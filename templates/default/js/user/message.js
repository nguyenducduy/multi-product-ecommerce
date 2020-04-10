

function message_send(requesturl)
{
	$("#messageform form #fsubmit").after('<span class="tmp_indicator"><img src="http://static.r-img.com/images/ajax_indicator.gif" border="0" /> &#272;ang g&#7903;i tin nh&#7855;n c&#7911;a b&#7841;n...</span>');
	
	$("#messageform form #fsubmit").attr('disabled', 'disabled');
	
	var postrequest = $('#messageform form').serialize();
	$('#messagesenderror').html('');
	
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: postrequest,
	   url: requesturl,
	   error: function(){
		   	$("#messageform form #fsubmit").removeAttr('disabled');
			$("#messageform .tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#messageform form #fsubmit").removeAttr('disabled');
			$("#messageform .tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			
			if(success == "1")
			{
				$("#messageform").remove();
				$("body").prepend('<div id="messagesendsuccess">Tin nh&#7855;n c&#7911;a b&#7841;n &#273;&#227; &#273;&#432;&#7907;c g&#7903;i. <br /><br /> &#272;ang chuy&#7875;n t&#7899;i trang tin nh&#7855;n c&#225; nh&#226;n c&#7911;a b&#7841;n...</div>')
				//self.parent.Shadowbox.close();
				//redirect
				self.parent.document.location.href = $(xml).find('message').text();
				
			}
			else
			{
				$('#messagesenderror').html($(xml).find('message').text());
			}
	   }
	 });
}



function message_sendonmobile(requesturl)
{
	$("#messageform form #fsubmit").after('<span class="tmp_indicator"><img src="http://static.r-img.com/images/ajax_indicator.gif" border="0" /> &#272;ang g&#7903;i tin nh&#7855;n c&#7911;a b&#7841;n...</span>');
	
	$("#messageform form #fsubmit").attr('disabled', 'disabled');
	
	var postrequest = $('#messageform form').serialize();
	$('#messagesenderror').html('');
	
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: postrequest,
	   url: requesturl,
	   error: function(){
		   	$("#messageform form #fsubmit").removeAttr('disabled');
			$("#messageform .tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#messageform form #fsubmit").removeAttr('disabled');
			$("#messageform .tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			
			if(success == "1")
			{
				document.location.href = meurl + "/message";
			}
			else
			{
				$('#messagesenderror').html($(xml).find('message').text());
			}
	   }
	 });
}




function message_replysend(requesturl)
{
	$("#msgreplyform form #fsubmit").after('<span class="tmp_indicator"><img src="http://static.r-img.com/images/ajax_indicator.gif" border="0" /> &#272;ang g&#7903;i tin nh&#7855;n c&#7911;a b&#7841;n...</span>');
	
	$("#msgreplyform form #fsubmit").attr('disabled', 'disabled');
	
	var postrequest = $('#msgreplyform form').serialize();
		
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: postrequest,
	   url: requesturl,
	   error: function(){
		   	$("#msgreplyform form #fsubmit").removeAttr('disabled');
			$("#msgreplyform .tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#msgreplyform form #fsubmit").removeAttr('disabled');
			$("#msgreplyform .tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			if(success == "1")
			{
				$.gritter.add({
					title: 'Th&#224;nh c&#244;ng',
					image: imageDir + 'gritter/success.png',
					time: gritterDelay,
					text: message
				});
				
				//clear statux box
				$("#msgreplyform #fmessage").val("");
				
				//show new message to form
				var moremessage = $(xml).find('moremessage').text();
				$('#msgdetail').append(moremessage);
			}
			else
			{
				showGritterError(message);
				$("#msgreplyform #fmessage").focus();
			}
	   }
	 });
}