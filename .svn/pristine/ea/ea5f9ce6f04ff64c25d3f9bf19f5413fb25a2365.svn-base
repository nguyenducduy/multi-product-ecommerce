<?php

/**
 * core/class.reportuserdata.php
 *
 * File contains the class used for ReportUserdata Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReportUserdata extends Core_Object
{

	public $rscid = 0;
	public $rsid = 0;
	public $rcid = 0;
	public $uid = 0;
	public $id = 0;
	public $value = "";
	public $datecreated = 0;
	public $datemodified = 0;
	public $status = 0;
	public $objectid = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'report_userdata (
					rsc_id,
					rs_id,
					rc_id,
					u_id,
					ru_value,
					ru_datecreated,
					ru_datemodified,
					ru_status,
					ru_objectid
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->rscid,
					(int)$this->rsid,
					(int)$this->rcid,
					(int)$this->uid,
					(string)$this->value,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->status,
					(int)$this->objectid
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'report_userdata
				SET rsc_id = ?,
					rs_id = ?,
					rc_id = ?,
					u_id = ?,
					ru_value = ?,
					ru_datecreated = ?,
					ru_datemodified = ?,
					ru_status = ?,
					ru_objectid = ?
				WHERE ru_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->rscid,
					(int)$this->rsid,
					(int)$this->rcid,
					(int)$this->uid,
					(string)$this->value,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->status,
					(int)$this->objectid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_userdata ru
				WHERE ru.ru_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->rscid = $row['rsc_id'];
		$this->rsid = $row['rs_id'];
		$this->rcid = $row['rc_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['ru_id'];
		$this->value = $row['ru_value'];
		$this->datecreated = $row['ru_datecreated'];
		$this->datemodified = $row['ru_datemodified'];
		$this->status = $row['ru_status'];
		$this->objectid = $row['ru_objectid'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'report_userdata
				WHERE ru_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'report_userdata ru';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_userdata ru';

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
			$myReportUserdata = new Core_ReportUserdata();

			$myReportUserdata->rscid = $row['rsc_id'];
			$myReportUserdata->rsid = $row['rs_id'];
			$myReportUserdata->rcid = $row['rc_id'];
			$myReportUserdata->uid = $row['u_id'];
			$myReportUserdata->id = $row['ru_id'];
			$myReportUserdata->value = $row['ru_value'];
			$myReportUserdata->datecreated = $row['ru_datecreated'];
			$myReportUserdata->datemodified = $row['ru_datemodified'];
			$myReportUserdata->status = $row['ru_status'];
			$myReportUserdata->objectid = $row['ru_objectid'];


            $outputList[] = $myReportUserdata;
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
	public static function getReportUserdatas($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['frscid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.rsc_id = '.(int)$formData['frscid'].' ';

		if($formData['frsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.rs_id = '.(int)$formData['frsid'].' ';

		if($formData['frcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.rc_id = '.(int)$formData['frcid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_status = '.(int)$formData['fstatus'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ru.ru_objectid = '.(int)$formData['fobjectid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'rscid')
			$orderString = 'rsc_id ' . $sorttype;
		elseif($sortby == 'rsid')
			$orderString = 'rs_id ' . $sorttype;
		elseif($sortby == 'rcid')
			$orderString = 'rc_id ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ru_id ' . $sorttype;
		else
			$orderString = 'ru_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}