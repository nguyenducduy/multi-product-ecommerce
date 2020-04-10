<?php

/**
 * core/class.calendarcategory.php
 *
 * File contains the class used for CalendarCategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_CalendarCategory extends Core_Object
{

	public $uid = 0;
	public $cid = 0;
	public $id = 0;
	public $name = "";
	public $color = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'calendar_category (
					u_id,
					c_id,
					cc_name,
					cc_color,
					cc_datecreated,
					cc_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->cid,
					(string)$this->name,
					(string)$this->color,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'calendar_category
				SET u_id = ?,
					c_id = ?,
					cc_name = ?,
					cc_color = ?,
					cc_datecreated = ?,
					cc_datemodified = ?
				WHERE cc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->cid,
					(string)$this->name,
					(string)$this->color,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'calendar_category cc
				WHERE cc.cc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->cid = $row['c_id'];
		$this->id = $row['cc_id'];
		$this->name = $row['cc_name'];
		$this->color = $row['cc_color'];
		$this->datecreated = $row['cc_datecreated'];
		$this->datemodified = $row['cc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'calendar_category
				WHERE cc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'calendar_category cc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'calendar_category cc';

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
			$myCalendarCategory = new Core_CalendarCategory();

			$myCalendarCategory->uid = $row['u_id'];
			$myCalendarCategory->cid = $row['c_id'];
			$myCalendarCategory->id = $row['cc_id'];
			$myCalendarCategory->name = $row['cc_name'];
			$myCalendarCategory->color = $row['cc_color'];
			$myCalendarCategory->datecreated = $row['cc_datecreated'];
			$myCalendarCategory->datemodified = $row['cc_datemodified'];


            $outputList[] = $myCalendarCategory;
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
	public static function getCalendarCategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cc.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cc.c_id = '.(int)$formData['fcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cc.cc_id = '.(int)$formData['fid'].' ';

		if($formData['fcolor'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'cc.cc_color = "'.Helper::unspecialtext((string)$formData['fcolor']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'cc.cc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (cc.cc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'cc_id ' . $sorttype;
		else
			$orderString = 'cc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}