<?php

/**
 * core/class.page.php
 *
 * File contains the class used for Page Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Page extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

	public $uid = 0;
	public $id = 0;
	public $title = "";
	public $slug = "";
	public $content = "";
	public $contenttype = 0;
	public $seotitle = "";
	public $seokeyword = "";
    public $seodescription = "";
	public $metarobot = "";
	public $countview = 0;
	public $countreview = 0;
	public $themeid = 0;
	public $isofficial = 0;
	public $limitgroup = '';
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'page (
					u_id,
					p_title,
					p_slug,
					p_content,
					p_contenttype,
					p_seotitle,
					p_seokeyword,
                    p_seodescription,
					p_metarobot,
					p_countview,
					p_countreview,
					p_themeid,
					p_isofficial,
					p_limitgroup,
					p_blank,
					p_status,
					p_ipaddress,
					p_datecreated,
					p_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(int)$this->contenttype,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->themeid,
					(int)$this->isofficial,
					(string)$this->limitgroup,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'page
				SET u_id = ?,
					p_title = ?,
					p_slug = ?,
					p_content = ?,
					p_contenttype = ?,
					p_seotitle = ?,
					p_seokeyword = ?,
                    p_seodescription = ?,
					p_metarobot = ?,
					p_countview = ?,
					p_countreview = ?,
					p_themeid = ?,
					p_isofficial = ?,
					p_limitgroup = ?,
					p_blank = ? ,
					p_status = ?,
					p_ipaddress = ?,
					p_datecreated = ?,
					p_datemodified = ?
				WHERE p_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(int)$this->contenttype,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->themeid,
					(int)$this->isofficial,
					(string)$this->limitgroup,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'page p
				WHERE p.p_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['p_id'];
		$this->title = $row['p_title'];
		$this->slug = $row['p_slug'];
		$this->content = $row['p_content'];
		$this->contenttype = $row['p_contenttype'];
		$this->seotitle = $row['p_seotitle'];
		$this->seokeyword = $row['p_seokeyword'];
        $this->seodescription = $row['p_seodescription'];
		$this->metarobot = $row['p_metarobot'];
		$this->countview = $row['p_countview'];
		$this->countreview = $row['p_countreview'];
		$this->themeid = $row['p_themeid'];
		$this->isofficial = $row['p_isofficial'];
		$this->limitgroup = $row['p_limitgroup'];
		$this->blank = $row['p_blank'];
		$this->status = $row['p_status'];
		$this->ipaddress = $row['p_ipaddress'];
		$this->datecreated = $row['p_datecreated'];
		$this->datemodified = $row['p_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->id = $row['p_id'];
		$this->title = $row['p_title'];
		$this->slug = $row['p_slug'];
		$this->content = $row['p_content'];
		$this->contenttype = $row['p_contenttype'];
		$this->seotitle = $row['p_seotitle'];
		$this->seokeyword = $row['p_seokeyword'];
        $this->seodescription = $row['p_seodescription'];
		$this->metarobot = $row['p_metarobot'];
		$this->countview = $row['p_countview'];
		$this->countreview = $row['p_countreview'];
		$this->themeid = $row['p_themeid'];
		$this->isofficial = $row['p_isofficial'];
		$this->limitgroup = $row['p_limitgroup'];
		$this->blank = $row['p_blank'];
		$this->status = $row['p_status'];
		$this->ipaddress = $row['p_ipaddress'];
		$this->datecreated = $row['p_datecreated'];
		$this->datemodified = $row['p_datemodified'];
	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'page
				WHERE p_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'page p';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'page p';

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
			$myPage = new Core_Page();

			$myPage->uid = $row['u_id'];
			$myPage->id = $row['p_id'];
			$myPage->image = $row['p_image'];
			$myPage->title = $row['p_title'];
			$myPage->slug = $row['p_slug'];
			$myPage->content = $row['p_content'];
			$myPage->contenttype = $row['p_contenttype'];
			$myPage->seotitle = $row['p_seotitle'];
			$myPage->seokeyword = $row['p_seokeyword'];
            $myPage->seodescription = $row['p_seodescription'];
			$myPage->metarobot = $row['p_metarobot'];
			$myPage->countview = $row['p_countview'];
			$myPage->countreview = $row['p_countreview'];
			$myPage->themeid = $row['p_themeid'];
			$myPage->isofficial = $row['p_isofficial'];
			$myPage->limitgroup = $row['p_limitgroup'];
			$myPage->blank = $row['p_blank'];
			$myPage->status = $row['p_status'];
			$myPage->ipaddress = $row['p_ipaddress'];
			$myPage->datecreated = $row['p_datecreated'];
			$myPage->datemodified = $row['p_datemodified'];


            $outputList[] = $myPage;
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
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fid'].' ';

		if($formData['fthemeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_themeid = '.(int)$formData['fthemeid'].' ';

		if(isset($formData['fisofficial']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_isofficial = '.(int)$formData['fisofficial'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_status = '.(int)$formData['fstatus'].' ';

		if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'title')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'content')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.p_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (p.p_content LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'title')
			$orderString = 'p_title ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 'p_countview ' . $sorttype;
		elseif($sortby == 'countreview')
			$orderString = 'p_countreview ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'p_status ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'p_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'p_datemodified ' . $sorttype;
		else
			$orderString = 'p_datecreated ' . $sorttype;

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
    		$path .= $rooturl . 'site/'. 'page/detail/id/' . (int)$this->id;
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
		return 'page_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myPage = new Core_Page();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();
		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'page
					WHERE p_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['p_id'] > 0)
			{
				$myPage->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myPage->getDataByArray($row);
		}

		return $myPage;
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