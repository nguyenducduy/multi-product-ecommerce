<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/_controller/admin/header_topbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2563239595e8ec25a957ed1-44716979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd41b82bd0ae0588d4b57b7b4ab32fd67d7ce726' => 
    array (
      0 => 'templates/default/_controller/admin/header_topbar.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2563239595e8ec25a957ed1-44716979',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="navbar navbar-fixed-top">
   <div class="navbar-inner" style="height:50px;">
    <div class="container-fluid">
      <a class="brand" href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
/home" title="Go to Dashboard">MyWebShop<span style="font-weight:normal;">.vn</span></a>
      <div id="topnotify" class="pull-left">

            <div class="topitem" id="topmessage">
                <a class="topbutton" href="javascript:void(0)"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
top_message.png" /><span class="badge hide">0</span></a>
                <div class="topitempanel hide" style="height: auto;">
                    <h3>Tin nhắn mới<a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
message?do=add">[+] Gởi tin nhắn</a></h3>
                    <ul style="height: auto;"></ul>
                    <div class="viewall"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
message" title="Xem tất cả các tin nhắn">Xem tất cả</a></div>
                </div><!-- .topitemdata -->
            </div><!-- end #topmessage -->

            <div class="topitem" id="topnotification">
                <a class="topbutton" href="javascript:void(0)"><img src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
top_notification.png" /><span class="badge hide">0</span></a>
                <div class="topitempanel hide" style="height: auto;">
                    <h3>Thông báo mới</h3>
                    <ul style="height: auto;"></ul>
                    <div class="viewall"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
notification" title="Xem tất cả các thông báo">Xem tất cả</a></div>
                </div><!-- .topitemdata -->
            </div><!-- end #topnotification -->
        </div><!-- end #topnotify -->
        
        <div id="topsearch" class="pull-left form-search">
            <form action="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
globalsearch" method="POST">
                <div class="input-append">
                    <input type="text" name="fkeyword" id="fsitebooksearchtext" onkeypress="doSitebooksearchtextpress(event)" placeholder="Search in employees, groups, products..." class="span3 search-query input-small">
                    <input type="submit" class="btn" name="fsearch" value="Search" style="height:30px"/>
                </div>
            </form>
        </div><!-- end #topsearch -->
      <div class="btn-group pull-right" style="margin:10px 0;">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" id="profiledropdown">
          <?php echo $_smarty_tpl->getVariable('me')->value->fullname;?>

          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
"><i class="icon-user"></i> My Profile</a></li>
          <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
account"><i class="icon-pencil"></i> Edit Profile</a></li>
          <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
account?tab=3"><i class="icon-lock"></i> Change Password</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
cms/feedback/add" rel="shadowbox;width=980;height=500"><i class="icon-gift"></i> Send Feedback</a></li>
          <li><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
site/logout?from=admin"><i class="icon-off"></i> Sign Out</a></li>
        </ul>
      </div>
      
    </div>
  </div>
</div>