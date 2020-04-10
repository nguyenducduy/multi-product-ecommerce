<?php

/**
 * core/class.product.php
 *
 * File contains the class used for Product Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Product extends Core_Object
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLED = 2;
	const STATUS_DELETED = 3;

	const STATUS_SYNC_FOUND = 100;
	const STATUS_SYNC_NOTFOUND = 101;
	const STATUS_SYNC_LOCALONLY = 102;

    const CUSTOMIZETYPE_MAIN = 10;
    const CUSTOMIZETYPE_COLOR = 20;
    const CUSTOMIZETYPE_OLD = 30;

    const OS_NOSELL = 0;
    const OS_ERP_PREPAID = 2;
    const OS_DM_PREPAID = 4;
    const OS_ERP = 6;
    const OS_DM = 8;
    const OS_COMMINGSOON = 10;
    const OS_NEWARRIVAL = 12;
    const OS_CLEARSTOCK = 14;
    const OS_SHOWROOM = 16;
    const OS_ONLINEONY = 18;
    const OS_HOT = 20;
    const OS_NEW = 22;
    const OS_BESTSELLER = 24;
    const OS_CRAZYSALE = 26;
    const OS_DOANGIA = 27;

    const BS_DEFAULT = 0;
    const BS_KEYONLINE = 9;
    const BS_NOSELL = 10;
    const BS_CLEARSTOCK = 11;
    const BS_ONLINESTOCK = 12;
    const BS_BUSSINESSNORMAL = 13;
  	const BS_TEMPORALITYOUTOFSTOCK = 14;
  	const BS_KEYSUPERMARTKETANDONLINE = 15;
  	const BS_MULTIFORMAT = 16;
  	const BS_ONLINEOUTOFSTOCK = 21;
  	const BS_COMINGSOON = 22;

    const TRANSPORT_NO = 0;
    const TRANSPORT_DEFAULT = 1;

    const SETUP_NO = 0;
    const SETUP_DEFAULT = 1;

    const KEYTYPE_KEY = 200;
    const KEYTYPE_CLEARSTOCK = 210;

    const DISPLAY_NORMAL = 0;
    const DISPLAY_TEXT = 1;
    const DISPLAY_BANNER = 2;

	public $uid                = 0;
	public $vid                = 0;
	public $vsubid             = 0;
	public $pcid               = 0;
	public $id                 = 0;
	public $image              = '';
	public $resourceserver     = 0;
	public $barcode            = "";
	public $name               = "";
	public $slug               = "";
	public $content            = "";
	public $summary            = "";
	public $summarynew         = "";
	public $good               = '';
	public $bad                = '';
	public $dienmayreview      = '';
	public $fullbox            = '';
	public $laigopauto         = 0;
	public $laigop             = 0;
	public $seotitle           = "";
	public $seokeyword         = "";
	public $seodescription     = "";
	public $canonical          = "";
	public $metarobot          = "";
	public $topseokeyword      = "";
	public $textfooter         = "";
	public $unitprice          = 0;
	public $sellprice          = 0;
	public $finalprice         = 0;
	public $productaward       = 0;
	public $promotionlist      = "";
	public $applypromotionlist = "";
	public $vendorprice        = 0;
	public $discountpercent    = 0;
	public $isbagdehot         = 0;
	public $isbagdenew         = 0;
	public $isbagdegift        = 0;
	public $instock            = 0;
	public $countview          = 0;
	public $countreview        = 0;
	public $countrating        = 0;
	public $averagerating      = 0;
	public $counthumbup        = 0;
	public $view1              = 0;
	public $view7              = 0;
	public $view15             = 0;
	public $view30             = 0;
	public $sell1              = 0;
	public $sell7              = 0;
	public $sell15             = 0;
	public $sell30             = 0;
	public $status             = 0;
	public $syncstatus         = 0;
	public $onsitestatus       = 0;
	public $businessstatus     = 0;
	public $keytype            = 0;
	public $customizetype      = 0;
	public $colorlist          = "";
	public $fullboxshort       = "";
	public $warranty           = 0;
	public $transporttype      = 0;
	public $setuptype          = 0;
	public $width              = 0;
	public $length             = 0;
	public $height             = 0;
	public $weight             = 0;
	public $displaytype        = 0;
	public $ipaddress          = 0;
	public $datedeleted        = 0;
	public $datelastsync       = 0;
	public $prepaidprice       = 0;
	public $prepaidstartdate   = 0;
	public $prepaidenddate     = 0;
	public $prepaidname        = "";
	public $prepaidpromotion   = "";
	public $prepaidpolicy      = "";
	public $prepaidrand        = 0;
	public $prepaiddepositrequire = 0;
	public $comingsoonprice    = 0;
	public $comingsoondate	   = "";
	public $isrequestimei      = 0;
	public $isservice		   = 0;
	public $vat				   = 0;
	public $importdate         = 0;
	public $datecreated        = 0;
	public $datemodified       = 0;
	public $rppdisplayorder    = 0;
	public $slugcategory       = '';
	public $displayorder       = 0 ;
	public $displaymanual       = 0 ;
	public $displaypriceorder  = 0;
	public $displaysellprice   = 0;
	public $enddate            = 0;
	public $categoryactor      = null;
	public $productmainlink = '';

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
		global $registry;

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product (
					u_id,
					v_id,
					v_subid,
					pc_id,
                    p_image,
                    p_resourceserver,
					p_barcode,
					p_name,
					p_slug,
					p_content,
					p_summary,
                    p_summarynew,
					p_good,
					p_bad,
					p_dienmayreview,
					p_fullbox,
					p_laigopauto,
					p_laigop,
					p_seotitle,
					p_seokeyword,
					p_seodescription,
					p_canonical,
					p_metarobot,
					p_topseokeyword,
					p_textfooter,
					p_unitprice,
					p_sellprice,
					p_finalprice,
					p_productaward,
					p_promotionlist,
					p_applypromotionlist,
					p_vendorprice,
					p_discountpercent,
					p_isbagdehot,
					p_isbagdenew,
					p_isbagdegift,
					p_instock,
					p_countview,
					p_countreview,
					p_countrating,
                    p_averagerating,
                    p_countthumbup,
					p_view1,
                    p_view7,
                    p_view15,
                    p_view30,
					p_sell1,
                    p_sell7,
                    p_sell15,
                    p_sell30,
					p_displayorder,
					p_displaymanual,
					p_displaypriceorder,
					p_displaysellprice,
                    p_status,
                    p_syncstatus,
                    p_onsitestatus,
                    p_businessstaus,
                    p_keytype,
                    p_customizetype,
                    p_colorlist,
                    p_fullbox_short,
                    p_warranty,
                    p_transporttype,
                    p_setuptype,
                    p_width,
                    p_height,
                    p_length,
                    p_weight,
                    p_displaytype,
					p_ipaddress,
					p_datedeleted,
					p_datelastsync,
					p_prepaidprice,
					p_prepaidstartdate,
					p_prepaidenddate,
					p_prepaidname,
					p_prepaidpromotion,
					p_prepaidpolicy,
					p_prepaidrand,
					p_prepaiddepositrequire,
					p_comingsoonprice,
					p_comingsoondate,
					p_isrequestimei,
					p_isservice,
					p_vat,
					p_importdate,
					p_datecreated,
					p_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->vid,
					(int)$this->vsubid,
					(int)$this->pcid,
                    (string)$this->image,
                    (int)$this->resourceserver,
					(string)$this->barcode,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->summary,
					(string)$this->summarynew,
					(string)$this->good,
					(string)$this->bad,
					(string)$this->dienmayreview,
					(string)$this->fullbox,
					(float)$this->laigopauto,
					(float)$this->laigop,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->canonical,
					(string)$this->metarobot,
					(string)$this->topseokeyword,
					(string)$this->textfooter,
					(float)$this->unitprice,
					(float)$this->sellprice,
					(float)$this->finalprice,
					(float)$this->productaward,
					(string)$this->promotionlist,
					(string)$this->applypromotionlist,
					(float)$this->vendorprice,
					(int)$this->discountpercent,
					(int)$this->isbagdehot,
					(int)$this->isbagdenew,
					(int)$this->isbagdegift,
					(int)$this->instock,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->countrating,
                    (float)$this->averagerating,
                    (int)$this->countthumbup,
					(int)$this->view1,
                    (int)$this->view7,
                    (int)$this->view15,
                    (int)$this->view30,
					(int)$this->sell1,
                    (int)$this->sell7,
                    (int)$this->sell15,
                    (int)$this->sell30,
					(int)$this->displayorder,
					(int)$this->displaymanual,
					(int)$this->displaypriceorder,
					(int)$this->displaysellprice,
                    (int)$this->status,
                    (int)$this->syncstatus,
                    (int)$this->onsitestatus,
                    (int)$this->businessstatus,
                    (int)$this->keytype,
                    (int)$this->customizetype,
                    (string)$this->colorlist,
                    (string)$this->fullboxshort,
                    (int)$this->warranty,
                    (int)$this->transporttype,
                    (int)$this->setuptype,
                    (float)$this->width,
                    (float)$this->height,
                    (float)$this->length,
                    (float)$this->weight,
                    (int)$this->displaytype,
					(int)$this->ipaddress,
					(int)$this->datedeleted,
					(int)$this->datelastsync,
					(float)$this->prepaidprice,
					(int)$this->prepaidstartdate,
					(string)$this->prepaidname,
					(string)$this->prepaidpromotion,
					(string)$this->prepaidpolicy,
					(int)$this->prepaidrand,
					(float)$this->prepaiddepositrequire,
					(float)$this->comingsoonprice,
					(string)$this->comingsoondate,
					(int)$this->prepaidenddate,
					(int)$this->isrequestimei,
					(int)$this->isservice,
					(int)$this->vat,
					(int)$this->importdate,
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                            SET p_image = ?,
                            	p_resourceserver = 0
                            WHERE p_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
                    if(!$result)
                    	return false;
                }
            }
			elseif(strpos($this->image, 'http') === 0)//set to download from remote image, do like amazon add
	        {
	            $originalImagePath = $this->image;

		        $curDateDir = Helper::getCurrentDateDirName();
			    $extPart = substr(strrchr($originalImagePath,'.'),1);
			    $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
			    $name = $namePart . '.' . $extPart;
			    $fullpath = $registry->setting['product']['imageDirectory'] . $curDateDir . $name;

			    //check existed directory
			    if(!file_exists($registry->setting['product']['imageDirectory'] . $curDateDir))
			    {
					mkdir($registry->setting['product']['imageDirectory'] . $curDateDir, 0777, true);
			    }

			    $originalImagePath = Helper::refineRemoteCoverPath($originalImagePath);

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
			        $this->image = $curDateDir . $name;
			        $this->smallImage = $curDateDir . $nameThumb;
			        $this->updateImage();
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
		global $registry;

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product
				SET u_id = ?,
					v_id = ?,
					v_subid = ?,
					pc_id = ?,
                    p_image = ?,
                    p_resourceserver = ?,
					p_barcode = ?,
					p_name = ?,
					p_slug = ?,
					p_content = ?,
					p_summary = ?,
                    p_summarynew = ?,
					p_good = ?,
					p_bad = ?,
					p_dienmayreview = ?,
					p_fullbox = ?,
					p_laigopauto = ?,
					p_laigop = ?,
					p_seotitle = ?,
					p_seokeyword = ?,
					p_seodescription = ?,
					p_canonical = ?,
					p_metarobot = ?,
					p_topseokeyword = ?,
					p_textfooter = ?,
					p_unitprice = ?,
					p_sellprice = ?,
					p_finalprice = ?,
					p_productaward = ?,
					p_promotionlist = ?,
					p_applypromotionlist = ?,
					p_vendorprice = ?,
					p_discountpercent = ?,
					p_isbagdehot = ?,
					p_isbagdenew = ?,
					p_isbagdegift = ?,
					p_instock = ?,
					p_countview = ?,
					p_countreview = ?,
					p_countrating = ?,
                    p_averagerating = ?,
                    p_countthumbup = ?,
					p_view1 = ?,
                    p_view7 = ?,
                    p_view15 = ?,
                    p_view30 = ?,
					p_sell1 = ?,
                    p_sell7 = ?,
                    p_sell15 = ?,
                    p_sell30 = ?,
					p_displayorder = ?,
					p_displaymanual = ?,
					p_displaypriceorder = ?,
					p_displaysellprice = ?,
                    p_status = ?,
                    p_syncstatus = ?,
                    p_onsitestatus = ?,
                    p_businessstaus = ?,
                    p_keytype = ?,
                    p_customizetype = ?,
                    p_colorlist = ?,
                    p_fullbox_short = ?,
                    p_warranty = ?,
                    p_transporttype = ?,
                    p_setuptype = ?,
                    p_width = ?,
                    p_height = ?,
                    p_length = ?,
                    p_weight = ?,
                    p_displaytype = ?,
					p_ipaddress = ?,
					p_datedeleted = ?,
					p_datelastsync = ?,
					p_prepaidprice = ?,
					p_prepaidstartdate = ?,
					p_prepaidenddate =?,
					p_prepaidname = ?,
					p_prepaidpromotion = ?,
					p_prepaidpolicy = ?,
					p_prepaidrand = ?,
					p_prepaiddepositrequire = ?,
					p_comingsoonprice = ?,
					p_comingsoondate = ?,
					p_isrequestimei = ?,
					p_isservice = ?,
					p_vat = ?,
					p_importdate = ?,
					p_datecreated = ?,
					p_datemodified = ?
				WHERE p_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->vid,
					(int)$this->vsubid,
					(int)$this->pcid,
                    (string)$this->image,
                    (int)$this->resourceserver,
					(string)$this->barcode,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->summary,
					(string)$this->summarynew,
					(string)$this->good,
					(string)$this->bad,
					(string)$this->dienmayreview,
					(string)$this->fullbox,
					(float)$this->laigopauto,
					(float)$this->laigop,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->canonical,
					(string)$this->metarobot,
					(string)$this->topseokeyword,
					(string)$this->textfooter,
					(float)$this->unitprice,
					(float)$this->sellprice,
					(float)$this->finalprice,
					(float)$this->productaward,
					(string)$this->promotionlist,
					(string)$this->applypromotionlist,
					(float)$this->vendorprice,
					(int)$this->discountpercent,
					(int)$this->isbagdehot,
					(int)$this->isbagdenew,
					(int)$this->isbagdegift,
					(int)$this->instock,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->countrating,
                    (int)$this->averagerating,
                    (int)$this->countthumbup,
					(int)$this->view1,
                    (int)$this->view7,
                    (int)$this->view15,
                    (int)$this->view30,
					(int)$this->sell1,
                    (int)$this->sell7,
                    (int)$this->sell15,
                    (int)$this->sell30,
					(int)$this->displayorder,
					(int)$this->displaymanual,
					(int)$this->displaypriceorder,
					(int)$this->displaysellprice,
                    (int)$this->status,
                    (int)$this->syncstatus,
                    (int)$this->onsitestatus,
                    (int)$this->businessstatus,
                    (int)$this->keytype,
                    (int)$this->customizetype,
                    (string)$this->colorlist,
                    (string)$this->fullboxshort,
                    (int)$this->warranty,
                    (int)$this->transporttype,
                    (int)$this->setuptype,
                    (float)$this->width,
                    (float)$this->height,
                    (float)$this->length,
                    (float)$this->weight,
                    (int)$this->displaytype,
					(int)$this->ipaddress,
					(int)$this->datedeleted,
					(int)$this->datelastsync,
					(float)$this->prepaidprice,
					(int)$this->prepaidstartdate,
					(int)$this->prepaidenddate,
					(string)$this->prepaidname,
					(string)$this->prepaidpromotion,
					(string)$this->prepaidpolicy,
					(int)$this->prepaidrand,
					(float)$this->prepaiddepositrequire,
					(float)$this->comingsoonprice,
					(string)$this->comingsoondate,
					(int)$this->isrequestimei,
					(int)$this->isservice,
					(int)$this->vat,
					(int)$this->importdate,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(int)$this->id
					));

		if($stmt)
		{
			//xoa cache html product  detail
			$this->clearCache();

			//Xoa cache object
			self::cacheClear($this->id);

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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                            SET p_image = ?,
                            	p_resourceserver = 0
                            WHERE p_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
                    if(!$result)
                    	return false;
                    else
                        $this->resourceserver = 0;
                }
            }
			elseif(strpos($this->image, 'http') === 0)//set to download from remote image, do like amazon add
	        {
	            $originalImagePath = $this->image;

		        $curDateDir = Helper::getCurrentDateDirName();
			    $extPart = substr(strrchr($originalImagePath,'.'),1);
			    $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
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
			        $this->image = $curDateDir . $name;
			        $this->smallImage = $curDateDir . $nameThumb;
			        $this->updateImage();
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product p
				WHERE p.p_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid                = $row['u_id'];
		$this->vid                = $row['v_id'];
		$this->vsubid             = $row['v_subid'];
		$this->pcid               = $row['pc_id'];
		$this->id                 = $row['p_id'];
		$this->image              = $row['p_image'];
		$this->resourceserver     = $row['p_resourceserver'];
		$this->barcode            = $row['p_barcode'];
		$this->name               = $row['p_name'];
		$this->slug               = $row['p_slug'];
		$this->content            = $row['p_content'];
		$this->summary            = $row['p_summary'];
		$this->summarynew         = $row['p_summarynew'];
		$this->good               = $row['p_good'];
		$this->bad                = $row['p_bad'];
		$this->dienmayreview      = $row['p_dienmayreview'];
		$this->fullbox            = $row['p_fullbox'];
		$this->laigopauto         = $row['p_laigopauto'];
		$this->laigop             = $row['p_laigop'];
		$this->seotitle           = $row['p_seotitle'];
		$this->seokeyword         = $row['p_seokeyword'];
		$this->seodescription     = $row['p_seodescription'];
		$this->canonical          = $row['p_canonical'];
		$this->metarobot          = $row['p_metarobot'];
		$this->topseokeyword      = $row['p_topseokeyword'];
		$this->textfooter         = $row['p_textfooter'];
		$this->unitprice          = $row['p_unitprice'];
		$this->sellprice          = $row['p_sellprice'];
		$this->finalprice         = $row['p_finalprice'];
		$this->productaward       = $row['p_productaward'];
		$this->promotionlist      = $row['p_promotionlist'];
		$this->applypromotionlist = $row['p_applypromotionlist'];
		$this->vendorprice        = $row['p_vendorprice'];
		$this->discountpercent    = $row['p_discountpercent'];
		$this->isbagdehot         = $row['p_isbagdehot'];
		$this->isbagdenew         = $row['p_isbagdenew'];
		$this->isbagdegift        = $row['p_isbagdegift'];
		$this->instock            = $row['p_instock'];
		$this->countview          = $row['p_countview'];
		$this->countreview        = $row['p_countreview'];
		$this->countrating        = $row['p_countrating'];
		$this->averagerating      = $row['p_averagerating'];
		$this->countthumbup       = $row['p_countthumbup'];
		$this->view1              = $row['p_view1'];
		$this->view7              = $row['p_view7'];
		$this->view15             = $row['p_view15'];
		$this->view30             = $row['p_view30'];
		$this->sell1              = $row['p_sell1'];
		$this->sell7              = $row['p_sell7'];
		$this->sell15             = $row['p_sell15'];
		$this->sell30             = $row['p_sell30'];
		$this->displayorder       = $row['p_displayorder'];
		$this->displaymanual      = $row['p_displaymanual'];
		$this->displaypriceorder  = $row['p_displaypriceorder'];
		$this->displaysellprice   = $row['p_displaysellprice'];
		$this->status             = $row['p_status'];
		$this->syncstatus         = $row['p_syncstatus'];
		$this->onsitestatus       = $row['p_onsitestatus'];
		$this->businessstatus     = $row['p_businessstaus'];
		$this->keytype            = $row['p_keytype'];
		$this->customizetype      = $row['p_customizetype'];
		$this->colorlist          = $row['p_colorlist'];
		$this->fullboxshort       = $row['p_fullbox_short'];
		$this->warranty           = $row['p_warranty'];
		$this->transporttype      = $row['p_transporttype'];
		$this->setuptype          = $row['p_setuptype'];
		$this->width              = $row['p_width'];
		$this->height             = $row['p_height'];
		$this->length             = $row['p_length'];
		$this->weight             = $row['p_weight'];
		$this->displaytype        = $row['p_displaytype'];
		$this->ipaddress          = $row['p_ipaddress'];
		$this->datedeleted        = $row['p_datedeleted'];
		$this->datelastsync       = $row['p_datelastsync'];
		$this->prepaidprice       = $row['p_prepaidprice'];
		$this->prepaidstartdate   = $row['p_prepaidstartdate'];
		$this->prepaidname 		  = $row['p_prepaidname'];
		$this->prepaidpromotion   = $row['p_prepaidpromotion'];
		$this->prepaidpolicy      = $row['p_prepaidpolicy'];
		$this->prepaidrand        = $row['p_prepaidrand'];
		$this->prepaiddepositrequire = $row['p_prepaiddepositrequire'];
		$this->prepaidenddate     = $row['p_prepaidenddate'];
		$this->comingsoonprice    = $row['p_comingsoonprice'];
		$this->comingsoondate     = $row['p_comingsoondate'];
		$this->isrequestimei      = $row['p_isrequestimei'];
		$this->isservice = $row['p_isservice'];
		$this->vat				  = $row['p_vat'];
		$this->importdate         = $row['p_importdate'];
		$this->datecreated        = $row['p_datecreated'];
		$this->datemodified       = $row['p_datemodified'];
		$this->pc_slug            = $row['pc_slug'];

	}

	public function getDataByArray($row)
	{
		$this->uid                = $row['u_id'];
		$this->vid                = $row['v_id'];
		$this->vsubid             = $row['v_subid'];
		$this->pcid               = $row['pc_id'];
		$this->id                 = $row['p_id'];
		$this->image              = $row['p_image'];
		$this->resourceserver     = $row['p_resourceserver'];
		$this->barcode            = $row['p_barcode'];
		$this->name               = $row['p_name'];
		$this->slug               = $row['p_slug'];
		$this->content            = $row['p_content'];
		$this->summary            = $row['p_summary'];
		$this->summarynew         = $row['p_summarynew'];
		$this->good               = $row['p_good'];
		$this->bad                = $row['p_bad'];
		$this->dienmayreview      = $row['p_dienmayreview'];
		$this->fullbox            = $row['p_fullbox'];
		$this->laigopauto         = $row['p_laigopauto'];
		$this->laigop             = $row['p_laigop'];
		$this->seotitle           = $row['p_seotitle'];
		$this->seokeyword         = $row['p_seokeyword'];
		$this->seodescription     = $row['p_seodescription'];
		$this->canonical          = $row['p_canonical'];
		$this->metarobot          = $row['p_metarobot'];
		$this->topseokeyword      = $row['p_topseokeyword'];
		$this->textfooter         = $row['p_textfooter'];
		$this->unitprice          = $row['p_unitprice'];
		$this->sellprice          = $row['p_sellprice'];
		$this->finalprice         = $row['p_finalprice'];
		$this->productaward       = $row['p_productaward'];
		$this->promotionlist      = $row['p_promotionlist'];
		$this->applypromotionlist = $row['p_applypromotionlist'];
		$this->vendorprice        = $row['p_vendorprice'];
		$this->discountpercent    = $row['p_discountpercent'];
		$this->isbagdehot         = $row['p_isbagdehot'];
		$this->isbagdenew         = $row['p_isbagdenew'];
		$this->isbagdegift        = $row['p_isbagdegift'];
		$this->instock            = $row['p_instock'];
		$this->countview          = $row['p_countview'];
		$this->countreview        = $row['p_countreview'];
		$this->countrating        = $row['p_countrating'];
		$this->averagerating      = $row['p_averagerating'];
		$this->countthumbup       = $row['p_countthumbup'];
		$this->view1              = $row['p_view1'];
		$this->view7              = $row['p_view7'];
		$this->view15             = $row['p_view15'];
		$this->view30             = $row['p_view30'];
		$this->sell1              = $row['p_sell1'];
		$this->sell7              = $row['p_sell7'];
		$this->sell15             = $row['p_sell15'];
		$this->sell30             = $row['p_sell30'];
		$this->displayorder       = $row['p_displayorder'];
		$this->displaymanual      = $row['p_displaymanual'];
		$this->displaypriceorder  = $row['p_displaypriceorder'];
		$this->displaysellprice   = $row['p_displaysellprice'];
		$this->status             = $row['p_status'];
		$this->syncstatus         = $row['p_syncstatus'];
		$this->onsitestatus       = $row['p_onsitestatus'];
		$this->businessstatus     = $row['p_businessstaus'];
		$this->keytype            = $row['p_keytype'];
		$this->customizetype      = $row['p_customizetype'];
		$this->colorlist          = $row['p_colorlist'];
		$this->fullboxshort       = $row['p_fullbox_short'];
		$this->warranty           = $row['p_warranty'];
		$this->transporttype      = $row['p_transporttype'];
		$this->setuptype          = $row['p_setuptype'];
		$this->width              = $row['p_width'];
		$this->height             = $row['p_height'];
		$this->length             = $row['p_length'];
		$this->weight             = $row['p_weight'];
		$this->displaytype        = $row['p_displaytype'];
		$this->ipaddress          = $row['p_ipaddress'];
		$this->datedeleted        = $row['p_datedeleted'];
		$this->datelastsync       = $row['p_datelastsync'];
		$this->prepaidprice       = $row['p_prepaidprice'];
		$this->prepaidstartdate   = $row['p_prepaidstartdate'];
		$this->prepaidenddate     = $row['p_prepaidenddate'];
		$this->prepaidname 		  = $row['p_prepaidname'];
		$this->prepaidpromotion   = $row['p_prepaidpromotion'];
		$this->prepaidpolicy      = $row['p_prepaidpolicy'];
		$this->prepaidrand        = $row['p_prepaidrand'];
		$this->prepaiddepositrequire = $row['p_prepaiddepositrequire'];
		$this->comingsoonprice    = $row['p_comingsoonprice'];
		$this->comingsoondate     = $row['p_comingsoondate'];
		$this->isrequestimei      = $row['p_isrequestimei'];
		$this->isservice = $row['p_isservice'];
		$this->vat				  = $row['p_vat'];
		$this->importdate         = $row['p_importdate'];
		$this->datecreated        = $row['p_datecreated'];
		$this->datemodified       = $row['p_datemodified'];
		$this->pc_slug            = $row['pc_slug'];

	}


	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product
				WHERE p_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		//xoa cache html product  detail
		$this->clearCache();

		//Xoa cache object
		self::cacheClear($this->id);

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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product p';

		if($where != '')
			$sql .= ' WHERE ' . $where;
		//echodebug($sql);
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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product p';


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
			$myProduct                     = new Core_Product();

			$myProduct->uid                = $row['u_id'];
			$myProduct->vid                = $row['v_id'];
			$myProduct->vsubid             = $row['v_subid'];
			$myProduct->pcid               = $row['pc_id'];
			$myProduct->id                 = $row['p_id'];
			$myProduct->image              = $row['p_image'];
			$myProduct->resourceserver     = $row['p_resourceserver'];
			$myProduct->barcode            = $row['p_barcode'];
			$myProduct->name               = $row['p_name'];
			$myProduct->slug               = $row['p_slug'];
			$myProduct->content            = $row['p_content'];
			$myProduct->summary            = $row['p_summary'];
			$myProduct->summarynew         = $row['p_summarynew'];
			$myProduct->good               = $row['p_good'];
			$myProduct->bad                = $row['p_bad'];
			$myProduct->dienmayreview      = $row['p_dienmayreview'];
			$myProduct->fullbox            = $row['p_fullbox'];
			$myProduct->laigopauto         = $row['p_laigopauto'];
			$myProduct->laigop             = $row['p_laigop'];
			$myProduct->seotitle           = $row['p_seotitle'];
			$myProduct->seokeyword         = $row['p_seokeyword'];
			$myProduct->seodescription     = $row['p_seodescription'];
			$myProduct->canonical          = $row['p_canonical'];
			$myProduct->metarobot          = $row['p_metarobot'];
			$myProduct->topseokeyword      = $row['p_topseokeyword'];
			$myProduct->textfooter         = $row['p_textfooter'];
			$myProduct->unitprice          = $row['p_unitprice'];
			$myProduct->sellprice          = $row['p_sellprice'];
			$myProduct->finalprice         = $row['p_finalprice'];
			$myProduct->productaward       = $row['p_productaward'];
			$myProduct->promotionlist      = $row['p_promotionlist'];
			$myProduct->applypromotionlist = $row['p_applypromotionlist'];
			$myProduct->vendorprice        = $row['p_vendorprice'];
			$myProduct->discountpercent    = $row['p_discountpercent'];
			$myProduct->isbagdehot         = $row['p_isbagdehot'];
			$myProduct->isbagdenew         = $row['p_isbagdenew'];
			$myProduct->isbagdegift        = $row['p_isbagdegift'];
			$myProduct->instock            = $row['p_instock'];
			$myProduct->countview          = $row['p_countview'];
			$myProduct->countreview        = $row['p_countreview'];
			$myProduct->countrating        = $row['p_countrating'];
			$myProduct->averagerating      = $row['p_averagerating'];
			$myProduct->countthumbup       = $row['p_counthumbup'];
			$myProduct->view1              = $row['p_view1'];
			$myProduct->view7              = $row['p_view7'];
			$myProduct->view15             = $row['p_view15'];
			$myProduct->view30             = $row['p_view30'];
			$myProduct->sell1              = $row['p_sell1'];
			$myProduct->sell7              = $row['p_sell7'];
			$myProduct->sell15             = $row['p_sell15'];
			$myProduct->sell30             = $row['p_sell30'];
			$myProduct->displayorder       = $row['p_displayorder'];
			$myProduct->displaymanual      = $row['p_displaymanual'];
			$myProduct->displaypriceorder  = $row['p_displaypriceorder'];
			$myProduct->displaysellprice   = $row['p_displaysellprice'];
			$myProduct->status             = $row['p_status'];
			$myProduct->syncstatus         = $row['p_syncstatus'];
			$myProduct->onsitestatus       = $row['p_onsitestatus'];
			$myProduct->businessstatus     = $row['p_businessstaus'];
			$myProduct->keytype            = $row['p_keytype'];
			$myProduct->customizetype      = $row['p_customizetype'];
			$myProduct->colorlist          = $row['p_colorlist'];
			$myProduct->fullboxshort       = $row['p_fullbox_short'];
			$myProduct->warranty           = $row['p_warranty'];
			$myProduct->transporttype      = $row['p_transporttype'];
			$myProduct->setuptype          = $row['p_setuptype'];
			$myProduct->width              = $row['p_width'];
			$myProduct->height             = $row['p_height'];
			$myProduct->length             = $row['p_length'];
			$myProduct->weight             = $row['p_weight'];
			$myProduct->displaytype        = $row['p_displaytype'];
			$myProduct->ipaddress          = $row['p_ipaddress'];
			$myProduct->datedeleted        = $row['p_datedeleted'];
			$myProduct->datelastsync       = $row['p_datelastsync'];
			$myProduct->prepaidprice       = $row['p_prepaidprice'];
			$myProduct->prepaidstartdate   = $row['p_prepaidstartdate'];
			$myProduct->prepaidenddate     = $row['p_prepaidenddate'];
			$myProduct->prepaidname 	   = $row['p_prepaidname'];
			$myProduct->prepaidpromotion   = $row['p_prepaidpromotion'];
			$myProduct->prepaidpolicy      = $row['p_prepaidpolicy'];
			$myProduct->prepaidrand        = $row['p_prepaidrand'];
			$myProduct->prepaiddepositrequire = $row['p_prepaiddepositrequire'];
			$myProduct->comingsoonprice    = $row['p_comingsoonprice'];
			$myProduct->comingsoondate     = $row['p_comingsoondate'];
			$myProduct->isrequestimei      = $row['p_isrequestimei'];
			$myProduct->isservice 		   = $row['p_isservice'];
			$myProduct->vat				   = $row['p_vat'];
			$myProduct->importdate         = $row['p_importdate'];
			$myProduct->datecreated        = $row['p_datecreated'];
			$myProduct->datemodified       = $row['p_datemodified'];

			$outputList[]                  = $myProduct;
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
	public static function getProducts($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';

		if($formData['fvid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.v_id = '.(int)$formData['fvid'].' ';

		if($formData['fvsubid'] > 0)
				$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.v_subid = '.(int)$formData['fvsubid'].' ';

		if($formData['fpcid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id = '.(int)$formData['fpcid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fid'].' ';

		if($formData['fbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = "'.Helper::unspecialtext((string)$formData['fbarcode']).'" ';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_name LIKE "%'.Helper::unspecialtext((string)$formData['fname']).'%" ';

		if($formData['fslug'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';

		if($formData['funitprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_unitprice = '.(float)$formData['funitprice'].' ';

		if($formData['fsellprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice = '.(float)$formData['fsellprice'].' ';

		if($formData['fvendorprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_vendorprice = '.(float)$formData['fvendorprice'].' ';

		if($formData['finstock'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_instock > '.(int)$formData['finstock'].' ';

		if($formData['fcountview'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_countview = '.(int)$formData['fcountview'].' ';

		if($formData['fstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_status = '.(int)$formData['fstatus'].' ';

		if($formData['favalible'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_status != ' . Core_Product::STATUS_DELETED . ' ' ;

		if($formData['fsellpricefrom'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice >= ' . (float)$formData['fsellpricefrom'] . ' ';
		if($formData['fsellpriceto'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice <= ' . (float)$formData['fsellpriceto'] . ' ';
		if($formData['fisbagdehot'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_isbagdehot = ' . (int)$formData['fisbagdehot'] . ' ';
		if($formData['fisbagdenew'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_isbagdenew = ' . (int)$formData['fisbagdenew'] . ' ';
		if($formData['fisbagdegift'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_isbagdegift = ' . (int)$formData['fisbagdegift'] . ' ';
		if($formData['fisbagdegift'] == -1)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_isbagdegift != ' . 1 . ' ';
		if($formData['fdisplaysellprice'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_displaysellprice = ' . (int)$formData['fdisplaysellprice'] . ' ';

		if(count($formData['fpcidarr']) > 0 && $formData['fpcid'] == 0)
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
			for($i = 0 ; $i < count($formData['fpcidarr']) ; $i++)
			{
				if($i == count($formData['fpcidarr']) - 1)
				{
					$whereString .= 'p.pc_id = ' . (int)$formData['fpcidarr'][$i];
				}
				else
				{
					$whereString .= 'p.pc_id = ' . (int)$formData['fpcidarr'][$i] . ' OR ';
				}
			}
			$whereString .= ')';
		}

		if(is_array($formData['fpcidarrin']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id IN( '.implode(',' , $formData['fpcidarrin']).') ';
		}

		if(is_array($formData['fidarr']))
		{
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id IN( '.implode(',' , $formData['fidarr']).') ';
        }

        if($formData['fcustomizetype'] > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_customizetype = ' . (int)$formData['fcustomizetype'] . ' ';
        }

        if(!empty($formData['fpricethan0']))
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice > 0  ';
        }

        //filter for pricesegment
        if($formData['ffromprice'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice >= '.(float)$formData['ffromprice'].' ';

        if($formData['ftoprice'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_sellprice < '.(float)$formData['ftoprice'].' ';

        if(!empty($formData['fquantitythan0']))
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_instock > 0  ';
        }

        if(!empty($formData['fquantity0']))
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_instock = 0  ';
        }

        if(!empty($formData['fhasbarcode']))
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode != ""  ';
        }

        if(!empty($formData['fhaspromotion']))
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_promotionlist != ""  ';
        }

        if(!empty($formData['fhasnotbarcode']))
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = ""  ';
        }

        if($formData['fsyncstatus'] > 0)
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_syncstatus = ' . (int)$formData['fsyncstatus'] . ' ';
        }


        if(count($formData['fpbarcodearr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode IN ("'.implode('","',$formData['fpbarcodearr']).'") ';

        if(count($formData['fvidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.v_id IN ('.implode(',',$formData['fvidarr']).') ';

        if(count($formData['fpcidarrs']) > 0)
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . '(';
        	$i = 0;
			foreach($formData['fpcidarrs'] as $data)
			{
				if($i < count($formData['fpcidarrs'])-1)
				{
					foreach($data as $key => $value)
					{
						if($value == 0)
						{
							$whereString .= ' (p.pc_id ='.$key.' ) OR ';
						}
						else
						{
							$whereString .= ' (p.pc_id = '.$key.' AND p.v_id = '.$value.') OR ';
						}
					}
				}
				else
				{
					 foreach($data as $key => $value)
					 {
					 	if($value == 0)
						{
							$whereString .= ' (p.pc_id ='.$key.' ) ';
						}
						else
						{
							$whereString .= ' (p.pc_id = '.$key.' AND p.v_id = '.$value.') ';
						}
					 }
				}
				$i++;
			}

			$whereString .= ')';
        }

        if(strlen($formData['fgeneralkeyword']) > 0)
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . '(p.p_id = "'.Helper::unspecialtext((string)$formData['fgeneralkeyword']).'" OR p.p_barcode = "'.Helper::unspecialtext((string)$formData['fgeneralkeyword']).'" OR p.p_name LIKE "%'.Helper::unspecialtext((string)$formData['fgeneralkeyword']).'%")';
        }

        if(strlen($formData['fisonsitestatus']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_onsitestatus > 0 ';
        }

        if(isset($formData['fonsitestatus']))
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_onsitestatus = ' . (int)$formData['fonsitestatus'] . ' ';
        }

        if(count($formData['fonsitestatusarr']) > 0)
        {
        	$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_onsitestatus IN(' . implode(',', $formData['fonsitestatusarr']) . ') ';
        }

        if(isset($formData['fbusinessstatus']))
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_businessstaus = ' . (int)$formData['fbusinessstatus'] . ' ';
        }

        if(count($formData['fbusinessstatusarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_businessstaus IN (' . implode(',', $formData['fbusinessstatusarr']) . ') ';
        }

        if(isset($formData['fresourceserver']))
        {
        		$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_resourceserver = ' . (int)$formData['fresourceserver'] . ' ';
        }

        if(isset($formData['fhasimage']))
        {
        		$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_image != "" ';
        }

        if($formData['ftransporttype'] > 0)
        {
        		$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_transporttype = ' . (int)$formData['ftransporttype'] . ' ';
        }

        if($formData['fsetuptype'] > 0)
        {
        		$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_setuptype = ' . (int)$formData['fsetuptype'] . ' ';
        }

        if($formData['fkeytype'] > 0)
        {
        		$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_keytype = ' . (int)$formData['fkeytype'] . ' ';
        }

        /* Start for Mobile app*/
        if($formData['fMstatus'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_status IN (' . implode(',', $formData['fMstatus']) . ') ';

        if(strlen($formData['fMobile']) > 0)
        {
			$whereString .= ($whereString != '' ? ' AND ' : '') . '((p.p_id LIKE "%'.str_replace(' ', '', $formData['fMobile']).'%")
																	OR (p.p_barcode LIKE "%'.str_replace(' ', '', $formData['fMobile']).'%")
																	OR (p.p_finalprice LIKE "%'.str_replace(' ', '', $formData['fMobile']).'%")
																	OR (p.p_name LIKE "%'.$formData['fMobile'].'%"  ))';

        }
        /* End of Mobile*/

        //Get product availble
        if($formData['fproductavailble'] > 0){
        	$whereString .= ($whereString != '' ? ' AND ' : '') . '((p.p_onsitestatus > 0 AND p.p_sellprice > 0 AND p.p_instock > 0)
        															OR (p.p_onsitestatus = ' . self::OS_COMMINGSOON .')
        															OR (p.p_onsitestatus = ' . self::OS_DOANGIA .')
        															OR (p.p_onsitestatus = ' . self::OS_ERP_PREPAID . ' AND p.p_prepaidprice > 0)
        															)';
        }

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'p.pc_id , p.p_id ' . $sorttype;
		if($sortby == 'name')
			$orderString = 'p.pc_id , p.p_name ' . $sorttype;
		elseif($sortby == 'onsitestatus')
			$orderString = 'p.p_onsitestatus ' . $sorttype . ', p.pc_id, p.p_id DESC';
		elseif($sortby == 'sellprice')
			$orderString = 'p_sellprice ' . $sorttype;
		elseif($sortby == 'displayorder')
            $orderString = 'p.pc_id , p.p_displayorder ' . $sorttype;
        elseif($sortby == 'countview')
			$orderString = 'p.pc_id , p.p_countview ' . $sorttype;
		elseif($sortby == 'finalprice')
			$orderString = 'p.pc_id , p.p_finalprice ' . $sorttype;
		else
			$orderString = 'p.pc_id , p.p_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

	public function getMaxDisplayOrder()
	{
		$sql = 'SELECT MAX(p_displayorder) FROM ' . TABLE_PREFIX . 'product';
		return (int)$this->db->query($sql)->fetchColumn(0);
	}

	public static function getStatusList()
	{
		$output = array();

		$output[self::STATUS_ENABLE] = 'Enable';
		$output[self::STATUS_DISABLED] = 'Disabled';

		return $output;
	}

	public static function getSyncStatusList()
	{
		$output = array();

		$output[self::STATUS_SYNC_FOUND] = 'Sync';
		$output[self::STATUS_SYNC_NOTFOUND] = 'Not Sync';
		$output[self::STATUS_SYNC_LOCALONLY] = 'Local only';

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

	public static function getonsitestatusList()
	{
        $output = array();

        $output[self::OS_NOSELL] = 'Không kinh doanh';

        // $outpurt[self::OS_DM_PREPAID] = 'Đặt hàng trước'; // tam thoi comment

        $output[self::OS_ERP_PREPAID] = 'Đặt hàng trước (ERP)';
        $output[self::OS_ERP] = 'ERP';
        $output[self::OS_DM] = 'Điện máy'; //tam thoi comment
        $output[self::OS_COMMINGSOON] = 'Hàng sắp về';
        $output[self::OS_NEW] = 'Mới';
        $output[self::OS_HOT] = 'Hot';
        $output[self::OS_CRAZYSALE] = 'Crazy Sale';
        $output[self::OS_BESTSELLER] = 'Bán chạy';
        $output[self::OS_DOANGIA] = 'Đoán giá';

        // $output[self::OS_NEWARRIVAL] = 'Hàng mẫu';
        // $output[self::OS_CLEARSTOCK] = 'Hàng thanh lý';
        // $output[self::OS_SHOWROOM] = 'Hàng trưng bày';
        // $output[self::OS_ONLINEONY] = 'Chỉ bán online';


        return $output;
	}

	public function getonsitestatusName()
	{
        $name = '';

        switch($this->onsitestatus)
        {
            case self::OS_NOSELL : $name = 'Không kinh doanh'; break;
            case self::OS_ERP_PREPAID : $name = 'Đặt hàng trước (ERP)'; break;
            case self::OS_DM_PREPAID : $name = 'Đặt hàng trước (Điện máy)'; break;
            case self::OS_ERP : $name = 'ERP'; break;
            case self::OS_DM : $name = 'Điện máy';
            case self::OS_COMMINGSOON : $name = 'Hàng sắp về'; break;
            case self::OS_NEWARRIVAL : $name = 'Hàng mẫu'; break;
            case self::OS_CLEARSTOCK : $name = 'Hàng thanh lý'; break;
            case self::OS_SHOWROOM : $name = 'Hàng trưng bày'; break;
            case self::OS_ONLINEONY : $name = 'Chỉ bán online'; break;
            case self::OS_NEW : $name = 'Mới'; break;
            case self::OS_HOT : $name = 'Hot'; break;
            case self::OS_CRAZYSALE : $name = 'Crazy Sale'; break;
            case self::OS_BESTSELLER : $name = 'Bán chạy'; break;
            case self::OS_DOANGIA : $name = 'Đoán giá'; break;
        }

        return $name;
	}

	public function checkonsitestatusName($name)
	{
	    $name = strtolower($name);

        if($this->onsitestatus == self::OS_NOSELL && $name == 'no sell' || $this->onsitestatus == self::OS_ERP_PREPAID && $name == 'prepaid_erp' || $this->onsitestatus == self::OS_DM_PREPAID && $name == 'prepaid_dm' || $this->onsitestatus == self::OS_ERP && $name == 'erp' || $this->onsitestatus == self::OS_DM && $name == 'dm')
			return true;
		else
			return false;
	}

	public static function getbusinessstatusList()
	{
		$output = array();


        $output[self::BS_DEFAULT] = 'Không xác định';
        $output[self::BS_KEYONLINE] = 'Key online';
        $output[self::BS_NOSELL] = 'Ngừng kinh doanh';
        $output[self::BS_CLEARSTOCK] = 'Clear stock';
		$output[self::BS_ONLINESTOCK] = 'Online đa dạng tồn kho';
		$output[self::BS_BUSSINESSNORMAL] = 'Kinh doanh bình thường';
		$output[self::BS_TEMPORALITYOUTOFSTOCK] = 'Tạm thời hét hàng';
		$output[self::BS_KEYSUPERMARTKETANDONLINE] = 'Key siêu thị và online';
		$output[self::BS_MULTIFORMAT] = 'Đa dạng';
		$output[self::BS_ONLINEOUTOFSTOCK] = 'Online đa dạng không tồn tồn kho';
		$output[self::BS_COMINGSOON] = 'Hàng sắp về';


        return $output;
	}

	public static function getbusinessstatusListReport($keystatus = 0)
	{
		$output = array();
        $output[self::BS_KEYSUPERMARTKETANDONLINE] = 'Key siêu thị và Online';
        $output[self::BS_KEYONLINE] = 'Key Online';
        $output[self::BS_BUSSINESSNORMAL] = 'Kinh doanh bình thường';
        $output[self::BS_MULTIFORMAT] = 'Đa dạng';
        $output[self::BS_ONLINESTOCK] = 'Online đa dạng tồn kho';
        $output[self::BS_ONLINEOUTOFSTOCK] = 'Online đa dạng không tồn tồn kho';
        $output[self::BS_CLEARSTOCK] = 'Clear stock';
        $output[self::BS_COMINGSOON] = 'Hàng sắp về';
        $output[self::BS_TEMPORALITYOUTOFSTOCK] = 'Tạm thời hét hàng';
        $output[self::BS_NOSELL] = 'Ngừng kinh doanh';
        $output[self::BS_DEFAULT] = 'Không xác định';
        if (!empty($keystatus)) return $output[$keystatus];
        return $output;
	}

	public function getbusinessstatusName()
	{
		$name = '';

		switch ($this->businessstatus)
		{
			case self::BS_KEYSUPERMARTKETANDONLINE:
				$name = 'Key siêu thị và online';
				break;

			case self::BS_MULTIFORMAT:
				$name = 'Đa dạng';
				break;

			case self::BS_DEFAULT:
				$name = 'Không xác định';
				break;

			case self::BS_BUSSINESSNORMAL:
				$name = 'Kinh doanh bình thường';
				break;

			case self::BS_KEYONLINE:
				$name = 'Key online';
				break;

			case self::BS_NOSELL:
				$name = 'Ngừng kinh doanh';
				break;

			case self::BS_COMINGSOON:
				$name = 'Hàng sắp về';
				break;

			case self::BS_TEMPORALITYOUTOFSTOCK:
				$name = 'Tạm hết hàng';
				break;

			case self::BS_ONLINESTOCK:
				$name = 'Online đa dạng tồn kho';
				break;

			case self::BS_ONLINEOUTOFSTOCK:
				$name = 'Online đa dạng không tồn tồn kho';
				break;

			case self::BS_CLEARSTOCK:
				$name = 'Clear stock';
				break;
		}

		return $name;
	}

	public static function getstaticbusinessstatusName($bussinesstatus)
	{
		$name = '';

		switch ($bussinesstatus)
		{
			case self::BS_KEYSUPERMARTKETANDONLINE:
				$name = 'Key siêu thị và online';
				break;

			case self::BS_MULTIFORMAT:
				$name = 'Đa dạng';
				break;

			case self::BS_DEFAULT:
				$name = 'Không xác định';
				break;

			case self::BS_BUSSINESSNORMAL:
				$name = 'Kinh doanh bình thường';
				break;

			case self::BS_KEYONLINE:
				$name = 'Key online';
				break;

			case self::BS_NOSELL:
				$name = 'Ngừng kinh doanh';
				break;

			case self::BS_COMINGSOON:
				$name = 'Hàng sắp về';
				break;

			case self::BS_TEMPORALITYOUTOFSTOCK:
				$name = 'Tạm hết hàng';
				break;

			case self::BS_ONLINESTOCK:
				$name = 'Online đa dạng tồn kho';
				break;

			case self::BS_ONLINEOUTOFSTOCK:
				$name = 'Online đa dạng không tồn tồn kho';
				break;

			case self::BS_CLEARSTOCK:
				$name = 'Clear stock';
				break;
		}

		return $name;
	}

	public static function getkeytypeList()
	{
        $output = array();

        $output[self::KEYTYPE_KEY] = 'Key';
        $output[self::KEYTYPE_CLEARSTOCK] = 'Clear Stock';

        return $output;
	}

	public function getkeytypeName()
	{
        $name = '';

        switch($this->keytype)
        {
        	case self::KEYTYPE_KEY : $name = 'KEY';break;
        	case self::KEYTYPE_CLEARSTOCK : $name = 'Clear Stock';break;
        }

        return $name;
	}

	public function checkkeytypeName($name)
	{
	    $name = strtolower($name);

        if($this->keytype == self::KEYTYPE_KEY && $name == 'key' || $this->keytype == self::KEYTYPE_CLEARSTOCK && $name == 'clear stock')
			return true;
		else
			return false;
	}

	public static function getDisplayTypeList()
	{
		$outputList = array();

		$outputList[self::DISPLAY_NORMAL] = 'Thông thường';
		$outputList[self::DISPLAY_TEXT] = 'Nổi bật chi tiết';
		$outputList[self::DISPLAY_BANNER] = 'Nổi bật banner';

		return $outputList;
	}

	public static function getTranspostTypeList()
	{
		$outputList = array();

		$outputList[self::TRANSPORT_NO] = 'Không';
		$outputList[self::TRANSPORT_DEFAULT] = 'Có';

		return $outputList;
	}

	public static function getSetupTypeList()
	{
		$outputList = array();

		$outputList[self::SETUP_NO] = 'Không';
		$outputList[self::SETUP_DEFAULT] = 'Có';

		return $outputList;
	}

	public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['product']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
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

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer($registry->setting['product']['imageDirectory'] . $curDateDir, $name,
                                                $registry->setting['product']['imageDirectory'] . $curDateDir, $nameThumb,
                                                $registry->setting['product']['imageThumbWidth'],
                                                $registry->setting['product']['imageThumbHeight'],
                                                $registry->setting['product']['imageThumbRatio'],
                                                $registry->setting['product']['imageQuality']);
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
            $file = $registry->setting['product']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
	            $pos = strrpos($deletefile, '.');
				$extPart = substr($deletefile, $pos+1);
				$namePart =  substr($deletefile,0, $pos);

				$deletesmallimage = $namePart . '-small.' . $extPart;
				$file = $registry->setting['product']['imageDirectory'] . $deletesmallimage;
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

		if (empty($this->image) && $this->onsitestatus == self::CUSTOMIZETYPE_COLOR) {
			$mainProduct = Core_Product::getMainProductFromColor($this->id);
			if (!empty($mainProduct)) {
				$this->resourceserver = $mainProduct->resourceserver;
				$this->image = $mainProduct->image;
			}
		}

		$pos = strrpos($this->image, '.');
		$extPart = substr($this->image, $pos+1);
		$namePart =  substr($this->image,0, $pos);
		$filesmall = $namePart . '-small.' . $extPart;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'product') . $filesmall;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['product']['imageDirectory'] . $filesmall;
		}

		return $url;
	}


	public function getImage()
	{
		global $registry;

		if($this->resourceserver > 0)
		{
			$url = ResourceServer::getUrl($this->resourceserver, 'product') . $this->image;
		}
		else
		{
			$url = $registry->conf['rooturl'] . $registry->setting['product']['imageDirectory'] . $this->image;
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
		if($this->image != '')
		{
			$coverpath = $registry->setting['product']['imageDirectory'] . $this->image;
		}

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product
                SET p_image = ?,
                	  p_resourceserver = 0
                WHERE p_id = ?';

        $stmt = $this->db->query($sql, array(
                (string)$this->image,
                (int)$this->id
            ));
        return $stmt;
    }

	public static function getIdByBarcode($barcode = '')
	{
		if(strlen($barcode) > 0)
		{
			global $db;
		    $myProduct = new Core_Product();

			$sql = 'SELECT *
					FROM ' . TABLE_PREFIX . 'product
					WHERE p_barcode = "' .trim(Helper::unspecialtext((string)$barcode)).'"';


			$row = $db->query($sql)->fetch();



			$myProduct->uid                = $row['u_id'];
			$myProduct->vid                = $row['v_id'];
			$myProduct->vsubid             = $row['v_subid'];
			$myProduct->pcid               = $row['pc_id'];
			$myProduct->id                 = $row['p_id'];
			$myProduct->image              = $row['p_image'];
			$myProduct->resourceserver     = $row['p_resourceserver'];
			$myProduct->barcode            = $row['p_barcode'];
			$myProduct->name               = $row['p_name'];
			$myProduct->slug               = $row['p_slug'];
			$myProduct->content            = $row['p_content'];
			$myProduct->summary            = $row['p_summary'];
			$myProduct->summarynew         = $row['p_summarynew'];
			$myProduct->good               = $row['p_good'];
			$myProduct->bad                = $row['p_bad'];
			$myProduct->dienmayreview      = $row['p_dienmayreview'];
			$myProduct->fullbox            = $row['p_fullbox'];
			$myProduct->laigopauto         = $row['p_laigopauto'];
			$myProduct->laigop             = $row['p_laigop'];
			$myProduct->seotitle           = $row['p_seotitle'];
			$myProduct->seokeyword         = $row['p_seokeyword'];
			$myProduct->seodescription     = $row['p_seodescription'];
			$myProduct->canonical          = $row['p_canonical'];
			$myProduct->metarobot          = $row['p_metarobot'];
			$myProduct->topseokeyword      = $row['p_topseokeyword'];
			$myProduct->textfooter         = $row['p_textfooter'];
			$myProduct->unitprice          = $row['p_unitprice'];
			$myProduct->sellprice          = $row['p_sellprice'];
			$myProduct->finalprice         = $row['p_finalprice'];
			$myProduct->productaward       = $row['p_productaward'];
			$myProduct->promotionlist      = $row['p_promotionlist'];
			$myProduct->applypromotionlist = $row['p_applypromotionlist'];
			$myProduct->vendorprice        = $row['p_vendorprice'];
			$myProduct->discountpercent    = $row['p_discountpercent'];
			$myProduct->isbagdehot         = $row['p_isbagdehot'];
			$myProduct->isbagdenew         = $row['p_isbagdenew'];
			$myProduct->isbagdegift        = $row['p_isbagdegift'];
			$myProduct->instock            = $row['p_instock'];
			$myProduct->countview          = $row['p_countview'];
			$myProduct->countreview        = $row['p_countreview'];
			$myProduct->countrating        = $row['p_countrating'];
			$myProduct->averagerating      = $row['p_averagerating'];
			$myProduct->countthumbup       = $row['p_countthumbup'];
			$myProduct->view1              = $row['p_view1'];
			$myProduct->view7              = $row['p_view7'];
			$myProduct->view15             = $row['p_view15'];
			$myProduct->view30             = $row['p_view30'];
			$myProduct->sell1              = $row['p_sell1'];
			$myProduct->sell7              = $row['p_sell7'];
			$myProduct->sell15             = $row['p_sell15'];
			$myProduct->sell30             = $row['p_sell30'];
			$myProduct->displayorder       = $row['p_displayorder'];
			$myProduct->displaypriceorder  = $row['p_displaypriceorder'];
			$myProduct->displaysellprice   = $row['p_displaysellprice'];
			$myProduct->status             = $row['p_status'];
			$myProduct->syncstatus         = $row['p_syncstatus'];
			$myProduct->onsitestatus       = $row['p_onsitestatus'];
			$myProduct->businessstaus      = $row['p_businessstaus'];
			$myProduct->keytype            = $row['p_keytype'];
			$myProduct->customizetype      = $row['p_customizetype'];
			$myProduct->colorlist          = $row['p_colorlist'];
			$myProduct->fullboxshort       = $row['p_fullbox_short'];
			$myProduct->warranty           = $row['p_warranty'];
			$myProduct->transporttype      = $row['p_transporttype'];
			$myProduct->setuptype          = $row['p_setuptype'];
			$myProduct->width              = $row['p_width'];
			$myProduct->height             = $row['p_height'];
			$myProduct->length             = $row['p_length'];
			$myProduct->weight             = $row['p_weight'];
			$myProduct->displaytype        = $row['p_displaytype'];
			$myProduct->ipaddress          = $row['p_ipaddress'];
			$myProduct->datedeleted        = $row['p_datedeleted'];
			$myProduct->datelastsync       = $row['p_datelastsync'];
			$myProduct->prepaidprice       = $row['p_prepaidprice'];
			$myProduct->prepaidstartdate   = $row['p_prepaidstartdate'];
			$myProduct->prepaidenddate     = $row['p_prepaidenddate'];
			$myProduct->prepaidname 	   = $row['p_prepaidname'];
			$myProduct->prepaidpolicy      = $row['p_prepaidpolicy'];
			$myProduct->prepaidrand        = $row['p_prepaidrand'];
			$myProduct->prepaiddepositrequire = $row['p_prepaiddepositrequire'];
			$myProduct->comingsoonprice    = $row['p_comingsoonprice'];
			$myProduct->comingsoondate     = $row['p_comingsoondate'];
			$myProduct->isrequestimei      = $row['p_isrequestimei'];
			$myProduct->isservice  = $row['p_isservice'];
			$myProduct->vat                = $row['p_vat'];
			$myProduct->importdate         = $row['p_importdate'];
			$myProduct->datecreated        = $row['p_datecreated'];
			$myProduct->datemodified       = $row['p_datemodified'];

			return $myProduct;
		}
	}

    public static function getFullCategory($pid = 0)
    {
        global $db;
        global $registry;

        if($pid > 0)
        {
            $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'product WHERE p_id = ' . $pid;
            $row = $registry->db->query($sql)->fetch();
            $output = Core_Productcategory::getFullParentProductCategorys((int)$row['pc_id']);

            //lay thong tin cua category hien tai
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_id = ' . (int)$row['pc_id'];
            $rows = $registry->db->query($sql)->fetch();
            if(!empty($rows))
            {
                $pc = new Core_Productcategory();
                $rows['fullpath'] = $pc->getProductcateoryPath($rows['pc_id']);
            }
            $output[] = $rows;

            return $output;
        }
    }


    public static function getFullCategoryByProductId($pid = 0)
    {
        global $db;
        global $registry;

        if($pid > 0)
        {
            $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'product WHERE p_id = ' . $pid;
            $row = $registry->db->query($sql)->fetch();
            //$output = Core_Productcategory::getFullParentProductCategorys((int)$row['pc_id']);

            //lay thong tin cua category hien tai
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_id = ' . (int)$row['pc_id'];
            $rows = $registry->db->query($sql)->fetch();
            if(!empty($rows))
            {
                $pc = new Core_Productcategory();
                $rows['fullpath'] = $pc->getProductcateoryPath($rows['pc_id']);
            }
            $output[] = $rows;

            return $output;
        }
    }

    public function getProductPath()
    {
    	global $registry;

    	$productPath = $registry['conf']['rooturl'];
        //if($productPath) $productPath .= 'product/detail/?pcid='.$this->pcid.'&pid='.$this->id;

    	if(strlen($this->slug) > 0)
    	{
    		$myProductCategory = new Core_Productcategory($this->pcid, true);

    		$productPath .= $myProductCategory->slug . '/' . $this->slug;
    	}
    	else
    	{
    		if($productPath) $productPath .= 'product/detail/?pcid='.$this->pcid.'&pid='.$this->id;
    	}

    	return $productPath;
    }

    public function updateProductByBarcode()
    {
    	$this->datemodified = time();
		global $registry;

		$sql = 'UPDATE ' . TABLE_PREFIX . 'product
				SET u_id = ?,
					v_id = ?,
					v_subid = ?,
					pc_id = ?,
                    p_image = ?,
                    p_resourceserver = ?,
					p_name = ?,
					p_slug = ?,
					p_content = ?,
					p_summary = ?,
					p_good = ?,
					p_bad = ?,
					p_dienmayreview = ?,
					p_fullbox = ?,
					p_laigopauto = ?,
					p_laigop = ?,
					p_seotitle = ?,
					p_seokeyword = ?,
					p_seodescription = ?,
					p_canonical = ?,
					p_unitprice = ?,
					p_sellprice = ?,
					p_promotionlist = ?,
					p_applypromotionlist =?,
					p_vendorprice = ?,
					p_discountpercent = ?,
					p_isbagdehot = ?,
					p_isbagdenew = ?,
					p_isbagdegift = ?,
					p_instock = ?,
					p_countview = ?,
					p_countreview = ?,
					p_countrating = ?,
					p_averagerating = ?,
					p_displayorder = ?,
					p_displaysellprice = ?,
                    p_status = ?,
                    p_syncstatus = ?,
                    p_onsitestatus = ?,
                    p_businessstatus = ?,
                    p_customizetype = ?,
                    p_colorlist = ?,
                    p_fullbox_short = ?,
                    p_warranty = ?,
					p_ipaddress = ?,
					p_datedeleted = ?,
					p_datelastsync = ?,
					p_prepaidprice =?,
					p_prepaidstartdate = ?,
					p_prepaidenddate = ?,
					p_prepaidname = ?,
					p_prepaidpolicy = ?,
					p_prepaidrand = ?,
					p_prepaiddepositrequire = ?,
					p_isrequestimei =?,
					p_importdate = ?,
					p_datecreated = ?,
					p_datemodified = ?
				WHERE p_barcode = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
					(int)$this->vid,
					(int)$this->vsubid,
					(int)$this->pcid,
                    (string)$this->image,
                    (int)$this->resourceserver,
					(string)$this->name,
					(string)$this->slug,
					(string)$this->content,
					(string)$this->summary,
					(string)$this->good,
					(string)$this->bad,
					(string)$this->dienmayreview,
					(string)$this->fullbox,
					(float)$this->laigopauto,
					(float)$this->laigop,
					(string)$this->seotitle,
					(string)$this->seokeyword,
					(string)$this->seodescription,
					(string)$this->canonical,
					(float)$this->unitprice,
					(float)$this->sellprice,
					(string)$this->promotionlist,
					(string)$this->applypromotionlist,
					(float)$this->vendorprice,
					(int)$this->discountpercent,
					(int)$this->isbagdehot,
					(int)$this->isbagdenew,
					(int)$this->isbagdegift,
					(int)$this->instock,
					(int)$this->countview,
					(int)$this->countreview,
					(int)$this->countrating,
					(int)$this->averagerating,
					(int)$this->displayorder,
					(int)$this->displaysellprice,
                    (int)$this->status,
                    (int)self::STATUS_SYNC_LOCALONLY,
                    (int)$this->onsitestatus,
                    (int)$this->businessstaus,
                    (int)$this->customizetype,
                    (string)$this->colorlist,
                    (string)$this->fullboxshort,
                    (int)$this->warranty,
					(int)$this->ipaddress,
					(int)$this->datedeleted,
					(int)$this->datelastsync,
					(float)$this->prepaidprice,
					(int)$this->prepaidstartdate,
					(int)$this->prepaidenddate,
					(string)$this->prepaidname,
					(string)$this->prepaidpolicy,
					(int)$this->prepaidrand,
					(float)$this->prepaiddepositrequire,
					(int)$this->isrequestimei,
					(int)$this->importdate,
					(int)$this->datecreated,
					(int)$this->datemodified,
					(string)$this->barcode
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                            SET p_image = ?
                            WHERE p_id = ?';
                    $result=$this->db->query($sql, array($this->image, $this->id));
                    if(!$result)
                    	return false;
                }
            }
			elseif(strpos($this->image, 'http') === 0)//set to download from remote image, do like amazon add
	        {
	            $originalImagePath = $this->image;

		        $curDateDir = Helper::getCurrentDateDirName();
			    $extPart = substr(strrchr($originalImagePath,'.'),1);
			    $namePart =  Helper::codau2khongdau($this->name, true) . '-' . $this->id . time();
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
			        $this->image = $curDateDir . $name;
			        $this->smallImage = $curDateDir . $nameThumb;
			        $this->updateImage();
		        }

			}

            return true;
		}
		else
			return false;
    }

    public function clearCache()
    {
        global $registry;
        $keyfile = 'http'.'sitehtml_productdetail'.$this->id.'_';
        $keyfile2 = 'https'.'sitehtml_productdetail'.$this->id.'_';
        //get all region
        $listregion = Core_Region::getRegions(array('fparentid' => 0),'','');
        if(!empty($listregion))
        {
            foreach($listregion as $ritem)
            {
                $cachefile1 = $keyfile.$ritem->id;
                $removeCache1 = new Cacher($cachefile1);
                $removeCache1->clear();

                $cachefile1 = $keyfile2.$ritem->id;
                $removeCache1 = new Cacher($cachefile1);
                $removeCache1->clear();
            }
        }
    }

    public static function getOnsiteIdList()
    {
        global $db;

        $sql = 'SELECT p_id FROM ' . TABLE_PREFIX .'product
                WHERE p_onsitestatus > 0';
        $stmt = $db->query($sql);
        $idList = array();

        while($row = $stmt->fetch())
        {
            $idList[] = $row['p_id'];
        }

        return $idList;
    }

    public function promotionPrice()
    {
        global $registry;
        if($this->sellprice > 0 && $this->onsitestatus > 0 && !empty($this->promotionlist))
        {
            $explodepromotionlist = explode('###', $this->promotionlist);
            if(!empty($explodepromotionlist))
            {
                foreach($explodepromotionlist as $promoprice)
                {
                    if(!empty($promoprice))
                    {
                        list($rid, $promoid, $promogrupid, $psellprice) = explode(',',trim($promoprice));
                        if($rid == $registry->region)
                        {
                            $myPromotion = new Core_Promotion($promoid);
                            $currenthours = date('H') * 60 + date('m');
                            if($myPromotion->enddate >= time() && $myPromotion->isactived ==1 && ($myPromotion->ispromotionbyhour == 0 || ($myPromotion->ispromotionbyhour == 1 && ($myPromotion->startpromotionbyhour <= $currenthours && $myPromotion->endpromotionbyhour >= $currenthours))) && $myPromotion->isdeleted == 0)
                            {
                                $myPromotionProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($this->barcode), 'fpromoid' => $promoid), '','', 1);
                            	$description = "";
                                if($myPromotion->descriptionclone != "")
                                	$description = $myPromotion->descriptionclone;
                                else
                                	$description = $myPromotion->description;
                                if(!empty($myPromotionProduct)) return array('price' => $psellprice, 'promoid' => $promoid, 'promogroupid' => $promogrupid, 'promodescription' =>$description);
                            }
                        }
                    }
                }
            }
        }
        return false;
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
		return 'p_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myProduct = new Core_Product();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product p
					WHERE p.p_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['p_id'] > 0)
			{
				$myProduct->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myProduct->getDataByArray($row);
		}

		return $myProduct;
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

    public static function getVendorFromCategories($idList , $type = 0)
    {
        global $db;
        $sql = 'SELECT DISTINCT(v_id) as vendorid , pc_id FROM ' . TABLE_PREFIX . 'product
                WHERE pc_id IN ('.implode(',', $idList).')
                AND p_onsitestatus > 0';

        $stmt = $db->query($sql);
        $vendorList = array();
        while($row = $stmt->fetch())
        {
            $myVendor = new Core_Vendor($row['vendorid'], true);
            if($myVendor->id >0 && !empty($myVendor->name) && $myVendor->type == $type && $myVendor->status == Core_Vendor::STATUS_ENABLE)
            {
                $myVendor->pcid = $row['pc_id'];
                $vendorList[$myVendor->id] = $myVendor;
            }
        }
        if(!empty($vendorList)) usort($vendorList, 'vendor_cmp');
        return $vendorList;

    }

    public static function getVendorFromVendorIds($idvendors)
    {
        $idvendors = trim($idvendors);
        $vendoridlist = explode(',', $idvendors);
        if(!empty($vendoridlist))
        {
            $vendorList = array();
            foreach($vendoridlist as $vid)
            {
                if(!empty($vid))
                {
                    $myVendor = new Core_Vendor($vid, true);
                    $vendorList[] = $myVendor;
                }
            }
            if(!empty($vendorList))
            {
                usort($vendorList, 'vendor_cmp');
                return $vendorList;
            }
        }
        return false;
    }

	public function getdisplayonsitestatus()
	{
		/**
		 * 1 :  dang kinh doanh
		 * 2 : tam thoi het hang
		 * 3 : khong kinh doanh
		 * 4 : Chá»‰ bÃ¡n online
		 * 5 : HÃ ng sáº¯p vá»�
		 * 6 : HÃ ng má»›i
		 * 7 : HÃ ng thanh lÃ½
		 * 8 : HÃ ng trÆ°ng bÃ y
		 */
		$status = 0;

		switch ($this->onsitestatus)
		{
			case Core_Product::OS_NOSELL:
				$status = 3;
				break;

			case Core_Product::OS_ONLINEONY:
				$status = 4;
				break;

			case Core_Product::OS_COMMINGSOON:
				$status = 5;
				break;

			case Core_Product::OS_NEWARRIVAL:
				$status = 6;
				break;

			case Core_Product::OS_CLEARSTOCK:
				$status = 7;
				break;

			case Core_Product::OS_SHOWROOM:
				$status = 8;
				break;

			case Core_Product::OS_DOANGIA:
				$status = 27;
				break;

			case Core_Product::OS_ERP:
				if($this->sellprice > 0)
				{
					if($this->instock > 0)
					{
						$status =1 ;
					}
					else
					{
						$status = 2;
					}
				}
				break;
		}

		return $status;
	}

	public static function getProductIdByCategory($catidlist = array() , $vendorlist = array())
	{
		global $db;
		$outputList = array();

		$sql = 'SELECT p_id ,
					pc_id,
					v_id,
					p_barcode,
					p_name,
					p_sellprice,
					p_unitprice,
					p_instock,
					p_businessstaus,
					p_isservice
			    FROM ' . TABLE_PREFIX . 'product
			    WHERE p_onsitestatus > 0';

		if(count($catidlist) > 0) //for get view company or category
			$sql .= ' AND pc_id IN(' . implode(',', $catidlist) . ')';

		if(count($vendorlist) > 0)
			$sql .= ' AND v_id IN(' . implode(',', $vendorlist) . ')';

		$stmt = $db->query($sql);

		while($row = $stmt->fetch())
		{
			$row['p_businessstaus'] = self::getstaticbusinessstatusName($row['p_businessstaus']);
			$outputList[] = $row;
		}
		return $outputList;
	}

	public static function getProductIdByIdList($productidlist = array() , $condition = array())
	{
		global $db;
		$outputList = array();

		if(count($productidlist) > 0)
		{
			foreach ($productidlist as $pid)
			{
				$sql = 'SELECT p_id ,
					pc_id,
					v_id,
					p_barcode,
					p_name,
					p_sellprice,
					p_unitprice,
					p_instock,
					p_businessstaus,
					p_isservice
			    FROM ' . TABLE_PREFIX . 'product
			    WHERE p_id = ? AND p_onsitestatus = ?';

				if(count($condition['fvidarr']) > 0)
				{
					$sql .= ' AND v_id IN('.implode(',', $condition['fvidarr']).')';
				}

				$row = $db->query($sql , array($pid , Core_Product::OS_ERP))->fetch();
				if((int)$row['p_id'] > 0)
				{
					$row['p_businessstaus'] = self::getstaticbusinessstatusName($row['p_businessstaus']);
					$outputList[] = $row;
				}
			}
		}


		return $outputList;
	}

	public static function getProductIdByVendor($vendoridlist = array())
	{
		global $db;
		$outputList = array();
		$sql = 'SELECT p_id ,
					pc_id,
					v_id,
					p_barcode,
					p_name,
					p_sellprice,
					p_unitprice,
					p_instock,
					p_isservice
			    FROM ' . TABLE_PREFIX . 'product
			    WHERE p_onsitestatus = ?';

		if(count($vendoridlist) > 0) //for get view company or category
			$sql .= ' AND v_id IN(' . implode(',', $vendoridlist) . ')';
		$stmt = $db->query($sql , array(Core_Product::OS_ERP));

		while($row = $stmt->fetch())
		{
			$outputList[] = $row;
		}
		return $outputList;
	}


	public static function getProductIDByBarcode($barcode = '')
	{
		global $db;
		if(strlen($barcode) > 0)
		{
			$sql = 'SELECT p_id ,
						p_barcode,
						pc_id ,
						p_name,
						v_id,
						p_isrequestimei,
						p_customizetype,
                        p_sellprice,
                        p_finalprice,
						p_isservice
					FROM ' . TABLE_PREFIX . 'product
					WHERE p_barcode = ?';
			$row = $db->query($sql , array($barcode))->fetch();

			return $row;
		}
	}

    public static function updateProductInfo($formData = array())
    {
        global $db;

        $myProduct = new Core_Product($formData['p_id']);

        if($myProduct->id > 0)
        {
            $myProduct->width = isset($formData['p_width']) ? $formData['p_width'] : $myProduct->width;
            $myProduct->length = isset($formData['p_length']) ? $formData['p_length'] : $myProduct->length;
            $myProduct->height = isset($formData['p_height']) ? $formData['p_height'] : $myProduct->height;
            $myProduct->weight = isset($formData['p_weight']) ? $formData['p_weight'] : $myProduct->weight;
            $myProduct->summarynew = isset($formData['p_summarynew']) ? $formData['p_summarynew'] : $myProduct->summarynew;

            if(count($formData) > 0)
            {
                $sql = 'UPDATE ' . TABLE_PREFIX . 'product
                        SET p_width = ?,
                            p_length = ?,
                            p_height = ?,
                            p_weight = ?,
                            p_summarynew = ?
                        WHERE p_id = ?';
                $stmt = $db->query($sql , array(
                                    $myProduct->width,
                                    $myProduct->length,
                                    $myProduct->height,
                                    $myProduct->weight,
                                    $myProduct->summarynew,
                                    $myProduct->id,
                               ));

                if($stmt)
                    return true;
                else
                    return false;
            }

        }

    }

    public static function getProductIDByBarcodeFromCache($barcode = '')
    {
        global $conf;
        $row = array();
        if(strlen($barcode) > 0)
        {
            $myCacher = new Cacher('pb:'.$barcode , Cacher::STORAGE_REDIS , $conf['redis'][1]);
            $data = $myCacher->get();
            //echodebug($data,true);
            if($data !== false)
            {
                $datainfo = explode(':' , $data);
                $row['p_id'] = $datainfo[0];
                $row['p_barcode'] = $datainfo[3];
                $row['pc_id'] = $datainfo[2];
                $row['p_name'] = $datainfo[1];
                $row['v_id'] = $datainfo[4];
                $row['p_isrequestimei'] = $datainfo[5];
                $row['p_isservice'] = $datainfo[6];
            }
        }

        return $row;
    }

	public static function getallproduct()
	{
		$outputList = array();
		global $db;

		$sql = 'SELECT p_id, p_name , p_barcode FROM ' . TABLE_PREFIX . 'product';
		$stmt = $db->query($sql, array());

		while ($row = $stmt->fetch())
		{
			$outputList[] = $row;

			unset($row);
		}

		return $outputList;
	}

	public static function sortproductbyfilter($productidlist = array())
	{
		$outputList = array();
		$resultlist = array();
		if(count($productidlist) > 0)
		{
			foreach ( $productidlist as $productid )
			{
				$myProduct = new Core_Product($productid);
				if($myProduct->finalprice > 0)
					$outputList[$myProduct->id] = $myProduct->finalprice;
				else
					$outputList[$myProduct->id] = $myProduct->sellprice;

			}
			arsort($outputList);
			$resultlist = array_keys($outputList);
		}


		return $resultlist;
	}

	public static function isBarcodeExist($barcode)
	{
		global $db;
		$isExist = false;
		if(strlen($barcode) > 0)
		{
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product
					WHERE p_barcode = ?';
			$rowCount = $db->query($sql , array($barcode))->fetchColumn(0);

			if($rowCount > 0)
				$isExist = true;
		}

		return $isExist;
	}

	public function getProductColor($pid = 0)
	{
		$npid = $this->id;
		if ($pid > 0) $npid = $pid;
		$relproducts = array();
		/*$getRelProductProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $npid, 'ftype' => Core_RelProductProduct::TYPE_COLOR), '', '');
		$relproducts = array();
		if (!empty($getRelProductProduct))
		{
			foreach ($getRelProductProduct as $relitem)
			{
				if (!in_array($relitem->piddestination, $relproducts)) $relproducts[] = $relitem->piddestination;
			}
		}*/
		$explodecolor = explode('###', $this->colorlist);
		if (!empty($explodecolor))
		{
			foreach ($explodecolor as $itemcolor)
			{
				$getproductids = explode(':', $itemcolor);
				if (!empty($getproductids) && !empty($getproductids[0]) && !in_array($getproductids[0], $relproducts))
				{
					$relproducts[] = $getproductids[0];
				}
			}
		}

        $getRelProductProduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $npid, 'ftype' => Core_RelProductProduct::TYPE_COLOR), '', '');

        if (count($getRelProductProduct) > 0) {
            foreach ($getRelProductProduct as $relproduct) {
                if (!in_array($reproduct->piddestination , $relproducts) && preg_match('/[a-zA-Z0-9 ]+:[a-zA-Z0-9]+/' , $relproduct->typevalue, $out) > 0 ) {
                    $relproducts[] = $relproduct->piddestination;
                }
            }
        }

		return $relproducts;
	}

	public static function searchproductinfo($formData = array())
	{
		global $db;
		$productlist = array();
		$sql = 'SELECT p_id , p_name , p_barcode , p_businessstaus , p_finalprice , p_sellprice FROM ' .  TABLE_PREFIX . 'product p ';
		$whereString = '';

		if($formData['fname'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_name LIKE "%'.Helper::unspecialtext((string)$formData['fname']).'%" ';

		if($formData['fbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = "'.Helper::unspecialtext((string)$formData['fbarcode']).'" ';

		if(is_array($formData['fpcidarrin']))
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id IN( '.implode(',' , $formData['fpcidarrin']).') ';

		if(count($formData['fbusinessstatusarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_businessstaus IN (' . implode(',', $formData['fbusinessstatusarr']) . ') ';

        if(count($formData['fvidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.v_id IN ('.implode(',',$formData['fvidarr']).') ';

        $sql .= ' WHERE ' . $whereString . ' AND p_onsitestatus = '.Core_Product::OS_ERP.' ORDER BY p_id';

        $stmt = $db->query($sql);
        while ( $row = $stmt->fetch())
        {
        	$productlist[] = $row;
        }

        return $productlist;
	}

	public static function getMainProductFromColor($piddestination = 0)
	{
		global $db;
		$sql = 'SELECT p_idsource FROM ' . TABLE_PREFIX . 'rel_product_product WHERE p_iddestination = ? AND pp_type = ?';
		$row = $db->query($sql , array($piddestination , Core_RelProductProduct::TYPE_COLOR))->fetch();
		$product = new Core_Product($row['p_idsource'] , true);

		return $product;
	}

	public function checkimagevalid($imagepath)
    {
        $pass = true;

		$file_headers = @get_headers($imagepath);
		if($file_headers[0] == 'HTTP/1.1 404 Not Found')
		{
		    $pass = false;
		}
		else
		{
		    $pass = true;
		}

        return $pass;
    }
    public static function getStoreAvailable($barcode)
    {
    	$listallstoreavaible = self::getSpecialStore();

    	$specialstore = $listallstoreavaible['specialstore'];
    	$storehcm = $listallstoreavaible['storehcm'];

    	$storeList = array();
    	$productStockData = array();
    	$productStockData['fpbarcode'] = $barcode;
    	$productStockData['fhavequantity'] = true;
    	$productStocks = Core_ProductStock::getProductStocks($productStockData , 'id' , 'ASC');

    	$allstorewithout919 = array();
    	foreach ($productStocks as $key => $productStock)
    	{
    		# Kiem tra sieu thi, vi chua co storelist nao nen chi assign khong can merge
    		if($productStock->sid == 919 && empty($storeList))
			{
			  	$storeList = $storehcm;//array_merge($storehcm,$storeList);
			  	//break;
			}
			elseif ($productStock->sid != 919 && !in_array($productStock->sid , $specialstore))
			{
				$allstorewithout919[$productStock->sid] = $productStock;
			}
		}
		unset($productStock);
		unset($productStocks);
    	if (!empty($allstorewithout919))
    	{
			foreach ($allstorewithout919 as $sid => $productStock)
			{
				if ($productStock->sid == 919) continue;
                if(Core_Store::checkisMarket($productStock->sid) && !in_array($productStock->sid , $storeList))
			   {
				    $storeList[] = $productStock->sid;
			   }
			   else{
				   $myStore = new Core_Store($productStock->sid , true);
				   $market = Core_Store::getMainMarket($myStore->storegroupid);
				   if($market > 0 && !in_array($market , $storeList))
				   {
					    $storeList[] = $market;
				   }
				}
			}
    	}
    	/*foreach ($productStocks as $key => $productStock) {
    		# Kiem tra sieu thi
    		if($productStock->sid == 919)
			{
			  	$storeList = array_merge($storehcm,$storeList);
			  	break;
			}
    	}

    	foreach ($productStocks as $key => $productStock) {
    		if($productStock->sid != 919)
    		{
	    		if(!in_array($productStock->sid , $specialstore))
			    {
				   if(Core_Store::checkisMarket($productStock->sid) && !in_array($productStock->sid , $storeList))
				   {
				    	$storeList[] = $productStock->sid;
				   }
				   else{
					   $myStore = new Core_Store($productStock->sid , true);
					   $market = Core_Store::getMainMarket($myStore->storegroupid);
					   if($market > 0 && !in_array($market , $storeList))
					   {
					    	$storeList[] = $market;
					   }
					}
			    }
			}
    	}*/
    	return $storeList;
    }

    public static function getSpecialStore()
    {
		$specialstore = array(988 , 997, 963, 840, 837, 811, 790 , 791 , 806 , 855 , 877 , 946 , 947, 948, 949, 974, 978, 988, 990, 991, 992, 993, 994, 995, 760); // day la nhung kho ma se khong tinh ton kho vao san pham , neu phat sinh them thi them id cua store vao mang nay
    	$storehcm = array(999,688,962,836);
    	return array('specialstore' => $specialstore, 'storehcm' => $storehcm);
    }

    public function updateproductcolor()
	{
		$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_colorlist = ? WHERE p_id = ?';
		$stmt = $this->db->query($sql , array($this->colorlist , $this->id));
	}
}
//de ben ngoai class nha
function vendor_cmp($v1, $v2)
{
	if(!empty($v1) && !empty($v2) && !empty($v1->name) && !empty($v2->name))
	{
		return strcmp($v1->name, $v2->name);
	}
	else
		return false;
}



