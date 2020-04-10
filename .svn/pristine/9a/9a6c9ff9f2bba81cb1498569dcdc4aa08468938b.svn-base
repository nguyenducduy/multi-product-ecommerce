<?php

/**
 * core/class.shippingfeenamefee.php
 *
 * File contains the class used for ShippingfeeNamefee Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ShippingfeeNamefee Class
 */
Class Core_ShippingfeeNamefee extends Core_Object
{

	public $id = 0;
	public $name = '';
	public $pricemin = 0;
	public $pricemax = 0;
	public $weightmin = 0;
	public $weightmax = 0;
	public $discount = 0;
	public $ispercent = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'shippingfee_namefee (
					sfn_name,
					sfn_pricemin,
					sfn_pricemax,
					sfn_weightmin,
					sfn_weightmax,
					sfn_discount,
					sfn_ispercent
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->pricemin,
					(int)$this->pricemax,
					(int)$this->weightmin,
					(int)$this->weightmax,
					(int)$this->discount,
					(int)$this->ispercent
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'shippingfee_namefee
				SET sfn_name = ?,
					sfn_pricemin = ?,
					sfn_pricemax = ?,
					sfn_weightmin = ?,
					sfn_weightmax = ?,
					sfn_discount = ?,
					sfn_ispercent = ?
				WHERE sfn_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->pricemin,
					(int)$this->pricemax,
					(int)$this->weightmin,
					(int)$this->weightmax,
					(int)$this->discount,
					(int)$this->ispercent,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_namefee sn
				WHERE sn.sfn_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = (int)$row['sfn_id'];
		$this->name = (string)$row['sfn_name'];
		$this->pricemin = (int)$row['sfn_pricemin'];
		$this->pricemax = (int)$row['sfn_pricemax'];
		$this->weightmin = (int)$row['sfn_weightmin'];
		$this->weightmax = (int)$row['sfn_weightmax'];
		$this->discount = (int)$row['sfn_discount'];
		$this->ispercent = (int)$row['sfn_ispercent'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'shippingfee_namefee
				WHERE sfn_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'shippingfee_namefee sn';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_namefee sn';

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
			$myShippingfeeNamefee = new Core_ShippingfeeNamefee();

			$myShippingfeeNamefee->id = (int)$row['sfn_id'];
			$myShippingfeeNamefee->name = (string)$row['sfn_name'];
			$myShippingfeeNamefee->pricemin = (int)$row['sfn_pricemin'];
			$myShippingfeeNamefee->pricemax = (int)$row['sfn_pricemax'];
			$myShippingfeeNamefee->weightmin = (int)$row['sfn_weightmin'];
			$myShippingfeeNamefee->weightmax = (int)$row['sfn_weightmax'];
			$myShippingfeeNamefee->discount = (int)$row['sfn_discount'];
			$myShippingfeeNamefee->ispercent = (int)$row['sfn_ispercent'];


            $outputList[] = $myShippingfeeNamefee;
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
	public static function getShippingfeeNamefees($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fpricemin'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_pricemin = '.(int)$formData['fpricemin'].' ';

		if($formData['fpricemax'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_pricemax = '.(int)$formData['fpricemax'].' ';

		if($formData['fweightmin'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_weightmin = '.(int)$formData['fweightmin'].' ';

		if($formData['fweightmax'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sn.sfn_weightmax = '.(int)$formData['fweightmax'].' ';

		if ($formData['ftotalprice'] > 0 && $formData['ftotalweight'] > 0) {
			$whereString .= ($whereString != '' ? ' AND ' : '');
			$whereString .= ' (sn.sfn_pricemin <= '.(float)$formData['ftotalprice'].' AND sn.sfn_pricemax = 0)';
			$whereString .= ' AND ((sn.sfn_weightmin <= '.(float)$formData['ftotalweight'].' AND sn.sfn_weightmax = 0) OR (sn.sfn_weightmin = 0 AND sn.sfn_weightmax > '.(float)$formData['ftotalweight'].'))';
		}


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sfn_id ' . $sorttype;
		else
			$orderString = 'sfn_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}







}