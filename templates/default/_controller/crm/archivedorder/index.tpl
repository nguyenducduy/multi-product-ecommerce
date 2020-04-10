<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Archivedorder</a> <span class="divider">/</span></li>
	<li class="active">Listing</li>
</ul>



<div class="page-header" rel="menu_archivedorder"><h1>{$lang.controller.head_list}</h1></div>


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
				<input type="hidden" name="ftoken" value="{$smarty.session.archivedorderBulkToken}" />
				<table class="table table-striped">
		
				{if $archivedorders|@count > 0}
					<thead>
						<tr>
						 
							<th><a href="{$filterUrl}sortby/saleorderid/sorttype/{if $formData.sortby eq 'saleorderid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSaleorderid}</a></th>
							<th><a href="{$filterUrl}sortby/ordertypeid/sorttype/{if $formData.sortby eq 'ordertypeid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelOrdertypeid}</a></th>
							<th><a href="{$filterUrl}sortby/crmcustomerid/sorttype/{if $formData.sortby eq 'crmcustomerid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCrmcustomerid}</a></th>
							<th><a href="{$filterUrl}sortby/customername/sorttype/{if $formData.sortby eq 'customername'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCustomername}</a></th>
							<th><a href="{$filterUrl}sortby/contactphone/sorttype/{if $formData.sortby eq 'contactphone'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelContactphone}</a></th>
							<th><a href="{$filterUrl}sortby/customeraddress/sorttype/{if $formData.sortby eq 'customeraddress'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">Ngày tạo</a></th>
							<th style='width: 200px;'>
							</th>
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
					{foreach item=archivedorder from=$archivedorders}
		
						<tr>
							
							<td><a class='label label-info' href="{$conf.rooturl_crm}archivedorderdetail/index/saleorderid/{$archivedorder->saleorderid}">{$archivedorder->saleorderid}</td>
							<td>{$archivedorder->ordername}</td>
							<td>{$archivedorder->crmcustomerid}</a></td>
							<td>{$archivedorder->customername}</td>
							<td>{$archivedorder->customerphone}</td>
							<td>{$archivedorder->createdate}</td>
							<td style='width: 240px;'>
								{if {$archivedorder->crmcustomerid}!="" && {$archivedorder->crmcustomerid}>"0" || {$archivedorder->customerphone}!=''}<a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl_crm}customer/index/group/0/searchkey/{if {$archivedorder->customerphone}!=''}{$archivedorder->customerphone}{elseif {$archivedorder->crmcustomerid}!=""}{$archivedorder->crmcustomerid}{/if}" class="btn btn-mini"><i class="icon-pencil">Tìm kiếm từ CRM</i></a> {/if}
								{if {$archivedorder->IsDetail}==1}
									<a title="{$lang.default.formActionDeleteTooltip}" href="{$conf.rooturl_crm}archivedorderdetail/detailshow/saleid/{$archivedorder->saleorderid}" class="btn btn-mini"><i class="icon-folder-open icon-white">Chi tiết</i></a>
								{else}
									<a title="{$lang.default.formActionDeleteTooltip}" href="#" class="btn btn-mini"><i class="icon-folder-open icon-white">Chưa đồng bộ</i></a>
								{/if}
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
				<table style="width:50%;">
					<tr>
						<td>Đã sync detail:</td>
						<td style='text-align: left;width:80%'>
							<select name="fisdetail" id="fisdetail">
								<option value=''>----</option>
								<option value='1' {if {$formData.fsaleorderid|@htmlspecialchars}==0}selected{/if}>Đã đồng bộ detail</option>
								<option value='0' {if {$formData.fsaleorderid|@htmlspecialchars}==1}selected{/if}>Chưa đồng bộ detail</option>
							</select>
<!-- 							<input type="text" name="fisdetail" id="fisdetail" value="{$formData.fsaleorderid|@htmlspecialchars}" class="input-mini" style='width:200px'/> - 
 -->						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelSaleorderid}:</td>
						<td style='text-align: left;width:80%'><input type="text" name="fsaleorderid" id="fsaleorderid" value="{$formData.fsaleorderid|@htmlspecialchars}" class="input-mini" style='width:200px'/> - </td>
					</tr>
					<tr>
						<td>{$lang.controller.labelOrdertypeid}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fordertypeid" id="fordertypeid" value="{$formData.fordertypeid|@htmlspecialchars}" class="input-mini" /> - </td>
					</tr>
					
					
					<tr>
						<td>{$lang.controller.labelCustomername}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fcustomername" id="fcustomername" value="{$formData.fcustomername|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					
					<tr>
						<td>{$lang.controller.labelCustomerphone}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fcustomerphone" id="fcustomerphone" value="{$formData.fcustomerphone|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					
					<tr>
						<td>{$lang.controller.labelGender}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fgender" id="fgender" value="{$formData.fgender|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					
					<tr>
						<td>{$lang.controller.labelProvinceid}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fprovinceid" id="fprovinceid" value="{$formData.fprovinceid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					
					
					<tr>
						<td>{$lang.controller.labelIssmspromotion}:  </td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fissmspromotion" id="fissmspromotion" value="{$formData.fissmspromotion|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelCrmcustomerid}:  </td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fcrmcustomerid" id="fcrmcustomerid" value="{$formData.fcrmcustomerid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelDatearchived}:</td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fdatearchived" id="fdatearchived" value="{$formData.fdatearchived|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:  </td>
						<td style='text-align: left;width:80%'><input style='width:200px' type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
				</table>
				 

				 

				
				
				<!-- Createdate: <input type="text" name="fcreatedate" id="fcreatedate" value="{$formData.fcreatedate|@htmlspecialchars}" class="input-mini" /> -  -->

				
				{$lang.controller.formKeywordLabel}:
				<input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" />
				<select name="fsearchin" id="fsearchin">
					<option value="">{$lang.controller.formKeywordInLabel}</option>
					<option value="saleorderid" {if $formData.fsearchin eq "saleorderid"}selected="selected"{/if}>{$lang.controller.labelSaleorderid}</option>
					<option value="customername" {if $formData.fsearchin eq "customername"}selected="selected"{/if}>{$lang.controller.labelCustomername}</option>
					<option value="customeraddress" {if $formData.fsearchin eq "customeraddress"}selected="selected"{/if}>{$lang.controller.labelCustomeraddress}</option>
					<option value="customerphone" {if $formData.fsearchin eq "customerphone"}selected="selected"{/if}>{$lang.controller.labelCustomerphone}</option>
					<option value="contactname" {if $formData.fsearchin eq "contactname"}selected="selected"{/if}>{$lang.controller.labelContactname}</option>
					<option value="deliveryaddress" {if $formData.fsearchin eq "deliveryaddress"}selected="selected"{/if}>{$lang.controller.labelDeliveryaddress}</option>
					<option value="voucherconcern" {if $formData.fsearchin eq "voucherconcern"}selected="selected"{/if}>{$lang.controller.labelVoucherconcern}</option>
					<option value="deliveryuser" {if $formData.fsearchin eq "deliveryuser"}selected="selected"{/if}>{$lang.controller.labelDeliveryuser}</option>
					<option value="parentsaleorderid" {if $formData.fsearchin eq "parentsaleorderid"}selected="selected"{/if}>{$lang.controller.labelParentsaleorderid}</option>
					<option value="thirdpartyvoucher" {if $formData.fsearchin eq "thirdpartyvoucher"}selected="selected"{/if}>{$lang.controller.labelThirdpartyvoucher}</option>
					<option value="contactphone" {if $formData.fsearchin eq "contactphone"}selected="selected"{/if}>{$lang.controller.labelContactphone}</option></select>
				
				<input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
		
			</form>
		</div><!-- end #tab2 -->
	</div>
</div>
			
			

{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/archivedorder/index";
		

		var saleorderid = $('#fsaleorderid').val();
		if(saleorderid.length > 0)
		{
			path += '/saleorderid/' + saleorderid;
		}
		var isdetail = $('#fisdetail').val();
		if(isdetail.length > 0)
		{
			path += '/isdetail/' + isdetail;
		}


		var ordertypeid = $('#fordertypeid').val();
		if(ordertypeid.length > 0)
		{
			path += '/ordertypeid/' + ordertypeid;
		}

		

		var customername = $('#fcustomername').val();
		if(customername.length > 0)
		{
			path += '/customername/' + customername;
		}

		
		var customerphone = $('#fcustomerphone').val();
		if(customerphone.length > 0)
		{
			path += '/customerphone/' + customerphone;
		}

		

		var gender = $('#fgender').val();
		if(gender.length > 0)
		{
			path += '/gender/' + gender;
		}

		

		

		var provinceid = $('#fprovinceid').val();
		if(provinceid.length > 0)
		{
			path += '/provinceid/' + provinceid;
		}

		

		var issmspromotion = $('#fissmspromotion').val();
		if(issmspromotion.length > 0)
		{
			path += '/issmspromotion/' + issmspromotion;
		}

		
		var crmcustomerid = $('#fcrmcustomerid').val();
		if(crmcustomerid.length > 0)
		{
			path += '/crmcustomerid/' + crmcustomerid;
		}

		var datearchived = $('#fdatearchived').val();
		if(datearchived.length > 0)
		{
			path += '/datearchived/' + datearchived;
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
			
			


