<?php

/**
 * core/class.crontask.php
 *
 * File contains the class used for Crontask Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Crontask extends Core_Object
{
	const STATUS_PROCESSING = 1;
	const STATUS_COMPLETED = 2;

	public $id = 0;
	public $controller = "";
	public $action = "";
	public $ipaddress = 0;
	public $timeprocessing = 0;
	public $output = "";
	public $status = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'crontask (
					c_controller,
					c_action,
					c_ipaddress,
					c_timeprocessing,
					c_output,
					c_status,
					c_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->controller,
					(string)$this->action,
					(int)Helper::getIpAddress(true),
					(float)$this->timeprocessing,
					(string)$this->output,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'crontask
				SET c_controller = ?,
					c_action = ?,
					c_timeprocessing = ?,
					c_output = ?,
					c_status = ?,
					c_datecreated = ?
				WHERE c_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->controller,
					(string)$this->action,
					(float)$this->timeprocessing,
					(string)$this->output,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'crontask c
				WHERE c.c_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['c_id'];
		$this->controller = $row['c_controller'];
		$this->action = $row['c_action'];
		$this->ipaddress = long2ip($row['c_ipaddress']);
		$this->timeprocessing = $row['c_timeprocessing'];
		$this->output = $row['c_output'];
		$this->status = $row['c_status'];
		$this->datecreated = $row['c_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'crontask
				WHERE c_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'crontask c';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'crontask c';

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
			$myCrontask = new Core_Crontask();

			$myCrontask->id = $row['c_id'];
			$myCrontask->controller = $row['c_controller'];
			$myCrontask->action = $row['c_action'];
			$myCrontask->ipaddress = long2ip($row['c_ipaddress']);
			$myCrontask->timeprocessing = $row['c_timeprocessing'];
			$myCrontask->output = $row['c_output'];
			$myCrontask->status = $row['c_status'];
			$myCrontask->datecreated = $row['c_datecreated'];


            $outputList[] = $myCrontask;
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
	public static function getCrontasks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_id = '.(int)$formData['fid'].' ';

		if($formData['fcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_controller = "'.(string)$formData['fcontroller'].'" ';

		if($formData['faction'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_action = "'.(string)$formData['faction'].'" ';

		if($formData['fstatus'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'controller')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_controller LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'action')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_action LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'output')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'c.c_output LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (c.c_controller LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (c.c_action LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (c.c_output LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'c_id ' . $sorttype;
		elseif($sortby == 'timeprocessing')
			$orderString = 'c_timeprocessing ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'c_status ' . $sorttype;
		else
			$orderString = 'c_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_PROCESSING: $name = 'Processing'; break;
			case self::STATUS_COMPLETED: $name = 'Completed'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return (($this->status == self::STATUS_PROCESSING && $name == 'processing')
			|| ($this->status == self::STATUS_COMPLETED && $name == 'completed'));
	}

}