<?php

/**
 * core/class.storeuser.php
 *
 * File contains the class used for StoreUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_StoreUser extends Core_Object
{
	const ROLE_SUPERMARKET = 5;
	const ROLE_MARKETING = 10;
	const ROLE_EMPLOYEE = 15;

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $uid = 0;
	public $sid = 0;
	public $id = 0;
	public $role = 0;
	public $creatorid = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $userActor = null;
	public $storeActor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store_user (
					u_id,
					s_id,
					su_role,
					su_creatorid,
					su_status,
					su_datecreated,
					su_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->sid,
					(int)$this->role,
					(int)$this->creatorid,
					(int)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'store_user
				SET u_id = ?,
					s_id = ?,
					su_role = ?,
					su_creatorid = ?,
					su_status = ?,
					su_datecreated = ?,
					su_datemodified = ?
				WHERE su_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->sid,
					(int)$this->role,
					(int)$this->creatorid,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_user su
				WHERE su.su_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->sid = $row['s_id'];
		$this->id = $row['su_id'];
		$this->role = $row['su_role'];
		$this->creatorid = $row['su_creatorid'];
		$this->status = $row['su_status'];
		$this->datecreated = $row['su_datecreated'];
		$this->datemodified = $row['su_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'store_user
				WHERE su_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'store_user su';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_user su';

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
			$myStoreUser = new Core_StoreUser();

			$myStoreUser->uid = $row['u_id'];
			$myStoreUser->sid = $row['s_id'];
			$myStoreUser->id = $row['su_id'];
			$myStoreUser->role = $row['su_role'];
			$myStoreUser->creatorid = $row['su_creatorid'];
			$myStoreUser->status = $row['su_status'];
			$myStoreUser->datecreated = $row['su_datecreated'];
			$myStoreUser->datemodified = $row['su_datemodified'];


            $outputList[] = $myStoreUser;
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
	public static function getStoreUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_id = '.(int)$formData['fid'].' ';

		if($formData['frole'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_role = '.(int)$formData['frole'].' ';

		if($formData['fcreatorid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_creatorid = '.(int)$formData['fcreatorid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'su_id ' . $sorttype;
		elseif($sortby == 'creatorid')
			$orderString = 'su_creatorid ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'su_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'su_datemodified ' . $sorttype;
		else
			$orderString = 'su_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

	public static function getRoleList()
	{
		$outputList = array();

		$outputList[self::ROLE_SUPERMARKET] = 'Khối siêu thị';
		$outputList[self::ROLE_MARKETING] = 'Bộ phận marketing';
		$outputList[self::ROLE_EMPLOYEE] = 'Nhân viên';

		return $outputList;
	}

	public function getRoleName()
	{
		$name = '';

		switch($this->role)
		{
			case self::ROLE_SUPERMARKET: $name = 'Siêu thị'; break;
			case self::ROLE_MARKETING: $name = 'Marketing'; break;
			case self::ROLE_EMPLOYEE: $name = 'Nhân viên'; break;
		}

		return $name;
	}

	public static function checkRoleUser($formData)
	{
		global $db;

		$whereString = '';

		$checker = false;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'store_user su';

		if(count($formData) > 0)
		{
			if($formData['fuid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.u_id = '.(int)$formData['fuid'].' ';

			if($formData['fsid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.s_id = '.(int)$formData['fsid'].' ';

			if($formData['frole'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_role = '.(int)$formData['frole'].' ';

			if($formData['fstatus'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'su.su_status = '.(int)$formData['fstatus'].' ';



			if($whereString != '')
				$sql .= ' WHERE ' . $whereString;

			$counter = $db->query($sql)->fetchColumn(0);
			if($counter > 0)
			{
				$checker =  true;
			}
		}

		return $checker;
	}

	public static function getStoreUserInfo($uid = 0)
	{
		global $db;
		$myStoreUser = new Core_StoreUser();
		if($uid > 0)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_user su
					WHERE u_id = ? LIMIT 1';

			$row = $db->query($sql , array($uid))->fetch();

			$myStoreUser->uid = $row['u_id'];
			$myStoreUser->sid = $row['s_id'];
			$myStoreUser->id = $row['su_id'];
			$myStoreUser->role = $row['su_role'];
			$myStoreUser->creatorid = $row['su_creatorid'];
			$myStoreUser->status = $row['su_status'];
			$myStoreUser->datecreated = $row['su_datecreated'];
			$myStoreUser->datemodified = $row['su_datemodified'];
		}
		return $myStoreUser;
	}
}