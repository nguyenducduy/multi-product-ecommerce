<script  type="text/javascript" src="{$currentTemplate}js/site/popup.js"></script>
<div class="installment">
<p style="color:#00a1e6"><i class="icon-advice"></i>Tư vấn mua trả góp</p>
    <div class="installeft">
        {include file="notify.tpl" notifyError=$error notifySuccess=$success}
        <span>Thông tin đặt hàng</span>
        Vui lòng cung cấp thông tin bên dưới để <span style="color:#00a1e6; font-weight:normal; display:inline; text-transform:none">dienmay.com</span> có thể tư vấn tốt nhất cho quý khách
        <div class="clear"></div>
     <form action="" method="post" name="installmentform">
        <label>Anh chị</label>
      <select name="fgender" class="wi-ins01 required">
            <option value="">--Chọn--</option>
            <option value="1"{if $formData.fgender==1} selected="selected"{/if}>Anh</option>
            <option value="2"{if $formData.fgender==2} selected="selected"{/if}>Chị</option>
      </select>
      <input class="wi-ins02 required" name="ffullname" value="{$formData.ffullname}" type="text" placeholder="Vui lòng điền đầy đủ họ và tên"  />
        <label>Số di động</label>
      <input name="fphone" type="text" value="{$formData.fphone}" class="wi-ins03 required" />
        <label style="width:45px">Email</label>
      <input style="width:160px !important" name="femail" type="text" value="{$formData.femail}" class="wi-ins03 required email" />
        <label>Ngày sinh</label>
      <input name="fbirdthdate" type="text" value="{$formData.fbirdthdate}" placeholder="Ngày/tháng/năm sinh" class="wi-ins03 required inputdatepicker" />
        <label style="width:45px">CMND</label>
        <input style="width:160px !important" name="fpersonid" value="{$formData.fpersonid}" type="text" class="wi-ins03 required" maxlength="11" />
        <div class="clear"></div>
      <input class="wi-ins04" name="fpersontype" type="radio" value="1"{if $formData.fpersontype==1} checked="checked"{/if} />Người đi làm
      <input style="margin-left:35px !important" class="wi-ins04" name="fpersontype" type="radio" value="2"{if $formData.fpersontype==2} checked="checked"{/if} />Sinh viên
        <div class="clear"></div>
        <label>Địa chỉ ở hiện nay</label>
      <input class="wi-ins05 required" name="faddress" value="{$formData.faddress}" type="text" />
        <div class="clear"></div>
        <label>Nơi ở</label>
      <select style="width: 140px!important;" class="wi-ins05 required" name="fregion" id="fcurrentregion">
            <option value="">--Chọn--</option>
            {foreach item=region key=regionid from=$setting.region}
            <option {if $regionid == $formData.fregion}selected="selected" {/if} value="{$regionid}">{$region}</option>
            {/foreach}
        </select>
       <!-- <div class="clear"></div>-->
        <label style="width:57px">Hộ khẩu</label>
      <select style="width: 150px!important;" class="wi-ins05 required" id="fregionresident" name="fregionresident">
            <option value="">--Chọn--</option>
            {foreach item=region key=regionid from=$setting.region}
            <option {if $regionid == $formData.fregionresident}selected="selected" {/if} value="{$regionid}">{$region}</option>
            {/foreach} 
        </select>
        <div class="clear"></div>
        <label>Thời gian trả góp</label>
      <select class="wi-ins06 required" name="finstallmentmonth" id="finstallmentmonth" style="width: 100px !important;">
            <option value="">--Chọn--</option>
            <option{if $formData.finstallmentmonth==6} selected="selected"{/if} value="6">6 tháng</option>
            <option{if $formData.finstallmentmonth==9} selected="selected"{/if} value="9">9 tháng</option>
            <option{if $formData.finstallmentmonth==12} selected="selected"{/if} value="12">12 tháng</option>
            <option{if $formData.finstallmentmonth==15} selected="selected"{/if} value="15">15 tháng</option>
            <option{if $formData.finstallmentmonth==18} selected="selected"{/if} value="18">18 tháng</option>
            <option{if $formData.finstallmentmonth==24} selected="selected"{/if} value="24">24 tháng</option>
        </select>
        <label style="width:95px">Mức trả trước</label>
      <select class="wi-ins06 required" name="fsegmentpercent" id="fsegmentpercent" style="width: 152px !important;">
            <option value="">--Chọn--</option>
            <!--<option{if $formData.fsegmentpercent==20} selected="selected"{/if}>20% (~ 2,899,000đ)</option>
            <option{if $formData.fsegmentpercent==30} selected="selected"{/if}>30% (~ 4,899,000đ)</option>
            <option{if $formData.fsegmentpercent==40} selected="selected"{/if}>40% (~ 5,899,000đ)</option>
            <option{if $formData.fsegmentpercent==50} selected="selected"{/if}>50% (~ 6,899,000đ)</option>
            <option{if $formData.fsegmentpercent==60} selected="selected"{/if}>60% (~ 6,899,000đ)</option>
            <option{if $formData.fsegmentpercent==70} selected="selected"{/if}>70% (~ 6,899,000đ)</option>
            <option{if $formData.fsegmentpercent==80} selected="selected"{/if}>80% (~ 6,899,000đ)</option>-->
        </select>
        <div class="clear"></div>
        <label id="payathomebox" style="display: block;width: 100%; text-align:center;"><input class="wi-ins08 required" name="fpayathome" id="fpayathome" type="checkbox" value="1" style="margin-left: -3px;" /> Yêu cầu mua trả góp tận nhà</label>
        <div class="clear"></div>
        <input class=" wi-ins07 btn-blue" id="submitinstallment" name="btnBuyInstallMent" type="submit" value="Đặt mua trả góp" />
   </form>
    </div>
    <div class="installright">
        <div class="installrightsp">
            {if !empty($myProduct)}
            <img src="{$myProduct->getSmallImage()}" />
            <span id="{$myProduct->id}" class="productname">{$myProduct->name}</span>
            <div class="priceins">{$myProduct->sellprice|number_format} đ</div>
            {else}
            <span>Không tìm thấy sản phẩm</span>
            {/if}
        </div>
        
        <div class="infoonemonth">
            <span>Tiền góp mỗi tháng</span>
            Tiền góp chỉ mang tính chất tham khảo. Mức góp cụ thể sẽ được thể hiện qua hồ sơ mua trả góp với các đối tác tài chính mà Quý khách lựa chọn.
            <div class="infopay" style="display: none;">
                <ul>
                    <li>Mua trả góp với ACS: <span class="do">~2,180,000 </span>đ/tháng</li>
                    <li>Mua trả góp với PPF: <span class="do">Không hỗ trợ</span></li>
                </ul>
            </div>
        </div>
        <div class="infoonemonth">
            <span>Giới thiệu mua trả góp</span>
                <ul>
                    <li>- Mua trả góp là gì <a href="javascript:parent.location.href='{$conf.rooturl}huong-dan-mua-tra-gop'">Xem thêm</a> </li>
                    <li>- Tôi là sinh viên thì thủ tục mua trả góp như thế nào? <a href="javascript:parent.location.href='{$conf.rooturl}thu-tuc-mua-tra-gop-cho-sinh-vien'">Xem thêm</a>  </li>
                    <li>- Không có hộ khẩu tại nơi đang ở mua trả góp được không? <a href="javascript:parent.location.href='{$conf.rooturl}mua-tra-gop-khong-co-ho-khau'">Xem thêm </a> </li>
                </ul>
        </div>
    </div>
</div>