<?php

Abstract Class Controller_Connection_Base extends Controller_Core_Base
{
    public function getRedirectUrl()
    {
        $redirectUrl = $this->registry->router->getArg('redirect');
		
		if(strlen($redirectUrl) > 0)
			$redirectUrl = base64_decode ($redirectUrl);
		else
			$redirectUrl = $this->registry['rooturl'] . $this->registry->controller;
		
		return $redirectUrl;
    }
}
