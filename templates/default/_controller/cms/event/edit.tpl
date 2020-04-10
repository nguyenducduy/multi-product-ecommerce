<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Event</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="event-header" rel="menu_event"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.eventEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	
	
	<div class="control-group">
		<label class="control-label" for="fthemeid">Theme</label>
		<div class="controls">
			<select id="fthemeid" name="fthemeid">
					<option value="0">- - - Default - - -</option>
				{foreach item=theme from=$themeList}
					<option value="{$theme->id}" {if $theme->id == $formData.fthemeid}selected="selected"{/if}>{$theme->name}</option>
				{/foreach}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ftitle">{$lang.controller.labelTitle} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="ftitle" id="ftitle" value="{$formData.ftitle|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fslug">{$lang.controller.labelSlug}</label>
		<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge">
			{if $slugList|@count > 0}
				<div class="">Found item for slug "{$formData.fslug}":</div>
				{foreach item=slug from=$slugList}
					{if $slug->controller != 'page' || $slug->objectid != $formData.fid}<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>{/if}
				{/foreach}
			{/if}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fcontent" id="fcontent" rows="25" class="mceNoEditor input-xxlarge">{$formData.fcontent}</textarea></div>
		{include file="tinymce.tpl"}
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fproductstyle">Product style</label>
		<div class="controls">
			<textarea name="fproductstyle" id="fproductstyle" rows="25" class="mceNoEditor input-xxlarge">{$formData.fproductstyle}</textarea>
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
		<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle|@htmlspecialchars}" class="input-xxlarge">
        Còn lại <span id="seotitlecounter">50</span> ký tự</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
		<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseokeyword}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
		<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea>
        Còn lại <span id="seodescriptioncounter">160</span> ký tự</div>
	</div>

	<div class="control-group">
        <label class="control-label" for="fmetarobot">{$lang.controller.labelMetaRobot}</label>
        <div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="{$formData.fmetarobot|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
		<label class="control-label" for="fseodescription">Keyword</label>
		<div class="controls"><input name="fkeyword" id="tags_keyword" type="text" class="tags" value="{$formData.fkeyword}" /></p></div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
		<div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class=" input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
	</div>
	
	  <div class="control-group">
        <label class="control-label" for="ffooterkey">Footer Key</label>
        <div class="controls"><textarea name="ffooterkey" id="ffooterkey" rows="7" class=" input-xxlarge">{$formData.ffooterkey}</textarea></div>
    </div>
	
	<div class="control-group">
		<label class="control-label" for="fiscounter">Is Counter</label>
		<div class="controls">
			<select name="fiscounter" id="fiscounter">
				<option value="1" {if $formData.fiscounter == 1}selected="selected"{/if}>Yes</option>
				<option value="0" {if $formData.fiscounter == 0}selected="selected"{/if}>No</option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
        <label class="control-label" for="fstarttime">Ngày bắt đầu</label>
        <div class="controls"><input class='inputdatepicker' type="text" name="fstarttime" id="fstarttime" value="{if $formData.fstarttime > 0}{$formData.fstarttime|@htmlspecialchars}{/if}" ></div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="fendtime">Ngày kết thúc</label>
        <div class="controls"><input class='inputdatepicker' type="text" name="fendtime" id="fendtime" value="{if $formData.fendtime > 0}{$formData.fendtime|@htmlspecialchars}{/if}" ></div>
    </div>
	
	
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus} <span class="star_require">*</span></label>
		<div class="controls">
            <select name="fstatus" id="fstatus">
                {html_options options=$statusList selected=$formData.fstatus}
            </select>
        </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fblank">Blank</label>
		<div class="controls">
			<select name="fblank" id="fblank">
				<option value="1" {if $formData.fblank == 1}selected="selected"{/if}>Yes</option>
				<option value="0" {if $formData.fblank == 0}selected="selected"{/if}>No</option>
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
	
		$(function() {
			$('#tags_keyword').tagsInput({width:'532px'});
            $('#fseotitle').limit(50, '#seotitlecounter');
            $('#fseodescription').limit(160, '#seodescriptioncounter');
		});
	
</script>
{/literal}