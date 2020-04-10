<?php

Abstract Class Controller_Site_Base Extends Controller_Core_Base 
{
    public $cartfirstpricetotal;
    public $cartItems;
    public function __construct($registry)
    {   
        parent::__construct($registry);
        
        $menupagetext = new Core_Page(73, true);//menu page
        $footerpagetext = new Core_Page(11, true);//footer page

        if($footerpagetext->status == Core_Page::STATUS_DISABLED)
        {
            $footerpagetext = null;
        }

		$searchmostpagetext = new Core_Page(42, true);//keyword search nhieu nhat
        if($searchmostpagetext->status == Core_Page::STATUS_DISABLED) {
            $searchmostpagetext = null;
        }

		$brandmostpagetext = new Core_Page(43, true);//nhan hieu ua chuong nhat
        if($brandmostpagetext->status == Core_Page::STATUS_DISABLED) {
            $brandmostpagetext = null;
        }

		$categorymostpagetext = new Core_Page(44, true);//danh muc ua chuong nhat
        if($categorymostpagetext->status == Core_Page::STATUS_DISABLED) {
            $categorymostpagetext = null;
        }
        
        $footerheaderparamtext = array( 'menu' => $menupagetext,
        								'footer' => $footerpagetext, 
										'search' => $searchmostpagetext, 
										'brand' => $brandmostpagetext, 
										'category' => $categorymostpagetext);
        $registry->smarty->assign(array(	'OsERP'    => Core_Product::OS_ERP,
                                            'OsERPPrepaid'    => Core_Product::OS_ERP_PREPAID,
                                            'OsCommingSoon'    => Core_Product::OS_COMMINGSOON,
                                            'OsHot' => Core_Product::OS_HOT,
											'OsNew' => Core_Product::OS_NEW,
											'OsBestSeller' => Core_Product::OS_BESTSELLER,
											'OsCrazySale' => Core_Product::OS_CRAZYSALE,
											'OsNoSell' => Core_Product::OS_NOSELL,
        									'OsDoanGia' => Core_Product::OS_DOANGIA,
        									'footerheadertext' => $footerheaderparamtext
                                        )
                                   );        
        
    }


	protected function getRedirectUrl()
	{
		
		
		$redirectUrl = $this->registry->router->getArg('redirect');
		if(strlen($redirectUrl) > 0)
			$redirectUrl = base64_decode($redirectUrl);	
		else
			$redirectUrl = $this->registry->conf['rooturl'] . $this->registry->controller;
			
		return $redirectUrl;
	} 
	
	protected function notfound()
	{
		
		header('HTTP/1.0 404 Not Found');
		readfile('./404.html');
		
		//header('location: ' . $this->registry->conf['rooturl'] . 'notfound?r=' . base64_encode(Helper::curPageURL()));
		exit();
	}
	
}
