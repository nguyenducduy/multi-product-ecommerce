<?php

/**
 * core/class.relcalendareventuser.php
 *
 * File contains the class used for RelCalendarEventUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelCalendarEventUser extends Core_Object
{

	public $uid = 0;
	public $ceid = 0;
	public $id = 0;
	public $status = 0;
	public $datecreated = 0;
	public $dateviewed = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_calendar_event_user (
					u_id,
					ce_id,
					ceu_status,
					ceu_datecreated,
					ceu_dateviewed
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->ceid,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->dateviewed
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_calendar_event_user
				SET u_id = ?,
					ce_id = ?,
					ceu_status = ?,
					ceu_datecreated = ?,
					ceu_dateviewed = ?
				WHERE ceu_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->ceid,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->dateviewed,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_calendar_event_user ceu
				WHERE ceu.ceu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->ceid = $row['ce_id'];
		$this->id = $row['ceu_id'];
		$this->status = $row['ceu_status'];
		$this->datecreated = $row['ceu_datecreated'];
		$this->dateviewed = $row['ceu_dateviewed'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_calendar_event_user
				WHERE ceu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_calendar_event_user ceu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_calendar_event_user ceu';

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
			$myRelCalendarEventUser = new Core_RelCalendarEventUser();

			$myRelCalendarEventUser->uid = $row['u_id'];
			$myRelCalendarEventUser->ceid = $row['ce_id'];
			$myRelCalendarEventUser->id = $row['ceu_id'];
			$myRelCalendarEventUser->status = $row['ceu_status'];
			$myRelCalendarEventUser->datecreated = $row['ceu_datecreated'];
			$myRelCalendarEventUser->dateviewed = $row['ceu_dateviewed'];


            $outputList[] = $myRelCalendarEventUser;
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
	public static function getRelCalendarEventUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ceu.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fceid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ceu.ce_id = '.(int)$formData['fceid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ceu.ceu_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ceu.ceu_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ceu_id ' . $sorttype;
		else
			$orderString = 'ceu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}