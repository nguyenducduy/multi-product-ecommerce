<?php

Class Controller_Cms_ReportColumn Extends Controller_Cms_Base
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


		$identifierFilter = (string)($this->registry->router->getArg('identifier'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$valuetypeFilter = (int)($this->registry->router->getArg('valuetype'));
		$datatypeFilter = (int)($this->registry->router->getArg('datatype'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$objecttypeFilter = (int)($this->registry->router->getArg('objecttype'));
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
            if($_SESSION['reportcolumnBulkToken']==$_POST['ftoken'])
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
                            $myReportColumn = new Core_ReportColumn($id);

                            if($myReportColumn->id > 0)
                            {
                                //tien hanh xoa
                                if($myReportColumn->delete())
                                {
                                    $deletedItems[] = $myReportColumn->id;
                                    $this->registry->me->writelog('reportcolumn_delete', $myReportColumn->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myReportColumn->id;
                            }
                            else
                                $cannotDeletedItems[] = $myReportColumn->id;
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
				$myItem = new Core_ReportColumn($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['reportcolumnBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($identifierFilter != "")
		{
			$paginateUrl .= 'identifier/'.$identifierFilter . '/';
			$formData['fidentifier'] = $identifierFilter;
			$formData['search'] = 'identifier';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($valuetypeFilter > 0)
		{
			$paginateUrl .= 'valuetype/'.$valuetypeFilter . '/';
			$formData['fvaluetype'] = $valuetypeFilter;
			$formData['search'] = 'valuetype';
		}

		if($datatypeFilter > 0)
		{
			$paginateUrl .= 'datatype/'.$datatypeFilter . '/';
			$formData['fdatatype'] = $datatypeFilter;
			$formData['search'] = 'datatype';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($displayorderFilter > 0)
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
		}

		if($objecttypeFilter > 0)
		{
			$paginateUrl .= 'objecttype/'.$objecttypeFilter . '/';
			$formData['fobjecttype'] = $objecttypeFilter;
			$formData['search'] = 'objecttype';
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

			if($searchKeywordIn == 'identifier')
			{
				$paginateUrl .= 'searchin/identifier/';
			}
			elseif($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_ReportColumn::getReportColumns($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$reportcolumns = Core_ReportColumn::getReportColumns($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'reportcolumns' 	=> $reportcolumns,
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
												'statusList'	=> Core_ReportColumn::getStatusList(),
												'datatypeList'	=> Core_ReportColumn::getDataTypeList(),
												'valuetypeList'	=> Core_ReportColumn::getValueTypeList(),
												'objecttypeList'	=> Core_ReportColumn::getObjectTypeList(),
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
            if($_SESSION['reportcolumnAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myReportColumn = new Core_ReportColumn();


					$myReportColumn->identifier = $formData['fidentifier'];
					$myReportColumn->name = $formData['fname'];
					$myReportColumn->valuetype = $formData['fvaluetype'];
					$myReportColumn->datatype = $formData['fdatatype'];
					$myReportColumn->status = $formData['fstatus'];
					$myReportColumn->displayorder = $formData['fdisplayorder'];
					$myReportColumn->formular = $formData['fformular'];
					$myReportColumn->objecttype = $formData['fobjecttype'];

                    if($myReportColumn->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('reportcolumn_add', $myReportColumn->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['reportcolumnAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'	=> Core_ReportColumn::getStatusList(),
												'datatypeList'	=> Core_ReportColumn::getDataTypeList(),
												'valuetypeList'	=> Core_ReportColumn::getValueTypeList(),
												'objecttypeList'	=> Core_ReportColumn::getObjectTypeList(),

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
		$myReportColumn = new Core_ReportColumn($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myReportColumn->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myReportColumn->id;
			$formData['fidentifier'] = $myReportColumn->identifier;
			$formData['fname'] = $myReportColumn->name;
			$formData['fvaluetype'] = $myReportColumn->valuetype;
			$formData['fdatatype'] = $myReportColumn->datatype;
			$formData['fstatus'] = $myReportColumn->status;
			$formData['fdisplayorder'] = $myReportColumn->displayorder;
			$formData['fformular'] = $myReportColumn->formular;
			$formData['fobjecttype'] = $myReportColumn->objecttype;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['reportcolumnEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myReportColumn->identifier = $formData['fidentifier'];
						$myReportColumn->name = $formData['fname'];
						$myReportColumn->valuetype = $formData['fvaluetype'];
						$myReportColumn->datatype = $formData['fdatatype'];
						$myReportColumn->status = $formData['fstatus'];
						$myReportColumn->displayorder = $formData['fdisplayorder'];
						$myReportColumn->formular = ($formData['fvaluetype'] == Core_ReportColumn::VALUETYPE_FORMULAR) ? $formData['fformular'] : '';
						$myReportColumn->objecttype = $formData['fobjecttype'];

                        if($myReportColumn->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('reportcolumn_edit', $myReportColumn->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['reportcolumnEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_ReportColumn::getStatusList(),
													'datatypeList'	=> Core_ReportColumn::getDataTypeList(),
													'valuetypeList'	=> Core_ReportColumn::getValueTypeList(),
													'objecttypeList'	=> Core_ReportColumn::getObjectTypeList(),
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
		$myReportColumn = new Core_ReportColumn($id);
		if($myReportColumn->id > 0)
		{
			//tien hanh xoa
			if($myReportColumn->delete())
			{
				$redirectMsg = str_replace('###id###', $myReportColumn->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('reportcolumn_delete', $myReportColumn->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myReportColumn->id, $this->registry->lang['controller']['errDelete']);
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



		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		//neu kieu gia tri la cong thuc thi phai nhap cong thuc vao
		if($formData['fvaluetype'] == Core_ReportColumn::VALUETYPE_FORMULAR)
		{
			if(strlen($formData['fformular']) == 0)
			{
				$error[] = $this->registry->lang['controller']['errFormularRequired'];
				$pass = false;
			}
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		//neu kieu gia tri la cong thuc thi phai nhap cong thuc vao
		if($formData['fvaluetype'] == Core_ReportColumn::VALUETYPE_FORMULAR)
		{
			if(strlen($formData['fformular']) == 0)
			{
				$error[] = $this->registry->lang['controller']['errFormularRequired'];
				$pass = false;
			}
		}

		return $pass;
	}
}

?>