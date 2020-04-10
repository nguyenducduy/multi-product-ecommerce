<?php

/**
 * core/class.promotionlist.php
 *
 * File contains the class used for Promotionlist Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Promotionlist extends Core_Object
{

	public $promogid = 0;
    public $pbarcode = "";
	public $id = 0;
	public $iscombo = 0;
	public $price = 0;
	public $imei = "";
	public $imeipromotionid = "";
	public $quantity = 0;
	public $ispercentcalc = 0;
	public $dateadd = 0;
	public $datemodify = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotionlist (
					promog_id,
                    p_barcode,
					promol_iscombo,
					promol_price,
					promol_imei,
					promol_imeipromotionid,
					promol_quantity,
					promol_ispercentcalc,
					promol_dateadd,
					promol_datemodify
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promogid,
                    (string)$this->pbarcode,
					(int)$this->iscombo,
					(float)$this->price,
					(string)$this->imei,
					(string)$this->imeipromotionid,
					(int)$this->quantity,
					(int)$this->ispercentcalc,
					(int)$this->dateadd,
					(int)$this->datemodify
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotionlist
				SET promog_id = ?,
                    promol_iscombo = ?,
					p_barcode = ?,
					promol_price = ?,
					promol_imei = ?,
					promol_imeipromotionid = ?,
					promol_quantity = ?,
					promol_ispercentcalc = ?,
					promol_dateadd = ?,
					promol_datemodify = ?
				WHERE promol_id = ?';

		$stmt = $this->db->query($sql, array(
                    (int)$this->promogid,
					(int)$this->pbarcode,
					(int)$this->iscombo,
					(float)$this->price,
					(string)$this->imei,
					(string)$this->imeipromotionid,
					(int)$this->quantity,
					(int)$this->ispercentcalc,
					(int)$this->dateadd,
					(int)$this->datemodify,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotionlist p
				WHERE p.promol_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

        $this->promogid = $row['promog_id'];
		$this->pbarcode = $row['p_barcode'];
		$this->id = $row['promol_id'];
		$this->iscombo = $row['promol_iscombo'];
		$this->price = $row['promol_price'];
		$this->imei = $row['promol_imei'];
		$this->imeipromotionid = $row['promol_imeipromotionid'];
		$this->quantity = $row['promol_quantity'];
		$this->ispercentcalc = $row['promol_ispercentcalc'];
		$this->dateadd = $row['promol_dateadd'];
		$this->datemodify = $row['promol_datemodify'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotionlist
				WHERE promol_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotionlist p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotionlist p';

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
			$myPromotionlist = new Core_Promotionlist();

            $myPromotionlist->promogid = $row['promog_id'];
			$myPromotionlist->pbarcode = $row['p_barcode'];
			$myPromotionlist->id = $row['promol_id'];
			$myPromotionlist->iscombo = $row['promol_iscombo'];
			$myPromotionlist->price = $row['promol_price'];
			$myPromotionlist->imei = $row['promol_imei'];
			$myPromotionlist->imeipromotionid = $row['promol_imeipromotionid'];
			$myPromotionlist->quantity = $row['promol_quantity'];
			$myPromotionlist->ispercentcalc = $row['promol_ispercentcalc'];
			$myPromotionlist->dateadd = $row['promol_dateadd'];
			$myPromotionlist->datemodify = $row['promol_datemodify'];

            $outputList[] = $myPromotionlist;
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
	public static function getPromotionlists($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpromogid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promog_id = '.(int)$formData['fpromogid'].' ';

        if($formData['fpbarcode'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promol_id = '.(int)$formData['fid'].' ';


		if(count($formData['fpromogidarr']) > 0 && $formData['fpromogid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpromogidarr']) ; $i++)
            {
                if($i == count($formData['fpromogidarr']) - 1)
                {
                    $whereString .= 'p.promog_id = ' . (int)$formData['fpromogidarr'][$i];
                }
                else
                {
                    $whereString .= 'p.promog_id = ' . (int)$formData['fpromogidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['fpbarcodearr']) > 0 && $formData['fpbarcode'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpbarcodearr']) ; $i++)
            {
                if($i == count($formData['fpbarcodearr']) - 1)
                {
                    $whereString .= 'p.p_barcode = ' . (int)$formData['fpbarcodearr'][$i];
                }
                else
                {
                    $whereString .= 'p.p_barcode = ' . (int)$formData['fpbarcodearr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'promol_id ' . $sorttype;
		else
			$orderString = 'promol_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}