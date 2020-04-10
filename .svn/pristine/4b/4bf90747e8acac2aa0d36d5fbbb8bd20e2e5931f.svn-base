<?php

Class Controller_Cms_RelItemKeyword Extends Controller_Cms_Base 
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
		
		
		$kidFilter = (int)($this->registry->router->getArg('kid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
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
            if($_SESSION['relitemkeywordBulkToken']==$_POST['ftoken'])
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
                            $myRelItemKeyword = new Core_RelItemKeyword($id);
                            
                            if($myRelItemKeyword->id > 0)
                            {
                                //tien hanh xoa
                                if($myRelItemKeyword->delete())
                                {
                                    $deletedItems[] = $myRelItemKeyword->id;
                                    $this->registry->me->writelog('relitemkeyword_delete', $myRelItemKeyword->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myRelItemKeyword->id;
                            }
                            else
                                $cannotDeletedItems[] = $myRelItemKeyword->id;
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
		
		$_SESSION['relitemkeywordBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($kidFilter > 0)
		{
			$paginateUrl .= 'kid/'.$kidFilter . '/';
			$formData['fkid'] = $kidFilter;
			$formData['search'] = 'kid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
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
		$total = Core_RelItemKeyword::getRelItemKeywords($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$relitemkeywords = Core_RelItemKeyword::getRelItemKeywords($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'relitemkeywords' 	=> $relitemkeywords,
												'formData'		=> $formData,
												'typeList'		=> Core_RelItemKeyword::getTypeList(),
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
            if($_SESSION['relitemkeywordAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myRelItemKeyword = new Core_RelItemKeyword();

					
					$myRelItemKeyword->type = $formData['ftype'];
					$myRelItemKeyword->objectid = $formData['fobjectid'];
					
                    if($myRelItemKeyword->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('relitemkeyword_add', $myRelItemKeyword->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['relitemkeywordAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'typeList'		=> Core_RelItemKeyword::getTypeList(),
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
		$myRelItemKeyword = new Core_RelItemKeyword($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myRelItemKeyword->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fkid'] = $myRelItemKeyword->kid;
			$formData['fid'] = $myRelItemKeyword->id;
			$formData['ftype'] = $myRelItemKeyword->type;
			$formData['fobjectid'] = $myRelItemKeyword->objectid;
			$formData['fdisplayorder'] = $myRelItemKeyword->displayorder;
			$formData['fdatecreated'] = $myRelItemKeyword->datecreated;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['relitemkeywordEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myRelItemKeyword->type = $formData['ftype'];
						$myRelItemKeyword->objectid = $formData['fobjectid'];
						$myRelItemKeyword->displayorder = $formData['fdisplayorder'];
                        
                        if($myRelItemKeyword->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('relitemkeyword_edit', $myRelItemKeyword->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['relitemkeywordEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'typeList'		=> Core_RelItemKeyword::getTypeList(),
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
		$myRelItemKeyword = new Core_RelItemKeyword($id);
		if($myRelItemKeyword->id > 0)
		{
			//tien hanh xoa
			if($myRelItemKeyword->delete())
			{
				$redirectMsg = str_replace('###id###', $myRelItemKeyword->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('relitemkeyword_delete', $myRelItemKeyword->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myRelItemKeyword->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['ftype'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		if($formData['fobjectid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errObjectidRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftype'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		if($formData['fobjectid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errObjectidRequired'];
			$pass = false;
		}

		return $pass;
	}
}

