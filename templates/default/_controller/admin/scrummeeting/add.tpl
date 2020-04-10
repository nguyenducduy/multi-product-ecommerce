<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/siid/{$sprintid}">ScrumMeeting</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrummeeting"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrummeetingAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid} <span class="star_require">*</span></label>
		<div class="controls"><select name="fuid" id="fuid" class="autocompletestaff">

            </select></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fsiid">{$lang.controller.labelSiid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fsiid" id="fsiid">
				{foreach $scrumiteration as $value}
				    <option value='{$value->id}'>{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="ftype" id="ftype">
				{foreach $liststatus as $key => $value}
				    <option value='{$key}'>{$value}</option>
				{/foreach}
			</select>
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="input-xxlarge">{$formData.fsummary}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="input-xxlarge">{$formData.fnote}</textarea></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


