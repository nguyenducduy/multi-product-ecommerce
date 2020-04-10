<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Homepage</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.labelUpdate}</li>
</ul>

<div class="page-header" rel="menu_homepage"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="ftype">
				{foreach item=type key=key from=$typeList}
				<option value="{$key}">{$type}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" name="fsubmitNext" value="{$lang.controller.formNextSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
</form>
