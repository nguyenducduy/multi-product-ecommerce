<?php

/**
 * core/class.giaregioithieu.php
 *
 * File contains the class used for GiareGioithieu Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_GiareGioithieu extends Core_Object
{

	public $uid = 0;
	public $id = 0;
	public $email1 = "";
	public $email2 = "";
	public $ip = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'giare_gioithieu (
					u_id,
					gg_email1,
					gg_email2,
					gg_ip,
					gg_datecreated
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->email1,
					(string)$this->email2,
					(int)$this->ip,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'giare_gioithieu
				SET u_id = ?,
					gg_email1 = ?,
					gg_email2 = ?,
					gg_ip = ?,
					gg_datecreated = ?
				WHERE gg_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->email1,
					(string)$this->email2,
					(int)$this->ip,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giare_gioithieu gg
				WHERE gg.gg_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['gg_id'];
		$this->email1 = $row['gg_email1'];
		$this->email2 = $row['gg_email2'];
		$this->ip = $row['gg_ip'];
		$this->datecreated = $row['gg_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'giare_gioithieu
				WHERE gg_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'giare_gioithieu gg';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giare_gioithieu gg';

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
			$myGiareGioithieu = new Core_GiareGioithieu();

			$myGiareGioithieu->uid = $row['u_id'];
			$myGiareGioithieu->id = $row['gg_id'];
			$myGiareGioithieu->email1 = $row['gg_email1'];
			$myGiareGioithieu->email2 = $row['gg_email2'];
			$myGiareGioithieu->ip = $row['gg_ip'];
			$myGiareGioithieu->datecreated = $row['gg_datecreated'];


            $outputList[] = $myGiareGioithieu;
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
	public static function getGiareGioithieus($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_id = '.(int)$formData['fid'].' ';

		if($formData['femail1'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_email1 = "'.Helper::unspecialtext((string)$formData['femail1']).'" ';

		if($formData['femail2'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_email2 = "'.Helper::unspecialtext((string)$formData['femail2']).'" ';

		if($formData['fip'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_ip = '.(int)$formData['fip'].' ';

		if($formData['fcheckallemail'] != '')
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(gg.gg_email1 = "'.Helper::unspecialtext((string)$formData['fcheckallemail']).'" OR '.
                                                                   'gg.gg_email2 = "'.Helper::unspecialtext((string)$formData['fcheckallemail']).'")';
        }

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'email1')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_email1 LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email2')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'gg.gg_email2 LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (gg.gg_email1 LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (gg.gg_email2 LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'gg_id ' . $sorttype;
		else
			$orderString = 'gg_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}