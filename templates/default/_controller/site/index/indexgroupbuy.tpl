{literal}
<style type="text/css">
		
	/*** set the width and height to match your images **/
	
	#sslideshow {
		position:relative;
		width: 380px;
		height:250px;
	}
	
	#sslideshow DIV {
		position:absolute;
		top:0;
		left:0;
		z-index:8;
		opacity:0.0;
		height: 250px;
		background-color: #FFF;
	}
	
	#sslideshow DIV.active {
		z-index:10;
		opacity:1.0;
	}
	
	#sslideshow DIV.last-active {
		z-index:9;
	}
	
	#sslideshow DIV IMG {
		height: 250px;
		display: block;
		border: 0;
		margin-bottom: 10px;
	}
</style>

<script type="text/javascript">
function Countdown(then) {
 
 	this.then = then;
 	
 	function setElement(id, value) {
		if (value < 10) {
 	    	value = "0" + value;
			
 		}
 	
 		window.document.getElementById(id).innerHTML = value;
 	}
 	
 	function countdown() {
 		now  		  = new Date();
 	  	diff		  = new Date(this.then - now);
 	  	
 		seconds_left  = Math.floor(diff.valueOf() / 1000);
 	
 		seconds  = Math.floor(seconds_left / 1) % 60;
 		minutes  = Math.floor(seconds_left / 60) % 60;
 		hours    = Math.floor(seconds_left / 3600) % 24;
 		days     = Math.floor(seconds_left / 86400) % 86400;
 		
 		setElement('countdown-days', days);
 		setElement('countdown-hours', hours);
 		setElement('countdown-minutes', minutes);
 		setElement('countdown-seconds', seconds);
 		
 		countdown.timer = setTimeout(countdown, 1000);
 	}
 	
 		
 	function start() {
 		this.timer = setTimeout(countdown, 1000);
 	}
 	
 	start(then);	
 }
 
 Countdown(new Date("Oct 23 2011 00:00:00"));


	
		
	/*** 
		Simple jQuery Slideshow Script
		Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
	***/
	
	function slideSwitch() {
		var $active = $('#sslideshow DIV.active');
	
		if ( $active.length == 0 ) $active = $('#sslideshow DIV:last');
	
		// use this to pull the divs in the order they appear in the markup
		var $next =  $active.next().length ? $active.next()
			: $('#sslideshow DIV:first');
	
		// uncomment below to pull the divs randomly
		// var $sibs  = $active.siblings();
		// var rndNum = Math.floor(Math.random() * $sibs.length );
		// var $next  = $( $sibs[ rndNum ] );
	
	
		$active.addClass('last-active');
	
		$next.css({opacity: 0.0})
			.addClass('active')
			.animate({opacity: 1.0}, 1000, function() {
				$active.removeClass('active last-active');
			});
	}
	
	$(function() {
		setInterval( "slideSwitch()", 2500 );
	});
	

</script>

{/literal}



<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		<div id="panelprofile">
			{include file="`$smartyControllerGroupContainer`panel-introbox.tpl"}
		</div>
		
		
            
            
		{include file="`$smartyControllerGroupContainer`hotshelf.tpl"}
		
		
		
		
		
		<div class="bookbox" id="panellastmember">
			<h2>{$lang.default.latestActiveMember}</h2>
			<div class="bookboxlink">
				<a href="{$conf.rooturl}member" title="">{$lang.default.viewAll}</a>
			</div>
		</div><!-- end .bookbox -->
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<br />
		<div class="shelf">
			<h1 class="head">T&#7863;ng  10 cu&#7889;n s&aacute;ch &quot;L&aacute; n&#7857;m trong l&aacute;&quot; c&#7911;a Nguy&#7877;n Nh&#7853;t &Aacute;nh</h1>
	
			<div style="padding: 10px 30px;">
				<div class="groupbuysummary">
					<div class="groupbuystat">
						<div><a href="{$groupbuyUrl}" class="groupbuy-button"><span class="groupbuy-buy-label">T&#7863;ng s&#225;ch MI&#7876;N PH&Iacute;</span></a></div>
						<div class="groupbuyinfobox">Ti&#7871;t ki&#7879;m 100%, giao s&aacute;ch mi&#7877;n ph&iacute;</div>
						<div class="groupbuyinfobox"><strong>&#272;&atilde; c&oacute; {$groupbuyTotalTicket} l&#432;&#7907;t tham gia</strong></div>
						<div class="groupbuyinfobox">Th&#7901;i gian c&ograve;n l&#7841;i <br />
							<strong id="countdown-days"></strong> ng&#224;y
	 
							<strong id="countdown-hours"></strong> gi&#7901; <strong id="countdown-minutes"></strong> ph&#250;t <strong id="countdown-seconds"></strong> gi&#226;y
						</div>
					</div>
					<div class="groupbuyphoto">
						<div id="sslideshow">
							<div class="active"><a href="{$groupbuyUrl}" title="Xem chi ti&#7871;t"><img border="0" src="{$imageDir}groupbuy/la-nam-trong-la/la-nam-trong-la.jpg" alt="la-nam-trong-la" width="380" /></a></div>
							<div><a href="{$groupbuyUrl}" title="Xem chi ti&#7871;t"><img border="0" src="{$imageDir}groupbuy/la-nam-trong-la/la-nam-trong-la-2.jpg" alt="la-nam-trong-la" width="380" /></a></div>
							<div><a href="{$groupbuyUrl}" title="Xem chi ti&#7871;t"><img border="0" src="{$imageDir}groupbuy/la-nam-trong-la/la-nam-trong-la-3.jpg" alt="la-nam-trong-la" width="380" /></a></div>
							<div><a href="{$groupbuyUrl}" title="Xem chi ti&#7871;t"><img border="0" src="{$imageDir}groupbuy/la-nam-trong-la/la-nam-trong-la-4.jpg" alt="la-nam-trong-la" width="380" /></a></div>
							<div><a href="{$groupbuyUrl}" title="Xem chi ti&#7871;t"><img border="0" src="{$imageDir}groupbuy/la-nam-trong-la/la-nam-trong-la-5.jpg" alt="la-nam-trong-la" width="380" /></a></div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			
				
	
		</div><!-- end .shelf -->
		
		
		<div class="clear"></div>
		<br />
		
		
				
		<div class="shelf">
			<h1 class="head">{$lang.controller.latestBook}</h1>

			
				{foreach key=index name=latestbook item=book from=$latestBooks}
				{if $index % 4 == 0 && $index != 0}</div>{/if}
				{if $index % 4 == 0}<div class="shelfrow">{/if}
				<div class="sbook">
					<div class="title"><a href="{$book->getBookPath()}" title="{$book->title}">{$book->title}</a></div>
					<div class="author">{$book->author}</div>
					<div class="cover">
						<a class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" href="{$book->getBookPath()}" title="{$book->title} - {$book->author}"><img src="{$book->getSmallImage()}" alt="" /></a>
					</div>
					
				</div><!-- end .sbook -->
				{if $smarty.foreach.latestbook.last}</div><!-- end .shelfrow -->{/if}
				{/foreach}
	
		</div><!-- end .shelf -->
		
		<div class="shelf shelfmeta">
			<div class="head">
				<h1 class="left">{$lang.controller.ebookshop}</h1>
				<div class="right">
					<a href="{$conf.rooturl}ebook" title="{$lang.controller.ebookshopall}">{$lang.controller.ebookshopall}</a> |
					<a href="{$conf.rooturl}xu" title="{$lang.controller.ebookshopnapxuTitle}">{$lang.controller.ebookshopnapxu}</a>
				</div>
			</div>
			
			

			{foreach key=index name=sellebook item=ebook from=$ebookList}
				{if $index % 4 == 0 && $index != 0}</div>{/if}
				{if $index % 4 == 0}<div class="shelfrow">{/if}
				<div class="sbook">
					<div class="title"><a href="{$ebook->getEbookPath()}" title="{$ebook->book->title}">{$ebook->book->title}</a></div>
					<div class="author">{$ebook->book->author}</div>
					<div class="cover">
						<a class="tipsy-hovercard-trigger" data-url="{$ebook->book->getHovercardPath()}" href="{$ebook->getEbookPath()}" title="[EBOOK] --- {$ebook->book->title} - {$ebook->book->author}"><img src="{$ebook->book->getSmallImage()}" alt="" /></a>
					</div>
                    <div class="badge sp spshopbadge"><a href="{$ebook->getEbookPath()}" title="{$lang.default.clickToBuyTooltip}">{$ebook->getPrice()}</a></div>
					<div class="badgepdf"><a href="{$ebook->getEbookPath()}" title="{$book->title}"><img src="{$imageDir}ebook/pdf_badge.png" /></a></div>
				</div><!-- end .sbook -->
				{if $smarty.foreach.sellebook.last}</div><!-- end .shelfrow -->{/if}
			{/foreach}
			
	
		</div><!-- end .shelf -->
		
		
		<div class="shelf shelfmeta">
			<div class="head">
				<h1 class="left">{$lang.controller.sellingBook}</h1>
				<div class="right">
					<a href="{$conf.rooturl}shop" title="{$lang.controller.viewAllSellTitle}">{$lang.controller.viewAllSell}</a>
				</div>
			</div>
			
			

			{foreach key=index name=sellingbook item=sellingbook from=$sellingBooks}
				{if $index % 4 == 0 && $index != 0}</div>{/if}
				{if $index % 4 == 0}<div class="shelfrow">{/if}
				<div class="sbook">{assign var=bookurl value=$sellingbook->book->getBookPath()}
					<div class="title"><a href="{$bookurl}" title="{$sellingbook->book->title}">{$sellingbook->book->title}</a></div>
					<div class="author">{$sellingbook->book->author}</div>
					<div class="cover">
						<a class="tipsy-hovercard-trigger" data-url="{$sellingbook->book->getHovercardPath()}" href="{$bookurl}" title="[{$sellingbook->getQualityName()}] --- {$sellingbook->book->title} - {$sellingbook->book->author} --- {$lang.default.coverPrice} : {$sellingbook->book->price|formatprice}"><img src="{$sellingbook->book->getSmallImage()}" alt="" /></a>
					</div>
                    {if $sellingbook->price > 0}
						<div class="badge sp spshopbadge"><a href="{$bookurl}/buy/{$sellingbook->id}" title="{if $sellingbook->region > 0}[{$sellingbook->getRegionName()}] {/if}{$lang.default.clickToBuyTooltip}">{$sellingbook->formatPrice($sellingbook->price, $sellingbook->currency)}</a></div>
					{else}
						<div class="badge badge_free sp spshopbadgefree">{$sellingbook->getFreeLink()}</div>
					{/if}
				</div><!-- end .sbook -->
				{if $smarty.foreach.sellingbook.last}</div><!-- end .shelfrow -->{/if}
			{/foreach}
			
	
		</div><!-- end .shelf -->
		
        
        		
		<div class="shelf">
			<h1 class="head">{$lang.controller.mostviewBookToday}</h1>

			{foreach key=index name=mostviewbook item=book from=$mostviewBooksToday}
				{if $index % 4 == 0 && $index != 0}</div>{/if}
				{if $index % 4 == 0}<div class="shelfrow">{/if}
				<div class="sbook">{assign var=bookurl value=$book->getBookPath()}
					<div class="title"><a href="{$bookurl}" title="{$book->title}">{$book->title}</a></div>
					<div class="author">{$book->author}</div>
					<div class="cover">
						<a class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" href="{$bookurl}" title="{$book->title} - {$book->author}"><img src="{$book->getSmallImage()}" alt="" /></a>
					</div>
					
				</div><!-- end .sbook -->
				{if $smarty.foreach.mostviewbook.last}</div><!-- end .shelfrow -->{/if}
			{/foreach}		
	
		</div><!-- end .shelf -->
		
		<div class="shelf">
			<h1 class="head">{$lang.controller.mostaddBookToday}</h1>

			{foreach key=index name=mostaddbook item=book from=$mostaddBooksToday}
				{if $index % 4 == 0 && $index != 0}</div>{/if}
				{if $index % 4 == 0}<div class="shelfrow">{/if}
				<div class="sbook">{assign var=bookurl value=$book->getBookPath()}
					<div class="title"><a href="{$bookurl}" title="{$book->title}">{$book->title}</a></div>
					<div class="author">{$book->author}</div>
					<div class="cover">
						<a class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" href="{$bookurl}" title="{$book->title} - {$book->author}"><img src="{$book->getSmallImage()}" alt="" /></a>
					</div>
					
				</div><!-- end .sbook -->
				{if $smarty.foreach.mostaddbook.last}</div><!-- end .shelfrow -->{/if}
			{/foreach}		
	
		</div><!-- end .shelf -->
		
	</div><!-- end #panelright -->
	
	{literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
		panelLatestActiveMember();
	
	});
	
	
	</script>
    {/literal}
    