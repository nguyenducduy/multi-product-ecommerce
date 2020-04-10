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
<form method="post" id="checkoutform" class="formcheckout">
{if !empty($giftProduct)}
  <div class="giftProduct"></div>
  <input type='hidden' value="{$isshowgift}" name="hiddengift" />
  <input type="hidden" value="{$giftOrder->pricefrom}-{$giftOrder->priceto}" id="priceorder"/>
{/if}
<div id="checkout-wrap">
  <div id="header-checkout">
        <div class="logo-co"> <a href="{$conf.rooturl}"> <img src="{$currentTemplate}images/site/logo-dien-may.png"></a> </div>
    <div class="process-co">
      <ul class="step">
        <li class="step_done"> <span>Chọn hàng</span></li>
        <li class="step_done"> <span>Nhập thông tin thanh toán</span></li>
        <li class="step_todo"> <span>Xác nhận đơn hàng</span></li>
      </ul>
    </div>
  </div>

  <!-- Check out -->
   {include file="notify.tpl" notifyError=$error notifySuccess=$success}
  <div id="summary-checkout">
    <div class="payment-info">
      <h3>Thông tin thanh toán</h3>
      <div class="form_content">
        <h4>Địa chỉ nhận hàng</h4>
        {if $registry->me->id <= 0}
            <span class="link-log">Bạn đã là thành viên của <san class="textlogo">dienmay.com</san>? <a class="btnlogincart" href="javascript:;">Đăng nhập</a></span>
            <div class="pouplogin" style="display: none">
                <p class="loginresult"></p>
                <input id="fuser" name="fuser" value="" type="text" placeholder="Email hoặc SĐT">
                <input id="fpassword" name="fpassword" value="" type="password" placeholder="Mật khẩu">
                <input onclick="ajaxcartlogin();" class="button" id="btncartlogin" name="btncartlogin" value="Đăng nhập" type="button">
            </div>
        {/if}

        <label>Họ và tên </label>
        <input id="ffullname"  name="ffullname" value="{$formData.ffullname}" type="text" placeholder="Họ tên của bạn để in hóa đơn">
        <label>Email :</label>
        <input id="femail" name="femail" value="{$formData.femail}" type="text" placeholder="Email của bạn (để nhận thông tin về đơn hàng)">
        <label>Số điện thoại </label>
        <input id="fphonenumber" name="fphonenumber" value="{$formData.fphonenumber}" type="text" placeholder="SĐT của bạn (để dienmay.com liên lạc)">
        <label>Tỉnh/Thành và Quận/Huyện</label>
        <select name="myregion" id="fcity" class="province">
          <option value="">---Tỉnh/Thành---</option>
            {foreach item=region key=regionid from=$setting.region}
                <option value="{$regionid}" {if {$regionid}=={$me->city}}selected{/if} >{$region}</option>
            {/foreach}
        </select>
        <select id="fdistrict" name="fdistrict" class="province">
          <option value="">---Quận/Huyện---</option>
        </select>
        <label>Địa chỉ </label>
        <textarea rows="3" id="faddress"  name="faddress" placeholder="Số nhà, đường, phường, xã">{$formData.faddress}</textarea>
        {if $registry->me->id <= 0}
        <div class="add-log">
          <label><input name="fregister" class="check-log" value="1" type="checkbox">
          Đăng ký làm thành viên của <san class="textlogo">dienmay.com</san> </label></div>
         {/if}
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
<!--            <span>Thanh toán trực tiếp bằng thẻ ghi nợ quốc tế <img src="{$currentTemplate}images/site/visa.png"> <img src="{$currentTemplate}images/site/mastercard.png"></span>-->
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
      {if !empty($cartItems)}
         {foreach from=$cartItems item=item}
        <div class="r-row">
        <div class="clearcart"><a title="Xóa" href="{$conf.rooturl}cart/checkout/?deleteid={$item->product->id}">x</a></div>
          <div class="tt-pro"><a href="{$item->product->getProductPath()}" title="{$item->product->name}">{$item->product->name}</a></div>
          <div class="image-co"><a href="{$item->product->getProductPath()}" title="{$item->product->name}"><img width="90" src="{$item->product->getSmallImage()}" alt="{$item->product->name}" title="{$item->product->name}" ></a></div>
          <div class="txt-info" id="{$item->product->id}">
            <p class="number">Số lượng:
             <select class="inputnumber cartquantity" name="fquantity[{$item->product->id}]">
                {section name=loopquantity start=1 loop=6 step=1}
                <option value="{$smarty.section.loopquantity.index}"{if $item->quantity == $smarty.section.loopquantity.index} selected="selected"{/if}>{$smarty.section.loopquantity.index}</option>
                {/section}
             </select>{if $item->pricesell > 0}
                            &#215; {$item->pricesell|number_format}đ
                        {/if}
                        {if !empty($item->firstprice)}
                        <span class="price-cart-1">
                            {if $item->firstprice > 0}
                                ({$item->firstprice|number_format}đ)
                            {/if}
                             </span>
                        {/if}


                 </p>

            <p style="margin-top: 5px">Thành tiền: <span class="red">{math|number_format equation="x*y" x=$item->pricesell y=$item->quantity format="%.0f"}đ</span></p>
          </div>
          {if !empty($item->promotion)}
            {assign var="promotioninfo" value=$item->promotion}
        {else}
            {assign var="promotioninfo" value=$item->product->promotionPrice()}
        {/if}

        {if !empty($promotioninfo)}
          <div class="Promote">
            <h6>Khuyến mãi</h6>
            <span>{if !empty($item->promotion)}{$promotioninfo->description}{else}{$promotioninfo.promodescription}{/if}</span>
          </div>

        {/if}
        </div>

         <input type="hidden" name="promotionid[{$item->product->id}]" value="{$item->options['promotionid']}" />
                        <input type="hidden" name="regionid[{$item->product->id}]" value="{$item->options['regionid']}" />
            {/foreach}


      </div>
      <div class="r-row" style="clear: both;" id="totalfeebox"><br />
        <h4 style="float: left;">THÀNH TIỀN:</h4>
        <span class="red" id="totalfee" style="float: right;">{$cartpricetotal|number_format}đ</span>
      </div>
      <div class="r-row" id="shippingfeebox" style="clear: both;display: none;">
        <h4 style="float: left;">PHÍ VẬN CHUYỂN:</h4>
        <span class="red" id="shippingfee" style="float: right;">0đ</span>
      </div>
      <div class="r-row" id="newmessageshippingfeebox" style="clear: both;display: none;">
        <h4 style="float: left;" id="newmessagefee"></h4>
        <span class="red" id="newmessageshippingfee" style="float: right;">0đ</span>
      </div>
      <div class="Total-co" style="margin-right: 10px;"> Tổng cộng: <span class="red1" id="totalfinalfees">{$cartpricetotal|number_format}đ</span> </div>
      <p class="note"><span class="notespan" style="display:none"><em>Lưu ý:</em> Giá trị đơn hàng trên chưa bao gồm chi phí giao hàng (nếu có). Nhân viên chăm sóc khách hàng của <span class="textlogo">dienmay.com</span> sẽ liên hệ với bạn và thông báo chi phí cụ thể. Rất xin lỗi bạn vì sự bất tiện này.</span></p>
      {if !empty($cartItems)}<input onclick="return checkOutValidation()" name="btncheckout" id="btncheckout" class="btn-pay submitform" value="Đặt mua" type="submit">{/if}
      {else}
      <p class="cartempty">Giỏ hàng hiện tại đang trống. Hãy tiếp tục mua sắm !</p>

      {/if}
      <div class="cont-shopping"><a href="{$conf.rooturl}">Tiếp tục mua hàng</a></div>
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
<script type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>
<!--<script  type="text/javascript" src="{$currentTemplate}min/?g=js&ver={$setting.site.jsversion}"></script>-->
 <script type="text/javascript">
 var mydistrict = {$me->district};
 </script>
{literal}
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
            var isshowgift = {/literal}{$isshowgift}{literal};
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
{/literal}
{include file="googleanalytic.tpl"}
{include file="websocket_external.tpl"}
{include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>