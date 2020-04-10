<?php

Class Controller_Cms_CheapProduct Extends Controller_Cms_Base 
{
	private $recordPerPage = 20;
	
	function indexAction() 
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
        $mycheapproduct = new Core_CheapProduct(1);
        $cheapproducts = null;
        if($mycheapproduct->listproduct != '')
        {
            $cheapproducts = Core_Product::getProducts(array('fidarr' => explode(',',$mycheapproduct->listproduct), 'fonsitestatus' => Core_Product::OS_ERP,'fhaspromotion'=>1),'','');
            if(!empty($cheapproducts))
            {
                $result = '';
                foreach($cheapproducts as $product)
                {
                    $product->categoryactor = new Core_Productcategory($product->pcid);
                    $result .= '<tr id="row'.'_'.$product->id.'">';
                    $result .= '<td>';
                    if($product->image != '')
                    {
                        $result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100" height="100" /></a>';
                    }
                    $result .= '</td>';
                    $result .= '<td id="pid">'.$product->id.'</td>';
                    $result .= '<td id="barcode">'.$product->barcode.'</td>';
                    $result .= '<td><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
                    $result .= '<td id="names_'.$product->id.'"><input type="hidden" name="listpids[]" value="'.$product->id.'" id="_'.$product->id.'" />'.$product->name.'</td>';
                    $result .= '<td>'.$product->instock.'</td>';
                    $result .= '<td>'.Helper::formatPrice($product->sellprice) . ' đ' . '</td>';

                    $result .= '<td><input type="button" class="btn btn-danger" id="fclear_'.$product->id.'" onclick="clearFunction('.$product->id.')" value="Remove" /></td>';
                    $result .= '</tr>';
                }
                $cheapproducts = $result;
            }
        }
		
        $this->registry->smarty->assign(array(	'cheapproducts' 	=> $cheapproducts,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												));
		
		
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');
		
		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		
	}
    
    public function updateAction() 
    {
        $myCheapProduct = new Core_CheapProduct(1);
            if($myCheapProduct->id >0)
            {
                if(!empty($_POST['listpids'])) $myCheapProduct->listproduct = implode(',',$_POST['listpids']);
                else $myCheapProduct->listproduct = '';
                $myCheapProduct->updateData();
            }
            else {
                $myCheapProduct->id = 1;
                $myCheapProduct->listproduct = implode(',',$_POST['listpids']);
                $myCheapProduct->addData();
            }
        header('location: ' . $this->registry['conf']['rooturl_cms'].'cheapproduct/index');
    }
	
	public function searchProductAjaxAction()
    {
        $result = '';

        $pname = (string)$_POST['pname'];
        if($pname != '')
        {
            $productList = Core_Product::getProducts(array('fgeneralkeyword'=>$pname , 'fonsitestatus' => Core_Product::OS_ERP,'fhaspromotion'=>1) , 'id' , 'ASC');
            if(count($productList) > 0)
            {
                $result .= '<table class="table"><thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Barcode</th>
                        <th>Danh mục</th>
                        <th> Tên sản phẩm</th>
                        <th> Số lượng</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead>';
                foreach($productList as $product)
                {
                    $product->categoryactor = new Core_Productcategory($product->pcid);
                    $result .= '<tr id="rows'.'_'.$product->id.'">';
                    $result .= '<td>';
                    if($product->image != '')
                    {
                        $result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="100" height="100" /></a>';
                    }
                    $result .= '</td>';
                    $result .= '<td id="pid">'.$product->id.'</td>';
                    $result .= '<td id="barcode">'.$product->barcode.'</td>';
                    $result .= '<td id="categorys_'.$product->id.'"><span class="label label-info">'.$product->categoryactor->name.'</span></td>';
                    $result .= '<td id="names_'.$product->id.'">'.$product->name.'</td>';
                    $result .= '<td id="instocks_'.$product->id.'">'.$product->instock.'</td>';
                    $result .= '<td id="prices_'.$product->id.'">'.Helper::formatPrice($product->sellprice) . ' ' . $this->registry->lang['controller']['labelCurrency'] . '</td>';

                    $result .= '<td><input class="btn btn-success" type="button" id="fchoose_'.$product->id.'" onclick="chooseFunction('.$product->id.')" value="Choose" /></td>';
                    $result .= '</tr>';
                }
                $result .= '</table><br/>';
            }
        }
        echo $result;
    }	
}

?>