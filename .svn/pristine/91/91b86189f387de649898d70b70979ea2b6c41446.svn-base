function bottombar_init()
{
	///////////////
	/////new
	//Adjust panel height
	$.fn.adjustNotifyPanel = function(){ 
		$(this).find("ul, .topitempanel").css({ 'height' : 'auto'}); //Reset subpanel and ul height
		
		var windowHeight = $(window).height(); //Get the height of the browser viewport
		var panelsub = $(this).find(".topitempanel").height(); //Get the height of subpanel	
		var panelAdjust = windowHeight - 100; //Viewport height - 100px (Sets max height of subpanel)
		var ulAdjust =  panelAdjust - 25; //Calculate ul size after adjusting sub-panel (27px is the height of the base panel)
		
		if ( panelsub >= panelAdjust ) {	 //If subpanel is taller than max height...
			$(this).find(".topitempanel").css({ 'height' : panelAdjust }); //Adjust subpanel to max height
			$(this).find("ul").css({ 'height' : ulAdjust}); //Adjust subpanel ul to new size
		}
		else if ( panelsub < panelAdjust ) { //If subpanel is smaller than max height...
			$(this).find("ul").css({ 'height' : 'auto'}); //Set subpanel ul to auto (default size)
		}
	};
	
	
	//Execute function on load
	$("#topmessage").adjustNotifyPanel(); //Run the adjustPanel function on #alertpanel
	$("#topnotification").adjustNotifyPanel(); //Run the adjustPanel function on #alertpanel
	
	//Each time the viewport is adjusted/resized, execute the function
	$(window).resize(function () { 
		$("#topmessage").adjustNotifyPanel();
		$("#topnotification").adjustNotifyPanel();
	});
	
	//Click event on FriendRequest Panel + Alert Panel	
	$(".topbutton").click( function() { //If clicked on the first link of #friendrequestpanel and #alertpanel...
		if($(this).next(".topitempanel").is(':visible')){ //If subpanel is already active...
			$(this).next(".topitempanel").hide(); //Hide active subpanel
			$(".topbutton").removeClass('active'); //Remove active class on the subpanel trigger
		}
		else { //if subpanel is not active...
			$(".topitempanel").hide(); //Hide all subpanels
			$(this).next(".topitempanel").toggle(); //Toggle the subpanel to make active
			$(".topbutton").removeClass('active'); //Remove active class on all subpanel trigger
			$(this).toggleClass('active'); //Toggle the active class on the subpanel trigger
			$(this).find(".badge").hide(); //Hide badge
			
			var parentid = $(this).parent().attr('id');
			if(parentid == 'topnotification')
			{
				//load & show new notification
				topnotify_notification();
			}
			else if(parentid == 'topmessage')
			{
				//call to process alertpanel data
				topnotify_message();
			}
		}
		return false; //Prevent browser jump to link anchor
	});
	
	
	
	//Click event outside of subpanel
	$(document).click(function() { //Click anywhere and...
		$(".topitempanel").hide(); //hide subpanel
		$(".topbutton").removeClass('active'); //remove active class on subpanel trigger
		
	});
	$('.topitempanel ul').click(function(e) { 
		e.stopPropagation(); //Prevents the subpanel ul from closing on click
	});
	//end new
	
	setTimeout("bottombar_refresh()", 5000);
}

function topnotify_notification()
{
	
	//check counter
	//neu > 0, co nghia la da update va co the send request de load
	var currentNotification = parseInt($("#topnotification .badge").text());
	
	//kiem tra list hien tai
	var currentShow = $("#topnotification .topitempanel ul li").length;
	
	//neu currentnotification = 0, tuc la hien ko co notification nao moi
	//ma hien thoi trong notification list chua co notification item nao thi
	//moi request de lay default min item
	//con mac du = 0, nhung list da co thi ko load lai default min
	
	if(currentNotification > 0 || currentShow == 0)
	{
		$("#topnotification .topitempanel .viewall").before('<div class="tmp_indicator" style="text-align:center;padding:10px 0;"><img src="'+imageDir+'ajax_indicator.gif" border="0" /></div>');
	
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   url: rooturl_profile + 'notification/indexajax',
		   error: function(){
				$("#topnotification .topitempanel .tmp_indicator").remove();
			   },
		   success: function(xml){
				$("#topnotification .topitempanel .tmp_indicator").remove();
				
				var count = $(xml).find('count').text();
				
				if(count != '0')
				{
					var html = '';
					$(xml).find('notification').each(function(){
						
						html += '<li><img class="avatar" src="'+$(this).find('avatar').text()+'" alt="" /><div class="info">'+$(this).find('data').text()+'</div><br class="cl" /></li>';
					});
					
					if(currentNotification > 0)
						$("#topnotification .topitempanel ul").prepend(html);
					else
						$("#topnotification .topitempanel ul").html(html);
				}
				
		   }
		 });
		
		//reset counter
		$("#topnotification .badge").text('0');
	}
	

}


/** View message */
function topnotify_message()
{
	//check counter
	//neu > 0, co nghia la da update va co the send request de load
	var currentNotification = parseInt($("#topmessage .badge").text());
	
	//kiem tra list hien tai
	var currentShow = $("#topmessage .topitempanel ul li").length;
	
	//neu currentnewmessage = 0, tuc la hien ko co message nao moi
	//ma hien thoi trong message list chua co message item nao thi
	//moi request de lay default min item
	//con mac du = 0, nhung list da co thi ko load lai default min
	
	if(currentNotification > 0 || currentShow == 0)
	{
		$("#topmessage .viewall").before('<div class="tmp_indicator" style="text-align:center;padding:10px 0;"><img src="'+imageDir+'ajax_indicator.gif" border="0" /></div>');
	
		$.ajax({
		   type: "POST",
		   dataType: 'xml',
		   url: rooturl_profile + 'message/bottomindexajax',
		   error: function(){
				$("#topmessage .tmp_indicator").remove();
			   },
		   success: function(xml){
				$("#topmessage .tmp_indicator").remove();
				
				var count = $(xml).find('count').text();
				
				if(count != '0')
				{
					var html = '';
					$(xml).find('message').each(function(){
						
						html += '<li><img class="avatar" src="'+$(this).find('avatar').text()+'" /><div class="info">'+$(this).find('data').text()+'</div><br class="cl" /></li>';
					});
					
					if(currentNotification > 0)
						$("#topmessage .topitempanel ul").prepend(html);
					else
						$("#topmessage .topitempanel ul").html(html);
				}
				
		   }
		 });
		
		//reset counter
		$("#topmessage .badge").text('0');
	}
}


//refresh bottom bar data to get new notification and more
function bottombar_refresh()
{
	//alert(websocketurl);
	
	//fallback for websocket
	//neu da set websocket tu phia server thi khong su dung co che AJAX longpolling nua
	if(typeof websocketenable != "undefined" && websocketenable == 1)
		return true;
	
	
	$.ajax({
	   type: "GET",
	   dataType: 'xml',
	   url: rooturl_profile + 'notification/refreshajax',
	   error: function(){
			
		   },
	   success: function(xml){
						
			var newNotification = $(xml).find('notification').text();
			var newMessage = $(xml).find('message').text();
			
			$("#topnotification .badge").html(newNotification);
			$("#topmessage .badge").html(newMessage);
			
			//update title with number of notification number
			//remove current (x) in title from before update
			var newTitle = document.title.replace(/\(\d+\) /, "");
			
			if(parseInt(newNotification) > 0 || parseInt(newMessage) > 0)
			{
				if(parseInt(newNotification) > 0)
					$("#topnotification .badge").show();	
				
				Tinycon.setBubble(parseInt(newNotification) + parseInt(newMessage));
			}
			else
				Tinycon.setBubble(0);
			
			if(parseInt(newMessage) > 0)
				$("#topmessage .badge").show();	
			
			
			//boi vi dung Tinycon nen ko can show o day
			/*
			if(parseInt(newNotification) > 0 || parseInt(newMessage) > 0)
			{
				var numbernotification = parseInt(newNotification) + parseInt(newMessage);
				newTitle = '(' + parseInt(numbernotification) + ') ' + newTitle;
			}
			*/
			
			
			
			document.title = newTitle;
			
			setTimeout("bottombar_refresh()", 5000);
	   }
	 });	
}

