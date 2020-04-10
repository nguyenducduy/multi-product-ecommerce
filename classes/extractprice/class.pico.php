<?php 
    Class ExtractPrice_Pico extends ExtractPrice{
        public function run($file)
        {            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="supPrice">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            $match = str_replace(".","",$match[1][0]);
          	return $match;             	
            
        }
         public static function getInfo($file)
        {
			 $orginalprice  = '/<span id="price_box">(?P<orginalprice>[0-9\.]+)\s/';
		    $promoprice    = '/<span class="supPrice">(?P<promoprice>[0-9\.]+)\s/u';
		    $promotioninfo = '/<div class="detail_offer"><ul>(?P<promotioninfo>[^\$]+)<\/ul><\/div><\/dd><dt/';
		    $image         = '/href="(?P<image>[\w\S]+)" class="jqzoom"/';

		    $description   = '/<span id="Home_ContentPlaceHolder_main_Content_BodyControlPlace_uc_ProductDetail_lbDescr">(?P<description>[^\$]*)<\/span>[\t\r\n\s]+<\/div>[\t\r\n\s]+<div class="clear"\s/';
		    $productname   = '/<div class="item_detail_title"><h1>(?P<productname>[^\<\>]*)<\/h1>/';  
			$data = array();
			$result1 = preg_match_all($orginalprice, $file, $final1);
			$result2 = preg_match_all($promoprice, $file, $final2);
			$result3 = preg_match_all($promotioninfo, $file, $final3);
			$result4 = preg_match_all($image, $file, $final4);
			$result5 = preg_match_all($description, $file, $final5);
			$result6 = preg_match_all($productname, $file, $final6);
			$data['price']          = !empty($final1['orginalprice'][0])?str_replace(".", ",", $final1['orginalprice'][0]):"";
			$data['promotionprice'] = !empty($final2['promoprice'][0])?str_replace(".", ",", $final2['promoprice'][0]):"";
			$data['promotioninfo']  = !empty($final3['promotioninfo'][0])?strip_tags($final3['promotioninfo'][0]):"";
			$data['image']         	= !empty($final4['image'][0])?"http://pico.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>