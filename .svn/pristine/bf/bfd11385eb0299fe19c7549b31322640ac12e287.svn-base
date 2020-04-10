<?php 
    Class ExtractPrice_NguyenKim extends ExtractPrice{
        public function run($file)
        {

            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#<span id="(sec_discounted_price_([0-9]*))"([A-Za-z0-9_="-\s]*)>([0-9\.]*)<\/span>#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[4][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<span id="sec_old_price_[0-9]+" class="list-price nowrap">(?P<orginalprice>[0-9\.]+)/u';
			$promoprice    = '/class="price-num">(?P<promoprice>[0-9.]+)/u';
			$promotioninfo = '/<label id="option_description_[0-9_]+" class="option-items">(?P<promotioninfo>[^\$]*)<\/label>/';
			$image         = '/class="cm-image-previewer cm-previewer" href="(?P<image>[\w\S]+)"/';
			$description   = '/id="content_description" class="wysiwyg-content">(?P<description>[^\$]*)<\/div>[\s\t\r\n]+<div id="content_features"/';
			$productname   = '/<div class="block_product-title">(?P<productname>[^\<\>]*)<\/div>/';
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
			$data['image']        = !empty($final4['image'][0])?"http://nguyenkim.com".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }

    }
?>