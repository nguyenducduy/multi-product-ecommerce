<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:48
         compiled from "templates/default/_controller/site/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20169546085e8ec2bcbe9419-64541677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea5e4eb531c2fc175743bba5d5be10ef62e9150b' => 
    array (
      0 => 'templates/default/_controller/site/header.tpl',
      1 => 1586406170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20169546085e8ec2bcbe9419-64541677',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escapequote')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escapequote.php';
if (!is_callable('smarty_modifier_regex_replace')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.regex_replace.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($_smarty_tpl->getVariable('pageTitle')->value!=''){?><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
 - <?php echo $_smarty_tpl->getVariable('setting')->value['site']['heading'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('setting')->value['site']['defaultPageTitle'];?>
<?php }?></title>
<meta name="keywords" content="<?php echo smarty_modifier_escapequote((($tmp = @$_smarty_tpl->getVariable('pageKeyword')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('setting')->value['site']['defaultPageKeyword'] : $tmp));?>
" />
<meta name="description" content="<?php echo smarty_modifier_escapequote((($tmp = @$_smarty_tpl->getVariable('pageDescription')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('setting')->value['site']['defaultPageDescription'] : $tmp));?>
" />
<meta name="robots" content="<?php if (!empty($_smarty_tpl->getVariable('pageMetarobots',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('pageMetarobots')->value;?>
<?php }else{ ?>index, follow<?php }?>"/>
<?php if ($_smarty_tpl->getVariable('discount')->value==1){?>
<meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/discountproduct/imgfbbacktoschool.png"/>
<?php }elseif(!empty($_smarty_tpl->getVariable('smallproductdetail',null,true,false)->value)){?>
<meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('smallproductdetail')->value;?>
"/>
<?php }?>
<?php if (!empty($_smarty_tpl->getVariable('pageCanonical',null,true,false)->value)){?>
<link rel="canonical" href="<?php echo $_smarty_tpl->getVariable('pageCanonical')->value;?>
"/>
<?php }?>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/min/?g=css" media="screen" />
<script src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/js/jquery.js"></script>

<script type="text/javascript">
		var rooturl = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
";
		var rooturl_profile = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
";
		var pathImage360 = "<?php echo $_smarty_tpl->getVariable('pathimage360')->value;?>
";
		var numImage360 = "<?php echo $_smarty_tpl->getVariable('numimage360')->value;?>
";
		var imageDir = "<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
";
		var hideMenu = "<?php if (!empty($_smarty_tpl->getVariable('hideMenu',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('hideMenu')->value;?>
<?php }?>";
		var ispriceajax = <?php echo $_smarty_tpl->getVariable('setting')->value['site']['isajaxprice'];?>
;
</script>
</head>

<body>
<div id="header">
<div class="rowheader">
    	<ul>
        	<li><a href="#">Hỏi đáp - hỗ trợ khách hàng</a> 111|</li>
            <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
account/checksaleorder">Kiểm tra đơn hàng</a> |</li>
            <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
account/detail">Tài khoản cá nhân</a> <span>|</span></li>
            <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
thanh-vien/dang-ky">Đăng ký</a> |</li>
            <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
login">Đăng nhập</a></li>
        </ul>
    </div>
	<h1 class="logo"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
" title="Siêu thị điện máy dienmay.com"><img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/logo-dien-may.png" width="200" height="63" alt="Siêu thị điện máy dienmay.com - Mua bán điện thoại, laptop, tivi, điện lạnh, điện tử, đồ gia dụng, điện máy chính hãng giá rẻ" /></a></h1>
	<div class="headsearch">
	  <div class="topinput">
	        <form action="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
search" method="get" id="searchtopform">
	        	<!-- <input type="hidden" name="c" value="0" /> -->
	        	<input class="textfieldtop" name="q" id="fsitebooksearchtext" type="text" value="<?php echo $_smarty_tpl->getVariable('formData')->value['q'];?>
" placeholder="Tìm kiếm hơn 2800 sản phẩm chất lượng tại dienmay.com" onkeypress="doSitebooksearchtextpress(event)" />
	        	<input class="btnsearch go" type="submit" value="Tìm kiếm" />
	        </form>
	    </div>
	    <div class="keysearch"><span>Tìm nhiều nhất:</span>
	    	<?php if (!empty($_smarty_tpl->getVariable('headertext',null,true,false)->value)){?>
	    		<?php echo smarty_modifier_regex_replace($_smarty_tpl->getVariable('headertext')->value,"/(<p>|<p [^>]*>|<\\/p>)/",'');?>

		    <?php }elseif(!empty($_smarty_tpl->getVariable('footerheadertext',null,true,false)->value['search'])){?>
		        <?php echo smarty_modifier_regex_replace($_smarty_tpl->getVariable('footerheadertext')->value['search']->content,"/(<p>|<p [^>]*>|<\\/p>)/",'');?>

		    <?php }?>
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
                            <form id="loginBanner" action="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
login/index/" method="post" >
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
                            <a class="regrowlink" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
thanh-vien/dang-ky">Đăng ký /</a><a class="regrowlink"  href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
thanh-vien/quen-mat-khau">Quên mật khẩu</a>
                            <div class="clear"></div>
                            <a href="#">Tài khoản của tôi</a>
                            <div class="clear"></div>
                            <a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
account/checksaleorder">Kiểm tra đơn hàng</a>
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
                	<!-- <iframe src="http://www.facebook.com/plugins/like.php?href=https://www.facebook.com/dienmaycom&width=200&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe> -->
    </div>
    <div style="clear:both"></div>
  </div>
</div>

<div id="nav-main" class="<?php if (!empty($_smarty_tpl->getVariable('hideMenu',null,true,false)->value)){?>showhide<?php }?>">
<?php echo $_smarty_tpl->getVariable('footerheadertext')->value['menu']->content;?>

</div>

