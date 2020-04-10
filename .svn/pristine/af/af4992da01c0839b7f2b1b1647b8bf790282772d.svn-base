


<div class="post-wrap">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="titlepost">Gửi câu hỏi</div>

		<form method="POST" action="">
			<input type="hidden" name="ftoken" value="{$smarty.session.faqAddToken}">
			{if $me->id == 0}
			<label class="posttext">Họ tên <span class="postfred">*</span></label>
			<input class="inputpost" type="text" name="ffullname" value="{$formData.ffullname}"/> <br />
			{/if}
			
			<label class="posttext">Nội dung <span class="postfred">*</span></label>
			<textarea class="areapost" rows="5" type="text" name="ftitle" value="{$formData.ftitle}"></textarea> (Tối đa 300 ký tự)<br />

			<input class="nutpost" type="submit" name="fsubmit" value="Gửi câu hỏi" />
		</form>

</div>

	

{literal}
<style>
	.titlepost{ text-transform:uppercase; font:normal 18px Arial; color:#00a1e5; padding:10px}
	.post-wrap{width:500px; overflow:hidden; margin:40px auto; font:normal 12px Arial; color:#888; background-color: white;}
	.posttext{float:left;width:60px; color:#333; line-height:20px; text-align:right;vertical-align:middle}
	.inputpost{ outline:none;width: 300px;padding: 4px 6px;border-radius: 3px;border: 1px solid #ccc;line-height: 20px;margin-left: 15px;vertical-align:middle; margin-bottom:8px}
	.areapost{width: 300px;padding: 4px 6px;border-radius: 3px;border: 1px solid #ccc;line-height: 20px;margin-left: 15px; vertical-align:middle; outline:none}
	
	.nutpost {
	margin:10px auto;
    display:block;
    font:normal 14px Arial !important;
    text-shadow:1px 1px 0 #006dc5 !important;
    padding: .4em 0.6em ;
	color: #fff !important;
	border:1px solid #0090cd;
	border-radius:4px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.5);
	
	background-color: #00a1e5;
    background-image: -moz-linear-gradient(top, #00a1e5, #0086be);
    background-image: -ms-linear-gradient(top, #00a1e5, #0086be);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#00a1e5), to(##0086be));
    background-image: -webkit-linear-gradient(top, #00a1e5, #0086be);
    background-image: -o-linear-gradient(top, #00a1e5, #0086be);
    background-image: linear-gradient(top, #00a1e5, #0086be);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00a1e5', endColorstr='#0086be', GradientType=0);
    filter: progid:dximagetransform.microsoft.gradient(enabled=false);
}
.nutpost:hover { background: #079eed; text-decoration:none !important;}
.nutpost:active {color: #fff; background: #079eed;}

.postfred{font:normal 12px Arial; color:red}

/*    NOTIFY BAR    */
.notify-bar{padding:10px;border-radius: 8px; -moz-border-radius: 8px; -webkit-border-radius: 8px;margin-bottom:10px;}
.notify-bar-success{background:#eaffa5;color:#6c8c00;}
.notify-bar-error{background:#ffcfce;color:#9e3737;}
.notify-bar-warning{background:#ffeeb1;color:#e37b00;}
.notify-bar-info{background:#d6e2ff;color:#577bd1;}
.notify-bar-icon{float:left;width:45px;}
.notify-bar-text{padding:0 20px 0 45px; font-size:14px;line-height:1.5;}
.notify-bar-text-sep{border-top:1px solid #eee;margin:10px 0;}
.notify-bar-button{float:right;width:15px;text-align:right;}
</style>
{/literal}
