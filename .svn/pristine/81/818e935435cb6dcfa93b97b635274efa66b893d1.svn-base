<?php

/**
 * core/backend/class.adsimpression.php
 *
 * File contains the class used for AdsImpression Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_AdsImpression extends Core_Backend_Object
{
	const PLATFORM_DESKTOP = 1;
	const PLATFORM_TABLE = 3;
	const PLATFORM_MOBILE = 5;

	public $uid = 0;
	public $aid = 0;
	public $id = 0;
	public $platform = 0;
	public $ipaddress = 0;
	public $datecreated = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ads_impression (
					u_id,
					a_id,
					ai_platform,
					ai_ipaddress,
					ai_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->aid,
					(int)$this->platform,
					(int)$this->ipaddress,
					(int)$this->datecreated
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
		return $this->id;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads_impression
				SET u_id = ?,
					a_id = ?,
					ai_platform = ?,
					ai_ipaddress = ?,
					ai_datecreated = ?
				WHERE ai_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->aid,
					(int)$this->platform,
					(int)$this->ipaddress,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_impression ai
				WHERE ai.ai_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->aid = $row['a_id'];
		$this->id = $row['ai_id'];
		$this->platform = $row['ai_platform'];
		$this->ipaddress = $row['ai_ipaddress'];
		$this->datecreated = $row['ai_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads_impression
				WHERE ai_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where)
	{
		$db3 = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ads_impression ai';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db3->query($sql)->fetchColumn(0);
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
		$db3 = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads_impression ai';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myAdsImpression = new Core_Backend_AdsImpression();

			$myAdsImpression->uid = $row['u_id'];
			$myAdsImpression->aid = $row['a_id'];
			$myAdsImpression->id = $row['ai_id'];
			$myAdsImpression->platform = $row['ai_platform'];
			$myAdsImpression->ipaddress = $row['ai_ipaddress'];
			$myAdsImpression->datecreated = $row['ai_datecreated'];


            $outputList[] = $myAdsImpression;
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
	public static function getAdsImpressions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.u_id = '.(int)$formData['fuid'].' ';

		if($formData['faid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.a_id = '.(int)$formData['faid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.ai_id = '.(int)$formData['fid'].' ';

		if($formData['fplatform'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.ai_platform = '.(int)$formData['fplatform'].' ';

		if($formData['fipaddress'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.ai_ipaddress = '.(int)$formData['fipaddress'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ai.ai_datecreated = '.(int)$formData['fdatecreated'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ai_id ' . $sorttype;
		else
			$orderString = 'ai_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}