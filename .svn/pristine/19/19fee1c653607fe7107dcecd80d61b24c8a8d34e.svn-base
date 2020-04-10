<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Settingentry</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_settingentry"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.settingentryEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fsgid">{$lang.controller.labelSgid}</label>
		<div class="controls">
			<select name="fsgid" id="fsgid">
				<option value="0">- - - - - -</option>
				{foreach item=settinggroup from=$settinggroupList}
					<option value="{$settinggroup->id}" {if $settinggroup->id == $formData.fsgid}selected="selected"{/if}>{$settinggroup->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><input type="text" name="fdescription" id="fdescription" value="{$formData.fdescription|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fidentifier">{$lang.controller.labelIdentifier} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fidentifier" id="fidentifier" value="{$formData.fidentifier|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvalue">{$lang.controller.labelValue}</label>
		<div class="controls"><textarea name="fvalue" id="fvalue" rows="7" class="input-xxlarge">{$formData.fvalue}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

