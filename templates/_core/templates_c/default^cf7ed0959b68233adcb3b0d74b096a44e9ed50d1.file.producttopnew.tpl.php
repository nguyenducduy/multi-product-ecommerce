<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:38:53
         compiled from "templates/default/_controller/site/product/producttopnew.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4959510985e8ec2fd8bbc08-84570357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf7ed0959b68233adcb3b0d74b096a44e9ed50d1' => 
    array (
      0 => 'templates/default/_controller/site/product/producttopnew.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4959510985e8ec2fd8bbc08-84570357',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
?><div class="colleft"><div class="colleftbrand"><h3 class="titlenav"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fullPathCategory')->value[0]['pc_name']);?>
</h3><ul style="max-height: none;"><?php  $_smarty_tpl->tpl_vars['fcat'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('allChildCategory')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fcat']->key => $_smarty_tpl->tpl_vars['fcat']->value){
?><li><a <?php if ($_smarty_tpl->getVariable('fpcid')->value==$_smarty_tpl->getVariable('fcat')->value->id){?> class="active" <?php }?> href="<?php echo $_smarty_tpl->getVariable('fcat')->value->getProductcateoryPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fcat')->value->name);?>
"><?php echo $_smarty_tpl->getVariable('fcat')->value->name;?>
</a></li><?php if ($_smarty_tpl->getVariable('fpcid')->value==$_smarty_tpl->getVariable('fcat')->value->id||$_smarty_tpl->getVariable('fcat')->value->parentcurrent==$_smarty_tpl->getVariable('fcat')->value->id){?><?php  $_smarty_tpl->tpl_vars['fsubcate'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('fcat')->value->subsubcate; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['fsubcate']->key => $_smarty_tpl->tpl_vars['fsubcate']->value){
?><li><a class="subli <?php if ($_smarty_tpl->getVariable('fpcid')->value==$_smarty_tpl->getVariable('fsubcate')->value->id){?> active <?php }?>" href="<?php echo $_smarty_tpl->getVariable('fsubcate')->value->getProductcateoryPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fsubcate')->value->name);?>
"><sup style="font-size: 8px">|_</sup> <?php echo $_smarty_tpl->getVariable('fsubcate')->value->name;?>
</a></li><?php }} ?><?php }?><?php }} ?><?php echo $_smarty_tpl->getVariable('fullPathCategory')->value[0]['pc_categoryreference'];?>
</ul></div><?php if (count($_smarty_tpl->getVariable('arrVendorselect')->value)>0||!empty($_GET['a'])){?><div class="colleftbrand"> <h3>Bộ lọc hiện tại</h3><ul><?php  $_smarty_tpl->tpl_vars['vendorselect'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('arrVendorselect')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['vendorselect']->key => $_smarty_tpl->tpl_vars['vendorselect']->value){
?><?php  $_smarty_tpl->tpl_vars['ven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['ven']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['ven']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->tpl_vars['ven']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ven']->key => $_smarty_tpl->tpl_vars['ven']->value){
 $_smarty_tpl->tpl_vars['ven']->iteration++;
 $_smarty_tpl->tpl_vars['ven']->last = $_smarty_tpl->tpl_vars['ven']->iteration === $_smarty_tpl->tpl_vars['ven']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['last'] = $_smarty_tpl->tpl_vars['ven']->last;
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
</a><div class="clearfilter"><a title="Xóa" href="<?php if (strpos($_GET['a'],$_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1])===false){?><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)&&!empty($_smarty_tpl->getVariable('paginateurl',null,true,false)->value)){?><?php echo trim($_smarty_tpl->getVariable('paginateurl')->value);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('curCategory')->value->getProductcateoryPath();?>
<?php }?><?php if ($_GET['vendor']!=''){?>?vendor=<?php echo trim($_GET['vendor']);?>
&<?php }else{ ?>?<?php }?>a=<?php echo trim($_smarty_tpl->getVariable('attribute')->value->panameseo);?>
,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[2][$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['attributelistname']['iteration']-1])){?>,<?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?><?php }else{ ?><?php echo trim($_smarty_tpl->getVariable('attribute')->value->value[3][$_smarty_tpl->getVariable('smarty')->value['foreach']['attributelistname']['iteration']-1]);?>
<?php }?>">&#215;</a></div></li><?php }?><?php }?><?php }} ?><?php }?><?php }?><?php }} ?><?php }?></ul></div><?php }?><?php if (!empty($_smarty_tpl->getVariable('listvendors',null,true,false)->value)){?><div class="colleftbrand"><h3>Nhà sản xuất</h3><ul><?php if (count($_smarty_tpl->getVariable('listChildCat')->value)==1||count($_smarty_tpl->getVariable('listChildCat')->value)>1){?><?php  $_smarty_tpl->tpl_vars['ven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[0]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['ven']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['ven']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->tpl_vars['ven']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['ven']->key => $_smarty_tpl->tpl_vars['ven']->value){
 $_smarty_tpl->tpl_vars['ven']->iteration++;
 $_smarty_tpl->tpl_vars['ven']->last = $_smarty_tpl->tpl_vars['ven']->iteration === $_smarty_tpl->tpl_vars['ven']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['last'] = $_smarty_tpl->tpl_vars['ven']->last;
?><li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10){?>hidden<?php }?>"><a href="<?php echo $_smarty_tpl->getVariable('listvendors')->value[2][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1];?>
" title="<?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
" class ="subli checkbox-sort <?php if (in_array($_smarty_tpl->getVariable('listvendors')->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1],explode(',',$_GET['vendor']))!==false||($_GET['fvid']!=''&&$_GET['fvid']==$_smarty_tpl->getVariable('listvendors')->value[3][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1])||($_smarty_tpl->getVariable('singlevendorname')->value!=''&&$_smarty_tpl->getVariable('singlevendorname')->value==$_smarty_tpl->getVariable('listvendors')->value[1][$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']-1])){?>active<?php }else{ ?><?php }?>"><?php echo $_smarty_tpl->tpl_vars['ven']->value;?>
</a></li><?php }} ?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10&&$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['last']){?><li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li><?php }?><?php }elseif(!empty($_smarty_tpl->getVariable('curCategory',null,true,false)->value->id)&&!empty($_smarty_tpl->getVariable('listvendors',null,true,false)->value[$_smarty_tpl->getVariable('curCategory',null,true,false)->value->id])){?><?php  $_smarty_tpl->tpl_vars['myven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value[$_smarty_tpl->getVariable('curCategory')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['myven']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['myven']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->tpl_vars['myven']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['myven']->key => $_smarty_tpl->tpl_vars['myven']->value){
 $_smarty_tpl->tpl_vars['myven']->iteration++;
 $_smarty_tpl->tpl_vars['myven']->last = $_smarty_tpl->tpl_vars['myven']->iteration === $_smarty_tpl->tpl_vars['myven']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['last'] = $_smarty_tpl->tpl_vars['myven']->last;
?><?php if (!empty($_smarty_tpl->getVariable('myven',null,true,false)->value->name)&&$_smarty_tpl->getVariable('myven')->value->name!='-'){?><li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10){?>hidden<?php }?>"><a href="<?php echo $_smarty_tpl->getVariable('myven')->value->getVendorPath($_smarty_tpl->getVariable('curCategory')->value->id);?>
" title="<?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
"<?php if ($_smarty_tpl->getVariable('myVendors')->value->id==$_smarty_tpl->getVariable('myven')->value->id){?> class="colorselectedfilter"<?php }?>>›› <?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
 </a></li><?php }?><?php }} ?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10&&$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['last']){?><li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li><?php }?><?php }elseif(!empty($_smarty_tpl->getVariable('listvendors',null,true,false)->value)){?><?php  $_smarty_tpl->tpl_vars['myven'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listvendors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['myven']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['myven']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']=0;
if ($_smarty_tpl->tpl_vars['myven']->total > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['myven']->key => $_smarty_tpl->tpl_vars['myven']->value){
 $_smarty_tpl->tpl_vars['myven']->iteration++;
 $_smarty_tpl->tpl_vars['myven']->last = $_smarty_tpl->tpl_vars['myven']->iteration === $_smarty_tpl->tpl_vars['myven']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['vendorlistshow']['last'] = $_smarty_tpl->tpl_vars['myven']->last;
?><?php if (!empty($_smarty_tpl->getVariable('myven',null,true,false)->value->name)&&$_smarty_tpl->getVariable('myven')->value->name!='-'){?><li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10){?>hidden<?php }?>"><a href="<?php echo $_smarty_tpl->getVariable('myven')->value->getVendorPath();?>
" title="<?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
"<?php if ($_smarty_tpl->getVariable('myVendors')->value->id==$_smarty_tpl->getVariable('myven')->value->id){?> class="colorselectedfilter"<?php }?>>›› <?php echo $_smarty_tpl->getVariable('myven')->value->name;?>
</a></li><?php }?><?php }} ?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['iteration']>10&&$_smarty_tpl->getVariable('smarty')->value['foreach']['vendorlistshow']['last']){?><li><a class="subli vendorseemore" href="javascript:void(0)">Xem thêm</a></li><?php }?><?php }?></ul></div><?php }?><?php if (!empty($_smarty_tpl->getVariable('attributeList',null,true,false)->value['LEFT'])){?><?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('attributeList')->value['LEFT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['topattributeout']['iteration']++;
?><?php if (count($_smarty_tpl->getVariable('attribute')->value->value)>0){?><div class="colleftbrand"><h3><?php echo $_smarty_tpl->getVariable('attribute')->value->display;?>
</h3><ul><?php if (!empty($_smarty_tpl->getVariable('attribute',null,true,false)->value->value[0])){?><?php  $_smarty_tpl->tpl_vars['attrvalue'] = new Smarty_Variable;
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
">Xem thêm</a></li><?php }?><?php }} ?><?php }?></ul></div><?php }?><?php }} ?><?php }?></div>