<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.productcategoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}



	<div class="control-group">
		<label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
		<div class="controls"><input type="file" name="fimage" id="fimage" value=""></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdisplaytext">{$lang.controller.labelDisplayname} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fdisplaytext" id="fdisplaytext" value="{$formData.fdisplaytext|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fslug">{$lang.controller.labelSlugText}</label>
		<div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" class="input-xxlarge">
			{if $slugList|@count > 0}
				<div class="">Found item for slug "{$formData.fslug}":</div>
				{foreach item=slug from=$slugList}
					<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>
				{/foreach}
			{/if}
			Còn lại <span id="slugcounter">50</span> ký tự
		</div>
	</div>


	<div class="control-group">
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="input-xxlarge">{$formData.fsummary}</textarea></div>
		{include file="tinymce.tpl"}
	</div>

	<div class="control-group">
		<label class="control-label" for="fblockhomepagehorizon">{$lang.controller.labelBlockHomepageHorizon}</label>
		<div class="controls"><textarea name="fblockhomepagehorizon" id="fblockhomepagehorizon" rows="7" class="input-xxlarge">{$formData.fblockhomepagehorizon}</textarea></div>
		{include file="tinymce.tpl"}
	</div>

	<div class="control-group">
		<label class="control-label" for="fblockhomepagevertical">{$lang.controller.labelBlockHomepageVertical}</label>
		<div class="controls"><textarea name="fblockhomepagevertical" id="fblockhomepagevertical" rows="7" class="input-xxlarge">{$formData.fblockhomepagevertical}</textarea></div>
		{include file="tinymce.tpl"}
	</div>

	<div class="control-group">
		<label class="control-label" for="fblockcategory">{$lang.controller.labelBlockCategory}</label>
		<div class="controls"><textarea name="fblockcategory" id="fblockcategory" rows="7" class="input-xxlarge">{$formData.fblockcategory}</textarea></div>
		{include file="tinymce.tpl"}
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
		<label class="control-label" for="fmetarobot">Metarobot</label>
		<div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="{$formData.fmetarobot|@htmlspecialchars}" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitlecol1">Title col1</label>
		<div class="controls"><input type="text" name="ftitlecol1" id="ftitlecol1" value="{$formData.ftitlecol1|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdesccol1">Desc col1</label>
		<div class="controls"><textarea name="fdesccol1" id="fdesccol1" rows="7" class="input-xxlarge">{$formData.fdesccol1}</textarea>Còn lại <span id="fdesccol1counter">200</span> ký tự</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitlecol2">Title col2</label>
		<div class="controls"><input type="text" name="ftitlecol2" id="ftitlecol2" value="{$formData.ftitlecol2|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdesccol2">Desc col2</label>
		<div class="controls"><textarea name="fdesccol2" id="fdesccol2" rows="7" class="input-xxlarge">{$formData.fdesccol2}</textarea>Còn lại <span id="fdesccol2counter">200</span> ký tự</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftitlecol2">Title col3</label>
		<div class="controls"><input type="text" name="ftitlecol3" id="ftitlecol3" value="{$formData.ftitlecol3|@htmlspecialchars}" class="input-xxlarge"></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fdesccol3">Desc col3</label>
		<div class="controls"><textarea name="fdesccol3" id="fdesccol3" rows="7" class="input-xxlarge">{$formData.fdesccol3}</textarea>Còn lại <span id="fdesccol3counter">200</span> ký tự</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
		<div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class="input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
	</div>

    <div class="control-group">
        <label class="control-label" for="ffooterkey">Footer Key</label>
        <div class="controls"><textarea name="ffooterkey" id="ffooterkey" rows="7" class=" input-xxlarge">{$formData.ffooterkey}</textarea></div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
		<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
		<div class="controls">
			<select name="fparentid" id="fparentid" style="width:200px;">
				{if $me->isGroup('administrator') || $me->isGroup('developer')}<option value="0">------</option> {/if}
				{foreach from=$productcategoryList item=category}
				<option value="{$category->id}" {if $category->id == $formData.fparentid}selected="selected"{/if}>{$category->name}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fitemdisplayorder">{$lang.controller.labelItemdisplayorder}</label>
		<div class="controls">
			<select name="fitemdisplayorder" id="fitemdisplayorder">
				{html_options options=$itemdisplayorderList selected=$formData.fitemdisplayorder}
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="fstatus">Danh mục liên quan</label>
		<div class="controls">
			<textarea id="fcategoryreference">{$formData.fcategoryreference}</textarea>
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

	<div class="control-group">
		<label class="control-label" for="fappendtoproductname">Append Category Name before Product Name (in Product Detail page)?</label>
		<div class="controls">
			<select name="fappendtoproductname">
				<option value="1" {if $formData.fappendtoproductname == '1'}selected="selected"{/if}>YES</option>
				<option value="0" {if $formData.fappendtoproductname == '0'}selected="selected"{/if}>NO</option>
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
	$(document).ready(function(){
		$('#fslug').limit(50 , '#slugcounter');
		$('#fseotitle').limit(70 , '#seotitlecounter');
		$('#fseodescription').limit(160 , '#seodescriptioncounter');
		$('#fdesccol1').limit(200 , '#fdesccol1couner');
		$('#fdesccol2').limit(200 , '#fdesccol2counter');
		$('#fdesccol3').limit(200 , '#fdesccol3counter');
		$('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
		$('#fparentid').select2();
	});
</script>
{/literal}

