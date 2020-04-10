<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ReportColumn</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_reportcolumn"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.reportcolumnEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}


	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fidentifier">{$lang.controller.labelIdentifier} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvaluetype">{$lang.controller.labelValuetype}</label>
		<div class="controls">
			<select name="fvaluetype" id="fvaluetype">
				{html_options options=$valuetypeList selected=$formData.fvaluetype}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatatype">{$lang.controller.labelDatatype}</label>
		<div class="controls">
			<select name="fdatatype" id="fdatatype">
				{html_options options=$datatypeList selected=$formData.fdatatype}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fformular">{$lang.controller.labelFormular}</label>
		<div class="controls"><input type="text" name="fformular" id="fformular" class="input-xlarge" value="{$formData.fformular|@htmlspecialchars}"/></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fobjecttype">{$lang.controller.labelObjecttype}</label>
		<div class="controls">
			<select name="fobjecttype" id="fobjecttype">
				{html_options options=$objecttypeList selected=$formData.fobjecttype}
			</select>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>

