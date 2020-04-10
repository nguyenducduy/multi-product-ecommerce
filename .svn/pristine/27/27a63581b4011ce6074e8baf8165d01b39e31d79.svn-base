<?php

Class Controller_Crm_Newsletter Extends Controller_Crm_Base
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
		$keywordFilter 	= $this->registry->router->getArg('keyword');
		$searchKeywordIn= $this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'datelastsent';
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
						//check valid user and not admin user
						$myNewsletter = new Core_Backend_Newsletter($id);

						if($myNewsletter->id > 0)
						{
							//tien hanh xoa
							if($myNewsletter->delete())
							{
								$deletedItems[] = $myNewsletter->subject;
								$this->registry->me->writelog('newsletter_delete', $myNewsletter->id, array('subject' => $myNewsletter->subject));
							}
							else
								$cannotDeletedItems[] = $myNewsletter->subject;
						}
						else
							$cannotDeletedItems[] = $myNewsletter->subject;
					}

					if(count($deletedItems) > 0)
						$success[] = str_replace('###subject###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

					if(count($cannotDeletedItems) > 0)
						$error[] = str_replace('###subject###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
				}
				else
				{
					//bulk action not select, show error
					$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
				}
			}
		}


		$paginateUrl = $this->registry->conf['rooturl_admin'].'newsletter/index/';

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}


		if(strlen($keywordFilter) > 0)
		{

			$paginateUrl .= 'keyword/' . $keywordFilter . '/';


			$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
			$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
			$formData['search'] = 'keyword';
		}

		//tim tong so
		$total = Core_Backend_Newsletter::getNewsletters($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$newsletters = Core_Backend_Newsletter::getNewsletters($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'newsletters' 	=> $newsletters,
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

		$this->registry->smarty->assign(array(	'menu'		=> 'newsletterlist',
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}

	public function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myNewsletter = new Core_Backend_Newsletter($id);


		if($myNewsletter->id > 0)
		{
			if(Helper::checkSecurityToken())
			{
				//tien hanh xoa
				if($myNewsletter->delete())
				{
					$redirectMsg = $this->registry->lang['controller']['succDelete'];

					$this->registry->me->writelog('newsletter_delete', $myNewsletter->id, array('subject' => $myNewsletter->subject));
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

        $formData['ffromemail'] = $this->registry->setting['mail']['fromEmail'];
        $formData['ffromname'] = $this->registry->setting['mail']['fromName'];

        //su dung button tao 1 newsletter tu 1 newsletter co san ^^
        $predefineid = (int)$this->registry->router->getArg('id');
        if($predefineid > 0)
        {
        	$myNewsletterTemplate = new Core_Backend_Newsletter($predefineid);
        	if($myNewsletterTemplate->id > 0)
        	{
        		$formData['ffromemail'] = $myNewsletterTemplate->fromemail;
        		$formData['ffromname'] = $myNewsletterTemplate->fromname;
        		$formData['fsubject'] = $myNewsletterTemplate->subject;
        		$formData['fcontents'] = $myNewsletterTemplate->contents;
			}
		}

        if(!empty($_POST['fsubmit']))
        {
        	//kiem tra token
			if($_SESSION['newsletterAddToken'] == $_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);

				//kiem tra du lieu nhap
				if($this->addActionValidator($formData, $error))
				{
					$myNewsletter = new Core_Backend_Newsletter();
					$myNewsletter->uid = $this->registry->me->id;
					$myNewsletter->fromemail = $formData['ffromemail'];
					$myNewsletter->fromname = $formData['ffromname'];
					$myNewsletter->subject = $formData['fsubject'];
					$myNewsletter->contents = $formData['fcontents'];

					if($myNewsletter->addData() > 0)
					{
						$success[] = $this->registry->lang['controller']['succAdd'];
						$this->registry->me->writelog('newsletter_add', $myNewsletter->id, array('subject' => $myNewsletter->subject));
						$formData['fsubject'] = '';
						$formData['fcontents'] = '';
					}
					else
					{
						$error[] = $this->registry->lang['controller']['errAdd'];
					}
				}
			}
        }

        $_SESSION['newsletterAddToken'] = Helper::getSecurityToken();  //them token moi


        $this->registry->smarty->assign(array(  'formData'         => $formData,
                                                'redirectUrl'    => $this->getRedirectUrl(),
                                                'error'            => $error,
                                                'success'        => $success,
                                                ));
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

        $this->registry->smarty->assign(array(    'menu'        => 'newsletterlist',
                                                'pageTitle'    => $this->registry->lang['controller']['pageTitle_add'],
                                                'contents'     => $contents));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
    }

    function editAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myNewsletter = new Core_Backend_Newsletter($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myNewsletter->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array();

	        $formData['ffromemail'] = $myNewsletter->fromemail;
	        $formData['ffromname'] = $myNewsletter->fromname;
	        $formData['fsubject'] = $myNewsletter->subject;
	        $formData['fcontents'] = $myNewsletter->contents;

	        if(!empty($_POST['fsubmit']))
	        {
	            if($_SESSION['newsletterEditToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);

	                if($this->editActionValidator($formData, $error))
	                {
                       	$myNewsletter->uid = $this->registry->me->id;
						$myNewsletter->fromemail = $formData['ffromemail'];
						$myNewsletter->fromname = $formData['ffromname'];
						$myNewsletter->subject = $formData['fsubject'];
						$myNewsletter->contents = $formData['fcontents'];

	                    if($myNewsletter->updateData())
	                    {
	                       $success[] = $this->registry->lang['controller']['succEdit'];
	                       $this->registry->me->writelog('newsletter_edit', $myNewsletter->id, array('subject' => $myNewsletter->subject));
	                    }
	                    else
	                    {
	                        $error[] = $this->registry->lang['controller']['errEdit'];
	                    }
	                }
	            }
	            else
	            {
	            	$error[] = 'Token Error';
				}
	        }
	        $_SESSION['newsletterEditToken'] = Helper::getSecurityToken();//Tao token moi
	        $this->registry->smarty->assign(array(   'formData'     => $formData,
            										'myNewsletter'	=> $myNewsletter,
	                                                'redirectUrl'=> $redirectUrl,
	                                                'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                'error'        => $error,
	                                                'success'    => $success,

	                                                ));
	        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
	        $this->registry->smarty->assign(array(
	                                                'menu'        => 'newsletterlist',
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

    function previewAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myNewsletter = new Core_Backend_Newsletter($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myNewsletter->id > 0)
        {
        	$this->registry->smarty->assign(array(  'mailSubject' => $myNewsletter->subject,
	                                                ));
        	$mailWrapperTop = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'header.tpl');
        	$mailWrapperBottom = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'footer.tpl');
        	$mailContents = $mailWrapperTop . $myNewsletter->contents . $mailWrapperBottom;

	        $this->registry->smarty->assign(array(   'mailContents'     => $mailContents,
            										'myNewsletter'	=> $myNewsletter,

	                                                ));
	        $this->registry->smarty->display($this->registry->smartyControllerContainer.'preview.tpl');

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

    function sendAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myNewsletter = new Core_Backend_Newsletter($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myNewsletter->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array();
	        $formData['maxToEmail'] = 20;	//so email toi da co the goi trong 1 lan, bat ke toemail co nhieu
	        $fetchCount = 0;
	        $toEmailList = array();

	        if(isset($_POST['fquerysubmit']))
	        {

	        	$formData = array_merge($formData, $_POST);
	        	$sql = 'SELECT u_fullname f, up_email e FROM ' . TABLE_PREFIX . 'ac_user u
	        			INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
	        			WHERE '
	        			.Helper::queryFilterString($_POST['fquery']);
	        	try
	        	{
	        		$stmt = $this->registry->db->query($sql);
	        		if($stmt)
	        		{

	        			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        			{
	        				if($fetchCount < $formData['maxToEmail'])
	        				{
	        					$toEmailList[] = $row['f'] . '&lt;'.$row['e'].'&gt;';
	        					$fetchCount++;
							}
							else
							{
								$fetchCount++;
							}
						}
					}
					if(count($toEmailList) > 0)
						$formData['femaillist'] = implode(',', $toEmailList);
				}
				catch(Exception $e)
				{
					$error[] = 'Your Query is not valid. Please check again.' . $sql;;
				}
			}


	        if(!empty($_POST['fsubmit']))
	        {
	            if($_SESSION['newsletterSendToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);
	                if($formData['femaillist'] == '')
	                {
	                	$error[] = 'To Emails is required.';
					}
					else
					{
						$toEmails = explode(',', $formData['femaillist']);
						//refine email
						$finalTo = array();
						for($i = 0; $i < count($toEmails); $i++)
						{
							$emailgroup = trim($toEmails[$i]);
							if($emailgroup != '')
							{
								//parsing email, name
								//with format: fullname<email>
								preg_match('/(.*?)<([^>]*)>/', $emailgroup, $match);
								if(trim($match[2]) != '')
								{
									$finalTo[trim($match[2])] = Helper::codau2khongdau(trim($match[1]), false, false);
								}
							}
						}

						//tien hanh goi email
						if(count($finalTo) > 0)
						{
							$this->registry->smarty->assign(array('myNewsletter'	=> $myNewsletter));
							$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'newsletter/user.tpl');
							$sender=  new SendMail($this->registry,
													'',
													'',
													$myNewsletter->subject,
													$mailContents,
													$myNewsletter->fromemail,
													$myNewsletter->fromname
													);
							$sender->toArray = $finalTo;
							if($sender->Send())
							{
								$success[] = 'Sending emails successfully';
								$myNewsletter->increaseSend();
								$myNewsletter->uid = $this->registry->me->id;
								$myNewsletter->updateLastSentUser();
							}
							else
							{
								$error[] = 'Error while sending email.';
							}
						}
					}
	            }
	            else
	            {
	            	$error[] = 'Token Error';
				}
	        }
	        $_SESSION['newsletterSendToken'] = Helper::getSecurityToken();//Tao token moi
	        $this->registry->smarty->assign(array(   'formData'     => $formData,
	        										'toEmailListCount' => $fetchCount,
            										'myNewsletter'	=> $myNewsletter,
	                                                'redirectUrl'=> $redirectUrl,
	                                                'encoderedirectUrl'=> base64_encode($redirectUrl),
	                                                'error'        => $error,
	                                                'success'    => $success,

	                                                ));
	        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'send.tpl');
	        $this->registry->smarty->assign(array(
	                                                'menu'        => 'newsletterlist',
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

	function sendtaskAction()
    {
    	set_time_limit(1000);

        $id = (int)$this->registry->router->getArg('id');
        $myNewsletter = new Core_Backend_Newsletter($id);
        $redirectUrl = $this->getRedirectUrl();
        if($myNewsletter->id > 0)
        {
            $error         = array();
	        $success     = array();
	        $contents     = '';
	        $formData     = array('fbulkid' => array());
	        $fetchCount = 0;
	        $toEmailList = array();

	        if(isset($_POST['fquerysubmit']))
	        {

	        	$formData = array_merge($formData, $_POST);
	        	$sql = 'SELECT u.u_id id, u_fullname fullname, up_email email FROM ' . TABLE_PREFIX . 'ac_user u
	        			INNER JOIN ' . TABLE_PREFIX . 'ac_user_profile up ON u.u_id = up.u_id
	        			WHERE '
	        			.Helper::queryFilterString($_POST['fquery']);
	        	try
	        	{
	        		$newmailAdd = 0;
	        		$stmt = $this->registry->db->query($sql);
	        		if($stmt)
	        		{
	        			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	        			{
	        				if($row['email'] != '')
	        				{
	        					//kiem tra xem email da co chua
	        					$newslettertasklist = Core_Backend_NewsletterTask::getTasks(array('femail' => $row['email'], 'fnewsletterid' => $myNewsletter->id), '', '', '');
	        					if(count($newslettertasklist) == 0)
	        					{
	        						$myNewsletterTask = new Core_Backend_NewsletterTask();
	        						$myNewsletterTask->nid = $myNewsletter->id;
	        						$myNewsletterTask->toname = $row['fullname'];
	        						$myNewsletterTask->toemail = $row['email'];
	        						$myNewsletterTask->touserid = $row['id'];
	        						if(!$myNewsletterTask->addData())
	        						{
	        							$error[] = 'Can not add task for email: ' . $row['email'];
									}
									else
										$newmailAdd++;
								}
								else
								{
									$existedemail[] = $row['email'];

									if($myNewsletterTask->touserid == 0)
									{
										$myNewsletterTask = $newslettertasklist[0];
	        							$myNewsletterTask->toname = $row['fullname'];
	        							$myNewsletterTask->touserid = $row['id'];
	        							$myNewsletterTask->updateData();
	        							$success[] = 'Update userid for email ' . $myNewsletterTask->toemail;
									}

								}
							}

						}


						if(count($existedemail) > 0)
						{
							$warning[] = 'Existed emails: ' . implode(', ', $existedemail);
						}
					}
				}
				catch(Exception $e)
				{
					$error[] = $e->getMessage() . '. <br />' . $sql;
				}
			}

			if(!empty($_POST['fsubmitadd']))
			{
				$ffullname = $_POST['ffullname'];
				$femail = $_POST['femail'];
				$fuserid = (int)$_POST['fuserid'];

				if($ffullname != '' && $femail != '')
				{
					//kiem tra xem email da co chua
					$newslettertasklist = Core_Backend_NewsletterTask::getTasks(array('femail' => $femail, 'fnewsletterid' => $myNewsletter->id), '', '', '');
	        		if(count($newslettertasklist) == 0)
	        		{
	        			$myNewsletterTask = new Core_Backend_NewsletterTask();
	        			$myNewsletterTask->nid = $myNewsletter->id;
	        			$myNewsletterTask->toname = $ffullname;
	        			$myNewsletterTask->toemail = $femail;
	        			$myNewsletterTask->touserid = $fuserid;
	        			if(!$myNewsletterTask->addData())
	        			{
	        				$error[] = 'Can not add task for email: ' . $femail;
						}
					}
					else
					{
						$existedemail[] = $row['email'];
					}
				}
				else
				{
					$error[] = 'Fullname and Email is required';
				}

			}


			//truy van de lay cac task email
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;

			$idFilter 		= (int)($this->registry->router->getArg('taskid'));
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
							//check valid user and not admin user
							$myNewsletterTask = new Core_Backend_NewsletterTask($id);

							if($myNewsletterTask->id > 0)
							{
								//tien hanh xoa
								if($myNewsletterTask->delete())
								{
									$deletedItems[] = $myNewsletterTask->toemail;
									$this->registry->me->writelog('newslettertask_delete', $myNewsletterTask->id, array('toemail' => $myNewsletterTask->toemail));
								}
								else
									$cannotDeletedItems[] = $myNewsletterTask->toemail;
							}
							else
								$cannotDeletedItems[] = $myNewsletterTask->toemail;
						}

						if(count($deletedItems) > 0)
							$success[] = str_replace('###email###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

						if(count($cannotDeletedItems) > 0)
							$error[] = str_replace('###email###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
					}
					elseif($_POST['fbulkaction'] == 'reset' || $_POST['fbulkaction'] == 'settosent')
					{
						$updateArr = $_POST['fbulkid'];
						$updatedItems = array();
						foreach($updateArr as $id)
						{
							//check valid user and not admin user
							$myNewsletterTask = new Core_Backend_NewsletterTask($id);

							if($myNewsletterTask->id > 0)
							{
								//tien hanh update
								if($_POST['fbulkaction'] == 'reset')
									$myNewsletterTask->issent = 0;
								elseif($_POST['fbulkaction'] == 'settosent')
									$myNewsletterTask->issent = 1;
								if($myNewsletterTask->updateData())
								{
									$updatedItems[] = $myNewsletterTask->id;
								}
							}
						}

						if(count($updatedItems) > 0)
							$success[] = $this->registry->lang['controller']['succEdit'];

					}
					elseif($_POST['fbulkaction'] == 'send')
					{
						//luu thong tin vao session de tien hanh goi email
						$startsender = 1;
						$_SESSION['newslettertask'][$myNewsletter->id] = array('tasklist' => $_POST['fbulkid'], 'type' => 'selected');
					}
					else
					{
						//bulk action not select, show error
						$warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
					}
				}
			}

			/**
			* Xoa toan bo task list
			*/
			if(!empty($_POST['fsubmitdeleteall']))
			{
				$deletecount = Core_Backend_NewsletterTask::deleteFromNewsletter($myNewsletter->id);
				$success[] = 'Delete all '.$deletecount.' record(s).';
			}

			/**
			* RESET all task list t0 NOT SENT
			*/
			if(!empty($_POST['fsubmitresetall']))
			{
				$deletecount = Core_Backend_NewsletterTask::setSentStatusFromNewsletter($myNewsletter->id, 0);
				$success[] = 'UPDATE all '.$deletecount.' record(s) to UN-SENT.';
			}

			/**
			* MARK all task list t0 SENT
			*/
			if(!empty($_POST['fsubmitsettosentall']))
			{
				$deletecount = Core_Backend_NewsletterTask::setSentStatusFromNewsletter($myNewsletter->id, 1);
				$success[] = 'MARKED all '.$deletecount.' record(s) to SENT.';
			}

			/**
			* SEND email to ALL
			*/
			if(!empty($_POST['fsubmitsendall']))
			{
				$startsender = 1;
				$_SESSION['newslettertask'][$myNewsletter->id] = array('type' => 'all');
			}

			$paginateUrl = $this->registry->conf['rooturl_admin'].'newsletter/sendtask/id/'.$myNewsletter->id.'/';
			$formData['fnewsletterid'] = $myNewsletter->id;

			if($idFilter > 0)
			{
				$paginateUrl .= 'taskid/'.$idFilter . '/';
				$formData['fid'] = $idFilter;
				$formData['search'] = 'id';
			}


			if(strlen($keywordFilter) > 0)
			{

				$paginateUrl .= 'keyword/' . $keywordFilter . '/';


				$formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
				$formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
				$formData['search'] = 'keyword';
			}

			//tim tong so
			if(isset($_GET['n']))
				$this->recordPerPage = (int)$_GET['n'];
			else
				$this->recordPerPage = 100;

			$total = Core_Backend_NewsletterTask::getTasks($formData, $sortby, $sorttype, 0, true);
			$totalPage = ceil($total/$this->recordPerPage);
			$curPage = $page;


			//get latest account
			$newsletterTasks = Core_Backend_NewsletterTask::getTasks($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);


			//filter for sortby & sorttype
			$filterUrl = $paginateUrl;

			//append sort to paginate url
			$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

	        if(!empty($_POST['fsubmit']))
	        {
	             $formData = array_merge($formData, $_POST);
	            if($formData['femaillist'] == '')
	            {
	                $error[] = 'To Emails is required.';
				}
				else
				{
					$toEmails = explode(',', $formData['femaillist']);
					//refine email
					$finalTo = array();
					for($i = 0; $i < count($toEmails); $i++)
					{
						$emailgroup = trim($toEmails[$i]);
						if($emailgroup != '')
						{
							//parsing email, name
							//with format: fullname<email>
							preg_match('/(.*?)<([^>]*)>/', $emailgroup, $match);
							if(trim($match[2]) != '')
							{
								$finalTo[trim($match[2])] = Helper::codau2khongdau(trim($match[1]), false, false);
							}
						}
					}

					//tien hanh goi email
					if(count($finalTo) > 0)
					{
						$this->registry->smarty->assign(array('myNewsletter'	=> $myNewsletter));
						$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'newsletter/user.tpl');
						$sender=  new SendMail($this->registry,
												'',
												'',
												$myNewsletter->subject,
												$mailContents,
												$myNewsletter->fromemail,
												$myNewsletter->fromname
												);
						$sender->toArray = $finalTo;
						if($sender->Send())
						{
							$success[] = 'Sending emails successfully';
							$myNewsletter->increaseSend();
							$myNewsletter->uid = $this->registry->me->id;
							$myNewsletter->updateLastSentUser();
						}
						else
						{
							$error[] = 'Error while sending email.';
						}
					}
				}
	        }

	        $this->registry->smarty->assign(array(   'formData'     => $formData,
	        										'startsender' => $startsender,
	        										'toEmailListCount' => $fetchCount,
	        										'newsletterTasks' => $newsletterTasks,
            										'myNewsletter'	=> $myNewsletter,
	                                                'error'        => $error,
	                                                'success'    => $success,
	                                                'warning'    => $warning,
	                                                'paginateurl' 	=> $paginateUrl,
	                                                'filterUrl' 	=> $filterUrl,
													'redirectUrl'	=> $redirectUrl,
													'total'			=> $total,
													'totalPage' 	=> $totalPage,
													'curPage'		=> $curPage,
	                                                ));
	        $contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'sendtask.tpl');
	        $this->registry->smarty->assign(array(
	                                                'menu'        => 'newsletterlist',
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

    function senderAction()
    {
        $id = (int)$this->registry->router->getArg('id');
        $myNewsletter = new Core_Backend_Newsletter($id);
        if($myNewsletter->id > 0)
        {
        	if(isset($_SESSION['newslettertask'][$myNewsletter->id]))
        	{
        		//mail contents
        		$this->registry->smarty->assign(array(  'mailSubject' => $myNewsletter->subject));
        		$mailWrapperTop = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'header.tpl');
        		$mailWrapperBottom = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'footer.tpl');
        		$mailContents = $mailWrapperTop . $myNewsletter->contents . $mailWrapperBottom;

        		$emailstat['sendtype'] = '';
        		$emailstat['length'] = strlen($mailContents);
        		$emailstat['segmentsize'] = 30;

        		//neu chon send mail cho 1 so record da chon
				if($_SESSION['newslettertask'][$myNewsletter->id]['type'] == 'selected')
				{
					$emailstat['sendtype'] = 'group';
					$emailstat['total'] = count($_SESSION['newslettertask'][$myNewsletter->id]['tasklist']);
					$emailstat['total_unsent'] = Core_Backend_NewsletterTask::getTasks(array('fidlist' => $_SESSION['newslettertask'][$myNewsletter->id]['tasklist'], 'fissent' => 0), '', '', '', true);
				}
				else //send mail cho tat ca record trong newsletter
				{
					$emailstat['sendtype'] = 'all';
					$emailstat['total'] = Core_Backend_NewsletterTask::getTasks(array('fnewsletterid' => $myNewsletter->id), '', '', '', true);
					$emailstat['total_unsent'] = Core_Backend_NewsletterTask::getTasks(array('fnewsletterid' => $myNewsletter->id, 'fissent' => 0), '', '', '', true);
				}

				//send to all sent and unsent task
				$emailstat['lengthtotal'] = $emailstat['total'] * $emailstat['length'];
        		$emailstat['lengthtotalInMB'] = round($emailstat['lengthtotal'] / (1024 * 1024), 2);
        		$emailstat['segmentestimate'] = ceil($emailstat['total'] / $emailstat['segmentsize']);

        		//just unsent task
        		$emailstat['lengthtotal_unsent'] = $emailstat['total_unsent'] * $emailstat['length'];
        		$emailstat['lengthtotalInMB_unsent'] = round($emailstat['lengthtotal_unsent'] / (1024 * 1024), 2);
        		$emailstat['segmentestimate_unsent'] = ceil($emailstat['total_unsent'] / $emailstat['segmentsize']);


        		//submit cac thong tin setting truoc khi send
        		if(isset($_POST['fsubmit']))
        		{
        			$formData = $_POST;
        			//so email se goi cho moi lan refresh
        			if($formData['fgrouptype'] == '2')
        				$listSegment = $formData['fsegmentsize'];
        			else
        				$listSegment = 1;

					//init cac thong tin can thiet de truoc khi run viec send email
					$_SESSION['newslettertask'][$myNewsletter->id]['start'] = time();
        			$_SESSION['newslettertask'][$myNewsletter->id]['segmentsize'] = $listSegment;
        			$_SESSION['newslettertask'][$myNewsletter->id]['sendtype'] = $emailstat['sendtype'];
        			$_SESSION['newslettertask'][$myNewsletter->id]['limitrecord'] = $formData['flimitrecord'];
        			$_SESSION['newslettertask'][$myNewsletter->id]['total'] = $formData['flimitrecord'] == 'all'?$emailstat['total']:$emailstat['total_unsent'];
        			$_SESSION['newslettertask'][$myNewsletter->id]['sendcount'] = 0;

				}


				//tien hanh nhan request/refresh page de xu ly viec send email
				if($_SESSION['newslettertask'][$myNewsletter->id]['start'] > 0)
				{
					if(!isset($_GET['start']))
						$startposition = 0;
					else
						$startposition = (int)$_GET['start'];

					//check xem da hoan tat chua
					if($startposition == $_SESSION['newslettertask'][$myNewsletter->id]['total'])
					{
						$_SESSION['newslettertask'][$myNewsletter->id]['isfinish'] = 1;
					}
					else
					{
						//fix bug, neu chon sent cac unsent task thi se bi bo record vi cac record da sent cung dc tinh nen bi hole
						//do do , chi su dung offset neu chon send cho toan bo danh sach ma khong quan tam den thong to issent
						if($_SESSION['newslettertask'][$myNewsletter->id]['limitrecord'] == 'all')
						{
							//offset de truy van database cac task can thiet
							$limitstring = $startposition . ',' . $_SESSION['newslettertask'][$myNewsletter->id]['segmentsize'];
						}
						else
						{
							//boi vi chon sent cho unsent, nen cu laytu dau va lay limit segment
							$limitstring = $_SESSION['newslettertask'][$myNewsletter->id]['segmentsize'];
						}


						//lay cac task bat bau tu vi tri start
						if($_SESSION['newslettertask'][$myNewsletter->id]['sendtype'] == 'all')
						{
							//neu send cho tat ca, tuc la ko co task list, thi tien hanh query database, su dung startposition de lam offset
							if($_SESSION['newslettertask'][$myNewsletter->id]['limitrecord'] == 'all')
								$tasks = Core_Backend_NewsletterTask::getTasks(array('fnewsletterid' => $myNewsletter->id), 'id', 'ASC', $limitstring);
							else
								$tasks = Core_Backend_NewsletterTask::getTasks(array('fnewsletterid' => $myNewsletter->id, 'fissent' => 0), 'id', 'ASC', $limitstring);
						}
						else
						{
							//neu send cho danh sach da chon, thi lay tat ca cac task tu tasklist id, sau do thao tac tren array de lay cac phan tu tuong ung
							if($_SESSION['newslettertask'][$myNewsletter->id]['limitrecord'] == 'all')
								$tasks = Core_Backend_NewsletterTask::getTasks(array('fidlist' => $_SESSION['newslettertask'][$myNewsletter->id]['tasklist'],'fnewsletterid' => $myNewsletter->id), 'id', 'ASC', $limitstring);
							else
								$tasks = Core_Backend_NewsletterTask::getTasks(array('fidlist' => $_SESSION['newslettertask'][$myNewsletter->id]['tasklist'],'fnewsletterid' => $myNewsletter->id, 'fissent' => 0), 'id', 'ASC', $limitstring);
						}

						if(count($tasks) > 0)
						{
							//position cua lan refresh ke tiep
							$nextStartposition = $startposition + count($tasks);

							//array chua email se goi di
							//co dang array('email' => 'fullname', 'email' => 'fullname'...)
							$finalTo = array();

							$currentToEmail = '';
							//prepare emaillist
							foreach($tasks as $mailtask)
							{
								if(!Core_Backend_NewsletterUnscriber::isUnscribe($mailtask->toemail))
								{
									$toname = $mailtask->toname;
									$toname = ucwords(Helper::codau2khongdau($toname));

									//trademark character will error when sending
									//so convert to htmlentity before sending
									$toname = htmlentities($toname);

									$finalTo[$mailtask->toemail] = $toname;
									if($currentToEmail == '')
									{
										$currentToEmail = $mailtask->toname . '&lt;' . $mailtask->toemail . '&gt;';
									}
								}
							}

							if(count($tasks) > 1)
							{

								$currentToEmail .= ' and ' . (count($tasks) - 1) . ' user';
								if(count($tasks) - 1 > 1)
									$currentToEmail .= 's';
							}
							$_SESSION['newslettertask'][$myNewsletter->id]['currentToEmail'] = $currentToEmail;

							//send only one email/request
							$sender=  new SendMail($this->registry,
													'',
													'',
													$myNewsletter->subject,
													$mailContents,
													$myNewsletter->fromemail,
													$myNewsletter->fromname
													);
							$sender->toArray = $finalTo;

							//tracking thoi gian goi email
							$senderTimer = new timer();
							$senderTimer->start();

							//kiem tra neu da unscribe thi khong send

							try
							{
								if($sender->Send())
								{
									$sendSuccess = 1;
								}
								else
								{
									$sendSuccess = 0;
								}
							}
							catch(Exception $e)
							{
								echo 'Can not send to ' . $sender->toArray;
							}

							$senderTimer->start();
							$senderTimeprocess = $senderTimer->get_exec_time();

							//update newsletter task
							foreach($tasks as $mailtask)
							{
								$mailtask->issent = 1;
								$mailtask->issentsuccess = $sendSuccess;
								$mailtask->sendcount++;
								$mailtask->datelastsent = time();
								$mailtask->updateData();

								//save to log
								$mySendlog = new Core_EmailSendLog();
								$mySendlog->toname = $mailtask->toname;
								$mySendlog->toemail = $mailtask->toemail;
								$mySendlog->emaillength = $emailstat['length'];
								$mySendlog->emailtype = Core_EmailSendLog::TYPE_NEWSLETTER;
								$mySendlog->emailengine = Core_EmailSendLog::ENGINE_AMAZONSES;
								$mySendlog->timeprocess = $senderTimeprocess;
								$mySendlog->issentsuccess = $sendSuccess;
								$mySendlog->addData();
							}

							$_SESSION['newslettertask'][$myNewsletter->id]['sendcount'] += count($tasks);
							$_SESSION['newslettertask'][$myNewsletter->id]['sendprocess'] = round($_SESSION['newslettertask'][$myNewsletter->id]['sendcount'] * 100 / $_SESSION['newslettertask'][$myNewsletter->id]['total'],0);
							if($_SESSION['newslettertask'][$myNewsletter->id]['sendcount'] == $_SESSION['newslettertask'][$myNewsletter->id]['total'])
								$_SESSION['newslettertask'][$myNewsletter->id]['isfinish'] = 1;



							//test, xuat ra thu xem co dung la cac record se send email khong
							//echo '<table>';
							//foreach($tasks as $task)
							//	echo '<tr><td>'.$task->id.'</td><td>'.$task->toname.'</td><td>'.$task->toemail.'</td><td>'.$task->issent.'</td></tr>';
							//echo '</table>';
						}
						else
						{
							//khong tim thay task nao nua, tien hanh bat co hoant tat
							$_SESSION['newslettertask'][$myNewsletter->id]['isfinish'] = 1;
						}

					}
				}

				if($_SESSION['newslettertask'][$myNewsletter->id]['isfinish'] == 1)
				{
					$_SESSION['newslettertask'][$myNewsletter->id]['totaltime'] = time() - $_SESSION['newslettertask'][$myNewsletter->id]['start'];
				}


		        $this->registry->smarty->assign(array(   'formData'     => $formData,
            											'myNewsletter'	=> $myNewsletter,
            											'emailstat' => $emailstat,
            											'sessionTask' => $_SESSION['newslettertask'][$myNewsletter->id],
            											'nextStartposition' => $nextStartposition,
            											'tasks' => $tasks
		                                                ));
	    		$this->registry->smarty->display($this->registry->smartyControllerContainer.'sender.tpl');
			}
			else
			{
				echo 'Invalid sending session.';
			}



        }
        else
        {
            echo 'Not Found';
        }
    }
	####################################################################################################
	####################################################################################################
	####################################################################################################


	private function addActionValidator($formData, &$error)
    {
        $pass = true;

        if($formData['fsubject'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errSubjectRequired'];
            $pass = false;
		}

        return $pass;
    }

    private function editActionValidator($formData, &$error)
    {
        $pass = true;

      	if($formData['fsubject'] == '')
        {
        	$error[] = $this->registry->lang['controller']['errSubjectRequired'];
            $pass = false;
		}

        return $pass;
    }




}
