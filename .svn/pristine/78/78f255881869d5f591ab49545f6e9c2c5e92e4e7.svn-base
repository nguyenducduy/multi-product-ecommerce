<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

<!-- Bootstrap Responsive Stylesheet -->
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

<!-- Customized Admin Stylesheet -->
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminchart&ver={$setting.site.cssversion}" media="screen" />

<!-- jQuery -->
<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>

<!-- customized admin -->
<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
<script type="text/javascript" src="{$currentTemplate}min/?g=jsadminchart&ver={$setting.site.jsversion}"></script>
<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>


<script type="text/javascript">
var rooturl = "{$conf.rooturl}";
var rooturl_admin = "{$conf.rooturl_admin}";
var rooturl_cms = "{$conf.rooturl_cms}";
var rooturl_crm = "{$conf.rooturl_crm}";
var rooturl_erp = "{$conf.rooturl_erp}";
var rooturl_profile = "{$conf.rooturl_profile}";
var rooturl_stat = "{$conf.rooturl_stat}";
var controllerGroup = "{$controllerGroup}";
var currentTemplate = "{$currentTemplate}";

var websocketurl = "{$setting.site.websocketurl}";
var websocketenable = {$setting.site.websocketenable};

var delConfirm = "Are You Sure?";
var delPromptYes = "Type YES to continue";


var imageDir = "{$imageDir}";
var loadingtext = '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />';
var gritterDelay = 3000;
var meid = {$me->id};
var meurl = "{$me->getUserPath()}";
var userid = {$myUser->id};
var userurl = "{$myUser->getUserPath()}";
</script>
{if $formData.ftab > 0}
<a href="{$conf.rooturl_cms}producteditinline/editmedia/fpid/{$formData.fpid}/fpcid/{$formData.fpcid}/tab/{$formData.ftab}">{$lang.controller.labelBackLink}</a>
{/if}
{include file="notify.tpl" notifyError=$error notifySuccess=$success}
<h1>Thêm màu mới của sản phẩm</h1>
<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="fpid" value="{$formData.fpid}" />
    <div class="control-group">
        <label class="control-label" for="fname">{$lang.controller.labelBarcode}</label> 
        <div class="controls">
            <input name="fbarcode" value="{$formData.fbarcode}" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fname">Màu sản phẩm</label>
        <div class="controls">
            <select id="fpchoosecolor" name="fpchoosecolor">                
                <option value="-1">Chọn màu</option>
            </select>
            <div class="btn-group" style="display:none;vertical-align:top;" id="groupcolor">
                <input type="tet" class="input-large" name="fpcolorname" id="fpcolorname" value="{$formData.fpcolorname}" placeholder="Tên màu..." />&nbsp;&nbsp;
                <a class="btn btn-info dropdown-toggle" data-toggle="dropdown">Color</a>
                <ul class="dropdown-menu">
                    <li><div id="colorpalette1"></div></li>
                </ul><br/>
                <input id="fpcolor" name="fpcolor" readonly="readonly" value="{$formData.fpcolor}">                            
            </div>
        </div>
    </div>
    <br/>
    <h2>Upload Gallery</h2>
    <table class="table" id="gallery">
        <tr>
            <td><input type="file" name="ffile[]" multiple /></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>        
    </table>    
    <div class="form-actions">
		<input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
        <input type="button" name="frefesh" id="frefesh" value="Đóng lại" class="btn btn-large btn-primary" />
	</div>
</form>
{literal}
<script type="text/javascript">   
    var pid = {/literal}{$myProduct->id}{literal}
    $(document).ready(function(){
        Shadowbox.init({
            onClose: function(){ window.location.reload(); }
        });

        $("#frefesh").click(function(){
            window.location = rooturl_cms + 'product/edit/id/' + pid + '/tab/6';
        });

        $('#colorpalette1').colorPalette()
          .on('selectColor', function(e) {
            $('#fpcolor').val(e.color);
            var color = $('#fpcolor').val(e.color);            
        });

        if($('#fpchoosecolor').val() === '-1')
        {
            $("#groupcolor").show();
        }

        $("#fpchoosecolor").change(function(event) {
            /* Act on the event */
            if($(this).val() === '-1'){
                $("#groupcolor").show();
            }else{
                $("#groupcolor").hide();
            }
        });

        $(".btn-color").click(function(event) {
            /* Act on the event */          
            event.preventDefault();
        });
    });
    function addRow(tbname)
    {
        rowCount = $('#'+ tbname +' tr').length;
        rowCount +=1 ;
        //alert(rowCount);
        if(tbname == 't360')
        {
            data = '<tr id="image360_'+rowCount+'"><td style="width:155px;"><input type="hidden" name="ftypeimage360['+rowCount+']" value="5"/></td><td><input type="file" name="ffile360['+rowCount+']" style="width:200px;" /><span style="padding-left:29px;">PNG,JPG,GIF</span></td><td><span id="caption360-'+rowCount+'"><input type="text" name="fcaption360['+rowCount+']" value="" placeholder="Caption..." /></td><td></td></tr>'
        }
        else
        {
            data = '<tr><td><input type="hidden" name="fimgnumber['+rowCount+']" value="1" /><input type="file" name="ffile['+rowCount+']" /></td><td><input type="text" name="fimgcaption['+rowCount+']" placeholder="Caption..." /></td><td><input type="text" name="fimgalt['+rowCount+']" placeholder="Alt..." /></td><td><input type="text" name="fimgtitleseo['+rowCount+']" placeholder="Title..." /></td></tr>';
        }
        $('#'+tbname).append(data);
    }
</script>
{/literal}