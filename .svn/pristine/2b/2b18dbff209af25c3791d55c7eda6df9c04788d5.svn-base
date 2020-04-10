<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Thương hiệu ngành hàng</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_brandcategory"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="ftoken" value="{$smarty.session.brandCategoryAddToken}" />


    {include file="notify.tpl" notifyError=$error notifySuccess=$success}
    {include file="tinymce.tpl"}

    <div class="control-group">
        <label class="control-label" for="fpcid">{$lang.controller.labelCategory} <span class="star_require">*</span></label>
        <div class="controls">

            <select name="fpcid" id="fpcid"  style="width:200px;">
                {foreach from=$category item=cat}
                {if $cat->parentid==0}
                </optgroup><optgroup label="{$cat->name}">
                    {else}
                    <option value="{$cat->id}" {if $cat->id == $formData.fpcid}selected="selected"{/if}>{$cat->name}</option>
                    {/if}
                    {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fvid">{$lang.controller.labelVendor}<span class="star_require">*</span></label>
        <div class="controls">
            <select name="fvid" id="fvid" style="width:200px;">
                {foreach  key=vid item=vdor from=$vendor}
                </optgroup><optgroup label="{$vid}">
                    {foreach from = $vdor item =vd}
                        <option value="{$vd->id}" {if $vd->id == $formData.fvid}selected="selected"{/if}>{$vd->name}</option>
                    {/foreach}
                    {/foreach}
            </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fname">{$lang.controller.labelName}<span class="star_require">*</span></label>
        <div class="controls"><input type="text" name="fname" id="fname" class="input-xxlarge" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
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
    <!-- Column new -->

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
        <div class="controls"><textarea name="fdesccol2" id="fdesccol2" rows="7" class=" input-xxlarge">{$formData.fdesccol2}</textarea></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol2">Title col3</label>
        <div class="controls"><input type="text" name="ftitlecol3" id="ftitlecol3" value="{$formData.ftitlecol3|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol3">Desc col3</label>
        <div class="controls"><textarea name="fdesccol3" id="fdesccol3" rows="7" class="input-xxlarge">{$formData.fdesccol3}</textarea></div>
    </div>
    <!-- End Column new -->

    <div class="control-group">
        <label class="control-label" for="ftopseokeyword">Top SEO keyword</label>
        <div class="controls"><textarea name="ftopseokeyword" id="ftopseokeyword" rows="7" class=" input-xxlarge">{$formData.ftopseokeyword}</textarea>Còn lại <span id="ftopseokeywordcounter">255</span> ký tự</div>
    </div>


    <div class="control-group">
        <label class="control-label" for="ffooterkey">Footer Key</label>
        <div class="controls"><textarea name="ffooterkey" id="ffooterkey" rows="7" class=" input-xxlarge">{$formData.ffooterkey}</textarea></div>
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
        <input type="submit" name="fsubmit" value="{$lang.default.formEditLabel}" class="btn btn-large btn-primary" />
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>

</form>

{literal}
    <script type="text/javascript">
        $(document).ready(function(){
            $('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
            $('#fseotitle').limit(70 , '#seotitlecounter');
            $('#fseodescription').limit(160 , '#seodescriptioncounter');
            $('#fdesccol1').limit(200 , '#fdesccol1couner');
            $('#fdesccol2').limit(200 , '#fdesccol2counter');
            $('#fdesccol3').limit(200 , '#fdesccol3counter');
            $("#fpcid").select2();
            $("#fvid").select2();
        });
    </script>
{/literal}

