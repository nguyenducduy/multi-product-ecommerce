<?php

Class Controller_Admin_ImportMissColumn Extends Controller_Admin_Base 
{
	public function indexAction()
	{
		
	}
	
	public function importstoreAction()
	{
		set_time_limit(0);
		$oracle = new Oracle();
		
		$liststoreissale = $oracle->query('SELECT * FROM ERP.VW_PM_STORE_DM');
		if (!empty($liststoreissale))
		{
			foreach($liststoreissale as $store)
			{
				$myStore = new Core_Store($store['STOREID']);
				$myStore->id = $store['STOREID'];
				$myStore->aid = $store['AREAID'];
				$myStore->ppaid = $store['PRICEAREAID'];
				$myStore->name = $store['STORENAME'];
				$myStore->region = $store['PROVINCEID'];
				$myStore->issalestore = $store['ISSALESTORE'];
				$myStore->isbizstockstore = $store['ISBIZSTOCKSTORE'];
				if ($myStore->id > 0)
				{
					$myStore->updateData();
				}
				else
				{
					$myStore->address = $store['STOREADDRESS'];				
					$myStore->phone = $store['STOREPHONENUM'];				
					$myStore->lat = $store['LNG'];
					$myStore->lng = $store['LAT'];
					$myStore->addData();
				}
			}
		}
	}
	
	//update cai nay de biet store nao dang ban hang, store nao la kho
	public function importissalestoreAction()
	{
		set_time_limit(0);
		$oracle = new Oracle();
		$db3 = Core_Backend_Object::getDb();
		$liststoreissale = $oracle->query('SELECT ISSALESTORE, STOREID FROM ERP.VW_PM_STORE_DM');
		if (!empty($liststoreissale))
		{
			foreach($liststoreissale as $store)
			{
				$sqlupdate = 'UPDATE '.TABLE_PREFIX.'store SET s_issalestore = '.$store['ISSALESTORE'].' WHERE s_id = '.(int)$store['STOREID'];
				$db3->query($sqlupdate);
			}
		}
	}
	
	//update cai nay de biet hinh thuc xuat nao dang ban, hinh thuc xuat nao tinh thuong,...
	public function importoutputtypeAction()
	{
		$db3 = Core_Backend_Object::getDb();
		set_time_limit(0);
		$oracle = new Oracle();
		
		$liststoreissale = $oracle->query('SELECT * FROM ERP.VW_PM_OUTPUTTYPE_DM');
		if (!empty($liststoreissale))
		{
			foreach($liststoreissale as $store)
			{
				//$sqlupdate = 'UPDATE '.TABLE_PREFIX.'product_outputype SET po_issale = '.$store['ISSALE'].', po_isreward = '.$store['ISREWARD'].', po_isdeleted = '.$store['ISDELETED'].', po_isinternalsale = '.$store['ISINTERNALSALE'].' WHERE  po_id = '.(int)$store['OUTPUTTYPEID'];
//				$db3->query($sqlupdate);
				$sqlupdate = 'INSERT INTO '.TABLE_PREFIX.'product_outputype(po_id, po_name, po_salechannelid,  	po_salechannelname, po_isdeleted, po_issale, po_isreward,  	po_isinternalsale) VALUE (?,?,?,?,?,?,?,?)';
				$db3->query($sqlupdate, array(
																(int)$store['OUTPUTTYPEID'], 
																(string)$store['OUTPUTTYPENAME'], 
																(int)$store['SALECHANNELID'], 
																(string)$store['SALECHANNELNAME'], 
																(int)$store['ISDELETED'], 
																(int)$store['ISSALE'], 
																(int)$store['ISREWARD'],
																(int)$store['ISINTERNALSALE']));
			}
		}
	}
	
	//import inputtype
	public function importinputtypeAction()
	{
		set_time_limit(0);
		$oracle = new Oracle();
		$db3 = Core_Backend_Object::getDb();
		$liststoreissale = $oracle->query('SELECT * FROM ERP.VW_INPUTTYPE_DM');
		if (!empty($liststoreissale))
		{
			foreach($liststoreissale as $store)
			{
				$sqlupdate = 'INSERT INTO '.TABLE_PREFIX.'product_inputtype(pi_id, pi_name, pi_isreturnsale, pi_isrequiredorder) VALUE (?,?,?,?)';
				$db3->query($sqlupdate, array(
																(int)$store['INPUTTYPEID'], 
																(string)$store['INPUTTYPENAME'], 
																(int)$store['ISRETURNSALE'], 
																(int)$store['ISREQUIREORDER']));
			}
		}
	}
}

