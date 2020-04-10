<?php

Class Controller_Cms_Giftorder Extends Controller_Cms_Base 
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
		
		
		$pricefromFilter = (float)($this->registry->router->getArg('pricefrom'));
		$pricetoFilter = (float)($this->registry->router->getArg('priceto'));
		$enddateFilter = (int)($this->registry->router->getArg('enddate'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		$formData['fpricein'] = -1;
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['giftorderBulkToken']==$_POST['ftoken'])
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
                            $myGiftorder = new Core_Giftorder($id);
                            
                            if($myGiftorder->id > 0)
                            {
                                //tien hanh xoa
                                if($myGiftorder->delete())
                                {
                                    $deletedItems[] = $myGiftorder->id;
                                    $this->registry->me->writelog('giftorder_delete', $myGiftorder->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGiftorder->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGiftorder->id;
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
		
		$_SESSION['giftorderBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pricefromFilter > 0)
		{
			$paginateUrl .= 'pricefrom/'.$pricefromFilter . '/';
			$formData['fpricefrom'] = $pricefromFilter;
			$formData['search'] = 'pricefrom';
		}

		if($pricetoFilter > 0)
		{
			$paginateUrl .= 'priceto/'.$pricetoFilter . '/';
			$formData['fpriceto'] = $pricetoFilter;
			$formData['search'] = 'priceto';
		}

		if($enddateFilter > 0)
		{
			$paginateUrl .= 'enddate/'.$enddateFilter . '/';
			$formData['fenddate'] = $enddateFilter;
			$formData['search'] = 'enddate';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Giftorder::getGiftorders($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$giftorders = Core_Giftorder::getGiftorders($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'giftorders' 	=> $giftorders,
												'statusOptions' => Core_Giftorder::getStatusList(),
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
            if($_SESSION['giftorderAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGiftorder = new Core_Giftorder();

					
					$myGiftorder->pricefrom = $formData['fpricefrom'];
					$myGiftorder->priceto = $formData['fpriceto'];
					$myGiftorder->startdate = $formData['fstartdate'];
                    $myGiftorder->status = $formData['fstatus'];
					$myGiftorder->startdate = Helper::strtotimedmy($formData['fstartdate'],$formData['fsttime']);
					$myGiftorder->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
					//echodebug($formData,true);					
                    if($myGiftorder->addData())
                    {
                    	$productid = $formData['fproductid'];
                    	if(!empty($productid))
                   		{
                   			foreach ($productid as $key => $id) {
                   			 	$myGiftorderproduct = new Core_Giftorderproduct();
                   			 	$myGiftorderproduct->goid = $myGiftorder->id;
								$myGiftorderproduct->productid = $formData['fproductid'][$key];
								$myGiftorderproduct->quantity = $formData['fquantity'][$key];
								$myGiftorderproduct->instock = $formData['fquantity'][$key];
								$myGiftorderproduct->status = $formData['fstatusp'][$key];
								
			                    if($myGiftorderproduct->addData())
			                    {
			                        $this->registry->me->writelog('giftorderproduct_add', $myGiftorderproduct->id, array());  
			                    }
			                    else
			                    {
			                        //$error[] = $this->registry->lang['controller']['errAdd'];            
			                    }
               			 	} 		
		                }
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('giftorder_add', $myGiftorder->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
        			$startdate = date("d/m/Y H:i:s",$formData['fstartdate']);
					$startdate = explode(" ", $startdate);
					$formData['fstartdate'] = $startdate[0];
					$formData['fsttime'] = $startdate[1];

					$enddate = date("d/m/Y H:i:s",$formData['fenddate']);
					$enddate = explode(" ", $enddate);
					$formData['fenddate'] = $enddate[0];
					$formData['fextime'] = $enddate[1];
                }
            }
            
		}
		
		$_SESSION['giftorderAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_Giftorder::getStatusList(),
												'redirectUrl'	=> $this->registry->conf['rooturl_cms'].'giftorder',
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
		$myGiftorder = new Core_Giftorder($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGiftorder->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myGiftorder->id;
			$formData['fpricefrom'] = $myGiftorder->pricefrom;
			$formData['fpriceto'] = $myGiftorder->priceto;
			$startdate = date("d/m/Y H:i:s",$myGiftorder->startdate);
			$startdate = explode(" ", $startdate);
			$formData['fstartdate'] = $startdate[0];
			$formData['fsttime'] = $startdate[1];

			$enddate = date("d/m/Y H:i:s",$myGiftorder->enddate);
			$enddate = explode(" ", $enddate);
			$formData['fenddate'] = $enddate[0];
			$formData['fextime'] = $enddate[1];
			$formData['fstatus'] = $myGiftorder->status;
			$formData['fdatecreated'] = $myGiftorder->datecreated;
			$formData['fdatemodified'] = $myGiftorder->datemodified;
			$giftOrderProduct = Core_Giftorderproduct::getGiftorderproducts(array('fgoid'=>$formData['fid']),'','');
            $numberproduct = count($giftOrderProduct);
            if ($numberproduct > 0) {
                foreach ($giftOrderProduct as $key => $giftProduct) {
                    $formData['forderid'][$key] = $giftProduct->id;
                    $formData['fproductid'][$key] = $giftProduct->productid;
                    $formData['fquantity'][$key] = $giftProduct->quantity;
                    $formData['finstock'][$key] = $giftProduct->instock;
                    $formData['fstatusp'][$key] = $giftProduct->status;
                }
            }
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['giftorderEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGiftorder->pricefrom = $formData['fpricefrom'];
						$myGiftorder->priceto = $formData['fpriceto'];
	                    $myGiftorder->startdate = Helper::strtotimedmy($formData['fstartdate'],$formData['fsttime']);
                        $myGiftorder->enddate = Helper::strtotimedmy($formData['fenddate'],$formData['fextime']);
                        $myGiftorder->datemodified = time();
						$myGiftorder->status = $formData['fstatus'];
                        if($myGiftorder->updateData())
                        {
                            $productid = $formData['fproductid'];
                            if(!empty($productid))
                            {
                                foreach ($productid as $key => $id) {
                                    $myGiftorderproduct = new Core_Giftorderproduct($formData['forderid'][$key]);
                                    if ($myGiftorderproduct->id > 0) {
                                        $myGiftorderproduct->productid = $formData['fproductid'][$key];
                                        $myGiftorderproduct->quantity = $formData['fquantity'][$key];
                                        $myGiftorderproduct->instock = $formData['finstock'][$key];
                                        $myGiftorderproduct->status = $formData['fstatusp'][$key];
                                        if($myGiftorderproduct->updateData())
                                        {
                                            $this->registry->me->writelog('giftorderproduct_edit', $myGiftorderproduct->id, array());  
                                        }
                                    } else {
                                        $giftOrderProduct = new Core_Giftorderproduct();
                                        $giftOrderProduct->goid = $myGiftorder->id;
                                        $giftOrderProduct->productid = $formData['fproductid'][$key];
                                        $giftOrderProduct->quantity = $formData['fquantity'][$key];
                                        $giftOrderProduct->instock = $formData['finstock'][$key];
                                        $giftOrderProduct->status = $formData['fstatus'][$key];
                                        
                                        if($giftOrderProduct->addData())
                                        {
                                            $this->registry->me->writelog('giftorderproduct_add', $giftOrderProduct->id, array());
                                        }
                                    }
                                }       
                            }
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('giftorder_edit', $myGiftorder->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['giftorderEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_Giftorder::getStatusList(),
													'redirectUrl'=> $redirectUrl,
                                                    'numberproduct'=>$numberproduct,
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
		$myGiftorder = new Core_Giftorder($id);
		if($myGiftorder->id > 0)
		{
			//tien hanh xoa
			if($myGiftorder->delete())
			{
				$redirectMsg = str_replace('###id###', $myGiftorder->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('giftorder_delete', $myGiftorder->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGiftorder->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fpricefrom'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricefromMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpriceto'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricetoMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fenddate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEnddateRequired'];
			$pass = false;
		}
		if (!empty($formData['fproductid'])) {
			foreach ($formData['fproductid'] as $key => $pid) {
				if ($formData['fproductid'][$key] == '') {
					$error[] = 'Product id sản phẩm ' .($key + 1). ' phải không được rỗng';
					$pass = false;
				}
				if ($formData['fquantity'][$key] <= 0) {
					$error[] = 'Số lượng sản phẩm ' .($key + 1). ' phải lớn hơn 0';
					$pass = false;
				}
			}
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fpricefrom'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricefromMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fpriceto'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPricetoMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstartdate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errStartdateRequired'];
			$pass = false;
		}

		if($formData['fenddate'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEnddateRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}
