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
body{background:url({/literal}{$imageDir}pagebar.jpg{literal}) repeat-x;  font-family:Tahoma, Geneva, sans-serif; font-size:12px;}
h1{font-weight:bold; color:#1a95fe; font-size:24px; margin-bottom:7px;}
h2{font-size:18px; color:#818181; font-weight:normal; line-height:1.5;}
h3{font-size:20px; font-weight:bold; color:#fff; padding: 20px 0 10px 0; text-align:center;}
img{border-width:0;}
.cl{clear:both;}
.sp{background:url({/literal}{$imageDir}homepage/homesprite.png{literal})}
#wrapper{width:900px; margin:auto; margin-top:40px;}
#left{width:580px; float:left;}
#homepage{padding-top:30px;}
#canvaswrapper{width:190px; height:290px; background:url({/literal}{$imageDir}homepage/mapcanvas.png{literal}) no-repeat; float:left;}
#realtime{width:370px; height:290px; float:left;}
#right{width:320px; float:right;}
#footerplaceholder{height:60px; clear:both;}
#wrapperfoot{clear:both; position:fixed; bottom:0; width:100%; height:50px; background:#333;}
#footer{width:900px; margin:auto; padding-top:5px;}
#footer img{float:left; width:150px; height:40px;}
#footer ul{text-align:right; padding-top:13px;}
#footer li{display:inline; list-style-type:none;}
#footer a, #footer{text-decoration:none; color:#cfcfcf;}
#footer a:hover{text-decoration:underline;}
#form{background:#6c6c6c; width: 290px; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px; -moz-box-shadow: 0px 0px 10px #ccc;
  -webkit-box-shadow: 0px 0px 10px #ccc;
  box-shadow: 0px 0px 10px #555; float:right;
}
.loginlabeltitle{width:230px; margin-left:30px; font-size: 14px; color:#fff; padding:10px 0 5px 0; display:block}
#femail, #fpassword{width:210px; border-width:0; background:#fff; display:block; margin-left:30px; padding:10px; font-size:14px; font-weight:bold; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px;}
#frememberme{float:left;}
#loginfunction{padding:10px 30px; color:#fff;}
#loginfunction label{padding:4px 0 0 4px;}
#loginbutton{float:right; width:130px; height:30px; line-height:30px; font-size: 18px; font-weight:bold; color:#fff; border-width:0;background:#b4b4b4; cursor:pointer; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px;}
#loginbutton:hover{background:#ccc}
#loginoauth{margin-top:20px;}
#loginoauth img{width:24px; height:24px;}
#loginoauth .yahoo{background-position: -150px 0;}
#loginoauth .gmail{background-position: -180px 0;}
#loginoauth .facebook{background-position: -210px 0; margin-right:30px;}
#loginoauth{background:#aaaaaa; height:40px;}
#loginoauth label{float:left; padding:12px 0 0 30px; color:#5f5f5f;}
#loginoauth a{float:right; margin: 7px 0 0 5px;}
#register{text-align:center;padding:20px 0 20px 0;}
#register label{padding-bottom:5px; color:#fff;}
#registerbutton .sp{width:240px; height:60px; background-position:0 -40px;}
.news{padding:10px; margin-bottom:10px; -moz-border-radius:8px;border-radius:8px;-webkit-border-radius:8px; background:#ffde00;  -moz-box-shadow: 3px 3px 2px #ddd;
  -webkit-box-shadow: 3px 3px 2px #ddd;
  box-shadow: 3px 3px 2px #ddd;}
.newsbookl{width: 70px; float:left;}
.newsbookl .cover{width:70px; height:110px; border-width:0;}
.newsbooklrating{text-align:center;}
.newsbookr{margin-left:70px; padding-left:10px;}
.newsbooktitle{font-weight:bold; font-size:14px; line-height:1.5;}
.newsbookauthor{font-size:11px; color:#555; padding-bottom:5px;}
.newsbookintro{line-height:1.5; font-size:11px; border-left:5px solid #fff; padding-left:10px;}
.sprating{background-position: -150px -26px; height:13px; margin-top:5px;}
.sprating0{width:0px;}
.sprating1{width:13px;}
.sprating2{width:25px;}
.sprating3{width:37px;}
.sprating4{width:49px;}
.sprating5{width:61px;}
#shelf{clear:both; position:fixed; bottom:50px;  padding:5px; width:100%; background:#eee;}
#shelfwrapper{width:900px; margin:auto; text-align:center;}
#shelf img{width:50px; height:75px; margin-right:5px;-moz-box-shadow: 0px 2px 4px #555; -webkit-box-shadow: 0px 2px 4px #555; box-shadow: 0px 2px 4px #555;}
{/literal}
</style>
</head>

<body>
	<div id="wrapper">
		<div id="left">
			<h1>{$lang.controller.heading}</h1>
			<h2>{$lang.controller.tagline}</h2>
			<div id="homepage">
				<div id="canvaswrapper"><canvas id="mapcanvas" width="190" height="290"></canvas></div>
				<div id="realtime">
					{foreach item=newsdata from=$newsList}
						{$newsdata}
					{/foreach}
				</div>
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
						<label>{$lang.controller.loginoauth}</label>
						<a href="javascript:void(0)" title="{$lang.controller.oauthFacebook}"><img class="sp facebook" src="{$imageDir}blank.png" alt="Facebook" /></a>
						<a href="javascript:void(0)" title="{$lang.controller.oauthGmail}"><img class="sp gmail" src="{$imageDir}blank.png" alt="Gmail" /></a>
						<a href="javascript:void(0)" title="{$lang.controller.oauthYahoo}"><img class="sp yahoo" src="{$imageDir}blank.png" alt="Yahoo" /></a>
					</div>
					<div id="register">
						<label id="registerlabel">{$lang.controller.registerLabel}</label>
						<a id="registerbutton" href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img class="sp" src="{$imageDir}blank.png" alt="{$lang.default.mRegister}" /></a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<div id="shelf">
		<div id="shelfwrapper">
			<a href="#"><img src="http://r-img.com/books/gen/31/dac-nhan-tam-small.jpg" /></a>
			<a href="#"><img src="http://r-img.com/books/gen/31/dac-nhan-tam-small.jpg" /></a>
			<a href="#"><img src="http://r-img.com/books/gen/31/dac-nhan-tam-small.jpg" /></a>
		</div>
	</div>
	
	<div id="footerplaceholder"></div>
	
	<div id="wrapperfoot">
		<div id="footer">
			<img class="sp" src="{$imageDir}blank.png" />
			<ul>
				<li><a href="{$conf.rooturl}login" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a> &middot;</li>
				<li><a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}">{$lang.default.mRegister}</a> &middot;</li>
				<li><a href="{$conf.rooturl}forgotpass" title="{$lang.default.mForgotpassTitle}">{$lang.default.mForgotpass}</a> &middot;</li>
            	<li><a href="{$conf.rooturl}contact" title="{$lang.default.mContactTitle}">{$lang.default.mContact}</a> &middot;</li>
				<li>2011 &copy; Reader.vn</li>
			</ul>
		</div>
	</div>


	<img id="mapmarker" src="{$imageDir}homepage/mapmarker.png" style="display:none;" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	{literal}
	<script type="text/javascript">
		function markCanvas()
		{
			var canvas = $("#mapcanvas")[0];
			var context = canvas.getContext("2d");
		
		
		  var  marker = document.getElementById("mapmarker");
		  context.drawImage(marker, 40, 60);
		  context.moveTo(55, 75);
		  context.lineTo(190, 50);
		  context.strokeStyle = "#ffde00";
		  context.lineWidth   = 2; // 4px wide
			context.stroke();
		}
		
		function clearCanvas(){
			var canvas = $("#mapcanvas")[0];
			var context = canvas.getContext("2d");
			context.clearRect(0, 0, canvas.width, canvas.height);
		}
		
		markCanvas()
	</script>
	{/literal}
	{include file="googleanalytic.tpl"}
</body>
</html>
