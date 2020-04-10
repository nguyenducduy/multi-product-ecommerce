<?php

/**
 * core/class.faq.php
 *
 * File contains the class used for Faq Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Faq extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;
	const STATUS_PENDING = 3;

	public $uid = 0;
	public $pid = 0;
	public $id = 0;
	public $title = "";
	public $fullname = '';
	public $content = "";
	public $displayorder = 0;
	public $status = 0;
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
		$this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'faq (
					u_id,
					p_id,
					f_title,
					f_fullname,
					f_content,
					f_displayorder,
					f_status,
					f_datecreated,
					f_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->title,
					(string)$this->fullname,
					(string)$this->content,
					(int)$this->displayorder,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'faq
				SET u_id = ?,
					p_id = ?,
					f_title = ?,
					f_content = ?,
					f_displayorder = ?,
					f_status = ?,
					f_datecreated = ?,
					f_datemodified = ?
				WHERE f_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(string)$this->title,
					(string)$this->content,
					(int)$this->displayorder,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'faq f
				WHERE f.f_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['f_id'];
		$this->title = $row['f_title'];
		$this->fullname = $row['f_fullname'];
		$this->content = $row['f_content'];
		$this->displayorder = $row['f_displayorder'];
		$this->status = $row['f_status'];
		$this->datecreated = $row['f_datecreated'];
		$this->datemodified = $row['f_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['f_id'];
		$this->title = $row['f_title'];
		$this->fullname = $row['f_fullname'];
		$this->content = $row['f_content'];
		$this->displayorder = $row['f_displayorder'];
		$this->status = $row['f_status'];
		$this->datecreated = $row['f_datecreated'];
		$this->datemodified = $row['f_datemodified'];
	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'faq
				WHERE f_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'faq f';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'faq f';

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
			$myFaq = new Core_Faq();

			$myFaq->uid = $row['u_id'];
			$myFaq->pid = $row['p_id'];
			$myFaq->id = $row['f_id'];
			$myFaq->fullname = $row['f_fullname'];
			$myFaq->title = $row['f_title'];
			$myFaq->content = $row['f_content'];
			$myFaq->displayorder = $row['f_displayorder'];
			$myFaq->status = $row['f_status'];
			$myFaq->datecreated = $row['f_datecreated'];
			$myFaq->datemodified = $row['f_datemodified'];


            $outputList[] = $myFaq;
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
	public static function getFaqs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_id = '.(int)$formData['fid'].' ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['fcontent'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_content = "'.Helper::unspecialtext((string)$formData['fcontent']).'" ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_status = '.(int)$formData['fstatus'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'content')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'f.f_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (f.f_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (f.f_content LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'uid')
			$orderString = 'u_id ' . $sorttype;
		elseif($sortby == 'pid')
			$orderString = 'p_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 'f_id ' . $sorttype;
		else
			$orderString = 'f_id ' . $sorttype;

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
		$output[self::STATUS_PENDING] = 'Pending';

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disabled'; break;
			case self::STATUS_PENDING: $name = 'Pending'; break;
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled' || $this->status == self::STATUS_PENDING && $name == 'pending')
			return true;
		else
			return false;
	}

	public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(f_displayorder) FROM ' . TABLE_PREFIX . 'faq';
        return (int)$this->db->query($sql)->fetchColumn(0);
    }

   	public function getActorName()
   	{
   		$user = new Core_User($this->uid);

   		return $user->fullname;
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
		return 'faq_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myFaq = new Core_Faq();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'faq
					WHERE f_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['f_id'] > 0)
			{
				$myFaq->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myFaq->getDataByArray($row);
		}

		return $myFaq;
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