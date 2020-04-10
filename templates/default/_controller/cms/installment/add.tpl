<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Installment</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_installment"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.installmentAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpid">{$lang.controller.labelPid}</label>
		<div class="controls"><input type="text" name="fpid" id="fpid" value="{$formData.fpid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finvoiceid">{$lang.controller.labelInvoiceid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="finvoiceid" id="finvoiceid" value="{$formData.finvoiceid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricesell">{$lang.controller.labelPricesell}</label>
		<div class="controls"><input type="text" name="fpricesell" id="fpricesell" value="{$formData.fpricesell|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpricemonthly">{$lang.controller.labelPricemonthly}</label>
		<div class="controls"><input type="text" name="fpricemonthly" id="fpricemonthly" value="{$formData.fpricemonthly|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fgender">{$lang.controller.labelGender}</label>
		<div class="controls"><input type="text" name="fgender" id="fgender" value="{$formData.fgender|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffullname">{$lang.controller.labelFullname}</label>
		<div class="controls"><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone}</label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail}</label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fbirthday">{$lang.controller.labelBirthday}</label>
		<div class="controls"><input type="text" name="fbirthday" id="fbirthday" value="{$formData.fbirthday|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpersonalid">{$lang.controller.labelPersonalid}</label>
		<div class="controls"><input type="text" name="fpersonalid" id="fpersonalid" value="{$formData.fpersonalid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpersonaltype">{$lang.controller.labelPersonaltype}</label>
		<div class="controls"><input type="text" name="fpersonaltype" id="fpersonaltype" value="{$formData.fpersonaltype|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="faddress">{$lang.controller.labelAddress}</label>
		<div class="controls"><input type="text" name="faddress" id="faddress" value="{$formData.faddress|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fregion">{$lang.controller.labelRegion}</label>
		<div class="controls"><input type="text" name="fregion" id="fregion" value="{$formData.fregion|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fregionresident">{$lang.controller.labelRegionresident}</label>
		<div class="controls"><input type="text" name="fregionresident" id="fregionresident" value="{$formData.fregionresident|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finstallmentmonth">{$lang.controller.labelInstallmentmonth}</label>
		<div class="controls"><input type="text" name="finstallmentmonth" id="finstallmentmonth" value="{$formData.finstallmentmonth|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsegmentpercent">{$lang.controller.labelSegmentpercent}</label>
		<div class="controls"><input type="text" name="fsegmentpercent" id="fsegmentpercent" value="{$formData.fsegmentpercent|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpayathome">{$lang.controller.labelPayathome}</label>
		<div class="controls"><input type="text" name="fpayathome" id="fpayathome" value="{$formData.fpayathome|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


