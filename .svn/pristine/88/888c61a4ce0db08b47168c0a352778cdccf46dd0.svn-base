<?php
Class Controller_Wse_Notification extends Controller_Wse_Base
{
    public function indexAction()
    {
        $pageget   = $_POST['p'];
        $recordget = $_POST['r'];
        $error     = array();
        if ($pageget > 0 && $recordget >0 ) {
            $start            = $recordget * ($pageget - 1);
            $limit            = $start.','.$recordget;

            $poster           = $this->registry->me;
            $formData         = array('freceiverid' => $poster->id);
            $notificationList = Core_Backend_Notification::getNotifications($formData, '', '', $limit);
            if (!empty($notificationList)) {
                //xu ly nang cao
                //thuat toan: combine cac notification giong nhau de tro thanh 1 notification combine
                $finalNotificationList = array();
                
                for($i = 0; $i < count($notificationList); $i++) {
                    //dieu kien de gom nhom notification
                    $idHash = $notificationList[$i]->getIdHash();
                    
                    if (isset($finalNotificationList[$idHash])) {
                        //grouping notification
                        //neu day la notification thu 2 trung, thi khoi tao danh sach actorList 
                        //de bao hieu bat dau grouping
                        if ($finalNotificationList[$idHash]->actorList == null) {
                            $finalNotificationList[$idHash]->actorList = array($finalNotificationList[$idHash]->actor);
                        }
                        $finalNotificationList[$idHash]->actorList[] = $notificationList[$i]->actor;
                    } else {
                        $finalNotificationList[$idHash] = $notificationList[$i];
                    }
                }
        //------------- End notification list
                
        /*---------Gom nhom theo ngay ------*/
                $notificationGroups = array();
                foreach($finalNotificationList as $notification) {
                    $notifieddate = date('d/m/Y', $notification->datecreated);
                    
                    if ($notifieddate == date('d/m/Y')) {
                        $notifieddate = $this->registry->lang['controller']['dategroupToday'];
                    } elseif ($notifieddate == date('d/m/Y', strtotime('-1 day'))) {
                        $notifieddate = $this->registry->lang['controller']['dategroupYesterday'];
                    }
                    
                    $notificationGroups[$notifieddate][] = $notification;
                  
                    $notify['user'] = $this->search($notification->actor->id);
                
                    $notify['type'] = (int)$notification->type;

                    if ($notification->data['pid'] == '') {
                        $notify['redirectobjectid'] = (int)$notification->actor->id;
                        $notify['avatarother'] = '';
                    } else {
                        $notify['redirectobjectid'] = (int)$notification->data['pid'];

                        if ($notification->data['pid'] > 0) {
                            $product = new Core_Product($notification->data['pid'],true);
                            $myProductCategory = new Core_Productcategory($product->pcid);
                            $productCategory = $myProductCategory->name;

                            if ($product->image == '') {
                                $notify['avatarother'] = '';
                            } else {
                                $notify['avatarother'] = 'http://p.tgdt.vn/'.$this->getSmallImage($product->image);
                            }
                        }
                    }
                    if ($notification->type == 10) {
                        $notify['text'] = $notification->actor->fullname . ' đã Follow bạn.';
                    }
                    if ($notification->type == 1) {
                        $notify['text'] = $notification->actor->fullname. ' viết lên trang nhà của bạn.';
                    }
                    if ($notification->type == 75) {
                        $notify['text'] = $notification->actor->fullname.' - Yêu cầu thêm phòng ban, Mã nhân viên:' .' A'.(int)$notification->data['objectid']. '. Mã BCNB : '.(int)$notify['user']['idbcnb'];
                    }
                    if ($notification->type == 201) {
                        $notify['text'] = $notification->actor->fullname.' - Thêm SP "' .$productCategory.'-'. html_entity_decode($product->name).'"';
                    }
                    if ($notification->type == 202) {
                        $notify['text'] = $notification->actor->fullname.' - Cập nhật SP "' .$productCategory.'-'. html_entity_decode($product->name).'"';
                    }

                    $notify['time'] = $this->time_ago($notification->datecreated);

                    $items['items'][] = $notify ;

                }
            } else {
                $items['items'] = $notificationList;
            }
        } else {
            $items['items'] = $error;
        }
        echo json_encode($items) ;
    }
    public function countAction()
    {
        //check main user or fanpage user
           
        $items['message'] = (int)$this->registry->me->newmessage;
        if ($this->registry->me->newmessage > 0) {
            //$this->registry->me->notificationReset('message');
        }

        $items['notification'] = (int)$this->registry->me->newnotification;
        if ($this->registry->me->newnotification > 0) {
            //$this->registry->me->notificationReset('notification');
        }
        echo json_encode($items);
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

        $pos = strrpos($image, '.');
        $extPart = substr($image, $pos+1);
        $namePart =  substr($image,0, $pos);
        $filesmall = $namePart . '-small.' . $extPart;
        $url = $filesmall;

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