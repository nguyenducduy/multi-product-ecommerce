<?php

/**
 * core/class.tgddsystemdepartment.php
 *
 * File contains the class used for TgddSystemDepartment Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_TgddSystemDepartment extends Core_Object
{

	public $DEPARTMENTID = 0;
	public $DEPARTMENTNAME = "";
	public $DECRIPTION = "";
	public $PHONENUMBER = "";
	public $HEADERUSER = "";
	public $PARENTID = 0;
	public $NODETREE = "";
	public $ISDELETE = 0;
	public $USERDELETE = "";
	public $DATEDELETE = 0;
	public $VIEWINDEX = 0;
	public $DEPARTMENTCODE = "";

    public function __construct($DEPARTMENTID = 0)
	{
		parent::__construct();

		if($DEPARTMENTID > 0)
			$this->getData($DEPARTMENTID);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO tgdd_system_department (
					DEPARTMENTID,
					DEPARTMENTNAME,
					DECRIPTION,
					PHONENUMBER,
					HEADERUSER,
					PARENTID,
					NODETREE,
					ISDELETE,
					USERDELETE,
					DATEDELETE,
					VIEWINDEX,
					DEPARTMENTCODE
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->DEPARTMENTID,
					(string)$this->DEPARTMENTNAME,
					(string)$this->DECRIPTION,
					(string)$this->PHONENUMBER,
					(string)$this->HEADERUSER,
					(int)$this->PARENTID,
					(string)$this->NODETREE,
					(int)$this->ISDELETE,
					(string)$this->USERDELETE,
					(int)$this->DATEDELETE,
					(int)$this->VIEWINDEX,
					(string)$this->DEPARTMENTCODE
					))->rowCount();

		$this->DEPARTMENTID = $this->db->lastInsertId();
		return $this->DEPARTMENTID;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE tgdd_system_department
				SET DEPARTMENTNAME = ?,
					DECRIPTION = ?,
					PHONENUMBER = ?,
					HEADERUSER = ?,
					PARENTID = ?,
					NODETREE = ?,
					ISDELETE = ?,
					USERDELETE = ?,
					DATEDELETE = ?,
					VIEWINDEX = ?,
					DEPARTMENTCODE = ?
				WHERE DEPARTMENTID = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->DEPARTMENTNAME,
					(string)$this->DECRIPTION,
					(string)$this->PHONENUMBER,
					(string)$this->HEADERUSER,
					(int)$this->PARENTID,
					(string)$this->NODETREE,
					(int)$this->ISDELETE,
					(string)$this->USERDELETE,
					(int)$this->DATEDELETE,
					(int)$this->VIEWINDEX,
					(string)$this->DEPARTMENTCODE,
					(int)$this->DEPARTMENTID
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
	public function getData($DEPARTMENTID)
	{
		$DEPARTMENTID = (int)$DEPARTMENTID;
		$sql = 'SELECT * FROM tgdd_system_department tsd
				WHERE tsd.DEPARTMENTID = ?';
		$row = $this->db->query($sql, array($DEPARTMENTID))->fetch();

		$this->DEPARTMENTID = $row['DEPARTMENTID'];
		$this->DEPARTMENTNAME = $row['DEPARTMENTNAME'];
		$this->DECRIPTION = $row['DECRIPTION'];
		$this->PHONENUMBER = $row['PHONENUMBER'];
		$this->HEADERUSER = $row['HEADERUSER'];
		$this->PARENTID = $row['PARENTID'];
		$this->NODETREE = $row['NODETREE'];
		$this->ISDELETE = $row['ISDELETE'];
		$this->USERDELETE = $row['USERDELETE'];
		$this->DATEDELETE = $row['DATEDELETE'];
		$this->VIEWINDEX = $row['VIEWINDEX'];
		$this->DEPARTMENTCODE = $row['DEPARTMENTCODE'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM tgdd_system_department
				WHERE DEPARTMENTID = ?';
		$rowCount = $this->db->query($sql, array($this->DEPARTMENTID))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM tgdd_system_department tsd';

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

		$sql = 'SELECT * FROM tgdd_system_department tsd';

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
			$myTgddSystemDepartment = new Core_TgddSystemDepartment();

			$myTgddSystemDepartment->DEPARTMENTID = $row['DEPARTMENTID'];
			$myTgddSystemDepartment->DEPARTMENTNAME = $row['DEPARTMENTNAME'];
			$myTgddSystemDepartment->DECRIPTION = $row['DECRIPTION'];
			$myTgddSystemDepartment->PHONENUMBER = $row['PHONENUMBER'];
			$myTgddSystemDepartment->HEADERUSER = $row['HEADERUSER'];
			$myTgddSystemDepartment->PARENTID = $row['PARENTID'];
			$myTgddSystemDepartment->NODETREE = $row['NODETREE'];
			$myTgddSystemDepartment->ISDELETE = $row['ISDELETE'];
			$myTgddSystemDepartment->USERDELETE = $row['USERDELETE'];
			$myTgddSystemDepartment->DATEDELETE = $row['DATEDELETE'];
			$myTgddSystemDepartment->VIEWINDEX = $row['VIEWINDEX'];
			$myTgddSystemDepartment->DEPARTMENTCODE = $row['DEPARTMENTCODE'];


            $outputList[] = $myTgddSystemDepartment;
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
	public static function getTgddSystemDepartments($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fDEPARTMENTID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DEPARTMENTID = '.(int)$formData['fDEPARTMENTID'].' ';

		if($formData['fDEPARTMENTNAME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DEPARTMENTNAME = "'.Helper::unspecialtext((string)$formData['fDEPARTMENTNAME']).'" ';

		if($formData['fDECRIPTION'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DECRIPTION = "'.Helper::unspecialtext((string)$formData['fDECRIPTION']).'" ';

		if($formData['fPHONENUMBER'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.PHONENUMBER = "'.Helper::unspecialtext((string)$formData['fPHONENUMBER']).'" ';

		if($formData['fHEADERUSER'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.HEADERUSER = "'.Helper::unspecialtext((string)$formData['fHEADERUSER']).'" ';

		if($formData['fPARENTID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.PARENTID = '.(int)$formData['fPARENTID'].' ';

		if($formData['fNODETREE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.NODETREE = "'.Helper::unspecialtext((string)$formData['fNODETREE']).'" ';

		if($formData['fISDELETE'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.ISDELETE = '.(int)$formData['fISDELETE'].' ';

		if($formData['fUSERDELETE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.USERDELETE = "'.Helper::unspecialtext((string)$formData['fUSERDELETE']).'" ';

		if($formData['fDATEDELETE'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DATEDELETE = '.(int)$formData['fDATEDELETE'].' ';

		if($formData['fVIEWINDEX'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.VIEWINDEX = '.(int)$formData['fVIEWINDEX'].' ';

		if($formData['fDEPARTMENTCODE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DEPARTMENTCODE = "'.Helper::unspecialtext((string)$formData['fDEPARTMENTCODE']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'DEPARTMENTNAME')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DEPARTMENTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'DECRIPTION')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DECRIPTION LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'PHONENUMBER')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.PHONENUMBER LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'HEADERUSER')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.HEADERUSER LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'NODETREE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.NODETREE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'USERDELETE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.USERDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'DEPARTMENTCODE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsd.DEPARTMENTCODE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (tsd.DEPARTMENTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.DECRIPTION LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.PHONENUMBER LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.HEADERUSER LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.NODETREE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.USERDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsd.DEPARTMENTCODE LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'DEPARTMENTID')
			$orderString = 'DEPARTMENTID ' . $sorttype;
		elseif($sortby == 'DEPARTMENTNAME')
			$orderString = 'DEPARTMENTNAME ' . $sorttype;
		elseif($sortby == 'DECRIPTION')
			$orderString = 'DECRIPTION ' . $sorttype;
		elseif($sortby == 'PHONENUMBER')
			$orderString = 'PHONENUMBER ' . $sorttype;
		elseif($sortby == 'HEADERUSER')
			$orderString = 'HEADERUSER ' . $sorttype;
		elseif($sortby == 'PARENTID')
			$orderString = 'PARENTID ' . $sorttype;
		elseif($sortby == 'NODETREE')
			$orderString = 'NODETREE ' . $sorttype;
		elseif($sortby == 'ISDELETE')
			$orderString = 'ISDELETE ' . $sorttype;
		elseif($sortby == 'USERDELETE')
			$orderString = 'USERDELETE ' . $sorttype;
		elseif($sortby == 'DATEDELETE')
			$orderString = 'DATEDELETE ' . $sorttype;
		elseif($sortby == 'VIEWINDEX')
			$orderString = 'VIEWINDEX ' . $sorttype;
		elseif($sortby == 'DEPARTMENTCODE')
			$orderString = 'DEPARTMENTCODE ' . $sorttype;
		else
			$orderString = 'DEPARTMENTID ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}