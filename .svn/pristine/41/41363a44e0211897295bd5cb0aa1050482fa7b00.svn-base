<?php

/**
 * core/class.parking.php
 *
 * File contains the class used for Parking Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Parking extends Core_Object
{

	public $uid = 0;
	public $id = 0;
	public $position = "";
	public $day = 0;
	public $month = 0;
	public $year = 0;

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
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'parking (
                    u_id,
                    p_position,
                    p_day,
                    p_month,
                    p_year
                    )
                VALUES(?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    p_position = ?,
                    p_id = LAST_INSERT_ID(p_id)';
        $rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->position,
					(int)date('j'),
					(int)date('n'),
					(int)date('Y'),
                    $this->position
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
		$sql = 'UPDATE ' . TABLE_PREFIX . 'parking
				SET u_id = ?,
					p_position = ?,
					p_day = ?,
					p_month = ?,
					p_year = ?
				WHERE p_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->position,
					(int)date('j'),
                    (int)date('n'),
                    (int)date('Y'),
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'parking p
				WHERE p.p_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['p_id'];
		$this->position = $row['p_position'];
		$this->day = $row['p_day'];
		$this->month = $row['p_month'];
		$this->year = $row['p_year'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'parking
				WHERE p_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'parking p';

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
		global $db, $me;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'parking p';

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
			$myParking = new Core_Parking();

			$myParking->uid = $row['u_id'];
			$myParking->id = $row['p_id'];
			$myParking->position = $row['p_position'];
			$myParking->day = $row['p_day'];
			$myParking->month = $row['p_month'];
			$myParking->year = $row['p_year'];


            $outputList[] = $myParking;
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
	public static function getParkings($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fid'].' ';

		if($formData['fday'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_day = '.(int)$formData['fday'].' ';

		if($formData['fmonth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_month = '.(int)$formData['fmonth'].' ';

		if($formData['fyear'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_year = '.(int)$formData['fyear'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'position')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_position LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.p_position LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'day')
			$orderString = 'p_day ' . $sorttype;
		elseif($sortby == 'month')
			$orderString = 'p_month ' . $sorttype;
		elseif($sortby == 'year')
			$orderString = 'p_year ' . $sorttype;
		else
			$orderString = 'p_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}