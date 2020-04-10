<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteCode</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_lottecode"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.lottecodeEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="flmid">{$lang.controller.labelLmid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flmid" id="flmid" value="{$formData.flmid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcode">{$lang.controller.labelCode} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcode" id="fcode" value="{$formData.fcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ferpsaleorderid">{$lang.controller.labelErpsaleorderid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ferpsaleorderid" id="ferpsaleorderid" value="{$formData.ferpsaleorderid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="freferer">{$lang.controller.labelReferer} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freferer" id="freferer" value="{$formData.freferer|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

