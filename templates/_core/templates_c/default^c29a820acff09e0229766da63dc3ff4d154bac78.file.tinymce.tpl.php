<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 14:19:23
         compiled from "templates/default/tinymce.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11564330035e8ecc7bc0ef68-77948635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c29a820acff09e0229766da63dc3ff4d154bac78' => 
    array (
      0 => 'templates/default/tinymce.tpl',
      1 => 1568094430,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11564330035e8ecc7bc0ef68-77948635',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
libs/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
libs/tiny_mce/jquery.tinymce.js"></script>
<script language="javascript" type="text/javascript">
//<![CDATA[

	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		entity_encoding : "raw",
		editor_deselector : "mceNoEditor",
		relative_urls : false,
		remove_script_host : true,
		document_base_url : "/",
		convert_urls : false, 

		plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,plugobrowser,dmfilemanager",
	
		// Theme options
		theme_advanced_buttons1 : "dmfilemanager,plugobrowser,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,|,fontselect,fontsizeselect,fullscreen",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor,table",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true
		
	
	});
	

	
		
	
</script>