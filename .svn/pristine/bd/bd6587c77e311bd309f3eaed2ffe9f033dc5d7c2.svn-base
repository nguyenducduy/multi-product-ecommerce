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
			<select name="fpcid" id="fpcid" onchange="changeFunction('{$formData.fpgaid}')">
				<option value="0">-------</option>
				{foreach from=$productcategoryList item=category}
				{if $category->parentid == 0}
				</optgroup><optgroup label="{$category->name}"></optgroup>
				{else}
				<option value="{$category->id}" {if $category->id == $formData.fpcid}selected="selected"{/if}>{$category->name}</option>
				{/if}
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group" id="groupattribute" style="display:none;">
		<label class="control-label" for="fpgaid">{$lang.controller.labelPgaid} <span class="star_require">*</span></label>
		<div class="controls">
			<select id="fpgaid" name="fpgaid">
				<option value="0">------</option>
			</select>
		</div>
	</div>

	<div style="float:right;">
		<input type="submit" name="fnext" value="{$lang.controller.nextSubmit}" class="btn btn-large btn-primary" />
	</div>

</form>
{literal}
<script type="text/javascript" language="JavaScript">
function changeFunction(fpgaid)
{
	if($('#fpcid').val() > 0)
	{
		var category = $('#fpcid').val();
		var url = rooturl + controllerGroup + "/" + {/literal}"{$controller}"{literal}+ "index/action/ajax";
		dataString = "fpcid=" + category + "&fpgaid=" + fpgaid;
		$.ajax({
			type : "post",
			url: "/cms/productgroupattribute/indexAjax",
			data : dataString,
			success : function(data){
				if(data != ''){
					$('#fpgaid').find('option')
					.remove()
					.end().append(data);

					$('#groupattribute').fadeIn(10);
				}else{
					$('#groupattribute').fadeOut(10);
					$('#fpgaid').find('option')
					.remove()
					.end().append('<option value="0">----</option>');
				}
			}
		});
	}
	else
	{
		$('#groupattribute').fadeOut(10);
	}
}
</script>
{/literal}

