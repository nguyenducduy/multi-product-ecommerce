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
{/literal}
</style>
</head>

<body>
<br />
<h1>{$lang.controller.avatarUploadTitle}</h1>
<form action="" id="uploadform" method="post" enctype="multipart/form-data">
<input type="hidden" name="fsubmit" value="1" />
<br />
{$lang.controller.avatarUploadHelp}:<input type="file" name="fimage" id="fimage"  onchange="$('#loader').show();$('#submitbutton').hide();this.form.submit();" />
<br /><br />
<input class="button" type="submit" id="submitbutton" value="Upload"  />
<br /><br />
<h1 id="loader" class="hide">Uploading...<img src="{$imageDir}ajax_indicator.gif" alt="" /></h1>
</form>

{include file="notify.tpl" notifyError=$error notifySuccess=$success}

<p class="closewindow"><a href="javascript:void(0)" onclick="self.parent.Shadowbox.close();">{$lang.default.closewindow}</a></p>
<script  type="text/javascript" src="{$currentTemplate}min/?g=jquery"></script>

</body>
</html>