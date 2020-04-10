<?php

/**
 * core/class.reportrelsheetcolumn.php
 *
 * File contains the class used for ReportRelSheetColumn Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReportRelSheetColumn extends Core_Object
{

	public $rsid = 0;
	public $rcid = 0;
	public $id = 0;
	public $displayorder = 0;
	public $status = 0;
	public $defalutvalue = "";
	public $editable = 0;

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

        if($this->displayorder == 0)
            $this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'report_rel_sheet_column (
					rs_id,
					rc_id,
					rsc_displayorder,
					rsc_status,
					rsc_defalutvalue,
					rsc_editable
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->rsid,
					(int)$this->rcid,
					(int)$this->displayorder,
					(int)$this->status,
					(string)$this->defalutvalue,
					(int)$this->editable
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'report_rel_sheet_column
				SET rs_id = ?,
					rc_id = ?,
					rsc_displayorder = ?,
					rsc_status = ?,
					rsc_defalutvalue = ?,
					rsc_editable = ?
				WHERE rsc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->rsid,
					(int)$this->rcid,
					(int)$this->displayorder,
					(int)$this->status,
					(string)$this->defalutvalue,
					(int)$this->editable,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_rel_sheet_column rrsc
				WHERE rrsc.rsc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->rsid = $row['rs_id'];
		$this->rcid = $row['rc_id'];
		$this->id = $row['rsc_id'];
		$this->displayorder = $row['rsc_displayorder'];
		$this->status = $row['rsc_status'];
		$this->defalutvalue = $row['rsc_defalutvalue'];
		$this->editable = $row['rsc_editable'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'report_rel_sheet_column
				WHERE rsc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'report_rel_sheet_column rrsc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_rel_sheet_column rrsc';

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
			$myReportRelSheetColumn = new Core_ReportRelSheetColumn();

			$myReportRelSheetColumn->rsid = $row['rs_id'];
			$myReportRelSheetColumn->rcid = $row['rc_id'];
			$myReportRelSheetColumn->id = $row['rsc_id'];
			$myReportRelSheetColumn->displayorder = $row['rsc_displayorder'];
			$myReportRelSheetColumn->status = $row['rsc_status'];
			$myReportRelSheetColumn->defalutvalue = $row['rsc_defalutvalue'];
			$myReportRelSheetColumn->editable = $row['rsc_editable'];


            $outputList[] = $myReportRelSheetColumn;
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
	public static function getReportRelSheetColumns($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['frsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rs_id = '.(int)$formData['frsid'].' ';

		if($formData['frcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rc_id = '.(int)$formData['frcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rsc_id = '.(int)$formData['fid'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rsc_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rsc_status = '.(int)$formData['fstatus'].' ';

		if($formData['feditable'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrsc.rsc_editable = '.(int)$formData['feditable'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'rsid')
			$orderString = 'rs_id ' . $sorttype;
		elseif($sortby == 'rcid')
			$orderString = 'rc_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rsc_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'rsc_displayorder ' . $sorttype;
		else
			$orderString = 'rsc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(rsc_displayorder) FROM ' . TABLE_PREFIX . 'report_rel_sheet_column';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

    /**
	 * Delete current object from database, base on rs_id
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public static function deletebysheet($rs_id)
    {
        global $db;
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'report_rel_sheet_column
				WHERE rs_id = ?';
		$rowCount = $db->query($sql, array($rs_id))->rowCount();

		return $rowCount;
	}

}
