<link href="{$currentTemplate}css/site/auction.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/jquery.min.js"></script>
<script type="text/javascript" src="{$currentTemplate}js/site/jquery.number.min.js"></script>

<style type="text/css">
  .clear{
    clear: both;
  }
  #sb-container #sb-nav-close{
    right: 20px;
  }
</style>
<div class="popup_auc_1">
	<div class="titpop">Đấu giá ngược <!-- <i class="closepop_auc"></i> --></div>
    <div class="cont_auc">
      {if $isshow == 1}
    	<span>Cảm ơn bạn đã tham gia chương trình.</span>
        <span>Vui lòng nhập thông tin để bắt đầu phiên đấu giá.</span>
      {/if}
        <div class="forminfo_auc"  {if $isshow == 0}style="margin-top:0"{/if}>
        	<form action="" method="post">
              {include file="notify.tpl" notifyError=$error notifySuccess=$success}
                {if $isshow == 1}
              <input type="hidden" name="ftoken" value="{$smarty.session.reverseauctionsAddToken}" />
           	  <input class="inpt" name="ffullname"  id="ffullname" type="text"  placeholder="Họ tên" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)"/>
              <label class="alt ffullname"></label>
              <div class="clear"></div>
              <input class="inpt" name="femail" type="text" id="femail" placeholder="Email" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)"/>
              <label class="alt femail"></label>
                <div class="clear"></div>
              <input class="inpt" name="fphone" type="text" id="fphonenumber"  placeholder="Điện thoại liên hệ" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)"/><label class="alt fphonenumber"></label>
                <div class="clear"></div>
                <label class="dgtext">Giá đấu:</label>
              <div class="clear"></div>
                <input class="inpt2" type="text" name="fprice" id="fprice" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)" />
                <label class="dgddd">đ</label>
              <div class="clear"></div>
                <label class="alt fprice"></label>
                <div class="clear"></div>
                <label><input name="fissubscribe" type="checkbox" checked="checked" value="1" /> Đăng ký nhận thông tin về các chương trình khuyến mãi khác của dienmay.com</label>
                <div class="clear"></div>
                <div class="clik_auc">
                  <input type="submit" value="Xác nhận" name='fsubmit' onclick="return checkOutValidation()">
                </div>
                {else}
                    <p style="line-height:22px">- Người thắng cuộc: 
      Để trở thành người thắng cuộc, bạn phải là người có mức đấu giá <strong>Duy nhất và Thấp nhất</strong> tại thời điểm kết thúc phiên đấu giá. </p>
    <p>
      
      <img src="http://dienmay.myhost/pimages/Article/rule1_1.jpg?v=2" width="535" alt="Thể lệ">
    </p>
             {/if}  
            </form>
            
        </div>
      
    </div>
</div>

{literal}
    <script type="text/javascript">
        var priceuinit = "{/literal}{$reverseauctions['price']}{literal}";
        function checkOutValidation()
        {
            var pass = true;
            var fullname = $('#ffullname').val().trim();
            var email = $('#femail').val().trim();
            var phone = $('#fphonenumber').val().trim();
            var price = $('#fprice').val().trim();
            if(fullname == '')
            {
                pass = false;
                $('#ffullname').css('border','solid 1px red');
                $('.ffullname').html('Vui lòng nhập Họ tên');
            }
            else{
                $('.ffullname').html('');
            }
            if(email == '')
            {
                pass = false;
                $('#femail').css('border','solid 1px red');
                $('.femail').html('Vui lòng nhập Email');
            }
            else
            {
                $('.femail').html('');
            }
            if(phone == '')
            {
                pass = false;
                $('#fphonenumber').css('border','solid 1px red');
                $('.fphonenumber').html('Vui lòng nhập số điện thoại');
            }
            else
            {
              if( phone.length < 8 || phone.length > 11 || isNaN(phone) == true)
              {
                 $('.fphonenumber').html('Số điện thoại không hợp lệ');
              }
              else
              {$('.fphonenumber').html('');}
            }
            if(price == '' || price < 1000 || price%1000 != 0 || price > parseFloat(priceuinit))
            {
                 pass = false;
                $('#fprice').css('border','solid 1px red');
                $('.fprice').html('Giá đấu phải là bội số 1.000, lớn hơn 0đ, và nhỏ hơn giá khởi điểm');
            }
            else
            {
              $('.fprice').html('');
            }
            return pass;
        }
        function checkvalidate(obj)
        {
             if($(obj).val().trim() != "")
                $(obj).css('border','1px solid #ccc');
            else
                $(obj).css('border','solid 1px red');
        }
        $('#fprice').number(true,0);
    </script>
{/literal}