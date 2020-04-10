
<script language="javascript" type="text/javascript" src="{$conf.rooturl}libs/tiny_mce/jquery.tinymce.js"></script>
<script language="javascript" type="text/javascript">



{literal}
$(function() {
	 $('textarea.tinymce').tinymce({
		// Location of TinyMCE script
        script_url : '{/literal}{$conf.rooturl}{literal}libs/tiny_mce/tiny_mce.js',
		

		// General options
		theme : "advanced",
		entity_encoding : "raw",
		plugins : "pagebreak,style,save,advhr,advimage,advlink,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		
		// Theme options
		theme_advanced_buttons1 : "forecolor,backcolor,|, bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,removeformat",
		theme_advanced_buttons2 : "pasteword,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,media,cleanup,code,fullscreen,|,pagebreak",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "",
		theme_advanced_resizing : true
		
	
	});
	
});

	
		
	{/literal}
</script>
