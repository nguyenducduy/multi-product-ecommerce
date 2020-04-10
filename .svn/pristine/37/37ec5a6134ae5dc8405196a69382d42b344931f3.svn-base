<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Search</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_search"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.searchAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="ftext">{$lang.controller.labelText} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftext" id="ftext" value="{$formData.ftext|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcategoryid">{$lang.controller.labelCategoryid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcategoryid" id="fcategoryid" value="{$formData.fcategoryid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="freferrer">{$lang.controller.labelReferrer} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freferrer" id="freferrer" value="{$formData.freferrer|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fnumresult">{$lang.controller.labelNumresult} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fnumresult" id="fnumresult" value="{$formData.fnumresult|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


