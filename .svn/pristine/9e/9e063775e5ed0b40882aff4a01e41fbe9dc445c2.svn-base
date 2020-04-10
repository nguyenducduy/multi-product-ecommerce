<?php

Class Controller_Cms_ProductReview Extends Controller_Cms_Base
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


		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$objectidFilter = (int)($this->registry->router->getArg('objectid'));
		$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
		$emailFilter = (string)($this->registry->router->getArg('email'));
		$moderatoridFilter = (int)($this->registry->router->getArg('moderatorid'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$pcidFilter = (int)$this->registry->router->getArg('pcid');

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');		

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'datecreated';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;
		$tab = (int)$this->registry->router->getArg('tab') > 0 ? (int)$this->registry->router->getArg('tab') : 1;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['productreviewBulkToken']==$_POST['ftoken'])
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
                            $myProductReview = new Core_ProductReview($id);

                            if($myProductReview->id > 0)
                            {
                                //tien hanh xoa
                                if($myProductReview->delete())
                                {
                                    $deletedItems[] = $myProductReview->id;
                                    $this->registry->me->writelog('productreview_delete', $myProductReview->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myProductReview->id;
                            }
                            else
                                $cannotDeletedItems[] = $myProductReview->id;
                        }

                        if(count($deletedItems) > 0)
                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

                        if(count($cannotDeletedItems) > 0)
                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
                    }
					elseif($_POST['fbulkaction'] == 'pending')
					{
						$reviewArr = $_POST['fbulkid'];
						$peningItems = array();
						$cannotpendingItems = array();

						foreach ($reviewArr as $id)
						{
							$myProductReview = new Core_ProductReview($id);
							if($myProductReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myProductReview->status = Core_ProductReview::STATUS_PENDING;
								$myProductReview->moderatorid = $this->registry->me->id;
								if($myProductReview->updateData())
								{
									$peningItems[] = $myProductReview->id;
									$this->registry->me->writelog('productreview_edit_pending', $myProductReview->id, array());
								}
								else
									$cannotpendingItems[] = $myProductReview->id;
							}
							else
								$cannotpendingItems[] = $myProductReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'success')
					{
						$reviewArr = $_POST['fbulkid'];
						$enableItems = array();
						$cannotenableItems = array();

						foreach ($reviewArr as $id)
						{
							$myProductReview = new Core_ProductReview($id);
							if($myProductReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myProductReview->status = Core_ProductReview::STATUS_ENABLE;
								$myProductReview->moderatorid = $this->registry->me->id;
								if($myProductReview->updateData())
								{
									$enableItems[] = $myProductReview->id;
									$this->registry->me->writelog('productreview_edit_enable', $myProductReview->id, array());
								}
								else
									$cannotenableItems[] = $myProductReview->id;
							}
							else
								$cannotenableItems[] = $myProductReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'spam')
					{
						$reviewArr = $_POST['fbulkid'];
						$spamItems = array();
						$cannotspamItems = array();

						foreach ($reviewArr as $id)
						{
							$myProductReview = new Core_ProductReview($id);
							if($myProductReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myProductReview->status = Core_ProductReview::STATUS_SPAM;
								$myProductReview->moderatorid = $this->registry->me->id;
								if($myProductReview->updateData())
								{
									$spamItems[] = $myProductReview->id;
									$this->registry->me->writelog('productreview_edit_spam', $myProductReview->id, array());
								}
								else
									$cannotspamItems[] = $myProductReview->id;
							}
							else
								$cannotspamItems[] = $myProductReview->id;
						}
					}
                    else
                    {
                        //bulk action not select, show error
                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
                    }
                }
            }

		}

		$_SESSION['productreviewBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($objectidFilter > 0)
		{
			$paginateUrl .= 'objectid/'.$objectidFilter . '/';
			$formData['fobjectid'] = $objectidFilter;
			$formData['search'] = 'objectid';
		}

		if($pcidFilter > 0)
		{
			$paginateUrl .= 'pcid/'.$pcidFilter . '/';

			$productidlist = array();
			//lay tat ca danh muc con cua danh muc hien tai
			$subcategorylist = Core_Productcategory::getFullSubCategory($pcidFilter);

			//lay tat ca san pham cua danh muc
			$productlist = Core_Product::getProductIdByCategory($subcategorylist);
	

			if(count($productlist) > 0)
			{
				foreach ($productlist as $product) 
				{
					$productidlist[] = $product['p_id'];
				}
			}

			$formData['fobjectidarr'] = $productidlist;
			$formData['fpcid'] = $pcidFilter;
			$formData['search'] = 'pcid';
		}

		if($fullnameFilter != "")
		{
			$paginateUrl .= 'fullname/'.$fullnameFilter . '/';
			$formData['ffullname'] = $fullnameFilter;
			$formData['search'] = 'fullname';
		}

		if($emailFilter != "")
		{
			$paginateUrl .= 'email/'.$emailFilter . '/';
			$formData['femail'] = $emailFilter;
			$formData['search'] = 'email';
		}

		if($moderatoridFilter > 0)
		{
			$paginateUrl .= 'moderatorid/'.$moderatoridFilter . '/';
			$formData['fmoderatorid'] = $moderatoridFilter;
			$formData['search'] = 'moderatorid';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($parentidFilter > 0)
		{
			$paginateUrl .= 'parentid/'.$parentidFilter . '/';
			$formData['fparentid'] = $parentidFilter;
			$formData['search'] = 'parentid';
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

			if($searchKeywordIn == 'fullname')
			{
				$paginateUrl .= 'searchin/fullname/';
			}
			elseif($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		/*$catlist = array();
		if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
		{
			$roleusers = Core_RoleUser::getRoleUsers(array('fuid'=>$this->registry->me->id , 'ftype' => Core_RoleUser::TYPE_PRODUCT , 'fstatus' => Core_RoleUser::STATUS_ENABLE) , 'id' , 'ASC' , '', false,true);
			foreach($roleusers as $roleuser)
			{
				$catlist[] = $roleuser->objectid;
			}

		}*/

		/*if(count($catlist) > 0 || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('developer'))
		{
			//tim tong so
			$total = Core_ProductReview::getProductReviews($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$productreviews = Core_ProductReview::getProductReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			if(count($productreviews) > 0)
			{
				$list = array();
				foreach ($productreviews as $productreview)
				{
					$productreview->product = new Core_Product($productreview->objectid);
					$productreview->actor = new Core_User($productreview->uid);
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						if(in_array($productreview->product->pcid, $catlist))
						{
							$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
							$list[] = $productreview;
						}
					}
					else
					{
						$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
						$list[] = $productreview;
					}
				}
				$productreviews = $list;				
			}

			//get review pending
			$formDatas = $formData;			
			$formDatas['fstatus'] = Core_ProductReview::STATUS_PENDING;
			$totalpending = Core_ProductReview::getProductReviews($formDatas, $sortby, $sorttype, 0, true);
			$productreviewspending = Core_ProductReview::getProductReviews($formDatas, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
			if(count($productreviewspending) > 0)
			{
				$list = array();
				foreach ($productreviewspending as $productreview)
				{
					$productreview->product = new Core_Product($productreview->objectid);
					$productreview->actor = new Core_User($productreview->uid);
					if(!$this->registry->me->isGroup('administrator') && !$this->registry->me->isGroup('developer'))
					{
						if(in_array($productreview->product->pcid, $catlist))
						{							
							$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
							$list[] = $productreview;
						}
					}
					else
					{
						$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
						$list[] = $productreview;
					}
				}
				$productreviewspending = $list;				
			}
		}*/

		//tim tong so
		$total = Core_ProductReview::getProductReviews($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$productreviews = Core_ProductReview::getProductReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		foreach ($productreviews as $productreview)
		{		
			$productreview->product = new Core_Product($productreview->objectid);	
			$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
		}
		

		//get review pending
		$formDatas = $formData;			
		$formDatas['fstatus'] = Core_ProductReview::STATUS_PENDING;
		$totalpending = Core_ProductReview::getProductReviews($formDatas, $sortby, $sorttype, 0, true);
		$productreviewspending = Core_ProductReview::getProductReviews($formDatas, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		foreach ($productreviewspending as $productreview)
		{
			$productreview->product = new Core_Product($productreview->objectid);
			$productreview->productcategory = new Core_Productcategory($productreview->product->pcid);
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

		//lay tat cac danh muc trong he thong
		$productcategoryList = array();
        $parentCategory1 = Core_Productcategory::getProductcategorys(array('fparentid' => 0), 'parentid', 'ASC');
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

        //lay tat ca cac nganh hang root
       	$rootcategorylist = Core_Productcategory::getRootProductcategory();       	

		$this->registry->smarty->assign(array(	'productreviews' 	=> $productreviews,
												'statusList'	=> Core_ProductReview::getStatusList(),
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
												'totalpending'	=> $totalpending,
												'productreviewspending' => $productreviewspending,
												'tab' => $tab,
												'productcategoryList' => $productcategoryList,
												'rootcategorylist' => $rootcategorylist,
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
            if($_SESSION['productreviewAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myProductReview = new Core_ProductReview();


					$myProductReview->uid = $formData['fuid'];
					$myProductReview->objectid = $formData['fobjectid'];
					$myProductReview->fullname = $formData['ffullname'];
					$myProductReview->email = $formData['femail'];
					$myProductReview->text = $formData['ftext'];
					$myProductReview->ipaddress = $formData['fipaddress'];
					$myProductReview->moderatorid = $formData['fmoderatorid'];
					$myProductReview->status = $formData['fstatus'];
					$myProductReview->countthumbup = $formData['fcountthumbup'];
					$myProductReview->countthumbdown = $formData['fcountthumbdown'];
					$myProductReview->countreply = $formData['fcountreply'];
					$myProductReview->datemoderated = $formData['fdatemoderated'];
					$myProductReview->parentid = $formData['fparentid'];

                    if($myProductReview->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('productreview_add', $myProductReview->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['productreviewAddToken']=Helper::getSecurityToken();//Tao token moi

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,

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
		$myProductReview = new Core_ProductReview($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myProductReview->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();

			$myProductReview->product = new Core_Product($myProductReview->objectid);


			$formData['fuid'] = $myProductReview->uid;
			$formData['fid'] = $myProductReview->id;
			$formData['fobjectid'] = $myProductReview->objectid;
			$formData['ffullname'] = $myProductReview->fullname;
			$formData['femail'] = $myProductReview->email;
			$formData['ftext'] = $myProductReview->text;
			$formData['fipaddress'] = $myProductReview->ipaddress;
			$formData['fmoderatorid'] = $myProductReview->moderatorid;
			$formData['fstatus'] = $myProductReview->status;
			$formData['fcountthumbup'] = $myProductReview->countthumbup;
			$formData['fcountthumbdown'] = $myProductReview->countthumbdown;
			$formData['fcountreply'] = $myProductReview->countreply;
			$formData['fdatecreated'] = $myProductReview->datecreated;
			$formData['fdatemodified'] = $myProductReview->datemodified;
			$formData['fdatemoderated'] = $myProductReview->datemoderated;
			$formData['fparentid'] = $myProductReview->parentid;
			$formData['pname'] = $myProductReview->product->name;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['productreviewEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myProductReview->uid = $formData['fuid'];
						$myProductReview->objectid = $formData['fobjectid'];
						$myProductReview->fullname = $formData['ffullname'];
						$myProductReview->email = $formData['femail'];
						$myProductReview->text = Helper::plaintext($formData['ftext']);
						$myProductReview->ipaddress = Helper::getIpAddress(true);
						$myProductReview->moderatorid = $this->registry->me->id;
						$myProductReview->status = $formData['fstatus'];
						$myProductReview->countthumbup = $formData['fcountthumbup'];
						$myProductReview->countthumbdown = $formData['fcountthumbdown'];
						$myProductReview->countreply = $formData['fcountreply'];
						$myProductReview->datemoderated = $formData['fdatemoderated'];
						$myProductReview->parentid = $formData['fparentid'];

                        if($myProductReview->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('productreview_edit', $myProductReview->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['productreviewEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													'statusList' => Core_ProductReview::getStatusList(),
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
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

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myProductReview = new Core_ProductReview($id);
		if($myProductReview->id > 0)
		{
			//tien hanh xoa
			if($myProductReview->delete())
			{
				$redirectMsg = str_replace('###id###', $myProductReview->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('productreview_delete', $myProductReview->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myProductReview->id, $this->registry->lang['controller']['errDelete']);
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

	public function replyAction()
	{

		$error = array();
		$success = array();
		$warning = array();
		$formData = array();

		$parentid = $this->registry->router->getArg('parentid');

		if($parentid > 0)
		{
			$parentReview = new Core_ProductReview($parentid);
			if($parentReview->id > 0)
			{
				if(!empty($_POST['fsubmit']))
				{
					$formData = array_merge($formData,$_POST);
					if($this->replyActionValidator($formData, $error))
					{
						//create reply
						$productreview = new Core_ProductReview();
						$productreview->uid = $this->registry->me->id;
						$productreview->objectid = $parentReview->objectid;
						$productreview->subobjectid = $parentReview->subobjectid;
						$productreview->fullname = $this->registry->me->fullname;
						$productreview->email = $this->registry->me->email;
						$productreview->text = Helper::plaintext($formData['freviewcontent']);
						$productreview->ipaddress = Helper::getIpAddress(true);
						$productreview->moderatorid = $this->registry->me->id;
						$productreview->parentid = $parentReview->id;
						$productreview->status = Core_ProductReview::STATUS_ENABLE;
						if($productreview->addData() > 0)
						{
							$parentReview->countreply = $parentReview->countreply + 1;
							if($parentReview->updateData())
							{
								//Send mail
								if($parentReview->isfeedback == Core_ProductReview::EMAILFEEDBACK)
								{
									$replyData = array();
									$product = new Core_Product($parentReview->objectid);
									$replyData['femail'] = $parentReview->email;
									$replyData['fullname'] = $parentReview->fullname;
									$replyData['productname'] = $product->name;
									$replyData['foldcontent'] = $parentReview->text;
									$replyData['dienmayreplay'] = Helper::plaintext($formData['freviewcontent']);
									$replyData['linkProduct'] = $product->getProductPath();
									$this->sendEmail($replyData);
								}
								//End Send mail
								$success[] = $this->registry->lang['controller']['succReply'];
								$this->registry->me->writelog('productreview_add', $myProductReview->id, array());
							}
							else
							{
								$error[] = $this->registry->lang['controller']['errReply'];
							}
						}
						else
						{
							$error[] = $this->registry->lang['controller']['errReply'];
						}
					}
				}

			}
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errReply'];
		}

		$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,
													));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reply.tpl');
		$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'reply.tpl');
	}


	// SEND MAIL WHEN REPLY ===
	public function sendemail($formData)
    {
        $this->registry->smarty->assign(array('formData'=>$formData));
        $mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'replycomment/index.tpl');
        $sender       = new SendMail(
        	$this->registry,
        	$formData['femail'],
        	'dienmay.com',
        	'Bạn có phản hồi từ dienmay.com',
        	$mailContents,
        	$this->registry->setting['mail']['fromEmail'],
        	$this->registry->setting['mail']['fromName']
        );
        if ($sender->Send()) {
                return true;
        }
        else {
                return false;
        }
    }
	// END SEND MAUL WHEN REPLY

	public function syncReplyReviewAction()
	{
		$reviews = Core_ProductReview::getProductReviews(array() , 'id' , 'ASC');
		if(count($reviews) > 0)
		{
			foreach($reviews as $review)
			{
				$countreply = Core_ProductReview::getProductReviews(array('fparentid' => $review->id) , 'id' , 'ASC' , '' , true);
				if($countreply > 0)
				{
					$review->countreply = $countreply;
					if($review->updateData())
					{
						echo $review->id . '&nbsp;updated<br />';
						$this->registry->me->writelog('productreview_edit', $myProductReview->id, array());
					}
					else
					{
						echo $review->id . '&nbsp;not updated<br />';
					}
				}
			}
		}
	}

	public function reportreviewAction()
	{
		$redirectUrl = $this->getRedirectUrl();
		$formData = array();

		$formData = array_merge($formData , $_POST);
		
		$chartData = array();

		 //lay tat ca cac nganh hang root
       	$rootcategorylist = Core_Productcategory::getRootProductcategory();       
       	$formData['startdate'] = strlen($formData['startdate']) > 0 ? Helper::strtotimedmy($formData['startdate']) : strtotime('-7 day' , time());
       	$formData['enddate'] = strlen($formData['enddate']) > 0 ? Helper::strtotimedmy($formData['enddate']) : time();      
       	$pcidlist = array();

       	if($formData['startdate'] <= $formData['enddate'])
       	{
       		if($formData['fpcid'] > 0)
	       	{
	       		$productcategory = new Core_Productcategory($formData['fpcid']);
	       		if($productcategory->id > 0)
	       			$pcidlist[$productcategory->id] =  $productcategory->name;
	       	}
	       	else
	       	{
	       		foreach ($rootcategorylist as $rootcategory) 
	       		{
	       			$pcidlist[$rootcategory->id] = $rootcategory->name;
	       		}
	       	}
	       	
	       	if(count($pcidlist) > 0)
	       	{
	       		foreach ($pcidlist as $pcid => $pcname) 
	       		{       			
	       			$productidlist = array();
					//lay tat ca danh muc con cua danh muc hien tai
					$subcategorylist = Core_Productcategory::getFullSubCategory($pcid);										

					$totalreview = 0;
					$dt = $formData['startdate'];
		       		while($dt <= $formData['enddate'])
		       		{
		       			$dtdate = date('d/m' , $dt);  	       			
		       			$formData['fdatecreatedfrom'] = mktime(0 ,0 ,1 , date('m' , $dt) , date('d' , $dt) , date('Y' , $dt) );
						$formData['fdatecreatedto'] = mktime(23 , 59 ,59 , date('m' , $dt) , date('d' , $dt) , date('Y' , $dt) );
						$formData['fsubobjectidin'] = $subcategorylist;						
						$totalreview = Core_ProductReview::getProductReviews($formData, 'id', 'ASC', 0, true);
						$chartData[$dtdate][$pcid] = $totalreview;

						$dt = strtotime('+1 day' , $dt);
		       		}	       					
	       		}       		       		
	       	}
       	}

       	//////////////       
       	$stepdate = ceil(($formData['enddate']  - $formData['startdate']) / (24 * 3600)) - 1;
		if($stepdate > 7)
				$stepdate = ceil($stepdate / 7) - 1;	
		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'error'			=> $error,
												'success'		=> $success,
												'rootcategorylist' => $rootcategorylist,
												'statusList' => Core_ProductReview::getStatusList(),
												'chartData' => $chartData,
												'stepdate' => $stepdate,
												'pcidlist' => $pcidlist,
												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reportreview.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> 'Thống kê bình luận',
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}


	public function exportproductreviewAction()
	{
		set_time_limit(0);
		$data = '';
		//get list review not from employee and count reply = 0
        $productreviewList = Core_ProductReview::getProductReviews(array('fstatus' => Core_ProductReview::STATUS_ENABLE , 'fnotemployee' => 1 , 'fnotreply' => 1) , 'id' , 'ASC');

        if(count($productreviewList) > 0)
        {
            $data = 'Id#Fullname#Email#Content Review#Date' . "\n";
            foreach($productreviewList as $productreview)
            {
                $data .= $productreview->id . '#' . $productreview->fullname . '#' . $productreview->email . '#' . $productreview->text . '#' . date('d-m-Y' , $productreview->datecreated) . "\n";
            }

            $myHttpDownload = new HttpDownload();
		    $myHttpDownload->set_bydata($data); //Download from php data
		    $myHttpDownload->use_resume = true; //Enable Resume Mode
		    $myHttpDownload->filename = 'productreviewdata-'.date('Y-m-d-H-i-s') . '.csv';
		    $myHttpDownload->download(); //Download File 
        }
		
	}
	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fobjectid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errObjectidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}

		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fobjectid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errObjectidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['ffullname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
			$pass = false;
		}

		if(!Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		return $pass;
	}

	private function replyActionValidator($formData  , &$error)
	{
		$pass = true;

		if(Helper::plaintext($formData['freviewcontent']) == '')
		{
			$error = $this->registry->lang['controller']['errContentEmpty'];
			$pass = false;
		}

		return $pass;
	}
}


