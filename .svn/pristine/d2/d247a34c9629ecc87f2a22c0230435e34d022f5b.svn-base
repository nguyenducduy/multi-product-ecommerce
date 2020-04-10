<?php

/**
 * core/class.newscategory.php
 *
 * File contains the class used for Newscategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Newscategory extends Core_Object
{
	const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

	public $id = "";
	public $pcid = 0;
	public $image = "";
	public $name = "";
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
	public $subCat = array();
	public $news = array();
	public $parent = array();

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



		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'newscategory (
					pc_id,
					nc_image,
					nc_name,
					nc_slug,
					nc_summary,
					nc_seotitle,
					nc_seokeyword,
                    nc_seodescription,
					nc_metarobot,
					nc_parentid,
					nc_countitem,
					nc_displayorder,
					nc_status,
					nc_datecreated,
					nc_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pcid,
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

        //update image data
        if($this->id > 0)
        {
            if(strlen($_FILES['fimage']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->image != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'newscategory
                            SET nc_image = ?
                            WHERE nc_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'newscategory
				SET pc_id = ?,
					nc_image = ?,
					nc_name = ?,
					nc_slug = ?,
					nc_summary = ?,
					nc_seotitle = ?,
					nc_seokeyword = ?,
                    nc_seodescription = ?,
					nc_metarobot = ?,
					nc_parentid = ?,
					nc_countitem = ?,
					nc_displayorder = ?,
					nc_status = ?,
					nc_datecreated = ?,
					nc_datemodified = ?
				WHERE nc_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pcid,
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
        {
            //update image into database
            if(strlen($_FILES['fimage']['name']) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->image != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'newscategory
                            SET nc_image = ?
                            WHERE nc_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newscategory n
				WHERE n.nc_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['nc_id'];
		$this->pcid = $row['pc_id'];
		$this->image = $row['nc_image'];
		$this->name = $row['nc_name'];
		$this->slug = $row['nc_slug'];
		$this->summary = $row['nc_summary'];
		$this->seotitle = $row['nc_seotitle'];
		$this->seokeyword = $row['nc_seokeyword'];
        $this->seodescription = $row['nc_seodescription'];
		$this->metarobot = $row['nc_metarobot'];
		$this->parentid = $row['nc_parentid'];
		$this->countitem = $row['nc_countitem'];
		$this->displayorder = $row['nc_displayorder'];
		$this->status = $row['nc_status'];
		$this->datecreated = $row['nc_datecreated'];
		$this->datemodified = $row['nc_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->id = $row['nc_id'];
		$this->pcid = $row['pc_id'];
		$this->image = $row['nc_image'];
		$this->name = $row['nc_name'];
		$this->slug = $row['nc_slug'];
		$this->summary = $row['nc_summary'];
		$this->seotitle = $row['nc_seotitle'];
		$this->seokeyword = $row['nc_seokeyword'];
        $this->seodescription = $row['nc_seodescription'];
		$this->metarobot = $row['nc_metarobot'];
		$this->parentid = $row['nc_parentid'];
		$this->countitem = $row['nc_countitem'];
		$this->displayorder = $row['nc_displayorder'];
		$this->status = $row['nc_status'];
		$this->datecreated = $row['nc_datecreated'];
		$this->datemodified = $row['nc_datemodified'];
	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'newscategory
				WHERE nc_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'newscategory n';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newscategory n';

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
			$myNewscategory = new Core_Newscategory();

			$myNewscategory->id = $row['nc_id'];
			$myNewscategory->pcid = $row['pc_id'];
			$myNewscategory->image = $row['nc_image'];
			$myNewscategory->name = $row['nc_name'];
			$myNewscategory->slug = $row['nc_slug'];
			$myNewscategory->summary = $row['nc_summary'];
			$myNewscategory->seotitle = $row['nc_seotitle'];
			$myNewscategory->seokeyword = $row['nc_seokeyword'];
            $myNewscategory->seodescription = $row['nc_seodescription'];
			$myNewscategory->metarobot = $row['nc_metarobot'];
			$myNewscategory->parentid = $row['nc_parentid'];
			$myNewscategory->countitem = Core_News::getNewss(array('fncid' => $row['nc_id']), '', '', '', true);
			$myNewscategory->displayorder = $row['nc_displayorder'];
			$myNewscategory->status = $row['nc_status'];
			$myNewscategory->datecreated = $row['nc_datecreated'];
			$myNewscategory->datemodified = $row['nc_datemodified'];


            $outputList[] = $myNewscategory;
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
	public static function getNewscategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if(isset($formData['fparentid']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_parentid = '.(int)$formData['fparentid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_id = '.(int)$formData['fid'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fsname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_name LIKE "%'.Helper::unspecialtext((string)$formData['fname']).'%" ';

		if($formData['fsummary'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_summary = "'.Helper::unspecialtext((string)$formData['fsummary']).'" ';

		if($formData['fparentid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_parentid = '.(int)$formData['fparentid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_status = '.(int)$formData['fstatus'].' ';

		if(count($formData['fidarr']) > 0 && $formData['fid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_id IN ('.implode(',', $formData['fidarr']).') ';
		}

		if($formData['fparentidall'] == 'all')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_parentid > 0 ';

		if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'name')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'summary')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (n.nc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (n.nc_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'nc_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'nc_name ' . $sorttype;
		elseif($sortby == 'countitem')
			$orderString = 'nc_countitem ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'nc_displayorder ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'nc_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'nc_datemodified ' . $sorttype;
		else
			$orderString = 'nc_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(nc_displayorder) FROM ' . TABLE_PREFIX . 'newscategory';
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

    public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['newscategory']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['newscategory']['imageMaxWidth'],
                                                $registry->setting['newscategory']['imageMaxHeight'],
                                                '',
                                                $registry->setting['newscategory']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create medium image
            $nameMediumPart = substr($name, 0, strrpos($name, '.'));
            $nameMedium = $nameMediumPart . '-medium.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $nameMedium,
                                                $registry->setting['newscategory']['imageMediumWidth'],
                                                $registry->setting['newscategory']['imageMediumHeight'],
                                                '',
                                                $registry->setting['newscategory']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['newscategory']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['newscategory']['imageThumbWidth'],
                                                $registry->setting['newscategory']['imageThumbHeight'],
                                                $registry->setting['newscategory']['imageThumbRatio'],
                                                $registry->setting['newscategory']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //update database
            $this->image = $curDateDir . $name;
        }
    }

    public function deleteImage($imagepath = '')
    {
        global $registry;

        //delete current image
        if($imagepath == '')
            $deletefile = $this->image;
        else
            $deletefile = $imagepath;

        if(strlen($deletefile) > 0)
        {
            $file = $registry->setting['newscategory']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['newscategory']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['newscategory']['imageDirectory'] . $deletemediumimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);
            }

            //delete current image
            if($imagepath == '')
                $this->image = '';
        }
    }


    public function getSmallImage()
    {
        global $registry;

        $pos = strrpos($this->image, '.');
        $extPart = substr($this->image, $pos+1);
        $namePart =  substr($this->image,0, $pos);
        $filesmall = $namePart . '-small.' . $extPart;

        $url = $registry->conf['rooturl'] . $registry->setting['newscategory']['imageDirectory'] . $filesmall;
        return $url;
    }

    public function getMediumImage()
    {
        global $registry;

        $pos = strrpos($this->image, '.');
        $extPart = substr($this->image, $pos+1);
        $namePart =  substr($this->image,0, $pos);
        $filemedium = $namePart . '-medium.' . $extPart;

        $url = $registry->conf['rooturl'] . $registry->setting['newscategory']['imageDirectory'] . $filemedium;
        return $url;
    }

    public function getImage()
    {
        global $registry;

        $url = $registry->conf['rooturl'] . $registry->setting['newscategory']['imageDirectory'] . $this->filepath;
        return $url;
    }


    public function getCatArr($parentid)
    {
    	global $registry;

    	$nameString = '';

    	$myCat = new Core_Newscategory($parentid);

    	if($myCat->parentid != 0)
    	{
			$myParentcat = new Core_Newscategory($myCat->parentid);

			$nameString .= '<a href="'.$registry->conf['rooturl_cms'].'newscategory/index/parentid/'.$myParentcat->id.'">' . $myParentcat->name . '</a> &raquo; <a href="'.$registry->conf['rooturl_cms'] .'newscategory/index/parentid/'.$myCat->id.'">' . $myCat->name . '</a>';
    	}
    	else
    		$nameString .= '<a href="'.$registry->conf['rooturl_cms'] .'newscategory/index/parentid/'.$myCat->id.'">' . $myCat->name . '</a>';

    	return $nameString;
    }

    public static function getSubListCategory($catid, $catlist = array())
    {
    	$outputList = array();
    	if(count($catlist) > 0)
    	{
    		$newscategory = new Core_Newscategory($catid);
    		if($newscategory->parentid > 0)
    			$newscategory->parent = self::getFullParentNewsCategorys($newscategory->id);
    		$outputList[] = $newscategory;
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

    public static function getFullParentNewsCategorys($categoryid)
	{
		global $db, $registry;

        $myNewscategory = new Core_Newscategory($categoryid , true);

		$output = array();

		$sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'newscategory nc
				WHERE nc_id = ' . $myNewscategory->parentid . ' LIMIT 1';

		$categoryList = $db->query($sql, array())->fetchAll();

        //echodebug($categoryList,true);
		foreach($categoryList as $category)
		{
            $output[] = $category;
			$output = array_merge($output, self::getFullParentNewsCategorys($category['nc_id']));
        }
        $output = array_reverse($output);
		return $output;
    }

    public static function getFullParentNewsCategorysId($categoryid)
    {
    	global $registry , $db;

    	$output = array();

    	$myNewscategory = new Core_Newscategory($categoryid , true);
    	if($myNewscategory->id > 0)
    	{
    		$sql = 'SELECT nc_id FROM ' . TABLE_PREFIX . 'newscategory nc WHERE nc_id = ?' ;
    		$stmt = $db->query( $sql , array($myNewscategory->parentid) );

    		while ( $row = $stmt->fetch() )
    		{
    			$output[] = $row['nc_id'];
				$output = array_merge($output , self::getFullParentNewsCategorysId($row['nc_id']));
    		}

    		$output = array_reverse($output);
    		return $output;
    	}
    }

    public static function getFullSubCategory($catid)
    {
    	$outputList = array();
    	$outputList[] = $catid;

    	$catList = Core_Newscategory::getNewscategorys(array('fparentid' => $catid) , 'id' , 'ASC');
    	if(count($catList) > 0)
    	{
    		foreach ($catList as $cat)
    		{
    			$outputList = array_merge($outputList , self::getFullSubCategory($cat->id));
    		}
    	}

    	return $outputList;
    }

    public function getNewscategoryPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->id > 0)
    	{
    		if($this->slug != '')
    			$path .= $this->slug;
    		else
    			$path .= 'site/news/index?ncid=' . $this->id;
    	}

    	return $path;
    }

    public static function getNewsCategoryFromProductcategory($pcid = 0)
    {
		global $db;
		$newscategoryidlist = array();

		if((int)$pcid > 0)
		{
			$sql = 'SELECT pc_id , nc_id FROM ' . TABLE_PREFIX . 'newscategory WHERE nc_status = ?';

			$stmt = $db->query($sql , array(self::STATUS_ENABLE));

			while ( $row = $stmt->fetch())
			{
				if( strlen($row['pc_id']) > 0 )
				{
					$pcidlist = explode(',', $row['pc_id']);
					if(in_array($pcid, $pcidlist))
					{
						$newscategoryidlist[] = $row['nc_id'];
					}
				}
			}
		}

		return $newscategoryidlist;
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
		return 'nc_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myNewscategory = new Core_Newscategory();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'newscategory
					WHERE nc_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['nc_id'] > 0)
			{
				$myNewscategory->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myNewscategory->getDataByArray($row);
		}

		return $myNewscategory;
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
