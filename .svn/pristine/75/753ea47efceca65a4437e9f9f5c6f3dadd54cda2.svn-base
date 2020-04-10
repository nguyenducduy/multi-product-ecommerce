<?php

Class Controller_Admin_ApidocRequestParameter Extends Controller_Admin_Base 
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
		
		
		$aridFilter = (int)($this->registry->router->getArg('arid'));
		$isrequiredFilter = (int)($this->registry->router->getArg('isrequired'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
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
            if($_SESSION['apidocrequestparameterBulkToken']==$_POST['ftoken'])
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
                            $myApidocRequestParameter = new Core_ApidocRequestParameter($id);
                            
                            if($myApidocRequestParameter->id > 0)
                            {
                                //tien hanh xoa
                                if($myApidocRequestParameter->delete())
                                {
                                    $deletedItems[] = $myApidocRequestParameter->id;
                                    $this->registry->me->writelog('apidocrequestparameter_delete', $myApidocRequestParameter->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApidocRequestParameter->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApidocRequestParameter->id;
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
		
		$_SESSION['apidocrequestparameterBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($aridFilter > 0)
		{
			$paginateUrl .= 'arid/'.$aridFilter . '/';
			$formData['farid'] = $aridFilter;
			$formData['search'] = 'arid';
		}

		if($isrequiredFilter > 0)
		{
			$paginateUrl .= 'isrequired/'.$isrequiredFilter . '/';
			$formData['fisrequired'] = $isrequiredFilter;
			$formData['search'] = 'isrequired';
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
			elseif($searchKeywordIn == 'datatype')
			{
				$paginateUrl .= 'searchin/datatype/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_ApidocRequestParameter::getApidocRequestParameters($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apidocrequestparameters = Core_ApidocRequestParameter::getApidocRequestParameters($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'apidocrequestparameters' 	=> $apidocrequestparameters,
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
            if($_SESSION['apidocrequestparameterAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApidocRequestParameter = new Core_ApidocRequestParameter();

					
					$myApidocRequestParameter->arid = $formData['farid'];
					$myApidocRequestParameter->name = $formData['fname'];
					$myApidocRequestParameter->summary = $formData['fsummary'];
					$myApidocRequestParameter->datatype = $formData['fdatatype'];
					$myApidocRequestParameter->isrequired = $formData['fisrequired'];
					$myApidocRequestParameter->displayorder = $formData['fdisplayorder'];
					
                    if($myApidocRequestParameter->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apidocrequestparameter_add', $myApidocRequestParameter->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apidocrequestparameterAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myApidocRequestParameter = new Core_ApidocRequestParameter($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApidocRequestParameter->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['farid'] = $myApidocRequestParameter->arid;
			$formData['fid'] = $myApidocRequestParameter->id;
			$formData['fname'] = $myApidocRequestParameter->name;
			$formData['fsummary'] = $myApidocRequestParameter->summary;
			$formData['fdatatype'] = $myApidocRequestParameter->datatype;
			$formData['fisrequired'] = $myApidocRequestParameter->isrequired;
			$formData['fdisplayorder'] = $myApidocRequestParameter->displayorder;
			$formData['fdatecreated'] = $myApidocRequestParameter->datecreated;
			$formData['fdatemodified'] = $myApidocRequestParameter->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apidocrequestparameterEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApidocRequestParameter->arid = $formData['farid'];
						$myApidocRequestParameter->name = $formData['fname'];
						$myApidocRequestParameter->summary = $formData['fsummary'];
						$myApidocRequestParameter->datatype = $formData['fdatatype'];
						$myApidocRequestParameter->isrequired = $formData['fisrequired'];
						$myApidocRequestParameter->displayorder = $formData['fdisplayorder'];
                        
                        if($myApidocRequestParameter->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apidocrequestparameter_edit', $myApidocRequestParameter->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['apidocrequestparameterEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myApidocRequestParameter = new Core_ApidocRequestParameter($id);
		if($myApidocRequestParameter->id > 0)
		{
			//tien hanh xoa
			if($myApidocRequestParameter->delete())
			{
				$redirectMsg = str_replace('###id###', $myApidocRequestParameter->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apidocrequestparameter_delete', $myApidocRequestParameter->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApidocRequestParameter->id, $this->registry->lang['controller']['errDelete']);
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