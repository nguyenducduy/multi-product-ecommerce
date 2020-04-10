<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:38:53
         compiled from "templates/default/_controller/site/product/productparentnew.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19702262955e8ec2fddc4ff1-30724046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84f08e26c698113fe901d601bd28571f46c58b43' => 
    array (
      0 => 'templates/default/_controller/site/product/productparentnew.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19702262955e8ec2fddc4ff1-30724046',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_function_paginateul')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.paginateul.php';
if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
?><div class="navbarprod"><ul><li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
" title="dienmay.com">Trang chủ</a> ››</li><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)||!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['DELETEDURL'])){?><li><a href="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
" title="<?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->seotitle)){?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('curCategory')->value->seotitle);?>
<?php }else{ ?><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('curCategory')->value->name);?>
<?php }?>"><?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
 </a> ››</li><?php }else{ ?><li><?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
</li><?php }?><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)){?><?php if (!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['DELETEDURL'])){?><li><a href="<?php echo $_smarty_tpl->getVariable('pageCanonical')->value;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('myVendors')->value->name);?>
" id="vendor" rel="<?php echo $_smarty_tpl->getVariable('myVendors')->value->id;?>
"><?php echo $_smarty_tpl->getVariable('myVendors')->value->name;?>
</a> ››</li><?php }else{ ?><li><?php echo $_smarty_tpl->getVariable('myVendors')->value->name;?>
</li><?php }?><?php }?><li><?php if (!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['DELETEDURL'])){?><?php  $_smarty_tpl->tpl_vars['delurl'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attributeList')->value['DELETEDURL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['delurl']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['delurl']->iteration=0;
if ($_smarty_tpl->tpl_vars['delurl']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['delurl']->key => $_smarty_tpl->tpl_vars['delurl']->value){
 $_smarty_tpl->tpl_vars['delurl']->iteration++;
 $_smarty_tpl->tpl_vars['delurl']->last = $_smarty_tpl->tpl_vars['delurl']->iteration === $_smarty_tpl->tpl_vars['delurl']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['namedelurl']['last'] = $_smarty_tpl->tpl_vars['delurl']->last;
?><?php echo $_smarty_tpl->tpl_vars['delurl']->value['name'];?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['namedelurl']['last']){?><?php }else{ ?>,<?php }?><?php }} ?><?php }?></li></ul><div class="socialbar"><div class="likepage"><label>Bạn thích trang này?</label><span><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe></span></div><div class="sharepage"><label>Chia sẻ</label><span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
"><i class="icon-face"></i></a></span><span><a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
"><i class="icon-goog"></i></a></span><span><a href="http://twitthis.com/twit?url=<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
"><i class="icon-twitter"></i></a></span></div></div></div><div id="container"><?php if (count($_smarty_tpl->getVariable('bannerProduct')->value)>0){?><div class="bn_depart" ><div id="bannerProduct"><ul class="bjqs"><?php  $_smarty_tpl->tpl_vars['bnProduct'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('bannerProduct')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['bnProduct']->key => $_smarty_tpl->tpl_vars['bnProduct']->value){
?><li><a href="<?php echo $_smarty_tpl->getVariable('bnProduct')->value->link;?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('bnProduct')->value->title);?>
"><img src="<?php echo $_smarty_tpl->getVariable('bnProduct')->value->getImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('bnProduct')->value->title);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('bnProduct')->value->title);?>
"></a></li><?php }} ?></ul></div></div><?php }?><div class="colleft"><div class="colleftbrand"><h3 class="titlenav"><?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
</h3><ul style="max-height: none;"><?php  $_smarty_tpl->tpl_vars['fcat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listChildCat')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topsubcat']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fcat']->key => $_smarty_tpl->tpl_vars['fcat']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topsubcat']['iteration']++;
?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('fcat')->value->name;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1==$_tmp2){?><?php continue 1?><?php }?><li><a href="<?php echo $_smarty_tpl->getVariable('fcat')->value->getProductcateoryPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fcat')->value->name);?>
"><?php echo $_smarty_tpl->getVariable('fcat')->value->name;?>
</a></li><?php }} ?><?php echo $_smarty_tpl->getVariable('curCategory')->value->categoryreference;?>
</ul></div><?php if (count($_smarty_tpl->getVariable('arrVendorselect')->value)>0||!empty($_GET['a'])){?><div class="colleftbrand"> <h3>Bộ lọc hiện tại</h3><ul><?php  $_smarty_tpl->tpl_vars['vendorselect'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrVendorselect')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendorselect']->key => $_smarty_tpl->tpl_vars['vendorselect']->value){
?><?php  $_smarty_tpl->tpl_vars['ven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ven']->key => $_smarty_tpl->tpl_vars['ven']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
?><?php if ($_smarty_tpl->getVariable('listvendors')->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1]==$_smarty_tpl->tpl_vars['vendorselect']->value){?><li><a class="subli" title="<?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
" href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
</a><div class="clearfilter"><a title="Xóa" href="<?php echo $_smarty_tpl->getVariable('listvendors')->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1];?>
">&#215;</a></div></li><?php }?><?php }} ?><?php }} ?><?php if (!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['LEFT'])){?><?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attributeList')->value['LEFT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']++;
?><?php if (count($_smarty_tpl->getVariable('attribute')->value->value)>0){?><?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[0])){?><?php  $_smarty_tpl->tpl_vars['attrvalue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attribute')->value->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['attrvalue']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['attrvalue']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['iteration']=0;
if ($_smarty_tpl->tpl_vars['attrvalue']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attrvalue']->key => $_smarty_tpl->tpl_vars['attrvalue']->value){
 $_smarty_tpl->tpl_vars['attrvalue']->iteration++;
 $_smarty_tpl->tpl_vars['attrvalue']->last = $_smarty_tpl->tpl_vars['attrvalue']->iteration === $_smarty_tpl->tpl_vars['attrvalue']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['last'] = $_smarty_tpl->tpl_vars['attrvalue']->last;
?><?php if (!empty($_smarty_tpl->tpl_vars['attrvalue']->value)){?><?php if (in_array($_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1],explode(',',$_GET['a']))!==false){?><li><a class="subli" title="<?php echo trim($_smarty_tpl->tpl_vars['attrvalue']->value);?>
" href="javascript:;"><?php echo trim($_smarty_tpl->tpl_vars['attrvalue']->value);?>
</a><div class="clearfilter"><a title="Xóa" href="<?php if (strpos($_GET['a'],$_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1])===false){?><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)&&!empty($_smarty_tpl->getVariable('pageCanonical',null,true,false)->value)){?><?php echo trim($_smarty_tpl->getVariable('pageCanonical')->value);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php }?><?php if ($_GET['vendor']!=''){?>?vendor=<?php echo trim($_GET['vendor']);?>
&<?php }else{ ?>?<?php }?>a=<?php echo trim($_smarty_tpl->getVariable('attribute')->value->panameseo);?>
,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[2][$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['attributelistname']['iteration']-1])){?>,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?><?php }else{ ?><?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[3][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?>">&#215;</a></div></li><?php }?><?php }?><?php }} ?><?php }?><?php }?><?php }} ?><?php }?></ul></div><?php }?><div class="colleftbrand"> <h3>Nhà sản xuất</h3><div class="searchbrand"><input class="inputbrand" name="" id="autosearchtextbrand" type="text" placeholder="Tìm theo thương hiệu ..." /><input class="btnseabrand" type="button" value="Tìm" /></div><ul class="textbrand"><?php  $_smarty_tpl->tpl_vars['ven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ven']->key => $_smarty_tpl->tpl_vars['ven']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
?><li> <a class="subli checkbox-sort <?php if (in_array($_smarty_tpl->getVariable('listvendors')->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1],explode(',',$_GET['vendor']))!==false||($_GET['fvid']!=''&&$_GET['fvid']==$_smarty_tpl->getVariable('listvendors')->value[3][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1])||($_smarty_tpl->getVariable('singlevendorname')->value!=''&&$_smarty_tpl->getVariable('singlevendorname')->value==$_smarty_tpl->getVariable('listvendors')->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1])){?>active<?php }else{ ?><?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
" href="<?php echo $_smarty_tpl->getVariable('listvendors')->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1];?>
"><?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
</a></li><?php }} ?></ul></div><?php if (!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['LEFT'])){?><?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attributeList')->value['LEFT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']++;
?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['topattributeout']['iteration']==1){?><?php if (count($_smarty_tpl->getVariable('attribute')->value->value)>0){?><div class="colleftbrand"><h3>Lọc theo giá</h3><ul><?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[0])){?><?php  $_smarty_tpl->tpl_vars['attrvalue'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attribute')->value->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['attrvalue']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['attrvalue']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['iteration']=0;
if ($_smarty_tpl->tpl_vars['attrvalue']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attrvalue']->key => $_smarty_tpl->tpl_vars['attrvalue']->value){
 $_smarty_tpl->tpl_vars['attrvalue']->iteration++;
 $_smarty_tpl->tpl_vars['attrvalue']->last = $_smarty_tpl->tpl_vars['attrvalue']->iteration === $_smarty_tpl->tpl_vars['attrvalue']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attributelistname']['last'] = $_smarty_tpl->tpl_vars['attrvalue']->last;
?><?php if (!empty($_smarty_tpl->tpl_vars['attrvalue']->value)){?><li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']>10){?>hidden filter<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['topattributeout']['iteration'];?>
<?php }?>"><a class="subli checkbox-sort <?php if (in_array($_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1],explode(',',$_GET['a']))!==false){?>active<?php }else{ ?><?php }?>" href="<?php if (strpos($_GET['a'],$_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1])===false){?><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)&&!empty($_smarty_tpl->getVariable('paginateurl',null,true,false)->value)){?><?php echo trim($_smarty_tpl->getVariable('paginateurl')->value);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php }?><?php if ($_GET['vendor']!=''){?>?vendor=<?php echo trim($_GET['vendor']);?>
&<?php }else{ ?>?<?php }?>a=<?php echo trim($_smarty_tpl->getVariable('attribute')->value->panameseo);?>
,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[2][$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['attributelistname']['iteration']-1])){?>,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?><?php }else{ ?><?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[3][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?>" title="<?php echo trim($_smarty_tpl->tpl_vars['attrvalue']->value);?>
"><?php echo trim($_smarty_tpl->tpl_vars['attrvalue']->value);?>
</a></li><?php }?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']>10&&$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['last']){?><li><a class="subli filterseemore" href="javascript:void(0)" rel="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['topattributeout']['iteration'];?>
">Xem thêm</a></li><?php }?><?php }} ?><?php }?></ul><div class="searchprice"><span>Hoặc</span><input class="inputprice" id="pricefrom" value="<?php echo substr($_GET['pricefrom'],0,-3);?>
" name="pricefrom" type="text" placeholder="Từ" /><label>.000</label><input class="inputprice" id="priceto" value="<?php echo substr($_GET['priceto'],0,-3);?>
" name="priceto" type="text" placeholder="Đến" /><label>.000</label><div class="clear"></div><input onclick="detectprice('<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
');" class="btnseaprice" id="btnfilter" name="btnfilter" type="button" value="Tìm" /><p id="pricenotify"></p></div></div><?php }?><?php }?><?php }} ?><?php }?><!--<div class="wrapnavcate"><span><?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
</span><ul id="navcate"><?php  $_smarty_tpl->tpl_vars['fcat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listChildCat')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topsubcat']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fcat']->key => $_smarty_tpl->tpl_vars['fcat']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topsubcat']['iteration']++;
?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['topsubcat']['iteration']==1){?><?php continue 1?><?php }?><li><a title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fcat')->value->name);?>
" href="<?php echo $_smarty_tpl->getVariable('fcat')->value->getProductcateoryPath();?>
" class="sub" tabindex="1"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fcat')->value->name);?>
</a><img style="top:0" src="images/up.gif" alt="" /><?php if (!empty($_smarty_tpl->getVariable('listvendors',null,true,false)->value)){?><ul class="marleftnavcate"><?php if (!empty($_smarty_tpl->getVariable('listvendors',null,true,false)->value[$_smarty_tpl->getVariable('fcat',null,true,false)->value->id])){?><?php  $_smarty_tpl->tpl_vars['myven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[$_smarty_tpl->getVariable('fcat')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['myven']->key => $_smarty_tpl->tpl_vars['myven']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
?><?php if (!empty($_smarty_tpl->getVariable('myven',null,true,false)->value->name)&&$_smarty_tpl->getVariable('myven')->value->name!='-'){?><li><a title="<?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
" href="<?php echo $_smarty_tpl->getVariable('myven')->value->getVendorPath($_smarty_tpl->getVariable('fcat')->value->id);?>
"><?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
</a></li><?php }?><?php }} ?><?php }?></ul><?php }?></li><?php }} ?></ul></div>--></div><!-- Box html trắng --><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->blockcategory)){?><div id="wrapdepart"> <?php echo $_smarty_tpl->getVariable('curCategory')->value->blockcategory;?>
</div><?php }?><!-- slide khuyến mãi --><?php if (!empty($_smarty_tpl->getVariable('listtopprouct',null,true,false)->value)){?><div id="wrapdepart"><div class="bartopsale"><h2 class="titlehot">Top <?php echo count($_smarty_tpl->getVariable('listtopprouct')->value);?>
 sản phẩm bán chạy nhất</h2></div><div class="m-carousel m-fluid m-carousel-photos m-top-product"><!-- the slider --><div class="m-carousel-inner "><!-- the items --><div class="m-item m-active"><?php  $_smarty_tpl->tpl_vars['topproduct'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listtopprouct')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listtopproduct']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['topproduct']->key => $_smarty_tpl->tpl_vars['topproduct']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listtopproduct']['iteration']++;
?><?php $_smarty_tpl->tpl_vars["promotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('topproduct')->value->promotionPrice(), null, null);?><div class="tagcentertext"><?php if ($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="tagtopsale"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="tagtopsale"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="tagtopsale"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="tagtopsale"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="tagtopsale"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="tagtopsale"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="tagtopsale"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('topproduct')->value->instock==0){?><div class="tagtopsale"><i class="icon-theend"></i></div><?php }?><!--<div class="bghover"></div>--><a href="<?php echo $_smarty_tpl->getVariable('topproduct')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('topproduct')->value->name;?>
"><?php echo $_smarty_tpl->getVariable('topproduct')->value->name;?>
</a><a href="<?php echo $_smarty_tpl->getVariable('topproduct')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('topproduct')->value->name;?>
"><img src="<?php echo $_smarty_tpl->getVariable('topproduct')->value->getSmallImage();?>
" alt="<?php echo $_smarty_tpl->getVariable('topproduct')->value->name;?>
" title="<?php echo $_smarty_tpl->getVariable('topproduct')->value->name;?>
" /> </a><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('topproduct')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('topproduct')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('topproduct')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('topproduct')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('topproduct')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('topproduct')->value->sellprice>0&&$_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('topproduct')->value->sellprice){?><strong class="pricenew"><?php if ($_smarty_tpl->getVariable('promotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</strong><div class="th_center"><?php if ($_smarty_tpl->getVariable('topproduct')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('topproduct')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('topproduct')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('topproduct')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><strong class="pricenew"><?php if ($_smarty_tpl->getVariable('topproduct')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('topproduct')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</strong><?php }elseif($_smarty_tpl->getVariable('topproduct')->value->sellprice>0){?><strong class="pricenew"><?php if ($_smarty_tpl->getVariable('topproduct')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('topproduct')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</strong><?php }?></div><div class="descenter"><?php  $_smarty_tpl->tpl_vars['summary'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topproduct')->value->summarynew; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['summary']->key => $_smarty_tpl->tpl_vars['summary']->value){
?><span>›› <?php echo $_smarty_tpl->tpl_vars['summary']->value;?>
</span><?php }} ?></div><?php if (!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['promodescription'])&&trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('promotionprices')->value['promodescription']))!='.'&&trim(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('promotionprices')->value['promodescription']))!='-'){?><div class="giftcenter"><i class="icon-gift"></i><?php echo $_smarty_tpl->getVariable('promotionprices')->value['promodescription'];?>
</div><?php }?></div><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['listtopproduct']['iteration']%2==0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['listtopproduct']['iteration']<count($_smarty_tpl->getVariable('listtopprouct')->value)){?></div><div class="m-item"><?php }?><?php }?><?php }} ?></div></div><!-- the controls --><?php if (count($_smarty_tpl->getVariable('listtopprouct')->value)>2){?><div class="m-carousel-controls m-carousel-pagination"><div class="prev"><a href="#" data-slide="prev">«</a></div><div class="next"><a href="#" data-slide="next">»</a></div></div><?php }?></div></div><?php }?><!-- filter center --><div id="rowview"><div class="viewpromo"><a class="checkpromotion checkbox-sort <?php if ($_smarty_tpl->getVariable('promotion')->value=='khuyen-mai'){?>active<?php }?>" title="Xem sản phẩm <?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
 đang khuyến  mãi" href="<?php if ($_smarty_tpl->getVariable('promotion')->value!='khuyen-mai'){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php echo $_smarty_tpl->getVariable('myVendors')->value->slug;?>
<?php if ($_smarty_tpl->getVariable('myVendors')->value->arrslug){?>?vendor=<?php echo $_smarty_tpl->getVariable('myVendors')->value->arrslug;?>
<?php if ($_smarty_tpl->getVariable('attributeList')->value['VALUE']){?>&a=<?php echo $_smarty_tpl->getVariable('attributeList')->value['VALUE'];?>
<?php }?>&f=khuyen-mai<?php }else{ ?><?php if ($_smarty_tpl->getVariable('attributeList')->value['VALUE']){?>?a=<?php echo $_smarty_tpl->getVariable('attributeList')->value['VALUE'];?>
&f=khuyen-mai<?php }else{ ?>?f=khuyen-mai<?php }?><?php }?><?php if (!empty($_GET['pricefrom'])||!empty($_GET['priceto'])){?>&pricefrom=<?php echo $_GET['pricefrom'];?>
&priceto=<?php echo $_GET['priceto'];?>
<?php }?><?php }else{ ?><?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php if ($_smarty_tpl->getVariable('myVendors')->value->arrslug){?>?vendor=<?php echo $_smarty_tpl->getVariable('myVendors')->value->arrslug;?>
<?php if ($_smarty_tpl->getVariable('attributeList')->value['VALUE']){?>&a=<?php echo $_smarty_tpl->getVariable('attributeList')->value['VALUE'];?>
<?php }?><?php if (!empty($_GET['pricefrom'])||!empty($_GET['priceto'])){?>&pricefrom=<?php echo $_GET['pricefrom'];?>
&priceto=<?php echo $_GET['priceto'];?>
<?php }?><?php }else{ ?><?php if ($_smarty_tpl->getVariable('attributeList')->value['VALUE']){?>?a=<?php echo $_smarty_tpl->getVariable('attributeList')->value['VALUE'];?>
<?php if (!empty($_GET['pricefrom'])||!empty($_GET['priceto'])){?>&pricefrom=<?php echo $_GET['pricefrom'];?>
&priceto=<?php echo $_GET['priceto'];?>
<?php }?><?php }else{ ?><?php if (!empty($_GET['pricefrom'])||!empty($_GET['priceto'])){?>?pricefrom=<?php echo $_GET['pricefrom'];?>
&priceto=<?php echo $_GET['priceto'];?>
<?php }?><?php }?><?php }?><?php }?>">Xem sản phẩm <?php echo $_smarty_tpl->getVariable('curCategory')->value->name;?>
 đang khuyến  mãi</a></div><div class="sortprice"><label>Sắp xếp sản phẩm theo</label><select class="listmenu" onchange="window.location.href = this.value;"><option value="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
">Mặc định</option><option value="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php if (!empty($_smarty_tpl->getVariable('urlsort',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('urlsort')->value;?>
&o=gia-cao-den-thap<?php }else{ ?>?o=gia-cao-den-thap<?php }?>" <?php if ($_smarty_tpl->getVariable('order')->value=='gia-cao-den-thap'){?> selected="selected" <?php }?>>Giá từ cao đến thấp</option><option value="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php if (!empty($_smarty_tpl->getVariable('urlsort',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('urlsort')->value;?>
&o=gia-thap-den-cao<?php }else{ ?>?o=gia-thap-den-cao<?php }?>" <?php if ($_smarty_tpl->getVariable('order')->value=='gia-thap-den-cao'){?> selected="selected" <?php }?>>Giá từ thấp đến cao</option><option value="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php if (!empty($_smarty_tpl->getVariable('urlsort',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('urlsort')->value;?>
&o=moi-nhat<?php }else{ ?>?o=moi-nhat<?php }?>" <?php if ($_smarty_tpl->getVariable('order')->value=='moi-nhat'){?> selected="selected" <?php }?>>Mới nhất</option><option value="<?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php if (!empty($_smarty_tpl->getVariable('urlsort',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('urlsort')->value;?>
&o=duoc-quan-tam-nhat<?php }else{ ?>?o=duoc-quan-tam-nhat<?php }?>" <?php if ($_smarty_tpl->getVariable('order')->value=='duoc-quan-tam-nhat'){?> selected="selected" <?php }?>>Được quan tâm nhất</option></select></div></div><!-- danh sách sản phẩm ngành hàng --><div id="wrapdepart"><div class="products"><?php if (count($_smarty_tpl->getVariable('productlists')->value)>0){?><ul><?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productlists')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?><?php $_smarty_tpl->tpl_vars["promotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->promotionPrice(), null, null);?><li><?php if (count($_smarty_tpl->getVariable('listProductColor')->value[$_smarty_tpl->getVariable('product')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['toplistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listProductColor')->value[$_smarty_tpl->getVariable('product')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toplistcolor']->key => $_smarty_tpl->tpl_vars['toplistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['toplistcolorname']['index']>4){?><?php break 1?><?php }?><li><a class="qtootip" href="<?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('product')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('product')->value->name;?>
"><img src="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
" title="<?php echo $_smarty_tpl->getVariable('product')->value->name;?>
" /> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
"><h3><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
</h3></a><div class="<?php if ($_smarty_tpl->getVariable('product')->value->onsitestatus!=$_smarty_tpl->getVariable('OsCommingSoon')->value){?>loadprice<?php }?> lp<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('product')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('product')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('product')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('product')->value->sellprice>0&&$_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('product')->value->sellprice){?><div class="priceold price1"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
 đ<?php }?></div><div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('promotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
 đ<?php }?></div><span class="salepercent">-<?php echo floor((($_smarty_tpl->getVariable('product')->value->sellprice-$_smarty_tpl->getVariable('promotionprices')->value['price'])/$_smarty_tpl->getVariable('product')->value->sellprice*100));?>
%</span><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('product')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('product')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('product')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->prepaidprice);?>
 đ<?php }?></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('product')->value->comingsoonprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->comingsoonprice);?>
 đ<?php }?> </div><?php }elseif($_smarty_tpl->getVariable('product')->value->sellprice>0){?><div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
 đ<?php }?> </div><?php }?></div></li><?php }} ?></ul></div><?php $_smarty_tpl->tpl_vars["pageurl"] = new Smarty_variable("page-::PAGE::", null, null);?><?php echo smarty_function_paginateul(array('count'=>$_smarty_tpl->getVariable('totalPage')->value,'curr'=>$_smarty_tpl->getVariable('curPage')->value,'lang'=>$_smarty_tpl->getVariable('paginateLang')->value,'max'=>10,'url'=>($_smarty_tpl->getVariable('paginateurl')->value)."/".($_smarty_tpl->getVariable('pageurl')->value)),$_smarty_tpl);?>
<?php if ($_smarty_tpl->getVariable('totalproductpage')->value>0){?><div class="seecontinue">Mời bạn xem tiếp ( còn <?php echo $_smarty_tpl->getVariable('totalproductpage')->value;?>
 sản phẩm )</div><?php }?><?php }else{ ?><span>Không tìm thấy sản phẩm theo tiêu chí.</span><?php }?></div><!-- pagnation --></div><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol1)||!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol2)||!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol3)){?><!--trai nghiem, cam nang --><div id="experiencehandbook"><div class="experience" <?php if (count($_smarty_tpl->getVariable('newslist')->value)<=0){?>style="width:100%"<?php }?>><div class="titleexper">Trải nghiệm mua sắm online cùng dienmay.com</div><!-- SEO text --><div class="ac-container"><div><input type="radio" checked="" name="accordion-1" id="ac-1"><label for="ac-1"><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol1)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->titlecol1;?>
<?php }?></label><article class="ac-small"><p><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->desccol1)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->desccol1;?>
<?php }?></p></article></div><div><input type="radio" name="accordion-1" id="ac-2"><label for="ac-2"><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol2)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->titlecol2;?>
<?php }?></label><article class="ac-small"><p><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->desccol2)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->desccol2;?>
<?php }?></p></article></div><div><input type="radio" name="accordion-1" id="ac-3"><label for="ac-3"><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->titlecol3)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->titlecol3;?>
<?php }?></label><article class="ac-small"><p><?php if (!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->desccol3)){?><?php echo $_smarty_tpl->getVariable('curCategory')->value->desccol3;?>
<?php }?></p></article></div></div></div><?php }?><?php if (count($_smarty_tpl->getVariable('newslist')->value)>0){?><div class="handbook"><div class="titlehandbook">Cẩm nang dienmay.com dành cho <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('curCategory')->value->name, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('curCategory')->value->name,SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('curCategory')->value->name));?>
</div><div class="latesthome-list"><ul><?php  $_smarty_tpl->tpl_vars['news'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('newslist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['news']->key => $_smarty_tpl->tpl_vars['news']->value){
?><li><a title="<?php echo $_smarty_tpl->getVariable('news')->value->title;?>
" href="<?php echo $_smarty_tpl->getVariable('news')->value->getNewsPath();?>
"><img alt="<?php echo $_smarty_tpl->getVariable('news')->value->slug;?>
" src="<?php echo $_smarty_tpl->getVariable('news')->value->getSmallImage();?>
"></a><a title="<?php echo $_smarty_tpl->getVariable('news')->value->title;?>
" href="<?php echo $_smarty_tpl->getVariable('news')->value->getNewsPath();?>
"><?php echo $_smarty_tpl->getVariable('news')->value->title;?>
</a><br><span>Ngày đăng: <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('news')->value->datecreated,"%d/%m/%Y %H:%M:%S");?>
</span></li><?php }} ?><li><a title="Cẩm nang dienmay.com dành cho <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('curCategory')->value->name, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('curCategory')->value->name,SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('curCategory')->value->name));?>
" href="<?php echo $_smarty_tpl->getVariable('myNewscategory')->value->getNewscategoryPath();?>
" class="seeall">Xem thêm cẩm nang cho <?php echo ((mb_detect_encoding($_smarty_tpl->getVariable('curCategory')->value->name, 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('curCategory')->value->name,SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('curCategory')->value->name));?>
  ››</a></li></ul></div></div><?php }?></div>

<script type="text/javascript">
var fpcid = "<?php echo $_smarty_tpl->getVariable('curCategory')->value->id;?>
";
$(document).ready(function(){
//    initEditCategoryInline(fpcid);
});
</script>

