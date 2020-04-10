<script  type="text/javascript" src="{$currentTemplate}js/site/popup.js"></script>
<style type="text/css">
	#sb-body {
		border: none !important;
		border-radius: inherit !important;
	}
    .wrap-quickbuy {
        margin: 0;
        border-radius: 0;
        box-shadow:none;
        background: url(http://dienmay.myhost/templates/default/images/site/logo_trungthu.png) no-repeat #eb4c4d;
        border-radius: inherit;
         height: 196px;
    }
    .wrap-quickbuy h3{
        background: #00a1e6;
        color: #fff;
        padding: 10px;
        font-size: 15px;
        font-family: arial;
        text-transform: uppercase;
    }
    #prepaidform{
        width: auto !important;
    }
    
	#prepaidform .qb-left {
	      border: medium none;
		    float: right;
		    margin-right: 46px;
		    width: 360px;
	}
	#prepaidform .inline-qb {
	     color: #FFFFFF;
	    float: left;
	    font-family: arial;
	    font-size: 14px;
	    margin-right: 10px;
	    padding: 4px;
	    text-align: right;
	    width: 80px;
	}
    .qb-left-sp li a{
        color: #00a1e6;
        text-decoration: none;
        font-size: 15px;
    }
    .totalqb{
        font-family: arial !important;
        font-size: 13px !important;
    }
    .infocust input{
         background: none repeat scroll 0 0 #EB4C4D;
	    border: 1px solid #FFFFFF;
	    font-family: arial;
	    font-size: 13px;
	    padding: 5px 10px;
	    width: 240px !important;
	    color: #fff;
    }
    
    .infocust {
	    border-top: 1px solid #FFFFFF;
	    float: left;
	    margin-top: 12px;
	    overflow: hidden;
	    padding-top: 19px;
	}
    .inline-qb span{
        color: red !important;
    }
    .clear{
       margin-bottom: 10px;
    }
    .btnview{
        width: auto !!important;
    }
    #popupbuy{
    	 border-top: 1px solid #FFFFFF;
   		 margin-top: 19px;
    }
    .textrequired{
    color: #FFFFFF;
    float: left;
    font-size: 13px;
    margin-right: 30px;
    padding-top: 12px
    }
    
    .notify-lantern{
      color: #FFFFFF;
    line-height: 20px;
    margin-left: 55px;
    margin-top: 18px;
        font-size: 13px;
    }
    .notify-title{
      background: none repeat scroll 0 0 transparent !important;
   
    font-size: 15px !important;
    padding: 10px 10px 10px 50px !important;
    font-style: italic;
    }
    .notify-content{
    	  border-bottom: 1px solid #FFFFFF;
    border-top: 1px solid #FFFFFF;
    padding: 10px 0 15px;
    }
    
    
</style>
<div class="wrap-quickbuy" id="prepaidform">
    <div class="qb-left">
       
        {if $notify_lantern['win'] == 2}
        	<div class="notify-lantern">
        		<h3 class="notify-title">Chúc mừng bạn</h3>
        		<div class="notify-content">Bạn là người đầu tiên tìm thấy đèn<br>Bạn sẽ nhận được giải thưởng là một chiếc áo cực cool in logo dienmay.com<br>Chúng tôi sẽ liên hệ bạn ngay khi sự kiện kết thúc</div>
        	</div>
        {elseif $notify_lantern['win'] == 3}
        		<div class="notify-lantern">
        		<h3 class="notify-title">Rất tiếc!</h3>
        		<div class="notify-content">Bạn là người thứ <b style="color: yellow;font-size: 20px;">{$notify_lantern['position']}</b> tìm thấy đèn<br>Bạn hãy tiếp tục tìm những đèn khác để nhận được phần thưởng<br><b>Chúc bạn may mắn!</b></div>
        	</div>
        {elseif $notify_lantern['win'] == 1}
        <div class="notify-lantern" style="margin-top: 70px;">
        		<div class="notify-content"><b>Xin lỗi, bạn chỉ có thể trúng thưởng một lần!</b></div>
        	</div>
        {else}
         <div class="infocust">
            <form method="post" action="{$conf.rooturl}{$controller}{if $action!='index'}/{$action}{/if}?id={$lantern}" class="formcheckout">
                <div class="clear"><label class="inline-qb">Họ và tên *</label>
               	<input class="wi_240px required" name="fullnamesub" type="text" maxlength="100" value="{$formData.fullnamesub}" />
                </div>
                 <div class="clear">
                <label class="inline-qb">Email *</label>
                <input class="wi_240px" name="emailsub" type="text" value="{$formData.emailsub}" maxlength="200" />
                </div>
                <div class="clear">
                <label class="inline-qb">Điện thoại *</label>
                <input class="wi_240px required" name="phonesub" type="text" value="{$formData.phonesub}" maxlength="14" />
                </div>

                <div class="buynow2 wi_120px" id="popupbuy">
                	<div class="textrequired">* Vui lòng điền đầy đủ thông tin</div>
                    <input type="submit" value="Xem kết quả ngay" name="btnview" class="submitform" style="width:auto!important;  padding: 5px 10px;background:#C12126;margin-bottom: 3px; margin-top: 7px;text-transform: none;cursor: pointer;" />
                </div>
            </form>
        </div>
        {/if}
    </div>
</div>