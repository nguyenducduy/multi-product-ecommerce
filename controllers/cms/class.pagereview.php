<?php

Class Controller_Cms_PageReview Extends Controller_Cms_Base 
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
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
		$ipaddressFilter = (int)($this->registry->router->getArg('ipaddress'));
		$moderatoridFilter = (int)($this->registry->router->getArg('moderatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
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
            if($_SESSION['pagereviewBulkToken']==$_POST['ftoken'])
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
                            $myPageReview = new Core_PageReview($id);
                            
                            if($myPageReview->id > 0)
                            {
                                //tien hanh xoa
                                if($myPageReview->delete())
                                {
                                    $deletedItems[] = $myPageReview->id;
                                    $this->registry->me->writelog('pagereview_delete', $myPageReview->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myPageReview->id;
                            }
                            else
                                $cannotDeletedItems[] = $myPageReview->id;
                        }
                        
                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);
                        
                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
                    elseif($_POST['fbulkaction'] == 'pending')
					{
						$reviewArr = $_POST['fbulkid'];
						$peningItems = array();
						$cannotpendingItems = array();

						foreach ($reviewArr as $id)
						{
							$myPageReview = new Core_PageReview($id);
							if($myPageReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myPageReview->status = Core_PageReview::STATUS_PENDING;
								$myPageReview->moderatorid = $this->registry->me->id;
								if($myPageReview->updateData())
								{
									$peningItems[] = $myPageReview->id;
									$this->registry->me->writelog('pagereview_edit_pending', $myPageReview->id, array());
								}
								else
									$cannotpendingItems[] = $myPageReview->id;
							}
							else
								$cannotpendingItems[] = $myPageReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'success')
					{
						$reviewArr = $_POST['fbulkid'];
						$enableItems = array();
						$cannotenableItems = array();

						foreach ($reviewArr as $id)
						{
							$myPageReview = new Core_PageReview($id);
							if($myPageReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myPageReview->status = Core_PageReview::STATUS_ENABLE;
								$myPageReview->moderatorid = $this->registry->me->id;
								if($myPageReview->updateData())
								{
									$enableItems[] = $myPageReview->id;
									$this->registry->me->writelog('pagereview_edit_enable', $myPageReview->id, array());
								}
								else
									$cannotenableItems[] = $myPageReview->id;
							}
							else
								$cannotenableItems[] = $myPageReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'spam')
					{
						$reviewArr = $_POST['fbulkid'];
						$spamItems = array();
						$cannotspamItems = array();

						foreach ($reviewArr as $id)
						{
							$myPageReview = new Core_PageReview($id);
							if($myPageReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myPageReview->status = Core_PageReview::STATUS_SPAM;
								$myPageReview->moderatorid = $this->registry->me->id;
								if($myPageReview->updateData())
								{
									$spamItems[] = $myPageReview->id;
									$this->registry->me->writelog('pagereview_edit_spam', $myPageReview->id, array());
								}
								else
									$cannotspamItems[] = $myPageReview->id;
							}
							else
								$cannotspamItems[] = $myPageReview->id;
						}
					}
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }
			
		}
		
		$_SESSION['pagereviewBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
		}

		if($ipaddressFilter > 0)
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = $ipaddressFilter;
			$formData['search'] = 'ipaddress';
		}

		if($moderatoridFilter > 0)
		{
			$paginateUrl .= 'moderatorid/'.$moderatoridFilter . '/';
			$formData['fmoderatorid'] = $moderatoridFilter;
			$formData['search'] = 'moderatorid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
		}

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
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

			if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			elseif($searchKeywordIn == 'text')
			{
				$paginateUrl .= 'searchin/text/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		/*$catlist = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PAGE , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
			foreach($roleusers as $roleuser)
			{
				$catlist[] = $roleuser->objectid;
			}

		}

		if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_PageReview::getPageReviews($formData, $sortby, $sorttype, 0, true);    
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;
			
				
			//get latest account
			$pagereviews = Core_PageReview::getPageReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			
			if(count($pagereviews) > 0)
			{
				$list = array();
				foreach ($pagereviews as $pagereview)
				{
					$pagereview->page = new Core_Page($pagereview->objectid);
					$pagereview->actor = new Core_User($pagereview->uid);
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer') )
					{
						if(in_array($pagereview->page->pcid, $catlist))
						{
							$list[] = $pagereview;
						}
					}
					else
					{
						$list[] = $pagereview;
					}
				}
			}

			$pagereviews = $list;
			$total = count($pagereviews);
		}*/
		
		//tim tong so
		$total = Core_PageReview::getPageReviews($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
		//get latest account
		$pagereviews = Core_PageReview::getPageReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
				
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);

		$formDatas = $formData;
		$formDatas['fstatus'] = Core_PageReview::STATUS_PENDING;
		$totalpending = Core_PageReview::getPageReviews($formDatas, $sortby, $sorttype, 0, true);
		$pagereviewspening = Core_PageReview::getPageReviews($formDatas, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
				
		$this->registry->smarty->assign(array(	'pagereviews' 	=> $pagereviews,
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
												'totalpending'	=> $totalpending,
												'statusList'	=> Core_PageReview::getStatusList(),
												'pagereviewspending' => $pagereviewspening,
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 

	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myPageReview = new Core_PageReview($id);
		$myPageReview->page = new Core_Page($myPageReview->objectid);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myPageReview->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $this->registry->me->id;
			$formData['fid'] = $myPageReview->id;
			$formData['fobjectid'] = $myPageReview->objectid;
			$formData['ffullname'] = $myPageReview->fullname;
			$formData['femail'] = $myPageReview->email;
			$formData['ftext'] = $myPageReview->text;
			$formData['fipaddress'] = $myPageReview->ipaddress;
			$formData['fmoderatorid'] = $myPageReview->moderatorid;
			$formData['fstatus'] = $myPageReview->status;
			$formData['fcountthumbup'] = $myPageReview->countthumbup;
			$formData['fcountthumbdown'] = $myPageReview->countthumbdown;
			$formData['fcountreply'] = $myPageReview->countreply;
			$formData['fdatecreated'] = $myPageReview->datecreated;
			$formData['fdatemodified'] = $myPageReview->datemodified;
			$formData['fdatemoderated'] = $myPageReview->datemoderated;
			$formData['fparentid'] = $myPageReview->parentid;
			$formData['ftitle'] = $myPageReview->page->title;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['pagereviewEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myPageReview->objectid = $formData['fobjectid'];
						$myPageReview->fullname = $formData['ffullname'];
						$myPageReview->email = $formData['femail'];
						$myPageReview->text = $formData['ftext'];
						$myPageReview->moderatorid = $formData['fmoderatorid'];
						$myPageReview->status = $formData['fstatus'];
						$myPageReview->parentid = $formData['fparentid'];
                        
                        if($myPageReview->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('pagereview_edit', $myPageReview->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['pagereviewEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_NewsReview::getStatusList()
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
		$myPageReview = new Core_PageReview($id);
		if($myPageReview->id > 0)
		{
			//tien hanh xoa
			if($myPageReview->delete())
			{
				$redirectMsg = str_replace('###id###', $myPageReview->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('pagereview_delete', $myPageReview->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myPageReview->id, $this->registry->lang['controller']['errDelete']);
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
	
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		
				
		return $pass;
	}

	public function replyAction()
	{

		$error = array();
		$success = array();
		$warning = array();
		$formData = array();

		$parentid = $this->registry->router->getArg('parentid');		

		if($parentid > 0)
		{
			$parentReview = new Core_PageReview($parentid);
			if($parentReview->id > 0)
			{
				if(!empty($_POST['fsubmit']))
				{
					$formData = array_merge($formData,$_POST);
					if($this->replyActionValidator($formData, $error))
					{						
						//create reply
						$pagereview = new Core_PageReview();
						$pagereview->uid = $this->registry->me->id;
						$pagereview->objectid = $parentReview->objectid;
						$pagereview->subobjectid = $parentReview->subobjectid;
						$pagereview->fullname = $this->registry->me->fullname;
						$pagereview->email = $this->registry->me->email;
						$pagereview->text = Helper::plaintext($formData['freviewcontent']);
						$pagereview->ipaddress = Helper::getIpAddress(true);
						$pagereview->moderatorid = $this->registry->me->id;
						$pagereview->parentid = $parentReview->id;
						$pagereview->status = Core_PageReview::STATUS_ENABLE;
						if($pagereview->addData() > 0)
						{
							$parentReview->countreply = $parentReview->countreply + 1;
							if($parentReview->updateData())
							{
								$success[] = $this->registry->lang['controller']['succReply'];								
							}
							else
							{
								$error[] = $this->registry->lang['controller']['errReply'];
							}
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errReply'];
						}
					}
				}

			}
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errReply'];
		}

		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,													
													));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reply.tpl');
		$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'reply.tpl');
	}

	private function replyActionValidator($formData  , &$error)
	{
		$pass = true;

		if(Helper::plaintext($formData['freviewcontent']) == '')
		{
			$error = $this->registry->lang['controller']['errContentEmpty'];
			$pass = false;
		}

		return $pass;
	}
}

