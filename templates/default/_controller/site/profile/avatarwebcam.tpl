<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="{$currentTemplate}images/favicon.ico"/>
<title>{if $pageTitle != ''}{$pageTitle} | {$setting.site.heading}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="author" content="Vo Duy Tuan, tuanmaster2002@yahoo.com" />
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription}" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=csslite" media="screen" />
<style type="text/css">
{literal}
body{background-color:#fff;text-align:center;}
h1{text-align:center;}
#error{font-weight:bold; color:#f00;padding:5px;border:1px solid #FF3333;background:#FFEaEa;margin-top:30px;}
.button{border:1px solid #690; font-size:16px; font-weight:bold; padding:5px 30px;cursor:pointer; background: #6c0;color:#fff;border-radius: 10px; -moz-border-radius: 10px; -webkit-border-radius: 10px;}
.button:hover{background:#6C3;}
em{font-weight:bold; color:#f30;}
{/literal}
</style>
</head>

<body>
<br />
<center>
		<h1>{$lang.controller.avatarWebcamTitle}</h1>
		<div style="font-size:12px;padding:20px;">{$lang.controller.avatarWebcamHelp}</div>
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
		        codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"
		        width="720" height="320" id="audio_client" align="middle">
		  <param name="allowScriptAccess" value="sameDomain" />
		  <param name="src" value="{$conf.rooturl}templates/default/images/webcamsnap.swf?uploadfile={$conf.rooturl}profile/avatarwebcam" />
		  <param name="quality" value="high" />
		  <param name="wmode" value="opaque" />
		  <param name="bgcolor" value="#ffffff" />
		    <embed src="{$conf.rooturl}templates/default/images/webcamsnap.swf?uploadfile={$conf.rooturl}profile/avatarwebcam" quality="high"
		           bgcolor="#ffffff" width="720" height="320" wmode="opaque" name="audio_client" align="middle"
		           allowScriptAccess="sameDomain" type="application/x-shockwave-flash" 
		           pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>
		</center>

{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<p class="closewindow"><a href="javascript:void(0)" onclick="self.parent.Shadowbox.close();">{$lang.default.closewindow}</a></p>
</body>
</html>