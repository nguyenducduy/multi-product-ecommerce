<?php

/**
 * core/class.scrumproject.php
 *
 * File contains the class used for ScrumProject Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ScrumProject extends Core_Object
{
	const STATUS_DELETED = 1;
	public $id = 0;
	public $name = "";
	public $status = "";

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_project (
					sp_name,
					sp_status
					)
				VALUES(?,?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(int)$this->status
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;

	}
	/*
	return pemiss
	*/
	public static function getNameStatus($status)
	{
		$name = "";
		switch ($status) {
			case '1':
				$name = "Deleted";
				break;
		}
		return $name;
	}
	public static function getStatusList()
	{
		$outputList = array();
		$outputList[STATUS_DELETED] = "Deleted";
		return $outputList;
	}
	public function updateDelete()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_project
				SET
					sp_status = "1"
				WHERE
				    sp_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}
	public static function checkPermiss()
	{
		global $registry;
		$user1 = new Core_User($registry->me->id);
		$user2 =  Core_scrumteammember::getList("u_id='".$registry->me->id."'","");


		$rs = array();

		if($user1->checkGroupname("administrator"))
		{
			$rs[]   = "admin";
		}

		if($user2[0]->id!=null)
		{
			switch ($user2[0]->role) {
			case '1':
				$rs[] = "master";
				break;

			case '3':
				$rs[] = "member";
				break;

			case '5':
				$rs[] = "owner";
				break;
			}
		}
		return $rs;

	}
	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{

		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_project
				SET sp_name = ?,
					sp_status = ?
				WHERE sp_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_project sp
				WHERE sp.sp_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();
		$this->id = $row['sp_id'];
		$this->status = $row['sp_status'];
		$this->name = $row['sp_name'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_project
				WHERE sp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_project sp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_project sp';

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
			$myScrumProject = new Core_ScrumProject();

			$myScrumProject->id = $row['sp_id'];
			$myScrumProject->name = $row['sp_name'];
			$myScrumProject->status = $row['sp_status'];


			$outputList[] = $myScrumProject;
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
	public static function getScrumProjects($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		echodebug('ok',true);
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sp_id = '.(int)$formData['fid'].' ';
		if($formData['fstatus'] >= 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sp_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sp.sp_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (sp.sp_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sp_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'sp_name ' . $sorttype;
		else
			$orderString = 'sp_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}