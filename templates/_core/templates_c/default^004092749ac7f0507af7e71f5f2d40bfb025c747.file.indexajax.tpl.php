<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:54:47
         compiled from "templates/default/_controller/profile/info/indexajax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14696765425e8ec6b7f1ae51-45477584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '004092749ac7f0507af7e71f5f2d40bfb025c747' => 
    array (
      0 => 'templates/default/_controller/profile/info/indexajax.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14696765425e8ec6b7f1ae51-45477584',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_nl2br')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.nl2br.php';
?><div id="accountcodebadge">
	
	
		<div id="pinfodepartment">
			
			
			
			<ul class="breadcrumb">
				<?php if ($_smarty_tpl->getVariable('myUser')->value->isStaff()){?>
					<?php  $_smarty_tpl->tpl_vars['department'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('userDepartmentList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['department']->index=-1;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['department']->key => $_smarty_tpl->tpl_vars['department']->value){
 $_smarty_tpl->tpl_vars['department']->index++;
 $_smarty_tpl->tpl_vars['department']->first = $_smarty_tpl->tpl_vars['department']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']["departmentlist"]['first'] = $_smarty_tpl->tpl_vars['department']->first;
?>
						<li><a href="<?php echo $_smarty_tpl->getVariable('department')->value->getUserPath();?>
" class="tipsy-trigger" title="<?php echo $_smarty_tpl->getVariable('department')->value->fullname;?>
"><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['departmentlist']['first']){?><i class="icon-home"></i><?php }else{ ?><?php echo $_smarty_tpl->getVariable('department')->value->fullname;?>
<?php }?></a> <span class="divider">\\</span></li>
					<?php }} ?>
					
				<?php }?>
				
				<li><a href="<?php echo $_smarty_tpl->getVariable('myUser')->value->getUserPath();?>
" class="tipsy-trigger" style="float:right;" title="<?php echo $_smarty_tpl->getVariable('lang')->value['default']['accountcodebadgeLabel'];?>
: <?php echo $_smarty_tpl->getVariable('myUser')->value->getCode();?>
. <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['accountType'];?>
: <?php echo $_smarty_tpl->getVariable('myUser')->value->getGroupName();?>
"><span class="label"><?php echo $_smarty_tpl->getVariable('myUser')->value->getCode();?>
</span></a></li>
				
				<li></li>
			</ul>
			
			
		</div>
	
</div>


<?php if ($_smarty_tpl->getVariable('myUser')->value->isStaff()){?>
	
<div id="pinfoimage">
	<img src="<?php echo $_smarty_tpl->getVariable('myUser')->value->getSmallImage(true);?>
" />
</div><!-- end #pinfoimage -->
<?php }?>
	
<div id="pinfo">

	<div class="status"><?php $_smarty_tpl->tpl_vars['myuseronlinestatus'] = new Smarty_variable($_smarty_tpl->getVariable('myUser')->value->getOnlinestatus(), null, null);?> <img class="sp sp16 sp<?php echo $_smarty_tpl->getVariable('myuseronlinestatus')->value;?>
" src="<?php echo $_smarty_tpl->getVariable('imageDir')->value;?>
blank.png" title="<?php echo $_smarty_tpl->getVariable('myuseronlinestatus')->value;?>
" alt="<?php echo $_smarty_tpl->getVariable('myuseronlinestatus')->value;?>
" /></div>
	
	<div class="pinfotop">
		<?php if ($_smarty_tpl->getVariable('myUser')->value->checkGroupname('department')==false){?>
			<div class="followbtn">
				<?php if ($_smarty_tpl->getVariable('userIsFollowed')->value){?>
					<a href="javascript:void(0)" onclick="user_followtoggle(<?php echo $_smarty_tpl->getVariable('myUser')->value->id;?>
)" class="btn" id="followbtn-<?php echo $_smarty_tpl->getVariable('myUser')->value->id;?>
"><i class="icon-ok"></i> <?php if ($_smarty_tpl->getVariable('myUser')->value->checkGroupname('group')){?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['groupexitBtn'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['unfollowBtn'];?>
<?php }?></a>
				<?php }else{ ?>
					<a href="javascript:void(0)" onclick="user_followtoggle(<?php echo $_smarty_tpl->getVariable('myUser')->value->id;?>
)" class="btn btn-success" id="followbtn-<?php echo $_smarty_tpl->getVariable('myUser')->value->id;?>
"><i class="icon-plus"></i> <?php if ($_smarty_tpl->getVariable('myUser')->value->checkGroupname('group')){?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['groupjoinBtn'];?>
<?php }else{ ?><?php echo $_smarty_tpl->getVariable('lang')->value['default']['followBtn'];?>
<?php }?></a>
				<?php }?>
			</div>
		<?php }?>
		
		<h1 class="head"><?php echo $_smarty_tpl->getVariable('myUser')->value->fullname;?>

			
		</h1>
		
		<?php if ($_smarty_tpl->getVariable('birthdayInfo')->value!=''){?><div class="subhead"><?php if ($_smarty_tpl->getVariable('myUser')->value->isStaff()==false){?><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['datecreated'];?>
: <?php }?><?php echo sprintf("%02d",$_smarty_tpl->getVariable('birthdayInfo')->value['mday']);?>
/<?php echo sprintf("%02d",$_smarty_tpl->getVariable('birthdayInfo')->value['mon']);?>
/<?php echo $_smarty_tpl->getVariable('birthdayInfo')->value['year'];?>
</div><?php }?>
		
		
		
		
		
	</div>
	<div class="line"></div>
	<?php if ($_smarty_tpl->getVariable('myUser')->value->bio!=''){?>
		<div class="bio"><?php echo smarty_modifier_nl2br($_smarty_tpl->getVariable('myUser')->value->bio);?>
</div>
		<div class="line"></div>
	<?php }?>
	<?php if (count($_smarty_tpl->getVariable('myProfileList')->value[1])>0){?>
	<div class="group">
		<div class="groupleft"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['groupWork'];?>
</div>
		<div class="groupright">
			<?php  $_smarty_tpl->tpl_vars['profile'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('myProfileList')->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['profile']->key => $_smarty_tpl->tpl_vars['profile']->value){
?>
				<div class="ginfo">
					<div class="title"><?php echo $_smarty_tpl->getVariable('profile')->value->text1;?>
</div>
					
					<div class="titlesub"><?php echo smarty_modifier_nl2br($_smarty_tpl->getVariable('profile')->value->text2);?>
</div>
					<div class="time">
						<?php echo $_smarty_tpl->getVariable('profile')->value->getText3Region();?>
, <?php if ($_smarty_tpl->getVariable('profile')->value->date1_month>0&&$_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_month;?>
/<?php }?><?php if ($_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_year;?>
<?php }?>
						
						<?php if ($_smarty_tpl->getVariable('profile')->value->date2_year>0){?>
						 	- <?php if ($_smarty_tpl->getVariable('profile')->value->date2_month>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_month;?>
/<?php }?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_year;?>

						<?php }else{ ?>
							- <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['now'];?>

						<?php }?>
						
					</div>
				</div>
			<?php }} ?>
		</div>
	</div>
	<?php }?>
	
	<?php if (count($_smarty_tpl->getVariable('myProfileList')->value[2])>0||count($_smarty_tpl->getVariable('myProfileList')->value[3])>0){?>
	<div class="group">
		<div class="groupleft"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['groupEducation'];?>
</div>
		<div class="groupright">
			<?php  $_smarty_tpl->tpl_vars['profile'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('myProfileList')->value[2]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['profile']->key => $_smarty_tpl->tpl_vars['profile']->value){
?>
				<div class="ginfo">
					<div class="title"><?php echo $_smarty_tpl->getVariable('profile')->value->text1;?>
</div>
					<div class="titlesub"><?php echo smarty_modifier_nl2br($_smarty_tpl->getVariable('profile')->value->text2);?>
</div>
					<div class="time">
						<?php echo $_smarty_tpl->getVariable('profile')->value->getText3Region();?>
, <?php if ($_smarty_tpl->getVariable('profile')->value->date1_month>0&&$_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_month;?>
/<?php }?><?php if ($_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_year;?>
<?php }?>
						
						<?php if ($_smarty_tpl->getVariable('profile')->value->date2_year>0){?>
						 	- <?php if ($_smarty_tpl->getVariable('profile')->value->date2_month>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_month;?>
/<?php }?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_year;?>

						<?php }else{ ?>
							- <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['now'];?>

						<?php }?>
						
					</div>
				</div>
			<?php }} ?>
			
			<?php  $_smarty_tpl->tpl_vars['profile'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('myProfileList')->value[3]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['profile']->key => $_smarty_tpl->tpl_vars['profile']->value){
?>
				<div class="ginfo">
					<div class="title"><?php echo $_smarty_tpl->getVariable('profile')->value->getText2Schooltype();?>
 <?php echo $_smarty_tpl->getVariable('profile')->value->text1;?>
</div>
					<div class="time">
						<?php echo $_smarty_tpl->getVariable('profile')->value->getText3Region();?>
, <?php if ($_smarty_tpl->getVariable('profile')->value->date1_month>0&&$_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_month;?>
/<?php }?><?php if ($_smarty_tpl->getVariable('profile')->value->date1_year>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date1_year;?>
<?php }?>
						
						<?php if ($_smarty_tpl->getVariable('profile')->value->date2_year>0){?>
						 	- <?php if ($_smarty_tpl->getVariable('profile')->value->date2_month>0){?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_month;?>
/<?php }?><?php echo $_smarty_tpl->getVariable('profile')->value->date2_year;?>

						<?php }else{ ?>
							- <?php echo $_smarty_tpl->getVariable('lang')->value['controller']['now'];?>

						<?php }?>
						
					</div>
				</div>
			<?php }} ?>
		</div>
	</div>
	<?php }?>
	
	<?php if ($_smarty_tpl->getVariable('myUser')->value->phone!=''||$_smarty_tpl->getVariable('myUser')->value->address!=''||$_smarty_tpl->getVariable('myUser')->value->website!='http://'){?>
	<div class="group">
		<div class="groupleft"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['groupContact'];?>
</div>
		<div class="groupright">
			<?php if ($_smarty_tpl->getVariable('myUser')->value->phone!=''){?>
			<div class="ginfo">
				<div class="title"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['phone'];?>
</div>
				<div class="titlesub"><?php echo $_smarty_tpl->getVariable('myUser')->value->phone;?>
</div>
			</div>
			<?php }?>
			
			<?php if ($_smarty_tpl->getVariable('myUser')->value->address!=''){?>
			<div class="ginfo">
				<div class="title"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['address'];?>
</div>
				<div class="titlesub"><?php echo $_smarty_tpl->getVariable('myUser')->value->address;?>
<?php if ($_smarty_tpl->getVariable('myUser')->value->region>0){?>, <?php echo $_smarty_tpl->getVariable('myUser')->value->getRegionName();?>
<?php }?></div>
			</div>
			<?php }?>
			
			<?php if ($_smarty_tpl->getVariable('myUser')->value->website!='http://'){?>
			<div class="ginfo">
				<div class="title">Website</div>
				<div class="titlesub"><?php echo $_smarty_tpl->getVariable('myUser')->value->website;?>
</div>
			</div>
			<?php }?>
		</div>
	</div>
	<?php }?>
	
	<?php if (count($_smarty_tpl->getVariable('myProfileList')->value[4])>0){?>
	<div class="group">
		<div class="groupleft"><?php echo $_smarty_tpl->getVariable('lang')->value['controller']['groupOther'];?>
</div>
		<div class="groupright">
			<?php  $_smarty_tpl->tpl_vars['profile'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('myProfileList')->value[4]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['profile']->key => $_smarty_tpl->tpl_vars['profile']->value){
?>
				<div class="ginfo">
					<div class="title"><?php echo $_smarty_tpl->getVariable('profile')->value->text1;?>
</div>
					<div class="titlesub"><?php echo $_smarty_tpl->getVariable('profile')->value->text2;?>
</div>
				</div>
			<?php }} ?>
		</div>
	</div>
	<?php }?>
	<div class="clear"></div>

       
    