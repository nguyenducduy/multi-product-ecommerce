<?php

Class Core_Chart_ProductView extends Core_Chart_Base
{
	public $title = 'Product View';
	
	const TYPE_ALL = 0;
	const TYPE_BY_CATEGORY = 2;
	const TYPE_BY_PRODUCTID = 4;
	
	//Base on type of this Chart, we will get the correct data from the Data storage
	public function getData($datestart, $dateend, $type = 0, $objectid = 0)
	{
		$dateranges = $this->extractDateRange($datestart, $dateend);
		
		//base on $dateranges, we will retreive the data for this section
		
	}
	
	public function collectData($datestart, $dateend)
	{
		//Connect to main DB to get the data for all Type of this kind of chart
		
		/////////////////////////
		//TYPE_ALL
		
		////////////////////////
		//TYPE_BY_CATEGORY
		
		////////////////////////
		//TYPE_BY_PRODUCTID
	}
	
	public function getTypeList()
	{
		$list = array();
		
		$list[] = array('type' => self::TYPE_ALL, 'requireid' => false);
		$list[] = array('type' => self::TYPE_BY_CATEGORY, 'requireid' => true);
		$list[] = array('type' => self::TYPE_BY_PRODUCTID, 'requireid' => true);
		
		return $list;
	}
}