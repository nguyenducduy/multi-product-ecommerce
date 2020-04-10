<?php

Class Controller_Site_Orders Extends Controller_Site_Base
{

	function indexAction()
	{
		$formData = array();
		$page 			= (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
		$paginateSuffix = '';

		$formData['fuid'] = $this->registry->me->id;

		if(isset($_GET['search']))
		{
			$formData['fkeywordFilter'] = htmlspecialchars($_GET['keyword']);
			$paginateSuffix = '?search=1&amp;keyword=' . $formData['fkeywordFilter'];

			if(mb_strlen($formData['fkeywordFilter']) < $this->registry->setting['book']['minSearchKeyword'])
			{
				$stopSelect = 1;
				$warning = $this->registry->lang['controller']['warnSearchLengthToShort'];
			}
		}

		//tim tong so record
		$total = Core_Orders::getOrderss($formData, 'id', 'DESC', $this->registry->setting['order']['recordPerPage'], true);
		$totalPage = ceil($total/$this->registry->setting['order']['recordPerPage']);
		$curPage = $page;
		$paginateUrl = $this->registry->me->getUserPath().'/orders/';

		//process to limit page, prevent leech book data
		if($curPage != 1 && $curPage > $totalPage)
		{
			$this->notfound();
		}


		$orderList = Core_Orders::getOrderss($formData, 'id', 'DESC', (($page - 1)*$this->registry->setting['order']['recordPerPage']).','.$this->registry->setting['order']['recordPerPage']);

		for($i = 0; $i < count($orderList); $i++)
		{
			//tim order detail
			$items = Core_OrdersDetail::getOrdersDetails(array('foid' => $orderList[$i]->id), 'id', 'ASC');
			$orderList[$i]->booklist = array();
			foreach($items as $item)
			{
				$orderList[$i]->booklist[] = new Core_Book($item->bid, true);
			}
		}

		$this->registry->smarty->assign(array('orderList' 	=> $orderList,
											'formData'		=> $formData,
											'success'		=> $success,
											'paginateurl' 	=> $paginateUrl,
											'paginatesuffix' 	=> $paginateSuffix,
											'total'			=> $total,
											'totalPage' 	=> $totalPage,
											'curPage'		=> $curPage
											));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');


		//SEO PREPARE
		$pageTitle = $this->registry->me->fullname . $this->registry->lang['controller']['pageTitle'];;
		$pageKeyword = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'];
		$pageDescription = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageDescription'];

		if(isset($formData['fkeywordFilter']))
		{
			$pageTitle = 'Search: ' . $formData['fkeywordFilter'];
			$pageKeyword = $formData['fkeywordFilter'] . $pageKeyword;
			$pageDescription = $formData['fkeywordFilter'] . $pageDescription;
		}


		if($curPage > 1)
		{
			$pageTitle .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage;
			$pageKeyword .= $this->registry->lang['global']['pageTitlePrefix'] . $curPage . ',';
			$pageDescription .= $this->registry->lang['global']['pageDescriptionPrefix'] . $curPage . '.';
		}

		$this->registry->smarty->assign(array('contents' => $contents,
											'pageTitle' => $pageTitle,
											'pageKeyword' => $pageKeyword,
											'pageDescription' => $pageDescription,
											));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');

	}

	public function detailAction()
	{
		$myOrder = new Core_Orders($_GET['id']);

		//check buyer hoac seller co phai la ME
	    if($myOrder->id > 0 && ($this->registry->me->email == $myOrder->contactemail || $this->registry->me->id == $myOrder->shippinguserid))
	    {


			//SEO PREPARE
			$pageTitle = $this->registry->me->fullname . $this->registry->lang['controller']['pageTitleDetail'] . $myOrder->invoiceid;
			$pageKeyword = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'] . ',' . $myOrder->title;
			$pageDescription = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageDescription'] . '. '. $myOrder->title;

			$this->registry->smarty->assign(array('myOrder' => $myOrder,
												'myCategory'	=> $myCategory,
												'qualityList'	=> $qualityList,
												'statusList'	=> $statusList,
												'formData'	=> $formData,
												'error'		=> $error,
												'success'		=> $success,
												));

			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

			$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle' => $pageTitle,
												'pageKeyword' => $pageKeyword,
												'pageDescription' => $pageDescription
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
		}
		else
		    $this->notfound();
	}

	public function printAction()
	{
		$myOrder = new Core_Orders($_GET['id']);

		//check buyer hoac seller co phai la ME
	    if($myOrder->id > 0 && ($this->registry->me->email == $myOrder->contactemail || $this->registry->me->id == $myOrder->shippinguserid || $this->registry->me->isGroup('administrator') || $this->registry->me->isGroup('bookstore')))
	    {

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

			//SEO PREPARE
			$pageTitle = $this->registry->me->fullname . $this->registry->lang['controller']['pageTitleDetail'] . $myOrder->invoiceid;
			$pageKeyword = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageKeyword'] . ',' . $myOrder->title;
			$pageDescription = $this->registry->me->fullname . ', ' . $this->registry->lang['controller']['pageDescription'] . '. '. $myOrder->title;

			$this->registry->smarty->assign(array('myOrder' => $myOrder,
													'items' => $items
												));

			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'print.tpl');

			$this->registry->smarty->assign(array('contents' => $contents,
												'pageTitle' => $pageTitle,
												'pageKeyword' => $pageKeyword,
												'pageDescription' => $pageDescription
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index_print.tpl');
		}
		else
		    $this->notfound();
	}

	###########################################################
	###########################################################
	###########################################################

}


