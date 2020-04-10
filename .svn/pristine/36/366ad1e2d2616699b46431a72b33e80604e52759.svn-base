<?php

/**
 * core/class.reportcolumn.php
 *
 * File contains the class used for ReportColumn Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ReportColumn extends Core_Object
{
	const VALUETYPE_NORMAL = 1;
	const VALUETYPE_FORMULAR = 3;

	const DATATYPE_NUMBER = 2;
	const DATATYPE_STRING = 4;

	const STATUS_ENABLE = 10;
	const STATUS_DISABLED = 11;

	const OBJECTTYPE_PRODUCT = 101;
	const OBJECTTYPE_PRODUCTCATEGORY = 102;
	const OBJECTTYPE_VENDOR = 103;


	public $id = 0;
	public $identifier = "";
	public $name = "";
	public $valuetype = 0;
	public $datatype = 0;
	public $status = 0;
	public $displayorder = 0;
	public $formular = "";
	public $objecttype = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'report_column (
					rc_identifier,
					rc_name,
					rc_valuetype,
					rc_datatype,
					rc_status,
					rc_displayorder,
					rc_formular,
					rc_objecttype
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->identifier,
					(string)$this->name,
					(int)$this->valuetype,
					(int)$this->datatype,
					(int)$this->status,
					(int)$this->displayorder,
					(string)$this->formular,
					(int)$this->objecttype
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'report_column
				SET rc_identifier = ?,
					rc_name = ?,
					rc_valuetype = ?,
					rc_datatype = ?,
					rc_status = ?,
					rc_displayorder = ?,
					rc_formular = ?,
					rc_objecttype = ?
				WHERE rc_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->identifier,
					(string)$this->name,
					(int)$this->valuetype,
					(int)$this->datatype,
					(int)$this->status,
					(int)$this->displayorder,
					(string)$this->formular,
					(int)$this->objecttype,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_column rc
				WHERE rc.rc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['rc_id'];
		$this->identifier = $row['rc_identifier'];
		$this->name = $row['rc_name'];
		$this->valuetype = $row['rc_valuetype'];
		$this->datatype = $row['rc_datatype'];
		$this->status = $row['rc_status'];
		$this->displayorder = $row['rc_displayorder'];
		$this->formular = $row['rc_formular'];
		$this->objecttype = $row['rc_objecttype'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'report_column
				WHERE rc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'report_column rc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'report_column rc';

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
			$myReportColumn = new Core_ReportColumn();

			$myReportColumn->id = $row['rc_id'];
			$myReportColumn->identifier = $row['rc_identifier'];
			$myReportColumn->name = $row['rc_name'];
			$myReportColumn->valuetype = $row['rc_valuetype'];
			$myReportColumn->datatype = $row['rc_datatype'];
			$myReportColumn->status = $row['rc_status'];
			$myReportColumn->displayorder = $row['rc_displayorder'];
			$myReportColumn->formular = $row['rc_formular'];
			$myReportColumn->objecttype = $row['rc_objecttype'];


            $outputList[] = $myReportColumn;
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
	public static function getReportColumns($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_id = '.(int)$formData['fid'].' ';

		if($formData['fidentifier'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_identifier = "'.Helper::unspecialtext((string)$formData['fidentifier']).'" ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fvaluetype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_valuetype = '.(int)$formData['fvaluetype'].' ';

		if($formData['fdatatype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_datatype = '.(int)$formData['fdatatype'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fobjecttype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_objecttype = '.(int)$formData['fobjecttype'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'identifier')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_identifier LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'rc.rc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (rc.rc_identifier LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (rc.rc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'rc_id ' . $sorttype;
		else
			$orderString = 'rc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(rc_displayorder) FROM ' . TABLE_PREFIX . 'report_column';
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

	public static function getDataTypeList()
	{
		$output = array();

		$output[self::DATATYPE_NUMBER] = 'Number';
		$output[self::DATATYPE_STRING] = 'String';

		return $output;
	}

	public function getDataTypeName()
	{
		$name = '';

		switch ($this->datatype)
		{
			case self::DATATYPE_STRING:
				$name = 'String';
				break;

			case self::DATATYPE_NUMBER:
				$name = 'Number';
				break;
		}

		return $name;
	}

	public static function getValueTypeList()
	{
		$output = array();

		$output[self::VALUETYPE_NORMAL] = 'Normal';
		$output[self::VALUETYPE_FORMULAR] = 'Formular';

		return $output;
	}

	public function getValueTypeName()
	{
		$name = '';

		switch ($this->valuetype)
		{
			case self::VALUETYPE_NORMAL :
				$name = 'Normal';
				break;

			case self::VALUETYPE_FORMULAR :
				$name = 'Formular';
				break;
		}

		return $name;
	}

	public static function getObjectTypeList()
	{
		$output = array();

		$output[self::OBJECTTYPE_PRODUCT] = 'product';
		$output[self::OBJECTTYPE_PRODUCTCATEGORY] = 'productcategory';
		$output[self::OBJECTTYPE_VENDOR] = 'vendor';

		return $output;
	}

	public function getObjectTypeName()
	{
		$name = '';

		switch ($this->objecttype)
		{
			case self::OBJECTTYPE_PRODUCT :
				$name = 'product';
				break;

			case self::OBJECTTYPE_PRODUCTCATEGORY :
				$name = 'productcategory';
				break;

			case self::OBJECTTYPE_VENDOR :
				$name = 'vendor';
				break;
		}

		return $name;
	}

}