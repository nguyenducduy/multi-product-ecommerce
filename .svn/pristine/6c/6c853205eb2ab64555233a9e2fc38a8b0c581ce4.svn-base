<?php

/**
 * core/class.discountproduct.php
 *
 * File contains the class used for DiscountProduct Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_DiscountProduct extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 0;
	public $id = 0;
	public $listproduct = "";
	public $discountname = "";
	public $type = 0;
	public $amount = 0;
	public $displayorder = 0;
	public $discountcombo = "";
	public $datecreated = 0;
	public $datemodified = 0;
	public $status = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'discount_product (
					dp_listproduct,
					dp_discountname,
					dp_type,
					dp_amount,
					dp_displayorder,
					dp_discountcombo,
					dp_datecreated,
					dp_datemodified,
					dp_status
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->listproduct,
					(string)$this->discountname,
					(int)$this->type,
					(int)$this->amount,
					(int)$this->displayorder,
					(string)$this->discountcombo,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->status
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'discount_product
				SET dp_listproduct = ?,
					dp_discountname = ?,
					dp_type = ?,
					dp_amount = ?,
					dp_displayorder = ?,
					dp_discountcombo = ?,
					dp_datecreated = ?,
					dp_datemodified = ?,
					dp_status = ?
				WHERE dp_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->listproduct,
					(string)$this->discountname,
					(int)$this->type,
					(int)$this->amount,
					(int)$this->displayorder,
					(string)$this->discountcombo,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'discount_product dp
				WHERE dp.dp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['dp_id'];
		$this->listproduct = $row['dp_listproduct'];
		$this->discountname = $row['dp_discountname'];
		$this->type = $row['dp_type'];
		$this->amount = $row['dp_amount'];
		$this->displayorder = $row['dp_displayorder'];
		$this->discountcombo = $row['dp_discountcombo'];
		$this->datecreated = $row['dp_datecreated'];
		$this->datemodified = $row['dp_datemodified'];
		$this->status = $row['dp_status'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'discount_product
				WHERE dp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'discount_product dp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'discount_product dp';

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
			$myDiscountProduct = new Core_DiscountProduct();

			$myDiscountProduct->id = $row['dp_id'];
			$myDiscountProduct->listproduct = $row['dp_listproduct'];
			$myDiscountProduct->discountname = $row['dp_discountname'];
			$myDiscountProduct->type = $row['dp_type'];
			$myDiscountProduct->amount = $row['dp_amount'];
			$myDiscountProduct->displayorder = $row['dp_displayorder'];
			$myDiscountProduct->discountcombo = $row['dp_discountcombo'];
			$myDiscountProduct->datecreated = $row['dp_datecreated'];
			$myDiscountProduct->datemodified = $row['dp_datemodified'];
			$myDiscountProduct->status = $row['dp_status'];


            $outputList[] = $myDiscountProduct;
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
	public static function getDiscountProducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_id = '.(int)$formData['fid'].' ';

		if($formData['fdiscountname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_discountname = "'.Helper::unspecialtext((string)$formData['fdiscountname']).'" ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_type = '.(int)$formData['ftype'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_status = '.(int)$formData['fstatus'].' ';

		if($formData['fnottype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'dp.dp_type != '.(int)$formData['fnottype'].' ';



		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'dp_id ' . $sorttype;
		elseif($sortby == 'discountname')
			$orderString = 'dp_discountname ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'dp_type ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'dp_displayorder ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'dp_status ' . $sorttype;
		else
			$orderString = 'dp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}