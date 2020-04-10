<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.controller.head_list}</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<div class="pull-right">
	{if $smarty.get.view == 'list'}
		<a class="btn" href="{$conf.rooturl}{$controllerGroup}/{$controller}"><i class="icon-sitemap"></i> {$lang.controller.viewChart}</a>
	{else}
		<a class="btn" href="{$conf.rooturl}{$controllerGroup}/{$controller}?view=list"><i class="icon-list"></i> {$lang.controller.viewList}</a>
	{/if}
	
	<a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a>
</div>

<div class="page-header" rel="menu_hrmtitle"><h1>{$lang.controller.head_list}</h1></div>

{if $smarty.get.view == 'list'}
	<ul class="nicelist">
		{$departmentListHtml}
	</ul>
{else}
	<ul id="org" style="display:none">
		{$departmentListHtml}
	</ul>

	<div id="orgchart"></div>
			

	{literal}
	<script type="text/javascript">
		$(document).ready(function() {
		    $("#org").jOrgChart({'chartElement' : '#orgchart'});
		});
	</script>
	{/literal}
{/if}
			


