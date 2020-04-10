<?php

Class Controller_Profile_Status Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
	}
	
	/**
	* Them 1 status + attach link
	* 
	*/
	function addajaxAction()
	{
		$moreMessage = '';
		$error = array();
		$formData = $_POST;
		$formData['fmessage'] = htmlspecialchars(trim($formData['fmessage']));
		$formData['furl'] = htmlspecialchars(trim($formData['u']));
		$formData['ftitle'] = htmlspecialchars(trim($formData['t']));
		$formData['fdescription'] = htmlspecialchars(trim($formData['d']));
		$formData['fimage'] = htmlspecialchars(trim($formData['i']));
		
		//image start with http|https
		if(strpos($formData['fimage'], 'http') !== 0)
		{
			$formData['fimage'] = '';
		}
		
		if($this->addajaxValidator($formData, $error))
		{
			//get the poster
			$poster = $this->registry->me;

			//create feed
			$myFeedStatus = new Core_Backend_Feed_Status();
			$myFeedStatus->uid = $poster->id;
			$myFeedStatus->uidreceive = $this->registry->myUser->id;
			$myFeedStatus->message = $formData['fmessage'];
			$myFeedStatus->url = $formData['furl'];
			
			if(strlen($formData['furl']) > 0)
			{
				$myFeedStatus->title = $formData['ftitle'];
				$myFeedStatus->description = $formData['fdescription'];
				$myFeedStatus->image = $formData['fimage'];
			}
			$myFeedStatus->actor = $poster;
			$myFeedStatus->receiver = $this->registry->myUser;
			if($myFeedStatus->addData())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succAdd'];		
				
				$moreMessage = '<feed>';
				$moreMessage .= '<id>'.$myFeedStatus->id.'</id>';
				$moreMessage .= '<data><![CDATA['. $myFeedStatus->showDetail() . $myFeedStatus->showDetailMore() .']]></data>';
				$moreMessage .= '<userurl>'.$poster->getUserPath().'</userurl>';
				$moreMessage .= '<avatar>'.$poster->getSmallImage().'</avatar>';
				$moreMessage .= '</feed>';
				
				$_SESSION['statusSpam'] = time();
				$_SESSION['statuslinkPrevious'] = $formData['furl'];
				$_SESSION['statusPrevious'] = $formData['fmessage'];
				
				//create notification
				//dieu kien: notify neu nguoi tao status len tuong nha nguoi khac
				if($myFeedStatus->uid != $myFeedStatus->uidreceive)
				{
					$myNotificationStatusAdd = new Core_Backend_Notification_StatusAdd();
					$myNotificationStatusAdd->uid = $myFeedStatus->uid;
					$myNotificationStatusAdd->uidreceive = $myFeedStatus->uidreceive;
					$myNotificationStatusAdd->feedid = $myFeedStatus->id;
					$myNotificationStatusAdd->feedpath = $myFeedStatus->getFeedPath();
					if($myNotificationStatusAdd->addData())
					{
						//increase notification count for receiver
						Core_User::notificationIncrease('notification', array($myNotificationStatusAdd->uidreceive));
					}
				}
				
				//update Date last action
				$poster->updateDateLastaction();
				
				//increase notification counter for fanpage if write on fanpage
				if($this->registry->myUser->checkGroupname('group') || $this->registry->myUser->checkGroupname('department'))
				{
					//use task to reduce traffic
					$taskUrl = $this->registry->conf['rooturl'] . 'task/pagenotification';
					Helper::backgroundHttpPost($taskUrl, 'pageid=' . $this->registry->myUser->id.'&excludeid=' . $this->registry->me->id);
				}
				
				//////////////////////////////////////////
				//get Tagged user to send notification
				Helper::mentionParsing($formData['fmessage'], $entityList);
				foreach($entityList as $tagitem)
				{
					//Neu user duoc tag khong phai la nguoi nhan duoc notification thong bao co status thi ko can goi notification nay vi se bi double cho nguoi nay
					if($tagitem['type'] == 'user' && $tagitem['entity']->id != $myNotificationStatusAdd->uidreceive)
					{
						$myNotificationMentionStatusLink = new Core_Backend_Notification_MentionStatusLink();
						$myNotificationMentionStatusLink->uid = $this->registry->me->id;
						$myNotificationMentionStatusLink->uidreceive = $tagitem['entity']->id;
						$myNotificationMentionStatusLink->feedid = $myFeedStatus->id;
						$myNotificationMentionStatusLink->feedpath = $myFeedStatus->getFeedPath();
						$myNotificationMentionStatusLink->summary = $myFeedStatus->title . ' - ' . substr($myFeedStatus->url, 0, 35) . '..';
						if($myNotificationMentionStatusLink->addData())
						{
							//increase notification count for receiver
							Core_User::notificationIncrease('notification', array($myNotificationMentionStatusLink->uidreceive));
						}
					}
				}
				
				//clear cache
				Core_Backend_Feed::cacheDeleteHomeFeedIds($myFeedStatusAdd->uidreceive);
				Core_Backend_Feed::cacheDeleteUserFeedIds($myFeedStatusAdd->uidreceive);
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
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}
		
	
	protected function removeTaggedBookLine($message)
	{
		//remove first line (tagged book line)
		$lines = preg_split("/[\n\r]+/", trim($message), 2);

		//join the new string withou firstline
		$newmessage = '';
		for($i = 1; $i < count($lines); $i++)
		{
			$newmessage .= $lines[$i] . PHP_EOL;
		}
		
		return $newmessage;
	}
	
	###########################################################3
	###########################################################3
	###########################################################3 
	protected function addajaxValidator($formData, &$error)
	{
		$pass = true;
		
		$strlen = mb_strlen($formData['fmessage'], 'utf-8');
		if($strlen < $this->registry->setting['status']['messageMinLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['status']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}
		
		if($strlen > $this->registry->setting['status']['messageMaxLength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['status']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}
		
		if(strcmp($_SESSION['statusPrevious'], $formData['fmessage']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errDuplicate'];
			$pass = false;
		}
		
		//if select link
		if(strlen($formData['furl']) > 0)
		{
			//check link
			$urlInfo = parse_url($formData['furl']);
			if($urlInfo['scheme'] != 'http' && $urlInfo['scheme'] != 'https')
			{
				$error[] = $this->registry->lang['controller']['errLinkInvalid'];
				$pass = false;
			}

			if(strcmp($_SESSION['statuslinkPrevious'], $formData['furl']) == 0)
			{
				$error[] = $this->registry->lang['controller']['errDuplicate'];
				$pass = false;
			}

			//check title
			$strlen = mb_strlen($formData['ftitle'], 'utf-8');
			if($strlen < $this->registry->setting['status']['linkTitleMinLength'])
			{
				$error[] = str_replace('###VALUE###', $this->registry->setting['status']['linkTitleMinLength'], $this->registry->lang['controller']['errLinkTitleTooShort']);
				$pass = false;
			}

			if($strlen > $this->registry->setting['status']['linkTitleMaxLength'])
			{
				$error[] = str_replace('###VALUE###', $this->registry->setting['status']['linkTitleMaxLength'], $this->registry->lang['controller']['errLinkTitleTooLong']);
				$pass = false;
			}

			//check description
			$strlen = mb_strlen($formData['fdescription'], 'utf-8');
			if($strlen > $this->registry->setting['status']['linkDescriptionMaxLength'])
			{
				$error[] = str_replace('###VALUE###', $this->registry->setting['status']['linkDescriptionMaxLength'], $this->registry->lang['controller']['errLinkDescriptionTooLong']);
				$pass = false;
			}
		}
		//end check submit link
		
		
		//check spam
		if(isset($_SESSION['statusSpam']) && $_SESSION['statusSpam'] + $this->registry->setting['status']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}
		
		return $pass;
	}
	
	
}


