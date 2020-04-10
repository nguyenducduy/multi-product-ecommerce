<?php

Class Controller_Cms_Parking Extends Controller_Cms_Base 
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
		
		
		$dayFilter = (int)($this->registry->router->getArg('day'));
		$monthFilter = (int)($this->registry->router->getArg('month'));
		$yearFilter = (int)($this->registry->router->getArg('year'));
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
            if($_SESSION['parkingBulkToken']==$_POST['ftoken'])
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
                            $myParking = new Core_Parking($id);
                            
                            if($myParking->id > 0)
                            {
                                //tien hanh xoa
                                if($myParking->delete())
                                {
                                    $deletedItems[] = $myParking->id;
                                    $this->registry->me->writelog('parking_delete', $myParking->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myParking->id;
                            }
                            else
                                $cannotDeletedItems[] = $myParking->id;
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
		
		$_SESSION['parkingBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($dayFilter > 0)
		{
			$paginateUrl .= 'day/'.$dayFilter . '/';
			$formData['fday'] = $dayFilter;
			$formData['search'] = 'day';
		}

		if($monthFilter > 0)
		{
			$paginateUrl .= 'month/'.$monthFilter . '/';
			$formData['fmonth'] = $monthFilter;
			$formData['search'] = 'month';
		}

		if($yearFilter > 0)
		{
			$paginateUrl .= 'year/'.$yearFilter . '/';
			$formData['fyear'] = $yearFilter;
			$formData['search'] = 'year';
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

			if($searchKeywordIn == 'position')
			{
				$paginateUrl .= 'searchin/position/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Parking::getParkings($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$parkings = Core_Parking::getParkings($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'parkings' 	=> $parkings,
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
                                                'cur_day'        => date('j'),
                                                'cur_month'        => date('n'),
                                                'cur_year'        => date('Y'),
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
		
	function addAction()
	{
		global $me;
        $error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['parkingAddToken'] == $_POST['ftoken'])
            {
                $formData = array_merge($formData, $_POST);                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myParking = new Core_Parking();
					
					//$myParking->uid = $formData['fuid'];
					$myParking->position = Helper::plaintext($formData['fposition']);
                    $myParking->uid = $this->registry->me->id;
					
                    if($myParking->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('parking_add', $myParking->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['parkingAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myParking = new Core_Parking($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myParking->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			//$formData['fuid'] = $myParking->uid;
			$formData['fid'] = $myParking->id;
			$formData['fposition'] = $myParking->position;
            
			//$formData['fday'] = $myParking->day;
			//$formData['fmonth'] = $myParking->month;
			//$formData['fyear'] = $myParking->year;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['parkingEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						//$myParking->uid = $formData['fuid'];
						$myParking->position = Helper::plaintext($formData['fposition']);
						//$myParking->day = $formData['fday'];
//						$myParking->month = $formData['fmonth'];
//						$myParking->year = $formData['fyear'];
                        
                        if($myParking->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('parking_edit', $myParking->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['parkingEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myParking = new Core_Parking($id);
		if($myParking->id > 0)
		{
			//tien hanh xoa
			if($myParking->delete())
			{
				$redirectMsg = str_replace('###id###', $myParking->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('parking_delete', $myParking->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myParking->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		/*if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}*/

		if($formData['fposition'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPositionRequired'];
			$pass = false;
		}

		/*if($formData['fday'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errDayMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fmonth'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errMonthMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fyear'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errYearMustGreaterThanZero'];
			$pass = false;
		}*/
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		/*if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}*/

		if($formData['fposition'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPositionRequired'];
			$pass = false;
		}

		/*if($formData['fday'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errDayMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fmonth'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errMonthMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fyear'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errYearMustGreaterThanZero'];
			$pass = false;
		}*/
				
		return $pass;
	}
}

