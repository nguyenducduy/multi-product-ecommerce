<?php

Class Core_Feed extends Core_Object
{
	const TYPE_STATUS = 30;
	const TYPE_PROFILE_EDIT = 35;
	const TYPE_FOLLOW_ADD = 45;
	const TYPE_GROUP_JOIN = 46;
	const TYPE_BLOG_ADD = 50;
	const TYPE_BLOGCOMMENT_ADD = 51;
	
	const MOBILE_IOS = 1;
	const MOBILE_ANDROID = 3;
	const MOBILE_WINDOWSPHONE = 5;
	const MOBILE_UNKNOWN = 1000;
	
	public $uid = 0;
	public $uidreceive = 0;
	public $id = 0;
	public $type = 0;
	public $data = null;
	public $userlist = array();	//danh sach ID cac user tham gia vao feed nay (ex: comment)
	public $likelist = array(); //danh sach ID cac user like feed nay
	public $hidelist = array(); //danh sach ID cac user khong muon nhan thong bao tu feed nay neu co like hay comment moi
	public $numcomment = 0;		//so comment ma feed nay co
	public $numlike = 0;		//so like ma feed nay co
	public $datecreated = 0;
	public $dateupdated = 0;
	public $activeActor = null;	//active actor la 1 pointer dac biet, co the co luc tro toi $actor, co luc thi $receiver. Activeactor la userinfo se show avatar tren feed. Mac dinh la $actor. Neu cac class khac muon co xu ly them thi co the override method getActiveActor() de kiem tra va thay doi
	public $actor = null;
	public $receiver = null;
	public $show = 1;	//de kiem tra feed nay co show khong, dung cho wa trinh compact feed
	public $compact = 0; //kiem tra feed nay co o dang compact khong
	
	
	public function __construct($id = 0)
	{
		parent::__construct($id);                
		
		if($id > 0)
			$this->getData($id);
			
	}
	
	
	public function updateActiveActor()
	{
		//$this->activeActor = $this->actor;
	}
	
	public function addData()
	{
		$this->datecreated = $this->dateupdated = time();
		$this->desktopversionUrl();
		
		if($this->uidreceive == 0)
		{
			$this->uidreceive = $this->uid;
		}
		
		//nguoi dau tien nhan thong bao (neu co) cung chinh la nguoi tao ra feed nay
		$this->userlist[] = $this->uid;
		
		//intercept the data here
		$myMobileDetect = new MobileDetect();
		if($myMobileDetect->isMobile())
		{
			if($myMobileDetect->isAndroidOS())
				$this->data['m'] = self::MOBILE_ANDROID;
			elseif($myMobileDetect->isiOS())
				$this->data['m'] = self::MOBILE_IOS;
			elseif($myMobileDetect->isWindowsPhoneOS())
				$this->data['m'] = self::MOBILE_WINDOWSPHONE;
			else
				$this->data['m'] = self::MOBILE_UNKNOWN;
		}
		
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'feed(
					u_id,
					u_id_receive,
					f_type,
					f_serialized_data,
					f_userlist,
					f_likelist,
					f_numcomment,
					f_numlike,
					f_datecreated,
					f_dateupdated
					)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';  
				
		$rowCount = $this->db->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uidreceive,
		    	(int)$this->type,
		    	(string)serialize($this->data),
		    	implode(',', $this->userlist),
		    	'',
		    	(int)$this->numcomment,
		    	(int)$this->numlike,
		    	(int)$this->datecreated,
		    	(int)$this->dateupdated
			))->rowCount();
			
		$this->id = $this->db->lastInsertId();
		
		return $this->id;
	}
	
	
	/**
	* 
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'feed
        		WHERE f_id =  ? ';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();
		
		if($rowCount > 0)
		{
			//remove feedcomment
			Core_FeedComment::deleteFromFeed($this->id);
			
			//remove feedlike
			Core_FeedLike::deleteFromFeed($this->id);
		}
		
		return $rowCount;
	}
	
	public function updateData()
	{
		$this->dateupdated = time();
		
		$sql = 'UPDATE ' . TABLE_PREFIX . 'feed
				SET f_serialized_data = ?,
					f_userlist = ?,
					f_likelist = ?,
					f_hidelist = ?,
					f_numcomment = ?,
					f_numlike = ?,
					f_dateupdated = ?
        		WHERE f_id =  ? ';
		$rowCount = $this->db->query($sql, array( 
			(string)serialize($this->data),
			implode(',', $this->userlist) , 
			implode(',', $this->likelist), 
			implode(',', $this->hidelist) , 
			(int)$this->numcomment, 
			(int)$this->numlike, 
			$this->dateupdated,
			$this->id))->rowCount();
		
		return $rowCount;
	}
	
	private function getData($id)
	{
		$sql = 'SELECT f.*, u.*, 
					u2.u_id u_id_r, u2.u_screenname u_screenname_r, u2.u_fullname u_fullname_r, u2.u_avatar u_avatar_r, u2.u_groupid u_groupid_r,
					u2.u_count_following u_count_following_r, u2.u_count_follower u_count_follower_r
				FROM ' . TABLE_PREFIX . 'feed f
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON f.u_id = u.u_id
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u2 ON f.u_id_receive = u2.u_id
				WHERE f_id = ? ';
		$row = $this->db->query($sql, array((int)$id))->fetch();
		$this->uid = $row['u_id'];
		$this->uidreceive = $row['u_id_receive'];
		$this->id = $row['f_id'];
		$this->type = $row['f_type'];
		$this->data = unserialize($row['f_serialized_data']);
		$this->userlist = $this->refineArray(explode(',', $row['f_userlist']));
		$this->likelist = $this->refineArray(explode(',', $row['f_likelist']));
		$this->hidelist = $this->refineArray(explode(',', $row['f_hidelist']));
		$this->numcomment = $row['f_numcomment'];
		$this->numlike = $row['f_numlike'];
		$this->datecreated = $row['f_datecreated'];
		$this->dateupdated = $row['f_dateupdated'];
		$this->actor = new Core_User();
		$this->actor->initMainInfo($row);
		$this->receiver = new Core_User();
		$this->receiver->initMainInfo(array(
			'u_id' => $row['u_id_r'], 'u_screenname' => $row['u_screenname_r'], 'u_fullname' => $row['u_fullname_r'], 'u_avatar' => $row['u_avatar_r'], 'u_groupid' => $row['u_groupid_r'],
			'u_count_following' => $row['u_count_following_r'],
			'u_count_follower' => $row['u_count_follower_r'],
		));
		
		$this->updateActiveActor();
		$this->mobileversionUrl();
	}
	
	public static function getList($where, $order, $limit = '')
	{
		global $db;
		
		$outputList = array();
		$sql = 'SELECT f.*, u.*, u2.u_id u_id_r, u2.u_screenname u_screenname_r, u2.u_fullname u_fullname_r, u2.u_avatar u_avatar_r  
				FROM ' . TABLE_PREFIX . 'feed f
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON f.u_id = u.u_id
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u2 ON f.u_id_receive = u2.u_id';
		
		if($where != '')
			$sql .= ' WHERE ' . $where;
			
		if($order != '')
			$sql .= ' ORDER BY ' . $order;
				
		if($limit != '')
			$sql .= ' LIMIT ' . $limit;
				
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myFeed = Core_Feed::factory($row['f_type']);
			$myFeed->uid = $row['u_id'];
			$myFeed->uidreceive = $row['u_id_receive'];
			$myFeed->id = $row['f_id'];
			$myFeed->type = $row['f_type'];
			$myFeed->data = unserialize($row['f_serialized_data']);
			$myFeed->userlist = $myFeed->refineArray(explode(',', $row['f_userlist']));
			$myFeed->likelist = $myFeed->refineArray(explode(',', $row['f_likelist']));
			$myFeed->hidelist = $myFeed->refineArray(explode(',', $row['f_hidelist']));
			$myFeed->numcomment = $row['f_numcomment'];
			$myFeed->numlike = $row['f_numlike'];
			$myFeed->datecreated = $row['f_datecreated'];
			$myFeed->dateupdated = $row['f_dateupdated'];
			$myFeed->actor = new Core_User();
			$myFeed->actor->initMainInfo($row);
			$myFeed->receiver = new Core_User();
			$myFeed->receiver->initMainInfo(array('u_id' => $row['u_id_r'], 'u_screenname' => $row['u_screenname_r'], 'u_fullname' => $row['u_fullname_r'], 'u_avatar' => $row['u_avatar_r']));
			$myFeed->updateActiveActor();
			$myFeed->mobileversionUrl();
		
			$outputList[] = $myFeed;
		}
		
		
		return $outputList;
	}
	
	public static function getFeeds($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';
		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_id = '.(int)$formData['fid'].' ';
		
		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id = '.(int)$formData['fuserid'].') OR (f.u_id_receive = '.(int)$formData['fuserid'].') ';
		
		if(count($formData['fuseridlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id IN ('.implode(',', $formData['fuseridlist']).')) OR  (f.u_id_receive IN ('.implode(',', $formData['fuseridlist']).'))';
			
		//danh cho trang home cua user
		//ngoai viec load feed cua friend,
		// co the load cac feed cua user, nhung chi lay nhung feed co comment > 0
		if($formData['fishomefeeduserid'] > 0)
			$whereString .= ($whereString != '' ? ' OR ' : '') . '(f.u_id = '.(int)$formData['fishomefeeduserid'].' AND f.f_numcomment > 0) ';
		
		
		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_type = '.(int)$formData['ftype'].' ';

		$orderString = ' f.f_dateupdated DESC';		
				
		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}
	
	/**
	* Tra ve loai class tuong ung voi feed type
	* dung de load feed ra de hien thi
	* 
	*/
	public static function factory($type)
	{
		$myFeed = null;
		switch($type)
		{
			case self::TYPE_STATUS: $myFeed = new Core_Feed_Status(); break;
			case self::TYPE_PROFILE_EDIT: $myFeed = new Core_Feed_ProfileEdit(); break;
			case self::TYPE_FOLLOW_ADD: $myFeed = new Core_Feed_FollowAdd(); break;
			case self::TYPE_GROUP_JOIN: $myFeed = new Core_Feed_GroupJoin(); break;
			case self::TYPE_BLOG_ADD: $myFeed = new Core_Feed_BlogAdd(); break;
			case self::TYPE_BLOGCOMMENT_ADD: $myFeed = new Core_Feed_BlogCommentAdd(); break;
			default: $myFeed = new Core_Feed();
		}
		
		return $myFeed;	
	}
	
	
	/**
	* Hien thi noi dung feed ra ben ngoai
	* 
	*/
	public function showDetail()
	{
		
	}
	
	/**
	 * Call from mobile version in .tpl file
	 */
	public function showDetailMobile($display = false)
	{
		//default is call the main showdetail
		$this->showDetail($display);
	}
	
	public function checkcompact(Core_Feed $prevFeed)
	{
		return '';
	}
	/**
	* Hien thi ra ben ngoai phan icon, thoi gian va link reply
	* 
	* @param boolean $replyButtonIsScroll: neu TRUE, link reply khong phai toggle reply textarea ma la scroll to textarea (used in feed detail)
	* 
	*/
	public function showDetailMore($display = false, $showReplyLink = false)
	{
		global $registry;
		
		$GLOBALS['lastFeedType'] = $this->type;
		
		//check like link
		$likeLink = '';
		if($this->canLike() && !in_array($registry->me->id, $this->likelist))
		{
			$likeLink = '<span class="act_btn_text">&middot; </span><a title="'.$registry->lang['default']['feedLikeLabel'].'" class=" like_btn" href="javascript://" onclick="user_feedlikeadd('.$this->id.')"><img class="sp sp16 spfeedlike" src="'.$registry->currentTemplate.'images/blank.png"><span class="act_btn_text">'.$registry->lang['default']['feedLikeLabel'].'</span></a>';	
		}
		
		//check comment link
		$commentLink = '';
		if($this->canComment())
		{
			$commentLink = '<span class="act_btn_text">&middot; </span><a class=" comment_btn" href="javascript://" onclick="$(\'#act_entry_'.$this->id.' .act_reply_add\').show();$(\'#act_entry_'.$this->id.' .act_reply_add textarea\').focus();" title="'.$registry->lang['default']['feedCommentLinkLabel'].'"><img class="sp sp16 spfeedreply" src="'.$registry->currentTemplate.'images/blank.png"><span class="act_btn_text">'.$registry->lang['default']['feedCommentLinkLabel'].'</span></a>';
		}
		
		//check remove link
		$removeLink = '';
		if($this->canDelete($registry->me->id))
		{
			$removeLink = '<a class="remove_btn" href="javascript://" onclick="feedRemove('.$this->id.')">'.$registry->lang['default']['feedCommentRemoveLabel'].'</a>';	
		}
		
		//check edit link
		$editLink = '';
		if($this->canEdit($registry->me->id))
		{
			$editLink = '&middot; <a class="edit_btn" href="javascript://" onclick="feedEdit_popup('.$this->id.')">'.$registry->lang['default']['feedCommentEditLabel'].'</a>';	
		}
		
		
		$out = '<div class="more'.$moreClass. ($this->data['m'] > 0 ? ' moremobile' : '').' ">
								<span class="datetimewrapper"><span class="datetime relativetime">'.$this->datecreated.'</span></span>
								'.$likeLink.'
								'.$commentLink.'
								'.$editLink.'
								'.$removeLink.'
							</div>';
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	
	/**
	* Hien thi ra ben ngoai phan icon, thoi gian va link reply
	* 
	* @param boolean $replyButtonIsScroll: neu TRUE, link reply khong phai toggle reply textarea ma la scroll to textarea (used in feed detail)
	* 
	*/
	public function showDetailMoreMobile($display = false, $showReplyLink = false)
	{
		global $registry;
		
		$GLOBALS['lastFeedType'] = $this->type;
		
		//check like link
		$likeLink = '';
		if($this->canLike() && !in_array($registry->me->id, $this->likelist))
		{
			$likeLink = '<span class="act_btn_text">&middot; </span><a title="'.$registry->lang['default']['feedLikeLabel'].'" class=" like_btn" href="javascript://" onclick="user_feedlikeadd('.$this->id.')"><img class="sp sp16 spfeedlike" src="'.$registry->currentTemplate.'images/blank.png"><span class="act_btn_text">'.$registry->lang['default']['feedLikeLabel'].'</span></a>';	
		}
		
		//check comment link
		$commentLink = '';
		if($this->canComment())
		{
			$commentLink = '<span class="act_btn_text">&middot; </span><a class=" comment_btn" href="'.$this->getFeedPath().'"><img class="sp sp16 spfeedreply" src="'.$registry->currentTemplate.'images/blank.png"><span class="act_btn_text">'.$registry->lang['default']['feedCommentLinkLabel'].'</span></a>';
		}
		
		$out = '<div class="more'.$moreClass.'">
					<span class="morestats">
						<a href="'.$this->getFeedPath().'?rel=like"><img class="sp sp16 spfeedlike" src="'.$registry->currentTemplate.'images/blank.png" /><span>'.$this->numlike.'</span></a>
						<a href="'.$this->getFeedPath().'?rel=comment"><img class="sp sp16 spfeedreply" src="'.$registry->currentTemplate.'images/blank.png" /><span>'.$this->numcomment.'</span></a>
					</span>
								<span class="datetimewrapper"><span class="datetime relativetime">'.$this->datecreated.'</span></span>
								'.$likeLink.'
								'.$commentLink.'
							</div>';
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	/**
	* Hien thi box chua thong tin like cua feed
	* 
	*/
	public function showLike($display = false, $maxUserLink = 3)
	{
		global $registry;
		$out = '';
		
		if($this->numlike > 0)
		{
			//check xem user hien tai da like chua
			//de hien chu BAN
			$iLiked = false;
			$iLikeLink = '';
			if(in_array($registry->me->id, $this->likelist))
			{
				$iLiked = true;
				$iLikeLink = '<a href="'.$registry->me->getUserPath().'" title="">'.$registry->lang['default']['feedLikeYou'].'</a>';
			}
			
			if($iLiked)
				$maxUserLink = $maxUserLink - 1;

			$userLinkId = array();
			//lay cac userid moi them sau nay
			for($i = $this->numlike - 1; $i >= 0; $i--)
			{
				//con co the them user vao list
				if(count($userLinkId) < $maxUserLink && $this->likelist[$i] != $registry->me->id)
				{
					$userLinkId[] = $this->likelist[$i];
				}
				
			}	
			
			//sau khi da co duoc so user se show link
			//tien hanh lay thong tin cac user nay
			$otherNumberCount = $this->numlike - count($userLinkId);
			if($iLiked)
				$otherNumberCount--;	
			
			if($otherNumberCount > 0)
			{
				$otherLinkBox = $registry->lang['default']['feedLikeAnd'].' 
						<a href="javascript:void(0);" onclick="user_feedlikeall(\''.$this->actor->getUserPath() . '/feedlike/' . $this->id.'\', \''.$registry->lang['default']['feedLikeViewAll'].' '.$this->actor->fullname.'\')" title="'.$registry->lang['default']['feedLikeViewAllTitle'].'">' . $otherNumberCount . ' 
						' . $registry->lang['default']['feedLikeOther'] . '</a>';
			}
			else
				$otherLinkBox = '';
				
			if(!empty($userLinkId))
			{
				for($i = 0; $i < count($userLinkId); $i++)
				{
					if($i != 0 || $iLiked)
						$userlinkBox .= ', ';
						
					$myUser = Core_User::cacheGet($userLinkId[$i]);
					if($myUser->id > 0)
					{
						$userlinkBox .= '<a class="tipsy-hovercard-trigger" data-url="'.$registry->conf['rooturl'].'hovercard/'.$myUser->id.'" href="'.$myUser->getUserPath().'" title="'.$registry->lang['default']['gotoProfileOf'].' '.$myUser->fullname.'">'.$myUser->fullname.'</a>';
					}
				}
			}
			
			if($this->numlike > 1)
			{
				$adverb = $registry->lang['default']['feedLikeAlso'];
			}
			else
			{
				$adverb = $registry->lang['default']['feedLikeAlsoOnlyone'];
			}
			
			$out = '<div class="act_entry_likebox">
						'.$iLikeLink.$userlinkBox.'
						'.$otherLinkBox.'
						'. $adverb.'
						 ' . $registry->lang['default']['feedLikeString'] . '
					</div>';
		}
		
		if($display)
			echo $out;
		else
			return $out;	
	}
	
	
	
	/**
	* Kiem tra xem userid co the delete feed nay khong
	* 
	* Neu cac subclass co rule khac thi co the override method nay
	* @param mixed $userid
	*/
	public function canDelete($userid)
	{
		global $registry;
		
		
		return ($this->receiver->id == $userid);
	}
	
	/**
	* Kiem tra xem userid co the edit feed nay khong
	* 
	* Neu cac subclass co rule khac thi co the override method nay
	* @param mixed $userid
	*/
	public function canEdit($userid)
	{
		global $registry;
		
		
		return (($this->type == self::TYPE_STATUS) && 
				($this->receiver->id == $userid)
				);
	}
	
	/**
	* Kiem tra xem loai feed nay co the comment duoc khong
	* 
	*/
	public function canComment()
	{
		global $registry;
		
		$result = true;
		
		if($this->type == self::TYPE_FOLLOW_ADD || $this->type == self::TYPE_GROUP_JOIN || $this->type == self::TYPE_PROFILE_EDIT)
		{
			$result = false;
		}
		
		return $result;
	}
	
	/**
	* Kiem tra xem loai feed nay co the compact o reply khong, vi de tiet kiem khong gian cung nhu design
	* 
	*/
	public function canCommentMinimum()
	{
		global $registry;
		
		$result = false;
		$minimumArray = array(self::TYPE_STATUS);
		
		if(in_array($this->type, $minimumArray) || ($registry->me->id != $this->uid && $registry->me->id != $this->uidreceive))
		{
			$result = true;
		}
		
		return $result;
	}
	
	/**
	* Kiem tra xem loai feed nay co the like duoc khong
	* 
	*/
	public function canLike()
	{
		global $registry;
		
		$result = true;
		
		if($this->type == self::TYPE_FOLLOW_ADD || $this->type == self::TYPE_GROUP_JOIN || $this->type == self::TYPE_PROFILE_EDIT)
		{
			$result = false;
		}
		
		return $result;
	}
	
	public function getDefaultData(Core_Feed $feed)
	{
		$this->id = $feed->id;
		$this->uid = $feed->uid;
		$this->uidreceive = $feed->uidreceive;
		$this->data = $feed->data;
		$this->userlist = $feed->userlist;
		$this->likelist = $feed->likelist;
		$this->hidelist = $feed->hidelist;
		$this->numcomment = $feed->numcomment;
		$this->numlike = $feed->numlike;
		$this->actor = $feed->actor;
		$this->receiver = $feed->receiver;
		$this->datecreated = $feed->datecreated;
		$this->dateupdate = $feed->dateupdated;
	}
	
	public function getFeedPath()
	{
		if($this->receiver->id > 0)
			$activeuser = $this->receiver;
		else
			$activeuser = $this->actor;
			
		return $activeuser->getUserPath() . '/feed/detail/id/' . $this->id;
	}
	
	//loai bo cac phan tu co chuoi rong
	public function refineArray($arr)
	{
		$refinedArr = array();
		foreach($arr as $k => $v)
		{
			if(strlen(trim($v)) > 0)
				$refinedArr[] = $v;
		}
		return $refinedArr;
	}
	
	
	/**
	* ham dung de compact danh sach cac Feed truoc khi hien ra
	* Muc dich: gom nhom cac feed trung nhau lai va o dang ngan gon
	* thu gon cac feed do 1 user thuc hien qua nhieu
	* 
	* @param array $feedList
	* @return array $niceFeedList
	*/
	public static function compact($feedList)
	{
		$niceFeedList = array();
		//buoc 1: sap xep cac feed cua 1 user ma co thoi gian gan nhau (vd: 1 tieng) thi nam o sat nhau truoc khi compact cac record
		//gom cac feed cua 1 user lai thanh 1 nhom
		for($i = 0; $i < count($feedList); $i++)
		{
			$feedGroups[$feedList[$i]->uid][$feedList[$i]->type][] = array($feedList[$i]->datecreated, $feedList[$i]);
		}
		
		//sap xep cac feed cua 1 user theo type
		
		
		//sau khi gom nhom, tien hanh phan bo lai thoi gian va thong tin feed
		foreach($feedGroups as $groupbyuser)
		{
			foreach($groupbyuser as $groupbytype)
			{
				foreach($groupbytype as $feedinfo)
				{
					$niceFeedList[] = array($feedinfo[0], $feedinfo[1]);
				}
			}
			
		}
		
		
		//sort theo thoi gian de cat cac doan xa nhau ra
		//boi vi nhieu khi cung 1 hanh dong cua 1 user nhung lai co the nam o nhung khoang thoi gian xa nhau
		//se mat tinh realtime
		//update 18/9/2011: khong sort de split feed from sameuser nua
		//usort($niceFeedList, "feedcompactcompare");
		
		//get correct feed
		$finalFeedList = array();
		foreach($niceFeedList as $feedinfo)
		{
			$finalFeedList[] = $feedinfo[1];
		}
		
		//buoc 2: tien hanh so sanh va compact cac feed
		$compactFeedList = array();
		$compactFeedListIndex = 0;
		for($i = 0; $i < count($finalFeedList); $i++)
		{
			if($i == 0 || $finalFeedList[$i]->numcomment > 0 || $finalFeedList[$i]->numlike > 0)
			{
				$compactFeedList[$compactFeedListIndex++] = $finalFeedList[$i];
			}
			else
			{
				$compactCheckResult = $finalFeedList[$i]->checkCompact($compactFeedList[$compactFeedListIndex-1]);
				
				//neu ket qua tra ve 
				if($compactCheckResult != 'douple' && $compactCheckResult != 'merge')
				{
					$compactFeedList[$compactFeedListIndex++] = $finalFeedList[$i];
				}
			}
		}
		
		
		//return $feedList;
		return $compactFeedList;
	}
	
	
	public function removeFromList($userid, $listtype = 'all')
	{
		if(($listtype == 'all' || $listtype == 'user') && ($pos = array_search($userid, $this->userlist)) !== false)
			unset($this->userlist[$pos]);
		if(($listtype == 'all' || $listtype == 'like') && ($pos = array_search($userid, $this->likelist)) !== false)
			unset($this->likelist[$pos]);
		if(($listtype == 'all' || $listtype == 'hide') && ($pos = array_search($userid, $this->hidelist)) !== false)
			unset($this->hidelist[$pos]);
	}	
	
	/**
	* Them 1 user vao danh sach cu the
	* 
	* @param int $userid
	*/
	public function addToList($userid, $listtype)
	{
		switch($listtype)
		{
			case 'user': if(!in_array($userid, $this->userlist)) $this->userlist[] = $userid; break;
			case 'like': if(!in_array($userid, $this->likelist)) $this->likelist[] = $userid; break;
			case 'hide': if(!in_array($userid, $this->hidelist)) $this->hidelist[] = $userid; break;
		}
	}	
	
	/**
	* Kiem tra xem 1 user co follow de nhan thong bao tu feed nay khong
	* 
	* @param mixed $userid
	*/
	public function isFollow($userid)
	{
		return (($userid == $this->uid || $userid == $this->uidreceive || in_array($userid, $this->userlist) || in_array($userid, $this->likelist)) && !in_array($userid, $this->hidelist) && ($this->numcomment > 0 || $this->numlike > 0));
	}
	
	
	/**
	* Tra ve mot chuoi ngan gon mo ta hoat dong nay, de de gan them vao notification
	* Cac class con se ke thua va trien khai tuy theo noi dung feed
	*/
	public function getSummary()
	{
		return '';
	}	
	
	
	////////////////////////////////////////////////////////////////////
	//	USERHOME FEED ID CACHE
	
	public static function cacheCheckHomeFeedIds($userid)
	{
		$cacheKeystring = self::cacheBuildKeystringHomeFeedIds($userid);

		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		if(!empty($row))
		{
			return $row;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	* Lay danh sach cac HOME FEED ID cua user tu he thong cache
	* 
	* EX: Luu 30 feedid, neu array thi ton 2110bytes, neu luu string thi cchi mat 292byte
	*/
	public static function cacheGetHomeFeedIds($userid, &$cacheSuccess = false, $forceStore = false, $formData = array(), $limit = 30)
	{
		global $db;
		$cacheKeystring = self::cacheBuildKeystringHomeFeedIds($userid);
		
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$homeFeedIdListString = $myCacher->get();
		
		//force to store new value
		if(!$homeFeedIdListString || isset($_GET['live']) || $forceStore)
		{
			$homeFeedIdList = array();
			
			$whereString = '';
			if(count($formData['fuseridlist']) > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id IN ('.implode(',', $formData['fuseridlist']).')) OR  (f.u_id_receive IN ('.implode(',', $formData['fuseridlist']).'))';
				
			//danh cho trang home cua user
			//ngoai viec load feed cua friend,
			// co the load cac feed cua user, nhung chi lay nhung feed co comment > 0
			$whereString .= ($whereString != '' ? ' OR ' : '') . '(f.u_id = '.(int)$userid.' AND f.f_numcomment > 0) ';
			
			$sql = 'SELECT f_id FROM ' . TABLE_PREFIX . 'feed f WHERE ' . $whereString . ' ORDER BY f_dateupdated DESC LIMIT ' . $limit;
			$stmt = $db->query($sql);
			while($row = $stmt->fetch())
				$homeFeedIdList[] = $row['f_id']; 
			
			$homeFeedIdListString = implode(',', $homeFeedIdList);	
			
			//store new value
			$cacheSuccess = self::cacheSetHomeFeedIds($userid, $homeFeedIdListString);
		}
		else
		{
			$homeFeedIdList = explode(',', $homeFeedIdListString);
		}
		
		return $homeFeedIdList;
	}
	
	/**
	* Lay danh sach cac HOME FEED ID cua user 
	* 
	* Gan giong voi he thong lay cachegethomefeedids, nhung khong su dung cache, de lay live data luon
	* vi it ai coi trang 2,3..dung cho cac trang khac 1
	*/
	public static function getHomeFeedIds($userid, $formData = array(), $limit = 30)
	{
		global $db;
		$homeFeedIdList = array();
			
		$whereString = '';
		if(count($formData['fuseridlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id IN ('.implode(',', $formData['fuseridlist']).')) OR  (f.u_id_receive IN ('.implode(',', $formData['fuseridlist']).'))';
			
		//danh cho trang home cua user
		//ngoai viec load feed cua friend,
		// co the load cac feed cua user, nhung chi lay nhung feed co comment > 0
		$whereString .= ($whereString != '' ? ' OR ' : '') . '(f.u_id = '.(int)$userid.' AND f.f_numcomment > 0) ';
		
		$sql = 'SELECT f_id FROM ' . TABLE_PREFIX . 'feed f WHERE ' . $whereString . ' ORDER BY f_dateupdated DESC LIMIT ' . $limit;
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
			$homeFeedIdList[] = $row['f_id']; 
		
		return $homeFeedIdList;
	}
	
	/**
	* Luu thong tin vao cache
	* 
	*/
	public static function cacheSetHomeFeedIds($userid, $value)
	{
		global $registry;
		
		$myCacher = new Cacher(self::cacheBuildKeystringHomeFeedIds($userid));
		return $myCacher->set($value, $registry->setting['apc']['shortDelay']);
	}
	
	/**
	* Xoa 1 key khoi cache
	* 
	* @param mixed $userid
	*/
	public static function cacheDeleteHomeFeedIds($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystringHomeFeedIds($userid));
		return $myCacher->clear();
	}
	
	/**
	* Ham tra ve key de cache
	* 
	* @param mixed $userid
	*/
	public static function cacheBuildKeystringHomeFeedIds($userid)
	{
		return 'homefeedids_'.$userid;
	}
	
	
	//	--end -- HOME FEED ID LIST CACHE
	////////////////////////////////////////////////////////////////////
	
	
	
	////////////////////////////////////////////////////////////////////
	//	USERINDEX FEED ID CACHE
	
	public static function cacheCheckUserFeedIds($userid)
	{

		$cacheKeystring = self::cacheBuildKeystringUserFeedIds($userid);
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		if(!empty($row))
		{
			return $row;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	* Lay danh sach cac HOME FEED ID cua user tu he thong cache
	*/
	public static function cacheGetUserFeedIds($userid, &$cacheSuccess = false, $forceStore = false, $formData = array(), $limit = 30)
	{
		global $db;
		$cacheKeystring = self::cacheBuildKeystringUserFeedIds($userid);
		
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$userFeedIdListString = $myCacher->get();
		//$userFeedIdListString = apc_fetch($cacheKeystring);
		
		//var_dump($row);
		
		//force to store new value
		if(!$userFeedIdListString || isset($_GET['live']) || $forceStore)
		{
			$userFeedIdList = array();
			
			$whereString = '';
			if($formData['fuserid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id = '.(int)$formData['fuserid'].') OR (f.u_id_receive = '.(int)$formData['fuserid'].') ';
			
			$sql = 'SELECT f_id FROM ' . TABLE_PREFIX . 'feed f WHERE ' . $whereString . ' ORDER BY f_dateupdated DESC LIMIT ' . $limit;
			$stmt = $db->query($sql);
			while($row = $stmt->fetch())
				$userFeedIdList[] = $row['f_id']; 
				
			$userFeedIdListString = implode(',', $userFeedIdList);
			//store new value
			$cacheSuccess = self::cacheSetUserFeedIds($userid, $userFeedIdListString);
		}
		else
		{
			$userFeedIdList = explode(',', $userFeedIdListString);
		}
		
		return $userFeedIdList;
	}
	
	/**
	* Lay danh sach cac USER FEED ID cua user 
	* 
	* Gan giong voi he thong lay cachegetuserfeedids, nhung khong su dung cache, de lay live data luon
	* vi it ai coi trang 2,3..dung cho cac trang khac 1
	*/
	public static function getUserFeedIds($userid, $formData = array(), $limit = 30)
	{
		global $db;
		$userFeedIdList = array();
			
		$whereString = '';
		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(f.u_id = '.(int)$formData['fuserid'].') OR (f.u_id_receive = '.(int)$formData['fuserid'].') ';
			
			
		$sql = 'SELECT f_id FROM ' . TABLE_PREFIX . 'feed f WHERE ' . $whereString . ' ORDER BY f_dateupdated DESC LIMIT ' . $limit;
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
			$userFeedIdList[] = $row['f_id']; 
		
		return $userFeedIdList;
	}
	
	/**
	* Luu thong tin vao cache
	* 
	*/
	public static function cacheSetUserFeedIds($userid, $value)
	{
		global $registry;
		
		$myCacher = new Cacher(self::cacheBuildKeystringUserFeedIds($userid));
		return $myCacher->set($value, $registry->setting['apc']['shortDelay']);
	}
	
	/**
	* Xoa 1 key khoi cache
	* 
	* @param mixed $userid
	*/
	public static function cacheDeleteUserFeedIds($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystringUserFeedIds($userid));
		$myCacher->clear();
	}
	
	/**
	* Ham tra ve key de cache
	* 
	* @param mixed $userid
	*/
	public static function cacheBuildKeystringUserFeedIds($userid)
	{
		return 'userfeedids_'.$userid;
	}
	
	
	//	--end -- HOME FEED ID LIST CACHE
	////////////////////////////////////////////////////////////////////
	
	
	////////////////////////////////////////////////////////////////////
	//	CACHE FEED DETAIL
	/**
	* Kiem tra xem 1 feed da duoc cache chua
	* 
	* @param mixed $feedid
	*/
	public static function cacheCheck($feedid)
	{
		$cacheKeystring = self::cacheBuildKeystring($feedid);
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		if(!empty($row))
		{
			return $row;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	* Lay thong tin feed tu he thong cache
	* danh cho he thong ko phai truy xuat database vao table Feed (rat nang)
	* 
	* Neu luu dang array thi se ton apc memory
	* vd: 1 feed ban dau ton trung binh 3000bytes, sau khi giam cac field khong can thiet thi con 1867bytes, va sau khi normalize thanh string thi chi con 423 bytes
	* 
	*/
	public static function cacheGet($feedid, &$cacheSuccess = false, $forceStore = false)
	{
		global $db;
		
		$cacheKeystring = self::cacheBuildKeystring($feedid);
		
		$myFeed = new Core_Feed();
		
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();
		
		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			//select 21 fields
			$sql = 'SELECT 	f_id, f_type, f_serialized_data, 
							f_userlist, f_likelist, f_hidelist, f_numcomment, f_numlike, f_datecreated, 
							f.u_id, f.u_id_receive, u.u_screenname, u.u_fullname, u.u_avatar, u.u_groupid, u.u_region, u.u_gender,
							u2.u_id u_id_r, u2.u_screenname u_screenname_r, u2.u_fullname u_fullname_r, u2.u_avatar u_avatar_r, u2.u_groupid u_groupid_r  
					FROM ' . TABLE_PREFIX . 'feed f
					INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON f.u_id = u.u_id
					INNER JOIN ' . TABLE_PREFIX . 'ac_user u2 ON f.u_id_receive = u2.u_id
					WHERE f_id = ? ';
			$row = $db->query($sql, array($feedid))->fetch();
			if($row['f_id'] > 0)
			{
				$myFeed = Core_Feed::factory($row['f_type']);
				$myFeed->uid = $row['u_id'];
				$myFeed->uidreceive = $row['u_id_receive'];
				$myFeed->id = $row['f_id'];
				$myFeed->type = $row['f_type'];
				$myFeed->data = unserialize($row['f_serialized_data']);
				$myFeed->userlist = $myFeed->refineArray(explode(',', $row['f_userlist']));
				$myFeed->likelist = $myFeed->refineArray(explode(',', $row['f_likelist']));
				$myFeed->hidelist = $myFeed->refineArray(explode(',', $row['f_hidelist']));
				$myFeed->numcomment = $row['f_numcomment'];
				$myFeed->numlike = $row['f_numlike'];
				$myFeed->datecreated = $row['f_datecreated'];
				$myFeed->actor = new Core_User();
				$myFeed->actor->initMainInfo($row);
				$myFeed->receiver = new Core_User();
				$myFeed->receiver->initMainInfo(array('u_id' => $row['u_id_r'], 'u_screenname' => $row['u_screenname_r'], 'u_fullname' => $row['u_fullname_r'], 'u_avatar' => $row['u_avatar_r'], 'u_groupid' => $row['u_groupid_r']));
				$myFeed->updateActiveActor();
				
				//boi vi cac field text co the co dau ',' nen neu chi viec implode lai thi co the se bi error thi explode ra
				//bi bi dinh cac dau phay trong cac field text
				//do do, can replace cac dau , truoc khi luu vao cache
				$row['f_serialized_data'] = str_replace(',', '&#44;', $row['f_serialized_data']);
				$row['u_fullname'] = str_replace(',', '&#44;', $row['u_fullname']);
				$row['u_fullname_r'] = str_replace(',', '&#44;', $row['u_fullname_r']);
				$row['f_userlist'] = str_replace(',', ';', $row['f_userlist']);
				$row['f_likelist'] = str_replace(',', ';', $row['f_likelist']);
				$row['f_hidelist'] = str_replace(',', ';', $row['f_hideelist']);
				
				$myFeed->mobileversionUrl();
				//store new value
				$row = implode(',', $row);
				$cacheSuccess = self::cacheSet($feedid, $row);
			}
		}
		else
		{
			//split to get raw data
			$row = explode(',', $row);
			
			
			$myFeed = Core_Feed::factory($row[1]);
			
			$myFeed->uid = $row[9];
			$myFeed->uidreceive = $row[10];
			$myFeed->id = $row[0];
			$myFeed->type = $row[1];
			$myFeed->data = unserialize(str_replace('&#44;', ',', $row[2]));
			$myFeed->userlist = $myFeed->refineArray(explode(';', $row[3]));
			$myFeed->likelist = $myFeed->refineArray(explode(';', $row[4]));
			$myFeed->hidelist = $myFeed->refineArray(explode(';', $row[5]));
			$myFeed->numcomment = $row[6];
			$myFeed->numlike = $row[7];
			$myFeed->datecreated = $row[8];
			$myFeed->actor = new Core_User();
			$myFeed->actor->initMainInfo(array('u_id' => $row[9], 'u_screenname' => $row[11], 'u_fullname' => str_replace('&#44;', ',', $row[12]), 'u_avatar' => $row[13], 'u_groupid' => $row[14], 'u_region' => $row[15], 'u_gender' => $row[16]));
			$myFeed->receiver = new Core_User();
			$myFeed->receiver->initMainInfo(array('u_id' => $row[17], 'u_screenname' => $row[18], 'u_fullname' => str_replace('&#44;', ',', $row[19]), 'u_avatar' => $row[20], 'u_groupid' => $row[21]));
			$myFeed->updateActiveActor();
			$myFeed->mobileversionUrl();
			
		}
		
		return $myFeed;
	}
	
	
	/**
	* Luu thong tin vao cache
	* 
	*/
	public static function cacheSet($feedid, $value)
	{
		global $registry;
		
		$myCacher = new Cacher(self::cacheBuildKeystring($feedid));
		return $myCacher->set($value, $registry->setting['apc']['shortDelay']);
	}
	
	/**
	* Xoa 1 key khoi cache
	* 
	* @param mixed $feedid
	*/
	public static function cacheDelete($feedid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystring($feedid));
		return $myCacher->clear();
	}
	
	/**
	* Ham tra ve key de cache
	* 
	* @param mixed $feedid
	*/
	public static function cacheBuildKeystring($feedid)
	{
		return 'feed_'.$feedid;
	}
	//	end - CACHE FEED DETAIL
	////////////////////////////////////////////////////////////////////
	
	
	/**
	 * Convert URL in reader.vn for mobile version
	 */
	public function mobileversionUrl()
	{
		if(SUBDOMAIN == 'm')
		{
			foreach($this->data as $key => $value)
			{
				if(is_string($value))
					$this->data[$key] = str_replace('http://reader.vn', 'http://m.reader.vn', $value);
			}
		}
	}
	
	public function desktopversionUrl()
	{
		foreach($this->data as $key => $value)
		{
			if(is_string($value))
				$this->data[$key] = str_replace('http://m.reader.vn', 'http://reader.vn', $value);
		}
	}
}

/**
* Sap xep cac feed theo thu tu thoi gian sau khi da Group theo user
* Giup cho cac feed nam thoi gian realtime hon
* 
* Neu cac feed
*/
function feedcompactcompare($feedinfo1, $feedinfo2)
{
	$distance = $feedinfo1[0] - $feedinfo2[0];
	
	if($distance < 3600 * 3)
		return 1;
	elseif($distance > 3600 * 3 && $distance < 7200 * 3)
		return 0;
	else
		return -1;
}



