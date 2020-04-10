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

<div class="page-header"><h1 style="display:inline;">{$head_list}</h1><span style="margin-left:42px;">{$lang.controller.datesync}&nbsp;:&nbsp;{$datesync|date_format:"%d/%m/%Y"}</span></div>
{if $pbarcodedestination != ""}
<a href="{$conf.rooturl_admin}productstock/index/pbarcode/{$pbarcodedestination}/">Quay lại trang trước</a>
{/if}
<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Hàng tồn</a></li>
        {if $pbarcodedestination == ""}<li><a href="#tab2" data-toggle="tab">Màu sản phẩm</a></li>{/if}
        <li class="pull-right"><a id="syncstock" class="btn btn-success" href="javascript:void(0)" onclick="syncStock('{$myProduct->barcode}',{$myProduct->id})">Cập nhật tồn kho</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
        {include file="notify.tpl" notifyError=$error notifySuccess=$success}
        {if $productStockListHtml|@count > 0}
        <table class="table table-striped" style="font-size:12px;">
        	<thead>
        		<tr>
        			<th>{$lang.controller.labelStoreName}</th>
        			<th><a href="{$conf.rooturl_admin}productstock/index/pbarcode/{$myProduct->barcode}/sortby/quantity/sorttype/{if $formData.sortby eq 'quantity'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelQuantity}</a></th>
        		</tr>
        	</thead>
        	<tbody>
        		{foreach item=productStock from=$productStockListHtml}
        		<tr>
        			<td>{$productStock->storeActor->name}</td>
        			<td style="text-align:left"><span class="badge badge-info">{$productStock->quantity}</span></td>
        		</tr>
        		{/foreach}
        	</tbody>
        </table>
        {/if}
        </div><!--end of tab1-->
        {if $pbarcodedestination == ""}
        <div id="tab2" class="tab-pane">
            {if $productcolorlist|@count > 0}
            <table class="table table-striped" style="font-size:12px;">
                <thead>
                    <tr>
                        <td>Màu</td>
                        <td>Barcode</td>
                        <td>Giá</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    {foreach item=product from=$productcolorlist}
                    <tr>
                        <td><b>{$product.color}</b></td>
                        <td><span class="label">{$product.barcode}</span></td>
                        <td><span class="badge badge-info">{$product.price}</span></td>
                        <td><a href="{$conf.rooturl_admin}productstock/index/pbarcode/{$product.barcode}/pbarcodedestination/{$myProduct->barcode}">Xem chi tiết</a></td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            {/if}
        </div><!--end of tab2-->
        {/if}
    </div>
</div>
