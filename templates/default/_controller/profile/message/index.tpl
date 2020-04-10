{include file="tinymce.tpl"}
{include file="_controller/profile/message/sidebar.tpl"}

<div id="mailgrid" class="">
	
	<div id="maillist">
	
		<div id="mailboxhead">
			<h1>{if $mailbox == 'isstarred'}{$lang.controller.mStarred}{elseif $mailbox == 'sent'}{$lang.controller.mSent}{elseif $mailbox == 'intrash'}{$lang.controller.mTrash}{else}{$lang.controller.mInbox}{/if}
				{if $formData.fkeywordFilter != ''}<span class="label" style="padding:5px 10px;"><big><big>{$formData.fkeywordFilter} &nbsp;<a href="?mailbox={$mailbox}" style="color:#ccc; font-size:smaller;"><i class="icon-remove"></i></a></big></big></span>{/if}
				{if $total > 0} ({$total}){/if}{if $curPage > 1} #{$lang.default.pageLabel} {$curPage}{/if}</h1>
			
			{if $mailbox != 'intrash'}
			<form action="" method="get">
				<input class="textbox" name="fkeyword" value="{$formData.fkeyword}" placeholder="{$lang.controller.searchPlaceholder}" />
				<input type="hidden" name="mailbox" value="{$mailbox}" />
				<button class="button" type="submit" id="mailboxkeyword"><i class="icon-search"></i></button>
			</form>
			{/if}
		</div><!-- end #mailboxhead -->
		
		<form action="" method="post" name="manage" class="form-inline" onsubmit="return confirm('Are You Sure ?');">
			<input type="hidden" name="ftoken" value="{$smarty.session.settinggroupBulkToken}" />
			<table class="table" id="msglist">

			{if $messageList|@count > 0}

				<tbody>
					{foreach item=message from=$messageList}
						<tr id="mt-{$message->mtid}" rel="{$message->mtid}" class="{cycle values="odd,even"} {if in_array($message->mtid, $myReadIdList)}read{else}unread{/if}">
							{if $mailbox != 'intrash' && $mailbox != 'sent'}<td class="msgcheckbox tipsy-trigger" style="display:none !important;" title="{$lang.controller.selectTitle}"><input type="checkbox" name="fbulkid[]" value="{$message->mtid}" {if in_array($message->mtid, $formData.fbulkid)}checked="checked"{/if}/></td>
							<td class="msgstarred"><a href="javascript:void(0)" onclick="message_starredtoggle({$message->mtid})" class="tipsy-trigger{if in_array($message->mtid, $myStarredIdList)} checked{/if}" title="{$lang.controller.starTitle}"><i class="icon-star"></i></a></td>
							{/if}
							<td class="msgfrom rowlink" id="rowlink-{$message->mtid}"><div class="msgactor"><strong>{$message->actor->fullname}</strong></div></td>
							<td class="msgsummary rowlink" title="{$lang.controller.viewDetailTitle}"><div><strong>{$message->subject}</strong><span>{$message->summary}</span></div></td>
							<td class="msgattachment rowlink">{if $message->countfile > 0}<i class="icon-paper-clip" title="{$lang.controller.hasAttachmentTitle}"></i>{/if}</td>
							<td class="msgmore rowlink">{$message->datemodified|date_format:"%H:%M, %d/%m"}</td>
							<td class="msgtrash">{if $mailbox == 'intrash'}<a href="javascript:void(0)" onclick="message_delete({$message->mtid})" title="{$lang.controller.deleteTitle}"><i class="icon-remove"></i></a>{elseif $mailbox == 'sent'}<a href="javascript:void(0)" onclick="message_senderdelete({$message->mtid})" title="{$lang.controller.deleteTitle}"><i class="icon-remove"></i></a>{else}<a href="javascript:void(0)" onclick="message_trash({$message->mtid})" title="{$lang.controller.moveToTrashTitle}"><i class="icon-trash"></i></a>{/if}</td>
						</tr>
					{/foreach}
				</tbody>


			{else}
				<tr>
					<td colspan="10"> {$lang.controller.messageempty}</td>
				</tr>
			{/if}

			</table>
		</form>
		
		{if $totalPage > 1}
		<div class="pagination">
			{if $formData.fkeywordFilter != ''}
				{assign var=searchkeyword value=$formData.fkeywordFilter}
		   		{assign var="pageurl" value="page/::PAGE::?mailbox=`$mailbox`&fkeyword=`$searchkeyword`"}
			{else}
				{assign var="pageurl" value="page/::PAGE::?mailbox=`$mailbox`"}
			{/if}
			
			{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
		</div> <!-- End .pagination -->
		{/if}

	</div><!-- end #maillist -->
	
	
	


</div><!-- end #mailgrid -->

<div id="emaildetail">
	
	
</div><!-- end #emaildetail -->


<script type="text/javascript">
	var mtid = parseInt('{$smarty.get.mtid}');
	var actiondo = '{$smarty.get.do}';
	
	$(document).ready(function(){
		$('.rowlink').click(function(){
			//detect click on currentmessage
			if($(this).parent().hasClass('currentmessage'))
			{
				$(this).parent().removeClass('currentmessage');
				message_detailclose();
			}
			else
			{
				//remove currentmessage class of all list
				$('#msglist tr').removeClass('currentmessage');

				var mtid = $(this).parent().attr('rel');


				$(this).parent().addClass('currentmessage');
				$(this).parent().removeClass('unread').addClass('read');
				message_detail(mtid);
			}
			
			
		})
		
		
		message_listresize();
		
		//init with selected message
		if(mtid > 0)
		{
			//$('#rowlink-' + mtid).trigger('click');
			message_detail(mtid);
		}
		
		if(actiondo == 'add')
		{
			message_add();
		}
	});

</script>

    
    