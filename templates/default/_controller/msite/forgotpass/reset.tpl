<!-- Content -->
    <section>
       <div class="dropuser">
          <div class="wrapuser">
            <div class="login">
               <div class="btnback"><a href="javascript:history.back()">« Trở về</a></div><h5>Đăng ký mật khẩu mới</h5>
            </div>
           <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
            <form action="" method="post">
              <div class="rowlogin">
                <input class="regisinput" name="fpassword" type="text" placeholder="Mật khẩu mới">
              </div>
              <div class="rowlogin">
                <input class="regisinput" name="fpassword2" type="text" placeholder="Xác nhận mật khẩu mới">
              </div>
              
              <button class="btnlogin"  type="submit">Gửi</button>
              <input type='hidden' name='fsubmit'>
              <input type="hidden" name="action" value="sitelogin">
              <input type="hidden" name="ftoken" value="{$smarty.session.forgotpassToken}" />
            </form>
            <div class="clear"></div>
            
         
          </div>
            
            <div class="policyuse"><a href="{$conf.rooturl}dieu-khoan-su-dung-thong-tin">Chính sách sử dụng thông tin tại dienmay.com</a></div>
        </div>
    </section>
<!-- End content -->