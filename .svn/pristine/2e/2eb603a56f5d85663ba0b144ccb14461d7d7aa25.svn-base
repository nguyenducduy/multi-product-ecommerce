<?php

Class Controller_Stat_MonitorMetric Extends Controller_Stat_Base
{
	public function indexAction()
	{

		//URL will parsing data from graphite
		$dataUrl = 'http://' . $this->registry->setting['statsd']['host'] . ':8080/render/?format=json';

		//check format -Number...
		if(isset($_GET['from']) && $_GET['from'] != '' && preg_match('/^-\d+/', $_GET['from']))
			$dataUrl .= '&from=' . $_GET['from'];

		if(isset($_GET['target']) && $_GET['target'] != '')
		{
			$targetList = explode(',', $_GET['target']);

			foreach($targetList as $target)
				$dataUrl .= '&target=' . trim($target);
		}

		//Get data from Graphite
		$jsonData = file_get_contents($dataUrl);

		header('Content-type: text/json');
		echo $jsonData;


	}



}


