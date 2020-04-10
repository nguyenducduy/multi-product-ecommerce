<?php
Class Controller_Site_Stuff Extends Controller_Site_Base
{
	public $recordPerPage = 10;

	public function indexAction()
	{
		$formData = array();

		$regionFilter = (int)(isset($_GET['regionid'])?$_GET['regionid']:3);
        $scid = (int)(isset($_GET['scid'])?$_GET['scid']:0);
        $uid = (int)(isset($_GET['uid'])?$_GET['uid']:0);

        $cachefile = 'sitehtml_stuffs'.'_'.$regionFilter.'_'.$scid.'_'.$uid;

        $myCache = new Cacher( $cachefile );

        if(isset($_GET['live'])) {
            $myCache->clear();
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if( !$pageHtml )
        {
		    if($_GET['scid'])
            {
                $pageHtml = $this->listAction();
            }
			elseif(isset($_GET['uid']) && $_GET['uid'] > 0)
            {
                $pageHtml = $this->getbycontactAction();
            }
            else
            {
                $myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

                foreach($myStuffcategory as $myStuff)
                {
                    $category = new Core_Stuffcategory($myStuff->id);

                    $myStuff->countitem = Core_Stuff::getStuffs(array('fscid' => $myStuff->id, 'fregionid' => $regionFilter), '', '', '', true);
                    $myStuff->topic = Core_Stuff::getStuffs(array('fscid' => $myStuff->id, 'fstatus' => Core_Stuff::STATUS_ENABLE, 'fregionid' => $regionFilter), 'datecreated', 'DESC', '0, 5');
                }

                $this->registry->smarty->assign(array(    'formData'    => $formData,
                                                        'regionFilter'    => $regionFilter,
                                                        'myRegion'		=> new Core_Region($regionFilter, true),
                                                        //'hideMenu'    => 1,
                                                        'myStuffcategory'    => $myStuffcategory,
                                                        'redirectUrl'    => $redirectUrl,
                                                        'bannerphai'     => $this->getBanner(9)));

                $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

                $this->registry->smarty->assign(array(
                                                        'pageTitle'    => $this->registry->lang['controller']['seotitlestuff'],
                                                        'pageKeyword'    => $this->registry->lang['controller']['seokeywordstuff'],
                                                        'pageDescription'    => $this->registry->lang['controller']['seodescriptionstuff'],
                                                        'contents'     => $contents,
    													'pageMetarobots'  => 'noindex, nofollow',
                                                        ));

                $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
            }

            $myCache->set($pageHtml);
        }
        echo $pageHtml;
	}

	private function listAction()
	{
		$formData = array();

		$catId = $_GET['scid'];
		$regionFilter = $_GET['regionid'];
		$vpage 			= (int)($_GET['vpage'])>0?(int)($_GET['vpage']):1;
		$page 			= (int)($_GET['page'])>0?(int)($_GET['page']):1;

		$paginateUrl = $this->registry->conf['rooturl']. 'rao-vat?scid=' . $catId . '&regionid=' . $regionFilter . '&';

		if(!isset($regionFilter))
			$regionFilter = 3;

		$myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

		$selectedCat = new Core_Stuffcategory($catId);

		//select top view topic
		$topview = Core_Stuff::getStuffs(array(), 'countview', 'DESC', '0, 8');

		//select vip topic
		$vtotal = Core_Stuff::getStuffs(array('fscid' => $catId, 'fregionid' => $regionFilter, 'fisvip' => 1, 'fstatus' => Core_Stuff::STATUS_ENABLE ), $sortby, $sorttype, 0, true);

		$vtotalPage = ceil($vtotal/$this->recordPerPage);
		$vcurPage = $vpage;

		$vipstuffs = Core_Stuff::getStuffs(array('fscid' => $catId, 'fregionid' => $regionFilter, 'fisvip' => 1, 'fstatus' => Core_Stuff::STATUS_ENABLE), $sortby, $sorttype, (($vpage - 1)*$this->recordPerPage).','.$this->recordPerPage);

		$redirectUrl = $paginateUrl;
		if($vcurPage > 1)
			$redirectUrl .= 'vpage=' . $vcurPage;

		//select normal topic
		$total = Core_Stuff::getStuffs(array('fscid' => $catId, 'fregionid' => $regionFilter, 'fstatus' => Core_Stuff::STATUS_ENABLE), $sortby, $sorttype, 0, true);

		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;

		$normalstuffs = Core_Stuff::getStuffs(array('fscid' => $catId, 'fregionid' => $regionFilter, 'fstatus' => Core_Stuff::STATUS_ENABLE), $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page=' . $curPage;

		$redirectUrl = base64_encode($redirectUrl);

		$this->registry->smarty->assign(array(	//'hideMenu'	=> 1,
												'formData'	=> $formData,
												'regionFilter'	=> $regionFilter,
												'myRegion'		=> new Core_Region($regionFilter, true),
												'selectedCat'		=> $selectedCat,
												'myStuffcategory'	=> $myStuffcategory,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'vtotal'			=> $vtotal,
												'vtotalPage' 	=> $vtotalPage,
												'vcurPage'		=> $vcurPage,
												'vipstuffs'	=> $vipstuffs,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												'normalstuffs'	=> $normalstuffs,
												'topview'		=> $topview,
												'bannerphai' 	=> $this->getBanner(9),
												'bannertrai' 	=> $this->getBanner(8)));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'list.tpl');

        $this->registry->smarty->assign(array(	'pageTitle'	=> (!empty($selectedCat->seotitle)?$selectedCat->seotitle:$selectedCat->name),
                                                'pageKeyword'    => $selectedCat->seokeyword,
                                                'pageDescription'    => $selectedCat->seodescription,
                                                'contents' 	=> $contents,
                                                ));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

		//for View Tracking
		$_GET['trackingid'] = $_GET['scid'];
	}


	public function detailAction()
	{
		$id = (int)(isset($_GET['id'])?$_GET['id']:0);
        $cachefile = 'sitehtml_stuffdetail'.'_'.$id;

        $myCache = new Cacher( $cachefile );

        if(isset($_GET['live'])) {
            $myCache->clear();
            $pageHtml = '';
        }
        else $pageHtml = $myCache->get();

        if( !$pageHtml )
        {
		    $myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

		    //select top view topic
		    $topview = Core_Stuff::getStuffs(array(), 'countview', 'DESC', '0, 8');

		    $myStuff = new Core_Stuff($id);
		    $myUser = new Core_User($myStuff->uid);
		    //echodebug($myStuff, true);
		    if(!empty($myUser))
		    {
			    $myStuff->contactname = $myUser->fullname;
			    $myStuff->contactphone = $myUser->phone;
			    $myStuff->contactemail = $myUser->email;
		    }

		    $category = new Core_Stuffcategory($myStuff->scid);



		    $this->registry->smarty->assign(array(	//'hideMenu'	=> 1,
												    'formData'	=> $formData,
												    'myStuffcategory'	=> $myStuffcategory,
												    'topview'		=> $topview,
												    'myStuff'	=> $myStuff,
												    'category'	=> $category,
												    'bannerphai' 	=> $this->getBanner(9),
												    'bannertrai' 	=> $this->getBanner(8)));

		    $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'detail.tpl');

		    $this->registry->smarty->assign(array(	'pageTitle'    => (!empty($myStuff->seotitle)?$myStuff->seotitle:$myStuff->title),
                                                    'pageKeyword'    => $myStuff->seokeyword,
                                                    'pageDescription'    => $myStuff->seodescription,
												    'contents' 	=> $contents));

		    $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer . 'index.tpl');
            $myCache->set($pageHtml);
        }
        echo $pageHtml;
		//for View Tracking
		$_GET['trackingid'] = $_GET['id'];
	}

	private function getbycontactAction()
	{
		$id = $_GET['uid'];

		$page 			= (int)($_GET['page'])>0?(int)($_GET['page']):1;

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index?uid=' . $id . '&';

		$myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

		$topview = Core_Stuff::getStuffs(array(), 'countview', 'DESC', '0, 8');

		//select normal topic
		$total = Core_Stuff::getStuffs(array('fuid' => $id, 'fstatus' => Core_Stuff::STATUS_ENABLE), $sortby, $sorttype, 0, true);

		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;

		$stuffs = Core_Stuff::getStuffs(array('fuid' => $id, 'fstatus' => Core_Stuff::STATUS_ENABLE), $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);

		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page=' . $curPage;

		$redirectUrl = base64_encode($redirectUrl);

		$this->registry->smarty->assign(array(	//'hideMenu'  => 1,
												'stuffs'	=> $stuffs,
												'topview'		=> $topview,
												'myStuffcategory'	=> $myStuffcategory,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'bannerphai' 	=> $this->getBanner(9),
												'bannertrai' 	=> $this->getBanner(8)));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'getbycontact.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'    => $this->registry->lang['controller']['seotitlestuff'],
                                                'pageKeyword'    => $this->registry->lang['controller']['seokeywordstuff'],
                                                'pageDescription'    => $this->registry->lang['controller']['seodescriptionstuff'],
												'contents'	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}

	public function postAction()
	{
		$formData = array();
		$error = array();
		$success = array();

		if(!empty($_POST['fsubmit']))
		{
			if($_SESSION['addStuffToken'] == $_POST['ftoken'])
			{
				$formData = array_merge($formData, $_POST);

				if($this->addActionValidator($formData, $error))
				{
					$myStuff = new Core_Stuff();

					$myStuff->uid = $this->registry->me->id;
					$myStuff->title = $formData['ftitle'];
					$myStuff->price = $formData['fprice'];
					$myStuff->content = $formData['fcontent'];
					$myStuff->scid = $formData['fscid'];
					if($formData['ftype'] == Core_Stuff::IS_VIP)
						$myStuff->isvip = $formData['ftype'];
					else
						$myStuff->isvip == Core_Stuff::IS_NORMAL;
					$myStuff->regionid = $formData['fregion'];
					$myStuff->status = Core_Stuff::STATUS_ENABLE;

					if($myStuff->addData() > 0)
						$success[] = $this->registry->lang['controller']['succAdd'];
					else
						$error[] = $this->registry->lang['controller']['errAdd'];
				}
			}
		}

		$_SESSION['addStuffToken'] = Helper::getSecurityToken();

		$myRegion = Core_Region::getRegions(array('fparentid'	=> 0), 'id', 'ASC', '');

		$myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

		$topview = Core_Stuff::getStuffs(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 8');

		$this->registry->smarty->assign(array(	//'hideMenu'	=> 1,
												'formData'	=> $formData,
												'error'		=> $error,
												'success'	=> $success,
												'myStuffcategory' 	=> $myStuffcategory,
												'topview'	=> $topview,
												'myRegion'	=> $myRegion,
												'isvip'	=> Core_Stuff::IS_VIP,
												'isnormal'	=> Core_Stuff::IS_NORMAL,
												'bannerphai' 	=> $this->getBanner(9),
												'bannertrai' 	=> $this->getBanner(8)));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'post.tpl');

		$this->registry->smarty->assign(array(	'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
												'contents'	=> $contents));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}

	public function searchstuffAction()
	{
		$formData = array();
		$warning = array();
		$success = array();
		$error = array();
		$filterin = array();
		$output = array();

		$myStuffcategory = Core_Stuffcategory::getStuffcategorys(array(), 'displayorder', 'ASC');

		//select top view topic
		$topview = Core_Stuff::getStuffs(array('fstatus' => Core_Stuff::STATUS_ENABLE), 'countview', 'DESC', '0, 8');

		$formData = array_merge($formData, $_GET);

		$searchEngine = new SearchEngine();

		if($_GET['page'])
		{
			$page = $_GET['page'];
			$offset = ($this->recordPerpage * $page) - $this->recordPerpage;
		}
		else
		{
			$page = 1;
			$offset = 0;
		}

		$searchEngine->addtable('stuff');

		if($formData['fscid'] > 0)
		{
			$filterin[] = $formData['fscid'];
			$searchEngine->searcher->SetFilter('sc_id', $filterin);
		}

		if(isset($formData['fregion']))
		{
			$searchEngine->searcher->SetSelect('*, s_regionid='.$formData['fregion'].' AS myregion');
			$searchEngine->searcher->SetFilter('s_regionid', array($formData['fregion']));
		}

		$searchEngine->searcher->setLimits($offset, $this->recordPerPage, 50000);

		$result = $searchEngine->search($formData['fkeyword']);

		if($result)
		{
			foreach($result['stuff'] as $stuff)
			{
				if(!$stuff['result_found'])
				{
					$myStuff = new Core_Stuff();

					$myStuff->id = $stuff['id'];
					$myStuff->title = $stuff['attrs']['s_title'];
					$myStuff->image = $stuff['attrs']['s_image'];
					$myStuff->price = $stuff['attrs']['s_price'];
					$myStuff->scid = $stuff['attrs']['sc_id'];
					$myStuff->regionid = $stuff['attrs']['s_regionid'];
					$myStuff->content = $stuff['attrs']['s_content'];
					$myStuff->contactname = $stuff['attrs']['s_contactname'];
					$myStuff->datecreated = $stuff['attrs']['s_datecreated'];

					$output[] = $myStuff;
				}
			}
		}
		//echodebug($output);
		$curPage = $page;
		$total = $result['stuff']['result_found'];
		$totalPage = ceil($total/$this->recordPerPage);

		if(isset($formData['fregion']))
			$paginateurl = $this->registry->conf['rooturl'] . 'rao-vat/searchstuff?fscid=' . $formData['fscid'] . '&fkeyword=' . $formData['fkeyword'] . '&fregion=' . $formData['fregion'] ;
		else
			$paginateurl = $this->registry->conf['rooturl'] . 'rao-vat/searchstuff?fscid=' . $formData['fscid'] . '&fkeyword=' . $formData['fkeyword'] ;

		$this->registry->smarty->assign(array(	'myStuffcategory'	=> $myStuffcategory,
												'topview'			=> $topview,
												//'hideMenu'			=> 1,
												'formData'			=> $formData,
												'paginateurl'		=> $paginateurl,
												'totalPage'			=> $totalPage,
												'total'				=> $total,
												'curPage'			=> $page,
												'myStuff'			=> $output,
												'myRegion'			=> new Core_Region($formData['fregion'], true),
												'bannerphai' 	=> $this->getBanner(9),
												'bannertrai' 	=> $this->getBanner(8)
												));

		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'searchresult.tpl');

		$this->registry->smarty->assign(array(	'pageTitle' => $this->registry->lang['controller']['pageTitle_list'],
												'contents'	=> $contents,
												));

		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer.'index.tpl');
	}


	public function addActionValidator($formData, &$error)
	{
		$pass = true;

		if($formData['ftitle'] == '')
		{
			$error[] = $this->registry->lang['controller']['errTitleRequired'];
			$pass = false;
		}

		if(strlen($formData['ftitle']) > 150)
		{
			$error[] = $this->registry->lang['controller']['errTitleLimited'];
			$pass = false;
		}
/*
		if($formData['fprice'] == '')
		{
			$error[] = $this->registry->lang['controller']['errPriceRequired'];
			$pass = false;
		}*/

		if(Helper::refineMoneyString($formData['fprice']) == 0)
		{
			$error[] = $this->registry->lang['controller']['errPriceIsInt'];;
			$pass = false;
		}

		if($formData['fcontent'] == '')
		{
			$error[] = $this->registry->lang['controller']['errContentRequired'];
			$pass = false;
		}


		if($formData['fscid'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errCategoryRequired'];
			$pass = false;
		}

		if($formData['fregion'] == 0)
		{
			$error[] = $this->registry->lang['controller']['errRegionRequired'];
			$pass = false;
		}

		//check security code
        if(strlen($formData['fcaptcha']) == 0 || $formData['fcaptcha'] != $_SESSION['verify_code'])
        {
            $error[] = $this->registry->lang['controller']['errSecurityCode'];
            $pass = false;
        }

		return $pass;
	}

	private function getBanner($fazid = 8, $ftype = Core_Ads::TYPE_BANNER)
    {
        $formData['fazid'] = $fazid; //Dienmay Homepage
        $formData['ftype'] = $ftype;
        return Core_Ads::getAdss($formData, '', 'DESC', 6);
    }


}







