<title>Danh sách sản phẩm trong khuyến mãi</title>
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
    <h2>Danh sách sản phẩm khuyến mãi
    {if !empty($formData.promotionproduct)}
        <table class="table table-striped">
                <thead>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th></th>
                </thead>
        {foreach from=$formData.promotionproduct item=promoex}
                <tr><td>{$promoex->barcode}</td><td>{$promoex->name}</td><td></td></tr>
        {/foreach}
        </table>
    {/if}
</div>