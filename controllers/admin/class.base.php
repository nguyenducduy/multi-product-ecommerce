<?php

Abstract Class Controller_Admin_Base Extends Controller_Core_Base 
{
		
	function __construct($registry) 
	{
		if(is_null($registry->myUser))
		{
			$registry->myUser = $registry->me;
			$registry->smarty->assign('myUser', $registry->me);
		}
		
		//Checking employee (with assign HRMdepartment) or Administrator or Developer
		//exclude Login controller ^^
		if($registry->controller != 'login' && $registry->controller != 'logintgdd' && $registry->controller != 'logout')
		{
			if(!$registry->me->isGroup('administrator') && !$registry->me->isGroup('developer') && !$registry->me->isGroup('employee'))
			{
				$this->notfound();
			}
			else
			{
				//Neu la nhan vien, nhung chua duoc cap phong ban thi redirect toi 
				if($registry->me->isGroup('employee'))
				{
					/*
					//select all department of this user
					$departmentList = $registry->me->getBelongDepartments();
					if(count($departmentList) == 0)
					{
						//employee nay chua duoc cap phong ban, tien hanh show template huong dan
						header('location: ' . $registry->conf['rooturl_admin'] . 'login/newemployee');
						exit();
					}
					elseif($registry->me->email == '' || $registry->me->password == '' || $registry->me->phone == '')
					{
						//neu la nhan vien, da duoc cap phong ban, thi bat buoc nhap email va phone
						header('location: ' . $registry->conf['rooturl_admin'] . 'login/initemployee');
						exit();
					}
					*/
				}//end check group employee
			}//end check employee group
			
		}
		
		
		parent::__construct($registry);
	}
	
}
