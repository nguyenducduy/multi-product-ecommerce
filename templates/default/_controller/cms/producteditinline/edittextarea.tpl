<title>Editinline Product Textarea</title>
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

<p></p>
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<div class="page-header"><h1>{$head_list}</h1></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="fpid" value="{$formData.fpid}" />
	<input type="hidden" name="ftoken" value="{$smarty.session.productEditToken}" />
	<textarea name="fdata" id="fdata" rows="14" class="input-xxlarge">{$formData.fdata}</textarea>
		{include file="tinymce.tpl"}
	<br />
	<div style="margin-left: 220px;">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
	</div>
</form>