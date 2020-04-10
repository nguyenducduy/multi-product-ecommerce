<ul class="breadcrumb">
	<li><a href="{$conf.rooturl}{$controllerGroup}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Region</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_region"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
		
				{if $regions|@count > 0}
					
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{if $formData.fparentid == 0}Quận/Huyện{else}Tỉnh/Thành phố{/if}</th>
							<th>Lat,Lng</th>
							<th></th>
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->
					
					
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=region from=$regions}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$region->id}" {if in_array($region->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$region->id}</td>
							
							<td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$region->id}" title="View all sub-region">{$region->name}</a></td>
							<td>{if $region->parentid > 0}
									<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/id/{$region->parentid}"><span class="label label-info">{$region->parent->name}</span></a>
								{else}
									<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/parentid/{$region->id}"><span class="badge badge-info">{$region->countsubregion}</span></a>
								{/if}</td>
							<td>{if $region->lat != 0}{$region->lat}, {$region->lng} <a href="https://maps.google.de/maps?q={$region->lat},{$region->lng}" target="_blank"><i class="icon-globe"></i> Map</a>{else}n/a{/if}</td>
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$region->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$region->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger hide"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>
			

					{/foreach}
					</tbody>
		
	  
				{else}
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
				{/if}
	
				</table>
			</form>

		</div><!-- end #tab 1 -->
		<div class="tab-pane" id="tab2">
			<form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
				{$lang.controller.labelParentid}: 
					<select name="fparentid" id="fparentid">
						<option value="">- - - - - - - - - - - - - -  -</option>
						{foreach item=region from=$regionList}
							<option value="{$region->id}" {if $region->id == $formData.fparentid}selected="selected"{/if}>{$region->name}</option>
						{/foreach}
					</select>
				 - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/region/index";
		

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}
		
		
		document.location.href= path;
	}
</script>
{/literal}
			
			


