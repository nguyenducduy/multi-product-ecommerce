<?php

Class Controller_Site_promotion Extends Controller_Site_Base 
{
	private $recordPerPage = 20;
    private $recordPerSearchPage = 100;
	
	/**
	* Trang homepage cu, co day du va nhieu thong tin
	* 
	*/
	function indexAction() 
	{
		$cachefile = (SUBDOMAIN == 'm' ? 'mpromotionpage'.$fpcid.'.html' : 'promotionpage'.$fpcid.'.html');
		
		$myCache = new cache($cachefile, $this->registry->setting['cache']['site'], $this->registry->setting['cache']['promotionpageExpire']);
		$pageHtml = $myCache->get();
        
		if(!$pageHtml)
		{
			
            /*$this->registry->smarty->assign(
                        array(
                            'slidebanner'           =>  $this->getBanner(),
                            'rightbanner'           =>  $this->getBanner(6),
                        )                
                );
            
            $banner = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'banner.tpl'); 
            
            $arrayAssignTemplate['banner'] = $banner;*/
            $arrayAssignTemplate['pageTitle'] = 'Khuyến mãi';
            $arrayAssignTemplate['pageKeyword'] = 'Khuyến mãi';
            $arrayAssignTemplate['pageDescription'] = 'Khuyến mãi';
            
            $arrayAssignTemplate['listpromotion'] = Core_Promotion::getProductPromotionListFrontEnd();
            
            $templatepage = 'promotions.tpl';
            
            $this->registry->smarty->assign( $arrayAssignTemplate );
            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.$templatepage); 
                        
            $this->registry->smarty->assign(
                array('contents' => $contents,
                )
            );
                
            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
			//save to cache
			//$myCache->save($pageHtml);
		}
		
		echo $pageHtml;
		 
	}
    
    private function getBanner($fazid = 3, $ftype = Core_Ads::TYPE_BANNER)
    {
        $formData['fazid'] = $fazid; //Dienmay Homepage
        $formData['ftype'] = $ftype;
        return Core_Ads::getAdss($formData, '', 'DESC', 6);
    }
}
