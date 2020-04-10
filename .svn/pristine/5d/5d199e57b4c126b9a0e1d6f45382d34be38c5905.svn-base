<div id="container">
	<div class="register" style='min-height: 288px;'>

		<div class="register-icon register-title">Kiểm tra đơn hàng</div>
		{include file="notify.tpl" notifyError=$error notifySuccess=$success}
		<div class="form-hor">
				<div class="choose-member" style="background-color: white;height:0">
				</div>

				<div class="form-main">

					<div class=" form-single">
						<label class="label" style='background-color:white;white-space: normal;'>Email hoặc số điện thoại
							* </label>
						<input type="text" name="fuser" id="fuser" class="keyeneter" value="{$formData.user}"/>
					</div>

					<div class=" form-single">
						<label class="label" style='background-color:white;white-space: normal;'>Mã đơn hàng *:</label>
						<input type="text" name="fidsaleorder" id="fidsaleorder" class="keyeneter" value="{$formData.saleid}"/>
					</div>
				</div>
		</div>
		<div class="clr"></div>
		<div class="button btnchecksaleorder divbtnloading" >
			<div class="btnsubmit" id="btnCheck">Kiểm tra</div>
		</div>
		<div id="urlajax" url="{$conf.rooturl}index/indexajax"></div>
		<div id="urlindex" url="{$conf.rooturl}"></div>
		<div id="urllogin" url="{$conf.rooturl}login"></div>
        <div id="autos"    value="{$formData.autosearch}"></div>
	</div>
</div>
{if $formData.load=='1'}
<script type="text/javascript">
    var urlpost = '{$conf.rooturl}';
	var langsearch ='Đang tìm kiếm';
	var formsearch;
    $(document).ready(function(){
        
       var au = {$formData.autosearch};
       if(au==1)
       {
        sendajax();
        formsearch = editelement();
       }
        
        
        
   
	{literal}
	$("#btnCheck").live("click",function () {
		var user = $("#fuser").val();
		var pass = $("#fidsaleorder").val();
		if (user != '' && pass != '') {
			/*======================CHECKOUT=============================*/
			formsearch = editelement();
			sendajax();
			/*======================CHECKOUT=============================*/
		}else{
			 nalert('vui lòng nhập đầy đủ thông tin' , 'Lỗi');
		}
	});
	$(".keyeneter").keyup(function (event) {
		var user = $("#fuser").val();
		var pass = $("#fidsaleorder").val();
		if (user != '' && pass != '') {
			/*======================CHECKOUT=============================*/

			if (event.keyCode == 13) {
				formsearch = editelement();
				sendajax();
			}
			/*======================CHECKOUT=============================*/
		}
	});
    
	function sendajax() {

 		var divhtml =  $(".divbtnloading");
 		var cusid = null;
		cusid = $('#fuser').val();	
		var saleid = $('#fidsaleorder').val();
		var datasend = {
			fidsaleorder: saleid,
            aut          : au
		};
	
		if(cusid == '' || cusid == null){
			datasend['action'] = 'checksaleordergiare';
		}else{
			datasend['action'] = 'checksaleorder';
			datasend['fuser'] = cusid;
		}	


		$.ajax({
			type: "POST",
			data: datasend,
			url: urlpost+"account/indexajax",
			dataType: "html",
			success: function (data) {
				$('#container').html(data).delay(5000);
			}
		})

	}

	function editelement()
	{
		var codehtml = '<div style="text-align: center">'+langsearch+'<br><img src="'+urlpost+'/templates/default/images/ajax-loader.gif"></div>';
		var divhtml =  $(".divbtnloading");
		var stylecss = 'style="width: 220px !important"';
		var htmbtn   = divhtml.html();
		divhtml.html(codehtml).attr('style',stylecss);
		return htmbtn;
	}
	function goback()
	{
		window.location.href= urlpost+"account/checksaleorder";
	}
	{/literal}
    });
	
    
</script>
{/if}