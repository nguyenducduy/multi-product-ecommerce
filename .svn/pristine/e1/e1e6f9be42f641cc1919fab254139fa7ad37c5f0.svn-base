<?php

/**
 * core/class.news.php
 *
 * File contains the class used for News Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_News extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

    const CATEGORY_VIDEO = 190;
    const CATEGORY_SPCNM = 188;
    const CATEGORY_KM = 187;
    const CATEGORY_ALL_KM = 112;
    const CATEGORY_SPCN = 114;

	public $uid = 0;
	public $ncid = 0;
	public $id = 0;
	public $image = "";
	public $title = "";
	public $slug = "";
	public $content = "";
	public $source = "";
	public $seotitle = "";
	public $seokeyword = "";
    public $seodescription = "";
	public $metarobot = "";
	public $countview = 0;
	public $countreview = 0;
	public $displayorder = 0;
	public $status = 0;
	public $ipaddress = 0;
	public $resourceserver = 0;
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

        $this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'news (
					u_id,
					nc_id,
					n_image,
					n_title,
					n_slug,
					n_content,
					n_source,
					n_seotitle,
					n_seokeyword,
                    n_seodescription,
					n_metarobot,
					n_countview,
					n_countreview,
					n_displayorder,
					n_status,
					n_ipaddress,
					n_datecreated,
					n_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->ncid,
					(string)$this->image,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->source,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->ipaddress,
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
	                	$sql = 'UPDATE ' . TABLE_PREFIX . 'news
	                        SET n_image = ?,
	                        	n_resourceserver = 0
	                        WHERE n_id = ?';

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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'news
				SET u_id = ?,
					nc_id = ?,
					n_image = ?,
					n_title = ?,
					n_slug = ?,
					n_content = ?,
					n_source = ?,
					n_seotitle = ?,
					n_seokeyword = ?,
                    n_seodescription = ?,
					n_metarobot = ?,
					n_countview = ?,
					n_countreview = ?,
					n_displayorder = ?,
					n_status = ?,
					n_ipaddress = ?,
					n_resourceserver = ?,
					n_datecreated = ?,
					n_datemodified = ?
				WHERE n_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->ncid,
					(string)$this->image,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->source,
					(string)$this->seotitle,
					(string)$this->seokeyword,
                    (string)$this->seodescription,
					(string)$this->metarobot,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->resourceserver,
					(int)$this->datecreated,
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
	               elseif($this->image != '')
	               {
	                    //update source
	                    $sql = 'UPDATE ' . TABLE_PREFIX . 'news
	                            SET n_image = ?,
	                            	n_resourceserver = 0
	                            WHERE n_id = ?';

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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'news n
				WHERE n.n_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->ncid = $row['nc_id'];
		$this->id = $row['n_id'];
		$this->image = $row['n_image'];
		$this->title = $row['n_title'];
		$this->slug = $row['n_slug'];
		$this->content = $row['n_content'];
		$this->source = $row['n_source'];
		$this->seotitle = $row['n_seotitle'];
		$this->seokeyword = $row['n_seokeyword'];
        	$this->seodescription = $row['n_seodescription'];
		$this->metarobot = $row['n_metarobot'];
		$this->countview = $row['n_countview'];
		$this->countreview = $row['n_countreview'];
		$this->displayorder = $row['n_displayorder'];
		$this->status = $row['n_status'];
		$this->ipaddress = $row['n_ipaddress'];
		$this->resourceserver = $row['n_resourceserver'];
		$this->datecreated = $row['n_datecreated'];
		$this->datemodified = $row['n_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->ncid = $row['nc_id'];
		$this->id = $row['n_id'];
		$this->image = $row['n_image'];
		$this->title = $row['n_title'];
		$this->slug = $row['n_slug'];
		$this->content = $row['n_content'];
		$this->source = $row['n_source'];
		$this->seotitle = $row['n_seotitle'];
		$this->seokeyword = $row['n_seokeyword'];
        	$this->seodescription = $row['n_seodescription'];
		$this->metarobot = $row['n_metarobot'];
		$this->countview = $row['n_countview'];
		$this->countreview = $row['n_countreview'];
		$this->displayorder = $row['n_displayorder'];
		$this->status = $row['n_status'];
		$this->ipaddress = $row['n_ipaddress'];
		$this->resourceserver = $row['n_resourceserver'];
		$this->datecreated = $row['n_datecreated'];
		$this->datemodified = $row['n_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'news
				WHERE n_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'news n';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'news n';

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
			$myNews = new Core_News();

			$myNews->uid = $row['u_id'];
			$myNews->ncid = $row['nc_id'];
			$myNews->id = $row['n_id'];
			$myNews->image = $row['n_image'];
			$myNews->title = $row['n_title'];
			$myNews->slug = $row['n_slug'];
			$myNews->content = $row['n_content'];
			$myNews->source = $row['n_source'];
			$myNews->seotitle = $row['n_seotitle'];
			$myNews->seokeyword = $row['n_seokeyword'];
            $myNews->seodescription = $row['n_seodescription'];
			$myNews->metarobot = $row['n_metarobot'];
			$myNews->countview = $row['n_countview'];
			$myNews->countreview = $row['n_countreview'];
			$myNews->displayorder = $row['n_displayorder'];
			$myNews->status = $row['n_status'];
			$myNews->ipaddress = $row['n_ipaddress'];
			$myNews->resourceserver = $row['n_resourceserver'];
			$myNews->datecreated = $row['n_datecreated'];
			$myNews->datemodified = $row['n_datemodified'];


            $outputList[] = $myNews;
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
	public static function getNewss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fncid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_id = '.(int)$formData['fncid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_id = '.(int)$formData['fid'].' ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['fstitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_title LIKE "%'.Helper::unspecialtext((string)$formData['fstitle']).'%" ';

		if($formData['fcountview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_countview = '.(int)$formData['fcountview'].' ';

		if($formData['fcountreview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_countreview = '.(int)$formData['fcountreview'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_status = '.(int)$formData['fstatus'].' ';

		if(isset($formData['fresourceserver']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if(isset($formData['fhasimage']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_image != "" ';

		if(count($formData['fncidarr']) > 0 && $formData['fid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'n.nc_id IN ('.implode(',', $formData['fncidarr']).') ';
		}

		if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'title')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'content')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'source')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'n.n_source LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (n.n_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (n.n_content LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (n.n_source LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }

        if(count($formData['fidarr']) >0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fidarr']) ; $i++)
            {
                if($i == count($formData['fidarr']) - 1)
                {
                    $whereString .= 'n.n_id = ' . (int)$formData['fidarr'][$i];
                }
                else
                {
                    $whereString .= 'n.n_id = ' . (int)$formData['fidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'n_id ' . $sorttype;
		elseif($sortby == 'title')
			$orderString = 'n_title ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 'n_countview ' . $sorttype;
		elseif($sortby == 'countreview')
			$orderString = 'n_countreview ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'n_displayorder ' . $sorttype;
		elseif($sortby == 'status')
			$orderString = 'n_status ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 'n_datecreated ' . $sorttype;
		elseif($sortby == 'datemodified')
			$orderString = 'n_datemodified ' . $sorttype;
		else
			$orderString = 'n_datecreated ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(n_displayorder) FROM ' . TABLE_PREFIX . 'news';
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
        $namePart =  Helper::codau2khongdau($this->title, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['news']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['news']['imageMaxWidth'],
                                                $registry->setting['news']['imageMaxHeight'],
                                                '',
                                                $registry->setting['news']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['news']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['news']['imageThumbWidth'],
                                                $registry->setting['news']['imageThumbHeight'],
                                                $registry->setting['news']['imageThumbRatio'],
                                                $registry->setting['news']['imageQuality']);
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
            $file = $registry->setting['news']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['news']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['news']['imageDirectory'] . $deletemediumimage;
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

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'news/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['news']['imageDirectory'] . $filesmall;
		}


        return $url;
    }


    public function getImage()
    {
        global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'news/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['news']['imageDirectory'] . $this->image;
		}

        return $url;
    }

  	public function importImage()
  	{
  		global $registry;

		$originalImagePath = $this->image;

        $curDateDir = Helper::getCurrentDateDirName();
	    $extPart = substr(strrchr($originalImagePath,'.'),1);
	    $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
	    $name = $namePart . '.' . $extPart;
	    $fullpath = $registry->setting['news']['imageDirectory'] . $curDateDir . $name;

	    //check existed directory
	    if(!file_exists($registry->setting['news']['imageDirectory'] . $curDateDir))
	    {
			mkdir($registry->setting['news']['imageDirectory'] . $curDateDir, 0777, true);
	    }

	    $originalImagePath = Helper::refineRemoteCoverPath($originalImagePath);

        if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
        {
			//Resize big image if needed
	        $myImageResizer = new ImageResizer( $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
	                                            $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
	                                            $registry->setting['news']['imageMaxWidth'],
	                                            $registry->setting['news']['imageMaxHeight'],
	                                            '',
	                                            $registry->setting['news']['imageQuality']);
	        $myImageResizer->output();
	        unset($myImageResizer);

	        //Create thumb image
	        $nameThumbPart = substr($name, 0, strrpos($name, '.'));
	        $nameThumb = $nameThumbPart . '-small.' . $extPart;
	        $myImageResizer = new ImageResizer(    $registry->setting['news']['imageDirectory'] . $curDateDir, $name,
		                                            $registry->setting['news']['imageDirectory'] . $curDateDir, $nameThumb,
		                                            $registry->setting['news']['imageThumbWidth'],
		                                            $registry->setting['news']['imageThumbHeight'],
		                                            '',
		                                            $registry->setting['news']['imageQuality']);
	        $myImageResizer->output();
	        unset($myImageResizer);

	        //update database
	        $this->image = $curDateDir . $name;
	        $this->smallImage = $curDateDir . $nameThumb;
	        $this->updateImage();
        }
  	}

  	public function updateImage()
    {
		global $registry;

		//get the ratio between width and height
		//read image information
		if($this->image != '')
		{
			$coverpath = $registry->setting['news']['imageDirectory'] . $this->image;
		}

		$sql = 'UPDATE ' . TABLE_PREFIX . 'news
                SET n_image = ?
                WHERE n_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->id
            ));

        return $stmt;
    }

    public function getNewsPath()
    {
    	global $registry;

    	$path = $registry->conf['rooturl'];

    	if($this->id > 0)
    	{
    		if($this->slug != '')
    		{
    			$category = new Core_Newscategory($this->ncid);

    			$path .= $category->slug . '/' . $this->slug;//
    		}
    		else
    		{
    			$path .= 'site/news/detail?id=' . $this->id;
    		}
    	}

    	return $path;
    }

    public function getYoutubeLink()
    {
    	$url = $this->source;

    	if($url != '')
    		$youtubeLink = Helper::makeEmbedYouTubeUrl($url);

    	return $youtubeLink;
    }

    public function getActorName()
    {
    	$actor = new Core_User($this->uid, true);

    	return $actor->fullname;
    }

    public function getAvatar()
    {
    	$actor = new Core_User($this->uid, true);

    	return $actor->avatar;
    }

    public function getNewscategoryname()
    {
    	$newscategory = new Core_Newscategory($this->ncid);

    	return $newscategory->name;
    }

    public function getNewscategorypath()
    {
    	$newscategory = new Core_Newscategory($this->ncid);

    	return $newscategory->getNewscategoryPath();
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
		return 'n_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myNews = new Core_News();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'news
					WHERE n_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['n_id'] > 0)
			{
				$myNews->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myNews->getDataByArray($row);
		}

		return $myNews;
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
