<?php

Class Controller_Task_NewOrder Extends Controller_Task_Base 
{
	
	public function indexAction()
	{
		$orderid = (int)$_POST['oid'];
		$type = (string)$_POST['type'];
		
		
		//$fh = fopen('neworder.txt', 'w');
		//$param = var_export($_POST, true);
		//fwrite($fh,$param);
		//fclose($fh);
		
		
		
		//check valid param
		if($orderid == 0)
			die('e1');
		
		$myOrder = new Core_Orders($orderid);
		
		//check valid object
		if($myOrder->id == 0)
			die('e2');
		
		//lay region & subregion
		if($myOrder->shippingsubregion > 0)
			$myOrder->subregion = new Core_Region($myOrder->shippingsubregion);
		
		if($myOrder->shippingregion > 0)
			$myOrder->region = new Core_Region($myOrder->shippingregion);
		
		//lay order detail
		$items = Core_OrdersDetail::getOrdersDetails(array('foid' => $myOrder->id), 'id', 'ASC', 1000);
		for($i = 0; $i < count($items); $i++)
		{
			$items[$i]->book = new Core_Book($items[$i]->bid);
			$items[$i]->subtotal = $items[$i]->pricefinal * $items[$i]->quantity;
		}
		
		
		$this->registry->smarty->assign(array('myOrder' => $myOrder, 
												'items' => $items));
												
		//fetch order detail print version to include in email
		$invoiceHtml = $this->registry->smarty->fetch('_controller/user/orders/print.tpl');
		
		$this->registry->smarty->assign(array('invoiceHtml' => $invoiceHtml));
		
		
		/////////////////////////////////////
		//tien hanh send email cho buyer
		$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'orders/buyerpending.tpl');
		
		//fwrite($fh,$mailContents);
		
		//send mail
		if($type == 'completedestimate')
			$subjectBuyer = $this->registry->lang['controller']['subjectBuyerCompletedEstimate'];
		else
			$subjectBuyer = $this->registry->lang['controller']['subjectBuyer'];
			
		$sender =  new SendMail($this->registry,
								'',
								'',
								str_replace('###VALUE###', $myOrder->invoiceid, $subjectBuyer),
								$mailContents,
								$this->registry->setting['mail']['fromEmail'],
								$this->registry->setting['mail']['fromName']
								);
		$sender->toArray = array($myOrder->contactemail => Helper::refineEmailSendername($myOrder->billingfullname));
		
		if($sender->Send())
		{
			//echo 'sent ok';
			//fwrite($fh,'.SENT.');
			
		}
		else
		{
			//echo 'not sent';
		}
		
		
		//tien hanh send email cho admin
		$mailContents = $this->registry->smarty->fetch($this->registry->smartyMailContainerRoot.'orders/adminpending.tpl');
		
		if($type == 'completedestimate')
			$subjectAdmin = $this->registry->lang['controller']['subjectAdminCompletedEstimate'];
		else
			$subjectAdmin = $this->registry->lang['controller']['subjectAdmin'];
			
		//send mail
		$sender =  new SendMail($this->registry,
								'',
								'',
								str_replace(array('###VALUE###', '###VALUE2###', '###VALUE3###'), 
											array($myOrder->invoiceid, Helper::formatPrice($myOrder->pricefinal), $myOrder->shippingaddress . ', ' . $myOrder->subregion->name . ', ' . $myOrder->region->name), 
											$subjectAdmin),
								$mailContents,
								$this->registry->setting['mail']['fromEmail'],
								$this->registry->setting['mail']['fromName']
								);
		//$sender->toArray = array($this->registry->setting['mail']['fromEmail'] => Helper::refineEmailSendername($this->registry->setting['mail']['fromName']));
		
		$sender->toArray = array(
			'tuanmaster2002@yahoo.com' => 'Vo Duy Tuan',
			'my.pham@phanthi.vn' => 'My Pham',
			'trang.phan@phanthi.vn' => 'Trang Phan',
			'hong.ly@phanthi.vn' => 'hong.ly@phanthi.vn',
			'info@bookbuy.vn' => 'info@bookbuy.vn',
			'lai.hoang@phanthi.vn' => 'lai.hoang@phanthi.vn',
			'nha.nguyen@phanthi.vn' => 'nha.nguyen@phanthi.vn'
		);
		
		
		if($sender->Send())
		{
			//echo 'sent ok';
		}
		else
		{
			//echo 'not sent';
		}
	}
	
}

