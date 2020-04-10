<?php

Class Controller_Admin_ScrumStoryComment Extends Controller_Admin_Base 
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
		$ssidFilter = (int)($this->registry->router->getArg('ssid'));
		$contentFilter = (string)($this->registry->router->getArg('content'));
		$fileFilter = (string)($this->registry->router->getArg('file'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
		$datecreateFilter = (int)($this->registry->router->getArg('datecreate'));
		$datemodifiedFilter = (int)($this->registry->router->getArg('datemodified'));
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
            if($_SESSION['scrumstorycommentBulkToken']==$_POST['ftoken'])
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
                            $myScrumStoryComment = new Core_Backend_ScrumStoryComment($id);
                            
                            if($myScrumStoryComment->id > 0)
                            {
                                //tien hanh xoa
                                if($myScrumStoryComment->delete())
                                {
                                    $deletedItems[] = $myScrumStoryComment->id;
                                    $this->registry->me->writelog('scrumstorycomment_delete', $myScrumStoryComment->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myScrumStoryComment->id;
                            }
                            else
                                $cannotDeletedItems[] = $myScrumStoryComment->id;
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
		
		$_SESSION['scrumstorycommentBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($ssidFilter > 0)
		{
			$paginateUrl .= 'ssid/'.$ssidFilter . '/';
			$formData['fssid'] = $ssidFilter;
			$formData['search'] = 'ssid';
		}

		if($contentFilter != "")
		{
			$paginateUrl .= 'content/'.$contentFilter . '/';
			$formData['fcontent'] = $contentFilter;
			$formData['search'] = 'content';
		}

		if($fileFilter != "")
		{
			$paginateUrl .= 'file/'.$fileFilter . '/';
			$formData['ffile'] = $fileFilter;
			$formData['search'] = 'file';
		}

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
		}

		if($datecreateFilter > 0)
		{
			$paginateUrl .= 'datecreate/'.$datecreateFilter . '/';
			$formData['fdatecreate'] = $datecreateFilter;
			$formData['search'] = 'datecreate';
		}

		if($datemodifiedFilter > 0)
		{
			$paginateUrl .= 'datemodified/'.$datemodifiedFilter . '/';
			$formData['fdatemodified'] = $datemodifiedFilter;
			$formData['search'] = 'datemodified';
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

			if($searchKeywordIn == 'content')
			{
				$paginateUrl .= 'searchin/content/';
			}
			elseif($searchKeywordIn == 'file')
			{
				$paginateUrl .= 'searchin/file/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ScrumStoryComment::getScrumStoryComments($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$scrumstorycomments = Core_Backend_ScrumStoryComment::getScrumStoryComments($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'scrumstorycomments' 	=> $scrumstorycomments,
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
            if($_SESSION['scrumstorycommentAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myScrumStoryComment = new Core_Backend_ScrumStoryComment();

					
					$myScrumStoryComment->content = $formData['fcontent'];
					$myScrumStoryComment->file = $formData['ffile'];
					
                    if($myScrumStoryComment->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('scrumstorycomment_add', $myScrumStoryComment->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['scrumstorycommentAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myScrumStoryComment = new Core_Backend_ScrumStoryComment($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumStoryComment->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myScrumStoryComment->uid;
			$formData['fssid'] = $myScrumStoryComment->ssid;
			$formData['fid'] = $myScrumStoryComment->id;
			$formData['fcontent'] = $myScrumStoryComment->content;
			$formData['ffile'] = $myScrumStoryComment->file;
			$formData['fipaddress'] = $myScrumStoryComment->ipaddress;
			$formData['fdatecreate'] = $myScrumStoryComment->datecreate;
			$formData['fdatemodified'] = $myScrumStoryComment->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['scrumstorycommentEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myScrumStoryComment->content = $formData['fcontent'];
						$myScrumStoryComment->file = $formData['ffile'];
                        
                        if($myScrumStoryComment->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('scrumstorycomment_edit', $myScrumStoryComment->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['scrumstorycommentEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myScrumStoryComment = new Core_Backend_ScrumStoryComment($id);
		if($myScrumStoryComment->id > 0)
		{
			//tien hanh xoa
			if($myScrumStoryComment->delete())
			{
				$redirectMsg = str_replace('###id###', $myScrumStoryComment->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('scrumstorycomment_delete', $myScrumStoryComment->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myScrumStoryComment->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if($formData['ffile'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFileRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}

		if($formData['ffile'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFileRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

