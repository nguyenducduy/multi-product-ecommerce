<?php

Class Controller_Cms_OrdersDetail Extends Controller_Cms_Base 
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
		
		
		$oidFilter = (int)($this->registry->router->getArg('oid'));
		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$pricesellFilter = (float)($this->registry->router->getArg('pricesell'));
		$pricefinalFilter = (float)($this->registry->router->getArg('pricefinal'));
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
            if($_SESSION['ordersdetailBulkToken']==$_POST['ftoken'])
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
                            $myOrdersDetail = new Core_OrdersDetail($id);
                            
                            if($myOrdersDetail->id > 0)
                            {
                                //tien hanh xoa
                                if($myOrdersDetail->delete())
                                {
                                    $deletedItems[] = $myOrdersDetail->id;
                                    $this->registry->me->writelog('ordersdetail_delete', $myOrdersDetail->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myOrdersDetail->id;
                            }
                            else
                                $cannotDeletedItems[] = $myOrdersDetail->id;
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
		
		$_SESSION['ordersdetailBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($oidFilter > 0)
		{
			$paginateUrl .= 'oid/'.$oidFilter . '/';
			$formData['foid'] = $oidFilter;
			$formData['search'] = 'oid';
		}

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($pricesellFilter > 0)
		{
			$paginateUrl .= 'pricesell/'.$pricesellFilter . '/';
			$formData['fpricesell'] = $pricesellFilter;
			$formData['search'] = 'pricesell';
		}

		if($pricefinalFilter > 0)
		{
			$paginateUrl .= 'pricefinal/'.$pricefinalFilter . '/';
			$formData['fpricefinal'] = $pricefinalFilter;
			$formData['search'] = 'pricefinal';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_OrdersDetail::getOrdersDetails($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$ordersdetails = Core_OrdersDetail::getOrdersDetails($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'ordersdetails' 	=> $ordersdetails,
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
            if($_SESSION['ordersdetailAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myOrdersDetail = new Core_OrdersDetail();

					
					$myOrdersDetail->pricesell = $formData['fpricesell'];
					$myOrdersDetail->pricediscount = $formData['fpricediscount'];
					$myOrdersDetail->pricefinal = $formData['fpricefinal'];
					$myOrdersDetail->quantity = $formData['fquantity'];
					$myOrdersDetail->options = $formData['foptions'];
					
                    if($myOrdersDetail->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('ordersdetail_add', $myOrdersDetail->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['ordersdetailAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myOrdersDetail = new Core_OrdersDetail($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myOrdersDetail->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['foid'] = $myOrdersDetail->oid;
			$formData['fpid'] = $myOrdersDetail->pid;
			$formData['fid'] = $myOrdersDetail->id;
			$formData['fpricesell'] = $myOrdersDetail->pricesell;
			$formData['fpricediscount'] = $myOrdersDetail->pricediscount;
			$formData['fpricefinal'] = $myOrdersDetail->pricefinal;
			$formData['fquantity'] = $myOrdersDetail->quantity;
			$formData['foptions'] = $myOrdersDetail->options;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['ordersdetailEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myOrdersDetail->pricesell = $formData['fpricesell'];
						$myOrdersDetail->pricediscount = $formData['fpricediscount'];
						$myOrdersDetail->pricefinal = $formData['fpricefinal'];
						$myOrdersDetail->quantity = $formData['fquantity'];
						$myOrdersDetail->options = $formData['foptions'];
                        
                        if($myOrdersDetail->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('ordersdetail_edit', $myOrdersDetail->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['ordersdetailEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myOrdersDetail = new Core_OrdersDetail($id);
		if($myOrdersDetail->id > 0)
		{
			//tien hanh xoa
			if($myOrdersDetail->delete())
			{
				$redirectMsg = str_replace('###id###', $myOrdersDetail->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('ordersdetail_delete', $myOrdersDetail->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myOrdersDetail->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['foid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errOidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpricesell'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricesellMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpricefinal'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricefinalMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fquantity'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errQuantityMustGreaterThanZero'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['foid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errOidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpricesell'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricesellMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpricefinal'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricefinalMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fquantity'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errQuantityMustGreaterThanZero'];
			$pass = false;
		}
				
		return $pass;
	}
}

