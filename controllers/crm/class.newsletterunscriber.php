<?php

Class Controller_Admin_NewsletterUnscriber Extends Controller_Admin_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());

		$_SESSION['securityToken'] = Helper::getSecurityToken();  //for delete link
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

		$idFilter 		= (int)($this->registry->router->getArg('id'));
		$typeFilter 		= (int)($this->registry->router->getArg('type'));
		$keywordFilter 	= $this->registry->router->getArg('keyword');
		$searchKeywordIn= $this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
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
						$myUnscriber = new Core_Backend_NewsletterUnscriber($id);

						if($myUnscriber->id > 0)
						{
							//tien hanh xoa
							if($myUnscriber->delete())
							{
								$deletedItems[] = $myUnscriber->name;
								$this->registry->me->writelog('newsletterunscriber_delete', $myUnscriber->id, array('email' => $myUnscriber->email));
							}
							else
								$cannotDeletedItems[] = $myUnscriber->email;
						}
						else
							$cannotDeletedItems[] = $myUnscriber->email;
					}

					if(count($deletedItems) > 0)
						$success[] = str_replace('###name###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

					if(count($cannotDeletedItems) > 0)
						$error[] = str_replace('###name###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
				}
				else
				{
					//bulk action not select, show error
					$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
				}
			}
		}


		$paginateUrl = $this->registry->conf['rooturl_admin'].'newsletterunscriber/index/';

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}


		if(strlen($keywordFilter) > 0)
		{

			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'email')
			{
				$paginateUrl .= 'searchin/email/';
			}
			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Backend_NewsletterUnscriber::getUnscribers($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$unscribers = Core_Backend_NewsletterUnscriber::getUnscribers($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'unscribers' 	=> $unscribers,
												'formData'		=> $formData,
												'typeList'		=> Core_Backend_NewsletterUnscriber::getTypeList(),
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

		$this->registry->smarty->assign(array(	'menu'		=> 'newsletterunscriberlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myUnscriber = new Core_Backend_NewsletterUnscriber($id);


		if($myUnscriber->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myUnscriber->delete())
				{
					$redirectMsg = $this->registry->lang['controller']['succDelete'];

					$this->registry->me->writelog('newsletterunscriber_delete', $myUnscriber->id, array('email' => $myUnscriber->email));
				}
				else
				{
					$redirectMsg = $this->registry->lang['controller']['errDelete'];
				}
			}
			else
				$redirectMsg = $this->registry->lang['default']['errFormTokenInvalid'];


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

	function addAction()
    {
        $error     = array();
        $success     = array();
        $contents     = '';
        $formData     = array();

        $formData['ftype'] = Core_Backend_NewsletterUnscriber::TYPE_SESCOMPLAINT;

        if(!empty($_POST['fsubmit']))
        {
        	//kiem tra token
			if($_SESSION['newsletterunscriberAddToken'] == $_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);

				//kiem tra du lieu nhap
				if($this->addActionValidator($formData, $error))
				{
					$myUnscriber = new Core_Backend_NewsletterUnscriber();
					$myUnscriber->email = $formData['femail'];
					$myUnscriber->type = $formData['ftype'];

					if($myUnscriber->addData() > 0)
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('newsletterunscriber_add', $myUnscriber->id, array('email' => $myUnscriber->email));
						$formData = array();
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}
        }

        $_SESSION['newsletterunscriberAddToken'] = Helper::getSecurityToken();  //them token moi


        $this->registry->smarty->assign(array(  'formData'         => $formData,
                                                'redirectUrl'    => $this->getRedirectUrl(),
												'typeList'		=> Core_Backend_NewsletterUnscriber::getTypeList(),
                                                'error'            => $error,
                                                'success'        => $success,

                                                ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

        $this->registry->smarty->assign(array(    'menu'        => 'newsletterunscriberlist',
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_add'],
                                                'contents'     => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    function editAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myUnscriber = new Core_Backend_NewsletterUnscriber($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myUnscriber->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array();

	        $formData['femail'] = $myUnscriber->email;
	        $formData['ftype'] = $myUnscriber->type;


	        if(!empty($_POST['fsubmit']))
	        {
	            if($_SESSION['newsletterunscriberEditToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);

	                if($this->editActionValidator($formData, $error))
	                {
                       	$myUnscriber->email = $formData['femail'];
                       	$myUnscriber->type = $formData['ftype'];

	                    if($myUnscriber->updateData())
	                    {
	                       $success[] = $this->registry->lang['controller']['succEdit'];
	                       $this->registry->me->writelog('newsletterunscriber_edit', $myUnscriber->id, array('email' => $myUnscriber->email));
	                    }
	                    else
	                    {
	                        $error[] = $this->registry->lang['controller']['errEdit'];
	                    }
	                }
	            }
	        }
	        $_SESSION['newsletterunscriberEditToken']=Helper::getSecurityToken();//Tao token moi
	        $this->registry->smarty->assign(array(   'formData'     => $formData,
            										'myUnscriber'	=> $myUnscriber,
													'typeList'		=> Core_Backend_NewsletterUnscriber::getTypeList(),
	                                                'redirectUrl'=> $redirectUrl,
	                                                'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                'error'        => $error,
	                                                'success'    => $success,

	                                                ));
	        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
	        $this->registry->smarty->assign(array(
	                                                'menu'        => 'newsletterunscriberlist',
	                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_edit'],
	                                                'contents'             => $contents));
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


	private function addActionValidator($formData, &$error)
    {
        $pass = true;

        if($formData['femail'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errNameRequired'];
            $pass = false;
		}
		else
		{
			//check existed email
			if(Core_Backend_NewsletterUnscriber::isUnscribe($formData['femail']))
			{
				$error[] = 'Email is already in unscriber list.';
				$pass = false;
			}
		}

        return $pass;
    }

    private function editActionValidator($formData, &$error)
    {
        $pass = true;

      	if($formData['femail'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errNameRequired'];
            $pass = false;
		}

        return $pass;
    }




}
