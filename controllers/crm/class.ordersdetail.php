<?php

Class Controller_Crm_OrdersDetail Extends Controller_Crm_Base 
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
		$bidFilter = (int)($this->registry->router->getArg('bid'));
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
		
		$paginateUrl = $this->registry->conf['rooturl_admin'].$this->registry->controller.'/index/';      
		
		

		if($oidFilter > 0)
		{
			$paginateUrl .= 'oid/'.$oidFilter . '/';
			$formData['foid'] = $oidFilter;
			$formData['search'] = 'oid';
		}

		if($bidFilter > 0)
		{
			$paginateUrl .= 'bid/'.$bidFilter . '/';
			$formData['fbid'] = $bidFilter;
			$formData['search'] = 'bid';
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

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
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

					
					$myOrdersDetail->oid = $formData['foid'];
					$myOrdersDetail->bid = $formData['fbid'];
					$myOrdersDetail->name = $formData['fname'];
					$myOrdersDetail->pricesell = $formData['fpricesell'];
					$myOrdersDetail->pricediscount = $formData['fpricediscount'];
					$myOrdersDetail->pricefinal = $formData['fpricefinal'];
					$myOrdersDetail->quantity = $formData['fquantity'];
					$myOrdersDetail->weight = $formData['fweight'];
					$myOrdersDetail->size = $formData['fsize'];
					
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
			$formData['fbid'] = $myOrdersDetail->bid;
			$formData['fid'] = $myOrdersDetail->id;
			$formData['fname'] = $myOrdersDetail->name;
			$formData['fpricesell'] = $myOrdersDetail->pricesell;
			$formData['fpricediscount'] = $myOrdersDetail->pricediscount;
			$formData['fpricefinal'] = $myOrdersDetail->pricefinal;
			$formData['fquantity'] = $myOrdersDetail->quantity;
			$formData['fweight'] = $myOrdersDetail->weight;
			$formData['fsize'] = $myOrdersDetail->size;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['ordersdetailEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myOrdersDetail->oid = $formData['foid'];
						$myOrdersDetail->bid = $formData['fbid'];
						$myOrdersDetail->name = $formData['fname'];
						$myOrdersDetail->pricesell = $formData['fpricesell'];
						$myOrdersDetail->pricediscount = $formData['fpricediscount'];
						$myOrdersDetail->pricefinal = $formData['fpricefinal'];
						$myOrdersDetail->quantity = $formData['fquantity'];
						$myOrdersDetail->weight = $formData['fweight'];
						$myOrdersDetail->size = $formData['fsize'];
                        
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
		
		
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		
				
		return $pass;
	}
}

