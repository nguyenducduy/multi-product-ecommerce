<title>Danh sách combo trong khuyến mãi</title>
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

        <!-- Bootstrap Responsive Stylesheet -->
        <link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

        <!-- Customized Admin Stylesheet -->
        <link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
        <link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />


        <!-- jQuery -->
        <script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

        <!-- Bootstrap Js -->
        <script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>
        
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<div class="page-header"><h1>{$head_list}</h1></div>
<div class="page-content">
    <h2>Danh sách combo khuyến mãi
    {if !empty($formData.promotionproduct)}
        <table class="table table-striped">
                <thead>
                    <th>Mã Combo</th>
                    <th>Tên Combo</th>
                    <th>Mã sản phẩm ERP</th>
                    <th>Tên sản phẩm ERP</th>
                    <th>Loại combo</th>
                    <th>Giá trị</th>
                    <th>Số lượng</th>
                    <th>Số thứ tự</th>
                    <th></th>
                </thead>
        {foreach from=$formData.promotionproduct item=promoex}
                <tr>
                    <td>{$promoex->coid}</td>
                    <td>{if !empty($formData.listCombo[$promoex->id]->name)}{$formData.listCombo[$promoex->id]->name}{/if}</td>
                    <td>{$promoex->barcode}</td>
                    <td>{if !empty($formData.listProduct[$promoex->barcode]->name)}{$formData.listProduct[$promoex->barcode]->name}{/if}</td>
                    <td>
                        {if $promoex->type == 1}
                            Giá cố định
                        {elseif $promoex->type == 2}
                            Giảm giá theo %
                        {elseif $promoex->type == 3}
                            Giảm giá theo số tiền
                        {/if}
                    </td>
                    <td>{$promoex->quantity}</td>
                    <td>{$promoex->displayorder}</td>
                    <td></td></tr>
        {/foreach}
        </table>
    {/if}
</div>