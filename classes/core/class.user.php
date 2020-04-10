<?php

Class Core_User extends Core_Object
{
	const PRIVACY_ME = 1;
	const PRIVACY_FRIEND = 2;
	const PRIVACY_GROUP = 4;
	const PRIVACY_INTERNET = 8;

	const OAUTH_PARTNER_EMPTY = 0;
	const OAUTH_PARTNER_FACEBOOK = 1;
	const OAUTH_PARTNER_YAHOO = 2;
	const OAUTH_PARTNER_GOOGLE = 3;
	const OAUTH_PARTNER_NOIBOTHEGIOIDIDONG = 4;
	const OAUTH_PARTNER_DIENMAYCRM = 5;

	const GENDER_UNKNOWN = 0;
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;

	public $id = 0;
	public $screenname = '';
	public $fullname = '';
	public $avatar = '';
	public $avatarCurrent = '';
	public $groupid = 0;
	public $gender = 'unknown';
	public $region = 0;

	public $countFollowing = 0;
	public $countFollower = 0;
	public $countFile = 0;
	public $countBlog = 0;

	public $view = 0;
	public $datelastaction = 0;
	public $email = '';
	public $password = '';
	public $birthday = '';
	public $phone = '';
	public $address = '';
	public $city = '';
	public $country = 'VN';
	public $website = '';
	public $bio = '';
	public $privacyBinary = 0;
	public $favouriteCategory = '';
	public $activatedcode = '';
	public $datecreated = 0;
	public $datemodified = 0;
	public $datelastlogin = 0;
	public $coverimage = '';
	public $parentid = 0;	//used for department
	public $district = 0;


	public $newfriendrequest = 0;
	public $newnotification = 0;
	public $newmessage = 0;

	public $oauthPartner = 0;
	public $oauthUid = 0;
	public $ipaddress = '';	//dia chi IP register user

	public $newpass = '';
	public $sessionid = '';
	public $userpath = '';
	public $followinglist = array();
	public $personalid =0;
	public function __construct($id = 0, $loadFromCache = false)
	{
		parent::__construct();
		$this->sessionid = session_id();

		if($id > 0)
		{
			if($loadFromCache)
				$this->cloneObject(self::cacheGet($id));
			else
				$this->getData($id);
		}


	}

	public function checkPerm()
	{
		global $registry, $groupPermisson, $smarty;

		//echo $GLOBALS['controller_group'] . '<br />';
		//echo $GLOBALS['controller'] . '<br />';
		//echo $GLOBALS['action'] . '<br />';
		//echo $this->groupid . '<br />';

		//print_r($groupPermisson[$this->groupid][$GLOBALS['controller_group']]);
		//var_dump(!in_array($GLOBALS['controller'].'_*', $groupPermisson[$this->groupid][$GLOBALS['controller_group']]));
		//exit();

		$controllerGroup = $GLOBALS['controller_group'];
		$controller = $GLOBALS['controller'];


		if(!isset($groupPermisson[$this->groupid][$controllerGroup]) || (!in_array($controller.'_'.$GLOBALS['action'], $groupPermisson[$this->groupid][$controllerGroup]) && !in_array($controller.'_*', $groupPermisson[$this->groupid][$controllerGroup])))
		{
			if(in_array($controllerGroup, array('admin', 'cms', 'crm', 'erp', 'profile')))
			{
				//if not login
				if($this->id == 0)
				{
					$redirectUrl = $registry->conf['rooturl'].substr($_SERVER['REQUEST_URI'],1);

					header('location: '.$registry->conf['rooturl'].'admin/login?refer=1&redirect=' . base64_encode($redirectUrl));
					exit();
				}
				else
				{
					header('location: ' . $registry->conf['rooturl_admin'] . 'notpermission');
					exit();
				}
			}


			//disable notpermission, just return 404 error
			//header('location: ' . $registry->conf['rooturl'] . 'notpermission?r=' . base64_encode(Helper::curPageURL()));
			header('HTTP/1.0 404 Not Found');
			readfile('./404.html');

			exit();
		}
	}

	/**
	* Lay thong tin user tu session (danh cho user da login hoac su dung remember me
	*
	*/
	public function updateFromSession()
	{
		global $registry, $setting;

		if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] > 0)
		{

			//New way
			$userid = (int)$_SESSION['userLogin'];
			$myCacher = new Cacher('userdetail_' . $userid);
			$userInfo = $myCacher->get();
			if(!$userInfo || isset($_GET['live']))
			{
				$sql = 'SELECT * FROM lit_ac_user u
						INNER JOIN lit_ac_user_profile up ON u.u_id = up.u_id
						WHERE u.u_id = ?';
				$userInfo = $this->db->query($sql, array($userid))->fetch();
				$myCacher->set($userInfo, 3600);
			}

			$this->getByArray($userInfo);

			//Old way
			//$this->getData($_SESSION['userLogin']);
		}
		else
		{
			//"remember me" function
			if(isset($_COOKIE['myHashing']) && strlen($_COOKIE['myHashing']) > 0)
			{
				$cookieRememberMeInfo = viephpHashing::cookiehasingParser($_COOKIE['myHashing']);


				$this->getData($cookieRememberMeInfo['userid']);



				if(viephpHashing::authenticateCookiehashing($cookieRememberMeInfo['shortPasswordString'], $this->password))
				{
					session_regenerate_id(true);

					////////////////////////////////////////////////////////////////////////////////////
					//UPDATE LAST LOGIN TIME
					$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile
							SET up_datelastlogin = ?
							WHERE u_id = ?
							LIMIT 1';
					$this->db->query($sql, array(time(), $this->id));

					$_SESSION['userLogin'] = $this->id;
					$_SESSION['loginauto'] = 1;

					//tracking stat for login remember
					$myStat = new Core_StatHook();
					$myStat->uid = $this->id;
					$myStat->type = Core_StatHook::TYPE_LOGIN_REMEMBER;
					$myStat->addData();
				}
			}//end remember me
			elseif($registry->controllerGroup == 'ws' || $registry->controllerGroup == 'wse')
			{
				//because the machenism of webservice request from mobile (non-session access)
				//we must use the $_GET['s'] or $_POST['s'] to verify user session
				$mobilesessionid = '';
				if(isset($_GET['s']))
					$mobilesessionid = $_GET['s'];
				elseif(isset($_POST['s']))
					$mobilesessionid = $_POST['s'];

				if(!empty($mobilesessionid))
				{
					$myMobileSession = new Core_Backend_MSession();
					$myMobileSession->getDataBySession($mobilesessionid);

					//This device logged in account
					if($myMobileSession->id > 0)
					{
						$registry->mobilesessionid = $mobilesessionid;

						if($myMobileSession->uid > 0)
							$this->getData($myMobileSession->uid);
					}
				}
			}//end check webservice
		}
	}

	public function addData()
	{
		global $registry, $setting;

		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user (u_screenname, u_fullname, u_groupid, u_region, u_gender, u_parentid)
				VALUES(?, ?, ?, ?, ?, ?)';

		$this->db->query($sql, array(
			(string)$this->screenname,
			(string)$this->fullname,
			(int)$this->groupid,
			(int)$this->region,
			(int)$this->gender,
			(int)$this->parentid,
			));

		$this->id = $this->db->lastInsertId();

		if($this->id > 0)
		{
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user_profile (
						u_id,
						up_email,
						up_password,
						up_birthday,
						up_phone,
						up_address,
						up_city,
						up_country,
						up_bio,
						up_privacy_binary,
						up_favouritecategory,
						up_activatedcode,
						up_datecreated,
						up_oauth_partner,
						up_oauth_uid,
						up_ipaddress,
						up_personalid,
						up_district
						)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?)';
			$this->db->query($sql, array(
		    		(int)$this->id,
		    		(string)$this->email,
		    		(string)$this->password,
					(string)$this->birthday,
		    		(string)$this->phone,
		    		(string)$this->address,
		    		(string)$this->city,
		    		(string)$this->country,
		    		(string)$this->bio,
		    		(int)$this->privacyBinary,
		    		(string)$this->favouriteCategory,
		    		(string)$this->activatedcode,
		    		(int)$this->datecreated,
		    		(int)$this->oauthPartner,
		    		(string)$this->oauthUid,
		    		Helper::getIpAddress(true),
                    $this->personalid,
					(int)$this->district
				));

			//set to download from remote image
			if(strpos($this->avatar, 'https') === 0)
	        {

	            $originalImagePath = $this->avatar;
		        $curDateDir = Helper::getCurrentDateDirName();
			    $extPart = substr(strrchr($originalImagePath,'.'),1);
			    $namePart =  $this->id . time();
			    $name = $namePart . '.' . $extPart;
			    $fullpath = $registry->setting['avatar']['imageDirectory'] . $curDateDir . $name;

			    //check existed directory
			    if(!file_exists($registry->setting['avatar']['imageDirectory'] . $curDateDir))
			    {
					mkdir($registry->setting['avatar']['imageDirectory'] . $curDateDir, 0777, true);
			    }


		        if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
		        {
					//Resize big image if needed
			        $myImageResizer = new ImageResizer( $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
			                                            $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
			                                            $registry->setting['avatar']['imageMaxWidth'],
			                                            $registry->setting['avatar']['imageMaxHeight'],
			                                            '1:1',
			                                            $registry->setting['avatar']['imageQuality']);
			        $myImageResizer->output();
			        unset($myImageResizer);

			        //Create medium image
					$nameMediumPart = substr($name, 0, strrpos($name, '.'));
					$nameMedium = $nameMediumPart . '-medium.' . $extPart;
					$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
														$registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameMedium,
														$registry->setting['avatar']['imageMediumWidth'],
														$registry->setting['avatar']['imageMediumHeight'],
														'1:1',
														$registry->setting['avatar']['imageQuality']);
					$myImageResizer->output();
					unset($myImageResizer);

			        //Create thumb image
			        $nameThumbPart = substr($name, 0, strrpos($name, '.'));
			        $nameThumb = $nameThumbPart . '-small.' . $extPart;
			        $myImageResizer = new ImageResizer(    $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
				                                            $registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameThumb,
				                                            $registry->setting['avatar']['imageThumbWidth'],
				                                            $registry->setting['avatar']['imageThumbHeight'],
				                                            '1:1',
				                                            $registry->setting['avatar']['imageQuality']);
			        $myImageResizer->output();
			        unset($myImageResizer);

			        //update database
			        $this->avatar = $curDateDir . $name;
			        $this->updateAvatar();
		        }
		        else
		        {
		        	$this->avatar = '';
				}
			}//end download avatar
		}

		return $this->id;
	}

	public function updateData($moreFields = array(), &$error = array())
	{
		global $registry;

		$this->datemodified = time();
		if(
			(isset($moreFields['fullname']) && strcmp($this->fullname, $moreFields['fullname']) != 0) ||
			(isset($moreFields['screenname']) && strcmp($this->screenname, $moreFields['screenname']) != 0) ||
			(isset($moreFields['groupid']) && $this->groupid != $moreFields['groupid']) ||
			(isset($moreFields['region']) && $this->region != $moreFields['region']) ||
			(isset($moreFields['gender']) && $this->gender != $moreFields['gender']) ||
			(isset($moreFields['parentid']) && $this->parentid != $moreFields['parentid']) ||
			(isset($moreFields['datelastaction']) && $this->datelastaction != $moreFields['datelastaction'])
		)
		{
			if(isset($moreFields['screenname']))
				$this->screenname = strtolower($moreFields['screenname']);

			if(isset($moreFields['fullname']))
				$this->fullname = $moreFields['fullname'];

			if(isset($moreFields['groupid']))
				$this->groupid = (int)$moreFields['groupid'];

			if(isset($moreFields['region']))
				$this->region = (int)$moreFields['region'];

			if(isset($moreFields['gender']))
				$this->gender = (int)$moreFields['gender'];

			if(isset($moreFields['datelastaction']))
				$this->datelastaction = (int)$moreFields['datelastaction'];

			if(isset($moreFields['parentid']))
				$this->parentid = (int)$moreFields['parentid'];


			$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
					SET u_screenname = ?,
						u_fullname = ?,
						u_groupid = ?,
						u_region = ?,
						u_gender = ?,
						u_datelastaction = ?,
						u_parentid = ?
					WHERE u_id = ?
					LIMIT 1';
			$this->db->query($sql, array(
				(string)$this->screenname,
				(string)$this->fullname,
				(int)$this->groupid,
				(int)$this->region,
				(int)$this->gender,
				(int)$this->datelastaction,
				(int)$this->parentid,
				$this->id));
		}
	;
		$moreupdate = '';
		if(strlen($this->newpass) > 0)
			$moreupdate = 'up_password = "'.viephpHashing::hash($this->newpass).'" ,';
		//update profile table
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile
        		SET '.$moreupdate.'
        			up_email = ?,
        			up_birthday = ?,
        			up_phone = ?,
        			up_address = ?,
        			up_city = ?,
        			up_country = ?,
        			up_website = ?,
        			up_bio = ?,
        			up_privacy_binary = ?,
        			up_favouritecategory = ?,
        			up_activatedcode = ?,
        			up_datemodified = ? ,
        			up_personalid = ?,
        			up_oauth_partner = ?,
					up_oauth_uid = ?,
        			up_district = ?
        		WHERE u_id = ?';

		$stmt = $this->db->query($sql, array(
		    (string)$this->email,
		    (string)$this->birthday,
		    (string)$this->phone,
		    (string)$this->address,
		    (string)$this->city,
		    (string)$this->country,
		    (string)$this->website,
		    (string)$this->bio,
		    (string)$this->privacyBinary,
		    (string)$this->favouriteCategory,
		    (string)$this->activatedcode,
		    (int)$this->datemodified,
            (string)$this->personalid,
            (int)$this->oauthPartner,
            (int)$this->oauthUid,
			(int)$this->district,
		    (int)$this->id
		));


		if($stmt->rowCount() > 0)
		{
			//set to download from remote image
			if(strpos($this->avatar, 'https') === 0)
	        {

	            $originalImagePath = $this->avatar;
		        $curDateDir = Helper::getCurrentDateDirName();
			    $extPart = substr(strrchr($originalImagePath,'.'),1);
			    $namePart =  $this->id . time();
			    $name = $namePart . '.' . $extPart;
			    $fullpath = $registry->setting['avatar']['imageDirectory'] . $curDateDir . $name;

			    //check existed directory
			    if(!file_exists($registry->setting['avatar']['imageDirectory'] . $curDateDir))
			    {
					mkdir($registry->setting['avatar']['imageDirectory'] . $curDateDir, 0777, true);
			    }


		        if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
		        {
					//Resize big image if needed
			        $myImageResizer = new ImageResizer( $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
			                                            $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
			                                            $registry->setting['avatar']['imageMaxWidth'],
			                                            $registry->setting['avatar']['imageMaxHeight'],
			                                            '1:1',
			                                            $registry->setting['avatar']['imageQuality']);
			        $myImageResizer->output();
			        unset($myImageResizer);

			        //Create medium image
					$nameMediumPart = substr($name, 0, strrpos($name, '.'));
					$nameMedium = $nameMediumPart . '-medium.' . $extPart;
					$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
														$registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameMedium,
														$registry->setting['avatar']['imageMediumWidth'],
														$registry->setting['avatar']['imageMediumHeight'],
														'1:1',
														$registry->setting['avatar']['imageQuality']);
					$myImageResizer->output();
					unset($myImageResizer);

			        //Create thumb image
			        $nameThumbPart = substr($name, 0, strrpos($name, '.'));
			        $nameThumb = $nameThumbPart . '-small.' . $extPart;
			        $myImageResizer = new ImageResizer(    $registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
				                                            $registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameThumb,
				                                            $registry->setting['avatar']['imageThumbWidth'],
				                                            $registry->setting['avatar']['imageThumbHeight'],
				                                            '1:1',
				                                            $registry->setting['avatar']['imageQuality']);
			        $myImageResizer->output();
			        unset($myImageResizer);

			        //update database
			        $this->avatar = $curDateDir . $name;
			        $this->updateAvatar();
		        }
		        else
		        {
		        	$this->avatar = '';
				}
			}//end download avatar

			//Clear detail cache
			$myCacher = new Cacher('userdetail_' . $this->id);
			$myCacher->clear();

			return true;
		}
		else
			return false;

	}


	/**
	* Resize avatar goc hoac tao cac phien ban thu nho cua avatar
	*
	*/
	public function postProcessingAvatar($curDateDir, $name)
	{
		global $registry;

		$extPart = Helper::fileExtension($name);

		//Resize big image if needed
		$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
											$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
											$registry->setting['avatar']['imageMaxWidth'],
											$registry->setting['avatar']['imageMaxHeight'],
											'',
											$registry->setting['avatar']['imageQuality']);
		$myImageResizer->output();
		unset($myImageResizer);

		//Create medium image
		$nameMediumPart = substr($name, 0, strrpos($name, '.'));
		$nameMedium = $nameMediumPart . '-medium.' . $extPart;
		$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
											$registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameMedium,
											$registry->setting['avatar']['imageMediumWidth'],
											$registry->setting['avatar']['imageMediumHeight'],
											'',
											$registry->setting['avatar']['imageQuality']);
		$myImageResizer->output();
		unset($myImageResizer);

		//Create thum image
		$nameThumbPart = substr($name, 0, strrpos($name, '.'));
		$nameThumb = $nameThumbPart . '-small.' . $extPart;
		$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] . $curDateDir, $name,
											$registry->setting['avatar']['imageDirectory'] . $curDateDir, $nameThumb,
											$registry->setting['avatar']['imageThumbWidth'],
											$registry->setting['avatar']['imageThumbHeight'],
											'1:1',
											$registry->setting['avatar']['imageQuality']);
		$myImageResizer->output();
		unset($myImageResizer);
	}

	/**
	* Apply medium and thumb image after crop image
	*
	*/
	public function postCroppingAvatar()
	{
		global $registry;


		//generate new image filename
		$curImage = $this->avatar;

		$extPart = Helper::fileExtension($this->avatar);
		$namePart = Helper::codau2khongdau($this->fullname, true) . '-' . $this->id . '-' . time();
		$newAvatar = $namePart . '.' . $extPart;

		$newAvatarMedium =$namePart . '-medium.' . $extPart;
		$newAvatarSmall =$namePart . '-small.' . $extPart;
		$currentDir = Helper::getCurrentDateDirName();
		if(!file_exists($registry->setting['avatar']['imageDirectory'] . $currentDir))
		{
			mkdir($registry->setting['avatar']['imageDirectory'] . $currentDir, 0777);
		}

		//rename originalimage to new location
		if(rename($registry->setting['avatar']['imageDirectory'] . $this->avatar, $registry->setting['avatar']['imageDirectory'] . $currentDir . $newAvatar))
		{
			//Create medium image
			$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'], $this->mediumImage(),
												$registry->setting['avatar']['imageDirectory'], $currentDir . $newAvatarMedium,
												$registry->setting['avatar']['imageMediumWidth'],
												$registry->setting['avatar']['imageMediumHeight'],
												'',
												$registry->setting['avatar']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//Create thum image
			$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] , $this->mediumImage(),
												$registry->setting['avatar']['imageDirectory'] , $currentDir . $newAvatarSmall,
												$registry->setting['avatar']['imageThumbWidth'],
												$registry->setting['avatar']['imageThumbHeight'],
												'1:1',
												$registry->setting['avatar']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//delete current old medium image
			@unlink($registry->setting['avatar']['imageDirectory'] . $this->mediumImage());
			@unlink($registry->setting['avatar']['imageDirectory'] . $this->thumbImage());

			$this->avatar = $currentDir . $newAvatar;
			//update
			$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user SET u_avatar = ? WHERE u_id = ?';
			$this->db->query($sql, array($this->avatar, $this->id));

		}
		else
		{
			//something wrong with copy, keep original info
			//Create medium image
			$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'], $this->mediumImage(),
												$registry->setting['avatar']['imageDirectory'], $this->mediumImage(),
												$registry->setting['avatar']['imageMediumWidth'],
												$registry->setting['avatar']['imageMediumHeight'],
												'',
												$registry->setting['avatar']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//Create thum image
			$myImageResizer = new ImageResizer(	$registry->setting['avatar']['imageDirectory'] , $this->mediumImage(),
												$registry->setting['avatar']['imageDirectory'] , $this->thumbImage(),
												$registry->setting['avatar']['imageThumbWidth'],
												$registry->setting['avatar']['imageThumbHeight'],
												'1:1',
												$registry->setting['avatar']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);
		}
	}



	public function updateAvatar()
	{
		//update profile table
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
        		SET u_avatar = ?
        		WHERE u_id = ?';

		$this->db->query($sql, array(
			(string)$this->avatar,
			(string)$this->id
		));

		//Clear detail cache
		$myCacher = new Cacher('userdetail_' . $this->id);
		$myCacher->clear();
	}

	public function deleteImage($imagepath = '')
	{
		global $registry;

		//delete current image
		if($imagepath == '')
			$deletefile = $this->avatar;
		else
			$deletefile = $imagepath;

		if(strlen($deletefile) > 0)
		{
			$file = $registry->setting['avatar']['imageDirectory'] . $deletefile;
			if(file_exists($file) && is_file($file))
			{
				@unlink($file);

				//delete thumb image
				$extPart = substr(strrchr($deletefile,'.'),1);
				$nameThumbPart = substr($deletefile, 0, strrpos($deletefile, '.'));
				$nameThumb = $nameThumbPart . '-small.' . $extPart;
				$filethumb = $registry->setting['avatar']['imageDirectory'] . $nameThumb;
				if(file_exists($filethumb) && is_file($filethumb))
				{
					@unlink($filethumb);
				}

				//delete medium image
				$nameMedium = $nameThumbPart . '-medium.' . $extPart;
				$filemedium = $registry->setting['avatar']['imageDirectory'] . $nameMedium;
				if(file_exists($filemedium) && is_file($filemedium))
				{
					@unlink($filemedium);
				}
			}

			//delete current image
			if($imagepath == '')
				$this->avatar = '';

			$this->updateAvatar();
		}
	}

	/**
	* Ngoai viec login thanh cong,
	* tien hanh cap nhat cac thong tin stat cua user nay
	*
	*/
	public function updateLastLogin()
	{
		//update profile table
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile
        		SET up_datelastlogin = ?
        		WHERE u_id = ?';

		$stmt = $this->db->query($sql, array(time(), $this->id));

		if($stmt)
		{


			$this->updateCounting(array());

			//refresh status online
			Core_UserOnline::setonline($this->id);

			return true;
		}else
			return false;
	}


	public function getData($id)
	{
		global $registry;

		$id = (int)$id;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user u
				INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
				WHERE u.u_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();
		$this->id = $row['u_id'];
		$this->screenname = $row['u_screenname'];
		$this->fullname = $row['u_fullname'];
		$this->avatar = $row['u_avatar'];
		$this->groupid = $row['u_groupid'];
		$this->region = $row['u_region'];
		$this->gender = $row['u_gender'];
		$this->countFollowing = $row['u_count_following'];
		$this->countFollower = $row['u_count_follower'];
		$this->countFile = $row['u_count_file'];
		$this->countBlog = $row['u_count_blog'];
		$this->view = $row['u_view'];
		$this->datelastaction = $row['u_datelastaction'];
		$this->coverimage = $row['u_coverimage'];
		$this->parentid = $row['u_parentid'];

		$this->email = $row['up_email'];
		$this->password = $row['up_password'];
		$this->birthday = $row['up_birthday'];
		$this->phone = $row['up_phone'];
		$this->address = $row['up_address'];
		$this->city = $row['up_city'];
		$this->country = $row['up_country'];
		$this->website = Helper::paddingWebsitePrefix($row['up_website']);
		$this->bio = $row['up_bio'];
		$this->privacyBinary = $row['up_privacy_binary'];
		$this->favouriteCategory = $row['up_favouritecategory'];
		$this->activatedcode = $row['up_activatedcode'];
		$this->datecreated = $row['up_datecreated'];
		$this->datemodified = $row['up_datemodified'];
		$this->datelastlogin = $row['up_datelastlogin'];
		$this->newfriendrequest = $row['up_newfriendrequest'];
		$this->newnotification = $row['up_newnotification'];
		$this->newmessage = $row['up_newmessage'];
		$this->oauthPartner = $row['up_oauth_partner'];
		$this->oauthUid = $row['up_oauth_uid'];
		$this->personalid = $row['up_personalid'];
		$this->district = $row['up_district'];
		$this->ipaddress = long2ip($row['up_ipaddress']);

	}

	public function cloneObject(Core_User $myUser)
	{
		$this->id = $myUser->id;
		$this->screenname = $myUser->screenname;
		$this->fullname = $myUser->fullname;
		$this->avatar = $myUser->avatar;
		$this->groupid = $myUser->groupid;
		$this->region = $myUser->region;
		$this->gender = $myUser->gender;
		$this->countFollowing = $myUser->countFollowing;
		$this->countFollower = $myUser->countFollower;
		$this->countFile = $myUser->countFile;
		$this->countBlog = $myUser->countBlog;
		$this->view = $myUser->view;
		$this->datelastaction = $myUser->datelastaction;
		$this->coverimage = $myUser->coverimage;
		$this->parentid = $myUser->parentid;

		$this->email = $myUser->email;
		$this->password = $myUser->password;
		$this->birthday = $myUser->birthday;
		$this->phone = $myUser->phone;
		$this->address = $myUser->address;
		$this->city = $myUser->city;
		$this->country = $myUser->country;
		$this->website = $myUser->website;
		$this->bio = $myUser->bio;
		$this->privacyBinary = $myUser->privacyBinary;
		$this->favouriteCategory = $myUser->favouriteCategory;
		$this->activatedcode = $myUser->activatedcode;
		$this->datecreated = $myUser->datecreated;
		$this->datemodified = $myUser->datemodified;
		$this->datelastlogin = $myUser->datelastlogin;
		$this->newfriendrequest = $myUser->newfriendrequest;
		$this->newnotification = $myUser->newnotification;
		$this->newmessage = $myUser->newmessage;
		$this->oauthPartner = $myUser->oauthPartner;
		$this->oauthUid = $myUser->oauthUid;
		$this->personalid = $myUser->personalid;
		$this->district = $myUser->district;
		$this->ipaddress = $myUser->ipaddress;
	}



	public static function getByEmail($email)
	{
		global $db;
		$myUser = new Core_User();
		if(Helper::ValidatedEmail($email))
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user u
					INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
					WHERE up_email = ?
					LIMIT 1';
			$row = $db->query($sql, array($email))->fetch();
			if($row['u_id'] > 0)
			{
				$myUser->id = $row['u_id'];
				$myUser->screenname = $row['u_screenname'];
				$myUser->fullname = $row['u_fullname'];
				$myUser->avatar = $row['u_avatar'];
				$myUser->groupid = $row['u_groupid'];
				$myUser->region = $row['u_region'];
				$myUser->gender = $row['u_gender'];
				$myUser->countFollowing = $row['u_count_following'];
				$myUser->countFollower = $row['u_count_follower'];
				$myUser->countFile = $row['u_count_file'];
				$myUser->countBlog = $row['u_count_blog'];
				$myUser->view = $row['u_view'];
				$myUser->datelastaction = $row['u_datelastaction'];
				$myUser->coverimage = $row['u_coverimage'];
				$myUser->parentid = $row['u_parentid'];

				$myUser->email = $row['up_email'];
				$myUser->password = $row['up_password'];
				$myUser->birthday = $row['up_birthday'];
				$myUser->phone = $row['up_phone'];
				$myUser->address = $row['up_address'];
				$myUser->city = $row['up_city'];
				$myUser->country = $row['up_country'];
				$myUser->website = Helper::paddingWebsitePrefix($row['up_website']);
				$myUser->bio = $row['up_bio'];
				$myUser->privacyBinary = $row['up_privacy_binary'];
				$myUser->favouriteCategory = $row['up_favouritecategory'];
				$myUser->activatedcode = $row['up_activatedcode'];
				$myUser->datecreated = $row['up_datecreated'];
				$myUser->datemodified = $row['up_datemodified'];
				$myUser->datelastlogin = $row['up_datelastlogin'];
				$myUser->newfriendrequest = $row['up_newfriendrequest'];
				$myUser->newnotification = $row['up_newnotification'];
				$myUser->newmessage = $row['up_newmessage'];
				$myUser->oauthPartner = $row['up_oauth_partner'];
				$myUser->oauthUid = $row['up_oauth_uid'];
				$myUser->personalid = $row['up_personalid'];
				$myUser->district = $row['up_district'];
				$myUser->ipaddress = long2ip($row['up_ipaddress']);
			}

		}

		return $myUser;
	}


	public static function getByOauthId($oauthpartner, $oauthuid)
	{
		global $db;
		$myUser = new Core_User();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user u
				INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
				WHERE up_oauth_partner = ? AND up_oauth_uid = ?
				LIMIT 1';
		$row = $db->query($sql, array((int)$oauthpartner, (string)$oauthuid))->fetch();
		if($row['u_id'] > 0)
		{
			$myUser->id = $row['u_id'];
			$myUser->screenname = $row['u_screenname'];
			$myUser->fullname = $row['u_fullname'];
			$myUser->avatar = $row['u_avatar'];
			$myUser->groupid = $row['u_groupid'];
			$myUser->region = $row['u_region'];
			$myUser->gender = $row['u_gender'];
			$myUser->countFollowing = $row['u_count_following'];
			$myUser->countFollower = $row['u_count_follower'];
			$myUser->countFile = $row['u_count_file'];
			$myUser->countBlog = $row['u_count_blog'];
			$myUser->view = $row['u_view'];
			$myUser->datelastaction = $row['u_datelastaction'];
			$myUser->coverimage = $row['u_coverimage'];
			$myUser->parentid = $row['u_parentid'];

			$myUser->email = $row['up_email'];
			$myUser->password = $row['up_password'];
			$myUser->birthday = $row['up_birthday'];
			$myUser->phone = $row['up_phone'];
			$myUser->address = $row['up_address'];
			$myUser->city = $row['up_city'];
			$myUser->country = $row['up_country'];
			$myUser->website = Helper::paddingWebsitePrefix($row['up_website']);
			$myUser->bio = $row['up_bio'];
			$myUser->privacyBinary = $row['up_privacy_binary'];
			$myUser->favouriteCategory = $row['up_favouritecategory'];
			$myUser->activatedcode = $row['up_activatedcode'];
			$myUser->datecreated = $row['up_datecreated'];
			$myUser->datemodified = $row['up_datemodified'];
			$myUser->datelastlogin = $row['up_datelastlogin'];
			$myUser->newfriendrequest = $row['up_newfriendrequest'];
			$myUser->newnotification = $row['up_newnotification'];
			$myUser->newmessage = $row['up_newmessage'];
			$myUser->oauthPartner = $row['up_oauth_partner'];
			$myUser->oauthUid = $row['up_oauth_uid'];
			$myUser->personalid = $row['up_personalid'];
			$myUser->district = $row['up_district'];
			$myUser->ipaddress = long2ip($row['up_ipaddress']);
		}

		return $myUser;
	}


	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ac_user
        		WHERE u_id = ?	';
		$this->db->query($sql, array($this->id));

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ac_user_profile
        		WHERE u_id = ?';
		$this->db->query($sql, array($this->id));

		//delete image
		$this->deleteImage();

		//Clear detail cache
		$myCacher = new Cacher('userdetail_' . $this->id);
		$myCacher->clear();


		return true;
	}

	/**
	* Gan cac gia tri chinh cho 1 tai khoan user
	* Thuong su dung khi JOIN voi cac chuc nang khac va gan data chinh (id, fullname, avatar) vao actor cho cac model khac
	*
	* @param array $info
	*/
	public function initMainInfo($info = array())
	{
		$this->id = isset($info['u_id']) ? $info['u_id'] : 0;
		$this->screenname = isset($info['u_screenname']) ? $info['u_screenname'] : '';
		$this->fullname = isset($info['u_fullname']) ? $info['u_fullname'] : '';
		$this->avatar = isset($info['u_avatar']) ? $info['u_avatar'] : '';
		$this->groupid = isset($info['u_groupid']) ? $info['u_groupid'] : '';
		$this->region = isset($info['u_region']) ? $info['u_region'] : '';
		$this->gender = isset($info['u_gender']) ? $info['u_gender'] : '';

		$this->countFollowing = isset($info['u_count_following']) ? $info['u_count_following'] : 0;
		$this->countFollower = isset($info['u_count_follower']) ? $info['u_count_follower'] : 0;
		$this->countFile = isset($info['u_count_file']) ? $info['u_count_file'] : 0;
		$this->countBlog = isset($info['u_count_blog']) ? $info['u_count_blog'] : 0;
		$this->view = isset($info['u_view']) ? $info['u_view'] : 0;
		$this->datelastaction = isset($info['u_datelastaction']) ? $info['u_datelastaction'] : 0;
		$this->coverimage = isset($info['u_coverimage']) ? $info['u_coverimage'] : '';
		$this->parentid = isset($info['u_parentid']) ? $info['u_parentid'] : '';

	}

	public function getByArray($info = array())
	{
		$this->id = $info['u_id'];
		$this->screenname = $info['u_screenname'];
		$this->fullname = $info['u_fullname'];
		$this->avatar = $info['u_avatar'];
		$this->groupid = $info['u_groupid'];
		$this->region = $info->region;
		$this->gender = $info->gender;
		$this->countFollowing = $info['u_count_following'];
		$this->countFollower = $info['u_count_follower'];
		$this->countFile = $info['u_count_file'];
		$this->countBlog = $info['u_count_blog'];
		$this->view = $info['u_view'];
		$this->datelastaction = $info['u_datelastaction'];
		$this->coverimage = $info['u_coverimage'];
		$this->parentid = $info['u_parentid'];

		$this->email = $info['up_email'];
		$this->password = $info['up_password'];
		$this->birthday = $info['up_birthday'];
		$this->phone = $info['up_phone'];
		$this->address = $info['up_address'];
		$this->city = $info['up_city'];
		$this->country = $info['up_country'];
		$this->website = $info['up_website'];
		$this->bio = $info['up_bio'];
		$this->privacyBinary = $info['up_privacy_binary'];
		$this->favouriteCategory = $info['up_favouritecategory'];
		$this->activatedcode = $info['up_activatedcode'];
		$this->datecreated = $info['up_datecreated'];
		$this->datemodified = $info['up_datemodified'];
		$this->datelastlogin = $info['up_datelastlogin'];
		$this->newfriendrequest = $info['up_newfriendrequest'];
		$this->newnotification = $info['up_newnotification'];
		$this->newmessage = $info['up_newmessage'];
		$this->oauthPartner = $info['up_oauth_partner'];
		$this->oauthUid = $info['up_oauth_uid'];
		$this->personalid = $info['up_personalid'];
		$this->district = $info['up_district'];
		$this->ipaddress = long2ip($info['up_ipaddress']);
	}


	public function writelog($type, $mainid = 0, $arraymoredata = array())
	{
		$myLog = new Core_Backend_ModeratorLog();
		$myLog->uid = $this->id;
		$myLog->email = $this->email;
		$myLog->type = $type;
		$myLog->mainid = $mainid;
		$myLog->moredata = $arraymoredata;
		$myLog->addData();
	}

	public function getGroupName()
	{
		return self::groupname($this->groupid);
	}

	public static function groupname($groupid)
	{
		global $lang;

		if($groupid == GROUPID_ADMIN)
			$groupname = 'Administrator';
		elseif($groupid == GROUPID_MODERATOR)
			$groupname = 'Moderator';
		elseif($groupid == GROUPID_DEVELOPER)
			$groupname = 'Developer';
		elseif($groupid == GROUPID_EMPLOYEE)
			$groupname = 'Employee';
		elseif($groupid == GROUPID_PARTNER)
			$groupname = 'Partner';
		elseif($groupid == GROUPID_DEPARTMENT)
			$groupname = 'Department';
		elseif($groupid == GROUPID_GROUP)
			$groupname = 'Group';
		elseif($groupid == GROUPID_MEMBER)
			$groupname = 'Member';
		elseif($groupid == GROUPID_MEMBERBANNED)
			$groupname = 'Banned Member';
		else
			$groupname = 'Guest';

		return $groupname;
	}



	public static function getGroupnameList()
    {
		global $registry;

		$groupnameList = array();

		$groupnameList[GROUPID_ADMIN] = $registry->lang['default']['groupnameAdmin'];
		$groupnameList[GROUPID_MODERATOR] = $registry->lang['default']['groupnameModerator'];
		$groupnameList[GROUPID_DEVELOPER] = $registry->lang['default']['groupnameDeveloper'];
		$groupnameList[GROUPID_EMPLOYEE] = $registry->lang['default']['groupnameEmployee'];
		$groupnameList[GROUPID_PARTNER] = $registry->lang['default']['groupnamePartner'];
		$groupnameList[GROUPID_DEPARTMENT] = $registry->lang['default']['groupnameDepartment'];
		$groupnameList[GROUPID_GROUP] = $registry->lang['default']['groupnameGroup'];
		$groupnameList[GROUPID_MEMBER] = $registry->lang['default']['groupnameMember'];
		$groupnameList[GROUPID_MEMBERBANNED] = $registry->lang['default']['groupnameMemberbanned'];
		//$groupnameList[GROUPID_GUEST] = $registry->lang['default']['groupnameGuest'];

		return $groupnameList;
    }

	public function checkGroupname($name)
	{
		$name = strtolower($name);
		return ($this->groupid == GROUPID_ADMIN && $name == 'administrator' ||
			$this->groupid == GROUPID_MODERATOR && $name == 'moderator' ||
			$this->groupid == GROUPID_DEVELOPER && $name == 'developer' ||
			$this->groupid == GROUPID_EMPLOYEE && $name == 'employee' ||
			$this->groupid == GROUPID_PARTNER && $name == 'partner' ||
			$this->groupid == GROUPID_DEPARTMENT && $name == 'department' ||
			$this->groupid == GROUPID_GROUP && $name == 'group' ||
			$this->groupid == GROUPID_MEMBER && $name == 'member' ||
			$this->groupid == GROUPID_MEMBERBANNED && $name == 'memberbanned'
		);
	}

	public function isEmployee()
	{
		return (
			$this->groupid == GROUPID_ADMIN ||
			$this->groupid == GROUPID_MODERATOR ||
			$this->groupid == GROUPID_DEVELOPER ||
			$this->groupid == GROUPID_EMPLOYEE
		);
	}

	public static function countList($where, $joinString)
	{
		global $db;
		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user u
				'.$joinString.'';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}

	public static function getList($where, $joinString, $order , $limit = '')
	{
		global $db;
		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user u
				'.$joinString.'';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);

		while($row = $stmt->fetch())
		{
			$myUser = new Core_User();
			$myUser->id = $row['u_id'];
			$myUser->screenname = $row['u_screenname'];
			$myUser->fullname = $row['u_fullname'];
			$myUser->avatar = $row['u_avatar'];
			$myUser->groupid = $row['u_groupid'];
			$myUser->region = $row['u_region'];
			$myUser->gender = $row['u_gender'];
			$myUser->countFollowing = $row['u_count_following'];
			$myUser->countFollower = $row['u_count_follower'];
			$myUser->countFile = $row['u_count_file'];
			$myUser->countBlog = $row['u_count_blog'];
			$myUser->view = $row['u_view'];
			$myUser->datelastaction = $row['u_datelastaction'];
			$myUser->coverimage = $row['u_coverimage'];
			$myUser->parentid = $row['u_parentid'];

			$myUser->email = $row['up_email'];
			$myUser->password = $row['up_password'];
			$myUser->birthday = $row['up_birthday'];
			$myUser->phone = $row['up_phone'];
			$myUser->address = $row['up_address'];
			$myUser->city = $row['up_city'];
			$myUser->country = $row['up_country'];
			$myUser->website = $row['up_website'];
			$myUser->bio = $row['up_bio'];
			$myUser->privacyBinary = $row['up_privacy_binary'];
			$myUser->favouriteCategory = $row['up_favouritecategory'];
			$myUser->activatedcode = $row['up_activatedcode'];
			$myUser->datecreated = $row['up_datecreated'];
			$myUser->datemodified = $row['up_datemodified'];
			$myUser->datelastlogin = $row['up_datelastlogin'];
			$myUser->newfriendrequest = $row['up_newfriendrequest'];
			$myUser->newnotification = $row['up_newnotification'];
			$myUser->newmessage = $row['up_newmessage'];
			$myUser->oauthPartner = $row['up_oauth_partner'];
			$myUser->oauthUid = $row['up_oauth_uid'];
            $myUser->personalid = $row['up_personalid'];
            $myUser->district = $row['up_district'];
			$myUser->ipaddress = long2ip($row['up_ipaddress']);
			$outputList[] = $myUser;
		}
		return $outputList;
	}


	public static function getUsers($formData, $sortby = 'id', $sorttype = 'DESC', $limit = '', $countOnly = false, $getUserDetail = true)
	{
		$whereString = '';
		$joinString = '';

		if($getUserDetail)
			$joinString = ' INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id ';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_id = '.(int)$formData['fid'].' ';

		if(isset($formData['fids']) && $formData['fids']!='')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_id IN('.(string)$formData['fids'].')';

		if(count($formData['femaillist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_email IN ( '.implode(',', $formData['femaillist']).') ';

		if(count($formData['fidlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_id IN ( '.implode(',', $formData['fidlist']).') ';

		if(strlen($formData['fscreenname']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_screenname = "'.Helper::unspecialtext($formData['fscreenname']).'" ';

		if($formData['fgroupid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_groupid = '.(int)$formData['fgroupid'].' ';

		if($formData['femployeeonly'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_groupid <= ' . GROUPID_EMPLOYEE;

		if(count($formData['fgroupidlist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_groupid IN ( '. implode(', ', $formData['fgroupidlist']).' )';

		if(isset($formData['fauthoauthpartner']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_oauth_partner = '.(int)$formData['foauthpartner'].' ';

		if(isset($formData['fhaveavatar']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_avatar <> ""';

		if(isset($formData['fparentid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_parentid = ' . (int)$formData['fparentid'];

		if(isset($formData['fphone']) && $formData['fphone']!='')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_phone ="' . (string)$formData['fphone'].'"';

		if(isset($formData['fpass']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_password ="' .$formData['fpass'].'"';

		if(isset($formData['femail']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_email =  "'.$formData['femail'].'"';

		if(isset($formData['foauthUid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_oauth_uid =  "'.$formData['foauthUid'].'"';

		if(isset($formData['ffullname']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_fullname LIKE \'%'.$formData['ffullname'].'%\'';

		if(isset($formData['fpersonalid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_personalid ="'.$formData['fpersonalid'].'"';

		/*---use for app mobile--*/
		if(count($formData['fMoauthUid']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_oauth_uid >  "'.$formData['fMoauthUid'].'"';
		if(count($formData['fNum']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . '( (u.u_id LIKE \'%'.$formData['fNum'].'%\') OR (up.up_phone LIKE \'%'.$formData['fNum'].'%\')OR (up.up_oauth_uid LIKE \'%'.$formData['fNum'].'%\') )';
		if(strlen($formData['fString']) > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (up.up_email LIKE \'%'.$formData['fString'].'%\') OR (u.u_fullname LIKE \'%'.$formData['fString'].'%\'))';
		/*---end of query for app--*/

		if(strlen($formData['fkeywordFilter']) > 0)
		{

			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'up.up_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'screenname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_screenname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (up.up_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (u.u_screenname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (u.u_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (up.up_oauth_uid LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'email')
			$orderString = ' up.up_email ' . $sorttype;
		elseif($sortby == 'group')
			$orderString = ' u.u_groupid ' . $sorttype;
		elseif($sortby == 'datelastaction')
			$orderString = ' u.u_datelastaction ' . $sorttype;
		else
			$orderString = ' u.u_id ' . $sorttype;
		if($countOnly)
			return self::countList($whereString, $joinString);
		else
			return self::getList($whereString, $joinString, $orderString, $limit);
	}

	public function thumbImage()
	{
		global $registry;
		$pos = strrpos($this->avatar, '.');
		$extPart = substr($this->avatar, $pos+1);
		$namePart =  substr($this->avatar,0, $pos);
		$filesmall = $namePart . '-small.' . $extPart;

		return $filesmall;
	}

	public function mediumImage()
	{
		global $registry;
		$pos = strrpos($this->avatar, '.');
		$extPart = substr($this->avatar, $pos+1);
		$namePart =  substr($this->avatar,0, $pos);
		$filesmall = $namePart . '-medium.' . $extPart;

		return $filesmall;
	}

	public function getRegionName($showUnknown = true)
	{
		global $setting;

		if($this->region > 0)
			return $setting['region'][$this->region];
		elseif($showUnknown)
			return 'n/a';
		else
			return '';
	}

	public function getGenderText()
	{
		if($this->gender == self::GENDER_MALE)
		{
			return 'male';
		}
		elseif($this->gender == self::GENDER_FEMALE)
		{
			return 'female';
		}
	}

	public function getOnlinestatus()
	{
		return Core_UserOnline::getOnlineStatus($this->id);
	}

	public function getNameicon()
	{
		$icon = '';

		return $icon;
	}

	/**
	* Duong dan den trang cua user
	*/
	public function getUserPath()
	{
		global $registry;

		$path = $registry->conf['rooturl'] . 'a' . $this->id;

		return $path;
	}

	/**
	* Duong dan den hovercard cua 1 user
	*/
	public function getHovercardPath()
	{
		global $registry;

		$path = $registry->conf['rooturl_profile'] . 'hovercard?id=' . $this->id;

		return $path;
	}

	/**
	* Cap nhat so luong cua 1 thong tin nao do ma user nay so huu vd: book, review...
	*
	* @param string $type
	* @param int $quantity , co the la so am(-)) cho truong hop tru
	*/
	public function updateCount($type, $quantity)
	{
		$column = '';

		if($type == 'following') $column = 'u_count_following';
		elseif($type == 'follower') $column = 'u_count_follower';
		elseif($type == 'file') $column = 'u_count_file';
		elseif($type == 'blog') $column = 'u_count_blog';

		if($column != '')
		{
		    $sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
		    		SET '.$column.' = '.$column.' + '.(int)$quantity.'
		    		WHERE u_id = ?
		    		LIMIT 1';
		    $stmt = $this->db->query($sql);
		}
	}


	public function resetpass($newpass)
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile
				SET up_password = ?
				WHERE u_id = ?
				LIMIT 1';
		$stmt = $this->db->query($sql, array(viephpHashing::hash($newpass), $this->id));
		if($stmt)
			return true;
		else
			return false;
	}

	/**
	* Ham kiem tra xem screenname input da co user nao dang ky chua
	*
	* @param string $screenname
	* @return bool $result
	*/
	public function isScreennameExisted($screenname)
	{
		$result = false;

		$screenname = preg_replace('[^a-z0-9]', '', $screenname);
		if(strlen($screenname) == 0)
		{
			$result = true;
		}
		else
		{
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user
					WHERE u_screenname = ?
					LIMIT 1';
			$count = $this->db->query($sql, array($screenname))->fetchColumn(0);
			if($count > 0)
			{
				$result = true;
			}
		}

		return $result;
	}


	/**
	* Tra ve filename cua hinh tuong ung voi group cua user
	*
	*/
	public function getBadge($showHtmlImg = false)
	{
		$badgeFile = '';

		switch($this->groupid)
		{
			case GROUPID_ADMIN: $badgeFile = ''; break;
			case GROUPID_PAGE: $badgeFile = ''; break;
			case GROUPID_MODERATOR: $badgeFile = ''; break;
			case GROUPID_EMPLOYEE: $badgeFile = ''; break;
			case GROUPID_PARTNER: $badgeFile = ''; break;
			case GROUPID_MEMBER: $badgeFile = ''; break;
			case GROUPID_MEMBERBANNED: $badgeFile = ''; break;
		}

		if($showHtmlImg)
		{
			global $registry;
			$badgeFile = '<img src="'.$registry->currentTemplate.'/images/'.$badgeFile.'" class="userbadge" alt="" />';
		}

		return $badgeFile;
	}


	/**
	* Cap nhat cac thong tin ve thong ke cua user, nhu counting book, shelf, review, quote
	*
	* @param array $columns: danh sach cac field can get new data de cap nhat
	*
	*/
	public function updateCounting($columns = array())
	{


		if(in_array('following', $columns))
			$this->countFollowing = Core_UserEdge::getUserEdges(array('fuidstart' => $this->id), '', '', '', true);

		if(in_array('follower', $columns))
			$this->countFollower = Core_UserEdge::getUserEdges(array('fuidend' => $this->id), '', '', '', true);

		if(in_array('blog', $columns))
			$this->countBlog = Core_Blog::getBlogs(array('fuserid' => $this->id), '', '', '', true);

		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
				SET u_count_following = ?,
					u_count_follower = ?,
					u_count_file = ?,
					u_count_blog = ?,
					u_datelastaction = ?
				WHERE u_id = ?';
		$stmt = $this->db->query($sql, array(
			(int)$this->countFollowing,
			(int)$this->countFollower,
			(int)$this->countFile,
			(int)$this->countBlog,
			time(),
			$this->id
		));

		if($stmt)
			return true;
		else
			return false;
	}

	public function getSmallImage($isMedium = false)
	{
		global $registry;

		$avatarPath = '';
		if($this->avatar == '')
		{
			$avatarPath = $registry->currentTemplate . 'images/noavatar200.jpg';
		}
		else
		{
			//$avatarPath = $registry->conf['rooturl'] . $registry->setting['avatar']['imageDirectory'];
			$avatarPath = $registry->getResourceHost('avatar') . $registry->setting['avatar']['imageDirectoryFromResourceHost'];

			if($isMedium)
				$avatarPath .= $this->mediumImage();
			else
				$avatarPath .= $this->thumbImage();
		}

		return $avatarPath;
	}

	/**
	* Reset cac so notification ve 0
	*
	* Hien tai co 3 loai:
	*
	* 2. New Notification - notification
	* 3. New Message - message : chua trien khai
	*
	*/
	public function notificationReset($type)
	{
		$column = '';
		switch($type)
		{
			case 'friendrequest': $column = 'up_newfriendrequest'; break;
			case 'notification': $column = 'up_newnotification'; break;
			case 'message': $column = 'up_newmessage'; break;
		}

		if($column == '')
		{
			return false;
		}
		else
		{
			$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile SET '.$column.' = 0 WHERE u_id = ?';
			$stmt = $this->db->query($sql, array($this->id));
			if($stmt->rowCount() > 0)
				return true;
			else
				return false;
		}
	}

	/**
	* Tang so notification len 1 cho 1 danh sach user id
	*
	* * Hien tai co 3 loai:
	*
	* 1. New friend request - friendrequest
	* 2. New Notification - notification
	* 3. New Message - message : chua trien khai
	*
	* @param string $type
	* @param array $useridList
	*
	*/
	public static function notificationIncrease($type, $useridList)
	{
		global $db;

		$result = false;
		$column = '';
		switch($type)
		{
			case 'friendrequest': $column = 'up_newfriendrequest'; break;
			case 'notification': $column = 'up_newnotification'; break;
			case 'message': $column = 'up_newmessage'; break;
		}

		if($column != '')
		{
			$count = count($useridList);

			if($count == 1)
			{
				//using array_merge de reset index value ve 0
				$useridList = array_merge(array(), $useridList);

				$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile SET '.$column.' = '.$column.' + 1 WHERE u_id = ?';
				$stmt = $db->query($sql, array((int)$useridList[0]));

				if($stmt->rowCount() > 0)
				{
					$result = true;
				}
			}
			elseif($count > 1)
			{
				//de dam bao query khong bi qua dai
				//do su dung dieu kien WHERE column IN(...)
				//nen segment userid list theo 1 segment size nao do de lam ngan cau query
				$segmentSize = 50;	//50 userids trong 1 segment
				$segments = array_chunk($useridList, $segmentSize);
				for($i = 0; $i < count($segments); $i++)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user_profile SET '.$column.' = '.$column.' + 1 WHERE u_id IN ('.implode(',', $segments[$i]).') LIMIT '.$segmentSize.' ';
					$stmt = $db->query($sql);
					if($stmt->rowCount() > 0)
						$result = true;
				}
			}

		}

		return $result;
	}

	/**
	* Ham tra ve gia tri privacy tuong ung voi type
	* hien tai chi co 1 type la generic, tuc la ap dung toan bo viec truy cap trang
	*
	* @param string $type
	*/
	public function getPrivacy($type = 'generic')
	{
		return $this->privacyBinary;
	}

	/**
	* Ham set privacy cua thanh vien
	* hien tai chi co 1 type la generic, tuc la ap dung toan bo viec truy cap trang
	*
	* @param int $privacyvalue: gia tri tuong ung voi cac constant cua Core_User::PRIVACY_..., hien tai chua co GROUP nen chi cho phep 3 loai: ME, FRIEND, INTERNET
	* @param string $type
	*/
	public function setPrivacy($privacyvalue, $type = 'generic')
	{
		if($privacyvalue == self::PRIVACY_ME || $privacyvalue == self::PRIVACY_FRIEND || $privacyvalue == self::PRIVACY_INTERNET)
		{
			$this->privacyBinary = $privacyvalue;
		}
	}

	/**
	* Cap nhat field thoi gian hoat dong cuoi cung
	*
	*/
	public function updateDateLastaction()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
				SET u_datelastaction = ?
				WHERE u_id = ?
				LIMIT 1';
		$this->db->query($sql, array(time(), $this->id));

		//refresh online status for cache
		Core_UserOnline::setonline($this->id);
	}

	/**
	* Kiem tra user nay co phai la group nay ko
	*
	* Dua vao name
	* $groupname: administrator, moderator, member, membervip, memberbanned, bookstore, publisher, guest
	*
	* @param mixed $groupname
	*/
	public function isGroup($groupname)
	{
		if($groupname == 'administrator')
			return $this->groupid == GROUPID_ADMIN;
		elseif($groupname == 'moderator')
			return $this->groupid == GROUPID_MODERATOR;
		elseif($groupname == 'developer')
			return $this->groupid == GROUPID_DEVELOPER;
		elseif($groupname == 'employee')
			return $this->groupid == GROUPID_EMPLOYEE;
		elseif($groupname == 'partner')
			return $this->groupid == GROUPID_PARTNER;
		elseif($groupname == 'department')
			return $this->groupid == GROUPID_DEPARTMENT;
		elseif($groupname == 'group')
			return $this->groupid == GROUPID_GROUP;
		elseif($groupname == 'member')
			return $this->groupid == GROUPID_MEMBER;
		elseif($groupname == 'memberbanned')
			return $this->groupid == GROUPID_MEMBERBANNED;
		else
			return false;

	}

	public function isStaff()
	{
		return in_array($this->groupid, array(GROUPID_ADMIN, GROUPID_MODERATOR, GROUPID_DEVELOPER, GROUPID_EMPLOYEE, GROUPID_PARTNER));
	}


	/**
	* Tang view cua user nay
	*
	*/
	public function increaseView($typeview, $moreid = 0)
	{
		global $setting;
		$result = false;


		if(Helper::checkCookieEnable() && (!isset($_SESSION['currentUserView'][$typeview]) || (is_array($_SESSION['currentUserView'][$typeview]) && count($_SESSION['currentUserView'][$typeview]) < $setting['user']['maxSesionGroupEntry'] && !in_array($this->id, $_SESSION['currentUserView'][$typeview]))))
		{
			 $sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user SET u_view = u_view + 1
    				WHERE u_id = ?';
		    $stmt = $this->db->query($sql, array($this->id));
		    if($stmt)
		    {
		        $_SESSION['currentUserView'][$typeview][] = $this->id;
		        $result = true;
			}
		}



		return $result;
	}

	/**
	* Chi cap nhat field region cho profile cua user
	*
	*/
	public function updateRegion()
	{
		//update profile table
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ac_user
        		SET u_region = ?
        		WHERE u_id = ?';

		$stmt = $this->db->query($sql, array(
		    (int)$this->region,
		    (int)$this->id
		));

		if($stmt)
			return true;
		else
			return false;
	}


	public function getOAuthPartnerName()
	{
		switch($this->oauthPartner)
		{
			case self::OAUTH_PARTNER_EMPTY : $name = 'Not use OAuth'; break;
			case self::OAUTH_PARTNER_FACEBOOK : $name = 'FACEBOOK'; break;
			case self::OAUTH_PARTNER_GOOGLE : $name = 'GOOGLE'; break;
			case self::OAUTH_PARTNER_YAHOO : $name = 'YAHOO'; break;
			case self::OAUTH_PARTNER_NOIBOTHEGIOIDIDONG : $name = 'NOI BO THEGIOIDIDONG'; break;
			case self::OAUTH_PARTNER_DIENMAYCRM : $name = 'DIENMAY CRM'; break;
		}

		return $name;
	}


	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	//	CACHE MAIN INFO
	/**
	* Kiem tra xem 1 userid da duoc cache chua
	*
	* @param mixed $userid
	*/
	public static function cacheCheck($userid)
	{
		$cacheKeystring = self::cacheBuildKeystring($userid);

		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		if(!empty($row))
		{
			return $row;
		}
		else
		{
			return false;
		}

	}

	/**
	* Lay thong tin user tu he thong cache
	* danh cho he thong ko phai join voi table user
	*
	* Chua trien khai nen truy xuat toi database luon ^^
	*/
	public static function cacheGet($userid, &$cacheSuccess = false, $forceStore = false)
	{
		global $db;

		$cacheKeystring = self::cacheBuildKeystring($userid);

		$myUser = new Core_User();

		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$storerow = $myCacher->get();

		//var_dump($row);

		//force to store new value
		if(!$storerow || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user
					WHERE u_id = ? ';
			$row = $db->query($sql, array($userid))->fetch();
			if($row['u_id'] > 0)
			{
				$myUser->initMainInfo($row);

				$storerow = array(
					$row['u_id'],
					$row['u_screenname'],
					str_replace(',', '&#44;', $row['u_fullname']),
					$row['u_avatar'],
					$row['u_groupid'],
					$row['u_region'],
					$row['u_gender'],
					$row['u_count_following'],
					$row['u_count_follower'],
					$row['u_count_blog'],
					$row['u_view'],
					$row['u_datelastaction'],
					$row['u_coverimage'],

				);

				$storerow = implode(',', $storerow);
				//store new value
				$cacheSuccess = self::cacheSet($userid, $storerow);
			}
		}
		else
		{
			$storerow = explode(',', $storerow);
			$row = array(
				'u_id' => $storerow[0],
				'u_screenname' => $storerow[1],
				'u_fullname' => str_replace('&#44;', ',', $storerow[2]),
				'u_avatar' => $storerow[3],
				'u_groupid' => $storerow[4],
				'u_region' => $storerow[5],
				'u_gender' => $storerow[6],
				'u_count_following' => $storerow[7],
				'u_count_follower' => $storerow[8],
				'u_count_blog' => $storerow[9],
				'u_view' => $storerow[10],
				'u_datelastaction' => $storerow[11],
				'u_coverimage' => $storerow[12],
			);


			$myUser->initMainInfo($row);
		}

		return $myUser;
	}

	/**
	* Luu thong tin vao cache
	*
	*/
	public static function cacheSet($userid, $value)
	{
		global $registry;

		$myCacher = new Cacher(self::cacheBuildKeystring($userid));
		return $myCacher->set($value, $registry->setting['site']['apcUserCacheTimetolive']);
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $userid
	*/
	public static function cacheDelete($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystring($userid));
		return $myCacher->clear();
	}

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $userid
	*/
	public static function cacheBuildKeystring($userid)
	{
		return 'user_'.$userid;
	}
	//	end -- CACHE MAIN INFO
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////


	public function getCode()
	{
		return 'A' . $this->id;
	}

	/**
	 * Get all account id of this user follow(user/group) and emply(department)
	 */
	public function getFullFollowingList()
	{
		$idList = array();

		//must be implement cache

		//get Group, Departments
		$idList = $this->getBelongConnections();

		//get Group (^^, sorry, it duplicate because of TYPE_FOLLOW), User i am following
		$followingList = Core_UserEdge::getUserEdges(array('fuidstart' => $this->id, 'ftype' => Core_UserEdge::TYPE_FOLLOW), '', '', '');
                //echodebug($followingList,true);
		for($i = 0; $i < count($followingList); $i++)
		{
			if(!in_array($followingList[$i]->uidend, $idList))
				$idList[] = $followingList[$i]->uidend;
		}

		return $idList;

	}


	/**
	 * Lay danh sach Department, Group ma user nay thuoc ve de tien hanh cac thao tac lay message/notification theo nhom
	 */
	public function getBelongConnections($includeUserFollowing = true)
	{
		$finalList = array();

		///////////////////
		// TODO:
		//we need to implement cache for this array because the performance of this process

		///////////////////////////////////
		//DEPARTMENTS
		$departmentList = $this->getBelongDepartments();
		for($i = 0; $i < count($departmentList); $i++)
			array_push($finalList, $departmentList[$i]->id);

		//////////////////////////////////
		//GROUPS CREATED
		//lay tat ca group ma user nay tao
		$createdGroupList = Core_User::getUsers(array('fparentid' => $this->id, 'fgroupid' => GROUPID_GROUP), '', '', '');

		/////////////////////////
		// GROUP FOLLOW
		//lay tat ca group ma user nay follow
		if($includeUserFollowing)
		{
			$userEdgeList = Core_UserEdge::getUserEdges(array('fuidstart' => $this->id, 'ftypelist' => array(Core_UserEdge::TYPE_FOLLOW, Core_UserEdge::TYPE_JOIN)), 'datemodified', 'DESC', '');
			$followGroupList = array();
			for($i = 0; $i < count($userEdgeList);$i++)
			{
				$followGroupList[] = $userEdgeList[$i]->uidend;
			}


			for($i = 0; $i < count($createdGroupList); $i++)
			{
				if(!in_array($createdGroupList[$i]->id, $followGroupList))
					$followGroupList[] = $createdGroupList[$i]->id;
			}
		}
		else //follow group only
		{
			$userEdgeList = Core_UserEdge::getUserEdges(array('fuidstart' => $this->id, 'ftype' => Core_UserEdge::TYPE_JOIN), 'datemodified', 'DESC', '');
			$followGroupList = array();
			for($i = 0; $i < count($userEdgeList);$i++)
			{
				$followGroupList[] = $userEdgeList[$i]->uidend;
			}


			for($i = 0; $i < count($createdGroupList); $i++)
			{
				if(!in_array($createdGroupList[$i]->id, $followGroupList))
					$followGroupList[] = $createdGroupList[$i]->id;
			}
		}

		$finalList = array_merge($finalList, $followGroupList);


		return $finalList;
	}

	/**
	 * Tra ve danh sach Department ma User nay thuoc ve
	 */
	public function getBelongDepartments()
	{
		$departmentList = array();

		//phong ban gan nhat ma user nay thuoc ve
		$useredgeList = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $this->id), '', '', 1);
		if(count($useredgeList) > 0)
		{
			$nearestDepartment = new Core_Department($useredgeList[0]->uidend, true);

			array_push($departmentList, $nearestDepartment);

			//traverse back to the root of found department.
			$parentDepartmentList = Core_Department::getFullParentDepartments($nearestDepartment->id);
			if(count($parentDepartmentList) > 0)
			{
				foreach($parentDepartmentList as $department)
				{
					$myDepartment = new Core_Department();
					$myDepartment->initMainInfo($department);
					array_unshift($departmentList, $myDepartment);
				}
			}
		}


		return $departmentList;
	}


	public static function statTotalAccount($dateRangeStart)
	{
		global $db;

		$groupidList = array(GROUPID_ADMIN, GROUPID_MODERATOR, GROUPID_DEVELOPER, GROUPID_EMPLOYEE, GROUPID_PARTNER, GROUPID_MEMBER, GROUPID_MEMBERBANNED);

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user u
				INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
				WHERE u_groupid IN ('.implode(',', $groupidList).')
					AND up_datecreated >= ?';
		return $db->query($sql, array($dateRangeStart))->fetchColumn(0);
	}

	public function haveAccessTicket($checkticket = '')
	{
		$pass = false;

		if($this->id > 0)
		{
			//user ticket list
			$ticketList = $this->getAccessTicketList();


			if(count($ticketList) > 0)
			{
				//Get checkticket parts to compare with may ticket parts
				$checkticketInfo = explode('_', $checkticket, 4);

				foreach($ticketList as $myTicket)
				{
					$myTicketInfo = explode('_', $myTicket, 4);

					if(
						$myTicketInfo[0] == $checkticketInfo[0] 	// Controller Group
						&& $myTicketInfo[1] == $checkticketInfo[1] 	// Controller
						&& ($checkticketInfo[2] == '*' || $myTicketInfo[2] == '*' || $myTicketInfo[2] == $checkticketInfo[2])	//	Action
						&& ($checkticketInfo[3] == '*' || $myTicketInfo[3] == '*' || $myTicketInfo[3] == $checkticketInfo[3])	//	Suffix
					)
						$pass = true;
				}
			}
		}

		return $pass;
	}


	public function getAccessTicketList()
	{
		//user ticket list
		$ticketList = array();

		if($this->id > 0)
		{
			/////////////
			// GET TICKET LIST OF CURRENT USER
			$key = 'user_accessticket_' . $this->id;
			$myCacher = new Cacher($key);
			$ticketString = $myCacher->get();
			if($ticketString !== false)
			{
				$ticketList = explode(',', $ticketString);
			}
			else
			{
				//IF NOT EXIST IN CACHE, FETCH FROM DB TO GET USER TICKET LIST
				//Lay danh sach access ticket cua user
				$tickets = Core_AccessTicket::getAccessTickets(array('fuid' => $this->id, 'fstatus' => Core_AccessTicket::STATUS_ENABLE), '', '', '');
				if(count($tickets) > 0)
				{
					foreach($tickets as $ticket)
					{
						$ticketList[] = $ticket->fullticket;
					}
				}

				$ticketString = '';
				if(count($ticketList) > 0)
				{
					//Store ticket
					$ticketString = implode(',', $ticketList);
					$myCacher->set($ticketString, 3600);
				}
			}
		}

		return $ticketList;
	}

	public function clearAccessTicketCache()
	{
		$pass = false;

		if($this->id > 0)
		{
			$key = 'user_accessticket_' . $this->id;
			$myCacher = new Cacher($key);
			$pass = $myCacher->clear();
		}

		return $pass;
	}

	public function getAccessTicketSuffixId($suffixWithoutId)
	{
		$suffixIdList = array();

		if(strlen($suffixWithoutId) > 0)
		{
			$ticketList = $this->getAccessTicketList();
			foreach($ticketList as $ticket)
			{
				if(preg_match('/^'.$suffixWithoutId.'(\d+)$/', $ticket, $match))
				{
					$objectid = (int)$match[1];
					if($objectid > 0)
						$suffixIdList[] = $objectid;
				}//end match
			}//end loop
		}


		return $suffixIdList;
	}


}



