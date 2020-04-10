<?php

Class Controller_Cms_GamefasteyeHistory Extends Controller_Cms_Base 
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
		
		
		$playedFilter = (int)($this->registry->router->getArg('played'));
		$timeplayedFilter = (int)($this->registry->router->getArg('timeplayed'));
		$pointFilter = (int)($this->registry->router->getArg('point'));
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
            if($_SESSION['gamefasteyehistoryBulkToken']==$_POST['ftoken'])
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
                            $myGamefasteyeHistory = new Core_GamefasteyeHistory($id);
                            
                            if($myGamefasteyeHistory->id > 0)
                            {
                                //tien hanh xoa
                                if($myGamefasteyeHistory->delete())
                                {
                                    $deletedItems[] = $myGamefasteyeHistory->id;
                                    $this->registry->me->writelog('gamefasteyehistory_delete', $myGamefasteyeHistory->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGamefasteyeHistory->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGamefasteyeHistory->id;
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
		
		$_SESSION['gamefasteyehistoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($playedFilter > 0)
		{
			$paginateUrl .= 'played/'.$playedFilter . '/';
			$formData['fplayed'] = $playedFilter;
			$formData['search'] = 'played';
		}

		if($timeplayedFilter > 0)
		{
			$paginateUrl .= 'timeplayed/'.$timeplayedFilter . '/';
			$formData['ftimeplayed'] = $timeplayedFilter;
			$formData['search'] = 'timeplayed';
		}

		if($pointFilter > 0)
		{
			$paginateUrl .= 'point/'.$pointFilter . '/';
			$formData['fpoint'] = $pointFilter;
			$formData['search'] = 'point';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_GamefasteyeHistory::getGamefasteyeHistorys($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$gamefasteyehistorys = Core_GamefasteyeHistory::getGamefasteyeHistorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'gamefasteyehistorys' 	=> $gamefasteyehistorys,
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
            if($_SESSION['gamefasteyehistoryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGamefasteyeHistory = new Core_GamefasteyeHistory();

					
					$myGamefasteyeHistory->guid = $formData['fguid'];
					$myGamefasteyeHistory->played = $formData['fplayed'];
					$myGamefasteyeHistory->timeplayed = $formData['ftimeplayed'];
					$myGamefasteyeHistory->point = $formData['fpoint'];
					
                    if($myGamefasteyeHistory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('gamefasteyehistory_add', $myGamefasteyeHistory->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['gamefasteyehistoryAddToken'] = Helper::getSecurityToken();//Tao token moi
		
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
		$myGamefasteyeHistory = new Core_GamefasteyeHistory($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGamefasteyeHistory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fguid'] = $myGamefasteyeHistory->guid;
			$formData['fid'] = $myGamefasteyeHistory->id;
			$formData['fplayed'] = $myGamefasteyeHistory->played;
			$formData['ftimeplayed'] = $myGamefasteyeHistory->timeplayed;
			$formData['fpoint'] = $myGamefasteyeHistory->point;
			$formData['fdatecreated'] = $myGamefasteyeHistory->datecreated;
			$formData['fdatemodified'] = $myGamefasteyeHistory->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['gamefasteyehistoryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGamefasteyeHistory->guid = $formData['fguid'];
						$myGamefasteyeHistory->played = $formData['fplayed'];
						$myGamefasteyeHistory->timeplayed = $formData['ftimeplayed'];
						$myGamefasteyeHistory->point = $formData['fpoint'];
                        
                        if($myGamefasteyeHistory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('gamefasteyehistory_edit', $myGamefasteyeHistory->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['gamefasteyehistoryEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myGamefasteyeHistory = new Core_GamefasteyeHistory($id);
		if($myGamefasteyeHistory->id > 0)
		{
			//tien hanh xoa
			if($myGamefasteyeHistory->delete())
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeHistory->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('gamefasteyehistory_delete', $myGamefasteyeHistory->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeHistory->id, $this->registry->lang['controller']['errDelete']);
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
