<?php

Class Controller_Cms_Jobcategory Extends Controller_Cms_Base
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


		$slugFilter = (string)($this->registry->router->getArg('slug'));
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$idFilter = (int)($this->registry->router->getArg('id'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'parentid';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['jobcategoryBulkToken']==$_POST['ftoken'])
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
                            $myJobcategory = new Core_Jobcategory($id);

                            if($myJobcategory->id > 0)
                            {
                                //tien hanh xoa
                                if($myJobcategory->delete())
                                {
                                    $deletedItems[] = $myJobcategory->id;
                                    $this->registry->me->writelog('jobcategory_delete', $myJobcategory->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myJobcategory->id;
                            }
                            else
                                $cannotDeletedItems[] = $myJobcategory->id;
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
                $myItem = new Core_Jobcategory($id);
                if($myItem->id > 0 && $myItem->displayorder != $neworder)
                {
                    $myItem->displayorder = $neworder;
                    $myItem->updateData();
                }
            }

            $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
        }

		$_SESSION['jobcategoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';

		if($jcidFilter > 0)
		{
			$paginateUrl .= 'jcid/'.$ncidFilter . '/';
			$formData['fjcid'] = $jcidFilter;
			$formData['search'] = 'jcid';
		}

		if($slugFilter != "")
		{
			$paginateUrl .= 'slug/'.$slugFilter . '/';
			$formData['fslug'] = $slugFilter;
			$formData['search'] = 'slug';
		}

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
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

		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			elseif($searchKeywordIn == 'summary')
			{
				$paginateUrl .= 'searchin/summary/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Jobcategory::getJobcategorys($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		
		$jobcategorys = Core_Jobcategory::getJobcategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);
		

		$this->registry->smarty->assign(array(	'jobcategorys' 	=> $jobcategorys,
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
												'statusList'	=> Core_Jobcategory::getStatusList(),
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
            if($_SESSION['jobcategoryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myJobcategory = new Core_Jobcategory();


					$myJobcategory->image = $formData['fimage'];
					$myJobcategory->name = $formData['fname'];
					$myJobcategory->summary = $formData['fsummary'];
					$myJobcategory->seotitle = $formData['fseotitle'];
					$myJobcategory->seokeyword = $formData['fseokeyword'];
					$myJobcategory->seodescription = $formData['fseodescription'];
					$myJobcategory->metarobot = $formData['fmetarobot'];
					$myJobcategory->parentid = $formData['fparentid'];
					$myJobcategory->countitem = $formData['fcountitem'];
					$myJobcategory->status = $formData['fstatus'];

                    if($myJobcategory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('jobcategory_add', $myJobcategory->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		
		//echodebug($myJobcategory, true);

		$_SESSION['jobcategoryAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'    => Core_Jobcategory::getStatusList(),
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
		$myJobcategory = new Core_Jobcategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myJobcategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myJobcategory->id;
			$formData['fimage'] = $myJobcategory->image;
			$formData['fname'] = $myJobcategory->name;
			$formData['fslug'] = $myJobcategory->slug;
			$formData['fsummary'] = $myJobcategory->summary;
			$formData['fseotitle'] = $myJobcategory->seotitle;
			$formData['fseokeyword'] = $myJobcategory->seokeyword;
			$formData['fseodescription'] = $myJobcategory->seodescription;
			$formData['fmetarobot'] = $myJobcategory->metarobot;
			$formData['fparentid'] = $myJobcategory->parentid;
			$formData['fcountitem'] = $myJobcategory->countitem;
			$formData['fdisplayorder'] = $myJobcategory->displayorder;
			$formData['fstatus'] = $myJobcategory->status;
			$formData['fdatecreated'] = $myJobcategory->datecreated;
			$formData['fdatemodified'] = $myJobcategory->datemodified;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['jobcategoryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myJobcategory->image = $formData['fimage'];
						$myJobcategory->name = $formData['fname'];
						$myJobcategory->summary = $formData['fsummary'];
						$myJobcategory->seotitle = $formData['fseotitle'];
						$myJobcategory->seokeyword = $formData['fseokeyword'];
						$myJobcategory->seodescription = $formData['fseodescription'];
						$myJobcategory->metarobot = $formData['fmetarobot'];
						$myJobcategory->parentid = $formData['fparentid'];
						$myJobcategory->countitem = $formData['fcountitem'];
						$myJobcategory->status = $formData['fstatus'];

                        if($myJobcategory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('jobcategory_edit', $myJobcategory->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['jobcategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_Jobcategory::getStatusList(),
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
		$myJobcategory = new Core_Jobcategory($id);
		if($myJobcategory->id > 0)
		{
			//tien hanh xoa
			if($myJobcategory->delete())
			{
				$redirectMsg = str_replace('###id###', $myJobcategory->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('jobcategory_delete', $myJobcategory->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myJobcategory->id, $this->registry->lang['controller']['errDelete']);
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



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		return $pass;
	}
}

?>
