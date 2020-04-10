<?php

/**
 * core/class.productyeararticle.php
 *
 * File contains the class used for ProductyearArticle Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_ProductyearArticle Class
 */
Class Core_ProductyearArticle extends Core_Object
{
	
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $pid = 0;
	public $pyuid = 0;
	public $id = 0;
	public $title = '';
	public $content = '';
	public $point = 0;
	public $countlike = 0;
	public $countshare = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $ipaddress = 0;

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productyear_article (
					p_id,
					pyu_id,
					pya_title,
					pya_content,
					pya_point,
					pya_countlike,
					pya_countshare,
					pya_status,
					pya_datecreated,
					pya_ipaddress
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pyuid,
					(string)$this->title,
					(string)$this->content,
					(int)$this->point,
					(int)$this->countlike,
					(int)$this->countshare,
					(int)$this->status,
					(int)$this->datecreated,
					(int)Helper::getIpAddress(true)
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'productyear_article
				SET p_id = ?,
					pyu_id = ?,
					pya_title = ?,
					pya_content = ?,
					pya_point = ?,
					pya_countlike = ?,
					pya_countshare = ?,
					pya_status = ?,
					pya_datemodified = ?
				WHERE pya_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->pid,
					(int)$this->pyuid,
					(string)$this->title,
					(string)$this->content,
					(int)$this->point,
					(int)$this->countlike,
					(int)$this->countshare,
					(int)$this->status,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear_article pa
				WHERE pa.pya_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pid = (int)$row['p_id'];
		$this->pyuid = (int)$row['pyu_id'];
		$this->id = (int)$row['pya_id'];
		$this->title = (string)$row['pya_title'];
		$this->content = (string)$row['pya_content'];
		$this->point = (int)$row['pya_point'];
		$this->countlike = (int)$row['pya_countlike'];
		$this->countshare = (int)$row['pya_countshare'];
		$this->status = (int)$row['pya_status'];
		$this->datecreated = (int)$row['pya_datecreated'];
		$this->datemodified = (int)$row['pya_datemodified'];
		$this->ipaddress = (string)long2ip($row['pya_ipaddress']);
		
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'productyear_article
				WHERE pya_id = ?';
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
		$db = self::getDb();

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productyear_article pa';

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
		$db = self::getDb();

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productyear_article pa';

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
			$myProductyearArticle = new Core_ProductyearArticle();

			$myProductyearArticle->pid = (int)$row['p_id'];
			$myProductyearArticle->pyuid = (int)$row['pyu_id'];
			$myProductyearArticle->id = (int)$row['pya_id'];
			$myProductyearArticle->title = (string)$row['pya_title'];
			$myProductyearArticle->content = (string)$row['pya_content'];
			$myProductyearArticle->point = (int)$row['pya_point'];
			$myProductyearArticle->countlike = (int)$row['pya_countlike'];
			$myProductyearArticle->countshare = (int)$row['pya_countshare'];
			$myProductyearArticle->status = (int)$row['pya_status'];
			$myProductyearArticle->datecreated = (int)$row['pya_datecreated'];
			$myProductyearArticle->datemodified = (int)$row['pya_datemodified'];
			$myProductyearArticle->ipaddress = (string)long2ip($row['pya_ipaddress']);
			

            $outputList[] = $myProductyearArticle;
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
	public static function getProductyearArticles($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		
		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_id = '.(int)$formData['fid'].' ';
			
		if($formData['fpyuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pyu_id = '.(int)$formData['fpyuid'].' ';
			
		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.p_id = '.(int)$formData['fpid'].' ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['fcontent'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_content = "'.Helper::unspecialtext((string)$formData['fcontent']).'" ';

		if($formData['fpoint'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_point = '.(int)$formData['fpoint'].' ';

		if($formData['fcountlike'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_countlike = '.(int)$formData['fcountlike'].' ';

		if($formData['fcountshare'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_countshare = '.(int)$formData['fcountshare'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_status = '.(int)$formData['fstatus'].' ';

		if($formData['fipaddress'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_ipaddress = '.(int)ip2long($formData['fipaddress']).' ';


		
		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'pa.pya_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (pa.pya_title LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';

		
		if($sortby == 'id')
			$orderString = 'pya_id ' . $sorttype; 
		elseif($sortby == 'title')
			$orderString = 'pya_title ' . $sorttype; 
		elseif($sortby == 'point')
			$orderString = 'pya_point ' . $sorttype; 
		else
			$orderString = 'pya_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	

		
	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disable';
		

		return $output;
	}

	public function getStatusName()
	{
		$name = '';

		switch($this->status)
		{
			case self::STATUS_ENABLE: $name = 'Enable'; break;
			case self::STATUS_DISABLED: $name = 'Disable'; break;
			
		}

		return $name;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		if(($this->status == self::STATUS_ENABLE && $name == 'enable')
			 || ($this->status == self::STATUS_DISABLED && $name == 'disable'))
			return true;
		else
			return false;
	}



}