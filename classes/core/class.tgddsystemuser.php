<?php

/**
 * core/class.tgddsystemuser.php
 *
 * File contains the class used for TgddSystemUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_TgddSystemUser extends Core_Object
{

	public $USERNAME = "";
	public $FULLNAME = "";
	public $FIRSTNAME = "";
	public $LASTNAME = "";
	public $GENDER = 0;
	public $BIRTHDAY = "";
	public $EMAIL = "";
	public $PHONENUMBER = "";
	public $MOBI = "";
	public $ADDRESS = "";
	public $DESCRIPTION = "";
	public $DEPARTMENTID = 0;
	public $REVIEWLEVELID = 0;
	public $POSITIONID = 0;
	public $AREAID = 0;
	public $ISACTIVED = 0;
	public $ISDELETE = 0;
	public $USERDELETE = "";
	public $DATEDELETE = "";
	public $USERID = 0;
	public $IMAGEPATH = "";
	public $ISMD5 = 0;
	public $CREATEDUSER = "";
	public $CREATEDDATE = "";
	public $UPDATEDUSER = "";
	public $UPDATEDDATE = "";
	public $FULLNAMEEN = "";
	public $ISREQUIREPWDCHAGING = 0;
	public $ISLOCKED = 0;
	public $LOCKEDTIME = "";
	public $STARTDATEWORK = "";
	public $ENDDATEWORK = "";
	public $SHIFTID = 0;
	public $STOREID = 0;
	public $POSITIONNAME = '';

    public function __construct($USERNAME = 0)
	{
		parent::__construct();

		if($USERNAME > 0)
			$this->getData($USERNAME);
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO tgdd_system_user (
					USERNAME,
					FULLNAME,
					FIRSTNAME,
					LASTNAME,
					GENDER,
					BIRTHDAY,
					EMAIL,
					PHONENUMBER,
					MOBI,
					ADDRESS,
					DESCRIPTION,
					DEPARTMENTID,
					REVIEWLEVELID,
					POSITIONID,
					POSITIONNAME,
					AREAID,
					ISACTIVED,
					ISDELETE,
					USERDELETE,
					DATEDELETE,
					USERID,
					IMAGEPATH,
					ISMD5,
					CREATEDUSER,
					CREATEDDATE,
					UPDATEDUSER,
					UPDATEDDATE,
					FULLNAMEEN,
					ISREQUIREPWDCHAGING,
					ISLOCKED,
					LOCKEDTIME,
					STARTDATEWORK,
					ENDDATEWORK,
					SHIFTID,
					STOREID
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?,?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->USERNAME,
					(string)$this->FULLNAME,
					(string)$this->FIRSTNAME,
					(string)$this->LASTNAME,
					(int)$this->GENDER,
					(string)$this->BIRTHDAY,
					(string)$this->EMAIL,
					(string)$this->PHONENUMBER,
					(string)$this->MOBI,
					(string)$this->ADDRESS,
					(string)$this->DESCRIPTION,
					(int)$this->DEPARTMENTID,
					(int)$this->REVIEWLEVELID,
					(int)$this->POSITIONID,
					(string)$this->POSITIONNAME,
					(int)$this->AREAID,
					(int)$this->ISACTIVED,
					(int)$this->ISDELETE,
					(string)$this->USERDELETE,
					(string)$this->DATEDELETE,
					(int)$this->USERID,
					(string)$this->IMAGEPATH,
					(int)$this->ISMD5,
					(string)$this->CREATEDUSER,
					(string)$this->CREATEDDATE,
					(string)$this->UPDATEDUSER,
					(string)$this->UPDATEDDATE,
					(string)$this->FULLNAMEEN,
					(int)$this->ISREQUIREPWDCHAGING,
					(int)$this->ISLOCKED,
					(string)$this->LOCKEDTIME,
					(string)$this->STARTDATEWORK,
					(string)$this->ENDDATEWORK,
					(int)$this->SHIFTID,
					(int)$this->STOREID
					))->rowCount();

		$this->USERNAME = $this->db->lastInsertId();
		return $this->USERNAME;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE tgdd_system_user
				SET FULLNAME = ?,
					FIRSTNAME = ?,
					LASTNAME = ?,
					GENDER = ?,
					BIRTHDAY = ?,
					EMAIL = ?,
					PHONENUMBER = ?,
					MOBI = ?,
					ADDRESS = ?,
					DESCRIPTION = ?,
					DEPARTMENTID = ?,
					REVIEWLEVELID = ?,
					POSITIONID = ?,
					POSITIONNAME = ?,
					AREAID = ?,
					ISACTIVED = ?,
					ISDELETE = ?,
					USERDELETE = ?,
					DATEDELETE = ?,
					USERID = ?,
					IMAGEPATH = ?,
					ISMD5 = ?,
					CREATEDUSER = ?,
					CREATEDDATE = ?,
					UPDATEDUSER = ?,
					UPDATEDDATE = ?,
					FULLNAMEEN = ?,
					ISREQUIREPWDCHAGING = ?,
					ISLOCKED = ?,
					LOCKEDTIME = ?,
					STARTDATEWORK = ?,
					ENDDATEWORK = ?,
					SHIFTID = ?,
					STOREID = ?
				WHERE USERNAME = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->FULLNAME,
					(string)$this->FIRSTNAME,
					(string)$this->LASTNAME,
					(int)$this->GENDER,
					(string)$this->BIRTHDAY,
					(string)$this->EMAIL,
					(string)$this->PHONENUMBER,
					(string)$this->MOBI,
					(string)$this->ADDRESS,
					(string)$this->DESCRIPTION,
					(int)$this->DEPARTMENTID,
					(int)$this->REVIEWLEVELID,
					(int)$this->POSITIONID,
					(string)$this->POSITIONNAME,
					(int)$this->AREAID,
					(int)$this->ISACTIVED,
					(int)$this->ISDELETE,
					(string)$this->USERDELETE,
					(string)$this->DATEDELETE,
					(int)$this->USERID,
					(string)$this->IMAGEPATH,
					(int)$this->ISMD5,
					(string)$this->CREATEDUSER,
					(string)$this->CREATEDDATE,
					(string)$this->UPDATEDUSER,
					(string)$this->UPDATEDDATE,
					(string)$this->FULLNAMEEN,
					(int)$this->ISREQUIREPWDCHAGING,
					(int)$this->ISLOCKED,
					(string)$this->LOCKEDTIME,
					(string)$this->STARTDATEWORK,
					(string)$this->ENDDATEWORK,
					(int)$this->SHIFTID,
					(int)$this->STOREID,
					(int)$this->USERNAME
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
	public function getData($USERNAME)
	{
		$USERNAME = (int)$USERNAME;
		$sql = 'SELECT * FROM tgdd_system_user tsu
				WHERE tsu.USERNAME = ?';
		$row = $this->db->query($sql, array($USERNAME))->fetch();

		$this->USERNAME = $row['USERNAME'];
		$this->FULLNAME = $row['FULLNAME'];
		$this->FIRSTNAME = $row['FIRSTNAME'];
		$this->LASTNAME = $row['LASTNAME'];
		$this->GENDER = $row['GENDER'];
		$this->BIRTHDAY = $row['BIRTHDAY'];
		$this->EMAIL = $row['EMAIL'];
		$this->PHONENUMBER = $row['PHONENUMBER'];
		$this->MOBI = $row['MOBI'];
		$this->ADDRESS = $row['ADDRESS'];
		$this->DESCRIPTION = $row['DESCRIPTION'];
		$this->DEPARTMENTID = $row['DEPARTMENTID'];
		$this->REVIEWLEVELID = $row['REVIEWLEVELID'];
		$this->POSITIONID = $row['POSITIONID'];
		$this->POSITIONNAME = $row['POSITIONNAME'];
		$this->AREAID = $row['AREAID'];
		$this->ISACTIVED = $row['ISACTIVED'];
		$this->ISDELETE = $row['ISDELETE'];
		$this->USERDELETE = $row['USERDELETE'];
		$this->DATEDELETE = $row['DATEDELETE'];
		$this->USERID = $row['USERID'];
		$this->IMAGEPATH = $row['IMAGEPATH'];
		$this->ISMD5 = $row['ISMD5'];
		$this->CREATEDUSER = $row['CREATEDUSER'];
		$this->CREATEDDATE = $row['CREATEDDATE'];
		$this->UPDATEDUSER = $row['UPDATEDUSER'];
		$this->UPDATEDDATE = $row['UPDATEDDATE'];
		$this->FULLNAMEEN = $row['FULLNAMEEN'];
		$this->ISREQUIREPWDCHAGING = $row['ISREQUIREPWDCHAGING'];
		$this->ISLOCKED = $row['ISLOCKED'];
		$this->LOCKEDTIME = $row['LOCKEDTIME'];
		$this->STARTDATEWORK = $row['STARTDATEWORK'];
		$this->ENDDATEWORK = $row['ENDDATEWORK'];
		$this->SHIFTID = $row['SHIFTID'];
		$this->STOREID = $row['STOREID'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM tgdd_system_user
				WHERE USERNAME = ?';
		$rowCount = $this->db->query($sql, array($this->USERNAME))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM tgdd_system_user tsu';

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

		$sql = 'SELECT * FROM tgdd_system_user tsu';

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
			$myTgddSystemUser = new Core_TgddSystemUser();

			$myTgddSystemUser->USERNAME = $row['USERNAME'];
			$myTgddSystemUser->FULLNAME = $row['FULLNAME'];
			$myTgddSystemUser->FIRSTNAME = $row['FIRSTNAME'];
			$myTgddSystemUser->LASTNAME = $row['LASTNAME'];
			$myTgddSystemUser->GENDER = $row['GENDER'];
			$myTgddSystemUser->BIRTHDAY = $row['BIRTHDAY'];
			$myTgddSystemUser->EMAIL = $row['EMAIL'];
			$myTgddSystemUser->PHONENUMBER = $row['PHONENUMBER'];
			$myTgddSystemUser->MOBI = $row['MOBI'];
			$myTgddSystemUser->ADDRESS = $row['ADDRESS'];
			$myTgddSystemUser->DESCRIPTION = $row['DESCRIPTION'];
			$myTgddSystemUser->DEPARTMENTID = $row['DEPARTMENTID'];
			$myTgddSystemUser->REVIEWLEVELID = $row['REVIEWLEVELID'];
			$myTgddSystemUser->POSITIONID = $row['POSITIONID'];
			$myTgddSystemUser->POSITIONNAME = $row['POSITIONNAME'];
			$myTgddSystemUser->AREAID = $row['AREAID'];
			$myTgddSystemUser->ISACTIVED = $row['ISACTIVED'];
			$myTgddSystemUser->ISDELETE = $row['ISDELETE'];
			$myTgddSystemUser->USERDELETE = $row['USERDELETE'];
			$myTgddSystemUser->DATEDELETE = $row['DATEDELETE'];
			$myTgddSystemUser->USERID = $row['USERID'];
			$myTgddSystemUser->IMAGEPATH = $row['IMAGEPATH'];
			$myTgddSystemUser->ISMD5 = $row['ISMD5'];
			$myTgddSystemUser->CREATEDUSER = $row['CREATEDUSER'];
			$myTgddSystemUser->CREATEDDATE = $row['CREATEDDATE'];
			$myTgddSystemUser->UPDATEDUSER = $row['UPDATEDUSER'];
			$myTgddSystemUser->UPDATEDDATE = $row['UPDATEDDATE'];
			$myTgddSystemUser->FULLNAMEEN = $row['FULLNAMEEN'];
			$myTgddSystemUser->ISREQUIREPWDCHAGING = $row['ISREQUIREPWDCHAGING'];
			$myTgddSystemUser->ISLOCKED = $row['ISLOCKED'];
			$myTgddSystemUser->LOCKEDTIME = $row['LOCKEDTIME'];
			$myTgddSystemUser->STARTDATEWORK = $row['STARTDATEWORK'];
			$myTgddSystemUser->ENDDATEWORK = $row['ENDDATEWORK'];
			$myTgddSystemUser->SHIFTID = $row['SHIFTID'];
			$myTgddSystemUser->STOREID = $row['STOREID'];


            $outputList[] = $myTgddSystemUser;
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
	public static function getTgddSystemUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fUSERNAME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.USERNAME = "'.Helper::unspecialtext((string)$formData['fUSERNAME']).'" ';

		if($formData['fFULLNAME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.FULLNAME = "'.Helper::unspecialtext((string)$formData['fFULLNAME']).'" ';

		if($formData['fFIRSTNAME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.FIRSTNAME = "'.Helper::unspecialtext((string)$formData['fFIRSTNAME']).'" ';

		if($formData['fLASTNAME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.LASTNAME = "'.Helper::unspecialtext((string)$formData['fLASTNAME']).'" ';

		if($formData['fGENDER'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.GENDER = '.(int)$formData['fGENDER'].' ';

		if($formData['fBIRTHDAY'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.BIRTHDAY = "'.Helper::unspecialtext((string)$formData['fBIRTHDAY']).'" ';

		if($formData['fEMAIL'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.EMAIL = "'.Helper::unspecialtext((string)$formData['fEMAIL']).'" ';

		if($formData['fPHONENUMBER'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.PHONENUMBER = "'.Helper::unspecialtext((string)$formData['fPHONENUMBER']).'" ';

		if($formData['fMOBI'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.MOBI = "'.Helper::unspecialtext((string)$formData['fMOBI']).'" ';

		if($formData['fADDRESS'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ADDRESS = "'.Helper::unspecialtext((string)$formData['fADDRESS']).'" ';

		if($formData['fDESCRIPTION'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.DESCRIPTION = "'.Helper::unspecialtext((string)$formData['fDESCRIPTION']).'" ';

		if($formData['fDEPARTMENTID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.DEPARTMENTID = '.(int)$formData['fDEPARTMENTID'].' ';

		if($formData['fREVIEWLEVELID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.REVIEWLEVELID = '.(int)$formData['fREVIEWLEVELID'].' ';

		if($formData['fPOSITIONID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.POSITIONID = '.(int)$formData['fPOSITIONID'].' ';

		if($formData['fAREAID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.AREAID = '.(int)$formData['fAREAID'].' ';

		if($formData['fISACTIVED'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ISACTIVED = '.(int)$formData['fISACTIVED'].' ';

		if($formData['fUSERDELETE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.USERDELETE = "'.Helper::unspecialtext((string)$formData['fUSERDELETE']).'" ';

		if($formData['fDATEDELETE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.DATEDELETE = "'.Helper::unspecialtext((string)$formData['fDATEDELETE']).'" ';

		if($formData['fUSERID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.USERID = '.(int)$formData['fUSERID'].' ';

		if($formData['fIMAGEPATH'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.IMAGEPATH = "'.Helper::unspecialtext((string)$formData['fIMAGEPATH']).'" ';

		if($formData['fISMD5'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ISMD5 = '.(int)$formData['fISMD5'].' ';

		if($formData['fCREATEDUSER'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.CREATEDUSER = "'.Helper::unspecialtext((string)$formData['fCREATEDUSER']).'" ';

		if($formData['fCREATEDDATE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.CREATEDDATE = "'.Helper::unspecialtext((string)$formData['fCREATEDDATE']).'" ';

		if($formData['fUPDATEDUSER'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.UPDATEDUSER = "'.Helper::unspecialtext((string)$formData['fUPDATEDUSER']).'" ';

		if($formData['fUPDATEDDATE'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.UPDATEDDATE = "'.Helper::unspecialtext((string)$formData['fUPDATEDDATE']).'" ';

		if($formData['fFULLNAMEEN'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.FULLNAMEEN = "'.Helper::unspecialtext((string)$formData['fFULLNAMEEN']).'" ';

		if($formData['fISREQUIREPWDCHAGING'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ISREQUIREPWDCHAGING = '.(int)$formData['fISREQUIREPWDCHAGING'].' ';

		if($formData['fISLOCKED'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ISLOCKED = '.(int)$formData['fISLOCKED'].' ';

		if($formData['fLOCKEDTIME'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.LOCKEDTIME = "'.Helper::unspecialtext((string)$formData['fLOCKEDTIME']).'" ';

		if($formData['fSTARTDATEWORK'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.STARTDATEWORK = "'.Helper::unspecialtext((string)$formData['fSTARTDATEWORK']).'" ';

		if($formData['fENDDATEWORK'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ENDDATEWORK = "'.Helper::unspecialtext((string)$formData['fENDDATEWORK']).'" ';

		if($formData['fSHIFTID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.SHIFTID = '.(int)$formData['fSHIFTID'].' ';

		if($formData['fSTOREID'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.STOREID = '.(int)$formData['fSTOREID'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'USERNAME')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.USERNAME LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'FIRSTNAME')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.FIRSTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'LASTNAME')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.LASTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'BIRTHDAY')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.BIRTHDAY LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'EMAIL')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.EMAIL LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'PHONENUMBER')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.PHONENUMBER LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'MOBI')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.MOBI LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'ADDRESS')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ADDRESS LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'DESCRIPTION')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.DESCRIPTION LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'USERDELETE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.USERDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'DATEDELETE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.DATEDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'IMAGEPATH')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.IMAGEPATH LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'CREATEDUSER')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.CREATEDUSER LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'CREATEDDATE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.CREATEDDATE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'UPDATEDUSER')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.UPDATEDUSER LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'UPDATEDDATE')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.UPDATEDDATE LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'FULLNAMEEN')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.FULLNAMEEN LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'LOCKEDTIME')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.LOCKEDTIME LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'STARTDATEWORK')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.STARTDATEWORK LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'ENDDATEWORK')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'tsu.ENDDATEWORK LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (tsu.USERNAME LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.FIRSTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.LASTNAME LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.BIRTHDAY LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.EMAIL LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.PHONENUMBER LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.MOBI LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.ADDRESS LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.DESCRIPTION LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.USERDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.DATEDELETE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.IMAGEPATH LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.CREATEDUSER LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.CREATEDDATE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.UPDATEDUSER LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.UPDATEDDATE LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.FULLNAMEEN LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.LOCKEDTIME LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.STARTDATEWORK LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (tsu.ENDDATEWORK LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'USERNAME')
			$orderString = 'USERNAME ' . $sorttype;
		elseif($sortby == 'FULLNAME')
			$orderString = 'FULLNAME ' . $sorttype;
		elseif($sortby == 'FIRSTNAME')
			$orderString = 'FIRSTNAME ' . $sorttype;
		elseif($sortby == 'GENDER')
			$orderString = 'GENDER ' . $sorttype;
		elseif($sortby == 'BIRTHDAY')
			$orderString = 'BIRTHDAY ' . $sorttype;
		elseif($sortby == 'EMAIL')
			$orderString = 'EMAIL ' . $sorttype;
		elseif($sortby == 'PHONENUMBER')
			$orderString = 'PHONENUMBER ' . $sorttype;
		elseif($sortby == 'MOBI')
			$orderString = 'MOBI ' . $sorttype;
		elseif($sortby == 'ADDRESS')
			$orderString = 'ADDRESS ' . $sorttype;
		elseif($sortby == 'DESCRIPTION')
			$orderString = 'DESCRIPTION ' . $sorttype;
		elseif($sortby == 'DEPARTMENTID')
			$orderString = 'DEPARTMENTID ' . $sorttype;
		elseif($sortby == 'REVIEWLEVELID')
			$orderString = 'REVIEWLEVELID ' . $sorttype;
		elseif($sortby == 'POSITIONID')
			$orderString = 'POSITIONID ' . $sorttype;
		elseif($sortby == 'AREAID')
			$orderString = 'AREAID ' . $sorttype;
		elseif($sortby == 'ISACTIVED')
			$orderString = 'ISACTIVED ' . $sorttype;
		elseif($sortby == 'ISDELETE')
			$orderString = 'ISDELETE ' . $sorttype;
		elseif($sortby == 'USERDELETE')
			$orderString = 'USERDELETE ' . $sorttype;
		elseif($sortby == 'DATEDELETE')
			$orderString = 'DATEDELETE ' . $sorttype;
		elseif($sortby == 'USERID')
			$orderString = 'USERID ' . $sorttype;
		elseif($sortby == 'IMAGEPATH')
			$orderString = 'IMAGEPATH ' . $sorttype;
		elseif($sortby == 'ISMD5')
			$orderString = 'ISMD5 ' . $sorttype;
		elseif($sortby == 'CREATEDUSER')
			$orderString = 'CREATEDUSER ' . $sorttype;
		elseif($sortby == 'CREATEDDATE')
			$orderString = 'CREATEDDATE ' . $sorttype;
		elseif($sortby == 'UPDATEDUSER')
			$orderString = 'UPDATEDUSER ' . $sorttype;
		elseif($sortby == 'UPDATEDDATE')
			$orderString = 'UPDATEDDATE ' . $sorttype;
		elseif($sortby == 'FULLNAMEEN')
			$orderString = 'FULLNAMEEN ' . $sorttype;
		elseif($sortby == 'ISREQUIREPWDCHAGING')
			$orderString = 'ISREQUIREPWDCHAGING ' . $sorttype;
		elseif($sortby == 'ISLOCKED')
			$orderString = 'ISLOCKED ' . $sorttype;
		elseif($sortby == 'LOCKEDTIME')
			$orderString = 'LOCKEDTIME ' . $sorttype;
		elseif($sortby == 'STARTDATEWORK')
			$orderString = 'STARTDATEWORK ' . $sorttype;
		elseif($sortby == 'ENDDATEWORK')
			$orderString = 'ENDDATEWORK ' . $sorttype;
		elseif($sortby == 'SHIFTID')
			$orderString = 'SHIFTID ' . $sorttype;
		elseif($sortby == 'STOREID')
			$orderString = 'STOREID ' . $sorttype;
		else
			$orderString = 'USERNAME ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}