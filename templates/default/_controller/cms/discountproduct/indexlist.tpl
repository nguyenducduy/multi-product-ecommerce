<title>Add Discount Product</title>
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/FortAwesome/css/font-awesome.css" type="text/css" media="screen" />

<!-- Bootstrap Responsive Stylesheet -->
<link rel="stylesheet" href="{$currentTemplate}/bootstrap/css/bootstrap-responsive.min.css" type="text/css" media="screen" />

<!-- Customized Admin Stylesheet -->
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadmin&ver={$setting.site.cssversion}" media="screen" />
<link type="text/css" rel="stylesheet" href="{$currentTemplate}min/?g=cssadminresponsive&ver={$setting.site.cssversion}" media="screen" />

<!-- jQuery -->
<script type="text/javascript" src="{$currentTemplate}js/admin/jquery.js"></script>

<!-- Bootstrap Js -->
<script type="text/javascript" src="{$currentTemplate}bootstrap/js/bootstrap.min.js"></script>


<!-- customized admin -->
<script src="{$currentTemplate}min/?g=jsadmin&ver={$setting.site.jsversion}"></script>
 <script type="text/javascript">
        var rooturl = "{$conf.rooturl}";
        var rooturl_admin = "{$conf.rooturl_admin}";
        var rooturl_cms = "{$conf.rooturl_cms}";
        var rooturl_crm = "{$conf.rooturl_crm}";
        var rooturl_erp = "{$conf.rooturl_erp}";
        var rooturl_profile = "{$conf.rooturl_profile}";
        var controllerGroup = "{$controllerGroup}";
        var currentTemplate = "{$currentTemplate}";

</script>
<style type="text/css">
    body{
        padding: 0px;
    }
    .page-header h1 {
        margin-top: 10px;
    }
    #choose, .table{
        font-size: 12px;
    }
 
</style>

<div class="page-header" rel="menu_cheapproduct"><h1>{$lang.controller.head_list}</h1></div>


<div class="tabbable">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">{$lang.controller.title_list} {if $formData.search != ''}| {$lang.controller.title_listSearch} {/if}</a></li>
        {if $formData.search != ''}
            <li><a href="{$conf.rooturl_cms}{$controller}">{$lang.default.formViewAll}</a></li>
        {/if}
    </ul>
    <div class="tab-content">
        <div id="tab1">
            {include file="notify.tpl" notifyError=$error notifySuccess=$success}
            <form action="" method="post" name="myform" class="form-horizontal" style="margin-top: 10px;" enctype="multipart/form-data">
                {$lang.controller.labelProductName}: <input type="text" style="height:30px" name="fsearchproduct" id="fsearchproduct" value="{$formData.fsearchproduct|@htmlspecialchars}" />
                <input type="button" value="{$lang.default.filterSubmit}" class="btn btn-primary" onclick="searchDiscountProduct();"  />    

                <div id="resultcheapproduct">

                </div>
                <div id="accessoriesproduct" {if empty($result)}style="display:none;"{/if}>
                    <h1>{$lang.controller.labelProductListChoose}</h1>
                    <table class="table" id="choose"><thead>
                    <input type="hidden" name="ftoken" value="{$smarty.session.discountUpdateToken}" />
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Barcode</th>
                        <th>Danh mục</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th></th>
                    </tr>
                </thead><tbody id="discountlist">
                    {if $result|@count>0}{$result}{/if}
                </tbody></table>
                <div class="form-actions">
                    <input type="submit" class="btn btn-large btn-primary" value=" {$lang.controller.labelUpdate} " name="fsubmit">
                </div>
                </div>
                
            </form>
        </div><!-- end #tab2 -->
    </div>
</div>
            
            

{literal}
<script type="text/javascript">
    function searchDiscountProduct()
    {
        if($('#fsearchproduct').val() != '')
        {
            var dataString = "pname=" + $('#fsearchproduct').val();
            $.ajax({
                type : "post",
                dataType : "html",
                url : "/cms/discountproduct/ajaxgetproductsbydiscountid",
                data : dataString,
                success : function(html){
                    if(html != ''){
                        $('#resultcheapproduct').html(html);
                        if($('#accessoriesproduct').attr('display') != 'none'){
                            $('#accessoriesproduct').fadeIn(10);
                        }
                    }else{
                        $('#resultcheapproduct').html('{/literal}{$lang.controller.errNotFound}{literal}');
                    }
                }
            });
        }
        else
        {
            bootbox.alert('{/literal}{$lang.controller.errNameNotEmpty}{literal}');
        }
    }
    $('#fdcid').change(function(){
        var id = $(this).val();
        if(id != 0)
        {
            var dataString = "id=" + id;
            $.ajax({
                type : "post",
                dataType : "html",
                url : "/cms/discountproduct/ajaxgetproductsbydiscountid",
                data : dataString,
                success : function(html){
                    if(html != 0){
                        $('tbody#discountlist').html(html);
                        if($('#accessoriesproduct').attr('display') != 'none'){
                            $('#accessoriesproduct').fadeIn(10);
                        }
                    }else{
                        $('tbody#discountlist').html('{/literal}<tr><td>{$lang.controller.errNotFound}{literal}</td></tr>');
                        if($('#accessoriesproduct').attr('display') != 'none'){
                            $('#accessoriesproduct').fadeIn(10);
                        }
                    }
                }
            });
        }
    })
    var i = $('.displayorder').length;
    function chooseFunction(id)
    {
        if(id > 0)
        {
            //kiem tra xem san pham nay da duoc chon hay chua ?
            if($('#'+'_'+id).length == 0)
            {
                var imgSource = $('#images_'+id).attr('src');
                var pid = $('#pid').html();
                var barcode = $('#barcode').html();
                var category = $('#categorys_'+id).html();
                var productName = $('#names_'+id).html();
                var productInstock = $("#instocks_"+id).html();
                var productPrice = $('#prices_'+id).html();
                var data = '<tr id="row'+'_'+id+'">';
                data += '<td><input type="text" class="displayorder" value="'+i++ +'" name="displayorder[]" class="input-mini" style="width:50px;height:30px"/></td></td>';
                data += '<td>';
                if(imgSource != undefined)
                {
                    data += '<a href="'+imgSource+'" rel="shadowbox" ><img src="'+imgSource+'" width="50" height="50" /></a>';
                }
                data += '</td>';
                data += '<td>'+pid+'</td>';
                data += '<td>'+barcode+'</td>';
                data += '<td><span class="label label-info">'+category+'</span></td>';
                data += '<td><input type="hidden" name="listpids[]" value="'+id+'" id="'+'_'+id+'" />'+productName+'</td>';
                data += '<td>'+productInstock+'</td>';
                data += '<td>'+productPrice+'</td>';
                data += '<td><input type="button" class="btn btn-danger" id="fclear_'+id+'" onclick="clearFunction('+id+')" value="Remove" /></td>';
                data += '</tr>';
                $('#choose').find('tbody').append(data);
                $('#rows'+'_'+id).fadeOut(10);
            }
            else
            {
                bootbox.alert('{/literal}{$lang.controller.errProductChoose}{literal}');
            }
        }
    }
    
    function clearFunction(id)
    {
        $('#row_'+id).remove();
        $('#row_'+id).fadeIn(10);
    }
</script>
{/literal}