
<div id="panelleft">
	
		
</div><!-- end #panelleft -->


<div id="panelright">
	
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	<div class="checkoutindicator">
		<div class="bar"><span style="width:360px;"></span></div>
		<ul>
			<li><a href="{$conf.rooturl}cart" class="done"><strong>1</strong><span>{$lang.controller.progressCart}</span></a></li>
			<li><a href="{$conf.rooturl}checkout" class="done"><strong>2</strong><span>{$lang.controller.progressBilling}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/payment" class="done"><strong>3</strong><span>{$lang.controller.progressPayment}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/review" class="active"><strong>4</strong><span>{$lang.controller.progressReview}</span></a></li>
			<li><a href="javascript:void(0)"><strong>5</strong><span>{$lang.controller.progressFinish}</span></a></li>
		</ul>
		<div class="cl"></div>
	</div>
	
	
	<div class="shelf">
		<h1 class="head">{$lang.controller.titleReviewInfo}</h1>
	</div><!-- end .shelf -->
	
	<div id="loginform" class="myform myformwide stylizedform checkoutreview">
		{if $bookforuser->id != $me->id}
			<label>Book For Specified User : </label>
			<div class="text text_nowidth" style="color:#f90;"><strong>{$bookforuser->fullname} #{$bookforuser->id} &lt;{$bookforuser->email}&gt; </strong><a href="{$bookforuser->getUserPath()}" title="Go to profile">[Profile]</a></div>
			<div class="clear"></div>
		{/if}
		
		<label>{$lang.controller.fullname} : </label>
		<div class="text text_nowidth"><strong><b>{$smarty.session.checkoutInfo.billingfullname|upper}</b></strong></div>
		<div class="clear"></div>
		
		
		
		<label>{$lang.controller.email} : </label>
		<div class="text text_nowidth"><strong>{$smarty.session.checkoutInfo.email}</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.phone} : </label>
		<div class="text text_nowidth"><strong>{$smarty.session.checkoutInfo.billingphone}</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.address} : </label>
		<div class="text text_nowidth"><strong>{$smarty.session.checkoutInfo.billingaddress}{if $mySubregion->id > 0}, {$mySubregion->name}{/if}, {$myRegion->name}.</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.shipping} : </label>
		<div class="text text_nowidth"><strong>{$priceshipDetail}.</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.payment} : </label>
		<div class="text text_nowidth"><strong>
			{if $smarty.session.checkoutInfo.paymentmethod == 1}
				{$lang.controller.paymentCod}
			{elseif $smarty.session.checkoutInfo.paymentmethod == 2}
				{$lang.controller.paymentBank}
			{else}
				Payment Type Not Found.
			{/if}
		</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.dateorder} : </label>
		<div class="text text_nowidth"><strong>{$smarty.now|date_format:"%H:%M, %d/%m/%Y"}</strong></div>
		<div class="clear"></div>
		
		<label>{$lang.controller.note} : </label>
		<div class="text text_nowidth"><strong>{if $smarty.session.checkoutInfo.note != ''}{$smarty.session.checkoutInfo.note}{else}<em>{$lang.controller.noteempty}</em>{/if}</strong></div>
		<div class="clear"></div>
		
		
		
		
	</div>

	
	
	<div class="shelf">
		<h1 class="head">{$lang.controller.titleReview}</h1>
	</div><!-- end .shelf -->
		
		
		
		<form id="form1" name="form1" method="post" action="">
			
				<table class="cart" cellpadding="5" cellspacing="0">
					<thead>
						<tr>
							<th width="30">{$lang.controller.cartitemImage}</th>
							<th align="left">{$lang.controller.cartitemTitle}</th>
							<th width="60">{$lang.controller.cartitemPrice}</th>
							<th width="20"></th>
							<th width="50">{$lang.controller.cartitemQuantity}</th>
							<th width="20"></th>
							<th width="100" align="right">{$lang.controller.cartitemSubtotal}</th>
						</tr>
					</thead>
					<tbody>
						{foreach item=item from=$items}
							<tr>
								<td align="center"><a href="{if $isPopup}javascript:void(0){else}{$item->book->getBookPath()}{/if}" class="tipsy-hovercard-trigger" data-url="{$item->book->getHovercardPath()}" ><img src="{$item->book->getSmallImage()}" alt="Cover" class="cover" /></a></td>
								<td><a href="{if $isPopup}javascript:void(0){else}{$item->book->getBookPath()}{/if}" class="tipsy-hovercard-trigger title" data-url="{$item->book->getHovercardPath()}" >{$item->book->title}</a></td>
								<td align="center">{$item->pricereal|formatprice}</td>
								<td align="center">&times;</td>
								<td align="center">{$item->quantity}</td>
								<td align="center">=</td>
								<td align="right">{$item->subtotal|formatprice}</td>
							</tr>
						{/foreach}
					</tbody>

					
					<tfoot class="bold boldsuper">
						<tr>
							<td align="right" colspan="5"><em>{$lang.controller.pricefinal}: </em></td>
							<td></td>
							<td class="total" align="right"><big>{if $pricefinal > 0}{$pricefinal|formatprice}{else}{$lang.controller.pricefinalFree}{/if}</big></td>
						</tr>
					</tfoot>
					

					<tfoot class="review reviewtop">
						<tr>
							<td colspan="5" align="right"><em>{$lang.default.cartTotal}:</em> </td>
							<td></td>
							<td align="right"><span class="total">{$pricetotal|formatprice}</span></td>
						</tr>
					</tfoot>
					
					<tfoot class="review">
						<tr>
							<td align="right" colspan="5"><em>{$lang.controller.priceship}: </em></td>
							<td></td>
							<td class="total" align="right">{$priceship|formatprice}</td>
						</tr>
					</tfoot>

					{if $pricediscount > 0}
					<tfoot class="review">
						<tr>
							<td align="right" colspan="5"><em>{$lang.controller.pricediscount} ({$pricediscountDetail}): </em></td>
							<td></td>
							<td class="total" align="right">- {$pricediscount|formatprice}</td>
						</tr>
					</tfoot>
					{/if}


					{if $pricediscountxu > 0}
					<tfoot class="review">
						<tr>
							<td align="right" colspan="5"><em>{$lang.controller.pricediscountxu}: </em></td>
							<td></td>
							<td class="total" align="right">- {$pricediscountxu|formatprice}</td>
						</tr>
					</tfoot>
					{/if}
					

				</table>
			
			
			
			
	  
	
	<br />
	<br />
		
	<input type="submit" class="submit" id="checkoutfinishbtn" name="fsubmit" value="{$lang.controller.submitfinish}" />
	<div class="spacer"></div>
	
	<br />
	<br />
	</form>
	
</div><!-- end #panelright -->


		

