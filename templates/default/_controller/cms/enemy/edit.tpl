<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Enemy</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_enemy"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.enemyEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fwebsite">{$lang.controller.labelWebsite}</label>
		<div class="controls"><input type="text" name="fwebsite" id="fwebsite" value="{$formData.fwebsite|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="frid">{$lang.controller.labelWebsite}</label>
		<div class="controls">
			<select name="frid" id="frid" style="width:200px;">
				{foreach item=region key=regionid from=$setting.region}
		        	<option {if $regionid == $formData.frid}selected="selected" {/if} value="{$regionid}">{$region}{if $regionid == $registry->region}{/if}</option>
		        {/foreach}
			</select>
		</div>
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

<script type="text/javascript">
	$(document).ready(function(){
		$('#frid').select2();
	})
</script>
