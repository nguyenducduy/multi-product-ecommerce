<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ProductyearArticle</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productyeararticle"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productyeararticleAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid}</label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpyuid">{$lang.controller.labelPyuid}</label>
		<div class="controls"><input type="text" name="fpyuid" id="fpyuid" value="{$formData.fpyuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fcontent" id="fcontent" rows="7" class="input-xxlarge">{$formData.fcontent}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint}</label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini"></div>
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


