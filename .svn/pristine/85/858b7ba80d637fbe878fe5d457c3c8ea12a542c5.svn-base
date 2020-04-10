<?php

/**
 * core/class.stuff.php
 *
 * File contains the class used for Stuff Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Stuff extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

    const IS_VIP = 1;
    const IS_SMS = 1;
	const IS_NORMAL = 0;

	const TYPE_SELL = 1;
	const TYPE_BUY = 2;

	public $uid = 0;
	public $pid = 0;
	public $scid = 0;
	public $id = 0;
	public $type = 0;
	public $issms = 0;
	public $isvip = 0;
	public $image = "";
	public $title = "";
	public $slug = "";
	public $content = "";
	public $price = 0;
	public $contactname = "";
	public $contactemail = "";
	public $contactphone = "";
	public $seotitle = "";
	public $seokeyword = "";
	public $seodescription = "";
	public $regionid = 0;
	public $districtid = 0;
	public $countview = 0;
	public $countreview = 0;
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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'stuff (
					u_id,
					p_id,
					sc_id,
					s_type,
					s_issms,
					s_isvip,
					s_image,
					s_title,
					s_slug,
					s_content,
					s_price,
					s_contactname,
					s_contactemail,
					s_contactphone,
					s_seotitle,
					s_seokeyword,
					s_seodescription,
					s_regionid,
					s_districtid,
					s_countview,
					s_countreview,
					s_status,
					s_ipaddress,
					s_datecreated,
					s_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(int)$this->scid,
					(int)$this->type,
					(int)$this->issms,
					(int)$this->isvip,
					(string)$this->image,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(float)$this->price,
					(string)$this->contactname,
					(string)$this->contactemail,
					(string)$this->contactphone,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(int)$this->regionid,
					(int)$this->districtid,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->status,
					(int)$this->ipaddress,
					(int)$this->datecreated,
					(int)$this->datemodified
					))->rowCount();

		$this->id = $this->db->lastInsertId();

		//update Slug
		if($this->slug == '')
			$this->slug = Helper::codau2khongdau($this->title, true, true) . '-' . $this->id;

		$sqlupdate = 'UPDATE ' . TABLE_PREFIX . 'stuff
						SET s_slug = "' . $this->slug . '"
						WHERE s_id = ' . $this->id . '';

		$this->db->query($sqlupdate);

		//insert vao table Slug
		$slugObject = new Core_Slug();
		$slugObject->slug = $this->slug;
		$slugObject->controller = 'stuff';
		$slugObject->objectid = $this->id;
		$slugObject->addData();


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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
                            SET s_image = ?,
                            	s_resourceserver = 0
                            WHERE s_id = ?';
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
				SET u_id = ?,
					p_id = ?,
					sc_id = ?,
					s_type = ?,
					s_issms = ?,
					s_isvip = ?,
					s_image = ?,
					s_title = ?,
					s_slug = ?,
					s_content = ?,
					s_price = ?,
					s_contactname = ?,
					s_contactemail = ?,
					s_contactphone = ?,
					s_seotitle = ?,
					s_seokeyword = ?,
					s_seodescription = ?,
					s_regionid = ?,
					s_districtid = ?,
					s_countview = ?,
					s_countreview = ?,
					s_status = ?,
					s_ipaddress = ?,
					s_resourceserver = ?,
					s_datecreated = ?,
					s_datemodified = ?
				WHERE s_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->pid,
					(int)$this->scid,
					(int)$this->type,
					(int)$this->issms,
					(int)$this->isvip,
					(string)$this->image,
					(string)$this->title,
					(string)$this->slug,
					(string)$this->content,
					(float)$this->price,
					(string)$this->contactname,
					(string)$this->contactemail,
					(string)$this->contactphone,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(int)$this->regionid,
					(int)$this->districtid,
					(int)$this->countview,
					(int)$this->countreview,
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
                            SET s_image = ?,
                            	s_resourceserver = 0
                            WHERE s_id = ?';
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff s
				WHERE s.s_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->scid = $row['sc_id'];
		$this->id = $row['s_id'];
		$this->type = $row['s_type'];
		$this->issms = $row['s_issms'];
		$this->isvip = $row['s_isvip'];
		$this->image = $row['s_image'];
		$this->title = $row['s_title'];
		$this->slug = $row['s_slug'];
		$this->content = $row['s_content'];
		$this->price = $row['s_price'];
		$this->contactname = $row['s_contactname'];
		$this->contactemail = $row['s_contactemail'];
		$this->contactphone = $row['s_contactphone'];
		$this->seotitle = $row['s_seotitle'];
		$this->seokeyword = $row['s_seokeyword'];
		$this->seodescription = $row['s_seodescription'];
		$this->regionid = $row['s_regionid'];
		$this->districtid = $row['s_districtid'];
		$this->countview = $row['s_countview'];
		$this->countreview = $row['s_countreview'];
		$this->status = $row['s_status'];
		$this->ipaddress = $row['s_ipaddress'];
		$this->resourceserver = $row['s_resourceserver'];
		$this->datecreated = $row['s_datecreated'];
		$this->datemodified = $row['s_datemodified'];

	}

	public function getDataByArray($row)
	{
		$this->uid = $row['u_id'];
		$this->pid = $row['p_id'];
		$this->scid = $row['sc_id'];
		$this->id = $row['s_id'];
		$this->type = $row['s_type'];
		$this->issms = $row['s_issms'];
		$this->isvip = $row['s_isvip'];
		$this->image = $row['s_image'];
		$this->title = $row['s_title'];
		$this->slug = $row['s_slug'];
		$this->content = $row['s_content'];
		$this->price = $row['s_price'];
		$this->contactname = $row['s_contactname'];
		$this->contactemail = $row['s_contactemail'];
		$this->contactphone = $row['s_contactphone'];
		$this->seotitle = $row['s_seotitle'];
		$this->seokeyword = $row['s_seokeyword'];
		$this->seodescription = $row['s_seodescription'];
		$this->regionid = $row['s_regionid'];
		$this->districtid = $row['s_districtid'];
		$this->countview = $row['s_countview'];
		$this->countreview = $row['s_countreview'];
		$this->status = $row['s_status'];
		$this->ipaddress = $row['s_ipaddress'];
		$this->resourceserver = $row['s_resourceserver'];
		$this->datecreated = $row['s_datecreated'];
		$this->datemodified = $row['s_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'stuff
				WHERE s_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'stuff s';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff s';

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
			$myStuff = new Core_Stuff();

			$myStuff->uid = $row['u_id'];
			$myStuff->pid = $row['p_id'];
			$myStuff->scid = $row['sc_id'];
			$myStuff->id = $row['s_id'];
			$myStuff->type = $row['s_type'];
			$myStuff->issms = $row['s_issms'];
			$myStuff->isvip = $row['s_isvip'];
			$myStuff->image = self::checkImage($row['s_image']);
			$myStuff->title = $row['s_title'];
			$myStuff->slug = $row['s_slug'];
			$myStuff->content = $row['s_content'];
			$myStuff->price = Helper::formatPrice($row['s_price']);
			$myStuff->contactname = $row['s_contactname'];
			$myStuff->contactemail = $row['s_contactemail'];
			$myStuff->contactphone = $row['s_contactphone'];
			$myStuff->seotitle = $row['s_seotitle'];
			$myStuff->seokeyword = $row['s_seokeyword'];
			$myStuff->seodescription = $row['s_seodescription'];
			$myStuff->regionid = $row['s_regionid'];
			$myStuff->districtid = $row['s_districtid'];
			$myStuff->countview = $row['s_countview'];
			$myStuff->countreview = $row['s_countreview'];
			$myStuff->status = $row['s_status'];
			$myStuff->ipaddress = $row['s_ipaddress'];
			$myStuff->resourceserver = $row['s_resourceserver'];
			$myStuff->datecreated = $row['s_datecreated'];
			$myStuff->datemodified = $row['s_datemodified'];


            $outputList[] = $myStuff;
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
	public static function getStuffs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fuid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.u_id = '.(int)$formData['fuid'].' ';

		if($formData['fpid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.p_id = '.(int)$formData['fpid'].' ';

		if($formData['fscid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_id = '.(int)$formData['fscid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_id = '.(int)$formData['fid'].' ';

		if($formData['ftype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_type = '.(int)$formData['ftype'].' ';

		if($formData['fissms'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_issms = '.(int)$formData['fissms'].' ';

		if($formData['fisvip'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_isvip = '.(int)$formData['fisvip'].' ';

		if($formData['fregionid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_regionid = '.(int)$formData['fregionid'].' ';

		if($formData['fdistrictid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_districtid = '.(int)$formData['fdistrictid'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_status = '.(int)$formData['fstatus'].' ';

		if($formData['ftimestampstart'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_datecreated >= '.(int)$formData['ftimestampstart'].' ';

		if($formData['ftimestampend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_datecreated <= '.(int)$formData['ftimestampend'].' ';

		if(isset($formData['fresourceserver']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if(isset($formData['fhasimage']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_image != "" ';

		if(count($formData['fscidarr']) > 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 's.sc_id IN ('.implode(',', $formData['fscidarr']).') ';
		}

		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'content')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_content LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'contactname')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_contactname LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'contactemail')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_contactemail LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'contactphone')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 's.s_contactphone LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (s.s_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.s_content LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.s_contactname LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.s_contactemail LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (s.s_contactphone LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'type')
			$orderString = 's_type ' . $sorttype;
		elseif($sortby == 'issms')
			$orderString = 's_issms ' . $sorttype;
		elseif($sortby == 'isvip')
			$orderString = 's_isvip ' . $sorttype;
		elseif($sortby == 'countview')
			$orderString = 's_countview ' . $sorttype;
		elseif($sortby == 'countreview')
			$orderString = 's_countreview ' . $sorttype;
		elseif($sortby == 'datecreated')
			$orderString = 's_datecreated ' . $sorttype;
		else
			$orderString = 's_id ' . $sorttype;

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

        $output[self::TYPE_SELL] = 'Cần bán';
        $output[self::TYPE_BUY] = 'Cần mua';

        return $output;
    }

    public function getTypeName()
    {
    	$name = '';

    	switch($this->type)
        {
            case self::TYPE_SELL: $name = 'Sell'; break;
            case self::TYPE_BUY: $name = 'Buy'; break;
        }

        return $name;
    }

    public function checkTypeName($name)
    {
        $name = strtolower($name);

        if($this->type == self::TYPE_SELL && $name == 'sell' || $this->type == self::TYPE_BUY && $name == 'buy')
            return true;
        else
            return false;
    }

    public static function getVipList()
    {
        $output = array();

        $output[self::IS_NORMAL] = 'Normal';
        $output[self::IS_VIP] = 'Vip';

        return $output;
    }

	public function getVipName()
    {
    	$name = '';

    	switch($this->isvip)
        {
            case self::IS_VIP: $name = 'YES'; break;
            case self::IS_NORMAL: $name = 'NO'; break;
        }

        return $name;
    }

    public function checkVipName($name)
    {
    	$name = strtolower($name);

        if($this->isvip == self::IS_VIP && $name == 'vip' || $this->isvip == self::IS_NORMAL && $name == 'normal')
            return true;
        else
            return false;
    }

    public function getSMSName()
    {
    	$name = '';

    	switch($this->issms)
        {
            case self::IS_SMS: $name = 'YES'; break;
            case self::IS_NORMAL: $name = 'NO'; break;
        }

        return $name;
    }

    public function checkSMSName($name)
    {
    	$name = strtolower($name);

        if($this->issms == self::IS_SMS && $name == 'sms' || $this->issms == self::IS_NORMAL && $name == 'normal')
            return true;
        else
            return false;
    }

    public function getRegionName($id)
    {
        $myRegion = new Core_Region($id);

        return $myRegion->name;
    }

    public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->title, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['stuff']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['stuff']['imageMaxWidth'],
                                                $registry->setting['stuff']['imageMaxHeight'],
                                                '',
                                                $registry->setting['stuff']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);


            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['stuff']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['stuff']['imageThumbWidth'],
                                                $registry->setting['stuff']['imageThumbHeight'],
                                                $registry->setting['stuff']['imageThumbRatio'],
                                                $registry->setting['stuff']['imageQuality']);
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
            $file = $registry->setting['stuff']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['stuff']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['stuff']['imageDirectory'] . $deletemediumimage;
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
			$url = ResourceServer::getUrl($this->resourceserver) . 'stuff/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['stuff']['imageDirectory'] . $filesmall;
		}


        return $url;
    }


    public function getImage()
    {
        global $registry;


  		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'stuff/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['stuff']['imageDirectory'] . $this->image;
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
	    $fullpath = $registry->setting['stuff']['imageDirectory'] . $curDateDir . $name;

	    //check existed directory
	    if(!file_exists($registry->setting['stuff']['imageDirectory'] . $curDateDir))
	    {
			mkdir($registry->setting['stuff']['imageDirectory'] . $curDateDir, 0777, true);
	    }

	    $originalImagePath = Helper::refineRemoteCoverPath($originalImagePath);

        if(Helper::saveExternalFile($originalImagePath, $fullpath, 'image'))
        {
			//Resize big image if needed
	        $myImageResizer = new ImageResizer( $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
	                                            $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
	                                            $registry->setting['stuff']['imageMaxWidth'],
	                                            $registry->setting['stuff']['imageMaxHeight'],
	                                            '',
	                                            $registry->setting['stuff']['imageQuality']);
	        $myImageResizer->output();
	        unset($myImageResizer);

	        //Create thumb image
	        $nameThumbPart = substr($name, 0, strrpos($name, '.'));
	        $nameThumb = $nameThumbPart . '-small.' . $extPart;
	        $myImageResizer = new ImageResizer(    $registry->setting['stuff']['imageDirectory'] . $curDateDir, $name,
		                                            $registry->setting['stuff']['imageDirectory'] . $curDateDir, $nameThumb,
		                                            $registry->setting['stuff']['imageThumbWidth'],
		                                            $registry->setting['stuff']['imageThumbHeight'],
		                                            '',
		                                            $registry->setting['stuff']['imageQuality']);
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
			$coverpath = $registry->setting['stuff']['imageDirectory'] . $this->image;
		}

		$sql = 'UPDATE ' . TABLE_PREFIX . 'stuff
                SET s_image = ?
                WHERE s_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->id
            ));

        return $stmt;
    }

   	public function getStuffPath()
   	{
   		global $registry;

   		$path = $registry->conf['rooturl'];

   		if($this->id > 0)
   		{
   			if($this->slug != '')
   			{
   				$category = new Core_Stuffcategory($this->scid, true);

   				$path .= $category->slug . '/' . $this->slug . '-rao-vat-' . $this->id;
   			}
   			else
   			{
   				$path .= 'site/stuff/detail?id=' . $this->id;
   			}

   		}


   		return $path;
   	}

   	static function checkImage($imagepath)
   	{
   		global $registry;

   		$rooturl = $registry->conf['rooturl'];

   		if(preg_match('#^:;#', $imagepath))
   			return '';
   		else
   			return $imagepath;
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
		return 'stuff_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myStuff = new Core_Stuff();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'stuff
					WHERE s_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['s_id'] > 0)
			{
				$myStuff->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myStuff->getDataByArray($row);
		}

		return $myStuff;
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