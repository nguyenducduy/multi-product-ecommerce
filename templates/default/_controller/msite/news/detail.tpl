<div class="navibarlist">
    <ul>
         <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
          <li><a href="{$conf.rooturl}tin-tuc">Tin tức ››</a></li>
        <li><a href="{$myCategory->getNewscategoryPath()}">{$myCategory->name}</a></li>
    </ul>
</div>
<div class="conttitle" style="position:relative"><div class="back"><a href="javascript:history.back()">&#171;Trở về</a></div>Chi tiết</div>
 <!-- news detail -->
<div class="newsdetail">
    <h1>{$myNews->title}</h1>
    <span>{$myNews->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
    <p>
            {$myNews->content}
        {if preg_match("#^http?://.+#", $myNews->source)}
            <iframe src="{$myNews->getYoutubeLink()}" ></iframe>
        {/if}
    </p>
</div>

<!-- Tin khác -->
<div class="listnews">
    <h2><a href="#">Tin khác</a></h2>
    <ul>
        {foreach item=nsame from=$samenews}
        <li class="li2_img">
            <a href="{$nsame->getNewsPath()}" title="{$nsame->title}">
               <!-- <img src="{$nsame->getSmallImage()}" alt="{$nsame->title}">-->
               
               <h3 style="font-weight:normal;padding-bottom:0">››&nbsp;&nbsp;{$nsame->title}</h3>
            </a>
        </li>
        {/foreach}
    </ul>
</div>