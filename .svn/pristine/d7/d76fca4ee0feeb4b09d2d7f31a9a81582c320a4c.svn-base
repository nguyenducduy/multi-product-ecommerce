{if !empty($productDetail)}
	{if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
	    <div class="dienmay">
            <div class="textdienmay">Giá dự kiến:</div>
            <div class="pricedienmay"><span class="pricenew">{if $productDetail->prepaidprice > 1000}{$productDetail->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
        </div>
        <div class="datesatus dattruoc"><i>Dự kiến có hàng:</i><strong>{$productDetail->prepaidenddate|date_format:"%d/%m/%Y"}</strong> <span>(Còn {(($productDetail->prepaidenddate - time())/(24*3600))|round} ngày)</span></div>

	{elseif $productDetail->onsitestatus == $OsERP || $productDetail->onsitestatus == $OsCrazySale || $productDetail->onsitestatus == $OsHot || $productDetail->onsitestatus == $OsNew || $productDetail->onsitestatus == $OsBestSeller}
	    {if $productDetail->displaysellprice!=1 &&  $productDetail->sellprice > 0 &&  !empty($promotionprice) && $promotionprice<$productDetail->sellprice}
    	<div class="wrapdienmay">
          	<div class="dienmay">
			    <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
			    <div class="pricedienmay"><span>{if $promotionprice > 1000}{$promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
			</div>
			<div class="genuine">
			    <div class="textgenuine">Giá thị trường:</div>
			    <div class="pricegenuine"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span>
			    </div>
			</div>
		</div>
		<div class="econo">
		    <div class="textecono">Bạn tiết kiệm được:</div>
		    {if $productDetail->sellprice > 1000}
		        {assign var="finalprice" value=$productDetail->sellprice}
		    {else}{assign var="finalprice" value=1000}{/if}
		    <div class="priceecono"><span>{math|number_format equation="x - y" x=$finalprice y=$promotionprice format="%.0f"} đ</span> (  <span class="persale"> -{(($productDetail->sellprice - $promotionprice)/$productDetail->sellprice * 100)|floor}%</span> )</div>
		</div>
		<div class="clear"></div>
	    {elseif $productDetail->sellprice > 0}
			<div class="dienmay">
			    <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
			    <div class="pricedienmay"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
			</div>
	    {/if}
	{elseif $productDetail->sellprice > 0}
	    <div class="dienmay">
			<div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
			<div class="pricedienmay"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
		</div>
	{/if}
	{*if !empty($joinpromotion)}
		<div class="gift-2">
			<p>KHUYẾN MÃI ĐƯỢC ÁP DỤNG KÈM:</p>
			{$joinpromotion}
		</div>
	{/if*}
{/if}