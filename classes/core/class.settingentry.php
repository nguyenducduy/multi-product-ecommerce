<?php

/**
 * core/class.settingentry.php
 *
 * File contains the class used for Settingentry Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Settingentry extends Core_Object
{

	public $uid = 0;
	public $sgid = 0;
	public $id = 0;
	public $name = "";
	public $description = "";
	public $identifier = "";
	public $value = "";
	public $displayorder = 0;
	public $status = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'settingentry (
					u_id,
					sg_id,
					se_name,
					se_description,
					se_identifier,
					se_value,
					se_displayorder,
					se_status,
					se_datecreated,
					se_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->sgid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->identifier,
					(string)$this->value,
					(int)$this->displayorder,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'settingentry
				SET u_id = ?,
					sg_id = ?,
					se_name = ?,
					se_description = ?,
					se_identifier = ?,
					se_value = ?,
					se_displayorder = ?,
					se_status = ?,
					se_datecreated = ?,
					se_datemodified = ?
				WHERE se_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->sgid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->identifier,
					(string)$this->value,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'settingentry s
				WHERE s.se_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->sgid = $row['sg_id'];
		$this->id = $row['se_id'];
		$this->name = $row['se_name'];
		$this->description = $row['se_description'];
		$this->identifier = $row['se_identifier'];
		$this->value = $row['se_value'];
		$this->displayorder = $row['se_displayorder'];
		$this->status = $row['se_status'];
		$this->datecreated = $row['se_datecreated'];
		$this->datemodified = $row['se_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'settingentry
				WHERE se_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'settingentry s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'settingentry s';

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
			$mySettingentry = new Core_Settingentry();

			$mySettingentry->uid = $row['u_id'];
			$mySettingentry->sgid = $row['sg_id'];
			$mySettingentry->id = $row['se_id'];
			$mySettingentry->name = $row['se_name'];
			$mySettingentry->description = $row['se_description'];
			$mySettingentry->identifier = $row['se_identifier'];
			$mySettingentry->value = $row['se_value'];
			$mySettingentry->displayorder = $row['se_displayorder'];
			$mySettingentry->status = $row['se_status'];
			$mySettingentry->datecreated = $row['se_datecreated'];
			$mySettingentry->datemodified = $row['se_datemodified'];


            $outputList[] = $mySettingentry;
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
	public static function getSettingentrys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fsgid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sg_id = '.(int)$formData['fsgid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fdescription'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_description = "'.Helper::unspecialtext((string)$formData['fdescription']).'" ';

		if($formData['fidentifier'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_identifier = "'.Helper::unspecialtext((string)$formData['fidentifier']).'" ';

		if($formData['fvalue'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_value = "'.Helper::unspecialtext((string)$formData['fvalue']).'" ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.se_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'se_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'se_displayorder ' . $sorttype;
		else
			$orderString = 'se_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}