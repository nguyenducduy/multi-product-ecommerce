<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Homepage</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_homepage"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.homepageEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fcategory">{$lang.controller.labelCategory} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fcategory" id="fcategory">
				{foreach item=productcategory from=$productcategoryList}
				{if $formData.fcategory == $productcategory->id}
				<option value="{$productcategory->id}">{$productcategory->name}</option>
				{/if}
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finputtype">{$lang.controller.labelType}</label>
		<div class="controls"><input type="hidden" name="ftype" value="{$formData.ftype}" /><span class="label label-info">{$formData.typename}</span></div>
	</div>

	<div style="margin-left:31px;">{$lang.controller.barcode} : <input type="text" id="barcode" />&nbsp;{$lang.controller.productname} : <input type="text" id="pname" /> &nbsp;<input type="button" name="fsearchButton" id="fsearchButton" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="loadProductHomepage()" /></div>
	<br />
	<div id="resultHomepage">

	</div>
	<div id="homepageproduct">
		<h1>Sản phẩm được chọn</h1>
		<table class="table" id="choosehomepage">
			<thead>
				<tr>
					<th></th><th>Danh mục</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th></th>
				</tr>
			</thead>
			<tbody>
				{foreach item=product from=$formData.fobjectidlist}
				{if $product->id > 0}
				<tr id="row_{$product->id}">
					<td width="266px;">{if $product->image != ''}<img src="{$product->getSmallImage()}" alt="{$product->name}" width="100px" height="100px" />{/if}</td>
					<td><span class="label label-info">{$product->categoryactor->name}</span></td>
					<td width="520px;"><input type="hidden" name="flistid[]" id="{$product->id}" value="{$product->id}" />{$product->name}</td>
					<td>{$product->sellprice}</td>
					<td>{$product->instock}</td>
					<td><input type="button" class="btn btn-danger" id="fclear_{$product->id}" onclick="clearFunction({$product->id})" value="Remove" /></td>
				</tr>
				{/if}
				{/foreach}
			</tbody>
		</table>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>
{literal}
<script type="text/javascript">
function loadProductHomepage()
{
	if($('#fcategory').val() >  0)
	{
		if($('#barcode').val() != '' || $('#pname').val() != '')
		{
			var dataString = "catid=" + $('#fcategory').val() + "&barcode="+ $('#barcode').val() + "&name=" +$('#pname').val();
			$.ajax({
				type : "post",
				dataType : "html",
				url : "/cms/homepage/loadproductajax",
				data : dataString,
				success : function(html){
					if(html != ''){
						$('#resultHomepage').html(html);
						if($('#homepageproduct').attr('display') != 'none'){
							$('#homepageproduct').fadeIn();
						}
					}else{
						$('#resultHomepage').html('{/literal}{$lang.controller.errNotFound}{literal}');
					}
				}
			});
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errCondNotEmpty}{literal}');
		}
	}
	else
	{
		bootbox.alert('{/literal}{$lang.controller.errCategoryRequired}{literal}');
	}
}
function chooseFunction(id)
{
	if(id > 0)
	{
		//kiem tra xem san pham nay da duoc chon hay chua ?
		if($('#'+id).length == 0)
		{
			var imgSource = $('#images_'+id).attr('src');			
			var productName = $('#names_'+id).html();
			var productPrice = $('#prices_'+id).html();
			var instock = $('#instocks_'+id).html();
			var productCategory = $('#categorys_'+id).html();
			var data = '<tr id="row_'+id+'">';
			data += '<td style="width:228px;">';
			if(imgSource != undefined)
			{
				data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="100px" height="100px" /></a>';
			}
			data += '</td>';
			data += '<td><span class="label label-info">'+productCategory+'</span></td>';
			data += '<td style="width:527px;"><input type="hidden" name="flistid[]" value="'+id+'" id="'+id+'" />'+productName+'</td>';
			data += '<td>'+productPrice+'</td>';
			data += '<td>'+instock+'</td>';
			data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+')" value="Remove" /></td>';
			data += '</tr>';
			$('#choosehomepage').find('tbody').append(data);
			$('#rows'+id).fadeOut();
		}
		else
		{
			bootbox.alert('{/literal}{$lang.controller.errProductChoose}{literal}');
		}
	}
}
function clearFunction(id)
{
	$('#row_'+id).remove();
	$('#rows'+id).fadeIn();
}
</script>
{/literal}
