<?php

/**
 * core/class.campaignautumn.php
 *
 * File contains the class used for CampaignAutumn Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_CampaignAutumn extends Core_Object
{

	const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 0;
	public $id = 0;
	public $name = "";
	public $listproduct = "";
	public $starttime = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'campaign_autumn (
					ca_name,
					ca_listproduct,
					ca_starttime,
					ca_status,
					ca_datecreated,
					ca_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->listproduct,
					(int)$this->starttime,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'campaign_autumn
				SET ca_name = ?,
					ca_listproduct = ?,
					ca_starttime = ?,
					ca_status = ?,
					ca_datecreated = ?,
					ca_datemodified = ?
				WHERE ca_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->listproduct,
					(int)$this->starttime,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_autumn ca
				WHERE ca.ca_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['ca_id'];
		$this->name = $row['ca_name'];
		$this->listproduct = $row['ca_listproduct'];
		$this->starttime = $row['ca_starttime'];
		$this->status = $row['ca_status'];
		$this->datecreated = $row['ca_datecreated'];
		$this->datemodified = $row['ca_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'campaign_autumn
				WHERE ca_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'campaign_autumn ca';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_autumn ca';

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
			$myCampaignAutumn = new Core_CampaignAutumn();

			$myCampaignAutumn->id = $row['ca_id'];
			$myCampaignAutumn->name = $row['ca_name'];
			$myCampaignAutumn->listproduct = $row['ca_listproduct'];
			$myCampaignAutumn->starttime = $row['ca_starttime'];
			$myCampaignAutumn->status = $row['ca_status'];
			$myCampaignAutumn->datecreated = $row['ca_datecreated'];
			$myCampaignAutumn->datemodified = $row['ca_datemodified'];


            $outputList[] = $myCampaignAutumn;
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
	public static function getCampaignAutumns($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ca.ca_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ca.ca_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fpid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ca.ca_listproduct = "'.Helper::unspecialtext((string)$formData['fpid']).'"';

		if($formData['fstarttime'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ca.ca_starttime = "'.(int)$formData['fstarttime'].'"';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ca.ca_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ca_id ' . $sorttype;
		else
			$orderString = 'ca_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
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

    public function checkStatusName($name)
    {
        $name = strtolower($name);

        if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
            return true;
        else
            return false;
    }


}