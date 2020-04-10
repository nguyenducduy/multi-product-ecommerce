<?php

Class Controller_{{CONTROLLERGROUP}}_{{MODULE_SIMPLIFY}} Extends Controller_{{CONTROLLERGROUP}}_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken'] = Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		{{FILTERABLE_GET_ARGUMENTS}}
		{{SEARCHABLETEXT_GET_ARGUMENTS}}
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = '{{PRIMARY_PROPERTY}}';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['{{MODULE_LOWER}}BulkToken']==$_POST['ftoken'])
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
                            $my{{MODULE_SIMPLIFY}} = new Core_{{MODULE}}($id);
                            
                            if($my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}} > 0)
                            {
                                //tien hanh xoa
                                if($my{{MODULE_SIMPLIFY}}->delete())
                                {
                                    $deletedItems[] = $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}};
                                    $this->registry->me->writelog('{{MODULE_LOWER}}_delete', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}};
                            }
                            else
                                $cannotDeletedItems[] = $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}};
                        }
                        
                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###{{PRIMARY_PROPERTY}}###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
                        
                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###{{PRIMARY_PROPERTY}}###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }
			
		}
		
		$_SESSION['{{MODULE_LOWER}}BulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		{{FILTERABLE_APPLY_FORMDATA}}
		{{SEARCHABLETEXT_APPLY_FORMDATA}}
				
		//tim tong so
		$total = Core_{{MODULE}}::get{{MODULE_SIMPLIFY}}s($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		${{MODULE_LOWER}}s = Core_{{MODULE}}::get{{MODULE_SIMPLIFY}}s($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'{{MODULE_LOWER}}s' 	=> ${{MODULE_LOWER}}s,{{CONSTANT_CONTROLLER_ASSIGN}}
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
            if($_SESSION['{{MODULE_LOWER}}AddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $my{{MODULE_SIMPLIFY}} = new Core_{{MODULE}}();

					{{ADD_ASSIGN_PROPERTY}}
					
                    if($my{{MODULE_SIMPLIFY}}->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('{{MODULE_LOWER}}_add', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['{{MODULE_LOWER}}AddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,{{CONSTANT_CONTROLLER_ASSIGN}}
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
		${{PRIMARY_PROPERTY}} = (int)$this->registry->router->getArg('{{PRIMARY_PROPERTY}}');
		$my{{MODULE_SIMPLIFY}} = new Core_{{MODULE}}(${{PRIMARY_PROPERTY}});
		
		$redirectUrl = $this->getRedirectUrl();
		if($my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}} > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			{{EDIT_FORMDATA_INIT}}
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['{{MODULE_LOWER}}EditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						{{EDIT_ASSIGN_PROPERTY}}
                        
                        if($my{{MODULE_SIMPLIFY}}->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('{{MODULE_LOWER}}_edit', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['{{MODULE_LOWER}}EditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,{{CONSTANT_CONTROLLER_ASSIGN}}
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
		${{PRIMARY_PROPERTY}} = (int)$this->registry->router->getArg('{{PRIMARY_PROPERTY}}');
		$my{{MODULE_SIMPLIFY}} = new Core_{{MODULE}}(${{PRIMARY_PROPERTY}});
		if($my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}} > 0)
		{
			//tien hanh xoa
			if($my{{MODULE_SIMPLIFY}}->delete())
			{
				$redirectMsg = str_replace('###{{PRIMARY_PROPERTY}}###', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('{{MODULE_LOWER}}_delete', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###{{PRIMARY_PROPERTY}}###', $my{{MODULE_SIMPLIFY}}->{{PRIMARY_PROPERTY}}, $this->registry->lang['controller']['errDelete']);
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
		
		{{ADD_VALIDATOR}}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		{{EDIT_VALIDATOR}}
				
		return $pass;
	}
}
