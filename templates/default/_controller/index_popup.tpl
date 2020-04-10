<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="{$conf.rooturl}favicon.ico"/>
<title>{if $pageTitle != ''}{$pageTitle} | {$setting.site.heading}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="author" content="Vo Duy Tuan, tuanmaster2002@yahoo.com" />
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription}" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=csslite&ver={$setting.site.cssversion}" media="screen" />
</head>
<body>

<div id="wrapper">
	<div id="header">
		<div class="left">
			<a href="{$conf.rooturl}" title="{$lang.default.logoTitle}"><img src="{$imageDir}logo.png" alt="{$setting.site.heading} Logo" /></a>
		</div>

	</div><!-- end #header -->
</div>
{include file="notify.tpl" notifyError=$error notifyInformation=$information hidenotifyclose=1}
{$contents}
<br />
<hr size="1" color="#ccc" />
<p align="center"><a href="javascript:void(0);" onclick="window.close();">Close</a></p>
</body>
</html>



