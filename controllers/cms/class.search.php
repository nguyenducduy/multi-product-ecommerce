<?php

Class Controller_Cms_Search Extends Controller_Cms_Base 
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
		
		
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$textFilter = (string)($this->registry->router->getArg('text'));
		$categoryidFilter = (int)($this->registry->router->getArg('categoryid'));
		$referrerFilter = (string)($this->registry->router->getArg('referrer'));
		$numresultFilter = (int)($this->registry->router->getArg('numresult'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
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
            if($_SESSION['searchBulkToken']==$_POST['ftoken'])
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
                            $mySearch = new Core_Backend_Search($id);
                            
                            if($mySearch->id > 0)
                            {
                                //tien hanh xoa
                                if($mySearch->delete())
                                {
                                    $deletedItems[] = $mySearch->id;
                                    $this->registry->me->writelog('search_delete', $mySearch->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $mySearch->id;
                            }
                            else
                                $cannotDeletedItems[] = $mySearch->id;
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
		
		$_SESSION['searchBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($textFilter != "")
		{
			$paginateUrl .= 'text/'.$textFilter . '/';
			$formData['ftext'] = $textFilter;
			$formData['search'] = 'text';
		}

		if($categoryidFilter > 0)
		{
			$paginateUrl .= 'categoryid/'.$categoryidFilter . '/';
			$formData['fcategoryid'] = $categoryidFilter;
			$formData['search'] = 'categoryid';
		}

		if($referrerFilter != "")
		{
			$paginateUrl .= 'referrer/'.$referrerFilter . '/';
			$formData['freferrer'] = $referrerFilter;
			$formData['search'] = 'referrer';
		}

		if($numresultFilter > 0)
		{
			$paginateUrl .= 'numresult/'.$numresultFilter . '/';
			$formData['fnumresult'] = $numresultFilter;
			$formData['search'] = 'numresult';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
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

			if($searchKeywordIn == 'text')
			{
				$paginateUrl .= 'searchin/text/';
			}
			elseif($searchKeywordIn == 'referrer')
			{
				$paginateUrl .= 'searchin/referrer/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_Search::getSearchs($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$searchs = Core_Backend_Search::getSearchs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'searchs' 	=> $searchs,
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
            if($_SESSION['searchAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $mySearch = new Core_Backend_Search();

					
					$mySearch->text = $formData['ftext'];
					$mySearch->categoryid = $formData['fcategoryid'];
					$mySearch->referrer = $formData['freferrer'];
					$mySearch->numresult = $formData['fnumresult'];
					
                    if($mySearch->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('search_add', $mySearch->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['searchAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$mySearch = new Core_Backend_Search($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($mySearch->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $mySearch->uid;
			$formData['fid'] = $mySearch->id;
			$formData['ftext'] = $mySearch->text;
			$formData['fcategoryid'] = $mySearch->categoryid;
			$formData['freferrer'] = $mySearch->referrer;
			$formData['fnumresult'] = $mySearch->numresult;
			$formData['fdatecreated'] = $mySearch->datecreated;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['searchEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$mySearch->text = $formData['ftext'];
						$mySearch->categoryid = $formData['fcategoryid'];
						$mySearch->referrer = $formData['freferrer'];
						$mySearch->numresult = $formData['fnumresult'];
                        
                        if($mySearch->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('search_edit', $mySearch->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['searchEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$mySearch = new Core_Backend_Search($id);
		if($mySearch->id > 0)
		{
			//tien hanh xoa
			if($mySearch->delete())
			{
				$redirectMsg = str_replace('###id###', $mySearch->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('search_delete', $mySearch->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $mySearch->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
			$pass = false;
		}

		if($formData['fcategoryid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCategoryidRequired'];
			$pass = false;
		}

		if($formData['freferrer'] == '')
		{
			$error[] = $this->registry->lang['controller']['errReferrerRequired'];
			$pass = false;
		}

		if($formData['fnumresult'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNumresultRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
			$pass = false;
		}

		if($formData['fcategoryid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errCategoryidRequired'];
			$pass = false;
		}

		if($formData['freferrer'] == '')
		{
			$error[] = $this->registry->lang['controller']['errReferrerRequired'];
			$pass = false;
		}

		if($formData['fnumresult'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNumresultRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

