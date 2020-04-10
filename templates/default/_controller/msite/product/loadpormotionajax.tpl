{if !empty($productDetail)}
	{if $productDetail->onsitestatus == $OsERPPrepaid && $productDetail->prepaidstartdate <= $currentTime && $productDetail->prepaidenddate >= $currentTime}
	    <div class="dienmay">
		    <div class="textdienmay">Giá dự kiến:</div>
		    <div class="pricedienmay"><span>{if $productDetail->prepaidprice > 1000}{$productDetail->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
		</div>		                
		<div class="expected">Hàng sắp về, dự kiến có hàng ngày {$productDetail->prepaidenddate|date_format:"%d/%m/%Y"}</div>     
	
	{elseif $productDetail->onsitestatus == $OsERP}
	    {if $productDetail->displaysellprice!=1 &&  $productDetail->sellprice > 0 &&  !empty($promotionprice) && $promotionprice<$productDetail->sellprice}
	    
			<div class="genuine">
			    <div class="textgenuine">Giá chính hãng:</div>
			    <div class="pricegenuine"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if}đ</span></div>
			</div>
			<div class="dienmay">
			    <div class="textdienmay">Giá bán tại dienmay.com:</div>
			    <div class="pricedienmay"><span>{if $promotionprice > 1000}{$promotionprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
			</div>	                
			<div class="econo">
			    <div class="textecono">Tiết kiệm được:</div>
			    {if $productDetail->sellprice > 1000}
			        {assign var="finalprice" value=$productDetail->sellprice}
			    {else}{assign var="finalprice" value=1000}{/if}
			    <div class="priceecono"><span>{math|number_format equation="x - y" x=$finalprice y=$promotionprice format="%.0f"}đ</span></div>
			</div>
	    {elseif $productDetail->sellprice > 0}		                
			<div class="dienmay">
			    <div class="textdienmay">Giá bán tại dienmay.com:</div>
			    <div class="pricedienmay"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if}đ</span></div>
			</div>	                	
	    {/if}
	{elseif $productDetail->sellprice > 0}	                
	    <div class="dienmay">
			<div class="textdienmay">Giá bán tại dienmay.com:</div>
			<div class="pricedienmay"><span>{if  $productDetail->sellprice > 1000}{$productDetail->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if}đ</span></div>
		</div>
	{/if}
	{if !empty($joinpromotion)}
		<div class="gift-2">
			<p>KHUYẾN MÃI ĐƯỢC ÁP DỤNG KÈM:</p>
			{$joinpromotion}
		</div>
	{/if}
{/if}