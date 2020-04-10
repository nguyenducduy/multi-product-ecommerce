<div id="mailsidebar">
	<a id="mailcompose" href="javascript:void(0)" onclick="message_add()">{$lang.controller.compose}</a>
	
	<ul class="mailboxgroup">
		<li><a {if $action == 'index' && $mailbox == 'inbox'}class="active"{/if} href="{$conf.rooturl_profile}message"><i class="icon-inbox"></i> {$lang.controller.mInbox}</a></li>
		<li><a {if $action == 'index' && $mailbox == 'isstarred'}class="active"{/if} href="{$conf.rooturl_profile}message?mailbox=isstarred"><i class="icon-star"></i> {$lang.controller.mStarred}</a></li>
		<li><a {if $action == 'index' && $mailbox == 'sent'}class="active"{/if} href="{$conf.rooturl_profile}message?mailbox=sent"><i class="icon-share-alt"></i> {$lang.controller.mSent}</a></li>
		<li><a {if $action == 'index' && $mailbox == 'intrash'}class="active"{/if} href="{$conf.rooturl_profile}message?mailbox=intrash"><i class="icon-trash"></i> {$lang.controller.mTrash}</a></li>
	</ul>
</div><!-- end #mailsidebar -->