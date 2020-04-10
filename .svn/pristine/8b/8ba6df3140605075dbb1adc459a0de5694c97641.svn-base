<div id="panelleft">

	{include file="`$smartyControllerGroupContainer`topnav.tpl"}

	{include file="`$smartyControllerGroupContainer`panel-introbox.tpl" disableregisterbutton=1}

	{include file="`$smartyControllerGroupContainer`hotshelf.tpl"}
</div><!-- end #panelleft -->

<div id="panelright">
	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
	<div id="loginform" class="myform myformwide stylizedform">
		<form id="form1" name="form1" method="post" action="">
			<input type="hidden" name="ftoken" value="{$smarty.session.userRegisterToken}"/>

			<h1>{$lang.controller.title}</h1>

			<p>{if $smarty.get.notoauth != 1}{$lang.controller.loginhelp} <a href="{$conf.rooturl}login"
																			 title="{$lang.controller.loginhelplinkTitle}">{$lang.controller.loginhelplink}</a>{/if}
			</p>
			<label>{$lang.controller.fullname}
				<span class="small"></span>
			</label>
			<input type="text" name="ffullname" id="ffullname" value="{$formData.ffullname}"/>

			<div class="text formmoreinfo">{$lang.controller.fullnameHelp}</div>
			<div class="clear"></div>
			<label>{$lang.controller.email}
				<span class="small"></span>
			</label>
			<input type="text" name="femail" id="femail" value="{$formData.femail}"/>

			<div class="text formmoreinfo">{$lang.controller.emailHelp}</div>
			<div class="clear"></div>
			<label>{$lang.controller.password}
				<span class="small"></span>
			</label>
			<input type="password" name="fpassword1" id="fpassword1"/>

			<div class="text formmoreinfo">{$lang.controller.passwordHelp}</div>
			<div class="clear"></div>
			<label>{$lang.controller.passwordconfirm}
				<span class="small"></span>
			</label>
			<input type="password" name="fpassword2" id="fpassword2"/>

			<div class="text formmoreinfo">{$lang.controller.passwordconfirmHelp}</div>
			<div class="clear"></div>
			<label>{$lang.controller.securityCode}

			</label>


			<input type="text" name="fcaptcha" id="fcaptcha"/>

			<div class="text formmoreinfo">{$lang.controller.securityCodeTip}<br/><a class="labellink"
																					 href="javascript:void(0);"
																					 onclick="javascript:reloadCaptchaImage();"
																					 title="">{$lang.controller.refreshImage}</a>
			</div>
			<br/><br/><br/>

			<div class="clear"></div>

			<label>&nbsp;</label>

			<div class="text_nowidth"><img id="captchaImage" src="{$conf.rooturl}captcha" alt=""/></div>
			<div class="clear"></div>


			<label>&nbsp;
				<span class="small"></span>
			</label>
			<small>
				<label class="normal"><input type="checkbox" name="ftos" value="1" class="checkbox checkboxcl"
											 {if isset($formData.fsubmit)}{if isset($formData.ftos)}checked="checked"
											 {/if}{else}checked="checked"{/if} /><big>{$lang.controller.agreement}</big></label>

			</small>
			<div class="clear"></div>

			<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}"/>

			<div class="spacer"></div>

		</form>
	</div>
</div><!-- end #panelright -->

<script type="text/javascript">
	//load REVIEW AJAX
	$(document).ready(function () {literal}{{/literal}
		$('#ffullname').focus();
		{literal}
	});
	{/literal}
</script>
	
	
	
	
	
	
	