<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Thương hiệu - Ngành hàng</a> <span class="divider">/</span></li>
    <li class="active">Danh sách</li>
</ul>

<div class="page-header" rel="menu_brandcategory"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}({$total})</a></li>
        <li><a href="#tab2" data-toggle="tab">{$lang.default.filterLabel}</a></li>
        {if $formData.search != ''}
            <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">{$lang.default.formViewAll}</a></li>
        {/if}
        <li class="pull-right"><a class="btn btn-success" href="{$conf.rooturl}{$controllerGroup}/{$controller}/add">{$lang.controller.head_add}</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">

            {include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning = $warning}

            <form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
                <input type="hidden" name="ftoken" value="{$smarty.session.brandCategoryBulkToken}" />
                <table class="table table-striped">

                    {if $brandCategory|@count > 0}
                        <thead>
                        <tr>
                            <th width="40"><input class="check-all" type="checkbox" /></th>
                            <th><a href="{$filterUrl}sortby/id/sorttype/{if $formData.sortby eq 'id'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelBrand}</a></th>
                            <th><a href="{$filterUrl}sortby/name/sorttype/{if $formData.sortby eq 'name'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelName}</a></th>
                            <th><a href="{$filterUrl}sortby/pcid/sorttype/{if $formData.sortby eq 'pcid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelCategory}</a></th>
                            <th><a href="{$filterUrl}sortby/vid/sorttype/{if $formData.sortby eq 'vid'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelVendor}</a></th>
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

                                </div>

                                <div class="clear"></div>
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                        {foreach item=bcategory from=$brandCategory}

                            <tr>
                                <td><input type="checkbox" name="fbulkid[]" value="{$bcategory->id}" {if in_array($bcategory->id, $formData.fbulkid)}checked="checked"{/if}/></td>
                                <td><span class="label label-info">{$bcategory->id}</span></td>
                                <td><span class="label label-info">{$bcategory->name}</span></td>
                                <td>{Core_BrandCategory::getProductCategoryNameByID($bcategory->pcid)}
                                </td>

                                <td>
                                    {Core_BrandCategory::getVendorNameByID($bcategory->vid)}
                                </td>
                                <td>
                                    {if $bcategory->checkStatusName('enable')}
                                        <span class="label label-success">{$bcategory->getStatusName()}</span>
                                    {else}
                                        <span class="label label-important">{$bcategory->getStatusName()}</span>
                                    {/if}
                                </td>
                                <td><a title="{$lang.default.formActionEditTooltip}" href="{$conf.rooturl}{$controllerGroup}/{$controller}/edit/id/{$bcategory->id}/redirect/{$redirectUrl}" class="btn btn-mini"><i class="icon-pencil"></i></a> &nbsp;
                                    <a title="{$lang.default.formActionDeleteTooltip}" href="javascript:delm('{$conf.rooturl}{$controllerGroup}/{$controller}/delete/id/{$bcategory->id}/redirect/{$redirectUrl}?token={$smarty.session.securityToken}');" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
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
        function gosearch()
        {
            var path = rooturl + controllerGroup + "/brandcategory/index";


            var name = $('#fname').val();
            if(name.length > 0)
            {
                path += '/name/' + name;
            }

            var status = $('#fstatus').val();
            if(status.length > 0)
            {
                path += '/status/' + status;
            }

            var id = $('#fid').val();
            if(id.length > 0)
            {
                path += '/id/' + id;
            }


            document.location.href= path;
        }
    </script>
{/literal}



