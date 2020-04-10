<?php 
    Class ExtractPrice_TopCare extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="prod_dt_price">([0-9\.]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<a class="price">(?P<orginalprice>[0-9\.]+)\s/';
		    $promoprice    = '/<p class="cssPrice-temp1">(?P<promoprice>[\s0-9\.]+)\s/';

		    $promotioninfo = '/<div class="productDetail-sale">(?P<promotioninfo>[^$]+)<\/div>[\r\t\n\s]+<div class="clear"><\/div>[\r\t\n\s]+<\/div>[\r\t\n\s]+<div class="productDetail-ShippingInfo">/';

		    $image         = '/class="imgProduct" onmouseover="showProductImage\([^\$]+\)"><img src="(?P<image>[^\"]+)"/';

		    $description   = '/<div class="product-summary">(?P<description>[^\$]*)<\/div>[\r\t\n\s]+<div class="productDetail-price"/';
		    $productname   = '/<div class="product-name"><h1>(?P<productname>[^\<\>]*)<\/h1>/'; 
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
			$data['image']          = !empty($final4['image'][0])?"http://www.topcare.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>