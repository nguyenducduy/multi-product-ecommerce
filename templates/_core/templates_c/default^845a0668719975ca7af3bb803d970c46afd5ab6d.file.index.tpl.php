<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:54:47
         compiled from "templates/default/_controller/profile/index/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1154269685e8ec6b794d0b7-98010169%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '845a0668719975ca7af3bb803d970c46afd5ab6d' => 
    array (
      0 => 'templates/default/_controller/profile/index/index.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1154269685e8ec6b794d0b7-98010169',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_safejsname')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.safejsname.php';
?>
	
<div id="panelmain">
	
	<div id="statuswrapper">
      		
		<div id="statusbox">
              <?php if ($_smarty_tpl->getVariable('me')->value->id>0){?>
				<textarea id="statusboxtext" class="mentionable mentionable_status" rows="1" cols="20" onfocus="if($('#statusboxtext').val() == '<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxTitle'];?>
 <?php echo $_smarty_tpl->getVariable('myUser')->value->fullname;?>
') $('#statusboxtext').val('')"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxTitle'];?>
 <?php echo $_smarty_tpl->getVariable('myUser')->value->fullname;?>
</textarea>
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
					
						<br clear="all" /><br clear="all" />
					
						<input type="text" name="url" size="64" id="url" title="http://..." onblur="if($('#url').val().length > 0) status_attachlink_fetch()" />
						<input type="button" name="attach" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxAddLinkAttach'];?>
" id="attach" onclick="status_attachlink_fetch()" />
						<br clear="all" />
						<div align="center" id="load" style="display:none"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
ajax_indicator.gif" alt="loading..." /></div>
						<div id="loader">
						
						</div>
						<br clear="all" />
					</div>
				</div><!-- end #statusbox_link -->
                  <?php }else{ ?>
                	<textarea disabled="disabled" id="statusboxtext" rows="1" cols="20"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['statusboxLoginWarning'];?>
</textarea>
                <?php }?>
			<div class="statuscontrol">
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
link-current-map.png" alt="Add Link" /></a>
						
						
					<?php }?>
					
				</div>
			</div>
		</div><!-- end #statusbox -->
	</div><!-- end #statuswrapper -->
	
	
	<h2 style="font-weight:normal; text-transform:uppercase; border-bottom:2px solid #08c; color:#08c; margin:10px 0; padding:10px 0;"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedTitle'];?>
 <?php if ($_smarty_tpl->getVariable('myUser')->value->isStaff()==false){?><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['inGroupDepartment'];?>
 <span class="label label-info"><?php echo $_smarty_tpl->getVariable('myUser')->value->getGroupName();?>
</span><?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['ofTitle'];?>
<?php }?> <em>"<?php echo $_smarty_tpl->getVariable('myUser')->value->fullname;?>
"</em></h2>
	
		
		
		
	<div id="activitybox">
            <?php if (count($_smarty_tpl->getVariable('feedList')->value)==0){?>
				<em><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['emptyactivity'];?>
</em>
			<?php }?>
			
            <?php  $_smarty_tpl->tpl_vars['feed'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('feedList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['feed']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['feed']->key => $_smarty_tpl->tpl_vars['feed']->value){
 $_smarty_tpl->tpl_vars['feed']->index++;
 $_smarty_tpl->tpl_vars['feed']->first = $_smarty_tpl->tpl_vars['feed']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['feedlist']['first'] = $_smarty_tpl->tpl_vars['feed']->first;
?>
            	<div class="act_entry<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['feedlist']['first']){?> act_enty_first<?php }?><?php if ($_smarty_tpl->getVariable('feed')->value->minify==1){?> act_entry_minify<?php }?>" id="act_entry_<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
">
		<div class="avatar avatarmain"><a class="tipsy-hovercard-trigger" data-url="<?php echo $_smarty_tpl->getVariable('feed')->value->actor->getHovercardPath();?>
" href="<?php echo $_smarty_tpl->getVariable('feed')->value->actor->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('feed')->value->actor->fullname;?>
"><img src="<?php echo $_smarty_tpl->getVariable('feed')->value->actor->getSmallImage();?>
" alt="" /></a></div>
		<div class="info">
                    	<?php if ($_smarty_tpl->getVariable('feed')->value->minify==1){?>
			<div class="minifyfeedicon"><a class="tipsy-hovercard-trigger" data-url="<?php echo $_smarty_tpl->getVariable('feed')->value->actor->getHovercardPath();?>
" href="<?php echo $_smarty_tpl->getVariable('feed')->value->actor->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('feed')->value->actor->fullname;?>
"><img class="sp sp16 spfeed<?php echo $_smarty_tpl->getVariable('feed')->value->type;?>
 act_entry_avatarfeedicon" src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
blank.png" alt="" /></a></div>
			<?php }?>
                    	<?php echo $_smarty_tpl->getVariable('feed')->value->showDetail(1);?>

			<?php echo $_smarty_tpl->getVariable('feed')->value->showDetailMore(1);?>

		</div>
                    
                    <div class="act_entry_reply<?php if ($_smarty_tpl->getVariable('feed')->value->minify==1){?> hide<?php }?>">
			<?php if ($_smarty_tpl->getVariable('feed')->value->numlike>0){?>
				<?php echo $_smarty_tpl->getVariable('feed')->value->showLike(true);?>

			<?php }?>
                    	<?php if ($_smarty_tpl->getVariable('feed')->value->numcomment>$_smarty_tpl->getVariable('setting')->value['feed']['commentShowPerFeed']){?>
                        	<div class="act_entry_reply_showmore">
					<input type="hidden" id="act_entry_reply_morestart_<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
" value="<?php echo $_smarty_tpl->getVariable('setting')->value['feed']['commentShowPerFeed'];?>
" />
					<input type="button" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedCommentShowMoreTitle'];?>
" onclick="user_feedcomment(<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedCommentShowMore'];?>
 &raquo;" class="btn">
					<img class="hide" src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
ajax_indicator.gif" />
					<span><?php echo $_smarty_tpl->getVariable('setting')->value['feed']['commentShowPerFeed'];?>
/<?php echo $_smarty_tpl->getVariable('feed')->value->numcomment;?>
</span>
					
				</div>
                        <?php }?>
                        
                    	<?php  $_smarty_tpl->tpl_vars['comment'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('feed')->value->comments; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['comment']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['comment']->key => $_smarty_tpl->tpl_vars['comment']->value){
 $_smarty_tpl->tpl_vars['comment']->index++;
 $_smarty_tpl->tpl_vars['comment']->first = $_smarty_tpl->tpl_vars['comment']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['feedcomment']['first'] = $_smarty_tpl->tpl_vars['comment']->first;
?>
			<div class="act_reply" id="act_reply_<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
">
				<div class="avatar">
					<a class="tipsy-hovercard-trigger" data-url="<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getHovercardPath();?>
" href="<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('comment')->value->actor->fullname;?>
"><img src="<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getSmallImage();?>
" alt="" /></a>
				</div>
				<div class="info">
					
					<?php if ($_smarty_tpl->getVariable('feed')->value->canDelete($_smarty_tpl->getVariable('me')->value->id)||$_smarty_tpl->getVariable('comment')->value->canDelete($_smarty_tpl->getVariable('me')->value->id)){?>
						<div class="delete remove_btn"><a href="javascript:void(0)" onclick="feedCommentRemove('<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
')" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedReplyDeleteTitle'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['delete'];?>
</a>&nbsp;&nbsp;</div>
					<?php }?>

					<?php if ($_smarty_tpl->getVariable('comment')->value->canEdit($_smarty_tpl->getVariable('me')->value->id)){?>
						<div class="edit edit_btn">&middot; <a href="javascript:void(0)" onclick="feedCommentEdit_popup('<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
')" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedReplyEditTitle'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['edit'];?>
</a>&nbsp;&nbsp;</div>
					<?php }?>
					
					
					
					<?php if ($_smarty_tpl->getVariable('me')->value->id>0&&$_smarty_tpl->getVariable('feed')->value->canComment()){?><div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('<?php echo smarty_modifier_safejsname($_smarty_tpl->getVariable('comment')->value->actor->fullname,true);?>
', '<?php echo $_smarty_tpl->getVariable('comment')->value->actor->id;?>
',  <?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedReplyToUserTitle'];?>
 <?php echo $_smarty_tpl->getVariable('comment')->value->actor->fullname;?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['reply'];?>
</a></div><?php }?>
					
					
					
					<div class="text"><a class="username tipsy-hovercard-trigger" data-url="<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getHovercardPath();?>
" href="<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('comment')->value->actor->fullname;?>
"><?php echo $_smarty_tpl->getVariable('comment')->value->actor->fullname;?>
<?php echo $_smarty_tpl->getVariable('comment')->value->actor->getNameIcon();?>
</a> <span class="datetime relativetime"><?php echo $_smarty_tpl->getVariable('comment')->value->datecreated;?>
</span><br />
					<span class="commenttext"><?php echo $_smarty_tpl->getVariable('comment')->value->getText();?>
</span></div>
					<div class="more">
						
					</div>
				</div>
			</div><!-- end .act_reply -->
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['feedcomment']['first']){?><input type="hidden" id="act_entry_comment_first_<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
" value="<?php echo $_smarty_tpl->getVariable('comment')->value->id;?>
" /><?php }?>
                        <?php }} ?>
			
			<?php if ($_smarty_tpl->getVariable('me')->value->id>0&&$_smarty_tpl->getVariable('feed')->value->canComment()){?>
                        	<div class="act_reply act_reply_add<?php if ($_smarty_tpl->getVariable('feed')->value->canCommentMinimum()&&$_smarty_tpl->getVariable('feed')->value->numcomment==0){?> hide<?php }?>">
                          
                            
                                <div class="avatar">
                                    <a href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('me')->value->fullname;?>
"><img src="<?php echo $_smarty_tpl->getVariable('me')->value->getSmallImage();?>
" alt="" /></a>
                                </div>
                                <div class="info">
                                    
                                    <textarea title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedReplyTextboxTitle'];?>
" class="fmessage mentionable mentionable_feed<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
" name="" rows="1" cols="10" onfocus="user_onFeedReplyFocus(<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)" onblur="user_onFeedReplyBlur(<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)" onkeypress="user_onFeedReplyKeypress(event, <?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedReplyDefaultText'];?>
</textarea>

                                    <input class="button" type="button" value="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedCommentButton'];?>
" onclick="user_feedcommentadd(<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
)" />
                                    
                                </div>
                            
				</div><!-- end .act_reply -->
			<?php }?>
		</div>
                    
                    <div class="clear"></div>
                </div>
            <?php }} ?>
            <span class="hide" id="activitynextpage">2</span>
            </div><!-- end #activitybox -->
            <div id="activitymore"><a href="javascript:void(0)" onclick="user_feedMore(0)" title="<?php echo $_smarty_tpl->getVariable('lang')->value['controller']['feedMoreTitle'];?>
"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['feedMore'];?>
</a></div>
    </div><!-- end #panelmain -->
    
	<div id="panelsub">
    	<div id="profileinfo"></div>
	</div><!-- end #panelsub -->




   
   
   <script type="text/javascript">
$(document).ready(function()
{

	//binding inview to load more feed
	user_feedmoreinview();
	
	feedPostProcess();
	user_loadprofile();

});


</script>
   
   
   
    