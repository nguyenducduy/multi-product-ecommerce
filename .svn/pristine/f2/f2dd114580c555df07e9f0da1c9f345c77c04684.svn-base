
    <section>
    <form method="post" action="{$conf.rooturl}{$controller}{if $action!='index'}/{$action}{/if}?id={$myProduct->id}" class="formcheckout">
    <div class="conttable">
        <div class="listcart">
            <div class="conttitle">Đặt hàng trước</div>
            <ul>
                <li>
                    <img src="{$myProduct->getSmallImage()}" alt="" >
                    <a href="{$myProduct->getProductPath()}">{$myProduct->name}</a>
                    <div class="area">
                        <div style="float:left">Giá dự kiến tại dienmay.com:</div><br>
                        <strong style="margin:0"><div class="pricedienmay loadprice lp{$myProduct->id}{$myProduct->barcode|trim|substr:-5}" rel="{$myProduct->id}{$myProduct->barcode|trim|substr:-5}"><span class="pricenew" style="margin-top: 0;font-weight: bold;color:red;text-decoration:none;">{if $myProduct->prepaidprice > 1000}{$myProduct->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</span></div></strong>
                        <div class="clearfix"></div>
                        <div style="float:left">Ngày dự kiến có hàng:</div><br>
                        <strong style="margin:0">{$myProduct->prepaidenddate|date_format:"%d/%m/%Y"}</strong>
                      
                   </div>
                    
                    <div class="clearfix"></div>
                </li>
            </ul>
        </div>
          {if !empty($myPromotion)}
		              <div class="Promote" style="padding: 10px 10px;">
		                <h6 style="color: #fe7e00;">Khuyến mãi</h6>
		      
		                    <div class="promotdes">{if $myPromotion->descriptionclone != ""}{$myPromotion->descriptionclone}{else}{$myPromotion->description}{/if}</div>
		            
		              </div>
		            {/if}
        <div class="infopay">
            <div class="conttitle">Thông tin khách hàng</div>
            <span class="infoa">Vui lòng điền đầy đủ thông tin để dienmay.com liên hệ với bạn khi có hàng</span>
            <div class="wrapinfopay">
                     {include file="notify.tpl" notifyError=$error notifySuccess=$success}
                    <input class="wiinput" name="ffullname" id="ffullname" type="text" value="{$formData.ffullname}" placeholder="Họ và tên(*)" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)">
                    <input class="wiinput" name="femail" id="femail" type="text" value="{$formData.femail}" placeholder="Email(*)" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)">
                    <input class="wiinput" name="fphonenumber" id="fphonenumber"  value="{$formData.fphonenumber}" type="text" placeholder="Số điện thoại(*)" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)">
                   <textarea class="inputfield wiinput textarea" style="" name="faddress" id="faddress" cols="" rows=""  placeholder="Địa chỉ nhận hàng(*)" onblur="checkvalidate(this)" onkeyup="checkvalidate(this)">{$formData.faddress}{if $formData.fdistrict != ""}, {$formData.fdistrict}{/if}{if $formData.fcity != ""}, {$registry->setting.region[$formData.fcity]}{/if}</textarea>
                    <textarea class="inputfield wiinput textarea" name="fnote" cols="" rows="" placeholder="Yêu cầu khác"></textarea>
            </div>
        </div>
        <div class="clearfix"></div>
        {if $myProduct->prepaiddepositrequire > 0}
              <strong>Lưu ý:</strong> {$myProduct->name} là sản phẩm rất hot do đó bạn cần đặt trước <strong style="color:red">{$myProduct->prepaiddepositrequire|number_format}đ</strong> để đảm bảo hàng sẽ được chuyển đến cho bạn đúng ngày. Nhân viên CSKH của điện máy sẽ liên hệ với bạn để xác nhận thông tin
              <input type="hidden" value="Sản phẩm đặt trước , cần đặt cọc: {$myProduct->prepaiddepositrequire|number_format} đ" name="fnotedattruoc" />
          {/if}
    </div>
            <!-- -->    
        <input class="btn-pay btnbuynow submitform" onclick="return checkOutValidation()" type="submit" id="btncheckout" name="btncheckout" value="Đặt hàng trước &#187;" />
        <div class="callme">Hoặc gọi cho chúng tôi: <strong>1900 1883</strong></div>      
    </form>
    </section>
<!-- End content -->
{literal}
     <script type="text/javascript">
        function checkOutValidation()
        {
            var pass = true;
            var fullname = $('#ffullname').val().trim();
            var email = $('#femail').val().trim();
            var phone = $('#fphonenumber').val().trim();
            var address = $('#faddress').val().trim();
            if(fullname == '')
            {
                pass = false;
                $('#ffullname').css('border','solid 1px red');
            }
            if(email == '')
            {
                pass = false;
                $('#femail').css('border','solid 1px red');
            }
            if(phone == '')
            {
                pass = false;
                $('#fphonenumber').css('border','solid 1px red');
            }
            if(address == '')
            {
                 pass = false;
                $('#faddress').css('border','solid 1px red');
            }
            return pass;
        }
    </script>
{/literal}