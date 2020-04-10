
<title></title>
<link rel="stylesheet" href="{$currentTemplate}bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$currentTemplate}bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

<!-- Bootstrap Responsive Stylesheet -->
<link rel="stylesheet" href="{$currentTemplate}bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

<!-- Customized Admin Stylesheet -->
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

<!-- jQuery -->
<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>


<!-- customized admin -->
<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
 <script type="text/javascript">
        var rooturl = "{$conf.rooturl}";
        var rooturl_admin = "{$conf.rooturl_admin}";
        var rooturl_cms = "{$conf.rooturl_cms}";
        var rooturl_crm = "{$conf.rooturl_crm}";
        var rooturl_erp = "{$conf.rooturl_erp}";
        var rooturl_profile = "{$conf.rooturl_profile}";
        var controllerGroup = "{$controllerGroup}";
        var currentTemplate = "{$currentTemplate}";
        var delConfirm = "Are You Sure?";
		var delPromptYes = "Type YES to continue";

</script>
<style type="text/css">
    body{
        padding: 0px;
    }
    .page-header h1 {
        margin-top: 10px;
    }
    #choose, .table{
        font-size: 12px;
    }
 
</style>
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Giftorderproduct</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_giftorderproduct"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.giftorderproductEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fproductid">{$lang.controller.labelProductid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fproductid" id="fproductid" style="height:30px" value="{$formData.fproductid|@htmlspecialchars}" class="input-large"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fquantity">{$lang.controller.labelQuantity} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fquantity" id="fquantity" style="height:30px" value="{$formData.fquantity|@htmlspecialchars}" class="input-large"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finstock">{$lang.controller.labelInstock} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finstock" id="finstock"  style="height:30px" value="{$formData.finstock|@htmlspecialchars}" class="input-large"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select class="" name="fstatus" id="fstatus">{html_options options=$statusOptions selected=$formData.fstatus}</select></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

