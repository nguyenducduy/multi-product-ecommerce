<?php

/**
 * core/class.messagetextstatus.php
 *
 * File contains the class used for MessageTextStatus Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_MessageTextStatus extends Core_Object
{
	const STATUS_INBOX = 1;
	const STATUS_INFOLDER = 3;
	const STATUS_INSPAM = 5;
	const STATUS_INTRASH = 7;
	const STATUS_DELETED = 10;


	public $mtid = 0;
	public $uid = 0;
	public $id = 0;
	public $isstarred = 0;
	public $isread = 0;
	public $status = 0;
	public $folderid = 0;
	public $datecreated = 0;
	public $dateread = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'message_text_status (
					mt_id,
					u_id,
					mts_isstarred,
					mts_isread,
					mts_status,
					mts_folderid,
					mts_datecreated,
					mts_dateread
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->mtid,
					(int)$this->uid,
					(int)$this->isstarred,
					(int)$this->isread,
					(int)$this->status,
					(int)$this->folderid,
					(int)$this->datecreated,
					(int)$this->dateread
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'message_text_status
				SET mt_id = ?,
					u_id = ?,
					mts_isstarred = ?,
					mts_isread = ?,
					mts_status = ?,
					mts_folderid = ?,
					mts_datecreated = ?,
					mts_dateread = ?
				WHERE mts_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->mtid,
					(int)$this->uid,
					(int)$this->isstarred,
					(int)$this->isread,
					(int)$this->status,
					(int)$this->folderid,
					(int)$this->datecreated,
					(int)$this->dateread,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_text_status mts
				WHERE mts.mts_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->mtid = $row['mt_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['mts_id'];
		$this->isstarred = $row['mts_isstarred'];
		$this->isread = $row['mts_isread'];
		$this->status = $row['mts_status'];
		$this->folderid = $row['mts_folderid'];
		$this->datecreated = $row['mts_datecreated'];
		$this->dateread = $row['mts_dateread'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'message_text_status
				WHERE mts_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'message_text_status mts';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'message_text_status mts';

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
			$myMessageTextStatus = new Core_MessageTextStatus();

			$myMessageTextStatus->mtid = $row['mt_id'];
			$myMessageTextStatus->uid = $row['u_id'];
			$myMessageTextStatus->id = $row['mts_id'];
			$myMessageTextStatus->isstarred = $row['mts_isstarred'];
			$myMessageTextStatus->isread = $row['mts_isread'];
			$myMessageTextStatus->status = $row['mts_status'];
			$myMessageTextStatus->folderid = $row['mts_folderid'];
			$myMessageTextStatus->datecreated = $row['mts_datecreated'];
			$myMessageTextStatus->dateread = $row['mts_dateread'];


            $outputList[] = $myMessageTextStatus;
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
	public static function getMessageTextStatuss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fmtid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mt_id = '.(int)$formData['fmtid'].' ';

		if($formData['fmtidstart'] > 0 && $formData['fmtidend'] > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(mts.mt_id BETWEEN '.(int)$formData['fmtidstart'].' AND '.(int)$formData['fmtidend'].') ';
		}
		else
		{
			if($formData['fmtidstart'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mt_id >= '.(int)$formData['fmtidstart'].' ';

			if($formData['fmtidend'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mt_id <= '.(int)$formData['fmtidend'].' ';
		}


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mts_id = '.(int)$formData['fid'].' ';

		if($formData['fisstarred'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mts_isstarred = '.(int)$formData['fisstarred'].' ';

		if($formData['fisread'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mts_isread = '.(int)$formData['fisread'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mts_status = '.(int)$formData['fstatus'].' ';

		if($formData['ffolderid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'mts.mts_folderid = '.(int)$formData['ffolderid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'mts_id ' . $sorttype;
		else
			$orderString = 'mts_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($this->status == self::STATUS_INTRASH && $name == 'intrash'
			|| $this->status == self::STATUS_INBOX && $name == 'inbox'
			|| $this->status == self::STATUS_INFOLDER && $name == 'inforlder'
			|| $this->status == self::STATUS_DELETED && $name == 'deleted');
	}


}