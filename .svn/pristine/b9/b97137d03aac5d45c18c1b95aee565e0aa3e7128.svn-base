<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Discount Product</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add_promotion}</li>
</ul>

<div class="page-header" rel="menu_eventproducthours"><h1>{$lang.controller.head_add_promotion}</h1></div>

<div class="navgoback"><a href="{$registry->conf.rooturl_cms}eventproducthours/index/tab/2">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="ftoken" value="{$smarty.session.discountAddToken}" />

    {include file="notify.tpl" notifyError=$error notifySuccess=$success}
    {include file="tinymce.tpl"}

    <div class="control-group">
        <label class="control-label" for="fvid">Tên giảm giá<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fdiscountname" value = "{$formData.fdiscountname}"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fvid">Thứ tự hiển thị</label>
        <div class="controls">
            <input type="text" name="fdisplayorder" value = "{$formData.fdisplayorder}"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fvid">Status</label>
        <div class="controls">
            <select name="fstatus">
                <option value="1" {if $formData.fstatus == 1 && isset($formData.fstatus)}selected='selected'{/if}}>Enable</option>
                <option value="0" {if $formData.fstatus == 0 && isset($formData.fstatus)}selected='selected'{/if}}>Disable</option>              
            </select>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>

</form>


