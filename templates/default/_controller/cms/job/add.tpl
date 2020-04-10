<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Tuyển dụng</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_job"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.jobAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}


	<div class="control-group">
		<label class="control-label" for="fparentid">Danh mục <span class="star_require">*</span></label>
		<div class="controls">
			<select name="fjcid">
				<option> ----------------------------------- </option>
				{foreach item=mycat from=$myJobcategory}
					<option value="{$mycat->id}"{if $mycat->id == $formData.fjcid}selected="selected"{/if}>{$mycat->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
		<div class="controls"><input type="file" name="fimage" id="fimage" ></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls">
			<textarea name="fcontent" id="fcontent" rows="25" class="input-xxlarge">{$formData.fcontent}</textarea>
			{include file="tinymce.tpl"}
		</div>
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
		<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseokeyword}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
		<div class="controls">
			<textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea>
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
