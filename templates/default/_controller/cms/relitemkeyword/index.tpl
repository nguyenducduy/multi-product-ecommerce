<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Keyword Usage</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_relitemkeyword"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.relitemkeywordBulkToken}" />
				<table class="table table-striped">
		
				{if $relitemkeywords|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th><a href="{$filterUrl}sortby/displayorder/sorttype/{if $formData.sortby eq 'displayorder'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDisplayorder}</a></th>
							<th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
							<th><a href="{$filterUrl}sortby/objectid/sorttype/{if $formData.sortby eq 'objectid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelObjectid}</a></th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							
							
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
					{foreach item=relitemkeyword from=$relitemkeywords}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$relitemkeyword->id}" {if in_array($relitemkeyword->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td><input type="text" class="input-mini" name="fdisplayorder[{$relitemkeyword->id}]" value="{$relitemkeyword->displayorder}" /></td>
							<td>
								{if $relitemkeyword->checkTypeName('Product')}
									{$relitemkeyword->getTypeName()}
								{elseif $relitemkeyword->checkTypeName('News')} 
									{$relitemkeyword->getTypeName()}
								{else}
									{$relitemkeyword->getTypeName()}
								{/if}
								
							</td>
							<td>{$relitemkeyword->objectid}</td>
							<td>{if $relitemkeyword->checkStatusName('enable')}
									<span class="label label-success">{$relitemkeyword->getStatusName()}</span>
								{else}
									<span class="label label-important">{$relitemkeyword->getStatusName()}</span>
								{/if}
							</td>
							
							
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$relitemkeyword->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$relitemkeyword->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 
				
				{$lang.controller.labelKid}: <input type="text" name="fkid" id="fkid" value="{$formData.fkid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelType}: <select name="ftype" id="ftype">
					<option value="0">- - - -</option>
	                {html_options options=$typeList selected=$formData.ftype}
	            </select> -
	

				{$lang.controller.labelObjectid}: <input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini" /> - 

				
				
				
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/relitemkeyword/index";
		

		var kid = $('#fkid').val();
		if(kid.length > 0)
		{
			path += '/kid/' + kid;
		}

		var type = $('#ftype').val();
		if(type.length > 0)
		{
			path += '/type/' + type;
		}

		var objectid = $('#fobjectid').val();
		if(objectid.length > 0)
		{
			path += '/objectid/' + objectid;
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
			
			


