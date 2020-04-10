<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:37:47
         compiled from "templates/default/_controller/site/banner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2243362215e8ec2bbbf0a57-19106068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e42a8a96643787cb432ec74f2049ce109bc9302' => 
    array (
      0 => 'templates/default/_controller/site/banner.tpl',
      1 => 1568094429,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2243362215e8ec2bbbf0a57-19106068',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/nguyenducduy/www/dienmay/libs/smarty/plugins/modifier.escape.php';
?><!--banner right-->
<div class="bn_right">           
        <?php if (!empty($_smarty_tpl->getVariable('crazydealproduct',null,true,false)->value)){?>
        <div id="crazydeal" <?php if (empty($_smarty_tpl->getVariable('crazydealproduct',null,true,false)->value)){?>style="display:none;"<?php }?>>
          <div class="typedeal">
              <h3>Crazy Deal</h3>
              <div class="wraptime">
                  <h4>Thời gian còn lại</h4>
                  <div class="dealtime" id="countbox1"></div>
              </div>
          </div>
          <div class="bndeal"><a href="<?php echo $_smarty_tpl->getVariable('crazydealproduct')->value->getProductPathByPid();?>
" title=""><img src="<?php echo $_smarty_tpl->getVariable('crazydealproduct')->value->getImage();?>
" /></a></div>
          <div class="buydeal"><a href="<?php echo $_smarty_tpl->getVariable('crazydealproduct')->value->getProductPathByPid();?>
" title="Mua ngay">Mua ngay !</a></div>
          <div class="crazydeal"><a href="#" title="Crazy deal là gì ?">Crazy deal là gì <span>?</span></a>
            <div class="dropcrazy"><b>CrazyDeal</b> là chương trình giá shock mỗi ngày của dienmay.com. Theo đó, mỗi ngày chúng tôi sẽ giảm giá đến <b>50%</b> cho 01 sản phẩm bất kì.</div>
          </div>
        </div>
        <?php }?>
        <div id="normalbanner" class="nodeal" <?php if (!empty($_smarty_tpl->getVariable('crazydealproduct',null,true,false)->value)){?>style="display:none;"<?php }?>>          
          <?php if (count($_smarty_tpl->getVariable('rightbanner')->value)>0){?>
              <?php  $_smarty_tpl->tpl_vars['rbanner'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rightbanner')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['rightbannername']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rbanner']->key => $_smarty_tpl->tpl_vars['rbanner']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['rightbannername']['iteration']++;
?>
                  <a href="<?php echo $_smarty_tpl->getVariable('rbanner')->value->getAdsPath();?>
"  title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('rbanner')->value->title);?>
">
                      <img src="<?php echo $_smarty_tpl->getVariable('rbanner')->value->getImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('rbanner')->value->title);?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('rbanner')->value->title);?>
" />
                  </a>
                  <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['rightbannername']['iteration']==1){?><?php break 1?><?php }?>
              <?php }} ?>        
          <?php }?>
        </div>      
</div>
<!-- banner left -->
<div class="bn_left">
<?php if (count($_smarty_tpl->getVariable('slidebanner')->value)>0){?>
	<div class="device">
      <a class="arrow-left" href="#">«</a> 
      <a class="arrow-right" href="#">»</a>
      <!-- the slider -->
      <div class="swiper-container">
        <div class="swiper-wrapper">
        <!-- the items -->
        <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('slidebanner')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['slide']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['slideshowbanner']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
 $_smarty_tpl->tpl_vars['slide']->index++;
 $_smarty_tpl->tpl_vars['slide']->first = $_smarty_tpl->tpl_vars['slide']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['slideshowbanner']['first'] = $_smarty_tpl->tpl_vars['slide']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['slideshowbanner']['iteration']++;
?>
        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['slideshowbanner']['first']){?>
         <div class="swiper-slide">
          <a href="<?php echo $_smarty_tpl->getVariable('slide')->value->getAdsPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('slide')->value->title);?>
"><img src="<?php echo $_smarty_tpl->getVariable('slide')->value->getImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('slide')->value->title);?>
"></a>
        </div>
        <?php }else{ ?>
       <div class="swiper-slide">
          <a href="<?php echo $_smarty_tpl->getVariable('slide')->value->getAdsPath();?>
" title="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('slide')->value->title);?>
"><img src="<?php echo $_smarty_tpl->getVariable('slide')->value->getImage();?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('slide')->value->title);?>
"></a>
        </div>
        <?php }?>
        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['slideshowbanner']['iteration']==8){?><?php break 1?><?php }?>
        <?php }} ?>
      </div>
     
      <!-- the controls -->
      </div>
       <div class="pagination"></div>
    </div>
    <?php }?>
</div>

<script type="text/javascript">
    var pid = "<?php echo $_smarty_tpl->getVariable('crazydealproduct')->value->pid;?>
";
    var fpcid = "<?php echo $_smarty_tpl->getVariable('crazydealproduct')->value->pcid;?>
";
    $(document).ready(function() {
        if($('#crazydeal').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimecrazydeal",{fpid:pid,fpcid:fpcid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]); 
            GetCount(dateFuture1,'countbox1');
        });      
        }
    });

    function GetCount(ddate,iid){

    dateNow = new Date(); //grab current date
    amount = ddate.getTime() - dateNow.getTime(); //calc milliseconds between dates
    delete dateNow;
    // if time is already past
    if(amount < 0){
       $.post( rooturl+"product/updatestatusandpromotion",{fpid:pid,fpcid:fpcid}, function(data) {
          if(data == 1)
          {
            $('.crazydetail').remove();
            $('.datesatus').remove();
            $('.dealtime').remove();
           
            //location.reload();
            $("#crazydeal").hide();
            $("#normalbanner").show();
          }
       });      
    }
    // else date is still good
    else{
      hours=0;mins=0;secs=0;out="";

      amount = Math.floor(amount/1000);

      hours=Math.floor(amount/3600);
      amount=amount%3600;

      mins=Math.floor(amount/60);
      amount=amount%60;

      secs=Math.floor(amount);//seconds

      if(hours != 0){out +="<div class='hours'>"+ hours +" "+((hours==1)?" ":"H")+" </div>  ";}
        out +="<div class='mins'>"+ mins +" "+((mins==1)?" ":" ' ")+" </div> ";
        out +="<div class='secs'>"+ secs +" "+((secs==1)?" ":" s ")+"</div>  ";
      out = out.substr(0,out.length-2);
      document.getElementById(iid).innerHTML=out;

      setTimeout(function(){GetCount(ddate,iid)}, 1000);
    }
  }
</script>

