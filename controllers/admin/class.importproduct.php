<?php

Class Controller_Admin_Importproduct Extends Controller_Admin_Base
{
	function indexAction(){}

	function importAttributeValue2Action()
	{   set_time_limit(0);

		$recordPerPage = 10;
		$oracle = new Oracle();
		$totalNumber = $oracle->query('SELECT count(*) AS NUM FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0');
		$totalNumber = $totalNumber[0]['NUM'];
		$totalPage = ceil($totalNumber/$recordPerPage);// $_SESSION['fdfd'];
		echo 'TOTAL NUMBER: '.$totalNumber;

		for($iiii=1; $iiii<=$totalPage; $iiii++ ){
			unset($listprovalues);

			 $start = ($recordPerPage * $iiii) - $recordPerPage;
			 $end = $recordPerPage * $iiii;
			 $sql_ = 'SELECT * FROM (SELECT d.*, rownum as r FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0 AND VALUE is not null) WHERE r > '.$start.' AND r <= '.$end;
			 echo $sql_;
			//$offset = $i*50;
			//$limit = $offset + 50;
			//echo '<br />OFFSET: '.$offset;//VALUE ID DUY NHAT
			$listprovalues = $oracle->query($sql_);
			//echodebug($sql_, true);
			//$listprovalues = $oracle->query('SELECT * FROM (SELECT d.*, rownum as nrow FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0 AND rownum<'.$limit.' AND VALUE is not null ORDER BY PRODUCTID DESC) WHERE nrow>='.$offset.' ');//ASC
			if(!empty($listprovalues))
			{
				foreach($listprovalues as $proval)
				{
					$chckProductatt = $this->registry->db->query('SELECT rpa_id FROM ' . TABLE_PREFIX . 'rel_product_attribute WHERE pa_id=? AND p_id=?',array((int)$proval['PROPERTYID'],(int)$proval['PRODUCTID']))->fetch();
					$valueinsert = '';
					if(empty($chckProductatt))
					{
						$strvalue = array();
						if(!empty($proval['VALUE']))
						{
							$val = explode(',',trim($proval['VALUE']));
							$num = count($val);
							if($num > 0)
							{
								for($i=0; $i< $num; $i++)
								{
									if(empty($val[$i])) unset($val[$i]);
								}
								if(count($val) > 0)
								{
									$getValue = $oracle->query('SELECT PROPERTYID,VALUE,VALUEID FROM TGDD_NEWS.PRODUCT_PROPVALUE WHERE VALUEID IN ('.implode(',',$val).')');

									if(!empty($getValue))
									{
										foreach($getValue as $val2222)
										{
											if(!empty($val2222['VALUE']))
											{
												$strvalue[]= $val2222['VALUE'];
											}
										}
									}
									$valueinsert = implode(',',$strvalue);
								}
							}
							else{
									if(is_numeric($proval['VALUE']))
									{
										$getValue = $oracle->query('SELECT PROPERTYID,VALUE,VALUEID FROM TGDD_NEWS.PRODUCT_PROPVALUE WHERE VALUEID = '.$proval['VALUE'].' AND PROPERTYID='.$proval['PROPERTYID']);
										if(!empty($getValue) && $getValue[0]['VALUE'])
										{
											$valueinsert = $getValue[0]['VALUE'];
										}
										else $valueinsert = $proval['VALUE'];
									}
									else{
										$valueinsert = $proval['VALUE'];
									}
								}
						}

						//Tr??ng h?p value cÃ³ 2 d?y ph?y mÃ  r?ng thÃ¬ l?y language lÃ  us
						if(empty($valueinsert))
						{
							$getEnglish = $oracle->query('SELECT d.* FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'en-US\' AND PRODUCTID>0 AND VALUE is not null');
							if(!empty($getEnglish) && !empty($getEnglish[0]['VALUE']))
							{
								$val = explode(',',trim($getEnglish[0]['VALUE']));
								$num = count($val);
								if($num > 0)
								{
									for($i=0; $i< $num; $i++)
									{
										if(empty($val[$i])) unset($val[$i]);
									}
									if(count($val) > 0)
									{
										$getValue = $oracle->query('SELECT PROPERTYID,VALUE,VALUEID FROM TGDD_NEWS.PRODUCT_PROPVALUE WHERE VALUEID IN ('.implode(',',$val).')');

										if(!empty($getValue))
										{
											foreach($getValue as $val2222)
											{
												if(!empty($val2222['VALUE']))
												{
													$strvalue[]= $val2222['VALUE'];
												}
											}
										}
										$valueinsert = implode(',',$strvalue);
									}
								}
								else{
									if(is_numeric($getEnglish[0]['VALUE']))
									{
										$getValue = $oracle->query('SELECT PROPERTYID,VALUE,VALUEID FROM TGDD_NEWS.PRODUCT_PROPVALUE WHERE VALUEID = '.$getEnglish[0]['VALUE'].' AND PROPERTYID='.$proval['PROPERTYID']);
										if(!empty($getValue) && $getValue[0]['VALUE'])
										{
											$valueinsert = $getValue[0]['VALUE'];
										}
										else $valueinsert = $getEnglish[0]['VALUE'];
									}
									else{
										$valueinsert = $getEnglish[0]['VALUE'];
									}
								}
							}
						}

						if(!empty($valueinsert))
						{
							$sql2 = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_attribute (p_id,pa_id,rpa_value,rpa_valueseo) VALUES(?, ?,?,?)';
							$rowCount = $this->registry->db->query($sql2, array((int)$proval['PRODUCTID'],(int)$proval['PROPERTYID'],(string)$valueinsert, Helper::codau2khongdau((string)$valueinsert,true,true)))->rowCount();
							echo '<p>'.$proval['PRODUCTID'].' -- '.$proval['PROPERTYID'].' -- '.$valueinsert.'</p>';
						}
					}
				}
			}
			//echo '<p>SLIEEPING 3 min</p>';
			//sleep(1800);
			//echo 'Page: '.$iiii;break;
		}
	}

	function importAttributeValueAction(){
		$oracle = new Oracle();
		$totalNumber = $oracle->query('SELECT count(*) as NUM FROM TGDD_NEWS.PRODUCT_PROPVALUE');
		$totalNumber = $totalNumber[0]['NUM'];
		$totalPage = ceil($totalNumber/300);// $_SESSION['fdfd'];
		echo 'TOTAL NUMBER: '.$totalNumber;
		set_time_limit(0);
		$startrun = (!empty($_SESSION['runningpage2'])?$_SESSION['runningpage2']:0);
		for($i=$startrun; $i<$totalPage; $i++ ){
			$_SESSION['runningpage2'] = $i;
			$offset = $i*50;
			$limit = $offset + 50;
			echo '<br />OFFSET: '.$_SESSION['runningpage2'];//VALUE ID DUY NHAT
			$listprovalues = $oracle->query('SELECT * FROM (SELECT PROPERTYID,VALUE,VALUEID,rownum as nrow FROM TGDD_NEWS.PRODUCT_PROPVALUE WHERE rownum<'.$limit.' AND VALUE is not null) WHERE nrow>='.$offset.' ');//ASC
			//'SELECT v.PROPERTYID, v.VALUE, d.PRODUCTID FROM TGDD_NEWS.PRODUCT_PROPVALUE v INNER JOIN TGDD_NEWS.PRODUCT_DETAIL d ON v.VALUEID = d.VALUE WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0'
			//echo 'TotalRow: '.count($listprovalues);
			$ct = 0;
			if(!empty($listprovalues)){
				foreach($listprovalues as $val){
					//exit('SELECT d.PRODUCTID FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0 AND d.VALUE LIKE '.(int)$val['VALUEID']);
					$prodetail = $oracle->query('SELECT d.PRODUCTID, d.PROPERTYID FROM TGDD_NEWS.PRODUCT_DETAIL d WHERE LANGUAGEID LIKE \'vi-VN\' AND PRODUCTID>0 AND d.VALUE LIKE '.(int)$val['VALUEID']);
					if(!empty($prodetail)){
						foreach($prodetail as $detail){
							$chckProductatt = $this->registry->db->query('SELECT rpa_id FROM ' . TABLE_PREFIX . 'rel_product_attribute WHERE pa_id=? AND p_id=?',array((int)$detail['PROPERTYID'],(int)$detail['PRODUCTID']))->fetch();
							if(!empty($chckProductatt)) continue;
							$sql2 = 'INSERT INTO ' . TABLE_PREFIX . 'rel_product_attribute (p_id,pa_id,rpa_value,rpa_valueseo) VALUES(?, ?,?,?)';
							$rowCount = $this->registry->db->query($sql2, array((int)$detail['PRODUCTID'],(int)$detail['PROPERTYID'],(string)$val['VALUE'], Helper::codau2khongdau((string)$val['VALUE'],true,true)))->rowCount();
							//file_put_contents('importProductAttributeValue.txt','OFFSET: '.$offset.' LIMIT: '.$limit.' VALUEID: '.$val['VALUEID']);
							echo '<br />'.++$ct;
						}
					}

				}
			}
		}
		if($i==($totalPage-1)) {
			unset($_SESSION['runningpage2']);
			return;
		}
	}

	function importProductsAction(){

		$oracle = new Oracle();
		$offset = 0; $limit = 500;
		$totalNumber = $oracle->query('SELECT count(*) as NUM FROM TGDD_NEWS.PRODUCT p WHERE p.PRODUCTID>0');
		$totalNumber = $totalNumber[0]['NUM'];

		$totalPage = ceil($totalNumber/500);// $_SESSION['fdfd'];
		unset($_SESSION['runningpage']);//return;
		set_time_limit(0);
		$startrun = (!empty($_SESSION['runningpage'])?$_SESSION['runningpage']:0);
		for($i=$startrun; $i<$totalPage; $i++ ){
			$_SESSION['runningpage'] = $i;
			$offset = $i*$limit;
			$this->loopProduct($offset, $limit+$offset);
			//break;
		}
		if($i==($totalPage-1)) {
			unset($_SESSION['runningpage']);
			return;
		}
	}

	function loopProduct($offset, $limit)
	{
		$oracle = new Oracle();
		//if($offset == 0) $offset = 1;
		//L?Y T?T C? THU?C TÃ�NH T? PRODUCT LANGUAGE, VÃ€ PRODUCT RELATESHONG
		/*$products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID, p.ISHOT, p.ISNEW, p.ISSPECIAL ,rownum rnum, p.MANUFACTURERID, pl.CATEGORYID, p.GROUPID, p.BIMAGE, p.ISACTIVED, p.PRODUCTCODE, pl.URL, pl.HTML, pl.GENERAL, pl.PRODUCTNAME, pl.CANONICAL,pl.DESCRIPTION, pl.METAKEYWORD, pl.METATITLE, pl.METADESCRIPTION,pl.HTMLDESCRIPTION, pl.KEYWORD
		FROM TGDD_NEWS.PRODUCT_CATEGORY_SITE pc INNER JOIN TGDD_NEWS.PRODUCT p ON pc.CATEGORYID = p.CATEGORYID INNER JOIN TGDD_NEWS.PRODUCT_LANGUAGE pl ON p.PRODUCTID = pl.PRODUCTID WHERE pc.SITEID = 3 AND LANGUAGEID LIKE \'vi_VN\' AND p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
		*/
		$products = $oracle->query('SELECT * FROM (SELECT p.PRODUCTID, p.ISHOT, p.ISNEW, p.ISSPECIAL ,rownum rnum, p.MANUFACTURERID, p.CATEGORYID, p.GROUPID, p.BIMAGE, p.ISACTIVED, p.PRODUCTCODE, p.URL, p.HTML, p.GENERAL, p.PRODUCTNAME, p.DESCRIPTION, p.METAKEYWORD, p.METATITLE, p.METADESCRIPTION,p.HTMLDESCRIPTION, p.KEYWORD
		FROM TGDD_NEWS.PRODUCT p WHERE  p.PRODUCTID>0 AND rownum<'.$limit.') WHERE rnum>='.$offset.'');//  ORDER BY PRODUCTID DESC
		/*echo 'SELECT * FROM (SELECT p.PRODUCTID,rownum rnum, p.MANUFACTURERID, pl.CATEGORYID, p.GROUPID, p.BIMAGE, p.ISACTIVED, p.PRODUCTCODE, pl.URL, pl.HTML, pl.GENERAL, pl.PRODUCTNAME, pl.CANONICAL,pl.DESCRIPTION, pl.METAKEYWORD, pl.METATITLE, pl.METADESCRIPTION,pl.HTMLDESCRIPTION
		FROM TGDD_NEWS.PRODUCT_CATEGORY_SITE pc INNER JOIN TGDD_NEWS.PRODUCT p ON pc.CATEGORYID = p.CATEGORYID INNER JOIN TGDD_NEWS.PRODUCT_LANGUAGE pl ON p.PRODUCTID = pl.PRODUCTID WHERE pc.SITEID = 3 AND LANGUAGEID LIKE \'vi_VN\' AND p.PRODUCTID>0 AND rownum<'.$limit.'  ORDER BY PRODUCTID DESC) WHERE rnum>'.$offset.'';*/
		/*var_dump($oracle->query('SELECT * FROM (SELECT p.PRODUCTID,rownum rnum, p.MANUFACTURERID, pl.CATEGORYID, p.GROUPID, p.BIMAGE, p.ISACTIVED, p.PRODUCTCODE, pl.URL, pl.HTML, pl.GENERAL, pl.PRODUCTNAME, pl.CANONICAL,pl.DESCRIPTION, pl.METAKEYWORD, pl.METATITLE, pl.METADESCRIPTION,pl.HTMLDESCRIPTION FROM TGDD_NEWS.PRODUCT_CATEGORY_SITE pc INNER JOIN TGDD_NEWS.PRODUCT p ON pc.CATEGORYID = p.CATEGORYID INNER JOIN TGDD_NEWS.PRODUCT_LANGUAGE pl ON p.PRODUCTID = pl.PRODUCTID WHERE pc.SITEID = 3 AND LANGUAGEID LIKE \'vi_VN\' AND p.PRODUCTID>0 AND rownum<500) WHERE rnum>=1'));
		exit();*/
		$ct=0;echo '<p>Offset: '.$offset.'</p>';
		if(!empty($products)){
			$listextensionimage = array('jpg','jpeg','gif','png');
			foreach($products as  $pro){
				//$objProduct = new Core_Product((int)$pro['PRODUCTID']);
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
							$getKeyword = Core_Keyword::getKeywords(array('ftext'=>$kw),'','',1);
							if(empty($getKeyword))
							{
								$objKeyword = new Core_Keyword();
								$objKeyword->text = Helper::plaintext($kw);
								$objKeyword->slug = Helper::codau2khongdau($kw, true, true);
								$objKeyword->from = Core_Keyword::TYPE_PRODUCT;
								$objKeyword->status = Core_Keyword::STATUS_ENABLE;
								$objKeyword->datecreated = time();
								$idkeyword = $objKeyword->addData();

								$relItemKeyword = new Core_RelItemKeyword();
								$relItemKeyword->kid = $idkeyword;
								$relItemKeyword->type = Core_RelItemKeyword::TYPE_PRODUCT;
								$relItemKeyword->objectid = (int)$pro['PRODUCTID'];
								$relItemKeyword->addData();
							}
						}
					}
				}

				//check duplicate product
			   // $onepro = $this->registry->db->query('SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE p_id='.(int)$pro['PRODUCTID'].' LIMIT 1')->fetch();
				//if(!empty($onepro)) continue;
				//Find verdor name
				$vendor = $oracle->query('SELECT DISTINCT MANUFACTURERNAME FROM '.Oracle::$ociDatabaseName.'.PRODUCT_MANU WHERE MANUFACTURERID='.$pro['MANUFACTURERID']);
				//var_dump($vendor);break;
				$vendorid = 0;
				if(!empty($vendor)){
					$searchvendor = $this->registry->db->query('SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_name =?',array((string)trim($vendor[0]['MANUFACTURERNAME'])))->fetch();
					$vendorid = (!empty($searchvendor['v_id'])?$searchvendor['v_id']:0);
				}
				$summary = htmlspecialchars_decode($pro['DESCRIPTION']);
				if(empty($summary)){
					$gen = (!empty($pro['GENERAL'])?$pro['GENERAL']->load():'');
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
					$getpathinfo = pathinfo('https://ecommerce.kubil.app/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE']);
					if(!empty($getpathinfo['extension']) && in_array($getpathinfo['extension'],$listextensionimage)){
						$productimage = 'https://ecommerce.kubil.app/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE'];
					}
				}
				if(empty($productimage)){
					$getProductGallery = $oracle->query('SELECT * FROM (SELECT p.PICTURE,rownum rnum FROM TGDD_NEWS.PRODUCT_GALLERY p WHERE p.PRODUCTID='.$pro['PRODUCTID'].' AND p.PICTURE !=\' \' AND p.PICTURE is not null AND rownum<2) WHERE rnum>=0');
					if(!empty($getProductGallery[0]['PICTURE'])){
						$imageinfo = pathinfo('https://ecommerce.kubil.app/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$getProductGallery[0]['PICTURE']);
						if(!empty($imageinfo['extension']) && in_array($imageinfo['extension'],$listextensionimage)){
							$productimage = 'https://ecommerce.kubil.app/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$getProductGallery[0]['PICTURE'];
						}
					}
				}
				$description = (string)(!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']->load():'');
				//echodebug($description, true);
				//
				if(!empty($description)){
					//echo '<p>DESCRIPTION : '.$pro['PRODUCTID'].': '.$description.' ---END------</p>';exit();
					$description = html_entity_decode(Helper::specialchar2normalchar($description));

					preg_match_all('@\[one_third(.*?)\](.*?)\[\/one_third]@si',$description,$list3columns, PREG_PATTERN_ORDER);
					//var_dump($list3columns[2]);
					if(!empty($list3columns[2])){
						foreach($list3columns[2] as $item){
							if(strstr($item,'?u ?i?m')){
								//echo '?u ?i?m: '.$item."\n\n";
								preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
								if(!empty($uudiem[0][0])){
									$objProduct->good = trim($uudiem[0][0]);
								}
							}
							elseif(strstr($item,'Nh??c ?i?m')){
								//echo 'Nh??c ?i?m: '.$item."\n\n";
								preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
								if(!empty($uudiem[0][0])){
									$objProduct->bad = trim($uudiem[0][0]);
								}
							}
							else{
								$objProduct->dienmayreview = preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);

							} //echo 'OTHER: '.$item."\n\n";
						}
					}
					else{
						preg_match_all('@\[one_half(.*?)\](.*?)\[\/one_half]@si',$description,$list3columns, PREG_PATTERN_ORDER);
						if(!empty($list3columns[2])){
							foreach($list3columns[2] as $item){
								if(strstr($item,'?u ?i?m')){
									preg_match_all('@\<ul(.*?)\>(.*?)\<\/ul\>@si',$item,$uudiem);
									if(!empty($uudiem[0][0])){
										$objProduct->good = trim($uudiem[0][0]);
									}
								}
								elseif(strstr($item,'Nh??c ?i?m')){
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
									else $objProduct->dienmayreview = preg_replace('/\<(.*?)\>(.*?)\<\/(.*?)\>/','',$item);
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
							if(strstr($gc,'B? bÃ¡n hÃ ng chu?n') || strstr($gc,'b? bÃ¡n hÃ ng chu?n')){
								$objProduct->fullbox = str_replace('[br]','<br />', trim($gc));
								break;
							}
						}
					}

				}
				if(!empty($productimage) && Helper::isUrlOnline($productimage)){
					$objProduct->image=$productimage;//'https://ecommerce.kubil.app/Products/Images/'.$pro['CATEGORYID'].'/'.$pro['PRODUCTID'].'/'.$pro['BIMAGE']KIEM TRA LAI DUONG DAN HINH
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
				//$objProduct->content=(string)(!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']->load():'');
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

				if((int)$checkobjProduct->id <=0)$objProduct->importProduct();
				else $objProduct->updateData();
				//file_put_contents('importProducts.txt','OFFSET: '.$offset.' LIMIT: '.$limit.' PRODUCTID: '.$pro['PRODUCTID']);
				echo ++$ct.'<br />';
			}
		}
		//echo $ct;
	}

	function importVendorAction()
	{
		$oracle = new Oracle();
		$vendors = $oracle->query('SELECT DISTINCT m.MANUFACTURERNAME FROM '.Oracle::$ociDatabaseName.'.PRODUCT_MANU m');//' INNER JOIN '.Oracle::$ociDatabaseName.'.PRODUCT_MANU_SEO ms ON m.MANUFACTURERID = ms.MANUFACTURERID');
		if(!empty($vendors)){
			foreach($vendors as $ven){

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
			}
		}
	}

	function importProductAttributesAction(){
		$oracle = new Oracle();
		$attributes = $oracle->query('SELECT g.GROUPID, gl.GROUPNAME, g.CATEGORYID, g.DISPLAYORDER, g.ISACTIVED FROM '.Oracle::$ociDatabaseName.'.PRODUCT_PROPGRP g INNER JOIN '.Oracle::$ociDatabaseName.'.PRODUCT_PROPGRP_LANG gl ON g.GROUPID = gl.GROUPID WHERE LANGUAGEID LIKE \'vi_VN\'');
		if(!empty($attributes)){

			foreach($attributes as $attr){

				//check category
				$category = $oracle->query('SELECT c.CATEGORYID FROM '.Oracle::$ociDatabaseName.'.PRODUCT_CATEGORY_SITE cs INNER JOIN '.Oracle::$ociDatabaseName.'.PRODUCT_CATEGORY c ON cs.CATEGORYID = c.CATEGORYID WHERE cs.SITEID = 3 AND c.CATEGORYID = '.(int)$attr['CATEGORYID']);
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
					$properties = $oracle->query('SELECT g.PROPERTYID, g.PROPERTYNAME, g.ISACTIVED,DISPLAYORDER FROM '.Oracle::$ociDatabaseName.'.PRODUCT_PROP g INNER JOIN '.Oracle::$ociDatabaseName.'.PRODUCT_PROP_LANG gl ON g.PROPERTYID = gl.PROPERTYID WHERE  LANGUAGEID LIKE \'vi_VN\' AND g.GROUPID = '.(int)$attr['GROUPID']);
					if(!empty($properties)){
						foreach($properties as $prop){
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

	function importCategoryAction(){
		$oracle = new Oracle();
		/*$listcategories = $oracle->query('SELECT c.CATEGORYID, CATEGORYNAME, CATEGORYLINK, DESCRIPTION, METAKEYWORD, METATITLE, METADESCRIPTION, PARENTID, DISPLAYORDER, ISACTIVED
		FROM '.Oracle::$ociDatabaseName.'.PRODUCT_CATEGORY_SITE cs LEFT JOIN '.Oracle::$ociDatabaseName.'.PRODUCT_CATEGORY c ON cs.CATEGORYID = c.CATEGORYID WHERE SITEID=3');*/
		$listcategories = $oracle->query('SELECT CATEGORYID, CATEGORYNAME, CATEGORYLINK, DESCRIPTION, METAKEYWORD, METATITLE, METADESCRIPTION, PARENTID, DISPLAYORDER, ISACTIVED
		FROM '.Oracle::$ociDatabaseName.'.PRODUCT_CATEGORY');
		if(!empty($listcategories)){
			$countadd = 0;
			foreach($listcategories as $category){
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'productcategory (
					pc_id,
					pc_name,
					pc_slug,
					pc_summary,
					pc_seotitle,
					pc_seokeyword,
					pc_seodescription,
					pc_parentid,
					pc_displayorder,
					pc_status,
					pc_datecreated
					)
				VALUES(?, ?, ?,?, ?, ?,?, ?, ?, ?, ?)';
				$slugname = '';
				if(!empty($category['CATEGORYLINK'])){
					$slugarray = explode('/',substr($category['CATEGORYLINK'],1,strlen($category['CATEGORYLINK'])-6));
					$slugname = $slugarray[count($slugarray)-1];
				}
				else $slugname = str_replace(' ','-',Helper::codau2khongdau($category['CATEGORYNAME'],true,true));

				$rowCount = $this->registry->db->query($sql, array(
					(int)$category['CATEGORYID'],
					(string)$category['CATEGORYNAME'],
					(string)($slugname),
					(string)$category['DESCRIPTION'],
					(string)$category['METATITLE'],
					(string)$category['METAKEYWORD'],
					(string)$category['METADESCRIPTION'],
					(int)$category['PARENTID'],
					(int)$category['DISPLAYORDER'],
					(int)$category['ISACTIVED'],
					(int)time()
					))->rowCount();
				if($rowCount){
					$countadd++;
					echo '<br />ID: '.$category['CATEGORYID'].':'.$category['CATEGORYNAME'];
				}
			}
			echo 'INSERT '.$countadd.' ROWS';
		}
	}

	function importStoreAction(){
		$oracle = new Oracle();
		$areas = $oracle->query('SELECT AREAID, AREANAME, ORDERINDEX FROM  ERP.VW_AREA_DM');
		if(!empty($areas)){
			 foreach($areas as $area){
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'area (
					a_id,
					a_name,
					a_displayorder
					)
				VALUES(?, ?, ?)';
				$rowCount = $this->registry->db->query($sql, array(
					(int)$area['AREAID'],
					(string)$area['AREANAME'],
					(int)$area['ORDERINDEX'],
					))->rowCount();
				if($rowCount){
					echo '<br />ID: '.$area['AREAID'].':'.$area['AREANAME'];
				}
			 }
		}
		echo '<p>LIST STORE: </p>';
		//$listStores = $oracle->query('SELECT s.STOREID, s.AREAID,s.ISACTIVE, s.STORENAME, s.STOREADDRESS, s.NOTE, s.PROVINCEID, s.STOREPHONENUM, s.STOREFAX, si.RANK, si.IMAGEMAPLARGE, si.LAT, si.LNG FROM '.Oracle::$ociDatabaseName.'.PM_STORE s INNER JOIN '.Oracle::$ociDatabaseName.'.PM_STORE_INFO si ON s.STOREID = si.STOREID INNER JOIN '.Oracle::$ociDatabaseName.'.PM_STORE_WEBSITE sw ON s.STOREID = sw.STOREID WHERE sw.SITEID=3');
		$listStores = $oracle->query('SELECT s.STOREID, s.AREAID,s.STORENAME, s.STOREADDRESS, s.PROVINCEID, s.STOREPHONENUM, s.STOREFAX, s.PRICEAREAID, s.LNG, s.LAT FROM ERP.VW_PM_STORE_DM s');
		if(!empty($listStores)){
			foreach($listStores as $store){
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'store (
					a_id,
					ppa_id,
					s_id,
					s_name,
					s_address,
					s_region,
					s_phone,
					s_fax,
					s_lat,
					s_lng,
					s_datecreated
					)
				VALUES(?, ?, ?,?, ?, ?,?, ?, ?, ?, ?)';
				$rowCount = $this->registry->db->query($sql, array(
					(int)$store['AREAID'],
					(int)$store['PRICEAREAID'],
					(int)$store['STOREID'],
					(string)$store['STORENAME'],
					(string)$store['STOREADDRESS'],
					(int)$store['PROVINCEID'],
					(string)$store['STOREPHONENUM'],
					(string)$store['STOREFAX'],
					(string)$store['LAT'],
					(string)$store['LNG'],
					time()
					))->rowCount();
				if($rowCount) echo '<br />ID: '.$store['STOREID'].':'.$store['STORENAME'];
			}
		}
	}

	function importRegionAction(){
		$oracle = new Oracle();
		$provinces = $oracle->query('SELECT PROVINCENAME,ORDERINDEX,PROVINCEID FROM  '.Oracle::$ociDatabaseName.'.GEN_PROVINCE');
		if(!empty($provinces)){
			foreach($provinces as $province){
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'region (
					r_id,
					r_name,
					r_displayorder
					)
				VALUES(?, ?, ?)';
				$rowCount = $this->registry->db->query($sql, array(
					(int)$province['PROVINCEID'],
					(string)$province['PROVINCENAME'],
					(int)$province['ORDERINDEX'],
					))->rowCount();
				if($rowCount){
					echo '<p>Save<br /> PROVINCE '.$province['PROVINCEID'].': '.$province['PROVINCENAME'].'<br />';
					echo '</p>';
				}
				//
			}



			foreach($provinces as $province){
				$getListDistricts = $oracle->query('SELECT * FROM  '.Oracle::$ociDatabaseName.'.GEN_DISTRICT WHERE PROVINCEID='.$province['PROVINCEID']);
				if(!empty($getListDistricts)){
					foreach($getListDistricts as $district){
						$sql = 'INSERT INTO ' . TABLE_PREFIX . 'region (
								r_name,
								r_displayorder,
								r_parentid
								)
							VALUES(?, ?, ?)';
						$rowCount2 = $this->registry->db->query($sql, array(
								(string)$district['DISTRICTNAME'],
								(int)$district['ORDERINDEX'],
								(int)$province['PROVINCEID'],
								))->rowCount();
						if($rowCount2){
							echo '             DISTRICT: '.$province['PROVINCEID'].':'.$this->registry->db->lastInsertId().':'.$district['DISTRICTNAME'].'<br />';
						}
					}
				}
			}
		}
	}

	function importFileProductMediaAction()
	{
		set_time_limit(0);

		//get all product media
		$productmedias = Core_ProductMedia::getProductMedias(array(),'id','ASC','0,20');
		if(count($productmedias) > 0)
		{
			foreach($productmedias as $media)
			{
				$media->fileurl = $media->file;
				$media->file = '';
				if($media->updateData())
				{
					echo $media->pid . '<br/>';
				}
			}
		}
	}

	function importProductOutputTypeAction()
	{
		$oracle = new Oracle();
		$sql = 'SELECT * FROM ERP.VW_PM_OUTPUTTYPE_DM';
		$outputTypeList = $oracle->query($sql);

		if(!empty($outputTypeList))
		{
			foreach ($outputTypeList as $outputType)
			{
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_outputype(po_id ,
																			po_name
																		)
														VALUES(? , ?)';
				$rowCount = $this->registry->db->query($sql, array(
															(int)$outputType['OUTPUTTYPEID'],
															(string)$outputType['OUTPUTTYPENAME'],
														));
				if($rowCount)
				{
					echo (int)$outputType['OUTPUTTYPEID'] . '<br />';
				}
			}
		}
	}

	function importProductPriceAreaAction()
	{
		$oracle = new Oracle();
		$sql = 'SELECT * FROM ERP.VW_PR_PRICEAREA_DM';

		$productPriceAreaList = $oracle->query($sql);

		foreach($productPriceAreaList as $productPriceArea)
		{
			$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price_area(ppa_id,
																		ppa_name,
																		ppa_isactive,
																		ppa_datecreated)
													VALUES(?, ?, ?, ?)';
			$rowCount = $this->registry->db->query($sql, array(
													(int)$productPriceArea['PRICEAREAID'],
													(string)$productPriceArea['PRICEAREANAME'],
													(int)$productPriceArea['ISACTIVE'],
													time(),
													));
			if($rowCount)
			{
				echo (int)$productPriceArea['PRICEAREAID'] . '<br />';
			}
		}
	}

	function importProductStockAction()
	{
		$recordPerPage = 1000;
		$oracle = new Oracle();
		$sql = 'SELECT Count(*) FROM ERP.VW_CURRENTINSTOCK_DM';
		$productStockList = $oracle->query($sql);

		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}

		$page = ceil($total/$recordPerPage);

		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sqlSelect = 'SELECT * FROM ( SELECT ci.*, ROWNUM r  FROM ERP.VW_CURRENTINSTOCK_DM ci)  WHERE r > '.$start.' AND r <= '.$end.'';

			$result = $oracle->query($sqlSelect);

			foreach($result as $res)
			{
				//lay product id dua vao barcode
				//$barcode = (string)$res['PRODUCTID'];
				//$productId = $this->getRefProductId($barcode);
				if(strlen((string)$res['PRODUCTID']) > 0)
				{
					$myProductStock = new Core_ProductStock();
					$myProductStock->pbarcode = (string)$res['PRODUCTID'];
					$myProductStock->sid = (int)$res['STOREID'];
					$myProductStock->quantity = (int)$res['QUANTITY'];

					$rowCount = $myProductStock->addData();

					if($rowCount)
						echo $res['PRODUCTID'] . '<i>inserted</i> <br />';
					else
						echo 'not inserted <br />';
				}

			}
		}

	}

	/**
	 * [Dong bo so luong san pham tu ERP]
	 * @return [type] [description]
	 */
	public function syncProductStockAction()
	{

		$recordPerPage = 1000;
		$oracle = new Oracle();
		$sql = 'SELECT Count(*) FROM ERP.VW_CURRENTINSTOCK_DM';
		$productStockList = $oracle->query($sql);

		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		//get max revision current
		$maxRevision = Core_ProductStat::getMaxRevision('pst_instockrevision');

		for($i = 1 ; $i <= $page ; $i++)
		{

			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sqlSelect = 'SELECT * FROM ( SELECT ci.*, ROWNUM r FROM ERP.VW_CURRENTINSTOCK_DM ci)  WHERE r > '.$start.' AND r <= '.$end.'';

			$result = $oracle->query($sqlSelect);

			foreach($result as $res)
			{
				if(strlen((string)$res['PRODUCTID']) > 0)
				{
					//kiem tra xem id nay da co trong danh sach hay chua ?
					$myProductStock = new Core_ProductStock();
					$myProductStock->getProductStockByBarcode((string)$res['PRODUCTID'], (int)$res['STOREID']);

					if($myProductStock->id > 0)
					{
						$myProductStock->quantity = (int)$res['QUANTITY'];

						$myProductStock->updateData();
					}
					else
					{
						$myProductStock->pbarcode = (string)$res['PRODUCTID'];
						$myProductStock->sid = (int)$res['STOREID'];
						$myProductStock->quantity = (int)$res['QUANTITY'];

						$myProductStock->addData();
					}

					//cap nhat revision cua stock
					$myProductStat = new Core_ProductStat();
					$myProductStat->getProductStatByBarcode((string)$res['PRODUCTID']);

					if($myProductStat->id > 0)
					{
						if($myProductStat->instockrevision < $maxRevision + 1)
						{
							$myProductStat->instockrevision = $maxRevision + 1;
							$stmt = $myProductStat->updateData();
							if($stmt)
								echo $myProductStock->pbarcode . '<i> done</i><br />';
							else
								echo $myProductStock->pbarcode . '<i>not done</i><br />';
						}
					}
					else
					{
						echo $myProductStock->pbarcode . '<i> sync</i><br />';
					}
				}
			}
		}
	}

	/**
	 * [updateQuantityProductAction description]
	 * Cap nhat lai so luong san trong trong database
	 * @return [type] [description]
	 */
	public function updateProductStockAction()
	{
		set_time_limit(0);
		$sql = 'SELECT ps.p_barcode, SUM(ps_quantity) AS quantity FROM ' . TABLE_PREFIX . 'product_stock ps
				WHERE ps.s_id NOT IN(734 , 990, 991, 992, 993, 994) GROUP BY ps.p_barcode';

		$stmt = $this->registry->db->query($sql);

		$maxInstockRevsion = Core_ProductStat::getMaxRevision('pst_instockrevision');

		$instockMaxRevisionList = Core_ProductStat::getMaxRevisionList('pst_instockrevision' , $maxInstockRevsion);

		//echodebug($instockMaxRevisionList,true);

		while($row = $stmt->fetch())
		{
			if(in_array((string)$row['p_barcode'], $instockMaxRevisionList))
			{
				$sql = 'UPDATE ' . TABLE_PREFIX .'product p
					SET p.p_instock = ?,
						p.p_syncstatus = ?
					WHERE p_barcode = ?';

				$result = $this->registry->db->query($sql, array((int)$row['quantity'], Core_Product::STATUS_SYNC_FOUND ,(string)$row['p_barcode']));
				if($result)
					echo $row['p_barcode'] . ' <i>updated</i>&nbsp;'.$row['quantity'].'<br />';
				else
					echo $row['p_barcode'] . ' <i>not updated</i><br />';
			}
			else
			{
				$sql = 'UPDATE '. TABLE_PREFIX .'product p
					SET p.p_instock = ?,
					 p.p_syncstatus = ?
					WHERE p_barcode = ?';

				$result = $this->registry->db->query($sql, array(-1, Core_Product::STATUS_SYNC_NOTFOUND ,(string)$row['p_barcode']));
				if($result)
					echo $row['p_barcode'] . ' <i>updated-</i>&nbsp;'.$row['quantity'].'<br />';
				else
					echo $row['p_barcode'] . ' <i>not updated-</i><br />';
			}
		}
	}

	public function importProductPriceAction()
	{
		$recordPerPage = 1000;
		$oracle = new Oracle();
		$sql = 'SELECT Count(*) FROM ERP.VW_PRICE_PRODUCT_DM';
		$productStockList = $oracle->query($sql);

		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}


		$page = ceil($total/$recordPerPage);

		for($i = 1 ; $i <= $page ; $i++) // xet lai tam thoi vi bi loi , chay ok se sua i = 1
		{
			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM ( SELECT pp.*, ROWNUM r  FROM ERP.VW_PRICE_PRODUCT_DM pp)  WHERE r > '.$start.' AND r <= '.$end.'';

			$result = $oracle->query($sql);


			foreach($result as $res)
			{
				if(strlen((string)$res['PRODUCTID']) > 0)
				{
					//echodebug($res['UPDATEDPRICEDATE'],true);
					//chuyen doi nay cap nhat gia
					if($res['UPDATEDPRICEDATE'] != '')
					{
						$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['UPDATEDPRICEDATE']);
						$date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
					}
					else
					{
						$date = time();
					}

					//kiem tra xem du lieu co bi trung lap hay khong ?
					$checker = Core_ProductPrice::getProductPrices(array('fpbarcode' => $res['PRODUCTID'],
																		'fppaid' => $res['PRICEAREAID'],
																		'fpoid' => $res['OUTPUTTYPEID'],
																	) , 'id' , 'ASC' , '' , true);

					if($checker == 0)
					{
						$myProductPrice = new Core_ProductPrice();

						$myProductPrice->pid = (int)$res['PRODUCTIDREF'];
						$myProductPrice->pbarcode = (string)$res['PRODUCTID'];
						$myProductPrice->ppaid = (int)$res['PRICEAREAID'];
						$myProductPrice->poid = (int)$res['OUTPUTTYPEID'];
						$myProductPrice->sellprice = (float)$res['SALEPRICE'];
						$myProductPrice->discount = (float)$res['DISCOUNT'];
						$myProductPrice->datemodified = $date;

						$rowCount = $myProductPrice->addData();

						if($rowCount)
							echo $myProductPrice->pbarcode . ' <i>inserted</i><br />';
						else
							echo $myProductPrice->pbarcode . ' <i>not inserted</i><br />';
					}
				}

			}
		}

	}

	public function syncProductPriceAction()
	{
		$recordPerPage = 1000;
		$oracle = new Oracle();
		$sql = 'SELECT Count(*) FROM ERP.VW_PRICE_PRODUCT_DM';
		$productStockList = $oracle->query($sql);

		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		//get max revision current
		$maxRevision = Core_ProductStat::getMaxRevision('pst_pricerevision');

		$today = strtoupper(date('d-M-y' , time()));

		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM ( SELECT pp.*, ROWNUM r FROM ERP.VW_PRICE_PRODUCT_DM pp WHERE pp.UPDATEDPRICEDATE >= TO_DATE(\' '.$today.' \'))  WHERE r > '.$start.' AND r <= '.$end.'';

			$result = $oracle->query($sql);

			//echo $sql;die();

			//echodebug($result,true);

			foreach($result as $res)
			{
				if((string)$res['PRODUCTID'] > 0)
				{
					//echodebug($res['UPDATEDPRICEDATE'],true);
					//chuyen doi nay cap nhat gia
					if($res['UPDATEDPRICEDATE'] != '')
					{
						$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['UPDATEDPRICEDATE']);
						$date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
					}
					else
					{
						$date = time();
					}

					$myProductPrice = new Core_Productprice();
					$myProductPrice->getProductPriceByBarcode((string)$res['PRODUCTID'], (int)$res['PRODUCTIDREF']);
					if($myProductPrice->id > 0)
					{
						$myProductPrice->sellprice =  (float)$res['SALEPRICE'];
						$myProductPrice->discount =  (int)$res['DISCOUNT'];
						$myProductPrice->datemodified = $date;

						$myProductPrice->updateData();
					}
					else
					{
						 //chuyen doi nay cap nhat gia
						if($res['UPDATEDPRICEDATE'] != '')
						{
							$dateUpdated = DateTime::createFromFormat('d-M-y h.i.s.u a', $res['UPDATEDPRICEDATE']);
							$date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
						}
						else
						{
							$date = time();
						}


						$myProductPrice = new Core_ProductPrice();

						$myProductPrice->pbarcode = (string)$res['PRODUCTID'];
						$myProductPrice->ppa = (int)$res['PRICEAREAID'];
						$myProductPrice->poid = (int)$res['OUTPUTTYPEID'];
						$myProductPrice->sellprice = $res['SALEPRICE'];
						$myProductPrice->discount = (int)$res['DISCOUNT'];
						$myProductPrice->datemodified = $date;

						$myProductPrice->addData();
					}
					//cap nhat version cua gia
					$myProductStat = new Core_ProductStat();
					$myProductStat->getProductStatByBarcode((string)$res['PRODUCTID']);
					if($myProductStat->id > 0)
					{
						if($myProductStat->pricerevision < $maxRevision + 1)
						{
							$myProductStat->pricerevision = $maxRevision + 1;
							$stmt = $myProductStat->updateData();
							if($stmt)
								echo $myProductStock->pbarcode . '<i> done</i><br />';
							else
								echo $myProductStock->pbarcode . '<i>not done</i><br />';
						}
					}

				}

			}

		}

	}

	/**
	 * Cap nhat gia cua san phan trong he thong
	 * */
	public function updateProductPriceAction()
	{
		$counter = 0;
		set_time_limit(0);

		$sql = 'SELECT DISTINCT(pp.p_barcode), pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
				WHERE ppa_id = 242 AND po_id = 0
				GROUP BY pp.p_barcode';

		$stmt = $this->registry->db->query($sql);


		while($row = $stmt->fetch())
		{
			if((float)$row['pp_sellprice'] <= 0)
			{

				  $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
				  WHERE ppa_id = 242 AND po_id = 222 AND p_barcode = ' . $row['p_barcode'];
				  $result1 = $this->registry->query($sql)->fetch();
				  if((float)$result1['pp_sellprice'] > 0)
				  {
					  $sql = 'UPDATE '. TABLE_PREFIX .'product
							SET p_sellprice = ?
							WHERE p_barcode = ? AND p_onsitestatus = 0';
					   $result = $this->registry->db->query($sql, array((float)$row['pp_sellprice'],(string)$row['p_barcode']));
					   //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
					   $counter++;
				  }
			}
			else
			{
				$sql = 'UPDATE '. TABLE_PREFIX .'product
					SET p_sellprice = ?
					WHERE p_barcode = ? AND p_onsitestatus = 0';
				$result = $this->registry->db->query($sql, array((float)$row['pp_sellprice'],(string)$row['p_barcode']));
				//echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
				$counter++;
			}
		}
		echo 'so luong record duoc thuc thi : ' . $counter;
	}


	public function importExtendProductAction()
	{
		$recordPerPage = 1000;
		$oracle = new Oracle();
		$sql = 'SELECT Count(*) FROM ERP.VW_CURRENTINSTOCKDETAIL_DM';
		$extendProductList = $oracle->query($sql);

		$countAll = $oracle->query($sql);
		foreach($countAll as $count)
		{
			$total = $count['COUNT(*)']; //tong so record
		}

		$page = ceil($total/$recordPerPage);

		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($result);

			set_time_limit(0);

			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM ( SELECT ppi.*, ROWNUM r , p.PRODUCTIDREF FROM ERP.VW_CURRENTINSTOCKDETAIL_DM ppi , ERP.PM_PRODUCT p WHERE ppi.PRODUCTID = p.PRODUCTID)  WHERE r > '.$start.' AND r <= '.$end.'';

			$result = $oracle->query($sql);

			foreach($result as $res)
			{
				if($res['PRODUCTIDREF'] > 0)
				{

					if($res['INPUTDATE'] != '')
					{
						$dateUpdated = DateTime::createFromFormat('d-M-y', $res['INPUTDATE']);
						$date =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
					}
					else
					{
						$date = time();
					}


					$myExtendProduct = new Core_Extendproduct();
					$myExtendProduct->getExtendproductByProductId((int)$res['PRODUCTIDREF']);
					if($myExtendProduct->id == 0)
					{
						$myExtendProduct->pid = (int)$res['PRODUCTIDREF'];
						$myExtendProduct->sid = (int)$res['STOREID'];
						$myExtendProduct->cusid = (int)$res['CUSTOMERID'];
						$myExtendProduct->code = (string)$res['IMEI'];
						$myExtendProduct->status = Core_Extendproduct::STATUS_ENABLE;
						$myExtendProduct->datecreated =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

						$rowCount = $myExtendProduct->addData();
						if($rowCount > 0)
						{
							$myExtendProductPrice = new Core_ExtendproductPrice();
							$myExtendProductPrice->getExtendproductPriceByEpId($myExtendProduct->id);
							if($myExtendProductPrice->id == 0)
							{
								$myExtendProductPrice->epid = $myExtendProduct->id;
								$myExtendProductPrice->eepcostprice = (float)$res['COSTPRICE'];
								$myExtendProductPrice->eepdatemodified =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
								$rowCount1 = $myExtendProductPrice->addData();
								if($rowCount1 > 0)
								{
									echo $myExtendProduct->id . ' <i>inserted</i><br />' ;
								}
								else
								{
									echo $myExtendProduct->id . ' <i>not inserted</i><br />' ;
								}
							}
							else
							{
								$myExtendProductPrice->eepcostprice = (float)$res['COSTPRICE'];
								$myExtendProductPrice->eepdatemodified =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
								if($myExtendProductPrice->updateData())
									echo $myExtendProductPrice->id . ' <i>updated</i><br />';
								else
									echo $myExtendProductPrice->id . ' <i>not updated</i><br />' ;
							}
						}
						else
						{
							echo $myExtendProduct->id . ' <i>not inserted</i><br />' ;
						}
					}
					else
					{
						$myExtendProduct->sid = (int)$res['STOREID'];
						$myExtendProduct->cusid = (int)$res['CUSTOMERID'];
						$myExtendProduct->code = (string)$res['IMEI'];
						$myExtendProduct->status = Core_Extendproduct::STATUS_ENABLE;
						$myExtendProduct->datecreated =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));

						if($myExtendProduct->updateData())
						{
							$myExtendProductPrice = new Core_ExtendproductPrice();
							$myExtendProductPrice->getExtendproductPriceByEpId($myExtendProduct->id);
							if($myExtendProductPrice->id == 0)
							{
								$myExtendProductPrice->epid = $myExtendProduct->id;
								$myExtendProductPrice->eepcostprice = (float)$res['COSTPRICE'];
								$myExtendProductPrice->eepdatemodified =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
								$rowCount1 = $myExtendProductPrice->addData();
								if($rowCount1 > 0)
								{
									echo $myExtendProduct->id . ' <i>inserted</i><br />' ;
								}
								else
								{
									echo $myExtendProduct->id . ' <i>not inserted</i><br />' ;
								}
							}
							else
							{
								$myExtendProductPrice->eepcostprice = (float)$res['COSTPRICE'];
								$myExtendProductPrice->eepdatemodified =  Helper::strtotimedmy($dateUpdated->format('d/m/Y'));
								if($myExtendProductPrice->updateData())
									echo $myExtendProductPrice->id . ' <i>updated</i><br />';
								else
									echo $myExtendProductPrice->id . ' <i>not updated</i><br />' ;
							}
						}
						else
						{
							 echo $myExtendProduct->id . ' <i>not updated</i><br />' ;
						}

					}
				}
			}
			die(); //test
		}
	}

	private function getRefProductId($barcode)
	{
		$productIdRef = 0;
		$oracle = new Oracle();
		$sql = 'SELECT PRODUCTIDREF FROM ERP.PM_PRODUCT
				WHERE PRODUCTID = \'' . (string)$barcode . '\'';

		$stmt = $oracle->query($sql);
		$productIdRef = (int)$stmt[0]['PRODUCTIDREF'];

		return $productIdRef;
	}

	public function importProductStatAction()
	{
		set_time_limit(0);
		$sql = 'SELECT p_barcode, p_id FROM ' . TABLE_PREFIX . 'product';
		$stmts = $this->registry->db->query($sql);

		while ($row = $stmts->fetch())
		{
			//echodebug($row);
			//kiem tra xem product stat nay da ton tai hay chua
			$productstat = new Core_ProductStat();
			$productstat->getProductStatByBarcode($row['p_barcode']);

			if($productstat->id == 0)
			{
				$productstat->pid = $row['p_id'];
				$productstat->pbarcode = $row['p_barcode'];
				$productstat->instockrevision = 1;
				$productstat->pricerevision = 1;

				$rowCount = $productstat->addData();

				if($rowCount > 0)
				{
					echo $product->id . ' inserted<br />';
				}
				else
				{
					echo $product->id . ' not inserted<br />';
				}
			}
			else
			{
				$productstat->pbarcode = $product->barcode;
				$stmt = $productstat->updateData();
				if($stmt)
				{
					echo $product->id . ' updated<br />';
				}
				else
				{
					echo $product->id . ' not updated<br />';
				}
			}
		}
	}


	public function importProductColorAction()
	{
		$oracle = new Oracle();
		$sql = 'SELECT * FROM TGDD_NEWS.PRODUCT_COLOR';

		$result = $oracle->query($sql);

		foreach($result as $res)
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

	public function importGalleryAction()
	{
		$recordPerPage = 2000;
		$oracle = new Oracle();
		$getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM TGDD_NEWS.PRODUCT_GALLERY');
		$total = 0;
		foreach($getAllGalleriesRow as $count)
		{
			$total = $count['R']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		$listextensionimage = array('jpg','jpeg','gif','png');
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($getAllGalleriesRow);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$listGalleries = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM TGDD_NEWS.PRODUCT_GALLERY g) WHERE r > '.$start.' AND r <= '.$end);
			if(!empty($listGalleries))
			{
				foreach($listGalleries as $gal)
				{
					if(!empty($gal['PICTURE']))
					{
						//check product exists in product table
						$getProduct = Core_Product::getProducts(array('fid'=>$gal['PRODUCTID']),'','',1);

						if(!empty($getProduct[0]))
						{
							$fileurl = 'https://ecommerce.kubil.app/Products/Images/'.$getProduct[0]->pcid.'/'.$getProduct[0]->id.'/'.str_replace(' ','%20',$gal['PICTURE']);
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
									echo 'START: '.$start.' ENd: '.$end.' PICTUREID: '.$gal['PICTUREID'];
								}
							}
						}
					}
				}
			}
		}
		die();
	}

	public function importGallery360Action()
	{
		$recordPerPage = 2000;
		$oracle = new Oracle();
		$getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM TGDD_NEWS.PRODUCT_GALLERY_360');
		$total = 0;
		foreach($getAllGalleriesRow as $count)
		{
			$total = $count['R']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		$listextensionimage = array('jpg','jpeg','gif','png');
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($getAllGalleriesRow);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$listGalleries = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM TGDD_NEWS.PRODUCT_GALLERY_360 g) WHERE r > '.$start.' AND r <= '.$end);
			if(!empty($listGalleries))
			{
				foreach($listGalleries as $gal)
				{
					if(!empty($gal['PICTURE']))
					{
						//check product exists in product table
						$getProduct = Core_Product::getProducts(array('fid'=>$gal['PRODUCTID']),'','',1);
						if(!empty($getProduct[0]))
						{
							$fileurl = 'https://ecommerce.kubil.app/Products/Images/'.$getProduct[0]->pcid.'/'.$getProduct[0]->id.'/'.str_replace(' ','%20',$gal['PICTURE']);
							$explode = explode(' ',$gal['PICTURE']);
							if(count($explode) ==1 )
							{
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
										echo 'START: '.$start.' ENd: '.$end.' PICTUREID: '.$gal['PICTUREID'];
									}
								}
							}

						}
					}
				}
			}
		}
		die();
	}

	function synWarrantyFullBoxShortAction()
	{
		$recordPerPage = 2000;
		$oracle = new Oracle();
		$getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM ERP.VW_PRICE_PRODUCT_DM');
		$total = 0;
		foreach($getAllGalleriesRow as $count)
		{
			$total = $count['R']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($listproductprice);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM ERP.VW_PRICE_PRODUCT_DM g) WHERE r > '.$start.' AND r <= '.$end);
			if(!empty($listproductprice))
			{
				foreach($listproductprice as $p)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product
							SET p_fullbox_short = ?,
								p_warranty = ?
							WHERE p_barcode = ?';
					$stmt = $this->registry->db->query($sql, array(
															(string)$p['ACCESSORIESINCLUDES'],
															(int)$p['WARRANTYINFO'],
															(string)trim($p['PRODUCTID']),
														  ));
				}
			}
		}
	}

	function getRegionAction()
	{
		$regions = Core_Region::getRegions(array('fparentid' => 0) , 'displayorder' , 'ASC');
		foreach ($regions as $region)
		{
			echo '<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8" /></head>';
			echo "'$region->id' => '$region->name', <br />";
			echo '</html>';
		}
	}

	function synBarCodeProductAction()
	{
		$recordPerPage = 2000;
		$oracle = new Oracle();
		$getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM ERP.PM_PRODUCT WHERE PRODUCTIDREF IS NOT NULL AND PRODUCTIDREF > 0');
		$total = 0;
		foreach($getAllGalleriesRow as $count)
		{
			$total = $count['R']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($listproductprice);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM ERP.PM_PRODUCT g WHERE PRODUCTIDREF IS NOT NULL AND PRODUCTIDREF > 0) WHERE r > '.$start.' AND r <= '.$end);
			if(!empty($listproductprice))
			{
				foreach($listproductprice as $p)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product
							SET p_barcode = ?
							WHERE p_id = ?';
					echo 'UPDATE: '.$p['PRODUCTID'].' - ' .$p['PRODUCTIDREF'];
					$stmt = $this->registry->db->query($sql, array(
															(string)$p['PRODUCTID'],
															(string)trim($p['PRODUCTIDREF']),
														  ));
				}
			}
		}
	}

	public function synVendorProductAction()
	{
		$recordPerPage = 2000;
		$oracle = new Oracle();
		$getAllGalleriesRow = $oracle->query('SELECT count(*) as R FROM TGDD_NEWS.PRODUCT');
		$total = 0;
		foreach($getAllGalleriesRow as $count)
		{
			$total = $count['R']; //tong so record
		}

		$page = ceil($total/$recordPerPage);
		//echo $page;
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($listproductprice);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$listproductprice = $oracle->query('SELECT * FROM (SELECT g.*, ROWNUM r FROM TGDD_NEWS.PRODUCT g) WHERE r > '.$start.' AND r <= '.$end);
			if(!empty($listproductprice))
			{
				foreach($listproductprice as $p)
				{
					$vendor = $oracle->query('SELECT DISTINCT MANUFACTURERNAME FROM '.Oracle::$ociDatabaseName.'.PRODUCT_MANU WHERE MANUFACTURERID='.$p['MANUFACTURERID']);
					//var_dump($vendor);
					if(!empty($vendor)){
						$searchvendor = $this->registry->db->query('SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_name =?',array((string)trim($vendor[0]['MANUFACTURERNAME'])))->fetch();
						//var_dump($searchvendor);
						$vendorid = (!empty($searchvendor['v_id'])?$searchvendor['v_id']:0);
						if(!empty($vendorid))
						{
							$sql = 'UPDATE ' . TABLE_PREFIX . 'product
								SET v_id = ?
								WHERE p_id = ?';
								echo '<p>UPDATE: '.$vendor[0]['MANUFACTURERNAME'].' - ' .$p['PRODUCTID'].'</p>';
								$stmt = $this->registry->db->query($sql, array(
																		(int)$vendorid,
																		(string)$p['PRODUCTID']
																	  ));
						}

					}
				}
			}
		}
	}

	public function synProductSlugAction()
	{
		$recordPerPage = 500;
		$oracle = new Oracle();
		$getAllGalleriesRow = $this->registry->db->query('SELECT count(*) as R FROM lit_product WHERE p_slug !="" OR p_slug IS NULL')->fetch();
		$total = $getAllGalleriesRow['R'];

		$page = ceil($total/$recordPerPage);
		for($i = 1 ; $i <= $page ; $i++)
		{
			unset($listproductprice);

			set_time_limit(0);
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;
echo '<p>SELECT * FROM lit_product WHERE p_slug !="" OR p_slug IS NOT NULL LIMIT '.$start.','.$end.'</p>';

			$listproductprice = $this->registry->db->query('SELECT * FROM lit_product WHERE p_slug ="" OR p_slug IS NULL LIMIT '.$start.','.$end);
			//var_dump($listproductprice);exit();
			echo '<p>COUNT: '.count($listproductprice).'</p>';
			$iiiii = 1;
			if(!empty($listproductprice))
			{
				while($p = $listproductprice->fetch())
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product
								SET p_slug = ?
								WHERE p_id = ?';
						echo '<p>'.$iiiii++.'-- UPDATE: '.$p['p_name'].' - ' .$p['p_id'].'</p>';
						$stmt = $this->registry->db->query($sql, array(
																(string)Helper::codau2khongdau($p['p_name'], true, true),
																(int)$p['p_id']
															  ));
				}
			}
		}
	}

	public function importProductSlugAction()
	{
		$sql = 'SELECT p_id, p_name, p_slug FROM ' . TABLE_PREFIX . 'product';
		$stmt = $this->registry->db->query($sql);

		while($row = $stmt->fetch())
		{
			if((string)$row['p_slug'] == '')
			{
				$sql = 'UPDATE '.TABLE_PREFIX.'product
					SET p_slug = ?
					WHERE p_id = ?';
				$stmts = $this->registry->db->query($sql , array((string)Helper::codau2khongdau($row['p_name'], true, true) , (int)$row['p_id']));
				if($stmts)
				{
					echo $row['p_id'] . ' is updated<br />';
				}
				else
				{
					echo $row['p_id'] . ' is not updated<br />';
				}
			}
		}
	}

	public function importseovalueattributeAction()
	{

		$record = 1000;
		$total = Core_RelProductAttribute::getRelProductAttributes(array() , 'id' , 'ASC' , '' , true , true);
		$page = ceil($total / $record);



		for($i = 1 ; $i <= $page ; $i++)
		{
			set_time_limit(0);
			unset($relproductattributes);
			$start = ($i * $record) - $record;
			$end = $i * $record;
			$relproductattributes = Core_RelProductAttribute::getRelProductAttributes(array() , 'id' , 'ASC' , $start . ',' . $end);
			foreach($relproductattributes as $relproductattribute)
			{
				if($relproductattribute->valueseo == '')
				{
					if($relproductattribute->updateData())
						echo $relproductattribute->id . '&nbsp;updated<br />';
					else
						echo $relproductattribute->id . '&nbsp;not updated<br />';
				}
			}
		}
	}


	public function testAction()
	{
		$productcategorylist = Core_Productcategory::getProductcategoryListFromCache(true , true);
		echodebug($productcategorylist ,true);
	}

	public function getProductDataAction()
	{
		set_time_limit(0);
		$data = '';
		$rootproductcategoryList = Core_Productcategory::getProductcategorys(array('fparent'=>1) , 'id' , 'ASC');
		$productlist = array();
		$data .= 'Danh mục cha#Danh mục con#ID#Barcode#Tên#Hãng#Hình đại diện‡n#Nội dung#Gallery#Hình 360#Giá#SEO description#Trạng thái#Slug#Bài viết#dienmay.com đánh giá#Hình bộ bán hàng chuẩnn#Video#Bộ bán hàng chuẩn(text)#Sản phẩm liên quan#Sản phẩm bán kèm#Trạng thái ERP#NNgày tạo#Ngày cập nhật#Tồn kho#Sellprice#Loại#Number of Color#Status' . "\n";
		foreach($rootproductcategoryList as $rootcategory)
		{
			//if($rootcategory->id != 462) continue;

			$rootcategory->sublist = Core_Productcategory::getFullSubCategory($rootcategory->id);

			$productlist = Core_Product::getProducts(array('fpcidarrin' => $rootcategory->sublist , 'fisonsitestatus' => 1, 'fcustomizetype' => Core_Product::CUSTOMIZETYPE_MAIN , 'fstatus'=>Core_Product::STATUS_ENABLE) , 'id' , 'ASC');
			foreach($productlist as $product)
			{
                //if($product->customizetype != Core_Product::CUSTOMIZETYPE_MAIN) break;

				$productcategory = new Core_Productcategory($product->pcid , true);
				$data .= $rootcategory->name .'#'. $productcategory->name .'#' . $product->id . '#' . ($product->barcode != '' ? trim((string)$product->barcode) : 'No') . '#' . $product->name . '#'  . ($product->vid > 0 ? 'Yes' : 'No') . '#' . ($product->image != '' ? 'Yes' : 'No');

				// $summary = nl2br($product->summary);
				// $summary = strip_tags($summary);
				// $summary = str_replace (array("\r\n", "\n", "\r"), ';', $summary);
				// if($product->id == 46372)
				// {
				//     echodebug(trim($datas),true);
				// }

				// if(strlen($summary) > 0)
				// {
				//     $explodesum = explode(',', $summary);
				//     $finalsummary = '';
				//     if(count($explodesum) > 0)
				//     {
				//         foreach ($explodesum as $su)
				//         {
				//             $su = trim($su);
				//             if(!empty($su) && $su !='-' && strlen($su) != 0)
				//             {
				//                 $finalsummary .= $su.';';
				//             }
				//         }
				//     }
				//     else
				//         $finalsummary = $summary;

				//     $data .= '#' . $summary;
				// }
				// else
				//     $data .= '#No';

				$data .= strlen($product->summary) > 0 ? '#Yes' : '#No';

				$numbergallery = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_FILE , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numbergallery > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}
				$number360 = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_360 , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($number360 > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->sellprice > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->seodescription != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$data .= '#' . $product->getonsitestatusName();
				$data .= '#' . $product->slug;
				if($product->content != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->dienmayreview != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberimgefullbox = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_SPECIALTYPE , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numberimgefullbox > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofvideo = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_URL , 'fpid' => $product->id) , 'id' , 'ASC', '',true);
				if($numberofvideo > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				if($product->fullboxshort != '')
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofsampleproduct = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype' => Core_RelProductProduct::TYPE_SAMPLE) , 'id' , 'ASC' , '' ,true);

				if($numberofsampleproduct > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$numberofaccessoriesproduct =  Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype' => Core_RelProductProduct::TYPE_ACCESSORIES) , 'id' , 'ASC' , '' ,true);
				if($numberofaccessoriesproduct > 0)
				{
					$data .= '#Yes';
				}
				else
				{
					$data .= '#No';
				}

				$data .= '#' . $product->getbusinessstatusName();
				$data .= "#" . date('d/m/Y' , $product->datecreated);
				$data .= ($product->datemodified != "") ? "#" . date('d/m/Y' , $product->datemodified) : "# ";
				$data .= '#' . $product->instock;
				$data .= '#' . $product->sellprice;
				$data .= ($product->customizetype == Core_Product::CUSTOMIZETYPE_MAIN) ? '#Main' : '#Color';
                //$numberofproductcolor = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $product->id , 'ftype'=>Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '' , true);
                $countcolorlist = explode('###' , $product->colorlist);
                $numberofproductcolor = (count($countcolorlist) > 0) ? count($countcolorlist) -1 : 0;
                $data .= '#' . $numberofproductcolor;

                $data .= '#' . $product->getStatusName();

				$data .= "\n";

			}
			unset($rootcategory);
			unset($productlist);
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productdata-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}


	public function getproductcolorlistAction()
	{
		set_time_limit(0);

		$data = '';

		$data .= 'ID#Barcode#Danh mục cha#Danh mục con#Product Name#Trạng thái#Ngày tạo#Ngày cập nhật#Gallery#Màu';

		$data .= "\n";

		$sql = 'SELECT p_id , p_barcode , p_name , p_customizetype , p_colorlist, pc_id , p_datecreated , p_datemodified , p_businessstaus  FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != "" AND p_onsitestatus > 0';

		$stmt = $this->registry->db->query($sql , array());
		while ($row = $stmt->fetch()) {

			$data .= $row['p_id'] . '#' . trim($row['p_barcode']) . '#';

			$myProductcategory = new Core_Productcategory($row['pc_id'] , true);

			$rootcategorys = Core_Productcategory::getFullParentProductCategorys($row['pc_id']);

			$rootcategory = $rootcategorys[0];				

			$data .= $rootcategory['pc_name'] . '#';
			$data .= $myProductcategory->name . '#';
			$data .= $row['p_name'] . '#';
			$data .= Core_Product::getstaticbusinessstatusName($row['p_businessstaus']) . '#';
			$data .= date('d/m/Y' , $row['p_datecreated']) . '#';
			$data .= date('d/m/Y' , $row['p_datemodified']) . '#';
			$numbergallery = Core_ProductMedia::getProductMedias(array('ftype' => Core_ProductMedia::TYPE_FILE , 'fpid' => $row['p_id']) , 'id' , 'ASC', '',true);
			if($numbergallery > 0)
			{
				$data .= 'Yes#';
			}
			else
			{
				$data .= 'No#';
			}

			if($row['p_customizetype'] == Core_Product::CUSTOMIZETYPE_MAIN) {
                $colorlist = explode('###' , $row['p_colorlist']);
                $colordata = explode(':' , $colorlist[0]);

                $data .= (string)$colordata[2];
            }
            else {
                $relproductproductlist = Core_RelProductProduct::getRelProductProducts(array('fpiddestination' => $row['p_id'] , 'ftype'=>  Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC' , '0,1');
                $relproductproduct = $relproductproductlist[0];
                $colordata = explode(':', $relproductproduct->typevalue);
                $data .= (string)$colordata[0];
            }

            $data .= "\n";


		}
		
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productdata-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function testdataAction()
	{
		$data = file_get_contents('C:/Users/ASUS/Desktop/productdata-2013-06-13-15-15-57.csv');

		file_put_contents('C:/Users/ASUS/Desktop/productdata-2013-06-13-15-15-57-modified.csv', str_replace('$', "\n", $data));
	}

	public function getProductAttributeAction()
	{
		set_time_limit(0);
		$data = '';
		$categorylist = Core_Productcategory::getFullSubCategory(462);

		$data .= 'Barcode#TÃªn s?n ph?m#Thu?c tÃ­nh#GiÃ¡ tr?' . "\n";

		$sql = 'SELECT p_barcode , p_name , pc_id , p_id FROM ' . TABLE_PREFIX .'product
				WHERE pc_id IN(' . implode(',', $categorylist) . ') AND p_onsitestatus = ?';

		$stmt = $this->registry->db->query($sql ,array(Core_Product::OS_ERP));

		while ($row = $stmt->fetch())
		{
			$write = true;
			$productattributes = Core_ProductAttribute::getProductAttributes(array('fpcid'=>$row['pc_id']),'displayorder','ASC');
			foreach ($productattributes as $attr)
			{
				$relproductattribute = Core_RelProductAttribute::getRelProductAttributes(array('fpid'=>$row['p_id'] , 'fpaid'=> $attr->id),'','');

				$attr->value = $relproductattribute[0]->value;
				if($write)
				{
					$data .= trim($row['p_barcode']) . '#' . $row['p_name'] . '#' . $attr->name . '#' . $attr->value . "\n";
				}
				else
				{
					 $data .= '"' . '#' . '"' . '#' . $attr->name . '#' . $attr->value . "\n";
				}
				$write = false;
			}
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productattribute-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function updateonsitestatusAction()
	{
		set_time_limit(0);

		if(isset($_POST['fsubmit']))
		{
			$s1 = (string)$_POST['erp']; //mang nho
			$s2 = (string)$_POST['all']; //mang lon



			$productList1 = explode(',', $s1);
			$productList2 = explode(',', $s2);



			foreach($productList2 as $pid)
			{
				$pid = trim($pid);
				 $sql = 'UPDATE '.TABLE_PREFIX . 'product
							SET p_onsitestatus = ?
							WHERE p_barcode = ?';

				if(in_array($pid, $productList1))
				{
					$stmt = $this->registry->db->query($sql,array(Core_Product::OS_ERP , $pid) );
					if($stmt)
					{
						echo $pid . ' - ' . ' ERP <br />' ;
					}
				}
				else
				{
					$stmt = $this->registry->db->query($sql , array(Core_Product::OS_NOSELL , $pid));
					if($stmt)
					{
						echo $pid . ' - ' . ' NO SELL <br />' ;
					}
				}
			}
		}

		echo '<form method="post">
			<table>
				<tr>
					<td>ERP only</td>
					<td><textarea name="erp" cols="50" rows="20"></textarea></td>
				</tr>
				<tr>
					<td>All</td>
					<td><textarea name="all" cols="50" rows="20"></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="fsubmit" value="Update"/></td>
				</tr>
			</table>
		</form>';

	}


	function checkhtmldescriptionAction()
	{
		set_time_limit(0);
		echo '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';


		$sql = 'SELECT PRODUCTID, PRODUCTNAME, HTMLDESCRIPTION
				FROM product
				WHERE HTMLDESCRIPTION <> "NULL"
				ORDER BY PRODUCTID ASC
				LIMIT 20000';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			echo '<h1>' . $row['PRODUCTNAME'] . '</h1>';

			$description = Helper::specialchar2normalchar($row['HTMLDESCRIPTION']);
			$description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');

			$info = $this->msThamparsinghtmldescription($description);


			$myProduct = new Core_Product($row['PRODUCTID']);
			$myProduct->content = $info['content'];
			$myProduct->updateData();

			//echo $description;
			echo '<hr />';
		}
		echo 'done';
	}

	function msThamparsinghtmldescription($description)
	{
		$info = array();

		//$description = (string)(!empty($pro['HTMLDESCRIPTION'])?$pro['HTMLDESCRIPTION']:'');
		//echodebug($description, true);
		//
		if(!empty($description))
		{
			//echo '<p>DESCRIPTION : '.$pro['PRODUCTID'].': '.$description.' ---END------</p>';exit();
			//$description = html_entity_decode(Helper::specialchar2normalchar($description));


			//$descriptions = preg_replace('@\[one_third(.*?)\](.*?)\[\/one_third]@si','',$description);
			$getContent = preg_split('@\[divider(.*?)\]@si',$description);
			$contentstxt = '';

			//print_r($getContent);

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
			$info['content'] = $contentstxt;


			return $info;

		}
	}

	public function changeproductpriceAction()
	{
		set_time_limit(0);
		$counter = 0;
		$counteroracle = 0;
		$sql = 'SELECT p_barcode FROM '.TABLE_PREFIX.'product
				WHERE p_onsitestatus = ? AND p_barcode != ""';
		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		$timer = new Timer();

		$timer->start();
		$i = 0;
		while($row = $stmt->fetch())
		{
			$oracle = new Oracle();

			$sql = 'SELECT ci.* FROM ERP.VW_CURRENTINSTOCK_DM ci
								WHERE ci.PRODUCTID = \'' . $row['p_barcode'].'\'';

			$counteroracle++;

			$results = $oracle->query($sql);

			//xoa du lieu ton kho cu lien quan den san pham
			$sql = 'DELETE FROM '. TABLE_PREFIX . 'product_stock WHERE p_barcode = ?';
			$rowCounts1 = $this->registry->db->query($sql,  array($row['p_barcode']));

			foreach($results as $res)
			{
				$countProductstock = Core_ProductStock::getProductStocks(array('fpbarcode' =>$row['p_barcode'] , 'fsid' => (int)$res['STOREID']) , 'id' , 'ASC', '');
				if(count($countProductstock) > 0)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product_stock
						SET ps_quantity = ?,
							ps_datemodified = ?
						WHERE p_barcode = ? AND s_id = ?';

					$stmt1 = $this->registry->db->query($sql, array(
								(int)$res['QUANTITY'],
								time(),
								$row['p_barcode'],
								(int)$res['STOREID']
								));

					if($stmt1)
					{
						$counter++;
						unset($stmt1);
					}
				}
				else
				{
					 $sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_stock (
																p_barcode,
																s_id,
																ps_quantity
																)
															VALUES(?, ?, ?)';

					$stmt1 = $this->registry->db->query($sql, array(
							$row['p_barcode'],
							 (int)$res['STOREID'],
							(int)$res['QUANTITY']
							));

					if($stmt1)
					{
						$counter++;
						unset($stmt1);
					}
				}
			}
			unset($results);
		}


		//update product price
		$sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
				WHERE ppa_id = 242 AND po_id = 222
				GROUP BY pp.p_barcode';

		$stmt = $this->registry->db->query($sql);


		while($row = $stmt->fetch())
		{
			if((float)$row['pp_sellprice'] <= 0)
			{

				  $sql = 'SELECT pp.p_barcode, pp.pp_sellprice FROM ' . TABLE_PREFIX . 'product_price pp
				  WHERE ppa_id = 242 AND po_id = 0 AND p_barcode = ' . $row['p_barcode'];
				  $result1 = $this->registry->db->query($sql)->fetch();
				  if((float)$result1['pp_sellprice'] > 0)
				  {
					  $sql = 'UPDATE '. TABLE_PREFIX .'product
							SET p_sellprice = '.(float)$result1['pp_sellprice'].'
							WHERE p_barcode = ' . (string)$row['p_barcode'];

					   //$result = $this->registry->db->query($sql, array((float)$result1['pp_sellprice'],(string)$row['p_barcode']));
					   $result = $this->registry->db->query($sql);
					   //echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
					   $counter++;
				  }
			}
			else
			{
				$sql = 'UPDATE '. TABLE_PREFIX .'product
							SET p_sellprice = '.(float)$row['pp_sellprice'].'
							WHERE p_barcode = ' . (string)$row['p_barcode'];

				//$result = $this->registry->db->query($sql, array((float)$row['pp_sellprice'],(string)$row['p_barcode']));
				$result = $this->registry->db->query($sql);
				//echo '+' .(string)$row['p_barcode'] . $row['pp_sellprice'] .'<br />';
				$counter++;
			}
		}
		echo 'Done';
	}


	function testpriceAction()
	{
		$oracle = new Oracle();

		set_time_limit(0);
		$counter = 0;
		$counteroracle = 0;
		$sql = 'SELECT p_barcode FROM '.TABLE_PREFIX.'product
				WHERE p_onsitestatus = ? AND p_barcode != ""';
		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		while($row = $stmt->fetch())
		{

			$sql = 'select P.PRICEAREAID, P.OUTPUTTYPEID, p.updatedpricedate ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID , P.PRODUCTIDREF
						from ERP.VW_PRICE_PRODUCT_DM P
						INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID
						where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$row['p_barcode']. '\'';

			$results = $oracle->query($sql);


			foreach($results as $res)
			{
				$countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $row['p_barcode'] , 'fppaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','',true);

				if($countProductPrice > 0)
				{
					  $sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
								SET pp_sellprice = ?,
									pp_discount = ?,
									pp_confirm = ?,
									pp_datemodified = ?
								WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
						$stmt1 = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
															(int)$res['DISCOUNT'],
															(int)$res['ISPRICECONFIRMED'],
															time(),
															$row['p_barcode'] ,
															$res['PRICEAREAID'],
															$res['OUTPUTTYPEID'],
															$res['STOREID'],
															$res['AREAID'],
															$res['PROVINCEID']
															));

						if($stmt1)
						{
							$counter++;
							unset($stmt1);
						}
				}
				else
				{
					$sql = 'INSERT INTO ' . TABLE_PREFIX . 'product_price (
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
															VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
						$stmt1 = $this->registry->db->query($sql , array(
															(int)$res['PRODUCTIDREF'],
															trim($row['p_barcode']),
															(int)$res['PRICEAREAID'],
															$res['STOREID'],
															$res['AREAID'],
															$res['PROVINCEID'],
															(int)$res['OUTPUTTYPEID'],
															(float)$res['SALEPRICE'],
															(int)$res['DISCOUNT'],
															(int)$res['ISPRICECONFIRMED'],
															));

						if($stmt1)
						{
							$counter++;
							unset($stmt1);
						}
				}
			}
		}
	}

	public function getproductcontentAction()
	{
		$sql = 'SELECT p_id , p_name , p_content FROM ' . TABLE_PREFIX . 'product WHERE p_content != ""';
		$stmt = $this->registry->db->query($sql);
		$counter = 0;
		while ($row = $stmt->fetch())
		{
			//check http://cdn.tgdt.vn/
			$out = array();
			if(preg_match_all('/cdn.tgdt.vn/', $row['p_content'], $out))
			{
				$content = str_replace('cdn.tgdt.vn', 'ecommerce.kubil.app', $row['p_content']);
				$sql = 'UPDATE ' .TABLE_PREFIX . 'product SET p_content = ? WHERE p_id = ?';
				$stmt1 = $this->registry->db->query($sql , array($content , $row['p_id']));
				if($stmt1)
				{
					$counter++;
				}
			}
		}

		echodebug($counter);
	}

	public function syncattributevalueAction()
	{
		$recordPerPage = 10000;
		$counter = 0;
		set_time_limit(0);
		$counter = Core_RelProductAttribute::getRelProductAttributes(array() , 'id' , 'ASC' , '' ,true);
		$page = ceil($counter/$recordPerPage);
		for ($i=0; $i < $page; $i++)
		{
			$start = $i * $recordPerPage;
			$end = ($i * $recordPerPage) + $recordPerPage;

			$sql = 'SELECT rpa.rpa_id , rpa.rpa_value , rpa.rpa_valueseo FROM '.TABLE_PREFIX.'rel_product_attribute rpa LIMIT ' . $start . ',' . $end;
			$stmt = $this->registry->db->query($sql);
			while ($row = $stmt->fetch())
			{
				if($row['rpa_valueseo'] == Helper::codau2khongdau($row['rpa_value'] , true, true))
				{
					 $sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute
						SET rpa_valueseo = ?
						WHERE rpa_id = ?';
					$stmt1 = $this->registry->db->query($sql , array(Helper::codau2khongdau($row['rpa_value'] , true,true) , $row['rpa_id']));
					unset($row);
					unset($stmt1);
					$counter++;
				}
			}
			unset($stmt);
		}
		echo 'So luong record thuc thi : ' . $counter;
	}

	public function importproductvatAction()
	{
		global $db;
		$counter = 0;
		$oracle = new Oracle();
		//get all product from cms
		$sql = 'SELECT p_id,
					p_barcode
				FROM ' . TABLE_PREFIX . 'product
				WHERE p_onsitestatus = ?';

		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		while ($row = $stmt->fetch())
		{
			//cap nhat vat va isrequestimei
			$sql = 'SELECT ISREQUESTIMEI , VAT , ISSERVICE FROM ERP.PM_PRODUCT WHERE PRODUCTID = \'' . $row['p_barcode'] . '\'';
			$results = $oracle->query($sql);
			if(count($results) > 0)
			{
				$sql = 'UPDATE ' . TABLE_PREFIX . 'product
						SET p_isrequestimei = ? ,
							p_vat = ?,
							p_isservice = ?
						WHERE p_id = ?';

				$stmt1 = $this->registry->db->query($sql , array(
												$results[0]['ISREQUESTIMEI'],
												$results[0]['VAT'],
												$results[0]['ISSERVICE'],
												$row['p_id'],
												));
				if($stmt1)
				{
					$counter++;
					unset($results);
					unset($stmt1);
				}
			}
		}

		echo 'So luong record : ' . $counter;
	}

	//get all product name contain TGDD
	public function gettgddproductnameAction()
	{
		$data = '';
		$sql = 'SELECT p_id , p_name , p_barcode FROM ' .TABLE_PREFIX . 'product
				WHERE p_name LIKE "%TGDD%"';
		$stmt = $this->registry->db->query($sql);

		$data .= 'MÃ£ s?n ph?m#Barcode#TÃªn s?n ph?m' . "\n";

		while ($row = $stmt->fetch())
		{
			$data .= $row['p_id'] . '#' . $row['p_barcode'] . '#' . $row['p_name'] . "\n";
		}


		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productdata-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function importproductcolorpriceAction()
	{
		$counter = 0;
		$oracle = new Oracle();
		$sql = 'SELECT p_barcode , p_id FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		while ($row = $stmt->fetch())
		{
			$productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$row['p_id']), 'id', 'ASC');

			if(count($productcolors) > 0)
			{
				foreach ($productcolors as $productcolor)
				{
					$sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
					$row2 = $this->registry->db->query($sql , array($productcolor->piddestination))->fetch();

					$sql = 'select P.UPDATEDPRICEUSER,P.PRICEAREAID, P.OUTPUTTYPEID, p.UPDATEDPRICEDATE ,P.PRODUCTID, P.SALEPRICE, P.ISPRICECONFIRMED, S.STOREID , S.AREAID, S.PROVINCEID , P.COSTPRICE
							from ERP.VW_PRICE_PRODUCT_DM P
							INNER JOIN ERP.VW_PM_STORE_DM S ON S.PRICEAREAID = P.PRICEAREAID
							where P.ISPRICECONFIRMED = 1 AND P.PRODUCTID =\'' .$row2['p_barcode']. '\'';

					$results = $oracle->query($sql);
					//echodebug($results,true);

					$counteroracle++;

					//xoa thong tin cu ve gia cua san pham
					//$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product_price WHERE p_barcode = ?';
					//$rowCounts2 = $this->registry->db->query($sql, array($row['p_barcode']));

					foreach($results as $res)
					{
						$countProductPrice = Core_ProductPrice::getProductPrices(array('fpbarcode' => $row2['p_barcode'] , 'fpaid' => $res['PRICEAREAID'] , 'fpoid' => $res['OUTPUTTYPEID'], 'fsid' => $res['STOREID'] ,'faid' => $res['AREAID'] , 'frid' => $res['PROVINCEID']),'id','ASC','');

						if(count($countProductPrice) > 0)
						{
							if($res['SALEPRICE'] != $countProductPrice[0]->sellprice)
							{
								$sql = 'UPDATE ' . TABLE_PREFIX . 'product_price
										SET pp_sellprice = ?,
											pp_discount = ?,
											pp_confirm = ?,
											tgdd_uid = ?,
											pp_datemodified = ?
										WHERE p_barcode = ?  AND ppa_id = ? AND po_id = ? AND s_id = ? AND a_id = ? AND r_id = ?';
								$stmt1 = $this->registry->db->query($sql , array((float)$res['SALEPRICE'],
																	(int)$res['DISCOUNT'],
																	(int)$res['ISPRICECONFIRMED'],
																	(int)$res['UPDATEDPRICEUSER'],
																	time(),
																	$row2['p_barcode'] ,
																	$res['PRICEAREAID'],
																	$res['OUTPUTTYPEID'],
																	$res['STOREID'],
																	$res['AREAID'],
																	$res['PROVINCEID']
																	));

								if($stmt1)
								{
									unset($stmt1);
									//cap nhat gia goc cua san pham
									$sql = 'UPDATE ' . TABLE_PREFIX . 'product
											SET p_unitprice = ?
											WHERE p_barcode = ?';
									$stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
																					$row2['p_barcode']
																					   ));
									if($stmt1)
									{
										$counter++;
										unset($stmt1);
									}
								}
							}
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
							$stmt1 = $this->registry->db->query($sql , array(
																	(int)$res['UPDATEDPRICEUSER'],
																	(int)$res['PRODUCTIDREF'],
																	trim($row2['p_barcode']),
																	(int)$res['PRICEAREAID'],
																	$res['STOREID'],
																	$res['AREAID'],
																	$res['PROVINCEID'],
																	(int)$res['OUTPUTTYPEID'],
																	(float)$res['SALEPRICE'],
																	(int)$res['DISCOUNT'],
																	(int)$res['ISPRICECONFIRMED'],
																	));

							if($stmt1)
							{
								$counter++;
								unset($stmt1);
								//cap nhat gia goc cua san pham
								$sql = 'UPDATE ' . TABLE_PREFIX . 'product
											SET p_unitprice = ?
											WHERE p_barcode = ?';
								$stmt1 = $this->registry->db->query($sql, array((float)$res['COSTPRICE'],
																					$row2['p_barcode']
																					   ));
								if($stmt1)
								{
									$counter++;
									unset($stmt1);
								}
							}
						}
					}
					unset($row2);
				}
			}

			unset($row);
			unset($productcolors);
		}


		echo 'So luong record thuc thi la  : ' . $counter;
	}


	public function exportvolumeAction()
	{
		set_time_limit(0);

		$data = '';
		$sql = 'SELECT pc_name , p_id , p_barcode , p_name, p_instock FROM ' . TABLE_PREFIX . 'product p JOIN '.TABLE_PREFIX.'productcategory pc ON p.pc_id = pc.pc_id WHERE p_instock >= 0 AND p_instock < 4 AND p_barcode != ""';
		$stmt = $this->registry->db->query($sql);

		$data .= 'Danh m?c#Id#Barcode#TÃªn s?n ph?m#S? l??ng' . "\n";

		while ($row = $stmt->fetch())
		{
			$data .= $row['pc_name'] . '#' .  $row['p_id'] . '#' . $row['p_barcode'] . '#' . $row['p_name'] . '#' . $row['p_instock'] . "\n";
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productdatavolume-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function testtimedataAction()
	{
		$timer = new Timer();

		$timer->start();

		$products = Core_Product::getallproduct();

		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	public function testdatamysqlAction()
	{

		//$db3 = Core_Backend_Object::getDb();
		// $sql = 'SELECT * FROM ' . TABLE_PREFIX . 'beginminstock WHERE b_month = 6 AND b_year = 2013 and p_barcode = "1000362035001"';
		// $stmt = $db3->query($sql);
		// while ($row = $stmt->fetch())
		// {
		//     echodebug($row);
		// }

		// echodebug(ceil(746351/500));

		// $sql = 'SELECT SUM(b_quantity) AS TOTAL FROM ' . TABLE_PREFIX . 'beginminstock WHERE b_month =6 AND b_year = 2013 and p_barcode="1000362035001"';
		// $row = $db3->query($sql)->fetch();
		// echodebug($row);

		// $sql = 'SELECT COUNT(*) AS TOTAL FROM ' . TABLE_PREFIX . 'outputvoucher';

		// $row = $db3->query($sql)->fetch();

		// echodebug($row,true);
		//echo date('d/m/Y',1367341261);
		//
	   //  $a = Core_ProductAttribute::getProductAttributeInfo(58103);
	   // echodebug( $a);
	   //Core_ProductAttribute::getProductAttributeInfo(58103);
		$people = new ArrayIterator(array('John', 'Jane', 'Jack', 'Judy'));
		$roles  = new ArrayIterator(array('Developer', 'Scrum Master', 'Project Owner'));

		$team = new MultipleIterator($flags);
		$team->attachIterator($people);
		//$team->attachIterator($roles);

		foreach ($team as $member) {
			print_r($member);
		}
	}

	public function checklinkAction()
	{
		$str= 'dfadfadsfasfasfdsfadsfasdfsdfsfasfsad dfasdfasfsadfasfa dfadsfasf fadsfsafsa afadsfasdfa afasfasf afasfasf <a href="http://http://www.thegioididong.com">data</a> dfafsdfas fdfafddsakfjsadjfs hdfadsf hk fdskfj ljfd a fjdskf';
		$sql = 'SELECT p_id , p_name , p_content , pc_id , u_id FROM ' . TABLE_PREFIX . 'product WHERE p_status = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Product::STATUS_ENABLE));

		$data = 'Danh m?c#Id#Name#Have TGDD Link' . "\n";
		while ($row = $stmt->fetch())
		{
			preg_match_all('/thegioididong.com/', $row['p_content'], $out);
			if(count($out[0]) > 0)
			{
				$myCategory = new Core_Productcategory($row['pc_id'] , true);
				$data .= $myCategory->name . '#' .  $row['p_id'] . '#' . $row['p_name'] . '#Yes' ."\n";
			}
		}
		//echodebug($data,true);
		//die();
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'checklink-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function testperformanceAction()
	{
		global $conf;
		$timer = new Timer();

		$timer->start();

		//initialize cache
		$myCacher = new Cacher('catlist',Cacher::STORAGE_REDIS, $conf['redis'][1]);    //2 days
		$myCacher->get();
		$timer->stop();
		echo 'time : ' . $timer->get_exec_time() . '<br />';
	}

	public function syncstoreAction()
	{
		$oracle = new Oracle();
		$counter = 0;

		$sql = 'SELECT * FROM ERP.VW_PM_STORE_DM';
		$rows = $oracle->query($sql);

		foreach ($rows as $row)
		{
			$myStore = new Core_Store($row['STOREID'] , true);
			if($myStore->id > 0)
			{
				$myStore->aid = $row['AREAID'];
				$myStore->paid = $row['PRICEAREAID'];
				$myStore->name = $row['STORENAME'];
				$myStore->address = $row['STOREADDRESS'];
				$myStore->issalestore = $row['ISSALESTORE'];
				$myStore->isbizstockstore = $row['ISBIZSTOCKSTORE'];

				if($myStore->updateData())
				{
					$counter++;
				}
			}
			else
			{
				$myStore->aid = $row['AREAID'];
				$myStore->paid = $row['PRICEAREAID'];
				$myStore->name = $row['STORENAME'];
				$myStore->address = $row['STOREADDRESS'];
				$myStore->issalestore = $row['ISSALESTORE'];
				$myStore->isbizstockstore = $row['ISBIZSTOCKSTORE'];

				if($myStore->addData() > 0)
				{
					$counter++;
				}
			}

		}
		echo 'So luong record thuc thi : ' . $counter;
	}

	public function exportdatasubscriberAction()
	{
		//$campaign = '20130902';
		$campaign = '';
		$sql = 'SELECT s_email FROM ' . TABLE_PREFIX . 'subscriber WHERE s_campaign = ? AND s_datecreated >= ? AND s_datecreated <= ?';
		$data = 'Email' . "\n";
		$stmt = $this->registry->db->query($sql , array($campaign , strtotime('2013/08/30') , strtotime('2013/09/01')));

		while ($row = $stmt->fetch())
		{
			$data .= $row['s_email'] . "\n";
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'Danh sach email subscriber 02-09 -'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function exportuserAction()
	{
		$sql = 'SELECT * FROM ' . TABLE_PREFIX . 'event_user_hours eu
				INNER JOIN ' . TABLE_PREFIX . 'rel_product_event_user rpeu ON eu.eu_id = rpeu.eu_id';


		$stmt = $this->registry->db->query($sql);

		$data = 'Postion#Fullname#Email#Phone' . "\n";
		while ( $row = $stmt->fetch() )
		{
			$data .= $row['rpeu_position'] . '#' . $row['eu_fullname'] . '#' . $row['eu_email'] . '#' . $row['eu_phone'] . "\n";
		}
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'Danh sach email subscriber 02-09 -'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function exportproductlistAction()
	{
		$categorylist = array();
		Core_Productcategory::getCategoryIdTree($categorylist);

		$catlist = array(48,482);

		$data = 'ID#TÃªn#Barcode' . "\n";

		foreach ($catlist as $catid)
		{
			$productlist = Core_Product::getProductIdByCategory($categorylist[$catid]['child']);

			if(count($productlist) > 0)
			{
				foreach ($productlist as $product)
				{
					$data .= $product['p_id'] . '#' . $product['p_name'] . '#' . $product['p_barcode'] . "\n";
				}
			}
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productlist-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function syntitleseotitleproductAction()
	{
		global $db;
		$totalRecord = $db->query('SELECT count(*) FROM '. TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND p_sellprice > 0')->fetchColumn(0);
		$countererp++;
		$recordperpage = 500;
		$totalPage = ceil($totalRecord / $recordperpage);
		$totalaffected = 0;
		for($i = 0; $i < $totalPage; $i++ )
		{
			$offset = $i * $recordperpage;
			$sql = 'SELECT p_id,p_name, p_seotitle  FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" AND p_sellprice > 0
				ORDER BY p_id DESC LIMIT ' . $offset . ', ' . $recordperpage;

			$stmt = $db->query($sql);
			while($row = $stmt->fetch())
			{
				$sqlupdate = 'UPDATE '.TABLE_PREFIX.'product SET p_name = ?, p_seotitle = ? WHERE p_id = ?';
				$name = (string) htmlspecialchars(Helper::xss_clean($row['p_name']));
				$seotitle = (string)htmlspecialchars(Helper::xss_clean($row['p_seotitle']));
				$db->query($sqlupdate, array($name, $seotitle, (int)$row['p_id']));
				//echo $row['p_id'].', ';
				$totalaffected++;
			}
		}
		echo 'Total affected: '.$totalaffected;
	}

	public function syncreviewAction()
	{
		$counter = 0;
		$sql = 'SELECT r_id , r_objectid , r_subobjectid FROM ' . TABLE_PREFIX . 'product_review';

		$stmt = $this->registry->db->query($sql);

		while ($row = $stmt->fetch())
		{
			if((int)$row['r_subobjectid'] == 0)
			{
				$myProduct = new Core_Product((int)$row['r_objectid']);
				$sql = 'UPDATE ' . TABLE_PREFIX . 'product_review
						SET r_subobjectid = ?
						WHERE r_id = ?';
				$result = $this->registry->db->query($sql , array($myProduct->pcid , $row['r_id']));
				if($result)
					$counter++;
			}
		}

		echo 'So luong record thuc thi : ' . $counter;
	}

	public function exportvendorbycategoryAction()
	{
		$sql = 'SELECT pc_id , pc_name FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_status = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Productcategory::STATUS_ENABLE));

		$data = 'TÃªn Danh m?c#??i tÃ¡c' . "\n";
		while ($row = $stmt->fetch())
		{
			$subcategorylist = Core_Productcategory::getFullSubCategory($row['pc_id']);
			$sql = 'SELECT distinct(v_id) FROM ' . TABLE_PREFIX . 'product WHERE pc_id IN (' . implode(',', $subcategorylist) . ')';
			$result = $this->registry->db->query($sql);
			$data .= $row['pc_name'] . '#';
			$vendorlist = '';
			while ($rowresult = $result->fetch())
			{
				$vendor = new Core_Vendor($rowresult['v_id'] , true);
				if($vendor->id > 0)
				{
					  $vendorlist .= $vendor->name . '#';
				}
				unset($vendor);
			}
			$data .=  $vendorlist .  "\n";
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'vendorlist-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function exportproductdataAction()
	{
		set_time_limit(0);
		$counter = 0;
		$sql = 'SELECT p_id , p_name , p_barcode , p_slug FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != ""';
		$stmt = $this->registry->db->query($sql);

		$data = 'ID#TÃªn s?n ph?m#Barcode#Slug' . "\n";
		while ( $row = $stmt->fetch())
		{
			$data .= $row['p_id'] . '#' . $row['p_name'] . '#' . $row['p_barcode'] . '#' . $row['p_slug'] . "\n";
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'dienmay-productlist-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File

	}

	public function restoredataAction()
	{
		$counter = 0;
		$hostcatid = 49;
		$hostattr = array();
		///////////////LAY TAT CA DANH SACH THUOC TINH CUA HOSTCATID
		$sql = 'SELECT pa_id, pa_name FROM ' . TABLE_PREFIX . 'product_attribute WHERE pc_id = ?';
		$stmt = $this->registry->db->query($sql , array($hostcatid));

		while ( $row = $stmt->fetch() )
		{
			$hostattr[$row['pa_id']] = $row['pa_name'];
		}

		unset($stmt);


		$catid = 1786;
		/////LAY TAT CA SAN PHAM CUA DANH MUC CAN RESTORE
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ?';
		$stmt = $this->registry->db->query($sql , array($catid));

		while ( $row = $stmt->fetch() )
		{
			foreach ($hostattr as $paid => $paname)
			{
				//////TIM PA_ID THEO NAME CUA HOST
				$sql = 'SELECT pa_id FROM ' . TABLE_PREFIX . 'product_attribute WHERE pa_name=? AND pc_id = ?';

				$rowresult = $this->registry->db->query($sql,array($paname , $catid))->fetch();

				/////UPDATE DATA
				$sql = 'UPDATE ' . TABLE_PREFIX . 'rel_product_attribute SET pa_id = ? WHERE pa_id= ? AND p_id = ?';
				$result = $this->registry->db->query($sql , array($rowresult['pa_id'] , $paid , $row['p_id']));
				if($result)
					$counter++;
			}
		}
		echo 'so luong record thuc hien : ' . $counter;
	}

	public function importnewstoreAction()
	{
		$counter = 0;
		set_time_limit(0);
		$sql = 'SELECT * FROM ERP.VW_PM_STORE_DM';

		$oracle = new Oracle();
		$results = $oracle->query($sql);

		foreach ($results as $result)
		{
			$myStoret = new Core_Store();

			$myStoret->id = $result['STOREID'];
			$myStoret->name = $result['STORENAME'];
			$myStoret->aid = $result['AREAID'];
			$myStoret->companyid = $result['COMPANYID'];
			$myStoret->storegroupid = $result['STOREGROUPID'];
			$myStoret->storetypeid = $result['STORETYPEID'];
			$myStoret->poareaid = $result['POAREAID'];
			$myStoret->hoststoreid = $result['HOSTSTOREID'];
			$myStoret->ppaid = $result['PRICEAREAID'];
			$myStoret->storeshortname = $result['STORESHORTNAME'];
			$myStoret->storeaddress = $result['STOREADDRESS'];
			$myStoret->storemanager = $result['STOREMANAGER'];
			$myStoret->storephonenum = $result['STOREPHONENUM'];
			$myStoret->storefax = $result['STOREFAX'];
			$myStoret->storecode = $result['STORECODE'];
			$myStoret->taxcode = $result['TAXCODE'];
			$myStoret->taxaddress = $result['TAXADDRESS'];
			$myStoret->companynameprefix = $result['COMPANYNAMEPREFIX'];
			$myStoret->companytitle = $result['COMPANYTITLE'];
			$myStoret->poreceiveaddress = $result['PORECEIVEADDRESS'];
			$myStoret->iscenterstore = $result['ISCENTERSTORE'];
			$myStoret->isrealstore = $result['ISREALSTORE'];
			$myStoret->issalestore = $result['ISSALESTORE'];
			$myStoret->isinputstore = $result['ISINPUTSTORE'];
			$myStoret->iswarrantystore = $result['ISWARRANTYSTORE'];
			$myStoret->isautostorechange = $result['ISAUTOSTORECHANGE'];
			$myStoret->isauxiliarystore = $result['ISAUXILIARYSTORE'];
			$myStoret->isactive = $result['ISACTIVE'];
			$myStoret->issystem = $result['ISSYSTEM'];
			$myStoret->note = $result['NOTE'];
			$myStoret->orderindex = $result['ORDERINDEX'];
			$myStoret->createuser = '';
			$myStoret->createdate = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['CREATEDDATE']);
			$myStoret->updateuser = $result['UPDATEDUSER'];
			$myStoret->updatedate = DateTime::createFromFormat('d-M-y h.i.s.u a', $result['UPDATEDDATE']);
			$myStoret->isdeleted = $result['ISDELETED'];
			$myStoret->deleteuser = $result['DELETEDUSER'];
			$myStoret->deletedate = (strlen($result['DELETEDDATE']) > 0) ? DateTime::createFromFormat('d-M-y h.i.s.u a', $result['DELETEDDATE']) : '' ;
			$myStoret->webstorename = $result['WEBSTORENAME'];
			$myStoret->disctrictid = $result['DISTRICTID'];
			$myStoret->director = $result['DIRECTOR'];
			$myStoret->email = $result['EMAIL'];
			$myStoret->currentip = $result['CURRENTIP'];
			$myStoret->storeipkey = $result['STOREIPKEY'];
			$myStoret->storeipkeysource = $result['STOREIPKEYSOURCE'];
			$myStoret->imagemaplarge = $result['IMAGEMAPLARGE'];
			$myStoret->imagemapsmall = $result['IMAGEMAPSMALL'];
			$myStoret->openhour = $result['OPENHOUR'];

			//get lat lng of store
			$position = $this->getstoreposition($result['STOREID']);
			$myStoret->lat = $position['lat'];
			$myStoret->lng = $position['lng'];

			$myStoret->isrepay = $result['ISREPAY'];
			$myStoret->isdefault = $result['ISDEFAULT'];
			$myStoret->isonlinestore = $result['ISONLINESTORE'];
			$myStoret->rank = $result['RANK'];
			$myStoret->bcnbstorename = $result['BCNBSTORENAME'];
			$myStoret->bcnbstoreid = $result['BCNBSTOREID'];
			$myStoret->bcnbprovinceid = $result['BCNBPROVINCEID'];
			$myStoret->bcnbcompanyid = $result['BCNBCOMPANYID'];
			$myStoret->isshowbcnb = $result['ISSHOWBCNB'];
			$myStoret->provinceid = $result['PROVINCEID'];
			$myStoret->webstoreimage = $result['WEBSTOREIMAGE'];
			$myStoret->isshowweb = $result['ISSHOWWEB'];
			$myStoret->webaddress = $result['WEBADDRESS'];
			$myStoret->isbizstockstore = $result['ISBIZSTOCKSTORE'];
			$myStoret->slug = $position['slug'];
			$myStoret->region = $position['region'];
			$myStoret->image = '';
			$myStoret->description = '';
			$myStoret->isreport = 1;

			if($myStoret->addData() > 0)
			{
				$counter++;
			}

		}

		echo 'So luong record thuc thi : ' . $counter;
	}

	private function getstoreposition($storeid)
	{
		$position = array();

		$sql = 'SELECT s_lat , s_lng , s_slug , s_region FROM ' . TABLE_PREFIX .  'storets WHERE s_id = ?';
		$row = $this->registry->db->query($sql , array($storeid))->fetch();

		$position['lat'] = $row['s_lat'];
		$position['lng'] = $row['s_lng'];
		$position['slug'] = $row['s_slug'];
		$position['region'] = $row['s_region'];

		return $position;
	}

	public function testoracleAction()
	{
		set_time_limit(0);
		//$sql = 'SELECT count(*) FROM ERP.VW_CURRENTINSTOCK_DM';
		$barcode = '1100142075200';
		$sql = 'select ci.* from ERP.vw_currentinstock_dm ci';
		$oracle = new Oracle();

		$results = $oracle->query($sql);
		echodebug($results,true);
	}

	public function importbussinesstatusAction()
	{
		set_time_limit(0);
		$counter = 0;
		$oracle = new Oracle();
		$sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus > 0 AND p_barcode != "" ';

		$stmt = $this->registry->db->query($sql);

		while ( $row = $stmt->fetch() )
		{
			$sql = 'SELECT STATUSID FROM ERP.VW_PRODUCT_DM WHERE PRODUCTID = \'' . $row['p_barcode'] . '\'';
			$results = $oracle->query($sql);
			$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_businessstaus = ? WHERE p_barcode = ?';
			$rowresult = $this->registry->db->query($sql ,  array($results[0]['STATUSID'] , $row['p_barcode']));

			if($rowresult)
				$counter++;
			unset($results);
			unset($rowresult);
		}

		echo 'So luong record thuc thi : ' . $counter ;
	}

	public function synccolorlistAction()
	{
		set_time_limit(0);
		$counter = 0;

		$sql = 'SELECT p_id , p_name FROM ' . TABLE_PREFIX . 'product WHERE p_customizetype=? ORDER BY p_id';
		$stmt = $this->registry->db->query($sql , array(Core_Product::CUSTOMIZETYPE_MAIN));

		while ( $row = $stmt->fetch() )
		{
			$colorlist = $row['p_id'] . ':' . $row['p_name'] . ':KhÃ´ng xÃ¡c ??nh:kxd:1';

			$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_colorlist = ? WHERE p_id = ?';
			$rowdata = $this->registry->db->query($sql ,  array($colorlist , $row['p_id']));
			if($rowdata)
				$counter++;

			unset($colorlist);
		}

		echo 'So luong record thuc thi : ' . $counter;
	}

	public function deleteproductcolorAction()
	{
		set_time_limit(0);
		$sql = 'DELETE FROM ' . TABLE_PREFIX . 'product WHERE p_customizetype = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Product::CUSTOMIZETYPE_COLOR));
		echo 'Done';
	}

	public function updateregionAction()
	{
		$sql = 'SELECT s_id , s_region FROM ' . TABLE_PREFIX . 'storets';
		$stmt = $this->registry->db->query($sql);

		while ( $row = $stmt->fetch())
		{
			$sql = 'UPDATE ' . TABLE_PREFIX . 'store SET s_region = ? WHERE s_id = ?';

			$stmt1  = $this->registry->db->query($sql , array($row['s_region'] , $row['s_id']));
		}
	}

	public function compareskuAction()
	{
		$skuerp = array(1000001044701,1000001040701,1000001040722,1000362032116,1000001040700,1000362035622,1000122031401,1000001047901,1000001046826,1000362035501,1000144001201,1000122031415,1000150035672,1000001048701,1000362032169,1000001048501,1000002057415,1000001047022,1000001044711,1000362035901,1000001047926,1000122031101,1000006041515,1000006041401,1000001048326,1000001048117,1000362035833,1000006041901,1000150035616,1000362034601,1000362035201,1000001048301,1000150036200,1000001047915,1000006042601,1000362035515,1000006042701,1000001047701,1000001048546,1000002057915,1000362035015,1000362035715,1000001040726,1000001047911,1000362035816,1000002053215,1000001047070,1000001045622,1000002053243,1000362034646,2007122046300,1000001048601,1000733008401,1000122031115,1000002055715,1000156035715,1000150036100,1000001046815,1000150035726,1000001048611,1000362035001,2003122086300,1000002058315,1000001047726,1000006042915,1000001048515,1000002058301,1000002057426,1000362035301,1000001047646,1000001048001,2007122045700,1000006041415,1000362034416,1000001046301,1000002053201,1000001047501,2003122101715,1000001047746,1000002056215,1000002058122,1000002053226,1001006006701,1000002057115,1000006042115,2301122050100,2006122067001,1000156035015,1000001048401,1000362036015,1000003040201,1000001047815,2301122050000,1000003040001,1000001047817,1000002058115,1000003040301,2007122047500,1000006043201,1000006042515,1000006042901,1000382036715,1000006041915,1000001045642,1000001048646,1000002056115,1000001046311,1000002058215,1000156036501,1000003040501,1000002054715,1000001047946,1000001047017,1000006042615,1000150035716,1000003040401,1000001047715,1000001048526,1000001047811,1000003040542,1000001045634,1000144000901,1000001048201,1000003040515,1000003040546,1000003039701,1000001046726,1000006042315,1000001047526,1000003040115,1000002057101,1000001048101,1000006043215,1000003037115,1000006042101,1000003040015,1000001048215,1000003040101,1000003037001,2301122055700,1000003040315,1000001048426,1000006043001,2007122046100,1000006041501,1000555000915,1000913001701,1000006042815,1000006042801,1000003039915,1000006042501,1000001047315,1000002057022,1000003038601,1000002054701,1000144001101,1000156034501,1000002057715,1000003040415,1000002056226,1000006041701,1001006006715,1000002057601,1000001047401,1000001046326,1000001047615,2301122048400,2003122101615,2104122063900,1000382036246,1000001048901,1000001048902,1000001048915,1000001048922,2301122059000,1000002057615,1000001047446,1000002044501,1000001048011,2003122075100,1000002057015,1000001047601,1000362035401,1000555000415,1000001048715,1000006042415,1000555000901,1000001048746,1000382037001,1000156036515,1000002057701,1000006042715,1000002051601,1000006042401,1000382036815,1000001048246,1000156036315,1000001048726,1000362034501,1000112001012,1000002056217,1000362034900,1000001048015,1000555001015,1000003036915,1000003039101,1000006041315,1000002051615,1000006043015,1000913001201,1000003040215,1000001047411,1000001048946,1000003040211,1000150030816,1000001046370,1000003037815,1000003037215,1000003036101,1000006039726,1000006042301,1000003037601,1000156035501,1000001047716,1000156035611,1000003037415,1000156036111,1000150035601,2006122060000,1000156034701,1000156034715,2006122047400,1000001046711,1000001047146,1000001043715,2003122078800,1000006041301,1000006042201,1000362036115,1000362034431,1000362036101,1000001045543,1000112000826,1000382034515,1000002045601,1000006040712,1000156036101,1000003039742,1000001048046,2003122074900,1000002058001,1000002058015,1000002058415,1000002057122,1000003040317,1000001049001,1000003038112,1000001049011,1000362034826,1000001045915,1000001047311,1000156036815,1000001049101,1000156033300,2006122060312,1000003036631,1000002055915,1000002058701
);
		$oracle = new Oracle();
		$data = 'SKU#NAME#STATUS' . "\n";
		foreach($skuerp as $sku)
		{
			$sql = 'SELECT count(*) FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
			$rowcount = $this->registry->db->query($sql , array($sku))->fetchColumn(0);
			if($rowcount == 0)
			{
				$sql = 'SELECT PRODUCTNAME , STATUSNAME FROM ERP.VW_PRODUCT_DM WHERE PRODUCTID = \'' . $sku .  '\'';
				$result = $oracle->query($sql);

				$data .=  $sku . '#' . $result[0]['PRODUCTNAME'] . '#' . $result[0]['STATUSNAME'] . "\n";
			}
		}
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'tablet-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function checkproducterpAction()
	{
		set_time_limit(0);
		$counter = 0;
		$oracle = new Oracle();
		$sql = 'SELECT PRODUCTID , PRODUCTNAME , STATUSNAME FROM ERP.VW_PRODUCT_DM';
		$results = $oracle->query($sql);
		foreach($results as $result)
		{
			////////CHECK BARCODE IS EXIT IN WEB
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
			$rowCount = $this->registry->db->query($sql , array($result['PRODUCTID']))->fetchColumn(0);
			if($rowCount == 0)
			{

				$counter++;
			}
		}
	}

	public function exportproductinfoAction()
	{
		set_time_limit(0);
		$pcid = 482; // nganh hang phu kien
		$productcategorylist =  Core_Productcategory::getFullSubCategory($pcid);
		$data = 'Id#Barcode#Name#Slug#FinalPrice#Link' . "\n";
		foreach($productcategorylist as $catid)
		{
			$sql = 'SELECT p_id , p_barcode , p_name , p_slug , p_finalprice FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ?';
			$stmt = $this->registry->db->query($sql , array($catid));
			while($row = $stmt->fetch())
			{
			  $data .= $row['p_id'] . '#' . (strlen($row['p_barcode']) > 0 ? trim($row['p_barcode']) : 'N/A' )  . '#' .  $row['p_name'] . '#' . $row['p_slug'] . '#'  . (int)$row['p_finalprice'] . '#'  .  $this->registry['conf']['rooturl'] . $row['p_slug'] . "\n";
			}
		}
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'danhsachsanphamphukien-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function demoAction()
	{

		//$rootcategory = Core_Productcategory::getProductcategoryListFromCache(true);
		$cat = array();
		Core_Productcategory::getTreeData();

		echodebug(Core_Productcategory::getTreeData(),true);

		$html = '';
		foreach ($categorytree as $rootcatid => $value)
		{
			$html .= $rootcatid . '<br/>';
			foreach ($value['level1'] as $catid)
			{
				$hmtl .= '-' . $catid;
			}
		}
	}


	public function datainfowebAction()
	{
		set_time_limit(0);
		$data = 'SKU#Name#FinalPrice' . "\n";
		$sql = 'SELECT p_barcode , p_name , p_finalprice  FROM ' . TABLE_PREFIX . 'product';
		$stmt = $this->registry->db->query($sql);
		while($row = $stmt->fetch())
		{
			$data .= (strlen($row['p_barcode'])> 0 ?  $row['p_barcode'] : 'N/A' ) . '#' . $row['p_name'] . '#' . (float)$row['p_finalprice'] . "\n" ;
		}
		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productweb-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function syncproductcusAction()
	{
		set_time_limit(0);
		$counter = 0;
		$sql = 'SELECT p_id , p_isrequestimei , p_isservice , pc_id  FROM ' . TABLE_PREFIX . 'product WHERE p_barcode !="" AND p_customizetype = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Product::CUSTOMIZETYPE_MAIN));
		while ($row = $stmt->fetch())
		{
			/////LAY TAT CA CAC SAN PHAM MAU CUA SAN PHAM CHINH
			$productcustlist = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $row['p_id']) , 'id' , 'ASC');
			if(count($productcustlist) > 0)
			{
				foreach($productcustlist as $productcus)
				{
					$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET pc_id = ?, p_isrequestimei = ? , p_isservice =? WHERE p_id = ?';
					$result = $this->registry->db->query($sql , array($row['pc_id'] , $row['p_isrequestimei'] , $row['p_isservice'] , $productcus->piddestination ));
					if($result)
						$counter++;
				}
			}
		}
		echo 'So record thuc thi : ' . $counter;
	}

	public function exportdatawebAction()
	{
		set_time_limit(0);
		$productlist = Core_Product::getProducts(array('fhasbarcode' => 1) , 'id' , 'ASC');
		echodebug($productlist,true);
		$data = 'ProductId#ProductName#Barcode#Content#KeySellingPoint#Image#Onsitestatus#Bussinessstatus' . "\n";
		if(count($productlist) > 0)
		{
			foreach($productlist as $product)
			{
				$data .= $product->id . '#' . $product->name . '#' . $product->barcode;
				$data .= (strlen($product->content) > 0) ? '#Yes' : '#No';
				$data .= (strlen($product->good) > 0) ? '#Yes' : '#No';
				$productmedialist = Core_ProductMedia::getProductMedias(array('fpid'=>$product->id , 'ftype' => Core_ProductMedia::TYPE_FILE) , 'id' , 'ASC' , '' , true);
				$datalist .= (count($productmedialist) > 0) ? '#Yes' : '#No';
				$datalist .= $product->getonsitestatusName() . '#';
				$datalist .= $product->getbusinessstatusName() . "\n";
			}
			$myHttpDownload = new HttpDownload();
			$myHttpDownload->set_bydata($data); //Download from php data
			$myHttpDownload->use_resume = true; //Enable Resume Mode
			$myHttpDownload->filename = 'productweb-'.date('Y-m-d-H-i-s') . '.csv';
			$myHttpDownload->download(); //Download File
		}
	}

	public function storeinfoAction()
	{
		set_time_limit(0);
		$storelist = Core_Store::getStores(array('fissalestore'=>1) , 'id' , 'ASC');
		$html = '<html><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><table>';
		foreach($storelist as $store)
		{
			$html .= '<tr><td>'.$store->id.'</td><td>'.$store->name.'</td></tr>';
		}
		$html .= '</table></html>';
		echo $html;
	}

	public function findcolorAction()
	{
		set_time_limit(0);

		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != "" AND p_onsitestatus = 6';
		$stmt = $this->registry->db->query($sql);

		while($row = $stmt->fetch())
		{
			$countercolor = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $row['p_id']) , 'id' , 'ASC' , '', true);
			if($countercolor > 0)
			{
				echodebug($row['p_id'] , true);
			}

		}
	}

	public function syncinfoproductcolorAction()
	{
		set_time_limit(0);
		$counter = 0;

		$sql = 'SELECT p_id , p_isrequestimei , p_isservice , pc_id FROM '. TABLE_PREFIX .'product WHERE p_onsitestatus = ? AND p_barcode != "" ';

		$stmt = $this->registry->db->query($sql , array(Core_Product::OS_ERP));

		while ( $row = $stmt->fetch())
		{
			$productcolorlist = Core_RelProductProduct::getRelProductProducts(array('fpidsource' => $row['p_id'] , 'ftype' => Core_RelProductProduct::TYPE_COLOR) , 'id' , 'ASC');
			if(count($productcolorlist) > 0)
			{
				foreach ($productcolorlist as $productcolor)
				{
					$myProductColor = new Core_Product($productcolor->piddestination);
					if($myProductColor->id > 0)
					{
						$myProductColor->pcid = $row['pc_id'];
						$myProductColor->isrequestimei = $row['p_isrequestimei'];
						$myProductColor->isservice = $row['p_isservice'];

						if($myProductColor->updateData())
						{
							$counter++;
						}
					}
				}
			}
		}
		echo 'So luong record thuc thi ' . $counter;
	}

	public function checkbarcodesameAction()
	{
		set_time_limit(0);
		$counter = 0;
		$sql = 'SELECT p_barcode FROM ' . TABLE_PREFIX . 'product WHERE p_barcode !="" ORDER BY p_id';
		$stmt = $this->registry->db->query($sql);
		$data = 'Barcode#TÃªn sáº£n pháº©m 1#Tráº¡ng thÃ¡i sp1#TÃªn sáº£n pháº©m 2#Tráº¡ng thÃ¡i sp2' . "\n";
		while($row = $stmt->fetch())
		{
			//kiem tra xem barcode nay co bi trung lap hay khong
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product WHERE p_barcode = ?';
			$resultcounter = $this->registry->db->query($sql , array($row['p_barcode']))->fetchColumn(0);

			if($resultcounter > 1)
			{
				$sql = 'SELECT p_name , p_businessstaus FROM ' . TABLE_PREFIX  . 'product WHERE p_barcode = ?';
				$resultset = $this->registry->db->query($sql , array($row['p_barcode']) );
				$data .= trim($row['p_barcode']) . '#';
				while($result = $resultset->fetch())
				{
					$data .= $result['p_name'] . '#' . Core_Product::getstaticbusinessstatusName($result['p_businessstaus']) . '#';
				}
				$data .= "\n";
			}
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'productweb-'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function getalloutputvoucherAction()
	{
		set_time_limit(0);
		$recordPerPage = 1000;
		$counter = 0;
		$total = 0;
		$oracle = new Oracle();
		$db3 = Core_Backend_Object::getDb();

		$startdate = strtoupper(date('d-M-y' , strtotime('2013/08/01')));
		$sql = 'SELECT COUNT(*) AS TOTAL FROM ERP.VW_OUTPUTVOUCHER_DM WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\')';
		$countAll = $oracle->query($sql);
		echo 'So record ERP : ' . $countAll . '<br/>';
		foreach ($countAll as $count)
		{
			$total = $count['TOTAL'];
		}

		$totalpage = ceil($total/$recordPerPage);
		for ($i = 1 ; $i <= $totalpage ; $i++)
		{
			$start = ($recordPerPage * $i) - $recordPerPage;
			$end = $recordPerPage * $i;

			$sql = 'SELECT * FROM (SELECT ov.PRODUCTID , ROWNUM r FROM ERP.VW_OUTPUTVOUCHER_DM ov WHERE OUTPUTDATE >= TO_DATE(\''.$startdate .'\')) WHERE r > ' . $start .' AND r <=' . $end;
			$results = $oracle->query($sql);

			foreach ($results as $result)
			{
				$sql = 'INSERT INTO ' . TABLE_PREFIX . 'outoutvoucher_tmp(p_barcode) VALUES(?)';
				$resultset = $db3->query($sql , array($result['PRODUCTID']));
				if($resultset)
					$counter++;
			}
		}

		echo 'So luong record thuc thi :' . $counter;

	}

	public function checkskuwebAction()
	{
		set_time_limit(0);

		$db3 = Core_Backend_Object::getDb();
		$oracle = new Oracle();
		$sql = 'SELECT distinct(p_barcode) FROM ' . TABLE_PREFIX . 'outputvoucher_tmp';

		$stmt = $db3->query($sql);
		$data = 'SKU#Barcode#Tráº¡ng thÃ¡i' . "\n";
		while ( $row = $stmt->fetch() )
		{
			$counter = Core_Product::getProducts(array('fbarcode' => $row['p_barcode']) , 'id' , 'ASC' , '0,1' , true);
			if($counter == 0)
			{
				/////LAY THONG TIN SAN PHAM TU ERP
				$sql = 'SELECT PRODUCTNAME , PRODUCTID , STATUSNAME FROM ERP.VW_PRODUCT_DM WHERE PRODUCTID = \'' . $row['p_barcode'] .  '\'';
				$result = $oracle->query($sql);

				$data .= $result[0]['PRODUCTID'] . '#' . $result[0]['PRODUCTNAME'] . '#' . $result[0]['STATUSNAME'] ."\n";
			}
		}

		$myHttpDownload = new HttpDownload();
		$myHttpDownload->set_bydata($data); //Download from php data
		$myHttpDownload->use_resume = true; //Enable Resume Mode
		$myHttpDownload->filename = 'sku'.date('Y-m-d-H-i-s') . '.csv';
		$myHttpDownload->download(); //Download File
	}

	public function offproductwebAction()
	{
		set_time_limit(0);
		$counter = 0;
		$productlist = array(2702122007900,2702122008000,2702122010800,2702122011000,2702261000400,2702018000400,2702009000900,2702270000400,2702122015200,2702122016300,2702122011100,2702261000100,2702122018600,2702215000100,2701184000300,2701184000500,2701194000200,2712209000100,2701122006600,2701122001800,2702122002000,2701184000800,2701122002700,2702122012800,2701122002900,2702122013000,2702122008400,2702122003000,2701122004600,2701122004800,2701256000100,2701122004000,2701122008200,2701122000901,2701122005100,2703122004200,2703122004300,2703122003000,2703122004400,2703204000200,2703122007300,2703122007700,2703122003100,2703122000100,2703122005400,2703122004700,2703122005000,2703214000200,2703122008800,2703122003300,2703122005100,2703122002500,2702122005700,2703215001700,2703206003400,2702122006200,2702122019300,2703204001100,2702122006400,2703122006800,2703215002700,2702122014400,2703271000300,2702122010500,2703201000500,2703201000900,2703201001400,2702122014000,2714122048500,2714122048600,2701122006300,2714122057000,2714122049800,2714122048900,2701122006500,2714122023800,2714122034900,2714122052900,2714215001900,2714122035200,2714122023700,2714122014200,2714122027800,2713205002900,2716122002500,2714189003100,2714122028600,2714189005300,2714122031200,2714122031400,2714122031500,2714122031700,2714122031800,2714189000400,2714122014500,2714122033200,2714122029000,2714122040600,2714189003300,2714122005100,2714122002600,2714122005500,2714122005600,2714122005800,2714122005900,2714122049500,2714217001800,2714193000400,2714122029400,2714122017600,2714122027100,2714122039600,2714122043400,2714217002300,2714193000600,2714122029500,2714215002700,2714189002700,2714193000800,2714199000100,2714199000300,2714304002400,2714304002500,2714304002600,2714192000800,2720122000100,2706188000600,2706209000600,2706006000700,2706006000100,2706209000500,2703261001400,2723122000700,2708261000100,2708122000600,2708209001000,2708122001100,2708002001200,2708209000100,2708122000900,2708211000600,2708211001400,2708211001100,2708211001200,2708209000600,2707122001200,2707194000300,2707122001000,2707122001900,2707208003100,2707208000400,2707208001700,2707256000100,2707208002300,2707215000600,2707215000500,2707122002000,2707122001600,2714122050800,2709183000700,2709183000600,2709183000200,2706188000800,2719210000100,2709205000100,2710182000900,2710182000300,2712122001200,2712184000300,2712122000500,2719122007900,2719313000200,2719313000300,2719269000900,2717122000100,2717122000200,2718122002800,2718122002900,2718122000900,2718122002317,2719122003400,2719218001100,2719122006900,2717122000800,2719192000400,2717122001800,2719122001900,2719018000800,2719009000100,2719009000200,2719122000800,2719217001000,2719218000400,2717122001600,2717122002900,2717122001700,2719122004000,2719122003900,2719122009500,2719122007700,2719256001800,2719256001400,2717122001900,2719192000300,2719018000500,2719122006000,2719018000900,2719018000600,2719122005900,2719009001700,2719122006700,2719256000700,2717122002600,2719122003100,2719122008800,2719122010600,2719009001800,2719122007300,2713205002100,2713205001500,2713205002300,2713205002500,2713205001900,2713205002000,2719192001400,2719018001000,2719122002500,2719009001100,2719122006400,2713200000100,2713205000300,2714217003200,2714122045200,2714122045600,2714122003500,2714122003600,2714189001600,2714122044900,2714122011100,2714211002000,2714122008900,2714122009000,2714122009200,2714122010100,2714186000100,2714186000500,2714122032600,2714122013400,2714122055900,2714122022300,2714122022100,2714122022700,2714122022900,2714122050700,2714122037700,2714122037800,2714122038000,2714122038100,2714122038200,2714122038300,2714122037000,2714122036900,2714122037200,2714122037300,2714122008000,2714201001400,2714122026100,2714211000900,2714211001300,2714211000600,2714217000100,2714217001600,2714122027500,2714122048100,2714122039900,2714122008700,2714122009700,2714122012800,2714211002700,2714122018900,2714122048300,2714122043100,2714122057900,2714122058000,2714122017400,2714122017300,2714122054800,2714122035100,2714122012700,2714122012600,2714122038600,2714122038700,2714122042000,2714122057800,2714122057700,2714122053600,2714122010900,2714122010600,2714211001100,2714122027400,2714122047700,2714217001300,2714189001100,2714189001300,2714122021900,2714189004800,2714189000800,2714189000900,2714189001000,2714189000200,2714189000100,2714122011700,2714122033500,2714189005800,2714122044300,2714122044500,2714221000500,2714221000900,2714253000600,2714122035700,2714215003500,2714217000200,2714217000400,2714217000500,2714217003500,2714122038500,2714122032500,2714122040400,2714122008400,2714122008200,2714270000300,2714217001400,2714122049900,2714122001300,2714122061500,2716177000500,2716122004100,2716195001311,2716195000430,2716105000100,2716175000700,2716177002800,2716195000170,2716195000126,2716195001226,2716195001126,2716250000500,2716177001700,2716122007700,2716122003500,2716122003700,2716122003600,2716122009000,2716250000600,2716122007900,2716122005400,2716286000170,2716122002600,2716195002400,2716195001800,2716105001700,2716122010500,2716177003300,2716195000643,2716195000521,2716018000500,2716018000600,2716210000100,2716122009300,2716195002103,2716195002003,2716122006400,2716122006900,2716105001504,2716122003200,2716122007300,2716122007400,2716122009900,2716018001300,2718122000400,2718271000200,2718271000300,2718122002600,2718122003026,2718122003042,2718122003122,2718018002400,2718009001900,2718009002000,2718009002100,2718018000900,2718018001000,2718009000500,2714304002900,2714122053700,2715122000900,2714122008300,2714188000800,2714122004400,2719009001600,2705223000600,2705223000100,2705196000122,2705196000400,2721122000200,2721122000100,2701189000200,2701122001000,2701215000300,2701215000400,2701122005500,2715122000700,2715122000500,2715196000100,2715196000300,2715196000800,2715196000500,2715196000600,2715196000900,2715196001300,2715122000200,2715122000300,);
		foreach($productlist as $barcode)
		{
			$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_onsitestatus = ? WHERE p_barcode = ?';
			$stmt = $this->registry->db->query($sql , array(Core_Product::OS_NOSELL , $barcode));
			if($stmt)
			{
				$counter++;
			}
		}

		echo 'Sá»‘ lÆ°á»£ng record thá»±c thi : ' . $counter ;
	}

	public function checkcategoryAction()
	{
		set_time_limit(0);

		$sql = 'SELECT pc_id , pc_name FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_status = ?';
		$stmt = $this->registry->db->query($sql , array(Core_Productcategory::STATUS_ENABLE));

		while($row = $stmt->fetch())
		{
			/////KIEM TRA XEM DANH MUC NAY CO DANH MUC CON HAY KHONG
			$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_parentid = ? AND pc_status = ?';
			$counter = $this->registry->db->query($sql, array($row['pc_id'] , Core_Productcategory::STATUS_ENABLE))->fetchColumn(0);

			if($counter > 0)
			{
				////KIEM TRA XEM DANH MUC NAY CO SAN PHAM HAY KHONG
				$sql = 'SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'product WHERE pc_id = ?';
				$productcounter = $this->registry->db->query($sql , array($row['pc_ic']))->fetchColumn(0);

				if($productcounter > 0)
				{
					echo $row['pc_name'] . '----So luong danh muc con : ' . $counter . '----So luong san pham : ' . $productcounter . '<br/>';
				}
			}
		}
	}

	public function importproductsummarynewAction()
	{
		set_time_limit(0);
		$counter = 0;
		$sql = 'SELECT p_id , p_summary FROM ' . TABLE_PREFIX . 'product WHERE p_summary !=""';
		$stmt = $this->registry->db->query($sql);
		$summaryinfolist = array();
		while($row = $stmt->fetch())
		{
			$summarynew = '';
			$summarynew = strip_tags($row['p_summary']);
			$summarynew = str_replace(array('<p>' , '</p>'  , '<br>' , '<br/>'  , '&nbsp;' , "\n" , '=&gt;' ,"\r\n", "\n", "\r" , '&nbsp') , '#' , $summarynew );
			$summarypart = explode('#' , $summarynew);

			if(count($summarypart) > 0)
			{
				foreach($summarypart as $summarydata)
				{
					if(strlen($summarydata) > 0)
					{
						$summarylistinfo[$row['p_id']][] = $summarydata;
					}
				}
			}
		}

		if(count($summarylistinfo) > 0)
		{
			foreach($summarylistinfo as $pid => $psummarynew)
			{
				$sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_summarynew = ? WHERE p_id = ?';
				$stmt = $this->registry->db->query($sql , array( implode('#',$psummarynew) , $pid ) );
				if($stmt)
					$counter++;
			}
		}

		echo 'So luong record thuc thi la : ' . $counter;
	}


	public function getstoreinfoAction()
	{
		set_time_limit(0);

		$oracle = new Oracle();

		$sql = 'SELECT * FROM ERP.VW_PM_STORE_DM';

		$results = $oracle->query($sql);

		echodebug($results , true);
	}

	public function createticketautoAction()
	{
		set_time_limit(0);

		$uid = (int)$_GET['uid'];

		$counter = 0;

		$accesstickettypelist = array(1 => 'pview_',
										2 => 'padd_',
										3 => 'pedit_',
										4 => 'pdelete_',
										5 => 'pcview_',
										6 => 'pcadd_',
										7 => 'pcedit_',
										8 => 'pcdelete_',
										);

		$rootproductcategoryList = array(43, 102 , 48, 462, 122, 1282, 1783, 482);

		foreach( $rootproductcategoryList as $rootcategory )
		{
			foreach ( $accesstickettypelist as $accesstickettype => $suffix)
			{
				$myAccessTicket = new Core_AccessTicket();

				$myAccessTicket->uid = $uid;
				$myAccessTicket->uidissue = $this->registry->me->id;
				$myAccessTicket->tickettype = $accesstickettype;

				$myAccessTicketType = new Core_AccessTicketType($accesstickettype);

				$myAccessTicket->groupcontroller = $myAccessTicketType->groupcontroller;
				$myAccessTicket->controller = $myAccessTicketType->controller;
				$myAccessTicket->action = $myAccessTicketType->action;

				$suffixdata = $suffix . $rootcategory;
				$myAccessTicket->suffix = $suffixdata;
				$fullticket = $myAccessTicket->groupcontroller . '_' . $myAccessTicket->controller . '_' . $myAccessTicket->action . '_' . $suffixdata;

				$myAccessTicket->fullticket = $fullticket;
				$myAccessTicket->status = Core_AccessTicket::STATUS_ENABLE;

                if($myAccessTicket->addData())
                {
                    $success[] = $this->registry->lang['controller']['succAdd'];
                    $this->registry->me->writelog('accessticket_add', $myAccessTicket->id, array());

                    $counter++;
                }
                else
                {
                    $error[] = $this->registry->lang['controller']['errAdd'];
                }
			}
		}

		$accesstickettypelist = array(9 => 'nview_',
										10 => 'nadd_',
										11 => 'nedit_',
										12 => 'ndelete_',);
		$rootcategorynews = array(122 , 114 , 187, 189);

		foreach( $rootcategorynews as $rootcategory )
		{
			foreach ( $accesstickettypelist as $accesstickettype => $suffix)
			{
				$myAccessTicket = new Core_AccessTicket();

				$myAccessTicket->uid = $uid;
				$myAccessTicket->uidissue = $this->registry->me->id;
				$myAccessTicket->tickettype = $accesstickettype;

				$myAccessTicketType = new Core_AccessTicketType($accesstickettype);

				$myAccessTicket->groupcontroller = $myAccessTicketType->groupcontroller;
				$myAccessTicket->controller = $myAccessTicketType->controller;
				$myAccessTicket->action = $myAccessTicketType->action;

				$suffixdata = $suffix . $rootcategory;
				$myAccessTicket->suffix = $suffixdata;
				$fullticket = $myAccessTicket->groupcontroller . '_' . $myAccessTicket->controller . '_' . $myAccessTicket->action . '_' . $suffixdata;

				$myAccessTicket->fullticket = $fullticket;
				$myAccessTicket->status = Core_AccessTicket::STATUS_ENABLE;

                if($myAccessTicket->addData())
                {
                    $success[] = $this->registry->lang['controller']['succAdd'];
                    $this->registry->me->writelog('accessticket_add', $myAccessTicket->id, array());

                    $counter++;
                }
                else
                {
                    $error[] = $this->registry->lang['controller']['errAdd'];
                }
			}
		}

		echo 'So luong record thuc thi : ' . $counter;
	}

    public function checkbarcodeAction()
    {
        set_time_limit(0);

        $barcode_lit = array(
            2206122011714 , 2206122011701 , 2104122095100 , 2104122095101 , 2104122095117 , 2104122094900 , 2104122094917 , 2104122094922 , 2104122094970 , 2104122095211 , 2104122095200 , 2104122095311 , 2104122095201 , 2104122094811 , 2104122094800 , 2104122094817 , 2104122094814 , 2104122095011 , 2104122095000 , 2104122095017 , 2104122095014
                        );
		$i = 1;
        foreach($barcode_lit as $barcode)
        {
            $sql = 'SELECT p_id , p_name FROM ' .TABLE_PREFIX . 'product WHERE p_barcode = ?';
            $row = $this->registry->db->query($sql , array($barcode))->fetch();
			if(empty($row))
			{
				echo $i . '.  Barcode  : ' . $barcode . ' chua ton tai trong he thong . <br/>';
				$i++;
			}
        }
    }

    public function updatefinalpriceAction()
    {
        set_time_limit(0);

        $counter = 0;

        $sql = 'SELECT p_id , p_name , p_barcode , p_finalprice , p_sellprice, p_onsitestatus , p_status FROM ' . TABLE_PREFIX . 'product WHERE p_onsitestatus = ? AND p_sellprice > 0 AND p_finalprice = 0 AND p_status = ?';

        $stmt = $this->registry->db->query($sql ,  array(Core_Product::OS_ERP , Core_Product::STATUS_ENABLE));

        while( $row = $stmt->fetch() )
        {
            //echodebug($row);
            //update finalprice
            $sql = 'UPDATE ' . TABLE_PREFIX . 'product SET p_finalprice = ?  WHERE p_id=?';
            $resultset = $this->registry->db->query($sql , array( $row['p_sellprice']  , $row['p_id'] ));

            if($resultset)
            {
                $counter++;
            }
        }

        echo 'So luong record thuc thi la : ' . $counter;

    }


    public function testfastAction()
    {
        $parentlist = Core_Productcategory::getFullparentcategoryInfo(962);

        echodebug($parentlist,true);
    }

    public function fastAction()
    {
    	$sql = 'update ' . TABLE_PREFIX . 'product set p_colorlist = ? WHERE p_id = 59936';
    	$stmt = $this->registry->db->query($sql , array(' 59936:Nắp gập Iphone 4 Mercury:Đen:000000         :1###61863:Nắp gập Iphone 4 Mercury:Đỏ:FF0000          :0###61864:Nắp gập Iphone 4 Mercury:hồng:F7C6CE         :0###60395:Nắp gập Iphone 4 Mercury:Hồng:FF00FF     :0###60430:Nắp gập Iphone 4 Mercury:Xanh lá cây:00FF00    :0###60435:Nắp gập Iphone 4 Mercury:Xanh đậm:94BD7B   :0' , ));
    }

    public function syncproductmediumAction()
    {
    	ini_set('memory_limit', '1024M');
		set_time_limit(0);

		//FTP List
		$resourceserverFtpList = array(
			array('id' => 1, 'ipaddress' => '172.16.141.40', 'username' => 'admin', 'password' => 'Dienmay#2013!')
		);


		//List of item need to be upload to resource server
		$queueList = array();
		$successCount = $errorCount = 0;

		////////////////////////////////////////////////////////
		//	PRODUCTMEDIA
		$itemList = Core_ProductMedia::getProductMedias(array('fhasfile' => 1), 'id', 'DESC', '');
		if(count($itemList) > 0)
			foreach($itemList as $item)
				$queueList[] = array('type' => 'productmedia', 'obj' => $item, 'image' => $item->file, 'directory' => $this->registry->setting['product']['imageDirectory']);


		//For demo, get first 10 item to test
		//$queueList = array_splice($queueList, 0, 10);

		//////////////////
		/////////////////
		if(count($queueList) == 0)
		{
			echo 'No resource need to be uploaded.';
		}
		else
		{
			//////////////
			//Connect to FTP Server
			try
			{
				$ftpServer = $resourceserverFtpList[0];
				$myFtp = new Ftp();
				$myFtp->connect($ftpServer['ipaddress']);
				$myFtp->login($ftpServer['username'], $ftpServer['password']);
				$myFtp->pasv(true);
			}
			catch(FtpException $e)
			{
				die('Error: ' . $e->getMessage());
			}

			/////////////
			//Connect OK, PUT file to ftp server
			$createdDirectoryList = array();

			foreach($queueList as $queue)
			{
				//Tien hanh upload toi resource server thong qua FTP
				$destinationFilePath = $queue['directory'] . $queue['image'];
				$sourceFilePath = $queue['directory'] . $queue['image'];
				if($queue['image'] != '')
				{
					if(file_exists($sourceFilePath))
					{
						$extPart = substr(strrchr($queue['image'],'.'),1);
						$lastSlashPos = strrpos($destinationFilePath, '/');

						//PROCESS DIRECTORY ON REMOTE SERVER
						//if not existed, create this directory
						$filename = substr($destinationFilePath, $lastSlashPos + 1);
						$filedir = substr($destinationFilePath, 0, $lastSlashPos);

						if(!in_array($filedir, $createdDirectoryList))
						{
							$myFtp->mkDirRecursive($filedir);
							$createdDirectoryList[] = $filedir;
						}



						//////////
						//Directory OK, start upload file
						try
						{
							$myFtp->put($destinationFilePath, $sourceFilePath, FTP_BINARY);

							//If run here, it means upload big file ok

							//Checking medium file
							$nameThumbPart = substr($queue['image'], 0, strrpos($queue['image'], '.'));
				            $nameThumb = $nameThumbPart . '-medium.' . $extPart;

				            $destinationFilePathThumb = $queue['directory'] . $nameThumb;
							$sourceFilePathThumb = $queue['directory'] . $nameThumb;

							$resourceserverpassed = false;
							if(file_exists($sourceFilePathThumb))
							{
								$myFtp->put($destinationFilePathThumb, $sourceFilePathThumb, FTP_BINARY);

								//it goest here, mean big and thumb is uploaded to resource server
								$resourceserverpassed = true;
							}
							else
							{
								$resourceserverpassed = true;
							}

						}
						catch(FtpException $e)
						{
							echo 'Can not Upload file ' . $sourceFilePath . '. ' . "\n";
							$errorCount++;
							continue;
						}//end PUT file
					}//end file_exists()
					else
					{
						$errorCount++;
						echo 'File not found: ' . $sourceFilePath . '. ' . "\n";
					}
				}//end empty image


			}//end looping

			//close connection
			$myFtp->close();
		}

		////
		echo 'Success Count: ' . $successCount . '. Error Count: ' . $errorCount;
    }

    public function updatequanhuyenAction()
    {
    	global $db;

		$listregiontempl = $db->query('SELECT DISTRICTID, DISTRICTNAME, PROVINCEID FROM lit_region_tmp');
		if ($listregiontempl) {
			while($row = $listregiontempl->fetch()) {
				echodebug('SELECT r_id FROM lit_region WHERE r_name LIKE "%'.Helper::plaintext($row['r_name']).'%" AND r_parentid = '.$row['PROVINCEID']);
				$oneregion = $db->query('SELECT r_id FROM lit_region WHERE r_name LIKE "%'.Helper::plaintext($row['DISTRICTNAME']).'%" AND r_parentid = '.$row['PROVINCEID'])->fetch();
				if (!empty($oneregion)) {
					$db->query('UPDATE lit_region SET r_districtcrm = '.$row['DISTRICTID'].' WHERE r_id = '.$oneregion['r_id']);
				}
			}
		}
    	/*$listallregions = $db->query('SELECT r_name, r_id, r_parentid FROM lit_region WHERE r_parentid > 0');
    	if ($listallregions) {
    		while ($row = $listallregions->fetch()) {
    			echodebug('SELECT DISTRICTID FROM lit_region_tmp WHERE DISTRICTNAME = "'.Helper::plaintext($row['r_name']).'" AND PROVINCEID = '.$row['r_parentid']);
    			$listregiontempl = $db->query('SELECT DISTRICTID FROM lit_region_tmp WHERE DISTRICTNAME = "'.Helper::plaintext($row['r_name']).'" AND PROVINCEID = '.$row['r_parentid'])->fetch();
    			if ($listregiontempl) {
    				if ($listregiontempl['DISTRICTID'] > 0) {
    					$db->query('UPDATE lit_region SET r_districtcrm = '.$listregiontempl['DISTRICTID'].' WHERE r_id = '.$row['r_id'].'');
    				}
    			}
    		}
    	}*/
    }
}