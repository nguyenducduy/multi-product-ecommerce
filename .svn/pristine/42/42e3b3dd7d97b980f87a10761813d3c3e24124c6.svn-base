<?php

/**
 * core/class.calendarevent.php
 *
 * File contains the class used for CalendarEvent Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_CalendarEvent extends Core_Object
{

	public $uid = 0;
	public $cid = 0;
	public $ccid = 0;
	public $id = 0;
	public $name = "";
	public $description = "";
	public $address = "";
	public $region = 0;
	public $lat = 0;
	public $lng = 0;
	public $datestart = 0;
	public $dateend = 0;
	public $timestart = 0;
	public $timeend = 0;
	public $isrepeat = 0;
	public $repeattype = 0;
	public $repeatweekday = "";
	public $repeatmonthday = "";
	public $partnertype = 0;
	public $partnerid = 0;
	public $partnerdatesynced = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'calendar_event (
					u_id,
					c_id,
					cc_id,
					ce_name,
					ce_description,
					ce_address,
					ce_region,
					ce_lat,
					ce_lng,
					ce_datestart,
					ce_dateend,
					ce_timestart,
					ce_timeend,
					ce_isrepeat,
					ce_repeattype,
					ce_repeatweekday,
					ce_repeatmonthday,
					ce_partnertype,
					ce_partnerid,
					ce_partnerdatesynced,
					ce_status,
					ce_datecreated,
					ce_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->cid,
					(int)$this->ccid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->address,
					(int)$this->region,
					(float)$this->lat,
					(float)$this->lng,
					(int)$this->datestart,
					(int)$this->dateend,
					(int)$this->timestart,
					(int)$this->timeend,
					(int)$this->isrepeat,
					(int)$this->repeattype,
					(string)$this->repeatweekday,
					(string)$this->repeatmonthday,
					(int)$this->partnertype,
					(int)$this->partnerid,
					(int)$this->partnerdatesynced,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'calendar_event
				SET u_id = ?,
					c_id = ?,
					cc_id = ?,
					ce_name = ?,
					ce_description = ?,
					ce_address = ?,
					ce_region = ?,
					ce_lat = ?,
					ce_lng = ?,
					ce_datestart = ?,
					ce_dateend = ?,
					ce_timestart = ?,
					ce_timeend = ?,
					ce_isrepeat = ?,
					ce_repeattype = ?,
					ce_repeatweekday = ?,
					ce_repeatmonthday = ?,
					ce_partnertype = ?,
					ce_partnerid = ?,
					ce_partnerdatesynced = ?,
					ce_status = ?,
					ce_datecreated = ?,
					ce_datemodified = ?
				WHERE ce_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->cid,
					(int)$this->ccid,
					(string)$this->name,
					(string)$this->description,
					(string)$this->address,
					(int)$this->region,
					(float)$this->lat,
					(float)$this->lng,
					(int)$this->datestart,
					(int)$this->dateend,
					(int)$this->timestart,
					(int)$this->timeend,
					(int)$this->isrepeat,
					(int)$this->repeattype,
					(string)$this->repeatweekday,
					(string)$this->repeatmonthday,
					(int)$this->partnertype,
					(int)$this->partnerid,
					(int)$this->partnerdatesynced,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'calendar_event ce
				WHERE ce.ce_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->cid = $row['c_id'];
		$this->ccid = $row['cc_id'];
		$this->id = $row['ce_id'];
		$this->name = $row['ce_name'];
		$this->description = $row['ce_description'];
		$this->address = $row['ce_address'];
		$this->region = $row['ce_region'];
		$this->lat = $row['ce_lat'];
		$this->lng = $row['ce_lng'];
		$this->datestart = $row['ce_datestart'];
		$this->dateend = $row['ce_dateend'];
		$this->timestart = $row['ce_timestart'];
		$this->timeend = $row['ce_timeend'];
		$this->isrepeat = $row['ce_isrepeat'];
		$this->repeattype = $row['ce_repeattype'];
		$this->repeatweekday = $row['ce_repeatweekday'];
		$this->repeatmonthday = $row['ce_repeatmonthday'];
		$this->partnertype = $row['ce_partnertype'];
		$this->partnerid = $row['ce_partnerid'];
		$this->partnerdatesynced = $row['ce_partnerdatesynced'];
		$this->status = $row['ce_status'];
		$this->datecreated = $row['ce_datecreated'];
		$this->datemodified = $row['ce_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'calendar_event
				WHERE ce_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'calendar_event ce';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'calendar_event ce';

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
			$myCalendarEvent = new Core_CalendarEvent();

			$myCalendarEvent->uid = $row['u_id'];
			$myCalendarEvent->cid = $row['c_id'];
			$myCalendarEvent->ccid = $row['cc_id'];
			$myCalendarEvent->id = $row['ce_id'];
			$myCalendarEvent->name = $row['ce_name'];
			$myCalendarEvent->description = $row['ce_description'];
			$myCalendarEvent->address = $row['ce_address'];
			$myCalendarEvent->region = $row['ce_region'];
			$myCalendarEvent->lat = $row['ce_lat'];
			$myCalendarEvent->lng = $row['ce_lng'];
			$myCalendarEvent->datestart = $row['ce_datestart'];
			$myCalendarEvent->dateend = $row['ce_dateend'];
			$myCalendarEvent->timestart = $row['ce_timestart'];
			$myCalendarEvent->timeend = $row['ce_timeend'];
			$myCalendarEvent->isrepeat = $row['ce_isrepeat'];
			$myCalendarEvent->repeattype = $row['ce_repeattype'];
			$myCalendarEvent->repeatweekday = $row['ce_repeatweekday'];
			$myCalendarEvent->repeatmonthday = $row['ce_repeatmonthday'];
			$myCalendarEvent->partnertype = $row['ce_partnertype'];
			$myCalendarEvent->partnerid = $row['ce_partnerid'];
			$myCalendarEvent->partnerdatesynced = $row['ce_partnerdatesynced'];
			$myCalendarEvent->status = $row['ce_status'];
			$myCalendarEvent->datecreated = $row['ce_datecreated'];
			$myCalendarEvent->datemodified = $row['ce_datemodified'];


            $outputList[] = $myCalendarEvent;
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
	public static function getCalendarEvents($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.c_id = '.(int)$formData['fcid'].' ';

		if($formData['fccid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.cc_id = '.(int)$formData['fccid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fregion'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_region = '.(int)$formData['fregion'].' ';

		if($formData['fdatestart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_datestart = '.(int)$formData['fdatestart'].' ';

		if($formData['fdateend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_dateend = '.(int)$formData['fdateend'].' ';

		if($formData['fisrepeat'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_isrepeat = '.(int)$formData['fisrepeat'].' ';

		if($formData['frepeattype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_repeattype = '.(int)$formData['frepeattype'].' ';

		if($formData['fpartnertype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_partnertype = '.(int)$formData['fpartnertype'].' ';

		if($formData['fpartnerid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_partnerid = '.(int)$formData['fpartnerid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'description')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ce.ce_description LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ce.ce_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ce.ce_description LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ce_id ' . $sorttype;
		else
			$orderString = 'ce_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}