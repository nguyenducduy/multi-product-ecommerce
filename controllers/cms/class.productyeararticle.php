<?php

Class Controller_Cms_ProductyearArticle Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken'] = Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$titleFilter = (string)($this->registry->router->getArg('title'));
		$contentFilter = (string)($this->registry->router->getArg('content'));
		$pointFilter = (int)($this->registry->router->getArg('point'));
		$countlikeFilter = (int)($this->registry->router->getArg('countlike'));
		$countshareFilter = (int)($this->registry->router->getArg('countshare'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
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
            if($_SESSION['productyeararticleBulkToken']==$_POST['ftoken'])
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
                            $myProductyearArticle = new Core_ProductyearArticle($id);
                            
                            if($myProductyearArticle->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductyearArticle->delete())
                                {
                                    $deletedItems[] = $myProductyearArticle->id;
                                    $this->registry->me->writelog('productyeararticle_delete', $myProductyearArticle->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myProductyearArticle->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductyearArticle->id;
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
		
		$_SESSION['productyeararticleBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($titleFilter != "")
		{
			$paginateUrl .= 'title/'.$titleFilter . '/';
			$formData['ftitle'] = $titleFilter;
			$formData['search'] = 'title';
		}

		if($contentFilter != "")
		{
			$paginateUrl .= 'content/'.$contentFilter . '/';
			$formData['fcontent'] = $contentFilter;
			$formData['search'] = 'content';
		}

		if($pointFilter > 0)
		{
			$paginateUrl .= 'point/'.$pointFilter . '/';
			$formData['fpoint'] = $pointFilter;
			$formData['search'] = 'point';
		}

		if($countlikeFilter > 0)
		{
			$paginateUrl .= 'countlike/'.$countlikeFilter . '/';
			$formData['fcountlike'] = $countlikeFilter;
			$formData['search'] = 'countlike';
		}

		if($countshareFilter > 0)
		{
			$paginateUrl .= 'countshare/'.$countshareFilter . '/';
			$formData['fcountshare'] = $countshareFilter;
			$formData['search'] = 'countshare';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
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

			if($searchKeywordIn == 'title')
			{
				$paginateUrl .= 'searchin/title/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_ProductyearArticle::getProductyearArticles($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$productyeararticles = Core_ProductyearArticle::getProductyearArticles($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'productyeararticles' 	=> $productyeararticles,
												'statusOptions' => Core_ProductyearArticle::getStatusList(),
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
            if($_SESSION['productyeararticleAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myProductyearArticle = new Core_ProductyearArticle();

					
					$myProductyearArticle->pid = $formData['fpid'];
					$myProductyearArticle->pyuid = $formData['fpyuid'];
					$myProductyearArticle->title = $formData['ftitle'];
					$myProductyearArticle->content = $formData['fcontent'];
					$myProductyearArticle->point = $formData['fpoint'];
					$myProductyearArticle->countlike = $formData['fcountlike'];
					$myProductyearArticle->countshare = $formData['fcountshare'];
					$myProductyearArticle->status = $formData['fstatus'];
					$myProductyearArticle->ipaddress = $formData['fipaddress'];
					
                    if($myProductyearArticle->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productyeararticle_add', $myProductyearArticle->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['productyeararticleAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'statusOptions' => Core_ProductyearArticle::getStatusList(),
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
		$myProductyearArticle = new Core_ProductyearArticle($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myProductyearArticle->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpid'] = $myProductyearArticle->pid;
			$formData['fpyuid'] = $myProductyearArticle->pyuid;
			$formData['fid'] = $myProductyearArticle->id;
			$formData['ftitle'] = $myProductyearArticle->title;
			$formData['fcontent'] = $myProductyearArticle->content;
			$formData['fpoint'] = $myProductyearArticle->point;
			$formData['fcountlike'] = $myProductyearArticle->countlike;
			$formData['fcountshare'] = $myProductyearArticle->countshare;
			$formData['fstatus'] = $myProductyearArticle->status;
			$formData['fdatecreated'] = $myProductyearArticle->datecreated;
			$formData['fdatemodified'] = $myProductyearArticle->datemodified;
			$formData['fipaddress'] = $myProductyearArticle->ipaddress;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productyeararticleEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myProductyearArticle->pid = $formData['fpid'];
						$myProductyearArticle->pyuid = $formData['fpyuid'];
						$myProductyearArticle->title = $formData['ftitle'];
						$myProductyearArticle->content = $formData['fcontent'];
						$myProductyearArticle->point = $formData['fpoint'];
						$myProductyearArticle->countlike = $formData['fcountlike'];
						$myProductyearArticle->countshare = $formData['fcountshare'];
						$myProductyearArticle->status = $formData['fstatus'];
						$myProductyearArticle->ipaddress = $formData['fipaddress'];
                        
                        if($myProductyearArticle->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productyeararticle_edit', $myProductyearArticle->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['productyeararticleEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'statusOptions' => Core_ProductyearArticle::getStatusList(),
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
		$myProductyearArticle = new Core_ProductyearArticle($id);
		if($myProductyearArticle->id > 0)
		{
			//tien hanh xoa
			if($myProductyearArticle->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductyearArticle->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('productyeararticle_delete', $myProductyearArticle->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductyearArticle->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}
