var chktimeout;
function proccess()
{
    $.ajax({
          type : "post",
          dataType : 'html',
          url : rooturl + 'eventproducthours/indexajax',
          data : '',
          success : function(html){
          	  var data = jQuery.parseJSON(html);
          	  //alert(data.old.k_0.name);
              var olddata = data.old;
              $.each(olddata,function(i){
                if(olddata[i].randid > 0 )
                {
                      var datahtml = " <div class='sold33'><i class='ico-sold'></i></div>";

                      datahtml += "<div class='infocustom33'>";
                      /*if(olddata[i].fullname != null){
                        datahtml += "<p>Khách hàng may mắn thứ 29 được mua sản phẩm với giá 29.000đ<br />";
                        datahtml += olddata[i].fullname+"<br />";
                        datahtml += "Số ĐT: "+olddata[i].phone+"<br />";   
                        datahtml += "Email: "+olddata[i].email+"</p>";   
                      }*/
                      datahtml += "<a class='inline292 userpromo0209' href='javascript:void(0)' rel="+rooturl+"eventproducthours/listuser/pid/"+olddata[i].pid+"' >Danh sách khách hàng tham gia mua sản phẩm</a>";
                      datahtml += "</div>";
                      datahtml += "<a href='javascript:void(0)'><img src='"+olddata[i].images +"' title='"+olddata[i].name+"' alt='"+ olddata[i].name+"' /></a>";                       
                      datahtml += "<div class='title-pr'><a href='javascript:void(0)' title='"+olddata[i].name+"'>"+olddata[i].name+"</a></div>";
                      datahtml += "<div class='bottom-pr'>";
                      datahtml += "<div class='price'><span>Giá sinh nhật dienmay.com (dành cho người thứ 33)</span><br>"+olddata[i].discountprice+" VNĐ</div>"; 
                      datahtml += " <div class='price-throught'>Giá thị trường<br> <span>"+olddata[i].price+" VNĐ</span></div>";
                      datahtml += "</div>";
                      $('#'+olddata[i].randid).html(datahtml);
                      $('#'+olddata[i].randid).removeClass("trt1");
                      $('#'+olddata[i].randid).addClass("trt2");
                      $('#'+olddata[i].randid).addClass("pro-end");
                  }
              });
              if(typeof data.news !== 'undefined')
              {
        					if ($('.trt1').length > 0)
        					{
        						$('.trt1').each(function(){
        							$(this).removeClass('trt1');
        							$(this).remove('.selling29');
        							$(this).remove('.selled29');
        							$(this).remove('.buy29');
        							$(this).find('.price29b').removeClass('bortop291');
        						});
        					}
        					var newdata = data.news;
        					var datahtml = "";
        					datahtml += '<div class="sold33"><i class="ico-sell selling29"></i></div>';         
                  datahtml += '<div class="buy29 buy33"><a class="inline291 buypromo0209" href="javascript:void(0)" rel="'+rooturl+'eventproducthours/addeventuser?pid='+newdata.pid+'">Mua ngay</a></div>';  
                  datahtml += '<a href="javascript:void(0);"><img src="'+newdata.images+'" title="'+newdata.name+'" alt="'+newdata.name+'" /></a>';  
                  datahtml += '<div class="title-pr"><a href="#" title="'+newdata.name+'">'+newdata.name+'</a></div>';
                  datahtml += ' <div class="bottom-pr">';
                  datahtml += "<div class='price'><span>Giá sinh nhật dienmay.com (dành cho người thứ 33)</span><br>"+newdata.discountprice+" VNĐ</div>"; 
                  datahtml += " <div class='price-throught'>Giá thị trường<br> <span>"+newdata.price+" VNĐ</span></div>";
                  datahtml += '</div>';
        					$('#'+newdata.randid).html(datahtml);
        					$('#'+newdata.randid).addClass("trt1");
        					$('#'+newdata.randid).removeClass("trt2");          
              }
              else
              {
        				if ($('.trt1').length > 0)
        				{
        					$('.trt1').each(function(){
        						$(this).removeClass('trt1');
        						$(this).remove('.selling29');
        						$(this).remove('.selled29');
        						$(this).remove('.buy29');
        						$(this).find('.price29b').removeClass('bortop291');
        					});
        				}
              }
              Shadowbox.init();
              clearTimeout(chktimeout);
              chktimeout = setTimeout(proccess, 30000);
          }
    });
}
$(document).ready(function(){
      proccess();      
})

// 
//                $('.buy_'+newdata.randid+" a").attr("rel","shadowbox;options{dimensions:height=410;width=500}");
//$('.buy_'+newdata.randid+" a").attr("href",rooturl+"eventproducthours/addeventuser?pid="+newdata.pid);   