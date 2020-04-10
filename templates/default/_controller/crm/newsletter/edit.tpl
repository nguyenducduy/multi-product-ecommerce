{include file="tinymce.tpl"}
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">Dashboard</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">Newsletter</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_newsletter_list"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback">
<a href="{$redirectUrl}">{$lang.default.formBackLabel}</a>
</div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.newsletterEditToken}" />
	{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}
	
	<div class="control-group">
		<label class="control-label" for="ffromemail">From Email</label>
		<div class="controls">
			<input type="text" name="ffromemail" id="ffromemail" value="{$formData.ffromemail|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ffromname">From Name</label>
		<div class="controls">
			<input type="text" name="ffromname" id="ffromname" value="{$formData.ffromname|@htmlspecialchars}" class="">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fsubject">Subject <span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" name="fsubject" id="fsubject" value="{$formData.fsubject|@htmlspecialchars}" class="input-xxlarge">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fcontents">Content</label>
		<div class="controls">
			<textarea class="input-xxlarge"  rows="30" name="fcontents" id="fcontents">{$formData.fcontents}</textarea>
		</div>
	</div>
	
	<div class="form-actions">
		<a class="btn btn-inverse pull-right" href="javascript:void(0)" onclick="window.open('{$conf.rooturl_admin}newsletter/preview/id/{$myNewsletter->id}', 'mywindow','location=1,status=1,scrollbars=1, width=740,height=500');" title="Click here to preview this email">Preview</a>
		<a class="btn pull-right" href="{$conf.rooturl_admin}newsletter/add/id/{$myNewsletter->id}" title="Copy this newsletter to new newsletter">Create new newsletter form this template</a>
		<a class="btn btn-info pull-right" title="Send this newsletter" href="{$conf.rooturl_admin}newsletter/sendtask/id/{$myNewsletter->id}">[SEND TASK]</a>
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>
	
</form>





