<?php

Class Controller_Cms_RelRegionPricearea Extends Controller_Cms_Base 
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
		
		
		$ppaidFilter = (int)($this->registry->router->getArg('ppaid'));
		$ridFilter = (int)($this->registry->router->getArg('rid'));
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
            if($_SESSION['relregionpriceareaBulkToken']==$_POST['ftoken'])
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
                            $myRelRegionPricearea = new Core_RelRegionPricearea($id);
                            
                            if($myRelRegionPricearea->id > 0)
                            {
                                //tien hanh xoa
                                if($myRelRegionPricearea->delete())
                                {
                                    $deletedItems[] = $myRelRegionPricearea->id;
                                    $this->registry->me->writelog('relregionpricearea_delete', $myRelRegionPricearea->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myRelRegionPricearea->id;
                            }
                            else
                                $cannotDeletedItems[] = $myRelRegionPricearea->id;
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
		
		$_SESSION['relregionpriceareaBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($ppaidFilter > 0)
		{
			$paginateUrl .= 'ppaid/'.$ppaidFilter . '/';
			$formData['fppaid'] = $ppaidFilter;
			$formData['search'] = 'ppaid';
		}

		if($ridFilter > 0)
		{
			$paginateUrl .= 'rid/'.$ridFilter . '/';
			$formData['frid'] = $ridFilter;
			$formData['search'] = 'rid';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_RelRegionPricearea::getRelRegionPriceareas($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$relregionpriceareas = Core_RelRegionPricearea::getRelRegionPriceareas($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
        $listpricearea= Core_ProductPriceArea::getProductPriceAreas(array(),'','');
        $newlistpricearea = array();
        
        if(!empty($listpricearea))
        {
            foreach($listpricearea as $price)
            {
                $newlistpricearea[$price->id] = $price;
            }
        }
        
        $newlistregion = array();
        $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
        if(!empty($listregion))
        {
            foreach($listregion as $price)
            {
                $listregion[$price->id] = $price;
            }
        }
        
        $newlistuser = array();
        $newlistarea = array();
        if(!empty($relregionpriceareas))
        {
            $arr_uid = array();
            $arr_aid = array();
            foreach($relregionpriceareas as $rrpa)
            {
                if(!in_array($rrpa->uid, $arr_uid))
                {
                    $arr_uid[] = $rrpa->uid;
                }
                if(!in_array($rrpa->aid, $arr_aid))
                {
                    $arr_aid[] = $rrpa->aid;
                }
            }
            if(!empty($arr_uid))
            {
                $listuserid = Core_User::getUsers(array('fidlist'=>$arr_uid),'','');
                //var_dump($listuserid);
                if(!empty($listuserid))
                {
                    foreach($listuserid as $uid)
                    {
                        $newlistuser[$uid->id] = $uid;
                    }
                }
            }
            if(!empty($arr_aid))
            {
                $listarea = Core_Area::getAreas(array('faidarr'=>$arr_aid),'fname','ASC');
                //var_dump($listuserid);
                if(!empty($listarea))
                {
                    foreach($listarea as $aid)
                    {
                        $newlistarea[$aid->id] = $aid;
                    }
                }
            }
        }
        $formData['listuser'] = $newlistuser;
        $formData['listarea'] = $newlistarea;
        $formData['listpricearea'] = $newlistpricearea;
        $formData['listregion'] = $listregion;
        $ispermisison = false;
        if($this->registry->me->isgroup('administrator') || $this->registry->me->isgroup('developer'))
        {
            $formData['ispermisison'] = true;
        }
		$this->registry->smarty->assign(array(	'relregionpriceareas' 	=> $relregionpriceareas,
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
            if($_SESSION['relregionpriceareaAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myRelRegionPricearea = new Core_RelRegionPricearea();

					
					$myRelRegionPricearea->ppaid = $formData['fppaid'];
                    $myRelRegionPricearea->rid = $formData['frid'];
                    $myRelRegionPricearea->aid = $formData['faid'];
					$myRelRegionPricearea->uid = $this->registry->me->id;
					
                    if($myRelRegionPricearea->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('relregionpricearea_add', $myRelRegionPricearea->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		$listpricearea= Core_ProductPriceArea::getProductPriceAreas(array(),'','');
        $newlistpricearea = array();
        
        if(!empty($listpricearea))
        {
            foreach($listpricearea as $price)
            {
                $newlistpricearea[$price->id] = $price;
            }
        }
        $newlistarea = array();
        $listarea = Core_Area::getAreas(array(),'fname','ASC');
        if(!empty($listarea))
        {
            foreach($listarea as $aid)
            {
                $newlistarea[$aid->id] = $aid;
            }
        }
        
        $newlistregion = array();
        $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
        if(!empty($listregion))
        {
            foreach($listregion as $price)
            {
                $listregion[$price->id] = $price;
            }
        }
        
        $formData['listpricearea'] = $newlistpricearea;
        $formData['listarea'] = $newlistarea;
        $formData['listregion'] = $listregion;
		$_SESSION['relregionpriceareaAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myRelRegionPricearea = new Core_RelRegionPricearea($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myRelRegionPricearea->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myRelRegionPricearea->uid;
			$formData['fppaid'] = $myRelRegionPricearea->ppaid;
            $formData['frid'] = $myRelRegionPricearea->rid;
			$formData['faid'] = $myRelRegionPricearea->aid;
			$formData['fid'] = $myRelRegionPricearea->id;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['relregionpriceareaEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myRelRegionPricearea->ppaid = $formData['fppaid'];
                        $myRelRegionPricearea->rid = $formData['frid'];
                        $myRelRegionPricearea->uid = $formData['fuid'];
                        $myRelRegionPricearea->aid = $formData['faid'];
						$myRelRegionPricearea->ppaid = $formData['fppaid'];
                        
                        if($myRelRegionPricearea->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('relregionpricearea_edit', $myRelRegionPricearea->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			$listpricearea= Core_ProductPriceArea::getProductPriceAreas(array(),'','');
            $newlistpricearea = array();
            
            if(!empty($listpricearea))
            {
                foreach($listpricearea as $price)
                {
                    $newlistpricearea[$price->id] = $price;
                }
            }
            
            $newlistarea = array();
            $listarea = Core_Area::getAreas(array(),'fname','ASC');
            if(!empty($listarea))
            {
                foreach($listarea as $aid)
                {
                    $newlistarea[$aid->id] = $aid;
                }
            }
            
            $newlistregion = array();
            $listregion = Core_Region::getRegions(array('fparentid' => 0),'fname','ASC');
            if(!empty($listregion))
            {
                foreach($listregion as $price)
                {
                    $listregion[$price->id] = $price;
                }
            }
            $formData['listarea'] = $newlistarea;
            $formData['listpricearea'] = $newlistpricearea;
            $formData['listregion'] = $listregion;
        
			$_SESSION['relregionpriceareaEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myRelRegionPricearea = new Core_RelRegionPricearea($id);
		if($myRelRegionPricearea->id > 0)
		{
			//tien hanh xoa
			if($myRelRegionPricearea->delete())
			{
				$redirectMsg = str_replace('###id###', $myRelRegionPricearea->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('relregionpricearea_delete', $myRelRegionPricearea->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myRelRegionPricearea->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fppaid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPpaidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRidMustGreaterThanZero'];
			$pass = false;
		}
        
        if($formData['faid'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errAidMustGreaterThanZero'];
            $pass = false;
        }
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fppaid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPpaidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRidMustGreaterThanZero'];
			$pass = false;
		}
		
        if($formData['faid'] <= 0)
        {
            $error[] = $this->registry->lang['controller']['errAidMustGreaterThanZero'];
            $pass = false;
        }		
		return $pass;
	}
}

