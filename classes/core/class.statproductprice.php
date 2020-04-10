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
Class Core_StatProductprice extends Core_Object
{

	public $pbarcode = "";
    public $id = 0;
    public $value = '';
    public $month = 0;
    public $year = 0;
    public $day_1 = "";
    public $day_2 = "";
    public $day_3 = "";
    public $day_4 = "";
    public $day_5 = "";
    public $day_6 = "";
    public $day_7 = "";
    public $day_8 = "";
    public $day_9 = "";
    public $day_10 = "";
    public $day_11 = "";
    public $day_12 = "";
    public $day_13 = "";
    public $day_14 = "";
    public $day_15 = "";
    public $day_16 = "";
    public $day_17 = "";
    public $day_18 = "";
    public $day_19 = "";
    public $day_20 = "";
    public $day_21 = "";
    public $day_22 = "";
    public $day_23 = "";
    public $day_24 = "";
    public $day_25 = "";
    public $day_26 = "";
    public $day_27 = "";
    public $day_28 = "";
    public $day_29 = "";
    public $day_30 = "";
    public $day_31 = "";
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_productprice (
                    p_barcode,
                    pd_value,
                    pd_month,
                    pd_year,
                    day_1,
                    day_2,
                    day_3,
                    day_4,
                    day_5,
                    day_6,
                    day_7,
                    day_8,
                    day_9,
                    day_10,
                    day_11,
                    day_12,
                    day_13,
                    day_14,
                    day_15,
                    day_16,
                    day_17,
                    day_18,
                    day_19,
                    day_20,
                    day_21,
                    day_22,
                    day_23,
                    day_24,
                    day_25,
                    day_26,
                    day_27,
                    day_28,
                    day_29,
                    day_30,
                    day_31,
                    pd_datecreated,
                    pd_datemodified 
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
                    (string)$this->pbarcode,
                    (string)$this->value,
                    (int)$this->month,
                    (int)$this->year,
                    (string)$this->day_1,
                    (string)$this->day_2,
                    (string)$this->day_3,
                    (string)$this->day_4,
                    (string)$this->day_5,
                    (string)$this->day_6,
                    (string)$this->day_7,
                    (string)$this->day_8,
                    (string)$this->day_9,
                    (string)$this->day_10,
                    (string)$this->day_11,
                    (string)$this->day_12,
                    (string)$this->day_13,
                    (string)$this->day_14,
                    (string)$this->day_15,
                    (string)$this->day_16,
                    (string)$this->day_17,
                    (string)$this->day_18,
                    (string)$this->day_19,
                    (string)$this->day_20,
                    (string)$this->day_21,
                    (string)$this->day_22,
                    (string)$this->day_23,
                    (string)$this->day_24,
                    (string)$this->day_25,
                    (string)$this->day_26,
                    (string)$this->day_27,
                    (string)$this->day_28,
                    (string)$this->day_29,
                    (string)$this->day_30,
                    (string)$this->day_31,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'stat_productprice
                SET p_barcode = ?,
                    pd_value = ?,
                    pd_month = ?,
                    pd_year = ?,
                    day_1 = ?,
                    day_2 = ?,
                    day_3 = ?,
                    day_4 = ?,
                    day_5 = ?,
                    day_6 = ?,
                    day_7 = ?,
                    day_8 = ?,
                    day_9 = ?,
                    day_10 = ?,
                    day_11 = ?,
                    day_12 = ?,
                    day_13 = ?,
                    day_14 = ?,
                    day_15 = ?,
                    day_16 = ?,
                    day_17 = ?,
                    day_18 = ?,
                    day_19 = ?,
                    day_20 = ?,
                    day_21 = ?,
                    day_22 = ?,
                    day_23 = ?,
                    day_24 = ?,
                    day_25 = ?,
                    day_26 = ?,
                    day_27 = ?,
                    day_28 = ?,
                    day_29 = ?,
                    day_30 = ?,
                    day_31 = ?,
                    pd_datecreated = ?,
                    pd_datemodified=? 
                WHERE pd_id = ?';

        $stmt = $this->db3->query($sql, array(
                    (string)$this->pbarcode,
                    (string)$this->value,
                    (int)$this->month,
                    (int)$this->year,
                    (string)$this->day_1,
                    (string)$this->day_2,
                    (string)$this->day_3,
                    (string)$this->day_4,
                    (string)$this->day_5,
                    (string)$this->day_6,
                    (string)$this->day_7,
                    (string)$this->day_8,
                    (string)$this->day_9,
                    (string)$this->day_10,
                    (string)$this->day_11,
                    (string)$this->day_12,
                    (string)$this->day_13,
                    (string)$this->day_14,
                    (string)$this->day_15,
                    (string)$this->day_16,
                    (string)$this->day_17,
                    (string)$this->day_18,
                    (string)$this->day_19,
                    (string)$this->day_20,
                    (string)$this->day_21,
                    (string)$this->day_22,
                    (string)$this->day_23,
                    (string)$this->day_24,
                    (string)$this->day_25,
                    (string)$this->day_26,
                    (string)$this->day_27,
                    (string)$this->day_28,
                    (string)$this->day_29,
                    (string)$this->day_30,
                    (string)$this->day_31,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productprice sp
				WHERE sp.pd_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
        $this->id = $row['pd_id'];
        $this->value = $row['pd_value'];
        $this->month = $row['pd_month'];
        $this->year = $row['pd_year'];
		$this->day_1 = $row['day_1'];
        $this->day_2 = $row['day_2'];
        $this->day_3 = $row['day_3'];
        $this->day_4 = $row['day_4'];
        $this->day_5 = $row['day_5'];
        $this->day_6 = $row['day_6'];
        $this->day_7 = $row['day_7'];
        $this->day_8 = $row['day_8'];
        $this->day_9 = $row['day_9'];
        $this->day_10 = $row['day_10'];
        $this->day_11 = $row['day_11'];
        $this->day_12 = $row['day_12'];
        $this->day_13 = $row['day_13'];
        $this->day_14 = $row['day_14'];
        $this->day_15 = $row['day_15'];
        $this->day_16 = $row['day_16'];
        $this->day_17 = $row['day_17'];
        $this->day_18 = $row['day_18'];
        $this->day_19 = $row['day_19'];
        $this->day_20 = $row['day_20'];
        $this->day_21 = $row['day_21'];
        $this->day_22 = $row['day_22'];
        $this->day_23 = $row['day_23'];
        $this->day_24 = $row['day_24'];
        $this->day_25 = $row['day_25'];
        $this->day_26 = $row['day_26'];
        $this->day_27 = $row['day_27'];
        $this->day_28 = $row['day_28'];
        $this->day_29 = $row['day_29'];
        $this->day_30 = $row['day_30'];
        $this->day_31 = $row['day_31'];
        $this->datecreated = $row['pd_datecreated'];
        $this->datemodified = $row['pd_datemodified'];

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_productprice sp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productprice sp';

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
			$myStatProductprice = new Core_StatProductprice();

            $myStatProductprice->pbarcode = $row['p_barcode'];
            $myStatProductprice->id = $row['pd_id'];
            $myStatProductprice->value = $row['pd_value'];
            $myStatProductprice->month = $row['pd_month'];
            $myStatProductprice->year = $row['pd_year'];

            $myStatProductprice->day_1 = $row['day_1'];
            $myStatProductprice->day_2 = $row['day_2'];
            $myStatProductprice->day_3 = $row['day_3'];
            $myStatProductprice->day_4 = $row['day_4'];
            $myStatProductprice->day_5 = $row['day_5'];
            $myStatProductprice->day_6 = $row['day_6'];
            $myStatProductprice->day_7 = $row['day_7'];
            $myStatProductprice->day_8 = $row['day_8'];
            $myStatProductprice->day_9 = $row['day_9'];
            $myStatProductprice->day_10 = $row['day_10'];
            $myStatProductprice->day_11 = $row['day_11'];
            $myStatProductprice->day_12 = $row['day_12'];
            $myStatProductprice->day_13 = $row['day_13'];
            $myStatProductprice->day_14 = $row['day_14'];
            $myStatProductprice->day_15 = $row['day_15'];
            $myStatProductprice->day_16 = $row['day_16'];
            $myStatProductprice->day_17 = $row['day_17'];
            $myStatProductprice->day_18 = $row['day_18'];
            $myStatProductprice->day_19 = $row['day_19'];
            $myStatProductprice->day_20 = $row['day_20'];
            $myStatProductprice->day_21 = $row['day_21'];
            $myStatProductprice->day_22 = $row['day_22'];
            $myStatProductprice->day_23 = $row['day_23'];
            $myStatProductprice->day_24 = $row['day_24'];
            $myStatProductprice->day_25 = $row['day_25'];
            $myStatProductprice->day_26 = $row['day_26'];
            $myStatProductprice->day_27 = $row['day_27'];
            $myStatProductprice->day_28 = $row['day_28'];
            $myStatProductprice->day_29 = $row['day_29'];
            $myStatProductprice->day_30 = $row['day_30'];
            $myStatProductprice->day_31 = $row['day_31'];
            $myStatProductprice->datecreated = $row['pd_datecreated'];
            $myStatProductprice->datemodified = $row['pd_datemodified'];

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
        $myStatProductPrice->day_1 = $row['day_1'];
        $myStatProductPrice->day_2 = $row['day_2'];
        $myStatProductPrice->day_3 = $row['day_3'];
        $myStatProductPrice->day_4 = $row['day_4'];
        $myStatProductPrice->day_5 = $row['day_5'];
        $myStatProductPrice->day_6 = $row['day_6'];
        $myStatProductPrice->day_7 = $row['day_7'];
        $myStatProductPrice->day_8 = $row['day_8'];
        $myStatProductPrice->day_9 = $row['day_9'];
        $myStatProductPrice->day_10 = $row['day_10'];
        $myStatProductPrice->day_11 = $row['day_11'];
        $myStatProductPrice->day_12 = $row['day_12'];
        $myStatProductPrice->day_13 = $row['day_13'];
        $myStatProductPrice->day_14 = $row['day_14'];
        $myStatProductPrice->day_15 = $row['day_15'];
        $myStatProductPrice->day_16 = $row['day_16'];
        $myStatProductPrice->day_17 = $row['day_17'];
        $myStatProductPrice->day_18 = $row['day_18'];
        $myStatProductPrice->day_19 = $row['day_19'];
        $myStatProductPrice->day_20 = $row['day_20'];
        $myStatProductPrice->day_21 = $row['day_21'];
        $myStatProductPrice->day_22 = $row['day_22'];
        $myStatProductPrice->day_23 = $row['day_23'];
        $myStatProductPrice->day_24 = $row['day_24'];
        $myStatProductPrice->day_25 = $row['day_25'];
        $myStatProductPrice->day_26 = $row['day_26'];
        $myStatProductPrice->day_27 = $row['day_27'];
        $myStatProductPrice->day_28 = $row['day_28'];
        $myStatProductPrice->day_29 = $row['day_29'];
        $myStatProductPrice->day_30 = $row['day_30'];
        $myStatProductPrice->day_31 = $row['day_31'];
        $myStatProductPrice->datecreated = $row['pd_datecreated'];
        $myStatProductPrice->datemodified = $row['pd_datemodified'];

        return $myStatProductPrice;
    }
}