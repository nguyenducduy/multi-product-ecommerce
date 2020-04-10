<?php

/**
 * core/class.adszone.php
 *
 * File contains the class used for AdsZone Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_AdsZone extends Core_Object
{

	const SITE_DIENMAY = 1;

	public $id = 0;
	public $name = "";
	public $summary = "";
	public $site = 0;
	public $managerid = 0;

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

		$this->site = self::SITE_DIENMAY;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ads_zone (
					az_name,
					az_summary,
					az_site,
					az_managerid
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->summary,
					(int)$this->site,
					(int)$this->managerid
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
		$this->site = self::SITE_DIENMAY;

		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads_zone
				SET az_name = ?,
					az_summary = ?,
					az_site = ?,
					az_managerid = ?
				WHERE az_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->summary,
					(int)$this->site,
					(int)$this->managerid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_zone az
				WHERE az.az_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['az_id'];
		$this->name = $row['az_name'];
		$this->summary = $row['az_summary'];
		$this->site = $row['az_site'];
		$this->managerid = $row['az_managerid'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads_zone
				WHERE az_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ads_zone az';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_zone az';

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
			$myAdsZone = new Core_AdsZone();

			$myAdsZone->id = $row['az_id'];
			$myAdsZone->name = $row['az_name'];
			$myAdsZone->summary = $row['az_summary'];
			$myAdsZone->site = $row['az_site'];
			$myAdsZone->managerid = $row['az_managerid'];


            $outputList[] = $myAdsZone;
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
	public static function getAdsZones($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'az.az_id = '.(int)$formData['fid'].' ';

		if($formData['fsite'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'az.az_site = '.(int)$formData['fsite'].' ';

		if($formData['fmanagerid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'az.az_managerid = '.(int)$formData['fmanagerid'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'az.az_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'az.az_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (az.az_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (az.az_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'az_id ' . $sorttype;
		else
			$orderString = 'az_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}