<?php

Class Core_GoogleAnalytics extends Core_Object
{
	private $username;
	private $password;
	private $profileid;
	
	protected $analytics;
	
	public function __construct($username = '', $password = '')
	{
		
		// construct the class
		if($username != '')
			$this->username = $username;
			
		if($password != '')
			$this->password = $password;
			
		
		

	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function getPassword($password)
	{
		$this->password = $password;
	}
	
	public function init()
	{
		$this->analytics = new gapi($this->username, $this->password);
	}
	
	/**
	 * Because the dynamic of charting, we need a way to mapping chartname to a class for chart data set/get
	 */
	public static function getClassFromName($chartname)
	{
		$classname = '';
		switch($chartname)
		{
			case 'visit' : $classname = 'Core_GoogleAnalytics_Visit'; break;
			case 'visitor' : $classname = 'Core_GoogleAnalytics_Visitor'; break;
			case 'newvisit' : $classname = 'Core_GoogleAnalytics_NewVisit'; break;
			case 'bounce' : $classname = 'Core_GoogleAnalytics_Bounce'; break;
			case 'pageview' : $classname = 'Core_GoogleAnalytics_PageView'; break;
			case 'uniquepageview' : $classname = 'Core_GoogleAnalytics_UniquePageView'; break;
			case 'avgtimeonsite' : $classname = 'Core_GoogleAnalytics_AvgTimeOnSite'; break;
			case 'avgtimeonpage' : $classname = 'Core_GoogleAnalytics_AvgTimeOnPage'; break;
			case 'browser' : $classname = 'Core_GoogleAnalytics_Browser'; break;
			case 'operatingsystem' : $classname = 'Core_GoogleAnalytics_OperatingSystem'; break;
			case 'screenresolution' : $classname = 'Core_GoogleAnalytics_ScreenResolution'; break;
			case 'city' : $classname = 'Core_GoogleAnalytics_City'; break;
			case 'pagepath' : $classname = 'Core_GoogleAnalytics_PagePath'; break;
			case 'referrer' : $classname = 'Core_GoogleAnalytics_Referrer'; break;
		}
		
		return $classname;
	}
	
	public static function cacheGetData($classname, $dateRangeStart, $dateRangeEnd)
	{
		if(isset($_GET['live']))
			return false;
		else
		{
			$myCacher = new Cacher(self::cacheGetKey($classname, $dateRangeStart, $dateRangeEnd));
			return $myCacher->get();
		}
	}
	
	public static function cacheSetData($classname, $dateRangeStart, $dateRangeEnd, $value)
	{
		global $registry;
		
		$myCacher = new Cacher(self::cacheGetKey($classname, $dateRangeStart, $dateRangeEnd));
		return $myCacher->set($value, $registry->setting['site']['apcUserCacheTimetolive']);
	}
	
	
	public static function cacheGetKey($classname, $dateRangeStart, $dateRangeEnd)
	{
		return 'gapi:' . $classname . ':' . date('Ymd', $dateRangeStart) . ':' . date('Ymd', $dateRangeEnd);
	}
	
}