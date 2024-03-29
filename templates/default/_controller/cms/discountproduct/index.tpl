<style type="text/css">
   #sb-container{
        z-index: 99999;
    }
 
</style>
<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Discount products</a> <span class="divider">/</span></li>
    <li class="active">Danh sách</li>
</ul>

<div class="page-header" rel="menu_discountproduct"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.labelDiscountProductList}</a></li>
        <li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">

            {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning = $warning}

            <form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
                <input type="hidden" name="ftoken" value="{$smarty.session.discountproductBulkToken}" />
                <table class="table table-striped">

                    {if $discountProduct|@count > 0}
                        <thead>
                        <tr>
                            <th width="40"><input class="check-all" type="checkbox" /></th>
                            <th>sắp xếp</th>
                            <th><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelID}</a></th>
                            <th><a href="{$filterUrl}sortby/discountname/sorttype/{if $formData.sortby eq 'discountname'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelDiscountName}</a></th>
                            <th>{$lang.controller.labelListProduct}</th>
                            <th><a href="{$filterUrl}sortby/type/sorttype/{if $formData.sortby eq 'type'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelType}</a></th>
                             <th>Combo</th>
                            <th><a href="{$filterUrl}sortby/status/sorttype/{if $formData.sortby eq 'status'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelStatus}</a></th>
                            <th width="140"></th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="pagination">
                                    {assign var="pageurl" value="page/::PAGE::"}
                                    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
                                </div> <!-- End .pagination -->


                                <div class="bulk-actions align-left">
                                    <select name="fbulkaction">
                                        <option value="">{$lang.default.bulkActionSelectLabel}</option>
                                        <option value="delete">{$lang.default.bulkActionDeletetLabel}</option>
                                    </select>
                                    <input type="submit" name="fsubmitbulk" class="btn" value="{$lang.default.bulkActionSubmit}" />
                                     <input type="submit" name="fsubmitchangeorder" class="btn" value="{$lang.default.bulkItemChangeOrderSubmit}" />
                                </div>

                                <div class="clear"></div>
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                        {foreach item=dProduct from=$discountProduct}
                            <tr>
                                <td><input type="checkbox" name="fbulkid[]" value="{$dProduct->id}" {if in_array($dProduct->id, $formData.fbulkid)}checked="checked"{/if}/></td>
                                <td><input type="text" name="fdisplayorder[{$dProduct->id}]" value="{$dProduct->displayorder}" class="input-mini" style="width:30px;" /></span></td>
                                <td><span class="label label-info">{$dProduct->id}</span></td>
                                <td>
                                    <a href="{$registry.conf.rooturl_cms}discountproduct/indexlist/id/{$dProduct->id}" rel="shadowbox"><span>
                                    {$dProduct->discountname}
                                </a></span></td>
                                <td><a href="{$registry.conf.rooturl_cms}discountproduct/indexlist/id/{$dProduct->id}" rel="shadowbox"><span class="label label-info">{if $dProduct->listproduct != ""}{$dProduct->listproduct}{else}Empty{/if}</span></a></td>
                                <td><span class="label label-info">{if $dProduct->type == 0}Giảm giá theo Đơn giá{elseif $dProduct->type==1}Giảm giá theo %{else}Giảm giá theo nhu cau{/if}</span></td>
                                <td><span class="label label-info">{if $dProduct->discountcombo != ""}Có Combo{else}không có combo{/if}</span></td>
                                <td>{if $dProduct->status == 1}<span class="label label-success">Enable</span>{else}<span class="label label-inverse">Disable</span>{/if}</td>
                                <td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$dProduct->id}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
                                    <a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$dProduct->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
                                </td>
                            </tr>


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
                {$lang.controller.labelName}: <input type="text" name="fname" id="fname" value="{$formData.fname|@htmlspecialchars}" class="input-large" /> -

                {$lang.controller.labelStatus}: <select name="fstatus" id="fstatus">
                    <option value="">- - - -</option>
                    {html_options options=$statusList selected=$formData.fstatus}


                {$lang.controller.labelId}: <input type="text" name="fid" id="fid" value="{$formData.fid|@htmlspecialchars}" class="input-mini" /> -




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
</script>
{/literal}




