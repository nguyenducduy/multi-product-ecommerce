<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ForecastUservalue</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_forecastuservalue"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.forecastuservalueAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fidentifier">{$lang.controller.labelIdentifier} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsheet">{$lang.controller.labelSheet} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsheet" id="fsheet" value="{$formData.fsheet|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvalue">{$lang.controller.labelValue}</label>
		<div class="controls"><textarea name="fvalue" id="fvalue" rows="7" class="input-xxlarge">{$formData.fvalue}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdate">{$lang.controller.labelDate}</label>
		<div class="controls"><input type="text" name="fdate" id="fdate" value="{$formData.fdate|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flevel">{$lang.controller.labelLevel}</label>
		<div class="controls"><input type="text" name="flevel" id="flevel" value="{$formData.flevel|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisofficial">{$lang.controller.labelIsofficial}</label>
		<div class="controls"><input type="text" name="fisofficial" id="fisofficial" value="{$formData.fisofficial|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcanedit">{$lang.controller.labelCanedit}</label>
		<div class="controls"><input type="text" name="fcanedit" id="fcanedit" value="{$formData.fcanedit|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcandelete">{$lang.controller.labelCandelete}</label>
		<div class="controls"><input type="text" name="fcandelete" id="fcandelete" value="{$formData.fcandelete|@htmlspecialchars}" class="input-mini"></div>
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


