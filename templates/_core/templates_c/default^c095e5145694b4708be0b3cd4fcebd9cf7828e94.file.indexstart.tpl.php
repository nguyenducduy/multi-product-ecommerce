<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:47
         compiled from "templates/default/_controller/site/index/indexstart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21233173155e8ec2bbe70338-25601552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c095e5145694b4708be0b3cd4fcebd9cf7828e94' => 
    array (
      0 => 'templates/default/_controller/site/index/indexstart.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21233173155e8ec2bbe70338-25601552',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
if (!is_callable('smarty_function_cycle')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
?><div id="banner"><?php echo $_smarty_tpl->getVariable('banner')->value;?>
<div class="bn_btom"><?php if (count($_smarty_tpl->getVariable('textbanner')->value)>0){?><ul><?php  $_smarty_tpl->tpl_vars['txtbanner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('textbanner')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bannersmall']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['txtbanner']->key => $_smarty_tpl->tpl_vars['txtbanner']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['bannersmall']['iteration']++;
?><li><a href="<?php echo $_smarty_tpl->getVariable('txtbanner')->value->getAdsPath();?>
" title="<?php echo $_smarty_tpl->getVariable('txtbanner')->value->name;?>
"><img alt="<?php echo $_smarty_tpl->getVariable('txtbanner')->value->title;?>
" src="<?php echo $_smarty_tpl->getVariable('txtbanner')->value->getImage();?>
"  width="213" height="90"></a></li><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['bannersmall']['iteration']==7){?><?php break 1?><?php }?><?php }} ?></ul><?php }?></div><!--end of banner left--></div><!--end of banner--><div id="container"><!-- promotion, recommendation --><div id="depart"><div class="tabscontainer" id="promo"><div class="tabs"><div class="tagnoelone"></div><?php if ($_smarty_tpl->getVariable('me')->value->id>0&&count($_smarty_tpl->getVariable('listproductrecommend')->value)>0){?><div class="tab selected" id="tab_menu_1"><h3 class="link">Gợi ý cho bạn từ dienmay.com</h3></div><?php }?><div class="tab <?php if ($_smarty_tpl->getVariable('me')->value->id==0||count($_smarty_tpl->getVariable('listproductrecommend')->value)==0){?>selected<?php }?>" <?php if ($_smarty_tpl->getVariable('me')->value->id>0&&count($_smarty_tpl->getVariable('listproductrecommend')->value)>0){?>id="tab_menu_2"<?php }else{ ?>id="tab_menu_1"<?php }?>><h3 class="link">Top sản phẩm bán chạy tại dienmay.com</h3></div><div class="tab" id="tab_menu_3"><h3 class="link">Khuyến mãi hôm nay</h3></div></div><div class="clear"></div><div class="curvedContainer"><?php if ($_smarty_tpl->getVariable('me')->value->id>0&&count($_smarty_tpl->getVariable('listproductrecommend')->value)>0){?><div class="tabcontent tab_content_1 bortoptabs display"><div class="m-carousel m-fluid m-carousel-photos m-list-product"><!-- the slider --><div class="m-carousel-inner"><!-- the items --><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(count($_smarty_tpl->getVariable('listproductrecommend')->value)/5, null, null);?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(ceil($_smarty_tpl->getVariable('numrow')->value), null, null);?><?php if ($_smarty_tpl->getVariable('numrow')->value>1){?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('numrow')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total']);
?><div class="m-item"><div class="products"><ul><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['col']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['name'] = 'col';
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total']);
?><?php $_smarty_tpl->tpl_vars['index'] = new Smarty_variable(5*$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']+$_smarty_tpl->getVariable('smarty')->value['section']['col']['index'], null, null);?><?php $_smarty_tpl->tpl_vars['recommendpro'] = new Smarty_variable($_smarty_tpl->getVariable('listproductrecommend')->value[$_smarty_tpl->getVariable('index')->value], null, null);?><?php if (!empty($_smarty_tpl->getVariable('recommendpro',null,true,false)->value)){?><li><?php if (count($_smarty_tpl->getVariable('recommenditemcolorlist')->value[$_smarty_tpl->getVariable('recommendpro')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['recommendlistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('recommenditemcolorlist')->value[$_smarty_tpl->getVariable('recommendpro')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recommendlistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['recommendlistcolor']->key => $_smarty_tpl->tpl_vars['recommendlistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['recommendlistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['recommendlistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['recommendlistcolorname']['index']>4){?><?php break 1?><?php }?><li><a class="qtootip" href="<?php if ($_smarty_tpl->tpl_vars['recommendlistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('recommendpro')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('recommendpro')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['recommendlistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['recommendlistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['recommendlistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->getProductPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('recommendpro')->value->name);?>
"><?php if ($_smarty_tpl->getVariable('smarty')->value['section']['row']['index']==0){?><img alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('recommendpro')->value->name);?>
" src="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->getSmallImage();?>
" /><?php }else{ ?><span class="pro_img" rel="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->getSmallImage();?>
" title="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->name;?>
"></span><?php }?> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->getProductPath();?>
"><h4><?php echo $_smarty_tpl->getVariable('recommendpro')->value->name;?>
</h4></a><?php if ($_smarty_tpl->getVariable('recommendpro')->value->sellprice>0||$_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('recommendpro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('recommendpro')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('recommendpro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('recommendpro')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('recommendpro')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('recommendpro')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('recommendpro',null,true,false)->value->promotionprice)&&$_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&$_smarty_tpl->getVariable('recommendpro')->value->promotionprice<$_smarty_tpl->getVariable('recommendpro')->value->sellprice){?><div class="priceold"><?php if ($_smarty_tpl->getVariable('recommendpro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('recommendpro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="pricenew"><?php if ($_smarty_tpl->getVariable('recommendpro')->value->promotionprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('recommendpro')->value->promotionprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('recommendpro')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('recommendpro')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('recommendpro')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('recommendpro')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('recommendpro')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('recommendpro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('recommendpro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div><?php }?></li><?php }?><?php endfor; endif; ?></ul></div></div><?php endfor; endif; ?><?php }?><!--product recommandation--></div><!-- the controls --><div class="m-carousel-controls m-carousel-pagination"><div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div><div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div></div></div></div><?php }?><div class="tabcontent tab_content_<?php if ($_smarty_tpl->getVariable('me')->value->id>0&&count($_smarty_tpl->getVariable('listproductrecommend')->value)>0){?>2<?php }else{ ?>1<?php }?> bortoptabs <?php if ($_smarty_tpl->getVariable('me')->value->id==0||count($_smarty_tpl->getVariable('listproductrecommend')->value)==0){?>display<?php }?>"><div class="m-carousel m-fluid m-carousel-photos m-list-product"><!-- the slider --><div class="m-carousel-inner"><!-- the items --><?php if ($_smarty_tpl->getVariable('topitemlist')->value){?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(count($_smarty_tpl->getVariable('topitemlist')->value)/5, null, null);?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(ceil($_smarty_tpl->getVariable('numrow')->value), null, null);?><?php if ($_smarty_tpl->getVariable('numrow')->value>1){?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('numrow')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total']);
?><div class="m-item"><div class="products"><ul><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['col']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['name'] = 'col';
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total']);
?><?php $_smarty_tpl->tpl_vars['index'] = new Smarty_variable(5*$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']+$_smarty_tpl->getVariable('smarty')->value['section']['col']['index'], null, null);?><?php $_smarty_tpl->tpl_vars['toppro'] = new Smarty_variable($_smarty_tpl->getVariable('topitemlist')->value[$_smarty_tpl->getVariable('index')->value], null, null);?><?php if (!empty($_smarty_tpl->getVariable('toppro',null,true,false)->value)){?><li><?php if (count($_smarty_tpl->getVariable('topitemcolorlist')->value[$_smarty_tpl->getVariable('toppro')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['toplistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topitemcolorlist')->value[$_smarty_tpl->getVariable('toppro')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toplistcolor']->key => $_smarty_tpl->tpl_vars['toplistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['toplistcolorname']['index']>4){?><?php break 1?><?php }?><li><a class="qtootip" href="<?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('toppro')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('toppro')->value->name);?>
"><?php if ($_smarty_tpl->getVariable('smarty')->value['section']['row']['index']==0){?><img alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('toppro')->value->name);?>
" src="<?php echo $_smarty_tpl->getVariable('toppro')->value->getSmallImage();?>
" /><?php }else{ ?><span class="pro_img" rel="<?php echo $_smarty_tpl->getVariable('toppro')->value->getSmallImage();?>
" title="<?php echo $_smarty_tpl->getVariable('toppro')->value->name;?>
"></span><?php }?> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
"><h4><?php echo $_smarty_tpl->getVariable('toppro')->value->name;?>
</h4></a><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>0||$_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('toppro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('toppro')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('toppro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('toppro')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('toppro')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('toppro')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('toppro',null,true,false)->value->promotionprice)&&$_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&$_smarty_tpl->getVariable('toppro')->value->promotionprice<$_smarty_tpl->getVariable('toppro')->value->sellprice){?><div class="priceold"><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->promotionprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->promotionprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('toppro')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('toppro')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div><?php }?></li><?php }?><?php endfor; endif; ?></ul></div></div><?php endfor; endif; ?><?php }else{ ?><div class="m-item"><div class="products"><ul><?php  $_smarty_tpl->tpl_vars['toppro'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topitemlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toppro']->key => $_smarty_tpl->tpl_vars['toppro']->value){
?><?php if (!empty($_smarty_tpl->tpl_vars['toppro']->value)){?><li><?php if (count($_smarty_tpl->getVariable('topitemcolorlist')->value[$_smarty_tpl->getVariable('toppro')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['toplistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('topitemcolorlist')->value[$_smarty_tpl->getVariable('toppro')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['toplistcolor']->key => $_smarty_tpl->tpl_vars['toplistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['toplistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['toplistcolorname']['index']>4){?><?php break 1?><?php }?><li class="qtooltip"><a class="qtootip"  href="<?php if ($_smarty_tpl->tpl_vars['toplistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['toplistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('toppro')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('toppro')->value->name);?>
"><img alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('toppro')->value->name);?>
" src="<?php echo $_smarty_tpl->getVariable('toppro')->value->getSmallImage();?>
" /> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('toppro')->value->getProductPath();?>
"><h4><?php echo $_smarty_tpl->getVariable('toppro')->value->name;?>
</h4></a><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>0||$_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('toppro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('toppro')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('toppro')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('toppro')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('toppro')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('toppro')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('toppro',null,true,false)->value->promotionprice)&&$_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&$_smarty_tpl->getVariable('toppro')->value->promotionprice<$_smarty_tpl->getVariable('toppro')->value->sellprice){?><div class="priceold"><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->promotionprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->promotionprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('toppro')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('toppro')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('toppro')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('toppro')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('toppro')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div><?php }?></li><?php }?><?php }} ?></ul></div></div><?php }?><?php }?><!--product recommandation--></div><!-- the controls --><div class="m-carousel-controls m-carousel-pagination"><div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div><div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div></div></div></div><div class="tabcontent tab_content_3 bortoptabs"><div class="m-carousel m-fluid m-carousel-photos m-list-product"><!-- the slider --><div class="m-carousel-inner"><!-- the items --><?php if ($_smarty_tpl->getVariable('listPromotions')->value){?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(count($_smarty_tpl->getVariable('listPromotions')->value)/5, null, null);?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(ceil($_smarty_tpl->getVariable('numrow')->value), null, null);?><?php if ($_smarty_tpl->getVariable('numrow')->value>1){?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('numrow')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total']);
?><div class="m-item"><div class="products"><ul><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['col']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['name'] = 'col';
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total']);
?><?php $_smarty_tpl->tpl_vars['index'] = new Smarty_variable(5*$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']+$_smarty_tpl->getVariable('smarty')->value['section']['col']['index'], null, null);?><?php $_smarty_tpl->tpl_vars['hpromo'] = new Smarty_variable($_smarty_tpl->getVariable('listPromotions')->value[$_smarty_tpl->getVariable('index')->value], null, null);?><?php if (!empty($_smarty_tpl->getVariable('hpromo',null,true,false)->value)){?><li><?php if (count($_smarty_tpl->getVariable('listPromotionColor')->value[$_smarty_tpl->getVariable('hpromo')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['promotionlistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listPromotionColor')->value[$_smarty_tpl->getVariable('hpromo')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['promotionlistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['promotionlistcolor']->key => $_smarty_tpl->tpl_vars['promotionlistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['promotionlistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['promotionlistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['promotionlistcolorname']['index']>4){?><?php break 1?><?php }?><li class="qtooltip"><a class="qtootip"  href="<?php if ($_smarty_tpl->tpl_vars['promotionlistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('hpromo')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('hpromo')->value->name);?>
"><?php if ($_smarty_tpl->getVariable('smarty')->value['section']['row']['index']==0){?><img alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('hpromo')->value->name);?>
" src="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getSmallImage();?>
" /><?php }else{ ?><span class="pro_img" rel="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getSmallImage();?>
" title="<?php echo $_smarty_tpl->getVariable('hpromo')->value->name;?>
"></span><?php }?> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
"><h4><?php echo $_smarty_tpl->getVariable('hpromo')->value->name;?>
</h4></a><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>0||$_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('hpromo')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('hpromo')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('hpromo')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('hpromo')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('hpromo')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('hpromo')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('hpromo',null,true,false)->value->promotionprice)&&$_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&$_smarty_tpl->getVariable('hpromo')->value->promotionprice<$_smarty_tpl->getVariable('hpromo')->value->sellprice){?><div class="priceold"><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->promotionprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->promotionprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('hpromo')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('hpromo')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div><?php }?></li><?php }?><?php endfor; endif; ?></ul></div></div><?php endfor; endif; ?><?php }else{ ?><div class="m-item"><div class="products"><ul><?php  $_smarty_tpl->tpl_vars['hpromo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listPromotions')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hpromo']->key => $_smarty_tpl->tpl_vars['hpromo']->value){
?><li><?php if (count($_smarty_tpl->getVariable('listPromotionColor')->value[$_smarty_tpl->getVariable('hpromo')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['promotionlistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listPromotionColor')->value[$_smarty_tpl->getVariable('hpromo')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['promotionlistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['promotionlistcolor']->key => $_smarty_tpl->tpl_vars['promotionlistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['promotionlistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['promotionlistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['promotionlistcolorname']['index']>4){?><?php break 1?><?php }?><li class="qtooltip"><a class="qtootip" href="<?php if ($_smarty_tpl->tpl_vars['promotionlistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['promotionlistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('hpromo')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a href="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('hpromo')->value->name);?>
"><img alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('hpromo')->value->name);?>
" src="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getSmallImage();?>
" /> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('hpromo')->value->getProductPath();?>
"><h4><?php echo $_smarty_tpl->getVariable('hpromo')->value->name;?>
</h4></a><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>0||$_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('hpromo')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('hpromo')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('hpromo')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('hpromo')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('hpromo')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('hpromo')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('hpromo',null,true,false)->value->promotionprice)&&$_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&$_smarty_tpl->getVariable('hpromo')->value->promotionprice<$_smarty_tpl->getVariable('hpromo')->value->sellprice){?><div class="priceold"><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->promotionprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->promotionprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('hpromo')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('hpromo')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('hpromo')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('hpromo')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div><?php }?></li><?php }} ?></ul></div></div><?php }?><?php }?><!--product recommandation--></div><!-- the controls --><div class="m-carousel-controls m-carousel-pagination"><div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div><div class="next"><a href="javascript:void(0)" onclick="clicknext('promo')" data-slide="next">»</a></div></div></div></div></div></div></div><!-- sản phẩm trang chủ --><div class="clear"></div><?php if (!empty($_smarty_tpl->getVariable('listProductsByCategory',null,true,false)->value)){?><?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['categoryid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listProductsByCategory')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
 $_smarty_tpl->tpl_vars['categoryid']->value = $_smarty_tpl->tpl_vars['category']->key;
?><?php if (!empty($_smarty_tpl->tpl_vars['category']->value)&&!empty($_smarty_tpl->getVariable('listCategoriesIcon',null,true,false)->value[$_smarty_tpl->tpl_vars['categoryid']->value])&&!empty($_smarty_tpl->getVariable('listCategories',null,true,false)->value[$_smarty_tpl->tpl_vars['categoryid']->value])){?><div id="depart"><div class="mobile"><div class="titledepart"><span>▼</span><div class="smallnav"><ul><?php  $_smarty_tpl->tpl_vars['subcatedata'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['subcateid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subcatdatalist')->value[$_smarty_tpl->tpl_vars['categoryid']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subcatedata']->key => $_smarty_tpl->tpl_vars['subcatedata']->value){
 $_smarty_tpl->tpl_vars['subcateid']->value = $_smarty_tpl->tpl_vars['subcatedata']->key;
?><li><a href="<?php echo $_smarty_tpl->tpl_vars['subcatedata']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['subcatedata']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['subcatedata']->value['name'];?>
</a></li><?php }} ?></ul></div></div></div><div class="tabscontainer" id="<?php echo $_smarty_tpl->getVariable('listCategoriesIcon')->value[$_smarty_tpl->tpl_vars['categoryid']->value]['id'];?>
"><div class="tabs"><div class="<?php echo smarty_function_cycle(array('values'=>"tagnoeltwo,tagnoelone"),$_smarty_tpl);?>
"></div><?php  $_smarty_tpl->tpl_vars['subcate'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['subcatid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['subcate']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subcate']->key => $_smarty_tpl->tpl_vars['subcate']->value){
 $_smarty_tpl->tpl_vars['subcatid']->value = $_smarty_tpl->tpl_vars['subcate']->key;
 $_smarty_tpl->tpl_vars['subcate']->index++;
 $_smarty_tpl->tpl_vars['subcate']->first = $_smarty_tpl->tpl_vars['subcate']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['first'] = $_smarty_tpl->tpl_vars['subcate']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['index']++;
?><div class="tab <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['subcategorylist']['first']){?>selected<?php }?>" id="tab_menu_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['subcategorylist']['index']+1;?>
"><h2 class="link"><?php echo $_smarty_tpl->getVariable('subcate')->value['category']->name;?>
</h2></div><?php }} ?></div><div class="clear"></div><!-- banner right --><div class="tagrightimg"><?php echo $_smarty_tpl->getVariable('blockbannerrightlist')->value[$_smarty_tpl->tpl_vars['categoryid']->value];?>
</div><!-- content tab --><div class="curvedContainer"><?php  $_smarty_tpl->tpl_vars['subcate'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['subcatid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['subcate']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subcate']->key => $_smarty_tpl->tpl_vars['subcate']->value){
 $_smarty_tpl->tpl_vars['subcatid']->value = $_smarty_tpl->tpl_vars['subcate']->key;
 $_smarty_tpl->tpl_vars['subcate']->index++;
 $_smarty_tpl->tpl_vars['subcate']->first = $_smarty_tpl->tpl_vars['subcate']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['first'] = $_smarty_tpl->tpl_vars['subcate']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['subcategorylist']['index']++;
?><div class="tabcontent tab_content_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['subcategorylist']['index']+1;?>
 bortoptabs <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['subcategorylist']['first']){?>display<?php }?>"><div class="m-carousel m-fluid m-carousel-photos m-list-product"><!-- the slider --><div class="m-carousel-inner" style="-webkit-transform: translate3d(-985px, 0, 0);"><!-- the items --><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['subcate']->value['products'])/4, null, null);?><?php $_smarty_tpl->tpl_vars['numrow'] = new Smarty_variable(ceil($_smarty_tpl->getVariable('numrow')->value)+1, null, null);?><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['row']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['name'] = 'row';
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('numrow')->value-1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['row']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['row']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['row']['total']);
?><div class="m-item"><div class="products"><ul><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['col']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['name'] = 'col';
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] = is_array($_loop=4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = (int)0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['col']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['col']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['col']['total']);
?><?php $_smarty_tpl->tpl_vars['index'] = new Smarty_variable(4*$_smarty_tpl->getVariable('smarty')->value['section']['row']['index']+$_smarty_tpl->getVariable('smarty')->value['section']['col']['index'], null, null);?><?php $_smarty_tpl->tpl_vars['product'] = new Smarty_variable($_smarty_tpl->tpl_vars['subcate']->value['products'][$_smarty_tpl->getVariable('index')->value], null, null);?><?php if (!empty($_smarty_tpl->getVariable('product',null,true,false)->value)){?><li><?php if (count($_smarty_tpl->getVariable('listProductColor')->value[$_smarty_tpl->getVariable('product')->value->id])>1){?><div class="lg"><ul><?php  $_smarty_tpl->tpl_vars['productcatlistcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listProductColor')->value[$_smarty_tpl->getVariable('product')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['productcatlistcolorname']['index']=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productcatlistcolor']->key => $_smarty_tpl->tpl_vars['productcatlistcolor']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['productcatlistcolorname']['index']++;
?><?php if ($_smarty_tpl->tpl_vars['productcatlistcolor']->value[0]>0){?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['productcatlistcolorname']['index']>4){?><?php break 1?><?php }?><li class="qtooltip"><a class="qtootip" href="<?php if ($_smarty_tpl->tpl_vars['productcatlistcolor']->value[4]==1){?><?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
?color=<?php echo $_smarty_tpl->tpl_vars['productcatlistcolor']->value[0];?>
<?php }?>" title="<?php echo $_smarty_tpl->tpl_vars['productcatlistcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['productcatlistcolor']->value[3];?>
"></a></li><?php }?><?php }} ?></ul></div><?php }?><?php if ($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div><?php }elseif($_smarty_tpl->getVariable('hpromo')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('product')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div><?php }?><a class="img_link" href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
" title="<?php if (!empty($_smarty_tpl->getVariable('product',null,true,false)->value->seotitle)){?><?php echo $_smarty_tpl->getVariable('product')->value->seotitle;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
<?php }?>"><?php if ($_smarty_tpl->getVariable('smarty')->value['section']['row']['index']==0){?><img src="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" alt="<?php echo $_smarty_tpl->getVariable('product')->value->name;?>
"><?php }else{ ?><span class="pro_img" rel="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" title="<?php echo $_smarty_tpl->getVariable('product')->value->name;?>
"></span><?php }?> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
" title="<?php if (!empty($_smarty_tpl->getVariable('product',null,true,false)->value->seotitle)){?><?php echo $_smarty_tpl->getVariable('product')->value->seotitle;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
<?php }?>"><h4><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
</h4></a><div class="loadprice lp<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('product')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('product')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('product')->value->barcode),-5);?>
"><?php if ($_smarty_tpl->getVariable('product')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('product')->value->sellprice>0&&$_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('product')->value->sellprice){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('promotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><div class="priceold"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><div class="th_left"><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
 đ</div><?php }else{ ?><div class="th_center"><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
 đ</div><?php }?><?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('product')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('product')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('product')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }elseif($_smarty_tpl->getVariable('product')->value->sellprice>0){?><div class="pricenew"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div><?php }?><div class="salepercent">%</div></div></li><?php }?><?php endfor; endif; ?></ul></div></div><?php endfor; endif; ?></div><!-- the controls --><?php if (count($_smarty_tpl->tpl_vars['subcate']->value['products'])>4){?><div class="m-carousel-controls m-carousel-pagination"><div class="prev"><a href="javascript:void(0)" data-slide="prev">«</a></div><div class="next"><a href="javascript:void(0)" onclick="clicknext('<?php echo $_smarty_tpl->getVariable('listCategoriesIcon')->value[$_smarty_tpl->tpl_vars['categoryid']->value]['id'];?>
')" data-slide="next">»</a></div></div><?php }?><div class="linkmore"><a title="<?php echo $_smarty_tpl->getVariable('subcate')->value['category']->name;?>
" href="<?php echo $_smarty_tpl->getVariable('subcate')->value['category']->getProductcateoryPath();?>
">&raquo; Xem thêm sản phẩm <?php echo $_smarty_tpl->getVariable('subcate')->value['category']->name;?>
</a></div><br/><br/></div></div><?php }} ?></div><!-- brand , banner --><div class="listlogo"><?php if (!empty($_smarty_tpl->getVariable('blockhomepagelist',null,true,false)->value[$_smarty_tpl->tpl_vars['categoryid']->value])){?><?php echo $_smarty_tpl->getVariable('blockhomepagelist')->value[$_smarty_tpl->tpl_vars['categoryid']->value];?>
<?php }?></div></div></div><?php }?><?php }} ?><?php }?></div><!--trai nghiem, cam nang --><div id="experiencehandbook"><?php echo $_smarty_tpl->getVariable('experince')->value->content;?>
<div class="handbook"><div class="titlehandbook">Cẩm nang dienmay.com</div><div class="latesthome-list"><?php if (!empty($_smarty_tpl->getVariable('listnews',null,true,false)->value['normal'])){?><ul><?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['name'] = 'counternews';
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['loop'] = is_array($_loop=4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['counternews']['total']);
?><?php if (!empty($_smarty_tpl->getVariable('listnews',null,true,false)->value['normal'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['counternews']['index']])){?><li><a href="<?php echo $_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->getNewsPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->title);?>
"><img src="<?php echo $_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->getImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->title);?>
" /></a><a href="<?php echo $_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->getNewsPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->title);?>
"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->title);?>
</a><br /><span>Ngày đăng: <?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('listnews')->value['normal'][$_smarty_tpl->getVariable('smarty')->value['section']['counternews']['index']]->datecreated,"%d/%m/%Y %H:%m:%S");?>
</span></li><?php }?><?php endfor; endif; ?><li><a class="seeall" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
san-pham-cong-nghe" title="Xem tất cả tin công nghệ">Xem tất cả tin công nghệ  ››</a></li></ul><?php }?></div></div></div>

    <script type="text/javascript">
    $(document).ready(function(){
        var mySwiper = new Swiper('.swiper-container',{
            pagination: '.pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplay: 5000,
        })
        $('.arrow-left').on('click', function(e){
            e.preventDefault()
            mySwiper.swipePrev()
        })
        $('.arrow-right').on('click', function(e){
            e.preventDefault()
            mySwiper.swipeNext()
        })
    })
    </script>
