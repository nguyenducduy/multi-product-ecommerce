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
		
		<link rel="stylesheet" type="text/css" href="{$currentTemplate}css/site/index.css" />
		<script type="text/javascript" src="{$currentTemplate}js/slides.min.jquery.js?ver={$setting.site.jsversion}"></script>
		<script>
			$(function(){
				
				// Initialize Slides
				$('#slides').slides({
					paginationClass: 'jsslidepagination',
					play: 5000,
					pause: 2500,
					hoverPause: true
				});
			});
		</script>

		
				
		
		<div id="homeslider">
			<div id="slides">
				<div class="slides_container">
					{foreach item=slideentryitem from=$slideEntries}
					{assign var=slideentry value=$slideentryitem.data}
					<div class="slide">
						<div class="cover">{assign var=bookurl value=$slideentry->book->getBookPath()}
							<a class="tipsy-hovercard-trigger" data-url="{$slideentry->book->getHovercardPath()}" href="{$bookurl}" title="{$slideentry->book->title}"><img src="{$slideentry->book->getImage()}" alt="" /></a>
							{if $slideentry->book->rating > 0}<div style="text-align:center; width:160px; padding: 5px 0;"><img class="sp sprating sprating{$slideentry->book->getRatingRound()}" src="{$imageDir}blank.png" alt="Rating: {$slideentry->book->rating}" /></div>{/if}
						</div>
						<h2 class="title"><a class="tipsy-hovercard-trigger" data-url="{$slideentry->book->getHovercardPath()}" href="{$bookurl}" title="{$slideentry->book->title}">{$slideentry->book->title}</a><span>- {$slideentry->book->author}</span></h2>
						<div class="reviewtext">{$slideentry->text}</div>
						<div class="reviewer">
							
							<div class="fullname"><a href="{$slideentry->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$slideentry->actor->fullname}">{$slideentry->actor->fullname}</a></div>		
							<div class="avatar"><a href="{$slideentry->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$slideentry->actor->fullname}"><img src="{$slideentry->actor->getSmallImage()}" /></a></div>
						</div>
					</div>
					{/foreach}
				
					
					
				</div>
				<a href="#" class="prev"><img src="{$imageDir}jsslide/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="{$imageDir}jsslide/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>

			</div>
			
			<img src="{$imageDir}jsslide/bookslideframe.png" width="739" height="341" alt="Slide frame" id="frame">

			
		</div>

		
		
				
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
    