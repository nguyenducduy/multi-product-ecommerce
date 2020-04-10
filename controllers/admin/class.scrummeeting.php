<?php

Class Controller_Admin_ScrumMeeting Extends Controller_Admin_Base 
{
	private $recordPerPage = 20;
	private function createhistory()
	{
		$link  = $this->registry->conf['rooturl'].substr($_SERVER['REQUEST_URI'],1);
		Core_Backend_ScrumProject::gethistory($link);
	}
	function indexAction() 
	{
		$this->createhistory();
		$formData 		= array('fbulkid' => array());

		$siidFilter = (int)($this->registry->router->getArg('siid'));
		$myScrumStory = new Core_Backend_ScrumIteration($siidFilter);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStory->spid);
		if(!$permiss)
			$this->redirecturl();
		else
			$formData['permiss'] = '1';


		$error 			= array();
		$success 		= array();
		$warning 		= array();

		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

		$uidFilter = (int)($this->registry->router->getArg('uid'));

		$typeFilter = (int)($this->registry->router->getArg('type'));
		$summaryFilter = (string)($this->registry->router->getArg('summary'));
		$noteFilter = (string)($this->registry->router->getArg('note'));
		$datecreatedFilter = (int)($this->registry->router->getArg('datecreated'));
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
            if($_SESSION['scrummeetingBulkToken']==$_POST['ftoken'])
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
                            $myScrumMeeting = new Core_Backend_ScrumMeeting($id);
                            
                            if($myScrumMeeting->id > 0)
                            {
                                //tien hanh xoa
                                if($myScrumMeeting->delete())
                                {
                                    $deletedItems[] = $myScrumMeeting->id;
                                    $this->registry->me->writelog('scrummeeting_delete', $myScrumMeeting->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myScrumMeeting->id;
                            }
                            else
                                $cannotDeletedItems[] = $myScrumMeeting->id;
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
		
		$_SESSION['scrummeetingBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		$formData['iterationid'] = 0;
		$project = new Core_Backend_ScrumIteration($siidFilter);
		if(!empty($project))
			$formData['iterationid'] = $project->spid;

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($siidFilter > 0)
		{
			$paginateUrl .= 'siid/'.$siidFilter . '/';
			$formData['fsiid'] = $siidFilter;
			$formData['search'] = 'siid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($summaryFilter != "")
		{
			$paginateUrl .= 'summary/'.$summaryFilter . '/';
			$formData['fsummary'] = $summaryFilter;
			$formData['search'] = 'summary';
		}

		if($noteFilter != "")
		{
			$paginateUrl .= 'note/'.$noteFilter . '/';
			$formData['fnote'] = $noteFilter;
			$formData['search'] = 'note';
		}

		if($datecreatedFilter > 0)
		{
			$paginateUrl .= 'datecreated/'.$datecreatedFilter . '/';
			$formData['fdatecreated'] = $datecreatedFilter;
			$formData['search'] = 'datecreated';
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

			if($searchKeywordIn == 'summary')
			{
				$paginateUrl .= 'searchin/summary/';
			}
			elseif($searchKeywordIn == 'note')
			{
				$paginateUrl .= 'searchin/note/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_ScrumMeeting::getScrumMeetings($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$scrummeetings = Core_Backend_ScrumMeeting::getScrumMeetings($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		foreach ($scrummeetings as $key => $value) {
			$member = new Core_User($scrummeetings[$key]->uid);
			$print  = new Core_Backend_ScrumIteration($scrummeetings[$key]->siid);
			$type   =  Core_Backend_ScrumMeeting::getNameStatus($scrummeetings[$key]->type);
			
			$scrummeetings[$key]->uname  = $member->fullname;
			$scrummeetings[$key]->prname = $scrummeetings[$key]->siid==0? "Backlog" :  $print->name;
			$scrummeetings[$key]->tname  = $type;
			$project = Core_Backend_ScrumMeeting::joiniteration($value->id);
			$scrummeetings[$key]->permiss = '0';
			if(Core_Backend_ScrumProject::getpermission(__METHOD__,$project))
				$scrummeetings[$key]->permiss = '1';
			# code...
		}
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'scrummeetings' 	=> $scrummeetings,
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
												'sprintid'		=> $siidFilter,
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
	function indexAjaxAction()
	{
		$str = "";
		if(isset($_POST['id'])&&$_POST['id']!="")
		{

			$user = new Core_User($_POST['id']);
			$str = $user->fullname;
		}
		echo $str;
	}
	function redirecturl()
	{
		$redirectUrl = $this->registry->conf['rooturl_admin']."notpermission";
		$redirectMsg = $this->registry->lang['default']['errPermission'];
		$this->registry->smarty->assign(array('redirect' => $redirectUrl,
											  'redirectMsg' => $redirectMsg,
		));
		$this->registry->smarty->display('redirect.tpl');
		exit();
	}


	function addAction()
	{

		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if(!$permiss)
			$this->redirecturl();
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['scrummeetingAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myScrumMeeting = new Core_Backend_ScrumMeeting();

					
					$myScrumMeeting->uid = $formData['fuid'];
					$myScrumMeeting->siid = $formData['fsiid'];
					$myScrumMeeting->type = $formData['ftype'];
					$myScrumMeeting->summary = $formData['fsummary'];
					$myScrumMeeting->note = $formData['fnote'];
					
                    if($myScrumMeeting->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('scrummeeting_add', $myScrumMeeting->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		$scrumiteration =  Core_Backend_ScrumIteration::getList("","");
		$liststatus = Core_Backend_ScrumMeeting::getListStatus();
		$_SESSION['scrummeetingAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'scrumiteration'	=> $scrumiteration,
												'liststatus'	=> $liststatus,
												'error'			=> $error,
												'success'		=> $success,
												'sprintid'		=> (int)$this->registry->router->getArg('siid'),

												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	
	
	function editAction()
	{
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if(!$permiss)
			$this->redirecturl();
		$id = (int)$this->registry->router->getArg('id');
		$myScrumMeeting = new Core_Backend_ScrumMeeting($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumMeeting->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fuid'] = $myScrumMeeting->uid;
			$formData['fsiid'] = $myScrumMeeting->siid;
			$formData['fid'] = $myScrumMeeting->id;
			$formData['ftype'] = $myScrumMeeting->type;
			$formData['fsummary'] = $myScrumMeeting->summary;
			$formData['fnote'] = $myScrumMeeting->note;
			$formData['fdatecreated'] = $myScrumMeeting->datecreated;
			$formData['fdatemodified'] = $myScrumMeeting->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['scrummeetingEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myScrumMeeting->uid = $formData['fuid'];
						$myScrumMeeting->siid = $formData['fsiid'];
						$myScrumMeeting->type = $formData['ftype'];
						$myScrumMeeting->summary = $formData['fsummary'];
						$myScrumMeeting->note = $formData['fnote'];
                        
                        if($myScrumMeeting->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('scrummeeting_edit', $myScrumMeeting->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			$user = new Core_User($formData['fuid']);
			$formData['username'] = $user->fullname;
			$scrumiteration =  Core_Backend_ScrumIteration::getList("","");
			$liststatus = Core_Backend_ScrumMeeting::getListStatus();
			$_SESSION['scrummeetingEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'scrumiteration'=> $scrumiteration,
													'liststatus'=> $liststatus,
													'error'		=> $error,
													'success'	=> $success,
													'sprintid'	=> $myScrumMeeting->siid,

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

		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if($permiss)
		{
			$id = (int)$this->registry->router->getArg('id');
			$myScrumMeeting = new Core_Backend_ScrumMeeting($id);
			if($myScrumMeeting->id > 0)
			{
				//tien hanh xoa
				if($myScrumMeeting->delete())
				{
					$redirectMsg = str_replace('###id###', $myScrumMeeting->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('scrummeeting_delete', $myScrumMeeting->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myScrumMeeting->id, $this->registry->lang['controller']['errDelete']);
				}

			}
			else
			{
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			}

			$this->registry->smarty->assign(array('redirect' => Core_Backend_ScrumProject::gethistory('',false),
												  'redirectMsg' => $redirectMsg,
			));
			$this->registry->smarty->display('redirect.tpl');
		}

			
	}
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fuid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errUidRequired'];
			$pass = false;
		}

		if($formData['fsiid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSiidRequired'];
			$pass = false;
		}

		if($formData['ftype'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		if($formData['fsummary'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSummaryRequired'];
			$pass = false;
		}

		if($formData['fnote'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNoteRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fuid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errUidRequired'];
			$pass = false;
		}

		if($formData['fsiid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSiidRequired'];
			$pass = false;
		}

		if($formData['ftype'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTypeRequired'];
			$pass = false;
		}

		if($formData['fsummary'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSummaryRequired'];
			$pass = false;
		}

		if($formData['fnote'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNoteRequired'];
			$pass = false;
		}
				
		return $pass;
	}
}

