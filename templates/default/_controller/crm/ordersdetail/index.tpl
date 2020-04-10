<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">OrdersDetail</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>

<a class="pull-right btn btn-success" href="{$conf.rooturl_admin}{$controller}/add">{$lang.controller.head_add}</a>

<div class="page-header" rel="menu_ordersdetail"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl_admin}{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.ordersdetailBulkToken}" />
				<table class="table table-striped">
		
				{if $ordersdetails|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th>{$lang.controller.labelOid}</th>
							<th>{$lang.controller.labelBid}</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelPricesell}</th>
							<th>{$lang.controller.labelPricediscount}</th>
							<th>{$lang.controller.labelPricefinal}</th>
							<th>{$lang.controller.labelQuantity}</th>
							<th>{$lang.controller.labelWeight}</th>
							<th>{$lang.controller.labelSize}</th>
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
					{foreach item=ordersdetail from=$ordersdetails}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$ordersdetail->id}" {if in_array($ordersdetail->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$ordersdetail->id}</td>
							
							<td>{$ordersdetail->oid}</td>
							<td>{$ordersdetail->bid}</td>
							<td>{$ordersdetail->name}</td>
							<td>{$ordersdetail->pricesell}</td>
							<td>{$ordersdetail->pricediscount}</td>
							<td>{$ordersdetail->pricefinal}</td>
							<td>{$ordersdetail->quantity}</td>
							<td>{$ordersdetail->weight}</td>
							<td>{$ordersdetail->size}</td>
							
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_admin}{$controller}/edit/id/{$ordersdetail->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl_admin}{$controller}/delete/id/{$ordersdetail->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelOid}: <input type="text" name="foid" id="foid" value="{$formData.foid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelBid}: <input type="text" name="fbid" id="fbid" value="{$formData.fbid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="name" {if $formData.fsearchin eq "name"}selected="selected"{/if}>{$lang.controller.labelName}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl_admin + "ordersdetail/index";
		

		var oid = $('#foid').val();
		if(oid.length > 0)
		{
			path += '/oid/' + oid;
		}

		var bid = $('#fbid').val();
		if(bid.length > 0)
		{
			path += '/bid/' + bid;
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
			
			


