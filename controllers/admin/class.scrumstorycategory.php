<?php

Class Controller_Admin_ScrumStoryCategory Extends Controller_Admin_Base 
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
		$spid = (int)($this->registry->router->getArg('spid'));
		$permiss    = Core_Backend_ScrumProject::getpermission(__METHOD__ , $spid);
		if ( $spid == '0' || !$permiss ) {
			$this->redirecturl();
		}
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,0);
		if($permiss)
			$formData["permiss"] = '1';
		$error     = array();
		$success     = array();
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';
		//get latest account
		$scrumstorycategorys = Core_Backend_ScrumStoryCategory::getScrumStoryCategoryProject(' and ssc.sp_id="'.$spid.'"');//getScrumStoryCategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		$newStoryCategories = array();
		if(!empty($scrumstorycategorys)){
			foreach($scrumstorycategorys as $storyCate){
				$storyCate->story = Core_Backend_ScrumStory::countListFilterProjectCategory($storyCate->spid,$storyCate->id);
				$newStoryCategories[] = $storyCate;
				$storyCate->permiss = '0';
				if(Core_Backend_ScrumProject::getpermission(__METHOD__,$storyCate->spid))
					$storyCate->permiss = '1';
			}

		}
		$formData['iterationid'] = $spid;
		$total = count($scrumstorycategorys);
		$redirectUrl = base64_encode($paginateUrl);

		$this->registry->smarty->assign(array(	'scrumstorycategorys' 	=> $scrumstorycategorys,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'error'            => $error,
												'success'        => $success,
												'total'			=> $total,
												'formData'			=> $formData,
												'projectId'			=> $spid
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
		$redirectUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';
		if(!empty($_POST['fsubmit']))
		{
			if($_SESSION['scrumstorycategoryAddToken'] == $_POST['ftoken'])
			{
				 $formData = array_merge($formData, $_POST);


				if($this->addActionValidator($formData, $error))
				{
					$myScrumStoryCategory = new Core_Backend_ScrumStoryCategory();


					$myScrumStoryCategory->spid = $formData['fspid'];
					$myScrumStoryCategory->name = $formData['fname'];

					if($myScrumStoryCategory->addData())
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('scrumstorycategory_add', $myScrumStoryCategory->id, array());
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}

		}

		$_SESSION['scrumstorycategoryAddToken']=Helper::getSecurityToken();//Tao token moi
		$listproject = Core_Backend_ScrumProject::getList('','sp_name');
		foreach ($listproject as $key => $value) {
			if($value->status==1)
				unset($listproject[$key]);
			if(!Core_Backend_ScrumProject::checkthreadproject($value->id))
				unset($listproject[$key]);
		}
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'projectsList'=> $listproject,
												'projectId'=> (int)$this->registry->router->getArg('spid'),
												'redirectUrl' => $redirectUrl
												));

		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents,
												));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}
	
	
	
	function editAction()
	{

		$id = (int)$this->registry->router->getArg('id');
		$myScrumStoryCategory = new Core_Backend_ScrumStoryCategory($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStoryCategory->spid);
		if(!$permiss)
			$this->redirecturl();
		$redirectUrl = $this->getRedirectUrl();
		if($myScrumStoryCategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fspid'] = $myScrumStoryCategory->spid;
			$formData['fid'] = $myScrumStoryCategory->id;
			$formData['fname'] = $myScrumStoryCategory->name;
			$formData['fdatecreated'] = $myScrumStoryCategory->datecreated;
			$formData['fdatemodified'] = $myScrumStoryCategory->datemodified;

			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['scrumstorycategoryEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->editActionValidator($formData, $error))
					{

						$myScrumStoryCategory->spid = $formData['fspid'];
						$myScrumStoryCategory->name = $formData['fname'];

						if($myScrumStoryCategory->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('scrumstorycategory_edit', $myScrumStoryCategory->id, array());
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}


			}


			$_SESSION['scrumstorycategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			$listproject = Core_Backend_ScrumProject::getList('','sp_name');
			foreach ($listproject as $key => $value) {
				if($value->status==1)
					unset($listproject[$key]);
				if(!!Core_Backend_ScrumProject::checkthreadproject($value->id))
					unset($listproject[$key]);
			}
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'projectId'	=> $myScrumStoryCategory->spid,
													'projectsList'=>$listproject
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');

			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents,
													));
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
		$myScrumStoryCategory = new Core_Backend_ScrumStoryCategory($id);
		$permiss = Core_Backend_ScrumProject::getpermission(__METHOD__,$myScrumStoryCategory->spid);
		if($permiss)
		{
			if($myScrumStoryCategory->id > 0)
			{
				//tien hanh xoa
				if($myScrumStoryCategory->delete())
				{
					Core_Backend_ScrumStory::updateDataDeleteCategory($id);
					$redirectMsg = str_replace('###id###', $myScrumStoryCategory->id, $this->registry->lang['controller']['succDelete']);
					
					$this->registry->me->writelog('scrumstorycategory_delete', $myScrumStoryCategory->id, array());  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myScrumStoryCategory->id, $this->registry->lang['controller']['errDelete']);
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
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
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
		
		

		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['fspid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errProjectMustGreaterThanZero'];
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
		if($formData['fspid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errProjectMustGreaterThanZero'];
			$pass = false;
		}

		return $pass;
	}
}

