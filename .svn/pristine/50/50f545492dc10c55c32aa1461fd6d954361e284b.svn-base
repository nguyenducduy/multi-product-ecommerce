<?php

Class Core_FriendRequest extends Core_Object
{
	const STATUS_NEW = 1;
	const STATUS_RENEW = 5;
	const STATUS_HIDE = 10;

	public $uid = 0;
	public $uid_friend = 0;
	public $id = 0;
	public $status = 0;	// store request status, hide, private, discard...
	public $datecreated = 0;
	public $actor = null; 	//requestor // nguoi goi yeu cau ket ban

	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'friend_request(
					u_id,
					u_id_friend,
					fr_status,
					fr_datecreated
					)
				VALUES(?, ?, ?, ?)';

		$rowCount = $this->db->query($sql, array(
		    	(int)$this->uid,
		    	(int)$this->uid_friend,
		    	(int)$this->status,
		    	(int)$this->datecreated,

			))->rowCount();

		$this->id = $this->db->lastInsertId();

		return $this->id;
	}

	public function updateData()
	{
        $sql = 'UPDATE ' . TABLE_PREFIX . 'friend_request
        		SET fr_status = ?
        		WHERE fr_id = ?';

		$stmt = $this->db->query($sql, array(
				$this->status,
		    	$this->id
			));

		if($stmt)
			return true;
		else
			return false;
	}

	/**
	*
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'friend_request
        		WHERE fr_id =  ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	public static function countList($where)
	{
		global $db;
		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'friend_request fr
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON fr.u_id = u.u_id';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}


	public static function getList($where, $order, $limit = '')
	{
		global $db;

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'friend_request fr
				INNER JOIN ' . TABLE_PREFIX . 'ac_user u ON fr.u_id = u.u_id';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myFriendRequest = new Core_FriendRequest();
			$myFriendRequest->uid = $row['u_id'];
			$myFriendRequest->uid_friend = $row['u_id_friend'];
			$myFriendRequest->id = $row['fr_id'];
			$myFriendRequest->status = $row['fr_status'];
			$myFriendRequest->datecreated = $row['fr_datecreated'];
			$myFriendRequest->actor = new Core_User();
			$myFriendRequest->actor->initMainInfo($row);
			$outputList[] = $myFriendRequest;
		}
		return $outputList;
	}

	public static function getRequests($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fr.fr_id = '.(int)$formData['fid'].' ';

		if($formData['fuserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fr.u_id = '.(int)$formData['fuserid'].' ';

		if($formData['ffriendid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fr.u_id_friend = '.(int)$formData['ffriendid'].' ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			$whereString .= ($whereString != '' ? ' AND ' : '') . 'u.u_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'fullname')
			$orderString = ' u.u_fullname ' . $sorttype;
		else
			$orderString = ' fr.fr_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

}


