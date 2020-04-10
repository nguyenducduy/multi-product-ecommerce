<?php

Class Controller_Cms_Crazydeal Extends Controller_Cms_Base 
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
		$nameFilter = (string)($this->registry->router->getArg('name'));
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
            if($_SESSION['crazydealBulkToken']==$_POST['ftoken'])
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
                            $myCrazydeal = new Core_Crazydeal($id);
                            
                            if($myCrazydeal->id > 0)
                            {
                                //tien hanh xoa
                                if($myCrazydeal->delete())
                                {
                                    $deletedItems[] = $myCrazydeal->id;
                                    $this->registry->me->writelog('crazydeal_delete', $myCrazydeal->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myCrazydeal->id;
                            }
                            else
                                $cannotDeletedItems[] = $myCrazydeal->id;
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
		
		$_SESSION['crazydealBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
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
		$total = Core_Crazydeal::getCrazydeals($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$crazydeals = Core_Crazydeal::getCrazydeals($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'crazydeals' 	=> $crazydeals,
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
            if($_SESSION['crazydealAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                $product = new Core_Product($formData['fpid']);
                if($product->id > 0)
                {
	                if($this->addActionValidator($formData, $error))
	                {
	                    $myCrazydeal = new Core_Crazydeal();

						$myCrazydeal->uid = $this->registry->me->id;
						$myCrazydeal->pid = $formData['fpid'];
						$myCrazydeal->name = $formData['fname'];
						$myCrazydeal->image = $formData['fimage'];
						$myCrazydeal->description = $formData['fdescription'];
						$myCrazydeal->oldonsitestatus = $product->onsitestatus;
						$myCrazydeal->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
						$myCrazydeal->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
						$myCrazydeal->status = $formData['fstatus'];
						
	                    if($myCrazydeal->addData())
	                    {
	                    	$product->onsitestatus = Core_Product::OS_CRAZYSALE;
	                    	if($product->updateData())
	                    	{
		                        $success[] = $this->registry->lang['controller']['succAdd'];
		                        $this->registry->me->writelog('crazydeal_add', $myCrazydeal->id, array());
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
		
		$_SESSION['crazydealAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $redirectUrl = $this->registry->conf['rooturl_cms'] . $this->registry->controller,
												'error'			=> $error,
												'success'		=> $success,
												'statusList'	=> Core_Crazydeal::getStatusList(),
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
		$myCrazydeal = new Core_Crazydeal($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myCrazydeal->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myCrazydeal->uid;
			$formData['fpid'] = $myCrazydeal->pid;
			$formData['fid'] = $myCrazydeal->id;
			$formData['fname'] = $myCrazydeal->name;
			$formData['fimage'] = $myCrazydeal->getImage();
			$formData['fdescription'] = $myCrazydeal->description;

			$starttime = date("d/m/Y H:i:s",$myCrazydeal->starttime);
			$starttime = explode(" ", $starttime);
			$formData['fstarttime'] = $starttime[0];
			$formData['fsttime'] = $starttime[1];

			$expiretime = date("d/m/Y H:i:s",$myCrazydeal->expiretime);
			$expiretime = explode(" ", $expiretime);
			$formData['fexpiretime'] = $expiretime[0];
			$formData['fextime'] = $expiretime[1];

			$formData['fstatus'] = $myCrazydeal->status;
			$formData['fdatecreated'] = $myCrazydeal->datecreated;
			$formData['fdatemodified'] = $myCrazydeal->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['crazydealEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						$product = new Core_Product($myCrazydeal->pid);
						if($product->id > 0)
						{
							if($formData['fonsitestatus'] == 0)
							{
								$product->onsitestatus = $myCrazydeal->oldonsitestatus;
							}
							else
							{
								$product->onsitestatus = $formData['fonsitestatus'];
							}
							if($product->updateData())
							{
								$myCrazydeal->pid = $formData['fpid'];
								$myCrazydeal->name = $formData['fname'];
								if(strlen($_FILES['fimage']['name']) > 0)
									$myCrazydeal->image = $formData['fimage'];
								$myCrazydeal->description = $formData['fdescription'];
								$myCrazydeal->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
								$myCrazydeal->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
								$myCrazydeal->status = $formData['fstatus'];

		                        if($myCrazydeal->updateData())
		                        {
		                            $success[] = $this->registry->lang['controller']['succUpdate'];
		                            $this->registry->me->writelog('crazydeal_edit', $myCrazydeal->id, array());
		                            $formData['image'] = $myCrazydeal->getImage();
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
			
			
			$_SESSION['crazydealEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_Crazydeal::getStatusList(),
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
		$myCrazydeal = new Core_Crazydeal($id);
		if($myCrazydeal->id > 0)
		{
			//tien hanh xoa
			$product = new Core_Product($myCrazydeal->pid);
			if($product->id > 0)
			{
				$product->onsitestatus = $myCrazydeal->oldonsitestatus;
				$product->updateData();
				if($myCrazydeal->delete())
				{
					$redirectMsg = str_replace('###id###', $myCrazydeal->id, $this->registry->lang['controller']['succDelete']);
					
					$this->registry->me->writelog('crazydeal_delete', $myCrazydeal->id, array());  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myCrazydeal->id, $this->registry->lang['controller']['errDelete']);
				}
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

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
		if($_FILES['fimage']['name'] == '')
        {
            $error[] = $this->registry->lang['controller']['errFileRequired'];
            $pass = false;
        }
        else
        {
            $ext = strtoupper(Helper::fileExtension($_FILES['fimage']['name']));
            if(!in_array($ext, $this->registry->setting['crazydeal']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
                $pass = false;
            }
            elseif($_FILES['fimage']['size'] > $this->registry->setting['ads']['imageMaxFileSize'])
            {
                $error[] = str_replace('###VALUE###', round($this->registry->setting['ads']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
                $pass = false;
            }
        }

		if($formData['fstarttime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStarttimeRequired'];
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

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fimage'] == '')
		{
			$error[] = $this->registry->lang['controller']['errImageRequired'];
			$pass = false;
		}

		if($formData['fstarttime'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStarttimeRequired'];
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