<div class="stats">
	{$lang.controller.yourxu} <a href="{$conf.rooturl}money">{$me->xu|formatprice}</a>
</div>

<div id="recent">
	<h3>{$lang.controller.recentlist}</h3>
	{foreach item=book from=$myBooklist}
		<a href="{$book->getBookPath()}" class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}"><img src="{$book->getSmallImage()}" /></a>
	{/foreach}
</div>