<?php

Class Controller_Admin_Settingentry Extends Controller_Admin_Base 
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
		$sgidFilter = (int)($this->registry->router->getArg('sgid'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$descriptionFilter = (string)($this->registry->router->getArg('description'));
		$identifierFilter = (string)($this->registry->router->getArg('identifier'));
		$valueFilter = (string)($this->registry->router->getArg('value'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['settingentryBulkToken']==$_POST['ftoken'])
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
                            $mySettingentry = new Core_Settingentry($id);
                            
                            if($mySettingentry->id > 0)
                            {
                                //tien hanh xoa
                                if($mySettingentry->delete())
                                {
                                    $deletedItems[] = $mySettingentry->id;
                                    $this->registry->me->writelog('settingentry_delete', $mySettingentry->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $mySettingentry->id;
                            }
                            else
                                $cannotDeletedItems[] = $mySettingentry->id;
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
		
		$_SESSION['settingentryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($sgidFilter > 0)
		{
			$paginateUrl .= 'sgid/'.$sgidFilter . '/';
			$formData['fsgid'] = $sgidFilter;
			$formData['search'] = 'sgid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($descriptionFilter != "")
		{
			$paginateUrl .= 'description/'.$descriptionFilter . '/';
			$formData['fdescription'] = $descriptionFilter;
			$formData['search'] = 'description';
		}

		if($identifierFilter != "")
		{
			$paginateUrl .= 'identifier/'.$identifierFilter . '/';
			$formData['fidentifier'] = $identifierFilter;
			$formData['search'] = 'identifier';
		}

		if($valueFilter != "")
		{
			$paginateUrl .= 'value/'.$valueFilter . '/';
			$formData['fvalue'] = $valueFilter;
			$formData['search'] = 'value';
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

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Settingentry::getSettingentrys($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$settingentrys = Core_Settingentry::getSettingentrys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'settingentrys' 	=> $settingentrys,
												'formData'		=> $formData,
												'settinggroupList' => Core_Settinggroup::getSettinggroups(array(), 'displayorder', 'ASC'),
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
		
		if($this->registry->router->getArg('id') > 0)
		{
			$formData['fsgid'] = (int)$this->registry->router->getArg('id');
		}
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['settingentryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $mySettingentry = new Core_Settingentry();

					
					$mySettingentry->sgid = $formData['fsgid'];
					$mySettingentry->name = $formData['fname'];
					$mySettingentry->description = $formData['fdescription'];
					$mySettingentry->identifier = $formData['fidentifier'];
					$mySettingentry->value = $formData['fvalue'];
					$mySettingentry->displayorder = $formData['fdisplayorder'];
					$mySettingentry->status = $formData['fstatus'];
					
                    if($mySettingentry->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('settingentry_add', $mySettingentry->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['settingentryAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'settinggroupList' => Core_Settinggroup::getSettinggroups(array(), 'displayorder', 'ASC'),
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
		$mySettingentry = new Core_Settingentry($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($mySettingentry->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $mySettingentry->uid;
			$formData['fsgid'] = $mySettingentry->sgid;
			$formData['fid'] = $mySettingentry->id;
			$formData['fname'] = $mySettingentry->name;
			$formData['fdescription'] = $mySettingentry->description;
			$formData['fidentifier'] = $mySettingentry->identifier;
			$formData['fvalue'] = $mySettingentry->value;
			$formData['fdisplayorder'] = $mySettingentry->displayorder;
			$formData['fstatus'] = $mySettingentry->status;
			$formData['fdatecreated'] = $mySettingentry->datecreated;
			$formData['fdatemodified'] = $mySettingentry->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['settingentryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$mySettingentry->sgid = $formData['fsgid'];
						$mySettingentry->name = $formData['fname'];
						$mySettingentry->description = $formData['fdescription'];
						$mySettingentry->identifier = $formData['fidentifier'];
						$mySettingentry->value = $formData['fvalue'];
						$mySettingentry->displayorder = $formData['fdisplayorder'];
						$mySettingentry->status = $formData['fstatus'];
                        
                        if($mySettingentry->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('settingentry_edit', $mySettingentry->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['settingentryEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'settinggroupList' => Core_Settinggroup::getSettinggroups(array(), 'displayorder', 'ASC'),
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
		$mySettingentry = new Core_Settingentry($id);
		if($mySettingentry->id > 0)
		{
			//tien hanh xoa
			if($mySettingentry->delete())
			{
				$redirectMsg = str_replace('###id###', $mySettingentry->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('settingentry_delete', $mySettingentry->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $mySettingentry->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
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

		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

