<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
		
            
		{include file="`$smartyControllerGroupContainer`hotshelf.tpl"}
		
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		
		<div class="shelf">
			<div class="head">
				<h1 class="left">{$lang.controller.title}{if $curPage > 1} <span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</h1>
				
			</div>
		
		
				
		{if $total > 0}
			<div class="reviewlist">
				{foreach item=review from=$reviewList}
					{assign var=book value=$review->book}
				<div class="review review_wide" id="review-{$review->id}">
					<div class="cover"><a class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" href="{$book->getBookPath()}" title="{$book->title}"><img src="{$book->getSmallImage()}" alt="{$book->title}" /></a></div>
					<div class="info">
						<div class="title"><a class="tipsy-hovercard-trigger" data-url="{$book->getHovercardPath()}" href="{$book->getBookPath()}" title="{$book->title}">{$book->title}</a>  <span class="author">{$book->author}</span></div>
						<div class="text textsmall">{$review->text}</div>
						{$review->showLike(true)}
						<div class="controlbar">
							<span class="time relativetime">{$review->datecreated}</span>
							<span class="commentor"><a class="tipsy-hovercard-trigger" data-url="{$review->actor->getHovercardPath()}" href="{$review->actor->getUserPath()}" title="{$lang.default.gotoProfileOf} {$review->actor->fullname}">{$review->actor->fullname}</a></span>
							{if $review->actor->id == $me->id}
								<a class="remove" href="javascript:void(0);" onclick="bookreviewRemove('{$book->getBookPath()}/review/removeajax/{$review->id}',{$review->id})" title="{$lang.controller.reviewRemoveTitle}">{$lang.controller.reviewRemove}</a>
							{/if}
							
							{if in_array($me->id, $review->likelist) == false && $me->id != $review->uid}
							|
							
							<a href="javascript:void(0)" onclick="bookreviewlikeadd({$review->bid}, {$review->id}, 0)" class="like_btn">{$lang.controller.like}</a>
							{/if}
							
							
							<a class="facebookshare tipsy-trigger" title="{$lang.default.facebooksharetooltip}" href="javascript:void(0)" onclick="facebookshare_popup('{$conf.rooturl}facebookshare?type=review&id={$review->id}')"><img src="{$imageDir}facebookshare-button.png" alt="Share on facebook" /></a>
							
						</div>
					</div>
				</div><!-- end .review -->
				{/foreach}
			</div>
			
			
			
			
			<div class="cl"></div>
			{assign var="pageurl" value="page-::PAGE::"}
			{paginate count=$totalPage curr=$curPage lang=$paginateLang max=6 url="`$paginateurl``$pageurl``$paginatesuffix`"}
		{else}
			<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}. </a></div>
		{/if}
		
	</div><!-- end .shelf -->
       
       
	</div><!-- end #panelright -->
    
    <script type="text/javascript">
	{literal}
	$(document).ready(function()
	{
		$('.review .textsmall').each(function(){user_formatCommentText($(this))})
		
		
	});
	{/literal}
	</script>