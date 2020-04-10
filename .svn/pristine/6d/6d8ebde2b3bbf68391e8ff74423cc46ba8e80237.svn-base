<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
	
        
		{include file="`$smartyControllerGroupContainer`panel-mybox.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		{assign var=myBook value=$myOrder->book}
		<div id="book" class="shelf">
			<h1 class="head"><a href="{$me->getUserPath()}/order" title="{$lang.controller.titleTitle}">{$lang.controller.title}</a> &raquo; {$myBook->title}  - {$myBook->author}</h1>
            
        	<div class="shelfrow shelfrowbuy">
				
                <div class="cover"><a class="tipsy-hovercard-trigger" data-url="{$myBook->getHovercardPath()}" href="{$myBook->getBookPath()}" title="{$myBook->title}"><img src="{$myBook->getSmallImage()}" alt="{$myBook->title}" /></a></div>
				<div class="bookinfo">
					<p>
						
						{$lang.default.bookCategory}: <a href="{$conf.rooturl}book?category={$myCategory->id}" title="{$myCategory->name}">{$myCategory->name}</a><br />	
						{$lang.default.bookPriceCover}: {$myBook->price|formatprice}<br />						
						{if $myBook->rating > 0}{$lang.default.bookRating}: <img class="sp sprating sprating{$myBook->getRatingRound()}" src="{$imageDir}blank.png" alt="Rating: {$myBook->rating}" /><br />{/if}
                        
						
					</p>
				</div><!-- end .bookinfo --> 	
				<div class="posterinfo">
					<div class="subtitle">
						{$myBook->view} {$lang.controller.view}<br />
						
						{if $myBook->countUsing > 0}{$myBook->countUsing} {$lang.default.bookCountUsing}<br />{/if}
						{if $myBook->countSelling > 0}{$myBook->countSelling} {$lang.default.bookCountSelling}<br />{/if}
						{if $myBook->countFav > 0}{$myBook->countFav} {$lang.default.bookCountFav}<br />{/if}
						
					</div>
					
				</div><!-- end .posterinfo -->
				
			</div><!-- end .shelfrow, .shelfrowdetail -->
		</div><!-- end .shelf -->
		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		
		<div id="orderform" class="myform myformwide stylizedform">
			<form id="orderformedit" name="form1" method="post" action="{$me->getUserPath()}/order/detail/{$myOrder->id}">
				<a style="float:right;" href="javascript:void(0)" onclick="window.open('{$me->getUserPath()}/order/print/{$myOrder->id}', 'printwin', 'menubar=0,resizable=1,location=0,width=760,height=600')" title="Print"><img src="{$imageDir}print.png" alt="Print" /></a>
				<h1>{$lang.controller.invoiceid} #<u><big>{$myOrder->invoiceid}</big></u></h1>
				<p></p>
				
				<label>{$lang.controller.dateordered}</label>
				<div class="text textwide">{$myOrder->datecreated|date_format:"%H:%M, %d/%m/%Y"}</div>
				<div class="clear"></div>
				
				
				<label>{$lang.controller.style}</label>
				<div class="text textwide">
					<span class="noeditorder">{$myOrder->booksell->getQualityName()}</span>
					<span class="editorder hide">
						<select class="input_inline" name="fsellquality" id="fsellquality">
							{foreach key=qualityid item=quality from=$qualityList}
								<option value="{$qualityid}" {if $qualityid == $formData.fsellquality}selected="selected"{/if}>{$quality}</option>
							{/foreach}
						</select>
					</span>
				</div>
				<div class="clear"></div>
				
				<label>{$lang.controller.sellCurrency}&nbsp;</label>
				<div class="text textwide">
					<span class="noeditorder">{$myOrder->getCurrencyName()}</span>
					<span class="editorder hide">
						<select name="fsellcurrency" id="fsellcurrency" class="input_inline" onchange="updateCurrency()">
							<option value="1">{$lang.controller.sellCurrencyVnd}</option>
							<option value="3"{if $formData.fsellcurrency == '3'} selected="selected"{/if}>{$lang.controller.sellCurrencyRep}</option>
							<option value="5"{if $formData.fsellcurrency == '5'} selected="selected"{/if}>{$lang.controller.sellCurrencyXu}</option>
							  
						</select> <a href="{$conf.rooturl}help/sellcurrency" target="_blank" title="{$lang.controller.sellCurrencyHelpTitle}">(?)</a><br />
						
					</span>
				</div>
				<div class="clear"></div>
				
				
				<label>{$lang.controller.resellprice}</label>
				<div class="text orderformprice"><big><big><span class="noeditorder">{if $myOrder->priceSell > 0}{$myOrder->formatPrice($myOrder->priceSell, $myOrder->currency)}{else}<span class="greenfree">{$lang.default.freebook}</span>{/if}</span>
					<span class="editorder hide"><input class="input_inline" type="text" name="fsellprice" value="{$formData.fsellprice}" /><small><small class="currencycode">{$currency->currencyCode|upper}</small></small></span>
				</big></big></span></div>
				<div class="clear"></div>
				
				<label>{$lang.controller.resellpriceship}</label>
				<div class="text orderformprice"><big><big><span class="noeditorder">{if $myOrder->priceShip > 0}{$myOrder->formatPrice($myOrder->priceShip, $myOrder->currency)}{else}<span class="greenfree">{$lang.default.freebook}</span>{/if}</span>
					<span class="editorder hide"><input class="input_inline" type="text" name="fsellpriceship" value="{$formData.fsellpriceship}" /><small><small class="currencycodeship">{$currency->currencyCode|upper}</small></small></span>
				</big></big></span></div>
				<div class="clear"></div>
				<p></p>
				
				<label><big><big>{$lang.controller.pricetotal} : </big></big></label>
				<div class="text orderformprice"><big><big><strong>{if $myOrder->priceTotal > 0}{$myOrder->formatPrice($myOrder->priceTotal, $myOrder->currency)}{else}<span class="greenfree">{$lang.default.freebook}</span>{/if}</strong></big></big></div>
				<div class="clear"></div>
				<p></p>
				<label>{$lang.controller.status}</label>
				<div class="text textwide">
					<span class="noeditorder"><img class="sp sp16 sppaystatus{$myOrder->status}" src="{$imageDir}blank.png" /> {$myOrder->getStatusName()}</span>
					<span class="editorder hide">
						<select class="input_inline" name="fstatus" id="fstatus">
								{foreach key=statusid item=status from=$statusList}
									<option value="{$statusid}" {if $statusid == $formData.fstatus}selected="selected"{/if}>{$status}</option>
								{/foreach}
							</select>
					</span>
				</div>
				<div class="clear"></div>
				
				{if $myOrder->note != '' || $me->id == $myOrder->sellerId}
				<p></p>
				<label>{$lang.controller.note} : </label>
				<div class="text textwide">
					<span class="noeditorder">{$myOrder->note|nl2br|default:'N/a'}</span>
					<span class="editorder hide">
						<textarea id="fsellnote" name="fsellnote" style="width:400px; height:150px; margin:0 0 5px 0;">{$myOrder->note}</textarea>
					</span>
				</div>
				<div class="clear"></div>
				{/if}
				
				{if $me->id == $myOrder->sellerId}
				<label>&nbsp;<a class="editorder hide" href="javascript:void(0)" onclick="$('.noeditorder').show(); $('.editorder').hide();">{$lang.controller.cancellabel}</a></label>
				<div class="text textwide noeditorder"><a href="javascript:void(0)" onclick="$('.noeditorder').hide(); $('.editorder').show();">{$lang.controller.editlabel}</a></div>
				<div class="clear"></div>
				<input type="submit" class="submit editorder hide" name="fsubmitorder" value="{$lang.controller.editsubmit}" />
				{/if}
				
				{if $myOrder->checkCurrency('vnd') == false && $myOrder->priceTotal > 0}
				<div class="clear"></div>
				<div style="background:#fff; border:2px solid #39F; padding:10px">
					{if $myOrder->transactionid != ''}
					<big><big>{$lang.controller.transactionid} #<strong><u>{$myOrder->transactionid}</u></strong>
					{if $me->id == $myOrder->buyerId}<a href="{$myOrder->getTransactionPath()}" title="{$lang.controller.transactionidDetailTitle}">[{$lang.controller.transactionidDetail}]</a>{/if}
					
					{elseif $myOrder->priceTotal > 0}
						{assign var=orderPaymentPath value=$myOrder->getPaymentPath()}
						
						<big><big><strong>{$lang.controller.transactionidEmpty}</strong></big></big>
						
						
						
						
						
						{if $myOrder->buyerId == $me->id}
							{if $orderPaymentPath != ''}
								<a href="{$orderPaymentPath}" title="{$lang.controller.paynowTitle}" class="paymentlinkbutton">{$lang.controller.paynow}</a>
							{else}
								{if $myOrder->checkCurrency('rep')}
									<a href="javascript:void(0);" onclick="alert('{$lang.controller.paymentRepNotEnoughTextTitle}')" title="{$lang.controller.paynowTitle}" class="paymentlinkbutton">{$lang.controller.paynow}</a>
								{elseif $myOrder->checkCUrrency('xu')}
									<a href="javascript:void(0);" onclick="alert('{$lang.controller.paymentXuNotEnoughTextTitle}')" title="{$lang.controller.paynowTitle}" class="paymentlinkbutton">{$lang.controller.paynow}</a>
								{/if}	
							{/if}
							
							
							<br />
							
							
							{if $myOrder->checkCurrency('rep')}
								{if $me->rep >= $myOrder->priceTotal}
									{$lang.controller.paymentRepPayHelp}
								{else}
									{$lang.controller.paymentRepNotEnoughText}
								{/if}
							{elseif $myOrder->checkCurrency('xu')}
								{if $me->xu >= $myOrder->priceTotal}
									{$lang.controller.paymentXuPayHelp}
								{else}
									{$lang.controller.paymentXuNotEnoughText}
								{/if}
							{/if}
							
							
							
						{else}
							<br />{$lang.controller.transactionidEmptySellerHelp}
						{/if}
					{/if}
					</big></big> 
				</div>
				{/if}
				<div class="spacer"></div>
		
		  </form>
	  </div><!-- end #orderform -->
	  
	  
	  <div id="transactionsellerform" class="myform stylizedform">
		<h1><a href="{$myOrder->seller->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myOrder->seller->fullname}"><img src="{$myOrder->seller->getSmallImage()}" alt="avatar" /></a> {if $myOrder->priceTotal == 0}{$lang.controller.sellerfree}{else}{$lang.controller.seller}{/if}</h1>
		<p></p>
		
		<label>{$lang.controller.fullname}</label>
		<div class="text"><a href="{$myOrder->seller->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myOrder->sellerFullname}">{$myOrder->sellerFullname}</a></div>	
				
		<label>{$lang.controller.phone}</label>
		<div class="text">{$myOrder->sellerPhone}</div>	
		
		<label>{$lang.controller.email}</label>
		<div class="text">{$myOrder->sellerEmail}</div>
		
		<label>{$lang.controller.address}</label>
		<div class="text">{$myOrder->sellerAddress}</div>
		
		
		<div class="spacer"></div>
		 
	  </div><!-- end #transactionsellerform -->
	  
	  <div id="transactionbuyerform" class="myform stylizedform">
		<h1><a href="{$myOrder->buyer->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myOrder->buyer->fullname}"><img src="{$myOrder->buyer->getSmallImage()}" alt="avatar" /></a> {if $myOrder->priceTotal == 0}{$lang.controller.buyerfree}{else}{$lang.controller.buyer}{/if}</h1>
		<p></p>
		<form id="buyerform" method="post" action="">
			<label>{$lang.controller.fullname}</label>
			<div class="text noeditbuyer"><a href="{$myOrder->buyer->getUserPath()}" title="{$lang.default.gotoProfileOf} {$myOrder->buyerFullname}">{$myOrder->buyerFullname}</a></div>	
			<input class="editbuyer hide" type="text" name="fbuyerfullname" value="{$formData.fbuyerfullname}" />
			
			<label>{$lang.controller.phone}</label>
			<div class="text noeditbuyer "><span class="noeditbuyer ">{$myOrder->buyerPhone}</span></div>	
			<input class="editbuyer hide" type="text" name="fbuyerphone" value="{$formData.fbuyerphone}" />
			
			<label>{$lang.controller.email}</label>
			<div class="text noeditbuyer "><span class="noeditbuyer ">{$myOrder->buyerEmail}</span></div>
			<input class="editbuyer hide" type="text" name="fbuyeremail" value="{$formData.fbuyeremail}" />
			
			<label>{$lang.controller.address}</label>
			<div class="text noeditbuyer "><span class="noeditbuyer ">{$myOrder->buyerAddress}</span></div>
			<input class="editbuyer hide" type="text" name="fbuyeraddress" value="{$formData.fbuyeraddress}" />
			
			{if $me->id == $myOrder->buyerId}
			<label>&nbsp;<a class="editbuyer hide" href="javascript:void(0)" onclick="$('.noeditbuyer').show(); $('.editbuyer').hide();">{$lang.controller.cancellabel}</a></label>
			<div class="text noeditbuyer "><a href="javascript:void(0)" onclick="$('.noeditbuyer').hide(); $('.editbuyer').show();">{$lang.controller.editlabel}</a>
			
			</div>
			
			
			<input type="submit" class="submit editbuyer hide" name="fsubmitbuyer" value="{$lang.controller.editsubmit}" />
			{/if}
			
			
		</form>
	  </div><!-- end #transactionbuyerform -->
	  
	  <div class="cl"></div>
	  <br />
		
		
		
	<a name="comment"></a>
        
		<div id="bookcomment">
			
			<div class="head">
				<div class="left">{$lang.controller.commentTitle}</div>
				<div class="right"><a href="#" title="">{$lang.controller.goToTop}</a></div>
			</div><!-- end .head -->
			<div class="commentlist">
				
				
			</div><!-- end .commentlist -->
            
            
           	<div style="text-align:center" class="emptynotify hide"><em>{$lang.controller.commentEmpty}</em></div> 
            
			
			<div id="commentform" class="myform myformwide stylizedform stylizedform_sub">
				<form id="formcomment" name="form1" method="get" action="">
					<p>{if $myOrder->buyerId == $me->id}
						{if $myOrder->priceTotal == 0}{$lang.controller.commentMessageToSellerFree}{else}{$lang.controller.commentMessageToSeller}{/if}
					{else}
						{if $myOrder->priceTotal == 0}{$lang.controller.commentMessageToBuyerFree}{else}{$lang.controller.commentMessageToBuyer}{/if}
					{/if}</p>
					
					<label>{$lang.controller.commentMessage}</label>
				 	<textarea name="fmessage" id="fmessage" cols="30" rows="4"></textarea>
					
					<input type="button" class="submit" id="fsubmit" value="{$lang.controller.commentSubmit}" onclick="user_ordercommentAdd({$myOrder->id})" />
											
					<div class="spacer"></div>
			
				</form>
				
			</div><!-- end #commentform -->
		</div><!-- end #bookcomment -->
	</div><!-- end #panelright -->
	
	
	<script type="text/javascript">
		
		var selectedcomment = "{$smarty.get.selectedcomment}";
		

		$(document).ready(function()
		{literal}{{/literal}
			
			user_ordercommentLoad({$myOrder->id}, 1);
									
			{literal}
			$('#fmessage').autoResize({limit : 400});
			{/literal}
			
			
			updateCurrency();
			
		{literal}});{/literal}
		
		function updateCurrency()
		{
			var currencyCode = $('#fsellcurrency').val();
			var currencyString = '';
			if(currencyCode == '1')
				currencyString = ' VND';
			else if(currencyCode == '3')
				currencyString = ' REP';
			else if(currencyCode == '5')
				currencyString = ' Reader XU';
				
			$('.currencycode').text(currencyString);
			$('.currencycodeship').text(currencyString);
		}
	
	</script>
    
    