<?php

Class Controller_Admin_Utility Extends Controller_Admin_Base
{
	
	public function indexAction()
	{
		
		header('location: ' . $this->registry->conf['rooturl_admin'] . 'utility/passwordgenerator');			
				
		
	}
	
	public function passwordGeneratorAction()
	{
		$encodedPass = '';
		
		if(isset($_POST['fpassword']))
		{
			$myHasher = new viephpHashing();
			$encodedPass = $myHasher->hash($_POST['fpassword']);
		}
		
		$this->registry->smarty->assign(array(	'encodedPass' => $encodedPass
												));
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'passwordgenerator.tpl');
		
		$this->registry->smarty->assign(array(	'menu'		=> 'passwordgenerator',
												'pageTitle'	=> 'Password Generator',
												'contents' 	=> $contents));
		
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	
	public function generatenewsmallproductimagereplaceAction()
	{
		set_time_limit(0);
		
		$myTimer = new Timer();
		$myTimer->start();
		
		$dir = 'uploads/product/';
		$destination = 'uploads/product_small/';
		
		if(!is_writable($destination))
		{
			die('Can not write to directory : ' . $destination);
		}
		
		$objects = new RecursiveIteratorIterator(
		               new RecursiveDirectoryIterator($dir), 
		               RecursiveIteratorIterator::SELF_FIRST);

		$smallList = array();
		foreach($objects as $name => $object){
			$path = $object->getPathname();
			
			$ext = Helper::fileExtension($path);
			if(in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'bmp')) && strpos($path, '-small.') !== false && file_exists($path))
			{
				$smallList[] = $path;
			}
		}
		
		//Get small chunk to testing
		//$smallList = array_splice($smallList, 0, 100);
		
		//start resize image
		$maxwidth = $maxheight = 150;
		foreach($smallList as $image)
		{
			$imageinfo = getimagesize($image);
			if($imageinfo[0] > $maxwidth || $imageinfo[1] > $maxheight)
			{
				//Start resize to smaller image size
				//Resize big image if needed
	            $myImageResizer = new ImageResizer( './', $image,
	                                                './', $image,
	                                                $maxwidth,
	                                                $maxheight,
	                                                '',
	                                                95);
	            $myImageResizer->output();
	            unset($myImageResizer);
				
			}
		}
		
		$myTimer->stop();
		
		echo 'Thoi gian thuc thi: ' . $myTimer->get_exec_time() . '.';
		echo 'Done.';
		//print_r($smallList);
	}
	
	
	public function generatenewsmallproductimageAction()
	{
		set_time_limit(0);
		
		$myTimer = new Timer();
		$myTimer->start();
		
		$dir = 'uploads/product/';
		$destination = 'uploads/product_small/';
		
		if(!is_writable($destination))
		{
			die('Can not write to directory : ' . $destination);
		}
		
		$objects = new RecursiveIteratorIterator(
		               new RecursiveDirectoryIterator($dir), 
		               RecursiveIteratorIterator::SELF_FIRST);

		$smallList = array();
		foreach($objects as $name => $object){
			$path = $object->getPathname();
			
			$ext = Helper::fileExtension($path);
			if(in_array($ext, array('jpg', 'jpeg', 'gif', 'png', 'bmp')) && strpos($path, '-small.') !== false && file_exists($path))
			{
				$smallList[] = $path;
			}
		}
		
		//Get small chunk to testing
		$smallList = array_splice($smallList, 0, 100);
		
		//start resize image
		$maxwidth = $maxheight = 150;
		foreach($smallList as $image)
		{
			$imageinfo = getimagesize($image);
			if($imageinfo[0] > $maxwidth || $imageinfo[1] > $maxheight)
			{
				$newpath = str_replace($dir, $destination, $image);
				
				//get desitnation folder
				$pos = strrpos($newpath, '/');
				$newdir = substr($newpath, 0, $pos);

				if(!file_exists($newdir))
				{
					if(!mkdir($newdir, 0777, true))
					{
						echo 'Can not create directory: ' . $newdir . '<br />';
					}
				}
				
				//Start resize to smaller image size
				//Resize big image if needed
	            $myImageResizer = new ImageResizer( './', $image,
	                                                './', $image,
	                                                $maxwidth,
	                                                $maxheight,
	                                                '',
	                                                95);
	            $myImageResizer->output();
	            unset($myImageResizer);
				
			}
		}
		
		$myTimer->stop();
		
		echo 'Thoi gian thuc thi: ' . $myTimer->get_exec_time() . '.';
		echo 'Done.';
		//print_r($smallList);
	}
    	
	####################################################################################################
	####################################################################################################
	####################################################################################################
	
	
	
}
