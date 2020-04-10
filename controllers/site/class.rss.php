<?php

Class Controller_Site_Rss Extends Controller_Site_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{
		header("content-type: text/xml");

		$myNews = Core_News::getNewss(array(), 'id', 'DESC', $this->recordPerPage);
		$lastBuildDate =  $myNews[0]->datecreated;
		$this->registry->smarty->assign(array(	'myNews'	=> $myNews,
												'lastBuildDate'	=> $lastBuildDate));

		$contents = $this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
	}

	public function categoryAction()
	{
		header('content-type: text/xml');

		$id = (int)$_GET['id'];

		$myProductcategory = new Core_Productcategory($id , true);
		if($myProductcategory->id > 0)
		{
			$categorylist = Core_Productcategory::getFullSubCategory($myProductcategory->id);
			$productlist = Core_Product::getProducts( array('fpcidarrin' => $categorylist) , 'displayorder' , 'ASC' , $this->recordPerPage);
            if(count(productlist) > 0)
            {
                foreach ($productlist as $product) 
                {
                    $product->summary = strip_tags($product->summary);
                    $product->dienmayreview = strip_tags($product->dienmayreview);
                    $product->content = strip_tags($product->content);
                }
            }
			$lastBuildDate = $productlist[0]->datemodified;		

			$this->registry->smarty->assign(array(	'productlist'	=> $productlist,
													'category' => $myProductcategory,
													'lastBuildDate'	=> $lastBuildDate));												

			$contents = $this->registry->smarty->display($this->registry->smartyControllerContainer.'category.tpl');	
		}
	}
}