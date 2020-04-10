<?php

/**
 * core/class.hrmtitle.php
 *
 * File contains the class used for HrmTitle Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_HrmTitle extends Core_Object
{

	public $id = 0;
	public $name = "";
	public $departmentid = 0;
	public $priority = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'hrm_title (
					ht_name,
					ht_departmentid,
					ht_priority
					)
		        VALUES(?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->departmentid,
					(int)$this->priority
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'hrm_title
				SET ht_name = ?,
					ht_departmentid = ?,
					ht_priority = ?
				WHERE ht_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->departmentid,
					(int)$this->priority,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'hrm_title ht
				WHERE ht.ht_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['ht_id'];
		$this->name = $row['ht_name'];
		$this->departmentid = $row['ht_departmentid'];
		$this->priority = $row['ht_priority'];

	}

	public function getDataByArray($row)
	{
		$this->id = $row['ht_id'];
		$this->name = $row['ht_name'];
		$this->departmentid = $row['ht_departmentid'];
		$this->priority = $row['ht_priority'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'hrm_title
				WHERE ht_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'hrm_title ht';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'hrm_title ht';

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
			$myHrmTitle = new Core_HrmTitle();

			$myHrmTitle->id = $row['ht_id'];
			$myHrmTitle->name = $row['ht_name'];
			$myHrmTitle->departmentid = $row['ht_departmentid'];
			$myHrmTitle->priority = $row['ht_priority'];


            $outputList[] = $myHrmTitle;
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
	public static function getHrmTitles($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ht.ht_id = '.(int)$formData['fid'].' ';

		if($formData['fdepartmentid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ht.ht_departmentid = '.(int)$formData['fdepartmentid'].' ';

		if($formData['fpriority'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ht.ht_priority = '.(int)$formData['fpriority'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'ht.ht_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (ht.ht_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ht_id ' . $sorttype;
		elseif($sortby == 'priority')
			$orderString = 'ht_priority ' . $sorttype;
		else
			$orderString = 'ht_id ' . $sorttype;

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
		return 'hrmtitle_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myHrmTitle = new Core_HrmTitle();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'hrm_title
					WHERE ht_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['ht_id'] > 0)
			{
				$myHrmTitle->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myHrmTitle->getDataByArray($row);
		}

		return $myHrmTitle;
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