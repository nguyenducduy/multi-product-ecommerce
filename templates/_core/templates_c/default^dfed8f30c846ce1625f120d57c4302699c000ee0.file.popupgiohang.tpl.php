<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:41:50
         compiled from "templates/default/_controller/site/cart/popupgiohang.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5934863735e8ec34d41e871-49638575%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfed8f30c846ce1625f120d57c4302699c000ee0' => 
    array (
      0 => 'templates/default/_controller/site/cart/popupgiohang.tpl',
      1 => 1586414507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5934863735e8ec34d41e871-49638575',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escapequote')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escapequote.php';
if (!is_callable('smarty_function_math')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/function.math.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($_smarty_tpl->getVariable('pageTitle')->value!=''){?><?php echo $_smarty_tpl->getVariable('pageTitle')->value;?>
 - <?php echo $_smarty_tpl->getVariable('setting')->value['site']['heading'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('setting')->value['site']['defaultPageTitle'];?>
<?php }?></title>
<meta name="keywords" content="<?php echo smarty_modifier_escapequote((($tmp = @$_smarty_tpl->getVariable('pageKeyword')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('setting')->value['site']['defaultPageKeyword'] : $tmp));?>
" />
<meta name="description" content="<?php echo smarty_modifier_escapequote((($tmp = @$_smarty_tpl->getVariable('pageDescription')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('setting')->value['site']['defaultPageDescription'] : $tmp));?>
" />
<meta name="robots" content="<?php if (!empty($_smarty_tpl->getVariable('pageMetarobots',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('pageMetarobots')->value;?>
<?php }else{ ?>index, follow<?php }?>"/>
<?php if ($_smarty_tpl->getVariable('discount')->value==1){?>
<meta property="og:image" content="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/discountproduct/imgfbbacktoschool.png"/>
<?php }?>
<?php if (!empty($_smarty_tpl->getVariable('pageCanonical',null,true,false)->value)){?>
<link rel="canonical" href="<?php echo $_smarty_tpl->getVariable('pageCanonical')->value;?>
"/>
<?php }?>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/min/?g=css&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />
<!--  <link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=css&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['cssversion'];?>
" media="screen" />-->
<script src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/js/jquery.js"></script>

<script type="text/javascript">
        var rooturl = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
";
        var rooturl_profile = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
";
        var pathImage360 = "<?php echo $_smarty_tpl->getVariable('pathimage360')->value;?>
";
        var numImage360 = "<?php echo $_smarty_tpl->getVariable('numimage360')->value;?>
";
        var imageDir = "<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
";
        var ispriceajax = <?php echo $_smarty_tpl->getVariable('setting')->value['site']['isajaxprice'];?>
;
</script>
</head>

<body>
<form method="post" id="checkoutform" class="formcheckout">
<?php if (!empty($_smarty_tpl->getVariable('giftProduct',null,true,false)->value)){?>
  <div class="giftProduct"></div>
  <input type='hidden' value="<?php echo $_smarty_tpl->getVariable('isshowgift')->value;?>
" name="hiddengift" />
  <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('giftOrder')->value->pricefrom;?>
-<?php echo $_smarty_tpl->getVariable('giftOrder')->value->priceto;?>
" id="priceorder"/>
<?php }?>
<div id="checkout-wrap">
  <div id="header-checkout">
        <div class="logo-co"> <a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
"> <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/logo-dien-may.png"></a> </div>
    <div class="process-co">
      <ul class="step">
        <li class="step_done"> <span>Chọn hàng</span></li>
        <li class="step_done"> <span>Nhập thông tin thanh toán</span></li>
        <li class="step_todo"> <span>Xác nhận đơn hàng</span></li>
      </ul>
    </div>
  </div>

  <!-- Check out -->
   <?php $_template = new Smarty_Internal_Template("notify.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('notifyError',$_smarty_tpl->getVariable('error')->value);$_template->assign('notifySuccess',$_smarty_tpl->getVariable('success')->value); echo $_template->getRenderedTemplate();?><?php unset($_template);?>
  <div id="summary-checkout">
    <div class="payment-info">
      <h3>Thông tin thanh toán</h3>
      <div class="form_content">
        <h4>Địa chỉ nhận hàng</h4>
        <?php if ($_smarty_tpl->getVariable('registry')->value->me->id<=0){?>
            <span class="link-log">Bạn đã là thành viên của <san class="textlogo">dienmay.com</san>? <a class="btnlogincart" href="javascript:;">Đăng nhập</a></span>
            <div class="pouplogin" style="display: none">
                <p class="loginresult"></p>
                <input id="fuser" name="fuser" value="" type="text" placeholder="Email hoặc SĐT">
                <input id="fpassword" name="fpassword" value="" type="password" placeholder="Mật khẩu">
                <input onclick="ajaxcartlogin();" class="button" id="btncartlogin" name="btncartlogin" value="Đăng nhập" type="button">
            </div>
        <?php }?>

        <label>Họ và tên </label>
        <input id="ffullname"  name="ffullname" value="<?php echo $_smarty_tpl->getVariable('formData')->value['ffullname'];?>
" type="text" placeholder="Họ tên của bạn để in hóa đơn">
        <label>Email :</label>
        <input id="femail" name="femail" value="<?php echo $_smarty_tpl->getVariable('formData')->value['femail'];?>
" type="text" placeholder="Email của bạn (để nhận thông tin về đơn hàng)">
        <label>Số điện thoại </label>
        <input id="fphonenumber" name="fphonenumber" value="<?php echo $_smarty_tpl->getVariable('formData')->value['fphonenumber'];?>
" type="text" placeholder="SĐT của bạn (để dienmay.com liên lạc)">
        <label>Tỉnh/Thành và Quận/Huyện</label>
        <select name="myregion" id="fcity" class="province">
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
        <select id="fdistrict" name="fdistrict" class="province">
          <option value="">---Quận/Huyện---</option>
        </select>
        <label>Địa chỉ </label>
        <textarea rows="3" id="faddress"  name="faddress" placeholder="Số nhà, đường, phường, xã"><?php echo $_smarty_tpl->getVariable('formData')->value['faddress'];?>
</textarea>
        <?php if ($_smarty_tpl->getVariable('registry')->value->me->id<=0){?>
        <div class="add-log">
          <label><input name="fregister" class="check-log" value="1" type="checkbox">
          Đăng ký làm thành viên của <san class="textlogo">dienmay.com</san> </label></div>
         <?php }?>
      </div>
    </div>
    <div class="payment-way">
      <h3>Hình thức thanh toán</h3>
      <ul>
        <li>
          <label>
          <input class="radiopm" name="fpaymentmethod" value="121" checked="checked" type="radio">
          <div class="pm-txt"> <i class="ic-delivery"></i>
            <h5> <a> Thanh toán khi nhận hàng COD</a></h5>
            <span>Bạn sẽ thanh toán tiền cho nhân viên giao hàng của <san class="textlogo">dienmay.com</san>, sau khi nhận và kiểm tra hàng hóa</span> </div>
          </label>
        </li>
<!--        <li>-->
<!--          <label>-->
<!--          <input class="radiopm" value="1" type="radio">-->
<!--          <div class="pm-txt"> <i class="ic-card"></i>-->
<!--            <h5> <a href="#"> Thanh toán bằng thẻ ATM nội địa</a></h5>-->
<!--            <span>Thanh toán trực tiếp bằng thẻ ATM của các ngân hàng trong nước.<br>-->
<!--            <em>Lưu ý:</em> Bạn phải đăng ký Internet Banking mới sử dụng được dịch vụ này</span> </div>-->
<!--          </label>-->
<!--        </li>-->
<!--        <li>-->
<!--          <label>-->
<!--          <input class="radiopm" value="1" type="radio">-->
<!--          <div class="pm-txt"> <i class="ic-card2"></i>-->
<!--            <h5><a href="#"> Thanh toán bằng thẻ quốc tế</a></h5>-->
<!--            <span>Thanh toán trực tiếp bằng thẻ ghi nợ quốc tế <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/visa.png"> <img src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
images/site/mastercard.png"></span>-->
<!--            <p> </p>-->
<!--          </div>-->
<!--          </label>-->
<!--        </li>-->
        <li>
          <label>
          <input class="radiopm" name="fpaymentmethod" value="144" type="radio">
          <div class="pm-txt"> <i class="ic-bank"></i>
            <h5><a> Chuyển khoản ngân hàng</a></h5>
            <span>Bạn sẽ chuyển khoản cho <san class="textlogo">dienmay.com</san> qua tài khoản <br>
            Công ty cổ phần Thế Giới Điện Tử<br>
            STK: <strong>0441000614689</strong><br>
            Tại Ngân hàng Vietcombank, chi nhánh Tân Bình, TP. HCM</span> </div>
          </label>
        </li>
      </ul>
    </div>
    <div class="payment-confirm">
      <h3>Xác nhận đơn hàng</h3>
      <div class="cart-bg">
      <?php if (!empty($_smarty_tpl->getVariable('cartItems',null,true,false)->value)){?>
         <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('cartItems')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
        <div class="r-row">
        <div class="clearcart"><a title="Xóa" href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
cart/checkout/?deleteid=<?php echo $_smarty_tpl->getVariable('item')->value->product->id;?>
">x</a></div>
          <div class="tt-pro"><a href="<?php echo $_smarty_tpl->getVariable('item')->value->product->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('item')->value->product->name;?>
"><?php echo $_smarty_tpl->getVariable('item')->value->product->name;?>
</a></div>
          <div class="image-co"><a href="<?php echo $_smarty_tpl->getVariable('item')->value->product->getProductPath();?>
" title="<?php echo $_smarty_tpl->getVariable('item')->value->product->name;?>
"><img width="90" src="<?php echo $_smarty_tpl->getVariable('item')->value->product->getSmallImage();?>
" alt="<?php echo $_smarty_tpl->getVariable('item')->value->product->name;?>
" title="<?php echo $_smarty_tpl->getVariable('item')->value->product->name;?>
" ></a></div>
          <div class="txt-info" id="<?php echo $_smarty_tpl->getVariable('item')->value->product->id;?>
">
            <p class="number">Số lượng:
             <select class="inputnumber cartquantity" name="fquantity[<?php echo $_smarty_tpl->getVariable('item')->value->product->id;?>
]">
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['name'] = 'loopquantity';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loopquantity']['total']);
?>
                <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loopquantity']['index'];?>
"<?php if ($_smarty_tpl->getVariable('item')->value->quantity==$_smarty_tpl->getVariable('smarty')->value['section']['loopquantity']['index']){?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['loopquantity']['index'];?>
</option>
                <?php endfor; endif; ?>
             </select><?php if ($_smarty_tpl->getVariable('item')->value->pricesell>0){?>
                            &#215; <?php echo number_format($_smarty_tpl->getVariable('item')->value->pricesell);?>
đ
                        <?php }?>
                        <?php if (!empty($_smarty_tpl->getVariable('item',null,true,false)->value->firstprice)){?>
                        <span class="price-cart-1">
                            <?php if ($_smarty_tpl->getVariable('item')->value->firstprice>0){?>
                                (<?php echo number_format($_smarty_tpl->getVariable('item')->value->firstprice);?>
đ)
                            <?php }?>
                             </span>
                        <?php }?>


                 </p>

            <p style="margin-top: 5px">Thành tiền: <span class="red"><?php ob_start();?><?php echo smarty_function_math(array('equation'=>"x*y",'x'=>$_smarty_tpl->getVariable('item')->value->pricesell,'y'=>$_smarty_tpl->getVariable('item')->value->quantity,'format'=>"%.0f"),$_smarty_tpl);?>
<?php echo number_format(ob_get_clean())?>đ</span></p>
          </div>
          <?php if (!empty($_smarty_tpl->getVariable('item',null,true,false)->value->promotion)){?>
            <?php $_smarty_tpl->tpl_vars["promotioninfo"] = new Smarty_variable($_smarty_tpl->getVariable('item')->value->promotion, null, null);?>
        <?php }else{ ?>
            <?php $_smarty_tpl->tpl_vars["promotioninfo"] = new Smarty_variable($_smarty_tpl->getVariable('item')->value->product->promotionPrice(), null, null);?>
        <?php }?>

        <?php if (!empty($_smarty_tpl->getVariable('promotioninfo',null,true,false)->value)){?>
          <div class="Promote">
            <h6>Khuyến mãi</h6>
            <span><?php if (!empty($_smarty_tpl->getVariable('item',null,true,false)->value->promotion)){?><?php echo $_smarty_tpl->getVariable('promotioninfo')->value->description;?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('promotioninfo')->value['promodescription'];?>
<?php }?></span>
          </div>

        <?php }?>
        </div>

         <input type="hidden" name="promotionid[<?php echo $_smarty_tpl->getVariable('item')->value->product->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('item')->value->options['promotionid'];?>
" />
                        <input type="hidden" name="regionid[<?php echo $_smarty_tpl->getVariable('item')->value->product->id;?>
]" value="<?php echo $_smarty_tpl->getVariable('item')->value->options['regionid'];?>
" />
            <?php }} ?>


      </div>
      <div class="r-row" style="clear: both;" id="totalfeebox"><br />
        <h4 style="float: left;">THÀNH TIỀN:</h4>
        <span class="red" id="totalfee" style="float: right;"><?php echo number_format($_smarty_tpl->getVariable('cartpricetotal')->value);?>
đ</span>
      </div>
      <div class="r-row" id="shippingfeebox" style="clear: both;display: none;">
        <h4 style="float: left;">PHÍ VẬN CHUYỂN:</h4>
        <span class="red" id="shippingfee" style="float: right;">0đ</span>
      </div>
      <div class="r-row" id="newmessageshippingfeebox" style="clear: both;display: none;">
        <h4 style="float: left;" id="newmessagefee"></h4>
        <span class="red" id="newmessageshippingfee" style="float: right;">0đ</span>
      </div>
      <div class="Total-co" style="margin-right: 10px;"> Tổng cộng: <span class="red1" id="totalfinalfees"><?php echo number_format($_smarty_tpl->getVariable('cartpricetotal')->value);?>
đ</span> </div>
      <p class="note"><span class="notespan" style="display:none"><em>Lưu ý:</em> Giá trị đơn hàng trên chưa bao gồm chi phí giao hàng (nếu có). Nhân viên chăm sóc khách hàng của <span class="textlogo">dienmay.com</span> sẽ liên hệ với bạn và thông báo chi phí cụ thể. Rất xin lỗi bạn vì sự bất tiện này.</span></p>
      <?php if (!empty($_smarty_tpl->getVariable('cartItems',null,true,false)->value)){?><input onclick="return checkOutValidation()" name="btncheckout" id="btncheckout" class="btn-pay submitform" value="Đặt mua" type="submit"><?php }?>
      <?php }else{ ?>
      <p class="cartempty">Giỏ hàng hiện tại đang trống. Hãy tiếp tục mua sắm !</p>

      <?php }?>
      <div class="cont-shopping"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
">Tiếp tục mua hàng</a></div>
    </div>

  </div>
</div>
  </form>
<div class="clear"></div>
<br style="clear: both"/><br style="clear: both"/>
<div id="footer" style="border-top: 1px solid #CCCCCC; padding-top: 20px">
  <div class="colfoot-1"><span>Cam kết tận tâm</span>
    <ul>
      <li><i class="icon-market"></i><div class="descam">Sản phẩm, hàng hóa chính hãng, chất lượng.</div></li>
      <li><i class="icon-warranty"></i><div class="descam">10 ngày bảo hành đổi trả miễn phí</div></li>
      <li><i class="icon-service"></i><div class="descam">Dịch vụ chăm sóc khách hàng tốt nhất</div></li>
    </ul>
  </div>
  <div class="colfoot-2"> <span>Hỗ trợ khách hàng</span>
        <ul>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
huong-dan-mua-online" title="Hướng dẫn mua online">Hướng dẫn mua online</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
bao-hanh-doi-tra" title="Bảo hành, đổi trả">Bảo hành, đổi trả</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
account/checksaleorder" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
vip" title="Thành viên VIP">Thành viên VIP</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
        </ul>
  </div>
  <div class="colfoot-3"> <span>Thông tin công ty</span>
    <ul>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu về dienmay.com</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
tuyendung" title="Tuyển dụng" >Tuyển dụng</a></li>
    </ul>
    <a target="_blank" href="https://www.facebook.com/dienmaycom"><i class="icon-dmface"></i></a>
    <a target="_blank" href="https://www.google.com/+dienmay"><i class="icon-dmggl"></i></a>

  </div>
    <div class="colfoot-4">
        <span>Tổng đài trợ giúp</span>
        <p><i class="icon-call"></i><span class="fontcall">1900 1883</span><span class="timeser">(từ 8h00 đến 20h00 tất cả các ngày)</span></p>
        <p><i class="icon-latter"></i><span class="email2">cskh@dienmay.com</span></p>
        <p><span class="help">Giải quyết khiếu nại:</span><span class="helpcall"> 1900 1883</span></p>
    </div>
</div>

<div id="copyright">
    <p>&copy; 2013 Công ty Cổ phần Thế Giới Điện Tử - ĐCĐK: 130 Trần Quang Khải, P. Tân Định, Q.1, TP.HCM. GPĐKKD số: 0310471746 do Sở KHĐT Tp.HCM cấp ngày 3/11/2010.</p>
    <p>Email: lienhe@dienmay.com. Điện thoại: 08 38 125 960. Fax: 08 38 125 961.</p>
    <p>Giấy phép thiết lập trang TTĐT số 22/GP-ICP-STTTT, cấp ngày 20/03/2012.</p>
    <p><a title="dienmay.com" href="http://dienmay.com">http://dienmay.com</a></p>
    <div class="desktop"><a href="javascript:void(0)" class="forcedesktop">Xem phiên bản mobile</a></div>
</div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/min/?g=js&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['jsversion'];?>
"></script>
<!--<script  type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=js&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['jsversion'];?>
"></script>-->
 <script type="text/javascript">
 var mydistrict = <?php echo $_smarty_tpl->getVariable('me')->value->district;?>
;
 </script>

    <script type="text/javascript">
        $( ".btnlogincart" ).click(function() {
          $( ".pouplogin" ).toggle();
        });
        $( "#ffullname" ).click(function() {
            $( ".pouplogin" ).hide();
        });
        $( "#femail" ).click(function() {
            $( ".pouplogin" ).hide();
        });
        $( "#fphonenumber" ).click(function() {
            $( ".pouplogin" ).hide();
        });
        $( "#faddress" ).click(function() {
            $( ".pouplogin" ).hide();
        });
      var city     = $('#fcity').val();
      if(city != '')
      {
          changegetdistrict();
      }
      if (city != '' && $('#fdistrict').val()!='') {
        feedistrict($('#fdistrict').val());
      }

        function checkOutValidation()
        {
            $( ".pouplogin" ).hide();
            var pass = true;
            var fullname = $('#ffullname').val().trim();
            var email = $('#femail').val().trim();
            var phone = $('#fphonenumber').val().trim();
            var address = $('#faddress').val().trim();
            var city     = $('#fcity').val();
            var district     = $('#fdistrict').val();
            fdistrict
            if(fullname == '')
            {
                pass = false;
                $('#ffullname').css('border','solid 1px red');
            }else{
                $('#ffullname').css('border','solid 1px #ccc');
            }
            if(email == '')
            {
                pass = false;
                $('#femail').css('border','solid 1px red');
            }else{;
                $('#femail').css('border','solid 1px #ccc');
                }
            if(phone == '')
            {
                pass = false;
                $('#fphonenumber').css('border','solid 1px red');
            }else{

                $('#fphonenumber').css('border','solid 1px #ccc');
                }

            if(city == '')
            {
                pass = false;
                $('#fcity').css('border','solid 1px red');
            }else{

                $('#fcity').css('border','solid 1px #ccc');
                }

            if(district == '')
            {
                pass = false;
                $('#fdistrict').css('border','solid 1px red');
            }else{
                $('#fdistrict').css('border','solid 1px #ccc');
            }

            if(address == '')
            {
                 pass = false;
                $('#faddress').css('border','solid 1px red');
            }else{
                $('#faddress').css('border','solid 1px #ccc');
            }
            //check gift
            var isshowgift = <?php echo $_smarty_tpl->getVariable('isshowgift')->value;?>
;
            if(pass == true){
              if ($('.giftProduct').length > 0 && isshowgift == 1) {
                 $.post(rooturl+'cart/checkoutajax', $("#checkoutform").serialize(),function(data){
                     if (data != '') {
                        Shadowbox.open({
                            content:    rooturl + 'site/cart/showgift/invoiceid/'+data,
                            player:     "iframe",
                            options: {
                              modal:   true,
                              onClose: function ()
                              {
                                  var priceorder = $('#priceorder').val();
                                   _gaq.push(['_trackEvent', 'GiftLucky', 'Close', priceorder]);
                                  var invoice = data;
                                  $.ajax({
                                    url: rooturl +'site/cart/updatecheckoutgift',
                                    type: 'POST',
                                    dataType: 'html',
                                    data: {invoicedid: invoice},
                                    success: function(data)
                                    {
                                        parent.location.href= rooturl+'site/cart/success?o='+invoice;
                                    }
                                  });
                              }
                            },
                            height:     400,
                            width:      600,
                        });
                     }
                  });
                 pass = false;
              }
              else
              {
                pass =  true;
              }
            }
            return pass;
        }

        function changegetdistrict(){
            var city     = $('#fcity').val();
            var url      = "/register/indexajax?city="+city + "&district=" + mydistrict;
            $.ajax({
                type : "POST",
                data : {action:"getdistrict"},
                url : url,
                dataType: "html",
                success: function(data){
                    $("#fdistrict").html(data);
                    var fistoption = $("#fdistrict option").first();
                    feedistrict(fistoption.val());
                    fistoption.attr('selected', 'selected');
                }
            });

            /*if(city == 3 || city==82 || city==102 || city ==109 || city==146 || city==144 || city==154 || city==6 || city==8){
                    $(".notespan").hide();
              } else{$(".notespan").show();}*/
        }

        $("#fcity").change(function(){
            changegetdistrict();
        });

        $("#fdistrict").live('change', function(){
            feedistrict($(this).val());
        });

        function feedistrict(curval)
        {
            $('#shippingfeebox').hide();
            var allpids = '';
            var city = parseInt($('#fcity').val());
            if ($('.txt-info').length > 0) {
                $('.txt-info').each(function(ix){
                    if (ix != 0) allpids += ',' + $(this).attr('id');
                    else allpids += $(this).attr('id');
                });
                $.post(rooturl + 'cart/shippingfeeajax', $('#checkoutform').serialize(), function(data){//{rid: city,rsid: curval,pids: allpids}
                    if (data) {
                        if (parseInt(data.nosupport) == 1) {
                            if(city == 3 || city==82 || city==102 || city ==109 || city==146 || city==144 || city==154 || city==6 || city==8) {
                                $(".notespan").hide();
                            } else {$(".notespan").show();}
                            $('#shippingfeebox').hide();
                            $('#newmessageshippingfeebox').hide();
                            $('#totalfinalfees').html($('#totalfee').html());
                        } else if (parseInt(data.nosupport) == 2) {
                            var feee = parseInt(data.fee);
                            if (feee > 0) {
                                /*var totalfee = parseInt($('#totalfee').html().replace(/\,+/g, ''));
                                var finalfee = feee + totalfee;
                                $('#shippingfee').html(formatNumber(feee.toString()) + 'đ');
                                $('#totalfinalfees').html(formatNumber(finalfee.toString()) + 'đ');
                                */
                                if (data.newfeemessage != '') {
                                  $('#shippingfee').html('Miễn phí');
                                  $('#newmessageshippingfeebox').show();
                                  $('#newmessagefee').html(data.newfeemessage);
                                  $('#newmessageshippingfee').html(data.fee + 'đ');
                                  $('#shippingfeebox').css('border', 'none');

                                  $('#totalfinalfees').html(data.totalfinalprice + 'đ');
                                  $('#totalfee').html(data.totalprices + 'đ');
                                  $(".notespan").hide();
                                  $('#shippingfeebox').fadeIn(1000);
                                  $('#totalfeebox').css('border', 'none');
                                } else {
                                  $('#shippingfee').html(data.fee + 'đ');
                                  $('#shippingfeebox').css('border-bottom', '1px solid #e5e5e5');//
                                  $('#totalfinalfees').html(data.totalfinalprice + 'đ');
                                  $('#totalfee').html(data.totalprices + 'đ');
                                  $(".notespan").hide();
                                  $('#shippingfeebox').fadeIn(1000);
                                  $('#totalfeebox').css('border', 'none');
                                }
                            } else {
                              $('#shippingfeebox').hide();
                              $('#newmessageshippingfeebox').hide();
                              $('#totalfeebox').css('border', 'none');
                              $('#shippingfee').html('Miễn phí');
                              $('#shippingfeebox').fadeIn(1000);
                            }
                        }
                        else {
                            $('#shippingfeebox').hide();
                            $('#newmessageshippingfeebox').hide();

                            if(city == 3 || city==82 || city==102 || city ==109 || city==146 || city==144 || city==154 || city==6 || city==8) {
                                $(".notespan").hide();
                            } else {$(".notespan").show();}
                            $('#totalfinalfees').html($('#totalfee').html());
                            $('#shippingfee').html('Miễn phí');
                            $('#shippingfeebox').fadeIn(1000);
                            $('#totalfeebox').css('border', 'none');
                        }
                    }
                  else {
                    $('#totalfinalfees').html($('#totalfee').html());
                    $('#newmessageshippingfeebox').hide();
                    $('#shippingfee').html('Miễn phí');
                    $('#shippingfeebox').fadeIn(1000);
                    $('#totalfeebox').css('border', 'none');
                  }
                }, 'json');
            }
        }

        function formatNumber(str)
        {
            var returnstring = '';
            var i = str.length - 1;
            var chk = 0;
            for (var j = i; j >=0; j--) {
                returnstring = str.charAt(j) + returnstring;
                chk++;
                if (chk == 3 && j >0) {
                    returnstring = ',' + returnstring;
                    chk = 0;
                }
            }
            return returnstring;
        }

    </script>

<?php $_template = new Smarty_Internal_Template("googleanalytic.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template("websocket_external.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('smartyControllerGroupContainer')->value)."../analytic.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</body>
</html>
