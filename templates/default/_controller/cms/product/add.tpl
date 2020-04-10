<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_product"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formBackLabel}</a></div>
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<form action="" method="post" name="myform" class="form-horizontal">
	<h1>Vui lòng chọn danh mục sản phẩm</h1>
	<div class="control-group">
		<label class="control-label" for="fpcid">{$lang.controller.labelPcid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid" id="fpcid"  style="width:200px;">
			{foreach from=$productcategoryList item=productCategory}
			{if $productCategory->parentid==0}
				</optgroup><optgroup label="{$productCategory->name}">
			{else}
				<option value="{$productCategory->id}">{$productCategory->name}</option>
			{/if}
			{/foreach}
			</select>
		</div>
	</div>
	<!-- <div class="control-group" id="child" style="display:none">
		<label class="control-label" for="fpcid1">{$lang.controller.labelPcid1} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcid1" id="fpcid1" style="width:200px;">
			</select>
		</div>
	</div> -->
	<input type="submit" name="fsubmitNext" value="{$lang.controller.labelNext}" class="btn btn-large btn-primary" style="float:right;" />
</form>
{literal}
<script type="text/javascript">
function changeFunction()
{
	pcat = $('#fpcid').val();
	dataString = 'fpcid=' + pcat;
	url = '/cms/product/indexAjax';
	$.ajax({
		type : "POST",
		data : dataString,
		url : url,
		success: function(data){
			if(data != ''){
				$('#child').fadeIn();
				$('#fpcid1').find('option')
			    .remove()
			    .end().append(data);
			}
			else{
				$('#child').fadeOut();
				$('#fpcid1').find('option')
			    .remove()
			    .end()
			}
		}
	});
}
$(document).ready(function(){
	$("#fpcid").select2();
	$("#fpcid1").select2();

	pcat = $('#fpcid').val();
	dataString = 'fpcid=' + pcat;
	url = '/cms/product/indexAjax';
	$.ajax({
		type : "POST",
		data : dataString,
		url : url,
		success: function(data){
			if(data != ''){
				$('#child').fadeIn();
				$('#fpcid1').find('option')
			    .remove()
			    .end().append(data);
			}
			else{
				$('#child').fadeOut();
				$('#fpcid1').find('option')
			    .remove()
			    .end()
			}
		}
	});
});
</script>
{/literal}

