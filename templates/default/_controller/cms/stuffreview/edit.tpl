<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">StuffReview</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_stuffreview"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.stuffreviewEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fobjectid">{$lang.controller.labelObjectid}</label>
		<div class="controls"><input type="hidden" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}"><b>{$formData.ftitle}</b></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffullname">{$lang.controller.labelUid}</label>
		<div class="controls"><input type="hidden" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}"><b>{$formData.ffullname}</b></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail}</label>
		<div class="controls"><input type="hidden" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}"><span class="label label-info">{$formData.femail}</span></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftext">{$lang.controller.labelText}</label>
		<div class="controls"><textarea name="ftext" id="ftext" rows="7" class="input-xxlarge">{$formData.ftext}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
					{html_options options=$statusList selected=$formData.fstatus}
				</select></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

