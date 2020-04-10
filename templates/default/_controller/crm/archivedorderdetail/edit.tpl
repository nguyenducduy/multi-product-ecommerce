<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ArchivedorderDetail</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_archivedorderdetail"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.archivedorderdetailEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fsaleorderid">{$lang.controller.labelSaleorderid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsaleorderid" id="fsaleorderid" value="{$formData.fsaleorderid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fproductid">{$lang.controller.labelProductid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fproductid" id="fproductid" value="{$formData.fproductid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fquantity">{$lang.controller.labelQuantity} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fquantity" id="fquantity" value="{$formData.fquantity|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsaleprice">{$lang.controller.labelSaleprice} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsaleprice" id="fsaleprice" value="{$formData.fsaleprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="foutputtypeid">{$lang.controller.labelOutputtypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="foutputtypeid" id="foutputtypeid" value="{$formData.foutputtypeid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvat">{$lang.controller.labelVat} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fvat" id="fvat" value="{$formData.fvat|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsalepriceerp">{$lang.controller.labelSalepriceerp} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fsalepriceerp" id="fsalepriceerp" value="{$formData.fsalepriceerp|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fendwarrantytime">{$lang.controller.labelEndwarrantytime} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fendwarrantytime" id="fendwarrantytime" value="{$formData.fendwarrantytime|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fispromotionautoadd">{$lang.controller.labelIspromotionautoadd} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fispromotionautoadd" id="fispromotionautoadd" value="{$formData.fispromotionautoadd|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromotionid">{$lang.controller.labelPromotionid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpromotionid" id="fpromotionid" value="{$formData.fpromotionid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromotionlistgroupid">{$lang.controller.labelPromotionlistgroupid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpromotionlistgroupid" id="fpromotionlistgroupid" value="{$formData.fpromotionlistgroupid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fapplyproductid">{$lang.controller.labelApplyproductid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fapplyproductid" id="fapplyproductid" value="{$formData.fapplyproductid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="freplicationstoreid">{$lang.controller.labelReplicationstoreid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freplicationstoreid" id="freplicationstoreid" value="{$formData.freplicationstoreid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fadjustpricetypeid">{$lang.controller.labelAdjustpricetypeid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fadjustpricetypeid" id="fadjustpricetypeid" value="{$formData.fadjustpricetypeid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fadjustprice">{$lang.controller.labelAdjustprice} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fadjustprice" id="fadjustprice" value="{$formData.fadjustprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fadjustpricecontent">{$lang.controller.labelAdjustpricecontent} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fadjustpricecontent" id="fadjustpricecontent" value="{$formData.fadjustpricecontent|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdiscountcode">{$lang.controller.labelDiscountcode} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdiscountcode" id="fdiscountcode" value="{$formData.fdiscountcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fadjustpriceuser">{$lang.controller.labelAdjustpriceuser} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fadjustpriceuser" id="fadjustpriceuser" value="{$formData.fadjustpriceuser|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvatpercent">{$lang.controller.labelVatpercent} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fvatpercent" id="fvatpercent" value="{$formData.fvatpercent|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fretailprice">{$lang.controller.labelRetailprice} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fretailprice" id="fretailprice" value="{$formData.fretailprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finputvoucherdetailid">{$lang.controller.labelInputvoucherdetailid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finputvoucherdetailid" id="finputvoucherdetailid" value="{$formData.finputvoucherdetailid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbuyinputvoucherid">{$lang.controller.labelBuyinputvoucherid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fbuyinputvoucherid" id="fbuyinputvoucherid" value="{$formData.fbuyinputvoucherid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finputvoucherdate">{$lang.controller.labelInputvoucherdate} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finputvoucherdate" id="finputvoucherdate" value="{$formData.finputvoucherdate|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisnew">{$lang.controller.labelIsnew} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisnew" id="fisnew" value="{$formData.fisnew|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fisshowproduct">{$lang.controller.labelIsshowproduct} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fisshowproduct" id="fisshowproduct" value="{$formData.fisshowproduct|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcostprice">{$lang.controller.labelCostprice} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcostprice" id="fcostprice" value="{$formData.fcostprice|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fproductsaleskitid">{$lang.controller.labelProductsaleskitid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fproductsaleskitid" id="fproductsaleskitid" value="{$formData.fproductsaleskitid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="frefproductid">{$lang.controller.labelRefproductid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="frefproductid" id="frefproductid" value="{$formData.frefproductid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fproductcomboid">{$lang.controller.labelProductcomboid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fproductcomboid" id="fproductcomboid" value="{$formData.fproductcomboid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

