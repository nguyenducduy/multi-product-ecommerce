<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Đối tác</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_edit}</li>
</ul>

<div class="page-header" rel="menu_vendor"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.vendorEditToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
    {include file="tinymce.tpl"}


	<div class="control-group">
		<label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
		<div class="controls">
			{if $formData.fimageurl != ''}<image src="{$formData.fimageurl}" width="80" />{else}{if $formData.fimage != ''}<image src="{$registry->conf['rooturl']}uploads/vendor/{$formData.fimage}" width="80" />{/if}{/if}
			<input type="file" name="fimage" />(JPG, GIF, PNG)
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftype">{$lang.controller.labelType}</label>
		<div class="controls">
			<select name="ftype" id="ftype">
				{html_options options=$typeList selected=$formData.ftype}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fslug">{$lang.controller.labelSlug} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge">
			{if $slugList|@count > 0}
				<div class="">Found item for slug "{$formData.fslug}":</div>
				{foreach item=slug from=$slugList}
					{if $slug->controller != 'vendor' || $slug->objectid != $formData.fid}<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>{/if}
				{/foreach}
			{/if}
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fcontent">{$lang.controller.labelContent} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fcontent" id="fcontent" rows="7" class="input-xxlarge">{$formData.fcontent}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="finsurance">Mô tả xuất hiện ở trang detail</label>
		<div class="controls"><textarea name="finsurance" id="finsurance" rows="7" class="mceNoEditor input-xxlarge">{$formData.finsurance}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
		<div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
	</div>

	<div class="control-group">
        <label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
        <div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle|@htmlspecialchars}" class="input-xlarge">Còn lại <span id="seotitlecounter">70</span> ký tự</div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
        <div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseokeyword}</textarea>Còn lại <span id="seodescriptioncounter">160</span> ký tự</div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
        <div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea></div>
    </div>
	<!-- New -->
    <div class="control-group">
        <label class="control-label" for="fmetarobot">Metarobot</label>
        <div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="{$formData.fmetarobot|@htmlspecialchars}" class="input-xlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol1">Title col1</label>
        <div class="controls"><input type="text" name="ftitlecol1" id="ftitlecol1" value="{$formData.ftitlecol1|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol1">Desc col1</label>
        <div class="controls"><textarea name="fdesccol1" id="fdesccol1" rows="7" class="input-xxlarge">{$formData.fdesccol1}</textarea></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol2">Title col2</label>
        <div class="controls"><input type="text" name="ftitlecol2" id="ftitlecol2" value="{$formData.ftitlecol2|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol2">Desc col2</label>
        <div class="controls"><textarea name="fdesccol2" id="fdesccol2" rows="7" class="input-xxlarge">{$formData.fdesccol2}</textarea></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol2">Title col3</label>
        <div class="controls"><input type="text" name="ftitlecol3" id="ftitlecol3" value="{$formData.ftitlecol3|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol3">Desc col3</label>
        <div class="controls"><textarea name="fdesccol3" id="fdesccol3" rows="7" class="  input-xxlarge">{$formData.fdesccol3}</textarea></div>
    </div>
    <!-- End New -->
    <div class="control-group">
        <label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
        <div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class=" input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
    </div>
	<div class="control-group">
		<label class="control-label" for="fstatus">{$lang.controller.labelStatus}</label>
		<div class="controls"><select name="fstatus" id="fstatus">
				{html_options options=$statusList selected=$formData.fstatus}
			</select></div>
	</div>

	<div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
		<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
	</div>

</form>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
		$('#fseotitle').limit(70 , '#seotitlecounter');
        $('#fseodescription').limit(160 , '#seodescriptioncounter');
	});
</script>
{/literal}
