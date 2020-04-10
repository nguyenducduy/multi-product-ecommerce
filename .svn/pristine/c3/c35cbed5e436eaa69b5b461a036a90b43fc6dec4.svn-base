<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Slug</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_slug"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.slugEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
		<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xlarge"></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fcontroller">{$lang.controller.labelController}</label>
		<div class="controls"><input type="text" name="fcontroller" id="fcontroller" value="{$formData.fcontroller|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fobjectid">{$lang.controller.labelObjectid}</label>
		<div class="controls"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="fstatus" id="fstatus">
                {html_options options=$statusList selected=$formData.fstatus}
            </select>
        </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fredirecturl">Redirect URL (For REDIRECT status Only)</label>
		<div class="controls"><input type="text" name="fredirecturl" id="fredirecturl" value="{$formData.fredirecturl|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

