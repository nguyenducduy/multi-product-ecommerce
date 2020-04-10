<?php 
    Class ExtractPrice_Tgdd extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="price-discount">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<\/cite><\/span>[\r\t\n\s]+<del>(?P<orginalprice>[0-9.]+)/';
		    $promoprice    = '/<cite class="price">(?P<promoprice>[0-9.]+)/';

		    $promotioninfo = '/<span itemprop="description">(?P<promotioninfo>[^\$]+)<\/span>[\r\t\n\s]+<\/div>[\r\t\n\s]+<\/div>[\r\t\n\s]+<\/div>[\r\t\n\s]+<table class="b-order"/';

		    $image         =  '/<div class="fixcenter">[\r\t\n\s]+<img src=\'(?P<image>[\w:\/\.-]+)\'\s/';

		    $description   = '/<div class="productspec">(?P<description>[^\$]+)<\/div>[\r\t\n\s]+<div id="product-other"/';
		    $productname   = '/<h1 class="product-title">(?P<productname>[^\$]+)<\/h1>/';

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
			
			$data['image']          = !empty($final4['image'][0])?$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>
