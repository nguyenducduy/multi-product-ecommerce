<?php
class Controller_Admin_Permission extends Controller_Admin_Base
{
	public function indexAction()
	{
		$delegateList = array();
		$promotionList = array();
		$orderList = array();
		$viewpromotion = array();
		$vieworder = array();

		//get all user have delegate
		$roleuserList = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_DELEGATE) , 'id' , 'ASC');

		if(count($roleuserList) > 0)
		{
			foreach($roleuserList as $roleuser)
			{
				$userinfo = new Core_User($roleuser->uid);
				$department = $userinfo->getBelongDepartments();

				$startdepartment = end($department);

				$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY,'fuidstart' => $userinfo->id) , '' , '');

				if(count($startuseredges) > 0)
					$startuseredge = $startuseredges[0];

				$startpriority = new Core_HrmTitle($startuseredge->point);

				$delegateList[] = array('id' => $userinfo->id,
										'name' => $userinfo->fullname,
										'department' => $startdepartment->fullname,
										'position' => $startpriority->name,
										);
			}
		}


		//get all user have promotion
		$roleuserList = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_PRODUCTPROMOTION) , 'id' , 'ASC');

		if(count($roleuserList) > 0)
		{
			foreach($roleuserList as $roleuser)
			{
				$userinfo = new Core_User($roleuser->uid);
				$department = $userinfo->getBelongDepartments();

				$startdepartment = end($department);

				$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $userinfo->id) , '' , '');

				if(count($startuseredges) > 0)
					$startuseredge = $startuseredges[0];

				$startpriority = new Core_HrmTitle($startuseredge->point);

				$promotionList[] = array('id' => $userinfo->id,
										'name' => $userinfo->fullname,
										'department' => $startdepartment->fullname,
										'position' => $startpriority->name,
										);
			}
		}


		//get all user can view order
		$roleuserList = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_ORDER) , 'id' , 'ASC');

		if(count($roleuserList) > 0)
		{
			foreach($roleuserList as $roleuser)
			{
				$userinfo = new Core_User($roleuser->uid);
				$department = $userinfo->getBelongDepartments();

				$startdepartment = end($department);

				$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $userinfo->id) , '' , '');

				if(count($startuseredges) > 0)
					$startuseredge = $startuseredges[0];

				$startpriority = new Core_HrmTitle($startuseredge->point);

				$orderList[] = array('id' => $userinfo->id,
										'name' => $userinfo->fullname,
										'department' => $startdepartment->fullname,
										'position' => $startpriority->name,
										);
			}
		}

		//get all user can view promotion of product
		$roleuserList = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_VIEWPROMOTION) , 'id' , 'ASC');

		if(count($roleuserList) > 0)
		{
			foreach($roleuserList as $roleuser)
			{
				$userinfo = new Core_User($roleuser->uid);
				$department = $userinfo->getBelongDepartments();

				$startdepartment = end($department);

				$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $userinfo->id) , '' , '');

				if(count($startuseredges) > 0)
					$startuseredge = $startuseredges[0];

				$startpriority = new Core_HrmTitle($startuseredge->point);

				$viewpromotion[] = array('id' => $userinfo->id,
										'name' => $userinfo->fullname,
										'department' => $startdepartment->fullname,
										'position' => $startpriority->name,
										);
			}
		}
		
		//get all user can view promotion of product
		$roleuserList = Core_RoleUser::getRoleUsers(array('ftype' => Core_RoleUser::TYPE_VIEWORDER) , 'id' , 'ASC');

		if(count($roleuserList) > 0)
		{
			foreach($roleuserList as $roleuser)
			{
				$userinfo = new Core_User($roleuser->uid);
				$department = $userinfo->getBelongDepartments();

				$startdepartment = end($department);

				$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $userinfo->id) , '' , '');

				if(count($startuseredges) > 0)
					$startuseredge = $startuseredges[0];

				$startpriority = new Core_HrmTitle($startuseredge->point);

				$vieworder[] = array('id' => $userinfo->id,
										'name' => $userinfo->fullname,
										'department' => $startdepartment->fullname,
										'position' => $startpriority->name,
										);
			}
		}
				


		$this->registry->smarty->assign(array('delegateList' => $delegateList,
												'promotionList' => $promotionList,
												'orderList' => $orderList,
												'viewpromotion' => $viewpromotion,
												'vieworders' => $vieworder,
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'permission.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function adduserAction()
	{
		$success = array();
		$error = array();
		$warning = array();
		$formData = array();

		$type = (string)$this->registry->router->getArg('type');

		$formData['ftype'] = Core_RoleUser::getRoleType($type);		
		
		if(isset($_POST['fsubmit']))
		{
			$formData = array_merge($formData, $_POST);
			if($this->adduserValidator($formData, $error))
			{
				$ok = false;
				foreach ($formData['fuid'] as $uid)
				{					
					$roleuser = new Core_RoleUser();
					$roleuser->uid = $uid;
					$roleuser->type = $formData['ftype'];
					$roleuser->value = 1;
					$roleuser->creatorid = $this->registry->me->id;
					$roleuser->status = Core_RoleUser::STATUS_ENABLE;

					if($roleuser->addData() > 0)
					{
						$ok = true;
						$this->registry->me->writelog('roleuser_add', $roleuser->id, array());
					}
				}

				if($ok)
	            {
                    $success[] = $this->registry->lang['controller']['succAddUser'];
                    $formData = array();
	            }
	            else
	            {
                    $error[] = $this->registry->lang['controller']['errAddUser'];
	            }
			}
		}

		$this->registry->smarty->assign(array( 'formData' => $formData,
												'success' => $success,
												'error' => $error,
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'adduser.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'adduser.tpl');
	}


	public function deleteroleuserajaxAction()
	{
		$uid = (int)$_POST['uid'];
		$type = (int)$_POST['type'];

		if($uid > 0 && $type > 0)
		{
			$roleuser = Core_RoleUser::getRoleUsers(array('fuid'=>$uid , 'ftype'=>$type) , 'id' , 'ASC');

			if(count($roleuser) > 0)
			{
				//tien hanh xoa role
				if($roleuser[0]->delete())
				{
					echo 'success';
				}
				else
				{
					echo 'error';
				}
			}
		}
	}

	private function adduserValidator($formData, &$error)
	{
		$pass = true;
		if(count($formData['fuid']) == 0)
		{
			$error = $this->registry->lang['controller']['errUserEmpty'];
			$pass = false;
		}
		else
		{
			foreach ($formData['fuid'] as $uid)
			{
				$checker = Core_RoleUser::getRoleUsers(array('ftype' => $formData['ftype'] , 'fuid' => $uid) , 'id' , 'ASC' , '' , true);

				if($checker > 0)
				{
					$error[] = str_replace('###ID###', $uid,$this->registry->lang['controller']['errUserExist']);
					$pass = false;
				}
			}
		}

		return $pass;
	}

	public function permissionfileAction()
	{
		$controllerPath = SITE_PATH. 'controllers';
		$constants = get_defined_constants(true);
		$groupId = array();
		$controllerGroups = array();
		$data = $formData = $success= $errors = array();
		$compareGroupId = array();
		global $groupPermisson;

		$status = (string)$this->registry->router->getArg('status');

		switch ($status) {
			case 'success':
				$success[] = 'Tạo file permission thành công';
				break;

		}

		foreach ($constants['user'] as $key=>$value)
		{
			if(preg_match('/GROUPID_[A-Z]+/', $key))
			{
				$groupId[] = $key;
			}
		}

		foreach ($groupId as $group)
		{
			$controllerGroups = $this->getListDir($controllerPath);
		}

		foreach ($controllerGroups as $controllerGroup)
		{
			$arr = $this->getListDir($controllerPath . '/' . $controllerGroup , true);

			if(count($arr) > 0)
			{
				$controllers = array();
				foreach($arr as $controller)
				{
					$part = explode('.', $controller);
					$class = $part[1];

					$methodList = array();
					$class_name = 'Controller_' . $controllerGroup . '_' . $class;
					$methods = get_class_methods($class_name);

					if(count($methods) > 0)
					{
						foreach($methods as $method)
						{
							if(preg_match('/[a-z]+Action/', $method))
				        	{
				        		$parts = explode('Action', $method);
				        		$methodList[$parts[0]] = 0;

				        	}
						}
					}
					$controllers[$class] = $methodList;
				}
				$controllerList[$controllerGroup] = $controllers;
			}
		}


		foreach ($groupId as $group)
		{
			$data[$group] = $controllerList;
		}

		//ksort($data);
		//sort data
		/*foreach ($data as $items)
		{
			ksort($items);
			foreach($items as $controller)
			{
				ksort($controller);
				foreach($controllers as $methods)
				{
					foreach($methods as $m)
					{
						ksort($m);
					}
				}
			}
		}*/

		//var_dump($data);die();
		//var_dump($methodList);

		$this->registry->smarty->assign(array('data' => $data,
												'methodList' =>$methodList,
												'formData' => $formData,
												'success' => $success,
												'errors' => $errors,
												));
		$contents = $this->writeContent($data, $formData);


        $this->registry->smarty->assign(array(
                                                'pageTitle'    => $this->registry->lang['controller']['title'],
                                                'contents'             => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function createpermissionfileAction()
	{
		$controllerPath = SITE_PATH. 'controllers';
		$constants = get_defined_constants(true);
		$groupId = array();
		$controllerGroups = array();
		$data = $formData = $success= $errors = array();
		$compareGroupId = array();
		global $groupPermisson;

		foreach ($constants['user'] as $key=>$value)
		{
			if(preg_match('/GROUPID_[A-Z]+/', $key))
			{
				$groupId[] = $key;
			}
		}

		foreach ($groupId as $group)
		{
			$controllerGroups = $this->getListDir($controllerPath);
		}

		foreach ($controllerGroups as $controllerGroup)
		{
			$arr = $this->getListDir($controllerPath . '/' . $controllerGroup , true);

			if(count($arr) > 0)
			{
				$controllers = array();
				foreach($arr as $controller)
				{
					$part = explode('.', $controller);
					$class = $part[1];

					$methodList = array();
					$class_name = 'Controller_' . $controllerGroup . '_' . $class;
					$methods = get_class_methods($class_name);

					if(count($methods) > 0)
					{
						foreach($methods as $method)
						{
							if(preg_match('/[a-z]+Action/', $method))
				        	{
				        		$parts = explode('Action', $method);
				        		$methodList[$parts[0]] = 0;

				        	}
						}
					}
					$controllers[$class] = $methodList;
				}
				$controllerList[$controllerGroup] = $controllers;
			}
		}


		foreach ($groupId as $group)
		{
			$data[$group] = $controllerList;
		}
			$formData = array();
			$formData = array_merge($formData , $_POST);

			$content = "<?php \n ";
			$content .= "\t define('GROUPID_GUEST', 0);\n";
			$content .= "\t define('GROUPID_ADMIN', 1);\n";
			$content .= "\t define('GROUPID_MODERATOR', 5);\n";
			$content .= "\t define('GROUPID_MEMBER', 20);\n";
			$content .=" \t //format: \$p[groupid] = array('{controllerGroup}' => array ('{controller}_{action}'));";
			//check controller group
			foreach($data as $groupId => $value)
			{
				$content .= "\n \t \$groupPermisson[" . $groupId."] = array(\n";
				foreach ($value as $controllerGroup => $controller)
				{
					if(!isset($formData['f'.$groupId.$controllerGroup]))
					{
						$content .= "\t\t'{$controllerGroup}' => array(\n";
						foreach ($controller as $obj=>$values)
						{
							if(isset($formData['f'.$groupId.$controllerGroup.$obj.'all']))
							{
								$content .= "\t\t\t'{$obj}_*', \n";
							}
							else
							{
								$keyName = 'f' . $groupId . $controllerGroup . $obj;
								if(array_key_exists($keyName, $formData))
								{
									foreach ($formData[$keyName] as $o)
									{
										$content .= "\t\t\t'{$obj}_{$o}',\n";
									}
								}
							}
						}
						$content .= "\t\t),\n";
					}
				}
				$content .= "\t);";
			}

			$fp = fopen(SITE_PATH. 'includes' . DIRECTORY_SEPARATOR . 'test.php' , 'w');
			if($fp)
			{
				fwrite($fp, $content);
				$success[] = $this->registry->lang['controller']['success'];
			}
			else
			{
				$errors = $this->registry->lang['controller']['error'];
			}
			fclose($fp);

			header('location: '.$this->registry['conf']['rooturl_admin'] . 'permission/permissionfile/status/success');
	}

	private function getListDir($path , $file=false)
	{
		$dirList = array();
		if ($handle = opendir($path))
		{
		    while (false !== ($entry = readdir($handle)))
		    {
		        if($entry != '.' && $entry != '..' && $entry != 'core' && preg_match('/^[a-z][a-z.]+$/ims', $entry))
		        {
		        	if($file == false)
		        	{
		        		if(is_dir($path .'/'. $entry) === true)
		        		{
		        			$dirList[] = $entry;
		        		}
		        	}
		        	else
		        	{
		        		if(is_file($path .'/'. $entry) === true)
		        		{
		        			$dirList[] = $entry;
		        		}
		        	}
		        }
		    }
		}


		return $dirList;
	}

	private function writeContent($data, $formData)
	{
		$display = '<div class="page-header" rel="menu_permission"><h1>Generate File <code>/includes/permission.php</code></h1></div>';
		$display .=  '<form action="'.$this->registry['conf']['rooturl_admin'].'permission/createpermissionfile" method="post" id="form1" name="form1">
					<table class="table">
					<thead>
						<tr>
							<th width="100">USER GROUP</th>
							<th width="250">CONTROLLER GROUP</th>
							<th width="140">CONTROLLER</th>
							<th>ACTION</th>
						</tr>
					</thead>
					<tbody>';
		foreach($data as $groupId=>$items)
		{
			$flagGroupId =true;
			foreach($items as $controllerGroup => $value)
			{
				$flagControllerGroup = true;
				foreach($value as $controller=>$values)
				{

					if($flagGroupId)
					{
						$display .= '<tr><td style="border-top:2px solid #08c;"><span class="label label-success">';
						$display .= $groupId .'</span></td><td style="border-top:2px solid #08c;" class="form-inline">';
						$flagGroupId = false;
					}
					else
					{
						if($flagControllerGroup)
						{
							$display .= '<tr><td><span class="label" style="background:none;color:#ddd;text-shadow:none;">'.$groupId.'</span></td><td style="border-top:2px solid #08c;" class="form-inline">';
						}
						else
						{
							$display .= '<tr><td></td><td>';
						}

					}
					if($flagControllerGroup)
					{
						$display .= '<span class="label label-info">'.$controllerGroup . '</span>&nbsp;&nbsp;&nbsp;<label class="checkbox"><input type="checkbox" name="f'.$groupId. $controllerGroup .'" id="f'.$groupId. $controllerGroup .'" value="0" ';
						if(isset($formData['f'.$groupId. $controllerGroup]))
						{
							$display .= 'checked';
						}
						$display .=' />Ignore all controllers</label></td>';

						$flagControllerGroup = false;
						$display .= '<td style="border-top:2px solid #08c;"><span class="label label-inverse">'.$controller.'</span></td><td style="border-top:2px solid #08c;" class="form-inline"><label class="radio inline"><input onclick="view(\'#f'.$groupId.$controllerGroup .$controller.'\',\'\')" type="radio" id="f'.$groupId.$controllerGroup .$controller.'all" name="f'.$groupId.$controllerGroup .$controller.'all" value="all" ';
						if(!isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'checked';
						}
						$display .= ' />All</label> <label class="radio inline"><input onclick="view(\'#f'.$groupId.$controllerGroup .$controller.'\',\'out\')" type="radio" name="f'.$groupId.$controllerGroup .$controller.'custom" id="f'.$groupId.$controllerGroup .$controller.'custom" value="custom" ';
						if(isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'checked';
						}
						$display .= '/>Custom </label><span class="permissionactioncustom" id="f'.$groupId . $controllerGroup . $controller .'action" ';
						if(!isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'style="display:none"';
						}
						$display .= '>';
					}
					else
					{
						$display .= '</td>';
						$display .= '<td><span class="label label-inverse">'.$controller.'</span></td><td class="form-inline"><label class="radio inline"><input onclick="view(\'#f'.$groupId.$controllerGroup .$controller.'\',\'\')" type="radio" id="f'.$groupId.$controllerGroup .$controller.'all" name="f'.$groupId.$controllerGroup .$controller.'all" value="all"';
						if(!isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'checked';
						}
						$display .= ' />All</label> <label class="radio inline"><input onclick="view(\'#f'.$groupId.$controllerGroup .$controller.'\',\'out\')" type="radio" id="f'.$groupId.$controllerGroup .$controller.'custom"name="f'.$groupId.$controllerGroup .$controller.'custom" name="f'.$groupId.$controllerGroup .$controller.'custom" value="custom"';
						if(isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'checked';
						}
						$display .= '/>Custom</label><span class="permissionactioncustom" id="f'.$groupId . $controllerGroup . $controller .'action" ';
						if(!isset($formData['f'.$groupId. $controllerGroup.$controller.'all']))
						{
							$display .= 'style="display:none"';
						}
						$display .= '>';
					}
					foreach($values as $method=>$role)
					{
						$display .= '<label class="checkbox inline"><input type="checkbox" name="f'.$groupId.$controllerGroup.$controller.'[]" value="'.$method.'" ';
						if($role == 1)
						{
							$display .= 'checked';
						}
						$display .= ' />'.$method.'</label>';
					}
					$display .= '</span></td></tr>';
				}
			}
		}
		$display .= '<tr><td colspan="4"><input type="submit" name="fsubmit" value="Create" class="btn btn-large btn-primary" /></td></tr></tbody>
			</table>
			</form>';
		$display .= '<script type="text/javascript">
						function view(selector ,mode)
						{
							if(mode == "out")
							{
								$(selector+"all").removeAttr("checked");
								$(selector+"action").fadeIn();
							}
							else
							{
								$(selector+"custom").removeAttr("checked");
								$(selector+"action").fadeOut();
							}
						}
					</script>';
		return $display;
	}
}
