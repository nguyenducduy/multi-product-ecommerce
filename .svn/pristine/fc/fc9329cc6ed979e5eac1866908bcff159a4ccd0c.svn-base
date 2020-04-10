<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ProductAward</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productaward"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productawardAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpbarcode">{$lang.controller.labelPbarcode}</label>
		<div class="controls"><input type="text" name="fpbarcode" id="fpbarcode" value="{$formData.fpbarcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpoid">{$lang.controller.labelPoid}</label>
		<div class="controls"><input type="text" name="fpoid" id="fpoid" value="{$formData.fpoid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fppaid">{$lang.controller.labelPpaid}</label>
		<div class="controls"><input type="text" name="fppaid" id="fppaid" value="{$formData.fppaid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotalawardforstaff">{$lang.controller.labelTotalawardforstaff}</label>
		<div class="controls"><input type="text" name="ftotalawardforstaff" id="ftotalawardforstaff" value="{$formData.ftotalawardforstaff|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fupdatedatedoferp">{$lang.controller.labelUpdatedatedoferp}</label>
		<div class="controls"><input type="text" name="fupdatedatedoferp" id="fupdatedatedoferp" value="{$formData.fupdatedatedoferp|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


