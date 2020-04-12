<?php
	//Main Database (Master)
	$conf['db']['host'] = 'localhost';
	$conf['db']['name'] = 'dienmay';
	$conf['db']['user'] = 'root';
	$conf['db']['pass'] = 'root';

	//Main Database (Replicate 01)
	$conf['db_replicate01']['host'] = 'localhost';
	$conf['db_replicate01']['name'] = 'dienmay';
	$conf['db_replicate01']['user'] = 'root';
	$conf['db_replicate01']['pass'] = 'root';

	//Main Database (Replicate 02)
	$conf['db_replicate02']['host'] = 'localhost';
	$conf['db_replicate02']['name'] = 'dienmay';
	$conf['db_replicate02']['user'] = 'root';
	$conf['db_replicate02']['pass'] = 'root';

	////////////////////////////////////////////////////

	//Backend Database (Master)
	$conf['db3']['host'] = 'localhost';
	$conf['db3']['name'] = 'dienmay_backend';
	$conf['db3']['user'] = 'root';
	$conf['db3']['pass'] = 'root';

	//Redis #1 Information
	$conf['redis'][0]['ip'] = 'localhost';
	$conf['redis'][0]['port'] = 6379;

	$conf['redis'][1]['ip'] = 'localhost';
	$conf['redis'][1]['port'] = 6379;

	//Memcache #1 Information
	//$conf['memcached'][0]['ip'] = '172.16.141.90';
	$conf['memcached'][0]['ip'] = 'localhost';
	$conf['memcached'][0]['port'] = 11211;


	$conf['sphinx'][0]['ip'] = 'localhost';
	$conf['sphinx'][0]['port'] = '9312';
