<?php

/**
 * core/class.campaignuser.php
 *
 * File contains the class used for CampaignUser Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_CampaignUser extends Core_Object
{

	const USERLUCKY = 1;
	public $sid = 0;
	public $id = 0;
	public $position = 0;
	public $type = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'campaign_user (
					s_id,
					cu_position,
					cu_type
					)
		        VALUES(?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
		(int)$this->sid,
		(int)$this->position,
		(int)$this->type
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'campaign_user
				SET s_id = ?,
					cu_position = ?,
					cu_type = ?
				WHERE cu_id = ?';

		$stmt = $this->db->query($sql, array(
		(int)$this->sid,
		(int)$this->position,
		(int)$this->type,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_user cu
				WHERE cu.cu_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->sid = $row['s_id'];
		$this->id = $row['cu_id'];
		$this->position = $row['cu_position'];
		$this->type = $row['cu_type'];

	}

	/**
	 * Get the object data base on key
	 * @param int $s_id : the primary key value for searching record.
	 */
	public static function getCampaignUserLucky($s_id)
	{
		global $db;
		$s_id = (int)$s_id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_user cu
				WHERE cu.s_id = ? and cu_position = ?';
		$row = $db->query($sql, array($s_id, Core_CampaignUser::USERLUCKY))->fetch();

		$myCampaignUser = new Core_CampaignUser();

		$myCampaignUser->sid = $row['s_id'];
		$myCampaignUser->id = $row['cu_id'];
		$myCampaignUser->position = $row['cu_position'];
		$myCampaignUser->type = $row['cu_type'];

		return $myCampaignUser;

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'campaign_user
				WHERE cu_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'campaign_user cu';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_user cu';

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
			$myCampaignUser = new Core_CampaignUser();

			$myCampaignUser->sid = $row['s_id'];
			$myCampaignUser->id = $row['cu_id'];
			$myCampaignUser->position = $row['cu_position'];
			$myCampaignUser->type = $row['cu_type'];


			$outputList[] = $myCampaignUser;
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
	public static function getCampaignUsers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fsid'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'cu.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'cu.cu_id = '.(int)$formData['fid'].' ';

		if($formData['fposition'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'cu.cu_position = '.(int)$formData['fposition'].' ';

		if($formData['ftype'] > 0)
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'cu.cu_type = '.(int)$formData['ftype'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
		$sorttype = 'DESC';


		if($sortby == 'id')
		$orderString = 'cu_id ' . $sorttype;
		else
		$orderString = 'cu_id ' . $sorttype;

		if($countOnly)
		return self::countList($whereString);
		else
		return self::getList($whereString, $orderString, $limit);
	}


	public static function getMaxPosition($type){
		global $db;
		$type = (int)$type;
		$sql = 'SELECT MAX( cu_position ) FROM ' . TABLE_PREFIX . 'campaign_user cu
				WHERE cu.cu_type = ?';
		return ($db->query($sql, array($type))->fetchColumn(0) + 1);
	}


	public static function getlistuserbylantern($lanter){
		global $db;
		$lanter = (int)$lanter;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'campaign_user cu
				WHERE cu_type = ? ORDER BY cu_position ASC';

		$stmt = $db->query($sql, array($lanter));
		while($row = $stmt->fetch())
		{
			$myCampaignUser = new Core_CampaignUser();

			$myCampaignUser->sid = $row['s_id'];
			$myCampaignUser->id = $row['cu_id'];
			$myCampaignUser->position = $row['cu_position'];
			$myCampaignUser->type = $row['cu_type'];


			$outputList[] = $myCampaignUser;
		}

		return $outputList;
    }


}