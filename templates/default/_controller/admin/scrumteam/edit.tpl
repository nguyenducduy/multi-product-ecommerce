<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/spid/{$projectId}">ScrumTeam</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_scrumteam"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumteamEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	


	<div class="control-group">
		<label class="control-label" for="fspid">{$lang.controller.labelSpid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fspid" id="fspid">
				<option value=''>----</option>
				{foreach $project as $value}
				    <option value='{$value->id}'{if {$value->id}=={$formData.fspid}}selected{/if}>{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

