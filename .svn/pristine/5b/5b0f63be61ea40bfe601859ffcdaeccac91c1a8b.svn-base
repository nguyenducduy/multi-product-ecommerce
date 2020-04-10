<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

<!-- Bootstrap Responsive Stylesheet -->
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

<!-- Customized Admin Stylesheet -->
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>



<!-- customized admin -->
<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
 <script type="text/javascript">
        var rooturl = "{$conf.rooturl}";
        var rooturl_admin = "{$conf.rooturl_admin}";
        var rooturl_cms = "{$conf.rooturl_cms}";
        var rooturl_crm = "{$conf.rooturl_crm}";
        var rooturl_erp = "{$conf.rooturl_erp}";
        var rooturl_profile = "{$conf.rooturl_profile}";
        var controllerGroup = "{$controllerGroup}";
        var currentTemplate = "{$currentTemplate}";

        var websocketurl = "{$setting.site.websocketurl}";
        var websocketenable = {$setting.site.websocketenable};

        var delConfirm = "Are You Sure?";
        var delPromptYes = "Type YES to continue";


        var imageDir = "{$imageDir}";
        var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
        var gritterDelay = 3000;
        var meid = {$me->id};
        var meurl = "{$me->getUserPath()}";
        var userid = {$myUser->id};
        var userurl = "{$myUser->getUserPath()}";
</script>

<form id="myform" method="post" class="form-horizontal" action="" style="margin-top:-36px;">
        {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}

       {if $formData.fpciddes > 0 && $productcategory->id != $formData.fpciddes}
       <h1>Thay đổi danh mục</h1>
       <table style="display:inline;width:40%">
            {foreach item=attrsource from=$attributesource}
            <tr>
                <td>{$attrsource->name}</td>
                <td><input type="text" readonly="readonly" value="{$attrsource->value->value}" style="height:25px;" class="input-large"/></td>
                <td><input type="text" readonly="readonly" value="{$attrsource->value->weight}" style="height:25px;" class="input-mini"/></td>
            </tr>
            {/foreach}
       </table>
       <table style="display:inline-block;width:40%;">
            <input type="hidden" name="fpciddes" value="{$formData.fpciddes}" />
            <input type="hidden" name="fpid" value="{$formData.fpid}" />
            {foreach item=attrdes from=$attributedes}
            <tr>
                <td>{$attrdes->name}</td>
                <td><input type="text" value="{$attrdes->value->value}" style="height:25px;" class="input-large" name="fattrdesvalue[{$attrdes->id}]"/></td>
                <td><input type="text" value="{$attrdes->value->weight}" style="height:25px;" class="input-mini" name="fattrdesweight[{$attrdes->id}]"/></td>
            </tr>
            {/foreach}
       </table>
       {if $formData.done != 1}
       <div class="form-actions">
            <input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />
            <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
        </div>
       {/if}
       {else}
       <h1>Vui lòng chọn danh mục sản phẩm  di chuyển đến</h1>
        <div class="control-group">
            <label class="control-label" for="fpcid">Danh mục hiện tại</label>
            <div class="controls">
                <b>{$productcategory->name}</b>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="fpciddes">Danh mục chuyển đến</label>
            <div class="controls">
                <select name="fpciddes" id="fpciddes"  style="width:200px;">
                    <option value-"0">----------</option>
                {foreach from=$productcategoryList item=productCategory}
                    <option {if $formData.fpciddes == $productCategory->id}selected="selected"{/if} value="{$productCategory->id}">{$productCategory->name}</option>
                {/foreach}
                </select>
            </div>
        </div>
        <div class="form-actions">
            <input type="submit" name="fsubmitNext" value="{$lang.controller.labelNext}" class="btn btn-large btn-primary" />
            <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
        </div>

       {/if}
</form>
{literal}
<script type="text/javascript">
    Shadowbox.init({
        onClose: function(){ window.location.reload(); }
    });
       $(document).ready(function(){
            $("#fpciddes").select2();
       });
</script>
{/literal}
