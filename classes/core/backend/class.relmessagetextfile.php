<?php

/**
 * core/backend/class.relmessagetextfile.php
 *
 * File contains the class used for RelMessageTextFile Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_RelMessageTextFile extends Core_Backend_Object
{

	public $mtid = 0;
	public $fid = 0;
	public $id = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_message_text_file (
					mt_id,
					f_id
					)
		        VALUES(?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->mtid,
					(int)$this->fid
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_message_text_file
				SET mt_id = ?,
					f_id = ?
				WHERE mtf_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->mtid,
					(int)$this->fid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_message_text_file rmtf
				WHERE rmtf.mtf_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->mtid = $row['mt_id'];
		$this->fid = $row['f_id'];
		$this->id = $row['mtf_id'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_message_text_file
				WHERE mtf_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_message_text_file rmtf';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_message_text_file rmtf';

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
			$myRelMessageTextFile = new Core_Backend_RelMessageTextFile();

			$myRelMessageTextFile->mtid = $row['mt_id'];
			$myRelMessageTextFile->fid = $row['f_id'];
			$myRelMessageTextFile->id = $row['mtf_id'];


            $outputList[] = $myRelMessageTextFile;
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
	public static function getRelMessageTextFiles($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fmtid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.mt_id = '.(int)$formData['fmtid'].' ';

		if($formData['ffid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.f_id = '.(int)$formData['ffid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rmtf.mtf_id = '.(int)$formData['fid'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'mtf_id ' . $sorttype;
		else
			$orderString = 'mtf_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}