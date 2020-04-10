<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/_controller/profile/home/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1781999745e8ec25a76e260-21390038%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da4b08daa05d46b4a45fb99acd689125567571f1' => 
    array (
      0 => 'templates/default/_controller/profile/home/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1781999745e8ec25a76e260-21390038',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="panelmain">

	<div id="statuswrapper">
		<div id="statusbox">
			<textarea id="statusboxtext" class="mentionable mentionable_status" rows="1" cols="20" onfocus="if($('#statusboxtext').val() == '<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxTitleSelf'];?>
') $('#statusboxtext').val('')"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxTitleSelf'];?>
</textarea>
			
			<div id="statusbox_insertphoto" class="hide">
				<div id="statusbox_photolist"></div>
				<div class="cl"></div>
			</div><!-- end #statusbox_diarysetting -->
			
			
			<div id="statusbox_linkwrapper">
				<div id="statusbox_link" class="hide">
					<input type="hidden" id="statusbox_link_attach" value="0" />
					<div class="box" align="left">
						<input type="hidden" name="cur_image" id="cur_image" />
						<div class="head"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxAddLinkTitle'];?>
</div>
						<div class="close" align="right">
							<div class="closes"><a href="javascript:void(0);" onclick="status_attachlink_close()" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxAddLinkCloseTitle'];?>
">X</a></div>
						</div>
					
						<br clear="all" />
					
						<input type="text" name="url" size="64" id="url" title="http://..." onblur="if($('#url').val().length > 0) status_attachlink_fetch()" />
						<input type="button" name="attach" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxAddLinkAttach'];?>
" id="attach" onclick="status_attachlink_fetch()" />
						<br clear="all" />
						<div align="center" id="load" style="display:none"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
ajax_indicator.gif" alt="loading..." /></div>
						<div id="loader"></div>
						<br clear="all" />
					</div>
				</div><!-- end #statusbox_link -->
			</div>
			
			
			<div class="statuscontrol" id="statustabstatus_control">
				<div class="sright">
					<input id="statusboxSubmitButton" type="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxButton'];?>
" onclick="user_statusadd('status')" />
				</div>
				
				<div class="sleft">
                      	<?php if ($_smarty_tpl->getVariable('me')->value->id==0){?>
                          	<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
login?redirect=<?php echo $_smarty_tpl->getVariable('redirectUrl')->value;?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['mLoginTitle'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['mLogin'];?>
</a>
					<?php }else{ ?>
						<a href="javascript:void(0)" onclick="$('#statusbox #statusbox_link').show();$('#statusbox #statusbox_link #url').focus();$('#statusbox #statusbox_link_trigger').hide();" id="statusbox_link_trigger" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxAddLinkText'];?>
" class="tipsy-trigger"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
link-current-map.png" alt="Add Link" /></a>&nbsp;&nbsp;
                          <?php }?>
				</div>
			</div><!-- end #statustabstatus_control -->
			
			
		</div><!-- end #statusbox -->
	</div><!-- end #statuswrapper -->
		
		
		<h2 style="font-weight:normal; text-transform:uppercase; border-bottom:2px solid #08c; color:#08c; margin:10px 0; padding:10px 0;"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedTitleSelf'];?>
</h2>
		
              
              
		<div id="activitybox">
			<span class="hide" id="activitynextpage">1</span>
		</div>	
		<div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(1)" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['feedMoreTitle'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedMore'];?>
</a></div>
      
      

	
	
</div><!-- end #panelmain -->

<div id="panelright">
	<input type="hidden" id="myuserlikeidscount" value="<?php echo count($_smarty_tpl->getVariable('myUserLikeIds')->value);?>
" />
	
	<?php if (count($_smarty_tpl->getVariable('myUserLikeIds')->value)>0){?>
	<div class="clear"></div>
	
	<div class="headingbox">
	<div class="bookbox" id="panellastfriend">
		
		<h3><a href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
/page" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['viewAll'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['fanpage'];?>
</a></h3>
		<ul class="linklist user" id="userlikelist">
			
		</ul>
		
	</div><!-- end .bookbox -->
	</div>
	
		<br />
	<?php }?>
	
	 
	<div id="userprofileright">
		<div class="page-header hide"><h2><i class="icon-dashboard"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['titleDashboardSummary'];?>
</h2></div>
		
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
			<div class="page-header"><h2><i class="icon-bookmark"></i> <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['titleLastvisit'];?>
</h2></div>
			<div id="lastvisit"></div>
		</div><!-- end #lastvisitwrapper -->


	</div><!-- end #userprofileright -->
					
</div><!-- end #panelright -->

    
    
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
    
    
    
    