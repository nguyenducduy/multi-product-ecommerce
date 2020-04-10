<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ReverseAuctions</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_reverseauctions"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.reverseauctionsBulkToken}" />
				<table class="table table-striped">
		
				{if $reverseauctionss|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
							<th width="30">{$lang.controller.labelId}</th>
							
							<th><a href="{$filterUrl}sortby/productname/sorttype/{if $formData.sortby eq 'productname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelProductname}</a></th>
							<th><a href="{$filterUrl}sortby/price/sorttype/{if $formData.sortby eq 'price'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPrice}</a></th>
							<th><a href="{$filterUrl}sortby/startdate/sorttype/{if $formData.sortby eq 'startdate'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStartdate}</a></th>
							<th><a href="{$filterUrl}sortby/enddate/sorttype/{if $formData.sortby eq 'enddate'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEnddate}</a></th>
							<th><a href="{$filterUrl}sortby/datecreated/sorttype/{if $formData.sortby eq 'datecreated'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDatecreated}</a></th>
							<th>Status</th>
							<th width="120"><a href="">Thành viên tham gia</a></th>
							<th></th>
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
					{foreach item=reverseauctions from=$reverseauctionss}
		
						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$reverseauctions->id}" {if in_array($reverseauctions->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$reverseauctions->id}</td>
							<td>{$reverseauctions->productname}</td>
							<td>{$reverseauctions->price|number_format}</td>
							<td><span class="label label-info">{$reverseauctions->startdate|date_format:$lang.default.dateFormatTimeSmarty}</span></td>
							<td><span class="label label-warning">{$reverseauctions->enddate|date_format:$lang.default.dateFormatTimeSmarty}</span></td>
							<td>{$reverseauctions->datecreated|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$reverseauctions->getStatusName()}</td>
							<td><a rel="shadowbox" href="{$this->registry->conf.rooturl_cms}reverseauctionsuser/index/raid/{$reverseauctions->id}">Thành viên tham gia</a></td>
							<td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$reverseauctions->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i> {$lang.default.formEditLabel}</a> &nbsp;
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$reverseauctions->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i> {$lang.default.formDeleteLabel}</a>
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
				{$lang.controller.labelProductname}: <input type="text" name="fproductname" id="fproductname" value="{$formData.fproductname|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelPrice}: <input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelStartdate}: <input type="text" name="fstartdate" id="fstartdate" value="{$formData.fstartdate|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelEnddate}: <input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatecreated}: <input type="text" name="fdatecreated" id="fdatecreated" value="{$formData.fdatecreated|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelDatemodified}: <input type="text" name="fdatemodified" id="fdatemodified" value="{$formData.fdatemodified|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="productname" {if $formData.fsearchin eq "productname"}selected="selected"{/if}>{$lang.controller.labelProductname}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/reverseauctions/index";
		

		var productname = $('#fproductname').val();
		if(productname.length > 0)
		{
			path += '/productname/' + productname;
		}

		var price = $('#fprice').val();
		if(parseInt(price) > 0)
		{
			path += '/price/' + price;
		}

		var startdate = $('#fstartdate').val();
		if(startdate.length > 0)
		{
			path += '/startdate/' + startdate;
		}

		var enddate = $('#fenddate').val();
		if(enddate.length > 0)
		{
			path += '/enddate/' + enddate;
		}

		var datecreated = $('#fdatecreated').val();
		if(datecreated.length > 0)
		{
			path += '/datecreated/' + datecreated;
		}

		var datemodified = $('#fdatemodified').val();
		if(datemodified.length > 0)
		{
			path += '/datemodified/' + datemodified;
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
			
			


