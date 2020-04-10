<?php

	Class Controller_Site_Contact Extends Controller_Site_Base
	{

		function indexAction()
		{
			$success               = $error = $formData = array();
			$formData['ffullname'] = $this->registry->me->fullname;
			$formData['femail']    = $this->registry->me->email;
			$formData['fphone']    = $this->registry->me->phone;

			//tien hanh luu thong tin lien he
			if (isset($_POST['fsubmit'])) {
				$formData = $_POST;
				if ($this->contactValidate($formData, $error)) {
					$myContact           = new Core_Contact();
					$myContact->fullname = strip_tags($formData['ffullname']);
					$myContact->email    = strip_tags($formData['femail']);
					$myContact->phone    = strip_tags($formData['fphone']);
					$myContact->message  = strip_tags($formData['fmessage']);


					if ($myContact->addData()) {

						$_SESSION['contactSpam'] = time();

						//////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////
						//send mail to admin
						$taskUrl = $this->registry->conf['rooturl'] . 'task/contact';
						//file_put_contents('uploads/backgroundjob.txt','uid=' . $uid.'&oid='.$idorder);
						Helper::backgroundHttpPost($taskUrl, 'mail=' . $this->registry->setting['mail']['toEmail'] . '&name=' . $myContact->fullname . '&mail=' . $myContact->email . '&mess=' . $myContact->message);
						$success[] = $this->registry->lang['controller']['succContact'];

						//clear form, keep email
						$formData['freason']  = '';
						$formData['fmessage'] = '';

					}
					else {
						$error[] = $this->registry->lang['controller']['errContact'];
					}
				}
			}
			$this->registry->smarty->assign(array('success' => $success,
												  'error' => $error,
												  'formData' => $formData,));

			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');
			$this->registry->smarty->assign(array('contents' => $contents,
												  'pageTitle' => $this->registry->lang['controller']['pageTitle'],
												  'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
												  'pageDescription' => $this->registry->lang['controller']['pageDescription'],));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index_popup.tpl');
		}

		protected function contactValidate($formData, &$error)
		{
			$pass = true;

			//check contact spam
			$contactExpire = 10; //seconds
			if (isset($_SESSION['contactSpam']) && (time() - $_SESSION['contactSpam']) < $contactExpire) {
				$error[] = $this->registry->lang['controller']['errSpam'];
				$pass    = false;
			}

			//check email valid
			if (strlen($formData['fmessage']) == 0) {
				$error[] = 'Vui lòng nhập câu hỏi';
				$pass    = false;
			}

			if (strlen($formData['ffullname']) == 0) {
				$error[] = $this->registry->lang['controller']['errFullnameNotValid'];
				$pass    = false;
			}

			//check email valid
			if (!Helper::ValidatedEmail($formData['femail'])) {
				$error[] = $this->registry->lang['controller']['errEmailNotValid'];
				$pass    = false;
			}

			//check email valid
			$pattern = '/[0-9]/';

			if (!preg_match($pattern, $formData['fphone']) && strlen($formData['fphone']) <= 10 || strlen($formData['fphone']) >= 11 && $formData['fphone']=='') {
				$error[] = 'Số điện thoại ko hợp lệ';
				$pass    = false;
			}


			//check security code
			if (strlen($formData['fcaptcha']) == 0 || $formData['fcaptcha'] != $_SESSION['verify_code']) {
				$error[] = $this->registry->lang['controller']['errSecurityCode'];
				$pass    = false;
			}


			return $pass;
		}
		
		public function processAction()
		{
			$success               = $error = $formData = array();
			//tien hanh luu thong tin lien he
			if (isset($_POST['ffullname']) && isset($_POST['femail']) && isset($_POST['fphone']) && isset($_POST['fmessage'])) {
				$formData = $_POST;
				if ($this->contactValidateNoCaptchar($formData, $error)) {
					$myContact           = new Core_Contact();
					$myContact->fullname = Helper::plaintext($formData['ffullname']);
					$myContact->email    = Helper::plaintext($formData['femail']);
					$myContact->phone    = Helper::plaintext($formData['fphone']);
					$myContact->message  = Helper::plaintext($formData['fmessage']);


					if ($myContact->addData()) {

						$_SESSION['contactSpamAjax'] = time();

						//////////////////////////////////////////////////////////////////////////////////////////////////
						//////////////////////////////////////////////////////////////////////////////////////////////////
						//send mail to admin
						$taskUrl = $this->registry->conf['rooturl'] . 'task/contact';
						//file_put_contents('uploads/backgroundjob.txt','uid=' . $uid.'&oid='.$idorder);
						Helper::backgroundHttpPost($taskUrl, 'mail=' . $this->registry->setting['mail']['toEmail'] . '&name=' . $myContact->fullname . '&mail=' . $myContact->email . '&mess=' . $myContact->message);
						$success[] = $this->registry->lang['controller']['succContact'];

						//clear form, keep email
						$formData['freason']  = '';
						$formData['fmessage'] = '';

					}
					else {
						$error[] = $this->registry->lang['controller']['errContact'];
					}
				}
				echo json_encode(array('error' => trim(implode('<br />', $error)), 'success' => trim(implode('<br />', $success))));
			}
			
		}
		
		private function contactValidateNoCaptchar($formData, &$error)
		{
			$pass = true;

			//check contact spam
			$contactExpire = 10; //seconds
			if (isset($_SESSION['contactSpamAjax']) && (time() - $_SESSION['contactSpamAjax']) < $contactExpire) {
				$error[] = $this->registry->lang['controller']['errSpam'];
				$pass    = false;
			}

			//check email valid
			if (strlen($formData['fmessage']) == 0) {
				$error[] = 'Bạn cần nhập câu hỏi';
				$pass    = false;
			}

			if (strlen($formData['ffullname']) == 0) {
				$error[] = $this->registry->lang['controller']['errFullnameNotValid'];
				$pass    = false;
			}

			//check email valid
			if (!Helper::ValidatedEmail($formData['femail'])) {
				$error[] = $this->registry->lang['controller']['errEmailNotValid'];
				$pass    = false;
			}

			//check email valid
			$pattern = '/[0-9]/';

			if (!preg_match($pattern, $formData['fphone']) && strlen($formData['fphone']) <= 10 || strlen($formData['fphone']) >= 11 && $formData['fphone']=='') {
				$error[] = 'Số điện thoại ko hợp lệ';
				$pass    = false;
			}

			return $pass;
		}
		
	}

