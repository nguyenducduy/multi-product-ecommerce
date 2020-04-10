<?php

Class Controller_Profile_Follow Extends Controller_Profile_Base 
{
	/**
	* Trang liet ke cac account ma user following
	* 
	*/
	function indexAction() 
	{
		$formData = array('fuserid' => $this->registry->myUser->id);
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
		
		//tim tong so record
		$total = Core_Backend_Friend::getFriends($formData, '', '', '', true);
		$totalPage = ceil($total/$this->registry->setting['friend']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->myUser->getUserPath().'/friend/';
		
		if($curPage != 1 && $curPage > $totalPage)
		{
			$this->notfound();
		}
		
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelastaction', 'DESC', (($page - 1)*$this->registry->setting['friend']['recordPerPage']).','.$this->registry->setting['friend']['recordPerPage']);
		
		//track page view
		if($this->registry->me->id != $this->registry->myUser->id && $this->registry->myUser->increaseView(Core_UserView::TYPE_FRIEND))
		{
			$myUserView = new Core_UserView();
			$myUserView->uid = $this->registry->me->id;
			$myUserView->uid_receiver = $this->registry->myUser->id;
			$myUserView->type = Core_UserView::TYPE_FRIEND;
			$myUserView->addData();
		}
		
		//kiem tra trang thai da ket ban chua trong danh sach friend cua nguoi khac
		$myFriendIds = array();
		if($this->registry->me->id != $this->registry->myUser->id)
		{
			$myFriendIds = Core_Backend_Friend::getFriendIds($this->registry->me->id);
		}
		
		
		$this->registry->smarty->assign(array('friendList' => $friendList,
											'formData'		=> $formData,
											'myFriendIds' => $myFriendIds,
											'paginateurl' 	=> $paginateUrl, 
											'paginatesuffix' 	=> $paginateSuffix, 
											'total'			=> $total,
											'totalPage' 	=> $totalPage,
											'curPage'		=> $curPage
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		
		
		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];
		
				
		if($curPage > 1)
		{
			$pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
			$pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
			$pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
		}
		
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
		
	} 
	
	
	/**
	* Them vao danh sach ban
	* 	
	*/
	function followtoggleajaxAction()
	{
		$success = 0;
		$message = '';
		$moremessage = '';
		
		$followingid = (int)$_GET['id'];
		
		$myPartner = new Core_User($followingid, true);
		
		//khong cho phep unfollow department
		if(!$myPartner->checkGroupname('department'))
		{
			
			if($myPartner->checkGroupname('group'))
				$isAlreadyFollowOrJoin = Core_UserEdge::isJoining($this->registry->me->id, $myPartner->id);
			else
				$isAlreadyFollowOrJoin = Core_UserEdge::isFollowing($this->registry->me->id, $myPartner->id);
			
			//Neu hien tai da follow thi xoa follow
			if($isAlreadyFollowOrJoin)
			{
				
				if($myPartner->checkGroupname('group'))
					$removeResult = Core_UserEdge::removeJoining($this->registry->me->id, $myPartner->id);
				else
					$removeResult = Core_UserEdge::removeFollowing($this->registry->me->id, $myPartner->id);
				
				//tien hanh xoa
				if($removeResult)
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succDelete'];
					
					if($myPartner->checkGroupname('group'))
						$moremessage = $this->registry->lang['default']['groupjoinBtn'];
					else
						$moremessage = $this->registry->lang['default']['followBtn'];

					//update stat of user
					$this->registry->me->updateCounting(array('following'));
					$myPartner->updateCounting(array('follower'));

					//update homefeedids
					Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
					Core_Backend_Feed::cacheDeleteHomeFeedIds($myPartner->id);

					//Core_Backend_Friend::cacheDeleteFriendIds($this->registry->me->id);
					//Core_Backend_Friend::cacheDeleteFriendIds($followingid);
				}
				else
				{
					$message = $this->registry->lang['controller']['errDelete'];
				}
			}
			else
			{
				//tien hanh them
				$myUserEdge = new Core_UserEdge();
				$myUserEdge->uidstart = $this->registry->me->id;
				$myUserEdge->uidend = $myPartner->id;
				
				if($myPartner->checkGroupname('group'))
					$myUserEdge->type = Core_UserEdge::TYPE_JOIN;
				else
					$myUserEdge->type = Core_UserEdge::TYPE_FOLLOW;
					
				if($myUserEdge->addData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succFollowingAdd'];
					
					if($myPartner->checkGroupname('group'))
						$moremessage = $this->registry->lang['default']['groupexitBtn'];
					else
						$moremessage = $this->registry->lang['default']['unfollowBtn'];
					
					//update stat of user
					$this->registry->me->updateCounting(array('following'));
					$myPartner->updateCounting(array('follower'));
					
					if($myPartner->checkGroupname('group'))
					{
						//create feed
						$myFeedGroupJoin = new Core_Backend_Feed_GroupJoin();
						$myFeedGroupJoin->uid = $this->registry->me->id;
						$myFeedGroupJoin->uidreceive = $followingid;
						$myFeedGroupJoin->addData();
					}
					else
					{
						//create feed
						$myFeedFollowAdd = new Core_Backend_Feed_FollowAdd();
						$myFeedFollowAdd->uid = $this->registry->me->id;
						$myFeedFollowAdd->uidreceive = $followingid;
						$myFeedFollowAdd->addData();
						
						//create notification cho nguoi da goi loi moi ket ban
						$myNotificationFriendRequestAccept = new Core_Backend_Notification_FriendRequestAccept();
						$myNotificationFriendRequestAccept->uid = $this->registry->me->id;
						$myNotificationFriendRequestAccept->uidreceive = $followingid;
						if($myNotificationFriendRequestAccept->addData())
						{
							//increase notification count for receiver
							Core_User::notificationIncrease('notification', array($myNotificationFriendRequestAccept->uidreceive));
						}
					}
					
					
					
					//update Date last action
					$this->registry->me->updateDateLastaction();	
					
					//update homefeedids
					Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
					Core_Backend_Feed::cacheDeleteHomeFeedIds($followingid);
					
					//update friendids cache
					//Core_Backend_Friend::cacheDeleteFriendIds($this->registry->me->id);
					//Core_Backend_Friend::cacheDeleteFriendIds($followingid);
				}
				else
				{
					$message = $this->registry->lang['controller']['errFollowingAdd'];
				}
			}
		}
		
				
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message><moremessage>'.$moremessage.'</moremessage></result>';
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
		
	
}


