{*<ul class="navbarprod">
    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
    <li><a href="{$curVendor->getVendorPath()}" title="{$curVendor->name}">{$curVendor->name}</a></li>
    <!--<li>Tên sản phẩm ››</li>-->
    <li class="lastitem"><p><i class="icon-mobile2"></i>Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></p></li>
</ul>*}

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
        <div class="products">
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
            {if !empty($listproductcat)}
                <ul>
                    {foreach from=$listproductcat item=product name=ProductsByCategory}
                        {assign var="promotionprices" value=$product->promotionPrice()}

                            <li>
                                {if $product->isbagdehot == 1 || $product->isbagdenew == 1 || $product->isbagdegift == 1}
                                    <div class="special">
                                        {if $product->isbagdehot == 1}
                                            <i class="icon-hot"></i>
                                        {elseif $product->isbagdenew == 1}
                                            <i class="icon-new"></i>
                                        {elseif $product->isbagdegift == 1}
                                            <i class="icon-gift"></i>
                                        {/if}
                                    </div>
                                {/if}
                                <a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle|escape}{else}{$product->name|escape}{/if}"><img src="{$product->getSmallImage()}" alt="{$product->name|escape}" /> </a>
                                <a class="position-a" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle|escape}{else}{$product->name}{/if}">{$product->name|escape} </a>
                                <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
                                {if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
                                    <div class="priceold">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                    <div class="pricenew">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                                    <div class="pricenew">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                {elseif $product->sellprice >0}
                                    <div class="pricenew">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
                                {/if}
                                </div>

                                {if $product->onsitestatus == $OsERP && $product->instock > 0 && $product->sellprice > 0}
                                    <!--<div class="buynownew"></div>
                                     <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
                                    <!--<div class="salemethod">Chỉ bán online</div>-->
                                {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
                                    <div class="buynownew"></div>
                                    <a href="javascript:void(0)" class="textbuynow buyprepaid" rel="{$product->id}" title="Đặt hàng trước">Mua</a>
                                    <div class="salemethod">Đặt hàng trước</div>
                                {elseif $product->onsitestatus == $OsCommingSoon}
			  						<div class="salemethod">Hàng sắp về</div>								  
								  {else}
                                    <div class="salemethod">Hết hàng</div>
                                {/if}
                                {if !empty($product->listgallery)}
                                    <ul class="circlegallery">
                                        {foreach from=$product->listgallery item=lgal}
                                            <li>{$lgal->getSmallImage()}</li>
                                        {/foreach}
                                        {if $product->image!=''}
                                            <li>{$product->getSmallImage()}</li>
                                        {else}
                                            <li>{$currentTemplate}images/site/default/default.jpg</li>
                                        {/if}
                                    </ul>
                                {/if}
                            </li>

                    {/foreach}
                </ul>
                {assign var="pageurl" value="page-::PAGE::"}
                {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl``$joinpaginationlink`"}
            {else}
                <p class="brandnotpro">Nhà sản xuất này hiện thời chưa có sản phẩm</p>
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
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
    initEditCategoryInline(fpcid);
});
</script>
{/literal}
