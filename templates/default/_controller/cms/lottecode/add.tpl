<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteCode</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_lottecode"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.lottecodeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="flmid">{$lang.controller.labelLmid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="flmid" id="flmid" value="{$formData.flmid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}</label>
		<div class="controls">
			<select name="ftype" id="ftype" >
				<option value="0">----</option>
				{foreach $type as $k=>$v}
					<option value="{$k}" {if  {$formData.ftype}==$k}selected="selected"{/if}>{$v}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcode">{$lang.controller.labelCode} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcode" id="fcode" value="{$formData.fcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ferpsaleorderid">{$lang.controller.labelErpsaleorderid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ferpsaleorderid" id="ferpsaleorderid" value="{$formData.ferpsaleorderid|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="freferer">{$lang.controller.labelReferer} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freferer" id="freferer" value="{$formData.freferer|@htmlspecialchars}" class="input-mini"></div>
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
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


