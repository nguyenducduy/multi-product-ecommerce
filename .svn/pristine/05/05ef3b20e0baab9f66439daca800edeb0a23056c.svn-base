<ul class="navbarprod">
    <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ</a> ››</li>
    <li><a href="{$curVendor->getVendorPath()}" title="{$curVendor->name}">{$curVendor->name}</a></li>
    <!--<li>Tên sản phẩm ››</li>-->
    <li class="lastitem"><p><i class="icon-mobile2"></i>Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></p></li>
</ul>

<div id="container">
{$producttop}
    <div id="wrapdepart">
		<div class="barparent">
			<h2 class="titlebarparent">Các sản phẩm của nhà sản xuất {$curVendor->name}</h2>
		</div>
		<div class="products">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			{if !empty($listproductcat)}
				<ul>
					{foreach from=$listproductcat item=product name=ProductsByCategory}
						{assign var="promotionprices" value=$product->promotionPrice()}
						{if $product->displaytype == $productdisplaybanner || $product->displaytype == $productdisplaytext}
				  			<li class="tagcentertext">
				  			{if !empty($product->productspecial) && $product->displaytype == $productdisplaybanner}
				  				<a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}" class="imagespecial"><img src="{$product->productspecial->getImage()}" alt="{$product->name}" width="375" height="205" class="bigspecialimage" /></a>
							{else}
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
							      {if !empty($product->productspecial) && $product->displaytype == $productdisplaytext}
								      <a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><img src="{$product->productspecial->getImage()}" alt="{$product->name}" /></a>					      		
								      {else}
								      <a href="{$product->getProductPath()}" title="{if !empty($product->seotitle)}{$product->seotitle}{else}{$product->name}{/if}"><img src="{$product->getImage()}" alt="{$product->name}" /></a>
								      {/if}
						      		<div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
						      		{if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
				                		<strong class="pricenew">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
				                		{if $product->sellprice > 1000}<div class="th_center">{$product->sellprice|number_format} đ</div>{else}<div class="th_center">{$lang.default.promotionspecial} đ</div>{/if}
					                {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
				                		<strong class="pricenew">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
					                {elseif $product->sellprice >0}
				                		<strong class="pricenew">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</strong>
					                {/if}
					                </div>
							      <div class="descenter">
						      		{$product->summary}
							      </div>
							      {if !empty($promotionprices.promodescription) && $promotionprices.promodescription|strip_tags|trim != '.' && $promotionprices.promodescription|strip_tags|trim != '-'}
						      		<div class="giftcenter"><i class="icon-gift"></i>{$promotionprices.promodescription}</div>
							      {/if}
							      
						    {/if}
						    {if $product->onsitestatus == $OsERP && $product->instock > 0 && $product->sellprice > 0}							      
								      <!-- <div class="buynownew"></div>
								      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
								      <!--<div class="salemethod">Chỉ bán online</div>-->
							      {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
						      		<div class="buynownew"></div>
								    <a href="javascript:void(0)" class="textbuynow buyprepaid" rel="{$product->id}" title="Đặt hàng trước">Mua</a>
						      		<div class="salemethod">Đặt hàng trước</div>
							      {else}
						      		<div class="salemethod">Hết hàng</div>
							      {/if}
						    </li>
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
							      <!-- <div class="buynownew"></div>
							      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
							      <!--<div class="salemethod">Chỉ bán online</div>-->
						      {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
						      	<div class="buynownew"></div>
							    <a href="javascript:void(0)" class="textbuynow buyprepaid" rel="{$product->id}" title="Đặt hàng trước">Mua</a>
						      	<div class="salemethod">Đặt hàng trước</div>
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
				  		{/if}
					{/foreach}
				</ul>
				{assign var="pageurl" value="page-::PAGE::"}
   				{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl``$joinpaginationlink`"}
			{else}
				Nhà sản xuất này hiện thời chưa có sản phẩm
			{/if}
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
