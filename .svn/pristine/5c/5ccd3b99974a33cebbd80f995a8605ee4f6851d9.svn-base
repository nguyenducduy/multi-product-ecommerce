<?php
ini_set('memory_limit','500M');
Class Controller_Site_ReverseAuctions Extends Controller_Site_Base 
{
	public $recordPerPage = 20;
	public function indexAction()
	{

		//Product cacher
		$keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();
		if(isset($_GET['live']))
		{
			$listProducts = '';
		}
		//echodebug(json_decode($listProducts));
		//Neu khong co cache thi cache lai
		if (empty($listProducts) || $listProducts == 'null')
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'ASC', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$product->image = unserialize($product->image);
					$listProducts[$product->id] = (array) $product;
				}				
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
		}
	
		$runningproduct = array();
		foreach ($listProducts as $product)
		{
			if ($product['startdate'] <= time() && $product['enddate'] >= time() && $product['status'] == Core_ReverseAuctions::STATUS_BUYING)
			{
				$runningproduct = $product;
				// set running cache vao` cache de hien thi tiep neu chua co san pham thoa dieu kien tren
				$runningproductoldCaher = new Cacher('runningproductold', Cacher::STORAGE_REDIS);
				//$runningproductold = $runningproductoldCaher->get();
				$runningproductoldCaher->set(json_encode($product),86400 * 30);
				break;
			}
			else
			{
				$runningproductoldCaher = new Cacher('runningproductold', Cacher::STORAGE_REDIS);
				$runningproductold = $runningproductoldCaher->get();
				if(!empty($runningproductold))
				{
					$runningproduct = json_decode($runningproductold,true);
				}
			}
		}
		//Tao cacher user by productid
		$keycacheuser = 'userdaugianguoc_'.$runningproduct['id'];
		$userCacher = new Cacher($keycacheuser, Cacher::STORAGE_MEMCACHED);
		$listUser = $userCacher->get();
		if(empty($listUser) || $listUser == 'null')
		{
			$listUser = array();
			$listUserFromDb = Core_ReverseAuctionsUser::getReverseAuctionsUsers(array('fraid'=>$runningproduct['id']),'datecreated','DESC');
			if (!empty($listUserFromDb))
			{
				foreach ($listUserFromDb as $user)
				{
					$listUser[$user->id] = (array) $user;
				}		
			}
			$userCacher->set(json_encode($listUser));
		}
		else
		{
			$listUser = json_decode($listUser, true);
		}
		// Lay danh sach nguoi choi
		$listUserLimit = array_slice($listUser,0,9);
		$userwinnercurrent = array();
		foreach ($listProducts as $productid => $getuserwinner) {
			# code...
			$priceCacher = new Cacher('daugianguoc_listgia_'.$productid, Cacher::STORAGE_REDIS);
			$priceofcache = $priceCacher->get();
			if(!empty($priceofcache))
			{
				$priceofcache = json_decode($priceofcache,true);
				ksort($priceofcache);
				$pricewinner = 0;
				foreach ($priceofcache as $price => $listPriceUser) {
					if(count($listPriceUser) == 1)
					{
						$userwinnercurrent[$productid] = $listPriceUser[0];
						$userwinnercurrent[$productid]['price'] = $price;
						break;
					}
				}
			}
			//$userwinnerold[$productid] = $this->countUserOldProduct($productid);
		}
		$runningtime = 0;
		if (!empty($runningproduct) && !empty($runningproduct['startdate']))
		{
			$runningtime = ($runningproduct['enddate'] - time());
		}
		$this->registry->smarty->assign(array(
			'runningproduct' => $runningproduct,
			'listProduct' => $listProducts,
			'listUserLimit'  => $listUserLimit,
			'listUser' => $listUser,
			'userwinnercurrent' => $userwinnercurrent,
			'currentTime'   => time(),
			'runningtime'   => $runningtime,
			'userwinnerold' => $userwinnerold,
		));
		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'reverseauctions.tpl');
        $this->registry->smarty->assign(array('contents' => $contents,
            'pageTitle' => 'Đấu giá ngược'
        ));

        $this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}
	public function adduserAction()
	{	
		$id = $this->registry->router->getArg('pid');
		////////GET CACHE ////////////////////////////
		$keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();
		//Neu khong co cache thi cache lai
		if (empty($listProducts))
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'ASC', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$listProducts[$product->id] = (array) $product;
				}				
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
		}
		////////GET CACHE ////////////////////////////
		if (!empty($listProducts[$id]))
		{
			$reverseauctions = $listProducts[$id];
			if($reverseauctions['id'] > 0)
			{
				if($reverseauctions['startdate'] <= time() && $reverseauctions['enddate'] >= time() && $reverseauctions['status'] == Core_ReverseAuctions::STATUS_BUYING)
				{
					// adduser
					$isshow = 1;
					if(!empty($_POST['fsubmit']))
					{
						$formData = array();
			            if($_SESSION['reverseauctionsAddToken'] == $_POST['ftoken'])
			            {
			                $formData = array_merge($formData, $_POST);  
			                $formData['fprice'] = Helper::refineMoneyString($formData['fprice']);
			                $formData['fpriceinit'] =  $reverseauctions['price'];   
			                if($this->addActionValidator($formData, $error))
			                {
			                	$user = Core_ReverseAuctionsUser::getReverseAuctionsUsers(array('fphone'=>$formData['fphone'],'fraid'=>$reverseauctions['id'],'fisdate'=>1),'','');
			                	if(count($user) < 11)
			                	{
		                			$myReverseAuctionsUser = new Core_ReverseAuctionsUser();
		                			$myReverseAuctionsUser->raid = $reverseauctions['id'];
									$myReverseAuctionsUser->fullname = strip_tags($formData['ffullname']);
									$myReverseAuctionsUser->email = $formData['femail'];
									$myReverseAuctionsUser->price = $formData['fprice'];
									$myReverseAuctionsUser->phone = $formData['fphone'];
				                    if($myReverseAuctionsUser->addData())
				                    {
				                    	$bidprice = $myReverseAuctionsUser->price;
				                    	//get usercacher
				                    	$keycacheuser = 'userdaugianguoc_'.$reverseauctions['id'];
										$userCacher = new Cacher($keycacheuser, Cacher::STORAGE_MEMCACHED);
										$listUser = $userCacher->get();
										if(empty($listUser) || $listUser == 'null')
										{
											$listUser = array();
											$listUserFromDb = Core_ReverseAuctionsUser::getReverseAuctionsUsers(array('fraid'=>$runningproduct['id']),'datecreated','DESC');
											if (!empty($listUserFromDb))
											{
												foreach ($listUserFromDb as $user)
												{
													$listUser[$user->id] = (array) $user;
												}		
											}
											$userCacher->set(json_encode($listUser));
										}
										else
										{
											$listUser = json_decode($listUser, true);
										}
										$newUser = new Core_ReverseAuctionsUser($myReverseAuctionsUser->id);

										array_unshift($listUser,get_object_vars($newUser));
										$userCacher->set(json_encode($listUser));

										// Cache Redis lay user chien thang
										$priceCacher = new Cacher('daugianguoc_listgia_'.$reverseauctions['id'], Cacher::STORAGE_REDIS);
										$priceofcache = $priceCacher->get();
										if (!empty($priceofcache))
										{
											$priceofcache = json_decode($priceofcache, true);
											if (!empty($priceofcache[$bidprice]))
											{
												$priceofcache[$bidprice][] = array('userid'=>$myReverseAuctionsUser->id,'username'=>$myReverseAuctionsUser->fullname);
											}
											else $priceofcache[$bidprice][] = array('userid'=>$myReverseAuctionsUser->id,'username'=>$myReverseAuctionsUser->fullname);											
										}
										else
										{
											$priceofcache = array();
											$priceofcache[$bidprice][] = array('userid'=>$myReverseAuctionsUser->id,'username'=>$myReverseAuctionsUser->fullname);;											
										}
										//luu cache lai
										$priceCacher->set((string)json_encode($priceofcache), 86400 * 30);//luu 30 ngay
										unset($priceCacher);
										//dang ky subscriber cho user
										if (isset($_POST['fissubscribe']) && $_POST['fissubscribe'] == 1)
										{
											$mySubscriber = new Core_Subscriber();
											$mysub        = $mySubscriber->getSubscribers(array('femail' => $myReverseAuctionsUser->email), '', '');
											if ($mysub[0]->id == 0) {
												$myuser              = new Core_User();
												$user                = $myuser->getUsers(array('femail' => $myReverseAuctionsUser->email));
												$mySubscriber->uid   = $user[0]->id;
												$mySubscriber->email = $myReverseAuctionsUser->email;
												$mySubscriber->fullname = $myReverseAuctionsUser->fullname;
												$mySubscriber->phone = $myReverseAuctionsUser->phone;
												$mySubscriber->addData();
											}
										}
										unset($listUser);
										$isshow = 0;
				                    	//end get cacher
				                        $success[] = '<strong>Cám ơn bạn đã tham gia đấu giá</strong><span>Chúng tôi sẽ liên hệ với bạn nếu bạn là người thắng cuộc.</span><span>Mọi chi tiết xin liên hệ <b style="color: red;font-size: 20px; ">1900 1883</b></span>';
				                        $formData = array();      
				                    }
				                    else
				                    {
				                        $error[] = 'Có lỗi xảy ra vui lòng thử lại';            
				                    }
			                	}
			                	else
			                	{
			                		$error[] = 'Xin lỗi. Bạn đã vượt quá giới hạn đấu giá của sản phẩm này.';
			                	}
			                }
			            }
		        	}
		    		$_SESSION['reverseauctionsAddToken']=Helper::getSecurityToken();//Tao token moi
					$this->registry->smarty->assign(array(
						'reverseauctions' => $reverseauctions,
						'error' 	=> $error,
						'success'   => $success,
						'isshow'    => $isshow,
					));
					$this->registry->smarty->display($this->registry->smartyControllerContainer . 'adduser.tpl');
					exit();					
				}
			}
		}
			?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'reverseauctions';?>";</script><?php
		//header('Location: '.$this->registry->conf['rooturl'].'reverseauctions');
		
	}
	public function listuserAction()
	{
		$recordPerPage = 10;
		$id = $this->registry->router->getArg('pid');
		$product = new Core_ReverseAuctions($id);
		if($product->id > 0)
		{
			$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;
			$fullnameFilter = (string)($this->registry->router->getArg('fullname'));
			$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/listuser/pid/'.$product->id.'/';
			if($fullnameFilter != "")
			{
				$paginateUrl .= 'fullname/'.$fullnameFilter . '/';
				$formData['ffullnamelike'] = $fullnameFilter;
				$formData['search'] = 'ffullnamelike';
			}

			$formData['fraid'] = $product->id;
			$total = Core_ReverseAuctionsUser::getReverseAuctionsUsers($formData, 'price', 'ASC', 0, true);    
			$totalPage = ceil($total/$recordPerPage);
			$curPage = $page;

			$userList = Core_ReverseAuctionsUser::getReverseAuctionsUsers($formData,'price','ASC',(($page - 1)*$recordPerPage).','.$recordPerPage);
			$this->registry->smarty->assign(
				array(
					'userList' => $userList,
					'total'    => $total,
					'totalPage' => $totalPage,
					'curPage'    => $curPage,
					'paginateUrl' => $paginateUrl,
					'productid'   => $product->id,
				)
			);
			$this->registry->smarty->display($this->registry->smartyControllerContainer . 'listuser.tpl');
		}
		else
		{
			?><script>parent.location.href="<?php echo $this->registry->conf['rooturl'].'reverseauctions';?>";</script><?php
		}
	}

	public function theleAction()
	{
		$this->registry->smarty->display($this->registry->smartyControllerContainer . 'thele.tpl');
	}

	public function gettimeauctionAction()
    {
        $formData = array();
        $formData['fid'] = $_POST['fpid'];
        $keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();
		if (empty($listProducts))
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'ASC', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$listProducts[$product->id] = (array) $product;
					$listProducts[$product->id]['image'] = unserialize($listProducts[$product->id]['image']);
				}				
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
		}
		$runproduct = $listProducts[$formData['fid']];
		if($runproduct['startdate'] <= time() && $runproduct['enddate'] >= time())
		{
        	echo date('Y-m-d H:i:s',$runproduct['enddate']);
    	}
    	else
    	{
    		echo 0;
    	}
        
    }

    public function updatecacherAction()
    {
    	//$formData = array();
        $keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();

		//Neu khong co cache thi cache lai
		if (empty($listProducts))
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'ASC', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$listProducts[$product->id] = (array) $product;
					$listProducts[$product->id]['image'] = unserialize($listProducts[$product->id]['image']);
				}				
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
		}
		//Update lai trang thai dang dau gia trong database
		$id = $_POST['fpid'];
        $reversedisable =  new Core_ReverseAuctions($id);
        if($reversedisable->id > 0)
        {
        	if (time() >= $reversedisable->enddate  && $reversedisable->status == Core_ReverseAuctions::STATUS_BUYING)
	        {
	        	$reversedisable->status = Core_ReverseAuctions::STATUS_DISABLED;
        		$reversedisable->updateStatus();	
				$listProducts[$id]['status'] = Core_ReverseAuctions::STATUS_DISABLED;
				$myCacher->set(json_encode($listProducts));
				echo '1';
	        }
	        else
	        {
	        	echo '0';
	        }
        }
        else
        {
        	echo '0';
        }
        //end update lai trang thai da dau gia trong database
		
    }
    public function updatestatubuyingAction()
    {
    	//$formData = array();
    	if (empty($_POST['fpid']))
    	{
    		echo '2';
    		return;
    	}
    	$returnvalue = 0;

        $keycache = 'daugianguoc';
		$myCacher = new Cacher($keycache, Cacher::STORAGE_MEMCACHED);
		$listProducts = $myCacher->get();

		//Neu khong co cache thi cache lai
		if (empty($listProducts))
		{
			//truy van database
			$listProducts = array();
			$listproductfromdb = Core_ReverseAuctions::getReverseAuctionss(array(), 'startdate', 'ASC', '');
			if (!empty($listproductfromdb))
			{
				foreach ($listproductfromdb as $product)
				{
					$listProducts[$product->id] = (array) $product;
					$listProducts[$product->id]['image'] = unserialize($listProducts[$product->id]['image']);
				}				
			}
			$myCacher->set(json_encode($listProducts));
		}
		else
		{
			$listProducts = json_decode($listProducts, true);
		}
		$statusbuying = 0;

		foreach ($listProducts as $kpid=>$product)
		{
			if($product['id'] == $_POST['fpid'] && $product['status']==Core_ReverseAuctions::STATUS_BUYING)
			{
				$statusbuying = 1; break;
			}
		}
		if($statusbuying < 1)
		{
			foreach ($listProducts as $product)
			{	
				if ($product['startdate'] <= time() && $product['enddate'] >= time() && $product['status'] != Core_ReverseAuctions::STATUS_DISABLED){
					
					$listProducts[$product['id']]['status'] =  Core_ReverseAuctions::STATUS_BUYING;
					//Update lai trang thai trong database
					$pid = $product['id'];
			        $reverseauctions =  new Core_ReverseAuctions($pid);
			        if($reverseauctions->id > 0)
			        {
			        	$reverseauctions->status = Core_ReverseAuctions::STATUS_BUYING;
			        	$reverseauctions->updateStatus();
			        	$returnvalue = 1;
			        }
					break;
				
				}
			}
			$myCacher->set(json_encode($listProducts));
		}
		echo $returnvalue;
		//echodebug($listProducts);
    }

    private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ffullname'] == '')
		{
			$error[] = 'Vui lòng nhập Họ tên';
			$pass = false;
		}

		if($formData['fprice'] == '' || $formData['fprice'] < 1000 || $formData['fprice']%1000 != 0 || $formData['fprice'] > $formData['fpriceinit'])
		{
			$error[] = 'Giá đấu phải là bội số 1.000, lớn hơn 0đ, và nhỏ hơn giá khởi điểm';
			$pass = false;
		}

		if($formData['fphone'] == '')
		{
			$error[] = 'Vui lòng nhập số điện thoại';
			$pass = false;
		}
		else
		{
			if( strlen($formData['fphone']) < 8 || strlen($formData['fphone']) > 11 || !(int)$formData['fphone'])
           {
            	$error[] =  'Số điện thoại không hợp lệ';
            	$pass = false;
           }
		}

		if($formData['femail'] == '')
		{
			$error[] = 'Vui lòng nhập Email';
			$pass = false;
		}
		else
		{
			if (!Helper::ValidatedEmail($formData['femail'])) {
				$error[] = 'Sai định dạng email';
				$pass    = false;
			}
		}

		if($formData['fprice'] <= 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceMustGreaterThanZero'];
			$pass = false;
		}		
		return $pass;
	}
	public function countUserOldProduct($pid)
	{
		//Tao cacher user by productid
		$keycacheuser = 'userdaugianguoc_'.$pid;
		$userCacher = new Cacher($keycacheuser, Cacher::STORAGE_MEMCACHED);
		$listUser = $userCacher->get();
		if(empty($listUser) || $listUser == 'null')
		{
			$listUser = array();
			$listUserFromDb = Core_ReverseAuctionsUser::getReverseAuctionsUsers(array('fraid'=>$pid),'datecreated','DESC');
			if (!empty($listUserFromDb))
			{
				foreach ($listUserFromDb as $user)
				{
					$listUser[$user->id] = (array) $user;
				}		
			}
			$userCacher->set(json_encode($listUser));
		}
		else
		{
			$listUser = json_decode($listUser, true);
		}
		$usersCount = count($listUser);
		if($usersCount > 0)
		{
			return $usersCount;
		}
		else
		{
			return 0;
		}
	}
}

function sortuserbypriceasc($p1, $p2)
{
    if ($p1['price'] > $p2['price']) return 1;
    elseif($p1['price'] < $p2['price']) return -1;
    else return 0;
}