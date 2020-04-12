                   <div class="space"></div>
                    <div class="yellow-bg-bottom">
                    	<div class="col">
                        {if !empty($user_profile)}
                        	<h5>Xin chào bạn</h5>
                            <div class="user-login">
                            	<div class="ava-login"><img width="32" src="{$user_profile['avatar']}"></div>
                                <div class="user">{$user_profile['name']}<br/><a href="{$conf.rooturl}productyear/logout">Thoát</a></div>
                                
                            </div>
                        {else}
                        <h4>Đăng nhập để viết bài đánh giá</h4>
                            <div class="buton-log">
                            	<a href="{$conf.rooturl}productyear/loginfacebook"><img src="{$currentTemplate}images/site/bt-face.png"></a>
                            </div>
                            <div class="buton-log">
                            	<a href="{$conf.rooturl}productyear/logingoogle"><img src="{$currentTemplate}images/site/bt-gg.png"></a>
                            </div>
                        {/if}
                        </div>
                        <div class="col2">
                        	
                            <input onclick="showrule()" class="bt-x" type="button" value="Xem thể lệ">
                        </div>
                        <div class="col3">
                        	<h1>Chia sẻ</h1>
                              <div class="block-ico">
                            	<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$conf.rooturl}product-of-the-year"><img src="{$currentTemplate}images/site/ico-face.png"></a>
                                <a target="_blank" href="https://plus.google.com/share?url={$conf.rooturl}product-of-the-year"><img src="{$currentTemplate}images/site/ico-gg.png"></a>
                                <div class="likefb"><iframe src="http://www.facebook.com/plugins/like.php?href= &width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:120px; height:21px; float:left" class="likepage"></iframe>
           						 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>          
<script type="text/javascript">
function showrule(id)
{
	Shadowbox.open({
        content:    rooturl + 'site/productyear/showrule',
        player:     "iframe",
        title: "Thể lệ",
        options: {
                       modal:   true
        },
        height:     500,
        width:      800
    });
}
</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=403992816397723";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

  {include file="googleanalytic.tpl"}
    {include file="websocket_external.tpl"}
    {include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>