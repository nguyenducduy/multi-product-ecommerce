<?php

/**
 * core/class.productcategory.php
 *
 * File contains the class used for Productcategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Productcategory extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;

    const ITEM_ID = 0;
    const ITEM_PRICE_ASC = 4;
    const ITEM_PRICE_DESC = 6;
    const ITEM_DISPLAYORDER = 8;
    const ITEM_PRICE_SEGMENT = 10;
    const ITEM_PRICE_SEGMENT_ASC = 12;
    const ITEM_PRICE_SEGMENT_DESC = 14;
    const ITEM_PRICE_SEGMENT_DISPLAYORDER = 16;

    public $id                    = 0;
    public $image                 = "";
    public $resourceserver        = 0;
    public $name                  = "";
    public $displaytext           = "";
    public $slug                  = "";
    public $summary               = "";
    public $blockhomepagehorizon  = "";
    public $blockhomepagevertical = "";
    public $blockcategory         = "";
    public $seotitle              = "";
    public $seokeyword            = "";
    public $seodescription        = "";
    public $metarobot             = '';
    public $titlecol1             = '';
    public $desccol1              = '';
    public $titlecol2             = '';
    public $desccol2              = '';
    public $titlecol3             = '';
    public $desccol3              = '';
    public $topseokeyword         = "";
    public $footerkey             = "";
    public $parentid              = 0;
    public $countitem             = 0;
    public $pricesegment          = "";
    public $vendorlist            = "";
    public $producthomepagelist   = "";
    public $topitemlist = "";
    public $displayorder          = 0;
    public $itemdisplayorder      = 0;
    public $categoryreference     = "";
    public $parent                = array();
    public $sublist               = array();
    public $status                = 0;
    public $datecreated           = 0;
    public $datemodified          = 0;
    public $appendtoproductname   = 0;

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

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'productcategory (
					pc_image,
					pc_resourceserver,
					pc_name,
                    pc_displaytext,
					pc_slug,
					pc_summary,
                    pc_blockhomepagehorizon,
                    pc_blockhomepagevertical,
                    pc_blockcategory,
					pc_seotitle,
					pc_seokeyword,
					pc_seodescription,
					pc_metarobot,
					pc_titlecol1,
					pc_desccol1,
					pc_titlecol2,
					pc_desccol2,
					pc_titlecol3,
					pc_desccol3,
					pc_topseokeyword,
					pc_footerkey,
					pc_parentid,
					pc_countitem,
					pc_pricesegment,
					pc_vendorlist,
					pc_producthomepagelist,
                    pc_topitemlist,
					pc_displayorder,
					pc_itemdisplayorder,
                    pc_categoryreference,
					pc_status,
					pc_datecreated,
					pc_datemodified,
					pc_appendtoproductname
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
            (string)$this->image,
            (int)$this->resourceserver,
            (string)$this->name,
            (string)$this->displaytext,
            (string)$this->slug,
            (string)$this->summary,
            (string)$this->blockhomepagehorizon,
            (string)$this->blockhomepagevertical,
            (string)$this->blockcategory,
            (string)$this->seotitle,
            (string)$this->seokeyword,
            (string)$this->seodescription,
            (string)$this->metarobot,
            (string)$this->titlecol1,
            (string)$this->desccol1,
            (string)$this->titlecol2,
            (string)$this->desccol2,
            (string)$this->titlecol3,
            (string)$this->desccol3,
            (string)$this->topseokeyword,
            (string)$this->footerkey,
            (int)$this->parentid,
            (int)$this->countitem,
            (string)$this->pricesegment,
            (string)$this->vendorlist,
            (string)$this->producthomepagelist,
            (string)$this->topitemlist,
            (int)$this->displayorder,
            (int)$this->itemdisplayorder,
            (string)$this->categoryreference,
            (int)$this->status,
            (int)$this->datecreated,
            (int)$this->datemodified,
            (int)$this->appendtoproductname
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'productcategory
                            SET pc_image = ?,
                            	pc_resourceserver = 0
                            WHERE pc_id = ?';
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


        $sql = 'UPDATE ' . TABLE_PREFIX . 'productcategory
				SET pc_image = ?,
					pc_resourceserver = ?,
					pc_name = ?,
                    pc_displaytext = ?,
					pc_slug = ?,
					pc_summary = ?,
                    pc_blockhomepagehorizon = ?,
                    pc_blockhomepagevertical = ?,
                    pc_blockcategory = ?,
					pc_seotitle = ?,
					pc_seokeyword = ?,
					pc_seodescription = ?,
					pc_metarobot = ?,
					pc_titlecol1=?,
					pc_desccol1 = ?,
					pc_titlecol2 = ?,
					pc_desccol2=?,
					pc_titlecol3 = ?,
					pc_desccol3 = ?,
					pc_topseokeyword = ?,
					pc_footerkey = ?,
					pc_parentid = ?,
					pc_countitem = ?,
					pc_pricesegment = ?,
					pc_vendorlist = ?,
					pc_producthomepagelist = ?,
                    pc_topitemlist = ?,
					pc_displayorder = ?,
					pc_itemdisplayorder = ?,
                    pc_categoryreference = ?,
					pc_status = ?,
					pc_datecreated = ?,
					pc_datemodified = ?,
					pc_appendtoproductname = ?
				WHERE pc_id = ?';

        $stmt = $this->db->query($sql, array(
            (string)$this->image,
            (int)$this->resourceserver,
            (string)$this->name,
            (string)$this->displaytext,
            (string)$this->slug,
            (string)$this->summary,
            (string)$this->blockhomepagehorizon,
            (string)$this->blockhomepagevertical,
            (string)$this->blockcategory,
            (string)$this->seotitle,
            (string)$this->seokeyword,
            (string)$this->seodescription,
            (string)$this->metarobot,
            (string)$this->titlecol1,
            (string)$this->desccol1,
            (string)$this->titlecol2,
            (string)$this->desccol2,
            (string)$this->titlecol3,
            (string)$this->desccol3,
            (string)$this->topseokeyword,
            (string)$this->footerkey,
            (int)$this->parentid,
            (int)$this->countitem,
            (string)$this->pricesegment,
            (string)$this->vendorlist,
            (string)$this->producthomepagelist,
            (string)$this->topitemlist,
            (int)$this->displayorder,
            (int)$this->itemdisplayorder,
            (string)$this->categoryreference,
            (int)$this->status,
            (int)$this->datecreated,
            (int)$this->datemodified,
            (int)$this->appendtoproductname,
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
                    $sql = 'UPDATE ' . TABLE_PREFIX . 'productcategory
                            SET pc_image = ?,
                            	pc_resourceserver = ?
                            WHERE pc_id = ?';
                    $result=$this->db->query($sql, array($this->image,$this->resourceserver, $this->id));
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory p
				WHERE p.pc_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();

        $this->id                    = $row['pc_id'];
        $this->image                 = $row['pc_image'];
        $this->resourceserver        = $row['pc_resourceserver'];
        $this->name                  = $row['pc_name'];
        $this->displaytext           = $row['pc_displaytext'];
        $this->slug                  = $row['pc_slug'];
        $this->summary               = $row['pc_summary'];
        $this->blockhomepagehorizon  = $row['pc_blockhomepagehorizon'];
        $this->blockhomepagevertical = $row['pc_blockhomepagevertical'];
        $this->blockcategory         = $row['pc_blockcategory'];
        $this->seotitle              = $row['pc_seotitle'];
        $this->seokeyword            = $row['pc_seokeyword'];
        $this->seodescription        = $row['pc_seodescription'];
        $this->metarobot             = $row['pc_metarobot'];
        $this->titlecol1             = $row['pc_titlecol1'];
        $this->titlecol2             = $row['pc_titlecol2'];
        $this->titlecol3             = $row['pc_titlecol3'];
        $this->desccol1              = $row['pc_desccol1'];
        $this->desccol2              = $row['pc_desccol2'];
        $this->desccol3              = $row['pc_desccol3'];
        $this->topseokeyword         = $row['pc_topseokeyword'];
        $this->footerkey             = $row['pc_footerkey'];
        $this->parentid              = $row['pc_parentid'];
        $this->countitem             = $row['pc_countitem'];
        $this->pricesegment          = $row['pc_pricesegment'];
        $this->vendorlist            = $row['pc_vendorlist'];
        $this->producthomepagelist   = $row['pc_producthomepagelist'];
        $this->topitemlist = $row['pc_topitemlist'];
        $this->displayorder          = $row['pc_displayorder'];
        $this->itemdisplayorder      = $row['pc_itemdisplayorder'];
        $this->categoryreference = $row['pc_categoryreference'];
        $this->status                = $row['pc_status'];
        $this->datecreated           = $row['pc_datecreated'];
        $this->datemodified          = $row['pc_datemodified'];
        $this->appendtoproductname   = $row['pc_appendtoproductname'];

    }


    public function getDataByArray($row)
    {
        $this->id                    = $row['pc_id'];
        $this->image                 = $row['pc_image'];
        $this->resourceserver        = $row['pc_resourceserver'];
        $this->name                  = $row['pc_name'];
        $this->displaytext           = $row['pc_displaytext'];
        $this->slug                  = $row['pc_slug'];
        $this->summary               = $row['pc_summary'];
        $this->blockhomepagehorizon  = $row['pc_blockhomepagehorizon'];
        $this->blockhomepagevertical = $row['pc_blockhomepagevertical'];
        $this->blockcategory         = $row['pc_blockcategory'];
        $this->seotitle              = $row['pc_seotitle'];
        $this->seokeyword            = $row['pc_seokeyword'];
        $this->seodescription        = $row['pc_seodescription'];
        $this->metarobot             = $row['pc_metarobot'];
        $this->titlecol1             = $row['pc_titlecol1'];
        $this->titlecol2             = $row['pc_titlecol2'];
        $this->titlecol3             = $row['pc_titlecol3'];
        $this->desccol1              = $row['pc_desccol1'];
        $this->desccol2              = $row['pc_desccol2'];
        $this->desccol3              = $row['pc_desccol3'];
        $this->topseokeyword         = $row['pc_topseokeyword'];
        $this->footerkey             = $row['pc_footerkey'];
        $this->parentid              = $row['pc_parentid'];
        $this->countitem             = $row['pc_countitem'];
        $this->pricesegment          = $row['pc_pricesegment'];
        $this->vendorlist            = $row['pc_vendorlist'];
        $this->producthomepagelist   = $row['pc_producthomepagelist'];
        $this->topitemlist = $row['pc_topitemlist'];
        $this->displayorder          = $row['pc_displayorder'];
        $this->itemdisplayorder      = $row['pc_itemdisplayorder'];
        $this->categoryreference = $row['pc_categoryreference'];
        $this->status                = $row['pc_status'];
        $this->datecreated           = $row['pc_datecreated'];
        $this->datemodified          = $row['pc_datemodified'];
        $this->appendtoproductname   = $row['pc_appendtoproductname'];

    }

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'productcategory
				WHERE pc_id = ?';
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

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productcategory p';

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

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory p';

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
            $myProductcategory                        = new Core_Productcategory();

            $myProductcategory->id                    = $row['pc_id'];
            $myProductcategory->image                 = $row['pc_image'];
            $myProductcategory->resourceserver        = $row['pc_resourceserver'];
            $myProductcategory->name                  = $row['pc_name'];
            $myProductcategory->displaytext           = $row['pc_displaytext'];
            $myProductcategory->slug                  = $row['pc_slug'];
            $myProductcategory->summary               = $row['pc_summary'];
            $myProductcategory->blockhomepagehorizon  = $row['pc_blockhomepagehorizon'];
            $myProductcategory->blockhomepagevertical = $row['pc_blockhomepagevertical'];
            $myProductcategory->blockcategory         = $row['pc_blockcategory'];
            $myProductcategory->seotitle              = $row['pc_seotitle'];
            $myProductcategory->seokeyword            = $row['pc_seokeyword'];
            $myProductcategory->seodescription        = $row['pc_seodescription'];
            $myProductcategory->metarobot             = $row['pc_metarobot'];
            $myProductcategory->titlecol1             = $row['pc_titlecol1'];
            $myProductcategory->titlecol2             = $row['pc_titlecol2'];
            $myProductcategory->titlecol3             = $row['pc_titlecol3'];
            $myProductcategory->desccol1              = $row['pc_desccol1'];
            $myProductcategory->desccol2              = $row['pc_desccol2'];
            $myProductcategory->desccol3              = $row['pc_desccol3'];
            $myProductcategory->topseokeyword         = $row['pc_topseokeyword'];
            $myProductcategory->footerkey             = $row['pc_footerkey'];
            $myProductcategory->parentid              = $row['pc_parentid'];
            $myProductcategory->pricesegment          = $row['pc_pricesegment'];
            $myProductcategory->vendorlist            = $row['pc_vendorlist'];
            $myProductcategory->producthomepagelist   = $row['pc_producthomepagelist'];
            $myProductcategory->topitemlist = $row['pc_topitemlist'];
            $myProductcategory->countitem             = $row['pc_countitem'];
            $myProductcategory->displayorder          = $row['pc_displayorder'];
            $myProductcategory->itemdisplayorder      = $row['pc_itemdisplayorder'];
            $myProductcategory->categoryreference = $row['pc_categoryreference'];
            $myProductcategory->status                = $row['pc_status'];
            $myProductcategory->datecreated           = $row['pc_datecreated'];
            $myProductcategory->datemodified          = $row['pc_datemodified'];
            $myProductcategory->appendtoproductname   = $row['pc_appendtoproductname'];


            $outputList[] = $myProductcategory;
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
    public static function getProductcategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id = '.(int)$formData['fid'].' ';

        if($formData['fsearchid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id = '.(int)$formData['fsearchid'].' ';

        if($formData['fname'] != '')
        {
            $formData['fname'] = Helper::codau2khongdau($formData['fname']);
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_name LIKE "%'.Helper::unspecialtext((string)$formData['fname']).'%" ';

        }

        if(isset($formData['fcountitemgreater0']))
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_countitem  >0 ';

        }
        if($formData['fvendorlist'] > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_vendorlist  != "" ';

        }

        if($formData['fslug'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_slug = "'.Helper::unspecialtext((string)$formData['fslug']).'" ';

        if(isset($formData['fparentid']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_parentid = '.(int)$formData['fparentid'].' ';

        if(isset($formData['fparent']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_parentid = 0 ';

        if($formData['fparentidall'] == 'all')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_parentid > 0 ';

        if($formData['fdisplayorder'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_displayorder = '.(int)$formData['fdisplayorder'].' ';

        if($formData['fstatus'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_status = '.(int)$formData['fstatus'].' ';

        if(count($formData['fidarr']) > 0 && $formData['fid'] == 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'pc_id IN ('.implode(',', $formData['fidarr']).') ';
        }

        if(isset($formData['fresourceserver']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_resourceserver = '.(int)$formData['fresourceserver'].' ';

        if(isset($formData['fhasimage']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_image != "" ';

        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'id')
            $orderString = 'pc_id ' . $sorttype;
        else if($sortby == 'parentid')
            $orderString = 'pc_parentid ' . $sorttype;
        elseif($sortby == 'name')
            $orderString = 'pc_parentid , pc_name ' . $sorttype;
        elseif($sortby == 'displayorder')
            $orderString = 'pc_displayorder ' . $sorttype;
        else
            $orderString = 'pc_displayorder ' . $sorttype;

        if($countOnly)
            return self::countList($whereString);
        else
            return self::getList($whereString, $orderString, $limit);
    }

    public function getMaxDisplayOrder()
    {
        $sql = 'SELECT MAX(pc_displayorder) FROM ' . TABLE_PREFIX . 'productcategory';
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

    public static function getitemdisplayorderList()
    {
        $output = array();

        $output[self::ITEM_ID] = 'Sắp xếp ID tăng dần';
        $output[self::ITEM_PRICE_ASC] = 'Sắp xếp giá tăng dần';
        $output[self::ITEM_PRICE_DESC] = 'Sắp xếp giá giảm dần';
        $output[self::ITEM_DISPLAYORDER] = 'Sắp xếp thứ tự hiển thị';
        $output[self::ITEM_PRICE_SEGMENT] = 'Sắp xếp phân khúc giá';
        $output[self::ITEM_PRICE_SEGMENT_ASC] = 'Sắp xếp giá tăng dần trong phân khúc giá';
        $output[self::ITEM_PRICE_SEGMENT_DESC] = 'Sắp xếp giá giảm dần trong phân khúc giá';
        $output[self::ITEM_PRICE_SEGMENT_DISPLAYORDER] = 'Sắp xếp thứ tự hiển thị trong phân khúc giá';


        return $output;
    }

    public function uploadImage()
    {
        global $registry;

        $curDateDir = Helper::getCurrentDateDirName();
        $extPart = substr(strrchr($_FILES['fimage']['name'],'.'),1);
        $namePart =  Helper::codau2khongdau($this->title, true) . '-' . $this->id . time();
        $name = $namePart . '.' . $extPart;
        $uploader = new Uploader($_FILES['fimage']['tmp_name'], $name, $registry->setting['productcategory']['imageDirectory'] . $curDateDir, '');

        $uploadError = $uploader->upload(false, $name);
        if($uploadError != Uploader::ERROR_UPLOAD_OK)
        {
            return $uploadError;
        }
        else
        {
            //Resize big image if needed
            $myImageResizer = new ImageResizer( $registry->setting['productcategory']['imageDirectory'] . $curDateDir, $name,
                $registry->setting['productcategory']['imageDirectory'] . $curDateDir, $name,
                $registry->setting['productcategory']['imageMaxWidth'],
                $registry->setting['productcategory']['imageMaxHeight'],
                '',
                $registry->setting['productcategory']['imageQuality']);
            $myImageResizer->output();
            unset($myImageResizer);

            //Create thum image
            $nameThumbPart = substr($name, 0, strrpos($name, '.'));
            $nameThumb = $nameThumbPart . '-small.' . $extPart;
            $myImageResizer = new ImageResizer(    $registry->setting['productcategory']['imageDirectory'] . $curDateDir, $name,
                $registry->setting['productcategory']['imageDirectory'] . $curDateDir, $nameThumb,
                $registry->setting['productcategory']['imageThumbWidth'],
                $registry->setting['productcategory']['imageThumbHeight'],
                $registry->setting['productcategory']['imageThumbRatio'],
                $registry->setting['productcategory']['imageQuality']);
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
            $file = $registry->setting['productcategory']['imageDirectory'] . $deletefile;
            if(file_exists($file) && is_file($file))
            {
                @unlink($file);

                //get small image name
                $pos = strrpos($deletefile, '.');
                $extPart = substr($deletefile, $pos+1);
                $namePart =  substr($deletefile,0, $pos);

                $deletesmallimage = $namePart . '-small.' . $extPart;
                $file = $registry->setting['productcategory']['imageDirectory'] . $deletesmallimage;
                if(file_exists($file) && is_file($file))
                    @unlink($file);

                $deletemediumimage = $namePart . '-medium.' . $extPart;
                $file = $registry->setting['productcategory']['imageDirectory'] . $deletemediumimage;
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
            $url = ResourceServer::getUrl($this->resourceserver) . 'productcategory/' . $filesmall;
        }
        else
        {
            $url = $registry->conf['rooturl'] . $registry->setting['productcategory']['imageDirectory'] . $filesmall;
        }


        return $url;
    }


    public function getImage()
    {
        global $registry;

        if($this->resourceserver > 0)
        {
            $url = ResourceServer::getUrl($this->resourceserver) . 'productcategory/' . $this->image;
        }
        else
        {
            $url = $registry->conf['rooturl'] . $registry->setting['productcategory']['imageDirectory'] . $this->image;
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

    /**
     * [getFullParentProductCategorys description]
     * @param  [type] $categoryid [description]
     * @return [type]             [description]
     */
    public static function getFullParentProductCategorys($categoryid)
    {
        global $db, $registry;

        $myProductcategory = new Core_Productcategory($categoryid);

        $output = array();

        $sql = 'SELECT * FROM '.TABLE_PREFIX.'productcategory pc WHERE pc_id = ' . $myProductcategory->parentid . ' LIMIT 1';

        if($myProductcategory->id > 0)
        {
            $sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'productcategory pc
				WHERE pc_id = ' . $myProductcategory->parentid . ' LIMIT 1';

            $categoryList = $db->query($sql, array())->fetchAll();

            //echodebug($categoryList,true);
            foreach($categoryList as $category)
            {
                $pc = new Core_Productcategory();
                $category['fullpath'] = $pc->getProductcateoryPath($category['pc_id']);
                $output[] = $category;
                $output = array_merge($output, self::getFullParentProductCategorys($category['pc_id']));
            }
            $output = array_reverse($output);
        }
        return $output;
    }

    public static function getFullParentProductCategoryId($categoryid)
    {
        global $db , $registry;
        $myProductcategory = new Core_Productcategory($categoryid);

        $output = array();
        if($myProductcategory->id > 0)
        {
            $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory pc WHERE pc_id = ' . $myProductcategory->parentid . ' LIMIT 1';

            $categorylist = $db->query($sql)->fetchAll();

            foreach($categorylist as $row)
            {
                $output[] = $row['pc_id'];
                $output = array_merge($output , self::getFullParentProductCategoryId($row['pc_id']) );
            }
            $output = array_reverse($output);
        }
        return $output;
    }

    /**
     * [getSubListCategory description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public static function getSubListCategory($catid, $catlist = array())
    {
        $outputList = array();
        if(count($catlist) > 0)
        {
            $productcategory = new Core_Productcategory($catid);
            if($productcategory->parentid > 0)
                $productcategory->parent = self::getFullParentProductCategorys($productcategory->id);
            $outputList[] = $productcategory;
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

    public static function getFullSubCategory($catid , $getcurrentcat = true)
    {
        $outputList = array();
        if($getcurrentcat)
            $outputList[] = $catid;

        $catList = Core_Productcategory::getProductcategorys(array('fparentid' => $catid) , 'id' , 'ASC');
        if(count($catList) > 0)
        {
            foreach ($catList as $cat)
            {
                $outputList = array_merge($outputList , self::getFullSubCategory($cat->id));
            }
        }

        return $outputList;
    }

    public static function getFullSubCategoryList($catid)
    {
        $outputList = array();

        $currencategory = new Core_Productcategory($catid , true);

        if($currencategory->parentid > 0)
            $currencategory->parent = self::getFullParentProductCategorys($currencategory->id);

        $outputList[] = $currencategory;

        $catList = Core_Productcategory::getProductcategorys(array('fparentid' => $catid) , 'id' , 'ASC');
        if(count($catList) > 0)
        {
            foreach ($catList as $cat)
            {
                $outputList = array_merge($outputList , self::getFullSubCategoryList($cat->id));
            }
        }

        return $outputList;
    }


    public function getProductcateoryPath($id = 0)
    {
        global $registry;
        $productcategoryPath = $registry['conf']['rooturl'];

        if($id > 0)
        {
            $productcategory = new Core_Productcategory($id, true);
            $this->slug = $productcategory->slug;
        }

        if($this->slug != '')
        {
            $productcategoryPath .= $this->slug;
        }
        else
        {
            $productcategoryPath.'product/?pcid='.(!empty($id)?$id:$this->id);
        }

        return $productcategoryPath;
    }

    /**
     * [getPriceSegment description]
     * @return [type] [description]
     */
    public static function getPriceSegment($id)
    {
        global $db;
        $output = array();
        if($id > 0)
        {
            $sql = 'SELECT pc_pricesegment FROM ' . TABLE_PREFIX . 'productcategory
    				WHERE pc_id = ?';
            $row = $db->query($sql, array($id))->fetch();

            if(strlen($row['pc_pricesegment']) > 0)
            {
                $segment = explode('##', $row['pc_pricesegment']);
                $segmentList = array();

                foreach($segment as $seg)
                {
                    $temp = explode('#', $seg);
                    for($i = 1 ; $i < count($temp) ; $i++)
                    {
                        $temp[$i] = Helper::formatPrice($temp[$i]);
                    }
                    $segmentList[] = $temp;
                }
                $output[$id] = $segmentList;
            }
            else
            {
                $category = new Core_Productcategory($id);
                if($category->parentid > 0)
                {
                    $output[$category->parentid] =array_merge($output, self::getPriceSegment($category->parentid));
                }
            }
            return $output;
        }
    }

    public static function getSubProductcategory()
    {
        $rootparents = self::getProductcategorys(array('fparent'=>1) , 'id' , 'ASC');

        for($i = 0 , $counter = count($rootparents) ; $i < $counter ; $i++)
        {
            $rootparents[$i]->sublist = self::getProductcategorys(array('fparentid' => $rootparents[$i]->id) , 'id' , 'ASC');
        }

        return $rootparents;
    }

    public static function getFullCategoryList($parentId = '0', $level = 0 , $getAll = false)
    {
        global $db, $registry;
        $output = array();

        if($getAll)
        {
            $sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'productcategory pc
				WHERE pc_parentid = ?
				ORDER BY pc_displayorder ASC';

            $categoryList = $db->query($sql, array($parentId))->fetchAll();
        }
        else
        {
            $sql = 'SELECT *
				FROM ' . TABLE_PREFIX . 'productcategory pc
				WHERE pc_parentid = ?  AND pc_status = ?
				ORDER BY pc_displayorder ASC';

            $categoryList = $db->query($sql, array($parentId , self::STATUS_ENABLE))->fetchAll();
        }

        $level++;
        foreach($categoryList as $category)
        {
            $myCategory = new Core_Productcategory();
            $myCategory->getDataByArray($category);
            $myCategory->level = $level;

            $output[] = $myCategory;

            $children = self::getFullCategoryList($myCategory->id, $level , $getAll);

            if(count($children) > 0)
            {
                $output = array_merge($output, $children);
            }
        }
        return $output;
    }

    public static function getCategoryTree($pcid = 0 , $level = 1)
    {
        global $db , $registry;
        $output = array();

        if($pcid > 0)
        {
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory pc
					WHERE pc_parentid = ?
					ORDER BY pc_displayorder ASC';
            $categoryList = $db->query($sql, array($pcid))->fetchAll();

            foreach($categoryList as $category)
            {
                $myCategory = new Core_Productcategory();
                $myCategory->getDataByArray($category);
                $prefix = '';
                for($i = 0; $i < $level ; $i++)
                {
                    $prefix .= '&nbsp;';
                }
                $myCategory->name = $prefix . $myCategory->name;
                $output[] = $myCategory;
                $children = self::getCategoryTree($myCategory->id, $level+1);

                if(count($children) > 0)
                {
                    $output = array_merge($output, $children);
                }
            }
        }

        return $output;
    }

    public static function getRootProductcategory($getall = false)
    {
        global $db;
        $outputList = array();

       if($getall)
       {
           $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_parentid = 0';
           $stmt = $db->query($sql);
       }
       else
       {
           $sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_parentid = 0 AND pc_status = ?';
           $stmt = $db->query($sql , array(self::STATUS_ENABLE));
       }

        while ($row = $stmt->fetch())
        {
            $productcategory = new Core_Productcategory($row['pc_id'] , true);
            $outputList[] = $productcategory;
        }

        return $outputList;
    }

    public static function getProductcategoryInfo($id)
    {
        global $db;
        if($id > 0)
        {
            $sql = 'SELECT * FROM ' . TABLE_PREFIX .'productcategory WHERE pc_id = ?';
            $row = $db->query($sql , array($id))->fetch();

            return $row;
        }
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
        return 'pc_'.$id;
    }

    public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
    {
        global $db;

        $key = self::cacheBuildKey($id);

        $myProductcategory = new Core_Productcategory();

        //get current cache
        $myCacher = new Cacher($key);
        $row = $myCacher->get();

        //force to store new value
        if(!$row || isset($_GET['live']) || $forceSet)
        {
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productcategory pc
					WHERE pc.pc_id = ? ';
            $row = $db->query($sql, array($id))->fetch();
            if($row['pc_id'] > 0)
            {
                $myProductcategory->getDataByArray($row);

                //store new value
                Core_Object::cacheSet($key, $row);
            }
        }
        else
        {
            $myProductcategory->getDataByArray($row);
        }

        return $myProductcategory;
    }

    public static function getProductIdListFromCache($catid)
    {
        $productidlist = array();
        if((int)$catid > 0)
        {
            $myCacher = new Cacher('pc_'. $catid . ':productlist', Cacher::STORAGE_MEMCACHED, 86400 * 2);
            $data = $myCacher->get();
            if($data != false || strlen($data) > 0)
            {
                $dataarr = explode(',', $data);
                if(count($dataarr) > 0)
                {
                    foreach ($dataarr as $datavalue)
                    {
                        $valuearr = explode(':', $datavalue);
                        $productidlist[$valuearr[0]] = $valuearr[1];
                    }
                }
            }
        }

        return $productidlist;
    }

    public static function getCategoryIdTree(&$productcategoryidlist = array())
    {
        $categorylist = Core_Productcategory::getFullCategoryList();

        foreach ($categorylist as $category)
        {
            $productcategoryidlist[$category->id] = array();
            $productcategoryidlist[$category->id]['name'] = $category->name;
            $productcategoryidlist[$category->id]['link'] = $category->getProductcateoryPath();
            $productcategoryidlist[$category->id]['image'] = $category->getSmallImage();
//            $productcategoryidlist[$category->id]['path'] = $category->getProductcateoryPath;
            $productcategoryidlist[$category->id]['parent'] = self::getfullparentcategoryid($category->parentid , $categorylist);
            $productcategoryidlist[$category->id]['child'] = self::getsubcategoryidList($category->id , $categorylist);
            $productcategoryidlist[$category->id]['displayorder'] = $category->displayorder;
            $productcategoryidlist[$category->id]['status'] = $category->status;
        }
    }


    public static function getProductcategoryListFromCache($getroot = false , $ismobile = false)
    {
        $productcategorylist = array();

        $myCacher = new Cacher('catlist' , Cacher::STORAGE_MEMCACHED, 86400 * 2);
        $data = $myCacher->get();
        if($data != false)
        {
            $productcategorylist = json_decode($data , true);
        }
        else
        {
			//CREATE CACHE
            self::getCategoryIdTree($productcategorylist);
			$data = json_encode($productcategorylist);
			$myCacher->get((string)$data);
        }

        ////CHECK GET ROOT CATEGORY
        if($getroot)
        {
            $datalist = $productcategorylist;
            $productcategorylist = array();
            foreach ($datalist as $pcid => $data)
            {
                if(count($data['parent']) == 0)
                {
                    $productcategorylist[$pcid] = $data;
                }
            }
        }


        /////DETECT LINK FOR MOBILE
        if($ismobile)
        {
            if(count($productcategorylist) > 0)
            {
                $list = $productcategorylist;
                $productcategorylist = array();
                foreach($list as $catid => $catinfo)
                {
                    $productcategorylist[$catid]['name'] = $catinfo['name'];
                    $url = $catinfo['link'];
                    $parturl = explode('://', $url);

                    ///KIEM TRA XEM CO SUBDOMAIN m chua
                    if(preg_match('/^m.\w+/', $parturl[1]))
                        $productcategorylist[$catid]['link'] = $parturl[0] . '://' . $parturl[1];
                    else
                        $productcategorylist[$catid]['link'] = $parturl[0] . '://' . 'm.' .$parturl[1];

                    $productcategorylist[$catid]['image'] = $catinfo['image'];
                    $productcategorylist[$catid]['parent'] = $catinfo['parent'];
                    $productcategorylist[$catid]['child'] = $catinfo['child'];
                    $productcategorylist[$catid]['displayorder'] = $catinfo['parent'];
                }
            }
        }

        return $productcategorylist;
    }


    public static function getTreeDataHtml($active=array())
    {
        $htmlblock = '';
        $catlist = self::getProductcategoryListFromCache(true,true);
        $catfulllist = self::getProductcategoryListFromCache(false,true);
        foreach ($catlist as $catid => $value)
        {
            if($value['displayorder'] > 0)
            {
                if(count($active) > 0)
                {
                    $activehtml = $active[0] == $catid?'m-active':'';
                }
                $htmlblock .= '<li class="m-item '.$activehtml.'"><h3 class="m-header"><a><img src="'.$value['image'].'"style="float: left;margin-top: 9px;margin-right: 5px;"/>'.$value['name'].'</a></h3><div class="m-content"><div class="m-inner-content"><ul>';
                foreach ($value['child'] as $cid)
                {
                    if(count($catfulllist[$cid]['parent'])==1){
                        if($active[1] > 0)
                        {
                            $activehtml = $active[1] == $cid?'style="color:red"':'';
                        }
                        $htmlblock .= '<li><a href="'.$catfulllist[$cid]['link'].'" title="" '.$activehtml.' >'.$catfulllist[$cid]['name'].'</a>';
                    }
                    if(count($catfulllist[$cid]['child']) > 0)
                    {
                        $htmlblock .= '<ul>';
                        foreach ($catfulllist[$cid]['child'] as $childid)
                        {
                            if($active[1] > 0)
                            {
                                $activehtml = $active[1] == $childid?'style="color:red"':'';
                            }
                            $htmlblock .= '<li><a href="'.$catfulllist[$childid]['link'].'" title="" '.$activehtml.' >'.$catfulllist[$childid]['name'].'</a></li>';
                        }
                        $htmlblock .= '</ul>';
                    }
                    if(count($catfulllist[$cid]['parent'])==1){
                        $htmlblock .= '</li>';
                    }
                }
                $htmlblock .= '</ul></div></div></li>';
            }
        }

        return $htmlblock;
    }

    public static function getsubcategoryidList($parentid , $categorylist)
    {
        $subidlist = array();

        if(count($categorylist) > 0)
        {
            foreach ($categorylist as $category)
            {
                if($category->parentid == $parentid)
                {
                    $subidlist[] = $category->id;
                    $subidlist = array_merge($subidlist , self::getsubcategoryidList($category->id , $categorylist));
                }
            }
        }

        return $subidlist;
    }

    public static function getfullparentcategoryid($parentid , $categorylist)
    {
        $parentcategorylist = array();
        $listdata = array();
        if(count($categorylist) > 0)
        {
            foreach ($categorylist as $category)
            {
                if($category->id == $parentid)
                {
                    $listdata[] = $category->id;
                    $listdata = array_merge($listdata , self::getfullparentcategoryid($category->parentid , $categorylist));

                }
            }
            
            usort($listdata, 'cmp_level');
	        foreach ($listdata as $catid)
	        {
	        	$parentcategorylist[] = $catid;
	        }

        }

        return $parentcategorylist;
    }

    public static function getFullparentcategoryInfoFromCahe($catid)
    {
        $parentlist = array();
        $myCacher = new Cacher('catlist' , Cacher::STORAGE_MEMCACHED, 86400 * 2);
        $data = $myCacher->get();

        if($data != false)
        {
            //$productcategorylist = json_decode($data , true);
        }
		else
		{
			///CREATE CACHE CATEGORY
			Core_Productcategory::getCategoryIdTree($productcategorylist);
			$data = json_encode($productcategorylist);
			$myCacher->set((string)$data);
		}

		 if($productcategorylist[$catid]['parent'] > 0)
         {
			 foreach ($productcategorylist[$catid]['parent'] as $parentid)
             {
				 $parentlist[$parentid] = array('name' => $productcategorylist[$parentid]['name']);
             }
         }

         return $parentlist;
    }

    public static function getFullparentcategoryInfo($catid)
    {
        $parentlist = array();
        $productcategorylist = array();
        Core_Productcategory::getCategoryIdTree($productcategorylist);
        if($productcategorylist[(int)$catid]['parent'] > 0)
        {
            foreach ($productcategorylist[(int)$catid]['parent'] as $parentid)
            {
                $parentlist[$parentid] = array('name' => $productcategorylist[$parentid]['name']);
            }
        }
        return $parentlist;
    }

    public static function getFullSubCategoryFromCache($catid , $level = 1, $checkHaveProduct = false, $subdomain = '' , $ismobile = false)
    {
		global $db;
        $subidlist = array();
        $myCacher = new Cacher('catlist'.$subdomain , Cacher::STORAGE_MEMCACHED, 86400 * 2);
        $data = $myCacher->get();
        $productcategorylist = array();

        if($data != false)
        {
            $productcategorylist = json_decode($data , true);
        }
        else
        {
            ////CREATE CATEGORY LIST FROM CACHE
            Core_Productcategory::getCategoryIdTree($productcategorylist);

			$data = json_encode($productcategorylist);
			$myCacher->get((string)$data);
        }

        if ($productcategorylist[$catid]['child'] > 0)
        {
            foreach ($productcategorylist[$catid]['child'] as $subcatid)
            {
                if (count($productcategorylist[$subcatid]['parent']) <= $level)
                {
					if($checkHaveProduct)
					{
						$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ? AND p_onsitestatus = ?';
						$counter = $db->query($sql , array($subcatid , Core_Product::OS_ERP))->fetchColumn(0);
						if($counter > 0)
						{
                            /////DETECT LINK FOR MOBILE
                            $url = $productcategorylist[$subcatid]['link'];
                            $parturl = explode('://', $url);
                            $realurl = '';
                            if($ismobile)
                            {
                                ///KIEM TRA XEM CO SUBDOMAIN m chua
                                if(preg_match('/^m.\w+/', $parturl[1]))
                                    $realurl = $parturl[0] . '://' . $parturl[1];
                                else
                                    $realurl  = $parturl[0] . '://' . 'm.' .$parturl[1];
                            }
                            else
                            {
                                $realurl = $parturl[0] . '://' . str_replace('m.', '', $parturl[1]);
                            }

							$subidlist[$subcatid] = array('name' => $productcategorylist[$subcatid]['name'] , 'link' =>  $realurl);
						}
					}
					else
					{
                        /////DETECT LINK FOR MOBILE
                        $url = $productcategorylist[$subcatid]['link'];
                        $parturl = explode('://', $url);
                        $realurl = '';
                        if($ismobile)
                        {
                            ///KIEM TRA XEM CO SUBDOMAIN m chua
                            if(preg_match('/^m.\w+/', $parturl[1]))
                                $realurl = $parturl[0] . '://' . $parturl[1];
                            else
                                $realurl  = $parturl[0] . '://' . 'm.' .$parturl[1];
                        }
                        else
                        {
                            $realurl = $parturl[0] . '://' . str_replace('m.', '', $parturl[1]);
                        }
						$subidlist[$subcatid] = array('name' => $productcategorylist[$subcatid]['name'] , 'link' => $realurl );
					}
                }
            }
        }

        return $subidlist;
    }

    public static function getFullSubCategoryFromRedisCache($catid , $level = 1)
    {
        global $db, $conf;
        $subidlist = array();
        $myCacher = new Cacher('catlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);
        $data = $myCacher->get();
        $productcategorylist = array();

        if($data != false)
        {
            $productcategorylist = json_decode($data , true);
        }
        else
        {
            ////CREATE CATEGORY LIST FROM CACHE
            Core_Productcategory::getCategoryIdTree($productcategorylist);

			$data = json_encode($productcategorylist);
			$myCacher->get((string)$data);
        }
        if ($productcategorylist[$catid]['child'] > 0)
        {
            foreach ($productcategorylist[$catid]['child'] as $subcatid)
            {
                if (count($productcategorylist[$subcatid]['parent']) <= $level)
                {
					if($checkHaveProduct)
					{
						$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ? AND p_onsitestatus = ?';
						$counter = $db->query($sql , array($subcatid , Core_Product::OS_ERP))->fetchColumn(0);
						if($counter > 0)
						{
							$subidlist[$subcatid] = array('name' => $productcategorylist[$subcatid]['name'] , 'link' => $productcategorylist[$subcatid]['link'] );
						}
					}
					else
					{
						$subidlist[$subcatid] = array('name' => $productcategorylist[$subcatid]['name'] , 'link' => $productcategorylist[$subcatid]['link'] );
					}
                }
            }
        }

        return $subidlist;
    }

    public static function getFullparentcategoryInfoFromRedisCahe($catid)
    {
        global $conf;
        $parentlist = array();
        $myCacher = new Cacher('catlist' , Cacher::STORAGE_REDIS, $conf['redis'][1]);
        $data = $myCacher->get();

        if($data != false)
        {
            $productcategorylist = json_decode($data , true);
        }
		else
		{
			///// CREATE CACHE IF NOT EXIST
			Core_Productcategory::getCategoryIdTree($productcategorylist);

			$data = json_encode($productcategorylist);
			$myCacher->get((string)$data);
		}

		if($productcategorylist[$catid]['parent'] > 0)
        {
			foreach ($productcategorylist[$catid]['parent'] as $parentid)
            {
				$parentlist[$parentid] = array('name' => $productcategorylist[$parentid]['name']);
			}
        }

        return $parentlist;
    }


    public static function getProductlistFromCache($catid , $vidlist = array() , $bussinessstatuslist = array())
    {
        global $conf;
        $productlist = array();
        $myCacher = new Cacher('pc:list_' . $catid , Cacher::STORAGE_REDIS, $conf['redis'][1]);

        $data = $myCacher->get();
        if($data != false)
        {
            $datalist = explode('#', $data);
            foreach ($datalist as $info)
            {
                $infoarr = explode(':' , $info);

                if(count($vidlist) > 0)
                {
                    if(in_array($infoarr[1] , $vidlist))
                    {
                        if(count($bussinessstatuslist) > 0)
                        {
                            if(in_array($infoarr[5] , $bussinessstatuslist))
                            {
                                $attributelist = Core_RelProductAttribute::getAttributeFFilterOfProductFromCache($infoarr[0]);
                                $productlist[$infoarr[0]] = array('vid' => $infoarr[1],
                                                                'name' => $infoarr[2],
                                                                'barcode' => $infoarr[3],
                                                                'sellprice' => $infoarr[4],
                                                                'bussinessstatus' => $infoarr[5],
                                                                'attr' => $attributelist,
                                                                'color' => (strlen($infoarr[6]) > 0  ? explode(',', $infoarr[6]) : array()),
                                                                'customizetype' => $infoarr[7],
                                                                );
                            }
                        }
                        else
                        {
                            $attributelist = Core_RelProductAttribute::getAttributeFFilterOfProductFromCache($infoarr[0]);
                            $productlist[$infoarr[0]] = array('vid' => $infoarr[1],
                                                            'name' => $infoarr[2],
                                                            'barcode' => $infoarr[3],
                                                            'sellprice' => $infoarr[4],
                                                            'bussinessstatus' => $infoarr[5],
                                                            'attr' => $attributelist,
                                                            'color' => (strlen($infoarr[6]) > 0  ? explode(',', $infoarr[6]) : array()),
                                                            'customizetype' => $infoarr[7],
                                                            );
                        }
                    }

                }
                else
                {
                    if(count($bussinessstatuslist) > 0)
                    {
                        if(in_array($infoarr[5] , $bussinessstatuslist))
                        {
                            $attributelist = Core_RelProductAttribute::getAttributeFFilterOfProductFromCache($infoarr[0]);
                            $productlist[$infoarr[0]] = array('vid' => $infoarr[1],
                                                            'name' => $infoarr[2],
                                                            'barcode' => $infoarr[3],
                                                            'sellprice' => $infoarr[4],
                                                            'bussinessstatus' => $infoarr[5],
                                                            'attr' => $attributelist,
                                                            'color' => (strlen($infoarr[6]) > 0  ? explode(',', $infoarr[6]) : array()),
                                                            'customizetype' => $infoarr[7],
                                                            );
                        }
                    }
                    else
                    {
                        $attributelist = Core_RelProductAttribute::getAttributeFFilterOfProductFromCache($infoarr[0]);
                        $productlist[$infoarr[0]] = array('vid' => $infoarr[1],
                                                        'name' => $infoarr[2],
                                                        'barcode' => $infoarr[3],
                                                        'sellprice' => $infoarr[4],
                                                        'bussinessstatus' => $infoarr[5],
                                                        'attr' => $attributelist,
                                                        'color' => (strlen($infoarr[6]) > 0  ? explode(',', $infoarr[6]) : array()),
                                                        'customizetype' => $infoarr[7],
                                                        );
                    }
                }
            }
        }
        return $productlist;
    }

	public static function getProductlistFromCategory()
	{
		global $db;
		$resultlist = array();
		$sql = 'SELECT DISTINCT(pc_id) FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != ""' ;
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			////GET PRODUCT FORM PRODUCTCATEGORY
			$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ? AND p_barcode != ""';
			$resultset = $db->query($sql, array($row['pc_id']));
			while($result = $resultset->fetch())
			{
				$resultlist[$row['pc_id']][] = $result['p_id'];
			}
		}
		return $resultlist;
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
    public function clonecategoryname()
    {
        $this->displaytext = $this->name;
        if($this->updateData())
            return true;
        else
            return false;
    }

}

//ham nay de ngoai class
function cmp_level($category1 , $category2)
{
    if($category1->level == $category2->level)
    {
        return 0;
    }

    return ($category1->level >  $category2->level) ? 1 : -1;
}

