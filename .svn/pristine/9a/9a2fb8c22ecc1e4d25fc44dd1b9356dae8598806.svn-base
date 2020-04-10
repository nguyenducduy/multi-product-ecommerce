<?php

Class Controller_Cms_Productcategory Extends Controller_Cms_Base
{
	private $recordPerPage = 40;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$nameFilter         = (string)($this->registry->router->getArg('name'));
		$slugFilter         = (string)($this->registry->router->getArg('slug'));
		$parentidFilter     = (int)($this->registry->router->getArg('parentid'));
		$displayorderFilter = (int)($this->registry->router->getArg('displayorder'));
		$statusFilter       = (int)($this->registry->router->getArg('status'));
		$idFilter           = (int)($this->registry->router->getArg('id'));
		$permission         = (string)$this->registry->router->getArg('permission');

		$flag = false;

		//check sort column condition
		$sortby                  = $this->registry->router->getArg('sortby');
		if($sortby               == '') $sortby = 'displayorder';
		$formData['sortby']      = $sortby;
		$sorttype                = $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
		$formData['sorttype']    = $sorttype;

		//display error permission
		switch($permission)
		{
			case 'add' : $error[] = $this->registry->lang['controller']['errorAddPermission'];
				break;
			case 'edit' : $error[] = $this->registry->lang['controller']['errorEditPermission'];
				break;
			case 'delete' : $error[] = $this->registry->lang['controller']['errorDeletePermission'];
				break;
			case 'filter' : $error[] = $this->registry->lang['controller']['errorFilterPermission'];
				break;
			case 'segment' : $error[] = $this->registry->lang['controller']['errorSegmentPermission'];
				break;
			case 'access' : $error[] = $this->registry->lang['controller']['errAccessPermission'];
				break;
		}



		/*if(!empty($_POST['fsubmitbulk']))
		{
			if($_SESSION['productcategoryBulkToken']==$_POST['ftoken'])
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
							$myProductcategory = new Core_Productcategory($id);

							if($myProductcategory->id > 0)
							{
								//tien hanh xoa
								if($myProductcategory->delete())
								{
									$deletedItems[] = $myProductcategory->id;
									$this->registry->me->writelog('productcategory_delete', $myProductcategory->id, array());
								}
								else
									$cannotDeletedItems[] = $myProductcategory->id;
							}
							else
								$cannotDeletedItems[] = $myProductcategory->id;
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

		}*/

		//change order of item
		if(!empty($_POST['fsubmitchangeorder']))
		{
			$displayorderList = $_POST['fdisplayorder'];
			foreach($displayorderList as $id => $neworder)
			{
				$myItem = new Core_Productcategory($id);
				if($myItem->id > 0 && $myItem->displayorder != $neworder)
				{
					$myItem->displayorder = $neworder;
					$myItem->updateData();
				}
			}

			$success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
		}

		$_SESSION['productcategoryBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
			$flag = true;
		}

		if($slugFilter != "")
		{
			$paginateUrl .= 'slug/'.$slugFilter . '/';
			$formData['fslug'] = $slugFilter;
			$formData['search'] = 'slug';
			$flag = true;
		}

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
			$flag = true;
		}

		if($displayorderFilter > 0)
		{
			$paginateUrl .= 'displayorder/'.$displayorderFilter . '/';
			$formData['fdisplayorder'] = $displayorderFilter;
			$formData['search'] = 'displayorder';
			$flag = true;
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
			$flag = true;
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
			$flag = true;
		}

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$list = array();
			$accessTicketSuffixWithoutId = $this->getAccessTicket('pcview_');
			$accessTicketSuffixObjectIdList = $this->registry->me->getAccessTicketSuffixId($accessTicketSuffixWithoutId);

			$formData['fidarr'] = $accessTicketSuffixObjectIdList;

		}
        else
        {
            $listroot = Core_Productcategory::getRootProductcategory(true);
            foreach($listroot as $root)
            {
                $formData['fidarr'][] = $root->id;
            }
        }

		if(count($formData['fidarr']) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_Productcategory::getProductcategorys($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);;
			$curPage = $page;
			//get latest account
			//$productcategorys = Core_Productcategory::getProductcategorys($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			$productcategorys = array();

			//$formData['fparent'] = true;
			$productcategorys = Core_Productcategory::getProductcategorys($formData, $sortby, $sorttype);
			if(!$flag)
			{
				$list = $productcategorys;

				if(count($list) > 0)
				{
					$parentlist = array();
					foreach ($list as $cat)
					{
						if($cat->parentid > 0)
						{
							$ok = false;
							foreach ($productcategorys as $catdata)
							{
								if($catdata->id == $cat->parentid)
								{
									$ok = true;
								}
							}
							if($ok)
							{
								$parentcat = new Core_Productcategory($cat->parentid);
							}
							else
							{
								$parentlist[] = $cat;
							}
						}
						else
						{
							$parentcat = $cat;
						}
						if($parentcat->parentid == 0)
						{
							if(count($parentcat) == 0)
							{
								$parentlist[] = $parentcat;
							}
							else
							{
								$ok = true;
								foreach ($parentlist as $parent)
								{
									if($parent->id == $parentcat->id)
									{
										$ok = false;
										break;
									}
								}
								if($ok)
									$parentlist[] = $parentcat;
							}
						}
					}

					if(count($parentlist) > 0)
					{
						$output = array();
						foreach ($parentlist as $parent)
						{
							$output = array_merge($output, Core_Productcategory::getFullSubCategoryList($parent->id, $list));
						}
						$productcategorys = $output;
					}

				}
			}
			else
			{
				if(count($productcategorys) > 0)
				{
					foreach ($productcategorys as $productcategory)
					{
						$productcategory->parent = Core_Productcategory::getFullParentProductCategorys($productcategory->id);
					}
				}
			}
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

		$productcategoryList = array();
		$parentCategory1 = Core_Productcategory::getProductcategorys(array(), 'parentid', 'ASC');
		for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
		{
			if($parentCategory1[$i]->parentid == 0)
			{
				$productcategoryList[] = $parentCategory1[$i];
				$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
				for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
				{
					$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
					$productcategoryList[] = $parentCategory2[$j];

					$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
					foreach ($subCategory as $sub)
					{
						$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
						$productcategoryList[] = $sub;
					}
				}
			}
		}



		$this->registry->smarty->assign(array(	'productcategorys' 	=> $productcategorys,
			'parentcategorys' => $parentcategorys,
			'listcat'		=> $listcat,
			'listsubcat'	=> $listsubcat,
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
			'productcategoryList' => $productcategoryList,
			'statusList'	=> Core_Productcategory::getStatusList(),
			'parentCategory' => $parentCategory,
		));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
			'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			$error 	= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$slugList = array();


			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['productcategoryAddToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					//get all slug related to current slug
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');


					if($this->addActionValidator($formData, $error))
					{
						$myProductcategory = new Core_Productcategory();

						if($formData['fparentid'] > 0)
						{
							$myparentCategory = new Core_Productcategory($formData['fparentid']);
						}

						$myProductcategory->image                 = $formData['fimage'];
						$myProductcategory->name                  = Helper::plaintext($formData['fname']);
						$myProductcategory->displaytext           = Helper::plaintext($formData['fdisplaytext']);
						$myProductcategory->slug                  = ($formData['fslug'] == '') ? Helper::codau2khongdau($formData['fname'],true) : $formData['fslug'];
						$myProductcategory->summary               = $formData['fsummary'];
						$myProductcategory->blockhomepagehorizon  = $formData['fblockhomepagehorizon'];
						$myProductcategory->blockhomepagevertical = $formData['fblockhomepagevertical'];
						$myProductcategory->blockcategory         = $formData['fblockcategory'];
						$myProductcategory->seotitle              = Helper::plaintext($formData['fseotitle']);
						$myProductcategory->seokeyword            = ($myProductcategory->seokeyword != '') ? Helper::plaintext($formData['fseokeyword']) : $myProductcategory->name . ',' . $myparentCategory->name . ',' . $this->registry['conf']['rooturl'];
						$myProductcategory->seodescription        = Helper::plaintext($formData['fseodescription']);
						$myProductcategory->metarobot             = Helper::plaintext($formData['fmetarobot']);
						$myProductcategory->parentid              = $formData['fparentid'];
						$myProductcategory->status                = $formData['fstatus'];
						$myProductcategory->itemdisplayorder      = $formData['fitemdisplayorder'];
						$myProductcategory->appendtoproductname   = $formData['fappendtoproductname'];
						$myProductcategory->titlecol1             = $formData['ftitlecol1'];
						$myProductcategory->titlecol2             = $formData['ftitlecol2'];
						$myProductcategory->titlecol3             = $formData['ftitlecol3'];
						$myProductcategory->desccol1              = $formData['fdesccol1'];
						$myProductcategory->desccol2              = $formData['fdesccol2'];
						$myProductcategory->desccol3              = $formData['fdesccol3'];
						$myProductcategory->topseokeyword         = $formData['ftopseokeyword'];
						$myProductcategory->footerkey             = $formData['ffooterkey'];
						$myProductcategory->categoryreference     = $formData['fcategoryreference'];

						if($myProductcategory->addData())
						{
							$success[] = $this->registry->lang['controller']['succAdd'];
							$this->registry->me->writelog('productcategory_add', $myProductcategory->id, array());
							$formData = array();

							///////////////////////////////////
							//Add Slug base on slug of page
							$mySlug = new Core_Slug();
							$mySlug->uid = $this->registry->me->id;
							$mySlug->slug = $myProductcategory->slug;
							$mySlug->controller = 'productcategory';
							$mySlug->objectid = $myProductcategory->id;
							if(!$mySlug->addData())
							{
								$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

								//reset slug of current item
								$myProductcategory->slug = '';
								$myProductcategory->updateData();
							}
							//end Slug process
							////////////////////////////////
							// //add new role for new category
							// $myRoleUser = new Core_RoleUser();


							// $myRoleUser->type = Core_RoleUser::TYPE_PRODUCTCATEGORY;
							// $myRoleUser->uid = $this->registry->me->id;
							// $myRoleUser->value = Core_RoleUser::getRoleValue('change');
							// $myRoleUser->objectid = $myProductcategory->id;
							// $myRoleUser->creatorid = $this->registry->me->id;
							// $myRoleUser->status = Core_RoleUser::STATUS_ENABLE;

							// if($myRoleUser->addData())
							// {
							//     $ok = true;
							//     $this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
							// }
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errAdd'];
						}
					}
				}

			}


			$productcategoryList = Core_Productcategory::getProductcategorys($formData , 'name' , 'ASC');


			$_SESSION['productcategoryAddToken']=Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
				'productcategoryList'  => $productcategoryList,
				'statusList'	=> Core_Productcategory::getStatusList(),
				'itemdisplayorderList' => Core_Productcategory::getitemdisplayorderList(),													'redirectUrl'	=> $this->getRedirectUrl(),
				'error'			=> $error,
				'success'		=> $success,
				'slugList'		=> $slugList,
			));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
			$this->registry->smarty->assign(array(
				'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
				'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/access');
			exit();
		}
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductcategory = new Core_Productcategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductcategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();
			$cond = array();

			$formData['fbulkid'] = array();


			$formData['fid']                     = $myProductcategory->id;
			$formData['fimage']                  = $myProductcategory->image;
			$formData['fname']                   = $myProductcategory->name;
			$formData['fdisplaytext']            = $myProductcategory->displaytext;
			$formData['fslug']                   = $myProductcategory->slug;
			$formData['fsummary']                = $myProductcategory->summary;
			$formData['fblockhomepagehorizon']   = $myProductcategory->blockhomepagehorizon;
			$formData['fblockhomepagevertical']  = $myProductcategory->blockhomepagevertical;
			$formData['fblockcategory']          = $myProductcategory->blockcategory;
			$formData['fseotitle']               = $myProductcategory->seotitle;
			$formData['fseokeyword']             = $myProductcategory->seokeyword;
			$formData['fseodescription']         = $myProductcategory->seodescription;
			$formData['fmetarobot']              = $myProductcategory->metarobot;
			$formData['fparentid']               = $myProductcategory->parentid;
			$formData['fcountitem']              = $myProductcategory->countitem;
			$formData['fdisplayorder']           = $myProductcategory->displayorder;
			$formData['fitemdisplayorder']       = $myProductcategory->itemdisplayorder;
			$formData['fstatus']                 = $myProductcategory->status;
			$formData['fdatecreated']            = $myProductcategory->datecreated;
			$formData['fdatemodified']           = $myProductcategory->datemodified;
			$formData['fappendtoproductname']    = $myProductcategory->appendtoproductname;
			$formData['ftitlecol1']              = $myProductcategory->titlecol1;
			$formData['ftitlecol2']              = $myProductcategory->titlecol2;
			$formData['ftitlecol3']              = $myProductcategory->titlecol3;
			$formData['fdesccol1']               = $myProductcategory->desccol1;
			$formData['fdesccol2']               = $myProductcategory->desccol2;
			$formData['fdesccol3']               = $myProductcategory->desccol3;
			$formData['ftopseokeyword']          = $myProductcategory->topseokeyword;
			$formData['ffooterkey']              = $myProductcategory->footerkey;
			$formData['foldproducthomepagelist'] = $myProductcategory->producthomepagelist;
			$formData['fcategoryreference'] = $myProductcategory->categoryreference;


			//Current Slug
			$formData['fslugcurrent'] = $myProductcategory->slug;


			if($myProductcategory->image != '')
			{
				$formData['fimageurl'] = $myProductcategory->getSmallImage();
			}

			//khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = false;

				if( $formData['fparentid'] > 0 )
                {
                	//get full parentcategory from cache
                	$parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($formData['fid']);

                    //create suffix
                    $suffix = 'pcedit_' . $parentcategorylist[0];
                    $checker = $this->checkAccessTicket($suffix);
                }
                else
                {
                    //create suffix
                    $suffix = 'pcedit_' . $formData['fid'];
                    $checker = $this->checkAccessTicket($suffix);

                }

                if(!$checker)
                {
                    header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/edit');
                }
			}

			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['productcategoryEditToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);
					/////////////////////////
					//get all slug related to current slug
					$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
					if($formData['fslug'] != '')
						$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

					if($this->editActionValidator($formData, $error))
					{

						if($formData['fparentid'] > 0)
						{
							$myparentCategory = new Core_Productcategory($formData['fparentid']);
						}

						$myProductcategory->name                = Helper::plaintext($formData['fname']);
						$myProductcategory->displaytext         = Helper::plaintext($formData['fdisplaytext']);
						if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
						{
						$myProductcategory->slug                = $formData['fslug'];
						}
						$myProductcategory->summary               = $formData['fsummary'];
						$myProductcategory->blockhomepagehorizon  = $formData['fblockhomepagehorizon'];
						$myProductcategory->blockhomepagevertical = $formData['fblockhomepagevertical'];
						$myProductcategory->blockcategory         = $formData['fblockcategory'];
						$myProductcategory->seotitle              = Helper::plaintext($formData['fseotitle']);
						$myProductcategory->seokeyword            = ($formData['fseokeyword'] != '') ? Helper::plaintext($formData['fseokeyword']) : $myProductcategory->name . ',' . $myparentCategory->name . ',' . $this->registry['conf']['rooturl'];
						$myProductcategory->seodescription        = Helper::plaintext($formData['fseodescription']);
						$myProductcategory->metarobot             = Helper::plaintext($formData['fmetarobot']);
						$myProductcategory->parentid              = $formData['fparentid'];
						$myProductcategory->displayorder          = $formData['fdisplayorder'];
						$myProductcategory->status                = $formData['fstatus'];
						$myProductcategory->itemdisplayorder      = $formData['fitemdisplayorder'];
						$myProductcategory->appendtoproductname   = $formData['fappendtoproductname'];
						$myProductcategory->titlecol1             = $formData['ftitlecol1'];
						$myProductcategory->titlecol2             = $formData['ftitlecol2'];
						$myProductcategory->titlecol3             = $formData['ftitlecol3'];
						$myProductcategory->desccol1              = $formData['fdesccol1'];
						$myProductcategory->desccol2              = $formData['fdesccol2'];
						$myProductcategory->desccol3              = $formData['fdesccol3'];
						$myProductcategory->topseokeyword         = $formData['ftopseokeyword'];
						$myProductcategory->footerkey             = $formData['ffooterkey'];
						$myProductcategory->categoryreference     = $formData['fcategoryreference'];



						//$myProductcategory->producthomepagelist = ;
						if(count($formData['fproducthomepagelist']) > 0)
						{
							$myProductcategory->producthomepagelist = implode(',', $formData['fproducthomepagelist']);
						}
						else
						{
							$homepagelist = '';
							if(count($formData['fhomedisplay']) > 0)
							{
								asort($formData['fhomedisplay']);

								$counter = count($formData['fhomedisplay']);
								$i = 0;
								foreach ($formData['fhomedisplay'] as $productid => $display)
								{
									if($i == $counter-1)
									{
										$homepagelist .= (isset($formData['productreplace'][$productid])) ? $formData['productreplace'][$productid] : $productid;
									}
									else
									{
										if(isset($formData['productreplace'][$productid]))
										{
											$homepagelist .= $formData['productreplace'][$productid] . ',';
										}
										else
										{
											$homepagelist .= $productid . ',';
										}
									}

									$i++;
								}

								if(count($formData['fhomedisplaynew']) > 0 && count($formData['productreplacenew']))
								{
									$counter = count($formData['productreplacenew']);
									$i = 0;
									foreach ($formData['fhomedisplaynew'] as $key => $display)
									{
										if(isset($formData['productreplacenew'][$key]))
										{
											if($i == $counter-1)
											{
												if($i == 0)
												{
													$homepagelist .= ',' . $formData['productreplacenew'][$key];
												}
												else
													$homepagelist .= $formData['productreplacenew'][$key];
											}
											else
											{
												if($i == 0)
												{
													if($i == $counter-1)
													{
														$homepagelist .= ',' . $formData['productreplacenew'][$key];
													}
													else
													{
														$homepagelist .= ',' . $formData['productreplacenew'][$key] . ',';
													}
												}
												else
												{
													if($i == $counter-1)
													{
														$homepagelist .= $formData['productreplacenew'][$key];
													}
													else
													{
														$homepagelist .= $formData['productreplacenew'][$key] . ',';
													}
												}
											}
										}

										$i++;
									}
								}
								$myProductcategory->producthomepagelist = $homepagelist;
							}
						}

						///CAP NHAT THONG TIN CUA TOPITEM
						//$myProductcategory->topitemlist = count($formData['fproducttopitemlist']) > 0 ? implode(',' , $formData['fproducttopitemlist']) : '';
						if(count($formData['fproducttopitemlist']) > 0)
						{
							if(count($formData['fdefaulttopitemlist']) > 0)
							{
								$formData['fproducttopitemlist'] = array_merge($formData['fproducttopitemlist'] , $formData['fdefaulttopitemlist']);
							}
							$myProductcategory->topitemlist = implode(',' , $formData['fproducttopitemlist']);
						}
						else
						{
							if(count($formData['fdefaulttopitemlist']) > 0)
							{
								$myProductcategory->topitemlist = implode(',' , $formData['fdefaulttopitemlist']);
							}
							else
							{
								$myProductcategory->topitemlist = '';
							}
						}

						if($myProductcategory->updateData())
						{
							$success[] = $this->registry->lang['controller']['succUpdate'];
							$this->registry->me->writelog('productcategory_edit', $myProductcategory->id, array());
							if($myProductcategory->image != '')
							{
								$formData['fimageurl'] = $myProductcategory->getSmallImage();
							}

							///////////////////////////////////
							if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
							{
								//Add Slug base on slug of page
								if($formData['fslug'] != $formData['fslugcurrent'])
								{
									$mySlug = new Core_Slug();
									$mySlug->uid = $this->registry->me->id;
									$mySlug->slug = $myProductcategory->slug;
									$mySlug->controller = 'productcategory';
									$mySlug->objectid = $myProductcategory->id;
									if(!$mySlug->addData())
									{
										$error[] = 'Item Added but Slug can not added. Try again or use another slug for this item.';

										//reset slug of current item
										$myProductcategory->slug = $formData['fslugcurrent'];
										$myProductcategory->updateData();
									}
									else
									{
										//Add new slug ok, keep old slug but change the link to keep the reference to new ref
										Core_Slug::linkSlug($mySlug->id, $formData['fslugcurrent'], 'productcategory', $myProductcategory->id);
									}
								}

								//end Slug process
							}
							////////////////////////////////
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errUpdate'];
						}
					}
				}
			}

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$roles = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id) , 'id' , 'ASC','',false,true);
				if(count($roles) > 0)
				{
					foreach($roles as $role)
					{
						$pc = new Core_Productcategory($role->objectid);
						$cond['fidarr'][] =  $role->objectid;
					}
				}
			}
			//$productcategoryList = Core_Productcategory::getProductcategorys($cond , 'name' , 'ASC');
			$productcategoryList = Core_Productcategory::getFullCategoryList();

			//get product list in home page
			$producthomepagelist = array();
			if(strlen($myProductcategory->producthomepagelist) > 0)
			{
				$pidlist = explode(',', $myProductcategory->producthomepagelist);
				foreach ($pidlist as $pid)
				{
					$product = new Core_Product($pid,true);
					$producthomepagelist[] = $product;
				}
			}

			//get product top item
			$producttopitemlist = array();
			if(strlen($myProductcategory->topitemlist) > 0)
			{
				$pidtopitem = explode(',' , $myProductcategory->topitemlist);
				foreach($pidtopitem as $pid)
				{
					$product = new Core_Product($pid , true);
					$producttopitemlist[] = $product;
				}
			}

			$_SESSION['productcategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'productcategoryList' => $productcategoryList,
													'itemdisplayorderList' => Core_Productcategory::getitemdisplayorderList(),
													'slugList'	=> $slugList,
													'statusList' => Core_Productcategory::getStatusList(),
													'producthomepagelist' => $producthomepagelist,
													'numberproductenough' => (12 - count($producthomepagelist)),
													'producttopitemlist' => $producttopitemlist,
												));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
				'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'].' '.$myProductcategory->name,
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
		$myProductcategory = new Core_Productcategory($id);
		if($myProductcategory->id > 0)
		{
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			{
				$checker = false;

				//get full parentcategory from cache
                $parentcategoryinfolist = Core_Productcategory::getFullparentcategoryInfoFromCahe($myProduct->pcid);
                $parentcategorylist = array_keys($parentcategoryinfolist);

                //create suffix
                $suffix = 'pcdelete_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);

                if($checker)
                {
                	//tien hanh xoa
					if($myProductcategory->delete())
					{
						$redirectMsg = str_replace('###id###', $myProductcategory->id, $this->registry->lang['controller']['succDelete']);

						$this->registry->me->writelog('productcategory_delete', $myProductcategory->id, array());

						//xoa slug lien quan den item nay
						Core_Slug::deleteSlug($myProductcategory->slug, 'productcategory', $myProductcategory->id);
					}
					else
					{
						$redirectMsg = str_replace('###id###', $myProductcategory->id, $this->registry->lang['controller']['errDelete']);
					}
                }
                else
                {
                	header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/delete');
					exit();
                }
			}
			else
			{
				//tien hanh xoa
				if($myProductcategory->delete())
				{

					$redirectMsg = str_replace('###id###', $myProductcategory->id, $this->registry->lang['controller']['succDelete']);

					$this->registry->me->writelog('productcategory_delete', $myProductcategory->id, array());

					//xoa slug lien quan den item nay
					Core_Slug::deleteSlug($myProductcategory->slug, 'productcategory', $myProductcategory->id);
				}
				else
				{
					$redirectMsg = str_replace('###id###', $myProductcategory->id, $this->registry->lang['controller']['errDelete']);
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

	public function filterAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$redirectUrl = $this->getRedirectUrl();
		$productcategory = new Core_ProductCategory($id);
		$tab = 1;
		if($productcategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$warning    = array();

			$error1 		= array();
			$success1 	= array();
			$warning1    = array();

			$error2 		= array();
			$success2 	= array();
			$warning2    = array();

			$contents 	= '';
			$formData 	= array();

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // khong phai la admin
			{
				$checker = false;

                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($productcategory->id);

                //create suffix
                $suffix = 'pcfilter_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);
			}
			else
			{
				$checker = true;
			}

			//tien hanh filter
			if($checker)
			{

				//tien hanh cap nhat filter
				if(!empty($_POST['fsubmit']))
				{
					if($_SESSION['productcategoryFilterToken'] == $_POST['ftoken'])
					{
						$formData = array_merge($formData, $_POST);

						//xoa tat cac cac filter cua attribute
						if($this->filterValidatorAction($formData, $error))
						{
							$result = Core_ProductAttributeFilter::deleteFilterByCategory($id);
							$ok = true;
							if(count($formData['fname']) > 0)
							{
								$ok = false;
								foreach($formData['fname'] as $paid=>$paname)
								{
									$myFilter = new Core_ProductAttributeFilter();
									$myFilter->pcid = $id;
									$myFilter->paid = $paid;
									$myFilter->paname = $paname;
									$myFilter->position = $formData['fposition'][$paid];
									$myFilter->display = $formData['fdisplayname'][$paid];
									$myFilter->displayorder = $formData['fdisplayorder'][$paid];
									$myFilter->displayreport = isset($formData['fdisplayreport'][$paid]) ? 1 : 0;
									$myFilter->panameseo = Helper::codau2khongdau($paname,true,true);
									$dataarr = array();
									if(count($formData['ffiltername'][$paid]) > 0)
									{
										foreach ($formData['ffiltername'][$paid] as $key => $filtername)
										{
											if(strlen($filtername) > 0)
											{
												$dataarr[$key] = $filtername . '##' . Helper::codau2khongdau($filtername,true,true) . '##' .$formData['ftype'][$paid][$key] . '##';

												if($formData['ftype'][$paid][$key] == Core_ProductAttributeFilter::TYPE_EXACT)
												{
													$dataarr[$key] .= (count($formData['fvalue'][$paid][$key]) > 0) ? implode('#' , $formData['fvalue'][$paid][$key]) : '';
												}

												else if($formData['ftype'][$paid][$key] == Core_ProductAttributeFilter::TYPE_LIKE)
												{
													$dataarr[$key] .= $formData['flikevalue'][$paid][$key];
												}
												else if($formData['ftype'][$paid][$key] == Core_ProductAttributeFilter::TYPE_WEIGHT)
												{
													$dataarr[$key] .= (float)$formData['fweightfrom'][$paid][$key] . '##' . (float)$formData['fweightto'][$paid][$key];
												}
											}
										}
									}
									$myFilter->value = implode('###' , $dataarr);
									//echodebug($myFilter->value,true);
									if($myFilter->addData() > 0)
									{
										$ok = true;
									}
								}
							}

							//update filter price
							if(count($formData['fpricename']) > 0)
							{
								$ok = false;
								$valueprice = array();
								foreach($formData['fpricename'] as $key => $pricename)
								{
									$valueprice[] = $pricename . '##' . Helper::codau2khongdau($pricename,true,true) . '##' . Core_ProductAttributeFilter::TYPE_PRICE . '##' . (($formData['fpricefrom'][$key] != '') ? Helper::refineMoneyString($formData['fpricefrom'][$key]) : 0 ). '##' . (($formData['fpriceto'][$key] != '') ? Helper::refineMoneyString($formData['fpriceto'][$key]) : 0);
								}
								$pricefilter = new Core_ProductAttributeFilter();
								$pricefilter->pcid = $id;
								$pricefilter->paname = 'Giá';
								$pricefilter->panameseo = Helper::codau2khongdau('Giá',true,true);
								$pricefilter->display = 'Tìm theo giá';
								$pricefilter->position = Core_ProductAttributeFilter::LEFT_POSITION;
								$pricefilter->value = implode('###' , $valueprice);
								if($pricefilter->addData() > 0)
								{
									$ok = true;
								}
							}
						}

					}

					if($ok == true)
					{
						$success[] = $this->registry->lang['controller']['succUpdateFilter'];
						$this->registry->me->writelog('productcategory_edit', $id, array());
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdateFilter'];
					}
				}

				//cap nhat vendorlist
				if(isset($_POST['fsubmitvendorlist']))
				{

					if(!isset($_POST['fbulkid']))
					{
						$warning1 = $this->registry->lang['default']['bulkItemNoSelected'];
					}
					else
					{
						$formData['fbulkid'] = $_POST['fbulkid'];
						$formData['fvdisplayorder'] = $_POST['fvdisplayorder'];
						asort($formData['fvdisplayorder']);
						$idvendor = array();
						foreach($formData['fvdisplayorder'] as $vid => $order)
						{
							if(in_array($vid, $formData['fbulkid']))
							{
								$idvendor[] = $vid;
							}
						}
						//$productcategory->vendorlist = implode(",", $formData['fbulkid']);
						if(count($idvendor) > 0)
						{
							$productcategory->vendorlist = implode(",", $idvendor);
						}
						else
						{
							$productcategory->vendorlist = '';
						}

						if($productcategory->updateData())
						{
							$success1[] = $this->registry->lang['controller']['succVendorList'];
						}
						else
						{
							$error1[] = $this->registry->lang['controller']['errVendorList'];
						}
					}

					$tab = 2;

				}
				//cap nhat trong so cua san pham
				if(isset($_POST['fsubmitweightlist']))
				{
					$ok = false;
					$formData['fweight'] = $_POST['fweight'];
					foreach($formData['fweight'] as $paid => $valueseoattr)
					{
						foreach($valueseoattr as $valueseo => $weight)
						{
							$result = Core_RelProductAttribute::updateweightbyattribute($valueseo, $paid, $weight);
							if($result)
							{
								$ok = true;
							}
						}
					}

					if($ok)
					{
						$success2[] = $this->registry->lang['controller']['succWeightList'];
					}
					else
					{
						$error2[] =  $this->registry->lang['controller']['errWeightList'];
					}

					$tab = 3;
				}


				if($productcategory->parentid > 0)
				{
					$productAttributeList = Core_ProductAttribute::getProductAttributes(array('fpcid' => $id), 'name' , 'ASC');
					//lay tat cac cac gia tri cua thuoc tinh
					for($i = 0 , $counter = count($productAttributeList) ; $i < $counter ; $i++)
					{
						$values = Core_RelProductAttribute::getRelProductAttributeByCategory(array('fpcid' => $productcategory->id, 'fpaid'=>$productAttributeList[$i]->id),'weight' , 'DESC',true);

						if(count($values) > 0)
						{
							foreach($values as $value)
							{
								$value->value = addslashes($value->value);
							}
						}

						$productAttributeList[$i]->actor = $values;

					}
					//echodebug($productAttributeList,true);
					if(count($productAttributeList) == 0)
					{
						$warning[] = $this->registry->lang['controller']['errNoAttribute'];
					}

					//lay tat cac cac filter da co san
					$filterList = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid'=> $id ,'fpaidthan'=>0),'id','ASC');
					if(count($filterList) > 0)
					{
						$filterIdList = array();
						foreach ($filterList as $filter)
						{
							$values = array();
							$values = explode('###', $filter->value);

							foreach($values as $key => $data)
							{
								$filterinfo = explode('##', $data);
								$filter->type[$key] = $filterinfo[2];
								$filter->filtername[$key] = $filterinfo[0];

								if($filter->type[$key] == Core_ProductAttributeFilter::TYPE_EXACT)
								{
									$filter->exactfilter[$key] = explode('#', $filterinfo[3]);
								}
								else if($filter->type[$key] ==  Core_ProductAttributeFilter::TYPE_LIKE)
								{
									$filter->likevalue[$key] = $filterinfo[3];
								}
								else if($filter->type[$key] ==  Core_ProductAttributeFilter::TYPE_WEIGHT)
								{
									//$weightinfo = explode('##', $filterinfo[3]);
									$filter->weightfrom[$key] = $filterinfo[3];
									$filter->weightto[$key] = $filterinfo[4];
									foreach($productAttributeList as $pa)
									{
										if($filter->paid == $pa->id)
										{
											$filter->unit[$key] = $pa->unit;
										}
									}
								}
							}


							$filterIdList[] = $filter->paid;
						}

					}
				}

				//lay danh sach tat ca vendor
				$vendorList = array();
				$vendorList = Core_Product::getVendorFromCategories(array($id));
				if(count($vendorList) == 0)
				{
					//lay tat ca danh muc con cua san pham
					$subcategorylist = Core_Productcategory::getFullSubCategory($id);
					if(count($subcategorylist) > 0)
					{
						$vendorList = Core_Product::getVendorFromCategories($subcategorylist);
					}

				}


				//get list price of product
				$prices = Core_ProductAttributeFilter::getProductAttributeFilters(array('fpcid' => $id, 'fpaid' => 0) , 'id' , 'ASC' , '0,1');
				//get price list
				if(count($prices) > 0)
				{
					$price = $prices[0];
					$datas = explode('###' , $price->value);
					foreach($datas as $data)
					{
						$dataarr = explode('##' , $data);
						$price->pricename[] = $dataarr[0];
						$price->pricefrom[] = Helper::formatPrice($dataarr[3]);
						$price->priceto[] = Helper::formatPrice($dataarr[4]);
					}
				}


				//lay vendor da duoc filter san neu co
				$vendorFilters = explode(',', $productcategory->vendorlist);

				$_SESSION['productcategoryFilterToken'] = Helper::getSecurityToken();//Tao token moi

				$this->registry->smarty->assign(array(	'productcategory' => $productcategory,
					'formData' 	=> $formData,
					'redirectUrl'=> $redirectUrl,
					'error'		=> $error,
					'success'	=> $success,
					'warning'	=> $warning,
					'productAttributeList' => $productAttributeList,
					'filterList'	=>	$filterList,
					'positionList' => Core_ProductAttributeFilter::getPositionList(),
					'filterIdList' => $filterIdList,
					'vendorList'  => $vendorList,
					'vendorFilters' => $vendorFilters,
					'tab' => $tab,
					'error1' => $error1,
					'success1' => $success1,
					'warning1' => $warning1,
					'error2' => $error2,
					'success2' => $success2,
					'warning2' => $warning2,
					'typeList' => Core_ProductAttributeFilter::getTypeList(),
					'price' => $price,
				));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'filter.tpl');
				$this->registry->smarty->assign(array(
					'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'].' Filter: '.$productcategory->name,
					'contents' 			=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else
			{
				header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/filter');
				exit();
			}
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

	/**
	 * [pricesegmentAction description]
	 * @return [type] [description]
	 */
	public function pricesegmentAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$act = (string)$this->registry->router->getArg('act');
		$redirectUrl = $this->getRedirectUrl();
		$productcategory = new Core_ProductCategory($id);
		if($productcategory->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer')) // neu khong phai la admin
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $productcategory->id, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $productcategory->parentid, 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				}
			}
			else
			{
				$checker = true;
			}

			if($checker)
			{
				if(!empty($_POST['fsubmit']))
				{
					if($_SESSION['productcategorySegmentToken'] == $_POST['ftoken'])
					{
						$formData = array_merge($formData, $_POST);
						$ok = false;

						$segmentString = '';
						$havedata = false;
						//kiem tra mang dieu
						foreach($formData['fsegment'] as $key=>$value)
						{
							if($value != '')
							{
								$havedata = true;
								break;
							}
						}

						if($havedata)
						{
							$count = 0;
							for($i = 0 ; $i < count($formData['fsegment']) ; $i+=3)
							{
								if(strlen((string)$formData['fsegment'][$i]) > 0)
								{
									$name = str_replace('#', '', (string)$formData['fsegment'][$i]);
									$fromPrice = Helper::refineMoneyString($formData['fsegment'][$i+1]);
									$toPrice = Helper::refineMoneyString($formData['fsegment'][$i+2]);
									if($fromPrice == 0 && $toPrice == 0)
									{
										$count = count($formData['fsegment'])/3;
										break;
									}
								}
								else
								{
									$count++;
								}

							}
							if($count == count($formData['fsegment']) / 3)
							{
								$error[] = $this->registry->lang['controller']['errSegment'];
							}
							else
							{
								for($i = 0 ; $i < count($formData['fsegment']) ; $i+=3)
								{
									if(strlen((string)$formData['fsegment'][$i]) > 0)
									{
										$name = str_replace('#', '', (string)$formData['fsegment'][$i]);
										$fromPrice = Helper::refineMoneyString($formData['fsegment'][$i+1]);
										$toPrice = Helper::refineMoneyString($formData['fsegment'][$i+2]);
										if($fromPrice > 0 || $toPrice > 0)
										{
											if($i == (count($formData['fsegment'])-3))
											{
												$segmentString .= $name .'#' . $fromPrice . '#' . $toPrice;
											}
											else
											{
												$segmentString .= $name .'#' . $fromPrice . '#' . $toPrice . '##';
											}
										}
									}

								}
							}
						}

					}

					$productcategory->pricesegment = $segmentString;
					if($productcategory->updateData())
					{
						$ok = true;
					}

					if($ok == true)
					{
						$success[] = $this->registry->lang['controller']['succUpdateSegment'];
						$this->registry->me->writelog('productcategory_edit', $id, array());
						$act = '';
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errUpdateSegment'];
					}
				}
				$formData['fid'] = $id;
				$keyid = $id;
				if($act == '')
				{
					$segmentList = Core_Productcategory::getPriceSegment($productcategory->id);
					//echodebug($segmentList,true);
					if(count($segmentList) > 0)
					{
						foreach($segmentList as $key=>$values)
						{
							if($key != $productcategory->id)
							{
								$parentcategory = new Core_Productcategory($key);
								$keyid = $key;
							}
						}
					}

					if($keyid != $productcategory->id)
					{
						$productcategory->pricesegment =$segmentList[$keyid][0];
					}
					else
					{
						$productcategory->pricesegment =$segmentList[$keyid];
					}
				}
				$_SESSION['productcategorySegmentToken'] = Helper::getSecurityToken();//Tao token moi

				$this->registry->smarty->assign(array(	'productcategory' => $productcategory,
					'parentcategory' => $parentcategory,
					'formData' 	=> $formData,
					'redirectUrl'=> $redirectUrl,
					'error'		=> $error,
					'success'	=> $success,
					'warning'	=> $warning,
				));
				$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'priceSegment.tpl');
				$this->registry->smarty->assign(array(
					'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'].' Filter: '.$productcategory->name,
					'contents' 			=> $contents));
				$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
			}
			else
			{
				header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/segment');
				exit();
			}

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

	public function roleAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token

		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
		$permission = $this->registry->router->getArg('permission');

		switch ($permission) {
			case 'delegate':
				$error[] = $this->registry->lang['controller']['errorAccess'];
				break;
			case 'access' :
				$error[] = $this->registry->lang['controller']['errorAccess'];
				break;
		}


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$valueFilter = (int)($this->registry->router->getArg('value'));
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
		$subobjectidFilter = (int)($this->registry->router->getArg('subobjectid'));
		$creatoridFilter = (int)($this->registry->router->getArg('creatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$idFilter = (int)($this->registry->router->getArg('id'));


		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/role/';

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($valueFilter > 0)
		{
			$paginateUrl .= 'value/'.$valueFilter . '/';
			$formData['fvalue'] = $valueFilter;
			$formData['search'] = 'value';
		}

		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
		}

		if($subobjectidFilter > 0)
		{
			$paginateUrl .= 'subobjectid/'.$subobjectidFilter . '/';
			$formData['fsubobjectid'] = $subobjectidFilter;
			$formData['search'] = 'subobjectid';
		}

		if($creatoridFilter > 0)
		{
			$paginateUrl .= 'creatorid/'.$creatoridFilter . '/';
			$formData['fcreatorid'] = $creatoridFilter;
			$formData['search'] = 'creatorid';
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

		if(!empty($_POST['fsubmitbulk']))
		{
			if($_SESSION['roleuserBulkToken']==$_POST['ftoken'])
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
						set_time_limit(0);
						$delArr = $_POST['fbulkid'];
						$deletedItems = array();
						$cannotDeletedItems = array();
						foreach($delArr as $id)
						{
							//check valid user and not admin user
							$myRoleUser = new Core_RoleUser($id);

							if($myRoleUser->id > 0)
							{
								//tien hanh xoa
								if($myRoleUser->delete())
								{
									$deletedItems[] = $myRoleUser->id;
									$this->registry->me->writelog('productcategory_delete', $myRoleUser->id, array());
								}
								else
									$cannotDeletedItems[] = $myRoleUser->id;
							}
							else
								$cannotDeletedItems[] = $myRoleUser->id;
						}

						if(count($deletedItems) > 0)
							$success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succRoleDelete']);

						if(count($cannotDeletedItems) > 0)
							$error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errRoleDelete']);
					}
					else
					{
						//bulk action not select, show error
						$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
					}
				}
			}

		}

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$formData['fcreatorid'] = $this->registry->me->id;
		}
		$formData['ftypearr'] = array(Core_RoleUser::TYPE_PRODUCTCATEGORY, Core_RoleUser::TYPE_PRODUCT, Core_RoleUser::TYPE_PRODUCTATTRIBUTE, Core_RoleUser::TYPE_SALE);
		//tim tong so
		$total = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, 0, true,true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		//$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		$roleusers = Core_RoleUser::getRoleUsers($formData, $sortby, $sorttype,'',false,true);
		if(count($roleusers) > 0)
		{
			//$list = $roleusers;
			//$roleusers = array();
			foreach($roleusers as $roleuser)
			{
				$roleuser->actor = new Core_User($roleuser->uid);
				$roleuser->productcategory = new Core_Productcategory($roleuser->objectid);
				//$roleuser->productcategory->parent = Core_Productcategory::getFullParentProductCategorys($roleuser->productcategory->id);

				// if(count($roleusers) > 0)
				// {
				// 	foreach ($roleusers as $r)
				// 	{
				// 		$have = false;
				// 		if($r->productcategory->parent[0]['pc_id'] == $roleuser->productcategory->parent[0]['pc_id'])
				// 		{
				// 			if($r->uid == $roleuser->uid)
				// 			{
				// 				$have = true;
				// 			}
				// 		}
				// 	}

				// 	if(!$have)
				// 	{
				// 		$roleusers[] = $roleuser;
				// 	}
				// }
				// else
				// {
				// 	$roleusers[] = $roleuser;
				// }
			}
		}



		//echodebug($roleusers,true);



		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);

		if (count($roleusers) > 0)
		{
			$groupList = array();
			$group = array();
			$i = 0;
			foreach($roleusers as $roleuser)
			{

				if($i ==0)
				{
					$roleuser->vendor = new Core_Vendor($roleuser->subobjectid);
					$group[] = $roleuser;
				}
				else
				{
					foreach($group as $obj)
					{
						if($obj->uid == $roleuser->uid)
						{
							$roleuser->vendor = new Core_Vendor($roleuser->subobjectid);
							$group[] =	$roleuser;
							break;
						}
						else
						{
							$groupList[] = $group;
							$group = array();
							$roleuser->vendor = new Core_Vendor($roleuser->subobjectid);
							$group[] = $roleuser;
							break;
						}
					}
				}

				if($i== count($roleusers)-1)
				{
					$groupList[] = $group;
				}


				$i++;
			}
		}



		//$productcategoryList = array();
		// $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
		// for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
		// {
		// 	if($parentCategory1[$i]->parentid == 0)
		// 	{
		// 		$productcategoryList[] = $parentCategory1[$i];
		// 		$parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
		// 		for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
		// 		{
		// 			$parentCategory2[$j]->name = '&nbsp;&nbsp;' . $parentCategory2[$j]->name;
		// 			$productcategoryList[] = $parentCategory2[$j];

		// 			$subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
		// 			foreach ($subCategory as $sub)
		// 			{
		// 				$sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
		// 				$productcategoryList[] = $sub;
		// 			}
		// 		}
		// 	}
		// }

		//kiem tra xem user co the phan quyen cho nguoi khac khong
		$delegate = true;
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$delegate = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id);
		}

		$_SESSION['roleuserBulkToken']=Helper::getSecurityToken();//Token


		$this->registry->smarty->assign(array(	'roleusers' 	=> $roleusers,
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
			'groupList'		=> $groupList,
			'statusList'	=> Core_RoleUser::getStatusList(),
			//'productcategoryList' => $productcategoryList,
			'vendorList'	=> Core_Vendor::getVendors(array(), 'name' , 'ASC'),
			'delegate' => $delegate,
		));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'role.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
			'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function roleaddAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();


		if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['roleuserAddToken'] == $_POST['ftoken'])
				{
					$formData = array_merge($formData, $_POST);

					if($this->addroleActionValidator($formData, $error))
					{
						$ok = false;
						//add role of product
						if(count($formData['fproduct']) > 0)
						{
							foreach($formData['fproduct'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_PRODUCT;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}


						//add role of product category
						if(count($formData['fproductcategory']) > 0)
						{
							foreach ($formData['fproductcategory'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();


								$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTCATEGORY;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}

						//add role of product group attribute
						if(count($formData['fattribute']) > 0)
						{
							foreach ($formData['fattribute'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTATTRIBUTE;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}

						//add role of sale
						if(count($formData['fsale']) > 0)
						{
							foreach ($formData['fsale'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();

								$myRoleUser->type = Core_RoleUser::TYPE_SALE;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = $value;
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}


						//add role of page
						/*if(count($formData['fpage']) > 0)
						{
							foreach ($formData['fpage'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();


								$myRoleUser->type = Core_RoleUser::TYPE_PAGE;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}

						//add role of page
						if(count($formData['fslug']) > 0)
						{
							foreach ($formData['fslug'] as $key => $value)
							{
								$myRoleUser = new Core_RoleUser();


								$myRoleUser->type = Core_RoleUser::TYPE_SLUG;
								$myRoleUser->uid = $formData['fuid'];
								$myRoleUser->value = Core_RoleUser::getRoleValue($value);
								$myRoleUser->objectid = $key;
								$myRoleUser->subobjectid = $formData['fvid'];
								$myRoleUser->creatorid = $this->registry->me->id;
								$myRoleUser->status = $formData['fstatus'];

								if($myRoleUser->addData())
								{
									$ok = true;
									$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
								}
							}
						}*/


						#################################################################
						if($ok)
						{
							$success[] = $this->registry->lang['controller']['succAddRole'];
							$formData = array();
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errAddRole'];
						}
					}
				}

			}

			//get product category
			$productcategoryList = Core_Productcategory::getProductcategorys(array('fparentidall' => 'all') , 'name' , 'ASC');

			if(count($productcategoryList) > 0)
			{
				$list = $productcategoryList;
				$productcategoryList = array();
				foreach ($list as $productcategory)
				{
					$output = array();
					$parentCat = new Core_Productcategory($productcategory->parentid);
					if($parentCat->parentid == 0)
					{
						$output = Core_Productcategory::getSubListCategory($productcategory->id , $list);
						foreach ($output as $obj)
						{
							$productcategoryList[] = $obj;
						}
					}
				}
			}



			//get vendor list
			$vendorList = Core_Vendor::getVendors(array() , 'name' , 'ASC');


			$_SESSION['roleuserAddToken']=Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
				'redirectUrl'	=> $this->registry['conf']['rooturl_cms'] . 'productcategory/role',
				'error'			=> $error,
				'success'		=> $success,
				'productcategoryList' => $productcategoryList,
				'vendorList' => $vendorList,
				'statusList' => Core_RoleUser::getStatusList(),
			));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roleadd.tpl');
			$this->registry->smarty->assign(array(
				'pageTitle'	=> $this->registry->lang['controller']['pageTitle_addrole'],
				'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		}
		else
		{
			header('location: ' . $this->registry['conf']['rooturl_cms'] . 'productcategory/role/permission/access');
			exit();
		}
	}

	public function roledelegateAction()
	{
		$error 	= array();
		$success 	= array();
		$contents 	= '';
		$formData 	= array();

		//lay tat cac danh muc ma user co the phan quyen duoc
		$productcategoryList = array();
		$checker = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id, Core_RoleUser::STATUS_ENABLE, 'ftype' =>Core_RoleUser::TYPE_DELEGATE), 'id' , 'ASC' , '' , true , true);

		if($checker > 0)
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id, Core_RoleUser::STATUS_ENABLE, 'ftype' =>Core_RoleUser::TYPE_PRODUCT), 'id' , 'ASC');

			foreach($roleusers as $roleuser)
			{
				$category = new Core_Productcategory($roleuser->objectid);
				$category->parent = Core_Productcategory::getFullParentProductCategorys($roleuser->objectid);
				$productcategoryList[] = $category;
			}
		}
		else
		{
			header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/role/permission/delegate');
			exit();
		}

		if(!empty($_POST['fsubmit']))
		{
			if($_SESSION['roleuserAddToken'] == $_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);
				if($this->delegateroleActionValidator($formData, $error))
				{
					$ok = false;
					//add role of product
					if(count($formData['fproduct']) > 0)
					{
						foreach($formData['fproduct'] as $key => $value)
						{
							$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_PRODUCT;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = Core_RoleUser::getRoleValue($value);
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = $formData['fvid'];
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

							if($myRoleUser->addData())
							{
								$ok = true;
								$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
							}
						}
					}


					//add role of product category
					if(count($formData['fproductcategory']) > 0)
					{
						foreach ($formData['fproductcategory'] as $key => $value)
						{
							$myRoleUser = new Core_RoleUser();


							$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTCATEGORY;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = Core_RoleUser::getRoleValue($value);
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = $formData['fvid'];
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

							if($myRoleUser->addData())
							{
								$ok = true;
								$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
							}
						}
					}

					//add role of product group attribute
					if(count($formData['fattribute']) > 0)
					{
						foreach ($formData['fattribute'] as $key => $value)
						{
							$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTATTRIBUTE;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = Core_RoleUser::getRoleValue($value);
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = $formData['fvid'];
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

							if($myRoleUser->addData())
							{
								$ok = true;
								$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
							}
						}
					}

					//add role of sale
					if(count($formData['fsale']) > 0)
					{
						foreach ($formData['fsale'] as $key => $value)
						{
							$myRoleUser = new Core_RoleUser();

							$myRoleUser->type = Core_RoleUser::TYPE_SALE;
							$myRoleUser->uid = $formData['fuid'];
							$myRoleUser->value = $value;
							$myRoleUser->objectid = $key;
							$myRoleUser->subobjectid = $formData['fvid'];
							$myRoleUser->creatorid = $this->registry->me->id;
							$myRoleUser->status = $formData['fstatus'];

							if($myRoleUser->addData())
							{
								$ok = true;
								$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
							}
						}
					}


					#################################################################
					if($ok)
					{
						$success[] = $this->registry->lang['controller']['succAddRole'];
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAddRole'];
					}


				}
			}
		}

		//get vendor list
		$vendorList = Core_Vendor::getVendors(array() , 'name' , 'ASC');


		$_SESSION['roleuserAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
			'redirectUrl'	=> $this->getRedirectUrl(),
			'error'			=> $error,
			'success'		=> $success,
			'productcategoryList' => $productcategoryList,
			'vendorList' => $vendorList,
			'statusList' => Core_RoleUser::getStatusList(),
		));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roledelegate.tpl');
		$this->registry->smarty->assign(array(
			'pageTitle'	=> $this->registry->lang['controller']['pageTitle_addrole'],
			'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function roleeditAction()
	{
		$uid = (int)$this->registry->router->getArg('uid');
		//$pcid = (int)$this->registry->router->getArg('pcid');
		$vid = (int)$this->registry->router->getArg('vid');

		$redirectUrl = $this->getRedirectUrl();

		$productcategoryList = array();

		$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
			'fsubobjectid' => $vid), 'id' , 'ASC');

		$checker = false;
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $pcid, $vid, 0, Core_RoleUser::STATUS_ENABLE);
			if(!$checker)
			{
				$parentcat = new Core_Productcategory($pcid);
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $parentcat->parentid, $vid, 0, Core_RoleUser::STATUS_ENABLE);
			}

			//get productcategory of user
			$catList = Core_RoleUser::getRoleUsers(array('fuid' => $this->registry->me->id, Core_RoleUser::STATUS_ENABLE), 'id' , 'ASC' , '' , false , true);
			if(count($catList) > 0)
			{
				foreach($catList as $cat)
				{
					$category = new Core_Productcategory($cat->$objectid);
					$productcategoryList[] = $category;
				}
			}
		}
		else
		{
			$checker = true;

			//get product category
			$productcategoryList = Core_Productcategory::getProductcategorys(array('fparentidall' => 'all') , 'name' , 'ASC');

			if(count($productcategoryList) > 0)
			{
				$list = $productcategoryList;
				$productcategoryList = array();
				foreach ($list as $productcategory)
				{
					$output = array();
					$parentCat = new Core_Productcategory($productcategory->parentid);
					if($parentCat->parentid == 0)
					{
						$output = Core_Productcategory::getSubListCategory($productcategory->id , $list);
						foreach ($output as $obj)
						{
							$obj->parent = Core_Productcategory::getFullParentProductCategorys($obj->id);
							$productcategoryList[] = $obj;
						}
					}
				}
			}
		}

		if($checker)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			foreach($roleusers as $roleuser)
			{
				switch ($roleuser->type)
				{
					case Core_RoleUser::TYPE_PRODUCT :
						$formData['fproduct'][$roleuser->objectid] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_PRODUCTCATEGORY :
						$formData['fproductcategory'][$roleuser->objectid] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_PRODUCTATTRIBUTE :
						$formData['fattribute'][$roleuser->objectid] = Core_RoleUser::getRoleName($roleuser->value);
						break;

					case Core_RoleUser::TYPE_SALE :
						$formData['fsale'][$roleuser->objectid] = $roleuser->value;
						break;
				}
				$vid = (int)$roleuser->subobjectid;
				$formData['fstatus'] = $roleuser->status;
			}

			$formData['fvid'] = $vid;
			$formData['fuid'] = $uid;
			if(!empty($_POST['fsubmit']))
			{
				if($_SESSION['roleuserEditToken'] == $_POST['ftoken'])
				{
					$formData = array();
					$formData = array_merge($formData, $_POST);

					if($this->editroleActionValidator($formData,$error))
					{
						//xoa tat ca cac record hien tai
						if(Core_RoleUser::deleteRoles($uid, $vid) > 0)
						{
							$ok = false;
							//add role of product
							if(count($formData['fproduct']) > 0)
							{
								foreach($formData['fproduct'] as $key => $value)
								{
									$myRoleUser = new Core_RoleUser();

									$myRoleUser->type = Core_RoleUser::TYPE_PRODUCT;
									$myRoleUser->uid = $formData['fuid'];
									$myRoleUser->value = Core_RoleUser::getRoleValue($value);
									$myRoleUser->objectid = $key;
									$myRoleUser->subobjectid = $formData['fvid'];
									$myRoleUser->creatorid = $this->registry->me->id;
									$myRoleUser->status = $formData['fstatus'];

									if($myRoleUser->addData())
									{
										$ok = true;
										$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
									}
								}
							}


							//add role of product category
							if(count($formData['fproductcategory']) > 0)
							{
								foreach ($formData['fproductcategory'] as $key => $value)
								{
									$myRoleUser = new Core_RoleUser();


									$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTCATEGORY;
									$myRoleUser->uid = $formData['fuid'];
									$myRoleUser->value = Core_RoleUser::getRoleValue($value);
									$myRoleUser->objectid = $key;
									$myRoleUser->subobjectid = $formData['fvid'];
									$myRoleUser->creatorid = $this->registry->me->id;
									$myRoleUser->status = $formData['fstatus'];

									if($myRoleUser->addData())
									{
										$ok = true;
										$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
									}
								}
							}

							//add role of product group attribute
							if(count($formData['fattribute']) > 0)
							{
								foreach ($formData['fattribute'] as $key => $value)
								{
									$myRoleUser = new Core_RoleUser();

									$myRoleUser->type = Core_RoleUser::TYPE_PRODUCTATTRIBUTE;
									$myRoleUser->uid = $formData['fuid'];
									$myRoleUser->value = Core_RoleUser::getRoleValue($value);
									$myRoleUser->objectid = $key;
									$myRoleUser->subobjectid = $formData['fvid'];
									$myRoleUser->creatorid = $this->registry->me->id;
									$myRoleUser->status = $formData['fstatus'];

									if($myRoleUser->addData())
									{
										$ok = true;
										$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
									}
								}
							}

							//add role of sale
							if(count($formData['fsale']) > 0)
							{
								foreach ($formData['fsale'] as $key => $value)
								{
									$myRoleUser = new Core_RoleUser();

									$myRoleUser->type = Core_RoleUser::TYPE_SALE;
									$myRoleUser->uid = $formData['fuid'];
									$myRoleUser->value = $value;
									$myRoleUser->objectid = $key;
									$myRoleUser->subobjectid = $formData['fvid'];
									$myRoleUser->creatorid = $this->registry->me->id;
									$myRoleUser->status = $formData['fstatus'];

									if($myRoleUser->addData())
									{
										$ok = true;
										$this->registry->me->writelog('roleuser_add', $myRoleUser->id, array());
									}
								}
							}


							############################################################

							if($ok)
							{
								$success[] = $this->registry->lang['controller']['succUpdateRole'];
							}
							else
							{
								$error[] = $this->registry->lang['controller']['errUpdateRole'];
							}
						}
					}
				}
			}
			//get info of user
			$user = new Core_User($uid);

			//get vendor list
			$vendorList = Core_Vendor::getVendors(array() , 'name' , 'ASC');

			$_SESSION['roleuserEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
				'redirectUrl'=> $redirectUrl,
				'error'		=> $error,
				'success'	=> $success,
				'productcategory' => $productcategory,
				'user' => $user,
				'statusList' => Core_Productcategory::getStatusList(),
				'vendorList' => $vendorList,
				'roleusers' => $roleusers,
				'productcategoryList' => $productcategoryList,
			));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'roleedit.tpl');
			$this->registry->smarty->assign(array(
				'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
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

	public function roledeleteAction()
	{
		$uid = (int)$this->registry->router->getArg('uid');
		$vid = (int)$this->registry->router->getArg('vid');

		$redirectUrl = $this->getRedirectUrl();

		$roleusers = Core_RoleUser::getRoleUsers(array('fuid' => $uid ,
			'fsubobjectid' => $vid), 'id' , 'ASC');

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $pcid, $vid, 0, Core_RoleUser::STATUS_ENABLE);
			if(!$checker)
			{
				$parentcat = new Core_Productcategory($pcid);
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $parentcat->id, $vid, 0, Core_RoleUser::STATUS_ENABLE);
			}
		}
		else
		{
			$checker = true;
		}

		if(count($roleusers) > 0 && $checker)
		{
			$vid = $roleusers[0]->subobjectid;
			//tien hanh xoa phan quyen cho danh muc
			if(Core_RoleUser::deleteRoles($uid, $vid))
			{
				$productcategory = new Core_Productcategory($pcid);
				$redirectMsg = str_replace('###name###', $productcategory->name, $this->registry->lang['controller']['succDeleteRole']);

				$this->registry->me->writelog('roleuser_delete', $myRoleUser->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###name###', $productcategory->name, $this->registry->lang['controller']['errDeleteRole']);
			}
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
		}

		$this->registry->smarty->assign(array('redirect' => $this->registry['conf']['rooturl_cms'] . 'productcategory/role',
			'redirectMsg' => $redirectMsg,
		));
		$this->registry->smarty->display('redirect.tpl');

	}


	public function indexAjaxAction()
	{
		$pcid = (int)$_POST['fpcidparent'];
		if($pcid > 0)
		{
			$childCategoryList = Core_Productcategory::getProductcategorys(array('fparentid'=>$pcid),'id','ASC');
			$result = '';
			foreach($childCategoryList as $childCategory)
			{
				$result .= '<option value="'.$childCategory->id.'">'.$childCategory->name.'</option>';
			}
		}
		echo $result;
	}

	/**
	 * [changenewproductcategoryAction description]
	 * @return [type] [description]
	 */
	public function changenewproductcategoryAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductcategory = new Core_Productcategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductcategory->id > 0)
		{
			$error      = array();
			$success    = array();
			$contents   = '';
			$formData   = array();

			//khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = false;

                //get full parentcategory from cache
                $parentcategorylist = Core_Productcategory::getFullParentProductCategoryId($myProductcategory->pcid);

                //create suffix
                $suffix = 'pcedit_' . $parentcategorylist[0];
                $checker = $this->checkAccessTicket($suffix);

                if(!$checker)
                {
                	header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/edit');
                }
			}

			$formData['fid']  = $myProductcategory->id;

			if(!empty($_POST['fsubmit']))
			{

				$formData = array_merge($formData, $_POST);
				/////////////////////////
				//get all slug related to current slug
				$formData['fslug'] = Helper::codau2khongdau($formData['fslug'], true, true);
				if($formData['fslug'] != '')
					$slugList = Core_Slug::getSlugs(array('fslug' => $formData['fslug']), '', '');

				if($this->editnewcategoryActionValidator($formData, $error))
				{
					//tao danh muc san pham moi
					$newproductcategory = new Core_Productcategory();
					$newproductcategory->name = Helper::plaintext($formData['fname']);
					$newproductcategory->slug = (strlen($formData['fslug']) > 0) ? $formData['fslug'] : Helper::codau2khongdau($formData['fname'] , true , true);
					$newproductcategory->status = Core_Productcategory::STATUS_ENABLE;
					$newproductcategory->parentid = (int)$formData['fparentid'];
					if($newproductcategory->addData() > 0)
					{
						//Add Slug base on slug of page
						$mySlug = new Core_Slug();
						$mySlug->uid = $this->registry->me->id;
						$mySlug->slug = $newproductcategory->slug;
						$mySlug->controller = 'productcategory';
						$mySlug->objectid = $newproductcategory->id;
						if(!$mySlug->addData())
						{
							$error[] = 'Item Added but Slug is not valid. Try again or use another slug for this item.';

							//reset slug of current item
							$newproductcategory->slug = '';
							$newproductcategory->updateData();
						}
						//end Slug process


						// chuyen tat ca nhung san pham duoc chon qua danh muc moi
						if(count($formData['fbulkid']) > 0)
						{
							$ok = false;
							//clone nhom thuoc tinh
							$productgroupattributelist = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid' => $myProductcategory->id) , 'id' , 'ASC');
							if(count($productgroupattributelist) > 0)
							{
								foreach ($productgroupattributelist as $gpa)
								{
									$newgpa = new Core_ProductGroupAttribute();

									$newgpa->uid = $this->registry->me->id;
									$newgpa->pcid = $newproductcategory->id;
									$newgpa->name = $gpa->name;
									$newgpa->displayorder = $gpa->displayorder;
									$newgpa->status = $gpa->status;

									if($newgpa->addData() > 0)
									{
										//cap nhat thuoc tinh moi cho san pham
										$productattributelist = Core_ProductAttribute::getProductAttributes(array('fpcid' => $myProductcategory->id , 'fpgaid' =>$gpa->id) , 'id' , 'ASC');
										if(count($productattributelist) > 0)
										{
											foreach ($productattributelist as $productattribute)
											{
												$newattribute = new Core_ProductAttribute();
												$newattribute->uid = $this->registry->me->id;
												$newattribute->pgaid = $newgpa->id;
												$newattribute->pcid = $newproductcategory->id;
												$newattribute->name = $productattribute->name;
												$newattribute->link = $productattribute->link;
												$newattribute->weightrecommand = $productattribute->weightrecommand;
												$newattribute->description = $productattribute->description;
												$newattribute->datatype = $productattribute->datatype;
												$newattribute->unit = $productattribute->unit;
												$newattribute->status = $productattribute->status;
												$newattribute->displayorder = $productattribute->displayorder;
												if($newattribute->addData() > 0)
												{
													foreach ($formData['fbulkid'] as $pid)
													{
														$relproductattributes = Core_RelProductAttribute::getRelProductAttributes(array('fpid' => $pid , 'fpaid' => $productattribute->id) , 'id' , 'ASC');
														if(count($relproductattributes) > 0)
														{
															foreach ($relproductattributes as $relproductattribute)
															{
																$relproductattribute->paid = $newattribute->id;
																if($relproductattribute->updateData())
																{
																	$ok = true;
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}

							foreach ($formData['fbulkid'] as $pid)
							{
								$myProduct = new Core_Product($pid , true);

								$myProduct->pcid = $newproductcategory->id;

								//update category
								if($myProduct->updateData())
								{
									$ok = true;
								}

								unset($myProduct);
							}

							if($ok)
							{
								$success[] = 'Tạo danh mục mới và di chuyển sản phẩm thành công.';
								$formData = array();
							}
						}

					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}

			}

			$_SESSION['productcategoryEditToken'] = Helper::getSecurityToken();//Tao token moi

			//lay danh sach san pham cua danh muc hien tai
			$productlist = Core_Product::getProducts(array('fpcid' => $myProductcategory->id , 'fonsitestatus' => Core_Product::OS_ERP) , 'id' , 'ASC');

			//$productcategoryList = Core_Productcategory::getProductcategorys($cond , 'name' , 'ASC');
			$productcategoryList = Core_Productcategory::getFullCategoryList();

			$this->registry->smarty->assign(array(  'formData'  => $formData,
				'myProductcategory' => $myProductcategory,
				'redirectUrl'=> $redirectUrl,
				'error'     => $error,
				'success'   => $success,
				'productlist' => $productlist,
				'productcategoryList' => $productcategoryList,
				'formData' => $formData,
			));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'newcategory.tpl');
			$this->registry->smarty->assign(array(
				'pageTitle' => $this->registry->lang['controller']['pageTitle_edit'].' '.$myProductcategory->name,
				'contents'          => $contents));
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



	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if(strlen($_FILES['fimage']['name']) > 0)
		{
			//kiem tra dinh dang hinh anh
			if(!in_array(strtoupper(end(explode('.', $_FILES['fimage']['name']))), $this->registry->setting['productcategory']['imageValidType']))
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}

			//kiem tra kich thuoc file
			if($_FILES['fimage']['size'] > $this->registry->setting['productcategory']['imageMaxFileSize'])
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}
		}

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fparentid'] == 0)
			{
				$error[] = $this->registry->lang['controller']['errParentRequired'];
				$pass = false;
			}
			else
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTCATEGORY, $this->registry->me->id, $formData['fparentid'],0,Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					$category = new Core_Productcategory($formData['fparentid']);
					if($category->parentid == 0)
					{
						$error[] = $this->registry->lang['controller']['errorAddPermission'];
						$pass = false;
					}
					else
					{
						$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTCATEGORY, $this->registry->me->id, $category->parentid,0,Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
						if(!$checker)
						{
							$error[] = $this->registry->lang['controller']['errorAddPermission'];
							$pass = false;
						}
					}
				}
			}
		}

		//CHECKING SLUG
		if(Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
		{
			$error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if(strlen($_FILES['fimage']['name']) > 0)
		{
			//kiem tra dinh dang hinh anh
			$filepart = explode('.', $_FILES['fimage']['name']);
			$extension = end($filepart);
			if(!in_array(strtoupper($extension), $this->registry->setting['productcategory']['imageValidType']))
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}

			//kiem tra kich thuoc file
			if($_FILES['fimage']['size'] > $this->registry->setting['productcategory']['imageMaxFileSize'])
			{
				$error[] = $this->registry->lang['controller']['errFileType'];
				$pass = false;
			}
		}

		// if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		// {
		// 	// if($formData['fparentid'] == 0)
		// 	// {
		// 	// 	$error[] = $this->registry->lang['controller']['errParentRequired'];
		// 	// 	$pass = false;
		// 	// }
		// 	// else
		// 	//{
		// 		$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fparentid'],0,Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
		// 		if(!$checker)
		// 		{
		// 			$category = new Core_Productcategory($formData['fparentid']);
		// 			if($category->parentid == 0)
		// 			{
		// 				$error[] = $this->registry->lang['controller']['errorEditPermission'];
		// 						$pass = false;
		// 			}
		// 			else
		// 			{
		// 				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCTCATEGORY, $this->registry->me->id, $category->parentid,0,Core_RoleUser::ROLE_CHANGE,Core_RoleUser::STATUS_ENABLE);
		// 				if(!$checker)
		// 				{
		// 					$error[] = $this->registry->lang['controller']['errorEditPermission'];
		// 					$pass = false;
		// 				}
		// 			}
		// 		}
		// 	//}
		// }

		//CHECKING SLUG
		if($formData['fslug'] != $formData['fslugcurrent'] && Core_Slug::getSlugs(array('fhash' => md5($formData['fslug'])), '', '', '', true) > 0)
		{
			$error[] = str_replace('###VALUE###', $this->registry->conf['rooturl_cms'] . 'slug/index/hash/' . md5($formData['fslug']), $this->registry->lang['default']['errSlugExisted']);
			$pass = false;
		}

		return $pass;
	}

	private function addroleActionValidator($formData, &$error)
	{
		$pass = true;
		if($formData['fuid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleUser'];
			$pass = false;
		}

		if(!isset($formData['fproduct']) || /*!isset($formData['fproductcategory']) ||*/ !isset($formData['fattribute']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		elseif($formData['fuid'] > 0)
		{
			if(isset($formData['fproduct']) && count($formData['fproduct']) > 0)
			{
				foreach ($formData['fproduct'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'fsubobjectid' => $formData['fvid'],
						'ftype' => Core_RoleUser::TYPE_PRODUCT,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}
			// elseif (isset($formData['fproductcategory']) && count($formData['fproductcategory']) > 0)
			// {
			// 	foreach ($formData['fproductcategory'] as $key=>$value)
			// 	{
			// 		$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
			// 											'fuid'	=> $formData['fuid'],
			// 											'fsubobjectid' => $formData['fvid'],
			// 									) , 'id' , 'ASC');
			// 		if(count($data) > 0)
			// 		{
			// 			$cat = new Core_Productcategory($key);
			// 			$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
			// 			$pass = false;
			// 		}
			// 	}
			// }
			elseif (isset($formData['fattribute']) && count($formData['fattribute']) > 0)
			{
				foreach ($formData['fattribute'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'fsubobjectid' => $formData['fvid'],
						'ftype' => Core_RoleUser::TYPE_PRODUCTATTRIBUTE,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fsale']) && count($formData['fsale']) > 0)
			{
				foreach ($formData['fsale'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'fsubobjectid' => $formData['fvid'],
						'ftype' => Core_RoleUser::TYPE_SALE,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}
				}
			}

			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				//kiem tra xem nguoi dang phan quyen va nguoi phan quyen co cung 1 phong ban hay khong ?
				$startuser = new Core_User($this->registry->me->id);
				$startdepartmentList = $startuser->getBelongDepartments();

				$enduser = new Core_User($formData['fuid']);
				$enddepartmentList = $enduser->getBelongDepartments();

				if(count($startdepartmentList) > 0)
				{
					if(count($enddepartmentList) > 0)
					{
						$startdepartment = end($startdepartmentList);
						$enddepartment = end($enddepartmentList);
						if( $startdepartment->id == $enddepartment->id)
						{
							//lay tri cua 2 user de so sanh
							$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $startuser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$startuseredge = $startuseredges[0];

							$enduseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $enduser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$enduseredge = $enduseredges[0];

							if($startuseredge->id > 0 && $enduseredge->id > 0)
							{
								$startpriority = new Core_HrmTitle($startuseredge->point);
								$endpriority = new Core_HrmTitle($enduseredge->point);

								if($startpriority->priority >  $endpriority->priority)
								{
									$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUserPiority']);
									$pass = false;
								}
							}

						}
						else
						{
							$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
							$pass = false;
						}
					}
					else
					{
						$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
						$pass = false;
					}
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errstartUser'];
					$pass = false;
				}
			}
		}



		return $pass;
	}

	private function editroleActionValidator($formData, &$error)
	{
		$pass = true;
		if(!isset($formData['fproduct']) || /*!isset($formData['fproductcategory']) ||*/ !isset($formData['fattribute']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		return $pass;
	}

	private function delegateroleActionValidator($formData, &$error)
	{
		$pass = true;
		if($formData['fuid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRoleUser'];
			$pass = false;
		}

		if(!isset($formData['fproduct']) || /*!isset($formData['fproductcategory']) ||*/ !isset($formData['fattribute']))
		{
			$error[] = $this->registry->lang['controller']['errRoleFull'];
			$pass = false;
		}
		elseif($formData['fuid'] > 0)
		{
			if(isset($formData['fproduct']) && count($formData['fproduct']) > 0)
			{
				foreach ($formData['fproduct'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'ftype' => Core_RoleUser::TYPE_PRODUCT,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $key))
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}
			// elseif (isset($formData['fproductcategory']) && count($formData['fproductcategory']) > 0)
			// {
			// 	foreach ($formData['fproductcategory'] as $key=>$value)
			// 	{
			// 		$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
			// 											'fuid'	=> $formData['fuid'],
			// 									) , 'id' , 'ASC');
			// 		if(count($data) > 0)
			// 		{
			// 			$cat = new Core_Productcategory($key);
			// 			$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
			// 			$pass = false;
			// 		}

			// 		if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $key))
			// 		{
			// 			$cat = new Core_Productcategory($key);
			// 			$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
			// 			$pass = false;
			// 		}
			// 	}
			// }
			elseif (isset($formData['fattribute']) && count($formData['fattribute']) > 0)
			{
				foreach ($formData['fattribute'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'ftype' => Core_RoleUser::TYPE_PRODUCTATTRIBUTE,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $key))
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}
			elseif (isset($formData['fsale']) && count($formData['fsale']) > 0)
			{
				foreach ($formData['fsale'] as $key=>$value)
				{
					$data = Core_RoleUser::getRoleUsers(array('fobjectid' => $key,
						'fuid'	=> $formData['fuid'],
						'ftype' => Core_RoleUser::TYPE_SALE,
					) , 'id' , 'ASC');
					if(count($data) > 0)
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###pcid###', $cat->name , $this->registry->lang['controller']['errRoleCategoryExist']);
						$pass = false;
					}

					if(!Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_DELEGATE, $this->registry->me->id, $key))
					{
						$cat = new Core_Productcategory($key);
						$error[] = str_replace('###name###', $cat->name , $this->registry->lang['controller']['errRoleCategoryDelegate']);
						$pass = false;
					}
				}
			}


			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				//kiem tra xem nguoi dang phan quyen va nguoi phan quyen co cung 1 phong ban hay khong ?
				$startuser = new Core_User($this->registry->me->id);
				$startdepartmentList = $startuser->getBelongDepartments();

				$enduser = new Core_User($formData['fuid']);
				$enddepartmentList = $enduser->getBelongDepartments();

				if(count($startdepartmentList) > 0)
				{
					if(count($enddepartmentList) > 0)
					{
						$startdepartment = end($startdepartmentList);
						$enddepartment = end($enddepartmentList);
						if( $startdepartment->id == $enddepartment->id)
						{
							//lay tri cua 2 user de so sanh
							$startuseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $startuser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$startuseredge = $startuseredges[0];

							$enduseredges = Core_UserEdge::getUserEdges(array('ftype' => Core_UserEdge::TYPE_EMPLOY, 'fuidstart' => $enduser->id , 'fuidend' => $startdepartment->id) , '' , '');

							if(count($startuseredges) > 0)
								$enduseredge = $enduseredges[0];

							if($startuseredge->id > 0 && $enduseredge->id > 0)
							{
								$startpriority = new Core_HrmTitle($startuseredge->point);
								$endpriority = new Core_HrmTitle($enduseredge->point);

								if($startpriority->priority >  $endpriority->priority)
								{
									$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUserPiority']);
									$pass = false;
								}
							}

						}
						else
						{
							$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
							$pass = false;
						}
					}
					else
					{
						$error[] = str_replace('###name###', $enduser->fullname , $this->registry->lang['controller']['errendUser']);
						$pass = false;
					}
				}
				else
				{
					$error[] = $this->registry->lang['controller']['errstartUser'];
					$pass = false;
				}
			}
		}



		return $pass;
	}

	private function editnewcategoryActionValidator($formData, &$error)
	{
		$pass = true;
		if(strlen($formData['fname']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if(count($formData['fbulkid']) == 0 || !isset($formData['fbulkid']))
		{
			$error[] = 'Không có sản phẩm nào được chọn.';
			$pass = false;
		}

		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			if($formData['fparentid'] == 0)
			{
				$error[] = 'Vui lòng chọn danh mục cha.';
				$pass = false;
			}
		}
		return $pass;
	}

	public function updatepromotionajaxAction()
	{
		global $db;
		$fpcid = (int)($this->registry->router->getArg('fpcid'));
		if($fpcid <= 0) {
			echo json_encode(array('fail' => 1));
			return;
		}
		set_time_limit(0);
		$getAllChildCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$fpcid, 'fcountitemgreater0' => 1,'fstatus' => Core_Productcategory::STATUS_ENABLE),'displayorder','ASC','');
		$arr_catid = array($fpcid);
		if(!empty($getAllChildCategory))
		{
			foreach($getAllChildCategory as $cat)
			{
				$arr_catid[] = $cat->id;
			}
		}
		$totalRecord = $db->query('SELECT count(*) FROM '. TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND pc_id IN( '.implode(',',$arr_catid).') AND p_sellprice > 0')->fetchColumn(0);
		$countererp++;
		$recordperpage = 500;
		$totalPage = ceil($totalRecord / $recordperpage);
		$totalaffected = 0;
		for($i = 0; $i < $totalPage; $i++ )
		{
			$offset = $i * $recordperpage;
			$sql = 'SELECT p_id,p_barcode  FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND pc_id IN( '.implode(',',$arr_catid).')
				AND p_sellprice > 0 ORDER BY p_id DESC LIMIT ' . $offset . ', ' . $recordperpage;

			$stmt = $db->query($sql);
			while($row = $stmt->fetch())
			{
				$barcode = trim($row['p_barcode']);
				$this->synpromotionbybarcode($barcode);
				$totalaffected++;
			}
		}
		if($totalaffected > 0) echo json_encode(array('success' => 1));
		else echo json_encode(array('fail' => 1));
	}

	private function formatTime($str, $time = 'H:i:s')
	{
		$date =  0;
		$str = trim($str);
		if(!empty($str) && $str != '0' &&  $str != 0)
		{
			$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $str);
			if(!empty($time))
			{
				$date =  strtotime($dateUpdated->format('Y-m-d '.$time));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'),$dateUpdated->format($time));
			}
			else {
				$date =  strtotime($dateUpdated->format('Y-m-d H:i:s'));//Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
			}
		}
		return $date;
	}

	private function synpromotionbybarcode($barcode)
	{
		global $db;
		$oracle = new Oracle();
		//Tìm tất cả các promotion của product trên erp
		$today = strtoupper(date('d-M-y' , time()));
		$findpromotions = $oracle->query('SELECT DISTINCT PROMOTIONID FROM ERP.VW_PROMOTIONINFO_DM WHERE PRODUCTID = \''.$barcode.'\' AND ENDDATE >= TO_DATE(\' '.$today.' \')');
		$listpromotionids = array();
		if(!empty($findpromotions))
		{
			if(!empty($findpromotions))
			{
				foreach($findpromotions as $promos)
				{
					$promos['PROMOTIONID'] = trim($promos['PROMOTIONID']);
					if(!in_array($promos['PROMOTIONID'], $listpromotionids))
					{
						//kiểm tra output time
						$checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601,801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
						//741: xuat ban online trực tuyến
						if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
						{
							$listpromotionids[] = $promos['PROMOTIONID'];
						}
					}
				}
			}
		}
		//lấy promotion theo dạng combo
		$findcombolist = $oracle->query('SELECT distinct PRODUCTCOMBOID FROM ERP.VW_COMBO_PRODUCT  WHERE PRODUCTID = \''.$barcode.'\'');
		if(!empty($findcombolist))
		{
			$listcombosid = array();
			foreach($findcombolist as $combo)
			{
				if(!in_array($combo['PRODUCTCOMBOID'], $listcombosid))
				{
					$listcombosid[] = $combo['PRODUCTCOMBOID'];
				}
			}

			if(!empty($listcombosid))
			{
				$findpromotionlist = $oracle->query('SELECT distinct PROMOTIONID FROM
												   ERP.vw_promotioncombo_dm  WHERE
												   productcomboid IN (\''.implode('\',\'',$listcombosid).'\')'
				);
				if(!empty($findpromotionlist))
				{
					foreach($findpromotionlist as $promos)
					{
						$promos['PROMOTIONID'] = trim($promos['PROMOTIONID']);
						if(!in_array($promos['PROMOTIONID'], $listpromotionids))
						{
							$checkpromotionoutputtype = $oracle->query('SELECT COUNT(*) AS NUMPROMO FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE OUTPUTTYPEID IN (222, 8, 621, 3,201,601,801) AND PROMOTIONID = '.$promos['PROMOTIONID']);
							//741: xuat ban online trực tuyến
							if($checkpromotionoutputtype[0]['NUMPROMO'] > 0)
							{
								$listpromotionids[] = $promos['PROMOTIONID'];
							}
						}
					}
				}

			}
		}

		//tìm promotion product cũ của barcode này trên csdl và  xóa nó
		$getlistoldpromotionproduct = $db->query('SELECT distinct promo_id FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode = "'.$barcode.'"');
		$listpromotiondeleted = array();
		if(!empty($getlistoldpromotionproduct))
		{
			while($rowpromoproducts = $getlistoldpromotionproduct->fetch())
			{
				//trường hợp $listpromotionids có
				if(!empty($listpromotionids))
				{
					$rowpromoproducts['promo_id'] = trim($rowpromoproducts['promo_id']);
					//Trường hợp promotion cần delete không nằm trong promotion mới tìm thấy
					if( !in_array($rowpromoproducts['promo_id'] ,$listpromotionids))
					{
						if( !in_array($rowpromoproducts['promo_id'] ,$listpromotiondeleted))
						{
							$listpromotiondeleted[] = $rowpromoproducts['promo_id'];
						}
					}
				}
				else {
					$listpromotiondeleted[] = $rowpromoproducts['promo_id'];
				}
			}
		}
		if(!empty($listpromotiondeleted))
		{
			$db->query('DELETE FROM '.TABLE_PREFIX.'promotion_product WHERE p_barcode = "'.$barcode.'" AND promo_id IN ('.implode(',',$listpromotiondeleted).')');
			//kiem tra xem promotion nay con chua nhung product khac khong, nếu không có thì  xóa nó đi
			foreach($listpromotiondeleted as $promoid)
			{
				$totalpromotionproducthasdata = $db->query('SELECT count(*) FROM '.TABLE_PREFIX.'promotion_product WHERE promo_id = '.(int)$promoid)->fetchColumn(0);
				if($totalpromotionproducthasdata == 0)
				{
					//trường hợp promotion này không có promotion apply product kiểm tra tiếp coi có trong promotion combo không
					$totalpromotioncombohasdata = $db->query('SELECT count(*) FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promoid)->fetchColumn(0);
					if($totalpromotioncombohasdata == 0)
					{
						//delete tất cả những gì liên quan đến promotion này
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promoid);

						$getAllpromotionGroup = $db->query('SELECT promog_id FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id ='.(int)$promoid);
						if(!empty($getAllpromotionGroup))
						{
							while($rgprow = $getAllpromotionGroup->fetch())
							{
								$db->query('DELETE FROM '.TABLE_PREFIX.'promotionlist WHERE promog_id = '.(int)$rgprow['promog_id']);
							}
						}
						$this->expriedproductpromotion($promoid);
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotiongroup WHERE promo_id = '.(int)$promoid);
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotion_combo WHERE promo_id = '.(int)$promoid);
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotion_exclude WHERE promo_id = '.(int)$promoid);
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotion_outputtype WHERE promo_id = '.(int)$promoid);
						$db->query('DELETE FROM '.TABLE_PREFIX.'promotion_store WHERE promo_id = '.(int)$promoid);
					}
				}
			}
		}

		if(!empty($listpromotionids))
		{
			//lấy promotion mới từ ERP
			$sql = 'SELECT pr.* FROM ERP.VW_PROMOTIONSUMARY_DM pr WHERE pr.PROMOTIONID IN ('.implode(',', $listpromotionids).') AND (pr.DESCRIPTION IS NOT NULL OR pr.DESCRIPTION !=\'\') AND ISACTIVE = 1';

			$result = $oracle->query($sql);
			if(!empty($result))
			{
				foreach($result as $res)
				{
					//update promotion, check combo, exclude promotion, scrope name, promotion apply, promotion list, promotion list group
					//check promotion id
					$checkpromotion = new Core_Promotion((int)$res['PROMOTIONID']);
					$promotion = new Core_Promotion((int)$res['PROMOTIONID']);

					$promotion->id                          = $res['PROMOTIONID'];
					$promotion->usercreate                  = $res['USERCREATE'];
					$promotion->useractive                  = $res['USERACTIVE'];
					$promotion->userdelete                  = $res['USERDELETE'];
					$promotion->name                        = $res['PROMOTIONNAME'];
					$promotion->shortdescription            = $res['SHORTDESCRIPTION'];
					$promotion->description                 = $res['DESCRIPTION'];
					$promotion->isnew                       = $res['ISNEWTYPE'];
					$promotion->showtype                    = $res['ISSHOWPRODUCTTYPE'];
					$promotion->isprintpromotion            = $res['ISPRINTONHANDBOOK'];
					$promotion->descriptionproductapply     = $res['APPLYPRODUCTDESCRIPTION'];
					$promotion->descriptionpromotioninfo    = $res['PROMOTIONOFFERDESCRIPTION'];
					$promotion->ispromotionbyprice          = $res['ISPROMOTIONBYPRICE'];
					$promotion->maxpromotionbyprice         = $res['TOPRICE'];
					$promotion->minpromotionbyprice         = $res['FROMPRICE'];
					$promotion->ispromotionbytotalmoney     = $res['ISPROMOTIONBYTOTALMONEY'];
					$promotion->maxpromotionbytotalmoney    = $res['MAXPROMOTIONTOTALMONEY'];
					$promotion->minpromotionbytotalmoney    = $res['MINPROMOTIONTOTALMONEY'];
					$promotion->ispromotionbyquantity       = $res['ISPROMOTIONBYTOTALQUANTITY'];
					$promotion->maxpromotionbyquantity      = $res['MAXPROMOTIONTOTALQUANTITY'];
					$promotion->minpromotionbyquantity      = $res['MINPROMOTIONTOTALQUANTITY'];
					$promotion->ispromotionbyhour           = $res['ISAPPLYBYTIMES'];
					$promotion->startpromotionbyhour        = (is_numeric($res['STARTTIME'])?$res['STARTTIME']:$this->formatTime($res['STARTTIME']));
					$promotion->endpromotionbyhour          = (is_numeric($res['ENDTIME'])?$res['ENDTIME']:$this->formatTime($res['ENDTIME']));
					$promotion->isloyalty                   = $res['ISMEMBERSHIPPROMOTION'];
					$promotion->isnotloyalty                = $res['ISNOTAPPLYFORMEMBERSHIP'];
					$promotion->isdeleted      				= $res['ISDELETE'];

					$promotion->isactived                   = $res['ISACTIVE'];
					$promotion->iscombo                     = $res['ISCOMBO'];
					$promotion->isshowvat                   = $res['ISSHOWVATINVOICEMESSAGE'];
					$promotion->messagevat                  = $res['VATINVOICEMESSAGE'];

					$promotion->isunlimited                 = $res['ISLIMITPROMOTIONTIMES'];
					$promotion->timepromotion               = $res['MAXPROMOTIONTIMES'];
					$promotion->islimittimesoncustomer      = $res['ISLIMITTIMESONCUSTOMER'];

					$promotion->startdate                   = $this->formatTime($res['BEGINDATE']);
					$promotion->enddate                     = $this->formatTime($res['ENDDATE']);
					$promotion->dateadd                     = $this->formatTime($res['INPUTTIME']);
					$promotion->datemodify                  = $this->formatTime($res['DATEUPDATE'],'');

					//Get promotion apply product list
					//$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);
					$promotionapplyproductlist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYPRODUCT_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID'].' AND PRODUCTID = \''.$barcode.'\'');

					//get promotion apply store
					$promotionapplystorelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONAPPLYSCOPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					//get promotion combo
					$promotioncombolist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONCOMBO_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					//get promotion exclude
					$promotionexcludelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONEXCLUDE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					//get promotion group
					$promotiongroup = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					//get promotion group list
					$promotiongrouplist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONLISTGROUP_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					//get promotion out put type
					$promotionoutputtypelist = $oracle->query('SELECT * FROM ERP.VW_PROMOTIONOUTPUTTYPE_DM WHERE PROMOTIONID = '.(int)$res['PROMOTIONID']);

					if($checkpromotion->id > 0) {
						//if promotion exists
						$promotion->updateData();
					}
					else {
						//if promotion not exists
						$promotion->addDataID();
					}

					//update promotion apply product
					$excludeapplyproduct = array();
					$excludeapplyarea = array();
					if(!empty($promotionapplyproductlist))
					{
						foreach($promotionapplyproductlist as $promoapplyproduct)
						{
							if(!empty($promoapplyproduct['PROMOTIONID']) && !empty($promoapplyproduct['PRODUCTID']) && !empty($promoapplyproduct['AREAID']))
							{
								$PromotionProduct = new Core_PromotionProduct();
								$checkpromotionlist = Core_PromotionProduct::getPromotionProducts(array('fpbarcode'=>$promoapplyproduct['PRODUCTID'],'fpromoid'=>$promoapplyproduct['PROMOTIONID'],'faid' => $promoapplyproduct['AREAID']),'','',1);
								$PromotionProduct->pbarcode = $promoapplyproduct['PRODUCTID'];
								$PromotionProduct->promoid = $promoapplyproduct['PROMOTIONID'];
								$PromotionProduct->aid = $promoapplyproduct['AREAID'];

								$promoapplyproduct['PRODUCTID'] = trim($promoapplyproduct['PRODUCTID']);
								//if(!in_array($promoapplyproduct['PRODUCTID'], $excludeapplyproduct)) $excludeapplyproduct[] = $promoapplyproduct['PRODUCTID'];
								//if(!in_array($promoapplyproduct['AREAID'], $excludeapplyarea)) $excludeapplyarea[] = $promoapplyproduct['AREAID'];

								if(empty($checkpromotionlist))
								{
									$PromotionProduct->addData();
								}
								else{
									$PromotionProduct->id = $checkpromotionlist[0]->id;
									$PromotionProduct->updateData();
								}
							}
						}

					}
					//update promotion apply store
					$excludeapplystore = array();
					if(!empty($promotionapplystorelist))
					{
						foreach($promotionapplystorelist as $promoapplystore)
						{
							if(!empty($promoapplystore['PROMOTIONID']) && !empty($promoapplystore['STOREID']))
							{
								$promotionStore = new Core_PromotionStore();
								$checkpromotionstore = Core_PromotionStore::getPromotionStores(array('fpromoid'=>$promoapplystore['PROMOTIONID'],'fsid'=>$promoapplystore['STOREID']),'','',1);
								//if(!in_array($promoapplystore['STOREID'], $excludeapplystore)) $excludeapplystore[] = $promoapplystore['STOREID'];

								$promotionStore->promoid = $promoapplystore['PROMOTIONID'];
								$promotionStore->sid = $promoapplystore['STOREID'];

								//check if store not exist in current database, add the new store
								$getStore = Core_Store::getStores(array('fid'=>$promoapplystore['STOREID']),'','',1);
								if(empty($getStore))
								{
									$listStores = $oracle->query('SELECT * FROM ERP.VW_PM_STORE_DM s WHERE s.STOREID = '.(int)$promoapplystore['STOREID']);
									if(!empty($listStores[0]))
									{
										$store = $listStores[0];
										$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store (
											a_id,
											ppa_id,
											s_id,
											s_name,
											s_address,
											s_region,
											s_phone,
											s_fax,
											s_datecreated
											)
										VALUES(?, ?, ?,?, ?, ?,?, ?, ?)';
										$rowCount = $this->registry->db->query($sql, array(
											(int)$store['AREAID'],
											(int)$store['PRICEAREAID'],
											(int)$store['STOREID'],
											(string)$store['STORENAME'],
											(string)$store['STOREADDRESS'],
											(int)$store['PROVINCEID'],
											(string)$store['STOREPHONENUM'],
											(string)$store['STOREFAX'],
											time()
										))->rowCount();
									}
								}

								if(empty($checkpromotionstore))
								{
									$promotionStore->addData();
								}
								else
								{
									$promotionStore->id = $checkpromotionstore[0]->id;
									$promotionStore->updateData();
								}
							}
						}
					}

					//update promotion combo
					$excludepromotioncombo = array();
					if(!empty($promotioncombolist))
					{
						foreach($promotioncombolist as $combo)
						{
							if(!empty($combo['PRODUCTID']) && !empty($combo['PROMOTIONID']) && !empty($combo['PRODUCTCOMBOID']))
							{
								//check if combo not exist in current database, add the new combo
								$getCombo = Core_Combo::getCombos(array('fid'=>$combo['PRODUCTCOMBOID']),'','',1);
								if(empty($getCombo))
								{
									$listCombo = $oracle->query('SELECT * FROM ERP.VW_COMBO_DM s WHERE s.PRODUCTCOMBOID = \''.(int)$combo['PRODUCTCOMBOID'].'\'');
									if(!empty($listCombo[0]))
									{
										$ncombo = $listCombo[0];
										$newcombo = new Core_Combo();
										$newcombo->id = $ncombo['PRODUCTCOMBOID'];
										$newcombo->name = $ncombo['PRODUCTCOMBONAME'];
										$newcombo->description = $ncombo['DESCRIPTION'];
										$newcombo->isactive = $ncombo['ISACTIVE'];
										$newcombo->addData();
									}
								}
								if(!empty($combo['PRODUCTCOMBOID']))
								{
									$combo = new Core_Combo($combo['PRODUCTCOMBOID']);
									$combo->isdeleted = $combo['ISDELETE'];
									$combo->updateData();
								}
								$getRelComboProduct = Core_RelProductCombo::getRelProductCombos(array('fcoid' => $combo['PRODUCTCOMBOID'],'fpbarcode'=>$combo['PRODUCTID']),'','');
								if(empty($getRelComboProduct))
								{
									//Thêm rel combo product nếu chưa có
									$getComboProduct = $oracle->query('SELECT count(*) FROM ERP.VW_COMBO_PRODUCT pr WHERE pr.PRODUCTCOMBOID=\''.$combo['PRODUCTCOMBOID'].'\' AND PRODUCTID='.$combo['PRODUCTID']);
									if(!empty($getComboProduct))
									{
										$getProductDetailFromERP = $oracle->query('SELECT VAT,VATPERCENT FROM ERP.PM_PRODUCT WHERE PRODUCTID=\''.$combo['PRODUCTID'].'\'');
										if(!empty($getProductDetailFromERP[0]))
										{
											foreach($getComboProduct as $rcp)
											{
												$RelProductCombo = new Core_RelProductCombo();
												$RelProductCombo->pbarcode = $rcp['PRODUCTID'];
												$RelProductCombo->coid = $rcp['PRODUCTCOMBOID'];
												$RelProductCombo->type = $rcp['COMBOTYPE'];
												$RelProductCombo->value = round($rcp['VALUE']*(1+$getProductDetailFromERP[0]['VAT'] * $getProductDetailFromERP[0]['VATPERCENT']/10000));
												$RelProductCombo->quantity = $rcp['QUANTITY'];
												$RelProductCombo->displayorder = $rcp['ORDERINDEX'];
												$RelProductCombo->addData();
											}
										}
									}
								}
								$PromotionProduct = new Core_PromotionCombo();
								$checkpromotionlist = Core_PromotionCombo::getPromotionCombos(array('fpromoid'=>$combo['PROMOTIONID'],'fcoid'=>$combo['PRODUCTCOMBOID']),'','',1);

								$PromotionProduct->promoid = $combo['PROMOTIONID'];
								$PromotionProduct->coid = $combo['PRODUCTCOMBOID'];

								if(empty($checkpromotionlist))
								{
									$PromotionProduct->addData();
								}
								else
								{
									$PromotionProduct->id = $checkpromotionlist[0]->id;
									$PromotionProduct->updateData();
								}
								//}
							}
						}
					}

					//update promotion exclude
					$excludepromotionexclude = array();
					if(!empty($promotionexcludelist))
					{
						foreach($promotionexcludelist as $promoexclude)
						{
							if(!empty($promoexclude['PROMOTIONID']) && !empty($promoexclude['EXCLUDEPROMOTIONID']))
							{
								$PromotionExclude = new Core_PromotionExclude();
								$checkpromotionlist = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$res['PROMOTIONID'],'fpromoeid'=>$promoexclude['EXCLUDEPROMOTIONID']),'','',1);
								$PromotionExclude->promoid = $promoexclude['PROMOTIONID'];
								$PromotionExclude->promoeid = $promoexclude['EXCLUDEPROMOTIONID'];

								if(empty($checkpromotionlist))
								{
									$PromotionExclude->addData();
								}
								else
								{
									$PromotionExclude->promooldid = $checkpromotionlist[0]->promoid;
									$PromotionExclude->promoeoldid = $checkpromotionlist[0]->promoeid;
									$PromotionExclude->updateData();
								}
							}
						}
					}

					//update promotion group
					$excludepromotiongroup = array();
					if(!empty($promotiongroup))
					{
						foreach($promotiongroup as $promogroup)
						{
							if(!empty($promogroup['PROMOTIONID']) && !empty($promogroup['PROMOTIONLISTGROUPID']))
							{
								$promotionGroup = new Core_Promotiongroup();
								$checkpromotionstore = Core_Promotiongroup::getPromotiongroups(array('fid'=>$promogroup['PROMOTIONLISTGROUPID']),'discountvalue','DESC',1);

								//if(!in_array($promogroup['PROMOTIONLISTGROUPID'], $excludepromotiongroup)) $excludepromotiongroup[] = $promogroup['PROMOTIONLISTGROUPID'];

								$promotionGroup->id = $promogroup['PROMOTIONLISTGROUPID'];
								$promotionGroup->promoid = $promogroup['PROMOTIONID'];
								$promotionGroup->name = $promogroup['PROMOTIONLISTGROUPNAME'];
								$promotionGroup->isfixed = $promogroup['ISFIXED'];
								$promotionGroup->isdiscount = $promogroup['ISDISCOUNT'];
								$promotionGroup->discountvalue = $promogroup['DISCOUNTVALUE'];
								$promotionGroup->isdiscountpercent = $promogroup['ISPERCENTDISCOUNT'];
								$promotionGroup->iscondition = $promogroup['ISCONDITION'];
								$promotionGroup->conditioncontent = $promogroup['CONDITIONCONTENT'];
								$promotionGroup->type = $promogroup['PROMOTIONLISTGROUPTYPE'];

								if(empty($checkpromotionstore))
								{
									$promotionGroup->addDataID();
								}
								else
								{
									$promotionGroup->updateData();
								}
							}
						}
					}

					//update promotion group list
					$excludepromotionlistgroup = array();
					$excludepromotionlistgroupbarcode = array();
					if(!empty($promotiongrouplist))
					{
						foreach($promotiongrouplist as $grouplist)
						{
							if(!empty($grouplist['PROMOTIONLISTGROUPID']) && !empty($grouplist['PRODUCTID']))
							{
								$promotionGroupList = new Core_Promotionlist();
								$checkpromotionlist = Core_Promotionlist::getPromotionlists(array('fpbarcode'=>$grouplist['PRODUCTID'],'fpromogid'=>$grouplist['PROMOTIONLISTGROUPID']),'','',1);
								$promotionGroupList->promogid = $grouplist['PROMOTIONLISTGROUPID'];
								$promotionGroupList->pbarcode = $grouplist['PRODUCTID'];
								$promotionGroupList->iscombo = $grouplist['ISCOMBO'];
								$promotionGroupList->price = $grouplist['PROMOTIONPRICE'];
								$promotionGroupList->quantity = $grouplist['QUANTITY'];
								$promotionGroupList->ispercentcalc = $grouplist['ISPERCENTCALC'];
								$promotionGroupList->imei = $grouplist['IMEI'];
								$promotionGroupList->imeipromotionid = $grouplist['IMEIPRODUCTID'];

								$promotionGroupList->datemodify = time();
								if(empty($checkpromotionlist))
								{
									$promotionGroupList->dateadd = time();
									$promotionGroupList->addData();
								}
								else{
									$promotionGroupList->id = $checkpromotionlist[0]->id;
									$promotionGroupList->updateData();
								}
							}
						}
					}
					//update promotion out put type
					$excludepromotionoutputtype = array();
					if(!empty($promotionoutputtypelist))
					{
						foreach($promotionoutputtypelist as $outputtype)
						{
							if(!empty($outputtype['PROMOTIONID']) && !empty($outputtype['OUTPUTTYPEID']))
							{
								$promotionOutputtype = new Core_PromotionOutputtype();
								$checkpromotionlist = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromoid'=>$outputtype['PROMOTIONID'],'fpoid'=>$outputtype['OUTPUTTYPEID']),'','',1);
								$promotionOutputtype->promoid = $outputtype['PROMOTIONID'];
								$promotionOutputtype->poid = $outputtype['OUTPUTTYPEID'];
								if(empty($checkpromotionlist))
								{
									$promotionOutputtype->addData();
								}
								else
								{
									$promotionOutputtype->id = $checkpromotionlist[0]->id;
									$promotionOutputtype->updateData();
								}
							}
						}
					}
					$totalrecord++;

				}
				$this->savepromotionproductprice($listpromotionids);
			}
		}
	}

	private function savepromotionproductprice($listpromotionids)
	{
		if(empty($listpromotionids)) return false;
		//tim promotion giam gia cao nhat
		$findhighestpromotion = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $listpromotionids),'discountvalue', 'DESC', 1);
		$promoid = 0;
		if(!empty($findhighestpromotion))
		{
			$promoid = $findhighestpromotion[0]->promoid;
		}

		if($promoid ==0 ) return false;

		$getPromoStoreList = Core_PromotionStore::getPromotionStores(array('fpromoid' => $promoid),'','');
		if(!empty($getPromoStoreList))
		{
			$liststoreids = array();
			foreach($getPromoStoreList as $store)
			{
				if(!in_array($store->sid, $liststoreids))
				{
					$liststoreids[] = $store->sid;
				}
			}
			if(!empty($liststoreids))
			{
				$getStoreList = Core_Store::getStores(array('fidarr' => $liststoreids), '', '');
				if(!empty($getStoreList))
				{
					$listaids = array();
					$listppaid = array();
					foreach($getStoreList as $st)
					{
						if(!in_array($st->aid, $listaids))
						{
							$listaids[] = $st->aid;
						}
						if($st->ppaid > 0 && !in_array($st->ppaid, $listppaid))
						{
							$listppaid[] = $st->ppaid;
						}
					}
					if(!empty($listaids) && !empty($listppaid))
					{
						$listRegionPriceAreas = Core_RelRegionPricearea::getRelRegionPriceareas(array('faidarr' => $listaids, 'fppaidarr' => $listppaid),'','');
						if(empty($listRegionPriceAreas)) return false;
						$listRegions = array();
						foreach($listRegionPriceAreas as $relRP)
						{
							if(!in_array($relPR->rid, $listRegions))
							{
								$listRegions[] =  $relRP->rid;
							}
						}
						if(!empty($listRegions))
						{
							//lay promotion product
							$listpromotionproduct = Core_PromotionProduct::getPromotionProducts(array('fpromoid' => $promoid, 'faidarr' => $listaids), '', '');
							if(!empty($listpromotionproduct))
							{
								$listproductpromolists = array();
								foreach($listpromotionproduct as $productpromo)
								{
									$productpromo->pbarcode = trim($productpromo->pbarcode);
									if(!empty($productpromo->pbarcode))
									{
										$getProductBybarocde = Core_Product::getIdByBarcode($productpromo->pbarcode);

										if($getProductBybarocde->id > 0)
										{
											$arrupdate = array();
											$discountpromotion = Core_Promotion::getFirstDiscountPromotionById($promoid);
											if(!empty($discountpromotion))
											{
												foreach($listRegions as $rid)
												{
													if(!empty($discountpromotion))
													{
														$sellpriceproduct = $getProductBybarocde->sellprice;
														if($discountpromotion['percent'] == 1)
														{
															$sellpriceproduct = $sellpriceproduct - ($sellpriceproduct * $discountpromotion['discountvalue']/100);
														}
														else
															$sellpriceproduct = $sellpriceproduct - $discountpromotion['discountvalue'];

														$arrupdate[] = $rid.','.$promoid.','.$discountpromotion['promogpid'].','.$sellpriceproduct;
													}
												}
											}
											if(!empty($arrupdate))
											{
												$updateProduct = new Core_Product($getProductBybarocde->id);
												$updateProduct->promotionlist = implode('###', $arrupdate);

												$updateProduct->updateData();
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return false;
	}

	private function expriedproductpromotion($idFilter)//$idFilter: promotion id
	{
		$promotion = new Core_Promotion($idFilter);
		if($promotion->id > 0)
		{
			$listallProductPromotion = Core_PromotionProduct::getPromotionProducts(array('fpromoid' => $promotion->id), '', '');
			//lay promotion product ra de clear field promotionlist cua product
			if(!empty($listallProductPromotion))
			{
				$listproductbarcode = array();
				foreach($listallProductPromotion as $promoproduct)
				{
					$promoproduct->pbarcode = trim($promoproduct->pbarcode);
					if(!in_array($promoproduct->pbarcode, $listproductbarcode))
					{
						$myproduct = Core_Product::getIdByBarcode($promoproduct->pbarcode);
						if($myproduct->id > 0)
						{
							$arrupdate = array();
							if($myproduct->promotionlist != '')
							{
								$com = explode('###',$myproduct->promotionlist);
								if(!empty($com))
								{
									foreach($com as $c)
									{
										if(!empty($c))
										{
											list($newrid, $newpromoid, $newpromogrupid, $newpsellprice) = explode(',',trim($c));
											$checkpromotion = $this->registry->db->query('SELECT promo_id FROM '. TABLE_PREFIX.'promotion WHERE promo_id = '.(int)$promotion->id. ' AND promo_enddate < '.(int)time())->fetch();
											if(empty($checkpromotion) && $newpromoid != $promotion->id)
											{
												$arrupdate[] = $c;
											}
										}
									}
								}
							}
							$updateProduct = new Core_Product($myproduct->id);
							if(!empty($arrupdate)) {
								$updateProduct->promotionlist = implode('###', $arrupdate);
							}
							else $updateProduct->promotionlist = '';

							$updateProduct->updateData();
						}
					}
				}
			}
			$recordaffect++;
		}
	}


	function attributevalueupdateAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductcategory = new Core_Productcategory($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductcategory->id > 0)
		{
			//khong phai la admin
			if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
			{
				$checker = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fid'], 0, Core_RoleUser::ROLE_CHANGE, Core_RoleUser::STATUS_ENABLE);
				if(!$checker)
				{
					//kiem tra quyen cua danh muc cha
					$checkerparent = Core_RoleUser::checkRoleUser(Core_RoleUser::TYPE_PRODUCT, $this->registry->me->id, $formData['fparentid'], 0 , Core_RoleUser::ROLE_CHANGE , Core_RoleUser::STATUS_ENABLE);
					if(!$checkerparent)
					{
						header('location: ' . $this->registry['conf']['rooturl_cms'].'productcategory/index/permission/edit');
					}
				}
			}


			////////////////
			if(!empty($_POST['fsubmit']))
			{
				$oldList = $_POST['fattributeoldvalue'];
				$newList = $_POST['fattributenewvalue'];

				foreach($newList as $attrId => $attrValueList)
				{
					$myAttribute = new Core_ProductAttribute($attrId);

					foreach($attrValueList as $index => $newValue)
					{
						$newValue = trim($newValue);
						if(strlen($newValue) > 0)
						{

							$oldValue = $oldList[$attrId][$index];

							//Tien hanh Update
							$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute
									SET rpa_value = ?,
										rpa_valueseo = ?
									WHERE pa_id = ?
										AND rpa_value = ?';

							$rowCount = $this->registry->db->query($sql, array($newValue, Helper::codau2khongdau($newValue,true,true), $attrId, $oldValue))->rowCount();
							$success[] = 'Có (' . $rowCount . ' sản phẩm) chuyển giá trị thuộc tính <strong>'.$myAttribute->name . '</strong>, từ "<strong><u>'.$oldValue.'</u></strong>" sang "<strong><u>'.$newValue.'</u></strong>"';
						}
					}
				}
			}

			//Lay danh sach attribute
			$attributeList = Core_ProductAttribute::getProductAttributes(array('fpcid' =>  $myProductcategory->id), 'displayorder', 'ASC');

			//permission OK
			//get latest account
			$productgroupattributes = array();
			$formData['fpcid'] = $myProductcategory->id;
			$formData['fid'] = $_GET['paid'];

			if($formData['fid'] > 0)
			{
				$attributes = Core_ProductAttribute::getProductAttributes($formData, 'displayorder', 'ASC');

				for($i = 0; $i < count($attributes); $i++)
				{
					//Lay tat ca VALUE cua thuoc tinh
					$sql = 'SELECT rpa_value as value, rpa_valueseo as valueseo, COUNT(rpa_value) as countitem
							FROM ' . TABLE_PREFIX . 'rel_product_attribute
							WHERE pa_id = ?
							GROUP BY rpa_value';
					$stmt = $this->registry->db->query($sql, array($attributes[$i]->id));
					$rows = array();

					while($row = $stmt->fetch())
					{
						$rows[] = $row;
					}
					$attributes[$i]->valueList = $rows;
				}

				$productgroupattributes = array($attributes);
			}

			$this->registry->smarty->assign(array(	'productgroupattributes' => $productgroupattributes,
				'attributeList' => $attributeList,
				'success' => $success,
				'error' => $error,
				'myProductcategory' => $myProductcategory,
				'formData' => $formData,
			));

			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'attributevalueupdate.tpl');
		}
		else
		{
			$contents = 'Not Found';
		}



		$this->registry->smarty->assign(array(	'pageTitle'	=> 'Update Value of all attribute of products in category',
			'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	private function filterValidatorAction($formData , &$error)
	{
		$pass = true;

		return $pass;
	}
	public function clonecategorynameAction()
	{
		$category = Core_Productcategory::getProductcategorys(array(),'','');

		foreach ($category as $key => $cat) {
			# code...
			$cat = new Core_Productcategory($cat->id);
			if($cat->clonecategoryname())
			{
				echo "ok";
			}
			else
			{
				echo "not ok";
			}
		}
	}

	public function exportproductinfoofcategoryAction()
	{
		set_time_limit(0);
		$pcid = (int)$_GET['pcid'];

		$myProductcategory = new Core_Productcategory($pcid);

		if($myProductcategory->id > 0)
		{
			$data = '';
			$productlist = array();
			$data .= 'Danh mục#ID#Barcode#Tên#Hãng#Hình đại diện#Gallery#Hình 360#Giá#SEO description#Trạng thái#Slug#Bài viết#dienmay.com đánh giá#Hình bộ bán hàng chuẩn#Video#Bộ bán hàng chuẩn(text)#Sản phẩm liên quan#Sản phẩm bán kèm#Trạng thái ERP#NNgày tạo#Ngày cập nhật#Tồn kho#Sellprice#Loại#Number of Color#Status' . "\n";

			///GET SUB CATEGORY LIST
			$fullsubcategorylist = Core_Productcategory::getFullSubCategory($myProductcategory->id);

			$productlist = Core_Product::getProducts(array('fpcidarrin' => $fullsubcategorylist , 'fisonsitestatus' => 1, 'fcustomizetype' => Core_Product::CUSTOMIZETYPE_MAIN , 'fstatus'=>Core_Product::STATUS_ENABLE) , 'id' , 'ASC');

			foreach($productlist as $product)
			{
                //if($product->customizetype != Core_Product::CUSTOMIZETYPE_MAIN) break;

				$productcategory = new Core_Productcategory($product->pcid , true);
				$data .= $productcategory->name .'#' . $product->id . '#' . ($product->barcode != '' ? trim((string)$product->barcode) : 'No') . '#' . $product->name . '#'  . ($product->vid > 0 ? 'Yes' : 'No') . '#' . ($product->image != '' ? 'Yes' : 'No');								

				$numbergallery = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_FILE , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numbergallery > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}
				$number360 = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_360 , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($number360 > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->sellprice > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->seodescription != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$data .= '#' . $product->getonsitestatusName();
				$data .= '#' . $product->slug;
				if(trim($product->content) != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if(trim($product->dienmayreview) != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberimgefullbox = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_SPECIALTYPE , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numberimgefullbox > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofvideo = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_URL , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numberofvideo > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if(trim($product->fullboxshort) != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofsampleproduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype' => Core_RelProductProduct::TYPE_SAMPLE) , 'id' , 'ASC' , '' ,true);

				if($numberofsampleproduct > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofaccessoriesproduct =  Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES) , 'id' , 'ASC' , '' ,true);
				if($numberofaccessoriesproduct > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$data .= '#' . $product->getbusinessstatusName();
				$data .= "#" . date('d/m/Y' , $product->datecreated);
				$data .= ($product->datemodified != "") ? "#" . date('d/m/Y' , $product->datemodified) : "# ";
				$data .= '#' . $product->instock;
				$data .= '#' . $product->sellprice;
				$data .= ($product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN) ? '#Main' : '#Color';
                //$numberofproductcolor = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype'=>Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '' , true);
                $countcolorlist = explode('###' , $product->colorlist);
                $numberofproductcolor = (count($countcolorlist) > 0) ? count($countcolorlist) -1 : 0;
                $data .= '#' . $numberofproductcolor;

                $data .= '#' . $product->getStatusName();

				$data .= "\n";

			}
			unset($productlist);

			$myHttpDownload = new HttpDownload();
			$myHttpDownload->set_bydata($data); //Download from php data
			$myHttpDownload->use_resume = true; //Enable Resume Mode
			$myHttpDownload->filename = 'productdata-'.date('Y-m-d-H-i-s') . '.csv';
			$myHttpDownload->download(); //Download File
		}

	}
}


