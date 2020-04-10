<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="{$conf.rooturl}favicon.ico"/>
<title>{$setting.site.defaultPageTitle}</title>
<meta name="author" content="Vo Duy Tuan, tuanmaster2002@yahoo.com" />
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription}" />
<link rel="image_src" href="{$imageDir}site-logo-preview.jpg" />
<style type="text/css">
{literal}
*{margin:0; padding:0;}
body{background:url({/literal}{$imageDir}pagebar.jpg{literal}) repeat-x; font-family:"Segoe UI", Tahoma, Geneva, sans-serif; font-size:11px;}
h1{font-weight:bold; color:#1a95fe; font-size:24px; margin-bottom:7px;}
h2{font-size:18px; color:#818181; font-weight:normal; line-height:1.5;}
h2 a{background:#aaa; font-size:11px; padding:3px 8px; color:#fff; text-decoration:none; -moz-border-radius:6px;border-radius:6px;-webkit-border-radius:6px; }
h2 a:hover{background:#1a95fe}
h3{font-size:20px; font-weight:bold; color:#fff; padding: 20px 0 10px 0; text-align:center; border-bottom:1px solid #777; margin:0 30px 10px 30px}
img{border-width:0;}
.cl{clear:both;}
#wrapper{width:960px; margin:auto; margin-top:40px;}
#left{width:640px; float:left;}
#right{padding-top:40px;}
#homepage{padding-top:30px;}

#right{width:320px; float:right;}
#footerplaceholder{height:60px; clear:both;}
#wrapperfoot{clear:both; position:fixed; bottom:0; width:100%; height:50px; background:#333;}

#footer{width:960px; margin:auto; padding-top:12px;}
#footer ul{text-align:right;}
#footer li{float:left; list-style-type:none;}
#footer li a{font-family:"Trebuchet MS", Arial, Helvetica, sans-serif}
#footer a, #footer{text-decoration:none; color:#fff; }
#footer a{ font-size:16px; padding:3px 9px; margin-right:5px; -moz-border-radius:8px;border-radius:4px;-webkit-border-radius:4px;background:#333;}
#footer a:hover{background:#1A95FE}

#form{background:#6c6c6c; width: 290px; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px; -moz-box-shadow: 0px 0px 10px #ccc;
  -webkit-box-shadow: 0px 0px 10px #ccc;
  box-shadow: 0px 0px 10px #555; float:right;
}
.loginlabeltitle{width:230px; margin-left:30px; font-size: 12px; color:#fff; padding:10px 0 5px 0; display:block}
#ffullname,#femail, #fpassword1, #fpassword2{width:220px; border-width:0; background:#fff; display:block; margin-left:30px; padding:5px; font-size:12px;}
#loginbox{ margin:0 30px 0px 30px; padding:10px 0;}
#loginbox p{text-align:center; height:30px;}
#loginbox a{color:#fff; text-decoration:none;}
#loginbox .login{float:left;}
#loginbox .forgot{float:right;}
#register{text-align:center;padding:20px 0 20px 0;}
#register label{padding-bottom:5px; color:#fff;}


{/literal}
</style>
</head>

<body>
	<div id="wrapper">
		<div id="left">
			<h1>{$lang.controller.heading}</h1>
			<h2>{$lang.controller.tagline} <a href="{$conf.rooturl}?start">{$lang.controller.start}</a></h2>
			<div id="homepage">
				<a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img src="{$imageDir}homepage/banner.jpg" border="0" width="570" height="360" /></a>
			</div>
		</div>
		
		<div id="right">
			<div id="form">
				<form method="post" action="{$conf.rooturl}register" onsubmit="return validateform();">
					<input type="hidden" name="ftoken" value="###TOKEN###" />
					<input type="hidden" name="fsubmit" value="1" />
					<input type="hidden" name="ftos" value="1" />
					<h3>{$lang.controller.formHeading}</h3>
					<label for="ffullname" class="loginlabeltitle">{$lang.controller.fullname}</label>
					<input type="text" name="ffullname" id="ffullname" />
					<label for="femail" class="loginlabeltitle">{$lang.controller.email}</label>
					<input type="text" name="femail" id="femail" />
					<label for="fpassword1" class="loginlabeltitle">{$lang.controller.password}</label>
					<input type="password" name="fpassword1" id="fpassword1" />
					<label for="fpassword2" class="loginlabeltitle">{$lang.controller.password2}</label>
					<input type="password" name="fpassword2" id="fpassword2" />
					
					<div style="text-align:center; margin-top:10px;">
						<input type="image" src="{$imageDir}homepage/registerbtn.png" style="margin" />
					</div>
					
					<div style="clear:both"></div>
					<div id="loginbox">
						<p><a class="login" href="{$conf.rooturl}login" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a>
						<a class="forgot" href="{$conf.rooturl}forgotpass" title="{$lang.default.mForgotpassTitle}">{$lang.default.mForgotpass}</a>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<div id="footerplaceholder"></div>
	
	<div id="wrapperfoot">
		<div id="footer">
			<ul>
				<li><a href="{$conf.rooturl}login" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a></li>
				<li><a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}">{$lang.default.mRegister}</a></li>
				<li><a href="{$conf.rooturl}book" title="{$lang.default.mBookTitle}">{$lang.default.mBook}</a></li>
				<li><a href="{$conf.rooturl}review" title="{$lang.default.mReviewTitle}">{$lang.default.mReview}</a></li>
				<li><a href="{$conf.rooturl}hot" title="{$lang.default.mHotTitle}">{$lang.default.mHot}</a></li>
				<li><a href="{$conf.rooturl}quote" title="{$lang.default.mQuoteTitle}">{$lang.default.mQuote}</a></li>
				<li><a href="{$conf.rooturl}shop" title="{$lang.default.mShopTitle}">{$lang.default.mShop}</a></li>
				<li><a href="{$conf.rooturl}member" title="{$lang.default.mMemberTitle}">{$lang.default.mMember}</a></li>
				<li><a href="{$conf.rooturl}shelf" title="{$lang.default.mShelfTitle}">{$lang.default.mShelf}</a></li>
			</ul>
		</div>
	</div>

	{literal}
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		document.getElementById("ffullname").focus();
		$(document).ready(function()
		{
			//preload sprite
			var spriteurl = "{/literal}{$imageDir}sprite.png{literal}";
			$("#wrapper").append('<img src="'+spriteurl+'" style="display:none;" />');
		});
		
		function validateform()
		{
			if($('#ffullname').val() == '')
			{
				alert('Bạn chưa nhập Họ tên');
				$('#ffullname').focus();
				return false;
			}
			else if($('#femail').val() == '')
			{
				alert('Bạn chưa nhập địa chỉ Email');
				$('#femail').focus();
				return false;
			}
			else if($('#fpassword1').val() == '')
			{
				alert('Bạn chưa nhập mật khẩu');
				$('#fpassword1').focus();
				return false;
			}
			else if($('#fpassword1').val() != $('#fpassword2').val())
			{
				alert('Mật khẩu nhập không giống nhau. Hãy kiểm tra lại.');
				$('#fpassword2').focus();
				return false;
			}
			
			return true;
		}
	</script>
	{/literal}
	
	
	{include file="googleanalytic.tpl"}
</body>
</html>
