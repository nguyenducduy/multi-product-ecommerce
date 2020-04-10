<?php 
    Class ExtractPrice_MaiNguyen extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="prod_dt_price">([0-9\.]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/ class="prod_dt_price">(?P<price>[0-9.]+)/u';
			$promoprice    = '/ class="prod_dt_price">(?P<promoprice>[0-9.]+)/u';
			$promotioninfo = '/<p class="block_title"><span>(?P<promotioninfo>[^\<\>]+)<\/span><\/p>/';

			$image         =  '/class="cprod_dt_img producta">[\s\r\t\n]+<img src="(?P<image>[\w:\/\.-]+)"/u';
			
			$description   = '/<div class="tab_col_left grid_572" [\w\:\-\;\=\"\s\r\t\n]+>(?P<description>[^\$]+)<\/div><!-- END: tab_col_left -->/u';
			$productname   = '/<h1 class="left_block_title"><span>(?P<productname>[^\<\>]*)<\/span>/';  
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
			$data['image']          = !empty($final4['image'][0])?"http://mainguyen.vn".$final4['image'][0]:"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>