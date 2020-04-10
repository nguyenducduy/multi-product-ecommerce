<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:38:05
         compiled from "templates/default/_controller/site/product/productsdetailnew.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14242255855e8ec2cd341d26-53447909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa31d2a75cfeb940fd1108fabfd8d0ec088ab16b' => 
    array (
      0 => 'templates/default/_controller/site/product/productsdetailnew.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14242255855e8ec2cd341d26-53447909',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_math')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.math.php';
if (!is_callable('smarty_modifier_capitalize')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.capitalize.php';
if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
?><!-- navigation bar -->
<div class="navbarprod asdasd">
    <ul>
        <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
" title="Về trang chủ dienmay.com">Trang chủ</a> ››</li>
        <li><a href="<?php echo $_smarty_tpl->getVariable('currentCategory')->value->getProductcateoryPath();?>
" title="<?php echo $_smarty_tpl->getVariable('currentCategory')->value->name;?>
"><?php echo $_smarty_tpl->getVariable('currentCategory')->value->name;?>
</a><?php if (!empty($_smarty_tpl->getVariable('myVendors',null,true,false)->value->name)){?> ››<?php }?></li>
    </ul>
</div>
<?php $_smarty_tpl->tpl_vars["parentpromotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('productDetail')->value->promotionPrice(), null, null);?>
<!-- content -->
<div id="container">
    <div id="detail-head">
      <div class="head-left">
          <div id="zoomslide">
              <?php if (!empty($_smarty_tpl->getVariable('crazydeal',null,true,false)->value)){?>
                   <div class="special"> <i class="icon-crazydeal"></i></div>
              <?php }else{ ?>
                    <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div>
                     <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-bettingg"></i></div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('productDetail')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div>
                    <?php }?>
              <?php }?> <!-- End if khong phai crazydeal -->
              <?php if (!empty($_smarty_tpl->getVariable('galleries',null,true,false)->value)){?>
                  <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('galleries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listgallery']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listgallery']['iteration']++;
?>
                      <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['listgallery']['iteration']==2){?><?php break 1?><?php }?>
                      <div class="fixzoom">
                        <img data-zoom-image="<?php echo $_smarty_tpl->getVariable('gal')->value->getImage();?>
" src="<?php if ($_smarty_tpl->getVariable('gal')->value->checkimagevalid($_smarty_tpl->getVariable('gal')->value->getMediumImage())==true){?><?php echo $_smarty_tpl->getVariable('gal')->value->getMediumImage();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->getImage();?>
<?php }?>" alt="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->alt)){?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }?>" id="zoom">
                      </div>
                  <?php }} ?>
                <div id="zoomslides">
                   <?php if (count($_smarty_tpl->getVariable('galleries360')->value)>=36&&!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
                      <?php ob_start(); ?><?php echo 4;?>
<?php  $_smarty_tpl->assign('numberslider', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>
                   <?php }else{ ?>
                      <?php if (count($_smarty_tpl->getVariable('galleries360')->value)>=36||!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
                        <?php ob_start(); ?><?php echo 5;?>
<?php  $_smarty_tpl->assign('numberslider', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>
                      <?php }else{ ?>
                          <?php ob_start(); ?><?php echo 6;?>
<?php  $_smarty_tpl->assign('numberslider', ob_get_contents()); Smarty::$_smarty_vars['capture']['default']=ob_get_clean();?>
                    <?php }?>
                  <?php }?>
                  <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('galleries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listgallery']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['gal']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['listgallery']['iteration']++;
?>
                      <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['listgallery']['iteration']==$_smarty_tpl->getVariable('numberslider')->value){?><?php break 1?><?php }?>
                    <a data-zoom-image="<?php echo $_smarty_tpl->getVariable('gal')->value->getImage();?>
" data-image="<?php if ($_smarty_tpl->getVariable('gal')->value->checkimagevalid($_smarty_tpl->getVariable('gal')->value->getMediumImage())==true){?><?php echo $_smarty_tpl->getVariable('gal')->value->getMediumImage();?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->getImage();?>
<?php }?>" data-update="" class="elevatezoom-gallery  <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['listgallery']['iteration']==1){?>active<?php }?> withumb_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" >
                      <img class="withumb" src="<?php echo $_smarty_tpl->getVariable('gal')->value->getSmallImage();?>
" onclick="clickimage(this)" alt="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->alt)){?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }?>">
                    </a>
                  <?php }} ?>
                </div>
                <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->getImage()!=''){?>
                    <div class="fixzoom">
                      <img data-zoom-image="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getImage();?>
" src="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getImage();?>
" id="zoom" >
                    </div>
                     <a data-zoom-image="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getImage();?>
" data-image="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getImage();?>
" data-update="" class="elevatezoom-gallery  active withumb_0" >
                      <img class="withumb" src="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getImage();?>
" onclick="clickimage(this)" alt="<?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
">
                    </a>
                <?php }?>
            </div>
             <!-- load video -->
            <?php if (count($_smarty_tpl->getVariable('galleries360')->value)>0||!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
              <?php if (!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
                <div id="videothumb"><a style="cursor:pointer">
                  <span class="iconvideoyoutube"></span>
                  <img src="http://img.youtube.com/vi/<?php echo $_smarty_tpl->getVariable('videos')->value[0]->youtubeid;?>
/default.jpg" alt="<?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
"/></a>
                </div>
              <?php }?>
              <!-- load hình xoay 360 -->
              <?php if (count($_smarty_tpl->getVariable('galleries360')->value)>=36){?>
                <div id="360thumb" class="i360thumb"><a style="cursor:pointer"><i class="icon-img360"></i></a></div>
              <?php }?>
            <?php }?>
          <div class="clear"></div>
      </div>
        <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?>

              <div class="pre_center">
                <div class="des_pre">
                  <h1><?php if ($_smarty_tpl->getVariable('currentCategory')->value->appendtoproductname==1){?><?php echo $_smarty_tpl->getVariable('currentCategory')->value->name;?>
 <?php }?><?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidname!=''){?><?php echo $_smarty_tpl->getVariable('productDetail')->value->prepaidname;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
<?php }?></h1>
                  <div class="area_pre">
                      <div class="pre_price">
                          <strong>Giá</strong>
                          <div class="pricepre"><span><?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?><sub>đ</sub></span></div>
                      </div>
                      <div class="pre-statistic">
                         <?php if (!empty($_smarty_tpl->getVariable('prepaidnumberorders',null,true,false)->value)){?> <span>Đã có <b> <?php echo $_smarty_tpl->getVariable('numberreorder')->value;?>
</b> người đặt trước</span><?php }?>
                          <div class="fbcm">
                              <div class="productpath" style="display:none"><?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
</div>
                              <div class="cellsmall likepage">
                                <span></span>
                              </div>
                              <div class="cellcomm totalcomm"><a href="#comment" style=" margin-top: 8px;">Bình luận <span style="display:inline">(0)</span></a> </div>
                          </div>
                      </div>
                  </div>
                  <div class="bar_pre_center">
                    <div class="titinfo"><i class="icongiftpre"></i>Thông tin khuyến mãi</div>
                      <div class="titinfo"><i class="iconlistpre"></i>Thông tin sản phẩm</div>
                  </div>
                  <div class="giftpromo_pre">
                    <div class="infogift_pre">
                        <div class="areagift" id="loadpromotionlist">
                          <div class="gift-1"></div>
                        </div>
                      </div>
                      <div class="infodesc_pre">
                          <?php if ($_smarty_tpl->getVariable('productDetail')->value->summarynew!=''){?>
                            <ul>
                                <?php  $_smarty_tpl->tpl_vars['summary'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productDetail')->value->summarynew; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['summary']->key => $_smarty_tpl->tpl_vars['summary']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']++;
?>
                                  <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['summaryname']['iteration']==6){?>
                                    <?php break 1?>
                                  <?php }?>
                                  <?php if ($_smarty_tpl->tpl_vars['summary']->value!=''){?>
                                    <li><?php echo $_smarty_tpl->tpl_vars['summary']->value;?>
</li>
                                  <?php }?>
                                <?php }} ?>
                                <li>  <div class="viewmore"><a id="moreview" class="readfullsumary" onclick="readfullsumary()" href="javascript:void(0)">Xem thêm ››</a></div></li>
                            </ul>
                          <?php }?>
                      </div>
                  </div>
                </div>
                <div class="area_time_pre">
                  <div class="date_pre">Ngày có hàng: <strong><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('productDetail')->value->prepaidenddate,"%d/%m/%Y");?>
</strong></div>
                    <?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('productDetail')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?>
                    <div class="date_pre">
                      <div class="pre_countdown">
                          <span style="margin-right:3px">Còn lại:</span>
                            <div class="timedown" id="countbox1"></div>
                        </div>
                        <div class="btn-pre">
                        <?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidrand<=0||$_smarty_tpl->getVariable('numberreorder')->value<$_smarty_tpl->getVariable('productDetail')->value->prepaidrand){?>
                          <a href="<?php echo $_smarty_tpl->getVariable('registry')->value->conf['rooturl'];?>
cart/dattruoc?id=<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
"  class="buyprepaid"  <?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['promoid'])){?>&prid=<?php echo $_smarty_tpl->getVariable('productDetail')->value->barcode;?>
_<?php echo $_smarty_tpl->getVariable('parentpromotionprices')->value['promoid'];?>
<?php }?> title="Đặt hàng trước"><i class="icon-cart"></i>Đặt Mua Ngay</a>
                        <?php }else{ ?>
                          <a href="javascript:void()" title="Đặt hàng trước" style="font:bold 13px Arial;background:#cacaca"><i class="icon-cart"></i>Đã đủ số lượng đặt trước</a>
                      </div>
                        <?php }?>
                    </div>
                    <?php }else{ ?>
                      <div class="date_pre">
                        <div class="pre_countdown">
                            Hết thời gian đặt trước
                          </div>
                          <div class="btn-pre"><a href="javascript:void()" style="font:bold 13px Arial;background:#cacaca" title="Đặt hàng trước"><i class="icon-cart"></i>Hết thời gian đặt trước</a></div>
                      </div>
                    <?php }?>
                </div>
                </div>
              </div>
        <?php }else{ ?>
        <!-- head-center -->
        <div class="head-center">
          <h1 class="nameproduct" id="productname"><?php if ($_smarty_tpl->getVariable('currentCategory')->value->appendtoproductname==1){?><?php echo $_smarty_tpl->getVariable('currentCategory')->value->name;?>
 <?php }?><?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
<?php if ($_smarty_tpl->getVariable('productcolorlist')->value[0][2]!=''&&((mb_detect_encoding($_smarty_tpl->getVariable('productcolorlist')->value[0][2], 'UTF-8, ISO-8859-1') === 'UTF-8') ? mb_strtolower($_smarty_tpl->getVariable('productcolorlist')->value[0][2],SMARTY_RESOURCE_CHAR_SET) : strtolower($_smarty_tpl->getVariable('productcolorlist')->value[0][2]))!='không xác định'){?> - <?php echo $_smarty_tpl->getVariable('productcolorlist')->value[0][2];?>
<?php }?></h1>
            <?php $_smarty_tpl->tpl_vars["parentpromotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('productDetail')->value->promotionPrice(), null, null);?>
            <div class="areacenter">
              <?php if (!empty($_smarty_tpl->getVariable('crazydeal',null,true,false)->value)){?>
                <!-- KKhông quan tâm màu -->
              <?php }else{ ?>
                <div class="colorproduct">
                    <i class="textcolor">Màu sản phẩm:</i>
                    <ul>
                      <?php if (count($_smarty_tpl->getVariable('productcolorlist')->value)>0){?>
                        <?php  $_smarty_tpl->tpl_vars['productcolor'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productcolorlist')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['productcolor']->key => $_smarty_tpl->tpl_vars['productcolor']->value){
?>
                          <?php if ($_smarty_tpl->tpl_vars['productcolor']->value[0]>0){?>
                          <li><a class="black color_<?php echo $_smarty_tpl->tpl_vars['productcolor']->value[0];?>
 <?php if ($_smarty_tpl->tpl_vars['productcolor']->value[4]==1){?>actcolor<?php }?> productcolor" colorid="<?php echo $_smarty_tpl->tpl_vars['productcolor']->value[0];?>
" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productcolor']->value[1]);?>
 - <?php echo $_smarty_tpl->tpl_vars['productcolor']->value[2];?>
" style="background:#<?php echo $_smarty_tpl->tpl_vars['productcolor']->value[3];?>
;cursor: pointer"  title="<?php echo $_smarty_tpl->tpl_vars['productcolor']->value[2];?>
"   <?php if ($_smarty_tpl->tpl_vars['productcolor']->value[0]>1){?>onclick="productcolor(this)"<?php }?>></a></li>
                          <?php }?>
                        <?php }} ?>
                      <?php }?>
                    </ul>
                    <?php if ($_smarty_tpl->getVariable('productDetail')->value->sellprice>0&&$_smarty_tpl->getVariable('productDetail')->value->instock>0&&($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)){?>
                      <div class="conhang addloading instockstatus">Còn hàng</div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?>
                      <div class="conhang addloading instockstatus">Hàng sắp về</div>
                    <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?>
                      <div class="conhang addloading"></div>
                    <?php }else{ ?>
                      <div class="hethang addloading instockstatus">Hết hàng</div>
                    <?php }?>
                </div>
                <?php }?>
                <div class="totalcomm"><a href="#comment">Bình luận <span>(0)</span></a> </div>
                <div class="clear"></div>
            </div>
        	<?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?>
        	<div id="productguess">
        	    	<!-- HTML DOAN GIA -->
        	    <?php if ($_smarty_tpl->getVariable('productGuess')->value->starttime>=time()){?>
            	<div class="areaguest">
                	<?php echo $_smarty_tpl->getVariable('productGuess')->value->name;?>


                    <?php if ($_smarty_tpl->getVariable('productDetail')->value->summarynew!=''){?>
                    <ul>
                        <?php  $_smarty_tpl->tpl_vars['summary'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productDetail')->value->summarynew; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['summary']->key => $_smarty_tpl->tpl_vars['summary']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']++;
?>
                          <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['summaryname']['iteration']==6){?>
                            <?php break 1?>
                          <?php }?>
                          <?php if ($_smarty_tpl->tpl_vars['summary']->value!=''){?>
                            <li><?php echo $_smarty_tpl->tpl_vars['summary']->value;?>
</li>
                          <?php }?>
                        <?php }} ?>
                    </ul>
                    <?php }?>
                    <div class="giftP3">
                    	<img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/gifff.png"> <?php echo $_smarty_tpl->getVariable('productGuess')->value->infogift;?>

                    </div>
                    <div class="counter-tt">Thời gian bắt đầu dự đoán:</div>
                    <div id="counter"></div>
                    <div class="btn-detail">
                    	<a href="javascript:;" onclick="showpopuptruleguess(<?php echo $_smarty_tpl->getVariable('productGuess')->value->id;?>
)">Xem chi tiết »</a>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="areaguest">
                	<?php echo $_smarty_tpl->getVariable('productGuess')->value->name;?>

                    <div class="giftP3 giftP32">
                    	<img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/gifff.png"> <?php echo $_smarty_tpl->getVariable('productGuess')->value->infogift;?>

                    </div>
                    <div class="counter-tt counter-tt2">Thời gian còn lại:</div>
                    <div id="counter" class="counter"></div>
                    <div class="btn-detail btn-vtl">
                    	<a href="javascript:;" onclick="showpopuptruleguess(<?php echo $_smarty_tpl->getVariable('productGuess')->value->id;?>
)">Xem chi tiết »</a>
                    </div>
                </div>
                <div class="p3question">
               	  <div id="answesitem" data-id="<?php echo $_smarty_tpl->getVariable('productGuess')->value->id;?>
" >
        	      </div>
                <label class="p3alert"></label>
                <label class="loadinggif p3alert guessloading"></label>
                </div>
                <?php }?>
              </div>
               <!-- End DOAN GIA -->
        	<?php }else{ ?>
          <div class="areadescshort">
            <?php if ($_smarty_tpl->getVariable('productDetail')->value->summarynew!=''){?>
            <ul>
                <?php  $_smarty_tpl->tpl_vars['summary'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productDetail')->value->summarynew; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['summary']->key => $_smarty_tpl->tpl_vars['summary']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['summaryname']['iteration']++;
?>
                  <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['summaryname']['iteration']==6){?>
                    <?php break 1?>
                  <?php }?>
                  <?php if ($_smarty_tpl->tpl_vars['summary']->value!=''){?>
                    <li><?php echo $_smarty_tpl->tpl_vars['summary']->value;?>
</li>
                  <?php }?>
                <?php }} ?>
                <li>  <div class="viewmore"><a id="moreview" class="readfullsumary" onclick="readfullsumary()" href="javascript:void(0)">Xem thêm ››</a></div></li>
            </ul>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('productDetail')->value->warranty>0){?>
              <div class="warranty"><span><i class="icon-help"></i>Bảo hành chính hãng <strong><?php if (!empty($_smarty_tpl->getVariable('productDetail',null,true,false)->value->warranty)){?><?php echo $_smarty_tpl->getVariable('productDetail')->value->warranty;?>
<?php }?> tháng</strong></span></div>
            <?php }else{ ?>
                <div class="warranty"><span><i class="icon-help"></i>Đảm bảo 100% <br> <b>hàng chính hãng</b></span></div>
            <?php }?>
            <!--<div id="regionbox" style="float: right; overflow: hidden; width: 200px; font: 13px/18px Arial; margin-top: 10px;">
              <label style="clear: both; display: block;">Giao hàng đến</label>
              <select name="myregiondetail" id="fcitydetail" class="provincedetail" style="padding: 5px; width: 100%">
                <option value="">---Tỉnh/Thành---</option>
                  <?php  $_smarty_tpl->tpl_vars['region'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['regionid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('setting')->value['region']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['region']->key => $_smarty_tpl->tpl_vars['region']->value){
 $_smarty_tpl->tpl_vars['regionid']->value = $_smarty_tpl->tpl_vars['region']->key;
?>
                      <option value="<?php echo $_smarty_tpl->tpl_vars['regionid']->value;?>
" <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['regionid']->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->getVariable('me')->value->city;?>
<?php $_tmp2=ob_get_clean();?><?php if ($_tmp1==$_tmp2){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['region']->value;?>
</option>
                  <?php }} ?>
              </select>
            </div>-->
            <div class="clear"></div>
          </div>
          <div class="areapricegift">
            <?php if (!empty($_smarty_tpl->getVariable('crazydeal',null,true,false)->value)){?>
                <?php if ($_smarty_tpl->getVariable('productDetail')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('productDetail')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('parentpromotionprices')->value['price']<$_smarty_tpl->getVariable('productDetail')->value->sellprice){?>
                  <!-- San pham co khuyen mai -->
                  <div class="areaprice loadprice lp<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
">
                    <div class="wrapdienmay">
                      <div class="dienmay">
                          <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                          <div class="pricedienmay"><span class="pricenew"><?php if ($_smarty_tpl->getVariable('parentpromotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('parentpromotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                      </div>
                      <div class="genuine">
                          <div class="textgenuine">Giá thị trường:</div>
                          <div class="pricegenuine"><span class="priceold"><?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['online']);?>
<?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['offline']);?>
<?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                      </div>
                    </div>
                    <div class="econo">
                        <div class="textecono">Bạn tiết kiệm được:</div>
                        <?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?>
                                <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('listprices')->value['online'], null, null);?>
                              <?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?>
                                <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('listprices')->value['offline'], null, null);?>
                              <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?>
                                <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('productDetail')->value->sellprice, null, null);?>
                              <?php }else{ ?><?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable(1000, null, null);?><?php }?>
                              <div class="priceecono"><span><?php ob_start();?><?php echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->getVariable('finalprice')->value,'y'=>$_smarty_tpl->getVariable('parentpromotionprices')->value['price'],'format'=>"%.0f"),$_smarty_tpl);?>
<?php echo number_format(ob_get_clean())?>đ</span> (  <span class="persale"> -<?php echo floor((($_smarty_tpl->getVariable('productDetail')->value->sellprice-$_smarty_tpl->getVariable('parentpromotionprices')->value['price'])/$_smarty_tpl->getVariable('productDetail')->value->sellprice*100));?>
%</span> )
                        </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                  <!-- End san pham co khuyen mai -->
                  <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>0){?>
                  <!-- San pham khong co khuyen mai -->
                  <div class="areaprice loadprice lp<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
">
                    <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew"><?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['online']);?>
<?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['offline']);?>
<?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                    </div>
                    </div>
                    <!-- End san pham khong co khuyen mai -->
                <?php }?>
                <div class="areagift" style="display: none;" id="loadpromotionlist">
                <div class="gift-1"><i class="icon-gift"></i></div>
              </div>
              <div class="crazydetail"><span>Sản phẩm Crazy deal. Giá cực tốt 1 ngày duy nhất</span>
                <div class="crazydeal" style="margin-top:10px"><a title="Crazy deal là gì ?" href="#">Crazy deal là gì <span>?</span></a>
                    <div class="dropcrazy"><b>CrazyDeal</b> là chương trình giá shock mỗi ngày của <span class="text-dienmay"><strong>dienmay</strong>.com</span>span>. Theo đó, mỗi ngày chúng tôi sẽ giảm giá đến <b>50%</b> cho 01 sản phẩm bất kì.</div>
                </div>
                <div class="clear"></div>
              </div>
              <div class="wrap-sale">
                <div class="dealtime" id="countbox1"></div>
                <div class="datesatus"><i>Thời gian còn lại:</i></div>
              </div>
            <?php }else{ ?>
              <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?>
                <?php if ($_smarty_tpl->getVariable('productDetail')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('productDetail')->value->sellprice>0&&!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('parentpromotionprices')->value['price']<$_smarty_tpl->getVariable('productDetail')->value->sellprice){?>
                <!-- San pham co khuyen mai -->
                 <div class="areaprice loadprice lp<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
">
                  <div class="wrapdienmay">
                    <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew"><?php if ($_smarty_tpl->getVariable('parentpromotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('parentpromotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                    </div>
                    <div class="genuine">
                        <div class="textgenuine">Giá thị trường:</div>
                        <div class="pricegenuine"><span class="priceold"><?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['online']);?>
<?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['offline']);?>
<?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                    </div>
                  </div>
                  <div class="econo">
                      <div class="textecono">Bạn tiết kiệm được:</div>
                      <?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?>
                              <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('listprices')->value['online'], null, null);?>
                            <?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?>
                              <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('listprices')->value['offline'], null, null);?>
                            <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?>
                              <?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable($_smarty_tpl->getVariable('productDetail')->value->sellprice, null, null);?>
                            <?php }else{ ?><?php $_smarty_tpl->tpl_vars["finalprice"] = new Smarty_variable(1000, null, null);?><?php }?>
                            <div class="priceecono"><span><?php ob_start();?><?php echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->getVariable('finalprice')->value,'y'=>$_smarty_tpl->getVariable('parentpromotionprices')->value['price'],'format'=>"%.0f"),$_smarty_tpl);?>
<?php echo number_format(ob_get_clean())?>đ</span> (  <span class="persale"> -<?php echo floor((($_smarty_tpl->getVariable('productDetail')->value->sellprice-$_smarty_tpl->getVariable('parentpromotionprices')->value['price'])/$_smarty_tpl->getVariable('productDetail')->value->sellprice*100));?>
%</span> )
                      </div>
                  </div>
                  <div class="clear"></div>
                </div>
                <!-- End san pham co khuyen mai -->
                <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>0){?>
                  <!-- San pham khong co khuyen mai -->
                 <div class="areaprice loadprice lp<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
">
                   <div class="dienmay">
                      <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                      <div class="pricedienmay"><span class="pricenew"><?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['online']);?>
<?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['offline']);?>
<?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                  </div>
                  </div>
                  <!-- End san pham khong co khuyen mai -->
                <?php }?>
                <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?>
                <!-- hANG Sap ve -->
                  <div class="dienmay">
                      <div class="textdienmay">Giá dự kiến <span class="text-dienmay"><strong>dienmay</strong>.com</span>: </div>
                      <div class="pricedienmay"><span><?php if ($_smarty_tpl->getVariable('productDetail')->value->comingsoonprice>0){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->comingsoonprice);?>
 đ<?php }else{ ?>Chưa có giá<?php }?></span></div>
                      <?php if ($_smarty_tpl->getVariable('productDetail')->value->comingsoondate!=''){?>
                      <div class="datesatus dattruoc"><i>Dự kiến có hàng:</i><strong><?php echo $_smarty_tpl->getVariable('productDetail')->value->comingsoondate;?>
</strong></div>
                      <?php }?>
                  </div>
                  <div class="notestatus">
                    <div class="textnote"><i>Lưu ý:</i>
                        <p>Giá trên chỉ là giá dự kiến của <span class="text-dienmay"><strong>dienmay</strong>.com</span> và không phải là giá bán cuối cùng của sản phẩm này<br>
                          Giá sẽ được cập nhật khi sản phẩm chính thức ra mắt
                          </p>
                      </div>
                  </div>
                <!-- End  hang sap ve-->
                <?php }elseif((!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>0)||(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>0)){?>
                 <div class="areaprice loadprice lp<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5);?>
">
                  <div class="dienmay">
                        <div class="textdienmay">Giá bán tại <span class="text-dienmay"><strong>dienmay</strong>.com</span>:</div>
                        <div class="pricedienmay"><span class="pricenew"><?php if (!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['online'])&&$_smarty_tpl->getVariable('listprices')->value['online']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['online']);?>
<?php }elseif(!empty($_smarty_tpl->getVariable('listprices',null,true,false)->value['offline'])&&$_smarty_tpl->getVariable('listprices')->value['offline']>1000){?><?php echo number_format($_smarty_tpl->getVariable('listprices')->value['offline']);?>
<?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</span></div>
                    </div>
                  </div>
              <?php }?>
              <div class="areagift" style="display: none;" id="loadpromotionlist">
                <div class="gift-1"><i class="icon-gift"></i></div>
              </div>
            <?php }?>
              <div class="wrap-sale">
                <?php if (!empty($_smarty_tpl->getVariable('crazydeal',null,true,false)->value)){?>
                       <!-- Mua ngay -->
                   <div class="btn-buy"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
cart/<?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>mua-<?php echo $_smarty_tpl->getVariable('productDetail')->value->slug;?>
<?php }else{ ?>checkout?id=<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php }?><?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['promoid'])){?><?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>?<?php }else{ ?>&<?php }?>prid=<?php echo trim($_smarty_tpl->getVariable('productDetail')->value->barcode);?>
_<?php echo $_smarty_tpl->getVariable('parentpromotionprices')->value['promoid'];?>
<?php }?>"  id="buyonline"> <i class="icon-cart"></i> Mua ngay</a></div>
                  <!-- End mua ngay -->
                <?php }else{ ?>
                <!-- BTN MUA -->
                <?php if ($_smarty_tpl->getVariable('productDetail')->value->instock>0&&($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&$_smarty_tpl->getVariable('productDetail')->value->sellprice>0){?>
                  <!-- Mua ngay -->
                   <div class="btn-buy"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
cart/<?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>mua-<?php echo $_smarty_tpl->getVariable('productDetail')->value->slug;?>
<?php }else{ ?>checkout?id=<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php }?><?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['promoid'])){?><?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>?<?php }else{ ?>&<?php }?>prid=<?php echo trim($_smarty_tpl->getVariable('productDetail')->value->barcode);?>
_<?php echo $_smarty_tpl->getVariable('parentpromotionprices')->value['promoid'];?>
<?php }?>"  id="buyonline"> <i class="icon-cart"></i> Mua ngay</a></div>
                  <!-- End mua ngay -->
                <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?>
                  <!-- Coming soon -->
                  <div class="btn-hsapve">
                    <a href="javascript:void(0)" class="buyprepaid" title="HÀNG SẮP VỀ">HÀNG SẮP VỀ</a>
                  </div>
                  <!-- Comming soon -->
                 <?php }else{ ?>
                  <!-- Het hang -->
                    <div class="btn-hethang" >
                      <a href="javascript:void(0)" class="buyprepaid" style="background:#cacaca" title="Tạm thời hết hàng">Tạm thời hết hàng</a>
                    </div>
                    <form method="post" action="">
                      <div class="theendtext">
                        <input type="hidden" value="<?php echo $_SESSION['endstocksubcriberAddToken'];?>
" id="ftoken" name="ftoken">
                        <i>Gửi email cho tôi khi hàng trở lại:</i>
                        <div class="notifi" style="display:none;color:#00a1e6;margin: 3px 0px"></div>
                        <input class="theendinput" name="femail" id="femail" type="text" placeholder="Email của bạn">
                        <a href="javascript:void()" class="btntheend" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
" onclick="subcriberendofstock(true,$('#ftoken').val(),$('#femail').val())">Gửi</a>
                      </div>
                    </form>
                  <!-- End het hang -->
                 <?php }?>
                <!-- END BTN MUA -->
                <!-- Sieu thi con hang -->
                <div class="btn-spmark">
                <?php if (($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value)&&$_smarty_tpl->getVariable('productDetail')->value->instock>0){?>
                  <?php if (!empty($_smarty_tpl->getVariable('havestorestock',null,true,false)->value)){?>
                    <a href="#" title="Siêu thị còn hàng"><i class="icon-chart"></i>Có <?php if (count($_smarty_tpl->getVariable('havestorestock')->value)>0){?><?php echo count($_smarty_tpl->getVariable('havestorestock')->value);?>
<?php }?> siêu thị sẵn hàng</a>
                    <div class="dropsthi">
                      <ul>
                          <?php  $_smarty_tpl->tpl_vars['str'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('havestorestock')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['str']->key => $_smarty_tpl->tpl_vars['str']->value){
?>
                            <?php if ($_smarty_tpl->getVariable('str')->value->lat!=0&&$_smarty_tpl->getVariable('str')->value->lng!=0){?>
                              <li><a href="<?php echo $_smarty_tpl->getVariable('registry')->value->conf['rooturl'];?>
sieuthi/<?php echo $_smarty_tpl->getVariable('str')->value->slug;?>
" target="_blank" id="<?php echo $_smarty_tpl->getVariable('str')->value->lat;?>
_<?php echo $_smarty_tpl->getVariable('str')->value->lng;?>
" rel="<?php echo $_smarty_tpl->getVariable('str')->value->region;?>
_<?php echo $_smarty_tpl->getVariable('listregions')->value[$_smarty_tpl->getVariable('str')->value->region]->lat;?>
_<?php echo $_smarty_tpl->getVariable('listregions')->value[$_smarty_tpl->getVariable('str')->value->region]->lng;?>
" title="<?php echo $_smarty_tpl->getVariable('str')->value->name;?>
"><?php echo $_smarty_tpl->getVariable('str')->value->name;?>

                                <span><?php echo $_smarty_tpl->getVariable('str')->value->storeaddress;?>
</span>
                                  </a>
                              </li>
                            <?php }?>
                          <?php }} ?>
                        </ul>
                    </div>
                  <?php }?>
                <?php }?>
                  </div>
                <!-- End sieu thi con hang -->
              <?php }?> <!-- End crazy deal -->
              </div>
          </div>
          <?php }?>
      </div>
      <?php }?>
      <!-- head - right -->
       <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?>
          <div class="des_right">
           <?php if (!empty($_smarty_tpl->getVariable('prepaidnumberorders',null,true,false)->value)){?>
            <div class="list_pre">

              <div class="bar_list_pre">
                <?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidrand>0){?>
                  <?php if (($_smarty_tpl->getVariable('productDetail')->value->prepaidrand-$_smarty_tpl->getVariable('numberreorder')->value)>0){?>
                  Chỉ còn <b><?php echo $_smarty_tpl->getVariable('productDetail')->value->prepaidrand-$_smarty_tpl->getVariable('numberreorder')->value;?>
</b> đơn hàng có thể đặt trước
                  <?php }else{ ?>
                    Đã đủ số lượng đơn hàng đặt trước
                  <?php }?>
                <?php }else{ ?>
                  Đã có <b><?php echo $_smarty_tpl->getVariable('numberreorder')->value;?>
</b> đơn hàng đặt trước
                <?php }?>
              </div>
              <ul>
                  <?php  $_smarty_tpl->tpl_vars['userprepaid'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['prepaidposition'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prepaidnumberorders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['userprepaid']->key => $_smarty_tpl->tpl_vars['userprepaid']->value){
 $_smarty_tpl->tpl_vars['prepaidposition']->value = $_smarty_tpl->tpl_vars['userprepaid']->key;
?>
                    <li> <strong><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['userprepaid']->value,true);?>
</strong>
                    <span style="margin-left:0"> <?php echo Helper::time_ago($_smarty_tpl->getVariable('prepaidnumberorderstime')->value[$_smarty_tpl->tpl_vars['prepaidposition']->value]);?>
 trước</span>
                    </li>
                  <?php }} ?>
              </ul>
              <div class="viewall_pre">
                <a href="javascript:void(0)" onclick="showpopupprepaid(<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
)"> Xem tất cả ››</a>
              </div>
            </div>
            <?php }?>
            <?php if ($_smarty_tpl->getVariable('productDetail')->value->prepaidpolicy){?>
            <div class="policy_pre">
              <ul>
                  <?php echo $_smarty_tpl->getVariable('productDetail')->value->prepaidpolicy;?>

              </ul>
            </div>
            <?php }?>
        </div>
       <?php }else{ ?>
      <div class="head-right">
         <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?>
         <!-- USER CHOI DOAN GIA -->
      		 <?php if ($_smarty_tpl->getVariable('productGuess')->value->starttime>=time()){?>
      			 <?php echo $_smarty_tpl->getVariable('productGuess')->value->blocknews;?>

    		 <?php }else{ ?>
			   <?php if (!empty($_smarty_tpl->getVariable('userguess',null,true,false)->value)){?>
	          <div class="listorder">
	              <ul>
	                <li class="til"><?php echo $_smarty_tpl->getVariable('totaluserguess')->value;?>
 người tham gia</li>
	                   <?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('userguess')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
	                    <li><?php echo $_smarty_tpl->getVariable('user')->value->fullname;?>
<span style="margin-left:0">tham gia <?php echo Helper::time_ago($_smarty_tpl->getVariable('user')->value->datecreated);?>
 trước</span></li>

	                  <?php }} ?>
	                    <li><a href="javascript:void(0)" onclick="showpopupuserguess(<?php echo $_smarty_tpl->getVariable('productGuess')->value->id;?>
)"> Xem tất cả ››</a></li>
	              </ul>
	            </div>
    	       <?php }else{ ?>
    	         	<?php echo $_smarty_tpl->getVariable('productGuess')->value->blocknews;?>

    	       <?php }?>
		      <?php }?>
	         <ul>
                <li>
                   <div class="sharepage sharebor">
                      <div class="productpath" style="display:none"><?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
</div>
                       <label class="fom">Chia sẻ sản phẩm này</label>
                       <span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-face"></i></a></span>
                       <span><a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-goog"></i></a></span>
                       <span><a href="http://twitthis.com/twit?url=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-twitter"></i></a></span>
                       <div style="margin-top:5px" class="likepage"><span></span></div>
					             <div class="clear"></div>
                   </div>
                </li>
                <li><i class="icon-policy"></i>Đảm bảo 100% hàng chính hãng</li>
                <li><i class="icon-comp"></i>Đổi trả hàng trong 7 ngày (*)</li>
                <li><i class="icon-guide"></i>Dịch vụ khách hàng tốt nhất</li>
                <li>
                  <div class="numbercall"><i class="icon-numcall"></i><span>1800 1061</span></div>
                </li>
            </ul>
         <!-- END USER CHOI DOAN GIA -->
          <?php }else{ ?>
         	<?php if (!empty($_smarty_tpl->getVariable('prepaidnumberorders',null,true,false)->value)){?>
          <div class="listorder">
              <ul>
                <li class="til">Đã có <?php echo $_smarty_tpl->getVariable('numberreorder')->value;?>
 người đặt trước</li>
                   <?php  $_smarty_tpl->tpl_vars['userprepaid'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['prepaidposition'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('prepaidnumberorders')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['userprepaid']->key => $_smarty_tpl->tpl_vars['userprepaid']->value){
 $_smarty_tpl->tpl_vars['prepaidposition']->value = $_smarty_tpl->tpl_vars['userprepaid']->key;
?>
                    <li><?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['userprepaid']->value,true);?>
<span style="margin-left:0"> <?php echo Helper::time_ago($_smarty_tpl->getVariable('prepaidnumberorderstime')->value[$_smarty_tpl->tpl_vars['prepaidposition']->value]);?>
 trước</span></li>

                  <?php }} ?>
                    <li><a href="javascript:void(0)" onclick="showpopupprepaid(<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
)"> Xem tất cả ››</a></li>
              </ul>
            </div>
            <?php }else{ ?>
            <?php if ($_smarty_tpl->getVariable('myVendor')->value->name!=''){?>
              <div class="maker"><?php if ($_smarty_tpl->getVariable('myVendor')->value->getImage()!=''){?><img src="<?php echo $_smarty_tpl->getVariable('myVendor')->value->getImage();?>
"/><?php }else{ ?><?php echo $_smarty_tpl->getVariable('myVendor')->value->name;?>
<?php }?></div>
              <?php }?>
           <?php }?>
              <ul>
                <li class="productbookmark"><a id="addproductbookmark" onclick="return addproductbookmark();" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
" data-barcode="<?php echo $_smarty_tpl->getVariable('productDetail')->value->barcode;?>
"  href="javascript:;"><i class="icon-heart"></i>Tôi thích sản phẩm này</a></li>

                <?php if ($_smarty_tpl->getVariable('productDetail')->value->sellprice>0&&($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&$_smarty_tpl->getVariable('productDetail')->value->instock>0&&$_smarty_tpl->getVariable('installments')->value['PPF']['nosupport']==1&&!empty($_smarty_tpl->getVariable('installments',null,true,false)->value['PPF']['monthly'])){?>

                  <li><a href="javascript:void(0)" title="Mua trả góp" id="installment" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
" ><i class="icon-inst"></i> Mua trả góp từ <span class="installment"><?php echo number_format(round($_smarty_tpl->getVariable('installments')->value['PPF']['monthly']));?>
đ/tháng</span></a></li>

                 <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->sellprice>0&&($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&$_smarty_tpl->getVariable('productDetail')->value->instock>0&&$_smarty_tpl->getVariable('installments')->value['ACS']['nosupport']==1&&!empty($_smarty_tpl->getVariable('installments',null,true,false)->value['ACS']['monthly'])){?>
                      <li><a href="javascript:void(0)" title="Mua trả góp" id="installment" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
" ><i class="icon-inst"></i> Mua trả góp từ <span class="installment"><?php echo number_format(round($_smarty_tpl->getVariable('installments')->value['ACS']['monthly']));?>
đ/tháng</span></a></li>
                 <?php }?>
                <li>
                   <div class="sharepage sharebor">
                        <div class="productpath" style="display:none"><?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
</div>
                       <label class="fom">Chia sẻ sản phẩm này</label>
                       <!--<span><a href="#"><i class="icon-mail"></i></a></span> -->
                       <span><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-face"></i></a></span>
                       <span><a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-goog"></i></a></span>
                       <span><a href="http://twitthis.com/twit?url=<?php echo $_smarty_tpl->getVariable('productDetail')->value->getProductPath();?>
" target="_blank"><i class="icon-twitter"></i></a></span>
                       <!--<span><a href="#"><i class="icon-youtube"></i></a></span> -->
                       <div class="clear"></div>
                   </div>
                </li>
                <li><i class="icon-policy"></i>Đảm bảo 100% hàng chính hãng</li>
                <li><i class="icon-comp"></i>Đổi trả hàng trong 7 ngày (*)</li>
                <li><i class="icon-guide"></i>Dịch vụ khách hàng tốt nhất</li>
                <li>
                  <div class="numbercall"><i class="icon-numcall"></i><span>1800 1061</span></div>
                </li>
                <li>
                   <div class="likepage">
                        <span></span>
                    </div>
                </li>
            </ul>
             <?php }?>
        </div>
        <?php }?>
        <div class="clear"></div>
    </div>
    <!-- content detail -->
    <div class="articlesdetail">
    <div class="main">
      <article class="post__article">
        <?php if (!empty($_smarty_tpl->getVariable('productDetail',null,true,false)->value->fullbox)&&!empty($_smarty_tpl->getVariable('specialimage',null,true,false)->value)){?>
        <h6>Chức năng - Kích thước</h6>
          <div id="feature">
            <div class="featcol">

              <div class="featbar"><h2>Mô tả tính năng</h2></div>
                <?php echo $_smarty_tpl->getVariable('productDetail')->value->fullbox;?>

                </div>
                <div class="featcol featfloat">
                    <div class="featbar"><h2>Kích thước sản phẩm</h2></div>
                     <img src="<?php echo $_smarty_tpl->getVariable('specialimage')->value;?>
" alt="<?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
" />
                </div>
            </div>
        <?php }?>
        <?php if (!empty($_smarty_tpl->getVariable('galleries',null,true,false)->value)||!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
        <h6>Hình ảnh - Video</h6>
         <!-- gallery video -->
          <div id="gallery" class="s2">
            <!-- gallery -->
            <div class="glalery_one" <?php if (empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>style="width:100%"<?php }?>>
              <div class="galvidbar titlename"><h2>Hình ảnh sản phẩm</h2></div>
              <!-- Xoay 360 -->
              <!--<div id="360frames"></div>-->
              <!-- end xoay 360 -->
              <div class="doubleSlider-1">
                <div class="slider">
                  <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('galleries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
?>
                    <div class="item thumnail">
                      <img border="0" title="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->caption)){?><?php echo $_smarty_tpl->getVariable('gal')->value->caption;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->titleseo;?>
<?php }?>" src="<?php echo $_smarty_tpl->getVariable('gal')->value->getImage();?>
" alt="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->alt)){?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }?>">
                    </div>
                 <?php }} ?>
                </div>
              </div>
              <div class="wrapButtonslide">
                <div class="doubleSliderPrevButton" style="cursor: pointer;"></div>
                <div class="doubleSliderNextButton" style="cursor: pointer;"></div>
              </div>
              <?php if (count($_smarty_tpl->getVariable('galleries360')->value)>=36){?>
              <div class="cell360px"><a href="javascrip:void()"><i class="icon-img360"></i></a></div>
              <?php }?>
              <div class="doubleSlider-2">
                <div class="slider">
                   <?php  $_smarty_tpl->tpl_vars['gal'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('galleries')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['gal']->key => $_smarty_tpl->tpl_vars['gal']->value){
?>
                      <div class="button thumnail borderfirst actived"><img border="0" title="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->caption)){?><?php echo $_smarty_tpl->getVariable('gal')->value->caption;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->titleseo;?>
<?php }?>" alt="<?php if (!empty($_smarty_tpl->getVariable('gal',null,true,false)->value->alt)){?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('gal')->value->alt;?>
<?php }?>" src="<?php echo $_smarty_tpl->getVariable('gal')->value->getSmallImage();?>
"></div>
                  <?php }} ?>
                </div>
              </div>
            </div>
            <!-- video -->
          <?php if (!empty($_smarty_tpl->getVariable('videos',null,true,false)->value)){?>
            <div class="wrap-video" id="#video">
                <div class="galvidbar titlename"><h2>Video sản phẩm</h2></div>
                <div class="group-video">
                  <div id="runyoutubeurl" class="video-larg">
                    <iframe width="420" height="390" frameborder="0" allowfullscreen="" src="<?php echo $_smarty_tpl->getVariable('videos')->value[0]->moreurl;?>
"></iframe>
                    <input type="hidden" class="contentvideo" value="<?php echo $_smarty_tpl->getVariable('videos')->value[0]->moreurl;?>
"/>
                  </div>
                  <?php if (count($_smarty_tpl->getVariable('videos')->value)>0){?>
                    <div class="video-small">
                      <ul>
                        <?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('videos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['video']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
 $_smarty_tpl->tpl_vars['video']->index++;
 $_smarty_tpl->tpl_vars['video']->first = $_smarty_tpl->tpl_vars['video']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['videonamesmart']['first'] = $_smarty_tpl->tpl_vars['video']->first;
?>
                            <?php if (!empty($_smarty_tpl->getVariable('video',null,true,false)->value->moreurl)){?>
                                <li class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['videonamesmart']['first']){?>activede<?php }?> popupvideo" rel="<?php echo $_smarty_tpl->getVariable('video')->value->moreurl;?>
"><img src="http://img.youtube.com/vi/<?php echo $_smarty_tpl->getVariable('video')->value->youtubeid;?>
/default.jpg" alt="<?php echo $_smarty_tpl->getVariable('productDetail')->value->name;?>
"/></li>
                            <?php }?>
                        <?php }} ?>
                      </ul>
                    </div>
                  <?php }?>
                  <ul class="nguon-youtube">
                      <li>
                        Nguồn Youtube
                      </li>
                  </ul>
                </div>
              </div>
            <?php }?>
          </div>
        <?php }?>
         <!-- ================== -->
        <h6>Giới thiệu sản phẩm</h6>
        <div class="wrap_article" <?php if (count($_smarty_tpl->getVariable('relProductProduct')->value)<0){?>style="width:100%"<?php }?>>
         <!-- Bài viết -->
         <?php if (!empty($_smarty_tpl->getVariable('productDetail',null,true,false)->value->content)){?>
            <div id="articles" class="s3">
                <div class="articlesbar" id="introduction"><h2>Bài viết sản phẩm</h2></div>
                <div class="articles">
                  <?php echo $_smarty_tpl->getVariable('productDetail')->value->content;?>

                </div>
                <!-- nut mua ngay -->
                <?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('productDetail')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('productDetail')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?>
                 <!-- TH1 Dat truoc-->
                  <div class="btnbuynow btn-muangay">
                    <a href="<?php echo $_smarty_tpl->getVariable('registry')->value->conf['rooturl'];?>
cart/dattruoc?id=<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
" class="buyprepaid" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
"<?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value)&&$_smarty_tpl->getVariable('parentpromotionprices')->value['promoid']>0){?> id="<?php echo $_smarty_tpl->getVariable('productDetail')->value->barcode;?>
_<?php echo $_smarty_tpl->getVariable('parentpromotionprices')->value['promoid'];?>
"<?php }?> title="Đặt hàng trước">Đặt trước &#187;</a>
                  </div>
               <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->instock>0&&($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&$_smarty_tpl->getVariable('productDetail')->value->sellprice>0){?>
                <!--TH2 -->
                   <div class="btnbuynow btn-muangay"><a  href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
cart/<?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>mua-<?php echo $_smarty_tpl->getVariable('productDetail')->value->slug;?>
<?php }else{ ?>checkout?id=<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
<?php }?><?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['promoid'])){?><?php if ($_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>?<?php }else{ ?>&<?php }?>prid=<?php echo trim($_smarty_tpl->getVariable('productDetail')->value->barcode);?>
_<?php echo $_smarty_tpl->getVariable('parentpromotionprices')->value['promoid'];?>
<?php }?><?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['promoid'])&&$_smarty_tpl->getVariable('productDetail')->value->slug!=''){?>&<?php }else{ ?>?<?php }?>po=p<?php echo substr(trim($_smarty_tpl->getVariable('productDetail')->value->barcode),-5,5);?>
41"  id="buyonline"> Mua ngay &#187;</a></div>
              <?php }elseif($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?>
                <!-- TH3 -->
              <?php }else{ ?>
                <!-- HET HANG -->
              <?php }?>
                <!-- end nut mua ngay -->
            </div>
        <?php }?>
            <!-- Sản phẩm liên quan -->
          <div class="related sticktop">
            <?php if (count($_smarty_tpl->getVariable('relProductProduct')->value)>0){?>
          <div class="relatedbar"><h2>Sản phẩm liên quan</h2></div>
          <ul>
             <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('relProductProduct')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['relpp']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['relpp']['iteration']++;
?>
                <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['relpp']['iteration']==6){?><?php break 1?><?php }?>
                <?php $_smarty_tpl->tpl_vars["promotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('product')->value->promotionPrice(), null, null);?>

              <li>
                 <?php if ($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div>
                  <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('product')->value->instock==0){?><div class="special"><i class="icon-theend"></i></div>
                  <?php }?>
                <a href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
?ref=related_product_link"><h4><?php echo $_smarty_tpl->getVariable('product')->value->name;?>
</h4></a>
                <div class="imageproductsame"><a href="<?php echo $_smarty_tpl->getVariable('product')->value->getProductPath();?>
?ref=related_product_link" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
"><img src="<?php echo $_smarty_tpl->getVariable('product')->value->getSmallImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('product')->value->name);?>
" /> </a> </div>
                <?php if ($_smarty_tpl->getVariable('product')->value->displaysellprice!=1&&$_smarty_tpl->getVariable('product')->value->sellprice>0&&($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('product')->value->sellprice){?>
                  <div class="priceold price1"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                        <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('promotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                        <span class="salepercent"> -<?php echo floor((($_smarty_tpl->getVariable('product')->value->sellprice-$_smarty_tpl->getVariable('promotionprices')->value['price'])/$_smarty_tpl->getVariable('product')->value->sellprice*100));?>
%</span>
               <?php }elseif($_smarty_tpl->getVariable('product')->value->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('product')->value->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('product')->value->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?>
                         <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('product')->value->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                       <?php }elseif($_smarty_tpl->getVariable('product')->value->sellprice>0){?>
                         <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('product')->value->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('product')->value->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                       <?php }?>
              </li>
              <?php }} ?>
            </ul>
            <?php }?>
           </div>
        </div>
         <!-- ================== -->
       <div class="clear"></div>
         <!-- Thông tin thương hiệu -->
         <?php if ($_smarty_tpl->getVariable('myVendor')->value->insurance!=''){?>

        <h6>Thông tin thương hiệu</h6>
            <div id="infobrand">
                <div class="articlesbar"><h2>Thông tin thương hiệu</h2></div>
                <?php if ($_smarty_tpl->getVariable('myVendor')->value->getImage()!=''){?>
                  <img src="<?php echo $_smarty_tpl->getVariable('myVendor')->value->getImage();?>
" alt="<?php echo $_smarty_tpl->getVariable('myVendor')->value->name;?>
"/>
                <?php }?>
                <p><?php echo $_smarty_tpl->getVariable('myVendor')->value->insurance;?>
</p>
                <a href="<?php echo $_smarty_tpl->getVariable('registry')->value->conf['rooturl'];?>
<?php echo $_smarty_tpl->getVariable('myVendor')->value->slug;?>
" title="Xem tất cả sản phẩm khác của <?php echo $_smarty_tpl->getVariable('myVendor')->value->name;?>
">Xem tất cả sản phẩm khác của <?php echo $_smarty_tpl->getVariable('myVendor')->value->name;?>
 ›› </a>
            </div>
          <?php }?>
            <!-- Mua kèm -->
            <?php if (!empty($_smarty_tpl->getVariable('accessoriesProducts',null,true,false)->value)){?>
            <div id="accessory">
                <div class="articlesbar"><h2>Khách hàng mua sản phẩm này thường mua kèm với nhau</h2></div>
                <div class="accesscont" id="accessoryparentbox">
                    <div class="accessleft">
                        <div class="accessimg"><img src="<?php echo $_smarty_tpl->getVariable('productDetail')->value->getSmallImage();?>
" /></div>

                        <div class="accesslist">
                          <?php  $_smarty_tpl->tpl_vars['accessory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('accessoriesProducts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['accessory']->key => $_smarty_tpl->tpl_vars['accessory']->value){
?>
                            <div class="accessmath" id="accessmath_<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
">+</div>
                            <div class="accessproduct" id="accessproduct_<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
">
                                <a href="<?php echo $_smarty_tpl->getVariable('accessory')->value->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('accessory')->value->name;?>
"><img src="<?php echo $_smarty_tpl->getVariable('accessory')->value->getSmallImage();?>
" alt="<?php echo $_smarty_tpl->getVariable('accessory')->value->name;?>
" /></a>
                            </div>
                          <?php }} ?>
                        </div>
                        <!-- ==== -->
                            <div class="clear"></div>
                            <?php  $_smarty_tpl->tpl_vars['accessory'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('accessoriesProducts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['accessory']->key => $_smarty_tpl->tpl_vars['accessory']->value){
?>
                              <?php $_smarty_tpl->tpl_vars["promotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('accessory')->value->promotionPrice(), null, null);?>
                                  <?php if ($_smarty_tpl->getVariable('accessory')->value->displaysellprice!=1&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('accessory')->value->sellprice){?>
                                  <div class="accessprice-2">
                                    <label style="cursor: pointer"><input class="acccheck chkaccessory" name="access_<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" rel="<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" type="checkbox" checked="checked" value="<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" />
                                        <a><?php echo $_smarty_tpl->getVariable('accessory')->value->name;?>
</a>
                                        <div class="accessprice-1" style="float:left;margin-left:9px"><?php echo number_format($_smarty_tpl->getVariable('accessory')->value->sellprice);?>
đ</div>
                                        <div class="accessprice-2"><span><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
đ</span></div>
                                      </label>
                                  </div>
                              <?php }else{ ?>
                                  <div class="accessprice-2">
                                    <label style="cursor: pointer"><input class="acccheck chkaccessory" name="access_<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" rel="<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" type="checkbox" checked="checked" value="<?php echo $_smarty_tpl->getVariable('accessory')->value->id;?>
" />
                                      <a><?php echo $_smarty_tpl->getVariable('accessory')->value->name;?>
</a>
                                  <span><?php echo number_format($_smarty_tpl->getVariable('accessory')->value->sellprice);?>
đ</span>
                                  </label>
                                </div>
                              <?php }?>
                            <?php }} ?>
                    </div>
                    <div class="accessmath">=</div>
                    <div class="accessright" id="accessorybox" rel="<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
">
                        <?php if (!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value)&&!empty($_smarty_tpl->getVariable('parentpromotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('parentpromotionprices')->value['price']<$_smarty_tpl->getVariable('productDetail')->value->sellprice){?>

                          <div class="accessrow" id="priceretail">Giá mua lẻ: <span><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
đ</span></div>
                          <div class="accessrow" id="priceassessory">Giá mua kèm: <strong><?php echo number_format($_smarty_tpl->getVariable('parentpromotionprices')->value['price']);?>
đ</strong></div>
                          <div class="accessrow" id="pricesaving">Tiết kiệm: <span><?php ob_start();?><?php echo smarty_function_math(array('equation'=>"x - y",'x'=>$_smarty_tpl->getVariable('productDetail')->value->sellprice,'y'=>$_smarty_tpl->getVariable('parentpromotionprices')->value['price'],'format'=>"%.0f"),$_smarty_tpl);?>
<?php echo number_format(ob_get_clean())?>đ</span></div>
                          <?php }else{ ?>
                          <div class="accessrow">Giá mua: <strong><?php echo number_format($_smarty_tpl->getVariable('productDetail')->value->sellprice);?>
đ</strong></div>
                          <?php }?>
                          <div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()">Mua sản phẩm đã chọn</span></a></div>
                    </div>
                </div>
            </div>
            <?php }?>
         <!-- ======================= -->
        <h6>Nhận xét</h6>
         <!-- Comment -->
            <div id="comment">

            </div>
         <!-- ================= -->
         <h6><a class="readfullsumary" href="javascript:void(0)">Thông số kỹ thuật</a></h6>
         <div style="min-height:450px; display:none"></div>
        <!--<a class="iframe" href="thong-so-ky-thuat.html"><h4>Thong số kỹ thuật</h4></a>-->
      </article>
  </div>
    <!-- Sản phẩm đề nghị -->

     <?php if (count($_smarty_tpl->getVariable('relProductProduct')->value)>5){?>

    <div id="interested">
          <div class="articlesbar"><h2>Có thể bạn quan tâm</h2></div>
            <div class="products">

                        <ul>
                          <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['item']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['name'] = 'item';
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('relProductProduct')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'] = (int)5;
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['max'] = (int)5;
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['show'] = true;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['max'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['item']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['item']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['item']['total']);
?>
                            <?php $_smarty_tpl->tpl_vars["promotionprices"] = new Smarty_variable($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->promotionPrice(), null, null);?>

                          <li>
                            <?php if ($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value){?><div class="special"><i class="icon-preorder"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsCommingSoon')->value){?><div class="special"><i class="icon-hsapve"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value){?><div class="special"><i class="icon-hot"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value){?><div class="special"><i class="icon-new"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value){?><div class="special"><i class="icon-bestsale"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsCrazySale')->value){?><div class="special"><i class="icon-crazydeal"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?><div class="special"><i class="icon-betting"></i></div>
                            <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsNoSell')->value||$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->instock==0){?><div class="special"><i class="icon-theend"></i></div>
                            <?php }?>
                            <a href="<?php echo $_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->getProductPath();?>
?ref=you_may_interest_link" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->name);?>
"><img src="<?php echo $_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->getSmallImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->name);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->name);?>
" /> </a> <a class="position-a" href="<?php echo $_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->getProductPath();?>
?ref=you_may_interest_link"><h3><?php echo $_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->name;?>
</h3>
                            </a>
                            <?php if ($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->displaysellprice!=1&&$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice>0&&($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsERP')->value||$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsHot')->value||$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsNew')->value||$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsBestSeller')->value)&&!empty($_smarty_tpl->getVariable('promotionprices',null,true,false)->value['price'])&&$_smarty_tpl->getVariable('promotionprices')->value['price']<$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice){?>
                              <div class="priceold price1"><?php if ($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                                    <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('promotionprices')->value['price']>1000){?><?php echo number_format($_smarty_tpl->getVariable('promotionprices')->value['price']);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                                    <span class="salepercent"> -<?php echo floor((($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice-$_smarty_tpl->getVariable('promotionprices')->value['price'])/$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice*100));?>
%</span>
                           <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->onsitestatus==$_smarty_tpl->getVariable('OsERPPrepaid')->value&&$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->prepaidstartdate<=$_smarty_tpl->getVariable('currentTime')->value&&$_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->prepaidenddate>=$_smarty_tpl->getVariable('currentTime')->value){?>
                                     <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->prepaidprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->prepaidprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                                   <?php }elseif($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice>0){?>
                                     <div class="pricenew price2"><?php if ($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice>1000){?><?php echo number_format($_smarty_tpl->getVariable('relProductProduct')->value[$_smarty_tpl->getVariable('smarty')->value['section']['item']['index']]->sellprice);?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['promotionspecial'];?>
<?php }?> đ</div>
                                   <?php }?>
                          </li>
                           <?php endfor; endif; ?>
                        </ul>

                    </div>
        </div>
        <?php }?>
        <!--Thong so ky thuat full-->
    <div class="conttable" style="display: none;" id="attrfull">
        <div class="conttitle" style="position: relative;"> Chi tiết tính năng sản phẩm</div>
        <?php if (count($_smarty_tpl->getVariable('productGroupAttributes')->value)>0&&count($_smarty_tpl->getVariable('productAttributes')->value)>0&&count($_smarty_tpl->getVariable('relProductAttributes')->value)>0){?>
            <table class="martable" cellspacing="0" width="100%" cellpadding="0" style="margin-top: 0;">
            <?php  $_smarty_tpl->tpl_vars['groupattributes'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productGroupAttributes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['groupattributes']->key => $_smarty_tpl->tpl_vars['groupattributes']->value){
?>
            <?php if (!empty($_smarty_tpl->getVariable('productAttributes',null,true,false)->value[$_smarty_tpl->getVariable('groupattributes',null,true,false)->value->id])){?>
            <tr>
                <td valign="top" class="generaltd"><?php echo $_smarty_tpl->getVariable('groupattributes')->value->name;?>
</td>
                <td class="generaltd-2">
                    <table width="100%" cellspacing="10" cellpadding="0">
                    <?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('productAttributes')->value[$_smarty_tpl->getVariable('groupattributes')->value->id]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
?>
                        <?php if (!empty($_smarty_tpl->getVariable('relProductAttributes',null,true,false)->value[$_smarty_tpl->getVariable('attribute',null,true,false)->value->id][$_smarty_tpl->getVariable('productDetail',null,true,false)->value->id])){?>
                            <tr>
                                <td width="200"><?php echo $_smarty_tpl->getVariable('attribute')->value->name;?>
</td>
                                <td><?php echo $_smarty_tpl->getVariable('relProductAttributes')->value[$_smarty_tpl->getVariable('attribute')->value->id][$_smarty_tpl->getVariable('productDetail')->value->id]->value;?>
 <?php echo $_smarty_tpl->getVariable('productAttributes')->value[$_smarty_tpl->getVariable('groupattributes')->value->id][$_smarty_tpl->getVariable('attribute')->value->id]->unit;?>
</td>
                              </tr>
                        <?php }?>
                    <?php }} ?>
                </table>
                </td>
            </tr>
            <?php }?>
            <?php }} ?>
            </table>
        <?php }?>
    </div>
    <!--end-->
</div>


<script type="text/javascript">
  // add 360
  //ENd 360
  var doangia = "<?php if ($_smarty_tpl->getVariable('productDetail')->value->onsitestatus==$_smarty_tpl->getVariable('OsDoanGia')->value){?>1<?php }else{ ?>0<?php }?>";
  var fpcid = "<?php echo $_smarty_tpl->getVariable('productDetail')->value->pcid;?>
";
  var pid = "<?php echo $_smarty_tpl->getVariable('productDetail')->value->id;?>
";
  var fgpa = "<?php echo $_smarty_tpl->getVariable('gpa')->value;?>
";
  var fpa = "<?php echo $_smarty_tpl->getVariable('pa')->value;?>
";
  var prel = "<?php echo $_smarty_tpl->getVariable('prel')->value;?>
";
  var image360path = "<?php echo $_smarty_tpl->getVariable('pathimage360')->value;?>
";
  var countimagepath = "<?php echo count($_smarty_tpl->getVariable('galleries360')->value);?>
";
  if($('#360thumb').length > 0)
  {
    var framess = [];
    for(var i = 1 ; i<=countimagepath ; i++)
    {
        framess.push(image360path.replace('#',i));
    }
  }
  $(document).ready(function(){
      $('.likepage span').html('<iframe src="http://www.facebook.com/plugins/like.php?href='+$('.productpath').html()+'&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>');
      //Load comment
      initEditInline(fpcid, pid);
      loadReview(pid , '');
      //End load cmment
      //Creazydeal
      if($('.dropcrazy').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimecrazydeal",{fpid:pid,fpcid:fpcid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            GetCount(dateFuture1,'countbox1');
        });
      }
      //End crazydeal
      if($('.pre_countdown').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimeprepaid",{fpid:pid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            GetCount(dateFuture1,'countbox1');
        });
      }
      //Doan gia
      if(doangia == "1"){
	      if( pid == 62611){
	    	  	$("<p style='text-align: center; margin-bottom: 15px;'><img style='max-width: 100%;' src='http://dienmay.com/uploads/pimages/Khuyen-mai/Event/doangiatab3lite/galaxy-lite-1200x160.jpg' alt='TRẢ LỜI HAY, TRÚNG NGAY NOKIA LUMIA 1320' /></p>" ).insertBefore("#detail-head");
	      }
        var dateguessprice = '';
  		  $.ajax({
    			type : "POST",
    			data : {fpid:pid,fpcid:fpcid},
    			url : rooturl+"product/gettimedoangia",
    			dataType: "json",
    			success: function(data){
    				if(data.error >= 0){
    					countdowntimestart(data.timestart, data.timeend);
    				}
    			}
  		  });
      }
      //End crazydeal

      $('.cell360px').bind('click',function(event) {
          $('#360sprite').addClass('loadingframe');
          $('.slider > img').css('display','none');
          $('.actived').removeClass('actived');
          $(this).addClass('actived');
          $('#360frames').remove();
          var doubleslider = $('.doubleSlider-1');
          doubleslider.prepend('<div id="360frames"></div>');
          xoay360(framess);
          $('.loadingframe').removeClass('loadingframe');
      });
      $('.thumnail > img').click(function(event) {
        $('.slider > img').css('display','block');
          $('#360frames').remove();
      });
      $('#360thumb a').bind("click",function(){
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom ').css("display","none");
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          $('#zoomslide').prepend('<div id="360sprite" class="image360">');
          $('.zoomContainer').css("display","none");
          xoay360thumb(framess);
      });
      $('#videothumb a').bind('click',function() {
          $('.active').removeClass('active');
          $(this).parent().addClass('active');
          $('#zoomslide > .fixzoom').css("display","none");
          if($('#360sprite').length > 0)
              $('#360sprite').remove();
          if($('#zoomslide .fixzoomvideo > iframe').length > 0)
              $('#zoomslide .fixzoomvideo').remove();
          var url = $('.contentvideo').val();
          $('#zoomslide').prepend('<div class="fixzoomvideo"><iframe width="400" height="380" frameborder="0" allowfullscreen="" src="'+url+'"></iframe></div>');
          $('.zoomContainer').css("display","none");
      });

      $('#fcitydetail').change(function(){
        $.post(rooturl + '', {rid: $(this).val()}, function(){

        });
      });
  });
  setTimeout(addfullsumary,1000);
  function addfullsumary()
  {
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('href','javascript:void(0)');
    $('.articlesdetail .main .scroll-nav .scroll-nav__wrapper li:last-child a').attr('onclick','readfullsumary()');
  }

  function GetCount(ddate,iid){

    dateNow = new Date(); //grab current date
    amount = ddate.getTime() - dateNow.getTime(); //calc milliseconds between dates
    delete dateNow;
    // if time is already past
    if(amount < 0){
      if ($('.dropcrazy').length > 0) {
         $.post( rooturl+"product/updatestatusandpromotion",{fpid:pid,fpcid:fpcid}, function(data) {
            if(data == 1)
            {
              $('.crazydetail').remove();
              $('.datesatus').remove();
              $('.dealtime').remove();

              location.reload();
            }
         });
       }
       else {

       }
    }
    // else date is still good
    else{
      if ($('.dropcrazy').length > 0) {
        hours=0;mins=0;secs=0;out="";
        amount = Math.floor(amount/1000);
        hours=Math.floor(amount/3600);
        amount=amount%3600;
        mins=Math.floor(amount/60);
        amount=amount%60;
        secs=Math.floor(amount);//seconds
        if(hours != 0){out +="<div class='hours'>"+ hours +" "+((hours==1)?" ":"H")+" </div>  ";}
        out +="<div class='mins'>"+ mins +" "+((mins==1)?" ":" ' ")+" </div> ";
        out +="<div class='secs'>"+ secs +" "+((secs==1)?" ":" s ")+"</div>  ";
      }
      else {
        days=0;hours=0;mins=0;secs=0;out="";
        amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs
        days=Math.floor(amount/86400);//days
        amount=amount%86400;
        hours=Math.floor(amount/3600);//hours
        amount=amount%3600;
        mins=Math.floor(amount/60);//minutes
        amount=amount%60;
        secs=Math.floor(amount);//seconds
        if(days != 0){out += "<div style='float:left'><span>"+ days +"</span><strong>:</strong><b>Ngày</b></div>";}
        out +="<div style='float:left'><span>"+ hours +"</span><strong>:</strong><b>Giờ</b></div>";
        out +="<div style='float:left'><span>"+ mins +" </span><strong>:</strong><b>Phút</b></div>";
        out +=" <div style='float:left'><span>"+ secs +"</span><b>Giây</b></div>";
      }
      out = out.substr(0,out.length-2);
      document.getElementById(iid).innerHTML=out;
      setTimeout(function(){GetCount(ddate,iid)}, 1000);
    }
  }

  function countdowntimestart(timestart,timeend){
        var tmpdatetime = timestart.split(' ');
        var date = tmpdatetime[0].split('-');
        var time = tmpdatetime[1].split(':');
        dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
        dateNow = new Date();
        amount = dateguessprice.getTime() - dateNow.getTime();
        if(Math.floor(amount) > 0 ){

            if( $('#counter').is(':empty') ) {
	        	$('#counter').countdown({
	    			timestamp : Math.floor((new Date()).getTime() + amount)
    	  		});
        	 }
		}else{

			var tmpdatetime = timeend.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateguessprice = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]);
            amount = dateguessprice.getTime() - dateNow.getTime();
            if(Math.floor(amount) <= 0){
            	clearTimeout();
                $.post( rooturl+"product/updatestatusdoangia",{fpid:pid,fpcid:fpcid}, function(data) {
                    if(data == 1)
                    {
                      location.reload();
                    }
                 });
	        }else{
		        if($(".p3question").length == 0 ){
		        	$.post( rooturl+"product/showformguess",{fpid:pid,fpcid:fpcid,action:'showformguess'}, function(data) {
	                    if(data != '')
	                    {
	                     	$('#productguess').html(data);
	                    }
	                 });
		        }
	        	if( $('#counter').is(':empty') ) {
		        	$('#counter').countdown({
		    			timestamp : Math.floor((new Date()).getTime() + amount)
	    	  		});
	        	 }
		        }
		}
    setTimeout(function(){countdowntimestart(timestart,timeend)}, 1000);
  }


</script>
