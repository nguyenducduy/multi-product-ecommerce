<?php

/**
 * core/class.promotionexclude.php
 *
 * File contains the class used for PromotionExclude Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PromotionExclude extends Core_Object
{

	public $promoid = 0;
	public $promoeid = 0;
    public $promooldid = 0;
    public $promoeoldid = 0;

    public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion_exclude (
					promo_id,
					promoe_id
					)
		        VALUES(?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->promoeid
					))->rowCount();

		return $rowCount;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'promotion_exclude
				SET promo_id = ?,
					promoe_id = ?
				WHERE promo_id = ? AND promoe_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->promoid,
					(int)$this->promoeid,
                    (int)$this->promooldid,
                    (int)$this->promoeoldid,
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
		$id= (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_exclude pe
				WHERE pe. = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->promoid = $row['promo_id'];
		$this->promoeid = $row['promoe_id'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	/*public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion_exclude
				WHERE  = ?';
		$rowCount = $this->db->query($sql, array($this->p))->rowCount();

		return $rowCount;
	}*/

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion_exclude pe';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion_exclude pe';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;
		//echo $sql;
		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myPromotionExclude = new Core_PromotionExclude();

			$myPromotionExclude->promoid = $row['promo_id'];
			$myPromotionExclude->promoeid = $row['promoe_id'];


            $outputList[] = $myPromotionExclude;
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
	public static function getPromotionExcludes($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpromoid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.promo_id = '.(int)$formData['fpromoid'].' ';

		if($formData['fpromoeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.promoe_id = '.(int)$formData['fpromoeid'].' ';




		//checking sort by & sort type
		//if($sorttype != 'DESC' && $sorttype != 'ASC')
//			$sorttype = 'DESC';


		$orderString = '' ;//. $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}