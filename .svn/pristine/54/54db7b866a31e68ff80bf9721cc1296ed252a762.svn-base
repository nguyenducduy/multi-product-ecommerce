<?php

Class Controller_Erp_HrmDepartment Extends Controller_Erp_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		
		$departmentListHtml = Core_Department::getFullDepartmentsList();
		
		$this->registry->smarty->assign(array(	'departmentListHtml' => $departmentListHtml
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	} 
	
	
	function addAction()
	{

		die('This featured had been disabled because of new syncing department feature.');

		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();
		
		
		
		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['hrmdepartmentAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);
                
                                
                if($this->addActionValidator($formData, $error))
                {
                    $myDepartment = new Core_Department();
					$myDepartment->groupid = GROUPID_DEPARTMENT;
					$myDepartment->fullname = $formData['fname'];
					$myDepartment->screenname = Helper::codau2khongdau($formData['fname'], true, true);
					$myDepartment->parentid = $formData['fparentid'];
					
                    if($myDepartment->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('department_add', $myDepartment->id, array());
                        $formData = array('fparentid' => $formData['fparentid']);      
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];            
                    }
                }
            }
            
		}
		
		$departmentList = Core_Department::getFullDepartments();
		
		$_SESSION['hrmdepartmentAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'departmentList' => $departmentList,
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
		die('This featured had been disabled because of new syncing department feature.');

		$id = (int)$this->registry->router->getArg('id');
		$myDepartment = new Core_Department($id);
		
		$redirectUrl = $this->getRedirectUrl();
		if($myDepartment->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fbulkid'] = array();
			
			
			$formData['fid'] = $myDepartment->id;
			$formData['fname'] = $myDepartment->fullname;
			$formData['fparentid'] = $myDepartment->parentid;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['hrmdepartmentEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    					
                    if($this->editActionValidator($formData, $error))
                    {
						
						$myDepartment->fullname = $formData['fname'];
						$myDepartment->screename = Helper::codau2khongdau($formData['fname'], true, true);
						$myDepartment->parentid = $formData['fparentid'];
                        
                        if($myDepartment->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('department_edit', $myDepartment->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];            
                        }
                    }
                }
                
				    
			}
			
			
			$_SESSION['hrmdepartmentEditToken'] = Helper::getSecurityToken();//Tao token moi
			
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
		die('This featured had been disabled because of new syncing department feature.');

		$id = (int)$this->registry->router->getArg('id');
		$myDepartment = new Core_Department($id);
		if($myDepartment->id > 0)
		{
			//get employee in this department
			$countEmployee = 0;
			//TODO
			
			if($countEmployee == 0)
			{
				$redirectMsg = 'You must be remove all employee in this Department before remove this department.';
			}
			else
			{
				//tien hanh xoa
				if($myDepartment->delete())
				{
					$redirectMsg = str_replace('###id###', $myDepartment->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('hrmdepartment_delete', $myDepartment->id, array());  	
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myDepartment->id, $this->registry->lang['controller']['errDelete']);
				}
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
	
	
	public function employeeaddAction()
	{
		die('This featured had been disabled because of new syncing department feature.');

		$departmentid = (int)$this->registry->router->getArg('departmentid');
		$myDepartment = new Core_Department($departmentid);
		$validDepartment = false;
		if($myDepartment->id == 0 || !$myDepartment->checkGroupname('department'))
		{
			//invalid department
			$error[] = $this->registry->lang['controller']['errNotFound'];
		}
		else
		{
			//valid department
			$validDepartment = true;
			
			$departmentList = Core_Department::getFullDepartments();
			$jobtitleList = Core_HrmTitle::getHrmTitles(array(), 'priority', 'ASC');
			
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fdepartmentid'] = $myDepartment->id;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['hrmdepartmentemployeeAddToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    
					
					
                    if($this->employeeaddActionValidator($formData, $error))
                    {
						$processedUserIdList = array();
						
						for($i = 0; $i < count($formData['fuidstart']);$i++)
						{
							$uidstart = (int)$formData['fuidstart'][$i];
							$myUser = new Core_User($uidstart);
							
							if($myUser->id > 0 && $myUser->isEmployee() && !in_array($myUser->id, $processedUserIdList))
							{
								$processedUserIdList[] = $myUser->id;
								
								$myUserEdge = new Core_UserEdge();
								$myUserEdge->uidstart = $uidstart;
								$myUserEdge->uidend = $formData['fdepartmentid'];
								$myUserEdge->type = Core_UserEdge::TYPE_EMPLOY;
								$myUserEdge->point = $formData['fjobtitle'];

								if($myUserEdge->addData())
								{
									$successRecord[] = $myUser->fullname . ' (A'.$myUser->id.')';
								}
								else
								{
									$errorRecord[] = $myUser->fullname . ' (A'.$myUser->id.')';
								}
							}
						}
						
						
						if(count($successRecord) > 0)
						{
							$success[] = str_replace('###VALUE###', implode(', ', $successRecord),$this->registry->lang['controller']['succEmployeeAdd']);
						}
						
						if(count($errorRecord) > 0)
						{
							$error[] = str_replace('###VALUE###', implode(', ', $errorRecord),$this->registry->lang['controller']['errEmployeeAdd']);
						}
						
						$formData['fuidstart'] = array();
                    }//end employeeaddActionValidator

                }
			}
			//end submit
			
			//init for autocomplete selected user
			$selectedUsers = array();
			if(count($formData['fuidstart']) > 0)
			{
				foreach($formData['fuidstart'] as $uidstart)
				{
					$selectedUsers[] = new Core_User($uidstart, true);
				}
			}
			
		}
		
		
		$_SESSION['hrmdepartmentAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'validDepartment' => $validDepartment,
												'departmentList' => $departmentList,
												'jobtitleList' => $jobtitleList,
												'selectedUsers' => $selectedUsers,
												'success' => $success,
												'error' => $error,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'employeeadd.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}
	
	
	public function employeelistAction()
	{
		$departmentid = (int)$this->registry->router->getArg('departmentid');
		$myDepartment = new Core_Department($departmentid);
		$validDepartment = false;
		if($myDepartment->id == 0 || !$myDepartment->checkGroupname('department'))
		{
			//invalid department
			$error[] = $this->registry->lang['controller']['errNotFound'];
		}
		else
		{
			//valid department
			$validDepartment = true;
			
			$jobtitleList = Core_HrmTitle::getHrmTitles(array(), 'priority', 'ASC');
			$indexJobtitleList = array();
			for($i = 0; $i < count($jobtitleList); $i++)
			{
				$indexJobtitleList[$jobtitleList[$i]->id] = $jobtitleList[$i];
			}
			
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array('fbulkid' => array());
			
			$useredgeList = Core_UserEdge::getUserEdges(array('fuidend' => $myDepartment->id, 'ftype' => Core_UserEdge::TYPE_EMPLOY), 'point', 'ASC', '');
			
			for($i = 0; $i < count($useredgeList); $i++)
			{
				$useredgeList[$i]->actor = new Core_User($useredgeList[$i]->uidstart);
				$useredgeList[$i]->jobtitle = $indexJobtitleList[$useredgeList[$i]->point];
			}
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['hrmdepartmentemployeeAddToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
                    
					
					
                    if($this->employeeaddActionValidator($formData, $error))
                    {
						$processedUserIdList = array();
						
						for($i = 0; $i < count($formData['fuidstart']);$i++)
						{
							$uidstart = (int)$formData['fuidstart'][$i];
							$myUser = new Core_User($uidstart);
							
							if($myUser->id > 0 && $myUser->isEmployee() && !in_array($myUser->id, $processedUserIdList))
							{
								$processedUserIdList[] = $myUser->id;
								
								$myUserEdge = new Core_UserEdge();
								$myUserEdge->uidstart = $uidstart;
								$myUserEdge->uidend = $formData['fdepartmentid'];
								$myUserEdge->type = Core_UserEdge::TYPE_EMPLOY;
								$myUserEdge->point = $formData['fjobtitle'];

								if($myUserEdge->addData())
								{
									$successRecord[] = $myUser->fullname . ' (A'.$myUser->id.')';
								}
								else
								{
									$errorRecord[] = $myUser->fullname . ' (A'.$myUser->id.')';
								}
							}
						}
						
						
						if(count($successRecord) > 0)
						{
							$success[] = str_replace('###VALUE###', implode(', ', $successRecord),$this->registry->lang['controller']['succEmployeeAdd']);
						}
						
						if(count($errorRecord) > 0)
						{
							$error[] = str_replace('###VALUE###', implode(', ', $errorRecord),$this->registry->lang['controller']['errEmployeeAdd']);
						}
						
						$formData['fuidstart'] = array();
                    }//end employeeaddActionValidator

                }
			}
			//end submit
			
		}
		
		
		$_SESSION['securityToken'] = Helper::getSecurityToken();
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'jobtitleList' => $jobtitleList,
												'useredgeList' => $useredgeList,
												'myDepartment' => $myDepartment,
												'success' => $success,
												'error' => $error,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'employeelist.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
		
	}
	
	
	
	public function employeeeditAction()
	{		
		die('This featured had been disabled because of new syncing department feature.');

		$useredgeid = (int)$this->registry->router->getArg('id');
		$myUserEdge = new Core_UserEdge($useredgeid);

		if($myUserEdge->id == 0)
		{
			$this->notfound();
		}
		else
		{
			$departmentList = Core_Department::getFullDepartments();
			$jobtitleList = Core_HrmTitle::getHrmTitles(array(), 'priority', 'ASC');
			
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			
			$formData['fdepartmentid'] = $myUserEdge->uidend;
			$formData['fjobtitle'] = $myUserEdge->point;
			
			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['hrmdepartmentemployeeEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);
					
                    if($this->employeeeditActionValidator($formData, $error))
                    {
	
						$myUserEdge->uidend = $formData['fdepartmentid'];
						$myUserEdge->point = $formData['fjobtitle'];
						
						if($myUserEdge->updateData())
						{
							$success[] = $this->registry->lang['controller']['succEmployeeUpdate'];
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errEmployeeUpdate'];
						}
                    }

                }
			}
			//end submit
			
			$myUser = new Core_User($myUserEdge->uidstart, true);
		}
		
		
		$_SESSION['hrmdepartmentEditToken']=Helper::getSecurityToken();//Tao token moi
		$_SESSION['securityToken'] = Helper::getSecurityToken();//for delete
		
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'departmentList' => $departmentList,
												'jobtitleList' => $jobtitleList,
												'myUser' => $myUser,
												'myUserEdge' => $myUserEdge,
												'success' => $success,
												'error' => $error,
												
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'employeeedit.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
		
	}
	
	public function employeeremoveAction()
	{
		die('This featured had been disabled because of new syncing department feature.');

		$useredgeid = (int)$this->registry->router->getArg('id');
		$myUserEdge = new Core_UserEdge($useredgeid);

		$redirectUrl = $this->registry['conf']['rooturl_erp'] . 'hrmdepartment/employeeadd/departmentid/' . $myUserEdge->uidend;
		
		if($myUserEdge->id == 0)
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		elseif($_SESSION['securityToken'] != $_GET['ftoken'])
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}
		else
		{
			if($myUserEdge->delete())
			{
				$redirectMsg = $this->registry->lang['controller']['succEmployeeRemove'];
			}
			else
			{
				$redirectMsg = $this->registry->lang['controller']['errEmployeeRemove'];
			}
		}
		
		$this->registry->smarty->assign(array('redirect' => $redirectUrl,
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
	
	
	
	private function employeeaddActionValidator($formData, &$error)
	{
		$pass = true;
		
		//check valid department
		$myDepartment = new Core_Department($formData['fdepartmentid']);
		if($myDepartment->id == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errDepartmentInvalid'];
		}
		
		//check valid jobtitle
		$myJobTitle = new Core_HrmTitle($formData['fjobtitle']);
		if($myJobTitle->id == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errJobtitleInvalid'];
		}
		
		if(count($formData['fuidstart']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errEmployeeIsRequired'];
		}
		else
		{
			for($i = 0; $i < count($formData['fuidstart']); $i++)
			{
				$myUser = new Core_User($formData['fuidstart'][$i]);
				
				if($myUser->id > 0)
				{
					//kiem tra xem user nay da tham gia vao phong ban nao chua
					$useredgeList = Core_UserEdge::getUserEdges(array('fuidstart' => $myUser->id, 'ftype' => Core_UserEdge::TYPE_EMPLOY), '', '');
					if(count($useredgeList) > 0)
					{
						$existedDepartment = new Core_Department($useredgeList[0]->uidend);
						$pass = false;
						$error[] = str_replace(array('###VALUE###', '###VALUE2###', '###VALUE3###'), 
							array($myUser->fullname, $existedDepartment->fullname, $this->registry->conf['rooturl_erp'] . 'hrmdepartment/employeeedit/id/' . $useredgeList[0]->id), 
							$this->registry->lang['controller']['errExistedDepartmentEmployee']);
					}
				}
				
			}
		}
		
		
		return $pass;
	}
	
	
	
	
	private function employeeeditActionValidator($formData, &$error)
	{
		$pass = true;
		
		//check valid department
		$myDepartment = new Core_Department($formData['fdepartmentid']);
		if($myDepartment->id == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errDepartmentInvalid'];
		}
		
		//check valid jobtitle
		$myJobTitle = new Core_HrmTitle($formData['fjobtitle']);
		if($myJobTitle->id == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errJobtitleInvalid'];
		}
		
		
		return $pass;
	}
	
	/**
	 * Import danh sach department lay duoc tu Suong de dua vao he thong account
	 */
	public function importDienmayDepartmentAction()
	{
		
		die('Disabed.');
		
		$sql = 'SELECT * FROM tgdd_department 
				ORDER BY DepartmentID ASC
				LIMIT 1000';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$row['DepartmentName'] = str_replace(' - ĐM', '', $row['DepartmentName']);
			
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user (u_id, u_screenname, u_fullname, u_groupid, u_parentid)
					VALUES(?, ?, ?, ?, ?)';
			$this->registry->db->query($sql, array(
				$row['DepartmentID'],
				Helper::codau2khongdau($row['DepartmentName'], true, true),
				$row['DepartmentName'],
				GROUPID_DEPARTMENT,
				$row['ParentID']
			));
			
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user_profile(u_id, up_datecreated)
					VALUES(?, ?)';
			$this->registry->db->query($sql, array(
				$row['DepartmentID'],
				time()
			));
			
		}
	}
	
	public function importDienmayEmployeeAction()
	{
		die('disabled');
		///////////////////////////
		//Clear all old useredge
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'user_edge
				WHERE ue_type = ' . Core_UserEdge::TYPE_EMPLOY;
		$this->registry->db->query($sql);
		
		///////////////////////////
		//Tien hanh import user va phong ban
		$sql = 'SELECT * FROM tgdd_dienmayemployee
				ORDER BY STT ASC';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$myUser = new Core_User();
			
			//get birthday
			$dateinfo = explode('/', $row['ngaysinh2']);
			
			//Get user
			$myUser = Core_User::getByOauthId(Core_User::OAUTH_PARTNER_NOIBOTHEGIOIDIDONG, $row['manhanvien']);
			if($myUser->id == 0)
			{
				//If user not found, insert new record for new employee
				$myUser->fullname = $row['ho'] . ' ' . $row['ten'];
				$myUser->groupid = GROUPID_EMPLOYEE;
				$myUser->gender = $row['magioitinh'];
				$myUser->email = strtolower($row['email']);
				$myUser->phone = '0' . $row['didong'];
				$myUser->birthday = $dateinfo[0] . '-' . $dateinfo[1] . '-' . $dateinfo[2];
				$myUser->oauthPartner = Core_User::OAUTH_PARTNER_NOIBOTHEGIOIDIDONG;
				$myUser->oauthUid = $row['manhanvien'];
				if($myUser->addData())
				{
					;
				}
				else
				{
					echo '<p>Can not Create User: ' . $row['manhanvien'] . ' - ' . $myUser->fullname . '</p>';
				}
			}
			else
			{
				//If user found, update data for this user
				$myUser->phone = '0' . $row['didong'];
				$myUser->birthday = $dateinfo[0] . '-' . $dateinfo[1] . '-' . $dateinfo[2];
				if($myUser->updateData(array('region' => $row['magioitinh'])))
				{
					;
				}
			}
			
			/////////////////////////////////
			//Update Department of this user
			if($myUser->id > 0)
			{
				$myUserEdge = new Core_UserEdge();
				$myUserEdge->uidstart = $myUser->id;
				$myUserEdge->uidend = $row['maphongban'];
				$myUserEdge->type = Core_UserEdge::TYPE_EMPLOY;
				$myUserEdge->point = $row['machucvu'];

				if($myUserEdge->addData())
				{
					echo '<p style="color:#00f">Add '.$myUser->fullname.' ('.$row['manhanvien'].') to department <b>'.$row['phongban'].'</b></p>';
				}
				else
				{
					echo '<p style="color:#f00">Error Add '.$myUser->fullname.' ('.$row['manhanvien'].') to department <b>'.$row['phongban'].'</b></p>';
				}
			}
		}
				
	}
}
