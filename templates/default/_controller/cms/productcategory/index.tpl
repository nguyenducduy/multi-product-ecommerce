<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
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
		{if $me->isGroup('administrator') || $me->isGroup('developer')}
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		{/if}
		<li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/role">{$lang.controller.labelCategoryPermission}</a></li>
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
						   <!-- <th width="40"><input class="check-all" type="checkbox" /></th> -->

							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th>Danh muc</th>
							<th>Slug</th>
							<th>{$lang.controller.labelStatus}</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<!--<div class="pagination">
								   {assign var="pageurl" value="page/::PAGE::"}
									{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
								</div> <!-- End .pagination -->


								<!-- <div class="bulk-actions align-left">
									<select name="fbulkaction">
										<option value="">{$lang.default.bulkActionSelectLabel}</option>
										<option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
									</select>
									<input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />-->
									<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=productcategory from=$productcategorys}

						{if $productcategory->id > 0}
						<tr {if $productcategory->parentid == 0}style="font-weight:bold; background:#ddd !important;border-top:2px solid #ccc;"{/if}>
							<!-- <td><input type="checkbox" name="fbulkid[]" value="{$productcategory->id}" {if in_array($productcategory->id, $formData.fbulkid)}checked="checked"{/if}/></td> -->


							<td><input type="text" class="input-mini" style="width:25px;" name="fdisplayorder[{$productcategory->id}]" value="{$productcategory->displayorder}" style="width:30px;"/></td>
							<td>
								{if count($producateogry->parent)|@count > 0}
								{foreach item=parent from=$productcategory->parent}
									<a href="{$conf.rooturl_cms}productcategory/index/parentid/{$parent.pc_id}">{$parent.pc_name}</a> &raquo;
								{/foreach}
								{/if}
								<a target="_blank" href="{$conf.rooturl_cms}product/index/pcid/{$productcategory->id}" title="Xem sản phẩm" class="tipsy-trigger">{$productcategory->name}</a>
								</td>
							<td>
								<small><a href="{$productcategory->getProductcateoryPath()}" target="_blank" title="Open new window">{$productcategory->slug}</a></small>
								</td>
							<td>{if $productcategory->checkStatusName('enable')}
									<span class="label label-success">{$productcategory->getStatusName()}</span>
								{else}
									<span class="label label-important">{$productcategory->getStatusName()}</span>
								{/if}</td>

							<td>
								<a title="{$lang.controller.labelFilterManager}" href="{$conf.rooturl_cms}{$controller}/filter/id/{$productcategory->id}/redirect/{$redirectUrl}" class="btn btn-mini tipsy-trigger"><i class="icon-filter"></i></a>
								{if $productcategory->parentid > 0}								
								<a title="{$lang.controller.labelProductAttributeManager}" href="{$conf.rooturl_cms}productgroupattribute/view/pcid/{$productcategory->id}" class="btn btn-mini tipsy-trigger" rel="shadowbox;height=500"><i class=" icon-th-list"></i></a>
								
								{/if}
                            	<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$productcategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
                            	{if $me->isGroup('administrator') || $me->isGroup('developer')}
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$productcategory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
                            	{/if}
							</td>
						</tr>
						{/if}

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
				<table>
					<tr>
						<td>{$lang.controller.labelName}:</td>
						<td style="float:left;"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-medium" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelSlugText}:</td>
						<td style="float:left;">
							<input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-medium" />
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelParentid}:</td>
						<td style="float:left;">
							<select name="fparentid" id="fparentid">
							<option value="0">------</option>
							{foreach from=$productcategoryList item=category}
								<option value="{$category->id}"  {if $category->id == $formData.fparentid}selected="selected"{/if}>{$category->name}</option>
							{/foreach}
							</select>
						</td>
					</tr>

					<tr>
						<td>{$lang.controller.labelDisplayorder}:</td>
						<td style="float:left;">
							<input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini" />
						</td>
					</tr>

					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;">
							<select name="fstatus" id="fstatus">
							<option value="">- - - -</option>
							{html_options options=$statusList selected=$formData.fstatus}
						</select>
						</td>
					</tr>

					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="float:left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>

					<tr>
						<td></td>
						<td style="float:left;">
						<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
					</tr>
				</table>
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




