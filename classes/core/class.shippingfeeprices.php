<?php

/**
 * core/class.shippingfeeprices.php
 *
 * File contains the class used for ShippingfeePrices Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ShippingfeePrices Class
 */
Class Core_ShippingfeePrices extends Core_Object
{

    public $id = 0;
    public $distancemin = 0;
    public $distancemax = 0;
    public $weightmin = 0;
    public $weightmax = 0;
    public $timemin = 0;
    public $timemax = 0;
    public $price = 0;
    public $priceplus = 0;
    public $area = '';
    public $typefee = 0;

    const TYPE_TTC = 1;
    const TYPE_SBP = 10;

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

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'shippingfee_prices (
                    sfp_distancemin,
                    sfp_distancemax,
                    sfp_weightmin,
                    sfp_weightmax,
                    sfp_timemin,
                    sfp_timemax,
                    sfp_price,
                    sfp_priceplus,
                    sfp_area,
                    sfp_typefee
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
                    (int)$this->distancemin,
                    (int)$this->distancemax,
                    (int)($this->weightmin * 10),
                    (int)($this->weightmax * 10),
                    (int)$this->timemin,
                    (int)$this->timemax,
                    (int)$this->price,
                    (int)$this->priceplus,
                    (string)$this->area,
                    (int)$this->typefee
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

        $sql = 'UPDATE ' . TABLE_PREFIX . 'shippingfee_prices
                SET sfp_distancemin = ?,
                    sfp_distancemax = ?,
                    sfp_weightmin = ?,
                    sfp_weightmax = ?,
                    sfp_timemin = ?,
                    sfp_timemax = ?,
                    sfp_price = ?,
                    sfp_priceplus = ?,
                    sfp_area = ?,
                    sfp_typefee = ?
                WHERE sfp_id = ?';

        $stmt = $this->db->query($sql, array(
                    (int)$this->distancemin,
                    (int)$this->distancemax,
                    (int)($this->weightmin * 10),
                    (int)($this->weightmax * 10),
                    (int)$this->timemin,
                    (int)$this->timemax,
                    (int)$this->price,
                    (int)$this->priceplus,
                    (string)$this->area,
                    (int)$this->typefee,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_prices sp
                WHERE sp.sfp_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();

        $this->id = (int)$row['sfp_id'];
        $this->distancemin = (int)$row['sfp_distancemin'];
        $this->distancemax = (int)$row['sfp_distancemax'];
        $this->weightmin = (float)($row['sfp_weightmin']/10);
        $this->weightmax = (float)($row['sfp_weightmax']/10);
        $this->timemin = (int)$row['sfp_timemin'];
        $this->timemax = (int)$row['sfp_timemax'];
        $this->price = (int)$row['sfp_price'];
        $this->priceplus = (int)$row['sfp_priceplus'];
        $this->area = (string)$row['sfp_area'];
        $this->typefee = (int)$row['sfp_typefee'];

    }

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'shippingfee_prices
                WHERE sfp_id = ?';
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
        $db = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'shippingfee_prices sp';

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
        $db = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_prices sp';

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
            $myShippingfeePrices = new Core_ShippingfeePrices();

            $myShippingfeePrices->id = (int)$row['sfp_id'];
            $myShippingfeePrices->distancemin = (int)$row['sfp_distancemin'];
            $myShippingfeePrices->distancemax = (int)$row['sfp_distancemax'];
            $myShippingfeePrices->weightmin = (float)($row['sfp_weightmin']/10);
            $myShippingfeePrices->weightmax = (float)($row['sfp_weightmax']/10);
            $myShippingfeePrices->timemin = (int)$row['sfp_timemin'];
            $myShippingfeePrices->timemax = (int)$row['sfp_timemax'];
            $myShippingfeePrices->price = (int)$row['sfp_price'];
            $myShippingfeePrices->priceplus = (int)$row['sfp_priceplus'];
            $myShippingfeePrices->area = (string)$row['sfp_area'];
            $myShippingfeePrices->typefee = (int)$row['sfp_typefee'];


            $outputList[] = $myShippingfeePrices;
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
    public static function getShippingfeePricess($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';

        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_id = '.(int)$formData['fid'].' ';

        if(isset($formData['fdistancemin']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_distancemin = '.(int)$formData['fdistancemin'].' ';

        if($formData['farea'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_area = "'.(string)Helper::unspecialtext($formData['farea']).'" ';

        if(isset($formData['fdistancemax']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_distancemax = '.(int)$formData['fdistancemax'].' ';

        if(isset($formData['fweightmin']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_weightmin = '.(int)$formData['fweightmin'].' ';

        if($formData['fweightmax'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_weightmax = '.(int)$formData['fweightmax'].' ';

        if($formData['ftypefee'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sfp_typefee = '.(int)$formData['ftypefee'].' ';

        if($formData['fcompareweight'] > 0) {
            if ($formData['fcompareweight'] > 100) {
                $whereString .= ($whereString != '' ? ' AND ' : '') . '((sp.sfp_weightmin <= 100 AND sp.sfp_weightmax = 0) OR (sp.sfp_weightmax >= 100))';
            } else {
                $whereString .= ($whereString != '' ? ' AND ' : '') . '(sp.sfp_weightmin <= '.(int)$formData['fcompareweight'].' OR sp.sfp_weightmin = 0) ';
                $whereString .= ' AND (sp.sfp_weightmax > '.(int)$formData['fcompareweight'].' OR sp.sfp_weightmax = 0) ';
            }
        }

        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'id')
            $orderString = 'sfp_id ' . $sorttype;
        else
            $orderString = 'sfp_id ' . $sorttype;

        if($countOnly)
            return self::countList($whereString);
        else
            return self::getList($whereString, $orderString, $limit);
    }


    public function getTypePrice()
    {
        if ($this->typefee == Core_ShippingfeePrices::TYPE_TTC) {
            return 'TTC';
        } else {
            return 'SBP';
        }
    }



}