        <title>Chi tiết đơn hàng trả góp</title>
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
    <div class="page-header"><h1>Chi tiết đơn hàng trả góp</h1></div>
    {if !empty($oneOrder)}
    <table class="table table-bordered">
            <tr><td align="right" width="40%">{$lang.controller.labelInvoiceid}: </td><td>{$oneOrder->invoiceid}</td></tr>
            <tr><td align="right">{$lang.controller.labelPricesell}: </td><td>{$oneOrder->pricesell|number_format}</td></tr>            
            <!--<tr><td align="right">{$lang.controller.labelPricemonthly}: </td><td>{$oneOrder->pricemonthly|number_format}</td></tr>-->
            <tr><td align="right">{$lang.controller.labelGender}: </td><td>{if $oneOrder->gender == 1}Male{else}Female{/if}</td></tr>
            <tr><td align="right">{$lang.controller.labelFullname}: </td><td>{$oneOrder->fullname}</td></tr>
            <tr><td align="right">{$lang.controller.labelPhone}: </td><td>{$oneOrder->phone}</td></tr>
            <tr><td align="right">{$lang.controller.labelEmail}: </td><td>{$oneOrder->email}</td></tr>
            <tr><td align="right">{$lang.controller.labelBirthday}: </td><td>{$oneOrder->birthday|date_format:"%d/%m/%Y %H:%m:%S"}</td></tr>
            <tr><td align="right">{$lang.controller.labelPersonalid}: </td><td>{$oneOrder->personalid}</td></tr>
            <tr><td align="right">{$lang.controller.labelPersonaltype}: </td><td>{if $oneOrder->personaltype == 1}Người đi làm{else}Sinh viên{/if}</td></tr>
            <tr><td align="right">{$lang.controller.labelAddress}: </td><td>{$oneOrder->address}</td></tr>
            <tr><td align="right">{$lang.controller.labelRegion}: </td><td>{$setting.region[$oneOrder->region]}</td></tr>
            <tr><td align="right">{$lang.controller.labelRegionresident}: </td><td>{$setting.region[$oneOrder->regionresident]}</td></tr>
            <tr><td align="right">{$lang.controller.labelInstallmentmonth}: </td><td>{$oneOrder->installmentmonth}</td></tr>
            
            <tr><td align="right">Số tiền trả trước ACS: </td><td>{if $getprepaid.ACS.nosupport==1}{$getprepaid.ACS.prepaid}{else}Không hỗ trợ{/if}</td></tr>
            <tr><td align="right">Số tiền trả hàng tháng của ACS: </td><td>{if $getprepaid.ACS.nosupport==1}{$getprepaid.ACS.monthly}{else}Không hỗ trợ{/if}</td></tr>
            
            <tr><td align="right">Số tiền trả trước PPF: </td><td>{if $getprepaid.PPF.nosupport==1}{$getprepaid.PPF.prepaid}{else}Không hỗ trợ{/if}</td></tr>
            <tr><td align="right">Số tiền trả hàng tháng của PPF: </td><td>{if $getprepaid.PPF.nosupport==1}{$getprepaid.PPF.monthly}{else}Không hỗ trợ{/if}</td></tr>
            
            <tr><td align="right">{$lang.controller.labelSegmentpercent}: </td><td>{$oneOrder->segmentpercent}%</td></tr>
            <tr><td align="right">{$lang.controller.labelPayathome}: </td><td><span class="lable lable-warning">{if $oneOrder->payathome == 1}YES{else}NO{/if}</span></td></tr>
    </table> 
    {/if}
</div>