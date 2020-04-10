<?php

Class Controller_Admin_CacheManager Extends Controller_Admin_Base
{
	public $recordPerPage = 20;
	
	public function indexAction()
	{
		
				
		$this->registry->smarty->assign(array(	
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'cachemanager',
												'pageTitle'	=> 'Cache Manager',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	public function userAction()
	{
		
		$error = $success = $warning = $formData = array();
		$cacheResult = array();
		
		if(isset($_POST['fsubmitcheck']) || isset($_POST['fsubmitstore']) || isset($_POST['fsubmitdelete']))
		{
			$formData = array_merge($formData, $_POST);
			$userid = (int)$formData['fuserid'];
			
			//kiem tra xem userid nay co ton tai khong
			$myUser = new Core_User($userid);
			
			if($myUser->id > 0)
			{
				if(isset($_POST['fsubmitcheck']))
				{
					$cacheResult = Core_User::cacheCheck($userid);
					if($cacheResult === false)
					{
						$warning[] = 'Selected User is not cached.';
					}
					else
					{
						$success[] = 'Selected User is cached.';
						$cachecheckOutput = highlight_string(var_export($cacheResult, true), true);
					}
				}
				elseif(isset($_POST['fsubmitstore']))
				{
					//store the cache for user
					$cacheUser = new Core_User();
					$cacheUser = Core_User::cacheGet($myUser->id, $cacheSuccess, true);
					if($cacheSuccess)
					{
						$success[] = 'Selected User data had been cached.';	
					}
					else
					{
						$error[] = 'Error while creating cache for selected user.';
					}
				}
				else
				{
					if(Core_User::cacheDelete($myUser->id))
					{
						$success[] = 'Delete cache for selected user successfully.';
					}
					else
					{
						$error[] = 'Error while delete cache for selected user.';
					}
				}
				
			}
			else
			{
				$error[] = 'User not found with your selected ID. Please change User ID.';
			}
		}
		
		
				
		$this->registry->smarty->assign(array(	'cacheResult' 	=> $cacheResult,
												'cachecheckOutput'	=> $cachecheckOutput,
												'formData'		=> $formData,
												'success'		=> $success,
												'warning'		=> $warning,
												'error'			=> $error,));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'user.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'cachemanager',
												'pageTitle'	=> 'Cache Manager :: User',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	public function bookAction()
	{
		
		$error = $success = $warning = $formData = array();
		$cacheResult = array();
		
		if(isset($_POST['fsubmitcheck']) || isset($_POST['fsubmitstore']) || isset($_POST['fsubmitdelete']))
		{
			$formData = array_merge($formData, $_POST);
			$bookid = (int)$formData['fbookid'];
			
			//kiem tra xem userid nay co ton tai khong
			$myBook = new Core_Book($bookid);
			
			if($myBook->id > 0)
			{
				if(isset($_POST['fsubmitcheck']))
				{
					$cacheResult = Core_Book::cacheCheck($bookid);
					if($cacheResult === false)
					{
						$warning[] = 'Selected Book is not cached.';
					}
					else
					{
						$success[] = 'Selected Book is cached.';
						$cachecheckOutput = highlight_string(var_export($cacheResult, true), true);
					}
				}
				elseif(isset($_POST['fsubmitstore']))
				{
					//store the cache for user
					$cacheBook = new Core_Book();
					$cacheBook = Core_Book::cacheGet($myBook->id, $cacheSuccess, true);
					if($cacheSuccess)
					{
						$success[] = 'Selected Book data had been cached.';	
					}
					else
					{
						$error[] = 'Error while creating cache for selected book.';
					}
				}
				else
				{
					if(Core_Book::cacheDelete($myBook->id))
					{
						$success[] = 'Delete cache for selected book successfully.';
					}
					else
					{
						$error[] = 'Error while delete cache for selected book.';
					}
				}
				
			}
			else
			{
				$error[] = 'Book not found with your selected ID. Please change Book ID.';
			}
		}
		
		
				
		$this->registry->smarty->assign(array(	'cacheResult' 	=> $cacheResult,
												'cachecheckOutput'	=> $cachecheckOutput,
												'formData'		=> $formData,
												'success'		=> $success,
												'warning'		=> $warning,
												'error'			=> $error,));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'book.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'cachemanager',
												'pageTitle'	=> 'Cache Manager :: Book',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
    	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	
	
}
