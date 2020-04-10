<?php

/**
 * core/class.event.php
 *
 * File contains the class used for Event Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Event Class for event feature
 */
Class Core_Event extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

	public $uid = 0;
	public $id = 0;
	public $title = "";
	public $slug = "";
	public $content = "";
	public $productstyle = "";
	public $seotitle = "";
	public $seokeyword = "";
    public $seodescription = "";
	public $metarobot = "";
	public $topseokeyword = "";
	public $footerkey = "";
	public $countview = 0;
	public $countreview = 0;
	public $themeid = 0;
	public $isofficial = 0;
	public $limitgroup = '';
	public $iscounter = 0;
	public $starttime = 0;
	public $endtime = 0;
	public $blank = 0;
	public $status = 0;
	public $ipaddress = 0;
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
        $this->ipaddress = Helper::getIpAddress(true);

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'event (
					u_id,
					ev_title,
					ev_slug,
					ev_content,
					ev_productstyle,
					ev_seotitle,
					ev_seokeyword,
                    ev_seodescription,
					ev_metarobot,
					ev_topseokeyword,
					ev_footerkey,
					ev_countview,
					ev_countreview,
					ev_themeid,
					ev_isofficial,
					ev_limitgroup,
					ev_iscounter,
					ev_starttime,
					ev_endtime,
					ev_blank,
					ev_status,
					ev_ipaddress,
					ev_datecreated,
					ev_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->productstyle,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(string)$this->topseokeyword,
					(string)$this->footerkey,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->themeid,
					(int)$this->isofficial,
					(string)$this->limitgroup,
					(int)$this->iscounter,
					(int)$this->starttime,
					(int)$this->endtime,
					(int)$this->blank,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();

        //update image data
        if($this->id > 0)
        {

        }

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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'event
				SET u_id = ?,
					ev_title = ?,
					ev_slug = ?,
					ev_content = ?,
					ev_productstyle = ?,
					ev_seotitle = ?,
					ev_seokeyword = ?,
                    ev_seodescription = ?,
					ev_metarobot = ?,
					ev_topseokeyword = ?,
					ev_footerkey = ?,
					ev_countview = ?,
					ev_countreview = ?,
					ev_themeid = ?,
					ev_isofficial = ?,
					ev_limitgroup = ?,
					ev_iscounter = ?,
					ev_starttime = ?,
					ev_endtime = ?,
					ev_blank = ? ,
					ev_status = ?,
					ev_ipaddress = ?,
					ev_datecreated = ?,
					ev_datemodified = ?
				WHERE ev_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->productstyle,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(string)$this->topseokeyword,
					(string)$this->footerkey,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->themeid,
					(int)$this->isofficial,
					(string)$this->limitgroup,
					(int)$this->iscounter,
					(int)$this->starttime,
					(int)$this->endtime,
					(int)$this->blank,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
        {
            return true;
        }
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event p
				WHERE p.ev_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['ev_id'];
		$this->title = $row['ev_title'];
		$this->slug = $row['ev_slug'];
		$this->content = $row['ev_content'];
		$this->productstyle = $row['ev_productstyle'];
		$this->seotitle = $row['ev_seotitle'];
		$this->seokeyword = $row['ev_seokeyword'];
        $this->seodescription = $row['ev_seodescription'];
		$this->metarobot = $row['ev_metarobot'];
		$this->topseokeyword = $row['ev_topseokeyword'];
		$this->footerkey = $row['ev_footerkey'];
		$this->countview = $row['ev_countview'];
		$this->countreview = $row['ev_countreview'];
		$this->themeid = $row['ev_themeid'];
		$this->isofficial = $row['ev_isofficial'];
		$this->limitgroup = $row['ev_limitgroup'];
		$this->iscounter = $row['ev_iscounter'];
		$this->starttime = $row['ev_starttime'];
		$this->endtime = $row['ev_endtime'];
		$this->blank = $row['ev_blank'];
		$this->status = $row['ev_status'];
		$this->ipaddress = $row['ev_ipaddress'];
		$this->datecreated = $row['ev_datecreated'];
		$this->datemodified = $row['ev_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->id = $row['ev_id'];
		$this->title = $row['ev_title'];
		$this->slug = $row['ev_slug'];
		$this->content = $row['ev_content'];
		$this->productstyle = $row['ev_productstyle'];
		$this->seotitle = $row['ev_seotitle'];
		$this->seokeyword = $row['ev_seokeyword'];
        $this->seodescription = $row['ev_seodescription'];
		$this->metarobot = $row['ev_metarobot'];
		$this->topseokeyword = $row['ev_topseokeyword'];
		$this->footerkey = $row['ev_footerkey'];
		$this->countview = $row['ev_countview'];
		$this->countreview = $row['ev_countreview'];
		$this->themeid = $row['ev_themeid'];
		$this->isofficial = $row['ev_isofficial'];
		$this->limitgroup = $row['ev_limitgroup'];
		$this->iscounter = $row['ev_iscounter'];
		$this->starttime = $row['ev_starttime'];
		$this->endtime = $row['ev_endtime'];
		$this->blank = $row['ev_blank'];
		$this->status = $row['ev_status'];
		$this->ipaddress = $row['ev_ipaddress'];
		$this->datecreated = $row['ev_datecreated'];
		$this->datemodified = $row['ev_datemodified'];
	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'event
				WHERE ev_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'event p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event p';

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
			$myEvent = new Core_Event();

			$myEvent->uid = $row['u_id'];
			$myEvent->id = $row['ev_id'];
			$myEvent->image = $row['ev_image'];
			$myEvent->title = $row['ev_title'];
			$myEvent->slug = $row['ev_slug'];
			$myEvent->content = $row['ev_content'];
			$myEvent->productstyle = $row['ev_productstyle'];
			$myEvent->seotitle = $row['ev_seotitle'];
			$myEvent->seokeyword = $row['ev_seokeyword'];
            $myEvent->seodescription = $row['ev_seodescription'];
			$myEvent->metarobot = $row['ev_metarobot'];
			$myEvent->topseokeyword = $row['ev_topseokeyword'];
			$myEvent->footerkey = $row['ev_footerkey'];
			$myEvent->countview = $row['ev_countview'];
			$myEvent->countreview = $row['ev_countreview'];
			$myEvent->themeid = $row['ev_themeid'];
			$myEvent->isofficial = $row['ev_isofficial'];
			$myEvent->limitgroup = $row['ev_limitgroup'];
			$myEvent->iscounter = $row['ev_iscounter'];
			$myEvent->starttime = $row['ev_starttime'];
			$myEvent->endtime = $row['ev_endtime'];
			$myEvent->blank = $row['ev_blank'];
			$myEvent->status = $row['ev_status'];
			$myEvent->ipaddress = $row['ev_ipaddress'];
			$myEvent->datecreated = $row['ev_datecreated'];
			$myEvent->datemodified = $row['ev_datemodified'];


            $outputList[] = $myEvent;
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
	public static function getPages($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_id = '.(int)$formData['fid'].' ';

		if($formData['fthemeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_themeid = '.(int)$formData['fthemeid'].' ';

		if(isset($formData['fisofficial']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_isofficial = '.(int)$formData['fisofficial'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_status = '.(int)$formData['fstatus'].' ';

		if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'title')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'content')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.ev_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.ev_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (p.ev_content LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'ev_id ' . $sorttype;
		elseif($sortby == 'title')
			$orderString = 'ev_title ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 'ev_countview ' . $sorttype;
		elseif($sortby == 'countreview')
			$orderString = 'ev_countreview ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'ev_status ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'ev_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'ev_datemodified ' . $sorttype;
		else
			$orderString = 'ev_datecreated ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getStatusList()
    {
        $output = array();

        $output[self::STATUS_ENABLE] = 'Enable';
        $output[self::STATUS_DISABLED] = 'Disabled';

        return $output;
    }

    public function getStatusName()
    {
        $name = '';

        switch($this->status)
        {
            case self::STATUS_ENABLE: $name = 'Enable'; break;
            case self::STATUS_DISABLED: $name = 'Disabled'; break;
        }

        return $name;
    }

    public function checkStatusName($name)
    {
        $name = strtolower($name);

        if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
            return true;
        else
            return false;
    }

    public function getPagePath()
    {
    	global $registry;

    	$path = '';
    	$rooturl = $registry->conf['rooturl'];
    	if(!empty($this->slug))
    	{
    		$path .= $rooturl . $this->slug;
    	}
    	else{
    		$path .= $rooturl . 'site/'. 'event/detail/id/' . (int)$this->id;
    	}

    	return $path;
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
		return 'event_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myEvent = new Core_Event();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();
		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event
					WHERE ev_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['ev_id'] > 0)
			{
				$myEvent->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myEvent->getDataByArray($row);
		}

		return $myEvent;
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