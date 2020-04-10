<?php

/**
 * core/class.relstoreprice.php
 *
 * File contains the class used for RelStorePrice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelStorePrice extends Core_Object
{

	public $sid = 0;
	public $pid = 0;
	public $prid = 0;
	public $id = 0;
	public $unitprice = 0;
	public $sellprice = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_store_price (
					s_id,
					p_id,
					pr_id,
					rsp_unitprice,
					rsp_sellprice,
					rsp_datecreated,
					rsp_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->sid,
					(int)$this->pid,
					(int)$this->prid,
					(float)$this->unitprice,
					(float)$this->sellprice,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_store_price
				SET s_id = ?,
					p_id = ?,
					pr_id = ?,
					rsp_unitprice = ?,
					rsp_sellprice = ?,
					rsp_datecreated = ?,
					rsp_datemodified = ?
				WHERE rsp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->sid,
					(int)$this->pid,
					(int)$this->prid,
					(float)$this->unitprice,
					(float)$this->sellprice,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_store_price rsp
				WHERE rsp.rsp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->sid = $row['s_id'];
		$this->pid = $row['p_id'];
		$this->prid = $row['pr_id'];
		$this->id = $row['rsp_id'];
		$this->unitprice = $row['rsp_unitprice'];
		$this->sellprice = $row['rsp_sellprice'];
		$this->datecreated = $row['rsp_datecreated'];
		$this->datemodified = $row['rsp_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_store_price
				WHERE rsp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_store_price rsp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_store_price rsp';

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
			$myRelStorePrice = new Core_RelStorePrice();

			$myRelStorePrice->sid = $row['s_id'];
			$myRelStorePrice->pid = $row['p_id'];
			$myRelStorePrice->prid = $row['pr_id'];
			$myRelStorePrice->id = $row['rsp_id'];
			$myRelStorePrice->unitprice = $row['rsp_unitprice'];
			$myRelStorePrice->sellprice = $row['rsp_sellprice'];
			$myRelStorePrice->datecreated = $row['rsp_datecreated'];
			$myRelStorePrice->datemodified = $row['rsp_datemodified'];


            $outputList[] = $myRelStorePrice;
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
	public static function getRelStorePrices($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fprid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.pr_id = '.(int)$formData['fprid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.rsp_id = '.(int)$formData['fid'].' ';

		if($formData['funitprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.rsp_unitprice = '.(float)$formData['funitprice'].' ';

		if($formData['fsellprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rsp.rsp_sellprice = '.(float)$formData['fsellprice'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'prid')
			$orderString = 'pr_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'rsp_id ' . $sorttype;
		else
			$orderString = 'rsp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}