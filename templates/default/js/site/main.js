
var autocompleteUrl = '';
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

function slideshow(){

    var indexselected = parseInt($('#banner .bn_left ul li.selected').attr('rel'));
    var allChild = parseInt($('#banner .bn_left ul li').length);
    var next = indexselected + 1;
    $('#banner .bn_left ul li#li_'+indexselected).removeClass('selected');
    $('#banner .bn_left .feature a#'+indexselected).fadeOut(500);//.css('display','none');
    if(allChild < next){
        next = 1;
    }
    $('#banner .bn_left ul li#li_'+next).addClass('selected');
    $('#banner .bn_left .feature a#'+next).fadeIn(1000);
}
function SBopen() {
    document.body.style.overflow = "hidden";
    return true;
}

function SBclose() {
    document.body.style.overflow = "auto";
    if($('#sb-title-inner').text()=='Sửa hình 360'
       || $('#sb-title-inner').text()=='Sửa sản phẩm'
       || $('#sb-title-inner').text()=='Sửa ưu điểm'
       || $('#sb-title-inner').text()=='Sửa nhược điểm'
       || $('#sb-title-inner').text()=='Sửa đánh giá của điện máy'
       || $('#sb-title-inner').text()=='Sửa hình đại diện'
       || $('#sb-title-inner').text()=='Sửa bộ bán hàng chuẩn'
       || $('#sb-title-inner').text()=='Sửa hình ảnh (gallery)'
       || $('#sb-title-inner').text()=='Sửa video'
       || $('#sb-title-inner').text()=='ĐẶT HÀNG NHANH'
       || $('#sb-title-inner').text()=='Summary'
       || $('#sb-title-inner').text()=='Giới thiệu sản phẩm'
       || $('#sb-title-inner').text()=='Mua sản phẩm giá rẻ'
       || $('#sb-title-inner').text()=='ĐẶT HÀNG TRƯỚC'
       || $('#sb-title-inner').text()=='Mỗi giờ một bất ngờ'
    ){
        window.location.reload();
    }
    //
    return true;
}
var timer;
$(document).ready(function(){
    Shadowbox.init({
        fadeDuration: 0.1,
        onOpen: SBopen,
        onClose: SBclose
    });
	if($('.arrowbanner').length >0)
    {
    	$('.arrowbanner').click(function(){
    		clearTimeout(timer);
        	timer = setTimeout(function(){setInterval('slideshow()',8000);},8000);
			if ($(this).hasClass('arrowbannerleft'))
			{
				var indexselected = parseInt($('#banner .bn_left ul li.selected').attr('rel'));
			    var allChild = parseInt($('#banner .bn_left ul li').length);
			    var next = indexselected + 1;
			    $('#banner .bn_left ul li#li_'+indexselected).removeClass('selected');
			    $('#banner .bn_left .feature a#'+indexselected).fadeOut(500);//.css('display','none');
			    if(allChild < next){
			        next = 1;
			    }
			    $('#banner .bn_left ul li#li_'+next).addClass('selected');
			    $('#banner .bn_left .feature a#'+next).fadeIn(1000);
			}
			else{
				var indexselected = parseInt($('#banner .bn_left ul li.selected').attr('rel'));
			    var allChild = parseInt($('#banner .bn_left ul li').length);
			    var next = indexselected - 1;
			    $('#banner .bn_left ul li#li_'+indexselected).removeClass('selected');
			    $('#banner .bn_left .feature a#'+indexselected).fadeOut(500);//.css('display','none');
			    if(next == 0){
			        next = allChild;
			    }
			    $('#banner .bn_left ul li#li_'+next).addClass('selected');
			    $('#banner .bn_left .feature a#'+next).fadeIn(1000);
			}
    	});
	}
    if($('#myregionlogin').length >0)
    {
        $('#myregionlogin').unbind('change').change(function(){
            $(this).parent().attr('action',$(location).attr('href'));
            $(this).parent().submit();
        });
    }
    if($('#myregiondetail').length >0)
    {
        $('#myregiondetail').unbind('change').change(function(){
            $(this).parent().attr('action',$(location).attr('href'));
            $(this).parent().submit();
        });
    }
    if($('#banner .bn_left').length>0){
        clearTimeout(timer);
        timer = setTimeout(function(){setInterval('slideshow()',8000);},8000);
    }
    if($('#banner .bn_left ul li').length>0){
        $('#banner .bn_left ul li').click(function(){
            clearTimeout(timer);
            var indexselected = parseInt($('#banner .bn_left ul li.selected').attr('rel'));
            var allChild = parseInt($('#banner .bn_left ul li').length);
            var next = $(this).attr('rel');
            $('#banner .bn_left ul li#li_'+indexselected).removeClass('selected');
            $('#banner .bn_left .feature a#'+indexselected).css('display','none');
            $('#banner .bn_left ul li#li_'+next).addClass('selected');
            $('#banner .bn_left .feature a#'+next).fadeIn(600);
            timer = setTimeout(function(){setInterval('slideshow()',6000);},6000);
        });
    }

    /*$(".jcarousel-prev").html('&lsaquo;');
    $(".jcarousel-next").html('&rsaquo;');
    $('#mycarousel').jcarousel({visible: 5,scroll:1,auto:1,wrap:'both', 'animation': 3000});
*/
    if($('.image360').length>0){
        $('.image360').reel({indicator:   5, // For no indicator just remove this line
              frames:      numImage360,
              frame:       14,
              rows:        0,
              row:         1,
              footage:       6,
              speed:       0.3,
              cw: true,
              images:      pathImage360,
        });
    }

    //Create Autocomplete for heading-search
    $("#fsitebooksearchtext").autocomplete(rooturl + 'search/suggest', {
      width: 462,
      scroll: true,
      scrollHeight: 500,
      highlight: false,
      selectFirst: false,
      formatItem: fsitebooksearchtextAutoCompleteFormatItem,
      formatResult: fsitebooksearchtextAutoCompleteFormatResult,

    }).result(function(event, row) {
      location.href = row[0];
      autocompleteUrl = row[0];
    });

    //Create Autocomplete for compare-search
    $("#fsitecompare").autocomplete(rooturl + 'productcompare/suggest', {
      width: 265,
      scroll: true,
      scrollHeight: 300,
      highlight: false,
      selectFirst: false,
      formatItem: fsitebooksearchtextAutoCompleteFormatItem,
      formatResult: fsitebooksearchtextAutoCompleteFormatResult,

    }).result(function(event, row) {
      location.href = row[0];
      autocompleteUrl = row[0];
    });

    if($('#installment').length > 0)
    {
        /*$('#installment').unbind('click').click(function(){
            if($(this).is(':checked')==false){
                $(this).attr('checked', false);
            }
            else
            {
                $(this).attr('checked', true);
                if(document.readyState === "complete"){

                    Shadowbox.open({
                        content:    rooturl + 'product/installment/?id=' + $(this).val(),
                        player:     "iframe",
                        options: {
                                       modal:   true
                        },
                        height:     670,
                        width:      920
                    });
                }
                else alert('Đang xử lý....');
            }

        });*/
        $('#installment').live('click', function(){
			if(document.readyState === "complete"){
                Shadowbox.open({
                   content:    rooturl + 'product/installment/?id=' + $(this).attr('rel'),
                    title :     'Chi tiết ',
                    player:     "iframe",
                    width : 950,
                    height: 465
                });
            }
            else alert('Đang xử lý....');
        });
    }

    if($('#fcurrentregion').length > 0)
    {
        $('#fcurrentregion').change(function(){
            var cr = $(this).val();
            $.post(rooturl + 'product/checkregion', {r: cr}, function(data){
                if( data && data.rt==1)
                {
                    $('#payathomebox').css('display', 'block');
                }
                else{
                    $('#payathomebox').css('display', 'none');
                }
            }, 'json');
        });

        $('#submitinstallment').click(function(){
            var rt = true;
            var err = 'Vui lòng nhập đầy đủ thông tin ở những ô màu đỏ';
            $('.required').each(function(){
                if($(this).val() == '') {
                    rt = false;
                    $(this).addClass('errorinput');
                }
                else{
                    $(this).removeClass('errorinput');
                }

            });
            if( rt )
            {
                $('.email').each(function(){
                    if(checkEmail($(this).val())) {
                        rt = false;
                        $(this).addClass('errorinput');
                    }
                    else{
                        $(this).removeClass('errorinput');
                    }
                });
            }
            /*if (rt && isValidDate($('.inputdatepicker'))==false)
            {
                err = 'Ngày sinh không hợp lệ';
                rt = false;
            }*/
            if( rt ){
                if($('input[name=fpersontype]').is(':checked')==false) {
                    rt  = false;
                    err = 'Vui lòng chọn Người đi làm hoặc Sinh Viên để nhận biết quý khách';
                }
            }
            if(rt==false) nalert(err, 'Chú ý');
            return rt;
        });

        $('#finstallmentmonth').change(function(){
            var m = $(this).val();
            if(m != '')
            {
                $.post(rooturl + 'product/prepaid',{m:m, r: $('#fcurrentregion').val(), o: $('.installrightsp .productname').attr('id'), c:  $('#fsegmentpercent').val()}, function(data){
                    if(data)
                    {
                        if(data.success==1)
                        {
                            $('#fsegmentpercent').html(data.dt);
                            if(data.rightpopup) {
                                $('.infopay').html(data.rightpopup);
                                $('.infopay').css('display', 'block');
                            }
                        }
                        else {
                            $('.infopay').html('');
                            $('.infopay').css('display', 'none');
                            $('#fsegmentpercent').html('<option value="">'+data.dt+'</option>');
                        }
                    }
                }, 'json');
            }
        });

        $('#fsegmentpercent').change(function(){
            var s = $(this).val();
            if(s != '')
            {
                $.post(rooturl + 'product/prepaid',{s: s,m:$('#finstallmentmonth').val(), r: $('#fcurrentregion').val(), o: $('.installrightsp .productname').attr('id')}, function(data){
                    if(data)
                    {
                        if(data.dt)
                        {
                            $('.infopay').html(data.dt);
                            $('.infopay').css('display', 'block');
                        }
                        else $('.infopay').css('display', 'none');
                    }
                }, 'json');
            }
        });
    }

    $('.inputdatepicker, .inputdatepickersmall').datepicker({'format':'dd/mm/yyyy', 'weekStart' : 1})
        .on('changeDate', function(ev){
           $('.datepicker').hide();
            $(this).blur();
        });

    $('.promotions').live('click', function(){
        var r = $(this).val();
        if(r != '')
        {
            processpromotion(r);
        }
	});

	if($('#loadpromotionlist').length > 0 && pid)
	{
        if(getParameterByName('color') <= 0 || getParameterByName('color') == '')
        {
    		$.post(rooturl + 'product/loadpromotionajax', {pid: pid}, function(data){
    			if (data && data.success == 1 && data.blockhtml)
    			{
    				$('#loadpromotionlist').css('display', 'block');
    				$('#loadpromotionlist').html(data.blockhtml);
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
    			}
    		}, 'json');
        }
	}

    if($('#buypress').length > 0)
    {
        $('#buypress').unbind('click').click(function(){
            var prid = $('.promotiondetail').attr('id');
            var pid = $(this).attr('rel');
            if(pid)
            {
                var url = rooturl+'cart/checkout/'+'?id='+pid;
                if(prid) url = url +'&prid='+prid;
                //loadShadowBox(url);
                if(document.readyState === "complete"){
                	window.location.href = url;
                	//loadShadowBox(url);
                }
                else alert('Đang xử lý....');
            }
        });
    }

    if($('.buypress').length > 0)
    {
        $('.buypress').unbind('click').click(function(){
            var prid = $(this).parent().attr('id');
            var pid = $(this).attr('rel');
            if(pid)
            {
                var url = rooturl+'cart/checkout/'+'?id='+pid;
                if(prid) url = url +'&prid='+prid;
                //loadShadowBox(url);
                if(document.readyState === "complete"){
                	window.location.href = url;
                	//loadShadowBox(url);
                }
                else alert('Đang xử lý....');
            }
        });
    }

    if($('.buynow').length > 0 )
    {
        $('.buynow').unbind('click').click(function(){
            var prid = $(this).parent().attr('rel');//$('.promotiondetail').attr('id');
            var pid = $(this).attr('rel');
            if(pid)
            {
                var url = rooturl+'cart/checkout/'+'?id='+pid;
                if(prid) url = url +'&prid='+prid;
                if(document.readyState === "complete"){
                	window.location.href = url;
                	//loadShadowBox(url);
                }
                else alert('Đang xử lý....');
            }
            return false;
        });
    }

    if($('.mua_ngay').length > 0 )
    {
        $('.mua_ngay').unbind('click').click(function(){
            var pid = $(this).attr('rel');
            if(!isNaN(pid))
            {
                var prid = $(this).attr('id');//$('.promotiondetail').attr('id');
                if(pid)
                {
                    var url = rooturl+'cart/giare/'+'?id='+pid;
                    if(prid) url = url +'&prid='+prid;
                    var urlpopup = rooturl+'giare/popupshare/'+'?id='+encodeURIComponent(url);
                    if(document.readyState === "complete"){ Shadowbox.open({content:urlpopup,player:"iframe",options:{modal:true},title:'Mua sản phẩm giá rẻ',height:200,width:700});}
                    else alert('Đang xử lý....');
                }
            }
            else loadShadowBox(pid);
            return false;
        });
    }

    if($('.buynow3').length > 0)
    {
        $('.buynow3').unbind('click').click(function(){
            var prid = $(this).parent().attr('rel');//$('.promotiondetail').attr('id');
            var pid = $(this).attr('rel');
            if(pid)
            {
                var url = rooturl+'cart/checkout/'+'?id='+pid;
                if(prid) url = url +'&prid='+prid;
                //loadShadowBox(url);
                if(document.readyState === "complete"){
                	window.location.href = url;
                	//loadShadowBox(url);
                }
                else alert('Đang xử lý....');
            }
            return false;
        });
    }

    if($('.buyprepaid').length > 0)
    {
        /*$('.buyprepaid').unbind('click').click(function(){
            var pid = $(this).attr('rel');
            var prid = $(this).attr('id');
            if(pid)
            {
                var url = rooturl+'cart/dattruoc'+'?id='+pid;
                if(prid) url += '&prid='+prid;

                if(document.readyState === "complete"){ Shadowbox.open({content:url,player:"iframe",options:{modal:true},title:'ĐẶT HÀNG TRƯỚC',height:450,width:510});}
                else alert('Đang xử lý....');
            }
            return false;
        });*/
    }

    if($('#cartback').length > 0)
    {
        $('#cartback').unbind('click').click(function(){
            window.location.href = rooturl;
        });
    }

    /*if($('#paymenttop').length > 0)
    {
        $('#paymenttop').click(function(){
            loadShadowBox(rooturl+'cart');
            return false;
        });
    }
    if($('#checkout').length > 0)
    {
        $('#checkout').click(function(){
            loadShadowBox(rooturl+'cart');
            return false;
        });
    }*/
    if($('#advicepopup').length > 0)
    {
        $('#advicepopup').unbind('click').click(function(){
            var r = $(this).attr('rel');
            var url = rooturl+'product/advice/?pid='+r;
            if(document.readyState === "complete"){
                Shadowbox.open({content:url,player:"iframe",options:{modal:true},title:'TƯ VẤN CHỌN SẢN PHẨM',height:610,width:850});
            }
            else alert('Đang xử lý....');
        });
    }

    if($('.radiospace').length > 0)
    {
        $('.radiospace').click(function(){
            window.location.href = $(this).val();
        });
    }

    if($('#ffiltersubmit').length > 0)
    {
        $('#ffiltersubmit').click(function(){
            var fobj = $(this).parent();
            var urlstr = '';
            fobj.find('select').each(function(){
               if($(this).val())
               {
                   urlstr += $(this).val()+',';
               }
            });
            if(urlstr != '') {
                urlstr = urlstr.substring(0, urlstr.length-1);
                window.location.href = fobj.attr('action')+'?a='+urlstr;
            }
            //if(fobj.serialize()) window.location.href = fobj.attr('action')+'?'+fobj.serialize();
            //alert($(this).parent().serialize());
            return false;
        });
    }

    if($('.products li .imageprod img').length > 0)
    {
        /*var imgobj = null, timeinterval = null;
        $('.products li .imageprod img').hover(
            function () {
                var obj = $(this).parent();
                var curobj = $(this);
                imgobj = $(this).attr('src');
                if(obj.parent().find('ul.circlegallery li').length > 0)
                {
                    var liobj =null;
                    timeinterval = setTimeout(function(){
                        if(liobj != null)
                        {
                            if(liobj.next().length > 0)
                            {
                                liobj = liobj.next();
                            }
                            else
                            {
                                liobj = obj.parent().find('ul.circlegallery li').first();//liobj = liobj.prev();
                            }
                        }
                        else liobj = obj.parent().find('ul.circlegallery li');
                        curobj.attr('src', liobj.html());
                    }, 100);

                    timeinterval = setInterval(function() {
                        if(liobj != null)
                        {
                            if(liobj.next().length > 0)
                            {
                                liobj = liobj.next();
                            }
                            else
                            {
                                liobj = obj.parent().find('ul.circlegallery li').first();//liobj = liobj.prev();
                            }
                        }
                        else liobj = obj.parent().find('ul.circlegallery li');
                        curobj.attr('src', liobj.html());
                    }, 500);
                }
            },
            function () {
                clearInterval(timeinterval);
                clearTimeout(timeinterval);
                var obj = $(this).parent();
                if(obj.parent().find('ul.circlegallery li').length > 0)
                {
                    var curobj = $(this);
                    setTimeout(function(){
                        curobj.attr('src', obj.parent().find('ul.circlegallery li').last().html());
                    }, 501);
                }
            }
        );*/
    }

    $.ajax({
        type : "POST",
        data : {url:$(location).attr('href')},
        url : rooturl + 'index/initxajax',
        dataType: "xml",
        success: function(data){
            if ($(data).find('logindata').length > 0)
            {
                var row = $('.rowheader').children().children();
                var row2 = $('.rowheader').children();
				$("#loginform").html($(data).find('logindata').text());
				$('#myregionlogin').bind('change',function(){
                    $(this).parent().attr('action',$(location).attr('href'));
                    $(this).parent().submit();
                });
                row.eq(4).remove();
                row2.attr('style','width: 427px;')
                row.eq(3).remove();
                row.children().eq(3).remove();
            }
            else if ($(data).find('loginlink').length > 0)
            {
				$("#loginBanner").attr("action", rooturl+'login/index/redirect/'+$(data).find('loginlink').text());
				$("#linklogin").attr("href", rooturl+'thanh-vien/dang-ky/redirect/'+$(data).find('loginlink').text());
            }
            if ($(data).find('cartcontent').length > 0)
            {
				$('#showcartpopup').html($(data).find('cartcontent').text());
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

    $(".video-small .popupvideo img").unbind('click').click(function(){
        var url = $(this).parent().attr('rel');
        if(url){
            $(".video-small .popupvideo").removeClass('activede');
            $('#runyoutubeurl').html('<iframe width="420" height="315" src="'+url+'?autoplay=1" frameborder="0" allowfullscreen></iframe>');
            $(this).parent().addClass('activede');
        }
        else alert('Fail to load your video');
        return false;
    });

    if($('.staticpage').length > 0)
    {
        $('.staticpage').unbind("click").click(function(){
            var url = $(this).attr('rel');
            if( url )
            {
                loadShadowBox(rooturl + '/page/pagepopup/' + url);
            }
            return false;
        });
    }

    if($('.chkaccessory').length > 0)
    {
		$('.chkaccessory').live('click', function(){
            var accessoryid = $(this).attr('rel');
            if($(this).is(':checked'))
            {
                $('#accessmath_'+accessoryid).fadeIn();
                $('#accessproduct_'+accessoryid).fadeIn();
            }
            else
            {
                $('#accessmath_'+accessoryid).fadeOut();
                $('#accessproduct_'+accessoryid).fadeOut();
            }
			checkaccessory();
		});
    }
    if($('.chkaccessory').length > 0)
    {
        setTimeout(checkaccessory,1000);
    }
    // function checked
    function checkaccessory()
    {
        if($('.chkaccessory').length > 0)
        {
            var checkedid = '';
            $('.chkaccessory:checked').each(function(){
                checkedid += $(this).val() + ',';
            });
            if( $('#accessorybox').attr('rel') != '' )
            {
                var promo = '';
                if( $('.promotions').length > 0 ) promo = $('.promotions:checked').val();
                $.post(rooturl + 'product/updateaccessory' , {pid: $('#accessorybox').attr('rel'), acc: checkedid, promo: promo}, function(success){
                    if ( success && success.mainprice )
                    {
                        var htmlassign = '';
                        if ( success.saving  && success.saving != '')
                        {

                            if ( success.numproduct > 0 ) htmlassign += '<div class="accessrow" id="selectnumber" style="display: none;">Bạn vừa chọn: <strong>'+success.numproduct+'</strong> phụ kiện</div>';
                            htmlassign += '<div class="accessrow" id="priceassessory">Giá mua lẻ: <strong>'+success.promotionprices+'đ</strong></div>';
                            htmlassign += '<div class="accessrow" id="priceretail">Giá mua kèm: <span>'+success.mainprice+'đ</span></div>';
                            htmlassign += '<div class="accessrow" id="pricesaving">Tiết kiệm: <span>'+success.saving+'đ</span></div>';
                            if(success.numproduct > 0)
                                 htmlassign += '<div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()">Mua kèm '+success.numproduct+' sản phẩm đã chọn</a></div>';
                            else
                                htmlassign += '<div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()">Mua sản phẩm đã chọn</a></div>';
                        }
                        else
                        {
                            if ( success.numproduct > 0 ) htmlassign += '<div class="accessrow" id="selectnumber" style="display: none;">Bạn vừa chọn: <strong>'+success.numproduct+'</strong> phụ kiện</div>';
                            htmlassign += '<div class="accessrow">Giá mua: <strong>'+success.mainprice+'đ</strong></div>';
                            if(success.numproduct > 0)
                                 htmlassign += '<div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()"> Mua kèm '+success.numproduct+' sản phẩm đã chọn</a></div>';
                            else
                                htmlassign += '<div class="accessrow accbtn"><a href="javascript:void(0)" id="addaccessoryproduct" onclick="addaccessorytocart()"> Mua sản phẩm đã chọn </a></div>';
                        }
                        if ( htmlassign != '' )
                        {
                            $('#accessorybox').html( htmlassign );
                        }
                    }
                }, 'json');
            }
        }
    }
    if ($('.vendorseemore').length > 0)
    {
		$('.vendorseemore').click(function(){
			var parentobj = $(this).parent().parent();
			if ($(this).text() == 'Xem thêm')
			{
				parentobj.find('li').each(function(){
					$(this).removeClass('hidden');
				});
				$(this).text('Thu lại');
			}
			else
			{
				parentobj.find('li').each(function(ix){
					if (ix > 9) $(this).addClass('hidden');
				});
				$(this).text('Xem thêm');
				$(this).parent().removeClass('hidden');
			}
		});
    }
    if ($('.filterseemore').length > 0)
    {
		$('.filterseemore').click(function(){
			var parentobj = $(this).parent().parent();
			var idrel = $(this).attr('rel');
			if ($(this).text() == 'Xem thêm')
			{
				parentobj.find('li').each(function(){
					if ($(this).hasClass('filter'+idrel))
					{
						$(this).removeClass('hidden');
					}
				});
				$(this).text('Thu lại');
			}
			else
			{
				parentobj.find('li').each(function(ix){
					if (ix > 9) {
						if ($(this).hasClass('filter'+idrel))
						{
							$(this).addClass('hidden');
						}
					}
				});
				$(this).text('Xem thêm');
				$(this).parent().removeClass('hidden');
			}
		});
    }

    // Slider page product /////////////////////////////////////////
    //Slider content product
    $('#bannerProduct').bjqs({
        'height' : 100,
        'width' : 1200,
        'responsive' : true,
        usecaptions : false,
        showmarkers : false,
        hoverpause : true,
        animspeed : 4000
    });
    //End slider content product
    //Slider page product /////////////////////////////////////////
    if (typeof ispriceajax !== 'undefined' && ispriceajax == 1 && $('.loadprice').length > 0 && (getParameterByName('color') <= 0 || getParameterByName('color') == ''))
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

                            }
                            if (objassign.find('.priceold').length > 0)
                            {
                                objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
                            }
							else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
							{
								if (objassign.find('div.pricedienmay').length > 0 && objassign.find('div.dienmay').length > 0 && objassign.find('div.genuine').length == 0)
								{
								    objassign.find('div.dienmay').before('<div class="genuine"><div class="textgenuine">Giá chính hãng:</div><div class="pricegenuine"><span>'+datajs.data[i].sell+' đ</span></div></div>');
								}
								else objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
							}
                            if(parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.salepercent').length > 0)
                            {
                                objassign.find('.salepercent').html('-'+datajs.data[i].percent + '%');
                            }
                            else if(parseInt(datajs.data[i].isdiscount) != 1 && objassign.find('.salepercent').length > 0)
                            {
                                objassign.find('.salepercent').remove();
                            }
                            if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.priceold').length == 0 && objassign.find('div.pricenew').length >0) {
                                objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
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
											}
											if (objassign.find('.priceold').length > 0)
											{
												objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
											}
											else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
											{
												objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+'</div>');
											}
                                            if(parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.salepercent').length > 0)
                                            {
                                                objassign.find('.salepercent').html('-'+datajs.data[i].percent + '%');
                                            }
                                            else if(parseInt(datajs.data[i].isdiscount) != 1 && objassign.find('.salepercent').length > 0)
                                            {
                                                objassign.find('.salepercent').remove();
                                            }
                                            if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.priceold').length == 0 && objassign.find('div.pricenew').length >0) {
                                                objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
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
															}
															if (objassign.find('.priceold').length > 0)
															{
																objassign.find('.priceold').html(datajs.data[i].sell + ' đ');
															}
															else if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('div.priceold').length == 0)
															{
																objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+'</div>');
															}
                                                            if(parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.salepercent').length > 0)
                                                            {
                                                                objassign.find('.salepercent').html('-'+datajs.data[i].percent + '%');
                                                            }
                                                            else if(parseInt(datajs.data[i].isdiscount) != 1 && objassign.find('.salepercent').length > 0)
                                                            {
                                                                objassign.find('.salepercent').remove();
                                                            }
                                                            if (parseInt(datajs.data[i].isdiscount) == 1 && objassign.find('.priceold').length == 0 && objassign.find('div.pricenew').length >0) {
                                                                objassign.find('div.pricenew').after('<div class="priceold">'+datajs.data[i].sell+' đ</div>');
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
    /* Load product segment
    if ($('.specialproductsegment').length > 0)
    {
		var str20first = '';
		var str30next = '';
		var str50last = '';
		$('.specialproductsegment').each(function(ix){
			if (ix < 20)
			{
				if ($(this).attr('id'))
				{
					var childdata = $(this).attr('id');
					if ($(this).attr('rel') == '') childdata += ':' + $(this).attr('rel');
					if (str20first != '')
					{
						str20first += '#' + childdata;
					}
					else str20first += childdata;
				}
			}
			else if (ix > 19 && ix < 50)
			{
				if ($(this).attr('id'))
				{
					var childdata = $(this).attr('id');
					if ($(this).attr('rel') == '') childdata += ':' + $(this).attr('rel');
					if (str30next != '')
					{
						str30next += '#' + childdata;
					}
					else str30next += childdata;
				}
			}
			else if (ix > 49)
			{
				if ($(this).attr('id'))
				{
					var childdata = $(this).attr('id');
					if ($(this).attr('rel') == '') childdata += ':' + $(this).attr('rel');
					if (str50last != '')
					{
						str50last += '#' + childdata;
					}
					else str50last += childdata;
				}
			}
		});
		if (str20first != '')
		{
			$.ajax({
				   type: "POST",
				   dataType: 'json',
				   data: {id: str20first},
				   url: rooturl + 'site/productsegment/indexajax',
				   error: function(){
				   },
				   success: function(datajs){
						if (datajs && datajs.data)
						{
							$.each(datajs.data,function(i){
								$('#' + datajs.data[i].id).html(datajs.data[i].block);
							});

							if (str30next != '')
							{
								$.ajax({
									   type: "POST",
									   dataType: 'json',
									   data: {id: str30next},
									   url: rooturl + 'site/productsegment/indexajax',
									   error: function(){
									   },
									   success: function(datajs){
											if (datajs && datajs.data)
											{
												$.each(datajs.data,function(i){
													$('#' + datajs.data[i].id).html(datajs.data[i].block);
												});
												if (str50last != '')
												{
													$.ajax({
														   type: "POST",
														   dataType: 'json',
														   data: {id: str50last},
														   url: rooturl + 'site/productsegment/indexajax',
														   error: function(){
														   },
														   success: function(datajs){
																if (datajs && datajs.data)
																{
																	$.each(datajs.data,function(i){
																		$('#' + datajs.data[i].id).html(datajs.data[i].block);
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
    */
     //$('.showTip').tip({maxWidth:'200px'});

     $('#facebook-headlike').html('<iframe src="http://www.facebook.com/plugins/like.php?href=https://www.facebook.com/dienmaycom&width=200&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>');

    //Tracking
    var t_id = $('#t_id').val();
    var t_controller_group = $('#t_controller_group').val();
    var t_controller = $('#t_controller').val();
    var t_action = $('#t_action').val();
    var t_referer = document.referrer;
    var t_q = $('#t_q').val();

    $.ajax({
        type : "POST",
        data : {trackingid : t_id,
        		controller_group : t_controller_group,
        		controller : t_controller,
        		action : t_action,
        		referer : t_referer,
        		q : t_q},
        url : rooturl + 'site/tracking',
        dataType: "json",
        success: function(data){

        }
    });
        /*Show popup campaign 02092013*/
    $('.buypromo0209').live('click', function(){
        if ($(this).attr('rel') != '')Shadowbox.open({content:$(this).attr('rel'),player:"iframe",options:{modal:true},title:'Mỗi giờ một bất ngờ',height:450,width:500});
    });
    $('.userpromo0209').live('click', function(){
        if ($(this).attr('rel') != '')Shadowbox.open({content:$(this).attr('rel'),player:"iframe",options:{modal:true},title:'Danh sách khách hàng mua sản phẩm',height:430,width:750});
    });
    /*End Show popup campaign*/
    // Load user pre-oder ajax
    if(typeof pid !== 'undefined' && pid > 0)
    {
        loadUserPrepaid(pid);
    }
});

function loadShadowBox(url)
{
    Shadowbox.open({content:url,player:"iframe",options:{modal:true},title:'ĐẶT HÀNG NHANH',height:610,width:800});
}

function loadinstock(idcolor)
{
    $.post(rooturl + 'product/checkstorestock', {fpid: idcolor}, function(data){//
    if (data)
    {
        if (parseInt(data.instock) >0)
        {
            if (data.html.length >0)
            {
                $('.btn-spmark').html(data.html);
            }
            if ($('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().removeClass('btn-hethang');
            if (!$('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().addClass('btn-buy');
            if (!$('.btn-hethang').parent().hasClass('btn-buy')) {
                $('.btn-hethang a').removeClass('buyprepaid');
                $('.btn-hethang a').attr('id', 'buyonline');
                $('.btn-hethang a').attr('style', '');
                $('.btn-hethang a').attr('title', 'Mua ngay');
                $('.btn-hethang a').html('<i class="icon-cart"></i> MUA NGAY');
                $('.btn-hethang').addClass('btn-buy');
                $('.btn-hethang').removeClass('btn-hethang');
            } else {
                $('#buyonline').html('<i class="icon-cart"></i> MUA NGAY');
            }
            
            $('.instockstatus').fadeIn();
             $('.instockstatus').html('Còn hàng');
        }
        else
        {
            if (!$('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().removeClass('btn-buy');
            if ($('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().addClass('btn-hethang');
            $('#buyonline').html('TẠM THỜI HẾT HÀNG');
            $('#btn-spmark').html('');
             $('.instockstatus').fadeIn();
             $('.instockstatus').html('Hết hàng');
        }
    }
}, 'json');
}

function doSitebooksearchtextpress(e)
{
  if (e.keyCode == 13)
  {
    //check xem autocomplete da co row nao select chua
    //neu chua thi tien hanh submit form
    if(autocompleteUrl.length == 0)
      $('#fsitebooksearchsubmit').trigger('click');
    else
      location.href = autocompleteUrl;
  }
}

////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////t/////////////////////
/////////////////////////       AUTO COMPLETE   //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////
function fsitebooksearchtextAutoCompleteFormatItem(row)
{
  autocompleteUrl = '';
  var _viewDetail = 'Xem thông tin này';

  var value = row[1].replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $("#fsitebooksearchtext").val().replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");

  var url = row[0];
  var rating = row[3];
  var author = row[4];
  var resulttype = row[5];  //can be book, user, site page (contact, login..)




  var output = '';

  //append book item
  if(resulttype == 'product' || resulttype == 'news' || resulttype == 'stuff' || resulttype == '')
  {
    output += '<div class="sitesearch-autocomplete">';
    output += '   <div class="sitesearch-autocomplete-image"><img class="product" src="'+ row[2] +'" /></div>';
    output += '   <div class="sitesearch-autocomplete-text">'+ value +'</div>';
    output += '   <div class="sitesearch-autocomplete-author">'+ author +'</div>';
    output += ' </div>';
  }
  else if(resulttype == 'controller')
  {
    output += '<div class="sitesearch-autocomplete-controller">';
    output += '   <div class="sitesearch-autocomplete-image"><img class="controller" src="'+ row[2] +'" /></div>';
    output += '   <div class="sitesearch-autocomplete-text">'+ value +'</div>';
    output += '   <div class="sitesearch-autocomplete-author">'+ author +'</div>';
    output += ' </div>';
  }
  else if(resulttype == 'user')
  {
    output += '<div class="sitesearch-autocomplete-user">';
    output += '   <div class="sitesearch-autocomplete-image"><img class="avatar" src="'+ row[2] +'" /></div>';
    output += '   <div class="sitesearch-autocomplete-text">'+ value +'</div>';
    output += '   <div class="sitesearch-autocomplete-author">'+ author +'</div>';
    output += ' </div>';
  }
  else if(resulttype == 'seperator')
  {
    output += '<div class="sitesearch-autocomplete-seperator"><div class="sitesearch-autocomplete-textsep">'+value+'</div></div>';
  }




  return output;
}

function fsitebooksearchtextAutoCompleteFormatResult(row)
{
  return row[1].replace(/(<.+?>)/gi, '');
}


function initEditInline(pcid, pid)
{
    var cururl = $(location).attr('href');
    $.ajax({
       type: "POST",
       dataType: 'xml',
       data: 'fpcid= '+pcid+'&fpid='+pid+'&furl='+encodeURIComponent(cururl),
       url: rooturl + 'product/initinlineajax',
       error: function(){
       },
       success: function(xml){
           var status = parseInt($(xml).find('status').text());
           if(status == 1)
           {
               $('body').append($(xml).find('htmlblock').text()).css('padding-top', '50px');
               $('#hidepopup').bind('click', function(){
                    $(this).parent().css('display','none');
                });
                $('#toprotate').css('position', 'relative');
               $('#toprotate').append($(xml).find('rotate360').text());

               var catname = '';
               if($('#productcategory').length > 0) catname = $('#productcategory').html()
               var proname = '';
               if($('#productname').length > 0) proname = $('#productname').html();
               if(catname != '' && proname != '') proname = proname.replace(catname + ' ',"");
               if(proname != '' && $('#productname').length > 0) {
				   $('#productname').html(catname + ' <span>'+proname+'</span>');
	               $('#productname span').editable(rooturl+'product/inlineproduct', {
	                    indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
	                    tooltip   : "Click to edit...",
	                    submitdata: { fpcid: pcid, fpid: pid, type: 'p_name'},
	                  }
	               );
               }
               if($('#summaryproduct').length > 0)
               {
                   $('#summaryproduct').css('position', 'relative');
                   $('#summaryproduct').append($(xml).find('summaryproduct').text());
               }
               if($('#introduction').length > 0)
               {
                   $('#introduction').css('position', 'relative');
                   $('#introduction').append($(xml).find('introductionproduct').text());
               }
               if($('#seodescription').length > 0 )
               {
                   $('#seodescription').editable(rooturl+'product/inlineproduct', {
                        indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
                        tooltip   : "Click to edit...",
                        type     : "textarea",
                        submitdata: { fpcid: pcid, fpid: pid, type: 'p_seodescription'},
                      }
                   );
               }
               $('#productname span').addClass('editbutton');

               $('#thegood').css('position','relative');
               $('#thegood').append($(xml).find('good').text());

               $('#thebad').css('position','relative');
               $('#thebad').append($(xml).find('bad').text());

               $('#dmreview').css('position','relative');
               $('#dmreview').append($(xml).find('review').text());

               /*$('#techlist').css('position','relative');
               $('#techlist').append($(xml).find('image').text());
               */

               $('#rotate360 .titlename').css('position','relative');
               $('#rotate360 .titlename').append($(xml).find('rotate360').text());

               $('#standard .titlename').css('position','relative');
               $('#standard .titlename').append($(xml).find('fullbox').text());

               $('#fullshortboxedit').css('position','relative');
               $('#fullshortboxedit').append($(xml).find('fullboxshort').text());

               $('#gallery .titlename').css('position','relative');
               $('#gallery .titlename').append($(xml).find('gallery').text());

               $('#specialimages').css('position','relative');
               $('#specialimages').append($(xml).find('gallery').text());

               $('#video .titlename').css('position','relative');
               $('#video .titlename').append($(xml).find('video').text());

               $('.fullnoteganame').each(function(index){
                   $(this).editable(rooturl+'product/inlinenote', {
                        indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
                        submitdata: { id: $(this).attr('rel'),fpcid: pcid, type: fgpa, fpid: pid },
                      }
                   );
                   $(this).addClass('editbutton');
               });

               $('.fullnotename').each(function(index){
                   var curId = $(this).attr('rel');
                   $(this).editable(rooturl+'product/inlinenote', {
                        indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
                        submitdata: { id: curId,fpcid: pcid, type: fpa, fpid: pid },
                        callback: function(data){
                            if($('#kk'+curId).length>0)
                            {
                                $('#kk'+curId).html(data);
                            }
                            if($('#k'+curId).length>0)
                            {
                                $('#k'+curId).html(data);
                            }
                        },
                      }
                   );
                   $(this).addClass('editbutton');
               });

               $('.fullnote').each(function(index){
                   var curId = $(this).attr('rel');
                   $(this).editable(rooturl+'product/inlinenote', {
                        indicator : '<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />',
                        submitdata: { id: curId,fpcid: pcid, type: prel, fpid: pid },
                        callback: function(data){
                            if($('#v'+curId).length>0)
                            {
                                $('#v'+curId).html(data);
                            }
                            if($('#vv'+curId).length>0)
                            {
                                $('#vv'+curId).html(data);
                            }
                        },
                      }
                   );
                   $(this).addClass('editbutton'); //type = rel
               });
           }
       }
     });

}

function initEditCategoryInline(pcid)
{
    pcid = $.trim(pcid);
    var cururl = $(location).attr('href');

    $.ajax({
       type: "POST",
       dataType: 'xml',
       data: 'fpcid='+pcid+'&furl='+encodeURIComponent(cururl),
       url: rooturl + 'product/initcatinlineajax',
       error: function(){

       },
       success: function(xml){
           var status = parseInt($(xml).find('status').text());
           if(status == 1)
           {



				/////////////////
				//edit inline
               var gloreturntext = $(xml).find('special').text();

               if(gloreturntext)
               {
                   _bindCatEdit(gloreturntext);
               }

           }
       }
     });

}

function _bindCatEdit(gloreturntext)
{
    //$('.products ul li .special').append(gloreturntext);
                   $('.products ul li .special').each(function(){

                       var returntext = gloreturntext;
                       if($(this).find('img').length>0)
                       {
                           var splitarr = $(this).find('img').attr('src').match(/[-_\w]+[.][\w]+$/i);
                           splitarr = splitarr[0].split(/\./);

                           if(splitarr[0])
                           {
                               var imgfile = splitarr[0];
                               splitarr = splitarr[0].split(/\_/);
                               var ln = splitarr.length;
                               //alert(splitarr[0]+' '+splitarr[1]+' '+ splitarr[2]);
                               if(ln ==3)
                               {
                                   returntext = returntext.replace('site/icon_'+splitarr[1]+'_grey', 'site/icon_'+splitarr[1] );
                                   returntext = returntext.replace('site/icon_'+splitarr[2]+'_grey' , 'site/icon_'+splitarr[2] );
                                   returntext = returntext.replace('rel="'+splitarr[1]+'"', 'rel="r'+splitarr[1]+'"' );
                                   returntext = returntext.replace('rel="'+splitarr[2]+'"', 'rel="r'+splitarr[2]+'"' );
                               }
                               else
                               {
                                   returntext = returntext.replace('site/'+imgfile+'_grey', 'site/'+imgfile);
                                   returntext = returntext.replace('rel="'+splitarr[1]+'"', 'rel="r'+splitarr[1]+'"' );
                               }
                           }
                       }
                       //$('.products ul li .special').append(returntext);
                       //$(this).parent().remove('ul');
                       $(this).append(returntext);
                   });
    _bindcatevent($('.products ul li .special ul li img'));
}

function _bindcatevent(obj)
{
    obj.bind('click', function(){
                       var parentobj = $(this).parent().parent().parent();
                       var pid = parentobj.attr('id');
                       var curimgsrc = $(this).attr('src');
                       var typimg = $(this).attr('rel');
                       $.ajax({
                           type: "POST",
                           dataType: 'json',
                           data: 'fpcid= '+parentobj.attr('rel')+'&fpid='+pid+'&type='+$(this).attr('rel')+'&value=1',
                           url: rooturl + 'product/inlineproduct',
                           error: function(){
                           },
                           success: function(result){

                               if(result)
                               {
                                   if(result.returnimg)
                                   {
                                       var newtext = parentobj.html();
                                       newimg = imageDir + 'site/'+result.returnimg;
                                       if(result.enablevalue && result.disablevalue)
                                       {
                                           newtext = newtext.replace(new RegExp(result.disablevalue,"g"),result.enablevalue);
                                           newtext = newtext.replace('rel="'+result.relenablevalue+'"','rel="'+result.reldisablevalue+'"');
                                           if(result.convertenablevalue && result.convertdisablevalue)
                                           {
                                               newtext = newtext.replace(new RegExp(result.convertenablevalue,"g"),result.convertdisablevalue);
                                               newtext = newtext.replace('rel="'+result.relconvertdisablevalue+'"','rel="'+result.relconvertenablevalue+'"');
                                           }
                                       }
                                       else
                                       {
                                           newtext = newtext.replace(curimgsrc,newimg);
                                       }
                                       curimgsrc = newimg;
                                       parentobj.html(newtext);
                                       _bindcatevent(parentobj.find('ul li img'));
                                   }
                                   if(result.noshowimage !='')
                                   {
                                       if(parentobj.find('#iconspecialimg').length>0)
                                       {
                                           parentobj.find('#iconspecialimg').hide();
                                       }
                                   }
                                   else
                                   {
                                       if(parentobj.find('#iconspecialimg').length>0)
                                       {
                                           //parentobj.find('#iconspecialimg').attr('src',curimgsrc);
                                           parentobj.find('#iconspecialimg').attr('class',result.returnclass);
                                       }
                                       else {
                                           parentobj.prepend('<i class="'+result.returnclass+'" id="iconspecialimg"></i>');//'<img src="'+curimgsrc+'" width="45" height="45" id="iconspecialimg" />');
                                       }
                                   }
                               }
                           }
                       });
                   });
}


function getParameterByName(name){
    var url     = document.URL,
        count   = url.indexOf(name);
        sub     = url.substring(count);
        amper   = sub.indexOf("&");

    if(amper == "-1"){
        var param = sub.split("=");
        return param[1];
    }else{
        var param = sub.substr(0,amper).split("=");
        return param[1];
    }

}


function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
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


function sendReview(id , parentid , check , reply)
{

    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap

    var parentobj = parent;
    parent = parentid;

    var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';
    var checksubcom = 0;
     $('.notifireviewthumb').fadeIn();
     $('.notifireviewthumb').html('');
     if ($('.check').is(':checked')){
        checksubcom = 1;
     }
    /*if(check == 0) //chua dang nhap
    {

        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }

        if(reply == 1)
        {

            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            //tien hanh luu thong tin cua content vao cookie
            //luu noi dung vao cookie
            $('.writepost').val('');
            $('#contentcounter').html('1000');

            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');

            createCookie("content" , content);
            url = rooturl + 'site/productreview/addinfo/pid/'+id+'/parentid/'+parent;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     175,
                    width:      500
                });
        }
    } */

    if(check == 1 || check == 0)
    {

        var pass = true;
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(check != 1)
        {
            if($('#username').val() == "" || $('#email').val() == "")
            {
                $('.notifireviewthumb').html('Vui lòng nhập thông tin trước khi bình luận');
                $('.notifireviewthumb').addClass('errorreview');
                pass= false;
            }
            if($('#email').val() != "")
            {
                if(validate($('#email').val()) == false)
                {
                    $('.notifireviewthumb').html('Sai định dạng email');
                    $('.notifireviewthumb').addClass('errorreview');
                    pass = false;
                }
            }
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            if(check == 1)
                nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            else{
                $('.notifireviewthumb').html('Vui lòng nhập nội dung bình luận');
                $('.notifireviewthumb').addClass('errorreview');
            }
            pass = false;
        }
        if(check == 1)
            datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent + '&checksubcom='+checksubcom;
        else
            datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent + '&name='+$('#username').val()+'&email='+$('#email').val() + '&checksubcom='+checksubcom;
        if(pass)
        {
            $('#contentcounter').html('1000');
            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');
            $('.combtn .loading').addClass('loadingcomment');
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/productreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        //xoa cookie
                        createCookie("content" , "" , -1);
                        //$('#freviewcontent').val('');
                        if(reply == 1 || reply == -1)
                        {

                            /*url = rooturl + 'site/productreview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });*/
                            $('.notifireview').fadeIn();
                            $('.notifireview').addClass('successreview');
                            $('.notifireview').html('<div class="notify-bar-icon"><img src="'+rooturl+'templates/default/images/notify/success.png" alt="success"></div><div class="notify-bar-button"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="'+rooturl+'templates/default/images/notify/close-btn.png" border="0" alt="close"></a></div><div class="notify-bar-text"><p>Ý kiến của bạn đã được đăng. Cám ơn bạn đã đóng góp cho dienmay.com</p></div>');
                            var username = check==1?$('#usernamereview').val():$('#username').val();
                            var now = new Date();
                            var month = parseInt(now.getMonth()) + 1;
                            var dateString = now.getDate() + "/" + month + "/" + now.getFullYear() + " ";
                            var html = '<div class="wrap-querep">';
                                html +=  '<div class="question">';
                                html +=     '<img src="'+rooturl+'templates/default/images/site/user.jpg">';
                                html +=     '<div class="questiontext">';
                                html +=     '<span>'+username+'</span>';
                                html +=     '<p>'+$('#freviewcontent').val()+'</p>';
                                html +=     '<ul>';
                                html +=                    '<li id=""><a href="javascript:void(0)">Thích</a></li>';
                                html +=                    '<li id=""><i class="icon-likecom"></i>0</li>';
                                html +=                    '<li>'+dateString+'</li>';
                                html +=            '</ul>';
                                html +=            '</div>';

                                html +=        '</div>';
                                html +=      '<div>';
                                $('.review-product').prepend(html);
                             $('.writepost').val('');
                             $('#username').val('');
                             $('#email').val('');
                        }
                        else
                        {
                            $('.writepost').val('');
                            $('#contentcounter').html('1000');

                            $('.writepostreply').val('');
                            $('.countercontentdata').html('1000');

                            parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/productreview/success';
                            document.location.href = url;
                        }
                        if(parent > 0)
                        {
                            $('#reply'+parent).hide();
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                    $('.loadingcomment').removeClass('loadingcomment');
                }
            });
        }
         else
        {
            $('.notifireviewthumb').delay(3000).fadeOut();
        }
    }

    if(check == 2)
    {
        content = $('#freviewcontent').val();
        if(content == '')
        {
            $('.notifireviewthumb').html('Vui lòng nhập nội dung bình luận');
            $('.notifireviewthumb').addClass('errorreview');
            pass = false;
        }
        if($('#emailorphone').val() == "" || $('#password').val() == "")
        {
            $('.notifireviewthumb').html('Vui lòng nhập thông tin trước khi bình luận');
            $('.notifireviewthumb').addClass('errorreview');
            pass= false;
        }
        if(pass)
        {
            var email = $('#emailorphone').val();
            var password = $('#password').val();
            $('#contentcounter').html('1000');
            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');
            $('.combtn .loading').addClass('loadingcomment');

            datastring = 'femail=' +email + '&fpassword=' +password + '&content=' +content+'&id=' +id+ '&parent=' +parent + '&checksubcom='+checksubcom;;
            $.ajax({
                type : "post",
                dataType : "html",
                url : "/site/login/addandloginajax",
                data : datastring,
                success : function(html){
                    var data = jQuery.parseJSON(html);
                    if(data.comment == 'loginfail')
                    {
                         $('.notifireviewthumb').html('Thông tin đăng nhập không chính xác');
                         $('.notifireviewthumb').addClass('errorreview');
                    }
                    if(data.comment == '4')
                    {
                        $('.notifireviewthumb').html('Vui lòng nhập nội dung bình luận');
                        $('.notifireviewthumb').addClass('errorreview');
                    }

                    if(data.comment == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(data.comment == '6')
                    {
                        //xoa cookie
                        createCookie("content" , "" , -1);
                        if(reply == 1 || reply == -1)
                        {
                            $('.notifireview').addClass('successreview');
                            $('.notifireview').fadeIn();
                            $('.notifireview').html('<div class="notify-bar-icon"><img src="'+rooturl+'templates/default/images/notify/success.png" alt="success"></div><div class="notify-bar-button"><a href="javascript:void(0);" onclick="javascript:$(this).parent().parent().fadeOut();" title="close"><img src="'+rooturl+'templates/default/images/notify/close-btn.png" border="0" alt="close"></a></div><div class="notify-bar-text"><p>Ý kiến của bạn đã được đăng. Cám ơn bạn đã đóng góp cho dienmay.com</p></div>');
                            var username = data.username;
                            var now = new Date();
                            var month = parseInt(now.getMonth()) + 1;
                            var dateString = now.getDate() + "/" + month + "/" + now.getFullYear() + " ";
                            var html = '<div class="wrap-querep">';
                                html += '    <div class="question">';
                                html +=     '<img src="'+rooturl+'templates/default/images/site/user.jpg">';
                                html +=     '<div class="questiontext">';
                                html +=     '<span>'+username+'</span>';
                                html +=     '<p>'+$('#freviewcontent').val()+'</p>';
                                html +=     '<ul>';
                                html +=                    '<li id=""><a href="javascript:void(0)">Thích</a></li>';
                                html +=                    '<li id=""><i class="icon-likecom"></i>0</li>';
                                html +=                    '<li>'+dateString+'</li>';
                                html +=            '</ul>';
                                html +=            '</div>';

                                html +=        '</div>';
                                html += '</div>';
                                $('.review-product').prepend(html);
                             $('.combtn').html('<div class="combtn"><a href="javascript:void(0)" class="btn-blues" onclick="sendReview('+pid+' , 0 , 1 , -1)">Gửi bình luận</a></div>')
                             $('#usernamereview').val(data.username);
                             $('.writepost').val('');
                             $('.username').val('');
                             $('.email').val('');
                        }
                        else
                        {
                            $('.writepost').val('');
                            $('#contentcounter').html('1000');

                            $('.writepostreply').val('');
                            $('.countercontentdata').html('1000');

                            parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/productreview/success';
                            document.location.href = url;
                        }
                        if(parent > 0)
                        {
                            $('#reply'+parent).hide();
                        }
                    }

                    if(data.comment == '7')
                    {
                        $('.notifireviewthumb').html('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau');
                        $('.notifireviewthumb').addClass('errorreview');
                    }
                    $('.loadingcomment').removeClass('loadingcomment');
                }
            });
        }
        else
        {
            $('.notifireviewthumb').delay(3000).fadeOut();
        }
    }
}

function loadReview(id , order)
{
  $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/productreview/indexajax",
    data : "id=" +id + "&order="+order,
    success : function(html){
      $('#comment').html(html);
      var countcomment = parseInt($('.commentbar h2 span').html()) > 0 ? '('+$('.commentbar h2 span').html()+')' :'';
      if(countcomment != "" || countcomment != null)
        $('.totalcomm a span').html( countcomment );
      if($('.commentnumber').length > 0){
		  $('.commentnumber').each(function(){
		  	$(this).find('span').html($('#productreviewtotal').val());
      	  });
      }
      //$('.writepost').limit(1000 , "#contentcounter");
      //$('.writepostreply').limit(1000 , ".countercontentdata");
    }
  });
}


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

function relyfunc(id)
{
    $('#reply'+id).fadeIn(10);
}

function closereply(id)
{
    $('#reply'+id).fadeOut(10);
}

function likereview(objectid , reviewid)
{
  if(objectid > 0 && reviewid > 0)
  {
    datastring = 'pid='+objectid + '&rid=' +reviewid;
    $.ajax({
      type : "post",
      dataType : 'html',
      url : '/productreviewthumb/addajax',
      data : datastring,
      success : function(html){
        if(html == 'done')
        {
          currentthumbup =  parseInt($('#like'+reviewid).html());
          currentthumbup = currentthumbup + 1;
          //$('#like'+reviewid).html(currentthumbup);
          $('#likecom'+reviewid).html('<i class="icon-likecom"></i>'+currentthumbup);
          $('#likeproductreview'+reviewid).html('Thích');
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

function orderreview(pid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadReview(pid, order);
    }
}

function orderreviewgiare(pid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadgiareReview(pid, order);
    }
}
/**Start Job comment**/
function loadJobReview(id , order)
{

  $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/jobreview/indexajax",
    data : "id=" +id + "&order="+order,
    success : function(html){
      $('#comments').html(html);
    }
  });
}

function sendJobReview(id , parentid , check , reply)
{
    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap

    var parentobj = parent;
    parent = parentid;

	var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';


    if(check == 0) //chua dang nhap
    {
        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }

        if(reply == 1)
        {

            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            url = rooturl + 'site/jobreview/addinfo/pid/'+id+'/parentid/'+parent+'/content/'+content;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     175,
                    width:      500
                });
        }
    }

    if(check == 1)
    {
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }

        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/jobreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        //$('#freviewcontent').val('');
                        if(reply == 1 || reply == -1)
                        {
                            $('.writepost').val('');
                            url = rooturl + 'site/jobreview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });
                        }
                        else
                        {
                           $('.writepost').val('');
                           parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/jobreview/success';
                            document.location.href = url;
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }

    if(check == 2)
    {
        if($('#freviewname').length > 0)
        {
            var name = $('#freviewname').val();
            if(name == '')
            {
                nalert('Vui lòng nhập tên của bạn' , 'Lỗi');
                pass = false;
            }
        }

        if($('#freviewemail').length > 0)
        {
            var email = $('#freviewemail').val();
            if(email == '')
            {
                nalert('Vui lòng nhập email của bạn', 'Lỗi');
                pass = false;
            }
        }


        content = $('#freviewcontent').val();
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        if(pass)
        {
            datastring = 'name=' +name + '&email=' +email + '&content=' +content+'&id=' +id+ '&parent=' +parent;
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/jobreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '1')
                    {
                        nalert('Vui lòng nhập tên của bạn', 'Lỗi');
                    }

                    if(html == '2')
                    {
                        nalert('Vui lòng nhập email của bạn', 'Lỗi');
                    }

                    if(html == '3')
                    {
                        nalert('Email của bạn không hợp lệ' , 'Lỗi');
                    }

                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {

                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        $('.writepost').val('');
                        parentobj.$("#sb-body").height(75);
                        url = rooturl + 'site/jobreview/success';
                        document.location.href = url;
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }
}

function relyfunc(id)
{
    $('#reply'+id).fadeIn(10);
}

function closereply(id)
{
    $('#reply'+id).fadeOut(10);
}

function orderjobreview(pid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadReview(pid, order);
    }
}



/**end job comment**/

/***** Begin News Comment Script *****/

function loadnewsReview(id , order)
{

  $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/newsreview/indexajax",
    data : "id=" +id + "&order="+order,
    success : function(html){
      $('#comments').html(html);
    }
  });
}

function sendnewsReview(id , parentid , check , reply)
{
    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap
    var parentobj = parent;
    parent = parentid;

    var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';


    if(check == 0) //chua dang nhap
    {
        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }

        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            url = rooturl + 'site/newsreview/addinfo/pid/'+id+'/parentid/'+parent+'/content/'+content;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     175,
                    width:      500
                });
        }
    }

    if(check == 1)
    {
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        else
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/newsreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        //$('#freviewcontent').val('');
                        if(reply == 1 || reply == -1)
                        {
                            $('.writepost').val('');
                            url = rooturl + 'site/newsreview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });
                        }
                        else
                        {
                            $('#freviewcontent').val('');
                            parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/newsreview/success';
                            document.location.href = url;
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }

    if(check == 2)
    {
        if($('#freviewname').length > 0)
        {
            var name = $('#freviewname').val();
            if(name == '')
            {
                nalert('Vui lòng nhập tên của bạn' , 'Lỗi');
                pass = false;
            }
        }

        if($('#freviewemail').length > 0)
        {
            var email = $('#freviewemail').val();
            if(email == '')
            {
                nalert('Vui lòng nhập email của bạn', 'Lỗi');
                pass = false;
            }
        }

        content = $('#freviewcontent').val();
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        if(pass)
        {
            datastring = 'name=' +name + '&email=' +email + '&content=' +content+'&id=' +id+ '&parent=' +parent;
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/newsreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '1')
                    {
                        nalert('Vui lòng nhập tên của bạn', 'Lỗi');
                    }

                    if(html == '2')
                    {
                        nalert('Vui lòng nhập email của bạn', 'Lỗi');
                    }

                    if(html == '3')
                    {
                        nalert('Email của bạn không hợp lệ' , 'Lỗi');
                    }

                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {

                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        $('.writepost').val('');
                        parentobj.$("#sb-body").height(75);
                        url = rooturl + 'site/newsreview/success';
                        document.location.href = url;
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }
}

function likenewsreview(objectid , reviewid)
{
  if(objectid > 0 && reviewid > 0)
  {
    datastring = 'nid='+objectid + '&rid=' +reviewid;
    $.ajax({
      type : "post",
      dataType : 'html',
      url : '/newsreviewthumb/addajax',
      data : datastring,
      success : function(html){
        if(html == 'done')
        {
          currentthumbup =  parseInt($('#like'+reviewid).html());
          currentthumbup = currentthumbup + 1;
          //$('#like'+reviewid).html(currentthumbup);
          $('#likecom'+reviewid).html('<span>Thích (<span id="like'+reviewid+'">'+currentthumbup+'</span>)</span>');
        }
      }
    });
  }
}

function replynewsreview(url ,objectid, parentreviewid,uid)
{
  if(objectid > 0 && parentreviewid > 0)
  {
    url += 'site/newsreview/reply/id/' + objectid + '/parentid/' + parentreviewid;

    if(uid == 0)
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
    else
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
  }
}

function ordernewsreview(nid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadnewsReview(nid, order);
    }
}

/***** End News Comment Script *****/

/***** Begin Stuff Comment Script *****/

function loadstuffReview(id , order)
{

  $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/stuffreview/indexajax",
    data : "id=" +id + "&order="+order,
    success : function(html){
      $('#comments').html(html);
    }
  });
}

function sendstuffReview(id , parentid , check , reply)
{
    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap
    var parentobj = parent;
    parent = parentid;
    var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';


    if(check == 0) //chua dang nhap
    {
        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            url = rooturl + 'site/stuffreview/addinfo/pid/'+id+'/parentid/'+parent+'/content/'+content;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     150,
                    width:      500
                });
        }
    }

    if(check == 1)
    {
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        else
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/stuffreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        //$('#freviewcontent').val('');
                        if(reply == 1 || reply == -1)
                        {
                            $('.writepost').val('');
                            url = rooturl + 'site/stuffreviewnewsreview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });
                        }
                        else
                        {
                            $('#freviewcontent').val('');
                            parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/stuffreview/success';
                            document.location.href = url;
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }

    if(check == 2)
    {
        if($('#freviewname').length > 0)
        {
            var name = $('#freviewname').val();
            if(name == '')
            {
                nalert('Vui lòng nhập tên của bạn' , 'Lỗi');
                pass = false;
            }
        }

        if($('#freviewemail').length > 0)
        {
            var email = $('#freviewemail').val();
            if(email == '')
            {
                nalert('Vui lòng nhập email của bạn', 'Lỗi');
                pass = false;
            }
        }

        content = $('#freviewcontent').val();
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        if(pass)
        {
            datastring = 'name=' +name + '&email=' +email + '&content=' +content+'&id=' +id+ '&parent=' +parent;
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/stuffreview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '1')
                    {
                        nalert('Vui lòng nhập tên của bạn', 'Lỗi');
                    }

                    if(html == '2')
                    {
                        nalert('Vui lòng nhập email của bạn', 'Lỗi');
                    }

                    if(html == '3')
                    {
                        nalert('Email của bạn không hợp lệ' , 'Lỗi');
                    }

                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {

                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        $('.writepost').val('');
                        parentobj.$("#sb-body").height(75);
                        url = rooturl + 'site/stuffreview/success';
                        document.location.href = url;
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }
}

function likestuffreview(objectid , reviewid)
{
  if(objectid > 0 && reviewid > 0)
  {
    datastring = 'sid='+objectid + '&rid=' +reviewid;
    $.ajax({
      type : "post",
      dataType : 'html',
      url : '/stuffreviewthumb/addajax',
      data : datastring,
      success : function(html){
        if(html == 'done')
        {
          currentthumbup =  parseInt($('#like'+reviewid).html());
          currentthumbup = currentthumbup + 1;
          //$('#like'+reviewid).html(currentthumbup);
          $('#likecom'+reviewid).html('<span>Thích (<span id="like'+reviewid+'">'+currentthumbup+'</span>)</span>');
        }
      }
    });
  }
}

function replystuffreview(url ,objectid, parentreviewid,uid)
{
  if(objectid > 0 && parentreviewid > 0)
  {
    url += 'site/stuffreview/reply/id/' + objectid + '/parentid/' + parentreviewid;

    if(uid == 0)
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
    else
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
  }
}

function orderstuffreview(sid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadstuffReview(sid, order);
    }
}
/***** End Stuff Comment *****/

/***** Begin Page Comment *****/

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

function sendpageReview(id , parentid , check , reply)
{
    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap
    var parentobj = parent;
    parent = parentid;
    var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';


    if(check == 0) //chua dang nhap
    {
        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            url = rooturl + 'site/pagereview/addinfo/pid/'+id+'/parentid/'+parent+'/content/'+content;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     150,
                    width:      500
                });
        }
    }

    if(check == 1)
    {
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/pagereview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        //$('#freviewcontent').val('');
                        if(reply == 1 || reply == -1)
                        {
                            $('.writepost').val('');
                            url = rooturl + 'site/pagereview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });
                        }
                        else
                        {
                            $('#freviewcontent').val('');
                            parentobj.$("#sb-body").height(75);
                            url = rooturl + 'site/pagereview/success';
                            document.location.href = url;
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }

    if(check == 2)
    {
        if($('#freviewname').length > 0)
        {
            var name = $('#freviewname').val();
            if(name == '')
            {
                nalert('Vui lòng nhập tên của bạn' , 'Lỗi');
                pass = false;
            }
        }

        if($('#freviewemail').length > 0)
        {
            var email = $('#freviewemail').val();
            if(email == '')
            {
                nalert('Vui lòng nhập email của bạn', 'Lỗi');
                pass = false;
            }
        }

        content = $('#freviewcontent').val();
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        if(pass)
        {
            datastring = 'name=' +name + '&email=' +email + '&content=' +content+'&id=' +id+ '&parent=' +parent;
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/pagereview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '1')
                    {
                        nalert('Vui lòng nhập tên của bạn', 'Lỗi');
                    }

                    if(html == '2')
                    {
                        nalert('Vui lòng nhập email của bạn', 'Lỗi');
                    }

                    if(html == '3')
                    {
                        nalert('Email của bạn không hợp lệ' , 'Lỗi');
                    }

                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '5')
                    {
                        nalert('Vui lòng chọn sản phẩm để bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {

                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                        $('.writepost').val('');
                        parentobj.$("#sb-body").height(75);
                        url = rooturl + 'site/pagereview/success';
                        document.location.href = url;
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }
}

function likepagereview(objectid , reviewid)
{
  if(objectid > 0 && reviewid > 0)
  {
    datastring = 'pid='+objectid + '&rid=' +reviewid;
    $.ajax({
      type : "post",
      dataType : 'html',
      url : '/pagereviewthumb/addajax',
      data : datastring,
      success : function(html){
        if(html == 'done')
        {
          currentthumbup =  parseInt($('#like'+reviewid).html());
          currentthumbup = currentthumbup + 1;
          //$('#like'+reviewid).html(currentthumbup);
          $('#likecom'+reviewid).html('<span>Thích (<span id="like'+reviewid+'">'+currentthumbup+'</span>)</span>');
        }
      }
    });
  }
}

function replypagereview(url ,objectid, parentreviewid,uid)
{
  if(objectid > 0 && parentreviewid > 0)
  {
    url += 'site/pagereview/reply/id/' + objectid + '/parentid/' + parentreviewid;

    if(uid == 0)
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
    else
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
  }
}

function orderpagereview(pid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadpageReview(pid, order);
    }
}

//////////////////////////////////////////
function loadgiareReview(id , order)
{

  $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/giarereview/indexajax",
    data : "id=" +id + "&order="+order,
    success : function(html){
      $('#comments').html(html);
    }
  });
}

function loadgiareReviewPage(page)
{
    $.ajax({
    type : "post",
    dataType : "html",
    url : "/site/giarereview/indexajax/page/"+page,
    success : function(html){
      $('#comments').html(html);
    }
  });
}

function sendgiareReview(id , parentid , check , reply)
{
    //check = 0 -> chua dang nhap ,
    //check =1 ->da dang nhap
    //check 2 -> hien popup nhap

    var name = '';
    var email = '';
    var content = '';
    var pass = true;
    var datastring = '';
    var parentobj = parent;
    parent = parentid;
    if(check == 0) //chua dang nhap
    {
        //kiem tra content
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
        }
        else
        {
            $('.writepost').val('');
            $('#contentcounter').html('1000');

            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');

            createCookie("content" , content);
            url = rooturl + 'site/giarereview/addinfo/pid/'+id+'/parentid/'+parent;
            Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     175,
                    width:      500
                });
        }
    }

    if(check == 1)
    {
        if(reply == 0 || reply == -1)
        {
            content = $('#freviewcontent').val();
        }
        if(reply == 1)
        {
            content = $('#freviewcontentreply'+parent).val();
        }

        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            pass = false;
        }

        datastring = 'content=' +content+'&id=' +id+ '&parent=' +parent;
        if(pass)
        {
            $('.writepost').val('');
            $('#contentcounter').html('1000');

            $('.writepostreply').val('');
            $('.countercontentdata').html('1000');
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/giarereview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        //nsuccess('Cảm ơn bình luận của bạn về sản phẩm ! Chúng tôi đã nhận được bình luận của bạn' , 'Thành công');
                         //xoa cookie
                        createCookie("content" , "" , -1);
                        $('.writepost').val('');
                        if(reply == 1 || reply == -1)
                        {
                            $('.writepost').val('');
                            url = rooturl + 'site/giarereview/success';
                            Shadowbox.open({
                                    content:    url,
                                    player:     "iframe",
                                    height:     75,
                                    width:      500
                            });
                        }
                        else
                        {
                            $('.writepost').val('');
                            $('#contentcounter').html('1000');

                            $('.writepostreply').val('');
                            $('.countercontentdata').html('1000');
                            parent.$("#sb-body").height(75);
                            url = rooturl + 'site/giarereview/success';
                            document.location.href = url;
                        }
                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });
        }
    }

    if(check == 2)
    {
        if($('#freviewname').length > 0)
        {
            var name = $('#freviewname').val();
            if(name == '')
            {
                nalert('Vui lòng nhập tên của bạn' , 'Lỗi');
                return false;
            }
        }

        if($('#freviewemail').length > 0)
        {
            var email = $('#freviewemail').val();
            if(email == '')
            {
                nalert('Vui lòng nhập email của bạn', 'Lỗi');
                return false;
            }
        }
        content = $('#freviewcontent').val();
        if(content == '')
        {
            nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
            return false;
        }

            datastring = 'name=' +name + '&email=' +email + '&content=' +content+'&id=' +id+ '&parent=' +parentid;
            $.ajax({
            type : "post",
            dataType : "html",
            url : "/site/giarereview/addajax",
            data : datastring,
            success : function(html){
                    if(html == '1')
                    {
                        nalert('Vui lòng nhập tên của bạn', 'Lỗi');
                    }

                    if(html == '2')
                    {
                        nalert('Vui lòng nhập email của bạn', 'Lỗi');
                    }

                    if(html == '3')
                    {
                        nalert('Email của bạn không hợp lệ' , 'Lỗi');
                    }

                    if(html == '4')
                    {
                        nalert('Vui lòng nhập nội dung bình luận', 'Lỗi');
                    }

                    if(html == '6')
                    {
                        createCookie("content" , '' , -1);

                        $('.writepost').val('');
                        $('#contentcounter').html('1000');

                        $('.writepostreply').val('');
                        $('.countercontentdata').html('1000');
                        parentobj.$("#sb-body").height(75);
                        url = rooturl + 'site/giarereview/success';

                        document.location.href = url;

                    }

                    if(html == '7')
                    {
                        nalert('Có lỗi xảy ra trong quá trình thêm bình luận ! Bạn vui lòng quay lại sau' , 'Lỗi');
                    }
                }
            });

    }
}

function likegiarereview(objectid , reviewid)
{
  if(reviewid > 0)
  {
    datastring = 'pid='+objectid + '&rid=' +reviewid;
    $.ajax({
      type : "post",
      dataType : 'html',
      url : '/giarereviewthumb/addajax',
      data : datastring,
      success : function(html){
        if(html == 'done')
        {
          currentthumbup =  parseInt($('#like'+reviewid).html());
          currentthumbup = currentthumbup + 1;
          //$('#like'+reviewid).html(currentthumbup);
          $('#likecom'+reviewid).html('<span>Thích (<span id="like'+reviewid+'">'+currentthumbup+'</span>)</span>');
        }
      }
    });
  }
}

function replygiarereview(url ,objectid, parentreviewid,uid)
{
  if(parentreviewid > 0)
  {
    url += 'site/giarereview/reply/id/' + objectid + '/parentid/' + parentreviewid;

    if(uid == 0)
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
    else
    {
      Shadowbox.open({
                    content:    url,
                    player:     "iframe",
                    height:     180,
                    width:      800
                });
    }
  }
}

function orderpagereview(pid)
{
    var order = $('#forder').val();
    if(typeof(order) != 'undefined')
    {
        loadgiareReview(pid, order);
    }
}
////////////////////////////////////////////////////


function addCompareProduct(pid)
{
	if(pid > 0)
	{
		 var datastring = 'pid=' + pid;

		    $.ajax({
		        type : "post",
		        dataType : "html",
		        url : "/site/productcompare/addproductcompareajax",
		        data : datastring,
		        success : function(html){
		            if(html == 'success'){
		                location.reload();
		            }
		        }
		    });
	}
}

/***** End Page Comment *****/
// Validates that the input string is a valid date formatted as "dd/mm/yyyy"
function isValidDate(dateString)
{
    // First check for the pattern
    if(!/^\d{2}\/\d{2}\/\d{4}$/.test(dateString))
        return false;

    // Parse the date parts to integers
    var parts = dateString.split("/");
    var day = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var year = parseInt(parts[2]);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}

function isEmail(str){
    var email =str;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test($(email).val()))
        return false;
    return true;
}

function product_stat(type, id)
{
	if($('#topheadstat').length){
		$('#topheadstat').remove();
		document.location.reload();
	}
	else
	{
		//move to top
		//scrollTo('body');
		scrollTo( 0,0);

		var html = '<div id="topheadstat"></div>';
		//$('#tophead').before(html);
		$('#header').before(html);

		//loading content
		$('#topheadstat').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');
		var vid = 0;
		if($('#vendor').length > 0) vid = parseInt ($('#vendor').attr('rel'));
		var urlprocess = rooturl + 'stat/report/productcategory?id=' + id + '';
		if(vid >0 ) urlprocess += '&fvid='+ vid;
		urlprocess += '&first=1';
		if(type == 'shit')
		{
			$.ajax({
		            type : "GET",
		            url : urlprocess,
		            dataType: "html",
		            success: function(html)
					{
						$('#topheadstat').html(html);
		            }
		    });
		}
		else
		{
			var iframeheightext = " height='1000' ";
			if(type == 'productcategory')
			{
				//$('#topheadstat').height($(window).height() - 50);
				//iframeheightext = " height='"+($(window).height() - 50)+"' ";
			}
			else
			{
				urlprocess = rooturl + 'stat/report/productcompare?id=' + id + '';
				$('#topheadstat').css('height', 'auto');
			}
			//nhung iframe
			$("#topheadstat").html("<iframe width='850' "+iframeheightext+" frameborder='0' marginheight='0' marginwidth='0' src='"+urlprocess+"' onload='resizeIframe(this)'></iframe>");
			$('#topheadstat iframe').width($(window).width());
			$('#topheadstat iframe').css('min-height', 1000);
		}

	}
}


function resizeIframe(iframe) {
    iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
 }

//menu
if(typeof(hideMenu) != 'undefined' && hideMenu == '1'){
	$(".dropdown-menu-aim").addClass('showhide');
}else{$(".dropdown-menu-aim").removeClass('showhide');}
var $menu = $(".dropdown-menu-aim");
$menu.menuAim({
    activate: activateSubmenu,
    deactivate: deactivateSubmenu,
    exitMenu: function() {
        $(".popover").css("display", "none");
        $(".maintainHover").removeClass("maintainHover");
    },
    enter : function(row){
      if($('.maintainHover').length==0)
      {
         $('.popover').hide();
         activateSubmenu(row);
      }
    },
});

function exitsubmenu(row)
{
     var $row = $(row),
        submenuId = $row.data("submenuId"),
        $submenu = $("#" + submenuId),
        height = $menu.outerHeight(),
        width = $menu.outerWidth();

        $('.popover').hide();
}
function activateSubmenu(row) {
    var $row = $(row),
        submenuId = $row.data("submenuId"),
        $submenu = $("#" + submenuId),
        height = $menu.outerHeight(),
        width = $menu.outerWidth();
    $submenu.css({
        display: "block",
        top: -1,
        left: 0,
        height: height
    });


    //$row.find("a").addClass("maintainHover");
	$row.addClass("maintainHover");
}

function deactivateSubmenu(row) {
    var $row = $(row),
        submenuId = $row.data("submenuId"),
        $submenu = $("#" + submenuId);
    $submenu.css("display", "none");
    //$row.find("a").removeClass("maintainHover");
	$row.removeClass("maintainHover");
}

function showpopupprepaid(id)
{
	Shadowbox.open({
        content:    rooturl + 'product/dattruoc/?id=' + id,
        player:     "iframe",
        options: {
                       modal:   true
        },
        height:     500,
        width:      800
    });
}

function processContact()
{
	$.post(rooturl + 'contact/process', $('#contactform').serialize(), function(rs){
		if( rs ){
			if (rs.error ){
				if($('#ffullname').val() == '') $('#ffullname').addClass('errorborder');
				if($('#femail').val() == '') $('#femail').addClass('errorborder');
				if($('#fphone').val() == '') $('#fphone').addClass('errorborder');
				if($('#fmessage').val() == '') $('#fmessage').addClass('errorborder');
				nalert(rs.error, 'Lỗi');
			}
			else if (rs.success) {
				$('#ffullname').removeClass('errorborder');
				$('#femail').removeClass('errorborder');
				$('#fphone').removeClass('errorborder');
				$('#fmessage').removeClass('errorborder');
				nsuccess(rs.success, 'Thành công');
			}
		}
	}, 'json');
}

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

            $('div.infopromo').html(data.block);
            $('.areapricegift .areaprice').html(data.block);
            if($('.buyprepaid').length > 0 ) {
				if (data.prid) {
                    $('.buyprepaid').attr('id',data.prid);
                    $('.buyprepaid').attr('href',rooturl+'cart/dattruoc?id='+data.id+'&prid='+data.prid)
                }
				$('.buyprepaid').attr('rel',data.id);
            }
            else if($('#buyonline').length > 0) $('#buyonline').attr('href', data.urlbuynow);
            else if($('#buystore').length > 0) $('#buystore').attr('href', data.urlbuynow+'&s=1');
        }
    },'json');
}

function addaccessorytocart()
{
	if ($('.chkaccessory:checked').length > 0)
	{
		$.post(rooturl + 'cart/addcartajax', {id: $('#accessorybox').attr('rel')}, function(data){
			if ( data && data.success )
			{
				if (data.success == 1)
				{
					$('#accessoryparentbox').css('position', 'relative');
					$('#accessoryparentbox').append('<p id="accesoryalert" style="background: #00A1E6;color: #FFFF00;display: block;padding: 10px 5px;position: absolute;right: 2px;text-transform: uppercase;top: 50%;width: 350px;z-index: 999;">Sản phẩm của bạn đã được thêm vào giỏ hàng</p>');
					$('#accesoryalert').hide(3000);
					$.ajax({
				            type : "POST",
				            data : {},
				            url : rooturl + 'cart/loadcartajax',
				            dataType: "json",
				            success: function(data){
			                    if(data && data.success == 1 && data.content != '')
			                    {
			                        window.location.href = rooturl+"cart/checkout";
			                    }
				            }
				    });
					//$('#addaccessoryproduct').remove();
				}
				else{
					$('#accessoryparentbox').css('position', 'relative');
					$('#accessoryparentbox').append('<p id="accesoryalert" style="background: #00A1E6;color: #FFFF00;display: block;padding: 10px 5px;position: absolute;right: 2px;text-transform: uppercase;top: 50%;width: 350px;z-index: 999;">Không thể thêm sản phẩm vào giỏ hàng, vui lòng chờ 5 giây</p>');
					$('#accesoryalert').hide(3000);
				}
			}
		}, 'json');
	}
}



function initinternalbar()
{
	var editurl = $('#internaltopbar_editurl').text();
    var refreshurl = $('#internaltopbar_refreshurl').text();
    var reporturl = $('#internaltopbar_reporturl').text();
    var reporttype = $('#internaltopbar_reporttype').text();
    var objectid = $('#internaltopbar_objectid').text();

	//LOAD SUMMARY STAT/REPORT FOR TOPBAR
	if(reporttype.length > 0 || parseInt(objectid) > 0)
		initinternalbar_summary(reporttype, objectid, reporturl);


	//init tinycon object to favicon notification number badge
	Tinycon.setOptions({
	    width: 7,
	    height: 9,
	    font: '10px arial',
	    colour: '#ffffff',
	    background: '#f00',
	    fallback: true
	});


	var tophtml = '<div id="popupeditinline">\
		<div id="topnotify" class="pull-left">\
		      <div class="topitem" id="topmessage">\
		          <a class="topbutton" href="javascript:void(0)"><img src="'+imageDir+'top_message.png" /><span class="badge hide">0</span></a>\
		          <div class="topitempanel hide" style="height: auto;">\
		              <h3>Tin nhắn mới<a href="'+rooturl+'profile/message?do=add">[+] Gởi tin nhắn</a></h3>\
		              <ul style="height: auto;"></ul>\
		              <div class="viewall"><a href="'+rooturl+'profile/message" title="Xem tất cả các tin nhắn">Xem tất cả</a></div>\
		          </div><!-- .topitemdata -->\
		      </div><!-- end #topmessage -->\
\
		      <div class="topitem" id="topnotification">\
		          <a class="topbutton" href="javascript:void(0)"><img src="'+imageDir+'top_notification.png" /><span class="badge hide">0</span></a>\
		          <div class="topitempanel hide" style="height: auto;">\
		              <h3>Thông báo mới</h3>\
		              <ul style="height: auto;"></ul>\
		              <div class="viewall"><a href="'+rooturl+'profile/notification" title="Xem tất cả các thông báo">Xem tất cả</a></div>\
		          </div><!-- .topitemdata -->\
		      </div><!-- end #topnotification -->\
		  </div><!-- end #topnotify -->\
		';
		if (objectid && parseInt(objectid) > 0 && reporturl !='') tophtml += '<a class="popupbread" href="javascript:void(0)" title="View Report" onclick="stat_open(\''+reporturl+'\')">ID: '+objectid+'</a>\ ';
		else if (objectid && parseInt(objectid) > 0) tophtml += '<a class="popupbread" href="javascript:void(0)" title="View Report">ID: '+objectid+'</a>\ ';
		else if (objectid && parseInt(objectid) == -1 && reporturl !='')  tophtml += '<a class="popupbread" href="javascript:void(0)" title="View Report" onclick="stat_open(\''+reporturl+'\')">Root Report</a>\ ';

		tophtml += '<a href="javascript:void(0)" onclick="$(\'#popupeditinline\').hide()" id="hidepopup" title="Close this bar"><img src="'+imageDir+'stat/close.png" alt="Close" /></a>\ ';

		if (objectid && parseInt(objectid) > 0) tophtml += '<a href="'+editurl+'" id="editinlineedit" title="Go to edit page"><img src="'+imageDir+'stat/edit.png" alt="Edit" /></a>\
		<a href="'+refreshurl+'" id="editinlinerefresh" title="View of Customer"><img src="'+imageDir+'stat/customerview.png" alt="Customer View" /></a>\
		</div>';

	$('body').append(tophtml).css('padding-top', '50px');

	bottombar_init();

}


function initinternalbar_summary(reporttype, objectid, reporturl)
{
	var currenturl = $(location).attr('href');

	//loading indicator

	$.ajax({
            type : "GET",
            url : rooturl + 'stat/index/internaltopbarsummary',
			data: 'currenturl=' + encodeURIComponent(currenturl) + '&reporttype=' + reporttype + '&objectid=' + objectid + '&reporturl=' + encodeURIComponent(reporturl),
			dataType: 'xml',
			error: function(){

			},
            success: function(xml)
			{
				var viewinday = $(xml).find('viewinday').text();
				//alert(viewinday);
            }
    });
}



function stat_open(reporturl)
{
	if($('#topheadstat').length){
		$('#topheadstat').remove();
		document.location.reload();
	}
	else
	{
		//move to top
		//scrollTo('body');
		scrollTo( 0,0);

		var html = '<div id="topheadstat"></div>';
		//$('#tophead').before(html);
		$('#header').before(html);

		//loading content
		$('#topheadstat').html('<img class="tmp_indicator" src="'+imageDir+'ajax_indicator.gif" border="0" />');

		var iframeheightext = " height='1000' ";
		$('#topheadstat').css('height', 'auto');

		//nhung iframe
		$("#topheadstat").html("<iframe width='850' "+iframeheightext+" frameborder='0' marginheight='0' marginwidth='0' src='"+reporturl+"' onload='resizeIframe(this)'></iframe>");
		$('#topheadstat iframe').width($(window).width());
		$('#topheadstat iframe').css('min-height', 1000);
	}
}

//PRODUCT color

    function productcolor(t){
        $('.addloading').addClass('loadinggif');
        $('.actcolor').removeClass('actcolor');
        $(t).addClass('actcolor');
        var pid = $(t).attr('colorid');
        var title = $(t).attr('rel');
        if(title!="")
        {
            $('.head-center .nameproduct').html(title);
        }
        $.ajax({
            type : "POST",
            url : rooturl + 'product/colorproductajax',
            data: 'pid='+pid,
            dataType: 'html',
            error: function(){

            },
            success: function(html)
            {
                var data = jQuery.parseJSON(html);
                //alert(data);
                var sell = data.sell; //gia ban
                var discount = data.discount; //gia giam
                //alert(sell);
                var isdiscount = data.isdiscount; // co giam gia hay khong
                var success = data.success //co khuyen mai
                var blockhtml = data.blockhtml //thong tin khuyen mai;
                var gallerycolor = data.gallerycolor //Gallery
                var productid = data.id; //Product id
                var instock = data.instock;
                //Insert gallery if exesit
                $('.btn-spmark').css('display','block');
                if(gallerycolor.length != 0){
                    $('active').removeClass('active');
                    var video = $('#videothumb').length;
                    var image360 = $('#360thumb').length;
                    var numberimg = 5 - video - image360;
                    var html = "";
                    html += '<div class="special">'+$('#zoomslide .special').text()+'</div>';
                    html += '<div class="fixzoom">';
                    html+= '<img data-zoom-image="'+gallerycolor[0].imagelarge+'" src="'+gallerycolor[0].imagemedium+'" id="zoom">';
                    html += '</div>';
                    html+= '<div id="zoomslides">';
                    $.each(gallerycolor,function(i){
                        if(i < numberimg){
                            html += '<a data-zoom-image="'+gallerycolor[i].imagelarge+'" data-image="'+gallerycolor[i].imagemedium+'" data-update="" class="elevatezoom-gallery">'
                            html += '<img class="withumb" src="'+gallerycolor[i].imagesmall+'" onclick="clickimage(this)">';
                            html += '</a>';
                        };
                    });
                    html+= '</div>';
                    $('#zoomslide').html(html);
                    $('.zoomContainer').remove();
                    $("#zoom").elevateZoom({
                        gallery : "zoomslide",
                        galleryActiveClass: "active",
                        easing:true
                    });
                    $('#zoomslides a').first().addClass('active');
                };
                $('.addloading').removeClass('loadinggif');
                //Load khuyen mai
                if(instock == 1)
                {
                    //$('#buyonline').fadeIn();
                    $('#buyonline').attr('href',data.urlbuynow);
                    $('#buyonline').html('<i class="icon-cart"></i> MUA NGAY');
                    if ($('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().removeClass('btn-hethang');
                    if (!$('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().addClass('btn-buy');
                    $('.instockstatus').fadeIn();
                    $('.instockstatus').html('Còn hàng');
                    if($('#loadpromotionlist').length > 0 && productid)
                    {
                        $('#loadpromotionlist').css('display', 'block');
                        $('#loadpromotionlist').html(data.blockhtml);
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
                        //console.log(firstpromoobj.val());
                        if(firstpromoobj && firstpromoobj.val() != '' && typeof firstpromoobj.val() != 'undefined') {
                            firstpromoobj.attr('checked', 'checked');
                            processpromotion(firstpromoobj.val());
                        }
                        else
                        {
                            if(parseInt(sell.replace(/,/g, "")) > 0 && parseInt(discount.replace(/,/g, "")) > 0)
                            {
                                if(parseInt(discount.replace(/,/g, "")) > 0 && isdiscount == 1 && parseInt(sell.replace(/,/g, "")) > parseInt(discount.replace(/,/g, "")) )
                                {
                                    $('.areaprice .pricedienmay span').html(discount+" đ");
                                    $('.areaprice .pricegenuine span').html(sell+"  đ");
                                }
                                else
                                {
                                    if(parseInt(sell.replace(/,/g, "")) > 0)
                                    {
                                        $('.areaprice .pricedienmay span').html(sell+" đ");
                                        $('.econo').remove();
                                        $('.genuine').remove();
                                    }
                                }
                            }
                            else{
                                $('#buyonline').attr('href', 'javascript:void(0)');
                                //$('#buyonline').css('display','none');
                                $('#buyonline').html('TẠM THỜI HẾT HÀNG');
                                if (!$('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().addClass('btn-hethang');
                                if ($('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().removeClass('btn-buy');

                                $('.econo').remove();
                                $('.genuine').remove();
                                $('.areaprice .pricedienmay span').html("Giá đang cập nhật");
                            }
                        }
                    }
                }
                else{
                    if(instock == 2)
                    {
                        if ($('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().removeClass('btn-hethang');
                    	if (!$('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().addClass('btn-buy');

                        $('.instockstatus').css('display','block');
                        $('.instockstatus').html('Hàng sắp về');
                    }
                    else
                    {
                        if(instock == 0)
                        {
                            if (!$('#buyonline').parent().hasClass('btn-hethang')) $('#buyonline').parent().addClass('btn-hethang');
                    		if ($('#buyonline').parent().hasClass('btn-buy')) $('#buyonline').parent().removeClass('btn-buy');
                    		$('#buyonline').attr('href', 'javascript:void(0)');
                            $('#buyonline').html('TẠM THỜI HẾT HÀNG');

                            $('.btn-spmark').css('display','none');
                            //$('#buyonline').fadeOut();
                            $('.instockstatus').css('display','block');
                            $('.instockstatus').html('Hết hàng');
                            $('.econo').remove();
                            $('.genuine').remove();
                            if($('.areagift').length > 0)
                            {
                                $('.areagift').fadeOut();
                            }
                            if(parseInt(sell.replace(/,/g, "")) > 0)
                            {
                                if(parseInt(discount.replace(/,/g, "")) > 0 && isdiscount == 1 && parseInt(sell.replace(/,/g, "")) > parseInt(discount.replace(/,/g, "")))
                                {
                                    $('.areaprice .pricedienmay span').html(discount+" đ");
                                    $('.areaprice .pricegenuine span').html(sell+"  đ");
                                }
                                else
                                {
                                    if(parseInt(sell.replace(/,/g, "")) > 0)
                                    {
                                        $('.areaprice .pricedienmay span').html(sell+" đ");
                                        $('.econo').remove();
                                        $('.genuine').remove();
                                    }
                                }
                            }
                            else{
                                $('.areaprice .pricedienmay span').html("Giá đang cập nhật");
                            }

                        }
                    }
                }
                if(instock !== 2 && instock !== 3){
                    loadinstock(pid);
                }
            }
        });
    };

//END COLOR PRODUCT
// Product color detail list
var color = getParameterByName('color');
if(color > 0)
{
    var t = $('.color_'+color);
    productcolor(t);
}
else
{
    if($('.colorproduct').length > 0)
    {
        if( $('.colorproduct .productcolor').length > 1){
            var t = $('.productcolor.actcolor');
            productcolor(t);
        }
    }
}
function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}
// End product color detail list
function subcriberendofstock(submit,token,email)
{
    if(email != "")
    {
        if(validate(email) == false)
        {
             $('.theendinput').css('border','solid 1px red');
            $('.theendinput').val('');
            $('.theendinput').attr('placeholder','Email sai định dạng');
        }
        else
        {   var pid = $('.btntheend').attr('rel');
            var datastring =  'fsubmit=' +submit+'&ftoken=' +token+'&femail=' +email +'&pid='+ pid;
            $.ajax({
                type : "post",
                dataType : "html",
                url : "/site/product/subcriberendofstock",
                data : datastring,
                success : function(html){
                    if(html == 1)
                    {
                        $('.notifi').css('display','block');
                        $('.notifi').html('Chúng tôi sẽ email cho bạn khi hàng trở lại');
                        $('.theendinput').val('');
                    }
                    else
                    {
                        if(html == 2)
                        {
                         $('.theendinput').css('border','solid 1px red');
                         $('.notifi').css('display','block');
                         $('.notifi').css('color','red');
                         $('.notifi').html('Bạn đã đăng ký nhận thông tin nhận thông tin sản phẩm này khi có hàng');
                        }
                        else
                        {
                            $('.theendinput').css('border','solid 1px red');
                            $('.theendinput').val('');
                            $('.theendinput').attr('placeholder','Email sai định dạng');
                        }
                    }
                }
            });
        }
    }
    else{
        $('.theendinput').css('border','solid 1px red');
        $('.theendinput').val('');
        $('.theendinput').attr('placeholder','Vui lòng nhập email');
    }
}
function validate(email) {
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if(reg.test(email) == false)
  {
    return false;
  }
}

function ischange(){
    var ischange = $('.ismember').attr('rel');
    var reviewid = $('#reviewid').val();
    if(ischange == 'false')
    {
         var html = "";
        html += '<div class="notifireviewthumb"></div>';
        html += '<a href="javascript:void()" class="ismember" rel="true" title="" onclick="ischange()">Bình luận như là khách ?</a>';
        html += '<input name="" type="text" placeholder="Email hoặc số điện thoại" id="emailorphone">';
        html += '<input name="" type="password" placeholder="Mật khẩu" id="password">';
        html += '<input class="check" name="" checked type="checkbox" value="">';
        html += '<label>Thông báo cho tôi khi có phản hồi từ dienmay.com</label>';
        html += '<a style="float:right" href="'+rooturl+'thanh-vien/quen-mat-khau" title="" target="_blank">Quên mật khẩu</a>';
        html += '<a href="javascript:void(0)" class="btn-blues" onclick="sendReview('+reviewid+' , 0 , 2 , -1)">Gửi bình luận và đăng nhập</a>';
    }
    else
    {
        var html = "";
        html += '<div class="notifireviewthumb"></div>';
        html += '<a href="javascript:void()" class="ismember" rel="false" title="" onclick="ischange()">Đã là thành viên điện máy? Đăng nhập &#187;</a>';
        html += '<input name="" type="text" placeholder="Mời bạn nhập tên (bắt buộc)" id="username">';
        html += '<input name="" type="text" placeholder="Mời bạn nhập email (bắt buộc)" id="email">';
        html += '<input class="check" name="" checked type="checkbox" value="">';
        html += '<label>Thông báo cho tôi khi có phản hồi từ dienmay.com</label>';
        html += '<a href="javascript:void(0)" class="btn-blues" onclick="sendReview('+reviewid+' , 0 , 0 , -1)">Gửi bình luận</a>';
    }
    $('.droppost').html(html);
}
function delsearchforu(t){
    var searchitem = $(t).attr('rel');
    $.ajax({
        url: rooturl + '/search/clearsessionsearch',
        type: 'POST',
        dataType: 'html',
        data: {item: searchitem},
        success:function(data)
        {
            $(t).parent('li').remove();
        }
    });
    /*var searchforyou = getCookie('searchforu');
    searchforyou = searchforyou.split(',');
    newsearchforyou = [];
    for(var i=0;i<searchforyou.length;i++){
        if(searchitem != searchforyou[i])
        {
            newsearchforyou.push(searchforyou[i]);
        }
    }
    newsearchforyou.join(',');*/
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
            $('#comment .review-product').after(html);
            $('.loading-gif').remove();
          }
          else
          {
            $('.viewallproducts').remove();
          }
      }
    });
}
function loadUserPrepaid(pid)
{
    if ($('.bar_list_pre').length > 0 && $('.pre-statistic').length > 0) {
        $.ajax({
            url: rooturl+'product/loaduserprepaidajax',
            type: 'POST',
            dataType: 'html',
            data: {'pid': pid},
            success: function(d) {
                var data = jQuery.parseJSON(d);
                if (data.numberorder > 0) {
                    $('.pre-statistic > span').html('Đã có <strong>'+data.numberorder+'</strong> người đặt trước');
                }
                if (parseInt(data.amountremain) > 0) {
                    $('.bar_list_pre').html('Chỉ còn <b>'+data.amountremain+'</b> đơn hàng có thể đặt trước');
                }
                else {
                    $('.bar_list_pre').html('Đã có <strong>'+data.numberorder+'</strong> người đặt trước');
                }
            },
            error: function(error) {

            }
        })
    }
}

function clicknext(id) {
    var tab = $('#' + id + ' .tab.selected').attr('id');

    var tabarr = tab.split('_');

    var element = '#' + id + ' .tab_content_'+tabarr[2]+' .m-active';// .products ul>li';
    var elementnext;
    if ($(element).next().length > 0)
    {
        elementnext = $(element).next();
    }
    else
    {
        elementnext = $(element).prev();
    }

    var elements = elementnext.find('.pro_img');

    elements.each(function(index){
        var pname = $(this).attr('title');
        var src = $(this).attr('rel');
        $(this).parent().html('<img src="'+src+'" alt="'+pname+'" />');
    });
}