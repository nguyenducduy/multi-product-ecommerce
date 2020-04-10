<?php

/**
 * core/backend/class.filesharing.php
 *
 * File contains the class used for FileSharing Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_FileSharing extends Core_Backend_Object
{
	const TYPE_NORMAL = 1;
	const TYPE_MESSAGEATTACH = 3;
	const TYPE_FEEDATTACH = 5;

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 3;

	public $uid = 0;
	public $uidreceive = 0;
	public $fid = 0;
	public $id = 0;
	public $status = 0;
	public $type = 0;
	public $objectid = 0;
	public $datecreated = 0;
	public $datebegin = 0;
	public $datend = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'file_sharing (
					u_id,
					u_id_receive,
					f_id,
					fs_status,
					fs_type,
					fs_objectid,
					fs_datecreated,
					fs_datebegin,
					fs_datend
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->uidreceive,
					(int)$this->fid,
					(int)$this->status,
					(int)$this->type,
					(int)$this->objectid,
					(int)$this->datecreated,
					(int)$this->datebegin,
					(int)$this->datend
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'file_sharing
				SET u_id = ?,
					u_id_receive = ?,
					f_id = ?,
					fs_status = ?,
					fs_type = ?,
					fs_objectid = ?,
					fs_datecreated = ?,
					fs_datebegin = ?,
					fs_datend = ?
				WHERE fs_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->uidreceive,
					(int)$this->fid,
					(int)$this->status,
					(int)$this->type,
					(int)$this->objectid,
					(int)$this->datecreated,
					(int)$this->datebegin,
					(int)$this->datend,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file_sharing fs
				WHERE fs.fs_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->uidreceive = $row['u_id_receive'];
		$this->fid = $row['f_id'];
		$this->id = $row['fs_id'];
		$this->status = $row['fs_status'];
		$this->type = $row['fs_type'];
		$this->objectid = $row['fs_objectid'];
		$this->datecreated = $row['fs_datecreated'];
		$this->datebegin = $row['fs_datebegin'];
		$this->datend = $row['fs_datend'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'file_sharing
				WHERE fs_id = ?';
		$rowCount = $this->db3->query($sql, array($this->id))->rowCount();

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'file_sharing fs';

		if($where != '')
			$sql .= ' WHERE ' . $where;

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'file_sharing fs';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db3->query($sql);
		while($row = $stmt->fetch())
		{
			$myFileSharing = new Core_Backend_FileSharing();

			$myFileSharing->uid = $row['u_id'];
			$myFileSharing->uidreceive = $row['u_id_receive'];
			$myFileSharing->fid = $row['f_id'];
			$myFileSharing->id = $row['fs_id'];
			$myFileSharing->status = $row['fs_status'];
			$myFileSharing->type = $row['fs_type'];
			$myFileSharing->objectid = $row['fs_objectid'];
			$myFileSharing->datecreated = $row['fs_datecreated'];
			$myFileSharing->datebegin = $row['fs_datebegin'];
			$myFileSharing->datend = $row['fs_datend'];


            $outputList[] = $myFileSharing;
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
	public static function getFileSharings($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fuidreceive'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.u_id_receive = '.(int)$formData['fuidreceive'].' ';

		if($formData['ffid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.f_id = '.(int)$formData['ffid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.fs_id = '.(int)$formData['fid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.fs_status = '.(int)$formData['fstatus'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.fs_type = '.(int)$formData['ftype'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'fs.fs_objectid = '.(int)$formData['fobjectid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'fs_id ' . $sorttype;
		else
			$orderString = 'fs_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	 * Check if an user can download a file from file sharing setted by sender
	 */
	public static function canDownload($userid, $fileid)
	{
		$db3 = self::getDb();

		return self::getFileSharings(array('fuidreceive' => $userid, 'ffid' => $fileid, 'fstatus' => self::STATUS_ENABLE), '', '', 1, true) > 0;

	}


}