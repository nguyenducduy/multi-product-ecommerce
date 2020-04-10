<?php

/**
 * core/class.accessticket.php
 *
 * File contains the class used for AccessTicket Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_AccessTicket extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;

	public $uid = 0;
	public $uidissue = 0;
	public $uidmodify = 0;
	public $id = 0;
	public $tickettype = 0;
	public $groupcontroller = "";
	public $controller = "";
	public $action = "";
	public $suffix = "";
	public $fullticket = "";
	public $ipaddress = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datamodified = 0;
	public $accesstickettypeactor = null;
	public $actor = null;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'access_ticket (
					u_id,
					u_id_issue,
					u_id_modify,
					at_tickettype,
					at_groupcontroller,
					at_controller,
					at_action,
					at_suffix,
					at_fullticket,
					at_ipaddress,
					at_status,
					at_datecreated,
					at_datamodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->uidissue,
					(int)$this->uidmodify,
					(int)$this->tickettype,
					(string)$this->groupcontroller,
					(string)$this->controller,
					(string)$this->action,
					(string)$this->suffix,
					(string)$this->fullticket,
					(int)Helper::getIpAddress(true),
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datamodified
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
		$this->datamodified = time();

		$sql = 'UPDATE ' . TABLE_PREFIX . 'access_ticket
				SET u_id = ?,
					u_id_issue = ?,
					u_id_modify = ?,
					at_tickettype = ?,
					at_groupcontroller = ?,
					at_controller = ?,
					at_action = ?,
					at_suffix = ?,
					at_fullticket = ?,
					at_ipaddress = ?,
					at_status = ?,
					at_datecreated = ?,
					at_datamodified = ?
				WHERE at_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->uidissue,
					(int)$this->uidmodify,
					(int)$this->tickettype,
					(string)$this->groupcontroller,
					(string)$this->controller,
					(string)$this->action,
					(string)$this->suffix,
					(string)$this->fullticket,
					(int)Helper::getIpAddress(true),
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datamodified,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'access_ticket at
				WHERE at.at_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->uidissue = $row['u_id_issue'];
		$this->uidmodify = $row['u_id_modify'];
		$this->id = $row['at_id'];
		$this->tickettype = $row['at_tickettype'];
		$this->groupcontroller = $row['at_groupcontroller'];
		$this->controller = $row['at_controller'];
		$this->action = $row['at_action'];
		$this->suffix = $row['at_suffix'];
		$this->fullticket = $row['at_fullticket'];
		$this->ipaddress = long2ip($row['at_ipaddress']);
		$this->status = $row['at_status'];
		$this->datecreated = $row['at_datecreated'];
		$this->datamodified = $row['at_datamodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'access_ticket
				WHERE at_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'access_ticket at';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'access_ticket at';

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
			$myAccessTicket = new Core_AccessTicket();

			$myAccessTicket->uid = $row['u_id'];
			$myAccessTicket->uidissue = $row['u_id_issue'];
			$myAccessTicket->uidmodify = $row['u_id_modify'];
			$myAccessTicket->id = $row['at_id'];
			$myAccessTicket->tickettype = $row['at_tickettype'];
			$myAccessTicket->groupcontroller = $row['at_groupcontroller'];
			$myAccessTicket->controller = $row['at_controller'];
			$myAccessTicket->action = $row['at_action'];
			$myAccessTicket->suffix = $row['at_suffix'];
			$myAccessTicket->fullticket = $row['at_fullticket'];
			$myAccessTicket->ipaddress = long2ip($row['at_ipaddress']);
			$myAccessTicket->status = $row['at_status'];
			$myAccessTicket->datecreated = $row['at_datecreated'];
			$myAccessTicket->datamodified = $row['at_datamodified'];


            $outputList[] = $myAccessTicket;
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
	public static function getAccessTickets($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fuidissue'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.u_id_issue = '.(int)$formData['fuidissue'].' ';

		if($formData['fuidmodify'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.u_id_modify = '.(int)$formData['fuidmodify'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_id = '.(int)$formData['fid'].' ';

		if($formData['ftickettype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_tickettype = '.(int)$formData['ftickettype'].' ';

		if($formData['fgroupcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_groupcontroller = "'.Helper::unspecialtext((string)$formData['fgroupcontroller']).'" ';

		if($formData['fcontroller'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_controller = "'.Helper::unspecialtext((string)$formData['fcontroller']).'" ';

		if($formData['faction'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_action = "'.Helper::unspecialtext((string)$formData['faction']).'" ';

		if($formData['fsuffix'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_suffix = "'.Helper::unspecialtext((string)$formData['fsuffix']).'" ';

		if($formData['ffullticket'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_fullticket = "'.Helper::unspecialtext((string)$formData['ffullticket']).'" ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'at.at_status = '.(int)$formData['fstatus'].' ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'at_id ' . $sorttype;
		elseif($sortby == 'groupcontroller')
			$orderString = 'at_groupcontroller ' . $sorttype;
		elseif($sortby == 'controller')
			$orderString = 'at_controller ' . $sorttype;
		elseif($sortby == 'action')
			$orderString = 'at_action ' . $sorttype;
		elseif($sortby == 'suffix')
			$orderString = 'at_suffix ' . $sorttype;
		elseif($sortby == 'fullticket')
			$orderString = 'at_fullticket ' . $sorttype;
		else
			$orderString = 'at_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

   	public static function getStatusList()
	{
		$outputList = array();

		$outputList[self::STATUS_ENABLE] = 'Enable';
		$outputList[self::STATUS_DISABLE] = 'Disable';

		return $outputList;
	}

	public function getStatusName()
	{
		$name = '';

		switch ($this->status)
		{
			case self::STATUS_ENABLE :
				$name = 'Enable';
				break;

			case self::STATUS_DISABLE :
				$name = 'Disable';
				break;

		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if( ($this->status == self::STATUS_ENABLE && $name == 'enable') || ($this->status == self::STATUS_DISABLE && $name == 'disable') )
			return true;
		else
			return false;
	}

	public static function getSuffixs($condition = array())
	{
		global $db;
		global $registry;
		$suffixlist = array();

		if(count($condition) > 0)
		{
			$sql = 'SELECT at_suffix FROM ' . TABLE_PREFIX . 'access_ticket
					WHERE u_id = ?
					AND at_groupcontroller = ?
					AND at_controller = ?
					AND at_action = ?';
			$stmt = $db->query($sql , array($registry->me->id,
											$condition['groupcontroller'],
											$condition['controller'],
											$condition['action'],
											));
            while($row = $stmt->fetch())
            {
                $suffixlist[] = $row['at_suffix'];
            }
		}

		return $suffixlist;
	}

    public static  function checkexistticket($uid = 0 , $fullticket = '')
    {
        $have = false;
        global $db;

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX .'access_ticket WHERE at_fullticket = ? AND u_id = ?';

        $rowCount = $db->query($sql , array($fullticket , $uid))->fetchColumn(0);


        return $have;
    }
}
