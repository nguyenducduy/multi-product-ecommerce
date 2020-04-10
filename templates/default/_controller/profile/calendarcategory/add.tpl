<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">CalendarCategory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_calendarcategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.calendarcategoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName}</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcolor">{$lang.controller.labelColor}</label>
		<div class="controls"><input type="text" name="fcolor" id="fcolor" value="{$formData.fcolor|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


