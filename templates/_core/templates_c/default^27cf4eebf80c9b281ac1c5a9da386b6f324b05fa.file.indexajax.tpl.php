<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:38:07
         compiled from "templates/default/_controller/site/productreview/indexajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12692418735e8ec2cf076979-57111206%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27cf4eebf80c9b281ac1c5a9da386b6f324b05fa' => 
    array (
      0 => 'templates/default/_controller/site/productreview/indexajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12692418735e8ec2cf076979-57111206',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
?><div class="commentbar"><h2><?php if (count($_smarty_tpl->getVariable('productreviewList')->value)>0){?>Có <span><?php echo $_smarty_tpl->getVariable('total')->value;?>
</span> nhận xét <?php }else{ ?>Bình luận<?php }?></h2></div>
<input id="productreviewtotal" value="<?php echo $_smarty_tpl->getVariable('total')->value;?>
" type="hidden" />
<div class="writecom">    
    <div class="notifireview"></div>
    <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/user.jpg">
    <textarea class="writepost" rows="" cols="" name="freviewcontent" id="freviewcontent" placeholder="Nhận xét của bạn về sản phẩm"></textarea>
    <?php if ($_smarty_tpl->getVariable('registry')->value->me->id>0){?>
        <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('registry')->value->me->fullname;?>
" id="usernamereview">
    <?php }else{ ?>
        <input type="hidden" value="" id="usernamereview">
    <?php }?>
    <div style="padding-left:70px;">Còn lại <span id="contentcounter">1000</span> ký tự</div>
    <?php if (count($_smarty_tpl->getVariable('productreviewList')->value)>0){?>
    <div class="sortcomm"><span>Sắp xếp theo</span>
        <select class="choosecomm" name="forder" id="forder" onchange="orderreview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
)">
            <option value="">Sắp xếp theo</option>
            <option value="lasted" <?php if ($_smarty_tpl->getVariable('order')->value=='lasted'){?>selected="selected"<?php }?>>Mới
                    nhất</option>
            <option value="like" <?php if ($_smarty_tpl->getVariable('order')->value=='like'){?>selected="selected"<?php }?>>Thích
                    nhất</option>
        </select>
    </div>
    <?php }?>    
    <div class="combtn">
        <span class="loading"></span>
        <?php if ($_smarty_tpl->getVariable('registry')->value->me->id>0){?>
        <a href="javascript:void(0)" class="btn-blues" onclick="sendReview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
 , 0 , <?php if ($_smarty_tpl->getVariable('registry')->value->me->id>0){?>1<?php }else{ ?>0<?php }?> , -1)">Gửi bình luận &#187;</a>
        <?php }else{ ?>
        <a>Bình luận với tư cách là ...</a>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
" id="reviewid"/>
            <div class="droppost optionreview1">
                <div class="notifireviewthumb"></div>
                <a style="cursor: pointer" class="ismember" rel="false" title="" onclick="ischange()">Đã là thành viên điện máy? Đăng nhập &#187;</a>
                <input name="" type="text" placeholder="Mời bạn nhập tên (bắt buộc)" id="username">
                <input name="" type="text" placeholder="Mời bạn nhập email (bắt buộc)" id="email">
                <input class="check" name="" checked type="checkbox" value="">
                <label>Thông báo cho tôi khi có phản hồi từ dienmay.com</label>
                <a href="javascript:void(0)" class="btn-blues" onclick="sendReview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
 , 0 , 0 , -1)">Gửi bình luận &#187;</a>
            </div>
         <?php }?>

    </div>
     <div class="clear"></div>  
</div>
<div class="clear"></div>
<!-- Question -->
<div class="review-product">
<?php if (count($_smarty_tpl->getVariable('productreviewList')->value)>0){?>
<?php  $_smarty_tpl->tpl_vars['productreviews'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['parentid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productreviewList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productreviews']->key => $_smarty_tpl->tpl_vars['productreviews']->value){
 $_smarty_tpl->tpl_vars['parentid']->value = $_smarty_tpl->tpl_vars['productreviews']->key;
?>
<?php  $_smarty_tpl->tpl_vars['productreview'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['productreviews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['productreview']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productreview']->key => $_smarty_tpl->tpl_vars['productreview']->value){
 $_smarty_tpl->tpl_vars['productreview']->index++;
 $_smarty_tpl->tpl_vars['productreview']->first = $_smarty_tpl->tpl_vars['productreview']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['foo']['first'] = $_smarty_tpl->tpl_vars['productreview']->first;
?>

<div class="wrap-querep">
    <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['foo']['first']){?>
    <div class="question">
        <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/user.jpg">
        <div class="questiontext">
            <span><?php if (in_array($_smarty_tpl->getVariable('productreview')->value->uid,$_smarty_tpl->getVariable('admindienmayarr')->value)){?>dienmay.com<?php }else{ ?><?php echo $_smarty_tpl->getVariable('productreview')->value->fullname;?>
<?php }?></span>
            <p><?php echo $_smarty_tpl->getVariable('productreview')->value->text;?>
</p>
            <ul>
                <li id="likeproductreview<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><a href="javascript:void(0)" onclick="likereview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
,<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
)">Thích</a></li>
                <li id="likecom<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><i class="icon-likecom"></i><span id="like<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('productreview')->value->countthumbup;?>
</span></li>
                <li><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('productreview')->value->datecreated,"%d/%m/%Y");?>
</li>
            </ul>
        </div>
    </div>
    <?php }else{ ?>
    <div class="reply">
        <div class="arrowcomm"></div>
        <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/user.jpg">
        <div class="replytext">
            <span><?php if (in_array($_smarty_tpl->getVariable('productreview')->value->uid,$_smarty_tpl->getVariable('admindienmayarr')->value)){?>dienmay.com<?php }else{ ?><?php echo $_smarty_tpl->getVariable('productreview')->value->fullname;?>
<?php }?></span>
            <p><?php echo $_smarty_tpl->getVariable('productreview')->value->text;?>
</p>
            <ul>
                <li id="likeproductreview<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><a href="javascript:void(0)" onclick="likereview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
,<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
)">Thích</a></li>
                <li id="likecom<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><i class="icon-likecom"></i><span id="like<?php echo $_smarty_tpl->getVariable('productreview')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('productreview')->value->countthumbup;?>
<span></li>
                <li><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('productreview')->value->datecreated,"%d/%m/%Y");?>
</li>
            </ul>
        </div>
    </div>
    <?php }?>
</div>

<?php }} ?>
<?php }} ?>
<?php }else{ ?>
<div class="wrap-querep"></div>
<?php }?>
</div>

<?php if ($_smarty_tpl->getVariable('total')->value>$_smarty_tpl->getVariable('recordPerPage')->value){?>
<div class="viewallproducts"><a href="javascript:void(0)" onclick="loadmoreReview(<?php echo $_smarty_tpl->getVariable('fpid')->value;?>
)">Mời bạn xem thêm ››</a></div>
<?php }?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.writepost').limit(1000 , "#contentcounter");
        //$('.writepostreply').limit(1000 , ".countercontentdata");
    });
</script>

