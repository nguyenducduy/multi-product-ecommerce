<?php

/**
 * core/class.productyear.php
 *
 * File contains the class used for Productyear Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Productyear Class
 */
Class Core_Productyear extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $pid = 0;
	public $id = 0;
	public $countarticle = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productyear (
					p_id,
					py_countarticle,
					py_status,
					py_datecreated
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->countarticle,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'productyear
				SET p_id = ?,
					py_countarticle = ?,
					py_status = ?,
					py_datemodified = ?
				WHERE py_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->countarticle,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear p
				WHERE p.py_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = (int)$row['p_id'];
		$this->id = (int)$row['py_id'];
		$this->countarticle = (int)$row['py_countarticle'];
		$this->status = (int)$row['py_status'];
		$this->datecreated = (int)$row['py_datecreated'];
		$this->datemodified = (int)$row['py_datemodified'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productyear
				WHERE py_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productyear p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear p';

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
			$myProductyear = new Core_Productyear();

			$myProductyear->pid = (int)$row['p_id'];
			$myProductyear->id = (int)$row['py_id'];
			$myProductyear->countarticle = (int)$row['py_countarticle'];
			$myProductyear->status = (int)$row['py_status'];
			$myProductyear->datecreated = (int)$row['py_datecreated'];
			$myProductyear->datemodified = (int)$row['py_datemodified'];
			

            $outputList[] = $myProductyear;
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
	public static function getProductyears($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.py_id = '.(int)$formData['fid'].' ';

		if($formData['fcountarticle'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.py_countarticle = '.(int)$formData['fcountarticle'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.py_status = '.(int)$formData['fstatus'].' ';


		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'py_id ' . $sorttype; 
		elseif($sortby == 'countarticle')
			$orderString = 'py_countarticle ' . $sorttype; 
		else
			$orderString = 'py_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disable';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disable'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
			 || ($this->status == self::STATUS_DISABLED && $name == 'disable'))
			return true;
		else
			return false;
	}



}