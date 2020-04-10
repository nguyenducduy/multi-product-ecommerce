<?php

Abstract Class Controller_Cms_Base Extends Controller_Admin_Base
{
	protected function getRedirectUrl()
	{


		$redirectUrl = $this->registry->router->getArg('redirect');
		if(strlen($redirectUrl) > 0)
			$redirectUrl = base64_decode($redirectUrl);
		else
			$redirectUrl = $this->registry->conf['rooturl'] . $this->registry->controller;

		return $redirectUrl;
	}
}
