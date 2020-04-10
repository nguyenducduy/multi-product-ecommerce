<?php

/**
 * core/backend/class.scrumteam.php
 *
 * File contains the class used for ScrumTeam Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_ScrumTeam extends Core_Backend_Object
{

	public $spid = 0;
	public $id = 0;
	public $name = "";

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_team (
					sp_id,
					st_name
					)
		        VALUES(?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->spid,
					(string)$this->name
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_team
				SET sp_id = ?,
					st_name = ?
				WHERE st_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->spid,
					(string)$this->name,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_team st
				WHERE st.st_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->spid = $row['sp_id'];
		$this->id = $row['st_id'];
		$this->name = $row['st_name'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_team
				WHERE st_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
    public static function deleteByproject($id)
    {
    	$db3 = self::getDb();
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_team
				WHERE sp_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_team st
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON st.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_team st
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON st.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
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
			$myScrumTeam = new Core_Backend_ScrumTeam();

			$myScrumTeam->spid = $row['sp_id'];
			$myScrumTeam->id = $row['st_id'];
			$myScrumTeam->name = $row['st_name'];


            $outputList[] = $myScrumTeam;
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
	public static function getScrumTeams($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fspid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'st.sp_id = '.(int)$formData['fspid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'st.st_id = '.(int)$formData['fid'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'st.st_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (st.st_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'spid')
			$orderString = 'sp_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'st_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'st_name ' . $sorttype;
		else
			$orderString = 'st_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}