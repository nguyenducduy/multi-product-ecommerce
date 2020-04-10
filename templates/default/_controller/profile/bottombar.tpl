<div id="footpanel">
	<ul id="mainpanel"> 
			
		
        <li id="alertpanel">
        	<a href="#" style="text-indent:0"><img class="sp sp16 spmonitor" src="{$imageDir}blank.png" alt="Notification" border="0" /></a>

            <div class="subpanel">
            <h3><span> &ndash; </span>{$lang.default.bottombarNotificationHeading}</h3>
			<div class="viewall"><a href="{$me->getUserPath()}/notification" title="{$lang.default.bottombarNotificationHeadingTitle}">{$lang.default.viewAll}</a></div>
            <ul></ul>
			</div>
			
			<div class="bottombar_redtip{if $me->newnotification == 0} hide{/if}">{$me->newnotification}</div>
        </li>
		
		<li id="alertpanel2">
        	<a href="#" style="text-indent:0"><img class="sp sp16 spmessage" src="{$imageDir}blank.png" alt="Message" border="0" /></a>

            <div class="subpanel">
            <h3><span> &ndash; </span>{$lang.default.bottombarMessageHeading}</h3>
			<div class="viewall"><a href="javascript:void(0)" onclick="message_formadd('{$me->getUserPath()}/message/addajax', '')">{$lang.default.newmessage}</a></div>
            <div class="viewall viewallmain"><a href="{$me->getUserPath()}/message" title="{$lang.default.bottombarMessageHeadingTitle}">{$lang.default.viewAll}</a></div>
			
            <ul></ul>
            </div>
			
			<div class="bottombar_redtip{if $me->newmessage == 0} hide{/if}">{$me->newmessage}</div>
        </li>
		
		
        <li id="friendrequestpanel">
        	<a href="#" class="chat">{$lang.default.mFriendRequest} </a>
			
            <div class="subpanel">
				<h3><span> &ndash; </span>{$lang.default.bottombarFriendRequestHeading}</h3>
				<div class="viewall"><a href="{$me->getUserPath()}/friend/request" title="{$lang.default.mFriendRequestTitle}">{$lang.default.viewAll}</a></div>
				
				<ul></ul>
				
            </div>
			
			<div class="bottombar_redtip{if $me->newfriendrequest == 0} hide{/if}">{$me->newfriendrequest}</div>
        </li>
        
        
	</ul>
</div>


{literal}
<script type="text/javascript">
$(document).ready(function()
{

	setTimeout("bottombar_refresh()", 20000);

});


</script>
{/literal}