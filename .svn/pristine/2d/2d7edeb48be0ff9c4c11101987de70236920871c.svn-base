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
Class Core_Backend_StatProductstock extends Core_Backend_Object
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

        $this->datecreated = time();
        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'stat_productstock (
                    p_barcode,
                    sd_value,
                    sd_month,
                    sd_year,
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
                    sd_datecreated,
                    sd_datemodified
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
        $this->datemodified = time();

        $sql = 'UPDATE ' . TABLE_PREFIX . 'stat_productstock
                SET p_barcode = ?,
                    sd_value = ?,
                    sd_month = ?,
                    sd_year = ?,
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
                    sd_datecreated = ?,
                    sd_datemodified = ?
                WHERE sd_id = ?';

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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productstock sp
                WHERE sp.sd_id = ?';
        $row = $this->db3->query($sql, array($id))->fetch();

        $this->pbarcode = $row['p_barcode'];
        $this->id = $row['sd_id'];
        $this->value = $row['sd_value'];
        $this->month = $row['sd_month'];
        $this->year = $row['sd_year'];
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
        $this->datecreated = $row['sd_datecreated'];
        $this->datemodified = $row['sd_datemodified'];

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
        global $db;

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stat_productstock sp';

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
        global $db;

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productstock sp';

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
            $myStatProductstock = new Core_StatProductstock();

            $myStatProductstock->pbarcode = $row['p_barcode'];
            $myStatProductstock->id = $row['sd_id'];
            $myStatProductstock->value = $row['sd_value'];
            $myStatProductstock->month = $row['sd_month'];
            $myStatProductstock->year = $row['sd_year'];
            $myStatProductstock->day_1 = $row['day_1'];
            $myStatProductstock->day_2 = $row['day_2'];
            $myStatProductstock->day_3 = $row['day_3'];
            $myStatProductstock->day_4 = $row['day_4'];
            $myStatProductstock->day_5 = $row['day_5'];
            $myStatProductstock->day_6 = $row['day_6'];
            $myStatProductstock->day_7 = $row['day_7'];
            $myStatProductstock->day_8 = $row['day_8'];
            $myStatProductstock->day_9 = $row['day_9'];
            $myStatProductstock->day_10 = $row['day_10'];
            $myStatProductstock->day_11 = $row['day_11'];
            $myStatProductstock->day_12 = $row['day_12'];
            $myStatProductstock->day_13 = $row['day_13'];
            $myStatProductstock->day_14 = $row['day_14'];
            $myStatProductstock->day_15 = $row['day_15'];
            $myStatProductstock->day_16 = $row['day_16'];
            $myStatProductstock->day_17 = $row['day_17'];
            $myStatProductstock->day_18 = $row['day_18'];
            $myStatProductstock->day_19 = $row['day_19'];
            $myStatProductstock->day_20 = $row['day_20'];
            $myStatProductstock->day_21 = $row['day_21'];
            $myStatProductstock->day_22 = $row['day_22'];
            $myStatProductstock->day_23 = $row['day_23'];
            $myStatProductstock->day_24 = $row['day_24'];
            $myStatProductstock->day_25 = $row['day_25'];
            $myStatProductstock->day_26 = $row['day_26'];
            $myStatProductstock->day_27 = $row['day_27'];
            $myStatProductstock->day_28 = $row['day_28'];
            $myStatProductstock->day_29 = $row['day_29'];
            $myStatProductstock->day_30 = $row['day_30'];
            $myStatProductstock->day_31 = $row['day_31'];
            $myStatProductstock->datecreated = $row['sd_datecreated'];
            $myStatProductstock->datemodified = $row['sd_datemodified'];


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

    public static function getDataByBarcode($barcode = '' , $currentmonth = 0 , $currentyear = 0)
    {
        $db3 = self::getDb();

        $row = array();

        $myStatProductStock = new Core_Backend_StatProductstock();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stat_productstock WHERE p_barcode = ? AND sd_month = ? AND sd_year = ?';
        $row = $db3->query($sql , array($barcode , $currentmonth , $currentyear))->fetch();
        
        if(!empty($row)) {
            $myStatProductStock->pbarcode = $row['p_barcode'];
            $myStatProductStock->id = $row['sd_id'];
            $myStatProductStock->value = $row['sd_value'];
            $myStatProductStock->month = $row['sd_month'];
            $myStatProductStock->year = $row['sd_year'];
            $myStatProductStock->day_1 = $row['day_1'];
            $myStatProductStock->day_2 = $row['day_2'];
            $myStatProductStock->day_3 = $row['day_3'];
            $myStatProductStock->day_4 = $row['day_4'];
            $myStatProductStock->day_5 = $row['day_5'];
            $myStatProductStock->day_6 = $row['day_6'];
            $myStatProductStock->day_7 = $row['day_7'];
            $myStatProductStock->day_8 = $row['day_8'];
            $myStatProductStock->day_9 = $row['day_9'];
            $myStatProductStock->day_10 = $row['day_10'];
            $myStatProductStock->day_11 = $row['day_11'];
            $myStatProductStock->day_12 = $row['day_12'];
            $myStatProductStock->day_13 = $row['day_13'];
            $myStatProductStock->day_14 = $row['day_14'];
            $myStatProductStock->day_15 = $row['day_15'];
            $myStatProductStock->day_16 = $row['day_16'];
            $myStatProductStock->day_17 = $row['day_17'];
            $myStatProductStock->day_18 = $row['day_18'];
            $myStatProductStock->day_19 = $row['day_19'];
            $myStatProductStock->day_20 = $row['day_20'];
            $myStatProductStock->day_21 = $row['day_21'];
            $myStatProductStock->day_22 = $row['day_22'];
            $myStatProductStock->day_23 = $row['day_23'];
            $myStatProductStock->day_24 = $row['day_24'];
            $myStatProductStock->day_25 = $row['day_25'];
            $myStatProductStock->day_26 = $row['day_26'];
            $myStatProductStock->day_27 = $row['day_27'];
            $myStatProductStock->day_28 = $row['day_28'];
            $myStatProductStock->day_29 = $row['day_29'];
            $myStatProductStock->day_30 = $row['day_30'];
            $myStatProductStock->day_31 = $row['day_31'];
            $myStatProductStock->datecreated = $row['sd_datecreated'];
            $myStatProductStock->datemodified = $row['sd_datemodified'];
        }

        return $myStatProductStock;
    }
}
