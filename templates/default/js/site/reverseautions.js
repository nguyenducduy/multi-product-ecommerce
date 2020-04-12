if ($('#360thumb').length > 0) {
  var framess = []
  for (var i = 1; i <= 36; i++) {
    framess.push(image360path.replace('#', i))
  }
}
$(document).ready(function () {
  // Setinterval cap nhat trang thai san pham
  //updateStatuBuying();
  setInterval(function () {
    updateStatuBuying()
  }, 15000)
  //End setinterval
  //Creazydeal
  $('.likepage span').html(
    '<iframe src="https://www.facebook.com/plugins/like.php?href=https://facebook.com/dienmaycom&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px; float:left" allowTransparency="true"></iframe>'
  )
  var dateFuture1 = ''
  $.post(rooturl + 'reverseauctions/gettimeauction', { fpid: pid }, function (data) {
    if (data != 0) {
      var tmpdatetime = data.split(' ')
      var date = tmpdatetime[0].split('-')
      var time = tmpdatetime[1].split(':')
      dateFuture1 = new Date(date[0], date[1] - 1, date[2], time[0], time[1], time[2])
      if ($('#countbox1').length > 0) GetCount(dateFuture1, 'countbox1')
    }
  })

  //End crazydeal

  $('.cell360px').bind('click', function (event) {
    $('#360sprite').addClass('loadingframe')
    $('.slider > img').css('display', 'none')
    $('.actived').removeClass('actived')
    $(this).addClass('actived')
    $('#360frames').remove()
    var doubleslider = $('.doubleSlider-1')
    doubleslider.prepend('<div id="360frames"></div>')
    xoay360(framess)
    $('.loadingframe').removeClass('loadingframe')
  })
  $('.thumnail > img').click(function (event) {
    $('.slider > img').css('display', 'block')
    $('#360frames').remove()
  })
  $('#360thumb a').bind('click', function () {
    $('.active').removeClass('active')
    $(this).parent().addClass('active')
    $('#zoomslide > .fixzoom ').css('display', 'none')
    if ($('#zoomslide .fixzoomvideo > iframe').length > 0) $('#zoomslide .fixzoomvideo').remove()
    if ($('#360sprite').length > 0) $('#360sprite').remove()
    $('#zoomslide').prepend('<div id="360sprite" class="image360">')
    $('.zoomContainer').css('display', 'none')
    xoay360thumb(framess)
  })
  $('#videothumb a').bind('click', function () {
    $('.active').removeClass('active')
    $(this).parent().addClass('active')
    $('#zoomslide > .fixzoom').css('display', 'none')
    if ($('#360sprite').length > 0) $('#360sprite').remove()
    if ($('#zoomslide .fixzoomvideo > iframe').length > 0) $('#zoomslide .fixzoomvideo').remove()
    var url = $('.contentvideo').val()
    $('#zoomslide').prepend(
      '<div class="fixzoomvideo"><iframe width="400" height="380" frameborder="0" allowfullscreen="" src="' +
        url +
        '"></iframe></div>'
    )
    $('.zoomContainer').css('display', 'none')
  })
})
function updateStatuBuying() {
  $.post(rooturl + 'reverseauctions/updatestatubuying', { fpid: pid }, function (data) {
    if (parseInt(data) == 1) {
      location.reload()
    }
  })
}
function GetCount(ddate, iid) {
  dateNow = new Date() //grab current date
  amount = ddate.getTime() - dateNow.getTime() //calc milliseconds between dates
  delete dateNow
  // if time is already past
  if (amount < 0) {
    $.post(rooturl + 'reverseauctions/updatecacher', { fpid: pid }, function (data) {
      if (data == 1) {
        location.reload()
      }
    })
  }
  // else date is still good
  else {
    hours = 0
    mins = 0
    secs = 0
    out = ''

    amount = Math.floor(amount / 1000)

    hours = Math.floor(amount / 3600)
    amount = amount % 3600

    mins = Math.floor(amount / 60)
    amount = amount % 60

    secs = Math.floor(amount) //seconds

    if (hours != 0) {
      out += "<div style='float:left'><span>" + hours + '</span><strong>:</strong><b>Giờ</b></div>'
    }
    out += "<div style='float:left'><span>" + mins + ' </span><strong>:</strong><b>Phút</b></div>'
    out += " <div style='float:left'><span>" + secs + '</span><b>Giây</b></div></div>  '
    out = out.substr(0, out.length - 2)
    document.getElementById(iid).innerHTML = out

    setTimeout(function () {
      GetCount(ddate, iid)
    }, 1000)
  }
}

function showpopupreverseautions(id) {
  Shadowbox.open({
    content: rooturl + 'site/reverseauctions/adduser/pid/' + id,
    player: 'iframe',
    options: {
      modal: true,
      onClose: function () {
        //add code here to get new link?
        window.location.reload()
      },
    },
    height: 450,
    width: 590,
  })
}

function showpopuplistuser(id) {
  Shadowbox.open({
    content: rooturl + 'site/reverseauctions/listuser/pid/' + id,
    player: 'iframe',
    options: {
      modal: true,
    },
    height: 500,
    width: 590,
  })
}
function showpopupthele() {
  Shadowbox.open({
    content: rooturl + 'site/reverseauctions/thele',
    player: 'iframe',
    options: {
      modal: true,
    },
    height: 500,
    width: 590,
  })
}
