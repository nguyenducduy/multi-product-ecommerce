<?php

Class Controller_Site_TestEmail Extends Controller_Site_Base
{

	function indexAction()
	{
		$ipaddress = Helper::getIpAddress();
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$msg = $_GET['msg'];

		//limit to localhsot request only
		if(strlen($msg) > 10 && $ipaddress != 'localhost')
		{

			$receiverEmail = $_GET['toemail'];
			if($receiverEmail == '')
				$receiverEmail = 'tuanmaster2002@yahoo.com';

			$receiverName = $_GET['toname'];
			if($receiverName == '')
				$receiverName = 'Vo Duy Tuan';

			//////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////
			//send mail to admin
			$mailContents = 'IP address: ' . $ipaddress . ' <br /><br />User Agent: ' . $useragent . ' <br /><br /> Message : ' . $msg;
			$sender = new SendMail( $this->registry,
									$receiverEmail,
									$receiverName,
									'Your have new mail from Test Email',
									$mailContents,
									$this->registry->setting['mail']['fromEmail'],
									$this->registry->setting['mail']['fromName']
									);
			if($sender->Send())
				echo 'Sent successfully.';
			else
				echo 'Error sent.';
		}
		else
		{
			echo 'hi, error meets you.';
		}


	}


}



