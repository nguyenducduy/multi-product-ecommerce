<?php

Class Controller_Admin_ScrumProject Extends Controller_Admin_Base 
{
	private $recordPerPage = 20;

	function indexAction() 
	{

		$this->createhistory();
		$error               = array ();
		$success             = array ();
		$warning             = array ();
		$formData            = array ( 'fbulkid' => array () );


		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


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
			if($_SESSION['scrumprojectBulkToken']==$_POST['ftoken'])
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
							$myScrumProject = new Core_Backend_ScrumProject($id);

							if($myScrumProject->id > 0)
							{
								//tien hanh xoa
								if($myScrumProject->updateDelete())
								{

									$deletedItems[] = $myScrumProject->id;
									$this->registry->me->writelog('scrumproject_delete', $myScrumProject->id, array());
								}
								else
									$cannotDeletedItems[] = $myScrumProject->id;
							}
							else
								$cannotDeletedItems[] = $myScrumProject->id;
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

		$_SESSION['scrumprojectBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



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
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Backend_ScrumProject::getScrumProjects(array("fstatus"=>"0"), $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$scrumprojects = Core_Backend_ScrumProject::getScrumProjects(array ( "fstatus" => "0" ) , $sortby , $sorttype , (($page - 1) * $this->recordPerPage) . ',' . $this->recordPerPage);

		$permiss       = Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumProject::button', 0);
		if($permiss)
			$formData["permiss"] = '1';
		foreach ($scrumprojects as $key => $value) {
			if(Core_Backend_ScrumProject::getpermission(__METHOD__,$value->id))
			{


				$where = 'sp_id = "'.$value->id.'"';
				$scrumprojects[$key]->countteam  = Core_Backend_ScrumTeam::countList('st.'.$where);
				$scrumprojects[$key]->countsession  = Core_Backend_ScrumSession::getScrumSessions(array(),'','','',true);
				$scrumprojects[$key]->countteammember  = Core_Backend_ScrumTeamMember::countList('stm.'.$where);
				$scrumprojects[$key]->countiteration  = Core_Backend_ScrumIteration::countList('si.'.$where);
				$scrumprojects[$key]->countstorycategory  = Core_Backend_ScrumStoryCategory::countList('ssc.'.$where);
			}
			else
			{
				unset($scrumprojects[$key]);
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


		$this->registry->smarty->assign(array(	'scrumprojects' 	=> $scrumprojects,
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
			if($_SESSION['scrumprojectAddToken'] == $_POST['ftoken'])
			{
				 $formData = array_merge($formData, $_POST);


				if($this->addActionValidator($formData, $error))
				{
					$myScrumProject = new Core_Backend_ScrumProject();


					$myScrumProject->name = $formData['fname'];
					$myScrumProject->status = "0";
					if($myScrumProject->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('scrumproject_add', $myScrumProject->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}

		}

		$_SESSION['scrumprojectAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myScrumProject = new Core_Backend_ScrumProject($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$id);
		if(!$permiss)
			$this->redirecturl();
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumProject->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fid'] = $myScrumProject->id;
			$formData['fname'] = $myScrumProject->name;

			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumprojectEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myScrumProject->name = $formData['fname'];
						$myScrumProject->status = 0;

						if($myScrumProject->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('scrumproject_edit', $myScrumProject->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}


			$_SESSION['scrumprojectEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,

													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'].' '.$myScrumProject->name,
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
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$id);
		if($permiss)
		{

			$myScrumProject = new Core_Backend_ScrumProject($id);
			if($myScrumProject->id > 0)
			{

				//tien hanh xoa
				if($myScrumProject->updateDelete())
				{


					$redirectMsg = str_replace('###id###', $myScrumProject->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('scrumproject_delete', $myScrumProject->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myScrumProject->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}
				
		return $pass;
	}
	public function detailAction()
	{
		$this->createhistory();
		$id 	 = (int)$this->registry->router->getArg('spid');
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$id);
		if(!$permiss)
			$this->redirecturl();

		if($id!='0')
		{
			$error               = array ();
			$success             = array ();
			$warning             = array ();
			$formData            = array ( 'fbulkid' => array () );

			$_SESSION['securityToken']=Helper::getSecurityToken();//Token
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
			if(Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumProject::additeration',$id))
				$formData['permiss'] = '1';

			$formData['fspid'] = $id;
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
				if($_SESSION['scrumprojectBulkToken']==$_POST['ftoken'])
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
								$success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDeleteIteration']);

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

			$_SESSION['scrumprojectBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

			$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';




			//tim tong so
			$total = Core_Backend_ScrumProject::getScrumProjects($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$scrumprojects = Core_Backend_ScrumProject::getScrumProjects($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);



			$scrumiteration = Core_Backend_ScrumIteration::getScrumIterations($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			$date                    = getdate();
			$formData['currentTime'] = $date[0];// thoi gian hien tai de hien ra
			$iterationCur            = $date[0]; // thoi gian hien tai de so sanh
			$iterationCurTmp         = 0; // thoi gian tam de lay current print
			$countDone               = 0;// dem so print thanh cong
			foreach($scrumiteration as $k=>$v)
			{
				$scrumiteration[$k]->countmeeting = Core_Backend_ScrumMeeting::getScrumMeetings(array('fsiid'=>$v->id),'','','',true);
				$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array('fsssid'=>$v->sssid),'','','');
				$scrumiteration[$k]->namesession = $scrumsession[0]->name ;
				$scrumiteration[$k]->statusname = "Running";
				if($formData['currentTime']>$v->dateended)
					$scrumiteration[$k]->statusname = "Done";
				$v->datestarted = date('d/m/y',$v->datestarted);
				$v->dateended = date('d/m/y',$v->dateended);
			}

			$ScrumIteration = new Core_Backend_ScrumIteration();
			$idmax = $ScrumIteration->getMaxid();
			foreach ($scrumiteration as $key => $value) {

				if($value->id == $idmax)
				{
						$formData['iterationTimeCurStart'] = $scrumiteration[$key]->datestarted;
						$formData['iterationTimeCurend']   = $scrumiteration[$key]->dateended;
						$formData['iterationCur']   = $scrumiteration[$key]->name;
				}
			}

			$getStatusList = Core_Backend_ScrumStory::getStatusList();
			$getPriorityList = Core_Backend_ScrumStory::getPriorityList();
			$countStatusList = array();
			if(!empty($getStatusList)) {
				foreach($getStatusList as $statusid=>$statusname){
					$countStory = Core_Backend_ScrumStory::countList('ss_status = '.(int)$statusid.(!empty($spidFilter)?' AND sp_id = '.$spidFilter:'').(!empty($siidFilter)?' AND si_id = '.$siidFilter:''));
					$formData['countStory'] = $countStory;
				}
			}

			$scrumproject = new Core_Backend_ScrumProject($id);
			$formData['nameproject'] = $scrumproject->name;
			$formData['countBackLog']   = Core_Backend_ScrumStory::getScrumStorys(array('fsiid'=>'0'),'','','',true);
			$formData['countIteration'] = Core_Backend_ScrumIteration::getScrumIterations(array('fspid'=>$id),'','','',true);
			$formData['countstory']     = Core_Backend_ScrumStory::getScrumStorys(array('fspid'=>$id),'','','',true);



			foreach ( $scrumiteration as $key=>$value ) {
				$story = Core_Backend_ScrumStory::getScrumStorys(array('fsiid'=>$value->id),'','','',true);
				$scrumiteration[$key]->countstory = $story;
			}

			$formData['countDone']      = $countDone;
			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;

			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


			//build redirect string
			$redirectUrl = $paginateUrl;
			if($curPage > 1)
				$redirectUrl .= 'page/' . $curPage;


			$redirectUrl = base64_encode($redirectUrl);


			$this->registry->smarty->assign(array(
													'scrumiterations' 	=> $scrumiteration,
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
													'projectId'        => $id,
													));


			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}
		else{
			$this->redirecturl();
		}

	}
	private function createhistory()
	{
		$link  = $this->registry->conf['rooturl'].substr($_SERVER['REQUEST_URI'],1);
		Core_Backend_ScrumProject::gethistory($link);
	}
}

