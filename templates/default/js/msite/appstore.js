$(function () {
  $('.menu-icon').click(function () {
    $('.drop-down').stop(true, false).slideToggle('fast')
  })

  $('.menu').click(function () {
    $(this).next('.dropdown').slideToggle('fast')
    return false
  })

  $('.close').click(function () {
    $(this).parent('ul').parent('.dropdown').slideToggle('fast')
  })

  // popup
  /*$(".iframe").colorbox({iframe:true, width:"90%", height:"80%"});*/

  //Featured Slide
  var featuredSwiper = $('.featured').swiper({
    slidesPerView: 'auto',
    centeredSlides: true,
    initialSlide: 7,
    tdFlow: {
      rotate: 30,
      stretch: 10,
      depth: 150,
    },
  })

  //Thumbs
  $('.thumbs-cotnainer').each(function () {
    $(this).swiper({
      slidesPerView: 'auto',
      offsetPxBefore: 25,
      offsetPxAfter: 10,
      calculateHeight: true,
    })
  })

  //Banners
  $('.banners-container').each(function () {
    $(this).swiper({
      slidesPerView: 'auto',
      offsetPxBefore: 25,
      offsetPxAfter: 10,
    })
  })

  // them du doan gia
  var currentQuestion = $('.p3question #answesitem').length
  if (currentQuestion > 0) {
    var page = 1
    var fpgid = $('#answesitem').attr('data-id')
    var url = rooturl + 'product/loadquestion'
    $('.guessloading').css('display', 'block')
    var data = {
      action: 'loadquestion',
      page: page,
      fpgid: fpgid,
    }

    $.ajax({
      type: 'POST',
      data: data,
      url: url,
      dataType: 'html',
      success: function (data) {
        if (data != '') {
          $('.guessloading').css('display', 'none')
          $('#answesitem').html(data)
        }
      },
    })
  }

  var question = 2
  var arrayanswer = new Array()
  $('body').on('click', '#next', function () {
    var fpgid = $(this).attr('data-id')
    var totalquestion = $(this).attr('rel')
    var answer = $('.p3question input:checked').val()
    var answertext = $('#answertext').val()

    if (answer == 'true') {
      if (question <= totalquestion) {
        var url = rooturl + 'product/nextquestion'
        $('.guessloading').css('display', 'block')
        var data = {
          action: 'nextquestion',
          question: question,
          fpgid: fpgid,
          totalquestion: totalquestion,
        }
        $.ajax({
          type: 'POST',
          data: data,
          url: url,
          dataType: 'html',
          success: function (data) {
            if (data != '') {
              $('.guessloading').css('display', 'none')
              question = question + 1
              $('#answesitem').html(data)
            }
          },
        })

        $('.p3alert').text('')
      } else {
        var htmlinfo =
          '<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="https://ecommerce.kubil.app/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>'
        htmlinfo +=
          '<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input maxlength="15" id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><div class="clear"></div>'
        htmlinfo +=
          '<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>'
        htmlinfo +=
          '<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" checked value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>'
        htmlinfo +=
          '<div class="btn-step"><a data-id="' +
          fpgid +
          '" rel="' +
          answertext +
          '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>'
        htmlinfo += '<label class="loadinggif p3alert guessloading"></label>'
        $('.p3question').html(htmlinfo)
        $('.p3alert').text('')
      }
    } else if (answer == 'false') {
      $('.p3alert').text('Ừm...có vẻ như bạn chọn chưa đúng.')
    } else if (typeof answer == 'undefined' && typeof answertext == 'undefined') {
      $('.p3alert').text('Bạn chưa chọn câu trả lời')
    } else {
      if (isNaN(answertext)) {
        $('#answertext').addClass('errorborder')
        $('#answertext').focus()
        $('.p3alert').text('Bạn chưa nhập số người')
      } else if (answertext != '') {
        if (question <= totalquestion) {
          var url = rooturl + 'product/nextquestion'
          $('.guessloading').css('display', 'block')
          var data = {
            action: 'nextquestion',
            question: question,
            fpgid: fpgid,
            totalquestion: totalquestion,
          }
          $.ajax({
            type: 'POST',
            data: data,
            url: url,
            dataType: 'html',
            success: function (data) {
              if (data != '') {
                $('.guessloading').css('display', 'none')
                question = question + 1
                $('#answesitem').html(data)
              }
            },
          })

          $('.p3alert').text('')
        } else {
          var htmlinfo =
            '<strong>Thông tin liên hệ</strong><span>Mời bạn để lại thông tin để nhận thông báo khi <i><a href="https://ecommerce.kubil.app/" target="_blank" style="text-decoration:none;color:#00a1e6"><b>dienmay</b>.com</a></i> công bố kết quả</span>'
          htmlinfo +=
            '<input id="ffullname" class="p3input2" name="ffullname" type="text" placeholder="Họ và tên bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="fphoneguess" class="p3input2" name="fphone" type="text" placeholder="Điện thoại của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="femail" class="p3input2" name="femail" type="text" placeholder="Email của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<input id="faddress" class="p3input2" name="faddress" type="text" placeholder="Địa chỉ của bạn"><div class="clear"></div>'
          htmlinfo +=
            '<label class="p3check"><input id="fcheckproduct" class="check" name="fcheckproduct" type="checkbox" checked value="1">Nhận thông báo qua email và tin nhắn khi sản phẩm này được bán</label><div class="clear"></div>'
          htmlinfo +=
            '<label class="p3check"><input id="fcheckfull" class="check" name="fcheckfull" type="checkbox" value="1">Nhận thông báo qua email về các chương trình khuyến mãi khác của dienmay.com</label><div class="clear"></div>'
          htmlinfo +=
            '<div class="btn-step"><a data-id="' +
            fpgid +
            '" rel="' +
            answertext +
            '" id="confirm_info" href="javascript:;">Hoàn tất</a></div>'
          htmlinfo += '<label class="loadinggif p3alert guessloading"></label>'
          $('.p3question').html(htmlinfo)
          $('.p3alert').text('')
        }
      } else {
        $('#answertext').addClass('errorborder')
        $('#answertext').focus()
        $('.p3alert').text('Bạn chưa dự đoán số người trả lời giống bạn.')
      }
    }
  })

  $('body').on('click', '#confirm_info', function () {
    var fpgid = $(this).attr('data-id')
    var answertext = $(this).attr('rel')

    var ffullname = $('#ffullname').val()
    var femail = $('#femail').val()
    var fphone = $('#fphoneguess').val()
    var faddress = $('#faddress').val()

    var flag = true

    if (faddress == '' || faddress == null) {
      $('#faddress').addClass('errorborder')
      $('#faddress').focus()
      $('.alertaddress').text('Vui lòng nhập địa chỉ')
      flag = false
    }
    $('#faddress').change(function () {
      $('#faddress').removeClass('errorborder')
      $('.alertaddress').text('')
      flag = true
    })

    var atpos = femail.indexOf('@')
    var dotpos = femail.lastIndexOf('.')
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= femail.length) {
      $('#femail').addClass('errorborder')
      $('#femail').focus()
      $('.alertemail').text('Email không đúng định dạng')
      flag = false
    }
    $('#femail').change(function () {
      $('#femail').removeClass('errorborder')
      $('.alertemail').text('')
      flag = true
    })

    if (fphone.value == '') {
      $('#fphoneguess').addClass('errorborder')
      $('#fphoneguess').focus()
      $('.alertphone').text('Vui lòng nhập số điện thoại')
      flag = false
    } else if (isNaN(parseInt(fphone))) {
      $('#fphoneguess').addClass('errorborder')
      $('#fphoneguess').focus()
      $('.alertphone').text('Số điện thoại không đúng')
      flag = false
    }
    $('#fphoneguess').change(function () {
      $('#fphoneguess').removeClass('errorborder')
      $('.alertphone').text('')
      flag = true
    })

    if (ffullname == '' || ffullname == null) {
      $('#ffullname').addClass('errorborder')
      $('#ffullname').focus()
      $('.alertfullname').text('Vui lòng nhập họ tên')
      flag = false
    }
    $('#ffullname').change(function () {
      $('#ffullname').removeClass('errorborder')
      $('.alertfullname').text('')
      flag = true
    })

    var fcheckproduct = $('#fcheckproduct:checked').val()
    if (fcheckproduct == 'undefined') {
      fcheckproduct = 0
    }
    var fcheckfull = $('#fcheckfull:checked').val()
    if (fcheckfull == 'undefined') {
      fcheckfull = 0
    }
    if (flag == true) {
      var url = rooturl + 'product/saveinfoguess'
      $('.guessloading').css('display', 'block')
      var data = {
        action: 'saveinfoguess',
        ffullname: ffullname,
        femail: femail,
        fphone: fphone,
        faddress: faddress,
        fnewsletterproduct: fcheckproduct,
        newsletter: fcheckfull,
        fpgid: fpgid,
        fanswer: answertext,
      }
      $.ajax({
        type: 'POST',
        data: data,
        url: url,
        dataType: 'json',
        success: function (data) {
          if (data.error == 0) {
            $('.guessloading').css('display', 'none')
            $('.p3question').html(data.html)
          } else if (data.error == -2) {
            $('.guessloading').css('display', 'none')
            $('.p3question').html(data.html)
          }
        },
      })

      $('.p3alert').text('')
    }
  })
})
