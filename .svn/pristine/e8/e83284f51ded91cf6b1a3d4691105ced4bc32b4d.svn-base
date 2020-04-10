<?php

/**
 * core/class.ads.php
 *
 * File contains the class used for Ads Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Ads extends Core_Object
{
	const TYPE_BANNER = 1;
	const TYPE_TEXTICON = 3;
	const TYPE_TEXTONLY = 5;

	const GROUPDISPLAYTYPE_SINGLE = 1;
	const GROUPDISPLAYTYPE_ROTATION = 3;
	const GROUPDISPLAYTYPE_LISTING = 5;

	const LINKTARGET_BLANK = 1;
	const LINKTARGET_SELF = 3;
	const LINKTARGET_PARENT = 5;

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 3;
	const STATUS_EXPIRED = 5;

	const PRODUCT_LINK_HORIZOTAL = 14;
	const PRODUCT_LINK_VERTICAL = 15;

	public $azid = 0;
	public $id = 0;
	public $type = 0;
	public $name = "";
	public $link = "";
	public $image = "";
	public $resourceserver = 0;
	public $title = "";
	public $summary = "";
	public $width = 0;
	public $height = 0;
	public $campaign = "";
	public $campaignsource = "";
	public $campaignmedium = "";
    public $group = "";
    public $parent = "";
    public $objcategory = "";
	public $countsubads = 0;
	public $groupdisplaytype = 0;
	public $groupdisplayorder = 0;
	public $linktarget = 0;
	public $isinternal = 0;
	public $payperclick = 0;
	public $impression = 0;
	public $click = 0;
	public $status = 0;
    public $displayorder = 0;
	public $datebegin = 0;
	public $dateend = 0;
	public $datecreated = 0;
	public $datemodified = 0;

    public function __construct($id = 0)
	{
		parent::__construct();

		if($id > 0)
			$this->getData($id);
	}


    //Ham upload anh
    //Da kiem tra co anh roi!!!
    public function uploadImage()
    {
        global $registry;


        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . '-' . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['ads']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {

            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['ads']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['ads']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['ads']['imageMaxWidth'],
                                                $registry->setting['ads']['imageMaxHeight'],
                                                '',
                                                $registry->setting['ads']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

			//Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['ads']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['ads']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['ads']['imageThumbWidth'],
                                                $registry->setting['ads']['imageThumbHeight'],
                                                '',
                                                $registry->setting['ads']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);


            //update database
            $this->image = $curDateDir . $name;

			//reset resource server
			$this->resourceserver = 0;
        }
    }


	/**
	 * Insert object data to database
	 * @return int The inserted record primary key
	 */
    public function addData()
    {
		$this->datecreated = time();


		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'ads (
					az_id,
					a_type,
					a_name,
					a_link,
					a_image,
					a_resourceserver,
					a_title,
					a_summary,
					a_width,
					a_height,
					a_campaign,
					a_campaignsource,
					a_campaignmedium,
                    a_group,
					a_parent,
					a_groupdisplaytype,
					a_groupdisplayorder,
					a_linktarget,
					a_isinternal,
					a_payperclick,
					a_impression,
					a_click,
					a_status,
					a_displayorder,
					a_datebegin,
					a_dateend,
					a_datecreated,
					a_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->azid,
					(int)$this->type,
					(string)$this->name,
					(string)$this->link,
					(string)$this->image,
					(int)$this->resourceserver,
					(string)$this->title,
					(string)$this->summary,
					(int)$this->width,
					(int)$this->height,
					(string)$this->campaign,
					(string)$this->campaignsource,
					(string)$this->campaignmedium,
                    (string)$this->group,
					(string)$this->parent,
					(int)$this->groupdisplaytype,
					(int)$this->groupdisplayorder,
					(int)$this->linktarget,
					(int)$this->isinternal,
					(float)$this->payperclick,
					(int)$this->impression,
					(int)$this->click,
					(int)$this->status,
                    (int)$this->displayorder,
					(int)$this->datebegin,
					(int)$this->dateend,
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

	            //demo only
	            $this->updateImage();

	            //demo only
	            return true;
	            /*
	            if($uploadImageResult != Uploader::ERROR_UPLOAD_OK)
	                return false;
	            else if($this->image != '')
	            {
	                if(!$this->updateImage())
	                    return false;
	            }
	            */
	        }

		}

		return $this->id;
	}

	public function updateImage()
    {
		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads
                SET a_image = ?,
					a_resourceserver = ?
                WHERE a_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->resourceserver,
                (int)$this->id
            ));

        //Xu ly anh
        if($stmt)
        	return true;
		else
			return false;
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
            $file = $registry->setting['ads']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
	            $pos = strrpos($deletefile, '.');
				$extPart = substr($deletefile, $pos+1);
				$namePart =  substr($deletefile,0, $pos);

				$deletesmallimage = $namePart . '-small.' . $extPart;
				$file = $registry->setting['ads']['imageDirectory'] . $deletesmallimage;
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
			$url = ResourceServer::getUrl($this->resourceserver) . 'asimg/' . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['ads']['imageDirectory'] . $filesmall;
		}


		return $url;
	}

	public function getImage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver) . 'asimg/' . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['ads']['imageDirectory'] . $this->image;
		}
		return $url;
	}

	/**
	 * Update database
	 *
	 * @return boolean Indicate query success or not
	 */
	public function updateData()
	{
		$this->datemodified = time();


		$sql = 'UPDATE ' . TABLE_PREFIX . 'ads
				SET az_id = ?,
					a_type = ?,
					a_name = ?,
					a_link = ?,
					a_image = ?,
					a_resourceserver = ?,
					a_title = ?,
					a_summary = ?,
					a_width = ?,
					a_height = ?,
					a_campaign = ?,
					a_campaignsource = ?,
					a_campaignmedium = ?,
                    a_group = ?,
					a_parent = ?,
					a_groupdisplaytype = ?,
					a_groupdisplayorder = ?,
					a_linktarget = ?,
					a_isinternal = ?,
					a_payperclick = ?,
					a_impression = ?,
					a_click = ?,
					a_status = ?,
					a_displayorder = ?,
					a_datebegin = ?,
					a_dateend = ?,
					a_datecreated = ?,
					a_datemodified = ?
				WHERE a_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->azid,
					(int)$this->type,
					(string)$this->name,
					(string)$this->link,
					(string)$this->image,
					(int)$this->resourceserver,
					(string)$this->title,
					(string)$this->summary,
					(int)$this->width,
					(int)$this->height,
					(string)$this->campaign,
					(string)$this->campaignsource,
					(string)$this->campaignmedium,
                    (string)$this->group,
					(string)$this->parent,
					(int)$this->groupdisplaytype,
					(int)$this->groupdisplayorder,
					(int)$this->linktarget,
					(int)$this->isinternal,
					(float)$this->payperclick,
					(int)$this->impression,
					(int)$this->click,
					(int)$this->status,
                    (int)$this->displayorder,
					(int)$this->datebegin,
					(int)$this->dateend,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads a
				WHERE a.a_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->azid = $row['az_id'];
		$this->id = $row['a_id'];
		$this->type = $row['a_type'];
		$this->name = $row['a_name'];
		$this->link = $row['a_link'];
		$this->image = $row['a_image'];
		$this->resourceserver = $row['a_resourceserver'];
		$this->title = $row['a_title'];
		$this->summary = $row['a_summary'];
		$this->width = $row['a_width'];
		$this->height = $row['a_height'];
		$this->campaign = $row['a_campaign'];
		$this->campaignsource = $row['a_campaignsource'];
		$this->campaignmedium = $row['a_campaignmedium'];
        $this->group = $row['a_group'];

        if($this->group > 0) {
            $this->objcategory = new Core_Productcategory($this->group);
        }

        if($this->parent == 0){
            $this->countsubads = self::getAdss(array('fparent' => $this->id),'','','', true);
        }
		$this->parent = $row['a_parent'];
		$this->groupdisplaytype = $row['a_groupdisplaytype'];
		$this->groupdisplayorder = $row['a_groupdisplayorder'];
		$this->linktarget = $row['a_linktarget'];
		$this->isinternal = $row['a_isinternal'];
		$this->payperclick = $row['a_payperclick'];
		$this->impression = $row['a_impression'];
		$this->click = $row['a_click'];
		$this->status = $row['a_status'];
        $this->displayorder = $row['a_displayorder'];
		$this->datebegin = $row['a_datebegin'];
		$this->dateend = $row['a_dateend'];
		$this->datecreated = $row['a_datecreated'];
		$this->datemodified = $row['a_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'ads
				WHERE a_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ads a';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'ads a';

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
			$myAds = new Core_Ads();

			$myAds->azid = $row['az_id'];
			$myAds->id = $row['a_id'];
			$myAds->type = $row['a_type'];
			$myAds->name = $row['a_name'];
			$myAds->link = $row['a_link'];
			$myAds->image = $row['a_image'];
			$myAds->resourceserver = $row['a_resourceserver'];
			$myAds->title = $row['a_title'];
			$myAds->summary = $row['a_summary'];
			$myAds->width = $row['a_width'];
			$myAds->height = $row['a_height'];
			$myAds->campaign = $row['a_campaign'];
			$myAds->campaignsource = $row['a_campaignsource'];
			$myAds->campaignmedium = $row['a_campaignmedium'];
            $myAds->group = $row['a_group'];
			$myAds->parent = $row['a_parent'];
			$myAds->groupdisplaytype = $row['a_groupdisplaytype'];
			$myAds->groupdisplayorder = $row['a_groupdisplayorder'];
			$myAds->linktarget = $row['a_linktarget'];
			$myAds->isinternal = $row['a_isinternal'];
			$myAds->payperclick = $row['a_payperclick'];
			$myAds->impression = $row['a_impression'];
			$myAds->click = $row['a_click'];
			$myAds->status = $row['a_status'];
            $myAds->displayorder = $row['a_displayorder'];
			$myAds->datebegin = $row['a_datebegin'];
			$myAds->dateend = $row['a_dateend'];
			$myAds->datecreated = $row['a_datecreated'];
			$myAds->datemodified = $row['a_datemodified'];

            if($myAds->group > 0) {
                $myAds->objcategory = new Core_Productcategory($myAds->group);
            }

            if($myAds->parent == 0){
                $myAds->countsubads = self::getAdss(array('fparent' => $myAds->id),'','','', true);
            }

            $outputList[] = $myAds;
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
	public static function getAdss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fazid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.az_id = '.(int)$formData['fazid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_id = '.(int)$formData['fid'].' ';

		if(count($formData['fidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_id IN ('.implode(',',$formData['fidarr']).') ';

        if($formData['ftype'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_type = '.(int)$formData['ftype'].' ';

		if(isset($formData['fresourceserver']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_resourceserver = '.(int)$formData['fresourceserver'].' ';

		if(isset($formData['fparent']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_parent = '.(int)$formData['fparent'].' ';

		if(isset($formData['fparentgreater0']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_parent >0 ';

        if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

		if($formData['ftitle'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_title = "'.Helper::unspecialtext((string)$formData['ftitle']).'" ';

		if($formData['fsummary'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_summary = "'.Helper::unspecialtext((string)$formData['fsummary']).'" ';

		if($formData['fcampaign'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaign = "'.Helper::unspecialtext((string)$formData['fcampaign']).'" ';

		if($formData['fcampaignsource'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaignsource = "'.Helper::unspecialtext((string)$formData['fcampaignsource']).'" ';

		if($formData['fcampaignmedium'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaignmedium = "'.Helper::unspecialtext((string)$formData['fcampaignmedium']).'" ';

		if($formData['fgroup'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_group = "'.Helper::unspecialtext((string)$formData['fgroup']).'" ';

        if(!empty($formData['fgrouparr']) && count($formData['fgrouparr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_group IN('.implode(',',$formData['fgrouparr']).')';

		if(isset($formData['fisactive']))
        {
            $wheredate = ($whereString != '' ? ' AND ' : '');
            $wheredate .= '((a.a_status = '.(int)Core_Ads::STATUS_ENABLE.'
                           AND a.a_datebegin <= '.(int)time().'
                           AND a.a_dateend >= '.(int)time().'
                          ) OR (
                           a.a_datebegin = 0
                           AND a.a_dateend >= '.(int)time().'
                          ) OR (
                           a.a_datebegin <= '.(int)time().'
                           AND a.a_dateend = 0
                          ) OR (
                            a.a_datebegin = 0
                            AND a.a_dateend = 0
                          ) ) AND a.a_status = '.(int)self::STATUS_ENABLE;
            $whereString .= $wheredate;
        }

        if($formData['fgroupdisplaytype'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_groupdisplaytype = '.(int)$formData['fgroupdisplaytype'].' ';

		if($formData['fgroupdisplayorder'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_groupdisplayorder = '.(int)$formData['fgroupdisplayorder'].' ';

		if($formData['flinktarget'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_linktarget = '.(int)$formData['flinktarget'].' ';

		if($formData['fisinternal'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_isinternal = '.(int)$formData['fisinternal'].' ';

		if($formData['fimpression'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_impression = '.(int)$formData['fimpression'].' ';

		if($formData['fclick'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_click = '.(int)$formData['fclick'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_status = '.(int)$formData['fstatus'].' ';

		if($formData['fdatebegin'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_datebegin = '.(int)$formData['fdatebegin'].' ';

		if($formData['fdateend'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_dateend = '.(int)$formData['fdateend'].' ';



		if(strlen($formData['fkeywordFilter']) > 0)
		{
			$formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

			if($formData['fsearchKeywordIn'] == 'name')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'title')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_title LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'summary')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_summary LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'campaign')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaign LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'campaignsource')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaignsource LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'campaignmedium')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaignmedium LIKE \'%'.$formData['fkeywordFilter'].'%\'';
			elseif($formData['fsearchKeywordIn'] == 'group')
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_group LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            elseif($formData['fsearchKeywordIn'] == 'slug')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_id IN ('.implode(',',$formData['fslug']).') ';
			else
				$whereString .= ($whereString != '' ? ' AND ' : '') . '( (a.a_name LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_title LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_summary LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_campaign LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_campaignsource LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_campaignmedium LIKE \'%'.$formData['fkeywordFilter'].'%\') OR (a.a_group LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
		}

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'a_id ' . $sorttype;
		elseif($sortby == 'groupdisplayorder')
			$orderString = 'a_groupdisplayorder ' . $sorttype;
		elseif($sortby == 'payperclick')
			$orderString = 'a_payperclick ' . $sorttype;
		elseif($sortby == 'impression')
			$orderString = 'a_impression ' . $sorttype;
		elseif($sortby == 'click')
			$orderString = 'a_click ' . $sorttype;
        elseif($sortby == 'displayorder')
            $orderString = 'a_displayorder ' . $sorttype;
		else
			$orderString = 'a_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}


	public static function getTypeList()
	{
		$output = array();

		$output[self::TYPE_BANNER] = 'BANNER IMAGE';
        $output[self::TYPE_TEXTICON] = 'BANNER TEXT ICON';
        $output[self::TYPE_TEXTONLY] = 'BANNER TEXT ONLY';

		return $output;
	}


	public function checkTypeName($name)
	{
		$name = strtolower($name);

		return ($name == 'banner' && $this->type == self::TYPE_BANNER ||
			$name == 'texticon' && $this->type == self::TYPE_TEXTICON ||
			$name == 'textonly' && $this->type == self::TYPE_TEXTONLY
			);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLE] = 'Disabled';
		//$output[self::STATUS_EXPIRED] = 'Expired';

		return $output;
	}

	public function checkStatusName($name)
	{
		$name = strtolower($name);

		return ($name == 'enable' && $this->status == self::STATUS_ENABLE ||
			$name = 'disable' && $this->status == self::STATUS_DISABLE ||
			$name = 'expired' && $this->status == self::STATUS_EXPIRED
		);

	}

	public function getAdsPath()
	{
		global $registry;

		$slug = '';
		if($this->title != '')
			$slug = Helper::codau2khongdau($this->title, true, true);
		else
			$slug = Helper::codau2khongdau($this->name, true, true);

		$url = $registry->conf['rooturl'] . $slug . '-a' . $this->id;
		return $url;
	}

	public static function getBannerListByProuctId($pid, $type)
	{
		if ($pid <= 0 || $type == '') return array();
		$whereString = '';
		$fazid = 14;//Product Link Horizontal, 15: Product Link Vertical
		if($type == 'v')
		{
			$fazid = 15;
		}
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.az_id = '.(int)$fazid.' ';
		$whereString .= ($whereString != '' ? ' AND ' : '') . 'a.a_campaign = "'.(int)$pid.'" ';
		$whereString .= ($whereString != '' ? ' AND ' : '') . '((a.a_status = '.(int)Core_Ads::STATUS_ENABLE.'
                       AND a.a_datebegin <= '.(int)time().'
                       AND a.a_dateend >= '.(int)time().'
                      ) OR (
                       a.a_datebegin = 0
                       AND a.a_dateend >= '.(int)time().'
                      ) OR (
                       a.a_datebegin <= '.(int)time().'
                       AND a.a_dateend = 0
                      ) OR (
                        a.a_datebegin = 0
                        AND a.a_dateend = 0
                      ) ) AND a.a_status = '.(int)self::STATUS_ENABLE;

		$orderString = 'a_id DESC';

		return self::getList($whereString, $orderString, '');
	}

}