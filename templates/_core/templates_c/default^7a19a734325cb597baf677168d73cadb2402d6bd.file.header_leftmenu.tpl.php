<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:36:10
         compiled from "templates/default/_controller/admin/header_leftmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2310070565e8ec25a9bd5b6-56890461%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a19a734325cb597baf677168d73cadb2402d6bd' => 
    array (
      0 => 'templates/default/_controller/admin/header_leftmenu.tpl',
      1 => 1568482489,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2310070565e8ec25a9bd5b6-56890461',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="span2" id="navbar">
	<?php if ($_smarty_tpl->getVariable('me')->value->checkGroupname('administrator')||$_smarty_tpl->getVariable('me')->value->checkGroupname('developer')){?>

  	<div class="well sidebar-nav">
		<h2>ADMINISTRATOR</h2>
        <ul class="nav nav-list <?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='admin'){?>hide<?php }?>" id="sidebar">
			<li id="menu_log" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
log"><i class="icon-file"></i> Moderator Log</a></li>
			<li id="menu_sessionmanager" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
sessionmanager"><i class="icon-eye-open"></i> Session Manager</a></li>
			<li id="menu_passwordgenerator" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
utility/passwordgenerator"><i class="icon-asterisk"></i> Password Generator</a></li>
			<li id="menu_codegenerator" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
codegenerator"><i class="icon-beaker"></i> Code Generator</a></li>
			<li id="menu_crontask" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
crontask"><i class="icon-time"></i> Crontask tracking</a></li>
			<li id="menu_backgroundtask" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
backgroundtask"><i class="icon-time"></i> Background Task tracking</a></li>
			<li id="menu_permission" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
permission"><i class="icon-lock"></i> Module Permission</a></li>
			<li id="menu_settinggroup" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
settinggroup"><i class="icon-cog"></i> Setting</a></li>
			<li id="menu_scrum" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
scrumproject"><i class="icon-tasks"></i> Scrum Manager</a></li>
			<li id="menu_user_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
user"><i class="icon-user"></i> Quản lý tài khoản</a></li>
			<li id="menu_user_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_admin'];?>
roleuser"><i class="icon-user"></i>Quản lý phân quyền danh mục</a></li>
        </ul>
      </div><!--/.well -->
	<?php }?>

	<div class="well sidebar-nav">
		<h2>PROFILE</h2>
        <ul class="nav nav-list  <?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='profile'){?>hide<?php }?>" id="sidebar">
			<li id="menu_profile" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('me')->value->getUserPath();?>
/home"><i class="icon-home"></i> Hoạt động</a></li>
			<li id="menu_group" class="nav-header"><a href="javascript:void(0)"><i class="icon-group"></i> Nhóm..</a>
				<ul class="nav nav-list">

					<li id="menu_group_add"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
group/add" rel="shadowbox;width=800;height=500">[+] Tạo nhóm mới</a></li>
				</ul>
			</li>


			<li id="menu_file" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
file"><i class="icon-folder-close"></i> File Manager</a></li>
			<!--<li id="menu_calendar" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_profile'];?>
calendar"><i class="icon-calendar"></i> Calendar/Event</a></li>-->
        </ul>
      </div><!--/.well -->

	<div class="well sidebar-nav">
		<h2>CMS</h2>
        <ul class="nav nav-list  <?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='cms'){?>hide<?php }?>" id="sidebar">
			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-barcode"></i> Sản phẩm..</a>
				<ul class="nav nav-list">
					<li id="menu_product"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
product">Tất cả sản phẩm</a></li>
					<li id="menu_productcategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
productcategory">Danh mục sản phẩm</a></li>
					<li id="menu_vendor"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
vendor">Đối tác</a></li>
					<li id="menu_productcolor"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
productcolor">Màu sản phẩm</a></li>
					<li id="menu_productreview"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
productreview">Bình luận sản phẩm</a></li>
					<li id="menu_homepage"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
homepage">Quản lý homepage</a></li>
					<li id="menu_enemy"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
enemy">Đối thủ</a></li>
					<li id="menu_search"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
search">Từ khóa Tìm kiếm</a></li>
                    <li id="menu_brandcategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
brandcategory">Thương hiêu-Ngành hàng</a></li>
                     <li id="menu_crazydeal"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
crazydeal">Crazydeal</a></li>
                    <li id="menu_discountproduct"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
discountproduct">Event Khởi đầu hoàn hảo</a></li>
                     <li id="menu_eventproducthours"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
eventproducthours">Event 2/9</a></li>
                     <li id="menu_eventproducthours"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
productguess">Đoán giá</a></li>
                     <li id="menu_reverseauctions"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
reverseauctions">Đấu giá ngược</a></li>
                     <li id="menu_giftorder"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
giftorder">Hộp quà may mắn</a></li>
				</ul>
			</li>

			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-file"></i> Tin tức..</a>
				<ul class="nav nav-list">
					<li id="menu_news"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
news">Tất cả tin</a></li>
					<li id="menu_newscategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
newscategory">Danh mục tin</a></li>
					<li id="menu_newsreview"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
newsreview">Bình luận tin</a></li>
				</ul>
			</li>

			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-bullhorn"></i> Rao vặt..</a>
				<ul class="nav nav-list">
					<li id="menu_stuff"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
stuff">Tất cả rao vặt</a></li>
					<li id="menu_stuffcategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
stuffcategory">Danh mục rao vặt</a></li>
					<li id="menu_stuffreview"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
stuffreview">Bình luận rao vặt</a></li>
				</ul>
			</li>

			<li id="menu_promotion" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
promotion"><i class="icon-gift"></i> Khuyến mãi</a></li>

			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-file"></i> Page..</a>
				<ul class="nav nav-list">
					<li id="menu_page"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
page">Tất cả page</a></li>
					<li id="menu_pagereview"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
pagereview">Bình luận page</a></li>
				</ul>
			</li>

			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-bullhorn"></i> Tuyển dụng..</a>
				<ul class="nav nav-list">
					<li id="menu_job"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
job">Tất cả tuyển dụng</a></li>
					<li id="menu_jobcategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
jobcategory">Danh mục tuyển dụng</a></li>
					<li id="menu_jobcv"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
jobcv">Quản lý hồ sơ tuyển dụng</a></li>
					<li id="menu_jobreview"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
jobreview">Bình luận tuyển dụng</a></li>
				</ul>
			</li>

			<li id="menu_faq" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
faq"><i class="icon-question-sign"></i> Hỏi và đáp</a></li>

			<li id="menu_ads" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
ads"><i class="icon-credit-card"></i> Banner quảng cáo</a></li>
			<li id="menu_region" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
region"><i class="icon-truck"></i> Tỉnh/Thành phố</a></li>
			<li id="menu_store" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
store"><i class="icon-road"></i> Tìm siêu thị</a></li>
			<li id="menu_slug" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
slug"><i class="icon-link"></i> Slug</a></li>
			<li id="menu_stat_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_stat'];?>
"><i class="icon-bar-chart"></i> Thống kê</a></li>
			<li id="menu_event_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
event"><i class="icon-bar-siemap"></i> Event</a></li>
			<li id="menu_sitemap_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
sitemap"><i class="icon-bar-siemap"></i> Sitemap</a></li>
			<li id="menu_internal_list" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
internallink"><i class="icon-bar-internal"></i> SEO internal</a></li>
			<li id="menu_inyear" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
gamefasteye"><i class="icon-inyear"></i>Review in year</a></li>
			<li id="menu_inyear" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
productyear"><i class="icon-inyear"></i>Product or year</a></li>
			<li id="menu_storeconfig" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
storeconfig"><i class="icon-sitemap"></i>Store config</a></li>



        </ul>
      </div><!--/.well -->

	<?php if ($_smarty_tpl->getVariable('me')->value->checkGroupname('administrator')||$_smarty_tpl->getVariable('me')->value->checkGroupname('developer')){?>
	<div class="well sidebar-nav">
		<h2>CRM</h2>
        <ul class="nav nav-list <?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='crm'){?>hide<?php }?>" id="sidebar">

			<li id="menu_orders" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_crm'];?>
orders"><i class="icon-shopping-cart"></i> Đơn hàng ONLINE</a></li>
			<li id="menu_installment" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_cms'];?>
installment"><i class="icon-shopping-cart"></i> Đơn hàng TRẢ GÓP ONLINE</a></li>
			<li id="menu_archivedorder" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_crm'];?>
archivedorder"><i class="icon-shopping-cart"></i> Đơn hàng ERP</a></li>
			<li id="menu_customer" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_crm'];?>
customer"><i class="icon-search"></i> Customer </a></li>
        </ul>
      </div><!--/.well -->




	<div class="well sidebar-nav">
		<h2>ERP</h2>
        <ul class="nav nav-list <?php if ($_smarty_tpl->getVariable('controllerGroup')->value!='erp'){?>hide<?php }?>" id="sidebar">
			<!--<li id="menu_account" class="nav-header"><a href="javascript:void(0)"><i class="icon-briefcase"></i> Kế toán</a></li>-->
			<li id="menu_humanresource" class="nav-header"><a href="javascript:void(0)" class="moresidemenu"><i class="icon-sitemap"></i> Nhân sự</a></li>
			<li class="nav-header"><a href="http://dienmay.myhost:9999/" ><i class="icon-bar-chart"></i> Reporting</a></li>
			<!--<li id="menu_manufacture" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
manufacturing"><i class="icon-fire"></i> Sản xuất</a></li>
			<li id="menu_supplychain" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
supplychain"><i class="icon-retweet"></i> Supply Chain</a></li>
			<li id="menu_projectmanagement" class="nav-header"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
project"><i class="icon-calendar"></i> Quản lý dự án</a></li>-->
        </ul>
      </div><!--/.well -->
	<?php }?>

</div><!--/span-->

<div class="span2 hide" id="moresidemenu">
	<div id="menu_humanresource_moresidemenu">
		<ul class="nav nav-list" id="subsidebar">
			<li id="menu_product" class="nav-header"><a href="javascript:void(0)"><i class="icon-sitemap"></i> Phòng ban..</a>
				<ul class="nav nav-list">
					<li id="menu_product"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
hrmdepartment?view=list">Danh sách phòng ban</a></li>
					<li id="menu_productcategory"><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl_erp'];?>
hrmtitle">Quản lý Chức danh</a></li>
				</ul>
			</li>

		</ul>
	</div><!-- end #menu_humanresource_moresidemenu -->
</div><!-- end #moresidemenu -->
