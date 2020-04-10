<?php

Class Controller_Cms_Internallink Extends Controller_Cms_Base 
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
            if($_SESSION['internallinkBulkToken']==$_POST['ftoken'])
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
                            $myInternallink = new Core_Internallink($id);
                            
                            if($myInternallink->id > 0)
                            {
                                //tien hanh xoa
                                if($myInternallink->delete())
                                {
                                    $deletedItems[] = $myInternallink->id;
                                    $this->registry->me->writelog('internallink_delete', $myInternallink->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myInternallink->id;
                            }
                            else
                                $cannotDeletedItems[] = $myInternallink->id;
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
		
		$_SESSION['internallinkBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Internallink::getInternallinks($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$internallinks = Core_Internallink::getInternallinks($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		$list = array();
		foreach ($internallinks as $seointernal) {
			$option = unserialize($seointernal->setting);
			$seointernal->isarticle = $option['fisarticle'];
			$seointernal->ispage = $option['fispage'];
			$seointernal->isproduct = $option['fisproduct'];
			$seointernal->isevent = $option['fisevent'];
			$seointernal->iscategoy = $option['fiscategoy'];
			$seointernal->isvendor = $option['fisvendor'];
			$list[] = $seointernal;
		}
		$internallinks = $list;
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'internallinks' 	=> $internallinks,
												'statusOptions' => Core_Internallink::getStatusList(),
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
            if($_SESSION['internallinkAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                 
                 $setting = array();
                 $setting['fisarticle'] = $formData['fisarticle'];
                 $setting['fispage'] = $formData['fispage'];
                 $setting['fisproduct'] = $formData['fisproduct'];
                 $setting['fisevent'] = $formData['fisevent'];
                 $setting['fisvendor'] = $formData['fisvendor'];
                 $setting['fisuppercase'] = $formData['fisuppercase'];
                 
                 $setting['fmaxlinkarticle'] = $formData['fmaxlinkarticle'];
                 $setting['fmaxlinkkey']	= $formData['fmaxlinkkey'];
                 $setting['fmaxurlsame']	= $formData['fmaxurlsame'];
                 $setting['ftarget']		= $formData['ftarget'];
                 $setting['fisheading']		= $formData['fisheading'];
                
                if($this->addActionValidator($formData, $error))
                {
                    $myInternallink = new Core_Internallink();

					$myInternallink->setting = serialize($setting);
					$myInternallink->keylink = $formData['fkeylink'];
					$myInternallink->exception = $formData['fexception'];
					$myInternallink->status = $formData['fstatus'];
					
                    if($myInternallink->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('internallink_add', $myInternallink->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['internallinkAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_Internallink::getStatusList(),
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
		$myInternallink = new Core_Internallink($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myInternallink->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myInternallink->id;
			
			$formData['fkeylink'] = $myInternallink->keylink;
			$formData['fexception'] = $myInternallink->exception;
			$formData['fstatus'] = $myInternallink->status;
			$formData['fdatecreated'] = $myInternallink->datecreated;
			$formData['fdatemodified'] = $myInternallink->datemodified;
			
			$unsetting = unserialize($myInternallink->setting);
			$formData['fisarticle'] = $unsetting['fisarticle'];
			$formData['fispage'] = $unsetting['fispage'];
			$formData['fisproduct'] = $unsetting['fisproduct'];
			$formData['fisevent'] = $unsetting['fisevent'];
			$formData['fiscategoy'] = $unsetting['fiscategoy'];
			$formData['fisvendor'] = $unsetting['fisvendor'];
			$formData['fisuppercase'] = $unsetting['fisuppercase'];
			
			$formData['fmaxlinkarticle'] = $unsetting['fmaxlinkarticle'];
			$formData['fmaxlinkkey'] = $unsetting['fmaxlinkkey'];
			$formData['fmaxurlsame'] = $unsetting['fmaxurlsame'];
			$formData['ftarget'] = $unsetting['ftarget'];
			$formData['fisheading'] = $unsetting['fisheading'];
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['internallinkEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    $setting = array();
                    $setting['fisarticle'] 	= $_POST['fisarticle'];
	                $setting['fispage'] 	= $_POST['fispage'];
	                $setting['fisproduct'] 	= $_POST['fisproduct'];
	                $setting['fisevent'] 	= $_POST['fisevent'];
	                $setting['fisvendor'] 	= $_POST['fisvendor'];
	                $setting['fisuppercase']= $_POST['fisuppercase'];
                    
	                $setting['fmaxlinkarticle'] = $_POST['fmaxlinkarticle'];
	                $setting['fmaxlinkkey']		= $_POST['fmaxlinkkey'];
	                $setting['fmaxurlsame']		= $_POST['fmaxurlsame'];
	                $setting['ftarget']			= $_POST['ftarget'];
	                $setting['fisheading']		= $_POST['fisheading'];
	                
	                // gan lai formdata
	                $formData['fisarticle'] = $setting['fisarticle'];
					$formData['fispage'] = $setting['fispage'];
					$formData['fisproduct'] = $setting['fisproduct'];
					$formData['fisevent'] = $setting['fisevent'];
					$formData['fiscategoy'] = $setting['fiscategoy'];
					$formData['fisvendor'] = $setting['fisvendor'];
					$formData['fisuppercase'] = $setting['fisuppercase'];
					
					$formData['fmaxlinkarticle'] = $setting['fmaxlinkarticle'];
					$formData['fmaxlinkkey'] = $setting['fmaxlinkkey'];
					$formData['fmaxurlsame'] = $setting['fmaxurlsame'];
					$formData['ftarget'] = $setting['ftarget'];
					$formData['fisheading'] = $setting['fisheading'];
	                
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myInternallink->setting = serialize($setting);
						$myInternallink->keylink = $formData['fkeylink'];
						$myInternallink->exception = $formData['fexception'];
						$myInternallink->status = $formData['fstatus'];
                        
                        if($myInternallink->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('internallink_edit', $myInternallink->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['internallinkEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_Internallink::getStatusList(),
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
		$myInternallink = new Core_Internallink($id);
		if($myInternallink->id > 0)
		{
			//tien hanh xoa
			if($myInternallink->delete())
			{
				$redirectMsg = str_replace('###id###', $myInternallink->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('internallink_delete', $myInternallink->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myInternallink->id, $this->registry->lang['controller']['errDelete']);
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
