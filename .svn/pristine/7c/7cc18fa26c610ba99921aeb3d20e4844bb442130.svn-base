<?php

Class Controller_Admin_ScrumTeamMember Extends Controller_Admin_Base 
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
		$spidFilter = (int)($this->registry->router->getArg('spid'));
		$permiss    = Core_Backend_ScrumProject::getpermission(__METHOD__ , $spidFilter);
		if ( $spidFilter == '0' || !$permiss ) {
			$this->redirecturl();
		}

			$error 			= array();
			$success 		= array();
			$warning 		= array();
			$formData 		= array('fbulkid' => array());
			if(Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumTeamMember' , $spidFilter))
				$formData["permiss"] = '1';
			$_SESSION['securityToken']=Helper::getSecurityToken();//Token
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
			
			

			$stidFilter = (int)($this->registry->router->getArg('stid'));
			$uidFilter = (int)($this->registry->router->getArg('uid'));
			$idFilter = (int)($this->registry->router->getArg('id'));
			
			
			//check sort column condition
			$sortby 	= $this->registry->router->getArg('sortby');
			if($sortby == '') $sortby = 'id';
			$formData['sortby'] = $sortby;
			$sorttype 	= $this->registry->router->getArg('sorttype');
			if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
			$formData['sorttype'] = $sorttype;


			if(!empty($_POST['fsubmitbulk']))
			{
				
				if($_SESSION['scrumteammemberBulkToken']==$_POST['ftoken'])
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
								$myScrumTeamMember = new Core_Backend_ScrumTeamMember($id);
								
								if($myScrumTeamMember->id > 0)
								{
									//tien hanh xoa
									if($myScrumTeamMember->delete())
									{
										$deletedItems[] = $myScrumTeamMember->id;
										$this->registry->me->writelog('scrumteammember_delete', $myScrumTeamMember->id, array());      
									}
									else
										$cannotDeletedItems[] = $myScrumTeamMember->id;
								}
								else
									$cannotDeletedItems[] = $myScrumTeamMember->id;
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
			$formData['iterationid'] = $spidFilter;
			$_SESSION['scrumteammemberBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
			
			$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
			
			

			if($spidFilter > 0)
			{
				$paginateUrl .= 'spid/'.$spidFilter . '/';
				$formData['fspid'] = $spidFilter;
				$formData['search'] = 'spid';
			}

			if($stidFilter > 0)
			{
				$paginateUrl .= 'stid/'.$stidFilter . '/';
				$formData['fstid'] = $stidFilter;
				$formData['search'] = 'stid';
			}

			if($uidFilter > 0)
			{
				$paginateUrl .= 'uid/'.$uidFilter . '/';
				$formData['fuid'] = $uidFilter;
				$formData['search'] = 'uid';
			}

			if($idFilter > 0)
			{
				$paginateUrl .= 'id/'.$idFilter . '/';
				$formData['fid'] = $idFilter;
				$formData['search'] = 'id';
			}
			

			//tim tong so
			$total = Core_Backend_ScrumTeamMember::getScrumTeamMembers($formData, $sortby, $sorttype, 0, true);    
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;
			$user1 = new Core_User($this->registry->me->id , true);

			//get latest account
			$scrumteammembers = Core_Backend_ScrumTeamMember::getScrumTeamMembers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			foreach ($scrumteammembers as $key => $value) {
				$project = new Core_Backend_ScrumProject($scrumteammembers[$key]->spid);
				$teammem = new Core_Backend_ScrumTeam($scrumteammembers[$key]->stid);
				$member  = new Core_User($scrumteammembers[$key]->uid);
				$role    = Core_Backend_ScrumTeamMember::getNameRole($scrumteammembers[$key]->role);

				$scrumteammembers[$key]->spname = $project->name;
				$scrumteammembers[$key]->stname = $teammem->name;
				$scrumteammembers[$key]->uname  = $member->fullname;
				$scrumteammembers[$key]->rname  = $role;
				$scrumteammembers[$key]->permiss = '0';
				if($user1->checkGroupname('administrator'))
					$scrumteammembers[$key]->permiss = '1';
				else
					if(Core_Backend_ScrumProject::getpermission(__METHOD__,$value->spid) && $this->registry->me->id != $value->uid )
					{
						$user3 = new Core_User($value->uid);
						if(!$user3->checkGroupname('administrator'))
							$scrumteammembers[$key]->permiss = '1';

					}


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
			
					
			$this->registry->smarty->assign(array(	'scrumteammembers' 	=> $scrumteammembers,
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
													'projectId'		=> $spidFilter,
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
			if($_SESSION['scrumteammemberAddToken'] == $_POST['ftoken'])
			{
				 $formData = array_merge($formData, $_POST);


				if($this->addActionValidator($formData, $error))
				{
					$myScrumTeamMember = new Core_Backend_ScrumTeamMember();


					$myScrumTeamMember->spid = $formData['fspid'];
					$myScrumTeamMember->stid = $formData['fstid'];
					$myScrumTeamMember->role = $formData['frole'];
					$myScrumTeamMember->uid = $formData['fuid'];

					if($myScrumTeamMember->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('scrumteammember_add', $myScrumTeamMember->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}

		}
		$listRole  = Core_Backend_ScrumTeamMember::getListRole();
		if(Core_Backend_ScrumProject::checkPermiss() != 'admin')
			unset($listRole[Core_Backend_ScrumTeamMember::Role_master]);

		$team = Core_Backend_ScrumTeam::getScrumTeams(array(), '', '',  '');
		foreach ($team as $key => $value) {
			if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$value->spid))
				unset($team[$key]);
		}
		$project = Core_Backend_ScrumProject::getScrumProjects(array(), '', '',  '');
		foreach ($project as $key => $value) {
			if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$value->id))
				unset($project[$key]);
		}
		$_SESSION['scrumteammemberAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'listRole'		=> $listRole,
												'error'			=> $error,
												'project'		=> $project,
												'team'			=> $team,
												'success'		=> $success,
												'projectId'		=> (int)$this->registry->router->getArg('spid'),
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

		$myScrumTeamMember = new Core_Backend_ScrumTeamMember($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumTeamMember->spid);
		if(!$permiss)
			$this->redirecturl();
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumTeamMember->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fspid'] = $myScrumTeamMember->spid;
			$formData['fstid'] = $myScrumTeamMember->stid;
			$formData['fuid'] = $myScrumTeamMember->uid;
			$formData['fid'] = $myScrumTeamMember->id;
			$formData['frole'] = $myScrumTeamMember->role;
			$formData['fdatecreated'] = $myScrumTeamMember->datecreated;

			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumteammemberEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myScrumTeamMember->spid = $formData['fspid'];
						$myScrumTeamMember->stid = $formData['fstid'];
						$myScrumTeamMember->role = $formData['frole'];
						$myScrumTeamMember->uid = $formData['fuid'];
						if($myScrumTeamMember->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('scrumteammember_edit', $myScrumTeamMember->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}
			$listRole  = Core_Backend_ScrumTeamMember::getListRole();

			$project = Core_Backend_ScrumProject::getScrumProjects(array(), '', '',  '');
			$team = Core_Backend_ScrumTeam::getList("st.sp_id='".$formData['fspid']."'", '', '',  '');
			foreach ($team as $key => $value) {
				if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$value->spid))
					unset($team[$key]);
			}
			foreach ($project as $key => $value) {
				if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$value->id))
					unset($project[$key]);
			}
			$user = new Core_User($formData['fuid']);
			$formData['username'] = $user->fullname;
			$_SESSION['scrumteammemberEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'listRole'=> $listRole,
													'error'		=> $error,
													'project'		=> $project,
													'team'			=> $team,
													'success'	=> $success,
													'projectId'		=> $myScrumTeamMember->spid,

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
	function indexAjaxAction()
	{
		$id 	= (int)($this->registry->router->getArg('pid'));
		$contents = "";
		if($id!=null || $id!="" && $id>0)
		{
			$team 	= Core_Backend_ScrumTeam::getList('st.sp_id='.$id,"");
			$this->registry->smarty->assign(array('team' => $team));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'getteam.tpl');
			$this->registry->smarty->assign(array('contents' 			=> $contents));  
		}
		
		echo $contents;
	}
	function deleteAction()
	{


		$id = (int)$this->registry->router->getArg('id');
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$id);
		if(!$permiss)
		$this->redirecturl();
		$myScrumTeamMember = new Core_Backend_ScrumTeamMember($id);
		if($myScrumTeamMember->id > 0)
		{
			//tien hanh xoa
			if($myScrumTeamMember->delete())
			{
				$redirectMsg = str_replace('###id###', $myScrumTeamMember->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('scrumteammember_delete', $myScrumTeamMember->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myScrumTeamMember->id, $this->registry->lang['controller']['errDelete']);
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
	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fspid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSpidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}
		if($formData['frole'] == "")
		{
			$error[] = $this->registry->lang['controller']['errRoleidMustGreaterThanZero'];
			$pass = false;
		}
		if($formData['fuid'] > 0)
		{
			$where = "stm.u_id='".$formData['fuid']."' AND stm.sp_id ='".$formData['fspid']."'";
			$user =  Core_Backend_Scrumteammember::getList($where,"");
			if($user[0]->id!=null)
			{
				$error[] = $this->registry->lang['controller']['errExistUid'];
				$pass = false;
			}
			
		}
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fspid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errSpidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fstid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errStidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] > 0)
		{


			$where = "stm.u_id='".$formData['fuid']."' AND stm.sp_id ='".$formData['fspid']."' AND stm_id <>'".$formData['fid']."'";
			$user  =  Core_Backend_Scrumteammember::getList($where,"");
			if($user[0]->id!=null)
			{
				$error[] = $this->registry->lang['controller']['errExistUid'];
				$pass = false;
			}
		}	
		if($formData['frole'] == "")
		{
			$error[] = $this->registry->lang['controller']['errRoleidMustGreaterThanZero'];
			$pass = false;
		}	
		return $pass;
	}
	
}

