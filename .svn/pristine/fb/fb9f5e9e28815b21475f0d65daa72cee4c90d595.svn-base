<div id="container">
    <div class="wrmember" style="height: 500px">
        <div class="wr-login">
            <div class="tt-login">Đăng nhập</div>
            <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
            <form action="" method="post" id="myformLogin">
                <div class="ctrl-input">
                    <label class="labelacc"> Tài khoản:</label>
                    <input name="fuser" id="fuser" class="inputacc" type="text" placeholder="Tài khoản" value="{$formData.fuser}" >
                </div>
                <div class="ctrl-input">
                    <label class="labelacc"> Mật khẩu:</label>
                    <input class="inputacc" name="fpassword" id="fpassword" type="password" placeholder="Mật khẩu" >
                </div>
                <div class="ctrl-input">
                    <label style="cursor: pointer"   > <input class="checkacc" type="checkbox" value="1" name="frememberme" >
                    <span>Nhớ tôi tại máy tính này</span></label>
                </div>
                <div class="ctrl-input">
                    <input class="btlogin" type="submit" value="Đăng nhập" type="submit">
                </div>
                <input type='hidden' name='action' value='sitelogin'>
                <div class="forget-pass"><span class="span-pass" style="height:40px;color: #00a1e6;font: normal 13px arial;text-decoration: none;padding: 10px;display: block;cursor: pointer" href="#">Quên mật khẩu</span>


                    <div class="wr-password" style="display:{if $formData.forgot=='1'} block {else}none {/if}">
                        <div class="arrforget"></div>

                        <div class="wr-passmall">
                            <div class="notifydiv" >
                                <div class="notify-bar notify-bar-error" style="display: none " id="errorbar">
                                    <div class="notify-bar-icon"><img src="{$conf.rooturl}templates/default/images/notify/error.png" alt="error"></div>
                                    <div class="notify-bar-button" style="width: 30px"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="{$conf.rooturl}templates/default/images/notify/close-btn.png" border="0" alt="close"></a></div>
                                    <div class="notify-bar-text">
                                        <p id="errortext"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="notifydiv" >
                                <div class="notify-bar notify-bar-success" style="display: none" id="successbar">
                                    <div class="notify-bar-icon" style="width: 26px"><img src="{$conf.rooturl}templates/default/images/notify/success.png" alt="error"></div>
                                    <div class="notify-bar-button" style="width: 30px"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="{$conf.rooturl}templates/default/images/notify/close-btn.png" border="0" alt="close"></a></div>
                                    <div class="notify-bar-text">
                                        <p id="successtext" style="font-size: 11px">Vui lòng kiểm tra mail để tiếp tục đổi mật khẩu</p>
                                    </div>
                                </div>
                            </div>
                            <p>Quên mật khẩu</p>
                            <span>Nhập email bạn đã đăng ký với dienmay.com</span>
                            <div class="ctrl-pw">
                                <input class="input-pw" type="text" placeholder="Nhập email" id='fpemail'>
                                <input id="btnforgot" class="btlogin" type="button" value="Lấy mật khẩu" type="button" onclick="forgotpass()">
                                <img id="imgforgot" src="{$conf.rooturl}templates/default/images/ajax-loader.gif" style="display: none;float: left;margin-top: 6px;">
                            </div>
                            {*<div class="pw-sms"> Hoặc nhắn tin theo cú pháp <span class="pw-red">MK [SĐT]</span> gửi đến<span class="pw-blue"> 1900 1883</span> </div>*}
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </form>
            <div class="clear"></div>
        </div>

        <!-- Đăng ký -->
        <div class="wr-signup">
            <div class="tt-login"> Đăng Ký </div>
            <div class='notifydiv'>{include file="notify.tpl" notifyError=$errorR notifySuccess=$successR}</div>
            <div class="note">
                <p>Bạn chưa là thành viên? Hãy đăng ký ngay để trải nghiệm hình thức mua sắm online thật thú vị tại dienmay.com</p>
                <div class="show_FAQ"> ?
                    <div class="show_box"> <i></i>Là thành viên của dienmay.com, bạn sẽ là người đầu tiên được nhận những thông tin khuyến mãi cực HOT cũng như được cập nhật xu hướng mua sắm hiện nay. </div>
                </div>
            </div>
            <form method="post" action="" id="MyformRegister">
                <div class="ctrl-signup">
                    <label class="label-signup">Họ và tên:<span>*</span></label>
                    <input class="input-signup" type="text" placeholder="Nhập họ và tên" name="fname" value="{$formData.fname}">
                </div>
                <div class="ctrl-signup">
                    <label class="label-signup">Email:<span>*</span></label>
                    <input class="input-signup" type="text" placeholder="Nhập email" name="femail" value="{$formData.femail}">
                </div>
                <div class="ctrl-signup">
                    <label class="label-signup">Điện thoại:<span>*</span></label>
                    <input class="input-signup" type="text" placeholder="Nhập điện thoại" name="fphone" value="{$formData.fphone}">
                </div>
                <div class=" ctrl-signup">
                    <label class="label-signup">Mật khẩu:<span>*</span></label>
                    <input class="input-signup" type="password" placeholder="Nhập mật khẩu" name="fpassword" value="{$formData.fpassword}">
                </div>
                <div class="ctrl-check">
                    <label style="cursor: pointer"><input class="checkacc" type="checkbox" checked name="fsubcriber">
                   <strong>Đăng ký nhận tin từ <i><b>dienmay</b>.com</i></strong></label></div>
                <div class="ctrl-check">
                    <label style="cursor: pointer"><input class="checkacc" type="checkbox" checked name="faccept">
                    <strong>Tôi đồng ý với các<span class="policy"> <a href="{$conf.rooturl}dieu-khoan-su-dung-thong-tin" target="_blank">điều khoản về sử dụng thông tin của
                                <i><b>dienmay</b>.com</i></a></span></strong></label></div>
                <div class=" ctrl-check">
                    <input class="btlogin" type="submit" value="Đăng ký" type="submit">
                </div>
                <input type='hidden' name='action' value='siteregister'>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>

{literal}
<script type="text/javascript">
    $("#btnloginsite").click(function(){
        $("#myformLogin").submit();
    });
    function disp_confirm()
    {
        var r=confirm("Có lỗi Hệ thống vui lòng đăng nhập vào lúc khác , OK để reload page , Cancel về trang chủ")
        if (r==true)
        {
            location.reload();
        }
        else
        {
            var geturl =$("#urlajax").attr("url");
            window.location.assign(urlindex);
        }
    }
    function forgotpass()
    {
        $('#successbar').hide();
        $('#errorbar').hide();
        var value = $('#fpemail').val();
        $('#imgforgot').show();
        $('#btnforgot').hide();
        $.ajax({
            type: "POST",
            data: { femail:value,'fsubmit':'forgotpass','ajax':'forgotpass'},
            url: rooturl + "forgotpass",
            dataType: "html",
            success: function (dataCheck) {
                if(dataCheck.trim()=='ok')
                {
                    $('#successbar').show();

                }
                else
                {
                    $('#errorbar').show();
                    $('#errortext').text(dataCheck);

                }

                $('#btnforgot').show();
                $('#imgforgot').hide();
            }
        });
    }

        $('.forget-pass').mouseenter(function(){
            var input = $('.wr-password');
            input.attr('style','display:block');
        });

    $('.span-pass').click(function(){
        var input = $('.wr-password');
        var css = input.attr('style')

        if(css != 'display:block')
            input.attr('style','display:block');

        if(css != 'display:none')
            input.attr('style','display:none');
    });
    $(".keyeneter").keyup(function(event){
        var user = $("#fuser").val();
        var pass = $("#fpassword").val();
        if(user!= '' && pass!=''){
            /*======================CHECKOUT=============================*/
                if(event.keyCode == 13)
                $("#myformLogin").submit();

            /*======================CHECKOUT=============================*/
        }
    });
</script>
{/literal}