
{include file="notify.tpl" notifyError=$error notifySuccess=$success}


<div id="userprofileleft">
			<div class="shelf">
				<h1 class="head">{$lang.controller.reviewlikeTitle}{if $curPage > 1}<span class="inlinecurpage">{$lang.default.shelfheadCurPageLabel}{$curPage}</span>{/if}</h1>
			</div><!-- end .shelf -->
			
			
			{if $total > 0}
				<div class="friendrequestgrid">
					<div id="mainform">
						
						<div id="mainform-body">
							
							<table width="100%" border="0" cellspacing="0" id="mainformtable-container">
								
								<tbody>
								
									{foreach item=reviewlike from=$reviewlikes}
					
					
									<tr class="{cycle values=",mf-row-alt"}" id="friend-{$reviewlike->actor->id}">
										<td class="ff-avatar"><a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}'" title="{$lang.default.gotoProfileOf} {$reviewlike->actor->fullname}"><img src="{$reviewlike->actor->getSmallImage()}" alt="" /></a></td>
										<td class="ff-detail">
											<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}'" class="ff-username" title="{$lang.default.gotoProfileOf} {$reviewlike->actor->fullname}">{$reviewlike->actor->fullname}</a> 
											
											
											<div class="ff-button">
												{if $reviewlike->actor->countBook > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}/book'" title="">{$reviewlike->actor->countBook} {$lang.default.book}</a> &middot;{/if}
												{if $reviewlike->actor->countSell > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}/shop'" target="_parent" title="">{$reviewlike->actor->countSell} {$lang.default.bookSellCount}</a> &middot;{/if}
												{if $reviewlike->actor->countFav > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}/fav'" title="">{$reviewlike->actor->countFav} {$lang.default.bookCountFav}</a> &middot;{/if}
												{if $reviewlike->actor->countReview > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}/review'" title="">{$reviewlike->actor->countReview} {$lang.default.bookCountReview}</a> &middot;{/if}
												{if $reviewlike->actor->countQuote > 0}<a href="javascript:void(0);" onclick="self.parent.document.location.href='{$reviewlike->actor->getUserPath()}/quote'" title="">{$reviewlike->actor->countQuote} {$lang.default.bookCountQuote}</a> &middot;{/if}
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
		