<?php

Class Controller_Admin_BackgroundTask Extends Controller_Admin_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		
		//just a test
		//$url = $this->registry->conf['rooturl'] . 'task/ping?a=1&b=2&debug=1';
		//Helper::backgroundHttpPost($url, 'c=1&d=2');
		
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$timeprocessingFilter = (int)($this->registry->router->getArg('timeprocessing'));
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
            if($_SESSION['backgroundtaskBulkToken']==$_POST['ftoken'])
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
                            $myBackgroundTask = new Core_Backend_BackgroundTask($id);
                            
                            if($myBackgroundTask->id > 0)
                            {
                                //tien hanh xoa
                                if($myBackgroundTask->delete())
                                {
                                    $deletedItems[] = $myBackgroundTask->id;
                                    $this->registry->me->writelog('backgroundtask_delete', $myBackgroundTask->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myBackgroundTask->id;
                            }
                            else
                                $cannotDeletedItems[] = $myBackgroundTask->id;
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
		
		$_SESSION['backgroundtaskBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl_admin'].$this->registry->controller.'/index/';      
		
		

		if($timeprocessingFilter > 0)
		{
			$paginateUrl .= 'timeprocessing/'.$timeprocessingFilter . '/';
			$formData['ftimeprocessing'] = $timeprocessingFilter;
			$formData['search'] = 'timeprocessing';
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

			if($searchKeywordIn == 'url')
			{
				$paginateUrl .= 'searchin/url/';
			}
			elseif($searchKeywordIn == 'postdata')
			{
				$paginateUrl .= 'searchin/postdata/';
			}
			elseif($searchKeywordIn == 'output')
			{
				$paginateUrl .= 'searchin/output/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
				
		//tim tong so
		$total = Core_Backend_BackgroundTask::getBackgroundTasks($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$backgroundtasks = Core_Backend_BackgroundTask::getBackgroundTasks($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'backgroundtasks' 	=> $backgroundtasks,
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
	
	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myBackgroundTask = new Core_Backend_BackgroundTask($id);
		if($myBackgroundTask->id > 0)
		{
			//tien hanh xoa
			if($myBackgroundTask->delete())
			{
				$redirectMsg = str_replace('###id###', $myBackgroundTask->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('backgroundtask_delete', $myBackgroundTask->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myBackgroundTask->id, $this->registry->lang['controller']['errDelete']);
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
	
}

