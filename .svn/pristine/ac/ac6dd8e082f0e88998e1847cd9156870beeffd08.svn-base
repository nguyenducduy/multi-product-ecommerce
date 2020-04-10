<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Keyword Usage</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_relitemkeyword"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.relitemkeywordEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="ftype" id="ftype">
				{html_options options=$typeList selected=$formData.ftype}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fobjectid">{$lang.controller.labelObjectid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini"></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

