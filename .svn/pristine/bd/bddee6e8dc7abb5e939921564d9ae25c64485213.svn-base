<?php

Class Controller_Profile_Recommendation Extends Controller_Profile_Base 
{
	
	public function indexAction() 
	{
	
		
		
	}
	
	/**
	* Load danh sach recommendation cho user o trang home
	* 
	* Gom co 2 phan: mutual book va mutual friend
	* 
	*/
	public function indexajaxAction()
	{
		$myMutualfriend = new Core_Backend_Mutualfriend();
		//load from cache to speedup
		$myMutualfriend = Core_Backend_Mutualfriend::cacheGet($this->registry->me->id);
		if($myMutualfriend->id > 0)
		{
			
			
			$limit = $this->registry->setting['recommendation']['panelrecord'];
			
			if($_GET['type'] == 'lite')
			{
				$currentFriendnumber = $this->registry->me->countFriend;
				//neu so luong ban qua nhieu thi hien thi it record recommend thoi ^^
				if( $currentFriendnumber > 20)	$limit--;
				if( $currentFriendnumber > 40)	$limit--;
				if( $currentFriendnumber > 60)	$limit--;
			}
			
			
			
			$mutualbooklist = array_slice($myMutualfriend->mutualbooklist, 0, $limit, true);
			$mutualfriendlist = array_slice($myMutualfriend->mutualfriendlist, 0, $limit, true);
			
			$count = 0;
			
			$showList = array();
			$mutualbookrecommend = array();
			foreach($myMutualfriend->mutualbooklist as $userid => $mutualcount)
			{
				if($count < $limit)
				{
					$mutualbookrecommend[$count] = array('actor' => Core_User::cacheGet($userid), 'samebook' => $mutualcount);
					
					if(isset($myMutualfriend->mutualfriendlist[$userid]))
					{
						$mutualbookrecommend[$count]['samefriend'] = $myMutualfriend->mutualfriendlist[$userid];
					}
					$showList[] = $userid;
					$count++;
				}
			}
			
			$count = 0;
			$mutualfriendrecommend = array();
			foreach($myMutualfriend->mutualfriendlist as $userid => $mutualcount)
			{
				if($count < $limit)
				{
					if(!in_array($userid, $showList))
					{
						$mutualfriendrecommend[$count] = array('actor' => Core_User::cacheGet($userid), 'samefriend' => $mutualcount);
						if(isset($myMutualfriend->mutualbooklist[$userid]))
						{
							$mutualfriendrecommend[$count]['samebook'] = $myMutualfriend->mutualbooklist[$userid];
						}
						$count++;
					}
				}
			}
			
			
			$this->registry->smarty->assign(array('mutualbookusers' => $mutualbookrecommend,
												'mutualfriendusers' => $mutualfriendrecommend,
												));
			
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl'); 
		}
	}
	
	/**
	* An 1 userid khoi danh sach de xuat ket ban
	* 
	*/
	public function hideajaxAction()
	{
		$success = 0;
		$message = '';
		
		$friendid = (int)$_GET['id'];
		
		
		$myMutualfriend = new Core_Backend_Mutualfriend($this->registry->me->id);
		$myFriend = new Core_User($friendid);
		if($myMutualfriend->id > 0 && $myFriend->id > 0)
		{
			//kiem tra neu friendid nam trong danh sach mutualbook hoac mutualfriend thi updatedate
			if(isset($myMutualfriend->mutualbooklist[$friendid]) || isset($myMutualfriend->mutualfriendlist[$friendid]))
			{
				$myMutualfriend->removeFromList($friendid, 'mutualbook');
				$myMutualfriend->removeFromList($friendid, 'mutualfriend');
				$myMutualfriend->addToList($friendid, 'mutualbookhide');
				$myMutualfriend->addToList($friendid, 'mutualfriendhide');
				if($myMutualfriend->updateData())
				{
					//delete cache
					Core_Backend_Mutualfriend::cacheDelete($this->registry->me->id);
					
					$success = 1;
					$message = $this->registry->lang['controller']['succHide'];
					
					//create stat
					$myMutualfriendHidelog = new Core_Backend_MutualfriendHidelog();
					$myMutualfriendHidelog->uid = $this->registry->me->id;
					$myMutualfriendHidelog->uid_friend = $friendid;
					$myMutualfriendHidelog->addData();
				}
				else
					$message = $this->registry->lang['controller']['errHide'];
			}
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	
	/**
	* Trang liet ke cac thanh vien nam trong danh sach co sach chung
	* 
	*/
	function mutualbookAction() 
	{
		
		$myMutualfriend = new Core_Backend_Mutualfriend($this->registry->me->id);
		
		$total = count($myMutualfriend->mutualbooklist);
		$mutualbookrecommend = array();
		if($total > 0)
		{
			foreach($myMutualfriend->mutualbooklist as $userid => $mutualcount)
			{
				$mutualbookrecommend[$count] = array('actor' => Core_User::cacheGet($userid), 'samebook' => $mutualcount);
				$count++;
			}
		}
		
		
		$this->registry->smarty->assign(array('mutualbooks' => $mutualbookrecommend,
											'total'			=> $total,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'mutualbook.tpl'); 
		
		
		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitleMutualbook'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeywordMutualbook'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescriptionMutualbook'];
		
				
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
		
	} 
	
	
	
	/**
	* Trang liet ke cac thanh vien nam trong danh sach co ban chung
	* 
	*/
	function mutualfriendAction() 
	{
		
		$myMutualfriend = new Core_Backend_Mutualfriend($this->registry->me->id);
		
		$total = count($myMutualfriend->mutualfriendlist);
		$mutualfriendrecommend = array();
		if($total > 0)
		{
			foreach($myMutualfriend->mutualfriendlist as $userid => $mutualcount)
			{
				$mutualfriendrecommend[$count] = array('actor' => Core_User::cacheGet($userid), 'samefriend' => $mutualcount);
				$count++;
			}
		}
		
		
		$this->registry->smarty->assign(array('mutualfriends' => $mutualfriendrecommend,
											'total'			=> $total,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'mutualfriend.tpl'); 
		
		
		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitleMutualfriend'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeywordMutualfriend'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescriptionMutualfriend'];
		
				
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
		
	} 
	
	/**
	* hien thi so ban be chung
	* 
	*/
	function samefriendajaxAction() 
	{
		$partnerid = (int)$_GET['id'];
		
		$myPartner = new Core_User();
		$myPartner = Core_User::cacheGet($partnerid);
		
		if($myPartner->id > 0)
		{
			$myPartnerMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($myPartner->id);
			
			$myMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($this->registry->me->id);
			
			$samefriends = array_intersect($myPartnerMutualfriendTask->friendlist, $myMutualfriendTask->friendlist);
			
			
			$total = count($samefriends);
			
			//limit the number of same
			$maxShow = 100;
			if($total > $maxShow)
			{
				$samefriends = array_slice($samefriends, 0, $maxShow);
				$total = $maxShow;
			}
			
			$userlist = array();
			if($total > 0)
			{
				foreach($samefriends as $userid)
				{
					$userlist[] = Core_User::cacheGet($userid);
				}
			}
			
			$this->registry->smarty->assign(array('userlist' => $userlist,
												'total'			=> $total,
												));
		}
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'samefriendajax.tpl'); 
	}
	
	
	
	/**
	* hien thi so sach chung
	* 
	*/
	function samebookajaxAction() 
	{
		$error = array();
		
		$partnerid = (int)$_GET['id'];
		
		$myPartner = new Core_User();
		$myPartner = Core_User::cacheGet($partnerid);
		
		if($myPartner->id > 0)
		{
			$myPartnerMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($myPartner->id);
			
			$myMutualfriendTask = Core_Backend_MutualfriendTask::cacheGet($this->registry->me->id);
			
			$samebooks = array_intersect($myPartnerMutualfriendTask->booklist, $myMutualfriendTask->booklist);
			
			
			$total = count($samebooks);
			
			//limit the number of same
			$maxShow = 100;
			if($total > $maxShow)
			{
				$samebooks = array_slice($samebooks, 0, $maxShow);
				$total = $maxShow;
			}
			
			$booklist = array();
			if($total > 0)
			{
				foreach($samebooks as $bookid)
				{
					$booklist[] = Core_Book::cacheGet($bookid);
				}
			}
			
			$this->registry->smarty->assign(array('booklist' => $booklist,
												'total'			=> $total,
												));
		}
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'samebookajax.tpl'); 
	}
	
	
	/**
	 * He thong suggest result cho chuc nang tag book, friend vao status
	 */
	public function mentionAction()
	{
		$keyword = Helper::plaintext(strip_tags($_GET['tag']));
		$items = array();
		
		//search FRIEND
		$formData = array('fuserid' => $this->registry->me->id, 'fkeywordFilter' => $keyword);
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelasaction', 'DESC', 5);
		for($i = 0; $i < count($friendList); $i++)
		{
			$items[] = array(
				'id' 		=> $friendList[$i]->uid_friend, 
				'name' 		=> $friendList[$i]->actor->fullname, 
				'namesearch' => Helper::codau2khongdau($friendList[$i]->actor->fullname),
				'avatar' 	=> $friendList[$i]->actor->getSmallImage(),
				'type'		=> 'u');
		}
		
		//echo $keyword;
		//search MOVIE
		$bookList = Core_Book::getBooks(array('fkeywordFilter' => $keyword), '', '', 3);
		for($i = 0; $i < count($bookList); $i++)
		{
			$items[] = array(
				'id' 		=> $bookList[$i]->id, 
				'name' 		=> trim($bookList[$i]->title), 
				'namesearch' => trim($bookList[$i]->titleSearch),
				'avatar' 	=> $bookList[$i]->getSmallImage(),
				'type'		=> 'b');
		}
		
		
		
		
		
		
		echo json_encode($items);
	}
	
}

