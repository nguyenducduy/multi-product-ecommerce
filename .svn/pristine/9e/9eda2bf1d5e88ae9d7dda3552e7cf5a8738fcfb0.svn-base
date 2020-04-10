
<div id="panelleft">
	<div class="checkoutsummary">
		<h3>{$lang.controller.yourcartHeading}</h3>
	
		<table class="cartsmall" cellspacing="0">
			{foreach item=item from=$items}
				<tr>
					<td>{$item->book->title} (&times; {$item->quantity})</td>
					<td width="5"></td>
					<td width="70" align="right">{$item->subtotal|formatprice}</td>
				</tr>
			{/foreach}
		
			<tfoot class="bold boldsuper">
				<tr>
					<td align="right"><em>{$lang.controller.pricefinal}: </em></td>
					<td></td>
					<td class="total" align="right"><big>{if $pricefinal > 0}{$pricefinal|formatprice}{else}{$lang.controller.pricefinalFree}{/if}</big></td>
				</tr>
			</tfoot>
			
			
			
			<tfoot class="bold">
				<tr>
					<td align="right"><em>{$lang.default.cartTotal}: </em></td>
					<td></td>
					<td class="total" align="right">{$pricetotal|formatprice}</td>
				</tr>
			</tfoot>
			
			<tfoot class="bold">
				<tr>
					<td align="right"><em>{$lang.controller.priceship}: </em></td>
					<td></td>
					<td class="total" align="right">{$priceship|formatprice}</td>
				</tr>
			</tfoot>
			
			{if $pricediscount > 0}
			<tfoot class="bold">
				<tr>
					<td align="right"><em>{$lang.controller.pricediscount} ({$pricediscountDetail}): </em></td>
					<td></td>
					<td class="total" align="right">- {$pricediscount|formatprice}</td>
				</tr>
			</tfoot>
			{/if}
			
			
			{if $pricediscountxu > 0}
			<tfoot class="bold">
				<tr>
					<td align="right"><em>{$lang.controller.pricediscountxu}: </em></td>
					<td></td>
					<td class="total" align="right">- {$pricediscountxu|formatprice}</td>
				</tr>
			</tfoot>
			{/if}
			
			
		</table>
		
		
	
		<h3>{$lang.controller.billingHeading}</h3>
		<p style="line-height:1.5;">
			<strong>{$smarty.session.checkoutInfo.billingfullname|upper}</strong><br />
			{$smarty.session.checkoutInfo.email}<br />
			{$smarty.session.checkoutInfo.billingphone}<br />
			{$smarty.session.checkoutInfo.billingaddress}, {$smarty.session.checkoutInfo.billingregion|regionname}<br />
		</p>
		
	</div>
		
</div><!-- end #panelleft -->


<div id="panelright">
	
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="checkoutindicator">
		<div class="bar"><span style="width:240px;"></span></div>
		<ul>
			<li><a href="{$conf.rooturl}cart" class="done"><strong>1</strong><span>{$lang.controller.progressCart}</span></a></li>
			<li><a href="{$conf.rooturl}checkout" class="done"><strong>2</strong><span>{$lang.controller.progressBilling}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/payment" class="active"><strong>3</strong><span>{$lang.controller.progressPayment}</span></a></li>
			<li><a {if $smarty.session.checkoutStep4Enable == 1}href="{$conf.rooturl}checkout/review" class="activenext" {else}href="javascript:void(0)"{/if}><strong>4</strong><span>{$lang.controller.progressReview}</span></a></li>
			<li><a href="javascript:void(0)"><strong>5</strong><span>{$lang.controller.progressFinish}</span></a></li>
		</ul>
		<div class="cl"></div>
	</div>
	
	<div id="loginform" class="myform myformwide stylizedform">
		
		
		
		<form id="form1" name="form1" method="post" action="">
			
			<h1>{$lang.controller.titleShipping}</h1>
			<label>&nbsp;</label>
			<label class="normal"><input class="checkbox" type="radio" name="fshippingmethod" value="1" checked="checked" />&nbsp; <big>{$priceshipDetail} . {if $priceship > 0}{$lang.controller.shippricelabel}: <u>{$priceship|formatprice}</u>. {/if}</big><a href="javascript:void(0)" class="tipsy-trigger" title="{$lang.controller.shippingNormalMore}"><img src="{$imageDir}help.png" /></a></label>
			<div class="clear"></div>
			<br />
			
			
			
			<h1>{$lang.controller.titlePayment}</h1>
			

			<label>&nbsp;</label>
			<label class="normal"><input class="checkbox" type="radio" name="fpaymentmethod" value="1" {if $formData.fpaymentmethod == 1}checked="checked"{/if} {if $formData.fsubmit == ''}checked="checked"{/if} />&nbsp; <big>{$lang.controller.paymentCod}</big><a href="javascript:void(0)" class="tipsy-trigger" title="{$lang.controller.paymentCodMore}"><img src="{$imageDir}help.png" /></a></label>
			<div class="clear"></div>
			
			
			<label>&nbsp;</label>
			<label class="normal"><input class="checkbox" type="radio" name="fpaymentmethod" value="2" {if $formData.fpaymentmethod == 2}checked="checked"{/if}/>&nbsp; <big>{$lang.controller.paymentBank}</big><a href="javascript:void(0)" class="tipsy-trigger" title="{$lang.controller.paymentBankMore}"><img src="{$imageDir}help.png" /></a></label>
			<div class="clear"></div>

			
			<br />
			<h1>{$lang.controller.titleCoupon}</h1>
				
			<label>&nbsp;</label>
			<label class="normal"><big>- {$lang.controller.discountCoupon}</big></label>
				<div class="checkoutpaymenthelp">
					<input type="text" name="fcouponcode" class="inputshort tipsy-trigger" title="{$lang.controller.discountCouponMore}" value="{$formData.fcouponcode}" />
					<input type="submit" class="button inputshort checkoutapplybtn" name="fsubmitcoupon" value="{$lang.controller.apply}" />
				</div>
			<div class="clear"></div>
			
			<label>&nbsp;</label>
			<label class="normal"><big>- {$lang.controller.isUseXu}</big></label>
				<div class="checkoutpaymenthelp">
					<input type="text" name="fxu" class="inputshort tipsy-trigger" title="{$lang.controller.isUseXuHelp} {$me->xu|formatprice})" value="{$formData.fxu}" />
					<input type="submit" class="button inputshort checkoutapplybtn" name="fsubmitxu" value="{$lang.controller.apply}" />
				</div>
			<div class="clear"></div>
				
			<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
			<div class="spacer"></div>
			
	  </form>
  </div>
	
</div><!-- end #panelright -->


		

