$(function() {
    $(".question").unbind('click').click(function(){
        //$(".panel").slideToggle();
        $(this).parent().parent().find(".answer").slideToggle();
    });
    $(".question2").unbind('click').click(function(){
        //$(".panel2").slideToggle();
        $(this).parent().parent().find(".answer2").slideToggle();
    });
	
	 $(".question3").unbind('click').click(function(){
        $(this).parent().parent().find(".answer3").slideToggle();
    });
	
	$(".question4").unbind('click').click(function(){
        $(this).parent().parent().find(".answer4").slideToggle();
    });
	
	$(".question5").unbind('click').click(function(){
        $(this).parent().parent().find(".answer5").slideToggle();
    });
	
	$(".question6").unbind('click').click(function(){
        $(this).parent().parent().find(".answer6").slideToggle();
    });
	
	
    if($('.sticky_navigation').length>0){
        // grab the initial top offset of the navigation 
        var sticky_navigation_offset_top = $('.sticky_navigation').offset().top;
        
        // our function that decides weather the navigation bar should have "fixed" css position or not.
        var sticky_navigation = function(){
            var scroll_top = $(window).scrollTop(); // our current vertical position from the top
            
            // if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
            if (scroll_top > sticky_navigation_offset_top) { 
                $('.sticky_navigation').css({ 'position': 'fixed', 'top':0, 'z-index':888 });
            } else {
                $('.sticky_navigation').css({ 'position': 'relative' }); 
            }   
        };
        
        // run our function on load
        sticky_navigation();
        // and run it again every time you scroll
        $(window).scroll(function() {
             sticky_navigation();
        });
    }
	
	// NOT required:
	// for this demo disable all links that point to "#"
	$('a[href="#"]').click(function(event){ 
		event.preventDefault(); 
	});
	
    $('.menufeature').onePageNav({
        begin: function() {
        console.log('start')
        },
        end: function() {
        console.log('stop')
        }
    });
    $('.menufeature2').onePageNav({
        begin: function() {
            console.log('start')
        },
        end: function() {
            console.log('stop')
        }
    });
    $('.vip-menu').onePageNav({
		begin: function() {
		console.log('start')
		},
		end: function() {
		console.log('stop')
		}
	});
});

function checkpoint(){
	var fname = $('#fullname');
	var fphone = $('#phonenum');
	if(fname.length > 0 && fphone.length > 0)
	{
		$.post(rooturl + 'vip/checkpoint', {fname: fname.val(), fphone: fphone.val()}, function(data){
			if(data && data.success == 1)
			{
				if($('#responsepoint').length > 0) {$('#responsepoint').remove();}
				$('#checkpointform').after('<div class="form-title" id="responsepoint"><p class="clear">&nbsp;</p>Bạn đã tích lũy được <font color="#F05C37" size="5">'+data.fpoint+'</font> điểm</div>');
			}
			else if(data && data.error == 1)
			{
				 nalert(data.message, 'Lỗi');
			}
			else nalert('Không tìm thấy thông tin bạn đã cung cấp', 'Lỗi');
		},'json');
	}
	else {
		nalert('Vui lòng nhập họ tên và số điện thoại để kiểm tra', 'Lỗi');
	}
}