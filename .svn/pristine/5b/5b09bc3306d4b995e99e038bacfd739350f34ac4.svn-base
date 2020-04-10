<?php
/**
 *
 * File contains the class used for class.productyear.php
 *
 * @category dienmay.com
 * @author Nguyen Phan <phannguyen2020@gmail.com>
 * @copyright Copyright (c) 2014 - dienmay.com
 */
Class Controller_Site_Productyear Extends Controller_Site_Base
{
	public function indexAction()
	{
		//var_dump($_SESSION['User']['id']);die;
		$invitor_id = base64_decode($_GET['invitor']);
		if ($invitor_id > 0) {
			$_SESSION['invitor_id'] = $invitor_id;
		}else {
			unset($_SESSION['invitor_id']);	
		}
		
		if (!empty($_SESSION['User'])) {
			$yearUser = array();
			$user_profile = $_SESSION['User'];
			// Check login
			if (!empty($user_profile['email'])) {
				$myUser = Core_ProductyearUser::getProductyearUsers(array('femail'=>$user_profile['email']), '', '');
			} else {
				$myUser = Core_ProductyearUser::getProductyearUsers(array('fusername'=>$user_profile['username']), '', '');
			}
			
			if($myUser[0]->id > 0) {
				if ($myUser[0]->status == Core_ProductyearUser::STATUS_ENABLE) {
					$_SESSION['usergameLogin'] = $myUser[0]->id;
				} else {
					unset($_SESSION['User']);	
				}
				$yearUser = $myUser[0];

			
			} else {
				$user = new Core_ProductyearUser();
				$user->gfeid = Core_ProductyearUser::PROGRAM;
				$user->oauthid = $_SESSION['User']['id'];
				$user->fullname = $user_profile['name'];
				$user->username = $user_profile['username'];
				$user->email = $user_profile['email'];
				$user->oauthpartner = $user_profile['oauthPartner'];
				$user->status = 1;
				$user->addData();
				$yearUser = $user;
				$_SESSION['usergameLogin'] = $user->id;
				
				// update luot chia se cho user invitor
				if ($_SESSION['invitor_id'] > 0) {
				
					$ipaddress = Helper::getIpAddress(true);
					$totalip = Core_ProductyearUser::getProductyearUsers(array('fipaddress' => $ipaddress), '', '','', true);
					if ($totalip <= 20) {
						$invitor_id = $_SESSION['invitor_id'];
						$invitor = new Core_ProductyearUser($invitor_id);
						$invitor->countshare = $invitor->countshare + 1;
						$invitor->countplay = $invitor->countplay + 1;
						if (empty($invitor->shareid)) {
							$invitor->shareid = $user->id;
						} else {
							$invitor->shareid = $invitor->shareid . ',' . $user->id;
						}
						$invitor->updateData();
						unset($_SESSION['invitor_id']);	
					}
				}
			}
			
			// Check va hien thi popup cap nhan phone
			if (empty($yearUser->phone)) {
				
				$error 	= array();
				$formData 	= array();
				
				if(!empty($_POST['fsubmit'])) {
					
		            if($_SESSION['PhoneToken'] == $_POST['ftoken'])
		            {
		               $formData = array_merge($formData, $_POST);
     
		                if($formData['fphone'] != '' && is_numeric($formData['fphone'])) {
		                    $checkphone = Core_ProductyearUser::getProductyearUsers(array('fphone' => $formData['fphone']), '', '');
							
		                    if (empty($checkphone)) {
		                    	
		                    	$yearUser->phone = $formData['fphone'];
		                    	if ($yearUser->updateData()) {
		                    		header('Location: ' . $this->registry->conf['rooturl'].'product-of-the-year');
		                    	}
		                    	
		                    }else {
		                    	$error[] = 'Số điện thoại đã tồn tại.';   
		                    }
		                }else {
		                	 $error[] = 'Bạn chưa nhập số điện thoại hoặc nhập không đúng định dạng.';            
		                }
		            }
				}
				
				$_SESSION['PhoneToken'] = Helper::getSecurityToken();//Tao token moi
				
				$this->registry->smarty->assign(
			            array(
			            	'error'			=> $error,
			            )
			        );
			    $this->registry->smarty->display($this->registry->smartyControllerContainer.'updatephone.tpl');
				exit();
			}
			
			
		
			$user_profile = $_SESSION['User'];
			if (!empty($user_profile)) {
				if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK ) {
					$user_profile['avatar'] = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=small';
				}else {
					$user_profile['avatar'] = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
				}
			}
			
		}
		
		$cache = new Cacher('FRONT_LIST_PRODUCT_YEAR');
		$listproducts = json_decode($cache->get());
		if(isset($_GET['live'])) {
			$listproducts = '';
		}
		if (empty($listproducts)) {
			$productyears = Core_Productyear::getProductyears(array('fstatus'=>Core_Productyear::STATUS_ENABLE), 'id', 'DESC');
			$listproducts = array();
			
			foreach ($productyears as $item) {
				$product = new Core_Product($item->pid);
				$product->countarticle = $item->countarticle;
				$product->image = $product->getImage();
				$product->link = $product->getProductPath();
				if($product->summarynew != "")
	                $product->summarynew = explode("#", $product->summarynew);
				
				$listproducts[] = $product;
			}
			
			$cache->set(json_encode($listproducts, true), 600);
		}

		$this->registry->smarty->assign(
	            array(
	            	'listproducts' => $listproducts,
	            	'user_profile' => $user_profile,
	            )
	        );
	    $this->registry->smarty->display($this->registry->smartyControllerContainer.'index.tpl');
	}
	
	public function showruleAction(){
    	$game = new Core_Gamefasteye(2);
    	echo $game->rule;
    }
	
	
	public function postAction()
	{
		$error 	= array();
		$formData 	= array();
		$product_id = (int)$_GET['id'];
		$product = new Core_Product($product_id);
		if ($product->id > 0) {
			
			if (!empty($_SESSION['User'])) {
			
				$user_profile = $_SESSION['User'];
				if (!empty($user_profile)) {
					if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK ) {
						$user_profile['avatar'] = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=small';
					}else {
						$user_profile['avatar'] = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
					}
				}
			}
					
			if(!empty($_POST['fsubmit']))
			{
	            if($_SESSION['PostToken'] == $_POST['ftoken'])
	            {
	                $formData = array_merge($formData, $_POST);
     
	                $checkexits = Core_ProductyearArticle::getProductyearArticles(array('fpyuid'=> $_SESSION['usergameLogin'], 'fpid' => $product_id), '', '');
	                if (empty($checkexits)) {
	                
		                if($this->addActionValidator($formData, $error))
		                {
		                    $myProductyearArticle = new Core_ProductyearArticle();
		
							
							$myProductyearArticle->pid = $product_id;
							$myProductyearArticle->pyuid = $_SESSION['usergameLogin'];
							$myProductyearArticle->title = strip_tags($formData['ftitle']);
							$myProductyearArticle->content = strip_tags($formData['fcontent']);
							$myProductyearArticle->status = 0;
							$myProductyearArticle->ipaddress = Helper::getIpAddress(true);
							
		                    if($myProductyearArticle->addData())
		                    {
		                    	$productyear = Core_Productyear::getProductyears(array('fpid'=> $product_id), '', '');
		                    	if (!empty($productyear)) {
		                    		$productyear[0]->countarticle = (int)$productyear[0]->countarticle + 1;
		                    		$productyear[0]->updateData();
		                    	}
		                    	
		                        $success[] = 'Đăng bài viết thành công. Chúng tôi sẽ duyệt bài trong thời gian sớm nhất.';
		                        $this->registry->me->writelog('productyeararticle_add', $myProductyearArticle->id, array());
		                        $formData = array();      
		                    }
		                    else
		                    {
		                        $error[] = 'Có lỗi xảy ra trong quá trình đăng bài. Vui lòng thử lại.';            
		                    }
		                }
	                }else {
	                	$error[] = 'Bạn đã viết bài cho sản phẩm này rồi. Vui lòng chọn sản phẩm khác.';    
	                }
	            }
	            
			}
			
			$_SESSION['PostToken'] = Helper::getSecurityToken();//Tao token moi
			
			$this->registry->smarty->assign(
		            array(
		            	'user_profile' => $user_profile,
		            	'error'			=> $error,
						'success'		=> $success,
		            	'product' => $product
		            )
		        );
		    $this->registry->smarty->display($this->registry->smartyControllerContainer.'post.tpl');
		} else {
			header('HTTP/1.0 404 Not Found');
	        echo 'Not found';
	        exit();
		}
	}
	
	public function detailAction() 
	{
		
		if (!empty($_SESSION['User'])) {
			
			$user_profile = $_SESSION['User'];
			if (!empty($user_profile)) {
				if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK ) {
					$user_profile['avatar'] = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=small';
				}else {
					$user_profile['avatar'] = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
				}
			}
		}
		
		$product_id = (int)$_GET['id'];
		$product = new Core_Product($product_id);
		if ($product->id > 0) {
			
			
			//Product gallery
            $productMedias = Core_ProductMedia::getProductMedias(array('fpid'=>$product_id),'displayorder','ASC','');
		 	$gallery = array();
            $gallery360 = array();
            $video = array();
            $specialimage = '';
            if(!empty($productMedias)) {
                foreach($productMedias as $media) {
                    if($media->type == Core_ProductMedia::TYPE_FILE) {
                        $gallery[] = $media;
                    } elseif($media->type == Core_ProductMedia::TYPE_360) {
                        $gallery360[] = $media;
                    } elseif($media->type == Core_ProductMedia::TYPE_SPECIALTYPE) {
                        $specialimage = $media->getImage();
                    } elseif($media->type == Core_ProductMedia::TYPE_URL) {
                        if(!empty($media->moreurl)) {
                            $media->moreurl = Helper::makeEmbedYouTubeUrl($media->moreurl);
                            $media->youtubeid = Helper::getYouTubeVideoId($media->moreurl);
                        }
                        $video[] = $media;
                    }
                }
            }
            
			$getPathImage360 = '';
            if(!empty($gallery360[0])) {

                $imageFile = trim($gallery360[0]->getImage());
                $extension = substr($imageFile,-4);//extension with: .jpg, .png, .gif
                $listexplode = explode('-',substr($imageFile, 0, strrpos($imageFile, '-')+1));
                $getPathImage360 = '';
                if(!empty($listexplode)) {
                    $number = count($listexplode)-1;
                    if(is_numeric($listexplode[$number])) $number = $number-2;

                    for( $i = $number; $i >= 0; $i-- ) {
                        if(!empty($listexplode[$i]))$getPathImage360 = $listexplode[$i].'-'.$getPathImage360;
                    }
                    $getPathImage360 = $getPathImage360.'#'.$extension;
                }
                else {
                    $getPathImage360 = substr($imageFile, 0, strrpos($imageFile, '-')+1).'#'.$extension;
                }
            }
            
            // Get all user thuộc product
            $articles = Core_ProductyearArticle::getProductyearArticles(array('fpid'=> $product_id, 'fstatus'=> Core_ProductyearArticle::STATUS_ENABLE), '', '');
            $listarticle = array();
            foreach ($articles as $item) {
            	$user = new Core_ProductyearUser($item->pyuid);
            	$item->actor = $user->fullname;
            	$item->slug = $this->registry->conf['rooturl'] .'product-of-the-year/' . Helper::codau2khongdau($item->title, true, true) . '-' . $item->id;
            	if ($user->oauthpartner == Core_User::OAUTH_PARTNER_FACEBOOK ) {
					$avatar = 'http://graph.facebook.com/'.$user->oauthid.'/picture?type=small';
				}else {
					$avatar = 'http://profiles.google.com/s2/photos/profile/'.$user->oauthid.'?sz=160';
				}
            	
            	$item->avatar = $avatar;
            	$listarticle[] = $item;
            }
            
			$productyear = Core_Productyear::getProductyears(array('fpid'=> $product_id), '', '');
            if (!empty($productyear)) {
            	$totalarticle = count($listarticle);
            	$product->totalarticle = $totalarticle;
            	$productyear[0]->countarticle = $totalarticle;
            	$productyear[0]->updateData();
            }
            
            // Get nguoi choi cao diem nhat
			$articles_point = Core_ProductyearArticle::getProductyearArticles(array('fpid'=> $product_id, 'fstatus'=> Core_ProductyearArticle::STATUS_ENABLE), 'point', 'DESC');
			
			if (!empty($articles_point)) {
				$tmp = $articles_point[0];
				$userpoint = new Core_ProductyearUser($tmp->pyuid);
				$tmp->actor = $userpoint->fullname;
            	$tmp->slug = $this->registry->conf['rooturl'] .'product-of-the-year/' . Helper::codau2khongdau($tmp->title, true, true) . '-' . $tmp->id;
            	if ($userpoint->oauthpartner == Core_User::OAUTH_PARTNER_FACEBOOK ) {
					$avatar = 'http://graph.facebook.com/'.$userpoint->oauthid.'/picture?type=small';
				}else {
					$avatar = 'http://profiles.google.com/s2/photos/profile/'.$userpoint->oauthid.'?sz=160';
				}
            	
            	$tmp->avatar = $avatar;
            	
            	$articles_point = $tmp;
			}
			
			 if($product->summarynew != "")
                $product->summarynew = explode("#", $product->summarynew);
			
            $this->registry->smarty->assign(
	            array(
	            	'productDetail' => $product,
	            	'galleries'    => $gallery,
                    'galleries360' => $gallery360,
	            	'user_profile' => $user_profile,
	            	'pathimage360' => $getPathImage360,
                    'numimage360'  => count($gallery360),
	            	'listarticle' => $listarticle,
	            	'articles_point' => $articles_point,
	            )
	        );
	    	$this->registry->smarty->display($this->registry->smartyControllerContainer.'detail.tpl');
            
		}else {
			header('HTTP/1.0 404 Not Found');
	        echo 'Not found';
	        exit();
		}
	}
	
	
	public function articleAction() 
	{
		
		if (!empty($_SESSION['User'])) {
			
			$user_profile = $_SESSION['User'];
			if (!empty($user_profile)) {
				if ($_SESSION['User']['oauthPartner'] == Core_User::OAUTH_PARTNER_FACEBOOK ) {
					$user_profile['avatar'] = 'http://graph.facebook.com/'.$_SESSION['User']['id'].'/picture?type=small';
				}else {
					$user_profile['avatar'] = 'http://profiles.google.com/s2/photos/profile/'.$_SESSION['User']['id'].'?sz=160';
				}
			}
		}
		
		$slug = $_GET['slug'];
		preg_match('/^[a-z0-9\_-]+-(\d+)$/', $slug, $match);
		$id = $match[1];
		$article = new Core_ProductyearArticle($id);
		$article->slug = $this->registry->conf['rooturl'] .'product-of-the-year/' . Helper::codau2khongdau($article->title, true, true) . '-' . $article->id;
		$user = new Core_ProductyearUser($article->pyuid);
        $article->actor = $user->fullname;
        if ($user->oauthpartner == Core_User::OAUTH_PARTNER_FACEBOOK ) {
			$avatar = 'http://graph.facebook.com/'.$user->oauthid.'/picture?type=small';
		}else {
			$avatar = 'http://profiles.google.com/s2/photos/profile/'.$user->oauthid.'?sz=160';
		}
		
		$article->avatar = $avatar;
		
		// get ten san pham 
		$product = new Core_Product($article->pid);
		$article->productname = $product->name;
		
		$this->registry->smarty->assign(
		            array(
		            	'article' => $article,
		            	'user_profile' => $user_profile
		            )
		        );
		$this->registry->smarty->display($this->registry->smartyControllerContainer.'article.tpl');
	}
	
	
	
	public function logoutAction() {
		session_regenerate_id(true);
		session_destroy();		
		header('location: ' . $this->registry->conf['rooturl'] . 'product-of-the-year');
	}
	
	public function loginfacebookAction() {

		require_once(SITE_PATH. 'libs/facebook/facebook.php');
		$facebook = new Facebook(array(
			'appId'		=>  '403992816397723',
			'secret'	=>  'bb179513ac955e873f230e664104e3e2',
		));
		
		//get the user facebook id
		$user = $facebook->getUser();
		if($user){
			try{
				//get the facebook user profile data
				$user_profile = $facebook->api('/me');
				$user_profile['oauthPartner'] = Core_User::OAUTH_PARTNER_FACEBOOK;
				$_SESSION['User'] = $user_profile;
				header('Location: ' . $this->registry->conf['rooturl'].'product-of-the-year');
				
			}catch (FacebookApiException $e) {
				error_log($e);
				$user = NULL;
			}
		}
		if(empty($user)){
			$loginurl = $facebook->getLoginUrl(array(
				'scope'			=> 'email,read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos',
				'redirect_uri'	=> $this->registry->conf['rooturl'].'productyear/loginfacebook'
				));
				header('Location: ' . $loginurl);
		}
	}
	
	public function logingoogleAction() {
		
		require_once(SITE_PATH. 'libs/google/google.config.php');
		require_once(SITE_PATH. 'libs/google/google_auth.php');

		$client = new Google_Client();
		$client->setApplicationName("dienmay");
		$oauth2 = new Google_Oauth2Service($client);
		
		if (isset($_GET['code'])) { // IF GOOGLE
			$client->authenticate($_GET['code']);
			$_SESSION['token'] = $client->getAccessToken();
			$_SESSION['oauth_type'] ="google";
			$user_profile = $oauth2->userinfo->get();

			$user_profile['oauthPartner'] = Core_User::OAUTH_PARTNER_GOOGLE;
			$_SESSION['User'] = $user_profile;

			header('Location: ' . $this->registry->conf['rooturl'].'product-of-the-year');
		}else{
			$authUrl = $client->createAuthUrl();
			header('Location: ' . $authUrl);
		}
			
	}
	
	//Kiem tra du lieu nhap trong form them moi	
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
		
		

		if($formData['ftitle'] == '')
		{
			$error[] = 'Bạn chưa nhập tiêu đề bài viết.';
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = 'Bạn chưa nhập nội dung bài viết.';
			$pass = false;
		}
		
		return $pass;
	}
}