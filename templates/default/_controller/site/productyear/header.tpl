<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Product of the year</title>

<meta property="og:site_name" content="{$conf.rooturl}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{$conf.rooturl}product-of-the-year" />
<meta property="og:image"
	content="https://ecommerce.kubil.app/templates/default/images/site/banner-top.jpg" />
<meta property="og:title" content="{if !empty($article->title)}{$article->title}{else}Product of the year{/if}" />
<meta property="og:description"
	content="{if !empty($article->content)}{$article->content}{else}Hãy cùng tham gia chương trình Product of the year để nhận những phần quà hấp dẫn vào dịp cuối năm này. Bài viết hay nhất , người chia sẻ chương trình nhiều nhất, bài viết được người chơi yêu thích nhất sẽ được trao thưởng{/if}" />


<link type="text/css" rel="stylesheet" href="{$currentTemplate}/min/?g=css&ver={$setting.site.cssversion}" media="screen" />
<link href="{$currentTemplate}css/site/style_topproduct.css" rel="stylesheet" type="text/css">
<script src="{$currentTemplate}/js/jquery.js"></script>

<script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var pathImage360 = "{$pathimage360}";
		var numImage360 = "{$numimage360}";
		var imageDir = "{$imageDir}";
</script>
</head>

<body>
<div class="wrap-topproduct">
	<div class="row-top ">
    	<div class="row-main "><a href="{$conf.rooturl}"> <img class="logo-top" src="{$currentTemplate}images/site/logo-top.jpg"></a>
        </div>
    </div>
    <div class="banner-Top">
    	<a href="{$conf.rooturl}product-of-the-year"> <img src="{$currentTemplate}images/site/banner-top.jpg"></a>
    
    </div>
    
    <div class="row-content">
    	<div class="bg-main">
        	<div class="row-main">
                <div class="blue-box">
                    <div class="yellow-bg">
                    	<div class="col">
                        {if !empty($user_profile)}
                        	<h5>Xin chào bạn</h5>
                            <div class="user-login">
                            	<div class="ava-login"><img width="32" src="{$user_profile['avatar']}"></div>
                                <div class="user">{$user_profile['name']}<br/><a href="{$conf.rooturl}productyear/logout">Thoát</a></div>
                                
                            </div>
                        {else}
                        <h4>Đăng nhập để viết bài đánh giá</h4>
                            <div class="buton-log">
                            	<a href="{$conf.rooturl}productyear/loginfacebook"><img src="{$currentTemplate}images/site/bt-face.png"></a>
                            </div>
                            <div class="buton-log">
                            	<a href="{$conf.rooturl}productyear/logingoogle"><img src="{$currentTemplate}images/site/bt-gg.png"></a>
                            </div>
                        {/if}
                        </div>
                      
                        <div class="col2">
<!--                        	<input class="input-s" placeholder="Nhập từ khóa bạn muốn tìm kiếm">-->
<!--                            <input class="bt-s" type="button" value="Tìm Kiếm" >-->
                             <input style="padding:10px" onclick="showrule()" class="bt-x" type="button" value="Xem thể lệ">
                        </div>
                        <div class="col3">
                        	<h1>Chia sẻ</h1>
                            <div class="block-ico">
                            	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$conf.rooturl}product-of-the-year"><img src="{$currentTemplate}images/site/ico-face.png"></a>
                                <a target="_blank" href="https://plus.google.com/share?url={$conf.rooturl}product-of-the-year"><img src="{$currentTemplate}images/site/ico-gg.png"></a>
                                <div class="likefb"><iframe src="http://www.facebook.com/plugins/like.php?href= &width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:120px; height:21px; float:left" class="likepage"></iframe>
           						 </div>
                            </div>
                        </div>
                    </div>
                     <div class="space"></div>