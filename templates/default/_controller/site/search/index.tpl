<!-- <div class="navbarprod">
    <ul>
        <li><a title="dienmay.com" href="#">Trang chủ</a> ››</li>
        <li>Kết quả tìm kiếm {$reviewkey}</li>
        <li class="lastitem">Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></li>
    </ul>
</div> -->
<div class="wrsearch">
	<div class="search-left">
		{if $searchTrendsContent != ""}
    	<ul>
        	<li class="bar-blue"> Xu Hướng Tìm Kiếm</li>
        	{foreach from=$searchTrendsContent item=contentTrend}
            	<li>{strip_tags($contentTrend,'<a>')}</li>
            {/foreach}
        </ul>
         {/if}
        <div class="clear"></div>
        <ul>
        	<li class="bar-blue"> Tìm Kiếm Của Bạn</li>
        	{if !empty($searchforu)}
        		{foreach from=$searchforu item=searchitem name=searchforyou}
        			{if $searchitem != ''}
		            <li {if $smarty.foreach.searchforyou.iteration == 1}class="current"{/if}><span class="icon-del delsearch" rel="{$searchitem|replace:' ':'+'}" style="cursor:pointer;display: block;margin-top:10px" onclick="delsearchforu(this)">×</span><a href="{$registry->conf.rooturl}search?q={$searchitem|lower|replace:' ':'+'}">{$searchitem}</a></li>
		            {/if}
            	{/foreach}
            {/if}
        </ul>
        
    </div>
    
    <div class="search-ct">
    	<div class="barresult duy">
			<ul>
				{if $totalProduct + $totalNews > 0}
	    		<li><span>Có <strong>{$totalProduct + $totalNews}</strong> Kết quả với từ khóa "{$reviewkey}"</span></li>
		        {if $totalProduct > 0}<li><a class="{if $formData.f == '' || $formData.f eq 'productindex'}currents{/if}" href="{$conf.rooturl}search?q={$formData.q}">Sản phẩm ({$totalProduct})</a></li>{/if}
		        {if $totalNews > 0}<li><a class="{if $formData.f eq 'news'}currents{/if}" href="{$conf.rooturl}search?f=news&q={$formData.q}">Tin tức ({$totalNews})</a></li>{/if}
		        {*if $totalStuff >0}<li><a class="{if $formData.f eq 'stuff'}currents{/if}" href="{$conf.rooturl}search?f=stuff&q={$formData.q}"><b>Rao vặt</b> ({$totalStuff})</a></li>{/if*}
		        {else}
		        <li><span>Không có kết quả nào phù hợp với từ khóa tìm kiếm của bạn.</span></li>
		        {/if}
		    </ul>
		</div>
		{if $totalProduct > 0 && $vendorList|@count > 0}
			{assign var=myVendor value=$vendorList[0]}
			{if $myVendor->countproduct > 0}
				<div class="suggest">Có phải bạn định tìm sản phẩm của nhà sản xuất <strong>{$myVendor->name}</strong>?, <a href="{$myVendor->getVendorPath()}">Bấm vào đây để xem &raquo;</a></div>
			{/if}
		 {/if}
		 {if $foundCategoryList|@count > 0}
			{assign var=myCategory value=$foundCategoryList[0]}
			{if $myCategory->countitem > 0}
				<div class="suggest">Có phải bạn định tìm sản phẩm <strong>{$myCategory->name}</strong>?, <a href="{$myCategory->getProductcateoryPath()}">Bấm vào đây để xem &raquo;</a></div>
			{/if}
		 {/if}
    	{if $totalProduct + $totalNews > 0}
    	{if !empty($myProduct)}
        <div class="products">
				
			      <ul>
			       {foreach from=$myProduct item=product name=ProductsByCategory}
            			{assign var="promotionprices" value=$product->promotionPrice()}
							
			      	<li>

			      		{if $searchitemcolorlist[$product->id]|count > 1}           
	                        <div class="lg">
	                            <ul>
	                                {foreach from=$searchitemcolorlist[$product->id] item=productsearchlistcolor name=productsearchlistcolorname}
	                                    {if $productsearchlistcolor[0] > 0}
	                                         {if $smarty.foreach.productsearchlistcolorname.index > 4}{break}{/if}
	                                        <li class="qtooltip"><a class="qtootip" href="{if $productsearchlistcolor[4] == 1}{$product->getProductPath()}{else}{$product->getProductPath()}?color={$productsearchlistcolor[0]}{/if}" title="{$productsearchlistcolor[2]}" style="background:#{$productsearchlistcolor[3]}"></a></li>
	                                    {/if}
	                                {/foreach}
	                            </ul>
	                        </div>                         
	                    {/if}  
			          {if $product->onsitestatus == $OsERPPrepaid}<div class="special"><i class="icon-preorder"></i></div>
	                  {elseif $product->onsitestatus == $OsCommingSoon}<div class="special"><i class="icon-hsapve"></i></div>
	                  {elseif $product->onsitestatus == $OsHot}<div class="special"><i class="icon-hot"></i></div>
	                  {elseif $product->onsitestatus == $OsNew}<div class="special"><i class="icon-new"></i></div>
	                  {elseif $product->onsitestatus == $OsBestSeller}<div class="special"><i class="icon-bestsale"></i></div>
	                  {elseif $product->onsitestatus == $OsCrazySale}<div class="special"><i class="icon-crazydeal"></i></div>
                      {elseif $product->onsitestatus == $OsDoanGia}<div class="special"><i class="icon-betting"></i></div>
	                  {elseif $product->onsitestatus == $OsNoSell || $product->instock == 0}<div class="special"><i class="icon-theend"></i></div>
	                  {/if}    
			          <a href="{$product->getProductPath()}" title="{$product->name|escape}"><img src="{$product->getSmallImage()}" alt="{$product->name|escape}" title="{$product->name|escape}" /> </a> <a class="position-a" href="{$product->getProductPath()}"><h4>{$product->name}</h4>
			          </a>
			          <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
				          {if $product->displaysellprice!=1 && $product->sellprice>0 && ($product->onsitestatus == $OsERP || $product->onsitestatus == $OsHot || $product->onsitestatus == $OsNew || $product->onsitestatus == $OsBestSeller) && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
				           	<div class="priceold price1">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
	                       	<div class="pricenew price2">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
	                       	<span class="salepercent"> -{(($product->sellprice - $promotionprices.price)/$product->sellprice * 100)|floor}%</span>
				   		   {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
	                         <div class="pricenew price2">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
	                       {elseif $product->sellprice >0}
	                         <div class="pricenew price2">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
	                       {/if} 
                       </div>
			        </li>
			        {/foreach}
			      </ul>
			      
			    </div>
    
    	<!-- pagnation -->
        <div class="paginat">
             {assign var="pageurl" value="page-::PAGE::"}
   	{paginateul count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}
        </div>
    </div>
    {elseif $myNews|@count > 0}

          {foreach item=news from=$myNews}
            <!-- <div class="everyrow searchstuff">
              <a href="{$news->getNewsPath()}" title="{$news->title}"><img src="{if $news->image != ''}{$news->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$news->title}" /> </a>
                <a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title}</a><span>{$news->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                <p>{$news->content|strip_tags|truncate:155}</p>
            </div> -->
            <div class="newsresult" style="width: 100%;">
	             <a href="{$news->getNewsPath()}" title="{$news->title}"><img src="{if $news->image != ''}{$news->getSmallImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$news->title}" title="{$news->title}" /></a>
	             <a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title}</a>
	             <p>{$news->content|strip_tags|truncate:155}</p>
	             <div><a href="javascript:void(0)"><i class="icon-usernews"></i>{if $news->uid > 0}{$news->getActorName()}{else}dienmay.com{/if}</a> |</div>
	             <div><i class="icon-calenda"></i> {$news->datecreated|date_format:$lang.default.dateFormatSmarty} &nbsp; &nbsp; |</div>
	             <div><a href="{$news->getNewscategorypath()}">{$news->getNewscategoryname()}</a></div>
       		</div>
          {/foreach}
        
          <div class="pagination" style="float: right;">
             {assign var="pageurl" value="&page=::PAGE::"}
            {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
          </div>
    {/if}
    {/if}
</div>



