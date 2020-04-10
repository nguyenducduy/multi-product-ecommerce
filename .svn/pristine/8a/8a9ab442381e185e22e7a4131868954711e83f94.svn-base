<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Danh mục sản phẩm</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_edit}</li>
</ul>

<a class="btn btn-warning pull-right tipsy-trigger" href="{$conf.rooturl}{$controllerGroup}/{$controller}/attributevalueupdate/id/{$formData.fid}" title="Để chỉnh sửa và đồng nhất các giá trị thuộc tính">Cập nhật giá trị thuộc tính hàng loạt</a>
<br/>
<br/>
<a class="btn btn-warning pull-right tipsy-trigger" href="{$conf.rooturl}{$controllerGroup}/{$controller}/changenewproductcategory/id/{$formData.fid}" title="Để chuyển sản phẩm qua danh mục mới">Chuyển sản phẩm vào danh mục mới</a>
<br/>
<br/>
<a class="btn btn-warning pull-right tipsy-trigger" href="{$conf.rooturl}{$controllerGroup}/{$controller}/exportproductinfoofcategory?pcid={$formData.fid}" title="Xem thống kê sản phẩm trong danh mục">Xem thống kê sản phẩm trong danh mục</a>

<div class="page-header" rel="menu_productcategory"><h1>{$lang.controller.head_edit}</h1></div>

<div class="navgoback"><a href="{$redirectUrl}">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
<input type="hidden" name="ftoken" value="{$smarty.session.productcategoryEditToken}" />


    {include file="notify.tpl" notifyError=$error notifySuccess=$success}



    <div class="control-group">
        <label class="control-label" for="fimage">{$lang.controller.labelImage}</label>
        <div class="controls">{if $formData.fimageurl != ''}<image src="{$formData.fimageurl}" width="80" />{/if}
            <input type="file" name="fimage" /></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
        <div class="controls"><input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>


    <div class="control-group">
        <label class="control-label" for="fdisplaytext">Tên hiển thị<span class="star_require">*</span></label>
        <div class="controls"><input type="text" name="fdisplaytext" id="fdisplaytext" value="{$formData.fdisplaytext|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>


    <div class="control-group">
        <label class="control-label" for="fslug">{$lang.controller.labelSlugText}</label>
        <div class="controls"><input type="text" name="fslug" id="fslug" value="{$formData.fslug|@htmlspecialchars}" {if !$me->isGroup('adminstrator') && !$me->isGroup('developer')}readonly="readonly"{/if} class="input-xxlarge">
            {if $me->isGroup('adminstrator') || $me->isGroup('developer')}
            {if $slugList|@count > 0}
                <div class="">Found item for slug "{$formData.fslug}":</div>
                {foreach item=slug from=$slugList}
                    {if $slug->controller != 'productcategory' || $slug->objectid != $formData.fid}<div class="red">&raquo; {$slug->controller} / {$slug->objectid} <a href="{$slug->getSlugSearch()}" title="Go to this slug" class="tipsy-trigger"><i class="icon-share"></i></a></div>{/if}
                {/foreach}
            {/if}
            Còn lại <span id="slugcounter">50</span> ký tự
            {/if}
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
        <label class="control-label" for="fseodescription">{$lang.controller.labelSeodescription}</label>
        <div class="controls"><textarea name="fseodescription" id="fseodescription" rows="7" class="mceNoEditor input-xxlarge">{$formData.fseodescription}</textarea></div>
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
        <div class="controls"><textarea name="fdesccol1" id="fdesccol1" rows="7" class="input-xxlarge">{$formData.fdesccol1}</textarea>Còn lại <span id="fdesccol1count">200</span> ký tự</div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol2">Title col2</label>
        <div class="controls"><input type="text" name="ftitlecol2" id="ftitlecol2" value="{$formData.ftitlecol2|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol2">Desc col2</label>
        <div class="controls"><textarea name="fdesccol2" id="fdesccol2" rows="7" class="input-xxlarge">{$formData.fdesccol2}</textarea>Còn lại <span id="fdesccol2count">200</span> ký tự</div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ftitlecol2">Title col3</label>
        <div class="controls"><input type="text" name="ftitlecol3" id="ftitlecol3" value="{$formData.ftitlecol3|@htmlspecialchars}" class="input-xxlarge"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdesccol3">Desc col3</label>
        <div class="controls"><textarea name="fdesccol3" id="fdesccol3" rows="7" class="input-xxlarge">{$formData.fdesccol3}</textarea>Còn lại <span id="fdesccol3count">200</span> ký tự</div>
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
        <label class="control-label" for="fparentid">{$lang.controller.labelParentid}</label>
        <div class="controls"><select name="fparentid" id="fparentid" style="width:200px;">
                <option value="0">------</option>
                {foreach from=$productcategoryList item=category}
                    <option value="{$category->id}" {if $category->id == $formData.fparentid}selected="selected"{/if}>{section name=foo start=1 loop=$category->level step=1}&nbsp;&nbsp;{/section}{$category->name}</option>
                {/foreach}
            </select></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fdisplayorder">{$lang.controller.labelDisplayorder}</label>
        <div class="controls"><input type="text" name="fdisplayorder" id="fdisplayorder" value="{$formData.fdisplayorder|@htmlspecialchars}" class="input-mini"></div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fproducthomepagelist">Danh sách sản phẩm hiển thị trang chủ</label>                
        <div class="controls">
            {if $producthomepagelist|@count > 0}
            <table style="background-color: #dcdcdc;width:60%">
                <thead>
                    <tr>
                        <th>TT hiển thị</th>
                        <th>ID</td>
                        <th>Tên sản phẩm</th>
                        <th>Sản phẩm thay thế</th>
                    </tr>
                </thead>
            {foreach item=product from=$producthomepagelist name=foo}            
                {if $smarty.foreach.foo.index < 12}
                <tr id="producth{$product->id}">
                    <td><input class="input-mini" type="text" name="fhomedisplay[{$product->id}]" value="{$smarty.foreach.foo.index+1}" /></td>
                    <td>{$product->id}</td>
                    <td><span class="label label-success">{$product->name}</span></td>
                    <td><select placeholder="Tìm sản phẩm" name="productreplace[{$product->id}]" id="productreplace{$product->id}" class="autocompleteproduct"></select></td>
                    <td><input type="button" class="btn btn-mini btn-danger deleteproduct" value="Xóa" id="{$product->id}" /></td>
                </tr>            
                {/if}
            {/foreach}
            {if $producthomepagelist|@count < 12}           
            {section name=foo start=0 loop=$numberproductenough step=1}
                <tr>
                    <td><input class="input-mini" type="text" name="fhomedisplaynew[{$smarty.section.foo.index}]" value="" /></td>
                    <td></td>
                    <td><span class="label label-success"></span></td>
                    <td><select placeholder="Tìm sản phẩm" name="productreplacenew[{$smarty.section.foo.index}]" id="productreplacenew{$smarty.section.foo.index}" class="autocompleteproduct"></select></td>
                    <td></td>
                </tr>  
            {/section}
            {/if}
            </table>
            {else}
            <select placeholder="Tìm sản phẩm" name="fproducthomepagelist[]" id="fproducthomepagelist" class="autocompleteproduct"></select>
            {/if}
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="fproducttopitemlist">Top sản phẩm bán chạy</label>
        <div class="controls">
            <select placeholder="Tìm sản phẩm" name="fproducttopitemlist[]" id="fproducttopitemlist" class="autocompleteproduct"></select>
            <table class="table table-striped">
                <tr>
                    <th>Id</th>
                    <th>Tên sản phẩm</th>
                    <th></th>
                </tr>
                {foreach item=product from=$producttopitemlist}
                <tr id="top{$product->id}">
                    <td>{$product->id}</td>
                    <td><input type="hidden" name="fdefaulttopitemlist[]" value="{$product->id}"/>{$product->name}</td>
                    <td><input type="button" class="btn btn-danger deltopitem" id="{$product->id}" value="Xóa"/></td>
                </tr>
                {/foreach}
            </table>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="fitemdisplayorder">{$lang.controller.labelItemdisplayorder}</label>
        <div class="controls">
            <select name="fitemdisplayorder" id="fitemdisplayorder">
                {html_options options=$itemdisplayorderList selected=$formData.fitemdisplayorder}
            </select>

            <a target="_blank" title="{$lang.controller.labelPriceSegment}" href="{$conf.rooturl_cms}{$controller}/pricesegment/id/{$formData.fid}/redirect/{$redirectUrl}" class="btn btn-mini tipsy-trigger">Cập nhật phân khúc giá</a>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label" for="fcategoryreference">Danh mục liên quan</label>
        <div class="controls">
            <textarea id="fcategoryreference" name="fcategoryreference" class="mceNoEditor input-xxlarge">{$formData.fcategoryreference}</textarea>
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
    <div class="control-group">
        <div class="controls">
            <a href="javascript:void(0)" onclick="updatepromotionforproductcategory('{$formData.fid|trim}')" id="buttonupdatepromotion" class="btn btn-large btn-primary btn-warning">Cập nhật khuyến mãi</a>
        </div>
    </div>
<div class="form-actions">
    <input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
    <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
</div>

</form>
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#fslug').limit(50 , '#slugcounter');
        $('#fseotitle').limit(70 , '#seotitlecounter');
        $('#fseodescription').limit(160 , '#seodescriptioncounter');
        $('#fdesccol1').limit(200 , '#fdesccol1count');
        $('#fdesccol2').limit(200 , '#fdesccol2count');
        $('#fdesccol3').limit(200 , '#fdesccol3count');
        $('#ftopseokeyword').limit(255, '#ftopseokeywordcounter');
        $('#fparentid').select2();
        
        $(".deltopitem").click(function(){
            var id = $(this).attr('id');
            if ($("#"+id).length > 0) {
                $("#top"+id).remove();
            }
        });

        $(".deleteproduct").click(function(){
            var id = $(this).attr('id');
            if($("#"+id).length > 0){
                $("#producth" +id).remove();
            }
        });
    });
    function updatepromotionforproductcategory(fpcid)
    {
        if(fpcid.length > 0)
        {
            var path = rooturl + controllerGroup + "/productcategory/updatepromotionajax";
            path += '/fpcid/' + fpcid;
            $("#buttonupdatepromotion").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
            $("#buttonupdatepromotion").hide();
            $.post(path,{}, function(data){
                if(data && data.success==1)
                {
                    showGritterSuccess('Khuyến mãi đã được cập nhật.');
                }
                else
                    showGritterError('Khuyến mãi đã có hoặc lỗi trong quá trình đồng bộ.');
                $("img.tmp_indicator").remove();
                $("#buttonupdatepromotion").show();
            }, 'json');
        }
        else
            showGritterError('Không có mã danh mục để đồng bộ');
    }
</script>
{/literal}

