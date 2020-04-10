<?php

/**
 * core/backend/class.productindex.php
 *
 * File contains the class used for Productindex Model
 *
 * @category Litpi
 * @package Core
 * @author Vo Duy Tuan <tuanmaster2002@yahoo.com>
 * @copyright Copyright (c) 2012 - Litpi Framework (http://www.litpi.com)
 */

/**
 * Core_Backend_PhotoComment Class for photo feature
 */
Class Core_Backend_Productindex extends Core_Backend_Object
{

    public $pid = 0;
    public $pbarcode = '';
    public $pcid = 0;
    public $title = '';
    public $content = "";
    public $onsitestatus = 0;
    public $datemodified = 0;

    public function __construct($pid = 0)
    {
        parent::__construct();

        if($pid > 0)
            $this->getData($pid);
    }

    /**
     * Insert object data to database
     * @return int The inserted record primary key
     */
    public function addData()
    {

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'productindex (
                    p_id,
                    p_barcode,
                    pc_id,
                    pi_title,
                    pi_content,
                    pi_onsitestatus,
                    pi_datemodified
                    )
                VALUES(?, ?, ?,?, ?, ?, ?)';
        $rowCount = $this->db3->query($sql, array(
                    (int)$this->pid,
                    (string)$this->pbarcode,
                    (int)$this->pcid,
                    (string)$this->title,
                    (string)$this->content,
                    (int)$this->onsitestatus,
                    (int)$this->datemodified
                    ))->rowCount();
        return $rowCount;
    }

    /**
     * Update database
     *
     * @return boolean Indicate query success or not
     */
    public function updateData()
    {
        if ($this->pid <= 0 ) return false;

        $myProduct = new Core_Product( $this->pid );
        if($myProduct->id <= 0) return false;

        $this->pcid         = $myProduct->pcid;
        $this->pbarcode     = $myProduct->barcode;
        $this->onsitestatus = $myProduct->onsitestatus;
        $this->title        = $myProduct->name;
        $this->datemodified = time();

        $myCategory = new Core_Productcategory( $myProduct->pcid );

        $contentoutput = '';

        $contentoutput .= $myProduct->name . "\n";
        $contentoutput .= 'Mã sản phẩm '.$myProduct->id . ' barcode ' . $myProduct->barcode . "\n";

        $fullPathCat = Core_Productcategory::getFullParentProductCategorys($myProduct->pcid);

        if(!empty($fullPathCat))
        {
            $breadcum = '';
            foreach ( $fullPathCat as $cat)
            {
                $breadcum .= $cat['pc_name'] . ' ';
            }

            if( $breadcum != '') $contentoutput .= $breadcum."\n";
        }

        if( $myProduct->warranty != '')
        {
            $contentoutput .= 'Bảo hành ' . $myProduct->warranty . ' tháng' . "\n";
        }

        //check promotion
        //lấy tất cả các region để clear cache
        $listpromotions = Core_Promotion::getPromotionByProductIDFrontEnd(trim($myProduct->barcode), 3, $myProduct->sellprice);
        $findmaxstartdatepromotion = 0;
        $findminenddatepromotion = 0;
        $getexcludepromotion = array();
        $listcurrentpromotion = array();
        $listpromotionbypromotionids = array();
        if(!empty($listpromotions['listPromotions']))
        {
            foreach($listpromotions['listPromotions'] as $lpromo)
            {
                if($lpromo['startdate'] > $findmaxstartdatepromotion)
                {
                    $findmaxstartdatepromotion = $lpromo['startdate'];
                }
                if($findminenddatepromotion == 0 || $lpromo['enddate'] < $findminenddatepromotion)
                {
                    $findminenddatepromotion = $lpromo['enddate'];
                }
                $listcurrentpromotion[] = $lpromo['promoid'];
                $listpromotionbypromotionids[$lpromo['promoid']] = $lpromo;
                //check promotion exclude
                $checkpromotionexclude = Core_PromotionExclude::getPromotionExcludes(array('fpromoid'=>$lpromo['promoid']),'','');
                if(!empty($checkpromotionexclude))
                {
                    foreach($checkpromotionexclude as $promoexcl)
                    {
                        $getexcludepromotion[$lpromo['promoid']][] = $promoexcl->promoeid;
                    }
                }
            }
        }
        $listpromotionswithexlude = Helper::combinePromotion($listcurrentpromotion, $getexcludepromotion);
        if(!empty($listpromotionswithexlude) && !empty($listpromotionbypromotionids))
        {
            foreach ($listpromotionswithexlude as $excludearray)
            {
                if (!empty($excludearray))
                {
                    $cntex = 0;
                    foreach($excludearray as $promoide)
                    {
                        if($cntex >0)
                        {
                            $contentoutput .= 'Hoặc'."\n";
                        }
                        if(!empty($listpromotionbypromotionids[$promoide]))
                        {
                            $contentoutput .= strip_tags($listpromotionbypromotionids[$promoide]['promoname'])."\n";
                        }
                    }
                }
            }
            $contentoutput .= 'Khuyến mãi áp dụng từ ngày '.date('d', $findmaxstartdatepromotion).' tháng '.date('m', $findmaxstartdatepromotion).' năm '.date('Y', $findmaxstartdatepromotion).' đến ngày '.date('d', $findminenddatepromotion).' tháng '.date('m', $findminenddatepromotion).' năm '.date('Y', $findminenddatepromotion)."\n";
        }

        //end check promotion


        if( $myProduct->fullboxshort != '')
        {
            $contentoutput .= 'Bộ bán hàng chuẩn ' . strip_tags($myProduct->fullboxshort) . strip_tags($myProduct->fullbox) . "\n";
        }

        if( $myProduct->good )
        {
            $contentoutput .= 'Ưu điểm ' . $myProduct->name . strip_tags($myProduct->good) . "\n";
        }

        if( $myProduct->dienmayreview )
        {
            $contentoutput .= 'Đánh giá ' . $myProduct->name . strip_tags($myProduct->dienmayreview) . "\n";
        }

        if( $myProduct->summary)
        {
            $contentoutput .= strip_tags($myProduct->summary) . "\n";
        }

        if( $myProduct->content )
        {
            $contentoutput .= 'Giới thiệu ' . $myProduct->name . strip_tags($myProduct->content) . "\n";
        }

        if(!empty($myProduct->vid))
        {
            $myVendor = new Core_Vendor($myProduct->vid);
            if(!empty($myVendor))
            {
                $contentoutput .= 'Nhà sản xuất ' . $myVendor->name . "\n";
            }
        }

        if( $myProduct->slug != '')
        {
            $contentoutput .= $myProduct->slug. "\n";
        }

        if( $myProduct->summary != '' )
        {
            $contentoutput .= strip_tags($myProduct->summary). "\n";
        }

        if( $myProduct->seotitle != '' )
        {
            $contentoutput .= strip_tags($myProduct->seotitle). "\n";
        }

        if( $myProduct->seokeyword != '' )
        {
            $contentoutput .= strip_tags($myProduct->seokeyword). "\n";
        }

        if( $myProduct->seodescription != '' )
        {
            $contentoutput .= strip_tags($myProduct->seodescription). "\n";
        }

        $myKeyword = Core_RelItemKeyword::getRelItemKeywords(array('fobjectid' => $myProduct->id, 'ftype' => Core_RelItemKeyword::TYPE_PRODUCT), '', '', '');
        if(!empty($myKeyword))
        {
            $strKeyword = '';
            foreach($myKeyword as $keyword)
            {
                $prebuild = new Core_Keyword($keyword->kid);
                $strKeyword .= $prebuild->text .' ';
            }
            if(!empty($strKeyword)) $contentoutput .= $strKeyword. "\n";
        }

        $productMedias = Core_ProductMedia::getProductMedias(array('fpid'=>$fpid),'','','', true);
        if( $productMedias > 0)
        {
            $contentoutput .= 'Hình ảnh ' . $myProduct->name . "\n";
        }

        //get product attribute
        $productGroupAttributes = Core_ProductGroupAttribute::getProductGroupAttributes(array('fpcid'=>$myCategory->id,'fstatus'=>Core_ProductGroupAttribute::STATUS_ENABLE),'displayorder','ASC',0);
        $newrelProductAttributes = array();
        $newProductGroupAttributes = array();
        $newProductAttributes = array();
        if(!empty($productGroupAttributes))
        {
            foreach($productGroupAttributes as $gattr)
            {
                $newProductGroupAttributes[$gattr->id] = $gattr;
                $arrInarray[] = $gattr->id;
            }
            $productAttributes = Core_ProductAttribute::getProductAttributes(array('fpgaidarr'=>$arrInarray,'fstatus'=>Core_ProductAttribute::STATUS_ENABLE),'displayorder','ASC',0);


            if(!empty($productAttributes))
            {
                $arrInarray = array();
                foreach($productAttributes as $attr)
                 {
                     $newProductAttributes[$attr->pgaid][$attr->id] = $attr;
                     $arrInarray[] = $attr->id;
                 }
                 $relProductAttributes = Core_RelProductAttribute::getRelProductAttributes(array('fpaidarr'=>$arrInarray,'fpid'=>$myProduct->id),'','',0);
                if(!empty($relProductAttributes))
                {
                    foreach($relProductAttributes as $relPro)
                    {
                        $newrelProductAttributes[$relPro->paid][$relPro->pid] = $relPro;
                    }
                }
            }

        }

        if(!empty($newProductGroupAttributes) && !empty($newProductAttributes) && !empty($newrelProductAttributes))
        {
            $attrOutput = '';
            foreach($newProductGroupAttributes as $groupattributes)
            {
                if(!empty($newProductAttributes[$groupattributes->id]))
                {
                    $attrOutput .= $groupattributes->name . ' ';
                    foreach ($newProductAttributes[$groupattributes->id] as $attribute)
                    {
                        if (!empty($newrelProductAttributes[$attribute->id][$myProduct->id]) && trim($newrelProductAttributes[$attribute->id][$myProduct->id]->value)!='-')
                        {
                            $attrOutput .= $newrelProductAttributes[$attribute->id][$myProduct->id]->value . ' ';
                        }
                    }
                }
            }
            if(!empty($attrOutput)) $contentoutput .= $attrOutput."\n";
        }

        $this->content = $contentoutput;

        $myProductIndex = new Core_Backend_Productindex($myProduct->id);
        $stmt = false;
        if($myProductIndex->pid > 0)
        {
            $sql = 'UPDATE ' . TABLE_PREFIX . 'productindex
                SET p_barcode = ?,
                    pc_id = ?,
                    pi_title = ?,
                    pi_content = ?,
                    pi_onsitestatus = ?,
                    pi_datemodified = ?
                WHERE p_id = ?';

            $stmt = $this->db3->query($sql, array(
                    (string)$this->pbarcode,
                    (int)$this->pcid,
                    (string)$this->title,
                    (string)$this->content,
                    (int)$this->onsitestatus,
                    (int)$this->datemodified,
                    (int)$this->pid
                    ));
        }
        else
            $stmt = $this->addData();

        if($stmt)
            return true;
        else
            return false;
    }

    /**
     * Get the object data base on primary key
     * @param int $id : the primary key value for searching record.
     */
    public function getData($pid)
    {
        $pid = (int)$pid;
        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productindex p
                WHERE p.p_id = ?';
        $row = $this->db3->query($sql, array($pid))->fetch();

        $this->pid = $row['p_id'];
        $this->pbarcode = $row['p_barcode'];
        $this->pcid = $row['pc_id'];
        $this->title = $row['pi_title'];
        $this->content = $row['pi_content'];
        $this->datemodified = $row['pi_datemodified'];

    }

    /**
     * Delete current object from database, base on primary key
     *
     * @return int the number of deleted rows (in this case, if success is 1)
     */
    public function delete()
    {
        $sql = 'DELETE FROM ' . TABLE_PREFIX . 'productindex
                WHERE  = ?';
        $rowCount = $this->db3->query($sql, array($this->pid))->rowCount();

        return $rowCount;
    }

    /**
     * Count the record in the table base on condition in $where
     *
     * @param string $where: the WHERE condition in SQL string.
     */
    public static function countList($where)
    {
        $db3 = self::getDb();

        $sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productindex p';

        if($where != '')
            $sql .= ' WHERE ' . $where;

        return $db3->query($sql)->fetchColumn(0);
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
        $db3 = self::getDb();

        $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'productindex p';

        if($where != '')
            $sql .= ' WHERE ' . $where;

        if($order != '')
            $sql .= ' ORDER BY ' . $order;

        if($limit != '')
            $sql .= ' LIMIT ' . $limit;

        $outputList = array();
        $stmt = $db3->query($sql);
        while($row = $stmt->fetch())
        {
            $myProductindex = new Core_Backend_Productindex();

            $myProductindex->pid = $row['p_id'];
            $myProductindex->pbarcode = $row['p_barcode'];
            $myProductindex->pcid = $row['pc_id'];
            $myProductindex->title = $row['pi_title'];
            $myProductindex->content = $row['pi_content'];
            $myProductindex->datemodified = $row['pi_datemodified'];


            $outputList[] = $myProductindex;
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
    public static function getProductindexs($formData, $sortby, $sorttype, $limit = '', $countOnly = false)
    {
        $whereString = '';


        if($formData['fpid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_id = '.(int)$formData['fpid'].' ';

        if($formData['fpcid'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pc_id = '.(int)$formData['fpcid'].' ';

        if($formData['fpbarcode'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.p_barcode = "'.(string)$formData['fpbarcode'].'" ';

        if($formData['ftitle'] > 0)
            $whereString .= ($whereString != '' ? ' AND ' : '') . 'p.pi_title = "'.(string)$formData['ftitle'].'" ';




        //checking sort by & sort type
        if($sorttype != 'DESC' && $sorttype != 'ASC')
            $sorttype = 'DESC';


        if($sortby == 'pid')
            $orderString = 'p_id ' . $sorttype;
        elseif($sortby == 'title')
            $orderString = 'pi_title ' . $sorttype;
        else
            $orderString = ' ' . $sorttype;

        if($countOnly)
            return self::countList($whereString);
        else
            return self::getList($whereString, $orderString, $limit);
    }

	public static function fetchall()
	{
		global $db;
		$db3 = self::getDb();

		$successcount = 0;

        $totalRecord = $db->query('SELECT count(*) FROM '. TABLE_PREFIX . 'product WHERE p_customizetype = ? AND p_status != ?', array(Core_Product::CUSTOMIZETYPE_MAIN, Core_Product::STATUS_DELETED))->fetchColumn(0);
        $recordperpage = 500;
        $totalPage = ceil($totalRecord / $recordperpage);
        for($i = 0; $i < $totalPage; $i++ )
        {
            $offset = $i * $recordperpage;
            $sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product
                    WHERE p_customizetype = ? AND p_status != ?
                ORDER BY p_id ASC LIMIT ' . $offset . ', ' . $recordperpage;

            $stmt = $db->query($sql , array(Core_Product::CUSTOMIZETYPE_MAIN, Core_Product::STATUS_DELETED));
            while($row = $stmt->fetch())
            {
                $myProductindex = new Core_Backend_Productindex();
                $myProductindex->pid = $row['p_id'];
                if($myProductindex->updateData())
                    $successcount++;
            }
        }
		return $successcount;
	}
}