<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">OrdersDetail</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_ordersdetail"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.ordersdetailEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpricesell">{$lang.controller.labelPricesell} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpricesell" id="fpricesell" value="{$formData.fpricesell|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricediscount">{$lang.controller.labelPricediscount}</label>
		<div class="controls"><input type="text" name="fpricediscount" id="fpricediscount" value="{$formData.fpricediscount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricefinal">{$lang.controller.labelPricefinal} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpricefinal" id="fpricefinal" value="{$formData.fpricefinal|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fquantity">{$lang.controller.labelQuantity} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fquantity" id="fquantity" value="{$formData.fquantity|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foptions">{$lang.controller.labelOptions}</label>
		<div class="controls"><input type="text" name="foptions" id="foptions" value="{$formData.foptions|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

