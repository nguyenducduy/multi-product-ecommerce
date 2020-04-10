<div id="bookcomment">
	<div class="head headshort">
		<h2 class="left">{$lang.controller.editTitle}</h2>
		
		
	</div><!-- end .head -->
	
			<div id="commentform" class="myform myformwide stylizedform stylizedform_sub">
				<a name="commentform"></a>
				<form id="formreview" name="form1" method="get" action="">
					
					<label>{$lang.controller.message}</label>
					
					<div class="mentionableinputwrapper">
				 		<textarea class="mentionable" title="{$lang.controller.typeometerTitle}" name="fmessage" id="fmessage" cols="30" rows="8">{$commentmessage}</textarea>
					</div>
					
					<input type="button" class="submit" id="fsubmit" value="{$lang.controller.editSubmit}" onclick="feedCommentEdit({$myFeedComment->id})" />
											
					<div class="spacer"></div>
			
				</form>
			</div><!-- end #commentform -->
		</div><!-- end #bookcomment -->
		