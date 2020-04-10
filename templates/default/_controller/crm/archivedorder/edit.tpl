<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Archivedorder</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_archivedorder"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.archivedorderEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fsaleorderid">{$lang.controller.labelSaleorderid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsaleorderid" id="fsaleorderid" value="{$formData.fsaleorderid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fordertypeid">{$lang.controller.labelOrdertypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fordertypeid" id="fordertypeid" value="{$formData.fordertypeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdeliverytypeid">{$lang.controller.labelDeliverytypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdeliverytypeid" id="fdeliverytypeid" value="{$formData.fdeliverytypeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcompanyid">{$lang.controller.labelCompanyid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcompanyid" id="fcompanyid" value="{$formData.fcompanyid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcustomerid">{$lang.controller.labelCustomerid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcustomerid" id="fcustomerid" value="{$formData.fcustomerid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcustomername">{$lang.controller.labelCustomername} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcustomername" id="fcustomername" value="{$formData.fcustomername|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcustomeraddress">{$lang.controller.labelCustomeraddress} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcustomeraddress" id="fcustomeraddress" value="{$formData.fcustomeraddress|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcustomerphone">{$lang.controller.labelCustomerphone} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcustomerphone" id="fcustomerphone" value="{$formData.fcustomerphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontactname">{$lang.controller.labelContactname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcontactname" id="fcontactname" value="{$formData.fcontactname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fgender">{$lang.controller.labelGender} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fgender" id="fgender" value="{$formData.fgender|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fageid">{$lang.controller.labelAgeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fageid" id="fageid" value="{$formData.fageid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdeliveryaddress">{$lang.controller.labelDeliveryaddress} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdeliveryaddress" id="fdeliveryaddress" value="{$formData.fdeliveryaddress|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fprovinceid">{$lang.controller.labelProvinceid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fprovinceid" id="fprovinceid" value="{$formData.fprovinceid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdistrictid">{$lang.controller.labelDistrictid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdistrictid" id="fdistrictid" value="{$formData.fdistrictid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisreviewed">{$lang.controller.labelIsreviewed} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisreviewed" id="fisreviewed" value="{$formData.fisreviewed|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpayabletypeid">{$lang.controller.labelPayabletypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpayabletypeid" id="fpayabletypeid" value="{$formData.fpayabletypeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcurrencyunitid">{$lang.controller.labelCurrencyunitid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcurrencyunitid" id="fcurrencyunitid" value="{$formData.fcurrencyunitid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcurrencyexchange">{$lang.controller.labelCurrencyexchange} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcurrencyexchange" id="fcurrencyexchange" value="{$formData.fcurrencyexchange|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotalquantity">{$lang.controller.labelTotalquantity} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftotalquantity" id="ftotalquantity" value="{$formData.ftotalquantity|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotalamount">{$lang.controller.labelTotalamount} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftotalamount" id="ftotalamount" value="{$formData.ftotalamount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotaladvance">{$lang.controller.labelTotaladvance} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftotaladvance" id="ftotaladvance" value="{$formData.ftotaladvance|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fshippingcost">{$lang.controller.labelShippingcost} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fshippingcost" id="fshippingcost" value="{$formData.fshippingcost|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdebt">{$lang.controller.labelDebt} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdebt" id="fdebt" value="{$formData.fdebt|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdiscountreasonid">{$lang.controller.labelDiscountreasonid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdiscountreasonid" id="fdiscountreasonid" value="{$formData.fdiscountreasonid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdiscount">{$lang.controller.labelDiscount} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdiscount" id="fdiscount" value="{$formData.fdiscount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foriginatestoreid">{$lang.controller.labelOriginatestoreid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="foriginatestoreid" id="foriginatestoreid" value="{$formData.foriginatestoreid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisoutproduct">{$lang.controller.labelIsoutproduct} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisoutproduct" id="fisoutproduct" value="{$formData.fisoutproduct|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foutputstoreid">{$lang.controller.labelOutputstoreid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="foutputstoreid" id="foutputstoreid" value="{$formData.foutputstoreid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisincome">{$lang.controller.labelIsincome} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisincome" id="fisincome" value="{$formData.fisincome|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisdeleted">{$lang.controller.labelIsdeleted} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisdeleted" id="fisdeleted" value="{$formData.fisdeleted|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromotiondiscount">{$lang.controller.labelPromotiondiscount} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpromotiondiscount" id="fpromotiondiscount" value="{$formData.fpromotiondiscount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvouchertypeid">{$lang.controller.labelVouchertypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fvouchertypeid" id="fvouchertypeid" value="{$formData.fvouchertypeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvoucherconcern">{$lang.controller.labelVoucherconcern} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fvoucherconcern" id="fvoucherconcern" value="{$formData.fvoucherconcern|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdeliveryuser">{$lang.controller.labelDeliveryuser} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdeliveryuser" id="fdeliveryuser" value="{$formData.fdeliveryuser|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsaleprogramid">{$lang.controller.labelSaleprogramid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsaleprogramid" id="fsaleprogramid" value="{$formData.fsaleprogramid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotalpaid">{$lang.controller.labelTotalpaid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftotalpaid" id="ftotalpaid" value="{$formData.ftotalpaid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fissmspromotion">{$lang.controller.labelIssmspromotion} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fissmspromotion" id="fissmspromotion" value="{$formData.fissmspromotion|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdeliverytime">{$lang.controller.labelDeliverytime} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdeliverytime" id="fdeliverytime" value="{$formData.fdeliverytime|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisdelivery">{$lang.controller.labelIsdelivery} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisdelivery" id="fisdelivery" value="{$formData.fisdelivery|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdeliveryupdatetime">{$lang.controller.labelDeliveryupdatetime} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdeliveryupdatetime" id="fdeliveryupdatetime" value="{$formData.fdeliveryupdatetime|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fismove">{$lang.controller.labelIsmove} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fismove" id="fismove" value="{$formData.fismove|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fparentsaleorderid">{$lang.controller.labelParentsaleorderid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fparentsaleorderid" id="fparentsaleorderid" value="{$formData.fparentsaleorderid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fthirdpartyvoucher">{$lang.controller.labelThirdpartyvoucher} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fthirdpartyvoucher" id="fthirdpartyvoucher" value="{$formData.fthirdpartyvoucher|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpayabletime">{$lang.controller.labelPayabletime} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpayabletime" id="fpayabletime" value="{$formData.fpayabletime|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcreatedbyotherapps">{$lang.controller.labelCreatedbyotherapps} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcreatedbyotherapps" id="fcreatedbyotherapps" value="{$formData.fcreatedbyotherapps|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontactphone">{$lang.controller.labelContactphone} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcontactphone" id="fcontactphone" value="{$formData.fcontactphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcustomercarestatusid">{$lang.controller.labelCustomercarestatusid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcustomercarestatusid" id="fcustomercarestatusid" value="{$formData.fcustomercarestatusid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftotalprepaid">{$lang.controller.labelTotalprepaid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftotalprepaid" id="ftotalprepaid" value="{$formData.ftotalprepaid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcrmcustomerid">{$lang.controller.labelCrmcustomerid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcrmcustomerid" id="fcrmcustomerid" value="{$formData.fcrmcustomerid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatearchived">{$lang.controller.labelDatearchived} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdatearchived" id="fdatearchived" value="{$formData.fdatearchived|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

