<?php

/**
 * core/class.keyword.php
 *
 * File contains the class used for Keyword Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Keyword extends Core_Object
{
	const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;
    const TYPE_PRODUCT = 1;
    const TYPE_NEWS = 3;
    const TYPE_STUFF = 5;
	const TYPE_PAGE = 7;
	const TYPE_EVENT = 9;

	public $id = 0;
	public $text = "";
	public $slug = "";
	public $counttotal = 0;
	public $countproduct = 0;
	public $countnews = 0;
	public $countstuff = 0;
	public $from = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $hash = '';

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'keyword (
					k_text,
					k_slug,
					k_hash,
					k_counttotal,
					k_countproduct,
					k_countnews,
					k_countstuff,
					k_from,
					k_status,
					k_datecreated,
					k_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->text,
					(string)$this->slug,
					$this->hash,
					(int)$this->counttotal,
					(int)$this->countproduct,
					(int)$this->countnews,
					(int)$this->countstuff,
					(int)$this->from,
					(int)$this->status,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'keyword
				SET k_text = ?,
					k_slug = ?,
					k_hash = ?,
					k_counttotal = ?,
					k_countproduct = ?,
					k_countnews = ?,
					k_countstuff = ?,
					k_from = ?,
					k_status = ?,
					k_datecreated = ?,
					k_datemodified = ?
				WHERE k_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->text,
					(string)$this->slug,
					$this->hash,
					(int)$this->counttotal,
					(int)$this->countproduct,
					(int)$this->countnews,
					(int)$this->countstuff,
					(int)$this->from,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'keyword k
				WHERE k.k_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['k_id'];
		$this->text = $row['k_text'];
		$this->slug = $row['k_slug'];
		$this->counttotal = $row['k_counttotal'];
		$this->countproduct = $row['k_countproduct'];
		$this->countnews = $row['k_countnews'];
		$this->countstuff = $row['k_countstuff'];
		$this->from = $row['k_from'];
		$this->status = $row['k_status'];
		$this->datecreated = $row['k_datecreated'];
		$this->datemodified = $row['k_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->id = $row['k_id'];
		$this->text = $row['k_text'];
		$this->slug = $row['k_slug'];
		$this->counttotal = $row['k_counttotal'];
		$this->countproduct = $row['k_countproduct'];
		$this->countnews = $row['k_countnews'];
		$this->countstuff = $row['k_countstuff'];
		$this->from = $row['k_from'];
		$this->status = $row['k_status'];
		$this->datecreated = $row['k_datecreated'];
		$this->datemodified = $row['k_datemodified'];

	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'keyword
				WHERE k_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'keyword k';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'keyword k';

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
			$myKeyword = new Core_Keyword();

			$myKeyword->id = $row['k_id'];
			$myKeyword->text = $row['k_text'];
			$myKeyword->slug = $row['k_slug'];
			$myKeyword->counttotal = $row['k_counttotal'];
			$myKeyword->countproduct = $row['k_countproduct'];
			$myKeyword->countnews = $row['k_countnews'];
			$myKeyword->countstuff = $row['k_countstuff'];
			$myKeyword->from = $row['k_from'];
			$myKeyword->status = $row['k_status'];
			$myKeyword->datecreated = $row['k_datecreated'];
			$myKeyword->datemodified = $row['k_datemodified'];


            $outputList[] = $myKeyword;
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
	public static function getKeywords($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_id = '.(int)$formData['fid'].' ';

		if($formData['ffrom'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_from = '.(int)$formData['ffrom'].' ';

        if($formData['fhash'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_hash= "'.(string)$formData['fhash'].'" ';


        if(!empty($formData['ftext']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_text = \''.addslashes(Helper::plaintext($formData['ftext'])).'\' ';

        if(!empty($formData['flsug']))
        $whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_slug = \''.addslashes(Helper::plaintext($formData['flsug'])).'\' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'text')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_text LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'slug')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_slug LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (k.k_text LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (k.k_slug LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		if($formData['fkeyword'])
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'k.k_hash LIKE \'%'.$formData['fkeyword'].'%\'';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'k_id ' . $sorttype;
		elseif($sortby == 'counttotal')
			$orderString = 'k_counttotal ' . $sorttype;
		elseif($sortby == 'countproduct')
			$orderString = 'k_countproduct ' . $sorttype;
		elseif($sortby == 'countnews')
			$orderString = 'k_countnews ' . $sorttype;
		elseif($sortby == 'countstuff')
			$orderString = 'k_countstuff ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'k_status ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'k_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'k_datemodified ' . $sorttype;
		else
			$orderString = 'k_id ' . $sorttype;

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

    public static function getTypeList()
    {
        $output = array();

        $output[self::TYPE_PRODUCT] = 'Product';
        $output[self::TYPE_NEWS] = 'News';
        $output[self::TYPE_STUFF] = 'Stuff';
        $output[self::TYPE_PAGE] = 'Page';

        return $output;
    }

    public function getTypeName()
    {
        $name = '';

        switch($this->from)
        {
            case self::TYPE_PRODUCT: $name = 'Product'; break;
            case self::TYPE_NEWS: $name = 'News'; break;
            case self::TYPE_STUFF: $name = 'Stuff'; break;
            case self::TYPE_PAGE: $name = 'Page'; break;
        }

        return $name;
    }

    public function checkTypeName($name)
    {
        $name = strtolower($name);

        if(($this->from == self::TYPE_PRODUCT && $name == 'product' )
			|| ($this->from == self::TYPE_NEWS && $name == 'news')
			|| ($this->from == self::TYPE_STUFF && $name == 'stuff')
			|| ($this->from == self::TYPE_PAGE && $name == 'page')
			)
            return true;
        else
            return false;
    }

    public function getKeywordPath($type = false)
    {
    	global $registry;
    	$path = $registry->conf['rooturl'] . 'search/keyword?fkeyword=' . $this->slug;

    	if($type == 'isnews')
    		$path .= '&' . $type;
    	elseif($type == 'ispage')
    		$path .= '&' . $type;

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
		return 'kw_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myKeyword = new Core_Keyword();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'keyword
					WHERE k_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['k_id'] > 0)
			{
				$myKeyword->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myKeyword->getDataByArray($row);
		}

		return $myKeyword;
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
