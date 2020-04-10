<?php

Class Controller_Cms_ProductGuess Extends Controller_Cms_Base 
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
		
		
		$pidFilter = (int)($this->registry->router->getArg('pid'));
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
            if($_SESSION['productguessBulkToken']==$_POST['ftoken'])
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
                            $myProductGuess = new Core_ProductGuess($id);
                            
                            if($myProductGuess->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductGuess->delete())
                                {
                                    $deletedItems[] = $myProductGuess->id;
                                    $this->registry->me->writelog('productguess_delete', $myProductGuess->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myProductGuess->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductGuess->id;
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
		
		$_SESSION['productguessBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
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
		$total = Core_ProductGuess::getProductGuesss($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$productguesss = Core_ProductGuess::getProductGuesss($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'productguesss' 	=> $productguesss,
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
            if($_SESSION['productguessAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);
                $product = new Core_Product($formData['fpid']);
                if($product->id > 0)
                {
                                
	                if($this->addActionValidator($formData, $error))
	                {
	                    $myProductGuess = new Core_ProductGuess();
	
						$myProductGuess->uid = $this->registry->me->id;
						$myProductGuess->pid = $formData['fpid'];
						$myProductGuess->name = $formData['fname'];
						$myProductGuess->infogift = $formData['finfogift'];
						$myProductGuess->rule = $formData['frule'];
						$myProductGuess->blockhtml = $formData['fblockhtml'];
						$myProductGuess->blocknews = $formData['fblocknews'];
						$myProductGuess->blockuser = $formData['fblockuser'];
						$myProductGuess->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
						$myProductGuess->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
						$myProductGuess->oldonsitestatus = Core_Product::OS_COMMINGSOON;
						$myProductGuess->status = $formData['fstatus'];
						
	                    if($myProductGuess->addData())
	                    {
	                    	$product->onsitestatus = Core_Product::OS_DOANGIA;
	                    	if($product->updateData())
	                    	{
		                        $success[] = $this->registry->lang['controller']['succAdd'];
		                        $this->registry->me->writelog('productguess_add', $myProductGuess->id, array());
		                        $formData = array();  
	                    	}    
	                    }
	                    else
	                    {
	                        $error[] = $this->registry->lang['controller']['errAdd'];            
	                    }
	                }
                }
                else
	            {
	            	$error[] = $this->registry->lang['controller']['errPid'];
	            }
            }
            
		}
		
		$_SESSION['productguessAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'	=> Core_ProductGuess::getStatusList(),
												
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
		$myProductGuess = new Core_ProductGuess($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myProductGuess->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myProductGuess->uid;
			$formData['fpid'] = $myProductGuess->pid;
			$formData['fid'] = $myProductGuess->id;	
			$formData['fname'] = $myProductGuess->name;
			$formData['finfogift'] = $myProductGuess->infogift;
			$formData['frule'] = $myProductGuess->rule;
			$formData['fblockhtml'] = $myProductGuess->blockhtml;
			$formData['fblocknews'] = $myProductGuess->blocknews;
			$formData['fblockuser'] = $myProductGuess->blockuser;
			
			
			$starttime = date("d/m/Y H:i:s",$myProductGuess->starttime);
			$starttime = explode(" ", $starttime);
			$formData['fstarttime'] = $starttime[0];
			$formData['fsttime'] = $starttime[1];

			$expiretime = date("d/m/Y H:i:s",$myProductGuess->expiretime);
			$expiretime = explode(" ", $expiretime);
			$formData['fexpiretime'] = $expiretime[0];
			$formData['fextime'] = $expiretime[1];
			
			$formData['foldonsitestatus'] = $myProductGuess->oldonsitestatus;
			$formData['fstatus'] = $myProductGuess->status;
			$formData['fdatecreated'] = $myProductGuess->datecreated;
			$formData['fdatemodified'] = $myProductGuess->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productguessEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
                    	$product = new Core_Product($myProductGuess->pid);
						if($product->id > 0)
						{
							if($formData['fonsitestatus'] == 0)
							{
								$product->onsitestatus = $myProductGuess->oldonsitestatus;
							}
							else
							{
								$product->onsitestatus = $formData['fonsitestatus'];
							}
							if($product->updateData())
							{
								$myProductGuess->uid = $this->registry->me->id;
								$myProductGuess->pid = $formData['fpid'];
								$myProductGuess->name = $formData['fname'];
								$myProductGuess->infogift = $formData['finfogift'];
								$myProductGuess->rule = $formData['frule'];
								$myProductGuess->blockhtml = $formData['fblockhtml'];
								$myProductGuess->blocknews = $formData['fblocknews'];
								$myProductGuess->blockuser = $formData['fblockuser'];
								$myProductGuess->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
								$myProductGuess->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
								$myProductGuess->oldonsitestatus = $formData['foldonsitestatus'];
								$myProductGuess->status = $formData['fstatus'];
		                        
		                        if($myProductGuess->updateData())
		                        {
		                            $success[] = $this->registry->lang['controller']['succUpdate'];
		                            $this->registry->me->writelog('productguess_edit', $myProductGuess->id, array());
		                        }
		                        else
		                        {
		                            $error[] = $this->registry->lang['controller']['errUpdate'];            
		                        }
							}
						}
                    }
                }
                
				    
			}
			
			
			$_SESSION['productguessEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_ProductGuess::getStatusList(),
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
		$myProductGuess = new Core_ProductGuess($id);
		if($myProductGuess->id > 0)
		{
			//tien hanh xoa
			if($myProductGuess->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductGuess->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('productguess_delete', $myProductGuess->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductGuess->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fpid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPidRequired'];
			$pass = false;
		}

		if($formData['fexpiretime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errExpiretimeRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fpid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPidRequired'];
			$pass = false;
		}

		if($formData['fexpiretime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errExpiretimeRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>