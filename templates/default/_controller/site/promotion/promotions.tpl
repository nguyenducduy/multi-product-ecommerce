<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}">Trang chá»§</a> â€ºâ€º</li>
        <li><a href="{$conf.rooturl}promotion">Khuyáº¿n mÃ£i</a></li>
        <!--<li>TÃªn sáº£n pháº©m â€ºâ€º</li>-->
        <p><i class="icon-mobile2"></i>TÆ° váº¥n Tivi <span>1900 1883</span> hoáº·c <span>(08) 38.102.102</span> <i>(NhÃ¡nh 15 mua hÃ ng, nhÃ¡nh 25 ká»¹ thuáº­t)</i></p>
    </ul>
</div>
<div id="banner">
  {$banner}
</div>
<div id="wrapper">
<div class="listproduct">    
    <div class="products">
        <pre>
        {$listpromotion|var_dump}
        </pre>
        {if $listpromotion|@count > 0}
        <ul>
            {foreach from=$listpromotion item=product name=ProductsByCategory}
            <li>
                <div class="special">
                    <span class="specialpercent">30%</span>
                </div>
                <a href="{$product->getProductPath()}">
                    {if $product->image!=''}
                    <img src="{$product->getSmallImage()}" width="150" height="150" /> 
                    {else}
                    <img src="{$currentTemplate}images/site/default/default.jpg" width="150" height="150" /> 
                    {/if}
                </a>
                <a href="{$product->getProductPath()}">{$product->name}</a>
                {$product->summary}
                <div class="priceold">{$product->sellprice} đ</div>
                <div class="pricenew">189.000 đ</div>
                <a href="#" class="buynow">Mua nhanh</a> 
            </li>
            <li{if $smarty.foreach.ProductsByCategory.iteration % 5 == 0 AND $smarty.foreach.ProductsByCategory.iteration !=1} class="showhide"{/if} >
                <div class="special" id="{$product->id}" rel="{$product->pcid}">
                    <span class="specialpercent">30%</span>
                </div>
                
                <a href="{$product->getProductPath()}">
                    {if $product->image!=''}
                    <img src="{$product->getSmallImage()}" width="150" height="150" /> 
                    {else}
                    <img src="{$currentTemplate}images/site/default/default.jpg" width="150" height="150" /> 
                    {/if}
                </a>
                <a href="{$product->getProductPath()}">{$product->name} </a>
                {$product->summary}                
                <div class="pricenew">{$product->sellprice} đ</div>
                <a href="#" class="buynow">Mua nhanh</a> 
            </li>
            {if $smarty.foreach.ProductsByCategory.iteration % 5 == 0 AND $smarty.foreach.ProductsByCategory.iteration !=1} 
                {if $listProductsByCategory[1282]|count==$smarty.foreach.ProductsByCategory.iteration}
                    </ul>
                {else}
                    </ul><div class="space-space"></div><ul>
                {/if}            
            {/if}
        {/foreach}
        </ul>
        {/if}
    </div>
    
    <!--<div><a href="#"><button class="login btnfull" type="button">+ Xem thÃªm</button></a></div>-->
    
       {assign var="pageurl" value="page/::PAGE::"}
       {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
    

</div>

</div>