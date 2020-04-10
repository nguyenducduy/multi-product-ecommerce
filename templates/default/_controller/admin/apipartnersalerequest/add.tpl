<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartnerSaleRequest</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_apipartnersalerequest"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.apipartnersalerequestAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fapid">{$lang.controller.labelApid}</label>
		<div class="controls"><input type="text" name="fapid" id="fapid" value="{$formData.fapid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fparameter">{$lang.controller.labelParameter}</label>
		<div class="controls"><input type="text" name="fparameter" id="fparameter" value="{$formData.fparameter|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fexecutetime">{$lang.controller.labelExecutetime}</label>
		<div class="controls"><input type="text" name="fexecutetime" id="fexecutetime" value="{$formData.fexecutetime|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="frecord">{$lang.controller.labelRecord}</label>
		<div class="controls"><input type="text" name="frecord" id="frecord" value="{$formData.frecord|@htmlspecialchars}" class="input-mini"></div>
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


