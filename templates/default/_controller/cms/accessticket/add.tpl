<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">AccessTicket</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_accessticket"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.accessticketAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid}</label>
		<div class="controls"><select name="fuid" id="fuid" class="autocompletestaff"></select></div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="ftickettype">{$lang.controller.labelTickettype} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="ftickettype" id="ftickettype" style="width:200px;">
				{foreach item=accesstickettype from=$accesstickettypelist}
				<option {if $accesstickettype->id == $formData.ftickettype}selected="selected"{/if} value="{$accesstickettype->id}">{$accesstickettype->name}</option>
				{/foreach}
			</select>
		</div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="fsuffix">{$lang.controller.labelSuffix} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsuffix" id="fsuffix" value="{$formData.fsuffix|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

    <div class="control-group">
        <label class="control-label" for="fsuffix">Using action wildcard</label>
        <div class="controls"><input type="checkbox" id="fwildcard" name="fwildcard" value="1" {if isset($formData.fwildcard)}checked="checked" {/if}></div>
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
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$("#ftickettype").select2();
		$("#fobjectid").select2();
	});
</script>
{/literal}