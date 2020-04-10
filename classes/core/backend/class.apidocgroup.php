<?php

/**
 * core/class.apidocgroup.php
 *
 * File contains the class used for ApidocGroup Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_ApidocGroup extends Core_Backend_Object
{
	const ZONE_WEBSITE = 1;
	const ZONE_ENTERPRISE = 3;

	const STATUS_IMPLEMENT = 1;
	const STATUS_PROTOTYPE = 3;
	const STATUS_DEPRECATED = 5;
	const STATUS_DISABLED = 7;


	public $id = 0;
	public $name = "";
	public $summary = "";
	public $zone = 0;
	public $status = 0;
	public $displayorder = 0;
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
		$this->displayorder = $this->getMaxOrder();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'apidoc_group (
					ag_name,
					ag_summary,
					ag_zone,
					ag_status,
					ag_displayorder,
					ag_datecreated,
					ag_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(string)$this->name,
					(string)$this->summary,
					(int)$this->zone,
					(int)$this->status,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(int)$this->datemodified
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'apidoc_group
				SET ag_name = ?,
					ag_summary = ?,
					ag_zone = ?,
					ag_status = ?,
					ag_displayorder = ?,
					ag_datecreated = ?,
					ag_datemodified = ?
				WHERE ag_id = ?';

		$stmt = $this->db3->query($sql, array(
					(string)$this->name,
					(string)$this->summary,
					(int)$this->zone,
					(int)$this->status,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_group ag
				WHERE ag.ag_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->id = $row['ag_id'];
		$this->name = $row['ag_name'];
		$this->summary = $row['ag_summary'];
		$this->zone = $row['ag_zone'];
		$this->status = $row['ag_status'];
		$this->displayorder = $row['ag_displayorder'];
		$this->datecreated = $row['ag_datecreated'];
		$this->datemodified = $row['ag_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'apidoc_group
				WHERE ag_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		//delete all request
		$requestList = Core_Backend_ApidocRequest::getApidocRequests(array('fagid' => $this->id), '', '', '');
		for($i = 0; $i < count($requestList); $i++)
		{
			$requestList[$i]->delete();
		}

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'apidoc_group ag';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'apidoc_group ag';

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
			$myApidocGroup = new Core_Backend_ApidocGroup();

			$myApidocGroup->id = $row['ag_id'];
			$myApidocGroup->name = $row['ag_name'];
			$myApidocGroup->summary = $row['ag_summary'];
			$myApidocGroup->zone = $row['ag_zone'];
			$myApidocGroup->status = $row['ag_status'];
			$myApidocGroup->displayorder = $row['ag_displayorder'];
			$myApidocGroup->datecreated = $row['ag_datecreated'];
			$myApidocGroup->datemodified = $row['ag_datemodified'];


            $outputList[] = $myApidocGroup;
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
	public static function getApidocGroups($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fzone'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_zone = '.(int)$formData['fzone'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_status = '.(int)$formData['fstatus'].' ';

		if($formData['fenable'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_status != '.self::STATUS_DISABLED.' ';

		if(count($formData['fstatuslist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_status IN ('. implode(',', $formData['fstatuslist']).') ';

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ag.ag_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ag.ag_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (ag.ag_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ag_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'ag_displayorder ' . $sorttype;
		elseif($sortby == 'zonedisplayorder')
			$orderString = 'ag_zone ASC, ag_displayorder ' . $sorttype;
		else
			$orderString = 'ag_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxOrder()
	{
		$sql = 'SELECT MAX(ag_displayorder)
				FROM ' . TABLE_PREFIX . 'apidoc_group
				WHERE ag_zone = ?';
		return $this->db3->query($sql, array($this->zone))->fetchColumn(0)+1;
	}


	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_IMPLEMENT] = 'Implemented';
		$output[self::STATUS_PROTOTYPE] = 'Just Prototyping';
		$output[self::STATUS_DEPRECATED] = 'Deprecated';
		$output[self::STATUS_DISABLED] = 'Disabled';


		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_IMPLEMENT: $name = 'Implemented'; break;
			case self::STATUS_PROTOTYPE: $name = 'Just Prototyping'; break;
			case self::STATUS_DEPRECATED: $name = 'Deprecated'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return (
			($name == 'implement' && $this->status == self::STATUS_IMPLEMENT) ||
			($name == 'prototype' && $this->status == self::STATUS_PROTOTYPE) ||
			($name == 'deprecated' && $this->status == self::STATUS_DEPRECATED) ||
			($name == 'disabled' && $this->status == self::STATUS_DISABLED)
			);
	}



	public static function getZoneList()
	{
		$output = array();

		$output[self::ZONE_WEBSITE] = 'Website';
		$output[self::ZONE_ENTERPRISE] = 'Enterprise';


		return $output;
	}

	public function getZoneName()
	{
		$name = '';

		switch($this->zone)
		{
			case self::ZONE_WEBSITE: $name = 'Website'; break;
			case self::ZONE_ENTERPRISE: $name = 'Enterprise'; break;
		}

		return $name;
	}

	public function checkZoneName($name)
	{
		$name = strtolower($name);

		return (
			($name == 'website' && $this->zone == self::ZONE_WEBSITE) ||
			($name == 'enterprise' && $this->zone == self::ZONE_ENTERPRISE)
			);
	}



}