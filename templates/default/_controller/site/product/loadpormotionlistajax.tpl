{if !empty($listpromotionbypromotionids)}
		{foreach from=$listpromotionbypromotionids key=promoide item=promotioninfo}
			<div class="gift-1 giftids" {if $productDetail->onsitestatus == $OsERPPrepaid}style="color:#444"{/if} id="{$promoide}"{if $promotioninfo['promoname']|strip_tags|trim == '-' || $promotioninfo['promoname']|strip_tags|trim == '.' || $promotioninfo['promoname']|strip_tags|trim == '&nbsp;'} style="display: none;"{/if}>
				{if $productDetail->onsitestatus != $OsERPPrepaid && $promotioninfo['disablegift'] == 1}<i class="icon-gift"></i>{/if}
				<input class="giftopt promotions{if !empty($parentpromotionprices) && $parentpromotionprices.promoid == $promoide && $promotioninfo['promoname']|strip_tags|trim != '-' && $promotioninfo['promoname']|strip_tags|trim != '.'} activefirst{/if}" name="giftpromo" type="radio" value="{$productDetail->id}_{$promoide}" style="display:none"/>{$promotioninfo['promoname']}</div>
		{/foreach}
{else}
	{if $productDetail->onsitestatus == $OsERPPrepaid && !empty($productDetail->prepaidpromotion)}
		{$productDetail->prepaidpromotion}
	{else}
		{literal}
			<script type="text/javascript">
				if($('.titinfo').length > 0)
				{
					$('.titinfo').first().remove();
					$('.infogift_pre').remove();
					$('.infodesc_pre').css('border-left','none');
				}
			</script>
		{/literal}
	{/if}
{/if}