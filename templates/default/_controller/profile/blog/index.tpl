<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`panel-userbox.tpl"}
            
		
				
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		<div class="shelf">
			<div class="head">
				<h1 class="left">{$lang.controller.title} {$myUser->fullname}{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</h1>
				<div class="right">{if $me->id == $myUser->id}<a class="linkbuttonorange" href="{$me->getUserPath()}/blog/add" title="{$lang.controller.titleAddTitle}">{$lang.controller.titleAdd}</a>{/if}</div>
			</div>
			
			{include file="notify.tpl" notifyError=$error notifySuccess=$success}
			
			{if $total > 0}
				{foreach item=blog from=$blogList}
					<div class="sblog sblog_wide" id="blog-{$blog->id}">
						<div class="image"><a href="{$blog->getBlogPath()}" title="{$blog->title}"><img src="{if $blog->image == ''}{$imageDir}blognoimage.png{else}{$blog->getSmallImage()}{/if}" alt="" /></a></div>
						<div class="info">
							<h2 class="title"><a class="t" href="{$blog->getBlogPath()}" title="{$blog->title}">{$blog->title}</a></h2>
							
							<div class="category">
								{$blog->datecreated|date_format:"%d/%m/%Y"}
								{if $blog->category->id > 0}, {$blog->category->name}{/if}
							</div>
							
							<div class="text">{$blog->contents|truncateperiod:400}</div>
							<div class="controlbar">
								<span class="time">{$blog->view} {$lang.controller.view}</span>
								{if $myUser->id == $me->id}
									{if $blog->showinhomepage == 1}
										<span class="label label-success">{$lang.controller.showinhomepage}</span>
									{elseif $blog->sharemode != 1}
									<span class="time" style="color:#F30">, {$lang.controller.sharemode}: {$blog->getSharemodeName()}</span>
									{/if}
								{/if}
								<span class="commentcount"><a href="{$blog->getBlogPath()}#comment" title="{$lang.controller.commentMessageHeading}">{if $blog->comment > 0}{$blog->comment} {$lang.controller.commentLabel}{else}{$lang.controller.commentEmpty}{/if}</a></span>
								{if $myUser->id == $me->id}
									<a class="" href="{$me->getUserPath()}/blog/edit/{$blog->id}?redirect={$redirectUrl}" title="{$lang.controller.editTitle}">{$lang.controller.edit}</a>
									<a class="remove" href="javascript:void(0);" onclick="delm('{$me->getUserPath()}/blog/delete/{$blog->id}?token={$smarty.session.securityToken}&redirect={$redirectUrl}')" title="{$lang.controller.deleteTitle}">{$lang.controller.delete}</a>
								{/if}
							</div>
						</div>
					</div><!-- end .review -->
					<div class="cl"></div>
				{/foreach}
				
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
	
		
		

	});
	{/literal}
	
	</script>
    
    