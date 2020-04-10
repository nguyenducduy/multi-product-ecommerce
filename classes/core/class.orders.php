<?php

/**
 * core/class.orders.php
 *
 * File contains the class used for Orders Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_Orders extends Core_Object
{
    const STATUS_PENDING = 1;
    const STATUS_RETURNPENDING = 2;
    const STATUS_PROCESSING = 3;
    const STATUS_RETURNPROCESSING = 5;
    const STATUS_RETURNREQUEST = 7;
    const STATUS_SHIPPING = 10;
    const STATUS_COMPLETED = 13;
    const STATUS_CANCEL = 15;
    const STATUS_CANCELMERGE = 16;
    const STATUS_ERROR = 20;

    const GENDER_UNKNOWN = 0;
	const GENDER_MALE = 1;
	const GENDER_FEMALE = 2;

    const DELIVERY_STORED = 1;
    const DELIVERY_IN24H = 5;
    const DELIVERY_DISCOUNT72H = 10;

    const PAYMENT_CASH = 121;
    const PAYMENT_CARDINHOUSE = 5;
    const PAYMENT_ONLINE = 10;
    const PAYMENT_TRANSFER = 144;

    const PAYMENT_ISDONE = 3;
    const PAYMENT_ISGIF = 2;

    public $uid = 0;
    public $id = 0;
    public $orderidcrm = 0;
    public $relatedorderid = 0;
    public $invoiceid = "";
    public $pricesell = 0;
    public $priceship = 0;
    public $pricediscount = 0;
    public $pricetax = 0;
    public $pricehandling = 0;
    public $pricefinal = 0;
    public $coupon = "";
    public $couponvalue = 0;
    public $promotionid = 0;
    public $promotionvalue = 0;
    public $contactemail = "";
    public $billinggender = 0;
    public $billingfullname = "";
    public $billingphone = "";
    public $billingaddress = "";
    public $billingregionid = 0;
    public $billingcountry = "";
    public $billingdistrict = 0;
    public $shippingfullname = "";
    public $shippingphone = "";
    public $shippingaddress = "";
    public $shippingcountry = "";
    public $shippingregionid = 0;
    public $shippingdistrict = 0;
    public $shippinglat = 0;
    public $shippinglng = 0;
    public $shippingservice = 0;
    public $shippingtrackingcode = "";
    public $ipaddress = 0;
    public $paymentisdone = 0;
    public $paymentmethod = 0;
    public $deliverymethod = 0;
    public $status = 0;
    public $isgift = 0;
    public $note = "";
    public $datecreated = 0;
    public $ordercrmdate = 0;
    public $datemodified = 0;
    public $datecompleted = 0;

    public function __construct($id = 0)
    {
        parent::__construct();

        if($id > 0)
            $this->getData($id);
    }

    public function paymentisdone()
    {
        if ($this->paymentisdone == self::PAYMENT_ISDONE) return true;
        return false;
    }

    public function paymentisgif()
    {
        if ($this->isgift == self::PAYMENT_ISGIF) return true;
        return false;
    }

    public function getpaymentOrderStatus()
    {
        return self::getOrderStatus($this->status);
    }

    public function getpaymentOrderDeliveryMethod()
    {
        return self::getOrderDeliveryMethod($this->deliverymethod);
    }

    public function getpaymentOrderMethod()
    {
        return self::getOrderPaymentMethod($this->paymentmethod);
    }

    public static function getOrderStatus($key = '')
    {
        global $registry;
        $array = array(
                                self::STATUS_PENDING => $registry->lang['controller']['labelorderStatusPending'],
                                self::STATUS_PROCESSING => $registry->lang['controller']['labelorderStatusProcessing'],
                                self::STATUS_RETURNPROCESSING => $registry->lang['controller']['labelorderStatusReturnProcessing'],
                                self::STATUS_SHIPPING => $registry->lang['controller']['labelorderStatusShipping'],
                                self::STATUS_COMPLETED => $registry->lang['controller']['labelorderStatusCompleted'],
                                self::STATUS_CANCEL => $registry->lang['controller']['labelorderStatusCancel'],
                                self::STATUS_ERROR => $registry->lang['controller']['labelorderStatusError'],
                                self::STATUS_RETURNPENDING => $registry->lang['controller']['labelorderStatusReturnPending'],
                                self::STATUS_RETURNREQUEST => $registry->lang['controller']['labelorderStatusReturnRequest'],
                                self::STATUS_CANCELMERGE => $registry->lang['controller']['labelorderStatusCancelMerge'],
                            );
        if(!empty($key) && !empty($array[$key])) {
            return $array[$key];
        }
        return $array;
    }

    public static function getOrderDeliveryMethod($key = '')
    {
        global $registry;
        $array = array(
                                self::DELIVERY_STORED => $registry->lang['controller']['labelorderDeliveryStore'],
                                self::DELIVERY_IN24H => $registry->lang['controller']['labelorderDeliveryIn24H'],
                                //self::DELIVERY_DISCOUNT72H => $registry->lang['controller']['labelorderDeliveryDiscount72H'],
                            );
        if(!empty($key) && !empty($array[$key])) {
            return $array[$key];
        }

        return $array;
    }

    public static function getOrderPaymentMethod($key = '')
    {
        global $registry;
        $array = array(
                                self::PAYMENT_CASH => $registry->lang['controller']['labelorderPaymenMethodCash'],
                                self::PAYMENT_CARDINHOUSE => $registry->lang['controller']['labelorderPaymentMethodCardInHouse'],
                                self::PAYMENT_ONLINE => $registry->lang['controller']['labelorderPaymentMethodOnline'],
                                self::PAYMENT_TRANSFER => $registry->lang['controller']['labelorderPaymentMethodTransfer'],
                            );
        if(!empty($key) && !empty($array[$key])) {
            return $array[$key];
        }
        return $array;
    }

    /**
     * Insert object data to database
     * @return int The inserted record primary key
     */
    public function addData()
    {
        $this->datecreated = time();


        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'orders (
                    u_id,
                    o_orderidcrm,
                    o_related_orderid,
                    o_invoiceid,
                    o_price_sell,
                    o_price_ship,
                    o_price_discount,
                    o_price_tax,
                    o_price_handling,
                    o_price_final,
                    o_coupon,
                    o_couponvalue,
                    o_promotionid,
                    o_promotionvalue,
                    o_contactemail,
                    o_billing_gender,
                    o_billing_fullname,
                    o_billing_phone,
                    o_billing_address,
                    o_billing_regionid,
                    o_billing_country,
                    o_billing_district,
                    o_shipping_fullname,
                    o_shipping_phone,
                    o_shipping_address,
                    o_shipping_country,
                    o_shipping_regionid,
                    o_shipping_district,
                    o_shipping_lat,
                    o_shipping_lng,
                    o_shipping_service,
                    o_shipping_trackingcode,
                    o_ipaddress,
                    o_payment_isdone,
                    o_payment_method,
                    o_delivery_method,
                    o_status,
                    o_isgift,
                    o_note,
                    o_datecreated,
                    o_ordercrmdate,
                    o_datemodified,
                    o_datecompleted
                    )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $rowCount = $this->db->query($sql, array(
                    (int)$this->uid,
                    (int)$this->orderidcrm,
                    (int)$this->relatedorderid,
                    (string)$this->invoiceid,
                    (float)$this->pricesell,
                    (float)$this->priceship,
                    (float)$this->pricediscount,
                    (float)$this->pricetax,
                    (float)$this->pricehandling,
                    (float)$this->pricefinal,
                    (string)$this->coupon,
                    (float)$this->couponvalue,
                    (int)$this->promotionid,
                    (float)$this->promotionvalue,
                    (string)$this->contactemail,
                    (int)$this->billinggender,
                    (string)$this->billingfullname,
                    (string)$this->billingphone,
                    (string)$this->billingaddress,
                    (int)$this->billingregionid,
                    (string)$this->billingcountry,
                    (int)$this->billingdistrict,
                    (string)$this->shippingfullname,
                    (string)$this->shippingphone,
                    (string)$this->shippingaddress,
                    (string)$this->shippingcountry,
                    (int)$this->shippingregionid,
                    (int)$this->shippingdistrict,
                    (float)$this->shippinglat,
                    (float)$this->shippinglng,
                    (int)$this->shippingservice,
                    (string)$this->shippingtrackingcode,
                    (int)$this->ipaddress,
                    (int)$this->paymentisdone,
                    (int)$this->paymentmethod,
                    (int)$this->deliverymethod,
                    (int)$this->status,
                    (int)$this->isgift,
                    (string)$this->note,
                    (int)$this->datecreated,
                    (int)$this->ordercrmdate,
                    (int)$this->datemodified,
                    (int)$this->datecompleted
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


        $sql = 'UPDATE ' . TABLE_PREFIX . 'orders
                SET u_id = ?,
                    o_orderidcrm = ?,
                    o_related_orderid = ?,
                    o_invoiceid = ?,
                    o_price_sell = ?,
                    o_price_ship = ?,
                    o_price_discount = ?,
                    o_price_tax = ?,
                    o_price_handling = ?,
                    o_price_final = ?,
                    o_coupon = ?,
                    o_couponvalue = ?,
                    o_promotionid = ?,
                    o_promotionvalue = ?,
                    o_contactemail = ?,
                    o_billing_gender = ?,
                    o_billing_fullname = ?,
                    o_billing_phone = ?,
                    o_billing_address = ?,
                    o_billing_regionid = ?,
                    o_billing_country = ?,
                    o_billing_district = ?,
                    o_shipping_fullname = ?,
                    o_shipping_phone = ?,
                    o_shipping_address = ?,
                    o_shipping_country = ?,
                    o_shipping_regionid = ?,
                    o_shipping_district = ?,
                    o_shipping_lat = ?,
                    o_shipping_lng = ?,
                    o_shipping_service = ?,
                    o_shipping_trackingcode = ?,
                    o_ipaddress = ?,
                    o_payment_isdone = ?,
                    o_payment_method = ?,
                    o_delivery_method = ?,
                    o_status = ?,
                    o_isgift = ?,
                    o_note = ?,
                    o_datecreated = ?,
                    o_ordercrmdate = ?,
                    o_datemodified = ?,
                    o_datecompleted = ?
                WHERE o_id = ?';

        $stmt = $this->db->query($sql, array(
                    (int)$this->uid,
                    (int)$this->orderidcrm,
                    (int)$this->relatedorderid,
                    (string)$this->invoiceid,
                    (float)$this->pricesell,
                    (float)$this->priceship,
                    (float)$this->pricediscount,
                    (float)$this->pricetax,
                    (float)$this->pricehandling,
                    (float)$this->pricefinal,
                    (string)$this->coupon,
                    (float)$this->couponvalue,
                    (int)$this->promotionid,
                    (float)$this->promotionvalue,
                    (string)$this->contactemail,
                    (int)$this->billinggender,
                    (string)$this->billingfullname,
                    (string)$this->billingphone,
                    (string)$this->billingaddress,
                    (int)$this->billingregionid,
                    (string)$this->billingcountry,
                    (int)$this->billingdistrict,
                    (string)$this->shippingfullname,
                    (string)$this->shippingphone,
                    (string)$this->shippingaddress,
                    (string)$this->shippingcountry,
                    (int)$this->shippingregionid,
                    (int)$this->shippingdistrict,
                    (float)$this->shippinglat,
                    (float)$this->shippinglng,
                    (int)$this->shippingservice,
                    (string)$this->shippingtrackingcode,
                    (int)$this->ipaddress,
                    (int)$this->paymentisdone,
                    (int)$this->paymentmethod,
                    (int)$this->deliverymethod,
                    (int)$this->status,
                    (int)$this->isgift,
                    (string)$this->note,
                    (int)$this->datecreated,
                    (int)$this->ordercrmdate,
                    (int)$this->datemodified,
                    (int)$this->datecompleted,
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
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'orders o
                WHERE o.o_id = ?';
        $row = $this->db->query($sql, array($id))->fetch();

        $this->uid = $row['u_id'];
        $this->id = $row['o_id'];
        $this->orderidcrm = $row['o_orderidcrm'];
        $this->relatedorderid = $row['o_related_orderid'];
        $this->invoiceid = $row['o_invoiceid'];
        $this->pricesell = $row['o_price_sell'];
        $this->priceship = $row['o_price_ship'];
        $this->pricediscount = $row['o_price_discount'];
        $this->pricetax = $row['o_price_tax'];
        $this->pricehandling = $row['o_price_handling'];
        $this->pricefinal = $row['o_price_final'];
        $this->coupon = $row['o_coupon'];
        $this->couponvalue = $row['o_couponvalue'];
        $this->promotionid = $row['o_promotionid'];
        $this->promotionvalue = $row['o_promotionvalue'];
        $this->contactemail = $row['o_contactemail'];
        $this->billinggender = $row['o_billing_gender'];
        $this->billingfullname = $row['o_billing_fullname'];
        $this->billingphone = $row['o_billing_phone'];
        $this->billingaddress = $row['o_billing_address'];
        $this->billingregionid = $row['o_billing_regionid'];
        $this->billingcountry = $row['o_billing_country'];
        $this->billingdistrict = $row['o_billing_district'];
        $this->shippingfullname = $row['o_shipping_fullname'];
        $this->shippingphone = $row['o_shipping_phone'];
        $this->shippingaddress = $row['o_shipping_address'];
        $this->shippingcountry = $row['o_shipping_country'];
        $this->shippingregionid = $row['o_shipping_regionid'];
        $this->shippingdistrict = $row['o_shipping_district'];
        $this->shippinglat = $row['o_shipping_lat'];
        $this->shippinglng = $row['o_shipping_lng'];
        $this->shippingservice = $row['o_shipping_service'];
        $this->shippingtrackingcode = $row['o_shipping_trackingcode'];
        $this->ipaddress = $row['o_ipaddress'];
        $this->paymentisdone = $row['o_payment_isdone'];
        $this->paymentmethod = $row['o_payment_method'];
        $this->deliverymethod = $row['o_delivery_method'];
        $this->status = $row['o_status'];
        $this->isgift = $row['o_isgift'];
        $this->note = $row['o_note'];
        $this->datecreated = $row['o_datecreated'];
        $this->ordercrmdate = $row['o_ordercrmdate'];
        $this->datemodified = $row['o_datemodified'];
        $this->datecompleted = $row['o_datecompleted'];
    }

    public function getInvoicedCode()
    {
        $code = Helper::alphaID($this->id, false, false, 'dodemtag09').Helper::RandomNumber(1000, 9999);
        return $code;
    }

    public function getDataByInvoiced($invoiceid)
    {
        $invoiceid = (int)$invoiceid;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'orders o
                WHERE o.o_invoiceid = ?';
        $row = $this->db->query($sql, array($invoiceid))->fetch();

        $this->uid = $row['u_id'];
        $this->id = $row['o_id'];
        $this->orderidcrm = $row['o_orderidcrm'];
        $this->relatedorderid = $row['o_related_orderid'];
        $this->invoiceid = $row['o_invoiceid'];
        $this->pricesell = $row['o_price_sell'];
        $this->priceship = $row['o_price_ship'];
        $this->pricediscount = $row['o_price_discount'];
        $this->pricetax = $row['o_price_tax'];
        $this->pricehandling = $row['o_price_handling'];
        $this->pricefinal = $row['o_price_final'];
        $this->coupon = $row['o_coupon'];
        $this->couponvalue = $row['o_couponvalue'];
        $this->promotionid = $row['o_promotionid'];
        $this->promotionvalue = $row['o_promotionvalue'];
        $this->contactemail = $row['o_contactemail'];
        $this->billinggender = $row['o_billing_gender'];
        $this->billingfullname = $row['o_billing_fullname'];
        $this->billingphone = $row['o_billing_phone'];
        $this->billingaddress = $row['o_billing_address'];
        $this->billingregionid = $row['o_billing_regionid'];
        $this->billingcountry = $row['o_billing_country'];
        $this->billingdistrict = $row['o_billing_district'];
        $this->shippingfullname = $row['o_shipping_fullname'];
        $this->shippingphone = $row['o_shipping_phone'];
        $this->shippingaddress = $row['o_shipping_address'];
        $this->shippingcountry = $row['o_shipping_country'];
        $this->shippingregionid = $row['o_shipping_regionid'];
        $this->shippingdistrict = $row['o_shipping_district'];
        $this->shippinglat = $row['o_shipping_lat'];
        $this->shippinglng = $row['o_shipping_lng'];
        $this->shippingservice = $row['o_shipping_service'];
        $this->shippingtrackingcode = $row['o_shipping_trackingcode'];
        $this->ipaddress = $row['o_ipaddress'];
        $this->paymentisdone = $row['o_payment_isdone'];
        $this->paymentmethod = $row['o_payment_method'];
        $this->deliverymethod = $row['o_delivery_method'];
        $this->status = $row['o_status'];
        $this->isgift = $row['o_isgift'];
        $this->note = $row['o_note'];
        $this->datecreated = $row['o_datecreated'];
        $this->ordercrmdate = $row['o_ordercrmdate'];
        $this->datemodified = $row['o_datemodified'];
        $this->datecompleted = $row['o_datecompleted'];
    }


    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'orders
                WHERE o_id = ?';
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

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'orders o';

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

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'orders o';

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
            $myOrders = new Core_Orders();

            $myOrders->uid = $row['u_id'];
            $myOrders->id = $row['o_id'];
            $myOrders->orderidcrm = $row['o_orderidcrm'];
            $myOrders->relatedorderid = $row['o_related_orderid'];
            $myOrders->invoiceid = $row['o_invoiceid'];
            $myOrders->pricesell = $row['o_price_sell'];
            $myOrders->priceship = $row['o_price_ship'];
            $myOrders->pricediscount = $row['o_price_discount'];
            $myOrders->pricetax = $row['o_price_tax'];
            $myOrders->pricehandling = $row['o_price_handling'];
            $myOrders->pricefinal = $row['o_price_final'];
            $myOrders->coupon = $row['o_coupon'];
            $myOrders->couponvalue = $row['o_couponvalue'];
            $myOrders->promotionid = $row['o_promotionid'];
            $myOrders->promotionvalue = $row['o_promotionvalue'];
            $myOrders->contactemail = $row['o_contactemail'];
            $myOrders->billinggender = $row['o_billing_gender'];
            $myOrders->billingfullname = $row['o_billing_fullname'];
            $myOrders->billingphone = $row['o_billing_phone'];
            $myOrders->billingaddress = $row['o_billing_address'];
            $myOrders->billingregionid = $row['o_billing_regionid'];
            $myOrders->billingcountry = $row['o_billing_country'];
            $myOrders->billingdistrict = $row['o_billing_district'];
            $myOrders->shippingfullname = $row['o_shipping_fullname'];
            $myOrders->shippingphone = $row['o_shipping_phone'];
            $myOrders->shippingaddress = $row['o_shipping_address'];
            $myOrders->shippingcountry = $row['o_shipping_country'];
            $myOrders->shippingregionid = $row['o_shipping_regionid'];
            $myOrders->shippingdistrict = $row['o_shipping_district'];
            $myOrders->shippinglat = $row['o_shipping_lat'];
            $myOrders->shippinglng = $row['o_shipping_lng'];
            $myOrders->shippingservice = $row['o_shipping_service'];
            $myOrders->shippingtrackingcode = $row['o_shipping_trackingcode'];
            $myOrders->ipaddress = $row['o_ipaddress'];
            $myOrders->paymentisdone = $row['o_payment_isdone'];
            $myOrders->paymentmethod = $row['o_payment_method'];
            $myOrders->deliverymethod = $row['o_delivery_method'];
            $myOrders->status = $row['o_status'];
            $myOrders->isgift = $row['o_isgift'];
            $myOrders->note = $row['o_note'];
            $myOrders->datecreated = $row['o_datecreated'];
            $myOrders->ordercrmdate = $row['o_ordercrmdate'];
            $myOrders->datemodified = $row['o_datemodified'];
            $myOrders->datecompleted = $row['o_datecompleted'];


            $outputList[] = $myOrders;
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
    public static function getOrderss($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if($formData['fuid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.u_id = '.(int)$formData['fuid'].' ';

        if($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_id = '.(int)$formData['fid'].' ';

        if(count($formData['fidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_id IN('.implode(',' , $formData['fidarr']).') ';

        if($formData['frelatedorderid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_related_orderid = '.(int)$formData['frelatedorderid'].' ';

        if($formData['forderidcrm'] >0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_orderidcrm= '.(int)$formData['forderidcrm'].' ';

        if($formData['fisorderidcrm'] ==1)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_orderidcrm= 0 ';

        if($formData['finvoiceid'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_invoiceid = "'.Helper::unspecialtext((string)$formData['finvoiceid']).'" ';

        if($formData['fpricesell'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_sell = '.(float)$formData['fpricesell'].' ';

        if($formData['fpriceship'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_ship = '.(float)$formData['fpriceship'].' ';

        if($formData['fpricediscount'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_discount = '.(float)$formData['fpricediscount'].' ';

        if($formData['fpricetax'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_tax = '.(float)$formData['fpricetax'].' ';

        if($formData['fpricehandling'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_handling = '.(float)$formData['fpricehandling'].' ';

        if($formData['fpricefinal'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_price_final = '.(float)$formData['fpricefinal'].' ';

        if($formData['fcoupon'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_coupon = "'.Helper::unspecialtext((string)$formData['fcoupon']).'" ';

        if($formData['fcouponvalue'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_couponvalue = '.(float)$formData['fcouponvalue'].' ';

        if($formData['fpromotionid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_promotionid = '.(int)$formData['fpromotionid'].' ';

        if($formData['fcontactemail'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_contactemail = "'.Helper::unspecialtext((string)$formData['fcontactemail']).'" ';

        if($formData['fbillingfullname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_billing_fullname = "'.Helper::unspecialtext((string)$formData['fbillingfullname']).'" ';

        if($formData['fbillingphone'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_billing_phone = "'.Helper::unspecialtext((string)$formData['fbillingphone']).'" ';

        if($formData['fbillingregionid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_billing_regionid = '.(int)$formData['fbillingregionid'].' ';

        if($formData['fbillingcountry'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_billing_country = "'.Helper::unspecialtext((string)$formData['fbillingcountry']).'" ';

        if($formData['fshippingfullname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_shipping_fullname = "'.Helper::unspecialtext((string)$formData['fshippingfullname']).'" ';

        if($formData['fshippingphone'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_shipping_phone = "'.Helper::unspecialtext((string)$formData['fshippingphone']).'" ';

        if($formData['fshippingregionid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_shipping_regionid = '.(int)$formData['fshippingregionid'].' ';

        if($formData['fdeliverymethod'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_delivery_method = '.(int)$formData['fdeliverymethod'].' ';

        if($formData['fshippingtrackingcode'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_shipping_trackingcode = "'.Helper::unspecialtext((string)$formData['fshippingtrackingcode']).'" ';

        if($formData['fstartdate'] > 0 && $formData['fenddate'] > 0 )
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_datecreated >= '.(int)$formData['fstartdate'].' AND o.o_datecreated <='.(int)$formData['fenddate'];

        if(is_array($formData['forderbytimesegment']) && count($formData['forderbytimesegment']) > 0)
        {
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'o.o_datecreated >= '.(int)($formData['forderbytimesegment'][0]).' AND o.o_datecreated <= '.(int)($formData['forderbytimesegment'][1]);
        }

        if(!empty($formData['isgroupbyuser']))
        {
			$whereString .= ' GROUP BY o.o_billing_fullname';
        }


        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'id')
            $orderString = 'o_id ' . $sorttype;
        else
            $orderString = 'o_id ' . $sorttype;

        if($countOnly)
            return self::countList($whereString);
        else
            return self::getList($whereString, $orderString, $limit);
    }


}