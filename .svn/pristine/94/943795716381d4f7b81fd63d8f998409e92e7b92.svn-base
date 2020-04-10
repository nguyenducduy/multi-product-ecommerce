<?php

Abstract Class Controller_Ws_Base Extends Controller_Core_Base 
{
	
	
	/**
	 * Used for login
	 */
	protected function loginSuccess(Core_User $myUser, $deviceid)
	{
		$mobilesessionid = Helper::getSessionId();
		
		//Find device
		$myDevice = new Core_Backend_MDevice();
		if(strlen($deviceid) > 0)
		{
			$deviceList = Core_Backend_MDevice::getMDevices(array('fdeviceid' => $deviceid), '', '', 1);
			if(count($deviceList) > 0)
				$myDevice = $deviceList[0];
		}
		
		
		//create mobile session id
		$mobileSessions = Core_Backend_MSession::getMSessions(array('fdeviceid' => $deviceid), 'id', 'DESC', 1);
		if(count($mobileSessions) == 1)
		{
			$myMobileSession = $mobileSessions[0];
			$myMobileSession->uid = $myUser->id;
			$myMobileSession->sessionid = $mobilesessionid;
			$myMobileSession->platform = $myDevice->platform;
			$myMobileSession->lastipaddress = Helper::getIpAddress(true);
			$myMobileSession->datelastaccessed = time();
			$myMobileSession->updateData();
		}
		else
		{	
			$myMobileSession = new Core_Backend_MSession();
			$myMobileSession->uid = $myUser->id;
			$myMobileSession->deviceid = $deviceid;
			$myMobileSession->sessionid = $mobilesessionid;
			$myMobileSession->platform = $myDevice->platform;
			$myMobileSession->ipaddress = Helper::getIpAddress(true);
			$myMobileSession->lastipaddress = Helper::getIpAddress(true);
			$myMobileSession->datelastaccessed = time();
			$myMobileSession->addData();
		}
		
		$myUser->updateLastLogin();
		
		return $mobilesessionid;
	}
	
	protected function jsonGeneralOutput($success, $message, $mobilesessionid, $uid = 0, $sessionexpired = false,$userinfo = True)
	{
		$info['sessionexpired'] = (boolean)$sessionexpired;
		$info['success'] = (boolean)$success;
		$info['message'] = (string)$message;
		$info['sessionid'] = (string)$mobilesessionid;
		$info['uid'] = (int)$uid;

		if($success == false || $userinfo == false)
			$info['user'] = array();
		else
			$info['user'] = $this->search($uid);
		
		echo json_encode($info);
		exit();
		
	}
	
	/**
	 * Detail User
	 */
	public function search($keyword)
    {

        $check = Core_User::getUsers($formData = array('fid'=>$keyword),'','',1);
        $user = $check[0];
        $region = new Core_Region($user->region, TRUE);
        $positionId = Core_UserEdge::getUserEdges($formData = array('fuidstart' => $keyword, 'ftype' => Core_UserEdge::TYPE_EMPLOY),'','',1);
        $positionName = new Core_HrmTitle($positionId[0]->point, TRUE);
        $departmentID = new Core_User($positionId[0]->uidend, TRUE);
        $items = array();
        if(empty($user))
        {
            return $items;
        }
        else
        {
            $items['uid']            = (int)$user->id;
            $items['idbcnb']         = (int)$user->oauthUid;
            $items['group']          = (int)$user->groupid;
            $items['gender']         = (int)$user->gender;
            $items['fullname']       = (string)ucwords($user->fullname);

            if($departmentID->groupid != 15)
            {
                $items['departmentid']   = 0;
                $items['departmentname'] = '';
            }
            else
            {
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

            if($this->registry->me->id == $user->id)
                $items['ipaddress']      = (string)Helper::getIpAddress();
            else
                $items['ipaddress']      = (string)$user->ipaddress;

            if($user->avatar == '')
                $items['avatar'] = '';
            else                 
                $items['avatar'] = (string)'http://a.tgdt.vn/'.$this->getSmallImage($user->avatar);   
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
        
	protected function sessionExpired()
	{
		$this->jsonGeneralOutput(false, '', '', 0, true);
		exit();
	}
	
}
