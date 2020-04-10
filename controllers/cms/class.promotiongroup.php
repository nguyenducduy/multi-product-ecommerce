<?php

Class Controller_Cms_Promotiongroup Extends Controller_Cms_Base 
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
		
		
		$promolgnameFilter = (int)($this->registry->router->getArg('promolgname'));
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
            if($_SESSION['promotiongroupBulkToken']==$_POST['ftoken'])
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
                            $myPromotiongroup = new Core_Promotiongroup($id);
                            
                            if($myPromotiongroup->id > 0)
                            {
                                //tien hanh xoa
                                if($myPromotiongroup->delete())
                                {
                                    $deletedItems[] = $myPromotiongroup->id;
                                    $this->registry->me->writelog('promotiongroup_delete', $myPromotiongroup->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPromotiongroup->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPromotiongroup->id;
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
		
		$_SESSION['promotiongroupBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($promolgnameFilter > 0)
		{
			$paginateUrl .= 'promolgname/'.$promolgnameFilter . '/';
			$formData['fpromolgname'] = $promolgnameFilter;
			$formData['search'] = 'promolgname';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Promotiongroup::getPromotiongroups($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$promotiongroups = Core_Promotiongroup::getPromotiongroups($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'promotiongroups' 	=> $promotiongroups,
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
            if($_SESSION['promotiongroupAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myPromotiongroup = new Core_Promotiongroup();

					
					$myPromotiongroup->promoid = $formData['fpromoid'];
					$myPromotiongroup->promolgusercreate = $formData['fpromolgusercreate'];
					$myPromotiongroup->promolguserdeleted = $formData['fpromolguserdeleted'];
					$myPromotiongroup->promolgisfixed = $formData['fpromolgisfixed'];
					$myPromotiongroup->promolgisdeleted = $formData['fpromolgisdeleted'];
					$myPromotiongroup->promolgisdiscount = $formData['fpromolgisdiscount'];
					$myPromotiongroup->promolgdiscountvalue = $formData['fpromolgdiscountvalue'];
					$myPromotiongroup->promolgisdiscountpercent = $formData['fpromolgisdiscountpercent'];
					$myPromotiongroup->promolgiscondition = $formData['fpromolgiscondition'];
					$myPromotiongroup->promolgconditiontext = $formData['fpromolgconditiontext'];
					$myPromotiongroup->promolgtype = $formData['fpromolgtype'];
					$myPromotiongroup->promotiondateadd = $formData['fpromotiondateadd'];
					$myPromotiongroup->promolgdatemodify = $formData['fpromolgdatemodify'];
					
                    if($myPromotiongroup->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('promotiongroup_add', $myPromotiongroup->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['promotiongroupAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myPromotiongroup = new Core_Promotiongroup($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPromotiongroup->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpromoid'] = $myPromotiongroup->promoid;
			$formData['fid'] = $myPromotiongroup->id;
			$formData['fpromolgusercreate'] = $myPromotiongroup->promolgusercreate;
			$formData['fpromolguserdeleted'] = $myPromotiongroup->promolguserdeleted;
			$formData['fpromolgname'] = $myPromotiongroup->promolgname;
			$formData['fpromolgisfixed'] = $myPromotiongroup->promolgisfixed;
			$formData['fpromolgisdeleted'] = $myPromotiongroup->promolgisdeleted;
			$formData['fpromolgisdiscount'] = $myPromotiongroup->promolgisdiscount;
			$formData['fpromolgdiscountvalue'] = $myPromotiongroup->promolgdiscountvalue;
			$formData['fpromolgisdiscountpercent'] = $myPromotiongroup->promolgisdiscountpercent;
			$formData['fpromolgiscondition'] = $myPromotiongroup->promolgiscondition;
			$formData['fpromolgconditiontext'] = $myPromotiongroup->promolgconditiontext;
			$formData['fpromolgtype'] = $myPromotiongroup->promolgtype;
			$formData['fpromotiondateadd'] = $myPromotiongroup->promotiondateadd;
			$formData['fpromolgdatemodify'] = $myPromotiongroup->promolgdatemodify;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['promotiongroupEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPromotiongroup->promoid = $formData['fpromoid'];
						$myPromotiongroup->promolgusercreate = $formData['fpromolgusercreate'];
						$myPromotiongroup->promolguserdeleted = $formData['fpromolguserdeleted'];
						$myPromotiongroup->promolgisfixed = $formData['fpromolgisfixed'];
						$myPromotiongroup->promolgisdeleted = $formData['fpromolgisdeleted'];
						$myPromotiongroup->promolgisdiscount = $formData['fpromolgisdiscount'];
						$myPromotiongroup->promolgdiscountvalue = $formData['fpromolgdiscountvalue'];
						$myPromotiongroup->promolgisdiscountpercent = $formData['fpromolgisdiscountpercent'];
						$myPromotiongroup->promolgiscondition = $formData['fpromolgiscondition'];
						$myPromotiongroup->promolgconditiontext = $formData['fpromolgconditiontext'];
						$myPromotiongroup->promolgtype = $formData['fpromolgtype'];
						$myPromotiongroup->promotiondateadd = $formData['fpromotiondateadd'];
						$myPromotiongroup->promolgdatemodify = $formData['fpromolgdatemodify'];
                        
                        if($myPromotiongroup->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('promotiongroup_edit', $myPromotiongroup->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['promotiongroupEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myPromotiongroup = new Core_Promotiongroup($id);
		if($myPromotiongroup->id > 0)
		{
			//tien hanh xoa
			if($myPromotiongroup->delete())
			{
				$redirectMsg = str_replace('###id###', $myPromotiongroup->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('promotiongroup_delete', $myPromotiongroup->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPromotiongroup->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fpromolgname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPromolgnameRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fpromolgname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPromolgnameRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

