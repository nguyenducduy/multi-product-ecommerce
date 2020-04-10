<?php

Class Controller_Admin_ProductStock Extends Controller_Admin_Base
{
	public $recordPerPage = 20;

	public function indexAction()
	{

		$formData = array();
		$error = array();
        $success = array();

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) == 'ASC') $sorttype = 'ASC';
		else $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


        $result = (int)$this->registry->router->getArg('rs');


        switch ($result) {
            case Core_ProductStock::ERRORPRODUCTEXIST :
                $error[] = $this->registry->lang['controller']['errExist'];
                break;
            case Core_ProductStock::WARININGNOTCHANGE:
                $warning[] = $this->registry->lang['controller']['warnNotChange'];
                break;
            case Core_ProductStock::SYNCSUCCESS :
                $success[] = $this->registry->lang['controller']['succSync'];
                break;
            case Core_ProductStock::SYNCERROR :
                $error[] = $this->registry->lang['controller']['errSync'];
                break;
        }

		$pbarcode = $this->registry->router->getArg('pbarcode');
		$myProduct = Core_Product::getIdByBarcode($pbarcode);
		$pbarcodedestination = $this->registry->router->getArg('pbarcodedestination');
		if(strlen($pbarcodedestination) > 0)
		{
			$myProductDes = Core_Product::getProductIDByBarcode($pbarcodedestination);
			$relproductcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$myProductDes['p_id'] , 'fpiddestination' => $myProduct->id), 'id', 'ASC');						
			$mycolor = new Core_Productcolor($relproductcolors[0]->typevalue);
		}


		if($myProduct->id >0)
		{
			$productStockListHtml = Core_ProductStock::getProductStocks(array('fpbarcode' => $pbarcode), $sortby , $sorttype, '',false,true);

            if(count($productStockListHtml) == 0)
            {
                $error[] = $this->registry->lang['controller']['errExist'];
            }
            else
            {
            		$obj = end($productStockListHtml);
					$datesync = $obj->datemodified;
					foreach($productStockListHtml as $productstock)
					{
						$productstock->storeActor = new Core_Store($productstock->sid);
					}
            }

            //lay thong tin ve gia cua cac san pham mau
			$productcolorlist = array();
			$productcolors = Core_RelProductProduct::getRelProductProducts(array('ftype' => Core_RelProductProduct::TYPE_COLOR, 'fpidsource'=>$myProduct->id), 'id', 'ASC');						
			foreach ($productcolors as $productcolor) 
			{
				$myproductcolor = new Core_Product($productcolor->piddestination);
				$productcolorlist[$myproductcolor->id]['barcode'] = $myproductcolor->barcode;
				$productcolorlist[$myproductcolor->id]['instock'] = $myproductcolor->instock;
				$color = new Core_Productcolor($productcolor->typevalue);				
				$productcolorlist[$myproductcolor->id]['color'] = $color->name;

				unset($myproductcolor);
			}			
		}
		else
		{
			$error[] = $this->registry->lang['controller']['errBarcodeExit'];
		}	
		$head_list = '';
		if(strlen($myProduct->name) > 0)
		{
			$head_list = str_replace('###PRODUCT_NAME###', $myProduct->name, $this->registry->lang['controller']['head_list']);
		}
		else
		{
			$head_list = str_replace('###PRODUCT_NAME###', $myProductDes['p_name'] . ' - ' . $mycolor->name, $this->registry->lang['controller']['head_list']);	
		}
	

		$this->registry->smarty->assign(array(	'productStockListHtml' => $productStockListHtml,
													'myProduct' => $myProduct,
													'head_list' => $head_list,
													'formData' => $formData,
													'error' => $error,
                                                    'success' => $success,
													'datesync' => $datesync,
													'productcolorlist' => $productcolorlist,
													'pbarcodedestination' => $pbarcodedestination,
													));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
													'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'index.tpl');
	}

    public function syncstockAction()
    {
        $barcode = (string)$_POST['barcode'];

        $total = Core_ProductStock::getProductStocks(array('fpbarcode' => $barcode) , 'id' , 'ASC' , '' ,true);
        if($total == 0)
        {
            $result =  Core_ProductPrice::ERRORPRODUCTEXIST;
        }

        $result = Core_ProductStock::syncProductStock($barcode);        

        echo $result;

    }
}

