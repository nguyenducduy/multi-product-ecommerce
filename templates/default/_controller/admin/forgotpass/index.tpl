<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`leftheading-top.tpl"}
			
            <div style="text-align:center"><a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img border="0" src="{$imageDir}button_register.png" alt="{$lang.default.mRegister}" /></a></div>
		{include file="`$smartyControllerGroupContainer`leftheading-bottom.tpl"}	
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
	{include file="notify.tpl" notifyError=$error notifyWarning=$warning}
		<div id="loginform" class="myform myformwide stylizedform">
			
			
			<form id="form1" name="form1" method="post" action="{$conf.rooturl}forgotpass">
            	<input type="hidden" name="ftoken" value="{$smarty.session.forgotpassToken}" />
				<h1>{$lang.controller.title}</h1>
				<p></p>
				
				<label class="big" for="femail">{$lang.controller.email}
					<span class="small"></span>
				</label>
				<input type="text" name="femail" id="femail" value="{$formData.femail}" />
				<div class="clear"></div>
								
								
				<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
			   
				<div class="spacer"></div>
				
		  </form>
	  </div>
	</div><!-- end #panelright -->
	
	
	<script type="text/javascript">
		
		//load REVIEW AJAX
		$(document).ready(function()
		{literal}{{/literal}
			$('#femail').focus();
		{literal}});{/literal}
		
		
	
	</script>
	
	
	
	
	

