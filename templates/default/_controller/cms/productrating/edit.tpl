<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Đánh giá sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_productrating"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.productratingEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="freviewid">{$lang.controller.labelReviewid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freviewid" id="freviewid" value="{$formData.freviewid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fobjectid">{$lang.controller.labelObjectid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fobjectid" id="fobjectid" value="{$formData.fobjectid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ffullname">{$lang.controller.labelFullname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fvalue">{$lang.controller.labelValue}</label>
		<div class="controls"><input type="text" name="fvalue" id="fvalue" value="{$formData.fvalue|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fipaddress">{$lang.controller.labelIpaddress}</label>
		<div class="controls"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

