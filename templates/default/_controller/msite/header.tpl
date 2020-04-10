<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1,initial-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $pageTitle != ''}{$pageTitle} - {$setting.site.heading}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription|escapequote}" />
<meta name="robots" content="noindex, nofollow"/>
{if $discount ==1}
<meta property="og:image" content="{$currentTemplate}images/discountproduct/imgfbbacktoschool.png"/>
{/if}
{if !empty($pageCanonical)}
    <link rel="canonical" href="{$pageCanonical|replace:'//m.':'//'}"/>
{/if}
<link type="text/css" rel="stylesheet" href="{$currentTemplate}mdienmay.css?ver={$setting.site.cssversion}" media="screen" /> 
<script>
document.write('<script src=' +
('__proto__' in {} ? '{$currentTemplate}js/msite/zepto.min' : '{$currentTemplate}js/msite/jquery-1.10.1') +
'.js><\/script>');
</script>
<script type="text/javascript">

    var rooturl = "{$conf.rooturl}";
    var rooturl_profile = "{$conf.rooturl_profile}";
    var pathImage360 = "{$pathimage360}";
    var numImage360 = "{$numimage360}";
      var imageDir = "{$imageDir}";
        var hideMenu = "{if !empty($hideMenu)}{$hideMenu}{/if}";
    var ispriceajax = {$setting.site.isajaxprice};
       
</script>

</head>

<body>
<section>
<!-- Header -->
    <header id="top">
        <div class="headbar">
            {if strpos(Helper::curPageURL(),'index/menu') == false}<div class="btnnav"><a href="{$registry->conf.rooturl}index/menu{if $smarty.get.pcid > 0}?active={$smarty.get.pcid}{/if}"><i class="icon-navi"></i></a></div>{/if}
            <h1><a href="{$registry->conf.rooturl}" title="Siêu thị điện máy dienmay.com"><img src="{$currentTemplate}images/msite/logo-dien-may.png" alt="Siêu thị điện máy dienmay.com - Mua bán điện thoại, laptop, tivi, điện lạnh, điện tử, đồ gia dụng, điện máy chính hãng giá rẻ"></a></h1>
            <!-- user, Cart -->
            <div class="headright">
                <div class="iconuser">
                    <a href="{$conf.rooturl}account/info"><i class="icon-user"></i></a>
                </div>
                <!-- giỏ hàng -->
                <div class="iconcart">
                    <div style="display:none" class="cart-info-hd">

                    </div>
                    <a href="{$registry->conf.rooturl}cart/checkout/"><i class="icon-cart"></i><span class="numbercartnewinfo">0</span></a>
                </div>
            </div>
        <div class="clearfix"></div>
        </displayiv>
        <!-- search -->
   
        <div class="search">
              <form action="{$conf.rooturl}search" method="get" id="searchtopform">
                <!-- <input type="hidden" name="c" value="0" /> -->
                <input class="textfieldtop textinput" name="q" id="fsitebooksearchtext" type="text" value="{$formData.q}" placeholder="Nhập từ khóa cần tìm" onkeypress="doSitebooksearchtextpress(event)" />
                <button class="btnsearch go" type="submit" >
                <i class="icon-search"></i>
              </button>
            </form>
        </div>
        
     <div class="clearfix"></div>
    </header>