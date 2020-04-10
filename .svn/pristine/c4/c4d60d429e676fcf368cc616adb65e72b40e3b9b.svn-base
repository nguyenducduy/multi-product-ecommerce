<?php

Class Controller_Cms_Notpermissionlink Extends Controller_Cms_Base 
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
		$sessionidFilter = (string)($this->registry->router->getArg('sessionid'));
		$refererFilter = (string)($this->registry->router->getArg('referer'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
		$useragentFilter = (string)($this->registry->router->getArg('useragent'));
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
            if($_SESSION['notpermissionlinkBulkToken']==$_POST['ftoken'])
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
                            $myNotpermissionlink = new Core_Backend_Notpermissionlink($id);
                            
                            if($myNotpermissionlink->id > 0)
                            {
                                //tien hanh xoa
                                if($myNotpermissionlink->delete())
                                {
                                    $deletedItems[] = $myNotpermissionlink->id;
                                    $this->registry->me->writelog('notpermissionlink_delete', $myNotpermissionlink->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myNotpermissionlink->id;
                            }
                            else
                                $cannotDeletedItems[] = $myNotpermissionlink->id;
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
		
		$_SESSION['notpermissionlinkBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($sessionidFilter != "")
		{
			$paginateUrl .= 'sessionid/'.$sessionidFilter . '/';
			$formData['fsessionid'] = $sessionidFilter;
			$formData['search'] = 'sessionid';
		}

		if($refererFilter != "")
		{
			$paginateUrl .= 'referer/'.$refererFilter . '/';
			$formData['freferer'] = $refererFilter;
			$formData['search'] = 'referer';
		}

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
		}

		if($useragentFilter != "")
		{
			$paginateUrl .= 'useragent/'.$useragentFilter . '/';
			$formData['fuseragent'] = $useragentFilter;
			$formData['search'] = 'useragent';
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

			if($searchKeywordIn == 'sessionid')
			{
				$paginateUrl .= 'searchin/sessionid/';
			}
			elseif($searchKeywordIn == 'referer')
			{
				$paginateUrl .= 'searchin/referer/';
			}
			elseif($searchKeywordIn == 'useragent')
			{
				$paginateUrl .= 'searchin/useragent/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_Notpermissionlink::getNotpermissionlinks($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$notpermissionlinks = Core_Backend_Notpermissionlink::getNotpermissionlinks($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'notpermissionlinks' 	=> $notpermissionlinks,
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
            if($_SESSION['notpermissionlinkAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myNotpermissionlink = new Core_Backend_Notpermissionlink();

					
					$myNotpermissionlink->uid = $formData['fuid'];
					$myNotpermissionlink->sessionid = $formData['fsessionid'];
					$myNotpermissionlink->referer = $formData['freferer'];
					$myNotpermissionlink->ipaddress = getIpAddress(true);
					$myNotpermissionlink->useragent = $formData['fuseragent'];
					
                    if($myNotpermissionlink->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('notpermissionlink_add', $myNotpermissionlink->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['notpermissionlinkAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myNotpermissionlink = new Core_Backend_Notpermissionlink($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myNotpermissionlink->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myNotpermissionlink->uid;
			$formData['fid'] = $myNotpermissionlink->id;
			$formData['fsessionid'] = $myNotpermissionlink->sessionid;
			$formData['freferer'] = $myNotpermissionlink->referer;
			$formData['fipaddress'] = $myNotpermissionlink->ipaddress;
			$formData['fuseragent'] = $myNotpermissionlink->useragent;
			$formData['fdatecreated'] = $myNotpermissionlink->datecreated;
			$formData['fdatemodified'] = $myNotpermissionlink->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['notpermissionlinkEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myNotpermissionlink->uid = $formData['fuid'];
						$myNotpermissionlink->sessionid = $formData['fsessionid'];
						$myNotpermissionlink->referer = $formData['freferer'];
						$myNotpermissionlink->ipaddress = getIpAddress(true);
						$myNotpermissionlink->useragent = $formData['fuseragent'];
                        
                        if($myNotpermissionlink->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('notpermissionlink_edit', $myNotpermissionlink->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['notpermissionlinkEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myNotpermissionlink = new Core_Backend_Notpermissionlink($id);
		if($myNotpermissionlink->id > 0)
		{
			//tien hanh xoa
			if($myNotpermissionlink->delete())
			{
				$redirectMsg = str_replace('###id###', $myNotpermissionlink->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('notpermissionlink_delete', $myNotpermissionlink->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myNotpermissionlink->id, $this->registry->lang['controller']['errDelete']);
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
		
		
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		
				
		return $pass;
	}
}

?>