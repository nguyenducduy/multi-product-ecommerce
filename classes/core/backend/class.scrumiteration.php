<?php

/**
 * core/backend/class.scrumiteration.php
 *
 * File contains the class used for ScrumIteration Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_ScrumIteration extends Core_Backend_Object
{
	public $spid = 0;
	public $stid = 0;
	public $id = 0;
	public $name = "";
	public $note = "";
	public $datestarted = 0;
	public $dateended = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_iteration (
					sp_id,
					st_id,
					si_name,
					si_note,
					si_datestarted,
					si_dateended,
					si_datecreated,
					si_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->stid,
					(string)$this->name,
					(string)$this->note,
					(int)$this->datestarted,
					(int)$this->dateended,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_iteration
				SET sp_id = ?,
					st_id = ?,
					si_name = ?,
					si_note = ?,
					si_datestarted = ?,
					si_dateended = ?,
					si_datecreated = ?,
					si_datemodified = ?
				WHERE si_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->spid,
					(int)$this->stid,
					(string)$this->name,
					(string)$this->note,
					(int)$this->datestarted,
					(int)$this->dateended,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}
   	public static function updateDataDeleteTeam($id)
	{
		$db3 = self::getDb();
		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_iteration
				SET
					st_id = "0"
				WHERE st_id = "'.$id.'"';
		$stmt = $db3->query($sql);

		if($stmt)
			return true;
		else
			return false;
	}
	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getMaxid()
	{
		$sql = 'SELECT max(si_id) FROM ' . TABLE_PREFIX . 'scrum_iteration si';
		return $this->db3->query($sql)->fetchColumn(0);
	}
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_iteration si
				WHERE si.si_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->spid = $row['sp_id'];
		$this->stid = $row['st_id'];
		$this->id = $row['si_id'];
		$this->name = $row['si_name'];
		$this->note = $row['si_note'];
		$this->datestarted = $row['si_datestarted'];
		$this->dateended = $row['si_dateended'];
		$this->datecreated = $row['si_datecreated'];
		$this->datemodified = $row['si_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_iteration
				WHERE si_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
    public static function deleteByproject($id)
    {
    	$db3 = self::getDb();
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_iteration
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_iteration si
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON si.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_iteration si
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON si.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
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
			$myScrumIteration = new Core_Backend_ScrumIteration();

			$myScrumIteration->spid = $row['sp_id'];
			$myScrumIteration->stid = $row['st_id'];
			$myScrumIteration->id = $row['si_id'];
			$myScrumIteration->name = $row['si_name'];
			$myScrumIteration->note = $row['si_note'];
			$myScrumIteration->datestarted = $row['si_datestarted'];
			$myScrumIteration->dateended = $row['si_dateended'];
			$myScrumIteration->datecreated = $row['si_datecreated'];
			$myScrumIteration->datemodified = $row['si_datemodified'];


            $outputList[] = $myScrumIteration;
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
	public static function getScrumIterations($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fspid'] > 0 && isset($formData['fspid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'si.sp_id = '.(int)$formData['fspid'].' ';
		if($formData['fstid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'si.st_id = '.(int)$formData['fstid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'si.si_id = '.(int)$formData['fid'].' ';





		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'si.si_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'note')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'si.si_note LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (si.si_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (si.si_note LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'si_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'si_name ' . $sorttype;
		elseif($sortby == 'datestarted')
			$orderString = 'si_datestarted ' . $sorttype;
		elseif($sortby == 'dateended')
			$orderString = 'si_dateended ' . $sorttype;
		else
			$orderString = 'si_id ' . $sorttype;
		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}