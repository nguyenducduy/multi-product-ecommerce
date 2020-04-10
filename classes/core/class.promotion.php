<?php

/**
 * core/class.promotion.php
 *
 * File contains the class used for Promotion Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Promotion extends Core_Object
{
    const STATUS_ENABLE = 0;
    const STATUS_DISABLED = 1;

    public $id = 0;
    public $usercreate = 0;
    public $useractive = 0;
    public $userdelete = 0;
    public $name = "";
    public $shortdescription = "";
    public $description = "";
    public $descriptionclone = "";
    public $isnew = 0;
    public $showtype = 0;
    public $isprintpromotion = 0;
    public $descriptionproductapply = "";
    public $descriptionpromotioninfo = "";
    public $ispromotionbyprice = 0;
    public $maxpromotionbyprice = 0;
    public $minpromotionbyprice = 0;
    public $ispromotionbytotalmoney = 0;
    public $maxpromotionbytotalmoney = 0;
    public $minpromotionbytotalmoney = 0;
    public $ispromotionbyquantity = 0;
    public $maxpromotionbyquantity = 0;
    public $minpromotionbyquantity = 0;
    public $ispromotionbyhour = 0;
    public $startpromotionbyhour = 0;
    public $endpromotionbyhour = 0;
    public $isloyalty = 0;
    public $isnotloyalty = 0;
    public $isimei = 0;
    public $iscombo = 0;
    public $isshowvat = 0;
    public $messagevat = 0;
    public $ispriorityinvoice = 0;
    public $isdiscountpercent = 0;
    public $discountvalue = 0;
    public $isconditiondiscount = 0;
    public $promolgconditiondiscounttext = "";
    public $typeapply = 0;
    public $isunlimited = 0;
    public $timepromotion = 0;
    public $url = "";
    public $ishot = 0;
    public $isactived = 0;
    public $image = "";
    public $isdeleted = 0;
    public $startdate = 0;
    public $enddate = 0;
    public $dateadd = 0;
    public $datemodify = 0;
    public $displayorder = 0;
    public $status = 0;

    public $pricepromo = 0;

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

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion (
                    promo_usercreate,
                    promo_useractive,
                    promo_userdelete,
                    promo_name,
                    promo_shortdescription,
                    promo_description,
                    promo_isnew,
                    promo_showtype,
                    promo_isprintpromotion,
                    promo_description_product_apply,
                    promo_description_promotioninfo,
                    promo_ispromotionbyprice,
                    promo_maxpromotionbyprice,
                    promo_minpromotionbyprice,
                    promo_ispromotionbytotalmoney,
                    promo_maxpromotionbytotalmoney,
                    promo_minpromotionbytotalmoney,
                    promo_ispromotionbyquantity,
                    promo_maxpromotionbyquantity,
                    promo_minpromotionbyquantity,
                    promo_ispromotionbyhour,
                    promo_startpromotionbyhour,
                    promo_endpromotionbyhour,
                    promo_isloyalty,
                    promo_isnotloyalty,
                    promo_isimei,
                    promo_iscombo,
                    promo_isshowvat,
                    promo_messagevat,
                    promo_ispriorityinvoice,
                    promo_isdiscountpercent,
                    promo_discountvalue,
                    promo_isconditiondiscount,
                    promolg_conditiondiscounttext,
                    promo_typeapply,
                    promo_isunlimited,
                    promo_timepromotion,
                    promo_islimittimesoncustomer,
                    promo_url,
                    promo_ishot,
                    promo_isactived,
                    promo_image,
                    promo_isdeleted,
                    promo_startdate,
                    promo_enddate,
                    promo_dateadd,
                    promo_datemodify,
                    promo_displayorder,
                    promo_status
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
                    (int)$this->usercreate,
                    (int)$this->useractive,
                    (int)$this->userdelete,
                    (string)$this->name,
                    (string)$this->shortdescription,
                    (string)$this->description,
                    (int)$this->isnew,
                    (int)$this->showtype,
                    (int)$this->isprintpromotion,
                    (string)$this->descriptionproductapply,
                    (string)$this->descriptionpromotioninfo,
                    (int)$this->ispromotionbyprice,
                    (float)$this->maxpromotionbyprice,
                    (float)$this->minpromotionbyprice,
                    (int)$this->ispromotionbytotalmoney,
                    (float)$this->maxpromotionbytotalmoney,
                    (float)$this->minpromotionbytotalmoney,
                    (int)$this->ispromotionbyquantity,
                    (float)$this->maxpromotionbyquantity,
                    (float)$this->minpromotionbyquantity,
                    (int)$this->ispromotionbyhour,
                    (int)$this->startpromotionbyhour,
                    (int)$this->endpromotionbyhour,
                    (int)$this->isloyalty,
                    (int)$this->isnotloyalty,
                    (int)$this->isimei,
                    (int)$this->iscombo,
                    (int)$this->isshowvat,
                    (int)$this->messagevat,
                    (int)$this->ispriorityinvoice,
                    (int)$this->isdiscountpercent,
                    (int)$this->discountvalue,
                    (int)$this->isconditiondiscount,
                    (string)$this->promolgconditiondiscounttext,
                    (int)$this->typeapply,
                    (int)$this->isunlimited,
                    (int)$this->timepromotion,
                    (int)$this->islimittimesoncustomer,
                    (string)$this->url,
                    (int)$this->ishot,
                    (int)$this->isactived,
                    (string)$this->image,
                    (int)$this->isdeleted,
                    (int)$this->startdate,
                    (int)$this->enddate,
                    (int)$this->dateadd,
                    (int)$this->datemodify,
                    (int)$this->displayorder,
                    (int)$this->status
                    ))->rowCount();

        $this->id = $this->db->lastInsertId();
        return $this->id;
    }

    public function addDataID()
    {

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'promotion (
                    promo_id,
                    promo_usercreate,
                    promo_useractive,
                    promo_userdelete,
                    promo_name,
                    promo_shortdescription,
                    promo_description,
                    promo_descriptionclone,
                    promo_isnew,
                    promo_showtype,
                    promo_isprintpromotion,
                    promo_description_product_apply,
                    promo_description_promotioninfo,
                    promo_ispromotionbyprice,
                    promo_maxpromotionbyprice,
                    promo_minpromotionbyprice,
                    promo_ispromotionbytotalmoney,
                    promo_maxpromotionbytotalmoney,
                    promo_minpromotionbytotalmoney,
                    promo_ispromotionbyquantity,
                    promo_maxpromotionbyquantity,
                    promo_minpromotionbyquantity,
                    promo_ispromotionbyhour,
                    promo_startpromotionbyhour,
                    promo_endpromotionbyhour,
                    promo_isloyalty,
                    promo_isnotloyalty,
                    promo_isimei,
                    promo_iscombo,
                    promo_isshowvat,
                    promo_messagevat,
                    promo_ispriorityinvoice,
                    promo_isdiscountpercent,
                    promo_discountvalue,
                    promo_isconditiondiscount,
                    promolg_conditiondiscounttext,
                    promo_typeapply,
                    promo_isunlimited,
                    promo_timepromotion,
                    promo_islimittimesoncustomer,
                    promo_url,
                    promo_ishot,
                    promo_isactived,
                    promo_image,
                    promo_isdeleted,
                    promo_startdate,
                    promo_enddate,
                    promo_dateadd,
                    promo_datemodify,
                    promo_displayorder,
                    promo_status
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
                    (int)$this->id,
                    (int)$this->usercreate,
                    (int)$this->useractive,
                    (int)$this->userdelete,
                    (string)$this->name,
                    (string)$this->shortdescription,
                    (string)$this->description,
                    (string)$this->descriptionclone,
                    (int)$this->isnew,
                    (int)$this->showtype,
                    (int)$this->isprintpromotion,
                    (string)$this->descriptionproductapply,
                    (string)$this->descriptionpromotioninfo,
                    (int)$this->ispromotionbyprice,
                    (float)$this->maxpromotionbyprice,
                    (float)$this->minpromotionbyprice,
                    (int)$this->ispromotionbytotalmoney,
                    (float)$this->maxpromotionbytotalmoney,
                    (float)$this->minpromotionbytotalmoney,
                    (int)$this->ispromotionbyquantity,
                    (float)$this->maxpromotionbyquantity,
                    (float)$this->minpromotionbyquantity,
                    (int)$this->ispromotionbyhour,
                    (int)$this->startpromotionbyhour,
                    (int)$this->endpromotionbyhour,
                    (int)$this->isloyalty,
                    (int)$this->isnotloyalty,
                    (int)$this->isimei,
                    (int)$this->iscombo,
                    (int)$this->isshowvat,
                    (int)$this->messagevat,
                    (int)$this->ispriorityinvoice,
                    (int)$this->isdiscountpercent,
                    (int)$this->discountvalue,
                    (int)$this->isconditiondiscount,
                    (string)$this->promolgconditiondiscounttext,
                    (int)$this->typeapply,
                    (int)$this->isunlimited,
                    (int)$this->timepromotion,
                    (int)$this->islimittimesoncustomer,
                    (string)$this->url,
                    (int)$this->ishot,
                    (int)$this->isactived,
                    (string)$this->image,
                    (int)$this->isdeleted,
                    (int)$this->startdate,
                    (int)$this->enddate,
                    (int)$this->dateadd,
                    (int)$this->datemodify,
                    (int)$this->displayorder,
                    (int)$this->status
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

        $sql = 'UPDATE ' . TABLE_PREFIX . 'promotion
                SET promo_usercreate = ?,
                    promo_useractive = ?,
                    promo_userdelete = ?,
                    promo_name = ?,
                    promo_shortdescription = ?,
                    promo_description = ?,
                    promo_descriptionclone = ?,
                    promo_isnew = ?,
                    promo_showtype = ?,
                    promo_isprintpromotion = ?,
                    promo_description_product_apply = ?,
                    promo_description_promotioninfo = ?,
                    promo_ispromotionbyprice = ?,
                    promo_maxpromotionbyprice = ?,
                    promo_minpromotionbyprice = ?,
                    promo_ispromotionbytotalmoney = ?,
                    promo_maxpromotionbytotalmoney = ?,
                    promo_minpromotionbytotalmoney = ?,
                    promo_ispromotionbyquantity = ?,
                    promo_maxpromotionbyquantity = ?,
                    promo_minpromotionbyquantity = ?,
                    promo_ispromotionbyhour = ?,
                    promo_startpromotionbyhour = ?,
                    promo_endpromotionbyhour = ?,
                    promo_isloyalty = ?,
                    promo_isnotloyalty = ?,
                    promo_isimei = ?,
                    promo_iscombo = ?,
                    promo_isshowvat = ?,
                    promo_messagevat = ?,
                    promo_ispriorityinvoice = ?,
                    promo_isdiscountpercent = ?,
                    promo_discountvalue = ?,
                    promo_isconditiondiscount = ?,
                    promolg_conditiondiscounttext = ?,
                    promo_typeapply = ?,
                    promo_isunlimited = ?,
                    promo_timepromotion = ?,
                    promo_islimittimesoncustomer = ?,
                    promo_url = ?,
                    promo_ishot = ?,
                    promo_isactived = ?,
                    promo_image = ?,
                    promo_isdeleted = ?,
                    promo_startdate = ?,
                    promo_enddate = ?,
                    promo_dateadd = ?,
                    promo_datemodify = ?,
                    promo_displayorder = ?,
                    promo_status = ?
                WHERE promo_id = ?';

        $stmt = $this->db->query($sql, array(
                    (int)$this->usercreate,
                    (int)$this->useractive,
                    (int)$this->userdelete,
                    (string)$this->name,
                    (string)$this->shortdescription,
                    (string)$this->description,
                    (string)$this->descriptionclone,
                    (int)$this->isnew,
                    (int)$this->showtype,
                    (int)$this->isprintpromotion,
                    (string)$this->descriptionproductapply,
                    (string)$this->descriptionpromotioninfo,
                    (int)$this->ispromotionbyprice,
                    (float)$this->maxpromotionbyprice,
                    (float)$this->minpromotionbyprice,
                    (int)$this->ispromotionbytotalmoney,
                    (float)$this->maxpromotionbytotalmoney,
                    (float)$this->minpromotionbytotalmoney,
                    (int)$this->ispromotionbyquantity,
                    (float)$this->maxpromotionbyquantity,
                    (float)$this->minpromotionbyquantity,
                    (int)$this->ispromotionbyhour,
                    (int)$this->startpromotionbyhour,
                    (int)$this->endpromotionbyhour,
                    (int)$this->isloyalty,
                    (int)$this->isnotloyalty,
                    (int)$this->isimei,
                    (int)$this->iscombo,
                    (int)$this->isshowvat,
                    (int)$this->messagevat,
                    (int)$this->ispriorityinvoice,
                    (int)$this->isdiscountpercent,
                    (int)$this->discountvalue,
                    (int)$this->isconditiondiscount,
                    (string)$this->promolgconditiondiscounttext,
                    (int)$this->typeapply,
                    (int)$this->isunlimited,
                    (int)$this->timepromotion,
                    (int)$this->timepromotion,
                    (string)$this->url,
                    (int)$this->ishot,
                    (int)$this->isactived,
                    (string)$this->image,
                    (int)$this->isdeleted,
                    (int)$this->startdate,
                    (int)$this->enddate,
                    (int)$this->dateadd,
                    (int)$this->datemodify,
                    (int)$this->displayorder,
                    (int)$this->status,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion p
                WHERE p.promo_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();
        if(!empty($row))
        {
            $this->id = $row['promo_id'];
            $this->usercreate = $row['promo_usercreate'];
            $this->useractive = $row['promo_useractive'];
            $this->userdelete = $row['promo_userdelete'];
            $this->name = $row['promo_name'];
            $this->shortdescription = $row['promo_shortdescription'];
            $this->description = $row['promo_description'];
            $this->descriptionclone = $row['promo_descriptionclone'];
            $this->isnew = $row['promo_isnew'];
            $this->showtype = $row['promo_showtype'];
            $this->isprintpromotion = $row['promo_isprintpromotion'];
            $this->descriptionproductapply = $row['promo_description_product_apply'];
            $this->descriptionpromotioninfo = $row['promo_description_promotioninfo'];
            $this->ispromotionbyprice = $row['promo_ispromotionbyprice'];
            $this->maxpromotionbyprice = $row['promo_maxpromotionbyprice'];
            $this->minpromotionbyprice = $row['promo_minpromotionbyprice'];
            $this->ispromotionbytotalmoney = $row['promo_ispromotionbytotalmoney'];
            $this->maxpromotionbytotalmoney = $row['promo_maxpromotionbytotalmoney'];
            $this->minpromotionbytotalmoney = $row['promo_minpromotionbytotalmoney'];
            $this->ispromotionbyquantity = $row['promo_ispromotionbyquantity'];
            $this->maxpromotionbyquantity = $row['promo_maxpromotionbyquantity'];
            $this->minpromotionbyquantity = $row['promo_minpromotionbyquantity'];
            $this->ispromotionbyhour = $row['promo_ispromotionbyhour'];
            $this->startpromotionbyhour = $row['promo_startpromotionbyhour'];
            $this->endpromotionbyhour = $row['promo_endpromotionbyhour'];
            $this->isloyalty = $row['promo_isloyalty'];
            $this->isnotloyalty = $row['promo_isnotloyalty'];
            $this->isimei = $row['promo_isimei'];
            $this->iscombo = $row['promo_iscombo'];
            $this->isshowvat = $row['promo_isshowvat'];
            $this->messagevat = $row['promo_messagevat'];
            $this->ispriorityinvoice = $row['promo_ispriorityinvoice'];
            $this->isdiscountpercent = $row['promo_isdiscountpercent'];
            $this->discountvalue = $row['promo_discountvalue'];
            $this->isconditiondiscount = $row['promo_isconditiondiscount'];
            $this->promolgconditiondiscounttext = $row['promolg_conditiondiscounttext'];
            $this->typeapply = $row['promo_typeapply'];
            $this->isunlimited = $row['promo_isunlimited'];
            $this->timepromotion = $row['promo_timepromotion'];
            $this->url = $row['promo_url'];
            $this->ishot = $row['promo_ishot'];
            $this->isactived = $row['promo_isactived'];
            $this->image = $row['promo_image'];
            $this->isdeleted = $row['promo_isdeleted'];
            $this->startdate = $row['promo_startdate'];
            $this->enddate = $row['promo_enddate'];
            $this->dateadd = $row['promo_dateadd'];
            $this->datemodify = $row['promo_datemodify'];
            $this->displayorder = $row['promo_displayorder'];
            $this->status = $row['promo_status'];
        }
    }

	public function getDataByArray($row)
    {
        $this->id = $row['promo_id'];
		$this->usercreate = $row['promo_usercreate'];
		$this->useractive = $row['promo_useractive'];
		$this->userdelete = $row['promo_userdelete'];
		$this->name = $row['promo_name'];
		$this->shortdescription = $row['promo_shortdescription'];
		$this->description = $row['promo_description'];
		$this->descriptionclone = $row['promo_descriptionclone'];
		$this->isnew = $row['promo_isnew'];
		$this->showtype = $row['promo_showtype'];
		$this->isprintpromotion = $row['promo_isprintpromotion'];
		$this->descriptionproductapply = $row['promo_description_product_apply'];
		$this->descriptionpromotioninfo = $row['promo_description_promotioninfo'];
		$this->ispromotionbyprice = $row['promo_ispromotionbyprice'];
		$this->maxpromotionbyprice = $row['promo_maxpromotionbyprice'];
		$this->minpromotionbyprice = $row['promo_minpromotionbyprice'];
		$this->ispromotionbytotalmoney = $row['promo_ispromotionbytotalmoney'];
		$this->maxpromotionbytotalmoney = $row['promo_maxpromotionbytotalmoney'];
		$this->minpromotionbytotalmoney = $row['promo_minpromotionbytotalmoney'];
		$this->ispromotionbyquantity = $row['promo_ispromotionbyquantity'];
		$this->maxpromotionbyquantity = $row['promo_maxpromotionbyquantity'];
		$this->minpromotionbyquantity = $row['promo_minpromotionbyquantity'];
		$this->ispromotionbyhour = $row['promo_ispromotionbyhour'];
		$this->startpromotionbyhour = $row['promo_startpromotionbyhour'];
		$this->endpromotionbyhour = $row['promo_endpromotionbyhour'];
		$this->isloyalty = $row['promo_isloyalty'];
		$this->isnotloyalty = $row['promo_isnotloyalty'];
		$this->isimei = $row['promo_isimei'];
		$this->iscombo = $row['promo_iscombo'];
		$this->isshowvat = $row['promo_isshowvat'];
		$this->messagevat = $row['promo_messagevat'];
		$this->ispriorityinvoice = $row['promo_ispriorityinvoice'];
		$this->isdiscountpercent = $row['promo_isdiscountpercent'];
		$this->discountvalue = $row['promo_discountvalue'];
		$this->isconditiondiscount = $row['promo_isconditiondiscount'];
		$this->promolgconditiondiscounttext = $row['promolg_conditiondiscounttext'];
		$this->typeapply = $row['promo_typeapply'];
		$this->isunlimited = $row['promo_isunlimited'];
		$this->timepromotion = $row['promo_timepromotion'];
		$this->url = $row['promo_url'];
		$this->ishot = $row['promo_ishot'];
		$this->isactived = $row['promo_isactived'];
		$this->image = $row['promo_image'];
		$this->isdeleted = $row['promo_isdeleted'];
		$this->startdate = $row['promo_startdate'];
		$this->enddate = $row['promo_enddate'];
		$this->dateadd = $row['promo_dateadd'];
		$this->datemodify = $row['promo_datemodify'];
		$this->displayorder = $row['promo_displayorder'];
        $this->status = $row['promo_status'];
    }

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'promotion
                WHERE promo_id = ?';
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

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'promotion p';

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

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion p';

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
            $myPromotion = new Core_Promotion();

            $myPromotion->id = $row['promo_id'];
            $myPromotion->usercreate = $row['promo_usercreate'];
            $myPromotion->useractive = $row['promo_useractive'];
            $myPromotion->userdelete = $row['promo_userdelete'];
            $myPromotion->name = $row['promo_name'];
            $myPromotion->shortdescription = $row['promo_shortdescription'];
            $myPromotion->description = $row['promo_description'];
            $myPromotion->descriptionclone = $row['promo_descriptionclone'];
            $myPromotion->isnew = $row['promo_isnew'];
            $myPromotion->showtype = $row['promo_showtype'];
            $myPromotion->isprintpromotion = $row['promo_isprintpromotion'];
            $myPromotion->descriptionproductapply = $row['promo_description_product_apply'];
            $myPromotion->descriptionpromotioninfo = $row['promo_description_promotioninfo'];
            $myPromotion->ispromotionbyprice = $row['promo_ispromotionbyprice'];
            $myPromotion->maxpromotionbyprice = $row['promo_maxpromotionbyprice'];
            $myPromotion->minpromotionbyprice = $row['promo_minpromotionbyprice'];
            $myPromotion->ispromotionbytotalmoney = $row['promo_ispromotionbytotalmoney'];
            $myPromotion->maxpromotionbytotalmoney = $row['promo_maxpromotionbytotalmoney'];
            $myPromotion->minpromotionbytotalmoney = $row['promo_minpromotionbytotalmoney'];
            $myPromotion->ispromotionbyquantity = $row['promo_ispromotionbyquantity'];
            $myPromotion->maxpromotionbyquantity = $row['promo_maxpromotionbyquantity'];
            $myPromotion->minpromotionbyquantity = $row['promo_minpromotionbyquantity'];
            $myPromotion->ispromotionbyhour = $row['promo_ispromotionbyhour'];
            $myPromotion->startpromotionbyhour = $row['promo_startpromotionbyhour'];
            $myPromotion->endpromotionbyhour = $row['promo_endpromotionbyhour'];
            $myPromotion->isloyalty = $row['promo_isloyalty'];
            $myPromotion->isnotloyalty = $row['promo_isnotloyalty'];
            $myPromotion->isimei = $row['promo_isimei'];
            $myPromotion->iscombo = $row['promo_iscombo'];
            $myPromotion->isshowvat = $row['promo_isshowvat'];
            $myPromotion->messagevat = $row['promo_messagevat'];
            $myPromotion->ispriorityinvoice = $row['promo_ispriorityinvoice'];
            $myPromotion->isdiscountpercent = $row['promo_isdiscountpercent'];
            $myPromotion->discountvalue = $row['promo_discountvalue'];
            $myPromotion->isconditiondiscount = $row['promo_isconditiondiscount'];
            $myPromotion->promolgconditiondiscounttext = $row['promolg_conditiondiscounttext'];
            $myPromotion->typeapply = $row['promo_typeapply'];
            $myPromotion->isunlimited = $row['promo_isunlimited'];
            $myPromotion->timepromotion = $row['promo_timepromotion'];
            $myPromotion->url = $row['promo_url'];
            $myPromotion->ishot = $row['promo_ishot'];
            $myPromotion->isactived = $row['promo_isactived'];
            $myPromotion->image = $row['promo_image'];
            $myPromotion->isdeleted = $row['promo_isdeleted'];
            $myPromotion->startdate = $row['promo_startdate'];
            $myPromotion->enddate = $row['promo_enddate'];
            $myPromotion->dateadd = $row['promo_dateadd'];
            $myPromotion->datemodify = $row['promo_datemodify'];
            $myPromotion->displayorder = $row['promo_displayorder'];
            $myPromotion->status = $row['promo_status'];


            $outputList[] = $myPromotion;
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
    public static function getPromotions($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_id = '.(int)$formData['fid'].' ';

        if(isset($formData['fisdeleted']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_isdeleted = '.(int)$formData['fisdeleted'].' ';


        if(is_array($formData['fidarr']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_id IN ('.implode(',',$formData['fidarr']).') ';

        if($formData['fname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_name = "'.Helper::unspecialtext((string)$formData['fname']).'" ';

        if($formData['fsname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_name LIKE "%'.Helper::unspecialtext((string)$formData['fsname']).'%" ';


        if($formData['fsdescription'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_description LIKE "%'.Helper::unspecialtext((string)$formData['fsdescription']).'%" ';

        if($formData['fenddate'] != '')
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_enddate >= '.(int)$formData['fenddate'].' ';
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_startdate <= '.(int)time().' ';
        }

        if($formData['fstatus'])
        {
             $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_status = ' . (int)$formData['fstatus'] . ' ';
        }

        if($formData['fisavailable'] > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_enddate >= '.(int)time().' ';
            $whereString .= ' AND p.promo_startdate <= '.(int)time().' ';
            $whereString .= ' AND p.promo_isactived = 1';
            $whereString .= ' AND p.promo_isdeleted = 0';
            $whereString .= ' AND p.promo_status = 0';
            $currenthours = date('H') * 60 + date('m');
            $whereString .= ' AND (p.promo_ispromotionbyhour = 0 OR (p.promo_startpromotionbyhour <= '.(int)$currenthours.' AND p.promo_endpromotionbyhour >= '.(int)$currenthours.'))';
        }

        if($formData['fisactived'] >0 )
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_isactived = '.(int)$formData['fisactived'].' ';

        if(strlen($formData['fkeywordFilter']) > 0)
        {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if($formData['fsearchKeywordIn'] == 'name')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.promo_name LIKE \'%'.$formData['fkeywordFilter'].'%\'';
            else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (p.promo_description LIKE \'%'.$formData['fkeywordFilter'].'%\') )';
        }

        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'id')
            $orderString = 'promo_id ' . $sorttype;
        elseif($sortby == 'name')
            $orderString = 'promo_name ' . $sorttype;
        else
            $orderString = 'promo_id ' . $sorttype;

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

    /*
    public static function getProductPromotionGroupFrontEnd($formData, $limit = '')//chua xai
    {
        $whereString = 'p. promo_enddate > '.time(). ' AND p.promo_isdeleted > 0';
        $orderString = 'p.promo_displayorder ASC';

        $listpromotions = self::getList($whereString, $orderString, $limit);
        $arr_promotion = array();
        $promotiongroup = array();
        $arr_promotiongroup = array();
        if(!empty($listpromotions))
        {

            foreach($listpromotions as $promotion)
            {
                $arr_promotion[] = $promotion->id;
            }
            if(!empty($arr_promotion))
            {
                $listpromotiongroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arr_promotion, 'fisdeleted' => 0),'','');
                if(!empty($listpromotiongroup))
                {
                    foreach($listpromotiongroup as $promogroup)
                    {
                        $arr_promotionlistgroup[] = $promogroup->id;
                        $promotiongroup[$promogroup->id] = $promogroup;
                    }
                }
                if(!empty($arr_promotionlistgroup))
                {
                    $listpromolistgroup = Core_Promotionlist::getPromotionlists(array('fpromogid' => $arr_promotionlistgroup),'','');
                    if(!empty($listpromolistgroup))
                    {
                        //$finalPromotion = array();
                        $arr_productbarcode = array();
                        foreach($listpromolistgroup as $promolist)
                        {
                            $arr_productbarcode[] = $promolist->pbarcode;
                        }
                        if(!empty($arr_productbarcode))
                        {
                            $listproducts = Core_Product::getProducts(array('fpbarcodearr' => $arr_productbarcode),'','');
                            $newlistproduct = array();
                            if(!empty($listproducts))
                            {
                                foreach($listproducts as $prod)
                                {
                                    $newlistproduct[$prod->barcode] = $prod;
                                }
                                $listfinalproduct = array();
                                foreach($listpromolistgroup as $promolist)
                                {
                                    if(!empty($promotiongroup[$promolist->promogid]) && !empty($newlistproduct[$promolist->pbarcode]))
                                    {
                                        $promolist = $promotionlistgroup[$promolist->promogid];
                                        $promolist->list = $promolist;
                                        $listfinalproduct[$promolist->pbarcode][$promolist->id]->promotion = $promolist;
                                    }
                                }
                                if(!empty($listfinalproduct)) {
                                    return $listfinalproduct;
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }
    */
    public static function getPromotionByProductIDFrontEnd($barcode, $regionid = '', $finalprice = 0)
    {
        if(!empty($barcode))
        {
            $barcode = trim($barcode);
            $formData = array();
            $product = Core_Product::getIdByBarcode($barcode);//Core_Product::getProducts(array('fbarcode' => $barcode), '', '', 1);
            if(!empty($product->id) && $product->sellprice > 0 && $product->onsitestatus > 0)
            {
                //$product = $product[0];
                //lấy khu vực của region
                $arr_areaid = array();
                $arr_ppaid = array();
                $arr_storeid = array();
                /*$getRelRegionPriceArea = Core_RelRegionPricearea::getRelRegionPriceareas(array('frid' => $regionid),'','');
                if(!empty($getRelRegionPriceArea))
                {
                    foreach($getRelRegionPriceArea as $item)
                    {
                        if(!in_array($item->aid, $arr_areaid))
                        {
                            $arr_areaid[] = $item->aid;
                        }
                        if(!in_array($item->ppaid, $arr_ppaid))
                        {
                            $arr_ppaid[] = $item->ppaid;
                        }
                    }
                }
                $getListStore = null;
                if(!empty($arr_ppaid) && !empty($arr_areaid)){
                    $getListStore = Core_Store::getStores(array('fppaidarr' => $arr_ppaid, 'faidarr' => $arr_areaid),'','');
                    if(!empty($getListStore))
                    {
                        foreach($getListStore as $st)
                        {
                            $arr_storeid[] = $st->id;
                        }
                    }
                }*/
                $getListStore = Core_Store::getStores(array('fregion' => $regionid),'','');
                    if(!empty($getListStore))
                    {
                        foreach($getListStore as $st)
                        {
                            $arr_storeid[] = $st->id;
                            if(!in_array($st->aid, $arr_areaid))
	                        {
	                            $arr_areaid[] = $st->aid;
	                        }
	                        if(!in_array($st->ppaid, $arr_ppaid))
	                        {
	                            $arr_ppaid[] = $st->ppaid;
	                        }
                        }
                    }

                //lấy tất cả các promotion của sản phẩm
                $allPromotionsByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($barcode), 'faidarr' => $arr_areaid),'','');

                //Lấy tất cả các product của combo mà có product hiện tại
                //$allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fpbarcode' => $barcode),'','');
                $allProductsByCombo = Core_RelProductCombo::getRelProductCombos(array('fpbarcode' => trim($barcode)),'','');//lấy tạm thời rồi sửa sau

                $allPromotionsByCombo = null;
                if(!empty($allProductsByCombo))
                {
                    $arr_cobo = array();
                    foreach($allProductsByCombo as $prodcom)
                    {
                        if(!in_array($prodcom->coid, $arr_cobo))
                        {
                            $arr_cobo[] = $prodcom->coid;
                        }
                    }
                    if(!empty($arr_cobo))
                    {
                        //Kiểm tra combo có active hoặc bị delete hay không
                        $checkValidationCombo = Core_Combo::getCombos(array('fidarr' => $arr_cobo, 'fisdeleted' => 0, 'fisactive' =>1),'','');
                        $arr_cobo = array();
                        if(!empty($checkValidationCombo))
                        {
                            foreach($checkValidationCombo as $ncobo)
                            {
                                $arr_cobo[] = $ncobo->id;
                            }
                        }
                        if(!empty($arr_cobo))
                        {
                            $allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fcoidarr' => $arr_cobo),'','');
                        }
                    }
                }
                $listNewPromotionByCombo = array();
                //lấy promotion của product theo area
                $arr_promotion = array();
                if(!empty($allPromotionsByProduct))
                {
                    foreach($allPromotionsByProduct as $pp)
                    {
                        if(!in_array($pp->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pp->promoid;
                        }
                    }
                }
                if(!empty($allPromotionsByCombo))
                {
                    foreach($allPromotionsByCombo as $pc)
                    {
                        if(!in_array($pc->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pc->promoid;
                        }
                        $listNewPromotionByCombo[$pc->promoid][] = $pc;
                    }
                }
                //echodebug($arr_promotion);
                //echodebug($arr_storeid);
                //Lấy ra được list promotion rồi,  bắt đầu móc ra tất cả các chương trình promotion
                $listpromotionstore = null;
                if(count($arr_storeid) > 0 && count($arr_promotion))
                {
                    $listpromotionstore = Core_PromotionStore::getPromotionStores(array('fsidarr' => $arr_storeid, 'fpromoidarr' => $arr_promotion), '', '');
                }
                //echodebug($listpromotionstore, true);
                $arr_newpromotionid = array();
                if(!empty($listpromotionstore))
                {
                    foreach($listpromotionstore as $ps)
                    {

                        if(in_array($ps->promoid, $arr_newpromotionid)==false)
                        {
                            $arr_newpromotionid[] = $ps->promoid;
                        }
                    }
                }        //die();
                if(!empty($arr_newpromotionid))
                {
                    $newlistpromotions = array();
                    $promotionlist = self::getPromotions(array('fidarr' => $arr_newpromotionid, 'fisavailable' => 1, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','');
                    if(!empty($promotionlist))
                    {
                        //móc những khuyến mãi của sản phẩm
                        $promoGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arr_newpromotionid, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');

                        $newpromoGroup = array();//'fisdiscountvaluegreater' => 0
                        $promotionGroupDiscount = array();
                        $promotionGroupNoDiscount = array();
                        if(!empty($promoGroup))
                        {
                            foreach($promoGroup as $promdis)
                            {
                                /*if((int)$promdis->discountvalue > 0)
                                {
                                    //$promotionGroupDiscount[$promdis->promoid] = $promdis;
                                    $newpromoGroup[$promdis->promoid] = $promdis;
                                }
                                else {
                                    //$promotionGroupNoDiscount[$promdis->promoid] = $promdis;
                                    $newpromoGroup[$promdis->promoid] = $promdis;
                                }*/
                                $newpromoGroup[$promdis->promoid] = $promdis;
                            }
                            /*if(!empty($promotionGroupDiscount))
                            {
                                $newpromoGroup = $promotionGroupDiscount;
                            }
                            elseif(!empty($promotionGroupNoDiscount))
                            {
                                $newpromoGroup = $promotionGroupNoDiscount;
                            }  */
                        }
                        //echodebug($newpromoGroup);
                        foreach($promotionlist as $promo)
                        {
                            //khuyến mãi theo sản phẩm
                            if(!empty($newpromoGroup[$promo->id]))
                            {
                                foreach($newpromoGroup[$promo->id] as $pg)
                                {
                                    $promorow = array();
                                    $promorow['promoid'] = $promo->id;
                                    //$promorow['promoname'] = !empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name);//;
                                    $promorow['promoname'] = !empty($promo->descriptionclone)?$promo->descriptionclone:(!empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name));//;

                                    $promorow['startdate'] = $promo->startdate;
                                    $promorow['enddate'] = $promo->enddate;
                                    $promorow['isproduct'] = 1;//isproduct là biến để nhận biết trường hợp khuyến mãi của sản phẩm, 0: là khuyến mãi dạng combo
                                    $promorow['promotiongroup'] = $pg;//->name
                                    $promorow['pricepromotion'] = 0;
                                    $promorow['promotionstatus'] = $promo->status;
                                    $promorow['promotiongrouptype'] = $pg->type;// 0: chỉ được chọn giảm giá hoặc tặng quà, 1: được chọn cả 2; 2: Bắt buộc chọn cả 2
                                    if($finalprice > 0)
                                    {
                                        if((int)$pg->isdiscount > 0)
                                        {
                                            if((int)$pg->isdiscountpercent > 0)
                                            {
                                                $promorow['pricepromotion'] = round($finalprice - ($finalprice*$pg->discountvalue/100),0);
                                            }
                                            else {
                                                $promorow['pricepromotion'] = $finalprice - $pg->discountvalue;
                                            }
                                        }
                                    }

                                    //$promorow['typediscount'] = $pg->type;
                                    /*if(!empty($pg->isdiscount))
                                    {
                                        //kiểm tra khuyến mãi hay tặng quà hay cả 2
                                        if($pg->type == 0) //Chỉ được chọn giảm giá hoặc tặng quà (nhưng lấy giảm giá ra để show giá trên web)
                                        {

                                        }

                                        if($pg->isfixed == 1) //trường hợp nhận hết toàn bộ sản phẩm trong list
                                        {

                                        }
                                    }*/
                                    $newlistpromotions[] = $promorow;
                                    break;
                                }
                            }
                            elseif(!empty($listNewPromotionByCombo[$promo->id]))
                            {
                                //Khuyến mãi theo combo
                                foreach($listNewPromotionByCombo[$promo->id] as $promocombo)
                                {
                                    $promorow = array();
                                    $promorow['promoid'] = $promo->id;
                                    $promorow['promoname'] = $promo->name;
                                    $promorow['isproduct'] = 0;//khuyến mãi là combo
                                    $promorow['combo'] = $promocombo;
                                    $newlistpromotions[] = $promorow;
                                    break;
                                }
                            }
                            else{
                            	$promorow = array();
                                $promorow['promoid'] = $promo->id;
                                //$promorow['promoname'] = !empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name);//;
                                $promorow['promoname'] = !empty($promo->descriptionclone)?$promo->descriptionclone:(!empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name));//;
                                $promorow['startdate'] = $promo->startdate;
                                $promorow['enddate'] = $promo->enddate;
                                $promorow['isproduct'] = 1;//isproduct là biến để nhận biết trường hợp khuyến mãi của sản phẩm, 0: là khuyến mãi dạng combo
                                $promorow['pricepromotion'] = 0;
                                $promorow['promotionstatus'] = $promo->status;
								$newlistpromotions[] = $promorow;
                            }
                        }

                        //$formData['listDiscountPromotion'] = $newlistDiscountPromotion;
                        $formData['listPromotions'] = $newlistpromotions;
                    }
                }
                //echodebug($arr_newpromotionid);
                /*$listarea = Core_Store::getStores(array('fregion' => $regionid),'','');
                if(!empty($listarea))
                {
                    foreach($listarea as $item)
                    {
                        if(!in_array($item->aid, $arr_areaid))
                        {
                            $arr_areaid[] = $item->aid;
                        }
                        if(!in_array($item->ppaid, $arr_ppaid))
                        {
                            $arr_ppaid[] = $item->ppaid;
                        }
                        if(!in_array($item->id, $arr_storeid))
                        {
                            $arr_storeid[] = $item->id;
                        }
                    }
                }//echo implode(',',$arr_storeid);

                //Lấy tất cả các chương trình khuyến mãi của siêu thị theo vùng
                /*if(!empty($arr_storeid))
                {
                    $getPromotionStore = Core_PromotionStore::getPromotionStores(array('fsidarr' => $arr_storeid), '', '');
                    if(!empty($getPromotionStore))
                    {echodebug($getPromotionStore, true);
                        $arr_Promotions = array();
                        foreach($getPromotionStore as $promostore)
                        {
                            if(!in_array($promostore->promoid, $arr_Promotions)) {
                                $arr_Promotions[] = $promostore->promoid;
                            }
                        }echodebug($arr_Promotions, true);
                        if(!empty($arr_Promotions))
                        {
                            $formData['listPromotions'] = self::getPromotions(array('fidarr' => $arr_Promotions, 'fenddate' => time(), 'fisactived' => 1),'','');var_dump($formData['listPromotions']);

                        }

                    }
                }*/
                /*
                //Lấy thông tin sản phẩm áp dụng khuyến mãi
                $allPromotionsByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => $barcode, 'faidarr' => $arr_areaid),'','');//echodebug($allPromotionsByProduct);echo $barcode;
                if($allPromotionsByProduct)
                {
                    $arr_Promotions = array();
                    foreach($allPromotionsByProduct as $promoprod)
                    {
                        if(!in_array($promoprod->promoid, $arr_Promotions)) {
                            $arr_Promotions[] = $promoprod->promoid;
                        }
                    }
                    if(!empty($arr_Promotions))
                    {
                        $formData['listPromotions'] = Core_Promotion::getPromotions(array('fidarr' => $arr_Promotions, 'fenddate' => time(), 'fisactived' => 1),'','');


                        //danh sách tất cả các siêu thị áp dụng
                        $formData['promotionStore'] = Core_PromotionStore::getPromotionStores(array('fpromoidarr' => $arr_Promotions, 'fsidarr' => $arr_storeid), '', '');

                        //lấy tất cả các chương trình khuyến mãi của sản phẩm hiện tại
                        $listPromotions = self::getPromotions(array('fidarr' => $arr_Promotions),'','');
                        if(!empty($listPromotions))
                        {
                            //lấy nhóm khuyến mãi
                            $promoGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arr_Promotions),'','');
                            if(!empty($promoGroup))
                            {
                                $arr_Group = array();
                                $newGroup = array();
                                foreach($promoGroup as $pg)
                                {
                                    $arr_Group[] = $pg->id;
                                    $newGroup[$pg->promoid][] = $pg;
                                }
                                if(!empty($arr_Group))
                                {
                                    //lấy danh sách nhóm khuyến mãi
                                    $promoListGroup = Core_Promotionlist::getPromotionlists(array('fpromogidarr' => $arr_Group),'','');

                                    if(!empty($promoListGroup))
                                    {
                                        $arr_Barcode = array();
                                        $newListGroup = array();
                                        foreach($promoListGroup as $listgroup)
                                        {
                                            if(!in_array($listgroup->pbarcode, $arr_Barcode)) {
                                                $arr_Barcode[] = $listgroup->pbarcode;
                                            }
                                            $newListGroup[$listgroup->promogid][$listgroup->pbarcode] = $listgroup;//$listgroup->pbarcode
                                        }
                                        $formData['promotionListGroup'] = $newListGroup;
                                    }
                                    $formData['promotionListGroup'] = $newListGroup;
                                    $formData['promotionGroup'] = $newGroup;
                                }


                            }
                        }

                        $listCombo = Core_PromotionCombo::getPromotionCombos(array('fpromoidarr' => $arr_Promotions),'','');
                        if(!empty($listCombo))
                        {
                            $newPromoCombo = array();
                            $arr_cobo = array();
                            $arr_barcode = array();
                            foreach($listCombo as $cobo)
                            {
                                $newPromoCombo[$cobo->promoid][] = $cobo;
                                if( !in_array($cobo->pbarcode, $arr_barcode))
                                {
                                    $arr_barcode[] = $cobo->pbarcode;
                                }
                            }
                            if(!empty($arr_barcode))
                            {
                                $listprod = Core_Product::getProducts(array('fpbarcodearr' => $arr_barcode),'','');

                                if(!empty($listprod))
                                {
                                    $newprod = array();
                                    foreach($listprod as $prod)
                                    {
                                        $newprod[$prod->barcode] = $prod;
                                    }
                                    $formData['listProduct'] = $newprod;
                                }
                            }
                        }


                    }

                }    */
            }
            return $formData;
        }
        return false;
    }

    //hàm này chỉ lấy 1 promotion mặc định là promotion giảm giá của 1 sản phẩm. Nếu promotion giảm giá không có thì lấy promotion tặng quà để biết sản phẩm này có khuyến mãi. Và nó là promotion dạng product chứ không phải promotion dạng combo
    public static function getProductPromotionListFrontEnd($arrPromotionsid = array(), $regionid = 3, $limit = 20)
    {
        if(empty($arrPromotionsid))
        {
            $getPromotion = self::getPromotions(array('fisavailable' => 1),'','',$limit);
            if(!empty($getPromotion))
            {
                foreach($getPromotion as $listpromo)
                {
                    $arrPromotionsid[] = $listpromo->id;
                }
            }
        }

        if(!empty($arrPromotionsid))
        {
            $arr_storeid = array();
            $arr_aid = array();
            $arr_ppaid = array();
            $getListStore = Core_Store::getStores(array('fregion' => $regionid),'','');
                    if(!empty($getListStore))
                    {
                        foreach($getListStore as $st)
                        {
                            $arr_storeid[] = $st->id;
                            if(!in_array($st->aid, $arr_aid))
	                        {
	                            $arr_aid[] = $st->aid;
	                        }
	                        if(!in_array($st->ppaid, $arr_ppaid))
	                        {
	                            $arr_ppaid[] = $st->ppaid;
	                        }
                        }
                    }
            $formDataProductPromo = array('fpromoidarr' => $arrPromotionsid);

            if(!empty($arr_aid))
            {
                $formDataProductPromo['faidarr'] = $arr_aid;
            }
            $getPromotionProduct = Core_PromotionProduct::getPromotionProducts($formDataProductPromo,'','');

            $arr_barcode = array();

            $listpromotionbarcode = array();
            $newarrpromotion = array();
            if(!empty($getPromotionProduct))
            {
                foreach($getPromotionProduct as $promo)
                {
                    $promo->pbarcode = trim($promo->pbarcode);
                    if(!empty($promo->pbarcode) && !in_array($promo->pbarcode, $arr_barcode))
                    {
                        $arr_barcode[] = $promo->pbarcode;
                    }
                    $listpromotionbarcode[$promo->pbarcode][$promo->promoid] = $promo;//[$promo->promoid]
                    if(!in_array($promo->promoid,$newarrpromotion))
                    {
                        $newarrpromotion[] = $promo->promoid;
                    }
                }
            }
            if(!empty($newarrpromotion))
            {
                //Lấy tất cả các DS nhóm hàng  khuyến mãi của promotion
                $getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $newarrpromotion, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');
                $newPromotionGroup = null;
                $newPromotionGroupHasDiscount = null;
                if(!empty($getPromotionGroup))
                {
                    foreach($getPromotionGroup as $promogroup)
                    {
                        if($promogroup->discountvalue > 0)
                        {
                            $newPromotionGroupHasDiscount[$promogroup->promoid] = $promogroup;//lấy những promotion nào giảm giá
                        }
                        else $newPromotionGroup[$promogroup->promoid] = $promogroup;//tất cả các group của 1 promotion

                    }
                }
                $listfinalPromotionGroup = null;
                if(!empty($newPromotionGroup) && !empty($newPromotionGroupHasDiscount))
                {
                    $listfinalPromotionGroup = array_merge($newPromotionGroup, $newPromotionGroupHasDiscount);
                }

                //LẤY 1 PROMOTION DUY NHẤT CHO 1 SẢN PHẨM SAO ĐÓ ADD VÔ SẢN PHẨM
                if(!empty($listfinalPromotionGroup))
                {
                    if(!empty($arr_barcode))
                    {
                        $getProduct = Core_Product::getProducts(array('fpbarcodearr' => $arr_barcode), '', '');
                        $newProductList = array();
                        if(!empty($getProduct))
                        {
                            foreach($getProduct as $prod)
                            {
                                if(!empty($listpromotionbarcode[$prod->barcode]))
                                {
                                    $promoproduct = array();

                                    foreach($listpromotionbarcode[$prod->barcode] as $promoid=>$value)
                                    {
                                        if(!empty($listfinalPromotionGroup[$promoid]))
                                        {
                                            $promoproduct['name'] = $listfinalPromotionGroup[$promoid]->name;
                                            $promoproduct['isdiscount'] = $listfinalPromotionGroup[$promoid]->isdiscount;
                                            $promoproduct['discountvalue'] = $listfinalPromotionGroup[$promoid]->discountvalue;
                                            $promoproduct['isdiscountpercent'] = $listfinalPromotionGroup[$promoid]->isdiscountpercent;
                                            break;//mỗi sản phẩm lấy 1 khuyến mãi không lấy khuyến mãi là combo
                                        }
                                    }


                                    $newsummary = '';
                                    $explodenewsummary = explode("\n",$prod->summary);//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
                                    if(!empty($explodenewsummary)){
                                        $cnt = 0;
                                        foreach($explodenewsummary as $suma){
                                            $suma = strip_tags(htmlspecialchars_decode($suma));
                                            $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
                                            if(!empty($suma))
                                            {
                                                if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
                                                if(!empty($suma) && $suma !='-'){
                                                    if($cnt++==3) break;
                                                    $newsummary .= '<span>'.$suma.'</span>';
                                                }
                                            }
                                        }
                                    }
                                    $getFinalPrice = Core_RelRegionPricearea::getPriceByProductRegion($prod->barcode,$regionid);
                                    $sellprice = (!empty($getFinalPrice)?$getFinalPrice:(!empty($prod->sellprice)?($prod->sellprice):0));
                                    if(!empty($promoproduct))
                                    {
                                        if((int)$promoproduct['isdiscount'] > 0)
                                        {
                                            if((int)$promoproduct['isdiscountpercent'] > 0)
                                            {
                                                $promoproduct['pricepromotion'] = round($sellprice - ($sellprice*$promoproduct['discountvalue']/100),0);
                                            }
                                            else
                                            {
                                                $promoproduct['pricepromotion'] = $sellprice - $promoproduct['discountvalue'] ;
                                            }
                                        }
                                        else{
                                            $promoproduct['pricepromotion'] = 0;
                                        }
                                    }
                                    $proitem = $prod;
                                    //Tính giá của sản phẩm
                                    $proitem->sellprice = $sellprice;

                                    $proitem->summary = $newsummary;

                                    $proitem->promotion = $promoproduct;
                                    $newProductList[] = $proitem;
                                }
                            }
                            return $newProductList;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function getFirstDiscountPromotion($barcode, $regionid = '')
    {
        $barcode = trim($barcode);
        if(empty($barcode)) return false;

        $myProduct = Core_Product::getIdByBarcode($barcode);
        if($myProduct->id > 0 && $myProduct->sellprice > 0 && $myProduct->onsitestatus > 0)
        {
            $arr_Area = array();
            if(!empty($regionid))
            {
            	$getListStore = Core_Store::getStores(array('fregion' => $regionid),'','');
                    if(!empty($getListStore))
                    {
                        foreach($getListStore as $st)
                        {
                            if(!in_array($st->aid, $arr_Area))
	                        {
	                            $arr_Area[] = $st->aid;
	                        }
                        }
                    }
            }
            $formDataProductPromo['fpbarcode'] = trim($barcode);
            $formDataProductPromo['faidarr'] = $arr_aid;
            $getPromotionProduct = Core_PromotionProduct::getPromotionProducts($formDataProductPromo,'','');
            $arrPromotionsid = array();

            if(!empty($getPromotionProduct))
            {
                foreach($getPromotionProduct as $promo)
                {
                    if(!in_array($promo->promoid, $arrPromotionsid))
                    {
                        $arrPromotionsid[] = $promo->promoid;
                    }
                }
            }
            if(empty($arrPromotionsid)) return false;

            $checkPromotionAvailable = self::getPromotions(array('fisavailable' => 1, 'fidarr' => $arrPromotionsid, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','');

            if(!empty($checkPromotionAvailable))
            {
                $arrPromotionsid = array();
                foreach($checkPromotionAvailable as $promo)
                {
                    if(!in_array($promo->id, $arrPromotionsid))
                    {
                        $arrPromotionsid[] = $promo->id;
                    }
                }
            }
            else return false;

            if(empty($arrPromotionsid)) return false;
            //Lấy tất cả các DS nhóm hàng  khuyến mãi của promotion
            $getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arrPromotionsid, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');//  , 'fisdiscountvalue'=>1
            //echodebug($getPromotionGroup);
            if(!empty($getPromotionGroup))
            {
                $pricediscount = array();
                foreach($getPromotionGroup as $gp)
                {
                    if((int)$gp->discountvalue > 0)
                    {
                        $pricediscount['promoid'] = $gp->promoid;
                        if((int)$gp->isdiscountpercent > 0)
                        {
                            $pricediscount['percent'] = 1; //giảm giá theo tỉ lệ %
                            $pricediscount['discountvalue'] = $gp->discountvalue;
                        }
                        else{
                            $pricediscount['percent'] = -1; //giảm giá theo tỉ lệ %
                            $pricediscount['discountvalue'] = $gp->discountvalue;
                        }break;
                    }
                }
                return $pricediscount;
            }
        }

        return false;
    }

    public static function getFirstDiscountPromotionById($promoid, $regionid = '')
    {
        if(empty($promoid)) return false;

        $checkPromotionAvailable = self::getPromotions(array('fisavailable' => 1, 'fid' => $promoid, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','', true);
        if ( $checkPromotionAvailable == 0) return false;

        $getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoid' => $promoid, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');//  , 'fisdiscountvalue'=>1
        if(!empty($getPromotionGroup))
        {
            $pricediscount = array();
            foreach($getPromotionGroup as $gp)
            {
                if((int)$gp->discountvalue > 0)
                {
                    $pricediscount['promogpid'] = $gp->id;
                    $pricediscount['promoid'] = $gp->promoid;
                    if((int)$gp->isdiscountpercent > 0)
                    {
                        $pricediscount['percent'] = 1; //giảm giá theo tỉ lệ %
                        $pricediscount['discountvalue'] = $gp->discountvalue;
                    }
                    else{
                        $pricediscount['percent'] = -1; //giảm giá theo tỉ lệ %
                        $pricediscount['discountvalue'] = $gp->discountvalue;
                    }break;
                }
            }
            return $pricediscount;
        }
    }

	public static function getFirstDiscountPromotionByListId($promotionlistid, $regionid = '')
    {
        if(empty($promotionlistid)) return false;

        $checkPromotionAvailable = self::getPromotions(array('fisavailable' => 1, 'fidarr' => $promotionlistid, 'fstatus' => Core_Promotion::STATUS_ENABLE),'','','', true);
        if ( $checkPromotionAvailable == 0) return false;

        $getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $promotionlistid, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC', '0,1');//  , 'fisdiscountvalue'=>1
        if(!empty($getPromotionGroup))
        {
            $pricediscount = array();
            foreach($getPromotionGroup as $gp)
            {
                if((int)$gp->discountvalue > 0)
                {
                    $pricediscount['promogpid'] = $gp->id;
                    $pricediscount['promoid'] = $gp->promoid;
                    if((int)$gp->isdiscountpercent > 0)
                    {
                        $pricediscount['percent'] = 1; //giảm giá theo tỉ lệ %
                        $pricediscount['discountvalue'] = $gp->discountvalue;
                    }
                    else{
                        $pricediscount['percent'] = -1; //giảm giá theo tỉ lệ %
                        $pricediscount['discountvalue'] = $gp->discountvalue;
                    }break;
                }
            }
            return $pricediscount;
        }
    }


    public static function getOnePromotionbyID($promoid = '', $regionid ='', $pbarcode = '')
    {
        if($promoid =='' || !is_numeric($promoid)) return false;
        if($regionid =='' || !is_numeric($regionid)) return false;
        if($pbarcode =='') return false;

        //check promotion available
        $myPromotion = new Core_Promotion($promoid, true);
        $currenthours = date('H') * 60 + date('m');
        if($myPromotion->status==Core_Promotion::STATUS_DISABLED || $myPromotion->enddate < time() || $myPromotion->isactived != 1 ||
        	($myPromotion->ispromotionbyhour == 1 &&
        		($myPromotion->startpromotionbyhour > $currenthours || $myPromotion->endpromotionbyhour < $currenthours)
        	)
        ) return false;

        $arr_aid = array();
        $arr_ppaid = array();
        $arr_storeid = array();
        $getListStore = Core_Store::getStores(array('fregion' => $regionid),'','');
        if(!empty($getListStore))
        {
            foreach($getListStore as $st)
            {
                $arr_storeid[] = $st->id;
                if(!in_array($st->aid, $arr_aid))
	            {
	                $arr_aid[] = $st->aid;
	            }
	            if(!in_array($st->ppaid, $arr_ppaid))
			    {
			        $arr_ppaid[] = $st->ppaid;
			    }
            }
        }

        if(!empty($arr_storeid))
        {
            $getPromotionStores = Core_PromotionStore::getPromotionStores(array('fpromoid' => $promoid, 'fsidarr' => $arr_storeid),'','',1);
            //Kiểm tra promotion có tồn tại trong region id của region hiện tại không để show lên
            if(!empty($getPromotionStores))
            {
                $onepromo = new Core_Promotion($promoid);
                $currenthours = date('H') * 60 + date('m');
                $formData = array();
                if(!empty($onepromo->id) && $onepromo->enddate >= time() && $onepromo->startdate <= time() && $onepromo->isactived == 1 &&
                    ($onepromo->ispromotionbyhour == 0 || ($onepromo->ispromotionbyhour == 1 && $onepromo->startpromotionbyhour <= $currenthours && $onepromo->endpromotionbyhour >= $currenthours))
                )
                {
                    //kiểm tra promotion có áp dụng cho sản phẩm hiện tại không
                    $getPromotionProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($pbarcode), 'fpromoid' => $promoid, 'faidarr' => $arr_aid),'','',0);
                    $listcombo = Core_PromotionCombo::getPromotionCombos(array('fpromoid' => $onepromo->id),'','');
                    if(empty($getPromotionProduct) && empty($listcombo))
                    {
                        //trường hợp không có sản phẩm áp dụng cũng không có combo nào áp dụng
                        return false;
                    }

                    $formData['promotion'] = $onepromo;
                    $formData['promotiongroup'] = Core_Promotiongroup::getPromotiongroups(array('fpromoid' => $onepromo->id, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');

                    if(!empty($listcombo))
                    {
                        $arr_combo = array();
                        foreach($listcombo as $cobo)
                        {
                            if(!in_array($cobo->coid,$arr_combo))
                            {
                                $arr_combo[] = $cobo->coid;
                            }
                        }
                        if(!empty($arr_combo))
                        {
                            $listproduct = Core_RelProductCombo::getRelProductCombos(array('fcoidarr' => $arr_combo, 'fpbarcode'=> trim($pbarcode)),'','');
                            if(empty($getPromotionProduct) && empty($listproduct))
                            {
                                //trường hợp không có sản phẩm áp dụng cũng không có combo nào có sản phẩm hiện tại
                                return false;
                            }
                            $newlistproduct = array();
                            $arr_product = array();
                            if(!empty($listproduct))
                            {
                                foreach($listproduct as $procombo)
                                {
                                    $procombo->pbarcode = trim($procombo->pbarcode);
                                    if(!in_array($procombo->pbarcode, $arr_product))
                                    {
                                        $arr_product[] = $procombo->pbarcode;
                                    }
                                    //$newlistproduct[$procombo->coid][$procombo->pbarcode] = 1;
                                }
                            }
                            if(!empty($arr_product))
                            {
                                $listproducts = Core_Product::getProducts(array('fpbarcodearr' => $arr_product),'','');
                                $arr_product = array();
                                if(!empty($listproducts))
                                {
                                    foreach($listproducts as $pro)
                                    {
                                        if($pro->sellprice > 0 && $pro->onsitestatus > 0 && $pro->status == Core_Product::STATUS_ENABLE)
                                        {
                                            $arr_product[$pro->barcode] = $pro;
                                        }
                                    }
                                }
                                if(!empty($listproduct) && !empty($arr_product))
                                {
                                    foreach($listproduct as $procombo)
                                    {
                                        $procombo->pbarcode = trim($procombo->pbarcode);
                                        if(!empty($arr_product[$procombo->pbarcode]))
                                        {
                                            $newlistproduct[$procombo->coid][$procombo->pbarcode] = $arr_product[$procombo->pbarcode];
                                        }
                                    }
                                }

                            }
                            $formData['listProductCombo'] = $newlistproduct;
                        }
                    }
                    $formData['promotioncombo'] = $listcombo;
                }
                return $formData;
            }
        }
    }

    public static function getProductHavePromotion($regionid, $limit = 20, $countOnly = false)
    {
        global $db;
        $getPromotionGroup = $db->query('SELECT * FROM ' . TABLE_PREFIX . 'promotiongroup GROUP BY promo_id ORDER BY promo_id DESC LIMIT '.$limit);
        if($getPromotionGroup)
        {
            $listpromoid = array();
            $listPromotionGroup = array();
            while($row = $getPromotionGroup->fetch())
            {
                $listPromotionGroup[$row['promo_id']] = $row;
                $listpromoid[] = $row['promo_id'];
            }
            if(!empty($listpromoid))
            {
                //check promotion expired
                $getPromotion = self::getPromotions(array('fidarr' => $listpromoid,'fisavailable' => 1),'','');
                $newlistpromoid = array();
                if(!empty($getPromotion))
                {
                    if(count($getPromotion)==$listpromoid)
                    {
                        $newlistpromoid = $listpromoid;
                    }
                    else
                    {
                        foreach($getPromotion as $promo)
                        {
                            $newlistpromoid[] = $promo->id;
                        }
                    }
                }
                if(!empty($newlistpromoid))
                {
                    $arr_aid = array();
			        $getListStore = Core_Store::getStores(array('fregion' => $regionid),'','');
			        if(!empty($getListStore))
			        {
			            foreach($getListStore as $st)
			            {
			                if(!in_array($st->aid, $arr_aid))
				            {
				                $arr_aid[] = $st->aid;
				            }
			            }
			        }
                    $formDataProductPromo = array('fpromoidarr' => $newlistpromoid);

                    if(!empty($arr_aid))
                    {
                        $formDataProductPromo['faidarr'] = $arr_aid;
                    }
                    $getPromotionProduct = Core_PromotionProduct::getPromotionProducts($formDataProductPromo,'','');

                    $listproductid = array();
                    $listpromotionbarcode = array();
                    foreach($getPromotionProduct as $ppro)
                    {
                        $ppro->pbarcode = trim($ppro->pbarcode);
                        if(!in_array($ppro->pbarcode, $listproductid))
                        {
                            $listproductid[] = trim($ppro->pbarcode);
                        }
                        if(!empty($listPromotionGroup[$ppro->promoid]))
                        {
                            $listpromotionbarcode[$ppro->pbarcode][$ppro->promoid]= $listPromotionGroup[$ppro->promoid];
                        }
                    }
                    //get promotion combo
                    $getPromotionCombo = Core_PromotionCombo::getPromotionCombos(array('fpromoidarr' => $newlistpromoid),'','');
                    if(!empty($getPromotionCombo))
                    {
                        $listcombo = array();
                        foreach($getPromotionCombo as $pcobo)
                        {
                            if(!in_array($pcobo->coid, $listcombo))
                            {
                                $listcombo[] = $pcobo->coid;
                            }
                        }
                        if(!empty($listcombo))
                        {
                            $listproductcombo = Core_RelProductCombo::getRelProductCombos(array('fcoidarr'=>$listcombo),'','');
                            if(!empty($listproductcombo))
                            {
                                foreach($listproductcombo as $lcombo)
                                {
                                    $lcombo->pbarcode = trim($lcombo->pbarcode);
                                    if(!in_array($lcombo->pbarcode, $listproductid))
                                    {
                                        $listproductid[] = $lcombo->pbarcode;
                                    }
                                }
                            }
                        }
                    }

                    if(!empty($listproductid))
                    {
                        $getProduct = Core_Product::getProducts(array('fpbarcodearr' => $listproductid), '', '');
                        $newProductList = array();

                        foreach($getProduct as $prod)
                        {
                            if($prod->sellprice > 0 && $prod->onsitestatus > 0 && $prod->status == Core_Product::STATUS_ENABLE)
                            {
                                $promoproduct = array();
                                if(!empty($listpromotionbarcode[$prod->barcode]))
                                {

                                    foreach($listpromotionbarcode[$prod->barcode] as $promoid=>$value)
                                    {
                                        if(!empty($listPromotionGroup[$promoid]))
                                        {
                                            $promoproduct['name'] = $listPromotionGroup[$promoid]['promog_name'];
                                            $promoproduct['isdiscount'] = $listPromotionGroup[$promoid]['promog_isdiscount'];
                                            $promoproduct['discountvalue'] = $listPromotionGroup[$promoid]['promog_discountvalue'];
                                            $promoproduct['isdiscountpercent'] = $listPromotionGroup[$promoid]['isdiscountpercent'];
                                            break;//mỗi sản phẩm lấy 1 khuyến mãi không lấy khuyến mãi là combo
                                        }
                                    }

                                }

                                $getFinalPrice = Core_RelRegionPricearea::getPriceByProductRegion($prod->barcode,$regionid);
                                $sellprice = (!empty($getFinalPrice)?$getFinalPrice:(!empty($prod->sellprice)?($prod->sellprice):0));
                                if(!empty($promoproduct))
                                {
                                    if((int)$promoproduct['isdiscount'] > 0)
                                    {
                                        if((int)$promoproduct['isdiscountpercent'] > 0)
                                        {
                                            $promoproduct['pricepromotion'] = round($sellprice - ($sellprice*$promoproduct['discountvalue']/100),0);
                                            $prod->promotionprice = $promoproduct['pricepromotion'];
                                        }
                                        else
                                        {
                                            $promoproduct['pricepromotion'] = $sellprice - $promoproduct['discountvalue'] ;
                                            $prod->promotionprice = $promoproduct['pricepromotion'];
                                        }
                                    }
                                    else{
                                        $promoproduct['pricepromotion'] = 0;
                                    }
                                }
                                //
                                $newsummary = '';
                                $explodenewsummary = explode("\n",$prod->summary);//Helper::xss_replacewithBreakline(strip_tags($pro->summary));
                                if(!empty($explodenewsummary)){
                                    $cnt = 0;
                                    foreach($explodenewsummary as $suma){
                                        $suma = strip_tags(htmlspecialchars_decode($suma));
                                        $suma = trim(preg_replace( '/[\s]+/mu', " ",$suma));
                                        if(!empty($suma))
                                        {
                                            if(substr($suma,0,1) =='-') $suma = trim(substr($suma,1));
                                            if(!empty($suma) && $suma !='-'){
                                                if($cnt++==3) break;
                                                $newsummary .= '<span>'.$suma.'</span>';
                                            }
                                        }
                                    }
                                }
                                $proitem = $prod;
                                //Tính giá của sản phẩm
                                $proitem->sellprice = $sellprice;

                                $proitem->summary = $newsummary;

                                $proitem->promotion = $promoproduct;
                                $newProductList[] = $proitem;
                            }
                        }
                        return $newProductList;
                    }
                }
            }
        }
        return false;
    }

    //Lấy promotion giảm giá
    public static function getProductPromotionListHaveDiscountPrice($limit = '', $countOnly = false)
    {
        $listPromotion = self::getPromotions(array('fisavailable' => 1),'promo_id','DESC', $limit,$countOnly);

        if($countOnly ) return $listPromotion;//number of promotion

        if(empty($listPromotion)) return false;
        $promotionlistids = array();
        foreach($listPromotion as $promo)
        {
            $promotionlistids[] = $promo->id;
        }
        if(empty($promotionlistids)) return false;

        $promotiongroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $promotionlistids, 'fisdiscountvaluegreater' => 0),'discountvalue','DESC');

        if(empty($promotiongroup)) return false;

        $promotionlistids = array();
        $listpromotiongroup = array();
        foreach($promotiongroup as $promogp)
        {
            if(!in_array($promogp->promoid, $promotionlistids))
            {
                $promotionlistids[] = $promogp->promoid;
                $listpromotiongroup[$promogp->promoid] = $promogp;
            }
        }

        if(empty($promotionlistids)) return false;

        //get promotion store
        $getPromotionStores = Core_PromotionStore::getPromotionStores(array('fpromoidarr' => $promotionlistids),'','');
        if(empty($getPromotionStores)) return false;

        $listStorePromotId = array();
        $listStoreids = array();
        foreach($getPromotionStores as $store)
        {
            if(!in_array($store->sid, $listStoreids))
            {
                $listStoreids[] = $store->sid;
            }
            $listStorePromotId[$store->sid][] = $store->promoid;//1 store có nhiều promotion
        }

        if(empty($listStoreids)) return false;

        //get list of store
        $getStoreList = Core_Store::getStores(array('fidarr' => $listStoreids),'','');
        if(empty($getStoreList)) return false;

        $listarrid = array();//list of store id
        $listPriceArea = array();
        $getAreaPromoId = array();
        foreach($getStoreList as $store)
        {
            if(!in_array($store->aid, $listarrid))
            {
                $listarrid[] = $store->aid;
            }
            if(!in_array($store->ppaid, $listPriceArea))
            {
                $listPriceArea[] = $store->ppaid;
            }
            if(!empty($listStorePromotId[$store->id]))
            {
                $getAreaPromoId[$store->aid][$store->id] = $listStorePromotId[$store->id]; //1 area có nhiều store và nhiều promotion
            }
        }

        if(empty($listarrid) || empty($getAreaPromoId) || empty($listPriceArea)) return false;

        //get product apply list
        $getPromotionProduct = Core_PromotionProduct::getPromotionProducts(array('fpromoidarr' => $promotionlistids,'faidarr' => $listarrid),'','');

        if(empty($getPromotionProduct)) return false;

        $listRegionPriceAreas = Core_RelRegionPricearea::getRelRegionPriceareas(array('faidarr' => $listarrid, 'fppaidarr' => $listPriceArea),'','');
        if(empty($listRegionPriceAreas)) return false;
        $listRegionPromotion = array();
        foreach($listRegionPriceAreas as $relRP)
        {
            if(!empty($getAreaPromoId[$relRP->aid]))
            {
                foreach($getAreaPromoId[$relRP->aid] as $listpromotionid)
                {
                    if(!empty($listpromotionid) && is_array($listpromotionid))
                    {
                        foreach($listpromotionid as $promoid)
                        {
                            $listRegionPromotion[$promoid][] = $relRP->rid;//;
                        }
                    }

                    //
                }
            }
        }
        //echodebug($listRegionPromotion, true);
        $listProductBarcode = array();
        $listProductPromotion = array();
        foreach($getPromotionProduct as $promoproduct)
        {
            $promoproduct->pbarcode = trim($promoproduct->pbarcode);
            if(!in_array($promoproduct->pbarcode,$listProductBarcode))
            {
                $listProductBarcode[] = $promoproduct->pbarcode;
                $listProductPromotion[$promoproduct->pbarcode][] = $promoproduct->promoid;
            }
        }

        return array('listPromotionGroup' => $listpromotiongroup,
                      'listProductBarcode' => $listProductBarcode,
                      'regionPromotion' => $listRegionPromotion,
                      'listPromotionProduct' => $listProductPromotion,
                     );
    }

    public static function getPromotionNameByProductID($barcode, $regionid = '')
    {
        if(!empty($barcode))
        {
            $product = Core_Product::getProducts(array('fbarcode' => $barcode), '', '', 1);
            if(!empty($product[0]))
            {
                $product = $product[0];
                //lấy khu vực của region
                $arr_areaid = array();
                $arr_ppaid = array();
                $arr_storeid = array();
                //$getRelRegionPriceArea = Core_RelRegionPricearea::getRelRegionPriceareas(array('frid' => $regionid),'','');
                $getRelRegionPriceArea = Core_Store::getStores(array('fregion' => $regionid),'','');
                if(!empty($getRelRegionPriceArea))
                {
                    foreach($getRelRegionPriceArea as $item)
                    {
                        $arr_storeid[] = $item->id;
                        if(!in_array($item->aid, $arr_areaid))
                        {
                            $arr_areaid[] = $item->aid;
                        }
                        if(!in_array($item->ppaid, $arr_ppaid))
                        {
                            $arr_ppaid[] = $item->ppaid;
                        }
                    }
                }

                //lấy tất cả các promotion của sản phẩm
                $allPromotionsByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($barcode), 'faidarr' => $arr_areaid),'','');

                //Lấy tất cả các product của combo mà có product hiện tại
                //$allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fpbarcode' => $barcode),'','');
                $allProductsByCombo = Core_RelProductCombo::getRelProductCombos(array('fpbarcode' => trim($barcode)),'','');//lấy tạm thời rồi sửa sau

                $allPromotionsByCombo = null;
                if(!empty($allProductsByCombo))
                {
                    $arr_cobo = array();
                    foreach($allProductsByCombo as $prodcom)
                    {
                        if(!in_array($prodcom->coid, $arr_cobo))
                        {
                            $arr_cobo[] = $prodcom->coid;
                        }
                    }
                    if(!empty($arr_cobo))
                    {
                        //Kiểm tra combo có active hoặc bị delete hay không
                        $checkValidationCombo = Core_Combo::getCombos(array('fidarr' => $arr_cobo, 'fisdeleted' => 0, 'fisactive' =>1),'','');
                        $arr_cobo = array();
                        if(!empty($checkValidationCombo))
                        {
                            foreach($checkValidationCombo as $ncobo)
                            {
                                $arr_cobo[] = $ncobo->id;
                            }
                        }
                        if(!empty($arr_cobo))
                        {
                            $allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fcoidarr' => $arr_cobo),'','');
                        }
                    }
                }
                $listNewPromotionByCombo = array();
                //lấy promotion của product theo area
                $arr_promotion = array();
                if(!empty($allPromotionsByProduct))
                {
                    foreach($allPromotionsByProduct as $pp)
                    {
                        if(!in_array($pp->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pp->promoid;
                        }
                    }
                }
                if(!empty($allPromotionsByCombo))
                {
                    foreach($allPromotionsByCombo as $pc)
                    {
                        if(!in_array($pc->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pc->promoid;
                        }
                        $listNewPromotionByCombo[$pc->promoid][] = $pc;
                    }
                }
                //echodebug($arr_promotion);
                //echodebug($arr_storeid);
                //Lấy ra được list promotion rồi,  bắt đầu móc ra tất cả các chương trình promotion
                $listpromotionstore = null;
                if(count($arr_storeid) > 0 && count($arr_promotion))
                {
                    $listpromotionstore = Core_PromotionStore::getPromotionStores(array('fsidarr' => $arr_storeid, 'fpromoidarr' => $arr_promotion), '', '');
                }
                //echodebug($listpromotionstore, true);
                $arr_newpromotionid = array();
                if(!empty($listpromotionstore))
                {
                    foreach($listpromotionstore as $ps)
                    {

                        if(in_array($ps->promoid, $arr_newpromotionid)==false)
                        {
                            $arr_newpromotionid[] = $ps->promoid;
                        }
                    }
                }        //die();
                if(!empty($arr_newpromotionid))
                {
                    $newlistpromotions = array();
                    return self::getPromotions(array('fidarr' => $arr_newpromotionid, 'fisavailable' => 1),'','');
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
		return 'promo_'.$id;
	}

	public static function cacheGet($id, &$cacheSuccess = false, $forceSet = false)
	{
		global $db;

		$key = self::cacheBuildKey($id);

		$myPromotion = new Core_Promotion();

		//get current cache
		$myCacher = new Cacher($key);
		$row = $myCacher->get();

		//force to store new value
		if(!$row || isset($_GET['live']) || $forceStore)
		{
			$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'promotion
					WHERE promo_id = ? ';
			$row = $db->query($sql, array($id))->fetch();
			if($row['promo_id'] > 0)
			{
				$myPromotion->getDataByArray($row);

				//store new value
				Core_Object::cacheSet($key, $row);
			}
		}
		else
		{
			$myPromotion->getDataByArray($row);
		}

		return $myPromotion;
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
    //222 : hình thức xuất online tiết kiệm
    public static function getAllPromotionwithOutputByBarcode($barcode, $outputtype = 222)
    {
        $barcode = trim($barcode);
        if(!empty($barcode))
        {
            $product = Core_Product::getIdByBarcode($barcode);

            if(!empty($product->id))
            {
                $fsellprice = Core_RelRegionPricearea::getPriceByProductRegion(trim($barcode), 3, false, 222);
                if($fsellprice > 0)
                {
                    $product->sellprice = $fsellprice;
                }

                //lấy tất cả các promotion của sản phẩm
                $allPromotionsByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($barcode)),'','');
                //lấy promotion của product theo area
                $arr_promotion = array();
                if(!empty($allPromotionsByProduct))
                {
                    foreach($allPromotionsByProduct as $pp)
                    {
                        if(!in_array($pp->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pp->promoid;
                        }
                    }
                }

                //
                if(empty($arr_promotion)) return false;
                $listpromotionoutput = Core_PromotionOutputtype::getPromotionOutputtypes(array('fpromoidarr' => $arr_promotion, 'fpoid' => $outputtype),'','');

                $arr_newpromotionid = array();
                if(!empty($listpromotionoutput))
                {
                    foreach($listpromotionoutput as $promoout)
                    {
                        if(!in_array($promoout->promoid, $arr_newpromotionid))
                        {
                            $arr_newpromotionid[] = $promoout->promoid;
                        }
                    }
                }

                if(!empty($arr_newpromotionid))
                {
                    $getAllPromotions = self::getPromotions(array('fidarr' => $arr_newpromotionid, 'fisavailable' => 1),'','');

                    if(!empty($getAllPromotions))
                    {
                        if(count($getAllPromotions) <= count($arr_newpromotionid))
                        {
                            $arr_newpromotionid = array();
                            $arr_promotionname = array();
                            $pricepromotion = 0;
                            foreach($getAllPromotions as $promotion)
                            {
                                if(!in_array($promotion->id, $arr_newpromotionid))
                                {
                                    $arr_newpromotionid[] = $promotion->id;
                                    $arr_promotionname[$promotion->id] = $promotion->description;
                                }
                            }
                            if(!empty($arr_newpromotionid))
                            {
                                $getPromotionGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arr_newpromotionid),'discountvalue','DESC');

                                if(!empty($getPromotionGroup))
                                {
                                    foreach($getPromotionGroup as $gp)
                                    {
                                        if((int)$gp->discountvalue > 0)
                                        {
                                            //$pricediscount['promoid'] = $gp->promoid;
                                            if((int)$gp->isdiscountpercent > 0)
                                            {
                                                //$pricediscount['percent'] = 1; //giảm giá theo tỉ lệ %
                                                //$pricediscount['discountvalue'] = $gp->discountvalue;
                                                $product->promotionprice = $product->sellprice - ($product->sellprice * $gp->discountvalue / 100);
                                            }
                                            else{
                                                //$pricediscount['percent'] = -1; //giảm giá theo tỉ lệ %
                                                //$pricediscount['discountvalue'] = $gp->discountvalue;
                                                $product->promotionprice = $product->sellprice - $gp->discountvalue;
                                            }
                                            $product->promotionid = $gp->promoid;
                                            break;
                                        }
                                    }
                                }
                                $product->listpromotionname = $arr_promotionname;
                                return $product;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function getPromotionByProductIDBackEnd($barcode, $regionid = '', $finalprice = 0)
    {
        if(!empty($barcode))
        {
            $barcode = trim($barcode);
            $formData = array();
            $product = Core_Product::getIdByBarcode($barcode);//Core_Product::getProducts(array('fbarcode' => $barcode), '', '', 1);
            if(!empty($product->id) && $product->sellprice > 0 && $product->onsitestatus > 0)
            {
                //$product = $product[0];
                //lấy khu vực của region
                $arr_areaid = array();
                $arr_ppaid = array();
                $arr_storeid = array();
                $getRelRegionPriceArea = Core_Store::getStores(array('fregion' => $regionid),'','');
                if(!empty($getRelRegionPriceArea))
                {
                    foreach($getRelRegionPriceArea as $item)
                    {
                        $arr_storeid[] = $item->id;
                        if(!in_array($item->aid, $arr_areaid))
                        {
                            $arr_areaid[] = $item->aid;
                        }
                        if(!in_array($item->ppaid, $arr_ppaid))
                        {
                            $arr_ppaid[] = $item->ppaid;
                        }
                    }
                }

                //lấy tất cả các promotion của sản phẩm
                $allPromotionsByProduct = Core_PromotionProduct::getPromotionProducts(array('fpbarcode' => trim($barcode), 'faidarr' => $arr_areaid),'','');

                //Lấy tất cả các product của combo mà có product hiện tại
                //$allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fpbarcode' => $barcode),'','');
                $allProductsByCombo = Core_RelProductCombo::getRelProductCombos(array('fpbarcode' => trim($barcode)),'','');//lấy tạm thời rồi sửa sau

                $allPromotionsByCombo = null;
                if(!empty($allProductsByCombo))
                {
                    $arr_cobo = array();
                    foreach($allProductsByCombo as $prodcom)
                    {
                        if(!in_array($prodcom->coid, $arr_cobo))
                        {
                            $arr_cobo[] = $prodcom->coid;
                        }
                    }
                    if(!empty($arr_cobo))
                    {
                        //Kiểm tra combo có active hoặc bị delete hay không
                        $checkValidationCombo = Core_Combo::getCombos(array('fidarr' => $arr_cobo, 'fisdeleted' => 0, 'fisactive' =>1),'','');
                        $arr_cobo = array();
                        if(!empty($checkValidationCombo))
                        {
                            foreach($checkValidationCombo as $ncobo)
                            {
                                $arr_cobo[] = $ncobo->id;
                            }
                        }
                        if(!empty($arr_cobo))
                        {
                            $allPromotionsByCombo = Core_PromotionCombo::getPromotionCombos(array('fcoidarr' => $arr_cobo),'','');
                        }
                    }
                }
                $listNewPromotionByCombo = array();
                //lấy promotion của product theo area
                $arr_promotion = array();
                if(!empty($allPromotionsByProduct))
                {
                    foreach($allPromotionsByProduct as $pp)
                    {
                        if(!in_array($pp->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pp->promoid;
                        }
                    }
                }
                if(!empty($allPromotionsByCombo))
                {
                    foreach($allPromotionsByCombo as $pc)
                    {
                        if(!in_array($pc->promoid, $arr_promotion))
                        {
                            $arr_promotion[] = $pc->promoid;
                        }
                        $listNewPromotionByCombo[$pc->promoid][] = $pc;
                    }
                }
                //echodebug($arr_promotion);
                //echodebug($arr_storeid);
                //Lấy ra được list promotion rồi,  bắt đầu móc ra tất cả các chương trình promotion
                $listpromotionstore = null;
                if(count($arr_storeid) > 0 && count($arr_promotion))
                {
                    $listpromotionstore = Core_PromotionStore::getPromotionStores(array('fsidarr' => $arr_storeid, 'fpromoidarr' => $arr_promotion), '', '');
                }
                //echodebug($listpromotionstore, true);
                $arr_newpromotionid = array();
                if(!empty($listpromotionstore))
                {
                    foreach($listpromotionstore as $ps)
                    {

                        if(in_array($ps->promoid, $arr_newpromotionid)==false)
                        {
                            $arr_newpromotionid[] = $ps->promoid;
                        }
                    }
                }        //die();
                if(!empty($arr_newpromotionid))
                {
                    $newlistpromotions = array();
                    $promotionlist = self::getPromotions(array('fidarr' => $arr_newpromotionid, 'fisactived' => 1, 'fenddate' => time()),'','');
                    if(!empty($promotionlist))
                    {
                        //móc những khuyến mãi của sản phẩm
                        $promoGroup = Core_Promotiongroup::getPromotiongroups(array('fpromoidarr' => $arr_newpromotionid),'discountvalue','DESC');

                        $newpromoGroup = array();//'fisdiscountvaluegreater' => 0
                        $promotionGroupDiscount = array();
                        $promotionGroupNoDiscount = array();
                        if(!empty($promoGroup))
                        {
                            foreach($promoGroup as $promdis)
                            {
                                $newpromoGroup[$promdis->promoid] = $promdis;
                            }
                        }
                        //echodebug($newpromoGroup);
                        foreach($promotionlist as $promo)
                        {
                            //khuyến mãi theo sản phẩm
                            if(!empty($newpromoGroup[$promo->id]))
                            {
                                foreach($newpromoGroup[$promo->id] as $pg)
                                {
                                    $promorow = array();
                                    $promorow['promoid'] = $promo->id;
                                    //$promorow['promoname'] = !empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name);//;
                                     $promorow['promoname'] = !empty($promo->descriptionclone)?$promo->descriptionclone:(!empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name));//;
                                    $promorow['startdate'] = $promo->startdate;
                                    $promorow['enddate'] = $promo->enddate;
                                    $promorow['isproduct'] = 1;//isproduct là biến để nhận biết trường hợp khuyến mãi của sản phẩm, 0: là khuyến mãi dạng combo
                                    $promorow['promotiongroup'] = $pg;//->name
                                    $promorow['pricepromotion'] = 0;
                                    $promorow['promotionstatus'] = $promo->status;
                                    $promorow['promotiongrouptype'] = $pg->type;// 0: chỉ được chọn giảm giá hoặc tặng quà, 1: được chọn cả 2; 2: Bắt buộc chọn cả 2
                                    if($finalprice > 0)
                                    {
                                        if((int)$pg->isdiscount > 0)
                                        {
                                            if((int)$pg->isdiscountpercent > 0)
                                            {
                                                $promorow['pricepromotion'] = round($finalprice - ($finalprice*$pg->discountvalue/100),0);
                                            }
                                            else {
                                                $promorow['pricepromotion'] = $finalprice - $pg->discountvalue;
                                            }
                                        }
                                    }
                                    $newlistpromotions[] = $promorow;
                                    break;
                                }
                            }
                            elseif(!empty($listNewPromotionByCombo[$promo->id]))
                            {
                                //Khuyến mãi theo combo
                                foreach($listNewPromotionByCombo[$promo->id] as $promocombo)
                                {
                                    $promorow = array();
                                    $promorow['promoid'] = $promo->id;
                                    $promorow['promoname'] = $promo->name;
                                    $promorow['isproduct'] = 0;//khuyến mãi là combo
                                    $promorow['combo'] = $promocombo;
                                    $newlistpromotions[] = $promorow;
                                    break;
                                }
                            }
                            else{
								$promorow = array();
                                $promorow['promoid'] = $promo->id;
                                $promorow['promoname'] = !empty($promo->description)?$promo->description:(!empty($promo->shortdescription)?$promo->shortdescription:$promo->name);//;
                                $promorow['startdate'] = $promo->startdate;
                                $promorow['enddate'] = $promo->enddate;
                                $promorow['isproduct'] = 1;//isproduct là biến để nhận biết trường hợp khuyến mãi của sản phẩm, 0: là khuyến mãi dạng combo
                                $promorow['pricepromotion'] = 0;
                                $promorow['promotionstatus'] = $promo->status;
                                $newlistpromotions[] = $promorow;
                            }
                        }

                        //$formData['listDiscountPromotion'] = $newlistDiscountPromotion;
                        $formData['listPromotions'] = $newlistpromotions;
                    }
                }
            }
            return $formData;
        }
        return false;
    }

}
