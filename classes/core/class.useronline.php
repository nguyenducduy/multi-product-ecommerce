<?php

Class Core_UserOnline extends Core_Object
{
	const STATUS_OFFLINE = 0;
	const STATUS_IDLE = 3;
	const STATUS_ONLINE = 5;

	public $id = 0;


	public function __construct($id = 0)
	{
		parent::__construct();
		$this->id = $id;

	}

	public static function isOnline($userid)
	{
		return self::cacheCheck($userid);
	}

	public static function setonline($userid)
	{
		return self::cacheSet($userid, time());
	}

	public static function getOnlineStatus($userid)
	{
		global $setting;

		$status = '';

		$datecreated = self::cacheGet($userid);
		//Admin is always..Offline :)
		if($datecreated == 0 || $userid == 1)
		{
			$status = 'offline';
		}
		else
		{
			//tim thay 	record, chung to user nay dang co trang thai online
			//kiem tra xem user nay vua online hay online lau de hien thi idle
			if(time() - $setting['user']['idleTimeout'] <= $datecreated)
			{
				$status = 'online';
			}
			else
			{
				$status = 'idle';
			}
		}

		return $status;
	}


	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	//	CACHE MAIN INFO
	/**
	* Kiem tra xem 1 userid da duoc cache chua
	*
	* @param mixed $userid
	*/
	public static function cacheCheck($userid)
	{
		$cacheKeystring = self::cacheBuildKeystring($userid);
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		if(!empty($row))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	/**
	* Lay thong tin user tu he thong cache
	* danh cho he thong ko phai join voi table user
	*
	*/
	public static function cacheGet($userid)
	{
		global $db;

		$cacheKeystring = self::cacheBuildKeystring($userid);

		$myCacher = new Cacher($cacheKeystring);
		return $myCacher->get();
	}

	/**
	* Luu thong tin vao cache
	*
	*/
	public static function cacheSet($userid, $value)
	{
		global $registry;

		$myCacher = new Cacher(self::cacheBuildKeystring($userid));
		return $myCacher->set($value, $registry->setting['apc']['onlinestatusTimeout']);
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $userid
	*/
	public static function cacheDelete($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystring($userid));
		return $myCacher->clear();
	}

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $userid
	*/
	public static function cacheBuildKeystring($userid)
	{
		return 'useronline_'.$userid;
	}
	//	end -- CACHE MAIN INFO
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////






}



