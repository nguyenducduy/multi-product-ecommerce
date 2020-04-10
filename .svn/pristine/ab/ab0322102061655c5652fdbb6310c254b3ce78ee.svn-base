<div id="panelleft">
		
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<ul id="msgtab">
			<li><a href="{$conf.rooturl}profile">{$lang.controller.tabAccount}</a></li>
			<li><a href="{$conf.rooturl}profile/info">{$lang.controller.tabProfile}</a></li>
			<li><a class="selected" href="{$conf.rooturl}profile/privacy" title="">{$lang.controller.tabPrivacy}</a></li>
			<li><a href="{$conf.rooturl}profile/changepassword">{$lang.controller.tabChangepassword}</a></li>
		</ul>
		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
        
	  <div id="changeprivacyform" class="myform myformwide stylizedform">
			<form id="form1" name="form1" method="post" action="{$conf.rooturl}profile/privacy">
				<h1>{$lang.controller.changeprivacysetting}</h1>
				<p></p>
				
				 <label>{$lang.controller.privacyAccess}</label>
				<select id="fprivacy" name="fprivacy">
					<option value="8" {if $formData.fprivacy == '8'}selected="selected"{/if}>{$lang.controller.privacyInternet}</option>
					<option value="2" {if $formData.fprivacy == '2'}selected="selected"{/if}>{$lang.controller.privacyFriend}</option>
					<option value="1" {if $formData.fprivacy == '1'}selected="selected"{/if}>{$lang.controller.privacyMe}</option>
				</select>
				<div class="text_nowidth">{$lang.controller.privacyAccessHelp}</div>
				<div class="clear"></div>
				
				
				
				<input type="submit" class="submit" name="fsubmitprivacy" value="{$lang.controller.submitLabel}" />
				<div class="spacer"></div>
		
		  </form>
	  </div><!-- end #changeprivacyform -->
	  
	  
	  
	  
	</div><!-- end #panelright -->
    
    
	