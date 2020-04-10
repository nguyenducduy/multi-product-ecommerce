<?php

/**
 * core/class.msession.php
 *
 * File contains the class used for MSession Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_MSession extends Core_Backend_Object
{

	public $uid = 0;
	public $deviceid = "";
	public $id = 0;
	public $sessionid = "";
	public $ipaddress = 0;
	public $lastipaddress = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $datelastaccessed = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'm_session (
					u_id,
					md_deviceid,
					ms_sessionid,
					ms_ipaddress,
					ms_lastipaddress,
					ms_datecreated,
					ms_datelastaccessed
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->deviceid,
					(string)$this->sessionid,
					(int)Helper::getIpAddress(true),
					(int)$this->lastipaddress,
					(int)$this->datecreated,
					(int)$this->datelastaccessed
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'm_session
				SET u_id = ?,
					ms_sessionid = ?,
					ms_lastipaddress = ?,
					ms_datemodified = ?,
					ms_datelastaccessed = ?
				WHERE ms_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->sessionid,
					(int)$this->lastipaddress,
					(int)$this->datemodified,
					(int)$this->datelastaccessed,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'm_session ms
				WHERE ms.ms_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->deviceid = $row['md_deviceid'];
		$this->id = $row['ms_id'];
		$this->sessionid = $row['ms_sessionid'];
		$this->ipaddress = long2ip($row['ms_ipaddress']);
		$this->lastipaddress = long2ip($row['ms_lastipaddress']);
		$this->datecreated = $row['ms_datecreated'];
		$this->datemodified = $row['ms_datemodified'];
		$this->datelastaccessed = $row['ms_datelastaccessed'];

	}

	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getDataBySession($sessionid)
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'm_session ms
				WHERE ms.ms_sessionid = ?
				ORDER BY ms.ms_id DESC
				LIMIT 1';
		$row = $this->db3->query($sql, array($sessionid))->fetch();

		$this->uid = $row['u_id'];
		$this->deviceid = $row['md_deviceid'];
		$this->id = $row['ms_id'];
		$this->sessionid = $row['ms_sessionid'];
		$this->ipaddress = long2ip($row['ms_ipaddress']);
		$this->lastipaddress = long2ip($row['ms_lastipaddress']);
		$this->datecreated = $row['ms_datecreated'];
		$this->datemodified = $row['ms_datemodified'];
		$this->datelastaccessed = $row['ms_datelastaccessed'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'm_session
				WHERE ms_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'm_session ms';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'm_session ms';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myMSession = new Core_Backend_MSession();

			$myMSession->uid = $row['u_id'];
			$myMSession->deviceid = $row['md_deviceid'];
			$myMSession->id = $row['ms_id'];
			$myMSession->sessionid = $row['ms_sessionid'];
			$myMSession->platform = $row['ms_platform'];
			$myMSession->ipaddress = long2ip($row['ms_ipaddress']);
			$myMSession->lastipaddress = long2ip($row['ms_lastipaddress']);
			$myMSession->datecreated = $row['ms_datecreated'];
			$myMSession->datemodified = $row['ms_datemodified'];
			$myMSession->datelastaccessed = $row['ms_datelastaccessed'];


            $outputList[] = $myMSession;
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
	public static function getMSessions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fdeviceid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.md_deviceid = "'.Helper::unspecialtext((string)$formData['fdeviceid']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_id = '.(int)$formData['fid'].' ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['fplatform'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_platform = '.(int)$formData['fplatform'].' ';

		if($formData['fipaddress'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_ipaddress = '.ip2long($formData['fipaddress']).' ';

		if($formData['flastipaddress'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_lastipaddress = '.ip2long($formData['flastipaddress']).' ';


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'deviceid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.md_deviceid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'sessionid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ms.ms_sessionid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ms.md_deviceid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ms.ms_sessionid LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ms_id ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ms_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ms_datemodified ' . $sorttype;
		elseif($sortby == 'datelastaccessed')
			$orderString = 'ms_datelastaccessed ' . $sorttype;
		else
			$orderString = 'ms_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	function getDeviceFromSession($sessionid)
	{
		$deviceid = '';

		$sessionList = self::getMSessions(array('fsessionid' => $sessionid), 'id', 'DESC', 1);
		if(count($sessionList) > 0)
		{
			$deviceid = $sessionList[0]->deviceid;
		}

		return $deviceid;
	}


}