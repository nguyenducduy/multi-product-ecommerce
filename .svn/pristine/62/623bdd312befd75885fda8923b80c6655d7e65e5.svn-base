{if $setting.site.websocketurl != '' && $setting.site.websocketenable == 1}
	<script type="text/javascript" src="{$setting.site.websocketurl}socket.io/socket.io.js"></script>
	<script type="text/javascript">
		
		var socket = io.connect("{$setting.site.websocketurl}");
		
		socket.on('pushnotification', function(data) {
			//console.log(data);
			
			var type = data.type;
			var url = data.url;
			var icon = data.icon;
			var newMessage = data.meta.newmessage;
			var newNotification = data.meta.newnotification;
			var messagetext = data.meta.text;
			
			//implement here to display correctly to the type of new push data, such as: new notification number, new message number, new friend request...
			//show number badge
			$("#topnotification .badge").html(newNotification);
			$("#topmessage .badge").html(newMessage);
			
			//update title with number of notification number
			//remove current (x) in title from before update
			var newTitle = document.title.replace(/\(\d+\) /, "");
			
			if(parseInt(newNotification) > 0)
			{
				$("#topnotification .badge").show();	
				Tinycon.setBubble(newNotification);
			}
			else
				Tinycon.setBubble(0);
			
			if(parseInt(newMessage) > 0)
				$("#topmessage .badge").show();
				
			if(parseInt(newMessage) > 0)
			{
				var numbernotification = parseInt(newMessage);
				newTitle = '(' + parseInt(numbernotification) + ' New Message) ' + newTitle;
			}

			document.title = newTitle;
			
			////////////////////////
			//show notfication
			realtimenotify(url, icon, messagetext);
			
		});

		//Connect to Socket server 
		socket.emit('register', {
			internaluser: 1,
			sessionid: '_{$me->sessionid}' //Use a unique ID here.  I'm using my session ID
		});
		
	</script>
{/if}