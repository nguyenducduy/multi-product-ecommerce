
<ul class="breadcrumb">
	<li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
	<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Newscategory</a> <span class="divider">/</span></li>
	<li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_newscategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.newscategoryAddToken}" />


	{include file="notify.tpl" notifyError=$error notifySuccess=$success}


    <div class="control-group">
        <label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
        <div class="controls">
            <select name="fparentid">
                <option value="">---------------------------------</option>
                {foreach from=$newscategoryList item=category}
					<option value="{$category->id}">{$category->name}</option>
				{/foreach}
            </select>
        </div>
    </div>

	<div class="control-group">
		<label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
		<div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
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
		<label class="control-label" for="fsummary">{$lang.controller.labelSummary}</label>
		<div class="controls"><textarea name="fsummary" id="fsummary" rows="7" class="input-xxlarge">{$formData.fsummary}</textarea></div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseotitle">{$lang.controller.labelSeotitle}</label>
		<div class="controls"><input type="text" name="fseotitle" id="fseotitle" value="{$formData.fseotitle|@htmlspecialchars}" class="input-xlarge">
        Còn lại <span id="seotitlecounter">50</span> ký tự</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseokeyword">{$lang.controller.labelSeokeyword}</label>
		<div class="controls"><textarea name="fseokeyword" id="fseokeyword" rows="7" class="input-xxlarge">{$formData.fseokeyword}</textarea>
        </div>
	</div>

	<div class="control-group">
		<label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription} <span class="star_require">*</span></label>
		<div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="input-xxlarge">{$formData.fseodescription}</textarea>
        Còn lại <span id="seodescriptioncounter">160</span> ký tự</div>
	</div>

	<div class="control-group">
        <label class="control-label" for="fmetarobot">{$lang.controller.labelMetaRobot}</label>
        <div class="controls"><input type="text" name="fmetarobot" id="fmetarobot" value="{$formData.fmetarobot|@htmlspecialchars}" class="input-xxlarge"></div>
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
		<label class="control-label" for="fpcid">Danh mục sản phẩm</label>
		<div class="controls">
            <select id="fpcid" name="fpcid[]" style="width: 200px;" multiple="multiple">
            	<option value="0">-----------</option>
            	{foreach item=productcategory from=$productcategorylist}
            	<option {if is_array($formData.fpcid)}{if in_array($productcategory->id , $formData.fpcid)}selected="selected"{/if}{/if} value="{$productcategory->id}">{$productcategory->name}</option>
            	{/foreach}
            </select>
        </div>
	</div>

    <!-- <div class="control-group">
        <label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
        <div class="controls"><input type="file" name="fimage" id="fimage"></div>
    </div> dienmay.com khong co hinh cho moi~ category nen bo field nay-->

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

            $("#fpcid").select2();
        });

</script>
{/literal}
