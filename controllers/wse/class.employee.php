
<?php
Class Controller_Wse_Employee extends Controller_Wse_Base
{
   
    public function indexAction() 
    {

        $keyword = Helper::xss_clean($_POST['keyword']);

        $pageget = $_POST['p'];
        $recordget = $_POST['r'];

        $departmentget = $_POST['departmentid'];
        $start = $recordget * ($pageget - 1);
        $limit = $start.','.$recordget;

        if ($pageget > 0 && $recordget > 0) {
            if ($departmentget == 0) {
                /*---- search normal not follow department---*/
                if ($keyword == '') {
                    $formData = array('fgroupidlist' => array(1,2,3,5), 'fMoauthUid'=> 0);
                    $list = Core_User::getUsers($formData,'id','ASC', $limit);
                    if (!empty($list)) {
                        foreach($list as $user) {
                            $details = $this->search($user->id);
                            if(!empty($details))
                                $res['items'][] = $details;
                        }
                    } else {
                        $res['items'] = array();
                    }
                } else {
                    if (is_numeric(str_replace(' ', '', $keyword))) {
                        $formData = array('fNum' => str_replace(' ', '', $keyword), 'fgroupidlist' => array(1,2,3,5) , 'fMoauthUid'=> 0);
                        $list = Core_User::getUsers($formData,'','ASC', $limit);
                        if (!empty($list)) {
                            foreach($list as $user) {
                                $details = $this->search($user->id);
                                if (!empty($details)) {
                                    $res['items'][] = $details;
                                }
                            }
                        } else {
                            $res['items'] = array();
                        }
                    } else {
                        $formData = array('fString' => $keyword, 'fgroupidlist' => array(1,2,3,5), 'fMoauthUid'=> 0);
                        $list = Core_User::getUsers($formData,'','ASC', $limit);
                        if (!empty($list)) {
                            foreach($list as $user) {
                                $details = $this->search($user->id);
                                if(!empty($details))
                                    $res['items'][] = $details;
                            }
                        } else {
                            $res['items'] = array();
                        }
                    }
                }
            } else {
            /*---- search normal follow department---*/
                if ($keyword == '') {
                    $formData = array('fuidend' => $departmentget,'ftype' => Core_UserEdge::TYPE_EMPLOY);
                    $list = Core_UserEdge::getUserEdges($formData, '', '', $limit);
                    if (!empty($list)) {
                        foreach($list as $find) {
                            $res['items'][] = $this->search($find->uidstart);
                        }
                    } else {
                        $res['items'] = array();
                    }
                    
                } else {
                    $formData = array('fuidend' => $departmentget,'ftype' => Core_UserEdge::TYPE_EMPLOY);
                    $list = Core_UserEdge::getUserEdges($formData, '', '', '');
                    if (!empty($list)) {
                        foreach($list as $id) {
                            $idList[] = $id->uidstart;
                        }

                        if (is_numeric(str_replace(' ', '', $keyword))) {
                            $user = Core_User::getUsers($formData = array('fids' => implode(',', $idList), 'fNum' => str_replace(' ', '', $keyword)),'','ASC',$limit);
                            foreach ($user as $value)  {
                                if (!empty($value)) {
                                    $res['items'][] = $this->search($value->id);
                                } else {
                                    $res['items'] = array();
                                }
                            }
                        } else {
                            $user = Core_User::getUsers($formData = array('fids' => implode(',', $idList), 'fString' => $keyword),'','ASC',$limit);
                            foreach ($user as $value) {
                                if (!empty($value)) {
                                    $res['items'][] = $this->search($value->id);
                                } else {
                                    $res['items'] = array();
                                }
                            }
                        }
                    } else {
                        $res['items'] = array();
                    }
                }
            }
        }

        echo json_encode($res);
    }
    public function detailAction()
    {
        $id = $_POST['id'];
        $items['user'] = $this->search($id);
        if (!empty($items['user'])) {
            $followed  = Core_UserEdge::getUserEdges($formdata = array('fuidstart' => $this->registry->me->id,'fuidend' => $id),'','',1);
            if (!empty($followed)) {
                $items['isfollowed'] = True;
            } else {
                $items['isfollowed'] = False;
            }
        } else {
            $items = $items['user'];
        }

        echo json_encode($items);
    }
    public function followingAction()
    {

        $userview  = $_POST['id'];
        $userid    = $this->registry->me->id;
        $pageget   = $_POST['p'];
        $recordget = $_POST['r'];
        $error     = array();
        
        if ($pageget >0 && $recordget > 0 && $userid >0) {
            $start = $recordget * ($pageget - 1);
            $limit = $start.','.$recordget;
            if ($userview == $userid) {
                ///////////////////list following of user login //////////////////////////////
                $formdata = array('fuidstart' => $userid,
                                    'ftype' => Core_UserEdge::TYPE_FOLLOW);

                $following  = Core_UserEdge::getUserEdges($formdata,'id','DESC',$limit);
                if (!empty($following)) {
                    foreach($following as $follow) {
                        $item['user']       = $this->search($follow->uidend);
                        $item['isfollowed'] = TRUE;
                        $items['items'][]   = $item;
                    }
                } else {
                    $items['items'] = $following;
                }
            } else {
                /////////// list following of user view //////////////////////
                $formdata = array('fuidstart' => $userview,
                                    'ftype' => Core_UserEdge::TYPE_FOLLOW);

                $following  = Core_UserEdge::getUserEdges($formdata,'id','DESC',$limit);
                if (!empty($following)) {
                    foreach($following as $follow) {
                        $item['user'] = $this->search($follow->uidend);
                        $checkfollow  = Core_UserEdge::isFollowing($userid, $follow->uidend);
                        if ($checkfollow) {
                            $item['isfollowed'] = TRUE; 
                        } else {
                            $item['isfollowed'] = FALSE;
                        }

                        $items['items'][] = $item;
                    }
                } else {
                    $items['items'] = $following;
                }
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items); 
    }
    public function followerAction()
    {

        $userview  = $_POST['id'];
        $userid    = $this->registry->me->id;
        $error     = array();
        $pageget   = $_POST['p'];
        $recordget = $_POST['r'];
        
        if ($pageget >0  && $recordget > 0 && $userid > 0) {
            $start = $recordget * ($pageget - 1);
            $limit = $start.','.$recordget;
            if ($userview == $userid) {
                $formdata = array('fuidend' => $userid, 'ftype' => Core_UserEdge::TYPE_FOLLOW);

                $follower  = Core_UserEdge::getUserEdges($formdata,'id','DESC',$limit);
                if (!empty($follower)) {
                    foreach($follower as $follow) {

                        $item['user']       = $this->search($follow->uidstart);
                        //// kiem tra co follow hay chua /////////////////////////////                 
                        $checkfollow = Core_UserEdge::isFollowing($userid, $follow->uidstart);
                        if ($checkfollow) {
                            $item['isfollowed'] = TRUE; 
                        } else {
                            $item['isfollowed'] = FALSE;
                        }

                        $items['items'][] = $item;
                    }
                } else {
                    $items['items'] = $follower;
                }
            } else {
                $formdata = array('fuidend' => $userview, 'ftype' => Core_UserEdge::TYPE_FOLLOW);

                $follower  = Core_UserEdge::getUserEdges($formdata,'id','DESC',$limit);
                if (!empty($follower)) {
                    foreach($follower as $follow) {
                        $item['user']       = $this->search($follow->uidstart);
                        //// kiem tra co follow hay chua /////////////////////////////                 
                        $checkfollow = Core_UserEdge::isFollowing($userid, $follow->uidstart);
                        if ($checkfollow) {
                            $item['isfollowed'] = TRUE; 
                        } else {
                            $item['isfollowed'] = FALSE;
                        }

                        $items['items'][] = $item;
                    }
                } else {
                    $items['items'] = $follower;
                }
            }
        } else {
            $items['items'] = $error;
        }

        echo json_encode($items);
    }
    public function followAction()
    {
        $user = $this->registry->me->id;
        $userfollow = $_POST['user'];

        $myPartner = new Core_User($userfollow , true);

        /////////////////kiem tra follow hay chua/////////////////
        $checkfollow = Core_UserEdge::isFollowing($user, $userfollow);

        if ($checkfollow) {
            $message = TRUE;
        } else {
        //////////////////tien hanh them /////////////////////////////           
            $myUserEdge = new Core_UserEdge();
            $myUserEdge->uidstart = $user;
            $myUserEdge->uidend = $userfollow;

            $myUserEdge->type = Core_UserEdge::TYPE_FOLLOW;

            if ($myUserEdge->addData()) {
                $message = TRUE;
                //update stat of user
                $this->registry->me->updateCounting(array('following'));
                $myPartner->updateCounting(array('follower'));

                //create feed
                $myFeedFollowAdd = new Core_Backend_Feed_FollowAdd();
                $myFeedFollowAdd->uid = $user;
                $myFeedFollowAdd->uidreceive = $userfollow;
                $myFeedFollowAdd->addData();

                //create notification cho nguoi da goi loi moi ket ban
                $myNotificationFriendRequestAccept = new Core_Backend_Notification_FriendRequestAccept();
                $myNotificationFriendRequestAccept->uid = $user;
                $myNotificationFriendRequestAccept->uidreceive = $userfollow;

                    //increase notification count for receiver
                if($myNotificationFriendRequestAccept->addData())
                    Core_User::notificationIncrease('notification', array($myNotificationFriendRequestAccept->uidreceive));
                
                //update Date last action
                $this->registry->me->updateDateLastaction();	

                //update homefeedids
                Core_Backend_Feed::cacheDeleteHomeFeedIds($user);
                Core_Backend_Feed::cacheDeleteHomeFeedIds($userfollow);

            } else {
                $message = FALSE;
            }
        }

        //////// kiem tra session ///////////    
        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($message,'',$_POST['s'], $this->registry->me->id, $sessionexpired,False);
    }
    public function activityAction()
    {
        $user      = (int)$_POST['user'];
        $pageget   = $_POST['p'];
        $recordget = $_POST['r'];
        $error     = array();
        $start     = $recordget * ($pageget - 1);
        $limit     = $start.','.$recordget;

        $checkUser = new Core_User($user);

        if ($checkUser->id != '') {
            $myFollowingIdList = $checkUser->getFullFollowingList();

            //add ME to this list
            $myFollowingIdList[] = $user;

            //lay cac feed trong cache
            $homeFeedIdList = Core_Backend_Feed::getHomeFeedIds($checkUser->id, array('fuseridlist' => $myFollowingIdList), $limit);

            if (!empty($homeFeedIdList)) {
                foreach ($homeFeedIdList as $key => $value) {
                    $myFeed = Core_Backend_Feed::cacheGet($value); 
                    if ($myFeed->id > 0 && !in_array($myFeed->uid, array())) {
                        if($this->registry->me->id == $user) {
                            ////actor////
                            $items['actor']['uid']      = (int)$myFeed->actor->id;
                            $items['actor']['fullname'] = (string)$myFeed->actor->fullname;
                            if ($myFeed->actor->avatar == '') {
                                $items['actor']['avatar'] = '';
                            } else {
                                $items['actor']['avatar'] = 'http://a.tgdt.vn/'.$this->getSmallImage($myFeed->actor->avatar);
                            }

                            ////recevier/////
                            $items['receiver']['uid']      = (int)$myFeed->receiver->id;
                            $items['receiver']['fullname'] = (string)$myFeed->receiver->fullname;
                            if ($myFeed->receiver->avatar == '') {
                                $items['receiver']['avatar'] = '';
                            } else {
                                $items['receiver']['avatar'] = 'http://a.tgdt.vn/'.$this->getSmallImage($myFeed->receiver->avatar);
                            }

                            if ($myFeed->type == 45) {
                                $items['type'] = 1;
                            } elseif ($myFeed->type == 30) {
                                $items['type'] = 2;
                            } elseif ($myFeed->type == 35) {
                                $items['type'] = 3;
                            }

                            $items['data']     = (string)$myFeed->data['message'];
                            $items['time']     = (string)$this->time_ago($myFeed->datecreated);
                            $item['items'][]   = $items;

                        } else {
                            ////actor////
                            $items['actor']['uid']      = (int)$myFeed->actor->id;
                            $items['actor']['fullname'] = (string)$myFeed->actor->fullname;
                            if ($myFeed->actor->avatar == '') {
                                $items['actor']['avatar'] = '';
                            } else {
                                $items['actor']['avatar'] = 'http://a.tgdt.vn/'.$this->getSmallImage($myFeed->actor->avatar);
                            }

                            ////recevier/////
                            $items['receiver']['uid']      = (int)$myFeed->receiver->id;
                            $items['receiver']['fullname'] = (string)$myFeed->receiver->fullname;
                            if ($myFeed->receiver->avatar == '') {
                                $items['receiver']['avatar'] = '';
                            } else {
                                $items['receiver']['avatar'] = 'http://a.tgdt.vn/'.$this->getSmallImage($myFeed->receiver->avatar);
                            }

                            if ($myFeed->type == 45) {
                                $items['type'] = 1;
                            } elseif ($myFeed->type == 30) {
                                $items['type'] = 2;
                            } elseif ($myFeed->type == 35) {
                                $items['type'] = 3;
                            }

                            $items['data']     = (string)$myFeed->data['message'];
                            $items['time']     = (string)$this->time_ago($myFeed->datecreated);
                            $item['items'][]   = $items;
                        }
                    }
                }
            } else {
                $item['items'] = $error;
            }    
        } else {
            $item['items'] = $error;
        }
        ///////////////End of fuction/////////////////////
        echo json_encode($item);
    }
    public function unfollowAction()
    {
        $id = $_POST['user'];

        $myPartner = new Core_User($id,true);
        
        $remove = Core_UserEdge::removeFollowing($this->registry->me->id,$myPartner->id);

        if ($remove) {
            $message = TRUE;
            //update homefeedids
            Core_Backend_Feed::cacheDeleteHomeFeedIds($this->registry->me->id);
            Core_Backend_Feed::cacheDeleteHomeFeedIds($myPartner->id);

            //update stat of user
            $this->registry->me->updateCounting(array('following'));
            $myPartner->updateCounting(array('follower'));
        }
        //////// kiem tra session ///////////    
        if (strlen($_POST['s']) > 0) {
            $sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $_POST['s']), '', '', '', true) == 0);
        } else {
            $sessionexpired = true;
        }

        $this->jsonGeneralOutput($message,'',$_POST['s'], $this->registry->me->id, $sessionexpired,False);
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
                $items['ipaddress']      = (string)Helper::getIpAddress();
            } else {
                $items['ipaddress']      = (string)$user->ipaddress;
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
