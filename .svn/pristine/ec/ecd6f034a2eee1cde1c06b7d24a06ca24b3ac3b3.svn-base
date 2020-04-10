<div class="navibarlist">
    <ul>
          <li><a href="{$rooturl}" title="dienmay.com">Trang chủ ››</a></li>
        <li>Tin tức</li>
    </ul>
</div>
<div class="conttitle" style="position:relative"><div class="back"><a href="javascript:history.back()">&#171;Trở về</a></div>Tin tức</div>
<div class="listnews">
   
  <ul>
     {foreach item=news from=$myNews name=mynewss}
          <li> <a href="{$news->getNewsPath()}">
          <h3>{$news->title}</h3>
          <img src="{$news->getSmallImage()}" alt="{$news->title}"> <span>{$news->content|strip_tags|truncate:300}</span> </a> 
        </li>
        {if $smarty.foreach.mynewss.iteration == 2}
          {break}
        {/if}
      {/foreach}
     {foreach item=homenews from=$parentCat}
        {foreach item=homelist from=$homenews->subCat}
            {if $homelist->news|@count > 0}
            <div class="newsbartitle"><span><a href="{$homelist->getNewscategoryPath()}">{$homelist->name}</a></span></div>
          {foreach item=mn from=$homelist->news name=mnnews}
              <li class="li2_img"> <a href="{$mn->getNewsPath()}" title="{$mn->title}"> 
                <div style="width:100px;float: left;">
                  <img src="{$mn->getSmallImage()}" alt="{$mn->title}" title="{$mn->title}" alt="{$mn->title}">

                </div>
                <h3>{$mn->title}</h3>
                  <div class="clear"></div>
                </a> </li>
          {/foreach}
          {/if}
        {/foreach}
    {/foreach}
  </ul>
</div>
<!-- Phân trang -->
<div class="pagination" style="float: right;">
    {assign var="pageurl" value="page=::PAGE::"}
    {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
</div> <!-- End .pagination -->

 <div class="clearfix"></div>
