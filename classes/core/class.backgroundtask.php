<?php

/**
 * core/class.backgroundtask.php
 *
 * File contains the class used for backgroundtask Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_BackgroundTask extends Core_Object
{

	public $id = 0;
	public $url = '';
	public $postdata = '';
	public $ipaddress = 0;
	public $timeprocessing = 0;
	public $output = "";
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'backgroundtask (
					b_url,
					b_postdata,
					b_ipaddress,
					b_timeprocessing,
					b_output,
					b_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->url,
					(string)$this->postdata,
					(int)Helper::getIpAddress(true),
					(float)$this->timeprocessing,
					(string)$this->output,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'backgroundtask
				SET b_url = ?,
					b_postdata = ?,
					b_timeprocessing = ?,
					b_output = ?,
					b_datecreated = ?
				WHERE b_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->url,
					(string)$this->postdata,
					(float)$this->timeprocessing,
					(string)$this->output,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'backgroundtask b
				WHERE b.b_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['b_id'];
		$this->url = $row['b_url'];
		$this->postdata = $row['b_postdata'];
		$this->ipaddress = long2ip($row['b_ipaddress']);
		$this->timeprocessing = $row['b_timeprocessing'];
		$this->output = $row['b_output'];
		$this->datecreated = $row['b_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'backgroundtask
				WHERE b_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'backgroundtask b';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'backgroundtask b';

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
			$myBackgroundTask = new Core_BackgroundTask();

			$myBackgroundTask->id = $row['b_id'];
			$myBackgroundTask->url = $row['b_url'];
			$myBackgroundTask->postdata = $row['b_postdata'];
			$myBackgroundTask->ipaddress = long2ip($row['b_ipaddress']);
			$myBackgroundTask->timeprocessing = $row['b_timeprocessing'];
			$myBackgroundTask->output = $row['b_output'];
			$myBackgroundTask->datecreated = $row['b_datecreated'];


            $outputList[] = $myBackgroundTask;
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
	public static function getBackgroundTasks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_id = '.(int)$formData['fid'].' ';

		if($formData['fcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_controller = "'.(string)$formData['fcontroller'].'" ';

		if($formData['faction'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_action = "'.(string)$formData['faction'].'" ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'url')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_url LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'postdata')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_postdata LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'output')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_output LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (b.b_url LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (b.b_postdata LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (b.b_output LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'b_id ' . $sorttype;
		elseif($sortby == 'timeprocessing')
			$orderString = 'b_timeprocessing ' . $sorttype;
		else
			$orderString = 'b_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}