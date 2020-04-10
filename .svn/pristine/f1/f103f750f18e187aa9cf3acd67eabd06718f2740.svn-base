<script  type="text/javascript" src="{$currentTemplate}js/site/popup.js"></script>
<div class="popuplogin">
{if empty($successpopup)}
<p class="title">Hãy đăng nhập để thêm sản phẩm vào danh sách yêu thích</p>
    <div class="popuplogin-bar">
    {include file="notify.tpl" notifyError=$errorpopup notifySuccess=$success}
     <form action="" method="post" name="installmentform">
       <div class="clear"></div><label>Tài khoản</label>
      <input class="wi-ins02 required" name="fuser" value="{$formData.fuser}" type="text" placeholder="Email hoặc số điện thoại">
        <div class="clear"></div><label>Mật khẩu</label>
      <input class="wi-ins02 required" name="fpassword" value="" type="password" placeholder="Mật khẩu">
        <div class="clear"></div>
    
        <input class="btnpopuplogin" id="" name="" type="submit" value="Đăng nhập" /><a class="popuploginforgetpass" onclick="parent.location.href = '{$conf.rooturl}login'" href="javascript:;">Quên mật khẩu ?</a>
        <input name="action" type="hidden" value="login">
   </form>
   <p style="color: #555;margin-top: 5px;">Chưa có tài khoản tại dienmay.com?<a class="popuploginforgetpass" onclick="parent.location.href = '{$conf.rooturl}login'" href="javascript:;"> Đăng ký ngay</a></p>
   <p style="color: #555;margin-top: 5px;">Tính năng này giúp bạn có thể lưu, chỉnh sửa và chia sẻ danh sách sản phẩm mà bạn yêu thích tại dienmay.com</p>
    </div>
    
{else}
<p class="title"><i class="icon-advice"></i>Thông báo</p>
    <div class="popuplogin-bar">
    {$successpopup}
    </div>
{/if}
</div>