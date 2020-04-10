<?php

Class Controller_Admin_ApidocRequest Extends Controller_Admin_Base 
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
		
		
		$agidFilter = (int)($this->registry->router->getArg('agid'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$httpmethodFilter = (int)($this->registry->router->getArg('httpmethod'));
		$urlFilter = (string)($this->registry->router->getArg('url'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
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
            if($_SESSION['apidocrequestBulkToken']==$_POST['ftoken'])
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
                            $myApidocRequest = new Core_Backend_ApidocRequest($id);
                            
                            if($myApidocRequest->id > 0)
                            {
                                //tien hanh xoa
                                if($myApidocRequest->delete())
                                {
                                    $deletedItems[] = $myApidocRequest->id;
                                    $this->registry->me->writelog('apidocrequest_delete', $myApidocRequest->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myApidocRequest->id;
                            }
                            else
                                $cannotDeletedItems[] = $myApidocRequest->id;
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
		
		$_SESSION['apidocrequestBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($agidFilter > 0)
		{
			$paginateUrl .= 'agid/'.$agidFilter . '/';
			$formData['fagid'] = $agidFilter;
			$formData['search'] = 'agid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($httpmethodFilter > 0)
		{
			$paginateUrl .= 'httpmethod/'.$httpmethodFilter . '/';
			$formData['fhttpmethod'] = $httpmethodFilter;
			$formData['search'] = 'httpmethod';
		}

		if($urlFilter != "")
		{
			$paginateUrl .= 'url/'.$urlFilter . '/';
			$formData['furl'] = $urlFilter;
			$formData['search'] = 'url';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
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
			elseif($searchKeywordIn == 'implementnote')
			{
				$paginateUrl .= 'searchin/implementnote/';
			}
			elseif($searchKeywordIn == 'url')
			{
				$paginateUrl .= 'searchin/url/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ApidocRequest::getApidocRequests($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$apidocrequests = Core_Backend_ApidocRequest::getApidocRequests($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'apidocrequests' 	=> $apidocrequests,
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
		
		$formData['fagid'] = (int)$_GET['agid'];
		$formData['furl'] = '{BASE_URL}';
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['apidocrequestAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myApidocRequest = new Core_Backend_ApidocRequest();

					
					$myApidocRequest->agid = $formData['fagid'];
					$myApidocRequest->name = $formData['fname'];
					$myApidocRequest->summary = $formData['fsummary'];
					$myApidocRequest->implementnote = $formData['fimplementnote'];
					$myApidocRequest->httpmethod = $formData['fhttpmethod'];
					$myApidocRequest->url = $formData['furl'];
					$myApidocRequest->status = $formData['fstatus'];
					
                    if($myApidocRequest->addData())
                    {
                        $success[] = str_replace('###VALUE###', $myApidocRequest->name, $this->registry->lang['controller']['succAdd']);
                        $this->registry->me->writelog('apidocrequest_add', $myApidocRequest->id, array());
                          

						/////////////////////
						//ADD PARAMETER
						for($i = 0; $i < count($formData['fparamname']);$i++)
						{
							//Valid param
							if(trim($formData['fparamname'][$i]) != '')
							{
								$myParam = new Core_Backend_ApidocRequestParameter();
								$myParam->arid = $myApidocRequest->id;
								$myParam->type = $formData['fparamtype'][$i];
								$myParam->name = $formData['fparamname'][$i];
								$myParam->summary = $formData['fparamdescription'][$i];
								$myParam->datatype = $formData['fparamdatatype'][$i];
								$myParam->isrequired = $formData['fparamisrequired'][$i];
								$myParam->addData();
							}
						}
						
						/////////////////////
						// ADD RESPONSE
						for($i = 0; $i < count($formData['fresponseoutput']);$i++)
						{
							//Valid param
							if(trim($formData['fresponseoutput'][$i]) != '')
							{
								$myResponse = new Core_Backend_ApidocRequestResponse();
								$myResponse->arid = $myApidocRequest->id;
								$myResponse->contenttype = $formData['fresponsetype'][$i];
								$myResponse->output = $formData['fresponseoutput'][$i];
								$myResponse->sample = $formData['fresponsesample'][$i];
								$myResponse->addData();
							}
						}
						
						//clear input
						$formData = array('fagid' => $formData['fagid'], 'fhttpmethod' => $formData['fhttpmethod']);    
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['apidocrequestAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'statusList'	=> Core_Backend_ApidocRequest::getStatusList(),
												'methodList'	=> Core_Backend_ApidocRequest::getMethodList(),
												'groupList'		=> Core_Backend_ApidocGroup::getApidocGroups(array(), 'displayorder', 'ASC', ''),
												'datatypeList'	=> Core_Backend_ApidocRequestParameter::getDatatypeList(),
												'paramtypeList'	=> Core_Backend_ApidocRequestParameter::getTypeList(),
												'contenttypeList'	=> Core_Backend_ApidocRequestResponse::getContenttypeList(),
												'error'			=> $error,
												'success'		=> $success,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myApidocRequest = new Core_Backend_ApidocRequest($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myApidocRequest->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fagid'] = $myApidocRequest->agid;
			$formData['fid'] = $myApidocRequest->id;
			$formData['fname'] = $myApidocRequest->name;
			$formData['fsummary'] = $myApidocRequest->summary;
			$formData['fimplementnote'] = $myApidocRequest->implementnote;
			$formData['fhttpmethod'] = $myApidocRequest->httpmethod;
			$formData['furl'] = $myApidocRequest->url;
			$formData['fstatus'] = $myApidocRequest->status;
			$formData['fdisplayorder'] = $myApidocRequest->displayorder;
			$formData['fdatecreated'] = $myApidocRequest->datecreated;
			$formData['fdatemodified'] = $myApidocRequest->datemodified;
			
			
			
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['apidocrequestEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myApidocRequest->agid = $formData['fagid'];
						$myApidocRequest->name = $formData['fname'];
						$myApidocRequest->summary = $formData['fsummary'];
						$myApidocRequest->implementnote = $formData['fimplementnote'];
						$myApidocRequest->httpmethod = $formData['fhttpmethod'];
						$myApidocRequest->url = $formData['furl'];
						$myApidocRequest->status = $formData['fstatus'];
						$myApidocRequest->displayorder = $formData['fdisplayorder'];
                        
                        if($myApidocRequest->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('apidocrequest_edit', $myApidocRequest->id, array());
							
							
							/////////////////////
							//UPDATE/DELETE PARAMETER
							if(count($formData['fexistedparamname']) > 0)
							{
								foreach($formData['fexistedparamname'] as $paramid => $paramname)
								{
									$myParam = new Core_Backend_ApidocRequestParameter($paramid);
									
									//detect delete parameter
									if(isset($formData['fexistedparamdeleted'][$paramid]) && $formData['fexistedparamdeleted'][$paramid] == 1)
									{
										//delete
										$myParam->delete();
									}
									else
									{
										//update
										$myParam->type = $formData['fexistedparamtype'][$paramid];
										$myParam->name = $formData['fexistedparamname'][$paramid];
										$myParam->summary = $formData['fexistedparamdescription'][$paramid];
										$myParam->datatype = $formData['fexistedparamdatatype'][$paramid];
										$myParam->isrequired = $formData['fexistedparamisrequired'][$paramid];
										$myParam->displayorder = $formData['fexistedparamdisplayorder'][$paramid];
										$myParam->updateData();
									}
									
								}//end foreach
							}//end if
							
							/////////////////////
							//UPDATE/DELETE RESPONSE
							if(count($formData['fexistedresponsetype']) > 0)
							{
								foreach($formData['fexistedresponsetype'] as $responseid => $responsetype)
								{
									$myResponse = new Core_Backend_ApidocRequestResponse($responseid);
									
									//detect delete parameter
									if(isset($formData['fexistedresponsedeleted'][$responseid]) && $formData['fexistedresponsedeleted'][$responseid] == 1)
									{
										//delete
										$myResponse->delete();
									}
									else
									{
										//update
										$myResponse->contenttype = $formData['fexistedresponsetype'][$responseid];
										$myResponse->output = $formData['fexistedresponseoutput'][$responseid];
										$myResponse->sample = $formData['fexistedresponsesample'][$responseid];
										$myResponse->displayorder = $formData['fexistedresponsedisplayorder'][$responseid];
										$myResponse->updateData();
									}
									
								}//end foreach
							}//end if
							
							
							/////////////////////
							//ADD PARAMETER
							for($i = 0; $i < count($formData['fparamname']);$i++)
							{
								//Valid param
								if(trim($formData['fparamname'][$i]) != '')
								{
									$myParam = new Core_Backend_ApidocRequestParameter();
									$myParam->arid = $myApidocRequest->id;
									$myParam->type = $formData['fparamtype'][$i];
									$myParam->name = $formData['fparamname'][$i];
									$myParam->summary = $formData['fparamdescription'][$i];
									$myParam->datatype = $formData['fparamdatatype'][$i];
									$myParam->isrequired = $formData['fparamisrequired'][$i];
									$myParam->addData();
								}
							}

							/////////////////////
							// ADD RESPONSE
							for($i = 0; $i < count($formData['fresponseoutput']);$i++)
							{
								//Valid param
								if(trim($formData['fresponseoutput'][$i]) != '')
								{
									$myResponse = new Core_Backend_ApidocRequestResponse();
									$myResponse->arid = $myApidocRequest->id;
									$myResponse->contenttype = $formData['fresponsetype'][$i];
									$myResponse->output = $formData['fresponseoutput'][$i];
									$myResponse->sample = $formData['fresponsesample'][$i];
									$myResponse->addData();
								}
							}
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			//Parameter list
			$parameterList = Core_Backend_ApidocRequestParameter::getApidocRequestParameters(array('farid' => $myApidocRequest->id), 'displayorder', 'ASC', '');
			$responseList = Core_Backend_ApidocRequestResponse::getApidocRequestResponses(array('farid' => $myApidocRequest->id), 'displayorder', 'ASC', '');
			
			
			$_SESSION['apidocrequestEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'parameterList'	=> $parameterList,
													'responseList'	=> $responseList,
													'statusList'	=> Core_Backend_ApidocRequest::getStatusList(),
													'methodList'	=> Core_Backend_ApidocRequest::getMethodList(),
													'groupList'		=> Core_Backend_ApidocGroup::getApidocGroups(array(), 'displayorder', 'ASC', ''),
													'datatypeList'	=> Core_Backend_ApidocRequestParameter::getDatatypeList(),
													'paramtypeList'	=> Core_Backend_ApidocRequestParameter::getTypeList(),
													'contenttypeList'	=> Core_Backend_ApidocRequestResponse::getContenttypeList(),
													
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
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
		$myApidocRequest = new Core_Backend_ApidocRequest($id);
		if($myApidocRequest->id > 0)
		{
			//tien hanh xoa
			if($myApidocRequest->delete())
			{
				$redirectMsg = str_replace('###id###', $myApidocRequest->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('apidocrequest_delete', $myApidocRequest->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myApidocRequest->id, $this->registry->lang['controller']['errDelete']);
			}
			
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		
		$this->registry->smarty->assign(array('redirect' => $this->registry->conf['rooturl_admin'] . 'apidocgroup',
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
		
		if(strlen(trim($formData['furl'])) == 0)
		{
			$pass = false;
			$error[] = 'URL is required.';
		}
		
		if(strlen(trim($formData['fname'])) == 0)
		{
			$pass = false;
			$error[] = 'Request Name is required.';
		}
		
		
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