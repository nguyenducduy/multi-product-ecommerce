
{include file="notify.tpl" notifyError=$error notifySuccess=$success}


<div id="userprofileleft">
			<div class="shelf">
				<h1 class="head">{$lang.controller.feedlikeTitle}{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</h1>
			</div><!-- end .shelf -->
			
			
			{if $total > 0}
				<div class="friendrequestgrid">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								
								<tbody>
								
									{foreach item=feedlike from=$feedlikes}
					
					
									<tr class="{cycle values=",mf-row-alt"}" id="friend-{$feedlike->actor->id}">
										<td class="ff-avatar"><a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}'" title="{$lang.default.gotoProfileOf} {$feedlike->actor->fullname}"><img src="{$feedlike->actor->getSmallImage()}" alt="" /></a></td>
										<td class="ff-detail">
											<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}'" class="ff-username" title="{$lang.default.gotoProfileOf} {$feedlike->actor->fullname}">{$feedlike->actor->fullname}</a> 
											
											
											<div class="ff-button">
												{if $feedlike->actor->countBook > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}/book'" title="">{$feedlike->actor->countBook} {$lang.default.book}</a> &middot;{/if}
												{if $feedlike->actor->countSell > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}/shop'" target="_parent" title="">{$feedlike->actor->countSell} {$lang.default.bookSellCount}</a> &middot;{/if}
												{if $feedlike->actor->countFav > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}/fav'" title="">{$feedlike->actor->countFav} {$lang.default.bookCountFav}</a> &middot;{/if}
												{if $feedlike->actor->countReview > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}/review'" title="">{$feedlike->actor->countReview} {$lang.default.bookCountReview}</a> &middot;{/if}
												{if $feedlike->actor->countQuote > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$feedlike->actor->getUserPath()}/quote'" title="">{$feedlike->actor->countQuote} {$lang.default.bookCountQuote}</a> &middot;{/if}
												{if $actor->countFriend > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$actor->getUserPath()}/friend'" title="">{$actor->countFriend} {$lang.default.friend}</a>{/if}
											</div>
										</td>
									</tr>
									{/foreach}
								</tbody>
								
							</table>
							
							
							
						</div><!-- end of id:mainform-body -->
						<div id="mainform-fixfloat">&nbsp;</div>
						
					</div>
					
				</div>
				
				
				<div class="cl"></div>
				{assign var="pageurl" value="page-::PAGE::"}
				{paginate count=$totalPage curr=$curPage lang=$paginateLang max=6 url="`$paginateurl``$pageurl``$paginatesuffix`"}
			{else}
				<div style="text-align: center;padding:50px 0;">{$lang.controller.empty}. </a></div>
			{/if}
				
		</div><!-- end #userprofileleft -->
		