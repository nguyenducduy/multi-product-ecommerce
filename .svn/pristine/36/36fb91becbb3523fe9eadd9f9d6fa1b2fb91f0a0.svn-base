<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục tuyển dụng</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_jobcategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.jobcategoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
		<div class="controls">
			<select name="fparentid">
				<option value="0"> ----------------------------------- </option>
				{foreach item=mycat from=$myJobcategory}
					<option value="{$mycat->id}" {if $mycat->id == $formData.fparentid}selected="selected"{/if}>{if $mycat->level > 1} &nbsp; &nbsp; {/if}{$mycat->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="input-xxlarge">{$formData.fsummary}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
		<div class="controls">
			<input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle|@htmlspecialchars}" class="input-xxlarge">
			Còn lại <span id="seotitlecounter">50</span> ký tự
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
		<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="input-xxlarge">{$formData.fseokeyword}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
		<div class="controls">
			<textarea name="fseodescription" id="fseodescription" rows="7" class="input-xxlarge">{$formData.fseodescription}</textarea>
			Còn lại <span id="seodescriptioncounter">160</span> ký tự
		</div>
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

        $(function() {
            $('#fseotitle').limit(50, '#seotitlecounter');
            $('#fseodescription').limit(160, '#seodescriptioncounter');
        });

</script>
{/literal}
