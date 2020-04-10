{if $setting.site.websocketurl != '' && $setting.site.websocketenable == 1}
	<script type="text/javascript" src="{$setting.site.websocketurl}socket.io/socket.io.js"></script>
	<script type="text/javascript">
		
		var socket = io.connect("{$setting.site.websocketurl}");
		
		socket.on('newmessage', function(data) {
			//console.log(data);
			
			var type = data.type;
			var newMessage = data.newmessage;
			var newNotification = data.newnotification;
			var url = data.url;
			var icon = data.icon;
			var meta = data.meta;
			
			
		});

		//Connect to Socket server 
		socket.emit('register', {
			sessionid: '{$me->sessionid}' //Use a unique ID here.  I'm using my session ID
		});
		
	</script>
{/if}