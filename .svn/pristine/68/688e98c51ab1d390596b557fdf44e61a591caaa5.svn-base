<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">StoreUser</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_storeuser"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.storeuserEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid}</label>
		<div class="controls"><span class="label label-info">{$userinfo->fullname}</span></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="frole">{$lang.controller.labelRole} <span class="star_require">*</span></label>
		<div class="controls">
			<select id="frole" name="frole" onchange="changerole()">
			{foreach item=rolevalue key=roleid from=$rolelist}
				<option {if $roleid==$formData.frole}selected="selected"{/if} value="{$roleid}">{$rolevalue}</option>
			{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group" id="smid">
		<label class="control-label" for="fsid">{$lang.controller.labelSid} <span class="star_require">*</span></label>
		<div class="controls">
			<select id="fsid" name="fsid" style="width: 400px;">
			{foreach item=store from=$storelist}
				<option {if $store->id == $formData.fsid}selected="selected"{/if} value="{$store->id}">{$store->name}</option>
			{/foreach}
			</select>
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>
{literal}
<script type="text/javascript">
$(document).ready(function(){

	var role = $('#frole').val();
	if(role == 5)
	{
		$('#smid').show();
	}
	else
	{
		$('#smid').hide();
	}
});
function changerole()
{
	var role = $('#frole').val();
	if(role == 5)
	{
		$('#smid').show();
	}
	else
	{
		$('#smid').hide();
	}
}
</script>
{/literal}
