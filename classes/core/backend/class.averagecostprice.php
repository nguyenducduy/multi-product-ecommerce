<?php

/**
 * core/class.averagecostprice.php
 *
 * File contains the class used for Averagecostprice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Averagecostprice extends Core_Backend_Object
{

	public $pbarcode = "";
	public $id = 0;
	public $month = 0;
	public $year = 0;
	public $price = 0;
	public $orarowscn = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'averagecostprice (
					p_barcode,
					a_month,
					a_year,
					a_price,
					a_orarowscn
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->month,
					(int)$this->year,
					(float)$this->price,
					$this->orarowscn
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'averagecostprice
				SET p_barcode = ?,
					a_month = ?,
					a_year = ?,
					a_price = ?,
					a_orarowscn = ?
				WHERE a_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->month,
					(int)$this->year,
					(float)$this->price,
					$this->orarowscn,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'averagecostprice a
				WHERE a.a_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['a_id'];
		$this->month = $row['a_month'];
		$this->year = $row['a_year'];
		$this->price = $row['a_price'];
		$this->orarowscn = $row['a_orarowscn'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'averagecostprice
				WHERE a_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'averagecostprice a';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'averagecostprice a';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myAveragecostprice = new Core_Backend_Averagecostprice();

			$myAveragecostprice->pbarcode = $row['p_barcode'];
			$myAveragecostprice->id = $row['a_id'];
			$myAveragecostprice->month = $row['a_month'];
			$myAveragecostprice->year = $row['a_year'];
			$myAveragecostprice->price = $row['a_price'];
			$myAveragecostprice->orarowscn = $row['a_orarowscn'];


            $outputList[] = $myAveragecostprice;
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
	public static function getAveragecostprices($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['forarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_orarowscn = "'.Helper::unspecialtext((string)$formData['forarowscn']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_id = '.(int)$formData['fid'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_year = '.(int)$formData['fyear'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'a_id ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'a_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'a_year ' . $sorttype;
		else
			$orderString = 'a_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}