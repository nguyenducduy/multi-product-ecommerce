<?php

Class Registry Implements ArrayAccess 
{
	private $vars = array();
	public static $base_dir = '';
	
	function __construct() 
	{
	}

	function set($key, $var) 
	{
		$this->vars[$key] = $var;
		return true;
	}

	function get($key) 
	{
		if (isset($this->vars[$key]) == false) 
		{
			return null;
		}

		return $this->vars[$key];
	}
	
	function __set($key, $var)
	{
		$this->vars[$key] = $var;
		return true;
	}
	
	function __get($key)
	{
		if (isset($this->vars[$key])) 
		{
			return $this->vars[$key];
		}

		return null;
	}

	function remove($var) 
	{
		unset($this->vars[$key]);
	}

	function offsetExists($offset) 
	{
		return isset($this->vars[$offset]);
	}

	function offsetGet($offset) 
	{
		return $this->get($offset);
	}

	function offsetSet($offset, $value) 
	{
		$this->set($offset, $value);
	}

	function offsetUnset($offset) 
	{
		unset($this->vars[$offset]);
	}
	
	/**
    * Ham xu ly tinh toan de tra ve ROOT URL cua Resource 
    * 
    * De lam giam tai cho main site
    * Co the xu ly cai tien cho phep su dung CDN voi nhieu domain
    * Hien tai chi co 1 domain la r-img.com duoc cau hinh trong file include/config.php ma thoi
    * nen return ve gia tri nay luon
    * 
    * @param string $type: loai resource de co the cau hinh duong dan resource cho tot hon dua vao loai resource
    * - 1 so loai resource la: static (css, img, js cua template), book cover (cover,thumb) va user avatar (big,small,medium)
    * 
    */
    public function getResourceHost($type = '')
    {
    	global $conf, $setting, $registry;
    	
    	$path = '';

		if($type == 'static')
		{
			if($GLOBALS['controller_group'] == 'site')
			{
				if($registry->https)
					$path = $setting['resourcehost']['static_1_https'];
				else
					$path = $setting['resourcehost']['static_1'];
			}
			else
			{
				if($registry->https)
					$path = $setting['resourcehost']['static_https'];
				else
					$path = $setting['resourcehost']['static'];
			}
		}
		else if(isset($setting['resourcehost'][$type]))
		{
			if($registry->https && isset($setting['resourcehost'][$type . '_https']))
				$path = $setting['resourcehost'][$type . '_https'];
			else
				$path = $setting['resourcehost'][$type];
		}
		else
		{
			if($registry->https && isset($setting['resourcehost']['general_https']))
				$path = $setting['resourcehost']['general_https'];
			else
				$path = $setting['resourcehost']['general'];
		}
    	
    	return $path;
	}
}

