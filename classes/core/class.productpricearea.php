<?php

/**
 * core/class.productpricearea.php
 *
 * File contains the class used for ProductPriceArea Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductPriceArea extends Core_Object
{

	public $id = 0;
    public $name = "";
    public $displayname = '';
    public $isactive = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price_area (
                    ppa_name,
                    ppa_displayname,
					ppa_isactive,
					ppa_datecreated,
					ppa_datemodified
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
                    (string)$this->name,
                    (string)$this->displayname,
					(int)$this->isactive,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_price_area
                SET ppa_name = ?,
                    ppa_displayname = ?,
					ppa_isactive = ?,
					ppa_datecreated = ?,
					ppa_datemodified = ?
				WHERE ppa_id = ?';

		$stmt = $this->db->query($sql, array(
                    (string)$this->name,
                    (string)$this->displayname,
					(int)$this->isactive,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_price_area ppa
				WHERE ppa.ppa_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['ppa_id'];
        $this->name = $row['ppa_name'];
        $this->displayname = $row['ppa_displayname'];
		$this->isactive = $row['ppa_isactive'];
		$this->datecreated = $row['ppa_datecreated'];
		$this->datemodified = $row['ppa_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price_area
				WHERE ppa_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_price_area ppa';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_price_area ppa';

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
			$myProductPriceArea = new Core_ProductPriceArea();

			$myProductPriceArea->id = $row['ppa_id'];
            $myProductPriceArea->name = $row['ppa_name'];
            $myProductPriceArea->displayname = $row['ppa_displayname'];
			$myProductPriceArea->isactive = $row['ppa_isactive'];
			$myProductPriceArea->datecreated = $row['ppa_datecreated'];
			$myProductPriceArea->datemodified = $row['ppa_datemodified'];


            $outputList[] = $myProductPriceArea;
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
	public static function getProductPriceAreas($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ppa.ppa_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ppa.ppa_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fisactive'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ppa.ppa_isactive = '.(int)$formData['fisactive'].' ';

		if(is_array($formData['fidarr']) && empty($formData['fid']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ppa.ppa_id IN ('.implode(',',$formData['fidarr']).') ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ppa.ppa_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ppa.ppa_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ppa_id ' . $sorttype;
		else
			$orderString = 'ppa_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}
