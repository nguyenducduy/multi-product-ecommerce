<!-- Content -->
    <section>
       <div class="profile">
       		<div class="btnback"><a href="javascript:history.back()">« Trở về</a></div>
       		<h4>Thông tin tài khoản</h4>
       		<div class="notifiprofile" id="notifiprofile"></div>
            <div class="infoprofile">
            	<label>Họ tên:</label>
                <input maxlength="50" id="textfullname" class="profileinput" name="ffullname" value="{$formData.fullname|@htmlspecialchars}" type="text" disabled="disabled" placeholder="Họ và tên">
                <div class="btnedit"><a id="btnfullname" href="javascript:;"><i class="icon-edit"></i></a></div>
            </div>
            <div class="infoprofile">
            	<label>Email:</label>
                <input id="textemail" class="profileinput" name="femail" value="{$formData.email|@htmlspecialchars}" type="text" disabled="disabled" placeholder="Nhập email">
                
            </div>
            <div class="infoprofile">
            	<label>Điện thoại:</label>
                <input maxlength="15" id="textphone" class="profileinput" name="fphone" value="{$formData.phone|@htmlspecialchars}" type="tel" disabled="disabled" placeholder="Nhập số điện thoại">
                <div class="btnedit"><a id="btnphone" href="javascript:;"><i class="icon-edit"></i></a></div>
            </div>
            <div class="infoprofile">
            	<label>Giới tính:</label>
            	<div class="profileinput">
                <input class="radiogender" disabled="disabled" class="radiomb" name="fgender" type="radio" value="1" {if $formData.gender == 1}checked="checked"{/if} /> Nam
		    	<input class="radiogender" disabled="disabled" class="radiomb" name="fgender" type="radio" value="0" {if $formData.gender == 0}checked="checked"{/if}/> Nữ
               </div>
                <div class="btnedit"><a id="btngender" href="javascript:;"><i class="icon-edit"></i></a></div>
            </div>
            <div class="infoprofile">
            	<label>Địa chỉ:</label>
                <textarea id="textaddress" class="profileinput infotextarea" name="faddress" disabled="disabled" placeholder="Nhập địa chỉ">{$formData.address|@htmlspecialchars}</textarea>
                <div class="btnedit"><a id="btnadress" href="javascript:;"><i class="icon-edit"></i></a></div>
            </div>
            
             <div class="infoprofile">
            	<label>Tỉnh thành:</label>
               <select disabled="disabled" class="profileselect" name="fcity" id="fcity">
					<option value=''>----</option>
					{foreach $region as $key=>$value}
						<option value='{$key}' {if {$key}=={$formData.city}}selected{/if}>{$value}</option>
					{/foreach}
				</select>
                <div class="btnedit"><a id="btncity" id="btnadress" href="javascript:;"><i class="icon-edit"></i></a></div>
            </div>
            
            <div class="infoprofile">
            	<label>Quận huyện:</label>
            	 <select disabled="disabled" name="fdistrict" id="fdistrict"  class="profileselect">
                    {if $strdictrict!=''}
                        {$strdictrict}
                    {else}
                        <option value="">---Vui lòng chọn tỉnh thành trước---</option>
                    {/if}
                </select>
                
            </div>
            
            <!-- Đổi mật khẩu -->
                <h4>Đổi mật khẩu</h4>
          <form action="" method="post">    
          <div class='notifydiv'>{include file="notify.tpl" notifyError=$error notifySuccess=$success}</div>
            <div class="changepass">
                <input class="changeinput" name="fpass" type="password" placeholder="Mật khẩu hiện tại">
                <input class="changeinput" name="password1" type="password" placeholder="Mật khẩu mới">
                <input class="changeinput" name="password2" type="password" placeholder="Xác nhận mật khẩu mới">
                <input class="btnchange" value="Thay đổi" name="changepass" type="submit"></input>
            </div>
            </form>  
       </div>
    </section>
<!-- End content -->

{literal}
 <script type="text/javascript">
 var fullname = '';
 var phone = '';
 var address = '';
 var gender = '';
 var city = '';

 var district = '';
 $(document).ready(function () {

    
	 
	 
     $('#btnfullname').click(function () {
    	 $('.notifiprofile').html('');
    	if($('#textfullname').is(':disabled')){
    		 $('#textfullname').removeAttr("disabled");
    		 $('#textfullname').addClass("profileinputborder");
    		 $('#btnfullname').html('<i class="icon-save">');
    	}else{
    		fullname = $('#textfullname').val();
    		phone = '';
    		address = '';
    		gender = '';
    		city = '';
    		district = '';
    		updateprofile();
    		$('#btnfullname').html('<i class="icon-edit">');
    		$('#textfullname').attr("disabled", "disabled");
    		$('#textfullname').removeClass("profileinputborder");
        }
         
     });
     
     $('#btnphone').click(function () {
    	 $('.notifiprofile').html('');
         if($('#textphone').is(':disabled')){
        	 $('#textphone').removeAttr("disabled");
        	 $('#textphone').addClass("profileinputborder");
          	$('#btnphone').html('<i class="icon-save">');
     	 }else{
     		phone = $('#textphone').val();
     		fullname = '';
    		address = '';
    		gender = '';
    		city = '';
    		district = '';
     		updateprofile();
      		$('#btnphone').html('<i class="icon-edit">');
      		$('#textphone').attr("disabled", "disabled");
      		$('#textphone').removeClass("profileinputborder");
         }
     });
     $('#btngender').click(function () {
    	 $('.notifiprofile').html('');
    	 if($('.radiogender').is(':disabled')){
         	$('.radiogender').removeAttr("disabled");
         	$('#btngender').html('<i class="icon-save">');
    	 }else{
    		 phone = '';
    		 fullname = '';
     		 address = '';
     		 city = '';
     		district = '';
    		 if($('.radiogender').is(":checked") ){ // check if the radio is checked
    	      	 gender = $('.radiogender').val(); // retrieve the value
    	     }else{
    	      	 gender = 0;
    	    }
     		updateprofile();
      		$('#btngender').html('<i class="icon-edit">');
      		$('.radiogender').attr("disabled", "disabled");
         }
     });
     $('#btnadress').click(function () {
    	 $('.notifiprofile').html('');
         if($('#textaddress').is(':disabled')){
        	$('#textaddress').removeAttr("disabled");
        	$('#textaddress').addClass("profileinputborder");
        	$('#textaddress').addClass("height");
          	$('#btnadress').html('<i class="icon-save">');
     	 }else{
     		phone = '';
     		address = $('#textaddress').val();
     		fullname = '';
    		gender = '';
    		city = '';
    		district = '';
     		updateprofile();
      		$('#btnadress').html('<i class="icon-edit">');
      		$('#textaddress').attr("disabled", "disabled");
      		$('#textaddress').removeClass("profileinputborder");
      		$('#textaddress').removeClass("height");
      		
         }
     });

     $('#btncity').click(function () {
    	 $('.notifiprofile').html('');
         if($('#fcity').is(':disabled')){
        	 $('#fcity').removeAttr("disabled");
        	 $('#fcity').addClass("profileselectborder");
           	 $('#btncity').html('<i class="icon-save">');
      	 }else{
      		phone = '';
      		fullname = '';
    		address = '';
    		gender = '';
      		city = $('#fcity').val();
      		district = $('#fdistrict').val();
      		updateprofile();
       		$('#btncity').html('<i class="icon-edit">');
       		$('#fcity').attr("disabled", "disabled");
       		$('#fcity').removeClass("profileselectborder");
          }

         if($('#fdistrict').is(':disabled')){
        	 $('#fdistrict').removeAttr("disabled");
        	 $('#fdistrict').addClass("profileselectborder");
      	 }else{
       		$('#fdistrict').attr("disabled", "disabled");
       		$('#fdistrict').removeClass("profileselectborder");
          }
     });

     $('#btndistrict').click(function () {
         
        
     });

     $("#fcity").change(function(){
         var city     = $('#fcity').val();
         var url      = "/register/indexajax?city="+city;
         $.ajax({
             type : "POST",
             data : {action:"getdistrict"},
             url : url,
             dataType: "html",
             success: function(data){
                 $("#fdistrict").html(data);
             }
         });
     });
 	});
    function updateprofile(){

      var data = {
    		  action:"editprofile",
    		  ffullname : fullname,
    		  fphone : phone,
    		  faddress : address,
    		  fcity : city,
    		  fdistrict : district,
    		  fgender :gender
      }
      $('.notifiprofile').html('<span class="loading-gif"></span>');
      var url      = "/account/ajaxupdateprofile";
      $.ajax({
              type : "POST",
              data : data,
              url : url,
              dataType: "json",
              success: function(resp){
          			if(resp.error >= 0){
						$('.notifiprofile').html('<p class="success">'+ resp.data +'</p>');
						
              	    }else{
              	    	$('.notifiprofile').html('<p class="error">'+ resp.data +'</p>');
                  	}
              }
      });
		return true;
    }
 </script>
{/literal}