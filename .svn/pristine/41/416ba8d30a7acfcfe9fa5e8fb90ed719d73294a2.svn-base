<style type="text/css">
.label-info
{
	font-size: 15px;
	margin-top: 8px;
	cursor: pointer;
}
.btnxong
{
	margin-top: 8px;
	position: absolute;
	top: 205px;
	right: 450px;
}
</style>
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/siid/{$sprintid}">ScrumMeeting</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_scrummeeting"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrummeetingEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid}<span class="star_require">*</span></label>
		<div class="controls">
			<div id="divuid">
				<input  type="hidden" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini">
				<span class="label label-info" id="spanname" >{$formData.username}</span>
			</div>
			<div style="display: none" id="divuide">
				<input type="text" name="" id="fuide" class="autocompletestaff" vclass="input-mini" >
				<input type="button" class="btn btnxong"  id="editbtn" value="Xong">
			</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsiid">{$lang.controller.labelSiid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fsiid" id="fsiid">
				{foreach $scrumiteration as $value}
				    <option value='{$value->id}' {if {$value->id}=={$formData.fsiid}}selected{/if}>{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="ftype" id="ftype">
				{foreach $liststatus as $key => $value}
				    <option value='{$key}' {if {$formData.ftype}=={$key}}selected{/if}>{$value}</option>
				{/foreach}
			</select>
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="input-xxlarge">{$formData.fsummary}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fnote">{$lang.controller.labelNote} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fnote" id="fnote" rows="7" class="input-xxlarge">{$formData.fnote}</textarea></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>

{literal}
<script type="text/javascript">
$("#divuid").click(function(){
	$("#divuide").show(500);
	$("#divuid").hide(500);
});
$("#editbtn").click(function(){
	$("#divuide").hide(500);
	if(typeof($(".bit-box").attr("rel"))!="undefine")
	$("#fuid").val($(".bit-box").attr("rel"));
	$("#divuid").show(500);
	var url      = '/admin/scrummeeting/indexAjax'; 
	var id  = $("#fuid").val();
	$.ajax({
			type : "POST",
			data : {id:id},
			url : url,
			dataType: "html",
			success: function(data){
				if(data!="")
					$("#spanname").html(data);
			}
	});
});
</script>
{/literal}