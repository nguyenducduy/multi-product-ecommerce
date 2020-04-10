<?php

/**
 * core/backend/class.scrumteammember.php
 *
 * File contains the class used for ScrumTeamMember Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_ScrumTeamMember extends Core_Backend_Object
{

	const Role_master = 1;
	const Role_member = 3;
	const Role_productowner = 5;

	public $spid = 0;
	public $stid = 0;
	public $uid = 0;
	public $id = 0;
	public $role = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_team_member (
					sp_id,
					st_id,
					u_id,
					stm_role,
					stm_datecreated
					)
				VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->stid,
					(int)$this->uid,
					(int)$this->role,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_team_member
				SET sp_id = ?,
					st_id = ?,
					u_id = ?,
					stm_role = ?,
					stm_datecreated = ?
				WHERE stm_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->stid,
					(int)$this->uid,
					(int)$this->role,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_team_member stm
				WHERE stm.stm_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->spid = $row['sp_id'];
		$this->stid = $row['st_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['stm_id'];
		$this->role = $row['stm_role'];
		$this->datecreated = $row['stm_datecreated'];

	}
	public static function getListRole()
	{
		$output[self::Role_master]       = "Web master";
		$output[self::Role_member]       = "Member";
		$output[self::Role_productowner] = "Product Owner";
		return $output;
	}
	public static function getNameRole($id)
	{
		$name = "";
		switch ($id) {
			case '1':
				$name =  "Web master";
				break;
			case '3':
				$name ="Member";
				break;
			case '5':
				$name =  "Product Owner";
				break;


		}
		return $name;
	}
	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */

	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_team_member
				WHERE stm_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
	public static function deleteByproject($id)
    {
    	$db3 = self::getDb();
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_team_member
				WHERE sp_id = ?';
		$rowCount = $db3->query($sql, array($id))->rowCount();

		return $rowCount;
    }
    public static function deleteByteam($id)
    {
    	$db3 = self::getDb();
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_team_member
				WHERE st_id = ?';
		$rowCount = $db3->query($sql, array($id))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_team_member stm
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON stm.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_team_member stm
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON stm.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;
		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;
		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myScrumTeamMember = new Core_Backend_ScrumTeamMember();

			$myScrumTeamMember->spid = $row['sp_id'];
			$myScrumTeamMember->stid = $row['st_id'];
			$myScrumTeamMember->uid = $row['u_id'];
			$myScrumTeamMember->id = $row['stm_id'];
			$myScrumTeamMember->role = $row['stm_role'];
			$myScrumTeamMember->datecreated = $row['stm_datecreated'];


			$outputList[] = $myScrumTeamMember;
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
	public static function getScrumTeamMembers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fspid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stm.sp_id = '.(int)$formData['fspid'].' ';

		if($formData['fstid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stm.st_id = '.(int)$formData['fstid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stm.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stm.stm_id = '.(int)$formData['fid'].' ';
		if($formData['frole'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'stm.stm_role = '.(int)$formData['frole'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'stid')
			$orderString = 'st_id ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'stm_id ' . $sorttype;
		else
			$orderString = 'stm_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}