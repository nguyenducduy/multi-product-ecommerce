<?php 
    Class ExtractPrice_DienMayChoLon extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="price-discount">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
        }
        public static function getInfo($file)
        {
			$orginalprice  = '#<a class="price">(?P<orginalprice>[0-9\.]+)\s#';
		    $promoprice    = '#<a class="price-discount">(?P<promoprice>[\s0-9\.]+)\s#';
		    $promotioninfo = '/<li ([\w="-\:\s\']*) class=\'bt_tooltip_root\'>(?P<promotioninfo>[^\<\>]+)/';
		    $image         = '/<div class="image_main_part">[\r\t\n\s]+<img src="(?P<image>[^\"]+)" ([\w="-\:\s\.]*)>[\r\t\n\s]+<\/div>[\r\t\n\s]+<div class="image_zoom_video_part">/';
		    $description   = '/<li class="info-highlights-f4">(?P<description>[^\$]*)<\/li>[\r\t\n\s]+<li class="info-highlights-f6"/';
		    $productname   = '/<span class="breakcrumb_title_cl_black">(?P<productname>[^\<\>]*)<\/span>/';
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
			
			$data['image']          = !empty($final4['image'][0])?"http://dienmaycholon.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
		/*$imageurl = !empty($final4['image'][0])?"http://dienmaycholon.vn".$final4['image'][0]:"";
	if($imageurl != "")
		$data['image'] = $this->getResource("/",$imageurl,'uploads/pimages/Enemy/');
	else
		$data['image'] 		= "";
	*/
?>
