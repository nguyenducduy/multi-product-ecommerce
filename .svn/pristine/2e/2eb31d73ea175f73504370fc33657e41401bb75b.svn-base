<!-- Content -->
    <section>
        <!-- -->
    	<div class="navibarlist">
        	<ul>
        	<li><a href="{$curCategory->getProductcateoryPath()}" title="{if !empty($curCategory->seotitle)}{$curCategory->seotitle|escape}{else}{$curCategory->name|escape}{/if}">{$curCategory->name} ››</a></li>        
        	{if !empty($myVendor)}
        	<li><a href="{$registry.conf.rooturl}{$slugcategory}?vendor={$smarty.get.vendor}" title="{$myVendor->name|escape}">{$myVendor->name} ››</a></li>
        	{/if}
              <li>Tìm kiếm 
        	{if !empty($attributeList['DELETEDURL'])}
        		{foreach from=$attributeList['DELETEDURL'] item=delurl name=namedelurl}
        			{$delurl.name}
        			{if $smarty.foreach.namedelurl.last}{else},{/if}
        		{/foreach}
        	{/if}
        </li>
            </ul>
        </div>
        <!-- menu, filter -->
        <!-- Bar -->
        <div class="barfilter">
            <select size="1" class="btnsort" onchange="window.location.href = this.value;">
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=gia-cao-den-thap{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=gia-cao-den-thap{else}?o=gia-cao-den-thap{/if}" {if $order == 'gia-cao-den-thap'} selected="selected" {/if}>Giá từ cao đến thấp</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=gia-thap-den-cao{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=gia-thap-den-cao{else}?o=gia-thap-den-cao{/if}" {if $order == 'gia-thap-den-cao'} selected="selected" {/if}>Giá từ thấp đến cao</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=moi-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=moi-nhat{else}?o=moi-nhat{/if}" {if $order == 'moi-nhat'} selected="selected" {/if}>Mới nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=ban-chay-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=ban-chay-nhat{else}?o=ban-chay-nhat{/if}" {if $order == 'ban-chay-nhat'} selected="selected" {/if}>Bán chạy nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}{if $attributeList['VALUE']}&a={$attributeList['VALUE']}{/if}&o=duoc-quan-tam-nhat{elseif $attributeList['VALUE']}?a={$attributeList['VALUE']}&o=duoc-quan-tam-nhat{else}?o=duoc-quan-tam-nhat{/if}" {if $order == 'duoc-quan-tam-nhat'} selected="selected" {/if}>Được quan tâm nhất</option>
            </select>
			<div class="button btnfilter"><a href="{$config_root}product/filter?pcid={$internaltopbar_objectid}{if !empty($smarty.get.vendor)}&vendor={$smarty.get.vendor}{/if}{if !empty($smarty.get.a)}&a={$smarty.get.a}{/if}">Xem theo tiêu chí ››</a></div>
            <div class="clearfix"></div>
		</div>
        <!-- list products -->
    	<div class="catelist">
    	{if !empty($listproductcat)}
            <ul>
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
            </ul>
            {else}
            <span class="nofi-filter">Không tìm thấy sản phẩm theo tiêu chí</span>
           {/if}
          
          </div>
    </section>
<!-- End content -->