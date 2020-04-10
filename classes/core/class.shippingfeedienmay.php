<?php

/**
 * core/class.shippingfeedienmay.php
 *
 * File contains the class used for ShippingfeeDienmay Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ShippingfeeDienmay Class
 */
Class Core_ShippingfeeDienmay extends Core_Object
{

	public $id = 0;
	public $provincestart = 0;
	public $districtstart = 0;
	public $provinceend = 0;
	public $districtend = 0;
	public $ttc = '';//km min max ; có phục vụ hay không? ; có phải Vùng sâu hay không?
	public $sbp = '';//khu vuc ; có phục vụ hay không? ; có phải Vùng sâu hay không?

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'shippingfee_dienmay (
					sfd_province_start,
					sfd_district_start,
					sfd_province_end,
					sfd_district_end,
					sfd_ttc,
					sfd_sbp
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->provincestart,
					(int)$this->districtstart,
					(int)$this->provinceend,
					(int)$this->districtend,
					(string)$this->ttc,
					(string)$this->sbp
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'shippingfee_dienmay
				SET sfd_province_start = ?,
					sfd_district_start = ?,
					sfd_province_end = ?,
					sfd_district_end = ?,
					sfd_ttc = ?,
					sfd_sbp = ?
				WHERE sfd_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->provincestart,
					(int)$this->districtstart,
					(int)$this->provinceend,
					(int)$this->districtend,
					(string)$this->ttc,
					(string)$this->sbp,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_dienmay sd
				WHERE sd.sfd_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = (int)$row['sfd_id'];
		$this->provincestart = (int)$row['sfd_province_start'];
		$this->districtstart = (int)$row['sfd_district_start'];
		$this->provinceend = (int)$row['sfd_province_end'];
		$this->districtend = (int)$row['sfd_district_end'];
		$this->ttc = (string)$row['sfd_ttc'];
		$this->sbp = (string)$row['sfd_sbp'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'shippingfee_dienmay
				WHERE sfd_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'shippingfee_dienmay sd';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_dienmay sd';

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
			$myShippingfeeDienmay = new Core_ShippingfeeDienmay();

			$myShippingfeeDienmay->id = (int)$row['sfd_id'];
			$myShippingfeeDienmay->provincestart = (int)$row['sfd_province_start'];
			$myShippingfeeDienmay->districtstart = (int)$row['sfd_district_start'];
			$myShippingfeeDienmay->provinceend = (int)$row['sfd_province_end'];
			$myShippingfeeDienmay->districtend = (int)$row['sfd_district_end'];
			$myShippingfeeDienmay->ttc = (string)$row['sfd_ttc'];
			$myShippingfeeDienmay->sbp = (string)$row['sfd_sbp'];


            $outputList[] = $myShippingfeeDienmay;
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
	public static function getShippingfeeDienmays($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sd.sfd_id = '.(int)$formData['fid'].' ';

		if($formData['fprovincestart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sd.sfd_province_start = '.(int)$formData['fprovincestart'].' ';

		if($formData['fdistrictstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sd.sfd_district_start = '.(int)$formData['fdistrictstart'].' ';

		if($formData['fprovinceend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sd.sfd_province_end = '.(int)$formData['fprovinceend'].' ';

		if($formData['fdistrictend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sd.sfd_district_end = '.(int)$formData['fdistrictend'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sfd_id ' . $sorttype;
		else
			$orderString = 'sfd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}
}
