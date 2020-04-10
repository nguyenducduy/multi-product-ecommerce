<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject">List Project </a> <span class="divider">/</span> </li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumproject/detail/spid/{$formData.projectid}">Project Detail</a> <span class="divider">/</span></li>
    <li class=""><a class="" href="{$conf.rooturl}{$controllerGroup}/scrumstory/index/siid/{$formData.iterationid}">List Story</a> <span class="divider">/</span> </li>
    <li class=""> List Story Assignee <span class="divider">/</span></li>

</ul>

<div class="page-header" rel="menu_scrumstoryasignee"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
        {if {$formData.permiss}=='1'}
        <li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add/ssid/{$projectId}">{$lang.controller.head_add}</a></li>
        {/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryasigneeBulkToken}" />
				<table class="table table-striped">
		
				{if $scrumstoryasignees|@count > 0}
					<thead>
						<tr>
						   {if {$formData.permiss}=='1'}
						   <th width="40"><input class="check-all" type="checkbox" /></th>
						   {/if}
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelSsid}</th>
							<th>{$lang.controller.labelUid}</th>
							<th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
                            {if {$formData.permiss}=='1'}
							<th width="140"></th>
							{/if}
						</tr>
					</thead>
		
					<tfoot>
						<tr>
							<td colspan="8">
								<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->

                                {if {$formData.permiss}=='1'}
								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>
								{/if}
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=scrumstoryasignee from=$scrumstoryasignees}
		
						<tr>
                            {if {$formData.permiss}=='1'}
							<td><input type="checkbox" name="fbulkid[]" value="{$scrumstoryasignee->id}" {if in_array($scrumstoryasignee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							{/if}
							<td style="font-weight:bold;">{$scrumstoryasignee->id}</td>
							
							<td>{$scrumstoryasignee->storyname}</td>

							<td>{$scrumstoryasignee->uname}</td>
							<td>{$scrumstoryasignee->type}</td>
							<td>{$scrumstoryasignee->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>

							<td>
                                {if {$formData.permiss}=='1'}
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$scrumstoryasignee->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$scrumstoryasignee->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
                                {/if}
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
				{$lang.controller.labelSsid}: <input type="text" name="fssid" id="fssid" value="{$formData.fssid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelUid}: <input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelType}: <input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/scrumstoryasignee/index";
		

		var ssid = $('#fssid').val();
		if(ssid.length > 0)
		{
			path += '/ssid/' + ssid;
		}

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
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
			
			


