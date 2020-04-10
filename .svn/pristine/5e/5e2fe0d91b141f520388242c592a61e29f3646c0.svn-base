<div align="left" style="padding:20px;background:#ffffff;">
<div align="left">
<table width="100%" style="border-bottom:2px solid #444444;font-family:Arial, Helvetica, sans-serif;">
	<tr>
  	<td align="left" valign="bottom">
    	<div style="font-weight:bold;font-size:18px;">{$lang.controller.printHeading|upper} #{$myOrder->invoiceid}</div>
       
      </td>
    <td align="right" valign="bottom">Hotline: {if $myOrder->id > 26}{$setting.store.hotline}{else}0938916902{/if}</td>
  </tr>
</table>
<table cellspacing="8" cellpadding="5" style="font-family:Arial, Helvetica, sans-serif">
	<tr>
  	<td width="150" style="font-weight:bold;">{$lang.controller.printOrderOnLabel}:</td>
    <td>{$myOrder->datecreated|date_format:"%H:%M, %d/%m/%Y"}</td>
  </tr>

	{if $myOrder->dateshipped > 0}
		<tr>
	  		<td width="150" style="font-weight:bold;">{$lang.controller.dateshipping}:</td>
		    <td>{$myOrder->dateshipped|date_format:"%H:%M, %d/%m/%Y"}{if $myOrder->shippingtrackingcode != ''}({$lang.controller.trackingcode}: <strong>{$myOrder->shippingtrackingcode}</strong> - <a href="http://tracuudinhvi.hcmpost.vn/dv/default.aspx" target="_blank" title="{$lang.controller.trackingcodeviewTitle}"><small>[{$lang.controller.trackingcodeview}]</small></a>){/if}</td>
		  </tr>
	{/if}

{if $myOrder->datecompletedestimate > 0}
	<tr>
  	<td width="150" style="font-weight:bold;">{$lang.controller.datecompletedestimate}:</td>
    <td><u>{$myOrder->datecompletedestimate|date_format:"%H:%M, %d/%m/%Y"}</u></td>
  </tr>
{/if}
  <tr>
  	<td width="150" style="font-weight:bold;">{$lang.controller.status}:</td>
    <td><span style="{if $myOrder->status == 12}font-weight:bold;border-bottom:dashed 1px #000000;{/if}"><b><big>{$myOrder->getStatusName()|upper}</big></b>
	{if $myOrder->status == 12}<img alt="" src="{$imageDir}/tick.png">{/if}</span></td>
  </tr>
  
  <tr>
  	<td style="font-weight:bold;" valign="top">{$lang.controller.shippingInfo}:</td>
	<td>
    	<p style="line-height:1.5;"><b><big>{$myOrder->shippingfullname|upper}</big></b><br />
			{$lang.controller.phone}: {$myOrder->shippingphone}<br />
			{$lang.controller.email}: {$myOrder->contactemail}
		</p>
    </td>
  </tr>

	<tr>
	  	<td style="font-weight:bold;" valign="top">{$lang.controller.shippingtype}:</td>
		<td>
			<p style="line-height:1.5;"><b><big>{$myOrder->getShippingName()|upper}</big></b><br />
				{$lang.controller.address}: {$myOrder->shippingaddress}, {$myOrder->subregion->name}, {$myOrder->region->name}
			</p>
	    </td>
	  </tr>

<tr>
  	<td style="font-weight:bold;" valign="top">{$lang.controller.paymenttype}:</td>
	<td>
    	<p style="line-height:1.5;"><b><big>{$myOrder->getPaymentName()|upper}</big></b></p>
    </td>
  </tr>

{if $myOrder->note != ''}
  <tr>
 	<td style="font-weight:bold;" valign="top">{$lang.controller.note}: </td>
    <td valign="top" align="left">
        {$myOrder->note|nl2br|default:'N/a'}
       
    </td>
  </tr>
{/if}
</table>



<br/><br/>
<table cellspacing="8" width="100%" style="border-bottom:2px solid #444444;font-family:Arial, Helvetica, sans-serif;">
	<tr>
  	<td align="left" valign="bottom">
    	<div style="font-weight:bold;font-size:16px;">{$lang.controller.printPaymentDetail|upper}</div>
      </td>
    <td align="right" valign="bottom"></td>
  </tr>
</table>
<table class="cart" width="100%" cellpadding="8" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;">
		<thead>
			<tr style="background:#eee;">
				<th width="30">{$lang.controller.cartitemImage}</th>
				<th align="left">{$lang.controller.cartitemTitle}</th>
				<th width="60">{$lang.controller.cartitemPrice}</th>
				<th width="12"></th>
				<th width="60">{$lang.controller.cartitemQuantity}</th>
				<th width="12"></th>
				<th width="80" align="right">{$lang.controller.cartitemSubtotal}</th>
			</tr>
		</thead>
		<tbody>
			{foreach item=item from=$items}
				<tr>
					<td align="center"><a href="{$item->book->getBookPath()}" target="_blank"><img src="{$item->book->getSmallImage()}" alt="Cover" class="cover" width="50" /></a></td>
					<td><strong>{$item->book->title}</strong> - <em>{$item->book->author}</em>{if $me->isGroup('administrator') || $me->isGroup('moderator')}
						<div class="bookpartner"><br /><small style="color:#ccc">{$item->book->getPartnerName()}</small><a href="javascript:void(0)" onclick="$('.bookpartner').hide()" title="Click to Hide book company information">(Hide)</a> -- <a href="{$item->book->getBookPath()}" target="_blank">View Info</a></div>
						{/if}</td>
					<td align="center">{$item->pricefinal|formatprice}</td>
					<td align="center">&times;</td>
					<td align="center">{$item->quantity}</td>
					<td align="center">=</td>
					<td align="right">{$item->subtotal|formatprice}</td>
				</tr>
			{/foreach}
		</tbody>

		
		<tfoot class="bold boldsuper">
			<tr>
				<td align="right" colspan="5" style="border-top:1px solid #555;"><em>{$lang.controller.pricefinal}: </em></td>
				<td style="border-top:1px solid #555;"></td>
				<td class="total" align="right" style="border-top:1px solid #555;"><big><strong>{if $myOrder->pricefinal > 0}{$myOrder->pricefinal|formatprice}{else}{$lang.controller.pricefinalFree}{/if}</strong></big></td>
			</tr>
		</tfoot>
		

		<tfoot class="review reviewtop">
			<tr>
				<td colspan="5" align="right"><em>{$lang.default.cartTotal}:</em> </td>
				<td></td>
				<td align="right"><span class="total">{$myOrder->pricesell|formatprice}</span></td>
			</tr>
		</tfoot>
		
		<tfoot class="review">
			<tr>
				<td align="right" colspan="5"><em>{$lang.controller.priceship}: </em></td>
				<td></td>
				<td class="total" align="right">{if $myOrder->priceship > 0}{$myOrder->priceship|formatprice}{else}{$lang.controller.pricefinalFree}{/if}</td>
			</tr>
		</tfoot>

		{if $myOrder->pricediscount > 0}
		<tfoot class="review">
			<tr>
				<td align="right" colspan="5"><em>{$lang.controller.pricediscount}: </em></td>
				<td></td>
				<td class="total" align="right">- {$myOrder->pricediscount|formatprice}</td>
			</tr>
		</tfoot>
		{/if}


		{if $myOrder->pricediscountxu > 0}
		<tfoot class="review">
			<tr>
				<td align="right" colspan="5"><em>{$lang.controller.pricediscountxu}: </em></td>
				<td></td>
				<td class="total" align="right">- {$myOrder->pricediscountxu|formatprice}</td>
			</tr>
		</tfoot>
		{/if}
		


</table>


</div>
</div>



