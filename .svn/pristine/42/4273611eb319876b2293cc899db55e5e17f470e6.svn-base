<?php
Class Controller_Wse_Message extends Controller_Wse_Base
{
    public function indexAction()
    {
        $page   = $_POST['p'];
        $record = $_POST['r'];
        $get    = $_POST['m'];
        $error  = array();
        if ($record > 0 && $page > 0 && $get != '' ) {

            $start    = $record * ($page- 1);
            $limit    = $start.','.$record;
            $formData = array();

            if ($get == 'inbox' || $get == '') {
                $formData = array('fisinbox' => 1);
            } elseif ($get == 'mark') {
                $formData = array('fisstarred' => 1);
            } elseif ($get == 'intrash') {
                $formData = array('fisintrash' => 1);
            } elseif ($get == 'sent') {
                $formData = array('fuidfrom' => $this->registry->me->id, 'fissenderdeleted' => 0);
            }

            $items = $this->searchmail($formData,$limit);
        } else {
            $items['items'] = $error;
        }

        echo json_encode($items);
    }
    public function recoveryAction()
    {
        $success = 0;
        $message = '';

        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);

        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

        //find message of current user and mtid
        $formData    = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
        $messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage   = $messageList[0];

        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0) {
            //lay trang thai
            $messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
            if (count($messagetextstatusList) > 0) {
                $myMessageTextStatus = $messagetextstatusList[0];
                 if ($myMessageTextStatus->checkStatusName('intrash')) {
                    $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
                    $success = $myMessageTextStatus->updateData() ? 1 : 0;
                 }
             }
        }

        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,'', $_POST['s'], $this->registry->me->id,$sessionexpired,False);
    }
    public function detailAction()
    {
        $error = array();
        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);
        
        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections(false));
        
        //find message of current user and mtid
        $formData      = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
        $messageList   = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage     = $messageList[0];
        $items         = array();
        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0 ) {
            //nguoi gui email
            $mySender          = new Core_User($myMessage->uidfrom);
            $items['mid']      = (int)$_POST['mid'];
            $items['sendfrom'] = $this->search($mySender->id);

            //danh sach nguoi nhan mail
            $fullRecipientList = $myMessage->getFullRecipients();

            foreach($fullRecipientList as $fullRecipient) {
                $to['uid']      = $fullRecipient->id;
                $to['fullname'] = $fullRecipient->fullname;
                if ($fullRecipient->avatar == '') {
                    $to['avatar'] = '';
                } else {
                    $to['avatar'] = $this->getSmallImage($fullRecipient->avatar);
                }

                $items['sendto'][] = $to;
            }

            $items['timesend'] = date('H:i, d/m',$myMessage->datemodified);

            //mark read this message
            //lay trang thai
            $messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
            if (count($messagetextstatusList) > 0) {
                $myMessageTextStatus = $messagetextstatusList[0];
                if ($myMessageTextStatus->isread == 0) {
                    $myMessageTextStatus->isread = 1;
                    $myMessageTextStatus->updateData();
                }
            } else {
                $myMessageTextStatus         = new Core_Backend_MessageTextStatus();
                $myMessageTextStatus->isread = 1;
                $myMessageTextStatus->uid    = $this->registry->me->id;
                $myMessageTextStatus->mtid   = $myMessageText->id;
                $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
                $myMessageTextStatus->addData();
            }

            if ($messagetextstatusList[0]->isstarred == 0 ) {
                $items['ismarked'] = False;
            } else {
                $items['ismarked'] = True;
            }

            $items['status'] = (string)$myMessageText->subject;
            $items['text']   = (string)$myMessageText->text . '<style type="text/css">
                                                                .quotedmessage
                                                                {
                                                                    border-left: 1px solid #ccc;
                                                                    padding-left: 5px;
                                                                }
                                                                </style>';
            //Get attachment
            $attachmentList = array();
            if ($myMessage->countfile > 0) {
                $relMessageTextFileDriveList = Core_Backend_RelMessageTextFiledrive::getRelMessageTextFiledrives(array('fmtid' => $myMessageText->id), 'id', 'DESC', '');
                if (count($relMessageTextFileDriveList) > 0) {
                    foreach($relMessageTextFileDriveList as $relDriver) {
                        $attachment = $relDriver;
                        $attachment->filedrive = new Core_Backend_FileDrive($attachment->fdid, true);
                        if ($attachment->filedrive->id > 0) {

                            $attachmentList[$attachment->filedrive->id] = $attachment;
                            $item['mid']           =  (int)$attachment->mtid;
                            $item['fileid']        =  (int)$attachment->fdid;
                            $item['filename']      =  (string)$attachment->name;
                            $item['filepath']      =  $this->registry->conf['rooturl'].$this->registry->setting['filecloud']['fileDirectory'].$attachment->filedrive->filepath;
                            $item['filesize']      =  (string)$attachment->filedrive->getDisplaySize();
                            $items['attachfile'][] = $item;
                        }
                    }
                }
            } else {
                $items['attachfile'] = $error;
            }
        } else {
            $items = $error;
        }

        echo json_encode($items);
    }
/*------ Toggle Starred Mail -------- */
    public function marktoggleAction()
    {
        $success = 0;
        $message = '';

        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);

        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

        //find message of current user and mtid
        $formData = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
        $messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage = $messageList[0];

        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0) {
            //lay trang thai
            $messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
            if (count($messagetextstatusList) > 0) {
                $myMessageTextStatus = $messagetextstatusList[0];
                if ($myMessageTextStatus->isstarred == 0) {
                    $myMessageTextStatus->isstarred = 1;
                } else {
                    $myMessageTextStatus->isstarred = 0;
                }
                $success = $myMessageTextStatus->updateData() ? 1 : 0;
            } else {
                $myMessageTextStatus            = new Core_Backend_MessageTextStatus();
                $myMessageTextStatus->isstarred = 1;
                $myMessageTextStatus->uid       = $this->registry->me->id;
                $myMessageTextStatus->mtid      = $myMessageText->id;
                $myMessageTextStatus->status    = Core_Backend_MessageTextStatus::STATUS_INBOX;
                $success                        = $myMessageTextStatus->addData() ? 1 : 0;
            }
        }


        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,'', $_POST['s'], $messagetextid,$sessionexpired,false);
    }
/*------- Action move to trash -------*/
    public function trashtoggleAction()
    {
        $success = 0;
        $message = '';

        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);

        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

        //find message of current user and mtid
        $formData    = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
        $messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage   = $messageList[0];

        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0) {
            //lay trang thai
            $messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
            if (count($messagetextstatusList) > 0) {
                $myMessageTextStatus = $messagetextstatusList[0];
                if ($myMessageTextStatus->checkStatusName('intrash')) {
                    $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INBOX;
                } else {
                    $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
                }

                $success = $myMessageTextStatus->updateData() ? 1 : 0;
            } else {
                $myMessageTextStatus         = new Core_Backend_MessageTextStatus();
                $myMessageTextStatus->uid    = $this->registry->me->id;
                $myMessageTextStatus->mtid   = $myMessageText->id;
                $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
                $success                     = $myMessageTextStatus->addData() ? 1 : 0;
            }
        }

        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,'', $_POST['s'], $this->registry->me->id,$sessionexpired,False);
    }
/*----- Delete Mail Intrash ------*/
    public function deletetoggleAction()
    {
        $success = 0;
        $message = '';

        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);

        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

        //find message of current user and mtid
        $formData    = array('fuidfrom' => $this->registry->me->id, 'fuseridlist' => $messageToList, 'fmtid' => $myMessageText->id);
        $messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage   = $messageList[0];

        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0) {
            //lay trang thai
            $messagetextstatusList = Core_Backend_MessageTextStatus::getMessageTextStatuss(array('fuid' => $this->registry->me->id, 'fmtid' => $myMessageText->id), '', '', 1);
            if (count($messagetextstatusList) > 0) {
                $myMessageTextStatus = $messagetextstatusList[0];
                if ($myMessageTextStatus->checkStatusName('intrash')) {
                    $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_DELETED;
                } else {
                    $myMessageTextStatus->status = Core_Backend_MessageTextStatus::STATUS_INTRASH;
                }

                $success = $myMessageTextStatus->updateData() ? 1 : 0;
            }
        }

        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,'', $_POST['s'], $this->registry->me->id, $sessionexpired,False);
    }
/*-------- Delete mail in send box ------*/
    public function deletesentmailAction()
    {
        $success = 0;
        $message = '';

        $messagetextid = (int)$_POST['mid'];
        $myMessageText = new Core_Backend_MessageText($messagetextid);

        //lay danh sach cac group/department ma user nay thuoc ve de lay cac message
        $messageToList = array($this->registry->me->id);
        $messageToList = array_merge($messageToList, $this->registry->me->getBelongConnections());

        //find message of current user and mtid
        $formData    = array('fuidfrom' => $this->registry->me->id, 'fmtid' => $myMessageText->id);
        $messageList = Core_Backend_Message::getMessages($formData, '', '', 1);
        $myMessage   = $messageList[0];

        //kiem tra message hop le
        if ($myMessage->id > 0 && $myMessageText->id > 0) {
            if ($myMessage->uidfrom == $this->registry->me->id) {
                $success = Core_Backend_Message::markSenderDeleted($myMessage->mtid, $this->registry->me->id) > 0 ? 1: 0;
            }
        }

        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,'', $_POST['s'], $this->registry->me->id, $sessionexpired,False);
    }
/*---- Send Mail ------*/
    public function sendAction()
    {
        /**
        * Tien hanh xu ly
        */
        $type          = (int)$_POST['type'];
        $messagetextid = (int)$_POST['mid'];

        if ($type > 0 && $messagetextid > 0) {
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
            $fullRecipientList = $myMessage->getFullRecipients();

            if ($myMessage->id > 0 && $myMessageText->id > 0) {
                //Init Sent To base on type of new message
                if ($type == 1 || $type == 2) {

                    $summary = '<p></p><p></p>
                                <div class="quotedmessagewrapper" id="mt-'.$myMessageText->id.'">
                                    <p class="quotedmessagemeta"> Vào '.date('H:i, d/m/Y', $myMessage->datecreated).', <a href="'.$sender->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$sender->getHovercardPath().'">'.$sender->fullname.'</a> viết: </p><div class="quotedmessage">' . $myMessageText->text . '</div>
                                </div>
                                <p></p>';
                } elseif ($type == 3) {
                    $summary = '<p></p><p></p>
                    <div class="forwardedmessagewrapper" id="mt-'.$myMessageText->id.'">
                        <p class="forwardedmessagemeta">
                            <div class="forwaredmessagemetahead">---------- Thư đã chuyển tiếp ----------</div>
                            <div class="forwardedmessagefrom"> Từ: <a href="'.$sender->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$sender->getHovercardPath().'">'.$sender->fullname.'</a></div>
                            <div class="forwardedmessagedate"> Lúc: '.date('H:i, d/m/Y', $myMessage->datecreated).'</div>
                            <div class="forwardedmessageto"> Đến: ';
                    //process recipientList
                    $count = count($fullRecipientList) ;

                    for($i = 0; $i < $count; $i++) {
                        $user = $fullRecipientList[$i];
                        if ($i > 0) {
                            $summary .= ', ';
                        }

                        $summary .= '<a href="'.$user->getUserPath().'" class="tipsy-hovercard-trigger" data-url="'.$user->getHovercardPath().'">'.$user->fullname.'</a>';
                    }

                    $summary .= '</div>
                                    </p>
                                    <p>&nbsp;</p>
                                <div class="forwardedmessage">' .$myMessageText->text. '</div>
                                </div>
                                <p></p>';
                }
            }
        }

        /*---tien hanh xu ly de send---*/
        $formData = $_POST;
        $formData['to'] = explode(',', $_POST['to']);

        ///kiem tra formData
        $message = $this->checkform($formData);
        if (empty($message)) {
            $formData['subject'] = Helper::xss_clean($formData['subject']);
            $formData['message'] = Helper::xss_clean($formData['message']);

            //refine recipientlist
            $recipientList = array();
            $recipientListEmail = array();

            foreach($formData['to'] as $recipientId) {
                $myUser = new Core_User($recipientId, true);

                if ($myUser->id > 0) {
                    //valid user
                    $recipientList[] = $myUser->id;
                    if ($myUser->datelastaction < time() - $this->registry->setting['message']['emailSendTimecheck']) {
                        $toname = $myUser->fullname;
                        $toname = ucwords(Helper::codau2khongdau($toname));
                        //trademark character will error when sending
                        //so convert to htmlentity before sending
                        $toname = htmlentities($toname);
                        $recipientListEmail[$myUser->email] = $toname;
                    }
                }
            }

            if (count($recipientList) > 0) {

                $attachFileDriveList = array();
                $attachFileIdList = array();

                $file = $_SESSION['mobileFileUploads'];
                if (count($file) > 0) {
                    foreach($file as $filedriveid => $filedrivename) {
                        $myFileDrive = new Core_Backend_FileDrive($filedriveid);
                        if ($myFileDrive->id > 0) {
                            $attachFileNameList[$myFileDrive->id] = $filedrivename;
                            $attachFileDriveList[]                = $myFileDrive;
                            $attachFileIdList[]                   = $filedriveid;
                        }
                    }
                }

                //ok, start insert message
                //tao message text truoc
                $myMessageText          = new Core_Backend_MessageText();
                $myMessageText->subject = $formData['subject'];
                $myMessageText->text    = $formData['message'] . $summary;

                if ($myMessageText->addData()) {
                    //tien hanh insert batch vao table message
                    $myMessage             = new Core_Backend_Message();
                    $myMessage->mtid       = $myMessageText->id;
                    $myMessage->uidfrom    = $this->registry->me->id;
                    $myMessage->readstatus = 0;
                    $myMessage->type       = Core_Backend_Message::TYPE_MAIL;
                    $myMessage->subject    = $myMessageText->subject;
                    $myMessage->summary    = Helper::truncateperiod(Helper::plaintext($formData['message']), 70);
                    $myMessage->summaryuid = $this->registry->me->id;
                    $myMessage->countfile  = count($attachFileDriveList);
                    $myMessage->fileidlist = implode(',', $attachFileIdList);

                    if (!empty($_SESSION['myFileDrive'])) {
                        $myMessage->fileidlist = implode(',', $_SESSION['myFileDrive']);
                    } else {
                        $myMessage->fileidlist = 0 ;
                    }

                    if (count($recipientList) > 1) {
                        $myMessage->ismultirecipient = 1;
                    }

                    $sendCount = $myMessage->addDataToList($recipientList);

                    if ($sendCount != count($recipientList)) {
                        $message = 'Không thể gởi tin nhắn tới thành viên trong số người gởi bạn đã chọn.';
                    }

                    if ($sendCount > 0) {

                        //update message count
                        $success = True;
                        $_SESSION['messageSpam'] = time();

                        //increase notification for message
                        Core_User::notificationIncrease('message', $recipientList);

                        //update datelastaction of user
                        $this->registry->me->updateDateLastaction();

                        //goi email toi nguoi nhan
                        $taskUrl = $this->registry->conf['rooturl'] . 'task/newmessagesendemail';
                        Helper::backgroundHttpPost($taskUrl, 'uid=' . $this->registry->me->id.'&mtid='.$myMessageText->id.'&recipientList=' . serialize($recipientList));
                /*---luu attachment---*/

                        if (count($attachFileDriveList) > 0) {
                                foreach($attachFileDriveList as $fileDrive) {
                                    $myRelMessageTextFiledrive       = new Core_Backend_RelMessageTextFiledrive();
                                    $myRelMessageTextFiledrive->mtid = $myMessageText->id;
                                    $myRelMessageTextFiledrive->fdid = $fileDrive->id;
                                    $myRelMessageTextFiledrive->name = $attachFileNameList[$fileDrive->id];
                                    if (!$myRelMessageTextFiledrive->addData()) {
                                        $failedAttachedFilenameList[] = $attachFileNameList[$fileDrive->id];
                                    }
                                }
                            }
                    } else {
                        $message = 'Có lỗi khi gởi tin nhắn của bạn.';
                    }

                }else {
                    $message = 'Có lỗi khi gởi tin nhắn của bạn.';
                }
            }
        }

    //output for send mail
        $_SESSION['messageToken'] = Helper::getSecurityToken();
        if ($success) {
            $success = True;
        } else {
            $success = False;
        }

        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($success,$message, $_POST['s'], $this->registry->me->id, $sessionexpired , False);
    }
    protected function checkform($formData)
    {
        $strlen = mb_strlen($formData['message'], 'utf-8');
        $count  = count($_FILES);

        // //check spam
        if (isset($_SESSION['messageSpam']) && $_SESSION['messageSpam'] + $this->registry->setting['message']['spamExpired'] > time()) {
            $error = 'Bạn vừa gởi 1 tin nhắn. Hãy chờ trong giây lát.';
        }

        if ($strlen < $this->registry->setting['message']['minlength']) {
            //check message
            $error = 'Nội dung tin nhắn quá ngắn.';
        }

        if ($strlen > $this->registry->setting['message']['maxlength']) {
            //check message
            $error = 'Nội dung tin nhắn quá dài.';
        }

        if ($formData['to'][0] == '' || $formData['to'][0] == 0) {
            //check recipient
            $error = 'Bạn chưa chọn người để gởi tin nhắn.';
        }

        if ($formData['to'][0] != '' && $formData['to'][0] > 0) {
            //limit permission
            foreach($formData['to'] as $accountid) {
                $myUser = new Core_User($accountid, true);
                if (($myUser->isGroup('department') || $myUser->isGroup('group')) && !$this->canSendToDepartment($myUser)) {
                    $error = 'Bạn không thể gởi tin nhắn đến người này.';
                } elseif ($myUser->id == 0) {
                    $error = 'Bạn không thể gởi tin nhắn đến người này.';
                }
            }
        }
        if ($count >0) {
            for($i = 1 ; $i <= $count ; $i++) {
                if ($_FILES['attachedfile_'.$i]['name'] == '') {
                    $error = 'File Upload is required.';
                } else {
                    $ext = strtoupper(Helper::fileExtension($_FILES['attachedfile_'.$i]['name']));

                    if (!in_array($ext, $this->registry->setting['filecloud']['fileValidType'])) {
                        $error = str_replace('###VALUE###', implode(', ', $this->registry->setting['filecloud']['fileValidType']), 'File type is Invalid. (###VALUE### only)');
                    } elseif ($_FILES['attachedfile_'.$i]['size'] > $this->registry->setting['filecloud']['fileMaxFileSize']) {
                        $error = str_replace('###VALUE###', round($this->registry->setting['filecloud']['fileMaxFileSize'] / 1024 / 1024), 'File size is too big. (Max: ###VALUE###MB)');
                    } else {
                        $myFileDrive                                  = new Core_Backend_FileDrive();
                        $myFileDrive->uid                             = $this->registry->me->id;
                        $myFileDrive->status                          = Core_Backend_FileDrive::STATUS_ENABLE;
                        $session[$myFileDrive->addDataFromMobile($i)] = $_FILES['attachedfile_'.$i]['name'];

                    }
                }
            }
        }

        $_SESSION['mobileFileUploads'] = $session;

        return $error;
    }
    private function canSendToDepartment(CoreUser $department)
    {
        if ($this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('moderator') || $this->registry->me->isGroup('developer')) {
            return true;
        } else {
            //normal account, check permission
            //tat ca phong ban
            if ($department->id == 2) {
                return false;
            } else {
                return true;
            }
        }
    }
    public function searchmail($formData,$limit)
    {

        if ($formData['fisinbox'] == 1) {
            $messageToList           = array($this->registry->me->id);
            $messageToList           = array_merge($messageToList, $this->registry->me->getBelongConnections(false));
            $formData['fuseridlist'] = $messageToList;
        }

        $total         = Core_Backend_Message::getMessages($formData, '', '', '', true);
        $item['total'] = (int)$total;
        $messagelist   = Core_Backend_Message::getMessages($formData, 'datemodified', 'DESC', $limit);

        if (!empty($messagelist)) {
            foreach($messagelist as $message) {

                $items['user']   = $this->search($message->uidfrom);
                $items['mid']    = (int)$message->mtid;
                $items['status'] = (string)$message->subject;
                $formData        = array('fuid' => $this->registry->me->id , 'fmtid' => $message->mtid );
                $label           = Core_Backend_MessageTextStatus::getMessageTextStatuss($formData, '', '',1);

                //--------kiem tra co danh dau mail nay hay chua-------//
                if ($label[0]->isstarred > 0) {
                    $items['ismarked'] = True;
                } else {
                    $items['ismarked'] = False;
                }

                //-------kiem tra mail nay doc roi chay chua-----//
                if ($label[0]->isread > 0) {
                    $items['isreaded'] = True;
                } else {
                    $items['isreaded'] = False;
                }

                //--------kiem tra co file dinh kem hay khong -----//
                if ($message->countfile > 0) {
                    $items['isattached']   = True;
                } else {
                    $items['isattached']   = False;
                }

                $items['time']   = date('H:i, d/m/y',$message->datemodified);
                $item['items'][] = $items;

            }

            //reset notification counting
            if ($this->registry->me->newmessage > 0) {
                $this->registry->me->notificationReset('message');
                $this->registry->me->newmessage = 0;
            }
        } else {
            $item['items'] = $messagelist;
        }

        return $item;
    }
	public function search($keyword)
    {

        $check        = Core_User::getUsers($formData = array('fid'=>$keyword),'','',1);
        $user         = $check[0];
        $region       = new Core_Region($user->region, TRUE);
        $positionId   = Core_UserEdge::getUserEdges($formData = array('fuidstart' => $keyword, 'ftype' => Core_UserEdge::TYPE_EMPLOY),'','',1);
        $positionName = new Core_HrmTitle($positionId[0]->point, TRUE);
        $departmentID = new Core_User($positionId[0]->uidend, TRUE);
        $items        = array();
        if (empty($user)) {
            return $items;
        } else {
            $items['uid']            = (int)$user->id;
            $items['idbcnb']         = (int)$user->oauthUid;
            $items['group']          = (int)$user->groupid;
            $items['gender']         = (int)$user->gender;
            $items['fullname']       = (string)ucwords($user->fullname);

            if ($departmentID->groupid != 15) {
                $items['departmentid']   = 0;
                $items['departmentname'] = '';
            } else {
                $items['departmentid']   = (int)$positionId[0]->uidend;
                $items['departmentname'] = (string)$departmentID->fullname;
            }

            $items['regionid']       = (int)$region->id;
            $items['regionname']     = (string)$region->name;
            $items['email']          = (string)$user->email;
            $items['phone']          = (string)$user->phone;
            $items['workplace']      = '';
            $items['positionid']     = (int)$positionId[0]->point;
            $items['positionname']   = (string)$positionName->name;
            $items['lastlogin']      = (string)$user->datelastlogin;
            $items['timestartjob']   = '';

            if ($this->registry->me->id == $user->id) {
                $items['ipaddress'] = (string)Helper::getIpAddress();
            } else {
                $items['ipaddress'] = (string)$user->ipaddress;
            }

            if ($user->avatar == '') {
                $items['avatar'] = '';
            } else {
                $items['avatar'] = (string)'http://a.tgdt.vn/'.$this->getSmallImage($user->avatar);
            }
        }

        return $items;
    }
    public function getSmallImage($image)
    {
        $pos       = strrpos($image, '.');
        $extPart   = substr($image, $pos+1);
        $namePart  =  substr($image,0, $pos);
        $filesmall = $namePart . '-small.' . $extPart;
        $url       = $filesmall;

        return $url;
    }
    public function time_ago($ptime)
    {
        if ($ptime > 0) {
            $etime = time() - $ptime;

            if ($etime < 1) {
                return '0 seconds';
            }

            $a = array( 31570560    =>  'năm',
                        2630880     =>  'tháng',
                        86400       =>  'ngày',
                        3600        =>  'giờ',
                        60          =>  'phút',
                        1           =>  'giây'
                        );

            foreach ($a as $secs => $str) {
                $d = $etime / $secs;

                if ($d >= 1) {
                    $r = round($d);
                    return $r . ' ' . $str . ' trước';
                }
            }
        }
    }
}

?>
