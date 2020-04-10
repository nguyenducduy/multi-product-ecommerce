<?php

/**
 * core/class.lottemember.php
 *
 * File contains the class used for LotteMember Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_LotteMember extends Core_Object
{

	public $leid = 0;
	public $uid = 0;
	public $id = 0;
	public $urlcode = "";
	public $fullname = "";
	public $email = "";
	public $gender = 0;
	public $phone = "";
	public $cmnd = "";
	public $region = 0;
	public $referermemberid = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0, $loadFromCache = false)
	{
		parent::__construct();
		if($id > 0)
		{
			if($loadFromCache)
				$this->copy(self::cacheGet($id));
			else
				$this->getData($id);
		}
	}

	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'lotte_member (
					le_id,
					u_id,
					lm_urlcode,
					lm_fullname,
					lm_email,
					lm_gender,
					lm_phone,
					lm_cmnd,
					lm_region,
					lm_referermemberid,
					lm_datecreated,
					lm_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->leid,
					(int)$this->uid,
					(string)$this->urlcode,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->gender,
					(string)$this->phone,
					(string)$this->cmnd,
					(int)$this->region,
					(int)$this->referermemberid,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'lotte_member
				SET le_id = ?,
					u_id = ?,
					lm_urlcode = ?,
					lm_fullname = ?,
					lm_email = ?,
					lm_gender = ?,
					lm_phone = ?,
					lm_cmnd = ?,
					lm_region = ?,
					lm_referermemberid = ?,
					lm_datecreated = ?,
					lm_datemodified = ?
				WHERE lm_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->leid,
					(int)$this->uid,
					(string)$this->urlcode,
					(string)$this->fullname,
					(string)$this->email,
					(int)$this->gender,
					(string)$this->phone,
					(string)$this->cmnd,
					(int)$this->region,
					(int)$this->referermemberid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_member lm
				WHERE lm.lm_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->leid = $row['le_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['lm_id'];
		$this->urlcode = $row['lm_urlcode'];
		$this->fullname = $row['lm_fullname'];
		$this->email = $row['lm_email'];
		$this->gender = $row['lm_gender'];
		$this->phone = $row['lm_phone'];
		$this->cmnd = $row['lm_cmnd'];
		$this->region = $row['lm_region'];
		$this->referermemberid = $row['lm_referermemberid'];
		$this->datecreated = $row['lm_datecreated'];
		$this->datemodified = $row['lm_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->leid = $row['le_id'];
		$this->uid = $row['u_id'];
		$this->id = $row['lm_id'];
		$this->urlcode = $row['lm_urlcode'];
		$this->fullname = $row['lm_fullname'];
		$this->email = $row['lm_email'];
		$this->gender = $row['lm_gender'];
		$this->phone = $row['lm_phone'];
		$this->cmnd = $row['lm_cmnd'];
		$this->region = $row['lm_region'];
		$this->referermemberid = $row['lm_referermemberid'];
		$this->datecreated = $row['lm_datecreated'];
		$this->datemodified = $row['lm_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'lotte_member
				WHERE lm_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'lotte_member lm';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_member lm';

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
			$myLotteMember = new Core_LotteMember();

			$myLotteMember->leid = $row['le_id'];
			$myLotteMember->uid = $row['u_id'];
			$myLotteMember->id = $row['lm_id'];
			$myLotteMember->urlcode = $row['lm_urlcode'];
			$myLotteMember->fullname = $row['lm_fullname'];
			$myLotteMember->email = $row['lm_email'];
			$myLotteMember->gender = $row['lm_gender'];
			$myLotteMember->phone = $row['lm_phone'];
			$myLotteMember->cmnd = $row['lm_cmnd'];
			$myLotteMember->region = $row['lm_region'];
			$myLotteMember->referermemberid = $row['lm_referermemberid'];
			$myLotteMember->datecreated = $row['lm_datecreated'];
			$myLotteMember->datemodified = $row['lm_datemodified'];


            $outputList[] = $myLotteMember;
        }

        return $outputList;
    }
    public static function getnewid()
    {
        global $db;

        $sql = 'SELECT max(lm_id) FROM ' . TABLE_PREFIX . 'lotte_member lm';
        $rs = $db->query($sql)->fetchColumn(0);
        $sql2 = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_member lm WHERE lm_id ="'.$rs.'"';
        $stmt = $db->query($sql2);
        while($row = $stmt->fetch())
        {
                $myLotteMember = new Core_LotteMember();

                $myLotteMember->leid = $row['le_id'];
                $myLotteMember->uid = $row['u_id'];
                $myLotteMember->id = $row['lm_id'];
                $myLotteMember->urlcode = $row['lm_urlcode'];
                $myLotteMember->fullname = $row['lm_fullname'];
                $myLotteMember->email = $row['lm_email'];
                $myLotteMember->gender = $row['lm_gender'];
                $myLotteMember->phone = $row['lm_phone'];
                $myLotteMember->cmnd = $row['lm_cmnd'];
                $myLotteMember->region = $row['lm_region'];
                $myLotteMember->referermemberid = $row['lm_referermemberid'];
                $myLotteMember->datecreated = $row['lm_datecreated'];
                $myLotteMember->datemodified = $row['lm_datemodified'];


            $outputList[] = $myLotteMember;
        }

        return $outputList ;
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
	public static function getLotteMembers($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fleid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.le_id = '.(int)$formData['fleid'].' ';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_id = '.(int)$formData['fid'].' ';

		if($formData['furlcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_urlcode = "'.Helper::unspecialtext((string)$formData['furlcode']).'" ';

		if($formData['ffullname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_fullname = "'.Helper::unspecialtext((string)$formData['ffullname']).'" ';

		if($formData['femail'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_email = "'.Helper::unspecialtext((string)$formData['femail']).'" ';

		if($formData['fgender'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_gender = '.(int)$formData['fgender'].' ';

		if($formData['fphone'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_phone = "'.Helper::unspecialtext((string)$formData['fphone']).'" ';

		if($formData['fcmnd'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_cmnd = "'.Helper::unspecialtext((string)$formData['fcmnd']).'" ';

		if($formData['fregion'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_region = '.(int)$formData['fregion'].' ';

		if($formData['freferermemberid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_referermemberid = '.(int)$formData['freferermemberid'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_datecreated = '.(int)$formData['fdatecreated'].' ';

		if($formData['fdatemodified'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_datemodified = '.(int)$formData['fdatemodified'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'urlcode')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_urlcode LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'fullname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'email')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_email LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'phone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_phone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'cmnd')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'lm.lm_cmnd LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (lm.lm_urlcode LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (lm.lm_fullname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (lm.lm_email LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (lm.lm_phone LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (lm.lm_cmnd LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'leid')
			$orderString = 'le_id ' . $sorttype;
		elseif($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'lm_id ' . $sorttype;
		elseif($sortby == 'urlcode')
			$orderString = 'lm_urlcode ' . $sorttype;
		elseif($sortby == 'fullname')
			$orderString = 'lm_fullname ' . $sorttype;
		elseif($sortby == 'email')
			$orderString = 'lm_email ' . $sorttype;
		elseif($sortby == 'gender')
			$orderString = 'lm_gender ' . $sorttype;
		elseif($sortby == 'phone')
			$orderString = 'lm_phone ' . $sorttype;
		elseif($sortby == 'cmnd')
			$orderString = 'lm_cmnd ' . $sorttype;
		elseif($sortby == 'region')
			$orderString = 'lm_region ' . $sorttype;
		elseif($sortby == 'referermemberid')
			$orderString = 'lm_referermemberid ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'lm_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'lm_datemodified ' . $sorttype;
		else
			$orderString = 'lm_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}



	////////////////////////////////
	////////////////////////////////
	// START CACHE PROCESS

	/**
	* Ham tra ve key de cache
	*
	* @param mixed $id
	*/
	public static function cacheBuildKey($id)
	{
		return 'lottemember_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myLotteMember = new Core_LotteMember();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'lotte_member
					WHERE lm_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['lm_id'] > 0)
			{
				$myLotteMember->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myLotteMember->getDataByArray($row);
		}

		return $myLotteMember;
	}

	/**
	* Xoa 1 key khoi cache
	*
	* @param mixed $id
	*/
	public static function cacheClear($id)
	{
		$myCacher = new Cacher(self::cacheBuildKey($id));
		return $myCacher->clear();
	}

	// - END CACHE PROCESS
	////////////////////////////////


}