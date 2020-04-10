<!--banner right-->
<div class="bn_right">           
        {if !empty($crazydealproduct)}
        <div id="crazydeal" {if empty($crazydealproduct)}style="display:none;"{/if}>
          <div class="typedeal">
              <h3>Crazy Deal</h3>
              <div class="wraptime">
                  <h4>Thời gian còn lại</h4>
                  <div class="dealtime" id="countbox1"></div>
              </div>
          </div>
          <div class="bndeal"><a href="{$crazydealproduct->getProductPathByPid()}" title=""><img src="{$crazydealproduct->getImage()}" /></a></div>
          <div class="buydeal"><a href="{$crazydealproduct->getProductPathByPid()}" title="Mua ngay">Mua ngay !</a></div>
          <div class="crazydeal"><a href="#" title="Crazy deal là gì ?">Crazy deal là gì <span>?</span></a>
            <div class="dropcrazy"><b>CrazyDeal</b> là chương trình giá shock mỗi ngày của dienmay.com. Theo đó, mỗi ngày chúng tôi sẽ giảm giá đến <b>50%</b> cho 01 sản phẩm bất kì.</div>
          </div>
        </div>
        {/if}
        <div id="normalbanner" class="nodeal" {if !empty($crazydealproduct)}style="display:none;"{/if}>          
          {if $rightbanner|@count > 0}
              {foreach from=$rightbanner item=rbanner name=rightbannername}
                  <a href="{$rbanner->getAdsPath()}"  title="{$rbanner->title|escape}">
                      <img src="{$rbanner->getImage()}" alt="{$rbanner->title|escape}" title="{$rbanner->title|escape}" />
                  </a>
                  {if $smarty.foreach.rightbannername.iteration==1}{break}{/if}
              {/foreach}        
          {/if}
        </div>      
</div>
<!-- banner left -->
<div class="bn_left">
{if $slidebanner|@count > 0}
	<div class="device">
      <a class="arrow-left" href="#">«</a> 
      <a class="arrow-right" href="#">»</a>
      <!-- the slider -->
      <div class="swiper-container">
        <div class="swiper-wrapper">
        <!-- the items -->
        {foreach from=$slidebanner item =slide name =slideshowbanner}
        {if $smarty.foreach.slideshowbanner.first}
         <div class="swiper-slide">
          <a href="{$slide->getAdsPath()}" title="{$slide->title|escape}"><img src="{$slide->getImage()}" alt="{$slide->title|escape}"></a>
        </div>
        {else}
       <div class="swiper-slide">
          <a href="{$slide->getAdsPath()}" title="{$slide->title|escape}"><img src="{$slide->getImage()}" alt="{$slide->title|escape}"></a>
        </div>
        {/if}
        {if $smarty.foreach.slideshowbanner.iteration==8}{break}{/if}
        {/foreach}
      </div>
     
      <!-- the controls -->
      </div>
       <div class="pagination"></div>
    </div>
    {/if}
</div>
{literal}
<script type="text/javascript">
    var pid = "{/literal}{$crazydealproduct->pid}{literal}";
    var fpcid = "{/literal}{$crazydealproduct->pcid}{literal}";
    $(document).ready(function() {
        if($('#crazydeal').length > 0){
        var dateFuture1 = '';
        $.post( rooturl+"product/gettimecrazydeal",{fpid:pid,fpcid:fpcid}, function(data) {
            var tmpdatetime = data.split(' ');
            var date = tmpdatetime[0].split('-');
            var time = tmpdatetime[1].split(':');
            dateFuture1 = new Date(date[0],date[1]-1,date[2],time[0],time[1],time[2]); 
            GetCount(dateFuture1,'countbox1');
        });      
        }
    });

    function GetCount(ddate,iid){

    dateNow = new Date(); //grab current date
    amount = ddate.getTime() - dateNow.getTime(); //calc milliseconds between dates
    delete dateNow;
    // if time is already past
    if(amount < 0){
       $.post( rooturl+"product/updatestatusandpromotion",{fpid:pid,fpcid:fpcid}, function(data) {
          if(data == 1)
          {
            $('.crazydetail').remove();
            $('.datesatus').remove();
            $('.dealtime').remove();
           
            //location.reload();
            $("#crazydeal").hide();
            $("#normalbanner").show();
          }
       });      
    }
    // else date is still good
    else{
      hours=0;mins=0;secs=0;out="";

      amount = Math.floor(amount/1000);

      hours=Math.floor(amount/3600);
      amount=amount%3600;

      mins=Math.floor(amount/60);
      amount=amount%60;

      secs=Math.floor(amount);//seconds

      if(hours != 0){out +="<div class='hours'>"+ hours +" "+((hours==1)?" ":"H")+" </div>  ";}
        out +="<div class='mins'>"+ mins +" "+((mins==1)?" ":" ' ")+" </div> ";
        out +="<div class='secs'>"+ secs +" "+((secs==1)?" ":" s ")+"</div>  ";
      out = out.substr(0,out.length-2);
      document.getElementById(iid).innerHTML=out;

      setTimeout(function(){GetCount(ddate,iid)}, 1000);
    }
  }
</script>
{/literal}
