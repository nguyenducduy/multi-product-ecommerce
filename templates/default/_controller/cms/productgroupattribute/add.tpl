<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Nhóm thuộc tính</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productgroupattribute"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productgroupattributeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fpcidparent">{$lang.controller.labelPcid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcidparent" id="fpcidparent" onchange="changeFunction()">
				<option value="0">----</option>
				{foreach from=$productcategoryList item=category}
				{if $category->parentid == 0}
				</optgroup><optgroup label="{$category->name}">
				{else}
				<option value="{$category->id}" {if $category->id == $formData.fpcid}selected="selected"{/if}>{$category->name}</option>
				{/if}
				{/foreach}
			</select>
		</div>
	</div>
	<div class="control-group" id="child" style="display:none;">
		<label class="control-label" for="fpcidsub">{$lang.controller.labelPcid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fpcidsub" id="fpcidsub">
			</select>
		</div>
	</div>

	<div style="float:right;">
		<input type="submit" name="fsubmitnext" value="{$lang.controller.nextSubmit}" class="btn btn-large btn-primary" />
	</div>

</form>
{literal}
<script type="text/javascript" language="JavaScript">
	function changeFunction()
	{
		$('#fpcidsub').find('option').remove().end();
		var url = '/cms/productcategory/indexAjax';
		var pcidparent = $('#fpcidparent').val();
		if(pcidparent > 0)
		{
			var dataString = "fpcidparent=" + $('#fpcidparent').val();
			$.ajax({
				type : "post",
				url : url,
				data :  dataString,
				success :  function(data){
					if(data != ''){
						$('#fpcidsub').append('<option value="0">----</option>'+data);
						$('#child').fadeIn(10);
					}
					else{
						$('#fpcidsub').append('<option value="0">No have sub category</option>'+data);
						$('#child').fadeIn(10);
					}
				}
			});
		}
		else{
			$('#child').fadeOut();
		}
	}
</script>
{/literal}

