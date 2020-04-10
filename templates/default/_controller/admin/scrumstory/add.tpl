<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/siid/{$sprintid}">ScrumStory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrumstory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group" id="divspid">
        <label class="control-label" for="fspid">{$lang.controller.labelSpid} <span class="star_require">*</span></label>
        <div class="controls">
            <select name="fspid" id="fspid" >
                <option value="">----</option>
                {if $listProject|@count > 0}
                {foreach from=$listProject item=project} 
                {if $project->id==1 && $formData.fspid==''}
                <option value="{$project->id}" {if 1 == {$formData.fspid} OR {$formData.fspid eq ''}}selected="selected"{/if}>{$project->name}</option>
                {else}
                <option value="{$project->id}" {if $project->id == {$formData.fspid}}selected="selected"{/if}>{$project->name}</option>
                {/if}
                {/foreach}
                {/if}
            </select>
        </div>
    </div>



	<div class="control-group">
		<label class="control-label" for="fasa">{$lang.controller.labelAsa} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fasa" id="fasa" value="{$formData.fasa|@htmlspecialchars}"></div>
	</div>

	<div class="control-group">
        <label class="control-label" for="fiwant">{$lang.controller.labelIwant} <span class="star_require">*</span></label>
        <div class="controls"><textarea name="fiwant" id="fiwant" rows="7" class="input-xxlarge">{$formData.fiwant}</textarea></div>
    </div>
    <div class="control-group">
		<label class="control-label" for="fsothat">{$lang.controller.labelSothat} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fsothat" id="fsothat" rows="7" class="input-xxlarge">{$formData.fiwant}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftag">{$lang.controller.labelTag}<span class="star_require">*</span></label>
		<div class="controls"><textarea name="ftag" id="ftag" rows="7" class="input-xxlarge">{$formData.ftag}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpoint">{$lang.controller.labelPoint}</label>
		<div class="controls"><input type="text" name="fpoint" id="fpoint" value="{$formData.fpoint|@htmlspecialchars}" class="input-mini"></div>
	</div>

    <div class="control-group">
        <label class="control-label" for="fdatecompleted">{$lang.controller.labelDatecompleted}<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" class='inputdatepicker' name="fdatecompleted" id="fdatecompleted" value="{$formData.fdatecompleted|@htmlspecialchars}" ></div>
    </div>
    
	<div class="control-group">
		<label class="control-label" for="fcategoryid">{$lang.controller.labelCategoryid}</label>
		<div class="controls">
            <select name="fcategoryid" id="fcategoryid" >
                <option value="0">----</option>                
                {if $listStoryCategory|@count > 0}
                {foreach from=$listStoryCategory item=storycate}                
                <option value="{$storycate->id}" {if $storycate->id == {$formData.fcategoryid}}selected="selected"{/if}>{$storycate->name}</option>
                {/foreach}
                {/if}
            </select>
        </div>
	</div>
    <div class="control-group">
        <label class="control-label" for="fsssid">Scrum session<span class="star_require">*</span></label>
        <div class="controls">
            <select name="fsssid" id="fsssid">
                <option value=''>----</option>
                {foreach $scrumsession as $value}
                    <option value='{$value->id}'>{$value->name}</option>
                {/foreach}
            </select>
        </div>
    </div>
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls">
            <select name="fstatus" id="fstatus" >
                {if $listStatus|@count > 0}
                {foreach from=$listStatus item=statusname key=statusid}                
                {if $statusid == 1 && $formData.fstatus eq ''}
                <option value="{$statusid}" selected="selected">{$statusname}</option>
                {else}
                <option value="{$statusid}" {if $statusid == {$formData.fstatus}}selected="selected"{/if}>{$statusname}</option>
                {/if}
                {/foreach}
                {/if}
            </select>
        </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fpriority">{$lang.controller.labelPriority}</label>
		<div class="controls">
            <select name="fpriority" id="fpriority" >
                <option value="0">----</option>                
                {if $priorityList|@count > 0}
                {foreach from=$priorityList item=priorityname key=priorityid}                
                <option value="{$priorityid}" {if $priorityid == {$formData.fpriority}}selected="selected"{/if}>{$priorityname}</option>
                {/foreach}
                {/if}
            </select>
        </div>
	</div>
    <div class="control-group">
        <label class="control-label" for="flevel">Level</label>
        <div class="controls">
            <select name="flevel" id="flevel" >
                <option value="0">----</option>
                {if $level|@count > 0}
                    {foreach $level as $k=>$v}
                        <option value="{$k}" >{$v}</option>
                    {/foreach}
                {/if}
            </select>
        </div>
    </div>
	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
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
        var url = '/admin/scrumstory/indexAjax/pid/'+pid; 
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
