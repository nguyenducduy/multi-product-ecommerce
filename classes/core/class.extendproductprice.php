<?php

/**
 * core/class.extendproductprice.php
 *
 * File contains the class used for ExtendproductPrice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ExtendproductPrice extends Core_Object
{

	public $epid = 0;
	public $id = 0;
	public $eepcostprice = 0;
	public $eepsalelprice = 0;
	public $epdiscount = 0;
	public $eepdatemodified = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'extendproduct_price (
					ep_id,
					eep_costprice,
					eep_salelprice,
					ep_discount,
					eep_datemodified
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->epid,
					(float)$this->eepcostprice,
					(float)$this->eepsalelprice,
					(float)$this->epdiscount,
					(int)$this->eepdatemodified
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'extendproduct_price
				SET ep_id = ?,
					eep_costprice = ?,
					eep_salelprice = ?,
					ep_discount = ?,
					eep_datemodified = ?
				WHERE epp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->epid,
					(float)$this->eepcostprice,
					(float)$this->eepsalelprice,
					(float)$this->epdiscount,
					(int)$this->eepdatemodified,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct_price ep
				WHERE ep.epp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->epid = $row['ep_id'];
		$this->id = $row['epp_id'];
		$this->eepcostprice = $row['eep_costprice'];
		$this->eepsalelprice = $row['eep_salelprice'];
		$this->epdiscount = $row['ep_discount'];
		$this->eepdatemodified = $row['eep_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'extendproduct_price
				WHERE epp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'extendproduct_price ep';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct_price ep';

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
			$myExtendproductPrice = new Core_ExtendproductPrice();

			$myExtendproductPrice->epid = $row['ep_id'];
			$myExtendproductPrice->id = $row['epp_id'];
			$myExtendproductPrice->eepcostprice = $row['eep_costprice'];
			$myExtendproductPrice->eepsalelprice = $row['eep_salelprice'];
			$myExtendproductPrice->epdiscount = $row['ep_discount'];
			$myExtendproductPrice->eepdatemodified = $row['eep_datemodified'];


            $outputList[] = $myExtendproductPrice;
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
	public static function getExtendproductPrices($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fepid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_id = '.(int)$formData['fepid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.epp_id = '.(int)$formData['fid'].' ';

		if($formData['feepcostprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.eep_costprice = '.(float)$formData['feepcostprice'].' ';

		if($formData['feepsalelprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.eep_salelprice = '.(float)$formData['feepsalelprice'].' ';

		if($formData['fepdiscount'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_discount = '.(float)$formData['fepdiscount'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'epid')
			$orderString = 'ep_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'epp_id ' . $sorttype;
		elseif($sortby == 'eepcostprice')
			$orderString = 'eep_costprice ' . $sorttype;
		elseif($sortby == 'eepsalelprice')
			$orderString = 'eep_salelprice ' . $sorttype;
		elseif($sortby == 'epdiscount')
			$orderString = 'ep_discount ' . $sorttype;
		else
			$orderString = 'epp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getExtendproductPriceByEpId($epid = 0)
	{
		if($epid > 0)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'extendproduct_price
					WHERE ep_id = ?';
			$row = $this->db->query($sql, array($epid))->fetch();

			$this->epid = $row['ep_id'];
			$this->id = $row['epp_id'];
			$this->eepcostprice = $row['eep_costprice'];
			$this->eepsalelprice = $row['eep_salelprice'];
			$this->epdiscount = $row['ep_discount'];
			$this->eepdatemodified = $row['eep_datemodified'];
		}
	}

}