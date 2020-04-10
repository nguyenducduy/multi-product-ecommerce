<?php

Class Controller_Cms_Promotionlist Extends Controller_Cms_Base 
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
		
		
		$pbarcodeFilter = (string)($this->registry->router->getArg('pbarcode'));
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
            if($_SESSION['promotionlistBulkToken']==$_POST['ftoken'])
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
                            $myPromotionlist = new Core_Promotionlist($id);
                            
                            if($myPromotionlist->id > 0)
                            {
                                //tien hanh xoa
                                if($myPromotionlist->delete())
                                {
                                    $deletedItems[] = $myPromotionlist->id;
                                    $this->registry->me->writelog('promotionlist_delete', $myPromotionlist->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPromotionlist->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPromotionlist->id;
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
		
		$_SESSION['promotionlistBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pbarcodeFilter != "")
		{
			$paginateUrl .= 'pbarcode/'.$pbarcodeFilter . '/';
			$formData['fpbarcode'] = $pbarcodeFilter;
			$formData['search'] = 'pbarcode';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Promotionlist::getPromotionlists($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$promotionlists = Core_Promotionlist::getPromotionlists($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'promotionlists' 	=> $promotionlists,
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
            if($_SESSION['promotionlistAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPromotionlist = new Core_Promotionlist();

					
					$myPromotionlist->promogid = $formData['fpromogid'];
					$myPromotionlist->pid = $formData['fpid'];
					$myPromotionlist->pbarcode = $formData['fpbarcode'];
					$myPromotionlist->iscombo = $formData['fiscombo'];
					$myPromotionlist->price = $formData['fprice'];
					$myPromotionlist->imei = $formData['fimei'];
					$myPromotionlist->imeipromotionid = $formData['fimeipromotionid'];
					$myPromotionlist->quantity = $formData['fquantity'];
					$myPromotionlist->ispercentcalc = $formData['fispercentcalc'];
					$myPromotionlist->dateadd = $formData['fdateadd'];
					$myPromotionlist->datemodify = $formData['fdatemodify'];
					
                    if($myPromotionlist->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('promotionlist_add', $myPromotionlist->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['promotionlistAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myPromotionlist = new Core_Promotionlist($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPromotionlist->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpromogid'] = $myPromotionlist->promogid;
			$formData['fpid'] = $myPromotionlist->pid;
			$formData['fpbarcode'] = $myPromotionlist->pbarcode;
			$formData['fid'] = $myPromotionlist->id;
			$formData['fiscombo'] = $myPromotionlist->iscombo;
			$formData['fprice'] = $myPromotionlist->price;
			$formData['fimei'] = $myPromotionlist->imei;
			$formData['fimeipromotionid'] = $myPromotionlist->imeipromotionid;
			$formData['fquantity'] = $myPromotionlist->quantity;
			$formData['fispercentcalc'] = $myPromotionlist->ispercentcalc;
			$formData['fdateadd'] = $myPromotionlist->dateadd;
			$formData['fdatemodify'] = $myPromotionlist->datemodify;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['promotionlistEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPromotionlist->promogid = $formData['fpromogid'];
						$myPromotionlist->pid = $formData['fpid'];
						$myPromotionlist->pbarcode = $formData['fpbarcode'];
						$myPromotionlist->iscombo = $formData['fiscombo'];
						$myPromotionlist->price = $formData['fprice'];
						$myPromotionlist->imei = $formData['fimei'];
						$myPromotionlist->imeipromotionid = $formData['fimeipromotionid'];
						$myPromotionlist->quantity = $formData['fquantity'];
						$myPromotionlist->ispercentcalc = $formData['fispercentcalc'];
						$myPromotionlist->dateadd = $formData['fdateadd'];
						$myPromotionlist->datemodify = $formData['fdatemodify'];
                        
                        if($myPromotionlist->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('promotionlist_edit', $myPromotionlist->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['promotionlistEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myPromotionlist = new Core_Promotionlist($id);
		if($myPromotionlist->id > 0)
		{
			//tien hanh xoa
			if($myPromotionlist->delete())
			{
				$redirectMsg = str_replace('###id###', $myPromotionlist->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('promotionlist_delete', $myPromotionlist->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPromotionlist->id, $this->registry->lang['controller']['errDelete']);
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

