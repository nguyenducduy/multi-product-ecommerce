<?php

/**
 * core/class.forecastuservaluehistory.php
 *
 * File contains the class used for ForecastUservalueHistory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ForecastUservalueHistory extends Core_Backend_Object
{
	const TYPE_ADD = 11;
	const TYPE_EDIT = 12;

	public $uid = 0;
	public $fuid = 0;
	public $id = 0;
	public $oldvalue = "";
	public $newvalue = "";
	public $edituserid = 0;
	public $type = 0;
	public $fromsheet = 0;
	public $sessionid = "";
	public $ipaddress = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'forecast_uservalue_history (
					u_id,
					fu_id,
					fuh_oldvalue,
					fuh_newvalue,
					fuh_edituserid,
					fuh_type,
					fuh_fromsheet,
					fuh_sessionid,
					fuh_ipaddress,
					fuh_datecreated,
					fuh_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->fuid,
					(string)$this->oldvalue,
					(string)$this->newvalue,
					(int)$this->edituserid,
					(int)$this->type,
					(int)$this->fromsheet,
					Helper::getSessionId(),
					Helper::getIpAddress(true),
					(int)$this->datecreated,
					(int)$this->datemodified
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'forecast_uservalue_history
				SET u_id = ?,
					fu_id = ?,
					fuh_oldvalue = ?,
					fuh_newvalue = ?,
					fuh_edituserid = ?,
					fuh_type = ?,
					fuh_fromsheet = ?,
					fuh_sessionid = ?,
					fuh_ipaddress = ?,
					fuh_datecreated = ?,
					fuh_datemodified = ?
				WHERE fuh_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->fuid,
					(string)$this->oldvalue,
					(string)$this->newvalue,
					(int)$this->edituserid,
					(int)$this->type,
					(int)$this->fromsheet,
					Helper::getSessionId(),
					Helper::getIpAddress(true),
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'forecast_uservalue_history fuh
				WHERE fuh.fuh_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->fuid = $row['fu_id'];
		$this->id = $row['fuh_id'];
		$this->oldvalue = $row['fuh_oldvalue'];
		$this->newvalue = $row['fuh_newvalue'];
		$this->edituserid = $row['fuh_edituserid'];
		$this->type = $row['fuh_type'];
		$this->fromsheet = $row['fuh_fromsheet'];
		$this->sessionid = $row['fuh_sessionid'];
		$this->ipaddress = long2ip($row['fuh_ipaddress']);
		$this->datecreated = $row['fuh_datecreated'];
		$this->datemodified = $row['fuh_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'forecast_uservalue_history
				WHERE fuh_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'forecast_uservalue_history fuh';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'forecast_uservalue_history fuh';

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
			$myForecastUservalueHistory = new Core_Backend_ForecastUservalueHistory();

			$myForecastUservalueHistory->uid = $row['u_id'];
			$myForecastUservalueHistory->fuid = $row['fu_id'];
			$myForecastUservalueHistory->id = $row['fuh_id'];
			$myForecastUservalueHistory->oldvalue = $row['fuh_oldvalue'];
			$myForecastUservalueHistory->newvalue = $row['fuh_newvalue'];
			$myForecastUservalueHistory->edituserid = $row['fuh_edituserid'];
			$myForecastUservalueHistory->type = $row['fuh_type'];
			$myForecastUservalueHistory->fromsheet = $row['fuh_fromsheet'];
			$myForecastUservalueHistory->sessionid = $row['fuh_sessionid'];
			$myForecastUservalueHistory->ipaddress = long2ip($row['fuh_ipaddress']);
			$myForecastUservalueHistory->datecreated = $row['fuh_datecreated'];
			$myForecastUservalueHistory->datemodified = $row['fuh_datemodified'];


            $outputList[] = $myForecastUservalueHistory;
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
	public static function getForecastUservalueHistorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.u_id = '.(int)$formData['fuid'].' ';

		if($formData['ffuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fu_id = '.(int)$formData['ffuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_id = '.(int)$formData['fid'].' ';

		if($formData['foldvalue'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_oldvalue = "'.Helper::unspecialtext((string)$formData['foldvalue']).'" ';

		if($formData['fnewvalue'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_newvalue = "'.Helper::unspecialtext((string)$formData['fnewvalue']).'" ';

		if($formData['fedituserid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_edituserid = '.(int)$formData['fedituserid'].' ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_ipaddress = '.(int)$formData['fipaddress'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'oldvalue')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_oldvalue LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'newvalue')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'fuh.fuh_newvalue LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (fuh.fuh_oldvalue LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (fuh.fuh_newvalue LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'fuid')
			$orderString = 'fu_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'fuh_id ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'fuh_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'fuh_datemodified ' . $sorttype;
		else
			$orderString = 'fuh_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	public static function getDataByUserSheet($fuid , $uid)
   	{
   		$db3 = self::getDb();
   		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'forecast_uservalue_history
   				WHERE fu_id = ?
   				AND u_id = ?';
   		$row = $db3->query($sql , array($fuid , $uid))->fetch();

		$myForecastUservalueHistory               = new Core_Backend_ForecastUservalueHistory();

		$myForecastUservalueHistory->uid          = $row['u_id'];
		$myForecastUservalueHistory->fuid         = $row['fu_id'];
		$myForecastUservalueHistory->id           = $row['fuh_id'];
		$myForecastUservalueHistory->oldvalue     = $row['fuh_oldvalue'];
		$myForecastUservalueHistory->newvalue     = $row['fuh_newvalue'];
		$myForecastUservalueHistory->edituserid   = $row['fuh_edituserid'];
		$myForecastUservalueHistory->type = $row['fuh_type'];
		$myForecastUservalueHistory->fromsheet = $row['fuh_fromsheet'];
		$myForecastUservalueHistory->sessionid    = $row['fuh_sessionid'];
		$myForecastUservalueHistory->ipaddress    = long2ip($row['fuh_ipaddress']);
		$myForecastUservalueHistory->datecreated  = $row['fuh_datecreated'];
		$myForecastUservalueHistory->datemodified = $row['fuh_datemodified'];
   	}
}