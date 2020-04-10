<?php
ini_set('memory_limit','4000M');
Class Controller_Cron_Reportingdata Extends Controller_Cron_Base
{
	public function indexAction()
	{

	}

	public function listbrandAction()
	{
		set_time_limit(0);
		$db3 = $this->getDb('db_replicate02');
		$counterAll = $db3->query('SELECT count(*) FROM '.TABLE_PREFIX.'product WHERE v_id <=0')->fetchColumn(0);
		if ($counterAll > 0 )
		{
			header('Content-Type: text/html; charset=utf-8');
			echo '<table border="1" align="center"><tr><th>STT</th><th>Barcode</th><th>Mã sản phẩm</th><th>Tên sản phẩm</th></tr>';
			$counter = 1;
			for ($i = 0; $i <$counterAll; $i+=500)
			{
				$results = $db3->query('SELECT p_name, p_id, p_barcode FROM '.TABLE_PREFIX.'product WHERE v_id <=0 AND p_customizetype ='.Core_Product::CUSTOMIZETYPE_MAIN.' LIMIT '.$i.', 500');
				if (!empty($results))
				{
					foreach ($results as $row)
					{
						$myProduct = new Core_Product($row['p_id'], true);
						$listproductcolor = $myProduct->getProductColor();

						if (!empty($listproductcolor))
						{
							foreach ($listproductcolor as $itemcolor)
							{
								$myproductcolor = new Core_Product($itemcolor);
								if ($myproductcolor->id >0)
								{
									echo '<tr>';
									echo '<td>'.$counter.'</td>';
									echo '<td>'.trim($myproductcolor->barcode).'</td>';
									echo '<td>'.trim($myproductcolor->id).'</td>';
									echo '<td>'.trim($myproductcolor->name).'</td>';
									echo '</tr>';
									$counter++;
								}
							}
						}
					}
				}
			}
			echo '</table>';
		}
	}

	public function pricesegmentAction()
	{
		set_time_limit(0);
		$db3 = $this->getDb('db_replicate02');

		//header('Content-Type: text/html; charset=utf-8');
		//	echo '<table border="1" align="center"><tr><th>STT</th><th>Barcode</th><th>Mã sản phẩm</th><th>Tên sản phẩm</th></tr>';
	}

	private function getDb($db = 'db')
	{
		global $conf;
		$dbconnect = null;
		try
			{
				$dbconnect = new MyPDO('mysql:host=' . $conf[$db]['host'] . ';dbname=' . $conf[$db]['name'] . '', '' . $conf[$db]['user'] . '', '' . $conf[$db]['pass'] . '');
				$dbconnect->query('SET NAMES utf8');
			}
			catch(PDOException $e)
			{
				$error = $e->getMessage();
				die('Can not connect to Dienmay FrontEnd DB. <!-- '.$error.'-->');
			}
		return $dbconnect;
	}
}