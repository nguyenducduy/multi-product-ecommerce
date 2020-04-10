

function message_send(requesturl)
{
	
	
	//to list
	var fto = []; 
	$('#fto :selected').each(function(i, selected){fto[i] = $(selected).text();});
	var fsubject = encodeURIComponent($('#fsubject').val());
	var fmessage = encodeURIComponent(tinyMCE.get('fmessage').getContent());
	
	var fattachedfd = new Array();
	$("input[name='fattachedfd[]']").each(function(){
	    fattachedfd.push($(this).val());
	});
	
	if(fto.length == 0)
	{
		bootbox.alert("Bạn chưa chọn người nhận tin nhắn.");
		$('#fto').focus();
	}
	else if(fsubject.length == 0)
	{
		bootbox.alert("Bạn chưa nhập tiêu đề.", function(){
			$('#fsubject').trigger('focus');
		});
		
	}
	else if(fmessage.length == 0)
	{
		bootbox.alert("Bạn chưa nhập nội dung.");
	}
	else
	{
		$("#messageform form #fsubmit").after('<span class="tmp_indicator"><img src="'+imageDir+'ajax_indicator.gif" border="0" /> &#272;ang g&#7903;i tin nh&#7855;n c&#7911;a b&#7841;n...</span>');

		$("#messageform form #fsubmit").attr('disabled', 'disabled');
		
		var postrequest = $('#messageform form').serialize() + '&fmessage=' + encodeURIComponent(tinyMCE.get('fmessage').getContent());
		
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
					$("#messageform").before($(xml).find('message').text()).remove();
				}
				else
				{
					$('#messagesenderror').html($(xml).find('message').text());
				}
		   }
		 });
	}
	
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

function message_detail(mtid)
{
	
	
	
	
	if($('#mailgrid').hasClass('mailgridlite'))
	{
		
	}
	else
	{
		$('#maillist').css('overflow', 'hidden');
		$('#mailgrid').addClass('mailgridlite');
		$('#emaildetail').show();
		message_listresize();
	}
	
	
	//request to load message detail
	$('#emaildetail').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl_profile + 'message/detailajax?mtid=' + mtid,
	   error: function(){
			$('#emaildetail').html('Error while load your email. Try again.');
	   },
	   success: function(html){
			$('#emaildetail').html(html);
			
			var limitheight = $('#mailgrid').css('height');
			$('#emaildetail').css('min-height', limitheight).css('max-height', limitheight).css('overflow', 'auto');
			
			if($('#mt-' + mtid).length)
			{
				$('#mt-' + mtid).removeClass('unread').addClass('read');
			}
	   }
	 });
	
}

function message_detailclose()
{
	$('#maillist').css('overflow', 'auto');
	$('#mailgrid').removeClass('mailgridlite');
	$('#emaildetail').html('').hide();
	message_listresize();
}

function message_listresize()
{
	//minimize the maillist
	var maxheight = $(window).height() - 51 - parseInt($('#maillist').css('padding-top')) - parseInt($('#maillist').css('padding-bottom'));
	$('#maillist').css('max-height', maxheight + 'px').css('min-height', maxheight + 'px').css('overflow', 'auto');
}

function message_starredtoggle(mtid)
{
	$('#mt-' + mtid + ' .msgstarred a').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'message/starredtoggleajax?mtid=' + mtid,
	   error: function(){
			$('#mt-' + mtid + ' .msgstarred a').show();
			$('#mt-' + mtid + ' .tmp_indicator').remove();
	   },
	   success: function(xml){
			$('#mt-' + mtid + ' .tmp_indicator').remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				$('#mt-' + mtid + ' .msgstarred a').toggleClass('checked');
			}
			else
			{
				showGritterError(message);
				
			}
			
			$('#mt-' + mtid + ' .msgstarred a').show();
	   }
	 });
	
}

function message_showadd(url)
{
	$('#emailreply, #emailattachment, #emailsubject, #emailpeople').hide();
	
	$('#emailtext').hide().after('<a href="javascript:void(0)" onclick="$(\'#emailtexttoggler\').hide();$(\'#emailreplywrapper\').hide();$(\'#emailtext, #emailattachment, #emailreply, #emailsubject, #emailpeople\').show();" id="emailtexttoggler">Show Full Message</a>');
	$('#emailreplywrapper').show().html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: url,
	   error: function(){
			$('#emailreplywrapper').html('Error while loading.');
	   },
	   success: function(html){
			$('#emailreplywrapper').html(html);
			
			loadtinymce('#fmessage');
			initMessageAjaxUpload('#ffile');			
	   }
	 });
}


function message_trash(mtid)
{
	$('#mt-' + mtid + ' .msgtrash a').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'message/trashtoggleajax?mtid=' + mtid,
	   error: function(){
			$('#mt-' + mtid + ' .msgtrash a').show();
			$('#mt-' + mtid + ' .tmp_indicator').remove();
	   },
	   success: function(xml){
			$('#mt-' + mtid + ' .tmp_indicator').remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				$('#mt-' + mtid).fadeOut('fash', function(){
					$(this).remove();
				});
			}
			else
			{
				showGritterError(message);
				$('#mt-' + mtid + ' .msgtrash a').show();
				
			}
			
			
	   }
	 });
}


function message_delete(mtid)
{
	$('#mt-' + mtid + ' .msgtrash a').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'message/deleteajax?mtid=' + mtid,
	   error: function(){
			$('#mt-' + mtid + ' .msgtrash a').show();
			$('#mt-' + mtid + ' .tmp_indicator').remove();
	   },
	   success: function(xml){
			$('#mt-' + mtid + ' .tmp_indicator').remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				$('#mt-' + mtid).fadeOut('fash', function(){
					$(this).remove();
				});
			}
			else
			{
				showGritterError(message);
				$('#mt-' + mtid + ' .msgtrash a').show();
				
			}
			
			
	   }
	 });
	
}


function message_senderdelete(mtid)
{
	$('#mt-' + mtid + ' .msgtrash a').after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'message/senderdeleteajax?mtid=' + mtid,
	   error: function(){
			$('#mt-' + mtid + ' .msgtrash a').show();
			$('#mt-' + mtid + ' .tmp_indicator').remove();
	   },
	   success: function(xml){
			$('#mt-' + mtid + ' .tmp_indicator').remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				$('#mt-' + mtid).fadeOut('fash', function(){
					$(this).remove();
				});
			}
			else
			{
				showGritterError(message);
				$('#mt-' + mtid + ' .msgtrash a').show();
				
			}
			
			
	   }
	 });
	
}


function message_add()
{
	$('#maillist').css('overflow', 'hidden');
	$('#mailgrid').addClass('mailgridlite');
	$('#emaildetail').show().html('');
	message_listresize();
	
	
	//request to load message detail
	$('#emaildetail').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl_profile + 'message/add',
	   error: function(){
			$('#emaildetail').html('Error while load form. Try again.');
	   },
	   success: function(html){
			$('#emaildetail').html(html);
			
			var limitheight = $('#mailgrid').css('height');
			$('#emaildetail').css('min-height', limitheight).css('max-height', limitheight).css('overflow', 'auto');
			
			loadtinymce('#fmessage');
			
			initMessageAjaxUpload('#ffile');
	   }
	 });
	
}



function initMessageAjaxUpload(selector)
{
	//load uploadifive
	$(selector).uploadifive({
	        'uploadScript' : rooturl_profile + 'file/uploadajax?from=message',
			'fileObjName' : 'ffile',
			'buttonClass' : 'messageajaxuploadbtn',
			'buttonText' : '<i class="icon-paper-clip"></i> Đính kèm file..',
			'onUploadComplete': function(file, data){
				var queue = file.queueItem;
				console.log(file);
				
				var html = '<input type="hidden" name="fattachedfd['+data+']" value="'+file.name+'" />';
				$(queue).append(html);
			}
	    });
}