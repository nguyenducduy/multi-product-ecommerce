<?php

Class Controller_Cms_Program Extends Controller_Cms_Base
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
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$storelistFilter = (string)($this->registry->router->getArg('storelist'));
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
            if($_SESSION['programBulkToken']==$_POST['ftoken'])
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
                            $myProgram = new Core_Program($id);

                            if($myProgram->id > 0)
                            {
                                //tien hanh xoa
                                if($myProgram->delete())
                                {
                                    $deletedItems[] = $myProgram->id;
                                    $this->registry->me->writelog('program_delete', $myProgram->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProgram->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProgram->id;
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

		$_SESSION['programBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($storelistFilter != "")
		{
			$paginateUrl .= 'storelist/'.$storelistFilter . '/';
			$formData['fstorelist'] = $storelistFilter;
			$formData['search'] = 'storelist';
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
			elseif($searchKeywordIn == 'storelist')
			{
				$paginateUrl .= 'searchin/storelist/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Program::getPrograms($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$programs = Core_Program::getPrograms($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'programs' 	=> $programs,
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
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		//check quyen la marketing
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $checker = Core_StoreUser::checkRoleUser(array(
                                                    'fuid' => $this->registry->me->id,
                                                    'frole' => Core_StoreUser::ROLE_MARKETING,
                                                    'fstatus' => Core_StoreUser::STATUS_ENABLE
                                                    ));
            if(!$checker)
            {
                header('location: ' . $this->registry['conf']['rooturl_cms']);
                exit();
            }
        }

		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		set_time_limit(0);
		$listpositions = Core_Posm::getPosms(array(),'ID', 'ASC');

		/*if(!empty($_FILES['fimageguidearr']['name'])){
			$_FILES['fimageguidearr'] = $_FILES['fimageguidearr'];
			$_SESSION['ses_postparam'] = $_POST;
		}*/
		if(!empty($_POST['fsubmit']) || !empty($_POST['ftoken']))
		{
            if($_SESSION['programAddToken'] == $_POST['ftoken'])
            {
            	$formData = array_merge($formData, $_POST);
            	$listposmimage = array();
                if(!empty($listpositions) && !empty($_FILES['fimageguidearr'])){
                    	$listnameofimage = $_FILES['fimageguidearr']['name'];
						foreach($listpositions as $posm){
							foreach($listnameofimage as $index=>$img){
								if(strpos($img, $posm->codeimage)!==false){
									$listposmimage[$posm->id] = $index;//index of array files
									break;
								}
							}
						}
                }
                if($this->addActionValidator($formData, $error))
                {
                    $myProgram = new Core_Program();
					$myProgram->uid = $this->registry->me->id;
					$myProgram->name = $formData['fname'];
					$myProgram->description = $formData['fdescription'];
					$myProgram->storelist = implode(',',$formData['fstorelist']);
					$myProgram->executetime = Helper::strtotimedmy($formData['fexecutetime']);
					$myProgram->startdate = Helper::strtotimedmy($formData['fstartdate']);
					$myProgram->dateend = Helper::strtotimedmy($formData['fdateend']);

					$myProgram->posmobj = $listposmimage;//$formData['listpositions'];
					//$myProgramPosition->imageguide = $formData['fimagesexecute'];
					$myProgram->noteguideobj = $formData['fnoteguide'];

                    if($myProgram->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('program_add', $myProgram->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}
		$formData['liststores'] = Core_Store::getStores(array('fstatus' => Core_Store::STATUS_ENABLE),'name','ASC');
		$formData['listpositions'] = $listpositions;
		$_SESSION['programAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	//check quyen la marketing
	function editAction()
	{
        //check quyen la marketing
        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $checker = Core_StoreUser::checkRoleUser(array(
                                                    'fuid' => $this->registry->me->id,
                                                    'frole' => Core_StoreUser::ROLE_MARKETING,
                                                    'fstatus' => Core_StoreUser::STATUS_ENABLE
                                                    ));
            if(!$checker)
            {
                header('location: ' . $this->registry['conf']['rooturl_cms']);
                exit();
            }
        }
		$id = (int)$this->registry->router->getArg('id');
		$myProgram = new Core_Program($id);
		set_time_limit(0);
		$redirectUrl = $this->getRedirectUrl();
		if($myProgram->id > 0)
		{
			$listpositions = Core_Posm::getPosms(array(),'ID', 'ASC');
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProgram->uid;
			$formData['fid'] = $myProgram->id;
			$formData['fname'] = $myProgram->name;
			$formData['fdescription'] = $myProgram->description;
			$formData['fstorelist'] = explode(',', $myProgram->storelist);
			$formData['fexecutetime'] = date('d/m/Y', $myProgram->executetime);
			$formData['fstartdate'] = date('d/m/Y', $myProgram->startdate);
			$formData['fdateend'] = date('d/m/Y', $myProgram->dateend);
			$programposition = $myProgram->programposition;

			$formData['fnoteguide'] = array();
			$ppimage = array();
			if(!empty($programposition)){
				foreach($programposition as $pp){
					$ppimage[$pp->poid] = $pp->getimage();
					$formData['fnoteguide'][$pp->poid] = $pp->noteguide;
				}
			}
			$formData['programposition'] = $ppimage;

			if(!empty($_POST['fsubmit']) || isset($_FILES['fimageguidearr']))
			{
                if($_SESSION['programEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    $listposmimage = array();
                    if(!empty($_FILES['fimageguidearr']['name'][0])){
		                if(!empty($listpositions) && !empty($_FILES['fimageguidearr'])){
                    			$listnameofimage = $_FILES['fimageguidearr']['name'];
								foreach($listpositions as $posm){
									foreach($listnameofimage as $index=>$img){
										if(strpos($img, $posm->codeimage)!==false){
											$listposmimage[$posm->id] = $index;//index of array files
											break;
										}
									}
								}
		                }
                    }
                    if($this->editActionValidator($formData, $error, $listpositions))
                    {
						$myProgram->uid = $formData['fuid'];
						$myProgram->name = $formData['fname'];
						$myProgram->description = $formData['fdescription'];
						$myProgram->storelist = implode(',',$formData['fstorelist']);
						$myProgram->executetime = Helper::strtotimedmy($formData['fexecutetime']);
						$myProgram->startdate = Helper::strtotimedmy($formData['fstartdate']);
						$myProgram->dateend = Helper::strtotimedmy($formData['fdateend']);

                        if(!empty($listposmimage)) $myProgram->posmobj = $listposmimage;
                        else $myProgram->listpositionsobject = $listpositions;//image of ject is position object
						$myProgram->noteguideobj = $formData['fnoteguide'];
                        //echodebug($_FILES['fimagepos'], true);
                        if($myProgram->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('program_edit', $myProgram->id, array());

                            //load lai data
                            $myProgram = new Core_Program($id);
                            $formData['fuid'] = $myProgram->uid;
							$formData['fid'] = $myProgram->id;
							$formData['fname'] = $myProgram->name;
							$formData['fdescription'] = $myProgram->description;
							$formData['fstorelist'] = explode(',', $myProgram->storelist);
							$formData['fexecutetime'] = date('d/m/Y', $myProgram->executetime);
							$formData['fstartdate'] = date('d/m/Y', $myProgram->startdate);
							$formData['fdateend'] = date('d/m/Y', $myProgram->dateend);
							$programposition = $myProgram->programposition;

							$formData['fnoteguide'] = array();
							$ppimage = array();
							if(!empty($programposition)){
								foreach($programposition as $pp){
									$ppimage[$pp->poid] = $pp->getimage();
									$formData['fnoteguide'][$pp->poid] = $pp->noteguide;
								}
							}
							$formData['programposition'] = $ppimage;
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['programEditToken'] = Helper::getSecurityToken();//Tao token moi

			$formData['liststores'] = Core_Store::getStores(array('fstatus' => Core_Store::STATUS_ENABLE),'name','ASC');
			$formData['listpositions'] = $listpositions;

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,

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

	function executeAction()
	{
		$uidcheckstore = $this->registry->me->id;//5423;//
		$storesuser = (Core_StoreUser::getStoreUserInfo($uidcheckstore));//nguyen vu long
		//$storesuser->sid = 810;
		$id = (int)$this->registry->router->getArg('id');
		$myProgram = new Core_Program($id);
		$redirectUrl = $this->getRedirectUrl();
		if($myProgram->id > 0 && (($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer')) || ($storesuser->sid > 0 && strpos($myProgram->storelist, $storesuser->sid) !==false)))
		{
			$listpositions = Core_Posm::getPosms(array(),'ID', 'ASC');
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProgram->uid;
			$formData['fid'] = $myProgram->id;
			$formData['fname'] = $myProgram->name;
			$formData['fdescription'] = $myProgram->description;
			$formData['fstorelist'] = explode(',', $myProgram->storelist);
			$formData['fexecutetime'] = date('d-m-Y', $myProgram->executetime);
			$formData['fstartdate'] = date('d-m-Y', $myProgram->startdate);
			$formData['fdateend'] = date('d-m-Y', $myProgram->dateend);
			$programposition = $myProgram->programposition;
			$programpositionstore = Core_ProgramPositionStore::getProgramPositionStores(array('fsid' => $storesuser->sid, 'fpid' => $myProgram->id), 'poid' , 'ASC');

			$formData['fnote'] = array();
			$ppimage = array();

			if(!empty($programposition)){
				foreach($programposition as $pp){
					$ppimage[$pp->poid] = array('image' => $pp->getimage(), 'id' => $pp->id);
				}
			}
			$formData['programposition'] = $ppimage;

			$ppsimage = array();
			$hasapprove = 2;
			if(!empty($programpositionstore)){
				foreach($programpositionstore as $pps){
					if(!empty($pps->image)){
						$ppsimage[$pps->ppid] = $pps->getimage();
						$formData['fnote'][$pps->ppid] = $pps->approvenote;
						$formData['fapprove'][$pps->ppid] = $pps->isapprove;
						if($pps->uidapprove > 0){
							$getUserInfo = new Core_User($pps->uidapprove, true);
							$formData['fapproveuser'][$pps->ppid] = $getUserInfo->fullname. (!empty($getUserInfo->phone)?' - '.$getUserInfo->phone:'');
						}
						if($hasapprove==2 && $pps->isapprove == 1 ) {
							$hasapprove = 1;
						}
					}
				}
			}
			$formData['hasapprove'] = $hasapprove;
			/*var_dump($_FILES);
			var_dump($_POST);
			if(!empty($_POST))exit();*/
			$formData['programpositionstore'] = $ppsimage;
			if((!empty($_POST['fsubmit']) || isset($_FILES['fimageexecutearr'])))
			{
				//check quyen la marketing
		        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		        {
		            $checker = Core_StoreUser::checkRoleUser(array(
		                                                    'fuid' => $this->registry->me->id,
		                                                    'frole' => Core_StoreUser::ROLE_SUPERMARKET,
		                                                    'fstatus' => Core_StoreUser::STATUS_ENABLE
		                                                    ));
		            if(!$checker)
		            {
		                header('location: ' . $this->registry['conf']['rooturl_cms']);
		                exit();
		            }
		        }

                if($_SESSION['programEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    $listposmimage = array();
                    if(!empty($_FILES['fimageexecutearr']['name'][0]) && $hasapprove == 2){
		                if(!empty($listpositions) && !empty($_FILES['fimageexecutearr'])){
                    			$listnameofimage = $_FILES['fimageexecutearr']['name'];
								foreach($listpositions as $posm){
									foreach($listnameofimage as $index=>$img){
										if(strpos($img, $posm->codeimage)!==false){
											$listposmimage[$posm->id] = $index;//index of array files
											break;
										}
									}
								}
		                }
                    }
                    $isedit = false;
                    if(!empty($formData['programpositionstore'])){
                    	$isedit = true;
					}
					if($this->executeValidation($programposition, $error, $isedit)){
						$myProgramPositionStore = new Core_ProgramPositionStore();
	                    if(!empty($listposmimage)) {
							$myProgramPositionStore->imageobject = $listposmimage;
							$myProgramPositionStore->ppobject = $formData['programposition'];
	                    }//it's position of images of new object
	                    else
	                    	$myProgramPositionStore->ppsobject = $programpositionstore;

	                    $myProgramPositionStore->sid = $storesuser->sid;
	                    //$myProgramPositionStore->ppobject = $programposition;
	                    $myProgramPositionStore->noteobject = $formData['fnote'];
	                    $myProgramPositionStore->pid = $myProgram->id;
	                    $myProgramPositionStore->uid = $this->registry->me->id;
	                    $myProgramPositionStore->processMultiData($isedit);
	                    //echodebug($myProgramPositionStore);
	                    header('Location: '.$this->conf['rooturl'].'/cms/program/execute/id/'.$myProgram->id);
					}
                    else{
						$error[] = str_replace('###name###', $this->registry->lang['controller']['labelExecutebutton'], $this->registry->lang['controller']['errorrequireinput']);
                    }
                }
			}


			$_SESSION['programEditToken'] = Helper::getSecurityToken();//Tao token moi

			$formData['liststoresapply'] = Core_Store::getStores(array('fstatus' => Core_Store::STATUS_ENABLE, 'fidarr' => explode(',', $myProgram->storelist)),'name','ASC');
			$formData['listpositions'] = $listpositions;

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'ismarketing' => $ismarketing,

													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'execute.tpl');
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

	//check quyen la marketing
	function reportAction()
	{
		//$uidcheckstore = $this->registry->me->id;//5423;//
		//$storesuser = (Core_StoreUser::getStoreUserInfo($uidcheckstore));//nguyen vu long
		$id = (int)$this->registry->router->getArg('id');
		$myProgram = new Core_Program($id);
		$redirectUrl = $this->getRedirectUrl();
		if($myProgram->id > 0)
		{
			$listpositions = Core_Posm::getPosms(array(),'ID', 'ASC');
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myProgram->uid;
			$formData['fid'] = $myProgram->id;
			$formData['fname'] = $myProgram->name;
			$formData['fdescription'] = $myProgram->description;
			$formData['fstorelist'] = explode(',', $myProgram->storelist);
			$formData['fexecutetime'] = date('d-m-Y', $myProgram->executetime);
			$formData['fstartdate'] = date('d-m-Y', $myProgram->startdate);
			$formData['fdateend'] = date('d-m-Y', $myProgram->dateend);
			$programposition = $myProgram->programposition;
			$programpositionstore = Core_ProgramPositionStore::getProgramPositionStores(array('fsid' => $storesuser->sid, 'fpid' => $myProgram->id), 'poid' , 'ASC');

			$formData['fnote'] = array();
			$ppimage = array();
			if(!empty($programposition)){
				foreach($programposition as $pp){
					$ppimage[$pp->poid] = array('image' => $pp->getimage(), 'id' => $pp->id);
				}
			}
			$formData['programposition'] = $ppimage;

			$ppsimage = array();
			$liststoreapplieds = array();
			if(!empty($programpositionstore)){
				foreach($programpositionstore as $pps){
					if(!empty($pps->image)){
						if($pps->uid > 0){
							$getUserInfo = new Core_User($pps->uid, true);
							$pps->fapproveuser = $getUserInfo->fullname. (!empty($getUserInfo->phone)?' - '.$getUserInfo->phone:'');
						}
						$ppsimage[$pps->ppid][$pps->sid] = $pps;//array('image'=>$pps->getimage(),'id' =>$pps->id);
						$liststoreapplieds[$pps->sid] = new Core_Store($pps->sid, true);
					}
				}
			}
			/*var_dump($_FILES);
			var_dump($_POST);
			if(!empty($_POST))exit();*/
			$formData['programpositionstore'] = $ppsimage;

			//$listallstores = Core_Store::getStores(array('fstatus' => Core_Store::STATUS_ENABLE, 'fidarr' => explode(',', $myProgram->storelist)),'name','ASC');
			$formData['liststoresapply'] = $liststoreapplieds;
			$formData['listpositions'] = $listpositions;

			//check quyen la marketing
			$ismarketing = 0;
		    if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		    {
		        $checker = Core_StoreUser::checkRoleUser(array(
		                                                    'fuid' => $this->registry->me->id,
		                                                    'frole' => Core_StoreUser::ROLE_MARKETING,
		                                                    'fstatus' => Core_StoreUser::STATUS_ENABLE
		                                                    ));
				if($checker) $ismarketing = 1;
		    }
		    else  $ismarketing = 1;

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'ismarketing' => $ismarketing,

													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'report.tpl');
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
		$myProgram = new Core_Program($id);
		if($myProgram->id > 0)
		{
			//tien hanh xoa
			if($myProgram->delete())
			{
				$redirectMsg = str_replace('###id###', $myProgram->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('program_delete', $myProgram->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProgram->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fdescription'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDescriptionRequired'];
			$pass = false;
		}

		if($formData['fstorelist'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStorelistRequired'];
			$pass = false;
		}

		if($formData['fexecutetime'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errExecutetimeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fdateend'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDateendRequired'];
			$pass = false;
		}

		if(empty($_FILES['fimageguidearr']['name'][0]))
		{
			$error[] = str_replace('###name###', $this->registry->lang['controller']['labelImageguide'], $this->registry->lang['controller']['errorrequireinput']);
			$pass = false;
		}
		elseif(!empty($_FILES['fimageguidearr']['name'][0])){
			foreach($_FILES['fimageguidearr']['name'] as $key=>$name){
				$ext = strtoupper(Helper::fileExtension($name));
	            if(!in_array($ext, $this->registry->setting['posm']['imageValidType']))
	            {
	                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
	                $pass = false;
	                break;
	            }
	            elseif($_FILES['fimageguidearr']['size'][$key] > $this->registry->setting['posm']['imageMaxFileSize'])
	            {
	                $error[] = str_replace('###VALUE###', '( '.$name.' )'.round($this->registry->setting['posm']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
	                $pass = false;
	                break;
	            }
			}
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error, $listpositions)
	{
		$pass = true;



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fdescription'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDescriptionRequired'];
			$pass = false;
		}

		if($formData['fstorelist'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStorelistRequired'];
			$pass = false;
		}

		if($formData['fexecutetime'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errExecutetimeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fdateend'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDateendRequired'];
			$pass = false;
		}

		if(!empty($_FILES['fimageguidearr']['name'][0])){
			foreach($_FILES['fimageguidearr']['name'] as $key=>$name){
				$ext = strtoupper(Helper::fileExtension($name));
	            if(!in_array($ext, $this->registry->setting['posm']['imageValidType']))
	            {
	                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
	                $pass = false;
	                break;
	            }
	            elseif($_FILES['fimageguidearr']['size'][$key] > $this->registry->setting['posm']['imageMaxFileSize'])
	            {
	                $error[] = str_replace('###VALUE###', '( '.$name.' )'.round($this->registry->setting['posm']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
	                $pass = false;
	                break;
	            }
			}
		}
		else{
			foreach($listpositions as $posm){
				if(!empty($_FILES['fimagepos']['name'][$posm->id])){
					$name = $_FILES['fimagepos']['name'][$posm->id];
					$ext = strtoupper(Helper::fileExtension($name));
		            if(!in_array($ext, $this->registry->setting['posm']['imageValidType']))
		            {
		                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
		                $pass = false;
		                break;
		            }
		            elseif($_FILES['fimagepos']['size'][$posm->id] > $this->registry->setting['posm']['imageMaxFileSize'])
		            {
		                $error[] = str_replace('###VALUE###', '( '.$name.' )'.round($this->registry->setting['posm']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
		                $pass = false;
		                break;
		            }
				}
			}
		}

		return $pass;
	}

	private function executeValidation($listprogramposition, &$error, $isedit = false){
		$pass = true;
		if($isedit){
			foreach($listprogramposition as $pp){
				if(!empty($_FILES['fimagepos']['name'][$pp->id])){
					$name = $_FILES['fimagepos']['name'][$pp->id];
					$ext = strtoupper(Helper::fileExtension($name));
			        if(!in_array($ext, $this->registry->setting['posm']['imageValidType']))
			        {
			            $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
			            $pass = false;
			            break;
			        }
			        elseif($_FILES['fimagepos']['size'][$pp->id] > $this->registry->setting['posm']['imageMaxFileSize'])
			        {
			            $error[] = str_replace('###VALUE###', '( '.$name.' )'.round($this->registry->setting['posm']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
			            $pass = false;
			            break;
			        }
				}
			}
		}
		else{
			foreach($_FILES['fimageexecutearr']['name'] as $key=>$name){
				$ext = strtoupper(Helper::fileExtension($name));
	            if(!in_array($ext, $this->registry->setting['posm']['imageValidType']))
	            {
	                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
	                $pass = false;
	                break;
	            }
	            elseif($_FILES['fimageexecutearr']['size'][$key] > $this->registry->setting['posm']['imageMaxFileSize'])
	            {
	                $error[] = str_replace('###VALUE###', '( '.$name.' )'.round($this->registry->setting['posm']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
	                $pass = false;
	                break;
	            }
			}
		}
		return $pass;
	}

	//check quyen la marketing
	public function approveAction(){
		//check quyen la marketing
        if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
        {
            $checker = Core_StoreUser::checkRoleUser(array(
                                                    'fuid' => $this->registry->me->id,
                                                    'frole' => Core_StoreUser::ROLE_MARKETING,
                                                    'fstatus' => Core_StoreUser::STATUS_ENABLE
                                                    ));
            if(!$checker)
            {
                header('location: ' . $this->registry['conf']['rooturl_cms']);
                exit();
            }
        }

		$id = (int)(isset($_POST['id'])?$_POST['id']:0);
		$tp = (int)(isset($_POST['tp'])?$_POST['tp']:0);
		$comment = (string)(isset($_POST['fcomment'])?$_POST['fcomment']:'');
		$myProgramPositionStore = new Core_ProgramPositionStore($id);
		$json_array = array('success' => 2);
		if($myProgramPositionStore->id > 0)
		{
			$myProgramPositionStore->uidapprove = $this->registry->me->id;
			$myProgramPositionStore->isapprove = $tp;
			$myProgramPositionStore->approvenote = $comment;
			$myProgramPositionStore->updateData();
			$json_array['success'] = 1;
		}
		else {
			$json_array['message'] = $this->registry->lang['controller']['errNotFound'];
		}
		echo json_encode($json_array);
	}
}

?>