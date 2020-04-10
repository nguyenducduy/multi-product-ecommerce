<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">ApiPartner</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_apipartner"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.apipartnerEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		

	<div class="control-group">
		<label class="control-label" for="fkey">{$lang.controller.labelKey} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fkey" id="fkey" value="{$formData.fkey|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsecret">{$lang.controller.labelSecret} <span class="star_require">*</span></label>
		<div class="controls">
			<input type="text" name="fsecret" id="fsecret" value="{$formData.fsecret|@htmlspecialchars}" class="input-xlarge" readonly="readonly">
			&nbsp;<a href="javascript:void(0)" id="changeserect">Change Secret</a>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="femail">{$lang.controller.labelEmail}</label>
		<div class="controls"><input type="text" name="femail" id="femail" value="{$formData.femail|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fphone">{$lang.controller.labelPhone}</label>
		<div class="controls"><input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
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
{literal}
<script type="text/javascript">
	var id = {/literal}{$formData.fid}{literal}
	$("#changeserect").click(function(){
		$.ajax({
			type:"post",
			dataType:"html",
			data: "id="+id,
			url : "/cms/apipartner/changesecretajax",
			success : function(html){
				if(html === ''){
					showGritterError('Change secret is error .');
				}else{
					showGritterSuccess('Change secret is success.');
					$("#fsecret").val(html);
				}
			}
		});
	});
</script>
{/literal}
