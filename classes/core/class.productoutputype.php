<?php

/**
 * core/class.productoutputype.php
 *
 * File contains the class used for ProductOutputype Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductOutputype extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $issale = 0;
	public $isreward = 0;
	public $isdeleted = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_outputype (
					po_name,
					po_issale,
					po_isreward,
					po_isdeleted
					)
		        VALUES(?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->issale,
					(int)$this->isreward,
					(int)$this->isdeleted
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_outputype
				SET po_name = ?
				SET po_issale = ?
				SET po_isreward = ?
				SET po_isdeleted = ?
				WHERE po_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->issale,
					(int)$this->isreward,
					(int)$this->isdeleted,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_outputype po
				WHERE po.po_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['po_id'];
		$this->name = $row['po_name'];
		$this->issale = $row['po_issale'];
		$this->isreward = $row['po_isreward'];
		$this->isdeleted = $row['po_isdeleted'];
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_outputype
				WHERE po_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_outputype po';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_outputype po';

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
			$myProductOutputype = new Core_ProductOutputype();

			$myProductOutputype->id = $row['po_id'];
			$myProductOutputype->name = $row['po_name'];
			$myProductOutputype->issale = $row['po_issale'];
			$myProductOutputype->isreward = $row['po_isreward'];
			$myProductOutputype->isdeleted = $row['po_isdeleted'];


            $outputList[] = $myProductOutputype;
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
	public static function getProductOutputypes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'po.po_id = '.(int)$formData['fid'].' ';

		if(isset($formData['fissale']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.po_issale = '.(int)$formData['fissale'].' ';

		if(isset($formData['fisreward']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.po_isreward = '.(int)$formData['fisreward'].' ';

		if(isset($formData['fisdeleted']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.po_isdeleted = '.(int)$formData['fisdeleted'].' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'po_id ' . $sorttype;
		else
			$orderString = 'po_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}