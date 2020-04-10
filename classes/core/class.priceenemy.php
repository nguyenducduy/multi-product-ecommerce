<?php

/**
 * core/class.priceenemy.php
 *
 * File contains the class used for PriceEnemy Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_PriceEnemy extends Core_Object
{

	const STATUS_NOTSYNC = 5;
	const STATUS_SYNCED = 10;
	const STATUS_SYNCERROR = 15;
	const TYPE_ONLINE = 1;
	const TYPE_OFFLINE = 2;

	public $pcid = 0;
	public $pid = 0;
	public $uid = 0;
	public $eid = 0;
	public $rid = 0;
	public $id = 0;
	public $productname = "";
	public $url = "";
	public $image = "";
	public $description = "";
	public $name = "";
	public $price = 0;
	public $pricepromotion = 0;
	public $priceauto = 0;
	public $promotioninfo = "";
	public $note = "";
	public $type = 0;
	public $displayorder = 0;
	public $status = 0;
	public $datecreated = 0;
	public $dateupdated = 0;
	public $datesynced = 0;
	public $enemyactor = null;

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
		$this->displayorder =  $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'price_enemy (
					pc_id,
					p_id,
					u_id,
					e_id,
					r_id,
					pe_productname,
					pe_url,
					pe_image,
					pe_description,
					pe_name,
					pe_price,
					pe_pricepromotion,
					pe_priceauto,
					pe_promotioninfo,
					pe_note,
					pe_type,
					pe_displayorder,
					pe_status,
					pe_datecreated,
					pe_dateupdated,
					pe_datesynced
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pcid,
					(int)$this->pid,
					(int)$this->uid,
					(int)$this->eid,
					(int)$this->rid,
					(string)$this->productname,
					(string)$this->url,
					(string)$this->image,
					(string)$this->description,
					(string)$this->name,
					(float)$this->price,
					(float)$this->pricepromotion,
					(float)$this->priceauto,
					(string)$this->promotioninfo,
					(string)$this->note,
					(int)$this->type,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->dateupdated,
					(int)$this->datesynced
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

		$this->dateupdated = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'price_enemy
				SET pc_id = ?,
					p_id = ?,
					u_id = ?,
					e_id = ?,
					r_id = ?,
					pe_productname= ? ,
					pe_url = ?,
					pe_image = ?,
					pe_description = ?,
					pe_name = ?,
					pe_price = ?,
					pe_pricepromotion = ?,
					pe_priceauto = ?,
					pe_promotioninfo = ?,
					pe_note = ?,
					pe_type = ?,
					pe_displayorder = ?,
					pe_status = ?,
					pe_datecreated = ?,
					pe_dateupdated = ?,
					pe_datesynced = ?
				WHERE pe_id = ?';
		$stmt = $this->db->query($sql, array(
					(int)$this->pcid,
					(int)$this->pid,
					(int)$this->uid,
					(int)$this->eid,
					(int)$this->rid,
					(string)$this->productname,
					(string)$this->url,
					(string)$this->image,
					(string)$this->description,
					(string)$this->name,
					(float)$this->price,
					(float)$this->pricepromotion,
					(float)$this->priceauto,
					(string)$this->promotioninfo,
					(string)$this->note,
					(int)$this->type,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->dateupdated,
					(int)$this->datesynced,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'price_enemy pe
				WHERE pe.pe_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pcid = $row['pc_id'];
		$this->pid = $row['p_id'];
		$this->uid = $row['u_id'];
		$this->eid = $row['e_id'];
		$this->rid = $row['r_id'];
		$this->id = $row['pe_id'];
		$this->productname = $row['pe_productname'];
		$this->url = $row['pe_url'];
		$this->image = $row['pe_image'];
		$this->description = $row['pe_description'];
		$this->name = $row['pe_name'];
		$this->price = $row['pe_price'];
		$this->pricepromotion = $row['pe_pricepromotion'];
		$this->priceauto = $row['pe_priceauto'];
		$this->promotioninfo = $row['pe_promotioninfo'];
		$this->type = $row['pe_type'];
		$this->note = $row['pe_note'];
		$this->displayorder = $row['pe_displayorder'];
		$this->status = $row['pe_status'];
		$this->datecreated = $row['pe_datecreated'];
		$this->dateupdated = $row['pe_dateupdated'];
		$this->datesynced = $row['pe_datesynced'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'price_enemy
				WHERE pe_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'price_enemy pe';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'price_enemy pe';

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
			$myPriceEnemy = new Core_PriceEnemy();

			$myPriceEnemy->pcid = $row['pc_id'];
			$myPriceEnemy->pid = $row['p_id'];
			$myPriceEnemy->uid = $row['u_id'];
			$myPriceEnemy->eid = $row['e_id'];
			$myPriceEnemy->rid = $row['r_id'];
			$myPriceEnemy->id = $row['pe_id'];
			$myPriceEnemy->productname = $row['pe_productname'];
			$myPriceEnemy->url = $row['pe_url'];
			$myPriceEnemy->image = $row['pe_image'];
			$myPriceEnemy->description = $row['pe_description'];
			$myPriceEnemy->name = $row['pe_name'];
			$myPriceEnemy->price = $row['pe_price'];
			$myPriceEnemy->pricepromotion = $row['pe_pricepromotion'];
			$myPriceEnemy->priceauto = $row['pe_priceauto'];
			$myPriceEnemy->promotioninfo = $row['pe_promotioninfo'];
			$myPriceEnemy->type = $row['pe_type'];
			$myPriceEnemy->note = $row['pe_note'];
			$myPriceEnemy->displayorder = $row['pe_displayorder'];
			$myPriceEnemy->status = $row['pe_status'];
			$myPriceEnemy->datecreated = $row['pe_datecreated'];
			$myPriceEnemy->dateupdated = $row['pe_dateupdated'];
			$myPriceEnemy->datesynced = $row['pe_datesynced'];


            $outputList[] = $myPriceEnemy;
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
	public static function getPriceEnemys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pc_id = '.(int)$formData['fpcid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.u_id = '.(int)$formData['fuid'].' ';

		if($formData['feid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.e_id = '.(int)$formData['feid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pe_id = '.(int)$formData['fid'].' ';

		if($formData['fprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pe_price = '.(float)$formData['fprice'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pe_status = '.(int)$formData['fstatus'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pe_type = '.(int)$formData['ftype'].' ';

		if(count($formData['fpcidarr']) > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pc_id IN('.implode(',', $formData['fpcidarr']).') ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'url')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pe.pe_url LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (pe.pe_url LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'pe_displayorder ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'p_id,u_id ' . $sorttype;
		elseif($sortby == 'eid')
			$orderString = 'p_id,e_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'p_id,pe_id ' . $sorttype;
		elseif($sortby == 'url')
			$orderString = 'p_id,pe_url ' . $sorttype;
		elseif($sortby == 'price')
			$orderString = 'p_id,pe_price ' . $sorttype;
		else
			$orderString = 'p_id,pe_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_NOTSYNC] = 'Not Sync';
		$output[self::STATUS_SYNCED] = 'Synced';
		$output[self::STATUS_SYNCERROR] = 'Sync Error';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_NOTSYNC: $name = 'Not Sync'; break;
			case self::STATUS_SYNCED: $name = 'Synced'; break;
			case self::STATUS_SYNCERROR: $name = 'Sync error'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_NOTSYNC && $name == 'not sync' || $this->status == self::STATUS_SYNCED && $name == 'synced'|| $this->status == self::STATUS_SYNCERROR && $name == 'sync error')
			return true;
		else
			return false;
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(pe_displayorder) FROM ' . TABLE_PREFIX . 'price_enemy';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

	public function getTypeName()
	{
		$name = '';
		switch($this->type)
		{
			case self::TYPE_ONLINE: $name = 'Online'; break;
			case self::TYPE_OFFLINE: $name = 'Offline'; break;
		}
		return $name;
	}

}