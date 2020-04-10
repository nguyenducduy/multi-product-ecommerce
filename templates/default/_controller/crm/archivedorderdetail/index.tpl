<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ArchivedorderDetail</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_archivedorderdetail"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.archivedorderdetailBulkToken}" />
				<table class="table table-striped">
		
				{if $archivedorderdetails|@count > 0}
					<thead>
						<tr>
						 
							
							<th>{$lang.controller.labelPid}</th>
							<th>{$lang.controller.labelOorderid}</th>
							<th>{$lang.controller.labelSaleorderid}</th>
							<th><a href="{$filterUrl}sortby/productid/sorttype/{if $formData.sortby eq 'productid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelProductid}</a></th>
							<th>{$lang.controller.labelQuantity}</th>
							<th><a href="{$filterUrl}sortby/saleprice/sorttype/{if $formData.sortby eq 'saleprice'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSaleprice}</a></th>
							<th>{$lang.controller.labelOutputtypeid}</th>
							<th>{$lang.controller.labelVat}</th>
							<th>{$lang.controller.labelSalepriceerp}</th>
							<th>{$lang.controller.labelEndwarrantytime}</th>
							<th>{$lang.controller.labelIspromotionautoadd}</th>
							<th>{$lang.controller.labelPromotionid}</th>
							<th>{$lang.controller.labelPromotionlistgroupid}</th>
							<th>{$lang.controller.labelApplyproductid}</th>
							<th>{$lang.controller.labelReplicationstoreid}</th>
							<th>{$lang.controller.labelAdjustpricetypeid}</th>
							<th>{$lang.controller.labelAdjustprice}</th>
							<th>{$lang.controller.labelAdjustpricecontent}</th>
							<th>{$lang.controller.labelDiscountcode}</th>
							<th>{$lang.controller.labelAdjustpriceuser}</th>
							<th>{$lang.controller.labelVatpercent}</th>
							<th><a href="{$filterUrl}sortby/retailprice/sorttype/{if $formData.sortby eq 'retailprice'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelRetailprice}</a></th>
							<th>{$lang.controller.labelInputvoucherdetailid}</th>
							<th>{$lang.controller.labelBuyinputvoucherid}</th>
							<th>{$lang.controller.labelInputvoucherdate}</th>
							<th>{$lang.controller.labelIsnew}</th>
							<th>{$lang.controller.labelIsshowproduct}</th>
							<th>{$lang.controller.labelCostprice}</th>
							<th>{$lang.controller.labelProductsaleskitid}</th>
							<th>{$lang.controller.labelRefproductid}</th>
							<th>{$lang.controller.labelProductcomboid}</th>
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
					
					
								
					
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=archivedorderdetail from=$archivedorderdetails}
		
						<tr>
							<td>{$archivedorderdetail->pid}</td>
							<td>{$archivedorderdetail->oorderid}</td>
							<td><span class='label label-info'>{$archivedorderdetail->saleorderid}</span></td>
							<td>{$archivedorderdetail->productid}</td>
							<td>{$archivedorderdetail->quantity}</td>
							<td>{$archivedorderdetail->saleprice}</td>
							<td>{$archivedorderdetail->outputtypeid}</td>
							<td>{$archivedorderdetail->vat}</td>
							<td>{$archivedorderdetail->salepriceerp}</td>
							<td>{$archivedorderdetail->endwarrantytime}</td>
							<td>{$archivedorderdetail->ispromotionautoadd}</td>
							<td>{$archivedorderdetail->promotionid}</td>
							<td>{$archivedorderdetail->promotionlistgroupid}</td>
							<td>{$archivedorderdetail->applyproductid}</td>
							<td>{$archivedorderdetail->replicationstoreid}</td>
							<td>{$archivedorderdetail->adjustpricetypeid}</td>
							<td>{$archivedorderdetail->adjustprice}</td>
							<td>{$archivedorderdetail->adjustpricecontent}</td>
							<td>{$archivedorderdetail->discountcode}</td>
							<td>{$archivedorderdetail->adjustpriceuser}</td>
							<td>{$archivedorderdetail->vatpercent}</td>
							<td>{$archivedorderdetail->retailprice}</td>
							<td>{$archivedorderdetail->inputvoucherdetailid}</td>
							<td>{$archivedorderdetail->buyinputvoucherid}</td>
							<td>{$archivedorderdetail->inputvoucherdate|date_format:$lang.default.dateFormatTimeSmarty}</td>
							<td>{$archivedorderdetail->isnew}</td>
							<td>{$archivedorderdetail->isshowproduct}</td>
							<td>{$archivedorderdetail->costprice}</td>
							<td>{$archivedorderdetail->productsaleskitid}</td>
							<td>{$archivedorderdetail->refproductid}</td>
							<td>{$archivedorderdetail->productcomboid}</td>
							
						
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
				{$lang.controller.labelSaleorderid}: <input type="text" name="fsaleorderid" id="fsaleorderid" value="{$formData.fsaleorderid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelProductid}: <input type="text" name="fproductid" id="fproductid" value="{$formData.fproductid|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelSaleprice}: <input type="text" name="fsaleprice" id="fsaleprice" value="{$formData.fsaleprice|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelRetailprice}: <input type="text" name="fretailprice" id="fretailprice" value="{$formData.fretailprice|@htmlspecialchars}" class="input-mini" /> - 

				{$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> - 

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="productid" {if $formData.fsearchin eq "productid"}selected="selected"{/if}>{$lang.controller.labelProductid}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/archivedorderdetail/index";
		

		var saleorderid = $('#fsaleorderid').val();
		if(saleorderid.length > 0)
		{
			path += '/saleorderid/' + saleorderid;
		}

		var productid = $('#fproductid').val();
		if(productid.length > 0)
		{
			path += '/productid/' + productid;
		}

		var saleprice = $('#fsaleprice').val();
		if(saleprice.length > 0)
		{
			path += '/saleprice/' + saleprice;
		}

		var retailprice = $('#fretailprice').val();
		if(retailprice.length > 0)
		{
			path += '/retailprice/' + retailprice;
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
			
			


