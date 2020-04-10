<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}">ScrumTeamMember</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrumteammember"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumteammemberAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="frole">{$lang.controller.labelUid}<span class="star_require">*</span></label>
		<div class="controls">
            <select name="fuid" id="fuid" class="autocompletestaff">

            </select>
        </div>
	</div>
	<div class="control-group" id="divspid">
		<label class="control-label" for="fspid">{$lang.controller.labelSpid}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="fspid" id="fspid">
				<option value='' selected >----</option>
				{foreach $project as $value}
				    <option value='{$value->id}'>{$value->name}</option>
				{/foreach}
			</select>
			<span class="star_require">(* {$lang.controller.labelchooseprojectfirst})</span>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="frole">{$lang.controller.labelRole}<span class="star_require">*</span></label>
		<div class="controls">
			<select name="frole" id="frole">
				<option value='' selected >----</option>
				{foreach $listRole as $key => $value}
				    <option value='{$key}'>{$value}</option>
				{/foreach}
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