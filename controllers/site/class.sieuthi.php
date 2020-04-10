<?php

Class Controller_Site_Sieuthi Extends Controller_Site_Base
{
    public function indexAction()
    {
        $subdomain = '';
        if(SUBDOMAIN == 'm')
            $subdomain = SUBDOMAIN;
        $cachefile = $subdomain.'sitehtml_danhsachsieuthi';
        $myCache = new Cacher($cachefile);
        $pageHtml = '';
        if(isset($_GET['customer']) || isset($_GET['live'])){
            $myCache->clear();
        }
        else
            $pageHtml = $myCache->get();
        if(!$pageHtml)
        {
            $liststores = null;
            $listnewregion = null;
            $listregionid = array();
            $configStores = array();
            $configStores['fstatus'] = Core_Store::STATUS_ENABLE;
            $configStores['fissalestore'] = 1;
            $configStores['fisautostorechange'] = 1;
            $liststores = Core_Store::getStores($configStores,'name','ASC');
            $liststoresnew = array();
            foreach($liststores as $st)
            {
            	if ($st->id == 919) continue;
                //$st->slug = Helper::codau2khongdau($st->name, true, true);
            	//$st->updateData();
                if($st->lng !=0 && $st->lat !=0)
                {
                    if(!in_array($st->region, $listregionid))
                    {
                        $listregionid[] = $st->region;
                    }
                }
                $liststoresnew[] = $st;
            }
            if(!empty($listregionid))
            {
                $listregion = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                if(!empty($listregion))
                {
                    foreach($listregion as $regid)
                    {
                        $listnewregion[$regid->id] = $regid;
                    }
                }
            }
            $this->registry->smarty->assign( array(
                'listregions' => $listnewregion,
                'liststores' => $liststoresnew,
                //'hideMenu' => 1,
            ) );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'liststores.tpl');

            $this->registry->smarty->assign(array(
                'pageTitle' => 'Hệ thống siêu thị dienmay.com',
                'pageKeyword' => 'Tìm siêu thị, hệ thống siêu thị, siêu thị',
                'pageDescription' => 'Hệ thống siêu thị dienmay.com',
                'contents' => $contents,
                )
            );

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');

            $myCache->set($pageHtml);
        }
        echo $pageHtml;
    }

    public function regionAction(){

        $regionID = $_GET['id'];
        $cachefile = 'sitehtml_region_' . $regionID;
        $myCache = new Cacher($cachefile);
        $pageHtml = '';
        if(isset($_GET['customer']) || isset($_GET['live'])){
            $myCache->clear();
        }
        else
            $pageHtml = $myCache->get();
        if(!$pageHtml)
        {
            $currentregion = null;
            $liststores = null;
            $listnewregion = null;
            $listregionid = array();
            $configStores = array();
            $configStores['fstatus'] = Core_Store::STATUS_ENABLE;
            $configStores['fissalestore'] = 1;
            $configStores['fisautostorechange'] = 1;
            $liststores = Core_Store::getStores($configStores,'name','ASC');
            foreach($liststores as $st)
            {
                if($st->lng !=0 && $st->lat !=0)
                {
                    if(!in_array($st->region, $listregionid))
                    {
                        $listregionid[] = $st->region;
                    }
                }
            }
            if(!empty($listregionid))
            {
                $listregion = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                if(!empty($listregion))
                {
                    foreach($listregion as $regid)
                    {
                        $listnewregion[$regid->id] = $regid;
                        if($regionID == $regid->id)
                            $currentregion = $regid;
                    }

                }
            }
            $this->registry->smarty->assign( array(
                'regionid' => $regionID,
                'listregions' => $listnewregion,
                'liststores' => $liststores,
                'region'     => $currentregion,

            ) );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'region.tpl');

            $this->registry->smarty->assign(array(
                    'pageTitle' => 'Hệ thống siêu thị dienmay.com',
                    'pageKeyword' => 'Tìm siêu thị, hệ thống siêu thị, siêu thị',
                    'pageDescription' => 'Hệ thống siêu thị dienmay.com',
                    'contents' => $contents,
                )
            );

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);

        }
        echo $pageHtml;

    }

    public function detailAction(){

        $sid = $_GET['id'];
        $cachefile = 'sitehtml_store_' . $sid;
        $myCache = new Cacher($cachefile);
        $pageHtml = '';
        if(isset($_GET['customer']) || isset($_GET['live'])){
            $myCache->clear();
        }
        else
            $pageHtml = $myCache->get();

        if(!$pageHtml)
        {

            $currentstore = array();
            $currentregion = null;
            $liststores = null;
            $listnewregion = null;
            $listregionid = array();
            $configStores = array();
            $configStores['fstatus'] = Core_Store::STATUS_ENABLE;
            $configStores['fissalestore'] = 1;
            $configStores['fisautostorechange'] = 1;
            $liststores = Core_Store::getStores($configStores,'name','ASC');
            foreach($liststores as $st)
            {
                if($st->lng !=0 && $st->lat !=0)
                {
                    if(!in_array($st->region, $listregionid))
                    {
                        $listregionid[] = $st->region;
                    }
                    if($st->id == $sid){
                        $currentstore = $st;
                    }
                }
            }
            if(!empty($listregionid))
            {
                $listregion = Core_Region::getRegions(array('fidarr'=>$listregionid),'name','ASC');
                if(!empty($listregion))
                {
                    foreach($listregion as $regid)
                    {
                        $listnewregion[$regid->id] = $regid;
                    }
                }
            }

            $this->registry->smarty->assign( array(
                    'store' => $currentstore,
                    'listregions' => $listnewregion,
                    'liststores' => $liststores,

            ) );

            $contents = $this->registry->smarty->fetch($this->registry->smartyControllerContainer.'store.tpl');

            $this->registry->smarty->assign(array(
                    'pageTitle' => 'Hệ thống siêu thị dienmay.com',
                    'pageKeyword' => 'Tìm siêu thị, hệ thống siêu thị, siêu thị',
                    'pageDescription' => 'Hệ thống siêu thị dienmay.com',
                    'contents' => $contents,
                )
            );

            $pageHtml = $this->registry->smarty->fetch($this->registry->smartyControllerGroupContainer.'index.tpl');
            $myCache->set($pageHtml);

        }
        echo $pageHtml;
    }


}