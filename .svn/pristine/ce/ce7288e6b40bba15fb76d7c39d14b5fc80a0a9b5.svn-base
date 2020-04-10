<?php
class Controller_Admin_OrderArchive Extends Controller_Admin_Base 
{
	private $recordPerPage = 20;
	private $refesh = 0;
	public function indexAction($action ='')
	{

		// Ghi tiếp



		/*// echo date("d-M-y h:i:s A","1363283101");
		$this->formatTime('14-MAR-13 12.45.49.227190000 PM');
		echo "<br>";
		// echo date("d-M-y h:i:s A","1325390941");
		die();*/
		
		set_time_limit(0);
		$oracle = new Core_OrderArchive();
		$flag             = false;
		$action           = $action !=''  ? $action : $this->registry->router->getArg('action');
		if($action == "reset")
		{
			var_dump($_SESSION);
			unset($_SESSION['begin']);
			unset($_SESSION['end']);
			unset($_SESSION['ok']);
			unset($_SESSION['begindate']);
			unset($_SESSION['id']);
			var_dump($_SESSION);
			echo "reset success";
			die();
		}
		$arrcheck = array();
		$recordGetPerTime  = 1000;
		$date              = getdate();
		if($action == 'import')
		{
			$count = Core_OrderArchive::CountgetOrderAchiveByID();
			/*
			$_SESSION['begin']     = isset($_SESSION['begin']) ? $_SESSION['begin'] + $recordGetPerTime : 0;
			$_SESSION['end']       = $_SESSION['begin'] + $recordGetPerTime;
			$results               = Core_OrderArchive::getOrderAchiveBydate($_SESSION['begindate'], '' , $_SESSION['begin'] , $_SESSION['end'] , false);*/
			$_SESSION['begindate'] = "01-JAN-12";
			$count                 = Core_OrderArchive::CountgetOrderAchiveByID($_SESSION['begindate']);
			$chia                  = (int)$count / (int)$recordGetPerTime;
			$countA = Core_Archivedorder::countList('');
			$toltalget = ceil($chia);
			
			for ($j=0; $j <= $toltalget ; $j++) { 

				set_time_limit(0);

				$begin   = $j*$recordGetPerTime+1;
				$end     = $begin+$recordGetPerTime-1;
				
				
				$results = Core_OrderArchive::getOrderAchiveBydate($_SESSION['begindate'], '',$begin , $end , false);
			
				if(!empty($results))
				{
					$count = count($results);
					for($i = 0 ; $i < count($results) ; $i++) 
					{
						if(!in_array($results[$i]['SALEORDERID'], $arrcheck))
						{
							$myArchivedorder = new Core_Archivedorder();
							$id = $results[$i]['SALEORDERID'];
						
							$arrcheck[]= $results[$i]['SALEORDERID'];
							$myArchivedorder->saleorderid          = $results[$i]['SALEORDERID'];
							$myArchivedorder->ordertypeid          = $results[$i]['ORDERTYPEID'];
							$myArchivedorder->deliverytypeid       = $results[$i]['DELIVERYTYPEID'];
							$myArchivedorder->companyid            = $results[$i]['COMPANYID'];
							$myArchivedorder->customerid           = $results[$i]['CUSTOMERID'];
							$myArchivedorder->customername         = $results[$i]['CUSTOMERNAME'];
							$myArchivedorder->customeraddress      = $results[$i]['CUSTOMERADDRESS'];
							$myArchivedorder->customerphone        = $results[$i]['CUSTOMERPHONE'];
							$myArchivedorder->contactname          = $results[$i]['CONTACTNAME'];
							$myArchivedorder->gender               = $results[$i]['GENDER'];
							$myArchivedorder->ageid                = $results[$i]['AGEID'];
							$myArchivedorder->deliveryaddress      = $results[$i]['DELIVERYADDRESS'];
							$myArchivedorder->provinceid           = $results[$i]['PROVINCEID'];
							$myArchivedorder->districtid           = $results[$i]['DISTRICTID'];
							$myArchivedorder->isreviewed           = $results[$i]['ISREVIEWED'];
							$myArchivedorder->payabletypeid        = $results[$i]['PAYABLETYPEID'];
							$myArchivedorder->currencyunitid       = $results[$i]['CURRENCYUNITID'];
							$myArchivedorder->currencyexchange     = $results[$i]['CURRENCYEXCHANGE'];
							$myArchivedorder->totalquantity        = $results[$i]['TOTALQUANTITY'];
							$myArchivedorder->totalamount          = $results[$i]['TOTALAMOUNT'];
							$myArchivedorder->totaladvance         = $results[$i]['TOTALADVANCE'];
							$myArchivedorder->shippingcost         = $results[$i]['SHIPPINGCOST'];
							$myArchivedorder->debt                 = $results[$i]['DEBT'];
							$myArchivedorder->discountreasonid     = $results[$i]['DISCOUNTREASONID'];
							$myArchivedorder->discount             = $results[$i]['DISCOUNT'];
							$myArchivedorder->originatestoreid     = $results[$i]['ORIGINATESTOREID'];
							$myArchivedorder->isoutproduct         = $results[$i]['ISOUTPRODUCT'];
							$myArchivedorder->outputstoreid        = $results[$i]['OUTPUTSTOREID'];
							$myArchivedorder->isincome             = $results[$i]['ISINCOME'];
							$myArchivedorder->isdeleted            = $results[$i]['ISDELETED'];
							$myArchivedorder->promotiondiscount    = $results[$i]['PROMOTIONDISCOUNT'];
							$myArchivedorder->vouchertypeid        = $results[$i]['VOUCHERTYPEID'];
							$myArchivedorder->voucherconcern       = $results[$i]['VOUCHERCONCERN'];
							$myArchivedorder->deliveryuser         = $results[$i]['DELIVERYUSER'];
							$myArchivedorder->saleprogramid        = $results[$i]['SALEPROGRAMID'];
							$myArchivedorder->totalpaid            = $results[$i]['TOTALPAID'];
							$myArchivedorder->issmspromotion       = $results[$i]['ISSMSPROMOTION'];
							$myArchivedorder->deliverytime         = $this->formatTime($results[$i]['DELIVERYTIME']);
							$myArchivedorder->isdelivery           = $results[$i]['ISDELIVERY'];
							$myArchivedorder->deliveryupdatetime   = $this->formatTime($results[$i]['DELIVERYUSERUPDATETIME']);
							$myArchivedorder->ismove               = $results[$i]['ISMOVE'];
							$myArchivedorder->parentsaleorderid    = $results[$i]['PARENTSALEORDERID'];
							$myArchivedorder->thirdpartyvoucher    = $results[$i]['THIRDPARTYVOUCHER'];
							$myArchivedorder->payabletime          = $this->formatTime($results[$i]['PAYABLETIME']);
							$myArchivedorder->createdbyotherapps   = $results[$i]['CREATEDBYOTHERAPPS'];
							$myArchivedorder->contactphone         = $results[$i]['CONTACTPHONE'];
							$myArchivedorder->customercarestatusid = $results[$i]['CUSTOMERCARESTATUSID'];
							$myArchivedorder->totalprepaid         = $results[$i]['TOTALPREPAID'];
							$myArchivedorder->crmcustomerid        = $results[$i]['CRMCUSTOMERID'];
							$myArchivedorder->createdate 		   = $this->formatTime($results[$i]['CREATEDATE']);
							if($i == 0 || !$flag)
							{
								$checkid =Core_Archivedorder::countList("o_saleorderid = '$id'");
								if($checkid == 0 )
								{
									
									$flag               = true;
									$Lastid             = $myArchivedorder->addData();
								}
							}
							if($flag)
							{
								$Lastid             = $myArchivedorder->addData();
							}
						}
						else
						{
								$str   = "begin :".$begin." end : ".$end." rownum ".$results[$i]['RNUM']."\r\n idsaleorder : ".$results[$i]['SALEORDERID']."\r\n";
								$sql   = Core_OrderArchive::ghisqlloi($_SESSION['begindate'],$begin,$end);
								$str   .= $sql."#################################################\r\n";
								$path  =realpath("controllers/admin/text.txt");
								$file  =fopen($path, "a");
								$write =fwrite($file,$str);
								fclose($file);
						}

						
					}
				}

			}
			$countA_new = Core_Archivedorder::countList('');
			$subcount = $countA_new-$countA;
			$this->getdetailajaxAction('sync',$subcount);
			
		}

		if($action == 'sync')
		{

				
			if(!isset($_SESSION['begindate']))
			{

				$rs                    = Core_Archivedorder::getDataSync();
				$_SESSION['begindate'] = Core_OrderArchive::getOrderAchiveByID($rs);

			}
			$countA = Core_Archivedorder::countList('');
			$count = 	Core_OrderArchive::CountgetOrderAchiveByID($_SESSION['begindate']);
			$chia = (int)$count / (int)$recordGetPerTime;
			$toltalget = ceil($chia);
			for ($j=0; $j <= $toltalget ; $j++) { 
				set_time_limit(0);

				$begin   =   $j*$recordGetPerTime;
				$end     =   $begin+$recordGetPerTime;
				$results = 	 Core_OrderArchive::getOrderAchiveBydate($_SESSION['begindate'], '',$begin , $end , false);
				if(!empty($results))
				{
					$count = count($results);
					for($i = 0 ; $i < count($results) ; $i++) 
					{
						if(!in_array($results[$i]['SALEORDERID'], $arrcheck))
						{
							$myArchivedorder = new Core_Archivedorder();
							$id = $results[$i]['SALEORDERID'];
							$myArchivedorder->saleorderid          = $results[$i]['SALEORDERID'];
							$myArchivedorder->ordertypeid          = $results[$i]['ORDERTYPEID'];
							$myArchivedorder->deliverytypeid       = $results[$i]['DELIVERYTYPEID'];
							$myArchivedorder->companyid            = $results[$i]['COMPANYID'];
							$myArchivedorder->customerid           = $results[$i]['CUSTOMERID'];
							$myArchivedorder->customername         = $results[$i]['CUSTOMERNAME'];
							$myArchivedorder->customeraddress      = $results[$i]['CUSTOMERADDRESS'];
							$myArchivedorder->customerphone        = $results[$i]['CUSTOMERPHONE'];
							$myArchivedorder->contactname          = $results[$i]['CONTACTNAME'];
							$myArchivedorder->gender               = $results[$i]['GENDER'];
							$myArchivedorder->ageid                = $results[$i]['AGEID'];
							$myArchivedorder->deliveryaddress      = $results[$i]['DELIVERYADDRESS'];
							$myArchivedorder->provinceid           = $results[$i]['PROVINCEID'];
							$myArchivedorder->districtid           = $results[$i]['DISTRICTID'];
							$myArchivedorder->isreviewed           = $results[$i]['ISREVIEWED'];
							$myArchivedorder->payabletypeid        = $results[$i]['PAYABLETYPEID'];
							$myArchivedorder->currencyunitid       = $results[$i]['CURRENCYUNITID'];
							$myArchivedorder->currencyexchange     = $results[$i]['CURRENCYEXCHANGE'];
							$myArchivedorder->totalquantity        = $results[$i]['TOTALQUANTITY'];
							$myArchivedorder->totalamount          = $results[$i]['TOTALAMOUNT'];
							$myArchivedorder->totaladvance         = $results[$i]['TOTALADVANCE'];
							$myArchivedorder->shippingcost         = $results[$i]['SHIPPINGCOST'];
							$myArchivedorder->debt                 = $results[$i]['DEBT'];
							$myArchivedorder->discountreasonid     = $results[$i]['DISCOUNTREASONID'];
							$myArchivedorder->discount             = $results[$i]['DISCOUNT'];
							$myArchivedorder->originatestoreid     = $results[$i]['ORIGINATESTOREID'];
							$myArchivedorder->isoutproduct         = $results[$i]['ISOUTPRODUCT'];
							$myArchivedorder->outputstoreid        = $results[$i]['OUTPUTSTOREID'];
							$myArchivedorder->isincome             = $results[$i]['ISINCOME'];
							$myArchivedorder->isdeleted            = $results[$i]['ISDELETED'];
							$myArchivedorder->promotiondiscount    = $results[$i]['PROMOTIONDISCOUNT'];
							$myArchivedorder->vouchertypeid        = $results[$i]['VOUCHERTYPEID'];
							$myArchivedorder->voucherconcern       = $results[$i]['VOUCHERCONCERN'];
							$myArchivedorder->deliveryuser         = $results[$i]['DELIVERYUSER'];
							$myArchivedorder->saleprogramid        = $results[$i]['SALEPROGRAMID'];
							$myArchivedorder->totalpaid            = $results[$i]['TOTALPAID'];
							$myArchivedorder->issmspromotion       = $results[$i]['ISSMSPROMOTION'];
							$myArchivedorder->deliverytime         = $this->formatTime($results[$i]['DELIVERYTIME']);
							$myArchivedorder->isdelivery           = $results[$i]['ISDELIVERY'];
							$myArchivedorder->deliveryupdatetime   = $this->formatTime($results[$i]['DELIVERYUSERUPDATETIME']);
							$myArchivedorder->ismove               = $results[$i]['ISMOVE'];
							$myArchivedorder->parentsaleorderid    = $results[$i]['PARENTSALEORDERID'];
							$myArchivedorder->thirdpartyvoucher    = $results[$i]['THIRDPARTYVOUCHER'];
							$myArchivedorder->payabletime          = $this->formatTime($results[$i]['PAYABLETIME']);
							$myArchivedorder->createdbyotherapps   = $results[$i]['CREATEDBYOTHERAPPS'];
							$myArchivedorder->contactphone         = $results[$i]['CONTACTPHONE'];
							$myArchivedorder->customercarestatusid = $results[$i]['CUSTOMERCARESTATUSID'];
							$myArchivedorder->totalprepaid         = $results[$i]['TOTALPREPAID'];
							$myArchivedorder->crmcustomerid        = $results[$i]['CRMCUSTOMERID'];
							$myArchivedorder->createdate 		   = $this->formatTime($results[$i]['CREATEDATE']);
							if($i == 0 || !$flag)
							{
								$checkid =Core_Archivedorder::countList("o_saleorderid = '$id'");
								if($checkid == 0 )
								{
									
									$flag               = true;
									$Lastid             = $myArchivedorder->addData();
								}
							}
							if($flag)
							{
								$Lastid             = $myArchivedorder->addData();
							}
						}
						else
						{
							$str   = "begin :".$begin." end : ".$end." rownum ".$results[$i]['RNUM']."\r\n idsaleorder : ".$results[$i]['SALEORDERID']."\r\n";
							$sql   = Core_OrderArchive::ghisqlloi($_SESSION['begindate'],$begin,$end);
							$str   .= $sql."#################################################\r\n";
							$path  =realpath("controllers/admin/text.txt");
							$file  =fopen($path, "a");
							$write =fwrite($file,$str);
							fclose($file);
						}
						unset($myArchivedorder);
					}
					unset($results);
				}
			}
			$countA_new = Core_Archivedorder::countList('');
			$subcount = $countA_new-$countA;
			$this->getdetailajaxAction($action,$subcount);
			
		}
		
	}


	public function importAction()
	{
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}
	

	
	public function getdetailajaxAction($action='',$count_old=0)
	{
		if($action=='')
		$action           = $action !=''  ? $action : $this->registry->router->getArg('action');
		
		$recordGetPerTime = 1000;
		if($action=="sync")
		{
			$orderdetail       = new Core_ArchivedorderDetail();
			$_SESSION['id']    = Core_ArchivedorderDetail::getDataSync();

			if($_SESSION['id'] == null || $_SESSION['id'] == '')
            {
                $_SESSION['id']    = 0;
            }


            $orderdetail->deleteByOrderid($_SESSION['id']);
			$count             = Core_Archivedorder::countList("o_id>'".$_SESSION['id']."'");
			$countd_old        = Core_ArchivedorderDetail::countList("");
			$total             = ceil($count/$recordGetPerTime);

			for ($i=0; $i <= $total ; $i++) 
			{ 
				set_time_limit(0);
				$begin = $i*1000;
				$results = Core_Archivedorder::getOrderByID($_SESSION['id'],$begin,$recordGetPerTime);

                if(!empty($results))
				{
					foreach ($results as $khoa => $giatri)
					{
						$oracle = new Core_OrderArchive();
						$rs = Core_OrderArchive::getOrderAchiveDetail($giatri['o_saleorderid']);//lay detail oracle

						// $myArchivedorderDetail->delete($oid);
						if(!empty($rs))
						{
							foreach ($rs as $key => $value) 
							{
                                $myArchivedorderDetail = new Core_ArchivedorderDetail();
								$id = $giatri['o_id'];
								$p_id= Core_Product::getIdByBarcode($value['PRODUCTID']);
								$myArchivedorderDetail->saleorderid          = $value['SALEORDERID'];
								$myArchivedorderDetail->oorderid             = $id;
								$myArchivedorderDetail->pid                  = $p_id;
								$myArchivedorderDetail->productid            = $value['PRODUCTID'];
								$myArchivedorderDetail->quantity             = $value['QUANTITY'];
								$myArchivedorderDetail->saleprice            = $value['SALEPRICE'];
								$myArchivedorderDetail->outputtypeid         = $value['OUTPUTTYPEID'];
								$myArchivedorderDetail->vat                  = $value['VAT'];
								$myArchivedorderDetail->salepriceerp         = $value['SALEPRICEERP'];
								$myArchivedorderDetail->endwarrantytime      = $this->formatTime($value['ENDWARRANTYTIME']);
								$myArchivedorderDetail->ispromotionautoadd   = $value['ISPROMOTIONAUTOADD'];
								$myArchivedorderDetail->promotionid          = $value['PROMOTIONID'];
								$myArchivedorderDetail->promotionlistgroupid = $value['PROMOTIONLISTGROUPID'];
								$myArchivedorderDetail->applyproductid       = $value['fapplyproductid'];
								$myArchivedorderDetail->replicationstoreid   = $value['RELICATIONSTOREID'];
								$myArchivedorderDetail->adjustpricetypeid    = $value['ADJUSTPRICETYPEID'];
								$myArchivedorderDetail->adjustprice          = $value['ADJUSTPRICE'];
								$myArchivedorderDetail->adjustpricecontent   = $value['ADJUSTPRICECONTENT'];
								$myArchivedorderDetail->discountcode         = $value['DISCOUNT'];
								$myArchivedorderDetail->adjustpriceuser      = $value['ADJUSTPRICEUSER'];
								$myArchivedorderDetail->vatpercent           = $value['VATPERCENT'];
								$myArchivedorderDetail->retailprice          = $value['RETAILPRICE'];
								$myArchivedorderDetail->inputvoucherdetailid = $value['INPUTVOUCHERDETAILID'];
								$myArchivedorderDetail->buyinputvoucherid    = $value['BUYINPUTVOUCHERID'];
								$myArchivedorderDetail->inputvoucherdate     = $value['INPUTVOUCHERDATE'];
								$myArchivedorderDetail->isnew                = $value['ISNEW'];
								$myArchivedorderDetail->isshowproduct        = $value['ISSHOWPRODUCT'];
								$myArchivedorderDetail->costprice            = $value['COSTPRICE'];
								$myArchivedorderDetail->productsaleskitid    = $value['PRODUCTSALESKITID'];
								$myArchivedorderDetail->refproductid         = $value['REFPRODUCTID'];
								$myArchivedorderDetail->productcomboid       = $value['PRODUCTCOMBOID'];
								$done = $myArchivedorderDetail->addData();
									
							}
							if($done)
							{
									Core_Archivedorder::updateIsDetail($giatri['o_id']);
							}
						}
				
					}
					unset($myArchivedorderDetail);
					unset($str);
					unset($rs);
					unset($arr);
					unset($results);
					
				}
			}
			$countd_new = Core_ArchivedorderDetail::countList("");
			if($count_old!=0)
			{
					echo "<h1>Đã import archivedorder xong ".$count_old."</h1><br/>";
			}
			echo "<h1>Đã import archivedorderdetail xong ".$countd_new-$countd_old."</h1>";
		}
	}
	private function formatTime($str,$debug = false)
	{
		// 14-MAR-13 12.02.22.041411000 PM
		if($str!=null)
		{
			$rs   = explode(" ",$str);
			$str  = substr($rs[1],0,8);
			$str  = $rs[0]." ".$str." ".$rs[2];
			$mang = explode(" ", $str);
			$gio  = substr($mang[1],0,-3);
			/*=================set h theo buoi================================*/
			$manggio = explode(".",$gio);
			$buoi    = $mang[2];
			$h       = $buoi == 'PM' ? $manggio[0] + 12 : $manggio[0] ;
			$gio     = $h.":".$manggio[1];
			/*=============================end====================*/
			$mang    = explode("-", $mang[0]);
			$str     = $mang[1]."-".$mang[0]."-".$mang[2];
			$str     = strtotime($str);
			$str     = date("d/m/y",$str);
			$str     = Helper::strtotimedmy($str,$gio);
			if($debug)
			{
				$strf 	= date('d/m/y h:i A' , $str);
				$rs 	= "str ban dau :" . $strf ."<br> str da format : ". $str;
				return $rs;
			}
			else
			{
				return $str;
			}
		}
		else
			return '';
		
	}

}

		