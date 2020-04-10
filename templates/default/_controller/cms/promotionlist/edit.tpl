<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Promotionlist</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_promotionlist"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.promotionlistEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpromogid">{$lang.controller.labelPromogid}</label>
		<div class="controls"><input type="text" name="fpromogid" id="fpromogid" value="{$formData.fpromogid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid}</label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpbarcode">{$lang.controller.labelPbarcode}</label>
		<div class="controls"><input type="text" name="fpbarcode" id="fpbarcode" value="{$formData.fpbarcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fiscombo">{$lang.controller.labelIscombo}</label>
		<div class="controls"><input type="text" name="fiscombo" id="fiscombo" value="{$formData.fiscombo|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fprice">{$lang.controller.labelPrice}</label>
		<div class="controls"><input type="text" name="fprice" id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimei">{$lang.controller.labelImei}</label>
		<div class="controls"><input type="text" name="fimei" id="fimei" value="{$formData.fimei|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimeipromotionid">{$lang.controller.labelImeipromotionid}</label>
		<div class="controls"><input type="text" name="fimeipromotionid" id="fimeipromotionid" value="{$formData.fimeipromotionid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fquantity">{$lang.controller.labelQuantity}</label>
		<div class="controls"><input type="text" name="fquantity" id="fquantity" value="{$formData.fquantity|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fispercentcalc">{$lang.controller.labelIspercentcalc}</label>
		<div class="controls"><input type="text" name="fispercentcalc" id="fispercentcalc" value="{$formData.fispercentcalc|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdateadd">{$lang.controller.labelDateadd}</label>
		<div class="controls"><input type="text" name="fdateadd" id="fdateadd" value="{$formData.fdateadd|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatemodify">{$lang.controller.labelDatemodify}</label>
		<div class="controls"><input type="text" name="fdatemodify" id="fdatemodify" value="{$formData.fdatemodify|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

