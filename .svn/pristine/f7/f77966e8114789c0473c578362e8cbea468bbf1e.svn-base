<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Đối tác</a> <span class="divider">/</span></li>
	<li class="active">Danh sách</li>
</ul>

<div class="page-header" rel="menu_vendor"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.vendorBulkToken}" />
				<table class="table table-striped">

				{if $vendors|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>

							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>{$lang.controller.labelImage}</th>
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th>{$lang.controller.labelSlug}</th>
							<th><a href="{$filterUrl}sortby/countproduct/sorttype/{if $formData.sortby eq 'countproduct'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCountproduct}</a></th>
							<th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
							<th>{$lang.controller.labelStatus}</th>
							<th width="140"></th>
						</tr>
					</thead>				
					<tfoot>
						<tr>
							<td colspan="9">
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
					{foreach item=vendor from=$vendors}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$vendor->id}" {if in_array($vendor->id, $formData.fbulkid)}checked="checked"{/if}/></td>

							<td><input type="text" class="input-mini" name="fdisplayorder[{$vendor->id}]" value="{$vendor->displayorder}" style="width:30px;"/></td>
							<td>
								{if $vendor->image != ''}
								<img src="{$vendor->getSmallImage()}" width="50px" height="50px" />
								{/if}
							</td>
							<td><span class="label label-info">{$vendor->name}</span></td>
							<td><code>{$vendor->slug}</code></td>
							<td>{if $vendor->countproduct > 0}<a target="blank" href="{$conf.rooturl}{$controllerGroup}/product/index/vid/{$vendor->id}"><span class="badge badge-info">{$vendor->countproduct}{else}<span class="badge badge-info">0</span>{/if}</span></a></td>
							<td>{if $vendor->checkTypeVendorName('nhà phân phối')}
									<span class="label">{$vendor->getVendorName()}</span>
								{else}
									<span class="label">{$vendor->getVendorName()}</span>
								{/if}</td>
							<td>{if $vendor->checkStatusName('enable')}
									<span class="label label-success">{$vendor->getStatusName()}</span>
								{else}
									<span class="label label-important">{$vendor->getStatusName()}</span>
								{/if}</td>


							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$vendor->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$vendor->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
					<option value="">- - - -</option>
					{html_options options=$statusList selected=$formData.fstatus}
				</select> -

				{$lang.controller.labelType}: <select name="ftype" id="ftype">
					<option value="">- - - -</option>
					{html_options options=$typeList selected=$formData.ftype}
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
		var path = rooturl + controllerGroup + "/vendor/index";


		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var status = $('#ftype').val();
		if(status.length > 0)
		{
			path += '/type/' + status;
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



