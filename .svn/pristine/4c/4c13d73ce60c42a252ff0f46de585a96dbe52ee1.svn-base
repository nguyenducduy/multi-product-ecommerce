<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Tin tức</a> <span class="divider">/</span></li>
	<li class="active">Role</li>
</ul>

<div class="page-header" rel="menu_newscategory"><h1>{$lang.controller.head_list_role}</h1></div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list_role} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">{$lang.default.formViewAll}</a></li>
		{/if}
		{if $delegate}
		<li class="pull-right">{if $me->isGroup('administrator') || $me->isGroup('developer')}<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roleadd">{$lang.controller.head_add_role}</a>{else}<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roledelegate">{$lang.controller.head_add_role}</a>{/if}</li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.roleuserBulkToken}" />
				<table class="table table-striped">

				{if $roleusers|@count > 0}
					<thead>
						<tr>
						   <!-- <th width="40"><input class="check-all" type="checkbox" /></th> -->
							<th>{$lang.controller.labelAccount}</th>
							<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelHaveNewscategory}</a></th>
							<!-- <th><a href="{$filterUrl}sortby/subobjectid/sorttype/{if $formData.sortby eq 'subobjectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSubobjectid}</a></th> -->
							<th>{$lang.controller.labelStatus}</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<!-- <div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div>


								<div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
								</div>

								<div class="clear"></div> -->
							</td>
						</tr>
					</tfoot>
					<tbody>
						{foreach item=groups from=$groupList}
							{foreach item=roleuser from=$groups name=foo}
							{if $smarty.foreach.foo.first}
							<tr>
								<td rowspan="{$groups|@count}"><b style="font-size:15px;">{$roleuser->actor->fullname}</b></td>

								<td>{if $roleuser->newscategory->parent|@count > 0}
									{foreach item=parent from=$roleuser->newscategory->parent}
									<b>{$parent.nc_name}</b> &raquo;
									{/foreach}
									{/if}
									<span class="label label-info">{$roleuser->newscategory->name}</span>
								</td>
								<td>{if $roleuser->checkStatusName('enable')}
									<span class="label label-success">{$roleuser->getStatusName()}</span>
								{else}
									<span class="label label-important">{$roleuser->getStatusName()}</span>
								{/if}</td>
								<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roleedit/uid/{$roleuser->uid}/ncid/{$roleuser->objectid}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/roledelete/uid/{$roleuser->uid}/ncid/{$roleuser->objectid}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
							{else}
							<tr>

								<td>{if $roleuser->newscategory->parent|@count > 0}
									{foreach item=parent from=$roleuser->newscategory->parent}
									<span class="label label-info">{$parent.nc_name}</span> &raquo;
									{/foreach}
									{/if}
									<span class="label label-info">{$roleuser->newscategory->name}</span>
								</td>
								<td>{if $roleuser->checkStatusName('enable')}
									<span class="label label-success">{$roleuser->getStatusName()}</span>
								{else}
									<span class="label label-important">{$roleuser->getStatusName()}</span>
								{/if}</td>
								<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roleedit/uid/{$roleuser->uid}/ncid/{$roleuser->objectid}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/roledelete/uid/{$roleuser->uid}/ncid/{$roleuser->objectid}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
							{/if}
							{/foreach}
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
				{$lang.controller.labelAccount}:
					<select name="fuid" id="fuid" class="autocompletestaff"></select> -

				{$lang.controller.labelCreatorid}:
				<select name="fcreatorid" id="fcreatorid" class="autocompletestaff"></select>

				<br /><br />

				{$lang.controller.head_list}:
				<select name="fparentid" id="fparentid">
				<option value="0">------</option>
				{foreach from=$newscategoryList item=category}
					<option value="{$category->id}"  {if $category->id == $formData.fparentid}selected="selected"{/if}>{$category->name}</option>
				{/foreach}
				</select> -

				{$lang.controller.labelStatus}:
				<select name="fstatus" id="fstatus">
					<option value="0">--------</option>
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
		var path = rooturl + controllerGroup + "/newscategory/role";


		var uid = $('#fuid').val();
		if(uid != null)
		{
			path += '/uid/' + uid;
		}


		var creatorid = $('#fcreatorid').val();
		if(creatorid != null)
		{
			path += '/creatorid/' + creatorid;
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
	$(document).ready(function() {
	$('.holder').css('width' , '250px');
	$('.default').css('width' , '250px');
	$('.facebook-auto').css('width' , '265px');
});
</script>
{/literal}