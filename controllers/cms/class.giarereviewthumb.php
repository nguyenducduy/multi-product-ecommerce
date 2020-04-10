<?php

Class Controller_Cms_GiareReviewThumb Extends Controller_Cms_Base
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


		$robjectidFilter = (int)($this->registry->router->getArg('robjectid'));
		$ridFilter = (int)($this->registry->router->getArg('rid'));
		$uidFilter = (int)($this->registry->router->getArg('uid'));
		$idFilter = (int)($this->registry->router->getArg('id'));


		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['giarereviewthumbBulkToken']==$_POST['ftoken'])
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
                            $myGiareReviewThumb = new Core_GiareReviewThumb($id);

                            if($myGiareReviewThumb->id > 0)
                            {
                                //tien hanh xoa
                                if($myGiareReviewThumb->delete())
                                {
                                    $deletedItems[] = $myGiareReviewThumb->id;
                                    $this->registry->me->writelog('giarereviewthumb_delete', $myGiareReviewThumb->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myGiareReviewThumb->id;
                            }
                            else
                                $cannotDeletedItems[] = $myGiareReviewThumb->id;
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

		$_SESSION['giarereviewthumbBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($robjectidFilter > 0)
		{
			$paginateUrl .= 'robjectid/'.$robjectidFilter . '/';
			$formData['frobjectid'] = $robjectidFilter;
			$formData['search'] = 'robjectid';
		}

		if($ridFilter > 0)
		{
			$paginateUrl .= 'rid/'.$ridFilter . '/';
			$formData['frid'] = $ridFilter;
			$formData['search'] = 'rid';
		}

		if($uidFilter > 0)
		{
			$paginateUrl .= 'uid/'.$uidFilter . '/';
			$formData['fuid'] = $uidFilter;
			$formData['search'] = 'uid';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}


		//tim tong so
		$total = Core_GiareReviewThumb::getGiareReviewThumbs($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$giarereviewthumbs = Core_GiareReviewThumb::getGiareReviewThumbs($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'giarereviewthumbs' 	=> $giarereviewthumbs,
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
            if($_SESSION['giarereviewthumbAddToken'] == $_POST['ftoken'])
            {
                 $formData = array_merge($formData, $_POST);


                if($this->addActionValidator($formData, $error))
                {
                    $myGiareReviewThumb = new Core_GiareReviewThumb();


					$myGiareReviewThumb->robjectid = $formData['frobjectid'];
					$myGiareReviewThumb->rid = $formData['frid'];
					$myGiareReviewThumb->uid = $formData['fuid'];
					$myGiareReviewThumb->value = $formData['fvalue'];
					$myGiareReviewThumb->ipaddress = $formData['fipaddress'];
					$myGiareReviewThumb->datecreared = $formData['fdatecreared'];

                    if($myGiareReviewThumb->addData())
                    {
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('giarereviewthumb_add', $myGiareReviewThumb->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['giarereviewthumbAddToken']=Helper::getSecurityToken();//Tao token moi

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
		$myGiareReviewThumb = new Core_GiareReviewThumb($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myGiareReviewThumb->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();


			$formData['frobjectid'] = $myGiareReviewThumb->robjectid;
			$formData['frid'] = $myGiareReviewThumb->rid;
			$formData['fuid'] = $myGiareReviewThumb->uid;
			$formData['fid'] = $myGiareReviewThumb->id;
			$formData['fvalue'] = $myGiareReviewThumb->value;
			$formData['fipaddress'] = $myGiareReviewThumb->ipaddress;
			$formData['fdatecreared'] = $myGiareReviewThumb->datecreared;
			$formData['fdatemodified'] = $myGiareReviewThumb->datemodified;

			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['giarereviewthumbEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {

						$myGiareReviewThumb->robjectid = $formData['frobjectid'];
						$myGiareReviewThumb->rid = $formData['frid'];
						$myGiareReviewThumb->uid = $formData['fuid'];
						$myGiareReviewThumb->value = $formData['fvalue'];
						$myGiareReviewThumb->ipaddress = $formData['fipaddress'];
						$myGiareReviewThumb->datecreared = $formData['fdatecreared'];

                        if($myGiareReviewThumb->updateData())
                        {
                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('giarereviewthumb_edit', $myGiareReviewThumb->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }


			}


			$_SESSION['giarereviewthumbEditToken'] = Helper::getSecurityToken();//Tao token moi

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
		$myGiareReviewThumb = new Core_GiareReviewThumb($id);
		if($myGiareReviewThumb->id > 0)
		{
			//tien hanh xoa
			if($myGiareReviewThumb->delete())
			{
				$redirectMsg = str_replace('###id###', $myGiareReviewThumb->id, $this->registry->lang['controller']['succDelete']);

				$this->registry->me->writelog('giarereviewthumb_delete', $myGiareReviewThumb->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myGiareReviewThumb->id, $this->registry->lang['controller']['errDelete']);
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

	public function syncProductReviewThumbAction()
	{
        //get product review thumb
        $giarereviewthumbs = Core_GiareReviewThumb::getValueGiareThumb();

        if(count($giarereviewthumbs) > 0)
        {
            foreach($giarereviewthumbs as $giarereviewthumb)
            {
                //cap nhat thumb cho review
                if($giarereviewthumb->rid > 0)
                {
                    $myGiareReview = new Core_GiareReview($giarereviewthumb->rid);
                    if($myGiareReview->id > 0)
                    {
                        $myGiareReview->countthumbup = $giarereviewthumb->value;
                        if($myGiareReview->updateData())
                            echo 'Review - id : ' . $myProductReview->id . ' update<br />';
                        else
                            echo 'Review - id : ' . $myProductReview->id . ' not update<br />';
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



		if($formData['frobjectid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRobjectidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;



		if($formData['frobjectid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRobjectidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['frid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errRidMustGreaterThanZero'];
			$pass = false;
		}

		if($formData['fuid'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errUidMustGreaterThanZero'];
			$pass = false;
		}

		return $pass;
	}
}

?>