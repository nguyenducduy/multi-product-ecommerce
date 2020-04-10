<?php

Class Controller_Cms_GamefasteyeUser Extends Controller_Cms_Base 
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
		
		
		$usernameFilter = (string)($this->registry->router->getArg('username'));
		$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$oauthpartnerFilter = (int)($this->registry->router->getArg('oauthpartner'));
		$ipaddressFilter = (string)($this->registry->router->getArg('ipaddress'));
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
            if($_SESSION['gamefasteyeuserBulkToken']==$_POST['ftoken'])
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
                            $myGamefasteyeUser = new Core_GamefasteyeUser($id);
                            
                            if($myGamefasteyeUser->id > 0)
                            {
                                //tien hanh xoa
                                if($myGamefasteyeUser->delete())
                                {
                                    $deletedItems[] = $myGamefasteyeUser->id;
                                    $this->registry->me->writelog('gamefasteyeuser_delete', $myGamefasteyeUser->id, array());      
                                }
                                else
                                    $cannotDeletedItems[] = $myGamefasteyeUser->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGamefasteyeUser->id;
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
		
		$_SESSION['gamefasteyeuserBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form   		
		
		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';      
		
		

		if($usernameFilter != "")
		{
			$paginateUrl .= 'username/'.$usernameFilter . '/';
			$formData['fusername'] = $usernameFilter;
			$formData['search'] = 'username';
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

		if($oauthpartnerFilter > 0)
		{
			$paginateUrl .= 'oauthpartner/'.$oauthpartnerFilter . '/';
			$formData['foauthpartner'] = $oauthpartnerFilter;
			$formData['search'] = 'oauthpartner';
		}
		
		if($ipaddressFilter != '')
		{
			$paginateUrl .= 'ipaddress/'.$ipaddressFilter . '/';
			$formData['fipaddress'] = ip2long($ipaddressFilter);
			$formData['search'] = 'ipaddress';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
			
			$user = new Core_GamefasteyeUser($idFilter);
			$invitor_id = $user->shareid;
			if (!empty($invitor_id)) {
				$listuserinvitor = Core_GamefasteyeUser::getGamefasteyeUsers(array('farrinvitor' => $invitor_id), 'id', 'DESC');
			}else {
				$listuserinvitor = '';
			}
			
		
		}
		
				
		//tim tong so
		$total = Core_GamefasteyeUser::getGamefasteyeUsers($formData, $sortby, $sorttype, 0, true);    
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;
		
			
		//get latest account
		$gamefasteyeusers = Core_GamefasteyeUser::getGamefasteyeUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		
		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;
		
		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';
		
		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;
		
		$redirectUrl = base64_encode($redirectUrl);
		
				
		$this->registry->smarty->assign(array(	'gamefasteyeusers' 	=> $gamefasteyeusers,
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
												'listuserinvitor' => $listuserinvitor,
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
            if($_SESSION['gamefasteyeuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myGamefasteyeUser = new Core_GamefasteyeUser();

					
					$myGamefasteyeUser->gfeid = $formData['fgfeid'];
					$myGamefasteyeUser->username = $formData['fusername'];
					$myGamefasteyeUser->fullname = $formData['ffullname'];
					$myGamefasteyeUser->email = $formData['femail'];
					$myGamefasteyeUser->phone = $formData['fphone'];
					$myGamefasteyeUser->point = $formData['fpoint'];
					$myGamefasteyeUser->historypoint = $formData['fhistorypoint'];
					$myGamefasteyeUser->countplay = $formData['fcountplay'];
					$myGamefasteyeUser->countshare = $formData['fcountshare'];
					$myGamefasteyeUser->oauthpartner = $formData['foauthpartner'];
					$myGamefasteyeUser->status = $formData['fstatus'];
					
                    if($myGamefasteyeUser->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('gamefasteyeuser_add', $myGamefasteyeUser->id, array());
                        $formData = array();      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$_SESSION['gamefasteyeuserAddToken'] = Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusOptions' => Core_GamefasteyeUser::getStatusList(),
												
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
		$myGamefasteyeUser = new Core_GamefasteyeUser($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myGamefasteyeUser->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fgfeid'] = $myGamefasteyeUser->gfeid;
			$formData['fid'] = $myGamefasteyeUser->id;
			$formData['fusername'] = $myGamefasteyeUser->username;
			$formData['ffullname'] = $myGamefasteyeUser->fullname;
			$formData['femail'] = $myGamefasteyeUser->email;
			$formData['fphone'] = $myGamefasteyeUser->phone;
			$formData['fpoint'] = $myGamefasteyeUser->point;
			$formData['fshareid'] = $myGamefasteyeUser->shareid;
			$formData['fhistorypoint'] = $myGamefasteyeUser->historypoint;
			$formData['fcountplay'] = $myGamefasteyeUser->countplay;
			$formData['fcountshare'] = $myGamefasteyeUser->countshare;
			$formData['foauthpartner'] = $myGamefasteyeUser->oauthpartner;
			$formData['fstatus'] = $myGamefasteyeUser->status;
			$formData['fdatecreated'] = $myGamefasteyeUser->datecreated;
			$formData['fdatemodified'] = $myGamefasteyeUser->datemodified;
			$formData['fipaddress'] = $myGamefasteyeUser->ipaddress;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['gamefasteyeuserEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myGamefasteyeUser->gfeid = $formData['fgfeid'];
						$myGamefasteyeUser->username = $formData['fusername'];
						$myGamefasteyeUser->fullname = $formData['ffullname'];
						$myGamefasteyeUser->email = $formData['femail'];
						$myGamefasteyeUser->phone = $formData['fphone'];
						$myGamefasteyeUser->point = $formData['fpoint'];
						$myGamefasteyeUser->historypoint = $formData['fhistorypoint'];
						$myGamefasteyeUser->countplay = $formData['fcountplay'];
						$myGamefasteyeUser->countshare = $formData['fcountshare'];
						$myGamefasteyeUser->oauthpartner = $formData['foauthpartner'];
						$myGamefasteyeUser->status = $formData['fstatus'];
                        
                        if($myGamefasteyeUser->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('gamefasteyeuser_edit', $myGamefasteyeUser->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['gamefasteyeuserEditToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusOptions' => Core_GamefasteyeUser::getStatusList(),
													
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
		$myGamefasteyeUser = new Core_GamefasteyeUser($id);
		if($myGamefasteyeUser->id > 0)
		{
			//tien hanh xoa
			if($myGamefasteyeUser->delete())
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeUser->id, $this->registry->lang['controller']['succDelete']);
				
				$this->registry->me->writelog('gamefasteyeuser_delete', $myGamefasteyeUser->id, array());  	
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGamefasteyeUser->id, $this->registry->lang['controller']['errDelete']);
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
				
		return $pass;
	}
	
	public function exportuserAction()
	{
		set_time_limit(0);
		
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['exportuserAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                 
                 $starttime = Helper::strtotimedmy($formData['fstarttime'],$formData['fsttime']);
                 $endtime = Helper::strtotimedmy($formData['fexpiretime'],$formData['fextime']);
                 
                 $config = array();
                 $config['fgfeid'] = $formData['fgfeid'];
                 $config['ftoday'] = 1;
                 $config['fstarttime'] = $starttime;
                 $config['fendtime'] = $endtime;
                 
                 
            	// Get tong diem tat ca cau hoi
				$cachetotalpoint = new Cacher('FRONT_TOTAL_QUESTION');
				$totalpointquestion = $cachetotalpoint->get();
				if (empty($totalpointquestion)) {
					$totalpointquestion = Core_GamefasteyeQuestion::totalPointQuestion();
					$cachetotalpoint->set($totalpointquestion, 600);
				}
				
				if ($formData['ftype'] == 0) {
              
		            $listuser = Core_GamefasteyeUser::getGamefasteyeUsers(array('fstatus'=> Core_GamefasteyeUser::STATUS_ENABLE), '', '');
		
					$data = 'Chương trình#Họ tên#Email#Điểm#Lượt chia sẻ#Lượt chơi cao điểm#Ngày tham gia' . "\n";
		                    
					foreach ($listuser as $user) {
	
							$history = Core_GamefasteyeHistory::getGamefasteyeHistorys(array('fguid'=> $user->id, 'ftoday'=>1, 'fstarttime'=> $starttime, 'fendtime'=>$endtime), 'point', 'DESC', 1);
							
							$share = Core_GamefasteyeShare::getGamefasteyeShares(array('fguid'=> $user->id, 'ftoday'=>1, 'fstarttime'=> $starttime, 'fendtime'=>$endtime), 'countshare', 'DESC', 1);
	
							//var_dump($share);die;
							if ($share[0]->countshare > 0 && $history[0]->point > 0) {
								$data .= $user->gfeid . '#' . $user->fullname . '#' . $user->email . '#' . $history[0]->point . '#' . $share[0]->countshare . '#' .  date('Y-m-d H:i:s', $history[0]->datecreated) . '#' . date('Y-m-d H:i:s', $user->datecreated) . "\n";
							}
					}
					
					
//				$listuser = Core_GamefasteyeUser::getGamefasteyeUsers(array('fstatus'=> Core_GamefasteyeUser::STATUS_ENABLE), '', '');
//		
//					$data = 'Chương trình#Họ tên#Email#Lượt chia sẻ#Ngày tham gia' . "\n";
//		                    
//					foreach ($listuser as $user) {
//	
//
//							$sql = 'SELECT SUM(gs.gs_countshare) FROM ' . TABLE_PREFIX . 'gamefasteye_share gs';
//							$sql .= ' WHERE gs.gu_id = ' . $user->id;
//							
//							$totalshare = $db->query($sql)->fetchColumn(0);
//
//							//var_dump($share);die;
//							if ($totalshare > 0) {
//								$data .= $user->gfeid . '#' . $user->fullname . '#' . $user->email . '#' . $totalshare . '#' . date('Y-m-d H:i:s', $user->datecreated) . "\n";
//							}
//					}
					
				}else {
					
				
		            $listuser = Core_GamefasteyeUser::getGamefasteyeUsers(array(), '', '');
		
					$data = 'Chương trình#Họ tên#Email#Ngày tham gia' . "\n";
		                    
					foreach ($listuser as $user) {

						$data .= $user->gfeid . '#' . $user->fullname . '#' . $user->email . '#' . date('Y-m-d H:i:s', $user->datecreated) . "\n";
					}
				
				}
				
				$myHttpDownload = new HttpDownload();
				$myHttpDownload->set_bydata($data); //Download from php data
				$myHttpDownload->use_resume = true; //Enable Resume Mode
				$myHttpDownload->filename = 'Listuser-'.date('Y-m-d-H-i-s') . '.csv';
				$myHttpDownload->download(); //Download File
				exit();
            }
            
		}
		
		$_SESSION['exportuserAddToken'] = Helper::getSecurityToken();//Tao token moi
		
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
	
	
	public function resetgameAction(){
	
		$alluser = Core_GamefasteyeUser::getGamefasteyeUsers(array(), '', '');
		foreach ($alluser as $user) {
			$user->countplay = 2;
			$user->point = 0;
			$user->countshare = 0;
			$user->updateData();
		}
		echo 'xong';die;
	}
	
}
