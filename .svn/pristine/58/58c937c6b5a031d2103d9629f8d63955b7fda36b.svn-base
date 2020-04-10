// JavaScript Document
//use for both desktop and mobile 
//
function getParameterByName(name)
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function htmlspecialchars(str) {
 if (typeof(str) == "string") {
  str = str.replace(/&/g, "&amp;"); /* must do &amp; first */
  str = str.replace(/"/g, "&quot;");
  str = str.replace(/'/g, "&#039;");
  str = str.replace(/</g, "&lt;");
  str = str.replace(/>/g, "&gt;");
  }
 return str;
 }
 
 

// JavaScript Document
function delm(theURL)
{
	if (confirm(delConfirm))
	{
		window.location.href=theURL;
	}
		  
}

function nl2br (str, is_xhtml) {
       
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
 
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}


function scrollTo(selector)
{
	var target = $('' + selector);
	if (target.length)
	{
		var top = target.offset().top - 100;
		if(top < 0)
			top = 0;
			
		$('html,body').animate({scrollTop: top}, 1000);
		return false;
	}	
}

function scrollToNoAnimation(selector)
{
	var target = $('' + selector);
	if (target.length)
	{
		var top = target.offset().top - 100;
		if(top < 0)
			top = 0;
			
		$('html,body').animate({scrollTop: top}, 1);
		return false;
	}	
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


function relativeTime(timestamp)
{
	if(timestamp.length != 10)
		return;
	
	var timestampNow = Math.round(new Date().getTime()/1000);
	
	var distance_in_seconds = timestampNow - timestamp;
    var distance_in_minutes = Math.round(distance_in_seconds / 60);
	
	if(distance_in_minutes < 0)
		distance_in_minutes = 0;


    if (distance_in_minutes == 0) { return 'vừa gởi'; }
    if (distance_in_minutes == 1) { return '1 phút trước'; }
    if (distance_in_minutes < 45) { return distance_in_minutes + ' phút trước'; }
    if (distance_in_minutes < 90) { return '1 tiếng trước'; }
    if (distance_in_minutes < 1440) { return Math.round(distance_in_minutes / 60) + ' tiếng trước'; }
    if (distance_in_minutes < 2880) { return '1 ngày trước'; }
    if (distance_in_minutes < 43200) { return Math.round(distance_in_minutes / 1440) + ' ngày trước'; }
    if (distance_in_minutes < 86400) { return '1 tháng trước'; }
    if (distance_in_minutes < 525960) { return Math.round(distance_in_minutes / 43200) + '  tháng trước'; }
    if (distance_in_minutes < 1051199) { return '1 năm trước'; }

    return 'hơn ' + Math.round(distance_in_minutes / 525960) + ' năm trước';
	
	
	
	//return output;
}



//////////////////////////////////////
// SELL BOOK COMMENT

function sellcommentAdd(sellId)
{
		
	$("#formcomment #fsubmit").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	var message = $("#formcomment #fmessage").val();
	$("#formcomment #fsubmit").attr('disabled', 'disabled');
	
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'fmessage=' + message,
	   url: rooturl + 'sellcomment/addajax/' + sellId,
	   error: function(){
		   	$("#formcomment #fsubmit").removeAttr('disabled');
			$("#formcomment img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#formcomment #fsubmit").removeAttr('disabled');
			$("#formcomment img.tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				
				//clear review box
				$("#formcomment #fmessage").val("");
				
				//remove text 'chua co binh luan nao'
				$("#bookcomment .emptynotify").remove();
				//show comment head box neu hien tai chua co comment nao
				$("#bookcomment .head").show();
				
				//insert latest comment
				var commentId = $(xml).find('id').text();
				var commentText = $(xml).find('text').text();
				var commentTime = $(xml).find('time').text();
				var fullname = $(xml).find('fullname').text();
				var userpath = $(xml).find('userpath').text();
				var avatar = $(xml).find('avatar').text();
				
				if(avatar.length == 0)
					avatar = imageDir + "noavatar.jpg";
					
					
				var comment = '';
				comment += '<div class="comment" style="display:none;" id="comment-'+commentId+'" >';
				comment += '<div class="avatar"><a name="comment-'+commentId+'" href="'+userpath+'" title="'+fullname+'"><img src="'+avatar+'" alt="Avatar" /></a></div>';
				comment += '<div class="commentdetail">';
				comment += '<div class="commentor"><a href="'+userpath+'" title="'+fullname+'">'+fullname+'</a> <span class="time">'+relativeTime(commentTime)+'</span></div>';
				comment += '<div class="text">'+commentText+'</div>';
				comment += '</div>';
				comment += '</div>';
				
				
				
				$("#bookcomment .commentlist").append(comment);
				$("#bookcomment #comment-" + commentId).fadeIn();
				//scrollTo("#comment-" + commentId);
			}
			else
			{
				showGritterError(message);
				
				$("#formcomment #fmessage").focus();
			}
	   }
	 });
}


function sellcommentLoad(sellId, page)
{

	$("#bookcomment .commentlist").html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl + 'sellcomment/indexajax/'+sellId+'?page=' + page,
	   error: function(){
		   $("#bookcomment .commentlist").html('');
			//showGritterError('');
		   },
	   success: function(html){
		   if(html == 'empty')
		   {
				$("#bookcomment .commentlist").html('');   
				$("#bookcomment .emptynotify").show();  
				
				
		   }
		   else
		   {
			   	$("#bookcomment .commentlist").html(html);
				var selectedcomment = getParameterByName('selectedcomment');
			   	if(selectedcomment != "")
				{
					scrollTo("#comment-" + selectedcomment);
				}
		   }
			
	   }
	 });
}


function sellcommentRemove(url, commentId)
{
	if (confirm(delConfirm))
	{
		$("#comment-" + commentId + " .controlbar a.remove").append('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
		
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: url,
		   error: function(){
			   $("#comment-" + commentId + " .controlbar a.remove img.tmp_indicator").remove();
	
				//showGritterError('');
			   },
		   success: function(xml){
				$("#comment-" + commentId + " .controlbar a.remove img.tmp_indicator").remove();
				
				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();
				
				if(success == "1")
				{
					showGritterSuccess(message);
					
					$("#comment-" + commentId).fadeOut();
					
								
				}
				else
				{
					showGritterError(message);
					
				}
		   }
		 });
	}
	
}

function sellcommentReport(url, title)
{
	// open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    url,
        player:     "iframe",
        title:      title,
        height:     250,
        width:      500
    });
}

function sellReport(url, title)
{
	// open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    url,
        player:     "iframe",
        title:      title,
        height:     250,
        width:      500
    });
}

////////////////////////////
//	BOOK SELL THANKS
function booksellthankLoad(sellId)
{

	$("#thankers").html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl + 'booksellthank/indexajax/' + sellId,
	   error: function(){
		   $("#thankers").html('');
			//showGritterError('');
		   },
	   success: function(html){
		   
		   if(html != 'empty')
		   {
			   $("#thankers").html(html);
			   $('#sell_thankbox').fadeIn();
		   }
		   
			
	   }
	 });
}


function booksellthankAdd(sellId)
{
		
	$("#thankbutton").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
		
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   url: rooturl + 'booksellthank/addajax/' + sellId,
	   error: function(){
		   	$("#thankbutton").show();
			$("#poster img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#formcomment #fsubmit").removeAttr('disabled');
			$("#poster img.tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			
			if(success == "1")
			{
				
				//ko show gritter vi bi flash reader overlay
				$("#thankbutton").after('<span>'+ $(xml).find('message').text()+'</span>');
				
				//insert latest comment
				var thankid = $(xml).find('id').text();
				var fullname = $(xml).find('fullname').text();
				var userpath = $(xml).find('userpath').text();
				var avatar = $(xml).find('avatar').text();
				
				if(avatar.length == 0)
					avatar = imageDir + "noavatar.jpg";
					
					
				var thank = '';
				thank += '<div class="thanker hide" id="thank-'+thankid+'">';
				thank += '	<div class="ava"><a href="'+userpath+'" title="'+fullname+'"><img src="'+avatar+'" alt="'+fullname+'" /></a></div>';
				thank += '	<div class="info">';
				thank += '		<a href="'+userpath+'" class="username" title="'+fullname+'">'+fullname+'</a>';
				thank += '	</div>';
				thank += '</div>';
								
				
				$("#thankers").prepend(thank);
				$("#thankers #thank-"+thankid).fadeIn('slow');
				
				//hide empty box (if current no thanks)
				$('#thankers .empty').hide();
				
			}
			else
			{
				var message = $(xml).find('message').text();
				
				$("#thankbutton").show();
				document.location.href = '#';	//trick, ko show gritter dc vi bi flash overlay
			}
	   }
	 });
}



////////////////////////////////////////////////
//	FLIPBOOK function

function flipbook_gotopage(page)
{
	if(page == 0)
		var setpage = $('#flipbook_setpage').val();
	else
		var setpage = page;
	
	
	
	//kiem tra xem trang nay da duoc load chua
	if($('#bookpage-' + setpage + ' img').length)
	{
		//scrollTo('#bookpage-' + setpage);
		//window.location.hash = 'page-' + setpage;
		scrollToNoAnimation('#bookpage-' + setpage);
		
		
		$('#flipbook_setpage').focus();
	}
	else
	{
		//load pagepack
		var pagepack = 0;
		if((setpage - 1 ) % 10 == 0)
			pagepack = setpage;
		else
			pagepack = setpage - (setpage -1 ) % 10;
		
		//load pagepack
		flipbook_pagepackload($('#currentchapter').val(), pagepack, setpage, false);
	}
}


function flipbook_navboxinit()
{
	//////////////////////////////
	//	SET ZOOM OPTION
	var curhtmlzoom = $.cookie('flipbookhtmlzoom');
	if(curhtmlzoom == null || isNaN(curhtmlzoom)) 
		curhtmlzoom = 100;	
	flipbook_zoomset(curhtmlzoom);
	
	
	
	/////////////////////////////
	//	RECOVER INTERRUPT PAGE, BECAUSE COMEBACK PAGE AFTER REGISTER/LOGIN
	var selectedpage = 0;
	var flipbookinterruptpage = $.cookie('interruptpagelike');
	var scrolltopagelike = false;
	if(flipbookinterruptpage != null && isNaN(flipbookinterruptpage)== false)
	{
		//verify like after redirect
		var sellid = $('#booksellid').val();
		var currentchapter = $('#currentchapter').val();
		var flipbookinterruptpage_verify = $.cookie('interruptpagelike_verify');
		
		if(flipbookinterruptpage_verify == sellid + '_' + currentchapter)
		{
			selectedpage = parseInt(flipbookinterruptpage);
			scrolltopagelike = true;
		}
		
		//clear cookie
		$.cookie('interruptpagelike', null, {  path: '/'});
		$.cookie('interruptpagelike_verify', null, {  path: '/'});
	}
	
		
	/////////////////////////////
	//	SCROLL TO A SELECTED PAGE
	
	//if selectedpage get from cookie, it will ignore this (get from URL get)
	if(selectedpage == 0)
		selectedpage = parseInt(getParameterByName('page'));
		
		
	if(selectedpage > 0 )
	{
		//check xem page nay co nam trong danh sach pagepack chua load ko (boi vi mac dinh chi load co 10 trang dau)
	
		
		if($('#bookpage-' + selectedpage + ' .flipbook-pageimage').length)
		{
			if(scrolltopagelike)
			{
				scrollToNoAnimation('#bookpage-like-'+selectedpage);
				flipbookpagelike_add(selectedpage);
			}
			else
				scrollToNoAnimation('#bookpage-'+selectedpage);
		}
		else
		{
			//calculate pagepack start
			var pagepack = 0;
			if((selectedpage -1 ) % 10 == 0)
				pagepack = selectedpage;
			else
				pagepack = selectedpage - (selectedpage -1 ) % 10;
			
			//load pagepack
			flipbook_pagepackload($('#currentchapter').val(), pagepack, selectedpage, scrolltopagelike);
		}
	}
	
   	
}

function flipbook_zoomset(zoomvalue)
{
	
	//set pagesize, hard part
	var fullwidth = parseInt($('#chapterpagewidth').val());
	var newwidth = Math.round(zoomvalue * fullwidth / 100);
	
	$('.flipbook-pageimage').css('width', newwidth + 'px');
	$('.flipbook-page').css('width', (newwidth + 20) + 'px');
	
	//also upgrade height too
	var fullheight = parseInt($('#chapterpageheight').val());
	var newheight = Math.round(zoomvalue * fullheight / 100);
	
	$('.flipbook-pageimage').css('height', newheight + 'px');
	$('.flipbook-page').css('height', (newheight + 40) + 'px');
	
	//update zoomvalue
	$('#flipbook_zoomnumber').text(zoomvalue);
		
	
}

function flipbook_zoom(inout)
{
	var zoomvalue = parseInt($('#flipbook_zoomnumber').text());
	
	//find zoomvalue
	if(inout == 'in')
	{
		if(zoomvalue == 800) alert('Bạn không thể phóng to hơn được nữa.');
		if(zoomvalue == 400) zoomvalue = 800;
		if(zoomvalue == 300) zoomvalue = 400;
		if(zoomvalue == 200) zoomvalue = 300;
		if(zoomvalue == 175) zoomvalue = 200;
		if(zoomvalue == 150) zoomvalue = 175;
		if(zoomvalue == 125) zoomvalue = 150;
		if(zoomvalue == 100) zoomvalue = 125;
		if(zoomvalue == 75) zoomvalue = 100;
		if(zoomvalue == 50) zoomvalue = 75;
		if(zoomvalue == 33) zoomvalue = 50;
		if(zoomvalue == 25) zoomvalue = 33;
	}
	else
	{
		if(zoomvalue == 25) alert('Bạn không thể thu nhỏ hơn được nữa.');
		if(zoomvalue == 33) zoomvalue = 25;
		if(zoomvalue == 50) zoomvalue = 33;
		if(zoomvalue == 75) zoomvalue = 50;
		if(zoomvalue == 100) zoomvalue = 75;
		if(zoomvalue == 125) zoomvalue = 100;
		if(zoomvalue == 150) zoomvalue = 125;
		if(zoomvalue == 175) zoomvalue = 150;
		if(zoomvalue == 200) zoomvalue = 175;
		if(zoomvalue == 300) zoomvalue = 200;
		if(zoomvalue == 400) zoomvalue = 300;
		if(zoomvalue == 800) zoomvalue = 400;
	}
	
	flipbook_zoomset(zoomvalue);
	
	
	//set cookie
	$.cookie('flipbookhtmlzoom', zoomvalue, {  path: '/'});
}

function flipbook_chapteronchange(flipbookviewmode)
{
	var booksellpath = $('#booksellpath').val();
	var chapter = $('#flipbook_curchap select').val();
	
	var chapterprefix = '';
	if(flipbookviewmode == 'flash')
	{
		if(chapter > 1)
		{
			chapterprefix = '?chapter=' + chapter + '&mode=flash'; 
		}
		else
		{
			chapterprefix = '?mode=flash';
		}
	}
	else
	{
		if(chapter > 1)
		{
			chapterprefix = '?chapter=' + chapter;
		}
	}
		
	if(chapter > 0)
		document.location.href = booksellpath + chapterprefix ;
}


//use global to tracking if a pagepack is loading
var isPagePackLoading = false;
function flipbook_pagepackload(chapter, pagepack, selectedpage, scrolltopagelike)
{
	if(isPagePackLoading == false || selectedpage > 0)
	{
		//get imagesize of first page
		var firstpagewrapperwidth = $('.flipbook-page:first').css('width');
		var firstpagewidth = $('.flipbook-pageimage:first').css('width');
		var firstpagewrapperheight = $('.flipbook-page:first').css('height');
		var firstpageheight = $('.flipbook-pageimage:first').css('height');
		
		//turn on flag to stop other pagepack loading
		isPagePackLoading = true;
		
		//get pagepack size (number of page in pagepack)
		var pagepacksize = parseInt($('#flipbook-pagepack-'+pagepack + ' span').length);
		//add placeholder to keep user eye
		var placeholderhtml = '<div id="flipbook-pagepack-placeholder-' + pagepack + '">';
		for(i=pagepack; i < (pagepack*1+pagepacksize); i++)
		{
			placeholderhtml += '<div class="flipbook-page" style="width:'+firstpagewrapperwidth+';height:'+firstpagewrapperheight+'"><img class="flipbook-pageimage" src="'+imageDir+'blank.png" style="width:'+firstpagewidth+';height:'+firstpageheight+'" /><div class="flipbook-pageinfo"><div class="flipbook-pagelike"></div><div class="flipbook-pagenumber">Trang '+i+'</div></div></div>';
		}
		placeholderhtml += '</div>';
		
		$('#flipbook-pagepack-'+pagepack).before(placeholderhtml);
		
		
		
		var loadurl = $('#booksellpath').val() + '/loadpagepackajax?chapter='+chapter+'&start='+pagepack+'&ww='+firstpagewrapperwidth+'&wi='+firstpagewidth+'&hw='+firstpagewrapperheight+'&hi='+firstpageheight;
		
		//ngan khong cho user tip tuc click vao pagepack de load lai
		if($('#flipbook-pagepack-'+pagepack).attr('title') != '')
		{
			//do not need ajax indicator, because using place holder
			//$('#flipbook-pagepack-'+pagepack).html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" style="margin-top:30px;" /> Đang tải từ trang ' + pagepack).attr('title', '');
			$('#flipbook-pagepack-'+pagepack).hide();
			
			$.ajax({
			   type: "GET",
			   dataType: 'html',
			   url: loadurl,
			   error: function(){
					//$("#flipbook-pagepack-" + pagepack + " img.tmp_indicator").remove();
					
					isPagePackLoading = false;
					$('#flipbook-pagepack-placeholder-'+pagepack).remove();
				   },
			   success: function(html){
					if(html != '')
					{
						$('#flipbook-pagepack-'+pagepack).after(html);
						$('#flipbook-pagepack-'+pagepack).remove();
						
						
					}
					else
					{
						var message = $(html).find('message').text();
						showGritterError('Không tìm thấy dữ liệu.');
					}
					
					
					isPagePackLoading = false;
					$('#flipbook-pagepack-placeholder-'+pagepack).remove();
					
					if(selectedpage > 0)
					{
						if(scrolltopagelike)
						{
							scrollToNoAnimation('#bookpage-like-'+selectedpage);
							//request to submit pagelikeadd
							flipbookpagelike_add(selectedpage);
						}else
							scrollToNoAnimation('#bookpage-'+selectedpage);
					}
			   }
			 });
		}
	}
	
	
	
	
}


function flipbook_inviewbinding()
{
	$(".flipbook-pagepack").bind("inview", function(isVisible) {
					
	  var pagepack = $(this).attr('id');
	  if (isVisible) {
		  if(isPagePackLoading == false)
		  {
			pagepackid = pagepack.replace('flipbook-pagepack-', '');  
			
			
			flipbook_pagepackload($('#currentchapter').val(), pagepackid, 0);
		  }
		 
		console.log("element "+pagepackid+" became visible in the browser's viewport");
	  }
	  
	  
	});
}


function flipbookpagelike_add(pageid)
{
	var sellid = $('#booksellid').val();
	var chapterid = $('#currentchapter').val();
	
	if(parseInt($('#currentuid').val()) == 0)
	{
		//save this page to breakpage
		$.cookie('interruptpagelike', pageid, {  path: '/'});
		
		//dung de check sau khi login/register, neu co quay lai thi check dung sellid va chapter thi moi request
		$.cookie('interruptpagelike_verify', sellid + '_' + chapterid, {  path: '/'});
		
		var booksellpathchapterencode = $('#booksellpathchapterencode').val();
		showGritterError('Chỉ có thành viên mới dùng được tính năng này. <a href="'+rooturl+'login?redirect='+booksellpathchapterencode+'">Đăng nhập</a> hoặc <a href="'+rooturl+'register?redirect='+booksellpathchapterencode+'">Đăng ký thành viên</a> để tiếp tục.');
		return;
	}
	
	
	
	$("#bookpage-" + pageid + " .like_btn").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$("#bookpage-" + pageid + " .like_btn").hide();
	
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'id=' + sellid + '&chapter=' + chapterid + '&page=' + pageid,
	   url: rooturl + 'flipbookpagelike/addajax',
	   error: function(){
		   	$("#bookpage-" + pageid + " .like_btn").show();
			$("#bookpage-" + pageid + " img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#bookpage-" + pageid + " img.tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();
			
			if(success == "1")
			{
				showGritterSuccess(message);
				
				//insert latest comment
				var liketext = $(xml).find('liketext').text();
				$("#bookpage-" + pageid + " .like_btn").after(liketext);	
			}
			else
			{
				showGritterError(message);
			}
	   }
	 });
}

function flipbook_mobilepromptpage()
{
	var totalpage = $('#totalpageinchapter').val();
	var page=prompt("Bạn muốn tới trang nào? Có "+totalpage+" trang.","1");
	if (page!=null && page!="" && parseInt(page) > 0)
	{
		flipbook_gotopage(parseInt(page));
	}
}

function flipbook_mobilepromptchapter(chapterprefixname)
{
	var totalchapter = $('#totalchapter').val();
	var currentchapter = $('#currentchapter').val();
	var initchapter = 1;
	if(currentchapter < totalchapter)
		initchapter = parseInt(currentchapter) + 1;
		
		
	var chapter=prompt("Bạn muốn tới "+chapterprefixname+" mấy? Có "+totalchapter+" "+chapterprefixname+".",initchapter);
	if (chapter!=null && chapter!="" && parseInt(chapter) > 0)
	{
		document.location.href = $('#booksellpath').val() + '?chapter=' + chapter + '&mobile';
		
	}
}

function flipbook_mobilescrolldown()
{
	$('document').scrollTo($('document').scrollTop + 300);
}

function flipbook_embed(width, height, booksellpath, chapter)
{
	var chapterString = '';
	if(chapter > 1)
	{
		chapterString = '?chapter=' + chapter;
	}
	
	var embedhtml = '<iframe width="'+width+'" height="'+height+'" src="'+booksellpath+'/embed'+chapterString+'" frameborder="0" type="text/html" scrolling="no"></iframe>';
	$('#flipbook-embed textarea').val(embedhtml).focus().select();
}

function autosaveReview()
{
	var reviewdata = $("#fmessage").val();
	if(reviewdata.length > 50)
	{
		$("#formreview #fsubmit").after('<span class="tmp_indicator"><img src="'+imageDir+'ajax_indicator.gif" border="0" />Saving draft...</span>');
		
		//request ajax to autosave
		$.ajax({
		   type: "POST",
		   dataType: 'html',
		   data: 'fdata=' + encodeURIComponent(reviewdata),
		   url: rooturl + 'review/autosave',
		   error: function(){
			   $("#formreview .tmp_indicator").remove();
		   },
		   success: function(html){
			   $("#formreview .tmp_indicator").remove();
		   }
		 });
	}
	
	setTimeout("autosaveReview()", 20000);
}

function popup_reviewadd(bookurl, bookid, event)
{
	if(uid > 0)
	{
		// open a welcome message as soon as the window loads
		Shadowbox.open({
			content:    rooturl + 'review/add/' + bookid,
			player:     "iframe",
			title:      '',
			options: {
						   modal:   true
			}, 
			height:     460,
			width:      740
		});
	}
	else
	{
		url = bookurl + '#formreview';
		document.location.href= rooturl + 'login?returnurl='+ encodeURIComponent(url);
	}
}

function popup_reviewedit(reviewid)
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    rooturl + 'review/edit/' + reviewid,
		player:     "iframe",
		title:      '',
		options: {
					   modal:   true
		}, 
		height:     460,
		width:      740
	});
}

function popup_reviewaddforce(bookid)
{
	
	

	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    rooturl + 'review/add/' + bookid,
		player:     "iframe",
		title:      'Viet Binh Luan',
		options: {
					   modal:   true
		}, 
		height:     460,
		width:      740
	});
	
	
}



////////////////////////////
//	SAMPLE THANKS
function samplethankLoad(sampleId)
{

	$("#thankers").html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl + 'samplethank/indexajax/' + sampleId,
	   error: function(){
		   $("#thankers").html('');
			//showGritterError('');
		   },
	   success: function(html){
		   $("#thankers img.tmp_indicator").remove();
		   
		   if(html != 'empty')
		   {
			   $("#thankers").html(html);
			   $('#sell_thankbox').fadeIn();
		   }
		   
		   
			
	   }
	 });
}


function samplethankAdd(sampleId)
{
		
	$("#thankbutton").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();
	
		
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   url: rooturl + 'samplethank/addajax/' + sampleId,
	   error: function(){
		   	$("#thankbutton").show();
			$("#poster img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#poster img.tmp_indicator").remove();
			
			var success = $(xml).find('success').text();
			
			if(success == "1")
			{
				
				//ko show gritter vi bi flash reader overlay
				$("#thankbutton").after('<span>'+ $(xml).find('message').text()+'</span>');
				
				//insert latest comment
				var thankid = $(xml).find('id').text();
				var fullname = $(xml).find('fullname').text();
				var userpath = $(xml).find('userpath').text();
				var avatar = $(xml).find('avatar').text();
				
				if(avatar.length == 0)
					avatar = imageDir + "noavatar.jpg";
					
				
				var thank = '';
				thank += '<div class="thanker hide" id="thank-'+thankid+'">';
				thank += '	<div class="ava"><a href="'+userpath+'" title="'+fullname+'"><img src="'+avatar+'" alt="'+fullname+'" /></a></div>';
				thank += '	<div class="info">';
				thank += '		<a href="'+userpath+'" class="username" title="'+fullname+'">'+fullname+'</a>';
				thank += '	</div>';
				thank += '</div>';
								
				$('#sell_thankbox').show();
				$("#thankers").prepend(thank);
				$("#thankers #thank-"+thankid).fadeIn('slow');
				
				//hide empty box (if current no thanks)
				$('#thankers .empty').hide();
				//alert($('#thankers .tmp_indicator').attr('src'));
				
				
			}
			else
			{
				var message = $(xml).find('message').text();
				
				$("#thankbutton").show();
				document.location.href = '#';	//trick, ko show gritter dc vi bi flash overlay
			}
	   }
	 });
}


function in_array(needle, haystack)
{
    for(var key in haystack)
    {
        if(needle === haystack[key])
        {
            return true;
        }
    }

    return false;
}