<?php

Class Controller_Stat_Sale Extends Controller_Stat_Base
{
	public $recordPerPage = 20;
	
	public function indexAction()
	{
		$formData = $error = $chartData = array();
		list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
		
			
		//////
		//output
		$this->registry->smarty->assign(array('formData' => $formData,
												'dateRangeStart' => $dateRangeStart,
												'dateRangeEnd' => $dateRangeEnd,
												'chartTitle' => $chartTitle,
												'chartData' => $chartData,
												'chartNames' => $chartNames,
												'customchart' => $customchart,
												'error'	=> $error,	
												'regionList' => $this->getRegionList(),
												'storeList' => Core_Store::getStores(array(), 'region', 'ASC'),
												'ordertypeList' => Core_Ordertype::getOrdertypes(array() , '' , '', ''),
												'vendorList' => Core_Vendor::getVendors(array('ftype'=>Core_Vendor::TYPE_VENDOR) , 'name' , 'ASC'),
												'categoryList' => $this->getCategoryList(),
												));
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
		
	}
	
	
	public function fetchajaxAction()
	{
		$formData = $error = $chartData = array();
		list($dateRangeStart, $dateRangeEnd) = $this->getDateRange();
		
			
		//////
		//output
		$this->registry->smarty->assign(array('formData' => $formData,
												'dateRangeStart' => $dateRangeStart,
												'dateRangeEnd' => $dateRangeEnd,
												'chartTitle' => $chartTitle,
												'chartData' => $chartData,
												'chartNames' => $chartNames,
												'customchart' => $customchart,
												'error'	=> $error,	
												
												));
		
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'fetch.tpl');
		
	}
	
	
	public function productsearchajaxAction()
	{
		$keyword = $_GET['keyword'];
		
		
	}
	
	public function getCategoryList()
	{
		$rootCategories = Core_ProductCategory::getSubProductcategory();
		
		$finalCategories = array();
		
		foreach($rootCategories as $category)
		{
			if(count($category->sublist) > 0)
			{
				foreach($category->sublist as $subcategory)
				{
					$subcategory->parentcategory = $category;
					$finalCategories[] = $subcategory;
				}
			}
		}
		
		return $finalCategories;
	}
	
	public function getRegionList()
	{
		$regions = array(
			'3' => 'TP.Hồ Chí Minh',
			'82' => 'An Giang',
			'102' => 'Bà Rịa - Vũng Tàu',
			'109' => 'Bình Dương',
			'6' => 'Đắc Lắk',
			'132' => 'Long An',
			'144' => 'Sóc Trăng',
			'146' => 'Tây Ninh',
			'151' => 'Tiền Giang',
		);
		
		return $regions;
	}
	
	
	//////////////////
	/**
	 * Return the mix of sale chart
	 */
	public function combinerAction()
	{
		$mySale = new Core_Chart_Sale();
		$mySale->getCombination();
		
	}
	
	
	
}



