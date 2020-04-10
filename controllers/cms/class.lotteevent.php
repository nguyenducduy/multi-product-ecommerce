<?php

Class Controller_Cms_LotteEvent Extends Controller_Cms_Base 
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
		$datebeginFilter = (int)($this->registry->router->getArg('datebegin'));
		$dateendFilter = (int)($this->registry->router->getArg('dateend'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$pageidFilter = (int)($this->registry->router->getArg('pageid'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$datemodifiedFilter = (int)($this->registry->router->getArg('datemodified'));
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
            if($_SESSION['lotteeventBulkToken']==$_POST['ftoken'])
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
                            $myLotteEvent = new Core_LotteEvent($id);
                            
                            if($myLotteEvent->id > 0)
                            {
                                //tien hanh xoa
                                if($myLotteEvent->delete())
                                {
                                    $deletedItems[] = $myLotteEvent->id;
                                    $this->registry->me->writelog('lotteevent_delete', $myLotteEvent->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myLotteEvent->id;
                            }
                            else
                                $cannotDeletedItems[] = $myLotteEvent->id;
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
		
		$_SESSION['lotteeventBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($datebeginFilter > 0)
		{
			$paginateUrl .= 'datebegin/'.$datebeginFilter . '/';
			$formData['fdatebegin'] = $datebeginFilter;
			$formData['search'] = 'datebegin';
		}

		if($dateendFilter > 0)
		{
			$paginateUrl .= 'dateend/'.$dateendFilter . '/';
			$formData['fdateend'] = $dateendFilter;
			$formData['search'] = 'dateend';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($pageidFilter > 0)
		{
			$paginateUrl .= 'pageid/'.$pageidFilter . '/';
			$formData['fpageid'] = $pageidFilter;
			$formData['search'] = 'pageid';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($datemodifiedFilter > 0)
		{
			$paginateUrl .= 'datemodified/'.$datemodifiedFilter . '/';
			$formData['fdatemodified'] = $datemodifiedFilter;
			$formData['search'] = 'datemodified';
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
		$total = Core_LotteEvent::getLotteEvents($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$lotteevents = Core_LotteEvent::getLotteEvents($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'lotteevents' 	=> $lotteevents,
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
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['lotteeventAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myLotteEvent = new Core_LotteEvent();

					
					$myLotteEvent->name = $formData['fname'];
					$myLotteEvent->datebegin = Helper::strtotimedmy($formData['fdatebegin']);
					$myLotteEvent->dateend = Helper::strtotimedmy($formData['fdateend']);
					$myLotteEvent->status = $formData['fstatus'];
					$myLotteEvent->pageid = $formData['fpageid'];
					
                    if($myLotteEvent->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('lotteevent_add', $myLotteEvent->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['lotteeventAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myLotteEvent = new Core_LotteEvent($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myLotteEvent->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myLotteEvent->id;
			$formData['fname'] = $myLotteEvent->name;
			$formData['fdatebegin'] = date('d/m/Y',$myLotteEvent->datebegin);
			$formData['fdateend'] = date('d/m/Y',$myLotteEvent->dateend);
			$formData['fstatus'] = $myLotteEvent->status;
			$formData['fpageid'] = $myLotteEvent->pageid;
			$formData['fdatecreated'] = $myLotteEvent->datecreated;
			$formData['fdatemodified'] = $myLotteEvent->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['lotteeventEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {
						
						$myLotteEvent->name = $formData['fname'];
						$myLotteEvent->datebegin = Helper::strtotimedmy($formData['fdatebegin']);
						$myLotteEvent->dateend = Helper::strtotimedmy($formData['fdateend']);
						$myLotteEvent->status = $formData['fstatus'];
						$myLotteEvent->pageid = $formData['fpageid'];
                        
                        if($myLotteEvent->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('lotteevent_edit', $myLotteEvent->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['lotteeventEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myLotteEvent = new Core_LotteEvent($id);
		if($myLotteEvent->id > 0)
		{
			//tien hanh xoa
			if($myLotteEvent->delete())
			{
				$redirectMsg = str_replace('###id###', $myLotteEvent->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('lotteevent_delete', $myLotteEvent->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myLotteEvent->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fdatebegin'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDatebeginRequired'];
			$pass = false;
		}

		if($formData['fdateend'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDateendRequired'];
			$pass = false;
		}

		if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
		}

		if($formData['fpageid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPageidRequired'];
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

		if($formData['fdatebegin'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDatebeginRequired'];
			$pass = false;
		}

		if($formData['fdateend'] == '')
		{
			$error[] = $this->registry->lang['controller']['errDateendRequired'];
			$pass = false;
		}

		if($formData['fstatus'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStatusRequired'];
			$pass = false;
		}

		if($formData['fpageid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPageidRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

