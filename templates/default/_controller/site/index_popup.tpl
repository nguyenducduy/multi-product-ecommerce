<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $pageTitle != ''}{$pageTitle}{else}{$setting.site.defaultPageTitle}{/if}</title>
<!--<meta name="keywords" content="{$lang.controller.pageKeyword}" />
<meta name="description" content="{$lang.controller.pageDescription}" />-->
<meta name="robots" content="noindex,nofollow" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}/min/?g=css&ver={$setting.site.cssversion}" media="screen" />


<script src="{$currentTemplate}/js/jquery.js"></script>
<script  type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>
<script type="text/javascript">
    var rooturl = "{$conf.rooturl}";
    var imageDir = "{$imageDir}";
</script>
</head>

<body style="background: #fff;">
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
{$contents}
</body>
</html>
