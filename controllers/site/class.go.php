<?php

Class Controller_Site_Go Extends Controller_Site_Base 
{
	
	function indexAction() 
	{
		if($this->registry->mobiledetect->isMobile() && $this->registry->mobiledetect->isBot())
		{
			echo '<a href="'.$this->registry->conf['rooturl'].'">'.$this->registry->conf['rooturl'].'</a>';
		}
		else
		{
			$id = (int)$_GET['id'];

			$myAds = new Core_Ads($id);
			if($myAds->id > 0)
			{
				//for performance, we use background job to save the banner click
				$url = $this->registry->conf['rooturl'] . 'go/bannerclick?id=' . $myAds->id;

				//append param for this request
				$url .= '&uid=' . (int)$this->registry->me->id;
				$url .= '&aid=' . $myAds->id;
				$url .= '&referer=' . urlencode($_SERVER['HTTP_REFERER']);
				$url .= '&ua=' . urlencode($_SERVER['HTTP_USER_AGENT']);
				$url .= '&ip=' . Helper::getIpAddress(true);
				$platform = 0;
				if($this->registry->mobiledetect->isMobile())
				{
					if($this->registry->mobiledetect->isTablet())
					{
						$platform = Core_Backend_AdsClick::PLATFORM_TABLET;
					}
					else
					{
						$platform = Core_Backend_AdsClick::PLATFORM_MOBILE;
					}
				}
				else
				{
					$platform =  Core_Backend_AdsClick::PLATFORM_DESKTOP;
				}
				$url .= '&platform=' . $platform;

				Helper::backgroundHttpGet($url);

				//Redirect to correct url of selected banner
				header('location: ' . $myAds->link);
			}
			else
				$this->notfound();
			
		}
		
	} 
	
	//tracking ads banner click
	function bannerclickAction()
	{
		$id = (int)$_GET['id'];
		$uid = (int)$_GET['uid'];
		$aid = (int)$_GET['aid'];
		$referer = urldecode($_GET['referer']);
		$useragent = urldecode($_GET['ua']);
		$ip = $_GET['ip'];
		$platform = $_GET['platform'];
		
		//detect spam/fraud
		$limitSpamDurationSeconds = 3;
		
		//neu trong khoang thoi gian cach day 3 giay ma goi 3 request khac thi coi nhu day la spam, ko luu nua
		$count = Core_Backend_AdsClick::getAdsClicks(array('fipaddress' => $ip, 'fdatestart' => time() - $limitSpamDurationSeconds), '', '', '', true);
		if($count < 3)
		{
			$myAdsClick = new Core_Backend_AdsClick();
			$myAdsClick->uid = $uid;
			$myAdsClick->aid = $aid;
			$myAdsClick->referer = $referer;
			$myAdsClick->useragent = $useragent;
			$myAdsClick->ipaddress = $ip;
			$myAdsClick->platform = $platform;
			$myAdsClick->fraudstatus = Core_Backend_AdsClick::FRAUDSTATUS_VALID;
			$myAdsClick->addData();
			
			//update counting of this banner
			$totalClick = Core_Backend_AdsClick::getAdsClicks(array('faid' => $aid), '', '', '', true);
			$myAds = new Core_Ads($aid);
			$myAds->click = $totalClick;
			$myAds->updateData();
		}
		else
		{
			//notify administrator of this user
			//Todo:
		}
		
		
	}
}

