<?php

/**
 * core/class.relregionpricearea.php
 *
 * File contains the class used for RelRegionPricearea Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_RelRegionPricearea extends Core_Object
{

	public $uid = 0;
	public $ppaid = 0;
    public $rid = 0;
	public $aid = 0;
    public $id = 0;
    public $dateadd= 0;
	public $datemodify = 0;

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

		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'rel_region_pricearea (
					u_id,
                    ppa_id,
                    rrpa_dateadd,
					rrpa_datemodify,
                    r_id,
					a_id
					)
		        VALUES(?, ?, ?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(int)$this->uid,
                    (int)$this->ppaid,
                    (int)time(),
					(int)time(),
                    (int)$this->rid,
					(int)$this->aid
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

		$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_region_pricearea
				SET u_id = ?,
					ppa_id = ?,
                    rrpa_datemodify = ?,
                    r_id = ?,
					a_id = ?
				WHERE rrpa_id = ?';

		$stmt = $this->db->query($sql, array(
					(int)$this->uid,
                    (int)$this->ppaid,
					(int)time(),
                    (int)$this->rid,
					(int)$this->aid,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_region_pricearea rrp
				WHERE rrp.rrpa_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->uid = $row['u_id'];
		$this->ppaid = $row['ppa_id'];
        $this->rid = $row['r_id'];
		$this->aid = $row['a_id'];
        $this->id = $row['rrpa_id'];
        $this->dateadd = $row['rrpa_dateadd'];
		$this->datemodify = $row['rrpa_datemodify'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'rel_region_pricearea
				WHERE rrpa_id = ?';
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

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_region_pricearea rrp';

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

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'rel_region_pricearea rrp';

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
			$myRelRegionPricearea = new Core_RelRegionPricearea();

			$myRelRegionPricearea->uid = $row['u_id'];
			$myRelRegionPricearea->ppaid = $row['ppa_id'];
            $myRelRegionPricearea->rid = $row['r_id'];
			$myRelRegionPricearea->aid = $row['a_id'];
			$myRelRegionPricearea->id = $row['rrpa_id'];
			$myRelRegionPricearea->dateadd = $row['rrppadateadd'];
            $myRelRegionPricearea->datemodify = $row['rrppa_datemodify'];

            $outputList[] = $myRelRegionPricearea;
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
	public static function getRelRegionPriceareas($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
	{
		$whereString = '';


		if($formData['fppaid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrp.ppa_id = '.(int)$formData['fppaid'].' ';

		if($formData['frid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrp.r_id = '.(int)$formData['frid'].' ';

		if($formData['faid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'rrp.a_id = '.(int)$formData['faid'].' ';

        if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'rrp.rrpa_id = '.(int)$formData['fid'].' ';

		if(count($formData['faidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['faidarr']) ; $i++)
            {
                if($i == count($formData['faidarr']) - 1)
                {
                    $whereString .= 'rrp.a_id= ' . (int)$formData['faidarr'][$i];
                }
                else
                {
                    $whereString .= 'rrp.a_id = ' . (int)$formData['faidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }

        if(count($formData['fppaidarr']) > 0)
        {
            $whereString .= ($whereString != '' ? ' AND ' : '') . '(';
            for($i = 0 ; $i < count($formData['fppaidarr']) ; $i++)
            {
                if($i == count($formData['fppaidarr']) - 1)
                {
                    $whereString .= 'rrp.ppa_id= ' . (int)$formData['fppaidarr'][$i];
                }
                else
                {
                    $whereString .= 'rrp.ppa_id = ' . (int)$formData['fppaidarr'][$i] . ' OR ';
                }
            }
            $whereString .= ')';
        }


		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'id')
			$orderString = 'rrpa_id ' . $sorttype;
		else
			$orderString = 'rrpa_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString);
		else
			return self::getList($whereString, $orderString, $limit);
	}

    //anh tai noi: 222; online, 0: sieu thi, 242 dienmay gia chuan
    public static function getPriceByProductRegion($barcode, $regionid, $showlistprice = false, $outputtype = 0)//222
    {
        $finaleprice = 0;
        if(!empty($barcode) && !empty($regionid))
        {
            $barcode = trim($barcode);
            $myproduct = Core_Product::getIdByBarcode($barcode);
            if($myproduct->id <=0) return 0;// || $myproduct->sellprice <= 0

            $getProductPrice = null;
            if($showlistprice) $getProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode, 'frid' => $regionid,'fhavesellprice' => 1, 'fconfirm' =>1, 'fppaid' => 242),'sellprice','ASC');
            else $getProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode, 'frid' => $regionid,'fhavesellprice' => 1, 'fppaid' => 242, 'fpoid' => $outputtype, 'fconfirm' =>1),'sellprice','ASC', 1);
            if(!empty($getProductPrice))
            {
                if($showlistprice)
                {
                    $newProductPrice = array();
                    foreach($getProductPrice as $pp)
                    {
                        if($pp->poid == $outputtype) continue;
                        $newProductPrice[] = $pp;//cái này cần lấy ra 1 khuyến mãi giảm giá duy nhất để tính tiền
                    }
                    return $newProductPrice;//array('listProductPrice'=>$newProductPrice, 'promotionPrice' => $getPromotionPrice);
                }
                elseif(!empty($getProductPrice[0])){
                	return $getProductPrice[0]->sellprice;
                    /*$newlistsellprice = array();
                    $arr_finalprice = array();
                    //$minprice = $pp->sellprice;
                    foreach($getProductPrice as $pp)
                    {
                        //
                        if($pp->sellprice > 0)
                        {
                            if($pp->poid==$outputtype)
                            {
                                //$arr_finalprice[] = $pp->sellprice;
                                return $pp->sellprice;
                            }
                            elseif(($pp->poid==222 && $pp->sellprice >0 ) || ($pp->poid==0 && $pp->sellprice >0 ))
                            {
                                //$arr_finalprice[] = $pp->sellprice;
                                return $pp->sellprice;
                            }
                            //$newlistsellprice[] = $pp->sellprice;
                        }
                    }  */
                    /*if(!empty($arr_finalprice)) {
                        if(count($finaleprice) > 1) $finaleprice = min($arr_finalprice);
                        else $finaleprice = $arr_finalprice[0];
                    }
                    elseif(!empty($newlistsellprice))
                    {
                        $finaleprice = min($newlistsellprice);
                    }*/
                }
            }

            /*if(empty($finaleprice))
            {
                $getProduct = Core_Product::getProducts(array('fbarcode' => $barcode),'','',1); var_dump($getProduct);
                if(!empty($getProduct->sellprice)) {
                    $finaleprice = $getProduct->sellprice;
                }
            }*/
        }
        return $finaleprice;
    }

 	//anh tai noi: 222; online, 0: sieu thi, 242 dienmay gia chuan
    public static function getPriceByProductRegionByProductObject($myproduct, $regionid, $showlistprice = false, $outputtype = 0)//222
    {
        $finaleprice = 0;
        if(!empty($myproduct) && !empty($regionid))
        {
            if($myproduct->id <=0) return 0;// || $myproduct->sellprice <= 0
            $barcode = trim($myproduct->barcode);
            $getProductPrice = null;
            if($showlistprice) $getProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode, 'frid' => $regionid,'fhavesellprice' => 1, 'fconfirm' =>1, 'fppaid' => 242),'sellprice','ASC');
            else $getProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $barcode, 'frid' => $regionid,'fhavesellprice' => 1, 'fppaid' => 242, 'fpoid' => $outputtype, 'fconfirm' =>1),'sellprice','ASC', 1);
            if(!empty($getProductPrice))
            {
                if($showlistprice)
                {
                    $newProductPrice = array();
                    foreach($getProductPrice as $pp)
                    {
                        if($pp->poid == $outputtype) continue;
                        $newProductPrice[] = $pp;//cái này cần lấy ra 1 khuyến mãi giảm giá duy nhất để tính tiền
                    }
                    return $newProductPrice;//array('listProductPrice'=>$newProductPrice, 'promotionPrice' => $getPromotionPrice);
                }
                elseif(!empty($getProductPrice[0])){
                	return $getProductPrice[0]->sellprice;
                }
            }
        }
        return $finaleprice;
    }
}