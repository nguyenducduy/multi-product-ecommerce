<?php

/**
 * core/class.productcolor.php
 *
 * File contains the class used for Productcolor Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Productcolor extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $id = 0;
	public $name = "";
	public $code = "";
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productcolor (
					pl_name,
					pl_code,
					pl_status,
					pl_datecreated,
					pl_datemodified
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->code,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'productcolor
				SET pl_name = ?,
					pl_code = ?,
					pl_status = ?,
					pl_datecreated = ?,
					pl_datemodified = ?
				WHERE pl_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->code,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcolor pt
				WHERE pt.pl_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['pl_id'];
		$this->name = $row['pl_name'];
		$this->code = $row['pl_code'];
		$this->status = $row['pl_status'];
		$this->datecreated = $row['pl_datecreated'];
		$this->datemodified = $row['pl_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productcolor
				WHERE pl_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productcolor pt';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcolor pt';

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
			$myProductcolor = new Core_Productcolor();

			$myProductcolor->id = $row['pl_id'];
			$myProductcolor->name = $row['pl_name'];
			$myProductcolor->code = $row['pl_code'];
			$myProductcolor->status = $row['pl_status'];
			$myProductcolor->datecreated = $row['pl_datecreated'];
			$myProductcolor->datemodified = $row['pl_datemodified'];


            $outputList[] = $myProductcolor;
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
	public static function getProductcolors($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pt.pl_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pt.pl_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pt.pl_code = "'.Helper::unspecialtext((string)$formData['fcode']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pt.pl_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pl_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'pl_name ' . $sorttype;
		else
			$orderString = 'pl_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
			return true;
		else
			return false;
	}

	public static function getDefaultColorList()
	{
		$codeColor = array('#FF0000', '#F88017', '#FFFF00', '#59E817', '#03c0c6', '#0000ff', '#762ca7', '#ff98bf', '#FFFFFF', '#999999', '#000000', '#885418');

		return $codeColor;
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function getProductcolorByCode($code = '')
	{
		if($code != '')
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcolor
					WHERE pl_code = ?';
			$row = $this->db->query($sql, array($code))->fetch();

			$this->id = $row['pl_id'];
			$this->name = $row['pl_name'];
			$this->code = $row['pl_code'];
			$this->status = $row['pl_status'];
			$this->datecreated = $row['pl_datecreated'];
			$this->datemodified = $row['pl_datemodified'];
		}
	}



}