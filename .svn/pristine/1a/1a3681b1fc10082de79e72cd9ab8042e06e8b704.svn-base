<?php

/**
 * core/class.archivedorder.php
 *
 * File contains the class used for Archivedorder Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
class Core_Archivedorder extends Core_Object
{
    const STATUS_COMPLETE    = 1;
    const STATUS_NOTCOMPLETE = 0;
    const STATUS_DELETE      = 2;
    public $id = 0;
    public $saleorderid = "";
    public $ordertypeid = 0;
    public $deliverytypeid = 0;
    public $companyid = 0;
    public $customerid = 0;
    public $customername = "";
    public $customeraddress = "";
    public $customerphone = "";
    public $contactname = "";
    public $gender = 0;
    public $ageid = 0;
    public $deliveryaddress = "";
    public $provinceid = 0;
    public $districtid = 0;
    public $isreviewed = 0;
    public $payabletypeid = 0;
    public $currencyunitid = 0;
    public $currencyexchange = 0;
    public $totalquantity = 0;
    public $totalamount = 0;
    public $totaladvance = 0;
    public $shippingcost = 0;
    public $debt = 0;
    public $discountreasonid = 0;
    public $discount = 0;
    public $originatestoreid = 0;
    public $isoutproduct = 0;
    public $outputstoreid = 0;
    public $isincome = 0;
    public $isdeleted = 0;
    public $promotiondiscount = 0;
    public $vouchertypeid = 0;
    public $voucherconcern = "";
    public $deliveryuser = "";
    public $saleprogramid = 0;
    public $totalpaid = 0;
    public $issmspromotion = 0;
    public $deliverytime = 0;
    public $isdelivery = 0;
    public $deliveryupdatetime = 0;
    public $ismove = 0;
    public $iscomplete = 1;
    public $parentsaleorderid = "";
    public $thirdpartyvoucher = "";
    public $payabletime = 0;
    public $createdbyotherapps = 0;
    public $contactphone = "";
    public $customercarestatusid = 0;
    public $totalprepaid = 0;
    public $crmcustomerid = 0;
    public $datearchived = 0;
    public $datecreated = 0;
    public $originatestoreregionid = 0;
    public $outputstoreregionid = 0;
    public $inputuser = 0;
    public $datedeleted = 0;

    public function __construct($id = 0)
    {
        parent::__construct();

        if ($id > 0)
            $this->getData($id);
    }

    /**
     * Get the object data base on primary key
     * @param int $id : the primary key value for searching record.
     */
	public function getData($id)
	{
		$id = (int)$id;
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'archivedorder a
				WHERE a.o_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->id = $row['o_id'];
		$this->ordertypeid = $row['o_ordertypeid'];
		$this->saleorderid = $row['o_saleorderid'];
		$this->deliverytypeid = $row['o_deliverytypeid'];
		$this->datearchived = $row['o_datearchived'];
		$this->companyid = $row['o_companyid'];
		$this->customerid = $row['o_customerid'];
		$this->customername = $row['o_customername'];
		$this->customeraddress = $row['o_customeraddress'];
		$this->customerphone = $row['o_customerphone'];
		$this->contactname = $row['o_contactname'];
		$this->gender = $row['o_gender'];
		$this->ageid = $row['o_ageid'];
		$this->deliveryaddress = $row['o_deliveryaddress'];
		$this->provinceid = $row['o_provinceid'];
		$this->districtid = $row['o_districtid'];
		$this->isreviewed = $row['o_isreviewed'];
		$this->payabletypeid = $row['o_payabletypeid'];
		$this->currencyunitid = $row['o_currencyunitid'];
		$this->currencyexchange = $row['o_currencyexchange'];
		$this->totalquantity = $row['o_totalquantity'];
		$this->totalamount = $row['o_totalamount'];
		$this->totaladvance = $row['o_totaladvance'];
		$this->shippingcost = $row['o_shippingcost'];
		$this->debt = $row['o_debt'];
		$this->discountreasonid = $row['o_discountreasonid'];
		$this->discount = $row['o_discount'];
		$this->originatestoreid = $row['o_originatestoreid'];
		$this->isoutproduct = $row['o_isoutproduct'];
		$this->outputstoreid = $row['o_outputstoreid'];
		$this->isincome = $row['o_isincome'];
		$this->isdeleted = $row['o_isdeleted'];
		$this->promotiondiscount = $row['o_promotiondiscount'];
		$this->vouchertypeid = $row['o_vouchertypeid'];
		$this->voucherconcern = $row['o_voucherconcern'];
		$this->deliveryuser = $row['o_deliveryuser'];
		$this->saleprogramid = $row['o_saleprogramid'];
		$this->totalpaid = $row['o_totalpaid'];
		$this->issmspromotion = $row['o_issmspromotion'];
		$this->deliverytime = $row['o_deliverytime'];
		$this->isdelivery = $row['o_isdelivery'];
		$this->deliveryupdatetime = $row['o_deliveryupdatetime'];
		$this->ismove = $row['o_ismove'];
		$this->parentsaleorderid = $row['o_parentsaleorderid'];
		$this->thirdpartyvoucher = $row['o_thirdpartyvoucher'];
		$this->payabletime = $row['o_payabletime'];
		$this->createdbyotherapps = $row['o_createdbyotherapps'];
		$this->contactphone = $row['o_contactphone'];
		$this->customercarestatusid = $row['o_customercarestatusid'];
		$this->totalprepaid = $row['o_totalprepaid'];
		$this->crmcustomerid = $row['o_crmcustomerid'];
		$this->IsDetail = $row['o_IsDetail'];
		$this->originatestoreregionid = $row['o_originatestoreregionid'];
		$this->outputstoreregionid = $row['o_outputstoreregionid'];
		$this->createdate = $row['o_createdate'];
		$this->lat = $row['o_lat'];
		$this->lng = $row['o_lng'];
		$this->iscomplete = $row['o_iscomplete'];
		$this->taxid = $row['o_taxid'];
		$this->note = $row['o_note'];
		$this->revieweduser = $row['o_revieweduser'];
		$this->revieweddate = $row['o_revieweddate'];
		$this->outproductdate = $row['o_outproductdate'];
		$this->inputtime = $row['o_inputtime'];
		$this->userdeleted = $row['o_userdeleted'];
		$this->datedelete = $row['o_datedelete'];
		$this->contentdeleted = $row['o_contentdeleted'];
		$this->staffuser = $row['o_staffuser'];
		$this->printtimes = $row['o_printtimes'];
		$this->deliveryupdateuser = $row['o_deliveryupdateuser'];
		$this->movetime = $row['o_movetime'];
		$this->outputuser = $row['o_outputuser'];
		$this->deliveryuserupdatetime = $row['o_deliveryuserupdatetime'];
		$this->deliveryuserupdateuser = $row['o_deliveryuserupdateuser'];
		$this->customercarestausupdatetime = $row['o_customercarestausupdatetime'];
		$this->customercarestatusupdateuser = $row['o_customercarestatusupdateuser'];
		$this->contactid = $row['o_contactid'];
		$this->customercode = $row['o_customercode'];
		$this->birthday = $row['o_birthday'];
		$this->customeridcard = $row['o_customeridcard'];
		$this->createdapplicationid = $row['o_createdapplicationid'];
		$this->iscreatefromoutputreceipt = $row['o_iscreatefromoutputreceipt'];
		$this->iscreatefromsimprocessreq = $row['o_iscreatefromsimprocessreq'];
		$this->bankvoucher = $row['o_bankvoucher'];
		$this->processuser = $row['o_processuser'];
		$this->contractid = $row['o_contractid'];
		$this->isinputimeicomplete = $row['o_isinputimeicomplete'];
		$this->organizationname = $row['o_organizationname'];
		$this->positionname = $row['o_positionname'];
		$this->currentreviewlevelid = $row['o_currentreviewlevelid'];
		$this->mspromotionlevelidlist = $row['o_mspromotionlevelidlist'];
		$this->crmcustomercardcode = $row['o_crmcustomercardcode'];
		$this->iswarningduplicatesaleorder = $row['o_iswarningduplicatesaleorder'];
		$this->duplicatesaleorderid = $row['o_duplicatesaleorderid'];
		$this->pointpaid = $row['o_pointpaid'];
		$this->inputuser = $row['o_inputuser'];
		$this->datedelete = $row['o_datedelete'];

	}

    public static function statTotalOrder($dateRangeStart)
    {

        global $db;
        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'archivedorder
	    WHERE o_createdate >= ?';
        return $db->query($sql, array($dateRangeStart))->fetchColumn(0);

    }

    public static function statTotalAmount($dateRangeStart)
    {

        global $db;
        $sql = 'SELECT SUM(o_totalpaid) as tong FROM ' . TABLE_PREFIX . 'archivedorder
	    WHERE o_createdate >= ?';
        return $db->query($sql, array($dateRangeStart))->fetchColumn(0);

    }

    public static function updateIsDetail($id)
    {

        global $db;
        $sql = 'UPDATE lit_archivedorder SET o_IsDetail="1" WHERE o_id = ?';
        return $db->query($sql, array($id));

    }

    public static function SaleorderFromDetail($id)
    {
        global $db;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'archivedorder
				WHERE
			    o_saleorderid = ?
				';
        $rowCount = $db->query($sql, array($id))->fetch();

        return $rowCount;
    }

    public static function syncregion($sql)
    {
        global $db;
        $rowCount = $db->query($sql, array())->rowCount();
        return $rowCount;
    }

    public static function getDataSync()
    {
        $result = array();
        global $db;
        $sql = 'SELECT MAX(o_id) FROM ' . TABLE_PREFIX . 'archivedorder ';
        $row = $db->query($sql)->fetchColumn(0);
        $sql2 = 'SELECT o_saleorderid FROM ' . TABLE_PREFIX . 'archivedorder where o_id="' . $row . '"';
        $rs = $db->query($sql2)->fetch();
        $result = $rs['o_saleorderid'];
        return $result;
    }

    /**
     * Get the record in the table with paginating and filtering
     *
     * @param string $where the WHERE condition in SQL string
     * @param string $order the ORDER in SQL string
     * @param string $limit the LIMIT in SQL string
     */
    public static function getOrderByBegin($begin, $limit)
    {
        global $db;
        $sql = "SELECT * FROM " . TABLE_PREFIX . "archivedorder a LIMIT $begin,$limit";
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $rs[] = $row;
        }
        return $rs;
    }

    public static function getOrderByID($id, $begin, $limit)
    {
        global $db;
        $sql = "SELECT * FROM " . TABLE_PREFIX . "archivedorder a where a.o_id >='$id' order by o_id LIMIT $begin,$limit";
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $rs[] = $row;
        }
        return $rs;
    }

    public static function DistinctStore()
    {
        global $db;
        $sql = "SELECT DISTINCT a.o_outputstoreid FROM " . TABLE_PREFIX . "archivedorder a";
        return $db->query($sql)->fetchAll();
    }

    public static function getDataSyncByID()
    {
        global $db;
        $sql = 'SELECT MAX(o_id) FROM ' . TABLE_PREFIX . 'archivedorder ';
        $row = $db->query($sql)->fetchColumn(0);
        return $row;
    }
	public static function getListSalorder($count=false,$limit ='')
    {
        global $db;
	    if($count)
	    {
		    $sql = 'SELECT count(*) FROM ' . TABLE_PREFIX . 'archivedorder ';
		    $rs = $db->query($sql)->fetchColumn(0);
	    }
		else
		{
			$rs = array();
			$sql = 'SELECT o_saleorderid FROM ' . TABLE_PREFIX . 'archivedorder ORDER BY o_id limit '.$limit;
			$row = $db->query($sql);
			while($tmp = $row->fetch())
			{
				$rs[]=$tmp;
			}
		}


        return $rs;
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
    public static function getArchivedorders($formData, $sortby = 'id', $sorttype = 'ASC', $limit = '', $countOnly = false, $stat = false)
    {
        $whereString = '';
        $joinString = '';

        if ($formData['fstoreregion'] > 0) {
            $joinString = ' INNER JOIN ' . TABLE_PREFIX . 'store b ON ' . TABLE_PREFIX . 'store.s_id = a.o_outputstoreid ';
            $whereString .= ($whereString != '' ? ' AND ' : '') . TABLE_PREFIX . 'store.s_region = ' . (int)$formData['fstoreregion'] . ' ';
        }

        if ($formData['fid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_id = ' . (int)$formData['fid'] . ' ';

        if ($formData['fsaleorderid'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_saleorderid = "' . Helper::unspecialtext((string)$formData['fsaleorderid']) . '" ';

        if ($formData['fordertypeid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_ordertypeid = ' . (int)$formData['fordertypeid'] . ' ';

        if ($formData['fdeliverytypeid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliverytypeid = ' . (int)$formData['fdeliverytypeid'] . ' ';

        if ($formData['fcompanyid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_companyid = ' . (int)$formData['fcompanyid'] . ' ';

        if ($formData['fcustomerid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customerid = ' . (int)$formData['fcustomerid'] . ' ';

        if ($formData['fcustomername'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customername = "' . Helper::unspecialtext((string)$formData['fcustomername']) . '" ';

        if ($formData['fcustomeraddress'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customeraddress = "' . Helper::unspecialtext((string)$formData['fcustomeraddress']) . '" ';

        if ($formData['fcustomerphone'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customerphone = "' . Helper::unspecialtext((string)$formData['fcustomerphone']) . '" ';

        if ($formData['fcontactname'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_contactname = "' . Helper::unspecialtext((string)$formData['fcontactname']) . '" ';

        if ($formData['fgender'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_gender = ' . (int)$formData['fgender'] . ' ';

        if ($formData['fageid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_ageid = ' . (int)$formData['fageid'] . ' ';

        if ($formData['fdeliveryaddress'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliveryaddress = "' . Helper::unspecialtext((string)$formData['fdeliveryaddress']) . '" ';

        if ($formData['fprovinceid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_provinceid = ' . (int)$formData['fprovinceid'] . ' ';

        if ($formData['fdistrictid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_districtid = ' . (int)$formData['fdistrictid'] . ' ';

        if ($formData['fisreviewed'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_isreviewed = ' . (int)$formData['fisreviewed'] . ' ';

        if ($formData['fpayabletypeid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_payabletypeid = ' . (int)$formData['fpayabletypeid'] . ' ';

        if ($formData['fcurrencyunitid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_currencyunitid = ' . (int)$formData['fcurrencyunitid'] . ' ';

        if ($formData['fcurrencyexchange'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_currencyexchange = ' . (int)$formData['fcurrencyexchange'] . ' ';

        if ($formData['ftotalquantity'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_totalquantity = ' . (int)$formData['ftotalquantity'] . ' ';

        if ($formData['ftotalamount'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_totalamount = ' . (float)$formData['ftotalamount'] . ' ';

        if ($formData['ftotaladvance'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_totaladvance = ' . (int)$formData['ftotaladvance'] . ' ';

        if ($formData['fshippingcost'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_shippingcost = ' . (int)$formData['fshippingcost'] . ' ';

        if ($formData['fdebt'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_debt = ' . (float)$formData['fdebt'] . ' ';

        if ($formData['fdiscountreasonid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_discountreasonid = ' . (int)$formData['fdiscountreasonid'] . ' ';

        if ($formData['fdiscount'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_discount = ' . (float)$formData['fdiscount'] . ' ';

        if ($formData['foriginatestoreid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_originatestoreid = ' . (int)$formData['foriginatestoreid'] . ' ';

        if ($formData['fisoutproduct'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_isoutproduct = ' . (int)$formData['fisoutproduct'] . ' ';

        if ($formData['foutputstoreid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_outputstoreid = ' . (int)$formData['foutputstoreid'] . ' ';

        if ($formData['fisincome'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_isincome = ' . (int)$formData['fisincome'] . ' ';

        if ($formData['fisdeleted'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_isdeleted = ' . (int)$formData['fisdeleted'] . ' ';

        if ($formData['fpromotiondiscount'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_promotiondiscount = ' . (int)$formData['fpromotiondiscount'] . ' ';

        if ($formData['fvouchertypeid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_vouchertypeid = ' . (int)$formData['fvouchertypeid'] . ' ';

        if ($formData['fvoucherconcern'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_voucherconcern = "' . Helper::unspecialtext((string)$formData['fvoucherconcern']) . '" ';

        if ($formData['fdeliveryuser'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliveryuser = "' . Helper::unspecialtext((string)$formData['fdeliveryuser']) . '" ';

        if ($formData['fsaleprogramid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_saleprogramid = ' . (int)$formData['fsaleprogramid'] . ' ';

        if ($formData['ftotalpaid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_totalpaid = ' . (float)$formData['ftotalpaid'] . ' ';

        if ($formData['fissmspromotion'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_issmspromotion = ' . (int)$formData['fissmspromotion'] . ' ';

        if ($formData['fdeliverytime'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliverytime = ' . (int)$formData['fdeliverytime'] . ' ';

        if ($formData['fisdelivery'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_isdelivery = ' . (int)$formData['fisdelivery'] . ' ';

        if ($formData['fdeliveryupdatetime'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliveryupdatetime = ' . (int)$formData['fdeliveryupdatetime'] . ' ';

        if ($formData['fismove'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_ismove = ' . (int)$formData['fismove'] . ' ';

        if ($formData['fparentsaleorderid'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_parentsaleorderid = "' . Helper::unspecialtext((string)$formData['fparentsaleorderid']) . '" ';

        if ($formData['fthirdpartyvoucher'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_thirdpartyvoucher = "' . Helper::unspecialtext((string)$formData['fthirdpartyvoucher']) . '" ';

        if ($formData['fpayabletime'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_payabletime = ' . (int)$formData['fpayabletime'] . ' ';

        if ($formData['fcreatedbyotherapps'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_createdbyotherapps = ' . (int)$formData['fcreatedbyotherapps'] . ' ';

        if ($formData['fcontactphone'] != '')
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_contactphone = "' . Helper::unspecialtext((string)$formData['fcontactphone']) . '" ';

        if ($formData['fcustomercarestatusid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customercarestatusid = ' . (int)$formData['fcustomercarestatusid'] . ' ';

        if ($formData['ftotalprepaid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_totalprepaid = ' . (float)$formData['ftotalprepaid'] . ' ';

        if ($formData['fcrmcustomerid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_crmcustomerid = ' . (int)$formData['fcrmcustomerid'] . ' ';

        if ($formData['fdatearchived'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_datearchived = ' . (int)$formData['fdatearchived'] . ' ';

        if ($formData['fcreatedate'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_createdate >= ' . (int)$formData['fcreatedate'] . ' ';

        if ($formData['ffromdate'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_createdate >= ' . (int)$formData['ffromdate'] . ' ';

        if ($formData['ftodate'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_createdate <= ' . (int)$formData['ftodate'] . ' ';

        if ($formData['fisdetail'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_IsDetail = ' . (int)$formData['fisdetail'] . ' ';

        if (isset($formData['fiscomplete']))
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_iscomplete = ' . (int)$formData['fiscomplete'] . ' ';

        if ($formData['foriginatestoreregionid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_originatestoreregionid = ' . (int)$formData['foriginatestoreregionid'] . ' ';

        if ($formData['foutputstoreregionid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_outputstoreregionid = ' . (int)$formData['foutputstoreregionid'] . ' ';


        if (strlen($formData['fkeywordFilter']) > 0) {
            $formData['fkeywordFilter'] = Helper::unspecialtext($formData['fkeywordFilter']);

            if ($formData['fsearchKeywordIn'] == 'saleorderid')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_saleorderid LIKE \'%' . $formData['fkeywordFilter'] . '%\'';
            elseif ($formData['fsearchKeywordIn'] == 'customername')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customername LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'customeraddress')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customeraddress LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'customerphone')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_customerphone LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'contactname')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_contactname LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'deliveryaddress')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliveryaddress LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'voucherconcern')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_voucherconcern LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'deliveryuser')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_deliveryuser LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'parentsaleorderid')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_parentsaleorderid LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'thirdpartyvoucher')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_thirdpartyvoucher LIKE \'%' . $formData['fkeywordFilter'] . '%\''; elseif ($formData['fsearchKeywordIn'] == 'contactphone')
                $whereString .= ($whereString != '' ? ' AND ' : '') . 'a.o_contactphone LIKE \'%' . $formData['fkeywordFilter'] . '%\''; else
                $whereString .= ($whereString != '' ? ' AND ' : '') . '( (a.o_saleorderid LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_customername LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_customeraddress LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_customerphone LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_contactname LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_deliveryaddress LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_voucherconcern LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_deliveryuser LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_parentsaleorderid LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_thirdpartyvoucher LIKE \'%' . $formData['fkeywordFilter'] . '%\') OR (a.o_contactphone LIKE \'%' . $formData['fkeywordFilter'] . '%\') )';
        }

        //checking sort by & sort type
        if ($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if ($sortby == 'id')
            $orderString = 'o_id ' . $sorttype;
        elseif ($sortby == 'saleorderid')
            $orderString = 'o_saleorderid ' . $sorttype; elseif ($sortby == 'ordertypeid')
            $orderString = 'o_ordertypeid ' . $sorttype; elseif ($sortby == 'deliverytypeid')
            $orderString = 'o_deliverytypeid ' . $sorttype; elseif ($sortby == 'companyid')
            $orderString = 'o_companyid ' . $sorttype; elseif ($sortby == 'customerid')
            $orderString = 'o_customerid ' . $sorttype; elseif ($sortby == 'customername')
            $orderString = 'o_customername ' . $sorttype; elseif ($sortby == 'customeraddress')
            $orderString = 'o_customeraddress ' . $sorttype; elseif ($sortby == 'customerphone')
            $orderString = 'o_customerphone ' . $sorttype; elseif ($sortby == 'contactname')
            $orderString = 'o_contactname ' . $sorttype; elseif ($sortby == 'gender')
            $orderString = 'o_gender ' . $sorttype; elseif ($sortby == 'ageid')
            $orderString = 'o_ageid ' . $sorttype; elseif ($sortby == 'deliveryaddress')
            $orderString = 'o_deliveryaddress ' . $sorttype; elseif ($sortby == 'provinceid')
            $orderString = 'o_provinceid ' . $sorttype; elseif ($sortby == 'districtid')
            $orderString = 'o_districtid ' . $sorttype; elseif ($sortby == 'isreviewed')
            $orderString = 'o_isreviewed ' . $sorttype; elseif ($sortby == 'payabletypeid')
            $orderString = 'o_payabletypeid ' . $sorttype; elseif ($sortby == 'currencyunitid')
            $orderString = 'o_currencyunitid ' . $sorttype; elseif ($sortby == 'currencyexchange')
            $orderString = 'o_currencyexchange ' . $sorttype; elseif ($sortby == 'totalquantity')
            $orderString = 'o_totalquantity ' . $sorttype; elseif ($sortby == 'totalamount')
            $orderString = 'o_totalamount ' . $sorttype; elseif ($sortby == 'totaladvance')
            $orderString = 'o_totaladvance ' . $sorttype; elseif ($sortby == 'shippingcost')
            $orderString = 'o_shippingcost ' . $sorttype; elseif ($sortby == 'debt')
            $orderString = 'o_debt ' . $sorttype; elseif ($sortby == 'discountreasonid')
            $orderString = 'o_discountreasonid ' . $sorttype; elseif ($sortby == 'discount')
            $orderString = 'o_discount ' . $sorttype; elseif ($sortby == 'originatestoreid')
            $orderString = 'o_originatestoreid ' . $sorttype; elseif ($sortby == 'isoutproduct')
            $orderString = 'o_isoutproduct ' . $sorttype; elseif ($sortby == 'outputstoreid')
            $orderString = 'o_outputstoreid ' . $sorttype; elseif ($sortby == 'isincome')
            $orderString = 'o_isincome ' . $sorttype; elseif ($sortby == 'isdeleted')
            $orderString = 'o_isdeleted ' . $sorttype; elseif ($sortby == 'promotiondiscount')
            $orderString = 'o_promotiondiscount ' . $sorttype; elseif ($sortby == 'vouchertypeid')
            $orderString = 'o_vouchertypeid ' . $sorttype; elseif ($sortby == 'voucherconcern')
            $orderString = 'o_voucherconcern ' . $sorttype; elseif ($sortby == 'deliveryuser')
            $orderString = 'o_deliveryuser ' . $sorttype; elseif ($sortby == 'saleprogramid')
            $orderString = 'o_saleprogramid ' . $sorttype; elseif ($sortby == 'totalpaid')
            $orderString = 'o_totalpaid ' . $sorttype; elseif ($sortby == 'issmspromotion')
            $orderString = 'o_issmspromotion ' . $sorttype; elseif ($sortby == 'deliverytime')
            $orderString = 'o_deliverytime ' . $sorttype; elseif ($sortby == 'isdelivery')
            $orderString = 'o_isdelivery ' . $sorttype; elseif ($sortby == 'deliveryupdatetime')
            $orderString = 'o_deliveryupdatetime ' . $sorttype; elseif ($sortby == 'ismove')
            $orderString = 'o_ismove ' . $sorttype; elseif ($sortby == 'parentsaleorderid')
            $orderString = 'o_parentsaleorderid ' . $sorttype; elseif ($sortby == 'thirdpartyvoucher')
            $orderString = 'o_thirdpartyvoucher ' . $sorttype; elseif ($sortby == 'payabletime')
            $orderString = 'o_payabletime ' . $sorttype; elseif ($sortby == 'createdbyotherapps')
            $orderString = 'o_createdbyotherapps ' . $sorttype; elseif ($sortby == 'contactphone')
            $orderString = 'o_contactphone ' . $sorttype; elseif ($sortby == 'customercarestatusid')
            $orderString = 'o_customercarestatusid ' . $sorttype; elseif ($sortby == 'totalprepaid')
            $orderString = 'o_totalprepaid ' . $sorttype; elseif ($sortby == 'crmcustomerid')
            $orderString = 'o_crmcustomerid ' . $sorttype; elseif ($sortby == 'datearchived')
            $orderString = 'o_datearchived ' . $sorttype; elseif ($sortby == 'createdate')
            $orderString = 'o_createdate ' . $sorttype; else
            $orderString = 'o_id ' . $sorttype;

        if ($stat) {
            return self::CountSumList($whereString);
        }

        if ($countOnly)
            return self::countList($whereString, $joinString);
        else
            return self::getList($whereString, $orderString, $limit, $joinString);
    }

    public static function CountSumList($where)
    {
        global $db;

        $sql = 'SELECT SUM(a.o_totalpaid) FROM ' . TABLE_PREFIX . 'archivedorder a ';

        if ($where != '')
            $sql .= ' WHERE ' . $where;
        return $db->query($sql)->fetchColumn(0);
    }

    /**
     * Count the record in the table base on condition in $where
     *
     * @param string $where: the WHERE condition in SQL string.
     */
    public static function countList($where, $joinString = '')
    {
        global $db;

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'archivedorder a ';
        if ($joinString != '')
            $sql .= $joinString;
        if ($where != '')
            $sql .= ' WHERE ' . $where;
        return $db->query($sql)->fetchColumn(0);
    }

	public static function getList($where, $order, $limit = '')
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'archivedorder a';

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
			$myArchivedorder = new Core_Archivedorder();

			$myArchivedorder->id = $row['o_id'];
			$myArchivedorder->ordertypeid = $row['o_ordertypeid'];
			$myArchivedorder->saleorderid = $row['o_saleorderid'];
			$myArchivedorder->deliverytypeid = $row['o_deliverytypeid'];
			$myArchivedorder->datearchived = $row['o_datearchived'];
			$myArchivedorder->companyid = $row['o_companyid'];
			$myArchivedorder->customerid = $row['o_customerid'];
			$myArchivedorder->customername = $row['o_customername'];
			$myArchivedorder->customeraddress = $row['o_customeraddress'];
			$myArchivedorder->customerphone = $row['o_customerphone'];
			$myArchivedorder->contactname = $row['o_contactname'];
			$myArchivedorder->gender = $row['o_gender'];
			$myArchivedorder->ageid = $row['o_ageid'];
			$myArchivedorder->deliveryaddress = $row['o_deliveryaddress'];
			$myArchivedorder->provinceid = $row['o_provinceid'];
			$myArchivedorder->districtid = $row['o_districtid'];
			$myArchivedorder->isreviewed = $row['o_isreviewed'];
			$myArchivedorder->payabletypeid = $row['o_payabletypeid'];
			$myArchivedorder->currencyunitid = $row['o_currencyunitid'];
			$myArchivedorder->currencyexchange = $row['o_currencyexchange'];
			$myArchivedorder->totalquantity = $row['o_totalquantity'];
			$myArchivedorder->totalamount = $row['o_totalamount'];
			$myArchivedorder->totaladvance = $row['o_totaladvance'];
			$myArchivedorder->shippingcost = $row['o_shippingcost'];
			$myArchivedorder->debt = $row['o_debt'];
			$myArchivedorder->discountreasonid = $row['o_discountreasonid'];
			$myArchivedorder->discount = $row['o_discount'];
			$myArchivedorder->originatestoreid = $row['o_originatestoreid'];
			$myArchivedorder->isoutproduct = $row['o_isoutproduct'];
			$myArchivedorder->outputstoreid = $row['o_outputstoreid'];
			$myArchivedorder->isincome = $row['o_isincome'];
			$myArchivedorder->isdeleted = $row['o_isdeleted'];
			$myArchivedorder->promotiondiscount = $row['o_promotiondiscount'];
			$myArchivedorder->vouchertypeid = $row['o_vouchertypeid'];
			$myArchivedorder->voucherconcern = $row['o_voucherconcern'];
			$myArchivedorder->deliveryuser = $row['o_deliveryuser'];
			$myArchivedorder->saleprogramid = $row['o_saleprogramid'];
			$myArchivedorder->totalpaid = $row['o_totalpaid'];
			$myArchivedorder->issmspromotion = $row['o_issmspromotion'];
			$myArchivedorder->deliverytime = $row['o_deliverytime'];
			$myArchivedorder->isdelivery = $row['o_isdelivery'];
			$myArchivedorder->deliveryupdatetime = $row['o_deliveryupdatetime'];
			$myArchivedorder->ismove = $row['o_ismove'];
			$myArchivedorder->parentsaleorderid = $row['o_parentsaleorderid'];
			$myArchivedorder->thirdpartyvoucher = $row['o_thirdpartyvoucher'];
			$myArchivedorder->payabletime = $row['o_payabletime'];
			$myArchivedorder->createdbyotherapps = $row['o_createdbyotherapps'];
			$myArchivedorder->contactphone = $row['o_contactphone'];
			$myArchivedorder->customercarestatusid = $row['o_customercarestatusid'];
			$myArchivedorder->totalprepaid = $row['o_totalprepaid'];
			$myArchivedorder->crmcustomerid = $row['o_crmcustomerid'];
			$myArchivedorder->IsDetail = $row['o_IsDetail'];
			$myArchivedorder->originatestoreregionid = $row['o_originatestoreregionid'];
			$myArchivedorder->outputstoreregionid = $row['o_outputstoreregionid'];
			$myArchivedorder->createdate = $row['o_createdate'];
			$myArchivedorder->lat = $row['o_lat'];
			$myArchivedorder->lng = $row['o_lng'];
			$myArchivedorder->iscomplete = $row['o_iscomplete'];
			$myArchivedorder->taxid = $row['o_taxid'];
			$myArchivedorder->note = $row['o_note'];
			$myArchivedorder->revieweduser = $row['o_revieweduser'];
			$myArchivedorder->revieweddate = $row['o_revieweddate'];
			$myArchivedorder->outproductdate = $row['o_outproductdate'];
			$myArchivedorder->inputtime = $row['o_inputtime'];
			$myArchivedorder->userdeleted = $row['o_userdeleted'];
			$myArchivedorder->datedelete = $row['o_datedelete'];
			$myArchivedorder->contentdeleted = $row['o_contentdeleted'];
			$myArchivedorder->staffuser = $row['o_staffuser'];
			$myArchivedorder->printtimes = $row['o_printtimes'];
			$myArchivedorder->deliveryupdateuser = $row['o_deliveryupdateuser'];
			$myArchivedorder->movetime = $row['o_movetime'];
			$myArchivedorder->outputuser = $row['o_outputuser'];
			$myArchivedorder->deliveryuserupdatetime = $row['o_deliveryuserupdatetime'];
			$myArchivedorder->deliveryuserupdateuser = $row['o_deliveryuserupdateuser'];
			$myArchivedorder->customercarestausupdatetime = $row['o_customercarestausupdatetime'];
			$myArchivedorder->customercarestatusupdateuser = $row['o_customercarestatusupdateuser'];
			$myArchivedorder->contactid = $row['o_contactid'];
			$myArchivedorder->customercode = $row['o_customercode'];
			$myArchivedorder->birthday = $row['o_birthday'];
			$myArchivedorder->customeridcard = $row['o_customeridcard'];
			$myArchivedorder->createdapplicationid = $row['o_createdapplicationid'];
			$myArchivedorder->iscreatefromoutputreceipt = $row['o_iscreatefromoutputreceipt'];
			$myArchivedorder->iscreatefromsimprocessreq = $row['o_iscreatefromsimprocessreq'];
			$myArchivedorder->bankvoucher = $row['o_bankvoucher'];
			$myArchivedorder->processuser = $row['o_processuser'];
			$myArchivedorder->contractid = $row['o_contractid'];
			$myArchivedorder->isinputimeicomplete = $row['o_isinputimeicomplete'];
			$myArchivedorder->organizationname = $row['o_organizationname'];
			$myArchivedorder->positionname = $row['o_positionname'];
			$myArchivedorder->currentreviewlevelid = $row['o_currentreviewlevelid'];
			$myArchivedorder->mspromotionlevelidlist = $row['o_mspromotionlevelidlist'];
			$myArchivedorder->crmcustomercardcode = $row['o_crmcustomercardcode'];
			$myArchivedorder->iswarningduplicatesaleorder = $row['o_iswarningduplicatesaleorder'];
			$myArchivedorder->duplicatesaleorderid = $row['o_duplicatesaleorderid'];
			$myArchivedorder->inputuser = $row['o_inputuser'];
			$myArchivedorder->datedeleted = $row['o_datedeleted'];
			$myArchivedorder->pointpaid = $row['o_pointpaid'];


			$outputList[] = $myArchivedorder;
		}

		return $outputList;
	}

    public static function countMultiID($strid)
    {
        global $db;
        $sql = "SELECT
                    distinct o_saleorderid,o_iscomplete
                    FROM
                    lit_archivedorder
                    WHERE
                    lit_archivedorder.o_saleorderid in (" . $strid . ")
                    GROUP BY
                    lit_archivedorder.o_saleorderid";
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $rs[] = $row;
        }
        return $rs;
    }

    public static function updateIsComplete($strid, $complete)
    {
        global $db;
        $date = time();
        $sql = 'UPDATE `lit_archivedorder` SET `o_iscomplete`="' . $complete . '" , `o_datecheckcomplete`="' . $date . '"  WHERE o_saleorderid ="' . $strid . '"';
        return $db->query($sql);
    }

    public static function updateMultiIsComplete($strid, $complete)
    {
        global $db;
        $date = time();
        $sql = 'UPDATE `lit_archivedorder` SET `o_iscomplete`="' . $complete . '" , `o_datecheckcomplete`="' . $date . '"  WHERE o_saleorderid in (' . $strid . ')';
        return $db->query($sql);
    }

    public static function getlistNotComplete($limit = '', $count = false, $condition = array())
    {
        global $db;
        $str = '';
        if (!empty($condition)) {
            $str .= ' AND o_createdate >="' . $condition['from'] . '" ';
        }
        if (!$count) {
            $limit = $limit != '' ? ' LIMIT ' . $limit : '';
            $sql = 'SELECT * FROM `lit_archivedorder` WHERE `o_iscomplete`="0" ' . $str . $limit;
            $stmt = $db->query($sql);
            while ($row = $stmt->fetch()) {
                $rs[] = $row;
            }
            return $rs;
        } else {
            $sql = 'SELECT count(*) FROM `lit_archivedorder` WHERE `o_iscomplete`="0" ' . $str;
            return $stmt = $db->query($sql)->fetchColumn(0);
        }

    }

    public static function getre()
    {
        global $db;
        $sql = 'SELECT * FROM `lit_recomment` ';
        $stmt = $db->query($sql);
        while ($row = $stmt->fetch()) {
            $rs[] = $row;
        }
        return $rs;
    }

    public static function insertbackupnotComplete($id, $complete)
    {
        global $db;
        $date = time();
        $sql = 'INSERT INTO `lit_tmpnotcomplete`(`o_sid`, `o_complete`,`datecreate`) VALUES (
                "' . $id . '",
                "' . $complete . '",
                "' . $date . '"
                )';

        return $db->query($sql);
    }

    public static function deletebackupnotComplete()
    {
        global $db;
        $sql = 'truncate lit_tmpnotcomplete';
        return $db->query($sql);
    }

    public static function updatenotComplete()
    {
        global $db;
        $sql = 'UPDATE lit_archivedorder t1, lit_tmpnotcomplete t2
                    SET t1.o_iscomplete = t2.o_complete
                    WHERE t1.o_saleorderid = t2.o_sid';
        return $db->query($sql);
    }
    public static  function  getStaticPhone()
    {
        global $db;
        $sql = 'SELECT
                lit_archivedorder.o_saleorderid,
                lit_archivedorder.o_customerphone,
                COUNT(o_saleorderid) as dem
                FROM
                lit_archivedorder_detail
                INNER JOIN lit_archivedorder ON lit_archivedorder.o_id = lit_archivedorder_detail.o_orderid
                GROUP BY
                lit_archivedorder.o_customerphone
                HAVING dem > 1';
        $stmt = $db->query($sql);
        $output = array();
        while ($row = $stmt->fetch()) {
            $output[] = $row;
        }
        return $output;
    }
	// get data samcustomer
    public static function getAJoinADByProduct( $condittion = array(), $limit = '', $count)
    {
        global $db;
        $limit = $limit!=''? ' LIMIT '.$limit : '' ;

	    $con = " WHERE lit_archivedorder.o_customerphone != '' AND  lit_archivedorder_detail.p_id != 0 ";
        if(!empty($condittion))
        {
            foreach($condittion as $k=>$v)
            {
	            foreach ($v as $cot=>$giatri) {
		            $con .=  " AND ".$k.'.'.$cot."= '".$giatri."'";
	            }
            }
        }

        if ($count) {
           $sql = 'SELECT
                count(*)
                FROM
                lit_archivedorder
                INNER JOIN lit_archivedorder_detail ON lit_archivedorder.o_id = lit_archivedorder_detail.o_orderid
                '. $con . $limit;
            $rs = $db->query($sql)->fetchColumn(0);
	        return (int)$rs;

        } else {
            $sql = 'SELECT
                lit_archivedorder.o_id,
                lit_archivedorder.o_customerphone,
                lit_archivedorder.o_contactphone,
                lit_archivedorder_detail.p_id
                FROM
                lit_archivedorder
                INNER JOIN lit_archivedorder_detail ON lit_archivedorder.o_id = lit_archivedorder_detail.o_orderid
                '. $con . $limit;

            $stmt = $db->query($sql);
            $output = array();
            while ($row = $stmt->fetch()) {
                $output[] = $row;
            }
            return $output;
        }

    }



    /**
     * Insert object data to database
     * @return int The inserted record primary key
     */
	public function addData()
	{
		$this->datearchived = time();
		$this->datecreated  = time();
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'archivedorder (
					o_ordertypeid,
					o_saleorderid,
					o_deliverytypeid,
					o_datearchived,
					o_companyid,
					o_customerid,
					o_customername,
					o_customeraddress,
					o_customerphone,
					o_contactname,
					o_gender,
					o_ageid,
					o_deliveryaddress,
					o_provinceid,
					o_districtid,
					o_isreviewed,
					o_payabletypeid,
					o_currencyunitid,
					o_currencyexchange,
					o_totalquantity,
					o_totalamount,
					o_totaladvance,
					o_shippingcost,
					o_debt,
					o_discountreasonid,
					o_discount,
					o_originatestoreid,
					o_isoutproduct,
					o_outputstoreid,
					o_isincome,
					o_isdeleted,
					o_promotiondiscount,
					o_vouchertypeid,
					o_voucherconcern,
					o_deliveryuser,
					o_saleprogramid,
					o_totalpaid,
					o_issmspromotion,
					o_deliverytime,
					o_isdelivery,
					o_deliveryupdatetime,
					o_ismove,
					o_parentsaleorderid,
					o_thirdpartyvoucher,
					o_payabletime,
					o_createdbyotherapps,
					o_contactphone,
					o_customercarestatusid,
					o_totalprepaid,
					o_crmcustomerid,
					o_IsDetail,
					o_originatestoreregionid,
					o_outputstoreregionid,
					o_createdate,
					o_lat,
					o_lng,
					o_iscomplete,
					o_taxid,
					o_note,
					o_revieweduser,
					o_revieweddate,
					o_outproductdate,
					o_inputtime,
					o_userdeleted,
					o_datedelete,
					o_contentdeleted,
					o_staffuser,
					o_printtimes,
					o_deliveryupdateuser,
					o_movetime,
					o_outputuser,
					o_deliveryuserupdatetime,
					o_deliveryuserupdateuser,
					o_customercarestatusupdatetime,
					o_customercarestatusupdateuser,
					o_contactid,
					o_customercode,
					o_birthday,
					o_customeridcard,
					o_createdapplicationid,
					o_iscreatefromoutputreceipt,
					o_iscreatefromsimprocessreq,
					o_bankvoucher,
					o_processuser,
					o_contractid,
					o_isinputimeicomplete,
					o_organizationname,
					o_positionname,
					o_currentreviewlevelid,
					o_mspromotionlevelidlist,
					o_crmcustomercardcode,
					o_iswarningduplicatesaleorder,
					o_duplicatesaleorderid,
					o_pointpaid,
					o_inputuser,
					o_datedeleted
					)
		        VALUES(?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
		                                        (int)$this->ordertypeid,
		                                        (string)$this->saleorderid,
		                                        (int)$this->deliverytypeid,
		                                        (int)$this->datearchived,
		                                        (int)$this->companyid,
		                                        (int)$this->customerid,
		                                        (string)$this->customername,
		                                        (string)$this->customeraddress,
		                                        (string)$this->customerphone,
		                                        (string)$this->contactname,
		                                        (int)$this->gender,
		                                        (int)$this->ageid,
		                                        (string)$this->deliveryaddress,
		                                        (int)$this->provinceid,
		                                        (int)$this->districtid,
		                                        (int)$this->isreviewed,
		                                        (int)$this->payabletypeid,
		                                        (int)$this->currencyunitid,
		                                        (int)$this->currencyexchange,
		                                        (int)$this->totalquantity,
		                                        (float)$this->totalamount,
		                                        (int)$this->totaladvance,
		                                        (int)$this->shippingcost,
		                                        (float)$this->debt,
		                                        (int)$this->discountreasonid,
		                                        (float)$this->discount,
		                                        (int)$this->originatestoreid,
		                                        (int)$this->isoutproduct,
		                                        (int)$this->outputstoreid,
		                                        (int)$this->isincome,
		                                        (int)$this->isdeleted,
		                                        (int)$this->promotiondiscount,
		                                        (int)$this->vouchertypeid,
		                                        (string)$this->voucherconcern,
		                                        (string)$this->deliveryuser,
		                                        (int)$this->saleprogramid,
		                                        (float)$this->totalpaid,
		                                        (int)$this->issmspromotion,
		                                        (int)$this->deliverytime,
		                                        (int)$this->isdelivery,
		                                        (int)$this->deliveryupdatetime,
		                                        (int)$this->ismove,
		                                        (string)$this->parentsaleorderid,
		                                        (string)$this->thirdpartyvoucher,
		                                        (int)$this->payabletime,
		                                        (int)$this->createdbyotherapps,
		                                        (string)$this->contactphone,
		                                        (int)$this->customercarestatusid,
		                                        (float)$this->totalprepaid,
		                                        (int)$this->crmcustomerid,
		                                        (int)$this->IsDetail,
		                                        (int)$this->originatestoreregionid,
		                                        (int)$this->outputstoreregionid,
		                                        (int)$this->createdate,
		                                        (float)$this->lat,
		                                        (float)$this->lng,
		                                        (int)$this->iscomplete,
		                                        (int)$this->taxid,
		                                        (string)$this->note,
		                                        (int)$this->revieweduser,
		                                        (int)$this->revieweddate,
		                                        (int)$this->outproductdate,
		                                        (int)$this->inputtime,
		                                        (int)$this->userdeleted,
		                                        (int)$this->datedelete,
		                                        (string)$this->contentdeleted,
		                                        (int)$this->staffuser,
		                                        (int)$this->printtimes,
		                                        (int)$this->deliveryupdateuser,
		                                        (int)$this->movetime,
		                                        (int)$this->outputuser,
		                                        (int)$this->deliveryuserupdatetime,
		                                        (int)$this->deliveryuserupdateuser,
		                                        (int)$this->customercarestausupdatetime,
		                                        (int)$this->customercarestatusupdateuser,
		                                        (int)$this->contactid,
		                                        (int)$this->customercode,
		                                        (int)$this->birthday,
		                                        (int)$this->customeridcard,
		                                        (string)$this->createdapplicationid,
		                                        (int)$this->iscreatefromoutputreceipt,
		                                        (int)$this->iscreatefromsimprocessreq,
		                                        (int)$this->bankvoucher,
		                                        (int)$this->processuser,
		                                        (int)$this->contractid,
		                                        (int)$this->isinputimeicomplete,
		                                        (string)$this->organizationname,
		                                        (string)$this->positionname,
		                                        (int)$this->currentreviewlevelid,
		                                        (string)$this->mspromotionlevelidlist,
		                                        (string)$this->crmcustomercardcode,
		                                        (string)$this->iswarningduplicatesaleorder,
		                                        (int)$this->duplicatesaleorderid,
		                                        (float)$this->pointpaid,
		                                        (int)$this->inputuser,
		                                        (int)$this->datedeleted
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'archivedorder
				SET o_ordertypeid = ?,
					o_saleorderid = ?,
					o_deliverytypeid = ?,
					o_datearchived = ?,
					o_companyid = ?,
					o_customerid = ?,
					o_customername = ?,
					o_customeraddress = ?,
					o_customerphone = ?,
					o_contactname = ?,
					o_gender = ?,
					o_ageid = ?,
					o_deliveryaddress = ?,
					o_provinceid = ?,
					o_districtid = ?,
					o_isreviewed = ?,
					o_payabletypeid = ?,
					o_currencyunitid = ?,
					o_currencyexchange = ?,
					o_totalquantity = ?,
					o_totalamount = ?,
					o_totaladvance = ?,
					o_shippingcost = ?,
					o_debt = ?,
					o_discountreasonid = ?,
					o_discount = ?,
					o_originatestoreid = ?,
					o_isoutproduct = ?,
					o_outputstoreid = ?,
					o_isincome = ?,
					o_isdeleted = ?,
					o_promotiondiscount = ?,
					o_vouchertypeid = ?,
					o_voucherconcern = ?,
					o_deliveryuser = ?,
					o_saleprogramid = ?,
					o_totalpaid = ?,
					o_issmspromotion = ?,
					o_deliverytime = ?,
					o_isdelivery = ?,
					o_deliveryupdatetime = ?,
					o_ismove = ?,
					o_parentsaleorderid = ?,
					o_thirdpartyvoucher = ?,
					o_payabletime = ?,
					o_createdbyotherapps = ?,
					o_contactphone = ?,
					o_customercarestatusid = ?,
					o_totalprepaid = ?,
					o_crmcustomerid = ?,
					o_IsDetail = ?,
					o_originatestoreregionid = ?,
					o_outputstoreregionid = ?,
					o_createdate = ?,
					o_lat = ?,
					o_lng = ?,
					o_iscomplete = ?,
					o_taxid = ?,
					o_note = ?,
					o_revieweduser = ?,
					o_revieweddate = ?,
					o_outproductdate = ?,
					o_inputtime = ?,
					o_userdeleted = ?,
					o_datedelete = ?,
					o_contentdeleted = ?,
					o_staffuser = ?,
					o_printtimes = ?,
					o_deliveryupdateuser = ?,
					o_movetime = ?,
					o_outputuser = ?,
					o_deliveryuserupdatetime = ?,
					o_deliveryuserupdateuser = ?,
					o_customercarestausupdatetime = ?,
					o_customercarestatusupdateuser = ?,
					o_contactid = ?,
					o_customercode = ?,
					o_birthday = ?,
					o_customeridcard = ?,
					o_createdapplicationid = ?,
					o_iscreatefromoutputreceipt = ?,
					o_iscreatefromsimprocessreq = ?,
					o_bankvoucher = ?,
					o_processuser = ?,
					o_contractid = ?,
					o_isinputimeicomplete = ?,
					o_organizationname = ?,
					o_positionname = ?,
					o_currentreviewlevelid = ?,
					o_mspromotionlevelidlist = ?,
					o_crmcustomercardcode = ?,
					o_iswarningduplicatesaleorder = ?,
					o_duplicatesaleorderid = ?,
					o_pointpaid = ?,
					o_inputuser =?,
					o_datedeleted=?
				WHERE o_id = ?';

		$stmt = $this->db->query($sql, array(
		                                    (int)$this->ordertypeid,
		                                    (string)$this->saleorderid,
		                                    (int)$this->deliverytypeid,
		                                    (int)$this->datearchived,
		                                    (int)$this->companyid,
		                                    (int)$this->customerid,
		                                    (string)$this->customername,
		                                    (string)$this->customeraddress,
		                                    (string)$this->customerphone,
		                                    (string)$this->contactname,
		                                    (int)$this->gender,
		                                    (int)$this->ageid,
		                                    (string)$this->deliveryaddress,
		                                    (int)$this->provinceid,
		                                    (int)$this->districtid,
		                                    (int)$this->isreviewed,
		                                    (int)$this->payabletypeid,
		                                    (int)$this->currencyunitid,
		                                    (int)$this->currencyexchange,
		                                    (int)$this->totalquantity,
		                                    (float)$this->totalamount,
		                                    (int)$this->totaladvance,
		                                    (int)$this->shippingcost,
		                                    (float)$this->debt,
		                                    (int)$this->discountreasonid,
		                                    (float)$this->discount,
		                                    (int)$this->originatestoreid,
		                                    (int)$this->isoutproduct,
		                                    (int)$this->outputstoreid,
		                                    (int)$this->isincome,
		                                    (int)$this->isdeleted,
		                                    (int)$this->promotiondiscount,
		                                    (int)$this->vouchertypeid,
		                                    (string)$this->voucherconcern,
		                                    (string)$this->deliveryuser,
		                                    (int)$this->saleprogramid,
		                                    (float)$this->totalpaid,
		                                    (int)$this->issmspromotion,
		                                    (int)$this->deliverytime,
		                                    (int)$this->isdelivery,
		                                    (int)$this->deliveryupdatetime,
		                                    (int)$this->ismove,
		                                    (string)$this->parentsaleorderid,
		                                    (string)$this->thirdpartyvoucher,
		                                    (int)$this->payabletime,
		                                    (int)$this->createdbyotherapps,
		                                    (string)$this->contactphone,
		                                    (int)$this->customercarestatusid,
		                                    (float)$this->totalprepaid,
		                                    (int)$this->crmcustomerid,
		                                    (int)$this->IsDetail,
		                                    (int)$this->originatestoreregionid,
		                                    (int)$this->outputstoreregionid,
		                                    (int)$this->createdate,
		                                    (float)$this->lat,
		                                    (float)$this->lng,
		                                    (int)$this->iscomplete,
		                                    (int)$this->taxid,
		                                    (string)$this->note,
		                                    (int)$this->revieweduser,
		                                    (int)$this->revieweddate,
		                                    (int)$this->outproductdate,
		                                    (int)$this->inputtime,
		                                    (int)$this->userdeleted,
		                                    (int)$this->datedelete,
		                                    (string)$this->contentdeleted,
		                                    (int)$this->staffuser,
		                                    (int)$this->printtimes,
		                                    (int)$this->deliveryupdateuser,
		                                    (int)$this->movetime,
		                                    (int)$this->outputuser,
		                                    (int)$this->deliveryuserupdatetime,
		                                    (int)$this->deliveryuserupdateuser,
		                                    (int)$this->customercarestausupdatetime,
		                                    (int)$this->customercarestatusupdateuser,
		                                    (int)$this->contactid,
		                                    (int)$this->customercode,
		                                    (int)$this->birthday,
		                                    (int)$this->customeridcard,
		                                    (string)$this->createdapplicationid,
		                                    (int)$this->iscreatefromoutputreceipt,
		                                    (int)$this->iscreatefromsimprocessreq,
		                                    (int)$this->bankvoucher,
		                                    (int)$this->processuser,
		                                    (int)$this->contractid,
		                                    (int)$this->isinputimeicomplete,
		                                    (string)$this->organizationname,
		                                    (string)$this->positionname,
		                                    (int)$this->currentreviewlevelid,
		                                    (string)$this->mspromotionlevelidlist,
		                                    (string)$this->crmcustomercardcode,
		                                    (string)$this->iswarningduplicatesaleorder,
		                                    (int)$this->duplicatesaleorderid,
		                                    (float)$this->pointpaid,
		                                    (int)$this->inputuser,
		                                    (int)$this->datedeleted,
		                                    (int)$this->id
		                               ));

		if($stmt)
			return true;
		else
			return false;
	}

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'archivedorder
				WHERE o_id = ?';
        $rowCount = $this->db->query($sql, array($this->id))->rowCount();

        return $rowCount;
    }

    /** get last saleorder */
    public function getIdNewOrder()
    {
        $result = 0;
        $sql = '
                SELECT
                   max(o_id) as newid
                FROM
                    lit_archivedorder
            ';
        $row = $this->db->query($sql)->fetch();
        if ($row['newid'] > 0) {
            $sql = '
                    SELECT

                        o_saleorderid
                    FROM
                        lit_archivedorder
                    WHERE
                        o_id = ?


                    ';

            $result = $this->db->query($sql, array( $row['newid'] ))->fetch();
        }


        return $result;
    }
    public function getIdMinOrder()
    {
        $result = 0;
        $sql = '
                SELECT
                   min(o_id) as newid
                FROM
                    lit_archivedorder
            ';
        $row = $this->db->query($sql)->fetch();
        if ($row['newid'] > 0) {
            $result = $row['newid'];
        }


        return $result;
    }
}