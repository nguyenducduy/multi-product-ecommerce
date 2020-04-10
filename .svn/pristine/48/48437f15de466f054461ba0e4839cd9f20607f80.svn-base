<?php

/**
 * core/class.promotionoutputtype.php
 *
 * File contains the class used for PromotionOutputtype Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PromotionOutputtype extends Core_Object
{

	public $promoid = 0;
	public $poid = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion_outputtype (
					promo_id,
					po_id
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->poid
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotion_outputtype
				SET promo_id = ?,
					po_id = ?
				WHERE promoo_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->poid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_outputtype po
				WHERE po.promoo_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->promoid = $row['promo_id'];
		$this->poid = $row['po_id'];
		$this->id = $row['promoo_id'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion_outputtype
				WHERE promoo_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion_outputtype po';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_outputtype po';

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
			$myPromotionOutputtype = new Core_PromotionOutputtype();

			$myPromotionOutputtype->promoid = $row['promo_id'];
			$myPromotionOutputtype->poid = $row['po_id'];
			$myPromotionOutputtype->id = $row['promoo_id'];


            $outputList[] = $myPromotionOutputtype;
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
	public static function getPromotionOutputtypes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fpromoid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.promo_id = '.(int)$formData['fpromoid'].' ';

        if($formData['fpoid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.po_id = '.(int)$formData['fpoid'].' ';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'po.promoo_id = '.(int)$formData['fid'].' ';

		if(is_array($formData['fpromoidarr']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'po.promo_id IN ('.implode(',',$formData['fpromoidarr']).') ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'promoo_id ' . $sorttype;
		else
			$orderString = 'promoo_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}