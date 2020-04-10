<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">PriceEnemy</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_priceenemy"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.priceenemyEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="feid">{$lang.controller.labelEid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="feid" id="feid" value="{$formData.feid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="furl">{$lang.controller.labelUrl} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="furl" id="furl" rows="7" class="input-xxlarge">{$formData.furl}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fprice">{$lang.controller.labelPrice}</label>
		<div class="controls"><input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpriceauto">{$lang.controller.labelPriceauto}</label>
		<div class="controls"><input type="text" name="fpriceauto" id="fpriceauto" value="{$formData.fpriceauto|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote}</label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="input-xxlarge">{$formData.fnote}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdateupdated">{$lang.controller.labelDateupdated}</label>
		<div class="controls"><input type="text" name="fdateupdated" id="fdateupdated" value="{$formData.fdateupdated|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatesynced">{$lang.controller.labelDatesynced}</label>
		<div class="controls"><input type="text" name="fdatesynced" id="fdatesynced" value="{$formData.fdatesynced|@htmlspecialchars}" class="input-mini"></div>
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

