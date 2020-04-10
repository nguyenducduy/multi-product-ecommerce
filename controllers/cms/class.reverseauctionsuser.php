<?php

Class Controller_Cms_ReverseAuctionsUser Extends Controller_Cms_Base 
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
		
		$raidFilter = (int)($this->registry->router->getArg('raid'));
		$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$priceFilter = (float)($this->registry->router->getArg('price'));
		$phoneFilter = (string)($this->registry->router->getArg('phone'));
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
            if($_SESSION['reverseauctionsuserBulkToken']==$_POST['ftoken'])
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
                            $myReverseAuctionsUser = new Core_ReverseAuctionsUser($id);
                            
                            if($myReverseAuctionsUser->id > 0)
                            {
                                //tien hanh xoa
                                if($myReverseAuctionsUser->delete())
                                {
                                    $deletedItems[] = $myReverseAuctionsUser->id;
                                    $this->registry->me->writelog('reverseauctionsuser_delete', $myReverseAuctionsUser->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myReverseAuctionsUser->id;
                            }
                            else
                                $cannotDeletedItems[] = $myReverseAuctionsUser->id;
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
		
		$_SESSION['reverseauctionsuserBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($raidFilter > 0)
		{
			$paginateUrl .= 'raid/'.$raidFilter . '/';
			$formData['fraid'] = $raidFilter;
			$formData['search'] = 'raid';
		}

		if($fullnameFilter != "")
		{
			$paginateUrl .= 'fullname/'.$fullnameFilter . '/';
			$formData['ffullname'] = $fullnameFilter;
			$formData['search'] = 'fullname';
		}

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
		}

		if($priceFilter > 0)
		{
			$paginateUrl .= 'price/'.$priceFilter . '/';
			$formData['fprice'] = $priceFilter;
			$formData['search'] = 'price';
		}

		if($phoneFilter != "")
		{
			$paginateUrl .= 'phone/'.$phoneFilter . '/';
			$formData['fphone'] = $phoneFilter;
			$formData['search'] = 'phone';
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

			if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}
			
		//tim tong so
		$total = Core_ReverseAuctionsUser::getReverseAuctionsUsers($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$reverseauctionsusers = Core_ReverseAuctionsUser::getReverseAuctionsUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
			
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'reverseauctionsusers' 	=> $reverseauctionsusers,
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
		
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		
		//$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												//'contents' 	=> $contents));
		//$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
		
	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['reverseauctionsuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myReverseAuctionsUser = new Core_ReverseAuctionsUser();

					
					$myReverseAuctionsUser->fullname = $formData['ffullname'];
					$myReverseAuctionsUser->email = $formData['femail'];
					$myReverseAuctionsUser->price = $formData['fprice'];
					$myReverseAuctionsUser->phone = $formData['fphone'];
					
                    if($myReverseAuctionsUser->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('reverseauctionsuser_add', $myReverseAuctionsUser->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['reverseauctionsuserAddToken']=Helper::getSecurityToken();//Tao token moi
		
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
		$myReverseAuctionsUser = new Core_ReverseAuctionsUser($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myReverseAuctionsUser->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fraid'] = $myReverseAuctionsUser->raid;
			$formData['fid'] = $myReverseAuctionsUser->id;
			$formData['ffullname'] = $myReverseAuctionsUser->fullname;
			$formData['femail'] = $myReverseAuctionsUser->email;
			$formData['fprice'] = $myReverseAuctionsUser->price;
			$formData['fphone'] = $myReverseAuctionsUser->phone;
			$formData['fdatecreated'] = $myReverseAuctionsUser->datecreated;
			$formData['fdatemodified'] = $myReverseAuctionsUser->datemodified;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['reverseauctionsuserEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myReverseAuctionsUser->fullname = $formData['ffullname'];
						$myReverseAuctionsUser->email = $formData['femail'];
						$myReverseAuctionsUser->price = $formData['fprice'];
						$myReverseAuctionsUser->phone = $formData['fphone'];
                        
                        if($myReverseAuctionsUser->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('reverseauctionsuser_edit', $myReverseAuctionsUser->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['reverseauctionsuserEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		$myReverseAuctionsUser = new Core_ReverseAuctionsUser($id);
		if($myReverseAuctionsUser->id > 0)
		{
			//tien hanh xoa
			if($myReverseAuctionsUser->delete())
			{
				$redirectMsg = str_replace('###id###', $myReverseAuctionsUser->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('reverseauctionsuser_delete', $myReverseAuctionsUser->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myReverseAuctionsUser->id, $this->registry->lang['controller']['errDelete']);
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
		
		

		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}

		if($formData['femail'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEmailRequired'];
			$pass = false;
		}

		if($formData['fprice'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}
		
		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}

		if($formData['femail'] == '')
		{
			$error[] = $this->registry->lang['controller']['errEmailRequired'];
			$pass = false;
		}

		if($formData['fprice'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPhoneRequired'];
			$pass = false;
		}
				
		return $pass;
	}
	public function exportuserAction()
	{
		set_time_limit(0);
		$raidFilter = (int)($this->registry->router->getArg('raid'));
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		$formData['fraid'] = $raidFilter;
		if($formData['fraid'] > 0) {
			$myReverseAuctionsUser = Core_ReverseAuctionsUser::getReverseAuctionsUsers($formData, 'id', 'ASC');
			$data = 'Mã số#Chương trình#Họ tên#Email#Số điện thoại#Địa chỉ#Ngày tham gia' . "\n";
	                
			foreach ($myReverseAuctionsUser as $auctionsuser) {
				$data .= $auctionsuser->id . '#' . $auctionsuser->raid . '#' 
					. $auctionsuser->fullname . '#' . $auctionsuser->email . '#' . $auctionsuser->phone 
					. '#' . $auctionsuser->price . '#' . date('Y-m-d-H:i:s', $auctionsuser->datecreated) . "\n";
			}
			
			$myHttpDownload = new HttpDownload();
			$myHttpDownload->set_bydata($data); //Download from php data
			$myHttpDownload->use_resume = true; //Enable Resume Mode
			$myHttpDownload->filename = 'auctionsuser-'.date('Y-m-d-H-i-s') . '.csv';
			$myHttpDownload->download(); //Download File
			exit();
		}
		header('Location:'.$this->registry->conf['rooturl'].'reverseauctionsuser/index/raid/'.$raidFilter);
	}
}

?>