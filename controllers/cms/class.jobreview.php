<?php

Class Controller_Cms_JobReview Extends Controller_Cms_Base 
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
		$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$textFilter = (string)($this->registry->router->getArg('text'));
		$moderatoridFilter = (int)($this->registry->router->getArg('moderatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$countreplyFilter = (int)($this->registry->router->getArg('countreply'));
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
            if($_SESSION['jobreviewBulkToken']==$_POST['ftoken'])
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
                            $myJobReview = new Core_JobReview($id);
                            
                            if($myJobReview->id > 0)
                            {
                                //tien hanh xoa
                                if($myJobReview->delete())
                                {
                                    $deletedItems[] = $myJobReview->id;
                                    $this->registry->me->writelog('jobreview_delete', $myJobReview->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myJobReview->id;
                            }
                            else
                                $cannotDeletedItems[] = $myJobReview->id;
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
                    		$myProductReview = new Core_ProductReview($id);
                    		if($myProductReview->id > 0)
                    		{
                    			//tien hanh cap nhat trang thai
                    			$myProductReview->status = Core_ProductReview::STATUS_PENDING;
                    			$myProductReview->moderatorid = $this->registry->me->id;
                    			if($myProductReview->updateData())
                    			{
                    				$peningItems[] = $myProductReview->id;
                    				$this->registry->me->writelog('productreview_edit_pending', $myProductReview->id, array());
                    			}
                    			else
                    				$cannotpendingItems[] = $myProductReview->id;
                    		}
                    		else
                    			$cannotpendingItems[] = $myProductReview->id;
                    	}
                    }
                    elseif($_POST['fbulkaction'] == 'success')
                    {
                    	$reviewArr = $_POST['fbulkid'];
                    	$enableItems = array();
                    	$cannotenableItems = array();
                    
                    	foreach ($reviewArr as $id)
                    	{
                    		$myProductReview = new Core_ProductReview($id);
                    		if($myProductReview->id > 0)
                    		{
                    			//tien hanh cap nhat trang thai
                    			$myProductReview->status = Core_ProductReview::STATUS_ENABLE;
                    			$myProductReview->moderatorid = $this->registry->me->id;
                    			if($myProductReview->updateData())
                    			{
                    				$enableItems[] = $myProductReview->id;
                    				$this->registry->me->writelog('productreview_edit_enable', $myProductReview->id, array());
                    			}
                    			else
                    				$cannotenableItems[] = $myProductReview->id;
                    		}
                    		else
                    			$cannotenableItems[] = $myProductReview->id;
                    	}
                    }
                    elseif($_POST['fbulkaction'] == 'spam')
                    {
                    	$reviewArr = $_POST['fbulkid'];
                    	$spamItems = array();
                    	$cannotspamItems = array();
                    
                    	foreach ($reviewArr as $id)
                    	{
                    		$myProductReview = new Core_ProductReview($id);
                    		if($myProductReview->id > 0)
                    		{
                    			//tien hanh cap nhat trang thai
                    			$myProductReview->status = Core_ProductReview::STATUS_SPAM;
                    			$myProductReview->moderatorid = $this->registry->me->id;
                    			if($myProductReview->updateData())
                    			{
                    				$spamItems[] = $myProductReview->id;
                    				$this->registry->me->writelog('productreview_edit_spam', $myProductReview->id, array());
                    			}
                    			else
                    				$cannotspamItems[] = $myProductReview->id;
                    		}
                    		else
                    			$cannotspamItems[] = $myProductReview->id;
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
		
		$_SESSION['jobreviewBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
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

		if($fullnameFilter != "")
		{
			$paginateUrl .= 'fullname/'.$fullnameFilter . '/';
			$formData['ffullname'] = $fullnameFilter;
			$formData['search'] = 'fullname';
		}

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
		}

		if($textFilter != "")
		{
			$paginateUrl .= 'text/'.$textFilter . '/';
			$formData['ftext'] = $textFilter;
			$formData['search'] = 'text';
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

		if($countreplyFilter > 0)
		{
			$paginateUrl .= 'countreply/'.$countreplyFilter . '/';
			$formData['fcountreply'] = $countreplyFilter;
			$formData['search'] = 'countreply';
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
				
		//tim tong so
		$total = Core_JobReview::getJobReviews($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$jobreviews = Core_JobReview::getJobReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		if(count($jobreviews) > 0)
		{
			foreach($jobreviews as $jobreview)
			{
				$jobreview->jobactor = new Core_Job($jobreview->objectid);
				$jobreview->actor = new Core_User($jobreview->uid);
			}
		}
		
		//get review pending
		$fomrDatas = $formData;
		$formDatas['fstatus'] = Core_JobReview::STATUS_PENDING;
		$jobreviewpending = Core_JobReview::getJobReviews($formDatas, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		if(count($jobreviews) > 0)
		{
			foreach($jobreviewpending as $jobreview)
			{
				$jobreview->jobactor = new Core_Job($jobreview->objectid);
				$jobreview->actor = new Core_User($jobreview->uid);
			}
		}
		/*if(count($jobreviewpending) > 0)
		{
			$list = array();
			foreach ($jobreviewpending as $jobreview)
			{
				$jobreview->product = new Core_Job($jobreview->objectid);
				$jobreview->actor = new Core_User($jobreview->uid);
				if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
				{
					if(in_array($jobreview->product->pcid, $catlist))
					{
						$list[] = $jobreview;
					}
				}
				else
				{
					$list[] = $jobreview;
				}
			}
			$jobreviewpending = $list;
			$totalpending = count($jobreviewpending);
		}*/
		$totalpending = count($jobreviewpending);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'jobreviews' 	=> $jobreviews,
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
												'jobreviewpending' => $jobreviewpending,
												'totalpending'  => $totalpending,
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
            if($_SESSION['jobreviewAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myJobReview = new Core_JobReview();

					
					$myJobReview->uid = $formData['fuid'];
					$myJobReview->objectid = $formData['fobjectid'];
					$myJobReview->fullname = $formData['ffullname'];
					$myJobReview->email = $formData['femail'];
					$myJobReview->text = $formData['ftext'];
					$myJobReview->ipaddress = $formData['fipaddress'];
					$myJobReview->moderatorid = $formData['fmoderatorid'];
					$myJobReview->status = $formData['fstatus'];
					$myJobReview->countthumbup = $formData['fcountthumbup'];
					$myJobReview->countthumbdown = $formData['fcountthumbdown'];
					$myJobReview->countreply = $formData['fcountreply'];
					$myJobReview->datemoderated = $formData['fdatemoderated'];
					$myJobReview->parentid = $formData['fparentid'];
					
                    if($myJobReview->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('jobreview_add', $myJobReview->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['jobreviewAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myJobReview = new Core_JobReview($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myJobReview->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			$myJobReview->jobactor = new Core_Job($myJobReview->objectid);
			
			$formData['fuid'] = $myJobReview->uid;
			$formData['fid'] = $myJobReview->id;
			$formData['fobjectid'] = $myJobReview->objectid;
			$formData['ffullname'] = $myJobReview->fullname;
			$formData['femail'] = $myJobReview->email;
			$formData['ftext'] = $myJobReview->text;
			$formData['fipaddress'] = $myJobReview->ipaddress;
			$formData['fmoderatorid'] = $myJobReview->moderatorid;
			$formData['fstatus'] = $myJobReview->status;
			$formData['fcountthumbup'] = $myJobReview->countthumbup;
			$formData['fcountthumbdown'] = $myJobReview->countthumbdown;
			$formData['fcountreply'] = $myJobReview->countreply;
			$formData['fdatecreated'] = $myJobReview->datecreated;
			$formData['fdatemodified'] = $myJobReview->datemodified;
			$formData['fdatemoderated'] = $myJobReview->datemoderated;
			$formData['fparentid'] = $myJobReview->parentid;
			$formData['jname'] = $myJobReview->jobactor->title;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['jobreviewEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myJobReview->uid = $formData['fuid'];
						$myJobReview->objectid = $formData['fobjectid'];
						$myJobReview->fullname = $formData['ffullname'];
						$myJobReview->email = $formData['femail'];
						$myJobReview->text = $formData['ftext'];
						$myJobReview->ipaddress = $formData['fipaddress'];
						$myJobReview->moderatorid = $formData['fmoderatorid'];
						$myJobReview->status = $formData['fstatus'];
						$myJobReview->countthumbup = $formData['fcountthumbup'];
						$myJobReview->countthumbdown = $formData['fcountthumbdown'];
						$myJobReview->countreply = $formData['fcountreply'];
						$myJobReview->datemoderated = $formData['fdatemoderated'];
						$myJobReview->parentid = $formData['fparentid'];
                        
                        if($myJobReview->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('jobreview_edit', $myJobReview->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['jobreviewEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList' => Core_JobReview::getStatusList(),
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
		$myJobReview = new Core_JobReview($id);
		if($myJobReview->id > 0)
		{
			//tien hanh xoa
			if($myJobReview->delete())
			{
				$redirectMsg = str_replace('###id###', $myJobReview->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('jobreview_delete', $myJobReview->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myJobReview->id, $this->registry->lang['controller']['errDelete']);
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
	
	public function replyAction()
	{
	
		$error = array();
		$success = array();
		$warning = array();
		$formData = array();
	
		$parentid = $this->registry->router->getArg('parentid');
	
		if($parentid > 0)
		{
			$parentReview = new Core_JobReview($parentid);
			if($parentReview->id > 0)
			{
				if(!empty($_POST['fsubmit']))
				{
					$formData = array_merge($formData,$_POST);
					if($this->replyActionValidator($formData, $error))
					{
						//create reply
						$jobreview = new Core_JobReview();
						$jobreview->uid = $this->registry->me->id;
						$jobreview->objectid = $parentReview->objectid;
						$jobreview->fullname = $this->registry->me->fullname;
						$jobreview->email = $this->registry->me->email;
						$jobreview->text = Helper::plaintext($formData['freviewcontent']);
						$jobreview->ipaddress = Helper::getIpAddress(true);
						$jobreview->moderatorid = $this->registry->me->id;
						$jobreview->parentid = $parentReview->id;
						$jobreview->status = Core_JobReview::STATUS_ENABLE;
						if($jobreview->addData() > 0)
						{
							$parentReview->countreply = $parentReview->countreply + 1;
							if($parentReview->updateData())
							{
								$success[] = $this->registry->lang['controller']['succReply'];
								$this->registry->me->writelog('productreview_add', $myProductReview->id, array());
								$formData = array();
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
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fobjectid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errObjectidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}

		if(Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
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
				
		return $pass;
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

?>