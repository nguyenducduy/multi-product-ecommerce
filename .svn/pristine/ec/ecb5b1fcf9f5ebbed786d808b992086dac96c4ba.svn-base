<?php

/**
 * core/class.stuffreviewthumb.php
 *
 * File contains the class used for StuffReviewThumb Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_StuffReviewThumb extends Core_Object
{

	public $robjectid = 0;
	public $rid = 0;
	public $uid = 0;
	public $id = 0;
	public $value = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stuff_review_thumb (
					r_objectid,
					r_id,
					u_id,
					rt_value,
					rt_ipaddress,
					rt_datecreated,
					rt_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->robjectid,
					(int)$this->rid,
					(int)$this->uid,
					(int)$this->value,
					(int)$this->ipaddress,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff_review_thumb
				SET r_objectid = ?,
					r_id = ?,
					u_id = ?,
					rt_value = ?,
					rt_ipaddress = ?,
					rt_datecreated = ?,
					rt_datemodified = ?
				WHERE rt_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->robjectid,
					(int)$this->rid,
					(int)$this->uid,
					(int)$this->value,
					(int)$this->ipaddress,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff_review_thumb srt
				WHERE srt.rt_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->robjectid = $row['r_objectid'];
		$this->rid = $row['r_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['rt_id'];
		$this->value = $row['rt_value'];
		$this->ipaddress = $row['rt_ipaddress'];
		$this->datecreated = $row['rt_datecreated'];
		$this->datemodified = $row['rt_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stuff_review_thumb
				WHERE rt_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stuff_review_thumb srt';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff_review_thumb srt';

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
			$myStuffReviewThumb = new Core_StuffReviewThumb();

			$myStuffReviewThumb->robjectid = $row['r_objectid'];
			$myStuffReviewThumb->rid = $row['r_id'];
			$myStuffReviewThumb->uid = $row['u_id'];
			$myStuffReviewThumb->id = $row['rt_id'];
			$myStuffReviewThumb->value = $row['rt_value'];
			$myStuffReviewThumb->ipaddress = $row['rt_ipaddress'];
			$myStuffReviewThumb->datecreated = $row['rt_datecreated'];
			$myStuffReviewThumb->datemodified = $row['rt_datemodified'];


            $outputList[] = $myStuffReviewThumb;
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
	public static function getStuffReviewThumbs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['frobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.r_objectid = '.(int)$formData['frobjectid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.r_id = '.(int)$formData['frid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.rt_id = '.(int)$formData['fid'].' ';

		if($formData['fvalue'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.rt_value = '.(int)$formData['fvalue'].' ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.rt_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'srt.rt_datecreated = '.(int)$formData['fdatecreated'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'robjectid')
			$orderString = 'r_objectid ' . $sorttype;
		elseif($sortby == 'rid')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rt_id ' . $sorttype;
		elseif($sortby == 'value')
			$orderString = 'rt_value ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'rt_datecreated ' . $sorttype;
		else
			$orderString = 'rt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}