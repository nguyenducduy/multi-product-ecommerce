<!DOCTYPE html>
<html lang="en">
  <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>{$pageTitle|default:$currentUrl}</title>
		
		<!-- Bootstrap Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />
	  	
		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />
        
		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />
		
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />

		
		
		
		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>
		
		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>
		
		
		
		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
		<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>
		
		
        <script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_admin = "{$conf.rooturl_admin}";
		var rooturl_cms = "{$conf.rooturl_cms}";
		var rooturl_crm = "{$conf.rooturl_crm}";
		var rooturl_erp = "{$conf.rooturl_erp}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var controllerGroup = "{$controllerGroup}";
		var currentTemplate = "{$currentTemplate}";
		
		var websocketurl = "{$setting.site.websocketurl}";
		var websocketenable = {$setting.site.websocketenable};
		
		var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";
		
		
		var imageDir = "{$imageDir}";
		var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
		var gritterDelay = 3000;
		var meid = {$me->id};
		var meurl = "{$me->getUserPath()}";
		var userid = {$myUser->id};
		var userurl = "{$myUser->getUserPath()}";
		</script>
		
	</head>

<div style="padding: 15px;">
<div class="page-header" rel="menu_feedback"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$conf.rooturl_cms}feedback">Xem tất cả Feedback</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.feedbackEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fasa">{$lang.controller.labelAsa} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fasa" id="fasa" value="{$formData.fasa|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fiwant">{$lang.controller.labelIwant} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fiwant" id="fiwant" rows="7" class="input-xxlarge">{$formData.fiwant}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsothat">{$lang.controller.labelSothat}</label>
		<div class="controls"><textarea name="fsothat" id="fsothat" rows="7" class="input-xxlarge">{$formData.fsothat}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsection">{$lang.controller.labelSection}</label>
		<div class="controls">
			<select name="fsection" id="fsection">
				<option value="">-------</option>
				{foreach item=section from=$mySection}
				<option value="{$section->id}"{if $formData.fsection == $section->id}selected="selected"{/if}>{$section->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffilepath">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
                {html_options options=$statusList selected=$formData.fstatus}
            </select>
		</div>
	</div>
			
	<div class="control-group">
		<label class="control-label" for="ffilepath">{$lang.controller.labelFilepath}</label>
		<div class="controls"><input type="file" name="ffilepath" id="ffilepath" value="{$formData.ffilepath}"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

</div>