<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">JobReview</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_jobreview"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.jobreviewAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

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
		<label class="control-label" for="ftext">{$lang.controller.labelText} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="ftext" id="ftext" rows="7" class="input-xxlarge">{$formData.ftext}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fipaddress">{$lang.controller.labelIpaddress}</label>
		<div class="controls"><input type="text" name="fipaddress" id="fipaddress" value="{$formData.fipaddress|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fmoderatorid">{$lang.controller.labelModeratorid}</label>
		<div class="controls"><input type="text" name="fmoderatorid" id="fmoderatorid" value="{$formData.fmoderatorid|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><input type="text" name="fstatus" id="fstatus" value="{$formData.fstatus|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountthumbup">{$lang.controller.labelCountthumbup}</label>
		<div class="controls"><input type="text" name="fcountthumbup" id="fcountthumbup" value="{$formData.fcountthumbup|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountthumbdown">{$lang.controller.labelCountthumbdown}</label>
		<div class="controls"><input type="text" name="fcountthumbdown" id="fcountthumbdown" value="{$formData.fcountthumbdown|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcountreply">{$lang.controller.labelCountreply}</label>
		<div class="controls"><input type="text" name="fcountreply" id="fcountreply" value="{$formData.fcountreply|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdatemoderated">{$lang.controller.labelDatemoderated}</label>
		<div class="controls"><input type="text" name="fdatemoderated" id="fdatemoderated" value="{$formData.fdatemoderated|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
		<div class="controls"><input type="text" name="fparentid" id="fparentid" value="{$formData.fparentid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


