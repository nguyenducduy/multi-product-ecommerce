<?php

Class Controller_Cms_AccessTicketType Extends Controller_Cms_Base 
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
		
		
		$groupcontrollerFilter = (string)($this->registry->router->getArg('groupcontroller'));
		$controllerFilter = (string)($this->registry->router->getArg('controller'));
		$actionFilter = (string)($this->registry->router->getArg('action'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
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
            if($_SESSION['accesstickettypeBulkToken']==$_POST['ftoken'])
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
                            $myAccessTicketType = new Core_AccessTicketType($id);
                            
                            if($myAccessTicketType->id > 0)
                            {
                                //tien hanh xoa
                                if($myAccessTicketType->delete())
                                {
                                    $deletedItems[] = $myAccessTicketType->id;
                                    $this->registry->me->writelog('accesstickettype_delete', $myAccessTicketType->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myAccessTicketType->id;
                            }
                            else
                                $cannotDeletedItems[] = $myAccessTicketType->id;
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
		
		$_SESSION['accesstickettypeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($groupcontrollerFilter != "")
		{
			$paginateUrl .= 'groupcontroller/'.$groupcontrollerFilter . '/';
			$formData['fgroupcontroller'] = $groupcontrollerFilter;
			$formData['search'] = 'groupcontroller';
		}

		if($controllerFilter != "")
		{
			$paginateUrl .= 'controller/'.$controllerFilter . '/';
			$formData['fcontroller'] = $controllerFilter;
			$formData['search'] = 'controller';
		}

		if($actionFilter != "")
		{
			$paginateUrl .= 'action/'.$actionFilter . '/';
			$formData['faction'] = $actionFilter;
			$formData['search'] = 'action';
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
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'groupcontroller')
			{
				$paginateUrl .= 'searchin/groupcontroller/';
			}
			elseif($searchKeywordIn == 'controller')
			{
				$paginateUrl .= 'searchin/controller/';
			}
			elseif($searchKeywordIn == 'action')
			{
				$paginateUrl .= 'searchin/action/';
			}
			elseif($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_AccessTicketType::getAccessTicketTypes($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$accesstickettypes = Core_AccessTicketType::getAccessTicketTypes($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
		/////GET ALL GROUP CONTROLLER IN SYSTEM
		$groupcontrollerlist = $this->getAllGroupController();

		////GET CONTROLLER LIST BY GROUP CONTROLLER
		$controllerlist = array();
		if(strlen($formData['fgroupcontroller']) > 0 )
		{
			$controllerPath = SITE_PATH. 'controllers/' . $formData['fgroupcontroller'] ;			
			$controllers = $this->getListDir($controllerPath , true);
			if(count($controllers) > 0)
			{
				foreach ($controllers as $classcontroller) 
				{
					$partcontroller = explode('.', $classcontroller);
					$controllerlist[] = $partcontroller[1];
				}
			}
		}
				
		$this->registry->smarty->assign(array(	'accesstickettypes' 	=> $accesstickettypes,
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
												'statusList' => Core_AccessTicketType::getStatusList(),
												'groupcontrollerlist' => $groupcontrollerlist,
												'controllerlist' => $controllerlist,
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
            if($_SESSION['accesstickettypeAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myAccessTicketType = new Core_AccessTicketType();

					
					$myAccessTicketType->groupcontroller = $formData['fgroupcontroller'];
					$myAccessTicketType->controller = $formData['fcontroller'];
					$myAccessTicketType->action = $formData['faction'];
					$myAccessTicketType->name = $formData['fname'];
					$myAccessTicketType->description = $formData['fdescription'];
					$myAccessTicketType->status = $formData['fstatus'];
					$myAccessTicketType->ipaddress = $formData['fipaddress'];
					
                    if($myAccessTicketType->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('accesstickettype_add', $myAccessTicketType->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		/////GET ALL GROUP CONTROLLER IN SYSTEM
		$groupcontrollerlist = $this->getAllGroupController();	

		////GET CONTROLLER LIST BY GROUP CONTROLLER
		$controllerlist = array();
		if(strlen($formData['fgroupcontroller']) > 0 )
		{
			$controllerPath = SITE_PATH. 'controllers/' . $formData['fgroupcontroller'] ;			
			$controllers = $this->getListDir($controllerPath , true);
			if(count($controllers) > 0)
			{
				foreach ($controllers as $classcontroller) 
				{
					$partcontroller = explode('.', $classcontroller);
					$controllerlist[] = $partcontroller[1];
				}
			}
		}


		$_SESSION['accesstickettypeAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'groupcontrollerlist' => $groupcontrollerlist,
												'statusList' => Core_AccessTicketType::getStatusList(),
												'controllerlist' => $controllerlist,
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
		$myAccessTicketType = new Core_AccessTicketType($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myAccessTicketType->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myAccessTicketType->id;
			$formData['fgroupcontroller'] = $myAccessTicketType->groupcontroller;
			$formData['fcontroller'] = $myAccessTicketType->controller;
			$formData['faction'] = $myAccessTicketType->action;
			$formData['fname'] = $myAccessTicketType->name;
			$formData['fdescription'] = $myAccessTicketType->description;
			$formData['fstatus'] = $myAccessTicketType->status;
			$formData['fipaddress'] = $myAccessTicketType->ipaddress;
			$formData['fdatecreated'] = $myAccessTicketType->datecreated;
			$formData['fdatemodified'] = $myAccessTicketType->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['accesstickettypeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myAccessTicketType->groupcontroller = $formData['fgroupcontroller'];
						$myAccessTicketType->controller = $formData['fcontroller'];
						$myAccessTicketType->action = $formData['faction'];
						$myAccessTicketType->name = $formData['fname'];
						$myAccessTicketType->description = $formData['fdescription'];
						$myAccessTicketType->status = $formData['fstatus'];						
                        
                        if($myAccessTicketType->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('accesstickettype_edit', $myAccessTicketType->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			/////GET ALL GROUP CONTROLLER IN SYSTEM
			$groupcontrollerlist = $this->getAllGroupController();

			////GET CONTROLLER LIST BY GROUP CONTROLLER
			$controllerlist = array();
			if(strlen($formData['fgroupcontroller']) > 0 )
			{
				$controllerPath = SITE_PATH. 'controllers/' . $formData['fgroupcontroller'] ;			
				$controllers = $this->getListDir($controllerPath , true);
				if(count($controllers) > 0)
				{
					foreach ($controllers as $classcontroller) 
					{
						$partcontroller = explode('.', $classcontroller);
						$controllerlist[] = $partcontroller[1];
					}
				}
			}
			
			$_SESSION['accesstickettypeEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'groupcontrollerlist' => $groupcontrollerlist,
													'controllerlist' => $controllerlist,
													'statusList' => Core_AccessTicketType::getStatusList(),
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
		$myAccessTicketType = new Core_AccessTicketType($id);
		if($myAccessTicketType->id > 0)
		{
			//tien hanh xoa
			if($myAccessTicketType->delete())
			{
				$redirectMsg = str_replace('###id###', $myAccessTicketType->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('accesstickettype_delete', $myAccessTicketType->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myAccessTicketType->id, $this->registry->lang['controller']['errDelete']);
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

	private function getAllGroupController()
	{
		$groupcontrollerlist = array();

		$controllerPath = SITE_PATH. 'controllers';

		$groupcontrollerlist = $this->getListDir($controllerPath);		

		return $groupcontrollerlist;
	}

	public function getcontrollerajaxAction()
	{
		$groupcontroller = (string)$_POST['groupcontroller'];
		$controllerlist = array();
		if(strlen($groupcontroller) > 0 )
		{
			$controllerPath = SITE_PATH. 'controllers/' . $groupcontroller ;			
			$controllers = $this->getListDir($controllerPath , true);
			if(count($controllers) > 0)
			{
				foreach ($controllers as $classcontroller) 
				{
					$partcontroller = explode('.', $classcontroller);
					$controllerlist[] = $partcontroller[1];
				}
			}
		}
		echo json_encode($controllerlist);
	}


	private function getListDir($path , $file=false)
	{
		$dirList = array();
		
		if ($handle = opendir($path))
		{
		    while (false !== ($entry = readdir($handle)))
		    {		    	
		        if($entry != '.' && $entry != '..' && $entry != 'core' && preg_match('/^[a-z][a-z.]+$/ims', $entry))
		        {
		        	if($file == false)
		        	{
		        		if(is_dir($path .'/'. $entry) === true)
		        		{
		        			$dirList[] = $entry;
		        		}
		        	}
		        	else
		        	{
		        		if(is_file($path .'/'. $entry) === true)
		        		{
		        			$dirList[] = $entry;
		        		}
		        	}
		        }
		    }
		}


		return $dirList;
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fgroupcontroller'] == '')
		{
			$error[] = $this->registry->lang['controller']['errGroupcontrollerRequired'];
			$pass = false;
		}

		if($formData['fcontroller'] == '')
		{
			$error[] = $this->registry->lang['controller']['errControllerRequired'];
			$pass = false;
		}

		if($formData['faction'] == '')
		{
			$error[] = $this->registry->lang['controller']['errActionRequired'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fgroupcontroller'] == '')
		{
			$error[] = $this->registry->lang['controller']['errGroupcontrollerRequired'];
			$pass = false;
		}

		if($formData['fcontroller'] == '')
		{
			$error[] = $this->registry->lang['controller']['errControllerRequired'];
			$pass = false;
		}

		if($formData['faction'] == '')
		{
			$error[] = $this->registry->lang['controller']['errActionRequired'];
			$pass = false;
		}

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>