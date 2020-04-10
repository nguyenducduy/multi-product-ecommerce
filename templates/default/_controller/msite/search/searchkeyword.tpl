<div class="navbarprod">
    <ul>
        <li><a title="dienmay.com" href="#">Trang chủ</a> ››</li>
        <li>Kết quả tìm kiếm {$reviewkey}</li>
        <li class="lastitem">Tư vấn mua hàng <span>1900 1883</span> hoặc <span>(08) 39.48.6789</span></li>
    </ul>

</div>
<div id="container">
<!-- list rao vat --><h2 class="titlepage" style="margin-left: 5px">Kết quả tìm kiếm với từ khóa: {$reviewkey}</h2>
    <div class="listresult duy">
        <!--  product template -->
        {if $myProduct|@count > 0}
        <div class="products" id="newlist">
			{if !empty($myProduct)}
				<ul>
					{foreach item=product from=$myProduct name=ProductsByCategory}
						{assign var="promotionprices" value=$product->promotionPrice()}
						<li> 
				  			 {if $product->isbagdehot == 1 || $product->isbagdenew == 1 || $product->isbagdegift == 1}
								<div class="special">
									{if $product->isbagdehot == 1}
										<i class="icon-hot"></i>
									{elseif $product->isbagdenew == 1}
										<i class="icon-new"></i>
									{elseif $product->isbagdegift == 1}
										<i class="icon-gift"></i>
									{/if}									
								</div>
							  {/if}
				  			  <a href="{$product->getProductPath()}" title="{$product->name}" class="imageprod"><img src="{$product->getSmallImage()}" alt="{$product->name}" /> </a>
			                  <a class="position-a" href="{$product->getProductPath()}">{$product->name} </a>
						      <div class="loadprice lp{$product->id}{$product->barcode|trim|substr:-5}" rel="{$product->id}{$product->barcode|trim|substr:-5}">
						      {if $product->displaysellprice!=1 && $product->sellprice>0 && $product->onsitestatus == $OsERP && !empty($promotionprices.price) && $promotionprices.price<$product->sellprice}
				                	<div class="priceold">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
			                    	<div class="pricenew">{if $promotionprices.price > 1000}{$promotionprices.price|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
				                {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
				                	<div class="pricenew">{if $product->prepaidprice > 1000}{$product->prepaidprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
				                {elseif $product->sellprice >0}
				                	<div class="pricenew">{if $product->sellprice > 1000}{$product->sellprice|number_format}{else}{$lang.default.promotionspecial}{/if} đ</div>
				                {/if}
				              </div>
						      
						      {if $product->onsitestatus == $OsERP && $product->instock > 0 && $product->sellprice > 0}							      
							      <!-- <div class="buynownew"></div>
							      <a  href="{$conf.rooturl}cart/checkout/?id={$product->id}{if !empty($promotionprices.promoid)}&prid={$product->barcode|trim}_{$promotionprices.promoid}{/if}" class="textbuynow">Mua</a> -->
							      <!--<div class="salemethod">Chỉ bán online</div>-->
						      {elseif $product->onsitestatus == $OsERPPrepaid && $product->prepaidstartdate <= $currentTime && $product->prepaidenddate >= $currentTime}
						      	<div class="buynownew"></div>
							    <a href="javascript:void(0)" class="textbuynow buyprepaid" rel="{$product->id}" title="Đặt hàng trước">Mua</a>
						      	<div class="salemethod">Đặt hàng trước</div>
						      {elseif $product->onsitestatus == $OsCommingSoon}
			  					<div class="salemethod">Hàng sắp về</div>
							  {else}
						      	<div class="salemethod">Hết hàng</div>
						      {/if}
						      
						      {if !empty($product->listgallery)}
				                <ul class="circlegallery">
				                    {foreach from=$product->listgallery item=lgal}
				                        <li>{$lgal->getSmallImage()}</li>                        
				                    {/foreach}
				                    {if $product->image!=''}
				                    <li>{$product->getSmallImage()}</li>
				                    {else}
				                    <li>{$currentTemplate}images/site/default/default.jpg</li>
				                    {/if}
				                </ul>
				                {/if}
						</li>
					{/foreach}
				</ul>
				{assign var="pageurl" value="page-::PAGE::"}
   				{paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl`/`$pageurl`"}
			{else}
				Danh mục này hiện thời chưa có sản phẩm
			{/if}		  
		</div>
          <div class="pagination" style="float: right;">
             {assign var="pageurl" value="&page=::PAGE::"}
            {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
          </div> <!-- End .pagination -->
        {elseif $myNews|@count > 0}
          {foreach item=news from=$myNews}
            <div class="everyrow">
              <a href="{$news->getNewsPath()}" title="{$news->title}"><img src="{if $news->image != ''}{$news->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$news->title}" /> </a>
                <a href="{$news->getNewsPath()}" title="{$news->title}">{$news->title}</a><span>{$news->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                <p>{$news->content|strip_tags|truncate:155}</p>
            </div>
          {/foreach}
            <div style="">
              <div class="pagination" style="float: right;">
                 {assign var="pageurl" value="&page=::PAGE::"}
                {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
              </div> <!-- End .pagination -->
            </div>
        {elseif $myPage|@count > 0}
          {foreach item=pages from=$myPage}
            <div class="everyrow">
              <a href="{$pages->getPagePath()}" title="{$pages->title}"><img src="{if $pages->image != ''}{$pages->getImage()}{else}{$currentTemplate}images/default.jpg{/if}" alt="{$pages->title}" /> </a>
                <a href="{$pages->getPagePath()}" title="{$pages->title}">{$pages->title}</a><span>{$pages->datecreated|date_format:$lang.default.dateFormatSmarty}</span>
                <p>{$pages->content|truncate:255}</p>
            </div>
          {/foreach}
            <div style="">
              <div class="pagination" style="float: right;">
                 {assign var="pageurl" value="&page=::PAGE::"}
                {paginate count=$totalPage curr=$curPage lang=$paginateLang max=10 url="`$paginateurl``$pageurl`"}
              </div> <!-- End .pagination -->
            </div>
        {/if}


        
    </div>
    <!-- end list rao vat -->
    
     


</div>

  


