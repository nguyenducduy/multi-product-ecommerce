<?php
Class Controller_Site_Tuyendung Extends Controller_Site_Base
{
	public function indexAction()
	{
		if(isset($_GET['c']))
			return $this->listChild();
		else
			return $this->listParent();
	}

	private function listParent()
	{
		$formData = array();

		$jobmenu = Core_Jobcategory::getJobcategorys(array('fparentid' => 0, 'fstatus' => Core_Jobcategory::STATUS_ENABLE), 'displayorder', 'ASC', '');

		$id = (int)$_GET['p'];

		if(count($jobmenu) > 0)
		{
			//check xem danh muc nay co bai viet chua, neu chua co thi lay danh muc con
			$getdocpid = Core_Job::getJobs(array('fjcid' => $id, 'fstatus' => Core_Job::STATUS_ENABLE), 'datecreated', 'DESC'/*, '0, 5'*/);
			
			if(count($getdocpid) == 0)
			{
				$myJobcategoryList = Core_Jobcategory::getJobcategorys(array('fparentid' => $id, 'fstatus' => Core_Jobcategory::STATUS_ENABLE), 'displayorder', 'ASC', '');

				foreach($myJobcategoryList as $list)
				{
					$list->job = Core_Job::getJobs(array('fjcid' => $list->id, 'fstatus' => Core_Job::STATUS_ENABLE), 'datecreated', 'DESC', '0, 5');
				}
				//echodebug($myJobcategoryList);
			}
		}
		

		$this->registry->smarty->assign(array(	'jobmenu'	=> $jobmenu,
												//'hideMenu'	=> 1,
												'myJobcategoryList'	=> $myJobcategoryList,
												'id'		=> $id,
												'getdocpid'	=> $getdocpid
												));

		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listparent.tpl');
		
		$this->registry->smarty->assign(array(  
                                                'pageTitle' => $this->registry->lang['controller']['pagetitle'],
                                                'pageKeyword' => $this->registry->lang['controller']['pagekeyword'],
                                                'pageDescription' => $this->registry->lang['controller']['pagedescription'],
                                                'pageMetarobots' => '',
												'contents' => $contents));
												
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');	
		
		//for View Tracking
		$_GET['trackingid'] = $_GET['p'];
	}

	private function listChild()
	{
		$id = (int)$_GET['c'];
		
		$jobmenu = Core_Jobcategory::getJobcategorys(array('fparentid' => 0, 'fstatus' => Core_Jobcategory::STATUS_ENABLE), 'displayorder', 'ASC', '');
		$myJobcategory = new Core_Jobcategory($id);  
		$myJob = Core_Job::getJobs(array('fjcid' => $id, 'fstatus' => Core_Job::STATUS_ENABLE), 'datecreated', 'DESC', '');
		//echodebug($myJob, true);
		$this->registry->smarty->assign(array(	'formData'	=> $formData,
												//'hideMenu'	=> 1,
												'jobmenu'	=> $jobmenu,
												'myJob'		=> $myJob,
												'myJobcategory'	=> $myJobcategory
                                                ));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'listchild.tpl');
		
		$this->registry->smarty->assign(array(
												'pageTitle' => (!empty($myJobcategory->seotitle)?$myJobcategory->seotitle:$myJobcategory->name),
                                                'pageKeyword' => $myJobcategory->seokeyword,
                                                'pageDescription' => $myJobcategory->seodescription,
                                                'pageMetarobots' => '',
                                                'contents' => $contents));
												
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');	
		
		//for View Tracking
		$_GET['trackingid'] = $_GET['c'];
	}

	public function detailAction()
	{
		$id = (int)$_GET['id'];

		$myJob = new Core_Job($id);
		$myCategory = new Core_Jobcategory($myJob->jcid);

		$jobmenu = Core_Jobcategory::getJobcategorys(array('fparentid' => 0, 'fstatus' => Core_Jobcategory::STATUS_ENABLE), 'displayorder', 'ASC', '');

		$this->registry->smarty->assign(array(	//'hideMenu'		=> 1,
												'myJob'			=> $myJob,
												'jobmenu'		=> $jobmenu,
												'myCategory'	=> $myCategory));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

		$this->registry->smarty->assign(array(	'pageTitle' => (!empty($myJob->seotitle)?$myJob->seotitle:$myJob->title),
                                                'pageKeyword' => $myJob->seokeyword,
                                                'pageDescription' => $myJob->seodescription,
                                                'pageMetarobots' => '',
                                                'contents'		=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

		//for View Tracking
		$_GET['trackingid'] = $_GET['id'];
	}

}
