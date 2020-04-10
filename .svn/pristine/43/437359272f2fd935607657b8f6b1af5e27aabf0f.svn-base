{if !empty($listproductcat)}
{foreach from=$listproductcat item=product name=ProductsByCategory}
            	{assign var="promotionprices" value=$product->promotionPrice()}
            	
            	<li>
                	<a href="{$product->getProductPath()}" title="{$product->name|escape}">
                	 {if $product->onsitestatus == $OsERPPrepaid}<span class="tagpreorder">Đặt trước</span>
			            {elseif $product->onsitestatus == $OsCommingSoon}<span class="tagsapve">Sắp về</span>
			            {elseif $product->onsitestatus == $OsHot}<span class="taghot">Hot</span>
			            {elseif $product->onsitestatus == $OsNew}<span class="tagnew">Mới</span>
			            {elseif $product->onsitestatus == $OsDoanGia} <span class="tagguess">Đoán giá</span>
			            {elseif $product->onsitestatus == $OsBestSeller}
			            {elseif $product->onsitestatus == $OsCrazySale}
			            {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<span class="tagtheend">Hết hàng</span>
			            {/if} 
                    	<img src="{$product->getSmallImage()}" alt="{$product->name|escape}" />
                        <h3>{$product->name} </h3>
                        <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
	                        {if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                              <div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                              <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                              <span class="persale"> -{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
                          {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                              <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                          {elseif $product->sellprice >0}
                              <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                          {/if} 
                       </div>
                    </a>
                </li>
                
{/foreach}
{/if}