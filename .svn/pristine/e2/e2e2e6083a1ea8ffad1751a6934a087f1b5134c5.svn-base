<?php

Class Controller_Admin_ApiPartnerSaleRequest Extends Controller_Cms_Base 
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
		
		
		$apidFilter = (int)($this->registry->router->getArg('apid'));
		$parameterFilter = (string)($this->registry->router->getArg('parameter'));
		$recordFilter = (int)($this->registry->router->getArg('record'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
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
            if($_SESSION['apipartnersalerequestBulkToken']==$_POST['ftoken'])
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
                            $myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest($id);
                            
                            if($myApiPartnerSaleRequest->id > 0)
                            {
                                //tien hanh xoa
                                if($myApiPartnerSaleRequest->delete())
                                {
                                    $deletedItems[] = $myApiPartnerSaleRequest->id;
                                    $this->registry->me->writelog('apipartnersalerequest_delete', $myApiPartnerSaleRequest->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApiPartnerSaleRequest->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApiPartnerSaleRequest->id;
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
		
		$_SESSION['apipartnersalerequestBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($apidFilter > 0)
		{
			$paginateUrl .= 'apid/'.$apidFilter . '/';
			$formData['fapid'] = $apidFilter;
			$formData['search'] = 'apid';
		}

		if($parameterFilter != "")
		{
			$paginateUrl .= 'parameter/'.$parameterFilter . '/';
			$formData['fparameter'] = $parameterFilter;
			$formData['search'] = 'parameter';
		}

		if($recordFilter > 0)
		{
			$paginateUrl .= 'record/'.$recordFilter . '/';
			$formData['frecord'] = $recordFilter;
			$formData['search'] = 'record';
		}

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
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

			if($searchKeywordIn == 'parameter')
			{
				$paginateUrl .= 'searchin/parameter/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ApiPartnerSaleRequest::getApiPartnerSaleRequests($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apipartnersalerequests = Core_Backend_ApiPartnerSaleRequest::getApiPartnerSaleRequests($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		if(count($apipartnersalerequests) > 0)
		{
			foreach($apipartnersalerequests as $apipartnersalerequest)
			{
				$apipartnersalerequest->apipartneractor = new Core_Backend_ApiPartner($apipartnersalerequest->apid);
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
		
				
		$this->registry->smarty->assign(array(	'apipartnersalerequests' 	=> $apipartnersalerequests,
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
            if($_SESSION['apipartnersalerequestAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest();

					
					$myApiPartnerSaleRequest->apid = $formData['fapid'];
					$myApiPartnerSaleRequest->parameter = $formData['fparameter'];
					$myApiPartnerSaleRequest->executetime = $formData['fexecutetime'];
					$myApiPartnerSaleRequest->record = $formData['frecord'];
					$myApiPartnerSaleRequest->ipaddress = $formData['fipaddress'];
					
                    if($myApiPartnerSaleRequest->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apipartnersalerequest_add', $myApiPartnerSaleRequest->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apipartnersalerequestAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApiPartnerSaleRequest->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fapid'] = $myApiPartnerSaleRequest->apid;
			$formData['fid'] = $myApiPartnerSaleRequest->id;
			$formData['fparameter'] = $myApiPartnerSaleRequest->parameter;
			$formData['fexecutetime'] = $myApiPartnerSaleRequest->executetime;
			$formData['frecord'] = $myApiPartnerSaleRequest->record;
			$formData['fipaddress'] = $myApiPartnerSaleRequest->ipaddress;
			$formData['fdatecreated'] = $myApiPartnerSaleRequest->datecreated;
			$formData['fdatemodified'] = $myApiPartnerSaleRequest->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apipartnersalerequestEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApiPartnerSaleRequest->apid = $formData['fapid'];
						$myApiPartnerSaleRequest->parameter = $formData['fparameter'];
						$myApiPartnerSaleRequest->executetime = $formData['fexecutetime'];
						$myApiPartnerSaleRequest->record = $formData['frecord'];
						$myApiPartnerSaleRequest->ipaddress = $formData['fipaddress'];
                        
                        if($myApiPartnerSaleRequest->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apipartnersalerequest_edit', $myApiPartnerSaleRequest->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['apipartnersalerequestEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myApiPartnerSaleRequest = new Core_Backend_ApiPartnerSaleRequest($id);
		if($myApiPartnerSaleRequest->id > 0)
		{
			//tien hanh xoa
			if($myApiPartnerSaleRequest->delete())
			{
				$redirectMsg = str_replace('###id###', $myApiPartnerSaleRequest->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apipartnersalerequest_delete', $myApiPartnerSaleRequest->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApiPartnerSaleRequest->id, $this->registry->lang['controller']['errDelete']);
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

?>