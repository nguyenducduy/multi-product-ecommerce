<?php

Class Core_Contact extends Core_Object
{
	public $id;
	public $fullname = '';
	public $email = '';
	public $phone = '';
	public $reason = 'general';
	public $message = '';
	public $ipaddress = 0;
	public $status = 'new';
	public $note = '';
	public $datecreated = 0;


	public function __construct($id = 0)
	{
		parent::__construct($id);

		if($id > 0)
			$this->getData($id);
	}

	public function addData()
	{
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'contact(
					c_fullname,
					c_email,
					c_phone,
					c_reason,
					c_message,
					c_ipaddress,
					c_status,
					c_note,
					c_datecreated)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';

		$rowCount = $this->db->query($sql, array(
		    	(string)$this->fullname,
		    	(string)$this->email,
		    	(string)$this->phone,
		    	(string)$this->reason,
		    	(string)$this->message,
		    	(int)Helper::getIpAddress(true),
		    	(string)$this->status,
		    	(string)$this->note,
		    	$this->datecreated
			))->rowCount();

		$this->id = $this->db->lastInsertId();

		return $this->id;
	}


	/**
	*
	*/
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'contact
        		WHERE c_id =  ? ';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

	private function getData($id)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'contact c
				WHERE c_id = ? ';
		$row = $this->db->query($sql, array((int)$id))->fetch();
		$this->id = $row['c_id'];
		$this->fullname = $row['c_fullname'];
		$this->email = $row['c_email'];
		$this->phone = $row['c_phone'];
		$this->reason = $row['c_reason'];
		$this->message = $row['c_message'];
		$this->ipaddress = long2ip($row['c_ipaddress']);
		$this->status = $row['c_status'];
		$this->note = $row['c_note'];
		$this->datecreated = $row['c_datecreated'];
	}

	public function updateData()
	{
        $sql = 'UPDATE ' . TABLE_PREFIX . 'contact
        		SET c_fullname = ?,
        			c_email = ?,
        			c_phone = ?,
        			c_reason = ?,
        			c_message = ?,
        			c_status = ?,
        			c_note = ?
        		WHERE c_id = ?';

		$stmt = $this->db->query($sql, array(
				(string)$this->fullname,
				(string)$this->email,
				(string)$this->phone,
				(string)$this->reason,
				(string)$this->message,
				(string)$this->status,
				(string)$this->note,
		    	$this->id
			));

		if($stmt)
			return true;
		else
			return false;
	}

	public static function countList($where)
	{
		global $db;
		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'contact c';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}

	public static function getList($where, $order, $limit = '')
	{
		global $db;

		$outputList = array();
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'contact c';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myContact = new Core_Contact();
			$myContact->id = $row['c_id'];
			$myContact->fullname = $row['c_fullname'];
			$myContact->email = $row['c_email'];
			$myContact->phone = $row['c_phone'];
			$myContact->reason = $row['c_reason'];
			$myContact->message = $row['c_message'];
			$myContact->ipaddress = long2ip($row['c_ipaddress']);
			$myContact->status = $row['c_status'];
			$myContact->note = $row['c_note'];
			$myContact->datecreated = $row['c_datecreated'];

			$outputList[] = $myContact;
		}
		return $outputList;
	}

	public static function getContacts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_id = '.(int)$formData['fid'].' ';

		if($formData['freason'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_reason = "'.Helper::unspecialtext($formData['freason']).'" ';

		if($formData['fstatus'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . ' c.c_status = "'.Helper::unspecialtext($formData['fstatus']).'" ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'note')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_note LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'ipaddress')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_ipaddress = '.(int)ip2long($formData['fkeywordFilter']).'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_message LIKE \'%'.$formData['fkeywordFilter'].'%\'';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		if($sortby == 'reason')
			$orderString = ' c.c_reason ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = ' c.c_status ' . $sorttype ;
		else
			$orderString = ' c.c_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}





}


