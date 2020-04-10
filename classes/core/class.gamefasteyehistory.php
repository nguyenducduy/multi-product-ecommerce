<?php

/**
 * core/class.gamefasteyehistory.php
 *
 * File contains the class used for GamefasteyeHistory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_GamefasteyeHistory Class
 */
Class Core_GamefasteyeHistory extends Core_Object
{
	
	public $guid = 0;
	public $id = 0;
	public $played = 0;
	public $timeplayed = 0;
	public $point = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'gamefasteye_history (
					gu_id,
					gh_played,
					gh_timeplayed,
					gh_point,
					gh_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->guid,
					(int)$this->played,
					(int)$this->timeplayed,
					(int)$this->point,
					(int)$this->datecreated
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'gamefasteye_history
				SET gu_id = ?,
					gh_played = ?,
					gh_timeplayed = ?,
					gh_point = ?,
					gh_datemodified = ?
				WHERE gh_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->guid,
					(int)$this->played,
					(int)$this->timeplayed,
					(int)$this->point,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_history gh
				WHERE gh.gh_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->guid = (int)$row['gu_id'];
		$this->id = (int)$row['gh_id'];
		$this->played = (int)$row['gh_played'];
		$this->timeplayed = (int)$row['gh_timeplayed'];
		$this->point = (int)$row['gh_point'];
		$this->datecreated = (int)$row['gh_datecreated'];
		$this->datemodified = (int)$row['gh_datemodified'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'gamefasteye_history
				WHERE gh_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'gamefasteye_history gh';

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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_history gh';

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
			$myGamefasteyeHistory = new Core_GamefasteyeHistory();

			$myGamefasteyeHistory->guid = (int)$row['gu_id'];
			$myGamefasteyeHistory->id = (int)$row['gh_id'];
			$myGamefasteyeHistory->played = (int)$row['gh_played'];
			$myGamefasteyeHistory->timeplayed = (int)$row['gh_timeplayed'];
			$myGamefasteyeHistory->point = (int)$row['gh_point'];
			$myGamefasteyeHistory->datecreated = (int)$row['gh_datecreated'];
			$myGamefasteyeHistory->datemodified = (int)$row['gh_datemodified'];
			

            $outputList[] = $myGamefasteyeHistory;
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
	public static function getGamefasteyeHistorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gh_id = '.(int)$formData['fid'].' ';
		
		if($formData['fguid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gu_id = '.(int)$formData['fguid'].' ';

		if($formData['fplayed'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gh_played = '.(int)$formData['fplayed'].' ';

		if($formData['ftimeplayed'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gh_timeplayed = '.(int)$formData['ftimeplayed'].' ';

		if($formData['fpoint'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gh_point = '.(int)$formData['fpoint'].' ';
			
		if($formData['ftoday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gh.gh_datecreated >= '.(int)$formData['fstarttime'].' AND gh.gh_datecreated <= ' .(int)$formData['fendtime'] . ' ';


		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'gh_id ' . $sorttype; 
		elseif($sortby == 'played')
			$orderString = 'gh_played ' . $sorttype; 
		elseif($sortby == 'timeplayed')
			$orderString = 'gh_timeplayed ' . $sorttype; 
		elseif($sortby == 'point')
			$orderString = 'gh_point ' . $sorttype; 
		elseif($sortby == 'datecreated')
			$orderString = 'gh_datecreated ' . $sorttype; 
		elseif($sortby == 'datemodified')
			$orderString = 'gh_datemodified ' . $sorttype; 
		else
			$orderString = 'gh_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxPoint()
	{
		$today = time();
		if($today <= strtotime(date("Y-m-d 10:00:00"))){
    		$starttime = strtotime(date("Y-m-d 10:00:00", time() - 60 * 60 * 24));
    		$endtime = strtotime(date("Y-m-d 10:00:00"));
    	}else{
    		$starttime = strtotime(date("Y-m-d 10:00:00"));
    		$endtime = strtotime(date("Y-m-d 10:00:00", time() + 86400));
    	}
		//$lasttime = strtotime(date("Y-m-d 10:00:00", time()));
		$sql = 'SELECT MAX(gh_point)
				FROM ' . TABLE_PREFIX . 'gamefasteye_history
				WHERE gu_id = ? and gh_datecreated <= ? and gh_datecreated >= ?';

		return $this->db->query($sql, array($this->guid, $endtime, $starttime))->fetchColumn(0);
	}

	



}