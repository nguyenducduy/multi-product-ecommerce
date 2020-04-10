<!-- Content -->
    <section>
       <div class="dropuser">
          <div class="wrapuser">
            <div class="login">
               <div class="btnback"><a href="javascript:history.back()">« Trở về</a></div><h5>Đăng nhập</h5>
            </div>
            <form action="{$conf.rooturl}login" method="post">
              <div class="rowlogin"><span><i class="icon-uname"></i></span>
                <input class="userinput" name="fuser" type="text" placeholder="Email hoặc số điện thoại">
              </div>
              <div class="rowlogin"><span><i class="icon-upass"></i></span>
                <input class="userinput" name="fpassword" type="password" placeholder="Mật khẩu">
              </div>
              <div class="checklog">
                 <label><input style="margin-top: 3px;display: block;float: left;" name="frememberme" checked="checked" type="checkbox" value="1" />
               Nhớ tôi trên điện thoại này</label>
              </div>
              <button class="btnlogin"  type="submit">Đăng nhập</button>
              
              <input type="hidden" name="action" value="sitelogin">
            </form>
            <div class="clear"></div>
            
            
          </div>
             <div class="policyuse"><a href="{$conf.rooturl}forgotpass">Quên mật khẩu?</a></div>
            <!--<div class="forgetpass">
                <h5>Quên mật khẩu</h5>
                <div class="forgetwrap">
                	<span>Soạn tin nhắn</span>
                    <strong>MK [ SĐT_ ]</strong>
                    <span>Gửi</span> <strong>1900 1883</strong>
                </div>
            </div>  -->
            <div class="registry">
                <h5>Đăng ký thành viên</h5>
                <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
                <form action="{$conf.rooturl}register" method="post">
                  <div class="rowlogin">
                    <input class="regisinput" name="ffullname" type="text" placeholder="Họ tên">
                  </div>
                  <div class="rowlogin">
                    <input class="regisinput" name="femail" type="text" placeholder="Email">
                  </div>
                  <div class="rowlogin">
                    <input class="regisinput" name="fphone" type="text" placeholder="Số điện thoại">
                  </div>
                  <div class="rowlogin">
                    <input class="regisinput" name="fpassword" type="password" placeholder="Mật khẩu">
                  </div>
                  <div class="checkregis">
                     <label><input style="margin-top: 3px;display: block;float: left;" name="fregister" checked="checked" type="checkbox" value="1" />
                   Đăng ký nhận tin từ dienmay.com</label>
                  </div>
                  <button class="btnlogin"  type="submit">Đăng ký</button>
                   <input type="hidden" name="action" value="register">
                </form>
                <div class="clear"></div>
            </div> 
            
            <div class="policyuse"><a href="{$conf.rooturl}dieu-khoan-su-dung-thong-tin">Chính sách sử dụng thông tin tại dienmay.com</a></div>
        </div>
    </section>
<!-- End content -->