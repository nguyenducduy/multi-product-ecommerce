<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">PriceEnemy</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_priceenemy"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.priceenemyBulkToken}" />
				<table class="table table-striped">
		
				{if $priceenemys|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>							
							
							<th><a href="{$filterUrl}sortby/pid/sorttype/{if $formData.sortby eq 'pid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPid}</a></th>
							
							<th><a href="{$filterUrl}sortby/eid/sorttype/{if $formData.sortby eq 'eid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEid}</a></th>
							<th><a href="{$filterUrl}sortby/url/sorttype/{if $formData.sortby eq 'url'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelUrl}</a></th>
							<th><a href="{$filterUrl}sortby/price/sorttype/{if $formData.sortby eq 'price'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPrice}</a></th>
							<th>{$lang.controller.labelPriceauto}</th>
							<th>{$lang.controller.labelNote}</th>
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
								</div>
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=priceenemyList from=$groupList}
					{foreach item=priceenemy from=$priceenemyList name=foo}
		
						{if $smarty.foreach.foo.first}
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$priceenemy->id}" {if in_array($priceenemy->id, $formData.fbulkid)}checked="checked"{/if}/></td>							
							
							<td rowspan="{$priceenemyList|@count}"><a target="_blank" href="{$conf.rooturl_cms}product/index/id/{$priceenemy->pid}" title="Xem chi tiết sản phẩm" class="tipsy-trigger"><span class="label label-info">{$priceenemy->pid}</span></a></td>							
							<td><b>{$priceenemy->enemyactor->name}</b></td>
							<td>{$priceenemy->url}</td>
							<td>{$priceenemy->price}</td>
							<td>{$priceenemy->priceauto}</td>
							<td>{$priceenemy->note}</td>
							<td>{if $priceenemy->checkStatusName('not sync')}
									<span class="label label-warning">{$priceenemy->getStatusName()}</span>
								{elseif $priceenemy->checkStatusName('synced')}
									<span class="label label-success">{$priceenemy->getStatusName()}</span>
								{else}
									<span class="label label-important">{$priceenemy->getStatusName()}</span>
								{/if}</td>							
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$priceenemy->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$priceenemy->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
						</tr>

						{else}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$priceenemy->id}" {if in_array($priceenemy->id, $formData.fbulkid)}checked="checked"{/if}/></td>							
																		
							<td><b>{$priceenemy->enemyactor->name}</b></td>
							<td>{$priceenemy->url}</td>
							<td>{$priceenemy->price}</td>
							<td>{$priceenemy->priceauto}</td>
							<td>{$priceenemy->note}</td>
							<td>{if $priceenemy->checkStatusName('not sync')}
									<span class="label label-warning">{$priceenemy->getStatusName()}</span>
								{elseif $priceenemy->checkStatusName('synced')}
									<span class="label label-success">{$priceenemy->getStatusName()}</span>
								{else}
									<span class="label label-important">{$priceenemy->getStatusName()}</span>
								{/if}</td>							
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$priceenemy->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$priceenemy->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
							</td>
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
				{$lang.controller.labelPid}: <input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini" /> - 				

				{$lang.controller.labelEid}: <input type="text" name="feid" id="feid" value="{$formData.feid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPrice}: <input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStatus}: <input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/priceenemy/index";
		

		var pid = $('#fpid').val();
		if(pid.length > 0)
		{
			path += '/pid/' + pid;
		}

		var uid = $('#fuid').val();
		if(uid.length > 0)
		{
			path += '/uid/' + uid;
		}

		var eid = $('#feid').val();
		if(eid.length > 0)
		{
			path += '/eid/' + eid;
		}

		var price = $('#fprice').val();
		if(parseInt(price) > 0)
		{
			path += '/price/' + price;
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
		
		var keyword = $("#fkeyword").val();
		if(keyword.length > 0)
		{
			path += "/keyword/" + keyword;
		}

		var keywordin = $("#fsearchin").val();
		if(keywordin.length > 0)
		{
			path += "/searchin/" + keywordin;
		}
		
		document.location.href= path;
	}
</script>
{/literal}
			
			


