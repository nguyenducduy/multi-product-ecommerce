<?php 
	 Class ExtractPrice_SoSanhGia extends ExtractPrice{
        public function run($file)
        {
        	$domainInternal = array('dienmay.com','www.dienmay.com','mediamart.vn');
		    $paternlink = '/class=\'go-button\'  onclick="window\.open\(\'\/redirect.php\?id=(?P<enemyid>[0-9]+)/';
		    $result = preg_match_all($paternlink, $file, $final);
		    $resultArray = array();
		    foreach ($final['enemyid'] as $key => $enemyid) {
		        $link = "http://www.sosanhgia.com/go.php?id=".$enemyid;
		        $html = file_get_contents($link);
		        $host = parse_url($html,PHP_URL_HOST);
		        if(!in_array($host, $domainInternal))
		        	$resultArray[] = $html;
		    }
		    return $resultArray;
        }
    }