{if !empty($listpromotionbypromotionids)}			            	
	{foreach from=$listpromotionbypromotionids key=promoide item=promotioninfo}
	{if $promotioninfo['promoname']|strip_tags|trim == '-' || $promotioninfo['promoname']|strip_tags|trim == '.' || $promotioninfo['promoname']|strip_tags|trim == '&nbsp;'}
	{else}
		<div class="gift-1 giftids" id="{$promoide}">
		<input class="giftopt promotions{if !empty($parentpromotionprices) && $parentpromotionprices.promoid == $promoide && $promotioninfo['promoname']|strip_tags|trim != '-' && $promotioninfo['promoname']|strip_tags|trim != '.'} activefirst{/if}" name="giftpromo" type="radio" value="{$productDetail->id}_{$promoide}" />{$promotioninfo['promoname']}
		</div>
	{/if}
	{/foreach}
{/if}