<?php

/**
 * core/class.promotionproduct.php
 *
 * File contains the class used for PromotionProduct Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PromotionProduct extends Core_Object
{

	public $pid = 0;
    public $aid = 0;
	public $pbarcode = "";
	public $promoid = 0;
	public $id = 0;


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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion_product (
					p_id,
					p_barcode,
					promo_id,
                    a_id
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->promoid,
                    (int)$this->aid
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotion_product
				SET p_id = ?,
					p_barcode = ?,
					promo_id = ?,
                    a_id = ?
				WHERE promop_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(string)$this->pbarcode,
					(int)$this->promoid,
                    (int)$this->aid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_product pp
				WHERE pp.promop_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->promoid = $row['promo_id'];
		$this->id = $row['promop_id'];
		$this->aid = $row['a_id'];
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion_product
				WHERE promop_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion_product pp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_product pp';

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
			$myPromotionProduct = new Core_PromotionProduct();

			$myPromotionProduct->pid = $row['p_id'];
			$myPromotionProduct->pbarcode = $row['p_barcode'];
			$myPromotionProduct->promoid = $row['promo_id'];
			$myPromotionProduct->id = $row['promop_id'];
            $myPromotionProduct->aid = $row['a_id'];


            $outputList[] = $myPromotionProduct;
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
	public static function getPromotionProducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';
        if($formData['fpbarcodearr'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.p_barcode IN ("'.implode('","',$formData['fpbarcodearr']).'") ';

		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.promo_id = '.(int)$formData['fpromoid'].' ';

        if($formData['faid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.a_id = '.(int)$formData['faid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pp.promop_id = '.(int)$formData['fid'].' ';


		if(count($formData['fpromoidarr']) > 0 && $formData['fpromoid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpromoidarr']) ; $i++)
            {
                if($i == count($formData['fpromoidarr']) - 1)
                {
                    $whereString .= 'pp.promo_id = ' . (int)$formData['fpromoidarr'][$i];
                }
                else
                {
                    $whereString .= 'pp.promo_id = ' . (int)$formData['fpromoidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['faidarr']) > 0 && $formData['faid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['faidarr']) ; $i++)
            {
                if($i == count($formData['faidarr']) - 1)
                {
                    $whereString .= 'pp.a_id = ' . (int)$formData['faidarr'][$i];
                }
                else
                {
                    $whereString .= 'pp.a_id = ' . (int)$formData['faidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'promop_id ' . $sorttype;
		else
			$orderString = 'promop_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getListPromotionProductGroupBy($fpromoid)
    {
        global $db;

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_product pp';

        $sql .= ' WHERE pp.promo_id = "'.(int)$fpromoid.'"';

        $sql .= ' GROUP BY pp.p_barcode';
        //echo $sql;
        $outputList = array();
        $stmt = $db->query($sql);
        while($row = $stmt->fetch())
        {
            $myPromotionProduct = new Core_PromotionProduct();

            $myPromotionProduct->pid = $row['p_id'];
            $myPromotionProduct->pbarcode = $row['p_barcode'];
            $myPromotionProduct->promoid = $row['promo_id'];
            $myPromotionProduct->id = $row['promop_id'];
            $myPromotionProduct->aid = $row['a_id'];


            $outputList[] = $myPromotionProduct;
        }

        return $outputList;
    }

}