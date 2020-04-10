{include file="_controller/admin/header.tpl"}
<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/lib/d3.v2.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/stream_layers.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/nvd3/nv.d3.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/date.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/daterangepicker.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/stat/mystat.js"></script>
{if $controller == 'index'}<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>{/if}

<link rel="stylesheet" type="text/css" href="{$currentTemplate}css/stat/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="{$currentTemplate}css/stat/stat.css" />


<div class="row-fluid">
			
	<!-- start: Main Menu -->
	<div id="sidebar-left" class="span1">
		<div class="nav-collapse sidebar-nav">
			<ul class="nav nav-tabs nav-stacked main-menu">
				<li{if $nav == 'dashboard'} class="active"{/if}><a href="{$conf.rooturl_stat}"><i class="icon-dashboard"></i><span class="hidden-tablet"> Dashboard</span></a></li>	
				<li{if $nav == 'analytics'} class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=sale"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Analytics</span></a></li>
				<li{if $nav == 'system'} class="active"{/if}><a href="{$conf.rooturl_stat}system"><i class="icon-cogs"></i><span class="hidden-tablet"> Cacti Monitor</span></a></li>
				<li{if $nav == 'apc'} class="active"{/if}><a href="{$conf.rooturl}_internal/apc/apc.php"><i class="icon-cogs"></i><span class="hidden-tablet"> APC Cache</span></a></li>
				<li{if $nav == 'redis'} class="active"{/if}><a href="http://172.16.141.60" target="_blank" title="Open In New Window"><i class="icon-cogs"></i><span class="hidden-tablet"> Redis Monitor</span></a></li>
				<li{if $nav == 'dosmonitor'} class="active"{/if}><a href="{$conf.rooturl_stat}system/dosmonitor"><i class="icon-exclamation-sign"></i><span class="hidden-tablet"> DoS Monitor</span></a></li>
				<li{if $nav == 'sqlmonitor'} class="active"{/if}><a href="{$conf.rooturl_stat}system/sqlmonitor" target="_blank"><i class="icon-cogs"></i><span class="hidden-tablet"> SQL Monitor</span></a></li>
				<li{if $nav == 'recommendationmonitor'} class="active"{/if}><a href="{$conf.rooturl_stat}system/recommendationmonitor"><i class="icon-cogs"></i><span class="hidden-tablet"> Recommendation Monitor</span></a></li>
				<li{if $nav == 'googleanalytics'} class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=visit,visitor,newvisit,bounce"><i class="icon-google-plus"></i><span class="hidden-tablet"> Google Analytics</span></a></li>
				
			</ul>
		</div>
	</div>
	<!-- end: Main Menu -->
	
	<!-- start: Content -->
	<div id="content" class="span11" style="min-height: 600px;">
		{if $nav != 'dashboard' && $nav != 'realtime' && $nav != 'system' && $nav != 'dosmonitor' && $nav != 'apc' && $nav != 'redis' && $nav != 'recommendationmonitor'}
			<div id="navsub" class="span2">
				<div id="statdaterange">
					<h2>Date Range <b class="caret"></b></h2>
				    <span>{$dateRangeStart|date_format:"%d/%m/%Y"} - {$dateRangeEnd|date_format:"%d/%m/%Y"}</span>
				</div>
				
				
				<ul>
					{if $nav == 'analytics'}
						<li {if in_array('sale', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=sale">Sale</a></li>
						<li {if in_array('product', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=product">Product</a></li>
						<li {if in_array('news', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=news">News</a></li>
						<li {if in_array('stuff', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=stuff">Stuff</a></li>
						<li {if in_array('customer', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=customer">Member</a></li>
						<li {if in_array('feed', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=feed,feedreply,feedlike">Feed</a></li>
						<li {if in_array('notification', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=notification">Notification</a></li>
						<li {if in_array('message', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=message,attachment">Message</a></li>
						<li {if in_array('filedrive', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}chart?name=filedrive">File</a></li>
					{elseif $nav == 'googleanalytics'}
						<li {if in_array('visitor', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=visit,visitor,newvisit,bounce">Visitor</a></li>
						<li {if in_array('avgtimeonsite', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=avgtimeonsite,avgtimeonpage">Time On Site</a></li>
						<li {if in_array('pageview', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=pageview,uniquepageview">Page View</a></li>
						<li {if in_array('browser', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=browser">Browser</a></li>
						<li {if in_array('operatingsystem', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=operatingsystem">Operating System</a></li>
						<li {if in_array('screenresolution', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=screenresolution">Screen Resolution</a></li>
						<li {if in_array('city', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=city">City</a></li>
						<li {if in_array('pagepath', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=pagepath">Page</a></li>
						<li {if in_array('referrer', $chartNames)}class="active"{/if}><a href="{$conf.rooturl_stat}googleanalytics?name=referrer">Referrer</a></li>
						<li><a href="https://www.google.com/analytics/" target="_blank">Go to Google Analytics <i class="icon-share"></i></a></li>
					{/if}
				</ul>
			</div>
		{/if}
			
		<div id="maincontent" {if $nav != 'dashboard' && $nav != 'system' && $nav != 'dosmonitor' && $nav != 'apc' && $nav != 'redis' && $nav != 'recommendationmonitor'}class="span10"{/if}>
			{include file="_controller/admin/maincontent.tpl"}
		</div>
	</div>

</div>

{include file="_controller/admin/footer.tpl"}