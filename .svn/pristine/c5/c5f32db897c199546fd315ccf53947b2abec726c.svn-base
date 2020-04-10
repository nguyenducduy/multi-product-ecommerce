<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Thuộc tính sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_productattribute"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productattributeEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}


	<div class="control-group">
		<label class="control-label" for="fpcid">{$lang.controller.labelPcid} <span class="star_require">*</span></label>
		<div class="controls"><select name="fpcid" id="fpcid" onchange="changeFunction('{$formData.fpgaid}')">
				<option value="0">-------</option>
				{foreach from=$productcategoryList item=category}
				{if $category->parentid == 0}
				</optgroup><optgroup label="{$category->name}"></optgroup>
				{else}
				<option value="{$category->id}" {if $category->id == $formData.fpcid}selected="selected"{/if}>{$category->name}</option>
				{/if}
				{/foreach}
			</select></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpgaid">{$lang.controller.labelPgaid} <span class="star_require">*</span></label>
		<div class="controls"><select id="fpgaid" name="fpgaid">
				<option value="0">------</option>
				{if $productAttributeGroupList|@count > 0}
					{foreach item=productGroupAttribute from=$productAttributeGroupList}
						<option value="{$productGroupAttribute->id}" {if $formData.fpgaid == $productGroupAttribute->id}selected="selected"{/if}>{$productGroupAttribute->name}</option>
					{/foreach}
				{/if}
			</select></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flink">{$lang.controller.labelLink}</label>
		<div class="controls"><input type="text" name="flink" id="flink" value="{$formData.flink|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
			{html_options options=$statusList selected=$formData.fstatus}
		</select></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>
{literal}
<script type="text/javascript" language="JavaScript">
function changeFunction(fpgaid)
{
	var category = $('#fpcid').val();
	var url = rooturl + controllerGroup + "/" + {/literal}"{$controller}"{literal}+ "index/action/ajax";
	dataString = "fpcid=" + category + "&fpgaid=" + fpgaid;
	$.ajax({
		type : "post",
		url: "/cms/productgroupattribute/indexAjax",
		data : dataString,
		success : function(data){
			$('#fpgaid').find('option')
		    .remove()
		    .end().append(data);
		}
	});
}
</script>
{/literal}
