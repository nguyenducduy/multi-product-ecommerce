<title>Chi tiết giá của sản phẩm{$myProduct->name}</title>
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

<!-- Bootstrap Responsive Stylesheet -->
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

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
<div style="margin:-30px 100px;">
<div class="page-header"><h1 style="display:inline;">Thêm đối thủ</h1>
	
</div>
<div class="navgoback"><a href="{$registry->conf.rooturl_admin}productprice/index/pbarcode/{$registry->router->getArg('pbarcode')}/tab/2">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.priceenemyAddToken}" />
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	{include file="tinymce.tpl"}
	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" readonly="true" value="{$product|@htmlspecialchars}" class="input-mini"></div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="feid">{$lang.controller.labelEid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="feid" id="feid" style="width:200px;">
				<option value="0">-------</option>
				{foreach item=enemy from=$enemys}
				<option value="{$enemy->id}" {if $enemy->id ==  $formData.feid}selected="selected"{/if}>{$enemy->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fregion">{$lang.controller.labelRegion}</label>
		<div class="controls">
			<select name="frid" id="frid" style="width:200px;"> 
				{foreach item=region key=regionid from=$setting.region}
		        	<option {if $regionid == $registry->region}selected="selected" {/if} value="{$regionid}">{$region}{if $regionid == $registry->region}{/if}</option>
		        {/foreach}
			</select>
		</div>
	</div>	
	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.lableType}</label>
		<div class="controls">
			<select name="ftype" id="ftype" style="width:200px;"> 
		        	<option {if $formData.ftype == 2}selected="selected"{/if} value="2">Offline</option>
			</select>
		</div>
	</div>
	<div class="group-offline">
		<div class="control-group">
			<label class="control-label" for="fname">{$lang.controller.lableName}<span class="star_require">*</span></label>
			<div class="controls"><input type="text" name="fname" id="fname" style=" height: 28px; " value="{$formData.fname|@htmlspecialchars}" class="input-large"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="fproductname">{$lang.controller.lableProductname}</label>
			<div class="controls"><input type="text" name="fproductname" style=" height: 28px; " id="fproductname" value="{$formData.fproductname|@htmlspecialchars}" class="input-large"></div>
		</div>	
		<div class="control-group">
			<label class="control-label" for="fprice">{$lang.controller.labelPrice}</label>
			<div class="controls"><input type="text" name="fprice" style=" height: 28px; " id="fprice" value="{$formData.fprice|@htmlspecialchars}" class="input-large"></div>
		</div>	
		<div class="control-group">
			<label class="control-label" for="fpricepromotion">{$lang.controller.lablePricePromotion}</label>
			<div class="controls"><input type="text" name="fpricepromotion" style=" height: 28px; " id="fpricepromotion" value="{$formData.fpricepromotion|@htmlspecialchars}" class="input-large"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="fpromotioninfo">{$lang.controller.lablePromotionInfo}</label>
			<div class="controls">
				<textarea name="fpromotioninfo" id="fpromotioninfo" rows="5" class="input-xxlarge">
					{$formData.fpromotioninfo|@htmlspecialchars}
				</textarea>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
			<div class="controls">
				<textarea name="fdescription" id="fdescription" rows="5" class="input-xxlarge">
					{$formData.fdescription|@htmlspecialchars}
				</textarea>
			</div>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote}</label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="mceNoEditor input-xxlarge">{$formData.fnote}</textarea></div>
	</div>		
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$("#feid").select2();
		$("#frid").select2();

		/*$("#ftype").change(function(event) {
			var type = $(this).val();
			if(type == 1)
			{
				$('.group-online').toggle("slow");
				$('.group-offline').fadeOut('fast');
			}
			else
			{
				$('.group-offline').toggle("slow");
 				$('.group-online').fadeOut('fast');
			}
		});*/
	});

	


</script>
{/literal}

