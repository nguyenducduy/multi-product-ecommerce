$(function() {
	
	$("#sharelink").colorbox({inline:true, width:"40%"});
	$("#thele").colorbox({inline:true, width:"70%"});
	
	var currentQuestion = $(".p3question #answesitem").length;
	if(currentQuestion > 0){
		var page = 1;
		var fpgid = $("#answesitem").attr("data-id");
		var url = rooturl+'product/loadquestion';
		$(".guessloading").css('display', 'block');
		var data  = {
				action:"loadquestion",
				page : page,
				fpgid:fpgid
		};
		
		$.ajax({
			type : "POST",
			data : data,
			url : url,
			dataType: "html",
			success: function(data){
				if(data != ''){
					$(".guessloading").css('display', 'none');
					$("#answesitem").html(data);
				}
			}
		});
		
	}
	
	var question = 2;
	var arrayanswer = new Array();
    $("body").on('click', '#next', function() {
    		var fpgid = $(this).attr("data-id");
    		var totalquestion = $(this).attr("rel");
            var answer = $( ".p3question input:checked" ).val();
            var answertext = $("#answertext").val();
            
	            if(answer == 'true'){
	            	if(question <= totalquestion){
		            	var url = rooturl+'product/nextquestion';
		            	$(".guessloading").css('display', 'block');
		            	var data  = {
		        				action:"nextquestion",
		        				question : question,
		        				fpgid:fpgid,
		        				totalquestion: totalquestion
		        		};
		        		$.ajax({
		        			type : "POST",
		        			data : data,
		        			url : url,
		        			dataType: "html",
		        			success: function(data){
		        				if(data != ''){
		        					$(".guessloading").css('display', 'none');
		        					question = question + 1;
		        					$("#answesitem").html(data);
		        				}
		        			}
		        		});
		            	
		            	$(".p3alert").text("");
	            	}else{
	            		var htmlinfo ='<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="http://dienmay.com/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>';
	                    htmlinfo +='<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><label class="p3alert alertfullname"></label><div class="clear"></div>';
	            		htmlinfo +='<input maxlength="15" id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><label  class="p3alert alertphone"></label><div class="clear"></div>';
	            		htmlinfo +='<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><label  class="p3alert alertemail"></label><div class="clear"></div>';
	            		htmlinfo +='<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><label  class="p3alert alertaddress"></label><div class="clear"></div>';
	            		htmlinfo +='<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>';
	            		htmlinfo +='<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" checked value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>';
	            		htmlinfo +='<div class="btn-step"><a data-id="' + fpgid + '" rel="' + answertext + '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>';
	            		htmlinfo +='<label class="loadinggif p3alert guessloading"></label>';
	            		$(".p3question").html(htmlinfo);
	            		$(".p3alert").text("");
	            		
	            	}
	            }else if(answer == 'false'){
	            	$(".p3alert").text("Ừm...có vẻ như bạn chọn chưa đúng.");
	            }else if(typeof(answer) == 'undefined' && typeof(answertext) == 'undefined'){
	            	$(".p3alert").text("Bạn chưa chọn câu trả lời");
	            }else{
	           
	            	
	            	if(isNaN(answertext)){
	            		
	            		$("#answertext").addClass('errorborder');
		            	$("#answertext").focus();
		            	$(".p3alert").text("Bạn chưa nhập số người");
	            	}else if(answertext != ''){
	            		if(question <= totalquestion){
	            			var url = rooturl+'product/nextquestion';
	    	            	$(".guessloading").css('display', 'block');
	    	            	var data  = {
	    	        				action:"nextquestion",
	    	        				question : question,
	    	        				fpgid:fpgid,
	    	        				totalquestion: totalquestion
	    	        		};
	    	        		$.ajax({
	    	        			type : "POST",
	    	        			data : data,
	    	        			url : url,
	    	        			dataType: "html",
	    	        			success: function(data){
	    	        				if(data != ''){
	    	        					$(".guessloading").css('display', 'none');
	    	        					question = question + 1;
	    	        					$("#answesitem").html(data);
	    	        				}
	    	        			}
	    	        		});
	    	            	
	    	            	$(".p3alert").text("");
	            		}else{
	            			
	            			var htmlinfo ='<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="http://dienmay.com/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>';
		                    htmlinfo +='<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><label class="p3alert alertfullname"></label><div class="clear"></div>';
		            		htmlinfo +='<input id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><label  class="p3alert alertphone"></label><div class="clear"></div>';
		            		htmlinfo +='<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><label  class="p3alert alertemail"></label><div class="clear"></div>';
		            		htmlinfo +='<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><label  class="p3alert alertaddress"></label><div class="clear"></div>';
		            		htmlinfo +='<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>';
		            		htmlinfo +='<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>';
		            		htmlinfo +='<div class="btn-step"><a data-id="' + fpgid + '" rel="' + answertext + '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>';
		            		htmlinfo +='<label class="loadinggif p3alert guessloading"></label>';
		            		$(".p3question").html(htmlinfo);
		            		$(".p3alert").text("");
	            		}
	            		
		            }else{
		            	$("#answertext").addClass('errorborder');
		            	$("#answertext").focus();
		            	$(".p3alert").text("Bạn chưa dự đoán số người trả lời giống bạn.");
		            }
	            }
            
        
     });
    
    $("body").on('click', '#confirm_info', function() {
		var fpgid = $(this).attr("data-id");
		var answertext = $(this).attr("rel");

        var ffullname = $("#ffullname").val();
        var femail = $("#femail").val();
        var fphone = $("#fphoneguess").val();
        var faddress = $("#faddress").val();
        
        
        var flag = true;
    	
       
        if(faddress == "" || faddress == null){
    		$("#faddress").addClass('errorborder');
    		$("#faddress").focus();
    		$(".alertaddress").text("Vui lòng nhập địa chỉ");
    		flag = false;
    	}
    	$( "#faddress" ).change(function() {
    		$("#faddress").removeClass('errorborder');
    		$(".alertaddress").text("");
    		flag = true;
    	});
        
        
        var atpos=femail.indexOf("@");
        var dotpos=femail.lastIndexOf(".");
    	if(atpos<1 || dotpos<atpos+2 || dotpos+2>=femail.length){
    		$("#femail").addClass('errorborder');
    		$("#femail").focus();
    		$(".alertemail").text("Email không đúng định dạng");
    		flag = false;
    	}
    	$( "#femail" ).change(function() {
    		$("#femail").removeClass('errorborder');
    		$(".alertemail").text("");
    		flag = true;
    	});
    	
    	 if(fphone.value == ""){
     		$("#fphoneguess").addClass('errorborder');
     		$("#fphoneguess").focus();
     		$(".alertphone").text("Vui lòng nhập số điện thoại");
     		flag = false;
     	}else if (isNaN(parseInt(fphone))) {
     		$("#fphoneguess").addClass('errorborder');
     		$("#fphoneguess").focus();
     		$(".alertphone").text("Số điện thoại không đúng");
     		flag = false;
     	}
     	$( "#fphoneguess" ).change(function() {
     		$("#fphoneguess").removeClass('errorborder');
     		$(".alertphone").text("");
     		flag = true;
     	});
    	
    	if(ffullname == "" || ffullname == null){
    		$("#ffullname").addClass('errorborder');
    		$("#ffullname").focus();
    		$(".alertfullname").text("Vui lòng nhập họ tên");
    		flag = false;
    	}
    	$( "#ffullname" ).change(function() {
    		$("#ffullname").removeClass('errorborder');
    		$(".alertfullname").text("");
    		flag = true;
    	});
    	
 
    	var fcheckproduct = $('#fcheckproduct:checked').val();
    	if(fcheckproduct == 'undefined'){fcheckproduct = 0;}
    	var fcheckfull = $('#fcheckfull:checked').val();
    	if(fcheckfull == 'undefined'){fcheckfull = 0;}
        if(flag == true){
        	var url = rooturl+'product/saveinfoguess';
        	$(".guessloading").css('display', 'block');
        	var data  = {
    				action:"saveinfoguess",
    				ffullname : ffullname,
    				femail: femail,
    				fphone: fphone,
    				faddress: faddress,
    				fnewsletterproduct: fcheckproduct,
    				newsletter: fcheckfull,
    				fpgid:fpgid,
    				fanswer:answertext
    		};
    		$.ajax({
    			type : "POST",
    			data : data,
    			url : url,
    			dataType: "json",
    			success: function(data){
    				if(data.error == 0){
    					$(".guessloading").css('display', 'none');
    					$(".p3question").html(data.html);
    				}else if(data.error == -2){
    					$(".guessloading").css('display', 'none');
    					$(".p3question").html(data.html);
    				}
    			}
    		});
        	
        	$(".p3alert").text("");
        }
    
 });
    
	
	$( "#autosearchtextbrand" ).keyup(function() {
		 var value = $(this).val();
	
			 $('.textbrand li a').each(function(){
			
					
			       var myText = $(this).text();
				       if (myText.toLowerCase().indexOf(''+value+'') >= 0 || myText.indexOf(''+value+'') >= 0){
				       		
				    	   $(this).parent().css('display','block');
				       }else{
					       
							$(this).parent().css('display','none');
					   }
				 

			    });

	});
	//tab combo - phụ kiện
	$('ul.parenttabs').each(function(){
			
            var $active, $content, $links = $(this).find('a');
			
            $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
            $active.addClass('active');
            $content = $($active.attr('href'));
 
            $links.not($active).each(function () {
                $($(this).attr('href')).hide();
            });
 
            $(this).on('click', 'a', function(e){
				
                $active.removeClass('active');
                $content.hide();
 
                $active = $(this);
                $content = $($(this).attr('href'));
 
                $active.addClass('active');
                $content.show();
 
                e.preventDefault();
            });
        });
   
    $("body").on('click', '.campaign_autumn', function() {
            var pid = $(this).attr('rel');
            if(pid)
            {
                var url = rooturl+'subscriber/subcampainautumn'+'?id='+pid;
                
                if(document.readyState === "complete"){ Shadowbox.open({content:url,player:"iframe",options:{modal:true},title:'Rước đèn cùng dienmay.com',height:200,width:600});}
                else alert('Đang xử lý....');
                
                $( "#sb-body" ).addClass( "lanter-body" );
            }
            return false;
     });
    
    var mobileurl = 'http://m.dienmay.com';
    /////////////////////////////////////END DIEN MAY COMMENT ////////////////////////////////////////
    $('.forcedesktop').click(function(){
        deleteCookie('forcedesktop');
        window.location.href= mobileurl;
    })

    function deleteCookie(c_name) {
      document.cookie = encodeURIComponent(c_name) + "=deleted; expires=" + new Date(0).toUTCString();
    }
    
    
    // Script game yeu tinh
    $("body").on('click', '#startgame', function() {

    	var token = $('#questiontoken').val();
	    var currentQuestion = $(".wrapyt_ask_bar .wrapyt_ask").length;
		if(currentQuestion <= 0){
			$(".wrapyt_ask_bar").html('<div class="gameloading"></div>');
			var page = 1;
			var fgfeid = $(this).attr("rel");
			var url = rooturl+'gamefasteye/loadquestion';
			var data  = {
					action:"loadquestion",
					page : page,
					fgfeid:fgfeid,
					token: token
			};
			
			$.ajax({
				type : "POST",
				data : data,
				url : url,
				dataType: "json",
				success: function(data){
					if(data.html != ''){
						//alert(JSON.stringify(data));
						$(".wrapyt_ask_bar").html(data.html);
						$('#questiontoken').val(data.token);
						var time = data.time;
						var a = time.split(':');
						countdowntimer(a[1], a[2]);
						$('html,body').animate({ scrollTop: 760 }, 'slow', function () {});
					}
				}
			});
			
		}
    });
	
	
	var count = 0;

	function pad2(n) {
	    return n < 10 ? '0' + n : n;
	}

	function show() {
	    var s = count % 60;
	    var m = Math.floor(count / 60);
	    var out = '';
	    out = pad2(m) + ":" + pad2(s);
	    if($(".wrapyt_ask_bar .yt_time").length > 0) {
	    	document.getElementById('yt_time').innerHTML=out;
	    }
	}

	function timer() {
	    show();
	    if (count-- > 0) {
	        setTimeout(timer, 1000);
	    }else{
	    	if ($(".wrapyt_ask_bar .point_yt").length <=0){
	    		var token = $('#questiontoken').val();
		    	var url = rooturl+'gamefasteye/greeting';
		    	var data  = {
						action:"greeting",
						token: token
				};
				$.ajax({
					type : "POST",
					data : data,
					url : url,
					dataType: "html",
					success: function(data){
						if (data != 0) {
							$(".wrapyt_ask").html(data);
						}
					}
				});
	    	}
	    }
	}

	function countdowntimer(mns, scs) {
		var s = parseInt(scs, 10);
	    var m = parseInt(mns, 10);

	    if (isNaN(s) || isNaN(m)) return;
	    scs.value = s;
	    mns.value = m;

	    var current = count;
	    count += (m * 60) + s;
	    
	    if (current <= 0) {
	    	timer();
	    } else {
	        show();
	    }
	}
	
	function millisecondsToTime(milli) {
	      var milliseconds = milli % 1000;
	      var seconds = Math.floor((milli / 1000) % 60);
	      var minutes = Math.floor((milli / (60 * 1000)) % 60);

	      return minutes + ":" + seconds + "." + milliseconds;
	}
	
	
	 $("body").on('click', '#nextquestion', function() {
		var token = $('#questiontoken').val();
 		var fgefid = $(this).attr("data-id");
 		var page = $(this).attr("rel");
 		var currentquestion = $(this).attr("data-action");
        var answer = $( ".option_yt input:checked" ).val();
        if (answer > 0) {
	    	var url = rooturl+'gamefasteye/nextquestion';
	    	var data  = {
					action:"nextquestion",
					page : page,
					fgefid : fgefid,
					answer: answer,
					currentquestion: currentquestion,
					token: token
			};
			$.ajax({
				type : "POST",
				data : data,
				url : url,
				dataType: "json",
				success: function(resp){
					if (resp.error == 0) {
						$(".yt_ask").html('<span>Câu hỏi '+ resp.page + '</span>');
						$("#contentquestion").html(resp.contentquestion);
						$('#questiontoken').val(resp.token);
					}else if (resp.error == 2) {
						if ($(".wrapyt_ask_bar .point_yt").length <=0 ) {
							var url = rooturl+'gamefasteye/greeting';
					    	var data  = {
									action:"greeting",
									token: token
							};
							$.ajax({
								type : "POST",
								data : data,
								url : url,
								dataType: "html",
								success: function(data){
									if (data != 0) {
										$(".wrapyt_ask").html(data);		
									}
								}
							});
						}
					}
				}
			});
        }else {
        	$( ".error" ).text( 'Bạn chưa chọn câu trả lời' );
        }
     
  });
    
    
});



function processsubscriber()
{
	var rooturl_processsubscriber = rooturl + "subscriber/processsubscriber";
	$("#btndksubscriber").html('Đang lưu');
	$("#btndksubscriber").attr("disabled","disabled");
	var name = $('#ffullname').val();
	var email = $('#femail').val();
	var flag = true;
	
	if(email == ''){
		$("#femail").addClass('errorborder');
		$("#femail").focus();
		flag = false;
	}
	$( "#femail" ).change(function() {
		$("#femail").removeClass('errorborder');
	});
	if(name == ''){
		$("#ffullname").addClass('errorborder');
		$("#ffullname").focus();
		flag = false;
	}
	$( "#ffullname" ).change(function() {
		$("#ffullname").removeClass('errorborder');
	});
	
	$('#agreesubrcriber').click(function(){
		$(this).removeClass('errorborder');
		$(".agreeerror").text('');
	});
	if($('#agreesubrcriber').is(":checked")){
		$('#agreesubrcriber').removeClass('errorborder');
		$(".agreeerror").text('');
	}else{
		$("#agreesubrcriber").addClass('errorborder');
		$(".agreeerror").attr('style','color: red');
		$(".agreeerror").text('Bạn chưa đồng ý với điều khoản của dienmay.com');
		flag = false;
	}

	var gender = $('.gender:checked').val();

	if(!gender){
		$(".gender").addClass('errorborder');
		flag = false;
	}
	if(flag == true){
		var data  = {
				action:"processsubscriber",
				ffullname : name,
				femail:email,
				gender: gender
		};
		$.ajax({
			type : "POST",
			data : data,
			url : rooturl_processsubscriber,
			dataType: "html",
			success: function(data){
				if(data=='ok'){
					$("#btndksubscriber").html('Thành công');
					$(".consultinghome").html('<p>"Cảm ơn bạn ký đã đăng ký nhận tin từ dienmay. Bạn hãy kiểm tra hộp thư vừa đăng ký để xác nhận rằng bạn sở hữu email này. <br><br>(Vui lòng kiểm tra trong hộp thư rác nếu bạn không thấy email, hoặc liên hệ với bộ phận CSKH của dienmay qua hotline 1900 1883)"</p>');
				}
				if(data=='ext')
				{
					$("#btndksubscriber").html('Emai này đã đăng ký');
					$('#email').addClass('errorborder');
					setTimeout(function(){
						$("#btndksubscriber").html('Đăng ký');
						$("#btndksubscriber").removeAttr('disabled');
					}, 5000);
				}
				if(data=='err')
				{
					$('#ffullname').removeClass('errorborder');
					$("#btndksubscriber").html('Email không đúng');
					$('#femail').addClass('errorborder');
					setTimeout(function(){
						$("#btndksubscriber").removeAttr('disabled');
						$("#btndksubscriber").html('Đăng ký');
					}, 5000);
				}
			}
		});

	}else{
		$("#btndksubscriber").html('Đăng ký');
		$("#btndksubscriber").removeAttr('disabled');
	}
}

function processSms(){
	var rooturl_processSms = rooturl + "register/processsms";
	var phone = $('#fphone').val();
	var flag = true;
	if(phone == ''){
		$("#fphone").addClass('errorborder');
		flag = false;
		$("#fphone").focus();
	}
	$( "#fphone" ).change(function() {
		$("#fphone").removeClass('errorborder');
	});
	
}

function ajaxcartlogin()
{
	var rooturl_ajaxcartlogin = rooturl + "login/ajaxcartlogin";
	
	var fuser = $('#fuser').val();
	var fpassword = $('#fpassword').val();
	var action = $('#action').val();
	var flag = true;
	if(fpassword == ''){
		$("#fpassword").addClass('errorborder');
		$("#fpassword").focus();
		flag = false;
	}
	$( "#fpassword" ).change(function() {
		$("#fpassword").removeClass('errorborder');
		flag = true;
	});
	if(fuser == ''){
		$("#fuser").addClass('errorborder');
		$("#fuser").focus();
		flag = false;
	}
	$( "#fuser" ).change(function() {
		$("#fuser").removeClass('errorborder');
		flag = true;
	});
	

	if(flag == true){
		$("#btncartlogin").val('Vui lòng chờ');
		$("#btncartlogin").attr("disabled","disabled");
		var data  = {
				action:"login",
				fuser : fuser,
				fpassword:fpassword
		};
		$.ajax({
			type : "POST",
			data : data,
			url : rooturl_ajaxcartlogin,
			dataType: "json",
			success: function(resp){
			
				if(resp.error == 0){
					document.location.href= rooturl + 'cart/checkout';
				}else{
					var str = resp.data;
					$(".loginresult").text('' + str + '');
					$("#btncartlogin").val('Đăng nhập');
					$("#btncartlogin").removeAttr('disabled');
				}
			}
		});

	}

}

function addproductbookmark(){
	var rooturl_productbookmark = rooturl + "product/addproductbookmark";
	var fpid = $("#addproductbookmark").attr('rel');
	var fbarcode = $("#addproductbookmark").attr('data-barcode');
	var data  = {
		fpid : fpid,
		fbarcode: fbarcode
	};
	$.ajax({
		type : "POST",
		data : data,
		url : rooturl_productbookmark,
		dataType: "json",
		success: function(resp){
		var html = '<div class="popuplogin"><p class="title">Thông báo</p> <div class="popuplogin-bar">' + resp.data + '</div></div>';
			if(resp.error == 0){
				$(".productbookmark").html('<i class="icon-heartdisable"></i>Tôi thích sản phẩm này');
				
				Shadowbox.open({
	                content:   html,
	                title :     'Thông báo',
	                player:     "html",
	                width : 500,
	                height: 110
	            });
			}else if(resp.error == 2){	
				$(".productbookmark").html('<i class="icon-heartdisable"></i>Tôi thích sản phẩm này');
				
				Shadowbox.open({
	                content:   html,
	                title :     'Thông báo',
	                player:     "html",
	                width : 500,
	                height: 90
	            });
			}else{
				
				Shadowbox.open({
	                content:    rooturl + 'login/popuplogin?productid=' + $("#addproductbookmark").attr('rel') + '&barcode=' + $("#addproductbookmark").attr('data-barcode'),
	                title :     'Đăng nhập ',
	                player:     "iframe",
	                width : 500,
	                height: 250
	            });
			}
			
		}
	});
}

function ajaxcartregister(){
	var flag = true;
	var fpassword = $("#fpassword").val();
	if(fpassword == ''){
		$("#fpassword").addClass('errorborder');
		$("#fpassword").focus();
		flag = false;
	}
	$( "#fpassword" ).change(function() {
		$("#fpassword").removeClass('errorborder');
		flag = true;
	});
	if(flag == true){
		var rooturl_ajaxcartregister = rooturl + "login/ajaxcartregister";
		var ffullname = $("#ffullname").val();
		var femail = $("#femail").val();
		var fphone = $("#fphone").val();
		var faddress = $("#faddress").val();
		var fprovince = $("#fprovince").val();
		var fdistrict = $("#fdistrict").val();
		var fpassword = $("#fpassword").val();
		var data  = {
			ffullname : ffullname,
			femail: femail,
			fphone: fphone,
			faddress: faddress,
			fprovince: fprovince,
			fdistrict: fdistrict,
			action: 'register',
			fpassword: fpassword
		};
		$(".notifycartregister").html('<span style="margin-top: 4px;" class="loading-gif"></span>');
		$.ajax({
			type : "POST",
			data : data,
			url : rooturl_ajaxcartregister,
			dataType: "json",
			success: function(resp){
				if(resp.error == 0){
					$(".notifycartregister").html('<span>'+ resp.data +'</span>');
					$("#cartregister").attr("disabled","disabled");
				}else if(resp.error == -2){	
					$(".notifycartregister").html('<span>'+ resp.data +'</span>');
				}else if(resp.error == '-3'){
					$(".box-register").remove();
					$(".box-registedphone").attr("style","display:block;margin-top:90px");
				}else if(resp.error == '-4'){
					$(".box-register").remove();
					$(".box-registedemail").attr("style","display:block;margin-top:90px");
				}
				
			}
		});
	}
}

function geturl(query){
    query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var expr = "[\\?&]"+query+"=([^&#]*)";
    var regex = new RegExp( expr );
    var results = regex.exec( window.location.href );
    if( results !== null ) {
        return results[1];
        //return decodeURIComponent(results[1].replace(/\+/g, " "));
    } else {
        return false;
    }
}

function detectprice(urlroot){
	var host = window.location.host;
	var pricecustom = '';
	var pricefrom = $("#pricefrom").val();
	var priceto = $("#priceto").val();

	if(parseFloat(pricefrom) < parseFloat(priceto) ){
	

		if(pricefrom != ''){
			pricecustom += 'pricefrom='+pricefrom + '000';
		}else{
			pricecustom += 'pricefrom=0';
		}

		if(priceto != ''){
			pricecustom += '&priceto='+priceto + '000';
		}
		

		var vendor = geturl('vendor');
		var a = geturl('a');

		var aurl = '';
		if(a){
			var b = a.split(',');
			var count = b.length;
			var pass=true;
			
			for(i=0; i<count; i++){
				if(b[i] =='gia'){
					pass=false;
				}
				if(pass==true){
					aurl+=b[i]+',';
				}
			}
			var strLen = aurl.length;
			aurl = aurl.slice(0,strLen-1);
			//alert(JSON.stringify(b));
		}
		
		if(vendor){
			urlroot = urlroot + '?vendor=' + vendor ;
			if(aurl != '')
				urlroot += '&a=' + aurl;
			urlroot += '&'+pricecustom;
		}else{
			if(aurl !=''){
				urlroot += '?a='+aurl+'&'+pricecustom;
			}else{urlroot +='?'+pricecustom;}
		}
		window.location.href = urlroot;
		
	}else{
		$("#pricenotify").text('Chọn giá không hợp lệ');
	}
	
}

function showpopupuserguess(id)
{
	Shadowbox.open({
        content:    rooturl + 'site/product/showpopupusergues/id/' + id,
        player:     "iframe",
        options: {
                       modal:   true
        },
        height:     500,
        width:      800
    });R
}

function showpopuptruleguess(id)
{
	Shadowbox.open({
        content:    rooturl + 'site/product/showrulepopupgues/id/' + id,
        player:     "iframe",
        title: "Thể lệ",
        options: {
                       modal:   true
        },
        height:     500,
        width:      800
    });
}

function loaduserguess(pgid){
	var fpgid = $("#answesitem").attr("data-id");
	var url = rooturl+'product/loaduserguess';
	//$(".guessloading").css('display', 'block');
	var data  = {
			action:"loaduserguess",
			fpgid:fpgid
	};
	
	$.ajax({
		type : "POST",
		data : data,
		url : url,
		dataType: "html",
		success: function(data){
			if(data != ''){
				//$(".guessloading").css('display', 'none');
				$(".listorder ul").html(data);
			}
		}
	});
	
}