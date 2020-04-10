<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Nhóm thuộc tính</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_productgroupattribute"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.productgroupattributeBulkToken}" />
				<table class="table table-striped">

				{if $productgroupattributes|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>

							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>{$lang.controller.labelPcid}</th>
							<th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th>{$lang.controller.labelStatus}</th>
							<th width="229"></th>
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
					{foreach item=productgroupattribute from=$productgroupattributes}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productgroupattribute->id}" {if in_array($productgroupattribute->id, $formData.fbulkid)}checked="checked"{/if}/></td>

							<td><input type="text" class="input-mini" name="fdisplayorder[{$productgroupattribute->id}]" value="{$productgroupattribute->displayorder}" style="width:30px;"/></td>
							<td>
								{foreach from=$productcategoryList item=category}
								{if $category->id == $productgroupattribute->pcid}<b>{$category->name|replace:'&nbsp;' : ''}</b>{/if}
								{/foreach}
							</td>
							<td><a href="{$conf.rooturl_cms}productattribute/index/pgaid/{$productgroupattribute->id}/pcid/{$productgroupattribute->pcid}">{$productgroupattribute->name}</a></td>
							<td>{if $productgroupattribute->checkStatusName('enable')}
									<span class="label label-success">{$productgroupattribute->getStatusName()}</span>
								{else}
									<span class="label label-important">{$productgroupattribute->getStatusName()}</span>
								{/if}
							</td>

							<td>
								<a title="" href="{$conf.rooturl}{$controllerGroup}/productattribute/add/pcid/{$productgroupattribute->pcid}/pgaid/{$productgroupattribute->id}/redirect/{$redirectUrl}" class="btn btn-mini"><span class="icon-plus">{$lang.controller.labelAddAttribute}</span></a> &nbsp;
								<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productgroupattribute->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productgroupattribute->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				{$lang.controller.labelPcid}: <select name="fpcid" id="fpcid">
					<option value="0">----</option>
					{foreach from=$productcategoryList item=category}
					{if $category->parentid == 0}
					</optgroup><optgroup label="{$category->name}">
					{else}
					<option value="{$category->id}" {if $category->id == $formData.fpcid}selected="selected"{/if}>{$category->name}</option>
					{/if}
					{/foreach}
				</select> -

				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelDisplayorder}: <input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini" /> -

				{$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
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
		var path = rooturl + controllerGroup + "/productgroupattribute/index";


		var pcid = $('#fpcid').val();
		if(pcid.length > 0)
		{
			path += '/pcid/' + pcid;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var displayorder = $('#fdisplayorder').val();
		if(displayorder.length > 0)
		{
			path += '/displayorder/' + displayorder;
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




