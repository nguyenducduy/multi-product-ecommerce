 <div id="back-top" style="display: block;"><a href="#top"><span></span><strong>Lên đầu trang</strong></a></div>
<!-- footer -->
    <div class="newsbot">
      <div class="newsbotcopy"> <span>dienmay.com</span>
        <p> © 2013 Công ty Cổ phần Thế Giới Điện Tử <br />
          ĐCĐK: 130 Trần Quang Khải, P. Tân Định, Q.1, TP.HCM.<br />
          GPĐKKD số: 0310471746 do Sở KHĐT Tp.HCM cấp ngày 3/11/2010.<br />
          Giấy phép thiết lập trang TTĐT số 22/GP-ICP-STTTT, cấp ngày 20/03/2012.<br />
          Email: <strong class="newsbotmail">lienhe@dienmay.com.</strong> <br />
          Điện thoại: <strong class="newsbotcall">08 38 125 960</strong> Fax: <strong class="newsbotcall">08 38 125 961</strong><br />
        </p>
      </div>
      <div class="newsbotdepart"> <span>Danh mục</span>
        <ul>
        {foreach item=pcat from=$parentCat}
          <li><a href="{$pcat->getNewscategoryPath()}" title="{$pcat->name}">{$pcat->name}</a></li>
        {/foreach}
        </ul>
      </div>
      <div class="newsbotinfo"> <span>Thông tin diemay.com</span>
        <ul>
          <li><a href="{$conf.rooturl}gioi-thieu-ve-dienmaycom" title="Giới thiệu về dienmay.com">Giới thiệu dienmay.com</a></li>
          <!-- <li><a href="#" title="">Cộng tác viên tin tức</a></li> -->
          <li><a href="{$conf.rooturl}tuyendung" title="Tuyển dụng">Tuyển dụng</a></li>
          <li><a href="http://forum.dienmay.com" title="Forum dienmay.com">Forum</a></li>
        </ul>
      </div>
      <div class="newsbotsocial"> <span>social network</span>
        <ul>
          <li><a target="_blank" href=" " title=""><i class="icon-netw1"></i></a></li>
          <li><a target="_blank" href=" " title=""><i class="icon-netw2"></i></a></li>
          <!-- <li><a target="_blank" href="#" title=""><i class="icon-netw3"></i></a></li> -->
        </ul>
      </div>
    </div>
</div>
<div class="hide" style="display:none;">
	<span id="internaltopbar_editurl">{$internaltopbar_editurl}</span>
	<span id="internaltopbar_refreshurl">{$internaltopbar_refreshurl}</span>
	<span id="internaltopbar_reporturl">{$internaltopbar_reporturl}</span>
	<span id="internaltopbar_reporttype">{$internaltopbar_reporttype|default:$controller}</span>
	<span id="internaltopbar_objectid">{$internaltopbar_objectid|default:"0"}</span>
</div>
     <script type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>

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
    


    {include file="googleanalytic.tpl"}
    {include file="websocket_external.tpl"}
    {include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>
