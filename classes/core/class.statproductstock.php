<?php

/**
 * core/class.statproductstock.php
 *
 * File contains the class used for StatProductstock Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_StatProductstock extends Core_Object
{

	public $pbarcode = "";
	public $sid = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_productstock (
					p_barcode,
					s_id,
					sd_quantity,
					sd_day,
					sd_month,
					sd_year
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'stat_productstock
				SET p_barcode = ?,
					s_id = ?,
					sd_quantity = ?,
					sd_day = ?,
					sd_month = ?,
					sd_year = ?
				WHERE sd_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productstock sp
				WHERE sp.sd_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->sid = $row['s_id'];
		$this->id = $row['sd_id'];
		$this->quantity = $row['sd_quantity'];
		$this->day = $row['sd_day'];
		$this->month = $row['sd_month'];
		$this->year = $row['sd_year'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stat_productstock
				WHERE sd_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_productstock sp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productstock sp';

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
			$myStatProductstock = new Core_StatProductstock();

			$myStatProductstock->pbarcode = $row['p_barcode'];
			$myStatProductstock->sid = $row['s_id'];
			$myStatProductstock->id = $row['sd_id'];
			$myStatProductstock->quantity = $row['sd_quantity'];
			$myStatProductstock->day = $row['sd_day'];
			$myStatProductstock->month = $row['sd_month'];
			$myStatProductstock->year = $row['sd_year'];


            $outputList[] = $myStatProductstock;
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
	public static function getStatProductstocks($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sd_id = '.(int)$formData['fid'].' ';

		if($formData['fday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sd_day = '.(int)$formData['fday'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sd_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sd_year = '.(int)$formData['fyear'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'pbarcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (sp.p_barcode LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 'p_barcode ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'sd_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'sd_quantity ' . $sorttype;
		elseif($sortby == 'day')
			$orderString = 'sd_day ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'sd_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'sd_year ' . $sorttype;
		else
			$orderString = 'sd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}