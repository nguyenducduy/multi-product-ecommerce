<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">GamefasteyeHistory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_gamefasteyehistory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.gamefasteyehistoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fguid">{$lang.controller.labelGuid}</label>
		<div class="controls"><input type="text" name="fguid" id="fguid" value="{$formData.fguid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fplayed">{$lang.controller.labelPlayed}</label>
		<div class="controls"><input type="text" name="fplayed" id="fplayed" value="{$formData.fplayed|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftimeplayed">{$lang.controller.labelTimeplayed}</label>
		<div class="controls"><input type="text" name="ftimeplayed" id="ftimeplayed" value="{$formData.ftimeplayed|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint}</label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


