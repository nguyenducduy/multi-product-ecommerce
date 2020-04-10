{strip}
<div id="container">
    <div class="brandindex">
        <span>Danh mục thương hiệu</span>
        <ul>
            <li><a {if $keyword == 'all'} class="active" {/if} href="thuong-hieu?q=all">All</a>
            <li><a {if $keyword == 'a'} class="active" {/if} href="thuong-hieu?q=a">A</a></li>
            <li><a {if $keyword == 'b'} class="active" {/if} href="thuong-hieu?q=b">B</a></li>
            <li><a {if $keyword == 'c'} class="active" {/if} href="thuong-hieu?q=c">C</a></li>
            <li><a {if $keyword == 'd'} class="active" {/if} href="thuong-hieu?q=d">D</a></li>
            <li><a {if $keyword == 'e'} class="active" {/if} href="thuong-hieu?q=e">E</a></li>
            <li><a {if $keyword == 'f'} class="active" {/if} href="thuong-hieu?q=f">F</a></li>
            <li><a {if $keyword == 'g'} class="active" {/if} href="thuong-hieu?q=g">G</a></li>
            <li><a {if $keyword == 'h'} class="active" {/if} href="thuong-hieu?q=h">H</a></li>
            <li><a {if $keyword == 'i'} class="active" {/if} href="thuong-hieu?q=i">I</a></li>
            <li><a {if $keyword == 'j'} class="active" {/if} href="thuong-hieu?q=j">J</a></li>
            <li><a {if $keyword == 'k'} class="active" {/if} href="thuong-hieu?q=k">K</a></li>
            <li><a {if $keyword == 'l'} class="active" {/if} href="thuong-hieu?q=l">L</a></li>
            <li><a {if $keyword == 'm'} class="active" {/if} href="thuong-hieu?q=m">M</a></li>
            <li><a {if $keyword == 'n'} class="active" {/if} href="thuong-hieu?q=n">N</a></li>
            <li><a {if $keyword == 'o'} class="active" {/if} href="thuong-hieu?q=o">O</a></li>
            <li><a {if $keyword == 'p'} class="active" {/if} href="thuong-hieu?q=p">P</a></li>
            <li><a {if $keyword == 'q'} class="active" {/if} href="thuong-hieu?q=q">Q</a></li>
            <li><a {if $keyword == 's'} class="active" {/if} href="thuong-hieu?q=s">S</a></li>
            <li><a {if $keyword == 't'} class="active" {/if} href="thuong-hieu?q=t">T</a></li>
            <li><a {if $keyword == 'u'} class="active" {/if} href="thuong-hieu?q=u">U</a></li>
            <li><a {if $keyword == 'v'} class="active" {/if} href="thuong-hieu?q=v">V</a></li>
            <li><a {if $keyword == 'w'} class="active" {/if} href="thuong-hieu?q=w">W</a></li>
            <li><a {if $keyword == 'x'} class="active" {/if} href="thuong-hieu?q=x">X</a></li>
            <li><a {if $keyword == 'y'} class="active" {/if} href="thuong-hieu?q=y">Y</a></li>
            <li><a {if $keyword == 'z'} class="active" {/if} href="thuong-hieu?q=z">Z</a></li>
        </ul>
    </div>

    <div class="brandname">
        {if !empty($curVendor->image)}
        <img src="{$curVendor->getImage()}" alt="{$curVendor->name}" title="{$curVendor->name|escape}" />
        {/if}
        <span> {$curVendor->name}</span>
    </div>
    {if !empty($bannervendor->image)}
    <div class="brandbanner">
        <a href="{$bannervendor->link}" title="{$bannervendor->title|escape}"><img src="{$bannervendor->getImage()}" alt="{$bannervendor->title|escape}" title="{$bannervendor->title|escape}" /></a></li>
    </div>
    {/if}
    <div class="brandproduct">
        <div class="barbrand"><span>Sản phẩm nổi bật</span></div>
        <div class="productss">
            {if !empty($listproductcat)}
            <div class="products">
                
                  <ul>
                   {foreach from=$listproductcat item=product name=ProductsByCategory}
                        {assign var="promotionprices" value=$product->promotionPrice()}
                            
                    <li>

                        {if $listVendorColor[$product->id]|count > 1}           
                            <div class="lg">
                                <ul>
                                    {foreach from=$listVendorColor[$product->id] item=productsVendorListColor name=productsVendorListColorName}
                                        {if $productsVendorListColor[0] > 0}
                                             {if $smarty.foreach.productsVendorListColorName.index > 4}{break}{/if}
                                            <li class="qtooltip"><a class="qtootip" href="{if $productsVendorListColor[4] == 1}{$product->getProductPath()}{else}{$product->getProductPath()}?color={$productsVendorListColor[0]}{/if}" title="{$productsVendorListColor[2]}" style="background:#{$productsVendorListColor[3]}"></a></li>
                                        {/if}
                                    {/foreach}
                                </ul>
                            </div>                         
                        {/if}  
                       {if $product->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
                      {elseif $product->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
                      {elseif $product->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
                      {elseif $product->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
                      {elseif $product->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
                      {elseif $product->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                      {elseif $product->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
                      {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<div class="special"><i class="icon-theend"></i></div>
                      {/if}    
                      <a href="{$product->getProductPath()}" title="{$product->name}"><img src="{$product->getSmallImage()}" alt="{$product->name}" title="{$product->name}" /> </a> <a class="position-a" href="{$product->getProductPath()}"><h3>{$product->name}</h3>
                      </a>
                      <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
                      {if $product->displaysellprice!=1 && ($product->onsitestatus == $OsERP || $product->onsitestatus == $OsHot || $product->onsitestatus == $OsNew || $product->onsitestatus == $OsBestSeller) && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                        <div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                        <div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                        <span class="salepercent"> -{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
                       {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                         <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                       {elseif $product->sellprice >0}
                         <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                       {/if} 
                       </div>
                    </li>
                    {/foreach}
                  </ul>
                  
                </div>
               
                
                {assign var="pageurl" value="page-::PAGE::"}
                {paginateul count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}
                {if $totalproductpage > 0}
                    <div class="seecontinue">Mời bạn xem tiếp ( còn {$totalproductpage} sản phẩm )</div>
                {/if}
            {/if}
        </div>
    </div>
    {if !empty({$curVendor->content})}
    <div class="brandintroduce">
        <span>Giới thiệu về {$curVendor->name}</span>
        <p>{$curVendor->content}</p>
    </div>
    {/if}

    <div class="articlesseo" style="margin: 0 auto;">
        <div class="articlescol">
            {if !empty($curVendor->titlecol1)}<span>{$curVendor->titlecol1}</span>{/if}
            {if !empty($curVendor->desccol1)}{$curVendor->desccol1}{/if}
        </div>
        <div class="articlescol">
            {if !empty($curVendor->titlecol2)}<span>{$curVendor->titlecol2}</span>{/if}
            {if !empty($curVendor->desccol2)}{$curVendor->desccol2}{/if}
        </div>
        <div class="articlescol">
            {if !empty($curVendor->titlecol3)}<span>{$curVendor->titlecol3}</span>{/if}
            {if !empty($curVendor->desccol3)}{$curVendor->desccol3}{/if}
        </div>
    </div>

</div>
{/strip}
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
    initEditCategoryInline(fpcid);
});
</script>
{/literal}
