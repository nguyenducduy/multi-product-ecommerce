<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">AccessTicketType</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_accesstickettype"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.accesstickettypeAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fgroupcontroller">{$lang.controller.labelGroupcontroller} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fgroupcontroller" id="fgroupcontroller" style="width:200px;">
				<option value="">---Group Controller---</option>
				{foreach item=groupcontroller from=$groupcontrollerlist}
				<option value="{$groupcontroller}" {if $groupcontroller==$formData.fgroupcontroller}selected="selected"{/if}>{$groupcontroller}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontroller">{$lang.controller.labelController} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fcontroller" id="fcontroller" style="width:200px;">
				{foreach item=controller from=$controllerlist}
				<option value="{$controller}" {if $formData.fcontroller == $controller}selected="selected"{/if}>{$controller}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="faction">{$lang.controller.labelAction} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="faction" id="faction" value="{$formData.faction|@htmlspecialchars}" class="input-xlarge"></div>
	</div>	

	<div class="control-group">
		<label class="control-label" for="fdescription">{$lang.controller.labelDescription}</label>
		<div class="controls"><textarea name="fdescription" id="fdescription" rows="7" class="input-xxlarge">{$formData.fdescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
			<select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select>
		</div>
	</div>	
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$("#fgroupcontroller").select2();
		$("#fcontroller").select2();

		$("#fgroupcontroller").change(function(event) {
			var groupcontroller = $(this).val();
			$.ajax({
				url: rooturl_cms + 'accesstickettype/getcontrollerajax',
				type: 'POST',
				dataType: 'json',
				data: {groupcontroller:groupcontroller},
				success : function(data){
					var htmldata = '';
					$.each(data, function(index, value) {						 
						if(index == 0){
							htmldata += '<option selected="selected" value="'+value+'">'+value+'</option>';
						}else{
							htmldata += '<option value="'+value+'">'+value+'</option>';
						}
					});
					$("#fcontroller").html(htmldata);
				}
			})						
		});
	});
</script>
{/literal}

