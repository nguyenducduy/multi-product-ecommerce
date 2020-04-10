<?php

/**
 * core/class.productquestion.php
 *
 * File contains the class used for Productquestion Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Productquestion extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	const TYPE_RADIO = 0;
	const TYPE_TEXT = 1;

	public $pid = 0;
	public $pgid = 0;
	public $id = 0;
	public $name = "";
	public $answer = "";
	public $correct = 0;
	public $type = 0;
	public $starttime = 0;
	public $expiretime = 0;
	public $displayorder = 0;
	public $status = 0;
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
		if($this->displayorder <= 0){
			$this->displayorder = $this->getOrder();
		}

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productquestion (
					p_id,
					pg_id,
					pq_name,
					pq_answer,
					pq_correct,
					pq_type,
					pq_starttime,
					pq_expiretime,
					pq_displayorder,
					pq_status,
					pq_datecreated,
					pq_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pgid,
					(string)$this->name,
					(string)$this->answer,
					(int)$this->correct,
					(int)$this->type,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		return $this->id;
	}

	private function getOrder()
	{
		$sql = 'SELECT MAX(pq_displayorder) FROM ' . TABLE_PREFIX . 'productquestion';
		return $this->db->query($sql)->fetchColumn(0) + 1;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'productquestion
				SET p_id = ?,
					pg_id = ?,
					pq_name = ?,
					pq_answer = ?,
					pq_correct = ?,
					pq_type = ?,
					pq_starttime = ?,
					pq_expiretime = ?,
					pq_displayorder = ?,
					pq_status = ?,
					pq_datecreated = ?,
					pq_datemodified = ?
				WHERE pq_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pgid,
					(string)$this->name,
					(string)$this->answer,
					(int)$this->correct,
					(int)$this->type,
					(int)$this->starttime,
					(int)$this->expiretime,
					(int)$this->displayorder,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productquestion p
				WHERE p.pq_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->pgid = $row['pg_id'];
		$this->id = $row['pq_id'];
		$this->name = $row['pq_name'];
		$this->answer = $row['pq_answer'];
		$this->correct = $row['pq_correct'];
		$this->type = $row['pq_type'];
		$this->starttime = $row['pq_starttime'];
		$this->expiretime = $row['pq_expiretime'];
		$this->displayorder = $row['pq_displayorder'];
		$this->status = $row['pq_status'];
		$this->datecreated = $row['pq_datecreated'];
		$this->datemodified = $row['pq_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productquestion
				WHERE pq_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productquestion p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productquestion p';

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
			$myProductquestion = new Core_Productquestion();

			$myProductquestion->pid = $row['p_id'];
			$myProductquestion->pgid = $row['pg_id'];
			$myProductquestion->id = $row['pq_id'];
			$myProductquestion->name = $row['pq_name'];
			$myProductquestion->answer = $row['pq_answer'];
			$myProductquestion->correct = $row['pq_correct'];
			$myProductquestion->type = $row['pq_type'];
			$myProductquestion->starttime = $row['pq_starttime'];
			$myProductquestion->expiretime = $row['pq_expiretime'];
			$myProductquestion->displayorder = $row['pq_displayorder'];
			$myProductquestion->status = $row['pq_status'];
			$myProductquestion->datecreated = $row['pq_datecreated'];
			$myProductquestion->datemodified = $row['pq_datemodified'];


            $outputList[] = $myProductquestion;
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
	public static function getProductquestions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pq_id = '.(int)$formData['fid'].' ';

		if($formData['fpgid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pg_id = '.(int)$formData['fpgid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pq_status = '.(int)$formData['fstatus'].' ';

		if($formData['ftime'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pq_starttime <= '.(int)$formData['ftime'].' AND p.pq_expiretime >= ' .(int)$formData['ftime']. ' '  ;

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pq_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.pq_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pq_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'pq_displayorder ' . $sorttype;
		else
			$orderString = 'pq_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disabled';

		return $output;
	}
 	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($name == 'enable' && $this->status == self::STATUS_ENABLE ||
			$name = 'disable' && $this->status == self::STATUS_DISABLE
		);

	}
	public function getstatusName()
	{
        $name = '';
        switch($this->status)
        {
            case self::STATUS_ENABLE : $name = 'enable'; break;
            case self::STATUS_DISABLE : $name = 'disable'; break;
        }

        return $name;
	}


}