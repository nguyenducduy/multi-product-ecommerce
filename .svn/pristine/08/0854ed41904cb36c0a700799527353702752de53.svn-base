//jquery fx begin
$(document).ready(function()
{

	Shadowbox.init({
		fadeDuration: 0.1,
		onOpen: SBopen,
		onClose: SBclose
	});
	
	var activemenu = $('.page-header').attr('rel');
	var activemenuselector = $('#' + activemenu);
	if(activemenuselector.length)
	{
		activemenuselector.addClass('active');
	}
	
	// Check all checkboxes when the one in a table head is checked:

	$('.check-all').click(
		function(){
			$(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $(this).is(':checked'));   
		}
	);
	
	//left menu toggle
	$('.nav-header').click(function(){
		
		var currentshow = false;
		
		if($(this).find('ul').is(":visible"))
			currentshow = true;
		
		$('.nav-header ul').slideUp('fast');
		
		if(!currentshow)
			$(this).find('ul').slideDown('fast');
	});
	
	$('.nav-header li.active').parent().show();
	
	
	
	//left box toggle
	$('.sidebar-nav h2').click(function(){
		
		if($('.moresidemenuactive').length > 0)
		{
			$('.moresidemenuactive').removeClass('moresidemenuactive');
			$('#moresidemenu').hide();
			$('#container').removeClass('span8').addClass('span10');
		}
		
		var currentshow = false;
		if($(this).next().is(":visible"))
			currentshow = true;
			
		$('.sidebar-nav .nav-list').slideUp('fast');
		if(!currentshow)
			$(this).next().slideDown('fast');
	});
	
	$('.nav-header li.active').parent().show();
	
	
	$('.useridpopup').bind('click', function(){
		$(this).attr('title', 'Click to Search and Select User ID');
		var elementid = $(this).attr('id');
		window.open (rooturl_admin + "user/searchid?elementid=" + elementid,"mywindow","menubar=1,resizable=1,width=1000,height=600");
	
	});
	
	$('.moresidemenu').bind('click', function(){
		if($(this).hasClass('moresidemenuactive'))
		{
			$(this).removeClass('moresidemenuactive');
			$('#moresidemenu').hide();
			$('#container').removeClass('span8').addClass('span10');
		}
		else
		{
			$(this).addClass('moresidemenuactive');
			$('#moresidemenu').show().height($('#navbar').height());
			$('#container').removeClass('span10').addClass('span8');
		}
	});
	
	bottombar_init();
	loadUserInfo();
	
	//save current visted link of this page
	lastvisit_save();
	
	//////
	// toggle full width
	$('#container').prepend('<a class="fullwidthbutton" href="javascript:void(0)" onclick="fullwidthtoggle(0)" title="Toggle Full Width"><i class="icon-resize-full" /><i class="icon-resize-small" style="display:none;" /></a>');
	
	if($.cookie('containerfullwidth') == '1')
	{
		fullwidthtoggle(1);
	}
	
	
	// - end toggle fullwidth
	////
	
});


function fullwidthtoggle(force)
{
	//detect current mode
	if($('#container').hasClass('containerfullwidth') == false || force == 1)
	{
		$('#container').addClass('containerfullwidth').removeClass('span10').addClass('span12');
		$('#navbar, #moresidemenu').hide();
		$.cookie('containerfullwidth', '1', {path: '/'});
		$('.fullwidthbutton .icon-resize-small').show();
		$('.fullwidthbutton .icon-resize-full').hide();
		
	}
	else
	{
		//current is fullwidth, minimize screen
		$('#container').removeClass('containerfullwidth').removeClass('span12').addClass('span10');
		$('#navbar').show();
		$.cookie('containerfullwidth', '0', {path: '/'});
		$('.fullwidthbutton .icon-resize-small').hide();
		$('.fullwidthbutton .icon-resize-full').show();
	}
}

// JavaScript Document
function delm(theURL)
{
	bootbox.confirm(delConfirm, function(confirmed){
		if(confirmed)
			window.location.href=theURL;
	})	  
}


function scrollTo(selector)
{
	var target = $('' + selector);
	if (target.length)
	{
		var top = target.offset().top;
		$('html,body').animate({scrollTop: top}, 1000);
		return false;
	}	
}

//use this function to keep connection (prevent login session expired for contents manipulation) alive
function ping()
{
	var nulltimestamp = new Date().getTime();
	var t = setTimeout("ping()", 1000*60*5); //5 minute
    $.ajax({
		 type: "GET",
		 url: rooturl_admin + 'null/index/timestamp/' + nulltimestamp,
		 dataType: "xml",
		 success: function(xml) {}
	 }); //close $.ajax
}


function showGritterSuccess(msg)
{
	if(msg.length == 0)
	{
		msg = 'Th&#244ng tin c&#7911a b&#7841n &#273&#227 &#273&#432&#7907c l&#432u.';
	}
	
	$.gritter.add({
					title: 'Th&#224nh c&#244ng',
					image: imageDir + 'gritter/success.png',
					time: gritterDelay,
					text: msg
				});
}

/**
* Show gritter error box, most using in ajax request, error request
*/
function showGritterError(msg)
{
	if(msg.length == 0)
	{
		msg = 'Request Data Error';
	}
	
	 $.gritter.add({
					title: 'Lỗi',
					image: imageDir + 'gritter/error.png',
					time: gritterDelay,
					text: msg
				});

}


/* LAST VISIT FEATURE */
function lastvisit_save()
{
	var pageTitle = $(document).attr('title');
	var pageUrl = $(location).attr('href');	
	
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'ftitle='+encodeURIComponent(pageTitle)+'&furl=' + encodeURIComponent(pageUrl),
	   url: rooturl_cms + 'lastvisit/addajax',
	   error: function(){
	   },
	   success: function(xml){
	   }
	 });	
}


function lastvisit_load()
{
	$('#lastvisit').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl_cms + 'lastvisit/indexajax',
	   error: function(){
			//showGritterError('');
		   },
	   success: function(html){           
           $('#lastvisit').html(html);
			$('#lastvisit li span').each(function(){
				$(this).text(relativeTime($(this).text()));
			});
	   }
	 });
}

function calendar_load(month)
{
	if($('#calendarbox h3').length)
		$('#calendarbox h3').append(loadingtext);
	else
		$('#calendarbox').append(loadingtext);
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl_profile + 'calendar/indexajax?month=' + month + '&firstdayofmonth=' + $('#firstdayofmonth').val(),
	   error: function(){
				$('#calendarbox .tmp_indicator').remove();
		   },
	   success: function(html){           
           $('#calendarbox').html(html);
	   }
	 });
}





function file_newdirectory(parentid)
{
	bootbox.prompt("Directory Name:", "Cancel", "CREATE DIRECTORY", function(result) {                
		if (result === null) 
		{
			                                                                          
		} 
		else 
		{
			$('#btncreatedirectory').append(loadingtext);
			
			//request ajax to create directory
			$.ajax({
			   type: "GET",
			   dataType: 'xml',
			   url: rooturl_profile + 'file/directoryaddajax?fparentid=' + parentid + '&fname=' + encodeURIComponent(result),
			   error: function(){
						$('#filebuttonbar .tmp_indicator').remove();
				   },
			   success: function(xml){           
		           var success = $(xml).find('success').text();
					var message = $(xml).find('message').text();
					
					$('#filebuttonbar .tmp_indicator').remove();
					
					if(success == "1")
					{
						showGritterSuccess(message);
						document.location.href = document.location.href;
					}
					else
					{
						showGritterError(message);
						$('#btncreatedirectory').trigger('click');
					}
			   }
			 });
		}
	});
}



function file_renamedirectory(id, oldname, token)
{
	bootbox.prompt("Rename to", "Close", "SAVE", function(result) {                
		if (result === null) 
		{
			                                                                          
		} 
		else 
		{
			$('#file-'+ id + ' .btnrename').after(loadingtext);
			
			//request ajax to create directory
			$.ajax({
			   type: "GET",
			   dataType: 'xml',
			   url: rooturl_profile + 'file/directoryeditajax/id/' + id + '?fname=' + encodeURIComponent(result),
			   error: function(){
						$('#file-'+id+' .tmp_indicator').remove();
				   },
			   success: function(xml){           
		           var success = $(xml).find('success').text();
					var message = $(xml).find('message').text();
					
					$('#file-'+id+' .tmp_indicator').remove();
					
					if(success == "1")
					{
						showGritterSuccess(message);
						//update new name
						$('#file-' + id + ' .filedirectorytitle').text(result);
					}
					else
					{
						showGritterError(message);
						$('#file-'+id+' .btnrename').trigger('click');
					}
			   }
			 });
		}
	}, oldname);
}


function file_deletedirectory(id, token, confirmMessage, name)
{
	bootbox.confirm(confirmMessage + name, function(confirmed)
	{
		if(confirmed)
		{
			$('#file-'+ id + ' .btndelete').after(loadingtext);
			
			//request ajax to create directory
			$.ajax({
			   type: "GET",
			   dataType: 'xml',
			   url: rooturl_profile + 'file/directorydeleteajax/id/' + id + '?token=' + token,
			   error: function(){
						$('#file-'+id+' .tmp_indicator').remove();
				   },
			   success: function(xml){           
		           var success = $(xml).find('success').text();
					var message = $(xml).find('message').text();
					
					$('#file-'+id+' .tmp_indicator').remove();
					
					if(success == "1")
					{
						showGritterSuccess(message);
						//update new name
						$('#file-' + id).fadeOut();
					}
					else
					{
						showGritterError(message);
					}
			   }
			 });
		}
	})
}


function file_deletefile(id, token, confirmMessage, name)
{
	bootbox.confirm(confirmMessage + name, function(confirmed)
	{
		if(confirmed)
		{
			$('#file-'+ id + ' .btndelete').after(loadingtext);
			
			//request ajax to create directory
			$.ajax({
			   type: "GET",
			   dataType: 'xml',
			   url: rooturl_profile + 'file/filedeleteajax/id/' + id + '?token=' + token,
			   error: function(){
						$('#file-'+id+' .tmp_indicator').remove();
				   },
			   success: function(xml){           
		           var success = $(xml).find('success').text();
					var message = $(xml).find('message').text();
					
					$('#file-'+id+' .tmp_indicator').remove();
					
					if(success == "1")
					{
						showGritterSuccess(message);
						//update new name
						$('#file-' + id).fadeOut();
					}
					else
					{
						showGritterError(message);
					}
			   }
			 });
		}
	})
}


function file_search()
{
	bootbox.prompt("Search In All Directory/File Name", "Cancel", "SEARCH", function(result) {                
		if (result === null) 
		{
			                                                                          
		} 
		else 
		{
			document.location.href = rooturl_profile + 'file/index/keyword/' + encodeURIComponent(result);
		}
	});
}



function file_publicurl(url)
{
	bootbox.alert(url);
}


function user_followtoggle(followingid)
{
	var sel = $('#followbtn-' + followingid);
	
	sel.after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'follow/followtoggleajax?id=' + followingid,
	   error: function(){
			sel.show();
			sel.parent().find('.tmp_indicator').remove();
	   },
	   success: function(xml){
			sel.parent().find('.tmp_indicator').remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				sel.toggleClass('btn-success').html($(xml).find('moremessage').html());
				
			}
			else
			{
				showGritterError(message);
			}
			
			sel.show();
	   }
	 });
	
}

function loadtinymce(selector)
{
	$(selector).tinymce({
		// General options
		mode : "textareas",
		theme : "advanced",
		entity_encoding : "raw",
		editor_deselector : "mceNoEditor",
		relative_urls : false,
		remove_script_host : true,
		document_base_url : "/",
		convert_urls : false, 

		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,plugobrowser",

		// Theme options
		theme_advanced_buttons1 : "plugobrowser,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,fontsizeselect,fullscreen",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true


	});
}

