<?php

/**
 * core/class.eventtheme.php
 *
 * File contains the class used for Eventtheme Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Eventtheme extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $header = "";
	public $footer = "";
	public $description = "";
	public $classidentifier = "";
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'eventtheme (
					et_name,
					et_header,
					et_footer,
					et_description,
					et_classidentifier,
					et_datecreated,
					et_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->header,
					(string)$this->footer,
					(string)$this->description,
					(string)$this->classidentifier,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'eventtheme
				SET et_name = ?,
					et_header = ?,
					et_footer = ?,
					et_description = ?,
					et_classidentifier = ?,
					et_datecreated = ?,
					et_datemodified = ?
				WHERE et_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->header,
					(string)$this->footer,
					(string)$this->description,
					(string)$this->classidentifier,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'eventtheme e
				WHERE e.et_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['et_id'];
		$this->name = $row['et_name'];
		$this->header = $row['et_header'];
		$this->footer = $row['et_footer'];
		$this->description = $row['et_description'];
		$this->classidentifier = $row['et_classidentifier'];
		$this->datecreated = $row['et_datecreated'];
		$this->datemodified = $row['et_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'eventtheme
				WHERE et_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'eventtheme e';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'eventtheme e';

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
			$myEventtheme = new Core_Eventtheme();

			$myEventtheme->id = $row['et_id'];
			$myEventtheme->name = $row['et_name'];
			$myEventtheme->header = $row['et_header'];
			$myEventtheme->footer = $row['et_footer'];
			$myEventtheme->description = $row['et_description'];
			$myEventtheme->classidentifier = $row['et_classidentifier'];
			$myEventtheme->datecreated = $row['et_datecreated'];
			$myEventtheme->datemodified = $row['et_datemodified'];


            $outputList[] = $myEventtheme;
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
	public static function getEventthemes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.et_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'et_id ' . $sorttype;
		else
			$orderString = 'et_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}