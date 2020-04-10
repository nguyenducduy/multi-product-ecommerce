<?php

Class Controller_Cms_Ads Extends Controller_Cms_Base
{
	private $recordPerPage = 20;

	function indexAction()
	{
		$error 			= array();
		$success 		= array();
		$warning 		= array();
		$formData 		= array('fbulkid' => array());
		$_SESSION['securityToken']=Helper::getSecurityToken();//Token
		$page 			= (int)($this->registry->router->getArg('page'))>0?(int)($this->registry->router->getArg('page')):1;


		$azidFilter = (int)($this->registry->router->getArg('azid'));
		$typeFilter = (int)($this->registry->router->getArg('type'));
		$nameFilter = (string)($this->registry->router->getArg('name'));
		$titleFilter = (string)($this->registry->router->getArg('title'));
		$summaryFilter = (string)($this->registry->router->getArg('summary'));
		$campaignFilter = (string)($this->registry->router->getArg('campaign'));
		$campaignsourceFilter = (string)($this->registry->router->getArg('campaignsource'));
		$campaignmediumFilter = (string)($this->registry->router->getArg('campaignmedium'));
		$groupFilter = (string)($this->registry->router->getArg('group'));
		$groupdisplaytypeFilter = (int)($this->registry->router->getArg('groupdisplaytype'));
		$groupdisplayorderFilter = (int)($this->registry->router->getArg('groupdisplayorder'));
		$linktargetFilter = (int)($this->registry->router->getArg('linktarget'));
		$isinternalFilter = (int)($this->registry->router->getArg('isinternal'));
		$impressionFilter = (int)($this->registry->router->getArg('impression'));
		$clickFilter = (int)($this->registry->router->getArg('click'));
		$statusFilter = (int)($this->registry->router->getArg('status'));
		$datebeginFilter = (int)($this->registry->router->getArg('datebegin'));
		$dateendFilter = (int)($this->registry->router->getArg('dateend'));
		$idFilter = (int)($this->registry->router->getArg('id'));
        $adsSlugFilter = (string)($this->registry->router->getArg('slug'));

		$keywordFilter = (string)$this->registry->router->getArg('keyword');
		$searchKeywordIn= (string)$this->registry->router->getArg('searchin');

		//check sort column condition
		$sortby 	= $this->registry->router->getArg('sortby');
		if($sortby == '') $sortby = 'id';
		$formData['sortby'] = $sortby;
		$sorttype 	= $this->registry->router->getArg('sorttype');
		if(strtoupper($sorttype) != 'ASC') $sorttype = 'DESC';
		$formData['sorttype'] = $sorttype;


		if(!empty($_POST['fsubmitbulk']))
		{
            if($_SESSION['adsBulkToken']==$_POST['ftoken'])
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
                        $adsslug = new Core_AdsSlug();
                        foreach($delArr as $id)
                        {
                            //check valid user and not admin user
                            $myAds = new Core_Ads($id);

                            if($myAds->id > 0)
                            {
                                //tien hanh xoa
                                if($myAds->delete())
                                {
                                    $adsslug->aid = $myAds->id;
                                    if($adsslug->deleteByAId())
                                    {
                                        //Some thing
                                    }
                                    $deletedItems[] = $myAds->id;
                                    $this->registry->me->writelog('ads_delete', $myAds->id, array());
                                }
                                else
                                    $cannotDeletedItems[] = $myAds->id;
                            }
                            else
                                $cannotDeletedItems[] = $myAds->id;
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

        //change order of item
        if(!empty($_POST['fsubmitchangeorder']))
        {
            if($_SESSION['adsBulkToken']==$_POST['ftoken'])
            {
                $displayorderList = $_POST['fdisplayorder'];
                foreach($displayorderList as $id => $neworder)
                {
                    $myItem = new Core_Ads($id);
                    if($myItem->id > 0 && $myItem->displayorder != $neworder)
                    {
                        $myItem->displayorder = $neworder;
                        $myItem->updateData();
                    }
                }
                $success[] = $this->registry->lang['default']['bulkItemChangeOrderSuccess'];
            }
        }

		$_SESSION['adsBulkToken']=Helper::getSecurityToken();//Gan token de kiem soat viec nhan nut submit form

		$paginateUrl = $this->registry->conf['rooturl'].$this->registry->controllerGroup . '/'.$this->registry->controller.'/index/';



		if($azidFilter > 0)
		{
			$paginateUrl .= 'azid/'.$azidFilter . '/';
			$formData['fazid'] = $azidFilter;
			$formData['search'] = 'azid';
		}

		if($typeFilter > 0)
		{
			$paginateUrl .= 'type/'.$typeFilter . '/';
			$formData['ftype'] = $typeFilter;
			$formData['search'] = 'type';
		}

		if($nameFilter != "")
		{
			$paginateUrl .= 'name/'.$nameFilter . '/';
			$formData['fname'] = $nameFilter;
			$formData['search'] = 'name';
		}

		if($titleFilter != "")
		{
			$paginateUrl .= 'title/'.$titleFilter . '/';
			$formData['ftitle'] = $titleFilter;
			$formData['search'] = 'title';
		}

		if($summaryFilter != "")
		{
			$paginateUrl .= 'summary/'.$summaryFilter . '/';
			$formData['fsummary'] = $summaryFilter;
			$formData['search'] = 'summary';
		}

		if($campaignFilter != "")
		{
			$paginateUrl .= 'campaign/'.$campaignFilter . '/';
			$formData['fcampaign'] = $campaignFilter;
			$formData['search'] = 'campaign';
		}

		if($campaignsourceFilter != "")
		{
			$paginateUrl .= 'campaignsource/'.$campaignsourceFilter . '/';
			$formData['fcampaignsource'] = $campaignsourceFilter;
			$formData['search'] = 'campaignsource';
		}

		if($campaignmediumFilter != "")
		{
			$paginateUrl .= 'campaignmedium/'.$campaignmediumFilter . '/';
			$formData['fcampaignmedium'] = $campaignmediumFilter;
			$formData['search'] = 'campaignmedium';
		}

		if($groupFilter != "")
		{
			$paginateUrl .= 'group/'.$groupFilter . '/';
			$formData['fgroup'] = $groupFilter;
			$formData['search'] = 'group';
		}

		if($groupdisplaytypeFilter > 0)
		{
			$paginateUrl .= 'groupdisplaytype/'.$groupdisplaytypeFilter . '/';
			$formData['fgroupdisplaytype'] = $groupdisplaytypeFilter;
			$formData['search'] = 'groupdisplaytype';
		}

		if($groupdisplayorderFilter > 0)
		{
			$paginateUrl .= 'groupdisplayorder/'.$groupdisplayorderFilter . '/';
			$formData['fgroupdisplayorder'] = $groupdisplayorderFilter;
			$formData['search'] = 'groupdisplayorder';
		}

		if($linktargetFilter > 0)
		{
			$paginateUrl .= 'linktarget/'.$linktargetFilter . '/';
			$formData['flinktarget'] = $linktargetFilter;
			$formData['search'] = 'linktarget';
		}

		if($isinternalFilter > 0)
		{
			$paginateUrl .= 'isinternal/'.$isinternalFilter . '/';
			$formData['fisinternal'] = $isinternalFilter;
			$formData['search'] = 'isinternal';
		}

		if($impressionFilter > 0)
		{
			$paginateUrl .= 'impression/'.$impressionFilter . '/';
			$formData['fimpression'] = $impressionFilter;
			$formData['search'] = 'impression';
		}

		if($clickFilter > 0)
		{
			$paginateUrl .= 'click/'.$clickFilter . '/';
			$formData['fclick'] = $clickFilter;
			$formData['search'] = 'click';
		}

		if($statusFilter > 0)
		{
			$paginateUrl .= 'status/'.$statusFilter . '/';
			$formData['fstatus'] = $statusFilter;
			$formData['search'] = 'status';
		}

		if($datebeginFilter > 0)
		{
			$paginateUrl .= 'datebegin/'.$datebeginFilter . '/';
			$formData['fdatebegin'] = $datebeginFilter;
			$formData['search'] = 'datebegin';
		}

		if($dateendFilter > 0)
		{
			$paginateUrl .= 'dateend/'.$dateendFilter . '/';
			$formData['fdateend'] = $dateendFilter;
			$formData['search'] = 'dateend';
		}

		if($idFilter > 0)
		{
			$paginateUrl .= 'id/'.$idFilter . '/';
			$formData['fid'] = $idFilter;
			$formData['search'] = 'id';
		}

		if(strlen($keywordFilter) > 0)
		{
			$paginateUrl .= 'keyword/' . $keywordFilter . '/';

			if($searchKeywordIn == 'name')
			{
				$paginateUrl .= 'searchin/name/';
			}
			elseif($searchKeywordIn == 'title')
			{
				$paginateUrl .= 'searchin/title/';
			}
			elseif($searchKeywordIn == 'summary')
			{
				$paginateUrl .= 'searchin/summary/';
			}
			elseif($searchKeywordIn == 'campaign')
			{
				$paginateUrl .= 'searchin/campaign/';
			}
			elseif($searchKeywordIn == 'campaignsource')
			{
				$paginateUrl .= 'searchin/campaignsource/';
			}
			elseif($searchKeywordIn == 'campaignmedium')
			{
				$paginateUrl .= 'searchin/campaignmedium/';
			}
			elseif($searchKeywordIn == 'group')
			{
				$paginateUrl .= 'searchin/group/';
			}
            elseif($searchKeywordIn=='slug'){
                $paginateUrl .= 'searchin/slug/';
                $formData['faslug'] = $keywordFilter;
                $adsslug = Core_AdsSlug::getAdsSlugs($formData,'','ASC');
                $aidarr = array();
                foreach($adsslug as $aslug)
                {
                    $aidarr[] = $aslug->aid;
                }
                unset($formData['faslug']);
                if(count($aidarr)>0){
                    $formData['fslug'] = $aidarr;
                }
                else{
                    $formData['fslug'] = array(0);
                }
            }
            $formData['fkeyword'] = $formData['fkeywordFilter'] = $keywordFilter;
            $formData['fsearchin'] = $formData['fsearchKeywordIn'] = $searchKeywordIn;
            $formData['search'] = 'keyword';

		}
		//$formData['fparent'] = 0;
		//tim tong so
		$total = Core_Ads::getAdss($formData, $sortby, $sorttype, 0, true);
		$totalPage = ceil($total/$this->recordPerPage);
		$curPage = $page;


		//get latest account
		$adss = Core_Ads::getAdss($formData, $sortby, $sorttype, (($page - 1)*$this->recordPerPage).','.$this->recordPerPage);
		for($i = 0; $i < count($adss); $i++)
		{
			$adss[$i]->zone = new Core_AdsZone($adss[$i]->azid);
		}


		//filter for sortby & sorttype
		$filterUrl = $paginateUrl;

		//append sort to paginate url
		$paginateUrl .= 'sortby/' . $sortby . '/sorttype/' . $sorttype . '/';


		//build redirect string
		$redirectUrl = $paginateUrl;
		if($curPage > 1)
			$redirectUrl .= 'page/' . $curPage;


		$redirectUrl = base64_encode($redirectUrl);


		$this->registry->smarty->assign(array(	'adss' 	=> $adss,
												'formData'		=> $formData,
												'success'		=> $success,
												'error'			=> $error,
												'warning'		=> $warning,
												'filterUrl'		=> $filterUrl,
												'paginateurl' 	=> $paginateUrl,
												'redirectUrl'	=> $redirectUrl,
												'total'			=> $total,
												'totalPage' 	=> $totalPage,
												'curPage'		=> $curPage,
												'adszoneList'	=> Core_AdsZone::getAdsZones(array(), 'id', 'DESC', ''),
												'typeList'		=> Core_Ads::getTypeList(),
												'statusList'	=> Core_Ads::getStatusList(),

												));


		$contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'index.tpl');

		$this->registry->smarty->assign(array(	'pageTitle'	=> $this->registry->lang['controller']['pageTitle_list'],
												'contents' 	=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');

	}


	function addAction()
	{
		$error 	= array();
		$success 	= array();
        $warning    = array();
		$contents 	= '';
		$formData 	= array();


		if(!empty($_POST['fsubmit']))
		{
            if($_SESSION['adsAddToken'] == $_POST['ftoken'])
            {

                 $formData = array_merge($formData, $_POST);

                if($this->addActionValidator($formData, $error))
                {
                    $myAds = new Core_Ads();


					$myAds->azid = $formData['fazid'];
                    $myAds->type = $formData['ftype'];
                    $myAds->group = $formData['fgroup'];
                    $myAds->name = $formData['fname'];
                    $myAds->title = $formData['ftitle'];
                    $myAds->summary = $formData['fsummary'];
					$myAds->group = (!empty($formData['fgroupmain'])?implode(',', $formData['fgroupmain']):'');
					$myAds->link = $formData['flink'];
					$myAds->image = $formData['fimage'];
					$myAds->width = $formData['fwidth'];
					$myAds->height = $formData['fheight'];
					$myAds->campaign = $formData['fcampaign'];
                    $myAds->campaignsource = $formData['fcampaignsource'];
					$myAds->campaignmedium = $formData['fcampaignmedium'];
                    $myAds->status = $formData['fstatus'];
                    if(!empty($formData['fdatebegin'])) $myAds->datebegin = Helper::strtotimedmy($formData['fdatebegin']);
                    else $myAds->datebegin = 0;
                    if(empty($formData['funlimited'])) $myAds->dateend = Helper::strtotimedmy($formData['fdateend']);
					else $myAds->dateend = 0;

                    if($myAds->addData())
                    {
                        $slugtmp = $formData['faslug'];
                        $slug = json_decode($slugtmp);
                        $adsSlug =  new Core_AdsSlug();
                        foreach($slug as $sl)
                        {
                            $adsSlug->aid = $myAds->id;
                            $adsSlug->slug = $sl;
                            if($adsSlug->addData())
                            {

                            }
                        }
                        $success[] = $this->registry->lang['controller']['succAdd'];
                        $this->registry->me->writelog('ads_add', $myAds->id, array());
                        $formData = array();
                    }
                    else
                    {
                        $error[] = $this->registry->lang['controller']['errAdd'];
                    }
                }
            }

		}

		$_SESSION['adsAddToken']=Helper::getSecurityToken();//Tao token moi
		
		$formData['listprogram'] = Core_Program::getPrograms(array('fenddatenow' => 1),'','');//campaing

		$this->registry->smarty->assign(array(	'formData' 		=> $formData,
												'redirectUrl'	=> $this->getRedirectUrl(),
												'adszoneList'	=> Core_AdsZone::getAdsZones(array(), 'id', 'DESC', ''),
												'typeList'		=> Core_Ads::getTypeList(),
												'statusList'	=> Core_Ads::getStatusList(),
												'error'			=> $error,
                                                'success'        => $success,
												'productcategoryList'		=> $this->getProductCategoryList(),

												));
		$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'add.tpl');
		$this->registry->smarty->assign(array(
												'pageTitle'	=> $this->registry->lang['controller']['pageTitle_add'],
												'contents' 			=> $contents));
		$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
	}



	function editAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myAds = new Core_Ads($id);

		$redirectUrl = $this->getRedirectUrl();
		if($myAds->id > 0)
		{
			$error 		= array();
			$success 	= array();
			$contents 	= '';
			$formData 	= array();

			$formData['fbulkid'] = array();
			if($myAds->parent == 0)
            {
                $formData['fazid'] = $myAds->azid;
                $formData['fid'] = $myAds->id;
                $formData['ftype'] = $myAds->type;
                if ($myAds->type == Core_Ads::TYPE_BANNER)
                {
                    $formData['fistypebannerimage'] = 1;
                }

                $formData['fwidth'] = $myAds->width;
                $formData['fheight'] = $myAds->height;
                $formData['fcampaign'] = $myAds->campaign;
                $formData['fcampaignsource'] = $myAds->campaignsource;
                $formData['fcampaignmedium'] = $myAds->campaignmedium;
                $formData['fgroup'] = $myAds->group;
                $formData['fgroupdisplaytype'] = $myAds->groupdisplaytype;
                $formData['fgroupdisplayorder'] = $myAds->groupdisplayorder;
                $formData['flinktarget'] = $myAds->linktarget;
                $formData['fisinternal'] = $myAds->isinternal;
                $formData['fpayperclick'] = $myAds->payperclick;
                $formData['fimpression'] = $myAds->impression;
                $formData['fclick'] = $myAds->click;
                $formData['fstatus'] = $myAds->status;
                if(!empty($myAds->datebegin)) $formData['fdatebegin'] = date('d/m/Y',$myAds->datebegin);
                else $formData['fdatebegin'] = 0;

                if(!empty($myAds->dateend)) $formData['fdateend'] = date('d/m/Y',$myAds->dateend);
                else $formData['fdateend'] = 0;

                $formData['fdatecreated'] = $myAds->datecreated;
                $formData['fdatemodified'] = $myAds->datemodified;
                $formData['fsummary'] = $myAds->summary;
            }
            else
            {
                $formData['fgroupmain'] = explode(',', $myAds->group);
            }

            $formData['fparent'] = $myAds->parent;
            $formData['fgroupmain'] = explode(',', $myAds->group);
			$formData['fname'] = $myAds->name;
			$formData['flink'] = $myAds->link;
            $formData['fimage'] = $myAds->image;
			$formData['flinkimage'] = $myAds->getSmallImage();
			$formData['ftitle'] = $myAds->title;



			if(!empty($_POST['fsubmit']))
			{
                if($_SESSION['adsEditToken'] == $_POST['ftoken'])
                {
                    $formData = array_merge($formData, $_POST);

                    if($this->editActionValidator($formData, $error))
                    {
						if($myAds->parent == 0)
                        {
                            $myAds->azid = $formData['fazid'];
                            $myAds->type = $formData['ftype'];
                            $myAds->summary = $formData['fsummary'];
                            $myAds->width = $formData['fwidth'];
                            $myAds->height = $formData['fheight'];
                            $myAds->campaign = $formData['fcampaign'];
                            $myAds->campaignsource = $formData['fcampaignsource'];
                            $myAds->campaignmedium = $formData['fcampaignmedium'];
                            $myAds->groupdisplaytype = $formData['fgroupdisplaytype'];
                            $myAds->groupdisplayorder = $formData['fgroupdisplayorder'];
                            $myAds->linktarget = $formData['flinktarget'];
                            $myAds->isinternal = $formData['fisinternal'];
                            $myAds->payperclick = $formData['fpayperclick'];
                            $myAds->status = $formData['fstatus'];
                            if(!empty($formData['fdatebegin'])) $myAds->datebegin = Helper::strtotimedmy($formData['fdatebegin']);
                            else {
                                $formData['fdatebegin'] = 0;
                                $myAds->datebegin = 0;
                            }

                            if(empty($formData['funlimited'])) $myAds->dateend = Helper::strtotimedmy($formData['fdateend']);
                            else {
                                $formData['fdateend'] = 0;
                                $myAds->dateend = 0;
                            }
                        }
						$myAds->group = (!empty($formData['fgroupmain'])?implode(',', $formData['fgroupmain']):'');
						$myAds->name = $formData['fname'];
						$myAds->link = $formData['flink'];
						$myAds->image = $formData['fimage'];
						$myAds->title = $formData['ftitle'];


                        if($myAds->updateData())
                        {
                            $allChildAds = Core_Ads::getAdss(array('fparent'=>$myAds->id),'','');
                            foreach($allChildAds as $child)
                            {
                                $newAds = new Core_Ads($child->id);
                                $newAds->status = $child->status;
                                $newAds->azid = $child->azid;
                                $newAds->type = $child->type;
                                $newAds->updateData();
                            }

                            $adsSlug =  new Core_AdsSlug();
                            $adsSlug->aid = $myAds->id;
                            if($adsSlug->deleteByAId()>=0)
                            {
                                $slugtmp = $formData['faslug'];
                                $slug = json_decode($slugtmp);
                                foreach($slug as $sl)
                                {
                                    $adsSlug->aid = $myAds->id;
                                    $adsSlug->slug = $sl;
                                    if($adsSlug->addData())
                                    {

                                    }
                                }
                            }

                            $success[] = $this->registry->lang['controller']['succUpdate'];
                            $this->registry->me->writelog('ads_edit', $myAds->id, array());
                        }
                        else
                        {
                            $error[] = $this->registry->lang['controller']['errUpdate'];
                        }
                    }
                }
			}

            if(!empty($_POST['fsubsubmit']))
            {
                $newFormData = $_POST;
                $errorSubForm = $this->addCategoryAajxValidator($newFormData, $error);

                if($errorSubForm)
                {
                    $mysubAds = new Core_Ads();
                    $mysubAds->status = $myAds->status;
                    $mysubAds->azid = $myAds->azid;
                    $mysubAds->type = $myAds->type;
                    $mysubAds->parent = $myAds->id;
                    //$mysubAds->group = $newFormData['fgroup'];
                    $mysubAds->group = (!empty($formData['fgroupmain'])?implode(',', $formData['fgroupmain']):'');
                    $mysubAds->name = $newFormData['fnamesub'];
                    $mysubAds->title = $newFormData['ftitlesub'];
                    $mysubAds->link = $newFormData['flinksub'];
                    $mysubAds->image = $newFormData['fimage'];
                    $mysubAds->datebegin = $myAds->datebegin;
                    $mysubAds->dateend = $myAds->dateend;
                    $mysubAds->addData();
                    //$success[] = $this->registry->lang['controller']['succSubUpdate'];
                    $this->registry->me->writelog('ads_edit', $mysubAds->id, array());
                    header('Location: .');
                }
            }

			$_SESSION['adsEditToken'] = Helper::getSecurityToken();//Tao token moi
			$formData['listprogram'] = Core_Program::getPrograms(array('fenddatenow' => 1),'','');//campaing
			
			$this->registry->smarty->assign(array(	'formData' 	=> $formData,
                                                    'redirectUrl'=> $redirectUrl,
													'newFormData'=> $newFormData,
                                                    'adszoneList'    => Core_AdsZone::getAdsZones(array(), 'id', 'DESC', ''),
													'listCategoryAds'	=> Core_Ads::getAdss(array('fparent' => $myAds->id), 'id', 'DESC', ''),
													'typeList'		=> Core_Ads::getTypeList(),
													'statusList'	=> Core_Ads::getStatusList(),
													'error'		=> $error,
                                                    'success'    => $success,
													'productcategoryList'        => $this->getProductCategoryList(),
													));
			$contents .= $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'edit.tpl');
			$this->registry->smarty->assign(array(
													'pageTitle'	=> $this->registry->lang['controller']['pageTitle_edit'],
													'contents' 			=> $contents));
			$this->registry->smarty->display($this->registry->smartyControllerGroupContainer . 'index.tpl');
		}
		else
		{
			$redirectMsg = $this->registry->lang['controller']['errNotFound'];
			$this->registry->smarty->assign(array('redirect' => $redirectUrl,
													'redirectMsg' => $redirectMsg,
													));
			$this->registry->smarty->display('redirect.tpl');
		}
	}

	function deleteAction()
	{
		$id = (int)$this->registry->router->getArg('id');
		$myAds = new Core_Ads($id);
		if($myAds->id > 0)
		{
			//tien hanh xoa
			if($myAds->delete())
			{
				$redirectMsg = str_replace('###id###', $myAds->id, $this->registry->lang['controller']['succDelete']);
				$allChildAds = Core_Ads::getAdss(array('fparent'=>$myAds->id),'','');
                foreach($allChildAds as $child)
                {
                    $newAds = new Core_Ads($child->id);
                    $newAds->delete();
                }
                $adsslug = new Core_AdsSlug();
                $adsslug->aid = $myAds->id;
                if($adsslug->deleteByAId())
                {
                    //Some thing
                }
				$this->registry->me->writelog('ads_delete', $myAds->id, array());
			}
			else
			{
				$redirectMsg = str_replace('###id###', $myAds->id, $this->registry->lang['controller']['errDelete']);
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

	public function deletebannerajaxAction()
	{
		$id = (int)$_POST['id'];
		$myAds = new Core_Ads($id);
		if($myAds->id > 0)
		{
			if($myAds->delete())
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}

	####################################################################################################
	####################################################################################################
	####################################################################################################

	//Kiem tra du lieu nhap trong form them moi
	private function addActionValidator($formData, &$error)
	{
		$pass = true;
        if($formData['faslug'] == "")
        {
            if($formData['fazid'] == 0)
            {
                $error[] = $this->registry->lang['controller']['errZoneRequired'];
                $pass = false;
            }
        }

		/*if($formData['fdatebegin'] == '')
        {
            $error[] = $this->registry->lang['controller']['errStartdateRequired'];
            $pass = false;
        } */

        if(empty($formData['funlimited']) && $formData['fdateend'] == '')
        {
            $error[] = $this->registry->lang['controller']['errEnddateRequired'];
            $pass = false;
        }

        if(empty($formData['funlimited']) && !empty($formData['fdatebegin']) && !empty($formData['fdateend']))
        {
            $stdate = Helper::strtotimedmy($formData['fdatebegin']);
            $edate = Helper::strtotimedmy($formData['fdateend']);
            if($stdate > $edate)
            {
                $error[] =  $this->registry->lang['controller']['labelstartDateGreaterEnddate'];
                $pass = false;
            }
        }
		if($formData['ftype']!= Core_Ads::TYPE_TEXTONLY )
        {
            if($_FILES['fimage']['name'] == '')
            {
                $error[] = $this->registry->lang['controller']['errFileRequired'];
                $pass = false;
            }
            else
            {
                $ext = strtoupper(Helper::fileExtension($_FILES['fimage']['name']));
                if(!in_array($ext, $this->registry->setting['ads']['imageValidType']))
                {
                    $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
                    $pass = false;
                }
                elseif($_FILES['fimage']['size'] > $this->registry->setting['ads']['imageMaxFileSize'])
                {
                    $error[] = str_replace('###VALUE###', round($this->registry->setting['ads']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
                    $pass = false;
                }
            }
        }


		if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['flink'] == '')
		{
			$error[] = $this->registry->lang['controller']['errLinkRequired'];
			$pass = false;
		}

		return $pass;
	}
	//Kiem tra du lieu nhap trong form cap nhat
	private function editActionValidator($formData, &$error)
	{
		$pass = true;
		if($formData['fparent'] == 0)
        {
            if($formData['faslug'] == "")
            {
                if($formData['fazid'] == 0)
                {
                    $error[] = $this->registry->lang['controller']['errZoneRequired'];
                    $pass = false;
                }
            }

            /*if($formData['fdatebegin'] == '')
            {
                $error[] = $this->registry->lang['controller']['errStartdateRequired'];
                $pass = false;
            } */

            if(empty($formData['funlimited']) && $formData['fdateend'] == '')
            {
                $error[] = $this->registry->lang['controller']['errEnddateRequired'];
                $pass = false;
            }

            if(empty($formData['funlimited']) && !empty($formData['fdatebegin']) && !empty($formData['fdateend']))
            {
                $stdate = Helper::strtotimedmy($formData['fdatebegin']);
                $edate = Helper::strtotimedmy($formData['fdateend']);
                if($stdate > $edate)
                {
                    $error[] =  $this->registry->lang['controller']['labelstartDateGreaterEnddate'];
                    $pass = false;
                }
            }
        }


        if($formData['fname'] == '')
		{
			$error[] = $this->registry->lang['controller']['errNameRequired'];
			$pass = false;
		}

		if($formData['flink'] == '')
		{
			$error[] = $this->registry->lang['controller']['errLinkRequired'];
			$pass = false;
		}

		return $pass;
	}

    private function getProductCategoryList()
    {
        $productcategoryList = array();
        $parentCategory1 = Core_Productcategory::getProductcategorys(array('fstatus' => Core_Productcategory::STATUS_ENABLE), 'parentid', 'ASC');
        for($i = 0 , $counter = count($parentCategory1) ; $i < $counter; $i++)
        {
            if($parentCategory1[$i]->parentid == 0)
            {
                $productcategoryList[] = $parentCategory1[$i];
                $parentCategory2 = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory1[$i]->id), 'displayorder', 'ASC');
                for($j = 0 , $counter1 = count($parentCategory2) ; $j < $counter1 ; $j++)
                {
                    $parentCategory2[$j]->name = '&nbsp;&nbsp;&nbsp;&nbsp;' . $parentCategory2[$j]->name;
                    $productcategoryList[] = $parentCategory2[$j];

                    $subCategory = Core_Productcategory::getProductcategorys(array('fparentid'=>$parentCategory2[$j]->id), 'displayorder', 'ASC');
                    foreach ($subCategory as $sub)
                    {
                        $sub->name = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sub->name;
                        $productcategoryList[] = $sub;
                    }
                }
            }
        }

        return $productcategoryList;
    }

    /*public function addCategoryAdsAjaxAction()
    {
        $formData = $_POST;
        $error = $this->addCategoryAajxValidator($formData);
        $arrError = array();
        if(!empty($error))
        {
            $arrError =
        }
    }*/

    private function addCategoryAajxValidator($formData, &$error)
    {
        $pass = true;

        if($_FILES['fimage']['name'] == '')
        {
            $error[] = $this->registry->lang['controller']['errFileRequired'];
            $pass = false;
        }
        else
        {
            $ext = strtoupper(Helper::fileExtension($_FILES['fimage']['name']));
            if(!in_array($ext, $this->registry->setting['ads']['imageValidType']))
            {
                $error[] = $this->registry->lang['controller']['errFiletypeInvalid'];
                $pass = false;
            }
            elseif($_FILES['fimage']['size'] > $this->registry->setting['ads']['imageMaxFileSize'])
            {
                $error[] = str_replace('###VALUE###', round($this->registry->setting['ads']['imageMaxFileSize'] / 1024 / 1024), $this->registry->lang['controller']['errFilesizeInvalid']);
                $pass = false;
            }
        }

        if($formData['fnamesub'] == '')
        {
            $error[] = $this->registry->lang['controller']['errNamesubRequired'];
            $pass = false;
        }

        if($formData['flinksub'] == '')
        {
            $error[] = $this->registry->lang['controller']['errLinksubRequired'];
            $pass = false;
        }

        return $pass;
    }
    public function getslugajaxAction()
    {
        $formData = array();
        $formData['fcontrollernotin'] = 'news';
        $slug = Core_Slug::getSlugs($formData,'id','DESC');
        $jsonslug = array();
        foreach($slug as $s){
            $js = $s->slug;
            $jsonslug[] = $js;
        }
        //echodebug($jsonslug);
        echo json_encode($jsonslug);
    }
    public function getslugajaxbyidAction()
    {
        $id = $_GET['id'];
        $formData = array();
        $formData['faid'] = $id;

        $adsslug = Core_AdsSlug::getAdsSlugs($formData,'id','ASC');

        $jsonslug = array();
        if(count($adsslug) > 0)
        {
            foreach($adsslug as $s){
                $js = $s->slug;
                $jsonslug[] = $js;
            }
            echo json_encode($jsonslug);
        }
    }
}

