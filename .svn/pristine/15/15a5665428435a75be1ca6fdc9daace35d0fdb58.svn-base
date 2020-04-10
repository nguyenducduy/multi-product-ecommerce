<?php

Class Core_Backend_Friend extends Core_Backend_Object
{
	const TYPE_FOLLOWING = 0;
	const TYPE_ADMIN = 1;
	const TYPE_CUSTOM = 5;

	public $uid = 0;
	public $uid_friend = 0;
	public $id = 0;
	public $type = 0;
	public $titleid = 0;
	public $datecreated = 0;
	public $actor = null; 	//friend data
	public static $followingStatusStore = array();

	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'friend(
					u_id,
					u_id_friend,
					f_type,
					f_titleid,
					f_datecreated
					)
				VALUES(?, ?, ?,?, ?)';

		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uid_friend,
		    	(int)$this->type,
		    	(int)$this->titleid,
		    	(int)$this->datecreated,
			))->rowCount();

		$this->id = $this->db3->lastInsertId();

		return $this->id;
	}


	/**
	*
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'friend
        		WHERE f_id =  ? ';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	/**
	*
	* un-following a user
	* userid-friendid
	*
	* @param int $userid
	* @param int $friendid
	*/
	public static function deleteFollowing($userid, $followinguserid)
	{
		$db3 = self::getDb();

		$userid = (int)$userid;
		$friendid = (int)$friendid;
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'friend
				WHERE u_id = ? AND u_id_friend = ?';
		$rowCount = $db3->query($sql, array($userid, $followinguserid))->rowCount();

		return $rowCount;
	}

	/**
	* Following a user
	*
	* Why INSERT IGNORE? neu khong de ignore co the dau do trong table da co record tuong ung,
	* nhung vi UNIQUE uid_uidfriend nen se error nua chung, dung ignore de khong bi stuck nua chung
	* @param int $userid
	* @param int $friendid
	*/
	public static function addFollowing($userid, $followinguserid, $type = 0)
	{
		$db3 = self::getDb();

		$userid = (int)$userid;
		$followinguserid = (int)$followinguserid;
		$timeadd = time();
		$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'friend(u_id, u_id_friend, f_type, f_datecreated)
				VALUES(?,?,?, ?)
				';
		$rowCount = $db3->query($sql, array($userid, $followinguserid, $type, $timeadd))->rowCount();

		return $rowCount;
	}

	/**
	* Ham kiem tra xem 2 user co phai la ban cua nhau khong
	*
	* @param mixed $userid
	* @param mixed $friendid
	*/
	public static function checkFollowing($userid, $followinguserid)
	{
		$db3 = self::getDb();

		//because the performance of following checking
		//we need to check following in global cache, so
		//if we not cache, just check and store to cache
		//if we cache, just use the result of previous checking
		$storeString = $userid . '_' . $followinguserid;
		if(isset(self::$followingStatusStore[$storeString]))
			return self::$followingStatusStore[$storeString];
		else
		{
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'friend
					WHERE u_id = ? AND u_id_friend = ?';
			$connection = $db3->query($sql, array($userid, $followinguserid))->fetchColumn(0);
			$result = ($connection >= 1);

			self::$followingStatusStore[$storeString] = $result;
			return $result;
		}


	}

	public static function countList($where)
    {
        $db3 = self::getDb();

       $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'friend f';


        if($where != '')
			$sql .= ' WHERE ' . $where;



        return $db3->query($sql)->fetchColumn(0);
    }

	public static function getListFollower($where, $order, $limit = '')
	{
		$db3 = self::getDb();

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'friend f';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myFriend = new Core_Backend_Friend();
			$myFriend->uid = (int)$row['u_id'];
			$myFriend->uid_friend = (int)$row['u_id_friend'];
			$myFriend->id = (int)$row['f_id'];
			$myFriend->type = (int)$row['f_type'];
			$myFriend->titleid = (int)$row['f_titleid'];
			$myFriend->datecreated = (int)$row['f_datecreated'];
			$myFriend->actor = new Core_User($row['u_id'], true);
			$outputList[] = $myFriend;
		}
		return $outputList;
	}


	public static function getList($where, $order, $limit = '')
	{
		$db3 = self::getDb();

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'friend f
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON f.u_id_friend = u.u_id';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myFriend = new Core_Backend_Friend();
			$myFriend->uid = $row['u_id'];
			$myFriend->uid_friend = $row['u_id_friend'];
			$myFriend->id = $row['f_id'];
			$myFriend->type = $row['f_type'];
			$myFriend->titleid = $row['f_titleid'];
			$myFriend->datecreated = $row['f_datecreated'];
			$myFriend->actor = new Core_User($row['u_id_friend'], true);//using friendid to init data for friend
			$outputList[] = $myFriend;
		}
		return $outputList;
	}

	public static function getFriends($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $getFollower = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['ffriendid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.u_id_friend = '.(int)$formData['ffriendid'].' ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		$orderString = ' f.f_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		elseif($getFollower)
			return self::getListFollower($whereString, $orderString, $limit);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getFriendIds($userid)
	{
		$db3 = self::getDb();

		$userid = (int)$userid;

		$friendIdList = array();

		if($userid > 0)
		{
			$friendIdList = self::cacheGetFriendIds($userid);

		}

		return $friendIdList;
	}

	////////////////////////////////////////////////////////////////////
	//	FRIENDLIST ID CACHE

	/**
	* Kiem tra xem 1 userid da duoc cache chua
	*
	* @param mixed $userid
	*/
	public static function cacheCheckFriendIds($userid)
	{
		$cacheKeystring = self::cacheBuildKeystringFriendIds($userid);

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
	* Lay danh sach friend ID cua user tu he thong cache
	*
	* Neu store array thi rat ton memory,
	* Chuyen sang store string, roi dung cac ham explode de lay ra lai
	* VD: Co 187 friend, neu store array thi ton 12326byte, con neu store string thi chi mat 977byte -> tiet kiem 97%
	*/
	public static function cacheGetFriendIds($userid, &$cacheSuccess = false, $forceStore = false)
	{
		$db3 = self::getDb();

		$cacheKeystring = self::cacheBuildKeystringFriendIds($userid);

		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$friendIdListString = $myCacher->get();


		//force to store new value
		if(!$friendIdListString || isset($_GET['live']) || $forceStore)
		{
			$friendIdList = array();

			$sql = 'SELECT u_id_friend FROM ' . TABLE_PREFIX . 'friend f
					WHERE f.u_id = '.$userid.' ';

			$stmt = $db3->query($sql);
			while($row = $stmt->fetch())
				$friendIdList[] = $row['u_id_friend'];

			$friendIdListString = implode(',', $friendIdList);

			//store new value
			$cacheSuccess = self::cacheSetFriendIds($userid, $friendIdListString);
		}
		else
		{
			$friendIdList = explode(',', $friendIdListString);
		}
		return $friendIdList;
	}

	/**
	* Luu thong tin vao cache
	*
	*/
	public static function cacheSetFriendIds($userid, $value)
	{
		global $registry;

		$myCacher = new Cacher(self::cacheBuildKeystringFriendIds($userid));
		return $myCacher->set($value, $registry->setting['site']['apcUserCacheTimetolive']);
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $userid
	*/
	public static function cacheDeleteFriendIds($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystringFriendIds($userid));
		return $myCacher->clear();
	}

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $userid
	*/
	public static function cacheBuildKeystringFriendIds($userid)
	{
		return 'userfriendids_'.$userid;
	}


	//	--end -- FRIENDLIST ID CACHE
	////////////////////////////////////////////////////////////////////

}


