<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/websocket_internal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7658334685e8ec25ab841c4-08209796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcc9cf58dbe6feaf3743b0f62b5d2efa39399e7c' => 
    array (
      0 => 'templates/default/websocket_internal.tpl',
      1 => 1568094430,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7658334685e8ec25ab841c4-08209796',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('setting')->value['site']['websocketurl']!=''&&$_smarty_tpl->getVariable('setting')->value['site']['websocketenable']==1){?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('setting')->value['site']['websocketurl'];?>
socket.io/socket.io.js"></script>
	<script type="text/javascript">
		
		var socket = io.connect("<?php echo $_smarty_tpl->getVariable('setting')->value['site']['websocketurl'];?>
");
		
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
			sessionid: '_<?php echo $_smarty_tpl->getVariable('me')->value->sessionid;?>
' //Use a unique ID here.  I'm using my session ID
		});
		
	</script>
<?php }?>