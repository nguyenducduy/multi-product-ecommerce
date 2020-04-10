<?php

Class Controller_Admin_ScrumStoryAsignee Extends Controller_Admin_Base 
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
		$ssidFilter = (int)($this->registry->router->getArg('ssid'));
		$project = new Core_Backend_ScrumStory($ssidFilter);
		$permiss    = Core_Backend_ScrumProject::getpermission(__METHOD__ , $project->spid);
		if ( $ssidFilter == '0' || !$permiss ) {
			$this->redirecturl();
		}

		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		

		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$idFilter = (int)($this->registry->router->getArg('id'));




		$project = new Core_Backend_ScrumStory($ssidFilter);
		$formData['projectid'] = 0;
		$formData['iterationid'] = 0;
		if(!empty($project))
		{
			$formData['projectid'] = $project->spid;
			$formData['iterationid'] = $project->siid;
		}






		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;	
		
		
		if(!empty($_POST['fsubmitbulk']))
		{
			if($_SESSION['scrumstoryasigneeBulkToken']==$_POST['ftoken'])
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
							$myScrumStoryAsignee = new Core_Backend_ScrumStoryAsignee($id);
							
							if($myScrumStoryAsignee->id > 0)
							{
								//tien hanh xoa
								if($myScrumStoryAsignee->delete())
								{
									$deletedItems[] = $myScrumStoryAsignee->id;
									$this->registry->me->writelog('scrumstoryasignee_delete', $myScrumStoryAsignee->id, array());      
								}
								else
									$cannotDeletedItems[] = $myScrumStoryAsignee->id;
							}
							else
								$cannotDeletedItems[] = $myScrumStoryAsignee->id;
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
		
		$_SESSION['scrumstoryasigneeBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($ssidFilter > 0)
		{
			$paginateUrl .= 'ssid/'.$ssidFilter . '/';
			$formData['fssid'] = $ssidFilter;
			$formData['search'] = 'ssid';
		}

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Backend_ScrumStoryAsignee::getScrumStoryAsignees($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$scrumstoryasignees = Core_Backend_ScrumStoryAsignee::getScrumStoryAsignees($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		foreach ($scrumstoryasignees as $key => $value) {
			$scrumstory =  new Core_Backend_ScrumStory($value->ssid);
			$user =  new Core_User($value->uid);

			$project = Core_Backend_ScrumStoryAsignee::innerjoinstory($value->ssid);
			$scrumstoryasignees[$key]->permiss = '0';
			if(Core_Backend_ScrumProject::getpermission(__METHOD__,$project))
				$scrumstoryasignees[$key]->permiss = '1';
			$scrumstoryasignees[$key]->storyname = $scrumstory->iwant;
			$scrumstoryasignees[$key]->uname = $user->fullname;


		}
		$permiss       = Core_Backend_ScrumProject::getpermission(__METHOD__ , 0);
		if($permiss)
			$formData["permiss"] = '1';
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
		$this->registry->smarty->assign(array(	'scrumstoryasignees' 	=> $scrumstoryasignees,
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
												'projectId'		=> $ssidFilter,
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
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
			if($_SESSION['scrumstoryasigneeAddToken'] == $_POST['ftoken'])
			{
				 $formData = array_merge($formData, $_POST);


				if($this->addActionValidator($formData, $error))
				{
					$myScrumStoryAsignee = new Core_Backend_ScrumStoryAsignee();


					$myScrumStoryAsignee->ssid = $formData['fssid'];
					$myScrumStoryAsignee->uid = $formData['fuid'];
					$myScrumStoryAsignee->type = $formData['ftype'];

					if($myScrumStoryAsignee->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('scrumstoryasignee_add', $myScrumStoryAsignee->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}

		}
		$scrumstory = Core_Backend_ScrumStory::getScrumStorys(array(),'','','');
		$_SESSION['scrumstoryasigneeAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'scrumstory'		=> $scrumstory,
												'projectId'		=> (int)$this->registry->router->getArg('ssid'),

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
		$myScrumStoryAsignee = new Core_Backend_ScrumStoryAsignee($id);
		$project = Core_Backend_ScrumStoryAsignee::innerjoinstory($myScrumStoryAsignee->ssid);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$project);
		if(!$permiss)
			$this->redirecturl();
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumStoryAsignee->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fssid'] = $myScrumStoryAsignee->ssid;
			$formData['fuid'] = $myScrumStoryAsignee->uid;
			$formData['fid'] = $myScrumStoryAsignee->id;
			$formData['ftype'] = $myScrumStoryAsignee->type;
			$formData['fdatecreated'] = $myScrumStoryAsignee->datecreated;
			$user = new Core_User($formData['fuid']);
			$formData["username"]= $user->fullname;
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumstoryasigneeEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myScrumStoryAsignee->ssid = $formData['fssid'];
						$myScrumStoryAsignee->uid = $formData['fuid'];
						$myScrumStoryAsignee->type = $formData['ftype'];

						if($myScrumStoryAsignee->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('scrumstoryasignee_edit', $myScrumStoryAsignee->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}

			$scrumstory = Core_Backend_ScrumStory::getScrumStorys(array(),'','','');
			$_SESSION['scrumstoryasigneeEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'scrumstory'		=> $scrumstory,
													'storyid'		=> $myScrumStoryAsignee->ssid,
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
		$myScrumStoryAsignee = new Core_Backend_ScrumStoryAsignee($id);
		$project = Core_Backend_ScrumStoryAsignee::innerjoinstory($myScrumStoryAsignee->ssid);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if($permiss)
		{

			$myScrumStoryAsignee = new Core_Backend_ScrumStoryAsignee($id);
			if($myScrumStoryAsignee->id > 0)
			{
				//tien hanh xoa
				if($myScrumStoryAsignee->delete())
				{
					$redirectMsg = str_replace('###id###', $myScrumStoryAsignee->id, $this->registry->lang['controller']['succDelete']);
					
					$this->registry->me->writelog('scrumstoryasignee_delete', $myScrumStoryAsignee->id, array());  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myScrumStoryAsignee->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fssid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSsidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ftype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeMustGreaterThanZero'];
			$pass = false;
		}
		if($pass)
		{
			$Countscrumassignee = Core_Backend_ScrumStoryAsignee::getScrumStoryAsignees(array('fuid'=>$formData['fuid'] , 'fssid'=>$formData['fssid']),'','','',true);
			if($Countscrumassignee!=0)
			{
				$pass = false;
				$error[] = 'User đã đuợc assign trong story';
			}
		}
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fssid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSsidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ftype'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errTypeMustGreaterThanZero'];
			$pass = false;
		}

		return $pass;
	}
}

