<style type="text/css">
.label-info
{
	font-size: 15px;
	margin-top: 8px;
	cursor: pointer;
}
.btnxong
{
	display: block;
	width: 525px;
	float: left;
}
</style>
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}">ScrumTeamMember</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_scrumteammember"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumteammemberEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid}<span class="star_require">*</span></label>
		<div class="controls">
			<div id="divuid">
				<input type="hidden" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini">
				<span class="label label-info" id="spanname">{$formData.username}</span><span class="star_require"> *Click to edit user</span>
			</div>
			<div style="display: none" id="divuide">
				<span class="btnxong"><input type="text" name="" id="fuide" class="autocompletestaff input-mini" ></span>
				<span><input type="button" class="btn btn-primary"  id="editbtn" value="Xong"></span>
			</div>
		</div>
		
		
	</div>
	
	<div class="control-group" id="divspid">
		<label class="control-label" for="fspid">{$lang.controller.labelSpid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fspid" id="fspid">
				 <option value=''>----</option>
				{foreach $project as $value}
				    <option value='{$value->id}'{if $value->id == $formData.fspid} selected = 'selected' {/if}>{$value->name}</option>
				{/foreach}
			</select>

		</div>
	</div>
	<div class="control-group" id="divstid">
		<label class="control-label" for="fstid">{$lang.controller.labelStid} <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fstid" id="fstid">
				 <option value=''>----</option>
				{foreach $team as $value}
				    <option value='{$value->id}'{if $value->id == $formData.fstid} selected = 'selected' {/if}>{$value->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="frole">{$lang.controller.labelRole}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="frole" id="frole">
				 <option value=''>----</option>
				{foreach $listRole as $key => $value}
				    <option value='{$key}' {if {$formData.frole}=={$key}}selected{/if}>{$value}</option>
				{/foreach}
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
$("#divuid").click(function(){
	$("#divuide").show(500);
	$("#divuid").hide(500);
});
$("#editbtn").click(function(){
	
	$("#divuide").hide(500);
	if(typeof($(".bit-box").attr("rel"))!="undefine")
	{
		$("#fuid").val($(".bit-box").attr("rel"));
		var test =$("ul.holder li:eq(0)").text();
		$("#spanname").html(test);
	}
	
	$("#divuid").show(500);
	
});
$("#fspid").change(function(){
	var pid = $("#fspid").val();
	var url = '/admin/scrumteammember/indexAjax/pid/'+pid; 
	$.ajax({
			type : "GET",
			url : url,
			dataType: "html",
			success: function(data){
				if(data !="")
				{
					$("#divstid").remove();
					$("#divspid").after(data);
				}
				else
				{
					$("#divstid").remove();
				}
			}
		});
});
</script>
{/literal}