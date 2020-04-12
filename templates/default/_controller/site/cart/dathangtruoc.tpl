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
<form method="post" action="" id="checkoutform" class="formcheckout">
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
       {if !empty($myProduct)}
        <div class="r-row">
            <!--<div class="clearcart"><a title="Xóa" href="{$conf.rooturl}cart/checkout/?deleteid={$item->product->id}">x</a></div> -->
              <div class="tt-pro"><a href="{$myProduct->getProductPath()}" title="{$myProduct->name}">{$myProduct->name}</a></div>
              <div class="image-co"><a href="{$myProduct->getProductPath()}" title="{$myProduct->name}"><img width="90" src="{$myProduct->getSmallImage()}" alt="{$myProduct->name}" title="{$myProduct->name}" ></a></div>
              <div class="txt-info">
                <p style="margin-top: 5px">Giá đặt trước dienmay.com:</p> <div class="pricedienmay loadprice lp{$myProduct->id}{$myProduct->barcode|trim|substr:-5}" rel="{$myProduct->id}{$myProduct->barcode|trim|substr:-5}" style="margin-left:0"><span class="" style="margin-top: 15px;display: block;">{if $myProduct->prepaidprice > 1000}{$myProduct->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div>
                <div class="clear"></div>
              </div>          
            {if !empty($myPromotion)}
              <div class="Promote">
                <h6>Khuyến mãi</h6>
                <span>
                    <div class="promotdes">
                        {if $myPromotion->descriptionclone != ""}
                            {$myPromotion->descriptionclone}
                        {else}
                            {$myPromotion->description}
                        {/if}
                    </div>
                </span> 
              </div>
            {else}
              {if !empty($myProduct->prepaidpromotion)}
                 <div class="Promote">
                <h6>Khuyến mãi</h6>
                <span>
                    <div class="promotdes">
                {$myProduct->prepaidpromotion}
                  </div>
                </span>
                </div>
              {/if}
            {/if}
        </div> 
      </div>
      <!-- <div class="Total-co"> Tổng cộng: <span class="red1">{*$cartpricetotal|number_format*}đ</span> </div> -->
      <p class="note">
          {if $myProduct->prepaiddepositrequire > 0}
              <strong>Lưu ý:</strong> {$myProduct->name} là sản phẩm rất hot do đó bạn cần đặt trước <strong style="color:red">{$myProduct->prepaiddepositrequire|number_format}đ</strong> để đảm bảo hàng sẽ được chuyển đến cho bạn đúng ngày. Nhân viên CSKH của điện máy sẽ liên hệ với bạn để xác nhận thông tin
              <input type="hidden" value="Sản phẩm đặt trước , cần đặt cọc: {$myProduct->prepaiddepositrequire|number_format} đ" name="fnotedattruoc" />
          {/if}
      </p>
      {if $displaybutton == true}
        <input onclick="return checkOutValidation()" name="btncheckout" id="btncheckout" class="btn-pay submitform" value="Đặt mua" type="submit">
      {else}
        <input name="" onclick="return false;" id="btncheckout" class="btn-pay submitform" value="Đã đủ số lượng đặt trước" type="submit" style="background: #cacaca;font: bold 11px arial;padding: 15px 50px;">
         <div class="cont-shopping"><a href="{$conf.rooturl}">Tiếp tục mua hàng</a></div>
      {/if}
      {/if}
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
    <p><a title="dienmay.com" href="https://ecommerce.kubil.app">https://ecommerce.kubil.app</a></p>
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
                }
            });

            if(city == 3 || city==82 || city==102 || city ==109 || city==146 || city==144 || city==154 || city==6 || city==8){
                $(".notespan").hide();
            }else{$(".notespan").show();}
        }
        
        $("#fcity").change(function(){
            changegetdistrict();
        });

    </script>
{/literal}
{include file="googleanalytic.tpl"}
{include file="websocket_external.tpl"}
{include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>
