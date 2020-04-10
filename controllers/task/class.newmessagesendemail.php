<?php

Class Controller_Task_NewMessageSendEmail Extends Controller_Task_Base 
{
	
	public function indexAction()
	{
		$uid = (int)$_POST['uid'];
		$mtid = (int)$_POST['mtid'];
		$recipientList = unserialize($_POST['recipientList']);
		
		
		$fh = fopen('newmessagesendemail.txt', 'w');
		$param = var_export($_POST, true);
		fwrite($fh,$param);
		//fclose($fh);
		
		
		//check valid param
		if($uid == 0 || $mtid == 0 || count($recipientList) == 0)
			die('e1');
		
		$myUser = new Core_User($uid);
		$myMessageText = new Core_Backend_MessageText($mtid);
		
		//check valid object
		if($myUser->id == 0 || $myMessageText->id == 0)
			die('e2');
			
		//loop to get receiver info
		foreach($recipientList as $recipientId)
		{
			$myReceiver = new Core_User($recipientId);
			if($myReceiver->id > 0)
			{
				//chi goi mail toi nhung nguoi cach day 1 ngay chua vo website
				if($myReceiver->datelastaction < time() - $this->registry->setting['message']['emailSendTimecheck'])
				{
					$toname = $myReceiver->fullname;
					$toname = ucwords(Helper::codau2khongdau($toname));
					
					//trademark character will error when sending
					//so convert to htmlentity before sending
					$toname = htmlentities($toname);
					
					$recipientListEmail[$myReceiver->email] = $toname;
				}
				
				fwrite($fh, 'push feed');
				/////////////////////
				//Push notification
				$feed = new WebSocketFeed();
				$feed->userid = $myReceiver->id;
				$feed->type = WebSocketFeed::EMITTYPE_PUSHNOTIFICATION;
				$feed->newmessage = $myReceiver->newmessage;
				$feed->newnotification = $myReceiver->newnotification;
				$feed->url = $myReceiver->getUserPath() . '/message/';
				$feed->icon = $myUser->getSmallImage();
				$feed->meta = '<strong>'.$myUser->fullname .'</strong> ' . $this->registry->lang['default']['pushNewmessage'];
				WebSocket::push(array($feed));	
				//end push notification
			}
		}
		
		
		
		//tien hanh goi email toi nguoi nhan
		if(count($recipientListEmail) > 0)
		{
			$this->registry->smarty->assign(array('message' => $myMessageText->text,));
			$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'message/user.tpl');
			
			try
			{
				//send mail
				$sender=  new SendMail($this->registry,
										'',
										'',
										str_replace('###VALUE###', ucwords(Helper::codau2khongdau($myUser->fullname)), '###VALUE### gởi cho bạn một tin nhắn.'),
										$mailContents,
										$this->registry->setting['mail']['fromEmail'],
										$this->registry->setting['mail']['fromName']
										);
				$sender->toArray = $recipientListEmail;
				
				if($sender->Send())
				{
					//echo 'sent ok';
				}
				else
				{
					//echo 'not sent';
				}
			}
			catch (Exception $e) 
			{
			    //error while sending
			}
		}
	}
	
}

