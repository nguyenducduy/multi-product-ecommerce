<?php

/**
 * core/class.accesstickettype.php
 *
 * File contains the class used for AccessTicketType Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_AccessTicketType extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $id = 0;
	public $groupcontroller = "";
	public $controller = "";
	public $action = "";
	public $name = "";
	public $description = "";
	public $status = 0;
	public $ipaddress = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'access_ticket_type (
					att_groupcontroller,
					att_controller,
					att_action,
					att_name,
					att_description,
					att_status,
					att_ipaddress,
					att_datecreated,
					att_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->groupcontroller,
					(string)$this->controller,
					(string)$this->action,
					(string)$this->name,
					(string)$this->description,
					(int)$this->status,
					(int)Helper::getIpAddress(true),
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'access_ticket_type
				SET att_groupcontroller = ?,
					att_controller = ?,
					att_action = ?,
					att_name = ?,
					att_description = ?,
					att_status = ?,
					att_ipaddress = ?,
					att_datecreated = ?,
					att_datemodified = ?
				WHERE att_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->groupcontroller,
					(string)$this->controller,
					(string)$this->action,
					(string)$this->name,
					(string)$this->description,
					(int)$this->status,
					(int)Helper::getIpAddress(true),
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}

	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'access_ticket_type att
				WHERE att.att_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['att_id'];
		$this->groupcontroller = $row['att_groupcontroller'];
		$this->controller = $row['att_controller'];
		$this->action = $row['att_action'];
		$this->name = $row['att_name'];
		$this->description = $row['att_description'];
		$this->status = $row['att_status'];
		$this->ipaddress = long2ip($row['att_ipaddress']);
		$this->datecreated = $row['att_datecreated'];
		$this->datemodified = $row['att_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'access_ticket_type
				WHERE att_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'access_ticket_type att';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}

	/**
	 * Get the record in the table with paginating and filtering
	 *
	 * @param string $where the WHERE condition in SQL string
	 * @param string $order the ORDER in SQL string
	 * @param string $limit the LIMIT in SQL string
	 */
	public static function getList($where, $order, $limit = '')
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'access_ticket_type att';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myAccessTicketType = new Core_AccessTicketType();

			$myAccessTicketType->id = $row['att_id'];
			$myAccessTicketType->groupcontroller = $row['att_groupcontroller'];
			$myAccessTicketType->controller = $row['att_controller'];
			$myAccessTicketType->action = $row['att_action'];
			$myAccessTicketType->name = $row['att_name'];
			$myAccessTicketType->description = $row['att_description'];
			$myAccessTicketType->status = $row['att_status'];
			$myAccessTicketType->ipaddress = long2ip($row['att_ipaddress']);
			$myAccessTicketType->datecreated = $row['att_datecreated'];
			$myAccessTicketType->datemodified = $row['att_datemodified'];


            $outputList[] = $myAccessTicketType;
        }

        return $outputList;
    }

	/**
	 * Select the record, Interface with the outside (Controller Action)
	 *
	 * @param array $formData : filter array to build WHERE condition
	 * @param string $sortby : indicating the order of select
	 * @param string $sorttype : DESC or ASC
	 * @param string $limit: the limit string, offset for LIMIT in SQL string
	 * @param boolean $countOnly: flag to counting or return datalist
	 *
	 */
	public static function getAccessTicketTypes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_id = '.(int)$formData['fid'].' ';

		if($formData['fgroupcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_groupcontroller = "'.Helper::unspecialtext((string)$formData['fgroupcontroller']).'" ';

		if($formData['fcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_controller = "'.Helper::unspecialtext((string)$formData['fcontroller']).'" ';

		if($formData['faction'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_action = "'.Helper::unspecialtext((string)$formData['faction']).'" ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'groupcontroller')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_groupcontroller LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'controller')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_controller LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'action')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_action LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'att.att_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (att.att_groupcontroller LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (att.att_controller LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (att.att_action LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (att.att_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'att_id ' . $sorttype;
		else
			$orderString = 'att_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$outputList = array();

		$outputList[self::STATUS_ENABLE] = 'Enable';
		$outputList[self::STATUS_DISABLE] = 'Disable';

		return $outputList;
	}

	public function getStatusName()
	{
		$name = '';

		switch ($this->status)
		{
			case self::STATUS_ENABLE :
				$name = 'Enable';
				break;

			case self::STATUS_DISABLE :
				$name = 'Disable';
				break;

		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if( ($this->status == self::STATUS_ENABLE && $name == 'enable') || ($this->status == self::STATUS_DISABLE && $name == 'disable') )
			return true;
		else
			return false;
	}


}