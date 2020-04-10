<?php

Class Controller_Site_Review Extends Controller_Site_Base 
{
    /**
    * Liet ke cac review tren website
    * 
    */
    public function indexAction()
    {
        $formData = array('fparentid' => 0);
        $page             = (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
                
        $recordPerPage = $this->registry->setting['review']['recordPerPage'];
        //tim tong so record
        $total = Core_Review::getReviews($formData, '', '', $recordPerPage, true, true, true);
        $totalPage = ceil($total/$recordPerPage);
        $curPage = $page;
        $paginateUrl = $this->registry->conf['rooturl'].'review/';
        
        //process to limit page, prevent leech book data
        if($totalPage > $this->registry->setting['review']['limitPage'])
        {
            $totalPage = $this->registry->setting['review']['limitPage'];
            if($curPage > $totalPage)
            {
                $this->notfound();
            }
        }
        elseif($curPage != 1 && $curPage > $totalPage)
        {
            $this->notfound();
        }
        
        $reviewList = Core_Review::getReviews($formData, '', '', (($page - 1)*$recordPerPage).','.$recordPerPage, false, true, true);
        
        for($i = 0; $i < count($reviewList); $i++)
        {
            $reviewList[$i]->text = Helper::mentionParsing($reviewList[$i]->text, $reviewList[$i]->entityList);
        }
        
        
        $this->registry->smarty->assign(array('reviewList' => $reviewList,
                                            'formData'        => $formData,
                                            'paginateurl'     => $paginateUrl, 
                                            'paginatesuffix'=> $paginateSuffix, 
                                            'total'            => $total,
                                            'totalPage'     => $totalPage,
                                            'curPage'        => $curPage
                                            ));
        
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
        
        
        //SEO PREPARE
        $pageTitle = $this->registry->lang['controller']['pageTitle'];;
        $pageKeyword = $this->registry->lang['controller']['pageKeyword'];
        $pageDescription = $this->registry->lang['controller']['pageDescription'];
        
                
        if($curPage > 1)
        {
            $pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
            $pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
            $pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
        }
        
        //them thong tin title sach vao description
        for($i = 0, $ct = count($reviewList); $i < $ct; $i++)
        {
            if($i != 0)
                $pageDescription .= ',';
            $pageDescription .= ' ' . $reviewList[$i]->book->title;
            if($i == $ct - 1)
                $pageDescription .= '.';
            if($i == $this->registry->setting['book']['descriptionTitleLimit'] - 1)
                break;
        }
        
        $this->registry->smarty->assign(array('contents' => $contents,
                                            'pageTitle' => $pageTitle,
                                            'pageKeyword' => $pageKeyword,
                                            'pageDescription' => $pageDescription,
                                            ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }
    
    
    
    /**
    * xem chi tiet 1 review
    * 
    */
    public function detailAction()
    {
        $formData = array();
        
        $reviewId = (int)$_GET['id'];
        $myReview = new Core_Review($reviewId);
        
        if($myReview->id > 0)
        {
            $myReview->replies = $myReview->getReplies();
            if(count($myReview->replies) > 0)
            {
                for($j = 0; $j < count($myReview->replies); $j++)
                {
                    $myReview->replies[$j]->text = Helper::mentionParsing($myReview->replies[$j]->text, $myReview->replies[$j]->entityList);
                }
            }
            
            
            $this->registry->smarty->assign(array('reviewList' => array($myReview),
                                                'myBook' => $myReview->book,
                                                'formData'        => $formData,
                                                ));
            
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl'); 
            
            
            //SEO PREPARE
            $pageTitle = $this->registry->lang['controller']['pageTitleDetail'] . ' ' . $myReview->book->title;
            $pageKeyword = $this->registry->lang['controller']['pageKeyword'] . ', ' . $myReview->book->title;
            $pageDescription = Helper::truncateperiod($myReview->text, 200, '...');
            
                    
                    
            
            $this->registry->smarty->assign(array('contents' => $contents,
                                                'pageTitle' => $pageTitle,
                                                'pageKeyword' => $pageKeyword,
                                                'pageDescription' => $pageDescription,
                                                ));
            $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
        }
        else
        {
            $this->notfound();
        }
                
        
        
    }
    
    
    /**
    * Liet ke cac review tren website
    * 
    */
    public function indexfulljoinAction()
    {
        $formData = array();
        $page             = (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
                
        //tim tong so record
        $total = Core_Review::getReviews($formData, '', '', $this->registry->setting['review']['recordPerPage'], true, true, true);
        $totalPage = ceil($total/$this->registry->setting['review']['recordPerPage']);
        $curPage = $page;
        $paginateUrl = $this->registry->conf['rooturl'].'review/';
        
        //process to limit page, prevent leech book data
        if($totalPage > $this->registry->setting['review']['limitPage'])
        {
            $totalPage = $this->registry->setting['review']['limitPage'];
            if($curPage > $totalPage)
            {
                $this->notfound();
            }
        }
        elseif($curPage != 1 && $curPage > $totalPage)
        {
            $this->notfound();
        }
        
        $reviewList = Core_Review::getReviews($formData, '', '', (($page - 1)*$this->registry->setting['review']['recordPerPage']).','.$this->registry->setting['review']['recordPerPage'], false, true, true);
        
        $this->registry->smarty->assign(array('reviewList' => $reviewList,
                                            'formData'        => $formData,
                                            'paginateurl'     => $paginateUrl, 
                                            'paginatesuffix'     => $paginateSuffix, 
                                            'total'            => $total,
                                            'totalPage'     => $totalPage,
                                            'curPage'        => $curPage
                                            ));
        
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl'); 
        
        
        //SEO PREPARE
        $pageTitle = $this->registry->lang['controller']['pageTitle'];;
        $pageKeyword = $this->registry->lang['controller']['pageKeyword'];
        $pageDescription = $this->registry->lang['controller']['pageDescription'];
        
                
        if($curPage > 1)
        {
            $pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
            $pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
            $pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
        }
        
        //them thong tin title sach vao description
        for($i = 0, $ct = count($reviewList); $i < $ct; $i++)
        {
            if($i != 0)
                $pageDescription .= ',';
            $pageDescription .= ' ' . $reviewList[$i]->book->title;
            if($i == $ct - 1)
                $pageDescription .= '.';
            if($i == $this->registry->setting['book']['descriptionTitleLimit'] - 1)
                break;
        }
        
        $this->registry->smarty->assign(array('contents' => $contents,
                                            'pageTitle' => $pageTitle,
                                            'pageKeyword' => $pageKeyword,
                                            'pageDescription' => $pageDescription,
                                            ));
        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
    }
    /**
    * Load cac review cua 1 sach
    * 
    * Thuat toan: lay tu duoi len tren
    * 
    * Nhung sau khi lay cho 1 page, tien hanh dao nguoc lai de hien thi tu cu toi moi
    * 
    */
    function indexajaxAction() 
    {
        $bookid = (int)$_GET['bookid'];
        $page = (int)$_GET['page'];
        $bookpath = base64_decode($_GET['encodebookpath']);
        $recordPerPage = $this->registry->setting['review']['recordPerPage'];
        
        if($page <= 0) $page = 1;
            
        //tim tong so record
        $total = Core_Review::getReviews(array('fbookid' => $bookid, 'fparentid' => 0), 'id', 'DESC', '', true, false);
        $totalPage = ceil($total/$recordPerPage);
        $paginateUrl = 'bookreviewLoad(\''.$bookpath.'\', \''.$_GET['encodebookpath'].'\', ::PAGE::)';
        
        $reviews = Core_Review::getReviews(array('fbookid' => $bookid, 'fparentid' => 0), 'id', 'DESC', '' . (($page - 1) * $recordPerPage) . ',' . $recordPerPage , false, false);
        
        
        if(count($reviews) == 0)
        {
            echo 'empty';
        }
        else
        {
            for($i = 0; $i < count($reviews); $i++)
            {
                $reviews[$i]->text = Helper::mentionParsing($reviews[$i]->text, $reviews[$i]->entityList);
                if($reviews[$i]->numreply > 0)
                {
                    $reviews[$i]->replies = $reviews[$i]->getReplies();
                    if(count($reviews[$i]->replies) > 0)
                    {
                        for($j = 0; $j < count($reviews[$i]->replies); $j++)
                        {
                            $reviews[$i]->replies[$j]->text = Helper::mentionParsing($reviews[$i]->replies[$j]->text, $reviews[$i]->replies[$j]->entityList);
                        }
                    }
                }
            }
            
            ////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////
            // HIGH RESOURCE FEATURE, TO GET THE RATING & FAV STATUS
            //get the uid
            $userids = array();
            foreach($reviews as $review)
            {
                if(!in_array($review->uid, $userids))
                    $userids[] = $review->uid;
            }

            //fetch userbook to get the rating
            $userBooks = Core_UserBook::getBooks(array('fbookid' => $bookid, 'fuseridlist' => $userids), '', '', '', false, false, false);
            $reviewRatings = array();
            foreach($userBooks as $userbook)
            {
                $reviewRatings[$userbook->uid] = $userbook->rating;
            }

            //fetch bookfav to get the favstatus
            $bookFavs = Core_BookFav::getFav(array('fbookid' => $bookid, 'fuseridlist' => $userids), '', '', '', false, false, false);
            $reviewFavs = array();
            foreach($bookFavs as $bookfav)
            {
                $reviewFavs[$bookfav->uid] = 1;
            }
            ///////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////
            
            $reviews = array_reverse($reviews);
            $this->registry->smarty->assign(array('reviews'        => $reviews,
                                                'reviewRatings' => $reviewRatings,
                                                'reviewFavs' => $reviewFavs,
                                                'bookpath' => $bookpath,
                                                'bookid' => $bookid,
                                                'total' => $total,
                                                'totalPage' => $totalPage,
                                                'curPage' => $page,
                                                'paginateUrl' => $paginateUrl
                                                ));
        
            $this->registry->smarty->display($this->registry->smartyControllerContainer.'indexajax.tpl');     
        }
        
    }
    
    function addAction()
    {
        $bookid = (int)$_GET['id'];
        $myBook = Core_Book::cacheGet($bookid);
        if($myBook->id == 0)
        {
            die('Book Not Found');
        }
        
        $success = $error = $formData = array();
        
        /////////////////////////////////////
        // reset show review popup flag
        unset($_SESSION['showreviewpopup']);
        
        //kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
        $this->registry->smarty->assign(array('myBook' => $myBook,
                                                'success' => $success,
                                                'error'    => $error,
                                                'formData' => $formData
                                            ));
        
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl'); 
        
        //kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
        $this->registry->smarty->assign(array('contents' => $contents,
                                            ));
        
        $this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl'); 
        
    }
    
    function editAction()
    {
        $reviewId = (int)$_GET['id'];
        $myReview = new Core_Review($reviewId);
        
        if($myReview->id == 0 || ($myReview->uid != $this->registry->me->id && !$myReview->canModerate() ))
        {
            die('Review Not Found');
        }
        $myBook = new Core_Book($myReview->bid, true);
        
        
        
        
        //kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
        $this->registry->smarty->assign(array('myBook' => $myBook,
                                                'myReview' => $myReview,
                                            ));
        
        $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl'); 
        
        //kiem tra xem co recipient san chua (do click nut send message tu 1 user nao do)
        $this->registry->smarty->assign(array('contents' => $contents,
                                            ));
        
        $this->registry->smarty->display($this->registry->smartyControllerContainerRoot.'index_shadowbox.tpl'); 
        
    }
    
    /**
    * Them 1 review cho 1 user doi voi 1 book
    * 
    */
    function addajaxAction()
    {
        $moreMessage = '';
        if($this->registry->me->id < 0)
        {
            $success = 0;
            $message = $this->registry->lang['default']['loginRequired'];
        }
        else
        {
            $myBook = new Core_Book((int)$_GET['bookid']);
            if($myBook->id == 0)
            {
                $success = 0;
                $message = $this->registry->lang['default']['bookNotFound'];    
            }
            else
            {
                $error = array();
                $formData = $_POST;
                array_walk($formData, 'trim');
                
                if($this->addajaxValidator($formData, $error))
                {
                    //check condition for review or review queu
                    //there are 2 condition here to become normal review
                    //1. not badstring
                    //2. have avatar (New, added on 4/5/2012)
                    $isNeedQueue = false;
                    
                    //condition 1, badstring
                    //check badstring ^^
                    $isBadString = BadStringChecker::isbad($formData['fmessage']);
                    if($isBadString)
                        $isNeedQueue = true;                
                    
                    //condition 2, have avatar
                    if($this->registry->me->avatar == '')
                        $isNeedQueue = true;
                        
                    //condition 3, have review user is OK
                    if($this->registry->me->countReview >= 2)
                        $isNeedQueue = false;
                    
                    //finalize 3 conditions to detect queue or not
                    if ($isNeedQueue) 
                        $myReview = new Core_ReviewQueue();
                    else
                        $myReview = new Core_Review();
                        
            
                    
                    $myReview->uid = $this->registry->me->id;
                    $myReview->bid = $myBook->id;
                    $myReview->text = htmlspecialchars($formData['fmessage']);
                    $myReview->parentid = (int)$formData['freviewid'];
                    
                    if($myReview->addData())
                    {
                        
                        $success = 1;
                        $message = $this->registry->lang['controller']['succAdd'];
                        $moreMessage = '<review>';
                        $moreMessage .= '<id>'.$myReview->id.'</id>';
                        $moreMessage .= '<text><![CDATA['.Helper::mentionParsing($myReview->text, $myReview->entityList).']]></text>';
                        $moreMessage .= '<time>'.$myReview->datecreated.'</time>';
                        $moreMessage .= '<fullname>'.$this->registry->me->fullname.'</fullname>';
                        $moreMessage .= '<userpath>'.$this->registry->me->getUserPath().'</userpath>';
                        $moreMessage .= '<avatar>'.$this->registry->me->getSmallImage().'</avatar>';
                        $moreMessage .= '</review>';
                        
                        
                        $_SESSION['reviewSpam'] = time();
                        $_SESSION['previousReview'] = $formData['fmessage'];
                        
                        //clear autosave data
                        $_SESSION['reviewAutosave'] = '';
                        
                        if(!$isNeedQueue)
                        {
                            //thao tac tuong tu trong viec xu ly accept queue
                            //create feed
                            $myFeedReviewAdd = new Core_Backend_Feed_ReviewAdd();
                            $myFeedReviewAdd->uid = $this->registry->me->id;
                            $myFeedReviewAdd->myBook = $myBook;
                            $myFeedReviewAdd->reviewText = Helper::truncateperiod(Helper::mentionMetaRemove($myReview->text), 200);
                            $myFeedReviewAdd->addData();
                            
                            //select correct REP REVIEW TYPE
                            $reviewLength = mb_strlen($myReview->text);
                            $repType = 0;
                            if($reviewLength >= 1600)
                                $repType = Core_Rep::TYPE_REVIEW_LONG_ADD;
                            elseif($reviewLength >= 800)
                                $repType = Core_Rep::TYPE_REVIEW_MEDIUM_ADD;
                            elseif($reviewLength >= 400)
                                $repType = Core_Rep::TYPE_REVIEW_SHORT_ADD;
                            elseif($reviewLength >= 100)
                                $repType = Core_Rep::TYPE_REVIEW_TINY_ADD;
                            
                            //xu ly them REP neu hop le
                            if($repType > 0 && Core_Rep::canAdd($this->registry->me->id, $repType))
                            {
                                $myRep = new Core_Rep();
                                $myRep->uid = $this->registry->me->id;
                                $myRep->uidtrigger = $this->registry->me->id;
                                $myRep->type = $repType;
                                $myRep->objectid1 = $myBook->id;
                                $myRep->objectid2 = $myReview->id;
                                $myRep->text = substr($myReview->text, 0, 200);
                                $repValue = $myRep->addData();
                                if($repValue > 0)
                                {
                                    $this->registry->me->rep += $repValue;
                                }
                            }
                            
                            //increase review counting
                            $myBook->updateCount('review', 1);
                            
                            //update user-stat
                            $this->registry->me->updateCounting(array('review'));
                            
                            //khong can update metadata o day
                            //boi vi khi aadd review thi ngoai viec update metadata
                            //con tao notification den nhung userid lien quan den booknay dua vao metadata lists
                            //do do, su dung co che async job de vua send notification (co the co nhieu INSERT sql)
                            //de process nhanh cho nay
                            //viec goi notification nay duoc thiet ke rieng 1 automatic task (standalone) voi cac tham so tuong ung
                            //de tu dong goi ma thoi
                            $taskUrl = $this->registry->setting['site']['taskurl'] . 'index.php?c=booknotification&a=review';
                            Helper::backgroundHttpPost($taskUrl, 'uid=' . $this->registry->me->id.'&bid=' . $myBook->id . '&rid=' . $myReview->id);
                        }
                        else
                        {
                            //tao 1 notification thong bao den user nay la review khong hop le
                            $badstringNotification = new Core_Backend_Notification_SystemNotify();
                            $badstringNotification->uid = 2;    //readerbot userid
                            $badstringNotification->uidreceive = $this->registry->me->id;
                            $badstringNotification->text = str_replace('###VALUE###', $myBook->title,$this->registry->lang['controller']['notifyBadstring']);
                            if($badstringNotification->addData())
                            {
                                //increase notification count for receiver
                                Core_User::notificationIncrease('notification', array($badstringNotification->uidreceive));
                            }
                        }
                        
                        
                        
                    }
                    else
                    {
                        $success = 0;
                        $message = $this->registry->lang['controller']['errAdd'];    
                    }
                }
                else
                {
                    $success = 0;
                    $message = implode(', ', $error);
                }
            }
        }
        
        header ("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
    }
    
    /**
    * Them 1 review cho 1 user doi voi 1 book
    * 
    */
    function editajaxAction()
    {
        $moreMessage = '';
        if($this->registry->me->id < 0)
        {
            $success = 0;
            $message = $this->registry->lang['default']['loginRequired'];
        }
        else
        {
            $myReview = new Core_Review((int)$_GET['id']);
            if($myReview->id == 0 || ($myReview->uid != $this->registry->me->id && !$myReview->canModerate() ))
            {
                $success = 0;
                $message = $this->registry->lang['controller']['notfound'];    
            }
            else
            {
                $error = array();
                $formData = $_POST;
                array_walk($formData, 'trim');
                
                if($this->addajaxValidator($formData, $error))
                {
                    //check badstring ^^
                    $isBadString = BadStringChecker::isbad($formData['fmessage']);
                    
                    $myReview->text = htmlspecialchars($formData['fmessage']);
                    
                    if($myReview->updateData())
                    {
                        
                        $success = 1;
                        $message = $this->registry->lang['controller']['succEdit'];
                        
                        $_SESSION['reviewSpam'] = time();
                        $_SESSION['previousReview'] = $formData['fmessage'];
                        
                        //send email to admin
                        
                    }
                    else
                    {
                        $success = 0;
                        $message = $this->registry->lang['controller']['errEdit'];    
                    }
                }
                else
                {
                    $success = 0;
                    $message = implode(', ', $error);
                }
            }
        }
        
        header ("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message>'.$moreMessage.'</result>';
    }
    
    /**
    * Remove 1 review cho 1 user doi voi 1 book
    * 
    */
    function removeajaxAction()
    {
        if($this->registry->me->id < 0)
        {
            $success = 0;
            $message = $this->registry->lang['default']['loginRequired'];
        }
        else
        {
            $myBook = new Core_Book((int)$_GET['bookid']);
            if($myBook->id == 0)
            {
                $success = 0;
                $message = $this->registry->lang['default']['bookNotFound'];    
            }
            else
            {
                $reviewid = $_GET['id'];
                $myReview = new Core_Review($reviewid);
                if($myReview->parentid > 0)
                    $myParentReview = new Core_Review($myReview->parentid);
                else
                    $myParentReview = new Core_Review();
                    
                if($myReview->uid != $this->registry->me->id && $myParentReview->uid != $this->registry->me->id && !$myReview->canModerate())
                {
                    $success = 0;
                    $message = $this->registry->lang['controller']['notfound'];
                }
                else
                {
                    if($myReview->delete())
                    {
                        $success = 1;
                        $message = $this->registry->lang['controller']['succRemove'];    
                        
                        //decrease review counting
                        $myBook->updateCount('review', -1);
                        
                        //update user-stat
                        $this->registry->me->updateCounting(array('review'));
                        
                        //khong update metadata
                        //boi vi co the hien tai userid nay co nhieu review
                        //chang the nao vi xoa 1 review ma xoa luon userid khoi reviewlist
                        //do do khong can hanh dong xoa userid khoi reviewlist
                        //neu that su day la review cuoi cung, thi khi run task de sync toan bo metadata
                        //userid cung se tu dong bi xoa khoi danh sach review :D
                        //qua trinh xu ly nay cung se tuong tu nhu khi xoa note va quote
                    }    
                    else
                    {
                        $success = 0;
                        $message = $this->registry->lang['controller']['errRemove'];
                    }
                }
            }
        }
        
        header ("content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?><result><success>'.$success.'</success><message>'.$message.'</message></result>';
    }
    
    /**
    * Dung de tu dong backup du lieu review trong khi user dang typing review
    * trong truong hop bi tat cua so neu dang soan review
    * 
    */
    function autosaveAction()
    {
        $savedData = $_POST['fdata'];
        
        if($savedData != '')
        {
            $_SESSION['reviewAutosave'] = $savedData;
        }
    }
    
    
    /**
    * Lay cac review moi duoc using cho trang user
    * 
    * 
    */
    public function latestajaxAction()
    {
        $formData = array();
        $userid = (int)$_GET['id'];
        
        $formData['fuserid'] = $userid;
        
        $reviewList = Core_Review::getReviews($formData, 'id', 'DESC', $this->registry->setting['review']['sidebarQuantity'], false, true);
        
        $this->registry->smarty->assign(array(    'reviewList' => $reviewList,
                                                ));
        
        header ("content-type: text/xml");
        $this->registry->smarty->display($this->registry->smartyControllerContainer.'latestajax.tpl'); 
        
        
        
    }
    ###########################################################3
    ###########################################################3
    ###########################################################3 
    protected function addajaxValidator($formData, &$error)
    {
        $pass = true;
        
        if(isset($formData['freviewid']) && $formData['freviewid'] > 0)
        {
            $myReview = new Core_Review($formData['freviewid']);
            if($myReview->id > 0 && $myReview->parentid != 0)
            {
                $error[] = 'Review Not Found.';
                $pass = false;
            }
        }
        
        $strlen = mb_strlen($formData['fmessage'], 'utf-8');
        if($strlen < $this->registry->setting['review']['messageMinLength'])
        {
            $error[] = str_replace('###VALUE###', $this->registry->setting['review']['messageMinLength'], $this->registry->lang['controller']['errMessageTooShort']);
            $pass = false;
        }
        
        if($strlen > $this->registry->setting['review']['messageMaxLength'])
        {
            $error[] = str_replace('###VALUE###', $this->registry->setting['review']['messageMaxLength'], $this->registry->lang['controller']['errMessageTooLong']);
            $pass = false;
        }
        
        if($strlen > 0 && strcmp($formData['fmessage'], $_SESSION['previousReview']) == 0)
        {
            $pass = false;
            $error[] = $this->registry->lang['controller']['errDuplicate'];
        }
        
        //check spam
        if(isset($_SESSION['reviewSpam']) && $_SESSION['reviewSpam'] + $this->registry->setting['review']['spamExpired'] > time())
        {
            $pass = false;
            $error[] = $this->registry->lang['controller']['errSpam'];
        }
        
        return $pass;
    }
}

