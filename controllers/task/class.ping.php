<?php

Class Controller_Task_Ping Extends Controller_Task_Base
{

	function indexAction()
	{
		echo substr($_SERVER['SERVER_ADDR'], strrpos($_SERVER['SERVER_ADDR'], '.') + 1);

		//print_r( $this->registry->me);
		//echo 'hello from background task';
		//$stmt = $this->registry->db->query('SELECT COUNT(*) FROM ' . TABLE_PREFIX . 'ac_user');
		//echo $stmt->fetchColumn(0);

		//test master
		//$this->registry->db->query('INSERT INTO test(text) VALUES("a")', array());

		//test slaver
		//echo $this->registry->db->query('SELECT count(*) FROM test', array())->fetchColumn(0);

	}


}

