{$banner}
<section>
    	<div class="ac-container">
        {if !empty($listProductsByCategory)}
            {foreach from=$listProductsByCategory item=category key=categoryid name=ProductsByCategory}
                {if !empty($category) && !empty($listCategoriesIcon[$categoryid]) && !empty($listCategories[$categoryid])}
                      <div class="catelist" >
                        <input type="checkbox" {if $smarty.foreach.ProductsByCategory.iteration == 1}checked{/if} name="accordion-1" id="ac-{$smarty.foreach.ProductsByCategory.iteration}">
                        <label for="ac-{$smarty.foreach.ProductsByCategory.iteration}"><h2>{$listCategories[$categoryid]->name}</h2></label>
                        <article class="ac-small">
                        <ul>
                            {foreach from=$category key=subcatid name=subcategorylist item=subcate}
                                {if $smarty.foreach.subcategorylist.iteration == 3}
                                        {break}
                                {/if}
                                {foreach from=$subcate.products name=productlist item=product}
                                        {assign var="promotionprices" value=$product->promotionPrice()}
                                	<li>
                                    	<a href="{$product->getProductPath()}">
                                            {if $product->onsitestatus == $OsERPPrepaid}<span class="tagpreorder">Đặt trước</span>
                                              {elseif $product->onsitestatus == $OsCommingSoon} <span class="tagsapve">Sắp về</span>              
                                              {elseif $product->onsitestatus == $OsHot} <span class="taghot">HOT</span>
                                              {elseif $product->onsitestatus == $OsNew} <span class="tagnew">Mới</span>
                                              {elseif $product->onsitestatus == $OsBestSeller}<!-- <i class="icon-status4"></i> Neu la gift-->
                                              {elseif $product->onsitestatus == $OsCrazySale}
                                              {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<span class="tagtheend">Hết hàng</span>
                                              {/if}  
                                        	<img src="{$product->getSmallImage()}" alt="{$product->name}"title="{$product->name}" />
                                            <h3> {if $subcate.category->appendtoproductname == 1} {$subcate.category->name} {/if} {$product->name}</h3>
                                            <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
                                                {if $product->displaysellprice!=1 && $product->sellprice>0 && ($product->onsitestatus == $OsERP || $product->onsitestatus == $OsHot || $product->onsitestatus == $OsNew || $product->onsitestatus == $OsBestSeller || $product->onsitestatus == $OsCrazySale) && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
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
                            {/foreach}
                        </ul>
                        <div class="viewallproducts"><a href="{$listCategories[$categoryid]->getProductcateoryPath()}" title="{if !empty($listCategories[$categoryid]->seotitle)}{$listCategories[$categoryid]->seotitle}{else}{$listCategories[$categoryid]->name}{/if}" title="Xem tất cả »">Xem tất cả »</a></div>
                        </article>
                      </div>
                {/if}
            {/foreach}
        {/if}
          
      </div>
    </section>