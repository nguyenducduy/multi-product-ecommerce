<?php

Class Controller_Cms_ForecastUservalueHistory Extends Controller_Cms_Base 
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
		$fuidFilter = (int)($this->registry->router->getArg('fuid'));
		$oldvalueFilter = (string)($this->registry->router->getArg('oldvalue'));
		$newvalueFilter = (string)($this->registry->router->getArg('newvalue'));
		$edituseridFilter = (int)($this->registry->router->getArg('edituserid'));
		$sessionidFilter = (string)($this->registry->router->getArg('sessionid'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
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
            if($_SESSION['forecastuservaluehistoryBulkToken']==$_POST['ftoken'])
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
                            $myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory($id);
                            
                            if($myForecastUservalueHistory->id > 0)
                            {
                                //tien hanh xoa
                                if($myForecastUservalueHistory->delete())
                                {
                                    $deletedItems[] = $myForecastUservalueHistory->id;
                                    $this->registry->me->writelog('forecastuservaluehistory_delete', $myForecastUservalueHistory->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myForecastUservalueHistory->id;
                            }
                            else
                                $cannotDeletedItems[] = $myForecastUservalueHistory->id;
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
		
		$_SESSION['forecastuservaluehistoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($fuidFilter > 0)
		{
			$paginateUrl .= 'fuid/'.$fuidFilter . '/';
			$formData['ffuid'] = $fuidFilter;
			$formData['search'] = 'fuid';
		}

		if($oldvalueFilter != "")
		{
			$paginateUrl .= 'oldvalue/'.$oldvalueFilter . '/';
			$formData['foldvalue'] = $oldvalueFilter;
			$formData['search'] = 'oldvalue';
		}

		if($newvalueFilter != "")
		{
			$paginateUrl .= 'newvalue/'.$newvalueFilter . '/';
			$formData['fnewvalue'] = $newvalueFilter;
			$formData['search'] = 'newvalue';
		}

		if($edituseridFilter > 0)
		{
			$paginateUrl .= 'edituserid/'.$edituseridFilter . '/';
			$formData['fedituserid'] = $edituseridFilter;
			$formData['search'] = 'edituserid';
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
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'oldvalue')
			{
				$paginateUrl .= 'searchin/oldvalue/';
			}
			elseif($searchKeywordIn == 'newvalue')
			{
				$paginateUrl .= 'searchin/newvalue/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ForecastUservalueHistory::getForecastUservalueHistorys($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$forecastuservaluehistorys = Core_Backend_ForecastUservalueHistory::getForecastUservalueHistorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'forecastuservaluehistorys' 	=> $forecastuservaluehistorys,
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
            if($_SESSION['forecastuservaluehistoryAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();

					
					$myForecastUservalueHistory->uid = $formData['fuid'];
					$myForecastUservalueHistory->fuid = $formData['ffuid'];
					$myForecastUservalueHistory->oldvalue = $formData['foldvalue'];
					$myForecastUservalueHistory->newvalue = $formData['fnewvalue'];
					$myForecastUservalueHistory->edituserid = $formData['fedituserid'];
					$myForecastUservalueHistory->sessionid = $formData['fsessionid'];
					$myForecastUservalueHistory->ipaddress = $formData['fipaddress'];
					
                    if($myForecastUservalueHistory->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('forecastuservaluehistory_add', $myForecastUservalueHistory->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['forecastuservaluehistoryAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myForecastUservalueHistory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myForecastUservalueHistory->uid;
			$formData['ffuid'] = $myForecastUservalueHistory->fuid;
			$formData['fid'] = $myForecastUservalueHistory->id;
			$formData['foldvalue'] = $myForecastUservalueHistory->oldvalue;
			$formData['fnewvalue'] = $myForecastUservalueHistory->newvalue;
			$formData['fedituserid'] = $myForecastUservalueHistory->edituserid;
			$formData['fsessionid'] = $myForecastUservalueHistory->sessionid;
			$formData['fipaddress'] = $myForecastUservalueHistory->ipaddress;
			$formData['fdatecreated'] = $myForecastUservalueHistory->datecreated;
			$formData['fdatemodified'] = $myForecastUservalueHistory->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['forecastuservaluehistoryEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myForecastUservalueHistory->uid = $formData['fuid'];
						$myForecastUservalueHistory->fuid = $formData['ffuid'];
						$myForecastUservalueHistory->oldvalue = $formData['foldvalue'];
						$myForecastUservalueHistory->newvalue = $formData['fnewvalue'];
						$myForecastUservalueHistory->edituserid = $formData['fedituserid'];
						$myForecastUservalueHistory->sessionid = $formData['fsessionid'];
						$myForecastUservalueHistory->ipaddress = $formData['fipaddress'];
                        
                        if($myForecastUservalueHistory->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('forecastuservaluehistory_edit', $myForecastUservalueHistory->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['forecastuservaluehistoryEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory($id);
		if($myForecastUservalueHistory->id > 0)
		{
			//tien hanh xoa
			if($myForecastUservalueHistory->delete())
			{
				$redirectMsg = str_replace('###id###', $myForecastUservalueHistory->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('forecastuservaluehistory_delete', $myForecastUservalueHistory->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myForecastUservalueHistory->id, $this->registry->lang['controller']['errDelete']);
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

		if($formData['ffuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errFuidMustGreaterThanZero'];
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

		if($formData['ffuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errFuidMustGreaterThanZero'];
			$pass = false;
		}
				
		return $pass;
	}
}

?>