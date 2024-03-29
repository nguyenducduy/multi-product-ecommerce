<?php

/**
 * core/class.storestatistic.php
 *
 * File contains the class used for StoreStatistic Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_StoreStatistic extends Core_Backend_Object
{

	public $sid = 0;
	public $id = 0;
	public $statisticvalue = 0;
	public $statisticdate = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store_statistic (
					s_id,
					ss_statisticvalue,
					ss_statisticdate
					)
		        VALUES(?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->sid,
					(int)$this->statisticvalue,
					(int)$this->statisticdate
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'store_statistic
				SET s_id = ?,
					ss_statisticvalue = ?,
					ss_statisticdate = ?
				WHERE ss_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->sid,
					(int)$this->statisticvalue,
					(int)$this->statisticdate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_statistic ss
				WHERE ss.ss_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->sid = $row['s_id'];
		$this->id = $row['ss_id'];
		$this->statisticvalue = $row['ss_statisticvalue'];
		$this->statisticdate = $row['ss_statisticdate'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'store_statistic
				WHERE ss_id = ?';
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
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'store_statistic ss';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_statistic ss';

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
			$myStoreStatistic = new Core_StoreStatistic();

			$myStoreStatistic->sid = $row['s_id'];
			$myStoreStatistic->id = $row['ss_id'];
			$myStoreStatistic->statisticvalue = $row['ss_statisticvalue'];
			$myStoreStatistic->statisticdate = $row['ss_statisticdate'];


            $outputList[] = $myStoreStatistic;
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
	public static function getStoreStatistics($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_id = '.(int)$formData['fid'].' ';

		if($formData['fstatisticdate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ss.ss_statisticdate = '.(int)$formData['fstatisticdate'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ss_id ' . $sorttype;
		else
			$orderString = 'ss_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}