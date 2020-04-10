<?php

/**
 * core/class.useredge.php
 *
 * File contains the class used for UserEdge Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_UserEdge extends Core_Object
{
	const TYPE_FOLLOW = 1;	//User Follow User, $point is Not Used.
	const TYPE_JOIN = 2;	//User Join a custom group, $point is New Notification
	const TYPE_EMPLOY = 3;	//User belongs to Department, $point is Human Resource Job Title

	public $uidstart = 0;
	public $uidend = 0;
	public $id = 0;
	public $type = 0;
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


		$sql = 'INSERT IGNORE INTO ' . TABLE_PREFIX . 'user_edge (
					u_id_start,
					u_id_end,
					ue_type,
					ue_point,
					ue_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uidstart,
					(int)$this->uidend,
					(int)$this->type,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'user_edge
				SET u_id_start = ?,
					u_id_end = ?,
					ue_type = ?,
					ue_point = ?,
					ue_datemodified = ?
				WHERE ue_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uidstart,
					(int)$this->uidend,
					(int)$this->type,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'user_edge ue
				WHERE ue.ue_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uidstart = $row['u_id_start'];
		$this->uidend = $row['u_id_end'];
		$this->id = $row['ue_id'];
		$this->type = $row['ue_type'];
		$this->point = $row['ue_point'];
		$this->datecreated = $row['ue_datecreated'];
		$this->datemodified = $row['ue_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'user_edge
				WHERE ue_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'user_edge ue';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'user_edge ue';

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
			$myUserEdge = new Core_UserEdge();

			$myUserEdge->uidstart = $row['u_id_start'];
			$myUserEdge->uidend = $row['u_id_end'];
			$myUserEdge->id = $row['ue_id'];
			$myUserEdge->type = $row['ue_type'];
			$myUserEdge->point = $row['ue_point'];
			$myUserEdge->datecreated = $row['ue_datecreated'];
			$myUserEdge->datemodified = $row['ue_datemodified'];


            $outputList[] = $myUserEdge;
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
	public static function getUserEdges($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuidstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.u_id_start = '.(int)$formData['fuidstart'].' ';

		if($formData['fuidend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.u_id_end = '.(int)$formData['fuidend'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.ue_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.ue_type = '.(int)$formData['ftype'].' ';

		if(count($formData['ftypelist']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.ue_type IN ( '. implode(', ', $formData['ftypelist']) .' ) ';

		if($formData['fpoint'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ue.ue_point = '.(int)$formData['fpoint'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ue_id ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ue_datemodified ' . $sorttype;
		elseif($sortby == 'point')
			$orderString = 'ue_point ' . $sorttype . ', ue_id ASC';
		else
			$orderString = 'ue_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function isFollowing($uidstart, $uidend)
	{
		return self::getUserEdges(array('fuidstart' => $uidstart, 'fuidend' => $uidend, 'ftype' => self::TYPE_FOLLOW), '', '', '', true) > 0;
	}

	public static function isJoining($uidstart, $uidend)
	{
		return self::getUserEdges(array('fuidstart' => $uidstart, 'fuidend' => $uidend, 'ftype' => self::TYPE_JOIN), '', '', '', true) > 0;
	}

	public static function removeFollowing($uidstart, $uidend)
	{
		global $db;

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'user_edge
				WHERE u_id_start = ?
					AND u_id_end = ?
					AND ue_type = ?';

		return $db->query($sql, array(
			(int)$uidstart,
			(int)$uidend,
			(int)self::TYPE_FOLLOW,
		))->rowCount();
	}

	public static function removeJoining($uidstart, $uidend)
	{
		global $db;

		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'user_edge
				WHERE u_id_start = ?
					AND u_id_end = ?
					AND ue_type = ?';

		return $db->query($sql, array(
			(int)$uidstart,
			(int)$uidend,
			(int)self::TYPE_JOIN,
		))->rowCount();

	}






}