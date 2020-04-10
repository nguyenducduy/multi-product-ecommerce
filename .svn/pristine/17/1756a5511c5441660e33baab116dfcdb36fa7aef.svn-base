<?php

Class Controller_Cms_LastVisit Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken'] = Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$titleFilter = (string)($this->registry->router->getArg('title'));
		$urlFilter = (string)($this->registry->router->getArg('url'));
		$datelastvisitedFilter = (int)($this->registry->router->getArg('datelastvisited'));
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
            if($_SESSION['lastvisitBulkToken']==$_POST['ftoken'])
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
                            $myLastVisit = new Core_Backend_LastVisit($id);
                            
                            if($myLastVisit->id > 0)
                            {
                                //tien hanh xoa
                                if($myLastVisit->delete())
                                {
                                    $deletedItems[] = $myLastVisit->id;
                                    $this->registry->me->writelog('lastvisit_delete', $myLastVisit->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myLastVisit->id;
                            }
                            else
                                $cannotDeletedItems[] = $myLastVisit->id;
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
		
		$_SESSION['lastvisitBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($titleFilter != "")
		{
			$paginateUrl .= 'title/'.$titleFilter . '/';
			$formData['ftitle'] = $titleFilter;
			$formData['search'] = 'title';
		}

		if($urlFilter != "")
		{
			$paginateUrl .= 'url/'.$urlFilter . '/';
			$formData['furl'] = $urlFilter;
			$formData['search'] = 'url';
		}

		if($datelastvisitedFilter > 0)
		{
			$paginateUrl .= 'datelastvisited/'.$datelastvisitedFilter . '/';
			$formData['fdatelastvisited'] = $datelastvisitedFilter;
			$formData['search'] = 'datelastvisited';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_Backend_LastVisit::getLastVisits($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$lastvisits = Core_Backend_LastVisit::getLastVisits($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'lastvisits' 	=> $lastvisits,
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
    
    function indexajaxAction()
    {
        $formData = array();        
        $formData['fuid'] = $this->registry->me->id;
        $html = '';
        
        $lastvisits = Core_Backend_LastVisit::getLastVisits($formData, 'datelastvisited', 'DESC', 10);
        if(!empty($lastvisits)){
            $html = '<ul class="listvisited">';
            foreach($lastvisits as $visit){
                $html .= '<li><a href="'.$visit->url.'">'.$visit->title.'<span>'.$visit->datelastvisited.'</span></a></li>';
            }
            $html .= '</ul>';
        }
        echo $html;
    }
	
		
	function addAjaxAction()
	{

        $success = 0;
        $message = '';

        
        $formData = $_POST;

        
        if(strlen($formData['ftitle']) > 0 || strlen($formData['furl']) > 0)
        {
            $myLastVisit = new Core_Backend_LastVisit();

            $myLastVisit->uid = $this->registry->me->id;
            $myLastVisit->title = urldecode($formData['ftitle']);
            $myLastVisit->url = urldecode($formData['furl']);
            $myLastVisit->datelastvisited = time();
            
            $myLastVisit->addData();
        }                
	}
	
	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myLastVisit = new Core_Backend_LastVisit($id);
		if($myLastVisit->id > 0)
		{
			//tien hanh xoa
			if($myLastVisit->delete())
			{
				$redirectMsg = str_replace('###id###', $myLastVisit->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('lastvisit_delete', $myLastVisit->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myLastVisit->id, $this->registry->lang['controller']['errDelete']);
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
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		
				
		return $pass;
	}
}

