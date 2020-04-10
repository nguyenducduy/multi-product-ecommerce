<?php
class Controller_Task_Productprice extends Controller_Task_Base
{
    public function indexAction()
    {
        $pbarcode = (string)$_GET['pbarcode'];               
        $result = 0;
		$oracle = new Oracle();
        $pbarcode = trim($pbarcode);
		$sql = 'select P.UPDATEDPRICEUSER,P.PRICEAREAID, P.OUTPUTTYPEID, p.updatedpricedate ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID
                    from ERP.VW_PRICE_PRODUCT_DM P
                    INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID                               
                    where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$pbarcode. '\'';



        $results = $oracle->query($sql);

        //xoa tat ca cac gia cu da luu cua san pham        
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price WHERE p_barcode = ?';
        $rowCounts2 = $this->registry->db->query($sql, array($pbarcode));

        foreach($results as $res)
        {
            $countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $pbarcode , 'fppaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','',true);

            //echodebug($countProductPrice,true);

            if($countProductPrice > 0)
            {
                  $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
                            SET pp_sellprice = ?,
                                pp_discount = ?,
                                pp_confirm = ?,
                                tgdd_uid = ?,
                                pp_datemodified = ?
                            WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
                    $stmt = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
                                                        (int)$res['DISCOUNT'],
                                                        (int)$res['ISPRICECONFIRMED'],
                                                        (int)$res['UPDATEDPRICEUSER'],
                                                        time(),
                                                        $pbarcode ,
                                                        $res['PRICEAREAID'],
                                                        $res['OUTPUTTYPEID'],
                                                        $res['STOREID'],
                                                        $res['AREAID'],
                                                        $res['PROVINCEID']
                                                        ));

            }
            else
            {
                $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price (
                                                            tgdd_uid,
                                                            p_id,
                                                            p_barcode,
                                                            ppa_id,
                                                            s_id,
                                                            a_id,
                                                            r_id,
                                                            po_id,
                                                            pp_sellprice,
                                                            pp_discount,
                                                            pp_confirm
                                                            )
                                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                $stmt = $this->registry->db->query($sql , array(
                                                        (int)$res['UPDATEDPRICEUSER'],
                                                        (int)$res['PRODUCTIDREF'],
                                                        trim($pbarcode),
                                                        (int)$res['PRICEAREAID'],
                                                        $res['STOREID'],
                                                        $res['AREAID'],
                                                        $res['PROVINCEID'],
                                                        (int)$res['OUTPUTTYPEID'],
                                                        (float)$res['SALEPRICE'],
                                                        (int)$res['DISCOUNT'],
                                                        (int)$res['ISPRICECONFIRMED'],
                                                        ));

            }

        }

        if($stmt)
        {
        	$sql = 'SELECT p_barcode , p_sellprice , p_finalprice FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
        	$row = $this->registry->db->query($sql , array($pbarcode))->fetch();


            //cap nhat gia cho san pham
            $sql = 'SELECT pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                            WHERE ppa_id = 242 AND po_id = 0 AND p_barcode = ? AND pp_confirm = 1';

            $row1 = $this->registry->db->query($sql,array($pbarcode))->fetch(); 
            
            if((float)$row1['pp_sellprice'] <= 0)
            {
                $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
                            WHERE ppa_id = 242 AND po_id = 222 AND p_barcode = ' . $pbarcode .' AND pp_confirm = 1';
                $row2 = $this->registry->db->query($sql)->fetch();
                if($row2['pp_sellprice'] > 0)
                {
                	 //kiem tra cap nhat final price
                    if($row['p_finalprice'] == 0)
                    {
                        $sql = 'UPDATE '. TABLE_PREFIX .'product
                            SET p_finalprice = '.(float)$result1['pp_sellprice'].'                                             
                            WHERE p_barcode = ' . (string)$row['p_barcode'];
                        $result2 = $this->registry->db->query($sql);
                    }

                     $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_sellprice = ' . $row2['pp_sellprice'].'
                        WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                      $stmt1 = $this->registry->db->query($sql);
                }
                else
                {
                	$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_sellprice = 0
                			WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                	$stmt1 = $this->registry->db->query($sql);
                }
            }
            else
            {
            	 //kiem tra cap nhat final price
                if((float)$row['p_finalprice'] == 0)
                {
                    $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_finalprice = '.(float)$row1['pp_sellprice'].'
                        WHERE p_barcode = ' . (string)$row['p_barcode'];
                    $result2 = $this->registry->db->query($sql);
                }
             	   
                $sql = 'UPDATE '. TABLE_PREFIX .'product
                        SET p_sellprice = ' . $row1['pp_sellprice'].'
                        WHERE p_barcode = ' . Helper::plaintext($pbarcode);
                $stmt1 = $this->registry->db->query($sql);                               
            }            

            if($stmt1)
            {
                $result = Core_ProductPrice::SYNCSUCCESS;
            }
            else
            {
                $result = Core_ProductPrice::SYNCERROR;
            }

        }
        else
        {
            $result = Core_ProductPrice::SYNCERROR;
        }
         
    }
}