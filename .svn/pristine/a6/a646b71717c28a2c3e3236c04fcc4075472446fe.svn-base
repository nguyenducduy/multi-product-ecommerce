<?php

Class Controller_Admin_Forgotpass Extends Controller_Admin_Base 
{
	
	function indexAction() 
	{
		if($_GET['sub'] == 'reset')
		{
			$this->resetAction();
			return;
		}
		
		$error = $warning = $formData = array();
		
		$redirectUrl = $_GET['redirect'];//base64 encoded
		
		if(isset($_POST['fsubmit']))
		{
			$formData = $_POST;
			
			if($this->submitValidate($formData, $error))
			{
				$myUser = Core_User::getByEmail($formData['femail']);	
				if($myUser->id > 0)
				{
					//xu ly de tai activatedcode cho viec change password
					$activatedCode = md5($myUser->id . $myUser->email . rand(1000,9999) . time() . viephpHashing::$secretString);
					$myUser->activatedcode = $activatedCode;
					if($myUser->updateData($error))
					{
						$_SESSION['forgotpassSpam'] = time();
						
						//tien hanh goi email
						//////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////
						//send mail to user
						$this->registry->smarty->assign(array(	'activatedCode' 	=> $activatedCode,
																'myUser'	=> $myUser,
														));
						$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'forgotpass/user.tpl');
						$sender2=  new SendMail($this->registry,
												$myUser->email,
												$myUser->fullname == '' ? $myUser->username : $myUser->fullname,
												$this->registry->lang['controller']['mailSubject'] . ' ' .$this->registry->conf['rooturl'],
												$mailContents,
												$this->registry->setting['mail']['fromEmail'],
												$this->registry->setting['mail']['fromName']
												);
						$sender2->Send();	
						
						$this->registry->smarty->assign(array('redirect' => $this->registry->conf['rooturl'] . 'login',
																'redirectMsg' => $this->registry->lang['controller']['succSubmitEmail'],
																));
						$this->registry->smarty->display('redirect.tpl');
						exit();
					}
				}
				else
				{
					$error = $this->registry->lang['controller']['errAccountInvalid'];
				}	
			}
				
						
		}
		
		$_SESSION['forgotpassToken'] = Helper::getSecurityToken();
		
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'error' 	=> $error,
													'warning' 	=> $warning,
													'redirectUrl' 	=> $redirectUrl
													));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		
	} 
	
	function resetAction()
	{
		$error = $warning = $formData = array();
		
		$myUser = Core_User::getByEmail($_GET['email']);	
		$activatedCode = $_GET['code'];
		
		if($myUser->activatedcode != $activatedCode)
		{
			$this->registry->smarty->assign(array('redirect' => $this->registry->conf['rooturl'] . 'forgotpass',
													'redirectMsg' => $this->registry->lang['controller']['errInvalidCode'],
													));
			$this->registry->smarty->display('redirect.tpl');
		}
		else
		{
			if(isset($_POST['fsubmit']))
			{
				//validate password
				if($_POST['fpassword'] != $_POST['fpassword2'])
				{
					$error = $this->registry->lang['controller']['errPassNotMatch'];
				}
				else
				{
					$myUser->newpass = $_POST['fpassword'];
					$myUser->activatedcode = '';
					if($myUser->updateData())
					{
						header('location: ' . $this->registry->conf['rooturl'] . 'login?from=forgotpass');
						exit();
					}
					else
					{
						$error = $this->registry->lang['controller']['errReset'];	
					}
				}	
			}
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
														'myUser' => $myUser,
														'error' 	=> $error,
														'warning' 	=> $warning,
														'redirectUrl' 	=> $redirectUrl
														));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reset.tpl'); 
			$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle' => $this->registry->lang['controller']['pageTitle'],
												'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
												'pageDescription' => $this->registry->lang['controller']['pageDescription'],
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     	
		}
		
		
		
		
	}
	
	
	protected function submitValidate($formData, &$error)
	{
		$pass = true;
		//check form token
		if($formData['ftoken'] != $_SESSION['forgotpassToken'])
		{
			$pass = false;
			$error[] = $this->registry->lang['default']['securityTokenInvalid'];	
		}
		
		//check spam
		$forgotpassExpire = 30;	//seconds
		if(isset($_SESSION['forgotpassSpam']) && time() - $_SESSION['forgotpassSpam'] < $forgotpassExpire)
		{
			$error[] = $this->registry->lang['controller']['errSpam'];
			$pass = false;
		}
		
		//check email length
		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] =  $this->registry->lang['controller']['errInvalidEmail'];   
			$pass = false;
		}
		
		return $pass;
	}
}

