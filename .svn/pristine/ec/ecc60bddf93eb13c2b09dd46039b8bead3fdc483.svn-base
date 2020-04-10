<div class="page-header" rel="menu_file"><h1>{$lang.controller.head_add}</h1></div>


<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.groupAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbio">{$lang.controller.labelDescription}</label>
		<div class="controls">
			<textarea name="fbio" id="fbio" class="input-xxlarge" rows="8">{$formData.fbio}</textarea>
	</div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formCreateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{if $success|@count > 0}
<script type="text/javascript">
	$(document).ready(function(){
		self.parent.location.href = "{$successGroupUrl}";
	});
</script>
{/if}


