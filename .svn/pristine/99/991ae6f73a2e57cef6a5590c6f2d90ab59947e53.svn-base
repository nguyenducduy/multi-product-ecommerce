<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">LotteMember</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_lottemember"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.lottememberEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="furlcode">{$lang.controller.labelUrlcode} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="furlcode" id="furlcode" value="{$formData.furlcode|@htmlspecialchars}" class="input-xlarge"></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fleid">Event</label>
		<div class="controls">
			<select name="fleid" id="fleid" >
				<option value="0">----</option>
				{foreach $event as $k=>$v}
					<option value="{$v->id}" {if  {$formData.fleid}=={$v->id}}selected="selected"{/if}>{$v->name}</option>
				{/foreach}
			</select>
		</div>
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
		<label class="control-label" for="fgender">{$lang.controller.labelGender}</label>
		<div class="controls">
			<select name="fgender" id="fgender" >
				<option value="">----</option>
				<option value="1" {if  {$formData.gender}==1}selected="selected"{/if}>Nam</option>
				<option value="0" {if  {$formData.gender}==0}selected="selected"{/if}>Nữ</option>
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcmnd">{$lang.controller.labelCmnd} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fcmnd" id="fcmnd" value="{$formData.fcmnd|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fregion">{$lang.controller.labelRegion}</label>
		<div class="controls">
			<select name="fregion" id="fregion" >
				<option value="0">----</option>
				{foreach $region as $k=>$v}
					<option value="{$k}" {if  {$formData.fregion}==$k}selected="selected"{/if}>{$v}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="freferermemberid">{$lang.controller.labelReferermemberid} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="freferermemberid" id="freferermemberid" value="{$formData.freferermemberid|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

