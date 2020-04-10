function checkcode(form)
{
        var codehtml= '<div style="text-align: center">Đang xử lý<br><img src="'+rooturl+'templates/default/images/ajax-loader.gif"/></div>';
        var oldhtml = $('#processck').html();
        $('#processck').html(codehtml);
        var content = '';
	var phone    = $('#fphoneck').val();
	var cmnd    = $('#fcmndck').val();
        var pathname = window.location.pathname;
	var datasend = {
            action      : "checkcode",
            fphone      : phone,
            fcmnd       : cmnd,

        };
        
     
        $.ajax({
                type: "POST",
                data: datasend,
                url:  rooturl+'giare/indexajax',
                dataType: "html",
                success: function (data) {
                  
                    checkdata('4');
                    if(data!='')
                    {
                        
                        var arr = JSON.parse(data);
                        
                        if(arr[1]=='err')
                        {
                            var msg     = 'Lỗi Thông tin nhập vào !';
                            var err     = JSON.parse(arr[0])
                            for(var i = 0 ; i<err.length ; i++)
                            {
                                 content += '. '+err[i]+'\r\n';
                            }
                             nalert(content, msg);
                        }
                        
                        
                        if(arr[1]=='ok')
                        {
                            var err     = JSON.parse(arr[0])
                            $('.list_danh_sach').html(err);
                            $('.list_danh_sach').show();
                            $('#fphoneck').val('');
                            $('#fcmndck').val('');
                        }
                        
                       
                    }
                    $('#processck').html(oldhtml);
                }
        });
}
function gr_submit()
{   
        var codehtml = '<div style="text-align: center">Đang xử lý<br><img src="'+rooturl+'templates/default/images/giare/ajax-loader.gif"/></div>';
        var oldhtml = $('#process').html();
        $('#process').html(codehtml);
        var content = '';
	var gender = $('#fgender').val();
	var name = $('#ffullname').val();
	var email = $('#femail').val();
	var phone = $('#fphone').val();
	var cmnd = $('#fcmnd').val();
	var region = $('#fregion').val();
	var answer = $('input:radio[name=fanswer]:checked').val();
        var pathname = window.location.pathname;
        
        
	var datasend = {
            action      : "dangki",
            fgender     : gender ,  
            ffullname   : name , 
            fcmnd       : cmnd,
            fphone      : phone,
            femail      : email,
            fregion     : region,
            fanswer     : answer,
            url         : pathname
        };
        
     
        $.ajax({
                type: "POST",
                data: datasend,
                url:  rootindexgiare,
                dataType: "html",
                success: function (data) {
                    checkdata('2');
                    if(data!='')
                    {
                        
                        var arr = JSON.parse(data);
                        
                        if(arr[1]=='err')
                        {
                            var msg     = 'Lỗi Thông tin nhập vào !';
                            var err     = JSON.parse(arr[0])
                            for(var i = 0 ; i<err.length ; i++)
                            {
                                 content += '. '+err[i]+'\r\n';
                            }
                            nalert(content, msg);
                        }
                        
                        
                        if(arr[1]=='ok')
                        {
                           showpoup(arr[0],'1');
                           $('.requiredgr2').val('');
                        }
                        
                       
                    }
                     $('#process').html(oldhtml);
                }
               
        });
        
}
function showpoup(id,ac)
{
   
            Shadowbox.open({
                content:    rooturl+'giare/popup/?uid='+id+'&ac='+ac,
                //title : 	'Chi tiết '+type+' của sản phẩm ' + name,
                player:     "iframe",
                height:     200,
                width:      800
            });
}
function expoint(form)
{
        $('.requiredgr'+form).removeClass('errorinput');
        var codehtml= '<div style="text-align: center">Đang xử lý<br><img src="'+rooturl+'templates/default/images/ajax-loader.gif"/></div>';
        var oldhtml = $('#processex').html();
        $('#processex').html(codehtml);
        var content = '';
	var sidgr     = $('#fdid').val();
	var usergr    = $('#fduser').val();
	var cmnd    = $('#fdcmnd').val();
        var pathname = window.location.pathname;
	var datasend = {
            action      : "expoint",
            fuser       : usergr,
            fsid        : sidgr,
            fcmnd       : cmnd,
            url         : pathname

        };
        
     
        $.ajax({
                type: "POST",
                data: datasend,
                url:  rooturl+'giare/indexajax',
                dataType: "html",
                success: function (data) {
                    checkdata('3');
                    if(data!='')
                    {
                        
                        var arr = JSON.parse(data);
                        
                        if(arr[1]=='err')
                        {
                            var msg     = 'Lỗi Thông tin nhập vào !';
                            var err     = JSON.parse(arr[0])
                            var con     = JSON.parse(arr[2])
                            for(var i = 0 ; i<err.length ; i++)
                            {
                                 content += '. '+err[i]+'\r\n';
                            }
                            for(var i = 0 ; i<con.length ; i++)
                            {
                                $('.'+con[i]+form).addClass('errorinput');
                            }
                            nalert(content, msg);
                        }
                        
                        
                        if(arr[1]=='ok')
                        {
                           showpoup(arr[0],'2');
                           $('.requiredgr'+form).val('');
                        }
                        
                        
                    }
                    $('#processex').html(oldhtml);
                }
        });
}

function checkdata(form)
{
    var rt = true;
    $('.requiredgr'+form).each(function(){
        if($(this).val() == '') {
            rt = false;
            $(this).addClass('errorinput');
        }
        else{
            rt = true;
            $(this).removeClass('errorinput');
        }

    });
    if(rt)
    {
       checkphone(form);
       checkEmail(form);
       checkcmnd(form);

    }  

}
function checkphone(form)
{
       var a = $('.phonegr'+form).val();
       var filter = /^[0-9-+]+$/;
       if (filter.test(a)) {
           if(a.length==10 || a.length==11)
                $('.phonegr'+form).removeClass('errorinput');
            else
                 $('.phonegr'+form).addClass('errorinput');

        }
        else {
               $('.phonegr').addClass('errorinput');

        }
}
function checkEmail(form){
    var email =$('.emailgr'+form).val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(email))  
    {
         $('.emailgr'+form).removeClass('errorinput');
    }
    else {
           $('.emailgr'+form).addClass('errorinput');

    }
}
function checksid(form){
    var sid =$('.sidgr3'+form).val();
    var filter = /^([0-9-+]{2})+SO+[0-9-+]+$/;
    if (filter.test(sid))  
    {
         $('.sidgr3'+form).removeClass('errorinput');
    }
    else {
           $('.sidgr3'+form).addClass('errorinput');

    }
}
function checkcmnd(form)
{
       var a = $('.cmndgr'+form).val();
       var filter2 = /^[0-9-+]+$/;
       var filter1 = /^([a-zA-Z_\.\-])+[0-9-+]+$/;
       if (filter2.test(a)) {
            if(a.length==9)
                $('.cmndgr'+form).removeClass('errorinput');
            else
                $('.cmndgr'+form).addClass('errorinput');
        }
        else {

               if(filter1.test(a))
                   $('.cmndgr'+form).removeClass('errorinput');
               else
                $('.cmndgr'+form).addClass('errorinput');

        }
}
function showds(action)
{
    if(action == 'show')
        $('.list_danh_sach').show();
    if(action == 'hide')
         $('.list_danh_sach').hide();
}
function getlist(page)
{
    var codehtml = '<div style="text-align: center">Đang xử lý<br><img src="'+rooturl+'templates/default/images/ajax-loader.gif"/></div>';
    $('.list_danh_sach').html(codehtml);
    var datasend = {
            action  : 'getlistmember',
            page    : page
        };
    $.ajax({
            type: "POST",
            url:  rootindexgiare,
            data:  datasend,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            dataType: "html",
            success: function (data) {
                if(data!='')
                 {
                    $('.list_danh_sach').html(data); 
                    showds('show');
                 }
            }
    })
}
function getcode(id,e)
{
       var codehtml = '<div style="text-align: center">Đang xử lý</div>';
       var oldhtml = $(e).html();
       $(e).html(codehtml); 
       var content  = '';
       var datasend = {
            action  : 'getcode',
            id      : id
        };
        
        $.ajax({
              type: "POST",
              data: datasend,
              url:  rootindexgiare,
              dataType: "html",
              success: function (data) {
                  if(data!='')
                  {
                      var arr = JSON.parse(data);
                      for(var i = 0 ; i<arr.length ; i++)
                      {
                           var msg     = 'Danh sách mã dự thưởng';
                           content += (i+1)+'. '+arr[i]+'\r\n';
                      }
                      nsuccess(content, msg);
                  }
                  $(e).html(oldhtml);
              }
        });
}   