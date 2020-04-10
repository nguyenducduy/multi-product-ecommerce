<?php

/**
 * core/class.scrumstorycategory.php
 *
 * File contains the class used for ScrumStoryCategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ScrumStoryCategory extends Core_Object
{

	public $spid = 0;
	public $id = 0;
	public $name = "";
	public $datecreated = 0;
	public $datemodified = 0;
    //public $story = 0;
    public $project = '';

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_story_category (
					sp_id,
					ssc_name,
					ssc_datecreated,
					ssc_datemodified
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->spid,
					(string)$this->name,
					(int)$this->datecreated,
					(int)$this->datemodified
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_story_category
				SET sp_id = ?,
					ssc_name = ?,
					ssc_datecreated = ?,
					ssc_datemodified = ?
				WHERE ssc_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->spid,
					(string)$this->name,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_category ssc
				WHERE ssc.ssc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->spid = $row['sp_id'];
		$this->id = $row['ssc_id'];
		$this->name = $row['ssc_name'];
		$this->datecreated = $row['ssc_datecreated'];
		$this->datemodified = $row['ssc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_category
				WHERE ssc_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}
    public static function deleteByproject($id)
    {
    	global $db;
    	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_story_category
				WHERE sp_id = ?';
		$rowCount = $db->query($sql, array($id))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_story_category ssc
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON ssc.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_story_category ssc
		INNER JOIN ' . TABLE_PREFIX . 'scrum_project ON ssc.sp_id = ' . TABLE_PREFIX . 'scrum_project.sp_id
		WHERE '.TABLE_PREFIX.'scrum_project.sp_status <> 1
		';

		if($where != '')
			$sql .=  " AND ".$where;


		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myScrumStoryCategory = new Core_ScrumStoryCategory();

			$myScrumStoryCategory->spid = $row['sp_id'];
			$myScrumStoryCategory->id = $row['ssc_id'];
			$myScrumStoryCategory->name = $row['ssc_name'];
			$myScrumStoryCategory->datecreated = $row['ssc_datecreated'];
			$myScrumStoryCategory->datemodified = $row['ssc_datemodified'];


            $outputList[] = $myScrumStoryCategory;
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
	public static function getScrumStoryCategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ssc.ssc_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ssc_id ' . $sorttype;
		else
			$orderString = 'ssc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getScrumStoryCategoryProject(){
        global $db;
        $sql = 'SELECT
                ssc.ssc_id,
                ssc.sp_id,
                sp.sp_name,
                ssc.ssc_name
                FROM ' . TABLE_PREFIX . 'scrum_project sp
                INNER JOIN ' . TABLE_PREFIX . 'scrum_story_category ssc ON sp.sp_id = ssc.sp_id
               	WHERE sp.sp_status <> 1
               ';
        $sscp = $db->query($sql);
        $outputList = array();
        while($row = $sscp->fetch())
        {
            $myScrumStoryCategory = new Core_ScrumStoryCategory();
            $myScrumStoryCategory->spid = $row['sp_id'];
            $myScrumStoryCategory->id = $row['ssc_id'];
            $myScrumStoryCategory->name = $row['ssc_name'];
            $myScrumStoryCategory->project = $row['sp_name'];
            //$myScrumStoryCategory->story = 0;//$countScrumStory;

            $outputList[] = $myScrumStoryCategory;
        }
        return $outputList;
    }
}