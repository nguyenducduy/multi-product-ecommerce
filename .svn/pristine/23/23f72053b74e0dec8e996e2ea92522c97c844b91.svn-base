<?php 
	Class Controller_Cms_DiscountProduct Extends Controller_Cms_Base{
	    public $recordPerPage = 20;
	    public function  indexAction()
	    {
	    	$error 			= array();
	        $success 		= array();
	        $warning 		= array();
	        $formData 		= array('fbulkid' => array());
	        $_SESSION['securityToken']=Helper::getSecurityToken();//Token
          	$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
	        $sortby 	= $this->registry->router->getArg('sortby');
	        if($sortby == '') $sortby = 'displayorder';
	        	$formData['sortby'] = $sortby;
	        $sorttype 	= $this->registry->router->getArg('sorttype');
	        if(strtoupper($sorttype) != 'DESC') $sorttype = 'ASC';
	        	$formData['sorttype'] = $sorttype;
	        $total = Core_DiscountProduct::getDiscountProducts($formData, $sortby, $sorttype, 0, true);
        	$totalPage = ceil($total/$this->recordPerPage);
        	$curPage = $page;
        	// Tien hanh xu~ ly delete
	        if(!empty($_POST['fsubmitbulk']))
	        {
	            if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
	            {

	                if(!isset($_POST['fbulkid']))
	                {
	                    $warning[] = $this->registry->lang['default']['bulkItemNoSelected'];

	                }
	                else
	                {
	                    $formData['fbulkid'] = $_POST['fbulkid'];

	                    //check for delete
	                    if($_POST['fbulkaction'] == 'delete')
	                    {
	                        $delArr = $_POST['fbulkid'];
	                        $deletedItems = array();
	                        $cannotDeletedItems = array();
	                        foreach($delArr as $id)
	                        {
	                            //check valid user and not admin user
	                            $myDiscountProduct = new Core_DiscountProduct($id);

	                            if($myDiscountProduct->id > 0)
	                            {
	                                //tien hanh xoa
	                                if($myDiscountProduct->delete())
	                                {
	                                    $deletedItems[] = $myDiscountProduct->id;
	                                    $this->registry->me->writelog('DiscountProduct_delete', $myDiscountProduct->id, array());
	                                }
	                                else
	                                    $cannotDeletedItems[] = $myDiscountProduct->id;
	                            }
	                            else
	                                $cannotDeletedItems[] = $myDiscountProduct->id;
	                        }

	                        if(count($deletedItems) > 0)
	                            $success[] = str_replace('###id###', implode(', ', $deletedItems), $this->registry->lang['controller']['succDelete']);

	                        if(count($cannotDeletedItems) > 0)
	                            $error[] = str_replace('###id###', implode(', ', $cannotDeletedItems), $this->registry->lang['controller']['errDelete']);
	                    }
	                    else
	                    {
	                        //bulk action not select, show error
	                        $warning[] = $this->registry->lang['default']['bulkActionInvalidWarn'];
	                    }
	                }
	            }
	        }
          	if(!empty($_POST['fsubmitchangeorder']))
        	{
            	if($_SESSION['discountproductBulkToken']==$_POST['ftoken'])
	            {
	                $displayorderList = $_POST['fdisplayorder'];
	                foreach($displayorderList as $id => $neworder)
	                {
	                    $myItem = new Core_DiscountProduct($id);
	                    if($myItem->id > 0 && $myItem->displayorder != $neworder)
	                    {
	                        $myItem->displayorder = $neworder;
	                        $myItem->updateData();
	                    }
	                }
	                $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
	            }
            }
	        $_SESSION['discountproductBulkToken'] = Helper::getSecurityToken();
        	// End tien hanh xu~ ly dele
	        $paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';

        	$discountProduct = Core_DiscountProduct::getDiscountProducts($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

        	$filterUrl = $paginateUrl;
        	//append sort to paginate url
	        $paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';

	        //build redirect string
	        $redirectUrl = $paginateUrl;
	        if($curPage > 1)
	        {
	            $redirectUrl .= 'page/' . $curPage;
	            $filterUrl .= 'page/' . $curPage."/";
	         }


	        $redirectUrl = base64_encode($redirectUrl);


	    	$this->registry->smarty->assign(array(	           
	    		'discountProduct' 	=> $discountProduct,
	            'formData'		=> $formData,
	            'success'		=> $success,
	            'error'			=> $error,
	            'warning'		=> $warning,
	            'redirectUrl'		=> $redirectUrl,
	            'paginateurl' 	=> $paginateUrl,
	            'redirectUrl'	=> $redirectUrl,
	            'filterUrl'		=> $filterUrl,
	            'total'			=> $total,
	            'totalPage' 	=> $totalPage,
	            'curPage'		=> $curPage,
												
			));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	    }
		public function indexlistAction()
		{
			$error 	= array();
			$success 	= array();
	        $warning    = array();
			$formData = array();
			$result = "";
			$id = $this->registry->router->getArg('id');
			if($id > 0)
	    	{
	    		$result = $this->getDiscountProductsByid($id);
	    	}
	    	
			if(!empty($_POST['fsubmit']))
			{
	            if($_SESSION['discountUpdateToken'] == $_POST['ftoken'])
	            {
            		$myDiscountProduct = new Core_DiscountProduct($id);
		            if($myDiscountProduct->id >0)
		            {
		                if(!empty($_POST['listpids']))
		                {
		                	$productid = $_POST['listpids'];
		                	$productid_new = array();
	                		$displayorder =  $_POST['displayorder'];
	                		$count =  count($_POST['listpids']);
              				foreach ($productid as $key =>$value) {
              					$productid_new[$value] = $displayorder[$key];
              				} 
              				asort($productid_new);
              				$proid = array();
              				foreach ($productid_new as $key => $pid){
              					$proid[] = $key;
              				}
              				$myDiscountProduct->listproduct = implode(',',$proid);
              			}		                
		                else
		                { 
		                	$myDiscountProduct->listproduct = '';
		                }
		                if($myDiscountProduct->updateData())
		                {
		                	$success[] = "Cập nhật thành công";
		                	$result = $this->getDiscountProductsByid($id);
		                }
		            }
		        	
	            }
	        }
        	$_SESSION['discountUpdateToken']=Helper::getSecurityToken();//Tao token moi

			$discount = Core_DiscountProduct::getDiscountProducts(array(''),'displayorder','ASC');

			$this->registry->smarty->assign(array(	'formData' 		=> $formData,
													'discount'			=> $discount,
													'result'=>$result,
													'success' =>$success
												));

			$this->registry->smarty->display($this->registry->smartyControllerContainer.'indexlist.tpl');

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
	                        <th>Loai giam gia</th>
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
	                        $result .= '<a href="'.$product->getSmallImage().'" rel="shadowbox"><image id="images_'.$product->id.'" src="'.$product->getSmallImage().'" width="50" height="50" /></a>';
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
	    public function addAction()
	    {
	    	$error 	= array();
			$success 	= array();
	        $warning    = array();
			$contents 	= '';
			$formData 	= array();
			if(!empty($_POST['fsubmit']))
			{
	            if($_SESSION['discountAddToken'] == $_POST['ftoken'])
	            {
	            	$formData = array_merge($formData,$_POST);
	            	if($formData['fdiscountname'] != ""){
            			$discountproduct = new Core_DiscountProduct();
            			$discountproduct->discountname = $formData['fdiscountname'];
            			$discountproduct->displayorder = $formData['fdisplayorder'];
            			$discountproduct->type = $formData['ftype'];
    					$discountproduct->amount = str_replace(",","",$formData['famount']);
            			$discountproduct->datecreated = time();
            			$discountproduct->status = $formData['fstatus'];
            			$discountproduct->discountcombo = $formData['fdiscountcombo'];
            			if($discountproduct->addData())
            			{
            				$success[] = "Thêm thành công";
            			}
            			else{
            				$error[] = "Thêm không thành công";
            			}
	            	}
	            	else{
	            		$error[] = "Vui lòng nhập tên loại giảm giá";
	            	}
	            }
	        }
        	$_SESSION['discountAddToken']=Helper::getSecurityToken();//Tao token moi
        	$this->registry->smarty->assign(array(	'formData' 		=> $formData,
													'error'			=> $error,
	                                                'success'        => $success,
	                                                'warning' =>$warning
												));
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');

			$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	    }	
	    public function ajaxgetproductsbydiscountidAction()
	    {
	    	
				$result = '';

		        $pname = (string)$_POST['pname'];
		        if($pname != '')
		        {
		            $productList = Core_Product::getProducts(array('fgeneralkeyword'=>$pname , 'fonsitestatus' => Core_Product::OS_ERP) , 'id' , 'ASC');
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
	    public function getDiscountProductsByid($id){
	    	$discountproduct = new Core_DiscountProduct($id);
    		if($discountproduct->id > 0 && $discountproduct->listproduct != '')
    		{
    			$discountp= explode(",",$discountproduct->listproduct);
    			foreach ($discountp as $key => $value) {
    				$discountproducts[] = Core_Product::getProducts(array('fid' => $value, 'fonsitestatus' => Core_Product::OS_ERP),'id','');
    			}

	            if(!empty($discountproducts))
	            {
	                $result = '';
	                $i = 0;
	                foreach($discountproducts as $product)
	                {
	                    $product[0]->categoryactor = new Core_Productcategory($product[0]->pcid);
	                    $result .= '<tr id="row'.'_'.$product[0]->id.'">';
	                    $result .= '<td><input type="text" class="displayorder" value="'.$i.'" name="displayorder[]" class="input-mini" style="width:50px;height:30px"/></td>' ;
	                    $result .= '<td>';
	                    if($product[0]->image != '')
	                    {
	                        $result .= '<a href="'.$product[0]->getSmallImage().'" rel="shadowbox"><image id="images_'.$product[0]->id.'" src="'.$product[0]->getSmallImage().'" width="50" height="50" /></a>';
	                    }
	                    $result .= '</td>';
	                    $result .= '<td id="pid">'.$product[0]->id.'</td>';
	                    $result .= '<td id="barcode">'.$product[0]->barcode.'</td>';
	                    $result .= '<td><span class="label label-info">'.$product[0]->categoryactor->name.'</span></td>';
	                    $result .= '<td id="names_'.$product[0]->id.'"><input type="hidden" name="listpids[]" value="'.$product[0]->id.'" id="_'.$product[0]->id.'" />'.$product[0]->name.'</td>';
	                    $result .= '<td>'.$product[0]->instock.'</td>';
	                    $result .= '<td>'.Helper::formatPrice($product[0]->sellprice) . ' đ' . '</td>';

	                    $result .= '<td><input type="button" class="btn btn-danger" id="fclear_'.$product[0]->id.'" onclick="clearFunction('.$product[0]->id.')" value="Remove" /></td>';
	                    $result .= '</tr>';
	                    $i++;
	                }
	            }
	        }
	        return $result;
	    }
	    public function editAction()
	    {
	    	$id = $this->registry->router->getArg('id');
	    	$discountproduct = new Core_DiscountProduct($id);
	    	if($discountproduct->id > 0)
	    	{
	    		$formData = array();
	    		$formData['fdisplayorder'] = $discountproduct->displayorder;
	    		$formData['fdiscountname'] = $discountproduct->discountname;
	    		$formData['ftype'] = $discountproduct->type;
	    		$formData['famount'] = $discountproduct->amount;
	    		$formData['fstatus'] = $discountproduct->status;
	    		$formData['fdiscountcombo'] = $discountproduct->discountcombo;
	    		if(isset($_POST['fsubmit']))
	    		{
	    			if($_SESSION['editDiscountToken'] == $_POST['ftoken'])
	    			{

	    				$formData = array();
	    				$formData = array_merge($formData,$_POST);
	    				if($formData['fdiscountname'] != "")
	    				{
		    				$mydiscount = new Core_DiscountProduct();
		    				$mydiscount->id = $discountproduct->id;
		    				$mydiscount->discountname = $formData['fdiscountname'];
		    				$mydiscount->type = $formData['ftype'];
		    				$mydiscount->displayorder = $formData['fdisplayorder'];
		    				$mydiscount->amount = str_replace(",","",$formData['famount']);
		    				$mydiscount->datemodified = time();
		    				$mydiscount->status = $formData['fstatus'];
		    				$mydiscount->discountcombo = $formData['fdiscountcombo'];
		    				$mydiscount->listproduct = $discountproduct->listproduct;
		    				if($mydiscount->updateData())
		    				{
		    					$success[] = "Cập nhật thành công";
		    				}
		    				else{
		    					$error[] = "Cập nhật không thành công";
		    				}
	    				}
	    				else{
	    					$error[] = "Vui lòng nhập tên loại giảm giá";
	    				}
	    			}
	    		}
	    		
	    		//echo $_SESSION['editDiscountToken'];	
			}
			$_SESSION['editDiscountToken'] = Helper::getSecurityToken();
			$this->registry->smarty->assign(array("formData"=>$formData,
													"success"=>$success,
													"error" => $error
													));
			//Add template
			$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer."edit.tpl");
			$this->registry->smarty->assign(array(
												"pageTitle"=>"Edit Discount Product",
												"contents" => $contents,
												));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer."index.tpl");
	    }

	    public function deleteAction()
	    {
			$id = $this->registry->router->getArg('id');
	    	$discountproduct = new Core_DiscountProduct($id);
    		if($discountproduct->id > 0)
	    	{
	            //tien hanh xoa
	            if($discountproduct->delete())
	            {
	                $redirectMsg = str_replace('###id###', $discountproduct->id, $this->registry->lang['controller']['succDelete']);

	                $this->registry->me->writelog('discountproduct_delete', $discountproduct->id, array());
	            }
	            else
	            {
	                $redirectMsg = str_replace('###id###', $discountproduct->id, $this->registry->lang['controller']['errDelete']);
	            }
		        
	    	} 
	    	else
	        {
		            $redirectMsg = $this->registry->lang['controller']['errNotFound'];
	        }
	        $this->registry->smarty->assign(array('redirect' => $this->getRedirectUrl(),
		            'redirectMsg' => $redirectMsg,
	        ));
	        $this->registry->smarty->display('redirect.tpl');

	    }

	    
	} 