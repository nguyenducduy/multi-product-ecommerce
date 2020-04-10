<?php

Class Controller_Task_InitEmployee Extends Controller_Task_Base
{

	public function indexAction()
	{
		$uid = (int)$_POST['uid'];

		//check valid param
		if($uid == 0)
			die('e1');

		$myUser = new Core_User($uid);

		//check valid object
		if($myUser->id == 0)
			die('e2');

		//Lay tat ca member thuoc nhom developer
		$developers = Core_User::getUsers(array('fgroupidlist' => array(GROUPID_ADMIN, GROUPID_DEVELOPER)), '', '', '');

		for($i = 0; $i < count($developers); $i++)
		{
			$myNotificationSystemNotify = new Core_Backend_Notification_SystemNotify();
			$myNotificationSystemNotify->uid = 1;
			$myNotificationSystemNotify->uidreceive = $developers[$i]->id;
			$myNotificationSystemNotify->objectid = $myUser->id;
			$myNotificationSystemNotify->text = $this->getNotificationText($myUser);
			$myNotificationSystemNotify->url = $this->getNotificationUrl($myUser);
			if($myNotificationSystemNotify->addData())
			{
				//increase notification count for receiver
				Core_User::notificationIncrease('notification', array($myNotificationSystemNotify->uidreceive));
			}
		}

	}


	public function getNotificationText(Core_User $myUser)
	{
		$output = '';

		$output .= 'Yêu cầu thêm phòng ban, Mã nhân viên: <span class="label label-success">'.$myUser->getCode().'</span>. Mã BCNB <span class="label">'.$myUser->oauthUid.'</span>';

		return $output;
	}

	public function getNotificationUrl(Core_User $myUser)
	{
		$url = '';

		$url = $this->registry->conf['rooturl_erp'] . 'hrmdepartment?view=list';

		return $url;
	}

	public function sendemailfordeveloperAction()
	{
	    global $registry;
	    $uid = (int)$_POST['uid'];
	    $fullname = (string)$_POST['name'];

	    //$uid = (int)$_GET['uid'];
	    //$fullname = (string)$_GET['name'];

	    //echo $uid;

		//check valid param
		if($uid == 0)
			die('e1');

		$myUser = new Core_User($uid);

		//check valid object
		if($myUser->id == 0)
			die('e2');


	    //gui email cho developer phan quyen
        $mailContents = '<h1>Bạn vừa nhận được yêu cầu phân quyền cho nhân viên mới</h1><table><tr><td>Id : </td><td><b>a'.$uid.'</b></td></tr><tr><td>Name : </td><td><b>'.$fullname.'</b></td></tr></table>';
		$sender = new SendMail($registry,
									'vohoanglong07@gmail.com',
									'Vo Hoang Long',
									'Have new user in system',
									$mailContents,
									$registry->setting['mail']['fromEmail'],
									$registry->setting['mail']['fromName']
									);
         if($sender->Send())
            echo 'Sent successfully.';
		else
			echo 'Error sent.';
	}

}



