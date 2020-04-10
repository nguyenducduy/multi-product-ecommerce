<?php

/**
 * core/class.storetypeforecast.php
 *
 * File contains the class used for StoreTypeForecast Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_StoreTypeForecast extends Core_Backend_Object
{

	const TYPE_A = 1;
	const TYPE_B = 2;
	const TYPE_C = 3;

	public $sid = 0;
	public $pcid = 0;
	public $id = 0;
	public $type = 0;
	public $uid = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store_type_forecast (
					s_id,
					pc_id,
					stf_type,
					u_id,
					stf_datecreated,
					stf_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->sid,
					(int)$this->pcid,
					(int)$this->type,
					(int)$this->uid,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'store_type_forecast
				SET s_id = ?,
					pc_id = ?,
					stf_type = ?,
					u_id = ?,
					stf_datecreated = ?,
					stf_datemodified = ?
				WHERE stf_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->sid,
					(int)$this->pcid,
					(int)$this->type,
					(int)$this->uid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_type_forecast stf
				WHERE stf.stf_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->sid = $row['s_id'];
		$this->pcid = $row['pc_id'];
		$this->id = $row['stf_id'];
		$this->type = $row['stf_type'];
		$this->uid = $row['u_id'];
		$this->datecreated = $row['stf_datecreated'];
		$this->datemodified = $row['stf_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'store_type_forecast
				WHERE stf_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'store_type_forecast stf';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'store_type_forecast stf';

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
			$myStoreTypeForecast = new Core_Backend_StoreTypeForecast();

			$myStoreTypeForecast->sid = $row['s_id'];
			$myStoreTypeForecast->pcid = $row['pc_id'];
			$myStoreTypeForecast->id = $row['stf_id'];
			$myStoreTypeForecast->type = $row['stf_type'];
			$myStoreTypeForecast->uid = $row['u_id'];
			$myStoreTypeForecast->datecreated = $row['stf_datecreated'];
			$myStoreTypeForecast->datemodified = $row['stf_datemodified'];


            $outputList[] = $myStoreTypeForecast;
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
	public static function getStoreTypeForecasts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stf.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stf.pc_id = '.(int)$formData['fpcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stf.stf_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stf.stf_type = '.(int)$formData['ftype'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stf.u_id = '.(int)$formData['fuid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'stf_id ' . $sorttype;
		else
			$orderString = 'stf_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	public static function gettypeList()
   	{
   		$outputList = array();

   		$outputList[self::TYPE_A] = 'A';
   		$outputList[self::TYPE_B] = 'B';
   		$outputList[self::TYPE_C] = 'C';

   		return $outputList;
   	}

   	public function getTypeName()
   	{
   		$name = '';

   		switch ((int)$this->type)
   		{
   			case self::TYPE_A:
   				$name = 'A';
   				break;

   			case self::TYPE_B:
   				$name = 'B';
   				break;

   			case self::TYPE_C:
   				$name = 'C';
   				break;

   		}

   		return $name;
   	}
}