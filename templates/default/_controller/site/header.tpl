<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $pageTitle != ''}{$pageTitle} - {$setting.site.heading}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword|escapequote}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription|escapequote}" />
<meta name="robots" content="{if !empty($pageMetarobots)}{$pageMetarobots}{else}index, follow{/if}"/>
{if $discount ==1}
<meta property="og:image" content="{$currentTemplate}images/discountproduct/imgfbbacktoschool.png"/>
{elseif !empty($smallproductdetail)}
<meta property="og:image" content="{$smallproductdetail}"/>
{/if}
{if !empty($pageCanonical)}
<link rel="canonical" href="{$pageCanonical}"/>
{/if}
<link type="text/css" rel="stylesheet" href="{$currentTemplate}/min/?g=css" media="screen" />
<script src="{$currentTemplate}/js/jquery.js"></script>

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
<div id="header">
<div class="rowheader">
    	<ul>
        	<li><a href="#">Hỏi đáp - hỗ trợ khách hàng</a> 111|</li>
            <li><a href="{$conf.rooturl}account/checksaleorder">Kiểm tra đơn hàng</a> |</li>
            <li><a href="{$conf.rooturl}account/detail">Tài khoản cá nhân</a> <span>|</span></li>
            <li><a href="{$conf.rooturl}thanh-vien/dang-ky">Đăng ký</a> |</li>
            <li><a href="{$conf.rooturl}login">Đăng nhập</a></li>
        </ul>
    </div>
	<h1 class="logo"><a href="{$conf.rooturl}" title="Siêu thị điện máy dienmay.com"><img src="{$currentTemplate}images/site/logo-dien-may.png" width="200" height="63" alt="Siêu thị điện máy dienmay.com - Mua bán điện thoại, laptop, tivi, điện lạnh, điện tử, đồ gia dụng, điện máy chính hãng giá rẻ" /></a></h1>
	<div class="headsearch">
	  <div class="topinput">
	        <form action="{$conf.rooturl}search" method="get" id="searchtopform">
	        	<!-- <input type="hidden" name="c" value="0" /> -->
	        	<input class="textfieldtop" name="q" id="fsitebooksearchtext" type="text" value="{$formData.q}" placeholder="Tìm kiếm hơn 2800 sản phẩm chất lượng tại dienmay.com" onkeypress="doSitebooksearchtextpress(event)" />
	        	<input class="btnsearch go" type="submit" value="Tìm kiếm" />
	        </form>
	    </div>
	    <div class="keysearch"><span>Tìm nhiều nhất:</span>
	    	{if !empty($headertext)}
	    		{$headertext|regex_replace:"/(<p>|<p [^>]*>|<\\/p>)/":""}
		    {elseif !empty($footerheadertext.search)}
		        {$footerheadertext.search->content|regex_replace:"/(<p>|<p [^>]*>|<\\/p>)/":""}
		    {/if}
	    </div>
	</div>
  <div class="headerright">
  	<div class="headnewnav">
    	<ul>
        	<li id="showcartpopup">
        	<a class="first-child" href="#"><i class="icon-cartnew"></i>Giỏ hàng <span class="numbercartnew">(0)</span> <span class="arrheadnav"></span></a>

            </li>
            <li id="loginform">
            <a class="usernew-login" href="#"><i class="icon-usernew"></i>Đăng nhập <span class="smalltext">Tài khoản, đơn hàng</span> <span class="arrheadnav"></span></a>
            	<div class="subnavhead">
                	<span class="arrsubnav"></span>
                    <ul>
                        <li><strong>Thông tin đăng nhập</strong>
                            <form id="loginBanner" action="{$conf.rooturl}login/index/" method="post" >
                                <div class="rowinputnew"><span><i class="icon-usernews"></i></span>
                                <input class="inputnew" name="fuser" type="text" placeholder="Email hoặc số điện thoại" />
                                </div>
                                <div class="rowinputnew"><span><i class="icon-keynew"></i></span>
                                <input class="inputnew" name="fpassword" type="password" placeholder="Mật khẩu" />
                                </div>
                                <div class="rowinputnew">
                                    <div class="checkhnew"><label><input class="homeremember" name="frememberme" checked="checked" type="checkbox" value="1" />Nhớ tôi trên máy tính này</label></div>
                                    <input class="btnlognew" type="submit" value="Đăng nhập" id="btnloginheader" />
                                </div>
                                <input name="action" type="hidden" value="login">
                            </form><!--
                            <p> Bạn đã từng mua hàng tại dienmay.com và chưa có tài khoản ?</p>
                            <div class="rowinputnew"><a class="inline" href="#inline_content">Tạo tài khoản tại dienmay.com ngay</a></div>
                            --><!-- Content popup -->
                            <div style="display:none;">
                                <div id="inline_content" class="inlinepopup">
                                <div class="rowinputnew2">Đăng ký thành viên dienmay.com</div>
                                <p><strong>Bạn vui lòng nhập số điện thoại đã mua hàng tại siêu thị dienmay.com, chúng tôi sẽ gửi mật khẩu cho bạn qua tin nhắn</strong></p>

                                <form action="" method="post">
                                    <input id="fphone" class="inputnew2" name="fphone" maxlength="12" type="text" placeholder="Nhập số điện thoại" />
                                    <input onclick="processSms()" class="btnlognew2" name="subfphone" type="button" value="Lấy mật khẩu" />
                                </form>

                                </div>

                            </div>
                             <!-- End content popup -->
                        </li>
                        <li>
                            <a class="regrowlink" href="{$conf.rooturl}thanh-vien/dang-ky">Đăng ký /</a><a class="regrowlink"  href="{$conf.rooturl}thanh-vien/quen-mat-khau">Quên mật khẩu</a>
                            <div class="clear"></div>
                            <a href="#">Tài khoản của tôi</a>
                            <div class="clear"></div>
                            <a href="{$conf.rooturl}account/checksaleorder">Kiểm tra đơn hàng</a>
                        </li>
                        <li><a href="#">Chính sách sử dụng thông tin tại dienmay.com</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <!-- hotline -->
    <div class="hotlinehead"><strong>Hotline:</strong> <span>1800 1061</span></div>
    <div class="headlike" id="facebook-headlike">
                	<!-- <iframe src="https://www.facebook.com/plugins/like.php?href= &width=200&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe> -->
    </div>
    <div style="clear:both"></div>
  </div>
</div>

<div id="nav-main" class="{if !empty($hideMenu)}showhide{/if}">
{$footerheadertext.menu->content}
</div>

