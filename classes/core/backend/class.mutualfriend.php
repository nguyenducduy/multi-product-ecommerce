<?php

Class Core_Backend_Mutualfriend extends Core_Backend_Object
{
	public $id = 0;
	public $mutualfriendlist = array();		//danh sach userid de xuat ket ban dua vao ban be chung
	public $mutualfriendhidelist = array();	//danh sach userid duoc an boi user tu danh sach userid co ban be chung
	
	public function __construct($id = 0)
	{
		parent::__construct($id);                
		
		if($id > 0)
			$this->getData($id);
	}
	
	public function addData()
	{
		$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'mutual_friend(
					u_id,
					fr_list_mutualfriend,
					fr_hide_mutualfriend
					)
				VALUES(?, ?, ?)';  
				
		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->id,
		    	(string)$this->unparseMutuallist($this->mutualfriendlist),
		    	(string)implode(',', $this->mutualfriendhidelist),
			))->rowCount();
			
		
		return $rowCount;
	}
	
	public function updateData()
	{             
		$this->datemodified = time();  
        $sql = 'UPDATE ' . TABLE_PREFIX . 'mutual_friend
        		SET fr_list_mutualfriend = ?,
        			fr_hide_mutualfriend = ?
        		WHERE u_id = ?';
        		
		$stmt = $this->db3->query($sql, array(
		    	(string)$this->unparseMutuallist($this->mutualfriendlist),
		    	(string)implode(',', $this->mutualfriendhidelist),
		    	$this->id
			));
			
		if($stmt->rowCount() > 0)
			return true;
		else
			return false;
	}
	
	public function getData($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'mutual_friend
				WHERE u_id = ? ';
		$row = $this->db3->query($sql, array((int)$id))->fetch();
		$this->id = $row['u_id'];
		$this->mutualfriendlist = $this->parseMutuallist($row['fr_list_mutualfriend']);
		$this->mutualfriendhidelist = $this->refineArray(explode(',', $row['fr_hide_mutualfriend']));
	}
	
	public function initInfo($row)
	{
		$this->id = $row['u_id'];
		$this->mutualfriendlist = $this->parseMutuallist($row['fr_list_mutualfriend']);
		$this->mutualfriendhidelist = $this->refineArray(explode(',', $row['fr_hide_mutualfriend']));
	}
	
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'mutual_friend
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
		if(($listtype == 'all' || $listtype == 'mutualfriend') && isset($this->mutualfriendlist[$userid]))
			unset($this->mutualfriendlist[$userid]);
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
			case 'mutualfriendhide': if(!in_array($userid, $this->mutualfriendhidelist)) $this->mutualfriendhidelist[] = $userid; break;
		}
	}	
	
	public function unparseMutuallist($list)
	{
		$string = '';
		if(count($list) > 0)
		{
			$rgroup = array();
			foreach($list as $k => $v)
			{
				$rgroup[] = $k.':'.$v;
			}
			$string = implode(';', $rgroup);
		}
		return $string;
	}
	
	public function parseMutuallist($string)
	{
		$list = array();
		
		preg_match_all('/(\d+):(\d+)/', $string, $matches);
		for($i = 0; $i < count($matches[0]); $i++)
		{
			$list[$matches[1][$i]] = $matches[2][$i];
		}
		
		return $list;
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
	* Kiem tra xem 1 mutual friend of user da duoc cache chua
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
		
		$myMutualfriend = new Core_Backend_Mutualfriend();
		
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'mutual_friend
					WHERE u_id = ? ';
			$row = $db3->query($sql, array($userid))->fetch();
			if($row['u_id'] > 0)
			{
				$myMutualfriend->initInfo($row);
				
				//store new value
				$cacheSuccess = self::cacheSet($userid, $row);
			}
		}
		else
		{
			$myMutualfriend->initInfo($row);
		}
		
		return $myMutualfriend;
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
		return 'mutualfriend_'.$userid;
	}	
   
	
}



