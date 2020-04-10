<?php /* Smarty version Smarty-3.0.7, created on 2020-04-09 13:44:15
         compiled from "templates/default/_controller/site/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20520827245e8ec43fe3aba3-45134804%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ace15b10241f81778d7c4d2193520ba03845911' => 
    array (
      0 => 'templates/default/_controller/site/footer.tpl',
      1 => 1586414610,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20520827245e8ec43fe3aba3-45134804',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div>
    <?php if (!empty($_smarty_tpl->getVariable('footerkey',null,true,false)->value)){?>
    <div id="keys">
      <div class="keystitle">Được quan tâm nhiều nhất tại dienmay.com</div>
        <?php echo $_smarty_tpl->getVariable('footerkey')->value;?>

    </div>
    <?php }elseif(!empty($_smarty_tpl->getVariable('footerheadertext',null,true,false)->value['footer'])){?>
        <div id="keys">
          <div class="keystitle">Được quan tâm nhiều nhất tại dienmay.com</div>
          <?php echo $_smarty_tpl->getVariable('footerheadertext')->value['footer']->content;?>

        </div>
    <?php }?>

<div id="brand">
  <?php if (!empty($_smarty_tpl->getVariable('footerheadertext',null,true,false)->value['brand'])){?>
  <div class="brandlist"> <span><?php echo $_smarty_tpl->getVariable('footerheadertext')->value['brand']->title;?>
</span>
    <div class="line brands-list">
      <div class="col1of5">        
	        <?php echo $_smarty_tpl->getVariable('footerheadertext')->value['brand']->content;?>
 
      </div>
    </div>
  </div>
  <?php }?>
  <?php if (!empty($_smarty_tpl->getVariable('footerheadertext',null,true,false)->value['category'])){?>
  <div class="departfavorite"> <span><?php echo $_smarty_tpl->getVariable('footerheadertext')->value['category']->title;?>
</span>
    <?php echo $_smarty_tpl->getVariable('footerheadertext')->value['category']->content;?>

  </div>
  <?php }?>
</div>

<div id="footer">
  <div class="colfoot-1"><span>Cam kết tận tâm</span>
    <ul>
      <li><i class="icon-market"></i><div class="descam">Sản phẩm, hàng hóa chính hãng, chất lượng.</div></li>
      <li><i class="icon-warranty"></i><div class="descam">7 ngày bảo hành đổi trả miễn phí</div></li>
      <li><i class="icon-service"></i><div class="descam">Dịch vụ chăm sóc khách hàng tốt nhất</div></li>
    </ul>
  </div>
  <div class="colfoot-2"> <span>Hỗ trợ khách hàng</span>
        <ul>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
huong-dan-mua-online" title="Hướng dẫn mua online">Hướng dẫn mua online</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
bao-hanh-doi-tra" title="Bảo hành, đổi trả">Bảo hành, đổi trả</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
account/checksaleorder" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
        </ul>
  </div>
  <div class="colfoot-3"> <span>Thông tin công ty</span>
    <ul>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu về dienmay.com</a></li>
            <li><i class="arrowbt2"></i><a href="<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
tuyendung" title="Tuyển dụng" >Tuyển dụng</a></li>
    </ul> 
    <a target="_blank" href="https://www.facebook.com/dienmaycom"><i class="icon-dmface"></i></a> 
    <a target="_blank" href="https://www.google.com/+dienmay"><i class="icon-dmggl"></i></a> 
    <div class="input-append">
        <label class="textregiserpromo">Đăng ký nhận tin khuyến mãi</label>
        <input class="inputfoot wi-inreg" id="appendedInputButton"   type="text" placeholder="Nhập email để nhận khuyến mãi">
        <button class="login regis" type="button" id='btndk' onclick="addsub()">Đăng ký</button>
    </div>
  </div>
    <div class="colfoot-4">
        <span>Tổng đài trợ giúp</span>
        <p><i class="icon-call"></i><span class="fontcall">1800 1061 - (08) 39 48 6789</span><span class="timeser">(từ 8h00 đến 20h00 tất cả các ngày)</span></p>
    	<p><i class="icon-latter"></i><span class="email2">cskh@dienmay.com</span></p>
    	<p><span class="help">Giải quyết khiếu nại:</span><span class="helpcall"> 1800 1063</span></p>
    </div>
</div>
<div id="copyright">
	<p>&copy; 2013 Công ty Cổ phần Thế Giới Điện Tử - ĐCĐK: 130 Trần Quang Khải, P. Tân Định, Q.1, TP.HCM. GPĐKKD số: 0310471746 do Sở KHĐT Tp.HCM cấp ngày 3/11/2010.</p>
	<p>Email: lienhe@dienmay.com. Điện thoại: 08 38 125 960. Fax: 08 38 125 961.</p>
	<p>Giấy phép thiết lập trang TTĐT số 22/GP-ICP-STTTT, cấp ngày 20/03/2012.</p>
	<p><a title="dienmay.com" href="http://dienmay.com">http://dienmay.com</a></p>
</div>

<div class="hide" style="display:none;">
	<span id="internaltopbar_editurl"><?php echo $_smarty_tpl->getVariable('internaltopbar_editurl')->value;?>
</span>
	<span id="internaltopbar_refreshurl"><?php echo $_smarty_tpl->getVariable('internaltopbar_refreshurl')->value;?>
</span>
	<span id="internaltopbar_reporturl"><?php echo $_smarty_tpl->getVariable('internaltopbar_reporturl')->value;?>
</span>
	<span id="internaltopbar_reporttype"><?php echo (($tmp = @$_smarty_tpl->getVariable('internaltopbar_reporttype')->value)===null||$tmp==='' ? $_smarty_tpl->getVariable('controller')->value : $tmp);?>
</span>
	<span id="internaltopbar_objectid"><?php echo (($tmp = @$_smarty_tpl->getVariable('internaltopbar_objectid')->value)===null||$tmp==='' ? "0" : $tmp);?>
</span>
</div>

	<input type="hidden" name="trackingid" value="<?php echo $_GET['trackingid'];?>
" id="t_id" />
	<input type="hidden" name="controller_group" value="<?php echo $_smarty_tpl->getVariable('controllerGroup')->value;?>
" id="t_controller_group" />
	<input type="hidden" name="controller" value="<?php echo $_smarty_tpl->getVariable('controller')->value;?>
" id="t_controller" />
	<input type="hidden" name="action" value="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" id="t_action" />
	<input type="hidden" name="q" value="<?php echo $_GET['q'];?>
" id="t_q" >

    <script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
/min/?g=js"></script>
    <!--<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
min/?g=js&ver=<?php echo $_smarty_tpl->getVariable('setting')->value['site']['jsversion'];?>
"></script>-->

    <script type="text/javascript">

    var rooturl_indexajax = "<?php echo $_smarty_tpl->getVariable('conf')->value['rooturl'];?>
index/indexajax";
    var currentTemplate = "<?php echo $_smarty_tpl->getVariable('currentTemplate')->value;?>
";
    
	function addsub()
	{
		$("#btndk").html('Đang Lưu');
		var email = $('#appendedInputButton').val();
		if(email!='')
		{
			$.ajax({
				type : "POST",
				data : {action:"addsub",femail:email},
				url : rooturl_indexajax,
				dataType: "html",
				success: function(data){
					if(data=='ok')
						$("#btndk").html('Thành công');
					if(data=='ext')
					{
						$("#btndk").html('Đã đăng kí');
						$('#appendedInputButton').attr('style','border-color: red');
						setTimeout(function(){
							$("#btndk").html('Đăng kí');
						}, 5000);
					}
					if(data=='err')
					{
						$("#btndk").html('Email sai');
						$('#appendedInputButton').attr('style','border-color: red');
						setTimeout(function(){
							$("#btndk").html('Đăng kí');
						}, 5000);
					}
				}
			});
		}
		else
		{
			$("#btndk").html('Đăng kí');
			$('#appendedInputButton').attr('style','border-color: red');
		}
	}
	$('#appendedInputButton').click(function(){
		$('#appendedInputButton').attr('style','');
	});
	
    </script>
    
</body>
</html>
