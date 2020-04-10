<?php

/**
 * core/backend/class.view.php
 *
 * File contains the class used for View Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_View extends Core_Backend_Object
{
	const TYPE_GROUPCONTROLLER_SITE = 1;
	const TYPE_HOMEPAGE = 10;
    const TYPE_PRODUCT = 11;
    const TYPE_PRODUCTCATEGORY = 12;
    const TYPE_SEARCH = 13;
    const TYPE_NEWS = 21;
    const TYPE_NEWSCATEGORY = 22;
    const TYPE_STUFF = 31;
    const TYPE_STUFFCATEGORY = 32;
	const TYPE_PAGE = 41;

	const DEVICE_DESKTOP = 1;
	const DEVICE_TV = 3;
	const DEVICE_TABLET = 5;
	const DEVICE_SMARTPHONE = 7;
	const DEVICE_OTHER = 9;

	public $uid = 0;
	public $id = 0;
	public $type = 0;
	public $objectid = 0;
	public $moretext = '';	//can be controller,action in general controller, search keyword...
	public $device = 0;
	public $os = '';
	public $referrer = '';
	public $beforetype = 0;
	public $beforeid = 0;
	public $sessionid = '';
	public $trackingid = '';
	public $ipaddress = 0;
	public $datecreated = 0;

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

		if($this->trackingid == '')
			$this->trackingid = $this->sessionid;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'view (
					u_id,
					v_type,
					v_objectid,
					v_moretext,
					v_device,
					v_os,
					v_referrer,
					v_beforetype,
					v_beforeid,
					v_sessionid,
					v_trackingid,
					v_ipaddress,
					v_datecreated
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->type,
					(int)$this->objectid,
					(string)Helper::plaintext($this->moretext),
					(int)$this->device,
					(string)$this->os,
					(string)$this->referrer,
					(int)$this->beforetype,
					(int)$this->beforeid,
					(string)$this->sessionid,
					(string)$this->trackingid,
					(int)$this->ipaddress,
					(int)$this->datecreated
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'view
				SET u_id = ?,
					v_type = ?,
					v_objectid = ?,
					v_moretext = ?,
					v_device = ?,
					v_os = ?,
					v_referrer = ?,
					v_beforetype = ?,
					v_beforeid = ?,
					v_sessionid = ?,
					v_trackingid = ?,
					v_ipaddress = ?,
					v_datecreated = ?
				WHERE v_id = ?';

		$stmt = $this->db3->query($sql, array(
					(int)$this->uid,
					(int)$this->type,
					(int)$this->objectid,
					(string)$this->moretext,
					(int)$this->device,
					(string)$this->os,
					(string)$this->referrer,
					(int)$this->beforetype,
					(int)$this->beforeid,
					(string)$this->sessionid,
					(string)$this->trackingid,
					(int)$this->ipaddress,
					(int)$this->datecreated,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'view v
				WHERE v.v_id = ?';
		$row = $this->db3->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->id = $row['v_id'];
		$this->type = $row['v_type'];
		$this->objectid = $row['v_objectid'];
		$this->moretext = $row['v_moretext'];
		$this->device = $row['v_device'];
		$this->os = $row['v_os'];
		$this->referrer = $row['v_referrer'];
		$this->beforetype = $row['v_beforetype'];
		$this->beforeid = $row['v_beforeid'];
		$this->sessionid = $row['v_sessionid'];
		$this->trackingid = $row['v_trackingid'];
		$this->ipaddress = $row['v_ipaddress'];
		$this->datecreated = $row['v_datecreated'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'view
				WHERE v_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'view v';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'view v';

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
			$myView = new Core_Backend_View();

			$myView->uid = $row['u_id'];
			$myView->id = $row['v_id'];
			$myView->type = $row['v_type'];
			$myView->objectid = $row['v_objectid'];
			$myView->moretext = $row['v_moretext'];
			$myView->device = $row['v_device'];
			$myView->os = $row['v_os'];
			$myView->referrer = $row['v_referrer'];
			$myView->beforetype = $row['v_beforetype'];
			$myView->beforeid = $row['v_beforeid'];
			$myView->sessionid = $row['v_sessionid'];
			$myView->trackingid = $row['v_trackingid'];
			$myView->ipaddress = $row['v_ipaddress'];
			$myView->datecreated = $row['v_datecreated'];


            $outputList[] = $myView;
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
	public static function getViews($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_type = '.(int)$formData['ftype'].' ';

		if($formData['fobjectid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_objectid = '.(int)$formData['fobjectid'].' ';

		if($formData['fdevice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_device = '.(int)$formData['fdevice'].' ';

		if($formData['fos'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_os = "'.Helper::unspecialtext((string)$formData['fos']).'" ';

		if($formData['fbeforetype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_beforetype = '.(int)$formData['fbeforetype'].' ';

		if($formData['fbeforeid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_beforeid = '.(int)$formData['fbeforeid'].' ';

		if($formData['fsessionid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_sessionid = "'.Helper::unspecialtext((string)$formData['fsessionid']).'" ';

		if($formData['ftrackingid'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_trackingid = "'.Helper::unspecialtext((string)$formData['ftrackingid']).'" ';

		if($formData['ftimestampstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_datecreated >= '.(int)$formData['ftimestampstart'].' ';

		if($formData['ftimestampend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_datecreated <= '.(int)$formData['ftimestampend'].' ';


		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'os')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_os LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (v.v_os LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'v_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 'v_type ' . $sorttype;
		elseif($sortby == 'device')
			$orderString = 'v_device ' . $sorttype;
		else
			$orderString = 'v_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public static function getTypeList()
    {
        $output = array();

        $output[self::TYPE_GROUPCONTROLLER_SITE] = 'SITE Controller Group';
        $output[self::TYPE_HOMEPAGE] = 'Homepage';
        $output[self::TYPE_PRODUCT] = 'Product';
        $output[self::TYPE_SEARCH] = 'Search';
        $output[self::TYPE_PRODUCTCATEGORY] = 'Product Category';
        $output[self::TYPE_NEWS] = 'News';
        $output[self::TYPE_NEWSCATEGORY] = 'News Category';
        $output[self::TYPE_STUFF] = 'Stuff';
        $output[self::TYPE_STUFFCATEGORY] = 'Stuff Category';
        $output[self::TYPE_PAGE] = 'Page';

        return $output;
    }


    public function getTypeName()
    {
        $name = '';

        switch($this->type)
        {
            case self::TYPE_GROUPCONTROLLER_SITE: $name = 'SITE Controller Group'; break;
            case self::TYPE_HOMEPAGE: $name = 'Homepage'; break;
            case self::TYPE_PRODUCT: $name = 'Product'; break;
            case self::TYPE_SEARCH: $name = 'Search'; break;
            case self::TYPE_PRODUCTCATEGORY: $name = 'Product Category'; break;
            case self::TYPE_NEWS: $name = 'News'; break;
            case self::TYPE_NEWSCATEGORY: $name = 'News Category'; break;
            case self::TYPE_STUFF: $name = 'Stuff'; break;
            case self::TYPE_STUFFCATEGORY: $name = 'Stuff Category'; break;
            case self::TYPE_PAGE: $name = 'Page'; break;
        }

        return $name;
    }


    public static function checkTypeName($type, $name)
    {
        $name = strtolower($name);

        if(
			($type == self::TYPE_GROUPCONTROLLER_SITE && $name == 'groupcontrollersite' )
			|| ($type == self::TYPE_HOMEPAGE && $name == 'homepage' )
			|| ($type == self::TYPE_PRODUCT && $name == 'product' )
			|| ($type == self::TYPE_SEARCH && $name == 'search' )
			|| ($type == self::TYPE_PRODUCTCATEGORY && $name == 'productcategory' )
			|| ($type == self::TYPE_NEWS && $name == 'news' )
			|| ($type == self::TYPE_NEWSCATEGORY && $name == 'newscategory' )
			|| ($type == self::TYPE_STUFF && $name == 'stuff')
			|| ($type == self::TYPE_STUFFCATEGORY && $name == 'stuffcategory')
			|| ($type == self::TYPE_PAGE && $name == 'page')
			)
            return true;
        else
            return false;
    }


	/**
	* Ham lay duoc xem nhieu nhat trong 1 khoang thoi gian nao do
	*
	* @param mixed $formData
	* @param mixed $limit
	* @return Core_Backend_Book
	*/
	public static function getViewTop($formData, $limit = '')
	{
		$db3 = self::getDb();

		$whereString = '';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.u_id = '.(int)$formData['fuid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_type = '.(int)$formData['ftype'].' ';

		if($formData['fdevice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_device = '.(int)$formData['fdevice'].' ';

		if($formData['ftimestampstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_datecreated >= '.(int)$formData['ftimestampstart'].' ';

		if($formData['ftimestampend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_datecreated <= '.(int)$formData['ftimestampend'].' ';

		$sql = 'SELECT v_objectid, count(v.v_objectid) numview
				FROM ' . TABLE_PREFIX . 'view v';

		if($whereString != '')
			$sql .= ' WHERE ' . $whereString;

		$sql .= ' GROUP BY v.v_objectid
					ORDER BY numview DESC
					LIMIT ' . (int)$limit;
		$stmt = $db3->query($sql);
		$outputList = array();
		while($row = $stmt->fetch())
		{
			$outputList[] = $row['v_objectid'];
		}
		return $outputList;
	}


	public static function getTrackingObjectIdentifier($controllergroup, $controller, $action, $trackingobjectid, $moretext)
	{
		$type = self::getType($controllergroup, $controller, $action);

		$out = $type . '_' . $trackingobjectid . '_'.$moretext.'_' . time();

		return $out;
	}

	public static function isTrackable($controllergroup, $controller, $action)
	{
		global $mobiledetect;

		//Array of casual controller in SITE group to tracking
		$normalGroupControllerSiteList = array('account', 'cart', 'checkout', 'contact', 'faq', 'forgotpass', 'jobcv', 'login', 'logout', 'orders', 'productcompare', 'promotion', 'register', 'search', 'sieuthi', 'tuyendung');

		return (
			!$mobiledetect->isBot() &&
			(
				($controllergroup == 'site' && in_array($controller, $normalGroupControllerSiteList) && $action == 'index')
			||	($controllergroup == 'site' && $controller == 'index' && $action == 'index')		//homepage
			||	($controllergroup == 'site' && $controller == 'search' && $action == 'index')		//search
			||	($controllergroup == 'site' && $controller == 'product' && $action == 'index')		//product category
			|| 	($controllergroup == 'site' && $controller == 'product' && $action == 'detail')	//product detail
			|| 	($controllergroup == 'site' && $controller == 'news' && $action == 'index')		//news category
			|| 	($controllergroup == 'site' && $controller == 'news' && $action == 'detail')		//news detail
			|| 	($controllergroup == 'site' && $controller == 'stuff' && $action == 'index')		//stuff category
			|| 	($controllergroup == 'site' && $controller == 'stuff' && $action == 'detail')	//stuff detail
			|| 	($controllergroup == 'site' && $controller == 'page' && $action == 'detail')		//page detail
			)
			);
	}

	public static function getType($controllergroup, $controller, $action)
	{
		$type = 0;

		if($controllergroup == 'site' && $controller == 'index' && $action == 'index')
			$type = self::TYPE_HOMEPAGE;
		elseif($controllergroup == 'site' && $controller == 'product' && $action == 'index')
			$type = self::TYPE_PRODUCTCATEGORY;
		elseif($controllergroup == 'site' && $controller == 'product' && $action == 'detail')
			$type = self::TYPE_PRODUCT;
		elseif($controllergroup == 'site' && $controller == 'search' && $action == 'index')
			$type = self::TYPE_SEARCH;
		elseif($controllergroup == 'site' && $controller == 'news' && $action == 'index')
			$type = self::TYPE_NEWSCATEGORY;
		elseif($controllergroup == 'site' && $controller == 'news' && $action == 'detail')
			$type = self::TYPE_NEWS;
		elseif($controllergroup == 'site' && $controller == 'stuff' && $action == 'index')
			$type = self::TYPE_STUFFCATEGORY;
		elseif($controllergroup == 'site' && $controller == 'stuff' && $action == 'detail')
			$type = self::TYPE_STUFF;
		elseif($controllergroup == 'site' && $controller == 'page' && $action == 'detail')
			$type = self::TYPE_PAGE;
		elseif($controllergroup == 'site')
			$type = self::TYPE_GROUPCONTROLLER_SITE;

		return $type;
	}

	public static function getDevice()
	{
		global $mobiledetect;

		$device = 0;

		if($mobiledetect->isMobile())
		{
			if($mobiledetect->isTablet())
				$device = self::DEVICE_TABLET;
			else
				$device = self::DEVICE_SMARTPHONE;
		}
		else
			$device = self::DEVICE_DESKTOP;

		return $device;
	}

	public static function getOs()
	{
		$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

		$os_platform    =   "Unknown OS Platform";

	    $os_array       =   array(
	                            '/windows nt 6.2/i'     =>  'Windows 8',
	                            '/windows nt 6.1/i'     =>  'Windows 7',
	                            '/windows nt 6.0/i'     =>  'Windows Vista',
	                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                            '/windows nt 5.1/i'     =>  'Windows XP',
	                            '/windows xp/i'         =>  'Windows XP',
	                            '/windows nt 5.0/i'     =>  'Windows 2000',
	                            '/windows me/i'         =>  'Windows ME',
	                            '/win98/i'              =>  'Windows 98',
	                            '/win95/i'              =>  'Windows 95',
	                            '/win16/i'              =>  'Windows 3.11',
	                            '/macintosh|mac os x/i' =>  'Mac OS X',
	                            '/mac_powerpc/i'        =>  'Mac OS 9',
	                            '/linux/i'              =>  'Linux',
	                            '/ubuntu/i'             =>  'Ubuntu',
	                            '/iphone/i'             =>  'iPhone',
	                            '/ipod/i'               =>  'iPod',
	                            '/ipad/i'               =>  'iPad',
	                            '/android/i'            =>  'Android',
	                            '/blackberry/i'         =>  'BlackBerry',
	                            '/webos/i'              =>  'Mobile'
	                        );

	    foreach ($os_array as $regex => $value) {

	        if (preg_match($regex, $user_agent)) {
	            $os_platform    =   $value;
	        }

	    }

	    return $os_platform;
	}
}