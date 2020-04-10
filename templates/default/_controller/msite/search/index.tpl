<!-- Content -->
    <section>
        <!-- -->
    	<div class="navibarlist">
        	<ul>
        	    <li><a title="dienmay.com" href="#">Trang chủ ››</a> </li>
                <li>Kết quả tìm kiếm {$reviewkey} ({$totalProduct})</li>
            </ul>
        </div>
    	<div class="catelist">
            <ul>
                {if $totalProduct + $totalNews > 0}
                    {if $myProduct|@count > 0}
                        {foreach item=product from=$myProduct name=ProductsByCategory}
                        {assign var="promotionprices" value=$product->promotionPrice()}
                        	   <li>
                                 <a href="{$product->getProductPath()}" title="{$product->name|escape}">
                                     {if $product->onsitestatus == $OsERPPrepaid}<span class="tagpreorder">Đặt trước</span>
                                      {elseif $product->onsitestatus == $OsCommingSoon} <span class="tagsapve">Sắp về</span>              
                                      {elseif $product->onsitestatus == $OsHot} <span class="taghot">HOT</span>
                                      {elseif $product->onsitestatus == $OsNew} <span class="tagnew">Mới</span>
                                      {elseif $product->onsitestatus == $OsDoanGia} <span class="tagguess">Đoán giá</span>
                                      {elseif $product->onsitestatus == $OsBestSeller}<!-- <i class="icon-status4"></i> Neu la gift-->
                                      {elseif $product->onsitestatus == $OsCrazySale}
                                      {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<span class="tagtheend">Hết hàng</span>
                                      {/if}  
                                     <img src="{$product->getSmallImage()}" alt="{$product->name|escape}" />
                                        <h3>{$product->name} </h3>
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
                        <div class="pagination" style="float: right;">
                             {assign var="pageurl" value="&page=::PAGE::"}
                            {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
                        </div> <!-- End .pagination -->
                    {/if}
                    {else}
                        Không có kết quả nào phù hợp với từ khóa tìm kiếm của bạn.
                {/if}

            </ul>
            <!-- <div class="viewallproducts"><a href="listproduct.html" title="Xem tất cả">Xem thêm »</a></div> -->
          </div>
    </section>
<!-- End content -->