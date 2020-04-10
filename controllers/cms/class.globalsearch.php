<?php

Class Controller_Cms_GlobalSearch Extends Controller_Cms_Base 
{
	
	function indexAction() 
	{
		if(isset($_POST['fsearch']))
		{
			$keyword = (string)$_POST['fkeyword'];
			
			$redirectUrl = $this->registry->conf['rooturl_cms'] . 'product/index/vid/0/vsubid/0/pcid/0/name/' . $keyword; 
			
			header('location:' . $redirectUrl);
		}
		
	} 
	
	
	/**
	* Chuc nang suggest product dua vao keyword user typing
	* 
	* Dung cho typing o top bar
	* 
	*/
	public function suggestAction()
	{
		$rooturl = $this->registry->conf['rooturl'];
		$rooturl_cms = $this->registry->conf['rooturl_cms'];
		$rooturl_profile = $this->registry->conf['rooturl_profile'];
		$rooturl_admin = $this->registry->conf['rooturl_admin'];
		$currentTemplate = $this->registry->conf['rooturl'] . 'templates/default/';
		$lang = $this->registry->lang['controller'];
		
		//search book
		$keyword = htmlspecialchars($_GET['q']);
		
		$stopSelect = 0;
		//$keyword = Helper::codau2khongdau($keyword);
		if(mb_strlen($keyword) < 3)
		{
			$stopSelect = 1;
		}  
		
		//search using Sphinx api
        //search product
        $searchEngine = new SearchEngine();
        $searchEngine->addtable('productindex');
        $searchEngine->searcher->SetFieldWeights(array('pi_title' => 3, 'pi_content' => 1));
        $searchEngine->searcher->SetSortMode(SPH_SORT_EXTENDED, 'pi_onsitestatus DESC, @weight DESC');
        $searchEngine->searcher->setLimits(0, 5, 50000);
        $result = $searchEngine->search($keyword);
        unset($searchEngine);

        //search news
        $searchEngine = new SearchEngine();
        $searchEngine->searcher->setLimits(0, 5, 50000);
        $searchEngine->addtable('news');
        $resultExtend = $searchEngine->search($keyword);

        //echodebug($result, true);

        $seperator = "|";

        if(count($result['productindex']) > 0)
        {
            echo $rooturl_cms . 'product'.$seperator.$this->registry->lang['controller']['product'].$seperator.'&nbsp;'.$seperator.'0'.$seperator.'&nbsp;'.$seperator.'seperator' . "\n";

            foreach($result['productindex'] as $product)
            {
                if(!$product['result_found'])
                {
                    $myProduct = new Core_Product($product['id'], true);

                    $finalprice = Core_RelRegionPricearea::getPriceByProductRegion($myProduct->barcode, $this->registry->region);
                    if($finalprice > 0) 
                        $myProduct->sellprice = $finalprice;

                    if($myProduct->image == '')
                        $imagePath = $currentTemplate . 'images/default.jpg';
                    else
                        $imagePath = $myProduct->getSmallImage();
                    
                    $myProduct->name = str_replace('|', '&#124;', $myProduct->name);
                    echo $rooturl_cms.'product/edit/id/'.$myProduct->id.$seperator.$myProduct->name.$seperator.$imagePath.$seperator.'&nbsp;'.$seperator.($myProduct->sellprice > 0 ? number_format($myProduct->sellprice) . '&#272;' : 'Hết hàng').$seperator.'product' . "\n";
                }
            }
        }

        

        if(count($resultExtend['news']) > 0)
        {
            echo $rooturl_cms . 'news'.$seperator.$this->registry->lang['controller']['news'].$seperator.'&nbsp;'.$seperator.'0'.$seperator.'&nbsp;'.$seperator.'seperator' . "\n";

            foreach($resultExtend['news'] as $news)
            {
                if(!$news['result_found'])
                {
                    $myNews = new Core_News();
                    $myNews->id = $news['id'];
                    $myNews->title = $news['attrs']['n_title'];
                    $myNews->image = $news['attrs']['n_image'];
                    $myNews->slug = $news['attrs']['n_slug'];

                    if($myNews->image == '')
                        $imagePath = $currentTemplate . 'images/default.jpg';
                    else
                        $imagePath = $rooturl . 'uploads/news/' .$myNews->image;

                    $myNews->title = str_replace('|', '&#124;', $myNews->title);
                    echo $rooturl_cms.'news/edit/id/'.$myNews->id.$seperator.$myNews->title.$seperator.$imagePath.$seperator.'&nbsp;'.$seperator.'&nbsp;'.$seperator.'news' . "\n";
                }
            }
        }

		//////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////
		//search user
		
		//echo $this->registry->conf['rooturl_admin'] . 'user|'.$this->registry->lang['controller']['user'].'|&nbsp;|0|&nbsp;|seperator' . "\n";
		/*
		//if login, search in friend and fanpage
		$myUserIdList = array();
		$myFriendIds = Core_Backend_Friend::getFriendIds($this->registry->me->id);
		
		$friendList = Core_User::getUsers(array('fidlist' => $myUserIdList, 'fkeywordFilter' => $keyword), '', '', 2);
		
		
		if(!empty($friendList))
		{
			echo $this->registry->me->getUserPath() . '/friend/search?keyword='.$keyword.'|'.$this->registry->lang['default']['mFriend'] . ' &amp; Page'.'|&nbsp;|0|&nbsp;|seperator' . "\n";
			for($i = 0; $i < count($friendList); $i++)
			{
				$authorReplacement = '';
				if($friendList[$i]->ispage())
				{
					$myPage = new Core_Page($friendList[$i]->id);
					$authorReplacement = $myPage->countLike . ' ' . $this->registry->lang['default']['mMember'];
				}
				else
				{
					$authorReplacement = $friendList[$i]->getRegionName(false);
				}
				
				echo  $friendList[$i]->getUserPath() . '|' . $friendList[$i]->fullname . '|' . $friendList[$i]->getSmallImage() . '|&nbsp;|'.$authorReplacement.'|' . 'user' . "\n";
			}
		}
		
		
		if(strlen($keyword) > 6)
		{
			$userListTmp = Core_User::getUsers(array('fkeywordFilter' => $keyword), '', '', 2);
			$userList = array();
			for($i = 0; $i < count($userListTmp); $i++)
			{
				if(!in_array($userListTmp[$i]->id, $myUserIdList))
					$userList[] = $userListTmp[$i];
			}
			
			
			if(!empty($userList))
			{
				echo $this->registry->conf['rooturl'] . 'member?search=1&keyword='.$keyword.'|'.$this->registry->lang['default']['mMember'].'|&nbsp;|0|&nbsp;|seperator' . "\n";
				for($i = 0; $i < count($userList); $i++)
				{
					$authorReplacement = '';
					if($userList[$i]->ispage())
					{
						$myPage = new Core_Page($userList[$i]->id);
						$authorReplacement = $myPage->countLike . ' ' . $this->registry->lang['default']['mMember'];
					}
					else
					{
						$authorReplacement = $friendList[$i]->getRegionName(false);
					}
					echo  $userList[$i]->getUserPath() . '|' . $userList[$i]->fullname . '|' . $userList[$i]->getSmallImage() . '|&nbsp;|'.$authorReplacement.'|' . 'user' . "\n";
				}
			}
		}
		
		*/
		
		
		
		//////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////
		//search controller such as: Dang ky, dang nhap, lien he...
		$c = array();
		$c['product'] = array($lang['product'], $rooturl_cms . 'product', 4);

		//synonym
		$c['sanpham'] = $c['product'];
		
		//foundController
		$foundController = array();
		$foundControllerId = array();
		foreach($c as $k => $v)
		{
			if(strpos($k, $keyword) !== false && !in_array($v[2], $foundControllerId))
			{
				//array tuan tu, vi de lay phan tu dau index = 0 de set default url cho seperator o duoi
				$foundController[] = $v;
				$foundControllerId[] = $v[2];
			}
		}
		
		
		
		if(count($foundController) > 0)
		{
			echo $foundController[0][1] . '|Quick Menu|&nbsp;|0|&nbsp;|seperator' . "\n";
			foreach($foundController as $controller)
			{
				echo  $controller[1] . '|' . $controller[0] . '|'.$this->registry->currentTemplate . 'images/plainicon.jpg' . ' |0|&nbsp;|' . 'controller' . "\n";
			}
		}
	}


}

