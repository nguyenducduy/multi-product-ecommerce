<div class="navbarprod">
    <ul>
        <li><a href="{$conf.rooturl}" title="Dienmay.com">Trang chủ</a> ››</li>
        <li><a href="{$curCategory->getProductcateoryPath()}" title="{if !empty($curCategory->seotitle)}{$curCategory->seotitle}{else}{$curCategory->name}{/if}">{$curCategory->name} </a> ››</li>
        {if !empty($myVendor)}
        	<li><a href="{$myVendor->getVendorPath($curCategory->id)}" title="{$myVendor->name}">{$myVendor->name} </a> ››</li>
        {/if}
        <li>Tìm kiếm
        	{if !empty($attributeList['DELETEDURL'])}
        		{foreach from=$attributeList['DELETEDURL'] item=delurl name=namedelurl}
        			{$delurl.name}
        			{if $smarty.foreach.namedelurl.last}{else},{/if}
        		{/foreach}
        	{/if}
        </li>
        <li class="lastitem"><p><i class="icon-mobile2"></i>Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></p></li>
    </ul>
</div>
<div id="container">
{$producttop}
    <div id="wrapdepart">
		<div class="barparent">
			<h2 class="titlebarparent">{$curCategory->name}</h2>
		</div>
		<div class="products">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			{if !empty($listproductcat)}
				<ul>
					{foreach from=$listproductcat item=product name=ProductsByCategory}
						{assign var="promotionprices" value=$product->promotionPrice()}
						{if !empty($product->productspecial)}
				  			<li class="tagcentertext">
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
							  <a class="textafloat" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}">{$product->name}</a>
						      <a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><img src="{$product->productspecial->getImage()}" alt="{$product->name}" /></a>
						      	{if $product->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
					                <strong>{$promotionprices.price|number_format} đ</strong>
					            {else}
					                <strong>{$product->sellprice|number_format} đ</strong>
					            {/if}
						      <div class="descenter">
						      	{$product->summary}
						      </div>
						      {if !empty($promotionprices.promodescription)}
						      	<div class="giftcenter"><i class="icon-gift"></i>{$promotionprices.promodescription}</div>
						      {/if}
						      <!-- <div class="buynownew"></div>
						      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.id)}&prid={$product->barcode|trim}_{$promotionprices.id}{/if}" class="textbuynow" title="Mua">Mua</a>
						    </li> -->
				  		{else}
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
				  			  <a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><img src="{$product->getSmallImage()}" alt="{$product->name}" /> </a>
			                  <a class="position-a" href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}">{$product->name} </a>
						      {if $product->displaysellprice!=1 && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
				                	<div class="priceold">{$product->sellprice|number_format} đ</div>
			                    	<div class="pricenew">{$promotionprices.price|number_format} đ</div>
				                {else}
				                	<div class="pricenew">{$product->sellprice|number_format} đ</div>
				                {/if}
						      <!-- <div class="buynownew"></div>
						      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.id)}&prid={$product->barcode|trim}_{$promotionprices.id}{/if}" class="textbuynow" title="Mua">Mua</a> -->
						    </li>
				  		{/if}
					{/foreach}
				</ul>
				{assign var="pageurl" value="page-::PAGE::"}
   				{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl``$joinpaginationlink`"}
			{else}
				Danh mục này hiện thời chưa có sản phẩm
			{/if}
		</div>
	</div>
</div>
<div class="articlesseo">
	<div class="articlescol">
    	{if !empty($curCategory->titlecol1)}<span>{$curCategory->titlecol1}</span>{/if}
        {if !empty($curCategory->desccol1)}{$curCategory->desccol1}{/if}
    </div>
    <div class="articlescol">
    	{if !empty($curCategory->titlecol2)}<span>{$curCategory->titlecol2}</span>{/if}
        {if !empty($curCategory->desccol2)}{$curCategory->desccol2}{/if}
    </div>
    <div class="articlescol">
    	{if !empty($curCategory->titlecol3)}<span>{$curCategory->titlecol3}</span>{/if}
        {if !empty($curCategory->desccol3)}{$curCategory->desccol3}{/if}
    </div>
</div>
{literal}
<script type="text/javascript">
var fpcid = "{/literal}{$curCategory->id}{literal}";
$(document).ready(function(){
    //initEditCategoryInline(fpcid);
});
</script>
{/literal}