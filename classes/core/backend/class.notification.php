<?php

Class Core_Backend_Notification extends Core_Backend_Object
{
	const TYPE_STATUS_ADD = 1;	//nhan duoc khi nguoi khac viet len tuong nha cua minh

	const TYPE_FEED_COMMENT = 5;	//nhan duoc khi minh la nguoi tao feed
	const TYPE_FEED_COMMENT_FOLLOW = 6;	// nhan duoc khi minh khong phai la chu feed ma la nguoi comment trong feed cua 1 ai do
	const TYPE_FEED_COMMENT_LIKE_FOLLOW = 4;	// nhan duoc khi minh khong phai la chu feed ma la nguoi comment trong feed cua 1 ai do
	const TYPE_FEED_LIKE = 7;	// nhan duoc khi minh la nguoi tao feed, va nguoi khac LIKE feed nay
	const TYPE_FEED_LIKE_FOLLOW = 8;	// nhan duoc khi minh khong phai la nguoi tao feed, va minh "chi" nam trong danh sach LIKE
	const TYPE_FEED_LIKE_COMMENT_FOLLOW = 9;	// nhan duoc khi minh khong phai la nguoi tao feed, nhung minh co binh luan feed nay va nguoi khac thank feed nay
	const TYPE_FRIENDREQUEST_ACCEPT = 10;
	const TYPE_SYSTEM_NOTIFY = 75;

	const TYPE_MENTION_STATUS = 131;	//nhan duoc khi nguoi khac tag minh vao status
	const TYPE_MENTION_STATUSLINK = 132;	//nhan duoc khi nguoi khac tag minh vao status
	const TYPE_MENTION_FEEDCOMMENT = 133;	//nhan duoc khi nguoi khac tag vao feed comment

	const TYPE_PRODUCT_ADD = 201;
	const TYPE_PRODUCT_EDIT = 202;

	public $uid = 0;
	public $uidreceive = 0;
	public $id = 0;
	public $type = 0;
	public $data = null;
	public $datecreated = 0;
	public $dateupdated = 0;
	public $actor = null;
	public $actorList = null;	//neu co xay ra combine notification, thi day la danh sach cac actor thao tac cung 1 action

	public $idHashString = '';	//moi notification se co 1 hash, neu detect hash giong nhau thi co nghia la co notification giong nhau (ve type, data, feed id...), dung de giup viec hien thi tot hon, ko hien nhieu duplicated. Tuy theo loai notification ma se co cong thuc tinh hashstringkhac nhau de detect trung



	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}


	public function addData()
	{
		$this->datecreated  = time();
		$this->dateupdated = 0;	//chua read nen  = 0
		$this->desktopversionUrl();	//remove 'm' in url if send from mobile

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'notification(
					u_id,
					u_id_receive,
					n_type,
					n_serialized_data,
					n_datecreated,
					n_dateupdated
					)
				VALUES(?, ?, ?, ?, ?, ?)';

		$rowCount = $this->db3->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uidreceive,
		    	(int)$this->type,
		    	(string)serialize($this->data),
		    	(int)$this->datecreated,
		    	(int)$this->dateupdated
			))->rowCount();

		$this->id = $this->db3->lastInsertId();

		return $this->id;
	}

	/**
	* Optimize de insert nhieu notification 1 luc
	*
	* @param array $receiverList
	*/
	public function addDataToMany($receiverList)
	{
		if(count($receiverList) > 0)
		{
			sort($receiverList);

			$this->datecreated  = time();
			$this->dateupdated = 0;	//chua read nen  = 0
			$this->desktopversionUrl();
			$serializedData = (string)serialize($this->data);
			$insertCount = 0;

			//de dam bao query khong bi qua dai
			//do su dung cau truc INSERT ..VALUES(...), (...), (...)
			//nen segment receiver list theo 1 segment size nao do de lam ngan cau query
			$segmentSize = 50;	//50 userids trong 1 segment
			$segments = array_chunk($receiverList, $segmentSize);
			for($i = 0, $count = count($segments); $i < $count; $i++)
			{
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'notification(
							u_id,
							u_id_receive,
							n_type,
							n_serialized_data,
							n_datecreated,
							n_dateupdated
							)
						VALUES';

				for($j = 0, $countj = count($segments[$i]); $j < $countj; $j++)
				{
					if($j > 0)
						$sql .= ', ';
					$sql .= '(?, ?, ?, ?, ?, ?) ';
				}

				$stmt = $this->db3->prepare($sql);


				//bind data
				for($j = 0, $countj = count($segments[$i]); $j < $countj; $j++)
				{
					$stmt->bindValue($j * 6 + 1, (int)$this->uid);
					$stmt->bindValue($j * 6 + 2, $segments[$i][$j]);
					$stmt->bindValue($j * 6 + 3, (int)$this->type);
					$stmt->bindValue($j * 6 + 4, (string)$serializedData);
					$stmt->bindValue($j * 6 + 5, (int)$this->datecreated);
					$stmt->bindValue($j * 6 + 6, (int)$this->dateupdated);
				}
				//execute prepared query
				$stmt->execute();
				$insertCount += $stmt->rowCount();
			}

			return $insertCount;
		}
		else
		{
			return false;
		}

	}


	/**
	*
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'notification
        		WHERE n_id =  ? ';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public function updateData()
	{
		$this->dateupdated = time();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'notification
				SET n_dateupdated = ?
        		WHERE n_id =  ? ';
		$rowCount = $this->db3->query($sql, array( $this->dateupdated,$this->id))->rowCount();

		return $rowCount;
	}

	/**
	* Ham dung de update trang thai da doc cho tat ca cac notification cua 1 user sau khi ho da load notification
	* Thuong duoc goi sau khi load ajax notification trong bottombar
	* @param int $receiveid
	*/
	public static function updateReadStatus($receiveid)
	{
		$db3 = self::getDb();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'notification
				SET n_dateupdated = ?
        		WHERE u_id_receive =  ?
					AND n_dateupdated = 0';
		$rowCount = $db3->query($sql, array( time(), (int)$receiveid))->rowCount();
	}

	private function getData($id)
	{
		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'notification n
				WHERE n_id = ? ';
		$row = $this->db3->query($sql, array((int)$id))->fetch();
		$this->uid = $row['u_id'];
		$this->uidreceive = $row['u_id_receive'];
		$this->id = $row['n_id'];
		$this->type = $row['n_type'];
		$this->data = unserialize($row['n_serialized_data']);
		$this->datecreated = $row['n_datecreated'];
		$this->dateupdated = $row['n_dateupdated'];
		$this->actor = new Core_User($row['u_id'], true);

		$this->mobileversionUrl();
	}

	public function getIdHash()
	{
		return $this->type . '.' . $this->id;
	}

	public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'notification n';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
    }

	public static function getList($where, $order, $limit = '')
	{
		$db3 = self::getDb();

		$outputList = array();
		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'notification n';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myNotification = Core_Backend_Notification::factory($row['n_type']);
			$myNotification->uid = $row['u_id'];
			$myNotification->uidreceive = $row['u_id_receive'];
			$myNotification->id = $row['n_id'];
			$myNotification->type = $row['n_type'];
			$myNotification->data = unserialize($row['n_serialized_data']);
			$myNotification->datecreated = $row['n_datecreated'];
			$myNotification->dateupdated = $row['n_dateupdated'];
			$myNotification->actor = new Core_User($row['u_id'], true);
			$myNotification->mobileversionUrl();
			$outputList[] = $myNotification;
		}


		return $outputList;
	}

	public static function getNotifications($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_id = '.(int)$formData['fid'];

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id = '.(int)$formData['fuserid'];

		if($formData['freceiverid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id_receive = '.(int)$formData['freceiverid'];

		if($formData['ftype'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_type = '.(int)$formData['ftype'].' ';

		if(isset($formData['funread']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_dateupdated = 0 ';
		}

		$orderString = ' n.n_id DESC';

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	* Tra ve loai class tuong ung voi notification type
	* dung de load notification ra de hien thi
	*
	*/
	public static function factory($type)
	{
		$myNotification = null;
		switch($type)
		{
			case self::TYPE_STATUS_ADD: $myNotification = new Core_Backend_Notification_StatusAdd(); break;
			case self::TYPE_FEED_COMMENT: $myNotification = new Core_Backend_Notification_FeedComment(); break;
			case self::TYPE_FEED_COMMENT_FOLLOW: $myNotification = new Core_Backend_Notification_FeedCommentFollow(); break;
			case self::TYPE_FEED_COMMENT_LIKE_FOLLOW: $myNotification = new Core_Backend_Notification_FeedCommentLikeFollow(); break;
			case self::TYPE_FEED_LIKE: $myNotification = new Core_Backend_Notification_FeedLike(); break;
			case self::TYPE_FEED_LIKE_COMMENT_FOLLOW: $myNotification = new Core_Backend_Notification_FeedLikeCommentFollow(); break;
			case self::TYPE_FEED_LIKE_FOLLOW: $myNotification = new Core_Backend_Notification_FeedLikeFollow(); break;
			case self::TYPE_FRIENDREQUEST_ACCEPT: $myNotification = new Core_Backend_Notification_FriendRequestAccept(); break;
			case self::TYPE_SYSTEM_NOTIFY: $myNotification = new Core_Backend_Notification_SystemNotify(); break;

			case self::TYPE_MENTION_STATUS: $myNotification = new Core_Backend_Notification_MentionStatus(); break;
			case self::TYPE_MENTION_STATUSLINK: $myNotification = new Core_Backend_Notification_MentionStatusLink(); break;
			case self::TYPE_MENTION_FEEDCOMMENT: $myNotification = new Core_Backend_Notification_MentionFeedComment(); break;

			case self::TYPE_PRODUCT_ADD: $myNotification = new Core_Backend_Notification_ProductAdd(); break;
			case self::TYPE_PRODUCT_EDIT: $myNotification = new Core_Backend_Notification_ProductEdit(); break;

			default: $myNotification = new Core_Backend_Notification();
		}

		return $myNotification;
	}


	/**
	* Hien thi noi dung notification ra ben ngoai
	*
	* de cho cac class con ke thua
	*
	*/
	public function showDetail(){}




	////////////////////////////////////////////////////////////////////
	//	NOTIFICATION LIST ID CACHE

	/**
	* Kiem tra xem 1 NOLIST da duoc cache chua
	*
	* @param mixed $userid
	*/
	public static function cacheCheckNotificationList($userid)
	{
		$cacheKeystring = self::cacheBuildKeystringNotificationList($userid);

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
	* Lay danh sach notification LIST cua user tu he thong cache
	*/
	public static function cacheGetNotificationList($userid, &$cacheSuccess = false, $forceStore = false, $formData = array(), $limit = 10)
	{
		$db3 = self::getDb();

		$cacheKeystring = self::cacheBuildKeystringNotificationList($userid);
		$notificationList = array();
		//get current cache
		$myCacher = new Cacher($cacheKeystring);
		$notificationListRawData = $myCacher->get();


		//var_dump($row);

		//force to store new value
		if(!$notificationListRawData || isset($_GET['live']) || $forceStore)
		{
			$notificationListRawData = array();

			$whereString = '';
			if($formData['freceiverid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id_receive = '.(int)$formData['freceiverid'];

			if(isset($formData['funread']))
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_dateupdated = 0 ';

			$sql = 'SELECT *
					FROM ' . TABLE_PREFIX . 'notification n
					WHERE '.$whereString.'
					ORDER BY n.n_id DESC
					LIMIT ' . $limit .'';

			$stmt = $db3->query($sql);
			while($row = $stmt->fetch())
				$notificationListRawData[] = $row;

			//store new value
			$cacheSuccess = self::cacheSetNotificationList($userid, $notificationListRawData);


		}

		//build object list
		if(!empty($notificationListRawData))
		{
			foreach($notificationListRawData as $row)
			{
				$myNotification = Core_Backend_Notification::factory($row['n_type']);
				$myNotification->uid = $row['u_id'];
				$myNotification->uidreceive = $row['u_id_receive'];
				$myNotification->id = $row['n_id'];
				$myNotification->type = $row['n_type'];
				$myNotification->data = unserialize($row['n_serialized_data']);
				$myNotification->datecreated = $row['n_datecreated'];
				$myNotification->dateupdated = $row['n_dateupdated'];
				$myNotification->actor = new Core_User($row['u_id'], true);
				$myNotification->mobileversionUrl();
				$notificationList[] = $myNotification;
			}
		}

		return $notificationList;
	}

	/**
	* Luu thong tin vao cache
	*
	*/
	public static function cacheSetNotificationList($userid, $value)
	{
		global $registry;

		$myCacher = new Cacher(self::cacheBuildKeystringNotificationList($userid));
		return $myCacher->set($value, $registry->setting['apc']['shortDelay']);
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $userid
	*/
	public static function cacheDeleteNotificationList($userid)
	{
		$myCacher = new Cacher(self::cacheBuildKeystringNotificationList($userid));
		return $myCacher->clear();
	}

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $userid
	*/
	public static function cacheBuildKeystringNotificationList($userid)
	{
		return 'usernotificationlist_'.$userid;
	}


	//	--end -- NOTIFICATION LIST CACHE
	////////////////////////////////////////////////////////////////////

	/**
	 * Convert URL in reader.vn for mobile version
	 */
	public function mobileversionUrl()
	{
		if(SUBDOMAIN == 'm')
		{
			foreach($this->data as $key => $value)
			{
				$this->data[$key] = str_replace('https://ecommerce.kubil.app', 'http://m.dienmay.com', $value);
			}
		}
	}

	public function desktopversionUrl()
	{
		foreach($this->data as $key => $value)
		{
			$this->data[$key] = str_replace('http://m.dienmay.com', 'https://ecommerce.kubil.app', $value);
		}
	}
}



