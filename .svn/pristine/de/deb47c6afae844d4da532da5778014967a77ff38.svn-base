 $(document).ready(function()
{    
    $('.m-carousel').carousel();    
    // dropdown
    $('.m-accordion').accordion();
    // touch swipe
   
    // fixed top
    /*var stickyNavTop = $('.search').offset().top;
        var stickyNav = function(){
            var scrollTop = $(window).scrollTop();
               if (scrollTop > stickyNavTop) { 
                  $('.search').addClass('sticky');
               } else {
                   $('.search').removeClass('sticky'); 
               }
            };
            stickyNav();
            $(window).scroll(function() {
                stickyNav();
       });*/
    //Gia 
      var isShowSearch = false;
      var oldScrollSearch = 0;
      var newScollSearch = 0;
      setTimeout(function(){
          oldScrollSearch = $(window).scrollTop();
      }, 100);
      $(window).scroll(function(){
          newScrollSearch = $(window).scrollTop();
          if(newScrollSearch  < oldScrollSearch)
          {
              isShowSearch = true;
          }
          else
          {
              isShowSearch = false;
          }
          oldScrollSearch = newScrollSearch;
          if(isShowSearch){
              if(newScrollSearch < 37)
              {
                  $('.search').removeClass('sticky'); 
              }
              else
              {
                $('.search').addClass('sticky');
                  
              }
          }
          else
          {
             $('.search').removeClass('sticky'); 
          }
      });
    if (typeof ispriceajax !== 'undefined' && ispriceajax == 1 && $('.loadprice').length > 0)
    {
    var str20first = '';
    var str30next = '';
    var str50last = '';
    $('.loadprice').each(function(ix){
      
      if (ix < 20)
      {
        if ($(this).attr('rel'))
        {
          if (str20first != '') str20first += ',' + $(this).attr('rel');
          else str20first += $(this).attr('rel');
        }       
      }
      else if (ix > 19 && ix < 50)
      {
        if ($(this).attr('rel'))
        {
          if (str30next != '') str30next += ',' + $(this).attr('rel');
          else str30next += $(this).attr('rel');
        }
      }
      else if (ix > 49)
      {
        if ($(this).attr('rel'))
        {
          if (str50last != '') str50last += ',' + $(this).attr('rel');
          else str50last += $(this).attr('rel');
        }
      }
    });
    if (str20first !='')
    {
      $.ajax({
           type: "POST",
           dataType: 'json',
           data: {id: str20first},
           url: rooturl + 'site/price',
           error: function(){
           },
           success: function(datajs){
              if (datajs && datajs.data)
              {
                $.each(datajs.data,function(i){
                    var objassign = $('.lp' + datajs.data[i].id);
                    if (objassign.find('.pricenew').length > 0)
                    {
                      objassign.find('.pricenew').html(datajs.data[i].discount + ' đ');
                      var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                      if(percent > 0 && percent<100){
                          objassign.find('span.persale').html(percent+'%');
                      }
                    }
                    if (objassign.find('.priceold').length > 0)
                    {
                      objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
                    }
                    else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
                    {
                      objassign.find('div.pricenew').before('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
                      var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                      if(percent > 0 && percent<100){
                         
                          objassign.find('span.persale').html(percent+'%');
                      }
                    }
                });
            if (str30next !='')
            {
              $.ajax({
                   type: "POST",
                   dataType: 'json',
                   data: {id: str30next},
                   url: rooturl + 'site/price',
                   error: function(){
                   },
                   success: function(datajs){
                  if (datajs && datajs.data)
                  {
                    $.each(datajs.data,function(i){
                      var objassign = $('.lp' + datajs.data[i].id);
                      if (objassign.find('.pricenew').length > 0)
                      {
                        objassign.find('.pricenew').html(datajs.data[i].discount + ' đ');
                        var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                        if(percent > 0 && percent<100){
                            objassign.find('span.persale').html(percent+'%');
                        }
                      }
                      if (objassign.find('.priceold').length > 0)
                      {
                        objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
                      }
                      else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
                      {
                        objassign.find('div.pricenew').before('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
                        var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                        if(percent > 0 && percent<100)
                            objassign.find('span.persale').html(percent+'%');
                      }
                    });
                    if (str50last !='')
                    {
                      $.ajax({
                           type: "POST",
                           dataType: 'json',
                           data: {id: str50last},
                           url: rooturl + 'site/price',
                           error: function(){
                           },
                           success: function(datajs){
                          if (datajs && datajs.data)
                          {
                            $.each(datajs.data,function(i){
                              var objassign = $('.lp' + datajs.data[i].id);
                              if (objassign.find('.pricenew').length > 0)
                              {
                                objassign.find('.pricenew').html(datajs.data[i].discount + ' đ');
                                var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                                if(percent > 0 && percent<100){
                                    objassign.find('span.persale').html(percent+'%');
                                }
                              }
                              if (objassign.find('.priceold').length > 0)
                              {
                                objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
                              }                             
                              else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
                              {
                                objassign.find('div.pricenew').before('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
                                var percent = Math.floor((parseFloat(datajs.data[i].discount)-parseFloat(datajs.data[i].sell))*100/parseFloat(datajs.data[i].sell)); 
                                if(percent > 0 && percent<100)
                                    objassign.find('span.persale').html(percent+'%');
                              }
                            });
                          }
                         }
                      });
                    }
                  }
                 }
              });
            }
          }
         }
      });
    }
    }
    
    /////////////////////////////////////Khuyen mai///////////////////////////////////////////////////
    if($('#loadpromotionlist').length > 0 && pid)
    {
      $.post(rooturl + 'product/loadpromotionajax', {pid: pid}, function(data){
        if (data && data.success == 1 && data.blockhtml)
        {
          $('#loadpromotionlist').css('display', 'block');
          $('#loadpromotionlist').html(data.blockhtml);
          $('.giftids').before('<div class="promolabel">Khuyến mãi:</div>');
          var firstpromoobj;
              if($('.activefirst').length > 0) firstpromoobj = $('.activefirst');
              else{
                firstpromoobj = $('.promotions').first();
                if (firstpromoobj.parent().css('display') == 'none')
                {
              $('.promotions').each(function(){
                if($(this).parent().css('display') != 'none')
                {
                  firstpromoobj = $(this);
                  return;
                }
              });
                }
            
              }
              if(firstpromoobj && $('.promotions').length == 1 &&  firstpromoobj.parent().css('display') == 'none')
              {
            $('.areapricegift .areagift').css('display', 'none');
              }
              else if ($('.promotions').length == 1 && !firstpromoobj)
              {
            $('.areapricegift .areagift').css('display', 'none');
            firstpromoobj = $('.promotions').first();
              }
              if(firstpromoobj && firstpromoobj.val() != '') {
                firstpromoobj.attr('checked', 'checked');
                processpromotion(firstpromoobj.val());      
              }
        }else{
        	if($('.infogift_pre').length > 0){
        		$('.bar_pre_center').css('display','none');
        		$('.giftpromo_pre').css('padding', '0px');
        	}
        }
      }, 'json');
    }
    ///////////////////////////////////////LOAD GIO HANG /////////////////////////////////////////////////

    $.ajax({
        type : "POST",
        data : {url:$(location).attr('href')},
        url : rooturl + 'index/initxajax',
        dataType: "xml",
        success: function(data){
            if ($(data).find('logindata').length > 0)
            {
            $("#loginform").html($(data).find('logindata').text());
            $('#myregionlogin').bind('change',function(){
                    $(this).parent().attr('action',$(location).attr('href'));
                    $(this).parent().submit();
                });
            }
            else if ($(data).find('loginlink').length > 0)
            {
              $("#loginBanner").attr("action", rooturl+'login/index/redirect/'+$(data).find('loginlink').text());
              $("#linklogin").attr("href", rooturl+'thanh-vien/dang-ky/redirect/'+$(data).find('loginlink').text());
            }
            if ($(data).find('cartcontent').length > 0)
            {
              var numbercart = $(data).find('cartcontent').text();
              $('.cart-info-hd').html(numbercart);
              $('.numbercartnewfooter').html($('.cart-info-hd').find('.numbercartnew').text());
              $('.numbercartnewinfo').html($('.cart-info-hd').find('.numbercartnew').text().replace("(", "").replace(")",""));
            }
            if ($(data).find('initfunction').length > 0)
            {
              if ($(data).find('initfunction').text() == 1)
              {
                initinternalbar();
              }
            }
        }
    });

    //////////////////////////////////////END LOAD GIO HANG //////////////////////////////////////////////

    ///////////////////////////////////////CHECK OUT SELECT QUANTITY//////////////////////////////////////
    if($('.cartquantity').length >0)
    {
        $('.cartquantity').unbind('change').change(function(){
            $.post(rooturl+'cart/updatecartmobile',$('#checkoutform').serialize(),function(){
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
    ///////////////////////////////////////END CHECK OUT SELECT QUANTITY//////////////////////////////////
    $('.notify-bar-button a').unbind('click').click(function(){
        $(this).parent().parent().hide();
    })

    //=======================================CART========================================================
    });  
    ////////////////////////////////////PROCESSPROMOTION//////////////////////////////////////////////////
    function processpromotion(r)
    {
      var ids = '';
      if($('.giftids').length > 0)
      {
        $('.giftids').each(function(){
          ids += $(this).attr('id')+',';
        });
      }
      $.post(rooturl+'product/promotionajax',{id: r, ids: ids},function(data){
            if(data && data.block && data.id && data.urlbuynow)
            {
                /*if(data.fpromotion  && data.fpromotion != '0' && data.fpromotion != '')
                {
                    nnotice('Bạn đã chọn khuyến mãi khác nên giá sản phẩm có thể thay đổi', 'Chú ý');
                    //$('#pricedienmay').html(data.fpromotion+' <span class="vnd">VNĐ</span> <span id="promotiontop">(<strike>'+data.fprice+'</strike>)</span><i class="icon-bton"></i>');
                    //$('.areaprice').preappend();
                    //$('.areaprice .dienmay .pricedienmay span').html(data.fprice+' đ');
                    $('.areapricegift .areaprice').html(data.block);
                }
                else if(data.fpromotion == 0 || data.fpromotion == '')
                {
                    //if($('#pricedienmay #promotiontop strike').length > 0) nnotice('Bạn đã chọn khuyến mãi khác nên giá sản phẩm có thể thay đổi', 'Chú ý');
                    //$('#pricedienmay').html(data.fprice+' <span class="vnd">VNĐ</span> <span>(Giá tốt nhất)</span><i class="icon-bton"></i>');
                    //$('.dienmay .pricedienmay span').html(data.fprice+' đ');
                    $('.areapricegift .areaprice').html(data.block);
                }*/
                //$('div.infopromo').html(data.block);
                $('.areapricegift .areaprice').html(data.block);
                if($('.buyprepaid').length > 0 ) {
              if(data.prid) $('.buyprepaid').attr('id',data.prid);
            $('.buyprepaid').attr('rel',data.id);
                }
                else if($('#buyonline').length > 0) $('#buyonline').attr('href', data.urlbuynow);
                else if($('#buystore').length > 0) $('#buystore').attr('href', data.urlbuynow+'&s=1');
            }
        },'json');
    }

    ////////////////////////////////////END PROCESSPROMOTION /////////////////////////////////////////////
    /////////////////////////////////////End khuyen mai/////////////////////////////////////////////////
    /////////////////////////////////////DIEN MAY COMMENT ////////////////////////////////////////////
    function  loadReview(id , order)
    {
      $.ajax({
        type : "post",
        dataType : "html",
        url : "/site/productreview/indexajax",
        data : "id=" +id + "&order="+order,
        success : function(html){
          $('#comment').html(html);
          var countcomment = parseInt($('.countcomment span b').html()) > 0 ? '('+$('.countcomment span b').html()+')' :'';
          if(countcomment != "" || countcomment != null)
            $('.totalcomm a span').html( countcomment );
          if($('.commentnumber').length > 0){
          $('.commentnumber').each(function(){
            $(this).find('span').html($('#productreviewtotal').val());
              });
          }
          $('.writepost').limit(1000 , "#contentcounter");
          $('.writepostreply').limit(1000 , ".countercontentdata");
        }
      });
    }
    
    function loadpageReview(id , order)
    {

      $.ajax({
        type : "post",
        dataType : "html",
        url : "/site/pagereview/indexajax",
        data : "id=" +id + "&order="+order,
        success : function(html){
          $('#comments').html(html);
        }
      });
    }
    var page = 1;
    function  loadmoreReview(id)
    {
        $('.viewallproducts a').append('<span class="loading-gif"></span>');
        page++;
        $.ajax({
          type : "post",
          dataType : "html",
          url : "/site/productreview/loadmore",
          data : "id=" +id + "&page="+page,
          success : function(html){
              if(html != "")
              {
                $('.infocoms > ul > li:last-child').after(html);
                $('.loading-gif').remove();
              }
              else
              {
                $('.viewallproducts').remove();
              }
          }
        });
    }

    /////////////////////////////////////////////////////SEND REVIEW ////////////////////////////////////////
    function sendReview(id , parentid , check , reply)
    {
        //check = 0 -> chua dang nhap ,
        //check =1 ->da dang nhap
        //check 2 -> hien popup nhap
        $('.combtn a').append('<span class="loading-gif" style="position: absolute;top: 13px;left: -39px;"></span>');
        var parentobj = parent;
        parent = parentid;

        var name = $('#reviewfullname').val();
        var email = $('#reviewemail').val();;
        var content = $('#reviewcontent').val();
        var pass = true;
        var datastring = '';
    
        if(reply != 1)
        {
            if(name == ''){
                $('#reviewfullname').css('border','solid 1px red');
                $('#reviewfullname').attr('placeholder','Vui lòng nhập tên của bạn');
                pass = false;
            }
            else{
               $('#reviewfullname').css('border','solid 1px ccc');
               $('#reviewfullname').attr('placeholder','Họ và tên');
            }
            if(email == ''){
                $('#reviewemail').css('border','solid 1px red');
                $('#reviewemail').attr('placeholder','Vui lòng nhập Email');
                pass = false;
            }
            else{
                 if(validate(email) == false){
                    $('#reviewemail').css('border','solid 1px red');
                    $('#reviewemail').attr('placeholder','Email không hợp lệ');
                    pass = false;
                 }
                 else{
                    $('#reviewemail').css('border','solid 1px ccc');
                    $('#reviewemail').attr('placeholder','Email');
                 }
            }
            if(content == ''){
                $('#reviewcontent').css('border','solid 1px red');
                $('#reviewcontent').attr('placeholder','Vui lòng nhập nội dung bình luận');
                pass = false;
            }
            else{
               $('#reviewcontent').css('border','solid 1px ccc');
               $('#reviewcontent').attr('placeholder','Nội dung bình luận');
            }
        }
        else
        {
            
        }
        datastring = 'email=' +email+'&name=' +name+'&content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $('.notifi').html('');
            $('.writepost').val('');
            $('#contentcounter').html('1000');

            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');

            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/productreview/addajax",
            data : datastring,
            success : function(html){
                    $('.notifi').css('display','block');
                    if(html == '3')
                    {
                        $('.notifi').append("<p class='error'>Email không hợp lệ</p>");
                    }
                    if(html == '4')
                    {
                        $('.notifi').append("<p class='error'>Vui lòng nhập nội dung bình luận</p>");
                    }

                    if(html == '5')
                    {
                        $('.notifi').append("<p class='error'>Vui lòng chọn sản phẩm để bình luận</p>");
                    }

                    if(html == '6')
                    {
                        $('#contentcounter').html('1000');
                        $('.writepostreply').val('');
                        $('.countercontentdata').html('1000');
                        $('.notifi').append("<p class='success'>Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn</p>");
                        var now = new Date();
                        var month = parseInt(now.getMonth()) + 1;
                        var dateString = now.getHours()+":"+now.getMinutes()+" Ngày "+now.getDate() + "/" + month + "/" + now.getFullYear() + " "; 
                        var html = '<li><div class="nameuser">'+name+'<span style="float:right;font-weight: normal;font-size:12px;"><i>'+dateString+'</i></span ></div><div class="contuser">'+content+'</div>';
                        html +='<div class="right"><div id="likeproductreview2545"><a href="javascript:void(0)">Thích</a> <span id="likecom2545">0</span></div>';
                        html += '</div></li>';
                        $('.infocoms > ul').prepend(html);
                        if(parent > 0)
                        {
                            $('#reply'+parent).hide();
                        }
                        if(check == 0)
                        {
                          $('#reviewfullname').val('');
                          $('#reviewemail').val('');
                          $('#reviewcontent').val('');
                        }else{
                          if(check == 1)
                          {
                             $('#reviewcontent').val('');
                          }
                        }
                    }

                    if(html == '7')
                    {
                         $('.notifi').append("<p class='error'>Vui lòng chọn sản phẩm để bình luận</p>");
                    }
                    $('.loading-gif').remove();
                }
            });
        
          }
          else
          {
            $('.loading-gif').remove();
          }
        
    }
    ////////////////////////////////////////////////////END SEND REVIEW //////////////////////////////////////
    function replyreview(url ,objectid, parentreviewid,uid)
    {
      if(objectid > 0 && parentreviewid > 0)
      {
        url += 'site/productreview/reply/id/' + objectid + '/parentid/' + parentreviewid;
        Shadowbox.open({
                        content:    url,
                        player:     "iframe",
                        height:     175,
                        width:      400
                    });
      }
    }

    function replyopen(id)
    {
          $('.dropdown_'+id).slideToggle(100);
    }

    function closereply(id)
    {
        $('#reply'+id).fadeOut(10);
    }
    function orderreview(pid)
    {
        var order = $('#forder').val();
        if(typeof(order) != 'undefined')
        {
            loadReview(pid, order);
        }
    }
    function likereview(objectid , reviewid)
    {
      if(objectid > 0 && reviewid > 0)
      {
        datastring = 'pid='+objectid + '&rid=' +reviewid;
        $.ajax({
            type : "post",
            dataType : 'html',
            url : '/productreviewthumb/addajaxmobile',
            data : datastring,
            success : function(html){
              if(html == 'done')
              {
                currentthumbup =  parseInt($('#likecom'+reviewid).html());
                currentthumbup = currentthumbup + 1;
                //$('#like'+reviewid).html(currentthumbup);
                $('#likecom'+reviewid).html(currentthumbup);
                $('#likeproductreview'+reviewid+ ' a').removeAttr('onclick');
                $('#likeproductreview'+reviewid+ ' a').css('background','#f1f1f1');
              }     
            }
        });
      }
    }


    function likeproduct(objectid)
    {
      if(objectid > 0)
      {
        datastring = 'pid='+objectid + '&rid=0';
        $.ajax({
          type : "post",
          dataType : 'html',
          url : '/productreviewthumb/addajax',
          data : datastring,
          success : function(html){
            if(html == 'done')
            {
              currentthumbup =  parseInt($('#likeproduct').html());
              currentthumbup = currentthumbup + 1;
              $('#likeproduct').html(currentthumbup);
            }
          }
        });
      }
    }
    //////////////////////////////////////VALIDATE EMAIL /////////////////////////////////////////////
    function validate(email) {   
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; 
      if(reg.test(email) == false) 
      {   
        return false;
      } 
    }
    ///////////////////////////////////////
    function checkvalidate(obj)
    {
         if($(obj).val().trim() != "")
            $(obj).css('border','1px solid #ccc');
        else
            $(obj).css('border','solid 1px red');
    }
    /////////////////////////////////////END DIEN MAY COMMENT ////////////////////////////////////////
    $('.forcedesktop').click(function(){
        createCookie('forcedesktop',1,1);
        desktopurl = rooturl.substr(rooturl.indexOf('.')+1);
        window.location.href= 'http://'+desktopurl;
    })
    function createCookie(name, value, days) {
      if (days) {
          var date = new Date();
          date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
          var expires = "; expires=" + date.toGMTString();
      }
      else var expires = "";
      desktopurl = rooturl.substr(rooturl.indexOf('.')+1).replace('/','');
      document.cookie = name + "=" + value + expires + "; path=/;domain="+desktopurl;
    }
    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1) {
                    c_end = document.cookie.length;
                }
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }
    function deleteCookie(c_name) {
      document.cookie = encodeURIComponent(c_name) + "=deleted; expires=" + new Date(0).toUTCString();
    }

    
    function eventclick(type,category,action,label,value){
    	ga('send', {
    		  'hitType': type,          // Required.
    		  'eventCategory': category,   // Required.
    		  'eventAction': action,      // Required.
    		  'eventLabel': label,
    		  'eventValue': value
    		});
    }
