<?php

	Class Controller_Admin_ScrumTeam Extends Controller_Admin_Base
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

			$error    = array ();
			$success  = array ();
			$warning  = array ();
			$formData = array ( 'fbulkid' => array () );

			$_SESSION['securityToken'] = Helper::getSecurityToken(); //Token
			$page                      = (int)($this->registry->router->getArg('page')) > 0 ? (int)($this->registry->router->getArg('page')) : 1;


			$idFilter = (int)($this->registry->router->getArg('id'));

			$keywordFilter   = (string)$this->registry->router->getArg('keyword');
			$searchKeywordIn = (string)$this->registry->router->getArg('searchin');

			//check sort column condition
			$sortby = $this->registry->router->getArg('sortby');
			if ( $sortby == '' ) {
				$sortby = 'id';
			}
			$formData['sortby'] = $sortby;
			$sorttype           = $this->registry->router->getArg('sorttype');
			if ( strtoupper($sorttype) != 'ASC' ) {
				$sorttype = 'DESC';
			}
			$formData['sorttype'] = $sorttype;


			if ( !empty($_POST['fsubmitbulk']) ) {
				if ( $_SESSION['scrumteamBulkToken'] == $_POST['ftoken'] ) {
					if ( !isset($_POST['fbulkid']) ) {
						$warning[] = $this->registry->lang['default']['bulkItemNoSelected'];
					}
					else {
						$formData['fbulkid'] = $_POST['fbulkid'];

						//check for delete
						if ( $_POST['fbulkaction'] == 'delete' ) {
							$delArr             = $_POST['fbulkid'];
							$deletedItems       = array ();
							$cannotDeletedItems = array ();
							foreach ( $delArr as $id ) {
								//check valid user and not admin user
								$myScrumTeam = new Core_Backend_ScrumTeam($id);

								if ( $myScrumTeam->id > 0 ) {
									//tien hanh xoa
									if ( $myScrumTeam->delete() ) {
										Core_Backend_ScrumTeamMember::deleteByteam($id);
										$deletedItems[] = $myScrumTeam->id;
										$this->registry->me->writelog('scrumteam_delete' , $myScrumTeam->id , array ());
									}
									else {
										$cannotDeletedItems[] = $myScrumTeam->id;
									}
								}
								else {
									$cannotDeletedItems[] = $myScrumTeam->id;
								}
							}

							if ( count($deletedItems) > 0 ) {
								$success[] = str_replace('###id###' , implode(', ' , $deletedItems) , $this->registry->lang['controller']['succDelete']);
							}

							if ( count($cannotDeletedItems) > 0 ) {
								$error[] = str_replace('###id###' , implode(', ' , $cannotDeletedItems) , $this->registry->lang['controller']['errDelete']);
							}
						}
						else {
							//bulk action not select, show error
							$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
						}
					}
				}

			}

			$_SESSION['scrumteamBulkToken'] = Helper::getSecurityToken(); //Gan token de kiem soat viec nhan nut submit form

			$paginateUrl             = $this->registry->conf['rooturl'] . $this->registry->controllerGroup . '/' . $this->registry->controller . '/index/';
			$formData['iterationid'] = $spidFilter;


			if ( $spidFilter > 0 ) {
				$paginateUrl .= 'spid/' . $spidFilter . '/';
				$formData['fspid']  = $spidFilter;
				$formData['search'] = 'spid';
			}

			if ( $idFilter > 0 ) {
				$paginateUrl .= 'id/' . $idFilter . '/';
				$formData['fid']    = $idFilter;
				$formData['search'] = 'id';
			}

			if ( strlen($keywordFilter) > 0 ) {
				$paginateUrl .= 'keyword/' . $keywordFilter . '/';

				if ( $searchKeywordIn == 'name' ) {
					$paginateUrl .= 'searchin/name/';
				}
				$formData['fkeyword']  = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search']    = 'keyword';
			}

			//tim tong so
			$total     = Core_Backend_ScrumTeam::getScrumTeams($formData , $sortby , $sorttype , 0 , true);
			$totalPage = ceil($total / $this->recordPerPage);
			$curPage   = $page;


			//get latest account
			$scrumteams = Core_Backend_ScrumTeam::getScrumTeams($formData , $sortby , $sorttype , (($page - 1) * $this->recordPerPage) . ',' . $this->recordPerPage);


			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;

			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
			$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__ , $spidFilter);
			if ( $permiss ) {
				$formData['permiss'] = '1';
			}
			foreach ( $scrumteams as $key => $value ) {
				$scrumteams[$key]->permiss = '0';
				if ( Core_Backend_ScrumProject::checkthreadproject($value->spid) ) {
					$scrumteams[$key]->permiss = '1';
				}
				$project                  = new Core_Backend_ScrumProject($scrumteams[$key]->spid);
				$scrumteams[$key]->spname = $project->name;
			}
			//build redirect string
			$redirectUrl = $paginateUrl;
			if ( $curPage > 1 ) {
				$redirectUrl .= 'page/' . $curPage;
			}


			$redirectUrl = base64_encode($redirectUrl);


			$this->registry->smarty->assign(array ( 'scrumteams'  => $scrumteams ,
													'formData'    => $formData ,
													'success'     => $success ,
													'error'       => $error ,
													'warning'     => $warning ,
													'filterUrl'   => $filterUrl ,
													'paginateurl' => $paginateUrl ,
													'redirectUrl' => $redirectUrl ,
													'total'       => $total ,
													'totalPage'   => $totalPage ,
													'curPage'     => $curPage ,
													'projectId'        => $spidFilter,
			));


			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'index.tpl');

			$this->registry->smarty->assign(array ( 'pageTitle' => $this->registry->lang['controller']['pageTitle_list'] ,
													'contents'  => $contents ));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}

		function redirecturl()
		{
			$redirectUrl = $this->registry->conf['rooturl_admin'] . "notpermission";
			$redirectMsg = $this->registry->lang['default']['errPermission'];
			$this->registry->smarty->assign(array ( 'redirect'    => $redirectUrl ,
													'redirectMsg' => $redirectMsg ,
			));
			$this->registry->smarty->display('redirect.tpl');
			exit();
		}

		function addAction()
		{

			$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__ , 0);
			if ( !$permiss ) {
				$this->redirecturl();
			}
			$error    = array ();
			$success  = array ();
			$contents = '';
			$formData = array ();

			if ( !empty($_POST['fsubmit']) ) {
				if ( $_SESSION['scrumteamAddToken'] == $_POST['ftoken'] ) {
					$formData = array_merge($formData , $_POST);


					if ( $this->addActionValidator($formData , $error) ) {
						$myScrumTeam = new Core_Backend_ScrumTeam();


						$myScrumTeam->spid = $formData['fspid'];
						$myScrumTeam->name = $formData['fname'];

						if ( $myScrumTeam->addData() ) {
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('scrumteam_add' , $myScrumTeam->id , array ());
							$formData = array ();
						}
						else {
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}

			}
			$project = Core_Backend_ScrumProject::getScrumProjects(array () , '' , '' , '');
			foreach ( $project as $key => $value ) {
				if ( !Core_Backend_ScrumProject::checkthreadproject($value->id) ) {
					unset($project[$key]);
				}
			}
			$_SESSION['scrumteamAddToken'] = Helper::getSecurityToken(); //Tao token moi

			$this->registry->smarty->assign(array ( 'formData'    => $formData ,
													'redirectUrl' => $this->getRedirectUrl() ,
													'error'       => $error ,
													'project'     => $project ,
													'success'     => $success ,
													'projectId'     => (int)$this->registry->router->getArg('spid') ,

			));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'add.tpl');
			$this->registry->smarty->assign(array (
				'pageTitle' => $this->registry->lang['controller']['pageTitle_add'] ,
				'contents'  => $contents ));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}


		function editAction()
		{

			$id = (int)$this->registry->router->getArg('id');


			$myScrumTeam = new Core_Backend_ScrumTeam($id);
			$permiss     = Core_Backend_ScrumProject::getpermission(__METHOD__ , $myScrumTeam->spid);
			if ( !$permiss ) {
				$this->redirecturl();
			}
			$redirectUrl = $this->getRedirectUrl();
			if ( $myScrumTeam->id > 0 ) {
				$error    = array ();
				$success  = array ();
				$contents = '';
				$formData = array ();

				$formData['fbulkid'] = array ();


				$formData['fspid'] = $myScrumTeam->spid;
				$formData['fid']   = $myScrumTeam->id;
				$formData['fname'] = $myScrumTeam->name;

				if ( !empty($_POST['fsubmit']) ) {
					if ( $_SESSION['scrumteamEditToken'] == $_POST['ftoken'] ) {
						$formData = array_merge($formData , $_POST);

						if ( $this->editActionValidator($formData , $error) ) {

							$myScrumTeam->spid = $formData['fspid'];
							$myScrumTeam->name = $formData['fname'];

							if ( $myScrumTeam->updateData() ) {
								$success[] = $this->registry->lang['controller']['succUpdate'];
								$this->registry->me->writelog('scrumteam_edit' , $myScrumTeam->id , array ());
							}
							else {
								$error[] = $this->registry->lang['controller']['errUpdate'];
							}
						}
					}


				}

				$project = Core_Backend_ScrumProject::getScrumProjects(array () , '' , '' , '');
				foreach ( $project as $key => $value ) {
					if ( !Core_Backend_ScrumProject::checkthreadproject($value->id) ) {
						unset($project[$key]);
					}
				}

				$_SESSION['scrumteamEditToken'] = Helper::getSecurityToken(); //Tao token moi

				$this->registry->smarty->assign(array ( 'formData'    => $formData ,
														'redirectUrl' => $redirectUrl ,
														'error'       => $error ,
														'project'     => $project ,
														'success'     => $success ,
														'projectId'     => $myScrumTeam->spid,

				));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'edit.tpl');
				$this->registry->smarty->assign(array (
					'pageTitle' => $this->registry->lang['controller']['pageTitle_edit'] ,
					'contents'  => $contents ));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else {
				$redirectMsg = $this->registry->lang['controller']['errNotFound'];
				$this->registry->smarty->assign(array ( 'redirect'    => $redirectUrl ,
														'redirectMsg' => $redirectMsg ,
				));
				$this->registry->smarty->display('redirect.tpl');
			}

		}

		function deleteAction()
		{
			$id          = (int)$this->registry->router->getArg('id');
			$myScrumTeam = new Core_Backend_ScrumTeam($id);
			$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__ , $myScrumTeam->spid);
			if ( $permiss ) {

				if ( $myScrumTeam->id > 0 ) {
					//tien hanh xoa
					if ( $myScrumTeam->delete() ) {
						Core_Backend_ScrumTeamMember::deleteByteam($id);
						$redirectMsg = str_replace('###id###' , $myScrumTeam->id , $this->registry->lang['controller']['succDelete']);

						$this->registry->me->writelog('scrumteam_delete' , $myScrumTeam->id , array ());
					}
					else {
						$redirectMsg = str_replace('###id###' , $myScrumTeam->id , $this->registry->lang['controller']['errDelete']);
					}

				}
				else {
					$redirectMsg = $this->registry->lang['controller']['errNotFound'];
				}

				$this->registry->smarty->assign(array ( 'redirect'    => Core_Backend_ScrumProject::gethistory('',false) ,
														'redirectMsg' => $redirectMsg ,
				));
				$this->registry->smarty->display('redirect.tpl');
			}
			else {
				$redirectUrl = $this->registry->conf['rooturl_admin'] . "notpermission";
				$redirectMsg = $this->registry->lang['default']['errPermission'];
				$this->registry->smarty->assign(array ( 'redirect'    => $redirectUrl ,
														'redirectMsg' => $redirectMsg ,
				));
				$this->registry->smarty->display('redirect.tpl');
			}

		}

		####################################################################################################
		####################################################################################################
		####################################################################################################

		//Kiem tra du lieu nhap trong form them moi
		private function addActionValidator($formData , &$error)
		{
			$pass = true;


			if ( $formData['fspid'] <= 0 ) {
				$error[] = $this->registry->lang['controller']['errSpidMustGreaterThanZero'];
				$pass    = false;
			}

			if ( $formData['fname'] == '' ) {
				$error[] = $this->registry->lang['controller']['errNameRequired'];
				$pass    = false;
			}

			return $pass;
		}

		//Kiem tra du lieu nhap trong form cap nhat
		private function editActionValidator($formData , &$error)
		{
			$pass = true;
			if ( $formData['fspid'] <= 0 ) {
				$error[] = $this->registry->lang['controller']['errSpidMustGreaterThanZero'];
				$pass    = false;
			}

			if ( $formData['fname'] == '' ) {
				$error[] = $this->registry->lang['controller']['errNameRequired'];
				$pass    = false;
			}

			return $pass;
		}
	}

