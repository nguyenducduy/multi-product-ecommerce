<?php

/**
 * core/class.eventuserhours.php
 *
 * File contains the class used for EventUserHours Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_EventUserHours extends Core_Object
{
	public $epid = 0;
	public $id = 0;
	public $fullname = "";
	public $email = "";
	public $phone = "";
	public $datecreated = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'event_user_hours (
					ep_id,
					eu_fullname,
					eu_email,
					eu_phone,
					eu_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->epid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->phone,
					(int)$this->datecreated
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'event_user_hours
				SET ep_id = ?,
					eu_fullname = ?,
					eu_email = ?,
					eu_phone = ?,
					eu_datecreated = ?
				WHERE eu_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->epid,
					(string)$this->fullname,
					(string)$this->email,
					(string)$this->phone,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_user_hours eu
				WHERE eu.eu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->epid = $row['ep_id'];
		$this->id = $row['eu_id'];
		$this->fullname = $row['eu_fullname'];
		$this->email = $row['eu_email'];
		$this->phone = $row['eu_phone'];
		$this->datecreated = $row['eu_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'event_user_hours
				WHERE eu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'event_user_hours eu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_user_hours eu';

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
			$myEventUserHours = new Core_EventUserHours();

			$myEventUserHours->epid = $row['ep_id'];
			$myEventUserHours->id = $row['eu_id'];
			$myEventUserHours->fullname = $row['eu_fullname'];
			$myEventUserHours->email = $row['eu_email'];
			$myEventUserHours->phone = $row['eu_phone'];
			$myEventUserHours->datecreated = $row['eu_datecreated'];


            $outputList[] = $myEventUserHours;
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
	public static function getEventUserHourss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fepid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.ep_id = '.(int)$formData['fepid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_id = '.(int)$formData['fid'].' ';

		if($formData['fidarr'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_id IN( '.implode(',' , $formData['fidarr']).') ';

		if($formData['ffullname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_fullname = "'.Helper::unspecialtext((string)$formData['ffullname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_phone = "'.Helper::unspecialtext((string)$formData['fphone']).'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'eu.eu_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (eu.eu_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (eu.eu_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (eu.eu_phone LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'epid')
			$orderString = 'ep_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'eu_id ' . $sorttype;
		elseif($sortby == 'fullname')
			$orderString = 'eu_fullname ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 'eu_email ' . $sorttype;
		elseif($sortby == 'phone')
			$orderString = 'eu_phone ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'eu_datecreated ' . $sorttype;
		else
			$orderString = 'eu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}