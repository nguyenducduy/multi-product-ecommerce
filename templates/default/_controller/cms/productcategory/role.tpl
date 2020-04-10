<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Phân quyền</li>
</ul>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_list_role}</h1></div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab"> Danh sách những người được bạn phân quyền</a></li>

		{if $delegate}
		<li class="pull-right">{if $me->isGroup('administrator') || $me->isGroup('developer')}<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roleadd">{$lang.controller.head_add_role}</a>{else}<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roledelegate">{$lang.controller.head_add_role}</a>{/if}</li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.roleuserBulkToken}" />
				<table class="table .table-hover">

				{if $roleusers|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
						   <th></th>
							<th style="width:160px;">{$lang.controller.labelAccount}</th>
							<th style="width:133px;">{$lang.controller.labelVendor}</th>
							<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelProductCategory}</a></th>
							<!-- <th><a href="{$filterUrl}sortby/subobjectid/sorttype/{if $formData.sortby eq 'subobjectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSubobjectid}</a></th> -->
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
								</div>


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
						{foreach item=groups from=$groupList}
							{foreach item=roleuser from=$groups name=foo}
							{if $smarty.foreach.foo.first && $roleuser->uid > 0}
							<tr>
								<td><input type="checkbox" name="fbulkid[]" value="{$roleuser->id}" {if in_array($roleuser->id, $formData.fbulkid)}checked="checked"{/if}/></td>
								<td rowspan="{$groups|@count}"><span class="label">a{$roleuser->actor->id}</span></td>
								<td rowspan="{$groups|@count}"><span class="label label-warning"><b style="font-size:15px;">{$roleuser->actor->fullname}</b></span></td>
								<td>{if $roleuser->vendor->id > 0}{$roleuser->vendor->name}{/if}</td>
								<td>{if $roleuser->productcategory->parent|@count > 0}
										{foreach item=parent from=$roleuser->productcategory->parent}
										<span class="label label-info">{$parent.pc_name}</span> &raquo;
										{/foreach}
										{/if}
									<span class="label label-info">{$roleuser->productcategory->name}</span>
								</td>
								<td>{if $roleuser->checkStatusName('enable')}
									<span class="label label-success">{$roleuser->getStatusName()}</span>
								{else}
									<span class="label label-important">{$roleuser->getStatusName()}</span>
								{/if}</td>
								<td rowspan="{$groups|@count}"><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/roleedit/uid/{$roleuser->uid}/vid/{$roleuser->subobjecteid}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/roledelete/uid/{$roleuser->uid}/vid/{$roleuser->subobjecteid}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a></td>
							</tr>
							{else}
							    {if $roleuser->uid > 0}
							    <tr>
								    <td><input type="checkbox" name="fbulkid[]" value="{$roleuser->id}" {if in_array($roleuser->id, $formData.fbulkid)}checked="checked"{/if}/></td>
								    <td>{if $roleuser->vendor->id > 0}{$roleuser->vendor->name}{/if}</td>
								    <td>{if $roleuser->productcategory->parent|@count > 0}
										{foreach item=parent from=$roleuser->productcategory->parent}
										<span class="label label-info">{$parent.pc_name}</span> &raquo;
										{/foreach}
										{/if}
									<span class="label label-info">{$roleuser->productcategory->name}</span>
								    </td>
								    <td style="float:left;">{if $roleuser->checkStatusName('enable')}
									    <span class="label label-success">{$roleuser->getStatusName()}</span>
								    {else}
									    <span class="label label-important">{$roleuser->getStatusName()}</span>
								    {/if}</td>
							    </tr>
							    {/if}
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
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/productcategory/role";


		var uid = $('#fuid').val();
		if(uid != null)
		{
			path += '/uid/' + uid;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
		}

		var objectid = $('#fsubobjectid').val();
		if(objectid.length > 0)
		{
			path += '/subobjectid/' + objectid;
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

