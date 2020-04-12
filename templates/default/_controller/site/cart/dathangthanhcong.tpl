<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $pageTitle != ''}{$pageTitle} - {$setting.site.heading}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="keywords" content="{$pageKeyword|default:$setting.site.defaultPageKeyword|escapequote}" />
<meta name="description" content="{$pageDescription|default:$setting.site.defaultPageDescription|escapequote}" />
<meta name="robots" content="{if !empty($pageMetarobots)}{$pageMetarobots}{else}index, follow{/if}"/>
{if $discount ==1}
<meta property="og:image" content="{$currentTemplate}images/discountproduct/imgfbbacktoschool.png"/>
{/if}
{if !empty($pageCanonical)}
<link rel="canonical" href="{$pageCanonical}"/>
{/if}
<link type="text/css" rel="stylesheet" href="{$currentTemplate}/min/?g=css&ver={$setting.site.cssversion}" media="screen" />
<!--  <link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=css&ver={$setting.site.cssversion}" media="screen" />-->
<script src="{$currentTemplate}/js/jquery.js"></script>
<script  type="text/javascript" src="{$currentTemplate}js/site/customsite.js"></script>

<script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_profile = "{$conf.rooturl_profile}";
		var pathImage360 = "{$pathimage360}";
		var numImage360 = "{$numimage360}";
		var imageDir = "{$imageDir}";
		var ispriceajax = {$setting.site.isajaxprice};
</script>
</head>

<body>
<!-- Đặt hàng thành công -->
<div id="checkout-wrap">
  <div id="header-checkout">
    <div class="logo-co"> <a href="{$conf.rooturl}"> <img src="{$currentTemplate}images/site/logo-dien-may.png"></a> </div>
    <div class="process-co">
      <ul class="step">
        <li class="step_done"> <span>Chọn hàng</span></li>
        <li class="step_done"> <span>Nhập thông tin thanh toán</span></li>
        <li class="step_done"> <span>Xác nhận đơn hàng</span></li>
      </ul>
    </div>
  </div>
  
  <!-- Confirm -->
  
  <div id="summary-checkout">
    <div class="img-tks"><img src="{$currentTemplate}images/site/confirm.jpg"></div>
    <div class="info-confirm">
      <p> Thân chào, <span class="name-customer">{$fullname}</span></p>
      <span> Cám ơn bạn đã tin tưởng và đặt hàng tại <span class="textlogo">dienmay.com</span>. Chúng tôi đã nhận được đơn hàng của bạn với các thông tin như sau:</span>
      <div class="inf-bg">
        <div class="ctrl-label">
          <label class="label-t">Mã đơn hàng:</label>
          <label class="labelCode">{$invoicedid|strtoupper}</label>
        </div>
        <div class="ctrl-label">
          <label  class="label-t">Địa chỉ nhận hàng:</label>
          <label class="labelTxt">{$address}{if !empty($districname)}, {$districname}{/if}{if !empty($districname)}, {$cityname}{/if}</label>
        </div>
        <div class="ctrl-label">
          <label  class="label-t">Email:</label>
          <label class="labelTxt">{$email}</label>
        </div>
        <div class="ctrl-label">
          <label  class="label-t">Điện thoại:</label>
          <label class="labelTxt">{$phonenumberuser}</label>
        </div>
      </div>
      {if !empty($productGift) && $productGift->id > 0}
        <div class="gift-order">
            <div class="red-tt12-title">Hộp quà may mắn</div>
            <div class="gift-order-box">
              <p>
                Chúc mừng bạn nhận được món quà: <b>{$productGift->name}</b> <br/>
                Quà tặng sẽ được áp dụng kèm với đơn hàng
              </p>
              <img src="{$productGift->getSmallImage()}" />
            </div>
        </div>
      {/if}
      <div> <span class="textlogo">Dienmay.com</span> cũng đã gửi email và tin nhắn xác nhận đơn hàng cho bạn. Đơn hàng của bạn đang được xử lý và sẽ được gửi đến tận nơi cho bạn trong thời gian sớm nhất</div>
      <div> Nếu có thắc mắc xin liên hệ bộ phận CSKH của dienmay.com hotline <span class="red1">1900 1883</span></div>
      <div class="signature"> <span> Trân trọng</span> <a href="{$conf.rooturl}"><img width="100" src="{$currentTemplate}images/site/logo-dien-may.png"></a> </div>
      {if $register == 1}
      <div class="box-register">
	      <div style="padding-top:30px" class="clear"><em>Lưu ý: </em>Bạn vừa đăng ký làm thành viên của <span class="textlogo">dienmay.com</span>. Vui lòng điền mật khẩu vào ô bên dưới để hoàn tất việc tào tài khoản cho email <span class="blue">{$email}</span></div>
	      <div class="cartregister form_content">
	      <form action="">
	      	<input id="fpassword" class="inputcartregister" name="fpassword" value="" type="password" placeholder="Nhập mật khẩu"/>
	      	<input onclick="ajaxcartregister();" name="cartregister" id="cartregister" class="btn-cartregister submitform" value="Tạo tài khoản" type="button"/>
	      	<div class="notifycartregister"></div>
	      	<input id="ffullname" type="hidden" value="{$fullname}" />
	      	<input id="femail" type="hidden" value="{$email}" />
	      	<input id="fphone" type="hidden" value="{$phonenumberuser}" />
	      	<input id="faddress" type="hidden" value="{$address}" />
	      	<input id="fprovince" type="hidden" value="{$province}" />
	      	<input id="fdistrict" type="hidden" value="{$district}" />
	      	</form>
	      </div>
      </div>
      <div class="box-registedemail" style="padding-top:10px;display:none" class="clear">Email <span class="blue">{$email}</span> của bạn đã tồn tại trong hệ thống của dienmay.com. Bạn vui lòng <a href="{$conf.rooturl}login"><strong><span class="blue">Đăng nhập</span></strong></a> hoặc <a href="{$conf.rooturl}login"><strong><span class="blue">Lấy lại mật khẩu</span></strong></a></div>
      <div class="box-registedphone" style="padding-top:10px;display:none" class="clear">Số điện thoại <span class="blue">{$phonenumberuser}</span> của bạn đã tồn tại trong hệ thống của dienmay.com. Bạn vui lòng <a href="{$conf.rooturl}login"><strong><span class="blue">Đăng nhập</span></strong></a> hoặc <a href="{$conf.rooturl}login"><strong><span class="blue">Lấy lại mật khẩu</span></strong></a></div>
    {/if}
    </div>
  </div>
</div>
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
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}huong-dan-mua-online" title="Hướng dẫn mua online">Hướng dẫn mua online</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}bao-hanh-doi-tra" title="Bảo hành, đổi trả">Bảo hành, đổi trả</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}account/checksaleorder" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}vip" title="Thành viên VIP">Thành viên VIP</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
        </ul>
  </div>
  <div class="colfoot-3"> <span>Thông tin công ty</span>
    <ul>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu về dienmay.com</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}tuyendung" title="Tuyển dụng" >Tuyển dụng</a></li>
    </ul> 
    <a target="_blank" href=" "><i class="icon-dmface"></i></a> 
    <a target="_blank" href=" "><i class="icon-dmggl"></i></a> 
   
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
	<p><a title="dienmay.com" href="https://ecommerce.kubil.app">https://ecommerce.kubil.app</a></p>
	<div class="desktop"><a href="javascript:void(0)" class="forcedesktop">Xem phiên bản mobile</a></div>
</div>
{include file="googleanalytic.tpl"}
{include file="websocket_external.tpl"}
{include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>