<?php

Class Controller_Cms_GiareReview Extends Controller_Cms_Base
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
		$parentidFilter = (int)($this->registry->router->getArg('parentid'));
		$idFilter = (int)($this->registry->router->getArg('id'));
		$statusFilter = (int)($this->registry->router->getArg('status'));

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
            if($_SESSION['giarereviewBulkToken']==$_POST['ftoken'])
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
                            $myGiareReview = new Core_GiareReview($id);

                            if($myGiareReview->id > 0)
                            {
                                //tien hanh xoa
                                if($myGiareReview->delete())
                                {
                                    $deletedItems[] = $myGiareReview->id;
                                    $this->registry->me->writelog('giarereview_delete', $myGiareReview->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myGiareReview->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGiareReview->id;
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
							$myGiareReview = new Core_GiareReview($id);
							if($myGiareReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myGiareReview->status = Core_GiareReview::STATUS_PENDING;
								$myGiareReview->moderatorid = $this->registry->me->id;
								if($myGiareReview->updateData())
								{
									$peningItems[] = $myGiareReview->id;
									$this->registry->me->writelog('giarereview_edit_pending', $myGiareReview->id, array());
								}
								else
									$cannotpendingItems[] = $myGiareReview->id;
							}
							else
								$cannotpendingItems[] = $myGiareReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'success')
					{
						$reviewArr = $_POST['fbulkid'];
						$enableItems = array();
						$cannotenableItems = array();

						foreach ($reviewArr as $id)
						{
							$myGiareReview = new Core_GiareReview($id);
							if($myGiareReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myGiareReview->status = Core_GiareReview::STATUS_ENABLE;
								$myGiareReview->moderatorid = $this->registry->me->id;
								if($myGiareReview->updateData())
								{
									$enableItems[] = $myGiareReview->id;
									$this->registry->me->writelog('giarereview_edit_enable', $myGiareReview->id, array());
								}
								else
									$cannotenableItems[] = $myGiareReview->id;
							}
							else
								$cannotenableItems[] = $myGiareReview->id;
						}
					}
					elseif($_POST['fbulkaction'] == 'spam')
					{
						$reviewArr = $_POST['fbulkid'];
						$spamItems = array();
						$cannotspamItems = array();

						foreach ($reviewArr as $id)
						{
							$myGiareReview = new Core_GiareReview($id);
							if($myGiareReview->id > 0)
							{
								//tien hanh cap nhat trang thai
								$myGiareReview->status = Core_GiareReview::STATUS_SPAM;
								$myGiareReview->moderatorid = $this->registry->me->id;
								if($myGiareReview->updateData())
								{
									$spamItems[] = $myGiareReview->id;
									$this->registry->me->writelog('giarereview_edit_spam', $myGiareReview->id, array());
								}
								else
									$cannotspamItems[] = $myGiareReview->id;
							}
							else
								$cannotspamItems[] = $myGiareReview->id;
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

		$_SESSION['giarereviewBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

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

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
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

		//tim tong so
		$total = Core_GiareReview::getGiareReviews($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$giarereviews = Core_GiareReview::getGiareReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//get review pending
		$formData['fstatus'] = Core_GiareReview::STATUS_PENDING;
		$giarereviewspending = Core_GiareReview::getGiareReviews($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'giarereviews' 	=> $giarereviews,
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
												'giarereviewspending' => $giarereviewspending,
												'totalpending' => $totalpending,
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
            if($_SESSION['giarereviewAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myGiareReview = new Core_GiareReview();


					$myGiareReview->uid = $formData['fuid'];
					$myGiareReview->objectid = $formData['fobjectid'];
					$myGiareReview->fullname = $formData['ffullname'];
					$myGiareReview->email = $formData['femail'];
					$myGiareReview->text = $formData['ftext'];
					$myGiareReview->ipaddress = $formData['fipaddress'];
					$myGiareReview->moderatorid = $formData['fmoderatorid'];
					$myGiareReview->status = $formData['fstatus'];
					$myGiareReview->countthumbup = $formData['fcountthumbup'];
					$myGiareReview->countthumbdown = $formData['fcountthumbdown'];
					$myGiareReview->countreply = $formData['fcountreply'];
					$myGiareReview->datemoderated = $formData['fdatemoderated'];
					$myGiareReview->parentid = $formData['fparentid'];

                    if($myGiareReview->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('giarereview_add', $myGiareReview->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['giarereviewAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myGiareReview = new Core_GiareReview($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myGiareReview->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['fuid'] = $myGiareReview->uid;
			$formData['fid'] = $myGiareReview->id;
			$formData['fobjectid'] = $myGiareReview->objectid;
			$formData['ffullname'] = $myGiareReview->fullname;
			$formData['femail'] = $myGiareReview->email;
			$formData['ftext'] = $myGiareReview->text;
			$formData['fipaddress'] = $myGiareReview->ipaddress;
			$formData['fmoderatorid'] = $myGiareReview->moderatorid;
			$formData['fstatus'] = $myGiareReview->status;
			$formData['fcountthumbup'] = $myGiareReview->countthumbup;
			$formData['fcountthumbdown'] = $myGiareReview->countthumbdown;
			$formData['fcountreply'] = $myGiareReview->countreply;
			$formData['fdatecreated'] = $myGiareReview->datecreated;
			$formData['fdatemodified'] = $myGiareReview->datemodified;
			$formData['fdatemoderated'] = $myGiareReview->datemoderated;
			$formData['fparentid'] = $myGiareReview->parentid;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['giarereviewEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myGiareReview->uid = $formData['fuid'];
						$myGiareReview->objectid = $formData['fobjectid'];
						$myGiareReview->fullname = $formData['ffullname'];
						$myGiareReview->email = $formData['femail'];
						$myGiareReview->text = $formData['ftext'];
						$myGiareReview->ipaddress = $formData['fipaddress'];
						$myGiareReview->moderatorid = $formData['fmoderatorid'];
						$myGiareReview->status = $formData['fstatus'];
						$myGiareReview->countthumbup = $formData['fcountthumbup'];
						$myGiareReview->countthumbdown = $formData['fcountthumbdown'];
						$myGiareReview->countreply = $formData['fcountreply'];
						$myGiareReview->datemoderated = $formData['fdatemoderated'];
						$myGiareReview->parentid = $formData['fparentid'];

                        if($myGiareReview->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('giarereview_edit', $myGiareReview->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['giarereviewEditToken'] = Helper::getSecurityToken();//Tao token moi

			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
													'redirectUrl'=> $redirectUrl,
													'error'		=> $error,
													'success'	=> $success,

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
		$myGiareReview = new Core_GiareReview($id);
		if($myGiareReview->id > 0)
		{
			//tien hanh xoa
			if($myGiareReview->delete())
			{
				$redirectMsg = str_replace('###id###', $myGiareReview->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('giarereview_delete', $myGiareReview->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGiareReview->id, $this->registry->lang['controller']['errDelete']);
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
			$parentReview = new Core_GiareReview($parentid);
			if($parentReview->id > 0)
			{
				if(!empty($_POST['fsubmit']))
				{
					$formData = array_merge($formData,$_POST);
					if($this->replyActionValidator($formData, $error))
					{
						//create reply
						$giarereview = new Core_GiareReview();
						$giarereview->uid = $this->registry->me->id;
						$giarereview->objectid = $parentReview->objectid;
						$giarereview->fullname = $this->registry->me->fullname;
						$giarereview->email = $this->registry->me->email;
						$giarereview->text = Helper::plaintext($formData['freviewcontent']);
						$giarereview->ipaddress = Helper::getIpAddress(true);
						$giarereview->moderatorid = $this->registry->me->id;
						$giarereview->parentid = $parentReview->id;
						$giarereview->status = Core_GiareReview::STATUS_ENABLE;
						if($giarereview->addData() > 0)
						{
							$parentReview->countreply = $parentReview->countreply + 1;
							if($parentReview->updateData())
							{
								$success[] = $this->registry->lang['controller']['succReply'];
								$this->registry->me->writelog('giarereview_add', $mygiarereview->id, array());
								$formData = array();
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


	public function syncReplyReviewAction()
	{
		$reviews = Core_GiareReview::getProductReviews(array() , 'id' , 'ASC');
		if(count($reviews) > 0)
		{
			foreach($reviews as $review)
			{
				$countreply = Core_GiareReview::getProductReviews(array('fparentid' => $review->id) , 'id' , 'ASC' , '' , true);
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

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

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

		if(Helper::ValidatedEmail($formData['femail']))
		{
			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
			$pass = false;
		}

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



// 		if($formData['fuid'] <= 0)
// 		{
// 			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
// 			$pass = false;
// 		}

// 		if($formData['fobjectid'] <= 0)
// 		{
// 			$error[] = $this->registry->lang['controller']['errObjectidMustGreaterThanZero'];
// 			$pass = false;
// 		}

// 		if($formData['ffullname'] == '')
// 		{
// 			$error[] = $this->registry->lang['controller']['errFullnameRequired'];
// 			$pass = false;
// 		}

// 		if(Helper::ValidatedEmail($formData['femail']))
// 		{
// 			$error[] = $this->registry->lang['controller']['errEmailInvalidEmail'];
// 			$pass = false;
// 		}

		if($formData['ftext'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTextRequired'];
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

?>