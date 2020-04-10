<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteEvent</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_lotteevent"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.lotteeventAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatebegin">{$lang.controller.labelDatebegin} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdatebegin" id="fdatebegin" value="{$formData.fdatebegin|@htmlspecialchars}" class="input-xlarge inputdatepicker" ></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdateend">{$lang.controller.labelDateend} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdateend" id="fdateend" value="{$formData.fdateend|@htmlspecialchars}" class="input-xlarge inputdatepicker"></div>
	</div>
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus" >
				<option value="0">----</option>
				<option value="0" {if  {$formData.status}==0}selected="selected"{/if}>Disable</option>
				<option value="1" {if  {$formData.status}==1}selected="selected"{/if}>Enable</option>
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpageid">{$lang.controller.labelPageid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fpageid" id="fpageid" value="{$formData.fpageid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


