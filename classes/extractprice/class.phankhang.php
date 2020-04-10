<?php 
    Class ExtractPrice_PhanKhang extends ExtractPrice{
        public function run($file)
        {

            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#<span id="(sec_discounted_price_([0-9]*))"([A-Za-z0-9_="-\s]*)>([0-9\.]*)<\/span>#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[4][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<a class="price">(?P<orginalprice>[0-9\.]+)\s/';
		    $promoprice    = '/<div id=productOldPriceNumber>(?P<promoprice>[0-9\.]+)/';

		    $promotioninfo = '/<div id=quatangItemName>(?P<promotioninfo>[^\<\>]+)<\/div>/';

		    $image         = '/<div id=productImage><img id=Product[0-9]+ src="(?P<image>[^\"]+)"/';

		    $description   = '/<div id="tab-1">(?P<description>[^\$]*)<\/div><div id="tab-2">/';
		    $productname   = '/<div id=productName>(?P<productname>[^\<\>]+)<\/div>/';
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
			$data['image']        = !empty($final4['image'][0])?"http://phankhang.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }

    }
?>