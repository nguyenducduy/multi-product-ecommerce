<!-- Content -->
    <section>
        <!-- -->
    	<div class="navibarlist">
        	<ul>
        		<li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a></li>
        		{foreach from=$fullPathCategory item=fcat}
            	<li><a href="{$fcat['fullpath']}" title="{$fcat['pc_name']|escape}">{$fcat['pc_name']} »</a></li>
            	{/foreach}
                <li>
                {if isset($smarty.get.fvid) || isset($smarty.get.vendor) || isset($smarty.get.a)}
                <a href="{$curCategory->getProductcateoryPath()}" title="{$curCategory->name|escape}">{$curCategory->name} »</a>
                {else}
        			{$curCategory->name}
        		{/if}
                </li>
                 {if !empty($myVendors->name)}
        			<li>{$myVendors->name}</li>
        		{/if}
            </ul>
        </div>
        <!-- menu, filter -->
        <!-- Bar -->
        <div class="barfilter">
            <select size="1" class="btnsort" onchange="window.location.href = this.value;">
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}&o=gia-cao-den-thap{else}?o=gia-cao-den-thap{/if}" {if $order == 'gia-cao-den-thap'} selected="selected" {/if}>Giá từ cao đến thấp</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}&o=gia-thap-den-cao{else}?o=gia-thap-den-cao{/if}" {if $order == 'gia-thap-den-cao'} selected="selected" {/if}>Giá từ thấp đến cao</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}&o=moi-nhat{else}?o=moi-nhat{/if}" {if $order == 'moi-nhat'} selected="selected" {/if}>Mới nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}&o=ban-chay-nhat{else}?o=ban-chay-nhat{/if}" {if $order == 'ban-chay-nhat'} selected="selected" {/if}>Bán chạy nhất</option>
              <option value="{$curCategory->getProductcateoryPath()}/{$myVendors->slug}{if $myVendors->arrslug}?vendor={$myVendors->arrslug}&o=duoc-quan-tam-nhat{else}?o=duoc-quan-tam-nhat{/if}" {if $order == 'duoc-quan-tam-nhat'} selected="selected" {/if}>Được quan tâm nhất</option>
            </select>
			<div class="button btnfilter"><a href="{$conf.rooturl}product/filter?pcid={$internaltopbar_objectid}{if !empty($smarty.get.vendor)}&vendor={$smarty.get.vendor}{/if}{if !empty($smarty.get.a)}&a={$smarty.get.a}{/if}">Xem theo tiêu chí ››</a></div>
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
            <span class="nofi-filter">Sản phẩm đang cập nhật</span>
           {/if}
           {if $curPage < $totalPage}
            <div class="viewallproducts"><a onclick="moreproduct();" href="javascript:;" title="Xem thêm">Xem thêm »</a></div>
          {/if}
          </div>
    </section>
<!-- End content -->
{literal}
<script>
var pages = 2;
var busy = true;
function moreproduct(){
	var fpcid = "{/literal}{$fpcid}{literal}";
	var fvid = "{/literal}{$smarty.get.fvid}{literal}";
	var fvidlist = "{/literal}{$fvidlist}{literal}";
	var order = "{/literal}{$order}{literal}";
	var data  = {
			action:"ajaxmoreproduct",
			fpcid : fpcid,
			fvid  :  fvid,
			fvidlist: fvidlist,
			pages : pages,
			order : order
	};
	//alert(JSON.stringify(data, null, 4));
	//{$curCategory->getProductcateoryPath()}{if !empty($myVendors->name)}/{$myVendors->slug}{/if}/page-{($curPage+1)}
	if(busy == true){
		$(".viewallproducts").append('<span style="margin-top: 10px;" class="loading-gif"></span>');
		 $.ajax({
	        type : "POST",
			data : data,
			url: rooturl + 'product/ajaxmoreproduct',
			dataType: "html",
	        success: function(data){
		        if(data == ''){
			        busy = false;
			        $(".viewallproducts").remove();
			    }else{
				    $(".loading-gif").remove();
			    	$(".catelist ul").append(data);
			    	pages = pages + 1;
		        	 }
				}
			
		 });
	}
}
</script>
{/literal}