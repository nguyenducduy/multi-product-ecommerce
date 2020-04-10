<ul class="breadcrumb">
    <li><a href="{$conf.rooturl_cms}">{$lang.default.menudashboard}</a> <span class="divider">/</span></li>
    <li><a href="{$conf.rooturl}{$controllerGroup}/{$controller}">Discount Product</a> <span class="divider">/</span></li>
    <li class="active">{$lang.controller.head_add}</li>
</ul>

<div class="page-header" rel="menu_eventproducthours"><h1>{$lang.controller.head_add}</h1></div>

<div class="navgoback"><a href="{$registry->conf.rooturl_cms}eventproducthours/index/">{$lang.default.formBackLabel}</a></div>

<form action="" method="post" name="myform" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="ftoken" value="{$smarty.session.eventProductAddToken}" />

    {include file="notify.tpl" notifyError=$error notifySuccess=$success}
    {include file="tinymce.tpl"}
    <div class="control-group">
        <label class="control-label" for="fpid">Mã sản phẩm tương ứng<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fpid" value = "{$formData.fpid}" class="input-xlarge"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fname">Tên sản phẩm<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fname" value = "{$formData.fname}" class="input-xlarge"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fimages">Link images<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fimages" value = "{$formData.fimages}" class="input-xlarge"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fcurrentprice"> Giá thị trường<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fcurrentprice" value = "{$formData.fcurrentprice|@number_format:2:'.':','}"class="input-xlarge"/>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label" for="fdiscountprice">Giá khuyến mãi<span class="star_require">*</span></label>
        <div class="controls">
            <input type="text" name="fdiscountprice" value = "{$formData.fdiscountprice|@number_format:2:'.':','}" class="input-xlarge"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="feventtime"> Khoảng thời gian được bán<span class="star_require">* (phút) </span></label>
        <div class="controls">
            <input type="text" name="feventtime" value = "{$formData.feventtime}" class="input-xlarge"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fbegindate">Ngày bắt đầu <span class="star_require">*</span></label>
        <div class="controls">
            <div class="input-append bootstrap-timepicker">
                <input id="fsttime" type="text"  placeholder="H:m:s" name="fsttime" class="input-small timepicker">
                <span class="add-on"><i class="icon-time"></i></span>
            </div>
            <input type="text" name="fbegindate" id="fbegindate" value="{$formData.fbegindate|@htmlspecialchars}" class="input-large inputdatepicker">

        </div>

    </div>
    
    <div class="control-group">
        <label class="control-label" for="fenddate">Ngày kết thúc <span class="star_require">*</span></label>
        <div class="controls">
            <div class="input-append bootstrap-timepicker">
                <input id="fextime" type="text" placeholder="H:m:s" name="fextime" class="input-small timepicker">
                <span class="add-on"><i class="icon-time"></i></span>
            </div>
            <input type="text" name="fenddate" id="fenddate" value="{$formData.fenddate|@htmlspecialchars}" class="input-large inputdatepicker">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="fstatus">Status</label>
        <div class="controls">
            <select name="fstatus" class="input-xlarge" style="width:288px">
                <option value="2" {if $formData.fstatus == 2 && isset($formData.fstatus)}selected='selected'{/if}}>Chờ bán</option>
                <option value="1" {if $formData.fstatus == 1 && isset($formData.fstatus)}selected='selected'{/if}}>Đã bán</option> 
                <option value="4" {if $formData.fstatus == 4 && isset($formData.fstatus)}selected='selected'{/if}}>Chờ bán ngày sau</option>                   
            </select>
        </div>
    </div>
    <div class="form-actions">
        <input type="submit" name="fsubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
        <span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
    </div>

</form>


{literal}
  <script type="text/javascript">
            $('#fsttime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
             $('#fextime').timepicker({defaultTime:false,showMeridian:false,showSeconds:true});
    </script>
{/literal}