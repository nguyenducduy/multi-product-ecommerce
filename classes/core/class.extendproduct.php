<?php

/**
 * core/class.extendproduct.php
 *
 * File contains the class used for Extendproduct Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Extendproduct extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $pid = 0;
	public $sid = 0;
	public $cusid = 0;
	public $id = 0;
	public $code = "";
	public $status = 0;
	public $note = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'extendproduct (
					p_id,
					s_id,
					cus_id,
					ep_code,
					ep_status,
					ep_note,
					ep_datecreated,
					ep_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->sid,
					(int)$this->cusid,
					(string)$this->code,
					(int)$this->status,
					(string)$this->note,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'extendproduct
				SET p_id = ?,
					s_id = ?,
					cus_id = ?,
					ep_code = ?,
					ep_status = ?,
					ep_note = ?,
					ep_datecreated = ?,
					ep_datemodified = ?
				WHERE ep_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->sid,
					(int)$this->cusid,
					(string)$this->code,
					(int)$this->status,
					(string)$this->note,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct e
				WHERE e.ep_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->sid = $row['s_id'];
		$this->cusid = $row['cus_id'];
		$this->id = $row['ep_id'];
		$this->code = $row['ep_code'];
		$this->status = $row['ep_status'];
		$this->note = $row['ep_note'];
		$this->datecreated = $row['ep_datecreated'];
		$this->datemodified = $row['ep_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'extendproduct
				WHERE ep_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'extendproduct e';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct e';

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
			$myExtendproduct = new Core_Extendproduct();

			$myExtendproduct->pid = $row['p_id'];
			$myExtendproduct->sid = $row['s_id'];
			$myExtendproduct->cusid = $row['cus_id'];
			$myExtendproduct->id = $row['ep_id'];
			$myExtendproduct->code = $row['ep_code'];
			$myExtendproduct->status = $row['ep_status'];
			$myExtendproduct->note = $row['ep_note'];
			$myExtendproduct->datecreated = $row['ep_datecreated'];
			$myExtendproduct->datemodified = $row['ep_datemodified'];


            $outputList[] = $myExtendproduct;
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
	public static function getExtendproducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fcusid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.cus_id = '.(int)$formData['fcusid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.ep_id = '.(int)$formData['fid'].' ';

		if($formData['fcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.ep_code = "'.Helper::unspecialtext((string)$formData['fcode']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.ep_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'code')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.ep_code LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (e.ep_code LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'cusid')
			$orderString = 'cus_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ep_id ' . $sorttype;
		else
			$orderString = 'ep_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

	public function getExtendproductByProductId($pid = 0)
	{
		if($pid > 0)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct
					WHERE p_id = ?';
			$row = $this->db->query($sql, array($pid))->fetch();

			$this->pid = $row['p_id'];
			$this->sid = $row['s_id'];
			$this->cusid = $row['cus_id'];
			$this->id = $row['ep_id'];
			$this->code = $row['ep_code'];
			$this->status = $row['ep_status'];
			$this->note = $row['ep_note'];
			$this->datecreated = $row['ep_datecreated'];
			$this->datemodified = $row['ep_datemodified'];
		}
	}

}