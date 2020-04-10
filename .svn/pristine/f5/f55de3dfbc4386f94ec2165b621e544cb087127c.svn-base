<?php

Class Controller_Cms_ForecastUservalue Extends Controller_Cms_Base 
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
		$identifierFilter = (string)($this->registry->router->getArg('identifier'));
		$sheetFilter = (string)($this->registry->router->getArg('sheet'));
		$valueFilter = (string)($this->registry->router->getArg('value'));
		$dateFilter = (string)($this->registry->router->getArg('date'));
		$levelFilter = (int)($this->registry->router->getArg('level'));
		$isofficialFilter = (int)($this->registry->router->getArg('isofficial'));
		$caneditFilter = (int)($this->registry->router->getArg('canedit'));
		$candeleteFilter = (int)($this->registry->router->getArg('candelete'));
		$sessionidFilter = (string)($this->registry->router->getArg('sessionid'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
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
            if($_SESSION['forecastuservalueBulkToken']==$_POST['ftoken'])
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
                            $myForecastUservalue = new Core_Backend_ForecastUservalue($id);
                            
                            if($myForecastUservalue->id > 0)
                            {
                                //tien hanh xoa
                                if($myForecastUservalue->delete())
                                {
                                    $deletedItems[] = $myForecastUservalue->id;
                                    $this->registry->me->writelog('forecastuservalue_delete', $myForecastUservalue->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myForecastUservalue->id;
                            }
                            else
                                $cannotDeletedItems[] = $myForecastUservalue->id;
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
		
		$_SESSION['forecastuservalueBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($identifierFilter != "")
		{
			$paginateUrl .= 'identifier/'.$identifierFilter . '/';
			$formData['fidentifier'] = $identifierFilter;
			$formData['search'] = 'identifier';
		}

		if($sheetFilter != "")
		{
			$paginateUrl .= 'sheet/'.$sheetFilter . '/';
			$formData['fsheet'] = $sheetFilter;
			$formData['search'] = 'sheet';
		}

		if($valueFilter != "")
		{
			$paginateUrl .= 'value/'.$valueFilter . '/';
			$formData['fvalue'] = $valueFilter;
			$formData['search'] = 'value';
		}

		if($dateFilter != "")
		{
			$paginateUrl .= 'date/'.$dateFilter . '/';
			$formData['fdate'] = $dateFilter;
			$formData['search'] = 'date';
		}

		if($levelFilter > 0)
		{
			$paginateUrl .= 'level/'.$levelFilter . '/';
			$formData['flevel'] = $levelFilter;
			$formData['search'] = 'level';
		}

		if($isofficialFilter > 0)
		{
			$paginateUrl .= 'isofficial/'.$isofficialFilter . '/';
			$formData['fisofficial'] = $isofficialFilter;
			$formData['search'] = 'isofficial';
		}

		if($caneditFilter > 0)
		{
			$paginateUrl .= 'canedit/'.$caneditFilter . '/';
			$formData['fcanedit'] = $caneditFilter;
			$formData['search'] = 'canedit';
		}

		if($candeleteFilter > 0)
		{
			$paginateUrl .= 'candelete/'.$candeleteFilter . '/';
			$formData['fcandelete'] = $candeleteFilter;
			$formData['search'] = 'candelete';
		}

		if($sessionidFilter != "")
		{
			$paginateUrl .= 'sessionid/'.$sessionidFilter . '/';
			$formData['fsessionid'] = $sessionidFilter;
			$formData['search'] = 'sessionid';
		}

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Backend_ForecastUservalue::getForecastUservalues($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$forecastuservalues = Core_Backend_ForecastUservalue::getForecastUservalues($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'forecastuservalues' 	=> $forecastuservalues,
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
            if($_SESSION['forecastuservalueAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myForecastUservalue = new Core_Backend_ForecastUservalue();

					
					$myForecastUservalue->uid = $formData['fuid'];
					$myForecastUservalue->identifier = $formData['fidentifier'];
					$myForecastUservalue->sheet = $formData['fsheet'];
					$myForecastUservalue->value = $formData['fvalue'];
					$myForecastUservalue->description = $formData['fdescription'];
					$myForecastUservalue->date = $formData['fdate'];
					$myForecastUservalue->level = $formData['flevel'];
					$myForecastUservalue->isofficial = $formData['fisofficial'];
					$myForecastUservalue->canedit = $formData['fcanedit'];
					$myForecastUservalue->candelete = $formData['fcandelete'];
					$myForecastUservalue->sessionid = $formData['fsessionid'];
					$myForecastUservalue->ipaddress = $formData['fipaddress'];
					
                    if($myForecastUservalue->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('forecastuservalue_add', $myForecastUservalue->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['forecastuservalueAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myForecastUservalue = new Core_Backend_ForecastUservalue($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myForecastUservalue->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myForecastUservalue->uid;
			$formData['fid'] = $myForecastUservalue->id;
			$formData['fidentifier'] = $myForecastUservalue->identifier;
			$formData['fsheet'] = $myForecastUservalue->sheet;
			$formData['fvalue'] = $myForecastUservalue->value;
			$formData['fdescription'] = $myForecastUservalue->description;
			$formData['fdate'] = $myForecastUservalue->date;
			$formData['flevel'] = $myForecastUservalue->level;
			$formData['fisofficial'] = $myForecastUservalue->isofficial;
			$formData['fcanedit'] = $myForecastUservalue->canedit;
			$formData['fcandelete'] = $myForecastUservalue->candelete;
			$formData['fsessionid'] = $myForecastUservalue->sessionid;
			$formData['fipaddress'] = $myForecastUservalue->ipaddress;
			$formData['fdatecreated'] = $myForecastUservalue->datecreated;
			$formData['fdatemodified'] = $myForecastUservalue->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['forecastuservalueEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myForecastUservalue->uid = $formData['fuid'];
						$myForecastUservalue->identifier = $formData['fidentifier'];
						$myForecastUservalue->sheet = $formData['fsheet'];
						$myForecastUservalue->value = $formData['fvalue'];
						$myForecastUservalue->description = $formData['fdescription'];
						$myForecastUservalue->date = $formData['fdate'];
						$myForecastUservalue->level = $formData['flevel'];
						$myForecastUservalue->isofficial = $formData['fisofficial'];
						$myForecastUservalue->canedit = $formData['fcanedit'];
						$myForecastUservalue->candelete = $formData['fcandelete'];
						$myForecastUservalue->sessionid = $formData['fsessionid'];
						$myForecastUservalue->ipaddress = $formData['fipaddress'];
                        
                        if($myForecastUservalue->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('forecastuservalue_edit', $myForecastUservalue->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['forecastuservalueEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myForecastUservalue = new Core_Backend_ForecastUservalue($id);
		if($myForecastUservalue->id > 0)
		{
			//tien hanh xoa
			if($myForecastUservalue->delete())
			{
				$redirectMsg = str_replace('###id###', $myForecastUservalue->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('forecastuservalue_delete', $myForecastUservalue->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myForecastUservalue->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
			$pass = false;
		}

		if($formData['fsheet'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSheetRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fidentifier'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIdentifierRequired'];
			$pass = false;
		}

		if($formData['fsheet'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSheetRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>