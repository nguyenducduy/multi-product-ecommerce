<div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div>
    {if !empty($footerkey)}
    <div id="keys">
      <div class="keystitle">Được quan tâm nhiều nhất tại dienmay.com</div>
        {$footerkey}
    </div>
    {elseif !empty($footerheadertext.footer)}
        <div id="keys">
          <div class="keystitle">Được quan tâm nhiều nhất tại dienmay.com</div>
          {$footerheadertext.footer->content}
        </div>
    {/if}

<div id="brand">
  {if !empty($footerheadertext.brand)}
  <div class="brandlist"> <span>{$footerheadertext.brand->title}</span>
    <div class="line brands-list">
      <div class="col1of5">        
	        {$footerheadertext.brand->content} 
      </div>
    </div>
  </div>
  {/if}
  {if !empty($footerheadertext.category)}
  <div class="departfavorite"> <span>{$footerheadertext.category->title}</span>
    {$footerheadertext.category->content}
  </div>
  {/if}
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
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}huong-dan-mua-online" title="Hướng dẫn mua online">Hướng dẫn mua online</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}huong-dan-mua-tra-gop-tai-dienmaycom" title="Hướng dẫn mua trả góp">Hướng dẫn mua trả góp</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}bao-hanh-doi-tra" title="Bảo hành, đổi trả">Bảo hành, đổi trả</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}account/checksaleorder" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}danh-cho-doanh-nghiep" title="Dành cho doanh nghiệp">Dành cho doanh nghiệp</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}chinh-sach-giao-hang-lap-dat-50-km" title="Chính sách giao hàng">Chính sách giao hàng</a></li>
        </ul>
  </div>
  <div class="colfoot-3"> <span>Thông tin công ty</span>
    <ul>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu về dienmay.com</a></li>
            <li><i class="arrowbt2"></i><a href="{$conf.rooturl}tuyendung" title="Tuyển dụng" >Tuyển dụng</a></li>
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
	<p><a title="dienmay.com" href="https://ecommerce.kubil.app">https://ecommerce.kubil.app</a></p>
</div>

<div class="hide" style="display:none;">
	<span id="internaltopbar_editurl">{$internaltopbar_editurl}</span>
	<span id="internaltopbar_refreshurl">{$internaltopbar_refreshurl}</span>
	<span id="internaltopbar_reporturl">{$internaltopbar_reporturl}</span>
	<span id="internaltopbar_reporttype">{$internaltopbar_reporttype|default:$controller}</span>
	<span id="internaltopbar_objectid">{$internaltopbar_objectid|default:"0"}</span>
</div>

	<input type="hidden" name="trackingid" value="{$smarty.get.trackingid}" id="t_id" />
	<input type="hidden" name="controller_group" value="{$controllerGroup}" id="t_controller_group" />
	<input type="hidden" name="controller" value="{$controller}" id="t_controller" />
	<input type="hidden" name="action" value="{$action}" id="t_action" />
	<input type="hidden" name="q" value="{$smarty.get.q}" id="t_q" >

    <script type="text/javascript" src="{$currentTemplate}/min/?g=js"></script>
    <!--<script type="text/javascript" src="{$currentTemplate}min/?g=js&ver={$setting.site.jsversion}"></script>-->

    <script type="text/javascript">

    var rooturl_indexajax = "{$conf.rooturl}index/indexajax";
    var currentTemplate = "{$currentTemplate}";
    {literal}
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
	{/literal}
    </script>
    


    {* {include file="googleanalytic.tpl"} *}
    {* {include file="websocket_external.tpl"} *}
    {* {include file="`$smartyControllerGroupContainer`../analytic.tpl"} *}
</body>
</html>
