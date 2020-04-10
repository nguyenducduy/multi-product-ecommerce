 <?php

Class Controller_Admin_ScrumStory Extends Controller_Admin_Base 
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
		$siidFilter 	  = (int)($this->registry->router->getArg('siid'));
		$categoryidFilter = (int)($this->registry->router->getArg('categoryid'));
		if($siidFilter!='0')
			$project =  new Core_Backend_ScrumIteration($siidFilter);
		if($categoryidFilter!='0')
			$project = new Core_Backend_ScrumStoryCategory($categoryidFilter);


		$permiss    = Core_Backend_ScrumProject::getpermission(__METHOD__ , $project->spid);
		if ( $siidFilter == '0' )
			if($categoryidFilter == '0')
				$this->redirecturl();
		elseif(!$permiss)
			$this->redirecturl();

            $curPage        = 0;
			$error 			= array();
			$success 		= array();
			$warning 		= array();
			$formData 		= array('fbulkid' => array());
			$_SESSION['securityToken']=Helper::getSecurityToken();//Token
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

			$spidFilter = (int)($this->registry->router->getArg('spid'));
			$fibacklogstory = ($this->registry->router->getArg('fibacklogstory'));
			$asaFilter = (string)($this->registry->router->getArg('asa'));
			$iwantFilter = (string)($this->registry->router->getArg('iwant'));
			$tagFilter = (string)($this->registry->router->getArg('tag'));
			$pointFilter = (float)($this->registry->router->getArg('point'));
			$categoryidFilter = (int)($this->registry->router->getArg('categoryid'));
			$statusFilter = (int)($this->registry->router->getArg('status'));
			$fstatusFilter = (int)($this->registry->router->getArg('fstatus'));
			$priorityFilter = (int)($this->registry->router->getArg('priority'));
			$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
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

				if($_SESSION['scrumstoryBulkToken']==$_POST['ftoken'])
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
								$myScrumStory = new Core_Backend_ScrumStory($id);
								
								if($myScrumStory->id > 0)
								{
									//tien hanh xoa
									if($myScrumStory->delete())
									{
										$deletedItems[] = $myScrumStory->id;
										$this->registry->me->writelog('scrumstory_delete', $myScrumStory->id, array());      
									}
									else
										$cannotDeletedItems[] = $myScrumStory->id;
								}
								else
									$cannotDeletedItems[] = $myScrumStory->id;
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
			
			$_SESSION['scrumstoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
			
			$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
			
			if($spidFilter > 0)
			{
				$paginateUrl .= 'spid/'.$spidFilter . '/';
				$formData['fspid'] = $spidFilter;
				$formData['search'] = 'spid';
			}

			if($siidFilter > 0)
			{
				$paginateUrl .= 'siid/'.$siidFilter . '/';
				$formData['fsiid'] = $siidFilter;
				$formData['search'] = 'siid';
			}

			if($asaFilter != "")
			{
				$paginateUrl .= 'asa/'.$asaFilter . '/';
				$formData['fasa'] = $asaFilter;
				$formData['search'] = 'asa';
			}

			if($iwantFilter != "")
			{
				$paginateUrl .= 'iwant/'.$iwantFilter . '/';
				$formData['fiwant'] = $iwantFilter;
				$formData['search'] = 'iwant';
			}

			if($tagFilter != "")
			{
				$paginateUrl .= 'tag/'.$tagFilter . '/';
				$formData['ftag'] = $tagFilter;
				$formData['search'] = 'tag';
			}

			if($pointFilter > 0)
			{
				$paginateUrl .= 'point/'.$pointFilter . '/';
				$formData['fpoint'] = $pointFilter;
				$formData['search'] = 'point';
			}

			if($categoryidFilter > 0)
			{
				$paginateUrl .= 'categoryid/'.$categoryidFilter . '/';
				$formData['fcategoryid'] = $categoryidFilter;
				$formData['search'] = 'categoryid';
			}

			if($statusFilter > 0)
			{
				$paginateUrl .= 'status/'.$statusFilter . '/';
				$formData['fstatus'] = $statusFilter;
				$formData['search'] = 'status';
			}
			if($fstatusFilter > 0)
			{
				$formData['fstatus'] = $fstatusFilter;
				$formData['search'] = 'status';
			}

			if($priorityFilter > 0)
			{
				$paginateUrl .= 'priority/'.$priorityFilter . '/';
				$formData['fpriority'] = $priorityFilter;
				$formData['search'] = 'priority';
			}

			if($displayorderFilter > 0)
			{
				$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
				$formData['fdisplayorder'] = $displayorderFilter;
				$formData['search'] = 'displayorder';
			}

			if($idFilter > 0)
			{
				$paginateUrl .= 'id/'.$idFilter . '/';
				$formData['fid'] = $idFilter;
				$formData['search'] = 'id';
			}
			if(isset($fibacklogstory))
			{
				$paginateUrl .= 'fibacklogstory/'.$fibacklogstory . '/';
				$formData['fibacklogstory'] = (int) $fibacklogstory;
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
				elseif($searchKeywordIn == 'tag')
				{
					$paginateUrl .= 'searchin/tag/';
				}
				$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search'] = 'keyword';
			}

			//get latest account
			$scrumstorys = Core_Backend_ScrumStory::getScrumStorysJoinIterationCategory($formData, $sortby, $sorttype);
			foreach ($scrumstorys as $key=>$value ) {
				$project = new Core_Backend_ScrumProject($value->spid);
				$scrumstorys[$key]->projectname = $project->name;
				$scrumstorys[$key]->permiss = '0';
				if(Core_Backend_ScrumProject::getpermission(__METHOD__,$value->spid))
					$scrumstorys[$key]->permiss = '1';
			}

			$permiss = Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumStory::button',$project->spid);
			if($permiss==true)
				$formData['permiss'] = '1';
			else
				$formData['permiss'] = '0';
			$total = count($scrumstorys);
			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;
			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
			

			//build redirect string
			$redirectUrl = $paginateUrl;
			if($curPage > 1)
				$redirectUrl .= 'page/' . $curPage;
				
			
			$redirectUrl = base64_encode($redirectUrl);
			
			$projectList = Core_Backend_ScrumProject::getList('','sp_name');

			$arrProjectList = array();
			if(!empty($projectList)){
				foreach($projectList as $project){
					$arrProjectList[$project->id] = $project->name;
				}
			}
			$getStatusList = Core_Backend_ScrumStory::getStatusList();
			$getPriorityList = Core_Backend_ScrumStory::getPriorityList();
			$countStatusList = array();
			if(!empty($getStatusList)) {
				foreach($getStatusList as $statusid=>$statusname){
					$countStory = Core_Backend_ScrumStory::countList('ss_status = '.(int)$statusid.(!empty($spidFilter)?' AND sp_id = '.$spidFilter:'').(!empty($siidFilter)?' AND si_id = '.$siidFilter:''));
					$countStatusList[] = array('statustext'=>$statusname,'statusid'=>$statusid,'storynumber'=>$countStory);
				}            
			}
			$formData['iterationid'] = 0;
			$project = new Core_Backend_ScrumIteration($siidFilter);
			if(!empty($project))
				$formData['iterationid'] = $project->spid;
			$newScrummStoryList = array();        
			$iterationName = '';
			$level = Core_Backend_ScrumStory::getlevel();
			if(!empty($scrumstorys)){
				foreach($scrumstorys as $story){
					$story->countassignee = Core_Backend_ScrumStoryAsignee::getScrumStoryAsignees(array('fssid'=>$story->id),"","","",true);
					$session = new Core_Backend_ScrumSession($story->sssid);
					$story->sessionname = $session->name;
					$iterationName = $story->iterationName;
					$story->projectName = $arrProjectList[$story->spid];
					$story->hardlevel   = $level[$story->level];
					$story->statusname = $this->printstatus($story,$getStatusList);
					$story->prioritytext = $getPriorityList[$story->priority];
					$newScrummStoryList[] = $story;
				}
			}


			$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array(),'','','');


			/*chart*/
			$chartiteration = $this->statstory($siidFilter,false);
			/*end*/


			$this->registry->smarty->assign(array(	'scrumstorys' 	=> $scrumstorys,
													'formData'		=> $formData,
														'success'		=> $success,
													'error'			=> $error,
													'warning'		=> $warning,
													'filterUrl'		=> $filterUrl,
													'paginateurl' 	=> $paginateUrl, 
													'redirectUrl'	=> $redirectUrl,
													'total'			=> $total,
													'countStatusList'    => $countStatusList,
													'priorityList' => $getPriorityList,
													'currentProjectName' =>(!empty($arrProjectList[$spidFilter])?$arrProjectList[$spidFilter]:''),
													'projectId' => $spidFilter,
													'scrumIteraction' => $siidFilter,
													'scrumIterationName' =>$iterationName,
													'sprintid' =>$siidFilter,
													'chartiteration' =>$chartiteration,
													'scrumsession' =>$scrumsession,
													));
			
			
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
			
			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	}
	function printstatus($story,$statusname)
	{
		$story->statusname = $statusname[$story->status];
		if($story->status == Core_Backend_ScrumStory::STATUS_DONE) $story->statusname = '<span class="badge badge-important" style="cursor: pointer" onclick="changestatus(\''.$story->id.'\',\''.$story->status.'\')">'.$story->statusname.'</span>';
		elseif($story->status == Core_Backend_ScrumStory::STATUS_DOING) $story->statusname = '<span class="badge badge-success" style="cursor: pointer" onclick="changestatus(\''.$story->id.'\',\''.$story->status.'\')">'.$story->statusname.'</span>';
		else $story->statusname = '<span class="badge">'.$story->statusname.'</span>';
		return $story->statusname;
	}
	public function statstory($id = '' , $get = false)
	{
		if($id=='')
			$id = (int)$this->registry->router->getArg('siid');

		$scrumiteration = new Core_Backend_ScrumIteration($id);
		$output[$scrumiteration->name] = array();

		if($get)
		{
			$myCacher = new Cacher('statscrumstory::'.$scrumiteration->name,Cacher::STORAGE_MEMCACHED);
			$output[$scrumiteration->name] = json_decode($myCacher->get());
		}
		else
		{
			$myCacher = new Cacher('statscrumstory::' . $scrumiteration->name , Cacher::STORAGE_MEMCACHED);

			$date     = Helper::strtotimedmy(date('d/m/Y' , time()));
			$datetime = date('d/m/Y' , time());

			$start    = date('d/m/Y' , $scrumiteration->datestarted);
			$end      = date('d/m/Y' , $scrumiteration->dateended);
			$total    = $date > $scrumiteration->dateended ? $end - $start + 1 : $datetime - $start + 1;

			for ( $i = 0;$i < $total;$i++ )
			{
				$time                     = Helper::strtotimedmy($start) + (86400 * $i);
				$arr[date('d/m' , $time)] = 0;
			}

			$scrumstory = Core_Backend_ScrumStory::getScrumStorys(array('fsiid'=>$id,'fstatus'=>Core_Backend_ScrumStory::STATUS_DONE),'','','');
			foreach ( $scrumstory as $k=>$v ) {
				$arr[date('d/m',$v->datecompleted)] = $arr[date('d/m/Y',$v->datecompleted)] + 1 ;
			}

			$count = count($scrumstory);
			$dem   = 0;
			foreach ( $arr as $key=>$value ) {
				$dem 	   = $dem + $value;
				$arr[$key] = $count - $dem;
			}

			$output[$scrumiteration->name] = $arr;


			$myCacher->set(json_encode($arr));
		}
		return $output;
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
			$formData["permiss"] = '1';
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumstoryAddToken'] == $_POST['ftoken'])
				{
					 $formData = array_merge($formData, $_POST);
					
									
					if($this->addActionValidator($formData, $error))
					{
						$myScrumStory = new Core_Backend_ScrumStory();

						
						$myScrumStory->spid = $formData['fspid'];
						$myScrumStory->siid = $formData['fsiid'];
						$myScrumStory->asa = $formData['fasa'];
						$myScrumStory->iwant = $formData['fiwant'];
						$myScrumStory->sothat = $formData['fsothat'];
						$myScrumStory->tag = $formData['ftag'];
						$myScrumStory->point = $formData['fpoint'];
						$myScrumStory->categoryid = $formData['fcategoryid'];
						$myScrumStory->sssid = $formData['fsssid'];
						$myScrumStory->status = $formData['fstatus'];
						$myScrumStory->priority = $formData['fpriority'];
						$myScrumStory->level = $formData['flevel'];
						$myScrumStory->displayorder = $formData['fdisplayorder'];
						if($formData['fstatus'] == Core_Backend_ScrumStory::STATUS_DONE) $formData['fdatecompleted'] = time();
						else $formData['fdatecompleted'] = $myScrumStory->datecompleted;
						
						if($myScrumStory->addData())
						{
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('scrumstory_add', $myScrumStory->id, array());
							$formData = array();      
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errAdd'];            
						}
					}
				}
				
			}
			$level = Core_Backend_ScrumStory::getlevel();
			$_SESSION['scrumstoryAddToken']=Helper::getSecurityToken();//Tao token moi
			$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
			
			$listproject = Core_Backend_ScrumProject::getList('','sp_name');
			foreach ( $listproject as $key=>$value ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumProject::indexAction',$value->id))
					unset($listproject[$key]);
			}
			$listiteration = Core_Backend_ScrumIteration::getList('','si_name');
			$listStoryCate = Core_Backend_ScrumStoryCategory::getList('','ssc_name');
			foreach ( $listStoryCate as $key=>$value ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumStoryCategory::indexAction',$value->spid))
					unset($listStoryCate[$key]);
			}
			$listStatus = Core_Backend_ScrumStory::getStatusList();
			$getPriorityList = Core_Backend_ScrumStory::getPriorityList();
			$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array(),'','','');
			foreach ($scrumsession as $k=>$v ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumSession::indexAction',$v->spid))
					unset($scrumsession[$k]);
			}

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
													'redirectUrl'	=> $this->getRedirectUrl(),
													'error'			=> $error,
													'success'		=> $success,
													'redirectUrl'   => $paginateUrl,
													'listProject'   => $listproject,
													'level'   => $level,
													'listIteration'   => $listiteration,
													'listStoryCategory' =>$listStoryCate,
													'listStatus'        =>$listStatus,
													'priorityList' => $getPriorityList,
													'scrumsession' => $scrumsession,
													'sprintid' => (int)$this->registry->router->getArg('siid'),
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
		$myScrumStory = new Core_Backend_ScrumStory($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStory->spid);
		if(!$permiss)
			$this->redirecturl();
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumStory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fspid'] = $myScrumStory->spid;
			$formData['fsiid'] = $myScrumStory->siid;
			$formData['fid'] = $myScrumStory->id;
			$formData['fasa'] = $myScrumStory->asa;
			$formData['fiwant'] = $myScrumStory->iwant;
			$formData['fsothat'] = $myScrumStory->sothat;
			$formData['ftag'] = $myScrumStory->tag;
			$formData['fpoint'] = $myScrumStory->point;
			$formData['fcategoryid'] = $myScrumStory->categoryid;
			$formData['fsssid'] = $myScrumStory->sssid;
			$formData['fstatus'] = $myScrumStory->status;
			$formData['fpriority'] = $myScrumStory->priority;
			$formData['flevel'] = $myScrumStory->level;
			$formData['fdisplayorder'] = $myScrumStory->displayorder;
			if($formData['fstatus'] == Core_Backend_ScrumStory::STATUS_DONE) $formData['fdatecompleted'] = time();
			else $formData['fdatecompleted'] = $myScrumStory->datecompleted;
			$formData['fdatecreated'] = $myScrumStory->datecreated;
			$formData['fdatemodified'] = $myScrumStory->datemodified;
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumstoryEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myScrumStory->spid = $formData['fspid'];
						$myScrumStory->siid = $formData['fsiid'];
						$myScrumStory->asa = $formData['fasa'];
						$myScrumStory->iwant = $formData['fiwant'];
						$myScrumStory->sothat = $formData['fsothat'];
						$myScrumStory->tag = $formData['ftag'];
						$myScrumStory->point = $formData['fpoint'];
						$myScrumStory->categoryid = $formData['fcategoryid'];
						$myScrumStory->sssid = $formData['fsssid'];
						$myScrumStory->status = $formData['fstatus'];
						$myScrumStory->priority = $formData['fpriority'];
						$myScrumStory->level = $formData['flevel'];
						$myScrumStory->displayorder = $formData['fdisplayorder'];
						$myScrumStory->datecompleted = Helper::strtotimedmy($formData['fdatecompleted']);

						if($myScrumStory->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('scrumstory_edit', $myScrumStory->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}
			$level = Core_Backend_ScrumStory::getlevel();
			$_SESSION['scrumstoryEditToken'] = Helper::getSecurityToken();//Tao token moi
			$listproject = Core_Backend_ScrumProject::getList('','sp_name');
			foreach ( $listproject as $key=>$value ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumProject::indexAction',$value->id))
					unset($listproject[$key]);
			}
			$listiteration = Core_Backend_ScrumIteration::getList('','si_name');
			$listStoryCate = Core_Backend_ScrumStoryCategory::getList('','ssc_name');
			foreach ( $listStoryCate as $key=>$value ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumStoryCategory::indexAction',$value->spid))
					unset($listStoryCate[$key]);
			}
			$listStatus = Core_Backend_ScrumStory::getStatusList();
			$getPriorityList = Core_Backend_ScrumStory::getPriorityList();
			$scrumsession = Core_Backend_ScrumSession::getScrumSessions(array(),'','','');
			foreach ($scrumsession as $k=>$v ) {
				if(!Core_Backend_ScrumProject::getpermission('Controller_Admin_ScrumSession::indexAction',$v->spid))
					unset($scrumsession[$k]);
			}

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'listProject'   => $listproject,
													'listIteration'   => $listiteration,
													'level'   => $level,
													'listStatus'        =>$listStatus,
													'listStoryCategory' =>$listStoryCate,
													'priorityList' => $getPriorityList,
													'sprintid' => $myScrumStory->siid,
													'scrumsession' => $scrumsession,
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

            $content = isset($_POST['contents']) && $_POST['contents']!='' ? $_POST['contents'] : null ;


			$Story_id = isset($_POST['Story_id']) && $_POST['Story_id']!='' ? $_POST['Story_id'] : null ;
			$action = isset($_POST['action']) && $_POST['action']!='' ? $_POST['action'] : null ;
			$contents = "";
			if($content!= null)
			{

				switch ($action) {
					case 'add':
						$myScrumStoryComment          = new Core_Backend_ScrumStoryComment();
						$myScrumStoryComment->ssid    = $Story_id;
						$myScrumStoryComment->uid     = $this->registry->me->id;
						$myScrumStoryComment->content = $content;
						$newid                        = $myScrumStoryComment->addData();
						if($newid)
						{
							$comment = new Core_Backend_ScrumStoryComment($newid); 
							$user = new Core_User($comment->uid);
							$comment->username = $user->fullname;
							$comment->avatar = $user->avatar;
							$comment->datecreate = date("d-m-Y h:i:s A",$comment->datecreate);
							$this->registry->smarty->assign(array('comment' => $comment));
							$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'addcomment.tpl');
							$this->registry->smarty->assign(array('contents' 			=> $contents));  
						}
					break;

					case 'edit':
						
						$Comment_id = isset($_POST['Comment_id']) && $_POST['Comment_id']!='' ? $_POST['Comment_id'] : null ;

						$user = new Core_Backend_Scrumteammember($this->registry->me->id);
						if($Comment_id!=null   && in_array("admin",Core_Backend_ScrumProject::checkPermiss()))
						{
							$myScrumStoryComment            = new Core_Backend_ScrumStoryComment($Comment_id);
							$myScrumStoryComment->id        = $Comment_id;
							$myScrumStoryComment->ssid      = $Story_id;
							$myScrumStoryComment->content   = $content;
							if($myScrumStoryComment->updateData())
							{
								$contents = "ok";
							}
						}
						
					break;

					case 'getimg':
						$content ="";
						$Comment_id          = isset($_POST['Comment_id']) && $_POST['Comment_id']!='' ? $_POST['Comment_id'] : null ;
						if($Comment_id!=null)
						{
							
							$myScrumStoryComment = new Core_Backend_ScrumStoryComment($Comment_id);
							if($myScrumStoryComment->filepath!=null)
							{
								$img                 = $this->registry->conf['rooturl'].$this->registry->setting['scrumstorycomment']['imageDirectory'].$myScrumStoryComment->filepath;
								$contents			 = $img ;
							}
							
						}
					break;
					case 'changestatus':
						$html         = 'not';
						$id           = isset($_POST['siid']) && $_POST['siid'] != '' ? $_POST['siid'] : null;
						$statuschange = isset($_POST['statuschange']) && $_POST['statuschange'] != '' ? $_POST['statuschange'] : null;
						$scrumstory   = new Core_Backend_ScrumStory($id);
						$scrumasignee = Core_Backend_ScrumStoryAsignee::getScrumStoryAsignees(array ( "fssid" => $scrumstory->id , 'fuid' => $this->registry->me->id ) , '' , '' , '');

						if(!empty($scrumasignee) || Core_Backend_ScrumProject::getpermission(__METHOD__,$scrumstory->spid))
						{



							$Myscrumstory         = new Core_Backend_ScrumStory($id);
							$Myscrumstory->status = $statuschange;
							if($statuschange == Core_Backend_ScrumStory::STATUS_DOING)
							{
								$Myscrumstory->status = Core_Backend_ScrumStory::STATUS_DONE;
								$Myscrumstory->datecompleted = Helper::strtotimedmy(date('d/m/Y',time()));

							}
							if($statuschange == Core_Backend_ScrumStory::STATUS_DONE)
								$Myscrumstory->status = Core_Backend_ScrumStory::STATUS_DOING;


							if($Myscrumstory->updateData())
							{
								$getStatusList= Core_Backend_ScrumStory::getStatusList();
								$Myscrumstory = new Core_Backend_ScrumStory($id);
								$html         = $this->printstatus($Myscrumstory,$getStatusList);
							}

						}
						echo $html;
						break;
				
				}
			}
			$pid = (int)$this->registry->router->getArg('pid');
			if($pid!=null && $pid!='' && $pid>0)
			{
				$iteration 	= Core_Backend_ScrumIteration::getList('si.sp_id="'.$pid.'"',"");
				$this->registry->smarty->assign(array('iteration' => $iteration));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'getiteration.tpl');
				$this->registry->smarty->assign(array('contents' 			=> $contents));  
			}
			echo $contents;
		
	}
	
	function detailAction()
	{


		$id = (int)$this->registry->router->getArg('id');
		$myScrumStory = new Core_Backend_ScrumStory($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStory->spid);
		if(!$permiss)
			$this->redirecturl();

			if(isset($_POST['idComment']))
			{
				$idComment           = $_POST['idComment'];
				$myScrumStoryComment = new Core_Backend_ScrumStoryComment($idComment);
				if($myScrumStoryComment->id != null && $_FILES["datafile"]["name"]!="")
				{
						$myScrumStoryComment->upload($idComment,$_FILES);
				}
			}

			$id = (int)$this->registry->router->getArg('id');
			$listStatus = Core_Backend_ScrumStory::getStatusList();
			$myScrumStory = new Core_Backend_ScrumStory($id);
			$level = Core_Backend_ScrumStory::getlevel();
			$myScrumStory->mylevel = $level[$myScrumStory->level];
			$projectList = Core_Backend_ScrumProject::getList('','sp_name');
			$arrProjectList = array();

			if(!empty($projectList)){
				foreach($projectList as $project){
					$arrProjectList[$project->id] = $project->name;
				}
			}
			$comment = Core_Backend_ScrumStoryComment::getList("ssc.ss_id='".$id."'","");
			
			foreach ($comment as $key => $value) {
				$user = new Core_User($value->uid);
				$comment[$key]->username = $user->fullname;
				$comment[$key]->avatar = $user->avatar;

				if($comment[$key]->avatar!="")
				{
					$formData['avatar']="http://new.dienmay.com/uploads/avatar/".$comment[$key]->avatar;
				}
				else
				{
					$formData['avatar']= " http://new.dienmay.com/templates/default/images/plainicon.jpg";
				}

				$comment[$key]->datecreate = date("d-m-Y h:i:s A",$comment[$key]->datecreate);
				if($comment[$key]->filepath!=null)
					$comment[$key]->filepath =$this->registry->conf['rooturl'].$this->registry->setting['scrumstorycomment']['imageDirectory'].$comment[$key]->filepath;
				else
					$comment[$key]->filepath="";
			}
			
			$formData["meid"] = $this->registry->me->id;
			$user = new Core_User($formData["meid"]);
			$formData['avatar'] = $user->avatar;
			if($formData['avatar']!="")
				$formData['avatar']="http://new.dienmay.com/uploads/avatar/".$formData['avatar'];
			else
				$formData['avatar']= " http://new.dienmay.com/templates/default/images/plainicon.jpg";

			$formData["permiss"] = true;

			$myScrumStory->projectname = $arrProjectList[$myScrumStory->spid];
			$myScrumStory->status = $listStatus[$myScrumStory->status];
			$myScrumStory->datecompleted = date("d-m-Y" , $myScrumStory->datecompleted);

            $contents = '';
			if($myScrumStory->id!=null)
			{
				$this->registry->smarty->assign(array(	    'formData' 	=> $formData,
															'comment'=> $comment,
															'myScrumStory'	=> $myScrumStory,
															));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

				$this->registry->smarty->assign(array(
														'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
														'contents' 			=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
	
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myScrumStory = new Core_Backend_ScrumStory($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStory->spid);
		if(!$permiss)
			$this->redirecturl();
		if($myScrumStory->id > 0)
		{
			//tien hanh xoa
			if($myScrumStory->delete())
			{
				$redirectMsg = str_replace('###id###', $myScrumStory->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('scrumstory_delete', $myScrumStory->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myScrumStory->id, $this->registry->lang['controller']['errDelete']);
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

		if(!is_numeric($formData['fsiid']))
		{
			$error[] = $this->registry->lang['controller']['errSiidMustGreaterThanZero'];
			$pass = false;
		}

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
		if($formData['fsothat'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSothatRequired'];
			$pass = false;
		}
		if($formData['fdatecompleted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errdatecompletedRequired'];
			$pass = false;
		}

		if($formData['ftag'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTagRequired'];
			$pass = false;
		}

		if($formData['fpoint'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPointRequired'];
			$pass = false;
		}

		if(!is_numeric($formData['fcategoryid']))
		{
			$error[] = $this->registry->lang['controller']['errCategoryidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fdisplayorder'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errDisplayorderMustGreaterThanZero'];
			$pass = false;
		}
		if($formData['fcategoryid'] <= 0)
		{
			$error[] = 'Categoryid not is zero';
			$pass = false;
		}
		if($formData['flevel'] <= 0)
		{
			$error[] = 'Level not is zero';
			$pass = false;
		}
		if($formData['fpriority'] <= 0)
		{
			$error[] = 'Priority not is zero';
			$pass = false;
		}
		if($formData['fsssid'] <= 0)
		{
			$error[] = 'Session not is zero';
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

		if(!is_numeric($formData['fsiid']))
		{
			$error[] = $this->registry->lang['controller']['errSiidMustGreaterThanZero'];
			$pass = false;
		}

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

		if($formData['fsothat'] == '')
		{
			$error[] = $this->registry->lang['controller']['errSothatRequired'];
			$pass = false;
		}
		if($formData['fdatecompleted'] == '')
		{
			$error[] = $this->registry->lang['controller']['errdatecompletedRequired'];
			$pass = false;
		}
		if($formData['ftag'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTagRequired'];
			$pass = false;
		}

		if($formData['fpoint'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPointRequired'];
			$pass = false;
		}

		if(!is_numeric($formData['fcategoryid']))
		{
			$error[] = $this->registry->lang['controller']['errCategoryidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fdisplayorder'] < 0)
		{
			$error[] = $this->registry->lang['controller']['errDisplayorderMustGreaterThanZero'];
			$pass = false;
		}
		if($formData['fcategoryid'] < 0)
		{
			$error[] = 'Categoryid not is zero';
			$pass = false;
		}
		if($formData['flevel'] <= 0)
		{
			$error[] = 'Level not is zero';
			$pass = false;
		}
		if($formData['fpriority'] <= 0)
		{
			$error[] = 'Priority not is zero';
			$pass = false;
		}
		if($formData['fsssid'] <= 0)
		{
			$error[] = 'Session not is zero';
			$pass = false;
		}
		return $pass;
	}
}

