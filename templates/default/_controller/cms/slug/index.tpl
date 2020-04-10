<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Slug</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_slug"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.slugBulkToken}" />
				<table class="table table-striped">
		
				{if $slugs|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							
							<th>Creator</th>
							<th>{$lang.controller.labelSlug}</th>
							<th width="120">Controller / ID</th>
							<th>{$lang.controller.labelStatus}</th>
							<th>{$lang.controller.labelRef}</th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th width="70"></th>
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
					{foreach item=slug from=$slugs}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$slug->id}" {if in_array($slug->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$slug->id}</td>
							
							<td>{if $slug->uid > 0}<a href="{$slug->actor->getUserPath()}" title="{$slug->actor->fullname}" class="tipsy-trigger"><img src="{$slug->actor->getSmallImage()}" width="30" /></a>{/if}</td>
							<td><a href="{$slug->getObjectPath()}" target="_blank"><small>{$slug->slug}</small></a></td>
							
							<td><span class="label label-inverse">{$slug->controller}</span> / <span class="label label-inverse">{$slug->objectid}</span></td>
							<td><span class="label {if $slug->checkStatusName('synced')}label-success{elseif $slug->checkStatusName('notfound')}label-important{/if}">{$slug->getStatusName()}</span></td>
							<td>{if $slug->ref > 0}<a href="{$conf.rooturl_cms}slug/index/id/{$slug->ref}"><span class="label label-info">{$slug->ref}</span></a>{else}n/a{/if}</td>
							<td>{$slug->datecreated|date_format}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$slug->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$slug->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				<table border="0" cellpadding="5">
					<tr>
						<td align="right">{$lang.controller.labelUid}</td>
						<td align="left"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini" /></td>
						<td></td>
					</tr>
					<tr>
						<td align="right">{$lang.controller.labelSlug}</td>
						<td align="left"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge" /></td>
						<td></td>
					</tr>
					<tr>
						<td align="right">{$lang.controller.labelController}</td>
						<td align="left">
							<select id="fcontroller" name="fcontroller">
								<option value="">- - - - -</option>
								<option value="product" {if $formData.fcontroller == 'product'}selected="selected"{/if}>Product</option>
								<option value="productcategory" {if $formData.fcontroller == 'productcategory'}selected="selected"{/if}>Product Category</option>
								<option value="vendor" {if $formData.fcontroller == 'vendor'}selected="selected"{/if}>Vendor</option>
								<option value="news" {if $formData.fcontroller == 'news'}selected="selected"{/if}>News</option>
								<option value="newscategory" {if $formData.fcontroller == 'newscategory'}selected="selected"{/if}>News Category</option>
								<option value="stuffcategory" {if $formData.fcontroller == 'stuffcategory'}selected="selected"{/if}>Stuff Category</option>
								<option value="page" {if $formData.fcontroller == 'page'}selected="selected"{/if}>Page</option>
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td align="right">{$lang.controller.labelObjectid}</td>
						<td align="left"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini" /></td>
						<td></td>
					</tr>
					<tr>
						<td align="right">{$lang.controller.labelStatus}</td>
						<td align="left">
							<select id="fstatus" name="fstatus">
								<option value="0">- - - - -</option>
								{html_options options=$statusList selected=$formData.fstatus}
							</select>
						</td>
						<td></td>
					</tr>
					<tr>
						<td align="right">{$lang.controller.labelId}</td>
						<td align="left"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td align="left"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
						<td></td>
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
		var path = rooturl + controllerGroup + "/slug/index";
		

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var slug = $('#fslug').val();
		if(slug.length > 0)
		{
			path += '/slug/' + slug;
		}

		var controller = $('#fcontroller').val();
		if(controller.length > 0)
		{
			path += '/controller/' + controller;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
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
			
			


