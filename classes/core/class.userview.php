<?php

Class Core_UserView extends Core_Object
{

	const TYPE_PROFILE = 1;
	const TYPE_FOLLOWING = 2;
	const TYPE_FOLLOWER = 3;
	const TYPE_BLOG = 4;
	const TYPE_LANDING = 5;

	public $uid = 0;
	public $uid_receiver = 0;
	public $id = 0;
	public $type = 0;
	public $useragent = '';
	public $referer = '';
	public $ipaddress = 0;
	public $sid = '';	//session id de tracking viec dang nhap thuong xuyen
	public $datecreated = 0;
	public $actor = null;

	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->useragent = $_SERVER['HTTP_USER_AGENT'];
		$this->referer = $_SERVER['HTTP_REFERER'];
		$this->sid = Helper::getSessionId();
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ac_user_view(
					u_id,
					u_id_receiver,
					uv_type,
					uv_useragent,
					uv_referer,
					uv_ipaddress,
					uv_sid,
					uv_datecreated
					)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?)';

		$rowCount = $this->db->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uid_receiver,
		    	(int)$this->type,
		    	(string)$this->useragent,
		    	(string)$this->referer,
		    	(int)Helper::getIpAddress(true),
		    	(string)$this->sid,
		    	(int)$this->datecreated
			))->rowCount();

		$this->id = $this->db->lastInsertId();

		return $this->id;
	}


	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ac_user_view
        		WHERE uv_id =  ? ';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public static function countList($where, $getUserDetail = false)
    {
        global $db;

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user_view uv';

        if($getUserDetail)
			$sql .= ' LEFT JOIN ' . TABLE_PREFIX . 'ac_user u ON uv.u_id = u.u_id ';

        if($where != '')
			$sql .= ' WHERE ' . $where;

        return $db->query($sql)->fetchColumn(0);
    }

	public static function getList($where, $order, $limit = '', $getUserDetail = false)
	{
		global $db;

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ac_user_view uv
				';

		if($getUserDetail)
			$sql .= ' LEFT JOIN ' . TABLE_PREFIX . 'ac_user u ON uv.u_id = u.u_id ';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myUserView = new Core_UserView();
			$myUserView->uid = $row['u_id'];
			$myUserView->uid_receiver = $row['u_id_receiver'];
			$myUserView->id = $row['uv_id'];
			$myUserView->type = $row['uv_type'];
			$myUserView->useragent = $row['uv_useragent'];
			$myUserView->referer = $row['uv_referer'];
			$myUserView->ipaddress = long2ip($row['uv_ipaddress']);
			$myUserView->sid = $row['uv_sid'];
			$myUserView->datecreated = $row['uv_datecreated'];

			if($getUserDetail)
			{
				$myUserView->actor = new Core_User();
				$myUserView->actor->initMainInfo($row);
			}


			$outputList[] = $myUserView;
		}
		return $outputList;
	}

	public static function getViews($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $getUserDetail = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'uv.uv_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'uv.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['fuseridreceiver'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'uv.u_id_receiver = '.(int)$formData['fuseridreceiver'].' ';

		if($formData['ftypeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'uv.uv_type = '.(int)$formData['ftypeid'].' ';

		$orderString = ' uv.uv_id DESC';


		if($countOnly)
			return self::countList($whereString, $getUserDetail);
		else
			return self::getList($whereString, $orderString, $limit, $getUserDetail);
	}



}


