{if !empty($productDetail)}			            	
	<p class="productsegmentimage">
		<a href="{$productDetail->getProductPath()}" title="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}">
			<img src="{$productDetail->getSmallImage()}" alt="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}" border="0" />
		</a>
	</p>
	<h3 class="productsegmenttitle">
		<a href="{$productDetail->getProductPath()}" title="{if !empty($productDetail->seotitle)}{$productDetail->seotitle}{else}{$productDetail->name}{/if}">{$productDetail->name}</a>
	</h3>
	<p class="productsegmentprice">
	{if !empty($discount)}
		<span class="productsegmentnewprice">{$discount|number_format} đ</span>
		<span class="productsegmentoldprice">{$finalprice|number_format} đ</span>
		<span class="productsegmentolddiscountnum">-{math|number_format equation="x - y" x=$finalprice y=$discount format="%.0f"} đ</span>
	{else}
		<span class="productsegmentnewprice">{$finalprice|number_format} đ</span>
	{/if}
	</p>
	<p class="productsegmentbuybutton">
		<a class="productsegmentbuylink" href="{$conf.rooturl}cart/checkout?id={$productDetail->id}{if !empty($promoiddiscount)}&prid={$productDetail->barcode|trim}_{$promoiddiscount}{/if}">Mua ngay</a>
	</p>
	{if !empty($promoinfo)}
	<div class="productsegmentpromotioninfo">
		{foreach from=$promoinfo item=promotion}
			{if $promotion->description|strip_tags|trim != '-' && $promotion->description|strip_tags|trim != '.' && $promotion->description|strip_tags|trim != '&nbsp;'}
				<div class="productsegmentpromotioninfoitem">{$promotion->description}</div>
			{/if}
		{/foreach}
		<div class="productsegmentpromotioninfoitem">hó hó hó hó</div>
		<div class="productsegmentpromotioninfoitem">sd fsd fsdf sdfsdf</div>
	</div>
	{/if}
{/if}