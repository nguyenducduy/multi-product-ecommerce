<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#"
	xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{if $pageTitle != ''}{$pageTitle}{else}{$setting.site.defaultPageTitle}{/if}</title>
<meta name="keywords"
	content="{$pageKeyword|default:$setting.site.defaultPageKeyword|escapequote}" />
<meta name="description"
	content="{$pageDescription|default:$setting.site.defaultPageDescription|escapequote}" />
<meta name="robots"
	content="{if !empty($pageMetarobots)}{$pageMetarobots}{else}index, follow{/if}" />

<meta property="og:site_name" content="{$conf.rooturl}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{$conf.rooturl}year-in-review" />
<meta property="og:image"
	content="http://dienmay.myhost/pimages/Khuyen-mai/Event/noel/ava-yeu-tinh.jpg" />
<meta property="og:title" content="YEAR IN REVIEW -  AI NHANH MẮT HƠN" />
<meta property="og:description"
	content="Hãy cùng chơi game tìm số điểm khác nhau vô cùng vui nhộn để có cơ hội dành lấy smartphone Gionee E6 từ 23/12 đến 30/12/2013" />



<link type="text/css" rel="stylesheet"
	href="{$currentTemplate}/min/?g=css&ver={$setting.site.cssversion}"
	media="screen" />
<script type="text/javascript" src="{$currentTemplate}js/jquery.js"></script>

<script type="text/javascript">
		var rooturl = "{$conf.rooturl}";
		var rooturl_profile = "{$conf.rooturl_profile}";
</script>
</head>
<body style="width: 100%">
<div class="row_yt_top">
<div class="wrap_yt">
<div class="title_yt"></div>
<!-- collum left -->
<div class="left_yt">
<div class="rowgen">
<div class="namepro_yt"></div>
<div class="namepro_yt_2"><a target="_blank" href="{$conf.rooturl}hop-qua-may-man"></a></div>
</div>
<div class="rowgen"><!-- Đăng nhập fb, google+ --> {if
empty($user_profile)}
<div class="dn_play_yt"><span>Đăng nhập để chơi ngay</span>
<div class="yt_dn_fa"><a title="Đăng nhập bằng tài khoản Facebook"
	href="{$conf.rooturl}gamefasteye/loginfacebook"></a></div>
<div class="yt_dn_go"><a title="Đăng nhập bằng tài khoản Google"
	href="{$conf.rooturl}gamefasteye/logingoogle"></a></div>
</div>
{else} <!-- Thông tin user -->
<div class="info_user_yt">
<div class="info_user_yt_1"><img src="{$user_profile->avatar}" /> <span>{$user_profile->fullname}</span>
<strong>{$user_profile->point} điểm</strong> <span>Bạn có <b>{$user_profile->countplay}</b>
lượt chơi</span></div>
<div class="shareuser_yt">
<div class="btnshare_yt"><a id="sharelink" href="#pop_yt_wrap">Mời bạn
bè</a></div>
<span>để có thêm lượt chơi</span></div>
</div>
{/if} <!-- like fb and share -->
<div class="yt_social">
<div class="yt_like"></div>
<div class="yt_bt_fa"><a target="_blank"
	href="https://www.facebook.com/sharer/sharer.php?u={$conf.rooturl}year-in-review?invitor={$userid_share}"></a></div>
<div class="yt_bt_go"><a target="_blank"
	href="https://plus.google.com/share?url={$conf.rooturl}year-in-review?invitor={$userid_share}"></a></div>
</div>
</div>
<div class="box_gift_yt"><img
	src="{$currentTemplate}images/site/qua-tang.png" /> 
	
	<div class="thgi_yt"><a {if !empty($user_profile)}id="startgame" {/if} rel="{$gamefasteye->id}" data-id="{$gamefasteye->time}" href="javascript:void(0);" title="Tham gia ngay"></a></div>

<div class="thle_yt"><a id="thele" href="#pop_yt_thele">Xem thể lệ »</a></div>
</div>
</div>
<!-- collum riht -->
<div class="right_yt">
<div class="yt_1"></div>
<div class="yt_2"></div>
<span>Danh sách người chơi</span>
<ul>
	{foreach item="userjoin" from="$listuserjoin"}
	<li>{$userjoin->fullname}<strong style="font-weight: normal;">{Helper::time_ago($userjoin->datecreated)}
	trước</strong></li>
	{/foreach}


</ul>
<span>Những người cao điểm nhất</span>
<ul>
	{foreach item="userpoint" from="$listuserpoint"}
	<li>{$userpoint->fullname}<strong>{$userpoint->point} điểm</strong></li>
	{/foreach}

</ul>
<span>Danh sách chia sẻ</span>
<ul>
	{foreach item="usershare" from="$listusershare"}
	<li>{$usershare->fullname}<strong>{$usershare->countshare} bạn</strong></li>
	{/foreach}

</ul>
<span></span>

<ul>
	<li style="text-align: center;font-size: 12px;font-weight: bold;">Số lượt đã tham gia
	<div style="font-size: 20px;font-weight: bold">{$totaluser*3}<div></div></div></li>

</ul>
</div>
</div>
</div>
<div id="wrapyt_ask_bar" class="wrapyt_ask_bar"></div>
<input id="questiontoken" type="hidden" name="ftoken" value="{$smarty.session.QuestionToken}" />

<div class="fter_yt">

</div>
<h1 class="titlecomment">Cảm nhận và chia sẻ về game Ai tinh mắt hơn?</h1>
<div id="commentgame">

</div>
<div style="display: none">
<div class="pop_yt_share" id="pop_yt_wrap">
<div class="pop_yt_wrap">
<form action="" method="get"><input class="yt_emfone" name=""
	type="text"
	value="{$conf.rooturl}year-in-review?invitor={$userid_share}" /> <input
	class="yt_nhtin" name="" type="button" value="Copy" /></form>
<div class="clear"></div>
<span>Share trên</span>
<div class="yt_dn_fa"><a target="_blank"
	href="https://www.facebook.com/sharer/sharer.php?u={$conf.rooturl}year-in-review?invitor={$userid_share}"></a></div>
<div class="yt_dn_go"><a target="_blank"
	href="https://plus.google.com/share?url={$conf.rooturl}year-in-review?invitor={$userid_share}"></a></div>
<div class="clear"></div>
<p>Khi mời thành công bạn sẽ có thêm 1 lượt chơi</p>
</div>
</div>
<div style="display: none">
<div class="pop_yt_thele" id="pop_yt_thele">
<div class="pop_yt_wrap_thele">{$gamefasteye->rule}</div>
</div>
</div>
<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=403992816397723";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="{$currentTemplate}/min/?g=js&ver={$setting.site.jsversion}"></script>
<script type="text/javascript" >
$(document).ready(function(){
      $('#commentgame').html('<div class="fb-comments" width="980" data-href="{$conf.rooturl}year-in-review" data-numposts="5" data-colorscheme="light"></div>');
      $('.yt_like').html('<iframe src="http://www.facebook.com/plugins/like.php?href=https://www.facebook.com/dienmaycom&width=120&height=21&colorscheme=light&layout=button_count&action=like&show_faces=true&send=false" scrolling="no" frameborder="0" allowTransparency="true" class="likepage"></iframe>');
       {literal}
       var  message="";function clickIE() {if (document.all) {(message);return   false;}}function clickNS(e) {if   (document.layers||(document.getElementById&&!document.all)) {if   (e.which==2||e.which==3) {(message);return false;}}}if  (document.layers)   {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;document.onselectstart=clickIE}document.oncontextmenu=new   Function("return false")
       {/literal}
});
</script>
    {include file="googleanalytic.tpl"}
    {include file="websocket_external.tpl"}
    {include file="`$smartyControllerGroupContainer`../analytic.tpl"}
</body>
</html>