<?php

Class Controller_Cms_Gamefasteye Extends Controller_Cms_Base 
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
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$starttimeFilter = (int)($this->registry->router->getArg('starttime'));
		$expiretimeFilter = (int)($this->registry->router->getArg('expiretime'));
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
            if($_SESSION['gamefasteyeBulkToken']==$_POST['ftoken'])
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
                            $myGamefasteye = new Core_Gamefasteye($id);
                            
                            if($myGamefasteye->id > 0)
                            {
                                //tien hanh xoa
                                if($myGamefasteye->delete())
                                {
                                    $deletedItems[] = $myGamefasteye->id;
                                    $this->registry->me->writelog('gamefasteye_delete', $myGamefasteye->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGamefasteye->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGamefasteye->id;
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
		
		$_SESSION['gamefasteyeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($starttimeFilter > 0)
		{
			$paginateUrl .= 'starttime/'.$starttimeFilter . '/';
			$formData['fstarttime'] = $starttimeFilter;
			$formData['search'] = 'starttime';
		}

		if($expiretimeFilter > 0)
		{
			$paginateUrl .= 'expiretime/'.$expiretimeFilter . '/';
			$formData['fexpiretime'] = $expiretimeFilter;
			$formData['search'] = 'expiretime';
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
		$total = Core_Gamefasteye::getGamefasteyes($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$gamefasteyes = Core_Gamefasteye::getGamefasteyes($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'gamefasteyes' 	=> $gamefasteyes,
												'statusOptions' => Core_Gamefasteye::getStatusList(),
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
            if($_SESSION['gamefasteyeAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGamefasteye = new Core_Gamefasteye();

					
					$myGamefasteye->name = $formData['fname'];
					$myGamefasteye->rule = $formData['frule'];
					$myGamefasteye->blockhtml = $formData['fblockhtml'];
					$myGamefasteye->time = strtotime($formData['ftime']);
					$myGamefasteye->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
					$myGamefasteye->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
					$myGamefasteye->status = $formData['fstatus'];
					
                    if($myGamefasteye->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('gamefasteye_add', $myGamefasteye->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['gamefasteyeAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_Gamefasteye::getStatusList(),
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
		$myGamefasteye = new Core_Gamefasteye($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGamefasteye->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myGamefasteye->id;
			$formData['fname'] = $myGamefasteye->name;
			$formData['frule'] = $myGamefasteye->rule;
			$formData['fblockhtml'] = $myGamefasteye->blockhtml;
			
			$time = date("H:i:s",$myGamefasteye->time);
			$formData['ftime'] = $time;
			
			$starttime = date("d/m/Y H:i:s",$myGamefasteye->starttime);
			$starttime = explode(" ", $starttime);
			$formData['fstarttime'] = $starttime[0];
			$formData['fsttime'] = $starttime[1];

			$expiretime = date("d/m/Y H:i:s",$myGamefasteye->expiretime);
			$expiretime = explode(" ", $expiretime);
			$formData['fexpiretime'] = $expiretime[0];
			$formData['fextime'] = $expiretime[1];
			
			$formData['fstatus'] = $myGamefasteye->status;
			$formData['fdatecreated'] = $myGamefasteye->datecreated;
			$formData['fdatemodified'] = $myGamefasteye->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['gamefasteyeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGamefasteye->name = $formData['fname'];
						$myGamefasteye->rule = $formData['frule'];
						$myGamefasteye->blockhtml = $formData['fblockhtml'];
						$myGamefasteye->time = strtotime($formData['ftime']);
						$myGamefasteye->starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
						$myGamefasteye->expiretime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
						$myGamefasteye->status = $formData['fstatus'];
                        
                        if($myGamefasteye->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('gamefasteye_edit', $myGamefasteye->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['gamefasteyeEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_Gamefasteye::getStatusList(),
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
		$myGamefasteye = new Core_Gamefasteye($id);
		if($myGamefasteye->id > 0)
		{
			//tien hanh xoa
			if($myGamefasteye->delete())
			{
				$redirectMsg = str_replace('###id###', $myGamefasteye->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('gamefasteye_delete', $myGamefasteye->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGamefasteye->id, $this->registry->lang['controller']['errDelete']);
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
