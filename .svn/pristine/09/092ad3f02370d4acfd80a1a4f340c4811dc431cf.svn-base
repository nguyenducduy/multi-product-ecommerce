<?php

/**
 * core/class.reportsheet.php
 *
 * File contains the class used for ReportSheet Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReportSheet extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

    const TYPE_DEFAULT = 10;
    const TYPE_CUSTOM = 15;

	public $id = 0;
	public $name = "";
	public $type = 0;
	public $creatorid = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $description = "";
	public $year = 0;
	public $month = 0;
    public $week = 0;
    public $userActor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'report_sheet (
					rs_name,
					rs_type,
					rs_creatorid,
					rs_status,
					rs_datecreated,
					rs_datemodified,
					rs_description,
					rs_year,
					rs_month,
					rs_week
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->type,
					(int)$this->creatorid,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(string)$this->description,
					(int)$this->year,
					(int)$this->month,
					(int)$this->week
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'report_sheet
				SET rs_name = ?,
					rs_type = ?,
					rs_creatorid = ?,
					rs_status = ?,
					rs_datecreated = ?,
					rs_datemodified = ?,
					rs_description = ?,
					rs_year = ?,
					rs_month = ?,
					rs_week = ?
				WHERE rs_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->type,
					(int)$this->creatorid,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(string)$this->description,
					(int)$this->year,
					(int)$this->month,
					(int)$this->week,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_sheet rs
				WHERE rs.rs_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['rs_id'];
		$this->name = $row['rs_name'];
		$this->type = $row['rs_type'];
		$this->creatorid = $row['rs_creatorid'];
		$this->status = $row['rs_status'];
		$this->datecreated = $row['rs_datecreated'];
		$this->datemodified = $row['rs_datemodified'];
		$this->description = $row['rs_description'];
		$this->year = $row['rs_year'];
		$this->month = $row['rs_month'];
		$this->week = $row['rs_week'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'report_sheet
				WHERE rs_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'report_sheet rs';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_sheet rs';

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
			$myReportSheet = new Core_ReportSheet();

			$myReportSheet->id = $row['rs_id'];
			$myReportSheet->name = $row['rs_name'];
			$myReportSheet->type = $row['rs_type'];
			$myReportSheet->creatorid = $row['rs_creatorid'];
			$myReportSheet->status = $row['rs_status'];
			$myReportSheet->datecreated = $row['rs_datecreated'];
			$myReportSheet->datemodified = $row['rs_datemodified'];
			$myReportSheet->description = $row['rs_description'];
			$myReportSheet->year = $row['rs_year'];
			$myReportSheet->month = $row['rs_month'];
			$myReportSheet->week = $row['rs_week'];


            $outputList[] = $myReportSheet;
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
	public static function getReportSheets($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_type = '.(int)$formData['ftype'].' ';

		if($formData['fcreatorid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_creatorid = '.(int)$formData['fcreatorid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_status = '.(int)$formData['fstatus'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_year = '.(int)$formData['fyear'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_month = '.(int)$formData['fmonth'].' ';

		if($formData['fweek'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_week = '.(int)$formData['fweek'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rs.rs_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rs.rs_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'rs_id ' . $sorttype;
		else
			$orderString = 'rs_id ' . $sorttype;

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

    public static function getTypeList()
    {
        $output = array();

        $output[self::TYPE_DEFAULT] = 'default';
        $output[self::TYPE_CUSTOM] = 'custom';

        return $output;
    }

    public function getTypeName()
    {
        $name = '';

        switch($this->type)
        {
            case self::TYPE_DEFAULT : $name = 'default';
                break;

            case self::TYPE_CUSTOM : $name = 'custom';
                break;
        }

        return $name;
    }


}
