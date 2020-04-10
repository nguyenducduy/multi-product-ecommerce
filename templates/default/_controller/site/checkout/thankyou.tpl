
<div id="panelleft">
	
		
</div><!-- end #panelleft -->


<div id="panelright">
	
	<div class="checkoutindicator">
		<div class="bar"><span style="width:480px;"></span></div>
		<ul>
			<li><a href="{$conf.rooturl}cart" class="done"><strong>1</strong><span>{$lang.controller.progressCart}</span></a></li>
			<li><a href="{$conf.rooturl}checkout" class="done"><strong>2</strong><span>{$lang.controller.progressBilling}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/payment" class="done"><strong>3</strong><span>{$lang.controller.progressPayment}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/review" class="done"><strong>4</strong><span>{$lang.controller.progressReview}</span></a></li>
			<li><a href="{$conf.rooturl}checkout/thankyou/{$myOrder->id}" class="active activecombo"><strong>5</strong><span>{$lang.controller.progressFinish}</span></a></li>
		</ul>
		<div class="cl"></div>
	</div>
	
	
	<h1 class="checkoutfinishTitle">{$lang.controller.thankyouTitle}</h1>
	<p class="checkoutfinishText">{$lang.controller.thankyouText}<strong>{$myOrder->invoiceid}</strong>.</p>
	<p class="checkoutfinishText">{$lang.controller.thankyouText2}.</p>
	
	<p class="checkoutfinishText"><a href="javascript:void(0)" onclick="window.open('{$me->getUserPath()}/orders/print/{$myOrder->id}', 'printwin', 'menubar=0,resizable=1,location=0,width=760,height=600')" class="orderdetail">{$lang.controller.vieworderdetail}{$myOrder->invoiceid}</a></p>
	
	<p class="checkoutfinishText checkoutfinishTextAll"><a href="{$me->getUserPath()}/orders"><small>{$lang.controller.viewallorder}</small></a></p>
	
	<br />
	
</div><!-- end #panelright -->


		

