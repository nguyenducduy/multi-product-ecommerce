<?php

Class Controller_Cms_ProductGuessUser Extends Controller_Cms_Base 
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
            if($_SESSION['productguessuserBulkToken']==$_POST['ftoken'])
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
                            $myProductGuessUser = new Core_ProductGuessUser($id);
                            
                            if($myProductGuessUser->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductGuessUser->delete())
                                {
                                    $deletedItems[] = $myProductGuessUser->id;
                                    $this->registry->me->writelog('productguessuser_delete', $myProductGuessUser->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myProductGuessUser->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductGuessUser->id;
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
		
		$_SESSION['productguessuserBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}
		
				
		//tim tong so
		$total = Core_ProductGuessUser::getProductGuessUsers($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$productguessusers = Core_ProductGuessUser::getProductGuessUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'productguessusers' 	=> $productguessusers,
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
            if($_SESSION['productguessuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myProductGuessUser = new Core_ProductGuessUser();

					
					$myProductGuessUser->pid = $formData['fpid'];
					$myProductGuessUser->pgid = $formData['fpgid'];
					$myProductGuessUser->fullname = $formData['ffullname'];
					$myProductGuessUser->email = $formData['femail'];
					$myProductGuessUser->phone = $formData['fphone'];
					$myProductGuessUser->address = $formData['faddress'];
					$myProductGuessUser->answer = $formData['fanswer'];
					$myProductGuessUser->newsletterproduct = $formData['fnewsletterproduct'];
					$myProductGuessUser->newsletter = $formData['fnewsletter'];
					
                    if($myProductGuessUser->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productguessuser_add', $myProductGuessUser->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['productguessuserAddToken'] = Helper::getSecurityToken();//Tao token moi
		
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
		$myProductGuessUser = new Core_ProductGuessUser($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myProductGuessUser->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fpid'] = $myProductGuessUser->pid;
			$formData['fpgid'] = $myProductGuessUser->pgid;
			$formData['fid'] = $myProductGuessUser->id;
			$formData['ffullname'] = $myProductGuessUser->fullname;
			$formData['femail'] = $myProductGuessUser->email;
			$formData['fphone'] = $myProductGuessUser->phone;
			$formData['faddress'] = $myProductGuessUser->address;
			$formData['fanswer'] = $myProductGuessUser->answer;
			$formData['fnewsletterproduct'] = $myProductGuessUser->newsletterproduct;
			$formData['fnewsletter'] = $myProductGuessUser->newsletter;
			$formData['fdatecreated'] = $myProductGuessUser->datecreated;
			$formData['fdatemodified'] = $myProductGuessUser->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productguessuserEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myProductGuessUser->pid = $formData['fpid'];
						$myProductGuessUser->pgid = $formData['fpgid'];
						$myProductGuessUser->fullname = $formData['ffullname'];
						$myProductGuessUser->email = $formData['femail'];
						$myProductGuessUser->phone = $formData['fphone'];
						$myProductGuessUser->address = $formData['faddress'];
						$myProductGuessUser->answer = $formData['fanswer'];
						$myProductGuessUser->newsletterproduct = $formData['fnewsletterproduct'];
						$myProductGuessUser->newsletter = $formData['fnewsletter'];
                        
                        if($myProductGuessUser->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productguessuser_edit', $myProductGuessUser->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['productguessuserEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myProductGuessUser = new Core_ProductGuessUser($id);
		if($myProductGuessUser->id > 0)
		{
			//tien hanh xoa
			if($myProductGuessUser->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductGuessUser->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('productguessuser_delete', $myProductGuessUser->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductGuessUser->id, $this->registry->lang['controller']['errDelete']);
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
	
	
	public function exportuserguessAction()
	{
		set_time_limit(0);
		
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['exportguessuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                 $config = array();
                 $config['fpgid'] = $formData['fpgid'];
                 $config['ftoday'] = 1;
                 $config['fstarttime'] = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
                 $config['fendtime'] = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
                 
              
	            $myProductGuessUser = Core_ProductGuessUser::getProductGuessUsers($config, 'id', 'ASC');
	
				$data = 'Mã số#Chương trình#Họ tên#Email#Số điện thoại#Địa chỉ#Ngày tham gia' . "\n";
	                    
				foreach ($myProductGuessUser as $productguessuser) {
					$data .= $productguessuser->id . '#' . $productguessuser->pgid . '#' 
						. $productguessuser->fullname . '#' . $productguessuser->email . '#' . $productguessuser->phone 
						. '#' . $productguessuser->address . '#' . date('Y-m-d-H:i:s', $productguessuser->datecreated) . "\n";
				}
				
				$myHttpDownload = new HttpDownload();
				$myHttpDownload->set_bydata($data); //Download from php data
				$myHttpDownload->use_resume = true; //Enable Resume Mode
				$myHttpDownload->filename = 'Listuserguess-'.date('Y-m-d-H-i-s') . '.csv';
				$myHttpDownload->download(); //Download File
				exit();
            }
            
		}
		
		$_SESSION['exportguessuserAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'exportuserguess.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
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
