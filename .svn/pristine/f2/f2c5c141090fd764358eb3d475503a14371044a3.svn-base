<?php

Class Controller_Admin_ApidocGroup Extends Controller_Admin_Base 
{
	private $recordPerPage = 1000;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$zoneFilter = (int)($this->registry->router->getArg('zone'));
		
		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');
		
		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'zonedisplayorder';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype'] = $sorttype;	
		
		if(!empty($_POST['fsubmitchangeorder']))
		{
			//group display order
			$groupArr = $_POST['fgroupdisplayorder'];
			foreach($groupArr as $id => $displayorder)
			{
				$myApidocGroup = new Core_Backend_ApidocGroup($id);
				$myApidocGroup->displayorder = (int)$displayorder;
				$myApidocGroup->updateData();
			}
			
			//group display order
			$requestArr = $_POST['frequestdisplayorder'];
			foreach($requestArr as $id => $displayorder)
			{
				$myApidocRequest = new Core_Backend_ApidocRequest($id);
				$myApidocRequest->displayorder = (int)$displayorder;
				$myApidocRequest->updateData();
			}
			$success[] = 'Update Display Order of GROUP &amp; REQUEST Successfully.';
		}
		
		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['apidocgroupBulkToken']==$_POST['ftoken'])
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
                            $myApidocGroup = new Core_Backend_ApidocGroup($id);
                            
                            if($myApidocGroup->id > 0)
                            {
                                //tien hanh xoa
                                if($myApidocGroup->delete())
                                {
                                    $deletedItems[] = $myApidocGroup->id;
                                    $this->registry->me->writelog('apidocgroup_delete', $myApidocGroup->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApidocGroup->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApidocGroup->id;
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
		
		$_SESSION['apidocgroupBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($displayorderFilter > 0)
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($zoneFilter > 0)
		{
			$paginateUrl .= 'zone/'.$zoneFilter . '/';
			$formData['fzone'] = $zoneFilter;
			$formData['search'] = 'zone';
		}
		
		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			elseif($searchKeywordIn == 'summary')
			{
				$paginateUrl .= 'searchin/summary/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ApidocGroup::getApidocGroups($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apidocgroups = Core_Backend_ApidocGroup::getApidocGroups($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		///////
		//get request
		for($i = 0; $i < count($apidocgroups); $i++)
		{
			$requestList = Core_Backend_ApidocRequest::getApidocRequests(array('fagid' => $apidocgroups[$i]->id), 'displayorder', 'ASC', '');
			$apidocgroups[$i]->requestList = $requestList;
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
		
				
		$this->registry->smarty->assign(array(	'apidocgroups' 	=> $apidocgroups,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'zoneList'		=> Core_Backend_ApidocGroup::getZoneList(),
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
            if($_SESSION['apidocgroupAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApidocGroup = new Core_Backend_ApidocGroup();

					
					$myApidocGroup->name = $formData['fname'];
					$myApidocGroup->summary = $formData['fsummary'];
					$myApidocGroup->zone = $formData['fzone'];
					$myApidocGroup->status = $formData['fstatus'];
					
                    if($myApidocGroup->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apidocgroup_add', $myApidocGroup->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apidocgroupAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'statusList'	=> Core_Backend_ApidocGroup::getStatusList(),
												'zoneList'		=> Core_Backend_ApidocGroup::getZoneList(),
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
		$myApidocGroup = new Core_Backend_ApidocGroup($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApidocGroup->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myApidocGroup->id;
			$formData['fname'] = $myApidocGroup->name;
			$formData['fsummary'] = $myApidocGroup->summary;
			$formData['fzone'] = $myApidocGroup->zone;
			$formData['fstatus'] = $myApidocGroup->status;
			$formData['fdisplayorder'] = $myApidocGroup->displayorder;
			$formData['fdatecreated'] = $myApidocGroup->datecreated;
			$formData['fdatemodified'] = $myApidocGroup->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apidocgroupEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApidocGroup->name = $formData['fname'];
						$myApidocGroup->summary = $formData['fsummary'];
						$myApidocGroup->zone = $formData['fzone'];
						$myApidocGroup->status = $formData['fstatus'];
						$myApidocGroup->displayorder = $formData['fdisplayorder'];
                        
                        if($myApidocGroup->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apidocgroup_edit', $myApidocGroup->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['apidocgroupEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'statusList'	=> Core_Backend_ApidocGroup::getStatusList(),
													'zoneList'		=> Core_Backend_ApidocGroup::getZoneList(),
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
		$myApidocGroup = new Core_Backend_ApidocGroup($id);
		if($myApidocGroup->id > 0)
		{
			//tien hanh xoa
			if($myApidocGroup->delete())
			{
				$redirectMsg = str_replace('###id###', $myApidocGroup->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apidocgroup_delete', $myApidocGroup->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApidocGroup->id, $this->registry->lang['controller']['errDelete']);
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