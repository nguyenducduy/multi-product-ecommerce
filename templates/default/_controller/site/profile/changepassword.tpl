<div id="panelleft">
		
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<ul id="msgtab">
			<li><a href="{$conf.rooturl}profile">{$lang.controller.tabAccount}</a></li>
			<li><a href="{$conf.rooturl}profile/info">{$lang.controller.tabProfile}</a></li>
			<li><a href="{$conf.rooturl}profile/privacy" title="">{$lang.controller.tabPrivacy}</a></li>
			{if $me->oauthPartner == 0}<li><a class="selected" href="{$conf.rooturl}profile/changepassword">{$lang.controller.tabChangepassword}</a></li>{/if}
		</ul>
		
		
       {include file="notify.tpl" notifyError=$error notifySuccess=$success}
	  
      {if $me->oauthPartner == 0}
	  <div id="changepassform" class="myform myformwide stylizedform">
			<form id="form1" name="form1" method="post" action="{$conf.rooturl}profile/changepassword">
				<h1>{$lang.controller.changepass}</h1>
				<p></p>
				<label>{$lang.controller.oldpass}
					<span class="small"></span>
				</label>
				<input type="password" name="foldpass" id="foldpass" />
				<div class="clear"></div>
				
				<label>{$lang.controller.newpass1}
					<span class="small"></span>
				</label>
				<input type="password" name="fnewpass1" id="fnewpass1" />
				<div class="clear"></div>
				
				<label>{$lang.controller.newpass2}
					<span class="small"></span>
				</label>
				<input type="password" name="fnewpass2" id="fnewpass2" />
				<div class="clear"></div>
				
				
				
				<input type="submit" class="submit" name="fsubmitpassword" value="{$lang.controller.submitLabel}" />
				<div class="spacer"></div>
		
		  </form>
	  </div><!-- end #changepassform -->
      {/if}
	  
	 	  
	  
	</div><!-- end #panelright -->
    
    
	
	
	
	
	