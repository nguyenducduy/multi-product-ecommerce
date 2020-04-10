<?php

Class Controller_Cms_StuffReview Extends Controller_Cms_Base 
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
            if($_SESSION['stuffreviewBulkToken']==$_POST['ftoken'])
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
                            $myStuffReview = new Core_StuffReview($id);
                            
                            if($myStuffReview->id > 0)
                            {
                                //tien hanh xoa
                                if($myStuffReview->delete())
                                {
                                    $deletedItems[] = $myStuffReview->id;
                                    $this->registry->me->writelog('stuffreview_delete', $myStuffReview->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myStuffReview->id;
                            }
                            else
                                $cannotDeletedItems[] = $myStuffReview->id;
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
							$myStuffReview = new Core_StuffReview($id);
							if($myStuffReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myStuffReview->status = Core_StuffReview::STATUS_PENDING;
								$myStuffReview->moderatorid = $this->registry->me->id;
								if($myStuffReview->updateData())
								{
									$peningItems[] = $myStuffReview->id;
									$this->registry->me->writelog('stuffreview_edit_pending', $myStuffReview->id, array());
								}
								else
									$cannotpendingItems[] = $myStuffReview->id;
							}
							else
								$cannotpendingItems[] = $myStuffReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'success')
					{
						$reviewArr = $_POST['fbulkid'];
						$enableItems = array();
						$cannotenableItems = array();

						foreach ($reviewArr as $id)
						{
							$myStuffReview = new Core_StuffReview($id);
							if($myStuffReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myStuffReview->status = Core_StuffReview::STATUS_ENABLE;
								$myStuffReview->moderatorid = $this->registry->me->id;
								if($myStuffReview->updateData())
								{
									$enableItems[] = $myStuffReview->id;
									$this->registry->me->writelog('stuffreview_edit_enable', $myStuffReview->id, array());
								}
								else
									$cannotenableItems[] = $myStuffReview->id;
							}
							else
								$cannotenableItems[] = $myStuffReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'spam')
					{
						$reviewArr = $_POST['fbulkid'];
						$spamItems = array();
						$cannotspamItems = array();

						foreach ($reviewArr as $id)
						{
							$myStuffReview = new Core_StuffReview($id);
							if($myStuffReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myStuffReview->status = Core_StuffReview::STATUS_SPAM;
								$myStuffReview->moderatorid = $this->registry->me->id;
								if($myStuffReview->updateData())
								{
									$spamItems[] = $myStuffReview->id;
									$this->registry->me->writelog('stuffreview_edit_spam', $myStuffReview->id, array());
								}
								else
									$cannotspamItems[] = $myStuffReview->id;
							}
							else
								$cannotspamItems[] = $myStuffReview->id;
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
		
		$_SESSION['stuffreviewBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
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
		
		$catlist = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_STUFF , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
			foreach($roleusers as $roleuser)
			{
				$catlist[] = $roleuser->objectid;
			}

		}

		if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_StuffReview::getStuffReviews($formData, $sortby, $sorttype, 0, true);    
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;
			
				
			//get latest account
			$stuffreviews = Core_StuffReview::getStuffReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
				
			if(count($stuffreviews) > 0)
			{
				$list = array();
				foreach ($stuffreviews as $stuffreview)
				{
					$stuffreview->stuff = new Core_Stuff($stuffreview->objectid);
					$stuffreview->actor = new Core_User($stuffreview->uid);
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						if(in_array($stuffreview->stuff->scid, $catlist))
						{
							$list[] = $stuffreview;
						}
					}
					else
					{
						$list[] = $stuffreview;
					}
				}
			}

			$stuffreviews = $list;
			$total = count($stuffreviews);
		}
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		$formDatas = $formData;
		$formDatas['fstatus'] = Core_StuffReview::STATUS_PENDING;
		$totalpending = Core_StuffReview::getStuffReviews($formDatas, $sortby, $sorttype, 0, true);
		
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'stuffreviews' 	=> $stuffreviews,
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
												'statusList'	=> Core_StuffReview::getStatusList(),
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myStuffReview = new Core_StuffReview($id);
		$myStuffReview->stuff = new Core_Stuff($myStuffReview->objectid);

		$redirectUrl = $this->getRedirectUrl();
		if($myStuffReview->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myStuffReview->uid;
			$formData['fid'] = $myStuffReview->id;
			$formData['fobjectid'] = $myStuffReview->objectid;
			$formData['ffullname'] = $myStuffReview->fullname;
			$formData['femail'] = $myStuffReview->email;
			$formData['ftext'] = $myStuffReview->text;
			$formData['fipaddress'] = $myStuffReview->ipaddress;
			$formData['fmoderatorid'] = $myStuffReview->moderatorid;
			$formData['fstatus'] = $myStuffReview->status;
			$formData['fcountthumbup'] = $myStuffReview->countthumbup;
			$formData['fcountthumbdown'] = $myStuffReview->countthumbdown;
			$formData['fcountreply'] = $myStuffReview->countreply;
			$formData['fdatecreated'] = $myStuffReview->datecreated;
			$formData['fdatemodified'] = $myStuffReview->datemodified;
			$formData['fdatemoderated'] = $myStuffReview->datemoderated;
			$formData['fparentid'] = $myStuffReview->parentid;
			$formData['ftitle'] = $myStuffReview->stuff->title;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['stuffreviewEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myStuffReview->uid = $formData['fuid'];
						$myStuffReview->objectid = $formData['fobjectid'];
						$myStuffReview->fullname = $formData['ffullname'];
						$myStuffReview->email = $formData['femail'];
						$myStuffReview->text = $formData['ftext'];
						$myStuffReview->ipaddress = $formData['fipaddress'];
						$myStuffReview->moderatorid = $formData['fmoderatorid'];
						$myStuffReview->status = $formData['fstatus'];
						$myStuffReview->countthumbup = $formData['fcountthumbup'];
						$myStuffReview->countthumbdown = $formData['fcountthumbdown'];
						$myStuffReview->countreply = $formData['fcountreply'];
						$myStuffReview->datemoderated = $formData['fdatemoderated'];
						$myStuffReview->parentid = $formData['fparentid'];
                        
                        if($myStuffReview->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('stuffreview_edit', $myStuffReview->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['stuffreviewEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'	=> Core_StuffReview::getStatusList()
													
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
		$myStuffReview = new Core_StuffReview($id);
		if($myStuffReview->id > 0)
		{
			//tien hanh xoa
			if($myStuffReview->delete())
			{
				$redirectMsg = str_replace('###id###', $myStuffReview->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('stuffreview_delete', $myStuffReview->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myStuffReview->id, $this->registry->lang['controller']['errDelete']);
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
			$parentReview = new Core_StuffReview($parentid);
			if($parentReview->id > 0)
			{
				if(!empty($_POST['fsubmit']))
				{
					$formData = array_merge($formData,$_POST);
					if($this->replyActionValidator($formData, $error))
					{						
						//create reply
						$stuffreview = new Core_StuffReview();
						$stuffreview->uid = $this->registry->me->id;
						$stuffreview->objectid = $parentReview->objectid;
						$stuffreview->fullname = $this->registry->me->fullname;
						$stuffreview->email = $this->registry->me->email;
						$stuffreview->text = Helper::plaintext($formData['freviewcontent']);
						$stuffreview->ipaddress = Helper::getIpAddress(true);
						$stuffreview->moderatorid = $this->registry->me->id;
						$stuffreview->status = Core_NewsReview::STATUS_ENABLE;
						if($stuffreview->addData() > 0)
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

