<?php

/**
 * core/class.promotioncombo.php
 *
 * File contains the class used for PromotionCombo Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PromotionCombo extends Core_Object
{

	public $promoid = 0;
	public $coid = "";
	public $id = 0;

    public $comboObject = null;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion_combo (

					promo_id,
					co_id
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promoid,
					(string)$this->coid

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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotion_combo
				SET
					promo_id = ?,
					co_id = ?
				WHERE promoc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->promoid,
					(string)$this->coid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_combo pc
				WHERE pc.promoc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		//$this->pbarcode = $row['p_barcode'];
		$this->promoid = $row['promo_id'];
		$this->coid = $row['co_id'];
		$this->id = $row['promoc_id'];
		/*$this->type = $row['promoc_type'];
		$this->quantity = $row['promoc_quantity'];
		$this->value = $row['promoc_value'];
		$this->displayorder = $row['promoc_displayorder'];*/
		$this->comboObject  = new Core_Combo($this->coid);
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion_combo
				WHERE promoc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion_combo pc';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_combo pc';

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
			$myPromotionCombo = new Core_PromotionCombo();

			//$myPromotionCombo->pbarcode = $row['p_barcode'];
			$myPromotionCombo->promoid = $row['promo_id'];
			$myPromotionCombo->coid = $row['co_id'];
			$myPromotionCombo->id = $row['promoc_id'];
			/*$myPromotionCombo->type = $row['promoc_type'];
			$myPromotionCombo->quantity = $row['promoc_quantity'];
			$myPromotionCombo->value = $row['promoc_value'];
			$myPromotionCombo->displayorder = $row['promoc_displayorder']; */
			$myPromotionCombo->comboObject  = new Core_Combo($row['co_id']);

            $outputList[] = $myPromotionCombo;
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
	public static function getPromotionCombos($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pc.promo_id = '.(int)$formData['fpromoid'].' ';

		if($formData['fcoid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pc.co_id = "'.Helper::unspecialtext((string)$formData['fcoid']).'" ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pc.promoc_id = '.(int)$formData['fid'].' ';


		if(count($formData['fpromoidarr']) > 0 && $formData['fpromoid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fpromoidarr']) ; $i++)
            {
                if($i == count($formData['fpromoidarr']) - 1)
                {
                    $whereString .= 'pc.promo_id = ' . (int)$formData['fpromoidarr'][$i];
                }
                else
                {
                    $whereString .= 'pc.promo_id = ' . (int)$formData['fpromoidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['fcoidarr']) > 0 && $formData['fcoid'] == '')
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fcoidarr']) ; $i++)
            {
                if($i == count($formData['fcoidarr']) - 1)
                {
                    $whereString .= 'pc.co_id = "' . (string)$formData['fcoidarr'][$i].'"';
                }
                else
                {
                    $whereString .= 'pc.co_id = "' . (string)$formData['fcoidarr'][$i] . '" OR ';
                }
            }
            $whereString .= ')';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'promoc_id ' . $sorttype;
		else
			$orderString = 'promoc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}