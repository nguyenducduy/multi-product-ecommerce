<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartnerSale</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_apipartnersale"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.apipartnersaleEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fapid">{$lang.controller.labelApid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fapid" id="fapid" value="{$formData.fapipartnername|@htmlspecialchars}" class="input-large" readonly="readonly"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini" readonly="readonly"></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPbarcode} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpbarcode|@htmlspecialchars}" class="input-large" readonly="readonly"></div>
	</div>
	

	<div class="control-group">
		<label class="control-label" for="fdiscountvalue">{$lang.controller.labelDiscountvalue}</label>
		<div class="controls"><input type="text" name="fdiscountvalue" id="fdiscountvalue" value="{$formData.fdiscountvalue|@htmlspecialchars}" class="input-mini">%</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus} <span class="star_require">*</span></label>
		<div class="controls">
			<select id="fstatus" name="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>	
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

