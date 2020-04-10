<?php

/**
 * core/class.stuffcategory.php
 *
 * File contains the class used for Stuffcategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Stuffcategory extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	const CATEGORY_PRODUCT = 1;
	const CATEGORY_NEWS = 3;
	const CATEGORY_STUFF = 5;


	public $id = 0;
	public $image = "";
	public $name = "";
	public $slug = "";
	public $summary = "";
	public $seotitle = "";
	public $seokeyword = "";
	public $seodescription = "";
	public $parentid = 0;
	public $countitem = 0;
	public $displayorder = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $iconclass = '';

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


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stuffcategory (
					sc_image,
					sc_name,
					sc_slug,
					sc_summary,
					sc_seotitle,
					sc_seokeyword,
					sc_seodescription,
					sc_parentid,
					sc_countitem,
					sc_status,
					sc_iconclass,
					sc_datecreated
					)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->image,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->summary,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(int)$this->parentid,
					(int)$this->countitem,
					(int)$this->status,
					(string)$this->iconclass,
					$this->datecreated
					))->rowCount();
		//echo $sql;die();
		$this->id = $this->db->lastInsertId();
		if($this->id > 0)
		{
			if(strlen($_FILES['fimage']['name']) > 0)
			{
				//upload image
				$uploadImageResult = $this->uploadImage();

				if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
					return false;

				elseif($this->filepath != '')
				{
					//update source
					$sql = 'UPDATE ' . TABLE_PREFIX . 'stuffcategory
							SET sc_image = ?
							WHERE sc_id = ?';
					$result=$this->db->query($sql, array($this->filepath, $this->id));
					if(!$result)
						return false;
				}
			}
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'stuffcategory
				SET sc_image = ?,
					sc_name = ?,
					sc_slug = ?,
					sc_summary = ?,
					sc_seotitle = ?,
					sc_seokeyword = ?,
					sc_seodescription = ?,
					sc_parentid = ?,
					sc_countitem = ?,
					sc_displayorder = ?,
					sc_status = ?,
					sc_iconclass = ?,
					sc_datemodified = ?
				WHERE sc_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->image,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->summary,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(int)$this->parentid,
					(int)$this->countitem,
					(int)$this->displayorder,
					(int)$this->status,
					(string)$this->iconclass,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			if(strlen($_FILES['fimage']['name']) > 0)
			{

				//upload image
				$uploadImageResult = $this->uploadImage();

				if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
					return false;
				elseif($this->filepath != '')
				{
					//update source
					$sql = 'UPDATE ' . TABLE_PREFIX . 'stuffcategory
							SET sc_image = ?
							WHERE sc_id = ?';
					$result=$this->db->query($sql, array($this->filepath, $this->id));
					if(!$result)
						return false;
				}
			}
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuffcategory s
				WHERE s.sc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['sc_id'];
		$this->image = $row['sc_image'];
		$this->name = $row['sc_name'];
		$this->slug = $row['sc_slug'];
		$this->summary = $row['sc_summary'];
		$this->seotitle = $row['sc_seotitle'];
		$this->seokeyword = $row['sc_seokeyword'];
		$this->seodescription = $row['sc_seodescription'];
		$this->parentid = $row['sc_parentid'];
		$this->countitem = $row['sc_countitem'];
		$this->displayorder = $row['sc_displayorder'];
		$this->status = $row['sc_status'];
		$this->iconclass = $row['sc_iconclass'];
		$this->datecreated = $row['sc_datecreated'];
		$this->datemodified = $row['sc_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->id = $row['sc_id'];
		$this->image = $row['sc_image'];
		$this->name = $row['sc_name'];
		$this->slug = $row['sc_slug'];
		$this->summary = $row['sc_summary'];
		$this->seotitle = $row['sc_seotitle'];
		$this->seokeyword = $row['sc_seokeyword'];
		$this->seodescription = $row['sc_seodescription'];
		$this->parentid = $row['sc_parentid'];
		$this->countitem = $row['sc_countitem'];
		$this->displayorder = $row['sc_displayorder'];
		$this->status = $row['sc_status'];
		$this->iconclass = $row['sc_iconclass'];
		$this->datecreated = $row['sc_datecreated'];
		$this->datemodified = $row['sc_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stuffcategory
				WHERE sc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stuffcategory s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuffcategory s';

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
			$myStuffcategory = new Core_Stuffcategory();

			$myStuffcategory->id = $row['sc_id'];
			$myStuffcategory->image = $row['sc_image'];
			$myStuffcategory->name = $row['sc_name'];
			$myStuffcategory->slug = $row['sc_slug'];
			$myStuffcategory->summary = $row['sc_summary'];
			$myStuffcategory->seotitle = $row['sc_seotitle'];
			$myStuffcategory->seokeyword = $row['sc_seokeyword'];
			$myStuffcategory->seodescription = $row['sc_seodescription'];
			$myStuffcategory->parentid = $row['sc_parentid'];
			$myStuffcategory->countitem = $row['sc_countitem'];
			$myStuffcategory->displayorder = $row['sc_displayorder'];
			$myStuffcategory->status = $row['sc_status'];
			$myStuffcategory->iconclass = $row['sc_iconclass'];
			$myStuffcategory->datecreated = $row['sc_datecreated'];
			$myStuffcategory->datemodified = $row['sc_datemodified'];


			$outputList[] = $myStuffcategory;
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
	public static function getStuffcategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fsummary'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_summary = "'.Helper::unspecialtext((string)$formData['fsummary']).'" ';

		if($formData['fparentid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_parentid = '.(int)$formData['fparentid'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_status = '.(int)$formData['fstatus'].' ';

		if(count($formData['fidarr']) > 0 && $formData['fid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'sc_id IN ('.implode(',', $formData['fidarr']).') ';
		}

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (s.sc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.sc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'sc_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'sc_name ' . $sorttype;
		elseif($sortby == 'summary')
			$orderString = 'sc_summary ' . $sorttype;
		elseif($sortby == 'parentid')
			$orderString = 'sc_parentid ' . $sorttype;
		elseif($sortby == 'countitem')
			$orderString = 'sc_countitem ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'sc_displayorder ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'sc_status ' . $sorttype;
		else
			$orderString = 'sc_id ' . $sorttype;

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


	public static function getCateList()
	{
		$output = array();

		$output[self::CATEGORY_PRODUCT] = 'Product';
		$output[self::CATEGORY_NEWS] = 'News';
		$output[self::CATEGORY_STUFF] = 'Stuff';

		return $output;
	}

	public function getCateName()
	{
		$name = '';

		switch($this->status)
		{
			case self::CATEGORY_PRODUCT: $name = 'Product'; break;
			case self::CATEGORY_NEWS: $name = 'News'; break;
			case self::CATEGORY_STUFF: $name = 'Stuff'; break;
		}

		return $name;
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
	public function uploadImage()
	{
		global $registry;

		$curDateDir = Helper::getCurrentDateDirName();
		$extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
		$namePart =  Helper::codau2khongdau($this->title, true) . '-' . $this->id . time();
		$name = $namePart . '.' . $extPart;
		$uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, '');

		$uploadError = $uploader->upload(false, $name);
		if($uploadError != Uploader::ERROR_UPLOAD_OK)
		{
			return $uploadError;
		}
		else
		{
			//Resize big image if needed
			$myImageResizer = new ImageResizer( $registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $name,
												$registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $name,
												$registry->setting['stuffcategorys']['imageMaxWidth'],
												$registry->setting['stuffcategorys']['imageMaxHeight'],
												'',
												$registry->setting['stuffcategorys']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//Create medium image
			$nameMediumPart = substr($name, 0, strrpos($name, '.'));
			$nameMedium = $nameMediumPart . '-medium.' . $extPart;
			$myImageResizer = new ImageResizer(    $registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $name,
												$registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $nameMedium,
												$registry->setting['stuffcategorys']['imageMediumWidth'],
												$registry->setting['stuffcategorys']['imageMediumHeight'],
												'',
												$registry->setting['stuffcategorys']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//Create thum image
			$nameThumbPart = substr($name, 0, strrpos($name, '.'));
			$nameThumb = $nameThumbPart . '-small.' . $extPart;
			$myImageResizer = new ImageResizer( $registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $name,
												$registry->setting['stuffcategorys']['imageDirectory'] . $curDateDir, $nameThumb,
												$registry->setting['stuffcategorys']['imageThumbWidth'],
												$registry->setting['stuffcategorys']['imageThumbHeight'],
												$registry->setting['stuffcategorys']['imageThumbRatio'],
												$registry->setting['stuffcategorys']['imageQuality']);
			$myImageResizer->output();
			unset($myImageResizer);

			//update database
			$this->filepath = $curDateDir . $name;
		}
	}

 	public static function getSubListCategory($catid, $catlist = array())
    {
    	$outputList = array();
    	if(count($catlist) > 0)
    	{
    		$stuffcategory = new Core_Stuffcategory($catid);
    		if($stuffcategory->parentid > 0)
    			$stuffcategory->parent = self::getFullParentStuffCategorys($stuffcategory->id);
    		$outputList[] = $stuffcategory;
    		foreach($catlist as $cat)
    		{
    			if($catid == $cat->parentid)
    			{
    				$outputList = array_merge($outputList, self::getSubListCategory($cat->id, $catlist));
    			}
    		}
    	}

    	return $outputList;
    }

    public static function getFullParentStuffCategorys($categoryid)
	{
		global $db, $registry;

        $myStuffcategory = new Core_Stuffcategory($categoryid);

		$output = array();

		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'stuffcategory sc
				WHERE sc_id = ' . $myStuffcategory->parentid . ' LIMIT 1';

		$categoryList = $db->query($sql, array())->fetchAll();

        //echodebug($categoryList,true);
		foreach($categoryList as $category)
		{
			$nc = new Core_Stuffcategory();
            $output[] = $category;
			$output = array_merge($output, self::getFullParentStuffCategorys($category['sc_id']));
        }
        $output = array_reverse($output);
		return $output;
    }

    public function getStuffcategoryPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->id > 0)
    	{
    		if($this->slug != '')
    			$path .= $this->slug;
    		else
    			$path .= 'site/stuff/index?scid=' . $this->id;
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
		return 'stuffcat_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myStuffcategory = new Core_Stuffcategory();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuffcategory
					WHERE sc_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['sc_id'] > 0)
			{
				$myStuffcategory->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myStuffcategory->getDataByArray($row);
		}

		return $myStuffcategory;
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