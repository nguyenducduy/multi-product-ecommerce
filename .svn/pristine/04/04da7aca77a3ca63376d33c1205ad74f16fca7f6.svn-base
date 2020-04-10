<?php

Class Controller_Cms_PageReviewThumb Extends Controller_Cms_Base 
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
		
		
		$robjectidFilter = (int)($this->registry->router->getArg('robjectid'));
		$ridFilter = (int)($this->registry->router->getArg('rid'));
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$valueFilter = (int)($this->registry->router->getArg('value'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
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
            if($_SESSION['pagereviewthumbBulkToken']==$_POST['ftoken'])
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
                            $myPageReviewThumb = new Core_PageReviewThumb($id);
                            
                            if($myPageReviewThumb->id > 0)
                            {
                                //tien hanh xoa
                                if($myPageReviewThumb->delete())
                                {
                                    $deletedItems[] = $myPageReviewThumb->id;
                                    $this->registry->me->writelog('pagereviewthumb_delete', $myPageReviewThumb->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPageReviewThumb->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPageReviewThumb->id;
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
		
		$_SESSION['pagereviewthumbBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($robjectidFilter > 0)
		{
			$paginateUrl .= 'robjectid/'.$robjectidFilter . '/';
			$formData['frobjectid'] = $robjectidFilter;
			$formData['search'] = 'robjectid';
		}

		if($ridFilter > 0)
		{
			$paginateUrl .= 'rid/'.$ridFilter . '/';
			$formData['frid'] = $ridFilter;
			$formData['search'] = 'rid';
		}

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($valueFilter > 0)
		{
			$paginateUrl .= 'value/'.$valueFilter . '/';
			$formData['fvalue'] = $valueFilter;
			$formData['search'] = 'value';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_PageReviewThumb::getPageReviewThumbs($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$pagereviewthumbs = Core_PageReviewThumb::getPageReviewThumbs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'pagereviewthumbs' 	=> $pagereviewthumbs,
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
            if($_SESSION['pagereviewthumbAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPageReviewThumb = new Core_PageReviewThumb();

					
					$myPageReviewThumb->robjectid = $formData['frobjectid'];
					$myPageReviewThumb->rid = $formData['frid'];
					$myPageReviewThumb->uid = $formData['fuid'];
					$myPageReviewThumb->value = $formData['fvalue'];
					$myPageReviewThumb->ipaddress = $formData['fipaddress'];
					
                    if($myPageReviewThumb->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('pagereviewthumb_add', $myPageReviewThumb->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['pagereviewthumbAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myPageReviewThumb = new Core_PageReviewThumb($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPageReviewThumb->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['frobjectid'] = $myPageReviewThumb->robjectid;
			$formData['frid'] = $myPageReviewThumb->rid;
			$formData['fuid'] = $myPageReviewThumb->uid;
			$formData['fid'] = $myPageReviewThumb->id;
			$formData['fvalue'] = $myPageReviewThumb->value;
			$formData['fipaddress'] = $myPageReviewThumb->ipaddress;
			$formData['fdatecreated'] = $myPageReviewThumb->datecreated;
			$formData['fdatemodified'] = $myPageReviewThumb->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['pagereviewthumbEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPageReviewThumb->robjectid = $formData['frobjectid'];
						$myPageReviewThumb->rid = $formData['frid'];
						$myPageReviewThumb->uid = $formData['fuid'];
						$myPageReviewThumb->value = $formData['fvalue'];
						$myPageReviewThumb->ipaddress = $formData['fipaddress'];
                        
                        if($myPageReviewThumb->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('pagereviewthumb_edit', $myPageReviewThumb->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['pagereviewthumbEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myPageReviewThumb = new Core_PageReviewThumb($id);
		if($myPageReviewThumb->id > 0)
		{
			//tien hanh xoa
			if($myPageReviewThumb->delete())
			{
				$redirectMsg = str_replace('###id###', $myPageReviewThumb->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('pagereviewthumb_delete', $myPageReviewThumb->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPageReviewThumb->id, $this->registry->lang['controller']['errDelete']);
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

