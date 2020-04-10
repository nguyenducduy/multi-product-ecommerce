<?php

/**
 * core/class.giftorder.php
 *
 * File contains the class used for Giftorder Model
 * 
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com) 
 */

/**
 * Core_Giftorder Class
 */
Class Core_Giftorder extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $id = 0;
	public $pricefrom = 0;
	public $priceto = 0;
	public $startdate = 0;
	public $enddate = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'giftorder (
					go_pricefrom,
					go_priceto,
					go_startdate,
					go_enddate,
					go_status,
					go_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(float)$this->pricefrom,
					(float)$this->priceto,
					(int)$this->startdate,
					(int)$this->enddate,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'giftorder
				SET go_pricefrom = ?,
					go_priceto = ?,
					go_startdate = ?,
					go_enddate = ?,
					go_status = ?,
					go_datemodified = ?
				WHERE go_id = ?';

		$stmt = $this->db->query($sql, array(
					(float)$this->pricefrom,
					(float)$this->priceto,
					(int)$this->startdate,
					(int)$this->enddate,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giftorder g
				WHERE g.go_id = ?';
		$row = $this->db->query($sql, array($id))->fetch(); 

		$this->id = (int)$row['go_id'];
		$this->pricefrom = (float)$row['go_pricefrom'];
		$this->priceto = (float)$row['go_priceto'];
		$this->startdate = (int)$row['go_startdate'];
		$this->enddate = (int)$row['go_enddate'];
		$this->status = (int)$row['go_status'];
		$this->datecreated = (int)$row['go_datecreated'];
		$this->datemodified = (int)$row['go_datemodified'];
		 
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'giftorder
				WHERE go_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'giftorder g';
        
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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'giftorder g';

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
			$myGiftorder = new Core_Giftorder();
			
			$myGiftorder->id = (int)$row['go_id'];
			$myGiftorder->pricefrom = (float)$row['go_pricefrom'];
			$myGiftorder->priceto = (float)$row['go_priceto'];
			$myGiftorder->startdate = (int)$row['go_startdate'];
			$myGiftorder->enddate = (int)$row['go_enddate'];
			$myGiftorder->status = (int)$row['go_status'];
			$myGiftorder->datecreated = (int)$row['go_datecreated'];
			$myGiftorder->datemodified = (int)$row['go_datemodified'];
			
			
            $outputList[] = $myGiftorder;			
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
	public static function getGiftorders($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';
		
		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.go_id = '.(int)$formData['fid'].' ';

		if($formData['fpricefrom'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.go_pricefrom = '.(float)$formData['fpricefrom'].' ';

		if($formData['fpriceto'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.go_priceto = '.(float)$formData['fpriceto'].' ';

		if($formData['fenddate'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'g.go_enddate = '.(int)$formData['fenddate'].' ';

		if($formData['fpricein'] >= 0){
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'g.go_pricefrom <= '.(float)$formData['fpricein'].' AND g.go_priceto >= '.(float)$formData['fpricein'].' ';
        }
		
        if(isset($formData['fisactive']) && $formData['fisactive'] == 1)
        {
            $wheredate = ($whereString != '' ? ' AND ' : '');
            $wheredate .= '(g.go_startdate <= '.(int)time().'
                           AND g.go_enddate >= '.(int)time().' AND g.go_status = '.Core_Giftorder::STATUS_ENABLE.' 
                          )';
            $whereString .= $wheredate;
        }
	
		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';
			
		
		if($sortby == 'id')
			$orderString = 'go_id ' . $sorttype; 
		elseif($sortby == 'pricefrom')
			$orderString = 'go_pricefrom ' . $sorttype; 
		elseif($sortby == 'priceto')
			$orderString = 'go_priceto ' . $sorttype; 
		elseif($sortby == 'startdate')
			$orderString = 'go_startdate ' . $sorttype; 
		elseif($sortby == 'enddate')
			$orderString = 'go_enddate ' . $sorttype; 
		elseif($sortby == 'status')
			$orderString = 'go_status ' . $sorttype; 
		else
			$orderString = 'go_id ' . $sorttype;
			
		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	
	
		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Hiển thị';
		$output[self::STATUS_DISABLE] = 'Không hiển thị';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Hiển thị'; break;
			case self::STATUS_DISABLE: $name = 'Không hiển thị'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'hiển thị')
			 || ($this->status == self::STATUS_DISABLE && $name == 'không hiển thị'))
			return true;
		else
			return false;
	}
	public function getGiftOderProduct()
	{
		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'giftorderproduct gop WHERE go_id = '.$this->id;
		return $this->db->query($sql)->fetchColumn(0);
	}
   
}