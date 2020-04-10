<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Promotiongroup</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_promotiongroup"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.promotiongroupAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fpromoid">{$lang.controller.labelPromoid}</label>
		<div class="controls"><input type="text" name="fpromoid" id="fpromoid" value="{$formData.fpromoid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgusercreate">{$lang.controller.labelPromolgusercreate}</label>
		<div class="controls"><input type="text" name="fpromolgusercreate" id="fpromolgusercreate" value="{$formData.fpromolgusercreate|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolguserdeleted">{$lang.controller.labelPromolguserdeleted}</label>
		<div class="controls"><input type="text" name="fpromolguserdeleted" id="fpromolguserdeleted" value="{$formData.fpromolguserdeleted|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgisfixed">{$lang.controller.labelPromolgisfixed}</label>
		<div class="controls"><input type="text" name="fpromolgisfixed" id="fpromolgisfixed" value="{$formData.fpromolgisfixed|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgisdeleted">{$lang.controller.labelPromolgisdeleted}</label>
		<div class="controls"><input type="text" name="fpromolgisdeleted" id="fpromolgisdeleted" value="{$formData.fpromolgisdeleted|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgisdiscount">{$lang.controller.labelPromolgisdiscount}</label>
		<div class="controls"><input type="text" name="fpromolgisdiscount" id="fpromolgisdiscount" value="{$formData.fpromolgisdiscount|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgdiscountvalue">{$lang.controller.labelPromolgdiscountvalue}</label>
		<div class="controls"><input type="text" name="fpromolgdiscountvalue" id="fpromolgdiscountvalue" value="{$formData.fpromolgdiscountvalue|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgisdiscountpercent">{$lang.controller.labelPromolgisdiscountpercent}</label>
		<div class="controls"><input type="text" name="fpromolgisdiscountpercent" id="fpromolgisdiscountpercent" value="{$formData.fpromolgisdiscountpercent|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgiscondition">{$lang.controller.labelPromolgiscondition}</label>
		<div class="controls"><input type="text" name="fpromolgiscondition" id="fpromolgiscondition" value="{$formData.fpromolgiscondition|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgconditiontext">{$lang.controller.labelPromolgconditiontext}</label>
		<div class="controls"><textarea name="fpromolgconditiontext" id="fpromolgconditiontext" rows="7" class="input-xxlarge">{$formData.fpromolgconditiontext}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgtype">{$lang.controller.labelPromolgtype}</label>
		<div class="controls"><input type="text" name="fpromolgtype" id="fpromolgtype" value="{$formData.fpromolgtype|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromotiondateadd">{$lang.controller.labelPromotiondateadd}</label>
		<div class="controls"><input type="text" name="fpromotiondateadd" id="fpromotiondateadd" value="{$formData.fpromotiondateadd|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpromolgdatemodify">{$lang.controller.labelPromolgdatemodify}</label>
		<div class="controls"><input type="text" name="fpromolgdatemodify" id="fpromolgdatemodify" value="{$formData.fpromolgdatemodify|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


