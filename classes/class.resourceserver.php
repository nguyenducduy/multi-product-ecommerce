<?php

class ResourceServer
{
	public static function getUrl($resourceid, $type = '')
	{
		global $registry;
		
		$rooturl = '';
		if($resourceid == 0)
		{
			
			$rooturl = $registry->conf['rooturl'];

			/*
			//hardcode because using nfs on all webserver to .40 static server
			if($type == 'product' || $type == 'productmedia')
				$rooturl = 'http://p.tgdt.vn/';
			elseif($type == 'avatar')
				$rooturl = 'http://a.tgdt.vn/';
			else
				$rooturl = 'https://ecommerce.kubil.app/';
			*/
		}
		elseif($resourceid == 1)
		{
			$rooturl = $registry->conf['rooturl'];
		}
		else
		{
			$rooturl = $registry->conf['rooturl'];
		}
		
		return $rooturl;
	}
}