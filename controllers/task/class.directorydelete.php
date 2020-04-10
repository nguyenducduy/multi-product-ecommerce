<?php

Class Controller_Task_DirectoryDelete Extends Controller_Task_Base 
{
	
	public function indexAction()
	{
		$uid = (int)$_POST['uid'];
		$fid = (int)$_POST['fid'];
		
		
		$fh = fopen('directorydelete.txt', 'w');
		$param = var_export($_POST, true);
		fwrite($fh,$param);
		//fclose($fh);
		
		
		//check valid param
		if($uid == 0 || $fid == 0)
			die('e1');
		
		$myUser = new Core_User($uid);
		$myFile = new Core_Backend_File($fid);
		
		//check valid object
		if($myUser->id == 0 || $myFile->id == 0 || $myFile->uid != $myUser->id || $myFile->uploadtype != Core_Backend_File::UPLOADTYPE_INTRASH)
			die('e2');
			
		//User is Valid
		//Deleted Directory is Valid
		//Permission is Valid
		//Begin Recursive to get All File/Directory
		$willBeTrashIdList = Core_Backend_File::getFullChildren($myFile->id, '', true);
		
		//Start trashing all children of selected id
		Core_Backend_File::markAsTrash($willBeTrashIdList);
	}
	
}

