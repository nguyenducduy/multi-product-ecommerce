<?php

Class Core_Chart_Sale extends Core_Chart_Base
{
	public $title = 'Sale';
	
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
		return array();
	}
	
	public function getCombination()
	{
		//REG: Region (Group 1)
		//ORS: Originate Store (Group 1)
		//OPS: Output Store (Group 1)
		//OTY: Order type (Group 2)
		//VEN: Vendor (Group 3)
		//CAT: Category (Group 4)
		//PID: Product ID (Group 5)
		
		//Can not use multiple option in one Group
		//Group 5 can no be used with Group 3 or 4
		
		
		$groups = array();
		$groups[] = array('REG', 'OTY');
		$groups[] = array('ORS', 'OTY');
		$groups[] = array('OPS', 'OTY');
		$groups[] = array('VEN', 'OTY');
		$groups[] = array('CAT', 'OTY');
		
		$groups[] = array('REG', 'PID');
		$groups[] = array('ORS', 'PID');
		$groups[] = array('OPS', 'PID');
		$groups[] = array('OTY', 'PID');
		
		//Get all combinations
		$combinations = array();
		foreach($groups as $group)
		{
			$resultset = pc_array_power_set($group);
			$refinedset = array();
			foreach($resultset as $combine)
			{
				if(count($combine) > 0)
				{
					sort($combine);
					$refinedset[] = $combine;
				}
			}
			$combinations = array_merge($combinations, $refinedset);
		}
		
		///////////////////////////////
		//Remove duplication element
		$removeDuplicateCombinations = array_map('unserialize', array_unique(array_map('serialize', $combinations)));
		
		//////////////////////////////
		//Sort by element count
		usort($removeDuplicateCombinations, 'cmpelementcount');
		
		
		//////////////////////////////
		//Get the number of each Filter
		$quantity = array();
		$quantity['REG'] = array(3, 82, 102, 109, 6, 132, 144, 146, 151);
		$quantity['ORS'] = $this->getStoreList();
		$quantity['OPS'] = $this->getStoreList();
		$quantity['OTY'] = $this->getOrdertypeList();
		$quantity['VEN'] = $this->getVendorList();
		$quantity['CAT'] = $this->getCategoryList();
		$quantity['PID'] = $this->getProductList();
		
		//////////////////////////
		//Calculate the combination quantity
		$total = 0;
		foreach($removeDuplicateCombinations as $combination)
		{
			$subtotal = 1;
			
			foreach($combination as $group)
			{
				$subtotal *= count($quantity[$group]);
			}
			
			echo '<h3>' . implode(',', $combination) . ': ' . $subtotal . '</h3>';
			
			$total += $subtotal;
		}
		echo '<h1>Total: ' . $total . '</h1>';
	}
	
	private function getStoreList()
	{
		global $db;
		
		$sql = 'SELECT s_id FROM ' . TABLE_PREFIX . 'store ORDER BY s_id ASC';
		$stmt = $db->query($sql);
		$idList = array();
		
		while($row = $stmt->fetch())
		{
			$idList[] = $row['s_id'];
		}
		return $idList;
	}
	
	private function getOrdertypeList()
	{
		global $db;
		$sql = 'SELECT ot_ordertypeid FROM ' . TABLE_PREFIX . 'ordertype ORDER BY ot_ordertypeid ASC';
		$stmt = $db->query($sql);
		$idList = array();
		
		while($row = $stmt->fetch())
		{
			$idList[] = $row['ot_ordertypeid'];
		}
		return $idList;
	}
	
	private function getVendorList()
	{
		global $db;
		$sql = 'SELECT v_id FROM ' . TABLE_PREFIX . 'vendor WHERE v_type = ? ORDER BY v_id ASC';
		$stmt = $db->query($sql, array(Core_Vendor::TYPE_VENDOR));
		$idList = array();
		
		while($row = $stmt->fetch())
		{
			$idList[] = $row['v_id'];
		}
		return $idList;
	}
	
	private function getCategoryList()
	{
		global $db;
		$sql = 'SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory 
			WHERE pc_parentid IN (SELECT pc_id FROM ' . TABLE_PREFIX . 'productcategory WHERE pc_parentid = 0)
			ORDER BY pc_id ASC';
		$stmt = $db->query($sql);
		$idList = array();
		
		while($row = $stmt->fetch())
		{
			$idList[] = $row['pc_id'];
		}
		return $idList;
	}
	
	private function getProductList()
	{
		global $db;
		$sql = 'SELECT p_id FROM ' . TABLE_PREFIX . 'product ORDER BY p_id ASC';
		$stmt = $db->query($sql);
		$idList = array();
		
		while($row = $stmt->fetch())
		{
			$idList[] = $row['p_id'];
		}
		return $idList;
	}
	
}



function pc_array_power_set($array) {
    // initialize by adding the empty set
    $results = array(array( ));

    foreach ($array as $element)
        foreach ($results as $combination)
            array_push($results, array_merge(array($element), $combination));

    return $results;
}

function cmpelementcount($a, $b)
{
	if(count($a) > count($b))
		return 1;
	elseif(count($a) < count($b))
		return -1;
	else
		return 0;
}
