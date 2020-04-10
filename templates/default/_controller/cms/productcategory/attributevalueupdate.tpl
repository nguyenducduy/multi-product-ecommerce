<div class="page-header" rel="menu_productcategory"><h1>Used Value for Attribute</h1></div>

<div class="tabbable">
<form method="POST" action="">
	<div class="tab-content">
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		<table class="table">
			<thead>
				<tr>
					<th>Thuộc tính</th>
					<th>Giá trị</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="width: 30%">
						<br/>
						<select id="attrid" style="width: 200px;">
							<option>Vui lòng chọn thuộc tính</option>
							{foreach item=attribute from=$attributeList}
							<option value="{$attribute->id}" {if $attribute->id == $formData.fid}selected="selected"{/if}>{$attribute->name}</option>
							{/foreach}
						</select>
					</td>
					<td style="width:70%">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Tên thuộc tính</th>
									<th>Giá trị</th>
									<th>Giá trị mới</th>
									<th style="text-align:right;">Sản phẩm áp dụng</th>

								</tr>
							</thead>

							<tbody>
								{assign var=groupfirstshow value=0}
								{assign var=attributefirstshow value=0}
								{foreach item=groupattribute from=$productgroupattributes}
									{foreach item=attribute from=$groupattribute}
										{foreach item=itemvalue from=$attribute->valueList}
											{counter assign="attributecounter"}
											<tr>
												<td class="tipsy-trigger" title="Attribute ID #{$attribute->id}">{$attribute->name}</span>{assign var=attributefirstshow value=1}</td>
												<td>{$itemvalue.value}</td>
												<td><div class="input-append">
														<input type="hidden" name="fattributeoldvalue[{$attribute->id}][{$attributecounter}]" value="{$itemvalue.value}" />
														<input class="input-normal" type="text" name="fattributenewvalue[{$attribute->id}][{$attributecounter}]" value="" style="margin-bottom:0;" />
														{if $attribute->unit != ''}<span class="add-on">{$attribute->unit}</span>{/if}
													</div>
													</td>
												<td><a href="{$myProductcategory->getProductcateoryPath()}?a={$attribute->id},{$itemvalue.valueseo}&auto=1" target="_blank" title="Xem sản phẩm" class="tipsy-trigger"><span class="badge">{$itemvalue.countitem}</span></a></td>

											</tr>
										{/foreach}
										{assign var=attributefirstshow value=0}
									{/foreach}

									{assign var=groupfirstshow value=0}
								{/foreach}
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			<tfoot>
			<tr>
				<td></td>
				<td><input type="submit" name="fsubmit" class="btn btn-primary" value="Lưu cập nhật" />
					<br /><small>- Các thuộc tính có ô giá trị bỏ trống thì sẽ không thay đổi.</small>
				</td>
			<tr>
		</tfoot>
		</table>
	</div>

</form>
</div>
{literal}
<script type="text/javascript">
	var pcid = {/literal}{$myProductcategory->id};{literal}

	$(document).ready(function(){
		$('#attrid').select2();
		$('#attrid').change(function(){
			var paid = $('#attrid').val();
			window.location.href = rooturl_cms + 'productcategory/attributevalueupdate/id/'+pcid+'?paid=' + paid;
		});
	});
</script>
{/literal}