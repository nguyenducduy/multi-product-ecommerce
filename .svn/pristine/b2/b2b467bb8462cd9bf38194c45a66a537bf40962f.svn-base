<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ProductyearUser</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productyearuser"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productyearuserAddToken}" />


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
		<label class="control-label" for="ffullname">{$lang.controller.labelFullname}</label>
		<div class="controls"><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail}</label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone}</label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint}</label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fshareid">{$lang.controller.labelShareid}</label>
		<div class="controls"><textarea name="fshareid" id="fshareid" rows="7" class="input-xxlarge">{$formData.fshareid}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountlike">{$lang.controller.labelCountlike}</label>
		<div class="controls"><input type="text" name="fcountlike" id="fcountlike" value="{$formData.fcountlike|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountshare">{$lang.controller.labelCountshare}</label>
		<div class="controls"><input type="text" name="fcountshare" id="fcountshare" value="{$formData.fcountshare|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foauthpartner">{$lang.controller.labelOauthpartner}</label>
		<div class="controls"><input type="text" name="foauthpartner" id="foauthpartner" value="{$formData.foauthpartner|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fipaddress">{$lang.controller.labelIpaddress}</label>
		<div class="controls"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


