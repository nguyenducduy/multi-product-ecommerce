<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Promotiongroup</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_promotiongroup"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.promotiongroupBulkToken}" />
				<table class="table table-striped">
		
				{if $promotiongroups|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelPromoid}</th>
							<th>{$lang.controller.labelPromolgusercreate}</th>
							<th>{$lang.controller.labelPromolguserdeleted}</th>
							<th><a href="{$filterUrl}sortby/promolgname/sorttype/{if $formData.sortby eq 'promolgname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPromolgname}</a></th>
							<th>{$lang.controller.labelPromolgisfixed}</th>
							<th>{$lang.controller.labelPromolgisdeleted}</th>
							<th>{$lang.controller.labelPromolgisdiscount}</th>
							<th>{$lang.controller.labelPromolgdiscountvalue}</th>
							<th>{$lang.controller.labelPromolgisdiscountpercent}</th>
							<th>{$lang.controller.labelPromolgiscondition}</th>
							<th>{$lang.controller.labelPromolgconditiontext}</th>
							<th>{$lang.controller.labelPromolgtype}</th>
							<th>{$lang.controller.labelPromotiondateadd}</th>
							<th>{$lang.controller.labelPromolgdatemodify}</th>
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
					{foreach item=promotiongroup from=$promotiongroups}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$promotiongroup->id}" {if in_array($promotiongroup->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$promotiongroup->id}</td>
							
							<td>{$promotiongroup->promoid}</td>
							<td>{$promotiongroup->promolgusercreate}</td>
							<td>{$promotiongroup->promolguserdeleted}</td>
							<td>{$promotiongroup->promolgname}</td>
							<td>{$promotiongroup->promolgisfixed}</td>
							<td>{$promotiongroup->promolgisdeleted}</td>
							<td>{$promotiongroup->promolgisdiscount}</td>
							<td>{$promotiongroup->promolgdiscountvalue}</td>
							<td>{$promotiongroup->promolgisdiscountpercent}</td>
							<td>{$promotiongroup->promolgiscondition}</td>
							<td>{$promotiongroup->promolgconditiontext}</td>
							<td>{$promotiongroup->promolgtype}</td>
							<td>{$promotiongroup->promotiondateadd|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$promotiongroup->promolgdatemodify|date_format:$lang.default.dateFormatTimeSmarty}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$promotiongroup->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$promotiongroup->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelPromolgname}: <input type="text" name="fpromolgname" id="fpromolgname" value="{$formData.fpromolgname|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/promotiongroup/index";
		

		var promolgname = $('#fpromolgname').val();
		if(promolgname.length > 0)
		{
			path += '/promolgname/' + promolgname;
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
			
			


