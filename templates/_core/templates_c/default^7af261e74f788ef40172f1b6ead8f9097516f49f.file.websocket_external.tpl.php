<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:48
         compiled from "templates/default/websocket_external.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1293403915e8ec2bcdf1fc7-83358965%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7af261e74f788ef40172f1b6ead8f9097516f49f' => 
    array (
      0 => 'templates/default/websocket_external.tpl',
      1 => 1568094430,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1293403915e8ec2bcdf1fc7-83358965',
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
			sessionid: '<?php echo $_smarty_tpl->getVariable('me')->value->sessionid;?>
' //Use a unique ID here.  I'm using my session ID
		});
		
	</script>
<?php }?>