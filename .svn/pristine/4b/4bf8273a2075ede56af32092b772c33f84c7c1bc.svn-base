<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_admin}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl_admin}{$controller}">OrdersDetail</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_ordersdetail"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.ordersdetailEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="foid">Order ID</label>
		<div class="controls"><input type="text" name="foid" id="foid" value="{$formData.foid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbid">Book ID</label>
		<div class="controls"><input type="text" name="fbid" id="fbid" value="{$formData.fbid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">Name</label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricesell">Price Sell</label>
		<div class="controls"><input type="text" name="fpricesell" id="fpricesell" value="{$formData.fpricesell|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricediscount">Price Discount</label>
		<div class="controls"><input type="text" name="fpricediscount" id="fpricediscount" value="{$formData.fpricediscount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricefinal">Price Final</label>
		<div class="controls"><input type="text" name="fpricefinal" id="fpricefinal" value="{$formData.fpricefinal|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fquantity">Quantity</label>
		<div class="controls"><input type="text" name="fquantity" id="fquantity" value="{$formData.fquantity|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fweight">Weight</label>
		<div class="controls"><input type="text" name="fweight" id="fweight" value="{$formData.fweight|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsize">Size</label>
		<div class="controls"><input type="text" name="fsize" id="fsize" value="{$formData.fsize|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

