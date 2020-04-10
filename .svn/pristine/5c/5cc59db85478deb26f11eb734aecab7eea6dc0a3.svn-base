<?php

/**
 * core/class.ordersdetail.php
 *
 * File contains the class used for OrdersDetail Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_OrdersDetail extends Core_Object
{

	public $oid = 0;
	public $pid = 0;
	public $id = 0;
	public $pricesell = 0;
	public $pricediscount = 0;
	public $pricefinal = 0;
	public $quantity = 0;
	public $options = array();

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'orders_detail (
					o_id,
					p_id,
					od_price_sell,
					od_price_discount,
					od_price_final,
					od_quantity,
					od_options
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->oid,
					(int)$this->pid,
					(float)$this->pricesell,
					(float)$this->pricediscount,
					(float)$this->pricefinal,
					(int)$this->quantity,
					(string)serialize($this->options)
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'orders_detail
				SET o_id = ?,
					p_id = ?,
					od_price_sell = ?,
					od_price_discount = ?,
					od_price_final = ?,
					od_quantity = ?,
					od_options = ?
				WHERE od_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->oid,
					(int)$this->pid,
					(float)$this->pricesell,
					(float)$this->pricediscount,
					(float)$this->pricefinal,
					(int)$this->quantity,
					(string)serialize($this->options),
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'orders_detail od
				WHERE od.od_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->oid = $row['o_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['od_id'];
		$this->pricesell = $row['od_price_sell'];
		$this->pricediscount = $row['od_price_discount'];
		$this->pricefinal = $row['od_price_final'];
        $this->quantity = $row['od_quantity'];
		$this->options = unserialize($row['od_options']);

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'orders_detail
				WHERE od_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'orders_detail od';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'orders_detail od';

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
			$myOrdersDetail = new Core_OrdersDetail();

			$myOrdersDetail->oid = $row['o_id'];
			$myOrdersDetail->pid = $row['p_id'];
			$myOrdersDetail->id = $row['od_id'];
			$myOrdersDetail->pricesell = $row['od_price_sell'];
			$myOrdersDetail->pricediscount = $row['od_price_discount'];
			$myOrdersDetail->pricefinal = $row['od_price_final'];
			$myOrdersDetail->quantity = $row['od_quantity'];
			$myOrdersDetail->options = unserialize($row['od_options']);


            $outputList[] = $myOrdersDetail;
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
	public static function getOrdersDetails($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['foid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.o_id = '.(int)$formData['foid'].' ';

		if(is_array($formData['foidarr']) && count($formData['foidarr']) > 0 )
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.o_id IN ('.implode(',',$formData['foidarr']).') ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.p_id = '.(int)$formData['fpid'].' ';

		if(is_array($formData['fpidarr']) && count($formData['fpidarr']) > 0 )
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.p_id IN ('.implode(',',$formData['fpidarr']).') ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.od_id = '.(int)$formData['fid'].' ';

		if($formData['fpricesell'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.od_price_sell = '.(float)$formData['fpricesell'].' ';

		if($formData['fpricefinal'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'od.od_price_final = '.(float)$formData['fpricefinal'].' ';

		if(!empty($formData['isgroupbyorder']))
        {
			$whereString .= ' GROUP BY od.o_id';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'od_id ' . $sorttype;
		elseif($sortby == 'oid')
			$orderString = 'o_id ' . $sorttype;
		else
			$orderString = 'od_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}