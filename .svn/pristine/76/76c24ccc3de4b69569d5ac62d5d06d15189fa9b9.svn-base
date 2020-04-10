{if $isPopup == false}
<div id="panelleft" style="margin-top:-10px;">
	<div class="freeshiprule">
		<p><img src="{$imageDir}store/freeship.png" alt="" /><br /><br /></p>
		<p>{$lang.default.cartfreeshiprule}</p>
	</div>
</div><!-- end #panelleft -->
{/if}

<div id="panelright" style="width:620px;">
	<div class="shelf">
		<h1 class="head">{$lang.controller.title}</h1>
	</div><!-- end .shelf -->
	
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	
	{if $items|@count > 0}
		<form method="post" action="{$conf.rooturl}cart{if $isPopup}?ispopup{/if}">
			<table class="cart" cellpadding="5" cellspacing="0">
				<thead>
					<tr>
						<th width="30">{$lang.controller.cartitemImage}</th>
						<th align="left">{$lang.controller.cartitemTitle}</th>
						<th width="60">{$lang.controller.cartitemPrice}</th>
						<th width="20"></th>
						<th width="50">{$lang.controller.cartitemQuantity}</th>
						<th width="20"></th>
						<th width="60" align="right">{$lang.controller.cartitemSubtotal}</th>
						<th width="20"></th>
					</tr>
				</thead>
				<tbody>
					{foreach item=item from=$items}
						<tr class="{cycle values="row,rowalt"}">
							<td align="center"><a href="{if $isPopup}javascript:void(0){else}{$item->book->getBookPath()}{/if}" class="tipsy-hovercard-trigger" data-url="{$item->book->getHovercardPath()}" ><img src="{$item->book->getSmallImage()}" alt="Cover" class="cover" /></a></td>
							<td><a href="{if $isPopup}javascript:void(0){else}{$item->book->getBookPath()}{/if}" class="tipsy-hovercard-trigger title" data-url="{$item->book->getHovercardPath()}" >{$item->book->title}</a></td>
							<td align="center">{$item->pricereal|formatprice}</td>
							<td align="center">&times;</td>
							<td align="center"><input type="text" name="fquantity[{$item->id}]" class="textbox" value="{$item->quantity}" /></td>
							<td align="center">=</td>
							<td align="right">{$item->subtotal|formatprice}</td>
							<td><a href="{$conf.rooturl}cart?deleteid={$item->id}{if $isPopup}&ispopup{/if}" title="{$lang.default.cartItemRemove}"><img src="{$imageDir}blank.png" class="sp sp16 spdelete" alt="Remove" /></a></td>
						</tr>
					{/foreach}
				</tbody>
				
				
				<tfoot class="end">
					<tr>
						<td colspan="8" align="right">
							<a {if $isPopup}onclick="parent.location.href='{if $smarty.session.continueshoppingurl == ''}{$conf.rooturl}store{else}{$smarty.session.continueshoppingurl}{/if}'; parent.Shadowbox.close();" href="javascript:void(0)"{else}href="{if $smarty.session.continueshoppingurl == ''}{$conf.rooturl}store{else}{$smarty.session.continueshoppingurl}{/if}"{/if} class="btncontinueshopping" title="{$lang.controller.gotostore}"><img src="{$imageDir}store/cart.png" /> {$lang.controller.continueshopping}</a>
							
							<a {if $isPopup}onclick="parent.location.href='{$conf.rooturl}checkout'; parent.Shadowbox.close();" href="javascript:void(0)"{else}href="{$conf.rooturl}checkout"{/if} class="btncheckout">{$lang.default.cartCheckout} &raquo;</a>
						</td>
					</tr>
				</tfoot>
				
				<tfoot>
					<tr>
						<td colspan="2"><a class="emptycart" href="javascript:delm('{$conf.rooturl}cart?deleteid=0')">{$lang.controller.cartempty}</a></td>
						<td colspan="3" align="right"><input type="submit" name="fsubmitupdate" value="{$lang.default.cartUpdate}" class="btnupdate" /></td>
						<td align="right" colspan="2">{$lang.default.cartTotal} <span class="total">{$pricetotal|formatprice}</span></td>
						<td></td>
					</tr>
				</tfoot>
				
			</table>
		</form>
		
		{if $isPopup}
			<div style="border-top:1px solid #ddd; margin-top:10px; padding-top:10px;">
				<img style="float:left; padding-right:10px;" src="{$imageDir}store/freeship.png" height="50" alt="" />
				<div style="color:#888;"><big>{$lang.default.cartfreeshiprule}</big></div>
				<div class="cl"></div>
			</div>
		{/if}
	{else}
		<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}.<br /><br />
			<a href="{$conf.rooturl}store" title="">{$lang.controller.gotostore}</a>
		</div>
		
		<br />
	{/if}
	
</div><!-- end #panelright -->


		
<script type="text/javascript">
{if $isPopup == false}
	$('#cartitemcount').text('{$cartItemCount}');
{else}
	parent.$('#cartitemcount').text('{$cartItemCount}');
{/if}
</script>