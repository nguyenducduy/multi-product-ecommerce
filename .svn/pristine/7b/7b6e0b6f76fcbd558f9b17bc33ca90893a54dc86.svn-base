<?php

/**
 * core/class.statorderproduct.php
 *
 * File contains the class used for StatOrderproduct Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_StatOrderproduct extends Core_Object
{

	public $pbarcode = "";
	public $id = 0;
	public $quantity = 0;
	public $day = 0;
	public $month = 0;
	public $year = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_orderproduct (
					p_barcode,
					od_quantity,
					od_day,
					od_month,
					od_year
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->quantity,
					(int)$this->day,
					(int)$this->month,
					(int)$this->year
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'stat_orderproduct
				SET p_barcode = ?,
					od_quantity = ?,
					od_day = ?,
					od_month = ?,
					od_year = ?
				WHERE od_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->quantity,
					(int)$this->day,
					(int)$this->month,
					(int)$this->year,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_orderproduct so
				WHERE so.od_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['od_id'];
		$this->quantity = $row['od_quantity'];
		$this->day = $row['od_day'];
		$this->month = $row['od_month'];
		$this->year = $row['od_year'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stat_orderproduct
				WHERE od_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_orderproduct so';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_orderproduct so';

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
			$myStatOrderproduct = new Core_StatOrderproduct();

			$myStatOrderproduct->pbarcode = $row['p_barcode'];
			$myStatOrderproduct->id = $row['od_id'];
			$myStatOrderproduct->quantity = $row['od_quantity'];
			$myStatOrderproduct->day = $row['od_day'];
			$myStatOrderproduct->month = $row['od_month'];
			$myStatOrderproduct->year = $row['od_year'];


            $outputList[] = $myStatOrderproduct;
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
	public static function getStatOrderproducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.od_id = '.(int)$formData['fid'].' ';

		if($formData['fday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.od_day = '.(int)$formData['fday'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.od_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.od_year = '.(int)$formData['fyear'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'pbarcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'so.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (so.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'od_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'od_quantity ' . $sorttype;
		elseif($sortby == 'day')
			$orderString = 'od_day ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'od_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'od_year ' . $sorttype;
		else
			$orderString = 'od_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}