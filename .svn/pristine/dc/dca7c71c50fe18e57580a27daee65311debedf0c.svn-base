<?php

Class Controller_Admin_ApidocRequestResponse Extends Controller_Admin_Base 
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
		$contenttypeFilter = (int)($this->registry->router->getArg('contenttype'));
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
            if($_SESSION['apidocrequestresponseBulkToken']==$_POST['ftoken'])
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
                            $myApidocRequestResponse = new Core_ApidocRequestResponse($id);
                            
                            if($myApidocRequestResponse->id > 0)
                            {
                                //tien hanh xoa
                                if($myApidocRequestResponse->delete())
                                {
                                    $deletedItems[] = $myApidocRequestResponse->id;
                                    $this->registry->me->writelog('apidocrequestresponse_delete', $myApidocRequestResponse->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApidocRequestResponse->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApidocRequestResponse->id;
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
		
		$_SESSION['apidocrequestresponseBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($aridFilter > 0)
		{
			$paginateUrl .= 'arid/'.$aridFilter . '/';
			$formData['farid'] = $aridFilter;
			$formData['search'] = 'arid';
		}

		if($contenttypeFilter > 0)
		{
			$paginateUrl .= 'contenttype/'.$contenttypeFilter . '/';
			$formData['fcontenttype'] = $contenttypeFilter;
			$formData['search'] = 'contenttype';
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

			if($searchKeywordIn == 'output')
			{
				$paginateUrl .= 'searchin/output/';
			}
			elseif($searchKeywordIn == 'sample')
			{
				$paginateUrl .= 'searchin/sample/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_ApidocRequestResponse::getApidocRequestResponses($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apidocrequestresponses = Core_ApidocRequestResponse::getApidocRequestResponses($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'apidocrequestresponses' 	=> $apidocrequestresponses,
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
            if($_SESSION['apidocrequestresponseAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApidocRequestResponse = new Core_ApidocRequestResponse();

					
					$myApidocRequestResponse->arid = $formData['farid'];
					$myApidocRequestResponse->contenttype = $formData['fcontenttype'];
					$myApidocRequestResponse->output = $formData['foutput'];
					$myApidocRequestResponse->sample = $formData['fsample'];
					$myApidocRequestResponse->displayorder = $formData['fdisplayorder'];
					
                    if($myApidocRequestResponse->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('apidocrequestresponse_add', $myApidocRequestResponse->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apidocrequestresponseAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myApidocRequestResponse = new Core_ApidocRequestResponse($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApidocRequestResponse->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['farid'] = $myApidocRequestResponse->arid;
			$formData['fid'] = $myApidocRequestResponse->id;
			$formData['fcontenttype'] = $myApidocRequestResponse->contenttype;
			$formData['foutput'] = $myApidocRequestResponse->output;
			$formData['fsample'] = $myApidocRequestResponse->sample;
			$formData['fdisplayorder'] = $myApidocRequestResponse->displayorder;
			$formData['fdatecreated'] = $myApidocRequestResponse->datecreated;
			$formData['fdatemodified'] = $myApidocRequestResponse->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apidocrequestresponseEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApidocRequestResponse->arid = $formData['farid'];
						$myApidocRequestResponse->contenttype = $formData['fcontenttype'];
						$myApidocRequestResponse->output = $formData['foutput'];
						$myApidocRequestResponse->sample = $formData['fsample'];
						$myApidocRequestResponse->displayorder = $formData['fdisplayorder'];
                        
                        if($myApidocRequestResponse->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apidocrequestresponse_edit', $myApidocRequestResponse->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['apidocrequestresponseEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myApidocRequestResponse = new Core_ApidocRequestResponse($id);
		if($myApidocRequestResponse->id > 0)
		{
			//tien hanh xoa
			if($myApidocRequestResponse->delete())
			{
				$redirectMsg = str_replace('###id###', $myApidocRequestResponse->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apidocrequestresponse_delete', $myApidocRequestResponse->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApidocRequestResponse->id, $this->registry->lang['controller']['errDelete']);
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