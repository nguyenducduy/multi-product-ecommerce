<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:11
         compiled from "templates/default/_controller/profile/feed/indexajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3032576135e8ec25b323558-12280771%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc02bfcc6f94bd956b6ef017b99661b230da55c9' => 
    array (
      0 => 'templates/default/_controller/profile/feed/indexajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3032576135e8ec25b323558-12280771',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_safejsname')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.safejsname.php';
?>
<?php  $_smarty_tpl->tpl_vars['feed'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('feedList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['feed']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['feed']->key => $_smarty_tpl->tpl_vars['feed']->value){
 $_smarty_tpl->tpl_vars['feed']->index++;
 $_smarty_tpl->tpl_vars['feed']->first = $_smarty_tpl->tpl_vars['feed']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['feedlist']['first'] = $_smarty_tpl->tpl_vars['feed']->first;
?>
    <div class="act_entry<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['feedlist']['first']&&$_smarty_tpl->getVariable('page')->value==1){?> act_enty_first<?php }?><?php if ($_smarty_tpl->getVariable('feed')->value->minify==1){?> act_entry_minify<?php }?>" id="act_entry_<?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
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
 &raquo;">
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
					
					
					<?php if ($_smarty_tpl->getVariable('me')->value->id>0&&$_smarty_tpl->getVariable('feed')->value->canComment()){?><div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser('<?php echo smarty_modifier_safejsname($_smarty_tpl->getVariable('comment')->value->actor->fullname);?>
', '<?php echo $_smarty_tpl->getVariable('comment')->value->actor->id;?>
', <?php echo $_smarty_tpl->getVariable('feed')->value->id;?>
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
                        <?php if ($_smarty_tpl->getVariable('myPage')->value->uid_creator==$_smarty_tpl->getVariable('me')->value->id){?>
							<a href="<?php echo $_smarty_tpl->getVariable('myUser')->value->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('myUser')->value->fullname;?>
"><img src="<?php echo $_smarty_tpl->getVariable('myUser')->value->getSmallImage();?>
" alt="" /></a>
						<?php }else{ ?>
							<a href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['gotoProfileOf'];?>
 <?php echo $_smarty_tpl->getVariable('me')->value->fullname;?>
"><img src="<?php echo $_smarty_tpl->getVariable('me')->value->getSmallImage();?>
" alt="" /></a>
						<?php }?>
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