<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/index/ssid/{$projectId}">ScrumStoryAsignee</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_scrumstoryasignee"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$smarty.session.backaction}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.scrumstoryasigneeAddToken}" />


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
		<label class="control-label" for="frole">{$lang.controller.labelUid}<span class="star_require">*</span></label>
		<div class="controls">
            <select name="fuid" id="fuid" class="autocompletestaff">

            </select>
        </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftype" id="ftype" value="{$formData.ftype|@htmlspecialchars}" class="input-mini"></div>
	</div>
	
	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


