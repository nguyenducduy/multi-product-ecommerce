<?php

Class Controller_Cms_Giftorderproduct Extends Controller_Cms_Base 
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
		
		$goid = (int)($this->registry->router->getArg('goid'));
		$productidFilter = (int)($this->registry->router->getArg('productid'));
		$quantityFilter = (int)($this->registry->router->getArg('quantity'));
		$instockFilter = (int)($this->registry->router->getArg('instock'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$datemodifiedFilter = (int)($this->registry->router->getArg('datemodified'));
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
            if($_SESSION['giftorderproductBulkToken']==$_POST['ftoken'])
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
                            $myGiftorderproduct = new Core_Giftorderproduct($id);
                            
                            if($myGiftorderproduct->id > 0)
                            {
                                //tien hanh xoa
                                if($myGiftorderproduct->delete())
                                {
                                    $deletedItems[] = $myGiftorderproduct->id;
                                    $this->registry->me->writelog('giftorderproduct_delete', $myGiftorderproduct->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGiftorderproduct->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGiftorderproduct->id;
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
		
		$_SESSION['giftorderproductBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		
		if($goid > 0)
		{
			$paginateUrl .= 'goid/'.$goid . '/';
			$formData['fgoid'] = $goid;
			$formData['search'] = 'goid';
		}
		if($productidFilter > 0)
		{
			$paginateUrl .= 'productid/'.$productidFilter . '/';
			$formData['fproductid'] = $productidFilter;
			$formData['search'] = 'productid';
		}

		if($quantityFilter > 0)
		{
			$paginateUrl .= 'quantity/'.$quantityFilter . '/';
			$formData['fquantity'] = $quantityFilter;
			$formData['search'] = 'quantity';
		}

		if($instockFilter > 0)
		{
			$paginateUrl .= 'instock/'.$instockFilter . '/';
			$formData['finstock'] = $instockFilter;
			$formData['search'] = 'instock';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($datemodifiedFilter > 0)
		{
			$paginateUrl .= 'datemodified/'.$datemodifiedFilter . '/';
			$formData['fdatemodified'] = $datemodifiedFilter;
			$formData['search'] = 'datemodified';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Giftorderproduct::getGiftorderproducts($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$giftorderproducts = Core_Giftorderproduct::getGiftorderproducts($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'giftorderproducts' 	=> $giftorderproducts,
												'statusOptions' => Core_Giftorderproduct::getStatusList(),
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
		
		
	
        $this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		/*} else {
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
            $this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}*/
		
	} 
	
		
	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['giftorderproductAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGiftorderproduct = new Core_Giftorderproduct();

					
					$myGiftorderproduct->productid = $formData['fproductid'];
					$myGiftorderproduct->quantity = $formData['fquantity'];
					$myGiftorderproduct->instock = $formData['finstock'];
					$myGiftorderproduct->status = $formData['fstatus'];
					
                    if($myGiftorderproduct->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('giftorderproduct_add', $myGiftorderproduct->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['giftorderproductAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_Giftorderproduct::getStatusList(),
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
		$myGiftorderproduct = new Core_Giftorderproduct($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGiftorderproduct->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fgoid'] = $myGiftorderproduct->goid;
			$formData['fid'] = $myGiftorderproduct->id;
			$formData['fproductid'] = $myGiftorderproduct->productid;
			$formData['fquantity'] = $myGiftorderproduct->quantity;
			$formData['finstock'] = $myGiftorderproduct->instock;
			$formData['fstatus'] = $myGiftorderproduct->status;
			$formData['fdatecreated'] = $myGiftorderproduct->datecreated;
			$formData['fdatemodified'] = $myGiftorderproduct->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['giftorderproductEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGiftorderproduct->productid = $formData['fproductid'];
						$myGiftorderproduct->quantity = $formData['fquantity'];
						$myGiftorderproduct->instock = $formData['finstock'];
						$myGiftorderproduct->status = $formData['fstatus'];
                        
                        if($myGiftorderproduct->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('giftorderproduct_edit', $myGiftorderproduct->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['giftorderproductEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_Giftorderproduct::getStatusList(),
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													
													));
		    $this->registry->smarty->display($this->registry->smartyControllerContainer.'edit.tpl');
			/*$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');*/
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
		$myGiftorderproduct = new Core_Giftorderproduct($id);
		if($myGiftorderproduct->id > 0)
		{
			//tien hanh xoa
			if($myGiftorderproduct->delete())
			{
				$redirectMsg = str_replace('###id###', $myGiftorderproduct->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('giftorderproduct_delete', $myGiftorderproduct->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGiftorderproduct->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fproductid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProductidRequired'];
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
		
		

		if($formData['fproductid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errProductidRequired'];
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
