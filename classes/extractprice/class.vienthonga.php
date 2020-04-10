<?php 
    Class ExtractPrice_Vienthonga extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="price-discount">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/class="prod_dt_price">(?P<orginalprice>[0-9,]+)/u';
			$promoprice    = '/span id="sec_discounted_price_[0-9]+" class="price">(?P<promoprice>[0-9,]+)<\/span>/';
			
			$promotioninfo = '/<div class="kmdetails">(?P<promotioninfo>[^\$]+)<\/div>[\r\t\n\s]+<div class="share_social"/';
			
			$image         =  '/<img class="[\w\s\']"  id="det_img_[0-9_-]+" src="(?P<image>[\w:\/\.-]+)"\s/';
			
			$description   = '/<div id="content_block_description" class="wysiwyg-content">(?P<description>[^\$]+)<\/div>[\r\t\n\s]+<div id="content_block_features"/';
			$productname   = '/<h1 class="mainbox-title">(?P<productname>[^\$]+)<\/h1>/';

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
			
			$data['image']          = !empty($final4['image'][0])?"http://www.vienthonga.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>
