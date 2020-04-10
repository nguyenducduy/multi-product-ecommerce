<div class="bodymember">
<div class="logsigndm">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div class="barMB">Nộp hồ sơ tuyển dụng</div>
	<form action="" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="ftoken" value="{$smarty.session.addJobcvToken}" />
	    <input type="hidden" name="fjid" value="{$job->id}" />
		<div class="iconinput"><label class="labelMB">Công việc</label><span><input class="inputmember" value="{$job->title}" type="text" readonly="readonly" /></span></div>
		<div class="iconinput"><label class="labelMB">Tiêu đề<span>*</span></label><input class="inputmember" name="ftitle" type="text" value="{$formData.ftitle|@htmlspecialchars}" placeholder="Tối đa 150 ký tự"  /></div>
		<div class="iconinput"><label class="labelMB">Hồ sơ<span>*</span></label><input type="file" name="ffile" id="ffile" /></div>
		<div class="iconinput"><label class="labelMB">Họ <span>*</span></label><input class="inputmember" name="ffirstname" type="text" value="{$formData.ffirstname}" /></div>
		<div class="iconinput"><label class="labelMB">Tên <span>*</span></label><input class="inputmember" name="flastname" type="text" value="{$formData.flastname}" /></div>
		<div class="iconinput"><label class="labelMB">Ngày sinh <span>*</span></label>
			<select name="fdate" style="width:67px; height:30px;">
	            <option value="0">---</option>
	            {section name=date start=1 loop=32 step=1}<option value="{$smarty.section.date.index}" {if $formData.fdate == $smarty.section.date.index}selected="selected"{/if}>{if $smarty.section.date.index < 10}0{/if}{$smarty.section.date.index}</option>{/section}
	        </select> &nbsp; / &nbsp;
	        <select name="fmonth" style="width:67px; height:30px;">
	            <option value="0">---</option>
	            {section name=month start=1 loop=13 step=1}<option value="{$smarty.section.month.index}" {if $formData.fmonth == $smarty.section.month.index}selected="selected"{/if}>{if $smarty.section.month.index < 10}0{/if}{$smarty.section.month.index}</option>{/section}
	        </select>&nbsp; / &nbsp;
	        <input type="text" name="fyear" value="{$formData.fyear}" style="width: 72px; height:30px;" />
		</div>
		<div class="iconinput"><label class="labelMB">Email<span>*</span></label><input class="inputmember" name="femail" value="{$formData.femail}" type="text" /></div>
		<div class="iconinput"><label class="labelMB">Điện thoại<span>*</span></label><input class="inputmember" name="fphone" type="text" value="{$formData.fphone}" type="text" /></div>
		<div class="iconinput"><label class="labelMB">Mã an toàn <span>*</span></label><input class="inputmember" type="text" name="fcaptcha" /></div>
		<div class="iconinput"><label class="labelMB"></label><a class="labellink" href="javascript:void(0);" onclick="javascript:reloadCaptchaImage();" title="">Refresh</a><img id="captchaImage" src="{$conf.rooturl}captcha" alt="" /></div>
		<input name="fsubmit" type="submit" class="btnmember" value="Nộp hồ sơ" />
	</form>
</div>
</div>
{literal}
<script type="text/javascript">
function reloadCaptchaImage()
{
    var timestamp = new Date();

    $("#captchaImage").attr('src', rooturl + "captcha?random=" + timestamp.getTime());
}
</script>
{/literal}