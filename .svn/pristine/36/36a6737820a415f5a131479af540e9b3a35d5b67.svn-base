<?php

/**
 * core/class.gamefasteyeshare.php
 *
 * File contains the class used for GamefasteyeShare Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_GamefasteyeShare Class
 */
Class Core_GamefasteyeShare extends Core_Object
{
	
	public $guid = 0;
	public $id = 0;
	public $countshare = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'gamefasteye_share (
					gu_id,
					gs_countshare,
					gs_datecreated
					)
		        VALUES(?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->guid,
					(int)$this->countshare,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'gamefasteye_share
				SET gu_id = ?,
					gs_countshare = ?,
					gs_datemodified = ?
				WHERE gs_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->guid,
					(int)$this->countshare,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_share gs
				WHERE gs.gs_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->guid = (int)$row['gu_id'];
		$this->id = (int)$row['gs_id'];
		$this->countshare = (int)$row['gs_countshare'];
		$this->datecreated = (int)$row['gs_datecreated'];
		$this->datemodified = (int)$row['gs_datemodified'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'gamefasteye_share
				WHERE gs_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'gamefasteye_share gs';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_share gs';

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
			$myGamefasteyeShare = new Core_GamefasteyeShare();

			$myGamefasteyeShare->guid = (int)$row['gu_id'];
			$myGamefasteyeShare->id = (int)$row['gs_id'];
			$myGamefasteyeShare->countshare = (int)$row['gs_countshare'];
			$myGamefasteyeShare->datecreated = (int)$row['gs_datecreated'];
			$myGamefasteyeShare->datemodified = (int)$row['gs_datemodified'];
			

            $outputList[] = $myGamefasteyeShare;
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
	public static function getGamefasteyeShares($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fguid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gu_id = '.(int)$formData['fguid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gs_id = '.(int)$formData['fid'].' ';

		if($formData['fcountshare'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gs_countshare = '.(int)$formData['fcountshare'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gs_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gs_datemodified = '.(int)$formData['fdatemodified'].' ';

		if($formData['ftoday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gs.gs_datecreated >= '.(int)$formData['fstarttime'].' AND gs.gs_datecreated <= ' .(int)$formData['fendtime'] . ' ';
		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'guid')
			$orderString = 'gu_id ' . $sorttype; 
		elseif($sortby == 'id')
			$orderString = 'gs_id ' . $sorttype; 
		elseif($sortby == 'countshare')
			$orderString = 'gs_countshare ' . $sorttype; 
		elseif($sortby == 'datecreated')
			$orderString = 'gs_datecreated ' . $sorttype; 
		elseif($sortby == 'datemodified')
			$orderString = 'gs_datemodified ' . $sorttype; 
		else
			$orderString = 'gs_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

	



}