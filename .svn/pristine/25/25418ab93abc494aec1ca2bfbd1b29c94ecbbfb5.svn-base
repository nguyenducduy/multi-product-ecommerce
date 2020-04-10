<div id="panelmain">

	<div id="statuswrapper">
		<div id="statusbox">
			<textarea id="statusboxtext" class="mentionable mentionable_status" rows="1" cols="20" onfocus="if($('#statusboxtext').val() == '{$lang.default.statusboxTitleSelf}') $('#statusboxtext').val('')">{$lang.default.statusboxTitleSelf}</textarea>
			
			<div id="statusbox_insertphoto" class="hide">
				<div id="statusbox_photolist"></div>
				<div class="cl"></div>
			</div><!-- end #statusbox_diarysetting -->
			
			
			<div id="statusbox_linkwrapper">
				<div id="statusbox_link" class="hide">
					<input type="hidden" id="statusbox_link_attach" value="0" />
					<div class="box" align="left">
						<input type="hidden" name="cur_image" id="cur_image" />
						<div class="head">{$lang.default.statusboxAddLinkTitle}</div>
						<div class="close" align="right">
							<div class="closes"><a href="javascript:void(0);" onclick="status_attachlink_close()" title="{$lang.default.statusboxAddLinkCloseTitle}">X</a></div>
						</div>
					
						<br clear="all" />
					
						<input type="text" name="url" size="64" id="url" title="http://..." onblur="if($('#url').val().length > 0) status_attachlink_fetch()" />
						<input type="button" name="attach" value="{$lang.default.statusboxAddLinkAttach}" id="attach" onclick="status_attachlink_fetch()" />
						<br clear="all" />
						<div align="center" id="load" style="display:none"><img src="{$imageDir}ajax_indicator.gif" alt="loading..." /></div>
						<div id="loader"></div>
						<br clear="all" />
					</div>
				</div><!-- end #statusbox_link -->
			</div>
			
			
			<div class="statuscontrol" id="statustabstatus_control">
				<div class="sright">
					<input id="statusboxSubmitButton" type="button" value="{$lang.default.statusboxButton}" onclick="user_statusadd('status')" />
				</div>
				
				<div class="sleft">
                      	{if $me->id == 0}
                          	<a href="{$conf.rooturl}login?redirect={$redirectUrl}" title="{$lang.default.mLoginTitle}">{$lang.default.mLogin}</a>
					{else}
						<a href="javascript:void(0)" onclick="$('#statusbox #statusbox_link').show();$('#statusbox #statusbox_link #url').focus();$('#statusbox #statusbox_link_trigger').hide();" id="statusbox_link_trigger" title="{$lang.default.statusboxAddLinkText}" class="tipsy-trigger"><img src="{$imageDir}link-current-map.png" alt="Add Link" /></a>&nbsp;&nbsp;
                          {/if}
				</div>
			</div><!-- end #statustabstatus_control -->
			
			
		</div><!-- end #statusbox -->
	</div><!-- end #statuswrapper -->
		
		
		<h2 style="font-weight:normal; text-transform:uppercase; border-bottom:2px solid #08c; color:#08c; margin:10px 0; padding:10px 0;">{$lang.default.feedTitleSelf}</h2>
		
              
              
		<div id="activitybox">
			<span class="hide" id="activitynextpage">1</span>
		</div>	
		<div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(1)" title="{$lang.controller.feedMoreTitle}">{$lang.default.feedMore}</a></div>
      
      

	
	
</div><!-- end #panelmain -->

<div id="panelright">
	<input type="hidden" id="myuserlikeidscount" value="{$myUserLikeIds|@count}" />
	
	{if $myUserLikeIds|@count > 0}
	<div class="clear"></div>
	
	<div class="headingbox">
	<div class="bookbox" id="panellastfriend">
		
		<h3><a href="{$me->getUserPath()}/page" title="{$lang.default.viewAll}">{$lang.default.fanpage}</a></h3>
		<ul class="linklist user" id="userlikelist">
			
		</ul>
		
	</div><!-- end .bookbox -->
	</div>
	
		<br />
	{/if}
	
	 
	<div id="userprofileright">
		<div class="page-header hide"><h2><i class="icon-dashboard"></i> {$lang.controller.titleDashboardSummary}</h2></div>
		
		<ul class="stats-plain" style="display:none;">
			<li>										
				<h4 id="statuser">33,000</h4>
				<span>Thành viên</span>
			</li>
			<li>										
				<h4 id="statproductview">36,094</h4>
				<span>Lượt xem sản phẩm</span>
			</li>
			
			<li>										
				<h4 id="statsale">300,000,000</h4>
				<span>Doanh thu bán hàng (VND)</span>
			</li>
			<li>										
				<h4 id="statcompletedorder">8,650</h4>
				<span>Đơn hàng hoàn tất</span>
			</li>
		</ul>

		<div id="lastvisitwrapper">
			<div class="page-header"><h2><i class="icon-bookmark"></i> {$lang.controller.titleLastvisit}</h2></div>
			<div id="lastvisit"></div>
		</div><!-- end #lastvisitwrapper -->


	</div><!-- end #userprofileright -->
					
</div><!-- end #panelright -->

    
    {literal}
    <script type="text/javascript">
	$(document).ready(function()
	{
		//user_recommendLoad('lite');
		
		//if($('#myuserlikeidscount').val() > 0)
		//	user_mypage();
		
		//request to update all stat of this user
		//$.get(meurl + '/home/updatestatajax');
		
		//binding inview to load more feed
		user_feedmoreinview();
		
		lastvisit_load();
	});
	
	
	
	</script>
    {/literal}
    
    
    