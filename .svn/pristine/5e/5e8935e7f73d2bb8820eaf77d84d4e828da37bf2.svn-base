<link type="text/css" rel="stylesheet" href="{$currentTemplate}css/site/giare.css" media="screen" />
<p class="clear">&nbsp;</p>
<p class="clear">&nbsp;</p>
<div id="close_mua_ngay">
<form action="{$formurl}" method="post" id="popupsharing">
    <div class="font14" style="float:left; width:345px; margin-right:30px;">"Like hoặc chia sẻ chương trình để mua được giá sốc:</div>
    <div style="float:left;">
        <div style="width: 90px; margin-left: 0px; float: left; display: block;">
            <fb:like href="{$conf.rooturl}giare" send="false" layout="button_count" width="75" show_faces="false"></fb:like>
        </div>
        <div style="width: 90px; margin-left: 0px; float: left; display: block;">
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-callback="clickgplus" data-href="{$conf.rooturl}giare"></div>

            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">
              (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>
        </div>
        <div style="margin-left: 0px; float: left; display: block;">hoặc nhập 2 email "<br><br></div>
    </div>
    
   <div style="float:left;"> 
   Email 1:<input class="propnput" name="email1" id="email1" placeholder="Địa chỉ email 1" type="text">
   Email 2:<input class="propnput" name="email2" id="email2" placeholder="Địa chỉ email 1" type="text">
  </div>
  <div><input class="btngame field_mua_ngay" style="margin-right:20px;margin-top: 9px;" name="btnshare" id="buttonshared" value="Chia sẻ" type="button"></div>
</form>    
</div>
<div id="fb-root"></div>
{literal}
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
function clickgplus(plusone){
    if (plusone.state == "on") {
        $.post(rooturl + 'giare/checkvalidation', {likegplus: 1}, function(){
           parent.$("#sb-wrapper").width(800); 
           parent.$("#sb-wrapper").css('top', 5); 
           parent.$("#sb-body").height(600);           
           window.location.href = $('#popupsharing').attr('action');
        });        
    }
}
window.fbAsyncInit = function() {
    FB.init({
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    FB.Event.subscribe('edge.create', function(href, widget) {
        $.post(rooturl + 'giare/checkvalidation', {likefb: 1}, function(){
           parent.$("#sb-wrapper").width(800); 
           parent.$("#sb-wrapper").css('top', 5); 
           parent.$("#sb-body").height(600);           
           window.location.href = $('#popupsharing').attr('action');
        }); 
    });
};
$(document).ready(function(){
    $('#buttonshared').unbind('click').click(function(){
        var email1 = $('#email1').val();
        var email2= $('#email2').val();
        if(email1 != '' && email2 != '' && email1 != email2)
        {
            $.post(rooturl + 'giare/checkvalidation', {email1: email1, email2: email2}, function(data){
               if(data) 
               {
                   if(data.error == 1 && data.message)
                   {
                        nalert(data.message);
                   }
                   else if(data.success == 1)
                   {
                       parent.$("#sb-wrapper").width(800); 
                       parent.$("#sb-wrapper").css('top', 5); 
                       parent.$("#sb-body").height(600);           
                       window.location.href = $('#popupsharing').attr('action');
                   }
               }
            }, 'json');
        }
        else nalert('Vui lòng nhập đủ 2 email giới thiệu hợp lệ');
    });
});
</script>
{/literal}