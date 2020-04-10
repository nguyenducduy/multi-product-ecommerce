//end get countdown
function readfullsumary(){
  var htmlcontent = $('#attrfull').html();
  htmlcontent = '<div class="conttable">' + htmlcontent + '</div>';
  Shadowbox.open({
      content :   htmlcontent,
      player:     "html",
      height:     800,
      width:      820
  });
};
function clickimage(t){
	$('.active').removeClass('active');
	$('#360sprite').remove();
 	$('#zoomslide > .fixzoomvideo').remove();
 	$('#zoomslide > .fixzoom').css("display","block");
 	$('.zoomContainer').css("display","block");
 	// Get on screen image

	// Create new offscreen image to test
	var theImage = new Image();
	theImage.src = $(t).parent().attr('data-zoom-image');
	// Get accurate measurements from that.
	var imageWidth = theImage.width;
	if(parseInt(imageWidth) < 400)
	{
		$('.zoomContainer').css('display','none');
	}
	else
	{
		$('.zoomContainer').css('display','block');
	}
};
$(function() {
	if($('.qtootip').length > 0)
		$('.qtootip').tipsy({gravity: 'w'});
	// Carousel
	if($('.m-carousel').length > 0)
		$('.m-carousel').carousel();
	
	// tabs 
	$('.tabscontainer').each(function(){
		var idobj = $(this).attr('id');
		$("#"+idobj+" .tabs .tab[id^=tab_menu]").hover(function() {
			var curMenu=$(this);
			//alert(curMenu.className.indexOf('selected'));
			if($(this).hasClass('selected') == false){
				$("#"+idobj+" .tabs .tab[id^=tab_menu]").removeClass("selected");
				curMenu.addClass("selected");
		
				var index=curMenu.attr("id").split("tab_menu_")[1];
				$("#"+idobj+" .tabcontent").css("display","none");
				$("#"+idobj+" .tab_content_"+index).fadeIn(400);//.css("display","block");
			}
		},function() {
		    $( this ).find( "span:last" ).remove();
		  });
	});
	Element.prototype.hasClass = function(className) {
    return this.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(this.className);
};
	//cloud zoom
	$("#zoom").elevateZoom({
		gallery : "zoomslide",
		galleryActiveClass: "active",
		easing:true,
	});
	$('#zoom_01').elevateZoom({
		zoomType: "inner",
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750,
		easing:true
	});
	if($('.fixzoom').length > 0)
	{
		setTimeout(zoomremove,500);
	}
	function zoomremove(){
		// Get on screen image
		var screenImage = $("#zoom");

		// Create new offscreen image to test
		var theImage = new Image();
		theImage.src = screenImage.attr("data-zoom-image");

		// Get accurate measurements from that.
		var imageWidth = theImage.width;
		if(parseInt(imageWidth) < 400)
		{
			$('.zoomContainer').css("display","none");
		}
	}
	// slide gallery
	if($('.doubleSlider-1').length > 0){
		$('.doubleSlider-1').iosSlider({
					scrollbar: true,
					snapToChildren: true,
					desktopClickDrag: true,
					infiniteSlider: true,
					navPrevSelector: $('.doubleSliderPrevButton'),
					navNextSelector: $('.doubleSliderNextButton'),
					scrollbarHeight: '2',
					scrollbarBorderRadius: '0',
					scrollbarOpacity: '0.5',
					onSliderLoaded: doubleSlider2Load,
					onSlideChange: doubleSlider2Load,
					autoSlide:false,
					autoSlideTimer: 1500,
					autoSlideTransTimer: 500,
				});
	}
	if($('.doubleSlider-2').length > 0)	{
				$('.doubleSlider-2 .button').each(function(i) {
				
					$(this).bind('click', function() {

						$('.doubleSlider-1').iosSlider('goToSlide', i+1);
						
					});
				
				});
				
				$('.doubleSlider-2').iosSlider({
					desktopClickDrag: true,
					snapToChildren: true,
					snapSlideCenter: true,
					infiniteSlider: true
				});
	}
	function doubleSlider2Load(args) {
		
		//currentSlide = args.currentSlideNumber;
		$('.doubleSlider-2').iosSlider('goToSlide', args.currentSlideNumber);
		
		/* update indicator */
		$('.doubleSlider-2 .button').removeClass('actived');
		$('.doubleSlider-2 .button:eq(' + (args.currentSlideNumber-1) + ')').addClass('actived');
		
	}
				
	  
	//popup
	
	// hide #back-top first
	$("#back-top").hide();
	// fade in #back-top
		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
		$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 900) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
	// stick top
	setTimeout(lockfix,1000);
	function lockfix()
	{
		var accessoryheight = $('#accessory').height();
		var comment = $('#comment').height();
		var keys = $('#keys').height();
		var brand = $('#brand').height();
		var copyright = $('#copyright').height();
		var footer = $('#footer').height();
		var infobrand = $('#infobrand').height();
		var interested = $('#interested').height();
		var positiontop = accessoryheight + comment + keys + brand + copyright + footer + infobrand + interested;
		//console.log('acc:'+accessoryheight + 'comment' + comment + 'keys' + keys + 'brand' + brand  + 'copyright:'+ copyright + 'footer:'+footer);
		$.lockfixed(".related",{offset: {top:48, bottom: positiontop+ 200}});
	}
	$.lockfixed(".tskt",{offset: {top:0,}});
	//sticky top snap id	
	if($('.post__article').length > 0)
	{
		$('.post__article').scrollNav({
			headlineText: 'srollNav',
			fixedMargin: 60,
			scrollOffset: 80,
			arrowKeys: false,
		});
		var $item = $('.scroll-nav__item');
		$.each($item, function(){
			$text = $(this).find('a').html().toLowerCase();
			$(this).addClass($text);
		});
	}
	//GetCount(dateFuture1, 'countbox1');

});

//Nguyen Ngoc Luong
function addsubpopup(t,gender)
{
	var genders = gender;
	var email = $('#subemail').val();
	var name = $('#subname').val();
	if(email!='' && name != '')
	{
		$.ajax({
			type : "POST",
			data : {action:"addsub",femail:email,fname:name,fgender:genders},
			url : rooturl+'index/subcriberpopup',
			dataType: "html",
			success: function(data){
				if(data=='ok')
				{
					$('.notificationsub').css('display','none');
					var html = '';
					html += '<p>Cảm ơn bạn, Hãy kiểm tra email để xác nhận để hoàn tất việc đăng ký nhận tin</p>';
					html += '<p><i>Lưu ý:</i> Kiểm tra trong mục spam nếu không thấy trong inbox</p>';
					html += '<p>Cửa số này sẽ đóng trong vòng 7s</p>';
				    html += '<a class="close" style="cursor:pointer">&#120;</a>';
				    $('.popupsub .form').html(html);
				    $('.popupsub').delay(7000).fadeOut();
					createCookie('subcriber',1,30);
	        		$(t).parent().parent().animate({ "bottom": "-100px",opacity: 0 }, 100);
	        		$(t).parent().parent().css('display','none');
				}
				if(data=='ext')
				{
					$('.notificationsub').css('display','block');	
					$('.notificationsub').html('Email của bạn đã tồn tại trong danh sách nhận tin');
					$('.notificationsub').addClass('error');
					$('#subemail').attr('style','border-color: red');
				}
				if(data=='err')
				{
					$('.notificationsub').css('display','block');
					$('.notificationsub').html('Sai định dạng email');
					$('.notificationsub').addClass('error');
					$('#subemail').attr('style','border-color: red');
				}
			}
		});
	}
	else
	{
		$('.notificationsub').css('display','block');
		$('.notificationsub').html('Vui lòng nhập thông tin đầy đủ');
		$('.notificationsub').addClass('error');
		$('#subemail').attr('style','border-color: red');
		$('#subname').attr('style','border-color: red');
	}
}

