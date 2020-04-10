<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ForecastUservalueHistory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_forecastuservaluehistory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.forecastuservaluehistoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffuid">{$lang.controller.labelFuid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ffuid" id="ffuid" value="{$formData.ffuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foldvalue">{$lang.controller.labelOldvalue}</label>
		<div class="controls"><textarea name="foldvalue" id="foldvalue" rows="7" class="input-xxlarge">{$formData.foldvalue}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fnewvalue">{$lang.controller.labelNewvalue}</label>
		<div class="controls"><textarea name="fnewvalue" id="fnewvalue" rows="7" class="input-xxlarge">{$formData.fnewvalue}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fedituserid">{$lang.controller.labelEdituserid}</label>
		<div class="controls"><input type="text" name="fedituserid" id="fedituserid" value="{$formData.fedituserid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsessionid">{$lang.controller.labelSessionid}</label>
		<div class="controls"><input type="text" name="fsessionid" id="fsessionid" value="{$formData.fsessionid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fipaddress">{$lang.controller.labelIpaddress}</label>
		<div class="controls"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


