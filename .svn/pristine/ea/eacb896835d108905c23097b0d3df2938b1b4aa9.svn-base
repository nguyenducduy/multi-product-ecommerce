
{literal}
<style type="text/css">
.pricecompare{}

.pricecompare thead th{background: #eee !important; padding:5px;}
.pricecompare thead tr.pricecomparehead th{background:#ccc !important; text-align: left}

.pricecompare tbody td{padding:5px;border-top:1px solid #ddd;}

.pricecompare tbody tr.even{background-color:#f5f5f5;}
.pricecompare tbody tr:hover{background:#ccc !important;}

.productcomparename {
    text-transform: uppercase;
    font-size: 15px;
}
</style>
{/literal}

<table cellpadding="0" cellspacing="0" class="pricecompare">
    <thead>
        <tr class="pricecomparehead">
            <th colspan="4" class="productcomparename">Đối thủ online</th>
            <!-- <th style="text-align:right;"><a href="{$conf.rooturl_admin}productprice/index/pbarcode/{$myProduct->barcode|trim}/tab/2" target="_blank">Sửa giá đối thủ</a></th> -->
            <th style="text-align:right;"><a href="javascript:void(0)" onclick="openShadowbox('{$conf.rooturl_admin}productprice/index/pbarcode/{$myProduct->barcode|trim}/tab/2')">Sửa giá đối thủ</a></th>
        </tr>
        <tr>
            <th style="width: 70px">Hình ảnh</th>
            <th style="">Mô tả sản phẩm</th>
            <th style="width: 150px">Nơi bán</th>
            <th style="width: 150px">Giá (VNĐ)</th>
            <th style="width: 150px">Giá gốc (VNĐ)</th>
        </tr>
    </thead>
    <tbody>
         {foreach from=$priceenemyonline item=penemyonline key=penemykey}
            {if !empty($penemyonline->priceenemyactor->url)}
            <tr class="{cycle values="odd,even"}">
               
                 <td>
                    <img src="{$penemyonline->priceenemyactor->image}" title="{$penemyonline->priceenemyactor->productname}" alt="{$penemyonline->priceenemyactor->productname}" width="70px" height="70px"/>
                 </td>
                 <td>
                    <p class="eproductname"><b>{$penemyonline->priceenemyactor->productname}</b></p>
                    {if $penemyonline->priceenemyactor->promotioninfo != ""}
                        <p><span style="font-weight:bold">Khuyến mãi:</span>{$penemyonline->priceenemyactor->promotioninfo}</p>
                    {/if}
                    {if $penemyonline->priceenemyactor->description != ""}
                        <p class="onlinedes_{$penemykey}"><span style="font-weight:bold">Mô tả:</span>{$penemyonline->priceenemyactor->description|strip_tags|truncate:400}</p>
                        {if $penemyonline->priceenemyactor->description|strip_tags|strlen > 400}
                            <div class="fulldes_{$penemykey} fulldesc" style="display:none;">
                                <span style="font-weight:bold">Mô tả:</span>{$penemyonline->priceenemyactor->description}
                            </div>
                             <a class="readmoreonl" rel="{$penemykey}" style="cursor: pointer">
                                [Xem thêm]
                            </a>
                        {/if}
                    {/if}
                 </td>
                <td>{$penemyonline->name}</td>
                <td style="text-align:right" class="pricepromotion">{$penemyonline->priceenemyactor->pricepromotion|number_format}</td>
                <td style="text-align:right" class="price">{$penemyonline->priceenemyactor->priceauto|number_format}</td>
            </tr>
            {/if}
            {/foreach}
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" class="pricecompare">
    <thead>
        <tr class="pricecomparehead">
            <th colspan="4" class="productcomparename">Đối thủ offline</th>
            <th style="text-align:right;"><a href="{$conf.rooturl_admin}productprice/index/pbarcode/{$myProduct->barcode|trim}/tab/2" target="_blank">Sửa giá đối thủ</a></th>
        </tr>
        <tr>
            <th style="">Mô tả sản phẩm</th>
            <th style="width: 150px">Nơi bán</th>
            <th style="width: 150px">Chi nhánh</th>
            <th style="width: 150px">Giá (VNĐ)</th>
            <th style="width: 150px">Giá gốc (VNĐ)</th>
        </tr>
    </thead>
    <tbody>
        {if $priceenemyoffline|count > 0}
         {foreach from=$priceenemyoffline item=penemyoff key="penemykeyoff"}
            <tr class="{cycle values="odd,even"}">
                 <td>
                    <p class="eproductname">{$penemyoff->productname}</p>
                    {if $penemyoff->promotioninfo != ""}
                        <p><span style="font-weight:bold">Khuyến mãi:</span>{$penemyoff->promotioninfo}</p>
                    {/if}
                   {if $penemyoff->description != ""}
                        <p class="desoff_{$penemykeyoff}"><span style="font-weight:bold">Mô tả:</span>{$penemyoff->description|strip_tags|truncate:400}
                        </p>
                        {if $penemyoff->description|strip_tags|strlen > 400}
                            <div class="fulldesoff_{$penemykeyoff} fulldesc" style="display:none;">
                                <span style="font-weight:bold">Mô tả:</span>{$penemyoff->description}
                            </div>
                            <a class="readmoreoff" rel="{$penemykeyoff}" style="cursor: pointer">
                                [Xem thêm]
                            </a>
                        {/if}
                    {/if}
                 </td>
                <td>{$penemyoff->enemyactor[0]->name}</td>
                <td>{$penemyoff->name}</td>
                <td style="text-align:right" class="pricepromotion">{$penemyoff->pricepromotion|number_format}</td>
                <td style="text-align:right" class="price">{$penemyoff->price|number_format}</td>
            </tr>
            {/foreach}
        {else}
            <tr>
                <td colspan="5">Không có dữ liệu</td>
            </tr>
        {/if}

    </tbody>
</table>