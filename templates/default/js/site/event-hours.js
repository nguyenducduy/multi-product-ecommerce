var chktimeout
function proccess() {
  $.ajax({
    type: 'post',
    dataType: 'html',
    url: rooturl + 'eventproducthours/indexajax',
    data: '',
    success: function (html) {
      var data = jQuery.parseJSON(html)
      //alert(data.old.k_0.name);
      var olddata = data.old
      $.each(olddata, function (i) {
        if (olddata[i].randid > 0) {
          var datahtml = "<div class='selled29'>Đã bán</div>"

          datahtml += "<div class='infoselled29'>"
          /*if(olddata[i].fullname != null){
                        datahtml += "<p>Khách hàng may mắn thứ 29 được mua sản phẩm với giá 29.000đ<br />";
                        datahtml += olddata[i].fullname+"<br />";
                        datahtml += "Số ĐT: "+olddata[i].phone+"<br />";   
                        datahtml += "Email: "+olddata[i].email+"</p>";   
                      }*/
          datahtml +=
            "<a class='inline292 userpromo0209' href='javascript:void(0)' rel=" +
            rooturl +
            'eventproducthours/listuser?pid=' +
            olddata[i].pid +
            "' >Danh sách khách hàng tham gia mua sản phẩm</a>"
          datahtml += '</div>'
          datahtml +=
            "<a href='javascript:void(0)'><img src='" +
            olddata[i].images.replace('https://ecommerce.kubil.app', 'http://s.tgdt.vn') +
            "' title='" +
            olddata[i].name +
            "' alt='" +
            olddata[i].name +
            "' /></a>"
          datahtml += "<a href='javascript:void(0)' title='" + olddata[i].name + "'>" + olddata[i].name + '</a>'
          datahtml +=
            " <div class='price29b bortop292'>Giá thị trường: <strong>" + olddata[i].price + 'đ</strong></div>'
          datahtml +=
            "<div class='price29n'>Giá bán tại dienmay.com ngày 02/09: <strong class='pricetrt1'>" +
            olddata[i].discountprice +
            'đ</strong></div>'
          $('#' + olddata[i].randid).html(datahtml)
          $('#' + olddata[i].randid).removeClass('trt1')
          $('#' + olddata[i].randid).addClass('trt2')
        }
      })
      if (typeof data.news !== 'undefined') {
        if ($('.trt1').length > 0) {
          $('.trt1').each(function () {
            $(this).removeClass('trt1')
            $(this).remove('.selling29')
            $(this).remove('.selled29')
            $(this).remove('.buy29')
            $(this).find('.price29b').removeClass('bortop291')
          })
        }
        var newdata = data.news
        var datahtml = "<div class='selled29'>Đã bán</div>"

        datahtml += '<div class="selling29">Đang bán</div>'
        datahtml +=
          '<div class="buy29"><a class="inline291 buypromo0209" href="javascript:void(0)" rel="' +
          rooturl +
          'eventproducthours/addeventuser?pid=' +
          newdata.pid +
          '">Mua ngay</a></div>'
        datahtml +=
          '<a href="javascript:void(0);"><img src="' +
          newdata.images.replace('https://ecommerce.kubil.app', 'http://s.tgdt.vn') +
          '" title="' +
          newdata.name +
          '" alt="' +
          newdata.name +
          '" /></a>'
        datahtml += '<a href="javascript:;" title="' + newdata.name + '">' + newdata.name + '</a>'
        datahtml += '<div class="price29b bortop291">Giá thị trường: <strong>' + newdata.price + 'đ</strong></div>'
        datahtml +=
          '<div class="price29n">Giá bán tại dienmay.com ngày 02/09: <strong class="pricetrt1">' +
          newdata.discountprice +
          'đ</strong></div>'
        $('#' + newdata.randid).html(datahtml)
        $('#' + newdata.randid).addClass('trt1')
        $('#' + newdata.randid).removeClass('trt2')
      } else {
        if ($('.trt1').length > 0) {
          $('.trt1').each(function () {
            $(this).removeClass('trt1')
            $(this).remove('.selling29')
            $(this).remove('.selled29')
            $(this).remove('.buy29')
            $(this).find('.price29b').removeClass('bortop291')
          })
        }
      }
      Shadowbox.init()
      clearTimeout(chktimeout)
      chktimeout = setTimeout(proccess, 60000)
    },
  })
}
$(document).ready(function () {
  proccess()
})

//
//                $('.buy_'+newdata.randid+" a").attr("rel","shadowbox;options{dimensions:height=410;width=500}");
//$('.buy_'+newdata.randid+" a").attr("href",rooturl+"eventproducthours/addeventuser?pid="+newdata.pid);
