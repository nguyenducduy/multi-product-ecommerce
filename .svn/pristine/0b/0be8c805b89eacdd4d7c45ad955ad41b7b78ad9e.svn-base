//jquery fx begin
var autocompleteUrl = '';
$(document).ready(function()
{
	$('.readmoreonl').click(function() {
	     /* Act on the event */
	     var id = $(this).attr("rel");
	     if($('.onlinedes_'+id).css('display') == "block")
	     {
	         $('.onlinedes_'+id).css("display","none");
	         $('.fulldes_'+id).css("display","block");
	         $(this).addClass('readmoreonlclose');
	         $(this).html('[Thu gọn]');

	    }
	    else{
	         $('.onlinedes_'+id).css("display","block");
	         $('.fulldes_'+id).css("display","none");
	         $(this).addClass('readmoreonlclose');
	         $(this).html('[Xem thêm]');
	    }
	});
  	$('.readmoreoff').click(function() {
     /* Act on the event */
	    var id = $(this).attr("rel");
	    if($('.desoff_'+id).css('display') == "block")
	    {
	         $('.desoff_'+id).css("display","none");
	         $('.fulldesoff_'+id).css("display","block");
	         $(this).addClass('readmoreonlclose');
	         $(this).html('[Thu gọn]');

    	}
    	else{
	         $('.desoff_'+id).css("display","block");
	         $('.fulldesoff_'+id).css("display","none");
	         $(this).addClass('readmoreonlclose');
	         $(this).html('[Xem thêm]');
    	}
	 });
	$('.tipsy-trigger').tipsy();
	$('.tipsy-hovercard-trigger').tipsyHoverCard();

	//convert timestamp to relativetime
	$('.relativetime').each(function(){
		$(this).text(relativeTime($(this).text()));
		$(this).show();
	});



	//Create Autocomplete for heading-search
	$("#fsitebooksearchtext").autocomplete(rooturl_cms + 'globalsearch/suggest', {
		width: 334,
		scroll: true,
		scrollHeight: 500,
		highlight: false,
		selectFirst: false,
		formatItem: fsitebooksearchtextAutoCompleteFormatItem,
		formatResult: fsitebooksearchtextAutoCompleteFormatResult

	}).result(function(event, row) {
	 	location.href = row[0];
	  autocompleteUrl = row[0];
	});


	//mention feature
	$('.mentionable').mentionsInput({
	  	onDataRequest:function (mode, query, callback) {
		      $.getJSON(meurl + '/recommendation/mention?tag=' + query, function(responseData) {
		        responseData = _.filter(responseData, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 ||  item.namesearch.toLowerCase().indexOf(query.toLowerCase()) > -1});
		        callback.call(this, responseData);
		      });
		    }
	});


	//init tinycon object to favicon notification number badge
	Tinycon.setOptions({
	    width: 7,
	    height: 9,
	    font: '10px arial',
	    colour: '#ffffff',
	    background: '#f00',
	    fallback: true
	});


	//autocomplete for search ONE user
	$(".autocompleteoneuser").fcbkcomplete({
				json_url: rooturl_admin + "user/autocompleteajax",
				addontab: true,
				maxitems: 1,
				height: 8,
				bricket: false,
				firstselected: true
			});

	//autocomplete for search MULTI user
	$(".autocompleteuser").fcbkcomplete({
				json_url: rooturl_admin + "user/autocompleteajax",
				addontab: true,
				maxitems: 20,
				height: 8,
				bricket: false,
				firstselected: true
			});


	//autocomplete for search ONE staff user (admin, moderator, developer, employee)
	$(".autocompleteonestaff").fcbkcomplete({
				json_url: rooturl_admin + "user/autocompleteajax?type=employeeonly",
				addontab: true,
				maxitems: 1,
				height: 8,
				bricket: false,
				firstselected: true
			});


	//autocomplete for search MULTI staff user (admin, moderator, developer, employee)
	$(".autocompletestaff").fcbkcomplete({
				json_url: rooturl_admin + "user/autocompleteajax?type=employeeonly",
				addontab: true,
				maxitems: 20,
				height: 8,
				bricket: false,
				firstselected: true
			});

	//autocomplete for search MULTI product
	$(".autocompleteproduct").fcbkcomplete({
				json_url: rooturl_cms + "product/autocompleteajax",
				addontab: true,
				maxitems: 20,
				height: 8,
				bricket: false,
				firstselected: true
			});

	//autocomplete for search one product
	$(".autocompleteoneproduct").fcbkcomplete({
				json_url: rooturl_cms + "product/autocompleteajax",
				addontab: true,
				maxitems: 1,
				height: 8,
				bricket: false,
				firstselected: true
			});

	$('.inputdatepicker, .inputdatepickersmall').datepicker({'format':'dd/mm/yyyy', 'weekStart' : 1})
		.on('changeDate', function(ev){
		   $('.datepicker').hide();
			$(this).blur();
	    });
	$('.inputdatepicker').after('<span class="inputdatepicker_help">&nbsp;&nbsp;DD/MM/YYYY</span>');



});

function SBopen() {
	document.body.style.overflow = "hidden";
	return true;
}

function SBclose() {
	document.body.style.overflow = "auto";
	return true;
}



function fcbkoncreate()
{

}

function loadUserInfo()
{
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/userinfo',
	   success: function(xml){
			var mygrouplist = $(xml).find('mygrouplist').text();

			$('#menu_group_add').before(mygrouplist);
	   }
	 });
}



////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////				AUTO COMPLETE		//////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
function fsitebooksearchtextAutoCompleteFormatItem(row)
{
	autocompleteUrl = '';
	var _viewDetail = 'Xem thông tin này';

	var value = row[1].replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $("#fsitebooksearchtext").val().replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");

	var url = row[0];
	var rating = row[3];
	var author = row[4];
	var resulttype = row[5];	//can be book, user, site page (contact, login..)




	var output = '';

	//append book item
	if(resulttype == 'product' || resulttype == 'news' || resulttype == 'stuff' || resulttype == '')
	{
		output += '<div class="sitesearch-autocomplete">';
		output += '		<div class="sitesearch-autocomplete-image"><img class="product" src="'+ row[2] +'" /></div>';
		output += '		<div class="sitesearch-autocomplete-text">'+ value +'</div>';
		output += '		<div class="sitesearch-autocomplete-author">'+ author +'</div>';
		output += '	</div>';
	}
	else if(resulttype == 'controller')
	{
		output += '<div class="sitesearch-autocomplete-controller">';
		output += '		<div class="sitesearch-autocomplete-image"><img class="controller" src="'+ row[2] +'" /></div>';
		output += '		<div class="sitesearch-autocomplete-text">'+ value +'</div>';
		output += '		<div class="sitesearch-autocomplete-author">'+ author +'</div>';
		output += '	</div>';
	}
	else if(resulttype == 'user')
	{
		output += '<div class="sitesearch-autocomplete-user">';
		output += '		<div class="sitesearch-autocomplete-image"><img class="avatar" src="'+ row[2] +'" /></div>';
		output += '		<div class="sitesearch-autocomplete-text">'+ value +'</div>';
		output += '		<div class="sitesearch-autocomplete-author">'+ author +'</div>';
		output += '	</div>';
	}
	else if(resulttype == 'seperator')
	{
		output += '<div class="sitesearch-autocomplete-seperator"><div class="sitesearch-autocomplete-textsep">'+value+'</div></div>';
	}




	return output;
}

function fsitebooksearchtextAutoCompleteFormatResult(row)
{
	return row[1].replace(/(<.+?>)/gi, '');
}



//end OAUTH PART

function reloadCaptchaImage()
{
	var timestamp = new Date();

	$("#captchaImage").attr('src', rooturl + "captcha?random=" + timestamp.getTime());
}


/**
Request toi trang de tim sach
*/
function doSitesearchbooksubmit()
{
	var keyword = $('#fsitebooksearchtext').val();
	if(keyword.length == 0)
	{
		alert('Bạn chưa nhập từ cần tìm');
		$('#fsitebooksearchtext').focus();
	}
	else if(keyword.length < 3)
	{
		alert('Từ cần tìm quá ngắn.');
		$('#fsitebooksearchtext').focus();
	}
	else
	{
		document.location.href = rooturl + 'globalsearch?keyword=' + keyword;
	}
}

/**
Xu ly khi user type search book va nhan ENTER
*/
function doSitebooksearchtextpress(e)
{
	if (e.keyCode == 13)
	{
		//check xem autocomplete da co row nao select chua
		//neu chua thi tien hanh submit form
		if(autocompleteUrl.length == 0)
			$('#fsitebooksearchsubmit').trigger('click');
		else
			location.href = autocompleteUrl;
	}
}


//request de khong nhan notification cho blog
function blogfollowDisable(blogid)
{
	$("#share-bookmark .disablenotification a").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#share-bookmark .disablenotification a").hide();

	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/blog/disablefollowajax/' + blogid,
	   error: function(){
		   	$("#share-bookmark .disablenotification a").show();
			$("#share-bookmark .disablenotification img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#share-bookmark .disablenotification img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
			}
			else
			{
				showGritterError(message);
				$("#share-bookmark .disablenotification a").show();
			}
	   }
	 });
}




$.fn.extend({
    insertAtCaret: function(myValue){
    		if (document.selection) {
        this.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
        this.focus();
    		}
      else if (this.selectionStart || this.selectionStart == '0') {
        var startPos = this.selectionStart;
        var endPos = this.selectionEnd;
        var scrollTop = this.scrollTop;
        this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
        this.focus();
        this.selectionStart = startPos + myValue.length;
        this.selectionEnd = startPos + myValue.length;
        this.scrollTop = scrollTop;
      } else {
        this.value += myValue;
        this.focus();
      }
    }
})



function testreal()
{
	realtimenotify('http://new.dienmay.com/cms', 'http://avatar.r-img.com/2012/May/25/kaka-hontholangdu-30205-1337947889-small.jpg', '<strong>Võ Duy Tuấn</strong> đã thích hoạt động viết lên trang nhà của bạn.');
}


function realtimenotify(url, icon, message)
{
	var timestamp = new Date();
	var realtimenotificationid = timestamp.getTime();

	var html = '<a id="realtimenotification-'+realtimenotificationid+'" class="realtimenotification hide" href="'+url+'"><b onclick="$(\'#realtimenotification-'+realtimenotificationid+'\').hide();event.stopPropagation();" title="Close">&times;</b><img src="'+icon+'" /><span>'+message+'</span></a>';

	$('#realtimenotificationwrapper').append(html);

	var realtimeTimeout = 0;

	$('#realtimenotification-' + realtimenotificationid).fadeIn('fast', function(){
		realtimeTimeout = setTimeout(function(){
			$('#realtimenotification-' + realtimenotificationid).fadeOut('slow');
		}, 4000);
	});

	$('#realtimenotification-' + realtimenotificationid).hover(function(){
		clearTimeout(realtimeTimeout);
	}, function(){
		realtimeTimeout = setTimeout(function(){
			$('#realtimenotification-' + realtimenotificationid).fadeOut('slow');
		}, 4000);
	})
}

var highlightextchangeEnable = true;
function highlighttextchange(selector)
{
	if(highlightextchangeEnable)
	{
		highlightextchangeEnable = false;
		$(selector).animate({
			color : '#f90'
		}, 500, function(){

			$(selector).animate({
				color : '#000'
			}, 1000, function(){
				highlightextchangeEnable = true;
			});
		});
	}

}



function region_loadsub()
{
	var regionid = $('#fregion').val();
	var selectedsubregionid = $('#fsubregiondefault').val();

	$("#fsubregion").before('<img class="tmp_indicator" id="fsubregionindicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();

	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: rooturl + 'region/subregionajax/' + regionid + '?selected=' + selectedsubregionid,
	   error: function(){
			$("#fsubregionindicator").remove();
			$('#fsubregion').show();
		   },
	   success: function(html){
			$("#fsubregionindicator").remove();
			$('#fsubregion').html(html).show();
	   }
	 });
}




function status_attachlink_fetch()
{
	if(!isValidURL($('#statusbox_link #url').val()))
	{
		showGritterError('&#272;&#7883;a ch&#7881; trang web kh&#244;ng h&#7907;p l&#7879;. (Ph&#7843;i c&#243; d&#7841;ng: http://...)');
		$('#statusbox_link #url').focus();
		return false;
	}
	else
	{
		$('#statusbox_link #load').show();
		$.post(rooturl_profile + "statusboxlinkfetch?url="+ encodeURIComponent($('#statusbox_link #url').val()), {
		}, function(response){
			$('#statusbox_link #statusbox_link_attach').val(1);
			$('#statusbox_link #loader').html($(response).fadeIn('slow'));
			$('#statusbox_link .images img').hide();
			$('#statusbox_link #load').hide();
			$('#statusbox_link img#1').fadeIn();
			$('#statusbox_link #cur_image').val(1);
		});
	}
}

function status_attachlink_edit(where)
{
	if(where == 'title')
	{
		$('#statusbox_link .title').hide();
		$('#statusbox_link #title_edit').show().focus();
	}
	else if(where == 'desc')
	{
		$('#statusbox_link .desc').hide();
		$('#statusbox_link #desc_edit').show().focus();
	}
}

function status_attachlink_editsave(where)
{
	if(where == 'title')
	{
		if($('#statusbox_link #title_edit').val().length > 0)
		{
			$('#statusbox_link .title').text($('#statusbox_link #title_edit').val());

		}
		else
		{
			$('#statusbox_link .title').html('[Th&#234;m ti&#234;u &#273;&#7873;]');
		}

		$('#statusbox_link #title_edit').hide();
		$('#statusbox_link .title').show();
	}
	else if(where == 'desc')
	{
		if($('#statusbox_link #desc_edit').val().length > 0)
		{
			$('#statusbox_link .desc').text($('#statusbox_link #desc_edit').val());

		}
		else
		{
			$('#statusbox_link .desc').html('[Th&#234;m gi&#7899;i thi&#7879;u]');
		}

		$('#statusbox_link #desc_edit').hide();
		$('#statusbox_link .desc').show();
	}
}

function status_attachlink_close()
{
	$('#statusbox_link #statusbox_link_attach').val(0);
	$('#statusbox_link').hide();
	$('#statusbox_link_trigger').show();
}

function status_attachlink_prev()
{
	var curimage = $('#statusbox_link #cur_image').val();

	if(curimage > 1)
	{
		$('#statusbox_link img#'+curimage).hide();

		curimage = parseInt(curimage)-parseInt(1);
		$('#statusbox_link #cur_image').val(curimage);
		$('#statusbox_link #currentimageshow').text(curimage);
		$('#statusbox_link img#'+curimage).show();
	}
}

function status_attachlink_next()
{
	var curimage = $('#statusbox_link #cur_image').val();
	if(curimage < parseInt($('#statusbox_link #total_images').val()))
	{
		$('#statusbox_link img#'+curimage).hide();
		curimage = parseInt(curimage)+parseInt(1);
		$('#statusbox_link #cur_image').val(curimage);
		$('#statusbox_link #currentimageshow').text(curimage);
		$('#statusbox_link img#'+curimage).show();
	}
}



/**
* Load cac friend vua moi cap nhat thong tin cua user
*/
function user_panelLastFriend(from)
{
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/friend/lastactionajax?from=' + from,
	   error: function(){

		  		//showGritterError('');
		   },
	   success: function(xml){
			var count = $(xml).find('count').text();

			if(count != '0')
			{


				var html = '<div id="panelfriendlist">';

				$(xml).find('user').each(function(){

					var statusstring = '';
					if($(this).find('status').text() != 'offline')
					{
						var statustext = $(this).find('status').text();
						statusstring = '<span class="sp sp16 sp'+statustext+'" style="display:block;position:relative; margin:-15px 0 0 25px;width:10px; height:13px;opacity:0.7;" title="'+statustext+'" />';
					}

					html += '<a class="frienditemimage tipsy-hovercard-trigger" data-url="'+$(this).find('hovercardurl').text()+'" title="' + $(this).find('fullname').text() + '" href="' + $(this).find('userurl').text() + '"><img src="' + $(this).find('avatar').text() + '" alt="" />'+statusstring+'</a>';
				});

				html += '</div>';

				$('#panellastfriend .bookboxlink').before(html);
				$('#panellastfriend .bookboxlink').show();
				$('#panelfriendlist .tipsy-hovercard-trigger').tipsyHoverCard();
			}
			else
			{
				$('#panellastfriend .bookboxlink').before('<p class="empty">Kh&#244;ng c&#243; b&#7841;n b&#232; n&#224;o</p>');
				$('#panellastfriend .bookboxlink').hide();
			}

	   }
	 });
}


/**
* Load cac friend vua moi cap nhat thong tin cua user
*/
function user_mypage()
{
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/pagelike/mypageajax',
	   error: function(){

		  		//showGritterError('');
		   },
	   success: function(xml){
			var count = $(xml).find('count').text();

			if(count != '0')
			{
				var html = '';
				$(xml).find('user').each(function(){

					var notificationstr = '';

					if($(this).find('notification').text() != '0')
						notificationstr = '<span class="linklist-number linklist-number-blue" title="C&#243; ' + $(this).find('notification').text() + ' ho&#7841;t &#273;&#7897;ng m&#7899;i">' + $(this).find('notification').text() + '</span>';

					html += '<li class="wide"><a class="black" href="' + $(this).find('userurl').text() + '" title="' + $(this).find('fullname').text() + '"><img class="sp16" alt="-" src="' + $(this).find('avatar').text() + '" />' + $(this).find('fullname').text() + notificationstr + '</a></li>';
				});

				$('#userlikelist').html(html);

			}


	   }
	 });
}



/**
* Load cac blog moi nhat vua duoc them trong website cua user
*/
function user_panelBlog()
{
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/blog/latestajax/',
	   error: function(){

		  		//showGritterError('');
		   },
	   success: function(xml){
			var count = $(xml).find('count').text();

			if(count != '0')
			{
				var html = '';
				$(xml).find('blog').each(function(){
					html += '<div class="book">';
					html += '	<div class="cover"><a href="' + $(this).find('url').text() + '"><img src="' + $(this).find('image').text() + '" alt="" /></a></div>';
					html += '	<div class="title"><a href="' + $(this).find('url').text() + '">' + $(this).find('title').text() + '</a></div>';
					html += '	<div class="moreinfo">';
					html += '		<p>"' + $(this).find('text').text() + '"</p>';
					html += '	</div>';
					html += '	<div class="bottom"></div>';
					html += '</div>';

				});

				$('#panelblog .bookboxlink').before(html);
				$('#panelblog .bookboxlink').show();
			}
			else
			{
				$('#panelblog .bookboxlink').before('<p class="empty">Ch&#432;a c&#243; b&#224;i vi&#7871;t n&#224;o</p>');
				$('#panelblog .bookboxlink').hide();
			}

	   }
	 });
}


/**
* Load cac fan cua 1 page
*/
function user_panelLastFan(from)
{
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/pagelike/lastactionajax',
	   error: function(){

		  		//showGritterError('');
		   },
	   success: function(xml){
			var count = $(xml).find('count').text();

			if(count != '0')
			{
				var html = '<div id="panelfriendlist">';
				$(xml).find('user').each(function(){
					html += '<a class="frienditemimage tipsy-hovercard-trigger" data-url="'+$(this).find('hovercardurl').text()+'" title="' + $(this).find('fullname').text() + '" href="' + $(this).find('userurl').text() + '"><img src="' + $(this).find('avatar').text() + '" alt="" /></a>';
				});
				html += '</div>';

				$('#panellastfriend .bookboxlink').before(html);
				$('#panellastfriend .bookboxlink').show();
				$('#panelfriendlist .tipsy-hovercard-trigger').tipsyHoverCard();

			}
			else
			{
				$('#panellastfriend .bookboxlink').before('<p class="empty">Kh&#244;ng c&#243; b&#7841;n b&#232; n&#224;o</p>');
				$('#panellastfriend .bookboxlink').hide();
			}

	   }
	 });
}



/**
* Sumit status len tuong nha nguoi khac
*/
function user_statusadd(type)
{
	//var message = $("#statusbox #statusboxtext").val();
	//use new method to get message, because check the tagged items
	var message = '';
	$('.mentionable_status').mentionsInput('val', function(text) {
	      message = text;
	    });



	//chi co loai status thong thuong moi cho add link
	//doi voi cac loai status nhu note/review/quote
	//check add link status
	var moreparam = '';
	var requesturl = userurl + '/status/addajax';

	//link info
	if($('#statusbox_link_attach').val() == "1")
	{
		var curimage = $('#statusbox_link #cur_image').val();
		var imageurl = '';
		if(curimage > 0)
			imageurl = $('#statusbox_link img#'+curimage).attr('src');

		moreparam += '&u=' + encodeURIComponent($('#statusbox_link #url').val()) + '&t=' + encodeURIComponent($('#statusbox_link #title_edit').val()) + '&d=' + encodeURIComponent($('#statusbox_link #desc_edit').val()) + '&i=' + encodeURIComponent(imageurl);
	}
	//end link info

	$("#statusbox #statusboxSubmitButton").before('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#statusbox .statuscontrol .sright input").attr('disabled', 'disabled');

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'ftype='+type+'&fmessage=' + encodeURIComponent(message) + moreparam,
	   url: requesturl,
	   error: function(){
		   	$("#statusbox .statuscontrol .sright input").removeAttr('disabled');
			$("#statusbox img.tmp_indicator").remove();
		   },
	   success: function(xml){
			$("#statusbox .statuscontrol .sright input").removeAttr('disabled');
			$("#statusbox img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);

				//clear statux box
				$("#statusbox #statusboxtext").val("");


				//insert latest comment
				var feedId = $(xml).find('id').text();
				var feedData = $(xml).find('data').text();

				//because add new review be queued, server will return feed id = 0
				if(feedId != '0')
				{
					var feed = '';
					feed += '<div class="act_entry hide" id="act_entry_'+feedId+'">';
					feed += '	<div class="avatar"><a href="' + $(xml).find('userurl').text() + '" title=""><img src="'+$(xml).find('avatar').text()+'" alt="" /></a></div>';
					feed += '	<div class="info">' + feedData + '</div>';
					feed += '	<div class="clear"></div>';
					feed += '</div>';
					$("#activitybox").prepend(feed);

					//convert timestamp to relativetime
					$("#activitybox #act_entry_" + feedId + ' .relativetime').each(function(){
						$(this).text(relativeTime($(this).text()));
						$(this).show();
					});

					$("#activitybox #act_entry_" + feedId).fadeIn('slow');
				}


				if($('#statusbox_link_attach').val() == "1")
				{
					$('#statusbox_link #statusbox_link_attach').val(0);
					$('#statusbox_link').hide();
					$('#statusbox_link #url').val('');
					$('#statusbox_link #loader').html('');
					$('#statusbox_link_trigger').show();
				}

				//reset current mention data
				$('.mentionable_status').mentionsInput('reset');
				$("#statusbox #statusboxtext").css('height', '50px');
			}
			else
			{
				showGritterError(message);

				 $("#statusbox #statusboxtext").focus();
			}
	   }
	 });
}




/**
* Sumit status len tuong nha nguoi khac
*/
function user_feedcommentadd(feedid)
{
	$("#act_entry_" + feedid + " .act_reply_add .button").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	//do dung he thong mention trong reply nen su dung co che khac de lay message
	//var message = $("#act_entry_" + feedid + " .act_reply_add .fmessage").val();
	var message = '';
	$('.mentionable_feed' + feedid).mentionsInput('val', function(text) {
	      message = text;
	    });

	$("#act_entry_" + feedid + " .act_reply_add .button").attr('disabled', 'disabled');

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'fmessage=' + encodeURIComponent(message) + '&feedid=' + feedid,
	   url: userurl + '/feedcomment/addajax',
	   error: function(){
		   	$("#act_entry_" + feedid + " .act_reply_add .button").removeAttr('disabled');
			$("#act_entry_" + feedid + " .act_reply_add img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#act_entry_" + feedid + " .act_reply_add .button").removeAttr('disabled');
			$("#act_entry_" + feedid + " .act_reply_add img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);

				//clear statux box
				$("#act_entry_" + feedid + " .act_reply_add .fmessage").val("");


				//insert latest comment
				var commentId = $(xml).find('id').text();

				var comment = '';
				comment += '<div id="act_reply_'+commentId+'" class="act_reply hide">';
				comment += '	<div class="avatar">';
				comment += '		<a title="" href="'+ $(xml).find('userurl').text()+'"><img alt="" src="'+ $(xml).find('avatar').text()+'"></a>';
				comment += '	</div>';
				comment += '	<div class="info">';
				comment += '		<div class="text"><a title="" href="'+ $(xml).find('userurl').text()+'" class="username">'+ $(xml).find('poster').text()+'</a> <span class="datetime relativetime">'+ $(xml).find('datecreated').text()+'</span><br><span class="commenttext">'+ $(xml).find('text').text()+'</span></div>';
				comment += '		<div class="more">';
				comment += '		</div>';
				comment += '	</div>';
				comment += '</div>';



				$("#act_entry_" + feedid + " .act_entry_reply .act_reply_add").before(comment);
				$("#act_reply_" + commentId).fadeIn('slow');

				//convert timestamp to relativetime
				$("#act_reply_" + commentId + ' .relativetime').each(function(){
					$(this).text(relativeTime($(this).text()));
					$(this).show();
				});

				//user_formatCommentText('#act_reply_' + commentId + ' .commenttext');

				//blur
				$("#act_entry_" + feedid + " .act_reply_add .fmessage").blur();
				$('.mentionable_feed' + feedid).mentionsInput('reset');
			}
			else
			{
				showGritterError(message);

				 $("#act_entry_" + feedid + " .act_reply_add .fmessage").focus();
			}
	   }
	 });
}






/**
* select tat ca comment cua 1 feed
*/
function user_feedcomment(feedid)
{
	$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore input:last").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore input:last").attr('disabled', 'disabled');

	var start = $('#activitybox #act_entry_reply_morestart_' + feedid).val();
	var commentid_first = parseInt($("#act_entry_comment_first_" + feedid).val());
	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'feedid=' + feedid,
	   url: userurl + '/feedcomment/indexajax?start=' + start,
	   error: function(){
		   	$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore input:last").removeAttr('disabled');
			$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore input:last").removeAttr('disabled');
			$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore img.tmp_indicator").remove();


			var count = $(xml).find('count').text();
			var nextstart = $(xml).find('nextstart').text();
			var loadedcount = $(xml).find('loadedcount').text();
			var remaincomment = $(xml).find('remaincomment').text();
			var candelete = $(xml).find('candelete').text();

			if(count != '0')
			{
				var html = '';
				$(xml).find('comment').each(function(){

					var commentid = parseInt($(this).find('id').text());

					if(commentid < commentid_first)
					{
						//get screename from userpath
						var userurl = $(this).find('userurl').text();


						var lastindexof = userurl.lastIndexOf('/');
						var screenname = userurl.substr(lastindexof + 1);

						html += '<div id="act_reply_'+commentid+'" class="act_reply act_reply_ajax hide">';
						html += '	<div class="avatar">';
						html += '		<a class="tipsy-hovercard-trigger" data-url="'+$(this).find('hovercardurl').text()+'" title="" href="'+ $(this).find('userurl').text()+'"><img alt="" src="'+ $(this).find('avatar').text()+'"></a>';
						html += '	</div>';
						html += '	<div class="info">';
						html += '		<div class="replyto"><a href="javascript:void(0)" onclick="user_feedReplyToUser(\''+ $(this).find('poster').text().replace("'", "\\'")+'\', \''+screenname+'\', '+feedid+')" title="G&#7903;i tr&#7843; l&#7901;i t&#7899;i '+ $(this).find('poster').text()+'">Tr&#7843; l&#7901;i</a></div>';
						if(candelete == 1)
						{
							html += '	<div class="delete remove_btn"><a href="javascript:void(0)" onclick="feedCommentRemove(\''+commentid+'\')" title="X&#243;a tr&#7843; l&#7901;i n&#224;y">X&#243;a</a>&nbsp;&nbsp;</div>';
						}
						html += '		<div class="text"><a title="" href="'+ $(this).find('userurl').text()+'" class="username tipsy-hovercard-trigger" data-url="'+$(this).find('hovercardurl').text()+'">'+ $(this).find('poster').text()+$(this).find('nameicon').text()+'</a> <span class="datetime relativetime">'+ $(this).find('datecreated').text()+'</span><br><span class="commenttext">'+ user_formatCommentTextForText($(this).find('text').text())+'</span></div>';
						html += '		<div class="more">';
						html += '		</div>';
						html += '	</div>';
						html += '</div>';
					}


				});

				$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore").after(html);
				$("#activitybox #act_entry_" + feedid + ' .act_reply_ajax').fadeIn();


				if(remaincomment > 0)
				{
					$('#activitybox #act_entry_reply_morestart_' + feedid).val(nextstart);
					//upgrade loaded count
					$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore span").text(loadedcount).show();
				}
				else
				{
					$("#activitybox #act_entry_" + feedid + " .act_entry_reply_showmore").hide();
				}

				//convert timestamp to relativetime
				$("#activitybox #act_entry_" + feedid + ' .act_reply_ajax .relativetime').each(function(){
					$(this).text(relativeTime($(this).text()));
					$(this).show();
				});

				$("#activitybox #act_entry_" + feedid + ' .act_reply_ajax .tipsy-hovercard-trigger').tipsyHoverCard();


				//scrollTo("#act_entry_" + feedid);

				//show reply from too
				$("#activitybox #act_entry_" + feedid + " .act_reply_add").show();
			}
			else
			{

			}


	   }
	 });
}




/**
* tiep tuc request feed
*/
function user_feedMore(isFromHome)
{

	var nextpage = $("#activitynextpage").text();

	console.log(nextpage);

	if($('#activitymore a img.tmp_indicator').length > 0 || $('#activity_page_' + nextpage).length > 0)
	{

		return false;
	}


	$("#activitymore a").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#activitymore a").hide();

	var param = '';
	if(isFromHome == 1)
	{
		param = '?home';
	}

	$.ajax({
	   type: "POST",
	   dataType: 'html',
	   data: 'page=' + nextpage,
	   url: userurl + '/feed/indexajax' + param,
	   error: function(){
		   	$("#activitymore a").show();
			$("#activitymore img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(html){
			$("#activitymore a").show();
			$("#activitymore img.tmp_indicator").remove();

			if(html != 'empty')
			{
				$("#activitybox").append('<div id="activity_page_' + nextpage + '" class="hide">'+html+ '</div>');

				//convert timestamp to relativetime
				$('#activitybox #activity_page_' + nextpage + ' .relativetime').each(function(){
					$(this).text(relativeTime($(this).text()));
					$(this).show();
				});


				//add event for hovercard
				$('#activitybox #activity_page_' + nextpage + ' .act_entry').each(function(){
					if($(this).hasClass('act_entry_minify'))
					{
						$(this).find('.text a').bind('click', function(event){event.preventDefault();});
					}
					else
					{
						$(this).find('.tipsy-hovercard-trigger').tipsyHoverCard();
					}
				});



				//user_formatStatusText('#activitybox #activity_page_' + nextpage + ' .statustext');

				//user_formatCommentText('#activitybox #activity_page_' + nextpage + ' .commenttext');

				$('#activity_page_' + nextpage).show();


				//mention feature for recent feed
				$('#activity_page_' + nextpage + ' .mentionable').mentionsInput({
				  	onDataRequest:function (mode, query, callback) {
					      $.getJSON(meurl + '/recommendation/mention?tag=' + query, function(responseData) {
					        responseData = _.filter(responseData, function(item) { return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1 ||  item.namesearch.toLowerCase().indexOf(query.toLowerCase()) > -1});
					        callback.call(this, responseData);
					      });
					    }
				});

				feedPostProcess();


				//truncate by height - DISABLED 'cause of bug
				if(false)
				$('#activitybox #activity_page_' + nextpage + ' .statustext').each(function(){
					$(this).ThreeDots({max_rows:4, ellipsis_string:'<span class="threedots_ellipsis_wrapper">...<br /><a class="unshorten" href="javascript:void(0)" onclick="user_unshorten(event)">Xem &#273;&#7847;y &#273;&#7911;</a></span>'});

				});

				nextpage++;
				$("#activitynextpage").text(nextpage);

			}
			else
			{
				//this is firstpage, just show no thing
				if(nextpage == 1)
				{
					$('#activitybox').prepend('<em>Chưa có hoạt động nào.</em>');
				}

				$("#activitymore").hide();
			}


	   }
	 });
}

function feedPostProcess()
{
	//binding click minified feed
	$('.act_entry_minify').each(function(){
		$(this).bind('click', function(event){

			$(this).fadeOut('fast', function(){
				$(this).unbind('click');

				$(this).find('.act_entry_reply').show();
				$(this).removeClass('act_entry_minify');

				//remove hovercard bind
				//$(this).find('.text a.tipsy-hovercard-trigger').unbind('mouseover');
				$(this).find('.tipsy-hovercard-trigger').tipsyHoverCard();
				//$(this).find('.more .comment_btn').trigger('click');
				$(this).find('.text a').unbind('click');


				$(this).fadeIn('slow');
			});

		});
	});

	$('.act_entry').hoverIntent({
        sensitivity: 7, // number = sensitivity threshold (must be 1 or higher)
        interval: 500, // number = milliseconds for onMouseOver polling interval
        timeout: 500, // number = milliseconds delay before onMouseOut
        over: function() {
			var feedid=$(this).attr('id').replace('act_entry_', '');
            $(this).addClass('act_entry_hoverfx');
			//feedHoverPanelLoad(feedid);

			//remove minify status
			if($(this).hasClass('act_entry_minify'))
			{
				$(this).fadeOut('fast', function(){
					$(this).unbind('click');
					$(this).find('.act_entry_reply').show();
					$(this).removeClass('act_entry_minify');

					//remove hovercard bind
					//$(this).find('.text a.tipsy-hovercard-trigger').unbind('mouseover');
					$(this).find('.tipsy-hovercard-trigger').tipsyHoverCard();
					$(this).find('.text a').unbind('click');


					$(this).fadeIn('slow');
				});
			}
        }, // function = onMouseOver callback (REQUIRED)
        out: function() {
			var feedid=$(this).attr('id').replace('act_entry_', '');
			$(this).removeClass('act_entry_hoverfx');
			$('#act_entry_panel_' + feedid).hide();
		} // function = onMouseOut callback (REQUIRED)
    });
}


function feedEdit_popup(feedId)
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    meurl + '/feed/edit/' + feedId,
		player:     "iframe",
		options: {
					   modal:   true
		},
		height:     400,
		width:      570
	});
}


function feedEdit(feedId)
{
	$("#formreview #fsubmit").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	//do not use this, because we use mentionable tag box
	//var message = $("#formreview #fmessage").val();
	var message = '';
	$('#formreview #fmessage').mentionsInput('val', function(text) {
	      message = text;
	    });

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'fmessage=' + encodeURIComponent(message),
	   url: meurl + '/feed/editajax/' + feedId,
	   error: function(){
		   	$("#formreview #fsubmit").removeAttr('disabled');
			$("#formreview img.tmp_indicator").remove();
		   },
	   success: function(xml){
			$("#formreview #fsubmit").removeAttr('disabled');
			$("#formreview img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
			}
			else
			{
				showGritterError(message);
				$("#formreview #fmessage").focus();
			}
	   }
	 });
}

function feedRemove(feedid)
{

	bootbox.confirm(delConfirm, function(confirmed){
		if(confirmed)
		{
			$("#act_entry_" + feedid + " .remove_btn").hide().after('<img class="tmp_indicator fr" src="'+imageDir+'ajax_indicator.gif" border="0" />');
			$.ajax({
			   type: "GET",
			   dataType: 'xml',
			   data: 'feedid=' + feedid,
			   url: userurl + '/feed/removeajax/',
			   error: function(){
				   $("#act_entry_" + feedid + " .remove_btn").show()
				   $("#act_entry_" + feedid + " img.tmp_indicator").remove();
				   //showGritterError('');
				   },
			   success: function(xml){

				   $("#act_entry_" + feedid + " img.tmp_indicator").remove();

					var success = $(xml).find('success').text();
					var message = $(xml).find('message').text();

					if(success == "1")
					{
						showGritterSuccess(message);

						$("#activitybox #act_entry_" + feedid).fadeOut();
					}
					else
					{
						$("#act_entry_" + feedid + " .remove_btn").show();
						showGritterError(message);

					}
			   }
			 });
		}
	});


}


function feedCommentEdit_popup(feedcommentId)
{
	// open a welcome message as soon as the window loads
	Shadowbox.open({
		content:    meurl + '/feedcomment/edit/' + feedcommentId,
		player:     "iframe",
		options: {
					   modal:   true
		},
		height:     400,
		width:      570
	});
}


function feedCommentEdit(feedcommentId)
{
	$("#formreview #fsubmit").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	//do not use this, because we use mentionable tag box
	//var message = $("#formreview #fmessage").val();
	var message = '';
	$('#formreview #fmessage').mentionsInput('val', function(text) {
	      message = text;
	    });

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'fmessage=' + encodeURIComponent(message),
	   url: meurl + '/feedcomment/editajax/' + feedcommentId,
	   error: function(){
		   	$("#formreview #fsubmit").removeAttr('disabled');
			$("#formreview img.tmp_indicator").remove();
		   },
	   success: function(xml){
			$("#formreview #fsubmit").removeAttr('disabled');
			$("#formreview img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
			}
			else
			{
				showGritterError(message);
				$("#formreview #fmessage").focus();
			}
	   }
	 });
}

function feedCommentRemove(commentid)
{

	if (confirm(delConfirm))
	{
		$("#act_reply_" + commentid + " .remove_btn").hide().after('<img class="tmp_indicator fr" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   data: 'commentid=' + commentid,
		   url: userurl + '/feedcomment/removeajax/',
		   error: function(){
			   $("#act_reply_" + commentid + " .remove_btn").show()
			   $("#act_reply_" + commentid + " img.tmp_indicator").remove();
			   //showGritterError('');
			   },
		   success: function(xml){

			   $("#act_reply_" + commentid + " img.tmp_indicator").remove();

				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();

				if(success == "1")
				{
					showGritterSuccess(message);

					$("#activitybox #act_reply_" + commentid).fadeOut();
				}
				else
				{
					$("#act_reply_" + commentid + " .remove_btn").show();
					showGritterError(message);

				}
		   }
		 });
	}


}




function feedUnfollow(feedid)
{

	$("#activity_unfollow a").hide().after('<img class="tmp_indicator fr" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/feed/unfollowajax/'+feedid,
	   error: function(){
		   $("#activity_unfollow a").show()
		   $("#activity_unfollow img.tmp_indicator").remove();
		   //showGritterError('');
		   },
	   success: function(xml){

		   $("#activity_unfollow img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
			}
			else
			{
				$("#activity_unfollow a").show();
				showGritterError(message);
			}
	   }
	 });


}


//xoa thanh vien khoi danh sach ban be
function user_deleteFriend(friendid)
{
	if (confirm(delConfirm))
	{
		$("#friend-" + friendid + ' .remove').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		$("#friend-" + friendid + " .remove").hide();
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: userurl + '/friend/deleteajax/' + friendid,
		   error: function(){
				$("#friend-" + friendid + " img.tmp_indicator").remove();
				$("#friend-" + friendid + " .remove").show();
				//showGritterError('');
			   },
		   success: function(xml){
				$("#friend-" + friendid + " img.tmp_indicator").remove();
				$("#friend-" + friendid + " .remove").show();

				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();

				if(success == "1")
				{
					showGritterSuccess(message);
					$("#friend-" + friendid).fadeOut();
				}
				else
				{
					showGritterError(message);
				}
		   }
		 });
	}
}

//xoa thanh vien khoi danh sach ban be
function user_requestFriend(friendid)
{
	$("#friend-" + friendid + ' .request').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#friend-" + friendid + " .request").hide();
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/friend/requestajax/' + friendid,
	   error: function(){
			$("#friend-" + friendid + " img.tmp_indicator").remove();
			$("#friend-" + friendid + " .request").show();
			//showGritterError('');
		   },
	   success: function(xml){
			$("#friend-" + friendid + " img.tmp_indicator").remove();
			$("#friend-" + friendid + " .request").show();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
				$("#friend-" + friendid + " .request").hide();
			}
			else
			{
				showGritterError(message);
			}
	   }
	 });
}

//dong y ket ban
function user_addFriend(friendid)
{

	$("#friend-" + friendid + ' .request').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#friend-" + friendid + " .request").hide();
	$("#friend-" + friendid + " .remove").hide();
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: userurl + '/friend/addajax/' + friendid,
	   error: function(){
			$("#friend-" + friendid + " img.tmp_indicator").remove();
			$("#friend-" + friendid + " .request").show();
			$("#friend-" + friendid + " .remove").show();
			//showGritterError('');
		   },
	   success: function(xml){
			$("#friend-" + friendid + " img.tmp_indicator").remove();
			$("#friend-" + friendid + " .request").show();
			$("#friend-" + friendid + " .remove").show();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
				$("#friend-" + friendid + " .request").hide();
				$("#friend-" + friendid + " .remove").hide();
			}
			else
			{
				showGritterError(message);
			}
	   }
	 });

}



//tu choi ket ban
function user_deleteRequest(friendid)
{
	if (confirm(delConfirm))
	{
		$("#friend-" + friendid + ' .remove').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		$("#friend-" + friendid + " .request").hide();
		$("#friend-" + friendid + " .remove").hide();
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: userurl + '/friend/deleterequestajax/' + friendid,
		   error: function(){
				$("#friend-" + friendid + " img.tmp_indicator").remove();
				$("#friend-" + friendid + " .request").show();
				$("#friend-" + friendid + " .remove").show();
				//showGritterError('');
			   },
		   success: function(xml){
				$("#friend-" + friendid + " img.tmp_indicator").remove();
				$("#friend-" + friendid + " .request").show();
				$("#friend-" + friendid + " .remove").show();

				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();

				if(success == "1")
				{
					showGritterSuccess(message);
					$("#friend-" + friendid + " .request").hide();
					$("#friend-" + friendid + " .remove").hide();
					$("#friend-" + friendid + "").remove();
				}
				else
				{
					showGritterError(message);
				}
		   }
		 });
	}
}



//goi yeu cau join page
function user_requestPagelike(uidpage)
{
	$("#friend-" + uidpage + ' .request').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
	$("#friend-" + uidpage + " .request").hide();
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/pagelike/requestajax/' + uidpage,
	   error: function(){
			$("#friend-" + uidpage + " img.tmp_indicator").remove();
			$("#friend-" + uidpage + " .request").show();
			//showGritterError('');
		   },
	   success: function(xml){
			$("#friend-" + uidpage + " img.tmp_indicator").remove();
			$("#friend-" + uidpage + " .request").show();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);
				$("#friend-" + uidpage + " .request").hide();
			}
			else
			{
				showGritterError(message);
			}
	   }
	 });
}

//xoa thanh vien khoi danh sach ban be
function user_deletePagelike(pagelikeid)
{
	if (confirm(delConfirm))
	{
		$("#friend-" + pagelikeid + ' .remove').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		$("#friend-" + pagelikeid + " .remove").hide();
		$.ajax({
		   type: "GET",
		   dataType: 'xml',
		   url: userurl + '/pagelike/deleteajax/' + pagelikeid,
		   error: function(){
				$("#friend-" + pagelikeid + " img.tmp_indicator").remove();
				$("#friend-" + pagelikeid + " .remove").show();
				//showGritterError('');
			   },
		   success: function(xml){
				$("#friend-" + pagelikeid + " img.tmp_indicator").remove();
				$("#friend-" + pagelikeid + " .remove").show();

				var success = $(xml).find('success').text();
				var message = $(xml).find('message').text();

				if(success == "1")
				{
					showGritterSuccess(message);
					$("#friend-" + pagelikeid).fadeOut();
				}
				else
				{
					showGritterError(message);
				}
		   }
		 });
	}
}


/////////////////////////////////////////////////
/* BLOG COMMENT */
function user_blogcommentAdd(blogId)
{

	$("#formcomment #fsubmit").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	//do not use this, because we use mentionable tag box
	//var message = $("#formcomment #fmessage").val();
	var message = '';
	$('#formcomment #fmessage').mentionsInput('val', function(text) {
	      message = text;
	    });


	$("#formcomment #fsubmit").attr('disabled', 'disabled');

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'fmessage=' + encodeURIComponent(message),
	   url: userurl + '/blogcomment/addajax/' + blogId,
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
				//$("#formcomment #fmessage").val("");
				$('#formcomment #fmessage').mentionsInput('reset');


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

				//user_formatCommentText($('#bookcomment #comment-' + commentId + ' .text'));
				scrollTo("#comment-" + commentId);


			}
			else
			{
				showGritterError(message);
				$("#formcomment #fmessage").focus();
			}
	   }
	 });
}


function user_blogcommentLoad(blogId, page)
{

	$("#bookcomment .commentlist").html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: userurl + '/blogcomment/indexajax/'+blogId+'?page=' + page,
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
			   	if(selectedcomment != "")
				{
					scrollTo("#comment-" + selectedcomment);
				}

				//trigger
				$('#reviewpage-' + page + ' .tipsy-hovercard-trigger').tipsyHoverCard();
		   }

	   }
	 });
}


function user_blogcommentRemove(url, commentId)
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

function user_blogcommentReport(url, title)
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

function user_blogReport(url, title)
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



function user_formatStatusText(selector)
{
	$(selector).each(function(){

		//store the original text, for unshorten
		var formatedText = formatMediaText($(this).html());


		//replace link,img..

		//because not use Threedot for truncate, just show the original
		//$(this).html('<span class="statustextoriginal hide">'+ formatedText + '</span>');
		$(this).html('<span class="statustextoriginal">'+ formatedText + '</span>');

		//disabled because disable Threedots
		//$(this).append('<span class="ellipsis_text">'+formatedText+'</span>');



	});
}

function user_formatCommentText(selector)
{
	$(selector).each(function(){
		//var msg = htmlspecialchars($(this).text());

		//$(this).html($(this).html());
	});
}

function user_formatCommentTextForText(text)
{
	//var msg = htmlspecialchars(text);
	var msg = text;
	msg = formatSmileyText(msg);
	msg = msg.replace(/(@([a-z0-9.]+)\[([^\]]+)\])/gi,'<a href="'+rooturl+'$2" target="_blank" title="T&#7899;i nh&#224; c&#7911;a $3">@$3</a>');
	msg = nl2br(msg, true);

	return msg;
}

function formatMediaText(msg)
{

	//after using MentionsInput, ignore this format
	return msg;


	msg = htmlspecialchars(msg);




	var IM_mp3FlashPlayer = imageDir + "dewplayer.swf";

	//reformat image url to pass the URL convert (it's a trick ^^)
	msg = msg.replace(/((http:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/gi,'image://$3');

	//reformat image url to pass the URL convert (it's a trick ^^) - HTTPS version (picasa google images gallery)
	msg = msg.replace(/((https:)\/\/(([^\s]*)\.(jpg|jpeg|gif|png)))/gi,'images://$3');


	//reformat music url to pass the URL convert (it's a trick ^^)
	msg = msg.replace(/((http:)\/\/(([^\s]*)(\.mp3)))/gi,'musicmp3://$3');


	//reformat youtube to pass the URL convert (it's a trick ^^)
	//msg = msg.replace(/((http:\/\/|http:\/\/www.)youtube.com\/watch\?v\=([a-zA-Z0-9_]*)([^\s]*))/gi,'$1 youtube://$3 ');

	//reformat nhac cua tui to pass the URL convert (it's a trick ^^)
	//msg = msg.replace(/((http:\/\/|http:\/\/www.)nhaccuatui.com\/nghe\?M\=([a-zA-Z0-9_]*)([^\s]*))/gi,'$1 nhacuatui://$3 ');

	//reformat flash to pass the URL convert (it's a trick ^^)
	//msg = msg.replace(/((http:)\/\/(([^\s]*)(\.swf)))/gi,'flashswf://$3');

	//convert URL text to hyperlink
	//replace following is bug with text have more than 1 url, this is really huge bug in js to hangout the webpage
	//msg = msg.replace(/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*))/gi,'<a class="statustext_link" title="$1" href="$1" rel="nofollow" target="_blank">[link]</a>');


	msg = msg.replace(/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*))/gi,'<div class="statustext_image"><a title="http://$3" href="http://$3" rel="nofollow" target="_blank">http://$3</a></div>');


	//fix version
	//msg = msg.replace(/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*\.(html|php|aspx)))/gi,'<a class="statustext_link" title="$1" href="$1" rel="nofollow" target="_blank">[$1]</a>');
	//fix advance version
	//msg = msg.replace(/((https:\/\/|http:\/\/|ftp:\/\/)([^\s]*[^jpegifpn]{3,4}))/gi,'<a class="statustext_link" title="$1" href="$1" rel="nofollow" target="_blank">[link]</a>');

	//convert image format to real image html tag
	msg = msg.replace(/((image:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/gi,'<div class="statustext_image"><a title="http://$3" href="http://$3" rel="nofollow" target="_blank"><img src="http://$3" /></a></div>');

	//convert image format to real image html tag
	msg = msg.replace(/((images:)\/\/(([^\s]*)\/([^\s]+\.(jpg|jpeg|gif|png))))/gi,'<div class="statustext_image"><a title="https://$3" href="https://$3" rel="nofollow" target="_blank"><img src="https://$3" /></a></div>');

	//convert mp3music format to real flashplayer
	msg = msg.replace(/((musicmp3:)\/\/(([^\s]*)\/([^\s]+\.(mp3))))/gi,'<div class="statustext_mp3"><object width="200" height="20"><param name="movie" value="'+IM_mp3FlashPlayer+'?mp3=http://$3"></param><param name="allowscriptaccess" value="always"></param><embed src="'+IM_mp3FlashPlayer+'?mp3=http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" width="200" height="20"></embed></object></div>');


	//convert youtube format to real flash player
	//msg = msg.replace(/((youtube:)\/\/(([^\s]*)))/gi,'<div class="statustext_youtube"><object width="390" height="280"><param name="movie" value="http://www.youtube.com/v/$3&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/$3&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="390" height="280"></embed></object></div>');

	//convert nhaccuatui format to real flash player
	//msg = msg.replace(/((nhacuatui:)\/\/(([^\s]*)))/gi,'<div class="statustext_nhacuatui"><object width="200" height="50"><param name="movie" value="http://www.nhaccuatui.com/m/$3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.nhaccuatui.com/m/$3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="200" height="50"></embed></object></div>');

	//convert youtube format to real flash player
	//msg = msg.replace(/((flashswf:)\/\/(([^\s]*)\/([^\s]+\.(swf))))/gi,'<div class="statustext_flash"><object width="210" height="170"><param name="movie" value="http://$3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://$3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="210" height="170"></embed></object></div>');


	//format newline
	msg = nl2br(msg, true);

	//format smiley text
	msg = formatSmileyText(msg);

	return msg;
}


/**
Ham dung de convert cac ky tu smiley tuong tu yahoo messenger sang bieu tuong mat cuoi
*/
function formatSmileyText(msg)
{
	//khong su dung smiley nua
	//ke tu ngay 21/7/2011
	/*
	//array store the replace text for smiley to format message before show in chatbox
	var IM_smileyFolder = imageDir + "smileys/";
	var IM_smileyTable = {"&gt;:D&lt;":"6.gif", ";;)":"5.gif", ':"&gt;':"9.gif", ":-*":"11.gif", "=((":"12.gif", ":-o":"13.gif", "&gt;:)":"19.gif", ":((":"20.gif", ":))":"21.gif", ":)":"1.gif", ":(":"2.gif", ";)":"3.gif", ":d":"4.gif", ":x":"8.gif", ":p":"10.gif", "x(":"14.gif"};

	//replace smiley text base on smileyTable data
	for(var text in IM_smileyTable)
	{
		var i = msg.indexOf(text);
		var replacetext = '<img src="' + IM_smileyFolder + IM_smileyTable[text] + '" align="top" />';

		while (i > -1){
			msg = msg.replace(text, replacetext);
			i = msg.indexOf(text);
		}

		text = text.toUpperCase();
		var i = msg.indexOf(text);
		while (i > -1){
			msg = msg.replace(text, replacetext);
			i = msg.indexOf(text);
		}

	}
	*/

	return msg;
}



function isValidURL(url){
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

	if(RegExp.test(url)){
		return true;
	}else{
		return false;
	}
}


$.fn.insertAtCaret = function (myValue) {
        return this.each(function(){
                //IE support
                if (document.selection) {
                        this.focus();
                        sel = document.selection.createRange();
                        sel.text = myValue;
                        this.focus();
                }
                //MOZILLA/NETSCAPE support
                else if (this.selectionStart || this.selectionStart == '0') {
                        var startPos = this.selectionStart;
                        var endPos = this.selectionEnd;
                        var scrollTop = this.scrollTop;
                        this.value = this.value.substring(0, startPos)
                                      + myValue
                              + this.value.substring(endPos,
this.value.length);
                        this.focus();
                        this.selectionStart = startPos + myValue.length;
                        this.selectionEnd = startPos + myValue.length;
                        this.scrollTop = scrollTop;
                } else {
                        this.value += myValue;
                        this.focus();
                }
        });
};


/*
	Xu ly nhan nut enter trong field Feed comment
*/
function user_onFeedReplyKeypress(e, feedid)
{
	if (e.keyCode == 13)
	{
		if(!e.shiftKey)
		{
			var message = $('#act_entry_' + feedid + ' textarea').val();
			if(message.length > 0)
			{
				user_feedcommentadd(feedid);
			}
		}
	}
}

function user_onFeedReplyFocus(feedid)
{
	var myselector = $('#act_entry_' + feedid + ' textarea');
	myselector.addClass('act_reply_textareafocus');
	if(myselector.val() == 'Nhap tra loi cua ban')
	{
		myselector.val('');
	}

	$('#act_entry_' + feedid + ' .act_reply_add .avatar').show();

	//khong su dung smiley nua
	//ke tu ngay 21/7/2011
	/*
	//insert smileybox if not existed
	if(myselector.parent().find('.commentsmileys').length == 0)
	{
		var smileyInsertTitle = 'Nh&#7845;n &#273;&#7875; th&#234;m bi&#7875;u t&#432;&#7907;ng';

		var IM_smileyTable = {":)":"1.gif", ":(":"2.gif", ";)":"3.gif",":d":"4.gif", ";;)":"5.gif",":x":"8.gif",':">':"9.gif",
			":p":"10.gif", ":-*":"11.gif", "=((":"12.gif",":-o":"13.gif", ">:)":"19.gif",":((":"20.gif",":))":"21.gif", "x(":"14.gif",">:D<":"6.gif"};

		var smileyHtml = '<div class="commentsmileys">';

		for(var text in IM_smileyTable)
		{
			smileyHtml += '<a href="javascript:void(0);" onclick="insertCommentSmiley('+feedid+', \''+escape(text)+'\')" ';
			smileyHtml += 'title="'+smileyInsertTitle+'"><img src="'+imageDir+'smileys/'+IM_smileyTable[text] +'" /></a>';
		}

		smileyHtml += '</div>';
		myselector.before(smileyHtml);
	}
	else
	{
		myselector.parent().find('.commentsmileys').slideDown();
	}
	*/

}

function insertCommentSmiley( feedid, smileytext)
{
	var myselector = $('#act_entry_' + feedid + ' textarea');
	myselector.focus();
	myselector.insertAtCaret(' ' + unescape(smileytext) + ' ').focus();
}

function user_onFeedReplyBlur(feedid)
{
	//fix bug click on minify entry and not fire because blur problem
	//settimeout to fire click event first
	setTimeout(function(){
        // original blur code here
		var myselector = $('#act_entry_' + feedid + ' textarea');

		if(myselector.val() == '')
		{
			myselector.val('Nhap tra loi cua ban');
			$('#act_entry_' + feedid + ' .act_reply_add .avatar').hide();

			myselector.parent().find('.commentsmileys').slideUp();
			myselector.removeClass('act_reply_textareafocus');
		}
    }, 250);




}

function user_feedReplyToUser(fullname, userid, feedid)
{
	var myselector = $('#act_entry_' + feedid + ' textarea');
	myselector.focus();

	//old way
	//var addstring = '@' + screenname + '['+ fullname +'] ';

	//new way
	var addstring = '@['+fullname+'](u:'+userid+') ';

	if(myselector.val() == '')
	{
		myselector.val(addstring);
	}
	else
	{
		//kiem tra xem da add replyto user nay chua
		//neu chua thi moi add them
		//con co roi thi khoi
		if(myselector.val().indexOf(addstring) == -1)
			if(myselector.val().indexOf(addstring + ',') == -1)
				myselector.val(myselector.val() + ', ' + addstring);
	}

}

/*
function user_feedReplyToUserScreenameVersion(screenname, feedid)
{
	var myselector = $('#act_entry_' + feedid + ' textarea');
	myselector.focus();
	var addstring = '@' + screenname + ' ';
	if(myselector.val() == '')
	{
		myselector.val(addstring);
	}
	else
	{
		//kiem tra xem da add replyto user nay chua
		//neu chua thi moi add them
		//con co roi thi khoi
		if(myselector.val().indexOf(addstring) == -1)
			if(myselector.val().indexOf('@' + screenname + ',') == -1)
				myselector.val(myselector.val() + ', ' + addstring);
	}

}
*/







/**
* Like 1 feed
*/
function user_feedlikeadd(feedid)
{
	$("#act_entry_" + feedid + " .like_btn").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	$("#act_entry_" + feedid + " .like_btn").hide();

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'feedid=' + feedid,
	   url: userurl + '/feedlike/addajax',
	   error: function(){
		   	$("#act_entry_" + feedid + " .like_btn").show();
			$("#act_entry_" + feedid + " img.tmp_indicator").remove();

			//showGritterError('');
		   },
	   success: function(xml){
			$("#act_entry_" + feedid + " img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				showGritterSuccess(message);

				//clear statux box
				$("#act_entry_" + feedid + " .act_reply_add .fmessage").val("");


				//insert latest comment
				var liketext = $(xml).find('liketext').text();
				$("#act_entry_" + feedid + " .like_btn").after(liketext);


			}
			else
			{
				showGritterError(message);

			}
	   }
	 });
}


function user_feedlikeall(url, title)
{
	// open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    url,
        player:     "iframe",
        title:      title,
        height:     600,
        width:      500
    });

}


///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
//RECOMMENDATION PROCESS FOR RIGHT PANEL
function user_recommendLoad(type)
{
	$('#recommendationfriendholder').html('<p class="tmp_indicator" style="text-align:center;"><img src="'+imageDir+'ajax_indicator.gif" /> L&#7845;y d&#7919; li&#7879;u b&#7841;n b&#232; chung...</p>')

	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: userurl + '/recommendation/indexajax?type=' + type,
	   error: function(){
		   		$("#recommendationfriendholder .tmp_indicator").remove();
		  		//showGritterError('');
		   },
	   success: function(html){
		   $("#recommendationfriendholder .tmp_indicator").remove();
			$('#recommendationfriendholder').html(html);

	   }
	 });
}


function user_recommendRequest(friendid, parentselector)
{
	$(parentselector + " #recbox-" + friendid + ' .btnrequest').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();

	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/friend/requestajax/' + friendid,
	   error: function(){
			$(parentselector + " #recbox-" + friendid + " img.tmp_indicator").remove();
			$(parentselector + " #recbox-" + friendid + ' .btnrequest').show();
			//showGritterError('');
		   },
	   success: function(xml){
			$(parentselector + " #recbox-" + friendid + " img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				$(parentselector + " #recbox-" + friendid + ' .recbutton').hide();
				showGritterSuccess(message);
			}
			else
			{
				showGritterError(message);
				$(parentselector + " #recbox-" + friendid + ' .btnrequest').show();
			}
	   }
	 });
}


function user_recommendHide(friendid, parentselector)
{

	$(parentselector + " #recbox-" + friendid + ' .btnhide').after('<img class="ff-buttonbig tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />').hide();

	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: meurl + '/recommendation/hideajax/' + friendid,
	   error: function(){
			$(parentselector + " #recbox-" + friendid + " img.tmp_indicator").remove();
			$(parentselector + " #recbox-" + friendid + ' .btnhide').show();
			//showGritterError('');
		   },
	   success: function(xml){
			$(parentselector + " #recbox-" + friendid + " img.tmp_indicator").remove();

			var success = $(xml).find('success').text();
			var message = $(xml).find('message').text();

			if(success == "1")
			{
				$(parentselector + " #recbox-" + friendid + ' .recbutton').hide();
				showGritterSuccess(message);
			}
			else
			{
				showGritterError(message);
				$(parentselector + " #recbox-" + friendid + ' .btnhide').show();
			}
	   }
	 });
}


function user_mutualdetail(url, title)
{
	// open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    url,
        player:     "iframe",
        title:      title,
        height:     600,
        width:      500
    });

}


function user_friendsearchprompt(poptitle)
{
	var name=prompt(poptitle,"");
	if (name!=null && name!="")
	  {
	  	document.location.href = meurl + '/friend/search?keyword=' + name;
	  }

}

function user_pagesearchprompt(poptitle)
{
	var name=prompt(poptitle,"");
	if (name!=null && name!="")
	  {
	  	document.location.href = rooturl + 'page/search?keyword=' + name;
	  }

}


function message_formadd(url, title)
{
	// open a welcome message as soon as the window loads
    Shadowbox.open({
        content:    url,
        player:     "iframe",
        title:      title,
        height:     450,
        width:      700
    });

}



function fanpage_notification(fanpageuserpath)
{
	$('#pagenotification').toggle();

	//check counter
	//neu > 0, co nghia la da update va co the send request de load
	var currentNotification = parseInt($("#pagenotificationcounter").text());

	//kiem tra list hien tai
	var currentShow = $("#pagenotification ul li").length;

	//neu currentnotification = 0, tuc la hien ko co notification nao moi
	//ma hien thoi trong notification list chua co notification item nao thi
	//moi request de lay default min item
	//con mac du = 0, nhung list da co thi ko load lai default min

	if(currentNotification > 0 || currentShow == 0)
	{
		$("#pagenotification .viewall").after('<div class="tmp_indicator" style="text-align:center;padding:10px 0;"><img src="'+imageDir+'ajax_indicator.gif" border="0" /></div>');

		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   url: fanpageuserpath + '/notification/indexajax',
		   error: function(){
				$("#pagenotification .tmp_indicator").remove();

				//showGritterError('');
			   },
		   success: function(xml){
				$("#pagenotification .tmp_indicator").remove();

				var count = $(xml).find('count').text();

				if(count != '0')
				{
					var html = '';
					$(xml).find('notification').each(function(){

						html += '<li><span class="avatar"><img src="'+$(this).find('avatar').text()+'" alt="" /></span><div class="info">'+$(this).find('data').text()+'</div></li>';
					});

					if(currentNotification > 0)
						$("#pagenotification ul").prepend(html);
					else
						$("#pagenotification ul").html(html);
				}

		   }
		 });

		//reset counter
		$("#pagenotificationcounter").hide();
	}
}


function user_fanpageresetnotification()
{
	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: userurl + '/pagelike/resetnotificationajax',
	   error: function(){

		   },
	   success: function(html){


	   }
	 });

	//reset counter
	$("#pagenotificationcounter").hide();
}


function user_feedmoreinview()
{
	$("#activitymore").bind("inview", function(isVisible) {


	  if (isVisible) {
		  var currentfeedpage = parseInt($('#activitynextpage').text()) - 1;

		  if(currentfeedpage < 5)
		  $('#activitymore a').trigger('click');
	  }


	});
}


function user_feedplayyoutube(feedid, youtubeid)
{
	var youtubeflashurl = '<div class="statustext_youtube"><object width="390" height="280"><param name="movie" value="http://www.youtube.com/v/'+youtubeid+'&hl=en&fs=1&autoplay=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'+youtubeid+'&hl=en&fs=1&autoplay=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="390" height="280"></embed></object></div>';

	$('#feedplayerholder_' + feedid).html(youtubeflashurl);
	$('#act_entry_' + feedid + ' .metatext').hide();
}

function user_feedplaynhaccuatui(feedid, type, nhaccuatuiid)
{
	var embedcode = '<div class="statustext_nhacuatui"><object width="390" height="50"><param name="movie" value="http://www.nhaccuatui.com/'+type+'/'+nhaccuatuiid+'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="autostart" value="true"></param><embed src="http://www.nhaccuatui.com/'+type+'/'+nhaccuatuiid+'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" flashvars="&autostart=true" width="390" height="50"></embed></object></div>';

	$('#feedplayerholder_' + feedid).html(embedcode);
	$('#act_entry_' + feedid + ' .metatext').hide();
}

function user_feedplayslideshare(feedid, url)
{
	$('#feedplayerholder_' + feedid).html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'width=390&height=280&url=' + url ,
	   url: rooturl + '/feedurlparser/slideshare',
	   error: function(){
			//error, go directly to url
			document.location.href = url;
		   },
	   success: function(xml){

			var success = $(xml).find('success').text();

			if(success == "1")
			{
				var embeddata = $(xml).find('embeddata').text();
				$('#feedplayerholder_' + feedid).html(embeddata);
				$('#act_entry_' + feedid + ' .metatext').hide();
			}
			else
			{
				document.location.href = url;
			}
	   }
	 });


}


function user_feedplayzingmusic(feedid, url)
{
	$('#feedplayerholder_' + feedid).html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

	$.ajax({
	   type: "POST",
	   dataType: 'xml',
	   data: 'width=390&height=280&url=' + url ,
	   url: rooturl + '/feedurlparser/zingmusic',
	   error: function(){
			//error, go directly to url
			document.location.href = url;
		   },
	   success: function(xml){

			var success = $(xml).find('success').text();

			if(success == "1")
			{
				var embeddata = $(xml).find('embeddata').text();
				$('#feedplayerholder_' + feedid).html(embeddata);
				$('#act_entry_' + feedid + ' .metatext').hide();
			}
			else
			{
				document.location.href = url;
			}
	   }
	 });


}


function user_loadprofile()
{
	$('#profileinfo').html(loadingtext);

	$.ajax({
	   type: "GET",
	   dataType: 'html',
	   url: userurl + '/info/indexajax',
	   error: function(){
			$('#profileinfo').html('Error loading.');
		   },
	   success: function(html){
			$('#profileinfo').html(html);
			$('#profileinfo .tipsy-trigger').tipsy();
	   }
	 });
}

function initEditInline(pcid)
{
	$('.gpa').each(function(index){

        $(this).editable(rooturl_cms+'productgroupattribute/editgroupattributeinline', {
                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
				tooltip   : "Click to edit",
                submitdata: {fpcid: pcid},
                callback: function(data){
                	//var getData = jQuery.parseJSON(data);
                	/*obj.attr({
                		id : 'gpa_' + data.id
                		name : 'gpa_' + data.id
                	});*/
                	//obj.html(data.name);
                	//$(this).html(getData.name);

                	var currId = $(this).attr('id');
                	var arrs = currId.split('_');
                	arr = data.split(':');
                	$('#rowpa_'+ arrs[1]).find('span').attr('id' , arr[0] + '_pa');
                	$('#faddbutton'+ arrs[1]).html('<input style="float:right;" class="btn btn-small btn-success" type="button" value="Thêm thuộc tính" onclick="addRow(\'rowpa_'+arr[0]+'\' , '+arr[0]+')" />');
                	$('#displayorder_'+ arrs[1]).attr('name' , 'fdisplayorder['+arr[0]+']');

                	arrays = data.split(':');
                	data = arrays[1];
                	$(this).html(data);
                	data = arrays[0];
                	$(this).attr("id" , data);
                	$('#rowgpa_'+arrs[1]).attr('id' , 'rowgpa_'+data);
                	$('#rowpa_'+arrs[1]).attr('id' , 'rowpa_'+data);

                	if(arrays.length == 2)
                	{
                		$('#'+data).after('<a id="dgpa_'+data+'" style="float:right;margin-right:20px;" title="Xóa dòng này" onclick="deleteGpa(\'rowgpa_\','+data+')" href="javascript:void(0)" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');
                	}

                	if(arrays.length == 3 && arrays[2] == 'error')
                	{
                		bootbox.alert('Vui lòng nhập tên của nhóm thuộc tính .');
                	}

                },
        }
		);
		//$(this).addClass('editbutton');
    });

    $('.pa').each(function(index){
    	var currId = $(this).attr('rel');
    	var arrs = currId.split('_');
    	var pgaid = arrs[1];
        $(this).editable(rooturl_cms+'productattribute/editattributeinline', {
                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
				tooltip   : "Click to edit",
                submitdata: {fpcid: pcid, fpgaid:pgaid},
                callback: function(data){
                	var arr = data.split(':');
                	data = arr[0];
                	if(data == 'pgaid')
                	{
                		$(this).html('Tên thuộc tính');
                		bootbox.alert('Vui lòng tạo nhóm thuộc tính cho sản phẩm trước .');
                	}
                	else
                	{
                		data = arr[1];
	                	$(this).html(data);
	                	data = arr[0];
	                	$(this).attr("id" , data);
	                	if(arr.length == 2)
	                	{
	                		$('#pa'+arrs[1]).attr('id' , 'pa'+data);
	                		$(this).css('padding-left' , '5px');
	                		$(this).before('<input style="float:left;" style="margin-right:2px;" class="input-mini" type="text" name="fpadisplayorder['+data+']" />');
	                		$(this).after('<a href="'+rooturl_cms+'productattribute/changegroup/id/'+data+'" title="Thay đổi nhóm"></a><a style="float:right;" title="Xóa dòng này" href="javascript:void(0)" onclick="deletePa('+data+')" class="btn btn-mini btn-danger"><i class="icon-remove icon-white" style="margin-top:1px;"></i></a>');
	                	}

	                	if(arr.length == 3 && arr[2] == 'error')
	                	{
	                		bootbox.alert('Vui lòng nhập tên nhóm thuộc tính');
	                	}
                	}
                },
        }
		);
		//$(this).addClass('editbutton');
    });
}

function initEditInlineEnemyPrice(fpid)
{
	$('.url').each(function(index){
    	var arrs = $(this).attr('id').split('_');
    	var fid = arrs[0];
    	var feid = $(this).attr('rel');
        $(this).editable(rooturl_admin+'productprice/editinlineurl', {
                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
				tooltip   : "Click to edit",
                submitdata: {fpid: fpid, fid:fid , feid:feid},
                callback: function(data){
                	var arr = data.split('_');
                	data = arr[0];
                	if(data == 'empty')
                	{
                		bootbox.alert('Vui lòng nhập url.');
                		data = arr[1];
	                	$(this).html(data);
                	}
                	else
                	{
	                	$('#'+fid+'_p').attr('id' , data);
	                	$('#'+fid+'_u').attr('id' , data);
	                	data = arr[1];
	                	$(this).html(data);

	                	$(this).editable(rooturl_admin+'productprice/editinlineurl', {
			                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
							tooltip   : "Click to edit",
			                submitdata: {fpid: fpid, fid:fid , feid:feid},
			                callback: function(data){
			                	var arr = data.split('_');
			                	data = arr[0];
			                	if(data == 'empty')
			                	{
			                		bootbox.alert('Vui lòng nhập url.');
			                		data = arr[1];
				                	$(this).html(data);
			                	}
			                	else
			                	{
				                	$('#'+fid+'_p').attr('id' , data);
				                	$('#'+fid+'_u').attr('id' , data);
				                	data = arr[1];
				                	$(this).html(data);
			                	}
			                	initEditInlineEnemyPrice(fpid);
			                },
			        	}
						);
                	}

                },
        }
		);
    });

    $('.price').each(function(index){
    	var arrs = $(this).attr('id').split('_');
    	var fid = arrs[0];
    	var feid = $(this).attr('rel');
        $(this).editable(rooturl_admin+'productprice/editinlineprice', {
                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
				tooltip   : "Click to edit",
                submitdata: {fpid: fpid, fid:fid , feid:feid},
                callback: function(data){
                	var arr = data.split('_');
                	data = arr[0];
                	$('#'+fid+'_p').attr('id' , data);
	                $('#'+fid+'_u').attr('id' , data);
                	data = arr[1];
                	$(this).html(data);
                	$(this).editable(rooturl_admin+'productprice/editinlineurl', {
			                indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
							tooltip   : "Click to edit",
			                submitdata: {fpid: fpid, fid:fid , feid:feid},
			                callback: function(data){
			                	var arr = data.split('_');
			                	data = arr[0];
			                	if(data == 'empty')
			                	{
			                		bootbox.alert('Vui lòng nhập url.');
			                		data = arr[1];
				                	$(this).html(data);
			                	}
			                	else
			                	{
				                	$('#'+fid+'_p').attr('id' , data);
				                	$('#'+fid+'_u').attr('id' , data);
				                	data = arr[1];
				                	$(this).html(data);
			                	}
			                	initEditInlineEnemyPrice(fpid);
			                },
			        	}
						);
                },
            //initEditInlineEnemyPrice(fpid);
        }
		);
    });

}

function syncPrice(barcode,pid)
{
	if(barcode.length > 0)
	{
		var dataString = 'barcode=' +barcode + '&pid=' + pid;
        $("#syncprice").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
        $("#syncprice").hide();
		$.ajax({
			type : 'post',
			dataType : "html",
			url : "/admin/productprice/syncprice",
			data : dataString,

			success : function(html){
				document.location.href = rooturl_admin + 'productprice/index/pbarcode/'+barcode + '/rs/'+html;
			}
		});
	}
}

function syncStock(barcode,pid)
{
    if(barcode.length > 0)
    {
        var dataString = 'barcode=' +barcode + '&pid=' + pid;
        $("#syncstock").after('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
        $("#syncstock").hide();
        $.ajax({
            type : 'post',
            dataType : "html",
            url : "/admin/productstock/syncstock",
            data : dataString,

            success : function(html){
                document.location.href = rooturl_admin + 'productstock/index/pbarcode/'+barcode + '/rs/'+html;
            }
        });
    }
}



function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function roundNumber(rnum, rlength) { // Arguments: number to round, number of decimal places
            var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
            return newnumber;
        }
function deleteUserRole(type , uid)
{
	if(uid > 0 && type > 0)
	{
		bootbox.confirm("Bạn có muốn xóa dòng này ?",function(confirm){
		if(confirm)
		{
			var datastring = 'uid=' + uid + '&type='+type;

			$.ajax({
				type : 'post',
				dataType : "html",
				url : "/admin/permission/deleteroleuserajax",
				data : datastring,

				success : function(html){
					if(html == 'success')
					{
						if(type == 6001)
						{
							$('#d'+uid).fadeOut();
						}
						else if(type == 7001)
						{
							$('#p'+uid).fadeOut();
						}
						else if(type == 9300)
						{
							$('#vp'+uid).fadeOut();
						}
					}
				}
			});
		}
		});
	}
}

function deleteHomepageObject(id, pid, types)
{
	if(id > 0 && pid > 0 && types > 0)
	{
		var datastring = 'id='+id+'&pid='+pid+'&type='+types;
		$.ajax({
				type : 'post',
				dataType : "html",
				url : "/cms/homepage/deleteajax",
				data : datastring,

				success : function(html){
					if(html == 'success')
					{
						if(types == 5)
						{
							$('#p'+id+'_'+pid).fadeOut();
						}
						else if(types == 10)
						{
							$('#pr'+id+'_'+pid).fadeOut();
						}
						else if(types == 15)
						{
							$('#n'+id+'_'+pid).fadeOut();
						}
					}
				}
			});
	}

}
function syncprice(url,token)
{
    $('.syncprice').addClass("disabled");
    $('.icon-ok').css("display","none");
    $('.icon-load').fadeIn();
    var data = {};
    url.each(function (i) {
        data[i] = url[i].value;
    });
    var dataSend = {
        'url':data,
        'ftoken':token
    };
	$.ajax({
		type: "POST",
		url: rooturl_admin+"productprice/ajaxsyncprice",
		data:dataSend,
        cache: false,
		dataType:'json',
		success: function(d){
             for (var i in d) {
                  $('.priceSync_'+i).val(addPeriod(d[i]));
                  $('.hdPriceSync_'+i).val(addPeriod(d[i]));  
                  $('.iconOk_'+i).fadeIn();
             }
              $('.syncprice').removeClass("disabled");
             $('.icon-load').fadeOut();
		},
        error: function (){
            //alert('Có lỗi xảy ra');
        }

	});

}

function syncprice2(url,token)
{
    $('.syncprice').addClass("disabled");
    $('.icon-ok').css("display","none");
    $('.icon-load').fadeIn();
    var data = {};
    var countUrl = url.length;
    var j = 0;
    url.each(function (i) {
        var data = fixedEncodeURIComponent(url[i].value);
        $.ajax({
			type: "POST",
			url: rooturl_admin+"productprice/ajaxsyncprice2",
			data:"url="+data+"&ftoken="+token,
            cache: false,
			dataType:'html',
			success: function(d){
			     $('.iconLoading_'+i).fadeOut();
			     if(parseFloat(d) >0 )
                 {
                    $('.priceSync_'+i).val(addPeriod(d));
                    $('.hdPriceSync_'+i).val(addPeriod(d));  
                    $('.iconOk_'+i).css("display","block");
                 }
                 j++;
                 if(j == countUrl)
                    $('.syncprice').removeClass("disabled");
          
			},
            error: function (){
                
            }
	      });
         
    })
}

//================================INDEX SYNC ENEMY INFO =======================================
function syncindexenemyinfo(url,token)
{
    $('.syncprice').addClass("disabled");
    $('.icon-ok').css("display","none");
    $('.icon-load').fadeIn();
    var data = {};
    var countUrl = url.length;
    var j = 0;

    url.each(function (i) {
        var data = fixedEncodeURIComponent(url[i].value);
        $.ajax({
			type: "POST",
			url: rooturl_admin+"productprice/ajaxsyncenemyinfo",
			data:"url="+data+"&ftoken="+token,
            cache: false,
			dataType:'html',
			success: function(d){
				if(d != "")
				{
					 var data = jQuery.parseJSON(d);
				     $('.iconLoading_'+i).fadeOut();
				     //////////////////////////////////////////////
	                 $('.pricePromotionSync_'+i).val(data.promotionprice);
	                 $('.hdPricePromotionSync_'+i).val(data.promotionprice);  
	                 $('.priceSync_'+i).val(data.price);
	              	 $('.hdPriceSync_'+i).val(data.price);
	              	 $('.hdProductname_'+i).val(data.productname);
	              	 $('.Productname_'+i).html(data.productname);
	              	 $('.hdDescription_'+i).val(data.description);
	              	 $('.Description_'+i).html(strip_tags(data.description).substring(0, 200));
	              	 $('.Promotioninfo_'+i).html(data.promotioninfo);
	              	 $('.hdPromotioninfo_'+i).val(data.promotioninfo);
	              	 $('.fimage_'+i).attr("src",data.image);
	              	 $('.hdImage_'+i).val(data.image);
	              	 $('.iconOk_'+i).css("display","block");
             	}
             	else
             	{
				     $('.iconLoading_'+i).fadeOut();
				     //////////////////////////////////////////////
	                 $('.pricePromotionSync_'+i).val("");
	                 $('.hdPricePromotionSync_'+i).val("");  
	                 $('.priceSync_'+i).val("");
	              	 $('.hdPriceSync_'+i).val("");
	              	 $('.hdProductname_'+i).val("");
	              	 $('.Productname_'+i).html("");
	              	 $('.hdDescription_'+i).val("");
	              	 $('.Description_'+i).html("");
	              	 $('.Promotioninfo_'+i).html("");
	              	 $('.hdPromotioninfo_'+i).val("");
	              	 $('.fimage_'+i).attr("src","");
	              	 $('.hdImage_'+i).val("");
	              	 $('.iconOk_'+i).css("display","block");
             	}
                
                 /////////////////////////////////////////////
                 if(j == countUrl)
                    $('.syncprice').removeClass("disabled");
          
			},
            error: function (){
                
            }
	      });
 		j++;
         
    });
}
function strip_tags(str, allow) {
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
  });
}
//================================SYNC ENEMY INFO ==============================================

function syncenemyinfo(url)
{
    $('.syncprice').addClass("disabled");
    $('.icon-ok').css("display","none");
    $('.icon-load').fadeIn();
    $.ajax({
		type: "POST",
		url: rooturl_admin+"productprice/ajaxsyncenemyinfo",
		data:"url="+url,
        cache: false,
		dataType:'html',
		success: function(d){
			var data = jQuery.parseJSON(d);
		    $('.groupappendadd').css("display",'block');
		    $('#fimage').attr("src",data.image);
		    $('#hdfimage').val(data.image);
		    $('#fpriceauto').val(data.price);
		    $('#fpricepromotiononl').val(data.promotionprice);
		    $('#fpromotioninfo').html(data.promotioninfo);
	        $('#hdfpromotioninfoonl').val(data.promotioninfo);
		    //$('#fdescription').html(data.description);
      	   $('.syncprice').removeClass("disabled");
		},
        error: function (){
            
        }
         
    });
}
//================================END SYNC ENEMY INFO ==========================================
function fixedEncodeURIComponent (str) {
  return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
}
function addPeriod(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
