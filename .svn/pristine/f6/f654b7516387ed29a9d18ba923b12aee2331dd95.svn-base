<div class="navbarprod">
    <li><a href="{$conf.rooturl}">Trang chủ</a> ››</li>
    <li>Thông tin tài khoản</li>
</div>

<!-- Profiles -->
<div class="profiles">

    <div class="profiles_left">
        <ul>
            <li class="bar-l">Tài khoản của tôi</li>
            <li><a href="#" class="active">
                    <e class="ic-pr-user"></e>
                    Thông tin cá nhân</a></li>
            <li><a href="{$conf.rooturl}account/accountsaleorder">
                    <e class="ic-pr-bill"></e>
                    Đơn hàng của tôi</a></li>
            <li><a href="{$conf.rooturl}account/bookmark/id/{$formData.codeuser}">
                    <e class="ic-pr-list"></e>
                    Sản phẩm tôi yêu thích</a></li>
            <li><a href="{$conf.rooturl}account/checksaleorder">
                    <e class="ic-pr-check"></e>
                    Kiểm tra đơn hàng</a></li>
        </ul>
    </div>


    <div class="profiles_cont">
        <h3>Thông tin cá nhân</h3>

        <form class="main-profile" method="post" action="" id="updateform">
            <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}</div>
            <div class="ctrl-gr">
                <label class="label-tx">Email:</label>
                {if $formData.email != $formData.empty}
                    <span>{$formData.email}</span>
                {else}
                    <input type="text" placeholder="{$formData.email}" disabled="" name="femail" id="femail"
                           class="input-in input-inupdate">
                {/if}
            </div>

            <div class="ctrl-gr">
                <label class="label-tx">Họ và Tên:</label>
                <input type="text" placeholder="{$formData.fullname}" name="ffullname" id="ffullname"
                       class=" input-inupdate input-in">
            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Giới tính:</label>

                <input type="radio" value="1" name="fgender" {if $formData.gender == '1'}checked="checked"{/if}
                       id="gendermale" class="radio"><span>Nam</span>
                <input type="radio" {if $formData.gender == '0'}checked="checked"{/if} value="0" name="fgender"
                       id="genderfemale" class="radio"><span>Nữ</span>

                {if $formData.gender !='0' && $formData.gender!='1'}
                    <label class="label-note">Xin mời cập nhật giới tính của bạn</label>
                {/if}

            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Ngày sinh:</label>
                <input type="text" placeholder="{$formData.birthday}" name="fbirthday" id="fbirthday"
                       class="input-in input-inupdate input-cal inputdatepicker ">


            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Điện thoại:</label>
                <input type="text" placeholder="{$formData.phone}" name="fphone" id="fphone"
                       class="input-in input-inupdate">
            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Địa chỉ:</label>
                <input type="text" placeholder="{$formData.address}" name="faddress" id="faddress"
                       class="input-in input-inupdate">
            </div>
            <div class="ctrl-gr">
                <select type="text" name="fcity" id="fcity" class="select-addr input-inupdate">
                    <option value=''>---Tỉnh/Thành phố---</option>
                    {foreach $setting.region as $key=>$value}
                        <option value='{$key}' {if {$key}=={$formData.city}}selected{/if}>{$value}</option>
                    {/foreach}
                </select>
                <label class="label-tx"></label>
                <select name="fdistrict" id="fdistrict" type="text" class="select-addr input-inupdate">
                    {if $strdictrict!=''}
                        {$strdictrict}
                    {else}
                        <option value="">---Quận/Huyện---</option>
                    {/if}
                </select>

            </div>
            <div class="ctrl-gr">
                <div class="bt-updatefix updateform" style="display: none"><span>Thay đổi »</span></div>
                <div class=" bt-invisiblefix inupdateform"><span>Thay đổi »</span></div>
            </div>
            <input type="hidden" name="fSubmitBasic">


        </form>
        <div class="space"></div>


        <h3>Đổi mật khẩu của bạn</h3>

        <form class="main-profile" method="post" action="" id="changeform">
            <div class='notifydiv'>{include file="notify.tpl" notifyError=$errorP notifySuccess=$successP notifyWarning=$warningP}</div>
            <div class="ctrl-gr">
                <label class="label-tx">Mật khẩu cũ:</label>
                <input type="password" placeholder="*****" name="fpass"
                       class="input-{$formData.errfpass} input-inchange">
            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Mật khẩu mới:</label>
                <input type="password" placeholder="*****" name="password1"
                       class="input-{$formData.errfpass1} input-inchange">
            </div>
            <div class="ctrl-gr">
                <label class="label-tx">Xác nhận mật khẩu:</label>
                <input type="password" placeholder="*****" name="password2"
                       class="input-{$formData.errfpass2} input-inchange">
            </div>
            <div class="ctrl-gr">

                <div class="bt-updatefix changeform" style="display: none"><span>Thay đổi »</span></div>
                <div class="bt-invisiblefix inchangeform"><span>Thay đổi »</span></div>
            </div>
            <input type="hidden" name="changepass">
        </form>
    </div>


    <div class="profiles_right">
        <h3>Đăng ký nhận tin</h3>
        <ul>
            {if $formData.subcriberMail==1}
                <li>
                    <span class="nhanemail"><span class="bullets">+</span>Bạn đã đăng ký nhận tin qua email từ dienmay.com</span>
                    <span class="konhanemail" style="display: none"><span class="bullets">+</span>Bạn chưa đăng ký nhận tin qua email từ <br> dienmay.com</span>

                    <div class="check">
                        <input type="checkbox" checked onclick="subcriber('email')"> Ngừng đăng ký nhận tin qua email
                    </div>
                </li>
            {else}
                <li>
                    <span class="konhanemail"> <span class="bullets">+</span>Bạn chưa đăng ký nhận tin qua email từ dienmay.com</span>
                    <span class="nhanemail" style="display: none"> <span class="bullets">+</span>Bạn đã đăng ký nhận tin qua email từ <br> dienmay.com</span>

                    <div class="check">

                        {if $formData.email == $formData.empty}
                            <span class="link-em"><a href="#">Cập nhật email để đăng ký</a></span>
                        {else}
                            <input type="checkbox" onclick="subcriber('email')">
                            Đăng ký nhận tin qua email
                        {/if}
                    </div>
                </li>
            {/if}
            {if $formData.subcriberPhone==1}
                <li>
                    <span class="nhanphone"><span class="bullets"> +</span>Bạn đã đăng ký nhận tin qua sms từ dienmay.com</span>
                    <span class="konhanphone" style="display: none"><span class="bullets"> +</span>Bạn chưa  đăng ký nhận tin qua sms từ <br> dienmay.com</span>

                    <div class="check">
                        <input type="checkbox" checked onclick="subcriber('phone')"> Ngừng đăng ký nhận tin qua SMS
                    </div>
                </li>
            {else}
                <li>
                    <span class="konhanphone"><span class="bullets"> +</span>Bạn chưa đăng ký nhận tin qua sms từ dienmay.com</span>
                    <span class="nhanphone" style="display: none"><span class="bullets"> +</span>Bạn đã  đăng ký nhận tin qua sms từ <br> dienmay.com</span>

                    <div class="check">

                        {if $formData.phone == $formData.empty}
                            <span class="link-em"><a href="#">Cập nhật số điện thoại để đăng ký</a></span>
                        {else}
                            <input type="checkbox" onclick="subcriber('phone')">
                            Đăng ký nhận tin qua SMS
                        {/if}
                    </div>
                </li>
            {/if}
        </ul
    </div>
</div>
</div>
<script type="text/javascript">
var datedefault = "{if $formData.birthday != $formData.empty}{$formData.birthday}{else}01-01-1990{/if}";
var changedate  = false;
var birthdate   = "{if $formData.birthday != $formData.empty}{$formData.birthday}{else}00-00-0000{/if}";
{literal}

$(document).ready(function () {

    $('.inputdatepicker').datepicker({'format': 'dd-mm-yyyy', 'weekStart': 1}).datepicker('setValue', datedefault)
            .on('changeDate', function (ev) {
                $('.datepicker').hide();
                $(this).blur();
                changedate = true;
                if ($(this).val() != '' && $(this).val() != $(this).attr('placeholder'))
                {
                    $('.updateform').show();
                    $('.inupdateform').hide();
                }
            });

    $("#fcity").change(function () {
        var city = $('#fcity').val();
        var url = "/register/indexajax?city=" + city;
        $.ajax({
            type: "POST",
            data: {action: "getdistrict"},
            url: url,
            dataType: "html",
            success: function (data) {
                $("#fdistrict").html(data);
            }
        });
    });
    $( "input:radio" ).on( "click", function() {
        $('.updateform').show();
        $('.inupdateform').hide();
    });
});


function subcriber(field) {
    $.ajax({
        type: "POST",
        data: { value: field, 'action': 'updatesub'},
        url: rooturl + "account/indexajax",
        dataType: "html",
        success: function (dataCheck) {
            var arr = JSON.parse(dataCheck);
            $('.' + arr[0] + field).show();
            $('.' + arr[1] + field).hide();
        }
    });
}



$('.input-inupdate').keyup(function(event){
    var control         = $(this);
    var controlval      = $(this).val();
    var controlclass    = $('.input-inupdate');
    var flag            = 0;
    var key             = event.which || event.keyCode || event.charCode;
    controlclass.each(function () {
        if ($(this).val() != '' && $(this).val() != $(this).attr('placeholder'))
        {
                flag = flag + 1;
        }

    });
    if (flag>0) {
        $('.updateform').show();
        $('.inupdateform').hide();
    }
    else {
        $('.updateform').hide();
        $('.inupdateform').show();
    }
});
$('.input-inchange').keyup(function(event){
    var control         = $(this);
    var controlval      = $(this).val();
    var controlclass    = $('.input-inchange');
    var flag            = 0;
    var key             = event.which || event.keyCode || event.charCode;
    controlclass.each(function () {
        if ($(this).val() != '' && $(this).val() != $(this).attr('placeholder'))
            flag = flag + 1;

    });

    if (flag == 3) {
        $('.changeform').show();
        $('.inchangeform').hide();
    }
    else {
        $('.changeform').hide();
        $('.inchangeform').show();
    }
});
$('.changeform').click(function(){
    $('#changeform').submit();
});
$('.updateform').click(function(){
    $('#updateform').submit();
});

</script>
{/literal}