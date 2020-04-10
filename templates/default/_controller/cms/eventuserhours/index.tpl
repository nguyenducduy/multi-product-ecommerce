<title>Add Discount Product</title>
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

</script>
<style type="text/css">
    body{
        padding: 0px;
    }
    .page-header h1 {
        margin-top: 10px;
    }
    #choose, .table{
        font-size: 12px;
    }
 
</style>

<div class="page-header" rel="menu_cheapproduct"><h1>{$lang.controller.head_list}</h1></div>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.labelUserNameList}( {$total} )</a></li>
       <li><a href="#tab2" data-toggle="tab">{$lang.controller.labelSearch}</a></li>
       {if $registry->router->getArg('searchin') != ''}
            <li><a href="{$registry->conf.rooturl_cms}/eventuserhours">Tất cả</a></li>
       {/if}
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">

            {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning = $warning}

            <form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
                <input type="hidden" name="ftoken" value="{$smarty.session.discountproductBulkToken}" />
                <table class="table table-striped">

                    {if $eventUserHoursList|@count > 0}
                        <thead>
                        <tr>
                            <th width="40"><input class="check-all" type="checkbox" /></th>
                            <th><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelID}</a></th>
                            <th><a href="{$filterUrl}sortby/fullname/sorttype/{if $formData.sortby eq 'fullname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
                            <th><a href="{$filterUrl}sortby/email/sorttype/{if $formData.sortby eq 'email'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelEmail}</a></th>
                            <th><a href="{$filterUrl}sortby/phone/sorttype/{if $formData.sortby eq 'phone'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelPhone}</a></th>
                            <th>{$lang.controller.labelDateCreated}</th>
                            <th>Vị trí</th>
                            <th width="140"></th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach item=eUserHours key=key from=$eventUserHoursList name=eventUserHoursList}
                            {if $eUserHours[0]->id > 0}
                            <tr >
                                <td><input type="checkbox" name="fbulkid[]" value="{$dProduct->id}" {if in_array($dProduct->id, $formData.fbulkid)}checked="checked"{/if}/></td>
                                <td><span class="label label-info">{$eUserHours[0]->id}</span></td>
                                <td>
                                    <span class="label label-info">{$eUserHours[0]->fullname}</span>
                                </td>
                                <td>{$eUserHours[0]->email}</td>
                                <td>{$eUserHours[0]->phone}</td>
                                <td>{date("d/m/Y H:i:s",$eUserHours[0]->datecreated)}</td>
                                <td><span class="label label-info">{$key}</span></td>
                                <td>
                                  {if $key == 33}
                                
                                    <span class='label label-warning'>Khách hàng may mắn</span>
                               
                                 {/if}
                                 </td>
                              
                            </tr>
                            {/if}

                        {/foreach}
                        </tbody>


                    {else}
                        <tr>
                            <td colspan="10"> {$lang.default.notfound}</td>
                        </tr>
                    {/if}

                </table>
            </form>

        </div><!-- end #tab 1 -->
        <div class="tab-pane" id="tab2">
            <form class="form-inline" action="" method="post" style="padding:0px;margin:0px;" onsubmit="return false;">
                <input type="hidden" value="{$formDataRel.fepid}" id="fhdid" />
                {$lang.controller.labelPhone}: <input type="text" name="fphone" id="fphone" value="{$formData.fphone|@htmlspecialchars}" class="input-large" style="height:28px" /> -----

                {$lang.controller.formKeywordLabel}:
                <input type="text" name="fkeyword" id="fkeyword" size="20" value="{$formData.fkeyword|@htmlspecialchars}" class="" style="height:28px;" />
                <select name="fsearchin" id="fsearchin">
                    <option value="fullname" {if $formData.fsearchin eq "fullname"}selected="selected"{/if}>{$lang.controller.labelName}</option>
                    <option value="email" {if $formData.fsearchin eq "email"}selected="selected"{/if}>{$lang.controller.labelEmail}</option>
                </select>-
                <input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="gosearch();"  />
            </form>
        </div><!-- end #tab2 -->
    </div>
</div>
{literal}
<script type="text/javascript">
  
    function viewShadowboxDiscount(url , name)
    {
        if(url.length > 0)
        {
            Shadowbox.open({
                    content:    url,
                    title :     'Them sản phẩm vao '+name,
                    player:     "iframe",
                    height:     500,
                    width:      1000
                });
        }
    }
    function gosearch()
    {
        var id = $('#fhdid').val();
        var path = rooturl_cms + "eventuserhours/index/id/"+id+"/search/keyword";
       

        var keyword = $("#fkeyword").val();
        if(keyword.length > 0)
        {
            path += "/keyword/" + keyword;
        }

        var keywordin = $("#fsearchin").val();
        if(keywordin.length > 0)
        {
            path += "/searchin/" + keywordin;
        }

        var phone = $('#fphone').val();
        if(phone.length > 0)
        {
            path += '/phone/' + phone;
        }

        document.location.href= path;
    }
</script>
{/literal}




