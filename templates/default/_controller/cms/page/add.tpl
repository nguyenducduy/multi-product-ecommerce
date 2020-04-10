<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Page</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_page"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal">
<input type="hidden" name="ftoken" value="{$smarty.session.pageAddToken}" />


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
					<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>
				{/foreach}
			{/if}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls">
			<select id="texttype" name="fcontenttype">
				<option value="0" {if $formData.fcontenttype == 0}selected="selected"{/if}>Định dạng HTML</option>
				<option value="1" {if $formData.fcontenttype == 1}selected="selected"{/if}>Định dạng text</option>
			</select><br/><br/>
			<div id="htmldata">
				<textarea name="fcontenthtml" id="fcontenthtml" rows="25" class="input-xxlarge">{if $formData.fcontenttype == 0}{$formData.fcontent}{/if}</textarea>
				{include file="tinymce.tpl"}
			</div>
			<div id="textdata" style="display:none;">
				<textarea name="fcontenttext" id="fcontenttext" rows="25" class="mceNoEditor input-xxlarge">{if $formData.fcontenttype == 1}{$formData.fcontent}{/if}</textarea>
			</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
		<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle|@htmlspecialchars}" class="input-xxlarge">
        Còn lại <span id="seotitlecounter">50</span> ký tự
        </div>
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
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>	
	
</form>


{literal}
<script type="text/javascript">
	
		$(function() {
			$('#tags_keyword').tagsInput({width:'532px'});
            $('#fseotitle').limit(50, '#seotitlecounter');
            $('#fseodescription').limit(160, '#seodescriptioncounter');
			
			/////
			var texttype = $("#texttype").val();
			if(texttype == 0){
				$("#htmldata").show();
				$("#textdata").hide();		
			}else{
				$("#htmldata").hide();					
				$("#textdata").show();
			}
			
			$("#texttype").live('change' , function(){
				type = $(this).val();
				if (type === '0') {
					$("#htmldata").show();
					$("#textdata").hide();					
				} else if (type === '1') {					
					$("#htmldata").hide();					
					$("#textdata").show();
				}
			});
		});
	
</script>
{/literal}
