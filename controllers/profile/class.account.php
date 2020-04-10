<?php

Class Controller_Profile_Account Extends Controller_Profile_Base 
{
	
	function indexAction() 
	{
		if(isset($_GET['avatareditor']))
		{
			$this->avatareditorAction();
			exit();	
		}
		
		$error = array();
		$success = array();
		$contents = '';
		$formData = array();
		
		
			
		if($this->registry->me->id > 0)
		{
			if(isset($_GET['tab']))
				$tab = $_GET['tab'];
				
			$formData['ffullname'] = $this->registry->me->fullname;
			
			$dateinfo = getdate();
			$monthList = array(1,2,3,4,5,6,7,8,9,10,11,12);
			for($i = $dateinfo['year']; $i > $dateinfo['year'] - 50; $i--)
			{
				$yearList[] = $i;
			}
			
			//select tat ca profile advanced cua user
			$myProfileList = Core_ProfileAdvanced::getUserProfile($this->registry->me->id);
			
			$formData['fphone'] = $this->registry->me->phone;
			$formData['faddress'] = $this->registry->me->address;
			$formData['fregion'] = $this->registry->me->region;
			$formData['fbio'] = $this->registry->me->bio;
			$formData['fgender'] = $this->registry->me->gender;
			
			if($this->registry->me->birthday != '0000-00-00')
			{
				$bdTmp = date_parse($this->registry->me->birthday . ' 00:00:01');
				$formData['fbirthday'] = $bdTmp['day'] . '/' . $bdTmp['month'] . '/' . $bdTmp['year']; 	
			}
			
			$formData['fwebsite'] = $this->registry->me->website;
			
			
			
			
			//init for profile tab
			if(isset($_GET['deleteavatar']) && $_SESSION['avatarDeleteToken'] == $_GET['deleteavatar'] && $this->registry->me->avatar != '')
			{
				$this->registry->me->deleteImage();
				$this->registry->me->updateAvatar();	
			}
			
			//update fullname
			if(!empty($_POST['fsubmit']))
			{
				$formData = array_merge($formData, $_POST);
				$formData = Helper::array_strip_tags($formData);
				
				
				if($this->submitAccountValidator($formData, $error))
				{
					$this->registry->me->avatarCurrent = $this->registry->me->avatar;
					
					
					if($this->registry->me->updateData(array(
						'fullname' => $formData['ffullname'], 
						), $error) > 0)
					{
						$success[] = $this->registry->lang['controller']['succUpdate'];
						
						//update Date last action
						$this->registry->me->updateDateLastaction();
						
						//clear cache for this user
						Core_User::cacheDelete($this->registry->me->id);
					}
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}
			}
			
			//update info
			
			if(!empty($_POST['fsubmitinfo']))
			{
				$formData = array_merge($formData, $_POST);
				$formData = Helper::array_strip_tags($formData);
				
				if($this->submitInfoValidator($formData, $error))
				{
					$this->registry->me->phone = strip_tags($formData['fphone']);
					$this->registry->me->address = strip_tags($formData['faddress']);
					$this->registry->me->bio = strip_tags($formData['fbio']);
					$this->registry->me->birthday = strip_tags($formData['fbirthday']);
					$this->registry->me->website = strip_tags($formData['fwebsite']);
					
					if(strlen($formData['fbirthday']) > 0)
					{
						$tmp = explode('/', $formData['fbirthday']);
						$this->registry->me->birthday = $tmp[2] . '-' . ((int)$tmp[1] < 10 ? '0'.(int)$tmp[1] : (int)$tmp[1]) . '-' . ((int)$tmp[0] < 10 ? '0'.(int)$tmp[0] : (int)$tmp[0]);
					}
					
					
					if(isset($this->registry->setting['region'][$formData['fregion']]))
						$formData['fregion'] = (int)$formData['fregion'];
					else
						$formData['fregion'] = 0;
						
					
					if($this->registry->me->updateData(array(
						'region' => $formData['fregion'],
						'gender' => $formData['fgender']
						), $error) > 0)
					{
						$success[] = $this->registry->lang['controller']['succUpdate'];
						
						//create feed for profile edit
						$myFeedProfileEdit = new Core_Backend_Feed_ProfileEdit();
						$myFeedProfileEdit->uid = $this->registry->me->id;
						$myFeedProfileEdit->addData();
						
						//update Date last action
						$this->registry->me->updateDateLastaction();
						
						//clear cache for this user
						Core_User::cacheDelete($this->registry->me->id);
					}
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}
				$tab = 2;
			}
			
			
			
			//update password
			if(!empty($_POST['fsubmitpassword']))
			{
				//validate register data
				$formData = array_merge($formData, $_POST);
				
				if($this->submitPasswordValidator($formData, $error))
				{
					$this->registry->me->newpass = $formData['fnewpass1'];
					
					if($this->registry->me->updateData(array(), $error) > 0)
						$success[] = $this->registry->lang['controller']['succUpdate'];
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}
				$tab = 3;
			}
			
			//update password
			if(!empty($_POST['fsubmitpasswordnew']))
			{
				//validate register data
				$formData = array_merge($formData, $_POST);
				
				if($this->submitPasswordNewValidator($formData, $error))
				{
					$this->registry->me->newpass = $formData['fnewpass1'];
					
					if($this->registry->me->updateData(array(), $error) > 0)
						$success[] = $this->registry->lang['controller']['succUpdate'];
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}
				$tab = 3;
			}
			
			
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'user'		=> $this->registry->me,
													'myProfileList' => $myProfileList,
													'monthList' => $monthList,
													'yearList' => $yearList,
													'error' 	=> $error,
													'success' 	=> $success,
													'warningCreateNativeUser' => $this->registry->lang['controller']['warnCreateNativeUser'],
													'tab'		=> $tab,
													));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
			
			$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		}
		else
		{
			$this->notfound();
		}
		
	} 
	

	function infoAction() 
	{
				
		$error = array();
		$success = array();
		$contents = '';
		$formData = array();
		
		if($this->registry->me->id > 0)
		{
			$dateinfo = getdate();
			$monthList = array(1,2,3,4,5,6,7,8,9,10,11,12);
			for($i = $dateinfo['year']; $i > $dateinfo['year'] - 50; $i--)
			{
				$yearList[] = $i;
			}
			
			//select tat ca profile advanced cua user
			$myProfileList = Core_ProfileAdvanced::getUserProfile($this->registry->me->id);
			
			$formData['fphone'] = $this->registry->me->phone;
			$formData['faddress'] = $this->registry->me->address;
			$formData['fregion'] = $this->registry->me->region;
			$formData['fbio'] = $this->registry->me->bio;
			$formData['fgender'] = $this->registry->me->gender;
			
			if($this->registry->me->birthday != '0000-00-00')
			{
				$bdTmp = date_parse($this->registry->me->birthday . ' 00:00:01');
				$formData['fbirthday'] = $bdTmp['day'] . '/' . $bdTmp['month'] . '/' . $bdTmp['year']; 	
			}
			
			$formData['fwebsite'] = $this->registry->me->website;
			
			
			if(!empty($_POST['fsubmit']))
			{
				$formData = array_merge($formData, $_POST);
				$formData = Helper::array_strip_tags($formData);
				
				if($this->submitInfoValidator($formData, $error))
				{
					$this->registry->me->phone = strip_tags($formData['fphone']);
					$this->registry->me->address = strip_tags($formData['faddress']);
					$this->registry->me->bio = strip_tags($formData['fbio']);
					$this->registry->me->birthday = strip_tags($formData['fbirthday']);
					$this->registry->me->website = strip_tags($formData['fwebsite']);
					
					if(strlen($formData['fbirthday']) > 0)
					{
						$tmp = explode('/', $formData['fbirthday']);
						$this->registry->me->birthday = $tmp[2] . '-' . ((int)$tmp[1] < 10 ? '0'.(int)$tmp[1] : (int)$tmp[1]) . '-' . ((int)$tmp[0] < 10 ? '0'.(int)$tmp[0] : (int)$tmp[0]);
					}
					
					
					if(isset($this->registry->setting['region'][$formData['fregion']]))
						$formData['fregion'] = (int)$formData['fregion'];
					else
						$formData['fregion'] = 0;
						
					
					if($this->registry->me->updateData(array(
						'region' => $formData['fregion'],
						'gender' => $formData['fgender']
						), $error) > 0)
					{
						$success[] = $this->registry->lang['controller']['succUpdate'];
						
						//create feed for profile edit
						$myFeedProfileEdit = new Core_Backend_Feed_ProfileEdit();
						$myFeedProfileEdit->uid = $this->registry->me->id;
						$myFeedProfileEdit->addData();
						
						//update Date last action
						$this->registry->me->updateDateLastaction();
						
						//clear cache for this user
						Core_User::cacheDelete($this->registry->me->id);
					}
					else
						$error[] = $this->registry->lang['controller']['errUpdate'];
				}
			}
			
			
			
			
			
			
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'user'		=> $this->registry->me,
													'myProfileList' => $myProfileList,
													'monthList' => $monthList,
													'yearList' => $yearList,
													'error' 	=> $error,
													'success' 	=> $success,
													));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'info.tpl'); 
			
			$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $this->registry->lang['controller']['pageTitle'],
											'pageKeyword' => $this->registry->lang['controller']['pageKeyword'],
											'pageDescription' => $this->registry->lang['controller']['pageDescription'],
											));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');     
		}
		else
		{
			$this->notfound();
		}
		
	} 
	
	
	public function additemAction()
	{
		$success = 0;
		$message = '';
		
		$formData = $_POST;
		
		//filter data
		foreach($formData as $k => $v)
			$formData[$k] == strip_tags(trim($v));
		
		//xu ly them work
		if($formData['type'] == 'work')
		{
			if($this->validateAddWork($formData, $error, true))
			{
				$myProfileAdvanced = new Core_ProfileAdvanced();
				$myProfileAdvanced->uid = $this->registry->me->id;
				$myProfileAdvanced->type = Core_ProfileAdvanced::TYPE_WORK;
				$myProfileAdvanced->text1 = $formData['text1'];
				$myProfileAdvanced->text2 = $formData['text2'];
				$myProfileAdvanced->text3 = (int)$formData['text3'];
				$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
				if($formData['tonow'] == 1)
					$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
				else
					$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
					
				if($myProfileAdvanced->addData())
				{
					$message = $this->registry->lang['controller']['succProfileitemAdd'];
					$success = 1;
					$moreMessage = '<id>'.$myProfileAdvanced->id.'</id>';
				}
				else
				{
					$message = $this->registry->lang['controller']['errProfileitemAdd'];
				}
				
			}
		}
		elseif($formData['type'] == 'university')
		{
			if($this->validateAddUniversity($formData, $error, true))
			{
				$myProfileAdvanced = new Core_ProfileAdvanced();
				$myProfileAdvanced->uid = $this->registry->me->id;
				$myProfileAdvanced->type = Core_ProfileAdvanced::TYPE_UNIVERSITY;
				$myProfileAdvanced->text1 = $formData['text1'];
				$myProfileAdvanced->text2 = $formData['text2'];
				$myProfileAdvanced->text3 = (int)$formData['text3'];
				$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
				if($formData['tonow'] == 1)
					$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
				else
					$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
					
				if($myProfileAdvanced->addData())
				{
					$message = $this->registry->lang['controller']['succProfileitemAdd'];
					$success = 1;
					$moreMessage = '<id>'.$myProfileAdvanced->id.'</id>';
				}
				else
				{
					$message = $this->registry->lang['controller']['errProfileitemAdd'];
				}
				
			}
		}
		elseif($formData['type'] == 'school')
		{
			if($this->validateAddSchool($formData, $error, true))
			{
				$myProfileAdvanced = new Core_ProfileAdvanced();
				$myProfileAdvanced->uid = $this->registry->me->id;
				$myProfileAdvanced->type = Core_ProfileAdvanced::TYPE_SCHOOL;
				$myProfileAdvanced->text1 = $formData['text1'];
				$myProfileAdvanced->text2 = (int)$formData['text2'];
				$myProfileAdvanced->text3 = (int)$formData['text3'];
				$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
				if($formData['tonow'] == 1)
					$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
				else
					$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
					
				if($myProfileAdvanced->addData())
				{
					$message = $this->registry->lang['controller']['succProfileitemAdd'];
					$success = 1;
					$moreMessage = '<id>'.$myProfileAdvanced->id.'</id>';
				}
				else
				{
					$message = $this->registry->lang['controller']['errProfileitemAdd'];
				}
				
			}
		}
		elseif($formData['type'] == 'other')
		{
			if($this->validateAddOtherfield($formData, $error, true))
			{
				$myProfileAdvanced = new Core_ProfileAdvanced();
				$myProfileAdvanced->uid = $this->registry->me->id;
				$myProfileAdvanced->type = Core_ProfileAdvanced::TYPE_OTHER;
				$myProfileAdvanced->text1 = $formData['text1'];
				$myProfileAdvanced->text2 = $formData['text2'];
				
				if($myProfileAdvanced->addData())
				{
					$message = $this->registry->lang['controller']['succProfileitemAdd'];
					$success = 1;
					$moreMessage = '<id>'.$myProfileAdvanced->id.'</id>';
				}
				else
				{
					$message = $this->registry->lang['controller']['errProfileitemAdd'];
				}
				
			}
		}
		else
		{
			$message = 'Invalid parameter.';
		}
		
		if(!empty($error))
			$message = implode('. ', $error);
			
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}
	
	public function edititemAction()
	{
		$success = 0;
		$message = '';
		
		$profileitemid = (int)$_GET['id'];
		$myProfileAdvanced = new Core_ProfileAdvanced($profileitemid);
		if($myProfileAdvanced->id == 0 || $myProfileAdvanced->uid != $this->registry->me->id)
		{
			$message = $this->registry->lang['controller']['errProfileitemNotfound'];
		}
		else
		{
			$formData = $_POST;
		
			//filter data
			foreach($formData as $k => $v)
				$formData[$k] == strip_tags(trim($v));
			
			//xu ly them work
			if($formData['type'] == 'work' && $myProfileAdvanced->type == Core_ProfileAdvanced::TYPE_WORK)
			{
				if($this->validateAddWork($formData, $error, true))
				{
					$myProfileAdvanced->text1 = $formData['text1'];
					$myProfileAdvanced->text2 = $formData['text2'];
					$myProfileAdvanced->text3 = (int)$formData['text3'];
					$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
					if($formData['tonow'] == 1)
						$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
					else
						$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
						
					if($myProfileAdvanced->updateData())
					{
						$message = $this->registry->lang['controller']['succProfileitemEdit'];
						$success = 1;
					}
					else
					{
						$message = $this->registry->lang['controller']['errProfileitemEdit'];
					}
					
				}
			}
			elseif($formData['type'] == 'university' && $myProfileAdvanced->type == Core_ProfileAdvanced::TYPE_UNIVERSITY)
			{
				if($this->validateAddUniversity($formData, $error, true))
				{
					$myProfileAdvanced->text1 = $formData['text1'];
					$myProfileAdvanced->text2 = $formData['text2'];
					$myProfileAdvanced->text3 = (int)$formData['text3'];
					$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
					if($formData['tonow'] == 1)
						$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
					else
						$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
						
					if($myProfileAdvanced->updateData())
					{
						$message = $this->registry->lang['controller']['succProfileitemEdit'];
						$success = 1;
					}
					else
					{
						$message = $this->registry->lang['controller']['errProfileitemEdit'];
					}
				}
			}
			elseif($formData['type'] == 'school' && $myProfileAdvanced->type == Core_ProfileAdvanced::TYPE_SCHOOL)
			{
				if($this->validateAddSchool($formData, $error, true))
				{
					$myProfileAdvanced->text1 = $formData['text1'];
					$myProfileAdvanced->text2 = (int)$formData['text2'];
					$myProfileAdvanced->text3 = (int)$formData['text3'];
					$myProfileAdvanced->date1 = $this->addBuildDateString($formData['fromyear'], $formData['frommonth']);
					if($formData['tonow'] == 1)
						$myProfileAdvanced->date2 = $this->addBuildDateString(0, 0);
					else
						$myProfileAdvanced->date2 = $this->addBuildDateString($formData['toyear'], $formData['tomonth']);
						
					if($myProfileAdvanced->updateData())
					{
						$message = $this->registry->lang['controller']['succProfileitemEdit'];
						$success = 1;
					}
					else
					{
						$message = $this->registry->lang['controller']['errProfileitemEdit'];
					}
				}
			}
			elseif($formData['type'] == 'other' && $myProfileAdvanced->type == Core_ProfileAdvanced::TYPE_OTHER)
			{
				if($this->validateAddOtherfield($formData, $error, true))
				{
					$myProfileAdvanced->text1 = $formData['text1'];
					$myProfileAdvanced->text2 = $formData['text2'];
					
					if($myProfileAdvanced->updateData())
					{
						$message = $this->registry->lang['controller']['succProfileitemEdit'];
						$success = 1;
					}
					else
					{
						$message = $this->registry->lang['controller']['errProfileitemEdit'];
					}
				}
			}
			else
			{
				$message = 'Invalid parameter.';
			}
		}
		
		if(!empty($error))
			$message = implode('. ', $error);
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
	}
	
	
	public function deleteitemAction()
	{
		$success = 0;
		$message = '';
		
		$profileitemid = (int)$_GET['id'];
		$myProfileAdvanced = new Core_ProfileAdvanced($profileitemid);

		if($myProfileAdvanced->id == 0 || $myProfileAdvanced->uid != $this->registry->me->id)
		{
			$message = $this->registry->lang['controller']['errProfileitemNotfound'];
		}
		else
		{
			if($myProfileAdvanced->delete())
			{
				$success = 1;
				$message = $this->registry->lang['controller']['succDeleteProfileitem'];
			}
			else
			{
				$message = $this->registry->lang['controller']['errDeleteProfileitem'];
			}
		}
		
		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
	}
	
	
	public function avataruploadAction()
	{
		if($this->registry->me->avatar != '')
		{
			//redirect to edit photo
			header('location:' . $this->registry->conf['rooturl_profile'] . 'account/avatareditor');
		}
		
		$error = array();

		if(isset($_POST['fsubmit']))
		{
			//accepted file size
			$maxFileSize = $this->registry->setting['avatar']['imageMaxSize'];
			$validMimetype = array('image/gif', 'image/jpeg', 'image/png'); 
			
			if($_FILES['fimage']['size'] < $maxFileSize && in_array($_FILES['fimage']['type'], $validMimetype))
			{
				$curDateDir = Helper::getCurrentDateDirName();  //path format: ../2009/September/  
				$extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
				$namePart =  Helper::codau2khongdau($this->registry->me->fullname . '-' . $this->registry->me->id, true, true) . '-' . time();
				$name = $namePart . '.' . $extPart;
				
				$uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $this->registry->setting['avatar']['imageDirectory'] . $curDateDir);
				
				$uploadError = $uploader->upload(false, $name);
				
				if($uploadError != Uploader::ERROR_UPLOAD_OK)
				{
					switch($uploadError)
					{
						case Uploader::ERROR_FILESIZE: $error[] = $this->registry->lang['global']['errUploadFileSize']; break;
						case Uploader::ERROR_FILETYPE: $error[] = $this->registry->lang['global']['errUploadFileType']; break;
						case Uploader::ERROR_PERMISSION: $error[] = $this->registry->lang['global']['errUploadFilePermission']; break;
						default: $error[] = $this->registry->lang['global']['errUploadFileUnknown']; break;
					}
				}
				else
				{
					//update database
					$this->registry->me->avatar = $curDateDir . $name;
					$this->registry->me->updateAvatar();
					$this->registry->me->postProcessingAvatar($curDateDir, $name);
					
					//redirect to crop page
					header('location: ' . $this->registry->conf['rooturl_profile'] . 'account/avatareditor');
				}
			}
			else
			{
				$error[] = $this->registry->lang['controller']['errAvatarInvalid'];
			}	  
		}	
		
		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
												'error' 	=> $error,
												));
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'avatarupload.tpl'); 
	}
	
	public function avatarwebcamAction()
	{
		if($this->registry->me->avatar != '')
		{
			//redirect to edit photo
			header('location:' . $this->registry->conf['rooturl_profile'] . 'account/avatareditor');
		}
		
		if(isset($_POST['bindata']))
		{
			$img_data = base64_decode($_POST["bindata"]);
			
			if(strlen($img_data) < $this->registry->setting['avatar']['imageMaxSize'])
			{
				$curDateDir = Helper::getCurrentDateDirName();  //path format: ../2009/September/  
				$extPart = 'jpg';
				$namePart =  Helper::codau2khongdau($this->registry->me->fullname . '-' . $this->registry->me->id, true, true) . '-' . time();
				$name = $namePart . '.' . $extPart;
				$fullImagePath = $this->registry->setting['avatar']['imageDirectory'] . $curDateDir . $name;
				if(!file_exists($this->registry->setting['avatar']['imageDirectory'].$curDateDir) && !is_dir($this->registry->setting['avatar']['imageDirectory'].$curDateDir))
				{
					mkdir($this->registry->setting['avatar']['imageDirectory'].$curDateDir, 0777, true);
				}
				
				$fh_img = fopen($fullImagePath, "w") or die("Error: can't create file");
				fwrite($fh_img, $img_data);
				fclose($fh_img);
				
				//check correct jpg type
				list($imagewidth, $imageheight, $imageType) = getimagesize($fullImagePath);
				$imageType = image_type_to_mime_type($imageType);
				if($imageType != 'image/pjpeg' && $imageType != 'image/jpeg' && $imageType != 'image/jpg')
				{
					echo 'Error: Image Type is not correct. Capture again.';
				}
				else
				{
					//update database
					$this->registry->me->avatar = $curDateDir . $name;
					$this->registry->me->updateAvatar();
					$this->registry->me->postProcessingAvatar($curDateDir, $name);
					
											
					//echo "$img_size bytes uploaded.";
					echo 'redirect:'. $this->registry->conf['rooturl_profile'] . 'account/avatareditor';
				}
				
			}
			else
			{
				echo $this->registry->lang['controller']['errAvatarWebcamSize'];
			}	  
		}
		else
		{
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'avatarwebcam.tpl');	
		}
	}
	
	public function avatareditorAction()
	{
		if($this->registry->me->avatar == '')
		{
			//redirect to upload photo
			header('location:' . $this->registry->conf['rooturl_profile'] . 'account/avatarupload');
		}
		else
		{
			$error = array();
			$name = $this->registry->me->avatar;
			$fullImagePath = $imagefile = $endImage = $this->registry->setting['avatar']['imageDirectory'] . $name;
			list($imagewidth, $imageheight, $imageType) = getimagesize($imagefile);
			
			if(isset($_POST['fsavethumbnail']))
			{
				$x1 = intval($_POST["x1"]);
				$y1 = intval($_POST["y1"]);
				$x2 = intval($_POST["x2"]);
				$y2 = intval($_POST["y2"]);
				$w = intval($_POST["w"]);
				$h = intval($_POST["h"]);
				
				list($width, $height, $type, $attr) = getimagesize($imagefile);
				if($w > $width || $h > $height)
				{
					$error[] = 'Image size is not correct.';
				}
				else
				{
					//Crop and apply to Medium Image
					$croppedImage = new ImageCropper($this->registry->setting['avatar']['imageDirectory'] . $this->registry->me->mediumImage(), $imagefile, $w, $h, $x1, $y1, 1);
					if($croppedImage->cropPass)
					{
						//Resize Medium & apply to thumb image
						$this->registry->me->postCroppingAvatar();
						
						//clear cache for this user
						Core_User::cacheDelete($this->registry->me->id);
						
						$this->registry->smarty->display($this->registry->smartyControllerContainer.'avatareditor_success.tpl'); 
						exit();
					}
					else
					{
						$error[] = 'Error while cropping your image. Please try again.';
					}
				}
			}
			
			$this->registry->smarty->assign(array(	'name' 	=> $name,
													'fullImagePath' => $fullImagePath,
													'imagewidth' => $imagewidth,
													'imageheight' => $imageheight,
													'error' 	=> $error,
													));
			$this->registry->smarty->display($this->registry->smartyControllerContainer.'avatareditor.tpl'); 
		}
	}
	########################################################################
	########################################################################
	########################################################################
	
	protected function submitAccountValidator($formData, &$error)
	{
		$pass = true;
		
		//check password length
		if(strlen($formData['ffullname']) < 6)
		{
			$error[] =  $this->registry->lang['controller']['errFullnameRequired'];   
			$pass = false;
		}
		
		
		
				
		
		return $pass;
	}
	
	protected function submitInfoValidator($formData, &$error)
	{
		$pass = true;
		
		
		
		if($formData['fgender'] != '' && $formData['fgender'] != Core_User::GENDER_MALE && $formData['fgender'] != Core_User::GENDER_FEMALE)
        {
        	$error[] = $this->registry->lang['controller']['errGenderInvalid'];
            $pass = false;
		}
		
		//check if input birthday
		if(strlen($formData['fbirthday']) > 0)
		{
			if(!preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $formData['fbirthday'], $match))
			{
				$error[] = $this->registry->lang['controller']['errBirthdayFormat'];   
				$pass = false;	
			}
			else
			{
				if(!checkdate($match[2], $match[1], $match[3]) || mktime(0, 0, 1, $match[2], $match[1], $match[3]) > time())
				{
					$error[] = $this->registry->lang['controller']['errBirthdayFormat'];   
					$pass = false;	
				}
			}
		}
		
		//check valid fav-category
		/*
		$validCategoryId = array();
		for($i = 0; $i < count($formData['fstaticshelves']); $i++)
		{
			$validCategoryId[] = $formData['fstaticshelves'][$i]->id;
		}
		
		$tmpCategories = array();
		for($i = 0; $i < count($formData['fcategory']); $i++)
		{
			if(!is_numeric($formData['fcategory'][$i]))
			{
				//invalid category id number
				$error[] =  $this->registry->lang['controller']['errCategoryValue'];   
				$pass = false;
			}
			else
			{
				if(in_array($formData['fcategory'][$i], $tmpCategories))
				{
					//duplicate category id
					$error[] =  $this->registry->lang['controller']['errCategoryValue'];   
					$pass = false;
				}
				elseif(!in_array($formData['fcategory'][$i], $validCategoryId))
				{
					//not static shelves
					$error[] =  $this->registry->lang['controller']['errCategoryValue'];   
					$pass = false;	
				}
			}
		}		
		*/
		
				
		
		
		return $pass;
	}
	
	
	protected function submitPasswordValidator($formData, &$error)
	{
		$pass = true;
		
		//check oldpass
		//change password
		if(!viephpHashing::authenticate($formData['foldpass'], $this->registry->me->password))
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errOldpassNotvalid'];
		}
		
		
		
		if(strlen($formData['fnewpass1']) < 6)
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotvalid'];
		}	
		
		if($formData['fnewpass1'] != $formData['fnewpass2'])
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotmatch'];
		}
				
		return $pass;
	}
	
	
	
	protected function submitPasswordNewValidator($formData, &$error)
	{
		$pass = true;
		
		if(strlen($formData['fnewpass1']) < 6)
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotvalid'];
		}	
		
		if($formData['fnewpass1'] != $formData['fnewpass2'])
		{
			$pass = false;
			$this->registry->me->newpass = '';
			$error[] = $this->registry->lang['controller']['errNewpassnotmatch'];
		}
				
		return $pass;
	}
	
	/**
	* Xay dung string theo format yyyy-mm-dd de insert vao cac cot field cua profile advanced
	* 
	* @param mixed $year
	* @param mixed $month
	*/
	protected function addBuildDateString($year, $month)
	{
		$out = '';
		
		if($year > 0 && $month == 0)
			$out = $year . '-00-00';
		elseif($year > 0 && $month > 0)
			$out = $year . '-' . $month . '-00';
		else
		{
			$out = '0000-00-00';
		}
		
		return $out;
	}
	
	/**
	* Kiem tra xem viec submit mot record working co hop le khong
	* 
	* @param mixed $formData
	* @param mixed $error
	*/
	protected function validateAddWork($formData, &$error, $ignorecheckquota = false)
	{
		$pass = true;
		
		if(!$ignorecheckquota)
		{
			//count max work record
			$count = Core_ProfileAdvanced::getProfiles(array('fuserid' => $this->registry->me->id, 'ftype' => Core_ProfileAdvanced::TYPE_WORK), '', '', '', true);
			if($count >= $this->registry->setting['profile']['maxrecordWork'])
			{
				$pass = false;
				$error[] = str_replace('###VALUE###', $this->registry->setting['profile']['maxrecordWork'], $this->registry->lang['controller']['errWorkQuota']);
			}
		}
		
		if(strlen($formData['text1']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errWorkCompany'];
		}
		
		if($formData['text3'] != '0' && !isset($this->registry->setting['region'][$formData['text3']]))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errWorkLocation'];
		}
		
		$dateinfo = getdate();
		if(($formData['fromyear'] != 0 && $formData['fromyear'] > $dateinfo['year']) || ($formData['toyear'] != 0 && $formData['toyear'] > $dateinfo['year']))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errYear'];
		}
		
		if($formData['frommonth'] > 12 || $formData['frommonth'] < 0 || $formData['tomonth'] > 12 || $formData['tomonth'] < 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errMonth'];
		}
		
		
		
		
		return $pass;
	}
	
	
	/**
	* Kiem tra xem viec submit mot record university co hop le khong
	* 
	* @param mixed $formData
	* @param mixed $error
	*/
	protected function validateAddUniversity($formData, &$error, $ignorecheckquota = false)
	{
		$pass = true;
		
		if(!$ignorecheckquota)
		{
			//count max work record
			$count = Core_ProfileAdvanced::getProfiles(array('fuserid' => $this->registry->me->id, 'ftype' => Core_ProfileAdvanced::TYPE_UNIVERSITY), '', '', '', true);
			if($count >= $this->registry->setting['profile']['maxrecordUniversity'])
			{
				$pass = false;
				$error[] = str_replace('###VALUE###', $this->registry->setting['profile']['maxrecordUniversity'], $this->registry->lang['controller']['errUniversityQuota']);
			}
		}
		
		if(strlen($formData['text1']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errUniversityName'];
		}
		
		if($formData['text3'] != '0' && !isset($this->registry->setting['region'][$formData['text3']]))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errUniversityLocation'];
		}
		
		$dateinfo = getdate();
		if(($formData['fromyear'] != 0 && $formData['fromyear'] > $dateinfo['year']) || ($formData['toyear'] != 0 && $formData['toyear'] > $dateinfo['year']))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errYear'];
		}
		
		if($formData['frommonth'] > 12 || $formData['frommonth'] < 0 || $formData['tomonth'] > 12 || $formData['tomonth'] < 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errMonth'];
		}
		
		
		
		
		return $pass;
	}
	
	
	/**
	* Kiem tra xem viec submit mot record school co hop le khong
	* 
	* @param mixed $formData
	* @param mixed $error
	*/
	protected function validateAddSchool($formData, &$error, $ignorecheckquota = false)
	{
		$pass = true;
		
		if(!$ignorecheckquota)
		{
			//count max work record
			$count = Core_ProfileAdvanced::getProfiles(array('fuserid' => $this->registry->me->id, 'ftype' => Core_ProfileAdvanced::TYPE_SCHOOL), '', '', '', true);
			if($count >= $this->registry->setting['profile']['maxrecordSchool'])
			{
				$pass = false;
				$error[] = str_replace('###VALUE###', $this->registry->setting['profile']['maxrecordSchool'], $this->registry->lang['controller']['errSchoolQuota']);
			}
		}
		
		if(strlen($formData['text1']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSchoolName'];
		}
		
		//check schooltype
		if($formData['text2'] < 1 || $formData['text2'] > 5)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSchooltypeInvalid'];
		}
		
		if($formData['text3'] != '0' && !isset($this->registry->setting['region'][$formData['text3']]))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errUniversityLocation'];
		}
		
		$dateinfo = getdate();
		if(($formData['fromyear'] != 0 && $formData['fromyear'] > $dateinfo['year']) || ($formData['toyear'] != 0 && $formData['toyear'] > $dateinfo['year']))
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errYear'];
		}
		
		if($formData['frommonth'] > 12 || $formData['frommonth'] < 0 || $formData['tomonth'] > 12 || $formData['tomonth'] < 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errMonth'];
		}
		
		return $pass;
	}
	
	
	/**
	* Kiem tra xem viec submit mot record other field co hop le khong
	* 
	* @param mixed $formData
	* @param mixed $error
	*/
	protected function validateAddOtherfield($formData, &$error, $ignorecheckquota = false)
	{
		$pass = true;
		
		if(!$ignorecheckquota)
		{
			//count max work record
			$count = Core_ProfileAdvanced::getProfiles(array('fuserid' => $this->registry->me->id, 'ftype' => Core_ProfileAdvanced::TYPE_OTHER), '', '', '', true);
			if($count >= $this->registry->setting['profile']['maxrecordOtherfield'])
			{
				$pass = false;
				$error[] = str_replace('###VALUE###', $this->registry->setting['profile']['maxrecordOtherfield'], $this->registry->lang['controller']['errOtherfieldQuota']);
			}
		}
		
		if(strlen($formData['text1']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errOtherfieldName'];
		}
		
		if(strlen($formData['text2']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errOtherfieldValue'];
		}
		
		
		return $pass;
	}
	
	
}


