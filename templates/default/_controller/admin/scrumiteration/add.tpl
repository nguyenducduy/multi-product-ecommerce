
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/scrumproject/detail/spid/{$projectId}">ScrumIteration</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrumiteration"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumiterationAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fspid">{$lang.controller.labelProject}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fspid" id="fspid">
				  <option value=''>----</option>
				{foreach $project as $value}
				    <option value='{$value->id}'>{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstid">{$lang.controller.labelTeam} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fstid" id="fstid">
				<option value=''>----</option>
				{foreach $team as $value}
				    <option value='{$value->id}' >{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	
	<div class="control-group">
		<label class="control-label" for="fdatestarted">{$lang.controller.labelDatestarted}<span class="star_require">*</span></label>
		<div class="controls"><input class='inputdatepicker' type="text" name="fdatestarted" id="fdatestarted" value="{$formData.fdatestarted|@htmlspecialchars}" ></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdateended">{$lang.controller.labelDateended}<span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" class='inputdatepicker' name="fdateended" id="fdateended" value="{$formData.fdateended|@htmlspecialchars}" ></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote}</label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="input-xxlarge">{$formData.fnote}</textarea></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


