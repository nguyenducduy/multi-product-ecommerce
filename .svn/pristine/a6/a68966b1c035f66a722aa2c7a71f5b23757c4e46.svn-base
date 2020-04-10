<div class="specialproductsegment">
    {if !empty($productDetail)}
        <p class="productsegmentimage">
            <a href="{$productDetail->getProductPath()}" title="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}">
                <img src="{$productDetail->getSmallImage()}" alt="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}" border="0" />
            </a>
        </p>
        <h3 class="productsegmenttitle">
            <a style="overflow: hidden;" href="{$productDetail->getProductPath()}" title="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}">{$productDetail->name}</a>
        </h3>
        <!-- <p class="productsegmentprice">
		{if !empty($discount)}
			<span class="productsegmentnewprice">{$discount|number_format} đ</span>
			<span class="productsegmentoldprice">{$finalprice|number_format} đ</span>
			<span class="productsegmentolddiscountnum">-{math|number_format equation="x - y" x=$finalprice y=$discount format="%.0f"} đ</span>
		{else}
			<span class="productsegmentnewprice">{$finalprice|number_format} đ</span>
		{/if}
		</p> -->
        <div id="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" class="productsegmentprice loadprice lp{$productDetail->id}{$productDetail->barcode|trim|substr:-5}" rel="{$productDetail->id}{$productDetail->barcode|trim|substr:-5}{if $promostr != ""}#{$promostr}{/if}">
            <div class="pricenew">{if $finalprice > 1000}{$finalprice|number_format} đ{else}{$finalprice|number_format}    đ*{/if}</div>
            <!-- <div class="priceold">10,000,000</div> -->
        </div>
        <p class="productsegmentbuybutton">

        </p>
        {if $promoinfo|@count > 0}
            <div class="productsegmentpromotioninfo">
                {foreach from=$promoinfo item=promotion}
                    {if $promotion.name|strip_tags|trim != '-' && $promotion.name|strip_tags|trim != '.' && $promotion.name|strip_tags|trim != '&nbsp;'}
                        <div class="productsegmentpromotioninfoitem">{$promotion.name}</div>
                    {/if}
                {/foreach}
                <!-- <div class="productsegmentpromotioninfoitem">hó hó hó hó</div>
                <div class="productsegmentpromotioninfoitem">sd fsd fsdf sdfsdf</div> -->
            </div>
        {/if}
    {/if}
</div>