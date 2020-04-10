<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/spid/{$projectId}">ScrumStoryCategory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrumstorycategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumstorycategoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	

	<div class="control-group">
		<label class="control-label" for="fspid">{$lang.controller.labelSpid}</label>
		<div class="controls">
            <select name="fspid" id="fspid" >
                <option value="0">----</option>                
                {if $projectsList|@count > 0}
                {foreach from=$projectsList item=project}                
                <option value="{$project->id}" {if $project->id == {$formData.fspid}}selected="selected"{/if}>{$project->name}</option>
                {/foreach}
                {/if}
            </select>
            
            <!--<input type="text" name="fspid" id="fspid" value="{$formData.fspid|@htmlspecialchars}" class="input-mini">-->
            </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


