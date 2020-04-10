<?php

Class Controller_Profile_Info Extends Controller_Profile_Base 
{
	function indexAction() 
	{
		
		echo ''; 
	} 
	
	function indexajaxAction() 
	{
		
		$myProfileList = Core_ProfileAdvanced::getUserProfile($this->registry->myUser->id);
		
		if($this->registry->myUser->birthday != '0000-00-00')
		{
			$birthday = strtotime($this->registry->myUser->birthday);
			if($birthday)
				$birthdayInfo = getdate($birthday);
		}
		elseif($this->registry->myUser->isGroup('group'))
		{
			$birthdayInfo = getdate($this->registry->myUser->datecreated);
		}
		
		
		//Lay danh sach phong ban ma User nay thuoc ve
		//Lay toi phong ban goc (tat ca phong ban), recursive
		$userDepartmentList = $this->registry->myUser->getBelongDepartments();
		
		$this->registry->smarty->assign(array('myProfileList' => $myProfileList,
											'birthdayInfo' => $birthdayInfo,
											'userDepartmentList' => $userDepartmentList
											));
											
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl'); 
	}
	
	
	
	
	 
}

