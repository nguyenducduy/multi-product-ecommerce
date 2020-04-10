<?php

/**
 * core/class.productmedia.php
 *
 * File contains the class used for ProductMedia Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductMedia extends Core_Object
{
	const TYPE_FILE = 1;
	const TYPE_URL = 3;
	const TYPE_360 = 5;
	const TYPE_SPECIALTYPE = 7;

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	public $uid = 0;
	public $pid = 0;
	public $id = 0;
	public $type = 0;
	public $resourceserver = 0;
	public $file = "";
	public $moreurl = "";
	public $fileurl = "";
	public $caption = "";
	public $alt = "";
	public $titleseo = "";
	public $countview = 0;
	public $displayorder = 0;
	public $status = 0;
	public $datecreated = 0;
	public $datemodified = 0;
	public $mediaorder = 0;
	public $productslug = '';
	public $productcolor = "";
	public $productcategoryname = "";

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
		global $registry;

		$this->displayorder = $this->getMaxDisplayOrder() + 1;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_media (
					u_id,
					p_id,
					pm_type,
					pm_resourceserver,
					pm_file,
					pm_moreurl,
					pm_caption,
					pm_alt,
					pm_titleseo,
					pm_countview,
					pm_displayorder,
					pm_status,
					pm_datecreated,
					pm_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(int)$this->type,
					(int)$this->resourceserver,
					(string)$this->file,
					(string)$this->moreurl,
					(string)$this->caption,
					(string)$this->alt,
					(string)$this->titleseo,
					(int)$this->countview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
		if($this->id > 0)
		{
			if(strlen($_FILES['ffile']['name'][$this->mediaorder]) > 0)
			{
				//upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                            SET pm_file = ?,
                                pm_resourceserver = 0
                            WHERE pm_id = ?';
                    $result=$this->db->query($sql, array($this->file, $this->id));

                    if(!$result)
                    	return false;
					else
						return $this->id;
                }
			}
            //set to download from remote image, do like amazon add
			if(strlen($this->fileurl) > 0 && strpos($this->fileurl, 'http') === 0)
	        {
				//check image url is exist
                $originalImagePath = $this->fileurl;
                $url = getimagesize($originalImagePath);

                if(is_array($url))
                {
                	$originalImagePath = $this->fileurl;

	                //kiem tra xem da ton tai thu muc chua image 36o cua san pham
	                if($this->type == Core_ProductMedia::TYPE_360)
	                {
	                    $productmedias = Core_ProductMedia::getProductMedias(array('fpid' => $this->pid , 'ftype' => Core_ProductMedia::TYPE_360) , 'id' , 'ASC');
	                    if(count($productmedias) > 0)
	                    {
	                        $productmedia = $productmedias[0];
	                        $path = explode('/', $productmedia->file);

	                        $curDateDir = '';

	                        for($i = 0 ; $i< count($path) - 1 ; $i++)
	                        {
	                            $curDateDir .= $path[$i] . '/';
	                        }
	                    }
	                    else
	                    {
	                        $curDateDir = Helper::getCurrentDateDirName();
	                    }
	                }
	                else
	                {
	                    $curDateDir = Helper::getCurrentDateDirName();
	                }

	                $extPart = substr(strrchr($originalImagePath,'.'),1);
	                /*$namePart =  Helper::codau2khongdau($this->type, true) . '-' . $this->id . time();*/
	                // if($this->type == Core_ProductMedia::TYPE_360)
	                // {

	                // }
	                // else if($this->type == Core_ProductMedia::TYPE_FILE)
	                // {
	                //  $namePart = Helper::codau2khongdau($htis->productname , true, true) . '';
	                // }
	                $namePart = end(array_reverse(explode('.', end(explode('/', $this->fileurl)))));

	                $name = $namePart . '.' . $extPart;

	                $fullpath = $registry->setting['product']['imageDirectory'] . $curDateDir . $name;


	                //check existed directory
	                if(!file_exists($registry->setting['product']['imageDirectory'] . $curDateDir))
	                {
	                    mkdir($registry->setting['product']['imageDirectory'] . $curDateDir, 0777, true);
	                }


	                if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
	                {
	                    //Resize big image if needed
	                    $myImageResizer = new ImageResizer( $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                        $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                        $registry->setting['product']['imageMaxWidth'],
	                                                        $registry->setting['product']['imageMaxHeight'],
	                                                        '',
	                                                        $registry->setting['product']['imageQuality']);
	                    $myImageResizer->output();
	                    unset($myImageResizer);

	                    //Create thumb image
	                    $nameThumbPart = substr($name, 0, strrpos($name, '.'));
	                    $nameThumb = $nameThumbPart . '-small.' . $extPart;
	                    $myImageResizer = new ImageResizer(    $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                            $registry->setting['product']['imageDirectory'] . $curDateDir, $nameThumb,
	                                                            $registry->setting['product']['imageThumbWidth'],
	                                                            $registry->setting['product']['imageThumbHeight'],
	                                                            '',
	                                                            $registry->setting['product']['imageQuality']);
	                    $myImageResizer->output();
	                    unset($myImageResizer);
	                    //update database
	                    $this->fileurl = $curDateDir . $name;
	                    $this->smallImage = $curDateDir . $nameThumb;
	                    $this->updateImage();
	                    return $this->id;
	                }

                }
                else
                {
                	$this->delete();
                }
			}

			/*if(strlen($_FILES['ffile360']['name'][$this->mediaorder]) > 0)
			{
				//upload image
                $uploadImageResult = $this->uploadImage('ffile360');

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                    return false;
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                            SET pm_file = ?
                            WHERE pm_id = ?';
                    $result=$this->db->query($sql, array($this->file, $this->id));
                    if(!$result)
                    	return false;
					else
						return $this->id;
                }
			}*/

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
		global $registry;

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
				SET u_id = ?,
					p_id = ?,
					pm_type = ?,
					pm_resourceserver = ?,
					pm_file = ?,
					pm_moreurl = ?,
					pm_caption = ?,
					pm_alt = ?,
					pm_titleseo = ?,
					pm_countview = ?,
					pm_displayorder = ?,
					pm_status = ?,
					pm_datecreated = ?,
					pm_datemodified = ?
				WHERE pm_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(int)$this->type,
					(int)$this->resourceserver,
					(string)$this->file,
					(string)$this->moreurl,
					(string)$this->caption,
					(string)$this->alt,
					(string)$this->titleseo,
					(int)$this->countview,
					(int)$this->displayorder,
					(int)$this->status,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			if(strlen($_FILES['ffile']['name'][$this->mediaorder]) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage();

                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                {
                	return false;
                }
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                            SET pm_file = ?,
                            	pm_resourceserver = 0
                            WHERE pm_id = ?';
                    $result=$this->db->query($sql, array($this->file, $this->id));
                    if(!$result)
                    	return false;
					else
						return true;
                }
            }

			/*if(strlen($_FILES['ffile360']['name'][$this->mediaorder]) > 0)
            {
                //upload image
                $uploadImageResult = $this->uploadImage('ffile360');
                if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
                {
                	return false;
                }
                elseif($this->file != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                            SET pm_file = ?
                            WHERE pm_id = ?';
                    $result=$this->db->query($sql, array($this->fileurl, $this->id));
					$this->fileurl = '';
                    if(!$result)
                    	return false;
					else
						return true;
                }
            }*/
            //set to download from remote image, do like amazon add
			if(strlen($this->fileurl) > 0 && strpos($this->fileurl, 'http') === 0)
	        {
	            $originalImagePath = $this->fileurl;

		        $url = getimagesize($originalImagePath);

                if(is_array($url))
                {
                	$curDateDir = Helper::getCurrentDateDirName();
	                $extPart = substr(strrchr($originalImagePath,'.'),1);
	                /*$namePart =  Helper::codau2khongdau($this->type, true) . '-' . $this->id . time();*/
	                $namePart = end(array_reverse(explode('.', end(explode('/', $this->fileurl)))));
	                $name = $namePart . '.' . $extPart;
	                $fullpath = $registry->setting['product']['imageDirectory'] . $curDateDir . $name;

	                //check existed directory
	                if(!file_exists($registry->setting['product']['imageDirectory'] . $curDateDir))
	                {
	                    mkdir($registry->setting['product']['imageDirectory'] . $curDateDir, 0777, true);
	                }


	                if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
	                {
	                    //Resize big image if needed
	                    $myImageResizer = new ImageResizer( $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                        $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                        $registry->setting['product']['imageMaxWidth'],
	                                                        $registry->setting['product']['imageMaxHeight'],
	                                                        '',
	                                                        $registry->setting['product']['imageQuality']);
	                    $myImageResizer->output();
	                    unset($myImageResizer);

	                    //Create thumb image
	                    $nameThumbPart = substr($name, 0, strrpos($name, '.'));
	                    $nameThumb = $nameThumbPart . '-small.' . $extPart;
	                    $myImageResizer = new ImageResizer(    $registry->setting['product']['imageDirectory'] . $curDateDir, $name,
	                                                            $registry->setting['product']['imageDirectory'] . $curDateDir, $nameThumb,
	                                                            $registry->setting['product']['imageThumbWidth'],
	                                                            $registry->setting['product']['imageThumbHeight'],
	                                                            '',
	                                                            $registry->setting['product']['imageQuality']);
	                    $myImageResizer->output();
	                    unset($myImageResizer);
	                    //update database
	                    $this->fileurl = $curDateDir . $name;
	                    $this->smallImage = $curDateDir . $nameThumb;
	                    $this->updateImage();
	                }

                }
                else
                {
                	$this->delete();
                }

			}

            return true;
		}
		else
			return false;
	}

    public function updateDataWithoutUploadImage()
    {
        $this->datemodified = time();
        global $registry;

        $sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                SET u_id = ?,
                    p_id = ?,
                    pm_type = ?,
                    pm_resourceserver = ?,
                    pm_file = ?,
                    pm_moreurl = ?,
                    pm_caption = ?,
                    pm_alt = ?,
                    pm_titleseo = ?,
                    pm_countview = ?,
                    pm_displayorder = ?,
                    pm_status = ?,
                    pm_datecreated = ?,
                    pm_datemodified = ?
                WHERE pm_id = ?';

        $stmt = $this->db->query($sql, array(
                    (int)$this->uid,
                    (int)$this->pid,
                    (int)$this->type,
                    (int)$this->resourceserver,
                    (string)$this->file,
                    (string)$this->moreurl,
                    (string)$this->caption,
                    (string)$this->alt,
                    (string)$this->titleseo,
                    (int)$this->countview,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_media pm
				WHERE pm.pm_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->id = $row['pm_id'];
		$this->type = $row['pm_type'];
		$this->resourceserver = $row['pm_resourceserver'];
		$this->file = $row['pm_file'];
		$this->moreurl = $row['pm_moreurl'];
		$this->caption = $row['pm_caption'];
		$this->alt = $row['pm_alt'];
		$this->titleseo = $row['pm_titleseo'];
		$this->countview = $row['pm_countview'];
		$this->displayorder = $row['pm_displayorder'];
		$this->status = $row['pm_status'];
		$this->datecreated = $row['pm_datecreated'];
		$this->datemodified = $row['pm_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_media
				WHERE pm_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();
		$this->deleteImage();
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_media pm';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_media pm';

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
			$myProductMedia = new Core_ProductMedia();

			$myProductMedia->uid = $row['u_id'];
			$myProductMedia->pid = $row['p_id'];
			$myProductMedia->id = $row['pm_id'];
			$myProductMedia->type = $row['pm_type'];
			$myProductMedia->resourceserver = $row['pm_resourceserver'];
			$myProductMedia->file = $row['pm_file'];
			$myProductMedia->moreurl = $row['pm_moreurl'];
			$myProductMedia->caption = $row['pm_caption'];
			$myProductMedia->alt = $row['pm_alt'];
			$myProductMedia->titleseo = $row['pm_titleseo'];
			$myProductMedia->countview = $row['pm_countview'];
			$myProductMedia->displayorder = $row['pm_displayorder'];
			$myProductMedia->status = $row['pm_status'];
			$myProductMedia->datecreated = $row['pm_datecreated'];
			$myProductMedia->datemodified = $row['pm_datemodified'];


            $outputList[] = $myProductMedia;
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
	public static function getProductMedias($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_id = '.(int)$formData['fid'].' ';

		if($formData['ffilenotnull'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_file !="" ';


        if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_type = '.(int)$formData['ftype'].' ';

		if($formData['fdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_displayorder = '.(int)$formData['fdisplayorder'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_status = '.(int)$formData['fstatus'].' ';

		if(isset($formData['fresourceserver']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if(isset($formData['fhasfile']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'pm.pm_file != "" ';



		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'pm_id ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 'pm_countview ' . $sorttype;
		elseif($sortby == 'displayorder')
			$orderString = 'pm_displayorder ' . $sorttype;
		else
			$orderString = 'pm_displayorder ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(pm_displayorder) FROM ' . TABLE_PREFIX . 'product_media WHERE p_id = ' . (int)$this->pid .' AND pm_type = ' . (int)$this->type;

		return (int)$this->db->query($sql)->fetchColumn(0);
	}

	public static function getMediaType()
	{
		$output = array();

		$output[self::TYPE_FILE] = 'File';
		$output[self::TYPE_URL]  = 'YouTube URL';

		return $output;
	}

	public function getMediaName()
	{
		$name = '';

		switch($this->type)
		{
			case self::TYPE_FILE: $name = 'File'; break;
			case self::TYPE_URL: $name = 'YouTube URL'; break;
		}

		return $name;
	}

	public function checkMediaName($name)
	{
		$name = strtolower($this->name);
		if($this->status == self::TYPE_FILE && $name == 'file' || $this->status == self::TYPE_URL && $name == 'youtube url')
			return true;
		else
			return false;
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

	public function uploadImage($filepath = '')
    {
        global $registry;
        $file = ($filepath != '') ? 'ffile360' : 'ffile';
        $curDateDir = Helper::getCurrentDateDirName();
        /*$namePart =  Helper::codau2khongdau($this->type, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;*/
        $extPart = end(explode('.',$_FILES['ffile']['name'][$this->mediaorder]));
        if($this->type == Core_ProductMedia::TYPE_360)
        {
        	$namePart = substr($_FILES['ffile']['name'][$this->mediaorder] , 0 , strrpos($_FILES[$file]['name'][$this->mediaorder] , '.'));
        }
        else if($this->type == Core_ProductMedia::TYPE_FILE)
	    {
	    	$myProduct = new Core_Product($this->pid);
        	$namePart = Helper::codau2khongdau($myProduct->name,true,true) . $myProduct->id . time();
	    }

	    $name = $namePart . '.' . $extPart;

        $uploader = new Uploader($_FILES['ffile']['tmp_name'][$this->mediaorder], $name, $registry->setting['productmedia']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);

        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['productmedia']['imageMaxWidth'],
                                                $registry->setting['productmedia']['imageMaxHeight'],
                                                '',
                                                $registry->setting['productmedia']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

			//Create medium image
            $nameMediumPart = substr($name, 0, strrpos($name, '.'));
            $nameMedium = $nameMediumPart . '-medium.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $nameMedium,
                                                $registry->setting['productmedia']['imageMediumWidth'],
                                                $registry->setting['productmedia']['imageMediumHeight'],
                                                '',
                                                $registry->setting['productmedia']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['productmedia']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['productmedia']['imageThumbWidth'],
                                                $registry->setting['productmedia']['imageThumbHeight'],
                                                $registry->setting['productmedia']['imageThumbRatio'],
                                                $registry->setting['productmedia']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //update database
            $this->file = $curDateDir . $name;
        }
    }

    public function deleteImage($imagepath = '')
    {
        global $registry;

        //delete current image
        if($imagepath == '')
            $deletefile = $this->file;
		else
            $deletefile = $imagepath;

        if(strlen($deletefile) > 0)
        {
            $file = $registry->setting['productmedia']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
	            $pos = strrpos($deletefile, '.');
				$extPart = substr($deletefile, $pos+1);
				$namePart =  substr($deletefile,0, $pos);

				$deletesmallimage = $namePart . '-small.' . $extPart;
				$file = $registry->setting['productmedia']['imageDirectory'] . $deletesmallimage;
	            if(file_exists($file) && is_file($file))
	                @unlink($file);

				$deletemediumimage = $namePart . '-medium.' . $extPart;
				$file = $registry->setting['productmedia']['imageDirectory'] . $deletemediumimage;
	            if(file_exists($file) && is_file($file))
	                @unlink($file);
			}

            //delete current image
            if($imagepath == '')
                $this->file = '';
        }
    }

    public function getSmallImage()
	{
		global $registry;

		$pos = strrpos($this->file, '.');
		$extPart = substr($this->file, $pos+1);
		$namePart =  substr($this->file,0, $pos);
		$filesmall = $namePart . '-small.' . $extPart;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'productmedia') . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['productmedia']['imageDirectory'] . $filesmall;
		}


		return $url;
	}

	public function getMediumImage()
	{
		/*global $registry;

		$pos = strrpos($this->file, '.');
		$extPart = substr($this->file, $pos+1);
		$namePart =  substr($this->file,0, $pos);
		$filemedium = $namePart . '-medium.' . $extPart;
		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'productmedia') . $filemedium;
		}
		else
		{
			$url = ResourceServer::getUrl($this->resourceserver) . $registry->setting['productmedia']['imageDirectory'] . $filemedium;
		}*/
		global $registry;

		$pos = strrpos($this->file, '.');
		$extPart = substr($this->file, $pos+1);
		$namePart =  substr($this->file,0, $pos);
		$filemedium = $namePart . '-medium.' . $extPart;
		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'productmedia') . $this->file;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['productmedia']['imageDirectory'] . $this->file;
		}
		return $url;
	}

	public function getImage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'productmedia') . $this->file;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['productmedia']['imageDirectory'] . $this->file;
		}

		return $url;
	}

	public function getPhotoPath()
	{
		global $registry;

		$slug = Helper::codau2khongdau($this->title, true, true);

		$url = ResourceServer::getUrl($this->resourceserver) . $slug . '-' . $this->id;
		return $url;
	}

	public function updateImage()
    {
		global $registry;

		//get the ratio between width and height
		//read image information

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_media
                SET pm_file = ?,
                	pm_resourceserver = 0
                WHERE pm_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->fileurl,
                (int)$this->id
            ));
        return $stmt;
    }


    public function checkimagevalid($imagepath)
    {
        $pass = true;

		$file_headers = @get_headers($imagepath);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found')
		{
		    $pass = false;
		}
		else if($file_headers[0] == 'HTTP/1.1 403 Forbidden')
		{
			$pass = false;
		}
		else
		{
		    $pass = true;
		}

        return $pass;
    }

}
