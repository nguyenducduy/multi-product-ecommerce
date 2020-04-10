<?php

/**
 * core/class.settinggroup.php
 *
 * File contains the class used for Settinggroup Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Settinggroup extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $uid = 0;
	public $id = 0;
	public $name = "";
	public $description = "";
	public $identifier = "";
	public $status = 0;
	public $displayorder = 0;
	public $datecreated = 0;
	public $datemodified = "";

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

		$this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'settinggroup (
					u_id,
					sg_name,
					sg_description,
					sg_identifier,
					sg_status,
					sg_displayorder,
					sg_datecreated,
					sg_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->identifier,
					(int)$this->status,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(string)$this->datemodified
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'settinggroup
				SET u_id = ?,
					sg_name = ?,
					sg_description = ?,
					sg_identifier = ?,
					sg_status = ?,
					sg_displayorder = ?,
					sg_datecreated = ?,
					sg_datemodified = ?
				WHERE sg_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->identifier,
					(int)$this->status,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(string)$this->datemodified,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'settinggroup s
				WHERE s.sg_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['sg_id'];
		$this->name = $row['sg_name'];
		$this->description = $row['sg_description'];
		$this->identifier = $row['sg_identifier'];
		$this->status = $row['sg_status'];
		$this->displayorder = $row['sg_displayorder'];
		$this->datecreated = $row['sg_datecreated'];
		$this->datemodified = $row['sg_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'settinggroup
				WHERE sg_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'settinggroup s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'settinggroup s';

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
			$mySettinggroup = new Core_Settinggroup();

			$mySettinggroup->uid = $row['u_id'];
			$mySettinggroup->id = $row['sg_id'];
			$mySettinggroup->name = $row['sg_name'];
			$mySettinggroup->description = $row['sg_description'];
			$mySettinggroup->identifier = $row['sg_identifier'];
			$mySettinggroup->status = $row['sg_status'];
			$mySettinggroup->displayorder = $row['sg_displayorder'];
			$mySettinggroup->datecreated = $row['sg_datecreated'];
			$mySettinggroup->datemodified = $row['sg_datemodified'];


            $outputList[] = $mySettinggroup;
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
	public static function getSettinggroups($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fidentifier'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_identifier = "'.Helper::unspecialtext((string)$formData['fidentifier']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_displayorder = '.(int)$formData['fdisplayorder'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sg_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'sg_displayorder ' . $sorttype;
		else
			$orderString = 'sg_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(sg_displayorder) FROM ' . TABLE_PREFIX . 'settinggroup';
		return (int)$this->db->query($sql)->fetchColumn(0);
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


}