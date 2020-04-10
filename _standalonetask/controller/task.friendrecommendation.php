<?php
	
	//prevent from direct call
	if(!defined('IN_TASK'))
		die();
		
	//so thanh vien toi da co the nam trong danh sach de xuat
	//neu size qua lon thi se lam nang database
	//tot nhat la co the de khong qua lon, boi vi job nay se tu chay lai sau 1, hoac vai ngay
	//thi se van dam bao luon co recommendation moi va du 30
	define('RECOMMEND_LIST_SIZE', 30);
		
	/**
	* Bien quan trong de tracking tinh trang da cap nhat, dang cap nhat hay dang bi loi do qua trinh tinh toan recommendation
	* 
	* Bien nay co the duoc set thong qua duong dan $_GET['revision'], hoac thong qua buoc 1 de lay tu POST
	* 
	* Mot so truong hop co the xay ra voi field revision trong table task
	* <1> MIN(revision) == MAX(revision) ==> Table chua process OR da process revision thanh cong
	* 	1.1> Neu $revision <= MAX(revision) : stop process
	* 	1.2> Neu $revision > MAX(revision) thi moi tien hanh xu ly, day la xu ly toan bo record
	* 
	* <2> MIN(revision) != MAX(revision) ==> Table chua 2 gia tri revision, co the la do qua trinh cap nhat truoc khong thanh cong, hoac co record moi chua duoc xu ly (do them U_ID) vao queue 
	* 	2.1> Neu $revision == MIN(revision): stop process
	*   2.2> Neu $revision == MAX(revision): chi xu ly cac record co col revision < $revision
	* 	2.3> Neu $revision > MAX(revision): tien hanh duyet toan bo table de cap nhat (giong voi truong hop 1.2)
	* 
	*/
	if(isset($_GET['revision']) && $_GET['revision'] > 0)
		$_SESSION['revision'] = (int)$_GET['revision'];
		
	if(isset($_POST['revision']) && $_POST['revision'] > 0)
		$_SESSION['revision'] = (int)$_POST['revision'];
		
	$revision = (int)$_SESSION['revision'];
	
	//get the min(revision) & max(revision)
	$sql = 'SELECT MIN(t_revision) FROM ' . TABLE_PREFIX . 'mutual_friend_task';
	$minRevision = (int)$db->query($sql)->fetchSingle();
	$sql = 'SELECT MAX(t_revision) FROM ' . TABLE_PREFIX . 'mutual_friend_task';
	$maxRevision = (int)$db->query($sql)->fetchSingle();
	
	//step by step 
	// step 1: check & update to FRIEND_RECOMMENDATION table from USER table
	// step 2: update all data for task table FRIEND_RECOMMENDATION_TASK to be process	//heavy task here, request more data
	// step 3: check & set the revision for resume(break on error before) or new process
	// step 4: start calculate and building recommendation list base on FRIEND_RECOMMENDATION_TASK table and update to main FRIEND_RECOMMENDATION table	// heavy task here, may be break
		
	$processOutput = '';
	switch($_GET['a'])
	{
		case 'step2': $processOutput .= insertUserAction(); break;
		case 'step3': $processOutput .= updateUserDataAction(); break;
		case 'step4': $processOutput .= findRecommenlistAction(); break;
	}
	
	//select total user of website
	$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user';
	$totalUser = $db->query($sql)->fetchSingle();
	
	//select already had recommendation data
	$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'mutual_friend';
	$totalUserAlready = $db->query($sql)->fetchSingle();
	
	//select already had process
	$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'mutual_friend_task';
	$totalUserTask = $db->query($sql)->fetchSingle();
	
	echo siteHeader();
	echo 'FRIEND RECOMMENDATION :: TOTAL USER ' . $totalUser . NL . NL . DASH . NL;
	echo 'Ready User: ' . $totalUserAlready . ' | Task User: ' . $totalUserTask . ' | Current Revision: ' . $revision . ' (Min: '.$minRevision.', Max: '.$maxRevision.')' . NL . DASH . NL;
	
	if($processOutput != '')
	{
		echo $processOutput . NL . DASH . NL;
	}
	
	//show step 1
	echo NL . NL . NL . NL;
	echo '<form method="post" action="?c=friendrecommendation">STEP 1: <input type="text" name="revision" size="6" value="'.($maxRevision + 1).'" /> <input type="submit" value="Set Current Revision" />(greater than '.$maxRevision.' will force update all users)</form>';
	echo 'STEP 2: <a href="?c=friendrecommendation&a=step2">Sync UID from FRIEND_RECOMMENDATION and FRIEND_RECOMMENDATION_TASK.</a>' . NL . NL;
	//show step 2
	echo 'STEP 3: <a href="?c=friendrecommendation&a=step3">Update Friend list,... for FRIEND_RECOMMENDATION_TASK</a> (slow)' . NL . NL;
	echo 'STEP 4: <a href="?c=friendrecommendation&a=step4">Find recommend friend list for OLD REVISION or t_isdone = 0</a> (super slow)' . NL . NL;
	
	
	echo siteFooter();
	
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	
	/**
	* Ham lay tat ca user tu table USER va cap nhat vao table RECOMMENDATION de tien hanh sync o buoc tiep theo
	* 
	*/
	function insertUserAction()
	{
		set_time_limit(1000);
		global $db;
		
		$sql = 'SELECT u_id FROM ' . TABLE_PREFIX . 'ac_user ';
		$stmt = $db->query($sql);
		$insertedRecommendation = 0;
		$insertedRecommendationTask = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			//insert into RECOMMENDATION table
			$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'mutual_friend(u_id) VALUE(?)';
			if($db->query($sql, array($row['u_id']))->rowCount() > 0)
			{
				$insertedRecommendation++;
			}
			
			$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'mutual_friend_task(u_id) VALUE(?)';
			if($db->query($sql, array($row['u_id']))->rowCount() > 0)
			{
				$insertedRecommendationTask++;
			}
		}
		
		$out .= 'PROCESSING.........'.NL.
			'............Insert ' . $insertedRecommendation . ' User(s) to FRIEND_RECOMMENDATION.' . NL .
			'............Insert ' . $insertedRecommendationTask . ' User(s) to FRIEND_RECOMMENDATION_TASK.';
		return $out;
	}
	
	/**
	* Cap nhat cac thong tin cua user
	* de chuan bi day du
	* cho buoc tiep theo la xu ly de tim ra
	* danh sach de xuat ket ban
	* 
	* Chi cap nhat cac record co revision < $revision
	* 
	*/
	function updateUserDataAction()
	{
		set_time_limit(1000);
		global $db, $revision;
		
		$sql = 'SELECT u_id FROM ' . TABLE_PREFIX . 'mutual_friend_task WHERE t_revision < ? ';
		$stmt = $db->query($sql, array($revision));
		$affected = 0;
		$total = 0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$total++;
			$uid = $row['u_id'];
			
			//tim friendlist cua 1 uid
			$sql = 'SELECT u_id_friend FROM ' . TABLE_PREFIX . 'friend WHERE u_id = ?';
			$friendlist = array();
			$stmt2 = $db->query($sql, array($uid));
			while($id = $stmt2->fetchColumn(0))
			{
				$friendlist[] = $id;
			}
			
			//tim friend request
			$sql = 'SELECT u_id_friend FROM ' . TABLE_PREFIX . 'friend_request WHERE u_id = ?';
			$friendrequestlist = array();
			$stmt2 = $db->query($sql, array($uid));
			while($id = $stmt2->fetchColumn(0))
			{
				$friendrequestlist[] = $id;
			}
			
			//tim friend request nhan duoc tu nguoi khac
			$sql = 'SELECT u_id FROM ' . TABLE_PREFIX . 'friend_request WHERE u_id_friend = ?';
			$stmt2 = $db->query($sql, array($uid));
			while($id = $stmt2->fetchColumn(0))
			{
				$friendrequestlist[] = $id;
			}
			
			
			//tim hide list
			$sql = 'SELECT fr_hide_mutualfriend FROM ' . TABLE_PREFIX . 'mutual_friend WHERE u_id = ?';
			$stmt2 = $db->query($sql, array($uid));
			if($stmt2)
			{
				$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				$hidelistMutualfriend = $row2['fr_hide_mutualfriend'];
			}
			
			////////////////////////////////////////
			// UPDATE DATA FOR TASK
			$sql = 'UPDATE ' . TABLE_PREFIX . 'mutual_friend_task
					SET u_id_friendlist = ?,
						u_id_friendrequestlist = ?,
						u_id_hidelist_mutualfriend = ?,
						t_revision = ?,
						t_isdone = 0
					 WHERE u_id = ?';
			$stmt2 = $db->query($sql, array(implode(',', $friendlist), implode(',', $friendrequestlist), $hidelistMutualfriend, $revision, $uid));
			if($stmt2->rowCount() > 0)
			{
				$affected++;
			}
			
			unset($friendlist);
			unset($friendrequestlist);
			unset($hidelistMutualfriend);
			unset($stmt2);
		}
		$out .= 'PROCESSING.........'.NL.
			'............Update ' . $affected . '/'.$total. ' Record(s) based on OLD REVISION and CURRENT REVISION.';
		return $out;
	}
	
	/**
	* Ham tien hanh tim danh sach de nghi ket ban
	* cho cac record (uid) chua cap nhat (t_isdone = 0)
	* 
	* t_isdone se giup resume neu qua trinh cap nhat truoc do bi stop dot xuat
	* do do se co 1 so record co t_isdone = 1 va 1 so co t_isdone =0
	* 
	*/
	function findRecommenlistAction()
	{
		include('../classes/class.sizepriorityqueue.php');
		
		set_time_limit(2000);
		global $db, $revision;
		$out = '';
		
		$updateRecommend = 0;
		
		//SELECT ALL USER AND SAVE TO RAM TO PROCESS FOLLOW
		//chi load cac user co friendlist
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'mutual_friend_task WHERE u_id_friendlist <> "" ';
		$stmt = $db->query($sql, array($myId));
		$partners = array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$partners[] = $row;
		}
		
		
		///////////////////////////////////////////////////
		// loop through each partner
		for($i = 0, $cnt = count($partners); $i < $cnt; $i++ )
		{
			//chi xu ly neu chua done
			if($partners[$i]['t_isdone'] == 0 && $partners[$i]['b_id_list'] != '')
			{
				//echo '<hr />Process UID: ' . $partners[$i]['u_id'] . '<br />';
				$myId = $partners[$i]['u_id'];
				$myFriendList = explode(',', $partners[$i]['u_id_friendlist']);
				$myFriendRequestList = explode(',', $partners[$i]['u_id_friendrequestlist']);
				$myHideListMutualfriend = explode(',', $partners[$i]['u_id_hidelist_mutualfriend']);
				
				
				///////////////////////////////////////////////////////////////////////////////////////
				///////////////////////////////////////////////////////////////////////////////////////
				///////////////////////////////////////////////////////////////////////////////////////
				//
				//		TIM DE XUAT KET BAN DUA VAO BAN BE CHUNG
				//
				///////////////////////////////////////////////////////////////////////////////////////
				//tien hanh loop tat ca user (co ban be ^^) khac cung table de tim ban chung
				//va dua vao hang doi uu tien de tim ra danh sach userid co 
				//so luong ban be chung lon nhat
				$mutualFriendList = array();
				$myFriendPriorityQueue = new SizePriorityQueue(RECOMMEND_LIST_SIZE);
				for($j = 0; $j < $cnt; $j++)
				{
					$partnerId = $partners[$j]['u_id'];
					//chi compare voi cac user khac ma thoi
					if($partnerId != $myId)
					{
						//chi tiep tuc xu ly neu user nay khong nam trong friendlist, friendrequestlist hoac hidelist
						if(!in_array($partnerId, $myFriendList) && !in_array($partnerId, $myFriendRequestList) && !in_array($partnerId, $myHideListMutualfriend))
						{
							$partnerFriendList = explode(',', $partners[$j]['u_id_friendlist']);
							
							$mutualFriendList[$partnerId] = array_intersect($myFriendList, $partnerFriendList);
							//add to queue
							if(count($mutualFriendList[$partnerId]) > 0)
								$myFriendPriorityQueue->insert($partnerId, count($mutualFriendList[$partnerId]));
						}
					}
				}
				
				//da co danh sach ban be co sach chung xep tu nhieu toi it ^^
				// qua de roi, tiep hanh update thoi
				$recommendListMutualfriend = $myFriendPriorityQueue->getAssocData();
				if(count($recommendListMutualfriend) > 0)
				{
					
					
					$recommendListMutualfriendString = '';
					if(count($recommendListMutualfriend) > 0)
					{
						$rgroup = array();
						for($k = 0; $k < count($recommendListMutualfriend); $k++)
						{
							$rgroup[] = $recommendListMutualfriend[$k][0].':'.$recommendListMutualfriend[$k][1];
						}
						$recommendListMutualfriendString = implode(';', $rgroup);
					}
					
					
					$sql = 'UPDATE ' . TABLE_PREFIX . 'mutual_friend
							SET fr_list_mutualfriend = ?
							WHERE u_id = ?';
					if($db->query($sql, array($recommendListMutualfriendString, $myId))->rowCount())
					{
						$updateRecommend++;
					}	
				}
				
				
				//set is done	
				$sql = 'UPDATE ' . TABLE_PREFIX . 'mutual_friend_task
						SET t_isdone = 1
						WHERE u_id = ?';
				$db->query($sql, array($myId));
				
				unset($myFriendList);
				unset($myFriendRequestList);
				unset($myHideListMutualfriend);
				unset($myFriendPriorityQueue);
				unset($rgroup);
				unset($mutualFriendList);
				unset($recommendList);
			}
				
		}
		
		$out .= 'PROCESSING.........'.NL.
			'............Update ' . $updateRecommend . ' User(s) has new recommendation list.';
		
		return $out;
	}