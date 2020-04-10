<div class="wrap-advice">
<p style="color:#00a1e6"><i class="icon-advice"></i>Tư vấn chọn sản phẩm</p>
{if !empty($relProductProduct)}
<ul>
    {foreach item=product from=$relProductProduct}
    <li>
        <a href="javascript:parent.location.href='{$product->getProductPath()}'" title="{$product->name}"><img src="{$product->getSmallImage()}"  alt="{$product->name}" /> </a>
        <a href="javascript:parent.location.href='{$product->getProductPath()}'" title="{$product->name}">{$product->name}</a>
        <div class="pricenew">{$product->sellprice|number_format}</div>
        {*$product->summary*}
        <div class="buynow2 maradv"><a href="javascript:parent.location.href='{$conf.rooturl|urlencode}cart/checkout?id={$product->id}'" id="buypress" rel="nofollow">Mua ngay</a></div>
        
        <!--<div class="compadv"><a href="#"><i class="icon-comp"></i>So sánh</a></div>-->
    </li>
    {/foreach}
</ul>

<div class="advicegood">
    <p class="advtitle">Ưu điểm</p>
{foreach item=product from=$relProductProduct}
    <div style="width:266px">
        {$product->good|strip_tags|nl2br}
    </div>
{/foreach}
</div>
<div class="advicebad">
    <p class="advtitle">Nhược điểm</p>
{foreach item=product from=$relProductProduct}
    <div style="width:265px">
        {$product->bad|strip_tags|nl2br}
    </div>
{/foreach}
</div>
<div class="advicepreview">
    <p class="advtitle">Đánh giá</p>
{foreach item=product from=$relProductProduct}
    <div style="width:265px">
        {$product->dienmayreview|strip_tags|nl2br}
    </div>
{/foreach}
</div>
{else}
<p align="center">Không có sản phẩm nào để tư vấn cho sản phẩm hiện tại của bạn.</p>
{/if}
</div>