<div align="left" style="padding:20px;background:#ffffff;">
<div align="left">
	
	
{foreach item=partnerdata key=partnerid from=$booklist}
{assign var=myPartner value=$partnerList.$partnerid}
<table width="100%" style="border-bottom:2px solid #444444;font-family:Arial, Helvetica, sans-serif;">
	<tr>
  	<td align="left" valign="bottom">
    	<div style="font-weight:bold;font-size:12px;">{$myPartner->name|upper}</div>
       
      </td>
  </tr>
</table>
<table class="cart" width="100%" cellpadding="8" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;">
		<thead>
			<tr style="background:#eee;">
				<th width="70">Image</th>
				<th align="left">Title</th>
				<th width="60">Price</th>
				<th width="12"></th>
				<th width="60">Quantity</th>
				<th width="100">Appear In Orders</th>
			</tr>
		</thead>
		<tbody>
			{foreach item=item from=$partnerdata}
				<tr>
					<td align="center"><a href="{$item.book->getBookPath()}" target="_blank"><img src="{$item.book->getSmallImage()}" alt="Cover" class="cover"  /></a></td>
					<td><strong>{$item.book->title}</strong> - <em>{$item.book->author}</em>
						<br /><a href="{$item.book->getBookPath()}" target="_blank">View Info</a> | <a href="{$conf.rooturl_admin}bookshop/edit/id/{$item.bookshop->id}" target="_blank">Edit Bookshop</a>
						</td>
					<td align="center">{$item.book->price|formatprice}</td>
					<td align="center">&times;</td>
					<td align="center"><big><b>{$item.quantity}</b></big></td>
					<td align="center">
						{foreach name=orderlist item=orderid from=$item.orders}
							{$orderid}{if $smarty.foreach.orderlist.last == false}, {/if}
						{/foreach}
					</td>
				</tr>
			{/foreach}
		</tbody>

		
</table>
<br /><br />
{/foreach}


</div>
</div>



