<?php

Class Controller_Cms_Feedback Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$user = new Core_User($this->registry->me->id);
		$formData['permis']= $user->checkGroupname("administrator");
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$asaFilter = (string)($this->registry->router->getArg('asa'));
		$sectionFilter = (int)($this->registry->router->getArg('section'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$scrumstoryidFilter = (int)($this->registry->router->getArg('scrumstoryid'));
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
            if($_SESSION['feedbackBulkToken']==$_POST['ftoken'])
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
                            $myFeedback = new Core_Backend_Feedback($id);
                            
                            if($myFeedback->id > 0)
                            {
                                //tien hanh xoa
                                if($myFeedback->delete())
                                {
                                    $deletedItems[] = $myFeedback->id;
                                    $this->registry->me->writelog('feedback_delete', $myFeedback->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myFeedback->id;
                            }
                            else
                                $cannotDeletedItems[] = $myFeedback->id;
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
		
		$_SESSION['feedbackBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($asaFilter != "")
		{
			$paginateUrl .= 'asa/'.$asaFilter . '/';
			$formData['fasa'] = $asaFilter;
			$formData['search'] = 'asa';
		}

		if($sectionFilter > 0)
		{
			$paginateUrl .= 'section/'.$sectionFilter . '/';
			$formData['fsection'] = $sectionFilter;
			$formData['search'] = 'section';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($scrumstoryidFilter > 0)
		{
			$paginateUrl .= 'scrumstoryid/'.$scrumstoryidFilter . '/';
			$formData['fscrumstoryid'] = $scrumstoryidFilter;
			$formData['search'] = 'scrumstoryid';
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

			if($searchKeywordIn == 'asa')
			{
				$paginateUrl .= 'searchin/asa/';
			}
			elseif($searchKeywordIn == 'iwant')
			{
				$paginateUrl .= 'searchin/iwant/';
			}
			elseif($searchKeywordIn == 'sothat')
			{
				$paginateUrl .= 'searchin/sothat/';
			}
			elseif($searchKeywordIn == 'filepath')
			{
				$paginateUrl .= 'searchin/filepath/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_Feedback::getFeedbacks($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$feedbacks = Core_Backend_Feedback::getFeedbacks($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		foreach($feedbacks as $fb)
		{
			$fb->actor = new Core_User($fb->uid, true);
		}
		
		$myUser = new Core_User((int)$this->registry->me->id);

		$formData['permiss'] = $this->checkPermissInTeam();   
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'feedbacks' 	=> $feedbacks,
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
												'mySection'		=> Core_Backend_Feedbacksection::getFeedbacksections(array(),'','',''),
												'myUser'		=> $myUser
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
			'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	private function checkPermissInTeam()
	{
		$user =  Core_Backend_Scrumteammember::getList("u_id='".$this->registry->me->id."'","");
		if($user[0]->role == 1 || $user[0]->role == 5)
			return true;
		else
			return false;
	}
	function matchAction()
	{
		$id          = (int)$this->registry->router->getArg('id');
		$listproject = Core_Backend_ScrumProject::getList('','sp_name');
		$feedbacks   =  new Core_Backend_Feedback($id);
		if($feedbacks->id!=null && !empty($_POST['fsubmit']))
		{
					$myScrumStory                   = new Core_Backend_ScrumStory();
					$myScrumStory->spid             = $_POST['fspid'];
					$myScrumStory->siid             = 0;
					$myScrumStory->asa              = $feedbacks->asa;
					$myScrumStory->iwant            = $feedbacks->iwant;
					$myScrumStory->sothat           = $feedbacks->sothat;
					$myScrumStory->tag              = $feedbacks->tag;
					$myScrumStory->point            = $feedbacks->point;
					$myScrumStory->categoryid       = $feedbacks->categoryid;
					$myScrumStory->status           = $feedbacks->status;
					$myScrumStory->priority         = $feedbacks->priority;
					$myScrumStory->displayorder     = $feedbacks->displayorder;
					$id 							= $myScrumStory->addData();
					if($id)
                    {
                        $success[] = $this->registry->lang['controller']['succMatch'];
                        $this->registry->me->writelog('scrumstory_add', $id, array());
                        $formData = array();      
                    }
		}
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
										'redirectUrl'=> $redirectUrl,
										'error'		=> $error,
										'success'	=> $success,
										'listProject'   => $listproject,
										));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'match.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}
	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['feedbackAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myFeedback = new Core_Backend_Feedback();

					
					$myFeedback->uid = (int)$this->registry->me->id;
					$myFeedback->asa = $formData['fasa'];
					$myFeedback->iwant = $formData['fiwant'];
					$myFeedback->sothat = $formData['fsothat'];
					$myFeedback->section = $formData['fsection'];
					$myFeedback->status = Core_Backend_Feedback::STATUS_NEW;
					
                    if($myFeedback->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('feedback_add', $myFeedback->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['feedbackAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'mySection'		=> Core_Backend_Feedbacksection::getFeedbacksections(array(),'','',''),
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'add.tpl');
	}
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myFeedback = new Core_Backend_Feedback($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myFeedback->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myFeedback->uid;
			$formData['fid'] = $myFeedback->id;
			$formData['fasa'] = $myFeedback->asa;
			$formData['fiwant'] = $myFeedback->iwant;
			$formData['fsothat'] = $myFeedback->sothat;
			$formData['fsection'] = $myFeedback->section;
			$formData['fstatus'] = $myFeedback->status;
			$formData['ffilepath'] = $myFeedback->filepath;
			$formData['fdatecreated'] = $myFeedback->datecreated;
			$formData['fdatemodified'] = $myFeedback->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['feedbackEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myFeedback->uid = $this->registry->me->id;
						$myFeedback->asa = $formData['fasa'];
						$myFeedback->iwant = $formData['fiwant'];
						$myFeedback->sothat = $formData['fsothat'];
						$myFeedback->section = $formData['fsection'];
						$myFeedback->status = $formData['fstatus'];
                        
                        if($myFeedback->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('feedback_edit', $myFeedback->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['feedbackEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'mySection'	=> Core_Backend_Feedbacksection::getFeedbacksections(array(),'','',''),
													'statusList'	=> Core_Backend_Feedback::getStatusList()
													
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'] . ' &raquo; ' . $myFeedback->iwant ,
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'edit.tpl');
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
		$myFeedback = new Core_Backend_Feedback($id);
		if($myFeedback->id > 0)
		{
			//tien hanh xoa
			if($myFeedback->delete())
			{
				$redirectMsg = str_replace('###id###', $myFeedback->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('feedback_delete', $myFeedback->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myFeedback->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fasa'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAsaRequired'];
			$pass = false;
		}

		if($formData['fiwant'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIwantRequired'];
			$pass = false;
		}

		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fasa'] == '')
		{
			$error[] = $this->registry->lang['controller']['errAsaRequired'];
			$pass = false;
		}

		if($formData['fiwant'] == '')
		{
			$error[] = $this->registry->lang['controller']['errIwantRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

