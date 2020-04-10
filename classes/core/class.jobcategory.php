<?php

/**
 * core/class.jobcategory.php
 *
 * File contains the class used for Jobcategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Jobcategory extends Core_Object
{
	const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

	public $id = 0;
	public $image = "";
	public $name = "";
	public $prefix = '';
	public $level = 0;
	public $slug = "";
	public $summary = "";
	public $seotitle = "";
	public $seokeyword = "";
	public $seodescription = "";
	public $metarobot = "";
	public $parentid = 0;
	public $countitem = 0;
	public $displayorder = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $job = array();


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
		$this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'jobcategory (
					jc_image,
					jc_name,
					jc_slug,
					jc_summary,
					jc_seotitle,
					jc_seokeyword,
					jc_seodescription,
					jc_metarobot,
					jc_parentid,
					jc_countitem,
					jc_displayorder,
					jc_status,
					jc_datecreated,
					jc_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->image,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->summary,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->parentid,
					(int)$this->countitem,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'jobcategory
				SET jc_image = ?,
					jc_name = ?,
					jc_slug = ?,
					jc_summary = ?,
					jc_seotitle = ?,
					jc_seokeyword = ?,
					jc_seodescription = ?,
					jc_metarobot = ?,
					jc_parentid = ?,
					jc_countitem = ?,
					jc_displayorder = ?,
					jc_status = ?,
					jc_datecreated = ?,
					jc_datemodified = ?
				WHERE jc_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->image,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->summary,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->parentid,
					(int)$this->countitem,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'jobcategory j
				WHERE j.jc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['jc_id'];
		$this->image = $row['jc_image'];
		$this->name = $row['jc_name'];
		$this->slug = $row['jc_slug'];
		$this->summary = $row['jc_summary'];
		$this->seotitle = $row['jc_seotitle'];
		$this->seokeyword = $row['jc_seokeyword'];
		$this->seodescription = $row['jc_seodescription'];
		$this->metarobot = $row['jc_metarobot'];
		$this->parentid = $row['jc_parentid'];
		$this->countitem = $row['jc_countitem'];
		$this->displayorder = $row['jc_displayorder'];
		$this->status = $row['jc_status'];
		$this->datecreated = $row['jc_datecreated'];
		$this->datemodified = $row['jc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'jobcategory
				WHERE jc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'jobcategory j';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'jobcategory j';

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
			$myJobcategory = new Core_Jobcategory();

			$myJobcategory->id = $row['jc_id'];
			$myJobcategory->image = $row['jc_image'];
			$myJobcategory->name = $row['jc_name'];
			$myJobcategory->slug = $row['jc_slug'];
			$myJobcategory->summary = $row['jc_summary'];
			$myJobcategory->seotitle = $row['jc_seotitle'];
			$myJobcategory->seokeyword = $row['jc_seokeyword'];
			$myJobcategory->seodescription = $row['jc_seodescription'];
			$myJobcategory->metarobot = $row['jc_metarobot'];
			$myJobcategory->parentid = $row['jc_parentid'];
			$myJobcategory->countitem = Core_Job::getJobs(array('fjcid' => $row['jc_id']), '', '', '', true);
			$myJobcategory->displayorder = $row['jc_displayorder'];
			$myJobcategory->status = $row['jc_status'];
			$myJobcategory->datecreated = $row['jc_datecreated'];
			$myJobcategory->datemodified = $row['jc_datemodified'];


            $outputList[] = $myJobcategory;
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
	public static function getJobcategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_id = '.(int)$formData['fid'].' ';

		if($formData['fslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';

		if(isset($formData['fparentid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_parentid = '. $formData['fparentid'] .' ';

		if($formData['fparentid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_parentid = '.(int)$formData['fparentid'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdatecreated'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_datecreated = '.(int)$formData['fdatecreated'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'j.jc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (j.jc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (j.jc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'jc_id ' . $sorttype;
		else
			$orderString = 'jc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(jc_displayorder) FROM ' . TABLE_PREFIX . 'jobcategory';
        return (int)$this->db->query($sql)->fetchColumn(0);
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

    public function getJobcategoryPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->id > 0)
    	{
    		$path .= 'site/jobcategory/index?jcid=' . $this->id;
    	}

    	return $path;
    }

   public static function getFullSubCategorys($parentId = '0', $level = 0, $prefix='')
	{
		global $db, $registry;
		$output = array();

		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'jobcategory
				WHERE jc_parentid = ?';
		$categoryList = $db->query($sql, array($parentId))->fetchAll();
		$level++;

		//echodebug($categoryList,true);
		foreach($categoryList as $category)
		{

			$prefixTemp = $prefix . ' &raquo; ' . $category['jc_name'];

			$myJobcategory = new Core_Jobcategory();

			$myJobcategory->level = $level;
			$myJobcategory->id = $category['jc_id'];
			$myJobcategory->parentid = $category['jc_parentid'];
			$myJobcategory->displayorder = $category['jc_displayorder'];
			$myJobcategory->status = $category['jc_status'];
			$myJobcategory->name = $prefixTemp;;
			$output[] = $myJobcategory;
			$output = array_merge($output, self::getFullCategorys($category['jc_id'], $level, $prefixTemp ));
		}

		return $output;
	}

	public function getCatArr()
    {
    	global $registry;

    	$nameString = '';

    	$myCat = new Core_Jobcategory($this->parentid);

    	if($myCat->parentid != 0)
    	{
			$myParentcat = new Core_Jobcategory($myCat->parentid);

			$nameString .= '<a href="'.$registry->conf['rooturl_cms'].'jobcategory/index/parentid/'.$myParentcat->id.'">' . $myParentcat->name . '</a> &raquo; <a href="'.$registry->conf['rooturl_cms'] .'jobcategory/index/parentid/'.$myCat->id.'">' . $myCat->name . '</a>';
    	}
    	else
    		$nameString .= '<a href="'.$registry->conf['rooturl_cms'] .'jobcategory/index/parentid/'.$myCat->id.'">' . $myCat->name . '</a>';

    	return $nameString;
    }
}
