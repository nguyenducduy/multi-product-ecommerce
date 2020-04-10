<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Contact</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_contact_list"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback">
<a href="{$redirectUrl}">{$lang.default.formBackLabel}</a>
</div>

<form action="{$conf.rooturl_admin}contact/edit/id/{$myContact->id}/redirect/{$redirectUrl}" method="post" name="myform" class="form-horizontal">
	<input type="hidden" name="ftoken" value="{$smarty.session.contactEditToken}" />
	{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
	
	<div class="control-group">
		<label class="control-label" for="ffullname">{$lang.controller.formFullnameLabel}</label>
		<div class="controls">
			<input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.formEmailLabel}</label>
		<div class="controls">
			<input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.formPhoneLabel}</label>
		<div class="controls">
			<input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="freason">{$lang.controller.formReasonLabel}</label>
		<div class="controls">
			<select id="freason" name="freason">
				<option value="general" {if $formData.freason eq 'general'}selected="selected"{/if}>{$lang.controller.reasonGeneral}</option>
				<option value="ads" {if $formData.freason eq 'ads'}selected="selected"{/if}>{$lang.controller.reasonAds}</option>
				<option value="idea" {if $formData.freason eq 'idea'}selected="selected"{/if}>{$lang.controller.reasonIdea}</option>
				<option value="support" {if $formData.freason eq 'support'}selected="selected"{/if}>{$lang.controller.reasonSupport}</option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fmessage">{$lang.controller.formMessageLabel}</label>
		<div class="controls">
			<textarea class="input-xxlarge"  rows="6" name="fmessage" id="fmessage">{$formData.fmessage}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.formStatusLabel}</label>
		<div class="controls">
			<select id="fstatus" name="fstatus">
				<option value="new" {if $formData.fstatus eq 'new'}selected="selected"{/if}>New</option>
				<option value="pending" {if $formData.fstatus eq 'pending'}selected="selected"{/if}>Pending</option>
				<option value="completed" {if $formData.fstatus eq 'completed'}selected="selected"{/if}>Completed</option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.formNoteLabel}</label>
		<div class="controls">
			<textarea class="input-xxlarge"  rows="4" name="fnote" id="fnote">{$formData.fnote}</textarea>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fdatecreated">{$lang.controller.formDateCreatedLabel}</label>
		<div class="controls">
			{$formData.fdatecreated|date_format:$lang.default.dateFormatTimeSmarty} ({$lang.controller.formIpAddressLabel} : <a href="http://www.ip2location.com/{$formData.fipaddress}" title="Click here to IP 2 Location" target="_blank">{$formData.fipaddress}</a>)
		</div>
	</div>			
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
	
	
</form>

