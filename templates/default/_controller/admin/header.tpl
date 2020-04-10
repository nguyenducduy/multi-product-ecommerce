<!DOCTYPE html>
<html lang="en">
  <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>{$pageTitle|default:$currentUrl}</title>
		
		<!-- Bootstrap Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />
	  	
		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />
        
		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />
		
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />

		
		
		
		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>
		
		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>
		
		
		
		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
		
		
        <script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_admin = "{$conf.rooturl_admin}";
		var rooturl_cms = "{$conf.rooturl_cms}";
		var rooturl_crm = "{$conf.rooturl_crm}";
		var rooturl_erp = "{$conf.rooturl_erp}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var rooturl_stat = "{$conf.rooturl_stat}";
		var controllerGroup = "{$controllerGroup}";
		var currentTemplate = "{$currentTemplate}";
		
		var websocketurl = "{$setting.site.websocketurl}";
		var websocketenable = {$setting.site.websocketenable};
		
		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";
		
		
		var imageDir = "{$imageDir}";
		var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = {$me->id};
		var meurl = "{$me->getUserPath()}";
		var userid = {$myUser->id};
		var userurl = "{$myUser->getUserPath()}";
		</script>
		
	</head>
    
    <body {if $controllerGroup == 'profile' && $controller == 'message'}id="bodymailbox"{/if}>
	
	
		<div class="notify-bar notify-bar-warning" style="border-radius:0;display:none;">
			<div class="notify-bar-icon"><img src="{$imageDir}notify/info.png" alt="info"  width="24" height="24"/></div>
			<div class="notify-bar-button{if $hidenotifyclose} hide{/if}"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="{$imageDir}notify/close-btn.png" border="0" alt="close" /></a></div>
			<div class="notify-bar-text">
				Nếu bạn muốn thử chức năng Quản lý sản phẩm/thuộc tính/danh mục thì gởi Một Tin Nhắn Cá nhân (<a href="{$conf.rooturl_profile}message">Gởi Tin nhắn</a>) đến tài khoản VÕ HOÀNG LONG (A32) để được phân quyền. Nội dung là Danh mục bạn muốn quản lý.
			</div>
		</div>
		
		{include file="_controller/admin/header_topbar.tpl"}
		
		{if $controllerGroup == 'profile' && $controller == 'message'}
			<div id="mailwrapper">
				<div id="mailcontainer">
					<div id="mailbox">
		{else}
			<div class="container-fluid">
		  		<div class="row-fluid">
					{if $controllerGroup != 'stat'}
						{include file="_controller/admin/header_leftmenu.tpl"}
			
	        			<div class="span10" id="container">
					{else}
						<div id="container" style="margin-left:0;">
					{/if}
		{/if}
