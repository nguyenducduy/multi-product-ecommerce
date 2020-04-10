<?php 
    Class ExtractPrice_Fptshop extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#class="price-discount">([0-9\.\s]*)#';
            preg_match_all($parttern, $file, $match);
            return str_replace(".","",$match[1][0]);
        }
        public static function getInfo($file)
        {
		    $orginalprice  = '/class="prod_dt_price">(?P<orginalprice>[0-9.]+)/u';
            $promoprice    = '/label class="price_Onl" ><span(?| itemprop="price")*>(?P<promoprice>[\s0-9.]+)/u';

            $promotioninfo = '/<ul class="discoption">(?P<promotioninfo>[^\$]+)<\/ul>[\r\t\n\s]+<\/div>[\r\t\n\s]+<\/div>[\r\t\n\s]+<div class="thongso"/';

            $image         =  '/<img itemprop="image" content="(?P<image>[^"]+)"\s/';

            $description   = '/span itemprop="description">(?P<description>[^\$]+)<\/ul>[\r\t\n\s]+<\/span>/';
            $productname   = '/<span itemprop="name" style="text-transform: uppercase;">(?P<productname>[\w:\/\.-\s"\']*)<\/span>/'; 

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
