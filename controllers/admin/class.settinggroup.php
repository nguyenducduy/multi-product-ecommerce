<?php

Class Controller_Admin_Settinggroup Extends Controller_Admin_Base 
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
		$identifierFilter = (string)($this->registry->router->getArg('identifier'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'displayorder';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['settinggroupBulkToken']==$_POST['ftoken'])
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
                            $mySettinggroup = new Core_Settinggroup($id);
                            
                            if($mySettinggroup->id > 0)
                            {
                                //tien hanh xoa
                                if($mySettinggroup->delete())
                                {
                                    $deletedItems[] = $mySettinggroup->id;
                                    $this->registry->me->writelog('settinggroup_delete', $mySettinggroup->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $mySettinggroup->id;
                            }
                            else
                                $cannotDeletedItems[] = $mySettinggroup->id;
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
				$myItem = new Core_Settinggroup($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}
			
			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}
		
		
		$_SESSION['settinggroupBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($identifierFilter != "")
		{
			$paginateUrl .= 'identifier/'.$identifierFilter . '/';
			$formData['fidentifier'] = $identifierFilter;
			$formData['search'] = 'identifier';
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

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Settinggroup::getSettinggroups($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$settinggroups = Core_Settinggroup::getSettinggroups($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		for($i = 0; $i < count($settinggroups); $i++)
		{
			$settinggroups[$i]->countsetting = Core_Settingentry::getSettingentrys(array('fsgid' => $settinggroups[$i]->id), '', '', '', true);
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
		
				
		$this->registry->smarty->assign(array(	'settinggroups' 	=> $settinggroups,
												'statusList'	=> Core_Settinggroup::getStatusList(),
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
            if($_SESSION['settinggroupAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $mySettinggroup = new Core_Settinggroup();

					$mySettinggroup->uid = $this->registry->me->id;
					$mySettinggroup->name = $formData['fname'];
					$mySettinggroup->description = $formData['fdescription'];
					$mySettinggroup->identifier = preg_replace('/[^a-z]/', '', strtolower($formData['fidentifier']));
					$mySettinggroup->status = $formData['fstatus'];
					
                    if($mySettinggroup->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('settinggroup_add', $mySettinggroup->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['settinggroupAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusList'	=> Core_Settinggroup::getStatusList(),
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
		$mySettinggroup = new Core_Settinggroup($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($mySettinggroup->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $mySettinggroup->uid;
			$formData['fid'] = $mySettinggroup->id;
			$formData['fname'] = $mySettinggroup->name;
			$formData['fdescription'] = $mySettinggroup->description;
			$formData['fidentifier'] = $mySettinggroup->identifier;
			$formData['fstatus'] = $mySettinggroup->status;
			$formData['fdisplayorder'] = $mySettinggroup->displayorder;
			$formData['fdatecreated'] = $mySettinggroup->datecreated;
			$formData['fdatemodified'] = $mySettinggroup->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['settinggroupEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$mySettinggroup->name = $formData['fname'];
						$mySettinggroup->description = $formData['fdescription'];
						$mySettinggroup->identifier = preg_replace('/[^a-z]/', '', strtolower($formData['fidentifier']));
						$mySettinggroup->status = $formData['fstatus'];
						$mySettinggroup->displayorder = $formData['fdisplayorder'];
                        
                        if($mySettinggroup->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('settinggroup_edit', $mySettinggroup->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['settinggroupEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'statusList'	=> Core_Settinggroup::getStatusList(),
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
		$mySettinggroup = new Core_Settinggroup($id);
		if($mySettinggroup->id > 0)
		{
			//tien hanh xoa
			if($mySettinggroup->delete())
			{
				$redirectMsg = str_replace('###id###', $mySettinggroup->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('settinggroup_delete', $mySettinggroup->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $mySettinggroup->id, $this->registry->lang['controller']['errDelete']);
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

