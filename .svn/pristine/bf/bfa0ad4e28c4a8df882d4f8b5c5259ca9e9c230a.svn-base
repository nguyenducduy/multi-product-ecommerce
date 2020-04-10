<?php

Class Controller_Cms_ReportSheet Extends Controller_Cms_Base
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


		$nameFilter = (string)($this->registry->router->getArg('name'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$creatoridFilter = (int)($this->registry->router->getArg('creatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$yearFilter = (int)($this->registry->router->getArg('year'));
		$monthFilter = (int)($this->registry->router->getArg('month'));
		$weekFilter = (int)($this->registry->router->getArg('week'));
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
            if($_SESSION['reportsheetBulkToken']==$_POST['ftoken'])
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
                            $myReportSheet = new Core_ReportSheet($id);

                            if($myReportSheet->id > 0)
                            {
                                //tien hanh xoa
                                if($myReportSheet->delete())
                                {
                                    $deletedItems[] = $myReportSheet->id;
                                    $this->registry->me->writelog('reportsheet_delete', $myReportSheet->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myReportSheet->id;
                            }
                            else
                                $cannotDeletedItems[] = $myReportSheet->id;
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

		$_SESSION['reportsheetBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($creatoridFilter > 0)
		{
			$paginateUrl .= 'creatorid/'.$creatoridFilter . '/';
			$formData['fcreatorid'] = $creatoridFilter;
			$formData['search'] = 'creatorid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($yearFilter > 0)
		{
			$paginateUrl .= 'year/'.$yearFilter . '/';
			$formData['fyear'] = $yearFilter;
			$formData['search'] = 'year';
		}

		if($monthFilter > 0)
		{
			$paginateUrl .= 'month/'.$monthFilter . '/';
			$formData['fmonth'] = $monthFilter;
			$formData['search'] = 'month';
		}

		if($weekFilter > 0)
		{
			$paginateUrl .= 'week/'.$weekFilter . '/';
			$formData['fweek'] = $weekFilter;
			$formData['search'] = 'week';
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
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_ReportSheet::getReportSheets($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
        $reportsheets = Core_ReportSheet::getReportSheets($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

        if(count($reportsheets) > 0)
        {
            foreach($reportsheets as $reportsheet)
            {
                $reportsheet->userActor = new Core_User($reportsheet->creatorid);
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


		$this->registry->smarty->assign(array(	'reportsheets' 	=> $reportsheets,
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
                                                'typeList'      => Core_ReportSheet::getTypeList(),
                                                'statusList'    => Core_ReportSheet::getStatusList(),
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
            if($_SESSION['reportsheetAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {                    
                    $myReportSheet = new Core_ReportSheet();


					$myReportSheet->name = $formData['fname'];
					$myReportSheet->type = $formData['ftype'];
					$myReportSheet->creatorid = $this->registry->me->id;
					$myReportSheet->status = $formData['fstatus'];
					$myReportSheet->description = $formData['fdescription'];
					$myReportSheet->year = $formData['fyear'];
					$myReportSheet->month = $formData['fmonth'];
					$myReportSheet->week = $formData['fweek'];

                    if($myReportSheet->addData())
                    {
                        $ok = true;
                        //add rel sheet and columns
                        if(count($formData['fcolumns']) > 0)
                        {
                            $ok =false;
                            foreach($formData['fcolumns'] as $columnid)
                            {
                                $myReportRelSheetColumn = new Core_ReportRelSheetColumn();
                                $myReportRelSheetColumn->rsid = $myReportSheet->id;
                                $myReportRelSheetColumn->rcid = $columnid;
                                if($myReportRelSheetColumn->addData() > 0)
                                {
                                    $ok = true;
                                }
                            }
                        }

                        if($ok)
                        {
                            $success[] = $this->registry->lang['controller']['succAdd'];
                            $this->registry->me->writelog('reportsheet_add', $myReportSheet->id, array());
                            $formData = array();
                        }                        
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

        }
        $columnList = Core_ReportColumn::getReportColumns(array(), 'displayorder' , 'ASC');
        $columns = array();
       
        if(count($columnList) > 0)
        {
            for($i = 0 , $ilen=ceil(count($columnList)/5) ; $i < $ilen ; $i++)
            {
                $row = array();
                for($j = $i * 5 , $jlen=($i+1)*5 ; $j < $jlen ; $j++)
                {
                    $row[] = $columnList[$j];
                }
                $columns[] = $row;
            }
        }       

		$_SESSION['reportsheetAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
                                                'typeList'      => Core_ReportSheet::getTypeList(),
                                                'statusList'    => Core_ReportSheet::getStatusList(),
                                                'columnList'    => $columns,                                                                                         
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
		$myReportSheet = new Core_ReportSheet($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myReportSheet->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myReportSheet->id;
			$formData['fname'] = $myReportSheet->name;
			$formData['ftype'] = $myReportSheet->type;
			$formData['fcreatorid'] = $myReportSheet->creatorid;
			$formData['fstatus'] = $myReportSheet->status;
			$formData['fdatecreated'] = $myReportSheet->datecreated;
			$formData['fdatemodified'] = $myReportSheet->datemodified;
			$formData['fdescription'] = $myReportSheet->description;
			$formData['fyear'] = $myReportSheet->year;
			$formData['fmonth'] = $myReportSheet->month;
			$formData['fweek'] = $myReportSheet->week;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['reportsheetEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {                       
						$myReportSheet->name = $formData['fname'];
						$myReportSheet->type = $formData['ftype'];
						$myReportSheet->creatorid = $formData['fcreatorid'];
						$myReportSheet->status = $formData['fstatus'];
						$myReportSheet->description = $formData['fdescription'];					

                        if($myReportSheet->updateData())
                        {
                            //xoa tat ca cac columns cu cua sheet
                            if(Core_ReportRelSheetColumn::deletebysheet($formData['fid']) > 0)
                            {
                                //add rel sheet and columns
                                if(count($formData['fcolumns']) > 0)
                                {
                                    $ok = false;                                   
                                    foreach($_POST['fcolumns'] as $columnid)
                                    {
                                        $myReportRelSheetColumn = new Core_ReportRelSheetColumn();
                                        $myReportRelSheetColumn->rsid = $myReportSheet->id;
                                        $myReportRelSheetColumn->rcid = $columnid;
                                        if($myReportRelSheetColumn->addData() > 0)
                                        {
                                            $ok = true;
                                        }
                                    }
                                }
                            }

                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('reportsheet_edit', $myReportSheet->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}
            //get column of sheet
            $sheetcolumns = Core_ReportRelSheetColumn::getReportRelSheetColumns(array('frsid' => $formData['fid']) , 'displayorder' , 'ASC');             

            //get all column
            $columnList = Core_ReportColumn::getReportColumns(array(), 'displayorder' , 'ASC');
            $columns = array();
       
            if(count($columnList) > 0)
            {
                for($i = 0 , $ilen=ceil(count($columnList)/5) ; $i < $ilen ; $i++)
                {
                    $row = array();
                    for($j = $i * 5 , $jlen=($i+1)*5 ; $j < $jlen ; $j++)
                    {
                        $row[] = $columnList[$j];
                    }
                    $columns[] = $row;
                }
            }
			$_SESSION['reportsheetEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
                                                    'success'	=> $success,
                                                    'statusList'=> Core_ReportSheet::getStatusList(),
                                                    'typeList'  => Core_ReportSheet::getTypeList(),
                                                    'sheetcolumns' => $sheetcolumns,
                                                    'columnList' => $columns,
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
		$myReportSheet = new Core_ReportSheet($id);
		if($myReportSheet->id > 0)
		{
			//tien hanh xoa
			if($myReportSheet->delete())
			{
				$redirectMsg = str_replace('###id###', $myReportSheet->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('reportsheet_delete', $myReportSheet->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myReportSheet->id, $this->registry->lang['controller']['errDelete']);
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
