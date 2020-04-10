<div class="wrmember">
    <div class=" wr-pword01">
        <div class="tt-pw"> Quên mật khẩu</div>
        <span>Nhập Email của bạn vào ô bên dưới và gửi cho dienmay.com để lấy lại mật khẩu</span>

        <form method="post" action="" id="myformSendmail">
            <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
            <div class=" control001">
                <label class="label-pass">Email:</label>
                <input class="inputemail" type="text" name="femail" id="femail" placeholder="Nhập email của bạn">
            </div>
            <div class=" control001">
                <input id="btnsenmail" name="" type="submit" class="btpword" value="gửi yêu cầu"/>
                <input type='hidden' name='fsubmit'>
                <input type="hidden" name="ftoken" value="{$smarty.session.forgotpassToken}"/>
            </div>
        </form>

    </div>

</div>

{literal}
    <script type="text/javascript">
        $("#btnsenmail").click(function () {
            $("#myformSendmail").submit();
        });
    </script>
{/literal}	
	
	

