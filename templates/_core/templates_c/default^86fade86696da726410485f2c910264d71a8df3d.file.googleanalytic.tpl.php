<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:40:13
         compiled from "templates/default/googleanalytic.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8479805825e8ec34d8ef5b9-07106571%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '86fade86696da726410485f2c910264d71a8df3d' => 
    array (
      0 => 'templates/default/googleanalytic.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8479805825e8ec34d8ef5b9-07106571',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


<script type="text/javascript">

   var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38936689-1']);
  _gaq.push(['_setDomainName', 'dienmay.com']);
  _gaq.push(['_trackPageview']);

<?php if ((!empty($_smarty_tpl->getVariable('listtrackingecommerce',null,true,false)->value))){?>
	<?php echo $_smarty_tpl->getVariable('listtrackingecommerce')->value;?>

<?php }?>

	(function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>


