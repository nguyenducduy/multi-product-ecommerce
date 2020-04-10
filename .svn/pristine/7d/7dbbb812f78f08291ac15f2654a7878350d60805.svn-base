<?php 
    Class ExtractPrice_HC extends ExtractPrice{
        public function run($file)
        {            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="supPrice">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            $match = str_replace(".","",$match[1][0]);
          	return $match;             	
            
        }
         public static function getInfo($file)
        {
		    $orginalprice  = '/<a class="price">(?P<orginalprice>[0-9\.]+)\s/';
		    $promoprice    = '/<span class="price" title="Gọi 1800-1788 để có giá KM mới nhất">(?P<promoprice>[0-9\.]+)/';

		    $promotioninfo = '/<div class="product-view-promo">(?P<promotioninfo>[^$]+)<\/div>[\r\t\n\s]+<div class="clearer/';

		    $image         = '/<p class="product-image">[\r\t\n\s]+<a href="(?P<image>[^\"]+)"/';

		    $description   = '/<div class="short-description">(?P<description>[^\$]*)<\/div>[\r\t\n\s]+<!--##GIÁ ĐẶC BIỆT##-->/';
		    $productname   = '/<div class="product-name">[\r\t\n\s]+<h1>(?P<productname>[^\<\>]*)<\/h1>/';
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
			$data['image']         	= !empty($final4['image'][0])?$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>