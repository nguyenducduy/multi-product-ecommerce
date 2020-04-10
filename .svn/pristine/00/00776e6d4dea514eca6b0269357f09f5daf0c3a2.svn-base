<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Thuộc tính sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productattribute"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productattributeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}


	<div class="control-group">
		<label class="control-label" for="fpcid">{$lang.controller.labelPcid} <span class="star_require">*</span></label>
		<div class="controls">
			<input type="hidden" name="fpcid" value="{$formData.fpcid}" /><b>{$productcategory->name}</b>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpgaid">{$lang.controller.labelPgaid} <span class="star_require">*</span></label>
		<div class="controls">
			<input type="hidden" name="fpgaid" value="{$formData.fpgaid}" /><b>{$groupattribute->name}</b>
		</div>
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

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
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

