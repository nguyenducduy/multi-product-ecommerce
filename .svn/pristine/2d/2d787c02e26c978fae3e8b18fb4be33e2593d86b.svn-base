<?php

/**
 * core/class.productstock.php
 *
 * File contains the class used for ProductStock Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_PhotoComment Class for photo feature
 */
Class Core_ProductStock extends Core_Object
{
    const ERRORPRODUCTEXIST = 1;
    const WARININGNOTCHANGE = 2;
    const SYNCSUCCESS = 3;
    const SYNCERROR = 4;

	public $pbarcode = "";
	public $sid = 0;
	public $id = 0;
	public $quantity = 0;
	public $datemodified = 0;
	public $storeActor = null;

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
    	$this->datemodified = time();
		$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
					p_barcode,
					s_id,
					ps_quantity,
					ps_datemodified
					)
		        VALUES(?, ?, ?, ?)';
		$rowCount = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
					(int)$this->quantity,
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


		$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
				SET p_barcode = ?,
					s_id = ?,
					ps_quantity = ?,
					ps_datemodified = ?
				WHERE ps_id = ?';

		$stmt = $this->db->query($sql, array(
					(string)$this->pbarcode,
					(int)$this->sid,
					(int)$this->quantity,
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
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stock ps
				WHERE ps.ps_id = ?';
		$row = $this->db->query($sql, array($id))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->sid = $row['s_id'];
		$this->id = $row['ps_id'];
		$this->quantity = $row['ps_quantity'];
		$this->datemodified = $row['ps_datemodified'];

	}

	/**
	 * Delete current object from database, base on primary key
	 *
	 * @return int the number of deleted rows (in this case, if success is 1)
	 */
	public function delete()
	{
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_stock
				WHERE ps_id = ?';
		$rowCount = $this->db->query($sql, array($this->id))->rowCount();

		return $rowCount;
	}

    /**
     * Count the record in the table base on condition in $where
	 *
	 * @param string $where: the WHERE condition in SQL string.
     */
	public static function countList($where, $groupby)
	{
		global $db;

		$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product_stock ps';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
			$sql .= ' GROUP BY s_id ';

		return $db->query($sql)->fetchColumn(0);
	}

	/**
	 * Get the record in the table with paginating and filtering
	 *
	 * @param string $where the WHERE condition in SQL string
	 * @param string $order the ORDER in SQL string
	 * @param string $limit the LIMIT in SQL string
	 */
	public static function getList($where, $order, $limit = '',$groupby)
	{
		global $db;

		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stock ps';

		if($where != '')
			$sql .= ' WHERE ' . $where;

		if($groupby)
			$sql .= ' GROUP BY s_id ';

		if($order != '')
			$sql .= ' ORDER BY ' . $order;

		if($limit != '')
			$sql .= ' LIMIT ' . $limit;

		$outputList = array();
		$stmt = $db->query($sql);
		while($row = $stmt->fetch())
		{
			$myProductStock = new Core_ProductStock();

			$myProductStock->pbarcode = $row['p_barcode'];
			$myProductStock->sid = $row['s_id'];
			$myProductStock->id = $row['ps_id'];
			$myProductStock->quantity = $row['ps_quantity'];
			$myProductStock->datemodified = $row['ps_datemodified'];


            $outputList[] = $myProductStock;
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
	public static function getProductStocks($formData, $sortby, $sorttype, $limit = '', $countOnly = false, $groupby=false)
	{
		$whereString = '';


		if($formData['fpbarcode'] != '')
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.p_barcode = "'.Helper::unspecialtext((string)$formData['fpbarcode']).'" ';

		if($formData['fsid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.s_id = '.(int)$formData['fsid'].' ';

		if($formData['fid'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.ps_id = '.(int)$formData['fid'].' ';

		if($formData['fquantity'] > 0)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.ps_quantity = '.(int)$formData['fquantity'].' ';

		if(isset($formData['fhavequantity']) && $formData['fhavequantity'] == true)
			$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.ps_quantity > 0 ';

        if(count($formData['fsidarr']) > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.ps_id IN (' . implode($formData['fsidarr']) .') ';

		$whereString .= ($whereString != '' ? ' AND ' : '') . 'ps.s_id NOT IN(734 , 990, 991, 992, 993, 994)';

		//checking sort by & sort type
		if($sorttype != 'DESC' && $sorttype != 'ASC')
			$sorttype = 'DESC';


		if($sortby == 'pbarcode')
			$orderString = 's_id , p_barcode ' . $sorttype;
		elseif($sortby == 'sid')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'id')
			$orderString = 's_id ' . $sorttype;
		elseif($sortby == 'quantity')
			$orderString = 'ps_quantity ' . $sorttype;
		else
			$orderString = 's_id , ps_id ' . $sorttype;

		if($countOnly)
			return self::countList($whereString,$groupby);
		else
			return self::getList($whereString, $orderString, $limit,$groupby);
	}

	public function getProductStockByBarcode($barcode , $sid)
	{
		$sql = 'SELECT DISTINCT(s_id) , p_barcode, ps_id, ps_quantity, ps_datemodified FROM ' . TABLE_PREFIX . 'product_stock
				WHERE p_barcode = ? AND s_id =?';
        $row = $this->db->query($sql, array($barcode, $sid))->fetch();

		$this->pbarcode = $row['p_barcode'];
		$this->sid = $row['s_id'];
		$this->id = $row['ps_id'];
		$this->quantity = $row['ps_quantity'];
		$this->datemodified = $row['ps_datemodified'];
	}

    public static function getProductIntockByStore($storeidList = array() , $barcode)
    {
    	global $db;
        $quantity = 0;

        if(count($storeidList) > 0 && !empty($barcode))
        {
            $sql = 'SELECT SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock WHERE s_id IN ('.implode(',', $storeidList).') AND p_barcode = ?';
            $row = $db->query($sql , array($barcode))->fetch();
            $quantity = $row['quantity'];
        }

        return $quantity;
    }

    public static function syncProductStock($pbarcode = '')
    {
        global $db;
        $result = 0;
        $oracle = new Oracle();

        //get product info
		$product = Core_Product::getProductIDByBarcode($pbarcode);

        $sql = 'select ci.* from ERP.vw_currentinstock_dm ci inner join ERP.VW_PM_STORE_DM s ON ci.STOREID = s.STOREID where ci.productid = \'' . trim($pbarcode) .'\' and s.ISSALESTORE = 1';


        $results = $oracle->query($sql);

        if(count($results) > 0)
        {
        	$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_stock WHERE p_barcode = ?';
        	$rs = $db->query($sql , array($pbarcode));
        	foreach($results as $res)
	        {

	        	$countProductstock = Core_ProductStock::getProductStocks(array('fpbarcode' =>$pbarcode,'fsid' => (int)$res['STOREID']) , 'id' , 'ASC', '', true);
	            if($countProductstock > 0)
	            {
	            	$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
	                    	SET ps_quantity = ?,
	                        ps_datemodified = ?
	                    	WHERE p_barcode = ? AND s_id = ?';

		            $stmt = $db->query($sql, array(
		                    (int)$res['QUANTITY'],
		                    time(),
		                    $pbarcode,
		                    (int)$res['STOREID']
		                    ));
	            }
	            else
	            {
	            	$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
	                                                                p_barcode,
	                                                                s_id,
	                                                                ps_quantity
	                                                                )
	                                                            VALUES(?, ?, ?)';

	                $stmt = $db->query($sql, array(
	                            	$pbarcode,
	                            	(int)$res['STOREID'],
	                            	(int)$res['QUANTITY']
	                            ));
	            }
	        }
        }
        else
        {
        	$sql = 'UPDATE '. TABLE_PREFIX . 'product_stock
                        SET ps_quantity = ?,
                            ps_datemodified = ?
                            WHERE p_barcode = ?';
            $stmt1 = $db->query($sql, array(
                                    0,
                                    time(),
                                    $pbarcode
                                    ));

            if($stmt1)
            {
                unset($stmt1);
            }
        }

	    //cap nhat ton kho san pham mau
	    $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$product['p_id']), 'id', 'ASC');

	    if(count($productcolors) > 0)
	    {
	        foreach ($productcolors as $productcolor)
	        {
	        	$myproductcolor = new Core_Product($productcolor->piddestination);

	        	if($myproductcolor->id > 0)
	        	{
		        	$sql = 'select ci.* from ERP.vw_currentinstock_dm ci inner join ERP.VW_PM_STORE_DM s ON ci.STOREID = s.STOREID where ci.productid = \'' . trim($myproductcolor->barcode) .'\' and s.ISSALESTORE = 1';

				    $results = $oracle->query($sql);

				    foreach($results as $res)
				    {

				        $countProductstock = Core_ProductStock::getProductStocks(array('fpbarcode' =>$myproductcolor->barcode,'fsid' => (int)$res['STOREID']) , 'id' , 'ASC', '', true);
				        if($countProductstock > 0)
				        {
				           	$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
				                    	SET ps_quantity = ?,
				                        ps_datemodified = ?
				                    	WHERE p_barcode = ? AND s_id = ?';

					        $stmt2 = $db->query($sql, array(
					                    (int)$res['QUANTITY'],
					                    time(),
					                    $myproductcolor->barcode,
					                    (int)$res['STOREID']
					                    ));
				        }
				        else
				        {
				            $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
				                                                                p_barcode,
				                                                                s_id,
				                                                                ps_quantity
				                                                                )
				                                                            VALUES(?, ?, ?)';

				            $stmt2 = $db->query($sql, array(
				                            	$myproductcolor->barcode,
				                            	(int)$res['STOREID'],
				                            	(int)$res['QUANTITY']
				                            ));
				        }
		        	}
	        	}
	        }
	    }
	    else
	    {
	    	$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
			                    	SET ps_quantity = ?,
			                        ps_datemodified = ?
			                    	WHERE p_barcode = ? AND s_id = ?';

				        $stmt2 = $db->query($sql, array(
				                    0,
				                    time(),
				                    $myproductcolor->barcode,
				                    (int)$res['STOREID']
				                    ));
	    }

        //cap nhat thong tin ton kho cua san pham
        /////////////////////////////////////////////////////////////////////
        if($stmt)
        {
        	$quantity = 0;
        	$specialstore = array(988 , 790 , 791 , 806 , 855 , 877 , 946 , 947, 948, 949, 974, 978, 988, 990, 991, 992, 993, 994, 995); // day la nhung kho ma se khong tinh ton kho vao san pham , neu phat sinh them thi them id cua store vao mang nay
            $sql = 'SELECT SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock ps
                    WHERE ps.s_id NOT IN(' .implode(',', $specialstore). ') AND ps.p_barcode = "' . $pbarcode .'"';

            $row1 = $db->query($sql)->fetch();
            $quantity += (int)$row1['quantity'];

            //lay ton kho cua san pham mau
            //get instock of product color
            $productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$product['p_id']), 'id', 'ASC');
            if(count($productcolors) > 0)
            {
                foreach($productcolors as $productcolor)
                {
                    $sql = 'SELECT p_barcode , p_id , p_instock FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
                    $rowdata = $db->query($sql , array($productcolor->piddestination))->fetch();

                    $sql = 'SELECT SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock ps
                            WHERE ps.s_id NOT IN(' .implode(',', $specialstore). ') AND ps.p_barcode = ?  GROUP BY ps.p_barcode';
                    $rowdata2 = $db->query($sql , array($rowdata['p_barcode']))->fetch();

                    $quantity += (int)$rowdata2['quantity'];

                    //cap nhat ton kho cho san pham mau
                    if($rowdata2['quantity'] > 0 && (int)$rowdata['p_instock'] != $rowdata2['quantity'])
                    {
                        $sql = 'UPDATE ' . TABLE_PREFIX .'product p
                        SET p.p_instock = ?,
                            p.p_syncstatus = ?
                        WHERE p_barcode = ?';

                        $result = $db->query($sql, array((int)$rowdata2['quantity'], Core_Product::STATUS_SYNC_FOUND ,(string)$rowdata['p_barcode']));
                        $counter++;
                    }
                }
            }
            $sql = 'UPDATE ' . TABLE_PREFIX .'product p
                    SET p.p_instock = ?,
                        p.p_syncstatus = ?
                    WHERE p_barcode = ?';
            $stmt1 = $db->query($sql, array($quantity, Core_Product::STATUS_SYNC_FOUND ,$pbarcode));
            if($stmt1)
                $result = Core_ProductStock::SYNCSUCCESS;
            else
                $result = Core_ProductStock::SYNCERROR;
        }
        else
        {
                $result = Core_ProductStock::SYNCERROR;
        }

        return $result;
    }

    public static function getStoreStockFromErpByProduct($pbarcode)
    {
		global $db;

		$liststoresobject = array();

		$listallstoreavailable = Core_Product::getSpecialStore();
		$specialstore = $listallstoreavailable['specialstore'];
    	$storehcm = $listallstoreavailable['storehcm'];

    	$listidloaitrutrongtonkhotong = array(988 , 790 , 791 , 806 , 855 , 877 , 946 , 947, 948, 949, 974, 978, 988, 990, 991, 992, 993, 994, 995);

		//lay all quantitystore cua web
		$productStockData = array();
		$productStockData['fpbarcode'] = $pbarcode;
    	$productStockData['fhavequantity'] = true;
    	$productStocks = Core_ProductStock::getProductStocks($productStockData , 'id' , 'ASC');

    	//$oldstocklist = array();
    	$returnstocks = array();
    	if (!empty($productStocks))
    	{
			foreach ($productStocks as $productstock)
			{
				//$oldstocklist[$productstock->sid] = array('quantity' => $productstock->quantity, 'iscached' => 0);
				$returnstocks[$productstock->sid] = array('quantity' => $productstock->quantity, 'iscached' => 0);
			}
    	}

		//lay all quantitystore cua erp
		$oracle = new Oracle();
		$results = $oracle->query('SELECT * FROM ERP.VW_CURRENTINSTOCK_DM WHERE PRODUCTID = \''.$pbarcode.'\'');// STOREID NOT IN ('.implode(',', $specialstore).')
		$ischangestock = 0;
		if (!empty($results))
		{
			foreach ($results as $rs)
			{
				$csid = (int)$rs['STOREID'];
				$cquantity = (int)$rs['QUANTITY'];
				if (!empty($returnstocks[$csid]))
				{
					if ($returnstocks[$csid]['quantity'] != $cquantity)
					{
						$returnstocks[$csid] = array('quantity' => $cquantity, 'iscached' => 3);
						$ischangestock = 1;
					}
					else $returnstocks[$csid] = array('quantity' => $cquantity, 'iscached' => 1);
				}
				else
				{
					$returnstocks[$csid] = array('quantity' => $cquantity, 'iscached' => 2);//cache 2 la new
					$ischangestock = 1;
				}
			}
		}
		elseif ($results != false)
		{
			$ischangestock = 1;
		}
		else $ischangestock = 1;
		$liststoreavailable = array();
		$quantityinstock = 0;
		if ($ischangestock > 0)
		{
			if (!empty($returnstocks))
			{
				foreach ($returnstocks as $sid => $stock)
				{
					if ($stock['iscached'] > 0)
					{
						if (!in_array($sid, $listidloaitrutrongtonkhotong))
						{
							$quantityinstock += $stock['quantity'];
						}
						if ($sid == 919 && !in_array($storehcm, $liststoreavailable))
						{
							$liststoreavailable = array_merge($storehcm, $liststoreavailable) ;
						}
						elseif ($sid != 919 && !in_array($sid , $specialstore) && !in_array($sid , $liststoreavailable))
						{
							$liststoreavailable[] = $sid;
						}
					}
					if ($stock['iscached'] > 0)
					{
                        //truong hop them moi
						if ($stock['iscached'] == 2)
						{
							$mynewProductStock = new Core_ProductStock();
							$mynewProductStock->pbarcode = $pbarcode;
							$mynewProductStock->quantity = (int)$stock['quantity'];
							$mynewProductStock->sid = (int)$sid;
							$mynewProductStock->datemodified = time();
							$mynewProductStock->addData();
						}
						else $db->query('UPDATE '.TABLE_PREFIX.'product_stock SET ps_quantity = '.(int)$stock['quantity'].' WHERE p_barcode = "'.$pbarcode.'" AND s_id = '.(int)$sid);
					}
					elseif ($stock['iscached'] == 0)
					{
						$db->query('UPDATE '.TABLE_PREFIX.'product_stock SET ps_quantity = 0 WHERE p_barcode = "'.$pbarcode.'" AND s_id = '.(int)$sid);
					}
				}
				//cap nhat ton kho tong trong product
				$db->query('UPDATE '.TABLE_PREFIX.'product SET p_instock = '.(int)$quantityinstock.' WHERE p_barcode = "'.$pbarcode.'"');

				//lay list sieu thi ton kho
				if (!empty($liststoreavailable))
				{
					$storers = Core_Store::getStores(array('fidarr' => $liststoreavailable), 'name', 'ASC');
					if (!empty($storers))
					{
						foreach ($storers as $store)
						{
							if ($store->id != 919 && $store->hoststoreid == 0 && $store->issalestore == 1 && $store->isinputstore == 1 && $store->isautostorechange == 1) {
								$liststoresobject[$store->id] = $store;
							}
						}
					}
					unset($storers);

					$storers = Core_Store::getStores(array('fstoregroupidarr' => $liststoreavailable), 'name', 'ASC');
					if (!empty($storers))
					{
						foreach ($storers as $store)
						{
							if ($store->id != 919 && $store->hoststoreid == 0 && $store->issalestore == 1 && $store->isinputstore == 1 && $store->isautostorechange == 1) {
								$liststoresobject[$store->id] = $store;
							}
						}
					}
					unset($storers);
				}
				//sau khi update data xong thi cap nhat du lieu trong product
			}
			else
			{
				//khong tim thay thong tin kho nao cua san pham hien tai nen update ve = 0
				$db->query('UPDATE '.TABLE_PREFIX.'product_stock SET ps_quantity = 0 WHERE p_barcode = "'.$pbarcode.'"');
				$db->query('UPDATE '.TABLE_PREFIX.'product SET p_instock = 0 WHERE p_barcode = "'.$pbarcode.'"');
			}
		}
		else
		{
			if (!empty($returnstocks))
			{
				foreach ($returnstocks as $sid => $stock)
				{
					if ($stock['iscached'] > 0)
					{
						if (!in_array($sid, $listidloaitrutrongtonkhotong))
						{
							$quantityinstock += $stock['quantity'];
						}
					}
				}
			}
			$liststoreid = Core_Product::getStoreAvailable($pbarcode);
			$liststoresobject = Core_Store::getStores(array('fidarr' => $liststoreid, 'fstatus' => Core_Store::STATUS_ENABLE),'name','ASC','');
		}

		return array('quantity' => $quantityinstock, 'stores' => $liststoresobject);
    }

    public function getProductStockByStore($barcode)
    {
        global $db;
        $outputList = array();

        if(!empty($barcode)) {
            $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'product_stock WHERE p_barcode = ? GROUP BY s_id';
            $stmt = $db->query($sql , array($barcode));
            while($row = $stmt->fetch())
            {
                $myProductStock = new Core_ProductStock();

                $myProductStock->pbarcode = $row['p_barcode'];
                $myProductStock->sid = $row['s_id'];
                $myProductStock->id = $row['ps_id'];
                $myProductStock->quantity = $row['ps_quantity'];
                $myProductStock->datemodified = $row['ps_datemodified'];


                $outputList[] = $myProductStock;
            }
        }


        return $outputList;
    }

}
