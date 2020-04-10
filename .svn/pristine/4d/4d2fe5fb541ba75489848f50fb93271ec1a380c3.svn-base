<div id="bookcomment">
			
			
			<div class="head">
				<h2 class="left">{$lang.controller.reviewToBook} "<em>{$myBook->title}</em>"</h2>
				
				
			</div><!-- end .head -->
			
			
			<div id="commentform" class="myform myformwide stylizedform stylizedform_sub">
				<p>{$lang.controller.reviewHelp}</p>
				<a name="commentform"></a>
				<form id="formreview" name="form1" method="get" action="">
					
					<label>{$lang.controller.reviewMessage}</label>
					
					<div class="mentionableinputwrapper">
				 		<textarea class="mentionable" title="{$lang.controller.typeometerTitle}" name="fmessage" id="fmessage" cols="30" rows="8">{$smarty.session.reviewAutosave}</textarea>
					</div>
					
					<div id="fmessage-typeometer" title="{$lang.controller.typeometerTitle}">
						<div class="typeometer-left"><div class="typeometer-bar"></div></div>
						<div class="typeometer-right"></div>
					</div>
					
					<input type="button" class="submit" id="fsubmit" value="{$lang.controller.reviewSubmit}" onclick="bookreviewAdd('{$myBook->getBookPath()}/review/addajax', {$myBook->id})" />
											
					<div class="spacer"></div>
			
				</form>
			</div><!-- end #commentform -->
		</div><!-- end #bookcomment -->
		
		{literal}
		<script type="text/javascript">
		
		
		
		
		$(document).ready(function()
		{
			
			
			
			//$('#fmessage').autoResize({limit : 300}).focus();
			
			$('#fmessage').keyup(function(){
				var maxchar = 2000;
				var cchar = $(this).val().length;
				var rep = 0;
				if(cchar < 100) rep = 0;
				else if(cchar < 400) rep = 15;
				else if(cchar < 800) rep = 30;
				else if(cchar < 1600) rep = 45;
				else rep = 60;
				
				var percent = Math.round(cchar / maxchar * 100);
				if(percent > 100) percent = 100;
				
				$('#fmessage-typeometer .typeometer-right').html(cchar + ' k&#237 t&#7921 (+' + rep + ' REP)');
				$('#fmessage-typeometer .typeometer-bar').css('width', percent + '%').attr('title', cchar + ' characters');
			});
			
			
			
		});
		</script>
		{/literal}