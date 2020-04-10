<?php

/**
 * core/class.lotteevent.php
 *
 * File contains the class used for LotteEvent Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_LotteEvent extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $datebegin = 0;
	public $dateend = 0;
	public $status = 0;
	public $pageid = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0, $loadFromCache = false)
	{
		parent::__construct();
		if($id > 0)
		{
			if($loadFromCache)
				$this->copy(self::cacheGet($id));
			else
				$this->getData($id);
		}
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'lotte_event (
					le_name,
					le_datebegin,
					le_dateend,
					le_status,
					le_pageid,
					le_datecreated,
					le_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->datebegin,
					(int)$this->dateend,
					(int)$this->status,
					(int)$this->pageid,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'lotte_event
				SET le_name = ?,
					le_datebegin = ?,
					le_dateend = ?,
					le_status = ?,
					le_pageid = ?,
					le_datecreated = ?,
					le_datemodified = ?
				WHERE le_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->datebegin,
					(int)$this->dateend,
					(int)$this->status,
					(int)$this->pageid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_event le
				WHERE le.le_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['le_id'];
		$this->name = $row['le_name'];
		$this->datebegin = $row['le_datebegin'];
		$this->dateend = $row['le_dateend'];
		$this->status = $row['le_status'];
		$this->pageid = $row['le_pageid'];
		$this->datecreated = $row['le_datecreated'];
		$this->datemodified = $row['le_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->id = $row['le_id'];
		$this->name = $row['le_name'];
		$this->datebegin = $row['le_datebegin'];
		$this->dateend = $row['le_dateend'];
		$this->status = $row['le_status'];
		$this->pageid = $row['le_pageid'];
		$this->datecreated = $row['le_datecreated'];
		$this->datemodified = $row['le_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'lotte_event
				WHERE le_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'lotte_event le';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_event le';

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
			$myLotteEvent = new Core_LotteEvent();

			$myLotteEvent->id = $row['le_id'];
			$myLotteEvent->name = $row['le_name'];
			$myLotteEvent->datebegin = $row['le_datebegin'];
			$myLotteEvent->dateend = $row['le_dateend'];
			$myLotteEvent->status = $row['le_status'];
			$myLotteEvent->pageid = $row['le_pageid'];
			$myLotteEvent->datecreated = $row['le_datecreated'];
			$myLotteEvent->datemodified = $row['le_datemodified'];


            $outputList[] = $myLotteEvent;
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
	public static function getLotteEvents($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fdatebegin'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_datebegin = '.(int)$formData['fdatebegin'].' ';

		if($formData['fdateend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_dateend = '.(int)$formData['fdateend'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_status = '.(int)$formData['fstatus'].' ';

		if($formData['fpageid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_pageid = '.(int)$formData['fpageid'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_datemodified = '.(int)$formData['fdatemodified'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'le.le_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (le.le_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'le_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'le_name ' . $sorttype;
		elseif($sortby == 'datebegin')
			$orderString = 'le_datebegin ' . $sorttype;
		elseif($sortby == 'dateend')
			$orderString = 'le_dateend ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'le_status ' . $sorttype;
		elseif($sortby == 'pageid')
			$orderString = 'le_pageid ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'le_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'le_datemodified ' . $sorttype;
		else
			$orderString = 'le_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	////////////////////////////////
	////////////////////////////////
	// START CACHE PROCESS

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $id
	*/
	public static function cacheBuildKey($id)
	{
		return 'lotteevent_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myLotteEvent = new Core_LotteEvent();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_event
					WHERE le_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['le_id'] > 0)
			{
				$myLotteEvent->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myLotteEvent->getDataByArray($row);
		}

		return $myLotteEvent;
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $id
	*/
	public static function cacheClear($id)
	{
		$myCacher = new Cacher(self::cacheBuildKey($id));
		return $myCacher->clear();
	}

	// - END CACHE PROCESS
	////////////////////////////////
}