<?php

Class Controller_Cms_EmailBlacklit Extends Controller_Cms_Base 
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
		
		
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$sourceFilter = (string)($this->registry->router->getArg('source'));
		$metadataFilter = (string)($this->registry->router->getArg('metadata'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
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
            if($_SESSION['emailblacklitBulkToken']==$_POST['ftoken'])
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
                            $myEmailBlacklit = new Core_EmailBlacklit($id);
                            
                            if($myEmailBlacklit->id > 0)
                            {
                                //tien hanh xoa
                                if($myEmailBlacklit->delete())
                                {
                                    $deletedItems[] = $myEmailBlacklit->id;
                                    $this->registry->me->writelog('emailblacklit_delete', $myEmailBlacklit->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myEmailBlacklit->id;
                            }
                            else
                                $cannotDeletedItems[] = $myEmailBlacklit->id;
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
		
		$_SESSION['emailblacklitBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($sourceFilter != "")
		{
			$paginateUrl .= 'source/'.$sourceFilter . '/';
			$formData['fsource'] = $sourceFilter;
			$formData['search'] = 'source';
		}

		if($metadataFilter != "")
		{
			$paginateUrl .= 'metadata/'.$metadataFilter . '/';
			$formData['fmetadata'] = $metadataFilter;
			$formData['search'] = 'metadata';
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
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'metadata')
			{
				$paginateUrl .= 'searchin/metadata/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_EmailBlacklit::getEmailBlacklits($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$emailblacklits = Core_EmailBlacklit::getEmailBlacklits($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'emailblacklits' 	=> $emailblacklits,
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
            if($_SESSION['emailblacklitAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myEmailBlacklit = new Core_EmailBlacklit();

					
					$myEmailBlacklit->email = $formData['femail'];
					$myEmailBlacklit->type = $formData['ftype'];
					$myEmailBlacklit->source = $formData['fsource'];
					$myEmailBlacklit->metadata = $formData['fmetadata'];
					$myEmailBlacklit->status = $formData['fstatus'];
					
                    if($myEmailBlacklit->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('emailblacklit_add', $myEmailBlacklit->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['emailblacklitAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myEmailBlacklit = new Core_EmailBlacklit($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myEmailBlacklit->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myEmailBlacklit->id;
			$formData['femail'] = $myEmailBlacklit->email;
			$formData['ftype'] = $myEmailBlacklit->type;
			$formData['fsource'] = $myEmailBlacklit->source;
			$formData['fmetadata'] = $myEmailBlacklit->metadata;
			$formData['fstatus'] = $myEmailBlacklit->status;
			$formData['fdatecreated'] = $myEmailBlacklit->datecreated;
			$formData['fdatemodified'] = $myEmailBlacklit->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['emailblacklitEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myEmailBlacklit->email = $formData['femail'];
						$myEmailBlacklit->type = $formData['ftype'];
						$myEmailBlacklit->source = $formData['fsource'];
						$myEmailBlacklit->metadata = $formData['fmetadata'];
						$myEmailBlacklit->status = $formData['fstatus'];
                        
                        if($myEmailBlacklit->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('emailblacklit_edit', $myEmailBlacklit->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['emailblacklitEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myEmailBlacklit = new Core_EmailBlacklit($id);
		if($myEmailBlacklit->id > 0)
		{
			//tien hanh xoa
			if($myEmailBlacklit->delete())
			{
				$redirectMsg = str_replace('###id###', $myEmailBlacklit->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('emailblacklit_delete', $myEmailBlacklit->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myEmailBlacklit->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if(Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['ftype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fsource'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSourceRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if(Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['ftype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fsource'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSourceRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>