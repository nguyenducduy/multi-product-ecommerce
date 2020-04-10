<div class="navibarlist">
    <ul>
         <li><a href="{$conf.rooturl}" title="dienmay.com">Trang chủ ››</a> </li>
          <li><a href="{$rooturl}tin-tuc">Tin tức ››</a></li>
        <li>{$myCategory->name}</li>
    </ul>
</div>
<div class="conttitle" style="position:relative"><div class="back"><a href="javascript:history.back()">&#171;Trở về</a></div>{$myCategory->name}</div>
<div class="listnews">
   
  <ul>
     {foreach item=mycat from=$category}
        <div class="newsbartitle"><span><a href="{$mycat->getNewscategoryPath()}">{$mycat->name}</a></span></div>
        {foreach item=mynews from=$mycat->news}
              <li class="li2_img"> <a href="{$mynews->getNewsPath()}" title="{$mynews->title}"> 
                 <div style="width:100px;float: left;"><img src="{$mynews->getSmallImage()}" alt="{$mynews->title}" title="{$mynews->title}" alt="{$mynews->title}">
                 </div>
                <h3>{$mynews->title}</h3>
                </a> </li>
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
