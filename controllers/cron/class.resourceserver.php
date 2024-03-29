<?php

Class Controller_Cron_ResourceServer Extends Controller_Cron_Base 
{
	
	function indexAction() 
	{
		
		
	} 
	
	/**
	 * Move no-resourceserver image/file from webserver to resource server
	 */
	function syncAction()
	{
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		//FTP List
		$resourceserverFtpList = array(
			array('id' => 1, 'ipaddress' => '172.16.141.40', 'username' => 'admin', 'password' => 'Dienmay#2013!')
		);
		
		
		//List of item need to be upload to resource server
		$queueList = array();
		$successCount = $errorCount = 0;
		
		
		////////////////////////////////////////////////////////
		//	PRODUCT
		$itemList = Core_Product::getProducts(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'product', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['product']['imageDirectory']);

		////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////
		//	ADS
		$itemList = Core_Ads::getAdss(array('fresourceserver' => 0), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'ads', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['ads']['imageDirectory']);
				
		////////////////////////////////////////////////////////
		//	PRODUCTCATEGORY
		$itemList = Core_Productcategory::getProductcategorys(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'productcategory', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['productcategory']['imageDirectory']);
		
		////////////////////////////////////////////////////////
		//	PRODUCTMEDIA
		$itemList = Core_ProductMedia::getProductMedias(array('fresourceserver' => 0, 'fhasfile' => 1), 'id', 'DESC', '');		
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'productmedia', 'obj' => $item, 'image' => $item->file, 'directory' => $this->registry->setting['product']['imageDirectory']);
			
		////////////////////////////////////////////////////////
		//	VENDOR
		$itemList = Core_Vendor::getVendors(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'vendor', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['vendor']['imageDirectory']);
	
		
		////////////////////////////////////////////////////////
		//	NEWS
		$itemList = Core_News::getNewss(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'news', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['news']['imageDirectory']);
				
		
		////////////////////////////////////////////////////////
		//	STUFF
		// $itemList = Core_Stuff::getStuffs(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
		// if(count($itemList) > 0)
		// 	foreach($itemList as $item)
		// 		$queueList[] = array('type' => 'stuff', 'obj' => $item, 'image' => $item->image, 'directory' => $this->registry->setting['stuff']['imageDirectory']);

		
		//For demo, get first 10 item to test
		//$queueList = array_splice($queueList, 0, 10);
		
		//////////////////
		/////////////////
		if(count($queueList) == 0)
		{
			echo 'No resource need to be uploaded.';
		}
		else
		{
			//////////////
			//Connect to FTP Server
			try
			{
				$ftpServer = $resourceserverFtpList[0];
				$myFtp = new Ftp();
				$myFtp->connect($ftpServer['ipaddress']);
				$myFtp->login($ftpServer['username'], $ftpServer['password']);
				$myFtp->pasv(true);
			}
			catch(FtpException $e)
			{
				die('Error: ' . $e->getMessage());
			}
			
			/////////////
			//Connect OK, PUT file to ftp server
			$createdDirectoryList = array();
			
			foreach($queueList as $queue)
			{
				//Tien hanh upload toi resource server thong qua FTP
				$destinationFilePath = $queue['directory'] . $queue['image'];
				$sourceFilePath = $queue['directory'] . $queue['image'];

				if($queue['image'] != '')
				{
					if(file_exists($sourceFilePath))
					{
						$extPart = substr(strrchr($queue['image'],'.'),1);
						$lastSlashPos = strrpos($destinationFilePath, '/');

						//PROCESS DIRECTORY ON REMOTE SERVER
						//if not existed, create this directory
						$filename = substr($destinationFilePath, $lastSlashPos + 1);
						$filedir = substr($destinationFilePath, 0, $lastSlashPos);

						if(!in_array($filedir, $createdDirectoryList))
						{
							$myFtp->mkDirRecursive($filedir);
							$createdDirectoryList[] = $filedir;
						}



						//////////
						//Directory OK, start upload file
						try
						{
							$myFtp->put($destinationFilePath, $sourceFilePath, FTP_BINARY);

							//If run here, it means upload big file ok
							//Checking small file
							$nameThumbPart = substr($queue['image'], 0, strrpos($queue['image'], '.'));
				            $nameThumb = $nameThumbPart . '-small.' . $extPart;

							$destinationFilePathThumb = $queue['directory'] . $nameThumb;
							$sourceFilePathThumb = $queue['directory'] . $nameThumb;

							$resourceserverpassed = false;
							if(file_exists($sourceFilePathThumb))
							{
								$myFtp->put($destinationFilePathThumb, $sourceFilePathThumb, FTP_BINARY);

								//it goest here, mean big and thumb is uploaded to resource server
								$resourceserverpassed = true;
							}
							else
							{
								$resourceserverpassed = true;
							}

							//Checking medium file
							$nameThumbPart = substr($queue['image'], 0, strrpos($queue['image'], '.'));
				            $nameThumb = $nameThumbPart . '-medium.' . $extPart;

				            $destinationFilePathThumb = $queue['directory'] . $nameThumb;
							$sourceFilePathThumb = $queue['directory'] . $nameThumb;							

							$resourceserverpassed = false;
							if(file_exists($sourceFilePathThumb))
							{							
								$myFtp->put($destinationFilePathThumb, $sourceFilePathThumb, FTP_BINARY);

								//it goest here, mean big and thumb is uploaded to resource server
								$resourceserverpassed = true;
							}
							else
							{
								$resourceserverpassed = true;
							}

							//Final check to update flag
							if($resourceserverpassed)
							{
								//update resourceserver field for this record
								$queue['obj']->resourceserver = $ftpServer['id'];
								if($queue['obj']->updateData())
								{
									$successCount++;
								}
								else
								{
									$errorCount++;
								}
							}
							else
								$errorCount++;

						}
						catch(FtpException $e)
						{
							echo 'Can not Upload file ' . $sourceFilePath . '. ' . "\n";
							$errorCount++;
							continue;
						}//end PUT file
					}//end file_exists()
					else
					{
						$errorCount++;
						echo 'File not found: ' . $sourceFilePath . '. ' . "\n";
					}
				}//end empty image
				
				
			}//end looping
			
			//close connection
			$myFtp->close(); 
		}
		
		////
		echo 'Success Count: ' . $successCount . '. Error Count: ' . $errorCount;
	}
	
	function removenotfoundimagestuffAction()
	{
		//fix Duy stuff image problem
		die();
		
		$clear = 0;
		
		$sql = 'SELECT s_id, s_image 
				FROM '.  TABLE_PREFIX . 'stuff
				WHERE s_image != ""
				ORDER BY s_id ASC';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$filepath = $this->registry->setting['stuff']['imageDirectory'] . $row['s_image'];
			
			if(file_exists($filepath))
			{
				//neu file ton tai, kiem tra filesize
				$imagesize = getimagesize($filepath);
				if($imagesize[0] == 0 || $imagesize[1] == 0)
				{
					//neu file ko ton tai, thi clear cot nay
					$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
							SET s_image = ""
							WHERE s_id = ?';
					if($this->registry->db->query($sql, array($row['s_id'])))
					{
						$clear++;
						unlink($filepath);
					}
				}
				
			}
			else
			{
				//neu file ko ton tai, thi clear cot nay
				$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
						SET s_image = ""
						WHERE s_id = ?';
				if($this->registry->db->query($sql, array($row['s_id'])))
					$clear++;
			}
		}
		
		echo 'Number of clear: ' . $clear;
	}
	
	function syncstaticAction() 
	{

		if(!is_writable('templates/default/'))
		{
			echo '--templates/default/-- must be CHMOD to 777.';
		}
		else
		{
			$staticscript = array(
					'dienmay.css' => $this->registry->conf['rooturl'] . 'templates/default/min/?g=css&ver=' . time(),
					'dienmay.js' => $this->registry->conf['rooturl'] . 'templates/default/min/?g=js&ver=' . time());


			//Generate file
			foreach($staticscript as $name => $path)
			{
				$destinationPath = 'templates/default/' . $name;
				$newContent = file_get_contents($path);

				if(file_exists($destinationPath))
					$oldContent = file_get_contents($destinationPath);
				else
					$oldContent = '';

				if(md5($newContent) != md5($oldContent))
				{
					file_put_contents($destinationPath, $newContent);
					echo '--'.$destinationPath.' --SAVE NEW. <br />';
				}
				else
				{
					echo '--'.$destinationPath.' --Not change. <br />';
				}
			}
			//end foreach
		}//end check permission
	}

    function synccontentAction(){
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        //FTP List
        $resourceserverFtpList = array(
            array('id' => 1, 'ipaddress' => '172.16.141.40', 'username' => 'admin', 'password' => 'Dienmay#2013!')
        );

        //List of item need to be upload to resource server
        $queueList = array();
        $successCount = $errorCount = 0;

        // Get content Product
        $itemList = Core_Product::getProducts(array('fresourceserver' => 0), 'id', 'DESC', '');

        if(count($itemList) > 0)
        {
            foreach($itemList as $item)
            {
                $imagescontent = ExternalImageDownload::getResourceList($item->content);
                $queueList[] = array('type' => 'product', 'obj' => $item, 'image' => $item->image,'content' => $item->content, 'imagescontent'=> $imagescontent, 'directory' => $this->registry->setting['product']['imageDirectory']);
            }
        }
        /*//	NEWS
        $itemList = Core_News::getNewss(array('fresourceserver' => 0, 'fhasimage' => 1), 'id', 'DESC', '');
        if(count($itemList) > 0)
        {
            foreach($itemList as $item){
                $imagescontent = ExternalImageDownload::getResourceList($item->content);
                $queueList[] = array('type' => 'news', 'obj' => $item, 'image' => $item->image,'content' => $item->content, 'imagescontent'=> $imagescontent, 'directory' => $this->registry->setting['news']['imageDirectory']);
            }
        }

        // Page
        $itemList = Core_Page::getPages('id', 'DESC', '');
        var_dump($itemList);die();
        if(count($itemList) > 0)
        {
            foreach($itemList as $item){
                $imagescontent = ExternalImageDownload::getResourceList($item->content);
                $queueList[] = array('type' => 'page', 'obj' => $item, 'image' => $item->image,'content' => $item->content, 'imagescontent'=> $imagescontent, 'directory' => $this->registry->setting['news']['imageDirectory']);
            }
        }*/

        if(count($queueList) == 0)
        {
            echo 'No resource need to be uploaded.';
        }
        else
        {
            try
            {
                $ftpServer = $resourceserverFtpList[0];
                $myFtp = new Ftp();
                $myFtp->connect($ftpServer['ipaddress']);
                $myFtp->login($ftpServer['username'], $ftpServer['password']);
                $myFtp->pasv(true);
            }
            catch(FtpException $e)
            {
                die('Error: ' . $e->getMessage());
            }
        }

            //Connect OK, PUT file to ftp server
            $createdDirectoryList = array();
            foreach($queueList as $queue)
            {
                $resourceserverpassed = false;
                if(is_array($queue['imagescontent']))
                {
                    $ftpContent = $queue['content'];
                    foreach($queue['imagescontent'] as $urlimages)
                    {
                        //Tien hanh upload toi resource server thong qua FTP
                        $url = parse_url($urlimages, PHP_URL_PATH);
                        $url = substr($url,1);

                        $destinationFilePath = $url;
                        $sourceFilePath = $url;

                        if(file_exists($sourceFilePath))
                        {
                            $extPart = substr(strrchr($url,'.'),1);
                            $lastSlashPos = strrpos($destinationFilePath, '/');

                            //PROCESS DIRECTORY ON REMOTE SERVER
                            //if not existed, create this directory
                            $filename = substr($destinationFilePath, $lastSlashPos + 1);
                            $filedir = substr($destinationFilePath, 0, $lastSlashPos);

                            if(!in_array($filedir, $createdDirectoryList))
                            {
                                $myFtp->mkDirRecursive($filedir);
                                $createdDirectoryList[] = $filedir;
                            }

                            //Directory OK, start upload file
                            try{
                                $myFtp->put($destinationFilePath, $sourceFilePath, FTP_BINARY);
                                // relace content with new url
                                $filedir = explode('/', $filedir, 2);
                                $domainUrl = 'https://ecommerce.kubil.app/' .$filedir[1].'/'. $filename;
                                $ftpContent = ContentRelace::replaceContentImagesFTP($domainUrl ,$urlimages, $ftpContent);
                                $resourceserverpassed = true;

                            }catch (FtpException $e)
                            {
                                echo 'Can not Upload file ' . $sourceFilePath . '. ' . "\n";
                                $errorCount++;
                                continue;
                            }//end PUT file

                        }//end file_exists()
                        else
                        {
                            $errorCount++;
                            echo 'File not found: ' . $sourceFilePath . '. ' . "\n";
                        }
                    }
                    // upload new content
                    if($resourceserverpassed){
                        $queue['obj']->content = $ftpContent;
                        if($queue['obj']->updateData())
                        {
                            $successCount++;
                        }
                        else
                        {
                            $errorCount++;
                        }
                    }
                    else
                        $errorCount++;

                }//end empty image
            }
            $myFtp->close();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function syncstaticmobileAction() 
	{

		if(!is_writable('templates/default/'))
		{
			echo '--templates/default/-- must be CHMOD to 777.';
		}
		else
		{
			$staticscript = array(
					'mdienmay.css' => $this->registry->conf['rooturl'] . 'templates/default/min/?g=mcss&ver=' . time(),
					'mdienmay.js' => $this->registry->conf['rooturl'] . 'templates/default/min/?g=mjs&ver=' . time());


			//Generate file
			foreach($staticscript as $name => $path)
			{
				$destinationPath = 'templates/default/' . $name;
				$newContent = file_get_contents($path);

				if(file_exists($destinationPath))
					$oldContent = file_get_contents($destinationPath);
				else
					$oldContent = '';

				if(md5($newContent) != md5($oldContent))
				{
					file_put_contents($destinationPath, $newContent);
					echo '--'.$destinationPath.' --SAVE NEW. <br />';
				}
				else
				{
					echo '--'.$destinationPath.' --Not change. <br />';
				}
			}
			//end foreach
		}//end check permission
	}

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}









