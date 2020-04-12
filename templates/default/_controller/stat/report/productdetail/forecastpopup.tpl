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

		<link rel="stylesheet" type="text/css" href="https://ecommerce.kubil.app/templates/default/css/stat/daterangepicker.css" />
		<!-- <link rel="stylesheet" type="text/css" href="https://ecommerce.kubil.app/templates/default/css/stat/stat.css" /> -->
		<link type="text/css" rel="stylesheet" href="https://ecommerce.kubil.app/templates/default/css/site/startproductcategory.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="https://ecommerce.kubil.app/templates/default/css/site/jquery.handsontable.full.css" media="screen" />



		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>



		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>

		<!--<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/nvd3/lib/d3.v2.min.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/nvd3/stream_layers.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/nvd3/nv.d3.min.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/mystat.js"></script>-->
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/date.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/daterangepicker.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/forecastproductcategory.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/highcharts/highcharts.js"></script>


		{if $controller == 'index'}<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>{/if}


		<script type="text/javascript" src="{$currentTemplate}js/admin/bootstrap-datepicker.js"></script>
		<!--<script type="text/javascript" src="{$currentTemplate}js/site/jquery.handsontable.full.js"></script>-->
		<script type="text/javascript" src="{$currentTemplate}js/site/numeral.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/jquery.sparkline.min.js"></script>
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/report/jquery.freezeheader.js"></script>		
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/report/jquery.tablesorter.min.js"></script>		
		<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/report/jquery-calx-1.1.4.min.js"></script>
		<!--<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/jquery.handsontable-excel.js"></script>-->
		{literal}
		<style type="text/css">
			#sb-wrapper{top:80px !important;}
			.inputdatepicker_help{display:none;}
		</style>
		{/literal}




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

    <body style="background:#fff;">
        {include file="notify.tpl" notifyError=$error notifySuccess=$success}
        {$datahtml}
    </body>
<script type="text/javascript" src="https://ecommerce.kubil.app/templates/default/js/stat/report/productdetail.js"></script>
