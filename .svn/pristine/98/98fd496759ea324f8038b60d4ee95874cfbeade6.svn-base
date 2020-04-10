<?php 
    Class ExtractPrice_ThienHoa extends ExtractPrice{
        public function run($file)
        {
            // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
            $parttern = '#<span id="(sec_discounted_price_([0-9]*))"([A-Za-z0-9_="-\s]*)>([0-9\,]*)<\/span>#';
            preg_match_all($parttern, $file, $match);
            return str_replace(",","",$match[4][0]);
            
        }
        public static function getInfo($file)
        {
			$orginalprice  = '/<span id="sec_list_price_[0-9]+" class="list-price nowrap">(?P<orginalprice>[0-9\,]+)/u';
		    $promoprice    = '/id="sec_discounted_price_[0-9]+" class="price">(?P<promoprice>[0-9\,]+)/u';
		    $promotioninfo = '/<span id="option_description_[0-9_]+">(?P<promotioninfo>[^\$]+)<\/span>/';
		    $image         = '/id="detailed_href1_[0-9]+" href="(?P<image>[\w\S]+)"/';
		    $description   = '/<div id="content_block_description" class="wysiwyg-content">(?P<description>[^\$]*)<\/div>[\t\r\n\s]+<div id="content_block_106+" class="wysiwyg-content hidden"/';
		    $productname   = '/<h1 class="mainbox-title">(?P<productname>[^\<\>]*)<\/h1>/';

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
			$data['image']         		= !empty($final4['image'][0])?"http://www.dienmaythienhoa.vn".htmlspecialchars_decode($final4['image'][0]):"";
			$data['description']    = $final5['description'][0];
			$data['productname']    = !empty($final6['productname'][0])?$final6['productname'][0]:"";
			return $data;
        }
    }
?>