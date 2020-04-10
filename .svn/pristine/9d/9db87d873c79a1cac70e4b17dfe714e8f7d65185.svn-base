<?php

/**
 * core/class.region.php
 *
 * File contains the class used for Region Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Region extends Core_Object
{

	public $id = 0;
	public $name = "";
    public $slug = "";
    public $displayorder = 0;
    public $lat = 0;
	public $lng = 0;
    public $parentid = 0;
	public $districtcrm = 0;
	public $isinshore = 0;	//co phai giao trong noi thanh
	public $priceshiphalf = 0;	// under 500gram price ship
	public $priceshipone = 0;	// 500gr - 1kg price ship
	public $priceshiponehalf = 0;	//1kg - 1.5kg price ship
	public $priceshiptwo = 0;	// 1.5kg - 2kg price ship
	public $priceshipmorehalf = 0;	// each 500gr from 2kg price (2.5, 3, 3.5..)


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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'region (
					r_name,
					r_slug,
                    r_displayorder,
                    r_lat,
					r_lng,
                    r_parentid,
					r_districtcrm
					)
		        VALUES(?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->slug,
                    (int)$this->displayorder,
                    (double)$this->lat,
					(double)$this->lng,
                    (int)$this->parentid,
					(int)$this->districtcrm,
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'region
				SET r_name = ?,
				    r_slug = ?,
					r_displayorder = ?,
                    r_lat = ?,
                    r_lng = ?,
                    r_parentid = ?,
					r_districtcrm = ?,
					r_isinshore = ?,
					r_priceshiphalf = ?,
					r_priceshipone = ?,
					r_priceshiponehalf = ?,
					r_priceshiptwo = ?,
					r_priceshipmorehalf = ?
				WHERE r_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->name,
					(string)$this->slug,
					(int)$this->displayorder,
                    (double)$this->lat,
                    (double)$this->lng,
                    (int)$this->parentid,
					(int)$this->districtcrm,
					(int)$this->isinshore,
					(float)$this->priceshiphalf,
					(float)$this->priceshipone,
					(float)$this->priceshiponehalf,
					(float)$this->priceshiptwo,
					(float)$this->priceshipmorehalf,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'region r
				WHERE r.r_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['r_id'];
		$this->name = $row['r_name'];
		$this->slug = $row['r_slug'];
        $this->displayorder = $row['r_displayorder'];
        $this->lat = $row['r_lat'];
		$this->lng = $row['r_lng'];

        $this->parentid = $row['r_parentid'];
		$this->districtcrm = $row['r_districtcrm'];
		$this->isinshore = $row['r_isinshore'];
		$this->priceshiphalf = $row['r_priceshiphalf'];
		$this->priceshipone = $row['r_priceshipone'];
		$this->priceshiponehalf = $row['r_priceshiponehalf'];
		$this->priceshiptwo = $row['r_priceshiptwo'];
		$this->priceshipmorehalf = $row['r_priceshipmorehalf'];

	}

    /**
     * Get the object data base on slug
     * @param String $slug : value for searching record.
     */
    public static function getSlug($slug)
    {
        global $db;

        $slug = (string)$slug;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'region r
				WHERE r.r_slug = ?';
        $row = $db->query($sql, array($slug))->fetch();

        $myRegion = new Core_Region();

        $myRegion->id = $row['r_id'];
        $myRegion->name = $row['r_name'];
        $myRegion->slug = $row['r_slug'];
        $myRegion->displayorder = $row['r_displayorder'];
        $myRegion->lat = $row['r_lat'];
        $myRegion->lng = $row['r_lng'];
        $myRegion->parentid = $row['r_parentid'];
        $myRegion->districtcrm = $row['r_districtcrm'];
        $myRegion->isinshore = $row['r_isinshore'];
        $myRegion->priceshiphalf = $row['r_priceshiphalf'];
        $myRegion->priceshipone = $row['r_priceshipone'];
        $myRegion->priceshiponehalf = $row['r_priceshiponehalf'];
        $myRegion->priceshiptwo = $row['r_priceshiptwo'];
        $myRegion->priceshipmorehalf = $row['r_priceshipmorehalf'];

        return $myRegion;

    }

    /**
     * Get ID by Slug
     * @param  $lug
     * @return $id
     */
    public static function getIdBySlug($slug)
    {
        global $db;

        $slug = (string)Helper::plaintext($slug);
        $sql = 'SELECT r.r_id FROM ' . TABLE_PREFIX . 'region r
				WHERE r.r_slug = ?';
        $row = $db->query($sql, array($slug))->fetch();
        if (!empty($row)) return $row['r_id'];
        return 0;
    }

	public function getDataByArray($row)
	{
		$this->id = $row['r_id'];
		$this->name = $row['r_name'];
		$this->slug = $row['r_slug'];
        $this->displayorder = $row['r_displayorder'];
        $this->lat = $row['r_lat'];
		$this->lng = $row['r_lng'];

        $this->parentid = $row['r_parentid'];
		$this->districtcrm = $row['r_districtcrm'];
		$this->isinshore = $row['r_isinshore'];
		$this->priceshiphalf = $row['r_priceshiphalf'];
		$this->priceshipone = $row['r_priceshipone'];
		$this->priceshiponehalf = $row['r_priceshiponehalf'];
		$this->priceshiptwo = $row['r_priceshiptwo'];
		$this->priceshipmorehalf = $row['r_priceshipmorehalf'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'region
				WHERE r_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'region r';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'region r';

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
			$myRegion = new Core_Region();

			$myRegion->id = $row['r_id'];
			$myRegion->name = $row['r_name'];
			$myRegion->slug = $row['r_slug'];
			$myRegion->displayorder = $row['r_displayorder'];
            $myRegion->lat = $row['r_lat'];
            $myRegion->lng = $row['r_lng'];
            $myRegion->parentid = $row['r_parentid'];
			$myRegion->districtcrm = $row['r_districtcrm'];
			$myRegion->isinshore = $row['r_isinshore'];
			$myRegion->priceshiphalf = $row['r_priceshiphalf'];
			$myRegion->priceshipone = $row['r_priceshipone'];
			$myRegion->priceshiponehalf = $row['r_priceshiponehalf'];
			$myRegion->priceshiptwo = $row['r_priceshiptwo'];
			$myRegion->priceshipmorehalf = $row['r_priceshipmorehalf'];

            $outputList[] = $myRegion;
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
	public static function getRegions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if ($formData['fid'] > 0) {
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_id = '.(int)$formData['fid'].' ';
        }

        if ($formData['flng'] > 0) {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_lat = '.(float)$formData['flat'].' ';
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_lng = '.(float)$formData['flng'].' ';
        }

        if ($formData['fname'] > 0) {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_name = '.(string)Helper::plaintext($formData['fname']).' ';
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_name = '.(string)Helper::plaintext($formData['fname']).' ';
        }

		if(isset($formData['fparentid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_parentid = '.(int)$formData['fparentid'].' ';

		if(count($formData['fidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'r.r_id IN ('.implode(',',$formData['fidarr']).') ';




		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'r_id ' . $sorttype;
		elseif($sortby == 'displayorder')
            $orderString = 'r_displayorder ' . $sorttype;
        elseif($sortby == 'name')
			$orderString = 'r_name ' . $sorttype;
		else
			$orderString = 'r_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	/**
	 * Return shipping price to this location base on the $weight (in gram) of total weight of all books in order
	 */
	public function calculatePrice($weight)
	{
		$price = 0;

		if($weight <= 500)
			$price = $this->priceshiphalf;
		elseif($weight <= 1000)
			$price = $this->priceshipone;
		elseif($weight <= 1500)
			$price = $this->priceshiponehalf;
		else
			$price = $this->priceshiptwo;

		//calculate additional price
		if($weight > 2000)
		{
			$price += ceil(($weight - 2000) / 500) * $this->priceshipmorehalf;
		}


		return $price;
	}

	/**
	 * Predict Region base on IP Address
	 */
	public static function predictRegion()
	{
		$region = 0;

		$myIp = Helper::getIpAddress();

		//checking here

		return $region;
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
		return 'region_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myRegion = new Core_Region();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'region
					WHERE r_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['r_id'] > 0)
			{
				$myRegion->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myRegion->getDataByArray($row);
		}

		return $myRegion;
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

    public function getRegionPath()
    {
        global $registry;

        $regionPath = $registry['conf']['rooturl'];

        if(strlen($this->slug) > 0)
        {
            $regionPath .= 'sieuthi/tinh/' . $this->slug;
        }
        else
        {
            if($regionPath) $regionPath .= 'sieuthi/tinh?id='.$this->id;
        }

        return $regionPath;
    }
}
