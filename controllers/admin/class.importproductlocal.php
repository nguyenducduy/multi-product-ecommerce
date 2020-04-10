<?php

Class Controller_Admin_Importproductlocal Extends Controller_Admin_Base
{
    public function indexAction(){  }

    public function importAttributeValue2Action()
    {

		set_time_limit(0);

		//CLEAR FOR TESTING
		//$this->registry->db->query('TRUNCATE TABLE  `lit_rel_product_attribute`');


		echo '<!DOCTYPE html>
		<html lang="en">
		  <head>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">

				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<body><h1>IMPORT PRODUCT ATTRIBUTE</h1>';

		$db2 = new MyPDO('mysql:host=localhost;dbname=TGDD_NEWS', 'root', 'root');
		$db2->query('SET NAMES utf8');
		$this->registry->db2 = $db2;

		$timer = new Timer();
		$timer->start();


		//SELECT ALL PRODUCT FROM DIENMAY
		$sql = 'SELECT p_id, p_name FROM ' . TABLE_PREFIX . 'product WHERE p_id = 57366 ORDER BY p_id ASC';
		$stmtvdt = $this->registry->db->query($sql);
		while($rowvdt = $stmtvdt->fetch())
		{
			$productId = $rowvdt['p_id'];

			echo '<h2>' . $productId . ' - '.$rowvdt['p_name'].'</h2>';

			$sql_ = 'SELECT g.pga_name, a.pa_name,  d.PROPERTYID, d.PRODUCTID, d.VALUE
					FROM PRODUCT_DETAIL d
					INNER JOIN lit_product_attribute a ON d.PROPERTYID = a.pa_id
					INNER JOIN lit_product_group_attribute g ON g.pga_id = a.pga_id
					WHERE LANGUAGEID = "vi-VN"
					AND PRODUCTID = '.$productId.'
					ORDER BY pga_displayorder, pa_displayorder
					LIMIT 1000';

	        $listprovalues = $this->registry->db2->query($sql_);
	        if(!empty($listprovalues))
	        {
	            //foreach($listprovalues as $proval)
	            while($proval = $listprovalues->fetch())
	            {
					echo '<hr /><h4>' . $proval['pga_name'] . ' | ' . $proval['pa_name'] . '('.$proval['PROPERTYID'].') | ';

	                $chckProductatt = $this->registry->db->query('SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'rel_product_attribute WHERE pa_id=? AND p_id=?',array((int)$proval['PROPERTYID'],(int)$proval['PRODUCTID']))->fetchColumn(0);	//0.07ms
	                $valueinsert = '';
	                $strweight = array();
                    //Neu chua co thong tin, thi tien hanh them
	                if($chckProductatt == 0)
	                {
	                    $strvalue = array();
	                    if(!empty($proval['VALUE']))
	                    {
	                        $val = explode(',',trim($proval['VALUE']));
	                        $num = count($val);
	                        if($num > 1)
	                        {
	                            for($i=0; $i< $num; $i++)
	                            {
	                                $val[$i] = trim($val[$i]);

	                                if(empty($val[$i]))
									{
										unset($val[$i]);
									}
	                                elseif(!empty($val[$i]) && !isMyInteger($val[$i]))
									{
	                                    $val = array();
	                                    $valueinsert = $proval['VALUE'];
	                                    break;
	                                }
	                            }


	                            if(!empty($val) && count($val) > 0)
	                            {

									$sqltext = 'SELECT PROPERTYID,VALUE,VALUEID,COMPAREVALUE FROM PRODUCT_PROPVALUE WHERE VALUEID IN ('.implode(',',$val).')';

	                                $getValue = $this->registry->db2->query($sqltext);

	                                if(!empty($getValue))
	                                {
	                                    //foreach($getValue as $val2222)
	                                    while($val2222 = $getValue->fetch())
	                                    {
	                                        if(!empty($val2222['VALUE']))
	                                        {
	                                            $strvalue[]= $val2222['VALUE'];
	                                        }

	                                        $strweight[] = $val2222['VALUE'];
	                                    }
	                                }
	                                $valueinsert = implode(',',$strvalue);

	                            }
	                        }
	                        else
							{
	                                if(isMyInteger($proval['VALUE']))
	                                {
	                                    $getValue = $this->registry->db2->query('SELECT PROPERTYID,VALUE,VALUEID,COMPAREVALUE FROM PRODUCT_PROPVALUE WHERE VALUEID = '.$proval['VALUE'].' AND PROPERTYID='.$proval['PROPERTYID'])->fetch();
	                                    if(!empty($getValue) && $getValue['VALUE'])
	                                    {
	                                        $valueinsert = $getValue['VALUE'];
	                                        $strweight[] = $getValue['COMPAREVALUE'];
	                                    }
	                                    else
											$valueinsert = $proval['VALUE'];	//lay con so lam value
	                                }
	                                else //neu la String binh thuong, thi la value bthuong
									{
	                                    $valueinsert = $proval['VALUE'];
	                                }
	                            }
	                    }

	                    //Trường hợp value có 2 dấy phẩy mà rỗng thì lấy language là us
	                    if(empty($valueinsert))
	                    {
	                        $getEnglish = $this->registry->db2->query('SELECT d.* FROM PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'en-US\' AND PRODUCTID = '.$productId.' AND VALUE is not null AND PROPERTYID = '.$proval['PROPERTYID'].'')->fetch();

	                        if(!empty($getEnglish) && !empty($getEnglish['VALUE']))
	                        {
	                            $val = explode(',',trim($getEnglish['VALUE']));
	                            $num = count($val);
	                            if($num > 1)
	                            {
	                                for($i=0; $i< $num; $i++)
	                                {
	                                    //if(empty($val[$i])) unset($val[$i]);
	                                    //if(!empty(trim($val[$i])) && !is_numeric(trim($val[$i]))) {
	                                    $val[$i] = trim($val[$i]);
	                                    if(empty($val[$i])) unset($val[$i]);
	                                    elseif(!empty($val[$i]) && !isMyInteger($val[$i])) {
	                                        $val = '';
	                                        $valueinsert = $proval['VALUE'];
	                                        break;
	                                    }
	                                }
	                                if(!empty($val) && count($val) > 0)
	                                {
	                                    $getValue = $this->registry->db2->query('SELECT PROPERTYID,VALUE,VALUEID,COMPAREVALUE FROM PRODUCT_PROPVALUE WHERE VALUEID IN ('.implode(',',$val).')');

	                                    if(!empty($getValue))
	                                    {
	                                        //foreach($getValue as $val2222)
	                                        while($val2222 = $getValue->fetch())
	                                        {
	                                            if(!empty($val2222['VALUE']))
	                                            {
	                                                $strvalue[]= $val2222['VALUE'];
	                                                $strweight[] = $val2222['COMPAREVALUE'];
	                                            }
	                                        }
	                                    }
	                                    $valueinsert = implode(',',$strvalue);
	                                }
	                            }
	                            else
								{
	                                if(isMyInteger($getEnglish['VALUE']))
	                                {
	                                    $getValue = $this->registry->db2->query('SELECT PROPERTYID,VALUE,VALUEID,COMPAREVALUE FROM PRODUCT_PROPVALUE WHERE VALUEID = '.$getEnglish['VALUE'].' AND PROPERTYID='.$proval['PROPERTYID'])->fetch();
	                                    if(!empty($getValue) && $getValue['VALUE'])
	                                    {
	                                        $valueinsert = $getValue['VALUE'];
	                                        $strweight[] = $getValue['COMPAREVALUE'];
	                                    }
	                                    else $valueinsert = $getEnglish['VALUE'];
	                                }
	                                else{
	                                    $valueinsert = $getEnglish['VALUE'];
	                                }
	                            }
	                        }
	                    }

	                    if(!empty($valueinsert))
	                    {
							echo $valueinsert . '</h4>';
	                        $sql2 = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_attribute (p_id,pa_id,rpa_value,rpa_weight,rpa_valueseo) VALUES(?,?, ?,?,?)';

	                        $rowCount = $this->registry->db->query($sql2, array(
						(int)$proval['PRODUCTID'],
						(int)$proval['PROPERTYID'],
						(string)$valueinsert,
						(int)(count($strweight)==1?$strweight[0]:''),
						Helper::codau2khongdau((string)$valueinsert,true,true)))->rowCount();

				//echo $valueinsert;
	                        //file_put_contents('uploads/importproductattributes2.txt', $iiii);
	                        //echo '<p>'.$proval['PRODUCTID'].' -- '.$proval['PROPERTYID'].' -- '.$valueinsert.'</p>';
	                    }
	                }
	            }
	        }


		}




		$timer->stop();
		echo '<br />Executive Time: '. $timer->get_exec_time();
    }

    //Ko xai
    function importProductAttributesAction(){
        $attributes = $this->registry->db2->query('SELECT g.GROUPID, gl.GROUPNAME, g.CATEGORYID, g.DISPLAYORDER, g.ISACTIVED FROM PRODUCT_PROPGRP g INNER JOIN PRODUCT_PROPGRP_LANG gl ON g.GROUPID = gl.GROUPID WHERE LANGUAGEID LIKE \'vi_VN\'');
        if(!empty($attributes)){

            //foreach($attributes as $attr){
            while($attr = $attributes->fetch()){

                //check category
                $category = $this->registry->db2->query('SELECT c.CATEGORYID FROM PRODUCT_CATEGORY_SITE cs INNER JOIN PRODUCT_CATEGORY c ON cs.CATEGORYID = c.CATEGORYID WHERE cs.SITEID = 3 AND c.CATEGORYID = '.(int)$attr['CATEGORYID'])->fetch();
                if(!empty($category)){
                    //import product attr group
                    $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_group_attribute (u_id,pc_id,pga_id,pga_name,pga_displayorder,pga_status, pga_datecreated)
                    VALUES(?, ?, ?,?, ?, ?,?)';
                    $rowCount = $this->registry->db->query($sql, array(
                        1,
                        (string)$attr['CATEGORYID'],
                        (string)($attr['GROUPID']),
                        (string)$attr['GROUPNAME'],
                        (string)$attr['DISPLAYORDER'],
                        (string)$attr['ISACTIVED'],
                        (int)time()
                        ))->rowCount();
                    //List product properties
                    $properties = $this->registry->db2->query('SELECT g.PROPERTYID, g.PROPERTYNAME, g.ISACTIVED,DISPLAYORDER FROM PRODUCT_PROP g INNER JOIN PRODUCT_PROP_LANG gl ON g.PROPERTYID = gl.PROPERTYID WHERE  LANGUAGEID LIKE \'vi_VN\' AND g.GROUPID = '.(int)$attr['GROUPID']);
                    if(!empty($properties)){
                        //foreach($properties as $prop){
                        while($prop = $properties->fetch()){
                            $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_attribute (u_id,pga_id,pc_id,pa_id,pa_name,pa_displayorder, pa_status,pa_datecreated)
                            VALUES(?, ?, ?,?, ?, ?,?,?)';
                            $rowCount = $this->registry->db->query($sql, array(
                                1,
                                (int)$attr['GROUPID'],
                                (int)($attr['CATEGORYID']),
                                (string)$prop['PROPERTYID'],
                                (string)$prop['PROPERTYNAME'],
                                (int)$prop['DISPLAYORDER'],
                                (int)$prop['ISACTIVED'],
                                (int)time()
                                ))->rowCount();
                                echo $prop['PROPERTYNAME'].'<br />';
                        }
                    }
                }
            }
        }
    }


    public function importVendorAction(){
        $vendors = $this->registry->db2->query('SELECT DISTINCT m.MANUFACTURERNAME FROM PRODUCT_MANU m');//' INNER JOIN PRODUCT_MANU_SEO ms ON m.MANUFACTURERID = ms.MANUFACTURERID');
        if(!empty($vendors)){
            //foreach($vendors as $ven){
            while($ven = $vendors->fetch()){

                if(empty($ven['MANUFACTURERNAME']) || trim($ven['MANUFACTURERNAME'])=='-')
                $searchvendor = $this->registry->db->query('SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_name =?',array((string)trim($ven['MANUFACTURERNAME'])))->fetch();
                if(!empty($searchvendor)) continue;

                $sql = 'INSERT INTO ' . TABLE_PREFIX . 'vendor (v_name,v_slug,v_datecreated)
                    VALUES(?, ?, ?)';
                    $rowCount = $this->registry->db->query($sql, array(
                        (string)$ven['MANUFACTURERNAME'],
                        (string)Helper::codau2khongdau($ven['MANUFACTURERNAME'],true,true),
                        (int)time()
                        ))->rowCount();
                    echo '<br />'.$ven['MANUFACTURERNAME'];
                    //$idven = $this->registry->db->lastInsertId();
//                    if(!empty($idven)){
//
//                    }
            }
        }
    }

    private function getRefProductId($barcode)
    {
        $productIdRef = 0;
        $sql = 'SELECT PRODUCTIDREF FROM PM_PRODUCT
                WHERE PRODUCTID = \'' . (string)$barcode . '\'';

        $stmt = $this->registry->db2->query($sql)->fetch();
        if(empty($stmt)) return false;
        $productIdRef = (int)$stmt['PRODUCTIDREF'];

        return $productIdRef;
    }

    public function importProductColorAction()
    {
        $sql = 'SELECT * FROM PRODUCT_COLOR';

        $result = $this->registry->db2->query($sql);

        //foreach($result as $res)
        while($res = $result->fetch())
        {
            $myProductColor = new Core_Productcolor();
            $myProductColor->name = $res['COLORNAME'];
            $myProductColor->code = $res['COLORCODE'];
            $myProductColor->status = Core_Productcolor::STATUS_ENABLE;
            if($myProductColor->addData())
                echo $myProductColor->code . ' <i> inserted</i>';
            else
                echo $myProductColor->code . ' <i> not inserted</i>';
        }

    }

	/*
    public function importGalleryAction()
    {
        $recordPerPage = 500;
        $total = $this->registry->db2->query('SELECT count(*) FROM PRODUCT_GALLERY')->fetchColumn(0);

        $page = ceil($total/$recordPerPage);
        $listextensionimage = array('jpg','jpeg','gif','png');
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($getAllGalleriesRow);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage;// * $i;
            $listGalleries = $this->registry->db2->query('SELECT g.* FROM PRODUCT_GALLERY g WHERE PRODUCTID>0 ORDER BY PRODUCTID DESC LIMIT '.$start.', '.$end);
            if(!empty($listGalleries))
            {
                foreach($listGalleries as $gal)
                {
                    if(!empty($gal['PICTURE']))
                    {
                        //check product exists in product table
                        $getProduct = new Core_Product($gal['PRODUCTID']);//Core_Product::getProducts(array('fid'=>$gal['PRODUCTID']),'','',1);

                        if(!empty($getProduct->id))
                        {
                            $fileurl = 'http://dienmay.myhost/Products/Images/'.$getProduct->pcid.'/'.$getProduct->id.'/'.str_replace(' ','%20',$gal['PICTURE']);
                            $getpathinfo = pathinfo($fileurl);
                            if(!empty($getpathinfo['extension']) && in_array($getpathinfo['extension'],$listextensionimage)){
                                $myProductMedia = new Core_ProductMedia();
                                $myProductMedia->uid = 1;
                                $myProductMedia->pid = $gal['PRODUCTID'];
                                $myProductMedia->type = Core_ProductMedia::TYPE_FILE;
                                $myProductMedia->fileurl = $fileurl;

                                $myProductMedia->caption = $gal['DESCRIPTION'];
                                $myProductMedia->displayorder = $gal['DISPLAYORDER'];
                                $myProductMedia->status = $gal['ISACTIVED'];
                                if($myProductMedia->addData())
                                {
                                    echo '<br />I: '.$i.' PRODUCTID: '.$gal['PRODUCTID'];
                                    file_put_contents('uploads/gallery.txt', 'I: '.$i.' PRODUCTID: '.$gal['PRODUCTID']);
                                }
                            }
                        }
                    }
                }
            }
        }
        die();
    }
	*/

	public function importGalleryAction()
    {
		die('disabled');
		set_time_limit(0);
		$db2 = new MyPDO('mysql:host=localhost;dbname=TGDD_NEWS', 'root', 'root');
		$db2->query('SET NAMES utf8');
		$this->registry->db2 = $db2;

		//SELECT ALL PRODUCT FROM DIENMAY
		$sql = 'SELECT p_id, pc_id FROM ' . TABLE_PREFIX . 'product ORDER BY p_id DESC';
		$stmtvdt = $this->registry->db->query($sql);
		while($rowvdt = $stmtvdt->fetch())
		{
			$productId = $rowvdt['p_id'];

			//Get all gallery image
			$listGalleries = $this->registry->db2->query('SELECT g.* FROM PRODUCT_GALLERY g WHERE PRODUCTID = '.$productId.' AND ISACTIVED = 1 AND ISDELETED = 0 ORDER BY DISPLAYORDER ASC');
			while($gal = $listGalleries->fetch())
			{
				$path = $rowvdt['pc_id'].'/'.$productId.'/'.str_replace(' ','%20',$gal['PICTURE']);

				$myProductMedia = new Core_ProductMedia();
                $myProductMedia->uid = 1;
                $myProductMedia->pid = $productId;
                $myProductMedia->type = Core_ProductMedia::TYPE_FILE;
                $myProductMedia->file =  $path;
                $myProductMedia->status = Core_ProductMedia::STATUS_ENABLE;
                if($myProductMedia->addData())
                {
                    //ok
                }
			}
		}

    }


	public function importGallery360Action()
    {
		die('disabled');
		set_time_limit(0);
		$db2 = new MyPDO('mysql:host=localhost;dbname=TGDD_NEWS', 'root', 'root');
		$db2->query('SET NAMES utf8');
		$this->registry->db2 = $db2;

		//SELECT ALL PRODUCT FROM DIENMAY
		$sql = 'SELECT p_id, pc_id FROM ' . TABLE_PREFIX . 'product ORDER BY p_id DESC';
		$stmtvdt = $this->registry->db->query($sql);
		while($rowvdt = $stmtvdt->fetch())
		{
			$productId = $rowvdt['p_id'];

			//Get all 360 image
			$listGalleries = $this->registry->db2->query('SELECT g.* FROM PRODUCT_GALLERY_360 g WHERE PRODUCTID = '.$productId.' AND ISACTIVED = 1 AND ISDELETED = 0 ORDER BY DISPLAYORDER ASC');
			while($gal = $listGalleries->fetch())
			{
				$path = $rowvdt['pc_id'].'/'.$productId.'/'.str_replace(' ','%20',$gal['PICTURE']);

				$myProductMedia = new Core_ProductMedia();
                $myProductMedia->uid = 1;
                $myProductMedia->pid = $productId;
                $myProductMedia->type = Core_ProductMedia::TYPE_360;
                $myProductMedia->file =  $path;
                $myProductMedia->caption = $gal['DESCRIPTION'];
                $myProductMedia->status = Core_ProductMedia::STATUS_ENABLE;
                if($myProductMedia->addData())
                {
                    //ok
                }
			}
		}

    }

	/*
    public function importGallery360Action()
    {
        $recordPerPage = 500;
        $total = $this->registry->db2->query('SELECT count(*) FROM PRODUCT_GALLERY_360')->fetchColumn(0);

        $page = ceil($total/$recordPerPage);
        $listextensionimage = array('jpg','jpeg','gif','png');
        for($i = 1 ; $i <= $page ; $i++)
        {
            unset($getAllGalleriesRow);

            set_time_limit(0);
            $start = ($recordPerPage * $i) - $recordPerPage;
            $end = $recordPerPage;// * $i;

            $listGalleries = $this->registry->db2->query('SELECT g.* FROM PRODUCT_GALLERY_360 g ORDER BY PRODUCTID DESC LIMIT '.$start.', '.$end);
            if(!empty($listGalleries))
            {
                //foreach($listGalleries as $gal)
                while($gal = $listGalleries->fetch())
                {
                    if(!empty($gal['PICTURE']))
                    {
                        //check product exists in product table
                        $getProduct = new Core_Product($gal['PRODUCTID']);//Core_Product::getProducts(array('fid'=>$gal['PRODUCTID']),'','',1);
                        if(!empty($getProduct->id))
                        {
                            $fileurl = 'http://dienmay.myhost/Products/Images/'.$getProduct->pcid.'/'.$getProduct->id.'/'.str_replace(' ','%20',$gal['PICTURE']);
                            $explode = explode(' ',$gal['PICTURE']);
                            $getpathinfo = pathinfo($fileurl);
                                if(!empty($getpathinfo['extension']) && in_array($getpathinfo['extension'],$listextensionimage)){
                                    $myProductMedia = new Core_ProductMedia();
                                    $myProductMedia->uid = 1;
                                    $myProductMedia->pid = $gal['PRODUCTID'];
                                    $myProductMedia->type = Core_ProductMedia::TYPE_360;
                                    $myProductMedia->fileurl =  $fileurl;

                                    $myProductMedia->caption = $gal['DESCRIPTION'];
                                    $myProductMedia->displayorder = $gal['DISPLAYORDER'];
                                    $myProductMedia->status = $gal['ISACTIVED'];
                                    if($myProductMedia->addData())
                                    {
                                        echo '<br />I: '.$i.' PRODUCTID: '.$gal['PRODUCTID'];
                                        file_put_contents('uploads/gallery360.txt', 'I: '.$i.' PRODUCTID: '.$gal['PRODUCTID']);
                                    }
                                }

                        }
                    }
                }
            }
        }
        die();
    }
*/

    public function synproducthaveclob2Action()
    {
        $oracle = new Oracle();
        //$offset = 0; $limit = 500;
        $recordperpage = 100;
        $totalNumber = $oracle->query('SELECT count(*) as NUM FROM TGDD_NEWS.PRODUCT p WHERE p.PRODUCTID>0');
        $totalNumber = $totalNumber[0]['NUM'];

        $totalPage = ceil($totalNumber/$recordperpage);// $_SESSION['fdfd'];
        set_time_limit(0);
        $startrun = 38;
        for($i=$startrun; $i<$totalPage; $i++ ){
            $offset = $i*$recordperpage;
            $limit += $offset;
            //echo 'SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'';
            $products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
            if(!empty($products))
            {
                foreach($products as $pro)
                {
                    $general = (!empty($pro['GENERAL'])?$pro['GENERAL']->load():$pro['GENERAL']);
                    $description = (!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']->load():$pro['HTMLDESCRIPTION']);
                    if(!empty($general) || !empty($description))
                    {
                        $this->registry->db2->query('UPDATE PRODUCT SET GENERAL = ?, HTMLDESCRIPTION = ? WHERE PRODUCTID = ?',
                                                array($general, $description, $pro['PRODUCTID'])
                                                );
                    }
                    file_put_contents('uploads/synproducthaveclobAction.txt', $pro['PRODUCTID']. ' -- '. $i);
                    echo '<p>'.$pro['PRODUCTID']. '   '.$description.'</p>';
                }
                //exit();
            }
            //sleep(3);
            //break;
        }
    }

    public function synproductslugAction()
    {
        $oracle = new Oracle();
        //$offset = 0; $limit = 500;
        $recordperpage = 100;
        $totalNumber = $oracle->query('select count(*) FROM TGDD_NEWS.product_language WHERE URL is not null OR URL !=\'\' AND LANGUAGEID = \'vi-VN\'');
        $totalNumber = $totalNumber[0]['NUM'];

        $totalPage = ceil($totalNumber/$recordperpage);// $_SESSION['fdfd'];
        set_time_limit(0);
        $startrun = 0;
        for($i=$startrun; $i<$totalPage; $i++ ){
            $offset = $i*$recordperpage;
            $limit  += $offset;
            //echo 'SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'';
            $products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.URL FROM TGDD_NEWS.product_language WHERE URL is not null OR URL !=\'\' AND LANGUAGEID = \'vi-VN\' AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
            if(!empty($products))
            {
                foreach($products as $pro)
                {
                    if(!empty($pro['URL']))
                    {
                        $this->registry->db2->query('UPDATE PRODUCT SET URL = ? WHERE PRODUCTID = ?',
                                                array($pro['URL'], $pro['PRODUCTID'])
                                                );
                        echo '<p>'.$pro['PRODUCTID']. '   '.$pro['URL'].'</p>';
                        file_put_contents('uploads/synproductslugAction.txt', $pro['PRODUCTID']. ' -- '. $i);
                    }
                }
                //exit();
            }
            //sleep(3);
            //break;
        }
    }

    public function synproductsdescriptionlangAction()
    {
        $oracle = new Oracle();
        //$offset = 0; $limit = 500;
        $recordperpage = 100;
        $totalNumber = $oracle->query('select count(*) FROM TGDD_NEWS.product_language WHERE htmldescription is not null AND LANGUAGEID = \'vi-VN\'');
        $totalNumber = $totalNumber[0]['NUM'];

        $totalPage = ceil($totalNumber/$recordperpage);// $_SESSION['fdfd'];
        set_time_limit(0);
        $startrun = 0;
        for($i=$startrun; $i<$totalPage; $i++ ){
            $offset = $i*$recordperpage;
            $limit += $offset;
            //echo 'SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'';
            $products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.htmldescription FROM TGDD_NEWS.product_language p WHERE htmldescription is not null AND LANGUAGEID = \'vi-VN\' AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
            if(!empty($products))
            {
                foreach($products as $pro)
                {

                    if(!empty($pro['GENERAL']) && !empty($pro['HTMLDESCRIPTION']))
                    {
                        $general = $pro['GENERAL']->load();
                        $description = $pro['HTMLDESCRIPTION']->load();
                        $this->registry->db2->query('UPDATE PRODUCT SET GENERAL = ?, HTMLDESCRIPTION = ? WHERE PRODUCTID = ?',
                                                array($general, $description, $pro['PRODUCTID'])
                                                );
                    }
                    file_put_contents('uploads/synproductsdescriptionlangAction.txt', $pro['PRODUCTID']. ' -- '. $i);
                    echo '<p>'.$pro['PRODUCTID']. '   '.$description.'</p>';
                }
                //exit();
            }
            sleep(3);
            //break;
        }
    }


    public function synproducthaveclobAction()
    {
        $oracle = new Oracle();
        //$offset = 0; $limit = 500;
        $recordperpage = 100;
        //$totalNumber = $oracle->query('SELECT count(*) as NUM FROM TGDD_NEWS.PRODUCT p WHERE p.PRODUCTID>0');
        $totalNumber = 19814;//$totalNumber[0]['NUM'];

        $totalPage = ceil($totalNumber/$recordperpage);// $_SESSION['fdfd'];
        set_time_limit(0);
        $startrun = 38;
        for($i=$startrun; $i<$totalPage; $i++ ){
            $offset = $i*$recordperpage;
            $limit = $recordperpage + $offset ;
            echo 'SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'';
            //exit('HELLO');
            $products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID ,rownum rnum, p.HTML, p.GENERAL,p.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
            //echodebug($products, true);
            if(!empty($products))
            {
                foreach($products as $pro)
                {
                    $general = (!empty($pro['GENERAL'])?$pro['GENERAL']->load():$pro['GENERAL']);
                    $description = (!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']->load():$pro['HTMLDESCRIPTION']);
                    if(!empty($general) || !empty($description))
                    {
                        $this->registry->db2->query('UPDATE PRODUCT SET GENERAL = ?, HTMLDESCRIPTION = ? WHERE PRODUCTID = ?',
                                                array($general, $description, $pro['PRODUCTID'])
                                                );
                    }
                    file_put_contents('uploads/synproducthaveclobAction.txt', $pro['PRODUCTID']. ' -- '. $i);
                    echo '<p>'.$pro['PRODUCTID']. '   '.$description.'</p>';
                }
                //exit();
            }
            //sleep(3);
            //break;
        }
    }



	    public function importProductsAction(){
			$db2 = new MyPDO('mysql:host=localhost;dbname=TGDD_NEWS', 'root', 'root');
			$db2->query('SET NAMES utf8');
			$this->registry->db2 = $db2;

	        $offset = 0; $limit = 500;
	        $totalNumber = $this->registry->db2->query('SELECT count(*) as NUM FROM PRODUCT p WHERE p.PRODUCTID>57440')->fetchColumn(0);
	        //$totalNumber = $totalNumber[0]['NUM'];

	        $totalPage = ceil($totalNumber/500);// $_SESSION['fdfd'];
	        unset($_SESSION['runningpage']);//return;
	        set_time_limit(0);
	        $startrun = (!empty($_SESSION['runningpage'])?$_SESSION['runningpage']:0);

	        for($i=$startrun; $i<$totalPage; $i++ ){
	            $_SESSION['runningpage'] = $i;
	            $offset = $i*$limit;
	            $this->loopProduct($offset, $limit);
	            //break;
	        }
	        if($i==($totalPage-1)) {
	            unset($_SESSION['runningpage']);
	            return;
	        }
	    }

	    public function loopProduct($offset, $limit){
			$db2 = new MyPDO('mysql:host=localhost;dbname=TGDD_NEWS', 'root', 'root');
			$db2->query('SET NAMES utf8');
			$this->registry->db2 = $db2;

			$sql = 'SELECT p.PRODUCTID, p.ISHOT, p.ISNEW, p.ISSPECIAL , p.MANUFACTURERID, p.CATEGORYID, p.GROUPID, p.BIMAGE, p.ISACTIVED, p.PRODUCTCODE, p.URL, p.HTML, p.GENERAL, p.PRODUCTNAME, p.DESCRIPTION, p.METAKEYWORD, p.METATITLE, p.METADESCRIPTION,p.HTMLDESCRIPTION, p.KEYWORD
	FROM PRODUCT p WHERE p.PRODUCTID>57440 ORDER BY PRODUCTID DESC LIMIT '.$offset.','.$limit.'';

	        $products = $this->registry->db2->query($sql);


	        $ct=0;echo '<p>Offset: '.$offset.'</p>';
	        if(!empty($products))
			{
	            $listextensionimage = array('jpg','jpeg','gif','png');
	            //foreach($products as  $pro){
	            while($pro = $products->fetch())
				{

	                $objProduct = new Core_Product();
	                $checkobjProduct = new Core_Product((int)$pro['PRODUCTID']);
	                //if((int)$objProduct->id) continue;

	                if((int)$checkobjProduct->id <=0 && !empty($pro['KEYWORD']))
	                {
	                    $explodekeywor = explode(',',$pro['KEYWORD']);
	                    if(!empty($explodekeywor))
	                    {
	                        foreach($explodekeywor as $kw)
	                        {
	                            $getKeyword = Core_Keyword::getKeywords(array('fhash'=>md5($kw)),'','',1);
	                            if(empty($getKeyword))
	                            {
	                                $objKeyword = new Core_Keyword();
	                                $objKeyword->text = Helper::plaintext($kw);
	                                $objKeyword->slug = Helper::codau2khongdau($kw, true, true);
	                                $objKeyword->hash = md5($kw);
	                                $objKeyword->from = Core_Keyword::TYPE_PRODUCT;
	                                $objKeyword->status = Core_Keyword::STATUS_ENABLE;
	                                $objKeyword->datecreated = time();
	                                $idkeyword = $objKeyword->addData();


	                            }
	                            else
	                                $idkeyword = $getKeyword[0]->id;

	                            $relItemKeyword = new Core_RelItemKeyword();
	                                $relItemKeyword->kid = $idkeyword;
	                                $relItemKeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
	                                $relItemKeyword->objectid = (int)$pro['PRODUCTID'];
	                                $relItemKeyword->addData();
	                        }
	                    }
	                }


					$vendor = $this->registry->db2->query('SELECT DISTINCT MANUFACTURERNAME FROM PRODUCT_MANU WHERE MANUFACTURERID='.$pro['MANUFACTURERID'])->fetch();
	                //var_dump($vendor);break;
	                $vendorid = 0;
	                if(!empty($vendor)){
	                    $searchvendor = $this->registry->db->query('SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_name =?',array((string)trim($vendor['MANUFACTURERNAME'])))->fetch();
	                    $vendorid = (!empty($searchvendor['v_id'])?$searchvendor['v_id']:0);
	                }
	                $summary = htmlspecialchars_decode($pro['DESCRIPTION']);
	                if(empty($summary)){
	                    $gen = (!empty($pro['GENERAL'])?$pro['GENERAL']:'');
	                    $summary = strip_tags(substr($gen, strpos($gen,'<ul')),'<ul>,<li>');
	                }
	                $newsummary = '';
	                if(!empty($summary)){
	                    $summary = str_replace(array('<ul class="item_list" style="padding-left: 15px</li><li> margin: 0px</li><li>">','<ul class="item_list" style="padding-left: 15px; margin: 0px;">','<li><li>','</ul></ul></ul>','</ul></ul>'),'',$summary);
	                    $newsummary = Helper::xss_replacewithBreakline(preg_replace('/<[^>]*>/',"\n",$summary));
	                    $newsummary = preg_replace('/(?:\s\s+|\n|\t)/',"\n",$newsummary);
	                    //$newsummary = trim(preg_replace( '/[\s]+/mu', " ",$newsummary));
	                    if(substr($newsummary,0,1) =='-') $newsummary = trim(substr($newsummary,1));
	                    $newsummary = strip_tags($newsummary);
	                    if(!empty($newsummary) && $newsummary =='-') $newsummary = '';
	                }

	                $productimage = '';
	                if((int)$checkobjProduct->id <=0 && !empty($pro['BIMAGE'])){
	                    $getpathinfo = pathinfo('http://dienmay.myhost/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE']);
	                    if(!empty($getpathinfo['extension']) && in_array($getpathinfo['extension'],$listextensionimage)){
	                        $productimage = 'http://dienmay.myhost/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE'];
	                    }
	                }
	                if(empty($productimage)){
	                    $getProductGallery = $this->registry->db2->query('SELECT p.PICTURE FROM PRODUCT_GALLERY p WHERE p.PRODUCTID='.$pro['PRODUCTID'].' AND p.PICTURE !=\' \' AND p.PICTURE is not null LIMIT 1')->fetch();
	                    if(!empty($getProductGallery['PICTURE'])){
	                        $imageinfo = pathinfo('http://dienmay.myhost/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$getProductGallery['PICTURE']);
	                        if(!empty($imageinfo['extension']) && in_array($imageinfo['extension'],$listextensionimage)){
	                            $productimage = 'http://dienmay.myhost/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$getProductGallery['PICTURE'];
	                        }
	                    }
	                }
	                $description = (string)(!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']:'');
	                //echodebug($description, true);
	                //
	                if(!empty($description))
					{
	                        //echo '<p>DESCRIPTION : '.$pro['PRODUCTID'].': '.$description.' ---END------</p>';exit();
	                        $description = html_entity_decode(Helper::specialchar2normalchar($description));

	                        preg_match_all('@\[one_third(.*?)\](.*?)\[\/one_third]@si',$description,$list3columns, PREG_PATTERN_ORDER);
	                        //var_dump($list3columns[2]);
	                        if(!empty($list3columns[2])){
	                            foreach($list3columns[2] as $item){
	                                if(strstr($item,'Ưu điểm')){
	                                    //echo 'Ưu điểm: '.$item."\n\n";
	                                    preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
	                                    if(!empty($uudiem[0][0])){
	                                        $objProduct->good = trim($uudiem[0][0]);
	                                    }
	                                }
	                                elseif(strstr($item,'Nhược điểm')){
	                                    //echo 'Nhược điểm: '.$item."\n\n";
	                                    preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
	                                    if(!empty($uudiem[0][0])){
	                                        $objProduct->bad = trim($uudiem[0][0]);
	                                    }
	                                }
	                                else{
	                                    $dmreview = preg_replace('/\<p\>(.*?)\<\/p\>/','',$item);
	                                    $dmreview = preg_replace('/\<h2\>(.*?)\<\/h2\>/','',$dmreview);
	                                    $objProduct->dienmayreview = $dmreview;//preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);;//preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);

	                                } //echo 'OTHER: '.$item."\n\n";
	                            }
	                        }
	                        else{
	                            preg_match_all('@\[one_half(.*?)\](.*?)\[\/one_half]@si',$description,$list3columns, PREG_PATTERN_ORDER);
	                            if(!empty($list3columns[2])){
	                                foreach($list3columns[2] as $item){
	                                    if(strstr($item,'Ưu điểm')){
	                                        preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
	                                        if(!empty($uudiem[0][0])){
	                                            $objProduct->good = trim($uudiem[0][0]);
	                                        }
	                                    }
	                                    elseif(strstr($item,'Nhược điểm')){
	                                        preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
	                                        if(!empty($uudiem[0][0])){
	                                            $objProduct->bad = trim($uudiem[0][0]);
	                                        }
	                                        preg_match_all('@\<p(.*?)\>(.*?)\<\/p\>@si',$item,$getpreview);
	                                        if(!empty($getpreview[2][0])) {
	                                            $objProduct->dienmayreview = $getpreview[2][0];
	                                        }
	                                        else $objProduct->dienmayreview = preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);

	                                    }
	                                    else{
	                                        //$objProduct->dienmayreview = preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);
	                                        preg_match_all('@\<p(.*?)\>(.*?)\<\/p\>@si',$item,$getpreview);
	                                        if(!empty($getpreview[2][0])) {
	                                            $objProduct->dienmayreview = $getpreview[2][0];
	                                        }
	                                        else{
	                                            $dmreview = preg_replace('/\<p\>(.*?)\<\/p\>/','',$item);
	                                            $dmreview = preg_replace('/\<h2\>(.*?)\<\/h2\>/','',$dmreview);
	                                            $objProduct->dienmayreview = $dmreview;//preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);;//preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);
	                                            //$objProduct->dienmayreview = preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);
	                                        }
	                                    } //echo 'OTHER: '.$item."\n\n";
	                                }
	                            }
	                        }

	                        //$descriptions = preg_replace('@\[one_third(.*?)\](.*?)\[\/one_third]@si','',$description);
	                        $getContent = preg_split('@\[divider(.*?)\]@si',$description);
	                        $contentstxt = '';
	                        if(!empty($getContent))
	                        {
	                            foreach($getContent as $it)
	                            {
	                                //echo '<p>Truoc: '.$it.'</p>';
	                                $nit = preg_replace('/\[(.*?)\](.*?)\[\/(.*?)\]/','',$it);
	                                $nit = preg_replace('/\[(.*?)\]/','',$nit);
	                                //echo '<p>SAO: '.$nit.'</p>';
	                                $nit = str_replace('[br]','<br />',$nit);
	                                if($nit != '')
	                                {
	                                    $contentstxt .= $nit;
	                                }
	                            }
	                        }
	                        $objProduct->content = $contentstxt;
	                        foreach($getContent as $gc){
	                            if(!empty($gc)){
	                                if(strstr($gc,'Bộ bán hàng chuẩn') || strstr($gc,'bộ bán hàng chuẩn')){
	                                    $nit = preg_replace('/\[(.*?)\](.*?)\[\/(.*?)\]/','',$gc);
	                                    $nit = preg_replace('/\[(.*?)\]/','',$nit);
	                                    $objProduct->fullbox = str_replace('[br]','<br />', trim($nit));
	                                    break;
	                                }
	                            }
	                        }
	                    }

	                if(!empty($productimage) && Helper::isUrlOnline($productimage)){
	                    $objProduct->image=$productimage;//'http://dienmay.myhost/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE']KIEM TRA LAI DUONG DAN HINH
	                    echo $objProduct->image;
	                }

	                $objProduct->id=(int)$pro['PRODUCTID'];
	                $objProduct->uid=1;
	                $objProduct->vid=(int)$vendorid;
	                $objProduct->pcid=$pro['CATEGORYID'];
	                $objProduct->barcode=$pro['PRODUCTCODE'];


	                $objProduct->name=$pro['PRODUCTNAME'];
	                //$objProduct->slug=!empty($pro['URL']) ?$pro['URL']: Helper::codau2khongdau($pro['PRODUCTNAME'], true, true);
	                $objProduct->colorlist = 'no';
	                //$objProduct->content=(string)(!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']:'');
	                $objProduct->summary=$newsummary;
	                $objProduct->seotitle=$pro['METATITLE'];
	                $objProduct->seokeyword=$pro['METAKEYWORD'];
	                $objProduct->seodescription=$pro['METADESCRIPTION'];
	                //$objProduct->canonical=$pro['CANONICAL'];
	                //array('<ul class="item_list" style="padding-left: 15px</li><li> margin: 0px</li><li>">','<ul class="item_list" style="padding-left: 15px; margin: 0px;">','<li><li>','</ul></ul></ul>','</ul></ul>'),'',$pro->summary
	                $objProduct->isbagdehot=$pro['ISHOT'];
	                $objProduct->isbagdenew=$pro['ISNEW'];
	                //$objProduct->vendorprice=
	                //$objProduct->discountpercent=
	                $objProduct->status=$pro['ISACTIVED'];
	                //$objProduct->onsitestatus=6;
	                $objProduct->datecreated= time();

	                $slugggg = !empty($pro['URL']) ?$pro['URL']: Helper::codau2khongdau($pro['PRODUCTNAME'], true, true);

	                $checkslug = Core_Slug::getSlugs(array('fslug' => $slugggg, 'fobjectid' => (int)$pro['PRODUCTID'],'fcontroller'=>'product'),'','');
	                if(empty($checkslug))
	                {
	                    $checkslug2 = Core_Slug::getSlugs(array('fslug' => $slugggg),'','');
	                    if(!empty($checkslug2)) $objProduct->slug=$slugggg.'-a';
	                    else $objProduct->slug=$slugggg;
	                }
	                else $objProduct->slug=$slugggg;

	                if((int)$checkobjProduct->id <= 0)
					{
						//echo $objProduct->id . "\n";
						$objProduct->importProduct();
					}
	                else
					{

						$objProduct->updateData();
					}

	                //file_put_contents('importProducts.txt','OFFSET: '.$offset.' LIMIT: '.$limit.' PRODUCTID: '.$pro['PRODUCTID']);
	                //echodebug($objProduct, true);
	                echo ++$ct.'<br />';
	            }
	        }
	        //echo $ct;
	    }

}


function isMyInteger($value)
{
	return ( is_int($value) || ctype_digit($value) );
}
