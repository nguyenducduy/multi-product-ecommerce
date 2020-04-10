<?php

/**
 * core/class.subscriberproductoutofstock.php
 *
 * File contains the class used for SubscriberProductoutofstock Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_SubscriberProductoutofstock extends Core_Object
{
	const SENDMAILED = 1;
	const NOSENDMAIL = 0;
	const TYPE_OUTOFSTOCK = 1;
	const TYPE_COMMENT = 2;
	public $uid = 0;
	public $pid = 0;
	public $id = 0;
	public $email = "";
	public $status = 0;
	public $type = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'subscriber_productoutofstock (
					u_id,
					p_id,
					sp_email,
					sp_status,
					sp_type,
					sp_datecreated,
					sp_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->email,
					(int)$this->status,
					(int)$this->type,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'subscriber_productoutofstock
				SET u_id = ?,
					p_id = ?,
					sp_email = ?,
					sp_status = ?,
					sp_type = ?,
					sp_datecreated = ?,
					sp_datemodified = ?
				WHERE sp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->email,
					(int)$this->status,
					(int)$this->type,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'subscriber_productoutofstock sp
				WHERE sp.sp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['sp_id'];
		$this->email = $row['sp_email'];
		$this->status = $row['sp_status'];
		$this->type = $row['sp_type'];
		$this->datecreated = $row['sp_datecreated'];
		$this->datemodified = $row['sp_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'subscriber_productoutofstock
				WHERE sp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'subscriber_productoutofstock sp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'subscriber_productoutofstock sp';

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
			$mySubscriberProductoutofstock = new Core_SubscriberProductoutofstock();

			$mySubscriberProductoutofstock->uid = $row['u_id'];
			$mySubscriberProductoutofstock->pid = $row['p_id'];
			$mySubscriberProductoutofstock->id = $row['sp_id'];
			$mySubscriberProductoutofstock->email = $row['sp_email'];
			$mySubscriberProductoutofstock->status = $row['sp_status'];
			$mySubscriberProductoutofstock->type = $row['sp_type'];
			$mySubscriberProductoutofstock->datecreated = $row['sp_datecreated'];
			$mySubscriberProductoutofstock->datemodified = $row['sp_datemodified'];


            $outputList[] = $mySubscriberProductoutofstock;
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
	public static function getSubscriberProductoutofstocks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sp_id = '.(int)$formData['fid'].' ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sp_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'sp_id ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 'sp_email ' . $sorttype;
		else
			$orderString = 'sp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}