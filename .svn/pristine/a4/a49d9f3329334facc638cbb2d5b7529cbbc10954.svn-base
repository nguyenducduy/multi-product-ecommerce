<title>Chi tiết giá của sản phẩm{$myProduct->name}</title>
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

<div class="page-header"><h1 style="display:inline;">{$head_list}</h1>
	<span style="margin-left:90px;">{$lang.controller.datesync}&nbsp;:&nbsp;{$datesync|date_format:"%d/%m/%Y"}</span>
</div>
{if $pbarcodedestination != ""}
<a href="{$conf.rooturl_admin}productprice/index/pbarcode/{$pbarcodedestination}/">Quay lại trang trước</a>
{/if}
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li {if $tab == 1}class="active"{/if}><a href="#tab1" data-toggle="tab">{$lang.controller.labelPriceArea}</a></li>
		<li {if $tab == 2}class="active"{/if}><a href="#tab2" data-toggle="tab">{$lang.controller.labelAssignt}</a></li>
		{if $pbarcodedestination == ""}<li {if $tab == 3}class="active"{/if}><a href="#tab3" data-toggle="tab">Màu sản phẩm</a></li>{/if}
		<li class="pull-right"><a id="syncprice" class="btn btn-success" href="javascript:void(0)" onclick="syncPrice('{$myProduct->barcode}',{$myProduct->id})">{$lang.controller.labelUpdatePrice}</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane {if $tab == 1}active{/if}" id="tab1">
			{include file="notify.tpl" notifyError=$error notifySuccess=$success notifyWarning=$warning}			
			{if $productPriceListHtml|@count > 0}
			<table class="table table-striped" style="font-size:12px;">
				<thead>
					<tr>
						<th width="100">Khu vực giá</th>
						<th width="100">{$lang.controller.labelPriceOutputtyped}</th>
						<th>Siêu thị</th>
						<th width="120">Khu vực</th>
						<th width="120">Tỉnh</th>
						<th><a href="{$conf.rooturl_admin}productprice/index/pbarcode/{$myProduct->barcode}/sortby/sellprice/sorttype/{if $formData.sortby eq 'sellprice'}{if $formData.sorttype|upper neq 'DESC'}DESC{else}ASC{/if}{/if}">{$lang.controller.labelQuantity}</a></th>
						<th></th>

					</tr>
				</thead>
				<tbody>
					{foreach item=productPrice from=$productPriceListHtml}
					<tr>
						<td>{$productPrice->priceareaActor->name}</td>
						<td>
							{if $productPrice->outputtypeActor->id == 0}
							Giá chuẩn
							{else}
							{$productPrice->outputtypeActor->name}
							{/if}
						</td>
						<td><span class="label label-inverse">{$productPrice->storeActor->name}</span></td>
						<td>{$productPrice->areaActor->name}</td>
						<td>{$productPrice->regionActor->name}</td>
						<td style="text-align:center;"><span class="badge badge-info">{$productPrice->sellprice}</span></td>

					</tr>
					{/foreach}
				</tbody>
			</table>
			{/if}
		</div><!--end of tab1-->

		<div id="tab2" class="tab-pane {if $tab == 2}active{/if}">
        	{include file="notify.tpl" notifyError=$error notifySuccess=$success}
        	<input type="hidden" value="{$registry->router->getArg('pbarcode')}" id="hdbarcode" />
			<form action="" method="post">
            <input type="hidden" name="ftoken" id="ftoken" value="{$smarty.session.securtyToken}" />
            <input type="hidden" name="ftab" value="2"/>
            <table>
            	<tr class="traddenemy" style="display:none">
                	<td colspan="5">
                		<div class="notifi" style="background: #eaffa5; display:none;color: #6c8c00;padding: 5px;width: 410px;"></div>
                		<div class="control-group">
							<label class="control-label" style="float: left;width: 150px;padding-top: 5px;" for="fname">{$lang.controller.labelName} <span class="star_require">*</span></label>
							<div class="controls"><input type="text" id="fname" style="height:28px" value="{$formData.fname|@htmlspecialchars}" class="input-xlarge"></div>
						</div>

						<div class="control-group">
							<label class="control-label" style="float: left;width: 150px;padding-top: 5px;"  for="fwebsite">{$lang.controller.labelWebsite}</label>
							<div class="controls"><input type="text" style="height:28px" id="fwebsite" value="{$formData.fwebsite|@htmlspecialchars}" class="input-xlarge"></div>
						</div>	
						<div class="control-group">
							<label class="control-label"  style="float: left;width: 150px;padding-top: 5px;"  for="fregion">{$lang.controller.labelRegion}</label>
							<div class="controls">
								<select id="frid" style="width:270px;"> 
									{foreach item=region key=regionid from=$setting.region}
							        	<option {if $regionid == $registry->region}selected="selected" {/if} value="{$regionid}">{$region}{if $regionid == $registry->region}{/if}</option>
							        {/foreach}
								</select>
							</div>
						</div>	
						<div class="form-actions" style="padding: 5px 270px 5px;">
							<input type="submit" id="addenemysubmit" value="{$lang.default.formAddSubmit}" class="btn btn-large btn-primary" />
							<span class="help-inline"><span class="star_require">*</span> : {$lang.default.formRequiredLabel}</span>
						</div>	
                	</td>
                </tr>
            </table>
            <div style="margin:10px 0px;background:#3498db; padding: 5px 10px; font-weight:bold;font-size:14px;color:#fff" >ONLINE</div>
			{if $priceenemyonline|@count > 0}
				<table class="table table-striped" style="font-size:13px;">
					<thead>
						<tr>

							<th style="width:165px;">{$lang.controller.labelEid}</th>
							<!--<th>
								{if $registry->router->getArg('rid') > 0}
									<a href="{$registry->conf.rooturl_admin}productprice/index/pbarcode/{$registry->router->getArg('pbarcode')}/tab/2">Tất Cả</a>
								{/if}

								{$lang.controller.labelRegion}
								
							</th>-->
							<th>{$lang.controller.labelUrl}</th>
							<th>{$lang.controller.lableImage}</th>	
							<th>{$lang.controller.labelInfo}</th>	
							<th>{$lang.controller.labelRootPrice}</th>		
							<th>{$lang.controller.lablePricePromotion}</th>						
							<th></th>
						</tr>
					</thead>
					<tbody>
                    {assign var=i value="0"}   
					{foreach item=enemyon from=$priceenemyonline}
                        {$smarty.request.ten|stripslashes}
                        {if $enemyon->id == 23}
                        	
                        		<div class="pasingsosanhgia" style="margin-bottom: 20px;">
					            	<h3>Lấy link đối thủ từ so sánh giá</h3>
					            	<span style="font-weight:bold">Link so sánh giá :</span>
					            	<input class="urlPrice" type="text" value="{$enemyon->priceenemyactor->url}" name="flinksosanhgia" style="height:30px;width:440px;margin-bottom: 0;margin-left: 76px" />
					            	<input type="submit" value="Lấy link từ so sánh giá" name="fsubmitsosanhgia" class="btn btn-warning" />
					            </div>
					        	
					        {else}
					        <tr>
								<td><span><a rel="{$enemyon->id}" style="cursor:pointer" class="enemy">{$enemyon->name}</a></span></td>
								<td><input class="urlPrice" style="height:30px;width:440px"  type="text" name="furl[{$enemyon->id}]" value="{$enemyon->priceenemyactor->url}"/></td>
								
								<td>
									<img src="{$enemyon->priceenemyactor->image}" width="50px" class="fimage_{$i}" height="50px" />
									<input type="hidden" name="hdImage[{$enemyon->id}]" value="{$enemyon->priceenemyactor->image}" class="hdImage_{$i}" />
								</td>
								<td>
									<b>{$lang.controller.lableProductname}</b> : <span class="Productname_{$i}">{$enemyon->priceenemyactor->productname}</span><br>

									<input type="hidden" name="hdProductname[{$enemyon->id}]" value="{$enemyon->priceenemyactor->productname}" class="hdProductname_{$i}" />

									<b>{$lang.controller.lablePromotionInfo}</b> : <span class="Promotioninfo_{$i}">{$enemyon->priceenemyactor->promotioninfo}</span><br>

									<input type="hidden" name="hdPromotioninfo[{$enemyon->id}]" value="{$enemyon->priceenemyactor->promotioninfo}" class="hdPromotioninfo_{$i}" />

									<b>{$lang.controller.labelDescription}</b> : <span class="Description_{$i}">{$enemyon->priceenemyactor->description|strip_tags|truncate:300}</span><br>

									<a rel="shadowbox;options'{'dimensions:height=768;width=1000'}'" href="{$registry->conf.rooturl_cms}priceenemy/showdescriptionenemy/id/{$enemyon->priceenemyactor->id}">Xem chi tiết</a>
									<input type="hidden" name="hdDescription[{$enemyon->id}]" value="{$enemyon->priceenemyactor->description|escapequote}" class="hdDescription_{$i}" />
								</td>
								<td>
									<input style="height:30px;width:150px;" t\fype="text" class="priceSync_{$i}" disabled="disabled" value="{$enemyon->priceenemyactor->priceauto|number_format}" />
		                            <input type="hidden" name="hdPriceAuto[{$enemyon->id}]" value="{$enemyon->priceenemyactor->priceauto|number_format}" class="hdPriceSync_{$i}" />
								</td>
								<td><input style="height:30px;width:150px;" type="text" class="pricePromotionSync_{$i}" disabled="disabled" value="{$enemyon->priceenemyactor->pricepromotion|number_format}" />
		                            <input type="hidden" name="hdPricePromotion[{$enemyon->id}]" value="{$enemyon->priceenemyactor->pricepromotion|number_format}" class="hdPricePromotionSync_{$i}" />
		                        </td>
								<td colspan="" rowspan="" headers="">
		                            <div class="icon-load iconLoading_{$i}" style="display:none">
		                                <img src="{$conf.rooturl}templates/default/images/ajax_indicator_old.gif" />
		                            </div>
		                            <div class="iconOk_{$i} icon-ok" style="display:none; color:#3e7dbc"></div>
		                        </td>
							</tr>
                        {/if}
                        
                        {capture assign=var}{$i++}{/capture}
					{/foreach}
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="" style="text-align:center">
                            <a href="javascript:void(0)" onclick="syncindexenemyinfo($('.urlPrice'),$('#ftoken').val())" class="btn syncprice btn-warning btn-small">Đồng bộ giá</a>
                        </td>
                    </tr>
					</tbody>
				</table>
				<div class="form-actions" style="margin-top:0px; padding:5px 20px 5px;text-align:center" id="submitallbutton" style="text-align:center">
					<input type="submit" name="fsubmit" value="{$lang.default.formUpdateSubmit}" class="btn btn-large btn-primary" />					
				</div>
			{else}
				{$lang.default.notfound}
			{/if}
			</form>
            <div class="html"></div>

            <!-- OFFLINE -->
            	<form action="" method="post">
             <div style="margin:10px 0px;background:#3498db; padding: 5px 10px; font-weight:bold;font-size:14px;color:#fff" >OFFLINE</div>
              <tr>
        		<!-- <td><a href="javascript:void(0)" class="btn btn-warning" style="margin-top:10px" id="addenemy">Thêm đối thủ</a></td>-->
        		<td>
        			<a href="{$registry->conf.rooturl_cms}priceenemy/addpopup/pbarcode/{$registry->router->getArg('pbarcode')}" class="btn btn-primary" style="margin:10px 0 ;float:right" >Thêm gia đối thủ offline</a>
        		</td>
        	</tr>
			{if $priceenemyoffline|@count > 0}
				<table class="table table-striped" style="font-size:13px;">
					<thead>
						<tr>

							<th style="width:120px;">{$lang.controller.labelEid}</th>
							<th>
								{if $registry->router->getArg('rid') > 0}
									<a href="{$registry->conf.rooturl_admin}productprice/index/pbarcode/{$registry->router->getArg('pbarcode')}/tab/2">Tất Cả</a>
								{/if}

								{$lang.controller.labelRegion}
								
							</th>
							<th>{$lang.controller.labelName}</th>
							<th>{$lang.controller.labelInfo}</th>
							<th>{$lang.controller.labelRootPrice}</th>		
							<th>{$lang.controller.lablePricePromotion}</th>							
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                    {assign var=i value="0"}   
					{foreach item=enemyoff from=$priceenemyoffline}
                        {$smarty.request.ten|stripslashes}
                    <tr>
						<td><span><a rel="{$enemy->id}" style="cursor:pointer" class="enemy">{$enemyoff->enemyactor[0]->name}</a></span></td>
						<td>
							<span class="label label-inverse" style="cursor:pointer">
								<a rel="{$enemyoff->rid}"  style="cursor:pointer; color:#fff" class="region">{$setting.region[$enemyoff->rid]}</a>
							</span>
						</td>
						<td>{$enemyoff->name}</td>
						<td  style="width:550px;">
							<b>{$lang.controller.lableProductname}</b> : <span class="">{$enemyoff->productname}</span>
							<b>{$lang.controller.lablePromotionInfo}</b> : <span class="">{$enemyoff->promotioninfo|strip_tags}</span><br>
							<b>{$lang.controller.labelDescription}</b> : <span class="">{$enemyoff->description|strip_tags|truncate:300}</span><br>
						</td>
						<td>
							<input style="height:30px;width:150px;" type="text"  disabled="disabled" value="{$enemyoff->price|number_format}" />
						</td>
						<td><input style="height:30px;width:150px;" type="text" disabled="disabled" value="{$enemyoff->pricepromotion|number_format}" />
                        </td>
						<td>
							<a title="Thay đổi thông tin dòng này" href="{$registry->conf.rooturl_cms}priceenemy/editpopup/id/{$enemyoff->id}/pbarcode/{$pbarcode}" class="btn btn-mini"><i class="icon-pencil"></i> Edit</a> &nbsp;
								
							<a title="Xóa dòng này" href="{$registry->conf.rooturl_admin}productprice/deletepriceenemy/id/{$enemyoff->id}/pbarcode/{$pbarcode}" class="btn btn-mini btn-danger"><i class="icon-remove icon-white"></i></a>
						</td>
					</tr>
                        {capture assign=var}{$i++}{/capture}
					{/foreach}
                   
					</tbody>
				</table>
				
			{else}
				{$lang.default.notfound}
			{/if}
			</form>
            <div class="html"></div>
		</div><!--end of tab2-->

		{if $pbarcodedestination == ""}
		<div id="tab3" class="tab-pane {if $tab == 3}active{/if}">
			{if $productcolorlist|@count > 0}
			<table class="table table-striped" style="font-size:12px;">
				<thead>
					<tr>
						<td>Màu</td>
						<td>Barcode</td>
						<td>Giá</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					{foreach item=product from=$productcolorlist}
					<tr>
						<td><b>{$product.color}</b></td>
						<td><span class="label">{$product.barcode}</span></td>
						<td><span class="badge badge-info">{$product.price}</span></td>
						<td><a href="{$conf.rooturl_admin}productprice/index/pbarcode/{$product.barcode}/pbarcodedestination/{$myProduct->barcode}">Xem chi tiết</a></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			{/if}
		</div><!--end of tab3-->
		{/if}
	</div>

</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$('#frid').select2();
	});
    $('.region').bind("click",function(){
    	var rid = $(this).attr('rel');
    	var path = rooturl + controllerGroup + "/productprice/index/pbarcode/"+$('#hdbarcode').val()+"/tab/2";
    	if(rid > 0)
    	{
    		path += '/rid/' + rid;
    	}
    	document.location.href= path;
    })
    $('#addenemy').bind("click",function(){
    	if($(".traddenemy").css('display') == 'none')
    		$(".traddenemy").fadeIn('fast');
    	else
    		$(".traddenemy").fadeOut('fast');
    })
    $('#addenemysubmit').click(function(){
    	var fname = $('#fname').val();
    	var fwebsite = $('#fwebsite').val();
    	var frid = $('#frid').val();
    	if(fname == '')
    	{
    		alert('vui lòng nhập tên đối thủ');
    		return false;
    	}
    	var data = {
    		'faddenemy':'submit',
    		'fname': fname,
    		'fwebsite' : fwebsite,
    		'frid' : frid
    	};
        $.ajax({
			type: "POST",
			url: rooturl_admin+"productprice/ajaxaddenemy",
			data: data,
            cache: false,
			dataType:'html',
			success: function(d){
				$('.notifi').fadeIn();
			     if(d == 1)
			     {
			     	alert('Thêm đối thủ thành công');
			     	var path = rooturl + controllerGroup + "/productprice/index/pbarcode/"+$('#hdbarcode').val()+"/tab/2";
			     	document.location.href= path;
			     }
			     else{
			     	$('.notifi').html('Thêm đối thủ không thành công vui lòng thử lại');
			     	$('.notifi').css('color','red');
			     }
			},
            error: function (){
                
            }
	    });    
	    return false;   
    })
</script>
{/literal}
