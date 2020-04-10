<html>
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

		<!-- Bootstrap Responsive Stylesheet -->
		<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

		<!-- Customized Admin Stylesheet -->
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
		<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

		<!-- <link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />
 -->
		<!-- jQuery -->
		<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

		<!-- Bootstrap Js -->
		<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>



		<!-- customized admin -->
		<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
		<!--<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>-->


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
	<body>
		<div class="page-header" rel="menu_productattribute"><h1>{$lang.controller.head_edit}</h1></div>

		<div class="navgoback"><a href="{$conf.rooturl_cms}productgroupattribute/view/pcid/{$formData.fpcid}">{$lang.default.formBackLabel}</a></div>

		<form action="" method="post" name="myform" class="form-horizontal">
		<input type="hidden" name="ftoken" value="{$smarty.session.productattributeEditToken}" />


			{include file="notify.tpl" notifyError=$error notifySuccess=$success}


			<div class="control-group">
				<label class="control-label" for="fpgaid">{$lang.controller.labelPgaid} <span class="star_require">*</span></label>
				<div class="controls"><select id="fpgaid" name="fpgaid">
						<option value="0">------</option>
						{if $productAttributeGroupList|@count > 0}
							{foreach item=productGroupAttribute from=$productAttributeGroupList}
								<option value="{$productGroupAttribute->id}" {if $formData.fpgaid == $productGroupAttribute->id}selected="selected"{/if}>{$productGroupAttribute->name}</option>
							{/foreach}
						{/if}
					</select></div>
			</div>

			<div class="form-actions">
				<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
				<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
			</div>

		</form>
	</body>
</html>