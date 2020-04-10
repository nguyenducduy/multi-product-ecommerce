<?php
Class Controller_Site_Jobcv extends Controller_Site_Base
{
	public function indexAction()
	{
		$formData = array();
		$success = array();
		$error = array();
		$warning = array();

		$jobid = (int)$_GET['id'];

		$job = new Core_Job($jobid);

		if($job->id > 0)
		{
			if(isset($_POST['fsubmit']))
			{
				if($_SESSION['addJobcvToken'] = $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);
					if($this->addValidatorAction($formData, $error))
					{
						$myJobcv = new Core_Jobcv();
						$myJobcv->jid = $job->id;
						$myJobcv->title = Helper::plaintext($formData['ftitle']);
						$myJobcv->firstname = Helper::plaintext($formData['ffirstname']);
						$myJobcv->lastname = Helper::plaintext($formData['flastname']);
						$myJobcv->birthday = $formData['fyear'] . '-' . $formData['fmonth'] . '-' . $formData['fdate'];
						$myJobcv->email = $formData['femail'];
						$myJobcv->phone = $formData['fphone'];
						$myJobcv->status = Core_Jobcv::STATUS_NEW;

						if($myJobcv->addData() > 0)
						{
							$success[] = $this->registry->lang['controller']['succAdd'];
	                        $this->registry->me->writelog('jobcv_add', $myJobcv->id, array());
	                        $formData = array();
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}
			}
		}
		$_SESSION['addJobcvToken'] = Helper::getSecurityToken();
		$this->registry->smarty->assign(array(	'formData'		=> $formData,
													'success'		=> $success,
													'error'			=> $error,
													'warning'		=> $warning,
													'job'			=> $job,
													));



		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	private function addValidatorAction($formData, &$error)
	{
		$pass = true;



		if($formData['fjid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errJidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['ffirstname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFirstnameRequired'];
			$pass = false;
		}

		if($formData['flastname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errLastnameRequired'];
			$pass = false;
		}

		if((int)$formData['fdate'] == 0 || (int)$formData['fmonth'] == 0 || $formData['fyear'] == '')
		{
			$error[] = $this->registry->lang['controller']['errBirthdayRequired'];
			$pass = false;
		}
		else
		{
			$birthdaystring = $formData['fyear'] . '-' . $formData['fmonth'] . '-' . $formData['fdate'];
			$birthday = strtotime($birthdaystring);
			if(time() - $birthday < (18 * 60 * 60 * 24 * 365))
			{
				$error[] = $this->registry->lang['controller']['errBirthdayValid'];
				$pass = false;
			}
		}

		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}
		else
		{
			if(ctype_digit($formData['fphone']))
			{
				if(strlen(trim($formData['fphone'])) < 10 || strlen(trim($formData['fphone'])) > 11)
                {
                	$error[] = $this->registry->lang['controller']['errPhoneRequired'];
                    $pass = false;
                }
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errPhoneRequired'];
                $pass = false;
			}
		}

		//check security code
        if(strlen($formData['fcaptcha']) == 0 || $formData['fcaptcha'] != $_SESSION['verify_code'])
        {
            $error[] = $this->registry->lang['controller']['errSecurityCode'];
            $pass = false;
        }

		//check file valid
		if(strlen($_FILES['ffile']['name']) > 0)
        {
            //kiem tra dinh dang hinh anh
            if(!in_array(strtoupper(end(explode('.', $_FILES['ffile']['name']))), $this->registry->setting['jobcv']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFileType'];
                $pass = false;
            }

            //kiem tra kich thuoc file
            if($_FILES['ffile']['size'] > $this->registry->setting['product']['imageMaxFileSize'])
            {
                $error[] = $this->registry->lang['controller']['errFileSize'];
                $pass = false;
            }
        }
        else
        {
        	$error[] = $this->registry->lang['controller']['errFileEmpty'];
            $pass = false;
        }

		return $pass;
	}
}