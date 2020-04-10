<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-mybox.tpl"}
            
		
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		<div class="shelf">
			<h1 class="head">
				{if isset($smarty.get.search)}
					{$lang.controller.searchResult} {if $total > 0}({$total} {$lang.controller.searchResultUnit}){/if} 
				{elseif $formData.fcategory > 0}
					{$myCategory->name}
				{else}
					{$lang.controller.title}
				{/if}
				{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}
				
			</h1>
			
			{include file="notify.tpl" notifySuccess=$success}
						
			{if $total > 0}
				<div class="sbookgrid">
					<form id="transactionform" method="post" action="">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								<thead>
									<tr>
										<th class="tf-id" style="width:80px">{$lang.controller.invoiceid}</th>
										<th align="left">{$lang.controller.booklist}</th>
										<th>{$lang.controller.pricefinalshort}</th>
										<th class="tf-date">{$lang.controller.datecreated}</th>
										<th width="100">{$lang.controller.status}</th>
										<th></th>
									</tr>
								</thead>
                                
                                			
								
								<tbody>
								
									{foreach name=orderlist item=order from=$orderList}
									<tr class="" title="">
										<td><strong>#{$order->invoiceid}</strong></td>
										<td>
											{foreach item=book from=$order->booklist}
												<a href="{$book->getBookPath()}" class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" title="{$lang.controller.gotobook}"><img src="{$book->getSmallImage()}" width="50" /></a>
											{/foreach}
										</td>
										<td align="center"><strong>{if $order->pricefinal > 0}{$order->pricefinal|formatprice}{else}{$lang.controller.pricefinalFree}{/if}</strong></td>
										<td class="tf-date" title="">{$order->datecreated|date_format:"%H:%M,<br /> %d-%m-%Y"}</td>
										<td class="tf-status">{$order->getStatusName()}</td>
										<td class="tf-id"><a href="javascript:void(0)" onclick="window.open('{$me->getUserPath()}/orders/print/{$order->id}', 'printwin', 'menubar=0,resizable=1,location=0,width=760,height=600')" title="{$lang.controller.orderDetailTitle}">{$lang.controller.viewdetail}</a></td>
									</tr>
									{/foreach}
									
									
									
								</tbody>
								
							</table>
							
							
							
							<div id="mainformtable-batchfunc">
								<div id="mf-func-left">
									
								</div>
								<div id="mf-func-right">
									
								</div>
								<div class="clearboth">&nbsp;</div>
							</div>
							
						</div><!-- end of id:mainform-body -->
						<div id="mainform-fixfloat">&nbsp;</div>
						
					</div>
					</form>
					
					</div>
								
			{else}
            	<div style="text-align: center;padding:50px 0;">{$lang.controller.orderEmpty} <a href="{$conf.rooturl}store" title="">{$lang.controller.orderEmptyText}</a></div>
            {/if}	
				
				
	
		</div><!-- end .shelf -->
		
				
        {assign var="pageurl" value="page-::PAGE::"}
		{paginate count=$totalPage curr=$curPage lang=$paginateLang max=6 url="`$paginateurl``$pageurl``$paginatesuffix`"}
       
       
	</div><!-- end #panelright -->
    
	<script type="text/javascript">
	{literal}
	$(document).ready(function()
	{
			

	});
	{/literal}
	</script>
    
    
    
	
	
	
    
    
    