<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Productcategory</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>


<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		{if $me->groupid == 1}
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl_admin}relproductcategoryuser">{$lang.controller.labelCategoryPermission}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.productcategoryBulkToken}" />
				<table class="table table-striped">

				{if $productcategorys|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>

							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th style="width:179px;">{$lang.controller.labelParentid}</th>
							<th style="width:150px;"><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
							<th>{$lang.controller.labelSlug}</th>

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
									<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=productcategory from=$productcategorys}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$productcategory->id}" {if in_array($productcategory->id, $formData.fbulkid)}checked="checked"{/if}/></td>

							<td><input type="text" class="input-mini" style="width:25px;" name="fdisplayorder[{$productcategory->id}]" value="{$productcategory->displayorder}" style="width:30px;"/></td>
							<td>
								{if array_key_exists($productcategory->id, $parentCategory)}
									{foreach $parentCategory key=pid item=parentarr}
										{if $pid == $productcategory->id}
											{foreach from=$parentarr item=parent}
											<a href="{$conf.rooturl_cms}productcategory/index/parentid/{$parent.pc_id}">{$parent.pc_name}</a> &raquo;
											{/foreach}
										{/if}
									{/foreach}
								{/if}
							</td>
							<td>{$productcategory->name}</td>
							<td>{$productcategory->slug}</td>
							<td>{if $productcategory->checkStatusName('enable')}
									<span class="label label-success">{$productcategory->getStatusName()}</span>
								{else}
									<span class="label label-important">{$productcategory->getStatusName()}</span>
								{/if}</td>

							<td><a title="{$lang.controller.labelFilterManager}" href="{$conf.rooturl_cms}{$groupController}/{$controller}/filter/id/{$productcategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-filter"></i></a>
                            	<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productcategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productcategory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				{$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-medium" /> -

				{$lang.controller.labelSlug}: <input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-medium" /> -

				{$lang.controller.labelParentid}:
				<select name="fparentid" id="fparentid">
				<option value="0">------</option>
				{foreach from=$productcategoryList item=category}
					<option value="{$category->id}"  {if $category->id == $formData.fparentid}selected="selected"{/if}>{$category->name}</option>
				{/foreach}
				</select> -

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
		var path = rooturl + controllerGroup + "/productcategory/index";


		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var slug = $('#fslug').val();
		if(slug.length > 0)
		{
			path += '/slug/' + slug;
		}

		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
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




