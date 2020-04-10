<?php

/**
 * core/class.scrummeeting.php
 *
 * File contains the class used for ScrumMeeting Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ScrumMeeting extends Core_Object
{
	const STATUS_DAILY = 1;
	const STATUS_PLANNING = 3;
	const STATUS_REVIEW = 5;
	const STATUS_RETROSPECTIVE  = 7;

	public $uid = 0;
	public $siid = 0;
	public $id = 0;
	public $type = 0;
	public $summary = "";
	public $note = "";
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}
    public static function getListStatus()
	{
		$output[self::STATUS_DAILY]         = "Daily";
		$output[self::STATUS_PLANNING]      = "Planning";
		$output[self::STATUS_REVIEW]        = "Review";
		$output[self::STATUS_RETROSPECTIVE] = "Retrospective";
		return $output;
	}
	public static function getNameStatus($id)
	{
		$name = "";
		switch ($id) {
			case '1':
				$name =  "Daily";
				break;
			case '3':
				$name ="Planning";
				break;
			case '5':
				$name =  "Review";
				break;
			case '7':
				$name =  "Retrospective";
				break;


		}
		return $name;
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'scrum_meeting (
					u_id,
					si_id,
					sm_type,
					sm_summary,
					sm_note,
					sm_datecreated,
					sm_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->siid,
					(int)$this->type,
					(string)$this->summary,
					(string)$this->note,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_meeting
				SET u_id = ?,
					si_id = ?,
					sm_type = ?,
					sm_summary = ?,
					sm_note = ?,
					sm_datecreated = ?,
					sm_datemodified = ?
				WHERE sm_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->siid,
					(int)$this->type,
					(string)$this->summary,
					(string)$this->note,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
			return true;
		else
			return false;
	}
	public static function updateDataDeleteIteration($id)
	{
		global $db;
		$sql = 'UPDATE ' . TABLE_PREFIX . 'scrum_meeting
				SET
					si_id = "0"
				WHERE si_id = "'.$id.'"';
		$stmt = $db->query($sql);

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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_meeting sm
				WHERE sm.sm_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->siid = $row['si_id'];
		$this->id = $row['sm_id'];
		$this->type = $row['sm_type'];
		$this->summary = $row['sm_summary'];
		$this->note = $row['sm_note'];
		$this->datecreated = $row['sm_datecreated'];
		$this->datemodified = $row['sm_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'scrum_meeting
				WHERE sm_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'scrum_meeting sm';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'scrum_meeting sm';

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
			$myScrumMeeting = new Core_ScrumMeeting();

			$myScrumMeeting->uid = $row['u_id'];
			$myScrumMeeting->siid = $row['si_id'];
			$myScrumMeeting->id = $row['sm_id'];
			$myScrumMeeting->type = $row['sm_type'];
			$myScrumMeeting->summary = $row['sm_summary'];
			$myScrumMeeting->note = $row['sm_note'];
			$myScrumMeeting->datecreated = $row['sm_datecreated'];
			$myScrumMeeting->datemodified = $row['sm_datemodified'];


            $outputList[] = $myScrumMeeting;
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
	public static function getScrumMeetings($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fsiid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.si_id = '.(int)$formData['fsiid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_type = '.(int)$formData['ftype'].' ';

		if($formData['fsummary'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_summary = "'.Helper::unspecialtext((string)$formData['fsummary']).'" ';

		if($formData['fnote'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_note = "'.Helper::unspecialtext((string)$formData['fnote']).'" ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_datemodified = '.(int)$formData['fdatemodified'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'note')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'sm.sm_note LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (sm.sm_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (sm.sm_note LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'siid')
			$orderString = 'si_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'sm_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'sm_type ' . $sorttype;
		elseif($sortby == 'summary')
			$orderString = 'sm_summary ' . $sorttype;
		elseif($sortby == 'note')
			$orderString = 'sm_note ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'sm_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'sm_datemodified ' . $sorttype;
		else
			$orderString = 'sm_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}