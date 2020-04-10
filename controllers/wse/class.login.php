<?php

Class Controller_Wse_Login Extends Controller_Wse_Base
{
    
    function indexAction()
    {
		$formData = $_POST;
		
		////////////////////
		// Init login info
		$success = false;
		$message = '';
		$mobilesessionid = '';
		
		///////////////////////////////
		// begin authentication check
		$myUser = Core_User::getByEmail($formData['email']);
		if($myUser->id > 0 && $myUser->password == viephpHashing::hash($formData['password']))
		{
			$success = true;
			$message = $this->registry->lang['controller']['succLogin'];
			$mobilesessionid = $this->loginSuccess($myUser, $formData['d']);
			
		}
		else
		{
			$message = $this->registry->lang['controller']['errLogin'];
		}
		
		///////////////
		// output
		$this->jsonGeneralOutput($success, $message, $mobilesessionid, $myUser->id,false,true);
    }
}

