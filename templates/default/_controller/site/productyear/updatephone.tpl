<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Top product home</title>
<link href="{$currentTemplate}css/site/style_topproduct.css" rel="stylesheet" type="text/css">

</head>

<body>
<div class="wrap-popup">
	<div class="email-popup">
	<form action="" method="post" name="myform" class="form-horizontal">
		<div class="email-box">
        	
        	<div class="bar-popup">Vui lòng đăng nhập để tham gia viết bài</div>
            <div class="close-popup"><a href="{$conf.rooturl}productyear/logout"><img src="{$currentTemplate}images/site/close-bt.png"></a></div>
            
        	<p>Vui lòng nhập chính xác số điện thoại của bạn để dienmay.com có thể liên lạc  trong trường hợp bạn trúng giải</p>
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
            <div class="ctrl-form">
                <label class="label-review">Số điện thoại:</label>
                <input name="fphone" class="input-email">
            </div>
            <div class="ctrl-form">
                <input name="fsubmit" class="bt-send" type="submit" value="Xác nhận">
                <input type="hidden" name="ftoken" value="{$smarty.session.PhoneToken}" />
            </div>
        </div>  
        </form>
    </div>
</div>
</body>
</html>
