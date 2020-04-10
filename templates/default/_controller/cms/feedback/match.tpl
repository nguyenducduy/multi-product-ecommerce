

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
        <label class="control-label" for="fspid">{$lang.controller.labelSproject} <span class="star_require">*</span></label>
        <div class="controls">
            <select name="fspid" id="fspid" >
                {if $listProject|@count > 0}
                {foreach from=$listProject item=project} 
                <option value="{$project->id}">{$project->name}</option>
                {/foreach}
                {/if}
            </select>
        </div>
    </div>

  
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


