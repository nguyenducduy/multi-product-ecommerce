<?php

/**
 * core/class.shippingfeevxvsttc.php
 *
 * File contains the class used for ShippingfeeVxvsTtc Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ShippingfeeVxvsTtc Class
 */
Class Core_ShippingfeeVxvsTtc extends Core_Object
{
	
	public $rid = 0;
	public $id = 0;
	public $districtid = 0;
	public $less30kg = 0;
	public $from30kg = 0;

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
		
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc (
					rid,
					svt_districtid,
					svt_less30kg,
					svt_from30kg
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->rid,
					(int)$this->districtid,
					(int)$this->less30kg,
					(int)$this->from30kg
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
		
		$sql = 'UPDATE ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc
				SET rid = ?,
					svt_districtid = ?,
					svt_less30kg = ?,
					svt_from30kg = ?
				WHERE svt_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->rid,
					(int)$this->districtid,
					(int)$this->less30kg,
					(int)$this->from30kg,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc svt
				WHERE svt.svt_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->rid = (int)$row['rid'];
		$this->id = (int)$row['svt_id'];
		$this->districtid = (int)$row['svt_districtid'];
		$this->less30kg = (int)$row['svt_less30kg'];
		$this->from30kg = (int)$row['svt_from30kg'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc
				WHERE svt_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc svt';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_vxvs_ttc svt';

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
			$myShippingfeeVxvsTtc = new Core_ShippingfeeVxvsTtc();

			$myShippingfeeVxvsTtc->rid = (int)$row['rid'];
			$myShippingfeeVxvsTtc->id = (int)$row['svt_id'];
			$myShippingfeeVxvsTtc->districtid = (int)$row['svt_districtid'];
			$myShippingfeeVxvsTtc->less30kg = (int)$row['svt_less30kg'];
			$myShippingfeeVxvsTtc->from30kg = (int)$row['svt_from30kg'];
			

            $outputList[] = $myShippingfeeVxvsTtc;
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
	public static function getShippingfeeVxvsTtcs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'svt.rid = '.(int)$formData['frid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'svt.svt_id = '.(int)$formData['fid'].' ';

		if($formData['fdistrictid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'svt.svt_districtid = '.(int)$formData['fdistrictid'].' ';


		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'svt_id ' . $sorttype; 
		else
			$orderString = 'svt_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

	



}