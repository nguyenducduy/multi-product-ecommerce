<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Settingentry</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_settingentry"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.settingentryBulkToken}" />
				<table class="table table-striped">
		
				{if $settingentrys|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th>{$lang.controller.labelSgid}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelDescription}</th>
							<th>{$lang.controller.labelIdentifier}</th>
							<th>{$lang.controller.labelValue}</th>
							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>{$lang.controller.labelStatus}</th>
							<th width="140"></th>
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
					{foreach item=settingentry from=$settingentrys}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$settingentry->id}" {if in_array($settingentry->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td>{$settingentry->sgid}</td>
							<td>{$settingentry->name}</td>
							<td>{$settingentry->description}</td>
							<td><span class="label">{$settingentry->identifier}</span></td>
							<td>{$settingentry->value}</td>
							<td>{$settingentry->displayorder}</td>
							<td>{$settingentry->status}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$settingentry->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$settingentry->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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

				{$lang.controller.labelSgid}: 
				<select name="fsgid" id="fsgid">
					<option value="0">- - - - - -</option>
					{foreach item=settinggroup from=$settinggroupList}
						<option value="{$settinggroup->id}" {if $settinggroup->id == $formData.fsgid}selected="selected"{/if}>{$settinggroup->name}</option>
					{/foreach}
				</select>
				
				 - 

				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDescription}: <input type="text" name="fdescription" id="fdescription" value="{$formData.fdescription|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelIdentifier}: <input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelValue}: <input type="text" name="fvalue" id="fvalue" value="{$formData.fvalue|@htmlspecialchars}" class="input-mini" /> - 


				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/settingentry/index";
		

		var sgid = $('#fsgid').val();
		if(sgid.length > 0)
		{
			path += '/sgid/' + sgid;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var description = $('#fdescription').val();
		if(description.length > 0)
		{
			path += '/description/' + description;
		}

		var identifier = $('#fidentifier').val();
		if(identifier.length > 0)
		{
			path += '/identifier/' + identifier;
		}

		var value = $('#fvalue').val();
		if(value.length > 0)
		{
			path += '/value/' + value;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		
		document.location.href= path;
	}
</script>
{/literal}
			
			


