<?php

Class Controller_Cms_Region Extends Controller_Cms_Base 
{
	private $recordPerPage = 100;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'displayorder';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['regionBulkToken']==$_POST['ftoken'])
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
                            $myRegion = new Core_Region($id);
                            
                            if($myRegion->id > 0)
                            {
                                //tien hanh xoa
                                if($myRegion->delete())
                                {
                                    $deletedItems[] = $myRegion->id;
                                    $this->registry->me->writelog('region_delete', $myRegion->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myRegion->id;
                            }
                            else
                                $cannotDeletedItems[] = $myRegion->id;
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
		
		$_SESSION['regionBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup.'/'.$this->registry->controller.'/index/';      
		
		

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
		}
		else
			$formData['fparentid'] = 0;

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Region::getRegions($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		$regions = Core_Region::getRegions($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		for($i = 0; $i < count($regions); $i++)
		{
			if($regions[$i]->parentid > 0)
			{
				$regions[$i]->parent = new Core_Region($regions[$i]->parentid);
			}
			else
			{
				//count the subregion
				$regions[$i]->countsubregion = Core_Region::getRegions(array('fparentid' => $regions[$i]->id), '', '', '', true);
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
		
				
		$this->registry->smarty->assign(array(	'regions' 	=> $regions,
												'formData'		=> $formData,
												'regionList'	=> Core_Region::getRegions(array('fparentid' => 0), 'displayorder', 'ASC', 100),
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
            if($_SESSION['regionAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);

                $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                if($formData['fslug'] != '')
                    $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myRegion = new Core_Region();

					
					$myRegion->name = $formData['fname'];
					$myRegion->slug = $formData['fslug'];
					$myRegion->displayorder = $formData['fdisplayorder'];
					$myRegion->parentid = $formData['fparentid'];
					
                    if($myRegion->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('region_add', $myRegion->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['regionAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'regionList'	=> Core_Region::getRegions(array('fparentid' => 0), 'displayorder', 'ASC', 100),
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
		$myRegion = new Core_Region($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myRegion->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myRegion->id;
			$formData['fname'] = $myRegion->name;
			$formData['fslug'] = $myRegion->slug;
			$formData['fdisplayorder'] = $myRegion->displayorder;
			$formData['fparentid'] = $myRegion->parentid;
			$formData['fisinshore'] = $myRegion->isinshore;
			$formData['fpriceshiphalf'] = $myRegion->priceshiphalf;
			$formData['fpriceshipone'] = $myRegion->priceshipone;
			$formData['fpriceshiponehalf'] = $myRegion->priceshiponehalf;
			$formData['fpriceshiptwo'] = $myRegion->priceshiptwo;
			$formData['fpriceshipmorehalf'] = $myRegion->priceshipmorehalf;
			$formData['flat'] = $myRegion->lat;
			$formData['flng'] = $myRegion->lng;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['regionEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    $formData['fslug'] = Helper::codau2khongdau(($formData['fslug'] != '') ? $formData['fslug'] : $formData['fname'], true, true);
                    if($formData['fslug'] != '')
                        $slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myRegion->name = $formData['fname'];
						$myRegion->slug = $formData['fslug'];
						$myRegion->displayorder = $formData['fdisplayorder'];
						$myRegion->parentid = $formData['fparentid'];
						$myRegion->isinshore = $formData['fisinshore'];
						$myRegion->priceshiphalf = $formData['fpriceshiphalf'];
						$myRegion->priceshipone = $formData['fpriceshipone'];
						$myRegion->priceshiponehalf = $formData['fpriceshiponehalf'];
						$myRegion->priceshiptwo = $formData['fpriceshiptwo'];
						$myRegion->priceshipmorehalf = $formData['fpriceshipmorehalf'];
						$myRegion->lat = $formData['flat'];
						$myRegion->lng = $formData['flng'];						
                        
                        if($myRegion->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('region_edit', $myRegion->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['regionEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'regionList'	=> Core_Region::getRegions(array('fparentid' => 0), 'displayorder', 'ASC', 100),
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
		$myRegion = new Core_Region($id);
		if($myRegion->id > 0)
		{
			//tien hanh xoa
			if($myRegion->delete())
			{
				$redirectMsg = str_replace('###id###', $myRegion->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('region_delete', $myRegion->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myRegion->id, $this->registry->lang['controller']['errDelete']);
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

    public function addslugAction(){

        $listregion = Core_Region::getRegions(array(),'','');
        foreach($listregion as $region){
           $slug = Helper::codau2khongdau($region->name,true, true);
            $sql = 'UPDATE ' . TABLE_PREFIX . 'region
                SET r_slug = ?
                WHERE r_id = ?';
            $this->registry->db->query($sql, array($slug,$region->id));
        }
        die('d');
    }
}

