<?php

	Class Controller_Task_Contact Extends Controller_Task_Base
	{
		public function indexAction()
		{

		}

		public function sendemailAction()
		{
			$myContact['email']    = $_GET['mail'];
			$myContact['fullname'] = $_GET['name'];
			$myContact['message']  = $_GET['mess'];
			$rs                    = false;
			if (!in_array(' ', $myContact)) {
				$this->registry->smarty->assign(array('datecreated' => date("F j, Y, g:i a"),
													  'myContact' => $myContact));
				$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot . 'contact/admin.tpl');
				$sender       = new SendMail($this->registry, $myContact['mail'], 'Dienmay.com', 'Liên hệ', $mailContents, $this->registry->setting['mail']['fromEmail'], $this->registry->setting['mail']['fromName']);
				if ($sender->Send()) {
					$rs = true;
				}
				else {
					$rs = false;
				}
			}

		}


	}

