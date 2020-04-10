<?php

Class Controller_Cms_Jobcv Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$jidFilter = (int)($this->registry->router->getArg('jid'));
		$titleFilter = (string)($this->registry->router->getArg('title'));
		$firstnameFilter = (string)($this->registry->router->getArg('firstname'));
		$lastnameFilter = (string)($this->registry->router->getArg('lastname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$phoneFilter = (string)($this->registry->router->getArg('phone'));
		$moderatoridFilter = (int)($this->registry->router->getArg('moderatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['jobcvBulkToken']==$_POST['ftoken'])
            {
                 if(!isset($_POST['fbulkid']))
                {
                    $warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
                }
                else
                {
                    $formData['fbulkid'] = $_POST['fbulkid'];

                    //check for delete
                    if($_POST['fbulkaction'] == 'delete')
                    {
                        $delArr = $_POST['fbulkid'];
                        $deletedItems = array();
                        $cannotDeletedItems = array();
                        foreach($delArr as $id)
                        {
                            //check valid user and not admin user
                            $myJobcv = new Core_Jobcv($id);

                            if($myJobcv->id > 0)
                            {
                                //tien hanh xoa
                                if($myJobcv->delete())
                                {
                                    $deletedItems[] = $myJobcv->id;
                                    $this->registry->me->writelog('jobcv_delete', $myJobcv->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myJobcv->id;
                            }
                            else
                                $cannotDeletedItems[] = $myJobcv->id;
                        }

                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }

		}

		$_SESSION['jobcvBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($jidFilter > 0)
		{
			$paginateUrl .= 'jid/'.$jidFilter . '/';
			$formData['fjid'] = $jidFilter;
			$formData['search'] = 'jid';
		}

		if($titleFilter != "")
		{
			$paginateUrl .= 'title/'.$titleFilter . '/';
			$formData['ftitle'] = $titleFilter;
			$formData['search'] = 'title';
		}

		if($firstnameFilter != "")
		{
			$paginateUrl .= 'firstname/'.$firstnameFilter . '/';
			$formData['ffirstname'] = $firstnameFilter;
			$formData['search'] = 'firstname';
		}

		if($lastnameFilter != "")
		{
			$paginateUrl .= 'lastname/'.$lastnameFilter . '/';
			$formData['flastname'] = $lastnameFilter;
			$formData['search'] = 'lastname';
		}

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
		}

		if($phoneFilter != "")
		{
			$paginateUrl .= 'phone/'.$phoneFilter . '/';
			$formData['fphone'] = $phoneFilter;
			$formData['search'] = 'phone';
		}

		if($moderatoridFilter > 0)
		{
			$paginateUrl .= 'moderatorid/'.$moderatoridFilter . '/';
			$formData['fmoderatorid'] = $moderatoridFilter;
			$formData['search'] = 'moderatorid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'title')
			{
				$paginateUrl .= 'searchin/title/';
			}
			elseif($searchKeywordIn == 'firstname')
			{
				$paginateUrl .= 'searchin/firstname/';
			}
			elseif($searchKeywordIn == 'lastname')
			{
				$paginateUrl .= 'searchin/lastname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'phone')
			{
				$paginateUrl .= 'searchin/phone/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Jobcv::getJobcvs($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$jobcvs = Core_Jobcv::getJobcvs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		if(count($jobcvs) > 0)
		{
			foreach($jobcvs as $jobcv)
			{
				$jobcv->jobactor = new Core_Job($jobcv->jid);
				$birthdaystring = explode('-',$jobcv->birthday);
				$jobcv->birthday = implode('/', array_reverse($birthdaystring));	
			}
		}

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);
		
		//get list job
		$joblist = Core_Job::getJobs(array(), 'id' , 'DESC');

		$this->registry->smarty->assign(array(	'jobcvs' 	=> $jobcvs,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												'statusList'    => Core_Jobcv::getStatusList(),
												'joblist'       => $joblist,
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['jobcvAddToken'] == $_POST['ftoken'])
            {
            	$formData = array_merge($formData, $_POST);
            	
                if($this->addActionValidator($formData, $error))
                {
                    $myJobcv = new Core_Jobcv();


					$myJobcv->jid = $formData['fjid'];
					$myJobcv->title = $formData['ftitle'];					
					$myJobcv->firstname = $formData['ffirstname'];
					$myJobcv->lastname = $formData['flastname'];
					$myJobcv->birthday =  $formData['fyear'] . '-' . $formData['fmonth'] . '-' . $formData['fdate'];
					$myJobcv->email = $formData['femail'];
					$myJobcv->phone = $formData['fphone'];
					$myJobcv->moderatorid = $this->registry->me->id;
					$myJobcv->ipaddress = Helper::getIpAddress(true);
					$myJobcv->status = $formData['fstatus'];
					$myJobcv->dateinterview =  strtotime($formData['fyearinterview'] . '-' . $formData['fmonthinterview'] . '-' . $formData['fdateinterview']);

                    if($myJobcv->addData())
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
		
		//get list job
		$joblist = Core_Job::getJobs(array(), 'id' , 'DESC');
		
		//get jobcv status
		$stausList = Core_Jobcv::getStatusList();
				

		$_SESSION['jobcvAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
                                                'joblist'       => $joblist,
                                                'statusList'    => $stausList,
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myJobcv = new Core_Jobcv($id);

		$redirectUrl = $this->getRedirectUrl(); 		
		if($myJobcv->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fjid'] = $myJobcv->jid;
			$formData['fid'] = $myJobcv->id;
			$formData['ftitle'] = $myJobcv->title;
			$formData['ffile'] = $myJobcv->file;
			$formData['ffirstname'] = $myJobcv->firstname;
			$formData['flastname'] = $myJobcv->lastname;
			
			$birthdaystring = $myJobcv->birthday;
			if($birthdaystring != '')
			{
				$birthday = explode('-' , $birthdaystring);
				$formData['fyear'] = $birthday[0];
				$formData['fmonth'] = $birthday[1];
				$formData['fdate'] = $birthday[2];
			}
			
			$formData['femail'] = $myJobcv->email;
			$formData['fphone'] = $myJobcv->phone;
			$formData['fmoderatorid'] = $myJobcv->moderatorid;
			$formData['fipaddress'] = long2ip($myJobcv->ipaddress);
			$formData['fstatus'] = $myJobcv->status;
			$formData['fdatecreated'] = $myJobcv->datecreated;
			$formData['fdatemodified'] = $myJobcv->datemodified;
			
			if($myJobcv->dateinterview > 0 )
			{
				$interviewdaystring = date('Y-m-d' , $myJobcv->dateinterview);
				$interviewday = explode('-' , $interviewdaystring);
				$formData['fyearinterview'] = $interviewday[0];
				$formData['fmonthinterview'] = $interviewday[1];
				$formData['fdateinterview'] = $interviewday[2];
			}
			
			$myJobcv->moderatoractor = new Core_User($myJobcv->moderatorid,true);			
			$formData['fmoderatorname'] = $myJobcv->moderatoractor->fullname;
			

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['jobcvEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myJobcv->jid = $formData['fjid'];
						$myJobcv->title = $formData['ftitle'];
						$myJobcv->file = $formData['ffile'];
						$myJobcv->firstname = $formData['ffirstname'];
						$myJobcv->lastname = $formData['flastname'];
						$myJobcv->birthday = $formData['fyear'] . '-' . $formData['fmonth'] . '-' . $formData['fdate'];
						$myJobcv->email = $formData['femail'];
						$myJobcv->phone = $formData['fphone'];
						$myJobcv->moderatorid = $formData['fmoderatorid'];
						$myJobcv->ipaddress = Helper::getIpAddress(true);
						$myJobcv->status = $formData['fstatus'];
						$myJobcv->dateinterview =  strtotime($formData['fyearinterview'] . '-' . $formData['fmonthinterview'] . '-' . $formData['fdateinterview']);

                        if($myJobcv->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('jobcv_edit', $myJobcv->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}

            //get list job
			$joblist = Core_Job::getJobs(array(), 'id' , 'DESC');
			
			//get jobcv status
			$stausList = Core_Jobcv::getStatusList();
			
			$_SESSION['jobcvEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
                                                    'joblist'   => $joblist,
                                                    'statusList' => $stausList,
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myJobcv = new Core_Jobcv($id);
		if($myJobcv->id > 0)
		{
			//tien hanh xoa
			if($myJobcv->delete())
			{
				$redirectMsg = str_replace('###id###', $myJobcv->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('jobcv_delete', $myJobcv->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myJobcv->id, $this->registry->lang['controller']['errDelete']);
			}

		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}

		$this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
												'redirectMsg' => $redirectMsg,
												));
		$this->registry->smarty->display('redirect.tpl');

	}

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
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
		
		//check date interview
		if((int)$formData['fdateinterview'] != 0 && (int)$formData['fmonthinterview'] != 0 && (int)$formData['fyearinterview'])
		{
			$interviewdaystring = $formData['fyearinterview'] . '-' . $formData['fmonthinterview'] . '-'. $formData['fdateinterview'];
			$interviewday = strtotime($interviewdaystring);
			if(time() > $interviewday)
			{
				$error[] = $this->registry->lang['controller']['errInterviewdayValid'];
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
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
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
		
		//check date interview
		if((int)$formData['fdateinterview'] != 0 && (int)$formData['fmonthinterview'] != 0 && (int)$formData['fyearinterview'])
		{
			$interviewdaystring = $formData['fyearinterview'] . '-' . $formData['fmonthinterview'] . '-'. $formData['fdateinterview'];
			$interviewday = strtotime($interviewdaystring);
			if(time() > $interviewday)
			{
				$error[] = $this->registry->lang['controller']['errInterviewdayValid'];
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

		return $pass;
	}
}

?>