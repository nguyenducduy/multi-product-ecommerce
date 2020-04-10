<?php

Class Controller_Wse_Index Extends Controller_Wse_Base
{
    
	/**
	 * Set device for this client
	 */
    function indexAction()
	{
		$formData = $_POST;
		

		//Mobile Setting
		$deviceSettings = array();
		if(isset($formData['settingnotifyorder'])) $deviceSettings['notifyorder'] = (int)$formData['settingnotifyorder'];
		if(isset($formData['settingnotifycomment'])) $deviceSettings['notifycomment'] = (int)$formData['settingnotifycomment'];
		if(isset($formData['settingnotifymessage'])) $deviceSettings['notifymessage'] = (int)$formData['settingnotifymessage'];
		if(isset($formData['settingnotifyvibration'])) $deviceSettings['notifyvibration'] = (int)$formData['settingnotifyvibration'];
		

		/////////////////////////////////
		/////////////////////////////////
		// tracking device
		$deviceList = Core_Backend_MDevice::getMDevices(array('fdeviceid' => $formData['d']), '', '', 1);
		if(count($deviceList) > 0)
		{
			//update Information
			$myDevice = $deviceList[0];
			if($myDevice->uid != $this->registry->me->id && $this->registry->me->id > 0)
				$myDevice->uid = $this->registry->me->id;
			
			$myDevice->pushtrackerid = $formData['pushtrackerid'];	
			$myDevice->settingnotifyorder = $deviceSettings['notifyorder'];
			$myDevice->settingnotifycomment = $deviceSettings['notifycomment'];
			$myDevice->settingnotifymessage = $deviceSettings['notifymessage'];
			$myDevice->settingnotifyvibration = $deviceSettings['notifyvibration'];
			$myDevice->datelastaccessed = time();
			$myDevice->updateData();
		}
		else
		{
			//Device Not existed, this is new device, just insert device
			$myDevice = new Core_Backend_MDevice();
			$myDevice->uid = $this->registry->me->id;
			$myDevice->deviceid = $formData['d'];
			$myDevice->pushtrackerid = $formData['pushtrackerid'];
			$myDevice->platform = ($formData['platform'] == 1 || $formData['platform'] == 2) ? $formData['platform'] : 0;
			$myDevice->screenwidth = (int)$formData['width'];
			$myDevice->screenheight = (int)$formData['height'];
			$myDevice->appversion = $formData['version'];
			$myDevice->brand = $formData['brand'];
			$myDevice->name = $formData['name'];
			$myDevice->os = $formData['os'];
			$myDevice->settingnotifyorder = $deviceSettings['notifyorder'];
			$myDevice->settingnotifycomment = $deviceSettings['notifycomment'];
			$myDevice->settingnotifymessage = $deviceSettings['notifymessage'];
			$myDevice->settingnotifyvibration = $deviceSettings['notifyvibration'];
			$myDevice->datelastaccessed = time();
			$myDevice->addData();
		}
		
		///////////////////////////////////
		///////////////////////////////////
		// check session
		if(strlen($formData['s']) > 0)
			$sessionexpired = (Core_Backend_MSession::getMSessions(array('fsessionid' => $formData['s']), '', '', '', true) == 0);
		else
			$sessionexpired = true;
			
		
		
		//////////////////////////////////
		//////////////////////////////////
		// checking platform & version
		$info = array();
		$info['uid'] = $this->registry->me->id;
		$info['sessionexpired'] = $sessionexpired;
		$info['latestversion'] = '1.0';
		$info['needtoupgrade'] = false;
		$info['emergency'] = '';
		$info['message'] = '';
		
		//
		if($formData['platform'] == Core_Backend_MDevice::PLATFORM_ANDROID)
		{
			$this->checkPlatformAndroid($info, $formData);
		}
		elseif($formData['platform'] == Core_Backend_MDevice::PLATFORM_IOS)
		{
			$this->checkPlatformIos($info, $formData);
		}
		elseif($formData['platform'] == Core_Backend_MDevice::PLATFORM_WINDOWSPHONE)
		{
			$this->checkPlatformWindowsPhone($info, $formData);
		}
		
		$data = json_encode($info);
		echo $data;
	}
	
	//////////////
	//
	private function checkPlatformAndroid(&$info, $formData)
	{
		$info['latestversion'] = '1.0';
		$version = $formData['version'];
		
		if(version_compare($version, '1.0') >= 0)
		{
			//fine until now
		}
		
	}
	
	private function checkPlatformIos(&$info, $formData)
	{
		$info['latestversion'] = '1.0';
		$version = $formData['version'];
		
		if(version_compare($version, '1.0') >= 0)
		{
			//fine until now
		}
		
	}
	
	private function checkPlatformWindowsPhone(&$info, $formData)
	{
		$info['latestversion'] = '1.0';
		$version = $formData['version'];
		
		if(version_compare($version, '1.0') >= 0)
		{
			//fine until now
		}
		
	}

	
}

