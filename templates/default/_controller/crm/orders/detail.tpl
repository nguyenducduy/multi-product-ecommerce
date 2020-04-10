        <title>Chi tiết hóa đơn</title>
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

{include file="notify.tpl" notifyError=$error notifySuccess=$success}

<div id="container">
    <div class="page-header"><h1>Order</h1></div>
    {if !empty($oneOrder)}
    <table class="table table-bordered">        
            <tr><td align="right" width="20%">{$lang.controller.labelOrderidcrm}: </td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelInvoiceid}: </td><td>{$oneOrder->invoiceid}</td></tr>
            <tr><td align="right">{$lang.controller.labelPricesell}: </td><td>{$oneOrder->pricesell|number_format}</td></tr>            
            <tr><td align="right">{$lang.controller.labelPricediscount}: </td><td>{$oneOrder->pricediscount|number_format}</td></tr>
            <!--<tr><td align="right">{$lang.controller.labelPricetax}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelPricehandling}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelPricefinal}: </td><td><code>{$oneOrder->pricefinal|number_format}</code></td></tr>
            <!--<tr><td align="right">{$lang.controller.labelCoupon}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelCouponvalue}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelPromotionvalue}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelContactemail}: </td><td>{$oneOrder->contactemail}</td></tr>
            <tr><td align="right">{$lang.controller.labelBillingfullname}: </td><td>{$oneOrder->billingfullname}</td></tr>
            <tr><td align="right">{$lang.controller.labelBillingphone}: </td><td>{$oneOrder->billingphone}</td></tr>
            <tr><td align="right">{$lang.controller.labelBillingaddress}: </td><td>{$oneOrder->billingaddress}</td></tr>
            <tr><td align="right">{$lang.controller.labelBillingregionid}: </td><td>{$oneOrder->regionname}</td></tr><!--
            <tr><td align="right">{$lang.controller.labelBillingcountry}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelShippingfullname}: </td><td>{$oneOrder->shippingfullname}</td></tr>
            <tr><td align="right">{$lang.controller.labelShippingphone}: </td><td>{$oneOrder->shippingphone}</td></tr>
            <tr><td align="right">{$lang.controller.labelShippingaddress}: </td><td>{$oneOrder->shippingaddress}</td></tr><!--
            <tr><td align="right">{$lang.controller.labelShippingcountry}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelShippingregionid}: </td><td>{$oneOrder->regionname}</td></tr><!--
            <tr><td align="right">{$lang.controller.labelShippinglat}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelShippinglng}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelShippingservice}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelShippingtrackingcode}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelIpaddress}: </td><td>{$oneOrder->ipaddress}</td></tr>
            <!--<tr><td align="right">{$lang.controller.labelPaymentisdone}</td><td>{$oneOrder->ipaddress}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelPaymentmethod}: </td><td>{if $oneOrder->paymentmethod == 0}{$lang.controller.labelorderPaymenMethodCash}{else}{$oneOrder->getpaymentOrderMethod()}{/if}</td></tr>
            <tr><td align="right">{$lang.controller.labelDeliverymethod}: </td><td>{if $oneOrder->deliverymethod == 0}{$lang.controller.labelorderDeliveryStore}{else}{$oneOrder->getpaymentOrderDeliveryMethod()}{/if}</td></tr>
            <!--<tr><td align="right">{$lang.controller.labelStatus}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelIsgift}: </td><td>{if $oneOrder->paymentisgif()}<i class="icon-ok tipsy-trigger" title="Gif"></i>{/if}&nbsp;</td></tr>
            <tr><td align="right">{$lang.controller.labelNote}: </td><td>{$oneOrder->note}</td></tr>
            <tr><td align="right">{$lang.controller.labelDatecreated}: </td><td>{$oneOrder->datecreated|date_format:"%d/%m/%Y %H:%m:%S"}</td></tr><!--
            <tr><td align="right">{$lang.controller.labelDatemodified}</td><td>{$oneOrder->orderidcrm}</td></tr>
            <tr><td align="right">{$lang.controller.labelDatecompleted}</td><td>{$oneOrder->orderidcrm}</td></tr>-->
    </table>
        {if !empty($Orderdetail)}
            <p class="page-header">&nbsp;</p>
            <div class="page-header"><h1>List Order Detail</h1></div>
            <table class="table table-striped">
                <thead>
                    <tr><th>Product Name</th><th>Promotion Name</th><th>Price sell</th><th>Price discount</th><th>Price Final</th><th>Quantity</th></tr>
                </thead>
                <tbody>
                {foreach from=$Orderdetail item=od}
                    <tr><td>{$od->productname}</td><td>{$od->promotionname}</td><td>{$od->pricesell|number_format}</td><td>{$od->pricediscount|number_format}</td><td>{$od->pricefinal|number_format}</td><td>{$od->quantity}</td></tr>
                {/foreach}
                </tbody>
            </table>
        {/if}
    {/if}
</div>