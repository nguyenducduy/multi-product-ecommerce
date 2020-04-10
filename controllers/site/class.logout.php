<?php

Class Controller_Site_Logout Extends Controller_Site_Base 
{
	
	function indexAction() 
	{
		session_regenerate_id(true);
		session_destroy();
		
		setcookie('myHashing', "", time()-3600, '/');   
		
		//Neu current user login from facebook
		
		if($this->registry->me->oauthPartner == Core_User::OAUTH_PARTNER_FACEBOOK)
		{
			//clear cookie
			$facebookCookieName = 'fbs_' . $this->registry->setting['facebook']['appid'];
			setcookie($facebookCookieName, '', time() - 3600);
    		unset($_COOKIE[$facebookCookieName]);       
		}
		elseif($this->registry->me->oauthPartner == Core_User::OAUTH_PARTNER_YAHOO)
		{
			//require 'libs/yahoo/Yahoo.inc';
			//YahooSession::clearSession();
		}  

		//clear islogin cookie
		setcookie('islogin', '', time() - 3600);
		
		header('location: ' . $this->registry->conf['rooturl'] . 'login');

		//clear online status
		Core_UserOnline::cacheDelete($this->registry->me->id);
		
		//clear current location
		Core_UserLocation::deleteFromUser($this->registry->me->id);
	} 
}

