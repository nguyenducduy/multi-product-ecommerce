<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Settinggroup</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_settinggroup"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.settinggroupBulkToken}" />
				<table class="table table-striped">
		
				{if $settinggroups|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th>{$lang.controller.labelIdentifier}</th>
							<th>Settings</th>
							<th>{$lang.controller.labelStatus}</th>
							
							<th width="250"></th>
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
									<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=settinggroup from=$settinggroups}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$settinggroup->id}" {if in_array($settinggroup->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><input type="text" class="input-mini" name="fdisplayorder[{$settinggroup->id}]" value="{$settinggroup->displayorder}" /></td>
							<td>{$settinggroup->name}</td>
							<td>{$settinggroup->description}</td>
							<td><span class="label">{$settinggroup->identifier}<span></td>
							<td><a href="{$conf.rooturl}{$controllerGroup}/settingentry/index/sgid/{$settinggroup->id}" title="View all settings in this group"><span class="badge badge-info">{$settinggroup->countsetting}</span></a></td>
							<td>{if $settinggroup->checkStatusName('enable')}
									<span class="label label-success">{$settinggroup->getStatusName()}</span>
								{else}
									<span class="label label-important">{$settinggroup->getStatusName()}</span>
								{/if}</td>
							
							
							<td>
								<a title="" href="{$conf.rooturl}{$controllerGroup}/settingentry/add/id/{$settinggroup->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-plus"></i> Add Setting</a> &nbsp;
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$settinggroup->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$settinggroup->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="" /> - 

				{$lang.controller.labelIdentifier}: <input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="" /> - 

				{$lang.controller.labelStatus}: 
				<select name="fstatus" id="fstatus">
					<option value="">- - - -</option>
					{html_options options=$statusList selected=$formData.fstatus}
				</select> - 

				

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
		var path = rooturl + controllerGroup + "/settinggroup/index";
		

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var identifier = $('#fidentifier').val();
		if(identifier.length > 0)
		{
			path += '/identifier/' + identifier;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
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
			
			


