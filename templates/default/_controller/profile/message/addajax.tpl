{if $smarty.get.type == ''}
	<div id="emailsubject">
		<div class="emailcontrol">
			<a href="javascript:void(0)" onclick="message_detailclose()" class="close"><i class="icon-remove"></i></a>
		</div>

		<h2>{$lang.controller.createtitle}</h2>

	</div>
{/if}

	
	<div id="maillist">
		{if $smarty.get.type != ''}
		<div class="page-header" rel="menu_message" style="border-top-width:0;"><h1>{if $smarty.get.type == 'reply'}{$lang.controller.titleReply}{elseif $smarty.get.type == 'replyall'}{$lang.controller.titleReplyall}{elseif $smarty.get.type == 'forward'}{$lang.controller.titleForward}{/if}</h1></div>
		{/if}


		<div id="messageform">
			<div id="messagesenderror"></div>
	
			<form action="" method="post" name="myform" class="">
				<input type="hidden" name="ftoken" id="ftoken" value="{$smarty.session.messageToken}" />
	

				<div class="control-group">
					<label class="control-label" for="fto">{$lang.controller.sendto} <span class="star_require">*</span></label>
					<div class="controls">
						<div id="msgcontactautocomplete" class="hide"></div>
						<select id="fto" name="fto[]" multiple="multiple" size="4" class="autocompleteuser">
							{foreach item=recipient from=$recipientList}
								<option value="{$recipient->id}" class="selected">{$recipient->fullname}</option>
							{/foreach}
						</select>
					</div>
				</div>
		
				<div class="control-group">
					<label class="control-label" for="fsubject">{$lang.controller.subject} <span class="star_require">*</span></label>
					<div class="controls">
						<input type="text" name="fsubject" id="fsubject" value="{$formData.fsubject}" class="input-xxlarge">
					</div>
				</div>
	
				<div class="control-group">
					<label class="control-label" for="fmessage">{$lang.controller.message} <span class="star_require">*</span></label>
					<div class="controls"><textarea id="fmessage" cols="30" rows="6" class="tinymce input-xlarge">{$formData.fmessage}</textarea></div>
				</div>
				
				<div class="control-group">
					<div class="controls" id="attachmentaddform">
						<input type="file" id="ffile" name="ffile" multiple="multiple" />
					</div>
					
					<div id="attachmentdefault">
						{if $attachmentList|@count > 0}
							{foreach item=attachment from=$attachmentList}
								<div class="uploadifive-queue-item complete" id="uploadifive-ffile-file-{$attachment->id}">                        
									<a class="close" href="javascript:void(0)" onclick="$('#uploadifive-ffile-file-{$attachment->id}').fadeOut('fast', function(){
										$(this).remove();
									});">X</a>                        
									<div>
										<span class="filename">{$attachment->name}</span>
										<span class="fileinfo">- {$attachment->filedrive->getDisplaySize()}</span>
									</div>                        
									<input type="hidden" name="fattachedfd[{$attachment->fdid}]" value="{$attachment->name}" />
								</div>
							{/foreach}
						{/if}
					</div>
				</div>
	
				<div class="form-actions">
					<input type="button" id="fsubmit" onclick="message_send('{$me->getUserPath()}/message/add')" name="fsubmit" value="{$lang.controller.sendbtn}" class="btn btn-large btn-primary" />
					<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
				</div>	
	
			</form>
		</div>
	</div><!-- end #maillist -->
	
<script type="text/javascript">
	//autocomplete for search MULTI user
	$(".autocompleteuser").fcbkcomplete({
				json_url: rooturl_admin + "user/autocompleteajax",
				addontab: true,                   
				maxitems: 20,
				height: 8,
				bricket: false,
				firstselected: true
			});
			

</script>

