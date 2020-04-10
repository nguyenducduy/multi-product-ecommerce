<?php

/**
 * core/class.enemy.php
 *
 * File contains the class used for Enemy Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Enemy extends Core_Object
{

	public $id = 0;
	public $rid = 0;
	public $name = "";
	public $website = "";
	public $displayorder = 0;
	public $datecreated = 0;
	public $dateupdated = 0;
    public $priceauto = 0;
	public $priceenemyactor = null;

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
		$this->displayorder =  $this->getMaxDisplayOrder() + 1;


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'enemy (
					r_id,
					e_name,
					e_website,
					e_displayorder,
					e_datecreated,
					e_dateupdated
					)
		        VALUES(?, ?, ?, ?,?,?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->rid,
					(string)$this->name,
					(string)$this->website,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(int)$this->dateupdated
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
		$this->dateupdated = time();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'enemy
				SET
					r_id = ?,
					e_name = ?,
					e_website = ?,
					e_displayorder = ?,
					e_datecreated = ?,
					e_dateupdated = ?
				WHERE e_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->rid,
					(string)$this->name,
					(string)$this->website,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(int)$this->dateupdated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'enemy e
				WHERE e.e_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();
		$this->rid = $row['r_id'];
		$this->id = $row['e_id'];
		$this->name = $row['e_name'];
		$this->website = $row['e_website'];
		$this->displayorder = $row['e_displayorder'];
		$this->datecreated = $row['e_datecreated'];
		$this->dateupdated = $row['e_dateupdated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'enemy
				WHERE e_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'enemy e';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'enemy e';

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
			$myEnemy = new Core_Enemy();
			$myEnemy->rid = $row['r_id'];
			$myEnemy->id = $row['e_id'];
			$myEnemy->name = $row['e_name'];
			$myEnemy->website = $row['e_website'];
			$myEnemy->displayorder = $row['e_displayorder'];
			$myEnemy->datecreated = $row['e_datecreated'];
			$myEnemy->dateupdated = $row['e_dateupdated'];


            $outputList[] = $myEnemy;
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
	public static function getEnemys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_id = '.(int)$formData['fid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.r_id = '.(int)$formData['frid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_name LIKE "%'.Helper::unspecialtext((string)$formData['fname']).'%" ';
		if($formData['fwebsite'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_website LIKE "%'.Helper::unspecialtext((string)$formData['fwebsite']).'%" ';


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'e.e_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (e.e_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'e_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'e_name ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'e_displayorder ' . $sorttype;
		else
			$orderString = 'e_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(e_displayorder) FROM ' . TABLE_PREFIX . 'enemy';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

}