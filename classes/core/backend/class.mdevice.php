<?php

/**
 * core/class.mdevice.php
 *
 * File contains the class used for MDevice Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Backend_MDevice extends Core_Backend_Object
{
	const PLATFORM_ANDROID = 1;
	const PLATFORM_IOS = 2;
	const PLATFORM_WINDOWSPHONE = 3;

	public $uid = 0;
	public $id = 0;
	public $deviceid = "";
	public $pushtrackerid = '';	//registered id for google cloud messaging (android),push notification (ios),...
	public $platform = 0;
	public $screenwidth = 0;
	public $screenheight = 0;
	public $name = "";
	public $brand = "";
	public $os = "";
	public $appversion = "";
	public $settingnotifyorder = 0;
	public $settingnotifycomment = 0;
	public $settingnotifymessage = 0;
	public $settingnotifyvibration = 0;
	public $ipaddress = '';
	public $datecreated = 0;
	public $datemodified = 0;
	public $datelastaccessed = 0;


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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'm_device (
					u_id,
					md_deviceid,
					md_pushtrackerid,
					md_platform,
					md_screenwidth,
					md_screenheight,
					md_name,
					md_brand,
					md_os,
					md_appversion,
					md_settingnotifyorder,
					md_settingnotifycomment,
					md_settingnotifymessage,
					md_settingnotifyvibration,
					md_ipaddress,
					md_datecreated,
					md_datemodified,
					md_datelastaccessed
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->deviceid,
					(string)$this->pushtrackerid,
					(int)$this->platform,
					(int)$this->screenwidth,
					(int)$this->screenheight,
					(string)$this->name,
					(string)$this->brand,
					(string)$this->os,
					(string)$this->appversion,
					(int)$this->settingnotifyorder,
					(int)$this->settingnotifycomment,
					(int)$this->settingnotifymessage,
					(int)$this->settingnotifyvibration,
					Helper::getIpAddress(true),
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datelastaccessed
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
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'm_device
				SET u_id = ?,
					md_deviceid = ?,
					md_pushtrackerid = ?,
					md_platform = ?,
					md_screenwidth = ?,
					md_screenheight = ?,
					md_name = ?,
					md_brand = ?,
					md_os = ?,
					md_appversion = ?,
					md_settingnotifyorder = ?,
					md_settingnotifycomment = ?,
					md_settingnotifymessage = ?,
					md_settingnotifyvibration = ?,
					md_datecreated = ?,
					md_datemodified = ?,
					md_datelastaccessed = ?
				WHERE md_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(string)$this->deviceid,
					(string)$this->pushtrackerid,
					(int)$this->platform,
					(int)$this->screenwidth,
					(int)$this->screenheight,
					(string)$this->name,
					(string)$this->brand,
					(string)$this->os,
					(string)$this->appversion,
					(int)$this->settingnotifyorder,
					(int)$this->settingnotifycomment,
					(int)$this->settingnotifymessage,
					(int)$this->settingnotifyvibration,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->datelastaccessed,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'm_device md
				WHERE md.md_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['md_id'];
		$this->deviceid = $row['md_deviceid'];
		$this->pushtrackerid = $row['md_pushtrackerid'];
		$this->platform = $row['md_platform'];
		$this->screenwidth = $row['md_screenwidth'];
		$this->screenheight = $row['md_screenheight'];
		$this->name = $row['md_name'];
		$this->brand = $row['md_brand'];
		$this->os = $row['md_os'];
		$this->appversion = $row['md_appversion'];
		$this->settingnotifyorder = $row['md_settingnotifyorder'];
		$this->settingnotifycomment = $row['md_settingnotifycomment'];
		$this->settingnotifymessage = $row['md_settingnotifymessage'];
		$this->settingnotifyvibration = $row['md_settingnotifyvibration'];
		$this->ipaddress = long2ip($row['md_ipaddress']);
		$this->datecreated = $row['md_datecreated'];
		$this->datemodified = $row['md_datemodified'];
		$this->datelastaccessed = $row['md_datelastaccessed'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'm_device
				WHERE md_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'm_device md';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'm_device md';

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
			$myMDevice = new Core_Backend_MDevice();

			$myMDevice->uid = $row['u_id'];
			$myMDevice->id = $row['md_id'];
			$myMDevice->deviceid = $row['md_deviceid'];
			$myMDevice->pushtrackerid = $row['md_pushtrackerid'];
			$myMDevice->platform = $row['md_platform'];
			$myMDevice->screenwidth = $row['md_screenwidth'];
			$myMDevice->screenheight = $row['md_screenheight'];
			$myMDevice->name = $row['md_name'];
			$myMDevice->brand = $row['md_brand'];
			$myMDevice->os = $row['md_os'];
			$myMDevice->appversion = $row['md_appversion'];
			$myMDevice->settingnotifyorder = $row['md_settingnotifyorder'];
			$myMDevice->settingnotifycomment = $row['md_settingnotifycomment'];
			$myMDevice->settingnotifymessage = $row['md_settingnotifymessage'];
			$myMDevice->settingnotifyvibration = $row['md_settingnotifyvibration'];
			$myMDevice->ipaddress = long2ip($row['md_ipaddress']);
			$myMDevice->datecreated = $row['md_datecreated'];
			$myMDevice->datemodified = $row['md_datemodified'];
			$myMDevice->datelastaccessed = $row['md_datelastaccessed'];


            $outputList[] = $myMDevice;
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
	public static function getMDevices($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_id = '.(int)$formData['fid'].' ';

		if($formData['fdeviceid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_deviceid = "'.Helper::unspecialtext((string)$formData['fdeviceid']).'" ';

		if($formData['fpushtrackerid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_pushtrackerid = "'.Helper::unspecialtext((string)$formData['fpushtrackerid']).'" ';

		if($formData['fplatform'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_platform = '.(int)$formData['fplatform'].' ';

		if($formData['fscreenwidth'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_screenwidth = '.(int)$formData['fscreenwidth'].' ';

		if($formData['fscreenheight'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_screenheight = '.(int)$formData['fscreenheight'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fbrand'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_brand = "'.Helper::unspecialtext((string)$formData['fbrand']).'" ';

		if($formData['fos'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_os = "'.Helper::unspecialtext((string)$formData['fos']).'" ';

		if($formData['fappversion'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_appversion = "'.Helper::unspecialtext((string)$formData['fappversion']).'" ';

		if($formData['fipaddress'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_ipaddress = '.ip2long((string)$formData['fipaddress']).' ';

		if($formData['fdatelastaccessed'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_datelastaccessed = '.(int)$formData['fdatelastaccessed'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'deviceid')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_deviceid LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'brand')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_brand LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'os')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_os LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'appversion')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'md.md_appversion LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (md.md_deviceid LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (md.md_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (md.md_brand LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (md.md_os LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (md.md_appversion LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'md_id ' . $sorttype;
		elseif($sortby == 'screenwidth')
			$orderString = 'md_screenwidth ' . $sorttype;
		elseif($sortby == 'screenheight')
			$orderString = 'md_screenheight ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'md_name ' . $sorttype;
		elseif($sortby == 'brand')
			$orderString = 'md_brand ' . $sorttype;
		elseif($sortby == 'os')
			$orderString = 'md_os ' . $sorttype;
		elseif($sortby == 'appversion')
			$orderString = 'md_appversion ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'md_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'md_datemodified ' . $sorttype;
		elseif($sortby == 'datelastaccessed')
			$orderString = 'md_datelastaccessed ' . $sorttype;
		else
			$orderString = 'md_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	 * Base on type of Notification & setting of current device
	 */
	public function canPush($notificationType)
	{
		$pass = false;

		if($this->settingnotifyorder == 1 && ($notificationType == Core_Notification::TYPE_ORDER_ADD || $notificationType == Core_Notification::TYPE_ORDER_UPDATE))
			$pass = true;
		elseif($this->settingnotifycomment == 1 && ($notificationType == Core_Notification::TYPE_PRODUCTCOMMENT_ADD || $notificationType == Core_Notification::TYPE_PRODUCTCOMMENT_REPLY || $notificationType == Core_Notification::TYPE_PRODUCTCOMMENT_LIKE))
			$pass = true;
		elseif($this->settingnotifymessage == 1 && $notificationType == 0)
			$pass = true;

		return $pass;
	}


}