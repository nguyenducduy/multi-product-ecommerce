<?php

Class Controller_Task_FriendRequestSendEmail Extends Controller_Task_Base 
{
	
	public function indexAction()
	{
		$uid = (int)$_POST['uid'];
		$uid_friend = (int)$_POST['uid_friend'];
		
		
		
		/*
		$fh = fopen('test.txt', 'w');
		$param = var_export($_POST, true);
		fwrite($fh,$param);
		fclose($fh);
		*/
		
		//check valid param
		if($uid == 0 || $uid_friend == 0)
			die('e1');
		
		$myUser = new Core_User($uid);
		$myUserFriend = new Core_User($uid_friend);
		
		//check valid object
		if($myUser->id == 0 || $myUserFriend->id == 0)
			die('e2');
			
		//khong can goi email vi co thoi han chua het, kha nang nay user se online la cao 
		//hoac neu user da unscribe nhan email
		//if($myUserFriend->datelastaction >= time() - $this->registry->setting['mail']['sendTimecheck'] || Core_Backend_NewsletterUnscriber::isUnscribe($myUserFriend->email) == true)
		if(Core_Backend_NewsletterUnscriber::isUnscribe($myUserFriend->email) == true)
			die('e3');
		
		$this->registry->smarty->assign(array('mailuser' => $myUser, 'mailuser2' => $myUserFriend));
		$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'friend/request.tpl');
		
		
		//tien hanh send email
		//send mail
		$sender =  new SendMail($this->registry,
								'',
								'',
								str_replace('###VALUE###', $myUser->fullname, $this->registry->lang['controller']['subjectAdd']),
								$mailContents,
								$this->registry->setting['mail']['fromEmail'],
								$this->registry->setting['mail']['fromName']
								);
		$sender->toArray = array($myUserFriend->email => Helper::refineEmailSendername($myUserFriend->fullname));
		
		
		if($sender->Send())
		{
			//echo 'sent ok';
		}
		else
		{
			//echo 'not sent';
		}
		
		
		/////////////////////
		//Push notification
		$feed = new WebSocketFeed();
		$feed->userid = $myUserFriend->id;
		$feed->type = WebSocketFeed::TYPE_FRIENDREQUEST;
		$feed->newfriendrequest = $myUserFriend->newfriendrequest;
		$feed->newmessage = $myUserFriend->newmessage;
		$feed->newnotification = $myUserFriend->newnotification;
		$feed->url = $myUserFriend->getUserPath() . '/friend/request';
		$feed->icon = $myUser->getSmallImage();	//icon of sender, not receiver ^^
		$feed->meta = '<strong>'.$myUser->fullname .'</strong> ' . $this->registry->lang['default']['pushFriendrequest'];
		WebSocket::push(array($feed));
	}
	
}

