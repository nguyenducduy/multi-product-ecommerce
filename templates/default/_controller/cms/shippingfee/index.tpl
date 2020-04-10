<ul class="breadcrumb">
	<li><a href="{$conf.rooturl}{$controllerGroup}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Shipping Fee</a> <span class="divider">/</span></li>
</ul>



<div class="page-header" rel="menu_region"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
	<ul class="nav nav-tabs">
		<li{if $action=='index'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Shipping Prices</a></li>
		<li{if $action=='shippingprovince'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/shippingprovince">Shipping Fee Province</a></li>
		<li{if $action=='settinglabel'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/settinglabel">Setting Label</a></li>
		<li{if $action=='settingfee'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/settingfee">Setting Name of Fee</a></li>
		<li{if $action=='vxvsttc'} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/vxvsttc">Fee VXVS TTC</a></li>
		<li class="pull-right"><a class="pull-right btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/upload">Upload</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">

			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			{if $listofshippingfee|@count > 0}
			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							<th>Distance Min</th>
							<th>Distance Max</th>
							<th>Weight Min</th>
							<th>Weight Max</th>
							<th>Time Min</th>
							<th>Time Max</th>
							<th>Price </th>
							<th>Price Plus </th>
							<th>Area</th>
							<th>Type (TTC/SBP)</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="12">
								<div class="pagination">
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
					{foreach item=fee from=$listofshippingfee}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$fee->id}" {if in_array($fee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$fee->id}</td>
							<td>{$fee->distancemin}</td>
							<td>{$fee->distancemax}</td>
							<td>{$fee->weightmin}</td>
							<td>{$fee->weightmax}</td>
							<td>{$fee->timemin}</td>
							<td>{$fee->timemax}</td>
							<td>{if $fee->price > 0}{$fee->price|number_format}{else}0{/if}</td>
							<td>{if $fee->priceplus > 0}{$fee->priceplus|number_format}{else}0{/if}</td>
							<td>{$fee->area}</td>
							<td>{$fee->getTypePrice()}</td>
						</tr>


					{/foreach}
					</tbody>
				</table>
			</form>
			{elseif $listshippingprovince|@count > 0}
			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							<th>Tỉnh đi</th>
							<th>Huyện đi</th>
							<th>Tỉnh đến</th>
							<th>Huyện đến</th>
							<th>TTC</th>
							<th>SBP</th>
							<th>&nbsp;</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="9">
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
					{foreach item=fee from=$listshippingprovince}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$fee->id}" {if in_array($fee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$fee->id}</td>
							<td>{$allregionsarray[$fee->provincestart]}</td>
							<td>{if !empty($allregionsarray[$fee->districtstart])}{$allregionsarray[$fee->districtstart]}{else}-{/if}</td>
							<td>{$allregionsarray[$fee->provinceend]}</td>
							<td>{$allregionsarray[$fee->districtend]}</td>
							<td>{$fee->ttc}</td>
							<td>{$fee->sbp}</td>
							<td>&nbsp;</td>
						</tr>


					{/foreach}
					</tbody>
				</table>
			</form>
			{elseif $listofshippingfeename|@count > 0}
			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							<th>Tên Phí</th>
							<th>Price Min</th>
							<th>Price Max</th>
							<th>Weight Min</th>
							<th>Weight Max</th>
							<th>Discount</th>
							<th>Is Percent</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="7">
								<div class="pagination">
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
					{foreach item=fee from=$listofshippingfeename}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$fee->id}" {if in_array($fee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$fee->id}</td>
							<td>{$fee->name}</td>
							<td>{$fee->pricemin}</td>
							<td>{$fee->pricemax}</td>
							<td>{$fee->weightmin}</td>
							<td>{$fee->weightmax}</td>
							<td>{$fee->discount}</td>
							<td>{if $fee->ispercent == 1}YES{else}NO{/if}</td>
						</tr>

					{/foreach}
					</tbody>
				</table>
			</form>
			{elseif $listofshippingsettingsfee|@count > 0}
			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							<th>Tên Phí</th>
							<th>Giá</th>
							<th>Loại (TTC/SBP)</th>
							<th>Tỉ lệ phần trăm</th>
							<th>Thứ Tự</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="pagination">
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
					{foreach item=fee from=$listofshippingsettingsfee}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$fee->id}" {if in_array($fee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$fee->id}</td>
							<td>{$fee->name}</td>
							<td>{if $fee->price > 0}{$fee->price|number_format}{else}0{/if}</td>
							<td>{$fee->getTypeFee()}</td>
							<td>{if $fee->ispercent == 1}YES{else}NO{/if}</td>
							<td>{$fee->order}</td>
						</tr>

					{/foreach}
					</tbody>
				</table>
			</form>
			{elseif $listfeevxvsttc|@count > 0}
			<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
				<input type="hidden" name="ftoken" value="{$smarty.session.regionBulkToken}" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th width="30"><input class="check-all" type="checkbox" /></th>
							<th width="30">ID</th>
							<th>Tỉnh đến</th>
							<th>Huyện đến</th>
							<th>TTC VW &lt;30kg </th>
							<th>TTC VW &gt;= 30kg</th>
							<th>&nbsp;</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="9">
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
					{foreach item=fee from=$listfeevxvsttc}

						<tr>
							<td><input type="checkbox" name="fbulkid[]" value="{$fee->id}" {if in_array($fee->id, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td style="font-weight:bold;">{$fee->id}</td>
							<td>{$allregionsarray[$fee->rid]}</td>
							<td>{$allregionsarray[$fee->districtid]}</td>
							<td>{if $fee->less30kg > 0}{$fee->less30kg|number_format}{else}0{/if}</td>
							<td>{if $fee->from30kg > 0}{$fee->from30kg|number_format}{else}0{/if}</td>
							<td>&nbsp;</td>
						</tr>


					{/foreach}
					</tbody>
				</table>
			</form>
			{else}
			<table>
					<tr>
						<td colspan="10"> {$lang.default.notfound}</td>
					</tr>
			</table>
			{/if}
		</div><!-- end #tab 1 -->
	</div>
</div>



{literal}
<script type="text/javascript">
	function gosearch()
	{
		var path = rooturl + controllerGroup + "/region/index";


		var parentid = $('#fparentid').val();
		if(parentid.length > 0)
		{
			path += '/parentid/' + parentid;
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




