<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PlugoBrowser</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<!-- Plugo Browser CSS -->
	<link media="screen,tv,projection" type="text/css" rel="stylesheet" href="css/plugobrowser.css" />
	<link media="screen,tv,projection" type="text/css" rel="stylesheet" href="css/jquery.contextMenu.css" />
	<link media="screen,tv,projection" type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
	<!-- TinyMCE PopUp -->
	<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
	<!-- jQuery LIBS -->
	<script type="text/javascript" src="js/jquery.1.7.2.min.js"></script>
	<!-- jQuery 3rd Party Plugins -->
	<script type="text/javascript" src="js/jquery.jcookie.js"></script>
	<script type="text/javascript" src="js/jquery.ui.position.js"></script>
	<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
	<!-- Plupload files -->
	<script type="text/javascript" src="js/browserplus-min.2.4.21.js"></script>
	<script type="text/javascript" src="plupload/plupload.full.js"></script>
	<!-- Plugo Browser Plugin -->
	<script type="text/javascript" src="js/plugobrowser.js?v=3"></script>
	<script type="text/javascript">
	PlugoBrowser.relativeUploadDir = '<?php echo $plugoBrowser->getRelativeUploadDir(); ?>';
	PlugoBrowser.maxUploadSize = '<?php echo ini_get('upload_max_filesize'); ?>';
	PlugoBrowser.settings = <?php echo json_encode($plugoBrowser->getSettings()); ?>;
	</script>
</head>
<body>
<div id="all">
	<div id="wrap" class="clearfix">
		<div id="sidebar_wrap">
		  <a href="#" onclick="PlugoBrowser.showUpload(); return false;" class="bc_upload" title="Click" rel="tooltip">{#plugobrowser_dlg.upload}</a>
			<div id="sidebar">
				<ul class="filetree">
				  <li>
						<div class="clearfix">
							<div class="menu_item menu_item_root">
								<a rel="/" href="#" onclick="PlugoBrowser.readDir('/', this); return false;" class="action_get_items">{#plugobrowser_dlg.root}</a>
							</div>
						</div>
					 </li>
				</ul>
			</div> <!-- /SIDEBAR -->
			<a href="#" onclick="PlugoBrowser.showNewDir(); return false;" class="bc_new">{#plugobrowser_dlg.new_folder}</a>
		</div> <!-- /SIDEBAR_WRAP -->
		<div id="content_wrap">
		  <div id="breadcrumb">
				<div id="crumb" class="f-left">
					<ul id="breadCrumbs"></ul>
				</div>
			</div> <!-- /BREADCRUMB -->
			<div id="content">
				<h2 id="dirName"></h2>
				<div id="directory_list"></div> <!-- /DIRECTORY LIST -->
			</div> <!-- /CONTENT -->
		</div> <!-- /CONTENT_WRAP -->
	</div> <!-- /WRAP -->
	<div id="nav">
	  <a href="#" id="displayStyle" onclick="PlugoBrowser.toggleDisplayStyle(); return false;" class="ico ico_table_list" title="{#plugobrowser_dlg.view_as_table}"></a>
		<span class="ico_separator"></span>
		<a href="#" onclick="PlugoBrowser.showSettings(); return false;" class="ico ico_setting" title="{#plugobrowser_dlg.settings}"></a>
		<a href="#" onclick="PlugoBrowser.showAbout(); return false;" class="ico ico_about" title="{#plugobrowser_dlg.about}"></a>
	</div> <!-- /NAV -->
</div> <!-- /ALL -->
</body>
</html>