<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">GamefasteyeUser</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_gamefasteyeuser"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.gamefasteyeuserEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fgfeid">{$lang.controller.labelGfeid}</label>
		<div class="controls"><input type="text" name="fgfeid" id="fgfeid" value="{$formData.fgfeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fusername">{$lang.controller.labelUsername}</label>
		<div class="controls"><input type="text" name="fusername" id="fusername" value="{$formData.fusername|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffullname">{$lang.controller.labelFullname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone}</label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div><!--

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint}</label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fhistorypoint">{$lang.controller.labelHistorypoint}</label>
		<div class="controls"><textarea name="fhistorypoint" id="fhistorypoint" rows="7" class="input-xxlarge">{$formData.fhistorypoint}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountplay">{$lang.controller.labelCountplay}</label>
		<div class="controls"><input type="text" name="fcountplay" id="fcountplay" value="{$formData.fcountplay|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountshare">{$lang.controller.labelCountshare}</label>
		<div class="controls"><input type="text" name="fcountshare" id="fcountshare" value="{$formData.fcountshare|@htmlspecialchars}" class="input-mini"></div>
	</div>

	--><div class="control-group">
		<label class="control-label" for="foauthpartner">{$lang.controller.labelOauthpartner}</label>
		<div class="controls"><input type="text" name="foauthpartner" id="foauthpartner" value="{$formData.foauthpartner|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

