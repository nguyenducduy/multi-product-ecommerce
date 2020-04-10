<?php

/**
 * core/class.eventproducthours.php
 *
 * File contains the class used for EventProductHours Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_EventProductHours extends Core_Object
{
	const STATUS_ENABLE = 2; // cho ban
	const STATUS_BUYING = 3; // dang ban
	const STATUS_DISABLED =1; // da ban
	const STATUS_COMMING =4; // da ban
	public $pid = 0;
	public $id = 0;
	public $randid = 0;
	public $name = "";
	public $images = "";
	public $currentprice = "";
	public $discountprice = "";
	public $eventtime = 0;
	public $displayorder = 0;
	public $status = 0;
	public $begindate = 0;
	public $enddate = 0;
	public $expiretime = 0;
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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'event_product_hours (
					p_id,
					ep_randid,
					ep_name,
					ep_images,
					ep_currentprice,
					ep_discountprice,
					ep_eventtime,
					ep_displayorder,
					ep_status,
					ep_begindate,
					ep_enddate,
					ep_expiretime,
					ep_datecreated,
					ep_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->randid,
					(string)$this->name,
					(string)$this->images,
					(string)$this->currentprice,
					(string)$this->discountprice,
					(int)$this->eventtime,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->begindate,
					(int)$this->enddate,
					(int)$this->expiretime,
					(int)$this->datecreated,
					(int)$this->datemodified
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'event_product_hours
				SET p_id = ?,
					ep_randid = ?,
					ep_name = ?,
					ep_images = ?,
					ep_currentprice = ?,
					ep_discountprice = ?,
					ep_eventtime = ?,
					ep_displayorder = ?,
					ep_status = ?,
					ep_begindate = ?,
					ep_enddate = ?,
					ep_expiretime = ?,
					ep_datecreated = ?,
					ep_datemodified = ?
				WHERE ep_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->randid,
					(string)$this->name,
					(string)$this->images,
					(string)$this->currentprice,
					(string)$this->discountprice,
					(int)$this->eventtime,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->begindate,
					(int)$this->enddate,
					(int)$this->expiretime,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_product_hours ep
				WHERE ep.ep_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = $row['p_id'];
		$this->id = $row['ep_id'];
		$this->randid = $row['ep_randid'];
		$this->name = $row['ep_name'];
		$this->images = $row['ep_images'];
		$this->currentprice = $row['ep_currentprice'];
		$this->discountprice = $row['ep_discountprice'];
		$this->eventtime = $row['ep_eventtime'];
		$this->displayorder = $row['ep_displayorder'];
		$this->status = $row['ep_status'];
		$this->begindate = $row['ep_begindate'];
		$this->enddate = $row['ep_enddate'];
		$this->expiretime = $row['ep_expiretime'];
		$this->datecreated = $row['ep_datecreated'];
		$this->datemodified = $row['ep_datemodified'];

	}

	public function getDataByRandId($randid)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_product_hours ep
				WHERE ep.ep_randid = ?';
		$row = $this->db->query($sql, array($randid))->fetch();

		$this->pid = $row['p_id'];
		$this->id = $row['ep_id'];
		$this->randid = $row['ep_randid'];
		$this->name = $row['ep_name'];
		$this->images = $row['ep_images'];
		$this->currentprice = $row['ep_currentprice'];
		$this->discountprice = $row['ep_discountprice'];
		$this->eventtime = $row['ep_eventtime'];
		$this->displayorder = $row['ep_displayorder'];
		$this->status = $row['ep_status'];
		$this->begindate = $row['ep_begindate'];
		$this->enddate = $row['ep_enddate'];
		$this->expiretime = $row['ep_expiretime'];
		$this->datecreated = $row['ep_datecreated'];
		$this->datemodified = $row['ep_datemodified'];

	}


	/**
	 * Get the product random base on primary key
	 * @param int $id : the primary key value for searching record.
	 */
	public static function getProductRand($status)
	{
		global $db;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_product_hours ep WHERE ep_status != ' . (int)$status . ' ORDER BY rand() LIMIT 0,1';
		$row = $db->query($sql)->fetch();

		$myEventProductHours = new Core_EventProductHours();

		$myEventProductHours->pid = $row['p_id'];
		$myEventProductHours->id = $row['ep_id'];
		$myEventProductHours->randid = $row['ep_randid'];
		$myEventProductHours->name = $row['ep_name'];
		$myEventProductHours->images = $row['ep_images'];
		$myEventProductHours->currentprice = $row['ep_currentprice'];
		$myEventProductHours->discountprice = $row['ep_discountprice'];
		$myEventProductHours->eventtime = $row['ep_eventtime'];
		$myEventProductHours->displayorder = $row['ep_displayorder'];
		$myEventProductHours->status = $row['ep_status'];
		$myEventProductHours->begindate = $row['ep_begindate'];
		$myEventProductHours->enddate = $row['ep_enddate'];
		$myEventProductHours->datecreated = $row['ep_datecreated'];
		$myEventProductHours->datemodified = $row['ep_datemodified'];

		return $myEventProductHours;
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'event_product_hours
				WHERE ep_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'event_product_hours ep';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_product_hours ep';

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
			$myEventProductHours = new Core_EventProductHours();

			$myEventProductHours->pid = $row['p_id'];
			$myEventProductHours->id = $row['ep_id'];
			$myEventProductHours->randid = $row['ep_randid'];
			$myEventProductHours->name = $row['ep_name'];
			$myEventProductHours->images = $row['ep_images'];
			$myEventProductHours->currentprice = $row['ep_currentprice'];
			$myEventProductHours->discountprice = $row['ep_discountprice'];
			$myEventProductHours->eventtime = $row['ep_eventtime'];
			$myEventProductHours->displayorder = $row['ep_displayorder'];
			$myEventProductHours->status = $row['ep_status'];
			$myEventProductHours->begindate  = $row['ep_begindate'];
			$myEventProductHours->enddate = $row['ep_enddate'];
			$myEventProductHours->expiretime = $row['ep_expiretime'];
			$myEventProductHours->datecreated = $row['ep_datecreated'];
			$myEventProductHours->datemodified = $row['ep_datemodified'];


            $outputList[] = $myEventProductHours;
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
	public static function getEventProductHourss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_status = '.(int)$formData['fstatus'].' ';

		if($formData['frandid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_randid = '.(int)$formData['frandid'].' ';

		if($formData['fexpiretime'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_expiretime < '.(int)$formData['fexpiretime'].' ';

		if(isset($formData['fisactive']) && $formData['fisactive'] == 1)
        {
            $wheredate = ($whereString != '' ? ' AND ' : '');
            $wheredate .= '(ep.ep_begindate <= '.(int)time().'
                           AND ep.ep_enddate >= '.(int)time().' AND ep.ep_status != '.Core_EventProductHours::STATUS_COMMING.'
                          )';
            $whereString .= $wheredate;
        }
        if(isset($formData['fcomingisactive']) && $formData['fcomingisactive'] == 1)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ep.ep_status != '.Core_EventProductHours::STATUS_COMMING.' ';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'ep_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'ep_name ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'ep_displayorder ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'ep_status ' . $sorttype;
		elseif($sortby == 'rand')
		{
			$orderString = 'rand() ';
		}
		else
			$orderString = 'ep_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getStatus($status)
	{
		$statusName = array(
			self::STATUS_ENABLE => '<span class="label label-warning">Chờ bán</span>',
			self::STATUS_BUYING => '<span class="label label-info">Đang bán</span>',
			self::STATUS_DISABLED => '<span class="label label-error">Đã bán</span>',
			self::STATUS_COMMING => '<span class="label label-error">Chờ bán ngày sau</span>',
		);
		return $statusName[$status];
	}


}