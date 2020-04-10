<?php 
    Class ExtractPrice_Tiki extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#<span id="(sec_discounted_price_([0-9]*))"([A-Za-z0-9_="-\s]*)>([0-9\,]*)<\/span>#';
            preg_match_all($parttern, $file, $match);
            return str_replace(",","",$match[4][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<span class="price" [^>]*?>(?P<orginalprice>[^<]+)/';
		    $promoprice    = '/<span itemprop="price" class="price">(?P<promoprice>[^<]+)/';
		    $promotioninfo = '/<div class="item-new-promotion no-freegift">[\r\t\n\s]+<ul>(?P<promotioninfo>[^\$]+)[\r\t\n\s]+<\/ul>[^>]*/';
		    $image         = '/<img id="imageMain[0-9]+" src="(?P<image>[^$>"]+)"/';
		    $description   = '/<section class="additional-content">(?P<description>[^\$]+)<\/section>/';
		    $productname   = '/<h1 class="item-name" itemprop="name">(?P<productname>[^\<\>]+)<\/h1>/'; 
			$data = array();
			$result1 = preg_match_all($orginalprice, $file, $final1);
			$result2 = preg_match_all($promoprice, $file, $final2);
			$result3 = preg_match_all($promotioninfo, $file, $final3);
			$result4 = preg_match_all($image, $file, $final4);
			$result5 = preg_match_all($description, $file, $final5);
			$result6 = preg_match_all($productname, $file, $final6);
			$data['price']          = !empty($final1['orginalprice'][0])?$final1['orginalprice'][0]:"";
			$data['promotionprice'] = !empty($final2['promoprice'][0])?$final2['promoprice'][0]:"";
			$data['promotioninfo']  = !empty($final3['promotioninfo'][0])?strip_tags($final3['promotioninfo'][0]):"";
			$data['image']         		= !empty($final4['image'][0])?htmlspecialchars_decode($final4['image'][0]):"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>