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
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/ssid/{$storyid}">ScrumStoryAsignee</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_scrumstoryasignee"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryasigneeEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



    <div class="control-group">
        <label class="control-label" for="fssid">{$lang.controller.labelSsid}<span class="star_require">*</span></label>
        <div class="controls">
            <select name="fssid" id="fssid">
                <option value=''>----</option>
                {foreach $scrumstory as $key => $value}
                    <option value='{$value->id}'>{$value->asa}</option>
                {/foreach}
            </select>
        </div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fuid">{$lang.controller.labelUid}<span class="star_require">*</span></label>
		<div class="controls">
			<div id="divuid">
				<input type="hidden" name="fuid" id="fuid" value="{$formData.fuid|@htmlspecialchars}" class="input-mini">
				<span class="label label-info" id="spanname">{$formData.username}</span><span class="star_require"> * Click to edit user</span>
			</div>
			<div style="display: none" id="divuide">
				<span class="btnxong"><input type="text" name="" id="fuide" class="autocompletestaff input-mini" ></span>
				<span><input type="button" class="btn btn-primary"  id="editbtn" value="Xong"></span>
			</div>
		</div>
		
		
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini"></div>
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
</script>
{/literal}