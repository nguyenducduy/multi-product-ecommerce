<?php

/**
 * core/class.brandcategory.php
 *
 * File contains the class used for BrandCategory Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_BrandCategory extends Core_Object
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLED = 2;
    public $pcid = 0;
    public $vid = 0;
    public $id = 0;
    public $name = "";
    public $seotitle = "";
    public $seokeyword = "";
    public $seodescription = "";
    public $titlecol1 = "";
    public $desccol1 = "";
    public $titlecol2 = "";
    public $desccol2 = "";
    public $titlecol3 = "";
    public $desccol3 = "";
    public $topseokeyword = "";
    public $footerkey = "";
    public $status = 0;
    public $datecreated = 0;
    public $datemodified = 0;

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


        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'brand_category (
					pc_id,
					v_id,
					bc_name,
					bc_seotitle,
					bc_seokeyword,
					bc_seodescription,
					bc_titlecol1,
					bc_desccol1,
					bc_titlecol2,
					bc_desccol2,
					bc_titlecol3,
					bc_desccol3,
					bc_topseokeyword,
					bc_footerkey,
					bc_status,
					bc_datecreated,
					bc_datemodified
					)
		        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
            (int)$this->pcid,
            (int)$this->vid,
            (string)$this->name,
            (string)$this->seotitle,
            (string)$this->seokeyword,
            (string)$this->seodescription,
            (string)$this->titlecol1,
            (string)$this->desccol1,
            (string)$this->titlecol2,
            (string)$this->desccol2,
            (string)$this->titlecol3,
            (string)$this->desccol3,
            (string)$this->topseokeyword,
            (string)$this->footerkey,
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


        $sql = 'UPDATE ' . TABLE_PREFIX . 'brand_category
				SET pc_id = ?,
					v_id = ?,
					bc_name = ?,
					bc_seotitle = ?,
					bc_seokeyword = ?,
					bc_seodescription = ?,
					bc_titlecol1 = ?,
					bc_desccol1 = ?,
					bc_titlecol2 = ?,
					bc_desccol2 = ?,
					bc_titlecol3 = ?,
					bc_desccol3 = ?,
					bc_topseokeyword = ?,
					bc_footerkey = ?,
					bc_status = ?,
					bc_datecreated = ?,
					bc_datemodified = ?
				WHERE bc_id = ?';

        $stmt = $this->db->query($sql, array(
            (int)$this->pcid,
            (int)$this->vid,
            (string)$this->name,
            (string)$this->seotitle,
            (string)$this->seokeyword,
            (string)$this->seodescription,
            (string)$this->titlecol1,
            (string)$this->desccol1,
            (string)$this->titlecol2,
            (string)$this->desccol2,
            (string)$this->titlecol3,
            (string)$this->desccol3,
            (string)$this->topseokeyword,
            (string)$this->footerkey,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'brand_category bc
				WHERE bc.bc_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();

        $this->pcid = $row['pc_id'];
        $this->vid = $row['v_id'];
        $this->id = $row['bc_id'];
        $this->name = $row['bc_name'];
        $this->seotitle = $row['bc_seotitle'];
        $this->seokeyword = $row['bc_seokeyword'];
        $this->seodescription = $row['bc_seodescription'];
        $this->titlecol1 = $row['bc_titlecol1'];
        $this->desccol1 = $row['bc_desccol1'];
        $this->titlecol2 = $row['bc_titlecol2'];
        $this->desccol2 = $row['bc_desccol2'];
        $this->titlecol3 = $row['bc_titlecol3'];
        $this->desccol3 = $row['bc_desccol3'];
        $this->topseokeyword = $row['bc_topseokeyword'];
        $this->footerkey = $row['bc_footerkey'];
        $this->status = $row['bc_status'];
        $this->datecreated = $row['bc_datecreated'];
        $this->datemodified = $row['bc_datemodified'];

    }

    /**
     * Get the object data base on foreign key
     * @param int $vid : the foreign keyvalue for searching record.
     */
    public static function getDatabyVendor($vid, $fpcid)
    {
        global $db;
        $vid = (int)$vid;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'brand_category bc
				WHERE bc.v_id = ? and bc.pc_id = ? order by bc_id DESC';
        $row = $db->query($sql, array($vid, $fpcid))->fetch();
        $myBrandCategory = new Core_BrandCategory();
        $myBrandCategory->pcid = $row['pc_id'];
        $myBrandCategory->vid = $row['v_id'];
        $myBrandCategory->id = $row['bc_id'];
        $myBrandCategory->name = $row['bc_name'];
        $myBrandCategory->seotitle = $row['bc_seotitle'];
        $myBrandCategory->seokeyword = $row['bc_seokeyword'];
        $myBrandCategory->seodescription = $row['bc_seodescription'];
        $myBrandCategory->titlecol1 = $row['bc_titlecol1'];
        $myBrandCategory->desccol1 = $row['bc_desccol1'];
        $myBrandCategory->titlecol2 = $row['bc_titlecol2'];
        $myBrandCategory->desccol2 = $row['bc_desccol2'];
        $myBrandCategory->titlecol3 = $row['bc_titlecol3'];
        $myBrandCategory->desccol3 = $row['bc_desccol3'];
        $myBrandCategory->topseokeyword = $row['bc_topseokeyword'];
        $myBrandCategory->footerkey = $row['bc_footerkey'];
        $myBrandCategory->status = $row['bc_status'];
        $myBrandCategory->datecreated = $row['bc_datecreated'];
        $myBrandCategory->datemodified = $row['bc_datemodified'];

        return $myBrandCategory;

    }
    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'brand_category
				WHERE bc_id = ?';
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

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'brand_category bc';

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

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'brand_category bc';

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
            $myBrandCategory = new Core_BrandCategory();

            $myBrandCategory->pcid = $row['pc_id'];
            $myBrandCategory->vid = $row['v_id'];
            $myBrandCategory->id = $row['bc_id'];
            $myBrandCategory->name = $row['bc_name'];
            $myBrandCategory->seotitle = $row['bc_seotitle'];
            $myBrandCategory->seokeyword = $row['bc_seokeyword'];
            $myBrandCategory->seodescription = $row['bc_seodescription'];
            $myBrandCategory->titlecol1 = $row['bc_titlecol1'];
            $myBrandCategory->desccol1 = $row['bc_desccol1'];
            $myBrandCategory->titlecol2 = $row['bc_titlecol2'];
            $myBrandCategory->desccol2 = $row['bc_desccol2'];
            $myBrandCategory->titlecol3 = $row['bc_titlecol3'];
            $myBrandCategory->desccol3 = $row['bc_desccol3'];
            $myBrandCategory->topseokeyword = $row['bc_topseokeyword'];
            $myBrandCategory->footerkey = $row['bc_footerkey'];
            $myBrandCategory->status = $row['bc_status'];
            $myBrandCategory->datecreated = $row['bc_datecreated'];
            $myBrandCategory->datemodified = $row['bc_datemodified'];


            $outputList[] = $myBrandCategory;
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
    public static function getBrandCategorys($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if($formData['fpcid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.pc_id = '.(int)$formData['fpcid'].' ';

        if($formData['fvid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.v_id = '.(int)$formData['fvid'].' ';

        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_id = '.(int)$formData['fid'].' ';

        if($formData['fname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_name LIKE \'%'.Helper::unspecialtext((string)$formData['fname']).'%\' ';

        if($formData['fstatus'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_status = '.(int)$formData['fstatus'].' ';

        if($formData['fdatecreated'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_datecreated = '.(int)$formData['fdatecreated'].' ';

        if($formData['fdatemodified'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_datemodified = '.(int)$formData['fdatemodified'].' ';



        if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'name')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'bc.bc_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (bc.bc_name LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }

        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'pcid')
            $orderString = 'pc_id ' . $sorttype;
        elseif($sortby == 'vid')
            $orderString = 'v_id ' . $sorttype;
        elseif($sortby == 'id')
            $orderString = 'bc_id ' . $sorttype;
        elseif($sortby == 'name')
            $orderString = 'bc_name ' . $sorttype;
        elseif($sortby == 'status')
            $orderString = 'bc_status ' . $sorttype;
        elseif($sortby == 'datecreated')
            $orderString = 'bc_datecreated ' . $sorttype;
        elseif($sortby == 'datemodified')
            $orderString = 'bc_datemodified ' . $sorttype;
        else
            $orderString = 'bc_id ' . $sorttype;

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

    public static function getProductCategoryNameByID($id)
    {
        global $db;
        $sql = 'SELECT pc_id,pc_name FROM '.TABLE_PREFIX.'productcategory WHERE pc_id = ?';
        $stmt = $db->query($sql,array($id))->fetch();
        return $stmt['pc_name'];

    }
    public static function getVendorNameByID($id)
    {
        global $db;
        $sql = 'SELECT v_id,v_name FROM '.TABLE_PREFIX.'vendor WHERE v_id = ?';
        $stmt = $db->query($sql,array($id))->fetch();
        return $stmt['v_name'];

    }
    public function checkStatusName($name)
    {
        $name = strtolower($name);
        if($this->status == self::STATUS_ENABLE && $name == 'enable' || $this->status == self::STATUS_DISABLED && $name == 'disabled')
            return true;
        else
            return false;

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


}