<?php

Abstract Class Core_Chart_Base extends Core_Object
{
	private static $cacheEngine = null;

	public $title = '';
	public $showControls = true;
	public $showLegend = true;
	
	public function __construct()
	{
		if(self::$cacheEngine == null)
		{
			self::$cacheEngine = self::initCacheEngine();
		}
	}
	
	/**
	 * Init cacheEngine using single pattern
	 */
	public static function initCacheEngine()
	{
		$myCacheEngine = new Redis();
		$myCacheEngine->connect('127.0.0.1', 6379);
		
		return $myCacheEngine;
	}
	
	public static function getCacheEngine()
	{
		if(self::$cacheEngine == null)
		{
			self::$cacheEngine = self::initCacheEngine();
		}
		
		return self::$cacheEngine;
	}
	
	
	
	public function set($key, $value)
	{
		$myCacheEngine = self::getCacheEngine();
		$myCacheEngine->set($key, $value);
	}
	
	
	public function get($key)
	{
		$myCacheEngine = self::getCacheEngine();
		return $myCacheEngine->get($key);
	}
	
	
	public function extractDateRange($datestart, $dateend, $isUseHour = false)
	{
		$dates = array();
		
		$datediff = $dateend - $datestart;
		$numberOfDate = floor($datediff/(60*60*24));
		
		for($i = 0; $i <= $numberOfDate; $i++)
		{
			$dateCurrent = strtotime('+' . $i . ' day' . ($i > 1 ? 's' : ''), $datestart);
			
			$dateCurrentDetail = getdate($dateCurrent);
			$dateCurrentRefined = mktime(0,0,0, $dateCurrentDetail['mon'], $dateCurrentDetail['mday'], $dateCurrentDetail['year']);
			
			if($isUseHour)
			{
				for($j = 0; $j < 24; $j++)
				{
					$dateCurrentRefinedWithHour = mktime($j,0,0, $dateCurrentDetail['mon'], $dateCurrentDetail['mday'], $dateCurrentDetail['year']);
					$dates[] = $dateCurrentRefinedWithHour;
					//$dates[] = date('d/m/Y, H:i:s', $dateCurrentRefinedWithHour);
				}
			}
			else
			{
				$dates[] = $dateCurrentRefined;
				//$dates[] = date('d/m/Y, H:i:s', $dateCurrentRefined);
			}
			
			
		}
		
		return $dates;
	}
	
	

	/**
	 * Pull data from Stat Data Storage
	 * @param int $datestart: Timestamp of start date
	 * @param int $dateend: Timestamp of end date
	 * @return array timeseries with time
	 */
	abstract public function getData($datestart, $dateend, $type = 0, $objectid = 0);
	
	/**
	 * Push data to Stat Data Storage
	 */
	abstract public function collectData($datestart, $dateend);
	
	/**
	 * Return the List of Options valid for current Chart Type (can be empty if chart is general, such as Feed Count, Feed Comment...)
	 */
	abstract public function getTypeList();
	
	/**
	 * Because the dynamic of charting, we need a way to mapping chartname to a class for chart data set/get
	 */
	public static function getClassFromName($chartname)
	{
		$classname = '';
		switch($chartname)
		{
			case 'customer' : $classname = 'Core_Chart_Customer'; break;
		}
		
		return $classname;
	}
   
}

//for testing
// simulating REDIS
if(!class_exists('Redis')) 
{
    Class Redis
	{
		public function __construct()
		{
			
		}
		
		public function connect($ipaddress, $port)
		{
			
		}
		
		public function set($key, $value)
		{
			$_SESSION['redis'][$key] = $value;
		}
		
		public function get($key)
		{
			return $_SESSION['redis'][$key];
		}
	}
}