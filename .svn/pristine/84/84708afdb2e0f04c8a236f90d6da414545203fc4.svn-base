<?php

/**
 * core/class.productguess.php
 *
 * File contains the class used for ProductGuess Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductGuess extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;
	const STATUS_EXPIRED = 3;

	public $uid = 0;
	public $pid = 0;
	public $id = 0;
	public $name = "";
	public $infogift = "";
	public $rule = "";
	public $blockhtml = "";
	public $blocknews = "";
	public $blockuser = "";
	public $starttime = 0;
	public $expiretime = 0;
	public $oldonsitestatus = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_guess (
					u_id,
					p_id,
					pg_name,
					pg_infogift,
					pg_rule,
					pg_blockhtml,
					pg_blocknews,
					pg_blockuser,
					pg_starttime,
					pg_expiretime,
					pg_oldonsitestatus,
					pg_status,
					pg_datecreated,
					pg_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->name,
					(string)$this->infogift,
					(string)$this->rule,
					(string)$this->blockhtml,
					(string)$this->blocknews,
					(string)$this->blockuser,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->oldonsitestatus,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_guess
				SET u_id = ?,
					p_id = ?,
					pg_name = ?,
					pg_infogift = ?,
					pg_rule = ?,
					pg_blockhtml = ?,
					pg_blocknews = ?,
					pg_blockuser = ?,
					pg_starttime = ?,
					pg_expiretime = ?,
					pg_oldonsitestatus = ?,
					pg_status = ?,
					pg_datecreated = ?,
					pg_datemodified = ?
				WHERE pg_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->name,
					(string)$this->infogift,
					(string)$this->rule,
					(string)$this->blockhtml,
					(string)$this->blocknews,
					(string)$this->blockuser,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->oldonsitestatus,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_guess pg
				WHERE pg.pg_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['pg_id'];
		$this->name = $row['pg_name'];
		$this->infogift = $row['pg_infogift'];
		$this->rule = $row['pg_rule'];
		$this->blockhtml = $row['pg_blockhtml'];
		$this->blocknews = $row['pg_blocknews'];
		$this->blockuser = $row['pg_blockuser'];
		$this->starttime = $row['pg_starttime'];
		$this->expiretime = $row['pg_expiretime'];
		$this->oldonsitestatus = $row['pg_oldonsitestatus'];
		$this->status = $row['pg_status'];
		$this->datecreated = $row['pg_datecreated'];
		$this->datemodified = $row['pg_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_guess
				WHERE pg_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_guess pg';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_guess pg';

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
			$myProductGuess = new Core_ProductGuess();

			$myProductGuess->uid = $row['u_id'];
			$myProductGuess->pid = $row['p_id'];
			$myProductGuess->id = $row['pg_id'];
			$myProductGuess->name = $row['pg_name'];
			$myProductGuess->infogift = $row['pg_infogift'];
			$myProductGuess->rule = $row['pg_rule'];
			$myProductGuess->blockhtml = $row['pg_blockhtml'];
			$myProductGuess->blocknews = $row['pg_blocknews'];
			$myProductGuess->blockuser = $row['pg_blockuser'];
			$myProductGuess->starttime = $row['pg_starttime'];
			$myProductGuess->expiretime = $row['pg_expiretime'];
			$myProductGuess->oldonsitestatus = $row['pg_oldonsitestatus'];
			$myProductGuess->status = $row['pg_status'];
			$myProductGuess->datecreated = $row['pg_datecreated'];
			$myProductGuess->datemodified = $row['pg_datemodified'];


            $outputList[] = $myProductGuess;
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
	public static function getProductGuesss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pg.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pg.pg_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pg.pg_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pg.pg_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (pg.pg_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pg_id ' . $sorttype;
		else
			$orderString = 'pg_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disabled';
		//$output[self::STATUS_EXPIRED] = 'Expired';

		return $output;
	}
 	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($name == 'enable' && $this->status == self::STATUS_ENABLE ||
			$name = 'disable' && $this->status == self::STATUS_DISABLE ||
			$name = 'expired' && $this->status == self::STATUS_EXPIRED
		);

	}
	public function getstatusName()
	{
        $name = '';
        switch($this->status)
        {
            case self::STATUS_ENABLE : $name = 'enable'; break;
            case self::STATUS_DISABLE : $name = 'disable'; break;
            case self::STATUS_EXPIRED : $name = 'expired'; break;
        }

        return $name;
	}
}