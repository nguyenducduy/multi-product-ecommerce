<?php

Class Controller_Profile_File Extends Controller_Profile_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array(), 'fuid' => $this->registry->me->id, 'fuploadtype' => Core_Backend_File::UPLOADTYPE_NORMALUPLOAD);
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$nameseoFilter = (string)($this->registry->router->getArg('nameseo'));
		$extensionFilter = (string)($this->registry->router->getArg('extension'));
		$isdirectoryFilter = (int)($this->registry->router->getArg('isdirectory'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$isstarredFilter = (int)($this->registry->router->getArg('isstarred'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$permissionFilter = (int)($this->registry->router->getArg('permission'));
		$countviewFilter = (int)($this->registry->router->getArg('countview'));
		$countdownloadFilter = (int)($this->registry->router->getArg('countdownload'));
		$countchildrenFilter = (int)($this->registry->router->getArg('countchildren'));
		$datelastdownloadedFilter = (int)($this->registry->router->getArg('datelastdownloaded'));
		$idFilter = (int)($this->registry->router->getArg('id'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'natural';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['fileBulkToken']==$_POST['ftoken'])
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
                            $myFile = new Core_Backend_File($id);

                            if($myFile->id > 0)
                            {
                                //tien hanh xoa
                                if($myFile->delete())
                                {
                                    $deletedItems[] = $myFile->id;
                                    $this->registry->me->writelog('file_delete', $myFile->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myFile->id;
                            }
                            else
                                $cannotDeletedItems[] = $myFile->id;
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

		$_SESSION['fileBulkToken'] = $_SESSION['securityToken'] = Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($nameseoFilter != "")
		{
			$paginateUrl .= 'nameseo/'.$nameseoFilter . '/';
			$formData['fnameseo'] = $nameseoFilter;
			$formData['search'] = 'nameseo';
		}

		if($extensionFilter != "")
		{
			$paginateUrl .= 'extension/'.$extensionFilter . '/';
			$formData['fextension'] = $extensionFilter;
			$formData['search'] = 'extension';
		}

		if($isdirectoryFilter > 0)
		{
			$paginateUrl .= 'isdirectory/'.$isdirectoryFilter . '/';
			$formData['fisdirectory'] = $isdirectoryFilter;
			$formData['search'] = 'isdirectory';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		//store the parent directory to check UP to parent directory
		$currentDirectory = new Core_Backend_File();
		$parentDirectoryList = Core_Backend_File::getFullParentDirectories($parentidFilter);
		$parentDirectoryList = array_reverse($parentDirectoryList);

		$paginateUrl .= 'parentid/'.$parentidFilter . '/';
		$formData['fparentid'] = $parentidFilter;
		$formData['search'] = 'parentid';
		$currentDirectory->getData($parentidFilter);

		//check valid parent is a Directory
		if($parentidFilter > 0 && $currentDirectory->isdirectory == 0)
			$currentDirectory = new Core_Backend_File();


		if($isstarredFilter > 0)
		{
			$paginateUrl .= 'isstarred/'.$isstarredFilter . '/';
			$formData['fisstarred'] = $isstarredFilter;
			$formData['search'] = 'isstarred';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($permissionFilter > 0)
		{
			$paginateUrl .= 'permission/'.$permissionFilter . '/';
			$formData['fpermission'] = $permissionFilter;
			$formData['search'] = 'permission';
		}

		if($countviewFilter > 0)
		{
			$paginateUrl .= 'countview/'.$countviewFilter . '/';
			$formData['fcountview'] = $countviewFilter;
			$formData['search'] = 'countview';
		}

		if($countdownloadFilter > 0)
		{
			$paginateUrl .= 'countdownload/'.$countdownloadFilter . '/';
			$formData['fcountdownload'] = $countdownloadFilter;
			$formData['search'] = 'countdownload';
		}

		if($countchildrenFilter > 0)
		{
			$paginateUrl .= 'countchildren/'.$countchildrenFilter . '/';
			$formData['fcountchildren'] = $countchildrenFilter;
			$formData['search'] = 'countchildren';
		}

		if($datelastdownloadedFilter > 0)
		{
			$paginateUrl .= 'datelastdownloaded/'.$datelastdownloadedFilter . '/';
			$formData['fdatelastdownloaded'] = $datelastdownloadedFilter;
			$formData['search'] = 'datelastdownloaded';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		//testing only
		//$fullList = Core_Backend_File::getFullChildren($parentidFilter, '');
		//echodebug($fullList);


		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			elseif($searchKeywordIn == 'nameseo')
			{
				$paginateUrl .= 'searchin/nameseo/';
			}
			elseif($searchKeywordIn == 'summary')
			{
				$paginateUrl .= 'searchin/summary/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Backend_File::getFiles($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$files = Core_Backend_File::getFiles($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'files' 	=> $files,
												'formData'		=> $formData,
												'currentDirectory' => $currentDirectory,
												'parentDirectoryList' => $parentDirectoryList,
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


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	/**
	 * Call from uploadifive in Ajax file upload
	 */
	function uploadajaxAction()
	{
		/*
		UploadiFive
		Copyright (c) 2012 Reactive Apps, Ronnie Garcia
		*/

		$formData = array();
		$error = array();

		if($this->addActionValidator($formData, $error))
        {
			$checksum = md5_file($_FILES['ffile']['tmp_name']);
			$myFileDrive = Core_Backend_FileDrive::getFromChecksum($checksum);

			if($myFileDrive->id == 0)
			{
				$myFileDrive = new Core_Backend_FileDrive();
				$myFileDrive->uid = $this->registry->me->id;
				$myFileDrive->status = Core_Backend_FileDrive::STATUS_ENABLE;
				$myFileDrive->addData();
			}

	        if($myFileDrive->id > 0)
	        {
				$_SESSION['myFileDriveList'][] = $myFileDrive->id;
				echo $myFileDrive->id;
	        }
	        else
	        {
	            $error[] = $this->registry->lang['controller']['errAdd'];
	        }
		}
		else
		{
			echo implode('. ', $error);
		}

	}

	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		//store the parent directory to check UP to parent directory
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$currentDirectory = new Core_Backend_File();
		$parentDirectoryList = Core_Backend_File::getFullParentDirectories($parentidFilter);
		$parentDirectoryList = array_reverse($parentDirectoryList);
		$currentDirectory->getData($parentidFilter);
		$formData['fparentid'] = (int)$parentidFilter;
		//check valid parent is a Directory
		if($parentidFilter > 0 && $currentDirectory->isdirectory == 0)
			$currentDirectory = new Core_Backend_File();


		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['fileAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myFile = new Core_Backend_File();
					$myFile->uid = $this->registry->me->id;
					$myFile->parentid = $formData['fparentid'];
					$myFile->status = Core_Backend_File::STATUS_ENABLE;
					$myFile->isdirectory = 0;
					$myFile->summary = $formData['fsummary'];

                    if($myFile->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('file_add', $myFile->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['fileAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'currentDirectory' => $currentDirectory,
												'parentDirectoryList' => $parentDirectoryList,
												'error'			=> $error,
												'success'		=> $success,

												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}

	//checking & Download file from current user
	function downloadAction()
	{
		$id = (int)$this->registry->router->getArg('id');

		$myFile = new Core_Backend_File($id);

		//check permission to download
		if($myFile->id > 0 && $myFile->canDownload() && ($myFile->uid == $this->registry->me->id || Core_Backend_FileSharing::canDownload($this->registry->me->id, $myFile->id)))
		{
			if($myFile->isdirectory)
			{

			}
			else
			{
				$myFileDrive = new Core_Backend_FileDrive($myFile->fdid);
				if($myFileDrive->status != Core_Backend_FileDrive::STATUS_DISABLE)
				{

					//Everything OK, now, get the source filepath and readfile to download with hide url method
					$sourcepath = $this->registry->setting['filecloud']['fileDirectory'] . $myFileDrive->filepath;

					$myHttpDownloader = new HttpDownload();
					$myHttpDownloader->filename = $myFile->name;
				 	$myHttpDownloader->set_byfile($sourcepath); //Download from a file
				 	$myHttpDownloader->use_resume = true; //Enable Resume Mode
				 	$myHttpDownloader->download(); //Download File

					//Increase download
					if($myHttpDownloader->seek_start == 0)
					{
						$myFileDownload = new Core_Backend_FileDownload();
						$myFileDownload->uid = $this->registry->me->id;
						$myFileDownload->fid = $myFileDrive->id;
						$myFileDownload->type = Core_Backend_FileDownload::TYPE_FILEDOWNLOAD;
						$myFileDownload->addData();
					}
				}
				else
					$this->notfound();
			}

		}
		else
		{
			$this->notfound();
		}
	}

	//public
	function viewAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$publictoken = (string)$this->registry->router->getArg('t');
		$startdownload = (int)$this->registry->router->getArg('d');
		$branchid = (int)$this->registry->router->getArg('b');
		if($branchid == $id)
			$branchid = 0;

		$leafid = (int)$this->registry->router->getArg('l');
		$leafpublictoken = (string)$this->registry->router->getArg('lt');

		$myFile = new Core_Backend_File($id);

		//check permission to download
		if($myFile->id > 0 && $myFile->canPublic() && $myFile->publictoken == $publictoken)
		{
			if($myFile->isdirectory)
			{
				//listing all file/subdirectory of current directory
				//and check permission (it is subdirectory of current granted permission)
				if($branchid > 0)
				{
					$parentDirectoryList = Core_Backend_File::getFullParentDirectories($branchid);

					$parentDirectoryList = array_reverse($parentDirectoryList);

					$found = 0;
					foreach($parentDirectoryList as $parentdir)
					{
						if($parentdir->id == $myFile->id)
							$found = 1;
					}

					if($found == 1)
					{
						$currentDirectory = new Core_Backend_File($branchid);
					}
					else
						$this->notfound();
				}
				elseif($leafid > 0)
				{
					//download a leaf node file, traverse from the current directory or subdirectory
					$myLeafFile = new Core_Backend_File($leafid);
					if($myLeafFile->id > 0 && $myLeafFile->isdirectory == 0 && $leafpublictoken == $myLeafFile->publictoken && $myLeafFile->status == Core_Backend_File::STATUS_ENABLE && $myLeafFile->uploadtype != Core_Backend_File::UPLOADTYPE_INTRASH && $myLeafFile->uploadtype != Core_Backend_File::UPLOADTYPE_DELETED)
					{
						//valid file
						$myFileDrive = new Core_Backend_FileDrive($myLeafFile->fdid);
						if($myFileDrive->id > 0 && $myFileDrive->status == Core_Backend_FileDrive::STATUS_ENABLE)
						{
							//Everything OK, now, get the source filepath and readfile to download with hide url method
							$sourcepath = $this->registry->setting['filecloud']['fileDirectory'] . $myFileDrive->filepath;

							$myHttpDownloader = new HttpDownload();
							$myHttpDownloader->filename = $myLeafFile->name;
						 	$myHttpDownloader->set_byfile($sourcepath); //Download from a file
						 	$myHttpDownloader->use_resume = true; //Enable Resume Mode
						 	$myHttpDownloader->download(); //Download File
						}
						else
							$this->notfound();
					}
					else
						$this->notfound();
				}
				else
					$currentDirectory = $myFile;

				//After checking viewing the current directory or the subdirectory of current directory
				//And all the correct permission,
				//Just show the listing of current directory
				$fileList = Core_Backend_File::getFiles(array('fparentid' => $currentDirectory->id, 'fuploadtype' => Core_Backend_File::UPLOADTYPE_NORMALUPLOAD, 'fstatus' => Core_Backend_File::STATUS_ENABLE), '', '', '');
				$this->registry->smarty->assign(array(	'files' 		=> $fileList,
														'currentDirectory' => $currentDirectory,
														'parentDirectoryList' => $parentDirectoryList,
														'myFile'		=> $myFile,
														));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'view.tpl');
				$this->registry->smarty->assign(array(
														'pageTitle'	=> $this->registry->lang['controller']['pageTitle_view'],
														'contents' 			=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');

			}
			else
			{
				$myFileDrive = new Core_Backend_FileDrive($myFile->fdid);
				if($myFileDrive->status == Core_Backend_FileDrive::STATUS_ENABLE)
				{
					if($startdownload == 1)
					{
						//Everything OK, now, get the source filepath and readfile to download with hide url method
						$sourcepath = $this->registry->setting['filecloud']['fileDirectory'] . $myFileDrive->filepath;

						$myHttpDownloader = new HttpDownload();
						$myHttpDownloader->filename = $myFile->name;
					 	$myHttpDownloader->set_byfile($sourcepath); //Download from a file
					 	$myHttpDownloader->use_resume = true; //Enable Resume Mode
					 	$myHttpDownloader->download(); //Download File
					}
					else
					{
						//listing download starter like dropbox/mediafire
						$fileList = array($myFile);
						$this->registry->smarty->assign(array(	'files' 		=> $fileList,
																'myFile'		=> $myFile,
																));
						$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'view.tpl');
						$this->registry->smarty->assign(array(
																'pageTitle'	=> $this->registry->lang['controller']['pageTitle_view'],
																'contents' 			=> $contents));
						$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
					}
				}
				else
					$this->notfound();

			}
		}
		else
		{
			$this->notfound();
		}
	}



	function editAction()
	{
		$error 		= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		$id = (int)$this->registry->router->getArg('id');
		$myFile = new Core_Backend_File($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myFile->id == 0)
		{
			$error[] = 'File Not Found';
		}

		$formData['fid'] = $myFile->id;
		$formData['fname'] = $myFile->name;
		$formData['fnameseo'] = $myFile->nameseo;
		$formData['fsummary'] = $myFile->summary;
		$formData['fstatus'] = $myFile->status;
		$formData['fpermission'] = $myFile->permission;

		if(!empty($_POST['fsubmit']))
		{
               if($_SESSION['fileEditToken'] == $_POST['ftoken'])
               {
                   $formData = array_merge($formData, $_POST);

                   if($this->editActionValidator($formData, $error))
                   {

					$myFile->name = $formData['fname'];
					$myFile->summary = $formData['fsummary'];
					$myFile->type = $formData['ftype'];
					$myFile->status = $formData['fstatus'];
					$myFile->permission = $formData['fpermission'];

                       if($myFile->updateData())
                       {
                           $success[] = $this->registry->lang['controller']['succUpdate'];
                           $this->registry->me->writelog('file_edit', $myFile->id, array());
                       }
                       else
                       {
                           $error[] = $this->registry->lang['controller']['errUpdate'];
                       }
                   }
               }
		}


		$_SESSION['fileEditToken'] = Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'statusList'	=> Core_Backend_File::getStatusList(),
												'error'			=> $error,
												'success'		=> $success,

												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
		$this->registry->smarty->assign(array(
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainerRoot . 'index_shadowbox.tpl');
	}

	function directorydeleteajaxAction()
	{
		$success = 0;
		$message = '';

		$id = (int)$this->registry->router->getArg('id');
		$myFile = new Core_Backend_File($id);
		if($myFile->id > 0 && $myFile->uid == $this->registry->me->id && $myFile->isdirectory == 1 && Helper::checkSecurityToken())
		{

			//not really delete, just mark as IN TRASH
			$myFile->uploadtype = Core_Backend_File::UPLOADTYPE_INTRASH;
			if($myFile->updateData())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDeleteDirectory'];

				//goi email toi nguoi nhan
				$taskUrl = $this->registry->conf['rooturl'] . 'task/directorydelete';
				Helper::backgroundHttpPost($taskUrl, 'uid=' . $this->registry->me->id.'&fid='.$myFile->id);
			}
			else
				$message = $this->registry->lang['controller']['errDeleteDirectory'];
		}
		else
		{
			$message = $this->registry->lang['controller']['errNotFound'];
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}

	function filedeleteajaxAction()
	{
		$success = 0;
		$message = '';

		$id = (int)$this->registry->router->getArg('id');
		$myFile = new Core_Backend_File($id);
		if($myFile->id > 0 && $myFile->uid == $this->registry->me->id && $myFile->isdirectory == 0 && Helper::checkSecurityToken())
		{

			//not really delete, just mark as IN TRASH
			$myFile->uploadtype = Core_Backend_File::UPLOADTYPE_INTRASH;
			if($myFile->updateData())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDeleteFile'];
			}
			else
				$message = $this->registry->lang['controller']['errDeleteFile'];
		}
		else
		{
			$message = $this->registry->lang['controller']['errNotFound'];
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myFile = new Core_Backend_File($id);
		if($myFile->id > 0 && $myFile->uid == $this->registry->me->id)
		{
			//tien hanh xoa
			if($myFile->delete())
			{
				$redirectMsg = str_replace('###id###', $myFile->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('file_delete', $myFile->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myFile->id, $this->registry->lang['controller']['errDelete']);
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

	public function directoryaddajaxAction()
	{
		$success = 0;
        $message = '';

		$parentid = (int)$_GET['fparentid'];
		$name = (string)urldecode($_GET['fname']);

		if($parentid > 0)
		{
			$myParentDirectory = new Core_Backend_File($parentid);
		}

		if($parentid > 0 && $myParentDirectory->uid != $this->registry->me->id)
			$message = $this->registry->lang['controller']['errParentDirectoryIsNotValid'];
		elseif($parentid > 0 && $myParentDirectory->isdirectory == 0)
			$message = $this->registry->lang['controller']['errParentDirectoryIsNotExisted'];
		elseif(strlen($name) == 0)
			$message = $this->registry->lang['controller']['errDirectoryNameIsRequired'];
		elseif(preg_match('/[^a-z0-9_\s.%-+]/i', $name))
			$message = $this->registry->lang['controller']['errDirectoryNameIsNotValid'];
		elseif(Core_Backend_File::isExists(true, $name, $parentid, $this->registry->me->id))
			$message = $this->registry->lang['controller']['errDirectoryNameExisted'];
		else
		{
			//everything ok, just add
			$myDirectory = new Core_Backend_File();
			$myDirectory->uid = $this->registry->me->id;
			$myDirectory->name = $name;
			$myDirectory->nameseo = Helper::codau2khongdau($name, true, true);
			$myDirectory->isdirectory = 1;
			$myDirectory->parentid = $parentid;
			$myDirectory->status = Core_Backend_File::STATUS_ENABLE;

			if($myDirectory->addData())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDirectoryAdd'];
			}
			else
			{
				$message = $this->registry->lang['controller']['errDirectoryAdd'];
			}
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}

	public function directoryeditajaxAction()
	{
		$success = 0;
        $message = '';

		$name = (string)urldecode($_GET['fname']);
		$id = (int)$this->registry->router->getArg('id');
		$myDirectory = new Core_Backend_File($id);

		if($myDirectory->id == 0 || $myDirectory->uid != $this->registry->me->id || $myDirectory->isdirectory == 0)
			$message = $this->registry->lang['controller']['errDirectoryNotFound'];
		elseif(strlen($name) == 0)
			$message = $this->registry->lang['controller']['errDirectoryNameIsRequired'];
		elseif(preg_match('/[^a-z0-9_\s.%-+]/i', $name))
			$message = $this->registry->lang['controller']['errDirectoryNameIsNotValid'];
		elseif($name == $myDirectory->name)
			$message = $this->registry->lang['controller']['errDirectoryNameNotChange'];
		elseif(Core_Backend_File::isExists(true, $name, $myDirectory->parentid, $this->registry->me->id))
			$message = $this->registry->lang['controller']['errDirectoryNameExisted'];
		else
		{
			//everything ok, just add
			$myDirectory->name = $name;
			$myDirectory->nameseo = Helper::codau2khongdau($name, true, true);

			if($myDirectory->updateData())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDirectoryRename'];
			}
			else
			{
				$message = $this->registry->lang['controller']['errDirectoryRename'];
			}
		}

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;

		//check valid mydirectory
		$myParentDirectory = new Core_Backend_File($formData['fparentid']);

		if($formData['fparentid'] > 0 && $myParentDirectory->uid != $this->registry->me->id)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errParentDirectoryIsNotValid'];
		}

		if($formData['fparentid'] > 0 && $myParentDirectory->isdirectory == 0)
		{
			$pass = false;
			$message = $this->registry->lang['controller']['errParentDirectoryIsNotExisted'];
		}


		if($_FILES['ffile']['name'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFileRequired'];
			$pass = false;
		}
		else
		{
			$ext = strtoupper(Helper::fileExtension($_FILES['ffile']['name']));
			if(!in_array($ext, $this->registry->setting['filecloud']['fileValidType']))
			{
				$error[] = str_replace('###VALUE###', implode(', ', $this->registry->setting['filecloud']['fileValidType']), $this->registry->lang['controller']['errFiletypeInvalid']);
				$pass = false;
			}
			elseif($_FILES['ffile']['size'] > $this->registry->setting['filecloud']['fileMaxFileSize'])
			{
				$error[] = str_replace('###VALUE###', round($this->registry->setting['filecloud']['fileMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
				$pass = false;
			}
		}



		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		return $pass;
	}
}

