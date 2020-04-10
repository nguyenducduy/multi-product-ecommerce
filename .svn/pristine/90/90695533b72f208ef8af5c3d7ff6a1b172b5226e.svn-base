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
#footer{width:960px; margin:auto; padding-top:10px;}
#footer img{float:left; width:150px; height:30px;}
#footer ul{text-align:right; padding-top:8px;}
#footer li{display:inline; list-style-type:none;}
#footer a, #footer{text-decoration:none; color:#cfcfcf;}
#footer a:hover{text-decoration:underline;}
#form{background:#6c6c6c; width: 290px; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px; -moz-box-shadow: 0px 0px 10px #ccc;
  -webkit-box-shadow: 0px 0px 10px #ccc;
  box-shadow: 0px 0px 10px #555; float:right;
}
.loginlabeltitle{width:230px; margin-left:30px; font-size: 14px; color:#fff; padding:10px 0 5px 0; display:block}
#femail, #fpassword{width:210px; border-width:0; background:#fff; display:block; margin-left:30px; padding:10px; font-size:14px; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px;}
#frememberme{float:left;}
#loginfunction{padding:10px 30px 70px 30px; color:#fff;}
#loginfunction label{padding:4px 0 0 4px;}
#loginbutton{float:right; width:130px; height:30px; line-height:30px; font-size: 18px; font-weight:bold; color:#fff; border-width:0;background:#b4b4b4; cursor:pointer; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px;}
#loginbutton:hover{background:#ccc}
#loginoauth{background:#aaaaaa; height:40px; margin-top:20px;}
#loginoauth label{float:left; padding:12px 0 0 30px; color:#5f5f5f;}
#loginoauth{margin-top:10px;}
#loginoauth a{color:#fff; text-decoration:none;}

#register{text-align:center;padding:20px 0 20px 0;}
#register label{padding-bottom:5px; color:#fff;}


{/literal}
</style>
</head>

<body>
	<div id="wrapper">
		<div id="left">
			<h1>{$lang.controller.heading}</h1>
			<h2>{$lang.controller.tagline} <a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}">{$lang.controller.start}</a></h2>
			<div id="homepage">
				<a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img src="{$imageDir}homepage/banner.jpg" border="0" width="570" height="360" /></a>
			</div>
		</div>
		
		<div id="right">
			<div id="form">
				<form method="post" action="{$conf.rooturl}login">
					<h3>{$lang.controller.formHeading}</h3>
					<label for="femail" class="loginlabeltitle">{$lang.controller.email}</label>
					<input type="text" name="femail" id="femail" />
					<label for="fpassword" class="loginlabeltitle">{$lang.controller.password}</label>
					<input type="password" name="fpassword" id="fpassword" />
					<div id="loginfunction">
						<input type="checkbox" name="frememberme" id="frememberme" value="1" />
						<label for="frememberme">{$lang.controller.rememberme}</label>
						<input id="loginbutton" type="submit" name="fsubmit" value="{$lang.controller.loginButton}" />
					</div>
					<div style="clear:both"></div>
					<div id="loginoauth">
						<label><a href="{$conf.rooturl}login" title="{$lang.controller.oauthHelp}">{$lang.controller.loginoauth}</a></label>
						
					</div>
					<div id="register">
						<label id="registerlabel">{$lang.controller.registerLabel}</label>
						<a id="registerbutton" href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img src="{$imageDir}homepage/registerbtn.png" alt="{$lang.default.mRegister}" /></a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<div id="footerplaceholder"></div>
	
	<div id="wrapperfoot">
		<div id="footer">
			<img src="{$imageDir}homepage/logo.png" />
			<ul>
				<li><a href="{$conf.rooturl}login" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a> &middot;</li>
				<li><a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}">{$lang.default.mRegister}</a> &middot;</li>
				<li><a href="{$conf.rooturl}forgotpass" title="{$lang.default.mForgotpassTitle}">{$lang.default.mForgotpass}</a> &middot;</li>
            	<li><a href="{$conf.rooturl}contact" title="{$lang.default.mContactTitle}">{$lang.default.mContact}</a> &middot;</li>
				<li>2011 &copy; Reader.vn</li>
			</ul>
		</div>
	</div>

	{literal}
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
		document.getElementById("femail").focus();
		$(document).ready(function()
		{
			//preload sprite
			var spriteurl = "{/literal}{$imageDir}sprite.png{literal}";
			$("#wrapper").append('<img src="'+spriteurl+'" style="display:none;" />');
		});
	</script>
	{/literal}
	
	
	{include file="googleanalytic.tpl"}
</body>
</html>
