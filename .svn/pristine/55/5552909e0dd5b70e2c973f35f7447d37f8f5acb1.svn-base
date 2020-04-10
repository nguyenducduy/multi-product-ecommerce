$(document).ready(function(){
    if($('#myregion').length >0)
    {
        $('#myregion').unbind('change').change(function(){ 
            if($(this).parent().attr('class')=='formcheckout') {
                $(this).parent().submit();
            }
            else if($(this).parent().parent().attr('class')=='formcheckout') {
                $(this).parent().parent().submit();
            }
        });
    }
    
    if($('.submitform').length > 0)
    {
        $('.submitform').unbind('click').click(function(){
            var rt = true;
            var errMsg = 'Vui lòng nhập đầy đủ giới tính, họ tên, số điện thoại,...';
            var valRegExp = new RegExp("^[0-9]"); 
            $('.required').each(function(){
                if($(this).val() == '') {
                    rt = false;
                    $(this).addClass('errorinput');
                }
                else{
                    if ($(this).attr('name') == 'fgender' && parseInt($(this).val()) < 0)
                    {
						rt = false;
						errMsg = 'Vui lòng chọn giới tính';
                    	$(this).addClass('errorinput');
                    }
                    else if ($(this).attr('name') == 'fphonenumber' && valRegExp.test($(this).val()) == false)
                    {
						rt = false;
                    	$(this).addClass('errorinput');
                    	errMsg = 'Số điện thoại không hợp lệ';
                    }
                    else $(this).removeClass('errorinput');                    
                }
                
            });
            if( rt )
            {
                if ($('.email').length > 0)
                {
					$('.email').each(function(){
                		var filtermail = new RegExp(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
                		if($(this).val() != '' && filtermail.test($(this).val())==false) {
	                        rt = false;
	                        errMsg = 'Email không hợp lệ';
	                        $(this).addClass('errorinput');
	                    }
	                    else{
	                        $(this).removeClass('errorinput');
	                    }                
	                });
                }                
            }
            if($('input[name=fpaymentmethod]').length > 0){
                if($('input[name=fpaymentmethod]').is(':checked')==false) {
                    rt  = false;
                    //$('#paymentmethodtext').addClass('errorinput');
                }
                else {
                    //$('#paymentmethodtext').removeClass('errorinput');
                }
            }
            if($('input[name=ftransfer]').length > 0){
                if($('input[name=ftransfer]').is(':checked')==false) {
                    rt  = false;
                    //$('#deliverymethodtext').addClass('errorinput');
                }
                else {
                    //$('#deliverymethodtext').removeClass('errorinput');
                }
            }
            
            if(rt==false) nalert(errMsg, 'Chú ý');
            return rt;
        });
    }
    
    if($('.cartquantity').length >0)
    {
        $('.cartquantity').unbind('change').change(function(){
            $.post(rooturl+'cart/update',$('#checkoutform').serialize(),function(){
                window.location.href = rooturl+'cart/checkout';
            });
        });
    }
    //if($('.wrap-advice').length > 0)
    if($('.cartquantity2').length >0)
    {
        $('.cartquantity2').unbind('change').change(function(){
            $.post(rooturl+'cart/update',$('#checkoutform').serialize(),function(){
                window.location.href = rooturl+'cart';
            });
        });
    }
//    {alert($('#wrap-advice ul li').width());
//        $('.wrap-advice ul').css('width',$('#wrap-advice ul').width());
//    }
    
    if($('.qb-left-sp li .deleted a').length > 0)
    {
        $('.qb-left-sp li .deleted a').unbind('click').click(function(){
            var curobj = $(this);
            var i = parseInt(curobj.attr('id'));            
            if(i > 0){
                $.post(rooturl + 'cart/deletecartitem', {deleteid: i}, function(data){
                    if(data && data.success && data.cartpricetotal){
                        curobj.parent().parent().remove();
                        $('.totalqb').html('<span>Tổng tiền:</span> '+data.cartpricetotal+' đ');
                    }
                    else parent.location.reload();
                },'json');
                return false;
            }
        });
    }
    
    if ($('.associateproduct').length > 0)
    {
		$('.associateproduct').unbind('click').click(function(){
            var link = rooturl+'cart/';
            if($(this).attr('rel') != "")
                link += 'mua-'+$(this).attr('rel');
            else
                link += 'checkout?id='+$(this).val();
			window.location.href = link;
		});
    }
});

function checkEmail(str){
    var filter = new RegExp(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return filter.test(str);
}

function is_url(str){    
    var reg = new RegExp(/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/);
    if(reg.test(str)){    
        return true;
    }    
    return false;
} 

function maskInput(event) {
   if(event.shiftKey)
        event.preventDefault();
     if (event.keyCode == 46 || event.keyCode == 8) {
   }
   else {
        if (event.keyCode < 95) {
          
          if (event.keyCode < 48 || event.keyCode > 57) {
              if (event.keyCode >= 37 && event.keyCode <= 40) {  
               }
              else
              {
                event.preventDefault();
              }
          }
        }
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
              }
        }
      }
}