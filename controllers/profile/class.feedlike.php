<?php

Class Controller_Profile_FeedLike Extends Controller_Profile_Base 
{
	function indexAction() 
	{
		$error = array();
		
		$feedId = (int)$_GET['id'];
		$myFeed = new Core_Backend_Feed($feedId);
		if($myFeed->id > 0)
		{
			//lay cac like user
			//tim tong so record
			$formData = array('ffeedid' => $feedId);
			$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
			$total = Core_Backend_FeedLike::getFeedLikes($formData, '', '', '', true, false);
			$totalPage = ceil($total/$this->registry->setting['feedlike']['recordPerPage']);
			$curPage = $page;
			$paginateUrl = $myFeed->actor->getUserPath().'/feedlike/' . $feedId . '/';
			
			$feedlikes = Core_Backend_FeedLike::getFeedLikes($formData, '', '', (($page - 1)*$this->registry->setting['feedlike']['recordPerPage']).','.$this->registry->setting['feedlike']['recordPerPage'], false, true);
			
			$this->registry->smarty->assign(array('feedlikes' => $feedlikes,
												'formData'		=> $formData,
												'paginateurl' 	=> $paginateUrl, 
												'paginatesuffix' 	=> $paginateSuffix, 
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage
												));
			
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errFeednotfound'];
		}
		
		$this->registry->smarty->assign(array(	'error' 	=> $error,
												));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 

		$this->registry->smarty->assign(array('contents' => $contents,
											));

		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl');
	}
	
	
	
	/**
	* Them 1 like cho feed
	* 
	*/
	function addajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		
		$feedId = (int)$_POST['feedid'];
		$myFeed = new Core_Backend_Feed($feedId);
		
		$formData['fid'] = $myFeed->id;
		
		
		//get the poster
		//boi vi neu feed like len page thi phai
		//quan tam den poster neu dang login la page creator
		$posterAsPage = 1;	//default
		$poster = $this->registry->me;
		
		
		if($myFeed->id > 0 && $myFeed->canLike())
		{
			if($this->addajaxValidator($formData, $error, $poster))
			{
				//create feed
				$myFeedLike = new Core_Backend_FeedLike();
				$myFeedLike->fid = $feedId;
				$myFeedLike->uid = $poster->id;
				$myFeedLike->actor = $this->registry->me;
				
				if($myFeedLike->addData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succAdd'];		
					
					$moreMessage = '<liketext>'.$this->registry->lang['controller']['succLiketext'].'</liketext>';
					
					$_SESSION['likeSpam'] = time();
					
					$mySpecifiedFeed = Core_Backend_Feed::factory($myFeed->type);
					$mySpecifiedFeed->getDefaultData($myFeed);
					
					//create notification cho nguoi chu cua feed
					//dieu kien: notify neu nguoi like khong phai la chu cua feed
					//va chu feed khong chon hide 
					$alreadyNotifiedId = array();
					if($myFeed->actor->id != $poster->id && !in_array($myFeed->actor->id, $myFeed->hidelist))
					{
						$myNotificationFeedLike = new Core_Backend_Notification_FeedLike();
						$myNotificationFeedLike->uid = $poster->id;
						$myNotificationFeedLike->uidreceive = $myFeed->actor->id;
						$myNotificationFeedLike->feedid = $myFeed->id;
						$myNotificationFeedLike->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedLike->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedLike->addData())
						{
							//increase notification count for receiver
							Core_User::notificationIncrease('notification', array($myNotificationFeedLike->uidreceive));
							$alreadyNotifiedId[] = $myNotificationFeedLike->uidreceive;
						}
					}
					
					//create notification cho nhung nguoi lien quan toi feed nay (userlist cua feed, tru nguoi viet comment nay)
					if(!in_array($poster->id, $alreadyNotifiedId))
					{
						$alreadyNotifiedId[] = $poster->id;	//trick here, dua ID cua user hien tai dang comment vao danh sach already de khong phai notifi tiep
					}
					
					//notification cho nhung nguoi co comment feed nay ma khong nam trong array $alreadynotified de send notification theo batch
					$notificationReceiverId = array_diff($myFeed->userlist, $alreadyNotifiedId, $myFeed->hidelist);
					if(count($notificationReceiverId) > 0)
					{
						$myNotificationFeedLikeCommentFollow = new Core_Backend_Notification_FeedLikeCommentFollow();
						$myNotificationFeedLikeCommentFollow->uid = $poster->id;
						$myNotificationFeedLikeCommentFollow->feedid = $myFeed->id;
						$myNotificationFeedLikeCommentFollow->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedLikeCommentFollow->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedLikeCommentFollow->addDataToMany($notificationReceiverId))
						{
							//increase notification count for receivers
							Core_User::notificationIncrease('notification', $notificationReceiverId);
						}
					}
					
					
					//notification cho nhung nguoi co like feed nay ma khong nam trong array $userlist(chua id cua owner va id cua commentor) de send notification theo batch
					$notificationReceiverId = array_diff($myFeed->likelist, $myFeed->userlist, $myFeed->hidelist);
					if(count($notificationReceiverId) > 0)
					{
						$myNotificationFeedLikeFollow = new Core_Backend_Notification_FeedLikeFollow();
						$myNotificationFeedLikeFollow->uid = $poster->id;
						$myNotificationFeedLikeFollow->feedid = $myFeed->id;
						$myNotificationFeedLikeFollow->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedLikeFollow->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedLikeFollow->addDataToMany($notificationReceiverId))
						{
							//increase notification count for receivers
							Core_User::notificationIncrease('notification', $notificationReceiverId);
						}
					}
					
					
					//update feed info
					//neu chua nam trong likelist
					//tuc la chua comment
					//thi them vao like list
					$myFeed->addToList($myFeedLike->uid, 'like');
					$myFeed->removeFromList($myFeedLike->uid, 'hide');
					$myFeed->numlike++;
					$myFeed->updateData();
					
					//update Date last action
					$poster->updateDateLastaction();	
					
					//clear cache
					Core_Backend_Feed::cacheDelete($myFeed->id);	
				}
				else
				{
					$success = 0;
					$message = $this->registry->lang['controller']['errAdd'];	
				}
			}
			else
			{
				$success = 0;
				$message = implode(', ', $error);
			}	
		}
		else
		{
			$success = 0;
			$message = $this->registry->lang['controller']['errFeednotfound'];
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}
	
	###########################################################3
	###########################################################3
	###########################################################3 

	
	
	protected function addajaxValidator($formData, &$error, $poster)
	{
		$pass = true;
		
		//kiem tra xem user nay da like feed nay chua
		$cnt = Core_Backend_FeedLike::getFeedLikes(array('fuserid' => $poster->id, 'ffeedid' => $formData['fid']), '','', '', true);
		if($cnt > 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errAlreadyLike'];
		}
		
		//check spam
		if(isset($_SESSION['likeSpam']) && $_SESSION['likeSpam'] + $this->registry->setting['feedlike']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}
		
		return $pass;
	}
}

