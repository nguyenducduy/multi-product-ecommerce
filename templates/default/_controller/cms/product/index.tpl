<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">Danh sách</li>
</ul>


<div class="page-header" rel="menu_product"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
		<li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
		{if $formData.search != ''}
			<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
		{/if}
		<li class="pull-right "><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
		<li class="pull-right "><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/importproductsize">Import kích thước sản phẩm</a></li>
		<li class="pull-right "><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/importkeysellingpoint">Import key selling point</a></li>
        <li class="pull-right "><a target="_blank" class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/exportinfoproductweb">Export data</a></li>
        <li class="pull-right "><a target="_blank" class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/exportproductsize">Export kích thước sản phẩm</a></li>		
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}

			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.productBulkToken}" />
				<table class="table table-striped">

				{if $products|@count > 0}
					<thead>
						<tr>
						   <th width="40"><input class="check-all" type="checkbox" /></th>
						    <th>TT hiển thị</th>
							<th>ID</th>
							{if $smarty.session.producthidephoto == 0}<th>{$lang.controller.iamgeLabel}</th>{/if}
							<th>{$lang.controller.labelPcid}</th>
							<th>{$lang.controller.labelVid}</th>
							<th>Barcode</th>
							<th width="250">{$lang.controller.labelName}</th>
							<th><a href="{$filterUrl}sortby/sellprice/sorttype/{if $formData.sortby eq 'sellprice'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelSellprice}</a></th>
							<th>SL</th>
							<th>{$lang.controller.labelIsbagdehot}</th>
							<th>{$lang.controller.labelIsbagdenew}</th>
							<th>{$lang.controller.labelIsbagdegift}</th>
							<th>{$lang.controller.labelOnsiteStatus}</th>
							<th width="140"></th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="15">
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
									<input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
								</div>

								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
					<tbody>
					{foreach item=product from=$products}

						<tr>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}><input type="checkbox" name="fbulkid[]" value="{$product->id}" {if in_array($product->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}><input type="text" class="input-mini" name="fdisplayorder[{$product->id}]" value="{$product->displayorder}" style="width:30px;"/></td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{$product->id}<br/>{if $product->customizetype == 20}<span class="label label-warning">Color</span>{/if}</td>
							{if $smarty.session.producthidephoto == 0}<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->image != ''}<a href="{$product->getSmallImage()}" rel="shadowbox"><img src="{$product->getSmallImage()}" width="50" alt="{$product->name}" /></a>{/if}</td>{/if}


							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{foreach item=category from=$productcategoryList}
								{if $product->pcid == $category->id}
								<a href="{$conf.rooturl_cms}product/index/pcid/{$category->id}"><small>{$category->name|replace:'&nbsp;' : ''}</small></a>
								{/if}
								{/foreach}
							</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{foreach item=vendor from=$vendorList}
								{if $product->vid == $vendor->id}
								<a href="{$conf.rooturl_cms}product/index/vid/{$vendor->id}"><small>{$vendor->name}</small></a>
								{/if}
								{/foreach}
							</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->barcode != ''}<span class="label label-info">{$product->barcode}</span>{else}<span class="label">No barcode</span>{/if}</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>
								<a href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$product->id}/redirect/{$redirectUrl}"><span class="label {if $product->checkonsitestatusName('no sell') == false}label-success{/if}">{$product->name}</span></a>
								<br /><small class="slugtext"><a href="{$product->getProductPath()}" target="_blank" title="Preview">{$product->slug}</a></small>
							</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>
								{if $product->barcode != ''}
								<a href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productprice/index/pbarcode/{$product->barcode}' , '', 'giá')">{if $product->sellprice > 0}{$product->sellprice}{else}Cập nhật giá{/if}</a><br/>
								<a href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productprice/index/pbarcode/{$product->barcode}/tab/2' ,'' , 'giá')">Giá đối thủ</a>
								{/if}
							</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>
								{if $product->barcode != ''}
								<a href="javascript:void(0)" onclick="viewShadowbox('{$conf.rooturl_admin}productstock/index/pbarcode/{$product->barcode}' , '{$product->name|escape}', 'tồn kho')"><span class="badge badge-info">{$product->instock}</span></a>
								{else}
								<span class="badge">{$product->instock}</span>
								{/if}
							</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->isbagdehot ==1}<i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsbagdehot}"></i>{/if}</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->isbagdenew ==1}<i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsbagdenew}"></i>{/if}</td>
							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->isbagdegift ==1}<i class="icon-ok tipsy-trigger" title="{$lang.controller.labelIsbagdegift}"></i>{/if}</td>


							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}>{if $product->checkonsitestatusName('no sell')}
									<span class="label label">{$product->getonsitestatusName()}</span>
								{elseif $product->checkonsitestatusName('prepaid_erp')}
									<span class="label label-warning">{$product->getonsitestatusName()}</span>
								{elseif $product->checkonsitestatusName('prepaid_dm')}
									<span class="label label-warning">{$product->getonsitestatusName()}</span>
								{elseif $product->checkonsitestatusName('erp')}
									<span class="label label-success">{$product->getonsitestatusName()}</span>
								{elseif $product->checkonsitestatusName('dm')}
									<span class="label label-success">{$product->getonsitestatusName()}</span>								
								{else}
									<span class="label label-success">{$product->getonsitestatusName()}</span>
								{/if}
							</td>

							<td {if $product->customizetype == 20}style="background-color:#e1e1e1"{/if}><a title="{$lang.controller.formActionCloneTooltip}" href="javascript:void(0)" onclick="cloneFunction('{$conf.rooturl}{$controllerGroup}/{$controller}/clone/id/{$product->id}/redirect/{$redirectUrl}')" class="btn btn-mini"><i class="icon-copy"></i> Clone</a> &nbsp;
							<a title="{$lang.default.formActionEditTooltip}" href="{if $product->productmainlink != ''}{$product->productmainlink}{else}{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$product->id}/redirect/{$redirectUrl}{/if}" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
								
								{if $me->isGroup('administrator') || $me->isGroup('developer')}
								<a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$product->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
				<table>
					<tr>
						<td>{$lang.controller.labelVid}:</td>
						<td style="float:left;"><select name="fvid" id="fvid" style="width:100px;">
						<option value="0">----</option>
						{foreach item=vendor from=$vendorList}
							<option value="{$vendor->id}" {if $vendor->id == $formData.fvid}selected="selected"{/if}>{$vendor->name}</option>
						{/foreach}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelVsubid}:</td>
						<td style="float:left;"><select name="fvsubid" id="fvsubid" style="width: 100px;">
						<option value="0" selected="selected">----</option>
						{foreach item=vendor from=$subVendorList}
							<option value="{$vendor->id}" {if $vendor->id == $formData.fsubvid}selected="selected"{/if}>{$vendor->name}</option>
						{/foreach}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelPcid}:</td>
						<td style="float:left;"><select name="fpcid" id="fpcid" style="width: 200px;">
						<option value="0">----</option>
						{foreach from=$productcategoryList item=productCategory}
						{if $productCategory->parentid==0}
							</optgroup><optgroup label="{$productCategory->name}">
						{else}
							<option value="{$productCategory->id}" {if $formData.fpcid == $productCategory->id}selected="selected"{/if}>{$productCategory->name}</option>{$formData.fpcid}
						{/if}
						{/foreach}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelBarcode}:</td>
						<td style="float:left;"><input type="text" name="fbarcode" id="fbarcode" value="{$formData.fbarcode|@htmlspecialchars}" class="input-medium" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelBarcodeStatus}:</td>
						<td style="float:left;">
							<select id="fbarcodestatus" name="fbarcodestatus">
							<option value="0">-----</option>
							<option value="1" {if $formData.fbarcodestatus == 1}selected="selected"{/if}>{$lang.controller.labelAll}</option>
							<option value="2"{if $formData.fbarcodestatus == 2}selected="selected"{/if}>{$lang.controller.labelHaveBarcode}</option>
							<option value="3" {if $formData.fbarcodestatus == 3}selected="selected"{/if}>{$lang.controller.labelNotHaveBarcode}</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>{$lang.controller.labelName}:</td>
						<td style="float:left;"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-medium" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelUnitprice}:</td>
						<td style="float:left;"><input type="text" name="funitprice" id="funitprice" value="{$formData.funitprice|@htmlspecialchars}" class="input-medium" /></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelSellprice}:</td>
						<td style="float:left;"><input type="text" name="fsellprice" id="fsellprice" value="{$formData.fsellprice|@htmlspecialchars}" class="input-medium" /> </td>
					</tr>
					<tr>
						<td>{$lang.controller.labelInstockSearch}:</td>
						<td style="float:left;"><select id="finstock" name="finstock">
							<option value="0">-----</option>
							<option value="1"{if $formData.finstock == 1}selected="selected"{/if}>{$lang.controller.labelHaveInstock}</option>
							<option value="2" {if $formData.finstock == 2}selected="selected"{/if}>{$lang.controller.labelNotHaveInstock}</option>
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelSyncStatus}:</td>
						<td style="float:left;"><select name="fsyncstatus" id="fsyncstatus" style="width:130px;">
							<option value="">- - - -</option>
							{html_options options=$syncstatusList selected=$formData.fsyncstatus}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelStatus}:</td>
						<td style="float:left;"><select name="fstatus" id="fstatus" style="width:130px;">
							<option value="">- - - -</option>
							{html_options options=$statusList selected=$formData.fstatus}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelOnsiteStatus}:</td>
						<td style="float:left;"><select name="fonsitestatus" id="fonsitestatus" style="width:160px;">
							<option value="">- - - -</option>
							{html_options options=$onsitestatusList selected=$formData.fonsitestatus}
						</select></td>
					</tr>
					<tr>
						<td>Trạng thái bán hàng:</td>
						<td style="float:left;"><select name="fbusinessstatus" id="fbusinessstatus" style="width:160px;">
							<option value="">- - - -</option>
							{html_options options=$businessstatusList selected=$formData.fbusinessstatus}
						</select></td>
					</tr>
					<tr>
						<td>{$lang.controller.labelId}:</td>
						<td style="float:left;"><input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /></td>
					</tr>
					<tr>
						<td></td>
						<td style="float:left;"><input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  /></td>
					</tr>
				</table>

			</form>
		</div><!-- end #tab2 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$('#fpcid').select2();
		$('#fvid').select2();
		$('#fvsubid').select2();
	});

	function gosearch()
	{
		var path = rooturl + controllerGroup + "/product/index";


		var vid = $('#fvid').val();
		if(vid.length > 0)
		{
			path += '/vid/' + vid;
		}

		var vid = $('#fvsubid').val();
		if(vid.length > 0)
		{
			path += '/vsubid/' + vid;
		}

		var pcid = $('#fpcid').val();
		if(pcid.length > 0)
		{
			path += '/pcid/' + pcid;
		}

		var barcode = $('#fbarcode').val();
		if(barcode.length > 0)
		{
			path += '/barcode/' + barcode;
		}

		var barcodestatus = $('#fbarcodestatus').val();
		if(parseInt(barcodestatus) > 0)
		{
			path += '/barcodestatus/' + barcodestatus;
		}

		var name = $('#fname').val();
		if(name.length > 0)
		{
			path += '/name/' + name;
		}

		var unitprice = $('#funitprice').val();
		if(parseInt(unitprice) > 0)
		{
			path += '/unitprice/' + unitprice;
		}

		var instock = $('#finstock').val();
		if(parseInt(instock) > 0)
		{
			path += '/instock/' + instock;
		}

		var sellprice = $('#fsellprice').val();
		if(parseInt(sellprice) > 0)
		{
			path += '/sellprice/' + sellprice;
		}

		var syncstatus = $('#fsyncstatus').val();
		if(syncstatus.length > 0)
		{
			path += '/syncstatus/' + syncstatus;
		}

		var status = $('#fstatus').val();
		if(status.length > 0)
		{
			path += '/status/' + status;
		}

		var status = $('#fonsitestatus').val();
		if(status.length > 0)
		{
			path += '/onsitestatus/' + status;
		}

		var status = $('#fbusinessstatus').val();
		if(status.length > 0)
		{
			path += '/businessstatus/' + status;
		}

		var id = $('#fid').val();
		if(id.length > 0)
		{
			path += '/id/' + id;
		}


		document.location.href= path;
	}

	function cloneFunction(url)
	{
		bootbox.confirm('{/literal}{$lang.controller.cloneProductConfirm}{literal}',function(confirm){
			if(confirm){
				window.location.href = url;
			}
		});
	}

	function viewShadowbox(url , name, type)
	{
		if(url.length > 0)
		{
			Shadowbox.open({
                    content:    url,
                    //title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                    player:     "iframe" 
                });
		}
	}
</script>
{/literal}

