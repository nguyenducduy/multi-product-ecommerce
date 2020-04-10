<?php

/**
 * core/class.relproducteventuser.php
 *
 * File contains the class used for RelProductEventUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelProductEventUser extends Core_Object
{

	public $epid = 0;
	public $euid = 0;
	public $id = 0;
	public $position = 0;
	public $status = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_event_user (
					ep_id,
					eu_id,
					rpeu_position,
					rpeu_status
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->epid,
					(int)$this->euid,
					(int)$this->position,
					(int)$this->status
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_event_user
				SET ep_id = ?,
					eu_id = ?,
					rpeu_position = ?,
					rpeu_status = ?
				WHERE rpeu_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->epid,
					(int)$this->euid,
					(int)$this->position,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_event_user rpeu
				WHERE rpeu.rpeu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->epid = $row['ep_id'];
		$this->euid = $row['eu_id'];
		$this->id = $row['rpeu_id'];
		$this->position = $row['rpeu_position'];
		$this->status = $row['rpeu_status'];

	}

	/**
	 * Get the object data base on position
	 * @param int $id : the primary key value for searching record.
	 */
	public static function getCustomervinner($product_id)
	{
		global $db;
		$product_id = (int)$product_id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_event_user rpeu
				WHERE rpeu.ep_id = ? and rpeu.rpeu_position = 29';
		$row = $db->query($sql, array($product_id))->fetch();

		$myRelProductEventUser = new Core_RelProductEventUser();

		$myRelProductEventUser->epid = $row['ep_id'];
		$myRelProductEventUser->euid = $row['eu_id'];
		$myRelProductEventUser->id = $row['rpeu_id'];
		$myRelProductEventUser->position = $row['rpeu_position'];
		$myRelProductEventUser->status = $row['rpeu_status'];
		return $myRelProductEventUser;
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_product_event_user
				WHERE rpeu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_product_event_user rpeu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_product_event_user rpeu';

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
			$myRelProductEventUser = new Core_RelProductEventUser();

			$myRelProductEventUser->epid = $row['ep_id'];
			$myRelProductEventUser->euid = $row['eu_id'];
			$myRelProductEventUser->id = $row['rpeu_id'];
			$myRelProductEventUser->position = $row['rpeu_position'];
			$myRelProductEventUser->status = $row['rpeu_status'];


            $outputList[] = $myRelProductEventUser;
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
	public static function getRelProductEventUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fepid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpeu.ep_id = '.(int)$formData['fepid'].' ';

		if($formData['fposition'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpeu.rpeu_position = '.(int)$formData['fposition'].' ';

		if($formData['feuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpeu.eu_id = '.(int)$formData['feuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rpeu.rpeu_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'rpeu_id ' . $sorttype;
		elseif($sortby == 'position')
			$orderString = 'rpeu_position ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'rpeu_status ' . $sorttype;
		else
			$orderString = 'rpeu_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}