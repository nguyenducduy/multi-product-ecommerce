<?php

/**
 * core/class.scrumstoryasignee.php
 *
 * File contains the class used for ScrumStoryAsignee Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ScrumStoryAsignee extends Core_Object
{

	public $ssid = 0;
	public $uid = 0;
	public $id = 0;
	public $type = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_story_asignee (
					ss_id,
					u_id,
					sa_type,
					sa_datecreated
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->ssid,
					(int)$this->uid,
					(int)$this->type,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story_asignee
				SET ss_id = ?,
					u_id = ?,
					sa_type = ?,
					sa_datecreated = ?
				WHERE sa_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->ssid,
					(int)$this->uid,
					(int)$this->type,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_asignee ssa
				WHERE ssa.sa_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->ssid = $row['ss_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['sa_id'];
		$this->type = $row['sa_type'];
		$this->datecreated = $row['sa_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_asignee
				WHERE sa_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
	public static function deleteByStoryDelete($id)
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_asignee
				WHERE sa_id = ?';
		$rowCount = $this->db->query($sql, array($id))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_story_asignee ssa';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_asignee ssa';

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
			$myScrumStoryAsignee = new Core_ScrumStoryAsignee();

			$myScrumStoryAsignee->ssid = $row['ss_id'];
			$myScrumStoryAsignee->uid = $row['u_id'];
			$myScrumStoryAsignee->id = $row['sa_id'];
			$myScrumStoryAsignee->type = $row['sa_type'];
			$myScrumStoryAsignee->datecreated = $row['sa_datecreated'];


            $outputList[] = $myScrumStoryAsignee;
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
	public static function getScrumStoryAsignees($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fssid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssa.ss_id = '.(int)$formData['fssid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssa.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssa.sa_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssa.sa_type = '.(int)$formData['ftype'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sa_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'sa_type ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'sa_datecreated ' . $sorttype;
		else
			$orderString = 'sa_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    //Return list the name of Assignee filtered by ss_id
    public static function getAssigneeUserList($ss_id){
        global $db;
        $sql = 'SELECT u.u_fullname
                FROM ' . TABLE_PREFIX . 'ac_user AS u
                INNER JOIN ' . TABLE_PREFIX . 'scrum_story_asignee AS sa ON u.u_id = sa.u_id';//, sa . *

        if(!empty($ss_id)) $sql .= ' WHERE sa.ss_id='.(int)$ss_id;
        $outputList = array();
        $stmt = $db->query($sql);
        while($row = $stmt->fetch())
        {
            /*$myScrumStoryAsignee = new Core_ScrumStoryAsignee();

            $myScrumStoryAsignee->ssid = $row['ss_id'];
            $myScrumStoryAsignee->uid = $row['u_id'];
            $myScrumStoryAsignee->id = $row['sa_id'];
            $myScrumStoryAsignee->type = $row['sa_type'];
            $myScrumStoryAsignee->datecreated = $row['sa_datecreated'];

            $myScrumStoryAsignee->fullname = $row['u_fullname'];*/
            $outputList[] = $row['u_fullname'];
        }

        return $outputList;
    }


}