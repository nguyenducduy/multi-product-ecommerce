<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Campaign 29</title>
<link type="text/css" rel="stylesheet" href="http://dienmay.myhost/templates/default/min/?g=css&ver=196-02112012" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/style29.css" media="screen" />
<script src="{$currentTemplate}/js/jquery.js"></script>
</head>

<body>
          <div style='width:500px'>
               <div id='inline_content291' class="inlinepopup292">
                    <div class="rowpopup292">ĐĂNG KÝ MUA SẢN PHẨM VỚI GIÁ 33.000Đ</div>
                	<p>Bạn sẽ là người may mắn được mua sản phẩm với giá 33.000đ nếu bạn là người thứ 33 nhập thông tin đầy đủ và gửi về cho <i><b>dienmay.com</b></i> </p>
				<div class="infocusbuy29">
                	<form action="" method="post">
                		<input type="hidden" name="ftoken" value="{$smarty.session.eventUserToken}"/>
                    	<input class="inputup29" name="ffullname" type="text" placeholder="Họ và Tên" value="{$formData.ffullname}" />
                        <input class="inputup29" name="fphone" type="text" placeholder="Điện thoại" value="{$formData.fphone}" />
                        <input class="inputup29" name="femail" type="text" placeholder="Email" value="{$formData.femail}" />
                        <div style="margin:10px 0"><input name="fregister" checked="checked" type="checkbox" value="1" />
                        <label style="margin-left:10px; vertical-align:top">Đăng ký nhận tin từ dienmay.com</label></div>
                        {include file="notify.tpl" notifyError=$error notifySuccess=$success}
                        {if $disiablebutton == ''}
                        <input class="btncam29" name="submit" type="submit" value="Mua ngay" />
                        {/if}
        
                    </form>
                </div>
             </div>
                            
        </div> 
</body>
</html>