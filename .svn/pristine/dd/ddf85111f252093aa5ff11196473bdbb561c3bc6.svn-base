<?php

/**
 * core/class.statproductprice.php
 *
 * File contains the class used for StatProductprice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_StatProductprice extends Core_Backend_Object
{

	public $pbarcode = "";
	public $id = 0;
    public $value = '';
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_productprice (
					p_barcode,
				    pd_value,
					pd_month,
					pd_year
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->value,
					(int)$this->month,
					(int)$this->year
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'stat_productprice
				SET p_barcode = ?,
					pd_value = ?,
					pd_month = ?,
					pd_year = ?
				WHERE pd_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->pbarcode,
					(string)$this->value,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productprice sp
				WHERE sp.pd_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['pd_id'];
		$this->value = $row['pd_value'];
		$this->month = $row['pd_month'];
		$this->year = $row['pd_year'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stat_productprice
				WHERE pd_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_productprice sp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productprice sp';

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
			$myStatProductprice = new Core_StatProductprice();

			$myStatProductprice->pbarcode = $row['p_barcode'];
			$myStatProductprice->id = $row['pd_id'];
			$myStatProductprice->value = $row['pd_value'];
			$myStatProductprice->month = $row['pd_month'];
			$myStatProductprice->year = $row['pd_year'];


            $outputList[] = $myStatProductprice;
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
	public static function getStatProductprices($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.s_id = '.(int)$formData['fsid'].' ';

		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.a_id = '.(int)$formData['faid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.r_id = '.(int)$formData['frid'].' ';

		if($formData['fpoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.po_id = '.(int)$formData['fpoid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.pd_id = '.(int)$formData['fid'].' ';

		if($formData['fprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.pd_price = '.(float)$formData['fprice'].' ';

		if($formData['fday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.pd_day = '.(int)$formData['fday'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.pd_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.pd_year = '.(int)$formData['fyear'].' ';



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
		elseif($sortby == 'ppaid')
			$orderString = 'ppa_id ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'aid')
			$orderString = 'a_id ' . $sorttype;
		elseif($sortby == 'rid')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'poid')
			$orderString = 'po_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'pd_id ' . $sorttype;
		elseif($sortby == 'price')
			$orderString = 'pd_price ' . $sorttype;
		elseif($sortby == 'day')
			$orderString = 'pd_day ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'pd_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'pd_year ' . $sorttype;
		else
			$orderString = 'pd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getDataByBarcode($barcode = '' , $currentmonth = 0 , $currentyear=0)
    {
        $db3 = self::getDb();
        $row = array();

		$myStatProductPrice = new Core_Backend_StatProductprice();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productprice WHERE p_barcode = ? AND pd_month = ? AND pd_year = ?';

        $row = $db3->query($sql , array($barcode , $currentmonth , $currentyear))->fetch();

		$myStatProductPrice->pbarcode = $row['p_barcode'];
		$myStatProductPrice->id = $row['pd_id'];
		$myStatProductPrice->value = $row['pd_value'];
		$myStatProductPrice->month = $row['pd_month'];
		$myStatProductPrice->year = $row['pd_year'];

        return $myStatProductPrice;
    }


}
