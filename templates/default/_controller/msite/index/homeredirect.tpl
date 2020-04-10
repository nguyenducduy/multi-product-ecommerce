<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="{$conf.rooturl}favicon.ico"/>
<title>{$setting.site.defaultPageTitle}</title>
<meta name="author" content="Vo Duy Tuan, tuanmaster2002@yahoo.com" />
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription}" />
<meta http-equiv="refresh" content="5;url={$redirect}"/>
<style type="text/css">
{literal}
*{margin:0; padding:0;}
body{background:url({/literal}{$imageDir}pagebar.jpg{literal}) repeat-x; font-family: "Segoe UI", Tahoma, Geneva, sans-serif; font-size:11px;}
#wrapper{width:700px; margin:auto; margin-top:100px}
#book{width:100px;float:left;}
#book img{width:70px;border:5px solid #fff;-moz-box-shadow: 0px 0px 20px #ddd;
  -webkit-box-shadow: 0px 0px 10px #ccc;
  box-shadow: 0px 0px 10px #555;}
#quote{margin-left:100px;}
#quote h1{font-size:18px;}
#quote h1 a{color: #008aff; text-decoration:none;}
#quote blockquote{margin-top:10px; font-size:28px; font-style:italic; font-family:"Times New Roman", Times, serif}
#quote blockquote a{text-decoration:none; color:#000;}
#quote blockquote a:hover{text-decoration:underline;}
#quote cite{display:block; text-align:right; color:#aaa; font-size:14px; padding-top:10px;}
#quotemeta{text-align:center; color:#aaa; clear:both; padding:20px; margin:50px 0; border: 1px solid #ddd; border-left-width:0; border-right-width:0;}
#quotemeta a{color:#aaa;}
#redirecting{text-align:center; clear:both; padding:30px 0; margin-top:50px; color:#aaa; font-size:11px;}
#redirecting a{color:#aaa;}
{/literal}
</style>
</head>

<body>
	<div id="wrapper">
		{if $myQuote->id > 0}
			<div id="book">
				<a href="{$myQuote->book->getBookPath()}#quote" title="{$myQuote->book->title}"><img src="{$myQuote->book->getSmallImage()}" /></a>
			</div>
			
			<div id="quote">
				<h1><a href="{$myQuote->book->getBookPath()}#quote" title="{$myQuote->book->title}">{$myQuote->book->title}</a></h1>
				<blockquote><a href="{$myQuote->book->getBookPath()}#quote">{$myQuote->text}</a></blockquote>
				<cite>{$myQuote->author}</cite>
			</div>
			
			<div id="quotemeta">
				Trích dẫn được tạo bởi thành viên <a href="{$myQuote->actor->getUserPath()}">{$myQuote->actor->fullname}</a> vào {$myQuote->datecreated|relative_datetime}
			</div>
		{/if}
		
		
		<div id="redirecting">
			<img src="{$imageDir}ajax_indicator.gif" /> 
			Đang chuyển tới trang nhà của bạn. <a href="{$redirect}">{$lang.global.redirectClickHere}</a> {$lang.global.redirectDontWantWait}
		</div>
	</div>
	
	{include file="googleanalytic.tpl"}
</body>
</html>
