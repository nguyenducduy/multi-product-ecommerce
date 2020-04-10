<div id="panelleft">
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		{include file="`$smartyControllerGroupContainer`leftheading-top.tpl"}
			
            <div style="text-align:center"><a href="{$conf.rooturl}register" title="{$lang.default.mRegisterTitle}"><img border="0" src="{$imageDir}button_register.png" alt="{$lang.default.mRegister}" /></a></div>
		{include file="`$smartyControllerGroupContainer`leftheading-bottom.tpl"}	
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
	{include file="notify.tpl" notifyError=$error notifyWarning=$warning}
		<div id="loginform" class="myform myformwide stylizedform">
			
			
			<form id="form1" name="form1" method="post" action="">
				<h1>{$lang.controller.title}</h1>
				<p>{$lang.controller.resetHelp}</p>
				
				<label for="fpassword">{$lang.controller.password}
					<span class="small"></span>
				</label>
				<input type="password" name="fpassword" id="fpassword" value="" />
				<div class="clear"></div>
				
				<label for="fpassword2">{$lang.controller.password2}
					<span class="small"></span>
				</label>
				<input type="password" name="fpassword2" id="fpassword2" value="" />
				<div class="clear"></div>
								
								
				<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
			   
				<div class="spacer"></div>
				
		  </form>
	  </div>
	</div><!-- end #panelright -->
	
	
	
	
	
	
	
	

