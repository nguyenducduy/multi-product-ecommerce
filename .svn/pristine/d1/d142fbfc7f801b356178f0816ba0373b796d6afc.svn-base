<div class="bodymember">
<div id="container">
    <div class="logsigndm">

	<div class="barMB">Đăng ký thành viên</div>
    <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
    <form action="" method="post" id="myformRegister2">
        <div class="wrapradiomb">
        <input class="radiomb" name="fgender" checked="checked" type="radio" value="1" /><div class="gendermb">Anh<span>*</span></div>
        <input class="radiomb" name="fgender" type="radio" value="0" /><div class="gendermb">Chị<span>*</span></div>
        </div>
        <div class="iconinput"><label class="labelMB">Họ và tên<span>*</span></label><input class="inputmember" name="ffullname" value="{$formData.ffullname}" type="text" placeholder="Hãy nhập đầy đủ họ tên có dấu"  /></div>

        <div class="iconinput"><label class="labelMB">Email<span>*</span></label><input class="inputmember" name="femail" value="{$formData.femail}" type="text" placeholder="Email"  /></div>
        <div class="iconinput"><label class="labelMB">Số điện thoại<span>*</span></label><input class="inputmember" name="fphone" value="{$formData.fphone}" type="text" placeholder="Số điện thoại"  /></div>
       
        <div class="iconinput"><label class="labelMB">Mật khẩu<span>*</span></label>
            <input class="inputmember" name="fpassword" id='txtpass' value="{$formData.fpassword}" type="password" placeholder="Vui lòng không sử dụng những mật khẩu thông dụng"  />
            <input class="inputmember" name="fpasswordshow" id='txtpassshow' style="display: none"  />
        </div>
         <div class="iconinput"><label class="labelMB">Địa chỉ<span>*</span></label><input class="inputmember" name="faddress" value="{$formData.faddress}" type="text" placeholder="Số nhà, đường, phường xã"  /></div>

        <div class="iconinput"><label class="labelMB"> Chọn Tỉnh/Thành phố<span>*</span></label>
            <select name="fprovince" id='fprovince' class="inputmember" style="width: 343px;">
                <option value="">---Tỉnh thành nơi bạn sống---</option>
                {foreach $region as $k=>$v}
                    <option value="{$k}" {if $k==$formData.fprovince}selected="selected"{/if}>{$v}</option>
                {/foreach}
            </select>
        </div>
         <div class="iconinput"><label class="labelMB"> Quận huyện<span>*</span></label>
            <select name="fdistrict" id="fdistrict"  class="inputmember" style="width: 343px;">
                        <option value="">---Vui lòng chọn tỉnh thành trước---</option>
                        {if isset($district) && $district != ""}
                            {$district}
                        {/if}
            </select>
        </div>
         <div class="iconinput {if $formData.vip=='1'}vip-control{/if}"><label class="labelMB">Ngày sinh<span>*</span></label><input class="inputmember inputdatepicker" name="fbirthday" id="fbirthday" value="{$formData.fbirthday}" type="text" placeholder="Ngày sinh"  /></div>
        <div class="iconinput {if $formData.vip=='1'}vip-control{/if}"><label class="labelMB">chứng minh nhân dân<span>*</span></label><input class="inputmember" name="fcmnd" id="fcmnd" value="{$formData.fcmnd}" type="text" placeholder="Chứng minh nhân dân"  /></div>

		<div class="iconinput"><label class="labelMB"></label>
           <label><input style="float:left; margin-right: 7px;margin-top: 1px" type="checkbox" value="1" checked="checked" name="fregister" class="checkmember"><p style="color: #fff">Đăng ký nhận tin tức hàng tuần từ dienmay.com</p></label>
        </div>
        <div class="iwant" >

            <a href="javascript:void(0)" id='wantvip'>Tôi muốn trở thành thành viên VIP của dienmay.com</a>
            <a style="cursor: pointer;display: none" id='notvip'> Tôi không muốn trở thành thành viên VIP của dienmay.com </a>

        </div>
        <input name="fsubmit"  id="btnsiteregister2" type="button" class="btnmember" value="Đăng ký" />
    	<div class="signup2">
            Đã có tài khoản? <a href="{$conf.rooturl}login">Đăng nhập</a>
            <span><a href="{$conf.rooturl}thanh-vien/quen-mat-khau">Quên mật khẩu?</a></span>
        </div>
        <input type='hidden' name='action' value='register'>
    </form>

    </div>
    <div class="icondkdn">→</div>
    <div class="regisright">
        <p>
            Là thành viên của dienmay.com, bạn sẽ là người đầu tiên được nhận những thông tin khuyến mãi cực HOT cũng như được cập nhật xu hướng mua sắm hiện nay.
        </p>
        <p>
            Bên cạnh đó, bạn cũng sẽ đc hưởng những chính sách chỉ dành riêng cho thành viên của dienmay.com
        </p>
        <p>
            Hãy đăng kí và cung cấp thông tin cho dienmay.com, chúng tôi hứa sẽ làm bạn hài lòng!
        </p>
    </div>
</div>
</div>
{literal}
<script type="text/javascript">
    $("#btnsiteregister2").click(function(){
        $("#myformRegister2").submit();
    });
    $("#reloadcatpcha").click(function() {
        var url = $("#urlhome").attr('url');
        $('#imgcatpcha').attr('src', url+'captcha&'+ Math.random())
    });

    $("#showpass").click(function(){


        if($('#txtpass').val()!='')
            $('#txtpassshow').val($('#txtpass').val());
        else
            $('#txtpass').val($('#txtpassshow').val());


        if($(this).is(':checked'))
        {
            $('#txtpass').hide();
            $('#txtpassshow').show();
        }
        else
        {
            $('#txtpass').show();
            $('#txtpassshow').hide();
        }
    });


    $("#fprovince").change(function(){
         var city     = $('#fprovince').val();
         var url      = "/register/indexajax?city="+city;
         $.ajax({
            type : "POST",
                data : {action:"getdistrict"},
                url : url,
                dataType: "html",
                success: function(data){
                    $("#fdistrict").html(data);
                }
         });
    });
    $('.vip-control').hide();
    $('#wantvip').html(' Tôi muốn trở thành thành viên VIP của dienmay.com ');
    $('#wantvip').click(function(){
        $('.vip-control').show(100);
        $('#wantvip').hide();
        $('#notvip').show();
    });
    $('#notvip').click(function(){
        $('.vip-control').hide(100);
        $('#wantvip').show();
        $('#notvip').hide();
    });
   $(document).ready(function(){
       $('.inputdatepicker').datepicker({'format':'yyyy-mm-dd', 'weekStart' : 1})
               .on('changeDate', function(ev){
                   $('.datepicker').hide();
                   $(this).blur();
       });
   });


</script>
{/literal}