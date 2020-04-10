        <title>Chi tiết khuyến mãi</title>
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
<div class="page-header"><h1>{$head_list}</h1></div>

<div class="tabbable">
    <ul class="nav nav-tabs">
        <li{if $formData.tab==1} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}">Tổng quát</a></li>
        <li{if $formData.tab==2} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}/tab/2">Phạm vi áp dụng</a></li>
        <li{if $formData.tab==3} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}/tab/3">Hình thức xuất</a></li>
        <li{if $formData.tab==4} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}/tab/4">DS sản phẩm áp dụng</a></li>
        <li{if $formData.tab==5} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}/tab/5">DS nhóm hàng KM</a></li>
        <li{if $formData.tab==6} class="active"{/if}><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromotion/id/{$formData.promotionid}/tab/6">CTKM không áp dụng kèm theo</a></li>
        <!--<li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/promotionexclude">DS mức KM khách hàng thân thiết</a></li>-->
    </ul>
    <div class="tab-content">
        <form method="post" action="">
        <div class="tab-pane active">

            {if $formData.tab==1 && !empty($formData.promotiondetail)}
                <table class="table table-striped">
                <tr><td>Tên chương trình:</td><td>{$formData.promotiondetail[0]->name}</td><td>&nbsp;</td></tr>
                <tr><td>Ngày bắt đầu:</td><td>{$formData.promotiondetail[0]->startdate|date_format:"%d/%m/%Y %H:%m:%S"}
                    Ngày kêt thúc: {$formData.promotiondetail[0]->enddate|date_format:"%d/%m/%Y %H:%m:%S"}
                    <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isactived==1}checked="checked"{/if} />Kích hoạt</span></td><td>&nbsp;</td></tr>
                <tr><td>Mô tả ngắn:</td><td>{$formData.promotiondetail[0]->shortdescription}</td><td>&nbsp;</td></tr>
                <tr><td>Nội dung:</td><td>{$formData.promotiondetail[0]->description}</td><td>&nbsp;</td></tr>

                <tr><td>Nội dung hiển thị trên website:</td><td>
                    <input type="hidden" name="ftoken" value="{$smarty.session.updatedescriptionclone}" />
                    <input type="text" value="{$formData.promotiondetail[0]->descriptionclone}" name="fdescriptionclone" class="input input-xxlarge" style="height:30px"/>
                    <input type="submit" value="Cập nhật" name="fupdatedescriptionclone" style="margin-top: -10px" class="btn btn-warning" />
                </td><td>&nbsp;</td></tr>
                <tr><td>Loại mới cũ:</td><td><span class="label">
                        {if $formData.promotiondetail[0]->promo_isnew==-1}Tất cả
                        {elseif $formData.promotiondetail[0]->promo_isnew==0} Cũ
                        {elseif $formData.promotiondetail[0]->promo_isnew==1} Mới
                        {/if}
                        </span>&nbsp;&nbsp;&nbsp;
                    Loại hàng trưng bày: <span class="label">
                        {if $formData.promotiondetail[0]->promo_isnew==-1}Tất cả
                        {elseif $formData.promotiondetail[0]->promo_isnew==0} Không là hàng trưng bày
                        {elseif $formData.promotiondetail[0]->promo_isnew==1} Hàng trưng bày
                        {/if}
                    </span>&nbsp;&nbsp;&nbsp;
                    <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isprintpromotion==1}checked="checked"{/if} />Có in lên sổ tay khuyến mãi hay không</span>
                </td><td>&nbsp;</td></tr>
                <tr><td>Mô tả SP áp dụng:</td><td>{$formData.promotiondetail[0]->description_product_apply}</td><td>&nbsp;</td></tr>
                <tr><td>Mô tả thông tin KM:</td><td>{$formData.promotiondetail[0]->description_promotioninfo}</td><td>&nbsp;</td></tr>
                <tr><td colspan="2">
                    <fieldset style="border: 1px solid #ccc;padding: 5px; float: left;margin: 5px;width: 350px;">
                        <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->ispromotionbytotalmoney==1}checked="checked"{/if} />Khuyến mãi theo tổng tiền hóa đơn</span>
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;Từ: <span class="label">{if $formData.promotiondetail[0]->minpromotionbytotalmoney >0}{$formData.promotiondetail[0]->minpromotionbytotalmoney}{else}0{/if}</span>  ->   <span class="label">{if $formData.promotiondetail[0]->maxpromotionbytotalmoney >0}{$formData.promotiondetail[0]->maxpromotionbytotalmoney}{else}0{/if}</span>
                        </label>
                    </fieldset>
                    <fieldset style="border: 1px solid #ccc;padding: 5px; float: left;margin: 5px;width: 350px;">
                        <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->ispromotionbyquantity==1}checked="checked"{/if} />Khuyến mãi theo số lượng</span>
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;Từ: <span class="label">{if $formData.promotiondetail[0]->minpromotionbyquantity >0}{$formData.promotiondetail[0]->minpromotionbyquantity}{else}0{/if}</span>  ->   <span class="label">{if $formData.promotiondetail[0]->maxpromotionbyquantity >0}{$formData.promotiondetail[0]->maxpromotionbyquantity}{else}0{/if}</span>
                        </label>
                    </fieldset>
                    <fieldset style="padding: 5px; float: left;margin: 5px;width: 350px;">
                        <label class="control-label"><span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isloyalty==1}checked="checked"{/if} />Dành cho khách hàng thân thiết</span></label>
                        <label class="control-label"><span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isnotloyalty==1}checked="checked"{/if} />Không dành cho khách hàng thân thiết</span></label>
                    </fieldset>
                </td><td>&nbsp;</td></tr>
                
                <tr><td colspan="2">
                    <fieldset style="border: 1px solid #ccc;padding: 5px; float: left;margin: 5px;width: 350px;">
                        <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->ispromotionbyquantity==1}checked="checked"{/if} />Khuyến mãi theo số lượng</span>
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;Từ: <span class="label">{if $formData.promotiondetail[0]->minpromotionbyquantity >0}{$formData.promotiondetail[0]->minpromotionbyquantity}{else}0{/if}</span>  ->   <span class="label">{if $formData.promotiondetail[0]->maxpromotionbyquantity >0}{$formData.promotiondetail[0]->maxpromotionbyquantity}{else}0{/if}</span>
                        </label>
                    </fieldset>
                    <fieldset style="border: 1px solid #ccc;padding: 5px; float: left;margin: 5px;width: 350px;">
                        <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->ispromotionbyhour==1}checked="checked"{/if} />Khuyến mãi theo giờ</span>
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;Từ: <span class="label">{if $formData.promotiondetail[0]->startpromotionbyhour >0}{$formData.promotiondetail[0]->startpromotionbyhour}{else}0{/if}</span>  ->   <span class="label">{if $formData.promotiondetail[0]->endpromotionbyhour >0}{$formData.promotiondetail[0]->endpromotionbyhour}{else}0{/if}</span>
                        </label>
                    </fieldset>
                </td><td>&nbsp;</td></tr>
                
                <tr><td colspan="2">
                    <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isimei==1}checked="checked"{/if} />Khuyến mãi áp dụng IMEI</span>&nbsp;&nbsp;&nbsp;&nbsp; 
                    <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->iscombo==1}checked="checked"{/if} />Là combo</span><p class="clearfix"></p>
                    <fieldset style="border: 1px solid #ccc;padding: 5px; float: left;margin: 5px;">
                        <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->timepromotion > 0}checked="checked"{/if} />Giới hạn số lần KM</span>
                        <label class="control-label">
                            &nbsp;&nbsp;&nbsp;SL: <span class="badge">{$formData.promotiondetail[0]->timepromotion}</span>
                        </label>
                    </fieldset>
                    <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->islimittimesoncustomer==1}checked="checked"{/if} />Giới hạn số lần KM trên KH</span>
                </td><td>&nbsp;</td></tr>
                <tr>
                    <td colspan="2">
                        <fieldset style="border: 1px solid #ccc;padding: 5px; margin: 5px;">
                            <span class="checkbox" style="display: inline-block;"><input type="checkbox" {if $formData.promotiondetail[0]->isshowvat==1}checked="checked"{/if} />Hiển thị thông báo trên hóa đơn VAT</span>
                            <label class="control-label">Độ ưu tiên: <span class="badge">{$formData.promotiondetail[0]->ispriorityinvoice}</span></label>
                            <label class="control-label">Nội dung: <span class="badge">{$formData.promotiondetail[0]->messagevat}</span></label>
                        </fieldset>
                    </td><td>&nbsp;</td>
                </tr>
            </table>
            {/if}<!--Promotion detail-->
            
            {if $formData.tab==2 && !empty($formData.promotionstore)}
            <table class="table table-striped">
                <thead>
                    <th width="200">Mã chi nhánh</th>
                    <th>Tên chi nhánh</th>
                    <th></th>
                </thead>
            {foreach item=promostore from=$formData.promotionstore}
                <tr><td>{$promostore->sid}</td><td>{$promostore->storename}</td><td></td></tr>
            {/foreach}
            </table>
            {/if}
            
            {if $formData.tab==3 && !empty($formData.promotionoutputtype)}
            <table class="table table-striped">
                <thead>
                    <th width="200">Mã</th>
                    <th>Hình thức xuất</th>
                    <th></th>
                </thead>
            {foreach item=promooutput from=$formData.promotionoutputtype}
                <tr><td>{$promooutput->poid}</td><td>{$promooutput->outputtypename}</td><td></td></tr>
            {/foreach}
            </table>
            {/if}
            
            {if $formData.tab==4 && (!empty($formData.promotionapplyproduct) || !empty($formData.listcombo))}
                {if !empty($formData.listproduct)}
                    <table class="table table-striped">
                        <thead>
                            <th>Mã Sản phẩm ERP</th>
                            <th>Tên sản phẩm</th>
                            <th>Mã NCC</th>
                            <th>Tên NCC</th>
                            <th></th>
                        </thead>
                        {foreach item=productappl from=$formData.promotionapplyproduct}
                            
                            <tr>
                                <td>{$productappl->pbarcode}</td>
                                <td>{if !empty($formData.listproduct[$productappl->pbarcode])}{$formData.listproduct[$productappl->pbarcode]->name}{/if}</td>
                                <td>{if !empty($formData.listproduct[$productappl->pbarcode])}{$formData.listproduct[$productappl->pbarcode]->vid}{/if}</td>
                                <td>{if !empty($formData.listproduct[$productappl->pbarcode]->vid) && !empty($formData.listvendor[$formData.listproduct[$productappl->pbarcode]->vid])}{$formData.listvendor[$formData.listproduct[$productappl->pbarcode]->vid]}{/if}</td>
                                <td></td>
                            </tr>
                        {/foreach}
                    </table>
                {elseif !empty($formData.listcombo)}
                    <table class="table table-striped">
                        <thead>
                            <th>Mã Combo</th>
                            <th>Tên Combo</th>
                            <th></th>
                        </thead>
                    {foreach item=cobo key=kcombo from=$formData.listcombo}
                        <tr><td>{$kcombo}</td><td>{$cobo}</td><td></td></tr>
                    {/foreach}
                    </table>
                {/if}
            {/if}
            
            
            {if !empty($formData.promotiongroup)}
                <table class="table table-striped">
                        <thead>
                            <th>Nhóm hàng khuyến mãi</th>
                            <th>Cố định</th>
                            <th>Giảm giá</th>
                            <th>Theo %</th>
                            <th>Giá trị giảm giá</th>
                            <th>Tính tỉ lệ</th>
                            <th>Loại nhóm khuyến mãi</th>
                            <th>Khuyến mãi có điều kiện</th>
                            <th>Điều kiện</th>
                            <th>Chỉ áp dụng IMEI</th>
                            <th></th>
                        </thead>
            {foreach from=$formData.promotiongroup item=promogroup}
                <tr>
                    <td>{if !empty($promogroup->name)}{$promogroup->name}{/if}</td>
                    <td><input type="checkbox" {if !empty($promogroup->isfixed)&& $promogroup->isfixed ==1}checked="checked"{/if} /></td>
                    <td><input type="checkbox" {if !empty($promogroup->isdiscount) && $promogroup->isdiscount ==1}checked="checked"{/if} /></td>
                    <td><input type="checkbox" {if !empty($promogroup->isdiscountpercent)&& $promogroup->isdiscountpercent ==1}checked="checked"{/if} /></td>
                    <td>{if !empty($promogroup->discountvalue)}{$promogroup->discountvalue}{/if}</td>
                    <td><input type="checkbox" {if $promogroup->isdiscountpercentcal ==1}checked="checked"{/if} /></td>
                    <td>
                        {if isset($promogroup->type)}
                            {if $promogroup->type==0}
                                Chỉ được chọn giảm giá hoặc tặng quà
                            {elseif $promogroup->type==1}
                                Được chọn cả 2
                            {else}
                                Bắt buộc chọn cả 2
                            {/if}
                        {/if}
                    </td>
                    <td><input type="checkbox" {if !empty($promogroup->iscondition)&& $promogroup->iscondition ==1}checked="checked"{/if} /></td>
                    <td>{if !empty($promogroup->conditioncontent)}{$promogroup->conditioncontent}{/if}</td>
                    <td><input type="checkbox" {if $promogroup->isonlyapplyforimei && $promogroup->isonlyapplyforimei ==1}checked="checked"{/if} /></td>
                    {if $promogroup->iscombo ==1}
                    <td><a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromocombolist/id/{$formData.promotiondetail[0]->id}/gpid/{$promogroup->id}" rel="shadowbox;width=450;height=300"> Xem combo KM</a></td>
                    {else}
                    <td>
                        {if !empty($promotiongrouplist)}
                        <a href="{$conf.rooturl}{$controllerGroup}/{$controller}/showpromoproductlist/id/{$formData.promotiondetail[0]->id}/gpid/{$promogroup->id}" rel="shadowbox;width=400;height=300">Xem SP KM</a>
                        {/if}
                    </td>
                    {/if}
                </tr>                
            {/foreach}
            </table>
            {/if}
            
            {if !empty($formData.promotionexclude) && !empty($formData.promotionexclude)}
                <table class="table table-striped">
                        <thead>
                            <th>Mã chương trình</th>
                            <th>Tên chương trình</th>
                            <th></th>
                        </thead>
                {foreach from=$formData.promotionexclude item=promoex}
                        <tr><td>{$promoex->id}</td><td>{$promoex->name}</td><td></td></tr>
                {/foreach}
                </table>
            {/if}
        </div><!-- end #tab 1 -->
        </form>
    </div>
</div>