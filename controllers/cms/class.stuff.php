<?php

Class Controller_Cms_Stuff Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		$permission = $this->registry->router->getArg('permission');

		//display error permission
		switch($permission)
		{
			case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
				break;
			case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
				break;
			case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
				break;
		}

		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$pidFilter = (int)($this->registry->router->getArg('pid'));
		$scidFilter = (int)($this->registry->router->getArg('scid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$issmsFilter = (int)($this->registry->router->getArg('issms'));
		$isvipFilter = (int)($this->registry->router->getArg('isvip'));
		$regionidFilter = (int)($this->registry->router->getArg('regionid'));
		$districtidFilter = (int)($this->registry->router->getArg('districtid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['stuffBulkToken']==$_POST['ftoken'])
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
                            $myStuff = new Core_Stuff($id);

                            if($myStuff->id > 0)
                            {
                            	if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
                            	{
                            		$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $myStuff->id, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
									if(!$checker)
									{
										$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $myStuff->parentid, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
									}

									if(!$checker)
									{
										header('location: ' . $this->registry['conf']['rooturl_cms'].'stuff/index/permission/delete');
										exit();
									}
									else
									{
										//tien hanh xoa
		                                if($myStuff->delete())
		                                {
		                                    $deletedItems[] = $myStuff->id;
		                                    $this->registry->me->writelog('stuff_delete', $myStuff->id, array());
		                                }
		                                else
		                                    $cannotDeletedItems[] = $myStuff->id;
									}
                            	}
                            	else
                            	{
                            		//tien hanh xoa
	                                if($myStuff->delete())
	                                {
	                                    $deletedItems[] = $myStuff->id;
	                                    $this->registry->me->writelog('stuff_delete', $myStuff->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myStuff->id;
                            	}
                            }
                            else
                                $cannotDeletedItems[] = $myStuff->id;
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

		$_SESSION['stuffBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($pidFilter > 0)
		{
			$paginateUrl .= 'pid/'.$pidFilter . '/';
			$formData['fpid'] = $pidFilter;
			$formData['search'] = 'pid';
		}

		if($scidFilter > 0)
		{
			$paginateUrl .= 'scid/'.$scidFilter . '/';
			$formData['fscid'] = $scidFilter;
			$formData['search'] = 'scid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($issmsFilter > 0)
		{
			$paginateUrl .= 'issms/'.$issmsFilter . '/';
			$formData['fissms'] = $issmsFilter;
			$formData['search'] = 'issms';
		}

		if($isvipFilter > 0)
		{
			$paginateUrl .= 'isvip/'.$isvipFilter . '/';
			$formData['fisvip'] = $isvipFilter;
			$formData['search'] = 'isvip';
		}

		if($regionidFilter > 0)
		{
			$paginateUrl .= 'regionid/'.$regionidFilter . '/';
			$formData['fregionid'] = $regionidFilter;
			$formData['search'] = 'regionid';
		}

		if($districtidFilter > 0)
		{
			$paginateUrl .= 'districtid/'.$districtidFilter . '/';
			$formData['fdistrictid'] = $districtidFilter;
			$formData['search'] = 'districtid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'title')
			{
				$paginateUrl .= 'searchin/title/';
			}
			elseif($searchKeywordIn == 'content')
			{
				$paginateUrl .= 'searchin/content/';
			}
			elseif($searchKeywordIn == 'contactname')
			{
				$paginateUrl .= 'searchin/contactname/';
			}
			elseif($searchKeywordIn == 'contactemail')
			{
				$paginateUrl .= 'searchin/contactemail/';
			}
			elseif($searchKeywordIn == 'contactphone')
			{
				$paginateUrl .= 'searchin/contactphone/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$formData['fscidarr'] = array();
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id, 'ftype' => Core_RoleUser::TYPE_STUFF, 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
			foreach($roleusers as $roleuser)
			{
				$formData['fscidarr'][] = $roleuser->objectid;
			}

		}

		if(count($formData['fscidarr']) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_Stuff::getStuffs($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$stuffs = Core_Stuff::getStuffs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		}

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);

		$myStuffcategory = Core_Stuffcategory::getStuffcategorys(array('fparentid' => 0), 'displayorder', 'ASC', '');



		$this->registry->smarty->assign(array(	'stuffs' 	=> $stuffs,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												'myStuffcategory'	=> $myStuffcategory,

												'statusList'	=> Core_Stuff::getStatusList(),
												'vipList'		=> Core_Stuff::getVipList(),
												'issms'			=> Core_Stuff::IS_SMS
												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['stuffAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


            	if($this->addActionValidator($formData, $error))
                {
                    $myStuff = new Core_Stuff();


					$myStuff->pid = $formData['fpid'];
					$myStuff->scid = $formData['fscid'];
					$myStuff->type = $formData['ftype'];
					$myStuff->image = $formData['fimage'];
					$myStuff->title = $formData['ftitle'];
					$myStuff->slug = $formData['fslug'];
					$myStuff->content = $formData['fcontent'];
					$myStuff->price = $formData['fprice'];
					$myStuff->contactname = $formData['fcontactname'];
					$myStuff->contactemail = $formData['fcontactemail'];
					$myStuff->contactphone = $formData['fcontactphone'];
					$myStuff->seotitle = $formData['fseotitle'];
					$myStuff->seokeyword = $formData['fseokeyword'];
					$myStuff->seodescription = $formData['fseodescription'];
					$myStuff->regionid = $formData['fregionid'];
					$myStuff->districtid = $formData['fdistrictid'];
					$myStuff->status = $formData['fstatus'];

                    if($myStuff->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('stuff_add', $myStuff->id, array());
                        $formData = array();

                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }

            }

		}

		$_SESSION['stuffAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'statusList'    => Core_Stuff::getStatusList(),
												'typeList'		=> Core_Stuff::getTypeList(),
												'stuffcategory'  => Core_Stuffcategory::getStuffcategorys(array('fparentid' => 0), '', 'ASC', ''),
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myStuff = new Core_Stuff($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myStuff->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$formData['fbulkid'] = array();


			$formData['fuid'] = $myStuff->uid;
			$formData['fpid'] = $myStuff->pid;
			$formData['fscid'] = $myStuff->scid;
			$formData['fid'] = $myStuff->id;
			$formData['ftype'] = $myStuff->type;
			$formData['fissms'] = $myStuff->issms;
			$formData['fisvip'] = $myStuff->isvip;
			$formData['fimage'] = $myStuff->image;
			$formData['ftitle'] = $myStuff->title;
			$formData['fslug'] = $myStuff->slug;
			$formData['fcontent'] = $myStuff->content;
			$formData['fprice'] = $myStuff->price;
			$formData['fcontactname'] = $myStuff->contactname;
			$formData['fcontactemail'] = $myStuff->contactemail;
			$formData['fcontactphone'] = $myStuff->contactphone;
			$formData['fseotitle'] = $myStuff->seotitle;
			$formData['fseokeyword'] = $myStuff->seokeyword;
			$formData['fseodescription'] = $myStuff->seodescription;
			$formData['fregionid'] = $myStuff->regionid;
			$formData['fdistrictid'] = $myStuff->districtid;
			$formData['fcountview'] = $myStuff->countview;
			$formData['fcountreview'] = $myStuff->countreview;
			$formData['fstatus'] = $myStuff->status;
			$formData['fipaddress'] = $myStuff->ipaddress;
			$formData['fdatecreated'] = $myStuff->datecreated;
			$formData['fdatemodified'] = $myStuff->datemodified;

			//khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $formData['fid'], 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					//kiem tra quyen cua danh muc cha
					$checkerparent = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $formData['fparentid'], 0 , Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
					if(!$checkerparent)
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'stuff/index/permission/edit');
					}
				}
			}

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['stuffEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myStuff->pid = $formData['fpid'];
						$myStuff->scid = $formData['fscid'];
						$myStuff->type = $formData['ftype'];
						$myStuff->image = $formData['fimage'];
						$myStuff->title = $formData['ftitle'];
						$myStuff->slug = $formData['fslug'];
						$myStuff->content = $formData['fcontent'];
						$myStuff->price = $formData['fprice'];
						$myStuff->contactname = $formData['fcontactname'];
						$myStuff->contactemail = $formData['fcontactemail'];
						$myStuff->contactphone = $formData['fcontactphone'];
						$myStuff->seotitle = $formData['fseotitle'];
						$myStuff->seokeyword = $formData['fseokeyword'];
						$myStuff->seodescription = $formData['fseodescription'];
						$myStuff->regionid = $formData['fregionid'];
						$myStuff->districtid = $formData['fdistrictid'];
						$myStuff->status = $formData['fstatus'];

                        if($myStuff->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('stuff_edit', $myStuff->id, array());

                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}

			$_SESSION['stuffEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList'    => Core_Stuff::getStatusList(),
													'typeList'		=> Core_Stuff::getTypeList(),
													'stuffcategory'  => Core_Stuffcategory::getStuffcategorys(array('fparentid' => 0), '', 'ASC', ''),
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'] . ' &raquo; ' . $myStuff->title,
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myStuff = new Core_Stuff($id);
		if($myStuff->id > 0)
		{
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $myStuff->id, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_STUFF, $this->registry->me->id, $myStuff->parentid, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				}

				if(!$checker)
				{
					header('location: ' . $this->registry['conf']['rooturl_cms'].'stuff/index/permission/delete');
					exit();
				}
				else
				{
					//tien hanh xoa
					if($myStuff->delete())
					{
						$redirectMsg = str_replace('###id###', $myStuff->id, $this->registry->lang['controller']['succDelete']);

						$this->registry->me->writelog('stuff_delete', $myStuff->id, array());

						//xoa slug lien quan den item nay
						Core_Slug::deleteSlug($myStuff->slug, 'stuff', $myStuff->id);
					}
					else
					{
						$redirectMsg = str_replace('###id###', $myStuff->id, $this->registry->lang['controller']['errDelete']);
					}
				}

			}
			else
			{
				//tien hanh xoa
				if($myStuff->delete())
				{
					$redirectMsg = str_replace('###id###', $myStuff->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('stuff_delete', $myStuff->id, array());
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myStuff->id, $this->registry->lang['controller']['errDelete']);
				}
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

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;

		if($formData['fscid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errScidRequired'];
			$pass = false;
		}

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if($formData['fregionid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
			$pass = false;
		}


		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;

		if($formData['fuid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errUidRequired'];
			$pass = false;
		}

		if($formData['fpid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPidRequired'];
			$pass = false;
		}

		if($formData['fscid'] == '')
		{
			$error[] = $this->registry->lang['controller']['errScidRequired'];
			$pass = false;
		}

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}




		return $pass;
	}

	public function getDistrictAction()
	{
		$id = (int)$_POST['id'];

		$getDistrictList = Core_Region::getRegions(array('fparentid' => $id), '', 'ASC', '');

		echo '	<select name="fdistrictid" id="fdistrictid">';
					foreach($getDistrictList as $district)
					{
						echo '<option value="'.$district->id.'">' . $district->name . '</option>';
					};
		echo '	</select>';

	}


	public function importAction()
	{
		$oracle = new Oracle();

		$recordPerPage = 100;

		$countAll = $oracle->query($sqlCount = 'SELECT COUNT(*) FROM TGDD_NEWS.CLASSIFIEDADS');

		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}

		$page = ceil($total/$recordPerPage);

		for($i = 1; $i <= $page; $i++)
		{
			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sqlSelect = 'SELECT * FROM ( SELECT c.*, ROWNUM r FROM TGDD_NEWS.CLASSIFIEDADS c) WHERE r > '.$start.' AND r <= '.$end.'';
			//echo $sqlSelect . '<br />';
			$result = $oracle->query($sqlSelect);

			foreach($result as $res)
			{
				$imagepath = 'https://ecommerce.kubil.app/ClassifiedAds/';

				if($res['IMAGE'] != '')
				{
					$vefiry = '';

					$arrImage = explode(':', $res['IMAGE']);

					foreach($arrImage as $image)
					{
						if($image != '' && $vefify == '')
						{
							$imagepath .= $res['CLASSIFIEDADSID'] . '/' . $image;
						}
					}
				}

				//$imagepath .= $res['CLASSIFIEDADSID'] . '/' . $arrImage[1];

				//chuyen doi time oracle thanh timestamp
				$dateCreated = DateTime::createFromFormat('d-M-y', $res['CREATEDDATE']);

				//chuyen doi gia tri 0,1 thanh 2,1 cho status
				if($res['ISACTIVED'] == 0)
					$status = 2;
				else
					$status = $res['ISACTIVED'];

				$sqlImport = 'INSERT INTO ' . TABLE_PREFIX . 'stuff(
									p_id,
									sc_id,
									s_id,
									s_type,
									s_issms,
									s_isvip,
									s_image,
									s_title,
									s_slug,
									s_content,
									s_price,
									s_contactname,
									s_contactemail,
									s_contactphone,
									s_regionid,
									s_districtid,
									s_countview,
									s_countreview,
									s_status,
									s_datecreated)
								VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

				$stmt = $this->registry->db->query($sqlImport,array(
									(int)$res['PRODUCTID'],
									(int)$res['CATEGORYID'],
									(int)$res['CLASSIFIEDADSID'],
									(int)$res['TYPE'],
									(int)$res['ISSMS'],
									(int)$res['ISVIP'],
									(string)$res['IMAGE'],
									(string)$res['TITLE'],
									(string)$res['URL'],
									(string)$res['CONTENT'],
									(string)$res['PRICE'],
									(string)$res['CONTACTNAME'],
									(string)$res['CONTACTEMAIL'],
									(string)$res['CONTACTPHONE'],
									(int)$res['PROVINCEID'],
									(int)$res['DISTRICTID'],
									(int)$res['TOTALVIEWS'],
									(int)$res['COMMENTCOUNT'],
									(int)$status,
									Helper::strtotimedmy($dateCreated->format('d/m/Y'))
									));

				$id = $this->registry->db->lastInsertId();

				//update slug cho record sau khi import thanh cong
				$slug = Helper::codau2khongdau($res['TITLE'], true, true) . '-' . $id;

				$sqlupdate = 'UPDATE ' .TABLE_PREFIX . 'stuff
								SET s_slug = "' . (string)$slug . '"
								WHERE s_id = ' . $id . '';

				$this->registry->db->query($sqlupdate);

				//Script download image tu server ve
				// vi do tin test cua ben tgdd khong dung dinh dang file type nen khj chay script nay tam thoi tat check request image type trong class imageresizer
				$myStuff = new Core_Stuff();
				$myStuff->image = $imagepath;
				$myStuff->name = $res['IMAGE'];
				$myStuff->id = $id;
				$myStuff->importImage();

				if($stmt)
					echo $imagepath . ' <i>inserted</i> <br />';

				unset($imagepath);
			}
		}

	}

}

