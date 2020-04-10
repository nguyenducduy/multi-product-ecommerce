<?php

/**
 * core/class.vendor.php
 *
 * File contains the class used for Vendor Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Vendor extends Core_Object
{

	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;

	const TYPE_VENDOR = 0;
	const TYPE_SUBVENDOR = 10;

	public $id             = 0;
	public $image          = "";
	public $resourceserver = 0;
	public $name           = "";
	public $slug           = "";
	public $content        = "";
	public $insurance      = ""; //cot nay chua thong tin mo ngan cua vendor trong trang detail
	public $type           = 0;
	public $status         = 0;
	public $topseokeyword  = "";
	public $seotitle       = "";
	public $seodescription = "";
	public $seokeyword     = "";
	public $metarobot      = "";
    public $titlecol1      = "";
    public $desccol1       = "";
    public $titlecol2      = "";
    public $desccol2       = "";
    public $titlecol3      = "";
    public $desccol3       = "";
	public $countproduct   = 0;
	public $displayorder   = 0;
	public $datecreated    = 0;
	public $datemodified   = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'vendor (
					v_image,
					v_resourceserver,
					v_name,
					v_slug,
					v_content,
					v_insurance,
					v_type,
					v_status,
					v_topseokeyword,
					v_seotitle,
					v_seodescription,
					v_seokeyword,
					v_metarobot,
					v_titlecol1,
					v_desccol1,
					v_titlecol2,
					v_desccol2,
					v_titlecol3,
					v_desccol3,
					v_countproduct,
					v_displayorder,
					v_datecreated,
					v_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->image,
					(int)$this->resourceserver,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->insurance,
					(int)$this->type,
					(int)$this->status,
					(string)$this->topseokeyword,
					(string)$this->seotitle,
					(string)$this->seodescription,
					(string)$this->seokeyword,
					(string)$this->metarobot,
                    (string)$this->titlecol1,
                    (string)$this->desccol1,
                    (string)$this->titlecol2,
                    (string)$this->desccol2,
                    (string)$this->titlecol3,
                    (string)$this->desccol3,
					(int)$this->countproduct,
					(int)$this->displayorder,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'vendor
                            SET v_image = ?,
                            	v_resourceserver = 0
                            WHERE v_id = ?';
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'vendor
				SET v_image = ?,
					v_resourceserver = ?,
					v_name = ?,
					v_slug = ?,
					v_content = ?,
					v_insurance = ?,
					v_type = ?,
					v_status = ?,
					v_topseokeyword = ?,
					v_seotitle = ?,
					v_seodescription = ?,
					v_seokeyword = ?,
					v_metarobot = ?,
					v_titlecol1 = ?,
					v_desccol1 = ?,
					v_titlecol2 = ?,
					v_desccol2 = ?,
					v_titlecol3 = ?,
					v_desccol3 = ?,
					v_countproduct = ?,
					v_displayorder = ?,
					v_datecreated = ?,
					v_datemodified = ?
				WHERE v_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->image,
					(int)$this->resourceserver,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->insurance,
					(int)$this->type,
					(int)$this->status,
					(string)$this->topseokeyword,
					(string)$this->seotitle,
					(string)$this->seodescription,
					(string)$this->seokeyword,
					(string)$this->metarobot,
                    (string)$this->titlecol1,
                    (string)$this->desccol1,
                    (string)$this->titlecol2,
                    (string)$this->desccol2,
                    (string)$this->titlecol3,
                    (string)$this->desccol3,
					(int)$this->countproduct,
					(int)$this->displayorder,
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
                {
                	return false;
                }
                elseif($this->image != '')
                {
                    //update source
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'vendor
                            SET v_image = ?,
                             	v_resourceserver = 0
                            WHERE v_id = ?';
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'vendor v
				WHERE v.v_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id             = $row['v_id'];
		$this->image          = $row['v_image'];
		$this->resourceserver = $row['v_resourceserver'];
		$this->name           = $row['v_name'];
		$this->slug           = $row['v_slug'];
		$this->content        = $row['v_content'];
		$this->insurance      = $row['v_insurance'];
		$this->type           = $row['v_type'];
		$this->status         = $row['v_status'];
		$this->topseokeyword  = $row['v_topseokeyword'];
		$this->seotitle  = $row['v_seotitle'];
		$this->seokeyword = $row['v_seokeyword'];
		$this->seodescription = $row['v_seodescription'];
		$this->metarobot = $row['v_metarobot'];
        $this->titlecol1      = $row['v_titlecol1'];
        $this->desccol1       = $row['v_desccol1'];
        $this->titlecol2      = $row['v_titlecol2'];
        $this->desccol2       = $row['v_desccol2'];
        $this->titlecol3      = $row['v_titlecol3'];
        $this->desccol3       = $row['v_desccol3'];
		$this->countproduct   = $row['v_countproduct'];
		$this->displayorder   = $row['v_displayorder'];
		$this->datecreated    = $row['v_datecreated'];
		$this->datemodified   = $row['v_datemodified'];

	}


	public function getDataByArray($row)
	{
		$this->id             = $row['v_id'];
		$this->image          = $row['v_image'];
		$this->resourceserver = $row['v_resourceserver'];
		$this->name           = $row['v_name'];
		$this->slug           = $row['v_slug'];
		$this->content        = $row['v_content'];
		$this->insurance      = $row['v_insurance'];
		$this->type           = $row['v_type'];
		$this->status         = $row['v_status'];
		$this->topseokeyword  = $row['v_topseokeyword'];
		$this->seotitle  = $row['v_seotitle'];
		$this->seokeyword = $row['v_seokeyword'];
		$this->seodescription = $row['v_seodescription'];
		$this->metarobot = $row['v_metarobot'];
        $this->titlecol1      = $row['v_titlecol1'];
        $this->desccol1       = $row['v_desccol1'];
        $this->titlecol2      = $row['v_titlecol2'];
        $this->desccol2       = $row['v_desccol2'];
        $this->titlecol3      = $row['v_titlecol3'];
        $this->desccol3       = $row['v_desccol3'];
		$this->countproduct   = $row['v_countproduct'];
		$this->displayorder   = $row['v_displayorder'];
		$this->datecreated    = $row['v_datecreated'];
		$this->datemodified   = $row['v_datemodified'];

	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'vendor
				WHERE v_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'vendor v';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'vendor v';

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
			$myVendor                 = new Core_Vendor();

			$myVendor->id             = $row['v_id'];
			$myVendor->image          = $row['v_image'];
			$myVendor->resourceserver = $row['v_resourceserver'];
			$myVendor->name           = $row['v_name'];
			$myVendor->slug           = $row['v_slug'];
			$myVendor->content        = $row['v_content'];
			$myVendor->insurance      = $row['v_insurance'];
			$myVendor->type           = $row['v_type'];
			$myVendor->status         = $row['v_status'];
			$myVendor->topseokeyword  = $row['v_topseokeyword'];
			$myVendor->seotitle  = $row['v_seotitle'];
			$myVendor->seokeyword = $row['v_seokeyword'];
			$myVendor->seodescription = $row['v_seodescription'];
			$myVendor->metarobot = $row['v_metarobot'];
            $myVendor->titlecol1      = $row['v_titlecol1'];
            $myVendor->desccol1       = $row['v_desccol1'];
            $myVendor->titlecol2      = $row['v_titlecol2'];
            $myVendor->desccol2       = $row['v_desccol2'];
            $myVendor->titlecol3      = $row['v_titlecol3'];
            $myVendor->desccol3       = $row['v_desccol3'];
			$myVendor->countproduct   = $row['v_countproduct'];
			$myVendor->displayorder   = $row['v_displayorder'];
			$myVendor->datecreated    = $row['v_datecreated'];
			$myVendor->datemodified   = $row['v_datemodified'];


            $outputList[] = $myVendor;
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
	public static function getVendors($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_id = '.(int)$formData['fid'].' ';

		if(is_array($formData['fidin']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_id IN ("'.implode('","',$formData['fidin']).'") ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_status = '.(int)$formData['fstatus'].' ';

		if(isset($formData['ftype']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_type = '.(int)$formData['ftype'].' ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['fslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';
		if($formData['fslugarr'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_slug IN ("'.implode('","',$formData['fslugarr']).'") ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'slug')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_slug LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (v.v_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (v.v_slug LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

        if(strlen($formData['fkeywordFilterCharacter']) > 0 ){
            $formData['fkeywordFilterCharacter'] = Helper::unspecialtext($formData['fkeywordFilterCharacter']);

            if($formData['fsearchKeywordIn'] == 'name')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_name LIKE \''.$formData['fkeywordFilterCharacter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'slug')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_slug LIKE \''.$formData['fkeywordFilterCharacter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (v.v_name LIKE \''.$formData['fkeywordFilterCharacter'].'%\') OR (v.v_slug LIKE \''.$formData['fkeywordFilterCharacter'].'%\') )';

        }

		if(isset($formData['fresourceserver']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if(isset($formData['fhasimage']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'v.v_image != "" ';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'v_id ' . $sorttype;
		elseif($sortby == 'name')
			$orderString = 'v_name,v_displayorder ' . $sorttype;
		elseif($sortby == 'slug')
			$orderString = 'v_slug,v_displayorder ' . $sorttype;
        elseif($sortby == 'displayorder')
            $orderString = 'v_displayorder ' . $sorttype;
		else
			$orderString = 'v_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(v_displayorder) FROM ' . TABLE_PREFIX . 'vendor';
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

	public static function getVendorTypeList()
	{
		$output = array();

		$output[self::TYPE_VENDOR] = 'Nhà cung cấp';
		$output[self::TYPE_SUBVENDOR] = 'Nhà phân phối';

		return $output;
	}

	public function getVendorName()
	{
		$name = '';
		switch ($this->type)
		{
			case self::TYPE_VENDOR : $name = 'Nhà cung cấp';
				break;

			case self::TYPE_SUBVENDOR : $name = 'Nhà phân phối';
				break;
		}

		return $name;
	}

	public function checkTypeVendorName($name)
	{
		$name = strtolower($name);

		if($this->status == self::TYPE_VENDOR && $name == 'nhà cung cấp' || $this->status == self::TYPE_SUBVENDOR && $name == 'nhà phân phối')
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
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['vendor']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['vendor']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['vendor']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['vendor']['imageMaxWidth'],
                                                $registry->setting['vendor']['imageMaxHeight'],
                                                '',
                                                $registry->setting['vendor']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);


            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['vendor']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['vendor']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['vendor']['imageThumbWidth'],
                                                $registry->setting['vendor']['imageThumbHeight'],
                                                $registry->setting['vendor']['imageThumbRatio'],
                                                $registry->setting['vendor']['imageQuality']);
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
            $file = $registry->setting['vendor']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
	            $pos = strrpos($deletefile, '.');
				$extPart = substr($deletefile, $pos+1);
				$namePart =  substr($deletefile,0, $pos);

				$deletesmallimage = $namePart . '-small.' . $extPart;
				$file = $registry->setting['vendor']['imageDirectory'] . $deletesmallimage;
	            if(file_exists($file) && is_file($file))
	                @unlink($file);

				$deletemediumimage = $namePart . '-medium.' . $extPart;
				$file = $registry->setting['vendor']['imageDirectory'] . $deletemediumimage;
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
			$url = ResourceServer::getUrl($this->resourceserver) . 'vendor/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['vendor']['imageDirectory'] . $filesmall;
		}


		return $url;
	}


	public function getImage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'vendor/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['vendor']['imageDirectory'] . $this->image;
		}


		return $url;
	}

	public function getPhotoPath()
	{
		global $registry;

		$slug = Helper::codau2khongdau($this->title, true, true);

		$url = $registry->conf['rooturl'] . $slug . '-' . $this->id;
		return $url;
	}

   	public static function getVendorByProductcategory($formData , $order = '')
   	{
   		global $db;
   		if($formData['fpcid'] > 0)
   		{
   			$sql = 'SELECT DISTINCT(v.v_id) , v.v_name , v.v_displayorder
   					FROM ' . TABLE_PREFIX . 'vendor v
   					INNER JOIN ' . TABLE_PREFIX . 'product p ON v.v_id = p.v_id
   					INNER JOIN ' . TABLE_PREFIX . 'productcategory pc ON pc.pc_id = p.pc_id
   					WHERE pc.pc_id = ' . (int)$formData['fpcid'];
   			if($order != '')
   				$sql .= ' ORDER BY ' . $order;


   			$outputList = array();
   			$stmt = $db->query($sql);
   			while ($row = $stmt->fetch())
   			{
   				$myVendor = new Core_Vendor();
   				$myVendor->id = $row['v_id'];
   				$myVendor->name = $row['v_name'];
   				$myVendor->displayorder = $row['v_displayorder'];

   				$outputList[] = $myVendor;
   			}

   			return $outputList;
   		}
   	}

	public function getVendorPath($categoryId = 0)
	{
		global $registry;

		$url = $registry->conf['rooturl'];
		//No product category filtering
		if($categoryId > 0)
		{
			$myCategory = new Core_Productcategory($categoryId);
			if($myCategory->id > 0)
			{
				$url .= $myCategory->slug . '/';
			}
		}

		$url .= $this->slug;
		return $url;
	}

	public static function getVendorByProductcategoryFromCache($categoryId)
	{
		global $conf;
        $outputList = array();
		if($categoryId > 0)
		{
			$myCacher = new Cacher('vendor:list_' . $categoryId ,  Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$data = $myCacher->get();

			if($data != false)
			{
				$dataarr = explode('#', $data);
				foreach ($dataarr as $info)
				{
					$infoarr = explode(':', $info);
					$outputList[$infoarr[0]] = $infoarr[1];
				}
			}
		}

		return $outputList;
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
		return 'v_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myVendor = new Core_Vendor();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceSet)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'vendor
					WHERE v_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['v_id'] > 0)
			{
				$myVendor->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myVendor->getDataByArray($row);
		}

		return $myVendor;
	}

	public static function getProductVendorFromCache($pcid = 0 , $vendorid = 0, $getall = false)
	{
	  	$result = array();
	  	$myCacher = new Cacher('pvc_list' , Cacher::STORAGE_MEMCACHED);
	  	//$myCacher = new Cacher('pvc_list' , Cacher::STORAGE_REDIS , 86400 *2);
		$data = $myCacher->get();
		if($data != false)
		{
		  	$vendorlist = json_decode($data , true);
		  	if($getall)
			{
			  	$result = $vendorlist;
			}
			else
			{
			  	if($pcid > 0)
				{
				  	foreach($vendorlist as $catid =>  $datavalue)
					{
					  	if($pcid == $catid)
						{
						  	foreach($datavalue as $vid =>  $productlist)
							{
							  	if($vendorid > 0)
								{
								  	if($vendorid == $vid)
									{
									  	$result[$catid][$vid] = $productlist;
									}
								}
								else
								{
								  	$result[$catid][$vid] = $productlist;
								}
							}
						}
					}
				}
			}
		}
		return $result;
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

