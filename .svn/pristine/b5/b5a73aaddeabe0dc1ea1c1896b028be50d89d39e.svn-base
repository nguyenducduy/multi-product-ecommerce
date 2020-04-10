<?php

Class Controller_Profile_Message Extends Controller_Profile_Base
{
	/**
	* User Inbox Message
	*
	*/
	function indexAction()
	{
		$formData = array('fbulkid' => array());

		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message

		//sent
		$mailbox = isset($_GET['mailbox'])?$_GET['mailbox']:'inbox';



		if($mailbox == 'sent')
		{
			$formData['fuidfrom'] = $this->registry->me->id;
		}
		elseif($mailbox == 'inbox' || $mailbox == 'inspam' || $mailbox == 'isstarred' || $mailbox == 'intrash' || $mailbox == 'infolder')
		{
			$messageToList = array($this->registry->me->id);

			$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections(false));
			$formData['fuseridlist'] = $messageToList;

			if($mailbox == 'inbox')
				$formData['fisinbox'] = 1;
			elseif($mailbox == 'isstarred')
				$formData['fisstarred'] = 1;
			elseif($mailbox == 'intrash')
				$formData['fisintrash'] = 1;
			elseif($mailbox == 'infolder')
				$formData['fisinfolder'] = (int)$_GET['folderid'];
		}

		if($_GET['fkeyword'] != '')
		{
			$formData['fkeywordFilter'] = $_GET['fkeyword'];
		}

		$page = (int)$this->registry->router->getArg('page');
		$page = $page > 0 ? $page : 1;

		//tim tong so record
		$total = Core_Backend_Message::getMessages($formData, '', '', '', true);
		$totalPage = ceil($total/$this->registry->setting['message']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->conf['rooturl_profile'].'message/index/';


		$messageList = Core_Backend_Message::getMessages($formData, 'datemodified', 'DESC', (($page - 1)*$this->registry->setting['message']['recordPerPage']).','.$this->registry->setting['message']['recordPerPage']);

		//2 flags to check message status of current user
		$messagetextIdMin = 0;
		$messagetextIdMax = 0;
		for($i = 0; $i < count($messageList); $i++)
		{
			if($i == 0) $messagetextIdMax = $messageList[$i]->mtid;
			if($i == (count($messageList) - 1)) $messagetextIdMin = $messageList[$i]->mtid;

			//lay thong tin cua cac user lien quan den message
			$messageList[$i]->actor = Core_User::cacheGet($messageList[$i]->uidfrom);

			$messageList[$i]->recipientList = array();

			$recipientIdList = $messageList[$i]->recipients;
			for($j = 0; $j < count($recipientIdList); $j++)
			{
				$recipientId = $recipientIdList[$j];
				$myUser = new Core_User($recipientId, true);	//use cache here

				if($myUser->id > 0)
					$messageList[$i]->recipientList[] = $myUser;
			}


		}



		//have message to check read status (also star status)
		$myStarredIdList = array();
		$myReadIdList = array();
		if($messagetextIdMin > 0 && $messagetextIdMax > 0)
		{
			$messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id , 'fmtidstart' => $messagetextIdMin, 'fmtidend' => $messagetextIdMax), '', '', '');


			for($i = 0; $i < count($messagetextstatusList); $i++)
			{
				if($messagetextstatusList[$i]->isstarred == 1)
					$myStarredIdList[] = $messagetextstatusList[$i]->mtid;

				if($messagetextstatusList[$i]->isread == 1)
					$myReadIdList[] = $messagetextstatusList[$i]->mtid;
			}

		}


		//reset notification counting
		if($this->registry->me->newmessage > 0)
		{
			$this->registry->me->notificationReset('message');
			$this->registry->me->newmessage = 0;
		}

		$this->registry->smarty->assign(array('messageList' => $messageList,
											'myStarredIdList' => $myStarredIdList,
											'myReadIdList' 	=> $myReadIdList,
											'paginateurl' 	=> $paginateUrl,
											'paginatesuffix' 	=> $paginateSuffix,
											'mailbox'		=> $mailbox,
											'total'			=> $total,
											'totalPage' 	=> $totalPage,
											'curPage'		=> $curPage,
											'formData'		=> $formData,
											));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');


		//SEO PREPARE
		$pageTitle = $this->registry->myUser->fullname . $this->registry->lang['controller']['pageTitle'];;
		$pageKeyword = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
		$pageDescription = $this->registry->myUser->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];

		if($curPage > 1)
		{
			$pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
			$pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
			$pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
		}

		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}


	/**
	* Xem chi tiet 1 message
	*
	*/
	function detailajaxAction()
	{
		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections(false));


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];


		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			$mySender = new Core_User($messageList[0]->uidfrom, true);


			//khong the lay danh sach recipients dua theo cach list dc boi vi da filter list uidto dua tren list cua user hien tai ma thoi
			//de lay duoc danh sach recipients (day du, ke ca goi cho nguoi khac)
			//can phai request lai de lay danh sach recipients id
			$fullRecipientList = $myMessage->getFullRecipients();

			//mark read this message
			//lay trang thai
			$messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
			if(count($messagetextstatusList) > 0)
			{
				$myMessageTextStatus = $messagetextstatusList[0];
				if($myMessageTextStatus->isread == 0)
				{
					$myMessageTextStatus->isread = 1;
					$myMessageTextStatus->updateData();
				}
			}
			else
			{
				$myMessageTextStatus = new Core_Backend_MessageTextStatus();
				$myMessageTextStatus->isread = 1;
				$myMessageTextStatus->uid = $this->registry->me->id;
				$myMessageTextStatus->mtid = $myMessageText->id;
				$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
				$myMessageTextStatus->addData();
			}

			//Get attachment
			$attachmentList = array();
			if($myMessage->countfile > 0)
			{
				$relMessageTextFileDriveList = Core_Backend_RelMessageTextFiledrive::getRelMessageTextFiledrives(array('fmtid' => $myMessageText->id), 'id', 'DESC', '');
				if(count($relMessageTextFileDriveList) > 0)
				{
					for($i = 0; $i < count($relMessageTextFileDriveList); $i++)
					{
						$attachment = $relMessageTextFileDriveList[$i];
						$attachment->filedrive = new Core_Backend_FileDrive($attachment->fdid, true);
						if($attachment->filedrive->id > 0)
						{
							$attachmentList[$attachment->filedrive->id] = $attachment;
						}
					}
				}
			}

			$_SESSION['messagedeleteToken'] = Helper::getSecurityToken();
			$this->registry->smarty->assign(array(
				'mySender' => $mySender,
				'fullRecipientList' => $fullRecipientList,
				'attachmentList' => $attachmentList,
			));


		}


		$this->registry->smarty->assign(array('myMessage' => $myMessage,
												'myMessageText' => $myMessageText,
												));

		$this->registry->smarty->display($this->registry->smartyControllerContainer.'detailajax.tpl');


	}



	/**
	* Download 1 attachment
	*
	*/
	function attachmentdownloadAction()
	{
		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);

		$filedriveid = (int)$_GET['fdid'];


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections(false));


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];


		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			$mySender = new Core_User($messageList[0]->uidfrom, true);


			//Get attachment
			$attachmentList = array();
			if($myMessage->countfile > 0)
			{
				$relMessageTextFileDriveList = Core_Backend_RelMessageTextFiledrive::getRelMessageTextFiledrives(array('fmtid' => $myMessageText->id), 'id', 'DESC', '');
				if(count($relMessageTextFileDriveList) > 0)
				{
					for($i = 0; $i < count($relMessageTextFileDriveList); $i++)
					{
						$attachment = $relMessageTextFileDriveList[$i];
						$attachment->filedrive = new Core_Backend_FileDrive($attachment->fdid, true);
						if($attachment->filedrive->id > 0)
						{
							$attachmentList[$attachment->filedrive->id] = $attachment;
						}
					}
				}
			}

			//Download 1 attachment
			if($filedriveid > 0)
			{
				if(isset($attachmentList[$filedriveid]))
				{
					$myFileDrive = $attachmentList[$filedriveid]->filedrive;

					if($myFileDrive->status != Core_Backend_FileDrive::STATUS_DISABLE)
					{
						//Everything OK, now, get the source filepath and readfile to download with hide url method
						$sourcepath = $this->registry->setting['filecloud']['fileDirectory'] . $myFileDrive->filepath;

						$myHttpDownloader = new HttpDownload();
						$myHttpDownloader->filename = $attachmentList[$filedriveid]->name;
					 	$myHttpDownloader->set_byfile($sourcepath); //Download from a file
					 	$myHttpDownloader->use_resume = true; //Enable Resume Mode
					 	$myHttpDownloader->download(); //Download File

						//Increase download
						if($myHttpDownloader->seek_start == 0)
						{
							$myFileDownload = new Core_Backend_FileDownload();
							$myFileDownload->uid = $this->registry->me->id;
							$myFileDownload->fid = $myFileDrive->id;
							$myFileDownload->type = Core_Backend_FileDownload::TYPE_ATTACHMENTDOWNLOAD;
							$myFileDownload->addData();
						}
					}
					else
						$this->notfound();
				}
				else
				{
					$this->notfound();
				}
			}
			else
			{
				//Download All Attachment to a Zip file
				//Not implementation.
			}


		}
		else
			$this->notfound();


	}



	/**
	* Toggle trang thai starred cua 1 message
	*
	*/
	function starredtoggleajaxAction()
	{
		$success = 0;
		$message = '';


		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];


		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			//lay trang thai
			$messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
			if(count($messagetextstatusList) > 0)
			{
				$myMessageTextStatus = $messagetextstatusList[0];
				if($myMessageTextStatus->isstarred == 0)
					$myMessageTextStatus->isstarred = 1;
				else
					$myMessageTextStatus->isstarred = 0;
				$success = $myMessageTextStatus->updateData() ? 1 : 0;
			}
			else
			{
				$myMessageTextStatus = new Core_Backend_MessageTextStatus();
				$myMessageTextStatus->isstarred = 1;
				$myMessageTextStatus->uid = $this->registry->me->id;
				$myMessageTextStatus->mtid = $myMessageText->id;
				$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
				$success = $myMessageTextStatus->addData() ? 1 : 0;
			}
		}


		if($success)
			$message = $this->registry->lang['controller']['succToggleStarred'];
		else
			$message = $this->registry->lang['controller']['errToggleStarred'];

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';


	}



	/**
	* Toggle trang thai starred cua 1 message
	*
	*/
	function trashtoggleajaxAction()
	{
		$success = 0;
		$message = '';


		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];


		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			//lay trang thai
			$messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
			if(count($messagetextstatusList) > 0)
			{
				$myMessageTextStatus = $messagetextstatusList[0];
				if($myMessageTextStatus->checkStatusName('intrash'))
					$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
				else
					$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
				$success = $myMessageTextStatus->updateData() ? 1 : 0;
			}
			else
			{
				$myMessageTextStatus = new Core_Backend_MessageTextStatus();
				$myMessageTextStatus->uid = $this->registry->me->id;
				$myMessageTextStatus->mtid = $myMessageText->id;
				$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
				$success = $myMessageTextStatus->addData() ? 1 : 0;
			}
		}


		if($success)
			$message = $this->registry->lang['controller']['succToggleTrash'];
		else
			$message = $this->registry->lang['controller']['errToggleTrash'];

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';


	}


	/**
	* Toggle trang thai starred cua 1 message
	*
	*/
	function deleteajaxAction()
	{
		$success = 0;
		$message = '';


		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];


		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			//lay trang thai
			$messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
			if(count($messagetextstatusList) > 0)
			{
				$myMessageTextStatus = $messagetextstatusList[0];
				if($myMessageTextStatus->checkStatusName('intrash'))
					$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_DELETED;
				else
					$myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
				$success = $myMessageTextStatus->updateData() ? 1 : 0;
			}
		}


		if($success)
			$message = $this->registry->lang['controller']['succDelete'];
		else
			$message = $this->registry->lang['controller']['errDelete'];

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';


	}


	/**
	* Xoa khoi danh sach sent boi sender
	*
	*/
	function senderdeleteajaxAction()
	{
		$success = 0;
		$message = '';


		$messagetextid = (int)$_GET['mtid'];
		$myMessageText = new Core_Backend_MessageText($messagetextid);


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());


		//find message of current user and mtid
		$formData = array('fuidfrom' => $this->registry->me->id, 'fmtid' => $myMessageText->id);
		$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
		$myMessage = $messageList[0];

		//kiem tra message hop le
		if($myMessage->id > 0 && $myMessageText->id > 0)
		{
			if($myMessage->uidfrom == $this->registry->me->id)
			{
				$success = Core_Backend_Message::markSenderDeleted($myMessage->mtid, $this->registry->me->id) > 0 ? 1: 0;
			}
		}


		if($success)
			$message = $this->registry->lang['controller']['succDelete'];
		else
			$message = $this->registry->lang['controller']['errDelete'];

		header ("content-type: text/xml");
		echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';


	}


	/**
	* Goi message to 1 hoac 1 group member
	*
	*/
	function addAction()
	{

		/**
		* Tien hanh xu ly
		*/

		if(!empty($_POST))
		{
			$formData = $_POST;

			$success = 0;
			$message = '';
			$failedAttachmentMessage = '';
			$failedAttachedFilenameList = array();

			if($this->addajaxvalidator($formData, $error))
			{
				$formData['fsubject'] = Helper::xss_clean($formData['fsubject']);
				$formData['fmessage'] = Helper::xss_clean($formData['fmessage']);

				//refine recipientlist
				$invalidRecipientId = 0;
				$recipientList = array();
				$recipientListEmail = array();

				$myUser = new Core_User();
				foreach($formData['fto'] as $recipientId)
				{
					$myUser = new Core_User($recipientId, true);
					if($myUser->id > 0)
					{
						//valid user
						$recipientList[] = $myUser->id;

						//chi goi mail toi nhung nguoi cach day 1 ngay chua vo reader
						//va chua nam trong danh sach newsletter
						if($myUser->datelastaction < time() - $this->registry->setting['message']['emailSendTimecheck'])
						{
							$toname = $myUser->fullname;
							$toname = ucwords(Helper::codau2khongdau($toname));

							//trademark character will error when sending
							//so convert to htmlentity before sending
							$toname = htmlentities($toname);

							$recipientListEmail[$myUser->email] = $toname;
						}
					}
					else
					{
						$invalidRecipientId++;
					}
				}

				if($invalidRecipientId > 0)
				{
					$error[] = str_replace('###VALUE###', $this->registry->me->fullname, $this->registry->lang['controller']['errInvalidRecipientId']);
				}

				if(count($recipientList) > 0)
				{
					//check attach file
					$attachFileDriveList = array();
					$attachFileIdList = array();

					if(count($formData['fattachedfd']) > 0)
					{
						foreach($formData['fattachedfd'] as $filedriveid => $filedrivename)
						{
							//$_SESSION['myFileDriveList'] setted in file/uploadajax
							if(in_array($filedriveid, $_SESSION['myFileDriveList']))
							{
								$myFileDrive = new Core_Backend_FileDrive($filedriveid);
								if($myFileDrive->id > 0)
								{
									$attachFileNameList[$myFileDrive->id] = $filedrivename;

									$attachFileDriveList[] = $myFileDrive;
									$attachFileIdList[] = $filedriveid;
								}
							}
						}
					}

					//ok, start insert message
					//tao message text truoc
					$myMessageText = new Core_Backend_MessageText();
					$myMessageText->subject = $formData['fsubject'];
					$myMessageText->text = $formData['fmessage'];
					if($myMessageText->addData())
					{
						//tien hanh insert batch vao table message
						$myMessage = new Core_Backend_Message();
						$myMessage->mtid = $myMessageText->id;
						$myMessage->uidfrom = $this->registry->me->id;
						$myMessage->readstatus = 0;
						$myMessage->type = Core_Backend_Message::TYPE_MAIL;
						$myMessage->subject = $myMessageText->subject;
						$myMessage->summary = Helper::truncateperiod(Helper::plaintext($formData['fmessage']), 70);
						$myMessage->summaryuid = $this->registry->me->id;
						$myMessage->countfile = count($attachFileDriveList);
						$myMessage->fileidlist = implode(',', $attachFileIdList);

						if(count($recipientList) > 1)
						{
							$myMessage->ismultirecipient = 1;
						}

						$sendCount = $myMessage->addDataToList($recipientList);

						if($sendCount != count($recipientList))
						{
							$error[] = str_replace('###VALUE###', count($recipientList) - $sendCount, $this->registry->lang['controller']['errInvalidRecipientId']);
						}


						if($sendCount > 0)
						{

							//update message count
							$success = 1;
							$message = $this->registry->me->getUserPath() . '/message';

							$_SESSION['messageSpam'] = time();

							//increase notification for message
							Core_User::notificationIncrease('message', $recipientList);

							//update datelastaction of user
							$this->registry->me->updateDateLastaction();

							//Save attachment for this email
							if(count($attachFileDriveList) > 0)
							{
								foreach($attachFileDriveList as $fileDrive)
								{
									$myRelMessageTextFiledrive = new Core_Backend_RelMessageTextFiledrive();
									$myRelMessageTextFiledrive->mtid = $myMessageText->id;
									$myRelMessageTextFiledrive->fdid = $fileDrive->id;
									$myRelMessageTextFiledrive->name = $attachFileNameList[$fileDrive->id];
									if(!$myRelMessageTextFiledrive->addData())
										$failedAttachedFilenameList[] = $attachFileNameList[$fileDrive->id];
								}


							}

							//goi email toi nguoi nhan
							$taskUrl = $this->registry->conf['rooturl'] . 'task/newmessagesendemail';
							Helper::backgroundHttpPost($taskUrl, 'uid=' . $this->registry->me->id.'&mtid='.$myMessageText->id.'&recipientList=' . serialize($recipientList));


						}
						else
						{
							$error[] = $this->registry->lang['controller']['errSaveMessage'];
						}

					}
					else
					{
						$error[] = $this->registry->lang['controller']['errSaveMessage'];
					}
				}

			}

			//append failed attachment
			if(count($failedAttachedFilenameList) > 0)
				$failedAttachmentMessage = '<p>Attachment Error: ' . implode(', ', $failedAttachedFilenameList) . '.</p>';

			if(!empty($error))
			{
				//build error
				$message = '<![CDATA[<div id="messagesenderror_content"><h2>'.$this->registry->lang['controller']['errSend'].'</h2>'.$failedAttachmentMessage.'<ul>';
				foreach($error as $erroritem)
				{
					$message .= '<li>'.$erroritem.'</li>';
				}
				$message .= '</ul></div>]]>';

				//show error
			}
			else
			{
				$message = '<![CDATA[<div id="messagesendsuccess">'.str_replace('###VALUE###',
							$myMessage->getMessagePath(),
							$this->registry->lang['controller']['succSend']).'</div>'.$failedAttachmentMessage.']]>';
			}

			header ("content-type: text/xml");
			echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
		}
		else
		{

			//detect reply,replyall,forward
			if(isset($_GET['mtid']))
			{
				$messagetextid = (int)$_GET['mtid'];
				$myMessageText = new Core_Backend_MessageText($messagetextid);

				//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
				$messageToList = array($this->registry->me->id);
				$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

				//find message of current user and mtid
				$formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
				$messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
				$myMessage = $messageList[0];

				//Valid of my Product
				$sender = new Core_User($myMessage->uidfrom, true);
				$recipientList = array();
				$attachmentList = array();

				if($myMessage->id > 0 && $myMessageText->id > 0)
				{
					//Init Sent To base on type of new message
					if($_GET['type'] == 'reply')
					{
						$recipientList = array(new Core_User($myMessage->uidfrom, true));
						$formData['fsubject'] = 'Re: ' . $myMessageText->subject;
						$formData['fmessage'] = $myMessageText->getQuotedText($myMessage, $sender);
					}
					elseif($_GET['type'] == 'replyall')
					{
						$recipientList = $myMessage->getFullRecipients();
						$formData['fsubject'] = 'Re: ' . $myMessageText->subject;
						$formData['fmessage'] = $myMessageText->getQuotedText($myMessage, $sender);
					}
					else
					{
						$formData['fsubject'] = 'Fw: ' . $myMessageText->subject;
						$formData['fmessage'] = $myMessageText->getForwardedText($myMessage, $sender, $myMessage->getFullRecipients());

						//Get attachment

						if($myMessage->countfile > 0)
						{
							$relMessageTextFileDriveList = Core_Backend_RelMessageTextFiledrive::getRelMessageTextFiledrives(array('fmtid' => $myMessageText->id), 'id', 'DESC', '');
							if(count($relMessageTextFileDriveList) > 0)
							{
								for($i = 0; $i < count($relMessageTextFileDriveList); $i++)
								{
									$attachment = $relMessageTextFileDriveList[$i];
									$attachment->filedrive = new Core_Backend_FileDrive($attachment->fdid, true);
									if($attachment->filedrive->id > 0)
									{
										$attachmentList[$attachment->filedrive->id] = $attachment;
										$_SESSION['myFileDriveList'][] = $attachment->filedrive->id;
									}
								}
							}
						}



					}


				}




				$this->registry->smarty->assign(array('myMessage' => $myMessage,
													'myMessageText' => $myMessageText,
													'recipientList' => $recipientList,
													'formData' => $formData,
													'attachmentList' => $attachmentList,
													));
			}




			$_SESSION['messageToken'] = Helper::getSecurityToken();

			$contents = $this->registry->smarty->display($this->registry->smartyControllerContainer.'addajax.tpl');

		}


	}


	/**
	* De xuat receipent cho contact To
	*
	*/
	function autocompleteajaxAction()
	{
		$keyword = Helper::xss_clean(strip_tags($_GET['tag']));
		$formData = array('fuserid' => $this->registry->me->id, 'fkeywordFilter' => $keyword);
		$friendList = Core_Backend_Friend::getFriends($formData, 'datelasaction', 'DESC', 5);
		$items = array();
		for($i = 0; $i < count($friendList); $i++)
		{
			$value = '<img src="'.$friendList[$i]->actor->getSmallImage().'" />' . $friendList[$i]->actor->fullname;
			$items[] = array('key' => $friendList[$i]->uid_friend, 'value' => $value);
		}

		echo json_encode($items);

	}

	/**
	* lay cac new message cua user
	*
	*/
	function bottomindexajaxAction()
	{
		//$formData = array('freceiverid' => $this->registry->me->id, 'funread' => 1);


		$limit = $this->registry->me->newmessage;

		if($limit > $this->registry->setting['notification']['bottomItemLimit'])
		{
			$limit = $this->registry->setting['notification']['bottomItemLimit'];
		}

		if($limit == 0)
		{
			$limit = $this->registry->setting['notification']['minShow'];
			$formData = array('fuserid' => $this->registry->me->id);
		}
		else
		{
			$formData = array('fuseridunread' => $this->registry->me->id);
		}


		//lay danh sach cac group/department ma user nay thuoc ve de lay cac message
		$messageToList = array($this->registry->me->id);
		$messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());
		$formData['fuseridlist'] = $messageToList;
		$formData['fisinbox'] = 1;





		$messageList = Core_Backend_Message::getMessages($formData, 'datemodified', 'DESC', $limit);
		if(count($messageList) > 0)
		{
			//update notification item to have-read status
			Core_Backend_Notification::updateReadStatus($this->registry->me->id);

			for($i = 0; $i < count($messageList); $i++)
			{
				$messageList[$i]->actor = Core_User::cacheGet($messageList[$i]->uidfrom);
			}

		}

		//echo '<pre>';
		//print_r($finalNotificationList);
		//exit();
		if($this->registry->me->newmessage > 0)
		{
			$this->registry->me->notificationReset('message');
		}

		$this->registry->smarty->assign(array('messageList' => $messageList,
											));

		header('Content-type: text/xml');
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'bottomindexajax.tpl');

	}
	###########################################################3
	###########################################################3
	###########################################################3

	protected function addajaxvalidator($formData, &$error)
	{
		$pass = true;

		//check spam
		if(isset($_SESSION['messageSpam']) && $_SESSION['messageSpam'] + $this->registry->setting['message']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}

		//check form token
		if($formData['ftoken'] != $_SESSION['messageToken'])
		{
			$pass = false;
			$error[] = $this->registry->lang['default']['securityTokenInvalid'];
		}

		//check recipient
		if(count($formData['fto']) == 0)
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errEmptyTo'];
		}
		else
		{
			//limit permission
			foreach($formData['fto'] as $accountid)
			{
				$myUser = new Core_User($accountid, true);
				if(($myUser->isGroup('department') || $myUser->isGroup('group')) && !$this->canSendToDepartment($myUser))
				{
					$error[] = str_replace('###VALUE###', $myUser->fullname, $this->registry->lang['controller']['errRecipientLimit']);
				}
			}

		}


		//check message
		$strlen = mb_strlen($formData['fmessage'], 'utf-8');
		if($strlen < $this->registry->setting['message']['minlength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['message']['minlength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}

		if($strlen > $this->registry->setting['message']['maxlength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['message']['maxlength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}


		return $pass;
	}



	protected function replyaddajaxvalidator($formData, &$error)
	{
		$pass = true;

		//check spam
		if(isset($_SESSION['messageSpam']) && $_SESSION['messageSpam'] + $this->registry->setting['message']['spamExpired'] > time())
		{
			$pass = false;
			$error[] = $this->registry->lang['controller']['errSpam'];
		}

		//check form token
		if($formData['ftoken'] != $_SESSION['messagereplyToken'])
		{
			$pass = false;
			$error[] = $this->registry->lang['default']['securityTokenInvalid'];
		}


		//check message
		$strlen = mb_strlen($formData['fmessage'], 'utf-8');
		if($strlen < $this->registry->setting['message']['minlength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['message']['minlength'], $this->registry->lang['controller']['errMessageTooShort']);
			$pass = false;
		}

		if($strlen > $this->registry->setting['message']['maxlength'])
		{
			$error[] = str_replace('###VALUE###', $this->registry->setting['message']['maxlength'], $this->registry->lang['controller']['errMessageTooLong']);
			$pass = false;
		}



		//kiem tra user nay co bi block viec send message khong
		$countBlock = Core_Backend_MessageBlock::getBlocks(array('fuserid' => $this->registry->me->id, 'fisunblock' => 0), '', '', '', true);
		if($countBlock > 0)
		{
			$error[] = $this->registry->lang['controller']['errAccountBlock'];
			$pass = false;
		}

		return $pass;
	}


	private function canSendToDepartment(CoreUser $department)
	{
		if($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('moderator') || $this->registry->me->isGroup('developer'))
			return true;
		else
		{
			//normal account, check permission
			//tat ca phong ban
			if($department->id == 2)
				return false;
			else
				return true;
		}
	}
}

