<?php

Class Controller_Cms_PriceEnemy Extends Controller_Cms_Base 
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
		
		
		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$eidFilter = (int)($this->registry->router->getArg('eid'));
		$priceFilter = (float)($this->registry->router->getArg('price'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
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
            if($_SESSION['priceenemyBulkToken']==$_POST['ftoken'])
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
                            $myPriceEnemy = new Core_PriceEnemy($id);
                            
                            if($myPriceEnemy->id > 0)
                            {
                                //tien hanh xoa
                                if($myPriceEnemy->delete())
                                {
                                    $deletedItems[] = $myPriceEnemy->id;
                                    $this->registry->me->writelog('priceenemy_delete', $myPriceEnemy->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPriceEnemy->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPriceEnemy->id;
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
		
		$_SESSION['priceenemyBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($eidFilter > 0)
		{
			$paginateUrl .= 'eid/'.$eidFilter . '/';
			$formData['feid'] = $eidFilter;
			$formData['search'] = 'eid';
		}

		if($priceFilter > 0)
		{
			$paginateUrl .= 'price/'.$priceFilter . '/';
			$formData['fprice'] = $priceFilter;
			$formData['search'] = 'price';
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
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'url')
			{
				$paginateUrl .= 'searchin/url/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
		
		//check role of user
		$productcategoryList = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id) , 'id' , 'ASC');

			if(count($roleusers) > 0)
			{
				foreach($roleusers as $roleuser)
				{					
					$productcategoryList[] = $roleuser->objectid;
				}
			}
		}			
		else
		{
			$list = Core_Productcategory::getProductcategorys(array('fparentidall' => 'all') , 'id' , 'ASC');
			foreach($list as $cat)
			{
				$productcategoryList[] = $cat->id;
			}
		}

		if(count($productcategoryList) > 0)
		{
			$formData['fpcidarr'] = $productcategoryList;
		}

		//tim tong so
		$total = Core_PriceEnemy::getPriceEnemys($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$priceenemys = Core_PriceEnemy::getPriceEnemys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		if(!empty($priceenemys))
		{
			$group = array();
			$groupList = array();
			$i = 0;			
			foreach ($priceenemys as $priceenemy) 
			{
				$priceenemy->price = Helper::formatPrice($priceenemy->price);
				$priceenemy->enemyactor = new Core_Enemy($priceenemy->eid);
				if($i > 0)
				{					
					foreach($group as $obj)
					{
						if($obj->pid == $priceenemy->pid)
						{
							$group[] = $priceenemy;
							break;
						}
						else
						{
							$groupList[] = $group;
							$group = array();
							$group[] = $priceenemy;
							break;
						}
					}					
				}
				else
				{
					$group[] = $priceenemy;					
				}

				if($i== count($priceenemys)-1)
				{
					$groupList[] = $group;
				}
				$i++;
			}			
		}
		
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'priceenemys' 	=> $priceenemys,
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
												'groupList'		=> $groupList,
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
            if($_SESSION['priceenemyAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPriceEnemy = new Core_PriceEnemy();

					$myProduct = new Core_Product($formData['fpid']);
					$myPriceEnemy->pid = $formData['fpid'];
					$myPriceEnemy->pcid = $myProduct->pcid; 						
					$myPriceEnemy->uid = $this->registry->me->id;
					$myPriceEnemy->eid = $formData['feid'];
					$myPriceEnemy->type = $formData['ftype'];
					$myPriceEnemy->rid = $formData['frid'];
					if($formData['ftype'] == Core_PriceEnemy::TYPE_ONLINE)
					{
						$myPriceEnemy->url = $formData['furl'];
						$myPriceEnemy->pricepromotion = Helper::refineMoneyString($formData['fpricepromotion']);
						$myPriceEnemy->priceauto = Helper::refineMoneyString($formData['fpriceauto']);
						$myPriceEnemy->description = $formData['fdescription'];
						$myPriceEnemy->promotioninfo = $formData['fpromotioninfo'];
					}
					else
					{						
						$myPriceEnemy->name = $formData['fname'];
						$myPriceEnemy->price = Helper::refineMoneyString($formData['fprice']);
						$myPriceEnemy->pricepromotion = Helper::refineMoneyString($formData['fpricepromotion']);
						$myPriceEnemy->promotioninfo = $formData['fpromotioninfo'];
					}
					$myPriceEnemy->note = $formData['fnote'];
					$myPriceEnemy->status = Core_PriceEnemy::STATUS_NOTSYNC;					
                    if($myPriceEnemy->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('priceenemy_add', $myPriceEnemy->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['priceenemyAddToken']=Helper::getSecurityToken();//Tao token moi
		$enemys = Core_Enemy::getEnemys(array() , 'id' , 'ASC');
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'enemys'		=> $enemys,												
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
		$myPriceEnemy = new Core_PriceEnemy($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPriceEnemy->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpid'] = $myPriceEnemy->pid;
			$formData['fuid'] = $myPriceEnemy->uid;
			$formData['feid'] = $myPriceEnemy->eid;
			$formData['fid'] = $myPriceEnemy->id;
			$formData['furl'] = $myPriceEnemy->url;
			$formData['fprice'] = Helper::formatPrice($myPriceEnemy->price);
			$formData['fpriceauto'] = $myPriceEnemy->priceauto;
			$formData['fnote'] = $myPriceEnemy->note;
			$formData['fdisplayorder'] = $myPriceEnemy->displayorder;
			$formData['fstatus'] = $myPriceEnemy->status;
			$formData['fdatecreated'] = $myPriceEnemy->datecreated;
			$formData['fdateupdated'] = $myPriceEnemy->dateupdated;
			$formData['fdatesynced'] = $myPriceEnemy->datesynced;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['priceenemyEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPriceEnemy->pid = $formData['fpid'];
						$myPriceEnemy->uid = $formData['fuid'];
						$myPriceEnemy->eid = $formData['feid'];
						$myPriceEnemy->url = $formData['furl'];
						$myPriceEnemy->price = Helper::refineMoneyString($formData['fprice']);
						$myPriceEnemy->priceauto = $formData['fpriceauto'];
						$myPriceEnemy->note = $formData['fnote'];
						$myPriceEnemy->displayorder = $formData['fdisplayorder'];
						$myPriceEnemy->status = $formData['fstatus'];
						$myPriceEnemy->dateupdated = $formData['fdateupdated'];
						$myPriceEnemy->datesynced = $formData['fdatesynced'];
                        
                        if($myPriceEnemy->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('priceenemy_edit', $myPriceEnemy->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['priceenemyEditToken'] = Helper::getSecurityToken();//Tao token moi
			$enemys = Core_Enemy::getEnemys(array() , 'id' , 'ASC');
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'enemys'	=> $enemys,
													
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
		$myPriceEnemy = new Core_PriceEnemy($id);
		if($myPriceEnemy->id > 0)
		{
			//tien hanh xoa
			if($myPriceEnemy->delete())
			{
				$redirectMsg = str_replace('###id###', $myPriceEnemy->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('priceenemy_delete', $myPriceEnemy->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPriceEnemy->id, $this->registry->lang['controller']['errDelete']);
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

	public function searchproductajaxAction()
	{		
		$barcode = (string)$_POST['barcode'];

		//check role of user
		$productcategoryList = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id) , 'id' , 'ASC');

			if(count($roleusers) > 0)
			{
				foreach($roleusers as $roleuser)
				{					
					$productcategoryList[] = $roleuser->objectid;
				}
			}
		}			
		else
		{
			$list = Core_Productcategory::getProductcategorys(array('fparentidall' => 'all') , 'id' , 'ASC');
			foreach($list as $cat)
			{
				$productcategoryList[] = $cat->id;
			}
		}

		if(!empty($productcategoryList))
		{
			$products = Core_Product::getProducts(array('fbarcode' => $barcode , 'fpcidarrin' => $productcategoryList) , 'id' , 'ASC');
			if(!empty($products))
			{
				$product = $products[0];

				echo $product->id;
			}
			else
			{
				echo 'notfound';
			}
		}
		else
		{
			echo 'error';
		}
	}
	public function addpopupAction()
	{
		ini_set('memory_limit', '-1');
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		$barcode = $this->registry->router->getArg('pbarcode');

		//check role of user
		$productcategoryList = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id) , 'id' , 'ASC');

			if(count($roleusers) > 0)
			{
				foreach($roleusers as $roleuser)
				{					
					$productcategoryList[] = $roleuser->objectid;
				}
			}
		}			
		else
		{
			$list = Core_Productcategory::getProductcategorys(array('fparentidall' => 'all') , 'id' , 'ASC');
			foreach($list as $cat)
			{
				$productcategoryList[] = $cat->id;
			}
		}

		if(!empty($productcategoryList))
		{
			$products = Core_Product::getProducts(array('fbarcode' => $barcode , 'fpcidarrin' => $productcategoryList) , 'id' , 'ASC');
			if(!empty($products))
			{
				$product = $products[0]->id;
			}
		}
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['priceenemyAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPriceEnemy = new Core_PriceEnemy();

					$myProduct                    = new Core_Product($formData['fpid']);
					$myPriceEnemy->pid            = $formData['fpid'];
					$myPriceEnemy->pcid           = $myProduct->pcid; 						
					$myPriceEnemy->uid            = $this->registry->me->id;
					$myPriceEnemy->eid            = $formData['feid'];
					$myPriceEnemy->type           = $formData['ftype'];
					$myPriceEnemy->productname     = $formData['fproductname'];
					$myPriceEnemy->description    = $formData['fdescription'];
					$myPriceEnemy->rid            = $formData['frid'];			
					$myPriceEnemy->name           = $formData['fname'];
					$myPriceEnemy->price          = Helper::refineMoneyString($formData['fprice']);
					$myPriceEnemy->pricepromotion = Helper::refineMoneyString($formData['fpricepromotion']);
					$myPriceEnemy->promotioninfo  = $formData['fpromotioninfo'];
					$myPriceEnemy->note           = $formData['fnote'];
					$myPriceEnemy->status         = Core_PriceEnemy::STATUS_NOTSYNC;					
                    if($myPriceEnemy->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('priceenemy_add', $myPriceEnemy->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['priceenemyAddToken']=Helper::getSecurityToken();//Tao token moi
		$enemys = Core_Enemy::getEnemys(array() , 'id' , 'ASC');
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'enemys'		=> $enemys,										
												'product'		=> $product		
												));
		$contents .= $this->registry->smarty->display($this->registry->smartyControllerContainer.'addpopup.tpl');
	}
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fpid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
			$pass = false;
		}		

		if($formData['feid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errEidMustGreaterThanZero'];
			$pass = false;
		}
		if(empty($formData['fname']))
		{
			$error[] = $this->registry->lang['controller']['errorName'];
			$pass = false;
		}
		// if($formData['furl'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errUrlRequired'];
		// 	$pass = false;
		// }		
		
		//check exist of price
		/*if($formData['fpid'] > 0 && $formData['feid'] > 0)
		{
			$counter = Core_PriceEnemy::getPriceEnemys(array('fpid' => $formData['fpid'] , 'feid' => $formData['feid']) , 'id' , 'ASC' , '' , true);

			if($counter  > 0)
			{
				$error[] = $this->registry->lang['controller']['errPriceEnemyExist'];
				$pass = false;
			}
		}*/

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fpid'] > 0)
			{
				$checker = false;
				$myProduct = new Core_Product($formData['fpid']);
				$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id) , 'id' , 'ASC');

				if(count($roleusers) > 0)
				{
					foreach($roleusers as $roleuser)
					{
						if($roleuser->objectid == $myProduct->pcid)
						{
							$checker = true;
							break;
						}
					}

					if(!$checker)
					{
						$error[] = $this->registry->lang['controller']['errAddPermission'];
						$pass = false;
					}
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errAddPermission'];
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
		
		

		if($formData['fpid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPidMustGreaterThanZero'];
			$pass = false;
		}
		
		if($formData['feid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errEidMustGreaterThanZero'];
			$pass = false;
		}

		// if($formData['furl'] == '')
		// {
		// 	$error[] = $this->registry->lang['controller']['errUrlRequired'];
		// 	$pass = false;
		// }
				
		return $pass;
	}

	function editpopupAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myPriceEnemy = new Core_PriceEnemy($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPriceEnemy->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpid']            = $myPriceEnemy->pid;
			$formData['fuid']            = $myPriceEnemy->uid;
			$formData['feid']            = $myPriceEnemy->eid;
			$formData['fid']             = $myPriceEnemy->id;
			$formData['fproductname']	 = $myPriceEnemy->productname;	
			$formData['furl']            = $myPriceEnemy->url;
			$formData['fpricepromotion'] = Helper::formatPrice($myPriceEnemy->pricepromotion);
			$formData['fprice']          = Helper::formatPrice($myPriceEnemy->price);
			$formData['fpriceauto']      = $myPriceEnemy->priceauto;
			$formData['fdescription']    = $myPriceEnemy->description;
			$formData['fpromotioninfo']  = $myPriceEnemy->promotioninfo;
			$formData['fname']           = $myPriceEnemy->name;
			$formData['ftype']           = $myPriceEnemy->type;
			$formData['fnote']           = $myPriceEnemy->note;
			$formData['fdisplayorder']   = $myPriceEnemy->displayorder;
			$formData['fstatus']         = $myPriceEnemy->status;
			$formData['fdatecreated']    = $myPriceEnemy->datecreated;
			$formData['fdateupdated']    = $myPriceEnemy->dateupdated;
			$formData['fdatesynced']     = $myPriceEnemy->datesynced;
			$formData['fimage']			 = $myPriceEnemy->image;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['priceenemyEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPriceEnemy->pid            = $formData['fpid'];
						$myPriceEnemy->uid            = $formData['fuid'];
						$myPriceEnemy->eid            = $formData['feid'];			
						$myPriceEnemy->name           = $formData['fname'];
						$myPriceEnemy->price          = Helper::refineMoneyString($formData['fprice']);
						$myPriceEnemy->pricepromotion = Helper::refineMoneyString($formData['fpricepromotion']);
						$myPriceEnemy->promotioninfo  = $formData['fpromotioninfo'];
						$myPriceEnemy->productname     = $formData['fproductname'];
						$myPriceEnemy->description    = $formData['fdescription'];
						$myPriceEnemy->note           = $formData['fnote'];
						$myPriceEnemy->displayorder   = $formData['fdisplayorder'];
						$myPriceEnemy->status         = $formData['fstatus'];
						$myPriceEnemy->dateupdated    = $formData['fdateupdated'];
						$myPriceEnemy->datesynced     = $formData['fdatesynced'];
                        
                        if($myPriceEnemy->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('priceenemy_edit', $myPriceEnemy->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['priceenemyEditToken'] = Helper::getSecurityToken();//Tao token moi
			$enemys = Core_Enemy::getEnemys(array() , 'id' , 'ASC');
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'enemys'	=> $enemys,
													
													));
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'editpopup.tpl');
			
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
	public function showdescriptionenemyAction()
    {
    	$id = $this->registry->router->getArg('id');
    	$myPriceEnemy = new Core_PriceEnemy($id);
    	if($myPriceEnemy->id > 0)
    	{
    		$this->registry->smarty->assign(array('priceenemy'=>$myPriceEnemy));
    		$this->registry->smarty->display($this->registry->smartyControllerContainer.'showdecriptionenemy.tpl');
    	}
    }
}

