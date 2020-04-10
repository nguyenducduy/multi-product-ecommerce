<?php

/**
 * core/class.gamefasteye.php
 *
 * File contains the class used for Gamefasteye Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Gamefasteye Class
 */
Class Core_Gamefasteye extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $id = 0;
	public $name = '';
	public $rule = '';
	public $blockhtml = '';
	public $time = 0;
	public $starttime = 0;
	public $expiretime = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'gamefasteye (
					gfe_name,
					gfe_rule,
					gfe_blockhtml,
					gfe_time,
					gfe_starttime,
					gfe_expiretime,
					gfe_status,
					gfe_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->rule,
					(string)$this->blockhtml,
					(int)$this->time,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->status,
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'gamefasteye
				SET gfe_name = ?,
					gfe_rule = ?,
					gfe_blockhtml = ?,
					gfe_time = ?,
					gfe_starttime = ?,
					gfe_expiretime = ?,
					gfe_status = ?,
					gfe_datemodified = ?
				WHERE gfe_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->rule,
					(string)$this->blockhtml,
					(int)$this->time,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye g
				WHERE g.gfe_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = (int)$row['gfe_id'];
		$this->name = (string)$row['gfe_name'];
		$this->rule = (string)$row['gfe_rule'];
		$this->blockhtml = (string)$row['gfe_blockhtml'];
		$this->time = (int)$row['gfe_time'];
		$this->starttime = (int)$row['gfe_starttime'];
		$this->expiretime = (int)$row['gfe_expiretime'];
		$this->status = (int)$row['gfe_status'];
		$this->datecreated = (int)$row['gfe_datecreated'];
		$this->datemodified = (int)$row['gfe_datemodified'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'gamefasteye
				WHERE gfe_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'gamefasteye g';

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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye g';

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
			$myGamefasteye = new Core_Gamefasteye();

			$myGamefasteye->id = (int)$row['gfe_id'];
			$myGamefasteye->name = (string)$row['gfe_name'];
			$myGamefasteye->rule = (string)$row['gfe_rule'];
			$myGamefasteye->blockhtml = (string)$row['gfe_blockhtml'];
			$myGamefasteye->time = (int)$row['gfe_time'];
			$myGamefasteye->starttime = (int)$row['gfe_starttime'];
			$myGamefasteye->expiretime = (int)$row['gfe_expiretime'];
			$myGamefasteye->status = (int)$row['gfe_status'];
			$myGamefasteye->datecreated = (int)$row['gfe_datecreated'];
			$myGamefasteye->datemodified = (int)$row['gfe_datemodified'];
			

            $outputList[] = $myGamefasteye;
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
	public static function getGamefasteyes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.gfe_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.gfe_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fstarttime'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.gfe_starttime = '.(int)$formData['fstarttime'].' ';

		if($formData['fexpiretime'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.gfe_expiretime = '.(int)$formData['fexpiretime'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.gfe_status = '.(int)$formData['fstatus'].' ';


		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'gfe_id ' . $sorttype; 
		else
			$orderString = 'gfe_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disable';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLE: $name = 'Disable'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
			 || ($this->status == self::STATUS_DISABLE && $name == 'disable'))
			return true;
		else
			return false;
	}



}