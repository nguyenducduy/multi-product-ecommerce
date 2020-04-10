<?php

Class Controller_Cms_CampaignAutumn Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		
		
		$nameFilter = (string)($this->registry->router->getArg('name'));
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
            if($_SESSION['campaignautumnBulkToken']==$_POST['ftoken'])
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
                            $myCampaignAutumn = new Core_CampaignAutumn($id);
                            
                            if($myCampaignAutumn->id > 0)
                            {
                                //tien hanh xoa
                                if($myCampaignAutumn->delete())
                                {
                                    $deletedItems[] = $myCampaignAutumn->id;
                                    $this->registry->me->writelog('campaignautumn_delete', $myCampaignAutumn->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myCampaignAutumn->id;
                            }
                            else
                                $cannotDeletedItems[] = $myCampaignAutumn->id;
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
		
		$_SESSION['campaignautumnBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_CampaignAutumn::getCampaignAutumns($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$campaignautumns = Core_CampaignAutumn::getCampaignAutumns($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'campaignautumns' 	=> $campaignautumns,
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
	
		
	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['campaignautumnAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myCampaignAutumn = new Core_CampaignAutumn();

					
					$myCampaignAutumn->name = $formData['fname'];
					$myCampaignAutumn->listproduct = $formData['flistproduct'];
					if(!empty($formData['fstarttime'])) $myCampaignAutumn->starttime = Helper::strtotimedmy($formData['fstarttime']);
                    	else $myCampaignAutumn->starttime = 0;
					$myCampaignAutumn->status = $formData['fstatus'];
					
                    if($myCampaignAutumn->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('campaignautumn_add', $myCampaignAutumn->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['campaignautumnAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myCampaignAutumn = new Core_CampaignAutumn($id);
		$product_id = $myCampaignAutumn->listproduct;
		$redirectUrl = $this->getRedirectUrl();
		if($myCampaignAutumn->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myCampaignAutumn->id;
			$formData['fname'] = $myCampaignAutumn->name;
			$formData['flistproduct'] = $myCampaignAutumn->listproduct;
			$formData['fstarttime'] = $myCampaignAutumn->starttime;
			$formData['fstatus'] = $myCampaignAutumn->status;
			$formData['fdatecreated'] = $myCampaignAutumn->datecreated;
			$formData['fdatemodified'] = $myCampaignAutumn->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['campaignautumnEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myCampaignAutumn->name = $formData['fname'];
						$myCampaignAutumn->listproduct = $formData['flistproduct'];
						if(!empty($formData['fstarttime'])) $myCampaignAutumn->starttime = Helper::strtotimedmy($formData['fstarttime']);
               			else $myCampaignAutumn->starttime = 0;
						$myCampaignAutumn->status = $formData['fstatus'];
                        
                        if($myCampaignAutumn->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('campaignautumn_edit', $myCampaignAutumn->id, array());
                           	$cachelantern = new Cacher('site_campaign_trungthu_' . $product_id);
	       					$cachelantern->clear();
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['campaignautumnEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													
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
		$myCampaignAutumn = new Core_CampaignAutumn($id);
		if($myCampaignAutumn->id > 0)
		{
			//tien hanh xoa
			if($myCampaignAutumn->delete())
			{
				$redirectMsg = str_replace('###id###', $myCampaignAutumn->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('campaignautumn_delete', $myCampaignAutumn->id, array());
				$cachelantern = new Cacher('site_campaign_trungthu_' . $myCampaignAutumn->listproduct);
	       		$cachelantern->clear();  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myCampaignAutumn->id, $this->registry->lang['controller']['errDelete']);
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
	
	public function listUserbylanternAction(){
		
		$id = (int)$this->registry->router->getArg('id');
		$listfulluser = array();
		$listuser = Core_CampaignUser::getlistuserbylantern($id);
		foreach ($listuser as $user) {
			$subuser = new Core_Subscriber($user->sid);
			$subuser->position = $user->position;
			$listfulluser[] = $subuser;
		}
		
		//var_dump($listfulluser);die;
		$this->registry->smarty->assign(array(
                                                      'listfulluser' => $listfulluser,
		));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer . 'listuser.tpl');
		echo $contents;
	}
}

?>