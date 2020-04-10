<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Homepage</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_homepage"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.homepageEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fcategory">{$lang.controller.labelCategory} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcategory" id="fcategory" value="{$formData.fcategory|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finputtype">{$lang.controller.labelInputtype} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finputtype" id="finputtype" value="{$formData.finputtype|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="flistid">{$lang.controller.labelListid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flistid" id="flistid" value="{$formData.flistid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

