<?php

/**
 * core/class.shippingfeesettings.php
 *
 * File contains the class used for ShippingfeeSettings Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ShippingfeeSettings Class
 */
Class Core_ShippingfeeSettings extends Core_Object
{

	public $id = 0;
	public $name = '';
	public $price = 0;
	public $typefee = 0;
	public $ispercent = 0;
	public $order = 0;

	const TYPEFEE_TTC = 2;
    const TYPEFEE_SBP = 20;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'shippingfee_settings (
					sfs_name,
					sfs_price,
					sfs_typefee,
					sfs_ispercent,
					sfs_order
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->price,
					(int)$this->typefee,
					(int)$this->ispercent,
					(int)$this->order
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'shippingfee_settings
				SET sfs_name = ?,
					sfs_price = ?,
					sfs_typefee = ?,
					sfs_ispercent = ?,
					sfs_order = ?
				WHERE sfs_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->price,
					(int)$this->typefee,
					(int)$this->ispercent,
					(int)$this->order,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_settings ss
				WHERE ss.sfs_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = (int)$row['sfs_id'];
		$this->name = (string)$row['sfs_name'];
		$this->price = (int)$row['sfs_price'];
		$this->typefee = (int)$row['sfs_typefee'];
		$this->ispercent = (int)$row['sfs_ispercent'];
		$this->order = (int)$row['sfs_order'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'shippingfee_settings
				WHERE sfs_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'shippingfee_settings ss';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'shippingfee_settings ss';

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
			$myShippingfeeSettings = new Core_ShippingfeeSettings();

			$myShippingfeeSettings->id = (int)$row['sfs_id'];
			$myShippingfeeSettings->name = (string)$row['sfs_name'];
			$myShippingfeeSettings->price = (int)$row['sfs_price'];
			$myShippingfeeSettings->typefee = (int)$row['sfs_typefee'];
			$myShippingfeeSettings->ispercent = (int)$row['sfs_ispercent'];
			$myShippingfeeSettings->order = (int)$row['sfs_order'];


            $outputList[] = $myShippingfeeSettings;
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
	public static function getShippingfeeSettingss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sfs_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sfs_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['ftypefee'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sfs_typefee = '.(int)$formData['ftypefee'].' ';

		if($formData['forder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sfs_order = '.(int)$formData['forder'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.sfs_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ss.sfs_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sfs_id ' . $sorttype;
		else
			$orderString = 'sfs_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public function getTypeFee()
    {
        if ($this->typefee == Core_ShippingfeeSettings::TYPEFEE_TTC) {
            return 'TTC';
        } else {
            return 'SBP';
        }
    }
}