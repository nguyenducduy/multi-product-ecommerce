<?php

/**
 * core/class.gamefasteyequestion.php
 *
 * File contains the class used for GamefasteyeQuestion Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_GamefasteyeQuestion Class
 */
Class Core_GamefasteyeQuestion extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $gfeid = 0;
	public $id = 0;
	public $name = '';
	public $image = '';
	public $answer = '';
	public $correct = 0;
	public $point = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'gamefasteye_question (
					gfe_id,
					gq_name,
					gq_image,
					gq_answer,
					gq_correct,
					gq_point,
					gq_displayorder,
					gq_status,
					gq_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->gfeid,
					(string)$this->name,
					(string)$this->image,
					(string)$this->answer,
					(int)$this->correct,
					(int)$this->point,
					(int)$this->getMaxDisplayOrder(),
					(int)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'gamefasteye_question
				SET gfe_id = ?,
					gq_name = ?,
					gq_image = ?,
					gq_answer = ?,
					gq_correct = ?,
					gq_point = ?,
					gq_displayorder = ?,
					gq_status = ?,
					gq_datemodified = ?
				WHERE gq_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->gfeid,
					(string)$this->name,
					(string)$this->image,
					(string)$this->answer,
					(int)$this->correct,
					(int)$this->point,
					(int)$this->displayorder,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_question gq
				WHERE gq.gq_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->gfeid = (int)$row['gfe_id'];
		$this->id = (int)$row['gq_id'];
		$this->name = (string)$row['gq_name'];
		$this->image = (string)$row['gq_image'];
		$this->answer = (string)$row['gq_answer'];
		$this->correct = (int)$row['gq_correct'];
		$this->point = (int)$row['gq_point'];
		$this->displayorder = (int)$row['gq_displayorder'];
		$this->status = (int)$row['gq_status'];
		$this->datecreated = (int)$row['gq_datecreated'];
		$this->datemodified = (int)$row['gq_datemodified'];
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'gamefasteye_question
				WHERE gq_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'gamefasteye_question gq';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		return $db->query($sql)->fetchColumn(0);
	}
	
 	/**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function totalPointQuestion()
	{
		$db = self::getDb();

		$sql = 'SELECT SUM(gq_point) FROM ' . TABLE_PREFIX . 'gamefasteye_question gq';

		$sql .= ' WHERE gq_status = ' . self::STATUS_ENABLE;
		
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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'gamefasteye_question gq';

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
			$myGamefasteyeQuestion = new Core_GamefasteyeQuestion();

			$myGamefasteyeQuestion->gfeid = (int)$row['gfe_id'];
			$myGamefasteyeQuestion->id = (int)$row['gq_id'];
			$myGamefasteyeQuestion->name = (string)$row['gq_name'];
			$myGamefasteyeQuestion->image = (string)$row['gq_image'];
			$myGamefasteyeQuestion->answer = (string)$row['gq_answer'];
			$myGamefasteyeQuestion->correct = (int)$row['gq_correct'];
			$myGamefasteyeQuestion->point = (int)$row['gq_point'];
			$myGamefasteyeQuestion->displayorder = (int)$row['gq_displayorder'];
			$myGamefasteyeQuestion->status = (int)$row['gq_status'];
			$myGamefasteyeQuestion->datecreated = (int)$row['gq_datecreated'];
			$myGamefasteyeQuestion->datemodified = (int)$row['gq_datemodified'];
			

            $outputList[] = $myGamefasteyeQuestion;
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
	public static function getGamefasteyeQuestions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fgfeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gfe_id = '.(int)$formData['fgfeid'].' ';
		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gq_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gq_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fpoint'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gq_point = '.(int)$formData['fpoint'].' ';
			
		if($formData['fcorrect'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gq_correct = '.(int)$formData['fcorrect'].' ';


		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'gq.gq_status = '.(int)$formData['fstatus'].' ';
		

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'gq_id ' . $sorttype; 
		elseif($sortby == 'point')
			$orderString = 'gq_point ' . $sorttype; 
		elseif($sortby == 'displayorder')
			$orderString = 'gq_displayorder ' . $sorttype; 
		else
			$orderString = 'gq_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	
	private function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(gq_displayorder)
				FROM ' . TABLE_PREFIX . 'gamefasteye_question
				WHERE gfe_id = ?';

		return ($this->db->query($sql, array($this->gfeid))->fetchColumn(0) + 1);
	}

		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disable';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLE: $name = 'Disable'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
			 || ($this->status == self::STATUS_DISABLE && $name == 'disable'))
			return true;
		else
			return false;
	}



}