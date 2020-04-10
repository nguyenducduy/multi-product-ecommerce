<?php

Class Controller_Profile_FeedComment Extends Controller_Profile_Base 
{
	function indexAction() 
	{
	}
	
	/**
	* lay cac comment con thieu cua feed, dung cho  chuc nang view all comment trong trang feed
	* 
	*/
	function indexajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		
		$feedId = (int)$_POST['feedid'];
		$myFeed = new Core_Backend_Feed($feedId);
		$comments = array();
		
		if($myFeed->id > 0)
		{
			$recordPerPage = $this->registry->setting['feedcomment']['recordPerPage'];
			$start = (int)$_GET['start'];
			
			if($start < 3 || $start > $myFeed->numcomment)
			{
				$start = 3;
			}
			
						
			$limit = $start . ',' . $recordPerPage;
			
			//neu co load cac feedcomment khac thi se load tu vi tri $nextstart
			//vi da cong them khoang cach la $recordperpage
			$nextstart = $start + $recordPerPage;
			$remaincomment = $myFeed->numcomment - $nextstart;
			if($remaincomment <= 0)
			{
				$remaincomment = 0;
			}
			
			
			
			$comments = Core_Backend_FeedComment::getComments(array('ffeedid' => $feedId), '', 'DESC', $limit);
			
			//reverse boi vi cac comment lay ra theo thu tu giam dan
			$comments = array_reverse($comments);
			
			$this->registry->smarty->assign(array(	'comments' => $comments,
													'nextstart' => $nextstart,
													'remaincomment' => $remaincomment,
													'loadedcount' => count($comments) + $start,
													'myFeed' => $myFeed,
													));	
		}
		
		
		
		header ("content-type: text/xml");
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl'); 
	}
	
	/**
	* Them 1 comment cho feed
	* 
	*/
	function addajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		$formData['fmessage'] = trim($formData['fmessage']);
		
		$feedId = (int)$_POST['feedid'];
		$myFeed = new Core_Backend_Feed($feedId);
		
		
		if($myFeed->id > 0 && $myFeed->canComment())
		{
			if($this->addajaxValidator($formData, $error))
			{
				$poster = $this->registry->me;
				
				
				//create feed
				$myFeedComment = new Core_Backend_FeedComment();
				$myFeedComment->fid = $feedId;
				$myFeedComment->uid = $poster->id;
				$myFeedComment->text = htmlspecialchars($formData['fmessage']);
				$myFeedComment->actor = $poster;
				if($myFeedComment->addData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succAdd'];		
					
					$moreMessage = '<comment>';
					$moreMessage .= '<id>'.$myFeedComment->id.'</id>';
					$moreMessage .= '<text><![CDATA['.$myFeedComment->getText().']]></text>';
					$moreMessage .= '<datecreated>'.$myFeedComment->datecreated.'</datecreated>';
					$moreMessage .= '<poster>'.$poster->fullname.'</poster>';
					$moreMessage .= '<userurl>'.$poster->getUserPath().'</userurl>';
					$moreMessage .= '<avatar>'.$poster->getSmallImage().'</avatar>';
					$moreMessage .= '</comment>';
					
					$_SESSION['commentSpam'] = time();
					$_SESSION['commentPrevious'] = $formData['fmessage'];
					
					//update feed info
					$myFeed->addToList($myFeedComment->uid, 'user');
					$myFeed->removeFromList($myFeedComment->uid, 'hide');
					$myFeed->numcomment++;
					$myFeed->updateData();
					
					$mySpecifiedFeed = Core_Backend_Feed::factory($myFeed->type);
					$mySpecifiedFeed->getDefaultData($myFeed);
					
					//create notification cho nguoi chu cua feed
					//dieu kien: notify neu nguoi viet comment khong phai la chu cua feed
					$alreadyNotifiedId = array();
					if($myFeed->actor->id != $poster->id && !in_array($myFeed->actor->id, $myFeed->hidelist))
					{
						$myNotificationFeedComment = new Core_Backend_Notification_FeedComment();
						$myNotificationFeedComment->uid = $poster->id;
						$myNotificationFeedComment->uidreceive = $myFeed->actor->id;
						$myNotificationFeedComment->feedid = $myFeed->id;
						$myNotificationFeedComment->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedComment->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedComment->addData())
						{
							//increase notification count for receiver
							Core_User::notificationIncrease('notification', array($myNotificationFeedComment->uidreceive));
							$alreadyNotifiedId[] = $myNotificationFeedComment->uidreceive;
						}
					}
					
					//create notification cho nhung nguoi lien quan toi feed nay (userlist cua feed, tru nguoi viet comment nay)
					if(!in_array($poster->id, $alreadyNotifiedId))
					{
						$alreadyNotifiedId[] = $poster->id;	//trick here, dua ID cua user hien tai dang comment vao danh sach already de khong phai notifi tiep
					}
					
					
					//tim cac userid trong danh sach userlist cua feed ma khong nam trong array $alreadynotified de send notification theo batch
					$notificationReceiverId = array_diff($myFeed->userlist, $alreadyNotifiedId, $myFeed->hidelist);
					if(count($notificationReceiverId) > 0)
					{
						$myNotificationFeedCommentFollow = new Core_Backend_Notification_FeedCommentFollow();
						$myNotificationFeedCommentFollow->uid = $poster->id;
						$myNotificationFeedCommentFollow->feedid = $myFeed->id;
						$myNotificationFeedCommentFollow->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedCommentFollow->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedCommentFollow->addDataToMany($notificationReceiverId))
						{
							//increase notification count for receivers
							Core_User::notificationIncrease('notification', $notificationReceiverId);
						}
					}
					
					//notification cho nhung nguoi co like feed nay ma khong nam trong array $userlist(chua id cua owner va id cua commentor) de send notification theo batch
					$notificationReceiverId = array_diff($myFeed->likelist, $myFeed->userlist, $myFeed->hidelist);
					if(count($notificationReceiverId) > 0)
					{
						$myNotificationFeedCommentLikeFollow = new Core_Backend_Notification_FeedCommentLikeFollow();
						$myNotificationFeedCommentLikeFollow->uid = $poster->id;
						$myNotificationFeedCommentLikeFollow->feedid = $myFeed->id;
						$myNotificationFeedCommentLikeFollow->feedpath = $myFeed->getFeedPath();
						$myNotificationFeedCommentLikeFollow->summary = $mySpecifiedFeed->getSummary();
						if($myNotificationFeedCommentLikeFollow->addDataToMany($notificationReceiverId))
						{
							//increase notification count for receivers
							Core_User::notificationIncrease('notification', $notificationReceiverId);
						}
					}
					
					
					//////////////////////////////////////////
					//get Tagged user to send notification
					Helper::mentionParsing($formData['fmessage'], $entityList);
					foreach($entityList as $tagitem)
					{
						//Nguoi nhan duoc notification dang nay phai la nguoi chua duoc nhan cac notificaiton ke tren ^^
						if($tagitem['type'] == 'user' && 
							!in_array($tagitem['entity']->id, $myFeed->hidelist) && 
							!in_array($tagitem['entity']->id, $alreadyNotifiedId) && 
							!in_array($tagitem['entity']->id, $myFeed->userlist) && 
							!in_array($tagitem['entity']->id, $myFeed->likelist) 
							 )
						{
							$myNotificationMentionFeedComment = new Core_Backend_Notification_MentionFeedComment();
							$myNotificationMentionFeedComment->uid = $this->registry->me->id;
							$myNotificationMentionFeedComment->uidreceive = $tagitem['entity']->id;
							$myNotificationMentionFeedComment->feedid = $myFeed->id;
							$myNotificationMentionFeedComment->feedpath = $mySpecifiedFeed->getFeedPath();
							$myNotificationMentionFeedComment->summary = Helper::truncateperiod(Helper::mentionMetaRemove($formData['fmessage']), 40, '...', ' ');
							if($myNotificationMentionFeedComment->addData())
							{
								//increase notification count for receiver
								Core_User::notificationIncrease('notification', array($myNotificationMentionFeedComment->uidreceive));
							}
						}
					}
					
					
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
	
	/**
	* Remove feed comment
	* 
	*/
	function removeajaxAction()
	{
		//sleep(3);
		$commentid = (int)$_GET['commentid'];
		$myComment = new Core_Backend_FeedComment($commentid);
		$myFeed = new Core_Backend_Feed($myComment->fid);
		$success = 0;
		
		
		if($myFeed->id > 0 && $myComment->id > 0)
		{
			//get correct subclass to call canDelete()
			$mySpecificFeed = Core_Backend_Feed::factory($myFeed->type);
			$mySpecificFeed->getDefaultData($myFeed);
			
			//neu user co the delete feed thi user do la feed owner
			//chi co feed owner moi co the delete cac comment cua minh
			if($mySpecificFeed->canDelete($this->registry->me->id) || $myComment->canDelete($this->registry->me->id))
			{
				//delete comment
				if($myComment->delete())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succDelete'];
					
					//clear cache
					$myFeed->numcomment++;
					$myFeed->updateData();
					Core_Backend_Feed::cacheDelete($mySpecificFeed->id);
				}
				else
				{
					$message = $this->registry->lang['controller']['errDelete'];	
				}
			}
			else
			{
				$message = $this->registry->lang['controller']['errNotOwner'];
			}
		}
		else
		{
			$message = $this->registry->lang['controller']['errFeednotfound'];
		}
		
				
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	
	
	function editAction()
	{
		$feedcommentId = (int)$_GET['id'];
		$myFeedComment = new Core_Backend_FeedComment($feedcommentId, true);
		
		//kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
		$this->registry->smarty->assign(array('myFeedComment' => $myFeedComment,
												'commentmessage' => $myFeedComment->text,
											));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl'); 
		
		$this->registry->smarty->assign(array('contents' => $contents,
											));
		
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl'); 
		
	}
	
	/**
	* Update 1 feed comment
	* 
	*/
	function editajaxAction()
	{
		$success = 0;
		$message = '';
		
		if($this->registry->me->id < 0)
		{
			$message = $this->registry->lang['default']['loginRequired'];
		}
		else
		{
			$myFeedComment = new Core_Backend_FeedComment((int)$_GET['id']);
			
			// owner cua comment (kem theo thoi gian chua expire, trong setting feedcomment)
			if($myFeedComment->canEdit($this->registry->me->id))
			{
				$myFeedComment->text = htmlspecialchars(trim($_POST['fmessage']));
				if($myFeedComment->updateData())
				{
					$success = 1;
					$message = $this->registry->lang['controller']['succEdit'];
				}
				else
					$message = $this->registry->lang['controller']['errEdit'];
			}
			else
			{
				$message = $this->registry->lang['controller']['errNotOwner'];
			}
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	###########################################################3
	###########################################################3
	###########################################################3 

	
	
	protected function addajaxValidator($formData, &$error)
	{
		
		$pass = true;
		
			
		
		$strlen = mb_strlen($formData['fmessage'], 'utf-8');
		if($strlen < $this->registry->setting['feedcomment']['messageMinLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['feedcomment']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}
		
		if($strlen > $this->registry->setting['feedcomment']['messageMaxLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['feedcomment']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}
		
		if(strcmp($_SESSION['commentPrevious'], $formData['fmessage']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errDuplicate'];
			$pass = false;
		}
		
		//check spam
		if(isset($_SESSION['commentSpam']) && $_SESSION['commentSpam'] + $this->registry->setting['feedcomment']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}
		
		return $pass;
	}
}

