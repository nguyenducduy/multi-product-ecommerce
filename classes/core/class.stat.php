<?php

Class Core_Stat extends Core_Object
{

	const TYPE_SALE_ORDER_VALUE = 101;//Tổng giá trị voucher (đơn hàng)
	const TYPE_SALE_ORDER_VOLUME = 102;//Tổng số lượng voucher (đơn hàng)
	const TYPE_SALE_ITEM_VALUE = 111;//Tổng doanh thu có vat
	const TYPE_SALE_ITEM_VALUE_NOVAT = 112;//Tổng doanh thu chưa VAT
	const TYPE_SALE_ITEM_VOLUME = 113;//Tổng số lượng bán

	const TYPE_SALE_COSTPRICE = 121;//Giá vốn bán
	const TYPE_PROFIT_ITEM = 201;//lợi thuận bán
	const TYPE_PROFIT_ORDER = 202;//lợi nhuận đơn hàng (voucher)

	const TYPE_STOCK_VALUE = 301;//tổng giá trị tồn kho (begintermstock)
	const TYPE_STOCK_VOLUME = 302;//Tổng số lượng tồn kho
	const TYPE_STOCK_VOLUME_BEGIN = 303;//tổng so luong ton dau ky
	const TYPE_STOCK_VALUE_BEGIN = 304;	//tổng giá trị tri gia ton dau ky sum(sl*costprice)

	const TYPE_REFUND_VALUE = 401;//Thanh toán (doanh thu) trả lại co +v
	const TYPE_REFUND_VOLUME = 402;//Tổng số lượng trả
	const TYPE_REFUND_COSTPRICE = 403;//Giá vốn trả lại
	const TYPE_REFUND_VALUE_NOVAT = 404;//Doanh thu trả lại (chua v)

	const TYPE_INPUT_VOLUME = 501;//Tổng SL Nhập Mua
	const TYPE_INPUT_VALUE = 502;//Tổng trị giá Nhập Mua
	const TYPE_INPUT_INTERNAL_VOLUME = 503;//SL Nhập Nội bộ
	const TYPE_INPUT_INTERNAL_VALUE = 504;//TG Nhập Nội bộ
	const TYPE_INPUT_REFUND_SALE_VOLUME = 505;//SL Nhập trả hang ban theo nhap xuat
	const TYPE_INPUT_REFUND_SALE_VALUE = 506;//TG Nhập trả hang ban theo nhap xuat
	const TYPE_INPUT_OTHER_VOLUME = 507;//SL Nhập khác
	const TYPE_INPUT_OTHER_VALUE = 508;//TG Nhập khác
	const TYPE_INPUT_BEGINTERM_VOLUME = 509;//TG Nhập khác
	const TYPE_INPUT_BEGINTERM_VALUE = 510;//TG Nhập khác
	const TYPE_INPUT_REFUND_REV_VOLUME = 511;//SL Nhập trả hang ban theo doanh thu
	const TYPE_INPUT_REFUND_REV_VALUE = 512;//TG Nhập trả hang ban theo doanh thu
	const TYPE_INPUT_REFUND_REV_VALUEVAT = 513;//Thanh toán trả lại

	const TYPE_OUTPUT_VOLUME = 601;//SL Xuất bán
	const TYPE_OUTPUT_VALUE = 602;//TG Xuất bán
	const TYPE_OUTPUT_INTERNAL_VOLUME = 603;//SL Xuất nội bộ
	const TYPE_OUTPUT_INTERNAL_VALUE = 604;//TG Xuất nội bộ
	const TYPE_OUTPUT_REFUND_SALE_VOLUME = 605;//SL Xuất trả hang mua
	const TYPE_OUTPUT_REFUND_SALE_VALUE = 606;//TG Xuất trả hang mua
	const TYPE_OUTPUT_OTHER_VOLUME = 607;//Xuất khác
	const TYPE_OUTPUT_OTHER_VALUE = 608;//Xuất khác
	const TYPE_OUTPUT_BEGINTERM_VOLUME = 609;//Xuất khác
	const TYPE_OUTPUT_BEGINTERM_VALUE = 610;//Xuất khác

	const TYPE_PRODUCTREWARD = 700;//DIEM THUONG

	const TYPE_PROMOTION_COSTPRICE = 800;//TG KM

	const TYPE_CUSTOMER_VIEWS	= 900;// số lượng khách vào siêu thị trong store

	const TYPE_VIEW = 901;
	const TYPE_NUMBER_OF_PRODUCT = 902;

	const TOPITEM_DAY_REVENUE	= 10000;
	const TOPITEM_DAY_VOLUME	= 11000;
	const TOPITEM_DAY_PROFIT	= 12000;
	const TOPITEM_DAY_TRAFFIC	= 13000;

	const TOPITEM_WEEK_REVENUE	= 20000;
	const TOPITEM_WEEK_VOLUME	= 21000;
	const TOPITEM_WEEK_PROFIT	= 22000;
	const TOPITEM_WEEK_TRAFFIC	= 23000;

	const TOPITEM_MONTH_REVENUE	= 30000;
	const TOPITEM_MONTH_VOLUME	= 31000;
	const TOPITEM_MONTH_PROFIT	= 32000;
	const TOPITEM_MONTH_TRAFFIC	= 33000;

	const PRODUCTATTRIBUTE_VENDOR 		= 40000;
	const PRODUCTATTRIBUTE_PRICESEGMENT = 41000;
	const PRODUCTATTRIBUTE_ATTRIBUTE = 42000;

	const CACULATE_PRODUCTCACHE = 52000;

	private function connectRedis()
	{
		global $conf;
		$redis = new Redis();
        $redis->connect($conf['redis'][1]['ip'], $conf['redis'][1]['port']);
		return $redis;

	}

	/**
	 * Get The statistic value base on type
	 * @param $type: Interger
	 * @param $parameters: Array of parameter used for specified type
	 * @param $issum: Boolean: if True, return to SUM of array value, FALSE to return array list
	 * @param $datebegin: UNIX Timestamp
	 * @param $dateend: UNIX Timestamp
	 */
	public static function getData($type, $parameters, $datebegin = 0, $dateend = 0)
	{
		global $conf;
        $dataFinal = array();

		//Date Time OK
		if($datebegin > 0 && $dateend > 0 && $datebegin < $dateend)
		{
			//Get Date List in range
			$dateList = self::extractDateList($datebegin, $dateend);
			$monthList = self::extractMonthList($datebegin, $dateend);

			////////////////////////////////////
			// DATA WILL RETURN
			$data = array();
			$selecteddaterange = array();

			//init data in month
			foreach($monthList as $month)
			{
				$mymonth = str_replace('/', '', $month);
				$data[$month] = array();
				for($i = 0; $i < 31; $i++)
				{
					$mday = $month .'/'. sprintf('%02d', $i+1);
					$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
				}
			}

			//check only selected input daterange to return
			foreach($dateList as $date)
			{
				$selecteddaterange[] = str_replace('/', '', $date);
			}

			////////////////////////////////////
			//Build REDIS key suffix
			$rKey = ':' . self::getDataSaleCacheKeyPrefix($type, $parameters);

			/////////////////////
			//CHECK REDIS key list
			$redisKeyList = array();
			foreach($monthList as $month)
			{
				$plainmonth = str_replace('/', '', $month);
				$key = $plainmonth . $rKey;
				//if (Core_Stat::TYPE_NUMBER_OF_PRODUCT == $type) echodebug($key);
				$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
				$cacheData = $myCacher->get();


				/*$redis = new Redis();
				$redis->connect('172.16.141.60', 6379);
				$a = $redis->get($key);
				echodebug($a);*/
				//Not existed, not found key
				if(!$cacheData)
				{
					//Du lieu trong thang nay chua co cai nao het
					//boi vi chua tim ra key cho thang nay
				}
				else
				{
					//Da tim ra key cho thang nay
					//Can kiem tra them cac ngay trong thang nay da co du lieu chua
					$monthdata = explode(',', $cacheData);

					//update cac ngay de danh dau la da co trong cache
					for($i = 0; $i < count($monthdata); $i++)
					{
						$dateincache = $month .'/'. sprintf('%02d', $i+1);
						$dateincachecompare = str_replace('/', '', $dateincache);
						//just get the data in selected range dates
						if(in_array($dateincachecompare, $selecteddaterange))
							$data[$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
					}
				}
			}

			//REFINE DATA FOR EACH DAY
			foreach($data as $plainmonth => $dateData)
			{
				foreach($dateData as $date => $dateInfo)
				{
					//Neu da co data roi thi khong can lay lai
					if($dateInfo['iscached'] == 1 && !empty($dateInfo['value']))
					{
						$dataFinal[$date] = $dateInfo['value'];
					}
					/*else
					{
						//We dont calculate(fetch) the value here
						//because we fetch it from CRON task
						$dataFinal[$date] = 0;
					}*/
				}
			}
		}

		return $dataFinal;
	}



	/**
	 * Get The statistic value base on type
	 * @param $type: Interger
	 * @param $parameters: Array of parameter used for specified type
	 * @param $issum: Boolean: if True, return to SUM of array value, FALSE to return array list
	 * @param $datebegin: UNIX Timestamp
	 * @param $dateend: UNIX Timestamp
	 */
	public static function getDataPipeline($type, $parameters, $datebegin = 0, $dateend = 0)
	{
		$redis = new Redis();
		$redis->connect($registry->conf['redis'][1]['ip'], $registry->conf['redis'][1]['port']);

		$dataFinal = array();

		//Date Time OK
		if($datebegin > 0 && $dateend > 0 && $datebegin < $dateend)
		{
			//Get Date List in range
			$dateList = self::extractDateList($datebegin, $dateend);
			$monthList = self::extractMonthList($datebegin, $dateend);

			////////////////////////////////////
			// DATA WILL RETURN
			$data = array();
			$selecteddaterange = array();

			//init data in month
			foreach($monthList as $month)
			{
				$mymonth = str_replace('/', '', $month);
				$data[$month] = array();
				for($i = 0; $i < 31; $i++)
				{
					$mday = $month .'/'. sprintf('%02d', $i+1);
					$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
				}
			}

			//check only selected input daterange to return
			foreach($dateList as $date)
			{
				$selecteddaterange[] = str_replace('/', '', $date);
			}

			////////////////////////////////////
			//Build REDIS key suffix
			$rKey = ':' . self::getDataSaleCacheKeyPrefix($type, $parameters);
			/////////////////////
			//CHECK REDIS key list
			$redisKeyList = array();
			foreach($monthList as $month)
			{
				$plainmonth = str_replace('/', '', $month);
				$key = $plainmonth . $rKey;
				$cacheData = $redis->get($key);

				//Not existed, not found key
				if(!$cacheData)
				{
					//Du lieu trong thang nay chua co cai nao het
					//boi vi chua tim ra key cho thang nay
				}
				else
				{
					//Da tim ra key cho thang nay
					//Can kiem tra them cac ngay trong thang nay da co du lieu chua
					$monthdata = explode(',', $cacheData);

					//update cac ngay de danh dau la da co trong cache
					for($i = 0; $i < count($monthdata); $i++)
					{
						$dateincache = $month .'/'. sprintf('%02d', $i+1);
						$dateincachecompare = str_replace('/', '', $dateincache);
						//just get the data in selected range dates
						if(in_array($dateincachecompare, $selecteddaterange))
							$data[$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
					}
				}
			}

			//REFINE DATA FOR EACH DAY
			foreach($data as $plainmonth => $dateData)
			{
				foreach($dateData as $date => $dateInfo)
				{
					//Neu da co data roi thi khong can lay lai
					if($dateInfo['iscached'] == 1)
					{
						$dataFinal[$date] = $dateInfo['value'];
					}
					else
					{
						//We dont calculate(fetch) the value here
						//because we fetch it from CRON task
						$dataFinal[$date] = 0;
					}
				}
			}
		}

		return $dataFinal;
	}

	/**
	 * Get The statistic value base on type
	 * @param $type: Interger
	 * @param $parameters: Array of parameter used for specified type
	 * @param $issum: Boolean: if True, return to SUM of array value, FALSE to return array list
	 * @param $datebegin: UNIX Timestamp
	 * @param $dateend: UNIX Timestamp
	 */
	public static function getDataBatch($typeList, $parameters, $datebegin = 0, $dateend = 0)
	{
		global $registry;

		$redis = new Redis();
		$redis->connect($registry->conf['redis'][1]['ip'], $registry->conf['redis'][1]['port']);


		$dataFinal = array();

		if(!is_array($typeList))
			$typeList = array($typeList);

		//Date Time OK
		if($datebegin > 0 && $dateend > 0 && $datebegin < $dateend)
		{
			//Get Date List in range
			$dateList = self::extractDateList($datebegin, $dateend);
			$monthList = self::extractMonthList($datebegin, $dateend);

			////////////////////////////////////
			// DATA WILL RETURN
			$data = array();
			$selecteddaterange = array();

			//init data in month
			foreach($monthList as $month)
			{
				$mymonth = str_replace('/', '', $month);
				$data[$month] = array();
				for($i = 0; $i < 31; $i++)
				{
					$mday = $month .'/'. sprintf('%02d', $i+1);
					$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
				}
			}

			//check only selected input daterange to return
			foreach($dateList as $date)
			{
				$selecteddaterange[] = str_replace('/', '', $date);
			}


			foreach($typeList as $type)
			{
				////////////////////////////////////
				//Build REDIS key suffix
				$rKey = ':' . self::getDataSaleCacheKeyPrefix($type, $parameters);

				foreach($monthList as $month)
				{
					$plainmonth = str_replace('/', '', $month);
					$cacheData[$type] = $redis->get($plainmonth . $rKey);

					//Not existed, not found key
					if($cacheData[$type])
					{
						//Da tim ra key cho thang nay
						//Can kiem tra them cac ngay trong thang nay da co du lieu chua
						$monthdata[$type] = explode(',', $cacheData[$type]);

						//update cac ngay de danh dau la da co trong cache
						for($i = 0; $i < count($monthdata[$type]); $i++)
						{
							$dateincache = $month .'/'. sprintf('%02d', $i+1);
							$dateincachecompare = str_replace('/', '', $dateincache);
							//just get the data in selected range dates
							if(in_array($dateincachecompare, $selecteddaterange))
								$data[$type][$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$type][$i]);
						}
					}
				}//end loop month

				//REFINE DATA FOR EACH DAY
				foreach($data[$type] as $plainmonth => $dateData)
				{
					foreach($dateData as $date => $dateInfo)
					{
						//Neu da co data roi thi khong can lay lai
						if($dateInfo['iscached'] == 1)
						{
							$dataFinal[$type][$date] = $dateInfo['value'];
						}
						else
						{
							//We dont calculate(fetch) the value here
							//because we fetch it from CRON task
							$dataFinal[$type][$date] = 0;
						}
					}
				}
			}//end loop typelist
		}

		return $dataFinal;
	}


	/**
	 * Get The statistic value base on type, group type, group product id
	 * @param $type: Interger
	 * @param $parameters: Array of parameter used for specified type
	 * @param $issum: Boolean: if True, return to SUM of array value, FALSE to return array list
	 * @param $datebegin: UNIX Timestamp
	 * @param $dateend: UNIX Timestamp
	 */
	public static function getDataList($type, $parameters, $datebegin = 0, $dateend = 0)//tham
	{
		if (!empty($parameters['products']) || (is_array($type) && !empty($parameters['product'])))
		{
			$dataFinal = array();
			$redis = self::connectRedis();

			//Date Time OK
			if(!empty($type) && $datebegin > 0 && $dateend > 0 && $datebegin < $dateend)
			{
				//Get Date List in range
				$dateList = self::extractDateList($datebegin, $dateend);
				$monthList = self::extractMonthList($datebegin, $dateend);
				////////////////////////////////////
				// DATA WILL RETURN
				$data = array();
				$selecteddaterange = array();

				//init data in month
				foreach($monthList as $month)
				{
					$mymonth = str_replace('/', '', $month);
					$data[$month] = array();
					for($i = 0; $i < 31; $i++)
					{
						$mday = $month .'/'. sprintf('%02d', $i+1);
						$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
					}
				}

				//check only selected input daterange to return
				foreach($dateList as $date)
				{
					$selecteddaterange[] = str_replace('/', '', $date);
				}

				////////////////////////////////////
				//Build REDIS key suffix
				$rediscommand = '';

				$listproducts = array();
				if (!empty($parameters['products'])) $listproducts = $parameters['products'];
				else $listproducts = array($parameters['product']);
				unset($parameters['products']);
				$arrtypes = array();
				if (is_array($type)) $arrtypes = $type;
				else $arrtypes = array($type);

				foreach ($arrtypes as $typeitem)
				{
					foreach ($listproducts as $pid)
					{
						$newparams = $parameters;
						$newparams['product'] = $pid;
						$rKey = ':' . self::getDataSaleCacheKeyPrefixAllProducts($typeitem, $newparams);

						foreach($monthList as $month)
						{
							$plainmonth = str_replace('/', '', $month);
							$key = $plainmonth . $rKey;

							$rediscommand .= '->get("'.$key.'")';
						}
					}
				}

				if (!empty($rediscommand)) {
					$rediscommand .= '->exec();';
					$rediscommand = '$results = $redis->pipeline()'.$rediscommand;
					eval($rediscommand);
					unset($rediscommand);
					if (!empty($results))
					{
						$cnt = 0;

						$data = array();
						foreach ($arrtypes as $typeitem)
						{
							foreach ($listproducts as $pid)
							{
								foreach($monthList as $month)
								{
									$plainmonth = str_replace('/', '', $month);

									if (!empty($results[$cnt]))
									{
										$monthdata = explode(',', $results[$cnt]);
										//update cac ngay de danh dau la da co trong cache
										for($i = 0; $i < count($monthdata); $i++)
										{
											$dateincache = $month .'/'. sprintf('%02d', $i+1);
											//$dateincachecompare = str_replace('/', '', $dateincache);
											//just get the data in selected range dates
											//if(in_array($dateincachecompare, $selecteddaterange))
												//$data[$typeitem][$pid][$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
											if (!empty($monthdata[$i])) $data[$typeitem][$pid][$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
										}
									}
									$cnt++;
								}
							}
						}
						foreach ($data as $typeitem=>$typeallproducts)
						{
							foreach ($typeallproducts as $pid=>$dataallmonths)
							{
								foreach ($dataallmonths as $plainmonth => $dateData)
								{
									foreach($dateData as $date => $dateInfo)
									{
										//Neu da co data roi thi khong can lay lai
										if($dateInfo['iscached'] == 1 && !empty($dateInfo['value']))
										{
											$dataFinal[$pid][$typeitem][$date] = $dateInfo['value'];
										}
										/*else
										{
											//We dont calculate(fetch) the value here
											//because we fetch it from CRON task
											//$dataFinal[$pid][$date] = 0;
										}*/
									}
								}
							}
						}
					}
					unset($data);
					unset($results);
					//echodebug($results);
					//echo '<p>------'.$rediscommand.'-------</p>';
				}
			}

			return $dataFinal;
		}
		elseif (!empty($parameters['product']) && !is_array($type))
		{
			return array($parameters['product'] => array($type => self::getData($type, $parameters, $datebegin = 0, $dateend = 0)));
		}
	}

	/**
	 * Get SALE data
	 * @param $parameters: More info for Sale statstics.
	 * 			$parameters['category']: View by Category ID (exclude: product)
	 * 			$parameters['product']: View by a specified Product ID (exclude: category)
	 * 			$parameters['region']: View by Region ID
	 * 			$parameters['vendor']: View by Vendor ID
	 * 			$parameters['outputtype']: View by Output Type ID
	 * 			$parameters['outputstore']: View by Output Store ID
	 * 			$parameters['inputstore']: View by Input Store ID
	*/
	public static function getDataSale($type, $params, $dateList, $monthList)
	{
		global $conf;
        ////////////////////////////////////
		// DATA WILL RETURN
		$data = array();
		$selecteddaterange = array();

		//init data in month
		foreach($monthList as $month)
		{
			$mymonth = str_replace('/', '', $month);
			$data[$month] = array();
			for($i = 0; $i < 31; $i++)
			{
				$mday = $month .'/'. sprintf('%02d', $i+1);
				$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
			}
		}

		//check only selected input daterange to return
		foreach($dateList as $date)
		{
			$selecteddaterange[] = str_replace('/', '', $date);
		}

		////////////////////////////////////
		//Build REDIS key suffix
		$rKey = ':' . self::getDataSaleCacheKeyPrefix($type, $params);

		/////////////////////
		//CHECK REDIS key list
		$redisKeyList = array();
		foreach($monthList as $month)
		{
			$plainmonth = str_replace('/', '', $month);
			$key = $plainmonth . $rKey;
			$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$cacheData = $myCacher->get();

			//Not existed, not found key
			if(!$cacheData)
			{
				//Du lieu trong thang nay chua co cai nao het
				//boi vi chua tim ra key cho thang nay
			}
			else
			{
				//Da tim ra key cho thang nay
				//Can kiem tra them cac ngay trong thang nay da co du lieu chua
				$monthdata = explode(',', $cacheData);

				//update cac ngay de danh dau la da co trong cache
				for($i = 0; $i < count($monthdata); $i++)
				{
					$dateincache = $month .'/'. sprintf('%02d', $i+1);
					$dateincachecompare = str_replace('/', '', $dateincache);
					//just get the data in selected range dates
					if(in_array($dateincachecompare, $selecteddaterange))
						$data[$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
				}
			}
		}

		//////////////////////////////////////////////
		// GET UNCACHE DATA AND SAVE BACK TO CACHER
		$dataFinal = array();
		foreach($data as $plainmonth => $dateData)
		{
			foreach($dateData as $date => $dateInfo)
			{
				//Neu da co data roi thi khong can lay lai
				if($dateInfo['iscached'] == 1)
				{
					$dataFinal[$date] = $dateInfo['value'];
				}
				else
				{

					//We dont calculate(fetch) the value here
					//because we fetch it from CRON task
					$dataFinal[$date] = 0;
				}
			}
		}


		return $dataFinal;
	}



	/**
	 * Get SALE data
	 * @param $parameters: More info for Sale statstics.
	 * 			$parameters['category']: View by Category ID (exclude: product)
	 * 			$parameters['product']: View by a specified Product ID (exclude: category)
	 * 			$parameters['region']: View by Region ID
	 * 			$parameters['vendor']: View by Vendor ID
	 * 			$parameters['outputtype']: View by Output Type ID
	 * 			$parameters['outputstore']: View by Output Store ID
	 * 			$parameters['inputstore']: View by Input Store ID
	 * 			$parameters['pricesegment']: View by Price Segment
	 * 			$parameters['character']: View by Main Character
	*/
	public static function setDataSaleInDate($type, $params, $date, $value = null)
	{
		global $conf;
        ////////////////////////////////////
		// DATA WILL RETURN
		$data = array();

		$curday = str_replace('/', '', $date);
		$month = substr($curday, 0, 6);


		//init blank data
		for($i=0; $i < 31; $i++)
		{
			$mday = $month . sprintf('%02d', $i+1);
			$data[$month][$mday] = array('iscached' => 0, 'value' => 0);
		}

		////////////////////////////////////
		//Build REDIS key suffix
		$rKey = ':' . self::getDataSaleCacheKeyPrefix($type, $params);
		/////////////////////
		//CHECK REDIS key list
		$redisKeyList = array();
		$plainmonth = str_replace('/', '', $month);
		$key = $plainmonth . $rKey;
		$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
		$cacheData = $myCacher->get();

		//Not existed, not found key
		if(!$cacheData)
		{
			//Du lieu trong thang nay chua co cai nao het
			//boi vi chua tim ra key cho thang nay
		}
		else
		{
			//Da tim ra key cho thang nay
			//Can kiem tra them cac ngay trong thang nay da co du lieu chua
			$monthdata = explode(',', $cacheData);

			//update cac ngay de danh dau la da co trong cache
			for($i = 0; $i < count($monthdata); $i++)
			{
				$dateincache = $month . sprintf('%02d', $i+1);

				//just get the data in selected range dates
				if(isset($data[$plainmonth][$dateincache]) && $dateincache != $curday)
					$data[$plainmonth][$dateincache] = array('iscached' => 1, 'value' => $monthdata[$i]);
			}
		}

		//////////////////////////////////////////////
		// GET UNCACHE DATA AND SAVE BACK TO CACHER
		$dataFinal = array();
		foreach($data as $plainmonth => $dateData)
		{
			$cacheBack = array();
			foreach($dateData as $date => $dateInfo)
			{
				//neu co data trung ngay thi de len data cu
				if($date == $curday)
				{
					$data[$plainmonth][$date] = array('iscached' => 1, 'value' => $value);
					$dataFinal[$date] = $value;
					$cacheBack[] = $value;
				}
				elseif($dateInfo['iscached'] == 1)//neu co cache roi thi luu lai gia tri cu
				{
					$cacheBack[] = $dateInfo['value'];
					$dataFinal[$date] = $dateInfo['value'];
				}
				else
				{
					$data[$plainmonth][$date] = array('iscached' => 0, 'value' => 0);
					$dataFinal[$date] = 0;
					$cacheBack[] = 0;
				}
			}
			//Update back to cacher
			$myCacher = new Cacher($plainmonth . $rKey, Cacher::STORAGE_REDIS, $conf['redis'][1]);
			$myCacher->set(implode(',', $cacheBack), 0);
		}

		return $dataFinal;
	}

	/**
	 * Param put here for month
	 * @param $parameters: More info for Sale statstics.
	 * 			$parameters[key][month][date][] = array('where' => , 'value' => )
	*/
	public static function setMultiDataSaleInMonth($parameters = array())
	{
		$commandrun = '';
		foreach ($parameters as $type => $datamonths)
		{
			foreach ($datamonths as $month => $datadates)
			{
				foreach ($datadates as $date => $listdatacache)
				{
					foreach ($listdatacache as $valuecache)
					{
						$rKey = $month.':' . self::getDataSaleCacheKeyPrefix($type, $valuecache['where']);
						$commandrun .= '->set("' . $rKey . '", "' . $valuecache['value'] . '")';
					}
				}
			}
		}
		if (!empty($commandrun))
		{
			$redis = self::connectRedis();
			$commandrun .= '->exec();';
			$commandredis = '$redis->pipeline()' . $commandrun;
			eval($commandredis);
		}
	}

	/**
	 * Generate cache key for stat get data for Sale
	 *
	 * @param array $params: Same with $parameters of method getDataSale();
	 */
	public static function getDataSaleCacheKeyPrefix($type, $params)
	{
		$key = '';

		//get valid key index
		$keyPartList = array();

		//Type
		switch($type)
		{
			case self::TYPE_SALE_ORDER_VALUE: $keyPartList['xxx'] = 'saleordervalue:'; break;
			case self::TYPE_SALE_ORDER_VOLUME: $keyPartList['xxx'] = 'saleordervolume:'; break;
			case self::TYPE_SALE_ITEM_VALUE: $keyPartList['xxx'] = 'saleitemvalue:'; break;
			case self::TYPE_SALE_ITEM_VALUE_NOVAT: $keyPartList['xxx'] = 'saleitemvaluenovat:'; break;
			case self::TYPE_SALE_ITEM_VOLUME: $keyPartList['xxx'] = 'saleitemvolume:'; break;
			case self::TYPE_SALE_COSTPRICE: $keyPartList['xxx'] = 'salecostprice:'; break;
			case self::TYPE_PROFIT_ITEM: $keyPartList['xxx'] = 'profititem:'; break;
			case self::TYPE_PROFIT_ORDER: $keyPartList['xxx'] = 'profitorder:'; break;
			case self::TYPE_STOCK_VALUE: $keyPartList['xxx'] = 'stockvalue:'; break;
			case self::TYPE_STOCK_VOLUME: $keyPartList['xxx'] = 'stockvolume:'; break;
			case self::TYPE_STOCK_VALUE_BEGIN: $keyPartList['xxx'] = 'stockvaluebegin:'; break;
			case self::TYPE_STOCK_VOLUME_BEGIN: $keyPartList['xxx'] = 'stockvolumebegin:'; break;
			case self::TYPE_REFUND_VALUE: $keyPartList['xxx'] = 'refundvalue:'; break;
			case self::TYPE_REFUND_VOLUME: $keyPartList['xxx'] = 'refundvolume:'; break;
			case self::TYPE_REFUND_VALUE_NOVAT: $keyPartList['xxx'] = 'refundvaluenovat:'; break;
			case self::TYPE_REFUND_COSTPRICE: $keyPartList['xxx'] = 'refundcostprice:'; break;
			case self::TYPE_INPUT_VOLUME: $keyPartList['xxx'] = 'inputvolume:'; break;//moi them
			case self::TYPE_INPUT_VALUE: $keyPartList['xxx'] = 'inputvalue:'; break;
			case self::TYPE_INPUT_INTERNAL_VOLUME: $keyPartList['xxx'] = 'inputinternalvolume:'; break;
			case self::TYPE_INPUT_INTERNAL_VALUE: $keyPartList['xxx'] = 'inputinternalvalue:'; break;
			case self::TYPE_INPUT_REFUND_SALE_VOLUME: $keyPartList['xxx'] = 'inputrefundvolume:'; break;
			case self::TYPE_INPUT_REFUND_SALE_VALUE: $keyPartList['xxx'] = 'inputrefundvalue:'; break;
			case self::TYPE_INPUT_OTHER_VOLUME: $keyPartList['xxx'] = 'inputothervolume:'; break;
			case self::TYPE_INPUT_OTHER_VALUE: $keyPartList['xxx'] = 'inputothervalue:'; break;
			case self::TYPE_OUTPUT_VOLUME: $keyPartList['xxx'] = 'outputvolume:'; break;
			case self::TYPE_OUTPUT_VALUE: $keyPartList['xxx'] = 'outputvalue:'; break;
			case self::TYPE_OUTPUT_INTERNAL_VOLUME: $keyPartList['xxx'] = 'outputinternalvolume:'; break;
			case self::TYPE_OUTPUT_INTERNAL_VALUE: $keyPartList['xxx'] = 'outputinternalvalue:'; break;
			case self::TYPE_OUTPUT_REFUND_SALE_VOLUME: $keyPartList['xxx'] = 'outputrefundvolume:'; break;
			case self::TYPE_OUTPUT_REFUND_SALE_VALUE: $keyPartList['xxx'] = 'outputrefundvalue:'; break;
			case self::TYPE_OUTPUT_OTHER_VOLUME: $keyPartList['xxx'] = 'outputothervolume:'; break;
			case self::TYPE_OUTPUT_OTHER_VALUE: $keyPartList['xxx'] = 'outputothervalue:'; break;
			case self::TYPE_PROMOTION_COSTPRICE: $keyPartList['xxx'] = 'promotioncostprice:'; break;
			case self::TYPE_INPUT_BEGINTERM_VOLUME: $keyPartList['xxx'] = 'inputbegintermvolume:'; break;
			case self::TYPE_INPUT_BEGINTERM_VALUE: $keyPartList['xxx'] = 'inputbegintermvalue:'; break;
			case self::TYPE_OUTPUT_BEGINTERM_VOLUME: $keyPartList['xxx'] = 'outputbegintermvolume:'; break;
			case self::TYPE_OUTPUT_BEGINTERM_VALUE : $keyPartList['xxx'] = 'outputbegintermvalue:'; break;

			case self::TYPE_INPUT_REFUND_REV_VOLUME : $keyPartList['xxx'] = 'inputrefundrevvolume:'; break;
			case self::TYPE_INPUT_REFUND_REV_VALUE : $keyPartList['xxx'] = 'inputrefundrevvalue:'; break;
			case self::TYPE_INPUT_REFUND_REV_VALUEVAT : $keyPartList['xxx'] = 'inputrefundrevvaluevat:'; break;

			case self::TYPE_CUSTOMER_VIEWS: $keyPartList['xxx'] = 'customerviews:'; break;
			case self::TYPE_PRODUCTREWARD: $keyPartList['xxx'] = 'reward:'; break;

			case self::TYPE_VIEW: $keyPartList['xxx'] = 'view:'; break;
			case self::TYPE_NUMBER_OF_PRODUCT: $keyPartList['xxx'] = 'numofskus:'; break;

			case self::CACULATE_PRODUCTCACHE: $keyPartList['xxx'] = 'caculateproduct:'; break;
		}

		//find param
		foreach($params as $k => $v)
		{
			if(!empty($v))//$v > 0
			{
				$keyAbbr = '';
				switch($k)
				{
					case 'category': $keyAbbr = 'c'; break;
					case 'product': $keyAbbr = 'p'; break;
					case 'region': $keyAbbr = 'r'; break;
					case 'vendor': $keyAbbr = 'v'; break;
					case 'outputtype': $keyAbbr = 'ot'; break;
					case 'inputtype': $keyAbbr = 'it'; break;
					case 'outputstore': $keyAbbr = 'o'; break;
					case 'inputstore': $keyAbbr = 'i'; break;
					case 'pricesegment': $keyAbbr = 's'; break;
					case 'character': $keyAbbr = 'm'; break;//main character or là filter attribute
					default: $keyAbbr = $k;
				}
				$keyPartList[$keyAbbr] = $keyAbbr . $v;
			}
		}
		//generate key
		if(count($keyPartList) > 0)
		{
			ksort($keyPartList);
			$key = implode(':', $keyPartList);
		}
		return $key;
	}

	public static function getDataSaleCacheKeyPrefixAllProducts($type, $params)
	{
		$key = '';

		//get valid key index
		$keyPartList = array();

		//Type
		switch($type)
		{
			case self::TYPE_SALE_ORDER_VALUE: $keyPartList['xxx'] = 'saleordervalue:'; break;
			case self::TYPE_SALE_ORDER_VOLUME: $keyPartList['xxx'] = 'saleordervolume:'; break;
			case self::TYPE_SALE_ITEM_VALUE: $keyPartList['xxx'] = 'saleitemvalue:'; break;
			case self::TYPE_SALE_ITEM_VALUE_NOVAT: $keyPartList['xxx'] = 'saleitemvaluenovat:'; break;
			case self::TYPE_SALE_ITEM_VOLUME: $keyPartList['xxx'] = 'saleitemvolume:'; break;
			case self::TYPE_SALE_COSTPRICE: $keyPartList['xxx'] = 'salecostprice:'; break;
			case self::TYPE_PROFIT_ITEM: $keyPartList['xxx'] = 'profititem:'; break;
			case self::TYPE_PROFIT_ORDER: $keyPartList['xxx'] = 'profitorder:'; break;
			case self::TYPE_STOCK_VALUE: $keyPartList['xxx'] = 'stockvalue:'; break;
			case self::TYPE_STOCK_VOLUME: $keyPartList['xxx'] = 'stockvolume:'; break;
			case self::TYPE_STOCK_VALUE_BEGIN: $keyPartList['xxx'] = 'stockvaluebegin:'; break;
			case self::TYPE_STOCK_VOLUME_BEGIN: $keyPartList['xxx'] = 'stockvolumebegin:'; break;
			case self::TYPE_REFUND_VALUE: $keyPartList['xxx'] = 'refundvalue:'; break;
			case self::TYPE_REFUND_VOLUME: $keyPartList['xxx'] = 'refundvolume:'; break;
			case self::TYPE_REFUND_VALUE_NOVAT: $keyPartList['xxx'] = 'refundvaluenovat:'; break;
			case self::TYPE_REFUND_COSTPRICE: $keyPartList['xxx'] = 'refundcostprice:'; break;
			case self::TYPE_INPUT_VOLUME: $keyPartList['xxx'] = 'inputvolume:'; break;//moi them
			case self::TYPE_INPUT_VALUE: $keyPartList['xxx'] = 'inputvalue:'; break;
			case self::TYPE_INPUT_INTERNAL_VOLUME: $keyPartList['xxx'] = 'inputinternalvolume:'; break;
			case self::TYPE_INPUT_INTERNAL_VALUE: $keyPartList['xxx'] = 'inputinternalvalue:'; break;
			case self::TYPE_INPUT_REFUND_SALE_VOLUME: $keyPartList['xxx'] = 'inputrefundvolume:'; break;
			case self::TYPE_INPUT_REFUND_SALE_VALUE: $keyPartList['xxx'] = 'inputrefundvalue:'; break;
			case self::TYPE_INPUT_OTHER_VOLUME: $keyPartList['xxx'] = 'inputothervolume:'; break;
			case self::TYPE_INPUT_OTHER_VALUE: $keyPartList['xxx'] = 'inputothervalue:'; break;
			case self::TYPE_OUTPUT_VOLUME: $keyPartList['xxx'] = 'outputvolume:'; break;
			case self::TYPE_OUTPUT_VALUE: $keyPartList['xxx'] = 'outputvalue:'; break;
			case self::TYPE_OUTPUT_INTERNAL_VOLUME: $keyPartList['xxx'] = 'outputinternalvolume:'; break;
			case self::TYPE_OUTPUT_INTERNAL_VALUE: $keyPartList['xxx'] = 'outputinternalvalue:'; break;
			case self::TYPE_OUTPUT_REFUND_SALE_VOLUME: $keyPartList['xxx'] = 'outputrefundvolume:'; break;
			case self::TYPE_OUTPUT_REFUND_SALE_VALUE: $keyPartList['xxx'] = 'outputrefundvalue:'; break;
			case self::TYPE_OUTPUT_OTHER_VOLUME: $keyPartList['xxx'] = 'outputothervolume:'; break;
			case self::TYPE_OUTPUT_OTHER_VALUE: $keyPartList['xxx'] = 'outputothervalue:'; break;
			case self::TYPE_PROMOTION_COSTPRICE: $keyPartList['xxx'] = 'promotioncostprice:'; break;
			case self::TYPE_INPUT_BEGINTERM_VOLUME: $keyPartList['xxx'] = 'inputbegintermvolume:'; break;
			case self::TYPE_INPUT_BEGINTERM_VALUE: $keyPartList['xxx'] = 'inputbegintermvalue:'; break;
			case self::TYPE_OUTPUT_BEGINTERM_VOLUME: $keyPartList['xxx'] = 'outputbegintermvolume:'; break;
			case self::TYPE_OUTPUT_BEGINTERM_VALUE : $keyPartList['xxx'] = 'outputbegintermvalue:'; break;

			case self::TYPE_INPUT_REFUND_REV_VOLUME : $keyPartList['xxx'] = 'inputrefundrevvolume:'; break;
			case self::TYPE_INPUT_REFUND_REV_VALUE : $keyPartList['xxx'] = 'inputrefundrevvalue:'; break;
			case self::TYPE_INPUT_REFUND_REV_VALUEVAT : $keyPartList['xxx'] = 'inputrefundrevvaluevat:'; break;

			case self::TYPE_CUSTOMER_VIEWS: $keyPartList['xxx'] = 'customerviews:'; break;
			case self::TYPE_PRODUCTREWARD: $keyPartList['xxx'] = 'reward:'; break;

			case self::TYPE_VIEW: $keyPartList['xxx'] = 'view:'; break;
			case self::TYPE_NUMBER_OF_PRODUCT: $keyPartList['xxx'] = 'numofskus:'; break;

			case self::CACULATE_PRODUCTCACHE: $keyPartList['xxx'] = 'caculateproduct:'; break;
		}

		//find param
		foreach($params as $k => $v)
		{
			if(!empty($v))//$v > 0
			{
				$keyAbbr = '';
				switch($k)
				{
					case 'category': $keyAbbr = 'c'; break;
					case 'product': $keyAbbr = 'p'; break;
					case 'region': $keyAbbr = 'r'; break;
					case 'vendor': $keyAbbr = 'v'; break;
					case 'outputtype': $keyAbbr = 'ot'; break;
					case 'inputtype': $keyAbbr = 'it'; break;
					case 'outputstore': $keyAbbr = 'o'; break;
					case 'inputstore': $keyAbbr = 'i'; break;
					case 'pricesegment': $keyAbbr = 's'; break;
					case 'character': $keyAbbr = 'm'; break;//main character or là filter attribute
					default: $keyAbbr = $k;
				}
				$keyPartList[$keyAbbr] = $keyAbbr . $v;
			}
		}
		//generate key
		if(count($keyPartList) > 0)
		{
			ksort($keyPartList);
			$key = implode(':', $keyPartList);
		}
		return $key;
	}

	/**
	 * Extract The DateList (in Unix Timestamp) from the $begin and $end date (in Timestamp)
	 */
	public static function extractDateList($begin, $end)
	{
		$dateList = array();
		$numDays = ($end - $begin)/60/60/24;

		for ($i = 0; $i < $numDays; $i++)
		{
			$dateList[] = date('Y/m/d', strtotime('+'.$i.' day', $begin));
		}

		return $dateList;
	}

	public static function extractMonthList($begin, $end)
	{
		$monthList = array();
		$numDays = ($end - $begin)/60/60/24;

		for ($i = 0; $i < $numDays; $i++)
		{
			$month = date('Y/m', strtotime('+'.$i.' day', $begin));

			if(!in_array($month, $monthList))
				$monthList[] = $month;
		}

		return $monthList;
	}


	public static function getDb()
	{
		global $db;

		return $db;
	}



	////////////////
	public static function getAllProductHaveBarcodeFromDb()
	{
		global $db;

		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product WHERE p_barcode != ""';
		$stmt = $db->query($sql);
		$pidList = array();
		while($row = $stmt->fetch())
		{
			$pidList[] = $row['p_id'];
		}

		return $pidList;
	}


	/**
	 * Get all product id (have barcode) from caching
	 */
	public static function getAllProductHaveBarcode()
	{
		global $conf;
        $productidList = array();
		$myCacher = new Cacher('stat:productidlist', Cacher::STORAGE_REDIS, $conf['redis'][1]);	//2 days
		$data = $myCacher->get();
		if($data != false)
		{
			$productidList = explode(',', $data);
		}
		else
		{
			//get data
			$productidList = self::getAllProductHaveBarcodeFromDb();
			$data = implode(',', $productidList);
			$myCacher->set($data, 86400*2);
		}

		return $productidList;
	}

	public static function getProductInfoFromDb($pid)
	{
		global $db;

		$sql = 'SELECT p_id, p_barcode, p_name FROM ' . TABLE_PREFIX . 'product WHERE p_id = ?';
		$productinfo = $db->query($sql, array($pid))->fetch(PDO::FETCH_NUM);

		return $productinfo;
	}


	public static function getProductInfo($pid)
	{
		global $conf;
        $productinfo = array();

		$myCacher = new Cacher('stat:productidlist:' . $pid, Cacher::STORAGE_REDIS, $conf['redis'][1]);	//2 days
		$data = $myCacher->get();
		if($data != false)
		{
			$productinfo = explode(',', $data, 3);
		}
		else
		{
			$productinfo = self::getProductInfoFromDb($pid);
			$data = implode(',', $productinfo);
			$myCacher->set($data, 86400 * 2);
		}

		return $productinfo;
	}

	public static function setcachetopitem($arrayParam, $values = array())
	{
		global $conf;
        if (count($arrayParam) > 0)
		{
			$key = 'stat:topitem:';
			//---Cache tung ngay theo 1 nam, cache tung tuan theo nam, cache 12 thang theo nam----
			if ( !empty($arrayParam['type']) && !empty($arrayParam['typevalue']) )
			{
				$key .= $arrayParam['type'] . ':';
				if($arrayParam['type'] == Core_Stat::TOPITEM_DAY_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_VOLUME
				)
				{
					$strtotime = strtotime($arrayParam['typevalue']);// day format is: Y-m-d
					$key .= 'd'. date('Y', $strtotime) . ':';//current year
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$dayskeys = array();//date('z'); lay ngay cua nam
					for ($i = 0; $i < 366; $i++)
					{
						$dayskeys[$i] = 0;
					}
					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						foreach ($olddayskeys as $ixk=>$itemval)
						{
							$dayskeys[$ixk] = $itemval;
						}
					}
					$arrParsing = array();
					foreach ($values as $val)
					{
						$arrParsing[] = $val['pid'].':'. $val['doanhthu'].':'.$val['soluong'].':'.$val['laigop'].':'.$val['traffic'];
					}
					$dayskeys[date('z', $strtotime)] = implode(',', $arrParsing);

					//Save to cache
					$myCacher->set((string)implode('#', $dayskeys), 0);
					//echodebug('KEY: '.$key. '---'.implode('#', $dayskeys), true);
				}
				elseif($arrayParam['type'] == Core_Stat::TOPITEM_WEEK_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_VOLUME
				)
				{
					$currentYear = (string)substr(trim($arrayParam['typevalue']), 0, 4);
					$currentWeek = (int)substr(trim($arrayParam['typevalue']), 4);
					$key .= 'w' . $currentYear . ':';
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$weekskeys = array();
					for ($i = 0; $i < 54; $i++)
					{
						$weekskeys[$i] = 0;
					}
					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						foreach ($olddayskeys as $ixk=>$itemval)
						{
							$weekskeys[$ixk] = $itemval;
						}
					}
					$arrParsing = array();
					foreach ($values as $val)
					{
						$arrParsing[] = $val['pid'].':'. $val['doanhthu'].':'.$val['soluong'].':'.$val['laigop'].':'.$val['traffic'];
					}
					$currentWeek--; //get index of week
					$weekskeys[$currentWeek] = implode(',', $arrParsing);
					//Save to cache
					$myCacher->set((string)implode('#', $weekskeys), 0);
				}
				elseif($arrayParam['type'] == Core_Stat::TOPITEM_MONTH_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_VOLUME
				)
				{
					$currentYear = (string)substr(trim($arrayParam['typevalue']), 0, 4);
					$currentMonth = (int)substr(trim($arrayParam['typevalue']), 4);
					$key .= 'm' . $currentYear . ':';
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$monthskeys = array();
					for ($i = 0; $i < 12; $i++)
					{
						$monthskeys[$i] = 0;
					}
					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						foreach ($olddayskeys as $ixk=>$itemval)
						{
							$monthskeys[$ixk] = $itemval;
						}
					}
					$arrParsing = array();
					foreach ($values as $val)
					{
						$arrParsing[] = $val['pid'].':'. $val['doanhthu'].':'.$val['soluong'].':'.$val['laigop'].':'.$val['traffic'];
					}
					$currentMonth--;//get index of month
					$monthskeys[$currentMonth] = implode(',', $arrParsing);

					//Save to cache
					$myCacher->set((string)implode('#', $monthskeys), 0);
				}
			}
		}

	}

	public static function getcachetopitem($arrayParam)
	{
		global $conf;
        $arrayReturn = array();
		if (count($arrayParam) > 0)
		{
			$key = 'stat:topitem:';
			//---Cache tung ngay theo 1 nam, cache tung tuan theo nam, cache 12 thang theo nam----
			if ( !empty($arrayParam['type']) && !empty($arrayParam['typevalue']) )
			{
				$key .= $arrayParam['type'] . ':';
				if($arrayParam['type'] == Core_Stat::TOPITEM_DAY_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_DAY_VOLUME
				)
				{
					$strtotime = strtotime($arrayParam['typevalue']);// day format is: Y-m-d
					$key .= 'd'. date('Y', $strtotime) . ':';//current year
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						$daystr = (int)date('z', $strtotime);
						//$daystr--;
						if (!empty($olddayskeys[$daystr]))
						{
							$returnvalue = explode(',', $olddayskeys[$daystr]);

							if (count($returnvalue) > 0 )
							{
								foreach ($returnvalue as $itval)
								{
									$explodeitem = explode(':', $itval);
									$arrayReturn[$explodeitem[0]] = array('pid' => $explodeitem[0], 'doanhthu' => $explodeitem[1], 'soluong' => $explodeitem[2], 'laigop' => $explodeitem[3], 'traffic' => $explodeitem[4]) ;
								}
							}
						}
					}
				}
				elseif($arrayParam['type'] == Core_Stat::TOPITEM_WEEK_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_WEEK_VOLUME
				)
				{
					$currentYear = (string)substr(trim($arrayParam['typevalue']), 0, 4);
					$currentWeek = (int)substr(trim($arrayParam['typevalue']), 4);
					$key .= 'w' . $currentYear . ':';
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						$currentWeek--;
						if (!empty($olddayskeys[$currentWeek]))
						{
							$returnvalue = explode(',', $olddayskeys[$currentWeek]);

							if (count($returnvalue) > 0 )
							{
								foreach ($returnvalue as $itval)
								{
									$explodeitem = explode(':', $itval);
									$arrayReturn[$explodeitem[0]] = array('pid' => $explodeitem[0], 'doanhthu' => $explodeitem[1], 'soluong' => $explodeitem[2], 'laigop' => $explodeitem[3], 'traffic' => $explodeitem[4]) ;
								}
							}
						}
					}
				}
				elseif($arrayParam['type'] == Core_Stat::TOPITEM_MONTH_PROFIT ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_REVENUE ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_TRAFFIC ||
				   $arrayParam['type'] == Core_Stat::TOPITEM_MONTH_VOLUME
				)
				{
					$currentYear = (string)substr(trim($arrayParam['typevalue']), 0, 4);
					$currentMonth = (int)substr(trim($arrayParam['typevalue']), 4);
					$key .= 'm' . $currentYear . ':';
					if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
					if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

					$myCacher = new Cacher($key, Cacher::STORAGE_REDIS, $conf['redis'][1]);
					$getoldcache = $myCacher->get();
					if (!empty($getoldcache))
					{
						$olddayskeys = explode('#', $getoldcache);
						$currentMonth--;
						if (!empty($olddayskeys[$currentMonth]))
						{
							$returnvalue = explode(',', $olddayskeys[$currentMonth]);

							if (count($returnvalue) > 0 )
							{
								foreach ($returnvalue as $itval)
								{
									$explodeitem = explode(':', $itval);
									$arrayReturn[$explodeitem[0]] = array('pid' => $explodeitem[0], 'doanhthu' => $explodeitem[1], 'soluong' => $explodeitem[2], 'laigop' => $explodeitem[3], 'traffic' => $explodeitem[4]) ;
								}
							}
						}
					}
				}
			}
		}
		return $arrayReturn;
	}

	//luu cache and get cache cho caculate main character, vendor, price segment

	public static function setattributeproducts($arrayParam, $values = array(), $datevalue)
	{
		global $conf;
        if (count($arrayParam) > 0)
		{
			$key = '';
			if ( !empty($arrayParam['type']) ) {
				$key .= $arrayParam['type'] . ':';
				switch($arrayParam['type'])
				{
					case Core_Stat::PRODUCTATTRIBUTE_VENDOR: 			$key .= 'v'; break;
					case Core_Stat::PRODUCTATTRIBUTE_PRICESEGMENT: 	$key .= 'ps'; break;
					case Core_Stat::PRODUCTATTRIBUTE_ATTRIBUTE: 		$key .= 'a'; break;
				}
				if ( !empty($arrayParam['typevalue']) ) $key .= str_replace('-', '',$arrayParam['typevalue']) . ':';
			}
			if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
			if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

			if ($key != '')
			{
				$data = array();
				$curdaytimestamp = strtotime($datevalue);
				$month = date('n', $curdaytimestamp);
				$year = date('Y', $curdaytimestamp);
				$curday = date('j', $curdaytimestamp) - 1;//because index begin at 0
				for($i=0; $i < 31; $i++)
				{
					$data[$i] = 0;//array('doanhthu' => 0, 'soluong' => 0, 'laigop' => 0);
				}

				$key .= $year.sprintf('%02d', $month).':';
				$myCacher = new Cacher('statproductatt:' .$key, Cacher::STORAGE_REDIS, $conf['redis'][1]);	//1 days
				if (count($values) > 0)
				{
					$getDataValues = $myCacher->get();
					if (!empty($getDataValues))
					{
						$array = explode(',', $getDataValues);
						foreach ($array as $ix=>$item)
						{
							//$nitem = explode(':', $item);
							$data[$ix] = $item;//array('doanhthu' => $nitem[0], 'soluong' => $nitem[1], 'laigop' => $nitem[2]);
						}

						$data[$curday] = $values['doanhthu'] . ':' .  $values['soluong'] . ':' .  $values['laigop'];//array('doanhthu' => $values['doanhthu'], 'soluong' => $values['soluong'], 'laigop' => $values['laigop']);
						//echodebug($data);
						$parsing = implode(',', $data);
						$myCacher->set((string)$parsing, 0);
					}
				}
			}
		}

	}

	public static function getattributeproducts($arrayParam, $datevalue)
	{
		global $conf;
        $arrayReturn = array();
		if (count($arrayParam) > 0)
		{
			$key = '';
			if ( !empty($arrayParam['type']) ) {
				$key .= $arrayParam['type'] . ':';
				switch($arrayParam['type'])
				{
					case Core_Stat::PRODUCTATTRIBUTE_VENDOR: 			$key .= 'v'; break;
					case Core_Stat::PRODUCTATTRIBUTE_PRICESEGMENT: 	$key .= 'ps'; break;
					case Core_Stat::PRODUCTATTRIBUTE_ATTRIBUTE: 		$key .= 'a'; break;
				}
				if ( !empty($arrayParam['typevalue']) ) $key .= str_replace('-', '',$arrayParam['typevalue']) . ':';
			}
			if ( !empty($arrayParam['store']) ) $key .= 'o'.$arrayParam['store'] . ':';
			if ( !empty($arrayParam['category']) ) $key .= 'c'.$arrayParam['category'] . ':';

			if ($key != '')
			{
				$arrayReturn = array();
				$curdaytimestamp = strtotime($datevalue);
				$month = date('n', $curdaytimestamp);
				$year = date('Y', $curdaytimestamp);
				$curday = date('j', $curdaytimestamp) - 1;//because index begin at 0
				for($i=0; $i < 31; $i++)
				{
					$arrayReturn[$i] = 0;
				}

				$key .= $year.sprintf('%02d', $month).':';
				$myCacher = new Cacher('statproductatt:' .$key, Cacher::STORAGE_REDIS, $conf['redis'][1]);	//1 days
				if (count($values) > 0)
				{
					$getDataValues = $myCacher->get();
					if (!empty($getDataValues))
					{
						$array = explode(',', $getDataValues);
						if (!empty($array[$curday]))
						{
							$nitem = explode(':', $array[$curday]);
							$arrayReturn = array('doanhthu' => $nitem[0], 'soluong' => $nitem[1], 'laigop' => $nitem[2]);
						}
					}
				}
			}
		}
		return $arrayReturn;
	}


	public static function getproducthavereport($startdate, $enddate, $catid = 0, $storeid = '')
	{
		global $conf;
        $listcategoryfromcache = array();
		$startmonth = $startdate;
		$listallmonthandyear = array();
		while($startmonth < $enddate)
		{
			$listallmonthandyear[date('Y', $startmonth)][date('n', $startmonth)][] = (date('j', $startmonth) - 1);
			$startmonth = strtotime('+1 day', $startmonth);
		}
		$keystore = '';
		if ($storeid > 0) $keystore .= ':'.$storeid;
		foreach ($listallmonthandyear as $cyear => $listmonths)
		{
			foreach ($listmonths as $cmonth => $valuedays)
			{
				if (count($valuedays) <= 0) continue;

				$myCacher = new Cacher('catlistreport:'. $cyear.sprintf('%02d', $cmonth).$keystore, Cacher::STORAGE_REDIS, $conf['redis'][1]);//
				$listcategoriesproducts = json_decode($myCacher->get(), true);
				if (empty($listcategoriesproducts)) return false;
				if ($catid > 0)
				{
					if (empty($listcategoriesproducts[$catid])) return false;
					foreach ($valuedays as $cday)
					{
						if (!empty($listcategoriesproducts[$catid][$cday]) && is_array($listcategoriesproducts[$catid][$cday]))
						{
							if (!empty($listcategoryfromcache[$catid]))
							{
								$listcategoryfromcache[$catid] = array_merge($listcategoryfromcache[$catid], $listcategoriesproducts[$catid][$cday]);
							}
							else $listcategoryfromcache[$catid] = $listcategoriesproducts[$catid][$cday];
						}
					}
					if (!empty($listcategoryfromcache[$catid])) $listcategoryfromcache[$catid] = array_unique($listcategoryfromcache[$catid]);
				}
				else
				{
					foreach ($listcategoriesproducts as $ccatid => $listproductbyday)
					{
						foreach ($valuedays as $cday)
						{

							if (!empty($listproductbyday[$cday]) && is_array($listproductbyday[$cday]))
							{
								if (!empty($listcategoryfromcache[$ccatid]))
								{
									$listcategoryfromcache[$ccatid] = array_merge($listcategoryfromcache[$ccatid], $listproductbyday[$cday]);
								}
								else $listcategoryfromcache[$ccatid] = $listproductbyday[$cday];
							}
						}
						if (!empty($listcategoryfromcache[$ccatid])) $listcategoryfromcache[$ccatid] = array_unique($listcategoryfromcache[$ccatid]);
					}
				}

				unset($listcategoriesproducts);
				unset($myCacher);
			}
		}

		return $listcategoryfromcache;
	}

}


