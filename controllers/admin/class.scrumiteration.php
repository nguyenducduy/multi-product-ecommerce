<?php

Class Controller_Admin_ScrumIteration Extends Controller_Admin_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		header('Location: '.$this->registry['conf']['rooturl_admin'].'scrumproject');
		$permiss = Core_Backend_ScrumProject::checkPermiss();
		if($permiss=='admin')
		{
			$error 			= array();
			$success 		= array();
			$warning 		= array();
			$formData 		= array('fbulkid' => array());
			$_SESSION['securityToken']=Helper::getSecurityToken();//Token
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
			
			
			$spidFilter = (int)($this->registry->router->getArg('spid'));
			$stidFilter = (int)($this->registry->router->getArg('stid'));
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
				if($_SESSION['scrumiterationBulkToken']==$_POST['ftoken'])
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
								$myScrumIteration = new Core_Backend_ScrumIteration($id);
								
								if($myScrumIteration->id > 0)
								{
									//tien hanh xoa
									if($myScrumIteration->delete())
									{
										Core_Backend_ScrumStory::updateDataDeleteIteration($id);
										Core_Backend_ScrumMeeting::updateDataDeleteIteration($id);
										$deletedItems[] = $myScrumIteration->id;
										$this->registry->me->writelog('scrumiteration_delete', $myScrumIteration->id, array());      
									}
									else
										$cannotDeletedItems[] = $myScrumIteration->id;
								}
								else
									$cannotDeletedItems[] = $myScrumIteration->id;
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
			
			$_SESSION['scrumiterationBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
			
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

			if($idFilter > 0)
			{
				$paginateUrl .= 'id/'.$idFilter . '/';
				$formData['fid'] = $idFilter;
				$formData['search'] = 'id';
			}
			
			if(strlen($keywordFilter) > 0)
			{
				$paginateUrl .= 'keyword/' . $keywordFilter . '/';

				if($searchKeywordIn == 'name')
				{
					$paginateUrl .= 'searchin/name/';
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
			$total = Core_Backend_ScrumIteration::getScrumIterations($formData, $sortby, $sorttype, 0, true);   
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;
			

			//get latest account
			$scrumiterations = Core_Backend_ScrumIteration::getScrumIterations($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			foreach ( $scrumiterations as $key=>$value ) {
				$project = new Core_Backend_ScrumProject($value->spid);
				$team    =  new Core_Backend_ScrumTeam($value->stid);
				$scrumiterations[$key]->spid = $project->name;
				$scrumiterations[$key]->stid = $team->name;

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
			
					
			$this->registry->smarty->assign(array(	'scrumiterations' 	=> $scrumiterations,
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
													'projectId'     => $this->registry->router->getArg('pid'),
													));
			
			
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
			
			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectUrl = $this->registry->conf['rooturl_admin']."notpermission";
			$redirectMsg = $this->registry->lang['default']['errPermission'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	} 
	
		
	function addAction()
	{
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if($permiss)
		{
			$error 	= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumiterationAddToken'] == $_POST['ftoken'])
				{
					 $formData = array_merge($formData, $_POST);

									
					if($this->addActionValidator($formData, $error))
					{
						$myScrumIteration = new Core_Backend_ScrumIteration();

						
						$myScrumIteration->name = $formData['fname'];
						$myScrumIteration->note = $formData['fnote'];
						$myScrumIteration->spid = $formData['fspid'];
						$myScrumIteration->stid = $formData['fstid'];
						$myScrumIteration->datestarted = Helper::strtotimedmy($formData['fdatestarted']);
						$myScrumIteration->dateended = Helper::strtotimedmy($formData['fdateended']);
						
						if($myScrumIteration->addData())
						{
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('scrumiteration_add', $myScrumIteration->id, array());
							$formData = array();      
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errAdd'];            
						}
					}
				}
				
			}

			$_SESSION['scrumiterationAddToken']=Helper::getSecurityToken();//Tao token moi
			$team = Core_Backend_ScrumTeam::getScrumTeams(array(), '', '',  '');
			$project = Core_Backend_ScrumProject::getScrumProjects(array(), '', '',  '');
			$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array(),'','','');

			foreach ( $project as $k=>$v ) {
				if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$v->id))
					unset($project[$k]);
			}

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
													'redirectUrl'	=> $this->getRedirectUrl(),
													'error'			=> $error,
													'project'		=> $project,
													'scrumsession'	=> $scrumsession,
													'team'			=> $team,
													'success'		=> $success,
													'projectId'     => $this->registry->router->getArg('spid'),
													
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectUrl = $this->registry->conf['rooturl_admin']."notpermission";
			$redirectMsg = $this->registry->lang['default']['errPermission'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	}
	
	
	
	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myScrumIteration = new Core_Backend_ScrumIteration($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumIteration->spid);
		if($permiss)
		{


			
			$redirectUrl = $this->getRedirectUrl();
			if($myScrumIteration->id > 0)
			{
				$error 		= array();
				$success 	= array();
				$contents 	= '';
				$formData 	= array();
				
				$formData['fbulkid'] = array();
				
				$formData['fspid'] = $myScrumIteration->spid;
				$formData['fstid'] = $myScrumIteration->stid;
				$formData['fid'] = $myScrumIteration->id;
				$formData['fname'] = $myScrumIteration->name;
				$formData['fnote'] = $myScrumIteration->note;
				$formData['fdatestarted'] = date("d/m/Y",$myScrumIteration->datestarted);
				$formData['fdateended'] = date("d/m/Y",$myScrumIteration->dateended);
				$formData['fdatecreated'] = $myScrumIteration->datecreated;
				$formData['fdatemodified'] = $myScrumIteration->datemodified;
				
				if(!empty($_POST['fsubmit']))
				{
					if($_SESSION['scrumiterationEditToken'] == $_POST['ftoken'])
					{
						$formData = array_merge($formData, $_POST);
											
						if($this->editActionValidator($formData, $error))
						{
							
							$myScrumIteration->name = $formData['fname'];
							$myScrumIteration->stid = $formData['fstid'];
							$myScrumIteration->spid = $formData['fspid'];
							$myScrumIteration->note = $formData['fnote'];
							$myScrumIteration->datestarted = Helper::strtotimedmy($formData['fdatestarted']);
							$myScrumIteration->dateended = Helper::strtotimedmy($formData['fdateended']);
							
							if($myScrumIteration->updateData())
							{
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('scrumiteration_edit', $myScrumIteration->id, array());
							}
							else
							{
								$error[] = $this->registry->lang['controller']['errUpdate'];            
							}
						}
					}
					
						
				}
				
				$team = Core_Backend_ScrumTeam::getScrumTeams(array(), '', '',  '');
				$project = Core_Backend_ScrumProject::getScrumProjects(array(), '', '',  '');
				foreach ( $project as $k=>$v ) {
					if(!Core_Backend_ScrumProject::getpermission(__METHOD__,$v->id))
						unset($project[$k]);
				}
				$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array(),'','','');
				$_SESSION['scrumiterationEditToken'] = Helper::getSecurityToken();//Tao token moi
				
				$this->registry->smarty->assign(array(	'formData' 	=> $formData,
														'redirectUrl'=> $redirectUrl,
														'error'		=> $error,
														'project'		=> $project,
														'scrumsession'	=> $scrumsession,
														'team'			=> $team,
														'success'	=> $success,
														'projectId'     => $this->registry->router->getArg('pid'),
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
		else
		{
			$redirectUrl = $this->registry->conf['rooturl_admin']."notpermission";
			$redirectMsg = $this->registry->lang['default']['errPermission'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myScrumIteration = new Core_Backend_ScrumIteration($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumIteration->spid);
		if($permiss)
		{
			if($myScrumIteration->id > 0)
			{
				//tien hanh xoa
				if($myScrumIteration->delete())
				{
					Core_Backend_ScrumStory::updateDataDeleteIteration($id);
					$redirectMsg = str_replace('###id###', $myScrumIteration->id, $this->registry->lang['controller']['succDelete']);
					
					$this->registry->me->writelog('scrumiteration_delete', $myScrumIteration->id, array());  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myScrumIteration->id, $this->registry->lang['controller']['errDelete']);
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
		else
		{
			$redirectUrl = $this->registry->conf['rooturl_admin']."notpermission";
			$redirectMsg = $this->registry->lang['default']['errPermission'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
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

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
		if($formData['fdatestarted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errfdatestartedRequired'];
			$pass = false;
		}
		if($formData['fdateended'] == '')
		{
			$error[] = $this->registry->lang['controller']['errfdateendedRequired'];
			$pass = false;
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

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
		if($formData['fdatestarted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errfdatestartedRequired'];
			$pass = false;
		}
		if($formData['fdateended'] == '')
		{
			$error[] = $this->registry->lang['controller']['errfdateendedRequired'];
			$pass = false;
		}

		return $pass;
	}
}

