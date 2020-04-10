<?php

/**
 * core/class.beginminstock.php
 *
 * File contains the class used for Beginminstock Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_Beginminstock extends Core_Backend_Object
{

	public $pbarcode = "";
	public $sid = 0;
	public $id = 0;
	public $imei = 0;
	public $month = 0;
	public $year = 0;
	public $quantity = 0;
	public $costprice = 0;
	public $isnew = 0;
	public $isshowproduct = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'beginminstock (
					p_barcode,
					s_id,
					b_imei,
					b_month,
					b_year,
					b_quantity,
					b_costprice,
					b_isnew,
					b_isshowproduct,
					b_orarowscn
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
					(string)$this->imei,
					(int)$this->month,
					(int)$this->year,
					(float)$this->quantity,
					(float)$this->costprice,
					(int)$this->isnew,
					(int)$this->isshowproduct,
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
		if ($this->id <= 0) return false;
		$sql = 'UPDATE ' . TABLE_PREFIX . 'beginminstock
				SET p_barcode = ?,
					s_id = ?,
					b_imei = ?,
					b_month = ?,
					b_year = ?,
					b_quantity = ?,
					b_costprice = ?,
					b_isnew = ?,
					b_isshowproduct = ?,
					b_orarowscn = ?
				WHERE b_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
					(string)$this->imei,
					(int)$this->month,
					(int)$this->year,
					(float)$this->quantity,
					(float)$this->costprice,
					(int)$this->isnew,
					(int)$this->isshowproduct,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'beginminstock b
				WHERE b.b_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->sid = $row['s_id'];
		$this->id = $row['b_id'];
		$this->imei = $row['b_imei'];
		$this->month = $row['b_month'];
		$this->year = $row['b_year'];
		$this->quantity = $row['b_quantity'];
		$this->costprice = $row['b_costprice'];
		$this->isnew = $row['b_isnew'];
		$this->isshowproduct = $row['b_isshowproduct'];
		$this->orarowscn = $row['b_orarowscn'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'beginminstock
				WHERE b_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'beginminstock b';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'beginminstock b';

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
			$myBeginminstock = new Core_Backend_Beginminstock();

			$myBeginminstock->pbarcode = $row['p_barcode'];
			$myBeginminstock->sid = $row['s_id'];
			$myBeginminstock->id = $row['b_id'];
			$myBeginminstock->imei = $row['b_imei'];
			$myBeginminstock->month = $row['b_month'];
			$myBeginminstock->year = $row['b_year'];
			$myBeginminstock->quantity = $row['b_quantity'];
			$myBeginminstock->costprice = $row['b_costprice'];
			$myBeginminstock->isnew = $row['b_isnew'];
			$myBeginminstock->isshowproduct = $row['b_isshowproduct'];
			$myBeginminstock->orarowscn = $row['b_orarowscn'];


            $outputList[] = $myBeginminstock;
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
	public static function getBeginminstocks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['forarowscn'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_orarowscn = "'.Helper::unspecialtext((string)$formData['forarowscn']).'" ';

		if($formData['fimei'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_imei = "'.(string)$formData['fimei'].'" ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_id = '.(int)$formData['fid'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_year = '.(int)$formData['fyear'].' ';

		if($formData['fquantity'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_quantity = '.(float)$formData['fquantity'].' ';

		if($formData['fcostprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_costprice = '.(float)$formData['fcostprice'].' ';

		if($formData['fisnew'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_isnew = '.(int)$formData['fisnew'].' ';

		if($formData['fisshowproduct'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'b.b_isshowproduct = '.(int)$formData['fisshowproduct'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'b_id ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'b_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'b_year ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'b_quantity ' . $sorttype;
		elseif($sortby == 'costprice')
			$orderString = 'b_costprice ' . $sorttype;
		else
			$orderString = 'b_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}
	public static function updateDataByBarcode($b_costprice, $condtion)
	{
		$db3 = self::getDb();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'beginminstock
				SET b_costprice = ?
				WHERE p_barcode = ? AND s_id = ? AND b_month = ? AND b_year = ?';

		$stmt = $db3->query($sql, array(
					(float)$b_costprice,
					(string)trim($condtion['p_barcode']),
					(int)$condtion['s_id'],
					(int)$condtion['b_month'],
					(int)$condtion['b_year']
					));

		if($stmt)
			return true;
		else
			return false;
	}

}