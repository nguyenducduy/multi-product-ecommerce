<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Eventtheme</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_eventtheme"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.eventthemeEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName}</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fheader">{$lang.controller.labelHeader}</label>
		<div class="controls"><textarea name="fheader" id="fheader" rows="7" class="input-xxlarge">{$formData.fheader}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ffooter">{$lang.controller.labelFooter}</label>
		<div class="controls"><textarea name="ffooter" id="ffooter" rows="7" class="input-xxlarge">{$formData.ffooter}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fclassidentifier">{$lang.controller.labelClassidentifier}</label>
		<div class="controls"><input type="text" name="fclassidentifier" id="fclassidentifier" value="{$formData.fclassidentifier|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

