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
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div style="padding-top:10px;">
		<form action="" method="post" name="myform" class="form-horizontal">
			<table>
				<tr>
					<td><input type="hidden" name="ftype" value ="{$formData.ftype}" /><label style="width:67px;" class="control-label" for="fuid">{$lang.controller.labelAccount}</label></td>
					<td><select name="fuid[]" id="fuid" class="autocompletestaff" multiple="multiple">

					</select></td>
				</tr>
				<tr>
					<td></td>
					<td><input style="margin-left:77px;margin-top:40px;" type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" /></td>
				</tr>
			</table>
		</form>
	</div>


{literal}
<script type="text/javascript">

Shadowbox.init({
	    players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv'],
	    onClose: function(){ window.location.reload(); }
	});
$(document).ready(function() {
	$('.holder').css('width' , '250px');
	$('.default').css('width' , '250px');
	$('.facebook-auto').css('width' , '265px');
});

</script>
{/literal}
