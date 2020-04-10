<div id="panelleft">
		
		
		{include file="`$smartyControllerGroupContainer`topnav.tpl"}
		
		
	</div><!-- end #panelleft -->
	
	<div id="panelright">
		
		<ul id="msgtab">
			<li><a class="selected" href="{$conf.rooturl}profile">{$lang.controller.tabAccount}</a></li>
			<li><a href="{$conf.rooturl}profile/info">{$lang.controller.tabProfile}</a></li>
			<li><a href="{$conf.rooturl}profile/privacy" title="">{$lang.controller.tabPrivacy}</a></li>
			<li><a href="{$conf.rooturl}profile/changepassword">{$lang.controller.tabChangepassword}</a></li>
		</ul>
		
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		
        <div id="avatarform">
        	<div class="form-avatar">
				<input type="hidden" name="favatar" id="favatar" />
				<div class="form-avatar-image"><img src="{$me->getSmallImage()}" alt="avatar placeholder" /></div>
				<div class="form-avatar-heading"{if $me->avatar != ''} style="display:none;"{/if}>{$lang.controller.noavatar}</div>	
				<div class="form-avatar-heading-alt"{if $me->avatar == ''} style="display:none;"{/if}>{$lang.controller.haveavatar}</div>	
				<div class="form-avatar-buttons"{if $me->avatar != ''} style="display:none;"{/if}>
					<a href="{$conf.rooturl}profile/avatarupload" rel="shadowbox;width=960px;height=640px" title="" class="sp sptext spbtnavatarupload">Upload</a>
					<a href="{$conf.rooturl}profile/avatarwebcam" rel="shadowbox;width=960px;height=640px" title="" class="sp sptext spbtnavatarwebcam">Webcam</a>
				</div>
				<div class="form-avatar-buttons-alt"{if $me->avatar == ''} style="display:none;"{/if}>
                	<a href="{$conf.rooturl}profile/avatareditor" rel="shadowbox;width=960px;height=640px" title="" class="sp sptext spbtnavataredit">Edit</a>
					<a href="javascript:delm('{$conf.rooturl}profile?deleteavatar={$smarty.session.avatarDeleteToken}')" title="" class="sp sptext spbtnavatardelete">Delete</a>
                    
					<div class="removeavatar-notification"></div>
					
				</div>
				<div class="form-avatar-text"{if $me->avatar != ''} style="display:none;"{/if}>{$lang.controller.avatarHelp}</div>
                <div class="clear"></div>
			</div><!-- end class:form-avatar -->
        </div>
        
		
	  
		<div id="profileform" class="myform myformwide stylizedform">
			<form id="form1" name="form1" method="post" action="{$conf.rooturl}profile">
				<h1>{$lang.controller.titleAccount} {if $me->email != ''}&lt;{$me->email}&gt;{/if}</h1>
				<p></p>
                
                <label>{$lang.controller.screenname}
					<span class="small"></span>
				</label>
               
				<input type="text" name="fscreenname" id="fscreenname" size="32" value="{$formData.fscreenname}" onkeyup="javascript:$('#screenname_holder').text($('#fscreenname').val());" />
                 <div class="text_nowidth">{$conf.rooturl}<span id="screenname_holder">{$formData.fscreenname}</span></div>
				
				<div class="clear"></div>
				<label>&nbsp;</label>
				<div class="inputwide text" style="width:400px">{$lang.controller.screennameHelp}</div>
				<div class="clear"></div>
				
				
                
                
				<label>{$lang.controller.fullname}
					<span class="small"></span>
				</label>
				<input type="text" name="ffullname" id="ffullname"  value="{$formData.ffullname}" />
               	<div class="clear"></div> 
                <label>&nbsp;</label>
				<div class="inputwide text" style="width:400px">{$lang.controller.fullnameHelp}</div>
				<div class="clear"></div>
                                    
                
				
				<input type="submit" class="submit" name="fsubmit" value="{$lang.controller.submitLabel}" />
				<div class="spacer"></div>
		
		  </form>
	  </div><!-- end #profileform -->
	  
     
	  
	  
	</div><!-- end #panelright -->
    
    