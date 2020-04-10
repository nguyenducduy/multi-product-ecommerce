<?php

Class Controller_Cms_Posm Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
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
        
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
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
            if($_SESSION['posmBulkToken']==$_POST['ftoken'])
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
                            $myPosm = new Core_Posm($id);
                            
                            if($myPosm->id > 0)
                            {
                                //tien hanh xoa
                                if($myPosm->delete())
                                {
                                    $deletedItems[] = $myPosm->id;
                                    $this->registry->me->writelog('posm_delete', $myPosm->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPosm->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPosm->id;
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
		
		$_SESSION['posmBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
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
		$total = Core_Posm::getPosms($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$posms = Core_Posm::getPosms($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'posms' 	=> $posms,
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
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['posmAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPosm = new Core_Posm();

					
					$myPosm->name = $formData['fname'];
					$myPosm->codeimage = $formData['fcodeimage'];
					
                    if($myPosm->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('posm_add', $myPosm->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['posmAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myPosm = new Core_Posm($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPosm->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myPosm->id;
			$formData['fname'] = $myPosm->name;
			$formData['fcodeimage'] = $myPosm->codeimage;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['posmEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPosm->name = $formData['fname'];
						$myPosm->codeimage = $formData['fcodeimage'];
                        
                        if($myPosm->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('posm_edit', $myPosm->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['posmEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myPosm = new Core_Posm($id);
		if($myPosm->id > 0)
		{
			//tien hanh xoa
			if($myPosm->delete())
			{
				$redirectMsg = str_replace('###id###', $myPosm->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('posm_delete', $myPosm->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPosm->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['fcodeimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCodeimageRequired'];
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

		if($formData['fcodeimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCodeimageRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>