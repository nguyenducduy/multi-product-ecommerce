<?php

/**
 * core/backend/class.lastvisit.php
 *
 * File contains the class used for LastVisit Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_LastVisit extends Core_Backend_Object
{
	public $uid = 0;
	public $id = 0;
	public $title = "";
	public $url = "";
	public $color = 0;
	public $datelastvisited = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'last_visit (
					u_id,
					lv_title,
					lv_url,
					lv_color,
					lv_datelastvisited
					)
		        VALUES(?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    lv_title = ?,
                    lv_datelastvisited = ?';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->title,
					(string)$this->url,
					(int)$this->color,
					(int)$this->datelastvisited,
                    (string)$this->title,
                    (int)$this->datelastvisited
					))->rowCount();

		$this->id = $this->db3->lastInsertId();
		return $this->id;
	}

	/**
	 * Get the object data base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'last_visit lv
				WHERE lv.lv_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['lv_id'];
		$this->title = $row['lv_title'];
		$this->url = $row['lv_url'];
		$this->color = $row['lv_color'];
		$this->datelastvisited = $row['lv_datelastvisited'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'last_visit
				WHERE lv_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'last_visit lv';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'last_visit lv';

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
			$myLastVisit = new Core_Backend_LastVisit();

			$myLastVisit->uid = $row['u_id'];
			$myLastVisit->id = $row['lv_id'];
			$myLastVisit->title = $row['lv_title'];
			$myLastVisit->url = $row['lv_url'];
			$myLastVisit->color = $row['lv_color'];
			$myLastVisit->datelastvisited = $row['lv_datelastvisited'];


            $outputList[] = $myLastVisit;
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
	public static function getLastVisits($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lv.lv_id = '.(int)$formData['fid'].' ';

        if($formData['fuid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'lv.u_id = '.(int)$formData['fuid'].' ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lv.lv_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['furl'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lv.lv_url = "'.Helper::unspecialtext((string)$formData['furl']).'" ';

		if($formData['fdatelastvisited'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lv.lv_datelastvisited = '.(int)$formData['fdatelastvisited'].' ';


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'lv_id ' . $sorttype;
		elseif($sortby == 'datelastvisited')
			$orderString = 'lv_datelastvisited ' . $sorttype;
		else
			$orderString = 'lv_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


}