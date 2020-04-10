<div class="sendquest">
	<div class="qleft">
		<div class="qtitle">Gửi câu hỏi cho dienmay.com</div>
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		<form method="POST" action="">
			<input class="qinput" name="ffullname" type="text" placeholder="Họ và tên"/>
			<input class="qinput" name="femail" type="text" placeholder="Email"/>
			<input class="qinput" name="fphone" type="text" placeholder="Số điện thoại"/>
			<textarea class="qinput" name="fmessage" cols="" rows="5" placeholder="Câu hỏi của anh chị ..."></textarea>
			<input class="qinput" type="text" name="fcaptcha" id="fcaptcha" placeholder="Nhập mã xác nhận bên dưới"/>

			<div style="margin-left: 12px;">
				<img style="margin-left: auto" id='imgcaptcha' src="{$conf.rooturl}captcha">
				<span onclick='refeshimg()' style="cursor: pointer"><img src="{$conf.rooturl}templates/default/images/refresh_blue.png" width="16px" style="vertical-align:top"/></span></div>
			<input class="qbutton" name="fsubmit" type="submit" value="Gửi câu hỏi"/>
		</form>
	</div>
	<div class="qright">
		<div class="dmcom">dienmay.com</div>
		<div class="dmphone">1900 1883 - (08) 39 48 6789</div>
		<div class="dmemail">cskh@dienmay.com</div>
		<div class="iconsocial">
			<a href="https://www.facebook.com/dienmaycom" target="_blank"><i class="icon-dmface"></i></a>
			<a href="#"><i class="icon-dmmap"></i></a>
			<a href="https://www.google.com/+dienmay"  target="_blank"><i class="icon-dmggl"></i></a>
		</div>
                        <div class="dmemail"><a href="#" onclick="redirect('{$conf.rooturl}ho-tro-khach-hang')" style="text-decoration:none">CHÍNH SÁCH HỔ TRỢ KHÁCH HÀNG</a></div>
	</div>
</div>
{literal}
	<script>
		$('.notify-bar:eq(0)').remove();
		function refeshimg()
		{
			d = new Date();
			$('#imgcaptcha').attr('src',rooturl+"captcha/"+d.getTime())
		}
                function redirect(url)
                {
                        window.top.location.href =url;
                }
	</script>
{/literal}