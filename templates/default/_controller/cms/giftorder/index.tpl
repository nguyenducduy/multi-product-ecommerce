<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Giftorder</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_giftorder"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.giftorderBulkToken}" />
				<table class="table table-striped">
		
				{if $giftorders|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/pricefrom/sorttype/{if $formData.sortby eq 'pricefrom'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPricefrom}</a></th>
							<th><a href="{$filterUrl}sortby/priceto/sorttype/{if $formData.sortby eq 'priceto'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPriceto}</a></th>
							<th><a href="{$filterUrl}sortby/startdate/sorttype/{if $formData.sortby eq 'startdate'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStartdate}</a></th>
							<th><a href="{$filterUrl}sortby/enddate/sorttype/{if $formData.sortby eq 'enddate'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEnddate}</a></th>
							<th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
							<th>{$lang.controller.labelDatecreated}</th>
							<th>Xem tất cả sản phẩm</th>
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
					{foreach item=giftorder from=$giftorders}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$giftorder->id}" {if in_array($giftorder->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$giftorder->id}</td>
							
							<td>{$giftorder->pricefrom|number_format} đ</td>
							<td>{$giftorder->priceto|number_format} đ</td>
							<td><span class="label label-info">{$giftorder->startdate|date_format:$lang.default.dateFormatTimeSmarty}</span></td>
							<td><span class="label label-warning">{$giftorder->enddate|date_format:$lang.default.dateFormatTimeSmarty}</span></td>
							<td>{$giftorder->getStatusName()}</td>
							<td>{$giftorder->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>
								<a rel="shadowbox" href="{$registry->conf.rooturl_cms}giftorderproduct/index/goid/{$giftorder->id}">Xem tất cả sản phẩm({$giftorder->getGiftOderProduct()})</a>
							</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$giftorder->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$giftorder->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelPricefrom}: <input type="text" name="fpricefrom" id="fpricefrom" value="{$formData.fpricefrom|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPriceto}: <input type="text" name="fpriceto" id="fpriceto" value="{$formData.fpriceto|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEnddate}: <input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|@htmlspecialchars}" class="input-mini" /> - 

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
		var path = rooturl + controllerGroup + "/giftorder/index";
		

		var pricefrom = $('#fpricefrom').val();
		if(parseInt(pricefrom) > 0)
		{
			path += '/pricefrom/' + pricefrom;
		}

		var priceto = $('#fpriceto').val();
		if(parseInt(priceto) > 0)
		{
			path += '/priceto/' + priceto;
		}

		var enddate = $('#fenddate').val();
		if(enddate.length > 0)
		{
			path += '/enddate/' + enddate;
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
			
			


