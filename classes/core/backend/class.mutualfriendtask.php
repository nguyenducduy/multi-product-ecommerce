<?php

Class Core_Backend_MutualfriendTask extends Core_Backend_Object
{
	public $id = 0;
	public $friendlist = array();		//danh sach userid dang la ban
	public $friendrequestlist = array();		//danh sach userid ma user nay da goi request ket ban
	public $mutualfriendhidelist = array();	//danh sach userid duoc an boi user tu danh sach userid co ban be chung
	public $revision = 0;
	public $isdone = 0;
	
	public function __construct($id = 0)
	{
		parent::__construct($id);                
		
		if($id > 0)
			$this->getData($id);
	}
	
	public function addData()
	{
		$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'mutual_friend_task(
					u_id,
					u_id_friendlist,
					u_id_friendrequestlist,
					u_id_hidelist_mutualfriend,
					t_revision,
					t_isdone
					)
				VALUES(?, ?, ?, ?, ?, ?)';  
				
		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->id,
		    	(string)implode(',', $this->friendlist),
		    	(string)implode(',', $this->friendrequestlist),
		    	(string)implode(',', $this->mutualfriendhidelist),
		    	(int)$this->revision,
		    	(int)$this->isdone,
			))->rowCount();
			
		
		return $rowCount;
	}
	
	public function updateData()
	{             
		$this->datemodified = time();  
        $sql = 'UPDATE ' . TABLE_PREFIX . 'mutual_friend_task
        		SET u_id_friendlist = ?,
        			u_id_friendrequestlist = ?,
        			u_id_hidelist_mutualfriend = ?,
        			t_revision = ?,
        			t_isdone = ?
        		WHERE u_id = ?';
        		
		$stmt = $this->db3->query($sql, array(
				(string)implode(',', $this->friendlist),
				(string)implode(',', $this->friendrequestlist),
		    	(string)implode(',', $this->mutualfriendhidelist),
		    	(int)$this->revision,
		    	(int)$this->isdone,
		    	$this->id
			));
			
		if($stmt)
			return true;
		else
			return false;
	}
	
	public function getData($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'mutual_friend_task
				WHERE u_id = ? ';
		$row = $this->db3->query($sql, array((int)$id))->fetch();
		$this->id = $row['u_id'];
		$this->friendlist = $this->refineArray(explode(',', $row['u_id_friendlist']));
		$this->friendrequestlist = $this->refineArray(explode(',', $row['u_id_friendrequestlist']));
		$this->mutualfriendhidelist = $this->refineArray(explode(',', $row['u_id_hidelist_mutualfriend']));
		$this->revision = $row['t_revision'];
		$this->isdone = $row['t_isdone'];
	}
	
	public function initInfo($row)
	{
		$this->id = $row['u_id'];
		$this->friendlist = $this->refineArray(explode(',', $row['u_id_friendlist']));
		$this->friendrequestlist = $this->refineArray(explode(',', $row['u_id_friendrequestlist']));
		$this->mutualfriendhidelist = $this->refineArray(explode(',', $row['u_id_hidelist_mutualfriend']));
		$this->revision = $row['t_revision'];
		$this->isdone = $row['t_isdone'];
	}
	
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'mutual_friend_task
        		WHERE u_id =  ? ';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();
		
		return $rowCount;
	}
	
	/**
	* Remove 1 user khoi danh sach cac list
	* 
	* @param int $userid
	*/
	public function removeFromList($userid, $listtype = 'all')
	{
		if(($listtype == 'all' || $listtype == 'friend') && ($pos = array_search($userid, $this->friendlist)) !== false)
			unset($this->friendlist[$pos]);
		if(($listtype == 'all' || $listtype == 'friendrequest') && ($pos = array_search($userid, $this->friendrequestlist)) !== false)
			unset($this->friendlist[$pos]);
		if(($listtype == 'all' || $listtype == 'mutualfriendhide') && ($pos = array_search($userid, $this->mutualfriendhidelist)) !== false)
			unset($this->mutualfriendhidelist[$pos]);
	}	
	
	/**
	* Them 1 user vao danh sach cu the
	* 
	* @param int $userid
	*/
	public function addToList($userid, $listtype)
	{
		switch($listtype)
		{
			case 'friend': if(!in_array($userid, $this->friendlist)) $this->friendlist[] = $userid; break;
			case 'friendrequest': if(!in_array($userid, $this->friendrequestlist)) $this->friendrequestlist[] = $userid; break;
			case 'mutualfriendhide': if(!in_array($userid, $this->mutualfriendhidelist)) $this->mutualfriendhidelist[] = $userid; break;
		}
	}	
	
	
	
	//loai bo cac phan tu co chuoi rong
	public function refineArray($arr)
	{
		$refinedArr = array();
		foreach($arr as $k => $v)
		{
			if(strlen(trim($v)) > 0)
			{
				$refinedArr[] = $v;
			}
		}
		return $refinedArr;
	}
	
	
	/**
	* Kiem tra xem 1 mutual friend task of user da duoc cache chua
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
			return $row;
		}
		else
		{
			return false;
		}
		
	}
	
	/**
	* Lay thong tin mutual friend tu he thong cache
	* 
	*/
	public static function cacheGet($userid, &$cacheSuccess = false, $forceStore = false)
	{
		$db3 = self::getDb();
		
		$cacheKeystring = self::cacheBuildKeystring($userid);
		
		$myMutualfriendTask = new Core_Backend_MutualfriendTask();
		
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();
		
		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'mutual_friend_task
					WHERE u_id = ? ';
			$row = $db3->query($sql, array($userid))->fetch();
			if($row['u_id'] > 0)
			{
				$myMutualfriendTask->initInfo($row);
				
				//store new value
				$cacheSuccess = self::cacheSet($userid, $row);
			}
		}
		else
		{
			$myMutualfriendTask->initInfo($row);
		}
		
		return $myMutualfriendTask;
	}
	
	/**
	* Luu thong tin vao cache
	* 
	*/
	public static function cacheSet($userid, $value)
	{
		global $registry;
		
		$myCacher = new Cacher(self::cacheBuildKeystring($userid));
		return $myCacher->set($value, $registry->setting['site']['apcUserCacheTimetolive']);
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
		return 'mutualfriendtask_'.$userid;
	}	
	
	
}



