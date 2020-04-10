<?php

Class Controller_Cms_Job Extends Controller_Cms_Base
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


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$slugFilter = (string)($this->registry->router->getArg('slug'));
		$sourceFilter = (string)($this->registry->router->getArg('source'));
		$countviewFilter = (int)($this->registry->router->getArg('countview'));
		$countreviewFilter = (int)($this->registry->router->getArg('countreview'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$resourceserverFilter = (int)($this->registry->router->getArg('resourceserver'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$jcidFilter = (int)($this->registry->router->getArg('jcid'));

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
            if($_SESSION['jobBulkToken']==$_POST['ftoken'])
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
                            $myJob = new Core_Job($id);

                            if($myJob->id > 0)
                            {
                                //tien hanh xoa
                                if($myJob->delete())
                                {
                                    $deletedItems[] = $myJob->id;
                                    $this->registry->me->writelog('job_delete', $myJob->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myJob->id;
                            }
                            else
                                $cannotDeletedItems[] = $myJob->id;
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

		//change order of item
        if(!empty($_POST['fsubmitchangeorder']))
        {
            $displayorderList = $_POST['fdisplayorder'];
            foreach($displayorderList as $id => $neworder)
            {
                $myItem = new Core_Job($id);
                if($myItem->id > 0 && $myItem->displayorder != $neworder)
                {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }

            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }

		$_SESSION['jobBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($slugFilter != "")
		{
			$paginateUrl .= 'slug/'.$slugFilter . '/';
			$formData['fslug'] = $slugFilter;
			$formData['search'] = 'slug';
		}

		if($sourceFilter != "")
		{
			$paginateUrl .= 'source/'.$sourceFilter . '/';
			$formData['fsource'] = $sourceFilter;
			$formData['search'] = 'source';
		}

		if($countviewFilter > 0)
		{
			$paginateUrl .= 'countview/'.$countviewFilter . '/';
			$formData['fcountview'] = $countviewFilter;
			$formData['search'] = 'countview';
		}

		if($countreviewFilter > 0)
		{
			$paginateUrl .= 'countreview/'.$countreviewFilter . '/';
			$formData['fcountreview'] = $countreviewFilter;
			$formData['search'] = 'countreview';
		}

		if($displayorderFilter > 0)
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($resourceserverFilter > 0)
		{
			$paginateUrl .= 'resourceserver/'.$resourceserverFilter . '/';
			$formData['fresourceserver'] = $resourceserverFilter;
			$formData['search'] = 'resourceserver';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($jcidFilter > 0)
		{
			$paginateUrl .= 'jcid/'.$idFilter . '/';
			$formData['fjcid'] = $jcidFilter;
			$formData['search'] = 'jcid';
		}

		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'title')
			{
				$paginateUrl .= 'searchin/title/';
			}
			elseif($searchKeywordIn == 'content')
			{
				$paginateUrl .= 'searchin/content/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Job::getJobs($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$jobs = Core_Job::getJobs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'jobs' 	=> $jobs,
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
												'statusList'    => Core_Job::getStatusList(),
												'myJobcategory'	=> Core_Jobcategory::getJobcategorys(array(), 'parentid', 'ASC', '')
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
            if($_SESSION['jobAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myJob = new Core_Job();

                    $myJob->uid = $this->registry->me->id;
                    $myJob->jcid = $formData['fjcid'];
					$myJob->image = $formData['fimage'];
					$myJob->title = Helper::plaintext($formData['ftitle']);
					$myJob->slug = $formData['fslug'];
					$myJob->content = Helper::xss_clean($formData['fcontent']);
					$myJob->source = $formData['fsource'];
					$myJob->seotitle = $formData['fseotitle'];
					$myJob->seokeyword = $formData['fseokeyword'];
					$myJob->seodescription = $formData['fseodescription'];
					$myJob->status = $formData['fstatus'];

                    if($myJob->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('job_add', $myJob->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['jobAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'    => Core_Job::getStatusList(),
												'myJobcategory'	=> Core_Jobcategory::getJobcategorys(array(), 'parentid', 'ASC', '')
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
		$myJob = new Core_Job($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myJob->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $this->registry->me->id;
			$formData['fid'] = $myJob->id;
			$formData['fjcid'] = $myJob->jcid;
			$formData['fimage'] = $myJob->image;
			$formData['ftitle'] = $myJob->title;
			$formData['fslug'] = $myJob->slug;
			$formData['fcontent'] = $myJob->content;
			$formData['fsource'] = $myJob->source;
			$formData['fseotitle'] = $myJob->seotitle;
			$formData['fseokeyword'] = $myJob->seokeyword;
			$formData['fseodescription'] = $myJob->seodescription;
			$formData['fmetarobot'] = $myJob->metarobot;
			$formData['fcountview'] = $myJob->countview;
			$formData['fcountreview'] = $myJob->countreview;
			$formData['fdisplayorder'] = $myJob->displayorder;
			$formData['fstatus'] = $myJob->status;
			$formData['fipaddress'] = $myJob->ipaddress;
			$formData['fresourceserver'] = $myJob->resourceserver;
			$formData['fdatecreated'] = $myJob->datecreated;
			$formData['fdatemodified'] = $myJob->datemodified;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['jobEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myJob->image = $formData['fimage'];
						$myJob->jcid = $formData['fjcid'];
						$myJob->title = Helper::plaintext($formData['ftitle']);
						$myJob->slug = $formData['fslug'];
						$myJob->content = Helper::xss_clean($formData['fcontent']);
						$myJob->source = $formData['fsource'];
						$myJob->seotitle = $formData['fseotitle'];
						$myJob->seokeyword = $formData['fseokeyword'];
						$myJob->seodescription = $formData['fseodescription'];
						$myJob->status = $formData['fstatus'];

                        if($myJob->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('job_edit', $myJob->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['jobEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'    => Core_Job::getStatusList(),
													'myJobcategory'	=> Core_Jobcategory::getJobcategorys(array(), 'parentid', 'ASC', '')
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
		$myJob = new Core_Job($id);
		if($myJob->id > 0)
		{
			//tien hanh xoa
			if($myJob->delete())
			{
				$redirectMsg = str_replace('###id###', $myJob->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('job_delete', $myJob->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myJob->id, $this->registry->lang['controller']['errDelete']);
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



		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fjcid'] == 0 || $formData['fjcid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCategoryRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fjcid'] == 0 || $formData['fjcid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCategoryRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		return $pass;
	}
}

?>
