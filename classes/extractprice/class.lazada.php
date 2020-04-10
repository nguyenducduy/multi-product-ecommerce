<?php
Class ExtractPrice_Lazada Extends ExtractPrice
{
	public $url = '';
	public $pattern = '';

	public function run($file)
	{
        // /id="(price_box|special_price_box)">(\s)*(.|[0-9])*/
        $parttern = '#id="special_price_box">([0-9\.]*)#';
        preg_match_all($parttern, $file, $match);
        return (float)str_replace(".","",$match[1][0]);
	}
	public static function getInfo($file)
    {
		$orginalprice  = '/<span id="price_box">(?P<orginalprice>[0-9\.]+)\s/';
	    $promoprice    = '/<span id="special_price_box">(?P<promoprice>[0-9\.]+)\s/u';
	    $promotioninfo = '/<span id="option_description_[0-9_]+">(?P<promotioninfo>[^\$]+)<\/span>/';
	    $image         = '/src="(?P<image>[\w:\/\.-]+)"[\s\r\t\n]+itemprop="image"/u';

	    $description   = '/<div class="prd-description">(?P<description>[^\$]*)<\/div>[\t\r\n\s]+<div id="productSpecifications"/';
	    $productname   = '/<h1 id="prod_title" itemprop="name">(?P<productname>[^\<\>]*)<\/h1>/';
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