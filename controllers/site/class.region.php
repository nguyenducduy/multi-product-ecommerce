<?php

Class Controller_Site_Region Extends Controller_Site_Base 
{
	
	function indexAction() 
	{
		  
		/*$rs= Core_Region::getList("","","");
		var_dump($rs);
		$str = '';
		foreach ($rs as $key => $value) {
			if($value->parentid==0)
			{
				if($value->lat!='' && $value->lat!='0' && $value->lng!='' && $value->lng!='0')
				{
					$str .="UPDATE `lit_region` SET `r_lat`='".$value->lat."' WHERE (`r_id`='".$value->id."');\r\n" ;
					$str .="UPDATE `lit_region`  SET `r_lng`='".$value->lng."' WHERE (`r_id`='".$value->id."');\r\n" ;
				}
				
			}
		}
		
		$path="D:/wamp/www/dienmay/controllers/site/region.txt";
		$file=fopen($path, "a");
		$write=fwrite($file,$str);
		fclose($file);*/
	} 
	
	function subregionajaxAction()
	{
		$regionid = (int)$_GET['id'];
		$selectedregionid = (int)$_GET['selected'];
		
		$output = '';
		if($regionid > 0)
		{
			$regions = Core_Region::getRegions(array('fparentid' => $regionid), 'displayorder', 'ASC', 100);
			$output = '<option value="0">'.$this->registry->lang['controller']['selectsubregion'].'</option>';
			
			foreach($regions as $region)
			{
				$output .= '<option value="'.$region->id.'" '.($selectedregionid == $region->id ? 'selected="selected"' : '').'>'.$region->name.'</option>';
			}
			
			$output .= '<option value="-1">'.$this->registry->lang['controller']['othersubregion'].'</option>';
		}
		
		echo $output;
	}
	
}

