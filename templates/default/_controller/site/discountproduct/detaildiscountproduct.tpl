<div id="wrapbts">
	<div class="bannerbts">
    	<a href="#" title="Tựu trường cùng dienmay.com"><img src="{$currentTemplate}images/site/banner-back-to-school-main.png" alt="Banner-Back-to-school" /></a>
        <div class="btslike">
        <div class="btnlikeleft">
        	<iframe src="http://www.facebook.com/plugins/like.php?href=http://dienmay.com/khoi-dau-hoan-hao&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>
        </div>
            </div>
            <div class="btslikecont">Chương trình tựu trường cùng dienmay.com dành cho tất cả các bạn sinh viên trong năm học mới</div>
        </div>
    </div>

<div id="wraplistbts" class="clearfix">
	<div class="leftbts">
    	<div class="navbts">
    		<h3>Giảm giá <span class="btsarrowdown arrcam"></span></h3>
            <ul>
            {if !empty($listDiscountProduct)}
            	{assign var=i value=0}
				{foreach from=$listDiscountProduct name=dp item=discountproduct}
					{if $discountproduct['type'] == 0}
						<li><a class="{$colordiscount[$i]}" rel="{Helper::codau2khongdau($discountproduct['discountname'], true, true)}" href="#{Helper::codau2khongdau($discountproduct['discountname'], true, true)}"><i class="iconnavarr"></i>{$discountproduct['discountname']}</a></li>	
						{$i ={counter}+1}				 	
				 	{/if}
				 {/foreach}
        	{/if}
        	{if !empty($listDiscountProduct)}
				{foreach from=$listDiscountProduct name=dp item=discountproduct}
					{if $discountproduct['type'] == 1}
				 		<li class="{$colorpresent[$discountproduct['amount']]}"><a rel="{Helper::codau2khongdau($discountproduct['discountname'], true, true)}" href="#{Helper::codau2khongdau($discountproduct['discountname'], true, true)}"><i class="{$colorpresenticon[$discountproduct['amount']]}""></i><span class="classhover"></span></a></li>
				 	{/if}
				 {/foreach}
        	{/if}
            </ul>
        </div>
        <!-- -->
        <div class="navbts">
    		<h3 class="fontother">Mua sắm kiểu sinh viên<span class="btsarrowdown arrcam"></span></h3>
            <ul><!--
            {if !empty($listDiscountProduct)}
				{foreach from=$listDiscountProduct name=dp item=discountproduct}
				{if $discountproduct['type'] == 2}
            	<li class="{$colorstudent[{Helper::codau2khongdau($discountproduct['discountname'], true, true)}]}"><a rel="{Helper::codau2khongdau($discountproduct['discountname'], true, true)}" href="#{Helper::codau2khongdau($discountproduct['discountname'], true, true)}"><i class="icon{$colorstudent[{Helper::codau2khongdau($discountproduct['discountname'], true, true)}]}"></i><span class="classhover"></span></a></li>
                               
           	 	{/if}
           	 {/foreach}
        	{/if}
        	
			-->
			<li class="learn"><a href="#" rel="13"><i class="iconlearn"></i><span class="classhover"></span></a></li>
            <li class="motel"><a href="#" rel="15"><i class="iconmotel"></i><span class="classhover"></span></a></li>
            <li class="connt"><a href="#" rel="14"><i class="iconconnt"></i><span class="classhover"></span></a></li>
            <li class="enter"><a href="#" rel="12"><i class="iconenter"></i><span class="classhover"></span></a></li>    
			</ul>
        </div>
    </div>
    <!-- -->
    <div class="rightbts">
    
   {if !empty($listDiscountProduct)}
	{foreach from=$listDiscountProduct name=dp item=discountproduct}
    	<div class="promobtslist clearfix" id="{Helper::codau2khongdau($discountproduct['discountname'], true, true)}">
    	{if $discountproduct['type'] == 0}
<!--        	<h3>Giảm giá đến <span>{$discountproduct['amount']|number_format}đ</span><span class="btsarrowdown arrla"></span></h3>-->
				<h3>{$discountproduct['discountname']}</span><span class="btsarrowdown arrla"></span></h3>
        {elseif $discountproduct['type'] == 1}
        	<h3>{$discountproduct['discountname']}</span><span class="btsarrowdown arrla"></span></h3>
        {else}
        	<h3 class="pinkt" id="{$discountproduct['id']}">{$discountproduct['discountname']}<span class="btsarrowdown arrpink"></span></h3>
        {/if}
            <!-- -->
        {if empty($discountproduct['discountcombo'])}
            <ul>
            {foreach from=$discountproduct['listProduct'] name=listproduct item=product}
            	<li>
                	<!--<div class="renhat"><i class="iconrenhat"></i></div>-->
                	<a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><img src="{$product->getSmallImage()}" alt="{$product->name}" /></a>
                    <a style="height:36px; overflow:hidden" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}">{$product->name} </a>
                    {if $product->displaysellprice!=1 && $product->sellprice > 0 && $product->promotionprice<$product->sellprice && $product->promotionprice != ''}
	                    <div class="pricebtsold">{$product->sellprice|number_format}đ</div>
	                    <div class="pricebtsnew">{$product->promotionprice|number_format}đ</div>
	                    <div class="discountrate">-{$product->discountvalue|number_format}đ</div>
	                {elseif $product->sellprice > 0}
	                 	<div class="pricebtsnew">{$product->sellprice|number_format}đ</div>
                    {/if}
                    <div class="btsbuy"><a href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($product->promotionid)}&prid={$product->barcode|trim}_{$product->promotionid}{/if}&po=p{substr($product->barcode|trim, -5, 5)}39">Mua ngay</a></div>
                    {if !empty($product->gifts)}
                    <div class="popupbts">
                    	{foreach from =$product->gifts name=gifts item=gift}
                    		{$gift}<br>
                    	{/foreach}
                    	<span class="btsarrowdown arrnau"></span>
                    </div>
                    {/if}
                </li>
                {/foreach}
               
            </ul>
            {else}
            	{$discountproduct['discountcombo']}
            {/if}
        </div>
        
        {/foreach}
        {/if}
        <!-- promo orther -->

    </div>
</div>

<div class="sharesocial">
	<ul>
    	<li>Hãy cùng chia sẽ với bạn bè để lan tỏa niềm vui mua sắm cho mùa tựu trường</li>
        <li><i class="iconhand"></i></li>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=http://dienmay.com/khoi-dau-hoan-hao/" target="_blank"><i class="iconshfb"></i></a></li>
        <li><a href="http://twitter.com/share?text=Khởi đầu hoàn hảo cùng dienmay.com&url=http://dienmay.com/khoi-dau-hoan-hao/" target="_blank"><i class="iconstwt"></i></a></li>
        <li><a href="https://plus.google.com/share?url=http://dienmay.com/khoi-dau-hoan-hao/" target="_blank"><i class="iconsgpl"></i></a></li>
    </ul>
</div>

<script>

$(document).ready(function() {

	 $('.navbts li a').click(function(){
		var rel = $(this).attr("rel");
		$(document).scrollTo('#' + rel, 500);
		return false;
	});


});
</script>