<?php

/**
 * core/class.relmessagetextfiledrive.php
 *
 * File contains the class used for RelMessageTextFiledrive Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelMessageTextFiledrive extends Core_Object
{

	public $mtid = 0;
	public $fdid = 0;
	public $id = 0;
	public $name = "";
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_message_text_filedrive (
					mt_id,
					fd_id,
					mtfd_name,
					mtfd_datecreated
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->mtid,
					(int)$this->fdid,
					(string)$this->name,
					$this->datecreated
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_message_text_filedrive
				SET mt_id = ?,
					fd_id = ?,
					mtfd_name = ?
				WHERE mtfd_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->mtid,
					(int)$this->fdid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_message_text_filedrive rmtf
				WHERE rmtf.mtfd_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->mtid = $row['mt_id'];
		$this->fdid = $row['fd_id'];
		$this->id = $row['mtfd_id'];
		$this->name = $row['mtfd_name'];
		$this->datecreated = $row['mtfd_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_message_text_filedrive
				WHERE mtfd_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_message_text_filedrive rmtf';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_message_text_filedrive rmtf';

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
			$myRelMessageTextFiledrive = new Core_RelMessageTextFiledrive();

			$myRelMessageTextFiledrive->mtid = $row['mt_id'];
			$myRelMessageTextFiledrive->fdid = $row['fd_id'];
			$myRelMessageTextFiledrive->id = $row['mtfd_id'];
			$myRelMessageTextFiledrive->name = $row['mtfd_name'];
			$myRelMessageTextFiledrive->datecreated = $row['mtfd_datecreated'];


            $outputList[] = $myRelMessageTextFiledrive;
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
	public static function getRelMessageTextFiledrives($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fmtid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.mt_id = '.(int)$formData['fmtid'].' ';

		if($formData['ffdid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.fd_id = '.(int)$formData['ffdid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.mtfd_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'mtfd_id ' . $sorttype;
		else
			$orderString = 'mtfd_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getExtension()
	{
		return strtoupper(Helper::fileExtension($this->name));
	}


}